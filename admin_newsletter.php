<?php

declare(strict_types=1);

require_once __DIR__ . '/auth.php';
require_once __DIR__ . '/db_config.php';
requireAdmin();

/** @var PDO $pdo */

$subscribers = $pdo->query("SELECT id, email, is_confirmed, confirmed_at, created_at FROM newsletter_subscribers ORDER BY created_at DESC LIMIT 1000")->fetchAll();

$baseUrl = getAppBaseUrl();
$pageTitle = 'Newsletter – odberatelia | MUDr. Ľubomír Polaščin';
$seoDescription = 'Správa odberateľov newslettera na Polascin.net.';
$robotsMeta = 'noindex, nofollow';
$canonicalUrl = $baseUrl . '/admin_newsletter.php';
?>
<!DOCTYPE html>
<html lang="sk">
<head>
<?php include __DIR__ . '/head_meta.php'; ?>
</head>
<body>
<?php include __DIR__ . '/header.php'; ?>
<main id="main-content" tabindex="-1" aria-label="Newsletter – odberatelia">
  <section class="admin-section">
    <div class="container">
      <h1>Odberatelia newslettera</h1>
      <p><a href="admin.php" class="btn btn-secondary btn-sm">Späť na panel</a></p>
      <p>Celkovo potvrdených: <?= (int) $pdo->query("SELECT COUNT(*) FROM newsletter_subscribers WHERE is_confirmed = 1")->fetchColumn() ?></p>
      <table class="admin-table admin-table-wrap">
        <thead><tr><th>E-mail</th><th>Stav</th><th>Prihlásený</th><th>Potvrdený</th></tr></thead>
        <tbody>
          <?php foreach ($subscribers as $sub): ?>
          <tr>
            <td><?= htmlspecialchars((string) $sub['email'], ENT_QUOTES, 'UTF-8') ?></td>
            <td><?= (int) $sub['is_confirmed'] === 1 ? 'Potvrdený' : 'Čakajúci' ?></td>
            <td><?= htmlspecialchars((string) $sub['created_at'], ENT_QUOTES, 'UTF-8') ?></td>
            <td><?= $sub['confirmed_at'] ? htmlspecialchars((string) $sub['confirmed_at'], ENT_QUOTES, 'UTF-8') : '-' ?></td>
          </tr>
          <?php endforeach; ?>
        </tbody>
      </table>
    </div>
  </section>
</main>
<?php include __DIR__ . '/footer.php'; ?>
</body>
</html>
