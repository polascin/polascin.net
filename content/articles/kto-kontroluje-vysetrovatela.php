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
 * Esej o dohľadovom vyhľadávaní v auditnom denníku bez ukladania plného
 * identifikátora. Produkt Heliora a interné označenia verzií sú fiktívne náhrady.
 */
return [
    'slug' => 'kto-kontroluje-vysetrovatela',
    'author' => 'MUDr. Ľubomír Polaščín',
    'category' => 'blog',
    'is_top' => 0,
    'published_at' => '2026-11-14 11:20:00',
    'image' => 'images/articles/kto-kontroluje-vysetrovatela.webp',
    'translations' => [
        'sk' => [
            'title' => 'Kto kontroluje vyšetrujúceho?',
            'image_alt' => 'Tmavofialový stôl s priesvitným auditným panelom. Tyrkysový lúč lupy skúma zamaskované identifikátory, nad ním menšie tyrkysové oko dohľadu.',
            'excerpt' => 'Auditný denník má pomáhať pri vyšetrovaní prístupu, nie sa stať ďalším adresárom citlivých identifikátorov. V Heliora som doplnil dohľadové vyhľadávanie s kryptografickým štítkom, vlastným auditom a tvrdo obmedzenou rolou.',
            'content' => <<<'HTML'
<p>Auditný denník má pomáhať pri vyšetrovaní prístupu. Nemá sa stať ďalším adresárom citlivých identifikátorov.</p>
<p>Tento týždeň som do Heliora, fiktívne označeného systému pre nefrológiu a dialýzu, doplnil dohľadové vyhľadávanie. Otázka bola konkrétna: ako má oprávnený lekár preveriť aktivitu kontroly poistenia u určitej osoby, keď v auditnom denníku nesmie ležať jej plné národné identifikačné číslo?</p>
<p>Riešenie pridáva k záznamu identifikátor odvodený kľúčovaným HMAC-SHA256 a vedľa neho zamaskovanú podobu čísla. Pri dohľadovom hľadaní lekár odošle číslo v tele požiadavky POST. Server z neho pomocou kľúča uloženého na serveri vypočíta rovnaký token a podľa neho nájde zhodu.</p>
<p>Samotné vyhľadávanie však otvára nové riziko: niekto by ním mohol skúšať auditný denník. Preto nie je funkcia automaticky dostupná administrátorom. Má ju len rola vedúceho lekára. Každé hľadanie sa zapisuje do auditu a predvolený limit je desať hľadaní za hodinu na používateľa.</p>
<p>Zmeny som overil v ukážkovom prostredí. To nie je tvrdenie o nasadení do produkcie.</p>
<p>Ide o pseudonymizáciu, nie o anonymizáciu. Údaje stále treba chrániť. Kryptografický štítok túto povinnosť nezruší.</p>
<p>Poučenie z produktu: nestačí chrániť pôvodný záznam. Treba sa spýtať, akú novú moc vytvára vyšetrovací nástroj, kto ju dostane a ako sa jeho použitie kontroluje.</p>
<p><em>Osobná úvaha z vývoja softvéru. Nie je to návod na klinickú prax. Názov „Heliora“ a interné označenia overení sú fiktívne náhrady. Neopisujú konkrétny produkt, firmu ani verejné odkazy na súkromný kód.</em></p>

HTML,
        ],
        'en' => [
            'title' => 'Who audits the investigator?',
            'image_alt' => 'A dark violet desk with a translucent audit panel. A teal magnifying beam inspects masked identifiers; a smaller teal supervisory eye watches from above.',
            'excerpt' => 'An audit log should help investigate access, not become another directory of sensitive identifiers. In Heliora I added a supervisory search with a cryptographic label, its own audit trail and a tightly limited role.',
            'content' => <<<'HTML'
<p>An audit log should help investigate access. It should not become another directory of sensitive identifiers.</p>
<p>This week I added a supervisory lookup to Heliora, a nephrology and dialysis system I label here under a fictional name. The question was concrete: how can an authorised physician review insurance-check activity for a particular person without storing their full national identifier in the audit trail?</p>
<p>The implementation adds a keyed HMAC-SHA256 identifier beside a masked form of the number. For a supervisory search the physician submits the number in a POST request body. The server derives the matching token with a server-held key and finds the match.</p>
<p>But the lookup creates its own risk: someone could use it to probe the audit trail. So the search is not granted to administrators by default. It belongs only to the lead-physician role. Every search is itself audited, with a configurable default of ten searches per hour per user.</p>
<p>I verified the changes in a demo environment. That is not a claim of production rollout.</p>
<p>This is pseudonymisation, not anonymisation. The data still needs protection. A cryptographic label does not erase that duty.</p>
<p>The product lesson: do not stop at protecting the original record. Ask what new power the investigation tool creates, who receives it, and how its use will be checked.</p>
<p><em>A personal reflection from software development. It is not clinical guidance. The name “Heliora” and the internal verification labels are fictional substitutes. They do not describe a real product, company or public links to private code.</em></p>

HTML,
        ],
        'cs' => [
            'title' => 'Kdo kontroluje vyšetřujícího?',
            'image_alt' => 'Tmavě fialový stůl s průsvitným auditním panelem. Tyrkysový paprsek lupy zkoumá zamaskované identifikátory, nad ním menší tyrkysové oko dohledu.',
            'excerpt' => 'Auditní deník má pomáhat při vyšetřování přístupu, ne se stát dalším adresářem citlivých identifikátorů. V Heliora jsem doplnil dohledové vyhledávání s kryptografickým štítkem, vlastním auditem a tvrdě omezenou rolí.',
            'content' => <<<'HTML'
<p>Auditní deník má pomáhat při vyšetřování přístupu. Nemá se stát dalším adresářem citlivých identifikátorů.</p>
<p>Tento týden jsem do Heliora, fiktivně označeného systému pro nefrologii a dialýzu, doplnil dohledové vyhledávání. Otázka byla konkrétní: jak má oprávněný lékař ověřit aktivitu kontroly pojištění u určité osoby, když v auditním deníku nesmí ležet její plné národní identifikační číslo?</p>
<p>Řešení přidává k záznamu identifikátor odvozený klíčovaným HMAC-SHA256 a vedle něj zamaskovanou podobu čísla. Při dohledovém hledání lékař odešle číslo v těle požadavku POST. Server z něj pomocí klíče uloženého na serveru vypočítá stejný token a podle něj najde shodu.</p>
<p>Samotné vyhledávání však otevírá nové riziko: někdo by jím mohl zkoušet auditní deník. Proto není funkce automaticky dostupná administrátorům. Má ji jen role vedoucího lékaře. Každé hledání se zapisuje do auditu a výchozí limit je deset hledání za hodinu na uživatele.</p>
<p>Změny jsem ověřil v ukázkovém prostředí. To není tvrzení o nasazení do produkce.</p>
<p>Jde o pseudonymizaci, ne o anonymizaci. Údaje stále je třeba chránit. Kryptografický štítek tuto povinnost neruší.</p>
<p>Poučení z produktu: nestačí chránit původní záznam. Je třeba se zeptat, jakou novou moc vytváří vyšetřovací nástroj, kdo ji dostane a jak se jeho použití kontroluje.</p>
<p><em>Osobní úvaha z vývoje softwaru. Není to návod na klinickou praxi. Název „Heliora“ a interní označení ověření jsou fiktivní náhrady. Neopisují konkrétní produkt, firmu ani veřejné odkazy na soukromý kód.</em></p>

HTML,
        ],
        'de' => [
            'title' => 'Wer prüft den Untersuchenden?',
            'image_alt' => 'Dunkler violetter Schreibtisch mit durchscheinendem Audit-Panel. Ein türkiser Lupenstrahl prüft maskierte Kennungen; darüber wacht ein kleineres türkises Aufsichtsauge.',
            'excerpt' => 'Ein Audit-Protokoll soll den Zugriff untersuchen helfen, nicht ein weiteres Verzeichnis sensibler Kennungen werden. In Heliora ergänzte ich eine Aufsichtssuche mit kryptografischem Etikett, eigenem Audit und streng begrenzter Rolle.',
            'content' => <<<'HTML'
<p>Ein Audit-Protokoll soll den Zugriff untersuchen helfen. Es soll kein weiteres Verzeichnis sensibler Kennungen werden.</p>
<p>Diese Woche habe ich in Heliora, einem hier fiktiv benannten System für Nephrologie und Dialyse, eine Aufsichtssuche ergänzt. Die Frage war konkret: wie kann ein befugter Arzt Versicherungsprüfungen für eine bestimmte Person nachvollziehen, ohne die volle nationale Kennung im Audit-Protokoll zu speichern?</p>
<p>Die Umsetzung fügt einen mit HMAC-SHA256 und Schlüssel abgeleiteten Bezeichner neben einer maskierten Form der Nummer hinzu. Bei der Aufsichtssuche sendet der Arzt die Nummer im Körper einer POST-Anfrage. Der Server leitet mit einem serverseitigen Schlüssel denselben Token ab und findet die Übereinstimmung.</p>
<p>Die Suche selbst schafft jedoch ein neues Risiko: jemand könnte damit das Audit-Protokoll abtasten. Deshalb steht die Funktion Administratoren nicht automatisch zu. Sie gehört nur der Rolle des leitenden Arztes. Jede Suche wird selbst auditiert, mit einer konfigurierbaren Vorgabe von zehn Suchen pro Stunde und Nutzer.</p>
<p>Die Änderungen habe ich in einer Demo-Umgebung geprüft. Das ist keine Aussage über eine Produktionsfreigabe.</p>
<p>Es handelt sich um Pseudonymisierung, nicht um Anonymisierung. Die Daten brauchen weiterhin Schutz. Ein kryptografisches Etikett hebt diese Pflicht nicht auf.</p>
<p>Die Produktlehre: höre nicht beim Schutz des ursprünglichen Datensatzes auf. Frage, welche neue Macht das Untersuchungswerkzeug schafft, wer sie erhält und wie ihre Nutzung geprüft wird.</p>
<p><em>Persönliche Überlegung aus der Softwareentwicklung. Keine klinische Anleitung. Der Name „Heliora“ und die internen Prüfbezeichnungen sind fiktive Ersatzangaben. Sie beschreiben kein konkretes Produkt, kein Unternehmen und keine öffentlichen Verweise auf privaten Code.</em></p>

HTML,
        ],
        'fr' => [
            'title' => 'Qui contrôle l’enquêteur ?',
            'image_alt' => 'Bureau violet sombre avec un panneau d’audit translucide. Un faisceau turquoise de loupe examine des identifiants masqués ; un œil de supervision turquoise plus petit veille au-dessus.',
            'excerpt' => 'Un journal d’audit doit aider à enquêter sur les accès, pas devenir un autre répertoire d’identifiants sensibles. Dans Heliora j’ai ajouté une recherche de supervision avec étiquette cryptographique, son propre audit et un rôle strictement limité.',
            'content' => <<<'HTML'
<p>Un journal d’audit doit aider à enquêter sur les accès. Il ne doit pas devenir un autre répertoire d’identifiants sensibles.</p>
<p>Cette semaine, j’ai ajouté une recherche de supervision dans Heliora, un système de néphrologie et de dialyse que je désigne ici sous un nom fictif. La question était concrète : comment un médecin autorisé peut-il examiner l’activité de contrôle d’assurance d’une personne sans stocker son identifiant national complet dans le journal d’audit ?</p>
<p>La mise en œuvre ajoute un identifiant dérivé par HMAC-SHA256 à clé, à côté d’une forme masquée du numéro. Pour une recherche de supervision, le médecin envoie le numéro dans le corps d’une requête POST. Le serveur dérive le jeton correspondant avec une clé détenue côté serveur et trouve la correspondance.</p>
<p>Mais la recherche crée son propre risque : quelqu’un pourrait s’en servir pour sonder le journal d’audit. La fonction n’est donc pas accordée automatiquement aux administrateurs. Elle appartient uniquement au rôle de médecin responsable. Chaque recherche est elle-même auditée, avec une limite par défaut configurable de dix recherches par heure et par utilisateur.</p>
<p>J’ai vérifié les changements dans un environnement de démonstration. Ce n’est pas une affirmation de mise en production.</p>
<p>Il s’agit de pseudonymisation, non d’anonymisation. Les données doivent encore être protégées. Une étiquette cryptographique n’efface pas cette obligation.</p>
<p>La leçon produit : ne vous arrêtez pas à la protection de l’enregistrement d’origine. Demandez quel nouveau pouvoir crée l’outil d’enquête, qui le reçoit, et comment son usage sera contrôlé.</p>
<p><em>Réflexion personnelle issue du développement logiciel. Ce n’est pas un guide clinique. Le nom « Heliora » et les libellés de vérification internes sont des substituts fictifs. Ils ne décrivent ni un produit réel, ni une entreprise, ni des liens publics vers du code privé.</em></p>

HTML,
        ],
        'es' => [
            'title' => '¿Quién controla al investigador?',
            'image_alt' => 'Escritorio violeta oscuro con un panel de auditoría translúcido. Un haz turquesa de lupa examina identificadores enmascarados; un ojo de supervisión turquesa más pequeño vigila desde arriba.',
            'excerpt' => 'Un registro de auditoría debe ayudar a investigar el acceso, no convertirse en otro directorio de identificadores sensibles. En Heliora añadí una búsqueda de supervisión con etiqueta criptográfica, su propia auditoría y un rol estrictamente limitado.',
            'content' => <<<'HTML'
<p>Un registro de auditoría debe ayudar a investigar el acceso. No debe convertirse en otro directorio de identificadores sensibles.</p>
<p>Esta semana añadí una consulta de supervisión a Heliora, un sistema de nefrología y diálisis que aquí denomino con un nombre ficticio. La pregunta era concreta: ¿cómo puede un médico autorizado revisar la actividad de control de seguros de una persona concreta sin almacenar su identificador nacional completo en el registro de auditoría?</p>
<p>La implementación añade un identificador derivado con HMAC-SHA256 con clave junto a una forma enmascarada del número. En una búsqueda de supervisión, el médico envía el número en el cuerpo de una solicitud POST. El servidor deriva el token coincidente con una clave retenida en el servidor y encuentra la coincidencia.</p>
<p>Pero la consulta crea su propio riesgo: alguien podría usarla para sondear el registro de auditoría. Por eso la función no se concede automáticamente a los administradores. Pertenece solo al rol de médico responsable. Cada búsqueda se audita a su vez, con un límite configurable por defecto de diez búsquedas por hora y usuario.</p>
<p>Verifiqué los cambios en un entorno de demostración. No es una afirmación de despliegue en producción.</p>
<p>Se trata de seudonimización, no de anonimización. Los datos siguen necesitando protección. Una etiqueta criptográfica no borra esa obligación.</p>
<p>La lección de producto: no te detengas en proteger el registro original. Pregunta qué nuevo poder crea la herramienta de investigación, quién lo recibe y cómo se controlará su uso.</p>
<p><em>Reflexión personal del desarrollo de software. No es orientación clínica. El nombre «Heliora» y las etiquetas internas de verificación son sustitutos ficticios. No describen un producto real, una empresa ni enlaces públicos a código privado.</em></p>

HTML,
        ],
        'pl' => [
            'title' => 'Kto kontroluje badającego?',
            'image_alt' => 'Ciemnofioletowy stół z półprzezroczystym panelem audytu. Turkusowy snop lupy bada zamaskowane identyfikatory; nad nim mniejsze turkusowe oko nadzoru.',
            'excerpt' => 'Dziennik audytu ma pomagać w badaniu dostępu, a nie stawać się kolejnym katalogiem wrażliwych identyfikatorów. W Heliora dodałem wyszukiwanie nadzorcze z kryptograficzną etykietą, własnym audytem i ściśle ograniczoną rolą.',
            'content' => <<<'HTML'
<p>Dziennik audytu ma pomagać w badaniu dostępu. Nie ma stawać się kolejnym katalogiem wrażliwych identyfikatorów.</p>
<p>W tym tygodniu dodałem w Heliora, fikcyjnie oznaczonym systemie do nefrologii i dializy, wyszukiwanie nadzorcze. Pytanie było konkretne: jak uprawniony lekarz ma sprawdzić aktywność kontroli ubezpieczenia dla danej osoby, skoro w dzienniku audytu nie może leżeć jej pełny krajowy identyfikator?</p>
<p>Rozwiązanie dodaje do zapisu identyfikator wyprowadzony kluczowanym HMAC-SHA256 oraz obok niego zamaskowaną postać numeru. Przy wyszukiwaniu nadzorczym lekarz wysyła numer w treści żądania POST. Serwer wyprowadza z niego ten sam token kluczem przechowywanym na serwerze i według niego znajduje zgodność.</p>
<p>Samo wyszukiwanie otwiera jednak nowe ryzyko: ktoś mógłby nim sondować dziennik audytu. Dlatego funkcja nie jest automatycznie dostępna administratorom. Ma ją tylko rola lekarza prowadzącego. Każde wyszukiwanie jest samo audytowane, z domyślnym limitem dziesięciu wyszukiwań na godzinę na użytkownika.</p>
<p>Zmiany sprawdziłem w środowisku demonstracyjnym. To nie jest twierdzenie o wdrożeniu produkcyjnym.</p>
<p>To pseudonimizacja, nie anonimizacja. Dane nadal trzeba chronić. Kryptograficzna etykieta tej powinności nie znosi.</p>
<p>Wniosek produktowy: nie wystarczy chronić pierwotnego zapisu. Trzeba zapytać, jaką nową władzę tworzy narzędzie badawcze, kto ją otrzymuje i jak kontroluje się jego użycie.</p>
<p><em>Osobna refleksja z rozwoju oprogramowania. To nie jest wskazówka kliniczna. Nazwa „Heliora” i wewnętrzne oznaczenia weryfikacji są fikcyjnymi zamiennikami. Nie opisują konkretnego produktu, firmy ani publicznych odnośników do prywatnego kodu.</em></p>

HTML,
        ],
        'hu' => [
            'title' => 'Ki ellenőrzi a vizsgálót?',
            'image_alt' => 'Sötétlila asztal áttetsző auditpanellel. Türkiz nagyítófény maszkolt azonosítókat vizsgál; fölötte kisebb türkiz felügyelő szem.',
            'excerpt' => 'Az auditnaplónak a hozzáférés vizsgálatában kell segítenie, nem újabb érzékeny azonosító-jegyzékké válnia. A Heliorában felügyeleti keresést adtam hozzá kriptográfiai címkével, saját audittal és szigorúan korlátozott szereppel.',
            'content' => <<<'HTML'
<p>Az auditnaplónak a hozzáférés vizsgálatában kell segítenie. Nem válhat újabb érzékeny azonosító-jegyzékké.</p>
<p>Ezen a héten a Heliorába, egy itt fiktíven megnevezett nefrológiai és dialízisrendszerbe felügyeleti keresést tettem. A kérdés konkrét volt: hogyan ellenőrizheti egy jogosult orvos egy adott személy biztosításellenőrzési tevékenységét anélkül, hogy a teljes nemzeti azonosító az auditnaplóban feküdne?</p>
<p>A megoldás kulcsolt HMAC-SHA256-ból származtatott azonosítót ad a rekordhoz, mellette a szám maszkolt alakját. Felügyeleti keresésnél az orvos a számot a POST kérés törzsében küldi. A szerver a szerveren tartott kulccsal ugyanazt a tokent számítja ki, és aszerint találja a találatot.</p>
<p>Maga a keresés azonban új kockázatot nyit: valaki vele próbálhatná az auditnaplót. Ezért a funkció nem jár automatikusan az adminisztrátoroknak. Csak a vezető orvos szerepéhez tartozik. Minden keresés maga is auditálódik, felhasználónként óránként tíz keresés konfigurálható alapértelmezett korláttal.</p>
<p>A változásokat demókörnyezetben ellenőriztem. Ez nem termelési bevezetés állítása.</p>
<p>Ez álnevesítés, nem anonimizálás. Az adatokat továbbra is védeni kell. A kriptográfiai címke ezt a kötelességet nem törli.</p>
<p>A termék tanulsága: ne állj meg az eredeti rekord védelménél. Kérdezd meg, milyen új hatalmat teremt a vizsgáló eszköz, ki kapja meg, és hogyan ellenőrzik a használatát.</p>
<p><em>Személyes gondolat a szoftverfejlesztésből. Nem klinikai útmutató. A „Heliora” név és a belső ellenőrzési jelölések fiktív helyettesítők. Nem írnak le konkrét terméket, céget vagy nyilvános hivatkozásokat privát kódra.</em></p>

HTML,
        ],
        'it' => [
            'title' => 'Chi controlla chi indaga?',
            'image_alt' => 'Scrivania viola scura con un pannello di audit traslucido. Un fascio turchese di lente esamina identificatori mascherati; sopra, un occhio di supervisione turchese più piccolo vigila.',
            'excerpt' => 'Un registro di audit deve aiutare a indagare gli accessi, non diventare un altro elenco di identificatori sensibili. In Heliora ho aggiunto una ricerca di supervisione con etichetta crittografica, un proprio audit e un ruolo rigidamente limitato.',
            'content' => <<<'HTML'
<p>Un registro di audit deve aiutare a indagare gli accessi. Non deve diventare un altro elenco di identificatori sensibili.</p>
<p>Questa settimana ho aggiunto a Heliora, un sistema di nefrologia e dialisi che qui indico con un nome fittizio, una ricerca di supervisione. La domanda era concreta: come può un medico autorizzato verificare l’attività di controllo assicurativo di una persona specifica senza conservare il suo identificatore nazionale completo nel registro di audit?</p>
<p>L’implementazione aggiunge un identificatore derivato con HMAC-SHA256 a chiave accanto a una forma mascherata del numero. Nella ricerca di supervisione il medico invia il numero nel corpo di una richiesta POST. Il server deriva il token corrispondente con una chiave tenuta sul server e trova la corrispondenza.</p>
<p>Ma la ricerca crea un rischio proprio: qualcuno potrebbe usarla per sondare il registro di audit. Perciò la funzione non è concessa automaticamente agli amministratori. Appartiene solo al ruolo di medico responsabile. Ogni ricerca è a sua volta auditata, con un limite predefinito configurabile di dieci ricerche all’ora per utente.</p>
<p>Ho verificato le modifiche in un ambiente dimostrativo. Non è un’affermazione di messa in produzione.</p>
<p>Si tratta di pseudonimizzazione, non di anonimizzazione. I dati vanno ancora protetti. Un’etichetta crittografica non cancella questo dovere.</p>
<p>La lezione di prodotto: non fermarti a proteggere il record originale. Chiedi quale nuovo potere crea lo strumento di indagine, chi lo riceve e come se ne controllerà l’uso.</p>
<p><em>Riflessione personale dallo sviluppo software. Non è una guida clinica. Il nome «Heliora» e le etichette interne di verifica sono sostituti fittizi. Non descrivono un prodotto reale, un’azienda o collegamenti pubblici a codice privato.</em></p>

HTML,
        ],
        'uk' => [
            'title' => 'Хто контролює того, хто розслідує?',
            'image_alt' => 'Темно-фіолетовий стіл із напівпрозорою панеллю аудиту. Бірюзовий промінь лупи вивчає замасковані ідентифікатори; згори пильнує менше бірюзове око нагляду.',
            'excerpt' => 'Аудитний журнал має допомагати розслідувати доступ, а не ставати ще одним довідником чутливих ідентифікаторів. У Heliora я додав наглядовий пошук із криптографічною міткою, власним аудитом і жорстко обмеженою роллю.',
            'content' => <<<'HTML'
<p>Аудитний журнал має допомагати розслідувати доступ. Він не повинен ставати ще одним довідником чутливих ідентифікаторів.</p>
<p>Цього тижня я додав до Heliora, фіктивно названої системи для нефрології та діалізу, наглядовий пошук. Питання було конкретне: як уповноважений лікар може перевірити активність страхової перевірки щодо конкретної особи, якщо в аудитному журналі не може лежати її повний національний ідентифікатор?</p>
<p>Рішення додає до запису ідентифікатор, виведений ключованим HMAC-SHA256, і поруч замасковану форму номера. Для наглядового пошуку лікар надсилає номер у тілі запиту POST. Сервер виводить відповідний токен ключем, що зберігається на сервері, і за ним знаходить збіг.</p>
<p>Але сам пошук створює власний ризик: хтось міг би ним зондувати аудитний журнал. Тому функція не надається адміністраторам автоматично. Вона належить лише ролі провідного лікаря. Кожен пошук сам потрапляє в аудит, із типовою межею десять пошуків на годину на користувача.</p>
<p>Зміни я перевірив у демонстраційному середовищі. Це не твердження про впровадження у виробництво.</p>
<p>Це псевдонімізація, а не анонімізація. Дані все одно треба захищати. Криптографічна мітка цього обов’язку не скасовує.</p>
<p>Урок продукту: не зупиняйся на захисті початкового запису. Запитай, яку нову владу створює інструмент розслідування, хто її отримує і як контролюватимуть її використання.</p>
<p><em>Особиста рефлексія з розробки програмного забезпечення. Це не клінічна настанова. Назва «Heliora» та внутрішні позначення перевірок є фіктивними замінниками. Вони не описують конкретний продукт, компанію чи публічні посилання на приватний код.</em></p>

HTML,
        ],
    ],
];
