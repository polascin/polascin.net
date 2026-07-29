<?php
declare(strict_types=1);

$partialName = basename(__FILE__);
$requestedScript = str_replace('\\', '/', (string) ($_SERVER['SCRIPT_NAME'] ?? $_SERVER['PHP_SELF'] ?? ''));
if (preg_match('~(?:^|/)' . preg_quote($partialName, '~') . '(?:/|$)~i', $requestedScript) === 1) {
    if (PHP_SAPI === 'cli') {
        fwrite(STDERR, "Chyba: {$partialName} je interný súbor a nemožno ho spúšťať priamo.\n");
        exit(1);
    }
    http_response_code(403);
    exit('Prístup odmietnutý.');
}
unset($partialName, $requestedScript);

$siteName = 'Polascin.net';
$baseUrl = getAppBaseUrl();
$requestUri = filter_var($_SERVER['REQUEST_URI'] ?? '/', FILTER_SANITIZE_URL) ?: '/';
// Kanonická URL nesmie preberať query parametre (utm_*, fbclid…), inak by sa
// tá istá stránka self-kanonizovala do nekonečna variantov.
$requestPath = substr($requestUri, 0, strcspn($requestUri, '?#'));
if ($requestPath === '' || $requestPath[0] !== '/') {
    $requestPath = '/';
}
$currentUrl = rtrim($baseUrl, '/') . '/' . ltrim($requestPath, '/');

$metaLang = currentLang();

$pageTitle = $pageTitle ?? $siteName;
$seoDescription = $seoDescription ?? t('meta.default_description');
$seoKeywords = $seoKeywords ?? t('meta.keywords');
$canonicalUrl = $canonicalUrl ?? $currentUrl;

/**
 * Jazykové varianty pre hreflang. Sú to kanonické adresy, teda pre predvolený
 * jazyk bez parametra `lang`.
 *
 * Táto premenná je určená výhradne pre SEO. Prepínač jazyka ju zámerne
 * nepoužíva — potreboval by parameter `lang` aj pre predvolený jazyk, inak by
 * sa naň nedalo prepnúť späť.
 */
if (!isset($languageAlternates) || !is_array($languageAlternates)) {
    // Parametre klastra sa čítajú z kanonickej URL, ktorú si stránka určila sama.
    // Stránka, ktorá má pre jednotlivé jazyky iné adresy (alebo preklad nemá
    // vôbec), si `$languageAlternates` nastaví — vrátane prázdneho poľa, ktoré
    // znamená „tento obsah existuje len v jednom jazyku“.
    $languageAlternates = languageAlternatesFor($canonicalUrl);
}
$robotsMeta = $robotsMeta ?? 'index, follow, max-image-preview:large';
$ogType = $ogType ?? 'website';
$ogImage = $ogImage ?? ($baseUrl . '/images/profile.jpg');
$ogImageWidth = $ogImageWidth ?? 768;
$ogImageHeight = $ogImageHeight ?? 1024;
$themeColor = $themeColor ?? '#ffffff';

$cssVersion = is_file(__DIR__ . '/css/styles.css') ? (string) filemtime(__DIR__ . '/css/styles.css') : '1';
$consentVersion = is_file(__DIR__ . '/js/consent-default.js') ? (string) filemtime(__DIR__ . '/js/consent-default.js') : '1';
$jsVersion = is_file(__DIR__ . '/js/main.js') ? (string) filemtime(__DIR__ . '/js/main.js') : '1';
?>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<meta name="description" content="<?= htmlspecialchars($seoDescription, ENT_QUOTES, 'UTF-8') ?>">
<meta name="keywords" content="<?= htmlspecialchars($seoKeywords, ENT_QUOTES, 'UTF-8') ?>">
<meta name="author" content="Ľubomír Polaščín">
<meta name="theme-color" content="<?= htmlspecialchars($themeColor, ENT_QUOTES, 'UTF-8') ?>">
<meta name="robots" content="<?= htmlspecialchars($robotsMeta, ENT_QUOTES, 'UTF-8') ?>">
<title><?= htmlspecialchars($pageTitle, ENT_QUOTES, 'UTF-8') ?></title>
<link rel="canonical" href="<?= htmlspecialchars($canonicalUrl, ENT_QUOTES, 'UTF-8') ?>">
<?php
// Na neindexovaných stránkach nemá hreflang zmysel — vyhľadávače ho ignorujú
// a klaster by odkazoval na adresy, ktoré sa nemajú objaviť vo výsledkoch.
$emitAlternates = !str_contains(strtolower($robotsMeta), 'noindex');
?>
<?php if ($emitAlternates): ?>
<?php foreach ($languageAlternates as $alternateLang => $alternateUrl): ?>
<link rel="alternate" hreflang="<?= htmlspecialchars((string) $alternateLang, ENT_QUOTES, 'UTF-8') ?>" href="<?= htmlspecialchars((string) $alternateUrl, ENT_QUOTES, 'UTF-8') ?>">
<?php endforeach; ?>
<?php
// x-default musí byť rovnaké pre všetky jazykové varianty tej istej stránky.
// Keď predvolený jazyk v klastri chýba, berie sa prvý podľa poradia v
// appLanguages(), ktoré je rovnaké nech sa stránka vykresľuje v ktoromkoľvek jazyku.
$xDefault = $languageAlternates[APP_DEFAULT_LANGUAGE] ?? null;
if ($xDefault === null) {
    foreach (array_keys(appLanguages()) as $preferredLang) {
        if (isset($languageAlternates[$preferredLang])) {
            $xDefault = $languageAlternates[$preferredLang];
            break;
        }
    }
}
?>
<?php if ($xDefault !== null): ?>
<link rel="alternate" hreflang="x-default" href="<?= htmlspecialchars((string) $xDefault, ENT_QUOTES, 'UTF-8') ?>">
<?php endif; ?>
<?php endif; ?>

