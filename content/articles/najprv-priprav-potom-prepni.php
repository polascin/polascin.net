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
    'slug' => 'najprv-priprav-potom-prepni',
    'author' => 'MUDr. Ľubomír Polaščín',
    'category' => 'blog',
    'is_top' => 0,
    'published_at' => '2026-11-21 08:00:00',
    'image' => 'images/articles/najprv-priprav-potom-prepni.webp',
    'translations' => [
        'sk' => [
            'title' => 'Najprv priprav náhradu. Až potom zhasni svetlo.',
            'image_alt' => 'Dva osvetlené modely domov na susedných plošinách spojených mostom.',
            'excerpt' => 'Opakovaný pokus nevylieči nebezpečné poradie krokov. Bezpečnejšie nasadenie začína tým, že fungujúci web zostane na mieste, kým náhrada nie je pripravená.',
            'content' => <<<'HTML'
<p>V modelovej dielni Tichý prístav sa nový web nasadzuje tromi krokmi: vymaž starý, nahraj nový, skontroluj výsledok. Pri druhom kroku vypadne spojenie. Návštevník dostane zamknuté dvere. Dielňa je vymyslená, chyba v poradí je celkom konkrétna.</p>
<p>Pridať tri opakovania vyzerá rozumne. Lenže ak každý pokus začína vyprataním toho, čo ešte funguje, zrýchlili sme najmä cestu k prázdnemu adresáru.</p>
<p>Lepšie poradie znie: pripraviť, overiť, prepnúť. Nová verzia príde do samostatného adresára. Skontroluje sa úplnosť zostavy a to, či sa dá spustiť. Doterajšia verzia ostane dostupná na návrat. Až potom sa návštevnosť presmeruje na náhradu.</p>
<p>Ani toto nie je kúzlo. Presúvanie súborov po jednom nie je atómové prepnutie: medzi krokmi môže byť web v zmiešanom stave. Prítomnosť úvodnej stránky a konfiguračného súboru neoverí všetky odkazy. Záloha nepomôže, ak sme nikdy nevyskúšali obnovu.</p>
<p>Pred schválením automatizácie by som preto do návrhu zakreslil prerušenie po každom kroku. Čo zostane návštevníkovi? Kto vie vykonať návrat? Ako spoznáme, že je služba opäť v poriadku?</p>
<p>Najlepší okamih na záchranu fungujúcej verzie je ešte predtým, než ju odstránime.</p>
<p><em>Fiktívny vzdelávací príklad, nie správa o výpadku konkrétnej služby. Opísané poradie je návrhový princíp, nie záruka bezporuchovosti.</em></p>

HTML,
        ],
        'en' => [
            'title' => 'Prepare the replacement before switching off the lights',
            'image_alt' => 'Two illuminated miniature houses on adjacent platforms joined by a bridge.',
            'excerpt' => 'Retries cannot cure a dangerous sequence. Safer deployment keeps the working website in place until its replacement is ready.',
            'content' => <<<'HTML'
<p>At the fictional Quiet Harbour workshop, deployment has three steps: delete the old site, upload the new one, check the result. The connection fails during step two. Visitors find a locked door. The workshop is invented; the sequencing problem is concrete.</p>
<p>Adding three retries looks sensible. But if every attempt clears away what still works, we have mainly accelerated the journey to an empty directory.</p>
<p>A better sequence is prepare, verify, switch. Upload the release to a separate directory. Check that the build is complete and can run. Keep the previous version available for rollback. Only then direct traffic to the replacement.</p>
<p>This is no magic trick. Moving files individually is not an atomic switch: the site can contain mixed versions between steps. Finding a homepage and configuration file does not validate every link. A backup is little help if restoration has never been tried.</p>
<p>Before approving automation, I would mark a connection failure after every step. What remains for visitors? Who can roll back? How will we know service is healthy again?</p>
<p>The best moment to save a working version is before removing it.</p>
<p><em>A fictional educational example, not an incident report about a particular service. This sequence is a design principle, not a guarantee against failure.</em></p>

HTML,
        ],
        'cs' => [
            'title' => 'Nejprve připrav náhradu. Teprve potom zhasni.',
            'image_alt' => 'Dva osvětlené modely domů na sousedních plošinách spojených mostem.',
            'excerpt' => 'Opakování pokusu nenapraví nebezpečné pořadí. Bezpečnější nasazení ponechá fungující web na místě, dokud není náhrada připravena.',
            'content' => <<<'HTML'
<p>V modelové dílně Tichý přístav má nasazení tři kroky: smaž starý web, nahraj nový, zkontroluj výsledek. Při druhém kroku vypadne spojení. Návštěvník najde zamčené dveře. Dílna je vymyšlená, chyba v pořadí je konkrétní.</p>
<p>Přidat tři opakování vypadá rozumně. Jestliže však každý pokus odstraní to, co ještě funguje, urychlili jsme hlavně cestu k prázdnému adresáři.</p>
<p>Lepší pořadí je připravit, ověřit, přepnout. Nová verze přijde do samostatného adresáře. Ověří se úplnost sestavení a jeho spustitelnost. Dosavadní verze zůstane připravena pro návrat. Teprve pak se provoz přesměruje.</p>
<p>Ani to není kouzlo. Přesouvání souborů jednotlivě není atomické přepnutí: mezi kroky může vzniknout smíšený stav. Přítomnost úvodní stránky a konfigurace neověří všechny odkazy. Záloha nepomůže, pokud jsme nikdy nevyzkoušeli obnovu.</p>
<p>Před schválením automatizace bych do návrhu zakreslil výpadek po každém kroku. Co zůstane návštěvníkovi? Kdo umí vrátit předchozí verzi? Jak poznáme obnovenou službu?</p>
<p>Nejlepší chvíle pro záchranu fungující verze je před jejím odstraněním.</p>
<p><em>Fiktivní vzdělávací příklad, nikoli zpráva o výpadku konkrétní služby. Jde o návrhový princip, ne záruku bezporuchovosti.</em></p>

HTML,
        ],
        'de' => [
            'title' => 'Erst den Ersatz vorbereiten, dann das Licht ausschalten',
            'image_alt' => 'Zwei beleuchtete Miniaturhäuser auf benachbarten, durch eine Brücke verbundenen Plattformen.',
            'excerpt' => 'Wiederholungen heilen keine gefährliche Reihenfolge. Ein sichereres Deployment lässt die funktionierende Website bestehen, bis ihr Ersatz bereitsteht.',
            'content' => <<<'HTML'
<p>In der erfundenen Werkstatt Stiller Hafen läuft das Deployment in drei Schritten: alte Website löschen, neue hochladen, Ergebnis prüfen. Beim zweiten Schritt bricht die Verbindung ab. Besucher stehen vor verschlossener Tür. Die Werkstatt ist fiktiv, der Reihenfolgefehler konkret.</p>
<p>Drei weitere Versuche wirken vernünftig. Beginnt aber jeder Versuch damit, das noch Funktionierende zu entfernen, beschleunigen wir vor allem den Weg zum leeren Verzeichnis.</p>
<p>Besser ist: vorbereiten, prüfen, umschalten. Die neue Version kommt in ein separates Verzeichnis. Vollständigkeit und Startfähigkeit werden geprüft. Die bisherige Version bleibt für eine Rückkehr verfügbar. Erst dann wird der Verkehr umgeleitet.</p>
<p>Auch das ist keine Zauberei. Einzelnes Verschieben von Dateien ist kein atomarer Wechsel: Zwischenzustände können Versionen mischen. Eine Startseite und eine Konfigurationsdatei bestätigen nicht sämtliche Links. Eine Sicherung hilft wenig, wenn die Wiederherstellung nie erprobt wurde.</p>
<p>Vor der Freigabe würde ich nach jedem Schritt einen Verbindungsabbruch einzeichnen. Was bleibt Besuchern? Wer kann zurückschalten? Woran erkennen wir den wiederhergestellten Betrieb?</p>
<p>Der beste Zeitpunkt, eine funktionierende Version zu retten, liegt vor ihrer Entfernung.</p>
<p><em>Fiktives Lehrbeispiel, kein Ausfallbericht eines konkreten Dienstes. Die Reihenfolge ist ein Gestaltungsprinzip, keine Garantie für störungsfreien Betrieb.</em></p>

HTML,
        ],
        'fr' => [
            'title' => 'Préparer le remplacement avant d\'éteindre la lumière',
            'image_alt' => 'Deux maisons miniatures éclairées sur des plateformes voisines reliées par un pont.',
            'excerpt' => 'Répéter une tentative ne corrige pas un ordre dangereux. Un déploiement plus sûr conserve le site opérationnel jusqu\'à ce que son remplacement soit prêt.',
            'content' => <<<'HTML'
<p>Dans l'atelier fictif Havre tranquille, le déploiement suit trois étapes : supprimer l'ancien site, envoyer le nouveau, vérifier. La connexion tombe à la deuxième étape. Le visiteur trouve porte close. L'atelier est inventé, l'erreur d'ordre est concrète.</p>
<p>Ajouter trois tentatives semble raisonnable. Mais si chacune commence par enlever ce qui fonctionne encore, on accélère surtout l'arrivée à un répertoire vide.</p>
<p>Mieux vaut préparer, vérifier, basculer. La nouvelle version arrive dans un répertoire distinct. On vérifie que l'ensemble est complet et peut fonctionner. La version précédente reste disponible pour revenir en arrière. Ensuite seulement, on redirige le trafic.</p>
<p>Rien de magique : déplacer les fichiers un par un n'est pas une bascule atomique. Le site peut mélanger les versions entre deux étapes. Une page d'accueil et un fichier de configuration ne valident pas tous les liens. Une sauvegarde sert peu si sa restauration n'a jamais été essayée.</p>
<p>Avant d'approuver l'automatisation, je placerais une coupure après chaque étape. Que reste-t-il au visiteur ? Qui peut revenir en arrière ? Comment vérifier le rétablissement ?</p>
<p>Le meilleur moment pour sauver une version fonctionnelle précède sa suppression.</p>
<p><em>Exemple pédagogique fictif, sans référence à une panne précise. Ce principe de conception ne garantit pas l'absence de défaillance.</em></p>

HTML,
        ],
        'es' => [
            'title' => 'Prepara el relevo antes de apagar la luz',
            'image_alt' => 'Dos casas en miniatura iluminadas sobre plataformas vecinas unidas por un puente.',
            'excerpt' => 'Reintentar no corrige un orden peligroso. Un despliegue más seguro conserva la web operativa hasta que su sustituta esté preparada.',
            'content' => <<<'HTML'
<p>En el taller ficticio Puerto tranquilo, desplegar tiene tres pasos: borrar la web antigua, subir la nueva y comprobar. La conexión falla en el segundo paso. El visitante encuentra la puerta cerrada. El taller es inventado; el error de orden es concreto.</p>
<p>Añadir tres reintentos parece sensato. Pero si todos empiezan retirando lo que aún funciona, sobre todo aceleramos el camino hacia un directorio vacío.</p>
<p>Es mejor preparar, verificar y cambiar. La nueva versión llega a un directorio separado. Se comprueba que la compilación esté completa y pueda ejecutarse. La versión anterior queda disponible para volver atrás. Solo entonces se redirige el tráfico.</p>
<p>No hay magia. Mover archivos uno a uno no es un cambio atómico: entre pasos pueden mezclarse versiones. Encontrar la página inicial y la configuración no valida todos los enlaces. Una copia de seguridad sirve de poco si nunca se ha probado su restauración.</p>
<p>Antes de aprobar la automatización, dibujaría un corte tras cada paso. ¿Qué queda para el visitante? ¿Quién puede revertir el cambio? ¿Cómo comprobamos la recuperación?</p>
<p>El mejor momento para salvar una versión que funciona es antes de borrarla.</p>
<p><em>Ejemplo educativo ficticio, no relato de una caída concreta. Es un principio de diseño, no una garantía contra fallos.</em></p>

HTML,
        ],
        'pl' => [
            'title' => 'Najpierw przygotuj zastępstwo. Dopiero potem zgaś światło.',
            'image_alt' => 'Dwa oświetlone modele domów na sąsiednich platformach połączonych mostem.',
            'excerpt' => 'Ponawianie próby nie naprawi niebezpiecznej kolejności. Bezpieczniejsze wdrożenie zachowuje działającą stronę, dopóki nowa wersja nie jest gotowa.',
            'content' => <<<'HTML'
<p>W fikcyjnym warsztacie Cicha Przystań wdrożenie ma trzy kroki: usuń starą stronę, prześlij nową, sprawdź wynik. Przy drugim kroku znika połączenie. Odwiedzający zastaje zamknięte drzwi. Warsztat jest zmyślony, błąd kolejności konkretny.</p>
<p>Trzy ponowienia brzmią rozsądnie. Jeśli jednak każde usuwa to, co jeszcze działa, przyspieszamy głównie drogę do pustego katalogu.</p>
<p>Lepiej przygotować, zweryfikować, przełączyć. Nowa wersja trafia do osobnego katalogu. Sprawdzamy kompletność i możliwość uruchomienia. Poprzednią wersję zachowujemy na wypadek powrotu. Dopiero potem przekierowujemy ruch.</p>
<p>To nie magia. Przenoszenie plików pojedynczo nie jest przełączeniem atomowym: pomiędzy krokami wersje mogą się mieszać. Strona główna i plik konfiguracji nie potwierdzają poprawności wszystkich odsyłaczy. Kopia niewiele daje, jeśli nigdy nie sprawdzono odtwarzania.</p>
<p>Przed zatwierdzeniem automatyzacji zaznaczyłbym przerwę po każdym kroku. Co zostaje odwiedzającemu? Kto potrafi przywrócić poprzednią wersję? Jak potwierdzimy sprawność usługi?</p>
<p>Najlepszy moment na uratowanie działającej wersji jest przed jej usunięciem.</p>
<p><em>Fikcyjny przykład edukacyjny, nie relacja z konkretnej awarii. To zasada projektowania, nie gwarancja bezawaryjności.</em></p>

HTML,
        ],
        'hu' => [
            'title' => 'Előbb készüljön el az új változat. Csak aztán oltsd el a fényt.',
            'image_alt' => 'Két megvilágított házmodell szomszédos, híddal összekötött emelvényeken.',
            'excerpt' => 'Az újrapróbálkozás nem javítja ki a veszélyes sorrendet. A biztonságosabb telepítés megtartja a működő webhelyet, amíg az utódja elkészül.',
            'content' => <<<'HTML'
<p>A kitalált Csendes Kikötő műhelyben három lépés a telepítés: töröld a régi webhelyet, töltsd fel az újat, ellenőrizd. A második lépésnél megszakad a kapcsolat. A látogató zárt ajtót talál. A műhely fiktív, a sorrendhiba konkrét.</p>
<p>Három újabb próbálkozás észszerűnek tűnik. Ha azonban mindegyik a még működő változat eltakarításával kezdődik, főleg az üres könyvtárhoz vezető utat gyorsítjuk fel.</p>
<p>Jobb sorrend: előkészítés, ellenőrzés, átkapcsolás. Az új verzió külön könyvtárba kerül. Ellenőrizzük a teljességét és az indíthatóságát. A korábbi verzió elérhető marad a visszaállításhoz. Csak ezután irányítjuk át a forgalmat.</p>
<p>Ez sem varázslat. A fájlok egyenkénti mozgatása nem atomi váltás: közben keveredhetnek a verziók. A kezdőlap és a konfiguráció megléte nem igazol minden hivatkozást. A mentés keveset ér, ha a visszaállítást sosem próbáltuk ki.</p>
<p>Jóváhagyás előtt minden lépés után kapcsolatszakadást jelölnék a terven. Mi marad a látogatónak? Ki tud visszaállni? Hogyan igazoljuk a helyreállást?</p>
<p>A működő verzió megmentésének legjobb ideje a törlése előtt van.</p>
<p><em>Fiktív oktatási példa, nem konkrét szolgáltatás kiesésének leírása. Tervezési elv, nem hibamentességi garancia.</em></p>

HTML,
        ],
        'it' => [
            'title' => 'Prepara il ricambio prima di spegnere la luce',
            'image_alt' => 'Due modellini di case illuminate su piattaforme vicine collegate da un ponte.',
            'excerpt' => 'Riprovare non corregge una sequenza pericolosa. Un rilascio più sicuro conserva il sito funzionante finché il sostituto non è pronto.',
            'content' => <<<'HTML'
<p>Nel laboratorio immaginario Porto quieto, il rilascio ha tre passaggi: elimina il vecchio sito, carica il nuovo, verifica. La connessione cade al secondo. Il visitatore trova la porta chiusa. Il laboratorio è inventato, l'errore nella sequenza è concreto.</p>
<p>Aggiungere tre tentativi sembra ragionevole. Ma se ciascuno comincia eliminando ciò che funziona ancora, acceleriamo soprattutto il percorso verso una cartella vuota.</p>
<p>Meglio preparare, verificare, commutare. La nuova versione arriva in una cartella separata. Se ne controllano completezza e avviabilità. La versione precedente resta disponibile per tornare indietro. Solo allora si reindirizza il traffico.</p>
<p>Non è magia. Spostare i file uno alla volta non è un passaggio atomico: fra un'operazione e l'altra le versioni possono mescolarsi. Trovare pagina iniziale e configurazione non convalida tutti i collegamenti. Un backup serve poco se il ripristino non è mai stato provato.</p>
<p>Prima di approvare l'automazione, segnerei un'interruzione dopo ogni passaggio. Che cosa rimane al visitatore? Chi sa tornare indietro? Come verifichiamo il ripristino del servizio?</p>
<p>Il momento migliore per salvare una versione funzionante è prima di eliminarla.</p>
<p><em>Esempio educativo immaginario, non resoconto di un disservizio specifico. È un principio progettuale, non una garanzia contro i guasti.</em></p>

HTML,
        ],
        'uk' => [
            'title' => 'Спочатку підготуй заміну. Лише потім гаси світло.',
            'image_alt' => 'Два освітлені макети будинків на сусідніх платформах, з’єднаних мостом.',
            'excerpt' => 'Повторна спроба не виправить небезпечної послідовності. Безпечніше розгортання зберігає робочий сайт, доки заміна не готова.',
            'content' => <<<'HTML'
<p>У вигаданій майстерні Тиха гавань розгортання має три кроки: видалити старий сайт, завантажити новий, перевірити. На другому кроці зникає з’єднання. Відвідувач бачить зачинені двері. Майстерня вигадана, помилка послідовності конкретна.</p>
<p>Додати три повтори здається розумним. Але якщо кожна спроба починається з видалення того, що ще працює, ми передусім прискорюємо шлях до порожнього каталогу.</p>
<p>Кращий порядок: підготувати, перевірити, перемкнути. Нова версія надходить в окремий каталог. Перевіряємо повноту збірки та можливість запуску. Попередня версія залишається доступною для повернення. Лише тоді перенаправляємо трафік.</p>
<p>Це теж не магія. Переміщення файлів по одному не є атомарним перемиканням: між кроками версії можуть змішуватися. Наявність головної сторінки й конфігурації не перевіряє всіх посилань. Резервна копія мало допоможе без випробуваного відновлення.</p>
<p>Перед схваленням автоматизації я позначив би розрив зв’язку після кожного кроку. Що залишається відвідувачеві? Хто може повернути попередню версію? Як підтвердити відновлення служби?</p>
<p>Найкращий час урятувати робочу версію настає до її видалення.</p>
<p><em>Вигаданий освітній приклад, не повідомлення про збій конкретної служби. Це принцип проєктування, а не гарантія безвідмовності.</em></p>

HTML,
        ],
    ],
];
