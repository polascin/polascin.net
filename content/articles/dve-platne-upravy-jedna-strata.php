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
 * Esej o tichom prepísaní platnej úpravy pri súbehu a o kontrole verzie
 * na strane klienta. Produkt Heliora je fiktívna náhrada.
 */
return [
    'slug' => 'dve-platne-upravy-jedna-strata',
    'author' => 'MUDr. Ľubomír Polaščín',
    'category' => 'blog',
    'is_top' => 0,
    'published_at' => '2026-11-14 13:18:00',
    'image' => 'images/articles/dve-platne-upravy-jedna-strata.webp',
    'translations' => [
        'sk' => [
            'title' => 'Dve platné úpravy. Jedna ticho zmizla.',
            'image_alt' => 'Dva tyrkysové perá zapisujú do toho istého fialového zväzku. Jedna stopa svetla zostáva, druhá sa rozplýva do tmy.',
            'excerpt' => 'Keď dvaja administrátori upravia tú istú verziu profilu pracovníka, bežné „posledný zápis vyhráva“ môže obom odpovedať úspechom a pritom jednu prácu potichu zmazať. V Heliora som doplnil kontrolu verzie, ktorú klient pošle so zápisom.',
            'content' => <<<'HTML'
<p>Dvaja ľudia uložia platnú úpravu. Obaja uvidia, že sa to podarilo. V databáze ostane len neskorší zápis.</p>
<p>Takto sa správa bežné správanie „posledný zápis vyhráva“, keď dvaja administrátori pracujú z tej istej verzie profilu pracovníka. Server prijme oba zápisy. Prvý z nich však zmizne bez varovania.</p>
<p>V Heliora, fiktívne označenom systéme pre nefrológiu a dialýzu, som preto pri úpravách profilu pracovníka a registrácie doplnil kontrolu verzie, ktorú pošle klient. Server musí vedieť, ktorú verziu človek naozaj upravil.</p>
<p>Ak verzia v požiadavke chýba, server ju odmietne stavom HTTP 400. Ak je zastaraná, vráti konflikt HTTP 409 namiesto tichého prepísania novšieho záznamu. Rozdiel je podstatný. Načítať najnovšiu verziu na serveri tesne pred uložením ešte nehovorí, či formulár používateľa už nebol zastaraný.</p>
<p>Integračné testy overujú konflikt a to, že uložený záznam ostane nezmenený. Ide o jeden chránený postup, nie o tvrdenie, že každé riziko súbehu v systéme zmizlo.</p>
<p>Poučenie z produktu je prosté. Úspešná odpoveď má znamenať viac než to, že databáza prijala zápis. Má znamenať aj to, že sme potichu nezmazali platnú prácu niekoho iného.</p>
<p><em>Osobná úvaha z vývoja softvéru. Nie je to návod na klinickú prax. Názov „Heliora“ a interné označenia overení sú fiktívne náhrady. Neopisujú konkrétny produkt, firmu ani verejné odkazy na súkromný kód.</em></p>

HTML,
        ],
        'en' => [
            'title' => 'Two valid edits. One vanished without a sound.',
            'image_alt' => 'Two teal pens write into the same violet ledger. One trail of light remains; the other fades into darkness.',
            'excerpt' => 'When two administrators edit the same worker-profile version, ordinary last-write-wins can answer both with success and still erase one person’s work. In Heliora I added a client-supplied version check on save.',
            'content' => <<<'HTML'
<p>Two people save a valid edit. Both see success. The database keeps only the later write.</p>
<p>That is ordinary last-write-wins when two administrators work from the same worker-profile version. The server accepts both saves. The first person’s changes disappear without a warning.</p>
<p>In Heliora, a nephrology and dialysis system I label here under a fictional name, I therefore added a client-supplied version check to worker-profile and registration updates. The server needs to know which version the person actually edited.</p>
<p>If the required version is missing, the server rejects the request with HTTP 400. If the version is stale, it returns an HTTP 409 conflict instead of silently overwriting the newer record. The distinction matters. Reading the latest version on the server just before saving still does not tell you whether the user’s form was already out of date.</p>
<p>Integration tests cover the conflict and check that the stored record remains unchanged. This is one protected workflow, not a claim that every concurrency risk in the system has disappeared.</p>
<p>The product lesson is simple. A successful response should mean more than “the database accepted a write.” It should also mean we have not quietly erased someone else’s valid work.</p>
<p><em>A personal reflection from software development. It is not clinical guidance. The name “Heliora” and the internal verification labels are fictional substitutes. They do not describe a real product, company or public links to private code.</em></p>

HTML,
        ],
        'cs' => [
            'title' => 'Dvě platné úpravy. Jedna tiše zmizela.',
            'image_alt' => 'Dvě tyrkysová pera zapisují do téhož fialového svazku. Jedna stopa světla zůstává, druhá se rozplývá do tmy.',
            'excerpt' => 'Když dva administrátoři upraví tutéž verzi profilu pracovníka, běžné „poslední zápis vyhrává“ může oběma odpovědět úspěchem a přitom jednu práci potichu smazat. V Heliora jsem doplnil kontrolu verze, kterou klient pošle se zápisem.',
            'content' => <<<'HTML'
<p>Dva lidé uloží platnou úpravu. Oba uvidí, že se to povedlo. V databázi zůstane jen pozdější zápis.</p>
<p>Tak se chová běžné „poslední zápis vyhrává“, když dva administrátoři pracují z téže verze profilu pracovníka. Server přijme oba zápisy. První z nich však zmizí bez varování.</p>
<p>V Heliora, fiktivně označeném systému pro nefrologii a dialýzu, jsem proto u úprav profilu pracovníka a registrace doplnil kontrolu verze, kterou pošle klient. Server musí vědět, kterou verzi člověk opravdu upravil.</p>
<p>Pokud verze v požadavku chybí, server ji odmítne stavem HTTP 400. Pokud je zastaralá, vrátí konflikt HTTP 409 místo tichého přepsání novějšího záznamu. Rozdíl je podstatný. Načíst nejnovější verzi na serveru těsně před uložením ještě neříká, zda formulář uživatele už nebyl zastaralý.</p>
<p>Integrační testy ověřují konflikt a to, že uložený záznam zůstane nezměněný. Jde o jeden chráněný postup, ne o tvrzení, že každé riziko souběhu v systému zmizelo.</p>
<p>Poučení z produktu je prosté. Úspěšná odpověď má znamenat víc než to, že databáze přijala zápis. Má znamenat i to, že jsme potichu nesmazali platnou práci někoho jiného.</p>
<p><em>Osobní úvaha z vývoje softwaru. Není to návod na klinickou praxi. Název „Heliora“ a interní označení ověření jsou fiktivní náhrady. Neopisují konkrétní produkt, firmu ani veřejné odkazy na soukromý kód.</em></p>

HTML,
        ],
        'de' => [
            'title' => 'Zwei gültige Änderungen. Eine verschwand lautlos.',
            'image_alt' => 'Zwei türkise Stifte schreiben in dasselbe violette Heft. Eine Lichtspur bleibt, die andere löst sich in Dunkelheit auf.',
            'excerpt' => 'Wenn zwei Administratoren dieselbe Version eines Mitarbeiterprofils bearbeiten, kann gewöhnliches Last-Write-Wins beiden Erfolg melden und dennoch eine Arbeit still löschen. In Heliora ergänzte ich eine vom Client gelieferte Versionsprüfung beim Speichern.',
            'content' => <<<'HTML'
<p>Zwei Menschen speichern eine gültige Änderung. Beide sehen Erfolg. In der Datenbank bleibt nur der spätere Schreibvorgang.</p>
<p>So verhält sich gewöhnliches Last-Write-Wins, wenn zwei Administratoren von derselben Version eines Mitarbeiterprofils aus arbeiten. Der Server nimmt beide Speichervorgänge an. Die erste Änderung verschwindet ohne Warnung.</p>
<p>In Heliora, einem hier fiktiv benannten System für Nephrologie und Dialyse, ergänzte ich deshalb bei Aktualisierungen von Mitarbeiterprofil und Registrierung eine vom Client gelieferte Versionsprüfung. Der Server muss wissen, welche Version die Person tatsächlich bearbeitet hat.</p>
<p>Fehlt die erforderliche Version in der Anfrage, lehnt der Server sie mit HTTP 400 ab. Ist die Version veraltet, liefert er einen Konflikt HTTP 409 statt stillschweigend den neueren Datensatz zu überschreiben. Der Unterschied zählt. Die neueste Version auf dem Server unmittelbar vor dem Speichern zu lesen sagt noch nicht, ob das Formular der Person schon veraltet war.</p>
<p>Integrationstests decken den Konflikt ab und prüfen, dass der gespeicherte Datensatz unverändert bleibt. Das ist ein geschützter Ablauf, kein Anspruch, jedes Nebenläufigkeitsrisiko im System sei verschwunden.</p>
<p>Die Produktlehre ist schlicht. Eine erfolgreiche Antwort soll mehr bedeuten als „die Datenbank hat einen Schreibvorgang angenommen“. Sie soll auch bedeuten, dass wir nicht still die gültige Arbeit eines anderen gelöscht haben.</p>
<p><em>Persönliche Überlegung aus der Softwareentwicklung. Keine klinische Anleitung. Der Name „Heliora“ und die internen Prüfbezeichnungen sind fiktive Ersatzangaben. Sie beschreiben kein konkretes Produkt, kein Unternehmen und keine öffentlichen Verweise auf privaten Code.</em></p>

HTML,
        ],
        'fr' => [
            'title' => 'Deux modifications valides. Une a disparu sans bruit.',
            'image_alt' => 'Deux stylos turquoise écrivent dans le même cahier violet. Une traînée de lumière demeure ; l’autre s’efface dans l’obscurité.',
            'excerpt' => 'Quand deux administrateurs modifient la même version d’un profil de travailleur, le classique « dernier écrit gagne » peut répondre succès aux deux et effacer pourtant le travail de l’un. Dans Heliora j’ai ajouté une vérification de version fournie par le client à l’enregistrement.',
            'content' => <<<'HTML'
<p>Deux personnes enregistrent une modification valide. Toutes deux voient un succès. La base de données ne garde que l’écriture la plus tardive.</p>
<p>C’est le comportement ordinaire du « dernier écrit gagne » lorsque deux administrateurs travaillent à partir de la même version d’un profil de travailleur. Le serveur accepte les deux enregistrements. Les changements de la première personne disparaissent sans avertissement.</p>
<p>Dans Heliora, un système de néphrologie et de dialyse que je désigne ici sous un nom fictif, j’ai donc ajouté aux mises à jour du profil de travailleur et de l’inscription une vérification de version fournie par le client. Le serveur doit savoir quelle version la personne a réellement modifiée.</p>
<p>Si la version requise manque, le serveur refuse la requête avec HTTP 400. Si la version est périmée, il renvoie un conflit HTTP 409 au lieu d’écraser en silence l’enregistrement plus récent. La distinction compte. Lire la dernière version sur le serveur juste avant d’enregistrer ne dit toujours pas si le formulaire de l’utilisateur était déjà périmé.</p>
<p>Les tests d’intégration couvrent le conflit et vérifient que l’enregistrement stocké reste inchangé. C’est un flux protégé, pas l’affirmation que tout risque de concurrence a disparu du système.</p>
<p>La leçon produit est simple. Une réponse réussie doit signifier plus que « la base a accepté une écriture ». Elle doit aussi signifier que nous n’avons pas effacé en silence le travail valide de quelqu’un d’autre.</p>
<p><em>Réflexion personnelle issue du développement logiciel. Ce n’est pas un guide clinique. Le nom « Heliora » et les libellés de vérification internes sont des substituts fictifs. Ils ne décrivent ni un produit réel, ni une entreprise, ni des liens publics vers du code privé.</em></p>

HTML,
        ],
        'es' => [
            'title' => 'Dos ediciones válidas. Una desapareció en silencio.',
            'image_alt' => 'Dos plumas turquesa escriben en el mismo cuaderno violeta. Un rastro de luz permanece; el otro se deshace en la oscuridad.',
            'excerpt' => 'Cuando dos administradores editan la misma versión de un perfil de trabajador, el habitual «gana la última escritura» puede responder con éxito a ambos y aun así borrar el trabajo de uno. En Heliora añadí una comprobación de versión enviada por el cliente al guardar.',
            'content' => <<<'HTML'
<p>Dos personas guardan una edición válida. Ambas ven un éxito. La base de datos conserva solo la escritura posterior.</p>
<p>Así se comporta el habitual «gana la última escritura» cuando dos administradores trabajan desde la misma versión de un perfil de trabajador. El servidor acepta ambos guardados. Los cambios de la primera persona desaparecen sin aviso.</p>
<p>En Heliora, un sistema de nefrología y diálisis que aquí denomino con un nombre ficticio, añadí por tanto a las actualizaciones del perfil de trabajador y del registro una comprobación de versión enviada por el cliente. El servidor necesita saber qué versión editó de verdad la persona.</p>
<p>Si falta la versión requerida, el servidor rechaza la petición con HTTP 400. Si la versión está obsoleta, devuelve un conflicto HTTP 409 en lugar de sobrescribir en silencio el registro más reciente. La distinción importa. Leer la versión más reciente en el servidor justo antes de guardar aún no dice si el formulario del usuario ya estaba desfasado.</p>
<p>Las pruebas de integración cubren el conflicto y comprueban que el registro almacenado permanece sin cambios. Es un flujo protegido, no la afirmación de que todo riesgo de concurrencia haya desaparecido del sistema.</p>
<p>La lección de producto es simple. Una respuesta exitosa debe significar más que «la base aceptó una escritura». Debe significar también que no hemos borrado en silencio el trabajo válido de otra persona.</p>
<p><em>Reflexión personal del desarrollo de software. No es orientación clínica. El nombre «Heliora» y las etiquetas internas de verificación son sustitutos ficticios. No describen un producto real, una empresa ni enlaces públicos a código privado.</em></p>

HTML,
        ],
        'pl' => [
            'title' => 'Dwie ważne zmiany. Jedna zniknęła po cichu.',
            'image_alt' => 'Dwa turkusowe pióra zapisują w tym samym fioletowym notesie. Jeden ślad światła zostaje, drugi rozpływa się w ciemności.',
            'excerpt' => 'Gdy dwóch administratorów edytuje tę samą wersję profilu pracownika, zwykłe „ostatni zapis wygrywa” może obu odpowiedzieć sukcesem i mimo to po cichu skasować pracę jednego. W Heliora dodałem kontrolę wersji przesyłaną przez klienta przy zapisie.',
            'content' => <<<'HTML'
<p>Dwie osoby zapisują ważną zmianę. Obie widzą sukces. W bazie zostaje tylko późniejszy zapis.</p>
<p>Tak działa zwykłe „ostatni zapis wygrywa”, gdy dwóch administratorów pracuje z tej samej wersji profilu pracownika. Serwer przyjmuje oba zapisy. Zmiany pierwszej osoby znikają bez ostrzeżenia.</p>
<p>W Heliora, fikcyjnie oznaczonym systemie do nefrologii i dializy, dodałem więc do aktualizacji profilu pracownika i rejestracji kontrolę wersji przesyłaną przez klienta. Serwer musi wiedzieć, którą wersję osoba naprawdę edytowała.</p>
<p>Jeśli wymagana wersja w żądaniu brakuje, serwer odrzuca je kodem HTTP 400. Jeśli wersja jest przestarzała, zwraca konflikt HTTP 409 zamiast po cichu nadpisać nowszy rekord. Różnica ma znaczenie. Odczytanie najnowszej wersji na serwerze tuż przed zapisem nadal nie mówi, czy formularz użytkownika był już przestarzały.</p>
<p>Testy integracyjne obejmują konflikt i sprawdzają, że zapisany rekord pozostaje niezmieniony. To jeden chroniony przebieg, nie twierdzenie, że każde ryzyko współbieżności w systemie zniknęło.</p>
<p>Lekcja produktowa jest prosta. Udana odpowiedź ma znaczyć więcej niż „baza przyjęła zapis”. Ma znaczyć też to, że po cichu nie skasowaliśmy ważnej pracy kogoś innego.</p>
<p><em>Osobna refleksja z rozwoju oprogramowania. To nie jest wskazówka kliniczna. Nazwa „Heliora” i wewnętrzne oznaczenia weryfikacji są fikcyjnymi zamiennikami. Nie opisują konkretnego produktu, firmy ani publicznych odnośników do prywatnego kodu.</em></p>

HTML,
        ],
        'hu' => [
            'title' => 'Két érvényes módosítás. Az egyik hangtalanul eltűnt.',
            'image_alt' => 'Két türkiz toll ugyanabba a lilás füzetbe ír. Egy fénycsík megmarad, a másik elenyészik a sötétben.',
            'excerpt' => 'Ha két adminisztrátor ugyanabból a dolgozói profilverzióból dolgozik, a szokásos „az utolsó írás győz” mindkettőnek sikert jelezhet, és mégis csendben törölheti az egyik munkáját. A Heliorában ügyfél által küldött verzióellenőrzést tettem a mentéshez.',
            'content' => <<<'HTML'
<p>Két ember érvényes módosítást ment. Mindketten sikert látnak. Az adatbázisban csak a későbbi írás marad.</p>
<p>Így működik a szokásos „az utolsó írás győz”, amikor két adminisztrátor ugyanabból a dolgozói profilverzióból dolgozik. A szerver mindkét mentést elfogadja. Az első személy változásai figyelmeztetés nélkül eltűnnek.</p>
<p>A Heliorában, egy itt fiktív néven jelölt nefrológiai és dialízis rendszerben ezért a dolgozói profil és a regisztráció frissítéseihez ügyfél által küldött verzióellenőrzést tettem. A szervernek tudnia kell, melyik verziót szerkesztette ténylegesen a személy.</p>
<p>Ha a kötelező verzió hiányzik a kérésből, a szerver HTTP 400-zal elutasítja. Ha a verzió elavult, HTTP 409 konfliktust ad vissza ahelyett, hogy csendben felülírná az újabb rekordot. A különbség számít. A legfrissebb verzió beolvasása a szerveren mentés előtt még nem mondja meg, hogy a felhasználó űrlapja már elavult volt-e.</p>
<p>Az integrációs tesztek lefedik a konfliktust, és ellenőrzik, hogy a tárolt rekord változatlan marad. Ez egy védett folyamat, nem azt állítja, hogy minden párhuzamossági kockázat eltűnt a rendszerből.</p>
<p>A terméktanulság egyszerű. A sikeres válasznak többet kell jelentenie annál, hogy „az adatbázis elfogadott egy írást”. Azt is kell jelentenie, hogy csendben nem töröltük valaki más érvényes munkáját.</p>
<p><em>Személyes gondolat a szoftverfejlesztésből. Nem klinikai útmutató. A „Heliora” név és a belső ellenőrzési jelölések fiktív helyettesítők. Nem írnak le konkrét terméket, céget vagy nyilvános hivatkozásokat privát kódra.</em></p>

HTML,
        ],
        'it' => [
            'title' => 'Due modifiche valide. Una è sparita in silenzio.',
            'image_alt' => 'Due penne turchesi scrivono nello stesso taccuino violetto. Una scia di luce resta; l’altra si dissolve nel buio.',
            'excerpt' => 'Quando due amministratori modificano la stessa versione di un profilo lavoratore, il solito «vince l’ultima scrittura» può rispondere con successo a entrambi eppure cancellare in silenzio il lavoro di uno. In Heliora ho aggiunto un controllo di versione inviato dal client al salvataggio.',
            'content' => <<<'HTML'
<p>Due persone salvano una modifica valida. Entrambe vedono un successo. Nel database resta solo la scrittura successiva.</p>
<p>Così si comporta il solito «vince l’ultima scrittura» quando due amministratori lavorano dalla stessa versione di un profilo lavoratore. Il server accetta entrambi i salvataggi. Le modifiche della prima persona spariscono senza avviso.</p>
<p>In Heliora, un sistema di nefrologia e dialisi che qui indico con un nome fittizio, ho quindi aggiunto agli aggiornamenti del profilo lavoratore e della registrazione un controllo di versione inviato dal client. Il server deve sapere quale versione la persona ha davvero modificato.</p>
<p>Se la versione richiesta manca, il server rifiuta la richiesta con HTTP 400. Se la versione è obsoleta, restituisce un conflitto HTTP 409 invece di sovrascrivere in silenzio il record più recente. La distinzione conta. Leggere l’ultima versione sul server subito prima del salvataggio non dice ancora se il modulo dell’utente era già obsoleto.</p>
<p>I test di integrazione coprono il conflitto e verificano che il record memorizzato resti invariato. È un flusso protetto, non l’affermazione che ogni rischio di concorrenza sia scomparso dal sistema.</p>
<p>La lezione di prodotto è semplice. Una risposta di successo deve significare più di «il database ha accettato una scrittura». Deve significare anche che non abbiamo cancellato in silenzio il lavoro valido di qualcun altro.</p>
<p><em>Riflessione personale dallo sviluppo software. Non è una guida clinica. Il nome «Heliora» e le etichette interne di verifica sono sostituti fittizi. Non descrivono un prodotto reale, un’azienda o collegamenti pubblici a codice privato.</em></p>

HTML,
        ],
        'uk' => [
            'title' => 'Дві чинні зміни. Одна зникла без звуку.',
            'image_alt' => 'Дві бірюзові ручки пишуть в один і той самий фіолетовий зошит. Один слід світла лишається, другий розчиняється в темряві.',
            'excerpt' => 'Коли двоє адміністраторів редагують ту саму версію профілю працівника, звичайне «останній запис перемагає» може відповісти успіхом обом і все одно тихо стерти роботу одного. У Heliora я додав перевірку версії, яку клієнт надсилає під час збереження.',
            'content' => <<<'HTML'
<p>Двоє людей зберігають чинну зміну. Обидва бачать успіх. У базі лишається лише пізніший запис.</p>
<p>Так працює звичайне «останній запис перемагає», коли двоє адміністраторів працюють із тієї самої версії профілю працівника. Сервер приймає обидва збереження. Зміни першої людини зникають без попередження.</p>
<p>У Heliora, фіктивно названій системі для нефрології та діалізу, я тому додав до оновлень профілю працівника та реєстрації перевірку версії, яку надсилає клієнт. Серверу потрібно знати, яку версію людина справді редагувала.</p>
<p>Якщо потрібна версія відсутня, сервер відхиляє запит зі статусом HTTP 400. Якщо версія застаріла, він повертає конфлікт HTTP 409 замість тихого перезапису новішого запису. Різниця важлива. Прочитати найновішу версію на сервері безпосередньо перед збереженням ще не каже, чи форма користувача вже була застарілою.</p>
<p>Інтеграційні тести покривають конфлікт і перевіряють, що збережений запис лишається незмінним. Це один захищений процес, а не твердження, що кожен ризик паралельності в системі зник.</p>
<p>Урок продукту простий. Успішна відповідь має означати більше, ніж «база прийняла запис». Вона має також означати, що ми тихо не стерли чинну роботу когось іншого.</p>
<p><em>Особиста рефлексія з розробки програмного забезпечення. Це не клінічна настанова. Назва «Heliora» та внутрішні позначення перевірок є фіктивними замінниками. Вони не описують конкретний продукт, компанію чи публічні посилання на приватний код.</em></p>

HTML,
        ],
    ],
];
