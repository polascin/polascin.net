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
            'excerpt' => 'Dva nevinné údaje môžu spolu prezradiť to, čo každý zvlášť tají. Ochranu súkromia treba čítať očami človeka, ktorý vidí viac než jednu obrazovku.',
            'content' => <<<'HTML'
<p>V modelovom centre Javorový dvor otvorí technik prehľad obsadenosti. Vidí lôžko, zmenu a označenie prístroja. V susednej evidencii nájde vysvetlenie, pre akú skupinu pacientov je prístroj vyhradený. Meno nepotreboval. Spojenie údajov mu umožnilo odhadnúť citlivú informáciu o človeku na lôžku. Názov centra je vymyslený.</p>
<p>Prvá obrazovka neukázala diagnózu. Druhá neukázala pacienta. Ich súvislosť však vytvorila informáciu, ktorú sme nechceli sprístupniť.</p>
<p>Preto nestačí hľadať v databáze stĺpec „meno“. Treba sa prejsť tým istým rozhraním ako používateľ a pripočítať vedomosti, ktoré si prináša z práce. Rozpis zmien, známe tváre, včerajšia služba. Jedna obrazovka nemusí byť celým rozhovorom systému.</p>
<p>V takom návrhu by som z prehľadu obsadenosti odstránil väzbu na konkrétny prístroj. Technikovi môže stačiť počet obsadených miest a ich stav. Oprávnenia treba posúdiť osobitne a v zázname o prístupe uchovať iba potrebné údaje. Ani potom nemožno bez ďalšieho posúdenia vyhlásiť celý prehľad za anonymný.</p>
<p>Praktická skúška znie: čo si môže tento používateľ domyslieť, keď spojí dve obrazovky? Niekedy je najlepšou ochranou vynechať jednu pohodlnú menovku.</p>
<p><em>Fiktívny príklad návrhového rizika, nie správa o úniku údajov. Text nie je právnym posúdením konkrétneho systému.</em></p>
<p><small><em>Information Commissioner’s Office. <a href="https://ico.org.uk/for-organisations/uk-gdpr-guidance-and-resources/data-sharing/anonymisation/how-do-we-ensure-anonymisation-is-effective/">How do we ensure anonymisation is effective?</a></em></small></p>

