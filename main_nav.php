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
$_navLang = currentLang();

if (!function_exists('_navA')) {
    function _navA(string $href, string $label, bool $active): string {
        $class = $active ? 'nav-link active' : 'nav-link';
        $ariaCurrent = $active ? ' aria-current="page"' : '';
        return '<a href="' . htmlspecialchars($href, ENT_QUOTES, 'UTF-8') . '" class="' . $class . '"' . $ariaCurrent . '>' . htmlspecialchars($label, ENT_QUOTES, 'UTF-8') . '</a>';
    }
}

/**
 * Odkaz v rámci stránky si nesie zvolený jazyk, aby sa voľba nestratila
 * pri prechode medzi stránkami ani pri zdieľaní odkazu.
 */
if (!function_exists('_navHref')) {
    function _navHref(string $script, string $fragment, bool $onIndex, string $lang): string {
        if ($onIndex && $script === 'index.php') {
            return $fragment !== '' ? $fragment : langUrl($lang, 'index.php');
        }
        return langUrl($lang, $script) . $fragment;
    }
}
?>
<ul class="nav-menu" id="navMenu">
  <li><?= _navA(_navHref('index.php', '#home', $_onIndex, $_navLang), t('nav.home'), $_navCurrent === 'index.php') ?></li>
  <li><?= _navA(langUrl($_navLang, 'articles.php'), t('nav.blog'), $_navCurrent === 'articles.php' || $_navCurrent === 'article.php') ?></li>
  <li><?= _navA(_navHref('index.php', '#about', $_onIndex, $_navLang), t('nav.about'), false) ?></li>
  <li><?= _navA(_navHref('index.php', '#nephrology', $_onIndex, $_navLang), t('nav.nephrology'), false) ?></li>
  <li><?= _navA(_navHref('index.php', '#projects', $_onIndex, $_navLang), t('nav.projects'), false) ?></li>
  <li><?= _navA('https://books.polascin.net/', t('nav.books'), false) ?></li>
  <li><?= _navA(_navHref('index.php', '#links', $_onIndex, $_navLang), t('nav.links'), false) ?></li>
  <li><?= _navA(_navHref('index.php', '#contact', $_onIndex, $_navLang), t('nav.contact'), false) ?></li>
  <?php if (function_exists('isLoggedIn') && isLoggedIn() && function_exists('isAdmin') && isAdmin()): ?>
    <li><?= _navA(langUrl($_navLang, 'admin.php'), t('nav.admin'), in_array($_navCurrent, ['admin.php', 'admin_articles.php', 'admin_content.php', 'admin_contact.php', 'admin_newsletter.php'], true)) ?></li>
    <li>
      <form action="logout.php" method="post" class="nav-logout-form">
        <input type="hidden" name="csrf_token" value="<?= htmlspecialchars(generateCsrfToken(), ENT_QUOTES, 'UTF-8') ?>">
      <button type="submit" class="nav-link nav-logout-btn"><?= te('nav.logout') ?></button>
      </form>
    </li>
  <?php else: ?>
    <li><?= _navA(langUrl($_navLang, 'login.php'), t('nav.login'), $_navCurrent === 'login.php') ?></li>
  <?php endif; ?>
</ul>
