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

if (!function_exists('isLoggedIn')) {
    require_once __DIR__ . '/auth.php';
}

$flash = function_exists('popFlashMessage') ? popFlashMessage() : null;

// Aktuálne počítaný vek — rovnaký výpočet ako na old.polascin.net
// (narodenie 4. 3. 1971 o 8:30, rok = 365,25 dňa).
$vekAktualny = (time() - mktime(8, 30, 0, 3, 4, 1971)) / (60 * 60 * 24 * 365.25);
$vekRoky = (int) floor($vekAktualny);
$vekZlomok = substr(number_format($vekAktualny, 3, '.', ''), -4);

// Aktuálny Swatch Internet Time ako v hlavičke nefro.polascin.net
// (BMT = UTC+1, 1 deň = 1000 beatov); js/main.js ho ďalej aktualizuje naživo.
$beatAktualny = number_format(((time() + 3600) % 86400) / 86.4, 2, '.', '');
?>
<a href="#main-content" class="skip-link"><?= te('common.skip_to_content') ?></a>

<nav class="navbar" aria-label="<?= te('common.main_navigation') ?>">
  <div class="container nav-container">
    <div class="nav-brand-group">
      <a
        href="<?= htmlspecialchars(langUrl(currentLang(), 'index.php'), ENT_QUOTES, 'UTF-8') ?>"
        class="nav-brand"
        aria-label="<?= te('common.site_name') ?>"
      >
        <img
          src="pix/lpimg001.webp"
          alt=""
          class="nav-brand-photo"
          width="44"
          height="44"
          loading="eager"
          decoding="async"
          fetchpriority="high"
        >
        <span class="nav-brand-text"><?= te('common.site_name') ?></span>
      </a>
      <span class="nav-age">
        <span class="nav-age-years"><?= $vekRoky ?></span>
        <span class="nav-age-exact">(<?= $vekRoky ?><small><?= $vekZlomok ?></small>)</span>
      </span>
      <a class="nav-beat" id="beatClock" href="https://www.swatch.com/en-us/internet-time.html" target="_blank" rel="noopener noreferrer" title="<?= te('footer.beat_title') ?>">@<?= $beatAktualny ?></a>
    </div>
    <button
      type="button"
      class="nav-toggle"
      id="navToggle"
      aria-label="<?= te('common.open_navigation') ?>"
      data-label-open="<?= te('common.open_navigation') ?>"
      data-label-close="<?= te('common.close_navigation') ?>"
      aria-controls="navMenu"
      aria-expanded="false"
    >
      <span></span>
      <span></span>
      <span></span>
    </button>
    <?php include __DIR__ . '/lang_switcher.php'; ?>
    <button
      type="button"
      class="theme-toggle-btn"
      id="themeToggle"
      aria-label="<?= te('common.toggle_dark_mode') ?>"
      data-label-dark="<?= te('common.switch_to_dark') ?>"
      data-label-light="<?= te('common.switch_to_light') ?>"
      aria-pressed="false"
    >
      <i class="fa-solid fa-moon" aria-hidden="true"></i>
    </button>
    <?php include __DIR__ . '/main_nav.php'; ?>
  </div>
</nav>

<?php if (is_array($flash) && !empty($flash['message'])): ?>
  <div class="container flash-container">
    <div class="alert <?= in_array(($flash['type'] ?? ''), ['error', 'warning'], true) ? 'alert-error' : 'alert-success' ?>">
      <p><?= htmlspecialchars((string) $flash['message'], ENT_QUOTES, 'UTF-8') ?></p>
    </div>
  </div>
<?php endif; ?>
