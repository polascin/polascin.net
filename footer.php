<?php

declare(strict_types=1);

require_once __DIR__ . '/guard.php';
guardInternalAccess(__FILE__);

$year = date('Y');
$footerLang = currentLang();

// Korelačné hodnoty veku: rovnaké výpočty ako v pätičke old.polascin.net
// (rok = 365,25 dňa; druhá a tretia hodnota majú historický posun +23/+22).
$rokVSekundach = 60 * 60 * 24 * 365.25;
$vekoveHodnoty = [
    (time() - mktime(0, 0, 0, 9, 7, 1973)) / $rokVSekundach,
    (time() - mktime(0, 0, 0, 2, 24, 1971)) / $rokVSekundach + 23,
    (time() - mktime(0, 0, 0, 5, 26, 1971)) / $rokVSekundach + 22,
    (time() - mktime(0, 0, 0, 2, 2, 1975)) / $rokVSekundach,
];

// Dátum aktualizácie a Swatch @beat ako v pätičke nefro.polascin.net.
// Presný čas nasadenia nesie deploy_info.php generovaný pri nasadení
// (workflow aj hooks/deploy.sh); bez neho, napr. pri lokálnom vývoji,
// sa berie čas úpravy zobrazovaného skriptu.
$deployInfoFile = __DIR__ . '/deploy_info.php';
if (is_file($deployInfoFile)) {
    // Chybný súbor z nasadenia nesmie zhodiť stránku (Parse error 2026-10-24);
    // pätička vtedy použije čas úpravy skriptu.
    try {
        require_once $deployInfoFile;
    } catch (ParseError $deployInfoError) {
        error_log('deploy_info.php sa nedá načítať: ' . $deployInfoError->getMessage());
    }
}
if (defined('DEPLOY_TIMESTAMP')) {
    $footerUpdateTs = (int) DEPLOY_TIMESTAMP;
} else {
    $footerScript = (string) ($_SERVER['SCRIPT_FILENAME'] ?? '');
    $footerUpdateTs = ($footerScript !== '' && is_file($footerScript)) ? (int) filemtime($footerScript) : time();
}
$footerUpdated = date('d.m.Y H:i', $footerUpdateTs);
// Bez vnorených zátvoriek: hodnota sa vypisuje v zátvorkách za dátumom.
$footerTimezone = date('T', $footerUpdateTs) . ', ' . date_default_timezone_get();
// Swiss Internet Time: BMT = UTC+1, 1 deň = 1000 beatov.
$footerBeat = appSwatchBeat($footerUpdateTs);
?>
<footer>
  <div class="container">
    <h2 class="footer-heading"><?= te('footer.heading') ?></h2>
    <div class="social-links">
      <a href="https://www.linkedin.com/in/lubomirpolascin/" target="_blank" rel="noopener noreferrer" aria-label="LinkedIn" title="<?= te('footer.linkedin') ?>">
        <i class="fa-brands fa-linkedin" aria-hidden="true"></i>
      </a>
      <a href="https://x.com/polascin" target="_blank" rel="noopener noreferrer" aria-label="X (Twitter)" title="<?= te('footer.x') ?>">
        <i class="fa-brands fa-x-twitter" aria-hidden="true"></i>
      </a>
      <a href="https://www.facebook.com/lubomir.polascin" target="_blank" rel="noopener noreferrer" aria-label="Facebook" title="<?= te('footer.facebook') ?>">
        <i class="fa-brands fa-facebook" aria-hidden="true"></i>
      </a>
      <a href="mailto:lubomir@polascin.net" aria-label="E-mail" title="<?= te('footer.email') ?>">
        <i class="fa-solid fa-envelope" aria-hidden="true"></i>
      </a>
    </div>
    <p class="footer-contact">
      <a href="mailto:lubomir@polascin.net">lubomir@polascin.net</a>
    </p>

    <p class="footer-ages">
      <?php foreach ($vekoveHodnoty as $vekHodnota): ?>
        <?php [$vekCele, $vekDesatiny] = appAgeParts($vekHodnota); ?>
        <span class="footer-age"><?= $vekCele ?><small><?= htmlspecialchars($vekDesatiny, ENT_QUOTES, 'UTF-8') ?></small></span>
      <?php endforeach; ?>
    </p>

    <p><?= te('footer.copyright', ['year' => $year]) ?></p>
    <p class="footer-meta">
      <a href="<?= htmlspecialchars(langUrl($footerLang, 'index.php'), ENT_QUOTES, 'UTF-8') ?>">polascin.net</a> |
      <a href="<?= htmlspecialchars(langUrl($footerLang, 'library.php'), ENT_QUOTES, 'UTF-8') ?>"><?= te('home.link_library') ?></a> |
      <a href="https://books.polascin.net/" target="_blank" rel="noopener noreferrer">books.polascin.net</a> |
      <a href="<?= htmlspecialchars(langUrl($footerLang, 'privacy.php'), ENT_QUOTES, 'UTF-8') ?>"><?= te('footer.privacy') ?></a> |
      <a href="<?= htmlspecialchars(langUrl($footerLang, 'terms.php'), ENT_QUOTES, 'UTF-8') ?>"><?= te('footer.terms') ?></a> |
      <button type="button" class="cookie-settings-trigger" aria-haspopup="dialog" aria-controls="cookie-consent-container"><?= te('footer.cookie_settings') ?></button>
    </p>
    <p class="footer-updated">
      <span><?= te('footer.updated') ?> <?= htmlspecialchars($footerUpdated, ENT_QUOTES, 'UTF-8') ?> (<?= htmlspecialchars($footerTimezone, ENT_QUOTES, 'UTF-8') ?>)</span>
      <span class="footer-updated-sep" aria-hidden="true">·</span>
      <a href="https://www.swatch.com/en-us/internet-time.html" target="_blank" rel="noopener noreferrer" title="<?= te('footer.beat_title') ?>"><?= htmlspecialchars($footerBeat, ENT_QUOTES, 'UTF-8') ?></a>
    </p>
  </div>
