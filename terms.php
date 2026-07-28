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
    readfile(__DIR__ . '/terms.html');
    exit;
}

require_once __DIR__ . '/auth.php';

$baseUrl = getAppBaseUrl();
$pageTitle = 'Podmienky používania | MUDr. Ľubomír Polaščín';
$seoDescription = 'Podmienky používania webovej stránky MUDr. Ľubomíra Polaščína.';
$robotsMeta = 'noindex, follow';
$canonicalUrl = $baseUrl . '/terms.php';
?>
<!DOCTYPE html>
<html lang="sk">
<head>
<?php include __DIR__ . '/head_meta.php'; ?>
</head>
<body>
<?php include __DIR__ . '/header.php'; ?>
<main id="main-content" class="page-content" tabindex="-1" aria-label="Podmienky používania">
  <div class="container">
    <h1 class="section-title">Podmienky používania</h1>
    <p><strong>Posledná aktualizácia: 28. júla 2026</strong></p>

    <h3>1. Akceptácia podmienok</h3>
    <p>Prístupom na webovú stránku a jej používaním <strong>polascin.net</strong> (ďalej len „webová stránka“) akceptujete a súhlasíte, že vás zaväzujú podmienky a ustanovenia tejto dohody.</p>

    <h3>2. Zdravotné zrieknutie sa zodpovednosti</h3>
    <div class="medical-disclaimer">
      <p><strong>DÔLEŽITÉ:</strong> Obsah poskytovaný na tejto webovej stránke slúži len na informačné účely. <strong>Nenahrádza</strong> odborné lekárske poradenstvo, diagnostiku ani liečbu.</p>
      <p>V prípade akýchkoľvek otázok týkajúcich sa zdravotného stavu sa vždy obráťte na svojho lekára alebo iného kvalifikovaného zdravotníckeho pracovníka. Nikdy nepodceňujte odborné lekárske odporúčanie ani neodkladajte vyhľadanie lekárskej pomoci z dôvodu informácií, ktoré ste si prečítali na tejto webovej stránke.</p>
    </div>

    <h3>3. Duševné vlastníctvo</h3>
    <p>Obsah, štruktúra, grafika, dizajn, kompilácia a iné prvky súvisiace s touto webovou stránkou sú chránené príslušnými autorskými právami a zákonmi o duševnom vlastníctve. Akékoľvek kopírovanie, redistribúcia, použitie alebo publikovanie týchto prvkov alebo akejkoľvek časti webovej stránky používateľom je prísne zakázané.</p>

    <h3>4. Obmedzenie zodpovednosti</h3>
    <p>V žiadnom prípade nenesiem zodpovednosť za akékoľvek náhodné, nepriame, následné alebo mimoriadne škody akejkoľvek povahy, ani za akékoľvek iné škody, vrátane, ale nie výhradne, škôd vzniknutých v dôsledku straty zisku, straty zmlúv, goodwillu, údajov, informácií, príjmov, očakávaných úspor alebo obchodných vzťahov, bez ohľadu na to, či som bol upozornený na možnosť takýchto škôd, a to v súvislosti s používaním tejto webovej stránky alebo akýchkoľvek na ňu odkazovaných webových stránok.</p>

    <h3>5. Rozhodné právo</h3>
    <p>Tieto podmienky a ustanovenia sa riadia a interpretujú v súlade s právnymi predpismi Slovenskej republiky a bez výhrad podriaďujete sa výlučnej právomoci súdov v tomto mieste.</p>
  </div>
</main>
<?php include __DIR__ . '/footer.php'; ?>
</body>
</html>
