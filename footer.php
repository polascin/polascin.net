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
      <a href="https://www.patreon.com/c/Csoelle" target="_blank" rel="noopener noreferrer" aria-label="Patreon" title="<?= te('footer.patreon') ?>">
        <i class="fa-brands fa-patreon" aria-hidden="true"></i>
      </a>
      <a href="https://discord.gg/MsGmMZbz" target="_blank" rel="noopener noreferrer" aria-label="Discord" title="<?= te('footer.discord') ?>">
        <i class="fa-brands fa-discord" aria-hidden="true"></i>
      </a>
    </div>
    <p class="footer-contact">
      <a href="mailto:lubomir@polascin.net">lubomir@polascin.net</a>
    </p>

    <p><?= te('footer.copyright', ['year' => $year]) ?></p>
    <p class="footer-meta">
      <a href="<?= htmlspecialchars(langUrl($footerLang, 'index.php'), ENT_QUOTES, 'UTF-8') ?>">polascin.net</a> |
      <a href="https://books.polascin.net/" target="_blank" rel="noopener noreferrer">books.polascin.net</a> |
      <a href="<?= htmlspecialchars(langUrl($footerLang, 'privacy.php'), ENT_QUOTES, 'UTF-8') ?>"><?= te('footer.privacy') ?></a> |
      <a href="<?= htmlspecialchars(langUrl($footerLang, 'terms.php'), ENT_QUOTES, 'UTF-8') ?>"><?= te('footer.terms') ?></a> |
      <button type="button" class="cookie-settings-trigger" aria-haspopup="dialog" aria-controls="cookie-consent-container"><?= te('footer.cookie_settings') ?></button>
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
