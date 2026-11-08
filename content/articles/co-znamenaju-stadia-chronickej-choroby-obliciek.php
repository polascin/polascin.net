<?php

declare(strict_types=1);

$requestedScript = str_replace('\\', '/', (string) ($_SERVER['SCRIPT_NAME'] ?? $_SERVER['PHP_SELF'] ?? ''));
$executedFile = isset($_SERVER['SCRIPT_FILENAME']) ? realpath((string) $_SERVER['SCRIPT_FILENAME']) : false;
if (
    $executedFile === __FILE__
    || preg_match('~(?:^|/)content/articles/.+\.php(?:/|$)~i', $requestedScript) === 1
) {
    if (PHP_SAPI === 'cli') {
        fwrite(STDERR, "Chyba: súbor článku je interný a nemožno ho spúšťať priamo.\n");
        exit(1);
    }
    http_response_code(403);
    exit('Prístup odmietnutý.');
}
unset($requestedScript, $executedFile);

/**
 * Pacientsky edukatívny článok: čo znamenajú štádiá chronickej choroby obličiek
 * (kategórie G1 až G5 podľa eGFR a kategórie albuminúrie A1 až A3 podľa UACR).
 * Fakty overené 8. 11. 2026: KDIGO 2024 CKD guideline (definícia CKD, kategórie G/A,
 * CKD-EPI 2021, cystatín C, cieľový TK pod 120 mmHg, SGLT2i, RAASi, NSAID),
 * NKF klasifikácia CKD, NIDDK rovnice eGFR, výskyt CKD asi 10 percent dospelých.
 * Tri ilustračné obrázky 16:10 v images/articles/co-znamenaju-stadia-chronickej-choroby-obliciek/. Žiadny textGrain.
 */

