<?php

declare(strict_types=1);

require_once __DIR__ . '/auth.php';
require_once __DIR__ . '/db_config.php';
require_once __DIR__ . '/helpers.php';

$lang = currentLang();
$rawSlug = $_GET['slug'] ?? null;
$slug = is_string($rawSlug) ? $rawSlug : '';
$isCatalog = $slug === '';
$work = !$isCatalog && libraryIsSlug($slug) ? libraryFind($slug) : null;
$notFound = !$isCatalog && $work === null;

$baseUrl = getAppBaseUrl();
$readableHtml = null;
if (is_array($work)) {
    $readableHtml = libraryReadableHtml($work);
}

if ($notFound) {
    http_response_code(404);
    $pageTitle = t('meta.library_404_title') . ' | ' . t('common.author');
    $seoDescription = t('meta.library_404_description');
    $canonicalUrl = absoluteLangUrl($lang, 'library.php');
    $robotsMeta = 'noindex, follow';
} elseif (is_array($work)) {
    $pageTitle = (string) $work['title'] . ' | ' . t('common.author');
    $seoDescription = (string) $work['description'] !== ''
        ? buildSeoExcerpt((string) $work['description'])
        : buildSeoExcerpt((string) $work['title'] . '. ' . t('library.intro'));
    $canonicalUrl = absoluteLangUrl($lang, 'library.php', ['slug' => (string) $work['slug']]);
    $ogType = 'article';
    $authorName = (string) $work['author'] !== '' ? (string) $work['author'] : t('common.author');
    $structuredData = [
        '@context' => 'https://schema.org',
        '@type' => 'CreativeWork',
        'name' => (string) $work['title'],
        'headline' => (string) $work['title'],
        'author' => [
            '@type' => 'Person',
            'name' => $authorName,
        ],
        'description' => $seoDescription,
        'url' => $canonicalUrl,
        'encoding' => [
            '@type' => 'MediaObject',
            'contentUrl' => rtrim($baseUrl, '/') . '/' . libraryFileUrl((string) $work['slug'], true),
            'encodingFormat' => (string) $work['mime'],
        ],
    ];
} else {
    $works = libraryList();
    $pageTitle = t('meta.library_title') . ' | ' . t('common.author');
    $seoDescription = t('meta.library_description');
    $canonicalUrl = absoluteLangUrl($lang, 'library.php');
    $structuredData = [
        '@context' => 'https://schema.org',
        '@type' => 'CollectionPage',
        'name' => t('library.heading'),
        'description' => $seoDescription,
        'url' => $canonicalUrl,
        'hasPart' => array_map(
            static function (array $item) use ($lang): array {
                return [
                    '@type' => 'CreativeWork',
                    'name' => (string) $item['title'],
                    'url' => absoluteLangUrl($lang, 'library.php', ['slug' => (string) $item['slug']]),
                ];
            },
            $works
        ),
    ];
}

