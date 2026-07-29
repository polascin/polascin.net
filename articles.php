<?php

declare(strict_types=1);

require_once __DIR__ . '/auth.php';
require_once __DIR__ . '/db_config.php';
require_once __DIR__ . '/helpers.php';

/** @var PDO $pdo */

$lang = currentLang();
$perPage = 10;
$total = countPublishedArticles($pdo, $lang);
$totalPages = max(1, (int) ceil($total / $perPage));
$rawPage = $_GET['page'] ?? '1';
$pageIsValid = is_string($rawPage)
    && preg_match('/^[1-9][0-9]{0,8}$/D', $rawPage) === 1
    && (int) $rawPage <= $totalPages;
$page = $pageIsValid ? (int) $rawPage : 1;
$offset = ($page - 1) * $perPage;
$articles = $pageIsValid ? getPublishedArticles($pdo, $perPage, $offset, $lang) : [];

$baseUrl = getAppBaseUrl();
if (!$pageIsValid) {
    http_response_code(404);
    $pageTitle = t('meta.articles_404_title') . ' | ' . t('common.author');
    $seoDescription = t('meta.articles_404_description');
    $canonicalUrl = absoluteLangUrl($lang, 'articles.php');
    $robotsMeta = 'noindex, follow';
} else {
    $pageTitle = t('meta.articles_title') . ' | ' . t('common.author');
    $seoDescription = t('meta.articles_description');
    $canonicalUrl = absoluteLangUrl($lang, 'articles.php', $page > 1 ? ['page' => $page] : []);

    // Jazykové varianty zostávajú na tej istej strane stránkovania, ale iba ak
    // v danom jazyku toľko článkov vôbec je — inak by odkaz viedol na 404.
    if ($page > 1) {
        $languageAlternates = [];
        $languageSwitchTargets = [];
        foreach (array_keys(appLanguages()) as $alternateLang) {
            $alternatePages = max(1, (int) ceil(countPublishedArticles($pdo, $alternateLang) / $perPage));
            $alternatePage = min($page, $alternatePages);
            $alternateParams = $alternatePage > 1 ? ['page' => $alternatePage] : [];
            $languageAlternates[$alternateLang] = absoluteLangUrl($alternateLang, 'articles.php', $alternateParams);
            $languageSwitchTargets[$alternateLang] = langUrl($alternateLang, 'articles.php', $alternateParams);
        }
    }
}
?>
<!DOCTYPE html>
<html lang="<?= htmlspecialchars($lang, ENT_QUOTES, 'UTF-8') ?>">
<head>
<?php include __DIR__ . '/head_meta.php'; ?>
</head>
<body>
<?php include __DIR__ . '/header.php'; ?>
<main id="main-content" tabindex="-1" aria-label="<?= te('articles.aria_label') ?>">
  <section class="articles-list">
    <div class="container">
      <h1 class="section-title reveal"><?= te('articles.heading') ?></h1>
      <?php if (!$pageIsValid): ?>
        <p><?= te('articles.page_missing') ?> <a href="<?= htmlspecialchars(langUrl($lang, 'articles.php'), ENT_QUOTES, 'UTF-8') ?>"><?= te('articles.go_first_page') ?></a>.</p>
      <?php elseif (empty($articles)): ?>
        <p><?= te('articles.empty') ?></p>
      <?php else: ?>
        <div class="card-grid">
          <?php foreach ($articles as $article): ?>
          <article class="card reveal">
            <h2><a href="<?= htmlspecialchars(langUrl($lang, 'article.php', ['slug' => (string) $article['slug']]), ENT_QUOTES, 'UTF-8') ?>"><?= htmlspecialchars((string) $article['title'], ENT_QUOTES, 'UTF-8') ?></a></h2>
            <p class="article-meta"><?= htmlspecialchars(formatArticleDate($article['published_at'] ?? null), ENT_QUOTES, 'UTF-8') ?><?php if (!empty($article['author'])): ?> · <?= htmlspecialchars((string) $article['author'], ENT_QUOTES, 'UTF-8') ?><?php endif; ?></p>
            <p><?= htmlspecialchars(buildSeoExcerpt((string) ($article['excerpt'] ?? '')), ENT_QUOTES, 'UTF-8') ?></p>
          </article>
          <?php endforeach; ?>
        </div>
        <?php if ($totalPages > 1): ?>
        <nav class="pagination" aria-label="<?= te('articles.pagination_label') ?>">
          <?php for ($i = 1; $i <= $totalPages; $i++): ?>
            <?php if ($i === $page): ?>
              <span class="page-current" aria-current="page"><?= $i ?></span>
            <?php else: ?>
              <a class="page-link" href="<?= htmlspecialchars(langUrl($lang, 'articles.php', ['page' => $i]), ENT_QUOTES, 'UTF-8') ?>"><?= $i ?></a>
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
