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
 * Menšia suma nie je zľava.
 * Koniec októbra 2026: výrobné ponuky na tlač trilera Marža z krvi.
 * Prvá balíková ponuka 1 631 EUR, užší rozsah (vlastné PDF, bez e-knihy,
 * 270 strán) 320 EUR. Firma a kontakt sú fiktívne náhrady (Nordgraf, Hana Belanová).
 * Bez podpísanej dohody; doplňujúca správa 27. 10. 2026 nie je objednávka.
 */
return [
    'slug' => 'mensia-suma-nie-je-zlava',
    'author' => 'MUDr. Ľubomír Polaščín',
    'category' => 'blog',
    'is_top' => 0,
    'published_at' => '2026-11-01 08:48:00',
    'image' => 'images/articles/mensia-suma-nie-je-zlava.webp',
    'translations' => [
        'sk' => [
            'title' => 'Menšia suma nie je zľava',
            'image_alt' => 'Na fialovom stole leží hrubý zapečatený balík a tenký otvorený priečinok listov. Medzi nimi váhy naklonené k tenšiemu priečinku, ktorý osvetľuje tyrkysový lúč.',
            'excerpt' => 'Ponuka na výrobu klesla z 1 631 na 320 eur. Zmenil sa rozsah a zodpovednosť, nie zázračná cena. Technickú prípravu súborov by som niesol sám a podiel po predaji ešte nebol spočítaný na konkrétnych číslach.',
            'content' => <<<'HTML'
<p>Koncom októbra 2026 som prechádzal výrobné možnosti pre slovenský triler Marža z krvi.</p>
<p>Prvá balíková ponuka od firmy Nordgraf bola 1&nbsp;631&nbsp;eur. Po rozhovore o užšej službe, pri ktorej dodám vlastné PDF, vypustíme služby e-knihy a opravíme počet strán na 270, klesla ponuka tlače a distribúcie na 320&nbsp;eur.</p>
<p>Iný rozsah. Iné povinnosti. Nie ten istý produkt za zázračnú cenu.</p>
<p>Jedna vec vážila zvlášť. Hana Belanová z Nordgrafu potvrdila, že firma nebude kontrolovať technickú prípravu mojich súborov. Tá zodpovednosť ostane na mne.</p>
<p>Nižší vstupný poplatok ešte neuzavrel ekonómiu predaja jedného výtlačku. V správach bol podiel autora opísaný rôzne, preto som žiadal prepočítané príklady so všetkými zrážkami.</p>
<p>Dvadsiateho siedmeho októbra som poslal doplňujúcu správu: prepočty, potvrdenie papiera a rozmerov obálky, fyzický náhľad, desať autorských výtlačkov a samostatnú cenu e-knihy. Výslovne som napísal, že správa nie je záväzná objednávka ani súhlas so začatím platenej práce.</p>
<p>Podpísaná dohoda ešte nie je. Je len omnoho jasnejšie rozhodnutie.</p>
<p>Číslo v záhlaví nestačí. Treba pomenovať, čo z balíka zmizne, ktoré riziká prejdú na mňa a čo ostane splatné po každom predaji.</p>
<p><em>Osobná skúsenosť z prípravy vydania. Nie je to obchodná ani právna rada. Názov firmy a meno kontaktu sú fiktívne náhrady.</em></p>

HTML,
        ],
        'en' => [
            'title' => 'A smaller quote is not a discount',
            'image_alt' => 'On a violet desk lie a thick sealed package and a slim open folder of sheets. Between them a balance scale tips toward the thinner folder, lit by a teal beam.',
            'excerpt' => 'A production quote fell from EUR 1,631 to EUR 320. The scope and the responsibilities changed, not a miraculous price. I would carry the technical file checks myself, and the share after each sale was still not worked out in concrete figures.',
            'content' => <<<'HTML'
<p>At the end of October 2026 I worked through production options for the Slovak thriller Marža z krvi.</p>
<p>The first package quote from Nordgraf was EUR&nbsp;1,631. After discussing a narrower service where I supply my own PDF, dropping ebook services, and correcting the page count to 270, the print-and-distribution offer became EUR&nbsp;320.</p>
<p>Different scope. Different responsibilities. Not the same product at a miraculous price.</p>
<p>One detail weighed especially. Hana Belanová of Nordgraf confirmed that the firm would not check the technical preparation of my files. That responsibility would stay with me.</p>
<p>A lower entry fee still did not settle the economics of selling each copy. The messages described the author’s share differently, so I asked for worked examples showing every deduction.</p>
<p>On 27 October I sent a follow-up requesting those calculations, confirmation of paper and cover dimensions, a physical proof, ten author copies, and separate ebook pricing. I wrote explicitly that the message was not a binding order or permission to begin paid work.</p>
<p>No signed deal yet. Just a much clearer decision.</p>
<p>The headline number is not enough. Name what disappears from the package, which risks move to me, and what remains payable after each sale.</p>
<p><em>Personal experience from preparing a publication. Not commercial or legal advice. The company name and contact name are fictional substitutes.</em></p>

HTML,
        ],
        'cs' => [
            'title' => 'Menší částka není sleva',
            'image_alt' => 'Na fialovém stole leží tlustý zapečetěný balík a tenký otevřený pořadač listů. Mezi nimi váhy nakloněné k tenčímu pořadači, který osvětluje tyrkysový paprsek.',
            'excerpt' => 'Nabídka na výrobu klesla z 1 631 na 320 eur. Změnil se rozsah a odpovědnost, ne zázračná cena. Technickou přípravu souborů bych nesl sám a podíl po prodeji ještě nebyl spočítaný na konkrétních číslech.',
            'content' => <<<'HTML'
<p>Koncem října 2026 jsem procházel výrobní možnosti pro slovenský thriller Marža z krvi.</p>
<p>První balíková nabídka od firmy Nordgraf byla 1&nbsp;631&nbsp;eur. Po rozhovoru o užší službě, při které dodám vlastní PDF, vypustíme služby e-knihy a opravíme počet stran na 270, klesla nabídka tisku a distribuce na 320&nbsp;eur.</p>
<p>Jiný rozsah. Jiné povinnosti. Ne tentýž produkt za zázračnou cenu.</p>
<p>Jedna věc vážila zvlášť. Hana Belanová z Nordgrafu potvrdila, že firma nebude kontrolovat technickou přípravu mých souborů. Ta odpovědnost zůstane na mně.</p>
<p>Nižší vstupní poplatek ještě neuzavřel ekonomiku prodeje jednoho výtisku. Ve zprávách byl podíl autora popsán různě, proto jsem žádal přepočítané příklady se všemi srážkami.</p>
<p>Dvacátého sedmého října jsem poslal doplňující zprávu: přepočty, potvrzení papíru a rozměrů obálky, fyzický náhled, deset autorských výtisků a samostatnou cenu e-knihy. Výslovně jsem napsal, že zpráva není závazná objednávka ani souhlas se zahájením placené práce.</p>
<p>Podepsaná dohoda ještě není. Je jen mnohem jasnější rozhodnutí.</p>
<p>Číslo v záhlaví nestačí. Je třeba pojmenovat, co z balíku zmizí, která rizika přejdou na mě a co zůstane splatné po každém prodeji.</p>
<p><em>Osobní zkušenost z přípravy vydání. Není to obchodní ani právní rada. Název firmy a jméno kontaktu jsou fiktivní náhrady.</em></p>

HTML,
        ],
        'de' => [
            'title' => 'Eine kleinere Summe ist kein Rabatt',
            'image_alt' => 'Auf einem violetten Tisch liegen ein dickes versiegeltes Paket und ein schmaler offener Hefter mit Blättern. Dazwischen eine Waage, die zum schmaleren Hefter kippt, den ein türkiser Strahl beleuchtet.',
            'excerpt' => 'Ein Produktionsangebot fiel von 1.631 auf 320 Euro. Geändert haben sich Umfang und Verantwortung, nicht ein Wunderpreis. Die technische Dateiprüfung trüge ich selbst, und der Anteil nach jedem Verkauf war noch nicht in konkreten Zahlen durchgerechnet.',
            'content' => <<<'HTML'
<p>Ende Oktober 2026 habe ich Produktionsoptionen für den slowakischen Thriller Marža z krvi durchgearbeitet.</p>
<p>Das erste Paketangebot von Nordgraf lag bei 1.631&nbsp;Euro. Nach dem Gespräch über einen engeren Service, bei dem ich mein eigenes PDF liefere, E-Book-Dienste entfallen und die Seitenzahl auf 270 korrigiert wird, wurde das Angebot für Druck und Vertrieb 320&nbsp;Euro.</p>
<p>Anderer Umfang. Andere Pflichten. Nicht dasselbe Produkt zu einem Wunderpreis.</p>
<p>Ein Detail wog besonders. Hana Belanová von Nordgraf bestätigte, dass die Firma die technische Vorbereitung meiner Dateien nicht prüfen werde. Diese Verantwortung bleibe bei mir.</p>
<p>Die niedrigere Einstiegsgebühr klärte noch nicht die Wirtschaftlichkeit des Verkaufs eines Exemplars. In den Nachrichten war der Autorenanteil unterschiedlich beschrieben, deshalb bat ich um durchgerechnete Beispiele mit allen Abzügen.</p>
<p>Am 27. Oktober schickte ich eine Nachricht mit der Bitte um diese Berechnungen, die Bestätigung von Papier und Covermaßen, einen physischen Proof, zehn Autorenexemplare und eine separate E-Book-Preisangabe. Ich schrieb ausdrücklich, dass die Nachricht keine verbindliche Bestellung und keine Freigabe für bezahlte Arbeit sei.</p>
<p>Noch kein unterzeichneter Vertrag. Nur eine deutlich klarere Entscheidung.</p>
<p>Die Zahl in der Überschrift reicht nicht. Benennen, was aus dem Paket verschwindet, welche Risiken zu mir wandern und was nach jedem Verkauf zahlbar bleibt.</p>
<p><em>Persönliche Erfahrung aus der Vorbereitung einer Veröffentlichung. Keine Geschäfts- oder Rechtsberatung. Firmenname und Kontaktname sind fiktive Ersatzbezeichnungen.</em></p>

HTML,
        ],
        'fr' => [
            'title' => 'Une somme plus basse n’est pas une remise',
            'image_alt' => 'Sur une table violette, un épais colis scellé et un mince dossier ouvert de feuilles. Entre eux, une balance penche vers le dossier plus mince, éclairé par un rayon turquoise.',
            'excerpt' => 'Un devis de fabrication est passé de 1 631 à 320 euros. Ce qui a changé, c’est le périmètre et la responsabilité, pas un prix miraculeux. Je porterais moi-même le contrôle technique des fichiers, et la part après chaque vente n’était pas encore chiffrée.',
            'content' => <<<'HTML'
<p>Fin octobre 2026, j’ai passé en revue les options de fabrication pour le thriller slovaque Marža z krvi.</p>
<p>Le premier devis forfaitaire de Nordgraf était de 1&nbsp;631&nbsp;euros. Après discussion d’un service plus étroit où je fournis mon propre PDF, sans services d’e-book, et avec un tirage corrigé à 270 pages, l’offre d’impression et de distribution est devenue 320&nbsp;euros.</p>
<p>Autre périmètre. Autres responsabilités. Pas le même produit à un prix miraculeux.</p>
<p>Un détail pesait surtout. Hana Belanová, de Nordgraf, a confirmé que la société ne vérifierait pas la préparation technique de mes fichiers. Cette responsabilité resterait la mienne.</p>
<p>Des frais d’entrée plus bas ne réglaient pas encore l’économie de la vente d’un exemplaire. Les messages décrivaient la part d’auteur de façons différentes, aussi ai-je demandé des exemples chiffrés avec toutes les déductions.</p>
<p>Le 27 octobre, j’ai envoyé un message de suivi demandant ces calculs, la confirmation du papier et des dimensions de couverture, une épreuve physique, dix exemplaires d’auteur et un tarif e-book séparé. J’ai écrit explicitement que le message n’était ni une commande ferme ni une autorisation de commencer un travail payant.</p>
<p>Pas encore d’accord signé. Seulement une décision beaucoup plus claire.</p>
<p>Le chiffre en tête de page ne suffit pas. Il faut nommer ce qui disparaît du forfait, quels risques passent chez moi, et ce qui reste dû après chaque vente.</p>
<p><em>Expérience personnelle de préparation d’une publication. Ce n’est ni un conseil commercial ni un avis juridique. Le nom de la société et celui du contact sont des substituts fictifs.</em></p>

HTML,
        ],
        'es' => [
            'title' => 'Una cifra menor no es un descuento',
            'image_alt' => 'Sobre una mesa violeta hay un paquete grueso sellado y una carpeta delgada abierta con hojas. Entre ellos, una balanza se inclina hacia la carpeta más fina, iluminada por un haz turquesa.',
            'excerpt' => 'Un presupuesto de producción bajó de 1.631 a 320 euros. Cambiaron el alcance y la responsabilidad, no un precio milagroso. Yo llevaría la revisión técnica de los archivos, y la parte tras cada venta aún no estaba calculada con cifras concretas.',
            'content' => <<<'HTML'
<p>A finales de octubre de 2026 revisé las opciones de producción del thriller eslovaco Marža z krvi.</p>
<p>El primer presupuesto en paquete de Nordgraf fue de 1.631&nbsp;euros. Tras hablar de un servicio más estrecho en el que aporto mi propio PDF, se suprimen los servicios de libro electrónico y se corrige el número de páginas a 270, la oferta de impresión y distribución pasó a 320&nbsp;euros.</p>
<p>Otro alcance. Otras responsabilidades. No el mismo producto a un precio milagroso.</p>
<p>Un detalle pesó especialmente. Hana Belanová, de Nordgraf, confirmó que la empresa no comprobaría la preparación técnica de mis archivos. Esa responsabilidad seguiría siendo mía.</p>
<p>Una tasa de entrada más baja aún no cerraba la economía de vender cada ejemplar. En los mensajes la parte del autor se describía de modos distintos, así que pedí ejemplos calculados con todas las deducciones.</p>
<p>El 27 de octubre envié un seguimiento pidiendo esos cálculos, la confirmación del papel y de las medidas de la cubierta, una prueba física, diez ejemplares de autor y un precio aparte del libro electrónico. Escribí explícitamente que el mensaje no era un pedido vinculante ni permiso para empezar trabajo de pago.</p>
<p>Aún no hay acuerdo firmado. Solo una decisión mucho más clara.</p>
<p>La cifra del encabezado no basta. Hay que nombrar qué desaparece del paquete, qué riesgos pasan a mí y qué sigue siendo pagadero tras cada venta.</p>
<p><em>Experiencia personal al preparar una publicación. No es consejo comercial ni jurídico. El nombre de la empresa y el del contacto son sustitutos ficticios.</em></p>

HTML,
        ],
        'pl' => [
            'title' => 'Mniejsza kwota to nie rabat',
            'image_alt' => 'Na fioletowym stole leży gruby zapieczętowany pakiet i cienki otwarty skoroszyt z kartkami. Między nimi waga przechylona ku cieńszemu skoroszytowi, oświetlonemu turkusowym promieniem.',
            'excerpt' => 'Oferta produkcji spadła z 1631 do 320 euro. Zmienił się zakres i odpowiedzialność, nie cudowna cena. Techniczne przygotowanie plików miałbym na sobie, a udział po sprzedaży nie był jeszcze policzony na konkretnych liczbach.',
            'content' => <<<'HTML'
<p>Pod koniec października 2026 przechodziłem opcje produkcji słowackiego thrillera Marža z krvi.</p>
<p>Pierwsza oferta pakietowa od firmy Nordgraf wynosiła 1&nbsp;631&nbsp;euro. Po rozmowie o węższym zakresie, w którym dostarczam własne PDF, pomijamy usługi e-booka i poprawiamy liczbę stron do 270, oferta druku i dystrybucji spadła do 320&nbsp;euro.</p>
<p>Inny zakres. Inne obowiązki. Nie ten sam produkt za cudowną cenę.</p>
<p>Jeden szczegół ważył szczególnie. Hana Belanová z Nordgrafu potwierdziła, że firma nie będzie sprawdzała technicznego przygotowania moich plików. Ta odpowiedzialność zostanie przy mnie.</p>
<p>Niższa opłata wstępna nie domykała jeszcze ekonomii sprzedaży jednego egzemplarza. W wiadomościach udział autora opisano różnie, dlatego prosiłem o wyliczone przykłady ze wszystkimi potrąceniami.</p>
<p>Dwudziestego siódmego października wysłałem uzupełniającą wiadomość: wyliczenia, potwierdzenie papieru i wymiarów okładki, fizyczny proof, dziesięć egzemplarzy autorskich oraz osobną cenę e-booka. Wyraźnie napisałem, że wiadomość nie jest wiążącym zamówieniem ani zgodą na rozpoczęcie płatnej pracy.</p>
<p>Podpisanej umowy jeszcze nie ma. Jest tylko znacznie jaśniejsza decyzja.</p>
<p>Liczba w nagłówku nie wystarczy. Trzeba nazwać, co znika z pakietu, które ryzyka przechodzą na mnie i co pozostaje do zapłaty po każdej sprzedaży.</p>
<p><em>Osobiste doświadczenie z przygotowania wydania. To nie porada handlowa ani prawna. Nazwa firmy i imię kontaktu to fikcyjne zamienniki.</em></p>

HTML,
        ],
        'hu' => [
            'title' => 'A kisebb összeg nem kedvezmény',
            'image_alt' => 'Ibolyaszínű asztalon egy vastag lepecsételt csomag és egy vékony, nyitott iratgyűjtő lapokkal. Közöttük egy mérleg a vékonyabb gyűjtő felé billen, amelyet türkiz sugár világít meg.',
            'excerpt' => 'A gyártási ajánlat 1631 euróról 320-ra esett. A hatókör és a felelősség változott, nem a csodaár. A fájlok technikai ellenőrzését én vinném, és az eladásonkénti részesedés még nem volt konkrét számokra lebontva.',
            'content' => <<<'HTML'
<p>2026 októberének végén a szlovák thriller, a Marža z krvi gyártási lehetőségeit jártam végig.</p>
<p>A Nordgraf első csomagajánlata 1&nbsp;631&nbsp;euró volt. Miután egy szűkebb szolgáltatásról beszéltem, amelyben saját PDF-et adok, elhagyjuk az e-könyv szolgáltatásokat, és az oldalszámot 270-re javítjuk, a nyomtatás és terjesztés ajánlata 320&nbsp;euróra csökkent.</p>
<p>Más hatókör. Más kötelezettségek. Nem ugyanaz a termék csodaáron.</p>
<p>Egy részlet különösen sokat nyomott. Hana Belanová a Nordgraf részéről megerősítette, hogy a cég nem ellenőrzi a fájljaim technikai előkészítését. Ez a felelősség nálam marad.</p>
<p>Az alacsonyabb belépő díj még nem zárta le egy példány eladásának gazdaságát. Az üzenetekben a szerzői részesedés eltérően szerepelt, ezért minden levonást bemutató, kiszámolt példákat kértem.</p>
<p>Október 27-én kiegészítő üzenetet küldtem: a számításokat, a papír és a borító méreteinek megerősítését, fizikai proofot, tíz szerzői példányt és külön e-könyvárat. Kifejezetten leírtam, hogy az üzenet nem kötelező megrendelés és nem engedély fizetett munka megkezdésére.</p>
<p>Aláírt megállapodás még nincs. Csak sokkal tisztább döntés.</p>
<p>A fejléc száma nem elég. Meg kell nevezni, mi tűnik el a csomagból, mely kockázatok kerülnek hozzám, és mi marad fizetendő minden eladás után.</p>
<p><em>Személyes tapasztalat egy kiadvány előkészítéséből. Nem üzleti és nem jogi tanács. A cégnév és a kapcsolattartó neve fiktív helyettesítők.</em></p>

HTML,
        ],
        'it' => [
            'title' => 'Una cifra più bassa non è uno sconto',
            'image_alt' => 'Su un tavolo violetto ci sono un pacco spesso sigillato e una cartellina sottile aperta con fogli. Tra di essi una bilancia pende verso la cartellina più sottile, illuminata da un raggio turchese.',
            'excerpt' => 'Un preventivo di produzione è sceso da 1.631 a 320 euro. Sono cambiati portata e responsabilità, non un prezzo miracoloso. Il controllo tecnico dei file resterebbe a me, e la quota dopo ogni vendita non era ancora calcolata in cifre concrete.',
            'content' => <<<'HTML'
<p>A fine ottobre 2026 ho esaminato le opzioni di produzione per il thriller slovacco Marža z krvi.</p>
<p>Il primo preventivo a pacchetto di Nordgraf era di 1.631&nbsp;euro. Dopo aver discusso un servizio più ristretto in cui fornisco il mio PDF, senza servizi ebook, e con il numero di pagine corretto a 270, l’offerta di stampa e distribuzione è diventata 320&nbsp;euro.</p>
<p>Portata diversa. Responsabilità diverse. Non lo stesso prodotto a un prezzo miracoloso.</p>
<p>Un dettaglio pesava in particolare. Hana Belanová di Nordgraf ha confermato che l’azienda non avrebbe controllato la preparazione tecnica dei miei file. Quella responsabilità resterebbe a me.</p>
<p>Una tariffa d’ingresso più bassa non chiudeva ancora l’economia della vendita di ogni copia. Nei messaggi la quota dell’autore era descritta in modi diversi, perciò ho chiesto esempi calcolati con ogni detrazione.</p>
<p>Il 27 ottobre ho inviato un seguito chiedendo quei calcoli, la conferma della carta e delle misure di copertina, una prova fisica, dieci copie d’autore e un prezzo ebook separato. Ho scritto esplicitamente che il messaggio non era un ordine vincolante né un’autorizzazione ad avviare lavoro a pagamento.</p>
<p>Nessun accordo firmato ancora. Solo una decisione molto più chiara.</p>
<p>La cifra in intestazione non basta. Bisogna nominare cosa scompare dal pacchetto, quali rischi passano a me e cosa resta dovuto dopo ogni vendita.</p>
<p><em>Esperienza personale dalla preparazione di una pubblicazione. Non è consiglio commerciale né legale. Il nome dell’azienda e quello del contatto sono sostituti fittizi.</em></p>

HTML,
        ],
        'uk' => [
            'title' => 'Менша сума це не знижка',
            'image_alt' => 'На фіолетовому столі лежать товстий запечатаний пакет і тонка відкрита тека з аркушами. Між ними терези схиляються до тоншої теки, освітленої бірюзовим променем.',
            'excerpt' => 'Пропозиція на виробництво впала з 1631 до 320 євро. Змінилися обсяг і відповідальність, не дивовижна ціна. Технічну перевірку файлів ніс би я, а частку після кожного продажу ще не порахували в конкретних цифрах.',
            'content' => <<<'HTML'
<p>Наприкінці жовтня 2026 року я розглядав варіанти виробництва словацького трилера Marža z krvi.</p>
<p>Перша пакетна пропозиція від Nordgraf становила 1&nbsp;631&nbsp;євро. Після розмови про вужчу послугу, де я надаю власний PDF, без послуг електронної книги і з виправленою кількістю сторінок до 270, пропозиція друку й дистрибуції стала 320&nbsp;євро.</p>
<p>Інший обсяг. Інші обов’язки. Не той самий продукт за дивовижною ціною.</p>
<p>Одна деталь важила особливо. Гана Беланова з Nordgraf підтвердила, що фірма не перевірятиме технічну підготовку моїх файлів. Ця відповідальність лишиться на мені.</p>
<p>Нижчий вступний платіж ще не закрив економіку продажу одного примірника. У повідомленнях частку автора описували по-різному, тож я просив пораховані приклади з усіма відрахуваннями.</p>
<p>Двадцять сьомого жовтня я надіслав додаткове повідомлення: розрахунки, підтвердження паперу й розмірів обкладинки, фізичний пруф, десять авторських примірників і окрему ціну електронної книги. Я прямо написав, що повідомлення не є зобов’язальним замовленням і не дозволом починати платну роботу.</p>
<p>Підписаної угоди ще немає. Є лише набагато ясніше рішення.</p>
<p>Числа в заголовку недостатньо. Треба назвати, що зникає з пакета, які ризики переходять до мене і що лишається до сплати після кожного продажу.</p>
<p><em>Особистий досвід підготовки видання. Це не комерційна й не юридична порада. Назва фірми та ім’я контакту є вигаданими замінниками.</em></p>

HTML,
        ],
    ],
];
