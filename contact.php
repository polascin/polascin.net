<?php

declare(strict_types=1);

require_once __DIR__ . '/auth.php';
require_once __DIR__ . '/db_config.php';
require_once __DIR__ . '/helpers.php';

/** @var PDO $pdo */

$errors = [];
$formData = ['name' => '', 'email' => '', 'subject' => '', 'message' => ''];
$redirectWithNeutralSuccess = static function (): never {
    setFlashMessage('success', t('contact.success'));
    header('Location: contact.php', true, 303);
    exit;
};

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if (!isTrustedStateChangingRequest()) {
        http_response_code(403);
        $errors[] = t('error.csrf');
    }
    $csrfToken = $_POST['csrf_token'] ?? '';
    if (empty($errors) && !validateCsrfToken($csrfToken)) {
        http_response_code(400);
        $errors[] = t('error.csrf');
    } elseif (empty($errors)) {
        $isLikelyBot = trim((string) ($_POST['website'] ?? '')) !== ''
            || !consumeTimedFormProof('contact', $_POST['form_proof'] ?? null, 2, 7200);
        if ($isLikelyBot) {
            $redirectWithNeutralSuccess();
        }

        $name = trim((string) ($_POST['name'] ?? ''));
        $email = trim((string) ($_POST['email'] ?? ''));
        $subject = trim((string) ($_POST['subject'] ?? ''));
        $message = trim(str_replace(["\r\n", "\r"], "\n", (string) ($_POST['message'] ?? '')));
        $formData = compact('name', 'email', 'subject', 'message');

        if (appTextLength($name) < 2 || appTextLength($name) > 255 || containsDisallowedControlCharacters($name)) {
            $errors[] = t('contact.error_name');
        }
        if (!filter_var($email, FILTER_VALIDATE_EMAIL) || appTextLength($email) > 255) {
            $errors[] = t('contact.error_email');
        }
        if (($subject !== '' && appTextLength($subject) > 255) || containsDisallowedControlCharacters($subject)) {
            $errors[] = t('contact.error_subject');
        }
        if (appTextLength($message) < 20 || appTextLength($message) > 5000 || containsDisallowedControlCharacters($message)) {
            $errors[] = t('contact.error_message');
        }

        // Limity sa počítajú až po syntaktickej validácii. Pseudokľúče sú
        // jednosmerné hashe, takže pomocná tabuľka neuchováva ďalšiu kópiu e-mailu.
        $ip = getClientIpAddress();
        if (empty($errors) && !checkFormRateLimit($pdo, 'contact_form', $ip, 3, 3600)) {
            $errors[] = t('contact.error_rate_limit');
        }
        if (empty($errors) && !checkFormRateLimit($pdo, 'contact_global', 'global', 30, 3600)) {
            $errors[] = t('contact.error_rate_limit');
        }
        if (empty($errors) && !isEmailDomainValid($email)) {
            $errors[] = t('contact.error_email');
        }
        $senderKey = 'mail:' . substr(hash('sha256', strtolower($email)), 0, 40);
        if (empty($errors) && !checkFormRateLimit($pdo, 'contact_sender', $senderKey, 3, 86400)) {
            $errors[] = t('contact.error_rate_limit');
        }
        if ($errors !== [] && in_array(t('contact.error_rate_limit'), $errors, true)) {
            http_response_code(429);
            header('Retry-After: 3600');
        }

        if (empty($errors)) {
            $deduplicatedMessage = preg_replace('/\s+/u', ' ', $message) ?? $message;
            $duplicateKey = 'msg:' . substr(hash('sha256', strtolower($email) . "\0" . $subject . "\0" . $deduplicatedMessage), 0, 40);
            if (!checkFormRateLimit($pdo, 'contact_duplicate', $duplicateKey, 1, 86400)) {
                $redirectWithNeutralSuccess();
            }
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
                clearFormRateLimit($pdo, 'contact_duplicate', $duplicateKey);
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
$formProof = generateTimedFormProof('contact');
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

      <form method="post" action="<?= htmlspecialchars(langUrl($lang, 'contact.php'), ENT_QUOTES, 'UTF-8') ?>" class="contact-form" data-submit-once novalidate>
        <input type="hidden" name="csrf_token" value="<?= htmlspecialchars(generateCsrfToken(), ENT_QUOTES, 'UTF-8') ?>">
        <input type="hidden" name="form_proof" value="<?= htmlspecialchars($formProof, ENT_QUOTES, 'UTF-8') ?>">
        <div class="contact-form-trap" aria-hidden="true">
          <label for="contact-website">Website</label>
          <input type="text" id="contact-website" name="website" value="" tabindex="-1" autocomplete="off">
        </div>
        <div class="form-group">
          <label for="name"><?= te('contact.name') ?> <span aria-label="<?= te('common.required') ?>">*</span></label>
          <input type="text" id="name" name="name" value="<?= htmlspecialchars($formData['name'], ENT_QUOTES, 'UTF-8') ?>" autocomplete="name" required minlength="2" maxlength="255">
        </div>
        <div class="form-group">
          <label for="email"><?= te('contact.email') ?> <span aria-label="<?= te('common.required') ?>">*</span></label>
          <input type="email" id="email" name="email" value="<?= htmlspecialchars($formData['email'], ENT_QUOTES, 'UTF-8') ?>" autocomplete="email" inputmode="email" required maxlength="255">
        </div>
        <div class="form-group">
          <label for="subject"><?= te('contact.subject') ?></label>
          <input type="text" id="subject" name="subject" value="<?= htmlspecialchars($formData['subject'], ENT_QUOTES, 'UTF-8') ?>" maxlength="255">
        </div>
        <div class="form-group">
          <label for="message"><?= te('contact.message') ?> <span aria-label="<?= te('common.required') ?>">*</span></label>
          <textarea id="message" name="message" rows="6" required minlength="20" maxlength="5000"><?= htmlspecialchars($formData['message'], ENT_QUOTES, 'UTF-8') ?></textarea>
        </div>
        <button type="submit" class="btn btn-primary"><?= te('contact.submit') ?></button>
      </form>
    </div>
  </section>
</main>
<?php include __DIR__ . '/footer.php'; ?>
</body>
</html>