HTML,
        ],
        'en' => [
            'title' => 'We removed the name. The person remained visible.',
            'image_alt' => 'Two translucent panels form a human silhouette where they overlap.',
            'excerpt' => 'Two innocent-looking details can reveal together what each conceals alone. Privacy needs to be read through the eyes of someone who sees more than one screen.',
            'content' => <<<'HTML'
<p>At the fictional Maple Court centre, a technician opens an occupancy view showing a bed, shift and machine label. An adjacent registry explains which patient group that machine serves. No name was needed. Combining the details allowed an inference about the person in the bed. The centre's name is invented.</p>
<p>The first screen showed no diagnosis. The second showed no patient. Their connection nevertheless revealed information we had not intended to share.</p>
<p>Looking for a database column called “name” is therefore insufficient. Walk through the interface as the user would, including knowledge brought from work: rosters, familiar faces, yesterday's shift. A single screen may not be the system's whole conversation.</p>
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
<p>V modelovém centru Javorový dvůr otevře technik přehled obsazenosti. Vidí lůžko, směnu a označení přístroje. V sousední evidenci zjistí, pro kterou skupinu pacientů je přístroj vyhrazen. Jméno nepotřeboval. Spojení údajů umožnilo odhadnout citlivou informaci o člověku na lůžku. Název centra je vymyšlený.</p>
<p>První obrazovka neukázala diagnózu. Druhá neukázala pacienta. Jejich souvislost přesto vytvořila informaci, kterou jsme nechtěli zpřístupnit.</p>
<p>Nestačí proto hledat v databázi sloupec „jméno“. Je třeba projít rozhraní jako uživatel a přičíst znalosti z práce: rozpis směn, známé tváře, včerejší službu. Jedna obrazovka nemusí být celou výpovědí systému.</p>
<p>Z takového přehledu bych odstranil vazbu na konkrétní přístroj. Technikovi mohou stačit počty a stav obsazeno/volno. Oprávnění vyžadují samostatné posouzení, záznamy o přístupu pouze potřebné údaje. Ani pak nelze bez dalšího posouzení označit celý přehled za anonymní.</p>
<p>Praktická zkouška zní: co si tento uživatel odvodí spojením dvou obrazovek? Někdy nejlépe chrání vynechání jedné pohodlné popisky.</p>
<p><em>Fiktivní příklad návrhového rizika, nikoli zpráva o úniku údajů či právní posouzení konkrétního systému.</em></p>
<p><small><em>Information Commissioner’s Office. <a href="https://ico.org.uk/for-organisations/uk-gdpr-guidance-and-resources/data-sharing/anonymisation/how-do-we-ensure-anonymisation-is-effective/">How do we ensure anonymisation is effective?</a></em></small></p>

HTML,
        ],
        'de' => [
            'title' => 'Der Name ist gelöscht. Der Mensch bleibt erkennbar.',
            'image_alt' => 'Zwei durchscheinende Tafeln bilden in ihrer Überlagerung eine menschliche Silhouette.',
            'excerpt' => 'Zwei harmlos wirkende Angaben können gemeinsam verraten, was jede für sich verbirgt. Datenschutz muss die Perspektive eines Menschen mit mehreren Bildschirmen berücksichtigen.',
            'content' => <<<'HTML'
<p>Im fiktiven Zentrum Ahornhof öffnet ein Techniker die Belegungsübersicht. Er sieht Bett, Schicht und Gerätekennung. Im benachbarten Register steht, welcher Patientengruppe das Gerät vorbehalten ist. Einen Namen braucht er nicht. Die Verknüpfung ermöglicht einen sensiblen Rückschluss auf den Menschen im Bett. Der Zentrumsname ist erfunden.</p>
<p>Der erste Bildschirm zeigte keine Diagnose, der zweite keinen Patienten. Zusammen offenbarten sie dennoch etwas, das nicht zugänglich sein sollte.</p>
<p>Eine Datenbankspalte namens „Name“ zu suchen reicht deshalb nicht. Man muss die Oberfläche wie der Nutzer durchgehen und dessen Arbeitswissen einbeziehen: Dienstpläne, bekannte Gesichter, die gestrige Schicht. Ein Bildschirm ist nicht die ganze Aussage des Systems.</p>
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
<p>Dans le centre fictif Cour des érables, un technicien ouvre le tableau d'occupation. Il voit un lit, une plage horaire et l'identifiant d'un appareil. Le registre voisin indique à quel groupe de patients cet appareil est réservé. Aucun nom n'était nécessaire. Le rapprochement permet une déduction sensible sur la personne occupant le lit. Le nom du centre est inventé.</p>
<p>Le premier écran ne montrait aucun diagnostic, le second aucun patient. Ensemble, ils révélaient pourtant ce que nous voulions protéger.</p>
<p>Chercher une colonne « nom » ne suffit donc pas. Il faut parcourir l'interface comme l'utilisateur et ajouter ce qu'il sait par son travail : plannings, visages connus, service de la veille. Un écran ne constitue pas toute la conversation du système.</p>
<p>Je retirerais de cette vue le lien vers l'appareil précis. Les effectifs et l'état libre/occupé peuvent suffire. Les autorisations demandent une analyse distincte et les journaux d'accès seulement les données nécessaires. Même alors, on ne peut déclarer l'ensemble anonyme sans examen supplémentaire.</p>
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
<p>En el centro ficticio Patio de los Arces, un técnico abre la vista de ocupación. Ve cama, turno e identificador de una máquina. El registro contiguo explica para qué grupo de pacientes se reserva ese equipo. No necesitó un nombre. La combinación permite inferir información sensible sobre quien ocupa la cama. El nombre del centro es inventado.</p>
<p>La primera pantalla no mostraba diagnósticos. La segunda no mostraba pacientes. Juntas revelaban algo que no queríamos compartir.</p>
<p>Buscar una columna llamada «nombre» no basta. Hay que recorrer la interfaz como el usuario y sumar sus conocimientos del trabajo: turnos, caras conocidas, la jornada anterior. Una pantalla no cuenta toda la conversación del sistema.</p>
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
<p>W fikcyjnym ośrodku Klonowy Dwór technik otwiera widok zajętości. Widzi łóżko, zmianę i oznaczenie aparatu. W sąsiednim rejestrze znajduje wyjaśnienie, dla jakiej grupy pacjentów zarezerwowano sprzęt. Nazwisko nie było potrzebne. Połączenie danych pozwala wywnioskować wrażliwą informację o osobie na łóżku. Nazwa ośrodka jest zmyślona.</p>
<p>Pierwszy ekran nie pokazywał rozpoznania. Drugi nie pokazywał pacjenta. Razem ujawniły jednak coś, czego nie zamierzaliśmy udostępniać.</p>
<p>Szukanie kolumny „nazwisko” nie wystarczy. Trzeba przejść przez interfejs jak użytkownik i uwzględnić jego wiedzę z pracy: grafik, znajome twarze, poprzedni dyżur. Jeden ekran nie jest całą wypowiedzią systemu.</p>
<p>Usunąłbym z tego widoku powiązanie z konkretnym aparatem. Liczby i stan wolne/zajęte mogą wystarczyć. Uprawnienia wymagają osobnej oceny, a dzienniki dostępu wyłącznie potrzebnych danych. Nawet wtedy nie można bez dalszej analizy uznać całego widoku za anonimowy.</p>
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
<p>A kitalált Juharudvar központban a technikus megnyitja a foglaltsági nézetet. Látja az ágyat, a műszakot és a gép jelölését. A szomszédos nyilvántartásból megtudja, mely betegcsoportnak tartják fenn a gépet. Név sem kellett hozzá. Az adatok összekapcsolása érzékeny következtetést tesz lehetővé az ágyon fekvő emberről. A központ neve kitalált.</p>
<p>Az első képernyőn nem volt diagnózis, a másodikon beteg. Együtt mégis olyasmit árultak el, amit nem akartunk hozzáférhetővé tenni.</p>
<p>Ezért nem elég a „név” oszlopot keresni. Úgy kell végigjárni a felületet, ahogy a felhasználó, hozzászámítva a munkából hozott tudását: beosztásokat, ismerős arcokat, a tegnapi műszakot. Egy képernyő nem a rendszer teljes közlése.</p>
<p>Ebből a nézetből eltávolítanám a konkrét géphez vezető kapcsolatot. A létszám és a szabad/foglalt állapot elegendő lehet. A jogosultságokat külön kell értékelni; a hozzáférési naplóba csak szükséges adat kerüljön. További vizsgálat nélkül még így sem nevezhető anonimnak az egész nézet.</p>
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
<p>Nel centro immaginario Corte degli Aceri, un tecnico apre la vista delle occupazioni. Vede letto, turno e codice dell'apparecchio. Il registro accanto spiega a quale gruppo di pazienti è riservata quella macchina. Non serviva un nome. L'incrocio permette di dedurre un'informazione sensibile sulla persona nel letto. Il nome del centro è inventato.</p>
<p>La prima schermata non mostrava diagnosi. La seconda non mostrava pazienti. Insieme rivelavano comunque ciò che non volevamo condividere.</p>
<p>Cercare una colonna chiamata «nome» non basta. Occorre percorrere l'interfaccia come l'utente e aggiungere ciò che sa dal lavoro: turni, volti noti, servizio del giorno prima. Una schermata non è tutta la conversazione del sistema.</p>
<p>Toglierei da questa vista il collegamento alla macchina specifica. Conteggi e stato libero/occupato possono bastare. I permessi richiedono una valutazione distinta; i registri degli accessi solo i dati necessari. Neppure allora l'intera vista può essere dichiarata anonima senza ulteriori verifiche.</p>
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
<p>У вигаданому центрі Кленовий двір технік відкриває огляд зайнятості. Бачить ліжко, зміну й позначення апарата. У сусідньому реєстрі знаходить пояснення, для якої групи пацієнтів призначено апарат. Ім’я не знадобилося. Поєднання даних дозволяє зробити чутливий висновок про людину на ліжку. Назва центру вигадана.</p>
<p>Перший екран не показував діагнозу. Другий не показував пацієнта. Разом вони все ж розкрили те, чого ми не хотіли оприлюднювати.</p>
<p>Тому недостатньо шукати в базі стовпець «ім’я». Треба пройти інтерфейс як користувач і врахувати його робочі знання: графіки, знайомі обличчя, учорашню зміну. Один екран не є всім повідомленням системи.</p>
<p>Я прибрав би з цього огляду зв’язок із конкретним апаратом. Кількості та стану вільно/зайнято може вистачити. Права доступу потребують окремої оцінки, а журнали доступу лише необхідних даних. Навіть тоді не можна без додаткової перевірки назвати весь огляд анонімним.</p>
<p>Практична перевірка: що цей користувач може вивести з двох екранів? Іноді найкраще захищає відмова від однієї зручної позначки.</p>
<p><em>Вигаданий приклад ризику проєктування, не повідомлення про витік даних і не правова оцінка конкретної системи.</em></p>
<p><small><em>Information Commissioner’s Office. <a href="https://ico.org.uk/for-organisations/uk-gdpr-guidance-and-resources/data-sharing/anonymisation/how-do-we-ensure-anonymisation-is-effective/">How do we ensure anonymisation is effective?</a></em></small></p>

HTML,
        ],
    ],
];
