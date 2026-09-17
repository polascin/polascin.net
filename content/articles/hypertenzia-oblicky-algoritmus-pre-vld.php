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
 * Edukačný príspevok o rukopise pre Via practica: hypertenzia, obličky a algoritmus pre VLD.
 * Zdroj: finalizácia rukopisu s Michaelou Malovou (SOLEN), 11.–14. 9. 2026.
 */
return [
    'slug' => 'hypertenzia-oblicky-algoritmus-pre-vld',
    'author' => 'MUDr. Ľubomír Polaščín',
    'category' => 'blog',
    'is_top' => 0,
    'published_at' => '2026-09-17 18:55:00',
    'translations' => [
        'sk' => [
            'title' => 'Ochorenie obličiek zachytíme neskoro, lebo odporúčania sa nedostanú k lekárom, ktorí pacienta vidia ako prví.',
            'excerpt' => 'S redaktorkou Michaelou Malovou zo SOLEN sme dokončili rukopis pre Via practica: algoritmus pre VLD, ako z KDIGO a ESH urobiť rozhodnutie v bežnej ambulancii — kedy skríning, kedy odoslať, kedy začať liečbu ešte pred odoslaním.',
            'content' => <<<'HTML'
<p>Väčšinu ochorení obličiek zachytíme neskoro, lebo guidelines sa nedostanú k lekárom, ktorí pacienta vidia ako prví.</p>
<p>Tento týždeň som s Michaelou Malovou, redaktorkou vydavateľstva SOLEN, dokončil rukopis pre časopis <a href="https://www.solen.sk/sk/casopisy/via-practica">Via practica</a>. Názov: <em>Hypertenzia a obličky: nové odporúčania a algoritmus pre VLD</em>. VLD sú všeobecní lekári pre dospelých na Slovensku.</p>
<p>Problém, ktorý text rieši, je jednoduchý a tvrdošijný. Nefrologické odporúčania píšu nefrológovia pre nefrológov. Pacient, u ktorého sa rozvinie chronické ochorenie obličiek, však do nefrologickej ambulancie nepríde ako prvý. Príde k svojmu obvodnému lekárovi s vysokým krvným tlakom.</p>
<p>Kým sa ku mne dostane, eGFR už často klesol pod 60&nbsp;ml/min/1,73&nbsp;m². Okno na zásah — inhibítory SGLT2, blokáda RAAS, úprava životosprávy — bolo o mesiace alebo roky skôr.</p>
<p>Preto sme aktuálne odporúčania KDIGO a ESH stiahli do jedného algoritmu, ktorý vie všeobecný lekár použiť počas bežnej konzultácie. Kedy skrínovať. Kedy odoslať. Kedy začať farmakoterapiu ešte pred odoslaním.</p>
<p>Algoritmus nie je prelomový. To je zámer. Poznanie existuje. Medzera je v doručení — dostať ho k ľuďom, ktorí stoja na začiatku cesty starostlivosti, nie na jej konci.</p>
<p>Ak pracujete v špecializovanom odbore: ktorý jeden kúsok vášho poznania by zajtra najviac zmenil prax, keby sa dostal k všeobecným lekárom? Napíšte mi cez <a href="contact.php">kontakt</a>.</p>
<p><em>Ide o sprievodný text k rukopisu, nie o náhradu originálnych odporúčaní KDIGO a ESH ani o liečebné rozhodnutie pre konkrétneho pacienta.</em></p>
HTML,
        ],
        'en' => [
            'title' => 'Most kidney disease is caught too late because the guidelines never reach the doctors who see patients first.',
            'excerpt' => 'With Michaela Malová at SOLEN I finished a Via practica manuscript: an algorithm for Slovak primary-care physicians that turns KDIGO and ESH guidance into a routine consult — when to screen, when to refer, when to start treatment before the referral.',
            'content' => <<<'HTML'
<p>Most kidney disease is caught too late because the guidelines never reach the doctors who see patients first.</p>
<p>This week I finalized a manuscript with Michaela Malová, editor at SOLEN, for the journal <a href="https://www.solen.sk/en/journals/via-practica">Via practica</a>. The title: <em>Hypertension and Kidneys: New Recommendations and Algorithm for VLD</em> — VLD being adult primary-care physicians in Slovakia.</p>
<p>The problem it addresses is simple and stubborn. Nephrology guidelines are written by nephrologists, for nephrologists. But the patient who will develop CKD does not walk into a nephrology clinic first. They walk into their family doctor with high blood pressure.</p>
<p>By the time they reach me, the eGFR has often already dropped below 60&nbsp;ml/min/1.73&nbsp;m². The window for intervention — SGLT2 inhibitors, RAAS blockade, lifestyle modification — was months or years earlier.</p>
<p>So we distilled the current KDIGO and ESH recommendations into a single algorithm a primary-care physician can follow during a routine consult. When to screen. When to refer. When to start pharmacotherapy before the referral even happens.</p>
<p>The algorithm is not groundbreaking. That is the point. The knowledge exists. The gap is in delivery — getting it to the people who stand at the entrance of the care pathway, not the end.</p>
<p>If you work in a specialist field, what is one piece of your knowledge that would have the most impact if it reached primary care tomorrow? Write to me via the <a href="contact.php">contact form</a>.</p>
<p><em>This is a companion note to a manuscript, not a substitute for the original KDIGO and ESH recommendations, and not treatment advice for an individual patient.</em></p>
HTML,
        ],
    ],
];
