<?php

declare(strict_types=1);

// Vlastná stránka 404 (`ErrorDocument 404 /404.php` v .htaccess). Bez nej
// Apache vrátil holú anglickú stránku v iso-8859-1, bez navigácie a bez CSP.
require_once __DIR__ . '/config_loader.php';

try {
    loadAppConfig();
} catch (AppConfigException) {
    http_response_code(404);
    header('Content-Type: text/plain; charset=UTF-8');
    echo "Not found\n";
    exit;
}

require_once __DIR__ . '/auth.php';

http_response_code(404);

$baseUrl = getAppBaseUrl();
$lang = currentLang();
$pageTitle = t('error404.heading') . ' | ' . t('common.author');
$seoDescription = t('error404.text');
$robotsMeta = 'noindex, follow';
$canonicalUrl = absoluteLangUrl($lang, 'index.php');
// Chybová stránka nemá jazykové varianty.
$languageAlternates = [];
// <base href> nižšie mení cieľ odkazu "#…"; preskakovací odkaz preto nesie
// vlastnú cestu požiadavky.
$requestTarget = (string) ($_SERVER['REQUEST_URI'] ?? '/');
$requestTarget = substr($requestTarget, 0, strcspn($requestTarget, '#'));
$skipLinkHref = ($requestTarget !== '' && $requestTarget[0] === '/' ? $requestTarget : '/') . '#main-content';
?>
<!DOCTYPE html>
<html lang="<?= htmlspecialchars($lang, ENT_QUOTES, 'UTF-8') ?>">
<head>
<?php /* 404 môže prísť aj na vnorenej adrese (/a/b/); relatívne cesty k CSS,
   JS a odkazom sa preto musia rátať od koreňa webu. */ ?>
<base href="<?= htmlspecialchars(rtrim($baseUrl, '/') . '/', ENT_QUOTES, 'UTF-8') ?>">
<?php include __DIR__ . '/head_meta.php'; ?>
</head>
<body>
<?php include __DIR__ . '/header.php'; ?>
<main id="main-content" class="page-content" tabindex="-1" aria-label="<?= te('error404.heading') ?>">
  <div class="container">
    <h1 class="section-title"><?= te('error404.heading') ?></h1>
    <p><?= te('error404.text') ?></p>
    <p>
      <a href="<?= htmlspecialchars(langUrl($lang, 'index.php'), ENT_QUOTES, 'UTF-8') ?>" class="btn btn-primary"><?= te('error404.home') ?></a>
      <a href="<?= htmlspecialchars(langUrl($lang, 'articles.php'), ENT_QUOTES, 'UTF-8') ?>" class="btn btn-secondary"><?= te('article.back_to_list') ?></a>
    </p>
  </div>
</main>
<?php include __DIR__ . '/footer.php'; ?>
</body>
</html>
