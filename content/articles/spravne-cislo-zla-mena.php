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
 * GitHub Copilot, recenzia AlphaGrab PR #11, 14. 10. 2026, 5.44 SELČ.
 * Reconnect WebSocketu zahodil menu pri sume 8000 JPY (mohla sa ukázať ako 8000 GBP
 * a dôjsť k nákupu). BuyTicketRequest obišiel validáciu meny. Päť nálezov.
 * Opravný commit a61f31d. PR bol 15. 10. 2026 ešte otvorený (GitHub API).
 */
return [
    'slug' => 'spravne-cislo-zla-mena',
    'author' => 'MUDr. Ľubomír Polaščín',
    'category' => 'blog',
    'is_top' => 0,
    'published_at' => '2026-10-15 17:40:00',
    'image' => 'images/articles/spravne-cislo-zla-mena.webp',
    'translations' => [
        'sk' => [
            'title' => 'Správne číslo. Zlá mena.',
            'image_alt' => 'Minca na hrane na tmavom drevenom stole, ľavá polovica tyrkysová a pravá fialová, nad ňou pretrhnutý oblúk svetla.',
            'excerpt' => '14. októbra 2026 vrátila recenzia pull requestu v AlphaGrabe päť nálezov. Po obnove spojenia ostalo 8 000 jenov bez meny. Používateľovi s librami sa tá suma mohla ukázať ako 8 000 libier a dôjsť až k nákupu.',
            'content' => <<<'HTML'
<p>14. októbra 2026 o 5.44 stredoeurópskeho letného času vrátil GitHub Copilot recenziu pull requestu v projekte <em>AlphaGrab</em>. Jedna cesta po obnove spojenia WebSocketu si nechala surovú sumu. Mena na nej chýbala.</p>
<p>Zdrojová suma 8&nbsp;000 jenov sa tak mohla používateľovi s menou nastavenou na libry ukázať ako 8&nbsp;000 libier. Tá istá suma mohla dôjsť až k nákupu. Aritmetika v tej chvíli ešte držala. Nesedela mena, s ktorou číslo cestovalo.</p>
<p>Tá istá recenzia našla aj druhú medzeru. Kontrola meny v kóde bola. Požiadavka na nákup ju však mohla obísť a priniesť kód meny, ktorý systém nepodporuje.</p>
<p>Poznámok bolo päť. Opravy aj regresné testy som posunul v commite a61f31d. Pull request som nechal otvorený. Opravný commit nie je nezávislé potvrdenie, že je všetko správne.</p>
<p>Pri vývoji s umelou inteligenciou si z toho beriem toto: kontrolovať cestu hodnoty, nie len funkciu, ktorá ju počíta. Odkiaľ prišla? Aká jednotka k nej patrí? Čo sa s ňou stane po obnove spojenia? Vie iný koncový bod pravidlo obísť?</p>
<p>Sumy, dátumy, dávky aj merania ostávajú spoľahlivé len dovtedy, kým s nimi prejde aj kontext. Číslo bez jednotky nie je hotový údaj. Je to tvrdenie, ktoré ešte nie je dokončené.</p>

HTML,
        ],
        'en' => [
            'title' => 'The right number. The wrong currency.',
            'image_alt' => 'A coin on its edge on a dark wooden desk, teal on the left half and violet on the right, with a broken arc of light above it.',
            'excerpt' => 'On 14 October 2026 a review of a pull request in AlphaGrab returned five findings. After a reconnect, 8,000 yen remained without a currency. To a user set to pounds, that sum could appear as 8,000 pounds and reach the purchase.',
            'content' => <<<'HTML'
<p>On 14 October 2026, at 5.44 Central European Summer Time, GitHub Copilot returned a review of a pull request in <em>AlphaGrab</em>. One path, after a WebSocket reconnect, kept the raw sum. The currency on it was missing.</p>
<p>A source amount of 8,000 yen could then appear as 8,000 pounds to a user whose currency was set to the pound. That same sum could reach the purchase. The arithmetic still held at that moment. The currency travelling with the number did not.</p>
<p>The same review found a second gap. Currency validation was in the code. A purchase request could still bypass it and bring in a currency code the system does not support.</p>
<p>There were five findings. I pushed the fixes and the regression tests in commit a61f31d. I left the pull request open. A fix commit is not an independent confirmation that everything is correct.</p>
<p>For AI-assisted development I take this from it: follow the path of a value, not only the function that calculates it. Where did it come from? What unit belongs to it? What happens to it after a reconnect? Can another endpoint bypass the rule?</p>
<p>Amounts, dates, doses and measurements stay reliable only as long as the context makes the trip with them. A number without its unit is not clean data. It is an unfinished claim.</p>

HTML,
        ],
        'cs' => [
            'title' => 'Správné číslo. Špatná měna.',
            'image_alt' => 'Mince na hraně na tmavém dřevěném stole, levá půlka tyrkysová a pravá fialová, nad ní přetržený oblouk světla.',
            'excerpt' => '14. října 2026 vrátila recenze pull requestu v AlphaGrabu pět nálezů. Po obnovení spojení zůstalo 8 000 jenů bez měny. Uživateli s librami se ta částka mohla ukázat jako 8 000 liber a dojít až k nákupu.',
            'content' => <<<'HTML'
<p>14. října 2026 v 5.44 středoevropského letního času vrátil GitHub Copilot recenzi pull requestu v projektu <em>AlphaGrab</em>. Jedna cesta po obnovení spojení WebSocketu si nechala surovou částku. Měna na ní chyběla.</p>
<p>Zdrojová částka 8&nbsp;000 jenů se tak mohla uživateli s měnou nastavenou na libry ukázat jako 8&nbsp;000 liber. Tatáž částka mohla dojít až k nákupu. Aritmetika v tu chvíli ještě držela. Neseděla měna, se kterou číslo cestovalo.</p>
<p>Tatáž recenze našla i druhou mezeru. Kontrola měny v kódu byla. Požadavek na nákup ji však mohl obejít a přinést kód měny, který systém nepodporuje.</p>
<p>Poznámek bylo pět. Opravy i regresní testy jsem odeslal v commitu a61f31d. Pull request jsem nechal otevřený. Opravný commit není nezávislé potvrzení, že je všechno správně.</p>
<p>Při vývoji s umělou inteligencí si z toho beru tohle: kontrolovat cestu hodnoty, ne jen funkci, která ji počítá. Odkud přišla? Jaká jednotka k ní patří? Co se s ní stane po obnovení spojení? Umí jiný koncový bod pravidlo obejít?</p>
<p>Částky, kalendářní data, dávky i měření zůstávají spolehlivé jen do té doby, dokud s nimi projde i kontext. Číslo bez jednotky není hotový údaj. Je to tvrzení, které ještě není dokončené.</p>

HTML,
        ],
        'de' => [
            'title' => 'Die richtige Zahl. Die falsche Währung.',
            'image_alt' => 'Eine Münze auf der Kante auf einem dunklen Holztisch, links türkis und rechts violett, darüber ein gerissener Lichtbogen.',
            'excerpt' => 'Am 14. Oktober 2026 lieferte die Prüfung eines Pull Requests in AlphaGrab fünf Befunde. Nach der neuen Verbindung blieben 8.000 Yen ohne Währung. Einem Nutzer mit Pfund konnte diese Summe als 8.000 Pfund erscheinen und bis zum Kauf gelangen.',
            'content' => <<<'HTML'
<p>Am 14. Oktober 2026 um 5.44 Uhr mitteleuropäischer Sommerzeit lieferte GitHub Copilot die Prüfung eines Pull Requests im Projekt <em>AlphaGrab</em>. Ein Pfad behielt nach der Wiederverbindung des WebSockets die rohe Summe. Die Währung daran fehlte.</p>
<p>Eine Ausgangssumme von 8.000 Yen konnte so einem Nutzer, dessen Währung auf Pfund stand, als 8.000 Pfund erscheinen. Dieselbe Summe konnte bis zum Kauf gelangen. Die Arithmetik hielt in dem Moment noch. Die Währung, mit der die Zahl unterwegs war, stimmte nicht.</p>
<p>Dieselbe Prüfung fand eine zweite Lücke. Die Währung wurde im Code bereits geprüft. Eine Kaufanfrage konnte diese Prüfung dennoch umgehen und einen Währungscode mitbringen, den das System nicht unterstützt.</p>
<p>Es waren fünf Hinweise. Die Korrekturen und die Regressionstests habe ich mit dem Commit a61f31d abgeschickt. Den Pull Request habe ich offen gelassen. Ein Korrekturcommit ist keine unabhängige Bestätigung, dass alles stimmt.</p>
<p>Für die Entwicklung mit künstlicher Intelligenz nehme ich das mit: den Weg eines Wertes prüfen, nicht nur die Funktion, die ihn berechnet. Woher kam er? Welche Einheit gehört zu ihm? Was geschieht mit ihm nach einer Wiederverbindung? Kann ein anderer Endpunkt die Regel umgehen?</p>
<p>Beträge, Datumswerte, Dosen und Messwerte bleiben nur so lange verlässlich, wie der Kontext den Weg mit ihnen mitgeht. Eine Zahl ohne ihre Einheit ist keine fertige Angabe. Sie ist eine Behauptung, die noch nicht abgeschlossen ist.</p>

HTML,
        ],
        'fr' => [
            'title' => 'Le bon nombre. La mauvaise devise.',
            'image_alt' => 'Une pièce sur la tranche, sur un bureau de bois sombre, moitié turquoise à gauche et violette à droite, avec un arc de lumière brisé au-dessus.',
            'excerpt' => 'Le 14 octobre 2026, la revue d’une pull request dans AlphaGrab a renvoyé cinq constats. Après la reconnexion, 8 000 yens sont restés sans devise. Pour un utilisateur en livres, cette somme pouvait s’afficher comme 8 000 livres et aller jusqu’à l’achat.',
            'content' => <<<'HTML'
<p>Le 14 octobre 2026, à 5 h 44, heure d’été d’Europe centrale, GitHub Copilot a renvoyé la revue d’une pull request dans le projet <em>AlphaGrab</em>. Un chemin, après la reconnexion du WebSocket, a gardé la somme brute. La devise y manquait.</p>
<p>Une somme d’origine de 8&nbsp;000 yens a ainsi pu s’afficher comme 8&nbsp;000 livres pour un utilisateur dont la devise était la livre. La même somme pouvait aller jusqu’à l’achat. L’arithmétique tenait encore à cet instant. La devise avec laquelle le nombre voyageait, non.</p>
<p>La même revue a trouvé une deuxième faille. Le contrôle de la devise était dans le code. Une demande d’achat pouvait pourtant le contourner et introduire un code de devise que le système ne prend pas en charge.</p>
<p>Il y avait cinq remarques. J’ai poussé les correctifs et les tests de régression dans le commit a61f31d. J’ai laissé la pull request ouverte. Un commit de correctif n’est pas une confirmation indépendante que tout est juste.</p>
<p>Pour le développement assisté par intelligence artificielle, j’en retiens ceci : suivre le trajet d’une valeur, pas seulement la fonction qui la calcule. D’où vient-elle ? Quelle unité lui appartient ? Que devient-elle après une reconnexion ? Un autre point d’accès peut-il contourner la règle ?</p>
<p>Les montants, les dates, les doses et les mesures ne restent fiables que tant que le contexte fait le voyage avec eux. Un nombre sans son unité n’est pas une donnée achevée. C’est une affirmation qui n’est pas encore finie.</p>

HTML,
        ],
        'es' => [
            'title' => 'El número correcto. La moneda equivocada.',
            'image_alt' => 'Una moneda de canto sobre un escritorio de madera oscura, turquesa a la izquierda y violeta a la derecha, con un arco de luz partido encima.',
            'excerpt' => 'El 14 de octubre de 2026, la revisión de una pull request en AlphaGrab devolvió cinco hallazgos. Tras reconectar, 8.000 yenes quedaron sin moneda. A un usuario con libras, esa suma podía mostrarse como 8.000 libras y llegar hasta la compra.',
            'content' => <<<'HTML'
<p>El 14 de octubre de 2026, a las 5.44, hora de verano de Europa central, GitHub Copilot devolvió la revisión de una pull request en el proyecto <em>AlphaGrab</em>. Un camino, tras la reconexión del WebSocket, conservó la suma en bruto. La moneda faltaba.</p>
<p>Una suma de origen de 8.000 yenes podía así mostrarse como 8.000 libras a un usuario cuya moneda estaba fijada en libras. La misma suma podía llegar hasta la compra. La aritmética aún se sostenía en ese momento. No se sostenía la moneda con la que viajaba el número.</p>
<p>La misma revisión encontró una segunda brecha. La validación de la moneda estaba en el código. Una solicitud de compra podía saltársela e introducir un código de moneda que el sistema no admite.</p>
<p>Había cinco observaciones. Subí las correcciones y las pruebas de regresión en el commit a61f31d. Dejé la pull request abierta. Un commit de corrección no es una confirmación independiente de que todo sea correcto.</p>
<p>Para el desarrollo asistido por inteligencia artificial me quedo con esto: revisar el recorrido de un valor, no solo la función que lo calcula. ¿De dónde salió? ¿Qué unidad le corresponde? ¿Qué le ocurre tras una reconexión? ¿Puede otro punto de acceso saltarse la regla?</p>
<p>Importes, fechas, dosis y mediciones siguen siendo fiables solo mientras el contexto hace el viaje con ellos. Un número sin su unidad no es un dato terminado. Es una afirmación que todavía no está cerrada.</p>

HTML,
        ],
        'pl' => [
            'title' => 'Dobra liczba. Zła waluta.',
            'image_alt' => 'Moneta na krawędzi na ciemnym drewnianym stole, lewa połowa turkusowa, prawa fioletowa, a nad nią przerwany łuk światła.',
            'excerpt' => '14 października 2026 recenzja pull requestu w AlphaGrabie zwróciła pięć ustaleń. Po ponownym połączeniu zostało 8 000 jenów bez waluty. Użytkownikowi z funtami ta kwota mogła się pokazać jako 8 000 funtów i dojść aż do zakupu.',
            'content' => <<<'HTML'
<p>14 października 2026 o 5.44 czasu środkowoeuropejskiego letniego GitHub Copilot oddał recenzję pull requestu w projekcie <em>AlphaGrab</em>. Jedna ścieżka po ponownym połączeniu WebSocketu zatrzymała surową kwotę. Waluty na niej brakowało.</p>
<p>Kwota źródłowa 8&nbsp;000 jenów mogła się tak pokazać użytkownikowi z walutą ustawioną na funty jako 8&nbsp;000 funtów. Ta sama kwota mogła dojść aż do zakupu. Arytmetyka w tej chwili jeszcze się trzymała. Nie trzymała się waluta, z którą liczba podróżowała.</p>
<p>Ta sama recenzja znalazła też drugą lukę. Sprawdzenie waluty w kodzie było. Żądanie zakupu mogło je jednak ominąć i wnieść kod waluty, którego system nie obsługuje.</p>
<p>Uwag było pięć. Poprawki i testy regresji wypchnąłem w commicie a61f31d. Pull request zostawiłem otwarty. Commit z poprawką nie jest niezależnym potwierdzeniem, że wszystko jest poprawne.</p>
<p>W rozwoju wspomaganym sztuczną inteligencją biorę z tego tyle: sprawdzać drogę wartości, nie tylko funkcję, która ją liczy. Skąd przyszła? Jaka jednostka do niej należy? Co się z nią dzieje po ponownym połączeniu? Czy inny punkt końcowy może obejść regułę?</p>
<p>Kwoty, daty, dawki i pomiary pozostają wiarygodne tylko dopóty, dopóki kontekst przechodzi razem z nimi. Liczba bez jednostki nie jest gotową informacją. To twierdzenie, które nie jest jeszcze skończone.</p>

HTML,
        ],
        'hu' => [
            'title' => 'A helyes szám. A rossz pénznem.',
            'image_alt' => 'Egy érme az élén egy sötét faasztalon, bal fele türkiz, jobb fele lila, fölötte egy megszakadt fényív.',
            'excerpt' => '2026. október 14-én az AlphaGrab egyik pull requestjének bírálata öt megállapítást adott vissza. Újrakapcsolás után 8 000 jen pénznem nélkül maradt. A fontot használó felhasználónak ez az összeg 8 000 fontként jelenhetett meg, és eljuthatott a vásárlásig.',
            'content' => <<<'HTML'
<p>2026. október 14-én, közép-európai nyári idő szerint 5.44-kor a GitHub Copilot visszaadta az <em>AlphaGrab</em> projekt egyik pull requestjének bírálatát. A WebSocket újrakapcsolása után az egyik út megtartotta a nyers összeget. A pénznem hiányzott róla.</p>
<p>A 8&nbsp;000 jenes forrásösszeg így annak a felhasználónak, akinek a pénzneme fontra volt állítva, 8&nbsp;000 fontként jelenhetett meg. Ugyanez az összeg eljuthatott a vásárlásig. A számolás abban a pillanatban még tartott. A pénznem, amellyel a szám utazott, nem.</p>
<p>Ugyanaz a bírálat egy második rést is talált. A pénznem ellenőrzése benne volt a kódban. A vásárlási kérés mégis megkerülhette, és olyan pénznemkódot hozhatott, amelyet a rendszer nem támogat.</p>
<p>Öt megjegyzés érkezett. A javításokat és a regressziós teszteket az a61f31d commitban toltam fel. A pull requestet nyitva hagytam. A javító commit nem független igazolás arra, hogy minden helyes.</p>
<p>A mesterséges intelligenciával segített fejlesztésben ezt viszem tovább: az érték útját kell nézni, nem csak a függvényt, amely kiszámolja. Honnan jött? Milyen egység tartozik hozzá? Mi történik vele újrakapcsolás után? Megkerülheti a szabályt egy másik végpont?</p>
<p>Az összegek, a dátumok, az adagok és a mérések csak addig megbízhatók, amíg a kontextus velük együtt megteszi az utat. A szám egység nélkül nem kész adat. Olyan állítás, amely még nincs befejezve.</p>

HTML,
        ],
        'it' => [
            'title' => 'Il numero giusto. La valuta sbagliata.',
            'image_alt' => 'Una moneta di taglio su un tavolo di legno scuro, turchese a sinistra e viola a destra, con un arco di luce spezzato sopra.',
            'excerpt' => 'Il 14 ottobre 2026 la revisione di una pull request in AlphaGrab ha restituito cinque rilievi. Dopo la riconnessione, 8.000 yen sono rimasti senza valuta. Per un utente in sterline quella somma poteva comparire come 8.000 sterline e arrivare fino all’acquisto.',
            'content' => <<<'HTML'
<p>Il 14 ottobre 2026, alle 5.44, ora legale dell’Europa centrale, GitHub Copilot ha restituito la revisione di una pull request nel progetto <em>AlphaGrab</em>. Un percorso, dopo la riconnessione del WebSocket, ha tenuto la somma grezza. La valuta mancava.</p>
<p>Una somma di partenza di 8.000 yen poteva così comparire come 8.000 sterline per un utente la cui valuta era impostata sulla sterlina. La stessa somma poteva arrivare fino all’acquisto. L’aritmetica in quel momento reggeva ancora. Non reggeva la valuta con cui il numero viaggiava.</p>
<p>La stessa revisione ha trovato una seconda fessura. Il controllo della valuta c’era nel codice. Una richiesta di acquisto poteva però aggirarlo e introdurre un codice di valuta che il sistema non ammette.</p>
<p>Le osservazioni erano cinque. Ho mandato le correzioni e i test di regressione nel commit a61f31d. Ho lasciato aperta la pull request. Un commit di correzione non è una conferma indipendente che tutto sia corretto.</p>
<p>Per lo sviluppo assistito dall’intelligenza artificiale ne traggo questo: seguire il percorso di un valore, non solo la funzione che lo calcola. Da dove è arrivato? Quale unità gli appartiene? Che cosa gli succede dopo una riconnessione? Un altro endpoint può aggirare la regola?</p>
<p>Importi, date, dosi e misure restano affidabili solo finché il contesto compie il viaggio con loro. Un numero senza la sua unità non è un dato compiuto. È un’affermazione che non è ancora conclusa.</p>

HTML,
        ],
        'uk' => [
            'title' => 'Правильне число. Неправильна валюта.',
            'image_alt' => 'Монета на ребрі на темному дерев’яному столі, ліва половина бірюзова, права фіолетова, над нею розірвана дуга світла.',
            'excerpt' => '14 жовтня 2026 року рецензія pull request в AlphaGrab повернула п’ять висновків. Після повторного з’єднання лишилося 8 000 єн без валюти. Користувачеві з фунтами ця сума могла показатися як 8 000 фунтів і дійти аж до покупки.',
            'content' => <<<'HTML'
<p>14 жовтня 2026 року о 5.44 за центральноєвропейським літнім часом GitHub Copilot повернув рецензію pull request у проєкті <em>AlphaGrab</em>. Один шлях після відновлення з’єднання WebSocket залишив сиру суму. Валюти на ньому не було.</p>
<p>Вихідна сума 8&nbsp;000 єн могла так показатися користувачеві, валюту якого було встановлено на фунти, як 8&nbsp;000 фунтів. Та сама сума могла дійти аж до покупки. Арифметика тієї миті ще трималася. Не трималася валюта, з якою число мандрувало.</p>
<p>Та сама рецензія знайшла й другу прогалину. Перевірка валюти в коді була. Запит на покупку міг її обійти і принести код валюти, якого система не підтримує.</p>
<p>Зауважень було п’ять. Виправлення і регресійні тести я відправив у коміті a61f31d. Pull request я залишив відкритим. Коміт із виправленням не є незалежним підтвердженням, що все правильно.</p>
<p>Для розробки за допомогою штучного інтелекту беру з цього ось що: стежити за шляхом значення, а не лише за функцією, яка його рахує. Звідки воно прийшло? Яка одиниця йому належить? Що з ним стається після відновлення з’єднання? Чи може інша кінцева точка обійти правило?</p>
<p>Суми, дати, дози й виміри лишаються надійними лише доти, доки контекст проходить шлях разом із ними. Число без одиниці не є готовим записом. Це твердження, яке ще не завершене.</p>

HTML,
        ],
    ],
];