return [
    'slug' => 'co-znamenaju-stadia-chronickej-choroby-obliciek',
    'author' => 'MUDr. Ľubomír Polaščín',
    'category' => 'blog',
    'is_top' => 0,
    'published_at' => '2026-11-08 16:30:00',
    'image' => 'images/articles/co-znamenaju-stadia-chronickej-choroby-obliciek.webp',
    'translations' => [
        'sk' => [
            'title' => 'Čo znamená „CKD G3a A2“ vo vašom náleze: štádiá chronickej choroby obličiek jednoducho',
            'image_alt' => 'Dve fialové obličky ležia oproti sebe na svetlom pozadí. Nad nimi oblúk mierky od tyrkysovej po fialovú farbu s ukazovateľom. Čistá ilustrácia bez textu.',
            'excerpt' => 'Vo výsledkoch krvných testov často nájdete skratku eGFR a v lekárskej správe označenie ako CKD G3a A2. Vysvetlíme, čo tieto kategórie znamenajú, prečo samotný kreatinín nestačí a čo môžete urobiť, aby sa funkcia vašich obličiek zhoršovala čo najpomalšie.',
            'content' => <<<'HTML'
<p>Dostali ste výsledky z odberu krvi a v riadku „eGFR“ vidíte číslo 52. V lekárskej správe stojí „CKD G3a A2“. Znie to ako kód, ale skrýva sa za ním jednoduchý príbeh: vaše obličky filtrujú krv pomalšie než zdravé obličky, a lekár chce vedieť, o koľko a ako rýchlo sa to mení.</p>
<p>Chronická choroba obličiek podľa definície KDIGO z roku 2024 znamená odchýlku štruktúry alebo funkcie obličiek, ktorá trvá viac ako tri mesiace a má vplyv na zdravie. Najčastejšie ide o dôsledok cukrovky alebo vysokého krvného tlaku. Postihuje približne každého desiateho dospelého na svete, pritom často prebieha bez akýchkoľvek príznakov, takže sa zachytí až pri náhodnom odbere krvi alebo moču. (<a href="https://kdigo.org/guidelines/ckd-evaluation-and-management/">KDIGO 2024, medzinárodná smernica pre chronickú chorobu obličiek</a>)</p>
<p>Čo je eGFR? Je to odhad, ako rýchlo obličky filtrujú krv. Udáva sa v jednotkách ml/min/1,73 m², teda prepočítaný na štandardnú telesnú plochu. Laboratórium ho počíta z hladiny kreatinínu v krvi spolu s vekom a pohlavím podľa rovnice CKD-EPI 2021, ktorá nezohľadňuje rasu. Samotný kreatinín pritom závisí aj od svalovej hmoty a stravy, preto lekár pri hraničných hodnotách často doplní vyšetrenie cystatínu C, čím je odhad filtrácie presnejší. (<a href="https://www.niddk.nih.gov/research-funding/research-programs/kidney-clinical-research-epidemiology/laboratory/glomerular-filtration-rate-equations/adults">NIDDK, rovnice na výpočet GFR u dospelých</a>)</p>
<p><img src="images/articles/co-znamenaju-stadia-chronickej-choroby-obliciek/01-gauge.webp" alt="Polkruhová mierka s oblúkom od tyrkysovej po fialovú farbu a ukazovateľom uprostred, symbol odhadu filtrácie obličiek. Ilustrácia bez textu na svetlom pozadí." loading="lazy"></p>
<p>Podľa hodnoty eGFR rozdeľujeme filtráciu obličiek do kategórií G1 až G5:</p>
<div class="table-responsive">
<table>
<thead><tr><th scope="col">Kategória</th><th scope="col">eGFR (ml/min/1,73 m²)</th><th scope="col">Význam</th></tr></thead>
<tbody>
<tr><td>G1</td><td>90 a viac</td><td>normálna alebo vysoká filtrácia</td></tr>
<tr><td>G2</td><td>60 až 89</td><td>mierne znížená filtrácia</td></tr>
<tr><td>G3a</td><td>45 až 59</td><td>mierne až stredne znížená filtrácia</td></tr>
<tr><td>G3b</td><td>30 až 44</td><td>stredne až výrazne znížená filtrácia</td></tr>
<tr><td>G4</td><td>15 až 29</td><td>výrazne znížená filtrácia</td></tr>
<tr><td>G5</td><td>menej ako 15</td><td>zlyhanie obličiek</td></tr>
</tbody>
</table>
</div>
<p>Kategórie G1 a G2 pritom samy osebe nie sú chorobou, ak nie sú prítomné známky poškodenia obličiek, najmä zvýšená albuminúria. Druhá os klasifikácie preto opisuje, koľko bielkoviny albumínu uniká do moču. Meria sa pomer albumínu ku kreatinínu v moči, skratka UACR, a delí sa do kategórií A1 až A3:</p>
<div class="table-responsive">
<table>
<thead><tr><th scope="col">Kategória</th><th scope="col">UACR (mg/mmol)</th><th scope="col">UACR (mg/g)</th><th scope="col">Význam</th></tr></thead>
<tbody>
<tr><td>A1</td><td>menej ako 3</td><td>menej ako 30</td><td>normálna až mierne zvýšená albuminúria</td></tr>
<tr><td>A2</td><td>3 až 30</td><td>30 až 300</td><td>stredne zvýšená albuminúria</td></tr>
<tr><td>A3</td><td>viac ako 30</td><td>viac ako 300</td><td>výrazne zvýšená albuminúria</td></tr>
</tbody>
</table>
</div>
<p>Čím vyššia je albuminúria, tým väčšie je riziko pre samotné obličky, ale aj pre srdce a cievy. Starší termín „mikroalbuminúria“ sa podľa KDIGO 2024 už nepoužíva. (<a href="https://www.kidney.org/how-to-classify-ckd">National Kidney Foundation, klasifikácia CKD</a>)</p>
<p><img src="images/articles/co-znamenaju-stadia-chronickej-choroby-obliciek/02-risk-grid.webp" alt="Mriežka päť krát tri políčok vo fialovom ráme, zľava hore zelené cez žlté a oranžové až po červené sprava dole. Tepelná mapa rizika progresie choroby obličiek. Ilustrácia bez textu." loading="lazy"></p>
<p>Kategória G a kategória A spolu tvoria mapu rizika. Zelené políčka znamenajú nízke riziko, žlté zvýšené, oranžové vysoké a červené veľmi vysoké riziko, že funkcia obličiek bude ďalej klesať a že pôjde aj o srdcovo-cievny systém. Označenie CKD G3a A2 teda znamená stredne zníženú filtráciu so stredne zvýšenou albuminúriou, čo patrí do zvýšeného, žltého rizika.</p>
<p>Čo to mení v praxi? Predovšetkým pravidelné sledovanie, pretože CKD dlho nebolí. Kontroluje sa eGFR aj UACR v čase. Ak máte vysoký tlak, KDIGO 2024 odporúča liečiť ho na cieľový systolický tlak pod 120 mmHg, ak je to dobre tolerované, pri štandardizovanom meraní v ambulancii. Z liekov lekár pri albuminúrii a vysokom tlaku zvažuje ACE inhibítor alebo sartan a pri cukrovke 2. typu s chorobou obličiek, prípadne pri výraznej albuminúrii, aj inhibítor SGLT2, lebo tieto lieky dokázateľne spomaľujú postup ochorenia. O konkrétnej liečbe vždy rozhoduje váš lekár. (<a href="https://kdigo.org/wp-content/uploads/2024/03/KDIGO-2024-CKD-Guideline.pdf">KDIGO 2024 CKD Guideline, plný text, PDF</a>)</p>
<p><img src="images/articles/co-znamenaju-stadia-chronickej-choroby-obliciek/03-protection.webp" alt="Fialová oblička s tyrkysovým obrysom, pred ňou tyrkysový štít s fialovým srdcom vo vnútri. Symbol ochrany obličiek a srdca. Ilustrácia bez textu na svetlom pozadí." loading="lazy"></p>
<p>Veľa toho môžete ovplyvniť sami: nefajčiť, soliť menej ako 5 gramov kuchynskej soli denne, čo zodpovedá príjmu sodíka pod 2 gramy denne, vyhýbať sa pri bolesti liekom zo skupiny nesteroidných antiflogistík, ako je ibuprofén alebo diklofenak, bez porady s lekárom, pretože pri chorobe obličiek môžu funkciu náhle zhoršiť, najmä pri dehydratácii, a chodiť na pravidelné kontroly, aj keď sa cítite dobre.</p>
<p>Kedy ide o vážny stav? Kategória G5, teda eGFR menej ako 15 ml/min/1,73 m², znamená zlyhanie obličiek. Dialýza sa pritom nezačína automaticky pri určitom čísle, rozhodujú príznaky, tempo poklesu a celkový stav. Pri včasnom zachytení a liečbe mnohí ľudia nikdy nedospejú k štádiu zlyhania; ak sa k nemu výhľadovo smeruje, pripravuje sa včas cievny prístup a zvažuje sa transplantácia obličky.</p>
<p>Čísla v náleze nie sú verdikt, sú mapa. Včasné štádium je výhoda, pretože práve vtedy vieme priebeh ochorenia najviac spomaliť. Keď vo výsledkoch nájdete písmeno G alebo A, spýtajte sa lekára, do ktorej skupiny vašej mapy patríte a čo to pre vás znamená.</p>
<p><em>Článok má informatívny charakter a nenahrádza individuálne lekárske odporúčanie. O vašom štádiu, liečbe a frekvencii kontroliek rozhoduje váš ošetrujúci lekár alebo nefrológ na základe kompletného vyšetrenia.</em></p>

HTML,
        ],
        'en' => [
            'title' => 'What “CKD G3a A2” in your lab report means: kidney disease stages explained simply',
            'image_alt' => 'Two purple kidneys face each other on a light background. Above them an arc-shaped gauge running from teal to purple with a needle. Clean illustration without text.',
            'excerpt' => 'Blood test results often show an eGFR value, and the doctor\'s report may say something like CKD G3a A2. We explain what these categories mean, why creatinine alone is not enough, and what you can do to slow the decline of your kidney function as much as possible.',
            'content' => <<<'HTML'
<p>You have received your blood test results and in the “eGFR” row you see the number 52. The medical report says “CKD G3a A2”. It sounds like a code, but behind it is a simple story: your kidneys filter blood more slowly than healthy kidneys, and your doctor wants to know by how much and how fast it is changing.</p>
<p>According to the 2024 KDIGO definition, chronic kidney disease means an abnormality of kidney structure or function that has been present for more than three months and has implications for health. Most often it is a consequence of diabetes or high blood pressure. It affects roughly one in ten adults worldwide, often without any symptoms, so it is usually detected only through a routine blood or urine test. (<a href="https://kdigo.org/guidelines/ckd-evaluation-and-management/">KDIGO 2024, guideline on chronic kidney disease</a>)</p>
<p>What is eGFR? It is an estimate of how fast the kidneys filter blood. It is reported in mL/min/1.73 m², that is, adjusted to a standard body surface area. The laboratory calculates it from the blood creatinine level together with age and sex using the 2021 CKD-EPI equation, which does not include race. Creatinine itself also depends on muscle mass and diet, which is why doctors often add a cystatin C test at borderline values, giving a more accurate estimate of filtration. (<a href="https://www.niddk.nih.gov/research-funding/research-programs/kidney-clinical-research-epidemiology/laboratory/glomerular-filtration-rate-equations/adults">NIDDK, GFR estimating equations for adults</a>)</p>
<p><img src="images/articles/co-znamenaju-stadia-chronickej-choroby-obliciek/01-gauge.webp" alt="A semicircular gauge with an arc running from teal to purple and a needle in the middle, symbolising the estimated kidney filtration. Illustration without text on a light background." loading="lazy"></p>
<p>Based on the eGFR value, kidney function is divided into categories G1 to G5:</p>
<div class="table-responsive">
<table>
<thead><tr><th scope="col">Category</th><th scope="col">eGFR (mL/min/1.73 m²)</th><th scope="col">Meaning</th></tr></thead>
<tbody>
<tr><td>G1</td><td>90 or more</td><td>normal or high filtration</td></tr>
<tr><td>G2</td><td>60-89</td><td>mildly decreased filtration</td></tr>
<tr><td>G3a</td><td>45-59</td><td>mildly to moderately decreased filtration</td></tr>
<tr><td>G3b</td><td>30-44</td><td>moderately to severely decreased filtration</td></tr>
<tr><td>G4</td><td>15-29</td><td>severely decreased filtration</td></tr>
<tr><td>G5</td><td>less than 15</td><td>kidney failure</td></tr>
</tbody>
</table>
</div>
<p>Categories G1 and G2 on their own are not disease unless there are signs of kidney damage, above all increased albuminuria. The second axis of the classification therefore describes how much of the protein albumin leaks into the urine. It is measured as the urine albumin-to-creatinine ratio, UACR, and divided into categories A1 to A3:</p>
<div class="table-responsive">
<table>
<thead><tr><th scope="col">Category</th><th scope="col">UACR (mg/mmol)</th><th scope="col">UACR (mg/g)</th><th scope="col">Meaning</th></tr></thead>
<tbody>
<tr><td>A1</td><td>less than 3</td><td>less than 30</td><td>normal to mildly increased albuminuria</td></tr>
<tr><td>A2</td><td>3-30</td><td>30-300</td><td>moderately increased albuminuria</td></tr>
<tr><td>A3</td><td>more than 30</td><td>more than 300</td><td>severely increased albuminuria</td></tr>
</tbody>
</table>
</div>
<p>The higher the albuminuria, the greater the risk, not only for the kidneys themselves but also for the heart and blood vessels. The older term “microalbuminuria” is no longer used under KDIGO 2024. (<a href="https://www.kidney.org/how-to-classify-ckd">National Kidney Foundation, CKD classification</a>)</p>
<p><img src="images/articles/co-znamenaju-stadia-chronickej-choroby-obliciek/02-risk-grid.webp" alt="A grid of five by three cells in a purple frame, green at the top left through yellow and orange to red at the bottom right. A risk heat map for progression of kidney disease. Illustration without text." loading="lazy"></p>
<p>The G category and the A category together form a risk map. Green cells mean low risk, yellow increased, orange high and red very high risk that kidney function will continue to decline and that the cardiovascular system will be affected too. The label CKD G3a A2 therefore means moderately decreased filtration with moderately increased albuminuria, which falls into the increased, yellow risk zone.</p>
<p>What does this change in practice? Above all, regular monitoring, because CKD hurts for a long time. eGFR and UACR are checked over time. If you have high blood pressure, KDIGO 2024 recommends treating it to a target systolic pressure below 120 mmHg, when well tolerated, measured with a standardised office protocol. As for medication, in albuminuria with high blood pressure the doctor will consider an ACE inhibitor or an angiotensin receptor blocker, and in type 2 diabetes with kidney disease, or in marked albuminuria, also an SGLT2 inhibitor, because these drugs have been shown to slow the progression of kidney disease. Your doctor always decides on the specific treatment. (<a href="https://kdigo.org/wp-content/uploads/2024/03/KDIGO-2024-CKD-Guideline.pdf">KDIGO 2024 CKD Guideline, full text, PDF</a>)</p>
<p><img src="images/articles/co-znamenaju-stadia-chronickej-choroby-obliciek/03-protection.webp" alt="A purple kidney with a teal outline, in front of it a teal shield with a purple heart inside. A symbol of protecting the kidneys and the heart. Illustration without text on a light background." loading="lazy"></p>
<p>You can influence a lot yourself: do not smoke, use less than 5 grams of table salt a day, which corresponds to a sodium intake below 2 grams a day, avoid painkillers from the NSAID group such as ibuprofen or diclofenac without asking your doctor, because in kidney disease they can suddenly worsen function, especially during dehydration, and attend regular check-ups even when you feel well.</p>
<p>When does it become serious? Category G5, that is eGFR below 15 mL/min/1.73 m², means kidney failure. Dialysis does not start automatically at a particular number; symptoms, the speed of decline and the overall condition decide. When caught and treated early, many people never progress to kidney failure; if it is heading that way, a vascular access is prepared in time and kidney transplantation is considered.</p>
<p>The numbers in your report are not a verdict, they are a map. An early stage is an advantage, because that is exactly when the course of the disease can be slowed the most. When you see a G or an A in your results, ask your doctor which cell of your map you are in and what it means for you.</p>
<p><em>This article is for information only and does not replace individual medical advice. Your stage, treatment and follow-up schedule are decided by your treating physician or nephrologist based on a complete examination.</em></p>

HTML,
        ],
        'cs' => [
            'title' => 'Co znamená „CKD G3a A2“ ve vašem nálezu: stadia chronického onemocnění ledvin jednoduše',
            'image_alt' => 'Dvě fialové ledviny leží proti sobě na světlém pozadí. Nad nimi oblouk stupnice od tyrkysové po fialovou barvu s ukazatelem. Čistá ilustrace bez textu.',
            'excerpt' => 'Ve výsledcích krevních testů často najdete zkratku eGFR a v lékařské zprávě označení jako CKD G3a A2. Vysvětlíme, co tyto kategorie znamenají, proč samotný kreatinin nestačí a co můžete udělat, aby se funkce vašich ledvin zhoršovala co nejpomaleji.',
            'content' => <<<'HTML'
<p>Dostali jste výsledky odběru krve a v řádku „eGFR“ vidíte číslo 52. V lékařské zprávě stojí „CKD G3a A2“. Zní to jako kód, ale skrývá se za ním jednoduchý příběh: vaše ledviny filtrují krev pomaleji než zdravé ledviny a lékař chce vědět, o kolik a jak rychle se to mění.</p>
<p>Chronické onemocnění ledvin podle definice KDIGO z roku 2024 znamená odchylku struktury nebo funkce ledvin, která trvá více než tři měsíce a má vliv na zdraví. Nejčastěji jde o důsledek cukrovky nebo vysokého krevního tlaku. Postihuje přibližně každého desátého dospělého na světě, přitom často probíhá bez jakýchkoli příznaků, takže se zachytí až při náhodném odběru krve nebo moči. (<a href="https://kdigo.org/guidelines/ckd-evaluation-and-management/">KDIGO 2024, mezinárodní směrnice pro chronické onemocnění ledvin</a>)</p>
<p>Co je eGFR? Je to odhad, jak rychle ledviny filtrují krev. Udává se v jednotkách ml/min/1,73 m², tedy přepočtených na standardní tělesný povrch. Laboratoř ho počítá z hladiny kreatininu v krvi spolu s věkem a pohlavím podle rovnice CKD-EPI 2021, která nezahrnuje rasu. Samotný kreatinin přitom závisí i na svalové hmotě a stravě, proto lékař při hraničních hodnotách často doplní vyšetření cystatinu C, čímž je odhad filtrace přesnější. (<a href="https://www.niddk.nih.gov/research-funding/research-programs/kidney-clinical-research-epidemiology/laboratory/glomerular-filtration-rate-equations/adults">NIDDK, rovnice pro výpočet GFR u dospělých</a>)</p>
<p><img src="images/articles/co-znamenaju-stadia-chronickej-choroby-obliciek/01-gauge.webp" alt="Půlkruhová stupnice s obloukem od tyrkysové po fialovou barvu a ukazatelem uprostřed, symbol odhadu filtrace ledvin. Ilustrace bez textu na světlém pozadí." loading="lazy"></p>
<p>Podle hodnoty eGFR dělíme filtraci ledvin do kategorií G1 až G5:</p>
<div class="table-responsive">
<table>
<thead><tr><th scope="col">Kategorie</th><th scope="col">eGFR (ml/min/1,73 m²)</th><th scope="col">Význam</th></tr></thead>
<tbody>
<tr><td>G1</td><td>90 a více</td><td>normální nebo vysoká filtrace</td></tr>
<tr><td>G2</td><td>60 až 89</td><td>mírně snížená filtrace</td></tr>
<tr><td>G3a</td><td>45 až 59</td><td>mírně až středně snížená filtrace</td></tr>
<tr><td>G3b</td><td>30 až 44</td><td>středně až výrazně snížená filtrace</td></tr>
<tr><td>G4</td><td>15 až 29</td><td>výrazně snížená filtrace</td></tr>
<tr><td>G5</td><td>méně než 15</td><td>selhání ledvin</td></tr>
</tbody>
</table>
</div>
<p>Kategorie G1 a G2 samy o sobě nejsou nemocí, pokud nejsou přítomny známky poškození ledvin, zejména zvýšená albuminurie. Druhá osa klasifikace proto popisuje, kolik bílkoviny albuminu uniká do moči. Měří se poměr albuminu ke kreatininu v moči, zkratka UACR, a dělí se do kategorií A1 až A3:</p>
<div class="table-responsive">
<table>
<thead><tr><th scope="col">Kategorie</th><th scope="col">UACR (mg/mmol)</th><th scope="col">UACR (mg/g)</th><th scope="col">Význam</th></tr></thead>
<tbody>
<tr><td>A1</td><td>méně než 3</td><td>méně než 30</td><td>normální až mírně zvýšená albuminurie</td></tr>
<tr><td>A2</td><td>3 až 30</td><td>30 až 300</td><td>středně zvýšená albuminurie</td></tr>
<tr><td>A3</td><td>více než 30</td><td>více než 300</td><td>výrazně zvýšená albuminurie</td></tr>
</tbody>
</table>
</div>
<p>Čím vyšší je albuminurie, tím větší je riziko, a to nejen pro samotné ledviny, ale i pro srdce a cévy. Starší termín „mikroalbuminurie“ se podle KDIGO 2024 už nepoužívá. (<a href="https://www.kidney.org/how-to-classify-ckd">National Kidney Foundation, klasifikace CKD</a>)</p>
<p><img src="images/articles/co-znamenaju-stadia-chronickej-choroby-obliciek/02-risk-grid.webp" alt="Mřížka pěti krát tří políček ve fialovém rámu, zleva nahoře zelená přes žlutou a oranžovou až po červenou vpravo dole. Tepelná mapa rizika progrese onemocnění ledvin. Ilustrace bez textu." loading="lazy"></p>
<p>Kategorie G a kategorie A společně tvoří mapu rizika. Zelená políčka znamenají nízké riziko, žlutá zvýšené, oranžová vysoké a červená velmi vysoké riziko, že funkce ledvin bude dále klesat a že půjde i o kardiovaskulární systém. Označení CKD G3a A2 tedy znamená středně sníženou filtraci se středně zvýšenou albuminurií, což patří do zvýšeného, žlutého rizika.</p>
<p>Co to mění v praxi? Především pravidelné sledování, protože CKD dlouho nebolí. Kontroluje se eGFR i UACR v čase. Pokud máte vysoký tlak, KDIGO 2024 doporučuje léčit ho na cílový systolický tlak pod 120 mmHg, pokud je to dobře snášeno, při standardizovaném měření v ordinaci. Z léků lékař při albuminurii a vysokém tlaku zvažuje ACE inhibitor nebo sartan a při cukrovce 2. typu s onemocněním ledvin, případně při výrazné albuminurii, také inhibitor SGLT2, protože tyto léky prokazatelně zpomalují postup onemocnění ledvin. O konkrétní léčbě vždy rozhoduje váš lékař. (<a href="https://kdigo.org/wp-content/uploads/2024/03/KDIGO-2024-CKD-Guideline.pdf">KDIGO 2024 CKD Guideline, plný text, PDF</a>)</p>
<p><img src="images/articles/co-znamenaju-stadia-chronickej-choroby-obliciek/03-protection.webp" alt="Fialová ledvina s tyrkysovým obrysem, před ní tyrkysový štít s fialovým srdcem uvnitř. Symbol ochrany ledvin a srdce. Ilustrace bez textu na světlém pozadí." loading="lazy"></p>
<p>Hodně toho můžete ovlivnit sami: nekouřit, solit méně než 5 gramů kuchyňské soli denně, což odpovídá příjmu sodíku pod 2 gramy denně, vyhýbat se při bolesti lékům ze skupiny nesteroidních antiflogistik, jako je ibuprofen nebo diklofenak, bez porady s lékařem, protože při onemocnění ledvin mohou funkci náhle zhoršit, zejména při dehydrataci, a chodit na pravidelné kontroly, i když se cítíte dobře.</p>
<p>Kdy jde o vážný stav? Kategorie G5, tedy eGFR méně než 15 ml/min/1,73 m², znamená selhání ledvin. Dialýza přitom nezačíná automaticky při určitém čísle, rozhodují příznaky, tempo poklesu a celkový stav. Při včasném zachycení a léčbě mnozí lidé nikdy nedospějí ke stadiu selhání; pokud se k němu směřuje, připravuje se včas cévní přístup a zvažuje se transplantace ledviny.</p>
<p>Čísla v nálezu nejsou verdikt, jsou mapa. Časné stadium je výhoda, protože právě tehdy lze průběh onemocnění nejvíce zpomalit. Když ve výsledcích najdete písmeno G nebo A, zeptejte se lékaře, do které skupiny vaší mapy patříte a co to pro vás znamená.</p>
<p><em>Článek má informativní charakter a nenahrazuje individuální lékařské doporučení. O vašem stadiu, léčbě a frekvenci kontrol rozhoduje váš ošetřující lékař nebo nefrolog na základě kompletního vyšetření.</em></p>

HTML,
        ],
        'de' => [
            'title' => 'Was bedeutet „CKD G3a A2“ in Ihrem Befund: Stadien der chronischen Nierenerkrankung einfach erklärt',
            'image_alt' => 'Zwei violette Nieren liegen einander auf hellem Hintergrund gegenüber. Darüber ein bogenförmiges Messgerät von Türkis nach Violett mit einem Zeiger. Saubere Illustration ohne Text.',
            'excerpt' => 'In Blutergebnissen finden Sie häufig die Abkürzung eGFR, und im Arztbrief steht etwa CKD G3a A2. Wir erklären, was diese Kategorien bedeuten, warum Kreatinin allein nicht ausreicht und was Sie tun können, damit sich Ihre Nierenfunktion möglichst langsam verschlechtert.',
            'content' => <<<'HTML'
<p>Sie haben Ihre Blutergebnisse erhalten und in der Zeile „eGFR“ steht die Zahl 52. Im Arztbrief steht „CKD G3a A2“. Das klingt wie ein Code, aber dahinter steckt eine einfache Geschichte: Ihre Nieren filtern das Blut langsamer als gesunde Nieren, und Ihr Arzt möchte wissen, um wie viel und wie schnell sich das ändert.</p>
<p>Nach der KDIGO-Definition von 2024 bedeutet eine chronische Nierenerkrankung eine Abweichung der Nierenstruktur oder -funktion, die seit mehr als drei Monaten besteht und gesundheitliche Folgen hat. Am häufigsten ist sie eine Folge von Diabetes oder Bluthochdruck. Sie betrifft weltweit etwa jeden zehnten Erwachsenen, oft ohne jegliche Symptome, und wird daher meist erst bei einer routinemäßigen Blut- oder Urinuntersuchung entdeckt. (<a href="https://kdigo.org/guidelines/ckd-evaluation-and-management/">KDIGO 2024, Leitlinie zur chronischen Nierenerkrankung</a>)</p>
<p>Was ist die eGFR? Eine Schätzung, wie schnell die Nieren das Blut filtern. Sie wird in ml/min/1,73 m² angegeben, also bezogen auf eine standardisierte Körperoberfläche. Das Labor berechnet sie aus dem Kreatininwert im Blut zusammen mit Alter und Geschlecht anhand der CKD-EPI-2021-Gleichung, die die ethnische Herkunft nicht berücksichtigt. Kreatinin hängt außerdem von Muskelmasse und Ernährung ab, deshalb ergänzt der Arzt bei grenzwertigen Werten oft Cystatin C, wodurch die Schätzung der Filtration genauer wird. (<a href="https://www.niddk.nih.gov/research-funding/research-programs/kidney-clinical-research-epidemiology/laboratory/glomerular-filtration-rate-equations/adults">NIDDK, Gleichungen zur GFR-Schätzung bei Erwachsenen</a>)</p>
<p><img src="images/articles/co-znamenaju-stadia-chronickej-choroby-obliciek/01-gauge.webp" alt="Ein halbkreisförmiges Messgerät mit einem Bogen von Türkis nach Violett und einem Zeiger in der Mitte, Symbol für die geschätzte Nierenfiltration. Illustration ohne Text auf hellem Hintergrund." loading="lazy"></p>
<p>Anhand des eGFR-Werts wird die Nierenfunktion in die Kategorien G1 bis G5 eingeteilt:</p>
<div class="table-responsive">
<table>
<thead><tr><th scope="col">Kategorie</th><th scope="col">eGFR (ml/min/1,73 m²)</th><th scope="col">Bedeutung</th></tr></thead>
<tbody>
<tr><td>G1</td><td>90 oder mehr</td><td>normale oder hohe Filtration</td></tr>
<tr><td>G2</td><td>60-89</td><td>leicht verminderte Filtration</td></tr>
<tr><td>G3a</td><td>45-59</td><td>leicht bis mäßig verminderte Filtration</td></tr>
<tr><td>G3b</td><td>30-44</td><td>mäßig bis deutlich verminderte Filtration</td></tr>
<tr><td>G4</td><td>15-29</td><td>deutlich verminderte Filtration</td></tr>
<tr><td>G5</td><td>unter 15</td><td>Nierenversagen</td></tr>
</tbody>
</table>
</div>
<p>Die Kategorien G1 und G2 sind für sich genommen noch keine Erkrankung, wenn keine Anzeichen eines Nierenschadens vorliegen, vor allem keine erhöhte Albuminurie. Die zweite Achse der Einteilung beschreibt daher, wie viel des Proteins Albumin in den Urin austritt. Gemessen wird der Albumin-Kreatinin-Quotient im Urin, UACR, eingeteilt in die Kategorien A1 bis A3:</p>
<div class="table-responsive">
<table>
<thead><tr><th scope="col">Kategorie</th><th scope="col">UACR (mg/mmol)</th><th scope="col">UACR (mg/g)</th><th scope="col">Bedeutung</th></tr></thead>
<tbody>
<tr><td>A1</td><td>unter 3</td><td>unter 30</td><td>normal bis leicht erhöhte Albuminurie</td></tr>
<tr><td>A2</td><td>3-30</td><td>30-300</td><td>mäßig erhöhte Albuminurie</td></tr>
<tr><td>A3</td><td>über 30</td><td>über 300</td><td>deutlich erhöhte Albuminurie</td></tr>
</tbody>
</table>
</div>
<p>Je höher die Albuminurie, desto größer das Risiko, nicht nur für die Nieren selbst, sondern auch für Herz und Blutgefäße. Der ältere Begriff „Mikroalbuminurie“ wird laut KDIGO 2024 nicht mehr verwendet. (<a href="https://www.kidney.org/how-to-classify-ckd">National Kidney Foundation, CKD-Klassifikation</a>)</p>
<p><img src="images/articles/co-znamenaju-stadia-chronickej-choroby-obliciek/02-risk-grid.webp" alt="Ein Raster aus fünf mal drei Feldern in violettem Rahmen, von Grün oben links über Gelb und Orange bis Rot unten rechts. Eine Risikokarte für das Fortschreiten der Nierenerkrankung. Illustration ohne Text." loading="lazy"></p>
<p>Die Kategorie G und die Kategorie A ergeben zusammen eine Risikokarte. Grüne Felder bedeuten ein niedriges Risiko, gelbe ein erhöhtes, orange ein hohes und rote ein sehr hohes Risiko, dass die Nierenfunktion weiter abnimmt und auch das Herz-Kreislauf-System betroffen ist. Die Bezeichnung CKD G3a A2 bedeutet also eine mäßig verminderte Filtration mit mäßig erhöhter Albuminurie und liegt damit im erhöhten, gelben Risikobereich.</p>
<p>Was ändert das in der Praxis? Vor allem die regelmäßige Kontrolle, denn eine chronische Nierenerkrankung tut lange nicht weh. eGFR und UACR werden im Verlauf kontrolliert. Bei Bluthochdruck empfiehlt KDIGO 2024, diesen auf einen systolischen Zielwert unter 120 mmHg zu behandeln, sofern er gut vertragen wird, gemessen mit standardisiertem Praxisprotokoll. An Medikamenten erwägt der Arzt bei Albuminurie und Bluthochdruck einen ACE-Hemmer oder ein Sartan und bei Diabetes mellitus Typ 2 mit Nierenerkrankung oder bei ausgeprägter Albuminurie auch einen SGLT2-Hemmer, weil diese Arzneimittel das Fortschreiten der Nierenerkrankung nachweislich verlangsamen. Über die konkrete Therapie entscheidet immer Ihr Arzt. (<a href="https://kdigo.org/wp-content/uploads/2024/03/KDIGO-2024-CKD-Guideline.pdf">KDIGO 2024 CKD Guideline, Volltext, PDF</a>)</p>
<p><img src="images/articles/co-znamenaju-stadia-chronickej-choroby-obliciek/03-protection.webp" alt="Eine violette Niere mit türkisfarbenem Umriss, davor ein türkisfarbenes Schild mit einem violetten Herz darin. Symbol für den Schutz von Nieren und Herz. Illustration ohne Text auf hellem Hintergrund." loading="lazy"></p>
<p>Vieles können Sie selbst beeinflussen: nicht rauchen, weniger als 5 Gramm Speisesalz täglich zu sich nehmen, was einer Natriumaufnahme unter 2 Gramm täglich entspricht, bei Schmerzen ohne Rücksprache mit dem Arzt Medikamente aus der Gruppe der nichtsteroidalen Antiphlogistika wie Ibuprofen oder Diclofenac meiden, weil sie bei Nierenerkrankungen die Funktion plötzlich verschlechtern können, besonders bei Flüssigkeitsmangel, und regelmäßig zu Kontrollen gehen, auch wenn Sie sich wohlfühlen.</p>
<p>Wann wird es ernst? Die Kategorie G5, also eine eGFR unter 15 ml/min/1,73 m², bedeutet Nierenversagen. Eine Dialyse beginnt dabei nicht automatisch bei einer bestimmten Zahl, sondern nach Symptomen, Tempo des Abfalls und Allgemeinzustand. Bei frühzeitiger Erkennung und Behandlung erreichen viele Menschen das Stadium des Nierenversagens nie; wenn es darauf hinausläuft, wird rechtzeitig ein Gefäßzugang angelegt und eine Nierentransplantation erwogen.</p>
<p>Die Zahlen im Befund sind kein Urteil, sie sind eine Landkarte. Ein frühes Stadium ist ein Vorteil, denn genau dann lässt sich der Krankheitsverlauf am stärksten bremsen. Wenn Sie in Ihren Ergebnissen ein G oder ein A sehen, fragen Sie Ihren Arzt, in welchem Feld Ihrer Karte Sie sich befinden und was das für Sie bedeutet.</p>
<p><em>Dieser Artikel dient nur der Information und ersetzt keine individuelle ärztliche Beratung. Über Stadium, Therapie und Kontrollintervalle entscheidet Ihr behandelnder Arzt oder Nephrologe auf Grundlage der vollständigen Untersuchung.</em></p>

HTML,
        ],
        'fr' => [
            'title' => 'Que signifie « CKD G3a A2 » dans votre compte rendu : les stades de la maladie rénale chronique expliqués simplement',
            'image_alt' => 'Deux reins violets se font face sur un fond clair. Au-dessus, un arc de jauge allant du turquoise au violet avec une aiguille. Illustration nette sans texte.',
            'excerpt' => 'Dans les résultats d\'une prise de sang, on trouve souvent l\'abréviation eGFR, et le compte rendu médical mentionne quelque chose comme CKD G3a A2. Nous expliquons ce que signifient ces catégories, pourquoi la créatinine seule ne suffit pas et ce que vous pouvez faire pour ralentir le plus possible la baisse de votre fonction rénale.',
            'content' => <<<'HTML'
<p>Vous avez reçu vos résultats de prise de sang et dans la ligne « eGFR » vous voyez le chiffre 52. Le compte rendu médical indique « CKD G3a A2 ». Cela ressemble à un code, mais derrière se cache une histoire simple : vos reins filtrent le sang plus lentement que des reins en bonne santé, et votre médecin veut savoir de combien et à quelle vitesse cela évolue.</p>
<p>Selon la définition KDIGO de 2024, une maladie rénale chronique signifie une anomalie de la structure ou de la fonction des reins présente depuis plus de trois mois et ayant des conséquences sur la santé. Le plus souvent, il s'agit d'une conséquence du diabète ou d'une hypertension artérielle. Elle touche environ un adulte sur dix dans le monde, souvent sans aucun symptôme, et n'est donc découverte que lors d'une prise de sang ou d'une analyse d'urine de routine. (<a href="https://kdigo.org/guidelines/ckd-evaluation-and-management/">KDIGO 2024, recommandation sur la maladie rénale chronique</a>)</p>
<p>Qu'est-ce que l'eGFR ? C'est une estimation de la vitesse à laquelle les reins filtrent le sang. Elle s'exprime en ml/min/1,73 m², c'est-à-dire rapportée à une surface corporelle standard. Le laboratoire la calcule à partir du taux de créatinine dans le sang, de l'âge et du sexe selon l'équation CKD-EPI 2021, qui ne tient pas compte de l'origine ethnique. La créatinine dépend aussi de la masse musculaire et de l'alimentation, c'est pourquoi le médecin ajoute souvent un dosage de la cystatine C aux valeurs limites, ce qui rend l'estimation de la filtration plus précise. (<a href="https://www.niddk.nih.gov/research-funding/research-programs/kidney-clinical-research-epidemiology/laboratory/glomerular-filtration-rate-equations/adults">NIDDK, équations d'estimation du DFG chez l'adulte</a>)</p>
<p><img src="images/articles/co-znamenaju-stadia-chronickej-choroby-obliciek/01-gauge.webp" alt="Une jauge en demi-cercle avec un arc allant du turquoise au violet et une aiguille au milieu, symbole de l'estimation de la filtration rénale. Illustration sans texte sur fond clair." loading="lazy"></p>
<p>Selon la valeur de l'eGFR, la fonction rénale se répartit en catégories G1 à G5 :</p>
<div class="table-responsive">
<table>
<thead><tr><th scope="col">Catégorie</th><th scope="col">eGFR (ml/min/1,73 m²)</th><th scope="col">Signification</th></tr></thead>
<tbody>
<tr><td>G1</td><td>90 ou plus</td><td>filtration normale ou élevée</td></tr>
<tr><td>G2</td><td>60-89</td><td>filtration légèrement diminuée</td></tr>
<tr><td>G3a</td><td>45-59</td><td>filtration légèrement à modérément diminuée</td></tr>
<tr><td>G3b</td><td>30-44</td><td>filtration modérément à fortement diminuée</td></tr>
<tr><td>G4</td><td>15-29</td><td>filtration fortement diminuée</td></tr>
<tr><td>G5</td><td>moins de 15</td><td>insuffisance rénale terminale</td></tr>
</tbody>
</table>
</div>
<p>Les catégories G1 et G2 seules ne constituent pas une maladie en l'absence de signes de lésions rénales, notamment d'albuminurie augmentée. Le deuxième axe de la classification décrit donc la quantité de la protéine albumine qui passe dans l'urine. On mesure le rapport albuminurie/créatininurie, UACR, réparti en catégories A1 à A3 :</p>
<div class="table-responsive">
<table>
<thead><tr><th scope="col">Catégorie</th><th scope="col">UACR (mg/mmol)</th><th scope="col">UACR (mg/g)</th><th scope="col">Signification</th></tr></thead>
<tbody>
<tr><td>A1</td><td>moins de 3</td><td>moins de 30</td><td>albuminurie normale à légèrement augmentée</td></tr>
<tr><td>A2</td><td>3-30</td><td>30-300</td><td>albuminurie modérément augmentée</td></tr>
<tr><td>A3</td><td>plus de 30</td><td>plus de 300</td><td>albuminurie fortement augmentée</td></tr>
</tbody>
</table>
</div>
<p>Plus l'albuminurie est élevée, plus le risque est grand, non seulement pour les reins eux-mêmes, mais aussi pour le cœur et les vaisseaux. L'ancien terme « microalbuminurie » n'est plus utilisé selon KDIGO 2024. (<a href="https://www.kidney.org/how-to-classify-ckd">National Kidney Foundation, classification de la MRC</a>)</p>
<p><img src="images/articles/co-znamenaju-stadia-chronickej-choroby-obliciek/02-risk-grid.webp" alt="Une grille de cinq fois trois cases dans un cadre violet, du vert en haut à gauche en passant par le jaune et l'orange jusqu'au rouge en bas à droite. Une carte de chaleur du risque de progression de la maladie rénale. Illustration sans texte." loading="lazy"></p>
<p>La catégorie G et la catégorie A forment ensemble une carte des risques. Les cases vertes signifient un risque faible, les jaunes un risque accru, les oranges un risque élevé et les rouges un risque très élevé que la fonction rénale continue de baisser et que le système cardiovasculaire soit atteint lui aussi. L'indication CKD G3a A2 signifie donc une filtration modérément diminuée avec une albuminurie modérément augmentée, ce qui relève de la zone de risque accru, jaune.</p>
<p>Qu'est-ce que cela change en pratique ? Avant tout un suivi régulier, car la maladie rénale chronique ne fait pas mal pendant longtemps. L'eGFR et l'UACR sont contrôlés au fil du temps. En cas d'hypertension artérielle, KDIGO 2024 recommande de la traiter jusqu'à une pression systolique cible inférieure à 120 mmHg, lorsqu'elle est bien tolérée, mesurée selon un protocole standardisé au cabinet. Côté médicaments, en cas d'albuminurie et d'hypertension, le médecin envisagera un inhibiteur de l'enzyme de conversion ou un sartan, et en cas de diabète de type 2 avec maladie rénale, ou d'albuminurie marquée, également un inhibiteur SGLT2, car ces médicaments ralentissent prouvé la progression de la maladie rénale. C'est toujours votre médecin qui décide du traitement concret. (<a href="https://kdigo.org/wp-content/uploads/2024/03/KDIGO-2024-CKD-Guideline.pdf">KDIGO 2024 CKD Guideline, texte intégral, PDF</a>)</p>
<p><img src="images/articles/co-znamenaju-stadia-chronickej-choroby-obliciek/03-protection.webp" alt="Un rein violet au contour turquoise, devant lui un bouclier turquoise avec un cœur violet à l'intérieur. Symbole de la protection des reins et du cœur. Illustration sans texte sur fond clair." loading="lazy"></p>
<p>Vous pouvez agir beaucoup vous-même : ne pas fumer, consommer moins de 5 grammes de sel de table par jour, soit un apport de sodium inférieur à 2 grammes par jour, éviter en cas de douleur les médicaments du groupe des anti-inflammatoires non stéroïdiens comme l'ibuprofène ou le diclofénac sans avis médical, car dans la maladie rénale ils peuvent aggraver brutalement la fonction, surtout en cas de déshydratation, et consulter régulièrement, même si vous vous sentez bien.</p>
<p>Quand cela devient-il grave ? La catégorie G5, soit une eGFR inférieure à 15 ml/min/1,73 m², signifie une insuffisance rénale terminale. La dialyse ne commence pas automatiquement à un chiffre précis ; ce sont les symptômes, la vitesse de la baisse et l'état général qui décident. Dépistée et traitée tôt, de nombreuses personnes n'atteignent jamais le stade d'insuffisance rénale terminale ; si tel est l'horizon, un abord vasculaire est préparé à temps et une transplantation rénale est envisagée.</p>
<p>Les chiffres de votre compte rendu ne sont pas un verdict, ce sont une carte. Un stade précoce est un avantage, car c'est précisément à ce moment que l'évolution de la maladie peut être le plus ralentie. Lorsque vous voyez un G ou un A dans vos résultats, demandez à votre médecin dans quelle case de votre carte vous vous trouvez et ce que cela signifie pour vous.</p>
<p><em>Cet article est purement informatif et ne remplace pas un avis médical individuel. Votre stade, votre traitement et le rythme des contrôles sont décidés par votre médecin traitant ou votre néphrologue sur la base d'un examen complet.</em></p>

HTML,
        ],
        'es' => [
            'title' => 'Qué significa «CKD G3a A2» en su informe: los estadios de la enfermedad renal crónica explicados de forma sencilla',
            'image_alt' => 'Dos riñones morados frente a frente sobre un fondo claro. Encima, un arco de medidor de turquesa a morado con una aguja. Ilustración limpia sin texto.',
            'excerpt' => 'En los resultados de un análisis de sangre aparece a menudo la sigla eGFR, y en el informe médico algo como CKD G3a A2. Explicamos qué significan estas categorías, por qué la creatinina sola no basta y qué puede hacer para que su función renal se deteriore lo más lentamente posible.',
            'content' => <<<'HTML'
<p>Ha recibido los resultados de su análisis de sangre y en la fila «eGFR» ve el número 52. En el informe médico pone «CKD G3a A2». Parece un código, pero detrás hay una historia sencilla: sus riñones filtran la sangre más lentamente que unos riñones sanos, y su médico quiere saber cuánto y con qué rapidez cambia eso.</p>
<p>Según la definición KDIGO de 2024, la enfermedad renal crónica significa una alteración de la estructura o de la función de los riñones presente durante más de tres meses y con repercusión en la salud. Lo más frecuente es que sea consecuencia de la diabetes o de la hipertensión arterial. Afecta aproximadamente a uno de cada diez adultos en el mundo, a menudo sin ningún síntoma, por lo que suele detectarse solo en un análisis de sangre o de orina de rutina. (<a href="https://kdigo.org/guidelines/ckd-evaluation-and-management/">KDIGO 2024, guía sobre la enfermedad renal crónica</a>)</p>
<p>¿Qué es la eGFR? Es una estimación de la velocidad a la que los riñones filtran la sangre. Se expresa en ml/min/1,73 m², es decir, ajustado a una superficie corporal estándar. El laboratorio la calcula a partir del nivel de creatinina en sangre junto con la edad y el sexo según la ecuación CKD-EPI 2021, que no tiene en cuenta la raza. La propia creatinina depende también de la masa muscular y de la dieta, por eso el médico suele añadir la cistatina C en valores límite, lo que hace más precisa la estimación de la filtración. (<a href="https://www.niddk.nih.gov/research-funding/research-programs/kidney-clinical-research-epidemiology/laboratory/glomerular-filtration-rate-equations/adults">NIDDK, ecuaciones para estimar la TFG en adultos</a>)</p>
<p><img src="images/articles/co-znamenaju-stadia-chronickej-choroby-obliciek/01-gauge.webp" alt="Un medidor semicircular con un arco de turquesa a morado y una aguja en el centro, símbolo de la filtración renal estimada. Ilustración sin texto sobre fondo claro." loading="lazy"></p>
<p>Según el valor de eGFR, la función renal se divide en las categorías G1 a G5:</p>
<div class="table-responsive">
<table>
<thead><tr><th scope="col">Categoría</th><th scope="col">eGFR (ml/min/1,73 m²)</th><th scope="col">Significado</th></tr></thead>
<tbody>
<tr><td>G1</td><td>90 o más</td><td>filtración normal o alta</td></tr>
<tr><td>G2</td><td>60-89</td><td>filtración levemente disminuida</td></tr>
<tr><td>G3a</td><td>45-59</td><td>filtración levemente a moderadamente disminuida</td></tr>
<tr><td>G3b</td><td>30-44</td><td>filtración moderadamente a gravemente disminuida</td></tr>
<tr><td>G4</td><td>15-29</td><td>filtración gravemente disminuida</td></tr>
<tr><td>G5</td><td>menos de 15</td><td>insuficiencia renal</td></tr>
</tbody>
</table>
</div>
<p>Las categorías G1 y G2 por sí solas no son enfermedad si no hay signos de daño renal, sobre todo albuminuria aumentada. El segundo eje de la clasificación describe, por tanto, cuánta proteína albúmina pasa a la orina. Se mide como el cociente albúmina/creatinina en orina, UACR, y se divide en las categorías A1 a A3:</p>
<div class="table-responsive">
<table>
<thead><tr><th scope="col">Categoría</th><th scope="col">UACR (mg/mmol)</th><th scope="col">UACR (mg/g)</th><th scope="col">Significado</th></tr></thead>
<tbody>
<tr><td>A1</td><td>menos de 3</td><td>menos de 30</td><td>albuminuria normal o levemente aumentada</td></tr>
<tr><td>A2</td><td>3-30</td><td>30-300</td><td>albuminuria moderadamente aumentada</td></tr>
<tr><td>A3</td><td>más de 30</td><td>más de 300</td><td>albuminuria gravemente aumentada</td></tr>
</tbody>
</table>
</div>
<p>Cuanto mayor es la albuminuria, mayor es el riesgo, no solo para los riñones, sino también para el corazón y los vasos sanguíneos. El término antiguo «microalbuminuria» ya no si usa según KDIGO 2024. (<a href="https://www.kidney.org/how-to-classify-ckd">National Kidney Foundation, clasificación de la ERC</a>)</p>
<p><img src="images/articles/co-znamenaju-stadia-chronickej-choroby-obliciek/02-risk-grid.webp" alt="Una cuadrícula de cinco por tres celdas en un marco morado, de verde en la parte superior izquierda pasando por amarillo y naranja hasta rojo en la parte inferior derecha. Un mapa de calor del riesgo de progresión de la enfermedad renal. Ilustración sin texto." loading="lazy"></p>
<p>La categoría G y la categoría A forman juntas un mapa de riesgo. Las celdas verdes significan riesgo bajo, las amarillas riesgo aumentado, las naranjas riesgo alto y las rojas riesgo muy alto de que la función renal siga bajando y de que también se afecte el sistema cardiovascular. La indicación CKD G3a A2 significa, por tanto, filtración moderadamente disminuida con albuminuria moderadamente aumentada, lo que entra en la zona de riesgo aumentado, amarilla.</p>
<p>¿Qué cambia esto en la práctica? Sobre todo el seguimiento regular, porque la enfermedad renal crónica no duele durante mucho tiempo. Se controlan la eGFR y el UACR a lo largo del tiempo. Si tiene hipertensión arterial, KDIGO 2024 recomienda tratarla hasta una presión sistólica objetivo inferior a 120 mmHg, si se tolera bien, medida con un protocolo estandarizado en la consulta. En cuanto a la medicación, ante albuminuria e hipertensión el médico valorará un inhibidor de la ECA o un ARA II, y en la diabetes de tipo 2 con enfermedad renal, o ante una albuminuria marcada, también un inhibidor SGLT2, porque estos fármacos han demostrado enlentecer la progresión de la enfermedad renal. El tratamiento concreto siempre lo decide su médico. (<a href="https://kdigo.org/wp-content/uploads/2024/03/KDIGO-2024-CKD-Guideline.pdf">KDIGO 2024 CKD Guideline, texto completo, PDF</a>)</p>
<p><img src="images/articles/co-znamenaju-stadia-chronickej-choroby-obliciek/03-protection.webp" alt="Un riñón morado con contorno turquesa, delante un escudo turquesa con un corazón morado dentro. Símbolo de protección de los riñones y el corazón. Ilustración sin texto sobre fondo claro." loading="lazy"></p>
<p>Puede influir mucho usted mismo: no fumar, usar menos de 5 gramos de sal de mesa al día, lo que equivale a una ingesta de sodio inferior a 2 gramos diarios, evitar los analgésicos del grupo de los antiinflamatorios no esteroideos como el ibuprofeno o el diclofenaco sin consultar al médico, porque en la enfermedad renal pueden empeorar bruscamente la función, sobre todo si hay deshidratación, y acudir a los controles periódicos aunque se encuentre bien.</p>
<p>¿Cuándo es grave? La categoría G5, es decir una eGFR inferior a 15 ml/min/1,73 m², significa insuficiencia renal. La diálisis no comienza automáticamente con un número determinado, sino que deciden los síntomas, la velocidad de caída y el estado general. Detectada y tratada a tiempo, muchas personas nunca llegan al estadio de insuficiencia renal; si se apunta en esa dirección, se prepara a tiempo un acceso vascular y se valora un trasplante renal.</p>
<p>Los números de su informe no son una sentencia, son un mapa. Un estadio precoz es una ventaja, porque precisamente entonces se puede frenar más la enfermedad. Cuando vea una G o una A en sus resultados, pregunte a su médico en qué casilla de su mapa está y qué significa para usted.</p>
<p><em>Este artículo es meramente informativo y no sustituye el consejo médico individual. Su estadio, el tratamiento y la frecuencia de los controles los decide su médico o su nefrólogo a partir de una exploración completa.</em></p>

HTML,
        ],
        'pl' => [
            'title' => 'Co oznacza „CKD G3a A2” w wynikach: stadia przewlekłej choroby nerek wyjaśnione prosto',
            'image_alt' => 'Dwie fioletowe nerki leżą naprzeciw siebie na jasnym tle. Nad nimi łuk miernika od turkusowego do fioletowego ze wskazówką. Czysta ilustracja bez tekstu.',
            'excerpt' => 'W wynikach badań krwi często pojawia się skrót eGFR, a w skierowaniu lekarskim zapis taki jak CKD G3a A2. Wyjaśniamy, co oznaczają te kategorie, dlaczego sama kreatynina nie wystarcza i co można zrobić, aby funkcja nerek pogarszała się jak najwolniej.',
            'content' => <<<'HTML'
<p>Otrzymałeś wyniki badania krwi i w wierszu „eGFR” widzisz liczbę 52. W skierowaniu lekarskim stoi „CKD G3a A2”. Brzmi jak kod, ale kryje się za nim prosta historia: nerki filtrują krew wolniej niż zdrowe nerki, a lekarz chce wiedzieć, o ile i jak szybko się to zmienia.</p>
<p>Według definicji KDIGO z 2024 roku przewlekła choroba nerek oznacza odchylenie struktury lub funkcji nerek utrzymujące się ponad trzy miesiące i mające wpływ na zdrowie. Najczęściej jest skutkiem cukrzycy lub nadciśnienia tętniczego. Dotyka około jednego na dziesięciu dorosłych na świecie, często bez żadnych objawów, dlatego wykrywa się ją zwykle przypadkowo podczas rutynowego badania krwi lub moczu. (<a href="https://kdigo.org/guidelines/ckd-evaluation-and-management/">KDIGO 2024, wytyczne dotyczące przewlekłej choroby nerek</a>)</p>
<p>Czym jest eGFR? To szacunkowa wartość tego, jak szybko nerki filtrują krew. Podaje się ją w ml/min/1,73 m², czyli w przeliczeniu na standardową powierzchnię ciała. Laboratorium oblicza ją na podstawie stężenia kreatyniny we krwi oraz wieku i płci według równania CKD-EPI 2021, które nie uwzględnia rasy. Sama kreatynina zależy jednak od masy mięśniowej i diety, dlatego przy wartościach granicznych lekarz często zleca cystatynę C, dzięki czemu szacunek filtracji jest dokładniejszy. (<a href="https://www.niddk.nih.gov/research-funding/research-programs/kidney-clinical-research-epidemiology/laboratory/glomerular-filtration-rate-equations/adults">NIDDK, równania do szacowania GFR u dorosłych</a>)</p>
<p><img src="images/articles/co-znamenaju-stadia-chronickej-choroby-obliciek/01-gauge.webp" alt="Półkolisty miernik z łukiem od turkusowego do fioletowego i wskazówką pośrodku, symbol szacowanej filtracji nerek. Ilustracja bez tekstu na jasnym tle." loading="lazy"></p>
<p>W zależności od wartości eGFR funkcję nerek dzieli się na kategorie G1 do G5:</p>
<div class="table-responsive">
<table>
<thead><tr><th scope="col">Kategoria</th><th scope="col">eGFR (ml/min/1,73 m²)</th><th scope="col">Znaczenie</th></tr></thead>
<tbody>
<tr><td>G1</td><td>90 lub więcej</td><td>filtracja prawidłowa lub wysoka</td></tr>
<tr><td>G2</td><td>60-89</td><td>filtracja nieznacznie obniżona</td></tr>
<tr><td>G3a</td><td>45-59</td><td>filtracja nieznacznie do umiarkowanie obniżona</td></tr>
<tr><td>G3b</td><td>30-44</td><td>filtracja umiarkowanie do znacznie obniżona</td></tr>
<tr><td>G4</td><td>15-29</td><td>filtracja znacznie obniżona</td></tr>
<tr><td>G5</td><td>mniej niż 15</td><td>niewydolność nerek</td></tr>
</tbody>
</table>
</div>
<p>Kategorie G1 i G2 same w sobie nie są chorobą, jeśli nie ma oznak uszkodzenia nerek, przede wszystkim zwiększonej albuminurii. Druga oś klasyfikacji opisuje więc, ile białka albuminy przedostaje się do moczu. Mierzy się stosunek albuminy do kreatyniny w moczu, UACR, i dzieli na kategorie A1 do A3:</p>
<div class="table-responsive">
<table>
<thead><tr><th scope="col">Kategoria</th><th scope="col">UACR (mg/mmol)</th><th scope="col">UACR (mg/g)</th><th scope="col">Znaczenie</th></tr></thead>
<tbody>
<tr><td>A1</td><td>mniej niż 3</td><td>mniej niż 30</td><td>albuminuria prawidłowa do nieznacznie zwiększonej</td></tr>
<tr><td>A2</td><td>3-30</td><td>30-300</td><td>albuminuria umiarkowanie zwiększona</td></tr>
<tr><td>A3</td><td>więcej niż 30</td><td>więcej niż 300</td><td>albuminuria znacznie zwiększona</td></tr>
</tbody>
</table>
</div>
<p>Im wyższa albuminuria, tym większe ryzyko, nie tylko dla samych nerek, ale także dla serca i naczyń krwionośnych. Dawniejszy termin „mikroalbuminuria” nie jest już używany według KDIGO 2024. (<a href="https://www.kidney.org/how-to-classify-ckd">National Kidney Foundation, klasyfikacja PChN</a>)</p>
<p><img src="images/articles/co-znamenaju-stadia-chronickej-choroby-obliciek/02-risk-grid.webp" alt="Siatka pięć na trzy pól w fioletowej ramce, od zielonego w lewym górnym rogu przez żółte i pomarańczowe do czerwonego w prawym dolnym. Mapa cieplna ryzyka progresji choroby nerek. Ilustracja bez tekstu." loading="lazy"></p>
<p>Kategoria G i kategoria A razem tworzą mapę ryzyka. Zielone pola oznaczają niskie ryzyko, żółte podwyższone, pomarańczowe wysokie, a czerwone bardzo wysokie ryzyko, że funkcja nerek będzie dalej spadać i że dotknie to też układu sercowo-naczyniowego. Zapis CKD G3a A2 oznacza więc umiarkowanie obniżoną filtrację z umiarkowanie zwiększoną albuminurią, co mieści się w podwyższonej, żółtej strefie ryzyka.</p>
<p>Co to zmienia w praktyce? Przede wszystkim regularne kontrole, ponieważ PChN długo nie boli. Kontroluje się eGFR i UACR w czasie. Jeśli masz nadciśnienie, KDIGO 2024 zaleca leczenie do docelowego ciśnienia skurczowego poniżej 120 mmHg, jeśli jest dobrze tolerowane, mierzonego standaryzowanym sposobem w gabinecie. Jeśli chodzi o leki, przy albuminurii i nadciśnieniu lekarz rozważa inhibitor ACE lub sartan, a w cukrzycy typu 2 z chorobą nerek lub przy znacznej albuminurii także inhibitor SGLT2, ponieważ leki te udowodniono spowalniają postęp choroby nerek. O konkretnej terapii zawsze decyduje lekarz. (<a href="https://kdigo.org/wp-content/uploads/2024/03/KDIGO-2024-CKD-Guideline.pdf">KDIGO 2024 CKD Guideline, pełny tekst, PDF</a>)</p>
<p><img src="images/articles/co-znamenaju-stadia-chronickej-choroby-obliciek/03-protection.webp" alt="Fioletowa nerka z turkusowym konturem, przed nią turkusowa tarcza z fioletowym sercem w środku. Symbol ochrony nerek i serca. Ilustracja bez tekstu na jasnym tle." loading="lazy"></p>
<p>Wiele możesz zrobić sam: nie palić, używać mniej niż 5 gramów soli kuchennej dziennie, co odpowiada spożyciu sodu poniżej 2 gramów dziennie, unikać przy bólu leków z grupy niesteroidowych leków przeciwzapalnych, takich jak ibuprofen czy diklofenak, bez konsultacji z lekarzem, ponieważ w chorobie nerek mogą gwałtownie pogorszyć funkcję, zwłaszcza przy odwodnieniu, i chodzić na regularne kontrole, nawet gdy dobrze się czujesz.</p>
<p>Kiedy robi się poważnie? Kategoria G5, czyli eGFR poniżej 15 ml/min/1,73 m², oznacza niewydolność nerek. Dializa nie zaczyna się jednak automatycznie od konkretnej liczby, decydują objawy, tempo spadku i stan ogólny. Wcześnie wykryta i leczona, u wielu osób nigdy nie dochodzi do stadium niewydolności; jeśli się na nie zanosi, zawczasu przygotowuje się dostęp naczyniowy i rozważa przeszczepienie nerki.</p>
<p>Liczby w wynikach nie są wyrokiem, są mapą. Wczesne stadium to zaleta, bo właśnie wtedy można najbardziej spowolnić przebieg choroby. Gdy w wynikach zobaczysz literę G albo A, zapytaj lekarza, w które pole mapy należysz i co to dla ciebie oznacza.</p>
<p><em>Ten artykuł ma charakter informacyjny i nie zastępuje indywidualnej porady lekarskiej. O stadium, leczeniu i częstotliwości kontroli decyduje lekarz prowadzący lub nefrolog na podstawie pełnego badania.</em></p>

HTML,
        ],
        'hu' => [
            'title' => 'Mit jelent a „CKD G3a A2” a leletében: a krónikus vesebetegség stádiumai egyszerűen',
            'image_alt' => 'Két lila vese egymással szemben, világos háttéren. Felettük íves skála türkiztől liláig, mutatóval. Letisztult, szöveg nélküli illusztráció.',
            'excerpt' => 'A vérvételi eredményekben gyakran szerepel az eGFR rövidítés, az orvosi leletben pedig egy olyan jelölés, mint a CKD G3a A2. Elmagyarázzuk, mit jelentenek ezek a kategóriák, miért nem elég önmagában a kreatinin, és mit tehet azért, hogy a veseműködése minél lassabban romoljon.',
            'content' => <<<'HTML'
<p>Megkapta a vérvételi eredményeit, és az „eGFR” sorban az 52-es számot látja. Az orvosi leletben „CKD G3a A2” áll. Ez kódnak tűnik, de mögötte egyszerű történet rejlik: a veséi lassabban szűrik a vért, mint az egészséges vesék, és orvosa azt szeretné tudni, mennyivel és milyen gyorsan változik ez.</p>
<p>A 2024-es KDIGO meghatározása szerint a krónikus vesebetegség azt jelenti, hogy a vese szerkezete vagy működése több mint három hónapja eltér a normálistól, és ez hatással van az egészségre. Leggyakrabban cukorbetegség vagy magas vérnyomás következménye. A világon nagyjából minden tizedik felnőttet érinti, gyakran minden tünet nélkül, ezért általában csak véletlenszerű vér- vagy vizeletvizsgálat során derül ki. (<a href="https://kdigo.org/guidelines/ckd-evaluation-and-management/">KDIGO 2024, krónikus vesebetegségre vonatkozó irányelv</a>)</p>
<p>Mi az eGFR? Annak becslése, milyen gyorsan szűrik a vesék a vért. Mértékegysége ml/perc/1,73 m², vagyis szabványos testfelületre átszámítva. A laboratórium a vér kreatininszintjéből, életkorból és nemből számítja a CKD-EPI 2021 egyenlettel, amely nem veszi figyelembe a rasszt. Maga a kreatinin ugyanakkor az izomtömegtől és a táplálkozástól is függ, ezért határértékeknél az orvos gyakran cisztatin C vizsgálatot is kér, így a szűrés becslése pontosabb lesz. (<a href="https://www.niddk.nih.gov/research-funding/research-programs/kidney-clinical-research-epidemiology/laboratory/glomerular-filtration-rate-equations/adults">NIDDK, GFR-becslő egyenletek felnőtteknél</a>)</p>
<p><img src="images/articles/co-znamenaju-stadia-chronickej-choroby-obliciek/01-gauge.webp" alt="Félkör alakú skála ívvel türkiztől liláig, középen mutatóval, a becsült veseszűrés szimbóluma. Szöveg nélküli illusztráció világos háttéren." loading="lazy"></p>
<p>Az eGFR értéke alapján a vesefunkciót G1-től G5-ig kategóriákba soroljuk:</p>
<div class="table-responsive">
<table>
<thead><tr><th scope="col">Kategória</th><th scope="col">eGFR (ml/perc/1,73 m²)</th><th scope="col">Jelentés</th></tr></thead>
<tbody>
<tr><td>G1</td><td>90 vagy több</td><td>normális vagy magas szűrés</td></tr>
<tr><td>G2</td><td>60-89</td><td>enyhén csökkent szűrés</td></tr>
<tr><td>G3a</td><td>45-59</td><td>enyhén vagy közepesen csökkent szűrés</td></tr>
<tr><td>G3b</td><td>30-44</td><td>közepesen vagy súlyosan csökkent szűrés</td></tr>
<tr><td>G4</td><td>15-29</td><td>súlyosan csökkent szűrés</td></tr>
<tr><td>G5</td><td>kevesebb mint 15</td><td>veseelégtelenség</td></tr>
</tbody>
</table>
</div>
<p>A G1 és G2 kategória önmagában még nem betegség, ha nincs vesekárosodásra utaló jel, mindenekelőtt fokozott albuminuria. Az osztályozás másik tengelye tehát azt írja le, mennyi albumin fehérje jut a vizeletbe. Ezt a vizelet albumin/kreatinin arányaként, UACR-ként mérik, és A1-től A3-ig kategóriákra osztják:</p>
<div class="table-responsive">
<table>
<thead><tr><th scope="col">Kategória</th><th scope="col">UACR (mg/mmol)</th><th scope="col">UACR (mg/g)</th><th scope="col">Jelentés</th></tr></thead>
<tbody>
<tr><td>A1</td><td>kevesebb mint 3</td><td>kevesebb mint 30</td><td>normális vagy enyhén emelkedett albuminuria</td></tr>
<tr><td>A2</td><td>3-30</td><td>30-300</td><td>közepesen emelkedett albuminuria</td></tr>
<tr><td>A3</td><td>több mint 30</td><td>több mint 300</td><td>súlyosan emelkedett albuminuria</td></tr>
</tbody>
</table>
</div>
<p>Minél magasabb az albuminuria, annál nagyobb a kockázat, nemcsak a vesékre, hanem a szívre és az erekre is. A régi „mikroalbuminuria” kifejezést a KDIGO 2024 már nem használja. (<a href="https://www.kidney.org/how-to-classify-ckd">National Kidney Foundation, CKD osztályozása</a>)</p>
<p><img src="images/articles/co-znamenaju-stadia-chronickej-choroby-obliciek/02-risk-grid.webp" alt="Ötször három mezős rács lila keretben, balról fent zöldből sárgán és narancssárgán át pirosig jobbra lent. A vesebetegség előrehaladásának kockázati hőtérképe. Szöveg nélküli illusztráció." loading="lazy"></p>
<p>A G és az A kategória együtt kockázati térképet ad. A zöld mezők alacsony, a sárga fokozott, a narancssárga magas, a piros nagyon magas kockázatot jelent arra, hogy a vesefunkció tovább romlik, és a szív-érrendszer is érintett lesz. A CKD G3a A2 jelölés tehát közepesen csökkent szűrést jelent közepesen emelkedett albuminuriával, ami a fokozott, sárga kockázati zónába tartozik.</p>
<p>Mit változtat ez a gyakorlatban? Mindenekelőtt a rendszeres ellenőrzést, mert a krónikus vesebetegség sokáig nem fáj. Idővel ellenőrzik az eGFR-t és az UACR-t is. Ha magas a vérnyomása, a KDIGO 2024 azt javasolja, hogy kezeljék 120 Hgmm alatti szisztolés célvérnyomásra, ha jól tolerálható, szabványosított rendelői méréssel. Gyógyszerek tekintetében albuminuria és magas vérnyomás esetén az orvos ACE-gátlót vagy sartánt fontol meg, cukorbetegség esetén pedig 2-es típusú cukorbetegséggel és vesebetegséggel, illetve jelentős albuminuriával SGLT2-gátlót is, mert ezekről a gyógyszerekről bizonyítottan kimutatták, hogy lassítják a vesebetegség előrehaladását. A konkrét terápiáról mindig az orvosa dönt. (<a href="https://kdigo.org/wp-content/uploads/2024/03/KDIGO-2024-CKD-Guideline.pdf">KDIGO 2024 CKD Guideline, teljes szöveg, PDF</a>)</p>
<p><img src="images/articles/co-znamenaju-stadia-chronickej-choroby-obliciek/03-protection.webp" alt="Lila vese türkiz körvonallal, előtte türkiz pajzs lila szívvel a közepén. A vesék és a szív védelmének szimbóluma. Szöveg nélküli illusztráció világos háttéren." loading="lazy"></p>
<p>Sokat tehet saját magáért: ne dohányozzon, naponta 5 grammnál kevesebb konyhasót fogyasszon, ami napi 2 grammnál kevesebb náliumbevitelnek felel meg, fájdalom esetén pedig kerülje az orvosi konzultáció nélkül szedett nem szteroid gyulladáscsökkentőket, például ibuprofent vagy diklofenakot, mert vesebetegségben hirtelen ronthatják a működést, főleg kiszáradás esetén, és járjon rendszeres kontrollra akkor is, ha jól érzi magát.</p>
<p>Mikor válik komollyá? A G5 kategória, vagyis az 15 ml/perc/1,73 m² alatti eGFR veseelégtelenséget jelent. A dialízis ugyanakkor nem egy adott számnál kezdődik automatikusan, hanem a tünetek, a romlás üteme és az általános állapot döntenek. Korán felismerve és kezelve sokan soha nem jutnak el a veseelégtelenség stádiumáig; ha mégis afelé halad az állapot, időben érbeömlést készítenek elő, és vesetranszplantációt fontolgatnak.</p>
<p>A leletben szereplő számok nem ítéletet, hanem térképet jelentenek. A korai stádium előny, mert éppen akkor lehet a betegség lefolyását a legjobban lassítani. Ha G vagy A betűt lát az eredményeiben, kérdezze meg orvosát, melyik mezőjébe tartozik a térképének, és mit jelent ez Önnek.</p>
<p><em>Ez a cikk tájékoztató jellegű, és nem helyettesíti az egyéni orvosi tanácsadást. A stádiumról, a kezelésről és az ellenőrzések gyakoriságáról a kezelőorvosa vagy nefrológusa dönt a teljes kivizsgálás alapján.</em></p>

HTML,
        ],
        'it' => [
            'title' => 'Cosa significa «CKD G3a A2» nel suo referto: gli stadi della malattia renale cronica spiegati semplicemente',
            'image_alt' => 'Due reni viola uno di fronte all\'altro su sfondo chiaro. Sopra, un arco di misuratore dal turchese al viola con un ago. Illustrazione pulita senza testo.',
            'excerpt' => 'negli esami del sangue trova spesso la sigla eGFR e nel referto medico una dicitura come CKD G3a A2. Spieghiamo cosa significano queste categorie, perché la creatinina da sola non basta e cosa può fare per rallentare il più possibile il peggioramento della funzione dei suoi reni.',
            'content' => <<<'HTML'
<p>Ha ricevuto i risultati degli esami del sangue e nella riga «eGFR» vede il numero 52. Nel referto medico c'è scritto «CKD G3a A2». Sembra un codice, ma dietro c'è una storia semplice: i suoi reni filtrano il sangue più lentamente dei reni sani, e il medico vuole sapere di quanto e quanto velocemente cambia.</p>
<p>Secondo la definizione KDIGO del 2024, la malattia renale cronica significa un'alterazione della struttura o della funzione dei reni presente da più di tre mesi e con conseguenze sulla salute. Il più delle volte è una conseguenza del diabete o dell'ipertensione. Colpisce circa un adulto su dieci nel mondo, spesso senza alcun sintomo, quindi viene scoperta di solito solo con un esame del sangue o delle urine di routine. (<a href="https://kdigo.org/guidelines/ckd-evaluation-and-management/">KDIGO 2024, linea guida sulla malattia renale cronica</a>)</p>
<p>Che cos'è l'eGFR? È una stima della velocità con cui i reni filtrano il sangue. Si expresa in ml/min/1,73 m², cioè rapportata a una superficie corporea standard. Il laboratorio la calcola dal livello di creatinina nel sangue insieme a età e sesso con l'equazione CKD-EPI 2021, che non tiene conto della razza. La creatinina stessa dipende anche dalla massa muscolare e dall'alimentazione, ecco perché il medico ai valori al limite aggiunge spesso la cistatina C, rendendo la stima della filtrazione più precisa. (<a href="https://www.niddk.nih.gov/research-funding/research-programs/kidney-clinical-research-epidemiology/laboratory/glomerular-filtration-rate-equations/adults">NIDDK, equazioni per stimare il GFR negli adulti</a>)</p>
<p><img src="images/articles/co-znamenaju-stadia-chronickej-choroby-obliciek/01-gauge.webp" alt="Un misuratore semicircolare con un arco dal turchese al viola e un ago al centro, simbolo della filtrazione renale stimata. Illustrazione senza testo su sfondo chiaro." loading="lazy"></p>
<p>In base al valore di eGFR la funzione renale si divide nelle categorie G1 fino a G5:</p>
<div class="table-responsive">
<table>
<thead><tr><th scope="col">Categoria</th><th scope="col">eGFR (ml/min/1,73 m²)</th><th scope="col">Significato</th></tr></thead>
<tbody>
<tr><td>G1</td><td>90 o più</td><td>filtrazione normale o alta</td></tr>
<tr><td>G2</td><td>60-89</td><td>filtrazione lievemente ridotta</td></tr>
<tr><td>G3a</td><td>45-59</td><td>filtrazione lievemente o moderatamente ridotta</td></tr>
<tr><td>G3b</td><td>30-44</td><td>filtrazione moderatamente o gravemente ridotta</td></tr>
<tr><td>G4</td><td>15-29</td><td>filtrazione gravemente ridotta</td></tr>
<tr><td>G5</td><td>meno di 15</td><td>insufficienza renale</td></tr>
</tbody>
</table>
</div>
<p>Le categorie G1 e G2 da sole non sono malattia se non ci sono segni di danno renale, soprattutto albuminuria aumentata. Il secondo asse della classificazione descrive quindi quanta proteina albumina passa nelle urine. Si misura come rapporto albumina/creatinina nelle urine, UACR, e si divide nelle categorie A1 fino a A3:</p>
<div class="table-responsive">
<table>
<thead><tr><th scope="col">Categoria</th><th scope="col">UACR (mg/mmol)</th><th scope="col">UACR (mg/g)</th><th scope="col">Significato</th></tr></thead>
<tbody>
<tr><td>A1</td><td>meno di 3</td><td>meno di 30</td><td>albuminuria normale o lievemente aumentata</td></tr>
<tr><td>A2</td><td>3-30</td><td>30-300</td><td>albuminuria moderatamente aumentata</td></tr>
<tr><td>A3</td><td>più di 30</td><td>più di 300</td><td>albuminuria gravemente aumentata</td></tr>
</tbody>
</table>
</div>
<p>Più l'albuminuria è alta, maggiore è il rischio, non solo per i reni stessi ma anche per il cuore e i vasi sanguigni. Il vecchio termine «microalbuminuria» non si usa più secondo KDIGO 2024. (<a href="https://www.kidney.org/how-to-classify-ckd">National Kidney Foundation, classificazione della MRC</a>)</p>
<p><img src="images/articles/co-znamenaju-stadia-chronickej-choroby-obliciek/02-risk-grid.webp" alt="Una griglia di cinque per tre celle in una cornice viola, dal verde in alto a sinistra passando per il giallo e l'arancione fino al rosso in basso a destra. Una mappa di calore del rischio di progressione della malattia renale. Illustrazione senza testo." loading="lazy"></p>
<p>La categoria G e la categoria A insieme formano una mappa del rischio. Le celle verdi significano rischio basso, gialle rischio aumentato, arancioni rischio alto e rosse rischio molto alto che la funzione renale continui a scendere e che venga colpito anche il sistema cardiovascolare. La dicitura CKD G3a A2 significa quindi filtrazione moderatamente ridotta con albuminuria moderatamente aumentata, che rientra nella zona di rischio aumentato, gialla.</p>
<p>Cosa cambia nella pratica? Prima di tutto il monitoraggio regolare, perché la malattia renale cronica non fa male a lungo. Si controllano nel tempo eGFR e UACR. Se ha la pressione alta, KDIGO 2024 consiglia di trattarla fino a un obiettivo di pressione sistolica inferiore a 120 mmHg, se ben tollerata, misurata con protocollo standardizzato in ambulatorio. Quanto ai farmaci, con albuminuria e pressione alta il medico prenderà in considerazione un ACE-inibitore o un sartano e, nel diabete di tipo 2 con malattia renale o con albuminuria marcata, anche un inibitore SGLT2, perché questi farmaci hanno dimostrato di rallentare la progressione della malattia renale. La terapia concreta la decide sempre il medico. (<a href="https://kdigo.org/wp-content/uploads/2024/03/KDIGO-2024-CKD-Guideline.pdf">KDIGO 2024 CKD Guideline, testo integrale, PDF</a>)</p>
<p><img src="images/articles/co-znamenaju-stadia-chronickej-choroby-obliciek/03-protection.webp" alt="Un rene viola con contorno turchese, davanti uno scudo turchese con un cuore viola all'interno. Simbolo della protezione di reni e cuore. Illustrazione senza testo su sfondo chiaro." loading="lazy"></p>
<p>Può fare molto da solo: non fumare, usare meno di 5 grammi di sale da cucina al giorno, pari a un apporto di sodio inferiore a 2 grammi al giorno, evitare in caso di dolore i farmaci antinfiammatori non steroidei come ibuprofene o diclofenac senza consultare il medico, perché nella malattia renale possono peggiorare improvvisamente la funzione, soprattutto in caso di disidratazione, e fare controlli regolari anche quando si sente bene.</p>
<p>Quando diventa grave? La categoria G5, cioè eGFR inferiore a 15 ml/min/1,73 m², significa insufficienza renale. La dialisi però non inizia automaticamente a un numero preciso: decidono i sintomi, la velocità del calo e lo stato generale. Se individuata e curata presto, molte persone non arrivano mai allo stadio di insufficienza renale; se ci si avvia, si prepara per tempo l'accesso vascolare e si valuta il trapianto di rene.</p>
<p>I numeri nel referto non sono una sentenza, sono una mappa. Uno stadio precoce è un vantaggio, perché è proprio allora che si può rallentare di più il decorso della malattia. Quando vede una G o una A nei risultati, chieda al medico in quale casella della sua mappa si trova e cosa significa per lei.</p>
<p><em>Questo articolo ha solo scopo informativo e non sostituisce la consulenza medica individuale. Stadio, terapia e frequenza dei controlli li decide il medico curante o il nefrologo sulla base dell'esame completo.</em></p>

HTML,
        ],
        'uk' => [
            'title' => 'Що означає «CKD G3a A2» у вашому аналізі: стадії хронічної хвороби нирок простою мовою',
            'image_alt' => 'Дві фіолетові нирки лежать одна навпроти одної на світлому тлі. Над ними дуга шкали від бірюзового до фіолетового з показником. Чиста ілюстрація без тексту.',
            'excerpt' => 'У результатах аналізу крові часто трапляється абревіатура eGFR, а в медичному висновку написано щось на кшталт CKD G3a A2. Пояснюємо, що означають ці категорії, чому одного креатиніну недостатньо і що ви можете зробити, аби функція ваших нирок погіршувалася якомога повільніше.',
            'content' => <<<'HTML'
<p>Ви отримали результати аналізу крові, і в рядку «eGFR» бачите число 52. У медичному висновку написано «CKD G3a A2». Це схоже на код, але за ним проста історія: ваші нирки фільтрують кров повільніше, ніж здорові нирки, і лікар хоче знати, наскільки і як швидко це змінюється.</p>
<p>За визначенням KDIGO 2024 року хронічна хвороба нирок означає відхилення структури чи функції нирок, яке триває понад три місяці і впливає на здоров'я. Найчастіше це наслідок діабету або підвищеного артеріального тиску. Вона вражає приблизно кожного десятого дорослого у світі, часто без будь-яких симптомів, тому виявляється зазвичай лише під час планового аналізу крові чи сечі. (<a href="https://kdigo.org/guidelines/ckd-evaluation-and-management/">KDIGO 2024, настанова щодо хронічної хвороби нирок</a>)</p>
<p>Що таке eGFR? Це оцінка того, як швидко нирки фільтрують кров. Вона подається в мл/хв/1,73 м², тобто в перерахунку на стандартну поверхню тіла. Лабораторія обчислює її за рівнем креатиніну в крові разом із віком і статтю за рівнянням CKD-EPI 2021, яке не враховує расу. Сам креатинін при цьому залежить іще від м'язової маси та харчування, тому на межових значеннях лікар часто додає цистатин C, і тоді оцінка фільтрації точніша. (<a href="https://www.niddk.nih.gov/research-funding/research-programs/kidney-clinical-research-epidemiology/laboratory/glomerular-filtration-rate-equations/adults">NIDDK, рівняння для оцінки ШКФ у дорослих</a>)</p>
<p><img src="images/articles/co-znamenaju-stadia-chronickej-choroby-obliciek/01-gauge.webp" alt="Напівкругла шкала з дугою від бірюзового до фіолетового і показником посередині, символ оціненої фільтрації нирок. Ілюстрація без тексту на світлому тлі." loading="lazy"></p>
<p>За значенням eGFR функцію нирок поділяють на категорії G1 až G5:</p>
<div class="table-responsive">
<table>
<thead><tr><th scope="col">Категорія</th><th scope="col">eGFR (мл/хв/1,73 м²)</th><th scope="col">Значення</th></tr></thead>
<tbody>
<tr><td>G1</td><td>90 і більше</td><td>нормальна або висока фільтрація</td></tr>
<tr><td>G2</td><td>60-89</td><td>незначно знижена фільтрація</td></tr>
<tr><td>G3a</td><td>45-59</td><td>незначно або помірно знижена фільтрація</td></tr>
<tr><td>G3b</td><td>30-44</td><td>помірно або значно знижена фільтрація</td></tr>
<tr><td>G4</td><td>15-29</td><td>значно знижена фільтрація</td></tr>
<tr><td>G5</td><td>менше ніж 15</td><td>ниркова недостатність</td></tr>
</tbody>
</table>
</div>
<p>Категорії G1 і G2 самі по собі не є хворобою, якщо немає ознак ушкодження нирок, насамперед підвищеної альбумінурії. Друга вісь класифікації описує, скільки білка альбуміну потрапляє в сечу. Її вимірюють як співвідношення альбуміну до креатиніну в сечі, UACR, і поділяють на категорії A1 až A3:</p>
<div class="table-responsive">
<table>
<thead><tr><th scope="col">Категорія</th><th scope="col">UACR (мг/ммоль)</th><th scope="col">UACR (мг/г)</th><th scope="col">Значення</th></tr></thead>
<tbody>
<tr><td>A1</td><td>менше ніж 3</td><td>менше ніж 30</td><td>нормальна або незначно підвищена альбумінурія</td></tr>
<tr><td>A2</td><td>3-30</td><td>30-300</td><td>помірно підвищена альбумінурія</td></tr>
<tr><td>A3</td><td>більше ніж 30</td><td>більше ніж 300</td><td>значно підвищена альбумінурія</td></tr>
</tbody>
</table>
</div>
<p>Що вища альбумінурія, то більший ризик, і не лише для самих нирок, а й для серця та судин. Старий термін «мікроальбумінурія» згідно з KDIGO 2024 більше не вживається. (<a href="https://www.kidney.org/how-to-classify-ckd">National Kidney Foundation, класифікація ХНН</a>)</p>
<p><img src="images/articles/co-znamenaju-stadia-chronickej-choroby-obliciek/02-risk-grid.webp" alt=" Ґратка п'ять на три клітинки у фіолетовій рамці, від зеленого зліва згори через жовте й помаранчеве до червоного справа знизу. Теплова мапа ризику прогресування хвороби нирок. Ілюстрація без тексту." loading="lazy"></p>
<p>Категорія G і категорія A разом утворюють мапу ризику. Зелені клітинки означають низький ризик, жовті підвищений, помаранчеві високий, а червоні дуже високий ризик того, що функція нирок і далі знижуватиметься і постраждає серцево-судинна система. Позначення CKD G3a A2 означає тому помірно знижену фільтрацію з помірно підвищеною альбумінурією, тобто належить до підвищеної, жовтої зони ризику.</p>
<p>Що це змінює на практиці? Насамперед регулярне спостереження, бо хронічна хвороба нирок довго не болить. Контролюють eGFR і UACR у динаміці. Якщо у вас високий тиск, KDIGO 2024 рекомендує лікувати його до цільового систолічного тиску нижче за 120 мм рт. ст., якщо він добре переноситься, за стандартизованого вимірювання в амбулаторії. Щодо ліків, то при альбумінурії та високому тиску лікар розгляне інгібітор АПФ або сартан, а при діабеті 2-го типу з хворобою нирок чи при вираженій альбумінурії також інгібітор SGLT2, бо ці препарати доведено сповільнюють прогресування хвороби нирок. Конкретне лікування завжди визначає ваш лікар. (<a href="https://kdigo.org/wp-content/uploads/2024/03/KDIGO-2024-CKD-Guideline.pdf">KDIGO 2024 CKD Guideline, повний текст, PDF</a>)</p>
<p><img src="images/articles/co-znamenaju-stadia-chronickej-choroby-obliciek/03-protection.webp" alt="Фіолетова нирка з бірюзовим контуром, перед нею бірюзовий щит із фіолетовим серцем усередині. Символ захисту нирок і серця. Ілюстрація без тексту на світлому тлі." loading="lazy"></p>
<p>Багато чого можете зробити самі: не курити, вживати менше ніж 5 грамів кухонної солі на день, що відповідає споживанню натрію менше ніж 2 грами на день, уникати при болю без консультації з лікарем нестероїдних протизапальних препаратів, як-от ібупрофен чи диклофенак, бо при хворобі нирок вони можуть раптово погіршити функцію, особливо при зневодненні, і ходити на регулярні огляди, навіть коли добре себе почуваєте.</p>
<p>Коли стає серйозно? Категорія G5, тобто eGFR нижче за 15 мл/хв/1,73 м², означає ниркову недостатність. Діаліз при цьому починається не автоматично за певним числом, а вирішують симптоми, темп падіння та загальний стан. За раннього виявлення та лікування багато людей ніколи не доходять до стадії ниркової недостатності; якщо до неї йдеться, заздалегідь готують судинний доступ і розглядають трансплантацію нирки.</p>
<p>Цифри у вашому висновку це не вирок, а мапа. Рання стадія це перевага, бо саме тоді перебіг хвороби можна найбільше загальмувати. Коли бачите у результатах літеру G чи A, запитайте лікаря, в яку клітинку вашої мапи ви потрапляєте і що це означає для вас.</p>
<p><em>Ця стаття має інформаційний характер і не замінює індивідуальну медичну консультацію. Про вашу стадію, лікування та частоту контрольних оглядів вирішує ваш лікар чи нефролог на підставі повного обстеження.</em></p>

HTML,
        ],
    ],
];