</footer>
<div
  id="cookie-consent-container"
  data-privacy-url="<?= htmlspecialchars(langUrl($footerLang, 'privacy.php'), ENT_QUOTES, 'UTF-8') ?>"
  data-cookie-title="<?= te('cookie.title') ?>"
  data-cookie-description="<?= te('cookie.description') ?>"
  data-cookie-privacy-label="<?= te('cookie.privacy_link') ?>"
  data-cookie-decline="<?= te('cookie.decline') ?>"
  data-cookie-accept="<?= te('cookie.accept') ?>"
></div>

<?php /* Šablóna cookie banneru. <template> nie je v DOM ani viditeľná; skrytie cez
   style="display:none" CSP (style-src bez unsafe-inline) zablokovala a na každej
   stránke ostal prázdny banner (Beh #116). */ ?>
<template id="cookie-banner-template">
  <div class="cookie-banner" role="dialog" aria-modal="false" aria-labelledby="cookie-consent-title" aria-describedby="cookie-consent-description">
    <div class="cookie-content">
      <div class="cookie-text">
        <h2 id="cookie-consent-title" class="cookie-title"></h2>
        <p id="cookie-consent-description"><span class="cookie-description-text"></span> <a class="cookie-link" target="_blank" rel="noopener noreferrer"></a>.</p>
      </div>
      <div class="cookie-buttons">
        <button type="button" class="btn btn-secondary btn-cookie-decline"></button>
        <button type="button" class="btn btn-primary btn-cookie-accept"></button>
      </div>
    </div>
  </div>
</template>

<?php if (!isLoggedIn()): ?>
<?php $clarityVersion = is_file(__DIR__ . '/js/clarity-consent.js') ? (string) filemtime(__DIR__ . '/js/clarity-consent.js') : '1'; ?>
<script src="/js/clarity-consent.js?v=<?= htmlspecialchars(rawurlencode($clarityVersion), ENT_QUOTES, 'UTF-8') ?>" data-project="axxzsx2xlq" data-consent="external" data-paths="/,/index.php,/articles.php,/article.php,/library.php,/privacy.php,/terms.php"></script>
<?php endif; ?>
