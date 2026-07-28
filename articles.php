<?php

declare(strict_types=1);

require_once __DIR__ . '/auth.php';
require_once __DIR__ . '/db_config.php';
require_once __DIR__ . '/helpers.php';

/** @var PDO $pdo */

$perPage = 10;
$page = isset($_GET['page']) ? max(1, (int) $_GET['page']) : 1;
$offset = ($page - 1) * $perPage;

$articles = getPublishedArticles($pdo, $perPage, $offset);

$countStmt = $pdo->query("SELECT COUNT(*) FROM articles WHERE is_published = 1 AND published_at <= NOW()");
$total = (int) $countStmt->fetchColumn();
$totalPages = max(1, (int) ceil($total / $perPage));

$baseUrl = getAppBaseUrl();
$pageTitle = 'Articles | Dr. Lubomir Polascin';
$seoDescription = 'Latest articles and insights from Dr. Lubomir Polascin on nephrology, internal medicine, technology and writing.';
$canonicalUrl = $baseUrl . '/articles.php' . ($page > 1 ? '?page=' . $page : '');
?>
<!DOCTYPE html>
<html lang="en">
<head>
<?php include __DIR__ . '/head_meta.php'; ?>
</head>
<body>
<?php include __DIR__ . '/header.php'; ?>
<main id="main-content" tabindex="-1" aria-label="Articles">
  <section class="articles-list">
    <div class="container">
      <h1 class="section-title reveal">Articles</h1>
      <?php if (empty($articles)): ?>
        <p>No articles published yet.</p>
      <?php else: ?>
        <div class="card-grid">
          <?php foreach ($articles as $article): ?>
          <article class="card reveal">
            <h2><a href="article.php?slug=<?= htmlspecialchars(rawurlencode((string) $article['slug']), ENT_QUOTES, 'UTF-8') ?>"><?= htmlspecialchars((string) $article['title'], ENT_QUOTES, 'UTF-8') ?></a></h2>
            <p class="article-meta"><?= htmlspecialchars(formatArticleDate($article['published_at'] ?? null), ENT_QUOTES, 'UTF-8') ?><?php if (!empty($article['author'])): ?> · <?= htmlspecialchars((string) $article['author'], ENT_QUOTES, 'UTF-8') ?><?php endif; ?></p>
            <p><?= htmlspecialchars(buildSeoExcerpt((string) ($article['excerpt'] ?? '')), ENT_QUOTES, 'UTF-8') ?></p>
          </article>
          <?php endforeach; ?>
        </div>
        <?php if ($totalPages > 1): ?>
        <nav class="pagination" aria-label="Article pagination">
          <?php for ($i = 1; $i <= $totalPages; $i++): ?>
            <?php if ($i === $page): ?>
              <span class="page-current" aria-current="page"><?= $i ?></span>
            <?php else: ?>
              <a class="page-link" href="articles.php?page=<?= $i ?>"><?= $i ?></a>
            <?php endif; ?>
          <?php endfor; ?>
        </nav>
        <?php endif; ?>
      <?php endif; ?>
    </div>
  </section>
</main>
<?php include __DIR__ . '/footer.php'; ?>
</body>
</html>
