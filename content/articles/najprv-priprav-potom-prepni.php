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
            'image_alt' => 'Dva modely domov na susedných plošinách spojených mostom.',
            'excerpt' => 'Opakovanie pokusu nenapraví nebezpečné poradie krokov. Bezpečnejšie nasadenie začína tým, že fungujúci web zostane na mieste, kým náhrada nie je pripravená.',
            'content' => <<<'HTML'
<p>Predstavme si malú dielňu a jej prezentačný web. Nová verzia sa nasadzuje tromi krokmi: vymaž starú, nahraj novú, skontroluj výsledok. Pri druhom kroku vypadne spojenie a návštevník nájde zamknuté dvere. Celá situácia je modelová, nepopisuje konkrétnu firmu ani skutočný výpadok.</p>
<p>Pridať tri opakovania vyzerá rozumne. Lenže ak každý pokus začína vyprataním toho, čo ešte funguje, zrýchlili sme najmä cestu k prázdnemu adresáru.</p>
<p>Lepšie poradie znie: pripraviť, overiť, prepnúť. Nová verzia príde do samostatného adresára. Skontroluje sa, či je úplná a funguje. Doterajšia verzia zostane k dispozícii, aby sa k nej dalo vrátiť. Až potom začnú požiadavky návštevníkov smerovať na novú verziu.</p>
<p>Ani toto nie je kúzlo. Presúvanie súborov po jednom nie je prepnutie v jedinom nedeliteľnom kroku: medzi krokmi môže byť web v zmiešanom stave. Prítomnosť úvodnej stránky a konfiguračného súboru neoverí všetky odkazy. Záloha nepomôže, ak sme nikdy nevyskúšali obnovu.</p>
<p>Pred schválením automatizácie by som preto zvážil, čo sa stane pri prerušení spojenia po každom z krokov. Čo zostane návštevníkovi? Kto vie obnoviť predchádzajúcu verziu? Ako spoznáme, že je služba opäť v poriadku?</p>
<p>Najlepší okamih na záchranu fungujúcej verzie je ešte predtým, než ju odstránime.</p>
<p><em>Fiktívny vzdelávací príklad, nie správa o výpadku konkrétnej služby. Opísané poradie je návrhový princíp, nie záruka bezporuchovosti.</em></p>

