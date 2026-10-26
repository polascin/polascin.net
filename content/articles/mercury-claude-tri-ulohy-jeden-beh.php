<?php

declare(strict_types=1);

$requestedScript = str_replace('\\', '/', (string) ($_SERVER['SCRIPT_NAME'] ?? $_SERVER['PHP_SELF'] ?? ''));
$executedFile = isset($_SERVER['SCRIPT_FILENAME']) ? realpath((string) $_SERVER['SCRIPT_FILENAME']) : false;
if ($executedFile === __FILE__ || preg_match('~(?:^|/)content/articles/.+\.php(?:/|$)~i', $requestedScript) === 1) {
    if (PHP_SAPI === 'cli') {
        fwrite(STDERR, "Chyba: súbor článku je interný a nemožno ho spúšťať priamo.\n");
        exit(1);
    }
    http_response_code(403);
    exit('Prístup odmietnutý.');
}
unset($requestedScript, $executedFile);

// Measurements supplied by the author; original prompts, logs and code were not supplied.
// Arithmetic and the clinical reference points were checked separately for publication.
$translations = [
    'sk' => [
        'title' => 'Mercury a Claude: tri úlohy, jeden beh a hranice víťazstva',
        'excerpt' => '19,7 sekundy oproti 46,9. Mercury 3 bol v troch úlohách rýchlejší a lacnejší než Claude Sonnet 5.5. Čo tento beh ukázal a prečo z neho ešte nevzniká všeobecný rebríček kvality.',
        'image_alt' => 'Tyrkysový a fialový svetelný prúd prechádzajú tromi sklenenými bránami. Na stole ležia stopky, lupa a listy s grafmi.',
        'labels' => ['Úloha', 'Čas v sekundách', 'Náklady v USD', 'Výstupné + reasoning tokeny', 'Úprava slovenského textu', 'Klinické zdôvodnenie', 'Kód CKD-EPI 2021', 'Spolu', 'Namerané údaje z jedného behu'],
        'intro' => <<<'HTML'
<p>Na tri rovnaké zadania potreboval Mercury 3 spolu 19,7 sekundy. Claude Sonnet 5.5 potreboval 46,9 sekundy. Rozdiel takmer pol minúty si pri práci všimnem skôr než zlomok centa na účte. A keď odpoveď kontrolujem dlhšie, než som na ňu čakal, stopky zachytia iba časť práce.</p>
<p>Po odstránení chyby autentifikácie pre Claude prebehlo porovnanie v rovnakom prostredí OpenCode: úprava slovenského textu, klinické zdôvodnenie pri dabigatrane a programovanie výpočtu CKD-EPI 2021. Nasledujúce čísla pochádzajú zo záznamu tohto jedného behu. Presné zadania, nastavenia úsilia modelov, vstupné tokeny ani úplné výstupy nie sú súčasťou publikovaného podkladu. Meranie tu nebolo nezávisle zopakované.</p>
HTML,
        'body' => <<<'HTML'
<h2>Rýchlosť je presvedčivá, rozsah záveru malý</h2>
<p>Mercury bol v jednotlivých úlohách približne 1,98-, 2,28- a 3,02-násobne rýchlejší. Súčet časov zodpovedá 2,38-násobnému rozdielu. Sú to časy dokončenia úloh vrátane vplyvu prostredia a dĺžky odpovedí, nie meranie samotnej rýchlosti generovania tokenov. Tri zadania bez opakovaní neukazujú kolísanie latencie ani správanie pri dlhšej práci.</p>
<h2>Čo presne znamená 45-násobný rozdiel v cene</h2>
<p>Položky Mercury dávajú súčet 0,00245 USD, po zaokrúhlení 0,0025 USD. Pri Claude je súčet 0,1122 USD. Podľa zaokrúhleného súčtu ide približne o 45-násobok; z jednotlivých položiek vychádza 45,8-násobok. Podklad pripisuje asi 0,055 USD prvému zápisu do vyrovnávacej pamäte promptu. Po jeho jednoduchom odpočítaní ostane 0,0572 USD, približne 23-násobok nezaokrúhleného súčtu Mercury.</p>
<p>Takéto odpočítanie je orientačné. Bez úplného rozpisu vstupov, zápisov a čítaní cache neviem zostaviť porovnateľný účet pri studenej a zahriatej cache. Uvedené sumy sú náklady tohto behu, nie univerzálny cenník. Pri oboch modeloch ide v absolútnej sume o malý výdavok.</p>
<h2>Viac tokenov nevypovedá o hĺbke uvažovania</h2>
<p>Mercury mal viac vykázaných reasoning tokenov pri klinickej úlohe a pri kóde, Claude pri úprave textu. Claude vytvoril vo všetkých troch úlohách dlhší viditeľný výstup. Počítadlá rôznych modelov a ich tokenizácia však nie sú priamou mierou intelektuálneho úsilia. Z čísla 3 013 oproti 1 173 sa nedá vyčítať, kto lepšie rozmýšľal.</p>
<h2>Kvalitu rozhodne kontrola odpovede</h2>
<p>Podľa pôvodného hodnotenia oba modely pri dabigatrane zachytili zásadnú kontraindikáciu: u dospelých je v európskom súhrne charakteristických vlastností lieku Pradaxa uvedený CrCl pod 30 ml/min. Na posúdenie CrCl sa používa Cockcroftova a Gaultova rovnica. Tento údaj nemožno bez ďalšieho zameniť za eGFR podľa CKD-EPI, vyjadrenú na 1,73 m². Podrobnejšia odpoveď musí navyše správne odlíšiť európske a americké podmienky použitia.</p>
<p>Pri kóde sa dá overiť aspoň konkrétny bod: žena vo veku 60 rokov, kreatinín 80 µmol/l, dáva podľa kreatinínovej rovnice CKD-EPI 2021 približne 72,704 ml/min/1,73 m². Výsledok 72,7 teda sedí. Jeden správny výpočet však neoveruje celú implementáciu, prevod jednotiek, hraničné vstupy ani validáciu. Bez úplných odpovedí a spustiteľného kódu zostáva priaznivé hodnotenie oboch modelov hodnotením autora pôvodného porovnania.</p>
<p>Pri slovenskom texte bol Mercury podľa podkladu stručný a bez komentára, Claude pridal poznámku o rekonštrukcii diakritiky. Pri čistej redakčnej úlohe môže takýto dodatok prekážať. Pri neistom klinickom údaji môže byť vysvetlenie neistoty presne tým, čo potrebujem.</p>
<h2>Do ďalšieho merania patrí aj čas kontroly</h2>
<p>Ďalší beh by mal uchovať presné zadania, identifikátory modelov, nastavenia úsilia a limity tokenov, opakovane striedať poradie volaní a oddeliť studenú cache od zahriatej. K času odpovede by som pridal čas overenia a opráv. Výstupy by mali dostať hodnotenie podľa vopred určených kritérií, ideálne bez zobrazenia názvu modelu.</p>
<p>V týchto troch úlohách Mercury priniesol odpovede rýchlejšie a za nižšiu vykázanú cenu. Pre voľbu pracovného nástroja je to užitočný začiatok. O ďalšom použití rozhodne, koľko overenej práce po ňom zostane hotovej.</p>
<p><em>Osobné orientačné porovnanie jedného behu. Klinické príklady slúžia na posúdenie odpovedí AI, nie na rozhodovanie o liečbe konkrétneho pacienta.</em></p>
HTML,
    ],
    'en' => [
        'title' => 'Mercury and Claude: three tasks, one run and the limits of winning',
        'excerpt' => '19.7 seconds versus 46.9. Mercury 3 was faster and cheaper than Claude Sonnet 5.5 on three tasks. What this run showed, and why it cannot establish an overall quality ranking.',
        'image_alt' => 'Teal and violet streams of light pass through three glass gates. A stopwatch, magnifying glass and charts rest on the desk.',
        'labels' => ['Task', 'Time in seconds', 'Cost in USD', 'Output + reasoning tokens', 'Slovak text editing', 'Clinical reasoning', 'CKD-EPI 2021 code', 'Total', 'Measurements from a single run'],
        'intro' => <<<'HTML'
<p>Mercury 3 took 19.7 seconds in total to complete three matching tasks. Claude Sonnet 5.5 took 46.9 seconds. Nearly half a minute is easier to notice at work than a fraction of a cent on the bill. If checking the answer takes longer than waiting for it, the stopwatch captures only part of the job.</p>
<p>After Claude’s authentication error was resolved, the comparison ran in the same OpenCode environment: editing Slovak prose, clinical reasoning about dabigatran and implementing CKD-EPI 2021. The figures below come from the record of that single run. Exact prompts, effort settings, input token counts and complete outputs were not supplied for publication. The measurement was not independently repeated here.</p>
HTML,
        'body' => <<<'HTML'
<h2>A clear speed difference within a small sample</h2>
<p>Mercury was approximately 1.98, 2.28 and 3.02 times faster on the individual tasks, with a 2.38-fold difference in total time. These are task completion times influenced by the environment and answer length, not isolated token generation speeds. Three tasks without repetitions reveal neither latency variation nor performance during longer sessions.</p>
<h2>What the 45-fold cost difference means</h2>
<p>Mercury’s individual costs add up to USD 0.00245, rounded to USD 0.0025. Claude’s total is USD 0.1122. That is about 45 times the rounded total, or 45.8 times the sum of the individual items. The supplied account attributes about USD 0.055 to the initial prompt cache write. Subtracting this leaves USD 0.0572, about 23 times Mercury’s unrounded total.</p>
<p>This subtraction is only an approximation. Without a complete breakdown of input, cache writes and cache reads, I cannot construct equivalent cold-cache and warm-cache bills. These amounts describe this run, not a universal price list. Both are small expenses in absolute terms.</p>
<h2>Token counts do not measure depth of thought</h2>
<p>Mercury reported more reasoning tokens for the clinical task and code; Claude reported more for text editing. Claude produced longer visible answers on all three tasks. Different tokenizers and model counters do not directly measure intellectual effort. A count of 3,013 versus 1,173 cannot tell us which model reasoned better.</p>
<h2>Quality depends on checking the answer</h2>
<p>According to the original assessment, both models identified the central dabigatran contraindication: the European Pradaxa product information specifies CrCl below 30 mL/min in adults. CrCl is assessed using Cockcroft-Gault. This value must not simply be substituted with CKD-EPI eGFR indexed to 1.73 m². A more detailed answer must also distinguish European and US conditions of use correctly.</p>
<p>One code example can be checked independently: a woman aged 60 with creatinine of 80 µmol/L has an estimated GFR of about 72.704 mL/min/1.73 m² using the 2021 CKD-EPI creatinine equation. The reported 72.7 is correct. One correct calculation does not validate an entire implementation, unit conversions, boundary inputs or input validation. Without the complete answers and executable code, the favourable assessment remains that of the original comparison’s author.</p>
<p>For Slovak editing, the supplied account describes Mercury as concise and free of commentary. Claude added a comment about reconstructing diacritics. That can be a distraction in a straightforward editing task. In an uncertain clinical answer, explaining uncertainty may be exactly what is needed.</p>
<h2>Include checking time in the next run</h2>
<p>A stronger comparison would preserve exact prompts, model identifiers, effort settings and token limits, alternate call order over repeated runs and separate cold from warm cache. I would add verification and correction time to response time, and assess outputs against predefined criteria, ideally with model names hidden.</p>
<p>Across these three tasks, Mercury delivered answers faster and at a lower reported cost. That is a useful starting point for choosing a tool. The next decision depends on how much verified work it leaves complete.</p>
<p><em>An exploratory personal comparison based on one run. Clinical examples assess AI answers and are not guidance for treating an individual patient.</em></p>
HTML,
    ],
    'cs' => [
        'title' => 'Mercury a Claude: tři úlohy, jeden běh a hranice vítězství',
        'excerpt' => '19,7 sekundy proti 46,9. Mercury 3 byl ve třech úlohách rychlejší a levnější než Claude Sonnet 5.5. Co tento běh ukázal a proč z něj ještě nevzniká obecný žebříček kvality.',
        'image_alt' => 'Tyrkysový a fialový proud světla procházejí třemi skleněnými branami. Na stole leží stopky, lupa a listy s grafy.',
        'labels' => ['Úloha', 'Čas v sekundách', 'Náklady v USD', 'Výstupní + reasoning tokeny', 'Úprava slovenského textu', 'Klinické zdůvodnění', 'Kód CKD-EPI 2021', 'Celkem', 'Naměřené údaje z jednoho běhu'],
        'intro' => <<<'HTML'
<p>Na tři stejná zadání potřeboval Mercury 3 celkem 19,7 sekundy. Claude Sonnet 5.5 potřeboval 46,9 sekundy. Rozdílu téměř půl minuty si při práci všimnu snáze než zlomku centu na účtu. Pokud kontrola odpovědi trvá déle než čekání na ni, stopky zachytí jen část práce.</p>
<p>Po odstranění chyby autentizace pro Claude proběhlo srovnání ve stejném prostředí OpenCode: úprava slovenského textu, klinické zdůvodnění u dabigatranu a naprogramování CKD-EPI 2021. Čísla pocházejí ze záznamu jediného běhu. Přesná zadání, nastavení úsilí modelů, počty vstupních tokenů ani úplné výstupy nejsou součástí podkladu k publikaci. Měření zde nebylo nezávisle zopakováno.</p>
HTML,
        'body' => <<<'HTML'
<h2>Výrazný rozdíl v rychlosti na malém vzorku</h2>
<p>Mercury byl v jednotlivých úlohách přibližně 1,98krát, 2,28krát a 3,02krát rychlejší. U součtu časů jde o 2,38násobný rozdíl. Jsou to časy dokončení úloh ovlivněné prostředím a délkou odpovědí, nikoli izolovaná rychlost generování tokenů. Tři úlohy bez opakování neukazují kolísání latence ani chování při delší práci.</p>
<h2>Co znamená 45násobný rozdíl v ceně</h2>
<p>Položky Mercury dávají dohromady 0,00245 USD, zaokrouhleně 0,0025 USD. Claude má součet 0,1122 USD. To je přibližně 45násobek zaokrouhlené částky, nebo 45,8násobek součtu položek. Podklad připisuje asi 0,055 USD prvnímu zápisu do mezipaměti promptu. Po odečtení zbývá 0,0572 USD, přibližně 23násobek nezaokrouhleného součtu Mercury.</p>
<p>Takový odpočet je pouze orientační. Bez rozpisu vstupů, zápisů a čtení cache nelze sestavit srovnatelný účet pro studenou a zahřátou cache. Částky popisují tento běh, nejsou univerzálním ceníkem. V absolutním vyjádření jde v obou případech o malý výdaj.</p>
<h2>Počet tokenů neměří hloubku uvažování</h2>
<p>Mercury vykázal více reasoning tokenů u klinické úlohy a kódu, Claude u redakční úlohy. Claude vytvořil ve všech třech případech delší viditelný výstup. Různá tokenizace a počítadla modelů však přímo neměří intelektuální úsilí. Z poměru 3 013 ku 1 173 nelze určit, kdo přemýšlel lépe.</p>
<h2>Kvalitu rozhodne kontrola odpovědi</h2>
<p>Podle původního hodnocení oba modely zachytily zásadní kontraindikaci dabigatranu: evropský souhrn údajů o přípravku Pradaxa uvádí u dospělých CrCl pod 30 ml/min. Pro posouzení CrCl slouží Cockcroftova a Gaultova rovnice. Tento údaj nelze jednoduše zaměnit za eGFR podle CKD-EPI vztaženou na 1,73 m². Podrobná odpověď musí správně rozlišovat evropské a americké podmínky použití.</p>
<p>U kódu lze nezávisle ověřit konkrétní bod: žena ve věku 60 let s kreatininem 80 µmol/l má podle kreatininové rovnice CKD-EPI 2021 eGFR přibližně 72,704 ml/min/1,73 m². Uvedených 72,7 tedy sedí. Jediný správný výpočet ale neověří celou implementaci, převody jednotek, hraniční vstupy ani validaci. Bez úplných odpovědí a spustitelného kódu zůstává příznivý úsudek hodnocením autora původního srovnání.</p>
<p>Při úpravě slovenštiny byl Mercury podle podkladu stručný a bez komentáře, Claude přidal poznámku o rekonstrukci diakritiky. U čistě redakčního zadání může dodatek překážet. U nejistého klinického údaje může vysvětlení nejistoty být právě tím potřebným.</p>
<h2>Příště měřit i čas kontroly</h2>
<p>Další srovnání by mělo uchovat přesná zadání, identifikátory modelů, nastavení úsilí a limity tokenů, opakovaně střídat pořadí volání a oddělit studenou cache od zahřáté. K času odpovědi bych přidal čas ověřování a oprav. Výstupy by se měly hodnotit podle předem daných kritérií, ideálně bez názvů modelů.</p>
<p>Ve třech úlohách Mercury dodal odpovědi rychleji a za nižší vykázanou cenu. Pro výběr nástroje je to užitečný začátek. Další rozhodnutí záleží na tom, kolik ověřené práce po něm zůstane hotové.</p>
<p><em>Osobní orientační srovnání jediného běhu. Klinické příklady slouží k posouzení odpovědí AI, nikoli k rozhodování o léčbě konkrétního pacienta.</em></p>
HTML,
    ],
    'de' => [
        'title' => 'Mercury und Claude: drei Aufgaben, ein Durchlauf und die Grenzen des Siegens',
        'excerpt' => '19,7 gegenüber 46,9 Sekunden. Mercury 3 war bei drei Aufgaben schneller und günstiger als Claude Sonnet 5.5. Was dieser Durchlauf zeigt und weshalb daraus keine allgemeine Qualitätsrangliste entsteht.',
        'image_alt' => 'Türkisfarbene und violette Lichtströme durchqueren drei Glastore. Auf dem Tisch liegen eine Stoppuhr, eine Lupe und Diagramme.',
        'labels' => ['Aufgabe', 'Zeit in Sekunden', 'Kosten in USD', 'Ausgabe- + Reasoning-Token', 'Slowakischen Text redigieren', 'Klinische Begründung', 'CKD-EPI-2021-Code', 'Gesamt', 'Messwerte aus einem Durchlauf'],
        'intro' => <<<'HTML'
<p>Mercury 3 benötigte für drei gleiche Aufgaben insgesamt 19,7 Sekunden, Claude Sonnet 5.5 dagegen 46,9 Sekunden. Fast eine halbe Minute fällt bei der Arbeit eher auf als ein Bruchteil eines Cents auf der Rechnung. Dauert die Prüfung länger als das Warten auf die Antwort, erfasst die Stoppuhr nur einen Teil der Arbeit.</p>
<p>Nach Behebung eines Authentifizierungsfehlers bei Claude lief der Vergleich in derselben OpenCode-Umgebung: einen slowakischen Text redigieren, eine klinische Frage zu Dabigatran begründen und CKD-EPI 2021 programmieren. Die Zahlen stammen aus dem Protokoll dieses einzelnen Durchlaufs. Genaue Prompts, Aufwandseinstellungen, Eingabe-Token und vollständige Antworten lagen für die Veröffentlichung nicht vor. Eine unabhängige Wiederholung erfolgte hier nicht.</p>
HTML,
        'body' => <<<'HTML'
<h2>Deutlicher Zeitunterschied, kleine Stichprobe</h2>
<p>Mercury war bei den einzelnen Aufgaben etwa 1,98-, 2,28- und 3,02-mal schneller. Insgesamt ergibt sich Faktor 2,38. Gemessen wurde die Bearbeitungsdauer, beeinflusst von Umgebung und Antwortlänge, nicht allein die Geschwindigkeit der Token-Erzeugung. Drei Aufgaben ohne Wiederholungen zeigen weder Latenzschwankungen noch das Verhalten in längeren Sitzungen.</p>
<h2>Was der 45-fache Kostenunterschied bedeutet</h2>
<p>Mercurys Einzelposten ergeben 0,00245 USD, gerundet 0,0025 USD. Claude kommt auf 0,1122 USD. Das entspricht etwa dem 45-Fachen des gerundeten Betrags oder dem 45,8-Fachen der Einzelpostensumme. Laut Ausgangsbericht entfallen etwa 0,055 USD auf den ersten Schreibvorgang im Prompt-Cache. Zieht man diesen Betrag ab, bleiben 0,0572 USD, etwa das 23-Fache von Mercurys ungerundeter Summe.</p>
<p>Diese Rechnung ist eine Näherung. Ohne vollständige Aufschlüsselung von Eingaben, Cache-Schreib- und Lesevorgängen lässt sich kein gleichwertiger Vergleich zwischen kaltem und warmem Cache erstellen. Die Beträge gelten für diesen Durchlauf, nicht als allgemeine Preisliste. Absolut gesehen sind beide Ausgaben gering.</p>
<h2>Token zählen ist kein Maß für Denktiefe</h2>
<p>Mercury meldete bei der klinischen Aufgabe und beim Code mehr Reasoning-Token, Claude bei der Textredaktion. Claudes sichtbare Antworten waren immer länger. Unterschiedliche Tokenisierung und Zähler messen jedoch nicht unmittelbar den Denkaufwand. Aus 3 013 gegenüber 1 173 lässt sich keine bessere Denkqualität ableiten.</p>
<h2>Qualität braucht überprüfte Antworten</h2>
<p>Nach der ursprünglichen Bewertung erkannten beide Modelle die entscheidende Kontraindikation für Dabigatran: Die europäische Pradaxa-Fachinformation nennt bei Erwachsenen eine CrCl unter 30 ml/min. Die CrCl wird mit Cockcroft-Gault beurteilt. Sie darf nicht ohne Weiteres durch eine auf 1,73 m² normierte CKD-EPI-eGFR ersetzt werden. Ausführlichere Antworten müssen außerdem europäische und US-amerikanische Anwendungsbedingungen korrekt unterscheiden.</p>
<p>Ein Rechenbeispiel lässt sich unabhängig prüfen: Bei einer 60-jährigen Frau mit Kreatinin 80 µmol/l ergibt die CKD-EPI-Kreatininformel von 2021 etwa 72,704 ml/min/1,73 m². Die genannten 72,7 stimmen. Ein richtiger Einzelwert validiert aber weder die gesamte Implementierung noch Einheitenumrechnung, Grenzfälle und Eingabeprüfung. Ohne vollständige Antworten und ausführbaren Code bleibt das positive Qualitätsurteil das Urteil des ursprünglichen Vergleichsautors.</p>
<p>Bei der slowakischen Redaktion antwortete Mercury laut Bericht knapp und ohne Kommentar. Claude ergänzte einen Hinweis zur Rekonstruktion der Diakritik. Bei einem reinen Redaktionsauftrag kann das stören. Bei klinischer Unsicherheit kann eine Erläuterung genau richtig sein.</p>
<h2>Beim nächsten Mal auch die Prüfzeit messen</h2>
<p>Ein besserer Vergleich würde Prompts, Modellkennungen, Aufwandseinstellungen und Token-Limits festhalten, die Aufrufreihenfolge bei Wiederholungen wechseln sowie kalten und warmen Cache trennen. Zur Antwortzeit würde ich Prüf- und Korrekturzeit addieren. Die Bewertung sollte vorab festgelegten Kriterien folgen, möglichst ohne sichtbare Modellnamen.</p>
<p>In diesen drei Aufgaben lieferte Mercury schneller und zu geringeren ausgewiesenen Kosten. Das hilft bei der Werkzeugwahl. Entscheidend für den weiteren Einsatz bleibt, wie viel überprüfte Arbeit anschließend erledigt ist.</p>
<p><em>Persönlicher orientierender Vergleich eines Durchlaufs. Die klinischen Beispiele bewerten KI-Antworten und dienen nicht der Behandlung einzelner Patienten.</em></p>
HTML,
    ],
    'fr' => [
        'title' => 'Mercury et Claude : trois tâches, un seul essai et les limites de la victoire',
        'excerpt' => '19,7 secondes contre 46,9. Mercury 3 a été plus rapide et moins coûteux que Claude Sonnet 5.5 sur trois tâches. Ce que cet essai montre, sans établir de classement général de qualité.',
        'image_alt' => 'Des faisceaux turquoise et violets traversent trois portiques en verre. Un chronomètre, une loupe et des graphiques reposent sur la table.',
        'labels' => ['Tâche', 'Temps en secondes', 'Coût en USD', 'Jetons de sortie + de raisonnement', 'Révision d’un texte slovaque', 'Justification clinique', 'Code CKD-EPI 2021', 'Total', 'Mesures issues d’un seul essai'],
        'intro' => <<<'HTML'
<p>Mercury 3 a pris 19,7 secondes au total pour trois consignes identiques, contre 46,9 secondes pour Claude Sonnet 5.5. Au travail, presque une demi-minute se remarque davantage qu’une fraction de centime sur la facture. Si vérifier la réponse prend plus de temps que l’attendre, le chronomètre ne mesure qu’une partie du travail.</p>
<p>Après résolution de l’erreur d’authentification de Claude, la comparaison a été réalisée dans le même environnement OpenCode : révision d’un texte slovaque, justification clinique concernant le dabigatran et programmation de CKD-EPI 2021. Les chiffres proviennent du compte rendu d’un seul essai. Les consignes exactes, les réglages d’effort, les jetons d’entrée et les réponses intégrales n’ont pas été fournis pour publication. Les mesures n’ont pas été reproduites indépendamment ici.</p>
HTML,
        'body' => <<<'HTML'
<h2>Un écart net sur un petit échantillon</h2>
<p>Mercury a été environ 1,98, 2,28 et 3,02 fois plus rapide selon la tâche, soit un facteur 2,38 sur le temps total. Il s’agit de durées d’exécution influencées par l’environnement et la longueur des réponses, pas d’une mesure isolée du débit de génération. Trois tâches sans répétition ne révèlent ni la variabilité de latence ni le comportement lors de sessions prolongées.</p>
<h2>Que signifie un coût multiplié par 45 ?</h2>
<p>Les postes Mercury totalisent 0,00245 USD, arrondis à 0,0025 USD. Claude totalise 0,1122 USD : environ 45 fois le total arrondi, ou 45,8 fois la somme détaillée. Le compte rendu attribue environ 0,055 USD à la première écriture dans le cache de prompt. Une simple soustraction laisse 0,0572 USD, soit environ 23 fois le total non arrondi de Mercury.</p>
<p>Ce calcul reste indicatif. Sans ventilation complète des entrées et des écritures et lectures du cache, impossible de construire deux factures comparables à cache froid et à cache chaud. Ces montants décrivent cet essai, pas un tarif universel. En valeur absolue, les deux dépenses sont modestes.</p>
<h2>Les jetons ne mesurent pas la profondeur du raisonnement</h2>
<p>Mercury a déclaré davantage de jetons de raisonnement pour la tâche clinique et le code, Claude pour la révision. Les réponses visibles de Claude étaient plus longues dans les trois cas. Les méthodes de découpage en jetons et les compteurs diffèrent : ils ne mesurent pas directement l’effort intellectuel. Comparer 3 013 à 1 173 ne permet pas de savoir qui a mieux raisonné.</p>
<h2>La qualité se juge en vérifiant</h2>
<p>Selon l’évaluation initiale, les deux modèles ont identifié la contre-indication essentielle du dabigatran : le résumé européen des caractéristiques de Pradaxa mentionne une ClCr inférieure à 30 ml/min chez l’adulte. La ClCr est évaluée par Cockcroft-Gault. Elle ne se substitue pas simplement au DFGe CKD-EPI indexé sur 1,73 m². Une réponse détaillée doit aussi distinguer correctement les conditions d’utilisation européennes et américaines.</p>
<p>Un exemple peut être vérifié : chez une femme de 60 ans ayant une créatinine de 80 µmol/l, l’équation CKD-EPI 2021 basée sur la créatinine donne environ 72,704 ml/min/1,73 m². Le résultat annoncé de 72,7 est juste. Un seul calcul correct ne valide toutefois ni l’implémentation entière, ni les conversions, ni les cas limites et la validation des entrées. Sans réponses intégrales et code exécutable, le jugement favorable reste celui de l’auteur du comparatif initial.</p>
<p>Pour le texte slovaque, Mercury aurait répondu sobrement, sans commentaire ; Claude aurait ajouté une remarque sur la restitution des signes diacritiques. Cela peut gêner une simple révision. Dans une réponse clinique incertaine, expliquer l’incertitude peut au contraire être nécessaire.</p>
<h2>Mesurer aussi le temps de vérification</h2>
<p>Un prochain essai devrait conserver les consignes, les identifiants des modèles, les réglages d’effort et les limites de jetons, alterner l’ordre des appels et séparer cache froid et cache chaud. J’ajouterais le temps de vérification et de correction au temps de réponse. L’évaluation suivrait des critères préétablis, idéalement sans connaître le modèle.</p>
<p>Sur ces trois tâches, Mercury a répondu plus vite et à moindre coût déclaré. C’est un point de départ utile pour choisir un outil. Son intérêt durable dépend du travail vérifié qu’il permet d’achever.</p>
<p><em>Comparaison personnelle exploratoire sur un seul essai. Les exemples cliniques évaluent les réponses de l’IA et ne guident pas le traitement d’un patient particulier.</em></p>
HTML,
    ],
    'es' => [
        'title' => 'Mercury y Claude: tres tareas, una ejecución y los límites de la victoria',
        'excerpt' => '19,7 segundos frente a 46,9. Mercury 3 fue más rápido y barato que Claude Sonnet 5.5 en tres tareas. Qué mostró esta ejecución y por qué no establece una clasificación general de calidad.',
        'image_alt' => 'Dos haces de luz turquesa y violeta atraviesan tres puertas de cristal. En la mesa hay un cronómetro, una lupa y gráficos.',
        'labels' => ['Tarea', 'Tiempo en segundos', 'Coste en USD', 'Tokens de salida + de razonamiento', 'Revisión de un texto eslovaco', 'Justificación clínica', 'Código CKD-EPI 2021', 'Total', 'Mediciones de una sola ejecución'],
        'intro' => <<<'HTML'
<p>Mercury 3 necesitó 19,7 segundos en total para tres tareas idénticas. Claude Sonnet 5.5 necesitó 46,9. Casi medio minuto se nota más durante el trabajo que una fracción de céntimo en la factura. Si comprobar la respuesta lleva más tiempo que esperarla, el cronómetro recoge solo una parte del trabajo.</p>
<p>Una vez resuelto el error de autenticación de Claude, la comparación se realizó en el mismo entorno OpenCode: revisión de un texto eslovaco, justificación clínica sobre dabigatrán y programación de CKD-EPI 2021. Los datos proceden del registro de una única ejecución. No se facilitaron para su publicación las instrucciones exactas, los ajustes de esfuerzo, los tokens de entrada ni las respuestas completas. Las mediciones no se repitieron aquí de forma independiente.</p>
HTML,
        'body' => <<<'HTML'
<h2>Una diferencia clara en una muestra pequeña</h2>
<p>Mercury fue aproximadamente 1,98, 2,28 y 3,02 veces más rápido según la tarea; la diferencia total fue de 2,38 veces. Son tiempos de finalización influidos por el entorno y la extensión de las respuestas, no una medición aislada de la generación de tokens. Tres tareas sin repeticiones no muestran la variabilidad de la latencia ni el rendimiento en sesiones largas.</p>
<h2>Qué significa una diferencia de coste de 45 veces</h2>
<p>Las partidas de Mercury suman 0,00245 USD, redondeados a 0,0025 USD. Claude suma 0,1122 USD: unas 45 veces el total redondeado o 45,8 veces la suma detallada. El registro atribuye unos 0,055 USD a la primera escritura en la caché del prompt. Al restarlos quedan 0,0572 USD, unas 23 veces el total sin redondear de Mercury.</p>
<p>La resta es orientativa. Sin el desglose completo de entradas, escrituras y lecturas de caché no puedo reconstruir facturas equivalentes con caché fría y caliente. Los importes corresponden a esta ejecución, no a una tarifa universal. En términos absolutos, ambos gastos son pequeños.</p>
<h2>Los tokens no miden la profundidad del razonamiento</h2>
<p>Mercury declaró más tokens de razonamiento en la tarea clínica y en el código; Claude, en la revisión. Las respuestas visibles de Claude fueron más largas en los tres casos. Los distintos contadores y métodos de tokenización no miden directamente el esfuerzo intelectual. Comparar 3 013 con 1 173 no determina quién razonó mejor.</p>
<h2>La calidad se decide al comprobar</h2>
<p>Según la evaluación original, ambos modelos identificaron la contraindicación esencial del dabigatrán: la ficha técnica europea de Pradaxa establece un aclaramiento de creatinina (CrCl) inferior a 30 ml/min en adultos. El CrCl se estima mediante Cockcroft-Gault. No puede sustituirse sin más por el FG estimado mediante CKD-EPI, indexado a 1,73 m². Una respuesta detallada debe distinguir también las condiciones de uso europeas y estadounidenses.</p>
<p>Se puede verificar un ejemplo: para una mujer de 60 años con creatinina de 80 µmol/l, la ecuación de creatinina CKD-EPI 2021 da aproximadamente 72,704 ml/min/1,73 m². El resultado de 72,7 es correcto. Un cálculo acertado no valida toda la implementación, las conversiones, los casos límite ni la validación de entradas. Sin las respuestas completas y el código ejecutable, la valoración favorable sigue siendo la del autor de la comparación inicial.</p>
<p>En la revisión del eslovaco, el registro describe a Mercury como conciso y sin comentarios. Claude añadió una observación sobre la reconstrucción de diacríticos. Puede sobrar en una tarea puramente editorial. Ante un dato clínico incierto, explicar esa incertidumbre puede ser necesario.</p>
<h2>Medir también el tiempo de comprobación</h2>
<p>La siguiente comparación debería conservar instrucciones, identificadores de modelo, ajustes de esfuerzo y límites de tokens, alternar el orden de las llamadas en ejecuciones repetidas y separar caché fría y caliente. Añadiría el tiempo de verificación y corrección al de respuesta. La evaluación seguiría criterios predefinidos, idealmente sin mostrar el nombre del modelo.</p>
<p>En estas tres tareas, Mercury respondió antes y con un coste declarado menor. Es un comienzo útil para elegir una herramienta. Su uso posterior dependerá de cuánto trabajo verificado deje terminado.</p>
<p><em>Comparación personal orientativa de una sola ejecución. Los ejemplos clínicos evalúan respuestas de IA y no orientan el tratamiento de un paciente concreto.</em></p>
HTML,
    ],
    'pl' => [
        'title' => 'Mercury i Claude: trzy zadania, jedna próba i granice zwycięstwa',
        'excerpt' => '19,7 sekundy wobec 46,9. Mercury 3 był szybszy i tańszy od Claude Sonnet 5.5 w trzech zadaniach. Co pokazała ta próba i dlaczego nie tworzy ogólnego rankingu jakości.',
        'image_alt' => 'Turkusowe i fioletowe strumienie światła przechodzą przez trzy szklane bramy. Na stole leżą stoper, lupa i wykresy.',
        'labels' => ['Zadanie', 'Czas w sekundach', 'Koszt w USD', 'Tokeny wyjściowe + rozumowania', 'Redakcja tekstu słowackiego', 'Uzasadnienie kliniczne', 'Kod CKD-EPI 2021', 'Razem', 'Pomiary z jednej próby'],
        'intro' => <<<'HTML'
<p>Mercury 3 potrzebował łącznie 19,7 sekundy na trzy identyczne zadania. Claude Sonnet 5.5 potrzebował 46,9 sekundy. Niemal pół minuty łatwiej zauważyć w pracy niż ułamek centa na rachunku. Jeżeli sprawdzenie odpowiedzi trwa dłużej niż czekanie na nią, stoper mierzy tylko część pracy.</p>
<p>Po usunięciu błędu uwierzytelniania Claude porównanie odbyło się w tym samym środowisku OpenCode: redakcja słowackiego tekstu, uzasadnienie kliniczne dotyczące dabigatranu i zaprogramowanie CKD-EPI 2021. Dane pochodzą z zapisu jednej próby. Do publikacji nie dostarczono dokładnych poleceń, ustawień wysiłku modeli, liczby tokenów wejściowych ani pełnych odpowiedzi. Pomiaru nie powtórzono tutaj niezależnie.</p>
HTML,
        'body' => <<<'HTML'
<h2>Wyraźna różnica w małej próbie</h2>
<p>Mercury był w poszczególnych zadaniach około 1,98, 2,28 i 3,02 razy szybszy. Łączny czas różnił się 2,38-krotnie. To czas ukończenia zadania, zależny od środowiska i długości odpowiedzi, a nie sam pomiar szybkości generowania tokenów. Trzy zadania bez powtórzeń nie pokazują zmienności opóźnień ani zachowania podczas długich sesji.</p>
<h2>Co oznacza 45-krotna różnica kosztów</h2>
<p>Pozycje Mercury sumują się do 0,00245 USD, po zaokrągleniu 0,0025 USD. Claude kosztował 0,1122 USD: około 45 razy więcej niż zaokrąglona suma lub 45,8 razy więcej niż suma pozycji. Zapis przypisuje około 0,055 USD pierwszemu zapisowi w pamięci podręcznej promptu. Po odjęciu zostaje 0,0572 USD, około 23 razy więcej niż niezaokrąglona suma Mercury.</p>
<p>Takie odejmowanie jest orientacyjne. Bez pełnego zestawienia wejść oraz zapisów i odczytów cache nie da się odtworzyć porównywalnych rachunków dla pustej i rozgrzanej pamięci podręcznej. To koszty tej próby, nie uniwersalny cennik. W wartościach bezwzględnych oba wydatki są małe.</p>
<h2>Liczba tokenów nie mierzy głębokości rozumowania</h2>
<p>Mercury wykazał więcej tokenów rozumowania w zadaniu klinicznym i kodzie, Claude przy redakcji. Widoczne odpowiedzi Claude były dłuższe we wszystkich zadaniach. Różne tokenizery i liczniki nie mierzą jednak bezpośrednio wysiłku intelektualnego. Z porównania 3 013 do 1 173 nie wynika, kto rozumował lepiej.</p>
<h2>O jakości decyduje sprawdzenie</h2>
<p>Według pierwotnej oceny oba modele wskazały zasadnicze przeciwwskazanie do dabigatranu: europejska charakterystyka produktu leczniczego Pradaxa podaje u dorosłych CrCl poniżej 30 ml/min. CrCl ocenia się metodą Cockcrofta-Gaulta. Nie można go po prostu zastąpić eGFR według CKD-EPI przeliczoną na 1,73 m². Szczegółowa odpowiedź musi też prawidłowo rozróżniać europejskie i amerykańskie warunki stosowania.</p>
<p>Można niezależnie sprawdzić przykład: kobieta w wieku 60 lat, kreatynina 80 µmol/l, uzyskuje we wzorze kreatyninowym CKD-EPI 2021 około 72,704 ml/min/1,73 m². Podane 72,7 jest poprawne. Pojedynczy prawidłowy wynik nie weryfikuje całej implementacji, przeliczeń jednostek, przypadków brzegowych ani walidacji danych. Bez pełnych odpowiedzi i wykonywalnego kodu pozytywna ocena pozostaje oceną autora pierwotnego porównania.</p>
<p>Według zapisu Mercury zredagował słowacki tekst zwięźle i bez komentarza. Claude dodał uwagę o odtworzeniu znaków diakrytycznych. Przy zwykłej redakcji może to przeszkadzać. W niepewnej odpowiedzi klinicznej wyjaśnienie niepewności może być potrzebne.</p>
<h2>Następnym razem także czas weryfikacji</h2>
<p>Kolejne porównanie powinno zachować polecenia, identyfikatory modeli, ustawienia wysiłku i limity tokenów, zmieniać kolejność wywołań w powtórzeniach oraz oddzielać pustą pamięć podręczną od rozgrzanej. Do czasu odpowiedzi dodałbym czas sprawdzania i poprawek. Ocena powinna opierać się na ustalonych wcześniej kryteriach, najlepiej bez widocznych nazw modeli.</p>
<p>W tych trzech zadaniach Mercury odpowiadał szybciej i przy niższym wykazanym koszcie. To użyteczny początek wyboru narzędzia. O dalszym użyciu zdecyduje ilość ukończonej i zweryfikowanej pracy.</p>
<p><em>Osobiste, orientacyjne porównanie jednej próby. Przykłady kliniczne służą ocenie odpowiedzi AI, a nie leczeniu konkretnego pacjenta.</em></p>
HTML,
    ],
    'hu' => [
        'title' => 'Mercury és Claude: három feladat, egy mérés és a győzelem határai',
        'excerpt' => '19,7 másodperc a 46,9-cel szemben. A Mercury 3 három feladatban gyorsabb és olcsóbb volt a Claude Sonnet 5.5-nél. Mit mutat ez a mérés, és miért nem általános minőségi rangsor?',
        'image_alt' => 'Türkiz és lila fényáram halad át három üvegkapun. Az asztalon stopperóra, nagyító és grafikonok láthatók.',
        'labels' => ['Feladat', 'Idő másodpercben', 'Költség USD-ben', 'Kimeneti + gondolkodási tokenek', 'Szlovák szöveg szerkesztése', 'Klinikai indoklás', 'CKD-EPI 2021 kód', 'Összesen', 'Egyetlen mérés adatai'],
        'intro' => <<<'HTML'
<p>A Mercury 3 összesen 19,7 másodperc alatt végzett három azonos feladattal. A Claude Sonnet 5.5-nek 46,9 másodperc kellett. Munka közben majdnem fél perc hamarabb feltűnik, mint egy cent töredéke a számlán. Ha az ellenőrzés tovább tart, mint a válaszra várakozás, a stopper csak a munka egy részét méri.</p>
<p>A Claude hitelesítési hibájának javítása után az összehasonlítás ugyanabban az OpenCode-környezetben futott: szlovák szöveg szerkesztése, dabigatránnal kapcsolatos klinikai indoklás és a CKD-EPI 2021 programozása. Az adatok egyetlen futás feljegyzéséből származnak. A pontos utasítások, az erőfeszítés beállításai, a bemeneti tokenszámok és a teljes válaszok nem álltak rendelkezésre a közléshez. A mérést itt nem ismételtük meg függetlenül.</p>
HTML,
        'body' => <<<'HTML'
<h2>Jelentős időkülönbség, kis minta</h2>
<p>A Mercury az egyes feladatokban hozzávetőleg 1,98-szor, 2,28-szor és 3,02-szor volt gyorsabb, összesítve 2,38-szor. Ezek a környezettől és a válasz hosszától is függő teljesítési idők, nem a tokengenerálás önálló sebességmérései. Három feladat ismétlések nélkül nem mutatja meg a késleltetés ingadozását vagy a hosszabb munkamenetek viselkedését.</p>
<h2>Mit jelent a 45-szörös költségkülönbség?</h2>
<p>A Mercury tételei összesen 0,00245 USD-t, kerekítve 0,0025 USD-t adnak. A Claude összege 0,1122 USD: a kerekített összeg körülbelül 45-szöröse, a tételes összeg 45,8-szerese. A feljegyzés nagyjából 0,055 USD-t tulajdonít a prompt gyorsítótárába történő első írásnak. Ennek levonása után 0,0572 USD marad, a Mercury kerekítetlen összegének mintegy 23-szorosa.</p>
<p>Ez csak közelítés. A bemenetek, valamint a gyorsítótár írásainak és olvasásainak teljes bontása nélkül nem állítható össze azonos feltételekkel számolt hideg és meleg gyorsítótáras számla. Ezek az adott futás költségei, nem általános díjszabás. Abszolút értékben mindkét kiadás csekély.</p>
<h2>A tokenszám nem a gondolkodás mélysége</h2>
<p>A Mercury a klinikai feladatnál és a kódnál jelzett több gondolkodási tokent, a Claude a szövegszerkesztésnél. A Claude látható válaszai mindhárom esetben hosszabbak voltak. Az eltérő tokenizálás és számlálás azonban nem méri közvetlenül a szellemi erőfeszítést. A 3 013 és 1 173 összevetéséből nem derül ki, melyik modell gondolkodott jobban.</p>
<h2>A minőséget ellenőrizni kell</h2>
<p>Az eredeti értékelés szerint mindkét modell felismerte a dabigatrán lényeges ellenjavallatát: a Pradaxa európai alkalmazási előírása felnőtteknél 30 ml/perc alatti CrCl-t nevez meg. A CrCl megítélésére a Cockcroft-Gault-képlet szolgál. Ez nem helyettesíthető egyszerűen az 1,73 m²-re vonatkoztatott CKD-EPI eGFR-rel. A részletes válasznak az európai és amerikai alkalmazási feltételeket is helyesen kell elkülönítenie.</p>
<p>Egy példaszámítás függetlenül ellenőrizhető: egy 60 éves nő 80 µmol/l kreatininszintje a 2021-es kreatininalapú CKD-EPI-képlettel mintegy 72,704 ml/perc/1,73 m² eredményt ad. A közölt 72,7 helyes. Egyetlen jó számítás azonban nem igazolja a teljes implementációt, az egységátváltásokat, a szélső eseteket vagy a bemenetellenőrzést. A teljes válaszok és futtatható kód nélkül a kedvező minősítés az eredeti összehasonlítás szerzőjének értékelése marad.</p>
<p>A feljegyzés szerint a Mercury tömören, kommentár nélkül szerkesztette a szlovák szöveget. A Claude megjegyzést fűzött az ékezetek helyreállításához. Egy tisztán szerkesztési feladatnál ez zavaró lehet. Bizonytalan klinikai adatnál viszont szükség lehet a bizonytalanság kifejtésére.</p>
<h2>Legközelebb az ellenőrzés idejét is mérni</h2>
<p>A következő összehasonlítás őrizze meg a pontos utasításokat, modellazonosítókat, erőfeszítés-beállításokat és tokenkorlátokat, ismételt futásokban váltogassa a hívási sorrendet, és különítse el a hideg és meleg gyorsítótárat. A válaszidőhöz hozzáadnám az ellenőrzés és javítás idejét. Az értékelés előre meghatározott szempontok szerint, lehetőleg a modellnevek ismerete nélkül történjen.</p>
<p>E három feladatban a Mercury gyorsabban, alacsonyabb kimutatott költséggel válaszolt. Ez hasznos kezdet az eszközválasztáshoz. A további használatról az dönt, mennyi ellenőrzött munka marad utána készen.</p>
<p><em>Személyes, tájékozódó összehasonlítás egyetlen futás alapján. A klinikai példák az AI válaszainak értékelését szolgálják, nem egy adott beteg kezelését.</em></p>
HTML,
    ],
    'it' => [
        'title' => 'Mercury e Claude: tre compiti, una prova e i limiti della vittoria',
        'excerpt' => '19,7 secondi contro 46,9. Mercury 3 è stato più rapido ed economico di Claude Sonnet 5.5 in tre compiti. Che cosa mostra questa prova e perché non stabilisce una classifica generale di qualità.',
        'image_alt' => 'Fasci di luce turchese e viola attraversano tre porte di vetro. Sul tavolo ci sono un cronometro, una lente e fogli con grafici.',
        'labels' => ['Compito', 'Tempo in secondi', 'Costo in USD', 'Token di output + ragionamento', 'Revisione di un testo slovacco', 'Motivazione clinica', 'Codice CKD-EPI 2021', 'Totale', 'Misurazioni di una sola prova'],
        'intro' => <<<'HTML'
<p>Mercury 3 ha impiegato complessivamente 19,7 secondi per tre compiti identici. Claude Sonnet 5.5 ne ha impiegati 46,9. Quasi mezzo minuto si nota sul lavoro più di una frazione di centesimo in fattura. Se controllare la risposta richiede più tempo che attenderla, il cronometro registra solo una parte del lavoro.</p>
<p>Risolto l’errore di autenticazione di Claude, il confronto si è svolto nello stesso ambiente OpenCode: revisione di un testo slovacco, motivazione clinica sul dabigatran e programmazione di CKD-EPI 2021. I numeri provengono dal resoconto di una sola prova. I prompt esatti, le impostazioni dello sforzo, i token di input e le risposte complete non sono stati forniti per la pubblicazione. Qui la misurazione non è stata ripetuta indipendentemente.</p>
HTML,
        'body' => <<<'HTML'
<h2>Una differenza netta in un campione piccolo</h2>
<p>Mercury è stato circa 1,98, 2,28 e 3,02 volte più rapido nei singoli compiti, con un rapporto di 2,38 sul tempo totale. Sono tempi di completamento influenzati dall’ambiente e dalla lunghezza delle risposte, non misure isolate della velocità di generazione dei token. Tre compiti senza ripetizioni non mostrano la variabilità della latenza né il comportamento nelle sessioni lunghe.</p>
<h2>Che cosa significa un costo 45 volte maggiore</h2>
<p>Le voci di Mercury sommano a 0,00245 USD, arrotondati a 0,0025 USD. Claude totalizza 0,1122 USD: circa 45 volte il totale arrotondato, oppure 45,8 volte la somma delle voci. Il resoconto attribuisce circa 0,055 USD alla prima scrittura nella cache del prompt. Sottraendoli restano 0,0572 USD, circa 23 volte il totale non arrotondato di Mercury.</p>
<p>La sottrazione è indicativa. Senza un dettaglio completo di input, scritture e letture della cache non posso ricostruire fatture equivalenti a cache fredda e calda. Sono costi di questa prova, non un listino universale. In termini assoluti entrambe le spese sono contenute.</p>
<h2>I token non misurano la profondità del ragionamento</h2>
<p>Mercury ha dichiarato più token di ragionamento nel compito clinico e nel codice, Claude nella revisione. Le risposte visibili di Claude erano più lunghe in tutti i casi. Tokenizzazioni e contatori diversi non misurano direttamente lo sforzo intellettuale. Da 3 013 contro 1 173 non si può dedurre chi abbia ragionato meglio.</p>
<h2>La qualità richiede verifica</h2>
<p>Secondo la valutazione iniziale, entrambi i modelli hanno identificato la controindicazione essenziale del dabigatran: il riassunto europeo delle caratteristiche di Pradaxa indica negli adulti una CrCl inferiore a 30 ml/min. Per stimare la CrCl si usa Cockcroft-Gault. Non la si può semplicemente sostituire con l’eGFR CKD-EPI indicizzata a 1,73 m². Una risposta dettagliata deve inoltre distinguere correttamente le condizioni d’uso europee e statunitensi.</p>
<p>Un esempio è verificabile indipendentemente: una donna di 60 anni con creatinina di 80 µmol/l ottiene circa 72,704 ml/min/1,73 m² con l’equazione CKD-EPI 2021 basata sulla creatinina. Il risultato di 72,7 è corretto. Un singolo calcolo non convalida però tutta l’implementazione, le conversioni, i casi limite o la validazione degli input. Senza risposte integrali e codice eseguibile, il giudizio favorevole rimane quello dell’autore del confronto originale.</p>
<p>Per la revisione dello slovacco, il resoconto descrive Mercury come conciso e senza commenti. Claude ha aggiunto una nota sulla ricostruzione dei segni diacritici. Può essere superflua in un incarico puramente redazionale. Davanti a un dato clinico incerto, spiegare l’incertezza può invece servire.</p>
<h2>Misurare anche il tempo di controllo</h2>
<p>Il prossimo confronto dovrebbe conservare prompt, identificativi dei modelli, impostazioni dello sforzo e limiti di token, alternare l’ordine delle chiamate in prove ripetute e separare cache fredda e calda. Aggiungerei al tempo di risposta quello di verifica e correzione. La valutazione dovrebbe seguire criteri prestabiliti, possibilmente senza mostrare il nome del modello.</p>
<p>In questi tre compiti Mercury ha risposto prima, a un costo dichiarato inferiore. È un punto di partenza utile per scegliere uno strumento. L’impiego successivo dipenderà da quanto lavoro verificato lascia concluso.</p>
<p><em>Confronto personale esplorativo di una sola prova. Gli esempi clinici valutano le risposte dell’AI e non guidano la cura di un singolo paziente.</em></p>
HTML,
    ],
    'uk' => [
        'title' => 'Mercury і Claude: три завдання, один запуск і межі перемоги',
        'excerpt' => '19,7 секунди проти 46,9. Mercury 3 був швидшим і дешевшим за Claude Sonnet 5.5 у трьох завданнях. Що показав цей запуск і чому він не створює загального рейтингу якості.',
        'image_alt' => 'Бірюзові та фіолетові потоки світла проходять крізь три скляні брами. На столі лежать секундомір, лупа та аркуші з графіками.',
        'labels' => ['Завдання', 'Час у секундах', 'Вартість у USD', 'Токени відповіді + міркування', 'Редагування словацького тексту', 'Клінічне обґрунтування', 'Код CKD-EPI 2021', 'Разом', 'Вимірювання одного запуску'],
        'intro' => <<<'HTML'
<p>Mercury 3 витратив загалом 19,7 секунди на три однакові завдання. Claude Sonnet 5.5 потребував 46,9 секунди. Майже пів хвилини під час роботи помітніші за частку цента в рахунку. Якщо перевірка відповіді триває довше за очікування, секундомір охоплює лише частину роботи.</p>
<p>Після усунення помилки автентифікації Claude порівняння відбулося в тому самому середовищі OpenCode: редагування словацького тексту, клінічне обґрунтування щодо дабігатрану та програмування CKD-EPI 2021. Дані походять із запису одного запуску. Точні запити, налаштування зусилля моделей, кількість вхідних токенів і повні відповіді для публікації не надано. Незалежного повторення вимірювання тут не було.</p>
HTML,
        'body' => <<<'HTML'
<h2>Виразна різниця на малій вибірці</h2>
<p>Mercury був приблизно в 1,98, 2,28 та 3,02 раза швидшим в окремих завданнях; співвідношення сумарного часу становить 2,38. Це час завершення завдань, на який впливають середовище та довжина відповідей, а не окреме вимірювання швидкості генерації токенів. Три завдання без повторень не показують коливань затримки чи поведінки під час тривалих сесій.</p>
<h2>Що означає різниця у вартості в 45 разів</h2>
<p>Окремі суми Mercury дають 0,00245 USD, після округлення 0,0025 USD. Claude коштував 0,1122 USD: приблизно в 45 разів більше за округлений підсумок або в 45,8 раза більше за суму позицій. Запис відносить близько 0,055 USD до першого запису в кеш запиту. Після віднімання залишається 0,0572 USD, приблизно у 23 рази більше за неокруглений підсумок Mercury.</p>
<p>Це лише орієнтовний розрахунок. Без повного розподілу вхідних даних, записів і читань кешу неможливо відтворити рівнозначні рахунки для холодного та прогрітого кешу. Суми описують цей запуск, а не універсальний тариф. В абсолютному вимірі обидві витрати невеликі.</p>
<h2>Токени не вимірюють глибину міркування</h2>
<p>Mercury повідомив більше токенів міркування у клінічному завданні та коді, Claude у редагуванні. Видимі відповіді Claude були довшими в усіх трьох випадках. Різні токенізатори та лічильники не вимірюють безпосередньо інтелектуальне зусилля. Із чисел 3 013 та 1 173 не випливає, яка модель міркувала краще.</p>
<h2>Якість визначає перевірка відповіді</h2>
<p>За первинною оцінкою, обидві моделі виявили ключове протипоказання до дабігатрану: європейська характеристика препарату Pradaxa вказує для дорослих CrCl нижче 30 мл/хв. CrCl оцінюють за формулою Кокрофта-Голта. Його не можна просто замінити розрахунковою ШКФ за CKD-EPI, індексованою на 1,73 м². Докладна відповідь також має правильно розрізняти європейські та американські умови застосування.</p>
<p>Окремий приклад можна перевірити незалежно: жінка віком 60 років із креатиніном 80 мкмоль/л за креатиніновою формулою CKD-EPI 2021 має приблизно 72,704 мл/хв/1,73 м². Наведені 72,7 правильні. Проте один правильний розрахунок не перевіряє всю реалізацію, перерахунок одиниць, граничні випадки чи валідацію введення. Без повних відповідей і виконуваного коду позитивна оцінка залишається оцінкою автора початкового порівняння.</p>
<p>За записом, Mercury відредагував словацький текст стисло й без коментаря. Claude додав зауваження про відновлення діакритики. У суто редакційному завданні це може заважати. За невизначеності клінічних даних пояснення цієї невизначеності може бути необхідним.</p>
<h2>Наступного разу виміряти й час перевірки</h2>
<p>Наступне порівняння має зберегти точні запити, ідентифікатори моделей, налаштування зусилля та ліміти токенів, чергувати порядок викликів у повторних запусках і відокремити холодний кеш від прогрітого. До часу відповіді я додав би час перевірки й виправлень. Оцінювати слід за наперед визначеними критеріями, бажано без назв моделей.</p>
<p>У цих трьох завданнях Mercury відповів швидше та з нижчою заявленою вартістю. Це корисний початок вибору інструмента. Подальше використання залежить від того, скільки перевіреної роботи після нього завершено.</p>
<p><em>Особисте орієнтовне порівняння одного запуску. Клінічні приклади оцінюють відповіді AI, а не визначають лікування конкретного пацієнта.</em></p>
HTML,
    ],
];

