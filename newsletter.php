<?php

declare(strict_types=1);

require_once __DIR__ . '/auth.php';
require_once __DIR__ . '/db_config.php';
require_once __DIR__ . '/helpers.php';

/** @var PDO $pdo */

$action = $_GET['action'] ?? '';
$token = isset($_GET['token']) ? trim((string) $_GET['token']) : '';
$message = '';
$messageType = 'info';

function hashToken(string $token): string {
    return hash('sha256', $token);
}

if ($action === 'confirm' && $token !== '') {
    $hash = hashToken($token);
    try {
        $stmt = $pdo->prepare("UPDATE newsletter_subscribers SET is_confirmed = 1, confirm_token_hash = NULL, confirmed_at = NOW() WHERE confirm_token_hash = :hash LIMIT 1");
        $stmt->execute([':hash' => $hash]);
        if ($stmt->rowCount() > 0) {
            $message = 'Your subscription has been confirmed. Thank you!';
            $messageType = 'success';
        } else {
            $message = 'Confirmation link is invalid or already used.';
            $messageType = 'error';
        }
    } catch (\PDOException $e) {
        error_log('newsletter confirm error: ' . $e->getMessage());
        $message = 'An error occurred. Please try again later.';
        $messageType = 'error';
    }
} elseif ($action === 'unsubscribe' && $token !== '') {
    $hash = hashToken($token);
    try {
        $stmt = $pdo->prepare("DELETE FROM newsletter_subscribers WHERE unsubscribe_token_hash = :hash LIMIT 1");
        $stmt->execute([':hash' => $hash]);
        if ($stmt->rowCount() > 0) {
            $message = 'You have been unsubscribed successfully.';
            $messageType = 'success';
        } else {
            $message = 'Unsubscribe link is invalid or already used.';
            $messageType = 'error';
        }
    } catch (\PDOException $e) {
        error_log('newsletter unsubscribe error: ' . $e->getMessage());
        $message = 'An error occurred. Please try again later.';
        $messageType = 'error';
    }
}

$errors = [];
$email = '';
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $csrfToken = $_POST['csrf_token'] ?? '';
    if (!validateCsrfToken((string) $csrfToken)) {
        $errors[] = 'Invalid security token. Please refresh the page and try again.';
    } else {
        $email = trim((string) ($_POST['email'] ?? ''));
        if (!filter_var($email, FILTER_VALIDATE_EMAIL) || mb_strlen($email) > 255) {
            $errors[] = 'Please enter a valid email address.';
        } elseif (!isEmailDomainValid($email)) {
            $errors[] = 'The email domain does not appear to be valid.';
        }

        $ip = getClientIpAddress();
        if (empty($errors) && !checkFormRateLimit($pdo, 'newsletter_subscribe', $ip, 5, 3600)) {
            $errors[] = 'Too many subscription attempts. Please try again later.';
        }

        if (empty($errors)) {
            $confirmToken = bin2hex(random_bytes(24));
            $unsubscribeToken = bin2hex(random_bytes(24));
            try {
                $stmt = $pdo->prepare(
                    "INSERT INTO newsletter_subscribers (email, is_confirmed, confirm_token_hash, unsubscribe_token_hash)
                     VALUES (:email, 1, :confirm_hash, :unsubscribe_hash)
                     ON DUPLICATE KEY UPDATE
                         unsubscribe_token_hash = VALUES(unsubscribe_token_hash)"
                );
                $stmt->execute([
                    ':email' => $email,
                    ':confirm_hash' => hashToken($confirmToken),
                    ':unsubscribe_hash' => hashToken($unsubscribeToken),
                ]);
                $message = 'Thank you for subscribing! You can unsubscribe at any time using the link in our emails.';
                $messageType = 'success';
                $email = '';
            } catch (\PDOException $e) {
                error_log('newsletter subscribe error: ' . $e->getMessage());
                $errors[] = 'An error occurred. Please try again later.';
            }
        }
    }
}

$baseUrl = getAppBaseUrl();
$pageTitle = 'Newsletter | Dr. Lubomir Polascin';
$seoDescription = 'Subscribe to the Polascin.net newsletter for updates on nephrology, internal medicine, books and technology.';
$robotsMeta = 'noindex, follow';
$canonicalUrl = $baseUrl . '/newsletter.php';
?>
<!DOCTYPE html>
<html lang="en">
<head>
<?php include __DIR__ . '/head_meta.php'; ?>
</head>
<body>
<?php include __DIR__ . '/header.php'; ?>
<main id="main-content" tabindex="-1" aria-label="Newsletter subscription">
  <section class="newsletter-section">
    <div class="container">
      <h1 class="section-title reveal">Newsletter</h1>
      <?php if ($message !== ''): ?>
        <div class="alert alert-<?= htmlspecialchars($messageType, ENT_QUOTES, 'UTF-8') ?>"><p><?= htmlspecialchars($message, ENT_QUOTES, 'UTF-8') ?></p></div>
      <?php endif; ?>
      <?php foreach ($errors as $error): ?>
        <div class="alert alert-error"><p><?= htmlspecialchars($error, ENT_QUOTES, 'UTF-8') ?></p></div>
      <?php endforeach; ?>

      <?php if ($action === ''): ?>
        <p>Subscribe to receive updates on articles, books, and projects.</p>
        <form method="post" action="newsletter.php" class="newsletter-form" novalidate>
          <input type="hidden" name="csrf_token" value="<?= htmlspecialchars(generateCsrfToken(), ENT_QUOTES, 'UTF-8') ?>">
          <div class="form-group">
            <label for="email">Email address <span aria-label="required">*</span></label>
            <input type="email" id="email" name="email" value="<?= htmlspecialchars($email, ENT_QUOTES, 'UTF-8') ?>" required maxlength="255">
          </div>
          <button type="submit" class="btn btn-primary">Subscribe</button>
        </form>
      <?php endif; ?>
    </div>
  </section>
</main>
<?php include __DIR__ . '/footer.php'; ?>
</body>
</html>
