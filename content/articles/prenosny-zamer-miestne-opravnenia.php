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
 * Esej o rozlíšení prenosného zámeru a miestneho prostredia
 * pri práci s viacerými AI asistentmi. Názvy nástrojov, zariadení
 * a ciest sú zovšeobecnené alebo fiktívne; synchronizácia nie je
 * deklarovaná ako hotová.
 */
return [
    'slug' => 'prenosny-zamer-miestne-opravnenia',
    'author' => 'MUDr. Ľubomír Polaščín',
    'category' => 'blog',
    'is_top' => 0,
    'published_at' => '2026-11-14 11:18:00',
    'image' => 'images/articles/prenosny-zamer-miestne-opravnenia.webp',
    'translations' => [
        'sk' => [
            'title' => 'Prenosný zámer, miestne oprávnenia',
            'image_alt' => 'Dva fialové stoly v jednej miestnosti. Z ľavého stola vystupuje jemný tyrkysový prúd spoločných pravidiel; pravý stôl má vlastný kľúč, vlastnú cestu a uzavretú skrinku.',
            'excerpt' => 'Chcel som synchronizovať všetko. Čo som naozaj potreboval, bolo prestať sa znova predstavovať svojim asistentom. Zámer môže putovať. Prihlasovacie údaje, cesty a oprávnenia majú ostať doma.',
            'content' => <<<'HTML'
<p>Chcel som synchronizovať všetko. Čo som naozaj potreboval, bolo prestať sa znova predstavovať svojim asistentom.</p>
<p>Začal som širokou žiadosťou: nech sa zjednotia počítače, tablety a telefóny. Potom som to spresnil. Nešlo o celý systém. Išlo o nastavenia AI nástrojov: spoločné pokyny, predvoľby a opakovane použiteľné návody. Nastavenia viazané na konkrétny stroj mali ostať oddelené.</p>
<p>Toto rozlíšenie zmenilo celý problém.</p>
<p>Skopírovať priečinok nie je to isté ako dosiahnuť, aby niekoľko asistentov pracovalo podľa rovnakých pravidiel. A zjednotiť pravidlá neznamená, že každé zariadenie má zdediť rovnaké prihlasovacie údaje, oprávnenia ani miestne cesty.</p>
<p>Užitočný rez je medzi zámerom a prostredím.</p>
<p>Zámer je prenosný: ako mám chcieť napísané odpovede, ktoré kontroly má postup vyžadovať, čo má robiť opakovane použiteľný návod. Prostredie je miestne: kde ležia súbory, ktoré prepojenia sú dostupné, čo smie konkrétny stroj otvoriť.</p>
<p>Predstavme si fiktívnu súpravu asistentov, ktorú tu označím ako „Notebook“, „Forge“, „Studio“, „Relay“, „Atlas“ a „Canvas“. Každý môže čítať ten istý súbor spoločných pravidiel. Žiadny z nich však nemá automaticky získať kľúče, cesty ani oprávnenia z iného stola.</p>
<p>Že je táto synchronizácia hotová, netvrdím. Ide o návrh v priebehu, nie o hotovú automatizáciu.</p>
<p>Žiadosť však odhalila skutočnú cenu: udržiavať rovnaké predvoľby oddelene pri každom asistentovi. Pred ďalším AI nástrojom mám teraz lepšiu otázku než „Je jeho model lepší?“</p>
<p>Koľko z môjho pracovného kontextu dokáže znova použiť, bez toho aby si priniesol predpoklady zo zlého stroja?</p>
<p><em>Redakčná úvaha o rozlíšení prenosného zámeru a miestneho prostredia. Označenia asistentov a okolnosti sú fiktívne alebo zovšeobecnené náhrady. Neopisujú konkrétne produkty, firmy ani identifikovateľné zariadenia; dokončenie synchronizácie nie je overené.</em></p>

HTML,
        ],
        'en' => [
            'title' => 'Portable intent, local permissions',
            'image_alt' => 'Two violet desks in one room. From the left desk a soft teal stream of shared rules rises; the right desk keeps its own key, its own path and a closed cabinet.',
            'excerpt' => 'I asked to synchronise everything. What I actually needed was to stop reintroducing myself to my AI tools. Intent can travel. Credentials, paths and permissions should stay at home.',
            'content' => <<<'HTML'
<p>I asked to synchronise everything. What I actually needed was to stop reintroducing myself to my AI tools.</p>
<p>I began with a broad request: let the computers, tablets and phones line up. Then I narrowed it. This was not about the whole system. It was about the settings of my AI tools: shared instructions, preferences and reusable guides. Machine-specific settings were to stay separate.</p>
<p>That distinction changed the problem.</p>
<p>Copying a folder is not the same as getting several assistants to work from the same rules. And making their rules consistent does not mean every device should inherit the same credentials, permissions or local paths.</p>
<p>The useful cut is between intent and environment.</p>
<p>Intent is portable: how I want answers written, which checks a workflow should require, what a reusable guide should do. Environment is local: where files live, which integrations are available, what a particular machine is allowed to open.</p>
<p>Imagine a fictional suite of assistants I label here as “Notebook”, “Forge”, “Studio”, “Relay”, “Atlas” and “Canvas”. Each may read the same shared rule file. None of them should automatically receive keys, paths or permissions from another desk.</p>
<p>I do not claim this synchronisation is finished. It is a design decision in progress, not a completed automation story.</p>
<p>But the request exposed a real cost: maintaining the same preferences separately for each assistant. Before adding another AI tool, I now have a better question than “Is its model better?”</p>
<p>How much of my working context can it reuse without importing the wrong machine’s assumptions?</p>
<p><em>An editorial reflection on separating portable intent from local environment. The assistant labels and circumstances are fictional or generalised substitutes. They do not describe specific products, companies or identifiable devices; completion of the synchronisation has not been verified.</em></p>

HTML,
        ],
        'cs' => [
            'title' => 'Přenosný záměr, místní oprávnění',
            'image_alt' => 'Dva fialové stoly v jedné místnosti. Z levého stolu vystupuje jemný tyrkysový proud společných pravidel; pravý stůl má vlastní klíč, vlastní cestu a zavřenou skříňku.',
            'excerpt' => 'Chtěl jsem synchronizovat všechno. Co jsem opravdu potřeboval, bylo přestat se znovu představovat svým asistentům. Záměr může putovat. Přihlašovací údaje, cesty a oprávnění mají zůstat doma.',
            'content' => <<<'HTML'
<p>Chtěl jsem synchronizovat všechno. Co jsem opravdu potřeboval, bylo přestat se znovu představovat svým asistentům.</p>
<p>Začal jsem širokou žádostí: ať se sjednotí počítače, tablety a telefony. Pak jsem to upřesnil. Nešlo o celý systém. Šlo o nastavení AI nástrojů: společné pokyny, preference a znovupoužitelné návody. Nastavení vázaná na konkrétní stroj měla zůstat oddělená.</p>
<p>Toto rozlišení změnilo celý problém.</p>
<p>Zkopírovat složku není totéž jako dosáhnout, aby několik asistentů pracovalo podle stejných pravidel. A sjednotit pravidla neznamená, že každé zařízení má zdědit stejné přihlašovací údaje, oprávnění ani místní cesty.</p>
<p>Užitečný řez je mezi záměrem a prostředím.</p>
<p>Záměr je přenosný: jak chci mít napsané odpovědi, které kontroly má postup vyžadovat, co má dělat znovupoužitelný návod. Prostředí je místní: kde leží soubory, které integrace jsou dostupné, co smí konkrétní stroj otevřít.</p>
<p>Představme si fiktivní sadu asistentů, kterou zde označím jako „Notebook“, „Forge“, „Studio“, „Relay“, „Atlas“ a „Canvas“. Každý může číst tentýž soubor společných pravidel. Žádný z nich však nemá automaticky získat klíče, cesty ani oprávnění z jiného stolu.</p>
<p>Že je tato synchronizace hotová, netvrdím. Jde o návrh v průběhu, ne o hotovou automatizaci.</p>
<p>Žádost však odhalila skutečnou cenu: udržovat stejné preference odděleně u každého asistenta. Před dalším AI nástrojem mám teď lepší otázku než „Je jeho model lepší?“</p>
<p>Kolik z mého pracovního kontextu dokáže znovu použít, aniž by si přinesl předpoklady ze špatného stroje?</p>
<p><em>Redakční úvaha o rozlišení přenosného záměru a místního prostředí. Označení asistentů a okolnosti jsou fiktivní nebo zobecněné náhrady. Neopisují konkrétní produkty, firmy ani identifikovatelná zařízení; dokončení synchronizace není ověřeno.</em></p>

HTML,
        ],
        'de' => [
            'title' => 'Tragbare Absicht, lokale Berechtigungen',
            'image_alt' => 'Zwei violette Schreibtische in einem Raum. Vom linken Tisch steigt ein sanfter türkiser Strom gemeinsamer Regeln; der rechte Tisch behält den eigenen Schlüssel, den eigenen Pfad und einen geschlossenen Schrank.',
            'excerpt' => 'Ich wollte alles synchronisieren. Was ich wirklich brauchte, war, mich meinen Assistenten nicht immer wieder vorzustellen. Absicht darf wandern. Zugangsdaten, Pfade und Berechtigungen sollen zu Hause bleiben.',
            'content' => <<<'HTML'
<p>Ich wollte alles synchronisieren. Was ich wirklich brauchte, war, mich meinen Assistenten nicht immer wieder vorzustellen.</p>
<p>Ich begann mit einer weiten Bitte: Computer, Tablets und Telefone sollten sich angleichen. Dann grenzte ich ein. Es ging nicht um das ganze System. Es ging um die Einstellungen meiner KI-Werkzeuge: gemeinsame Anweisungen, Vorlieben und wiederverwendbare Leitfäden. Maschinenspezifische Einstellungen sollten getrennt bleiben.</p>
<p>Diese Unterscheidung veränderte das Problem.</p>
<p>Einen Ordner zu kopieren ist nicht dasselbe, wie mehrere Assistenten nach denselben Regeln arbeiten zu lassen. Und Regeln anzugleichen heißt nicht, dass jedes Gerät dieselben Zugangsdaten, Berechtigungen oder lokalen Pfade erben soll.</p>
<p>Der nützliche Schnitt liegt zwischen Absicht und Umgebung.</p>
<p>Absicht ist tragbar: wie Antworten geschrieben sein sollen, welche Prüfungen ein Ablauf verlangen soll, was ein wiederverwendbarer Leitfaden tun soll. Umgebung ist lokal: wo Dateien liegen, welche Integrationen verfügbar sind, was eine bestimmte Maschine öffnen darf.</p>
<p>Stellen wir uns eine fiktive Suite von Assistenten vor, die ich hier „Notebook“, „Forge“, „Studio“, „Relay“, „Atlas“ und „Canvas“ nenne. Jeder darf dieselbe gemeinsame Regeldatei lesen. Keiner soll automatisch Schlüssel, Pfade oder Berechtigungen von einem anderen Tisch erhalten.</p>
<p>Dass diese Synchronisation fertig sei, behaupte ich nicht. Es ist eine Entwurfsentscheidung im Gang, keine abgeschlossene Automatisierungsgeschichte.</p>
<p>Die Bitte legte jedoch echte Kosten offen: dieselben Vorlieben bei jedem Assistenten getrennt zu pflegen. Bevor ich ein weiteres KI-Werkzeug hinzufüge, habe ich jetzt eine bessere Frage als „Ist sein Modell besser?“</p>
<p>Wie viel meines Arbeitskontexts kann es wiederverwenden, ohne die Annahmen der falschen Maschine zu übernehmen?</p>
<p><em>Eine redaktionelle Überlegung zur Trennung tragbarer Absicht und lokaler Umgebung. Die Bezeichnungen der Assistenten und die Umstände sind fiktive oder verallgemeinerte Ersatzangaben. Sie beschreiben keine konkreten Produkte, Unternehmen oder identifizierbaren Geräte; der Abschluss der Synchronisation ist nicht verifiziert.</em></p>

HTML,
        ],
        'fr' => [
            'title' => 'Intention portable, permissions locales',
            'image_alt' => 'Deux bureaux violets dans une même pièce. Du bureau de gauche s’élève un fin courant turquoise de règles partagées ; celui de droite garde sa propre clé, son propre chemin et une armoire fermée.',
            'excerpt' => 'Je voulais tout synchroniser. Ce dont j’avais vraiment besoin, c’était de cesser de me représenter à mes assistants. L’intention peut voyager. Identifiants, chemins et permissions doivent rester chez eux.',
            'content' => <<<'HTML'
<p>Je voulais tout synchroniser. Ce dont j’avais vraiment besoin, c’était de cesser de me représenter à mes assistants.</p>
<p>J’ai commencé par une demande large : que les ordinateurs, tablettes et téléphones s’alignent. Puis j’ai précisé. Il ne s’agissait pas de tout le système. Il s’agissait des réglages de mes outils d’IA : instructions partagées, préférences et guides réutilisables. Les réglages liés à une machine donnée devaient rester séparés.</p>
<p>Cette distinction a changé le problème.</p>
<p>Copier un dossier n’est pas la même chose que faire travailler plusieurs assistants selon les mêmes règles. Et unifier les règles ne signifie pas que chaque appareil doive hériter des mêmes identifiants, permissions ou chemins locaux.</p>
<p>La coupure utile se situe entre l’intention et l’environnement.</p>
<p>L’intention est portable : comment je veux les réponses rédigées, quelles vérifications un flux doit exiger, ce qu’un guide réutilisable doit faire. L’environnement est local : où vivent les fichiers, quelles intégrations sont disponibles, ce qu’une machine donnée a le droit d’ouvrir.</p>
<p>Imaginons une suite fictive d’assistants que je désigne ici par « Notebook », « Forge », « Studio », « Relay », « Atlas » et « Canvas ». Chacun peut lire le même fichier de règles partagées. Aucun ne doit recevoir automatiquement les clés, chemins ou permissions d’un autre bureau.</p>
<p>Je ne prétends pas que cette synchronisation soit terminée. C’est une décision de conception en cours, pas une automatisation achevée.</p>
<p>La demande a pourtant révélé un vrai coût : maintenir les mêmes préférences séparément pour chaque assistant. Avant d’ajouter un autre outil d’IA, j’ai désormais une meilleure question que « Son modèle est-il meilleur ? »</p>
<p>Combien de mon contexte de travail peut-il réutiliser sans importer les hypothèses de la mauvaise machine ?</p>
<p><em>Réflexion éditoriale sur la séparation entre intention portable et environnement local. Les désignations des assistants et les circonstances sont des substituts fictifs ou généralisés. Elles ne décrivent ni produits, ni entreprises, ni appareils identifiables ; l’achèvement de la synchronisation n’est pas vérifié.</em></p>

HTML,
        ],
        'es' => [
            'title' => 'Intención portable, permisos locales',
            'image_alt' => 'Dos escritorios violetas en una misma habitación. Del de la izquierda asciende un suave flujo turquesa de reglas compartidas; el de la derecha guarda su propia llave, su propio camino y un armario cerrado.',
            'excerpt' => 'Quise sincronizarlo todo. Lo que realmente necesitaba era dejar de presentarme otra vez a mis asistentes. La intención puede viajar. Credenciales, rutas y permisos deben quedarse en casa.',
            'content' => <<<'HTML'
<p>Quise sincronizarlo todo. Lo que realmente necesitaba era dejar de presentarme otra vez a mis asistentes.</p>
<p>Empecé con una petición amplia: que se alinearan ordenadores, tabletas y teléfonos. Luego la acoté. No se trataba de todo el sistema. Se trataba de los ajustes de mis herramientas de IA: instrucciones compartidas, preferencias y guías reutilizables. Los ajustes ligados a una máquina concreta debían permanecer aparte.</p>
<p>Esa distinción cambió el problema.</p>
<p>Copiar una carpeta no es lo mismo que lograr que varios asistentes trabajen con las mismas reglas. Y unificar las reglas no significa que cada dispositivo deba heredar las mismas credenciales, permisos o rutas locales.</p>
<p>El corte útil está entre la intención y el entorno.</p>
<p>La intención es portable: cómo quiero las respuestas escritas, qué comprobaciones debe exigir un flujo, qué debe hacer una guía reutilizable. El entorno es local: dónde viven los archivos, qué integraciones hay, qué puede abrir una máquina concreta.</p>
<p>Imaginemos un conjunto ficticio de asistentes que aquí llamo «Notebook», «Forge», «Studio», «Relay», «Atlas» y «Canvas». Cada uno puede leer el mismo archivo de reglas compartidas. Ninguno debe recibir automáticamente claves, rutas o permisos de otro escritorio.</p>
<p>No afirmo que esta sincronización esté terminada. Es una decisión de diseño en curso, no una automatización acabada.</p>
<p>La petición, sin embargo, reveló un coste real: mantener las mismas preferencias por separado en cada asistente. Antes de añadir otra herramienta de IA, ahora tengo una pregunta mejor que «¿Es mejor su modelo?»</p>
<p>¿Cuánto de mi contexto de trabajo puede reutilizar sin importar las hipótesis de la máquina equivocada?</p>
<p><em>Reflexión editorial sobre la separación entre intención portable y entorno local. Las etiquetas de los asistentes y las circunstancias son sustitutos ficticios o generalizados. No describen productos, empresas ni dispositivos identificables; no se ha verificado que la sincronización esté completa.</em></p>

HTML,
        ],
        'pl' => [
            'title' => 'Przenośny zamiar, lokalne uprawnienia',
            'image_alt' => 'Dwa fioletowe biurka w jednym pokoju. Z lewego unosi się łagodny turkusowy strumień wspólnych reguł; prawe ma własny klucz, własną ścieżkę i zamkniętą szafkę.',
            'excerpt' => 'Chciałem zsynchronizować wszystko. Czego naprawdę potrzebowałem, to przestać przedstawiać się swoim asystentom od nowa. Zamiar może wędrować. Dane logowania, ścieżki i uprawnienia mają zostać w domu.',
            'content' => <<<'HTML'
<p>Chciałem zsynchronizować wszystko. Czego naprawdę potrzebowałem, to przestać przedstawiać się swoim asystentom od nowa.</p>
<p>Zacząłem od szerokiej prośby: niech ujednolicią się komputery, tablety i telefony. Potem to zawęziłem. Nie chodziło o cały system. Chodziło o ustawienia narzędzi AI: wspólne instrukcje, preferencje i wielokrotnego użytku przewodniki. Ustawienia związane z konkretną maszyną miały zostać oddzielone.</p>
<p>To rozróżnienie zmieniło cały problem.</p>
<p>Skopiować folder to nie to samo, co sprawić, by kilku asystentów pracowało według tych samych reguł. A ujednolicić reguły nie znaczy, że każde urządzenie ma odziedziczyć te same dane logowania, uprawnienia ani lokalne ścieżki.</p>
<p>Pożyteczny podział leży między zamiarem a środowiskiem.</p>
<p>Zamiar jest przenośny: jak mam chcieć napisane odpowiedzi, które kontrole ma wymagać przepływ pracy, co ma robić wielokrotnego użytku przewodnik. Środowisko jest lokalne: gdzie leżą pliki, które integracje są dostępne, co wolno otworzyć konkretnej maszynie.</p>
<p>Wyobraźmy sobie fikcyjny zestaw asystentów, który tutaj oznaczam jako „Notebook”, „Forge”, „Studio”, „Relay”, „Atlas” i „Canvas”. Każdy może czytać ten sam plik wspólnych reguł. Żaden nie powinien automatycznie dostać kluczy, ścieżek ani uprawnień z innego biurka.</p>
<p>Nie twierdzę, że ta synchronizacja jest gotowa. To decyzja projektowa w toku, nie ukończona automatyzacja.</p>
<p>Prośba jednak ujawniła prawdziwy koszt: utrzymywanie tych samych preferencji osobno u każdego asystenta. Przed kolejnym narzędziem AI mam teraz lepsze pytanie niż „Czy jego model jest lepszy?”</p>
<p>Ile z mojego kontekstu pracy potrafi ponownie użyć, nie przejmując założeń ze złej maszyny?</p>
<p><em>Refleksja redakcyjna o rozdzieleniu przenośnego zamiaru i lokalnego środowiska. Oznaczenia asystentów i okoliczności są fikcyjnymi lub uogólnionymi zastępnikami. Nie opisują konkretnych produktów, firm ani identyfikowalnych urządzeń; ukończenie synchronizacji nie zostało zweryfikowane.</em></p>

HTML,
        ],
        'hu' => [
            'title' => 'Hordozható szándék, helyi jogosultságok',
            'image_alt' => 'Két ibolya íróasztal egy szobában. A balról lágy türkiz áramlatként emelkednek a közös szabályok; a jobbnak saját kulcsa, saját útja és zárt szekrénye van.',
            'excerpt' => 'Mindent szinkronizálni akartam. Amire igazán szükségem volt: ne kelljen újra bemutatkoznom az asszisztenseimnek. A szándék utazhat. A hitelesítő adatok, útvonalak és jogosultságok otthon maradjanak.',
            'content' => <<<'HTML'
<p>Mindent szinkronizálni akartam. Amire igazán szükségem volt: ne kelljen újra bemutatkoznom az asszisztenseimnek.</p>
<p>Tág kéréssel kezdtem: igazodjanak a számítógépek, táblagépek és telefonok. Aztán pontosítottam. Nem az egész rendszerről volt szó. Az AI-eszközök beállításairól: közös utasításokról, preferenciákról és újrahasználható útmutatókról. A gépre kötött beállítások külön maradjanak.</p>
<p>Ez a megkülönböztetés megváltoztatta a problémát.</p>
<p>Egy mappa másolása nem ugyanaz, mint elérni, hogy több asszisztens ugyanazok a szabályok szerint dolgozzon. És a szabályok egységesítése nem jelenti, hogy minden eszköz ugyanazokat a hitelesítő adatokat, jogosultságokat vagy helyi útvonalakat örökölje.</p>
<p>A hasznos vágás a szándék és a környezet között van.</p>
<p>A szándék hordozható: hogyan akarom a válaszokat megírva, milyen ellenőrzéseket követeljen egy folyamat, mit tegyen egy újrahasználható útmutató. A környezet helyi: hol vannak a fájlok, mely integrációk érhetők el, mit nyithat meg egy adott gép.</p>
<p>Képzeljünk el egy fiktív asszisztenscsomagot, amelyet itt „Notebook”, „Forge”, „Studio”, „Relay”, „Atlas” és „Canvas” néven jelölök. Mindegyik olvashatja ugyanazt a közös szabályfájlt. Egyik sem kaphatja meg automatikusan a kulcsokat, útvonalakat vagy jogosultságokat egy másik asztalról.</p>
<p>Nem állítom, hogy ez a szinkronizálás kész. Folyamatban lévő tervezési döntés, nem befejezett automatizálási történet.</p>
<p>A kérés azonban feltárta a valódi költséget: ugyanazokat a preferenciákat külön tartani minden asszisztensnél. Mielőtt újabb AI-eszközt adnék hozzá, most jobb kérdésem van, mint az, hogy „Jobb-e a modellje?”</p>
<p>Munkakontextusom mekkora részét tudja újrahasználni anélkül, hogy a rossz gép feltételezéseit átvenné?</p>
<p><em>Szerkesztői elmélkedés a hordozható szándék és a helyi környezet szétválasztásáról. Az asszisztensek megnevezése és a körülmények fiktív vagy általánosított helyettesítők. Nem írnak le konkrét termékeket, cégeket vagy azonosítható eszközöket; a szinkronizálás befejezése nincs ellenőrizve.</em></p>

HTML,
        ],
        'it' => [
            'title' => 'Intento portabile, permessi locali',
            'image_alt' => 'Due scrivanie violette nella stessa stanza. Dalla sinistra sale un soffice flusso turchese di regole condivise; quella di destra tiene la propria chiave, il proprio percorso e un armadietto chiuso.',
            'excerpt' => 'Volevo sincronizzare tutto. Ciò di cui avevo davvero bisogno era smettere di ripresentarmi ai miei assistenti. L’intento può viaggiare. Credenziali, percorsi e permessi devono restare a casa.',
            'content' => <<<'HTML'
<p>Volevo sincronizzare tutto. Ciò di cui avevo davvero bisogno era smettere di ripresentarmi ai miei assistenti.</p>
<p>Ho iniziato con una richiesta ampia: che computer, tablet e telefoni si allineassero. Poi ho ristretto. Non riguardava l’intero sistema. Riguardava le impostazioni dei miei strumenti di IA: istruzioni condivise, preferenze e guide riutilizzabili. Le impostazioni legate a una macchina specifica dovevano restare separate.</p>
<p>Questa distinzione ha cambiato il problema.</p>
<p>Copiare una cartella non è lo stesso che far lavorare più assistenti secondo le stesse regole. E unificare le regole non significa che ogni dispositivo debba ereditare le stesse credenziali, permessi o percorsi locali.</p>
<p>Il taglio utile sta tra intento e ambiente.</p>
<p>L’intento è portabile: come voglio le risposte scritte, quali controlli deve richiedere un flusso, cosa deve fare una guida riutilizzabile. L’ambiente è locale: dove vivono i file, quali integrazioni sono disponibili, cosa può aprire una macchina particolare.</p>
<p>Immaginiamo un insieme fittizio di assistenti che qui chiamo «Notebook», «Forge», «Studio», «Relay», «Atlas» e «Canvas». Ognuno può leggere lo stesso file di regole condivise. Nessuno deve ricevere automaticamente chiavi, percorsi o permessi da un’altra scrivania.</p>
<p>Non pretendo che questa sincronizzazione sia finita. È una decisione di progettazione in corso, non un’automazione completata.</p>
<p>La richiesta ha però rivelato un costo reale: mantenere le stesse preferenze separatamente per ogni assistente. Prima di aggiungere un altro strumento di IA, ora ho una domanda migliore di «Il suo modello è migliore?»</p>
<p>Quanto del mio contesto di lavoro può riutilizzare senza importare i presupposti della macchina sbagliata?</p>
<p><em>Riflessione editoriale sulla separazione tra intento portabile e ambiente locale. Le etichette degli assistenti e le circostanze sono sostituti fittizi o generalizzati. Non descrivono prodotti, aziende o dispositivi identificabili; il completamento della sincronizzazione non è verificato.</em></p>

HTML,
        ],
        'uk' => [
            'title' => 'Переносний намір, місцеві дозволи',
            'image_alt' => 'Два фіолетові столи в одній кімнаті. З лівого піднімається м’який бірюзовий потік спільних правил; правий тримає власний ключ, власний шлях і зачинену шафку.',
            'excerpt' => 'Я хотів синхронізувати все. Насправді мені потрібно було перестати знову представлятися своїм асистентам. Намір може мандрувати. Облікові дані, шляхи й дозволи мають лишатися вдома.',
            'content' => <<<'HTML'
<p>Я хотів синхронізувати все. Насправді мені потрібно було перестати знову представлятися своїм асистентам.</p>
<p>Я почав із широкого прохання: нехай узгодяться комп’ютери, планшети й телефони. Потім уточнив. Ішлося не про всю систему. Ішлося про налаштування інструментів ШІ: спільні інструкції, вподобання та повторно використовувані настанови. Налаштування, прив’язані до конкретної машини, мали лишатися окремо.</p>
<p>Це розрізнення змінило всю проблему.</p>
<p>Скопіювати теку: не те саме, що досягти, щоб кілька асистентів працювали за тими самими правилами. А узгодити правила не означає, що кожен пристрій має успадкувати ті самі облікові дані, дозволи чи місцеві шляхи.</p>
<p>Корисний розріз: між наміром і середовищем.</p>
<p>Намір переносний: як я хочу написані відповіді, які перевірки має вимагати процес, що має робити повторно використовувана настанова. Середовище місцеве: де лежать файли, які інтеграції доступні, що дозволено відкривати конкретній машині.</p>
<p>Уявімо вигаданий набір асистентів, який я тут позначаю як «Notebook», «Forge», «Studio», «Relay», «Atlas» і «Canvas». Кожен може читати той самий файл спільних правил. Жоден не повинен автоматично отримати ключі, шляхи чи дозволи з іншого столу.</p>
<p>Я не стверджую, що ця синхронізація завершена. Це проєктне рішення в процесі, не готова історія автоматизації.</p>
<p>Прохання, однак, виявило справжню ціну: підтримувати ті самі вподобання окремо в кожного асистента. Перед наступним інструментом ШІ в мене тепер краще питання, ніж «Чи краща його модель?»</p>
<p>Скільки мого робочого контексту він може використати знову, не переносячи припущень із неправильної машини?</p>
<p><em>Редакційна рефлексія про розрізнення переносного наміру та місцевого середовища. Позначення асистентів і обставини є вигаданими або узагальненими замінами. Вони не описують конкретні продукти, компанії чи ідентифіковані пристрої; завершення синхронізації не перевірено.</em></p>

HTML,
        ],
    ],
];