$sources = <<<'HTML'
<p><small><em>Ľubomír Polaščín: OpenCode, Mercury 3 / Claude Sonnet 5.5, T1 / T2 / T3. <a href="https://www.inceptionlabs.ai/blog/introducing-mercury-3">Inception Team: Diffusion at Scale: Introducing Mercury 3</a>. <a href="https://www.anthropic.com/claude-sonnet-5-5">Anthropic: Introducing Claude Sonnet 5.5</a>. <a href="https://www.ema.europa.eu/en/documents/product-information/pradaxa-epar-product-information_en.pdf">European Medicines Agency: Pradaxa, product information</a>. <a href="https://www.niddk.nih.gov/research-funding/research-programs/kidney-clinical-research-epidemiology/laboratory/glomerular-filtration-rate-equations/adults">NIDDK: eGFR Equations for Adults, 2021 CKD-EPI Creatinine Equation</a>.</em></small></p>
HTML;

foreach ($translations as &$translation) {
    [$task, $seconds, $cost, $tokens, $t1, $t2, $t3, $total, $caption] = $translation['labels'];
    $tables = '<table><caption>' . $caption . '</caption><thead><tr><th>' . $task
        . '</th><th>Mercury 3: ' . $seconds . '</th><th>Claude Sonnet 5.5: ' . $seconds . '</th></tr></thead><tbody>';
    foreach ([[$t1, '4.6', '9.1'], [$t2, '10.6', '24.2'], [$t3, '4.5', '13.6'], [$total, '19.7', '46.9']] as $row) {
        $tables .= '<tr><th>' . $row[0] . '</th><td>' . $row[1] . '</td><td>' . $row[2] . '</td></tr>';
    }
    $tables .= '</tbody></table><table><caption>' . $cost . '</caption><thead><tr><th>' . $task
        . '</th><th>Mercury 3</th><th>Claude Sonnet 5.5</th></tr></thead><tbody>';
    foreach ([[$t1, '0.00033', '0.0620'], [$t2, '0.00147', '0.0302'], [$t3, '0.00065', '0.0200'], [$total, '0.00245', '0.1122']] as $row) {
        $tables .= '<tr><th>' . $row[0] . '</th><td>' . $row[1] . '</td><td>' . $row[2] . '</td></tr>';
    }
    $tables .= '</tbody></table><table><caption>' . $tokens . '</caption><thead><tr><th>' . $task
        . '</th><th>Mercury 3</th><th>Claude Sonnet 5.5</th></tr></thead><tbody>';
    foreach ([[$t1, '100 + 346', '230 + 510'], [$t2, '680 + 3013', '1556 + 1173'], [$t3, '536 + 895', '922 + 789']] as $row) {
        $tables .= '<tr><th>' . $row[0] . '</th><td>' . $row[1] . '</td><td>' . $row[2] . '</td></tr>';
    }
    $translation['content'] = $translation['intro'] . $tables . $translation['body'] . $sources;
    unset($translation['intro'], $translation['body'], $translation['labels']);
}
unset($translation);

return [
    'slug' => 'mercury-claude-tri-ulohy-jeden-beh',
    'author' => 'MUDr. Ľubomír Polaščín',
    'category' => 'blog',
    'is_top' => 0,
    'published_at' => '2026-10-26 20:30:00',
    'image' => 'images/articles/mercury-claude-tri-ulohy-jeden-beh.webp',
    'translations' => $translations,
];
