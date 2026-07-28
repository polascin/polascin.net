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

$ip = getClientIpAddress();

if ($action === 'confirm' && $token !== '') {
    if (!checkFormRateLimit($pdo, 'newsletter_confirm', $ip, 10, 3600)) {
        $message = 'Príliš veľa pokusov o potvrdenie. Skúste to znova neskôr.';
        $messageType = 'error';
    } else {
        $hash = hashToken($token);
        try {
            $stmt = $pdo->prepare("UPDATE newsletter_subscribers SET is_confirmed = 1, confirm_token_hash = NULL, confirmed_at = NOW() WHERE confirm_token_hash = :hash LIMIT 1");
            $stmt->execute([':hash' => $hash]);
            if ($stmt->rowCount() > 0) {
                $message = 'Vaše predplatné bolo potvrdené. Ďakujeme!';
                $messageType = 'success';
            } else {
                $message = 'Potvrdzovací odkaz je neplatný alebo už bol použitý.';
                $messageType = 'error';
            }
        } catch (\PDOException $e) {
            error_log('newsletter confirm error: ' . $e->getMessage());
            $message = 'Vyskytla sa chyba. Skúste to znova neskôr.';
            $messageType = 'error';
        }
    }
} elseif ($action === 'unsubscribe' && $token !== '') {
    if (!checkFormRateLimit($pdo, 'newsletter_unsubscribe', $ip, 10, 3600)) {
        $message = 'Príliš veľa pokusov o odhlásenie. Skúste to znova neskôr.';
        $messageType = 'error';
    } else {
        $hash = hashToken($token);
        try {
            $stmt = $pdo->prepare("DELETE FROM newsletter_subscribers WHERE unsubscribe_token_hash = :hash LIMIT 1");
            $stmt->execute([':hash' => $hash]);
            if ($stmt->rowCount() > 0) {
                $message = 'Boli ste úspešne odhlásení z odberu.';
                $messageType = 'success';
            } else {
                $message = 'Odkaz na odhlásenie je neplatný alebo už bol použitý.';
                $messageType = 'error';
            }
        } catch (\PDOException $e) {
            error_log('newsletter unsubscribe error: ' . $e->getMessage());
            $message = 'Vyskytla sa chyba. Skúste to znova neskôr.';
            $messageType = 'error';
        }
    }
}

$errors = [];
$email = '';
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $csrfToken = $_POST['csrf_token'] ?? '';
    if (!validateCsrfToken((string) $csrfToken)) {
        $errors[] = 'Neplatný bezpečnostný token. Obnovte stránku a skúste to znova.';
    } else {
        $email = trim((string) ($_POST['email'] ?? ''));
        if (!filter_var($email, FILTER_VALIDATE_EMAIL) || mb_strlen($email) > 255) {
            $errors[] = 'Prosím, zadajte platnú e-mailovú adresu.';
        } elseif (!isEmailDomainValid($email)) {
            $errors[] = 'Doména e-mailovej adresy sa nezdá byť platná.';
        }

        $ip = getClientIpAddress();
        if (empty($errors) && !checkFormRateLimit($pdo, 'newsletter_subscribe', $ip, 5, 3600)) {
            $errors[] = 'Príliš veľa pokusov o prihlásenie na odber. Skúste to znova neskôr.';
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
                $message = 'Ďakujeme za prihlásenie na odber! Odhlásiť sa môžete kedykoľvek pomocou odkazu v našich e-mailoch.';
                $messageType = 'success';
                $email = '';
            } catch (\PDOException $e) {
                error_log('newsletter subscribe error: ' . $e->getMessage());
                $errors[] = 'Vyskytla sa chyba. Skúste to znova neskôr.';
            }
        }
    }
}

$baseUrl = getAppBaseUrl();
$pageTitle = 'Newsletter | MUDr. Ľubomír Polaščín';
$seoDescription = 'Prihláste sa na odber noviniek z Polascin.net — aktuality o nefrológii, internej medicíne, knihách a technológiách.';
$robotsMeta = 'noindex, follow';
$canonicalUrl = $baseUrl . '/newsletter.php';
?>
<!DOCTYPE html>
<html lang="sk">
<head>
<?php include __DIR__ . '/head_meta.php'; ?>
</head>
<body>
<?php include __DIR__ . '/header.php'; ?>
<main id="main-content" tabindex="-1" aria-label="Prihlásenie na odber noviniek">
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
        <p>Prihláste sa na odber aktualít o článkoch, knihách a projektoch.</p>
        <form method="post" action="newsletter.php" class="newsletter-form" novalidate>
          <input type="hidden" name="csrf_token" value="<?= htmlspecialchars(generateCsrfToken(), ENT_QUOTES, 'UTF-8') ?>">
          <div class="form-group">
            <label for="email">E-mailová adresa <span aria-label="povinné">*</span></label>
            <input type="email" id="email" name="email" value="<?= htmlspecialchars($email, ENT_QUOTES, 'UTF-8') ?>" required maxlength="255">
          </div>
          <button type="submit" class="btn btn-primary">Odoberať</button>
        </form>
      <?php endif; ?>
    </div>
  </section>
</main>
<?php include __DIR__ . '/footer.php'; ?>
</body>
</html>
