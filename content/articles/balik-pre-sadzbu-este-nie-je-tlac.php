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
 * Balík pre sadzbu ešte nie je tlačená kniha.
 * 20. 10. 2026: päť súborov firme Publico na cenovú ponuku sadzby,
 * vnútro A5, 270 strán, 59 ilustrácií v odtieňoch sivej. Žiadosť, nie zmluva.
 * Katalóg e-knihy overený 28. 10. 2026: vydanie 18. 10. 2026, 298 strán,
 * 59 ilustrácií, predaj e-knihy. ISBN v katalógu od 22. 10. 2026.
 */
return [
    'slug' => 'balik-pre-sadzbu-este-nie-je-tlac',
    'author' => 'MUDr. Ľubomír Polaščín',
    'category' => 'blog',
    'is_top' => 0,
    'published_at' => '2026-10-28 00:48:00',
    'image' => 'images/articles/balik-pre-sadzbu-este-nie-je-tlac.webp',
    'translations' => [
        'sk' => [
            'title' => 'Balík pre sadzbu ešte nie je tlačená kniha',
            'image_alt' => 'Na tmavom stole sú tri predmety: vľavo kôpka svetlých listov, v strede svietiaca tyrkysová doska, vpravo neviazaný blok so sivou kresbou vetvičky, fialová doska a tenké tyrkysové pravítko.',
            'excerpt' => '20. októbra 2026 odišiel firme Publico balík na sadzbu knihy Marža z krvi. Päť súborov, vnútro A5 so 270 stranami a 59 ilustráciami v odtieňoch sivej. Išlo o žiadosť o cenu, nie o zmluvu. E-kniha už mala dátum vydania a ISBN prišli o dva dni.',
            'content' => <<<'HTML'
<p>20. októbra 2026 som firme <a href="https://www.publico.sk/">Publico</a> poslal podklady na cenovú ponuku sadzby slovenského trilera Marža z krvi.</p>
<p>V balíku bol rukopis vo formáte DOCX, vnútorná časť ako PDF na formát A5 a súbory obálky. Spolu päť výrobných súborov. Pripravené vnútro má 270 strán a 59 ilustrácií v odtieňoch sivej. Išlo o žiadosť o cenu, nie o podpísanú výrobnú zmluvu. Žiadosti o ISBN pre digitálne vydanie a pre tlač ešte nemali pridelené čísla.</p>
<p>E-kniha je v <a href="https://nefro.polascin.net/publikacia.php?slug=marza-z-krvi">katalógu</a> vedená ako vydanie z 18. októbra a má uvedených 298 strán, tiež s 59 ilustráciami. Čísla 270 a 298 nie sú dva zápisy toho istého rozsahu. Jedno patrí vnútru A5 v balíku pre sadzbu, druhé patrí katalógu e-knihy. 22. októbra čísla pridelila Národná agentúra ISBN v SR. V katalógu sú zapísané takto: PDF 978-80-570-8831-8, EPUB 978-80-570-8832-5 a brožovaná väzba 978-80-570-8830-1. Stránka, ktorá knihu predáva, ponúka e-knihu. Číslo pre brožovanú väzbu samo osebe neznamená, že tlačiareň zákazku prevzala.</p>
<p>Názov je jeden a cieľové čiary sú tri. Príbeh môže byť dopísaný. Súbor sa dá čítať a predávať. Agentúra môže prideliť číslo. V deň, keď balík odišiel, ostávali pri tlači otvorené iné veci: väzba, šírka chrbta, rozlíšenie obrázkov a to, čo dodávateľ od súborov chce. Pekné PDF tieto veci nepotvrdí. Dobrá záverečná kapitola nenahradí nevhodný súbor obálky.</p>
<p>Medzník z 20. októbra teda nie je veta, že kniha vyšla. E-kniha svoj dátum už mala. Tlač mala balík a otázku na cenu. Hotový text držím oddelene od hotovej výroby, aby cieľová čiara, pri ktorej ešte nie je čo vyrobiť, nevyzerala ako skončená práca.</p>

HTML,
        ],
        'en' => [
            'title' => 'A typesetting package is not yet a printed book',
            'image_alt' => 'On a dark table are three objects: a stack of pale sheets on the left, a glowing teal slab in the center, and on the right an unbound block with a gray drawing of a sprig, a purple board and a thin teal ruler.',
            'excerpt' => 'On 20 October 2026 a package for the typesetting of Marža z krvi went to Publico. Five files, an A5 interior of 270 pages and 59 grayscale illustrations. It was a request for a price, not a contract. The ebook already had a publication date, and the ISBNs came two days later.',
            'content' => <<<'HTML'
<p>On 20 October 2026 I sent <a href="https://www.publico.sk/">Publico</a> the files for a typesetting quote for the Slovak thriller Marža z krvi.</p>
<p>The package held the manuscript as a DOCX file, the interior as an A5 PDF, and the cover files. Five production files in all. The prepared interior has 270 pages and 59 grayscale illustrations. That day it was a request for a price, not a signed production contract. The ISBN requests for the digital edition and for print did not yet have numbers assigned.</p>
<p>The ebook is listed in the <a href="https://nefro.polascin.net/publikacia.php?slug=marza-z-krvi">catalogue</a> as an edition of 18 October, with 298 pages and the same 59 illustrations. The figures 270 and 298 are not two records of one count. One belongs to the A5 interior in the typesetting package, the other belongs to the ebook catalogue. On 22 October the National ISBN Agency in the Slovak Republic assigned the numbers. The catalogue records them as PDF 978-80-570-8831-8, EPUB 978-80-570-8832-5, and paperback 978-80-570-8830-1. The page that sells the book offers the ebook. A number for a paperback does not, by itself, mean a printer has taken the job.</p>
<p>The title is one, and the finish lines are three. The story can be finished. A file can be read and sold. An agency can assign a number. On the day the package went out, other things about the print were still open: the binding, the spine width, the image resolution, and what the supplier requires of the files. A handsome PDF does not confirm those things. A good final chapter does not make up for an unsuitable cover file.</p>
<p>The step of 20 October is therefore not the sentence that the book has come out. The ebook already had its date. The print had a package and a question about the price. I keep the finished text apart from finished production, so that a finish line where there is still nothing to manufacture does not look like work that is done.</p>

HTML,
        ],
        'cs' => [
            'title' => 'Balík pro sazbu ještě není tištěná kniha',
            'image_alt' => 'Na tmavém stole jsou tři předměty: vlevo hromádka světlých listů, uprostřed svítící tyrkysová deska, vpravo nevázaný blok se šedou kresbou větvičky, fialová deska a tenké tyrkysové pravítko.',
            'excerpt' => '20. října 2026 odešel firmě Publico balík k sazbě knihy Marža z krvi. Pět souborů, vnitřek A5 o 270 stranách a 59 ilustracích v odstínech šedi. Šlo o žádost o cenu, ne o smlouvu. E-kniha už měla datum vydání a čísla ISBN přišla o dva dny později.',
            'content' => <<<'HTML'
<p>20. října 2026 jsem firmě <a href="https://www.publico.sk/">Publico</a> poslal podklady k cenové nabídce sazby slovenského thrilleru Marža z krvi.</p>
<p>V balíku byl rukopis ve formátu DOCX, vnitřní část jako PDF na formát A5 a soubory obálky. Dohromady pět výrobních souborů. Připravený vnitřek má 270 stran a 59 ilustrací v odstínech šedi. Šlo o žádost o cenu, ne o podepsanou výrobní smlouvu. Žádosti o ISBN pro digitální vydání a pro tisk ještě neměly přidělená čísla.</p>
<p>E-kniha je v <a href="https://nefro.polascin.net/publikacia.php?slug=marza-z-krvi">katalogu</a> vedena jako vydání z 18. října a má uvedených 298 stran, také s 59 ilustracemi. Čísla 270 a 298 nejsou dva zápisy téhož rozsahu. Jedno patří vnitřku A5 v balíku pro sazbu, druhé patří katalogu e-knihy. 22. října čísla přidělila Národní agentura ISBN ve Slovenské republice. V katalogu jsou zapsána takto: PDF 978-80-570-8831-8, EPUB 978-80-570-8832-5 a brožovaná vazba 978-80-570-8830-1. Stránka, která knihu prodává, nabízí e-knihu. Číslo pro brožovanou vazbu samo o sobě neznamená, že tiskárna zakázku převzala.</p>
<p>Název je jeden a cílové čáry jsou tři. Příběh může být dopsaný. Soubor se dá číst a prodávat. Agentura může přidělit číslo. V den, kdy balík odešel, zůstávaly u tisku otevřené jiné věci: vazba, šířka hřbetu, rozlišení obrázků a to, co dodavatel od souborů chce. Hezké PDF tyto věci nepotvrdí. Dobrá závěrečná kapitola nenahradí nevhodný soubor obálky.</p>
<p>Mezník z 20. října tedy není věta, že kniha vyšla. E-kniha své datum už měla. Tisk měl balík a otázku na cenu. Hotový text držím odděleně od hotové výroby, aby cílová čára, u které ještě není co vyrábět, nevypadala jako skončená práce.</p>

HTML,
        ],
        'de' => [
            'title' => 'Ein Satzpaket ist noch kein gedrucktes Buch',
            'image_alt' => 'Auf einem dunklen Tisch stehen drei Dinge: links ein Stapel heller Blätter, in der Mitte eine leuchtende türkise Platte, rechts ein ungebundener Block mit einer grauen Zweigzeichnung, eine violette Platte und ein dünnes türkises Lineal.',
            'excerpt' => 'Am 20. Oktober 2026 ging an Publico ein Paket für den Satz von Marža z krvi. Fünf Dateien, ein A5-Innenteil mit 270 Seiten und 59 Graustufenillustrationen. Es war eine Preisanfrage, kein Vertrag. Das E-Book hatte schon ein Erscheinungsdatum, die ISBN kamen zwei Tage später.',
            'content' => <<<'HTML'
<p>Am 20. Oktober 2026 habe ich <a href="https://www.publico.sk/">Publico</a> die Unterlagen für ein Satzangebot zum slowakischen Thriller Marža z krvi geschickt.</p>
<p>Im Paket lagen das Manuskript als DOCX, der Innenteil als PDF im Format A5 und die Coverdateien. Zusammen fünf Produktionsdateien. Der vorbereitete Innenteil hat 270 Seiten und 59 Illustrationen in Graustufen. An dem Tag war es eine Preisanfrage, kein unterschriebener Produktionsvertrag. Die ISBN-Anträge für die digitale Ausgabe und für den Druck hatten noch keine zugeteilten Nummern.</p>
<p>Das E-Book steht im <a href="https://nefro.polascin.net/publikacia.php?slug=marza-z-krvi">Katalog</a> als Ausgabe vom 18. Oktober, mit 298 Seiten und ebenfalls 59 Illustrationen. Die Zahlen 270 und 298 sind nicht zwei Einträge desselben Umfangs. Die eine gehört zum A5-Innenteil im Satzpaket, die andere zum E-Book-Katalog. Am 22. Oktober hat die nationale ISBN-Agentur in der Slowakischen Republik die Nummern vergeben. Im Katalog stehen sie so: PDF 978-80-570-8831-8, EPUB 978-80-570-8832-5 und Broschur 978-80-570-8830-1. Die Seite, die das Buch verkauft, bietet das E-Book an. Eine Nummer für die Broschur bedeutet für sich allein nicht, dass eine Druckerei den Auftrag übernommen hat.</p>
<p>Der Titel ist einer, die Ziellinien sind drei. Die Geschichte kann zu Ende geschrieben sein. Eine Datei lässt sich lesen und verkaufen. Eine Agentur kann eine Nummer vergeben. An dem Tag, als das Paket hinausging, blieb beim Druck anderes offen: die Bindung, die Rückenbreite, die Bildauflösung und das, was der Dienstleister von den Dateien verlangt. Ein schönes PDF bestätigt das nicht. Ein gutes Schlusskapitel ersetzt keine ungeeignete Coverdatei.</p>
<p>Der Schritt vom 20. Oktober ist also nicht der Satz, das Buch sei erschienen. Das E-Book hatte sein Datum schon. Der Druck hatte ein Paket und eine Frage zum Preis. Den fertigen Text halte ich von der fertigen Herstellung getrennt, damit eine Ziellinie, an der es noch nichts zu fertigen gibt, nicht wie abgeschlossene Arbeit aussieht.</p>

HTML,
        ],
        'fr' => [
            'title' => 'Un dossier de composition n’est pas encore un livre imprimé',
            'image_alt' => 'Sur une table sombre, trois objets : à gauche une pile de feuilles claires, au centre une plaque turquoise lumineuse, à droite un bloc non relié avec un dessin de rameau en gris, une planche violette et une fine règle turquoise.',
            'excerpt' => 'Le 20 octobre 2026, un dossier pour la composition de Marža z krvi est parti chez Publico. Cinq fichiers, un intérieur A5 de 270 pages et 59 illustrations en niveaux de gris. C’était une demande de prix, pas un contrat. L’e-book avait déjà une date, et les ISBN sont arrivés deux jours plus tard.',
            'content' => <<<'HTML'
<p>Le 20 octobre 2026, j’ai envoyé à <a href="https://www.publico.sk/">Publico</a> les fichiers pour un devis de composition du thriller slovaque Marža z krvi.</p>
<p>Le dossier contenait le manuscrit en DOCX, l’intérieur en PDF au format A5 et les fichiers de couverture. Cinq fichiers de fabrication en tout. L’intérieur préparé compte 270 pages et 59 illustrations en niveaux de gris. Ce jour-là, c’était une demande de prix, pas un contrat de fabrication signé. Les demandes d’ISBN pour l’édition numérique et pour l’imprimé n’avaient pas encore de numéros attribués.</p>
<p>L’e-book figure dans le <a href="https://nefro.polascin.net/publikacia.php?slug=marza-z-krvi">catalogue</a> comme une édition du 18 octobre, avec 298 pages et les mêmes 59 illustrations. Les nombres 270 et 298 ne sont pas deux relevés d’un même compte. L’un appartient à l’intérieur A5 du dossier de composition, l’autre appartient au catalogue de l’e-book. Le 22 octobre, l’agence nationale ISBN de la République slovaque a attribué les numéros. Le catalogue les inscrit ainsi : PDF 978-80-570-8831-8, EPUB 978-80-570-8832-5 et broché 978-80-570-8830-1. La page qui vend le livre propose l’e-book. Un numéro pour le broché ne signifie pas, à lui seul, qu’un imprimeur a pris la commande.</p>
<p>Le titre est un, les lignes d’arrivée sont trois. L’histoire peut être achevée. Un fichier peut se lire et se vendre. Une agence peut attribuer un numéro. Le jour où le dossier est parti, d’autres choses restaient ouvertes pour l’imprimé : la reliure, la largeur du dos, la résolution des images et ce que le prestataire exige des fichiers. Un beau PDF ne confirme pas ces points. Un bon chapitre final ne compense pas un fichier de couverture qui ne convient pas.</p>
<p>Le pas du 20 octobre n’est donc pas la phrase selon laquelle le livre est paru. L’e-book avait déjà sa date. L’imprimé avait un dossier et une question de prix. Je tiens le texte achevé à part de la fabrication achevée, pour qu’une ligne d’arrivée où il n’y a encore rien à fabriquer ne ressemble pas à un travail fini.</p>

HTML,
        ],
        'es' => [
            'title' => 'Un paquete de maquetación aún no es un libro impreso',
            'image_alt' => 'Sobre una mesa oscura hay tres objetos: a la izquierda un fajo de hojas claras, en el centro una placa turquesa luminosa y a la derecha un bloque sin encuadernar con un dibujo gris de una rama, una plancha morada y una regla turquesa fina.',
            'excerpt' => 'El 20 de octubre de 2026 salió hacia Publico un paquete para la maquetación de Marža z krvi. Cinco archivos, un interior A5 de 270 páginas y 59 ilustraciones en escala de grises. Era una petición de precio, no un contrato. El libro electrónico ya tenía fecha, y los ISBN llegaron dos días después.',
            'content' => <<<'HTML'
<p>El 20 de octubre de 2026 envié a <a href="https://www.publico.sk/">Publico</a> los archivos para un presupuesto de maquetación del thriller eslovaco Marža z krvi.</p>
<p>El paquete contenía el manuscrito en DOCX, el interior en PDF en formato A5 y los archivos de cubierta. Cinco archivos de producción en total. El interior preparado tiene 270 páginas y 59 ilustraciones en escala de grises. Ese día era una petición de precio, no un contrato de producción firmado. Las solicitudes de ISBN para la edición digital y para la impresa aún no tenían números asignados.</p>
<p>El libro electrónico figura en el <a href="https://nefro.polascin.net/publikacia.php?slug=marza-z-krvi">catálogo</a> como edición del 18 de octubre, con 298 páginas y las mismas 59 ilustraciones. Las cifras 270 y 298 no son dos registros de un mismo recuento. Una pertenece al interior A5 del paquete de maquetación y la otra pertenece al catálogo del libro electrónico. El 22 de octubre la Agencia Nacional del ISBN en la República Eslovaca asignó los números. El catálogo los anota así: PDF 978-80-570-8831-8, EPUB 978-80-570-8832-5 y rústica 978-80-570-8830-1. La página que vende el libro ofrece el libro electrónico. Un número para la rústica no significa, por sí solo, que una imprenta haya aceptado el encargo.</p>
<p>El título es uno y las líneas de meta son tres. La historia puede estar terminada. Un archivo se puede leer y vender. Una agencia puede asignar un número. El día en que salió el paquete, otras cosas de la impresión seguían abiertas: la encuadernación, el ancho del lomo, la resolución de las imágenes y lo que el proveedor exige de los archivos. Un PDF hermoso no confirma esas cosas. Un buen capítulo final no compensa un archivo de cubierta inadecuado.</p>
<p>El paso del 20 de octubre no es, por tanto, la frase de que el libro ha salido. El libro electrónico ya tenía su fecha. La impresión tenía un paquete y una pregunta por el precio. Mantengo el texto terminado aparte de la producción terminada, para que una línea de meta en la que todavía no hay nada que fabricar no parezca un trabajo acabado.</p>

HTML,
        ],
        'pl' => [
            'title' => 'Pakiet do składu to jeszcze nie drukowana książka',
            'image_alt' => 'Na ciemnym stole są trzy przedmioty: po lewej plik jasnych kartek, pośrodku świecąca turkusowa płyta, po prawej niezwiązany blok z szarym rysunkiem gałązki, fioletowa płyta i cienka turkusowa linijka.',
            'excerpt' => '20 października 2026 roku do Publico wyszedł pakiet do składu książki Marža z krvi. Pięć plików, wnętrze A5 o 270 stronach i 59 ilustracjach w odcieniach szarości. Była to prośba o cenę, nie umowa. E-book miał już datę wydania, a numery ISBN nadeszły dwa dni później.',
            'content' => <<<'HTML'
<p>20 października 2026 roku wysłałem do firmy <a href="https://www.publico.sk/">Publico</a> pliki do wyceny składu słowackiego thrillera Marža z krvi.</p>
<p>W pakiecie był rękopis w formacie DOCX, część wewnętrzna jako PDF w formacie A5 i pliki okładki. Razem pięć plików produkcyjnych. Przygotowane wnętrze ma 270 stron i 59 ilustracji w odcieniach szarości. Tego dnia była to prośba o cenę, nie podpisana umowa produkcyjna. Wnioski o ISBN dla wydania cyfrowego i dla druku nie miały jeszcze nadanych numerów.</p>
<p>E-book jest w <a href="https://nefro.polascin.net/publikacia.php?slug=marza-z-krvi">katalogu</a> prowadzony jako wydanie z 18 października i ma podane 298 stron, także z 59 ilustracjami. Liczby 270 i 298 nie są dwoma zapisami tego samego zakresu. Jedna należy do wnętrza A5 w pakiecie do składu, druga należy do katalogu e-booka. 22 października numery nadała krajowa agencja ISBN w Republice Słowackiej. W katalogu są zapisane tak: PDF 978-80-570-8831-8, EPUB 978-80-570-8832-5 i oprawa miękka 978-80-570-8830-1. Strona, która sprzedaje książkę, oferuje e-booka. Numer dla oprawy miękkiej sam w sobie nie znaczy, że drukarnia przyjęła zlecenie.</p>
<p>Tytuł jest jeden, a linie mety są trzy. Opowieść może być skończona. Plik można czytać i sprzedawać. Agencja może nadać numer. W dniu, w którym pakiet wyszedł, przy druku pozostawały otwarte inne rzeczy: oprawa, szerokość grzbietu, rozdzielczość obrazów i to, czego dostawca wymaga od plików. Ładny plik PDF tego nie potwierdzi. Dobry rozdział końcowy nie zastąpi nieodpowiedniego pliku okładki.</p>
<p>Krok z 20 października nie jest więc zdaniem, że książka się ukazała. E-book swoją datę już miał. Druk miał pakiet i pytanie o cenę. Gotowy tekst trzymam osobno od gotowej produkcji, żeby linia mety, przy której nie ma jeszcze czego wytwarzać, nie wyglądała jak skończona praca.</p>

HTML,
        ],
        'hu' => [
            'title' => 'A tördelési csomag még nem nyomtatott könyv',
            'image_alt' => 'Egy sötét asztalon három tárgy: balra világos lapok kötege, középen világító türkiz lap, jobbra kötetlen ívköteg szürke ágrajzzal, egy lila tábla és egy vékony türkiz vonalzó.',
            'excerpt' => '2026. október 20-án a Publico cégéhez elment a Marža z krvi tördelési csomagja. Öt fájl, 270 oldalas A5-ös belső rész, 59 szürkeárnyalatos illusztráció. Árajánlatkérés volt, nem szerződés. Az e-könyvnek már volt megjelenési dátuma, az ISBN két nappal később érkezett.',
            'content' => <<<'HTML'
<p>2026. október 20-án a <a href="https://www.publico.sk/">Publico</a> cégnek elküldtem a fájlokat a Marža z krvi című szlovák thriller tördelési árajánlatához.</p>
<p>A csomagban ott volt a kézirat DOCX-ben, a belső rész A5-ös PDF-ben, és a borító fájljai. Összesen öt gyártási fájl. Az előkészített belső rész 270 oldalas, és 59 szürkeárnyalatos illusztráció van benne. Azon a napon ez árajánlatkérés volt, nem aláírt gyártási szerződés. A digitális kiadás és a nyomtatott kiadás ISBN-kérelmeinek még nem volt kiosztott száma.</p>
<p>Az e-könyv a <a href="https://nefro.polascin.net/publikacia.php?slug=marza-z-krvi">katalógusban</a> 2026. október 18-i kiadásként szerepel, 298 oldallal, szintén 59 illusztrációval. A 270 és a 298 nem ugyanannak a terjedelemnek két feljegyzése. Az egyik a tördelési csomag A5-ös belső részéhez tartozik, a másik az e-könyv katalógusához tartozik. Október 22-én a Szlovák Köztársaság nemzeti ISBN-ügynöksége kiosztotta a számokat. A katalógus így rögzíti őket: PDF 978-80-570-8831-8, EPUB 978-80-570-8832-5, kartonált kötés 978-80-570-8830-1. Az oldal, amely a könyvet árulja, e-könyvet kínál. A kartonált kötés száma önmagában nem jelenti azt, hogy a nyomda elvállalta a munkát.</p>
<p>A cím egy, és három célvonal van. A történet lehet kész. Egy fájl olvasható és eladható. Egy ügynökség adhat számot. Azon a napon, amikor a csomag elment, a nyomtatásnál más dolgok nyitva maradtak: a kötés, a gerinc szélessége, a képek felbontása, és az, amit a beszállító a fájloktól kér. Egy szép PDF ezeket nem igazolja. A jó zárófejezet nem pótol egy alkalmatlan borítófájlt.</p>
<p>Az október 20-i lépés tehát nem az a mondat, hogy a könyv megjelent. Az e-könyvnek már megvolt a dátuma. A nyomtatásnak csomagja volt, és egy kérdés az árról. A kész szöveget külön tartom a kész gyártástól, hogy az a célvonal, ahol még nincs mit legyártani, ne úgy hasson, mint befejezett munka.</p>

HTML,
        ],
        'it' => [
            'title' => 'Un pacchetto di impaginazione non è ancora un libro stampato',
            'image_alt' => 'Su un tavolo scuro ci sono tre oggetti: a sinistra una pila di fogli chiari, al centro una lastra turchese luminosa, a destra un blocco non rilegato con un disegno grigio di un ramo, una tavola viola e un sottile righello turchese.',
            'excerpt' => 'Il 20 ottobre 2026 è partito verso Publico un pacchetto per l’impaginazione di Marža z krvi. Cinque file, un interno A5 di 270 pagine e 59 illustrazioni in scala di grigi. Era una richiesta di prezzo, non un contratto. L’ebook aveva già una data, e gli ISBN sono arrivati due giorni dopo.',
            'content' => <<<'HTML'
<p>Il 20 ottobre 2026 ho inviato a <a href="https://www.publico.sk/">Publico</a> i file per un preventivo di impaginazione del thriller slovacco Marža z krvi.</p>
<p>Nel pacchetto c’erano il manoscritto in DOCX, l’interno in PDF in formato A5 e i file di copertina. Cinque file di produzione in tutto. L’interno preparato ha 270 pagine e 59 illustrazioni in scala di grigi. Quel giorno era una richiesta di prezzo, non un contratto di produzione firmato. Le richieste di ISBN per l’edizione digitale e per la stampa non avevano ancora numeri assegnati.</p>
<p>L’ebook è indicato nel <a href="https://nefro.polascin.net/publikacia.php?slug=marza-z-krvi">catalogo</a> come edizione del 18 ottobre, con 298 pagine e le stesse 59 illustrazioni. Le cifre 270 e 298 non sono due registrazioni dello stesso conteggio. Una appartiene all’interno A5 del pacchetto di impaginazione, l’altra appartiene al catalogo dell’ebook. Il 22 ottobre l’agenzia nazionale ISBN della Repubblica slovacca ha assegnato i numeri. Il catalogo li riporta così: PDF 978-80-570-8831-8, EPUB 978-80-570-8832-5 e brossura 978-80-570-8830-1. La pagina che vende il libro offre l’ebook. Un numero per la brossura non significa, da solo, che una tipografia abbia preso l’incarico.</p>
<p>Il titolo è uno e i traguardi sono tre. La storia può essere finita. Un file può essere letto e venduto. Un’agenzia può assegnare un numero. Il giorno in cui il pacchetto è partito, per la stampa restavano aperte altre cose: la rilegatura, la larghezza del dorso, la risoluzione delle immagini e ciò che il fornitore richiede dai file. Un bel PDF non conferma queste cose. Un buon capitolo finale non compensa un file di copertina inadatto.</p>
<p>Il passo del 20 ottobre non è dunque la frase che il libro è uscito. L’ebook aveva già la sua data. La stampa aveva un pacchetto e una domanda sul prezzo. Tengo il testo finito separato dalla produzione finita, perché un traguardo a cui non c’è ancora nulla da fabbricare non sembri un lavoro concluso.</p>

HTML,
        ],
        'uk' => [
            'title' => 'Пакет для верстки ще не є друкованою книжкою',
            'image_alt' => 'На темному столі три предмети: ліворуч стос світлих аркушів, посередині світна бірюзова пластина, праворуч незшитий блок із сірим малюнком гілки, фіолетова дошка і тонка бірюзова лінійка.',
            'excerpt' => '20 жовтня 2026 року до Publico пішов пакет для верстки книжки Marža z krvi. П’ять файлів, внутрішня частина A5 на 270 сторінок і 59 ілюстрацій у відтінках сірого. Це було прохання про ціну, не договір. Електронна книжка вже мала дату виходу, а номери ISBN надійшли за два дні.',
            'content' => <<<'HTML'
<p>20 жовтня 2026 року я надіслав фірмі <a href="https://www.publico.sk/">Publico</a> файли для кошторису верстки словацького трилера Marža z krvi.</p>
<p>У пакеті був рукопис у форматі DOCX, внутрішня частина як PDF формату A5 і файли обкладинки. Разом п’ять виробничих файлів. Підготовлена внутрішня частина має 270 сторінок і 59 ілюстрацій у відтінках сірого. Того дня це було прохання про ціну, а не підписаний договір на виробництво. Заявки на ISBN для цифрового видання і для друку ще не мали присвоєних номерів.</p>
<p>Електронна книжка в <a href="https://nefro.polascin.net/publikacia.php?slug=marza-z-krvi">каталозі</a> зазначена як видання від 18 жовтня і має вказані 298 сторінок, також із 59 ілюстраціями. Числа 270 і 298 не є двома записами того самого обсягу. Одне належить внутрішній частині A5 у пакеті для верстки, друге належить каталогу електронної книжки. 22 жовтня номери присвоїло Національне агентство ISBN у Словацькій Республіці. У каталозі вони записані так: PDF 978-80-570-8831-8, EPUB 978-80-570-8832-5 і м’яка обкладинка 978-80-570-8830-1. Сторінка, яка продає книжку, пропонує електронну книжку. Номер для м’якої обкладинки сам по собі не означає, що друкарня взяла замовлення.</p>
<p>Назва одна, а фінішних ліній три. Оповідь може бути дописана. Файл можна читати і продавати. Агентство може присвоїти номер. Того дня, коли пакет пішов, щодо друку лишалися відкритими інші речі: палітурка, ширина корінця, роздільність зображень і те, чого постачальник вимагає від файлів. Гарний PDF цього не підтвердить. Добрий завершальний розділ не замінить непридатного файла обкладинки.</p>
<p>Отже, крок 20 жовтня не є реченням про те, що книжка вийшла. Електронна книжка свою дату вже мала. Друк мав пакет і питання про ціну. Готовий текст я тримаю окремо від готового виробництва, щоб фінішна лінія, на якій ще немає що виготовляти, не виглядала як закінчена праця.</p>

HTML,
        ],
    ],
];
