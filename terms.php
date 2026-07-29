<?php

declare(strict_types=1);

require_once __DIR__ . '/config_loader.php';

try {
    loadAppConfig();
} catch (AppConfigException) {
    readfile(__DIR__ . '/terms.html');
    exit;
}

require_once __DIR__ . '/auth.php';

$baseUrl = getAppBaseUrl();
$lang = currentLang();
$pageTitle = t('meta.terms_title') . ' | ' . t('common.author');
$seoDescription = t('meta.terms_description');
$robotsMeta = 'noindex, follow';
$canonicalUrl = absoluteLangUrl($lang, 'terms.php');
?>
<!DOCTYPE html>
<html lang="<?= htmlspecialchars($lang, ENT_QUOTES, 'UTF-8') ?>">
<head>
<?php include __DIR__ . '/head_meta.php'; ?>
</head>
<body>
<?php include __DIR__ . '/header.php'; ?>
<main id="main-content" class="page-content" tabindex="-1" aria-label="<?= te('terms.heading') ?>">
  <div class="container">
    <h1 class="section-title"><?= te('terms.heading') ?></h1>
    <p><strong><?= te('terms.updated') ?></strong></p>

    <h2><?= te('terms.s1_heading') ?></h2>
    <p><?= t('terms.s1_text') ?></p>

    <h2><?= te('terms.s2_heading') ?></h2>
    <div class="medical-disclaimer">
      <p><?= t('terms.s2_important') ?></p>
      <p><?= te('terms.s2_text') ?></p>
    </div>

    <h2><?= te('terms.s3_heading') ?></h2>
    <p><?= te('terms.s3_text') ?></p>

    <h2><?= te('terms.s4_heading') ?></h2>
    <p><?= te('terms.s4_text') ?></p>

    <h2><?= te('terms.s5_heading') ?></h2>
    <p><?= te('terms.s5_text') ?></p>
  </div>
</main>
<?php include __DIR__ . '/footer.php'; ?>
</body>
</html>
