<?php

declare(strict_types=1);

require_once __DIR__ . '/auth.php';
require_once __DIR__ . '/db_config.php';
requireAdmin();

/** @var PDO $pdo */

$articleCount = (int) $pdo->query("SELECT COUNT(*) FROM articles")->fetchColumn();
$publishedCount = (int) $pdo->query("SELECT COUNT(*) FROM articles WHERE is_published = 1")->fetchColumn();
$messageCount = (int) $pdo->query("SELECT COUNT(*) FROM contact_messages")->fetchColumn();
$unreadCount = (int) $pdo->query("SELECT COUNT(*) FROM contact_messages WHERE is_read = 0")->fetchColumn();
$subscriberCount = (int) $pdo->query("SELECT COUNT(*) FROM newsletter_subscribers WHERE is_confirmed = 1")->fetchColumn();

$baseUrl = getAppBaseUrl();
$pageTitle = 'Administrácia | MUDr. Ľubomír Polaščín';
$seoDescription = 'Administračný panel pre Polascin.net.';
$robotsMeta = 'noindex, nofollow';
$canonicalUrl = $baseUrl . '/admin.php';
?>
<!DOCTYPE html>
<html lang="sk">
<head>
<?php include __DIR__ . '/head_meta.php'; ?>
</head>
<body>
<?php include __DIR__ . '/header.php'; ?>
<main id="main-content" tabindex="-1" aria-label="Administračný panel">
  <section class="admin-section">
    <div class="container">
      <h1>Administračný panel</h1>
      <div class="admin-cards">
        <div class="card"><h2>Články</h2><p><strong><?= $publishedCount ?></strong> publikovaných / <?= $articleCount ?> celkovo</p><a href="admin_articles.php" class="btn btn-primary">Spravovať články</a></div>
        <div class="card"><h2>Obsahové bloky</h2><p>Spravovať sekcie a texty na hlavnej stránke.</p><a href="admin_content.php" class="btn btn-primary">Spravovať obsah</a></div>
        <div class="card"><h2>Správy</h2><p><strong><?= $unreadCount ?></strong> neprečítaných / <?= $messageCount ?> celkovo</p><a href="admin_contact.php" class="btn btn-primary">Zobraziť správy</a></div>
        <div class="card"><h2>Newsletter</h2><p><strong><?= $subscriberCount ?></strong> potvrdených odberateľov</p><a href="admin_newsletter.php" class="btn btn-primary">Zobraziť odberateľov</a></div>
      </div>
    </div>
  </section>
</main>
<?php include __DIR__ . '/footer.php'; ?>
</body>
</html>
