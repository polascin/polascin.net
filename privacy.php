<?php

declare(strict_types=1);

require_once __DIR__ . '/config_loader.php';

try {
    loadAppConfig();
} catch (AppConfigException) {
    readfile(__DIR__ . '/privacy.html');
    exit;
}

require_once __DIR__ . '/auth.php';

$baseUrl = getAppBaseUrl();
$lang = currentLang();
$pageTitle = t('meta.privacy_title') . ' | ' . t('common.author');
$seoDescription = t('meta.privacy_description');
$robotsMeta = 'noindex, follow';
$canonicalUrl = absoluteLangUrl($lang, 'privacy.php');
?>
<!DOCTYPE html>
<html lang="<?= htmlspecialchars($lang, ENT_QUOTES, 'UTF-8') ?>">
<head>
<?php include __DIR__ . '/head_meta.php'; ?>
</head>
<body>
<?php include __DIR__ . '/header.php'; ?>
<main id="main-content" class="page-content" tabindex="-1" aria-label="<?= te('privacy.heading') ?>">
  <div class="container">
    <h1 class="section-title"><?= te('privacy.heading') ?></h1>
    <p><strong><?= te('privacy.updated') ?></strong></p>

    <h2><?= te('privacy.s1_heading') ?></h2>
    <p><?= t('privacy.s1_text') ?></p>

    <h2><?= te('privacy.s2_heading') ?></h2>
    <p><?= te('privacy.s2_text') ?></p>
    <ul>
      <li><?= t('privacy.s2_technical') ?></li>
      <li><?= t('privacy.s2_contact') ?></li>
      <li><?= t('privacy.s2_newsletter') ?></li>
      <li><?= t('privacy.s2_cookies') ?></li>
    </ul>

    <h2><?= te('privacy.s3_heading') ?></h2>
    <p><?= te('privacy.s3_text') ?></p>
    <ul>
      <li><?= te('privacy.s3_item1') ?></li>
      <li><?= te('privacy.s3_item2') ?></li>
      <li><?= te('privacy.s3_item3') ?></li>
      <li><?= te('privacy.s3_item4') ?></li>
      <li><?= t('privacy.s3_item5') ?></li>
    </ul>

    <h2><?= te('privacy.s4_heading') ?></h2>
    <p><?= te('privacy.s4_text') ?></p>

    <h2><?= te('privacy.s5_heading') ?></h2>
    <p><?= te('privacy.s5_text') ?></p>

    <h2><?= te('privacy.s6_heading') ?></h2>
    <p><?= te('privacy.s6_text') ?></p>

    <h2><?= te('privacy.s7_heading') ?></h2>
    <p><?= te('privacy.s7_text') ?> <a href="mailto:lubomir@polascin.net">lubomir@polascin.net</a>.</p>
  </div>
</main>
<?php include __DIR__ . '/footer.php'; ?>
</body>
</html>