HTML,
        ],
        'en' => [
            'title' => 'Prepare the replacement before switching off the lights',
            'image_alt' => 'Two miniature houses on adjacent platforms joined by a bridge.',
            'excerpt' => 'Retries do not fix an unsafe sequence. Safer deployment keeps the working website in place until its replacement is ready.',
            'content' => <<<'HTML'
<p>Imagine a small workshop and its public website. Deployment has three steps: delete the old version, upload the new one, check the result. The connection fails during step two, leaving visitors at a locked door. This entire scenario is hypothetical; it does not describe a particular company or an actual outage.</p>
<p>Adding three retries looks sensible. But if every attempt clears away what still works, we have mainly accelerated the journey to an empty directory.</p>
<p>A better sequence is prepare, verify, switch. Upload the release to a separate directory. Check that the build is complete and can run. Keep the previous version available for rollback. Only then direct traffic to the replacement.</p>
<p>This is no magic trick. Moving files individually is not an atomic switch: the site can contain mixed versions between steps. The presence of a homepage and a configuration file does not mean every link works. A backup is little help if restoration has never been tried.</p>
<p>Before approving automation, I would consider what happens if the connection fails after each step. What remains for visitors? Who can roll back? How will we know service is healthy again?</p>
<p>The best moment to save a working version is before removing it.</p>
<p><em>A fictional educational example, not an incident report about a particular service. This sequence is a design principle, not a guarantee against failure.</em></p>

HTML,
        ],
        'cs' => [
            'title' => 'Nejprve připrav náhradu. Teprve potom zhasni.',
            'image_alt' => 'Dva modely domů na sousedních plošinách spojených mostem.',
            'excerpt' => 'Opakování pokusu nenapraví nebezpečné pořadí. Bezpečnější nasazení ponechá fungující web na místě, dokud není náhrada připravena.',
            'content' => <<<'HTML'
<p>Představme si malou dílnu a její prezentační web. Nasazení má tři kroky: smaž starou verzi, nahraj novou, zkontroluj výsledek. Při druhém kroku vypadne spojení a návštěvník najde zamčené dveře. Celá situace je modelová, nepopisuje konkrétní firmu ani skutečný výpadek.</p>
<p>Přidat tři opakování vypadá rozumně. Jestliže však každý pokus odstraní to, co ještě funguje, urychlili jsme hlavně cestu k prázdnému adresáři.</p>
<p>Lepší pořadí je připravit, ověřit, přepnout. Nová verze přijde do samostatného adresáře. Ověří se, zda je úplná a funguje. Dosavadní verze zůstane připravena pro návrat. Teprve pak se provoz přesměruje.</p>
<p>Ani to není kouzlo. Přesouvání souborů jednotlivě není atomické přepnutí: mezi kroky může vzniknout smíšený stav. Přítomnost úvodní stránky a konfigurace neověří všechny odkazy. Záloha nepomůže, pokud jsme nikdy nevyzkoušeli obnovu.</p>
<p>Před schválením automatizace bych do návrhu zakreslil výpadek po každém kroku. Co zůstane návštěvníkovi? Kdo umí vrátit předchozí verzi? Jak poznáme, že služba opět funguje správně?</p>
<p>Nejlepší chvíle pro záchranu fungující verze je před jejím odstraněním.</p>
<p><em>Fiktivní vzdělávací příklad, nikoli zpráva o výpadku konkrétní služby. Jde o návrhový princip, ne záruku bezporuchovosti.</em></p>

HTML,
        ],
        'de' => [
            'title' => 'Erst den Ersatz vorbereiten, dann das Licht ausschalten',
            'image_alt' => 'Zwei Miniaturhäuser auf benachbarten, durch eine Brücke verbundenen Plattformen.',
            'excerpt' => 'Wiederholungen beheben keine gefährliche Reihenfolge. Ein sichereres Deployment lässt die funktionierende Website bestehen, bis ihr Ersatz bereitsteht.',
            'content' => <<<'HTML'
<p>Stellen wir uns eine kleine Werkstatt und ihre öffentliche Website vor. Das Deployment hat drei Schritte: alte Version löschen, neue hochladen, Ergebnis prüfen. Beim zweiten Schritt bricht die Verbindung ab, und Besucher stehen vor verschlossener Tür. Das gesamte Beispiel ist hypothetisch und beschreibt weder ein bestimmtes Unternehmen noch einen tatsächlichen Ausfall.</p>
<p>Drei weitere Versuche wirken vernünftig. Beginnt aber jeder Versuch damit, das noch Funktionierende zu entfernen, beschleunigen wir vor allem den Weg zum leeren Verzeichnis.</p>
<p>Besser ist: vorbereiten, prüfen, umschalten. Die neue Version kommt in ein separates Verzeichnis. Es wird geprüft, ob sie vollständig ist und funktioniert. Die bisherige Version bleibt für eine Rückkehr verfügbar. Erst dann wird der Verkehr umgeleitet.</p>
<p>Auch das ist keine Zauberei. Einzelnes Verschieben von Dateien ist kein atomarer Wechsel: Zwischenzustände können Versionen mischen. Eine Startseite und eine Konfigurationsdatei bestätigen nicht sämtliche Links. Eine Sicherung hilft wenig, wenn die Wiederherstellung nie erprobt wurde.</p>
<p>Vor der Freigabe würde ich nach jedem Schritt einen Verbindungsabbruch einzeichnen. Was steht den Besuchern dann noch zur Verfügung? Wer kann zurückschalten? Woran erkennen wir den wiederhergestellten Betrieb?</p>
<p>Der beste Zeitpunkt, eine funktionierende Version zu retten, liegt vor ihrer Entfernung.</p>
<p><em>Fiktives Lehrbeispiel, kein Ausfallbericht eines konkreten Dienstes. Die Reihenfolge ist ein Gestaltungsprinzip, keine Garantie für störungsfreien Betrieb.</em></p>

HTML,
        ],
        'fr' => [
            'title' => 'Préparer le remplacement avant d\'éteindre la lumière',
            'image_alt' => 'Deux maisons miniatures sur des plateformes voisines reliées par un pont.',
            'excerpt' => 'Répéter une tentative ne corrige pas une mauvaise séquence d\'opérations. Un déploiement plus sûr conserve le site opérationnel jusqu\'à ce que son remplacement soit prêt.',
            'content' => <<<'HTML'
<p>Imaginons un petit atelier et son site de présentation. Le déploiement suit trois étapes : supprimer l'ancienne version, envoyer la nouvelle, vérifier. La connexion tombe à la deuxième étape, et le visiteur trouve porte close. Toute cette situation est hypothétique ; elle ne décrit aucune entreprise ni panne réelle.</p>
<p>Ajouter trois tentatives semble raisonnable. Mais si chacune commence par enlever ce qui fonctionne encore, on accélère surtout l'arrivée à un répertoire vide.</p>
<p>Mieux vaut préparer, vérifier, basculer. La nouvelle version arrive dans un répertoire distinct. On vérifie que l'ensemble est complet et peut fonctionner. La version précédente reste disponible pour revenir en arrière. Ensuite seulement, on redirige le trafic.</p>
<p>Rien de magique : déplacer les fichiers un par un n'est pas une bascule atomique. Le site peut mélanger les versions entre deux étapes. Une page d'accueil et un fichier de configuration ne valident pas tous les liens. Une sauvegarde sert peu si sa restauration n'a jamais été essayée.</p>
<p>Avant d'approuver l'automatisation, j'examinerais les conséquences d'une coupure après chaque étape. Que reste-t-il au visiteur ? Qui peut revenir en arrière ? Comment vérifier le rétablissement ?</p>
<p>Le meilleur moment pour sauver une version fonctionnelle précède sa suppression.</p>
<p><em>Exemple pédagogique fictif, sans référence à une panne précise. Ce principe de conception ne garantit pas l'absence de défaillance.</em></p>

HTML,
        ],
        'es' => [
            'title' => 'Prepara el relevo antes de apagar la luz',
            'image_alt' => 'Dos casas en miniatura sobre plataformas vecinas unidas por un puente.',
            'excerpt' => 'Reintentar no corrige un orden peligroso. Un despliegue más seguro conserva la web operativa hasta que su sustituta esté preparada.',
            'content' => <<<'HTML'
<p>Imaginemos un pequeño taller y su web de presentación. El despliegue tiene tres pasos: borrar la versión antigua, subir la nueva y comprobar el resultado. La conexión falla en el segundo paso y el visitante encuentra la puerta cerrada. Toda la situación es hipotética; no describe una empresa concreta ni una caída real.</p>
<p>Añadir tres reintentos parece sensato. Pero si todos empiezan retirando lo que aún funciona, sobre todo aceleramos el camino hacia un directorio vacío.</p>
<p>Es mejor preparar, verificar y cambiar. La nueva versión llega a un directorio separado. Se comprueba que esté completa y funcione. La versión anterior queda disponible para volver atrás. Solo entonces se redirige el tráfico.</p>
<p>No hay magia. Mover archivos uno a uno no es un cambio atómico: entre pasos pueden mezclarse versiones. Encontrar la página inicial y la configuración no valida todos los enlaces. Una copia de seguridad sirve de poco si nunca se ha probado su restauración.</p>
<p>Antes de aprobar la automatización, examinaría qué ocurre si se corta la conexión después de cada paso. ¿Qué queda para el visitante? ¿Quién puede revertir el cambio? ¿Cómo comprobamos la recuperación?</p>
<p>El mejor momento para salvar una versión que funciona es antes de borrarla.</p>
<p><em>Ejemplo educativo ficticio, no relato de una caída concreta. Es un principio de diseño, no una garantía contra fallos.</em></p>

HTML,
        ],
        'pl' => [
            'title' => 'Najpierw przygotuj zastępstwo. Dopiero potem zgaś światło.',
            'image_alt' => 'Dwa modele domów na sąsiednich platformach połączonych mostem.',
            'excerpt' => 'Ponawianie próby nie naprawi niebezpiecznej kolejności. Bezpieczniejsze wdrożenie zachowuje działającą stronę, dopóki nowa wersja nie jest gotowa.',
            'content' => <<<'HTML'
<p>Wyobraźmy sobie mały warsztat i jego stronę internetową. Wdrożenie ma trzy kroki: usuń starą wersję, prześlij nową, sprawdź wynik. Przy drugim kroku połączenie się urywa, a odwiedzający zastaje zamknięte drzwi. Cała sytuacja jest modelowa, nie opisuje konkretnej firmy ani rzeczywistej awarii.</p>
<p>Trzy ponowienia brzmią rozsądnie. Jeśli jednak każde usuwa to, co jeszcze działa, przyspieszamy głównie drogę do pustego katalogu.</p>
<p>Lepiej przygotować, zweryfikować, przełączyć. Nowa wersja trafia do osobnego katalogu. Sprawdzamy kompletność i możliwość uruchomienia. Poprzednią wersję zachowujemy na wypadek powrotu. Dopiero potem przekierowujemy ruch.</p>
<p>To nie magia. Przenoszenie plików pojedynczo nie jest przełączeniem atomowym: pomiędzy krokami wersje mogą się mieszać. Strona główna i plik konfiguracji nie potwierdzają poprawności wszystkich odsyłaczy. Kopia niewiele daje, jeśli nigdy nie sprawdzono odtwarzania.</p>
<p>Przed zatwierdzeniem automatyzacji sprawdziłbym, co się stanie, jeśli połączenie urwie się po każdym z kolejnych kroków. Co zostaje odwiedzającemu? Kto potrafi przywrócić poprzednią wersję? Jak potwierdzimy sprawność usługi?</p>
<p>Najlepszy moment na uratowanie działającej wersji jest przed jej usunięciem.</p>
<p><em>Fikcyjny przykład edukacyjny, nie relacja z konkretnej awarii. To zasada projektowania, nie gwarancja bezawaryjności.</em></p>

HTML,
        ],
        'hu' => [
            'title' => 'Előbb készüljön el az új változat. Csak aztán oltsd el a fényt.',
            'image_alt' => 'Két házmodell szomszédos, híddal összekötött emelvényeken.',
            'excerpt' => 'Az újrapróbálkozás nem javítja ki a veszélyes sorrendet. A biztonságosabb telepítés megtartja a működő webhelyet, amíg az utódja elkészül.',
            'content' => <<<'HTML'
<p>Képzeljünk el egy kis műhelyt és a bemutatkozó webhelyét. A telepítés három lépésből áll: töröld a régi verziót, töltsd fel az újat, ellenőrizd az eredményt. A második lépésnél megszakad a kapcsolat, a látogató zárt ajtót talál. Az egész helyzet szemléltető példa, nem egy konkrét cég vagy tényleges üzemzavar leírása.</p>
<p>Három újabb próbálkozás észszerűnek tűnik. Ha azonban mindegyik a még működő változat eltakarításával kezdődik, főleg az üres könyvtárhoz vezető utat gyorsítjuk fel.</p>
<p>Jobb sorrend: előkészítés, ellenőrzés, átkapcsolás. Az új verzió külön könyvtárba kerül. Ellenőrizzük, hogy teljes-e az új verzió, és működik-e. A korábbi verzió elérhető marad a visszaállításhoz. Csak ezután irányítjuk át a forgalmat.</p>
<p>Ez sem varázslat. A fájlok egyenkénti mozgatása nem atomi váltás: közben keveredhetnek a verziók. A kezdőlap és a konfiguráció megléte nem igazol minden hivatkozást. A mentés keveset ér, ha a visszaállítást sosem próbáltuk ki.</p>
<p>Jóváhagyás előtt végiggondolnám, mi történik, ha az egyes lépések után megszakad a kapcsolat. Mi marad a látogatónak? Ki tud visszaállni? Hogyan igazoljuk a helyreállást?</p>
<p>A működő verzió megmentésének legjobb ideje a törlése előtt van.</p>
<p><em>Fiktív oktatási példa, nem konkrét szolgáltatás kiesésének leírása. Tervezési elv, nem hibamentességi garancia.</em></p>

HTML,
        ],
        'it' => [
            'title' => 'Prepara il ricambio prima di spegnere la luce',
            'image_alt' => 'Due modellini di case su piattaforme vicine collegate da un ponte.',
            'excerpt' => 'Riprovare non corregge una sequenza pericolosa. Un rilascio più sicuro conserva il sito funzionante finché il sostituto non è pronto.',
            'content' => <<<'HTML'
<p>Immaginiamo un piccolo laboratorio e il suo sito di presentazione. Il rilascio ha tre passaggi: elimina la vecchia versione, carica la nuova, verifica il risultato. La connessione cade al secondo passaggio e il visitatore trova la porta chiusa. L'intera situazione è ipotetica: non descrive un'azienda specifica né un disservizio reale.</p>
<p>Aggiungere tre tentativi sembra ragionevole. Ma se ciascuno comincia eliminando ciò che funziona ancora, acceleriamo soprattutto il percorso verso una cartella vuota.</p>
<p>Meglio preparare la nuova versione, verificarla e solo allora attivarla. La nuova versione arriva in una cartella separata. Si controlla che sia completa e funzioni. La versione precedente resta disponibile per tornare indietro. Solo allora si reindirizza il traffico.</p>
<p>Non è magia. Spostare i file uno alla volta non è un passaggio atomico: fra un'operazione e l'altra le versioni possono mescolarsi. Trovare pagina iniziale e configurazione non convalida tutti i collegamenti. Un backup serve poco se il ripristino non è mai stato provato.</p>
<p>Prima di approvare l'automazione, valuterei che cosa accade se la connessione si interrompe dopo ciascun passaggio. Che cosa rimane al visitatore? Chi sa tornare indietro? Come verifichiamo il ripristino del servizio?</p>
<p>Il momento migliore per salvare una versione funzionante è prima di eliminarla.</p>
<p><em>Esempio educativo immaginario, non resoconto di un disservizio specifico. È un principio progettuale, non una garanzia contro i guasti.</em></p>

HTML,
        ],
        'uk' => [
            'title' => 'Спочатку підготуй заміну. Лише потім гаси світло.',
            'image_alt' => 'Два макети будинків на сусідніх платформах, з’єднаних мостом.',
            'excerpt' => 'Повторна спроба не виправить небезпечної послідовності. Безпечніше розгортання зберігає робочий сайт, доки заміна не готова.',
            'content' => <<<'HTML'
<p>Уявімо невелику майстерню та її презентаційний сайт. Розгортання має три кроки: видалити стару версію, завантажити нову, перевірити результат. На другому кроці зникає з’єднання, і відвідувач бачить зачинені двері. Уся ситуація умовна, вона не описує конкретної фірми чи реального збою.</p>
<p>Додати три повтори здається розумним. Але якщо кожна спроба починається з видалення того, що ще працює, ми передусім прискорюємо шлях до порожнього каталогу.</p>
<p>Кращий порядок: підготувати, перевірити, перемкнути. Нова версія надходить в окремий каталог. Перевіряємо повноту збірки та можливість запуску. Попередня версія залишається доступною для повернення. Лише тоді перенаправляємо трафік.</p>
<p>Це теж не магія. Переміщення файлів по одному не є атомарним перемиканням: між кроками версії можуть змішуватися. Наявність головної сторінки й конфігурації не означає, що всі посилання працюють. Резервна копія мало допоможе без випробуваного відновлення.</p>
<p>Перед схваленням автоматизації я розглянув би, що станеться, якщо зв’язок обірветься після кожного з кроків. Що залишається відвідувачеві? Хто може повернути попередню версію? Як підтвердити відновлення служби?</p>
<p>Найкращий час урятувати робочу версію настає до її видалення.</p>
<p><em>Вигаданий освітній приклад, не повідомлення про збій конкретної служби. Це принцип проєктування, а не гарантія безвідмовності.</em></p>

HTML,
        ],
    ],
];
