<?php

declare(strict_types=1);

require_once __DIR__ . '/auth.php';
require_once __DIR__ . '/db_config.php';
require_once __DIR__ . '/helpers.php';

/** @var PDO $pdo */

$errors = [];
$formData = ['name' => '', 'email' => '', 'subject' => '', 'message' => ''];

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $csrfToken = $_POST['csrf_token'] ?? '';
    if (!validateCsrfToken((string) $csrfToken)) {
        $errors[] = t('error.csrf');
    } else {
        $name = trim((string) ($_POST['name'] ?? ''));
        $email = trim((string) ($_POST['email'] ?? ''));
        $subject = trim((string) ($_POST['subject'] ?? ''));
        $message = trim((string) ($_POST['message'] ?? ''));
        $formData = compact('name', 'email', 'subject', 'message');

        if ($name === '' || appTextLength($name) > 255) {
            $errors[] = t('contact.error_name');
        }
        if (!filter_var($email, FILTER_VALIDATE_EMAIL) || appTextLength($email) > 255) {
            $errors[] = t('contact.error_email');
        }
        if ($subject !== '' && appTextLength($subject) > 255) {
            $errors[] = t('contact.error_subject');
        }
        if ($message === '' || appTextLength($message) > 5000) {
            $errors[] = t('contact.error_message');
        }

        // Limit sa počíta až po validácii, aby preklep vo formulári nespotreboval
        // pokus a nezablokoval odosielateľa na hodinu s mätúcou hláškou.
        $ip = getClientIpAddress();
        if (empty($errors) && !checkFormRateLimit($pdo, 'contact_form', $ip, 5, 3600)) {
            $errors[] = t('contact.error_rate_limit');
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
                setFlashMessage('success', t('contact.success'));
                header('Location: contact.php', true, 303);
                exit;
            } catch (\PDOException $e) {
                error_log('contact.php insert error: ' . $e->getMessage());
                $errors[] = t('contact.error_save');
            }
        }
    }
}

$baseUrl = getAppBaseUrl();
$lang = currentLang();
$pageTitle = t('meta.contact_title') . ' | ' . t('common.author');
$seoDescription = t('meta.contact_description');
$canonicalUrl = absoluteLangUrl($lang, 'contact.php');
?>
<!DOCTYPE html>
<html lang="<?= htmlspecialchars($lang, ENT_QUOTES, 'UTF-8') ?>">
<head>
<?php include __DIR__ . '/head_meta.php'; ?>
</head>
<body>
<?php include __DIR__ . '/header.php'; ?>
<main id="main-content" tabindex="-1" aria-label="<?= te('contact.aria_label') ?>">
  <section class="contact-section">
    <div class="container">
      <h1 class="section-title reveal"><?= te('contact.heading') ?></h1>
      <?php foreach ($errors as $error): ?>
        <div class="alert alert-error"><p><?= htmlspecialchars($error, ENT_QUOTES, 'UTF-8') ?></p></div>
      <?php endforeach; ?>

      <form method="post" action="<?= htmlspecialchars(langUrl($lang, 'contact.php'), ENT_QUOTES, 'UTF-8') ?>" class="contact-form" novalidate>
        <input type="hidden" name="csrf_token" value="<?= htmlspecialchars(generateCsrfToken(), ENT_QUOTES, 'UTF-8') ?>">
        <div class="form-group">
          <label for="name"><?= te('contact.name') ?> <span aria-label="<?= te('common.required') ?>">*</span></label>
          <input type="text" id="name" name="name" value="<?= htmlspecialchars($formData['name'], ENT_QUOTES, 'UTF-8') ?>" required maxlength="255">
        </div>
        <div class="form-group">
          <label for="email"><?= te('contact.email') ?> <span aria-label="<?= te('common.required') ?>">*</span></label>
          <input type="email" id="email" name="email" value="<?= htmlspecialchars($formData['email'], ENT_QUOTES, 'UTF-8') ?>" required maxlength="255">
        </div>
        <div class="form-group">
          <label for="subject"><?= te('contact.subject') ?></label>
          <input type="text" id="subject" name="subject" value="<?= htmlspecialchars($formData['subject'], ENT_QUOTES, 'UTF-8') ?>" maxlength="255">
        </div>
        <div class="form-group">
          <label for="message"><?= te('contact.message') ?> <span aria-label="<?= te('common.required') ?>">*</span></label>
          <textarea id="message" name="message" rows="6" required maxlength="5000"><?= htmlspecialchars($formData['message'], ENT_QUOTES, 'UTF-8') ?></textarea>
        </div>
        <button type="submit" class="btn btn-primary"><?= te('contact.submit') ?></button>
      </form>
    </div>
  </section>
</main>
<?php include __DIR__ . '/footer.php'; ?>
</body>
</html>
