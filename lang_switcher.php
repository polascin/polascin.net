<?php

declare(strict_types=1);

require_once __DIR__ . '/guard.php';
guardInternalAccess(__FILE__);

$switcherCurrent = currentLang();
$switcherLanguages = appLanguages();

/**
 * Cieľové URL prepínača.
 *
 * Zámerne sa nepoužíva `$languageAlternates` z `head_meta.php`, tie sú
 * kanonické a pre predvolený jazyk neobsahujú parameter `lang`, takže by sa
 * ním nedalo prepnúť späť na slovenčinu.
 *
 * Stránka, ktorá má pre jednotlivé jazyky iné adresy (detail článku s preloženým
 * slugom), si ich nastaví do `$languageSwitchTargets`. Inak sa zachová aktuálna
 * stránka aj s parametrami, aby sa napríklad odhlasovací token nestratil.
 */
$switcherTargets = isset($languageSwitchTargets) && is_array($languageSwitchTargets) ? $languageSwitchTargets : [];
?>
<details class="lang-switcher">
  <summary class="lang-switcher-toggle">
    <i class="fa-solid fa-globe" aria-hidden="true"></i>
    <span class="visually-hidden"><?= te('lang.switch') ?>:</span>
    <span class="lang-switcher-code"><?= htmlspecialchars($switcherCurrent, ENT_QUOTES, 'UTF-8') ?></span>
  </summary>
  <ul class="lang-switcher-menu">
    <?php foreach ($switcherLanguages as $code => $meta): ?>
      <?php
      $href = $switcherTargets[$code] ?? langUrl($code);
      $isCurrent = $code === $switcherCurrent;
      ?>
      <li>
        <a
          class="lang-switcher-link"
          href="<?= htmlspecialchars($href, ENT_QUOTES, 'UTF-8') ?>"
          hreflang="<?= htmlspecialchars($code, ENT_QUOTES, 'UTF-8') ?>"
          lang="<?= htmlspecialchars($code, ENT_QUOTES, 'UTF-8') ?>"
          <?= $isCurrent ? 'aria-current="true"' : '' ?>
        ><?= htmlspecialchars((string) $meta['native'], ENT_QUOTES, 'UTF-8') ?></a>
      </li>
    <?php endforeach; ?>
  </ul>
</details>
