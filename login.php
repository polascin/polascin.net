<?php

declare(strict_types=1);

require_once __DIR__ . '/auth.php';
require_once __DIR__ . '/db_config.php';

/** @var PDO $pdo */

$errors = [];
$totpRequired = false;

if (isLoggedIn()) {
    header('Location: admin.php', true, 303);
    exit;
}

// 2FA krok: overenie TOTP kódu po úspešnom overení hesla
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_SESSION['totp_pending_user_id'])) {
    $csrfToken = $_POST['csrf_token'] ?? '';
    $trustedOrigin = isTrustedStateChangingRequest();
    if (!$trustedOrigin || !validateCsrfToken((string) $csrfToken)) {
        http_response_code(400);
        $errors[] = t('error.csrf');
        logCsrfFailure('login_totp', $trustedOrigin, $csrfToken);
        unset($_SESSION['totp_pending_user_id']);
    } else {
        $totpCode = trim((string) ($_POST['totp_code'] ?? ''));
        $pendingUserId = (int) $_SESSION['totp_pending_user_id'];
        $ip = getClientIpAddress();

        if (!checkFormRateLimit($pdo, 'login_totp', $ip, 5, 900)) {
            http_response_code(429);
            header('Retry-After: 900');
            $errors[] = t('login.error_rate_limit');
        } elseif (!preg_match('/^[0-9]{6}$/', $totpCode)) {
            http_response_code(401);
            $errors[] = t('login.error_totp_invalid');
        } else {
            $stmt = $pdo->prepare("SELECT id, username, email, password_hash, is_admin, is_active, must_change_password, totp_secret, totp_last_used FROM users WHERE id = :id LIMIT 1");
            $stmt->execute([':id' => $pendingUserId]);
            $user = $stmt->fetch();

            if (
                !is_array($user)
                || (int) ($user['is_active'] ?? 0) !== 1
                || (string) ($user['totp_secret'] ?? '') === ''
                || !verifyTotpCode((string) $user['totp_secret'], $totpCode)
            ) {
                // Neaktívny účet aj zlý kód hlásime rovnako, aby sa neodlišovali.
                if (is_array($user) && (int) ($user['is_active'] ?? 0) !== 1) {
                    unset($_SESSION['totp_pending_user_id']);
                }
                http_response_code(401);
                $errors[] = t('login.error_totp_invalid');
            } else {
                // Kontrola replay útoku - rovnaký kód nesmie byť použitý dvakrát
                $lastUsed = (int) ($user['totp_last_used'] ?? 0);
                $currentPeriod = intdiv(time(), 30);
                if ($lastUsed >= $currentPeriod - 1) {
                    http_response_code(401);
                    $errors[] = t('login.error_totp_reused');
                } else {
                    // Najprv obnoviť ID relácie. Až potom stamplovať totp_last_used
                    // a zrušiť pending: pri zlyhaní regenerateSession() by inak
                    // platný kód zhorel a pending by zmizol (~60 s výpadok).
                    if (!regenerateSession()) {
                        http_response_code(503);
                        error_log('Po overení TOTP sa nepodarilo obnoviť ID relácie.');
                        $errors[] = t('login.error_credentials');
                    } else {
                        $pdo->prepare("UPDATE users SET totp_last_used = :period WHERE id = :id")
                            ->execute([':period' => $currentPeriod, ':id' => $pendingUserId]);

                        clearFormRateLimit($pdo, 'login_totp', $ip);
                        clearFormRateLimit($pdo, 'login_attempt', $ip);
                        $accountRateKey = 'usr:' . substr(
                            hash('sha256', strtolower((string) $user['username'])),
                            0,
                            40
                        );
                        clearFormRateLimit($pdo, 'login_account', $accountRateKey);
                        unset($_SESSION['totp_pending_user_id']);

                        $now = time();
                        $_SESSION['user_id'] = (int) $user['id'];
                        $_SESSION['username'] = (string) $user['username'];
                        $_SESSION['email'] = (string) $user['email'];
                        $_SESSION['is_admin'] = (int) $user['is_admin'];
                        $_SESSION['must_change_password'] = (int) ($user['must_change_password'] ?? 0);
                        $_SESSION['_credential_fingerprint'] = passwordHashFingerprint((string) $user['password_hash']);
                        $_SESSION['_session_started_at'] = $now;
                        $_SESSION['_session_rotated_at'] = $now;
                        $_SESSION['_last_activity'] = $now;
                        $_SESSION['_account_checked'] = $now;
                        logAdminAction($pdo, 'login_success_2fa', 'session');
                        $destination = !empty($_SESSION['must_change_password'])
                            ? 'admin_users.php?change_required=1'
                            : 'admin.php';
                        header('Location: ' . $destination, true, 303);
                        exit;
                    }
                }
            }
        }
    }
}

