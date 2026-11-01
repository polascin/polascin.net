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
 * Pred verdiktom over cieľ.
 * Arenibus v0.17.221, 27. októbra 2026, commit b2bd6c8c.
 * mutation-lib.sh: pred náhradou spočítať výskyty vzoru; nejednoznačné zlyhajú bez behu testov.
 * V tom istom commite pribudli vlastné testy tejto zábrany.
 */
return [
    'slug' => 'pred-verdiktom-over-ciel',
    'author' => 'MUDr. Ľubomír Polaščín',
    'category' => 'blog',
    'is_top' => 0,
    'published_at' => '2026-11-01 08:40:00',
    'image' => 'images/articles/pred-verdiktom-over-ciel.webp',
    'translations' => [
        'sk' => [
            'title' => 'Pred verdiktom over cieľ',
            'image_alt' => 'Dva priesvitné panely s riadkami kódu v fialovej tme. Tyrkysový lúč mieri na jeden panel a na mieste zásahu svieti terč.',
            'excerpt' => 'Mutačné testovanie môže zlyhať zo správneho dôvodu na zlom mieste. V Arenibus v0.17.221 som pred náhradou začal počítať výskyty vzoru. Nejednoznačná mutácia je zlyhanie, nie zelený verdikt.',
            'content' => <<<'HTML'
<p>Pri spevňovaní <a href="https://arenibus.polascin.net/">Arenibusu</a> som tento týždeň zmenil v sústave mutačného testovania drobnosť, ktorá váži viac, než znie.</p>
<p>Mutačné testovanie zámerne pokazí kód a potom skúša, či to testy spozorujú. Keď spozorujú, mutácia je zabitá.</p>
<p>Najprv však treba vedieť, čo ste naozaj pokazili.</p>
<p>Sústava hľadala miesto zmeny textovým vzorom. Keď sa ten istý úsek objavil v inej metóde, náhrada mohla zasiahnúť inde, než som chcel.</p>
<p>Zabitá mutácia potom vyzerala dobre, hoci netestovala zamýšľané správanie. Mutácia, ktorá prežila, mohla poslať pátranie do zlej metódy.</p>
<p>Pred náhradou preto spočítam výskyty vzoru v pôvodnom súbore. Jeden výskyt: pokračovať v ostatných kontrolách. Viaceré: označiť mutáciu za nejednoznačnú, započítať ju ako zlyhanie a testy nespúšťať. Najprv spraviť vzor tak konkrétny, aby ukazoval na jedno miesto. Pridal som aj vlastné testy tejto zábrany.</p>
<p>Zmena vyšla 27. októbra 2026 v Arenibus v0.17.221, commit b2bd6c8c, v súbore mutation-lib.sh.</p>
<p>Skôr než uveríte výsledku automatizovaného experimentu, overte, že experiment zmenil práve to, čo ste chceli zmeniť. Zelený verdikt nezachráni zle určený cieľ.</p>

HTML,
        ],
        'en' => [
            'title' => 'Verify the target before you trust the verdict',
            'image_alt' => 'Two translucent panels of code lines in purple dark. A teal beam aims at one panel, with a glowing target at the point of impact.',
            'excerpt' => 'A mutation test can fail for the right reason in the wrong place. In Arenibus v0.17.221 I started counting pattern matches before substitution. An ambiguous mutation is a failure, not a green verdict.',
            'content' => <<<'HTML'
<p>While hardening <a href="https://arenibus.polascin.net/">Arenibus</a> this week, I changed a small detail in the mutation-testing harness that weighs more than it sounds.</p>
<p>Mutation testing deliberately breaks code, then checks whether the tests notice. When they do, the mutation is killed.</p>
<p>First, though, you need to know what you actually broke.</p>
<p>The harness used a text pattern to find the place to change. If the same snippet appeared in another method, the substitution could hit the wrong location.</p>
<p>A killed mutation could then look reassuring without testing the intended behaviour. A surviving mutation could send the investigation into the wrong method.</p>
<p>So before the substitution I count how many times the pattern occurs in the original file. One match: continue with the remaining checks. Several: mark the mutation ambiguous, count it as a failure, and do not run the tests. Make the pattern specific enough to identify one location first. I added self-tests for that guard as well.</p>
<p>The change shipped on 27 October 2026 in Arenibus v0.17.221, commit b2bd6c8c, in mutation-lib.sh.</p>
<p>Before you trust the result of an automated experiment, verify that the experiment changed precisely what you meant to change. A green verdict cannot rescue a misidentified target.</p>

HTML,
        ],
        'cs' => [
            'title' => 'Před verdiktem ověř cíl',
            'image_alt' => 'Dva průsvitné panely s řádky kódu v fialové tmě. Tyrkysový paprsek míří na jeden panel a v místě zásahu svítí terč.',
            'excerpt' => 'Mutační testování může selhat ze správného důvodu na špatném místě. V Arenibus v0.17.221 jsem před náhradou začal počítat výskyty vzoru. Nejednoznačná mutace je selhání, ne zelený verdikt.',
            'content' => <<<'HTML'
<p>Při zpevňování <a href="https://arenibus.polascin.net/">Arenibusu</a> jsem tento týden změnil v soustavě mutačního testování drobnost, která váží víc, než zní.</p>
<p>Mutační testování záměrně pokazí kód a potom zkouší, jestli to testy zpozorují. Když zpozorují, mutace je zabitá.</p>
<p>Nejdřív ale musíte vědět, co jste opravdu pokazili.</p>
<p>Soustava hledala místo změny textovým vzorem. Když se tentýž úsek objevil v jiné metodě, náhrada mohla zasáhnout jinde, než jsem chtěl.</p>
<p>Zabitá mutace pak vypadala dobře, přestože netestovala zamýšlené chování. Mutace, která přežila, mohla poslat pátrání do špatné metody.</p>
<p>Před náhradou proto spočítám výskyty vzoru v původním souboru. Jeden výskyt: pokračovat v ostatních kontrolách. Více výskytů: označit mutaci za nejednoznačnou, započítat ji jako selhání a testy nespouštět. Nejdřív udělat vzor tak konkrétní, aby ukazoval na jedno místo. Přidal jsem i vlastní testy této zábrany.</p>
<p>Změna vyšla 27. října 2026 v Arenibus v0.17.221, commit b2bd6c8c, v souboru mutation-lib.sh.</p>
<p>Dřív než uvěříte výsledku automatizovaného experimentu, ověřte, že experiment změnil právě to, co jste chtěli změnit. Zelený verdikt nezachrání špatně určený cíl.</p>

HTML,
        ],
        'de' => [
            'title' => 'Prüfe das Ziel, bevor du dem Urteil vertraust',
            'image_alt' => 'Zwei durchscheinende Tafeln mit Codezeilen im violetten Dunkel. Ein türkiser Strahl zielt auf eine Tafel; am Auftreffpunkt leuchtet eine Zielscheibe.',
            'excerpt' => 'Ein Mutationstest kann aus dem richtigen Grund am falschen Ort scheitern. In Arenibus v0.17.221 zähle ich vor der Ersetzung die Treffer des Musters. Eine mehrdeutige Mutation ist ein Fehler, kein grünes Urteil.',
            'content' => <<<'HTML'
<p>Beim Härten von <a href="https://arenibus.polascin.net/">Arenibus</a> habe ich diese Woche in der Mutations-Testumgebung eine Kleinigkeit geändert, die mehr wiegt, als sie klingt.</p>
<p>Mutationstests verderben absichtlich Code und prüfen dann, ob die Tests es bemerken. Wenn sie es bemerken, ist die Mutation getötet.</p>
<p>Zuerst muss man aber wissen, was man wirklich verdorben hat.</p>
<p>Die Umgebung suchte den Änderungsort über ein Textmuster. Tauchte dieselbe Stelle in einer anderen Methode auf, konnte die Ersetzung woanders treffen, als ich wollte.</p>
<p>Eine getötete Mutation wirkte dann beruhigend, ohne das beabsichtigte Verhalten zu prüfen. Eine überlebende Mutation konnte die Suche in die falsche Methode schicken.</p>
<p>Vor der Ersetzung zähle ich deshalb, wie oft das Muster in der Originaldatei vorkommt. Ein Treffer: mit den übrigen Prüfungen fortfahren. Mehrere: die Mutation als mehrdeutig markieren, als Fehler werten und die Tests nicht starten. Zuerst das Muster so genau machen, dass es auf einen Ort zeigt. Ich habe auch eigene Tests für diese Sperre hinzugefügt.</p>
<p>Die Änderung erschien am 27. Oktober 2026 in Arenibus v0.17.221, Commit b2bd6c8c, in mutation-lib.sh.</p>
<p>Bevor Sie dem Ergebnis eines automatisierten Experiments vertrauen, prüfen Sie, dass das Experiment das geändert hat, was Sie ändern wollten. Ein grünes Urteil rettet kein falsch bestimmtes Ziel.</p>

HTML,
        ],
        'fr' => [
            'title' => 'Vérifiez la cible avant de croire le verdict',
            'image_alt' => 'Deux panneaux translucides de lignes de code dans le violet sombre. Un rayon turquoise vise un panneau; une cible brille au point d’impact.',
            'excerpt' => 'Un test de mutation peut échouer pour la bonne raison au mauvais endroit. Dans Arenibus v0.17.221 je compte les occurrences du motif avant la substitution. Une mutation ambiguë est un échec, pas un verdict vert.',
            'content' => <<<'HTML'
<p>En consolidant <a href="https://arenibus.polascin.net/">Arenibus</a> cette semaine, j’ai changé dans le harnais de tests de mutation un détail qui pèse plus qu’il n’en a l’air.</p>
<p>Les tests de mutation cassent volontairement le code, puis vérifient si les tests s’en aperçoivent. Quand ils s’en aperçoivent, la mutation est tuée.</p>
<p>Il faut d’abord savoir ce que l’on a vraiment cassé.</p>
<p>Le harnais cherchait l’endroit à modifier par un motif textuel. Si le même fragment apparaissait dans une autre méthode, la substitution pouvait frapper ailleurs que prévu.</p>
<p>Une mutation tuée pouvait alors paraître rassurante sans tester le comportement voulu. Une mutation survivante pouvait envoyer l’enquête dans la mauvaise méthode.</p>
<p>Avant la substitution, je compte donc les occurrences du motif dans le fichier d’origine. Une seule: poursuivre les autres contrôles. Plusieurs: marquer la mutation comme ambiguë, la compter comme un échec et ne pas lancer les tests. D’abord rendre le motif assez précis pour désigner un seul endroit. J’ai aussi ajouté des tests pour cette garde.</p>
<p>Le changement est sorti le 27 octobre 2026 dans Arenibus v0.17.221, commit b2bd6c8c, dans mutation-lib.sh.</p>
<p>Avant de croire le résultat d’une expérience automatisée, vérifiez que l’expérience a changé ce que vous vouliez changer. Un verdict vert ne sauve pas une cible mal identifiée.</p>

HTML,
        ],
        'es' => [
            'title' => 'Verifica el objetivo antes de fiarte del veredicto',
            'image_alt' => 'Dos paneles translúcidos con líneas de código en la oscuridad violeta. Un rayo turquesa apunta a un panel y en el impacto brilla una diana.',
            'excerpt' => 'Una prueba de mutación puede fallar por la razón correcta en el lugar equivocado. En Arenibus v0.17.221 empecé a contar las coincidencias del patrón antes de sustituir. Una mutación ambigua es un fallo, no un veredicto verde.',
            'content' => <<<'HTML'
<p>Al endurecer <a href="https://arenibus.polascin.net/">Arenibus</a> esta semana, cambié en el arnés de pruebas de mutación un detalle que pesa más de lo que parece.</p>
<p>Las pruebas de mutación rompen el código a propósito y luego comprueban si las pruebas lo notan. Cuando lo notan, la mutación queda eliminada.</p>
<p>Antes hay que saber qué se ha roto de verdad.</p>
<p>El arnés buscaba el lugar del cambio con un patrón de texto. Si el mismo fragmento aparecía en otro método, la sustitución podía golpear donde no quería.</p>
<p>Una mutación eliminada podía entonces parecer tranquilizadora sin probar el comportamiento previsto. Una mutación superviviente podía mandar la investigación al método equivocado.</p>
<p>Por eso, antes de sustituir, cuento cuántas veces aparece el patrón en el archivo original. Una coincidencia: seguir con el resto de comprobaciones. Varias: marcar la mutación como ambigua, contarla como fallo y no ejecutar las pruebas. Primero hacer el patrón lo bastante concreto para señalar un solo lugar. También añadí pruebas propias de esa guarda.</p>
<p>El cambio salió el 27 de octubre de 2026 en Arenibus v0.17.221, commit b2bd6c8c, en mutation-lib.sh.</p>
<p>Antes de fiarte del resultado de un experimento automatizado, verifica que el experimento cambió lo que querías cambiar. Un veredicto verde no salva un objetivo mal identificado.</p>

HTML,
        ],
        'pl' => [
            'title' => 'Zanim zaufasz werdyktowi, sprawdź cel',
            'image_alt' => 'Dwa półprzezroczyste panele z wierszami kodu w fioletowej ciemności. Turkusowy promień celuje w jeden panel, a w miejscu trafienia świeci tarcza.',
            'excerpt' => 'Test mutacyjny może zawieść z właściwego powodu w złym miejscu. W Arenibus v0.17.221 przed podstawieniem zacząłem liczyć wystąpienia wzorca. Niejednoznaczna mutacja to porażka, nie zielony werdykt.',
            'content' => <<<'HTML'
<p>Przy wzmacnianiu <a href="https://arenibus.polascin.net/">Arenibusu</a> zmieniłem w tym tygodniu w układzie testów mutacyjnych drobiazg, który waży więcej, niż brzmi.</p>
<p>Testowanie mutacyjne celowo psuje kod, a potem sprawdza, czy testy to zauważą. Gdy zauważą, mutacja jest zabita.</p>
<p>Najpierw jednak trzeba wiedzieć, co naprawdę popsuto.</p>
<p>Układ szukał miejsca zmiany wzorcem tekstowym. Gdy ten sam fragment pojawiał się w innej metodzie, podstawienie mogło trafić gdzie indziej, niż chciałem.</p>
<p>Zabita mutacja wyglądała wtedy dobrze, choć nie testowała zamierzonego zachowania. Mutacja, która przeżyła, mogła skierować dochodzenie do złej metody.</p>
<p>Przed podstawieniem zliczam więc wystąpienia wzorca w oryginalnym pliku. Jedno: kontynuować pozostałe kontrole. Kilka: oznaczyć mutację jako niejednoznaczną, policzyć jako porażkę i nie uruchamiać testów. Najpierw uczynić wzorzec na tyle konkretnym, by wskazywał jedno miejsce. Dodałem też własne testy tej zapory.</p>
<p>Zmiana wyszła 27 października 2026 w Arenibus v0.17.221, commit b2bd6c8c, w pliku mutation-lib.sh.</p>
<p>Zanim zaufasz wynikowi zautomatyzowanego eksperymentu, sprawdź, że eksperyment zmienił to, co chciałeś zmienić. Zielony werdykt nie uratuje źle wskazanego celu.</p>

HTML,
        ],
        'hu' => [
            'title' => 'A verdikt előtt ellenőrizd a célt',
            'image_alt' => 'Két áttetsző panel kódsorokkal a lilás sötétben. Egy türkiz sugár az egyik panelre céloz, a becsapódásnál célkereszt világít.',
            'excerpt' => 'A mutációs teszt a helyes okból is elbukhat a rossz helyen. Az Arenibus v0.17.221-ben a helyettesítés előtt elkezdtem számolni a minta előfordulásait. A többértelmű mutáció kudarc, nem zöld verdikt.',
            'content' => <<<'HTML'
<p>Az <a href="https://arenibus.polascin.net/">Arenibus</a> erősítése közben ezen a héten a mutációs tesztkörnyezetben olyan apróságot változtattam, amely többet nyom, mint amilyennek hangzik.</p>
<p>A mutációs tesztelés szándékosan elrontja a kódot, majd megnézi, észreveszik-e a tesztek. Ha igen, a mutáció meghalt.</p>
<p>Előbb azonban tudni kell, mit rontottunk el valójában.</p>
<p>A környezet szöveges mintával kereste a változtatás helyét. Ha ugyanaz a részlet másik metódusban is megjelent, a helyettesítés máshová találhatott, mint akartam.</p>
<p>A megölt mutáció aztán jónak látszott, bár nem a szándékolt viselkedést tesztelte. A túlélő mutáció rossz metódusba küldhette a nyomozást.</p>
<p>A helyettesítés előtt ezért megszámolom a minta előfordulásait az eredeti fájlban. Egy találat: folytatni a többi ellenőrzést. Több: a mutációt többértelműnek jelölni, kudarcnak számítani, és a teszteket nem futtatni. Előbb a mintát elég konkrétá tenni, hogy egy helyet mutasson. Ehhez a gáthoz saját teszteket is adtam.</p>
<p>A változás 2026. október 27-én jelent meg az Arenibus v0.17.221-ben, a b2bd6c8c commitban, a mutation-lib.sh fájlban.</p>
<p>Mielőtt az automatizált kísérlet eredményének hinnél, ellenőrizd, hogy a kísérlet azt változtatta meg, amit meg akartál változtatni. A zöld verdikt nem menti meg a rosszul azonosított célt.</p>

HTML,
        ],
        'it' => [
            'title' => 'Verifica il bersaglio prima di fidarti del verdetto',
            'image_alt' => 'Due pannelli traslucidi con righe di codice nel buio viola. Un raggio turchese punta a un pannello e al punto d’impatto brilla un bersaglio.',
            'excerpt' => 'Un test di mutazione può fallire per la ragione giusta nel posto sbagliato. In Arenibus v0.17.221 ho iniziato a contare le occorrenze del pattern prima della sostituzione. Una mutazione ambigua è un fallimento, non un verdetto verde.',
            'content' => <<<'HTML'
<p>Nel rafforzare <a href="https://arenibus.polascin.net/">Arenibus</a> questa settimana ho cambiato nell’impianto dei test di mutazione un dettaglio che pesa più di quanto sembri.</p>
<p>I test di mutazione rompono deliberatamente il codice, poi controllano se i test se ne accorgono. Quando se ne accorgono, la mutazione è uccisa.</p>
<p>Prima però bisogna sapere che cosa si è davvero rotto.</p>
<p>L’impianto cercava il punto da cambiare con un pattern di testo. Se lo stesso frammento compariva in un altro metodo, la sostituzione poteva colpire altrove da dove volevo.</p>
<p>Una mutazione uccisa poteva allora sembrare rassicurante senza verificare il comportamento previsto. Una mutazione sopravvissuta poteva mandare l’indagine nel metodo sbagliato.</p>
<p>Prima della sostituzione conto quindi quante volte il pattern compare nel file originale. Una sola: proseguire con gli altri controlli. Più di una: segnare la mutazione come ambigua, contarla come fallimento e non eseguire i test. Prima rendere il pattern abbastanza specifico da indicare un solo punto. Ho aggiunto anche test propri per questa protezione.</p>
<p>La modifica è uscita il 27 ottobre 2026 in Arenibus v0.17.221, commit b2bd6c8c, in mutation-lib.sh.</p>
<p>Prima di fidarti del risultato di un esperimento automatizzato, verifica che l’esperimento abbia cambiato ciò che volevi cambiare. Un verdetto verde non salva un bersaglio mal identificato.</p>

HTML,
        ],
        'uk' => [
            'title' => 'Перш ніж вірити вердикту, перевір ціль',
            'image_alt' => 'Дві напівпрозорі панелі з рядками коду в фіолетовій темряві. Бірюзовий промінь цілить в одну панель, а в місці влучання світить мішень.',
            'excerpt' => 'Мутаційний тест може провалитися з правильної причини в неправильному місці. В Arenibus v0.17.221 перед заміною я почав рахувати входження зразка. Неоднозначна мутація: це провал, не зелений вердикт.',
            'content' => <<<'HTML'
<p>Під час зміцнення <a href="https://arenibus.polascin.net/">Arenibus</a> цього тижня я змінив у системі мутаційного тестування дрібницю, яка важить більше, ніж звучить.</p>
<p>Мутаційне тестування навмисно псує код, а потім перевіряє, чи тести це помітять. Коли помітять, мутацію вбито.</p>
<p>Спочатку, однак, треба знати, що ви справді зіпсували.</p>
<p>Система шукала місце зміни текстовим зразком. Коли той самий фрагмент з’являвся в іншому методі, заміна могла влучити не туди, куди я хотів.</p>
<p>Убита мутація тоді виглядала добре, хоча не перевіряла задуману поведінку. Мутація, що вижила, могла спрямувати розслідування в неправильний метод.</p>
<p>Тому перед заміною я рахую входження зразка в початковому файлі. Одне: продовжувати інші перевірки. Кілька: позначити мутацію як неоднозначну, зарахувати як провал і не запускати тести. Спочатку зробити зразок досить конкретним, щоб вказував на одне місце. Я також додав власні тести цієї огорожі.</p>
<p>Зміна вийшла 27 жовтня 2026 в Arenibus v0.17.221, commit b2bd6c8c, у файлі mutation-lib.sh.</p>
<p>Перш ніж вірити результату автоматизованого експерименту, перевірте, що експеримент змінив те, що ви хотіли змінити. Зелений вердикт не врятує неправильно визначену ціль.</p>

HTML,
        ],
    ],
];
