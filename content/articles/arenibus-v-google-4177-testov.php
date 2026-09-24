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
 * Note: draft “6 166” was rejected — does not appear in STATUS/AUDIT and 1365+709+1510 ≠ 6166.
 * Used v0.17.162 close: 1772 unit + 754 integration + 1651 frontend = 4177.
 * Span v0.17.143…v0.17.162 inclusive = 20 releases (not 19).
 */
return [
    'slug' => 'arenibus-v-google-4177-testov',
    'author' => 'MUDr. Ľubomír Polaščín',
    'category' => 'blog',
    'is_top' => 0,
    'published_at' => '2026-09-24 18:30:00',
    'image' => 'images/articles/arenibus-v-google-4177-testov.webp',
    'translations' => [
        'sk' => [
            'title' => 'Môj nefrologický softvér sa tento týždeň objavil vo výsledkoch Google. Cesta k tomu mala 4 177 zelených testov.',
            'image_alt' => 'Lekár-vývojár pri tichom stole: na monitore žiari dialyzačný softvér, za ním stena zelených testovacích svetiel a hľadáčikový lúč svetla, ktorý produkt nachádza.',
            'excerpt' => 'Google indexoval arenibus.polascin.net. Od v0.17.143 po v0.17.162 som za päť dní poslal dvadsať vydaní — 1 772 unit, 754 integračných a 1 651 frontendových testov, všetky zelené. AI píše boilerplate; klinickú logiku rozhodujem ja.',
            'content' => <<<'HTML'
<p>Môj nefrologický softvér sa tento týždeň objavil vo výsledkoch Google. Cesta k tomu mala 4&nbsp;177 zelených testov.</p>
<p><a href="https://arenibus.polascin.net/">Arenibus</a> začal ako .NET informačný systém pre manažment dialýzy. Jeden vývojár. Jeden lekár. Bez tímu.</p>
<p>Tento týždeň Google indexoval arenibus.polascin.net — Google Alert na „polascin.net“ to potvrdil 20.&nbsp;9.&nbsp;2026. Po prvý raz, keď niekto hľadá nefrologický softvér po slovensky, produkt existuje vo výsledkoch.</p>
<p>Čísla pri vydaní <strong>v0.17.162</strong> (22.&nbsp;9.&nbsp;2026), zapísané v statuse produktu:</p>
<ul>
<li>1&nbsp;772 unit testov</li>
<li>754 integračných testov</li>
<li>1&nbsp;651 frontendových testov</li>
<li><strong>4&nbsp;177 spolu</strong>, všetky zelené</li>
</ul>
<p>Od 17.&nbsp;do 22.&nbsp;septembra 2026 som poslal vydania od <strong>v0.17.143</strong> po <strong>v0.17.162</strong> — dvadsať vydaní. Obmedzenia predpisovania pre admina. Stráže rozšírenia rolí. Porovnanie ceny s cenníkom. Opravy laboratórnej matice. Biznis pravidlá som rozhodoval po slovensky medzi konzultáciami s pacientmi.</p>
<p>Čo changelog nepovie: každé z tých vydaní najprv prešlo AI-asistovaným auditom. AI píše boilerplate. Ja prečítam každý riadok a rozhodnem klinickú biznis logiku. Tá delba práce je celý produkt.</p>
<p>Stavať klinický softvér sólo kedysi znamenalo voliť medzi rýchlosťou a bezpečnosťou. Keď AI zvládne opakujúcu sa prácu — testy, záplaty, bezpečnostné skeny — ten kompromis sa zužuje.</p>
<p>Produkt je nájditeľný. Testovacia sada je dôvod, prečo je bezpečné ho nájsť.</p>
<p>Ak staviaťe niečo podobné sami — čo by ste AI odovzdali ako prvé? Napíšte mi cez <a href="contact.php">kontakt</a>.</p>
HTML,
        ],
        'en' => [
            'title' => 'My nephrology software showed up in Google search results this week. Getting there took 4,177 green tests.',
            'image_alt' => 'A physician-developer at a quiet desk: dialysis software glowing on a monitor, a wall of green test lights behind him, a search beam finding the product.',
            'excerpt' => 'Google indexed arenibus.polascin.net. From v0.17.143 to v0.17.162 I shipped twenty releases in five days — 1,772 unit, 754 integration and 1,651 frontend tests, all green. AI writes the boilerplate; I decide the clinical logic.',
            'content' => <<<'HTML'
<p>My nephrology software showed up in Google search results this week. Getting there took 4,177 green tests.</p>
<p><a href="https://arenibus.polascin.net/">Arenibus</a> started as a .NET information system for dialysis management. One developer. One physician. No team.</p>
<p>This week Google indexed arenibus.polascin.net — a Google Alert for “polascin.net” confirmed it on 20&nbsp;September&nbsp;2026. For the first time, if you search for nephrology software in Slovak, the product exists in the results.</p>
<p>The numbers at release <strong>v0.17.162</strong> (22&nbsp;September&nbsp;2026), recorded in the product status:</p>
<ul>
<li>1,772 unit tests</li>
<li>754 integration tests</li>
<li>1,651 frontend tests</li>
<li><strong>4,177 total</strong>, all green</li>
</ul>
<p>From 17&nbsp;to 22&nbsp;September&nbsp;2026 I shipped from <strong>v0.17.143</strong> to <strong>v0.17.162</strong> — twenty releases. Admin prescribing restrictions. Role-expansion guards. Price-list comparison. Lab-matrix fixes. Business-rule decisions I made in Slovak between patient consults.</p>
<p>The part that does not make the changelog: every one of those releases went through an AI-assisted audit first. The AI writes the boilerplate. I review every line and make the clinical business-logic decisions. That division of labour is the whole product.</p>
<p>Building clinical software solo used to mean choosing between speed and safety. With AI handling the repetitive work — tests, patches, security scans — the trade-off narrows.</p>
<p>The product is findable now. The test suite is the reason it is safe to find.</p>
<p>If you are building something similar alone — what would you hand to AI first? Write to me via the <a href="contact.php">contact form</a>.</p>
HTML,
        ],
        'cs' => [
            'title' => 'Můj nefrologický software se tento týden objevil ve výsledcích Google. Cesta k tomu měla 4 177 zelených testů.',
            'image_alt' => 'Lékař-vývojář u tichého stolu: na monitoru září dialyzační software, za ním stěna zelených testovacích světel a hledáčkový paprsek světla, který produkt nachází.',
            'excerpt' => 'Google indexoval arenibus.polascin.net. Od v0.17.143 po v0.17.162 jsem za pět dní poslal dvacet vydání — 1 772 unit, 754 integračních a 1 651 frontendových testů, všechny zelené. AI píše boilerplate; klinickou logiku rozhoduji já.',
            'content' => <<<'HTML'
<p>Můj nefrologický software se tento týden objevil ve výsledcích Google. Cesta k tomu měla 4&nbsp;177 zelených testů.</p>
<p><a href="https://arenibus.polascin.net/">Arenibus</a> začal jako .NET informační systém pro management dialýzy. Jeden vývojář. Jeden lékař. Bez týmu.</p>
<p>Tento týden Google indexoval arenibus.polascin.net — Google Alert na „polascin.net“ to potvrdil 20.&nbsp;9.&nbsp;2026. Poprvé, když někdo hledá nefrologický software slovensky, produkt ve výsledcích existuje.</p>
<p>Čísla při vydání <strong>v0.17.162</strong> (22.&nbsp;9.&nbsp;2026), zapsaná ve statusu produktu:</p>
<ul>
<li>1&nbsp;772 unit testů</li>
<li>754 integračních testů</li>
<li>1&nbsp;651 frontendových testů</li>
<li><strong>4&nbsp;177 dohromady</strong>, všechny zelené</li>
</ul>
<p>Od 17.&nbsp;do 22.&nbsp;září 2026 jsem poslal vydání od <strong>v0.17.143</strong> po <strong>v0.17.162</strong> — dvacet vydání. Omezení předepisování pro admina. Stráže rozšíření rolí. Porovnání ceny s ceníkem. Opravy laboratorní matice. Business pravidla jsem rozhodoval slovensky mezi konzultacemi s pacienty.</p>
<p>Co changelog neřekne: každé z těch vydání nejprve prošlo AI-asistovaným auditem. AI píše boilerplate. Já přečtu každý řádek a rozhodnu klinickou business logiku. Ta dělba práce je celý produkt.</p>
<p>Stavět klinický software sólo kdysi znamenalo volit mezi rychlostí a bezpečností. Když AI zvládne opakující se práci — testy, záplaty, bezpečnostní skeny — ten kompromis se zužuje.</p>
<p>Produkt je dohledatelný. Testovací sada je důvod, proč je bezpečné ho najít.</p>
<p>Pokud stavíte něco podobného sami — co byste AI předali jako první? Napište mi přes <a href="contact.php">kontakt</a>.</p>
HTML,
        ],
        'de' => [
            'title' => 'Meine Nephrologie-Software tauchte diese Woche in den Google-Suchergebnissen auf. Der Weg dorthin umfasste 4.177 grüne Tests.',
            'image_alt' => 'Arzt-Entwickler an einem ruhigen Schreibtisch: Dialysesoftware leuchtet auf dem Monitor, dahinter eine Wand grüner Testlichter, ein Suchstrahl findet das Produkt.',
            'excerpt' => 'Google hat arenibus.polascin.net indexiert. Von v0.17.143 bis v0.17.162 lieferte ich in fünf Tagen zwanzig Releases — 1.772 Unit-, 754 Integrations- und 1.651 Frontend-Tests, alle grün. KI schreibt Boilerplate; die klinische Logik entscheide ich.',
            'content' => <<<'HTML'
<p>Meine Nephrologie-Software tauchte diese Woche in den Google-Suchergebnissen auf. Der Weg dorthin umfasste 4.177 grüne Tests.</p>
<p><a href="https://arenibus.polascin.net/">Arenibus</a> begann als .NET-Informationssystem für das Dialysemanagement. Ein Entwickler. Ein Arzt. Kein Team.</p>
<p>Diese Woche hat Google arenibus.polascin.net indexiert — ein Google Alert für „polascin.net“ bestätigte das am 20.&nbsp;9.&nbsp;2026. Zum ersten Mal existiert das Produkt in den Ergebnissen, wenn man auf Slowakisch nach Nephrologie-Software sucht.</p>
<p>Die Zahlen beim Release <strong>v0.17.162</strong> (22.&nbsp;9.&nbsp;2026), festgehalten im Produktstatus:</p>
<ul>
<li>1.772 Unit-Tests</li>
<li>754 Integrationstests</li>
<li>1.651 Frontend-Tests</li>
<li><strong>4.177 insgesamt</strong>, alle grün</li>
</ul>
<p>Vom 17.&nbsp;bis 22.&nbsp;September 2026 lieferte ich von <strong>v0.17.143</strong> bis <strong>v0.17.162</strong> — zwanzig Releases. Verschreibungsbeschränkungen für Admins. Wächter für Rollenerweiterungen. Preislistenvergleich. Korrekturen der Labormatrix. Geschäftsregeln entschied ich auf Slowakisch zwischen Patientenkonsultationen.</p>
<p>Was das Changelog nicht sagt: jedes dieser Releases ging zuerst durch ein KI-gestütztes Audit. Die KI schreibt Boilerplate. Ich lese jede Zeile und treffe die klinischen Business-Logic-Entscheidungen. Diese Arbeitsteilung ist das ganze Produkt.</p>
<p>Klinische Software allein zu bauen hieß früher, zwischen Geschwindigkeit und Sicherheit zu wählen. Wenn KI die repetitive Arbeit übernimmt — Tests, Patches, Security-Scans — verengt sich dieser Kompromiss.</p>
<p>Das Produkt ist auffindbar. Die Testsuite ist der Grund, warum es sicher ist, es zu finden.</p>
<p>Wenn Sie etwas Ähnliches allein bauen — was würden Sie der KI zuerst übergeben? Schreiben Sie mir über das <a href="contact.php">Kontaktformular</a>.</p>
HTML,
        ],
        'fr' => [
            'title' => 'Mon logiciel de néphrologie est apparu cette semaine dans les résultats Google. Le chemin a compté 4 177 tests verts.',
            'image_alt' => 'Un médecin-développeur à un bureau calme : logiciel de dialyse lumineux sur l’écran, mur de voyants de tests verts derrière lui, faisceau de recherche qui trouve le produit.',
            'excerpt' => 'Google a indexé arenibus.polascin.net. De v0.17.143 à v0.17.162 j’ai livré vingt versions en cinq jours — 1 772 tests unitaires, 754 d’intégration et 1 651 frontend, tous verts. L’IA écrit le boilerplate ; je décide la logique clinique.',
            'content' => <<<'HTML'
<p>Mon logiciel de néphrologie est apparu cette semaine dans les résultats Google. Le chemin a compté 4&nbsp;177 tests verts.</p>
<p><a href="https://arenibus.polascin.net/">Arenibus</a> a commencé comme système d’information .NET pour la gestion de la dialyse. Un développeur. Un médecin. Pas d’équipe.</p>
<p>Cette semaine, Google a indexé arenibus.polascin.net — une alerte Google sur «&nbsp;polascin.net&nbsp;» l’a confirmé le 20&nbsp;septembre&nbsp;2026. Pour la première fois, si l’on cherche un logiciel de néphrologie en slovaque, le produit existe dans les résultats.</p>
<p>Les chiffres à la version <strong>v0.17.162</strong> (22&nbsp;septembre&nbsp;2026), consignés dans le statut du produit&nbsp;:</p>
<ul>
<li>1&nbsp;772 tests unitaires</li>
<li>754 tests d’intégration</li>
<li>1&nbsp;651 tests frontend</li>
<li><strong>4&nbsp;177 au total</strong>, tous verts</li>
</ul>
<p>Du 17&nbsp;au 22&nbsp;septembre&nbsp;2026, j’ai livré de <strong>v0.17.143</strong> à <strong>v0.17.162</strong> — vingt versions. Restrictions de prescription pour l’admin. Gardes d’extension de rôles. Comparaison avec le tarif. Corrections de la matrice de laboratoire. Décisions de règles métier prises en slovaque entre les consultations.</p>
<p>Ce que le changelog ne dit pas&nbsp;: chacune de ces versions est d’abord passée par un audit assisté par l’IA. L’IA écrit le boilerplate. Je relis chaque ligne et je décide la logique métier clinique. Cette division du travail, c’est tout le produit.</p>
<p>Construire un logiciel clinique en solo, c’était autrefois choisir entre vitesse et sécurité. Quand l’IA prend le travail répétitif — tests, correctifs, scans de sécurité — le compromis se resserre.</p>
<p>Le produit est trouvable. La suite de tests est la raison pour laquelle il est sûr de le trouver.</p>
<p>Si vous construisez quelque chose de similaire seul — que confieriez-vous d’abord à l’IA&nbsp;? Écrivez-moi via le <a href="contact.php">formulaire de contact</a>.</p>
HTML,
        ],
        'es' => [
            'title' => 'Mi software de nefrología apareció esta semana en los resultados de Google. El camino tuvo 4.177 tests en verde.',
            'image_alt' => 'Un médico-desarrollador en un escritorio tranquilo: software de diálisis brillando en el monitor, una pared de luces verdes de tests detrás, un haz de búsqueda que encuentra el producto.',
            'excerpt' => 'Google indexó arenibus.polascin.net. De v0.17.143 a v0.17.162 envié veinte versiones en cinco días — 1.772 unitarios, 754 de integración y 1.651 de frontend, todos verdes. La IA escribe el boilerplate; yo decido la lógica clínica.',
            'content' => <<<'HTML'
<p>Mi software de nefrología apareció esta semana en los resultados de Google. El camino tuvo 4.177 tests en verde.</p>
<p><a href="https://arenibus.polascin.net/">Arenibus</a> empezó como un sistema de información .NET para la gestión de diálisis. Un desarrollador. Un médico. Sin equipo.</p>
<p>Esta semana Google indexó arenibus.polascin.net — una alerta de Google sobre «polascin.net» lo confirmó el 20&nbsp;de septiembre&nbsp;de&nbsp;2026. Por primera vez, si buscas software de nefrología en eslovaco, el producto existe en los resultados.</p>
<p>Los números en la versión <strong>v0.17.162</strong> (22&nbsp;de septiembre&nbsp;de&nbsp;2026), registrados en el estado del producto:</p>
<ul>
<li>1.772 tests unitarios</li>
<li>754 tests de integración</li>
<li>1.651 tests de frontend</li>
<li><strong>4.177 en total</strong>, todos verdes</li>
</ul>
<p>Del 17&nbsp;al 22&nbsp;de septiembre&nbsp;de&nbsp;2026 envié de <strong>v0.17.143</strong> a <strong>v0.17.162</strong> — veinte versiones. Restricciones de prescripción para el admin. Guardas de ampliación de roles. Comparación con la lista de precios. Correcciones de la matriz de laboratorio. Decisiones de reglas de negocio en eslovaco entre consultas con pacientes.</p>
<p>Lo que el changelog no cuenta: cada una de esas versiones pasó primero por una auditoría asistida por IA. La IA escribe el boilerplate. Yo leo cada línea y decido la lógica de negocio clínica. Esa división del trabajo es todo el producto.</p>
<p>Construir software clínico en solitario antes significaba elegir entre velocidad y seguridad. Cuando la IA asume el trabajo repetitivo — tests, parches, análisis de seguridad — el compromiso se estrecha.</p>
<p>El producto es encontrable. La suite de tests es la razón por la que es seguro encontrarlo.</p>
<p>Si construyes algo similar solo — ¿qué le entregarías primero a la IA? Escríbeme por el <a href="contact.php">formulario de contacto</a>.</p>
HTML,
        ],
        'pl' => [
            'title' => 'Mój soft nefrologiczny pojawił się w tym tygodniu w wynikach Google. Droga do tego miała 4 177 zielonych testów.',
            'image_alt' => 'Lekarz-programista przy spokojnym biurku: oprogramowanie dializacyjne świeci na monitorze, za nim ściana zielonych świateł testów, wiązka wyszukiwania odnajduje produkt.',
            'excerpt' => 'Google zindeksował arenibus.polascin.net. Od v0.17.143 do v0.17.162 w pięć dni wysłałem dwadzieścia wydań — 1 772 unit, 754 integracyjnych i 1 651 frontendowych, wszystkie zielone. AI pisze boilerplate; logikę kliniczną decyduję ja.',
            'content' => <<<'HTML'
<p>Mój soft nefrologiczny pojawił się w tym tygodniu w wynikach Google. Droga do tego miała 4&nbsp;177 zielonych testów.</p>
<p><a href="https://arenibus.polascin.net/">Arenibus</a> zaczął jako system informacyjny .NET do zarządzania dializą. Jeden programista. Jeden lekarz. Bez zespołu.</p>
<p>W tym tygodniu Google zindeksował arenibus.polascin.net — alert Google na „polascin.net” potwierdził to 20&nbsp;września&nbsp;2026. Po raz pierwszy, gdy ktoś szuka softu nefrologicznego po słowacku, produkt istnieje w wynikach.</p>
<p>Liczby przy wydaniu <strong>v0.17.162</strong> (22&nbsp;września&nbsp;2026), zapisane w statusie produktu:</p>
<ul>
<li>1&nbsp;772 testów jednostkowych</li>
<li>754 testów integracyjnych</li>
<li>1&nbsp;651 testów frontendowych</li>
<li><strong>4&nbsp;177 łącznie</strong>, wszystkie zielone</li>
</ul>
<p>Od 17&nbsp;do 22&nbsp;września&nbsp;2026 wysłałem wydania od <strong>v0.17.143</strong> do <strong>v0.17.162</strong> — dwadzieścia wydań. Ograniczenia przepisywania dla admina. Strażnicy rozszerzania ról. Porównanie z cennikiem. Poprawki macierzy laboratoryjnej. Reguły biznesowe decydowałem po słowacku między konsultacjami z pacjentami.</p>
<p>Czego changelog nie powie: każde z tych wydań najpierw przeszło audyt wspomagany AI. AI pisze boilerplate. Ja czytam każdą linię i decyduję o klinicznej logice biznesowej. Ten podział pracy to cały produkt.</p>
<p>Budowanie klinicznego softu solo kiedyś oznaczało wybór między szybkością a bezpieczeństwem. Gdy AI bierze powtarzalną pracę — testy, łatki, skany bezpieczeństwa — ten kompromis się zawęża.</p>
<p>Produkt jest znajdowalny. Zestaw testów jest powodem, dla którego bezpiecznie go znaleźć.</p>
<p>Jeśli budujecie coś podobnego sami — co oddalibyście AI jako pierwsze? Napiszcie przez <a href="contact.php">kontakt</a>.</p>
HTML,
        ],
        'hu' => [
            'title' => 'A nefrológiai szoftverem ezen a héten megjelent a Google találatok között. Az odáig vezető út 4 177 zöld teszt volt.',
            'image_alt' => 'Orvos-fejlesztő csendes asztalnál: dialízis-szoftver világít a monitoron, mögötte zöld tesztlámpák fala, kereső fénysugár találja meg a terméket.',
            'excerpt' => 'A Google indexelte az arenibus.polascin.net oldalt. A v0.17.143-tól a v0.17.162-ig öt nap alatt húsz kiadást küldtem — 1 772 unit, 754 integrációs és 1 651 frontend teszt, mind zöld. Az AI írja a boilerplate-et; a klinikai logikát én döntöm el.',
            'content' => <<<'HTML'
<p>A nefrológiai szoftverem ezen a héten megjelent a Google találatok között. Az odáig vezető út 4&nbsp;177 zöld teszt volt.</p>
<p>Az <a href="https://arenibus.polascin.net/">Arenibus</a> .NET információs rendszerként indult dialíziskezelésre. Egy fejlesztő. Egy orvos. Csapat nélkül.</p>
<p>Ezen a héten a Google indexelte az arenibus.polascin.net oldalt — a „polascin.net” Google Alert 2026.&nbsp;szeptember&nbsp;20-án igazolta. Először, ha valaki szlovákul keres nefrológiai szoftvert, a termék létezik a találatokban.</p>
<p>A <strong>v0.17.162</strong> kiadás számai (2026.&nbsp;szeptember&nbsp;22.), a termékstátuszban rögzítve:</p>
<ul>
<li>1&nbsp;772 unit teszt</li>
<li>754 integrációs teszt</li>
<li>1&nbsp;651 frontend teszt</li>
<li><strong>összesen 4&nbsp;177</strong>, mind zöld</li>
</ul>
<p>2026.&nbsp;szeptember&nbsp;17. és 22. között a <strong>v0.17.143</strong>-tól a <strong>v0.17.162</strong>-ig — húsz kiadás. Admin felírási korlátozások. Szerepkör-bővítési őrök. Árlista-összevetés. Laboratóriumi mátrix javítások. Üzleti szabályokat szlovákul döntöttem el a betegkonzultációk között.</p>
<p>Amit a changelog nem mond: ezek a kiadások mind előbb AI-segített auditon mentek át. Az AI írja a boilerplate-et. Én minden sort átolvasok, és a klinikai üzleti logikát döntöm el. Ez a munkamegosztás az egész termék.</p>
<p>Klinikai szoftvert egyedül építeni régen sebesség és biztonság közötti választást jelentett. Ha az AI végzi az ismétlődő munkát — tesztek, javítások, biztonsági vizsgálatok — a kompromisszum szűkül.</p>
<p>A termék megtalálható. A tesztsorozat az oka, hogy biztonságos megtalálni.</p>
<p>Ha hasonlót építettek egyedül — mit adnának át először az AI-nak? Írjanak a <a href="contact.php">kapcsolati űrlapon</a>.</p>
HTML,
        ],
        'it' => [
            'title' => 'Il mio software di nefrologia è comparso questa settimana nei risultati di Google. Il percorso ha contato 4.177 test verdi.',
            'image_alt' => 'Un medico-sviluppatore a una scrivania silenziosa: software di dialisi luminoso sul monitor, dietro di lui un muro di luci verdi dei test, un fascio di ricerca che trova il prodotto.',
            'excerpt' => 'Google ha indicizzato arenibus.polascin.net. Da v0.17.143 a v0.17.162 in cinque giorni ho rilasciato venti versioni — 1.772 unit, 754 di integrazione e 1.651 frontend, tutti verdi. L’IA scrive il boilerplate; la logica clinica la decido io.',
            'content' => <<<'HTML'
<p>Il mio software di nefrologia è comparso questa settimana nei risultati di Google. Il percorso ha contato 4.177 test verdi.</p>
<p><a href="https://arenibus.polascin.net/">Arenibus</a> è nato come sistema informativo .NET per la gestione della dialisi. Un sviluppatore. Un medico. Senza team.</p>
<p>Questa settimana Google ha indicizzato arenibus.polascin.net — un avviso Google su «polascin.net» l’ha confermato il 20&nbsp;settembre&nbsp;2026. Per la prima volta, chi cerca software di nefrologia in slovacco trova il prodotto nei risultati.</p>
<p>I numeri al rilascio <strong>v0.17.162</strong> (22&nbsp;settembre&nbsp;2026), registrati nello stato del prodotto:</p>
<ul>
<li>1.772 test unitari</li>
<li>754 test di integrazione</li>
<li>1.651 test frontend</li>
<li><strong>4.177 in totale</strong>, tutti verdi</li>
</ul>
<p>Dal 17&nbsp;al 22&nbsp;settembre&nbsp;2026 ho rilasciato da <strong>v0.17.143</strong> a <strong>v0.17.162</strong> — venti versioni. Restrizioni di prescrizione per l’admin. Guardie sull’espansione dei ruoli. Confronto con il listino. Correzioni della matrice di laboratorio. Decisioni di business rule in slovacco tra le consulenze con i pazienti.</p>
<p>Quello che il changelog non dice: ognuna di quelle versioni è prima passata da un audit assistito dall’IA. L’IA scrive il boilerplate. Io leggo ogni riga e decido la logica di business clinica. Quella divisione del lavoro è tutto il prodotto.</p>
<p>Costruire software clinico da soli un tempo significava scegliere tra velocità e sicurezza. Quando l’IA gestisce il lavoro ripetitivo — test, patch, scansioni di sicurezza — il compromesso si restringe.</p>
<p>Il prodotto è trovabile. La suite di test è il motivo per cui è sicuro trovarlo.</p>
<p>Se costruite qualcosa di simile da soli — cosa dareste per primi all’IA? Scrivetemi tramite il <a href="contact.php">modulo di contatto</a>.</p>
HTML,
        ],
        'uk' => [
            'title' => 'Мій нефрологічний софт цього тижня з’явився в результатах Google. Шлях до цього мав 4 177 зелених тестів.',
            'image_alt' => 'Лікар-розробник за спокійним столом: на моніторі світиться діалізний софт, за ним стіна зелених тестових ліхтарів, пошуковий промінь знаходить продукт.',
            'excerpt' => 'Google проіндексував arenibus.polascin.net. Від v0.17.143 до v0.17.162 за п’ять днів я випустив двадцять релізів — 1 772 unit, 754 інтеграційних і 1 651 фронтенд-тестів, усі зелені. AI пише boilerplate; клінічну логіку вирішую я.',
            'content' => <<<'HTML'
<p>Мій нефрологічний софт цього тижня з’явився в результатах Google. Шлях до цього мав 4&nbsp;177 зелених тестів.</p>
<p><a href="https://arenibus.polascin.net/">Arenibus</a> почався як .NET інформаційна система для керування діалізом. Один розробник. Один лікар. Без команди.</p>
<p>Цього тижня Google проіндексував arenibus.polascin.net — Google Alert на «polascin.net» підтвердив це 20&nbsp;вересня&nbsp;2026. Уперше, коли хтось шукає нефрологічний софт словацькою, продукт існує в результатах.</p>
<p>Цифри на релізі <strong>v0.17.162</strong> (22&nbsp;вересня&nbsp;2026), записані в статусі продукту:</p>
<ul>
<li>1&nbsp;772 unit-тестів</li>
<li>754 інтеграційних тестів</li>
<li>1&nbsp;651 фронтенд-тестів</li>
<li><strong>4&nbsp;177 разом</strong>, усі зелені</li>
</ul>
<p>З 17&nbsp;по 22&nbsp;вересня&nbsp;2026 я випустив від <strong>v0.17.143</strong> до <strong>v0.17.162</strong> — двадцять релізів. Обмеження призначення для адміна. Охорони розширення ролей. Порівняння з прайсом. Виправлення лабораторної матриці. Бізнес-правила я вирішував словацькою між консультаціями з пацієнтами.</p>
<p>Чого changelog не скаже: кожен із тих релізів спочатку пройшов AI-асистований аудит. AI пише boilerplate. Я читаю кожен рядок і вирішую клінічну бізнес-логіку. Цей поділ праці — весь продукт.</p>
<p>Будувати клінічний софт наодинці колись означало обирати між швидкістю й безпекою. Коли AI бере повторювану роботу — тести, латки, сканування безпеки — цей компроміс звужується.</p>
<p>Продукт можна знайти. Тестовий набір — причина, чому його безпечно знаходити.</p>
<p>Якщо будуєте щось подібне самі — що б ви віддали AI першим? Напишіть мені через <a href="contact.php">контакт</a>.</p>
HTML,
        ],
    ],
];
