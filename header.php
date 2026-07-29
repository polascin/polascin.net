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
?>
<a href="#main-content" class="skip-link"><?= te('common.skip_to_content') ?></a>

<nav class="navbar" aria-label="<?= te('common.main_navigation') ?>">
  <div class="container nav-container">
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
