<?php
declare(strict_types=1);
if (!function_exists('isLoggedIn')) {
    require_once __DIR__ . '/auth.php';
}

$flash = function_exists('popFlashMessage') ? popFlashMessage() : null;
?>
<a href="#main-content" class="skip-link">Skip to main content</a>

<nav class="navbar">
  <div class="container nav-container">
    <a href="index.php" class="nav-brand">Polascin.net</a>
    <button
      class="nav-toggle"
      id="navToggle"
      aria-label="Toggle navigation"
      aria-expanded="false"
    >
      <span></span>
      <span></span>
      <span></span>
    </button>
    <button
      class="theme-toggle-btn"
      id="themeToggle"
      aria-label="Toggle dark mode"
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
