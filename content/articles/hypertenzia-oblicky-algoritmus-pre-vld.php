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
    'image' => 'images/articles/hypertenzia-oblicky-algoritmus-pre-vld.webp',
    'translations' => [
        'sk' => [
            'title' => 'Ochorenie obličiek zachytíme neskoro, lebo odporúčania sa nedostanú k lekárom, ktorí pacienta vidia ako prví.',
            'image_alt' => 'Ambulancia všeobecného lekára: meranie tlaku v popredí, v presýpacích hodinách sa míňa čas obličiek.',
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
            'image_alt' => 'A primary-care consult: blood pressure in the foreground while a kidney-shaped hourglass runs out of time.',
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
        'cs' => [
            'title' => 'Onemocnění ledvin zachytíme pozdě, protože doporučení se nedostanou k lékařům, kteří pacienta vidí jako první.',
            'image_alt' => 'Ambulance praktického lékaře: měření tlaku v popředí, v přesýpacích hodinách se míjí čas ledvin.',
            'excerpt' => 'S redaktorkou Michaelou Malovou ze SOLEN jsme dokončili rukopis pro Via practica: algoritmus pro praktické lékaře, jak z KDIGO a ESH udělat rozhodnutí v běžné ambulanci — kdy screening, kdy odeslat, kdy začít léčbu ještě před odesláním.',
            'content' => <<<'HTML'
<p>Většinu onemocnění ledvin zachytíme pozdě, protože guidelines se nedostanou k lékařům, kteří pacienta vidí jako první.</p>
<p>Tento týden jsem s Michaelou Malovou, redaktorkou vydavatelství SOLEN, dokončil rukopis pro časopis <a href="https://www.solen.sk/sk/casopisy/via-practica">Via practica</a>. Název: <em>Hypertenzia a obličky: nové odporúčania a algoritmus pre VLD</em>. VLD jsou praktičtí lékaři pro dospělé na Slovensku.</p>
<p>Problém, který text řeší, je jednoduchý a tvrdošíjný. Nefrologická doporučení píší nefrologové pro nefrology. Pacient, u něhož se rozvine chronické onemocnění ledvin, však do nefrologické ambulance nepřijde jako první. Přijde ke svému obvodnímu lékaři s vysokým krevním tlakem.</p>
<p>Než se ke mně dostane, eGFR už často klesl pod 60&nbsp;ml/min/1,73&nbsp;m². Okno na zásah — inhibitory SGLT2, blokáda RAAS, úprava životosprávy — bylo o měsíce nebo roky dříve.</p>
<p>Proto jsme aktuální doporučení KDIGO a ESH stáhli do jednoho algoritmu, který umí praktický lékař použít během běžné konzultace. Kdy screeningovat. Kdy odeslat. Kdy začít farmakoterapii ještě před odesláním.</p>
<p>Algoritmus není převratný. To je záměr. Poznání existuje. Mezera je v doručení — dostat ho k lidem, kteří stojí na začátku cesty péče, ne na jejím konci.</p>
<p>Pokud pracujete ve specializovaném oboru: který jeden kousek vašeho poznání by zítra nejvíc změnil praxi, kdyby se dostal k praktickým lékařům? Napište mi přes <a href="contact.php">kontakt</a>.</p>
<p><em>Jde o doprovodný text k rukopisu, nikoli o náhradu původních doporučení KDIGO a ESH ani o léčebné rozhodnutí pro konkrétního pacienta.</em></p>
HTML,
        ],
        'de' => [
            'title' => 'Nierenerkrankungen erkennen wir zu spät, weil die Leitlinien nicht die Ärztinnen und Ärzte erreichen, die Patientinnen zuerst sehen.',
            'image_alt' => 'Hausarztpraxis: Blutdruckmessung im Vordergrund, in der Sanduhr läuft die Zeit der Nieren ab.',
            'excerpt' => 'Mit der Redakteurin Michaela Malová von SOLEN habe ich ein Manuskript für Via practica abgeschlossen: einen Algorithmus für die hausärztliche Praxis, der KDIGO und ESH in eine Routinekonsultation übersetzt — wann screenen, wann überweisen, wann vor der Überweisung behandeln.',
            'content' => <<<'HTML'
<p>Die meisten Nierenerkrankungen erkennen wir zu spät, weil Leitlinien die Ärztinnen und Ärzte nicht erreichen, die Patientinnen und Patienten zuerst sehen.</p>
<p>Diese Woche habe ich mit Michaela Malová, Redakteurin beim Verlag SOLEN, ein Manuskript für die Zeitschrift <a href="https://www.solen.sk/en/journals/via-practica">Via practica</a> abgeschlossen. Titel: <em>Hypertenzia a obličky: nové odporúčania a algoritmus pre VLD</em>. VLD sind hausärztlich tätige Internistinnen und Internisten für Erwachsene in der Slowakei.</p>
<p>Das Problem, das der Text angeht, ist einfach und hartnäckig. Nephrologische Leitlinien schreiben Nephrologen für Nephrologen. Der Patient, bei dem sich eine chronische Nierenerkrankung entwickeln wird, kommt aber nicht zuerst in die nephrologische Ambulanz. Er kommt mit Bluthochdruck zu seiner Hausärztin oder seinem Hausarzt.</p>
<p>Bis er bei mir ist, ist die eGFR oft schon unter 60&nbsp;ml/min/1,73&nbsp;m² gefallen. Das Fenster für den Eingriff — SGLT2-Hemmer, RAAS-Blockade, Lebensstiländerung — lag Monate oder Jahre früher.</p>
<p>Deshalb haben wir die aktuellen Empfehlungen von KDIGO und ESH in einen Algorithmus verdichtet, den die Hausarztpraxis in einer Routinekonsultation nutzen kann. Wann screenen. Wann überweisen. Wann Pharmakotherapie noch vor der Überweisung beginnen.</p>
<p>Der Algorithmus ist nicht bahnbrechend. Das ist Absicht. Das Wissen existiert. Die Lücke liegt in der Zustellung — es zu den Menschen zu bringen, die am Anfang des Versorgungspfads stehen, nicht am Ende.</p>
<p>Wenn Sie in einem Fachgebiet arbeiten: Welches eine Stück Ihres Wissens würde die Praxis morgen am stärksten verändern, wenn es die Hausärztinnen und Hausärzte erreichte? Schreiben Sie mir über das <a href="contact.php">Kontaktformular</a>.</p>
<p><em>Das ist ein Begleittext zu einem Manuskript, kein Ersatz der Originalempfehlungen von KDIGO und ESH und keine Behandlungsentscheidung für einen einzelnen Patienten.</em></p>
HTML,
        ],
        'fr' => [
            'title' => 'La maladie rénale se dépiste trop tard, parce que les recommandations n\'atteignent pas les médecins qui voient les patients en premier.',
            'image_alt' => 'Consultation de médecine générale : la mesure de la tension au premier plan, un sablier rénal dont le temps s\'écoule.',
            'excerpt' => 'Avec Michaela Malová, chez SOLEN, j\'ai achevé un manuscrit pour Via practica : un algorithme pour les médecins de premier recours slovaques, qui transforme KDIGO et ESH en décision de consultation — quand dépister, quand adresser, quand traiter avant l\'adressage.',
            'content' => <<<'HTML'
<p>La plupart des maladies rénales se dépistent trop tard, parce que les guidelines n'atteignent pas les médecins qui voient les patients en premier.</p>
<p>Cette semaine, j'ai finalisé un manuscrit avec Michaela Malová, rédactrice chez SOLEN, pour la revue <a href="https://www.solen.sk/en/journals/via-practica">Via practica</a>. Titre : <em>Hypertenzia a obličky: nové odporúčania a algoritmus pre VLD</em>. VLD désigne les médecins de premier recours pour adultes en Slovaquie.</p>
<p>Le problème que le texte traite est simple et tenace. Les recommandations de néphrologie sont écrites par des néphrologues, pour des néphrologues. Or le patient chez qui une MRC se développera n'entre pas d'abord dans une consultation de néphrologie. Il entre chez son médecin de famille avec une hypertension.</p>
<p>Quand il arrive jusqu'à moi, le DFGe est souvent déjà tombé sous 60&nbsp;ml/min/1,73&nbsp;m². La fenêtre d'intervention — inhibiteurs SGLT2, blocage du SRAA, modification du mode de vie — était des mois ou des années plus tôt.</p>
<p>Nous avons donc condensé les recommandations actuelles KDIGO et ESH en un algorithme qu'un médecin de premier recours peut suivre pendant une consultation de routine. Quand dépister. Quand adresser. Quand commencer une pharmacothérapie avant même l'adressage.</p>
<p>L'algorithme n'est pas révolutionnaire. C'est voulu. La connaissance existe. L'écart est dans la livraison — l'amener aux personnes qui se tiennent à l'entrée du parcours de soins, pas à la fin.</p>
<p>Si vous travaillez dans une spécialité : quel unique morceau de votre savoir changerait le plus la pratique demain, s'il parvenait aux médecins de premier recours ? Écrivez-moi via le <a href="contact.php">formulaire de contact</a>.</p>
<p><em>Il s'agit d'un texte d'accompagnement d'un manuscrit, non d'un substitut aux recommandations originales KDIGO et ESH, ni d'une décision thérapeutique pour un patient donné.</em></p>
HTML,
        ],
        'es' => [
            'title' => 'La enfermedad renal se detecta demasiado tarde porque las guías no llegan a los médicos que ven al paciente primero.',
            'image_alt' => 'Consulta de atención primaria: medición de la presión en primer plano y un reloj de arena renal cuyo tiempo se acaba.',
            'excerpt' => 'Con Michaela Malová, de SOLEN, cerré un manuscrito para Via practica: un algoritmo para médicos de familia eslovacos que convierte KDIGO y ESH en una consulta rutinaria — cuándo cribar, cuándo derivar, cuándo tratar antes de la derivación.',
            'content' => <<<'HTML'
<p>La mayor parte de la enfermedad renal se detecta demasiado tarde porque las guidelines no llegan a los médicos que ven al paciente primero.</p>
<p>Esta semana finalicé un manuscrito con Michaela Malová, editora de SOLEN, para la revista <a href="https://www.solen.sk/en/journals/via-practica">Via practica</a>. Título: <em>Hypertenzia a obličky: nové odporúčania a algoritmus pre VLD</em>. VLD son los médicos de atención primaria de adultos en Eslovaquia.</p>
<p>El problema que aborda el texto es simple y tenaz. Las recomendaciones de nefrología las escriben nefrólogos para nefrólogos. Pero el paciente en el que se desarrollará una ERC no entra primero en una consulta de nefrología. Entra en la de su médico de familia con hipertensión.</p>
<p>Cuando llega a mí, el TFGe a menudo ya ha bajado de 60&nbsp;ml/min/1,73&nbsp;m². La ventana de intervención — inhibidores SGLT2, bloqueo del SRAA, cambio de estilo de vida — estaba meses o años antes.</p>
<p>Por eso condensamos las recomendaciones actuales de KDIGO y ESH en un algoritmo que un médico de familia puede seguir en una consulta rutinaria. Cuándo cribar. Cuándo derivar. Cuándo iniciar farmacoterapia antes incluso de la derivación.</p>
<p>El algoritmo no es revolucionario. Esa es la intención. El conocimiento existe. La brecha está en la entrega: llevarlo a quienes están a la entrada del itinerario asistencial, no al final.</p>
<p>Si trabaja en una especialidad: ¿qué único fragmento de su conocimiento cambiaría más la práctica mañana si llegara a atención primaria? Escríbame a través del <a href="contact.php">formulario de contacto</a>.</p>
<p><em>Es un texto acompañante de un manuscrito, no un sustituto de las recomendaciones originales de KDIGO y ESH ni una decisión terapéutica para un paciente concreto.</em></p>
HTML,
        ],
        'pl' => [
            'title' => 'Chorobę nerek wychwytujemy za późno, bo wytyczne nie docierają do lekarzy, którzy pacjenta widzą jako pierwsi.',
            'image_alt' => 'Poradnia lekarza rodzinnego: pomiar ciśnienia na pierwszym planie, w klepsydrze ucieka czas nerek.',
            'excerpt' => 'Z redaktorką Michaelą Malovą z SOLEN dokończyliśmy rękopis dla Via practica: algorytm dla lekarzy rodzinnych, jak z KDIGO i ESH zrobić decyzję w zwykłej poradni — kiedy przesiew, kiedy skierować, kiedy zacząć leczenie jeszcze przed skierowaniem.',
            'content' => <<<'HTML'
<p>Większość chorób nerek wychwytujemy za późno, bo guidelines nie docierają do lekarzy, którzy pacjenta widzą jako pierwsi.</p>
<p>W tym tygodniu z Michaelą Malovą, redaktorką wydawnictwa SOLEN, dokończyłem rękopis dla czasopisma <a href="https://www.solen.sk/en/journals/via-practica">Via practica</a>. Tytuł: <em>Hypertenzia a obličky: nové odporúčania a algoritmus pre VLD</em>. VLD to lekarze rodzinni dla dorosłych na Słowacji.</p>
<p>Problem, który tekst podejmuje, jest prosty i uporczywy. Zalecenia nefrologiczne piszą nefrolodzy dla nefrologów. Pacjent, u którego rozwinie się przewlekła choroba nerek, nie przychodzi jednak najpierw do poradni nefrologicznej. Przychodzi do swojego lekarza rodzinnego z nadciśnieniem.</p>
<p>Zanim dotrze do mnie, eGFR często już spadł poniżej 60&nbsp;ml/min/1,73&nbsp;m². Okno na interwencję — inhibitory SGLT2, blokada RAAS, zmiana stylu życia — było miesiącami lub latami wcześniej.</p>
<p>Dlatego aktualne zalecenia KDIGO i ESH ściągnęliśmy do jednego algorytmu, którego lekarz rodzinny może użyć podczas zwykłej konsultacji. Kiedy przesiewać. Kiedy kierować. Kiedy zacząć farmakoterapię jeszcze przed skierowaniem.</p>
<p>Algorytm nie jest przełomowy. Taki jest zamysł. Wiedza istnieje. Luka jest w dostarczeniu — w tym, by trafiła do ludzi, którzy stoją na początku ścieżki opieki, nie na jej końcu.</p>
<p>Jeśli pracujecie w dziedzinie specjalistycznej: który jeden kawałek waszej wiedzy najbardziej zmieniłby praktykę jutro, gdyby trafił do lekarzy rodzinnych? Napiszcie do mnie przez <a href="contact.php">kontakt</a>.</p>
<p><em>To tekst towarzyszący rękopisowi, nie zastępstwo oryginalnych zaleceń KDIGO i ESH ani decyzja lecznicza wobec konkretnego pacjenta.</em></p>
HTML,
        ],
        'hu' => [
            'title' => 'A vesebetegséget későn ismerjük fel, mert az ajánlások nem jutnak el azokhoz az orvosokhoz, akik a beteget először látják.',
            'image_alt' => 'Háziorvosi rendelő: vérnyomásmérés az előtérben, a vese alakú homokórában fogy az idő.',
            'excerpt' => 'Michaela Malovával, a SOLEN szerkesztőjével lezártuk a Via practica kéziratát: algoritmus háziorvosoknak, hogyan legyen a KDIGO és az ESH döntés a rendelőben — mikor szűrjünk, mikor utaljunk, mikor kezdjünk kezelést az utalás előtt.',
            'content' => <<<'HTML'
<p>A vesebetegségek többségét későn ismerjük fel, mert a guidelines nem jutnak el azokhoz az orvosokhoz, akik a beteget először látják.</p>
<p>Ezen a héten Michaela Malovával, a SOLEN kiadó szerkesztőjével lezártam a <a href="https://www.solen.sk/en/journals/via-practica">Via practica</a> kéziratát. Cím: <em>Hypertenzia a obličky: nové odporúčania a algoritmus pre VLD</em>. A VLD Szlovákiában a felnőttek háziorvosait jelenti.</p>
<p>A szöveg problémája egyszerű és makacs. A nefrológiai ajánlásokat nefrológusok írják nefrológusoknak. A beteg, akinél krónikus vesebetegség alakul ki, azonban nem a nefrológiai rendelőbe lép be először. A háziorvosához megy magas vérnyomással.</p>
<p>Mire hozzám eljut, az eGFR gyakran már 60&nbsp;ml/min/1,73&nbsp;m² alá esett. A beavatkozás ablaka — SGLT2-gátlók, RAAS-blokád, életmódváltás — hónapokkal vagy évekkel korábban volt.</p>
<p>Ezért a jelenlegi KDIGO- és ESH-ajánlásokat egyetlen algoritmusba sűrítettük, amelyet a háziorvos egy rutinkonzultáció alatt követhet. Mikor szűrjön. Mikor utaljon. Mikor kezdjen gyógyszeres kezelést még az utalás előtt.</p>
<p>Az algoritmus nem áttörő. Ez a szándék. A tudás megvan. A rés a kézbesítésben van: eljuttatni azokhoz, akik a gondozási út elején állnak, nem a végén.</p>
<p>Ha szakorvosi területen dolgozik: tudásának melyik egy darabja változtatná meg holnap a gyakorlatot a legjobban, ha eljutna a háziorvosokhoz? Írjon nekem a <a href="contact.php">kapcsolati űrlapon</a>.</p>
<p><em>Kéziratot kísérő szöveg, nem a KDIGO és az ESH eredeti ajánlásainak helyettesítője, és nem kezelési döntés egy adott beteg számára.</em></p>
HTML,
        ],
        'it' => [
            'title' => 'La malattia renale si intercetta troppo tardi, perché le linee guida non arrivano ai medici che vedono il paziente per primi.',
            'image_alt' => 'Ambulatorio di medicina generale: misurazione della pressione in primo piano e una clessidra renale il cui tempo sta finendo.',
            'excerpt' => 'Con Michaela Malová, di SOLEN, ho chiuso un manoscritto per Via practica: un algoritmo per i medici di famiglia slovacchi che trasforma KDIGO ed ESH in una visita di routine — quando fare screening, quando inviare, quando trattare prima dell\'invio.',
            'content' => <<<'HTML'
<p>La maggior parte delle malattie renali si intercetta troppo tardi, perché le guidelines non arrivano ai medici che vedono il paziente per primi.</p>
<p>Questa settimana ho finalizzato un manoscritto con Michaela Malová, redattrice della casa editrice SOLEN, per la rivista <a href="https://www.solen.sk/en/journals/via-practica">Via practica</a>. Titolo: <em>Hypertenzia a obličky: nové odporúčania a algoritmus pre VLD</em>. VLD sono i medici di medicina generale per adulti in Slovacchia.</p>
<p>Il problema che il testo affronta è semplice e ostinato. Le raccomandazioni nefrologiche le scrivono nefrologi per nefrologi. Il paziente in cui si svilupperà una MRC, però, non entra prima in un ambulatorio di nefrologia. Entra dal medico di famiglia con la pressione alta.</p>
<p>Quando arriva da me, l'eGFR è spesso già sceso sotto 60&nbsp;ml/min/1,73&nbsp;m². La finestra di intervento — inibitori SGLT2, blocco del RAAS, modifica dello stile di vita — era mesi o anni prima.</p>
<p>Perciò abbiamo condensato le raccomandazioni attuali KDIGO ed ESH in un unico algoritmo che il medico di famiglia può seguire durante una visita di routine. Quando fare screening. Quando inviare. Quando iniziare la farmacoterapia ancora prima dell'invio.</p>
<p>L'algoritmo non è rivoluzionario. Questo è lo scopo. La conoscenza esiste. Il vuoto è nella consegna: farla arrivare alle persone che stanno all'ingresso del percorso di cura, non alla fine.</p>
<p>Se lavorate in una specialità: quale unico pezzo del vostro sapere cambierebbe di più la pratica domani, se arrivasse ai medici di famiglia? Scrivetemi tramite il <a href="contact.php">modulo di contatto</a>.</p>
<p><em>È un testo di accompagnamento a un manoscritto, non un sostituto delle raccomandazioni originali KDIGO ed ESH né una decisione terapeutica per un paziente concreto.</em></p>
HTML,
        ],
        'uk' => [
            'title' => 'Хворобу нирок виявляємо запізно, бо настанови не доходять до лікарів, які бачать пацієнта першими.',
            'image_alt' => 'Кабінет сімейного лікаря: вимірювання тиску на передньому плані, у пісковому годиннику спливає час нирок.',
            'excerpt' => 'З редакторкою Міхаелою Маловою із SOLEN ми завершили рукопис для Via practica: алгоритм для сімейних лікарів, як із KDIGO та ESH зробити рішення на звичайному прийомі — коли скринінг, коли скерувати, коли почати лікування ще до скерування.',
            'content' => <<<'HTML'
<p>Більшість хвороб нирок виявляємо запізно, бо guidelines не доходять до лікарів, які бачать пацієнта першими.</p>
<p>Цього тижня я з Міхаелою Маловою, редакторкою видавництва SOLEN, завершив рукопис для журналу <a href="https://www.solen.sk/en/journals/via-practica">Via practica</a>. Назва: <em>Hypertenzia a obličky: nové odporúčania a algoritmus pre VLD</em>. VLD — це сімейні лікарі для дорослих у Словаччині.</p>
<p>Проблема, яку розв'язує текст, проста й уперта. Нефрологічні настанови пишуть нефрологи для нефрологів. Пацієнт, у якого розвинеться хронічна хвороба нирок, однак не заходить спочатку до нефрологічного кабінету. Він іде до свого сімейного лікаря з високим тиском.</p>
<p>Поки він доходить до мене, eGFR часто вже впав нижче 60&nbsp;мл/хв/1,73&nbsp;м². Вікно для втручання — інгібітори SGLT2, блокада RAAS, зміна способу життя — було місяцями чи роками раніше.</p>
<p>Тому чинні настанови KDIGO та ESH ми стягнули в один алгоритм, яким сімейний лікар може скористатися під час звичайної консультації. Коли скринінг. Коли скерувати. Коли почати фармакотерапію ще до скерування.</p>
<p>Алгоритм не проривний. Такий задум. Знання існує. Прогалина в доставці — донести його до людей, які стоять на початку шляху допомоги, а не в його кінці.</p>
<p>Якщо ви працюєте в спеціалізованій галузі: який один шмат вашого знання завтра найбільше змінив би практику, якби дійшов до сімейних лікарів? Напишіть мені через <a href="contact.php">контакт</a>.</p>
<p><em>Це супровідний текст до рукопису, а не заміна оригінальних настанов KDIGO та ESH і не лікувальне рішення щодо конкретного пацієнта.</em></p>
HTML,
        ],
    ],
];
