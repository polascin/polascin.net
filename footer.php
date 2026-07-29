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

$year = date('Y');
$footerLang = currentLang();

// Korelačné hodnoty veku — rovnaké výpočty ako v pätičke old.polascin.net
// (rok = 365,25 dňa; druhá a tretia hodnota majú historický posun +23/+22).
$rokVSekundach = 60 * 60 * 24 * 365.25;
$vekoveHodnoty = [
    (time() - mktime(0, 0, 0, 9, 7, 1973)) / $rokVSekundach,
    (time() - mktime(0, 0, 0, 2, 24, 1971)) / $rokVSekundach + 23,
    (time() - mktime(0, 0, 0, 5, 26, 1971)) / $rokVSekundach + 22,
    (time() - mktime(0, 0, 0, 2, 2, 1975)) / $rokVSekundach,
];

// Dátum aktualizácie a Swatch @beat ako v pätičke nefro.polascin.net.
// Web nemá deploy_info.php, preto sa berie čas úpravy zobrazovaného skriptu.
$footerScript = (string) ($_SERVER['SCRIPT_FILENAME'] ?? '');
$footerUpdateTs = ($footerScript !== '' && is_file($footerScript)) ? (int) filemtime($footerScript) : time();
$footerUpdated = date('d.m.Y H:i', $footerUpdateTs);
$footerTimezone = date('T', $footerUpdateTs) . ' (' . date_default_timezone_get() . ')';
// Swiss Internet Time: BMT = UTC+1, 1 deň = 1000 beatov.
$footerBeat = '@' . number_format((($footerUpdateTs + 3600) % 86400) / 86.4, 2, '.', '');
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
      <a href="https://discord.gg/MsGmMZbz" target="_blank" rel="noopener noreferrer" aria-label="Discord" title="<?= te('footer.discord') ?>">
        <i class="fa-brands fa-discord" aria-hidden="true"></i>
      </a>
    </div>
    <p class="footer-contact">
      <a href="mailto:lubomir@polascin.net">lubomir@polascin.net</a>
    </p>

    <p class="footer-ages">
      <?php foreach ($vekoveHodnoty as $vekHodnota): ?>
        <span class="footer-age"><?= (int) floor($vekHodnota) ?><small><?= substr(number_format($vekHodnota, 3, '.', ''), -4) ?></small></span>
      <?php endforeach; ?>
    </p>

    <p><?= te('footer.copyright', ['year' => $year]) ?></p>
    <p class="footer-meta">
      <a href="<?= htmlspecialchars(langUrl($footerLang, 'index.php'), ENT_QUOTES, 'UTF-8') ?>">polascin.net</a> |
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
