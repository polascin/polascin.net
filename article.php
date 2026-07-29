<?php

declare(strict_types=1);

require_once __DIR__ . '/auth.php';
require_once __DIR__ . '/db_config.php';
require_once __DIR__ . '/helpers.php';

/** @var PDO $pdo */

$lang = currentLang();
$slug = isset($_GET['slug']) ? trim((string) $_GET['slug']) : '';
// Administrátor smie vidieť aj nepublikovaný koncept v požadovanom jazyku;
// návštevníkovi sa namiesto neho ponúkne publikovaný preklad.
$article = preg_match('/^[a-z0-9-]{1,255}$/D', $slug) === 1
    ? getArticleBySlug($pdo, $slug, $lang, isAdmin())
    : null;
// Článok sa mohol nájsť len v inom jazyku (staré odkazy, chýbajúci preklad).
$articleLang = is_array($article) ? (string) ($article['lang'] ?? $lang) : $lang;
$isTranslationFallback = is_array($article) && $articleLang !== $lang;
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
    $pageTitle = t('meta.article_404_title') . ' | ' . t('common.author');
    $seoDescription = t('meta.article_404_description');
    $canonicalUrl = absoluteLangUrl($lang, 'articles.php');
    $robotsMeta = 'noindex, follow';
} else {
    $pageTitle = (string) $article['title'] . ' | ' . t('common.author');
    $seoDescription = buildSeoExcerpt((string) ($article['excerpt'] ?: $article['content'] ?? ''), 170);
    // Kanonická URL patrí jazyku, v ktorom je článok skutočne napísaný.
    $canonicalUrl = absoluteLangUrl($articleLang, 'article.php', ['slug' => (string) $article['slug']]);
    $ogType = 'article';

    // Jazykové varianty ukazujú na skutočné preklady, nie na tú istú URL.
    $articleTranslations = array_filter(
        getArticleTranslations($pdo, isset($article['translation_group']) ? (int) $article['translation_group'] : null),
        static fn(string $translationLang): bool => isSupportedLanguage($translationLang),
        ARRAY_FILTER_USE_KEY
    );

    // Prepínač ponúka preložené adresy vždy, keď existujú; pre jazyk bez prekladu
    // zostáva predvolený cieľ, ktorý prepne jazyk celej stránky.
    $languageSwitchTargets = [];
    foreach ($articleTranslations as $translationLang => $translationSlug) {
        $languageSwitchTargets[$translationLang] = langUrl($translationLang, 'article.php', ['slug' => $translationSlug]);
    }

    // hreflang má zmysel len pri skutočnom preklade. Bez tohto priradenia by
    // `head_meta.php` doplnil klaster všetkých šiestich jazykov, hoci každá z tých
    // adries sa kanonizuje späť na tento článok — rozbitý klaster vyhľadávače
    // zahodia celý. Rovnaké pravidlo platí v `sitemap.php`.
    $languageAlternates = [];
    if (count($articleTranslations) > 1) {
        foreach ($articleTranslations as $translationLang => $translationSlug) {
            $languageAlternates[$translationLang] = absoluteLangUrl($translationLang, 'article.php', ['slug' => $translationSlug]);
        }
    }
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
<html lang="<?= htmlspecialchars($lang, ENT_QUOTES, 'UTF-8') ?>">
<head>
<?php include __DIR__ . '/head_meta.php'; ?>
</head>
<body>
<?php include __DIR__ . '/header.php'; ?>
<main id="main-content" tabindex="-1" aria-label="<?= $notFound ? te('article.not_found_aria') : te('article.aria_label') ?>">
  <?php if ($notFound): ?>
  <section class="article-detail">
    <div class="container">
      <h1><?= te('article.not_found_heading') ?></h1>
      <p><?= te('article.not_found_text') ?></p>
      <p><a href="<?= htmlspecialchars(langUrl($lang, 'articles.php'), ENT_QUOTES, 'UTF-8') ?>" class="btn btn-secondary"><?= te('article.back_to_list') ?></a></p>
    </div>
  </section>
  <?php else: ?>
  <article class="article-detail">
    <div class="container">
      <?php if ($isAdminPreview): ?>
        <div class="alert alert-error" role="status"><p><?= te('article.admin_preview') ?></p></div>
      <?php endif; ?>
      <?php if ($isTranslationFallback): ?>
        <div class="alert alert-info" role="status"><p><?= te('articles.no_translation') ?></p></div>
      <?php endif; ?>
      <h1 lang="<?= htmlspecialchars($articleLang, ENT_QUOTES, 'UTF-8') ?>"><?= htmlspecialchars((string) $article['title'], ENT_QUOTES, 'UTF-8') ?></h1>
      <p class="article-meta"><?= htmlspecialchars(formatArticleDate($article['published_at'] ?? null, $articleLang), ENT_QUOTES, 'UTF-8') ?><?php if (!empty($article['author'])): ?> · <?= htmlspecialchars((string) $article['author'], ENT_QUOTES, 'UTF-8') ?><?php endif; ?></p>
      <?php if (!empty($article['excerpt'])): ?>
        <p class="article-excerpt" lang="<?= htmlspecialchars($articleLang, ENT_QUOTES, 'UTF-8') ?>"><?= htmlspecialchars((string) $article['excerpt'], ENT_QUOTES, 'UTF-8') ?></p>
      <?php endif; ?>
      <div class="article-body" lang="<?= htmlspecialchars($articleLang, ENT_QUOTES, 'UTF-8') ?>">
        <?= sanitizeHtmlContent((string) ($article['content'] ?? '')) ?>
      </div>
      <?php
      $otherTranslations = array_diff_key($articleTranslations ?? [], [$articleLang => true]);
      ?>
      <?php if ($otherTranslations !== []): ?>
        <p class="article-translations"><?= te('article.available_in') ?>
          <?php $translationLinks = []; ?>
          <?php foreach ($otherTranslations as $translationLang => $translationSlug): ?>
            <?php $translationLinks[] = '<a href="' . htmlspecialchars(langUrl($translationLang, 'article.php', ['slug' => $translationSlug]), ENT_QUOTES, 'UTF-8') . '" hreflang="' . htmlspecialchars($translationLang, ENT_QUOTES, 'UTF-8') . '" lang="' . htmlspecialchars($translationLang, ENT_QUOTES, 'UTF-8') . '">' . htmlspecialchars((string) appLanguages()[$translationLang]['native'], ENT_QUOTES, 'UTF-8') . '</a>'; ?>
          <?php endforeach; ?>
          <?= implode(', ', $translationLinks) ?>
        </p>
      <?php endif; ?>
      <p><a href="<?= htmlspecialchars(langUrl($lang, 'articles.php'), ENT_QUOTES, 'UTF-8') ?>" class="btn btn-secondary"><?= te('article.back_to_list') ?></a></p>
    </div>
  </article>
  <?php endif; ?>
</main>
<?php include __DIR__ . '/footer.php'; ?>
</body>
</html>
