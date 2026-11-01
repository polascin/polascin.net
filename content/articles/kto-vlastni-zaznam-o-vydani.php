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
 * Oprava záznamu o vydaní Arenibus 27. 10. 2026 a ochrana proti súbežnému zápisu.
 * Autorom overené commity v súkromnom repozitári: 41d54d45 (oprava záznamu),
 * ebf43069 (ochrana proti súbežnému zápisu). Verejné overenie odkazov nie je možné.
 * Arenibus: vlastný .NET systém pre nefrológiu a dialýzu (polascin.net).
 */
return [
    'slug' => 'kto-vlastni-zaznam-o-vydani',
    'author' => 'MUDr. Ľubomír Polaščín',
    'category' => 'blog',
    'is_top' => 0,
    'published_at' => '2026-11-01 08:40:00',
    'image' => 'images/articles/kto-vlastni-zaznam-o-vydani.webp',
    'translations' => [
        'sk' => [
            'title' => 'Úloha môže mať dvoch. Záznam o vydaní jedného.',
            'image_alt' => 'Na tmavom stole leží otvorený zápisník. Zľava a sprava k nemu siahajú dve priesvitné postavy s tyrkysovými perami, medzi nimi tenká fialová čiara nad stránkou.',
            'excerpt' => 'Dvadsiateho siedmeho októbra som v Arenibuse opravoval históriu nasadenia. Dva agenty dokončili svoje úlohy a záznam o vydaní sa aj tak pokazil. Odvtedy skript odmietne neočakávané zmeny, ktoré by do záznamu vtiahol.',
            'content' => <<<'HTML'
<p>Dvadsiateho siedmeho októbra 2026 som musel opraviť históriu nasadenia v Arenibuse, softvéri pre nefrológiu a dialýzu. Súbežný agent upravil ten istý pracovný strom vydania. Vo výslednom zázname ostalo tvrdenie o mutačnom teste, ktorý nebežal, a odkaz na triedu, ktorá neexistovala.</p>
<p>Problém nebol len v zlej vete. Postup vydania dovolil viacerým autorom meniť dôkaz o tom, čo sa stalo.</p>
<p>Do skriptu vydania som preto pridal ochranu. Pred zbieraním zmien skontroluje neočakávané úpravy súborov s verziou a stavom, vrátane zmien už zapísaných v pracovnom strome. Keď nájde zásah iného autora, zastaví sa a nestrhne ich do vydania. Ochrana má aj vlastné testy.</p>
<p>Tým sa ešte nestane každý záznam o vydaní spoľahlivý sám od seba. Uzaviera sa však jedna konkrétna cesta, ktorou sa do postupu dostal nepresný záznam.</p>
<p>Pri práci s viacerými agentmi platí jednoduché pravidlo: treba určiť, kto vlastní záznam, nie len kto vlastní úlohu. Sebavedomá správa o dokončení je lacná. Postup, ktorý odmietne vtiahnuť nevysvetlené zmeny, je omnoho užitočnejší.</p>
<p><em>Osobná skúsenosť z vývoja softvéru. Nie je to návod na klinickú prax.</em></p>

HTML,
        ],
        'en' => [
            'title' => 'A task can have two owners. The release record needs one.',
            'image_alt' => 'An open ledger lies on a dark desk. Two translucent figures reach toward it from left and right with teal pens; a thin violet line hangs above the page between them.',
            'excerpt' => 'On 27 October I had to correct the deployment history in Arenibus. Two agents each finished their task and the release record still went wrong. The script now refuses unexpected changes it would otherwise fold in.',
            'content' => <<<'HTML'
<p>On 27 October 2026 I had to correct the deployment history in Arenibus, my nephrology and dialysis software. A concurrent agent had edited the same release worktree. The resulting record included a mutation-test claim for a test that had not run, and a reference to a class that did not exist.</p>
<p>The problem was not simply a bad sentence. The release process allowed several writers to alter the evidence of what had happened.</p>
<p>So I added a guard to the release script. Before collecting changes, it checks for unexpected edits to version and status files, including changes already committed in the worktree. If it finds another writer's changes, it stops rather than sweeping them into the release. The guard has its own self-tests.</p>
<p>This does not make every release record trustworthy by itself. It closes one concrete route by which an inaccurate record entered the process.</p>
<p>My lesson from building with several agents: define who owns the record, not only who owns the task. A confident completion message is cheap. A release process that refuses to absorb unexplained changes is far more useful.</p>
<p><em>A personal account from software development. It is not clinical guidance.</em></p>

HTML,
        ],
        'cs' => [
            'title' => 'Úloha může mít dva. Záznam o vydání jednoho.',
            'image_alt' => 'Na tmavém stole leží otevřený zápisník. Zleva a zprava k němu sahají dvě průsvitné postavy s tyrkysovými pery, mezi nimi tenká fialová čára nad stránkou.',
            'excerpt' => 'Dvacátého sedmého října jsem v Arenibu opravoval historii nasazení. Dva agenty dokončily své úlohy a záznam o vydání se přesto pokazil. Od té doby skript odmítne neočekávané změny, které by do záznamu vtáhl.',
            'content' => <<<'HTML'
<p>Dvacátého sedmého října 2026 jsem musel opravit historii nasazení v Arenibu, softwaru pro nefrologii a dialýzu. Souběžný agent upravil tentýž pracovní strom vydání. Ve výsledném záznamu zůstalo tvrzení o mutačním testu, který neběžel, a odkaz na třídu, která neexistovala.</p>
<p>Problém nebyl jen ve špatné větě. Postup vydání dovolil více autorům měnit důkaz o tom, co se stalo.</p>
<p>Do skriptu vydání jsem proto přidal ochranu. Před sběrem změn zkontroluje neočekávané úpravy souborů s verzí a stavem, včetně změn už zapsaných v pracovním stromu. Když najde zásah jiného autora, zastaví se a nestrhne je do vydání. Ochrana má i vlastní testy.</p>
<p>Tím se ještě nestane každý záznam o vydání spolehlivý sám od sebe. Uzavírá se však jedna konkrétní cesta, kterou se do postupu dostal nepřesný záznam.</p>
<p>Při práci s více agenty platí jednoduché pravidlo: je třeba určit, kdo vlastní záznam, nejen kdo vlastní úlohu. Sebevědomá zpráva o dokončení je levná. Postup, který odmítne vtáhnout nevysvětlené změny, je mnohem užitečnější.</p>
<p><em>Osobní zkušenost z vývoje softwaru. Není to návod na klinickou praxi.</em></p>

HTML,
        ],
        'de' => [
            'title' => 'Eine Aufgabe kann zwei Eigentümer haben. Der Release-Eintrag braucht einen.',
            'image_alt' => 'Auf einem dunklen Schreibtisch liegt ein offenes Notizbuch. Von links und rechts greifen zwei durchscheinende Gestalten mit türkisen Federn danach; zwischen ihnen hängt eine dünne violette Linie über der Seite.',
            'excerpt' => 'Am 27. Oktober musste ich in Arenibus die Deployment-Geschichte korrigieren. Zwei Agenten beendeten jeweils ihre Aufgabe, und der Release-Eintrag ging trotzdem schief. Das Skript lehnt seither unerwartete Änderungen ab, die es sonst hereinziehen würde.',
            'content' => <<<'HTML'
<p>Am 27. Oktober 2026 musste ich die Deployment-Geschichte in Arenibus korrigieren, meiner Software für Nephrologie und Dialyse. Ein gleichzeitiger Agent hatte denselben Release-Arbeitsbaum bearbeitet. Im resultierenden Eintrag stand die Behauptung eines Mutationstests, der nicht gelaufen war, und ein Verweis auf eine Klasse, die nicht existierte.</p>
<p>Das Problem war nicht nur ein schlechter Satz. Der Release-Ablauf erlaubte mehreren Autoren, den Beleg dessen zu ändern, was geschehen war.</p>
<p>Deshalb fügte ich dem Release-Skript eine Absicherung hinzu. Bevor es Änderungen sammelt, prüft es unerwartete Bearbeitungen an Versions- und Statusdateien, einschließlich Änderungen, die im Arbeitsbaum schon festgeschrieben sind. Findet es den Eingriff eines anderen Autors, hält es an, statt sie in das Release zu ziehen. Die Absicherung hat auch eigene Tests.</p>
<p>Damit wird nicht jeder Release-Eintrag von selbst vertrauenswürdig. Es schließt jedoch einen konkreten Weg, auf dem ein ungenauer Eintrag in den Ablauf gelangt war.</p>
<p>Meine Lehre aus der Arbeit mit mehreren Agenten: festlegen, wer den Eintrag besitzt, nicht nur wer die Aufgabe besitzt. Eine selbstsichere Fertigmeldung ist billig. Ein Release-Ablauf, der unerklärte Änderungen ablehnt, ist weit nützlicher.</p>
<p><em>Ein persönlicher Bericht aus der Softwareentwicklung. Keine klinische Anleitung.</em></p>

HTML,
        ],
        'fr' => [
            'title' => 'Une tâche peut avoir deux propriétaires. Le journal de version n’en a qu’un.',
            'image_alt' => 'Un carnet ouvert repose sur un bureau sombre. Deux silhouettes translucides tendent vers lui des plumes turquoise, à gauche et à droite ; une fine ligne violette flotte au-dessus de la page entre elles.',
            'excerpt' => 'Le 27 octobre, j’ai dû corriger l’historique de déploiement dans Arenibus. Deux agents ont chacun terminé leur tâche, et le journal de version s’est quand même abîmé. Le script refuse désormais les modifications inattendues qu’il aurait absorbées.',
            'content' => <<<'HTML'
<p>Le 27 octobre 2026, j’ai dû corriger l’historique de déploiement dans Arenibus, mon logiciel de néphrologie et de dialyse. Un agent concurrent avait modifié le même arbre de travail de version. Le journal résultant contenait l’affirmation d’un test de mutation qui n’avait pas tourné, et une référence à une classe qui n’existait pas.</p>
<p>Le problème n’était pas seulement une mauvaise phrase. Le processus de version permettait à plusieurs auteurs de modifier la preuve de ce qui s’était passé.</p>
<p>J’ai donc ajouté une garde au script de version. Avant de rassembler les changements, il vérifie les modifications inattendues des fichiers de version et d’état, y compris les changements déjà consignés dans l’arbre de travail. S’il détecte l’intervention d’un autre auteur, il s’arrête plutôt que de les entraîner dans la version. La garde a aussi ses propres tests.</p>
<p>Cela ne rend pas chaque journal de version digne de confiance à lui seul. Cela ferme cependant une voie concrète par laquelle un enregistrement inexact était entré dans le processus.</p>
<p>Ma leçon en travaillant avec plusieurs agents : définir qui possède le journal, pas seulement qui possède la tâche. Un message confiant de fin de tâche est bon marché. Un processus de version qui refuse d’absorber des changements inexpliqués est bien plus utile.</p>
<p><em>Récit personnel issu du développement logiciel. Ce n’est pas un guide clinique.</em></p>

HTML,
        ],
        'es' => [
            'title' => 'Una tarea puede tener dos dueños. El registro de versión necesita uno.',
            'image_alt' => 'Un cuaderno abierto yace sobre un escritorio oscuro. Dos figuras translúcidas se acercan desde la izquierda y la derecha con plumas turquesa; entre ellas, una fina línea violeta flota sobre la página.',
            'excerpt' => 'El 27 de octubre tuve que corregir el historial de despliegue en Arenibus. Dos agentes terminaron cada uno su tarea y el registro de versión igual se estropeó. El script rechaza desde entonces los cambios inesperados que de otro modo absorbería.',
            'content' => <<<'HTML'
<p>El 27 de octubre de 2026 tuve que corregir el historial de despliegue en Arenibus, mi software de nefrología y diálisis. Un agente concurrente había editado el mismo árbol de trabajo de la versión. El registro resultante incluía la afirmación de una prueba de mutación que no se había ejecutado y una referencia a una clase que no existía.</p>
<p>El problema no era solo una frase mala. El proceso de versión permitía a varios autores alterar la prueba de lo que había ocurrido.</p>
<p>Por eso añadí una guarda al script de versión. Antes de reunir los cambios, comprueba ediciones inesperadas en los archivos de versión y de estado, incluidas las ya consignadas en el árbol de trabajo. Si detecta la intervención de otro autor, se detiene en lugar de arrastrarlas a la versión. La guarda tiene también sus propias pruebas.</p>
<p>Con eso no se vuelve fiable por sí solo cada registro de versión. Sí se cierra, sin embargo, una vía concreta por la que un registro inexacto entró en el proceso.</p>
<p>Mi lección al construir con varios agentes: definir quién posee el registro, no solo quién posee la tarea. Un mensaje confiado de finalización es barato. Un proceso de versión que se niega a absorber cambios sin explicación es mucho más útil.</p>
<p><em>Relato personal del desarrollo de software. No es orientación clínica.</em></p>

HTML,
        ],
        'pl' => [
            'title' => 'Zadanie może mieć dwóch właścicieli. Zapis wydania potrzebuje jednego.',
            'image_alt' => 'Na ciemnym biurku leży otwarty notes. Z lewej i prawej sięgają ku niemu dwie półprzezroczyste postacie z turkusowymi piórami; między nimi nad stroną wisi cienka fioletowa linia.',
            'excerpt' => 'Dwudziestego siódmego października musiałem poprawić historię wdrożenia w Arenibusie. Dwa agenty dokończyły swoje zadania, a zapis wydania i tak się popsował. Skrypt od tej pory odrzuca nieoczekiwane zmiany, które inaczej wciągnąłby do zapisu.',
            'content' => <<<'HTML'
<p>Dwudziestego siódmego października 2026 musiałem poprawić historię wdrożenia w Arenibusie, oprogramowaniu do nefrologii i dializy. Równoległy agent edytował to samo drzewo robocze wydania. W wynikowym zapisie zostało twierdzenie o teście mutacyjnym, który nie został uruchomiony, oraz odniesienie do klasy, która nie istniała.</p>
<p>Problem nie leżał tylko w złym zdaniu. Proces wydania pozwalał kilku autorom zmieniać dowód tego, co się wydarzyło.</p>
<p>Dlatego dodałem do skryptu wydania ochronę. Przed zbieraniem zmian sprawdza nieoczekiwane edycje plików wersji i statusu, w tym zmiany już zapisane w drzewie roboczym. Gdy znajdzie ingerencję innego autora, zatrzymuje się, zamiast wciągać je do wydania. Ochrona ma też własne testy.</p>
<p>To jeszcze nie sprawia, że każdy zapis wydania jest wiarygodny sam z siebie. Zamyka jednak jedną konkretną drogę, którą niedokładny zapis wszedł do procesu.</p>
<p>Moja nauka z pracy z kilkoma agentami: trzeba ustalić, kto posiada zapis, nie tylko kto posiada zadanie. Pewna siebie wiadomość o zakończeniu jest tania. Proces wydania, który odmawia wchłonięcia niewyjaśnionych zmian, jest znacznie bardziej użyteczny.</p>
<p><em>Osobiste doświadczenie z rozwoju oprogramowania. To nie jest wskazówka kliniczna.</em></p>

HTML,
        ],
        'hu' => [
            'title' => 'Egy feladatnak lehet két gazdája. A kiadási naplónak egy.',
            'image_alt' => 'Sötét asztalon nyitott notesz fekszik. Balról és jobbról két áttetsző alak nyúl felé türkiz tollal; közöttük vékony ibolya vonal lebeg az oldal fölött.',
            'excerpt' => 'Október 27-én az Arenibusban ki kellett javítanom a telepítési történetet. Két ügynök is befejezte a saját feladatát, a kiadási napló mégis elromlott. A szkript azóta visszautasítja a váratlan változtatásokat, amelyeket különben belesöpörne.',
            'content' => <<<'HTML'
<p>2026. október 27-én ki kellett javítanom a telepítési történetet az Arenibusban, a nefrológiai és dialízis szoftveremben. Egy párhuzamos ügynök ugyanazt a kiadási munkafát szerkesztette. Az eredményül kapott naplóban szerepelt egy mutációs tesztre vonatkozó állítás, amely nem futott le, és egy hivatkozás egy osztályra, amely nem létezett.</p>
<p>A baj nem csak egy rossz mondat volt. A kiadási folyamat több szerzőnek engedte, hogy megváltoztassák annak bizonyítékát, ami történt.</p>
<p>Ezért védelmet adtam a kiadási szkripthez. A változtatások összegyűjtése előtt ellenőrzi a verzió- és státuszfájlok váratlan módosításait, beleértve a munkafában már rögzített változásokat is. Ha másik szerző beavatkozását találja, megáll, ahelyett hogy belesöpörné őket a kiadásba. A védelemnek saját tesztjei is vannak.</p>
<p>Ettől még nem lesz minden kiadási napló önmagában megbízható. Egy konkrét utat azonban bezár, amelyen pontatlan napló került a folyamatba.</p>
<p>A több ügynökkel végzett munka tanulsága: meg kell határozni, ki birtokolja a naplót, nem csak azt, ki birtokolja a feladatot. Egy magabiztos befejezési üzenet olcsó. Egy kiadási folyamat, amely visszautasítja a megmagyarázatlan változtatások befogadását, sokkal hasznosabb.</p>
<p><em>Személyes beszámoló a szoftverfejlesztésből. Nem klinikai útmutató.</em></p>

HTML,
        ],
        'it' => [
            'title' => 'Un compito può avere due padroni. Il registro di rilascio ne ha uno.',
            'image_alt' => 'Su una scrivania scura è aperto un taccuino. Da sinistra e da destra due figure traslucide vi tendono penne turchesi; tra loro una sottile linea violetta fluttua sopra la pagina.',
            'excerpt' => 'Il 27 ottobre ho dovuto correggere la cronologia di distribuzione in Arenibus. Due agenti avevano ciascuno finito il proprio compito e il registro di rilascio si era comunque rovinato. Lo script rifiuta da allora le modifiche inattese che altrimenti assorbirebbe.',
            'content' => <<<'HTML'
<p>Il 27 ottobre 2026 ho dovuto correggere la cronologia di distribuzione in Arenibus, il mio software di nefrologia e dialisi. Un agente concorrente aveva modificato lo stesso albero di lavoro del rilascio. Nel registro risultante c’era l’affermazione di un test di mutazione che non era stato eseguito e un riferimento a una classe che non esisteva.</p>
<p>Il problema non era soltanto una frase sbagliata. Il processo di rilascio permetteva a più autori di alterare la prova di ciò che era accaduto.</p>
<p>Perciò ho aggiunto una protezione allo script di rilascio. Prima di raccogliere le modifiche, controlla modifiche inattese ai file di versione e di stato, comprese quelle già registrate nell’albero di lavoro. Se trova l’intervento di un altro autore, si ferma invece di trascinarle nel rilascio. La protezione ha anche i propri test.</p>
<p>Così non diventa affidabile da solo ogni registro di rilascio. Si chiude però una via concreta attraverso cui un registro inesatto era entrato nel processo.</p>
<p>La lezione dal lavoro con più agenti: definire chi possiede il registro, non solo chi possiede il compito. Un messaggio sicuro di completamento costa poco. Un processo di rilascio che rifiuta di assorbire modifiche inspiegate è molto più utile.</p>
<p><em>Racconto personale dallo sviluppo software. Non è una guida clinica.</em></p>

HTML,
        ],
        'uk' => [
            'title' => 'Завдання може мати двох власників. Запис про випуск має одного.',
            'image_alt' => 'На темному столі лежить розгорнутий блокнот. Зліва і справа до нього тягнуться дві напівпрозорі фігури з бірюзовими перами; між ними над сторінкою висить тонка фіолетова лінія.',
            'excerpt' => 'Двадцять сьомого жовтня я мусив виправити історію розгортання в Arenibus. Два агенти завершили свої завдання, а запис про випуск усе одно зіпсувався. Відтоді скрипт відхиляє несподівані зміни, які інакше втягнув би в запис.',
            'content' => <<<'HTML'
<p>Двадцять сьомого жовтня 2026 року я мусив виправити історію розгортання в Arenibus, своєму програмному забезпеченні для нефрології та діалізу. Паралельний агент змінив те саме робоче дерево випуску. У підсумковому записі залишилось твердження про мутаційний тест, який не запускався, і посилання на клас, якого не існувало.</p>
<p>Проблема була не лише в поганому реченні. Процес випуску дозволяв кільком авторам змінювати доказ того, що сталося.</p>
<p>Тому я додав захист до скрипта випуску. Перед збором змін він перевіряє несподівані правки файлів версії та стану, включно зі змінами, уже записаними в робочому дереві. Якщо знаходить втручання іншого автора, зупиняється, замість того щоб втягнути їх у випуск. Захист має й власні тести.</p>
<p>Від цього ще не стає надійним сам по собі кожен запис про випуск. Проте закривається один конкретний шлях, яким неточний запис потрапив у процес.</p>
<p>Урок з роботи з кількома агентами: треба визначити, хто володіє записом, а не лише хто володіє завданням. Самовпевнене повідомлення про завершення дешеве. Процес випуску, який відмовляється вбирати незрозумілі зміни, набагато корисніший.</p>
<p><em>Особистий досвід з розробки програмного забезпечення. Це не клінічна настанова.</em></p>

HTML,
        ],
    ],
];
