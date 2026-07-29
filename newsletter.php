<?php

declare(strict_types=1);

require_once __DIR__ . '/auth.php';
require_once __DIR__ . '/db_config.php';
require_once __DIR__ . '/helpers.php';

/** @var PDO $pdo */

$action = $_GET['action'] ?? '';
$token = isset($_GET['token']) ? trim((string) $_GET['token']) : '';
$action = is_string($action) && in_array($action, ['confirm', 'unsubscribe'], true) ? $action : '';
$lang = currentLang();
$message = '';
$messageType = 'info';
$showUnsubscribeConfirmation = false;
// Odhlasovací odkaz sa zobrazí iba raz, v tej istej odpovedi, ktorá potvrdí odber.
$oneTimeUnsubscribeUrl = '';
// Pozostatok po staršom presmerovaní; kľúč sa už nikde nenastavuje.
unset($_SESSION['newsletter_unsubscribe_url']);

function hashToken(string $token): string {
    return hash('sha256', $token);
}

function buildNewsletterActionUrl(string $action, string $token, string $lang): string {
    return absoluteLangUrl($lang, 'newsletter.php', [
        'action' => $action,
        'token' => $token,
    ]);
}

function sendNewsletterEmail(string $recipient, string $subject, string $body): bool {
    if (!filter_var($recipient, FILTER_VALIDATE_EMAIL) || preg_match('/[\r\n]/', $recipient . $subject)) {
        return false;
    }
    if (!function_exists('mail')) {
        error_log('PHP mail() nie je na serveri dostupné.');
        return false;
    }

    try {
        $env = loadAppConfig();
    } catch (\RuntimeException) {
        $env = [];
    }
    $from = trim((string) ($env['NEWSLETTER_FROM_EMAIL'] ?? getenv('NEWSLETTER_FROM_EMAIL') ?: 'lubomir@polascin.net'));
    if (!filter_var($from, FILTER_VALIDATE_EMAIL) || preg_match('/[\r\n]/', $from)) {
        error_log('NEWSLETTER_FROM_EMAIL nie je platná e-mailová adresa.');
        return false;
    }

    $encodedSubject = function_exists('mb_encode_mimeheader')
        ? mb_encode_mimeheader($subject, 'UTF-8')
        : '=?UTF-8?B?' . base64_encode($subject) . '?=';
    $headers = [
        'MIME-Version: 1.0',
        'Content-Type: text/plain; charset=UTF-8',
        'Content-Transfer-Encoding: 8bit',
        'From: Polascin.net <' . $from . '>',
        'Reply-To: ' . $from,
        'X-Auto-Response-Suppress: All',
    ];

    try {
        return @mail($recipient, $encodedSubject, wordwrap($body, 78), implode("\r\n", $headers));
    } catch (\Throwable $e) {
        error_log('Newsletter mail error: ' . $e->getMessage());
        return false;
    }
}

$ip = getClientIpAddress();

if ($action === 'confirm' && $token !== '') {
    if (preg_match('/^[a-f0-9]{48}$/', $token) !== 1) {
        $message = t('newsletter.confirm_link_used');
        $messageType = 'error';
    } elseif (!checkFormRateLimit($pdo, 'newsletter_confirm', $ip, 10, 3600)) {
        $message = t('newsletter.rate_limit_confirm');
        $messageType = 'error';
    } else {
        $hash = hashToken($token);
        $unsubscribeToken = bin2hex(random_bytes(24));
        try {
            $pdo->beginTransaction();
            $stmt = $pdo->prepare(
                "SELECT id, email
                 FROM newsletter_subscribers
                 WHERE confirm_token_hash = :hash
                   AND is_confirmed = 0
                   AND created_at >= DATE_SUB(NOW(), INTERVAL 48 HOUR)
                 LIMIT 1
                 FOR UPDATE"
            );
            $stmt->execute([':hash' => $hash]);
            $subscriber = $stmt->fetch();
            if (!is_array($subscriber)) {
                $pdo->rollBack();
                $message = t('newsletter.confirm_link_used');
                $messageType = 'error';
            } else {
                $update = $pdo->prepare(
                    "UPDATE newsletter_subscribers
                     SET is_confirmed = 1,
                         confirm_token_hash = NULL,
                         unsubscribe_token_hash = :unsubscribe_hash,
                         confirmed_at = NOW()
                     WHERE id = :id"
                );
                $update->execute([
                    ':unsubscribe_hash' => hashToken($unsubscribeToken),
                    ':id' => (int) $subscriber['id'],
                ]);
                $pdo->commit();

                $unsubscribeUrl = buildNewsletterActionUrl('unsubscribe', $unsubscribeToken, $lang);
                $mailBody = t('newsletter.mail_welcome_body', ['url' => $unsubscribeUrl]);
                if (!sendNewsletterEmail((string) $subscriber['email'], t('newsletter.mail_welcome_subject'), $mailBody)) {
                    error_log('Newsletter welcome email sa nepodarilo odoslať.');
                }

                // Výsledok sa vykresľuje priamo v tejto odpovedi, nie cez presmerovanie:
                // potvrdzovací odkaz sa otvára z e-mailového klienta, teda cross-site,
                // a session cookie so SameSite=Strict by sa v presmerovanej požiadavke
                // neposlala — správa aj jednorazový odhlasovací odkaz by sa stratili.
                $message = t('newsletter.confirmed');
                $messageType = 'success';
                $oneTimeUnsubscribeUrl = $unsubscribeUrl;
            }
        } catch (\Throwable $e) {
            if ($pdo->inTransaction()) {
                $pdo->rollBack();
            }
            error_log('newsletter confirm error: ' . $e->getMessage());
            $message = t('newsletter.error_generic');
            $messageType = 'error';
        }
    }
} elseif ($action === 'unsubscribe' && $token !== '') {
    if (preg_match('/^[a-f0-9]{48}$/', $token) !== 1) {
        $message = t('newsletter.unsubscribe_link_invalid');
        $messageType = 'error';
    } else {
        $showUnsubscribeConfirmation = true;
        $message = t('newsletter.unsubscribe_prompt');
    }
}

