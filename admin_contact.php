<?php

declare(strict_types=1);

require_once __DIR__ . '/auth.php';
require_once __DIR__ . '/db_config.php';
requireAdmin();

/** @var PDO $pdo */

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['mark_read']) && isset($_POST['id'])) {
    $csrfToken = $_POST['csrf_token'] ?? '';
    if (validateCsrfToken((string) $csrfToken)) {
        $stmt = $pdo->prepare("UPDATE contact_messages SET is_read = 1 WHERE id = :id LIMIT 1");
        $stmt->execute([':id' => (int) $_POST['id']]);
        logAdminAction($pdo, 'contact_mark_read', 'contact_message', (int) $_POST['id']);
    }
    header('Location: admin_contact.php');
    exit;
}

$messages = $pdo->query("SELECT * FROM contact_messages ORDER BY created_at DESC LIMIT 500")->fetchAll();

$baseUrl = getAppBaseUrl();
$pageTitle = 'Správy z kontaktného formulára | MUDr. Ľubomír Polaščin';
$seoDescription = 'Správa kontaktných správ na Polascin.net.';
$robotsMeta = 'noindex, nofollow';
$canonicalUrl = $baseUrl . '/admin_contact.php';
?>
<!DOCTYPE html>
<html lang="sk">
<head>
<?php include __DIR__ . '/head_meta.php'; ?>
</head>
<body>
<?php include __DIR__ . '/header.php'; ?>
<main id="main-content" tabindex="-1" aria-label="Kontaktné správy">
  <section class="admin-section">
    <div class="container">
      <h1>Kontaktné správy</h1>
      <p><a href="admin.php" class="btn btn-secondary btn-sm">Späť na panel</a></p>
      <?php if (empty($messages)): ?>
        <p>Zatiaľ žiadne správy.</p>
      <?php else: ?>
      <table class="admin-table admin-table-wrap">
        <thead><tr><th>Dátum</th><th>Meno</th><th>E-mail</th><th>Predmet</th><th>Stav</th><th>Akcie</th></tr></thead>
        <tbody>
          <?php foreach ($messages as $msg): ?>
          <tr>
            <td><?= htmlspecialchars((string) $msg['created_at'], ENT_QUOTES, 'UTF-8') ?></td>
            <td><?= htmlspecialchars((string) $msg['name'], ENT_QUOTES, 'UTF-8') ?></td>
            <td><a href="mailto:<?= htmlspecialchars(rawurlencode((string) $msg['email']), ENT_QUOTES, 'UTF-8') ?>"><?= htmlspecialchars((string) $msg['email'], ENT_QUOTES, 'UTF-8') ?></a></td>
            <td><?= htmlspecialchars((string) ($msg['subject'] ?? ''), ENT_QUOTES, 'UTF-8') ?></td>
            <td><?= (int) $msg['is_read'] === 1 ? 'Prečítané' : 'Neprečítané' ?></td>
            <td class="actions">
              <a href="#message-<?= (int) $msg['id'] ?>" class="btn btn-sm btn-secondary">Zobraziť</a>
              <?php if ((int) $msg['is_read'] === 0): ?>
              <form method="post" action="admin_contact.php" class="inline-form">
                <input type="hidden" name="csrf_token" value="<?= htmlspecialchars(generateCsrfToken(), ENT_QUOTES, 'UTF-8') ?>">
                <input type="hidden" name="mark_read" value="1">
                <input type="hidden" name="id" value="<?= (int) $msg['id'] ?>">
                <button type="submit" class="btn btn-sm btn-primary">Označiť ako prečítané</button>
              </form>
              <?php endif; ?>
            </td>
          </tr>
          <tr id="message-<?= (int) $msg['id'] ?>" class="message-row">
            <td colspan="6">
              <div class="message-body">
                <p><strong>Správa:</strong></p>
                <p><?= nl2br(htmlspecialchars((string) $msg['message'], ENT_QUOTES, 'UTF-8'), false) ?></p>
              </div>
            </td>
          </tr>
          <?php endforeach; ?>
        </tbody>
      </table>
      <?php endif; ?>
    </div>
  </section>
</main>
<?php include __DIR__ . '/footer.php'; ?>
</body>
</html>
