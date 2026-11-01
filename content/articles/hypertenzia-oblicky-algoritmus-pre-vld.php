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
 * Zdroj: finalizácia rukopisu s redaktorkou SOLEN, 11. až 14. 9. 2026.
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
            'excerpt' => 'S redaktorkou vydavateľstva SOLEN sme dokončili rukopis pre Via practica: algoritmus pre VLD, ako z KDIGO a ESH urobiť rozhodnutie v bežnej ambulancii: kedy skríning, kedy odoslať, kedy začať liečbu ešte pred odoslaním.',
            'content' => <<<'HTML'
<p>Tento týždeň som s redaktorkou vydavateľstva SOLEN dokončil rukopis pre časopis <a href="https://www.solen.sk/sk/casopisy/via-practica">Via practica</a>. Názov: <em>Hypertenzia a obličky: nové odporúčania a algoritmus pre VLD</em>. VLD sú všeobecní lekári pre dospelých na Slovensku.</p>
<p>Nefrologické odporúčania píšu nefrológovia pre nefrológov. Pacient, u ktorého sa rozvinie chronické ochorenie obličiek, však do nefrologickej ambulancie nepríde ako prvý. Príde k svojmu obvodnému lekárovi s vysokým krvným tlakom.</p>
<p>Kým sa ku mne dostane, eGFR už často klesol pod 60&nbsp;ml/min/1,73&nbsp;m². Zásah, ktorý ešte dáva zmysel, inhibítory SGLT2, blokáda RAAS a úprava životosprávy, mal prísť o mesiace alebo o roky skôr.</p>
<p>Preto sme aktuálne odporúčania KDIGO a ESH zhrnuli do jedného algoritmu, ktorý vie všeobecný lekár použiť počas bežnej konzultácie. Kedy skrínovať. Kedy odoslať. Kedy začať farmakoterapiu ešte pred odoslaním.</p>
<p>Algoritmus nepridáva nové poznanie. To je zámer. Poznanie existuje. Chýba u lekára, ktorý pacienta vidí na začiatku, nie až v nefrologickej ambulancii.</p>
<p>Ak pracujete v špecializovanom odbore: ktorá jedna vec z vášho poznania by zajtra najviac zmenila prax, keby sa dostala k všeobecným lekárom?</p>
<p><em>Ide o sprievodný text k rukopisu, nie o náhradu originálnych odporúčaní KDIGO a ESH ani o liečebné rozhodnutie pre konkrétneho pacienta.</em></p>
HTML,
        ],
        'en' => [
            'title' => 'Most kidney disease is caught too late because the guidelines never reach the doctors who see patients first.',
            'image_alt' => 'A primary-care consult: blood pressure in the foreground while a kidney-shaped hourglass runs out of time.',
            'excerpt' => 'With an editor at SOLEN I finished a Via practica manuscript: an algorithm for Slovak primary-care physicians that turns KDIGO and ESH guidance into a routine consult: when to screen, when to refer, when to start treatment before the referral.',
            'content' => <<<'HTML'
<p>This week I finished a manuscript with an editor at SOLEN, for the journal <a href="https://www.solen.sk/en/journals/via-practica">Via practica</a>. The title: <em>Hypertension and Kidneys: New Recommendations and Algorithm for VLD</em>. VLD are adult primary-care physicians in Slovakia.</p>
<p>Nephrology guidelines are written by nephrologists, for nephrologists. The patient who will develop chronic kidney disease does not come to a nephrology clinic first. They come to their family doctor with high blood pressure.</p>
<p>By the time they reach me, the eGFR has often already fallen below 60&nbsp;ml/min/1.73&nbsp;m². The intervention that still makes sense, SGLT2 inhibitors, RAAS blockade and a change in daily habits, belonged months or years earlier.</p>
<p>So we put the current KDIGO and ESH recommendations into one algorithm a primary-care physician can use during a routine consult. When to screen. When to refer. When to start pharmacotherapy before the referral.</p>
<p>The algorithm adds no new knowledge. That is the point. The knowledge exists. It is missing with the doctor who sees the patient at the start, not only in the nephrology clinic.</p>
<p>If you work in a specialty: which one thing you know would change practice most tomorrow, if it reached primary-care physicians?</p>
<p><em>This is a companion note to a manuscript, not a substitute for the original KDIGO and ESH recommendations, and not a treatment decision for an individual patient.</em></p>
HTML,
        ],
        'cs' => [
            'title' => 'Onemocnění ledvin zachytíme pozdě, protože doporučení se nedostanou k lékařům, kteří pacienta vidí jako první.',
            'image_alt' => 'Ambulance praktického lékaře: měření tlaku v popředí, v přesýpacích hodinách se míjí čas ledvin.',
            'excerpt' => 'S redaktorkou vydavatelství SOLEN jsme dokončili rukopis pro Via practica: algoritmus pro praktické lékaře, jak z KDIGO a ESH udělat rozhodnutí v běžné ambulanci: kdy screening, kdy odeslat, kdy začít léčbu ještě před odesláním.',
            'content' => <<<'HTML'
<p>Tento týden jsem s redaktorkou vydavatelství SOLEN dokončil rukopis pro časopis <a href="https://www.solen.sk/sk/casopisy/via-practica">Via practica</a>. Název: <em>Hypertenzia a obličky: nové odporúčania a algoritmus pre VLD</em>. VLD jsou praktičtí lékaři pro dospělé na Slovensku.</p>
<p>Nefrologická doporučení píší nefrologové pro nefrology. Pacient, u něhož se rozvine chronické onemocnění ledvin, však do nefrologické ambulance nepřijde jako první. Přijde ke svému obvodnímu lékaři s vysokým krevním tlakem.</p>
<p>Než se ke mně dostane, eGFR už často klesla pod 60&nbsp;ml/min/1,73&nbsp;m². Zásah, který ještě dává smysl, inhibitory SGLT2, blokáda RAAS a úprava životosprávy, měl přijít o měsíce nebo o roky dříve.</p>
<p>Proto jsme aktuální doporučení KDIGO a ESH shrnuli do jednoho algoritmu, který praktický lékař zvládne během běžné konzultace. Kdy screenovat. Kdy odeslat. Kdy začít farmakoterapii ještě před odesláním.</p>
<p>Algoritmus nepřidává nové poznání. To je záměr. Poznání existuje. Chybí u lékaře, který pacienta vidí na začátku, ne až v nefrologické ambulanci.</p>
<p>Pokud pracujete ve specializovaném oboru: která jedna věc z vašeho poznání by zítra nejvíc změnila praxi, kdyby se dostala k praktickým lékařům?</p>
<p><em>Jde o doprovodný text k rukopisu, nikoli o náhradu původních doporučení KDIGO a ESH ani o léčebné rozhodnutí pro konkrétního pacienta.</em></p>
HTML,
        ],
        'de' => [
            'title' => 'Nierenerkrankungen erkennen wir zu spät, weil die Leitlinien nicht die Ärztinnen und Ärzte erreichen, die Patientinnen zuerst sehen.',
            'image_alt' => 'Hausarztpraxis: Blutdruckmessung im Vordergrund, in der Sanduhr läuft die Zeit der Nieren ab.',
            'excerpt' => 'Mit einer Redakteurin von SOLEN habe ich ein Manuskript für Via practica abgeschlossen: einen Algorithmus für die hausärztliche Praxis, der KDIGO und ESH in eine Routinekonsultation übersetzt: wann screenen, wann überweisen, wann vor der Überweisung behandeln.',
            'content' => <<<'HTML'
<p>Diese Woche habe ich mit einer Redakteurin beim Verlag SOLEN ein Manuskript für die Zeitschrift <a href="https://www.solen.sk/en/journals/via-practica">Via practica</a> abgeschlossen. Titel: <em>Hypertenzia a obličky: nové odporúčania a algoritmus pre VLD</em>. VLD sind Allgemeinärztinnen und Allgemeinärzte für Erwachsene in der Slowakei.</p>
<p>Nephrologische Leitlinien schreiben Nephrologen für Nephrologen. Der Patient, bei dem sich eine chronische Nierenerkrankung entwickeln wird, kommt aber nicht zuerst in die nephrologische Ambulanz. Er kommt mit hohem Blutdruck zu seiner Hausärztin oder seinem Hausarzt.</p>
<p>Bis er bei mir ist, ist die eGFR oft schon unter 60&nbsp;ml/min/1,73&nbsp;m² gefallen. Der Eingriff, der noch Sinn hat, SGLT2-Hemmer, RAAS-Blockade und eine Änderung der Lebensweise, hätte Monate oder Jahre früher kommen müssen.</p>
<p>Deshalb haben wir die aktuellen Empfehlungen von KDIGO und ESH in einen Algorithmus gefasst, den die Hausärztin oder der Hausarzt in einer Routinekonsultation nutzen kann. Wann screenen. Wann überweisen. Wann die Pharmakotherapie noch vor der Überweisung beginnen.</p>
<p>Der Algorithmus fügt kein neues Wissen hinzu. Das ist Absicht. Das Wissen ist da. Es fehlt bei denen, die den Patienten zuerst sehen, nicht erst in der nephrologischen Ambulanz.</p>
<p>Wenn Sie in einem Fachgebiet arbeiten: Welche einzelne Sache aus Ihrem Wissen würde die Praxis morgen am stärksten verändern, wenn sie die Hausärztinnen und Hausärzte erreichte?</p>
<p><em>Das ist ein Begleittext zu einem Manuskript, kein Ersatz der Originalempfehlungen von KDIGO und ESH und keine Behandlungsentscheidung für einen einzelnen Patienten.</em></p>
HTML,
        ],
        'fr' => [
            'title' => 'La maladie rénale se dépiste trop tard, parce que les recommandations n\'atteignent pas les médecins qui voient les patients en premier.',
            'image_alt' => 'Consultation de médecine générale : la mesure de la tension au premier plan, un sablier rénal dont le temps s\'écoule.',
            'excerpt' => 'Avec une rédactrice chez SOLEN, j\'ai achevé un manuscrit pour Via practica : un algorithme pour les médecins de premier recours slovaques, qui transforme KDIGO et ESH en décision de consultation : quand dépister, quand adresser, quand traiter avant l\'adressage.',
            'content' => <<<'HTML'
<p>Cette semaine, j'ai achevé un manuscrit avec une rédactrice chez SOLEN, pour la revue <a href="https://www.solen.sk/en/journals/via-practica">Via practica</a>. Titre : <em>Hypertenzia a obličky: nové odporúčania a algoritmus pre VLD</em>. VLD désigne les médecins de premier recours pour adultes en Slovaquie.</p>
<p>Les recommandations de néphrologie sont écrites par des néphrologues, pour des néphrologues. Le patient chez qui une maladie rénale chronique va se développer n'entre pas d'abord dans une consultation de néphrologie. Il entre chez son médecin de famille avec une hypertension.</p>
<p>Quand il arrive jusqu'à moi, le DFGe est souvent déjà tombé sous 60&nbsp;ml/min/1,73&nbsp;m². L'intervention qui a encore un sens, inhibiteurs du SGLT2, blocage du SRAA et changement des habitudes, aurait dû venir des mois ou des années plus tôt.</p>
<p>Nous avons donc rassemblé les recommandations actuelles de KDIGO et de l'ESH dans un algorithme qu'un médecin de premier recours peut suivre pendant une consultation ordinaire. Quand dépister. Quand adresser. Quand commencer une pharmacothérapie avant l'adressage.</p>
<p>L'algorithme n'ajoute pas de connaissance nouvelle. C'est voulu. La connaissance existe. Elle manque chez le médecin qui voit le patient au début, pas seulement au cabinet de néphrologie.</p>
<p>Si vous travaillez dans une spécialité : quelle chose, une seule, de votre savoir changerait le plus la pratique demain, si elle parvenait aux médecins de premier recours ?</p>
<p><em>Il s'agit d'un texte d'accompagnement d'un manuscrit, non d'un substitut aux recommandations originales de KDIGO et de l'ESH, ni d'une décision thérapeutique pour un patient donné.</em></p>
HTML,
        ],
        'es' => [
            'title' => 'La enfermedad renal se detecta demasiado tarde porque las guías no llegan a los médicos que ven al paciente primero.',
            'image_alt' => 'Consulta de atención primaria: medición de la presión en primer plano y un reloj de arena renal cuyo tiempo se acaba.',
            'excerpt' => 'Con una editora de SOLEN, cerré un manuscrito para Via practica: un algoritmo para médicos de familia eslovacos que convierte KDIGO y ESH en una consulta rutinaria: cuándo cribar, cuándo derivar, cuándo tratar antes de la derivación.',
            'content' => <<<'HTML'
<p>Esta semana cerré un manuscrito con una editora de SOLEN, para la revista <a href="https://www.solen.sk/en/journals/via-practica">Via practica</a>. Título: <em>Hypertenzia a obličky: nové odporúčania a algoritmus pre VLD</em>. VLD son los médicos de atención primaria de adultos en Eslovaquia.</p>
<p>Las recomendaciones de nefrología las escriben nefrólogos para nefrólogos. El paciente en el que se desarrollará una enfermedad renal crónica no entra primero en una consulta de nefrología. Entra en la de su médico de familia con hipertensión.</p>
<p>Cuando llega a mí, el TFGe a menudo ya ha bajado de 60&nbsp;ml/min/1,73&nbsp;m². La intervención que todavía tiene sentido, inhibidores de SGLT2, bloqueo del SRAA y un cambio de hábitos, tenía que haber llegado meses o años antes.</p>
<p>Por eso reunimos las recomendaciones actuales de KDIGO y ESH en un algoritmo que un médico de familia puede usar en una consulta ordinaria. Cuándo cribar. Cuándo derivar. Cuándo iniciar la farmacoterapia antes de la derivación.</p>
<p>El algoritmo no añade conocimiento nuevo. Esa es la intención. El conocimiento existe. Falta en el médico que ve al paciente al principio, no solo en la consulta de nefrología.</p>
<p>Si trabaja en una especialidad: ¿qué cosa, una sola, de su conocimiento cambiaría más la práctica mañana si llegara a los médicos de atención primaria?</p>
<p><em>Es un texto de acompañamiento de un manuscrito, no un sustituto de las recomendaciones originales de KDIGO y ESH ni una decisión terapéutica para un paciente concreto.</em></p>
HTML,
        ],
        'pl' => [
            'title' => 'Chorobę nerek wychwytujemy za późno, bo wytyczne nie docierają do lekarzy, którzy pacjenta widzą jako pierwsi.',
            'image_alt' => 'Poradnia lekarza rodzinnego: pomiar ciśnienia na pierwszym planie, w klepsydrze ucieka czas nerek.',
            'excerpt' => 'Z redaktorką wydawnictwa SOLEN dokończyliśmy rękopis dla Via practica: algorytm dla lekarzy rodzinnych, jak z KDIGO i ESH zrobić decyzję w zwykłej poradni: kiedy przesiew, kiedy skierować, kiedy zacząć leczenie jeszcze przed skierowaniem.',
            'content' => <<<'HTML'
<p>W tym tygodniu z redaktorką wydawnictwa SOLEN dokończyłem rękopis dla czasopisma <a href="https://www.solen.sk/en/journals/via-practica">Via practica</a>. Tytuł: <em>Hypertenzia a obličky: nové odporúčania a algoritmus pre VLD</em>. VLD to lekarze rodzinni dla dorosłych na Słowacji.</p>
<p>Zalecenia nefrologiczne piszą nefrolodzy dla nefrologów. Pacjent, u którego rozwinie się przewlekła choroba nerek, nie przychodzi jednak najpierw do poradni nefrologicznej. Przychodzi do swojego lekarza rodzinnego z nadciśnieniem.</p>
<p>Zanim dotrze do mnie, eGFR często już spadł poniżej 60&nbsp;ml/min/1,73&nbsp;m². Interwencja, która jeszcze ma sens, inhibitory SGLT2, blokada RAAS i zmiana codziennych nawyków, powinna była przyjść miesiące albo lata wcześniej.</p>
<p>Dlatego aktualne zalecenia KDIGO i ESH zebraliśmy w jeden algorytm, którego lekarz rodzinny może użyć podczas zwykłej konsultacji. Kiedy przesiewać. Kiedy kierować. Kiedy zacząć farmakoterapię jeszcze przed skierowaniem.</p>
<p>Algorytm nie dodaje nowej wiedzy. Taki jest zamysł. Wiedza jest. Brakuje jej u lekarza, który pacjenta widzi na początku, nie dopiero w poradni nefrologicznej.</p>
<p>Jeśli pracujecie w dziedzinie specjalistycznej: która jedna rzecz z waszej wiedzy najbardziej zmieniłaby praktykę jutro, gdyby trafiła do lekarzy rodzinnych?</p>
<p><em>To tekst towarzyszący rękopisowi, nie zastępstwo oryginalnych zaleceń KDIGO i ESH ani decyzja lecznicza wobec konkretnego pacjenta.</em></p>
HTML,
        ],
        'hu' => [
            'title' => 'A vesebetegséget későn ismerjük fel, mert az ajánlások nem jutnak el azokhoz az orvosokhoz, akik a beteget először látják.',
            'image_alt' => 'Háziorvosi rendelő: vérnyomásmérés az előtérben, a vese alakú homokórában fogy az idő.',
            'excerpt' => 'A SOLEN szerkesztőjével lezártuk a Via practica kéziratát: algoritmus háziorvosoknak, hogyan legyen a KDIGO és az ESH döntés a rendelőben: mikor szűrjünk, mikor utaljunk, mikor kezdjünk kezelést az utalás előtt.',
            'content' => <<<'HTML'
<p>Ezen a héten a SOLEN kiadó szerkesztőjével lezártam a <a href="https://www.solen.sk/en/journals/via-practica">Via practica</a> kéziratát. Cím: <em>Hypertenzia a obličky: nové odporúčania a algoritmus pre VLD</em>. A VLD Szlovákiában a felnőttek háziorvosait jelenti.</p>
<p>A nefrológiai ajánlásokat nefrológusok írják nefrológusoknak. A beteg, akinél krónikus vesebetegség alakul ki, nem a nefrológiai rendelőbe lép be először. Magas vérnyomással a háziorvosához megy.</p>
<p>Mire hozzám eljut, az eGFR gyakran már 60&nbsp;ml/min/1,73&nbsp;m² alá esett. A beavatkozásnak, amelynek még van értelme, az SGLT2-gátlóknak, a RAAS-blokádnak és az életmód rendezésének hónapokkal vagy évekkel korábban kellett volna jönnie.</p>
<p>Ezért a jelenlegi KDIGO- és ESH-ajánlásokat egyetlen algoritmusba foglaltuk, amelyet a háziorvos egy szokásos vizit alatt használhat. Mikor szűrjön. Mikor utaljon. Mikor kezdjen gyógyszeres kezelést még az utalás előtt.</p>
<p>Az algoritmus nem ad új ismeretet. Ez a szándék. Az ismeret megvan. Annál az orvosnál hiányzik, aki a beteget az elején látja, nem csak a nefrológiai rendelőben.</p>
<p>Ha szakorvosi területen dolgozik: tudásából melyik egyetlen dolog változtatná meg holnap a leginkább a gyakorlatot, ha eljutna a háziorvosokhoz?</p>
<p><em>Ez a kéziratot kísérő szöveg, nem a KDIGO és az ESH eredeti ajánlásainak helyettesítője, és nem kezelési döntés egy adott beteg számára.</em></p>
HTML,
        ],
        'it' => [
            'title' => 'La malattia renale si intercetta troppo tardi, perché le linee guida non arrivano ai medici che vedono il paziente per primi.',
            'image_alt' => 'Ambulatorio di medicina generale: misurazione della pressione in primo piano e una clessidra renale il cui tempo sta finendo.',
            'excerpt' => 'Con una redattrice di SOLEN, ho chiuso un manoscritto per Via practica: un algoritmo per i medici di famiglia slovacchi che trasforma KDIGO ed ESH in una visita di routine: quando fare screening, quando inviare, quando trattare prima dell\'invio.',
            'content' => <<<'HTML'
<p>Questa settimana ho chiuso un manoscritto con una redattrice della casa editrice SOLEN, per la rivista <a href="https://www.solen.sk/en/journals/via-practica">Via practica</a>. Titolo: <em>Hypertenzia a obličky: nové odporúčania a algoritmus pre VLD</em>. I VLD sono i medici di medicina generale per adulti in Slovacchia.</p>
<p>Le raccomandazioni nefrologiche le scrivono i nefrologi per i nefrologi. Il paziente in cui si svilupperà una malattia renale cronica non entra prima in un ambulatorio di nefrologia. Entra dal medico di famiglia con la pressione alta.</p>
<p>Quando arriva da me, l'eGFR è spesso già sceso sotto 60&nbsp;ml/min/1,73&nbsp;m². L'intervento che ha ancora un senso, inibitori SGLT2, blocco del RAAS e un cambiamento delle abitudini, doveva arrivare mesi o anni prima.</p>
<p>Perciò abbiamo raccolto le raccomandazioni attuali di KDIGO e dell'ESH in un unico algoritmo che il medico di famiglia può usare durante una visita ordinaria. Quando fare lo screening. Quando inviare. Quando iniziare la farmacoterapia prima dell'invio.</p>
<p>L'algoritmo non aggiunge conoscenza nuova. Questo è lo scopo. La conoscenza c'è. Manca dal medico che vede il paziente all'inizio, non solo nell'ambulatorio di nefrologia.</p>
<p>Se lavorate in una specialità: quale singola cosa del vostro sapere cambierebbe di più la pratica domani, se arrivasse ai medici di famiglia?</p>
<p><em>È un testo di accompagnamento a un manoscritto, non un sostituto delle raccomandazioni originali di KDIGO e dell'ESH né una decisione terapeutica per un paziente concreto.</em></p>
HTML,
        ],
        'uk' => [
            'title' => 'Хворобу нирок виявляємо запізно, бо настанови не доходять до лікарів, які бачать пацієнта першими.',
            'image_alt' => 'Кабінет сімейного лікаря: вимірювання тиску на передньому плані, у пісковому годиннику спливає час нирок.',
            'excerpt' => 'З редакторкою видавництва SOLEN ми завершили рукопис для Via practica: алгоритм для сімейних лікарів, як із KDIGO та ESH зробити рішення на звичайному прийомі: коли скринінг, коли скерувати, коли почати лікування ще до скерування.',
            'content' => <<<'HTML'
<p>Цього тижня я з редакторкою видавництва SOLEN завершив рукопис для журналу <a href="https://www.solen.sk/en/journals/via-practica">Via practica</a>. Назва: <em>Hypertenzia a obličky: nové odporúčania a algoritmus pre VLD</em>. VLD позначає сімейних лікарів для дорослих у Словаччині.</p>
<p>Нефрологічні настанови пишуть нефрологи для нефрологів. Пацієнт, у якого розвинеться хронічна хвороба нирок, не заходить спочатку до нефрологічного кабінету. Він іде до свого сімейного лікаря з високим тиском.</p>
<p>Поки він доходить до мене, eGFR часто вже впала нижче 60&nbsp;мл/хв/1,73&nbsp;м². Втручання, яке ще має сенс, інгібітори SGLT2, блокада RAAS і зміна щоденних звичок, мало прийти місяцями чи роками раніше.</p>
<p>Тому чинні настанови KDIGO та ESH ми зібрали в один алгоритм, яким сімейний лікар може скористатися під час звичайного прийому. Коли скринінг. Коли скерувати. Коли почати фармакотерапію ще до скерування.</p>
<p>Алгоритм не додає нового знання. Такий задум. Знання є. Його бракує в лікаря, який бачить пацієнта на початку, а не лише в нефрологічному кабінеті.</p>
<p>Якщо ви працюєте у вузькій спеціальності: яка одна річ із вашого знання завтра найбільше змінила б практику, якби дійшла до сімейних лікарів?</p>
<p><em>Це супровідний текст до рукопису, а не заміна оригінальних настанов KDIGO та ESH і не лікувальне рішення щодо конкретного пацієнта.</em></p>
HTML,
        ],
    ],
];