$errors = [];
$email = '';
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $formAction = (string) ($_POST['form_action'] ?? 'subscribe');
    if ($formAction === 'unsubscribe') {
        $action = 'unsubscribe';
        $token = trim((string) ($_POST['token'] ?? ''));
        $showUnsubscribeConfirmation = preg_match('/^[a-f0-9]{48}$/', $token) === 1;
    }
    $csrfToken = $_POST['csrf_token'] ?? '';
    if (!validateCsrfToken((string) $csrfToken)) {
        $errors[] = t('error.csrf');
    } elseif ($formAction === 'unsubscribe') {
        $unsubscribeToken = $token;
        $action = 'unsubscribe';
        $showUnsubscribeConfirmation = false;
        if (preg_match('/^[a-f0-9]{48}$/', $unsubscribeToken) !== 1) {
            $errors[] = t('newsletter.unsubscribe_link_used');
        } elseif (!checkFormRateLimit($pdo, 'newsletter_unsubscribe', $ip, 10, 3600)) {
            $errors[] = t('newsletter.rate_limit_unsubscribe');
        } else {
            try {
                $stmt = $pdo->prepare("DELETE FROM newsletter_subscribers WHERE unsubscribe_token_hash = :hash LIMIT 1");
                $stmt->execute([':hash' => hashToken($unsubscribeToken)]);
                if ($stmt->rowCount() > 0) {
                    setFlashMessage('success', t('newsletter.unsubscribed'));
                    header('Location: newsletter.php', true, 303);
                    exit;
                } else {
                    $errors[] = t('newsletter.unsubscribe_link_used');
                }
            } catch (\PDOException $e) {
                error_log('newsletter unsubscribe error: ' . $e->getMessage());
                $errors[] = t('newsletter.error_generic');
            }
        }
    } elseif ($formAction === 'subscribe') {
        $email = trim((string) ($_POST['email'] ?? ''));
        if (!filter_var($email, FILTER_VALIDATE_EMAIL) || appTextLength($email) > 255) {
            $errors[] = t('newsletter.error_email');
        }

        $ip = getClientIpAddress();
        if (empty($errors) && !checkFormRateLimit($pdo, 'newsletter_subscribe', $ip, 5, 3600)) {
            $errors[] = t('newsletter.rate_limit_subscribe');
        }
        if (empty($errors) && !isEmailDomainValid($email)) {
            $errors[] = t('newsletter.error_domain');
        }

        if (empty($errors)) {
            $confirmToken = bin2hex(random_bytes(24));
            try {
                $stmt = $pdo->prepare(
                    "INSERT INTO newsletter_subscribers (email, is_confirmed, confirm_token_hash, unsubscribe_token_hash, confirmed_at)
                     VALUES (:email, 0, :confirm_hash, NULL, NULL)
                     ON DUPLICATE KEY UPDATE
                         confirm_token_hash = IF(is_confirmed = 1, confirm_token_hash, VALUES(confirm_token_hash)),
                         unsubscribe_token_hash = IF(is_confirmed = 1, unsubscribe_token_hash, NULL),
                         created_at = IF(is_confirmed = 1, created_at, CURRENT_TIMESTAMP)"
                );
                $stmt->execute([
                    ':email' => $email,
                    ':confirm_hash' => hashToken($confirmToken),
                ]);

                $state = $pdo->prepare("SELECT is_confirmed FROM newsletter_subscribers WHERE email = :email LIMIT 1");
                $state->execute([':email' => $email]);
                $isConfirmed = (int) $state->fetchColumn() === 1;
                if (!$isConfirmed) {
                    // E-mail sa posiela v jazyku, v ktorom odberateľ formulár vyplnil.
                    $confirmUrl = buildNewsletterActionUrl('confirm', $confirmToken, $lang);
                    $mailBody = t('newsletter.mail_confirm_body', ['url' => $confirmUrl]);
                    if (!sendNewsletterEmail($email, t('newsletter.mail_confirm_subject'), $mailBody)) {
                        error_log('Newsletter confirmation email sa nepodarilo odoslať.');
                        $errors[] = t('newsletter.error_mail_failed');
                    }
                }

                if ($errors === []) {
                    setFlashMessage('success', t('newsletter.pending'));
                    header('Location: newsletter.php', true, 303);
                    exit;
                }
            } catch (\PDOException $e) {
                error_log('newsletter subscribe error: ' . $e->getMessage());
                $errors[] = t('newsletter.error_generic');
            }
        }
    } else {
        $errors[] = t('newsletter.error_action');
    }
}

