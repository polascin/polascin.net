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
 * posudkom; osoby, firmy a čísla sú fiktívne náhrady.
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
<p>Táto veta mi ostala v hlave pri posudzovaní fiktívne označeného projektu „Klinický most“: návrhu, ako rozšíriť sieť odosielajúcich ambulancií do nefrologickej starostlivosti. Na papieri to vyzerá ako samozrejmé zlepšenie. Skoršia diagnóza. Jednoduchší vstup. Viac pacientov u špecialistu.</p>
<p>Lenže každé prvé vyšetrenie ťahá za sebou ďalšie: kontroly, laboratórium, zobrazovanie, dialyzačný program. Kampaň, ktorá počíta len s príchodom, skráti frontu pri dverách a predĺži ju všade za nimi. Otvorené dvere bez chodby, ktorá unesie frontu, nie sú prístup. Sú past.</p>
<p>V písomnej odpovedi riaditeľovi fiktívnej siete „Regionálne spojenie“ som preto žiadal posúdiť kapacitu, personál, čakacie lehoty a úhradu skôr, než sa sieť rozšíri. Bez týchto čísel nie je rast plán. Je to sľub, ktorý zaplatia ľudia už v systéme: dlhšie čakanie na kontrolu, prerušená kontinuita, plnšie zmeny namiesto skoršieho zásahu.</p>
<p>Namietal som aj meradlo úspechu. V starostlivosti o obličky nemôže úspech znamenať len viac pacientov alebo plnšie dialyzačné zmeny. Cieľom včasnej starostlivosti je aj predísť dialýze alebo ju oddialiť. Návrh preto potreboval ukazovatele vhodnosti odporúčaní, kontinuity, čakacích lehôt a pracovnej záťaže vedľa ekonomiky. Inak sa „úspech“ zhoduje s plnou čakárňou.</p>
<p>Odporučil som podmienený 90-dňový pilotný projekt, nie automatické zelené svetlo pre celú sieť. Pred každou rastovou iniciatívou v zdravotníctve chcem vedieť jedno: čo sa stane s pacientmi, ktorí už v systéme sú, keď kampaň naozaj zaberie?</p>
<p>Rast nie je lepší prístup, kým služba dokáže nápor vstrebať bez toho, aby zhoršila starostlivosť, ktorá už beží. Najprv kapacita a meradlá. Až potom širšie dvere.</p>
<p><em>Ide o redakčnú úvahu o kapacite a meradlách rastu v zdravotníctve. Označenia „Klinický most“ a „Regionálne spojenie“, ako aj úlohy a okolnosti, sú fiktívne náhrady. Neopisujú konkrétny projekt, firmu ani identifikovateľné osoby.</em></p>