<meta property="og:type" content="<?= htmlspecialchars($ogType, ENT_QUOTES, 'UTF-8') ?>">
<meta property="og:title" content="<?= htmlspecialchars($pageTitle, ENT_QUOTES, 'UTF-8') ?>">
<meta property="og:description" content="<?= htmlspecialchars($seoDescription, ENT_QUOTES, 'UTF-8') ?>">
<meta property="og:url" content="<?= htmlspecialchars($canonicalUrl, ENT_QUOTES, 'UTF-8') ?>">
<meta property="og:site_name" content="<?= htmlspecialchars($siteName, ENT_QUOTES, 'UTF-8') ?>">
<meta property="og:locale" content="<?= htmlspecialchars(currentLocale(), ENT_QUOTES, 'UTF-8') ?>">
<?php foreach (appLanguages() as $ogLang => $ogMeta): ?>
<?php if ($ogLang !== $metaLang): ?>
<meta property="og:locale:alternate" content="<?= htmlspecialchars((string) $ogMeta['locale'], ENT_QUOTES, 'UTF-8') ?>">
<?php endif; ?>
<?php endforeach; ?>
<meta property="og:image" content="<?= htmlspecialchars($ogImage, ENT_QUOTES, 'UTF-8') ?>">
<meta property="og:image:width" content="<?= (int) $ogImageWidth ?>">
<meta property="og:image:height" content="<?= (int) $ogImageHeight ?>">
<meta property="og:image:alt" content="<?= htmlspecialchars($pageTitle, ENT_QUOTES, 'UTF-8') ?>">

<meta name="twitter:card" content="summary_large_image">
<meta name="twitter:title" content="<?= htmlspecialchars($pageTitle, ENT_QUOTES, 'UTF-8') ?>">
<meta name="twitter:description" content="<?= htmlspecialchars($seoDescription, ENT_QUOTES, 'UTF-8') ?>">
<meta name="twitter:image" content="<?= htmlspecialchars($ogImage, ENT_QUOTES, 'UTF-8') ?>">
<meta name="twitter:image:alt" content="<?= htmlspecialchars($pageTitle, ENT_QUOTES, 'UTF-8') ?>">

<link rel="icon" href="CrystalKidney.png" type="image/png">
<link rel="apple-touch-icon-precomposed" sizes="57x57" href="apple-touch-icon-57x57.png">
<link rel="apple-touch-icon-precomposed" sizes="114x114" href="apple-touch-icon-114x114.png">
<link rel="apple-touch-icon-precomposed" sizes="72x72" href="apple-touch-icon-72x72.png">
<link rel="apple-touch-icon-precomposed" sizes="144x144" href="apple-touch-icon-144x144.png">
<link rel="apple-touch-icon-precomposed" sizes="60x60" href="apple-touch-icon-60x60.png">
<link rel="apple-touch-icon-precomposed" sizes="120x120" href="apple-touch-icon-120x120.png">
<link rel="apple-touch-icon-precomposed" sizes="76x76" href="apple-touch-icon-76x76.png">
<link rel="apple-touch-icon-precomposed" sizes="152x152" href="apple-touch-icon-152x152.png">
<link rel="icon" type="image/png" sizes="196x196" href="favicon-196x196.png">
<link rel="icon" type="image/png" sizes="96x96" href="favicon-96x96.png">
<link rel="icon" type="image/png" sizes="32x32" href="favicon-32x32.png">
<link rel="icon" type="image/png" sizes="16x16" href="favicon-16x16.png">
<link rel="icon" type="image/png" sizes="128x128" href="favicon-128.png">

<link rel="preconnect" href="https://fonts.googleapis.com">
<link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
<link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;600;800&family=Open+Sans:wght@400;500;600&display=swap" rel="stylesheet">
<link rel="stylesheet" href="fontawesome-free-7.1.0-web/css/fontawesome.css">
<link rel="stylesheet" href="fontawesome-free-7.1.0-web/css/solid.css">
<link rel="stylesheet" href="fontawesome-free-7.1.0-web/css/brands.css">

<link rel="stylesheet" href="css/styles.css?v=<?= htmlspecialchars(rawurlencode($cssVersion), ENT_QUOTES, 'UTF-8') ?>">
<script src="js/consent-default.js?v=<?= htmlspecialchars(rawurlencode($consentVersion), ENT_QUOTES, 'UTF-8') ?>" defer></script>
<script src="js/main.js?v=<?= htmlspecialchars(rawurlencode($jsVersion), ENT_QUOTES, 'UTF-8') ?>" defer></script>

<?php if (!empty($structuredData)): ?>
<script type="application/ld+json" nonce="<?= htmlspecialchars(getScriptNonce(), ENT_QUOTES, 'UTF-8') ?>">
<?= json_encode($structuredData, JSON_UNESCAPED_UNICODE | JSON_UNESCAPED_SLASHES | JSON_PRETTY_PRINT | JSON_HEX_TAG | JSON_HEX_AMP | JSON_HEX_APOS | JSON_HEX_QUOT) ?>
</script>
<?php endif; ?>
