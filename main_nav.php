<?php
declare(strict_types=1);
if (defined('MAIN_NAV_INCLUDED')) {
    return;
}
define('MAIN_NAV_INCLUDED', 1);

$_navCurrent = isset($navActiveItem) ? $navActiveItem : basename((string) ($_SERVER['PHP_SELF'] ?? ''));
$_onIndex = $_navCurrent === 'index.php';

if (!function_exists('_navA')) {
    function _navA(string $href, string $label, bool $active): string {
        $class = $active ? 'nav-link active" aria-current="page' : 'nav-link';
        return '<a href="' . htmlspecialchars($href, ENT_QUOTES, 'UTF-8') . '" class="' . $class . '">' . htmlspecialchars($label, ENT_QUOTES, 'UTF-8') . '</a>';
    }
}
?>
<ul class="nav-menu" id="navMenu">
  <li><?= _navA($_onIndex ? '#home' : 'index.php', 'Home', $_navCurrent === 'index.php') ?></li>
  <li><?= _navA('articles.php', 'Blog', $_navCurrent === 'articles.php' || $_navCurrent === 'article.php') ?></li>
  <li><?= _navA($_onIndex ? '#about' : 'index.php#about', 'Bio', false) ?></li>
  <li><?= _navA($_onIndex ? '#nephrology' : 'index.php#nephrology', 'Nephrology', false) ?></li>
  <li><?= _navA($_onIndex ? '#projects' : 'index.php#projects', 'Projects', false) ?></li>
  <li><?= _navA('https://books.polascin.net/', 'Books', false) ?></li>
  <li><?= _navA($_onIndex ? '#links' : 'index.php#links', 'Links', false) ?></li>
  <li><?= _navA($_onIndex ? '#contact' : 'index.php#contact', 'Contact', false) ?></li>
  <?php if (function_exists('isLoggedIn') && isLoggedIn() && function_exists('isAdmin') && isAdmin()): ?>
    <li><?= _navA('admin.php', 'Admin', in_array($_navCurrent, ['admin.php', 'admin_articles.php', 'admin_content.php', 'admin_contact.php', 'admin_newsletter.php'], true)) ?></li>
    <li>
      <form action="logout.php" method="post" class="nav-logout-form">
        <input type="hidden" name="csrf_token" value="<?= htmlspecialchars(generateCsrfToken(), ENT_QUOTES, 'UTF-8') ?>">
        <button type="submit" class="nav-link nav-logout-btn">Logout</button>
      </form>
    </li>
  <?php else: ?>
    <li><?= _navA('login.php', 'Login', $_navCurrent === 'login.php') ?></li>
  <?php endif; ?>
</ul>
