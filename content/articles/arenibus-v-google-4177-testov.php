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
 * Authority / milestone: Arenibus indexed by Google; verified test suite at v0.17.162.
 * Sources: Arenibus docs/STATUS.md (test counts per release), AUDIT-REPORT.md (22. 9. 2026),
 * Google Alert polascin.net 20. 9. 2026 (author), live https://arenibus.polascin.net/
 * Note: draft “6 166” was rejected: does not appear in STATUS/AUDIT and 1365+709+1510 ≠ 6166.
 * Used v0.17.162 close: 1772 unit + 754 integration + 1651 frontend = 4177.
 * Span v0.17.143…v0.17.162 inclusive = 20 releases (not 19).
 */
return [
    'slug' => 'arenibus-v-google-4177-testov',
    'author' => 'MUDr. Ľubomír Polaščín',
    'category' => 'blog',
    'is_top' => 0,
    'published_at' => '2026-09-24 17:40:00',
    'image' => 'images/articles/arenibus-v-google-4177-testov.webp',
    'translations' => [
        'sk' => [
            'title' => 'Môj nefrologický softvér sa tento týždeň objavil vo výsledkoch Google. Cesta k tomu mala 4 177 zelených testov.',
            'image_alt' => 'Lekár-vývojár pri tichom stole: na monitore žiari dialyzačný softvér, za ním stena zelených testovacích svetiel a hľadáčikový lúč svetla, ktorý produkt nachádza.',
            'excerpt' => 'Google indexoval arenibus.polascin.net. Od v0.17.143 po v0.17.162 som za päť dní vydal dvadsať verzií: 1 772 jednotkových, 754 integračných a 1 651 testov rozhrania, všetky zelené. Šablónový kód píše umelá inteligencia; o klinickej logike rozhodujem ja.',
            'content' => <<<'HTML'
<p><a href="https://arenibus.polascin.net/">Arenibus</a> začal ako informačný systém v .NET na správu dialýzy. Jeden vývojár. Jeden lekár. Bez tímu.</p>
<p>Tento týždeň Google indexoval arenibus.polascin.net. Google Alert na „polascin.net“ to potvrdil 20.&nbsp;9.&nbsp;2026. Po prvý raz je produkt vo výsledkoch, keď niekto hľadá nefrologický softvér po slovensky.</p>
<p>Čísla pri vydaní <strong>v0.17.162</strong> (22.&nbsp;9.&nbsp;2026), zapísané v stave produktu:</p>
<ul>
<li>1&nbsp;772 jednotkových testov</li>
<li>754 integračných testov</li>
<li>1&nbsp;651 testov rozhrania</li>
<li><strong>4&nbsp;177 spolu</strong>, všetky zelené</li>
</ul>
<p>Od 17.&nbsp;do 22.&nbsp;septembra 2026 som vydal verzie od <strong>v0.17.143</strong> po <strong>v0.17.162</strong>: dvadsať vydaní. Obmedzenia predpisovania pre správcu. Kontroly proti rozširovaniu rolí. Porovnanie ceny s cenníkom. Opravy laboratórnej matice. Pravidlá prevádzky som rozhodoval po slovensky medzi konzultáciami s pacientmi.</p>
<p>Zoznam zmien to nepovie. Každé z tých vydaní najprv prešlo auditom s pomocou umelej inteligencie. Tá píše šablónový kód. Ja prečítam každý riadok a rozhodnem o klinickej logike. Tá delba práce je celý produkt.</p>
<p>Stavať klinický softvér sám kedysi znamenalo voliť medzi rýchlosťou a bezpečnosťou. Keď umelá inteligencia preberie opakujúcu sa prácu, testy, záplaty a bezpečnostné kontroly, tá voľba sa zužuje.</p>
<p>Produkt je nájditeľný. Testovacia sada je dôvod, prečo ho možno nájsť bez obavy.</p>
<p>Ak staviate niečo podobné sami, čo by ste umelej inteligencii odovzdali ako prvé?</p>
HTML,
        ],
        'en' => [
            'title' => 'My nephrology software showed up in Google search results this week. Getting there took 4,177 green tests.',
            'image_alt' => 'A physician-developer at a quiet desk: dialysis software glowing on a monitor, a wall of green test lights behind him, a search beam finding the product.',
            'excerpt' => 'Google indexed arenibus.polascin.net. From v0.17.143 to v0.17.162 I shipped twenty releases in five days: 1,772 unit, 754 integration and 1,651 frontend tests, all green. Artificial intelligence writes the boilerplate; I decide the clinical logic.',
            'content' => <<<'HTML'
<p><a href="https://arenibus.polascin.net/">Arenibus</a> started as a .NET information system for dialysis management. One developer. One physician. No team.</p>
<p>This week Google indexed arenibus.polascin.net. A Google Alert for “polascin.net” confirmed it on 20&nbsp;September&nbsp;2026. For the first time, when someone searches for nephrology software in Slovak, the product is there in the results.</p>
<p>The numbers at release <strong>v0.17.162</strong> (22&nbsp;September&nbsp;2026), recorded in the product status:</p>
<ul>
<li>1,772 unit tests</li>
<li>754 integration tests</li>
<li>1,651 frontend tests</li>
<li><strong>4,177 total</strong>, all green</li>
</ul>
<p>From 17&nbsp;to 22&nbsp;September&nbsp;2026 I shipped from <strong>v0.17.143</strong> to <strong>v0.17.162</strong>: twenty releases. Prescribing limits for the administrator. Checks that stop roles from being widened. Comparison with the price list. Fixes to the laboratory matrix. I decided the operating rules in Slovak between patient consultations.</p>
<p>The changelog does not say this. Every one of those releases first went through an audit with the help of artificial intelligence. It writes the boilerplate. I read every line and decide the clinical logic. That division of work is the whole product.</p>
<p>Building clinical software alone used to mean choosing between speed and safety. When artificial intelligence takes the repetitive work, tests, patches and security scans, that choice narrows.</p>
<p>The product can be found. The test suite is why it can be found without worry.</p>
<p>If you are building something similar alone, what would you hand to artificial intelligence first?</p>
HTML,
        ],
        'cs' => [
            'title' => 'Můj nefrologický software se tento týden objevil ve výsledcích Google. Cesta k tomu měla 4 177 zelených testů.',
            'image_alt' => 'Lékař-vývojář u tichého stolu: na monitoru září dialyzační software, za ním stěna zelených testovacích světel a hledáčkový paprsek světla, který produkt nachází.',
            'excerpt' => 'Google indexoval arenibus.polascin.net. Od v0.17.143 po v0.17.162 jsem za pět dní vydal dvacet verzí: 1 772 jednotkových, 754 integračních a 1 651 testů rozhraní, všechny zelené. Šablonový kód píše umělá inteligence; o klinické logice rozhoduji já.',
            'content' => <<<'HTML'
<p><a href="https://arenibus.polascin.net/">Arenibus</a> začal jako informační systém v .NET pro správu dialýzy. Jeden vývojář. Jeden lékař. Bez týmu.</p>
<p>Tento týden Google indexoval arenibus.polascin.net. Google Alert na „polascin.net“ to potvrdil 20.&nbsp;9.&nbsp;2026. Poprvé je produkt ve výsledcích, když někdo hledá nefrologický software slovensky.</p>
<p>Čísla při vydání <strong>v0.17.162</strong> (22.&nbsp;9.&nbsp;2026), zapsaná ve stavu produktu:</p>
<ul>
<li>1&nbsp;772 jednotkových testů</li>
<li>754 integračních testů</li>
<li>1&nbsp;651 testů rozhraní</li>
<li><strong>4&nbsp;177 dohromady</strong>, všechny zelené</li>
</ul>
<p>Od 17.&nbsp;do 22.&nbsp;září 2026 jsem vydal verze od <strong>v0.17.143</strong> po <strong>v0.17.162</strong>: dvacet vydání. Omezení předepisování pro správce. Kontroly proti rozšiřování rolí. Porovnání ceny s ceníkem. Opravy laboratorní matice. Pravidla provozu jsem rozhodoval slovensky mezi konzultacemi s pacienty.</p>
<p>Seznam změn to neřekne. Každé z těch vydání nejprve prošlo auditem s pomocí umělé inteligence. Ta píše šablonový kód. Já přečtu každý řádek a rozhodnu o klinické logice. Ta dělba práce je celý produkt.</p>
<p>Stavět klinický software sám kdysi znamenalo volit mezi rychlostí a bezpečností. Když umělá inteligence převezme opakující se práci, testy, záplaty a bezpečnostní kontroly, ta volba se zužuje.</p>
<p>Produkt je dohledatelný. Testovací sada je důvod, proč ho lze najít bez obavy.</p>
<p>Pokud stavíte něco podobného sami, co byste umělé inteligenci předali jako první?</p>
HTML,
        ],
        'de' => [
            'title' => 'Meine Nephrologie-Software tauchte diese Woche in den Google-Suchergebnissen auf. Der Weg dorthin umfasste 4.177 grüne Tests.',
            'image_alt' => 'Arzt-Entwickler an einem ruhigen Schreibtisch: Dialysesoftware leuchtet auf dem Monitor, dahinter eine Wand grüner Testlichter, ein Suchstrahl findet das Produkt.',
            'excerpt' => 'Google hat arenibus.polascin.net indexiert. Von v0.17.143 bis v0.17.162 lieferte ich in fünf Tagen zwanzig Releases: 1.772 Modul-, 754 Integrations- und 1.651 Oberflächentests, alle grün. Künstliche Intelligenz schreibt den vorgefertigten Code; die klinische Logik entscheide ich.',
            'content' => <<<'HTML'
<p><a href="https://arenibus.polascin.net/">Arenibus</a> begann als .NET-Informationssystem für die Verwaltung der Dialyse. Ein Entwickler. Ein Arzt. Kein Team.</p>
<p>Diese Woche hat Google arenibus.polascin.net indexiert. Ein Google Alert für „polascin.net“ bestätigte das am 20.&nbsp;9.&nbsp;2026. Zum ersten Mal steht das Produkt in den Ergebnissen, wenn man auf Slowakisch nach Nephrologie-Software sucht.</p>
<p>Die Zahlen beim Release <strong>v0.17.162</strong> (22.&nbsp;9.&nbsp;2026), festgehalten im Zustand des Produkts:</p>
<ul>
<li>1.772 Modultests</li>
<li>754 Integrationstests</li>
<li>1.651 Oberflächentests</li>
<li><strong>4.177 insgesamt</strong>, alle grün</li>
</ul>
<p>Vom 17.&nbsp;bis 22.&nbsp;September 2026 lieferte ich von <strong>v0.17.143</strong> bis <strong>v0.17.162</strong>: zwanzig Releases. Verschreibungsgrenzen für den Administrator. Prüfungen, die eine Ausweitung der Rollen stoppen. Vergleich mit der Preisliste. Korrekturen der Labormatrix. Die Betriebsregeln entschied ich auf Slowakisch zwischen den Konsultationen.</p>
<p>Das Änderungsprotokoll sagt das nicht. Jedes dieser Releases ging zuerst durch ein Audit mit Hilfe künstlicher Intelligenz. Sie schreibt den vorgefertigten Code. Ich lese jede Zeile und entscheide die klinische Logik. Diese Teilung der Arbeit ist das ganze Produkt.</p>
<p>Klinische Software allein zu bauen hieß früher, zwischen Geschwindigkeit und Sicherheit zu wählen. Wenn künstliche Intelligenz die wiederkehrende Arbeit übernimmt, Tests, Patches und Sicherheitsprüfungen, verengt sich diese Wahl.</p>
<p>Das Produkt ist auffindbar. Die Testsuite ist der Grund, warum man es ohne Sorge finden kann.</p>
<p>Wenn Sie etwas Ähnliches allein bauen, was würden Sie der künstlichen Intelligenz zuerst übergeben?</p>
HTML,
        ],
        'fr' => [
            'title' => 'Mon logiciel de néphrologie est apparu cette semaine dans les résultats Google. Le chemin a compté 4 177 tests verts.',
            'image_alt' => 'Un médecin-développeur à un bureau calme : logiciel de dialyse lumineux sur l’écran, mur de voyants de tests verts derrière lui, faisceau de recherche qui trouve le produit.',
            'excerpt' => 'Google a indexé arenibus.polascin.net. De v0.17.143 à v0.17.162 j’ai livré vingt versions en cinq jours : 1 772 tests unitaires, 754 d’intégration et 1 651 d’interface, tous verts. L’intelligence artificielle écrit le code répétitif ; je décide la logique clinique.',
            'content' => <<<'HTML'
<p><a href="https://arenibus.polascin.net/">Arenibus</a> a commencé comme système d’information .NET pour la gestion de la dialyse. Un développeur. Un médecin. Pas d’équipe.</p>
<p>Cette semaine, Google a indexé arenibus.polascin.net. Une alerte Google sur «&nbsp;polascin.net&nbsp;» l’a confirmé le 20&nbsp;septembre&nbsp;2026. Pour la première fois, le produit est dans les résultats quand on cherche un logiciel de néphrologie en slovaque.</p>
<p>Les chiffres à la version <strong>v0.17.162</strong> (22&nbsp;septembre&nbsp;2026), consignés dans l’état du produit&nbsp;:</p>
<ul>
<li>1&nbsp;772 tests unitaires</li>
<li>754 tests d’intégration</li>
<li>1&nbsp;651 tests d’interface</li>
<li><strong>4&nbsp;177 au total</strong>, tous verts</li>
</ul>
<p>Du 17&nbsp;au 22&nbsp;septembre&nbsp;2026, j’ai livré de <strong>v0.17.143</strong> à <strong>v0.17.162</strong>&nbsp;: vingt versions. Limites de prescription pour l’administrateur. Contrôles qui empêchent d’élargir les rôles. Comparaison avec le tarif. Corrections de la matrice de laboratoire. Les règles de fonctionnement, je les ai décidées en slovaque entre les consultations.</p>
<p>Le journal des modifications ne le dit pas. Chacune de ces versions est d’abord passée par un audit aidé par l’intelligence artificielle. Elle écrit le code répétitif. Je relis chaque ligne et je décide la logique clinique. Cette division du travail, c’est tout le produit.</p>
<p>Construire un logiciel clinique seul, c’était autrefois choisir entre vitesse et sécurité. Quand l’intelligence artificielle prend le travail répétitif, tests, correctifs et contrôles de sécurité, ce choix se resserre.</p>
<p>Le produit se trouve. La suite de tests est la raison pour laquelle on peut le trouver sans inquiétude.</p>
<p>Si vous construisez quelque chose de semblable seul, que confieriez-vous d’abord à l’intelligence artificielle&nbsp;?</p>
HTML,
        ],
        'es' => [
            'title' => 'Mi software de nefrología apareció esta semana en los resultados de Google. El camino tuvo 4.177 tests en verde.',
            'image_alt' => 'Un médico-desarrollador en un escritorio tranquilo: software de diálisis brillando en el monitor, una pared de luces verdes de tests detrás, un haz de búsqueda que encuentra el producto.',
            'excerpt' => 'Google indexó arenibus.polascin.net. De v0.17.143 a v0.17.162 publiqué veinte versiones en cinco días: 1.772 unitarios, 754 de integración y 1.651 de interfaz, todos verdes. La inteligencia artificial escribe el código repetitivo; yo decido la lógica clínica.',
            'content' => <<<'HTML'
<p><a href="https://arenibus.polascin.net/">Arenibus</a> empezó como un sistema de información .NET para la gestión de diálisis. Un desarrollador. Un médico. Sin equipo.</p>
<p>Esta semana Google indexó arenibus.polascin.net. Una alerta de Google sobre «polascin.net» lo confirmó el 20&nbsp;de septiembre&nbsp;de&nbsp;2026. Por primera vez el producto está en los resultados cuando alguien busca software de nefrología en eslovaco.</p>
<p>Los números en la versión <strong>v0.17.162</strong> (22&nbsp;de septiembre&nbsp;de&nbsp;2026), registrados en el estado del producto:</p>
<ul>
<li>1.772 tests unitarios</li>
<li>754 tests de integración</li>
<li>1.651 tests de interfaz</li>
<li><strong>4.177 en total</strong>, todos verdes</li>
</ul>
<p>Del 17&nbsp;al 22&nbsp;de septiembre&nbsp;de&nbsp;2026 publiqué de <strong>v0.17.143</strong> a <strong>v0.17.162</strong>: veinte versiones. Límites de prescripción para el administrador. Controles que impiden ampliar los roles. Comparación con la lista de precios. Correcciones de la matriz de laboratorio. Las reglas de funcionamiento las decidí en eslovaco entre consultas con pacientes.</p>
<p>El registro de cambios no lo dice. Cada una de esas versiones pasó primero por una auditoría con ayuda de la inteligencia artificial. Ella escribe el código repetitivo. Yo leo cada línea y decido la lógica clínica. Esa división del trabajo es todo el producto.</p>
<p>Construir software clínico en solitario antes significaba elegir entre velocidad y seguridad. Cuando la inteligencia artificial asume el trabajo repetitivo, tests, parches y revisiones de seguridad, esa elección se estrecha.</p>
<p>El producto se puede encontrar. La suite de tests es la razón por la que se puede encontrar sin inquietud.</p>
<p>Si construyes algo similar solo, ¿qué le entregarías primero a la inteligencia artificial?</p>
HTML,
        ],
        'pl' => [
            'title' => 'Mój soft nefrologiczny pojawił się w tym tygodniu w wynikach Google. Droga do tego miała 4 177 zielonych testów.',
            'image_alt' => 'Lekarz-programista przy spokojnym biurku: oprogramowanie dializacyjne świeci na monitorze, za nim ściana zielonych świateł testów, wiązka wyszukiwania odnajduje produkt.',
            'excerpt' => 'Google zindeksował arenibus.polascin.net. Od v0.17.143 do v0.17.162 w pięć dni wydałem dwadzieścia wersji: 1 772 jednostkowych, 754 integracyjnych i 1 651 interfejsu, wszystkie zielone. Sztuczna inteligencja pisze kod szablonowy; o logice klinicznej decyduję ja.',
            'content' => <<<'HTML'
<p><a href="https://arenibus.polascin.net/">Arenibus</a> zaczął jako system informacyjny .NET do zarządzania dializą. Jeden programista. Jeden lekarz. Bez zespołu.</p>
<p>W tym tygodniu Google zindeksował arenibus.polascin.net. Alert Google na „polascin.net” potwierdził to 20&nbsp;września&nbsp;2026. Po raz pierwszy produkt jest w wynikach, gdy ktoś szuka oprogramowania nefrologicznego po słowacku.</p>
<p>Liczby przy wydaniu <strong>v0.17.162</strong> (22&nbsp;września&nbsp;2026), zapisane w stanie produktu:</p>
<ul>
<li>1&nbsp;772 testów jednostkowych</li>
<li>754 testów integracyjnych</li>
<li>1&nbsp;651 testów interfejsu</li>
<li><strong>4&nbsp;177 łącznie</strong>, wszystkie zielone</li>
</ul>
<p>Od 17&nbsp;do 22&nbsp;września&nbsp;2026 wydałem wersje od <strong>v0.17.143</strong> do <strong>v0.17.162</strong>: dwadzieścia wydań. Ograniczenia przepisywania dla administratora. Kontrole przeciw rozszerzaniu ról. Porównanie ceny z cennikiem. Poprawki macierzy laboratoryjnej. Reguły działania decydowałem po słowacku między konsultacjami z pacjentami.</p>
<p>Lista zmian tego nie powie. Każde z tych wydań najpierw przeszło audyt z pomocą sztucznej inteligencji. Ona pisze kod szablonowy. Ja czytam każdą linię i decyduję o logice klinicznej. Ten podział pracy to cały produkt.</p>
<p>Budowanie klinicznego oprogramowania w pojedynkę kiedyś oznaczało wybór między szybkością a bezpieczeństwem. Gdy sztuczna inteligencja bierze powtarzalną pracę, testy, łatki i kontrole bezpieczeństwa, ten wybór się zawęża.</p>
<p>Produkt daje się znaleźć. Zestaw testów jest powodem, dla którego można go znaleźć bez obawy.</p>
<p>Jeśli budujecie coś podobnego sami, co oddalibyście sztucznej inteligencji jako pierwsze?</p>
HTML,
        ],
        'hu' => [
            'title' => 'A nefrológiai szoftverem ezen a héten megjelent a Google találatok között. Az odáig vezető út 4 177 zöld teszt volt.',
            'image_alt' => 'Orvos-fejlesztő csendes asztalnál: dialízis-szoftver világít a monitoron, mögötte zöld tesztlámpák fala, kereső fénysugár találja meg a terméket.',
            'excerpt' => 'A Google indexelte az arenibus.polascin.net oldalt. A v0.17.143-tól a v0.17.162-ig öt nap alatt húsz kiadást adtam ki: 1 772 egységteszt, 754 integrációs és 1 651 felületi teszt, mind zöld. A sablonkódot a mesterséges intelligencia írja; a klinikai logikát én döntöm el.',
            'content' => <<<'HTML'
<p>Az <a href="https://arenibus.polascin.net/">Arenibus</a> .NET információs rendszerként indult dialíziskezelésre. Egy fejlesztő. Egy orvos. Csapat nélkül.</p>
<p>Ezen a héten a Google indexelte az arenibus.polascin.net oldalt. A „polascin.net” Google Alert 2026.&nbsp;szeptember&nbsp;20-án igazolta. Először van a termék a találatok között, ha valaki szlovákul keres nefrológiai szoftvert.</p>
<p>A <strong>v0.17.162</strong> kiadás számai (2026.&nbsp;szeptember&nbsp;22.), a termék állapotában rögzítve:</p>
<ul>
<li>1&nbsp;772 egységteszt</li>
<li>754 integrációs teszt</li>
<li>1&nbsp;651 felületi teszt</li>
<li><strong>összesen 4&nbsp;177</strong>, mind zöld</li>
</ul>
<p>2026.&nbsp;szeptember&nbsp;17. és 22. között a <strong>v0.17.143</strong>-tól a <strong>v0.17.162</strong>-ig: húsz kiadás. Felírási korlátok az adminisztrátornak. Ellenőrzések, amelyek megállítják a szerepkörök tágítását. Összevetés az árlistával. A laboratóriumi mátrix javításai. A működés szabályait szlovákul döntöttem el a betegkonzultációk között.</p>
<p>A változásnapló ezt nem mondja. Ezek a kiadások mind előbb mesterséges intelligencia segítségével készült auditon mentek át. Az írja a sablonkódot. Én minden sort átolvasok, és a klinikai logikát döntöm el. Ez a munkamegosztás az egész termék.</p>
<p>Klinikai szoftvert egyedül építeni régen sebesség és biztonság közötti választást jelentett. Ha a mesterséges intelligencia végzi az ismétlődő munkát, a teszteket, a javításokat és a biztonsági ellenőrzéseket, a választás szűkül.</p>
<p>A termék megtalálható. A tesztsorozat az oka, hogy aggodalom nélkül meg lehet találni.</p>
<p>Ha hasonlót építenek egyedül, mit adnának át először a mesterséges intelligenciának?</p>
HTML,
        ],
        'it' => [
            'title' => 'Il mio software di nefrologia è comparso questa settimana nei risultati di Google. Il percorso ha contato 4.177 test verdi.',
            'image_alt' => 'Un medico-sviluppatore a una scrivania silenziosa: software di dialisi luminoso sul monitor, dietro di lui un muro di luci verdi dei test, un fascio di ricerca che trova il prodotto.',
            'excerpt' => 'Google ha indicizzato arenibus.polascin.net. Da v0.17.143 a v0.17.162 in cinque giorni ho rilasciato venti versioni: 1.772 unitari, 754 di integrazione e 1.651 di interfaccia, tutti verdi. L’intelligenza artificiale scrive il codice ripetitivo; la logica clinica la decido io.',
            'content' => <<<'HTML'
<p><a href="https://arenibus.polascin.net/">Arenibus</a> è nato come sistema informativo .NET per la gestione della dialisi. Uno sviluppatore. Un medico. Senza team.</p>
<p>Questa settimana Google ha indicizzato arenibus.polascin.net. Un avviso Google su «polascin.net» l’ha confermato il 20&nbsp;settembre&nbsp;2026. Per la prima volta il prodotto è nei risultati quando qualcuno cerca software di nefrologia in slovacco.</p>
<p>I numeri al rilascio <strong>v0.17.162</strong> (22&nbsp;settembre&nbsp;2026), registrati nello stato del prodotto:</p>
<ul>
<li>1.772 test unitari</li>
<li>754 test di integrazione</li>
<li>1.651 test di interfaccia</li>
<li><strong>4.177 in totale</strong>, tutti verdi</li>
</ul>
<p>Dal 17&nbsp;al 22&nbsp;settembre&nbsp;2026 ho rilasciato da <strong>v0.17.143</strong> a <strong>v0.17.162</strong>: venti versioni. Limiti di prescrizione per l’amministratore. Controlli che impediscono di allargare i ruoli. Confronto con il listino. Correzioni della matrice di laboratorio. Le regole di funzionamento le ho decise in slovacco tra le consulenze con i pazienti.</p>
<p>Il registro delle modifiche non lo dice. Ognuna di quelle versioni è prima passata da un audit con l’aiuto dell’intelligenza artificiale. Lei scrive il codice ripetitivo. Io leggo ogni riga e decido la logica clinica. Quella divisione del lavoro è tutto il prodotto.</p>
<p>Costruire software clinico da soli un tempo significava scegliere tra velocità e sicurezza. Quando l’intelligenza artificiale prende il lavoro ripetitivo, test, patch e controlli di sicurezza, quella scelta si restringe.</p>
<p>Il prodotto si trova. La suite di test è il motivo per cui lo si può trovare senza inquietudine.</p>
<p>Se costruite qualcosa di simile da soli, che cosa dareste per primi all’intelligenza artificiale?</p>
HTML,
        ],
        'uk' => [
            'title' => 'Мій нефрологічний софт цього тижня з’явився в результатах Google. Шлях до цього мав 4 177 зелених тестів.',
            'image_alt' => 'Лікар-розробник за спокійним столом: на моніторі світиться діалізний софт, за ним стіна зелених тестових ліхтарів, пошуковий промінь знаходить продукт.',
            'excerpt' => 'Google проіндексував arenibus.polascin.net. Від v0.17.143 до v0.17.162 за п’ять днів я випустив двадцять релізів: 1 772 модульних, 754 інтеграційних і 1 651 тестів інтерфейсу, усі зелені. Шаблонний код пише штучний інтелект; клінічну логіку вирішую я.',
            'content' => <<<'HTML'
<p><a href="https://arenibus.polascin.net/">Arenibus</a> почався як інформаційна система .NET для ведення діалізу. Один розробник. Один лікар. Без команди.</p>
<p>Цього тижня Google проіндексував arenibus.polascin.net. Google Alert на «polascin.net» підтвердив це 20&nbsp;вересня&nbsp;2026. Уперше продукт є в результатах, коли хтось шукає нефрологічне програмне забезпечення словацькою.</p>
<p>Цифри на релізі <strong>v0.17.162</strong> (22&nbsp;вересня&nbsp;2026), записані в стані продукту:</p>
<ul>
<li>1&nbsp;772 модульних тестів</li>
<li>754 інтеграційних тестів</li>
<li>1&nbsp;651 тестів інтерфейсу</li>
<li><strong>4&nbsp;177 разом</strong>, усі зелені</li>
</ul>
<p>З 17&nbsp;по 22&nbsp;вересня&nbsp;2026 я випустив від <strong>v0.17.143</strong> до <strong>v0.17.162</strong>: двадцять релізів. Обмеження призначення для адміністратора. Перевірки, які не дають розширити ролі. Порівняння з прайсом. Виправлення лабораторної матриці. Правила роботи я вирішував словацькою між консультаціями з пацієнтами.</p>
<p>Список змін цього не скаже. Кожен із тих релізів спочатку пройшов аудит за допомогою штучного інтелекту. Він пише шаблонний код. Я читаю кожен рядок і вирішую клінічну логіку. Цей поділ праці і є весь продукт.</p>
<p>Будувати клінічне програмне забезпечення наодинці колись означало обирати між швидкістю й безпекою. Коли штучний інтелект бере повторювану роботу, тести, латки й перевірки безпеки, цей вибір звужується.</p>
<p>Продукт можна знайти. Тестовий набір є причиною, чому його можна знайти без тривоги.</p>
<p>Якщо будуєте щось подібне самі, що б ви віддали штучному інтелекту першим?</p>
HTML,
        ],
    ],
];
