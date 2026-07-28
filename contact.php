<?php

declare(strict_types=1);

require_once __DIR__ . '/auth.php';
require_once __DIR__ . '/db_config.php';
require_once __DIR__ . '/helpers.php';

/** @var PDO $pdo */

$errors = [];
$success = false;
$formData = ['name' => '', 'email' => '', 'subject' => '', 'message' => ''];

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $csrfToken = $_POST['csrf_token'] ?? '';
    if (!validateCsrfToken((string) $csrfToken)) {
        $errors[] = 'Invalid security token. Please refresh the page and try again.';
    } else {
        $name = trim((string) ($_POST['name'] ?? ''));
        $email = trim((string) ($_POST['email'] ?? ''));
        $subject = trim((string) ($_POST['subject'] ?? ''));
        $message = trim((string) ($_POST['message'] ?? ''));
        $formData = compact('name', 'email', 'subject', 'message');

        if ($name === '' || mb_strlen($name) > 255) {
            $errors[] = 'Please enter a valid name.';
        }
        if (!filter_var($email, FILTER_VALIDATE_EMAIL) || mb_strlen($email) > 255) {
            $errors[] = 'Please enter a valid email address.';
        }
        if ($subject !== '' && mb_strlen($subject) > 255) {
            $errors[] = 'Subject is too long.';
        }
        if ($message === '' || mb_strlen($message) > 5000) {
            $errors[] = 'Please enter a message (max 5000 characters).';
        }

        $ip = getClientIpAddress();
        if (!checkFormRateLimit($pdo, 'contact_form', $ip, 5, 3600)) {
            $errors[] = 'Too many messages from this address. Please try again later.';
        }

        if (empty($errors)) {
            try {
                $stmt = $pdo->prepare(
                    "INSERT INTO contact_messages (name, email, subject, message)
                     VALUES (:name, :email, :subject, :message)"
                );
                $stmt->execute([
                    ':name' => $name,
                    ':email' => $email,
                    ':subject' => $subject ?: null,
                    ':message' => $message,
                ]);
                $success = true;
                $formData = ['name' => '', 'email' => '', 'subject' => '', 'message' => ''];
            } catch (\PDOException $e) {
                error_log('contact.php insert error: ' . $e->getMessage());
                $errors[] = 'Failed to send message. Please try again later.';
            }
        }
    }
}

$baseUrl = getAppBaseUrl();
$pageTitle = 'Contact | Dr. Lubomir Polascin';
$seoDescription = 'Contact Dr. Lubomir Polascin for professional inquiries, collaboration or questions.';
$canonicalUrl = $baseUrl . '/contact.php';
?>
<!DOCTYPE html>
<html lang="en">
<head>
<?php include __DIR__ . '/head_meta.php'; ?>
</head>
<body>
<?php include __DIR__ . '/header.php'; ?>
<main id="main-content" tabindex="-1" aria-label="Contact form">
  <section class="contact-section">
    <div class="container">
      <h1 class="section-title reveal">Contact</h1>
      <?php if ($success): ?>
        <div class="alert alert-success"><p>Thank you for your message. We will get back to you soon.</p></div>
      <?php endif; ?>
      <?php foreach ($errors as $error): ?>
        <div class="alert alert-error"><p><?= htmlspecialchars($error, ENT_QUOTES, 'UTF-8') ?></p></div>
      <?php endforeach; ?>

      <form method="post" action="contact.php" class="contact-form" novalidate>
        <input type="hidden" name="csrf_token" value="<?= htmlspecialchars(generateCsrfToken(), ENT_QUOTES, 'UTF-8') ?>">
        <div class="form-group">
          <label for="name">Name <span aria-label="required">*</span></label>
          <input type="text" id="name" name="name" value="<?= htmlspecialchars($formData['name'], ENT_QUOTES, 'UTF-8') ?>" required maxlength="255">
        </div>
        <div class="form-group">
          <label for="email">Email <span aria-label="required">*</span></label>
          <input type="email" id="email" name="email" value="<?= htmlspecialchars($formData['email'], ENT_QUOTES, 'UTF-8') ?>" required maxlength="255">
        </div>
        <div class="form-group">
          <label for="subject">Subject</label>
          <input type="text" id="subject" name="subject" value="<?= htmlspecialchars($formData['subject'], ENT_QUOTES, 'UTF-8') ?>" maxlength="255">
        </div>
        <div class="form-group">
          <label for="message">Message <span aria-label="required">*</span></label>
          <textarea id="message" name="message" rows="6" required maxlength="5000"><?= htmlspecialchars($formData['message'], ENT_QUOTES, 'UTF-8') ?></textarea>
        </div>
        <button type="submit" class="btn btn-primary">Send Message</button>
      </form>
    </div>
  </section>
</main>
<?php include __DIR__ . '/footer.php'; ?>
</body>
</html>
