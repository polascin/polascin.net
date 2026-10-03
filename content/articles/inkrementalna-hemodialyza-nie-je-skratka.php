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
 * Komentár k prehľadu o inkrementálnej hemodialýze.
 * Zdroj: nefro.polascin.net, 24. 9. 2026; Medeiros 2025; KDOQI 2015; NCT05465044.
 * Čísla sú z uverejneného prehľadu. Verejná stránka neukazuje interné ID článku.
 */
return [
    'slug' => 'inkrementalna-hemodialyza-nie-je-skratka',
    'author' => 'MUDr. Ľubomír Polaščín',
    'category' => 'blog',
    'is_top' => 0,
    'published_at' => '2026-10-03 21:45:00',
    'image' => 'images/articles/inkrementalna-hemodialyza-nie-je-skratka.webp',
    'translations' => [
        'sk' => [
            'title' => 'Pomer šancí 25,41 s intervalom 1,22 až 530,27. Z toho nerobte protokol.',
            'image_alt' => 'Muž od chrbta sedí pri dlhom tmavom stole vo fialovej miestnosti. Na doske svieti drobný tyrkysový bod a nad ním sa rozlieva veľká neistá žiara. Okolo stola sú prázdne kreslá.',
            'excerpt' => 'V prehľade o inkrementálnej hemodialýze som sa vrátil k štúdii Medeiros a spoluautorov. Deväť rýchlych poklesov a interval od 1,22 po 530,27 nie sú hranica na protokol. U vybraných pacientov dáva zmysel. Nie je to skratka.',
            'content' => <<<'HTML'
<p>Pomer šancí 25,41. Interval spoľahlivosti 1,22 až 530,27. Z toho, prosím, nerobte protokol.</p>
<p>24. septembra 2026 som na portáli Nefro-projekt zverejnil prehľad <a href="https://nefro.polascin.net/article.php?slug=inkrementalna-hemodialyza-rezidualna-funkcia-obliciek"><em>Inkrementálna hemodialýza a reziduálna funkcia obličiek: čo ukazujú dôkazy</em></a>. Ide o dialýzu, ktorá sa u vybraných pacientov môže začať dvoma procedúrami týždenne namiesto troch, kým ešte ostáva vlastná funkcia obličiek. Pevný režim dvakrát týždenne bez merania a bez možnosti dávku zvýšiť inkrementálny program nie je. Tu chcem vytiahnuť jedno číslo, ktoré sa ľahko zmení na pravidlo, hoci ním nie je.</p>
<p><a href="https://doi.org/10.7759/cureus.78601">Medeiros a spoluautori</a> retrospektívne sledovali 37 pacientov. Kompletné údaje mali u 30. Pokles reziduálneho klírensu močoviny aspoň o 25&nbsp;% do troch mesiacov nastal u deviatich z tých tridsiatich. S týmto výsledkom sa v multivariačnej analýze spájala východisková GFR &lt; 7&nbsp;ml/min/1,73&nbsp;m². Pomer šancí 25,41. 95&nbsp;% interval spoľahlivosti 1,22 až 530,27.</p>
<p>To nie je prah. Je to signál s veľmi malým počtom udalostí. Široký interval, hranica odvodená zo samotného súboru a deväť prípadov znamenajú neistý odhad. Hodnota 7&nbsp;ml/min/1,73&nbsp;m² nie je overená univerzálna hranica výberu pacienta ani dôvod začať dialýzu skôr.</p>
<p>Čo dôkazy naozaj unesú:</p>
<ul>
<li><a href="https://doi.org/10.1053/j.ajkd.2015.07.015">KDOQI 2015</a> pripúšťa zníženú dávku, keď je reziduálna funkcia významná a pravidelne sa meria. Pre režimy iné než trikrát týždenne je cieľový štandardný Kt/V 2,3 za týždeň a minimálna podaná hodnota 2,1. Výpočet zahŕňa ultrafiltráciu aj reziduálnu funkciu. Odporúčanie nie je klasifikované a číslo samo nenahrádza klinický úsudok.</li>
<li>Reziduálnu funkciu treba merať časovaným zberom moču a zodpovedajúcimi odbermi krvi. Nepredpokladajte ju. Samotný objem moču klírens nenahradí.</li>
<li>Na výbere záleží: diuréza, objemový stav, draslík, acidobázická rovnováha, výživa a to, či pacient dokáže spoľahlivo spolupracovať.</li>
<li>Keď klírens nestačí, treba byť pripravený dávku zvýšiť. Dve procedúry týždenne nemajú prednosť pred účinnou liečbou, keď je hyperkaliémia, acidóza, preťaženie tekutinami alebo urémia nezvládnutá.</li>
</ul>
<p>Čo chýba, je dôkaz, že menej procedúr samo chráni reziduálnu funkciu alebo zlepšuje prežívanie. Štúdia VA IncHVets (<a href="https://clinicaltrials.gov/study/NCT05465044">NCT05465044</a>) stále naberá. Register bol aktualizovaný 20. augusta 2026. Odhadované ukončenie primárneho sledovania je 30. septembra 2027. Výsledky v registri zatiaľ nie sú.</p>
<p>Inkrementálna hemodialýza je rozumná možnosť pre starostlivo vybraných pacientov pod blízkym dohľadom. Nie je to skratka.</p>
<p>Ak o tom chcete hovoriť ako o dôkazoch v praxi, napíšte mi cez <a href="contact.php">kontakt</a>.</p>
<p><em>Ide o odborný komentár k prehľadu, nie o individuálny liečebný predpis. O dialyzačnom režime rozhoduje ošetrujúci tím.</em></p>
HTML,
        ],
        'en' => [
            'title' => 'An odds ratio of 25.41, interval 1.22 to 530.27. Please do not build a protocol on that.',
            'image_alt' => 'A man seen from behind sits at a long dark table in a purple room. A tiny teal point glows on the tabletop and a large uncertain halo spreads above it. Empty chairs stand around the table.',
            'excerpt' => 'In a review of incremental hemodialysis I came back to Medeiros and colleagues. Nine rapid declines and an interval from 1.22 to 530.27 are not a threshold for a protocol. For selected patients it is reasonable. It is not a shortcut.',
            'content' => <<<'HTML'
<p>An odds ratio of 25.41. A confidence interval of 1.22 to 530.27. Please do not build a protocol on that.</p>
<p>On 24 September 2026 I published a review on the Nefro-projekt site, <a href="https://nefro.polascin.net/article.php?slug=inkrementalna-hemodialyza-rezidualna-funkcia-obliciek"><em>Inkrementálna hemodialýza a reziduálna funkcia obličiek: čo ukazujú dôkazy</em></a> — incremental hemodialysis and residual kidney function, and what the evidence actually shows. For selected patients it may start at two sessions a week instead of three, while their own kidney function remains. A fixed twice-weekly schedule with no measurement and no path to a higher dose is not an incremental program. I want to pull out one number that is easy to turn into a rule, and is not one.</p>
<p><a href="https://doi.org/10.7759/cureus.78601">Medeiros and colleagues</a> followed 37 patients retrospectively. Complete data were available for 30. A fall in residual urea clearance of at least 25&nbsp;% within three months occurred in nine of those thirty. In the multivariable analysis, a baseline GFR &lt; 7&nbsp;ml/min/1.73&nbsp;m² was associated with that outcome. Odds ratio 25.41. 95&nbsp;% confidence interval 1.22 to 530.27.</p>
<p>That is not a threshold. It is a signal with very few events behind it. A wide interval, a cut-point taken from the same dataset, and nine cases mean an uncertain estimate. A value of 7&nbsp;ml/min/1.73&nbsp;m² is not a validated universal rule for selecting patients, and it is not a reason to start dialysis earlier.</p>
<p>What the evidence actually supports:</p>
<ul>
<li><a href="https://doi.org/10.1053/j.ajkd.2015.07.015">KDOQI 2015</a> allows a reduced dose when residual function is significant and is measured regularly. For schedules other than three times a week, the target standard Kt/V is 2.3 per week, with a minimum delivered value of 2.1. The calculation includes ultrafiltration and residual function. The recommendation is not graded, and the number alone does not replace clinical judgment.</li>
<li>Residual function has to be measured with a timed urine collection and matching blood samples. Do not assume it. Urine volume alone does not stand in for clearance.</li>
<li>Selection matters: diuresis, volume status, potassium, acid-base balance, nutrition, and whether the patient can cooperate reliably.</li>
<li>Be ready to raise the dose when clearance falls short. Two sessions a week should not outrank effective treatment when hyperkalemia, acidosis, fluid overload, or uremia is not controlled.</li>
</ul>
<p>What is missing is proof that fewer sessions themselves protect residual function or improve survival. The VA IncHVets trial (<a href="https://clinicaltrials.gov/study/NCT05465044">NCT05465044</a>) is still recruiting. The registry was updated on 20 August 2026. Primary completion is estimated for 30 September 2027. Results are not posted yet.</p>
<p>Incremental hemodialysis is a reasonable option for carefully selected patients under close monitoring. It is not a shortcut.</p>
<p>If you want to talk about this as evidence in practice, write to me via the <a href="contact.php">contact form</a>.</p>
<p><em>This is a clinical commentary on a review, not a treatment prescription for an individual patient. The dialysis schedule is a decision for the treating team.</em></p>
HTML,
        ],
        'cs' => [
            'title' => 'Poměr šancí 25,41 s intervalem 1,22 až 530,27. Nedělejte z toho protokol.',
            'image_alt' => 'Muž zády k nám sedí u dlouhého tmavého stolu ve fialové místnosti. Na desce svítí drobný tyrkysový bod a nad ním se rozlévá velká nejistá záře. Kolem stolu jsou prázdná křesla.',
            'excerpt' => 'V přehledu o inkrementální hemodialýze jsem se vrátil ke studii Medeiros a kolegů. Devět rychlých poklesů a interval od 1,22 do 530,27 nejsou hranice pro protokol. U vybraných pacientů dává smysl. Není to zkratka.',
            'content' => <<<'HTML'
<p>Poměr šancí 25,41. Interval spolehlivosti 1,22 až 530,27. Nedělejte z toho, prosím, protokol.</p>
<p>24. září 2026 jsem na portálu Nefro-projekt zveřejnil přehled <a href="https://nefro.polascin.net/article.php?slug=inkrementalna-hemodialyza-rezidualna-funkcia-obliciek"><em>Inkrementálna hemodialýza a reziduálna funkcia obličiek: čo ukazujú dôkazy</em></a> — inkrementální hemodialýza a reziduální funkce ledvin a to, co z důkazů opravdu plyne. U vybraných pacientů může začínat dvěma procedurami týdně místo tří, dokud ještě zbývá vlastní funkce ledvin. Pevný režim dvakrát týdně bez měření a bez možnosti dávku zvýšit inkrementální program není. Chci vytáhnout jedno číslo, které se snadno změní v pravidlo, ačkoli jím není.</p>
<p><a href="https://doi.org/10.7759/cureus.78601">Medeiros a kolegové</a> retrospektivně sledovali 37 pacientů. Úplné údaje měli u 30. Pokles reziduální clearance močoviny alespoň o 25&nbsp;% do tří měsíců nastal u devíti z těch třiceti. S tímto výsledkem se v multivariační analýze pojila výchozí GFR &lt; 7&nbsp;ml/min/1,73&nbsp;m². Poměr šancí 25,41. 95% interval spolehlivosti 1,22 až 530,27.</p>
<p>To není práh. Je to signál s velmi malým počtem událostí. Široký interval, hranice odvozená ze samotného souboru a devět případů znamenají nejistý odhad. Hodnota 7&nbsp;ml/min/1,73&nbsp;m² není ověřená univerzální hranice výběru pacienta ani důvod začít dialýzu dříve.</p>
<p>Co důkazy skutečně unesou:</p>
<ul>
<li><a href="https://doi.org/10.1053/j.ajkd.2015.07.015">KDOQI 2015</a> připouští sníženou dávku, když je reziduální funkce významná a pravidelně se měří. Pro režimy jiné než třikrát týdně je cílový standardní Kt/V 2,3 za týden a minimální podaná hodnota 2,1. Výpočet zahrnuje ultrafiltraci i reziduální funkci. Doporučení není klasifikované a číslo samo nenahrazuje klinický úsudek.</li>
<li>Reziduální funkci je třeba měřit časovaným sběrem moči a odpovídajícími odběry krve. Nepředpokládejte ji. Samotný objem moči clearance nenahradí.</li>
<li>Na výběru záleží: diuréza, objemový stav, draslík, acidobazická rovnováha, výživa a to, zda pacient dokáže spolehlivě spolupracovat.</li>
<li>Když clearance nestačí, je třeba být připraven dávku zvýšit. Dvě procedury týdně nemají přednost před účinnou léčbou, když hyperkalemie, acidóza, převodnění nebo urémie nejsou zvládnuté.</li>
</ul>
<p>Co chybí, je důkaz, že méně procedur samo chrání reziduální funkci nebo zlepšuje přežití. Studie VA IncHVets (<a href="https://clinicaltrials.gov/study/NCT05465044">NCT05465044</a>) stále nabírá. Registr byl aktualizován 20. srpna 2026. Odhadované ukončení primárního sledování je 30. září 2027. Výsledky v registru zatím nejsou.</p>
<p>Inkrementální hemodialýza je rozumná možnost pro pečlivě vybrané pacienty pod blízkým dohledem. Není to zkratka.</p>
<p>Pokud o tom chcete mluvit jako o důkazech v praxi, napište mi přes <a href="contact.php">kontakt</a>.</p>
<p><em>Jde o odborný komentář k přehledu, ne o individuální léčebný předpis. O dialyzačním režimu rozhoduje ošetřující tým.</em></p>
HTML,
        ],
        'de' => [
            'title' => 'Eine Odds Ratio von 25,41, Intervall 1,22 bis 530,27. Bauen Sie darauf kein Protokoll.',
            'image_alt' => 'Ein Mann von hinten sitzt an einem langen dunklen Tisch in einem violetten Raum. Auf der Platte leuchtet ein winziger türkiser Punkt, darüber breitet sich ein großer unsicherer Schein aus. Leere Sessel stehen um den Tisch.',
            'excerpt' => 'In einer Übersicht zur inkrementellen Hämodialyse bin ich auf Medeiros und Kollegen zurückgekommen. Neun rasche Abfälle und ein Intervall von 1,22 bis 530,27 sind keine Schwelle für ein Protokoll. Bei ausgewählten Patienten ist sie vertretbar. Sie ist keine Abkürzung.',
            'content' => <<<'HTML'
<p>Eine Odds Ratio von 25,41. Ein Konfidenzintervall von 1,22 bis 530,27. Bitte bauen Sie darauf kein Protokoll.</p>
<p>Am 24. September 2026 habe ich auf dem Portal Nefro-projekt die Übersicht <a href="https://nefro.polascin.net/article.php?slug=inkrementalna-hemodialyza-rezidualna-funkcia-obliciek"><em>Inkrementálna hemodialýza a reziduálna funkcia obličiek: čo ukazujú dôkazy</em></a> veröffentlicht: inkrementelle Hämodialyse und Restnierenfunktion, und was die Evidenz tatsächlich hergibt. Bei ausgewählten Patienten kann sie mit zwei Sitzungen pro Woche statt drei beginnen, solange noch eigene Nierenfunktion bleibt. Ein festes Schema zweimal wöchentlich ohne Messung und ohne Weg zu einer höheren Dosis ist kein inkrementelles Programm. Ich möchte eine Zahl herausziehen, die sich leicht in eine Regel verwandelt, obwohl sie keine ist.</p>
<p><a href="https://doi.org/10.7759/cureus.78601">Medeiros und Kollegen</a> beobachteten 37 Patienten retrospektiv. Vollständige Daten lagen bei 30 vor. Ein Abfall der residualen Harnstoff-Clearance um mindestens 25&nbsp;% innerhalb von drei Monaten trat bei neun dieser dreißig auf. In der multivariablen Analyse war eine Ausgangs-GFR &lt; 7&nbsp;ml/min/1,73&nbsp;m² mit diesem Ergebnis verbunden. Odds Ratio 25,41. 95-%-Konfidenzintervall 1,22 bis 530,27.</p>
<p>Das ist keine Schwelle. Es ist ein Signal mit sehr wenigen Ereignissen dahinter. Ein weites Intervall, ein Schwellenwert aus demselben Datensatz und neun Fälle bedeuten eine unsichere Schätzung. Der Wert 7&nbsp;ml/min/1,73&nbsp;m² ist keine validierte universelle Grenze für die Patientenauswahl und kein Grund, früher mit der Dialyse zu beginnen.</p>
<p>Was die Evidenz tatsächlich trägt:</p>
<ul>
<li><a href="https://doi.org/10.1053/j.ajkd.2015.07.015">KDOQI 2015</a> lässt eine reduzierte Dosis zu, wenn die Restfunktion bedeutsam ist und regelmäßig gemessen wird. Für Schemata außer dreimal wöchentlich liegt das Ziel für das Standard-Kt/V bei 2,3 pro Woche, der Mindestwert der verabreichten Dosis bei 2,1. Die Berechnung schließt Ultrafiltration und Restfunktion ein. Die Empfehlung ist nicht graduiert, und die Zahl allein ersetzt das klinische Urteil nicht.</li>
<li>Die Restfunktion muss mit einer zeitlich definierten Urinsammlung und passenden Blutentnahmen gemessen werden. Setzen Sie sie nicht voraus. Das Urinvolumen allein ersetzt die Clearance nicht.</li>
<li>Die Auswahl zählt: Diurese, Volumenstatus, Kalium, Säure-Basen-Haushalt, Ernährung und ob der Patient zuverlässig mitarbeiten kann.</li>
<li>Seien Sie bereit, die Dosis zu erhöhen, wenn die Clearance nicht ausreicht. Zwei Sitzungen pro Woche haben keinen Vorrang vor wirksamer Behandlung, wenn Hyperkaliämie, Azidose, Volumenüberladung oder Urämie nicht beherrscht sind.</li>
</ul>
<p>Was fehlt, ist der Nachweis, dass weniger Sitzungen für sich die Restfunktion schützen oder das Überleben verbessern. Die Studie VA IncHVets (<a href="https://clinicaltrials.gov/study/NCT05465044">NCT05465044</a>) rekrutiert noch. Das Register wurde am 20. August 2026 aktualisiert. Der geschätzte Abschluss der primären Nachbeobachtung ist der 30. September 2027. Ergebnisse stehen im Register noch nicht.</p>
<p>Inkrementelle Hämodialyse ist eine vernünftige Möglichkeit für sorgfältig ausgewählte Patienten unter enger Überwachung. Sie ist keine Abkürzung.</p>
<p>Wenn Sie darüber als Evidenz in der Praxis sprechen wollen, schreiben Sie mir über das <a href="contact.php">Kontaktformular</a>.</p>
<p><em>Dies ist ein fachlicher Kommentar zu einer Übersicht, keine individuelle Behandlungsverordnung. Über das Dialyseschema entscheidet das behandelnde Team.</em></p>
HTML,
        ],
        'fr' => [
            'title' => 'Un odds ratio de 25,41, intervalle 1,22 à 530,27. N’en faites pas un protocole.',
            'image_alt' => 'Un homme vu de dos est assis à une longue table sombre dans une pièce violette. Un minuscule point turquoise luit sur le plateau et un large halo incertain s’étale au-dessus. Des fauteuils vides entourent la table.',
            'excerpt' => 'Dans une revue sur l’hémodialyse incrémentale, je suis revenu à Medeiros et ses coauteurs. Neuf baisses rapides et un intervalle de 1,22 à 530,27 ne sont pas un seuil de protocole. Chez des patients choisis, c’est raisonnable. Ce n’est pas un raccourci.',
            'content' => <<<'HTML'
<p>Un odds ratio de 25,41. Un intervalle de confiance de 1,22 à 530,27. N’en faites pas, s’il vous plaît, un protocole.</p>
<p>Le 24 septembre 2026, j’ai publié sur le portail Nefro-projekt la revue <a href="https://nefro.polascin.net/article.php?slug=inkrementalna-hemodialyza-rezidualna-funkcia-obliciek"><em>Inkrementálna hemodialýza a reziduálna funkcia obličiek: čo ukazujú dôkazy</em></a> : l’hémodialyse incrémentale et la fonction rénale résiduelle, et ce que les preuves montrent vraiment. Chez des patients choisis, elle peut commencer par deux séances par semaine au lieu de trois, tant qu’il reste une fonction rénale propre. Un schéma fixe à deux séances, sans mesure et sans possibilité d’augmenter la dose, n’est pas un programme incrémental. Je veux sortir un chiffre qui se transforme facilement en règle, alors qu’il n’en est pas une.</p>
<p><a href="https://doi.org/10.7759/cureus.78601">Medeiros et ses coauteurs</a> ont suivi 37 patients de façon rétrospective. Les données complètes concernaient 30 d’entre eux. Une baisse de la clairance résiduelle de l’urée d’au moins 25&nbsp;% en trois mois est survenue chez neuf de ces trente. Dans l’analyse multivariée, une DFG initiale &lt; 7&nbsp;ml/min/1,73&nbsp;m² était associée à ce résultat. Odds ratio 25,41. Intervalle de confiance à 95&nbsp;% : 1,22 à 530,27.</p>
<p>Ce n’est pas un seuil. C’est un signal porté par très peu d’événements. Un intervalle large, un seuil tiré du même jeu de données et neuf cas donnent une estimation incertaine. La valeur de 7&nbsp;ml/min/1,73&nbsp;m² n’est pas une limite universelle validée pour choisir un patient, ni une raison de commencer la dialyse plus tôt.</p>
<p>Ce que les preuves soutiennent vraiment :</p>
<ul>
<li><a href="https://doi.org/10.1053/j.ajkd.2015.07.015">Les KDOQI 2015</a> admettent une dose réduite quand la fonction résiduelle est importante et mesurée régulièrement. Pour les schémas autres que trois fois par semaine, le Kt/V standard cible est de 2,3 par semaine, avec une valeur minimale délivrée de 2,1. Le calcul inclut l’ultrafiltration et la fonction résiduelle. La recommandation n’est pas gradée, et le chiffre seul ne remplace pas le jugement clinique.</li>
<li>La fonction résiduelle doit être mesurée par un recueil urinaire minuté et des prises de sang correspondantes. Ne la supposez pas. Le volume d’urine seul ne remplace pas la clairance.</li>
<li>La sélection compte : diurèse, état volémique, potassium, équilibre acidobasique, nutrition, et la capacité du patient à coopérer de façon fiable.</li>
<li>Soyez prêts à augmenter la dose quand la clairance ne suffit pas. Deux séances par semaine ne passent pas avant un traitement efficace lorsque l’hyperkaliémie, l’acidose, la surcharge hydrique ou l’urémie ne sont pas maîtrisées.</li>
</ul>
<p>Ce qui manque, c’est la preuve que moins de séances protègent par elles-mêmes la fonction résiduelle ou améliorent la survie. L’essai VA IncHVets (<a href="https://clinicaltrials.gov/study/NCT05465044">NCT05465044</a>) recrute encore. Le registre a été mis à jour le 20 août 2026. La fin estimée du suivi principal est le 30 septembre 2027. Les résultats ne sont pas encore publiés dans le registre.</p>
<p>L’hémodialyse incrémentale est une option raisonnable pour des patients soigneusement choisis, sous surveillance étroite. Ce n’est pas un raccourci.</p>
<p>Si vous voulez en parler comme d’une preuve en pratique, écrivez-moi via le <a href="contact.php">formulaire de contact</a>.</p>
<p><em>Ceci est un commentaire clinique sur une revue, pas une prescription pour un patient donné. Le schéma de dialyse relève de l’équipe soignante.</em></p>
HTML,
        ],
        'es' => [
            'title' => 'Una odds ratio de 25,41, intervalo 1,22 a 530,27. No construya un protocolo con eso.',
            'image_alt' => 'Un hombre de espaldas se sienta ante una mesa larga y oscura en una sala violeta. En el tablero brilla un punto turquesa minúsculo y sobre él se extiende un halo grande e incierto. Alrededor hay sillas vacías.',
            'excerpt' => 'En una revisión sobre hemodiálisis incremental volví al estudio de Medeiros y colegas. Nueve descensos rápidos y un intervalo de 1,22 a 530,27 no son un umbral para un protocolo. En pacientes seleccionados es razonable. No es un atajo.',
            'content' => <<<'HTML'
<p>Una odds ratio de 25,41. Un intervalo de confianza de 1,22 a 530,27. No construya, por favor, un protocolo con eso.</p>
<p>El 24 de septiembre de 2026 publiqué en el portal Nefro-projekt la revisión <a href="https://nefro.polascin.net/article.php?slug=inkrementalna-hemodialyza-rezidualna-funkcia-obliciek"><em>Inkrementálna hemodialýza a reziduálna funkcia obličiek: čo ukazujú dôkazy</em></a>: hemodiálisis incremental y función renal residual, y lo que de verdad muestra la evidencia. En pacientes seleccionados puede empezar con dos sesiones por semana en lugar de tres, mientras queda función renal propia. Un esquema fijo de dos sesiones, sin medición y sin vía para subir la dosis, no es un programa incremental. Quiero sacar un número que se convierte con facilidad en una norma y no lo es.</p>
<p><a href="https://doi.org/10.7759/cureus.78601">Medeiros y colegas</a> siguieron de forma retrospectiva a 37 pacientes. Había datos completos de 30. Un descenso del aclaramiento residual de urea de al menos un 25&nbsp;% en tres meses ocurrió en nueve de esos treinta. En el análisis multivariable, una TFG basal &lt; 7&nbsp;ml/min/1,73&nbsp;m² se asoció con ese resultado. Odds ratio 25,41. Intervalo de confianza del 95&nbsp;%: 1,22 a 530,27.</p>
<p>Eso no es un umbral. Es una señal con muy pocos eventos detrás. Un intervalo ancho, un corte sacado del mismo conjunto de datos y nueve casos dan una estimación incierta. El valor de 7&nbsp;ml/min/1,73&nbsp;m² no es un límite universal validado para elegir pacientes, ni un motivo para empezar la diálisis antes.</p>
<p>Lo que la evidencia sí sostiene:</p>
<ul>
<li><a href="https://doi.org/10.1053/j.ajkd.2015.07.015">KDOQI 2015</a> admite una dosis reducida cuando la función residual es significativa y se mide con regularidad. Para esquemas distintos de tres veces por semana, el Kt/V estándar objetivo es 2,3 por semana, con un valor mínimo administrado de 2,1. El cálculo incluye la ultrafiltración y la función residual. La recomendación no está graduada, y el número por sí solo no sustituye el juicio clínico.</li>
<li>La función residual hay que medirla con una recolección de orina minutada y analíticas de sangre correspondientes. No la dé por supuesta. El volumen de orina solo no sustituye al aclaramiento.</li>
<li>La selección importa: diuresis, estado de volumen, potasio, equilibrio acidobásico, nutrición y si el paciente puede colaborar de forma fiable.</li>
<li>Hay que estar dispuesto a subir la dosis cuando el aclaramiento no alcanza. Dos sesiones por semana no deben primar sobre un tratamiento eficaz cuando la hiperpotasemia, la acidosis, la sobrecarga de volumen o la uremia no están controladas.</li>
</ul>
<p>Lo que falta es la prueba de que menos sesiones, por sí mismas, protegen la función residual o mejoran la supervivencia. El ensayo VA IncHVets (<a href="https://clinicaltrials.gov/study/NCT05465044">NCT05465044</a>) sigue reclutando. El registro se actualizó el 20 de agosto de 2026. La finalización primaria estimada es el 30 de septiembre de 2027. Aún no hay resultados en el registro.</p>
<p>La hemodiálisis incremental es una opción razonable para pacientes cuidadosamente seleccionados y bajo vigilancia estrecha. No es un atajo.</p>
<p>Si quiere hablar de esto como evidencia en la práctica, escríbame a través del <a href="contact.php">formulario de contacto</a>.</p>
<p><em>Esto es un comentario clínico sobre una revisión, no una prescripción para un paciente concreto. El esquema de diálisis lo decide el equipo tratante.</em></p>
HTML,
        ],
        'pl' => [
            'title' => 'Iloraz szans 25,41, przedział 1,22 do 530,27. Nie rób z tego protokołu.',
            'image_alt' => 'Mężczyzna od tyłu siedzi przy długim ciemnym stole w fioletowym pokoju. Na blacie świeci drobny turkusowy punkt, a nad nim rozlewa się duża niepewna poświata. Wokół stołu stoją puste fotele.',
            'excerpt' => 'W przeglądzie o hemodializie inkrementalnej wróciłem do badania Medeirosa i współautorów. Dziewięć szybkich spadków i przedział od 1,22 do 530,27 to nie próg do protokołu. U wybranych pacjentów ma sens. To nie skrót.',
            'content' => <<<'HTML'
<p>Iloraz szans 25,41. Przedział ufności 1,22 do 530,27. Nie rób z tego, proszę, protokołu.</p>
<p>24 września 2026 opublikowałem na portalu Nefro-projekt przegląd <a href="https://nefro.polascin.net/article.php?slug=inkrementalna-hemodialyza-rezidualna-funkcia-obliciek"><em>Inkrementálna hemodialýza a reziduálna funkcia obličiek: čo ukazujú dôkazy</em></a> — hemodializa inkrementalna i resztkowa funkcja nerek oraz to, co naprawdę wynika z danych. U wybranych pacjentów może zaczynać się od dwóch zabiegów w tygodniu zamiast trzech, dopóki zostaje własna funkcja nerek. Stały schemat dwa razy w tygodniu, bez pomiaru i bez drogi do wyższej dawki, nie jest programem inkrementalnym. Chcę wyciągnąć jedną liczbę, która łatwo staje się regułą, choć nią nie jest.</p>
<p><a href="https://doi.org/10.7759/cureus.78601">Medeiros i współautorzy</a> obserwowali retrospektywnie 37 pacjentów. Pełne dane mieli u 30. Spadek resztkowego klirensu mocznika o co najmniej 25&nbsp;% w ciągu trzech miesięcy wystąpił u dziewięciu z tych trzydziestu. W analizie wieloczynnikowej z tym wynikiem wiązało się wyjściowe GFR &lt; 7&nbsp;ml/min/1,73&nbsp;m². Iloraz szans 25,41. 95% przedział ufności 1,22 do 530,27.</p>
<p>To nie próg. To sygnał oparty na bardzo małej liczbie zdarzeń. Szeroki przedział, granica wyprowadzona z tego samego zbioru i dziewięć przypadków dają niepewne oszacowanie. Wartość 7&nbsp;ml/min/1,73&nbsp;m² nie jest sprawdzoną uniwersalną granicą doboru pacjenta ani powodem, by wcześniej zacząć dializę.</p>
<p>Co dane naprawdę udźwigną:</p>
<ul>
<li><a href="https://doi.org/10.1053/j.ajkd.2015.07.015">KDOQI 2015</a> dopuszcza zmniejszoną dawkę, gdy resztkowa funkcja jest istotna i regularnie mierzona. Dla schematów innych niż trzy razy w tygodniu docelowe standardowe Kt/V wynosi 2,3 na tydzień, a minimalna podana wartość 2,1. Obliczenie obejmuje ultrafiltrację i funkcję resztkową. Zalecenie nie jest klasyfikowane, a sama liczba nie zastępuje osądu klinicznego.</li>
<li>Funkcję resztkową trzeba zmierzyć zbiórką moczu w określonym czasie i odpowiadającymi pobraniami krwi. Nie zakładaj jej. Sama objętość moczu nie zastąpi klirensu.</li>
<li>Dobór ma znaczenie: diureza, stan objętości, potas, równowaga kwasowo-zasadowa, odżywienie i to, czy pacjent potrafi rzetelnie współpracować.</li>
<li>Gdy klirens nie wystarcza, trzeba być gotowym podnieść dawkę. Dwa zabiegi w tygodniu nie mają pierwszeństwa przed skutecznym leczeniem, gdy hiperkaliemia, kwasica, przewodnienie albo mocznica nie są opanowane.</li>
</ul>
<p>Brakuje dowodu, że mniejsza liczba zabiegów sama chroni funkcję resztkową albo poprawia przeżycie. Badanie VA IncHVets (<a href="https://clinicaltrials.gov/study/NCT05465044">NCT05465044</a>) wciąż rekrutuje. Rejestr zaktualizowano 20 sierpnia 2026. Szacowane zakończenie obserwacji pierwotnej to 30 września 2027. Wyników w rejestrze jeszcze nie ma.</p>
<p>Hemodializa inkrementalna jest rozsądną możliwością dla starannie wybranych pacjentów pod ścisłą obserwacją. To nie skrót.</p>
<p>Jeśli chcesz o tym rozmawiać jak o dowodach w praktyce, napisz przez <a href="contact.php">kontakt</a>.</p>
<p><em>To komentarz kliniczny do przeglądu, a nie indywidualne zalecenie leczenia. O schemacie dializy decyduje zespół leczący.</em></p>
HTML,
        ],
        'hu' => [
            'title' => '25,41-es esélyhányados, 1,22–530,27-es intervallum. Ne csinálj belőle protokollt.',
            'image_alt' => 'Egy férfi hátulról ül egy hosszú, sötét asztalnál egy lila szobában. Az asztallapon apró türkiz pont világít, fölötte nagy, bizonytalan fényudvar terül szét. Az asztal körül üres székek állnak.',
            'excerpt' => 'Az inkrementális hemodialízisről szóló áttekintésben visszatértem Medeiros és munkatársai vizsgálatához. Kilenc gyors csökkenés és az 1,22-től 530,27-ig tartó intervallum nem protokollküszöb. Válogatott betegeknél ésszerű. Nem rövidítés.',
            'content' => <<<'HTML'
<p>25,41-es esélyhányados. 1,22-től 530,27-ig terjedő konfidenciaintervallum. Kérlek, ne csinálj belőle protokollt.</p>
<p>2026. szeptember 24-én a Nefro-projekt portálon közzétettem az <a href="https://nefro.polascin.net/article.php?slug=inkrementalna-hemodialyza-rezidualna-funkcia-obliciek"><em>Inkrementálna hemodialýza a reziduálna funkcia obličiek: čo ukazujú dôkazy</em></a> című áttekintést: inkrementális hemodialízis és reziduális vesefunkció, és hogy a bizonyíték valójában mit bír el. Válogatott betegeknél heti két kezeléssel indulhat heti három helyett, amíg megmarad a saját vesefunkció. A rögzített heti kétszeri rend mérés nélkül, és a dózis emelésének lehetősége nélkül, nem inkrementális program. Ki akarok emelni egy számot, amely könnyen szabállyá válik, pedig nem az.</p>
<p><a href="https://doi.org/10.7759/cureus.78601">Medeiros és munkatársai</a> retrospektíven 37 beteget követtek. Teljes adat 30-nál volt. A reziduális ureaclearance legalább 25&nbsp;%-os csökkenése három hónapon belül a harmincból kilencnél fordult elő. A többváltozós elemzésben a kiindulási GFR &lt; 7&nbsp;ml/min/1,73&nbsp;m² társult ehhez az eredményhez. Esélyhányados: 25,41. 95%-os konfidenciaintervallum: 1,22–530,27.</p>
<p>Ez nem küszöb. Ez egy jel, nagyon kevés esemény mögött. A széles intervallum, az ugyanabból a mintából vett határ és a kilenc eset bizonytalan becslést jelent. A 7&nbsp;ml/min/1,73&nbsp;m² nem validált, általános betegkiválasztási határ, és nem ok arra, hogy előbb kezdjük a dialízist.</p>
<p>Amit a bizonyíték valóban elbír:</p>
<ul>
<li>A <a href="https://doi.org/10.1053/j.ajkd.2015.07.015">KDOQI 2015</a> csökkentett dózist enged, ha a reziduális funkció jelentős és rendszeresen mérik. A heti háromtól eltérő rendeknél a cél standard Kt/V heti 2,3, a leadott minimum 2,1. A számítás tartalmazza az ultrafiltrációt és a reziduális funkciót is. Az ajánlás nincs osztályozva, és a szám önmagában nem helyettesíti a klinikai mérlegelést.</li>
<li>A reziduális funkciót időzített vizeletgyűjtéssel és hozzá illő vérvételekkel kell mérni. Ne feltételezd. A vizeletmennyiség önmagában nem pótolja a clearance-t.</li>
<li>A kiválasztás számít: diurézis, volumenállapot, kálium, sav-bázis egyensúly, tápláltság, és hogy a beteg megbízhatóan tud-e együttműködni.</li>
<li>Ha a clearance nem elég, légy kész a dózis emelésére. A heti két kezelés nem előzheti meg a hatásos terápiát, ha a hyperkalaemia, az acidózis, a folyadéktúltöltés vagy az uraemia nincs kézben.</li>
</ul>
<p>Ami hiányzik, az a bizonyíték, hogy a kevesebb kezelés önmagában védi a reziduális funkciót vagy javítja a túlélést. A VA IncHVets vizsgálat (<a href="https://clinicaltrials.gov/study/NCT05465044">NCT05465044</a>) még toboroz. A regisztert 2026. augusztus 20-án frissítették. Az elsődleges követés becsült befejezése 2027. szeptember 30. Eredmény a regiszterben még nincs.</p>
<p>Az inkrementális hemodialízis ésszerű lehetőség gondosan kiválasztott betegeknél, szoros követés mellett. Nem rövidítés.</p>
<p>Ha a gyakorlat bizonyítékaként akarod megbeszélni, írj a <a href="contact.php">kapcsolati űrlapon</a>.</p>
<p><em>Ez klinikai kommentár egy áttekintéshez, nem egyéni kezelési előírás. A dialízisrendről a kezelőcsapat dönt.</em></p>
HTML,
        ],
        'it' => [
            'title' => 'Un odds ratio di 25,41, intervallo da 1,22 a 530,27. Non farne un protocollo.',
            'image_alt' => 'Un uomo di spalle siede a un lungo tavolo scuro in una stanza viola. Sul piano brilla un punto turchese minuscolo e sopra si allarga un alone grande e incerto. Intorno al tavolo ci sono sedie vuote.',
            'excerpt' => 'In una rassegna sull’emodialisi incrementale sono tornato allo studio di Medeiros e colleghi. Nove cali rapidi e un intervallo da 1,22 a 530,27 non sono una soglia da protocollo. Nei pazienti selezionati è ragionevole. Non è una scorciatoia.',
            'content' => <<<'HTML'
<p>Un odds ratio di 25,41. Un intervallo di confidenza da 1,22 a 530,27. Non farne, per favore, un protocollo.</p>
<p>Il 24 settembre 2026 ho pubblicato sul portale Nefro-projekt la rassegna <a href="https://nefro.polascin.net/article.php?slug=inkrementalna-hemodialyza-rezidualna-funkcia-obliciek"><em>Inkrementálna hemodialýza a reziduálna funkcia obličiek: čo ukazujú dôkazy</em></a>: emodialisi incrementale e funzione renale residua, e ciò che le prove mostrano davvero. Nei pazienti selezionati può iniziare con due sedute a settimana invece di tre, finché resta una funzione renale propria. Uno schema fisso due volte a settimana, senza misura e senza una via per alzare la dose, non è un programma incrementale. Voglio tirare fuori un numero che diventa facilmente una regola, e non lo è.</p>
<p><a href="https://doi.org/10.7759/cureus.78601">Medeiros e colleghi</a> hanno seguito in modo retrospettivo 37 pazienti. I dati completi riguardavano 30. Un calo della clearance ureica residua di almeno il 25&nbsp;% entro tre mesi si è verificato in nove di quei trenta. Nell’analisi multivariata una GFR basale &lt; 7&nbsp;ml/min/1,73&nbsp;m² si associava a questo esito. Odds ratio 25,41. Intervallo di confidenza al 95&nbsp;% da 1,22 a 530,27.</p>
<p>Non è una soglia. È un segnale con pochissimi eventi alle spalle. Un intervallo ampio, un taglio ricavato dallo stesso insieme di dati e nove casi danno una stima incerta. Il valore di 7&nbsp;ml/min/1,73&nbsp;m² non è un limite universale validato per scegliere il paziente, né un motivo per iniziare prima la dialisi.</p>
<p>Ciò che le prove reggono davvero:</p>
<ul>
<li>Le <a href="https://doi.org/10.1053/j.ajkd.2015.07.015">KDOQI 2015</a> ammettono una dose ridotta quando la funzione residua è significativa e viene misurata con regolarità. Per schemi diversi da tre volte a settimana il Kt/V standard obiettivo è 2,3 a settimana, con un valore minimo erogato di 2,1. Il calcolo include l’ultrafiltrazione e la funzione residua. La raccomandazione non è graduata, e il numero da solo non sostituisce il giudizio clinico.</li>
<li>La funzione residua va misurata con una raccolta temporizzata delle urine e prelievi di sangue corrispondenti. Non darla per scontata. Il volume di urina da solo non sostituisce la clearance.</li>
<li>La selezione conta: diuresi, stato di volume, potassio, equilibrio acido-base, nutrizione e se il paziente riesce a collaborare in modo affidabile.</li>
<li>Quando la clearance non basta, sii pronto ad aumentare la dose. Due sedute a settimana non vengono prima di un trattamento efficace se iperkaliemia, acidosi, sovraccarico di volume o uremia non sono controllati.</li>
</ul>
<p>Manca la prova che meno sedute, da sole, proteggano la funzione residua o migliorino la sopravvivenza. Lo studio VA IncHVets (<a href="https://clinicaltrials.gov/study/NCT05465044">NCT05465044</a>) sta ancora reclutando. Il registro è stato aggiornato il 20 agosto 2026. Il completamento primario stimato è il 30 settembre 2027. I risultati nel registro non ci sono ancora.</p>
<p>L’emodialisi incrementale è un’opzione ragionevole per pazienti scelti con cura e sotto stretto monitoraggio. Non è una scorciatoia.</p>
<p>Se vuoi parlarne come evidenza nella pratica, scrivi tramite il <a href="contact.php">modulo di contatto</a>.</p>
<p><em>È un commento clinico a una rassegna, non una prescrizione per un singolo paziente. Lo schema dialitico lo decide l’équipe curante.</em></p>
HTML,
        ],
        'uk' => [
            'title' => 'Відношення шансів 25,41, інтервал 1,22–530,27. Не робіть із цього протокол.',
            'image_alt' => 'Чоловік зі спини сидить за довгим темним столом у фіолетовій кімнаті. На стільниці світиться крихітна бірюзова точка, а над нею розходиться велике непевне сяйво. Навколо столу порожні крісла.',
            'excerpt' => 'В огляді про інкрементальний гемодіаліз я повернувся до дослідження Медейроса і колег. Дев’ять швидких спадів і інтервал від 1,22 до 530,27 — не поріг для протоколу. Для відібраних пацієнтів це доречно. Це не короткий шлях.',
            'content' => <<<'HTML'
<p>Відношення шансів 25,41. Довірчий інтервал від 1,22 до 530,27. Не робіть із цього, будь ласка, протокол.</p>
<p>24 вересня 2026 року я опублікував на порталі Nefro-projekt огляд <a href="https://nefro.polascin.net/article.php?slug=inkrementalna-hemodialyza-rezidualna-funkcia-obliciek"><em>Inkrementálna hemodialýza a reziduálna funkcia obličiek: čo ukazujú dôkazy</em></a> — інкрементальний гемодіаліз і залишкова функція нирок, і те, що насправді витримують докази. У відібраних пацієнтів він може починатися з двох процедур на тиждень замість трьох, доки лишається власна функція нирок. Фіксований режим двічі на тиждень без вимірювання і без шляху підвищити дозу не є інкрементальною програмою. Хочу витягти одне число, яке легко стає правилом, хоча ним не є.</p>
<p><a href="https://doi.org/10.7759/cureus.78601">Медейрос і колеги</a> ретроспективно спостерігали 37 пацієнтів. Повні дані були в 30. Зниження залишкового кліренсу сечовини щонайменше на 25&nbsp;% протягом трьох місяців сталося у дев’яти з цих тридцяти. У багатовимірному аналізі з цим результатом був пов’язаний вихідний GFR &lt; 7&nbsp;мл/хв/1,73&nbsp;м². Відношення шансів 25,41. 95&nbsp;% довірчий інтервал від 1,22 до 530,27.</p>
<p>Це не поріг. Це сигнал із дуже малою кількістю подій позаду. Широкий інтервал, межа, виведена з тієї самої вибірки, і дев’ять випадків дають непевну оцінку. Значення 7&nbsp;мл/хв/1,73&nbsp;м² не є перевіреною універсальною межею відбору пацієнта і не є причиною починати діаліз раніше.</p>
<p>Що докази справді витримують:</p>
<ul>
<li><a href="https://doi.org/10.1053/j.ajkd.2015.07.015">KDOQI 2015</a> допускає зменшену дозу, коли залишкова функція значуща і її регулярно вимірюють. Для режимів, відмінних від трьох разів на тиждень, цільовий стандартний Kt/V становить 2,3 на тиждень, а мінімальне доставлене значення — 2,1. Розрахунок включає ультрафільтрацію і залишкову функцію. Рекомендація не класифікована, і саме число не замінює клінічного судження.</li>
<li>Залишкову функцію треба вимірювати хронометрованим збором сечі і відповідними заборами крові. Не припускайте її. Сам об’єм сечі не замінить кліренсу.</li>
<li>Відбір має значення: діурез, об’ємний стан, калій, кислотно-лужна рівновага, харчування і те, чи пацієнт здатен надійно співпрацювати.</li>
<li>Коли кліренсу не вистачає, треба бути готовими підвищити дозу. Дві процедури на тиждень не мають переваги над дієвим лікуванням, якщо гіперкаліємія, ацидоз, перевантаження рідиною чи уремія не контрольовані.</li>
</ul>
<p>Чого бракує — доказу, що менша кількість процедур сама захищає залишкову функцію або поліпшує виживання. Дослідження VA IncHVets (<a href="https://clinicaltrials.gov/study/NCT05465044">NCT05465044</a>) досі набирає учасників. Реєстр оновлено 20 серпня 2026 року. Орієнтовне завершення первинного спостереження — 30 вересня 2027 року. Результатів у реєстрі ще немає.</p>
<p>Інкрементальний гемодіаліз — розумна можливість для ретельно відібраних пацієнтів під пильним наглядом. Це не короткий шлях.</p>
<p>Якщо хочете говорити про це як про докази в практиці, напишіть через <a href="contact.php">контакт</a>.</p>
<p><em>Це клінічний коментар до огляду, а не індивідуальне призначення лікування. Про режим діалізу вирішує лікувальна команда.</em></p>
HTML,
        ],
    ],
];