if ($_SERVER['REQUEST_METHOD'] === 'POST' && !isset($_SESSION['totp_pending_user_id'])) {
    $csrfToken = $_POST['csrf_token'] ?? '';
    $trustedOrigin = isTrustedStateChangingRequest();
    if (!$trustedOrigin || !validateCsrfToken((string) $csrfToken)) {
        http_response_code(400);
        $errors[] = t('error.csrf');
        logCsrfFailure('login', $trustedOrigin, $csrfToken);
    } else {
        $username = trim((string) ($_POST['username'] ?? ''));
        $password = (string) ($_POST['password'] ?? '');

        $credentialsHaveValidLength = $username !== ''
            && appTextLength($username) <= 255
            && strlen($password) <= APP_PASSWORD_MAX_BYTES;
        $ip = getClientIpAddress();
        $accountRateKey = $username === ''
            ? null
            : 'usr:' . substr(hash('sha256', strtolower($username)), 0, 40);
        $ipAllowed = checkFormRateLimit($pdo, 'login_attempt', $ip, 10, 900);
        $accountAllowed = !$ipAllowed
            || $accountRateKey === null
            || checkFormRateLimit($pdo, 'login_account', $accountRateKey, 20, 900);

        if (!$ipAllowed || !$accountAllowed) {
            http_response_code(429);
            header('Retry-After: 900');
            $errors[] = t('login.error_rate_limit');
        } else {
            $stmt = $pdo->prepare("SELECT id, username, email, password_hash, is_admin, is_active, must_change_password, totp_enabled, totp_secret FROM users WHERE username = :username LIMIT 1");
            $stmt->execute([':username' => appTextSlice($username, 0, 255)]);
            $user = $stmt->fetch();

            $candidateHash = is_array($user) && (int) $user['is_active'] === 1
                ? (string) $user['password_hash']
                : APP_DUMMY_PASSWORD_HASH;
            $verifiedPassword = strlen($password) <= APP_PASSWORD_MAX_BYTES
                ? $password
                : substr($password, 0, APP_PASSWORD_MAX_BYTES);
            $passwordMatches = password_verify($verifiedPassword, $candidateHash);

            if (!$credentialsHaveValidLength || !is_array($user) || (int) $user['is_active'] !== 1 || !$passwordMatches) {
                http_response_code(401);
                $errors[] = t('login.error_credentials');
            } else {
                // 2FA len keď je zapnuté a secret je vyplnený. Samotný totp_enabled=1
                // bez secretu by inak zablokoval prihlásenie na TOTP formulári.
                $totpArmed = (int) ($user['totp_enabled'] ?? 0) === 1
                    && (string) ($user['totp_secret'] ?? '') !== '';
                if ($totpArmed) {
                    // Po overení hesla obnoviť ID relácie skôr, než sa do nej
                    // uloží totp_pending_user_id (ochrana pred session fixation).
                    if (!regenerateSession()) {
                        http_response_code(503);
                        error_log('Po overení hesla pred 2FA sa nepodarilo obnoviť ID relácie.');
                        $errors[] = t('login.error_credentials');
                    } else {
                        $_SESSION['totp_pending_user_id'] = (int) $user['id'];
                        $totpRequired = true;
                    }
                } else {
                    $authenticatedPasswordHash = (string) $user['password_hash'];
                    if (password_needs_rehash((string) $user['password_hash'], PASSWORD_BCRYPT, appPasswordHashOptions())) {
                        try {
                            $newHash = hashAppPassword($verifiedPassword);
                            $rehash = $pdo->prepare("UPDATE users SET password_hash = :password_hash WHERE id = :id");
                            $rehash->execute([':password_hash' => $newHash, ':id' => (int) $user['id']]);
                            $authenticatedPasswordHash = $newHash;
                        } catch (\Throwable $rehashError) {
                            error_log('Rehash hesla zlyhal: ' . $rehashError->getMessage());
                        }
                    }
                    clearFormRateLimit($pdo, 'login_attempt', $ip);
                    if ($accountRateKey !== null) {
                        clearFormRateLimit($pdo, 'login_account', $accountRateKey);
                    }
                    if (!regenerateSession()) {
                        http_response_code(503);
                        error_log('Po úspešnom overení hesla sa nepodarilo obnoviť ID relácie.');
                        $errors[] = t('login.error_credentials');
                    } else {
                        $now = time();
                        $_SESSION['user_id'] = (int) $user['id'];
                        $_SESSION['username'] = (string) $user['username'];
                        $_SESSION['email'] = (string) $user['email'];
                        $_SESSION['is_admin'] = (int) $user['is_admin'];
                        $_SESSION['must_change_password'] = (int) ($user['must_change_password'] ?? 0);
                        $_SESSION['_credential_fingerprint'] = passwordHashFingerprint($authenticatedPasswordHash);
                        $_SESSION['_session_started_at'] = $now;
                        $_SESSION['_session_rotated_at'] = $now;
                        $_SESSION['_last_activity'] = $now;
                        $_SESSION['_account_checked'] = $now;
                        logAdminAction($pdo, 'login_success', 'session');
                        $destination = !empty($_SESSION['must_change_password'])
                            ? 'admin_users.php?change_required=1'
                            : 'admin.php';
                        header('Location: ' . $destination, true, 303);
                        exit;
                    }
                }
            }
        }
    }
}

