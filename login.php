<?php

declare(strict_types=1);

require_once __DIR__ . '/auth.php';
require_once __DIR__ . '/db_config.php';

/** @var PDO $pdo */

$errors = [];

if (isLoggedIn()) {
    header('Location: admin.php');
    exit;
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $csrfToken = $_POST['csrf_token'] ?? '';
    if (!validateCsrfToken((string) $csrfToken)) {
        $errors[] = 'Neplatný bezpečnostný token. Obnovte stránku a skúste to znova.';
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
        // Účtový limit sa počíta iba vtedy, keď IP limit ešte nie je vyčerpaný.
        // Inak by útočník z jedinej IP mohol po zablokovaní vlastnej IP donekonečna
        // zadarmo navyšovať účtové počítadlo a trvale uzamknúť cudzí účet.
        // Prah 20 je zámerne vyšší než 10 pokusov, ktoré jedna IP zvládne za rovnaké
        // okno, takže samotná jedna IP účet nikdy neuzamkne.
        $accountAllowed = !$ipAllowed
            || $accountRateKey === null
            || checkFormRateLimit($pdo, 'login_account', $accountRateKey, 20, 900);

        if (!$ipAllowed || !$accountAllowed) {
            $errors[] = 'Príliš veľa pokusov o prihlásenie. Skúste to znova neskôr.';
        } else {
            $stmt = $pdo->prepare("SELECT id, username, email, password_hash, is_admin, is_active FROM users WHERE username = :username LIMIT 1");
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
                $errors[] = 'Neplatné prihlasovacie meno alebo heslo.';
            } else {
                if (password_needs_rehash((string) $user['password_hash'], PASSWORD_BCRYPT, appPasswordHashOptions())) {
                    try {
                        // Hashuje sa presne tá hodnota, ktorá prešla overením.
                        $newHash = hashAppPassword($verifiedPassword);
                        $rehash = $pdo->prepare("UPDATE users SET password_hash = :password_hash WHERE id = :id");
                        $rehash->execute([':password_hash' => $newHash, ':id' => (int) $user['id']]);
                    } catch (\Throwable $rehashError) {
                        // Rehash je best-effort. Staré heslo nemusí spĺňať dnešné pravidlá
                        // a bcrypt odmieta napríklad NUL bajt (\ValueError), no prihlásenie
                        // už bolo úspešné — nesmie ho zhodiť fatálna chyba.
                        error_log('Rehash hesla zlyhal: ' . $rehashError->getMessage());
                    }
                }
                clearFormRateLimit($pdo, 'login_attempt', $ip);
                if ($accountRateKey !== null) {
                    clearFormRateLimit($pdo, 'login_account', $accountRateKey);
                }
                regenerateSession();
                $_SESSION['user_id'] = (int) $user['id'];
                $_SESSION['username'] = (string) $user['username'];
                $_SESSION['email'] = (string) $user['email'];
                $_SESSION['is_admin'] = (int) $user['is_admin'];
                $_SESSION['_last_activity'] = time();
                $_SESSION['_account_checked'] = time();
                header('Location: admin.php');
                exit;
            }
        }
    }
}

$baseUrl = getAppBaseUrl();
$pageTitle = 'Prihlásenie | MUDr. Ľubomír Polaščín';
$seoDescription = 'Prihlásenie administrátora na Polascin.net.';
$robotsMeta = 'noindex, nofollow';
$canonicalUrl = $baseUrl . '/login.php';
?>
<!DOCTYPE html>
<html lang="sk">
<head>
<?php include __DIR__ . '/head_meta.php'; ?>
</head>
<body>
<?php include __DIR__ . '/header.php'; ?>
<main id="main-content" tabindex="-1" aria-label="Prihlásenie">
  <section class="auth-section">
    <div class="container auth-container">
      <h1>Prihlásenie administrátora</h1>
      <?php foreach ($errors as $error): ?>
        <div class="alert alert-error"><p><?= htmlspecialchars($error, ENT_QUOTES, 'UTF-8') ?></p></div>
      <?php endforeach; ?>
      <form method="post" action="login.php" class="login-form" novalidate>
        <input type="hidden" name="csrf_token" value="<?= htmlspecialchars(generateCsrfToken(), ENT_QUOTES, 'UTF-8') ?>">
        <div class="form-group">
          <label for="username">Prihlasovacie meno</label>
          <input type="text" id="username" name="username" required maxlength="255" autocomplete="username" autocapitalize="none" spellcheck="false" autofocus>
        </div>
        <div class="form-group">
          <label for="password">Heslo</label>
          <input type="password" id="password" name="password" required maxlength="<?= APP_PASSWORD_MAX_BYTES ?>" autocomplete="current-password">
        </div>
        <button type="submit" class="btn btn-primary">Prihlásiť sa</button>
      </form>
    </div>
  </section>
</main>
<?php include __DIR__ . '/footer.php'; ?>
</body>
</html>
