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
        $errors[] = 'Neplatný bezpečnostný token. Obnovte stránku a skúste to znova.';
    } else {
        $name = trim((string) ($_POST['name'] ?? ''));
        $email = trim((string) ($_POST['email'] ?? ''));
        $subject = trim((string) ($_POST['subject'] ?? ''));
        $message = trim((string) ($_POST['message'] ?? ''));
        $formData = compact('name', 'email', 'subject', 'message');

        if ($name === '' || mb_strlen($name) > 255) {
            $errors[] = 'Prosím, zadajte platné meno.';
        }
        if (!filter_var($email, FILTER_VALIDATE_EMAIL) || mb_strlen($email) > 255) {
            $errors[] = 'Prosím, zadajte platnú e-mailovú adresu.';
        }
        if ($subject !== '' && mb_strlen($subject) > 255) {
            $errors[] = 'Predmet je príliš dlhý.';
        }
        if ($message === '' || mb_strlen($message) > 5000) {
            $errors[] = 'Prosím, zadajte správu (max 5000 znakov).';
        }

        $ip = getClientIpAddress();
        if (!checkFormRateLimit($pdo, 'contact_form', $ip, 5, 3600)) {
            $errors[] = 'Príliš veľa správ z tejto adresy. Skúste to znova neskôr.';
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
                $errors[] = 'Nepodarilo sa odoslať správu. Skúste to znova neskôr.';
            }
        }
    }
}

$baseUrl = getAppBaseUrl();
$pageTitle = 'Kontakt | MUDr. Ľubomír Polaščin';
$seoDescription = 'Kontaktujte MUDr. Ľubomíra Polaščina pre profesionálne otázky, spoluprácu alebo dotazy.';
$canonicalUrl = $baseUrl . '/contact.php';
?>
<!DOCTYPE html>
<html lang="sk">
<head>
<?php include __DIR__ . '/head_meta.php'; ?>
</head>
<body>
<?php include __DIR__ . '/header.php'; ?>
<main id="main-content" tabindex="-1" aria-label="Kontaktný formulár">
  <section class="contact-section">
    <div class="container">
      <h1 class="section-title reveal">Kontakt</h1>
      <?php if ($success): ?>
        <div class="alert alert-success"><p>Ďakujeme za vašu správu. Ozveme sa vám čoskoro.</p></div>
      <?php endif; ?>
      <?php foreach ($errors as $error): ?>
        <div class="alert alert-error"><p><?= htmlspecialchars($error, ENT_QUOTES, 'UTF-8') ?></p></div>
      <?php endforeach; ?>

      <form method="post" action="contact.php" class="contact-form" novalidate>
        <input type="hidden" name="csrf_token" value="<?= htmlspecialchars(generateCsrfToken(), ENT_QUOTES, 'UTF-8') ?>">
        <div class="form-group">
          <label for="name">Meno <span aria-label="povinné">*</span></label>
          <input type="text" id="name" name="name" value="<?= htmlspecialchars($formData['name'], ENT_QUOTES, 'UTF-8') ?>" required maxlength="255">
        </div>
        <div class="form-group">
          <label for="email">E-mail <span aria-label="povinné">*</span></label>
          <input type="email" id="email" name="email" value="<?= htmlspecialchars($formData['email'], ENT_QUOTES, 'UTF-8') ?>" required maxlength="255">
        </div>
        <div class="form-group">
          <label for="subject">Predmet</label>
          <input type="text" id="subject" name="subject" value="<?= htmlspecialchars($formData['subject'], ENT_QUOTES, 'UTF-8') ?>" maxlength="255">
        </div>
        <div class="form-group">
          <label for="message">Správa <span aria-label="povinné">*</span></label>
          <textarea id="message" name="message" rows="6" required maxlength="5000"><?= htmlspecialchars($formData['message'], ENT_QUOTES, 'UTF-8') ?></textarea>
        </div>
        <button type="submit" class="btn btn-primary">Odoslať správu</button>
      </form>
    </div>
  </section>
</main>
<?php include __DIR__ . '/footer.php'; ?>
</body>
</html>
