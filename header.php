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
<a href="#main-content" class="skip-link">Preskočiť na hlavný obsah</a>

<nav class="navbar" aria-label="Hlavná navigácia">
  <div class="container nav-container">
    <a href="index.php" class="nav-brand">Polascin.net</a>
    <button
      type="button"
      class="nav-toggle"
      id="navToggle"
      aria-label="Otvoriť navigáciu"
      aria-controls="navMenu"
      aria-expanded="false"
    >
      <span></span>
      <span></span>
      <span></span>
    </button>
    <button
      type="button"
      class="theme-toggle-btn"
      id="themeToggle"
      aria-label="Prepnúť tmavý režim"
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