$printOnPage = is_array($work) && (string) $work['kind'] !== 'pdf';
?>
<!DOCTYPE html>
<html lang="<?= htmlspecialchars($lang, ENT_QUOTES, 'UTF-8') ?>">
<head>
<?php include __DIR__ . '/head_meta.php'; ?>
</head>
<body class="library-page">
<?php include __DIR__ . '/header.php'; ?>
<main id="main-content" tabindex="-1" aria-label="<?= te('library.aria_label') ?>">
  <?php if ($notFound): ?>
  <section class="articles-list">
    <div class="container">
      <h1 class="section-title"><?= te('meta.library_404_title') ?></h1>
      <p><?= te('library.missing') ?> <a href="<?= htmlspecialchars(langUrl($lang, 'library.php'), ENT_QUOTES, 'UTF-8') ?>"><?= te('library.go_catalog') ?></a>.</p>
    </div>
  </section>
  <?php elseif (is_array($work)): ?>
  <article class="library-reader article-detail">
    <div class="container">
      <p class="library-back"><a href="<?= htmlspecialchars(langUrl($lang, 'library.php'), ENT_QUOTES, 'UTF-8') ?>"><?= te('library.back') ?></a></p>
      <h1><?= htmlspecialchars((string) $work['title'], ENT_QUOTES, 'UTF-8') ?></h1>
      <p class="article-meta">
        <?php if ((string) $work['author'] !== ''): ?>
          <?= te('common.author_meta_prefix') ?>: <?= htmlspecialchars((string) $work['author'], ENT_QUOTES, 'UTF-8') ?> ·
        <?php endif; ?>
        <?= te('library.format') ?>: <?= htmlspecialchars(strtoupper((string) $work['extension']), ENT_QUOTES, 'UTF-8') ?>
        · <?= htmlspecialchars(libraryFormatSize((int) $work['bytes']), ENT_QUOTES, 'UTF-8') ?>
        <?php $addedLabel = formatArticleDate((string) $work['added_at']); ?>
        <?php if ($addedLabel !== ''): ?>
          · <?= te('library.added', ['date' => $addedLabel]) ?>
        <?php endif; ?>
      </p>
      <?php if ((string) $work['description'] !== ''): ?>
        <p class="article-excerpt"><?= htmlspecialchars((string) $work['description'], ENT_QUOTES, 'UTF-8') ?></p>
      <?php endif; ?>
      <div class="library-toolbar">
        <a class="btn btn-secondary btn-sm" href="<?= htmlspecialchars(libraryFileUrl((string) $work['slug'], true), ENT_QUOTES, 'UTF-8') ?>"><?= te('library.download') ?></a>
        <?php if ($printOnPage): ?>
          <button type="button" class="btn btn-secondary btn-sm" data-print><?= te('library.print') ?></button>
        <?php else: ?>
          <a class="btn btn-secondary btn-sm" href="<?= htmlspecialchars(libraryFileUrl((string) $work['slug'], false), ENT_QUOTES, 'UTF-8') ?>" target="_blank" rel="noopener noreferrer"><?= te('library.print') ?></a>
        <?php endif; ?>
      </div>
      <?php if ($readableHtml !== null): ?>
        <div class="article-body library-sheet"><?= $readableHtml ?></div>
      <?php elseif ((string) $work['kind'] === 'pdf'): ?>
        <iframe class="library-pdf" title="<?= te('library.pdf_label') ?>" src="<?= htmlspecialchars(libraryFileUrl((string) $work['slug'], false), ENT_QUOTES, 'UTF-8') ?>#toolbar=1"></iframe>
      <?php elseif ((string) $work['kind'] === 'epub'): ?>
        <p><?= te('library.epub_note') ?></p>
      <?php else: ?>
        <p><?= te('library.too_large') ?></p>
      <?php endif; ?>
    </div>
  </article>
  <?php else: ?>
  <section class="articles-list">
    <div class="container">
      <h1 class="section-title reveal"><?= te('library.heading') ?></h1>
      <p class="section-intro"><?= te('library.intro') ?></p>
      <?php if ($works === []): ?>
        <p class="section-muted"><?= te('library.empty') ?></p>
      <?php else: ?>
        <div class="card-grid">
          <?php foreach ($works as $item): ?>
          <article class="card reveal">
            <h2><a href="<?= htmlspecialchars(langUrl($lang, 'library.php', ['slug' => (string) $item['slug']]), ENT_QUOTES, 'UTF-8') ?>"><?= htmlspecialchars((string) $item['title'], ENT_QUOTES, 'UTF-8') ?></a></h2>
            <p class="article-meta">
              <?php if ((string) $item['author'] !== ''): ?>
                <?= htmlspecialchars((string) $item['author'], ENT_QUOTES, 'UTF-8') ?> ·
              <?php endif; ?>
              <?= htmlspecialchars(strtoupper((string) $item['extension']), ENT_QUOTES, 'UTF-8') ?>
              · <?= htmlspecialchars(libraryFormatSize((int) $item['bytes']), ENT_QUOTES, 'UTF-8') ?>
            </p>
            <?php if ((string) $item['description'] !== ''): ?>
              <p><?= htmlspecialchars(buildSeoExcerpt((string) $item['description']), ENT_QUOTES, 'UTF-8') ?></p>
            <?php endif; ?>
            <p class="library-card-actions">
              <a class="btn btn-primary btn-sm" href="<?= htmlspecialchars(langUrl($lang, 'library.php', ['slug' => (string) $item['slug']]), ENT_QUOTES, 'UTF-8') ?>"><?= te('library.read') ?></a>
              <a class="btn btn-secondary btn-sm" href="<?= htmlspecialchars(libraryFileUrl((string) $item['slug'], true), ENT_QUOTES, 'UTF-8') ?>"><?= te('library.download') ?></a>
            </p>
          </article>
          <?php endforeach; ?>
        </div>
      <?php endif; ?>
    </div>
  </section>
  <?php endif; ?>
</main>
<?php include __DIR__ . '/footer.php'; ?>
<?php if ($printOnPage): ?>
<script nonce="<?= htmlspecialchars(getScriptNonce(), ENT_QUOTES, 'UTF-8') ?>">
document.querySelectorAll("[data-print]").forEach(function (button) {
  button.addEventListener("click", function () {
    window.print();
  });
});
</script>
<?php endif; ?>
</body>
</html>
