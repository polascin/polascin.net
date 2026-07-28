<?php
declare(strict_types=1);

$siteName = 'Polascin.net';
$baseUrl = getAppBaseUrl();
$allowedHost = parse_url($baseUrl, PHP_URL_HOST) ?: 'polascin.net';
$scheme = isRequestHttps() ? 'https' : 'http';
$requestUri = filter_var($_SERVER['REQUEST_URI'] ?? '/', FILTER_SANITIZE_URL) ?: '/';
$currentUrl = $scheme . '://' . $allowedHost . $requestUri;

$pageTitle = $pageTitle ?? $siteName;
$seoDescription = $seoDescription ?? 'MUDr. Ľubomír Polaščin — nefrológ, internista, lekársky prekladateľ, spisovateľ a samouk programátor.';
$seoKeywords = $seoKeywords ?? 'Ľubomír Polaščin, nefrológia, interná medicína, dialýza, lekársky preklad, programovanie';
$canonicalUrl = $canonicalUrl ?? $currentUrl;
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
<meta name="author" content="Ľubomír Polaščin">
<meta name="theme-color" content="<?= htmlspecialchars($themeColor, ENT_QUOTES, 'UTF-8') ?>">
<meta name="robots" content="<?= htmlspecialchars($robotsMeta, ENT_QUOTES, 'UTF-8') ?>">
<title><?= htmlspecialchars($pageTitle, ENT_QUOTES, 'UTF-8') ?></title>
<link rel="canonical" href="<?= htmlspecialchars($canonicalUrl, ENT_QUOTES, 'UTF-8') ?>">
<link rel="alternate" hreflang="sk" href="<?= htmlspecialchars($canonicalUrl, ENT_QUOTES, 'UTF-8') ?>">
<link rel="alternate" hreflang="x-default" href="<?= htmlspecialchars($canonicalUrl, ENT_QUOTES, 'UTF-8') ?>">

<meta property="og:type" content="<?= htmlspecialchars($ogType, ENT_QUOTES, 'UTF-8') ?>">
<meta property="og:title" content="<?= htmlspecialchars($pageTitle, ENT_QUOTES, 'UTF-8') ?>">
<meta property="og:description" content="<?= htmlspecialchars($seoDescription, ENT_QUOTES, 'UTF-8') ?>">
<meta property="og:url" content="<?= htmlspecialchars($canonicalUrl, ENT_QUOTES, 'UTF-8') ?>">
<meta property="og:site_name" content="<?= htmlspecialchars($siteName, ENT_QUOTES, 'UTF-8') ?>">
<meta property="og:locale" content="sk_SK">
<meta property="og:image" content="<?= htmlspecialchars($ogImage, ENT_QUOTES, 'UTF-8') ?>">
<meta property="og:image:width" content="<?= (int) $ogImageWidth ?>">
<meta property="og:image:height" content="<?= (int) $ogImageHeight ?>">
<meta property="og:image:alt" content="<?= htmlspecialchars($pageTitle, ENT_QUOTES, 'UTF-8') ?>">

<meta name="twitter:card" content="summary_large_image">
<meta name="twitter:title" content="<?= htmlspecialchars($pageTitle, ENT_QUOTES, 'UTF-8') ?>">
<meta name="twitter:description" content="<?= htmlspecialchars($seoDescription, ENT_QUOTES, 'UTF-8') ?>">
<meta name="twitter:image" content="<?= htmlspecialchars($ogImage, ENT_QUOTES, 'UTF-8') ?>">

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
