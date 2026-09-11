<?php

declare(strict_types=1);

require_once __DIR__ . '/auth.php';
require_once __DIR__ . '/db_config.php';
requireAdmin();

/** @var PDO $pdo */

$passwordErrors = [];
$createErrors = [];
$newAdminEmail = '';
$mustChangePassword = !empty($_SESSION['must_change_password']);
$currentAdminId = (int) $_SESSION['user_id'];

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $action = (string) ($_POST['action'] ?? '');
    if (!isTrustedStateChangingRequest()) {
        http_response_code(403);
        $passwordErrors[] = 'Požiadavka nepochádza z dôveryhodnej stránky.';
    } elseif (!validateCsrfToken($_POST['csrf_token'] ?? null)) {
        http_response_code(400);
        $passwordErrors[] = 'Platnosť formulára vypršala. Obnovte stránku a skúste to znova.';
    } elseif ($mustChangePassword && $action !== 'change_password') {
        http_response_code(403);
        $passwordErrors[] = 'Pred ďalšou správou stránky si musíte zmeniť dočasné heslo.';
    } elseif ($action === 'change_password') {
        $currentPassword = (string) ($_POST['current_password'] ?? '');
        $newPassword = (string) ($_POST['new_password'] ?? '');
        $newPasswordConfirmation = (string) ($_POST['new_password_confirmation'] ?? '');

        if (strlen($currentPassword) > APP_PASSWORD_MAX_BYTES || $currentPassword === '') {
            $passwordErrors[] = 'Aktuálne heslo nie je správne.';
        }
        if (!isAppPasswordValid($newPassword)) {
            $passwordErrors[] = 'Nové heslo musí mať 12 až 72 bajtov a obsahovať malé písmeno, veľké písmeno a číslicu.';
        }
        if (!hash_equals($newPassword, $newPasswordConfirmation)) {
            $passwordErrors[] = 'Potvrdenie nového hesla sa nezhoduje.';
        }

        $rateKey = 'usr:' . substr(hash('sha256', (string) $currentAdminId), 0, 40);
        if ($passwordErrors === [] && !checkFormRateLimit($pdo, 'admin_password_change', $rateKey, 5, 900)) {
            http_response_code(429);
            header('Retry-After: 900');
            $passwordErrors[] = 'Príliš veľa pokusov. Skúste to znova o 15 minút.';
        }

        if ($passwordErrors === []) {
            $stmt = $pdo->prepare("SELECT password_hash FROM users WHERE id = :id AND is_admin = 1 AND is_active = 1 LIMIT 1");
            $stmt->execute([':id' => $currentAdminId]);
            $currentHash = $stmt->fetchColumn();
            if (!is_string($currentHash) || !password_verify($currentPassword, $currentHash)) {
                http_response_code(401);
                $passwordErrors[] = 'Aktuálne heslo nie je správne.';
            } elseif (password_verify($newPassword, $currentHash)) {
                $passwordErrors[] = 'Nové heslo musí byť odlišné od aktuálneho hesla.';
            } else {
                try {
                    $newHash = hashAppPassword($newPassword);
                    $pdo->beginTransaction();
                    $update = $pdo->prepare(
                        "UPDATE users
                         SET password_hash = :new_hash, must_change_password = 0
                         WHERE id = :id AND password_hash = :current_hash AND is_admin = 1 AND is_active = 1"
                    );
                    $update->execute([
                        ':new_hash' => $newHash,
                        ':id' => $currentAdminId,
                        ':current_hash' => $currentHash,
                    ]);
                    if ($update->rowCount() !== 1 || !logAdminAction($pdo, 'admin_password_change', 'user', $currentAdminId)) {
                        throw new RuntimeException('Zmenu hesla sa nepodarilo zapísať spolu s auditom.');
                    }
                    $pdo->commit();

                    clearFormRateLimit($pdo, 'admin_password_change', $rateKey);
                    $_SESSION['_credential_fingerprint'] = passwordHashFingerprint($newHash);
                    $_SESSION['must_change_password'] = 0;
                    $_SESSION['_account_checked'] = time();
                    if (!regenerateSession()) {
                        restartAnonymousSession();
                        setFlashMessage('info', 'Heslo bolo zmenené. Prihláste sa novým heslom.');
                        header('Location: login.php', true, 303);
                        exit;
                    }
                    $_SESSION['_session_rotated_at'] = time();
                    setFlashMessage('success', 'Heslo bolo bezpečne zmenené. Ostatné relácie budú zneplatnené.');
                    header('Location: admin_users.php', true, 303);
                    exit;
                } catch (Throwable $e) {
                    if ($pdo->inTransaction()) {
                        $pdo->rollBack();
                    }
                    error_log('Zmena administrátorského hesla zlyhala: ' . $e->getMessage());
                    $passwordErrors[] = 'Heslo sa nepodarilo zmeniť. Skúste to znova.';
                }
            }
        }
    } elseif ($action === 'create_admin') {
        $newAdminEmail = strtolower(trim((string) ($_POST['email'] ?? '')));
        $authorizingPassword = (string) ($_POST['authorizing_password'] ?? '');
        $initialPassword = (string) ($_POST['initial_password'] ?? '');
        $initialPasswordConfirmation = (string) ($_POST['initial_password_confirmation'] ?? '');

        if (!filter_var($newAdminEmail, FILTER_VALIDATE_EMAIL) || appTextLength($newAdminEmail) > 255) {
            $createErrors[] = 'Zadajte platnú e-mailovú adresu nového administrátora.';
        }
        if ($authorizingPassword === '' || strlen($authorizingPassword) > APP_PASSWORD_MAX_BYTES) {
            $createErrors[] = 'Vaše aktuálne heslo nie je správne.';
        }
        if (!isAppPasswordValid($initialPassword)) {
            $createErrors[] = 'Dočasné heslo musí mať 12 až 72 bajtov a obsahovať malé písmeno, veľké písmeno a číslicu.';
        }
        if (!hash_equals($initialPassword, $initialPasswordConfirmation)) {
            $createErrors[] = 'Potvrdenie dočasného hesla sa nezhoduje.';
        }

        $rateKey = 'usr:' . substr(hash('sha256', (string) $currentAdminId), 0, 40);
        if ($createErrors === [] && !checkFormRateLimit($pdo, 'admin_user_create', $rateKey, 5, 900)) {
            http_response_code(429);
            header('Retry-After: 900');
            $createErrors[] = 'Príliš veľa pokusov. Skúste to znova o 15 minút.';
        }

        if ($createErrors === []) {
            $stmt = $pdo->prepare("SELECT password_hash FROM users WHERE id = :id AND is_admin = 1 AND is_active = 1 LIMIT 1");
            $stmt->execute([':id' => $currentAdminId]);
            $currentHash = $stmt->fetchColumn();
            if (!is_string($currentHash) || !password_verify($authorizingPassword, $currentHash)) {
                http_response_code(401);
                $createErrors[] = 'Vaše aktuálne heslo nie je správne.';
            } else {
                try {
                    $initialHash = hashAppPassword($initialPassword);
                    $pdo->beginTransaction();
                    $insert = $pdo->prepare(
                        "INSERT INTO users (username, email, password_hash, is_admin, is_active, must_change_password)
                         VALUES (:username, :email, :password_hash, 1, 1, 1)"
                    );
                    $insert->execute([
                        ':username' => $newAdminEmail,
                        ':email' => $newAdminEmail,
                        ':password_hash' => $initialHash,
                    ]);
                    $newAdminId = (int) $pdo->lastInsertId();
                    if ($newAdminId < 1 || !logAdminAction($pdo, 'admin_user_create', 'user', $newAdminId)) {
                        throw new RuntimeException('Nový účet sa nepodarilo zapísať spolu s auditom.');
                    }
                    $pdo->commit();

                    clearFormRateLimit($pdo, 'admin_user_create', $rateKey);
                    setFlashMessage('success', 'Administrátor bol pridaný. Pri prvom prihlásení musí zmeniť dočasné heslo.');
                    header('Location: admin_users.php', true, 303);
                    exit;
                } catch (PDOException $e) {
                    if ($pdo->inTransaction()) {
                        $pdo->rollBack();
                    }
                    if ((string) $e->getCode() === '23000') {
                        $createErrors[] = 'Účet s touto e-mailovou adresou už existuje.';
                    } else {
                        error_log('Vytvorenie administrátora zlyhalo: ' . $e->getMessage());
                        $createErrors[] = 'Administrátora sa nepodarilo pridať. Skúste to znova.';
                    }
                } catch (Throwable $e) {
                    if ($pdo->inTransaction()) {
                        $pdo->rollBack();
                    }
                    error_log('Vytvorenie administrátora zlyhalo: ' . $e->getMessage());
                    $createErrors[] = 'Administrátora sa nepodarilo pridať. Skúste to znova.';
                }
            }
        }
    } else {
        http_response_code(400);
        $passwordErrors[] = 'Neznáma administrátorská operácia.';
    }
}

