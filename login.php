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
        $errors[] = 'Invalid security token. Please refresh the page and try again.';
    } else {
        $username = trim((string) ($_POST['username'] ?? ''));
        $password = (string) ($_POST['password'] ?? '');

        $ip = getClientIpAddress();
        if (!checkFormRateLimit($pdo, 'login_attempt', $ip, 10, 900)) {
            $errors[] = 'Too many login attempts. Please try again later.';
        } else {
            $stmt = $pdo->prepare("SELECT id, username, email, password_hash, is_admin, is_active FROM users WHERE username = :username LIMIT 1");
            $stmt->execute([':username' => $username]);
            $user = $stmt->fetch();

            if (!$user || (int) $user['is_active'] !== 1 || !password_verify($password, (string) $user['password_hash'])) {
                $errors[] = 'Invalid username or password.';
                // constant-time mitigation via dummy verify
                password_verify($password, APP_DUMMY_PASSWORD_HASH);
            } else {
                regenerateSession();
                $_SESSION['user_id'] = (int) $user['id'];
                $_SESSION['username'] = (string) $user['username'];
                $_SESSION['email'] = (string) $user['email'];
                $_SESSION['is_admin'] = (int) $user['is_admin'];
                $_SESSION['_last_activity'] = time();
                header('Location: admin.php');
                exit;
            }
        }
    }
}

$baseUrl = getAppBaseUrl();
$pageTitle = 'Login | Dr. Lubomir Polascin';
$seoDescription = 'Administrator login for Polascin.net.';
$robotsMeta = 'noindex, nofollow';
$canonicalUrl = $baseUrl . '/login.php';
?>
<!DOCTYPE html>
<html lang="en">
<head>
<?php include __DIR__ . '/head_meta.php'; ?>
</head>
<body>
<?php include __DIR__ . '/header.php'; ?>
<main id="main-content" tabindex="-1" aria-label="Login">
  <section class="auth-section">
    <div class="container auth-container">
      <h1>Admin Login</h1>
      <?php foreach ($errors as $error): ?>
        <div class="alert alert-error"><p><?= htmlspecialchars($error, ENT_QUOTES, 'UTF-8') ?></p></div>
      <?php endforeach; ?>
      <form method="post" action="login.php" class="login-form" novalidate>
        <input type="hidden" name="csrf_token" value="<?= htmlspecialchars(generateCsrfToken(), ENT_QUOTES, 'UTF-8') ?>">
        <div class="form-group">
          <label for="username">Username</label>
          <input type="text" id="username" name="username" required autocomplete="username" autofocus>
        </div>
        <div class="form-group">
          <label for="password">Password</label>
          <input type="password" id="password" name="password" required autocomplete="current-password">
        </div>
        <button type="submit" class="btn btn-primary">Login</button>
      </form>
    </div>
  </section>
</main>
<?php include __DIR__ . '/footer.php'; ?>
</body>
</html>
