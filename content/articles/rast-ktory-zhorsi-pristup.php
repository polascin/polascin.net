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
 * Esej o raste siete odosielajúcich ambulancií bez kapacity:
 * viac odporúčaní môže zhoršiť prístup. Inšpirované anonymizovaným
 * posudkom nefrologického návrhu; bez identifikácie osôb, firiem a čísel.
 */
return [
    'slug' => 'rast-ktory-zhorsi-pristup',
    'author' => 'MUDr. Ľubomír Polaščín',
    'category' => 'blog',
    'is_top' => 0,
    'published_at' => '2026-11-14 09:55:00',
    'image' => 'images/articles/rast-ktory-zhorsi-pristup.webp',
    'translations' => [
        'sk' => [
            'title' => 'Rast, ktorý zhorší prístup',
            'image_alt' => 'Fialová chodba s radom anonymných siluet. Na konci otvorené dvere s ostrým tyrkysovým svetlom a tyrkysovými pruhmi svetla na podlahe.',
            'excerpt' => 'Väčšia sieť odosielajúcich ambulancií znie ako lepší prístup. Bez kapacity, personálu a správnych meradiel úspechu však môže kampaň skrátiť frontu pri dverách a predĺžiť ju všade inde.',
            'content' => <<<'HTML'
<p>Viac odporúčaní môže zhoršiť prístup.</p>
<p>Táto veta mi ostala v hlave pri posudzovaní návrhu na rast nefrologickej starostlivosti. Väčšia sieť odosielajúcich ambulancií znie ako samozrejmé zlepšenie: skoršia diagnóza, jednoduchší vstup, viac pacientov u špecialistu. V praxi však každé prvé vyšetrenie ťahá za sebou ďalšie. Kampaň, ktorá počíta len s príchodom, skráti frontu pri dverách a predĺži ju v kontrolách, vyšetreniach a dialyzačnom programe.</p>
<p>V písomnej odpovedi som preto žiadal posúdiť kapacitu, personál, čakacie lehoty a úhradu skôr, než sa sieť rozšíri. Bez týchto čísel nie je rast plán. Je to sľub, ktorý zaplatia ľudia už v systéme.</p>
<p>Namietal som aj meradlo úspechu. V starostlivosti o obličky nemôže úspech znamenať len viac pacientov alebo plnšie dialyzačné zmeny. Cieľom včasnej starostlivosti je aj predísť dialýze alebo ju oddialiť. Návrh preto potreboval ukazovatele vhodnosti odporúčaní, kontinuity, čakacích lehôt a pracovnej záťaže vedľa ekonomiky.</p>
<p>Odporučil som podmienený 90-dňový pilot, nie automatické zelené svetlo pre celý projekt. Pred každou rastovou iniciatívou v zdravotníctve chcem vedieť jedno: čo sa stane s pacientmi, ktorí už v systéme sú, keď kampaň naozaj zaberie?</p>
<p>Rast nie je lepší prístup, kým služba dokáže nápor vstrebať bez toho, aby zhoršila starostlivosť, ktorá už beží. Otvorené dvere nestačia, ak chodba za nimi neunesie frontu.</p>
<p><em>Ide o redakčnú úvahu o kapacite a meradlách rastu v zdravotníctve, nie o správu o konkrétnom projekte, pracovisku ani identifikovateľných osobách. Obchodné a osobné údaje sú vypustené alebo nahradené všeobecnými formuláciami.</em></p>

HTML,
        ],
        'en' => [
            'title' => 'Growth that makes access worse',
            'image_alt' => 'A violet corridor with a line of anonymous silhouettes. At the far end, an open doorway spills sharp teal light, with teal light ribbons along the floor.',
            'excerpt' => 'A larger network of referring clinics sounds like better access. Without capacity, staffing and the right success measures, a campaign can shorten the queue at the door and lengthen it everywhere else.',
            'content' => <<<'HTML'
<p>More referrals can make access worse.</p>
<p>That sentence stayed with me while reviewing a nephrology growth proposal. A larger network of referring clinics sounds like an obvious improvement: earlier diagnosis, an easier way in, more patients reaching specialist care. In practice every first appointment pulls follow-up with it. A campaign that counts only arrivals shortens the queue at the door and lengthens it in reviews, investigations and the dialysis programme.</p>
<p>In my written reply I therefore asked for capacity, staffing, waiting times and reimbursement to be assessed before the network expands. Without those figures, growth is not a plan. It is a promise paid for by people already inside the system.</p>
<p>I also challenged the success metric. In kidney care, success cannot mean only more patients or fuller dialysis shifts. Part of the purpose of earlier care is to prevent or delay dialysis. The proposal therefore needed measures of referral appropriateness, continuity, waiting times and workload alongside the economics.</p>
<p>My recommendation was a conditional 90-day pilot, not an automatic green light for the whole project. Before any healthcare growth initiative I want one answer: what happens to the patients already inside the system when the campaign actually works?</p>
<p>Growth is not better access until the service can absorb the surge without making existing care worse. An open door is not enough if the corridor behind it cannot carry the queue.</p>
<p><em>This is an editorial reflection on capacity and growth metrics in healthcare, not a report on a specific project, workplace or identifiable people. Commercial and personal details have been omitted or replaced with general wording.</em></p>

HTML,
        ],
        'cs' => [
            'title' => 'Růst, který zhorší přístup',
            'image_alt' => 'Fialová chodba s řadou anonymních siluet. Na konci otevřené dveře s ostrým tyrkysovým světlem a tyrkysovými pruhy světla na podlaze.',
            'excerpt' => 'Větší síť odesílajících ambulancí zní jako lepší přístup. Bez kapacity, personálu a správných měřítek úspěchu však může kampaň zkrátit frontu u dveří a prodloužit ji všude jinde.',
            'content' => <<<'HTML'
<p>Více doporučení může zhoršit přístup.</p>
<p>Tato věta mi zůstala v hlavě při posuzování návrhu na růst nefrologické péče. Větší síť odesílajících ambulancí zní jako samozřejmé zlepšení: dřívější diagnóza, jednodušší vstup, více pacientů u specialisty. V praxi však každé první vyšetření táhne za sebou další. Kampaň, která počítá jen s příchodem, zkrátí frontu u dveří a prodlouží ji v kontrolách, vyšetřeních a dialyzačním programu.</p>
<p>V písemné odpovědi jsem proto žádal posoudit kapacitu, personál, čekací lhůty a úhradu dříve, než se síť rozšíří. Bez těchto čísel není růst plán. Je to slib, který zaplatí lidé už v systému.</p>
<p>Namítal jsem i měřítko úspěchu. V péči o ledviny nemůže úspěch znamenat jen více pacientů nebo plnější dialyzační směny. Cílem včasné péče je i předejít dialýze nebo ji oddálit. Návrh proto potřeboval ukazatele vhodnosti doporučení, kontinuity, čekacích lhůt a pracovní zátěže vedle ekonomiky.</p>
<p>Doporučil jsem podmíněný 90denní pilot, ne automatické zelené světlo pro celý projekt. Před každou růstovou iniciativou ve zdravotnictví chci vědět jedno: co se stane s pacienty, kteří už v systému jsou, když kampaň opravdu zabere?</p>
<p>Růst není lepší přístup, dokud služba dokáže nápor vstřebat, aniž by zhoršila péči, která už běží. Otevřené dveře nestačí, pokud chodba za nimi neunese frontu.</p>
<p><em>Jde o redakční úvahu o kapacitě a měřítkách růstu ve zdravotnictví, ne o zprávu o konkrétním projektu, pracovišti ani identifikovatelných osobách. Obchodní a osobní údaje jsou vypuštěny nebo nahrazeny obecnými formulacemi.</em></p>

HTML,
        ],
        'de' => [
            'title' => 'Wachstum, das den Zugang verschlechtert',
            'image_alt' => 'Violetter Gang mit einer Reihe anonymer Silhouetten. Am Ende eine offene Tür mit scharfem Türkislicht und türkisen Lichtbändern auf dem Boden.',
            'excerpt' => 'Ein größeres Netz zuweisender Praxen klingt nach besserem Zugang. Ohne Kapazität, Personal und die richtigen Erfolgsmaße kann eine Kampagne die Warteschlange an der Tür verkürzen und sie überall sonst verlängern.',
            'content' => <<<'HTML'
<p>Mehr Überweisungen können den Zugang verschlechtern.</p>
<p>Dieser Satz blieb mir beim Prüfen eines Vorschlags zum Wachstum der nephrologischen Versorgung im Kopf. Ein größeres Netz zuweisender Praxen klingt nach einer offensichtlichen Verbesserung: frühere Diagnose, leichterer Einstieg, mehr Patientinnen und Patienten beim Spezialisten. In der Praxis zieht jeder Ersttermin Folgetermine nach sich. Eine Kampagne, die nur Ankünfte zählt, verkürzt die Warteschlange an der Tür und verlängert sie bei Kontrollen, Untersuchungen und im Dialyseprogramm.</p>
<p>In meiner schriftlichen Antwort bat ich deshalb, Kapazität, Personal, Wartezeiten und Vergütung zu prüfen, bevor das Netz wächst. Ohne diese Zahlen ist Wachstum kein Plan. Es ist ein Versprechen, das Menschen zahlen, die schon im System sind.</p>
<p>Ich habe auch die Erfolgsmessung infrage gestellt. In der Nierenversorgung kann Erfolg nicht nur mehr Patientinnen und Patienten oder vollere Dialyseschichten bedeuten. Frühe Versorgung soll Dialyse auch verhindern oder hinauszögern. Der Vorschlag brauchte deshalb Kennzahlen zur Angemessenheit der Überweisungen, zur Kontinuität, zu Wartezeiten und zur Arbeitslast neben der Ökonomie.</p>
<p>Meine Empfehlung war ein bedingter 90-Tage-Pilot, kein automatisches Grünlicht für das ganze Projekt. Vor jeder Wachstumsoffensive im Gesundheitswesen will ich eine Antwort: was geschieht mit den Menschen, die schon im System sind, wenn die Kampagne wirklich wirkt?</p>
<p>Wachstum ist kein besserer Zugang, solange der Dienst den Ansturm nicht aufnehmen kann, ohne die laufende Versorgung zu verschlechtern. Eine offene Tür reicht nicht, wenn der Gang dahinter die Warteschlange nicht trägt.</p>
<p><em>Dies ist eine redaktionelle Überlegung zu Kapazität und Wachstumsmaßen im Gesundheitswesen, kein Bericht über ein konkretes Projekt, einen Arbeitsplatz oder identifizierbare Personen. Geschäftliche und persönliche Angaben sind weggelassen oder durch allgemeine Formulierungen ersetzt.</em></p>

HTML,
        ],
        'fr' => [
            'title' => 'Une croissance qui détériore l’accès',
            'image_alt' => 'Couloir violet avec une file de silhouettes anonymes. Au fond, une porte ouverte déverse une lumière turquoise vive, avec des rubans de lumière turquoise sur le sol.',
            'excerpt' => 'Un plus grand réseau de cabinets adresseurs semble améliorer l’accès. Sans capacité, effectifs et bons indicateurs de réussite, une campagne peut raccourcir la file à la porte et l’allonger partout ailleurs.',
            'content' => <<<'HTML'
<p>Plus d’adressages peuvent détériorer l’accès.</p>
<p>Cette phrase m’est restée en tête en examinant une proposition de croissance des soins néphrologiques. Un plus grand réseau de cabinets adresseurs semble une amélioration évidente : diagnostic plus précoce, entrée plus simple, davantage de patients chez le spécialiste. En pratique, chaque première consultation entraîne un suivi. Une campagne qui ne compte que les arrivées raccourcit la file à la porte et l’allonge dans les contrôles, les examens et le programme de dialyse.</p>
<p>Dans ma réponse écrite, j’ai donc demandé d’évaluer la capacité, les effectifs, les délais d’attente et le remboursement avant d’élargir le réseau. Sans ces chiffres, la croissance n’est pas un plan. C’est une promesse payée par les personnes déjà dans le système.</p>
<p>J’ai aussi contesté l’indicateur de réussite. En néphrologie, la réussite ne peut pas signifier seulement plus de patients ou des séances de dialyse plus remplies. Une partie du sens des soins précoces est de prévenir ou de retarder la dialyse. La proposition devait donc inclure des mesures d’adéquation des adressages, de continuité, de délais d’attente et de charge de travail à côté de l’économie.</p>
<p>Ma recommandation était un pilote conditionnel de 90 jours, pas un feu vert automatique pour tout le projet. Avant toute initiative de croissance en santé, je veux une réponse : que devient-il des patients déjà dans le système lorsque la campagne fonctionne vraiment ?</p>
<p>La croissance n’est pas un meilleur accès tant que le service ne peut absorber l’afflux sans dégrader les soins déjà en cours. Une porte ouverte ne suffit pas si le couloir derrière elle ne porte pas la file.</p>
<p><em>Il s’agit d’une réflexion éditoriale sur la capacité et les indicateurs de croissance en santé, non d’un compte rendu sur un projet, un lieu de travail ou des personnes identifiables. Les détails commerciaux et personnels ont été omis ou remplacés par des formulations générales.</em></p>

HTML,
        ],
        'es' => [
            'title' => 'Un crecimiento que empeora el acceso',
            'image_alt' => 'Pasillo violeta con una fila de siluetas anónimas. Al fondo, una puerta abierta derrama luz turquesa intensa, con cintas de luz turquesa en el suelo.',
            'excerpt' => 'Una red mayor de consultas remisoras suena a mejor acceso. Sin capacidad, personal y medidas de éxito adecuadas, una campaña puede acortar la cola en la puerta y alargarla en todas partes.',
            'content' => <<<'HTML'
<p>Más derivaciones pueden empeorar el acceso.</p>
<p>Esa frase se me quedó al revisar una propuesta de crecimiento de la atención nefrológica. Una red mayor de consultas remisoras suena a una mejora obvia: diagnóstico más temprano, entrada más fácil, más pacientes en la consulta del especialista. En la práctica, cada primera cita arrastra seguimiento. Una campaña que solo cuenta llegadas acorta la cola en la puerta y la alarga en revisiones, pruebas y el programa de diálisis.</p>
<p>En mi respuesta escrita pedí por tanto valorar capacidad, personal, tiempos de espera y reembolso antes de ampliar la red. Sin esas cifras, el crecimiento no es un plan. Es una promesa que pagan quienes ya están dentro del sistema.</p>
<p>También cuestioné la métrica de éxito. En la atención renal, el éxito no puede significar solo más pacientes o turnos de diálisis más llenos. Parte del sentido de la atención temprana es prevenir o retrasar la diálisis. La propuesta necesitaba por tanto medidas de adecuación de las derivaciones, continuidad, tiempos de espera y carga de trabajo junto a la economía.</p>
<p>Mi recomendación fue un piloto condicional de 90 días, no luz verde automática para todo el proyecto. Antes de cualquier iniciativa de crecimiento en salud quiero una respuesta: ¿qué ocurre con los pacientes que ya están en el sistema cuando la campaña de verdad funciona?</p>
<p>El crecimiento no es mejor acceso mientras el servicio no pueda absorber la afluencia sin empeorar la atención que ya está en marcha. Una puerta abierta no basta si el pasillo detrás no aguanta la cola.</p>
<p><em>Se trata de una reflexión editorial sobre capacidad e indicadores de crecimiento en salud, no de un informe sobre un proyecto concreto, un centro ni personas identificables. Los datos comerciales y personales se han omitido o sustituido por formulaciones generales.</em></p>

HTML,
        ],
        'pl' => [
            'title' => 'Wzrost, który pogarsza dostęp',
            'image_alt' => 'Fioletowy korytarz z szeregiem anonimowych sylwetek. Na końcu otwarte drzwi z ostrym turkusowym światłem i turkusowymi pasmami światła na podłodze.',
            'excerpt' => 'Większa sieć gabinetów kierujących brzmi jak lepszy dostęp. Bez pojemności, kadry i właściwych miar sukcesu kampania może skrócić kolejkę u drzwi i wydłużyć ją wszędzie indziej.',
            'content' => <<<'HTML'
<p>Więcej skierowań może pogorszyć dostęp.</p>
<p>To zdanie zostało mi w głowie przy ocenie propozycji wzrostu opieki nefrologicznej. Większa sieć gabinetów kierujących brzmi jak oczywista poprawa: wcześniejsza diagnoza, prostsze wejście, więcej pacjentów u specjalisty. W praktyce każda pierwsza wizyta ciągnie za sobą kolejne. Kampania, która liczy tylko przyjścia, skraca kolejkę u drzwi i wydłuża ją w kontrolach, badaniach i programie dializ.</p>
<p>W pisemnej odpowiedzi prosiłem więc o ocenę pojemności, kadry, czasów oczekiwania i refundacji, zanim sieć się rozszerzy. Bez tych liczb wzrost nie jest planem. To obietnica, którą płacą ludzie już w systemie.</p>
<p>Zakwestionowałem też miarę sukcesu. W opiece nad nerkami sukces nie może oznaczać tylko większej liczby pacjentów ani pełniejszych zmian dializacyjnych. Celem wczesnej opieki jest też zapobieganie dializie lub jej opóźnienie. Propozycja potrzebowała więc wskaźników trafności skierowań, ciągłości, czasów oczekiwania i obciążenia pracą obok ekonomii.</p>
<p>Zalecłem warunkowy 90-dniowy pilotaż, a nie automatyczne zielone światło dla całego projektu. Przed każdą inicjatywą wzrostu w ochronie zdrowia chcę jednej odpowiedzi: co dzieje się z pacjentami, którzy już są w systemie, gdy kampania naprawdę działa?</p>
<p>Wzrost nie jest lepszym dostępem, dopóki usługa nie pochłonie napływu bez pogarszania opieki, która już trwa. Otwarte drzwi nie wystarczą, jeśli korytarz za nimi nie uniesie kolejki.</p>
<p><em>To redakcyjna refleksja o pojemności i miarach wzrostu w ochronie zdrowia, a nie raport o konkretnym projekcie, placówce ani osobach możliwych do zidentyfikowania. Dane handlowe i osobowe pominięto lub zastąpiono ogólnymi sformułowaniami.</em></p>

HTML,
        ],
        'hu' => [
            'title' => 'Növekedés, amely rontja a hozzáférést',
            'image_alt' => 'Lila folyosó anonim sziluettek sorával. A végén nyitott ajtó éles türkiz fénnyel, a padlón türkiz fénycsíkokkal.',
            'excerpt' => 'A beutaló rendelők nagyobb hálózata jobb hozzáférésnek hangzik. Kapacitás, személyzet és helyes siker mutatók nélkül a kampány lerövidítheti a sort az ajtónál, és mindenhol máshol meghosszabbíthatja.',
            'content' => <<<'HTML'
<p>Több beutaló ronthatja a hozzáférést.</p>
<p>Ez a mondat maradt meg bennem, amikor egy nefrológiai ellátás növekedési javaslatát bíráltam el. A beutaló rendelők nagyobb hálózata magától értetődő javulásnak hangzik: korábbi diagnózis, könnyebb belépés, több beteg a szakorvosnál. A gyakorlatban azonban minden első vizsgálat újabbakat húz maga után. A kampány, amely csak a megérkezést számolja, lerövidíti a sort az ajtónál, és meghosszabbítja a kontrollokban, vizsgálatokban és a dialízisprogramban.</p>
<p>Írásbeli válaszomban ezért kértem a kapacitás, a személyzet, a várakozási idők és a finanszírozás felmérését, mielőtt a hálózat bővülne. E számok nélkül a növekedés nem terv. Ígéret, amelyet a rendszerben már benne lévők fizetnek meg.</p>
<p>A siker mutatóját is megkérdőjeleztem. A vesebeteg-ellátásban a siker nem jelentheti csupán a több beteget vagy a telítettebb dialízisműszakokat. A korai ellátás célja az is, hogy megelőzze vagy késleltesse a dialízist. A javaslatnak ezért a beutalók megfelelőségének, a folytonosságnak, a várakozási időknek és a munkaterhelésnek a mutatóira is szüksége volt a gazdaságosság mellett.</p>
<p>Feltételes 90 napos pilotot ajánlottam, nem automatikus zöld utat a teljes projektnek. Minden egészségügyi növekedési kezdeményezés előtt egy választ akarok: mi lesz azokkal a betegekkel, akik már a rendszerben vannak, ha a kampány valóban működik?</p>
<p>A növekedés nem jobb hozzáférés, amíg a szolgáltatás nem tudja felszívni a rohamot anélkül, hogy rontaná a már zajló ellátást. A nyitott ajtó nem elég, ha a mögötte lévő folyosó nem bírja el a sort.</p>
<p><em>Ez szerkesztői gondolat az egészségügyi kapacitásról és a növekedés mutatóiról, nem beszámoló konkrét projektről, munkahelyről vagy azonosítható személyekről. A kereskedelmi és személyes adatokat elhagytuk vagy általános megfogalmazással helyettesítettük.</em></p>

HTML,
        ],
        'it' => [
            'title' => 'Una crescita che peggiora l’accesso',
            'image_alt' => 'Corridoio viola con una fila di sagome anonime. In fondo una porta aperta riversa luce turchese intensa, con nastri di luce turchese sul pavimento.',
            'excerpt' => 'Una rete più ampia di ambulatori che inviano sembra un accesso migliore. Senza capacità, personale e misure di successo adeguate, una campagna può accorciare la coda alla porta e allungarla ovunque altrove.',
            'content' => <<<'HTML'
<p>Più invii possono peggiorare l’accesso.</p>
<p>Questa frase mi è rimasta mentre esaminavo una proposta di crescita dell’assistenza nefrologica. Una rete più ampia di ambulatori che inviano sembra un miglioramento ovvio: diagnosi più precoce, ingresso più semplice, più pazienti dallo specialista. In pratica ogni prima visita trascina controlli successivi. Una campagna che conta solo gli arrivi accorcia la coda alla porta e la allunga nelle revisioni, negli esami e nel programma dialitico.</p>
<p>Nella risposta scritta ho quindi chiesto di valutare capacità, personale, tempi di attesa e rimborso prima di ampliare la rete. Senza queste cifre la crescita non è un piano. È una promessa pagata da chi è già nel sistema.</p>
<p>Ho anche contestato la metrica di successo. Nell’assistenza renale il successo non può significare solo più pazienti o turni dialitici più pieni. Parte dello scopo delle cure precoci è prevenire o ritardare la dialisi. La proposta aveva quindi bisogno di misure di appropriatezza degli invii, continuità, tempi di attesa e carico di lavoro accanto all’economia.</p>
<p>La mia raccomandazione è stata un pilota condizionale di 90 giorni, non il semaforo verde automatico per l’intero progetto. Prima di ogni iniziativa di crescita in sanità voglio una risposta: che ne è dei pazienti già nel sistema quando la campagna funziona davvero?</p>
<p>La crescita non è un accesso migliore finché il servizio non riesce ad assorbire l’afflusso senza peggiorare le cure già in corso. Una porta aperta non basta se il corridoio dietro non regge la coda.</p>
<p><em>Si tratta di una riflessione editoriale su capacità e indicatori di crescita in sanità, non di un resoconto su un progetto concreto, una sede o persone identificabili. I dettagli commerciali e personali sono stati omessi o sostituiti da formulazioni generali.</em></p>

HTML,
        ],
        'uk' => [
            'title' => 'Зростання, яке погіршує доступ',
            'image_alt' => 'Фіолетовий коридор із рядом анонімних силуетів. Наприкінці відчинені двері з різким бірюзовим світлом і бірюзовими смугами світла на підлозі.',
            'excerpt' => 'Більша мережа закладів, що спрямовують пацієнтів, звучить як кращий доступ. Без потужності, персоналу та правильних показників успіху кампанія може скоротити чергу біля дверей і подовжити її всюди інде.',
            'content' => <<<'HTML'
<p>Більше направлень може погіршити доступ.</p>
<p>Це речення лишилося зі мною під час оцінки пропозиції щодо зростання нефрологічної допомоги. Більша мережа закладів, що спрямовують пацієнтів, звучить як очевидне покращення: раніший діагноз, простіший вхід, більше пацієнтів у спеціаліста. На практиці кожен перший прийом тягне за собою наступні. Кампанія, яка рахує лише прибуття, скорочує чергу біля дверей і подовжує її в контролях, обстеженнях і діалізній програмі.</p>
<p>У письмовій відповіді я тому просив оцінити потужність, персонал, строки очікування та оплату, перш ніж мережа розшириться. Без цих цифр зростання не є планом. Це обіцянка, яку сплачують люди, що вже в системі.</p>
<p>Я також оскаржив показник успіху. У допомозі при хворобах нирок успіх не може означати лише більше пацієнтів чи повніші діалізні зміни. Мета ранньої допомоги також у тому, щоб запобігти діалізу або відкласти його. Тож пропозиція потребувала показників доречності направлень, безперервності, строків очікування та робочого навантаження поруч із економікою.</p>
<p>Я рекомендував умовний 90-денний пілот, а не автоматичне зелене світло для всього проєкту. Перед будь-якою ініціативою зростання в охороні здоров’я я хочу однієї відповіді: що станеться з пацієнтами, які вже в системі, коли кампанія справді спрацює?</p>
<p>Зростання не є кращим доступом, доки служба не може поглинути наплив, не погіршуючи допомогу, яка вже триває. Відчинених дверей замало, якщо коридор за ними не витримає чергу.</p>
<p><em>Це редакційна рефлексія про потужність і показники зростання в охороні здоров’я, а не звіт про конкретний проєкт, місце роботи чи осіб, яких можна ідентифікувати. Комерційні та особисті дані опущено або замінено загальними формулюваннями.</em></p>

HTML,
        ],
    ],
];