$admins = $pdo->query(
    "SELECT id, email, is_active, must_change_password, created_at
     FROM users
     WHERE is_admin = 1
     ORDER BY created_at ASC, id ASC"
)->fetchAll();

$baseUrl = getAppBaseUrl();
$pageTitle = 'Administrátori | MUDr. Ľubomír Polaščín';
$seoDescription = 'Správa administrátorov stránky Polascin.net.';
$robotsMeta = 'noindex, nofollow';
$canonicalUrl = $baseUrl . '/admin_users.php';
?>
<!DOCTYPE html>
<html lang="sk">
<head>
<?php include __DIR__ . '/head_meta.php'; ?>
</head>
<body>
<?php include __DIR__ . '/header.php'; ?>
<main id="main-content" tabindex="-1" aria-label="Správa administrátorov">
  <section class="admin-section">
    <div class="container">
      <h1>Administrátori</h1>
      <?php if (!$mustChangePassword): ?>
        <p><a href="admin.php" class="btn btn-secondary btn-sm">Späť na panel</a></p>
      <?php else: ?>
        <div class="alert alert-error"><p>Pred pokračovaním si zmeňte dočasné heslo.</p></div>
      <?php endif; ?>

      <h2>Zmeniť moje heslo</h2>
      <?php foreach ($passwordErrors as $error): ?>
        <div class="alert alert-error"><p><?= htmlspecialchars($error, ENT_QUOTES, 'UTF-8') ?></p></div>
      <?php endforeach; ?>
      <form method="post" action="admin_users.php" class="admin-form" data-submit-once novalidate>
        <input type="hidden" name="csrf_token" value="<?= htmlspecialchars(generateCsrfToken(), ENT_QUOTES, 'UTF-8') ?>">
        <input type="hidden" name="action" value="change_password">
        <div class="form-group">
          <label for="current-password">Aktuálne heslo</label>
          <input type="password" id="current-password" name="current_password" required maxlength="<?= APP_PASSWORD_MAX_BYTES ?>" autocomplete="current-password">
        </div>
        <div class="form-group">
          <label for="new-password">Nové heslo</label>
          <input type="password" id="new-password" name="new_password" required minlength="<?= APP_PASSWORD_MIN_BYTES ?>" maxlength="<?= APP_PASSWORD_MAX_BYTES ?>" autocomplete="new-password" aria-describedby="password-rules">
          <small id="password-rules" class="form-hint">12 až 72 bajtov, aspoň jedno malé písmeno, veľké písmeno a číslica.</small>
        </div>
        <div class="form-group">
          <label for="new-password-confirmation">Potvrdenie nového hesla</label>
          <input type="password" id="new-password-confirmation" name="new_password_confirmation" required minlength="<?= APP_PASSWORD_MIN_BYTES ?>" maxlength="<?= APP_PASSWORD_MAX_BYTES ?>" autocomplete="new-password">
        </div>
        <button type="submit" class="btn btn-primary">Zmeniť heslo</button>
      </form>

      <?php if (!$mustChangePassword): ?>
        <h2>Pridať administrátora</h2>
        <?php foreach ($createErrors as $error): ?>
          <div class="alert alert-error"><p><?= htmlspecialchars($error, ENT_QUOTES, 'UTF-8') ?></p></div>
        <?php endforeach; ?>
        <form method="post" action="admin_users.php" class="admin-form" data-submit-once novalidate>
          <input type="hidden" name="csrf_token" value="<?= htmlspecialchars(generateCsrfToken(), ENT_QUOTES, 'UTF-8') ?>">
          <input type="hidden" name="action" value="create_admin">
          <div class="form-group">
            <label for="admin-email">E-mail nového administrátora</label>
            <input type="email" id="admin-email" name="email" value="<?= htmlspecialchars($newAdminEmail, ENT_QUOTES, 'UTF-8') ?>" required maxlength="255" autocomplete="off" autocapitalize="none" spellcheck="false">
          </div>
          <div class="form-group">
            <label for="initial-password">Dočasné heslo</label>
            <input type="password" id="initial-password" name="initial_password" required minlength="<?= APP_PASSWORD_MIN_BYTES ?>" maxlength="<?= APP_PASSWORD_MAX_BYTES ?>" autocomplete="new-password" aria-describedby="initial-password-rules">
            <small id="initial-password-rules" class="form-hint">Nový administrátor ho musí pri prvom prihlásení zmeniť.</small>
          </div>
          <div class="form-group">
            <label for="initial-password-confirmation">Potvrdenie dočasného hesla</label>
            <input type="password" id="initial-password-confirmation" name="initial_password_confirmation" required minlength="<?= APP_PASSWORD_MIN_BYTES ?>" maxlength="<?= APP_PASSWORD_MAX_BYTES ?>" autocomplete="new-password">
          </div>
          <div class="form-group">
            <label for="authorizing-password">Vaše aktuálne heslo na potvrdenie oprávnenia</label>
            <input type="password" id="authorizing-password" name="authorizing_password" required maxlength="<?= APP_PASSWORD_MAX_BYTES ?>" autocomplete="current-password">
          </div>
          <button type="submit" class="btn btn-primary">Pridať administrátora</button>
        </form>

        <h2>Existujúci administrátori</h2>
        <div class="table-responsive">
          <table class="admin-table admin-table-wrap">
            <thead>
              <tr><th scope="col">E-mail</th><th scope="col">Stav</th><th scope="col">Vytvorený</th></tr>
            </thead>
            <tbody>
              <?php foreach ($admins as $admin): ?>
                <tr>
                  <td><?= htmlspecialchars((string) $admin['email'], ENT_QUOTES, 'UTF-8') ?><?= (int) $admin['id'] === $currentAdminId ? ' (vy)' : '' ?></td>
                  <td>
                    <?= (int) $admin['is_active'] === 1 ? 'Aktívny' : 'Neaktívny' ?>
                    <?= (int) $admin['must_change_password'] === 1 ? ' – čaká na zmenu hesla' : '' ?>
                  </td>
                  <td><?= htmlspecialchars((string) $admin['created_at'], ENT_QUOTES, 'UTF-8') ?></td>
                </tr>
              <?php endforeach; ?>
            </tbody>
          </table>
        </div>
      <?php endif; ?>
    </div>
  </section>
</main>
<?php include __DIR__ . '/footer.php'; ?>
</body>
</html>
