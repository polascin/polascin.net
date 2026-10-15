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
 * Osobná zmena pravidiel hlásení z 13. októbra 2026, 14:58 CEST.
 * Zdroj: pokyny v rozhovoroch WebSites a AI-subscription.
 * Obe odpovede nechali denné kontroly a bežné hlásenie presunuli na týždeň.
 * Sledovanie webov pokrýva 14 properties. Úžitok ešte nie je zmeraný.
 */
return [
    'slug' => 'menej-hlaseni-nie-menej-prace',
    'author' => 'MUDr. Ľubomír Polaščín',
    'category' => 'blog',
    'is_top' => 0,
    'published_at' => '2026-10-15 17:40:00',
    'image' => 'images/articles/menej-hlaseni-nie-menej-prace.webp',
    'translations' => [
        'sk' => [
            'title' => 'Menej hlásení. Nie menej práce.',
            'image_alt' => 'Muž od chrbta sedí pri tmavom stole v noci. Pred ním leží hrubý zväzok listov v tyrkysovom svetle a bokom od neho svieti jedna fialová obálka. Vzadu sú dva rady prázdnych obrazoviek v tyrkysovej a fialovej.',
            'excerpt' => '13. októbra 2026 som zmenil pravidlá hlásení pri sledovaní webov a predplatných na umelú inteligenciu. Kontroly ostávajú denné. Bežná správa ide raz za týždeň, hneď len keď je dôvod konať. Celý týždeň v novom rytme ešte nemám, takže úžitok zatiaľ neposudzujem.',
            'content' => <<<'HTML'
<p>13. októbra 2026 som zmenil pravidlá hlásení pri niekoľkých sledovaniach. Medzi ne patria kontrola webov aj predplatné na služby umelej inteligencie. Pokyn bol krátky: týždenná správa, alebo prerušenie, keď sa objaví niečo výnimočne dôležité.</p>
<p>Webov v tej kontrole je štrnásť. Denný e-mail z nej vie byť podrobný a presný. Rozhodnutie na dnešok v ňom byť nemusí.</p>
<p>Dovtedy som nechával splývať tri úlohy. Kontrola má bežať pravidelne, v tom istom rytme ako doteraz. Bežné zistenia patria do jedného týždenného prehľadu. Okamžitú správu si nechávam na udalosť, pri ktorej mám odísť od inej práce.</p>
<p>Denné kontroly bežia ďalej. Bežný denný e-mail z nich už nie.</p>
<p>Celý týždeň v novom rytme ešte nemám, a tak úžitok zatiaľ neposudzujem.</p>
<p>Po zmene je jasnejšie, čo od agenta chcem. Nemá poslať správu len preto, že práve skončil svoju úlohu. Má oddeliť bežnú informáciu od dôvodu, pre ktorý ma má odtiahnúť od niečoho iného.</p>
<p>Automatizácia má znížiť počet chvíľ, keď odchádzam od rozrobenej veci.</p>
<p>Čo si vo vašom postupe zaslúži správu hneď?</p>
<p><em>Osobná zmena pravidla pri vlastných kontrolách. Úžitok zatiaľ nie je zmeraný a text neodporúča konkrétny nástroj.</em></p>

HTML,
        ],
        'en' => [
            'title' => 'Fewer reports. Not less work.',
            'image_alt' => 'A man seen from behind sits at a dark desk at night. A thick stack of pages glows teal in front of him, and one violet envelope shines apart from it. Two rows of blank screens glow teal and violet behind him.',
            'excerpt' => 'On 13 October 2026 I changed the reporting rules for website monitoring and for subscriptions to artificial-intelligence services. The checks stay daily. An ordinary report goes out once a week, and at once only when there is a reason to act. I have not had a full week on the new rhythm, so I am not judging the benefit yet.',
            'content' => <<<'HTML'
<p>On 13 October 2026 I changed the reporting rules for several checks that already run. Among them are the check on my websites and the subscriptions to artificial-intelligence services. The instruction was short: a weekly report, or an interruption when something exceptionally important appears.</p>
<p>That website check covers fourteen sites. A daily email from it can be detailed and accurate. It does not have to hold a decision for today.</p>
<p>Until then I had let three jobs blur together. The check should keep running on the same rhythm as before. Ordinary findings belong in one weekly review. I keep the immediate message for an event that means leaving other work.</p>
<p>The daily checks still run. The ordinary daily email from them does not.</p>
<p>I have not had a full week on the new rhythm, so I am not judging the benefit yet.</p>
<p>What I want from the agent is clearer after the change. It should not send a report merely because it has finished its run. It should separate routine information from a reason to pull me away from something else.</p>
<p>Automation should cut the number of times I leave work that is already under way.</p>
<p>What earns an immediate message in your own workflow?</p>
<p><em>A personal change of rules for my own checks. The benefit is not measured yet, and the text recommends no particular tool.</em></p>

HTML,
        ],
        'cs' => [
            'title' => 'Méně zpráv. Ne méně práce.',
            'image_alt' => 'Muž zády k nám sedí u tmavého stolu v noci. Před ním leží silný svazek listů v tyrkysovém světle a stranou od něj svítí jedna fialová obálka. Vzadu jsou dvě řady prázdných obrazovek v tyrkysové a fialové.',
            'excerpt' => '13. října 2026 jsem změnil pravidla zpráv u sledování webů a u předplatného služeb umělé inteligence. Kontroly zůstávají denní. Běžná zpráva jde jednou týdně, hned jen když je důvod jednat. Celý týden v novém rytmu ještě nemám, takže přínos zatím neposuzuji.',
            'content' => <<<'HTML'
<p>13. října 2026 jsem změnil pravidla zpráv u několika sledování. Patří mezi ně kontrola webů i předplatné služeb umělé inteligence. Pokyn byl krátký: týdenní zpráva, nebo přerušení, když se objeví něco výjimečně důležitého.</p>
<p>Webů v té kontrole je čtrnáct. Denní e-mail z ní může být podrobný a přesný. Rozhodnutí na dnešek v něm být nemusí.</p>
<p>Do té doby jsem nechával splývat tři úkoly. Kontrola má běžet pravidelně, ve stejném rytmu jako dosud. Běžná zjištění patří do jednoho týdenního přehledu. Okamžitou zprávu si nechávám na událost, při které mám odejít od jiné práce.</p>
<p>Denní kontroly běží dál. Běžný denní e-mail z nich už ne.</p>
<p>Celý týden v novém rytmu ještě nemám, a tak přínos zatím neposuzuji.</p>
<p>Po změně je jasnější, co od agenta chci. Nemá poslat zprávu jen proto, že právě dokončil svůj úkol. Má oddělit běžnou informaci od důvodu, pro který mě má odvést od něčeho jiného.</p>
<p>Automatizace má snížit počet chvil, kdy odcházím od rozdělané věci.</p>
<p>Co si ve vašem postupu zaslouží zprávu hned?</p>
<p><em>Osobní změna pravidla u vlastních kontrol. Přínos zatím není změřený a text nedoporučuje konkrétní nástroj.</em></p>

HTML,
        ],
        'de' => [
            'title' => 'Weniger Berichte. Nicht weniger Arbeit.',
            'image_alt' => 'Ein Mann von hinten sitzt nachts an einem dunklen Tisch. Vor ihm liegt ein dicker Stapel Blätter in türkisem Licht, daneben leuchtet ein einzelner violetter Umschlag. Hinten zwei Reihen leerer Bildschirme in Türkis und Violett.',
            'excerpt' => 'Am 13. Oktober 2026 habe ich die Melderegeln für die Überwachung der Websites und für Abonnements von Diensten der künstlichen Intelligenz geändert. Die Kontrollen bleiben täglich. Ein gewöhnlicher Bericht geht einmal in der Woche hinaus, sofort nur, wenn es einen Grund zum Handeln gibt. Eine volle Woche im neuen Takt habe ich noch nicht, deshalb beurteile ich den Nutzen noch nicht.',
            'content' => <<<'HTML'
<p>Am 13. Oktober 2026 habe ich die Regeln für Meldungen bei mehreren Überwachungen geändert. Dazu gehören die Kontrolle meiner Websites und die Abonnements für Dienste der künstlichen Intelligenz. Die Anweisung war kurz: ein Wochenbericht, oder eine Unterbrechung, wenn etwas außergewöhnlich Wichtiges auftaucht.</p>
<p>Diese Kontrolle umfasst vierzehn Websites. Eine tägliche E-Mail daraus kann ausführlich und genau sein. Eine Entscheidung für heute muss nicht darin stehen.</p>
<p>Bis dahin hatte ich drei Aufgaben ineinanderlaufen lassen. Die Kontrolle soll regelmäßig weiterlaufen, im selben Takt wie bisher. Gewöhnliche Ergebnisse gehören in eine wöchentliche Übersicht. Die sofortige Nachricht bleibt einem Ereignis vorbehalten, bei dem ich andere Arbeit verlassen muss.</p>
<p>Die täglichen Kontrollen laufen weiter. Die gewöhnliche tägliche E-Mail daraus nicht mehr.</p>
<p>Eine volle Woche im neuen Takt habe ich noch nicht, deshalb beurteile ich den Nutzen noch nicht.</p>
<p>Nach der Änderung ist klarer, was ich vom Agenten will. Er soll nicht nur deshalb einen Bericht schicken, weil er seine Aufgabe gerade beendet hat. Er soll eine gewöhnliche Information von einem Grund trennen, der mich von etwas anderem wegzieht.</p>
<p>Automatisierung soll die Zahl der Momente senken, in denen ich von einer angefangenen Sache weggehe.</p>
<p>Was verdient in Ihrem Ablauf eine Nachricht sofort?</p>
<p><em>Eine persönliche Regeländerung bei eigenen Kontrollen. Der Nutzen ist noch nicht gemessen, und der Text empfiehlt kein bestimmtes Werkzeug.</em></p>

HTML,
        ],
        'fr' => [
            'title' => 'Moins de rapports. Pas moins de travail.',
            'image_alt' => 'Un homme vu de dos est assis la nuit à un bureau sombre. Devant lui, une épaisse liasse de feuilles luit en turquoise, et à l’écart brille une enveloppe violette. Derrière, deux rangées d’écrans vides luisent en turquoise et en violet.',
            'excerpt' => 'Le 13 octobre 2026, j’ai changé les règles de signalement pour la surveillance des sites et pour les abonnements à l’intelligence artificielle. Les contrôles restent quotidiens. Le rapport ordinaire part une fois par semaine, et tout de suite seulement lorsqu’il y a une raison d’agir. Je n’ai pas encore une semaine entière sur le nouveau rythme, et je ne juge donc pas encore le bénéfice.',
            'content' => <<<'HTML'
<p>Le 13 octobre 2026, j’ai changé les règles de signalement de plusieurs surveillances. Il s’agit notamment du contrôle de mes sites et des abonnements à des services d’intelligence artificielle. La consigne était courte : un rapport hebdomadaire, ou une interruption quand apparaît quelque chose d’exceptionnellement important.</p>
<p>Ce contrôle de sites en couvre quatorze. L’e-mail quotidien qui en sort peut être détaillé et exact. Il n’a pas à contenir une décision pour aujourd’hui.</p>
<p>Jusque-là, je laissais trois tâches se confondre. Le contrôle doit continuer au même rythme qu’avant. Les constats ordinaires vont dans une seule revue hebdomadaire. Je garde le message immédiat pour un événement qui me fait quitter un autre travail.</p>
<p>Les contrôles quotidiens continuent. L’e-mail quotidien ordinaire, non.</p>
<p>Je n’ai pas encore une semaine entière sur le nouveau rythme, et je ne juge donc pas encore le bénéfice.</p>
<p>Après le changement, ce que j’attends de l’agent est plus clair. Il ne doit pas envoyer un rapport seulement parce qu’il vient de finir sa tâche. Il doit séparer une information ordinaire d’une raison de m’éloigner d’autre chose.</p>
<p>L’automatisation doit réduire le nombre de fois où je quitte un travail déjà en cours.</p>
<p>Qu’est-ce qui, dans votre circuit, mérite un message tout de suite ?</p>
<p><em>Changement personnel de règle pour mes propres contrôles. Le bénéfice n’est pas encore mesuré, et le texte ne recommande aucun outil particulier.</em></p>

HTML,
        ],
        'es' => [
            'title' => 'Menos informes. No menos trabajo.',
            'image_alt' => 'Un hombre de espaldas se sienta de noche ante un escritorio oscuro. Delante hay un fajo grueso de hojas en luz turquesa y, aparte, brilla un sobre violeta. Detrás, dos filas de pantallas vacías en turquesa y violeta.',
            'excerpt' => 'El 13 de octubre de 2026 cambié las reglas de los informes para la vigilancia de los sitios y para las suscripciones a servicios de inteligencia artificial. Los controles siguen siendo diarios. El informe ordinario sale una vez por semana, y de inmediato solo cuando hay un motivo para actuar. Aún no llevo una semana entera con el nuevo ritmo, así que todavía no valoro el beneficio.',
            'content' => <<<'HTML'
<p>El 13 de octubre de 2026 cambié las reglas de los informes de varias vigilancias. Entre ellas están el control de mis sitios y las suscripciones a servicios de inteligencia artificial. La instrucción fue breve: un informe semanal, o una interrupción cuando aparece algo excepcionalmente importante.</p>
<p>Ese control cubre catorce sitios. El correo diario que sale de él puede ser detallado y exacto. No tiene que contener una decisión para hoy.</p>
<p>Hasta entonces dejaba que tres tareas se confundieran. El control debe seguir al mismo ritmo de antes. Los hallazgos ordinarios van a una sola revisión semanal. El mensaje inmediato lo reservo para un suceso que me obliga a dejar otro trabajo.</p>
<p>Los controles diarios siguen. El correo diario ordinario, no.</p>
<p>Aún no llevo una semana entera con el nuevo ritmo, así que todavía no valoro el beneficio.</p>
<p>Tras el cambio está más claro lo que quiero del agente. No debe enviar un informe solo porque acaba de terminar su tarea. Debe separar una información ordinaria de un motivo para apartarme de otra cosa.</p>
<p>La automatización debe reducir las veces que dejo un trabajo ya empezado.</p>
<p>¿Qué merece, en su procedimiento, un mensaje de inmediato?</p>
<p><em>Un cambio personal de regla en mis propios controles. El beneficio aún no está medido y el texto no recomienda ninguna herramienta concreta.</em></p>

HTML,
        ],
        'pl' => [
            'title' => 'Mniej raportów. Nie mniej pracy.',
            'image_alt' => 'Mężczyzna od tyłu siedzi w nocy przy ciemnym biurku. Przed nim leży gruby plik kartek w turkusowym świetle, a z boku świeci jedna fioletowa koperta. Z tyłu dwa rzędy pustych ekranów w turkusie i fiolecie.',
            'excerpt' => '13 października 2026 zmieniłem zasady raportów przy śledzeniu witryn i przy subskrypcjach usług sztucznej inteligencji. Kontrole zostają codzienne. Zwykły raport idzie raz w tygodniu, od razu tylko wtedy, gdy jest powód, by działać. Nie mam jeszcze pełnego tygodnia w nowym rytmie, więc korzyści na razie nie oceniam.',
            'content' => <<<'HTML'
<p>13 października 2026 zmieniłem zasady raportów przy kilku śledzeniach. Należy do nich kontrola witryn i subskrypcje usług sztucznej inteligencji. Polecenie było krótkie: raport tygodniowy albo przerwanie, gdy pojawi się coś wyjątkowo ważnego.</p>
<p>W tej kontroli jest czternaście witryn. Codzienny e-mail z niej może być szczegółowy i dokładny. Decyzja na dziś nie musi w nim być.</p>
<p>Do tamtej pory pozwalałem, by trzy zadania zlewały się w jedno. Kontrola ma iść dalej w tym samym rytmie co dotąd. Zwykłe ustalenia trafiają do jednego tygodniowego przeglądu. Natychmiastową wiadomość zostawiam na zdarzenie, przy którym mam odejść od innej pracy.</p>
<p>Codzienne kontrole idą dalej. Zwykły codzienny e-mail z nich już nie.</p>
<p>Nie mam jeszcze pełnego tygodnia w nowym rytmie, więc korzyści na razie nie oceniam.</p>
<p>Po zmianie jest jaśniejsze, czego chcę od agenta. Nie ma wysyłać raportu tylko dlatego, że właśnie skończył swoje zadanie. Ma oddzielić zwykłą informację od powodu, dla którego ma mnie oderwać od czegoś innego.</p>
<p>Automatyzacja ma zmniejszyć liczbę chwil, w których odchodzę od pracy już zaczętej.</p>
<p>Co w twoim toku pracy zasługuje na wiadomość od razu?</p>
<p><em>Osobista zmiana zasady przy własnych kontrolach. Korzyści jeszcze nie zmierzono, a tekst nie poleca konkretnego narzędzia.</em></p>

HTML,
        ],
        'hu' => [
            'title' => 'Kevesebb jelentés. Nem kevesebb munka.',
            'image_alt' => 'Egy férfi hátulról ül éjjel egy sötét asztalnál. Előtte vastag köteg lap türkiz fényben, tőle külön egy lila boríték világít. Hátul két sor üres képernyő türkizben és lilában.',
            'excerpt' => '2026. október 13-án megváltoztattam a jelentések szabályait a webhelyek figyelésénél és a mesterséges intelligencia szolgáltatásaira szóló előfizetéseknél. Az ellenőrzések napiak maradnak. A szokásos jelentés hetente egyszer megy ki, azonnal csak akkor, ha van ok a cselekvésre. Egy teljes hét az új ritmusban még nincs mögöttem, ezért a hasznot egyelőre nem mérem.',
            'content' => <<<'HTML'
<p>2026. október 13-án megváltoztattam a jelentések szabályait néhány figyelésnél. Közéjük tartozik a webhelyeim ellenőrzése és az előfizetés a mesterséges intelligencia szolgáltatásaira. Az utasítás rövid volt: heti jelentés, vagy megszakítás, ha valami kivételesen fontos jelenik meg.</p>
<p>Ebben az ellenőrzésben tizennégy webhely van. A napi e-mail, amely kijön belőle, lehet részletes és pontos. Döntésnek a mai napra nem kell benne lennie.</p>
<p>Addig három feladatot hagytam egybemosódni. Az ellenőrzésnek ugyanabban a ritmusban kell futnia, mint eddig. A szokásos megállapítások egyetlen heti áttekintésbe kerülnek. Az azonnali üzenetet olyan eseményre tartom, amikor más munkát kell otthagynom.</p>
<p>A napi ellenőrzések tovább futnak. A szokásos napi e-mail belőlük már nem.</p>
<p>Egy teljes hét az új ritmusban még nincs mögöttem, ezért a hasznot egyelőre nem mérem.</p>
<p>A változás után világosabb, mit várok az ügynöktől. Ne csak azért küldjön jelentést, mert éppen végzett a feladatával. A szokásos információt válassza el attól az októl, amely miatt félbe kell szakítania azt, amin éppen dolgozom.</p>
<p>Az automatizálás csökkentse azoknak az alkalmaknak a számát, amikor otthagyok egy már megkezdett munkát.</p>
<p>Nálad mi érdemel azonnali üzenetet?</p>
<p><em>Személyes szabályváltozás a saját ellenőrzéseimnél. A haszon még nincs megmérve, és a szöveg nem ajánl konkrét eszközt.</em></p>

HTML,
        ],
        'it' => [
            'title' => 'Meno resoconti. Non meno lavoro.',
            'image_alt' => 'Un uomo di spalle siede di notte a una scrivania scura. Davanti a lui un fascio spesso di fogli brilla in turchese e, discosta, una busta viola. Dietro, due file di schermi vuoti in turchese e viola.',
            'excerpt' => 'Il 13 ottobre 2026 ho cambiato le regole dei resoconti per il controllo dei siti e per gli abbonamenti ai servizi di intelligenza artificiale. I controlli restano quotidiani. Il resoconto ordinario esce una volta alla settimana, e subito solo quando c’è un motivo per agire. Non ho ancora una settimana intera sul nuovo ritmo, quindi non valuto ancora il beneficio.',
            'content' => <<<'HTML'
<p>Il 13 ottobre 2026 ho cambiato le regole dei resoconti per alcuni controlli. Tra questi ci sono il controllo dei miei siti e gli abbonamenti ai servizi di intelligenza artificiale. L’istruzione era breve: un resoconto settimanale, oppure un’interruzione quando compare qualcosa di eccezionalmente importante.</p>
<p>In quel controllo i siti sono quattordici. L’e-mail quotidiana che ne esce può essere dettagliata e precisa. Non deve contenere una decisione per oggi.</p>
<p>Fino ad allora lasciavo che tre compiti si confondessero. Il controllo deve continuare con lo stesso ritmo di prima. I rilievi ordinari vanno in un solo riepilogo settimanale. Il messaggio immediato lo tengo per un evento per il quale devo lasciare un altro lavoro.</p>
<p>I controlli quotidiani continuano. L’e-mail quotidiana ordinaria no.</p>
<p>Non ho ancora una settimana intera sul nuovo ritmo, quindi non valuto ancora il beneficio.</p>
<p>Dopo il cambiamento è più chiaro che cosa voglio dall’agente. Non deve inviare un resoconto solo perché ha appena finito il suo compito. Deve separare un’informazione ordinaria da un motivo per distogliermi da qualcos’altro.</p>
<p>L’automazione deve ridurre le volte in cui lascio un lavoro già avviato.</p>
<p>Che cosa, nel tuo procedimento, merita un messaggio subito?</p>
<p><em>Un cambiamento personale di regola per i miei controlli. Il beneficio non è ancora misurato e il testo non consiglia uno strumento particolare.</em></p>

HTML,
        ],
        'uk' => [
            'title' => 'Менше звітів. Не менше роботи.',
            'image_alt' => 'Чоловік зі спини сидить уночі за темним столом. Перед ним товста тека аркушів у бірюзовому світлі, а осторонь світиться один фіолетовий конверт. Позаду два ряди порожніх екранів у бірюзі й фіолеті.',
            'excerpt' => '13 жовтня 2026 року я змінив правила звітів для спостереження за сайтами і для передплат на сервіси штучного інтелекту. Перевірки лишаються щоденними. Звичайний звіт виходить раз на тиждень, і одразу лише тоді, коли є причина діяти. Повного тижня в новому ритмі ще не маю, тож користь поки що не оцінюю.',
            'content' => <<<'HTML'
<p>13 жовтня 2026 року я змінив правила звітів для кількох спостережень. Серед них перевірка моїх сайтів і передплати на сервіси штучного інтелекту. Вказівка була коротка: тижневий звіт або переривання, коли з’являється щось винятково важливе.</p>
<p>У цій перевірці чотирнадцять сайтів. Щоденний електронний лист із неї може бути докладним і точним. Рішення на сьогодні в ньому не мусить бути.</p>
<p>Доти я дозволяв трьом завданням зливатися. Перевірка має йти далі в тому самому ритмі, що й раніше. Звичайні висновки належать до одного тижневого огляду. Негайне повідомлення лишаю для події, через яку треба відійти від іншої роботи.</p>
<p>Щоденні перевірки тривають. Звичайний щоденний лист із них уже ні.</p>
<p>Повного тижня в новому ритмі ще не маю, тож користь поки що не оцінюю.</p>
<p>Після зміни ясніше, чого я хочу від агента. Він не має надсилати звіт лише тому, що щойно завершив своє завдання. Має відділити звичайну інформацію від причини, через яку мене треба відірвати від чогось іншого.</p>
<p>Автоматизація має зменшити кількість моментів, коли я відходжу від уже початої справи.</p>
<p>Що у вашій роботі заслуговує на повідомлення одразу?</p>
<p><em>Особиста зміна правила для власних перевірок. Користь ще не виміряна, і текст не радить конкретного інструмента.</em></p>

HTML,
        ],
    ],
];
