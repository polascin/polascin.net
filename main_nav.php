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

if (defined('MAIN_NAV_INCLUDED')) {
    return;
}
define('MAIN_NAV_INCLUDED', 1);

$_navCurrent = isset($navActiveItem) ? $navActiveItem : basename((string) ($_SERVER['PHP_SELF'] ?? ''));
$_onIndex = $_navCurrent === 'index.php';

if (!function_exists('_navA')) {
    function _navA(string $href, string $label, bool $active): string {
        $class = $active ? 'nav-link active' : 'nav-link';
        $ariaCurrent = $active ? ' aria-current="page"' : '';
        return '<a href="' . htmlspecialchars($href, ENT_QUOTES, 'UTF-8') . '" class="' . $class . '"' . $ariaCurrent . '>' . htmlspecialchars($label, ENT_QUOTES, 'UTF-8') . '</a>';
    }
}
?>
<ul class="nav-menu" id="navMenu">
  <li><?= _navA($_onIndex ? '#home' : 'index.php', 'Domov', $_navCurrent === 'index.php') ?></li>
  <li><?= _navA('articles.php', 'Blog', $_navCurrent === 'articles.php' || $_navCurrent === 'article.php') ?></li>
  <li><?= _navA($_onIndex ? '#about' : 'index.php#about', 'Životopis', false) ?></li>
  <li><?= _navA($_onIndex ? '#nephrology' : 'index.php#nephrology', 'Nefrológia', false) ?></li>
  <li><?= _navA($_onIndex ? '#projects' : 'index.php#projects', 'Projekty', false) ?></li>
  <li><?= _navA('https://books.polascin.net/', 'Knihy', false) ?></li>
  <li><?= _navA($_onIndex ? '#links' : 'index.php#links', 'Odkazy', false) ?></li>
  <li><?= _navA($_onIndex ? '#contact' : 'index.php#contact', 'Kontakt', false) ?></li>
  <?php if (function_exists('isLoggedIn') && isLoggedIn() && function_exists('isAdmin') && isAdmin()): ?>
    <li><?= _navA('admin.php', 'Administrácia', in_array($_navCurrent, ['admin.php', 'admin_articles.php', 'admin_content.php', 'admin_contact.php', 'admin_newsletter.php'], true)) ?></li>
    <li>
      <form action="logout.php" method="post" class="nav-logout-form">
        <input type="hidden" name="csrf_token" value="<?= htmlspecialchars(generateCsrfToken(), ENT_QUOTES, 'UTF-8') ?>">
      <button type="submit" class="nav-link nav-logout-btn">Odhlásiť sa</button>
      </form>
    </li>
  <?php else: ?>
    <li><?= _navA('login.php', 'Prihlásenie', $_navCurrent === 'login.php') ?></li>
  <?php endif; ?>
</ul>
