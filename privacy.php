<?php

declare(strict_types=1);

$envFiles = [
    __DIR__ . '/env.ini',
    __DIR__ . '/private/env.ini',
    __DIR__ . '/private/polascin.env.ini',
    dirname(__DIR__) . '/polascin.env.ini',
    dirname(__DIR__) . '/private/polascin.env.ini',
];
$envReady = getenv('POLASCIN_ENV_PATH') !== false;
foreach ($envFiles as $envFile) {
    if (file_exists($envFile)) {
        $envReady = true;
        break;
    }
}

if (!$envReady) {
    readfile(__DIR__ . '/privacy.html');
    exit;
}

require_once __DIR__ . '/auth.php';

$baseUrl = getAppBaseUrl();
$pageTitle = 'Ochrana súkromia | MUDr. Ľubomír Polaščin';
$seoDescription = 'Zásady ochrany súkromia webovej stránky MUDr. Ľubomíra Polaščina.';
$robotsMeta = 'noindex, follow';
$canonicalUrl = $baseUrl . '/privacy.php';
?>
<!DOCTYPE html>
<html lang="sk">
<head>
<?php include __DIR__ . '/head_meta.php'; ?>
</head>
<body>
<?php include __DIR__ . '/header.php'; ?>
<main id="main-content" class="page-content" tabindex="-1" aria-label="Ochrana súkromia">
  <div class="container">
    <h1 class="section-title">Ochrana súkromia</h1>
    <p><strong>Posledná aktualizácia: 28. júla 2026</strong></p>

    <h3>1. Úvod</h3>
    <p>Vitajte na stránke <strong>polascin.net</strong>. Rešpektujem vaše súkromie a zaväzujem sa chrániť vaše osobné údaje. Táto politika ochrany súkromia vysvetľuje, ako nakladám s vašimi osobnými údajmi pri návšteve tejto webovej stránky, a popisuje vaše práva na ochranu súkromia a príslušnú právnu ochranu.</p>

    <h3>2. Informácie, ktoré zhromažďujem</h3>
    <p>Táto webová stránka má predovšetkým informačný charakter. Nevyžadujem od vás vytvorenie účtu.</p>
    <ul>
      <li><strong>Technické údaje:</strong> Zahŕňajú adresu internetového protokolu (IP), typ a verziu prehliadača, nastavenie časového pásma, operačný systém a platformu. Tieto údaje sa zhromažďujú automaticky prostredníctvom serverových protokolov na účely zabezpečenia a výkonu.</li>
      <li><strong>Cookies:</strong> Používam minimálne lokálne úložisko na zapamätanie vašej preferencie témy (tmavý/svetlý režim).
        <strong>Google Analytics 4 (GA4):</strong> Používam Google Analytics na analýzu návštevnosti webovej stránky a správania používateľov. Implementujem <strong>Google Consent Mode v2</strong>, aby som rešpektoval vaše preferencie ohľadom súkromia. V predvolenom nastavení je súhlas so sledovaním nastavený na <strong>„odmietnutý“</strong>. Skripty sa môžu načítať s cieľom zabezpečiť základnú funkčnosť stránky, no nebudú ukladať cookies ani pristupovať k osobným údajom na účely sledovania, pokiaľ výslovne nekliknete na tlačidlo Prijať v lište súhlasu. Svoje preferencie môžete kedykoľvek spravovať.</li>
    </ul>

    <h3>3. Ako používam vaše informácie</h3>
    <p>Vaše údaje používam na:</p>
    <ul>
      <li>Poskytovanie obsahu webovej stránky.</li>
      <li>Zabezpečenie bezpečnosti webovej stránky.</li>
      <li>Zapamätanie vašich preferencií (napr. témy).</li>
      <li>Analýzu návštevnosti a spôsobov používania webovej stránky prostredníctvom Google Analytics 4, avšak iba v prípade, že kliknete na tlačidlo <strong>Prijať</strong> v lište súhlasu s cookies. Právny základ: váš súhlas (článok 6 ods. 1 písm. a) GDPR). Analytické údaje uchováva spoločnosť Google podľa vlastných pravidiel uchovávania (zvyčajne najviac 14 mesiacov). Súhlas môžete kedykoľvek odvolať prostredníctvom tlačidla <strong>Nastavenia cookies</strong> v pätičke a výberom možnosti <strong>Odmietnuť</strong>.</li>
    </ul>

    <h3>4. Odkazy tretích strán</h3>
    <p>Táto webová stránka môže obsahovať odkazy na webové stránky, doplnky a aplikácie tretích strán (napr. Amazon, sociálne siete). Kliknutím na tieto odkazy môžu tretie strany zhromažďovať alebo zdieľať údaje o vás. Nemám kontrolu nad týmito webovými stránkami tretích strán a nenesiem zodpovednosť za ich vyhlásenia o ochrane súkromia.</p>

    <h3>5. Vaše zákonné práva (GDPR/CCPA)</h3>
    <p>Za určitých okolností máte práva vyplývajúce zo zákonov o ochrane osobných údajov vo vzťahu k vašim osobným údajom, vrátane práva požiadať o prístup, opravu, vymazanie alebo obmedzenie spracúvania vašich osobných údajov.</p>

    <h3>6. Kontakt</h3>
    <p>Ak máte akékoľvek otázky týkajúce sa tejto politiky ochrany súkromia, kontaktujte ma na adrese: <a href="mailto:lubomir@polascin.net">lubomir@polascin.net</a>.</p>
  </div>
</main>
<?php include __DIR__ . '/footer.php'; ?>
</body>
</html>
