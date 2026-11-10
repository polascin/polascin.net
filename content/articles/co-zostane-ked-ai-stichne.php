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

/** Educational essay; primary sources checked 2026-11-10. Fictional teaching example. */
return [
    'slug' => 'co-zostane-ked-ai-stichne',
    'author' => 'MUDr. Ľubomír Polaščín',
    'category' => 'blog',
    'published_at' => '2026-11-10 03:35:44',
    'image' => 'images/articles/co-zostane-ked-ai-stichne.webp',
    'is_top' => 0,
    'translations' => [
        'sk' => [
            'title' => 'Čo zostane, keď AI stíchne: skúška medicínskeho vzdelávania',
            'image_alt' => 'Otvorený zápisník so stetoskopom pred tabletom s anonymnou postavou virtuálneho pacienta v tyrkysovom svetle na fialovom pozadí.',
            'excerpt' => 'Virtuálny pacient môže počkať, kým študent nájde správne slová. Skutočný pacient potrebuje človeka, ktorý im aj rozumie. Výskum ukazuje nádejné možnosti AI vo výučbe, ale aj dôvod skúšať vedomosti po vypnutí obrazovky.',
            'content' => <<<'HTML'
<p>Študent zavrie rozhovor s umelou inteligenciou a zrazu musí povedať vlastnými slovami, prečo sa rozhodol práve takto. Bez nápovedy, bez ďalšieho pokusu o lepšie zadanie. V tej chvíli sa začína skutočná skúška výučby: čo z rozhovoru zostalo v jeho hlave?</p>
<p>Predstavme si fiktívnu študentku Ninu a fiktívneho pána Horského. Má sa s ním porozprávať o obavách z liečby ochorenia obličiek. Virtuálny pacient jej dovolí zastaviť sa, skúsiť inú vetu a rozobrať chybu s učiteľom. Je to bezpečný priestor na nácvik. Jeho prínos sa však ukáže až pri ďalšom rozhovore, keď Nina dokáže počúvať aj bez našepkávača. Tento príklad nie je záznamom skutočného pacienta ani udalosti.</p>
<h2>Tutor, ktorý sa nepodvolí prvej odpovedi</h2>
<p><a href="https://mededu.jmir.org/2026/1/e102908/">Pilotná randomizovaná štúdia so 44 študentmi patológie</a>, publikovaná 6. novembra 2026, priniesla zaujímavý výsledok. Tutor naviazaný na učivo a vedený sokratovskými otázkami zlepšil hodnotenie prípravy aj výkon v skupinovej diskusii. Presvedčivý rozdiel v neskoršom zapamätaní učiva sa však nepreukázal. Navyše sa pracovalo iba s dvoma kazuistikami na jednej škole.</p>
<p>Pre pedagóga je to dobrá stopa. Namiesto otázky „Čo je správne?“ môže tutor žiadať: „Ktorý údaj by tvoje vysvetlenie spochybnil?“ Študent musí ukázať cestu k záveru. Plynulý odsek sa totiž dá prevziať za sekundu, klinické uvažovanie treba vybudovať.</p>
<h2>Rozhovor sa dá nacvičiť, vzťah nemožno sľúbiť</h2>
<p><a href="https://mededu.jmir.org/2026/1/e93034/">Randomizovaná štúdia virtuálneho pacienta s 51 účastníkmi</a> ukázala väčšie bezprostredné zlepšenie komunikácie o závažnom ochorení než čítanie výučbových materiálov. Hodnotenie zahŕňalo rozhovory so štandardizovanými pacientmi a zaslepených hodnotiteľov. To je užitočnejšie než samotný pocit účastníka, že sa mu nástroj páčil. Stále však ide o krátkodobý výsledok, nie o dôkaz lepšej starostlivosti o pacientov.</p>
<p>Protiváhu ponúka <a href="https://www.jmir.org/2026/1/e91886/">ďalšia randomizovaná štúdia s 50 študentmi</a>. Počas akademického roka sa komunikácia zlepšovala, ale doplnkový tréning s AI v posledných troch mesiacoch nepriniesol štatisticky významný náskok oproti bežnej výučbe. Záver nehovorí, že simulácia nemá cenu. Hovorí, že ďalšia obrazovka sama osebe lepšieho lekára nezaručí.</p>
<h2>Malé učebné laboratórium namiesto veľkého sľubu</h2>
<p>Navrhujem začať jednou odborne skontrolovanou kazuistikou a postupom „najprv sám, potom s tutorom, nakoniec znovu sám“. Študent najprv zapíše vlastný úsudok. AI potom dostane schválené podklady a smie klásť odstupňované otázky. Po rozhovore učiteľ so študentom rozoberie rozhodnutia aj chyby. S odstupom nasleduje nový prípad bez pomoci AI.</p>
<p>Pridal by som aj skúšku odolnosti voči presvedčivej chybe. Učiteľ do jasne označeného tréningového zadania vloží vierohodné, ale nesprávne vysvetlenie. Úlohou študenta je nájsť rozpor, overiť zdroj a vysvetliť opravu. Takéto cvičenie je návrh na miestne overenie, nie už dokázaná vzdelávacia metóda. Hodnotil by som správnosť, zdôvodnenie a rozpoznanie neistoty, nie rýchlosť písania.</p>
<p>Do simulácie patria výlučne vymyslené údaje, nie skopírovaná zdravotná dokumentácia. Scenár aj jeho verziu treba uchovať a odpovede kontrolovať odborníkom. Ani anonymne znejúce meno neochráni človeka, ak ho prezradí súbeh zriedkavej diagnózy, dátumu a pracoviska.</p>
<p><a href="https://pubmed.ncbi.nlm.nih.gov/42085678/">Metaanalýza 66 randomizovaných štúdií so 4 911 účastníkmi</a> síce našla priaznivé výsledky v niektorých oblastiach učenia, istota dôkazov však bola nízka až veľmi nízka. Spokojnosť a sebadôvera preto nemôžu zastúpiť samostatný výkon. Počet otázok v komerčnom katalógu tiež nie je mierou toho, čo si študent osvojil.</p>
<p>Najlepší tutor nemusí odpovedať najrýchlejšie. Má študenta pripraviť na chvíľu, keď už odpovedá sám a oproti nemu sedí človek.</p>
<p><em>Esej o vzdelávaní vychádza z podkladov k 9. novembru 2026, odkazy boli overené 10. novembra 2026. Nejde o návod na liečbu. Mená v modelovom príklade sú fiktívne; výskumné výsledky odkazujú na pôvodné publikácie.</em></p>

HTML,
        ],
        'en' => [
            'title' => 'What remains when AI falls silent: a test for medical education',
            'image_alt' => 'An open notebook and stethoscope before a tablet showing an anonymous virtual patient in teal light against a violet background.',
            'excerpt' => 'A virtual patient can wait while a student finds the right words. A real patient needs someone who understands them. Research offers promising uses for AI in teaching, and a reason to assess learning after the screen goes dark.',
            'content' => <<<'HTML'
<p>A student closes an AI conversation and suddenly has to explain, in their own words, why they made that decision. No hints, no second attempt at a better prompt. This is where the real test of teaching begins: what has stayed in the student's mind?</p>
<p>Imagine a fictional student, Nina, and a fictional patient, Mr Horský. She needs to discuss his worries about treatment for kidney disease. A virtual patient lets her pause, try another sentence and examine a mistake with her teacher. It is a safe place to practise. Its value emerges in the next conversation, when Nina can listen without someone feeding her lines. This example describes no real patient or event.</p>
<h2>A tutor that challenges the first answer</h2>
<p>A <a href="https://mededu.jmir.org/2026/1/e102908/">randomized pilot study of 44 pathology students</a>, published on 6 November 2026, offers an interesting finding. A tutor aligned with the curriculum and guided by Socratic questions improved preparation assessments and small-group discussion performance. A convincing advantage in delayed retention was not demonstrated. The study covered just two cases at one institution.</p>
<p>This gives educators a useful lead. Instead of asking what is correct, the tutor can ask which finding would undermine the student's explanation. The student must reveal the route to the conclusion. A fluent paragraph takes a second to copy; clinical reasoning has to be built.</p>
<h2>Conversation can be rehearsed; a relationship cannot be promised</h2>
<p>A <a href="https://mededu.jmir.org/2026/1/e93034/">randomized virtual-patient study with 51 participants</a> found greater immediate improvement in serious illness communication than reading educational materials. Assessment included encounters with standardized patients and blinded raters. That is more informative than participants simply enjoying a tool. It remains a short-term finding, rather than evidence of better patient care.</p>
<p>A <a href="https://www.jmir.org/2026/1/e91886/">second randomized study with 50 students</a> provides a counterweight. Communication improved across the academic year, but additional AI practice during the final three months produced no statistically significant advantage over standard teaching. This does not establish that simulation is worthless. It shows that an extra screen alone cannot guarantee a better doctor.</p>
<h2>A small learning laboratory</h2>
<p>I would start with one expert-reviewed case and a sequence: alone first, then with the tutor, then alone again. Students record their own reasoning. AI receives approved materials and may ask graduated questions. Teacher and student then examine decisions and errors together. A new case follows after a delay, without AI assistance.</p>
<p>I would also test resistance to a persuasive error. A teacher places a plausible but incorrect explanation in a clearly identified training exercise. The student must identify the contradiction, check the source and explain the correction. This is a proposal requiring local evaluation, not an established educational intervention. I would assess accuracy, justification and recognition of uncertainty, rather than typing speed.</p>
<p>Simulations should use entirely invented details, never copied medical records. Preserve each scenario and its version, and have an expert check the answers. An anonymous-sounding name cannot protect someone identified by a rare diagnosis combined with a date and institution.</p>
<p>A <a href="https://pubmed.ncbi.nlm.nih.gov/42085678/">meta-analysis of 66 randomized trials with 4,911 participants</a> found favorable results in some learning domains, but certainty was low to very low. Satisfaction and confidence therefore cannot substitute for independent performance. The number of questions in a commercial catalogue is no measure of what a student has learned.</p>
<p>The best tutor need not answer fastest. It should prepare students for the moment when they answer on their own, facing another person.</p>
<p><em>This educational essay draws on material current to 9 November 2026; links were checked on 10 November 2026. It is not treatment guidance. The illustrative names are fictional; research findings link to the original publications.</em></p>

HTML,
        ],
        'cs' => [
            'title' => 'Co zůstane, když AI ztichne: zkouška medicínského vzdělávání',
            'image_alt' => 'Otevřený zápisník se stetoskopem před tabletem s anonymní postavou virtuálního pacienta v tyrkysovém světle na fialovém pozadí.',
            'excerpt' => 'Virtuální pacient může počkat, než student najde správná slova. Skutečný pacient potřebuje člověka, který jim také rozumí. Výzkum ukazuje nadějné možnosti AI ve výuce, ale i důvod zkoušet znalosti po vypnutí obrazovky.',
            'content' => <<<'HTML'
<p>Student zavře rozhovor s umělou inteligencí a najednou musí vlastními slovy vysvětlit, proč se rozhodl právě takto. Bez nápovědy, bez dalšího pokusu o lepší zadání. V tu chvíli začíná skutečná zkouška výuky: co mu z rozhovoru zůstalo v hlavě?</p>
<p>Představme si fiktivní studentku Ninu a fiktivního pana Horského. Má s ním probrat obavy z léčby onemocnění ledvin. Virtuální pacient jí dovolí zastavit se, zkusit jinou větu a rozebrat chybu s učitelem. Je to bezpečný prostor k nácviku. Jeho přínos se však ukáže až při dalším rozhovoru, kdy Nina dokáže naslouchat bez našeptávače. Tento příklad nepopisuje skutečného pacienta ani událost.</p>
<h2>Tutor, který zpochybní první odpověď</h2>
<p><a href="https://mededu.jmir.org/2026/1/e102908/">Pilotní randomizovaná studie se 44 studenty patologie</a>, zveřejněná 6. listopadu 2026, přinesla zajímavý výsledek. Tutor navázaný na učivo a vedený sokratovskými otázkami zlepšil hodnocení přípravy i výkon ve skupinové diskusi. Přesvědčivý rozdíl v pozdějším zapamatování učiva se však neprokázal. Studie navíc zahrnovala pouze dvě kazuistiky na jedné škole.</p>
<p>Pro pedagoga je to dobrá stopa. Místo otázky, co je správně, může tutor žádat údaj, který by studentovo vysvětlení zpochybnil. Student musí ukázat cestu k závěru. Plynulý odstavec lze převzít za sekundu, klinické uvažování je třeba vybudovat.</p>
<h2>Rozhovor lze nacvičit, vztah nelze slíbit</h2>
<p><a href="https://mededu.jmir.org/2026/1/e93034/">Randomizovaná studie virtuálního pacienta s 51 účastníky</a> ukázala větší bezprostřední zlepšení komunikace o závažném onemocnění než četba výukových materiálů. Hodnocení zahrnovalo rozhovory se standardizovanými pacienty a zaslepené hodnotitele. To vypovídá více než pouhý pocit účastníka, že se mu nástroj líbil. Stále však jde o krátkodobý výsledek, nikoli důkaz lepší péče o pacienty.</p>
<p>Protiváhu nabízí <a href="https://www.jmir.org/2026/1/e91886/">další randomizovaná studie s 50 studenty</a>. Během akademického roku se komunikace zlepšovala, ale doplňkový trénink s AI v posledních třech měsících nepřinesl statisticky významný náskok oproti běžné výuce. Výsledek neříká, že simulace nemá cenu. Ukazuje, že další obrazovka sama lepšího lékaře nezaručí.</p>
<h2>Malá výuková laboratoř</h2>
<p>Navrhuji začít jednou odborně zkontrolovanou kazuistikou a postupem „nejprve sám, potom s tutorem, nakonec znovu sám“. Student nejdříve zapíše vlastní úsudek. AI dostane schválené podklady a smí klást odstupňované otázky. Učitel se studentem poté rozebere rozhodnutí i chyby. S odstupem následuje nový případ bez pomoci AI.</p>
<p>Přidal bych zkoušku odolnosti vůči přesvědčivé chybě. Učitel vloží do jasně označeného cvičného zadání věrohodné, ale nesprávné vysvětlení. Student má najít rozpor, ověřit zdroj a vysvětlit opravu. Jde o návrh k místnímu ověření, nikoli již prokázanou vzdělávací metodu. Hodnotil bych správnost, zdůvodnění a rozpoznání nejistoty, ne rychlost psaní.</p>
<p>Do simulace patří výhradně smyšlené údaje, nikoli zkopírovaná zdravotnická dokumentace. Scénář i jeho verzi je třeba uchovat a odpovědi nechat odborně zkontrolovat. Ani anonymně znějící jméno člověka neochrání, pokud ho prozradí spojení vzácné diagnózy, data a pracoviště.</p>
<p><a href="https://pubmed.ncbi.nlm.nih.gov/42085678/">Metaanalýza 66 randomizovaných studií se 4 911 účastníky</a> nalezla příznivé výsledky v některých oblastech učení, jistota důkazů však byla nízká až velmi nízká. Spokojenost a sebedůvěra proto nemohou zastoupit samostatný výkon. Ani počet otázek v komerčním katalogu neměří, co si student osvojil.</p>
<p>Nejlepší tutor nemusí odpovídat nejrychleji. Má studenta připravit na chvíli, kdy už odpovídá sám a naproti němu sedí člověk.</p>
<p><em>Esej o vzdělávání vychází z podkladů k 9. listopadu 2026, odkazy byly ověřeny 10. listopadu 2026. Nejde o návod k léčbě. Jména v modelovém příkladu jsou fiktivní; výzkumné výsledky odkazují na původní publikace.</em></p>

HTML,
        ],
        'de' => [
            'title' => 'Was bleibt, wenn die KI verstummt: eine Prüfung für die medizinische Lehre',
            'image_alt' => 'Ein offenes Notizbuch mit Stethoskop vor einem Tablet mit einer anonymen virtuellen Patientenfigur, türkis beleuchtet vor violettem Hintergrund.',
            'excerpt' => 'Ein virtueller Patient kann warten, bis Studierende die richtigen Worte finden. Ein echter Patient braucht jemanden, der sie auch versteht. Die Forschung zeigt Chancen für KI in der Lehre und Gründe, Wissen bei ausgeschaltetem Bildschirm zu prüfen.',
            'content' => <<<'HTML'
<p>Ein Student schließt den Dialog mit der künstlichen Intelligenz und muss plötzlich mit eigenen Worten erklären, warum er so entschieden hat. Ohne Hinweise, ohne einen weiteren Versuch mit einer besseren Eingabe. Hier beginnt die eigentliche Prüfung der Lehre: Was ist im Kopf geblieben?</p>
<p>Stellen wir uns die fiktive Studentin Nina und den fiktiven Herrn Horský vor. Sie soll mit ihm über seine Sorgen zur Behandlung einer Nierenerkrankung sprechen. Ein virtueller Patient erlaubt ihr, innezuhalten, einen anderen Satz auszuprobieren und Fehler mit einer Lehrperson zu besprechen. Das schafft einen geschützten Übungsraum. Sein Nutzen zeigt sich aber erst im nächsten Gespräch, wenn Nina ohne Souffleur zuhören kann. Dieses Beispiel beschreibt weder einen wirklichen Patienten noch ein tatsächliches Ereignis.</p>
<h2>Ein Tutor, der die erste Antwort hinterfragt</h2>
<p>Eine am 6. November 2026 veröffentlichte <a href="https://mededu.jmir.org/2026/1/e102908/">randomisierte Pilotstudie mit 44 Pathologiestudierenden</a> liefert einen interessanten Befund. Ein auf das Curriculum abgestimmter Tutor mit sokratischen Fragen verbesserte die Bewertung der Vorbereitung und die Leistung in Kleingruppendiskussionen. Ein überzeugender Vorteil beim späteren Behalten ließ sich jedoch nicht nachweisen. Untersucht wurden lediglich zwei Fälle an einer Hochschule.</p>
<p>Das ist ein brauchbarer Ansatz für Lehrende. Statt nach der richtigen Antwort zu fragen, kann der Tutor einen Befund verlangen, der die Erklärung infrage stellen würde. Studierende müssen ihren Weg zum Schluss offenlegen. Ein flüssiger Absatz ist schnell kopiert; klinisches Denken muss entstehen.</p>
<h2>Gespräche lassen sich üben, Beziehungen nicht versprechen</h2>
<p>Eine <a href="https://mededu.jmir.org/2026/1/e93034/">randomisierte Studie mit einem virtuellen Patienten und 51 Teilnehmenden</a> zeigte unmittelbar größere Verbesserungen bei Gesprächen über schwere Erkrankungen als das Lesen von Lehrmaterial. Die Beurteilung umfasste Gespräche mit standardisierten Patienten und verblindete Bewertende. Das sagt mehr aus als bloßes Gefallen am Werkzeug. Es bleibt ein kurzfristiges Ergebnis und kein Beleg für bessere Patientenversorgung.</p>
<p>Ein Gegengewicht bietet eine <a href="https://www.jmir.org/2026/1/e91886/">weitere randomisierte Studie mit 50 Studierenden</a>. Die Kommunikation verbesserte sich im Studienjahr, doch zusätzliches KI-Training in den letzten drei Monaten brachte keinen statistisch signifikanten Vorsprung gegenüber der üblichen Lehre. Das macht Simulation nicht wertlos. Es zeigt, dass ein weiterer Bildschirm allein keinen besseren Arzt garantiert.</p>
<h2>Ein kleines Lernlabor</h2>
<p>Ich würde mit einem fachlich geprüften Fall beginnen: zuerst allein, dann mit dem Tutor, schließlich wieder allein. Studierende halten zunächst ihr eigenes Urteil fest. Die KI erhält freigegebene Unterlagen und darf abgestufte Fragen stellen. Anschließend besprechen Lehrperson und Studierende Entscheidungen und Fehler. Nach einiger Zeit folgt ein neuer Fall ohne KI-Hilfe.</p>
<p>Hinzu käme eine Prüfung der Widerstandsfähigkeit gegen überzeugende Fehler. Eine Lehrperson fügt in eine klar gekennzeichnete Übung eine plausible, aber falsche Erklärung ein. Studierende sollen den Widerspruch entdecken, die Quelle prüfen und die Korrektur begründen. Das ist ein Vorschlag zur lokalen Erprobung, keine bereits nachgewiesene Lehrmethode. Bewertet würden Richtigkeit, Begründung und das Erkennen von Unsicherheit statt Tippgeschwindigkeit.</p>
<p>In die Simulation gehören ausschließlich erfundene Angaben, keine kopierten Krankenakten. Szenario und Versionsstand müssen erhalten bleiben, Antworten fachlich geprüft werden. Ein anonym klingender Name schützt niemanden, wenn eine seltene Diagnose zusammen mit Datum und Einrichtung die Person erkennbar macht.</p>
<p>Eine <a href="https://pubmed.ncbi.nlm.nih.gov/42085678/">Metaanalyse von 66 randomisierten Studien mit 4.911 Teilnehmenden</a> fand günstige Ergebnisse in einigen Lernbereichen, die Evidenzsicherheit war jedoch niedrig bis sehr niedrig. Zufriedenheit und Selbstvertrauen ersetzen daher keine eigenständige Leistung. Auch die Zahl der Fragen in einem kommerziellen Katalog misst nicht, was jemand gelernt hat.</p>
<p>Der beste Tutor muss nicht am schnellsten antworten. Er sollte auf den Moment vorbereiten, in dem Studierende selbst antworten und ihnen ein Mensch gegenübersitzt.</p>
<p><em>Dieser Essay zur Lehre beruht auf Unterlagen mit Stand vom 9. November 2026; die Links wurden am 10. November 2026 geprüft. Er ist keine Behandlungsanleitung. Die Namen im Beispiel sind fiktiv; Forschungsergebnisse verweisen auf die Originalpublikationen.</em></p>

HTML,
        ],
        'fr' => [
            'title' => 'Ce qui reste quand l’IA se tait : une épreuve pour la formation médicale',
            'image_alt' => 'Un carnet ouvert et un stéthoscope devant une tablette montrant un patient virtuel anonyme, éclairés de turquoise sur fond violet.',
            'excerpt' => 'Un patient virtuel peut attendre que l’étudiant trouve les mots justes. Un vrai patient a besoin de quelqu’un qui les comprenne. La recherche révèle des usages prometteurs de l’IA et des raisons d’évaluer les acquis une fois l’écran éteint.',
            'content' => <<<'HTML'
<p>Un étudiant ferme sa conversation avec l’intelligence artificielle et doit soudain expliquer, avec ses propres mots, pourquoi il a pris cette décision. Sans indice, sans nouvelle tentative pour mieux formuler sa demande. C’est là que commence la véritable épreuve de l’enseignement : que lui reste-t-il en tête ?</p>
<p>Imaginons Nina, une étudiante fictive, et M. Horský, un patient fictif. Elle doit parler avec lui de ses inquiétudes concernant le traitement d’une maladie rénale. Le patient virtuel lui permet de s’arrêter, d’essayer une autre phrase et d’analyser une erreur avec son enseignant. C’est un espace d’entraînement protégé. Son intérêt apparaît lors de l’entretien suivant, lorsque Nina sait écouter sans qu’on lui souffle ses répliques. Cet exemple ne décrit aucun patient ni événement réel.</p>
<h2>Un tuteur qui interroge la première réponse</h2>
<p>Une <a href="https://mededu.jmir.org/2026/1/e102908/">étude pilote randomisée menée auprès de 44 étudiants en pathologie</a>, publiée le 6 novembre 2026, apporte un résultat intéressant. Un tuteur adapté au programme et guidé par des questions socratiques a amélioré l’évaluation de la préparation et les performances en discussion de groupe. Aucun avantage convaincant concernant la mémorisation différée n’a toutefois été démontré. L’étude ne portait que sur deux cas dans un seul établissement.</p>
<p>C’est une piste utile pour les enseignants. Plutôt que de demander la bonne réponse, le tuteur peut demander quel élément remettrait l’explication en cause. L’étudiant doit exposer le cheminement de son raisonnement. Un paragraphe fluide se copie en une seconde ; le raisonnement clinique se construit.</p>
<h2>On peut répéter un entretien, pas promettre une relation</h2>
<p>Une <a href="https://mededu.jmir.org/2026/1/e93034/">étude randomisée sur un patient virtuel, avec 51 participants</a>, a montré une amélioration immédiate plus importante de la communication sur les maladies graves que la lecture de supports pédagogiques. L’évaluation comprenait des entretiens avec des patients standardisés et des évaluateurs en aveugle. C’est plus instructif que la simple satisfaction des utilisateurs. Cela reste un résultat à court terme, pas une preuve d’amélioration des soins.</p>
<p>Une <a href="https://www.jmir.org/2026/1/e91886/">autre étude randomisée, avec 50 étudiants</a>, apporte un contrepoint. La communication s’améliorait au cours de l’année universitaire, mais l’entraînement supplémentaire avec l’IA durant les trois derniers mois n’a pas produit d’avantage statistiquement significatif sur l’enseignement habituel. Cela ne rend pas la simulation inutile. Un écran supplémentaire ne garantit simplement pas un meilleur médecin.</p>
<h2>Un petit laboratoire pédagogique</h2>
<p>Je commencerais par un cas vérifié par un expert et la séquence suivante : seul, puis avec le tuteur, puis seul à nouveau. L’étudiant consigne d’abord son propre raisonnement. L’IA reçoit des documents validés et pose des questions graduées. Enseignant et étudiant analysent ensuite décisions et erreurs. Après un délai, un nouveau cas est proposé sans aide de l’IA.</p>
<p>J’ajouterais une épreuve de résistance à une erreur persuasive. L’enseignant insère une explication plausible mais fausse dans un exercice clairement présenté comme tel. L’étudiant doit trouver la contradiction, vérifier la source et expliquer la correction. C’est une proposition à évaluer localement, pas une méthode pédagogique déjà démontrée. Je noterais l’exactitude, la justification et la reconnaissance de l’incertitude plutôt que la vitesse de frappe.</p>
<p>La simulation doit employer exclusivement des données inventées, jamais des dossiers médicaux copiés. Il faut conserver le scénario et sa version, et faire vérifier les réponses par un expert. Un nom d’apparence anonyme ne protège personne si une maladie rare, une date et un établissement permettent l’identification.</p>
<p>Une <a href="https://pubmed.ncbi.nlm.nih.gov/42085678/">méta-analyse de 66 essais randomisés regroupant 4 911 participants</a> a relevé des résultats favorables dans certains domaines d’apprentissage, mais avec un niveau de certitude faible à très faible. Satisfaction et confiance ne remplacent donc pas une performance autonome. Le nombre de questions d’un catalogue commercial ne mesure pas non plus ce que l’étudiant a appris.</p>
<p>Le meilleur tuteur n’est pas forcément celui qui répond le plus vite. Il doit préparer l’étudiant au moment où il répondra seul, face à une personne.</p>
<p><em>Cet essai sur la formation s’appuie sur des éléments arrêtés au 9 novembre 2026 ; les liens ont été vérifiés le 10 novembre 2026. Il ne constitue pas un guide de traitement. Les noms de l’exemple sont fictifs ; les résultats renvoient aux publications originales.</em></p>

HTML,
        ],
        'es' => [
            'title' => 'Lo que queda cuando la IA calla: una prueba para la educación médica',
            'image_alt' => 'Un cuaderno abierto y un estetoscopio ante una tableta con un paciente virtual anónimo, iluminados en turquesa sobre fondo violeta.',
            'excerpt' => 'Un paciente virtual puede esperar a que el estudiante encuentre las palabras adecuadas. Un paciente real necesita a alguien que las comprenda. La investigación ofrece usos prometedores de la IA y motivos para evaluar lo aprendido con la pantalla apagada.',
            'content' => <<<'HTML'
<p>Un estudiante cierra su conversación con la inteligencia artificial y de pronto debe explicar con sus propias palabras por qué tomó esa decisión. Sin pistas, sin otro intento de mejorar la petición. Ahí comienza la verdadera prueba de la enseñanza: ¿qué ha quedado en su cabeza?</p>
<p>Imaginemos a Nina, una estudiante ficticia, y al señor Horský, un paciente ficticio. Debe conversar con él sobre sus temores ante el tratamiento de una enfermedad renal. El paciente virtual le permite detenerse, probar otra frase y analizar un error con su docente. Es un espacio seguro para practicar. Su valor aparece en la siguiente conversación, cuando Nina sabe escuchar sin que nadie le dicte las palabras. El ejemplo no describe a ningún paciente ni suceso real.</p>
<h2>Un tutor que cuestiona la primera respuesta</h2>
<p>Un <a href="https://mededu.jmir.org/2026/1/e102908/">estudio piloto aleatorizado con 44 estudiantes de patología</a>, publicado el 6 de noviembre de 2026, aporta un resultado interesante. Un tutor ajustado al programa y guiado por preguntas socráticas mejoró las evaluaciones de la preparación y el desempeño en debates de grupo. No se demostró una ventaja convincente en la retención posterior. Además, solo se estudiaron dos casos en una institución.</p>
<p>Es una pista útil para los docentes. En lugar de pedir la respuesta correcta, el tutor puede preguntar qué dato pondría en duda la explicación. El estudiante debe mostrar el camino hasta su conclusión. Un párrafo fluido se copia en un segundo; el razonamiento clínico se construye.</p>
<h2>La conversación se ensaya; la relación no se promete</h2>
<p>Un <a href="https://mededu.jmir.org/2026/1/e93034/">estudio aleatorizado de un paciente virtual con 51 participantes</a> encontró una mayor mejora inmediata en la comunicación sobre enfermedades graves que la lectura de materiales educativos. La evaluación incluyó entrevistas con pacientes estandarizados y evaluadores cegados. Esto informa más que la simple satisfacción con una herramienta. Sigue siendo un resultado a corto plazo, no una prueba de mejor atención a los pacientes.</p>
<p>Otro <a href="https://www.jmir.org/2026/1/e91886/">estudio aleatorizado con 50 estudiantes</a> ofrece un contrapeso. La comunicación mejoró durante el curso académico, pero la práctica adicional con IA en los últimos tres meses no aportó una ventaja estadísticamente significativa frente a la enseñanza habitual. Esto no demuestra que la simulación carezca de valor. Indica que otra pantalla, por sí sola, no garantiza un médico mejor.</p>
<h2>Un pequeño laboratorio de aprendizaje</h2>
<p>Empezaría por un caso revisado por un experto y esta secuencia: primero solo, después con el tutor y finalmente solo de nuevo. El estudiante registra su razonamiento inicial. La IA recibe materiales aprobados y puede plantear preguntas graduadas. Después, docente y estudiante analizan decisiones y errores. Tras un intervalo, llega un caso nuevo sin ayuda de la IA.</p>
<p>Añadiría una prueba de resistencia frente a un error convincente. El docente introduce una explicación verosímil pero incorrecta en un ejercicio identificado claramente como tal. El estudiante debe detectar la contradicción, comprobar la fuente y explicar la corrección. Es una propuesta que requiere evaluación local, no un método educativo ya demostrado. Evaluaría exactitud, justificación y reconocimiento de la incertidumbre, no velocidad al escribir.</p>
<p>La simulación debe usar datos completamente inventados, nunca historias clínicas copiadas. Hay que conservar el escenario y su versión, y someter las respuestas a revisión experta. Un nombre aparentemente anónimo no protege a nadie si una enfermedad rara, una fecha y un centro permiten identificarlo.</p>
<p>Un <a href="https://pubmed.ncbi.nlm.nih.gov/42085678/">metaanálisis de 66 ensayos aleatorizados con 4.911 participantes</a> encontró resultados favorables en algunas áreas del aprendizaje, pero la certeza de la evidencia fue baja o muy baja. La satisfacción y la confianza no sustituyen el desempeño autónomo. Tampoco el número de preguntas de un catálogo comercial mide lo aprendido.</p>
<p>El mejor tutor no tiene por qué responder más rápido. Debe preparar al estudiante para el momento en que responda solo y tenga delante a una persona.</p>
<p><em>Este ensayo educativo parte de materiales disponibles hasta el 9 de noviembre de 2026; los enlaces se verificaron el 10 de noviembre de 2026. No es una guía de tratamiento. Los nombres del ejemplo son ficticios; los resultados remiten a las publicaciones originales.</em></p>

HTML,
        ],
        'pl' => [
            'title' => 'Co zostaje, gdy AI milknie: sprawdzian edukacji medycznej',
            'image_alt' => 'Otwarty notatnik i stetoskop przed tabletem z anonimową postacią wirtualnego pacjenta, w turkusowym świetle na fioletowym tle.',
            'excerpt' => 'Wirtualny pacjent może poczekać, aż student znajdzie właściwe słowa. Prawdziwy pacjent potrzebuje kogoś, kto je rozumie. Badania pokazują obiecujące zastosowania AI i powody, by sprawdzać wiedzę po wyłączeniu ekranu.',
            'content' => <<<'HTML'
<p>Student zamyka rozmowę ze sztuczną inteligencją i nagle musi własnymi słowami wyjaśnić, dlaczego podjął taką decyzję. Bez podpowiedzi, bez kolejnej próby lepszego sformułowania polecenia. Wtedy zaczyna się prawdziwy sprawdzian nauczania: co zostało w jego głowie?</p>
<p>Wyobraźmy sobie fikcyjną studentkę Ninę i fikcyjnego pana Horskiego. Ma porozmawiać z nim o obawach związanych z leczeniem choroby nerek. Wirtualny pacjent pozwala się zatrzymać, spróbować innego zdania i omówić błąd z nauczycielem. To bezpieczne miejsce do ćwiczeń. Jego wartość ujawnia się jednak podczas następnej rozmowy, gdy Nina potrafi słuchać bez suflera. Przykład nie opisuje rzeczywistego pacjenta ani zdarzenia.</p>
<h2>Tutor, który podważa pierwszą odpowiedź</h2>
<p><a href="https://mededu.jmir.org/2026/1/e102908/">Pilotażowe badanie randomizowane z udziałem 44 studentów patologii</a>, opublikowane 6 listopada 2026 roku, przyniosło ciekawy wynik. Tutor zgodny z programem i oparty na pytaniach sokratejskich poprawił oceny przygotowania i wyniki dyskusji grupowych. Nie wykazano jednak przekonującej przewagi w późniejszym zapamiętywaniu. Badanie obejmowało zaledwie dwa przypadki na jednej uczelni.</p>
<p>To użyteczny trop dla nauczycieli. Zamiast pytać o poprawną odpowiedź, tutor może zapytać, jaki wynik podważyłby wyjaśnienie studenta. Student musi pokazać drogę do wniosku. Płynny akapit można skopiować w sekundę; rozumowanie kliniczne trzeba wypracować.</p>
<h2>Rozmowę można przećwiczyć, relacji nie można obiecać</h2>
<p><a href="https://mededu.jmir.org/2026/1/e93034/">Randomizowane badanie wirtualnego pacjenta z 51 uczestnikami</a> wykazało większą bezpośrednią poprawę komunikacji o poważnej chorobie niż czytanie materiałów dydaktycznych. Ocena obejmowała rozmowy z pacjentami standaryzowanymi i oceniających nieznających przydziału do grup. To więcej niż samo zadowolenie z narzędzia. Nadal jednak jest to wynik krótkoterminowy, a nie dowód lepszej opieki nad pacjentami.</p>
<p>Przeciwwagę stanowi <a href="https://www.jmir.org/2026/1/e91886/">kolejne badanie randomizowane z 50 studentami</a>. Komunikacja poprawiała się w ciągu roku akademickiego, lecz dodatkowe ćwiczenia z AI w ostatnich trzech miesiącach nie dały statystycznie istotnej przewagi nad zwykłym nauczaniem. Nie oznacza to, że symulacja jest bezwartościowa. Pokazuje, że kolejny ekran sam nie zagwarantuje lepszego lekarza.</p>
<h2>Małe laboratorium uczenia się</h2>
<p>Proponuję zacząć od jednego przypadku sprawdzonego przez eksperta i kolejności: najpierw samodzielnie, potem z tutorem, na końcu ponownie samodzielnie. Student zapisuje własne rozumowanie. AI otrzymuje zatwierdzone materiały i zadaje stopniowane pytania. Następnie nauczyciel i student omawiają decyzje oraz błędy. Po pewnym czasie pojawia się nowy przypadek bez pomocy AI.</p>
<p>Dodałbym sprawdzian odporności na przekonujący błąd. Nauczyciel umieszcza wiarygodne, lecz nieprawidłowe wyjaśnienie w wyraźnie oznaczonym ćwiczeniu. Student ma znaleźć sprzeczność, sprawdzić źródło i wyjaśnić poprawkę. To propozycja do lokalnej oceny, a nie metoda o udowodnionej skuteczności. Oceniałbym poprawność, uzasadnienie i rozpoznawanie niepewności, nie szybkość pisania.</p>
<p>Do symulacji należą wyłącznie dane wymyślone, nigdy skopiowana dokumentacja medyczna. Trzeba zachować scenariusz i jego wersję, a odpowiedzi poddać kontroli eksperta. Anonimowo brzmiące nazwisko nie chroni człowieka, jeśli rzadka diagnoza, data i placówka pozwalają go rozpoznać.</p>
<p><a href="https://pubmed.ncbi.nlm.nih.gov/42085678/">Metaanaliza 66 badań randomizowanych z 4911 uczestnikami</a> wykazała korzystne wyniki w niektórych obszarach uczenia się, ale pewność dowodów była niska lub bardzo niska. Zadowolenie i pewność siebie nie zastąpią samodzielnego wykonania zadania. Liczba pytań w komercyjnym katalogu także nie mierzy tego, czego student się nauczył.</p>
<p>Najlepszy tutor nie musi odpowiadać najszybciej. Powinien przygotować studenta na chwilę, w której odpowiada sam, a naprzeciwko siedzi człowiek.</p>
<p><em>Esej o kształceniu opiera się na materiałach aktualnych na 9 listopada 2026 roku; odnośniki sprawdzono 10 listopada 2026 roku. Nie jest to instrukcja leczenia. Imiona i nazwiska w przykładzie są fikcyjne; wyniki badań odsyłają do oryginalnych publikacji.</em></p>

HTML,
        ],
        'hu' => [
            'title' => 'Mi marad, amikor az MI elhallgat: az orvosképzés próbája',
            'image_alt' => 'Nyitott jegyzetfüzet és sztetoszkóp egy névtelen virtuális beteget mutató táblagép előtt, türkiz fényben, lila háttérrel.',
            'excerpt' => 'A virtuális beteg megvárhatja, amíg a hallgató megtalálja a megfelelő szavakat. A valódi betegnek olyan emberre van szüksége, aki érti is őket. A kutatások ígéretes lehetőségeket mutatnak, de a tudást kikapcsolt képernyő mellett is mérni kell.',
            'content' => <<<'HTML'
<p>A hallgató bezárja a mesterséges intelligenciával folytatott beszélgetést, és hirtelen saját szavaival kell elmondania, miért döntött így. Segítség nélkül, újabb, jobban megfogalmazott utasítás nélkül. Ekkor kezdődik az oktatás igazi próbája: mi maradt meg a fejében?</p>
<p>Képzeljük el Ninát, a kitalált hallgatót és a szintén kitalált Horský urat. A vesebetegség kezelésével kapcsolatos félelmeiről kell beszélgetnie vele. A virtuális beteg mellett megállhat, másik mondatot próbálhat ki, és oktatójával elemezheti a hibát. Ez biztonságos gyakorlótér. Értéke azonban a következő beszélgetésben mutatkozik meg, amikor Nina súgás nélkül is tud figyelni. A példa nem valódi betegről vagy eseményről szól.</p>
<h2>Oktatósegéd, amely visszakérdez</h2>
<p>Egy 2026. november 6-án megjelent, <a href="https://mededu.jmir.org/2026/1/e102908/">44 patológiát tanuló hallgatóval végzett randomizált pilotvizsgálat</a> érdekes eredményt hozott. A tananyaghoz igazított, szókratészi kérdésekkel dolgozó oktatósegéd javította a felkészülés értékelését és a kiscsoportos megbeszéléseken nyújtott teljesítményt. A későbbi tudásmegőrzésben azonban nem igazoltak meggyőző előnyt. Mindössze két esetet vizsgáltak egyetlen intézményben.</p>
<p>Ez használható kiindulópont az oktatóknak. A helyes válasz helyett az oktatósegéd megkérdezheti, melyik adat cáfolná a hallgató magyarázatát. A hallgatónak meg kell mutatnia a következtetéshez vezető utat. Egy gördülékeny bekezdés másodpercek alatt átvehető; a klinikai gondolkodást fel kell építeni.</p>
<h2>A beszélgetés gyakorolható, a kapcsolat nem ígérhető meg</h2>
<p>Egy <a href="https://mededu.jmir.org/2026/1/e93034/">virtuális beteggel végzett, 51 résztvevős randomizált vizsgálat</a> nagyobb azonnali javulást talált a súlyos betegségről folytatott kommunikációban, mint az oktatási anyagok olvasása. Az értékelés standardizált betegekkel folytatott beszélgetéseket és a csoportbesorolást nem ismerő értékelőket is bevont. Ez többet mond az eszközzel való puszta elégedettségnél. Mégis rövid távú eredmény, nem a jobb betegellátás bizonyítéka.</p>
<p>Ellensúlyt jelent egy <a href="https://www.jmir.org/2026/1/e91886/">másik randomizált vizsgálat 50 hallgatóval</a>. A kommunikáció javult a tanév során, de az utolsó három hónap kiegészítő MI-gyakorlása nem adott statisztikailag szignifikáns előnyt a szokásos oktatáshoz képest. Ettől a szimuláció még nem értéktelen. Egy újabb képernyő önmagában nem garantál jobb orvost.</p>
<h2>Kis tanulási laboratórium</h2>
<p>Egyetlen, szakértő által ellenőrzött esettel kezdenék: először önállóan, majd oktatósegéddel, végül újra önállóan. A hallgató leírja saját gondolatmenetét. Az MI jóváhagyott anyagokat kap, és fokozatosan felépített kérdéseket tehet fel. Ezután oktató és hallgató közösen elemzi a döntéseket és hibákat. Később új eset következik MI-segítség nélkül.</p>
<p>A meggyőző hibával szembeni ellenállást is vizsgálnám. Az oktató egyértelműen gyakorlásra szánt feladatba hihető, de helytelen magyarázatot illeszt. A hallgató feladata az ellentmondás felismerése, a forrás ellenőrzése és a javítás indoklása. Ez helyi értékelést igénylő javaslat, nem már bizonyított oktatási módszer. A helyességet, az indoklást és a bizonytalanság felismerését értékelném, nem a gépelési sebességet.</p>
<p>A szimulációba kizárólag kitalált adatok valók, másolt betegiratok nem. Meg kell őrizni a forgatókönyvet és verzióját, a válaszokat szakértővel kell ellenőriztetni. Egy névtelennek tűnő név sem véd, ha egy ritka diagnózis, dátum és intézmény együtt azonosítja az embert.</p>
<p>Egy <a href="https://pubmed.ncbi.nlm.nih.gov/42085678/">66 randomizált vizsgálatot és 4911 résztvevőt összesítő metaanalízis</a> kedvező eredményeket talált egyes tanulási területeken, de a bizonyítékok bizonyossága alacsony vagy nagyon alacsony volt. Az elégedettség és az önbizalom nem helyettesítheti az önálló teljesítményt. Egy kereskedelmi kérdéstár mérete sem méri a megszerzett tudást.</p>
<p>A legjobb oktatósegédnek nem kell a leggyorsabban válaszolnia. Arra a pillanatra kell felkészítenie a hallgatót, amikor már önállóan válaszol, és vele szemben egy ember ül.</p>
<p><em>Az oktatásról szóló esszé a 2026. november 9-i állapotot tükröző anyagokra épül; a hivatkozásokat 2026. november 10-én ellenőriztük. Nem kezelési útmutató. A példa nevei kitaláltak; a kutatási eredmények az eredeti közleményekre hivatkoznak.</em></p>

HTML,
        ],
        'it' => [
            'title' => 'Che cosa resta quando l’IA tace: una prova per la formazione medica',
            'image_alt' => 'Un quaderno aperto e uno stetoscopio davanti a un tablet con un paziente virtuale anonimo, illuminati di turchese su fondo viola.',
            'excerpt' => 'Un paziente virtuale può aspettare che lo studente trovi le parole giuste. Un paziente reale ha bisogno di qualcuno che le comprenda. La ricerca mostra impieghi promettenti dell’IA e buone ragioni per valutare ciò che si è appreso a schermo spento.',
            'content' => <<<'HTML'
<p>Uno studente chiude la conversazione con l’intelligenza artificiale e improvvisamente deve spiegare con parole proprie perché ha preso quella decisione. Senza suggerimenti, senza un altro tentativo di formulare meglio la richiesta. Qui comincia la vera prova dell’insegnamento: che cosa gli è rimasto in testa?</p>
<p>Immaginiamo Nina, una studentessa di fantasia, e il signor Horský, anch’egli immaginario. Deve parlare con lui dei timori legati alla cura di una malattia renale. Il paziente virtuale le permette di fermarsi, provare un’altra frase e analizzare un errore con il docente. È uno spazio protetto per esercitarsi. Il suo valore emerge però nel colloquio successivo, quando Nina sa ascoltare senza suggeritore. L’esempio non descrive pazienti o eventi reali.</p>
<h2>Un tutor che mette in discussione la prima risposta</h2>
<p>Uno <a href="https://mededu.jmir.org/2026/1/e102908/">studio pilota randomizzato su 44 studenti di patologia</a>, pubblicato il 6 novembre 2026, offre un risultato interessante. Un tutor allineato al programma e guidato da domande socratiche ha migliorato le valutazioni della preparazione e il rendimento nelle discussioni di gruppo. Non è stato dimostrato un vantaggio convincente nella ritenzione successiva. Lo studio riguardava soltanto due casi in un unico istituto.</p>
<p>È una pista utile per chi insegna. Invece di chiedere la risposta corretta, il tutor può domandare quale dato metterebbe in dubbio la spiegazione dello studente. Lo studente deve mostrare il percorso verso la conclusione. Un paragrafo scorrevole si copia in un secondo; il ragionamento clinico va costruito.</p>
<h2>Si può provare un colloquio, non promettere una relazione</h2>
<p>Uno <a href="https://mededu.jmir.org/2026/1/e93034/">studio randomizzato con un paziente virtuale e 51 partecipanti</a> ha rilevato un miglioramento immediato della comunicazione sulle malattie gravi maggiore rispetto alla lettura di materiali didattici. La valutazione comprendeva colloqui con pazienti standardizzati e valutatori all’oscuro dell’assegnazione ai gruppi. È più informativo del semplice gradimento dello strumento. Resta un risultato a breve termine, non una prova di cure migliori.</p>
<p>Un <a href="https://www.jmir.org/2026/1/e91886/">altro studio randomizzato con 50 studenti</a> offre un contrappeso. La comunicazione migliorava durante l’anno accademico, ma l’esercizio aggiuntivo con l’IA negli ultimi tre mesi non ha prodotto un vantaggio statisticamente significativo rispetto alla didattica abituale. Questo non rende inutile la simulazione. Mostra che uno schermo in più, da solo, non garantisce un medico migliore.</p>
<h2>Un piccolo laboratorio di apprendimento</h2>
<p>Comincerei con un caso verificato da un esperto e questa sequenza: prima da soli, poi con il tutor, infine di nuovo da soli. Lo studente annota il proprio ragionamento. L’IA riceve materiali approvati e può porre domande graduate. Docente e studente analizzano poi decisioni ed errori. A distanza di tempo segue un caso nuovo, senza aiuto dell’IA.</p>
<p>Aggiungerei una prova di resistenza a un errore persuasivo. Il docente inserisce una spiegazione plausibile ma sbagliata in un esercizio chiaramente identificato come tale. Lo studente deve individuare la contraddizione, verificare la fonte e motivare la correzione. È una proposta da valutare localmente, non un metodo didattico già dimostrato. Valuterei correttezza, motivazione e riconoscimento dell’incertezza, non la velocità di scrittura.</p>
<p>La simulazione deve usare soltanto dati inventati, mai cartelle cliniche copiate. Occorre conservare lo scenario e la sua versione e far controllare le risposte da un esperto. Un nome apparentemente anonimo non protegge nessuno se una diagnosi rara, una data e una struttura permettono di riconoscere la persona.</p>
<p>Una <a href="https://pubmed.ncbi.nlm.nih.gov/42085678/">metanalisi di 66 studi randomizzati con 4.911 partecipanti</a> ha trovato risultati favorevoli in alcuni ambiti dell’apprendimento, ma la certezza delle prove era bassa o molto bassa. Soddisfazione e fiducia non possono sostituire la prestazione autonoma. Nemmeno il numero di domande in un catalogo commerciale misura ciò che lo studente ha imparato.</p>
<p>Il tutor migliore non deve necessariamente rispondere più in fretta. Deve preparare lo studente al momento in cui risponderà da solo, davanti a una persona.</p>
<p><em>Questo saggio sulla formazione si basa su materiali aggiornati al 9 novembre 2026; i collegamenti sono stati verificati il 10 novembre 2026. Non è una guida terapeutica. I nomi dell’esempio sono inventati; i risultati rimandano alle pubblicazioni originali.</em></p>

HTML,
        ],
        'uk' => [
            'title' => 'Що залишається, коли ШІ замовкає: перевірка медичної освіти',
            'image_alt' => 'Відкритий записник і стетоскоп перед планшетом з анонімною постаттю віртуального пацієнта, у бірюзовому світлі на фіолетовому тлі.',
            'excerpt' => 'Віртуальний пацієнт може зачекати, поки студент знайде потрібні слова. Справжньому пацієнтові потрібна людина, яка їх розуміє. Дослідження показують перспективні можливості ШІ та причини перевіряти знання після вимкнення екрана.',
            'content' => <<<'HTML'
<p>Студент закриває розмову зі штучним інтелектом і раптом мусить власними словами пояснити, чому ухвалив саме таке рішення. Без підказок, без чергової спроби краще сформулювати запит. Саме тоді починається справжня перевірка навчання: що залишилося в його голові?</p>
<p>Уявімо вигадану студентку Ніну та вигаданого пана Горського. Вона має поговорити з ним про побоювання щодо лікування хвороби нирок. Віртуальний пацієнт дозволяє зупинитися, спробувати іншу фразу й розібрати помилку з викладачем. Це безпечний простір для практики. Його користь виявиться в наступній розмові, коли Ніна зможе слухати без підказувача. Цей приклад не описує реального пацієнта чи подію.</p>
<h2>Наставник, який ставить першу відповідь під сумнів</h2>
<p><a href="https://mededu.jmir.org/2026/1/e102908/">Пілотне рандомізоване дослідження за участю 44 студентів, які вивчали патологію</a>, опубліковане 6 листопада 2026 року, дало цікавий результат. Наставник, узгоджений із навчальною програмою та побудований на сократівських запитаннях, поліпшив оцінки підготовки й роботу в групових обговореннях. Переконливої переваги у відстроченому збереженні знань не продемонстровано. До того ж вивчали лише два випадки в одному закладі.</p>
<p>Це корисний орієнтир для викладача. Замість запитувати правильну відповідь наставник може попросити назвати дані, які поставили б пояснення студента під сумнів. Студент має показати шлях до висновку. Зв’язний абзац можна скопіювати за секунду; клінічне мислення потрібно сформувати.</p>
<h2>Розмову можна відпрацювати, стосунків не можна пообіцяти</h2>
<p><a href="https://mededu.jmir.org/2026/1/e93034/">Рандомізоване дослідження віртуального пацієнта з 51 учасником</a> показало більше негайне поліпшення спілкування про тяжку хворобу, ніж читання навчальних матеріалів. Оцінювання включало розмови зі стандартизованими пацієнтами й оцінювачів, які не знали розподілу учасників за групами. Це інформативніше за саме задоволення інструментом. Проте йдеться про короткостроковий результат, а не доказ кращої допомоги пацієнтам.</p>
<p>Противагу дає <a href="https://www.jmir.org/2026/1/e91886/">інше рандомізоване дослідження з 50 студентами</a>. Спілкування поліпшувалося протягом навчального року, але додаткові заняття із ШІ в останні три місяці не забезпечили статистично значущої переваги над звичайним навчанням. Це не означає, що симуляція марна. Додатковий екран сам по собі не гарантує кращого лікаря.</p>
<h2>Невелика навчальна лабораторія</h2>
<p>Я почав би з одного випадку, перевіреного фахівцем, і послідовності: спочатку самостійно, потім із наставником, насамкінець знову самостійно. Студент записує власне міркування. ШІ отримує затверджені матеріали й може ставити поступово ускладнювані запитання. Далі викладач і студент розбирають рішення та помилки. Згодом пропонується новий випадок без допомоги ШІ.</p>
<p>Я додав би перевірку стійкості до переконливої помилки. Викладач вставляє правдоподібне, але хибне пояснення в чітко позначене навчальне завдання. Студент має знайти суперечність, перевірити джерело й пояснити виправлення. Це пропозиція для місцевого оцінювання, а не вже доведений освітній метод. Я оцінював би правильність, обґрунтування й розпізнавання невизначеності, а не швидкість набору тексту.</p>
<p>У симуляції слід використовувати лише вигадані дані, ніколи не копіювати медичну документацію. Треба зберігати сценарій і його версію, а відповіді перевіряти з фахівцем. Навіть анонімне на вигляд ім’я не захистить людину, якщо рідкісний діагноз, дата й заклад разом дозволяють її впізнати.</p>
<p><a href="https://pubmed.ncbi.nlm.nih.gov/42085678/">Метааналіз 66 рандомізованих досліджень із 4911 учасниками</a> виявив сприятливі результати в окремих сферах навчання, однак упевненість у доказах була низькою або дуже низькою. Задоволеність і впевненість у собі не замінюють самостійного виконання завдання. Кількість запитань у комерційному каталозі теж не вимірює засвоєного.</p>
<p>Найкращий наставник не обов’язково відповідає найшвидше. Він має підготувати студента до миті, коли той відповідатиме сам, а навпроти сидітиме людина.</p>
<p><em>Есе про освіту спирається на матеріали станом на 9 листопада 2026 року; посилання перевірено 10 листопада 2026 року. Це не настанова з лікування. Імена в прикладі вигадані; результати досліджень посилаються на оригінальні публікації.</em></p>

HTML,
        ],
    ],
];