$baseUrl = getAppBaseUrl();
$lang = currentLang();
$pageTitle = t('meta.login_title') . ' | ' . t('common.author');
$seoDescription = t('meta.login_description');
$robotsMeta = 'noindex, nofollow';
$canonicalUrl = absoluteLangUrl($lang, 'login.php');
?>
<!DOCTYPE html>
<html lang="<?= htmlspecialchars($lang, ENT_QUOTES, 'UTF-8') ?>">
<head>
<?php include __DIR__ . '/head_meta.php'; ?>
</head>
<body>
<?php include __DIR__ . '/header.php'; ?>
<main id="main-content" tabindex="-1" aria-label="<?= te('login.aria_label') ?>">
  <section class="auth-section">
    <div class="container auth-container">
      <h1><?= te('login.heading') ?></h1>
      <?php foreach ($errors as $error): ?>
        <div class="alert alert-error"><p><?= htmlspecialchars($error, ENT_QUOTES, 'UTF-8') ?></p></div>
      <?php endforeach; ?>
      <?php if ($totpRequired || isset($_SESSION['totp_pending_user_id'])): ?>
      <form method="post" action="<?= htmlspecialchars(langUrl($lang, 'login.php'), ENT_QUOTES, 'UTF-8') ?>" class="login-form" novalidate>
        <input type="hidden" name="csrf_token" value="<?= htmlspecialchars(generateCsrfToken(), ENT_QUOTES, 'UTF-8') ?>">
        <p><?= te('login.totp_prompt') ?></p>
        <div class="form-group">
          <label for="totp_code"><?= te('login.totp_code') ?></label>
          <input type="text" id="totp_code" name="totp_code" required maxlength="6" pattern="[0-9]{6}" inputmode="numeric" autocomplete="one-time-code" autocapitalize="none" spellcheck="false" autofocus>
        </div>
        <button type="submit" class="btn btn-primary"><?= te('login.totp_submit') ?></button>
      </form>
      <?php else: ?>
      <form method="post" action="<?= htmlspecialchars(langUrl($lang, 'login.php'), ENT_QUOTES, 'UTF-8') ?>" class="login-form" novalidate>
        <input type="hidden" name="csrf_token" value="<?= htmlspecialchars(generateCsrfToken(), ENT_QUOTES, 'UTF-8') ?>">
        <div class="form-group">
          <label for="username"><?= te('login.username') ?></label>
          <input type="text" id="username" name="username" required maxlength="255" autocomplete="username" autocapitalize="none" spellcheck="false" autofocus>
        </div>
        <div class="form-group">
          <label for="password"><?= te('login.password') ?></label>
          <input type="password" id="password" name="password" required maxlength="<?= APP_PASSWORD_MAX_BYTES ?>" autocomplete="current-password">
        </div>
        <button type="submit" class="btn btn-primary"><?= te('login.submit') ?></button>
      </form>
      <?php endif; ?>
    </div>
  </section>
</main>
<?php include __DIR__ . '/footer.php'; ?>
</body>
</html>
