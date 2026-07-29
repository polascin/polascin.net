<?php

declare(strict_types=1);

require_once __DIR__ . '/auth.php';
require_once __DIR__ . '/db_config.php';
require_once __DIR__ . '/helpers.php';

/** @var PDO $pdo */

$slug = isset($_GET['slug']) ? trim((string) $_GET['slug']) : '';
$article = preg_match('/^[a-z0-9-]{1,255}$/D', $slug) === 1
    ? getArticleBySlug($pdo, $slug)
    : null;
$publishedTimestamp = is_array($article) && !empty($article['published_at'])
    ? strtotime((string) $article['published_at'])
    : false;
$isPubliclyVisible = is_array($article)
    && (int) $article['is_published'] === 1
    && $publishedTimestamp !== false
    && $publishedTimestamp <= time();
$isAdminPreview = is_array($article) && !$isPubliclyVisible && isAdmin();
$notFound = !is_array($article) || (!$isPubliclyVisible && !$isAdminPreview);

$baseUrl = getAppBaseUrl();
if ($notFound) {
    http_response_code(404);
    $pageTitle = 'Nenájdené | MUDr. Ľubomír Polaščín';
    $seoDescription = 'Článok nebol nájdený.';
    $canonicalUrl = $baseUrl . '/articles.php';
    $robotsMeta = 'noindex, follow';
} else {
    $pageTitle = (string) $article['title'] . ' | MUDr. Ľubomír Polaščín';
    $seoDescription = buildSeoExcerpt((string) ($article['excerpt'] ?: $article['content'] ?? ''), 170);
    $canonicalUrl = $baseUrl . '/article.php?slug=' . rawurlencode((string) $article['slug']);
    $ogType = 'article';
    $robotsMeta = $isAdminPreview ? 'noindex, nofollow' : 'index, follow, max-image-preview:large';
    $modifiedTimestamp = !empty($article['updated_at']) ? strtotime((string) $article['updated_at']) : false;
    if (!$isAdminPreview) {
        $structuredData = [
            '@context' => 'https://schema.org',
            '@type' => 'BlogPosting',
            'headline' => (string) $article['title'],
            'description' => $seoDescription,
            'datePublished' => date(DATE_ATOM, (int) $publishedTimestamp),
            'dateModified' => date(DATE_ATOM, $modifiedTimestamp !== false ? $modifiedTimestamp : (int) $publishedTimestamp),
            'mainEntityOfPage' => $canonicalUrl,
            'author' => [
                '@type' => 'Person',
                'name' => (string) ($article['author'] ?: 'Ľubomír Polaščín'),
            ],
        ];
    }
}
?>
<!DOCTYPE html>
<html lang="sk">
<head>
<?php include __DIR__ . '/head_meta.php'; ?>
</head>
<body>
<?php include __DIR__ . '/header.php'; ?>
<main id="main-content" tabindex="-1" aria-label="<?= $notFound ? 'Článok nebol nájdený' : 'Obsah článku' ?>">
  <?php if ($notFound): ?>
  <section class="article-detail">
    <div class="container">
      <h1>Článok nebol nájdený</h1>
      <p>Požadovaný článok neexistuje alebo nie je publikovaný.</p>
      <p><a href="articles.php" class="btn btn-secondary">Späť na články</a></p>
    </div>
  </section>
  <?php else: ?>
  <article class="article-detail">
    <div class="container">
      <?php if ($isAdminPreview): ?>
        <div class="alert alert-error" role="status"><p>Administrátorský náhľad — tento článok zatiaľ nie je verejne dostupný.</p></div>
      <?php endif; ?>
      <h1><?= htmlspecialchars((string) $article['title'], ENT_QUOTES, 'UTF-8') ?></h1>
      <p class="article-meta"><?= htmlspecialchars(formatArticleDate($article['published_at'] ?? null), ENT_QUOTES, 'UTF-8') ?><?php if (!empty($article['author'])): ?> · <?= htmlspecialchars((string) $article['author'], ENT_QUOTES, 'UTF-8') ?><?php endif; ?></p>
      <?php if (!empty($article['excerpt'])): ?>
        <p class="article-excerpt"><?= htmlspecialchars((string) $article['excerpt'], ENT_QUOTES, 'UTF-8') ?></p>
      <?php endif; ?>
      <div class="article-body">
        <?= sanitizeHtmlContent((string) ($article['content'] ?? '')) ?>
      </div>
      <p><a href="articles.php" class="btn btn-secondary">Späť na články</a></p>
    </div>
  </article>
  <?php endif; ?>
</main>
<?php include __DIR__ . '/footer.php'; ?>
</body>
</html>
