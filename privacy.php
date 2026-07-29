<?php

declare(strict_types=1);

require_once __DIR__ . '/config_loader.php';

try {
    loadAppConfig();
} catch (AppConfigException) {
    readfile(__DIR__ . '/privacy.html');
    exit;
}

require_once __DIR__ . '/auth.php';

$baseUrl = getAppBaseUrl();
$pageTitle = 'Ochrana súkromia | MUDr. Ľubomír Polaščín';
$seoDescription = 'Zásady ochrany súkromia webovej stránky MUDr. Ľubomíra Polaščína.';
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

    <h2>1. Úvod</h2>
    <p>Vitajte na stránke <strong>polascin.net</strong>. Rešpektujem vaše súkromie a zaväzujem sa chrániť vaše osobné údaje. Táto politika ochrany súkromia vysvetľuje, ako nakladám s vašimi osobnými údajmi pri návšteve tejto webovej stránky, a popisuje vaše práva na ochranu súkromia a príslušnú právnu ochranu.</p>

    <h2>2. Informácie, ktoré zhromažďujem</h2>
    <p>Táto webová stránka má predovšetkým informačný charakter. Nevyžadujem od vás vytvorenie účtu.</p>
    <ul>
      <li><strong>Technické údaje:</strong> Zahŕňajú adresu internetového protokolu (IP), typ prehliadača, navštívenú adresu, čas požiadavky a základné údaje o odpovedi. Tieto údaje sa používajú na zabezpečenie, diagnostiku a ochranu formulárov pred zneužitím. Citlivé parametre odkazov sa pred uložením odstraňujú.</li>
      <li><strong>Kontaktný formulár:</strong> Ak odošlete správu, uložím meno, e-mailovú adresu, predmet, text správy a čas odoslania, aby som mohol na správu odpovedať.</li>
      <li><strong>Newsletter:</strong> Pri prihlásení na odber uložím e-mailovú adresu, čas prihlásenia a kryptografické odtlačky tokenov potrebné na potvrdenie a odhlásenie z odberu.</li>
      <li><strong>Cookies a lokálne úložisko:</strong> Lokálne ukladám iba preferenciu témy (tmavý/svetlý režim) a vaše rozhodnutie o analytike.
        <strong>Google Analytics 4 (GA4):</strong> Analytický skript sa nenačíta, kým výslovne nekliknete na tlačidlo Súhlasím v lište súhlasu. Reklamné kategórie súhlasu zostávajú vypnuté. Svoje rozhodnutie môžete kedykoľvek zmeniť cez Nastavenia cookies v pätičke.</li>
    </ul>

    <h2>3. Ako používam vaše informácie</h2>
    <p>Vaše údaje používam na:</p>
    <ul>
      <li>Poskytovanie obsahu webovej stránky.</li>
      <li>Zabezpečenie bezpečnosti webovej stránky.</li>
      <li>Zapamätanie preferencie témy a rozhodnutia o analytike.</li>
      <li>Spracovanie kontaktných správ a správa odberu newslettera na základe vašej žiadosti.</li>
      <li>Analýzu návštevnosti a spôsobov používania webovej stránky prostredníctvom Google Analytics 4, avšak iba v prípade, že kliknete na tlačidlo <strong>Súhlasím</strong> v lište súhlasu s cookies. Právny základ: váš súhlas (článok 6 ods. 1 písm. a) GDPR). Analytické údaje uchováva spoločnosť Google podľa vlastných pravidiel uchovávania (zvyčajne najviac 14 mesiacov). Súhlas môžete kedykoľvek odvolať prostredníctvom tlačidla <strong>Nastavenia cookies</strong> v pätičke a výberom možnosti <strong>Odmietnuť</strong>.</li>
    </ul>

    <h2>4. Doba uchovávania</h2>
    <p>Vlastné technické prístupové záznamy sa predvolene automaticky odstraňujú po 90 dňoch; prevádzkovateľ môže túto dobu skrátiť. Krátkodobé záznamy ochrany formulárov sa priebežne odstraňujú po uplynutí ochranného okna. Kontaktné správy uchovávam iba po dobu potrebnú na vybavenie komunikácie. E-mail newslettera uchovávam do odhlásenia z odberu.</p>

    <h2>5. Odkazy tretích strán</h2>
    <p>Táto webová stránka môže obsahovať odkazy na webové stránky, doplnky a aplikácie tretích strán (napr. Amazon, sociálne siete). Kliknutím na tieto odkazy môžu tretie strany zhromažďovať alebo zdieľať údaje o vás. Nemám kontrolu nad týmito webovými stránkami tretích strán a nenesiem zodpovednosť za ich vyhlásenia o ochrane súkromia.</p>

    <h2>6. Vaše zákonné práva (GDPR/CCPA)</h2>
    <p>Za určitých okolností máte práva vyplývajúce zo zákonov o ochrane osobných údajov vo vzťahu k vašim osobným údajom, vrátane práva požiadať o prístup, opravu, vymazanie alebo obmedzenie spracúvania vašich osobných údajov.</p>

    <h2>7. Kontakt</h2>
    <p>Ak máte akékoľvek otázky týkajúce sa tejto politiky ochrany súkromia, kontaktujte ma na adrese: <a href="mailto:lubomir@polascin.net">lubomir@polascin.net</a>.</p>
  </div>
</main>
<?php include __DIR__ . '/footer.php'; ?>
</body>
</html>