$baseUrl = getAppBaseUrl();
$pageTitle = t('meta.newsletter_title') . ' | ' . t('common.author');
$seoDescription = t('meta.newsletter_description');
$robotsMeta = 'noindex, follow';
$canonicalUrl = absoluteLangUrl($lang, 'newsletter.php');
?>
<!DOCTYPE html>
<html lang="<?= htmlspecialchars($lang, ENT_QUOTES, 'UTF-8') ?>">
<head>
<?php include __DIR__ . '/head_meta.php'; ?>
</head>
<body>
<?php include __DIR__ . '/header.php'; ?>
<main id="main-content" tabindex="-1" aria-label="<?= te('newsletter.aria_label') ?>">
  <section class="newsletter-section">
    <div class="container">
      <h1 class="section-title reveal"><?= te('newsletter.heading') ?></h1>
      <?php if ($message !== ''): ?>
        <div class="alert alert-<?= htmlspecialchars($messageType, ENT_QUOTES, 'UTF-8') ?>"><p><?= htmlspecialchars($message, ENT_QUOTES, 'UTF-8') ?></p></div>
      <?php endif; ?>
      <?php foreach ($errors as $error): ?>
        <div class="alert alert-error"><p><?= htmlspecialchars($error, ENT_QUOTES, 'UTF-8') ?></p></div>
      <?php endforeach; ?>

      <?php if ($oneTimeUnsubscribeUrl !== ''): ?>
        <div class="alert alert-success">
          <p><?= te('newsletter.unsubscribe_hint') ?>
            <a href="<?= htmlspecialchars($oneTimeUnsubscribeUrl, ENT_QUOTES, 'UTF-8') ?>"><?= te('newsletter.unsubscribe_hint_link') ?></a>.
          </p>
        </div>
      <?php endif; ?>

      <?php if ($showUnsubscribeConfirmation): ?>
        <form method="post" action="newsletter.php" class="newsletter-form">
          <input type="hidden" name="csrf_token" value="<?= htmlspecialchars(generateCsrfToken(), ENT_QUOTES, 'UTF-8') ?>">
          <input type="hidden" name="form_action" value="unsubscribe">
          <input type="hidden" name="token" value="<?= htmlspecialchars($token, ENT_QUOTES, 'UTF-8') ?>">
          <button type="submit" class="btn btn-danger"><?= te('newsletter.confirm_unsubscribe') ?></button>
        </form>
      <?php endif; ?>

      <?php if ($action === ''): ?>
        <p><?= te('newsletter.intro') ?></p>
        <form method="post" action="<?= htmlspecialchars(langUrl($lang, 'newsletter.php'), ENT_QUOTES, 'UTF-8') ?>" class="newsletter-form" novalidate>
          <input type="hidden" name="csrf_token" value="<?= htmlspecialchars(generateCsrfToken(), ENT_QUOTES, 'UTF-8') ?>">
          <input type="hidden" name="form_action" value="subscribe">
          <div class="form-group">
            <label for="email"><?= te('newsletter.email') ?> <span aria-label="<?= te('common.required') ?>">*</span></label>
            <input type="email" id="email" name="email" value="<?= htmlspecialchars($email, ENT_QUOTES, 'UTF-8') ?>" required maxlength="255">
          </div>
          <button type="submit" class="btn btn-primary"><?= te('newsletter.subscribe') ?></button>
        </form>
      <?php endif; ?>
    </div>
  </section>
</main>
<?php include __DIR__ . '/footer.php'; ?>
</body>
</html>
