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
$pageTitle = 'Admin Dashboard | Dr. Lubomir Polascin';
$seoDescription = 'Administration dashboard for Polascin.net.';
$robotsMeta = 'noindex, nofollow';
$canonicalUrl = $baseUrl . '/admin.php';
?>
<!DOCTYPE html>
<html lang="en">
<head>
<?php include __DIR__ . '/head_meta.php'; ?>
</head>
<body>
<?php include __DIR__ . '/header.php'; ?>
<main id="main-content" tabindex="-1" aria-label="Administration dashboard">
  <section class="admin-section">
    <div class="container">
      <h1>Admin Dashboard</h1>
      <div class="admin-cards">
        <div class="card"><h2>Articles</h2><p><strong><?= $publishedCount ?></strong> published / <?= $articleCount ?> total</p><a href="admin_articles.php" class="btn btn-primary">Manage articles</a></div>
        <div class="card"><h2>Content blocks</h2><p>Manage homepage sections and texts.</p><a href="admin_content.php" class="btn btn-primary">Manage content</a></div>
        <div class="card"><h2>Messages</h2><p><strong><?= $unreadCount ?></strong> unread / <?= $messageCount ?> total</p><a href="admin_contact.php" class="btn btn-primary">View messages</a></div>
        <div class="card"><h2>Newsletter</h2><p><strong><?= $subscriberCount ?></strong> confirmed subscribers</p><a href="admin_newsletter.php" class="btn btn-primary">View subscribers</a></div>
      </div>
    </div>
  </section>
</main>
<?php include __DIR__ . '/footer.php'; ?>
</body>
</html>
