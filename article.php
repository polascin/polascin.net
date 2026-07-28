<?php

declare(strict_types=1);

require_once __DIR__ . '/auth.php';
require_once __DIR__ . '/db_config.php';
require_once __DIR__ . '/helpers.php';

/** @var PDO $pdo */

$slug = isset($_GET['slug']) ? trim((string) $_GET['slug']) : '';
if ($slug === '') {
    http_response_code(404);
    header('Location: articles.php');
    exit;
}

$article = getArticleBySlug($pdo, $slug);

if (!$article || ((int) $article['is_published'] !== 1 && !isAdmin())) {
    http_response_code(404);
    $pageTitle = 'Not Found | Dr. Lubomir Polascin';
    $seoDescription = 'Article not found.';
    $canonicalUrl = getAppBaseUrl() . '/articles.php';
    include __DIR__ . '/head_meta.php';
    include __DIR__ . '/header.php';
    echo '<main id="main-content" tabindex="-1" aria-label="Article not found"><section class="article-detail"><div class="container"><h1>Article not found</h1><p>The requested article does not exist or is not published.</p><p><a href="articles.php" class="btn btn-secondary">Back to articles</a></p></div></section></main>';
    include __DIR__ . '/footer.php';
    exit;
}

$baseUrl = getAppBaseUrl();
$pageTitle = htmlspecialchars((string) $article['title'], ENT_QUOTES, 'UTF-8') . ' | Dr. Lubomir Polascin';
$seoDescription = buildSeoExcerpt((string) ($article['excerpt'] ?? $article['content'] ?? ''), 170);
$canonicalUrl = $baseUrl . '/article.php?slug=' . rawurlencode((string) $article['slug']);
$ogType = 'article';
?>
<!DOCTYPE html>
<html lang="en">
<head>
<?php include __DIR__ . '/head_meta.php'; ?>
</head>
<body>
<?php include __DIR__ . '/header.php'; ?>
<main id="main-content" tabindex="-1" aria-label="Article content">
  <article class="article-detail">
    <div class="container">
      <h1><?= htmlspecialchars((string) $article['title'], ENT_QUOTES, 'UTF-8') ?></h1>
      <p class="article-meta"><?= htmlspecialchars(formatArticleDate($article['published_at'] ?? null), ENT_QUOTES, 'UTF-8') ?><?php if (!empty($article['author'])): ?> · <?= htmlspecialchars((string) $article['author'], ENT_QUOTES, 'UTF-8') ?><?php endif; ?></p>
      <?php if (!empty($article['excerpt'])): ?>
        <p class="article-excerpt"><?= htmlspecialchars((string) $article['excerpt'], ENT_QUOTES, 'UTF-8') ?></p>
      <?php endif; ?>
      <div class="article-body">
        <?= sanitizeHtmlContent((string) ($article['content'] ?? '')) ?>
      </div>
      <p><a href="articles.php" class="btn btn-secondary">Back to articles</a></p>
    </div>
  </article>
</main>
<?php include __DIR__ . '/footer.php'; ?>
</body>
</html>