HTML,
        ],
        'en' => [
            'title' => 'Growth that makes access worse',
            'image_alt' => 'A violet corridor with a line of anonymous silhouettes. At the far end, an open doorway spills sharp teal light, with teal light ribbons along the floor.',
            'excerpt' => 'A larger network of referring clinics sounds like better access. Without capacity, staffing and the right success measures, a campaign can shorten the queue at the door and lengthen it everywhere else.',
            'content' => <<<'HTML'
<p>More referrals can make access worse.</p>
<p>That sentence stayed with me while reviewing a proposal I label here as “Clinical Bridge”: a plan to widen the network of referring clinics into nephrology care. On paper it looks like an obvious improvement. Earlier diagnosis. An easier way in. More patients reaching a specialist.</p>
<p>But every first appointment pulls follow-up with it: reviews, labs, imaging, the dialysis programme. A campaign that counts only arrivals shortens the queue at the door and lengthens it everywhere behind it. An open door without a corridor that can carry the queue is not access. It is a trap.</p>
<p>In my written reply to the director of a fictional network I call “Regional Link”, I therefore asked for capacity, staffing, waiting times and reimbursement to be assessed before the network expands. Without those figures, growth is not a plan. It is a promise paid for by people already inside the system: longer waits for review, broken continuity, fuller shifts instead of earlier intervention.</p>
<p>I also challenged the success metric. In kidney care, success cannot mean only more patients or fuller dialysis shifts. Part of the purpose of earlier care is to prevent or delay dialysis. The proposal therefore needed measures of referral appropriateness, continuity, waiting times and workload alongside the economics. Otherwise “success” merely equals a crowded waiting room.</p>
<p>My recommendation was a conditional 90-day pilot, not an automatic green light for the whole network. Before any healthcare growth initiative I want one answer: what happens to the patients already inside the system when the campaign actually works?</p>
<p>Growth is not better access until the service can absorb the surge without making existing care worse. Capacity and measures first. Wider doors only after that.</p>
<p><em>This is an editorial reflection on capacity and growth metrics in healthcare. The labels “Clinical Bridge” and “Regional Link”, and the roles and circumstances around them, are fictional substitutes. They do not describe a real project, company or identifiable people.</em></p>

HTML,
        ],
        'cs' => [
            'title' => 'Růst, který zhorší přístup',
            'image_alt' => 'Fialová chodba s řadou anonymních siluet. Na konci otevřené dveře s ostrým tyrkysovým světlem a tyrkysovými pruhy světla na podlaze.',
            'excerpt' => 'Větší síť odesílajících ambulancí zní jako lepší přístup. Bez kapacity, personálu a správných měřítek úspěchu však může kampaň zkrátit frontu u dveří a prodloužit ji všude jinde.',
            'content' => <<<'HTML'
<p>Více doporučení může zhoršit přístup.</p>
<p>Tato věta mi zůstala v hlavě při posuzování fiktivně označeného projektu „Klinický most“: návrhu, jak rozšířit síť odesílajících ambulancí do nefrologické péče. Na papíře to vypadá jako samozřejmé zlepšení. Dřívější diagnóza. Jednodušší vstup. Více pacientů u specialisty.</p>
<p>Jenže každé první vyšetření táhne za sebou další: kontroly, laboratoř, zobrazování, dialyzační program. Kampaň, která počítá jen s příchodem, zkrátí frontu u dveří a prodlouží ji všude za nimi. Otevřené dveře bez chodby, která unese frontu, nejsou přístup. Jsou past.</p>
<p>V písemné odpovědi řediteli fiktivní sítě „Regionální spojení“ jsem proto žádal posoudit kapacitu, personál, čekací lhůty a úhradu dříve, než se síť rozšíří. Bez těchto čísel není růst plán. Je to slib, který zaplatí lidé už v systému: delší čekání na kontrolu, přerušená kontinuita, plnější směny místo dřívějšího zásahu.</p>
<p>Namítal jsem i měřítko úspěchu. V péči o ledviny nemůže úspěch znamenat jen více pacientů nebo plnější dialyzační směny. Cílem včasné péče je i předejít dialýze nebo ji oddálit. Návrh proto potřeboval ukazatele vhodnosti doporučení, kontinuity, čekacích lhůt a pracovní zátěže vedle ekonomiky. Jinak se „úspěch“ shoduje s plnou čekárnou.</p>
<p>Doporučil jsem podmíněný 90denní pilotní projekt, ne automatické zelené světlo pro celou síť. Před každou růstovou iniciativou ve zdravotnictví chci vědět jedno: co se stane s pacienty, kteří už v systému jsou, když kampaň opravdu zabere?</p>
<p>Růst není lepší přístup, dokud služba dokáže nápor vstřebat, aniž by zhoršila péči, která už běží. Nejdřív kapacita a měřítka. Teprve potom širší dveře.</p>
<p><em>Jde o redakční úvahu o kapacitě a měřítkách růstu ve zdravotnictví. Označení „Klinický most“ a „Regionální spojení“ i role a okolnosti jsou fiktivní náhrady. Neopisují konkrétní projekt, firmu ani identifikovatelné osoby.</em></p>

HTML,
        ],
        'de' => [
            'title' => 'Wachstum, das den Zugang verschlechtert',
            'image_alt' => 'Violetter Gang mit einer Reihe anonymer Silhouetten. Am Ende eine offene Tür mit scharfem Türkislicht und türkisen Lichtbändern auf dem Boden.',
            'excerpt' => 'Ein größeres Netz zuweisender Praxen klingt nach besserem Zugang. Ohne Kapazität, Personal und die richtigen Erfolgsmaße kann eine Kampagne die Warteschlange an der Tür verkürzen und sie überall sonst verlängern.',
            'content' => <<<'HTML'
<p>Mehr Überweisungen können den Zugang verschlechtern.</p>
<p>Dieser Satz blieb mir beim Prüfen eines hier fiktiv „Klinische Brücke“ genannten Vorschlags im Kopf: ein Plan, das Netz zuweisender Praxen in die nephrologische Versorgung auszuweiten. Auf dem Papier wirkt das wie eine offensichtliche Verbesserung. Frühere Diagnose. Leichterer Einstieg. Mehr Patientinnen und Patienten beim Spezialisten.</p>
<p>Doch jeder Ersttermin zieht Folgetermine nach sich: Kontrollen, Labor, Bildgebung, Dialyseprogramm. Eine Kampagne, die nur Ankünfte zählt, verkürzt die Warteschlange an der Tür und verlängert sie überall dahinter. Eine offene Tür ohne Gang, der die Warteschlange trägt, ist kein Zugang. Sie ist eine Falle.</p>
<p>In meiner schriftlichen Antwort an den Direktor eines fiktiven Netzes „Regionale Verbindung“ bat ich deshalb, Kapazität, Personal, Wartezeiten und Vergütung zu prüfen, bevor das Netz wächst. Ohne diese Zahlen ist Wachstum kein Plan. Es ist ein Versprechen, das Menschen zahlen, die schon im System sind: längeres Warten auf Kontrolle, unterbrochene Kontinuität, vollere Schichten statt früherem Eingreifen.</p>
<p>Ich habe auch die Erfolgsmessung infrage gestellt. In der Nierenversorgung kann Erfolg nicht nur mehr Patientinnen und Patienten oder vollere Dialyseschichten bedeuten. Frühe Versorgung soll Dialyse auch verhindern oder hinauszögern. Der Vorschlag brauchte deshalb Kennzahlen zur Angemessenheit der Überweisungen, zur Kontinuität, zu Wartezeiten und zur Arbeitslast neben der Ökonomie. Sonst bedeutet „Erfolg“ nur ein volles Wartezimmer.</p>
<p>Meine Empfehlung war ein bedingter 90-Tage-Pilot, kein automatisches Grünlicht für das ganze Netz. Vor jeder Wachstumsoffensive im Gesundheitswesen will ich eine Antwort: was geschieht mit den Menschen, die schon im System sind, wenn die Kampagne wirklich wirkt?</p>
<p>Wachstum ist kein besserer Zugang, solange der Dienst den Ansturm nicht aufnehmen kann, ohne die laufende Versorgung zu verschlechtern. Zuerst Kapazität und Maße. Erst danach breitere Türen.</p>
<p><em>Dies ist eine redaktionelle Überlegung zu Kapazität und Wachstumsmaßen im Gesundheitswesen. Die Bezeichnungen „Klinische Brücke“ und „Regionale Verbindung“ sowie Rollen und Umstände sind fiktive Ersatzangaben. Sie beschreiben kein konkretes Projekt, kein Unternehmen und keine identifizierbaren Personen.</em></p>

HTML,
        ],
        'fr' => [
            'title' => 'Une croissance qui détériore l’accès',
            'image_alt' => 'Couloir violet avec une file de silhouettes anonymes. Au fond, une porte ouverte déverse une lumière turquoise vive, avec des rubans de lumière turquoise sur le sol.',
            'excerpt' => 'Un plus grand réseau de cabinets adresseurs semble améliorer l’accès. Sans capacité, effectifs et bons indicateurs de réussite, une campagne peut raccourcir la file à la porte et l’allonger partout ailleurs.',
            'content' => <<<'HTML'
<p>Plus d’adressages peuvent détériorer l’accès.</p>
<p>Cette phrase m’est restée en tête en examinant une proposition que je désigne ici sous le nom fictif de « Pont clinique » : un plan pour élargir le réseau de cabinets adresseurs vers les soins néphrologiques. Sur le papier, cela paraît une amélioration évidente. Diagnostic plus précoce. Entrée plus simple. Davantage de patients chez le spécialiste.</p>
<p>Mais chaque première consultation entraîne un suivi : contrôles, analyses, imagerie, programme de dialyse. Une campagne qui ne compte que les arrivées raccourcit la file à la porte et l’allonge partout derrière. Une porte ouverte sans couloir capable de porter la file n’est pas un accès. C’est un piège.</p>
<p>Dans ma réponse écrite au directeur d’un réseau fictif appelé « Lien régional », j’ai donc demandé d’évaluer la capacité, les effectifs, les délais d’attente et le remboursement avant d’élargir le réseau. Sans ces chiffres, la croissance n’est pas un plan. C’est une promesse payée par les personnes déjà dans le système : attentes plus longues pour le suivi, continuité rompue, séances plus remplies au lieu d’une intervention plus précoce.</p>
<p>J’ai aussi contesté l’indicateur de réussite. En néphrologie, la réussite ne peut pas signifier seulement plus de patients ou des séances de dialyse plus remplies. Une partie du sens des soins précoces est de prévenir ou de retarder la dialyse. La proposition devait donc inclure des mesures d’adéquation des adressages, de continuité, de délais d’attente et de charge de travail à côté de l’économie. Sinon, la « réussite » se confond avec une salle d’attente pleine.</p>
<p>Ma recommandation était un pilote conditionnel de 90 jours, pas un feu vert automatique pour tout le réseau. Avant toute initiative de croissance en santé, je veux une réponse : que devient-il des patients déjà dans le système lorsque la campagne fonctionne vraiment ?</p>
<p>La croissance n’est pas un meilleur accès tant que le service ne peut absorber l’afflux sans dégrader les soins déjà en cours. D’abord la capacité et les indicateurs. Ensuite seulement des portes plus larges.</p>
<p><em>Il s’agit d’une réflexion éditoriale sur la capacité et les indicateurs de croissance en santé. Les désignations « Pont clinique » et « Lien régional », ainsi que les rôles et circonstances, sont des substituts fictifs. Elles ne décrivent ni un projet réel, ni une entreprise, ni des personnes identifiables.</em></p>

HTML,
        ],
        'es' => [
            'title' => 'Un crecimiento que empeora el acceso',
            'image_alt' => 'Pasillo violeta con una fila de siluetas anónimas. Al fondo, una puerta abierta derrama luz turquesa intensa, con cintas de luz turquesa en el suelo.',
            'excerpt' => 'Una red mayor de consultas remisoras suena a mejor acceso. Sin capacidad, personal y medidas de éxito adecuadas, una campaña puede acortar la cola en la puerta y alargarla en todas partes.',
            'content' => <<<'HTML'
<p>Más derivaciones pueden empeorar el acceso.</p>
<p>Esa frase se me quedó al revisar una propuesta que aquí llamo de forma ficticia «Puente clínico»: un plan para ampliar la red de consultas remisoras hacia la atención nefrológica. Sobre el papel parece una mejora obvia. Diagnóstico más temprano. Entrada más fácil. Más pacientes en la consulta del especialista.</p>
<p>Pero cada primera cita arrastra seguimiento: revisiones, laboratorio, imagen, programa de diálisis. Una campaña que solo cuenta llegadas acorta la cola en la puerta y la alarga en todas partes detrás. Una puerta abierta sin un pasillo que aguante la cola no es acceso. Es una trampa.</p>
<p>En mi respuesta escrita al director de una red ficticia llamada «Enlace regional» pedí por tanto valorar capacidad, personal, tiempos de espera y reembolso antes de ampliar la red. Sin esas cifras, el crecimiento no es un plan. Es una promesa que pagan quienes ya están dentro del sistema: esperas más largas para la revisión, continuidad rota, turnos más llenos en lugar de una intervención más temprana.</p>
<p>También cuestioné la métrica de éxito. En la atención renal, el éxito no puede significar solo más pacientes o turnos de diálisis más llenos. Parte del sentido de la atención temprana es prevenir o retrasar la diálisis. La propuesta necesitaba por tanto medidas de adecuación de las derivaciones, continuidad, tiempos de espera y carga de trabajo junto a la economía. Si no, el «éxito» se confunde con una sala de espera llena.</p>
<p>Mi recomendación fue un piloto condicional de 90 días, no luz verde automática para toda la red. Antes de cualquier iniciativa de crecimiento en salud quiero una respuesta: ¿qué ocurre con los pacientes que ya están en el sistema cuando la campaña de verdad funciona?</p>
<p>El crecimiento no es mejor acceso mientras el servicio no pueda absorber la afluencia sin empeorar la atención que ya está en marcha. Primero capacidad y medidas. Solo después puertas más anchas.</p>
<p><em>Se trata de una reflexión editorial sobre capacidad e indicadores de crecimiento en salud. Las designaciones «Puente clínico» y «Enlace regional», así como los roles y circunstancias, son sustitutos ficticios. No describen un proyecto concreto, una empresa ni personas identificables.</em></p>

HTML,
        ],
        'pl' => [
            'title' => 'Wzrost, który pogarsza dostęp',
            'image_alt' => 'Fioletowy korytarz z szeregiem anonimowych sylwetek. Na końcu otwarte drzwi z ostrym turkusowym światłem i turkusowymi pasmami światła na podłodze.',
            'excerpt' => 'Większa sieć gabinetów kierujących brzmi jak lepszy dostęp. Bez mocy przyjęć, kadry i właściwych miar sukcesu kampania może skrócić kolejkę u drzwi i wydłużyć ją wszędzie indziej.',
            'content' => <<<'HTML'
<p>Więcej skierowań może pogorszyć dostęp.</p>
<p>To zdanie zostało mi w głowie przy ocenie propozycji, którą tu oznaczam fikcyjnie jako „Most kliniczny”: planu rozszerzenia sieci gabinetów kierujących do opieki nefrologicznej. Na papierze wygląda to na oczywistą poprawę. Wcześniejsza diagnoza. Prostsze wejście. Więcej pacjentów u specjalisty.</p>
<p>Tymczasem każda pierwsza wizyta ciągnie za sobą kolejne: kontrole, laboratorium, obrazowanie, program dializ. Kampania, która liczy tylko przyjścia, skraca kolejkę u drzwi i wydłuża ją wszędzie za nimi. Otwarte drzwi bez korytarza, który uniesie kolejkę, to nie dostęp. To pułapka.</p>
<p>W pisemnej odpowiedzi do dyrektora fikcyjnej sieci „Połączenie regionalne” prosiłem więc o ocenę mocy przyjęć, kadry, czasów oczekiwania i refundacji, zanim sieć się rozszerzy. Bez tych liczb wzrost nie jest planem. To obietnica, którą płacą ludzie już w systemie: dłuższe czekanie na kontrolę, przerwana ciągłość, pełniejsze zmiany zamiast wcześniejszej interwencji.</p>
<p>Zakwestionowałem też miarę sukcesu. W opiece nad nerkami sukces nie może oznaczać tylko większej liczby pacjentów ani pełniejszych zmian dializacyjnych. Celem wczesnej opieki jest też zapobieganie dializie lub jej opóźnienie. Propozycja potrzebowała więc wskaźników trafności skierowań, ciągłości, czasów oczekiwania i obciążenia pracą obok ekonomii. Inaczej „sukces” pokrywa się z pełną poczekalnią.</p>
<p>Zalecłem warunkowy 90-dniowy projekt pilotażowy, a nie automatyczne zielone światło dla całej sieci. Przed każdą inicjatywą wzrostu w ochronie zdrowia chcę jednej odpowiedzi: co dzieje się z pacjentami, którzy już są w systemie, gdy kampania naprawdę działa?</p>
<p>Wzrost nie jest lepszym dostępem, dopóki usługa nie pochłonie napływu bez pogarszania opieki, która już trwa. Najpierw moc przyjęć i miary. Dopiero potem szersze drzwi.</p>
<p><em>To redakcyjna refleksja o mocy przyjęć i miarach wzrostu w ochronie zdrowia. Oznaczenia „Most kliniczny” i „Połączenie regionalne” oraz role i okoliczności są fikcyjnymi zamiennikami. Nie opisują konkretnego projektu, firmy ani osób możliwych do zidentyfikowania.</em></p>

HTML,
        ],
        'hu' => [
            'title' => 'Növekedés, amely rontja a hozzáférést',
            'image_alt' => 'Lila folyosó anonim sziluettek sorával. A végén nyitott ajtó éles türkiz fénnyel, a padlón türkiz fénycsíkokkal.',
            'excerpt' => 'A beutaló rendelők nagyobb hálózata jobb hozzáférésnek hangzik. Kapacitás, személyzet és helyes siker mutatók nélkül a kampány lerövidítheti a sort az ajtónál, és mindenhol máshol meghosszabbíthatja.',
            'content' => <<<'HTML'
<p>Több beutaló ronthatja a hozzáférést.</p>
<p>Ez a mondat maradt meg bennem, amikor egy itt fiktíven „Klinikai hídnak” nevezett javaslatot bíráltam el: tervet a beutaló rendelők hálózatának bővítésére a nefrológiai ellátás felé. Papíron magától értetődő javulásnak tűnik. Korábbi diagnózis. Könnyebb belépés. Több beteg a szakorvosnál.</p>
<p>Csakhogy minden első vizsgálat újabbakat húz maga után: kontrollok, labor, képalkotás, dialízisprogram. A kampány, amely csak a megérkezést számolja, lerövidíti a sort az ajtónál, és meghosszabbítja mindenütt mögötte. A nyitott ajtó folyosó nélkül, amely elbírja a sort, nem hozzáférés. Csapda.</p>
<p>Írásbeli válaszomban egy fiktív „Regionális kapcsolat” hálózat igazgatójának ezért kértem a kapacitás, a személyzet, a várakozási idők és a finanszírozás felmérését, mielőtt a hálózat bővülne. E számok nélkül a növekedés nem terv. Ígéret, amelyet a rendszerben már benne lévők fizetnek meg: hosszabb várakozás a kontrollra, megszakadt folytonosság, telítettebb műszakok a korábbi beavatkozás helyett.</p>
<p>A siker mutatóját is megkérdőjeleztem. A vesebeteg-ellátásban a siker nem jelentheti csupán a több beteget vagy a telítettebb dialízisműszakokat. A korai ellátás célja az is, hogy megelőzze vagy késleltesse a dialízist. A javaslatnak ezért a beutalók megfelelőségének, a folytonosságnak, a várakozási időknek és a munkaterhelésnek a mutatóira is szüksége volt a gazdaságosság mellett. Különben a „siker” egy tele váróteremmel esik egybe.</p>
<p>Feltételes 90 napos pilotprojektet ajánlottam, nem automatikus zöld utat a teljes hálózatnak. Minden egészségügyi növekedési kezdeményezés előtt egy választ akarok: mi lesz azokkal a betegekkel, akik már a rendszerben vannak, ha a kampány valóban működik?</p>
<p>A növekedés nem jobb hozzáférés, amíg a szolgáltatás nem tudja felszívni a rohamot anélkül, hogy rontaná a már zajló ellátást. Először kapacitás és mutatók. Csak azután szélesebb ajtók.</p>
<p><em>Ez szerkesztői gondolat az egészségügyi kapacitásról és a növekedés mutatóiról. A „Klinikai híd” és a „Regionális kapcsolat” megnevezések, valamint a szerepek és körülmények fiktív helyettesítők. Nem írnak le konkrét projektet, céget vagy azonosítható személyeket.</em></p>

HTML,
        ],
        'it' => [
            'title' => 'Una crescita che peggiora l’accesso',
            'image_alt' => 'Corridoio viola con una fila di sagome anonime. In fondo una porta aperta riversa luce turchese intensa, con nastri di luce turchese sul pavimento.',
            'excerpt' => 'Una rete più ampia di ambulatori che inviano sembra un accesso migliore. Senza capacità, personale e misure di successo adeguate, una campagna può accorciare la coda alla porta e allungarla ovunque altrove.',
            'content' => <<<'HTML'
<p>Più invii possono peggiorare l’accesso.</p>
<p>Questa frase mi è rimasta mentre esaminavo una proposta che qui chiamo in modo fittizio «Ponte clinico»: un piano per ampliare la rete di ambulatori che inviano verso l’assistenza nefrologica. Sulla carta sembra un miglioramento ovvio. Diagnosi più precoce. Ingresso più semplice. Più pazienti dallo specialista.</p>
<p>Ma ogni prima visita trascina controlli successivi: revisioni, laboratorio, imaging, programma dialitico. Una campagna che conta solo gli arrivi accorcia la coda alla porta e la allunga ovunque dietro. Una porta aperta senza un corridoio che regga la coda non è accesso. È una trappola.</p>
<p>Nella risposta scritta al direttore di una rete fittizia chiamata «Collegamento regionale» ho quindi chiesto di valutare capacità, personale, tempi di attesa e rimborso prima di ampliare la rete. Senza queste cifre la crescita non è un piano. È una promessa pagata da chi è già nel sistema: attese più lunghe per il controllo, continuità interrotta, turni più pieni invece di un intervento più precoce.</p>
<p>Ho anche contestato la metrica di successo. Nell’assistenza renale il successo non può significare solo più pazienti o turni dialitici più pieni. Parte dello scopo delle cure precoci è prevenire o ritardare la dialisi. La proposta aveva quindi bisogno di misure di appropriatezza degli invii, continuità, tempi di attesa e carico di lavoro accanto all’economia. Altrimenti il «successo» coincide con una sala d’attesa piena.</p>
<p>La mia raccomandazione è stata un pilota condizionale di 90 giorni, non il semaforo verde automatico per l’intera rete. Prima di ogni iniziativa di crescita in sanità voglio una risposta: che ne è dei pazienti già nel sistema quando la campagna funziona davvero?</p>
<p>La crescita non è un accesso migliore finché il servizio non riesce ad assorbire l’afflusso senza peggiorare le cure già in corso. Prima capacità e misure. Solo dopo porte più larghe.</p>
<p><em>Si tratta di una riflessione editoriale su capacità e indicatori di crescita in sanità. Le designazioni «Ponte clinico» e «Collegamento regionale», nonché i ruoli e le circostanze, sono sostituti fittizi. Non descrivono un progetto concreto, un’azienda o persone identificabili.</em></p>

HTML,
        ],
        'uk' => [
            'title' => 'Зростання, яке погіршує доступ',
            'image_alt' => 'Фіолетовий коридор із рядом анонімних силуетів. Наприкінці відчинені двері з різким бірюзовим світлом і бірюзовими смугами світла на підлозі.',
            'excerpt' => 'Більша мережа закладів, що спрямовують пацієнтів, звучить як кращий доступ. Без потужності, персоналу та правильних показників успіху кампанія може скоротити чергу біля дверей і подовжити її всюди інде.',
            'content' => <<<'HTML'
<p>Більше направлень може погіршити доступ.</p>
<p>Це речення лишилося зі мною під час оцінки пропозиції, яку тут умовно називаю «Клінічний міст»: плану розширити мережу закладів, що спрямовують пацієнтів, до нефрологічної допомоги. На папері це виглядає як очевидне покращення. Раніший діагноз. Простіший вхід. Більше пацієнтів у спеціаліста.</p>
<p>Але кожен перший прийом тягне за собою наступні: контролі, лабораторія, візуалізація, діалізна програма. Кампанія, яка рахує лише прибуття, скорочує чергу біля дверей і подовжує її всюди за ними. Відчинені двері без коридору, який витримає чергу, то не доступ. Це пастка.</p>
<p>У письмовій відповіді директорові фіктивної мережі «Регіональний зв’язок» я тому просив оцінити потужність, персонал, строки очікування та оплату, перш ніж мережа розшириться. Без цих цифр зростання не є планом. Це обіцянка, яку сплачують люди, що вже в системі: довше очікування на контроль, перервана безперервність, повніші зміни замість ранішого втручання.</p>
<p>Я також оскаржив показник успіху. У допомозі при хворобах нирок успіх не може означати лише більше пацієнтів чи повніші діалізні зміни. Мета ранньої допомоги також у тому, щоб запобігти діалізу або відкласти його. Тож пропозиція потребувала показників доречності направлень, безперервності, строків очікування та робочого навантаження поруч із економікою. Інакше «успіх» збігається з повною кімнатою очікування.</p>
<p>Я рекомендував умовний 90-денний пілотний проєкт, а не автоматичне зелене світло для всієї мережі. Перед будь-якою ініціативою зростання в охороні здоров’я я хочу однієї відповіді: що станеться з пацієнтами, які вже в системі, коли кампанія справді спрацює?</p>
<p>Зростання не є кращим доступом, доки служба не може поглинути наплив, не погіршуючи допомогу, яка вже триває. Спочатку потужність і показники. Лише потім ширші двері.</p>
<p><em>Це редакційна рефлексія про потужність і показники зростання в охороні здоров’я. Позначення «Клінічний міст» і «Регіональний зв’язок», а також ролі та обставини, є фіктивними замінниками. Вони не описують конкретний проєкт, компанію чи осіб, яких можна ідентифікувати.</em></p>

HTML,
        ],
    ],
];
