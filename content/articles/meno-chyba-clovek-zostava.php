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

/** Editorial essay; anonymised model examples where explicitly stated. */
return [
    'slug' => 'meno-chyba-clovek-zostava',
    'author' => 'MUDr. Ľubomír Polaščín',
    'category' => 'blog',
    'is_top' => 0,
    'published_at' => '2026-11-21 08:00:00',
    'image' => 'images/articles/meno-chyba-clovek-zostava.webp',
    'translations' => [
        'sk' => [
            'title' => 'Meno sme vymazali. Človek zostal viditeľný.',
            'image_alt' => 'Dve priesvitné dosky vytvárajú v prekrytí tieň ľudskej postavy.',
            'excerpt' => 'Dva zdanlivo neškodné údaje môžu spolu prezradiť to, čo každý zvlášť tají. Ochranu súkromia treba posudzovať aj podľa toho, čo môže používateľ zistiť spojením viacerých obrazoviek.',
            'content' => <<<'HTML'
<p>Predstavme si prehľad obsadenosti v zdravotníckom zariadení. Technik v ňom vidí lôžko, pracovnú zmenu a označenie prístroja. V samostatnej evidencii zistí, pre akú skupinu pacientov je tento prístroj vyhradený. Meno pacienta vôbec nepotrebuje: spojením údajov si môže odvodiť citlivú informáciu o človeku na lôžku. Celá situácia je modelová, nepopisuje konkrétne pracovisko ani pacienta.</p>
<p>Prvá obrazovka neukázala diagnózu. Druhá neukázala pacienta. Ich súvislosť však vytvorila informáciu, ktorú sme nechceli sprístupniť.</p>
<p>Preto nestačí hľadať v databáze stĺpec „meno“. Treba sa prejsť tým istým rozhraním ako používateľ a pripočítať vedomosti, ktoré si prináša z práce. Rozpis zmien, známe tváre, včerajšia služba. Údaje z jednej obrazovky treba posudzovať aj spolu s tým, čo je dostupné inde.</p>
<p>V takom návrhu by som z prehľadu obsadenosti odstránil väzbu na konkrétny prístroj. Technikovi môže stačiť počet obsadených miest a ich stav. Oprávnenia treba posúdiť osobitne a v zázname o prístupe uchovať iba potrebné údaje. Ani potom nemožno bez ďalšieho posúdenia vyhlásiť celý prehľad za anonymný.</p>
<p>Praktická skúška znie: čo si môže tento používateľ domyslieť, keď spojí dve obrazovky? Niekedy je najlepšou ochranou vynechať jedno zdanlivo užitočné označenie.</p>
<p><em>Fiktívny príklad návrhového rizika, nie správa o úniku údajov. Text nie je právnym posúdením konkrétneho systému.</em></p>
<p><small><em>Information Commissioner’s Office. <a href="https://ico.org.uk/for-organisations/uk-gdpr-guidance-and-resources/data-sharing/anonymisation/how-do-we-ensure-anonymisation-is-effective/">How do we ensure anonymisation is effective?</a></em></small></p>

HTML,
        ],
        'en' => [
            'title' => 'We removed the name. The person remained visible.',
            'image_alt' => 'Two translucent panels form a human silhouette where they overlap.',
            'excerpt' => 'Two apparently harmless details can reveal more together than either does alone. Privacy reviews need to consider what a user can learn by combining screens.',
            'content' => <<<'HTML'
<p>Imagine an occupancy view in a healthcare facility. A technician can see the bed, shift and machine label. A separate equipment registry explains which patient group that machine is reserved for. No patient name is needed: combining the details may allow the technician to infer sensitive information about the person in the bed. This entire scenario is hypothetical; it does not describe a particular facility or patient.</p>
<p>The first screen showed no diagnosis. The second showed no patient. Their connection nevertheless revealed information we had not intended to share.</p>
<p>Looking for a database column called “name” is therefore insufficient. Walk through the interface as the user would, including knowledge brought from work: rosters, familiar faces, yesterday's shift. A screen needs to be assessed alongside the other information available to its users.</p>
<p>In this design, I would remove the link to a specific machine from the occupancy view. Counts and occupied/free status may be enough for the technician. Permissions need separate assessment; access logs should retain only necessary information. Even then, the whole view cannot simply be declared anonymous without further assessment.</p>
<p>The practical test is what this user can infer by combining two screens. Sometimes the best protection is leaving out one convenient label.</p>
<p><em>A fictional design-risk example, not a report of a data breach or a legal assessment of a specific system.</em></p>
<p><small><em>Information Commissioner’s Office. <a href="https://ico.org.uk/for-organisations/uk-gdpr-guidance-and-resources/data-sharing/anonymisation/how-do-we-ensure-anonymisation-is-effective/">How do we ensure anonymisation is effective?</a></em></small></p>

HTML,
        ],
        'cs' => [
            'title' => 'Jméno jsme vymazali. Člověk zůstal viditelný.',
            'image_alt' => 'Dvě průsvitné desky vytvářejí v překrytí stín lidské postavy.',
            'excerpt' => 'Dva zdánlivě nevinné údaje mohou společně prozradit, co každý zvlášť skrývá. Soukromí je třeba posuzovat očima člověka, který vidí více obrazovek.',
            'content' => <<<'HTML'
<p>Představme si přehled obsazenosti ve zdravotnickém zařízení. Technik v něm vidí lůžko, pracovní směnu a označení přístroje. V samostatné evidenci zjistí, pro kterou skupinu pacientů je přístroj vyhrazen. Jméno pacienta vůbec nepotřebuje: spojením údajů si může odvodit citlivou informaci o člověku na lůžku. Celá situace je modelová, nepopisuje konkrétní pracoviště ani pacienta.</p>
<p>První obrazovka neukázala diagnózu. Druhá neukázala pacienta. Jejich souvislost přesto vytvořila informaci, kterou jsme nechtěli zpřístupnit.</p>
<p>Nestačí proto hledat v databázi sloupec „jméno“. Je třeba projít rozhraní jako uživatel a přičíst znalosti z práce: rozpis směn, známé tváře, včerejší službu. Údaje z jedné obrazovky je třeba posuzovat i společně s tím, co je dostupné jinde.</p>
<p>Z takového přehledu bych odstranil vazbu na konkrétní přístroj. Technikovi mohou stačit počty a stav obsazeno/volno. Oprávnění vyžadují samostatné posouzení, záznamy o přístupu pouze potřebné údaje. Ani pak nelze bez dalšího posouzení označit celý přehled za anonymní.</p>
<p>Praktická zkouška zní: co si tento uživatel odvodí spojením dvou obrazovek? Někdy nejlépe chrání vynechání jednoho zdánlivě užitečného označení.</p>
<p><em>Fiktivní příklad návrhového rizika, nikoli zpráva o úniku údajů či právní posouzení konkrétního systému.</em></p>
<p><small><em>Information Commissioner’s Office. <a href="https://ico.org.uk/for-organisations/uk-gdpr-guidance-and-resources/data-sharing/anonymisation/how-do-we-ensure-anonymisation-is-effective/">How do we ensure anonymisation is effective?</a></em></small></p>

HTML,
        ],
        'de' => [
            'title' => 'Der Name ist gelöscht. Der Mensch bleibt erkennbar.',
            'image_alt' => 'Zwei durchscheinende Tafeln bilden in ihrer Überlagerung eine menschliche Silhouette.',
            'excerpt' => 'Zwei harmlos wirkende Angaben können gemeinsam verraten, was jede für sich verbirgt. Datenschutzprüfungen müssen berücksichtigen, was ein Nutzer aus mehreren Ansichten ableiten kann.',
            'content' => <<<'HTML'
<p>Stellen wir uns eine Belegungsübersicht in einer Gesundheitseinrichtung vor. Ein Techniker sieht Bett, Schicht und Gerätekennung. Ein separates Geräteverzeichnis erklärt, welcher Patientengruppe das Gerät vorbehalten ist. Ein Patientenname ist dafür nicht nötig: Die Verknüpfung kann Rückschlüsse auf sensible Informationen über den Menschen im Bett ermöglichen. Das gesamte Beispiel ist hypothetisch und beschreibt weder eine bestimmte Einrichtung noch einen bestimmten Patienten.</p>
<p>Der erste Bildschirm zeigte keine Diagnose, der zweite keinen Patienten. Zusammen offenbarten sie dennoch etwas, das nicht zugänglich sein sollte.</p>
<p>Eine Datenbankspalte namens „Name“ zu suchen reicht deshalb nicht. Man muss die Oberfläche wie der Nutzer durchgehen und dessen Arbeitswissen einbeziehen: Dienstpläne, bekannte Gesichter, die gestrige Schicht. Eine Ansicht muss zusammen mit den anderen Informationen beurteilt werden, auf die der Nutzer zugreifen kann.</p>
<p>Ich würde die Zuordnung zum konkreten Gerät aus dieser Übersicht entfernen. Belegungszahlen und der Status frei/belegt können genügen. Berechtigungen sind gesondert zu prüfen, Zugriffsprotokolle auf notwendige Angaben zu beschränken. Auch dann darf die gesamte Übersicht nicht ohne weitere Prüfung als anonym gelten.</p>
<p>Die praktische Frage lautet, was dieser Nutzer aus zwei Bildschirmen ableiten kann. Manchmal schützt der Verzicht auf eine bequeme Beschriftung am besten.</p>
<p><em>Fiktives Beispiel eines Entwurfsrisikos, kein Bericht über ein Datenleck und keine rechtliche Bewertung eines konkreten Systems.</em></p>
<p><small><em>Information Commissioner’s Office. <a href="https://ico.org.uk/for-organisations/uk-gdpr-guidance-and-resources/data-sharing/anonymisation/how-do-we-ensure-anonymisation-is-effective/">How do we ensure anonymisation is effective?</a></em></small></p>

HTML,
        ],
        'fr' => [
            'title' => 'Le nom a disparu. La personne reste visible.',
            'image_alt' => 'Deux panneaux translucides forment une silhouette humaine dans leur superposition.',
            'excerpt' => 'Deux détails apparemment anodins peuvent révéler ensemble ce que chacun cache. Il faut examiner la confidentialité avec les yeux d\'une personne qui voit plusieurs écrans.',
            'content' => <<<'HTML'
<p>Imaginons un tableau d'occupation dans un établissement de soins. Un technicien y voit le lit, la plage horaire et l'identifiant de l'appareil. Un registre distinct indique à quel groupe de patients cet appareil est réservé. Le nom du patient n'est pas nécessaire : le rapprochement des données peut permettre de déduire une information sensible sur la personne occupant le lit. Toute la situation est hypothétique ; elle ne décrit aucun établissement ni patient particulier.</p>
<p>Le premier écran ne montrait aucun diagnostic, le second aucun patient. Ensemble, ils révélaient pourtant ce que nous voulions protéger.</p>
<p>Chercher une colonne « nom » ne suffit donc pas. Il faut parcourir l'interface comme l'utilisateur et ajouter ce qu'il sait par son travail : plannings, visages connus, service de la veille. Une vue doit être évaluée avec les autres informations auxquelles l'utilisateur a accès.</p>
<p>Je retirerais de cette vue le lien vers l'appareil précis. Le nombre de places occupées et l'état libre ou occupé peuvent suffire. Les autorisations doivent être examinées séparément, et les journaux d'accès ne doivent conserver que les données nécessaires. Même alors, on ne peut déclarer l'ensemble anonyme sans examen supplémentaire.</p>
<p>Le test pratique consiste à chercher ce que cet utilisateur peut déduire de deux écrans. Parfois, la meilleure protection est une étiquette commode en moins.</p>
<p><em>Exemple fictif de risque de conception, sans description d'une fuite ni analyse juridique d'un système particulier.</em></p>
<p><small><em>Information Commissioner’s Office. <a href="https://ico.org.uk/for-organisations/uk-gdpr-guidance-and-resources/data-sharing/anonymisation/how-do-we-ensure-anonymisation-is-effective/">How do we ensure anonymisation is effective?</a></em></small></p>

HTML,
        ],
        'es' => [
            'title' => 'Borramos el nombre. La persona seguía visible.',
            'image_alt' => 'Dos paneles translúcidos forman una silueta humana donde se superponen.',
            'excerpt' => 'Dos detalles aparentemente inocuos pueden revelar juntos lo que ocultan por separado. Hay que examinar la privacidad desde la perspectiva de quien ve varias pantallas.',
            'content' => <<<'HTML'
<p>Imaginemos una vista de ocupación en un centro sanitario. Un técnico ve la cama, el turno y el identificador de la máquina. Un registro separado indica para qué grupo de pacientes se reserva ese equipo. No necesita el nombre del paciente: al combinar los datos puede llegar a deducir información sensible sobre quien ocupa la cama. Toda la situación es hipotética; no describe un centro ni un paciente concreto.</p>
<p>La primera pantalla no mostraba diagnósticos. La segunda no mostraba pacientes. Juntas revelaban algo que no queríamos compartir.</p>
<p>Buscar una columna llamada «nombre» no basta. Hay que recorrer la interfaz como el usuario y sumar sus conocimientos del trabajo: turnos, caras conocidas, la jornada anterior. Cada vista debe evaluarse junto con la demás información a la que tiene acceso el usuario.</p>
<p>Quitaría de esa vista el vínculo con la máquina concreta. Los recuentos y el estado libre/ocupado pueden bastar. Los permisos requieren evaluación aparte; los registros de acceso, solo datos necesarios. Ni siquiera entonces cabe declarar anónima toda la vista sin más análisis.</p>
<p>La prueba práctica es qué puede deducir este usuario al combinar dos pantallas. A veces protege más prescindir de una etiqueta cómoda.</p>
<p><em>Ejemplo ficticio de un riesgo de diseño, no descripción de una filtración ni valoración jurídica de un sistema concreto.</em></p>
<p><small><em>Information Commissioner’s Office. <a href="https://ico.org.uk/for-organisations/uk-gdpr-guidance-and-resources/data-sharing/anonymisation/how-do-we-ensure-anonymisation-is-effective/">How do we ensure anonymisation is effective?</a></em></small></p>

HTML,
        ],
        'pl' => [
            'title' => 'Usunęliśmy nazwisko. Człowiek nadal był widoczny.',
            'image_alt' => 'Dwa półprzezroczyste panele tworzą sylwetkę człowieka w miejscu nałożenia.',
            'excerpt' => 'Dwie pozornie niewinne informacje mogą wspólnie ujawnić to, co osobno ukrywają. Prywatność trzeba oceniać oczami osoby, która widzi kilka ekranów.',
            'content' => <<<'HTML'
<p>Wyobraźmy sobie widok zajętości łóżek w placówce medycznej. Technik widzi łóżko, zmianę i oznaczenie aparatu. Osobny rejestr wyjaśnia, dla jakiej grupy pacjentów przeznaczono sprzęt. Nazwisko pacjenta nie jest potrzebne: połączenie danych może pozwolić wywnioskować wrażliwą informację o osobie na łóżku. Cała sytuacja jest modelowa, nie opisuje konkretnej placówki ani pacjenta.</p>
<p>Pierwszy ekran nie pokazywał rozpoznania. Drugi nie pokazywał pacjenta. Razem ujawniły jednak coś, czego nie zamierzaliśmy udostępniać.</p>
<p>Szukanie kolumny „nazwisko” nie wystarczy. Trzeba przejść przez interfejs jak użytkownik i uwzględnić jego wiedzę z pracy: grafik, znajome twarze, poprzedni dyżur. Każdy widok trzeba oceniać łącznie z innymi informacjami dostępnymi użytkownikowi.</p>
<p>Usunąłbym z tego widoku powiązanie z konkretnym aparatem. Liczby i stan wolne/zajęte mogą wystarczyć. Uprawnienia wymagają osobnej oceny, a w dziennikach dostępu należy zachować tylko niezbędne dane. Nawet wtedy nie można bez dalszej analizy uznać całego widoku za anonimowy.</p>
<p>Praktyczny test brzmi: co ten użytkownik wywnioskuje z dwóch ekranów? Czasem najlepiej chroni brak jednej wygodnej etykiety.</p>
<p><em>Fikcyjny przykład ryzyka projektowego, nie opis wycieku danych ani ocena prawna konkretnego systemu.</em></p>
<p><small><em>Information Commissioner’s Office. <a href="https://ico.org.uk/for-organisations/uk-gdpr-guidance-and-resources/data-sharing/anonymisation/how-do-we-ensure-anonymisation-is-effective/">How do we ensure anonymisation is effective?</a></em></small></p>

HTML,
        ],
        'hu' => [
            'title' => 'Töröltük a nevet. Az ember látható maradt.',
            'image_alt' => 'Két áttetsző lap az átfedésben emberi alak árnyékát rajzolja ki.',
            'excerpt' => 'Két ártatlannak tűnő adat együtt elárulhatja azt, amit külön-külön elfed. Az adatvédelmet annak szemével kell nézni, aki több képernyőt lát.',
            'content' => <<<'HTML'
<p>Képzeljünk el egy ágyfoglaltsági nézetet egy egészségügyi intézményben. A technikus látja az ágyat, a műszakot és a gép jelölését. Egy külön eszköznyilvántartásból megtudja, mely betegcsoportnak tartják fenn a gépet. A beteg nevére nincs szüksége: az adatok összekapcsolásából érzékeny információra következtethet az ágyon fekvő emberről. Az egész helyzet szemléltető példa, nem egy konkrét intézmény vagy beteg leírása.</p>
<p>Az első képernyőn nem volt diagnózis, a másodikon beteg. Együtt mégis olyasmit árultak el, amit nem akartunk hozzáférhetővé tenni.</p>
<p>Ezért nem elég a „név” oszlopot keresni. Úgy kell végigjárni a felületet, ahogy a felhasználó, hozzászámítva a munkából hozott tudását: beosztásokat, ismerős arcokat, a tegnapi műszakot. Az egyes nézeteket a felhasználó számára elérhető többi információval együtt kell értékelni.</p>
<p>Ebből a nézetből eltávolítanám a konkrét géphez vezető kapcsolatot. A foglalt helyek száma és a szabad/foglalt állapot elegendő lehet. A jogosultságokat külön kell értékelni; a hozzáférési naplóba csak szükséges adat kerüljön. További vizsgálat nélkül még így sem nevezhető anonimnak az egész nézet.</p>
<p>A gyakorlati próba az, mire következtethet ez a felhasználó két képernyőből. Néha egy kényelmes címke elhagyása véd a legjobban.</p>
<p><em>Fiktív tervezési kockázat, nem adatszivárgás leírása vagy egy konkrét rendszer jogi értékelése.</em></p>
<p><small><em>Information Commissioner’s Office. <a href="https://ico.org.uk/for-organisations/uk-gdpr-guidance-and-resources/data-sharing/anonymisation/how-do-we-ensure-anonymisation-is-effective/">How do we ensure anonymisation is effective?</a></em></small></p>

HTML,
        ],
        'it' => [
            'title' => 'Abbiamo tolto il nome. La persona era ancora visibile.',
            'image_alt' => 'Due pannelli traslucidi formano una sagoma umana nella zona di sovrapposizione.',
            'excerpt' => 'Due dettagli apparentemente innocui possono rivelare insieme ciò che nascondono separatamente. La riservatezza va esaminata con gli occhi di chi vede più schermate.',
            'content' => <<<'HTML'
<p>Immaginiamo una schermata con l'occupazione dei letti in una struttura sanitaria. Un tecnico vede il letto, il turno e il codice dell'apparecchio. Un registro separato indica a quale gruppo di pazienti è riservata quella macchina. Il nome del paziente non serve: incrociando i dati, il tecnico potrebbe dedurre un'informazione sensibile sulla persona nel letto. L'intera situazione è ipotetica e non descrive una struttura o un paziente specifico.</p>
<p>La prima schermata non mostrava diagnosi. La seconda non mostrava pazienti. Insieme rivelavano comunque ciò che non volevamo condividere.</p>
<p>Cercare una colonna chiamata «nome» non basta. Occorre percorrere l'interfaccia come l'utente e aggiungere ciò che sa dal lavoro: turni, volti noti, servizio del giorno prima. Ogni schermata va valutata insieme alle altre informazioni accessibili all'utente.</p>
<p>Toglierei da questa vista il collegamento alla macchina specifica. Conteggi e stato libero/occupato possono bastare. I permessi vanno valutati separatamente e i registri degli accessi devono conservare solo i dati necessari. Neppure allora l'intera vista può essere dichiarata anonima senza ulteriori verifiche.</p>
<p>La prova pratica è che cosa questo utente possa dedurre da due schermate. A volte protegge di più rinunciare a un'etichetta comoda.</p>
<p><em>Esempio immaginario di rischio progettuale, non resoconto di una fuga di dati né valutazione giuridica di un sistema specifico.</em></p>
<p><small><em>Information Commissioner’s Office. <a href="https://ico.org.uk/for-organisations/uk-gdpr-guidance-and-resources/data-sharing/anonymisation/how-do-we-ensure-anonymisation-is-effective/">How do we ensure anonymisation is effective?</a></em></small></p>

HTML,
        ],
        'uk' => [
            'title' => 'Ім’я видалили. Людина залишилася видимою.',
            'image_alt' => 'Дві напівпрозорі панелі утворюють силует людини в місці накладання.',
            'excerpt' => 'Дві начебто невинні деталі разом можуть видати те, що приховують окремо. Приватність треба оцінювати очима того, хто бачить кілька екранів.',
            'content' => <<<'HTML'
<p>Уявімо огляд зайнятості ліжок у медичному закладі. Технік бачить ліжко, робочу зміну й позначення апарата. В окремому реєстрі зазначено, для якої групи пацієнтів призначено цей апарат. Ім’я пацієнта не потрібне: поєднання даних може дозволити зробити висновок про чутливу інформацію щодо людини на ліжку. Уся ситуація умовна, вона не описує конкретного закладу чи пацієнта.</p>
<p>Перший екран не показував діагнозу. Другий не показував пацієнта. Разом вони все ж розкрили те, чого ми не хотіли оприлюднювати.</p>
<p>Тому недостатньо шукати в базі стовпець «ім’я». Треба пройти інтерфейс як користувач і врахувати його робочі знання: графіки, знайомі обличчя, учорашню зміну. Кожен екран треба оцінювати разом з іншою інформацією, доступною користувачеві.</p>
<p>Я прибрав би з цього огляду зв’язок із конкретним апаратом. Кількості та стану вільно/зайнято може вистачити. Права доступу потребують окремої оцінки, а в журналах доступу слід зберігати лише необхідні дані. Навіть тоді не можна без додаткової перевірки назвати весь огляд анонімним.</p>
<p>Практична перевірка: що цей користувач може вивести з двох екранів? Іноді найкраще захищає відмова від однієї зручної позначки.</p>
<p><em>Вигаданий приклад ризику проєктування, не повідомлення про витік даних і не правова оцінка конкретної системи.</em></p>
<p><small><em>Information Commissioner’s Office. <a href="https://ico.org.uk/for-organisations/uk-gdpr-guidance-and-resources/data-sharing/anonymisation/how-do-we-ensure-anonymisation-is-effective/">How do we ensure anonymisation is effective?</a></em></small></p>

HTML,
        ],
    ],
];
