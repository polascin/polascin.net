<?php
declare(strict_types=1);
$year = date('Y');
?>
<footer>
  <div class="container">
    <h2 class="footer-heading">Spojte sa</h2>
    <div class="social-links">
      <a href="https://www.linkedin.com/in/lubomirpolascin/" target="_blank" rel="noopener noreferrer" aria-label="LinkedIn" title="Profil na LinkedIn">
        <i class="fa-brands fa-linkedin" aria-hidden="true"></i>
      </a>
      <a href="https://x.com/polascin" target="_blank" rel="noopener noreferrer" aria-label="X (Twitter)" title="Profil na X">
        <i class="fa-brands fa-x-twitter" aria-hidden="true"></i>
      </a>
      <a href="https://www.facebook.com/lubomir.polascin" target="_blank" rel="noopener noreferrer" aria-label="Facebook" title="Profil na Facebooku">
        <i class="fa-brands fa-facebook" aria-hidden="true"></i>
      </a>
      <a href="mailto:lubomir@polascin.net" aria-label="E-mail" title="Poslať e-mail">
        <i class="fa-solid fa-envelope" aria-hidden="true"></i>
      </a>
      <a href="https://www.patreon.com/c/Csoelle" target="_blank" rel="noopener noreferrer" aria-label="Patreon" title="Podporiť na Patreon">
        <i class="fa-brands fa-patreon" aria-hidden="true"></i>
      </a>
      <a href="https://discord.gg/MsGmMZbz" target="_blank" rel="noopener noreferrer" aria-label="Discord" title="Pripojiť sa na Discord">
        <i class="fa-brands fa-discord" aria-hidden="true"></i>
      </a>
    </div>
    <p class="footer-contact">
      <a href="mailto:lubomir@polascin.net">lubomir@polascin.net</a>
    </p>

    <p>&copy; 1998 – <?= $year ?> Ľubomír Polaščín. Všetky práva vyhradené.</p>
    <p class="footer-meta">
      <a href="index.php">polascin.net</a> |
      <a href="https://books.polascin.net/" target="_blank" rel="noopener noreferrer">books.polascin.net</a> |
      <a href="privacy.php">Ochrana súkromia</a> |
      <a href="terms.php">Podmienky používania</a> |
      <button class="cookie-settings-trigger" aria-haspopup="dialog" aria-controls="cookie-consent-container">Nastavenia cookies</button>
    </p>
  </div>
</footer>
<div id="cookie-consent-container"></div>
