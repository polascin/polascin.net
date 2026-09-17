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
 * Osobný blogový príspevok: prechod medzi molekulami GLP-1 pri liečbe Medrolom.
 * Zdroj: vlastný e-mail diabetológovi z 13. 9. 2026.
 */
return [
    'slug' => 'lekar-ako-pacient-glp1-a-kortikosteroidy',
    'author' => 'MUDr. Ľubomír Polaščín',
    'category' => 'blog',
    'is_top' => 1,
    'published_at' => '2026-09-17 18:45:00',
    'translations' => [
        'sk' => [
            'title' => 'Lekári sú najpozornejší pacienti',
            'excerpt' => 'Čo som sa naučil pri prechode medzi tromi molekulami GLP-1, kým som zároveň užíval Medrol. Glykémie 16–18 mmol/l, návrat potravinového šumu a pohľad lekára, ktorý je zároveň pacientom.',
            'content' => <<<'HTML'
<p>Minulý týždeň som prešiel zo semaglutidu na tirzepatid (Mounjaro 5&nbsp;mg). Dôvod bol prostý: zároveň užívam Medrol a hyperglykémia vyvolaná kortikosteroidmi je brutálna. Glykémie 16–18&nbsp;mmol/l. Dávky inzulínu NovoMix, ktoré som mesiace nepotreboval.</p>
<p>Prekvapilo ma však niečo iné: návrat potravinového šumu — <em>food noise</em>.</p>
<p>To stále, vtieravé myslenie na jedlo, ktoré semaglutid potichu vypol, sa vrátilo v priebehu dní po zmene. Nie preto, že by bol tirzepatid slabší. Ale preto, že súhra medzi signálmi chuti do jedla a inzulínovou rezistenciou z kortikosteroidov je zložitejšia, než vysvetlí jeden receptor.</p>
<p>Nízkosacharidové jedlá to paradoxne zhoršili. Bielkoviny a tuk bez sacharidov hlad prehĺbili, namiesto toho, aby ho utíšili. Takú vec si prečítate v štúdiách; inak ju cítite, keď ide o vlastné telo.</p>
<p>V tom istom období som stihol aj krátky pokus s retratrutidom. Iná molekula, iný receptorový profil, iný zážitok. Dáta o týchto liekoch sa hýbu rýchlejšie, než stíhajú klinické odporúčania.</p>
<p>Nejde o to, ktorá molekula „vyhrala“. Ide o to, že ako lekár som vedel zdokumentovať každú premennú. Ako pacient som každú z nich cítil. Takýto dvojitý pohľad by som prial zažiť viacerým kolegom na vlastnej koži.</p>
<p>Ak pracujete s pacientmi na inkretínovej liečbe — najmä súbežne so steroidmi — aké vzorce ste videli? Napíšte mi cez <a href="contact.php">kontakt</a>.</p>
<p><em>Ide o osobnú skúsenosť, nie o liečebné odporúčanie. Rozhodnutia o liečbe patria do rozhovoru s ošetrujúcim lekárom.</em></p>
HTML,
        ],
        'en' => [
            'title' => 'Doctors make the most observant patients',
            'excerpt' => 'What I learned switching between three GLP-1 molecules while on Medrol. Glucose spikes of 16–18 mmol/L, the return of food noise, and the view from a physician who is also the patient.',
            'content' => <<<'HTML'
<p>Last week I moved from semaglutide to tirzepatide (Mounjaro 5&nbsp;mg). The reason was straightforward: I am also on Medrol, and corticosteroid-induced hyperglycemia is brutal. Glucose spikes of 16–18&nbsp;mmol/L. NovoMix insulin doses I had not needed in months.</p>
<p>What surprised me was the return of food noise.</p>
<p>That constant, intrusive thinking about food — the thing semaglutide had quietly switched off — came back within days of the switch. Not because tirzepatide is weaker. But because the interplay between appetite signaling and corticosteroid-driven insulin resistance is more complex than any single receptor explains.</p>
<p>Low-carb meals made it worse, paradoxically. Protein and fat without carbohydrate deepened the hunger rather than satisfying it. The kind of thing you read about in trials but feel differently when it is your own body.</p>
<p>I also ran a short retatrutide trial during this period. A different molecule, a different receptor profile, a different experience. The data on these drugs is moving faster than clinical guidelines can track.</p>
<p>The point is not which drug “won.” It is that as a physician I could document every variable. As a patient, I felt every one of them. That dual perspective is something I wish more of my colleagues had the chance to experience firsthand.</p>
<p>If you work with patients on incretin therapies — especially alongside steroids — what patterns have you seen? Write to me via the <a href="contact.php">contact form</a>.</p>
<p><em>This is personal experience, not medical advice. Treatment decisions belong in a conversation with the treating physician.</em></p>
HTML,
        ],
    ],
];
