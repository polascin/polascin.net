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
 * Archív nefrologických článkov ako publikácia, začiatok októbra 2026.
 * Katalóg https://nefro.polascin.net/publikacie.php : plné slovenské vydanie
 * SK Nefro Báza 1 má 387 článkov a 1 745 strán. Podklad uvádzal 405 článkov
 * pri tom istom počte strán; zverejnený zväzok má 387.
 * Kompendium: 387 článkov, abstrakt a štyri až sedem bodov, syntéza
 * na začiatku každej zo 16 kapitol, 261 strán.
 * 6. októbra 2026 dva e-maily Kindle Direct Publishing potvrdili,
 * že anglické vydanie je v Kindle Store. Verejný odkaz na Kindle sa tu necituje.
 * Týždenný prehľad Nefro-projektu z 5. októbra 2026 dokumentuje časť Publikácie.
 * Bez tržieb a platieb.
 */
return [
    'slug' => 'najvacsia-verzia-nie-je-najuzitocnejsia',
    'author' => 'MUDr. Ľubomír Polaščín',
    'category' => 'blog',
    'is_top' => 0,
    'published_at' => '2026-10-15 18:45:00',
    'image' => 'images/articles/najvacsia-verzia-nie-je-najuzitocnejsia.webp',
    'translations' => [
        'sk' => [
            'title' => 'Najväčšia verzia nemusí byť najužitočnejšia.',
            'image_alt' => 'Muž od chrbta sedí pri tmavom stole v noci. Pred ním stojí vysoký zväzok papierov vo fialovom a tyrkysovom svetle a bokom leží tenká otvorená kniha, ktorá svieti tyrkysovo.',
            'excerpt' => 'Plné slovenské vydanie SK Nefro Báza 1 má 387 článkov a 1 745 strán. Kompendium tie isté články zhustí na abstrakt, štyri až sedem bodov a syntézu šestnástich kapitol, spolu 261 strán. 6. októbra 2026 Kindle Direct Publishing potvrdil, že anglické vydanie je v Kindle Store. Rozsah som prestal brať ako mieru užitočnosti.',
            'content' => <<<'HTML'
<p>Začiatkom októbra 2026 som z archívu článkov na Nefro-projekte Slovensko spravil publikáciu, do ktorej vedie viac ciest. Plné slovenské vydanie SK Nefro Báza 1 má 387 článkov a 1 745 strán.</p>
<p>Kompendium je postavené inak. Z každého z tých 387 článkov ostal abstrakt a štyri až sedem bodov. Každú zo 16 kapitol otvára syntéza. Vyšlo to na 261 strán.</p>
<p>6. októbra Kindle Direct Publishing potvrdil, že anglické vydanie je v Kindle Store.</p>
<p>Plný zväzok necháva článok celý. Kompendium z neho necháva vstup. Kto potrebuje celý text, siahne po prvom. Kto potrebuje zistiť, o čom ročník je, siahne po druhom.</p>
<p>Pribudla aj samostatná časť <a href="https://nefro.polascin.net/publikacie.php">Publikácie</a>. Dá sa v nej vybrať formát a prejsť objednávkou. Znamenalo to obchodné podmienky a oznámenie o ochrane údajov. Nestačilo nahrať PDF.</p>
<p>Pri skladaní produktu z archívu som prestal brať rozsah ako mieru užitočnosti. Rozhoduje, čo má kto prečítať. Prípona súboru o tom nerozhodne.</p>
<p><em>Osobné rozhodnutie o vlastných publikáciách. Text neuvádza tržby ani platby.</em></p>

HTML,
        ],
        'en' => [
            'title' => 'The largest version need not be the most useful.',
            'image_alt' => 'A man seen from behind sits at a dark desk at night. A tall stack of paper glows violet and teal in front of him, and a thin open book shines teal to the side.',
            'excerpt' => 'The full Slovak edition of SK Nefro Báza 1 holds 387 articles and 1,745 pages. The compendium condenses the same articles into an abstract, four to seven points, and a synthesis of sixteen chapters, 261 pages in all. On 6 October 2026, Kindle Direct Publishing confirmed that the English edition was in the Kindle Store. I stopped treating length as a measure of usefulness.',
            'content' => <<<'HTML'
<p>In early October 2026 I turned the article archive of Nefro-projekt Slovensko into a publication with several ways in. The full Slovak edition of SK Nefro Báza 1 holds 387 articles and 1,745 pages.</p>
<p>The compendium is built differently. Each of those 387 articles is reduced to an abstract and four to seven points. Each of the 16 chapters opens with a synthesis. That comes to 261 pages.</p>
<p>On 6 October, Kindle Direct Publishing confirmed that the English edition was in the Kindle Store.</p>
<p>The full volume keeps the article whole. The compendium keeps an entry to it. Someone who needs the full text reaches for the first. Someone who needs to see what the year contains reaches for the second.</p>
<p>A separate <a href="https://nefro.polascin.net/publikacie.php">Publications</a> section was added as well. A format can be chosen there, and an order can be placed. That meant terms of sale and a privacy notice. Uploading a PDF was not enough.</p>
<p>While turning an archive into a product, I stopped treating length as a measure of usefulness. What matters is what someone needs to read. The file extension does not decide that.</p>
<p><em>A personal decision about my own publications. The text reports neither revenue nor payments.</em></p>

HTML,
        ],
        'cs' => [
            'title' => 'Největší verze nemusí být nejužitečnější.',
            'image_alt' => 'Muž zády k nám sedí u tmavého stolu v noci. Před ním stojí vysoký svazek papírů ve fialovém a tyrkysovém světle a stranou leží tenká otevřená kniha, která svítí tyrkysově.',
            'excerpt' => 'Plné slovenské vydání SK Nefro Báza 1 má 387 článků a 1 745 stran. Kompendium tytéž články zhustí na abstrakt, čtyři až sedm bodů a syntézu šestnácti kapitol, dohromady 261 stran. 6. října 2026 Kindle Direct Publishing potvrdil, že anglické vydání je v Kindle Store. Rozsah jsem přestal brát jako míru užitečnosti.',
            'content' => <<<'HTML'
<p>Začátkem října 2026 jsem z archivu článků na Nefro-projektu Slovensko udělal publikaci, do které vede víc cest. Plné slovenské vydání SK Nefro Báza 1 má 387 článků a 1 745 stran.</p>
<p>Kompendium je postavené jinak. Z každého z těch 387 článků zůstal abstrakt a čtyři až sedm bodů. Každou ze 16 kapitol otevírá syntéza. Vyšlo to na 261 stran.</p>
<p>6. října Kindle Direct Publishing potvrdil, že anglické vydání je v Kindle Store.</p>
<p>Plný svazek nechává článek celý. Kompendium z něj nechává vstup. Kdo potřebuje celý text, sáhne po prvním. Kdo potřebuje zjistit, o čem ročník je, sáhne po druhém.</p>
<p>Přibyla i samostatná část <a href="https://nefro.polascin.net/publikacie.php">Publikace</a>. Dá se v ní vybrat formát a projít objednávkou. Znamenalo to obchodní podmínky a oznámení o ochraně osobních údajů. Nestačilo nahrát PDF.</p>
<p>Při skládání produktu z archivu jsem přestal brát rozsah jako míru užitečnosti. Rozhoduje, co má kdo přečíst. Přípona souboru o tom nerozhodne.</p>
<p><em>Osobní rozhodnutí o vlastních publikacích. Text neuvádí tržby ani platby.</em></p>

HTML,
        ],
        'de' => [
            'title' => 'Die umfangreichste Fassung muss nicht die nützlichste sein.',
            'image_alt' => 'Ein Mann von hinten sitzt nachts an einem dunklen Tisch. Vor ihm steht ein hoher Papierstapel in violettem und türkisem Licht, daneben liegt ein dünnes aufgeschlagenes Buch, das türkis leuchtet.',
            'excerpt' => 'Die vollständige slowakische Ausgabe von SK Nefro Báza 1 hat 387 Artikel und 1.745 Seiten. Das Kompendium verdichtet dieselben Artikel zu einem Abstract, vier bis sieben Punkten und einer Synthese von sechzehn Kapiteln, zusammen 261 Seiten. Am 6. Oktober 2026 bestätigte Kindle Direct Publishing, dass die englische Ausgabe im Kindle Store steht. Den Umfang nehme ich nicht mehr als Maß der Nützlichkeit.',
            'content' => <<<'HTML'
<p>Anfang Oktober 2026 habe ich aus dem Artikelarchiv von Nefro-projekt Slovensko eine Publikation gemacht, in die mehrere Wege führen. Die vollständige slowakische Ausgabe von SK Nefro Báza 1 hat 387 Artikel und 1.745 Seiten.</p>
<p>Das Kompendium ist anders gebaut. Von jedem dieser 387 Artikel blieben ein Abstract und vier bis sieben Punkte. Eine Synthese eröffnet jedes der 16 Kapitel. Das ergibt 261 Seiten.</p>
<p>Am 6. Oktober bestätigte Kindle Direct Publishing, dass die englische Ausgabe im Kindle Store steht.</p>
<p>Der volle Band lässt den Artikel ganz. Das Kompendium lässt davon einen Einstieg. Wer den ganzen Text braucht, greift zum ersten. Wer wissen will, wovon der Jahrgang handelt, greift zum zweiten.</p>
<p>Hinzugekommen ist auch ein eigener Bereich <a href="https://nefro.polascin.net/publikacie.php">Publikationen</a>. Dort lässt sich ein Format wählen und eine Bestellung durchlaufen. Das bedeutete Verkaufsbedingungen und einen Hinweis zum Datenschutz. Eine PDF-Datei hochzuladen hat nicht gereicht.</p>
<p>Beim Zusammensetzen eines Produkts aus einem Archiv habe ich aufgehört, den Umfang als Maß der Nützlichkeit zu nehmen. Es entscheidet, was jemand lesen muss. Die Dateiendung entscheidet das nicht.</p>
<p><em>Eine persönliche Entscheidung über eigene Publikationen. Der Text nennt weder Umsätze noch Zahlungen.</em></p>

HTML,
        ],
        'fr' => [
            'title' => 'La version la plus volumineuse n’est pas forcément la plus utile.',
            'image_alt' => 'Un homme vu de dos est assis la nuit à un bureau sombre. Devant lui, une haute pile de feuilles luit en violet et en turquoise, et à côté un mince livre ouvert brille en turquoise.',
            'excerpt' => 'L’édition slovaque intégrale de SK Nefro Báza 1 réunit 387 articles et 1 745 pages. Le compendium condense les mêmes articles en un résumé, quatre à sept points et une synthèse de seize chapitres, 261 pages en tout. Le 6 octobre 2026, Kindle Direct Publishing a confirmé que l’édition anglaise était dans le Kindle Store. J’ai cessé de prendre l’ampleur pour mesure de l’utilité.',
            'content' => <<<'HTML'
<p>Au début d’octobre 2026, j’ai fait de l’archive d’articles de Nefro-projekt Slovensko une publication qui a plusieurs entrées. L’édition slovaque intégrale de SK Nefro Báza 1 réunit 387 articles et 1 745 pages.</p>
<p>Le compendium est bâti autrement. De chacun de ces 387 articles il reste un résumé et quatre à sept points. Chacun des 16 chapitres s’ouvre sur une synthèse. L’ensemble tient en 261 pages.</p>
<p>Le 6 octobre, Kindle Direct Publishing a confirmé que l’édition anglaise était dans le Kindle Store.</p>
<p>Le volume complet laisse l’article entier. Le compendium n’en garde qu’une entrée. Qui a besoin du texte entier prend le premier. Qui veut voir de quoi l’année est faite prend le second.</p>
<p>Une partie <a href="https://nefro.polascin.net/publikacie.php">Publications</a> s’y est ajoutée. On y choisit un format et l’on passe par une commande. Cela a demandé des conditions de vente et une notice sur la protection des données. Déposer un PDF n’a pas suffi.</p>
<p>En faisant un produit à partir d’une archive, j’ai cessé de prendre l’ampleur pour mesure de l’utilité. Ce qui compte, c’est ce que quelqu’un doit lire. L’extension du fichier n’en décide pas.</p>
<p><em>Décision personnelle sur mes propres publications. Le texte n’indique ni recettes ni paiements.</em></p>

HTML,
        ],
        'es' => [
            'title' => 'La versión más voluminosa no tiene por qué ser la más útil.',
            'image_alt' => 'Un hombre de espaldas está sentado de noche ante un escritorio oscuro. Frente a él se alza un alto montón de papeles en luz violeta y turquesa, y a un lado yace un libro delgado abierto que brilla en turquesa.',
            'excerpt' => 'La edición eslovaca completa de SK Nefro Báza 1 reúne 387 artículos y 1.745 páginas. El compendio condensa los mismos artículos en un resumen, de cuatro a siete puntos y una síntesis de dieciséis capítulos, 261 páginas en total. El 6 de octubre de 2026, Kindle Direct Publishing confirmó que la edición inglesa estaba en el Kindle Store. Dejé de tomar el tamaño como medida de la utilidad.',
            'content' => <<<'HTML'
<p>A principios de octubre de 2026 convertí el archivo de artículos de Nefro-projekt Slovensko en una publicación con varias entradas. La edición eslovaca completa de SK Nefro Báza 1 reúne 387 artículos y 1.745 páginas.</p>
<p>El compendio está armado de otro modo. De cada uno de esos 387 artículos queda un resumen y de cuatro a siete puntos. Cada uno de los 16 capítulos se abre con una síntesis. El conjunto ocupa 261 páginas.</p>
<p>El 6 de octubre, Kindle Direct Publishing confirmó que la edición inglesa estaba en el Kindle Store.</p>
<p>El volumen completo deja el artículo entero. El compendio deja de él una entrada. Quien necesita el texto entero toma el primero. Quien quiere ver de qué va el año toma el segundo.</p>
<p>También se añadió una sección <a href="https://nefro.polascin.net/publikacie.php">Publicaciones</a>. En ella se elige el formato y se pasa por un pedido. Eso exigió condiciones de venta y un aviso de privacidad. No bastó con subir un PDF.</p>
<p>Al hacer un producto a partir de un archivo, dejé de tomar el tamaño como medida de la utilidad. Importa qué tiene que leer alguien. La extensión del archivo no lo decide.</p>
<p><em>Decisión personal sobre mis propias publicaciones. El texto no indica ingresos ni pagos.</em></p>

HTML,
        ],
        'pl' => [
            'title' => 'Największa wersja nie musi być najbardziej użyteczna.',
            'image_alt' => 'Mężczyzna od tyłu siedzi nocą przy ciemnym stole. Przed nim stoi wysoki plik kartek w fioletowym i turkusowym świetle, a z boku leży cienka otwarta książka świecąca na turkusowo.',
            'excerpt' => 'Pełne słowackie wydanie SK Nefro Báza 1 ma 387 artykułów i 1 745 stron. Kompendium zagęszcza te same artykuły do abstraktu, czterech do siedmiu punktów i syntezy szesnastu rozdziałów, razem 261 stron. 6 października 2026 Kindle Direct Publishing potwierdził, że wydanie angielskie jest w Kindle Store. Przestałem brać objętość za miarę użyteczności.',
            'content' => <<<'HTML'
<p>Na początku października 2026 zrobiłem z archiwum artykułów Nefro-projekt Slovensko publikację, do której prowadzi więcej niż jedna droga. Pełne słowackie wydanie SK Nefro Báza 1 ma 387 artykułów i 1 745 stron.</p>
<p>Kompendium jest zbudowane inaczej. Z każdego z tych 387 artykułów został abstrakt i cztery do siedmiu punktów. Każdy z 16 rozdziałów otwiera synteza. Całość ma 261 stron.</p>
<p>6 października Kindle Direct Publishing potwierdził, że wydanie angielskie jest w Kindle Store.</p>
<p>Pełny tom zostawia artykuł w całości. Kompendium zostawia z niego wejście. Kto potrzebuje całego tekstu, sięga po pierwszy. Kto potrzebuje sprawdzić, o czym jest rocznik, sięga po drugi.</p>
<p>Doszła też osobna część <a href="https://nefro.polascin.net/publikacie.php">Publikacje</a>. Można w niej wybrać format i przejść zamówienie. Wymagało to warunków sprzedaży i informacji o ochronie danych. Nie wystarczyło wgrać pliku PDF.</p>
<p>Składając produkt z archiwum, przestałem brać objętość za miarę użyteczności. Decyduje to, co ktoś ma przeczytać. Rozszerzenie pliku o tym nie decyduje.</p>
<p><em>Osobista decyzja o własnych publikacjach. Tekst nie podaje przychodów ani płatności.</em></p>

HTML,
        ],
        'hu' => [
            'title' => 'A legnagyobb változat nem feltétlenül a leghasznosabb.',
            'image_alt' => 'Egy férfi hátulról ül éjjel egy sötét asztalnál. Előtte magas papírköteg világít lilán és türkizen, mellette vékony, kinyitott könyv türkiz fénnyel.',
            'excerpt' => 'A SK Nefro Báza 1 teljes szlovák kiadása 387 cikket és 1 745 oldalt tartalmaz. A kompendium ugyanazokat a cikkeket kivonatra és négytől hét pontig sűríti, tizenhat fejezetszintézissel, összesen 261 oldalon. 2026. október 6-án a Kindle Direct Publishing megerősítette, hogy az angol kiadás a Kindle Store-ban van. A terjedelmet többé nem veszem a hasznosság mértékének.',
            'content' => <<<'HTML'
<p>2026 októberének elején a Nefro-projekt Slovensko cikktárából olyan kiadványt csináltam, amelybe több út vezet. A SK Nefro Báza 1 teljes szlovák kiadása 387 cikket és 1 745 oldalt tartalmaz.</p>
<p>A kompendium másképp áll össze. A 387 cikk mindegyike kivonatra és négytől hét pontig szűkült. A 16 fejezet mindegyikét szintézis nyitja. Összesen 261 oldal.</p>
<p>Október 6-án a Kindle Direct Publishing megerősítette, hogy az angol kiadás a Kindle Store-ban van.</p>
<p>A teljes kötet a cikket egészében hagyja meg. A kompendium belépőt hagy belőle. Aki a teljes szöveget keresi, az elsőhöz nyúl. Aki azt akarja látni, miről szól az évfolyam, a másodikhoz.</p>
<p>Külön <a href="https://nefro.polascin.net/publikacie.php">Publikációk</a> rész is került mellé. Ott formátumot lehet választani, és végig lehet menni a megrendelésen. Ehhez értékesítési feltételek és adatvédelmi tájékoztató kellettek. Nem volt elég feltölteni egy PDF-et.</p>
<p>Miközben archívumból terméket raktam össze, abbahagytam, hogy a terjedelmet a hasznosság mértékének vegyem. Az dönt, mit kell elolvasni. A fájl kiterjesztése ebben nem dönt.</p>
<p><em>Személyes döntés a saját kiadványokról. A szöveg sem bevételt, sem kifizetést nem említ.</em></p>

HTML,
        ],
        'it' => [
            'title' => 'La versione più ampia non è per forza la più utile.',
            'image_alt' => 'Un uomo di spalle siede di notte a un tavolo scuro. Davanti a lui una pila alta di fogli brilla di viola e di turchese, e di lato giace un libro sottile aperto che brilla di turchese.',
            'excerpt' => 'L’edizione slovacca integrale di SK Nefro Báza 1 ha 387 articoli e 1.745 pagine. Il compendio condensa gli stessi articoli in un abstract, da quattro a sette punti e una sintesi di sedici capitoli, 261 pagine in tutto. Il 6 ottobre 2026 Kindle Direct Publishing ha confermato che l’edizione inglese era nel Kindle Store. Ho smesso di prendere l’ampiezza come misura dell’utilità.',
            'content' => <<<'HTML'
<p>All’inizio di ottobre 2026 ho fatto dell’archivio di articoli di Nefro-projekt Slovensko una pubblicazione con più di un ingresso. L’edizione slovacca integrale di SK Nefro Báza 1 ha 387 articoli e 1.745 pagine.</p>
<p>Il compendio è costruito diversamente. Di ciascuno dei 387 articoli restano un abstract e da quattro a sette punti. Ognuno dei 16 capitoli si apre con una sintesi. Il tutto sta in 261 pagine.</p>
<p>Il 6 ottobre Kindle Direct Publishing ha confermato che l’edizione inglese è nel Kindle Store.</p>
<p>Nel volume intero l’articolo resta intero. Il compendio ne lascia un ingresso. Chi cerca il testo intero prende il primo. Chi vuole capire di che cosa parla l’annata prende il secondo.</p>
<p>Si è aggiunta anche una sezione <a href="https://nefro.polascin.net/publikacie.php">Pubblicazioni</a>. Vi si sceglie il formato e si passa per un ordine. Questo ha richiesto condizioni di vendita e un’informativa sulla privacy. Non è bastato caricare un PDF.</p>
<p>Nel fare un prodotto da un archivio ho smesso di prendere l’ampiezza come misura dell’utilità. Conta che cosa qualcuno deve leggere. L’estensione del file non lo decide.</p>
<p><em>Decisione personale sulle mie pubblicazioni. Il testo non indica ricavi né pagamenti.</em></p>

HTML,
        ],
        'uk' => [
            'title' => 'Найбільша версія не обов’язково найкорисніша.',
            'image_alt' => 'Чоловік зі спини сидить уночі за темним столом. Перед ним висока стопка паперу світиться фіолетовим і бірюзовим, а збоку лежить тонка розгорнута книга з бірюзовим світлом.',
            'excerpt' => 'Повне словацьке видання SK Nefro Báza 1 має 387 статей і 1 745 сторінок. Компендіум стискає ті самі статті до анотації, від чотирьох до семи пунктів і синтезу шістнадцяти розділів, разом 261 сторінка. 6 жовтня 2026 року Kindle Direct Publishing підтвердив, що англійське видання є в Kindle Store. Я перестав брати обсяг за міру користі.',
            'content' => <<<'HTML'
<p>На початку жовтня 2026 року я зробив з архіву статей Nefro-projekt Slovensko публікацію, до якої веде кілька входів. Повне словацьке видання SK Nefro Báza 1 має 387 статей і 1 745 сторінок.</p>
<p>Компендіум складено інакше. Від кожної з цих 387 статей лишилися анотація і від чотирьох до семи пунктів. Кожен із 16 розділів відкриває синтез. Вийшло 261 сторінка.</p>
<p>6 жовтня Kindle Direct Publishing підтвердив, що англійське видання є в Kindle Store.</p>
<p>Повний том лишає статтю цілком. Компендіум лишає з неї вхід. Хто потребує повного тексту, бере перше. Хто хоче з’ясувати, про що річник, бере друге.</p>
<p>Додалася й окрема частина <a href="https://nefro.polascin.net/publikacie.php">Публікації</a>. У ній можна обрати формат і пройти замовлення. Для цього знадобилися умови продажу та повідомлення про захист даних. Завантажити PDF було замало.</p>
<p>Складаючи продукт з архіву, я перестав брати обсяг за міру користі. Вирішує те, що кому треба прочитати. Розширення файлу цього не вирішує.</p>
<p><em>Особисте рішення про власні публікації. Текст не наводить ані виручки, ані платежів.</em></p>

HTML,
        ],
    ],
];
