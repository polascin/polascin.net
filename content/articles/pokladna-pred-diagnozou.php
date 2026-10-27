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
 * Pokladňa pred diagnózou.
 * Výnimka: zákon č. 351/2022 Z. z., § 2 ods. 3, znenie účinné od 30. 5. 2026.
 * Pokuta: § 10 ods. 2 toho istého znenia (200 eur až 3 % obratu, strop 6 000
 * alebo 20 000 eur podľa deliktu). Slov-Lex, časová verzia 20260530.
 * Štyri hlásené položky článok nevyvracia. Nálezy neboli k nahliadnutiu.
 * Čísla z predajného e-mailu sa v texte neopakujú.
 */
return [
    'slug' => 'pokladna-pred-diagnozou',
    'author' => 'MUDr. Ľubomír Polaščín',
    'category' => 'blog',
    'is_top' => 0,
    'published_at' => '2026-10-28 00:40:00',
    'image' => 'images/articles/pokladna-pred-diagnozou.webp',
    'translations' => [
        'sk' => [
            'title' => 'Pokladňa pred diagnózou',
            'image_alt' => 'Zapnutý tmavý platobný terminál s tyrkysovým svetlom leží v popredí. Za ním stojí zatvorený tyrkysový sklenený fascikel a v pozadí prázdne fialové karty.',
            'excerpt' => 'V sobotu 17. októbra 2026 prišlo varovanie o významnom riziku v prístupnosti: jedno zistenie s vysokou závažnosťou, tri so strednou a platený balík. Nálezy som nevidel. Sumy pokút nezodpovedali zákonu č. 351/2022 Z. z.',
            'content' => <<<'HTML'
<p>V sobotu 17. októbra 2026 som si prečítal varovanie o významnom riziku v prístupnosti webu. Predmet znel naliehavo. V tele bolo jedno zistenie s vysokou závažnosťou, tri so strednou a platený balík, ktorý to mal dať do poriadku.</p>
<p>Nálezy, z ktorých tie štyri položky mali vzniknúť, som pri čítaní nevidel. Závažnosť bez nálezu je štítok. Štítok sa nedá overiť a stránka sa ním neopraví.</p>
<p>Predajná správa zložila tri otázky do jedného odseku. Patria k sebe, každá však chce vlastný podklad. Čo je na stránke naozaj pokazené? Ktorá povinnosť sa na túto činnosť vzťahuje? Odstránil by ponúkaný výrobok práve tú prekážku? Až štvrtá vec bola cena. Tá má prísť po odpovediach, nie namiesto nich.</p>
<p>Sumy pokút v e-maile som porovnal so slovenským predpisom. Nezodpovedali tomu, čo ustanovuje. Otvoril som <a href="https://www.slov-lex.sk/ezbierky/pravne-predpisy/SK/ZZ/2022/351/20260530">zákon č. 351/2022 Z. z.</a> o prístupnosti výrobkov a služieb pre osoby so zdravotným postihnutím, znenie účinné od 30. mája 2026. Podľa § 2 ods. 3 sa tento zákon nevzťahuje na služby poskytované mikropodnikom. Podľa § 10 ods. 2 môže orgán dohľadu uložiť pokutu od 200 eur do 3 % obratu za predchádzajúce účtovné obdobie, najviac do 6 000 eur alebo do 20 000 eur podľa toho, o ktorý správny delikt ide.</p>
<p>Výnimka pre mikropodnik nie je osvedčenie, že web je prístupný. Hovorí len toľko, že naliehavý predmet sám osebe nepreukáže, že povinnosť vznikla a že sankcia hrozí. Štyri hlásené položky tým nie sú vyvrátené. Neboli k nahliadnutiu, takže ich nevyvraciam.</p>
<p>Prístupnosť riešim preto, že stránku má vedieť použiť človek, ktorý na ňu príde. Predmet, ktorý sa dobre otvára, na to nestačí.</p>
<p>Poradie si preto držím pevne. Najprv prekážka. Potom povinnosť. Až potom náprava. Pokladňa nech počká, kým bude diagnóza na stole.</p>

HTML,
        ],
        'en' => [
            'title' => 'Checkout before the diagnosis',
            'image_alt' => 'A switched-on dark payment terminal with a teal light sits in front. Behind it stands a closed teal glass folder, with blank purple cards in the background.',
            'excerpt' => 'On Saturday 17 October 2026 a warning arrived about a significant accessibility risk: one high-severity finding, three medium ones, and a paid package. I never saw the findings. The penalty figures did not match Act No. 351/2022 Coll.',
            'content' => <<<'HTML'
<p>On Saturday 17 October 2026 I read a warning about a significant accessibility risk on the site. The subject line sounded urgent. The body listed one high-severity finding, three of medium severity, and a paid package that was supposed to put it right.</p>
<p>I did not see the findings those four items were meant to come from. Severity without a finding is a label. A label cannot be checked, and it does not repair a page.</p>
<p>The sales message folded three questions into one paragraph. They belong together, but each needs its own evidence. What is actually broken on the page? Which duty applies to this activity? Would the product on offer remove that particular barrier? The fourth item was the price. It should arrive after the answers, not in their place.</p>
<p>I compared the penalty figures in the email with the Slovak statute. They did not match what it provides. I opened <a href="https://www.slov-lex.sk/ezbierky/pravne-predpisy/SK/ZZ/2022/351/20260530">Act No. 351/2022 Coll.</a> on the accessibility of products and services for persons with disabilities, in the wording in force since 30 May 2026. Under Section 2(3), this Act does not apply to services provided by a micro-enterprise. Under Section 10(2), a supervisory authority may impose a fine from 200 euros up to 3 percent of turnover for the previous accounting period, capped at 6,000 euros or 20,000 euros according to the administrative offence.</p>
<p>The micro-enterprise exemption is not a certificate that the site is accessible. It says only that an urgent subject line does not, by itself, prove that a duty has arisen and that a sanction is looming. The four reported items are not disproved by this. They were not available for inspection, so I am not disproving them.</p>
<p>I care about accessibility because a person who arrives at the page needs to be able to use it. A subject line that opens well is not enough for that.</p>
<p>So I keep the order fixed. First the barrier. Then the duty. Only then the remedy. Checkout can wait until the diagnosis is on the table.</p>

HTML,
        ],
        'cs' => [
            'title' => 'Pokladna před diagnózou',
            'image_alt' => 'Zapnutý tmavý platební terminál s tyrkysovým světlem leží v popředí. Za ním stojí zavřený tyrkysový skleněný fascikl a v pozadí prázdné fialové karty.',
            'excerpt' => 'V sobotu 17. října 2026 přišlo varování o významném riziku v přístupnosti: jedno zjištění s vysokou závažností, tři se střední a placený balík. Nálezy jsem neviděl. Částky pokut neodpovídaly zákonu č. 351/2022 Z. z.',
            'content' => <<<'HTML'
<p>V sobotu 17. října 2026 jsem si přečetl varování o významném riziku v přístupnosti webu. Předmět zněl naléhavě. V těle bylo jedno zjištění s vysokou závažností, tři se střední a placený balík, který to měl dát do pořádku.</p>
<p>Nálezy, z nichž ty čtyři položky měly vzniknout, jsem při čtení neviděl. Závažnost bez nálezu je štítek. Štítek nelze ověřit a stránka se jím neopraví.</p>
<p>Prodejní zpráva složila tři otázky do jednoho odstavce. Patří k sobě, každá však chce vlastní podklad. Co je na stránce doopravdy rozbité? Která povinnost se na tuto činnost vztahuje? Odstranil by nabízený výrobek právě tu překážku? Až čtvrtá věc byla cena. Ta má přijít po odpovědích, ne místo nich.</p>
<p>Částky pokut v e-mailu jsem porovnal se slovenským předpisem. Neodpovídaly tomu, co stanoví. Otevřel jsem <a href="https://www.slov-lex.sk/ezbierky/pravne-predpisy/SK/ZZ/2022/351/20260530">zákon č. 351/2022 Z. z.</a> o přístupnosti výrobků a služeb pro osoby se zdravotním postižením, znění účinné od 30. května 2026. Podle § 2 odst. 3 se tento zákon nevztahuje na služby poskytované mikropodnikem. Podle § 10 odst. 2 může orgán dohledu uložit pokutu od 200 eur do 3 % obratu za předchozí účetní období, nejvýše do 6 000 eur nebo do 20 000 eur podle toho, o který správní delikt jde.</p>
<p>Výjimka pro mikropodnik není osvědčení, že web je přístupný. Říká jen tolik, že naléhavý předmět sám o sobě neprokáže, že povinnost vznikla a že sankce hrozí. Čtyři hlášené položky tím nejsou vyvráceny. Nebyly k nahlédnutí, takže je nevyvracím.</p>
<p>Přístupnost řeším proto, že stránku má umět použít člověk, který na ni přijde. Předmět, který se dobře otevírá, na to nestačí.</p>
<p>Pořadí si proto držím pevně. Nejdřív překážka. Pak povinnost. Až potom náprava. Pokladna ať počká, než bude diagnóza na stole.</p>

HTML,
        ],
        'de' => [
            'title' => 'Die Kasse vor der Diagnose',
            'image_alt' => 'Ein eingeschaltetes dunkles Zahlungsterminal mit türkisem Licht liegt vorn. Dahinter steht eine geschlossene türkise Glasmappe, im Hintergrund leere violette Karten.',
            'excerpt' => 'Am Samstag, dem 17. Oktober 2026, kam eine Warnung vor einem erheblichen Barrierefreiheitsrisiko: ein Befund hoher Schwere, drei mittlere und ein kostenpflichtiges Paket. Die Befunde habe ich nicht gesehen. Die Bußgelder passten nicht zum Gesetz Nr. 351/2022 Z. z.',
            'content' => <<<'HTML'
<p>Am Samstag, dem 17. Oktober 2026, las ich eine Warnung vor einem erheblichen Barrierefreiheitsrisiko auf der Website. Die Betreffzeile klang dringend. Im Text standen ein Befund hoher Schwere, drei mittlerer Schwere und ein kostenpflichtiges Paket, das die Sache in Ordnung bringen sollte.</p>
<p>Die Befunde, aus denen diese vier Punkte stammen sollten, habe ich beim Lesen nicht gesehen. Schwere ohne Befund ist ein Etikett. Ein Etikett lässt sich nicht prüfen, und eine Seite wird dadurch nicht repariert.</p>
<p>Die Verkaufsnachricht hat drei Fragen in einen Absatz gelegt. Sie gehören zusammen, jede braucht aber eine eigene Grundlage. Was ist auf der Seite tatsächlich kaputt? Welche Pflicht gilt für diese Tätigkeit? Würde das angebotene Produkt genau dieses Hindernis beseitigen? Erst die vierte Sache war der Preis. Der soll nach den Antworten kommen, nicht an ihrer Stelle.</p>
<p>Die Bußgeldbeträge in der E-Mail habe ich mit der slowakischen Vorschrift verglichen. Sie entsprachen nicht dem, was sie festlegt. Ich habe das <a href="https://www.slov-lex.sk/ezbierky/pravne-predpisy/SK/ZZ/2022/351/20260530">Gesetz Nr. 351/2022 Z. z.</a> über die Barrierefreiheit von Produkten und Dienstleistungen für Menschen mit Behinderung geöffnet, in der Fassung in Kraft seit dem 30. Mai 2026. Nach § 2 Abs. 3 gilt dieses Gesetz nicht für Dienstleistungen, die ein Mikrounternehmen erbringt. Nach § 10 Abs. 2 kann die Aufsichtsbehörde ein Bußgeld von 200 Euro bis zu 3 Prozent des Umsatzes des vorangegangenen Rechnungszeitraums verhängen, höchstens 6 000 Euro oder 20 000 Euro, je nach dem Verwaltungsdelikt.</p>
<p>Die Ausnahme für das Mikrounternehmen ist kein Nachweis, dass die Website barrierefrei ist. Sie besagt nur, dass eine dringende Betreffzeile für sich nicht beweist, dass eine Pflicht entstanden ist und eine Sanktion droht. Die vier gemeldeten Punkte sind damit nicht widerlegt. Sie lagen nicht zur Einsicht vor, also widerlege ich sie nicht.</p>
<p>Barrierefreiheit interessiert mich, weil ein Mensch, der auf die Seite kommt, sie benutzen können muss. Eine Betreffzeile, die sich gut öffnen lässt, genügt dafür nicht.</p>
<p>Die Reihenfolge halte ich deshalb fest. Zuerst das Hindernis. Dann die Pflicht. Erst danach die Abhilfe. Die Kasse kann warten, bis die Diagnose auf dem Tisch liegt.</p>

HTML,
        ],
        'fr' => [
            'title' => 'La caisse avant le diagnostic',
            'image_alt' => 'Un terminal de paiement sombre, allumé, avec une lumière turquoise, est au premier plan. Derrière lui se tient un dossier de verre turquoise fermé, et au fond des cartes violettes vierges.',
            'excerpt' => 'Le samedi 17 octobre 2026, un avertissement signalait un risque important pour l’accessibilité : un constat de gravité haute, trois de gravité moyenne et un forfait payant. Je n’ai pas vu les constats. Les montants d’amende ne correspondaient pas à la loi n° 351/2022 Z. z.',
            'content' => <<<'HTML'
<p>Le samedi 17 octobre 2026, j’ai lu un avertissement sur un risque important pour l’accessibilité du site. L’objet du message semblait urgent. Le corps comptait un constat de gravité haute, trois de gravité moyenne, et un forfait payant censé remettre les choses en ordre.</p>
<p>Je n’ai pas vu les constats dont ces quatre éléments étaient censés sortir. Une gravité sans constat est une étiquette. Une étiquette ne se vérifie pas, et elle ne répare pas une page.</p>
<p>Le message commercial a plié trois questions dans un seul paragraphe. Elles vont ensemble, mais chacune demande sa propre base. Qu’est-ce qui est vraiment en panne sur la page ? Quelle obligation s’applique à cette activité ? Le produit proposé lèverait-il précisément cet obstacle ? Le quatrième élément était le prix. Il doit arriver après les réponses, pas à leur place.</p>
<p>J’ai comparé les montants d’amende du message avec le texte slovaque. Ils ne correspondaient pas à ce qu’il prévoit. J’ai ouvert la <a href="https://www.slov-lex.sk/ezbierky/pravne-predpisy/SK/ZZ/2022/351/20260530">loi n° 351/2022 Z. z.</a> sur l’accessibilité des produits et des services pour les personnes handicapées, dans la version en vigueur depuis le 30 mai 2026. Selon l’article 2, paragraphe 3, la présente loi ne s’applique pas aux services fournis par une micro-entreprise. Selon l’article 10, paragraphe 2, l’autorité de contrôle peut infliger une amende de 200 euros jusqu’à 3 % du chiffre d’affaires de l’exercice comptable précédent, au plus 6 000 euros ou 20 000 euros selon l’infraction administrative.</p>
<p>L’exemption de la micro-entreprise n’est pas un certificat que le site est accessible. Elle dit seulement qu’un objet urgent ne prouve pas, à lui seul, qu’une obligation est née et qu’une sanction menace. Les quatre éléments signalés n’en sont pas réfutés. Ils n’étaient pas consultables, donc je ne les réfute pas.</p>
<p>L’accessibilité m’importe parce qu’une personne qui arrive sur la page doit pouvoir s’en servir. Un objet qui s’ouvre bien n’y suffit pas.</p>
<p>Je tiens donc l’ordre. D’abord l’obstacle. Ensuite l’obligation. Ensuite seulement le remède. La caisse peut attendre que le diagnostic soit sur la table.</p>

HTML,
        ],
        'es' => [
            'title' => 'La caja antes del diagnóstico',
            'image_alt' => 'Un terminal de pago oscuro, encendido, con una luz turquesa, está en primer plano. Detrás hay una carpeta de vidrio turquesa cerrada y, al fondo, tarjetas moradas en blanco.',
            'excerpt' => 'El sábado 17 de octubre de 2026 llegó un aviso de un riesgo importante de accesibilidad: un hallazgo de gravedad alta, tres de gravedad media y un paquete de pago. No vi los hallazgos. Las multas no coincidían con la Ley n.º 351/2022 Z. z.',
            'content' => <<<'HTML'
<p>El sábado 17 de octubre de 2026 leí un aviso sobre un riesgo importante de accesibilidad en el sitio. El asunto sonaba urgente. El cuerpo traía un hallazgo de gravedad alta, tres de gravedad media y un paquete de pago que debía dejarlo todo en orden.</p>
<p>No vi los hallazgos de los que debían salir esas cuatro partidas. La gravedad sin hallazgo es una etiqueta. Una etiqueta no se puede comprobar, y con ella no se repara una página.</p>
<p>El mensaje de venta metió tres preguntas en un solo párrafo. Van juntas, pero cada una pide su propio fundamento. ¿Qué está roto de verdad en la página? ¿Qué obligación alcanza a esta actividad? ¿El producto ofrecido quitaría justo ese obstáculo? La cuarta cosa fue el precio. Tiene que llegar después de las respuestas, no en su lugar.</p>
<p>Comparé las cuantías de las multas del correo con la norma eslovaca. No coincidían con lo que dispone. Abrí la <a href="https://www.slov-lex.sk/ezbierky/pravne-predpisy/SK/ZZ/2022/351/20260530">Ley n.º 351/2022 Z. z.</a> de accesibilidad de los productos y servicios para las personas con discapacidad, en la versión vigente desde el 30 de mayo de 2026. Según el artículo 2, apartado 3, esta ley no se aplica a los servicios prestados por una microempresa. Según el artículo 10, apartado 2, el órgano de control puede imponer una multa desde 200 euros hasta el 3 % del volumen de negocios del ejercicio contable anterior, como máximo 6 000 euros o 20 000 euros según la infracción administrativa.</p>
<p>La exención de la microempresa no es un certificado de que el sitio es accesible. Solo dice que un asunto urgente no prueba, por sí solo, que haya nacido una obligación y que amenace una sanción. Las cuatro partidas comunicadas no quedan así refutadas. No estaban a la vista, así que no las refuto.</p>
<p>Me ocupa la accesibilidad porque la persona que llega a la página tiene que poder usarla. Un asunto que se abre bien no basta para eso.</p>
<p>Por eso mantengo el orden. Primero el obstáculo. Después la obligación. Solo entonces el remedio. La caja puede esperar a que el diagnóstico esté sobre la mesa.</p>

HTML,
        ],
        'pl' => [
            'title' => 'Kasa przed diagnozą',
            'image_alt' => 'Włączony ciemny terminal płatniczy z turkusowym światłem leży na pierwszym planie. Za nim stoi zamknięta turkusowa szklana teczka, a w tle puste fioletowe karty.',
            'excerpt' => 'W sobotę 17 października 2026 roku przyszło ostrzeżenie o istotnym ryzyku dla dostępności: jedno ustalenie o wysokiej wadze, trzy o średniej i płatny pakiet. Ustaleń nie widziałem. Kwoty kar nie zgadzały się z ustawą nr 351/2022 Z. z.',
            'content' => <<<'HTML'
<p>W sobotę 17 października 2026 roku przeczytałem ostrzeżenie o istotnym ryzyku dla dostępności witryny. Temat brzmiał nagląco. W treści było jedno ustalenie o wysokiej wadze, trzy o średniej i płatny pakiet, który miał to doprowadzić do porządku.</p>
<p>Ustaleń, z których te cztery pozycje miały wyniknąć, przy czytaniu nie widziałem. Waga bez ustalenia jest etykietą. Etykiety nie da się sprawdzić i strona się nią nie naprawi.</p>
<p>Wiadomość sprzedażowa złożyła trzy pytania w jednym akapicie. Należą do siebie, każde jednak chce własnej podstawy. Co na stronie jest naprawdę zepsute? Który obowiązek dotyczy tej działalności? Czy oferowany produkt usunąłby właśnie tę przeszkodę? Dopiero czwartą rzeczą była cena. Ma przyjść po odpowiedziach, nie zamiast nich.</p>
<p>Kwoty kar w e-mailu porównałem ze słowackim przepisem. Nie odpowiadały temu, co stanowi. Otworzyłem <a href="https://www.slov-lex.sk/ezbierky/pravne-predpisy/SK/ZZ/2022/351/20260530">ustawę nr 351/2022 Z. z.</a> o dostępności produktów i usług dla osób z niepełnosprawnością, w brzmieniu obowiązującym od 30 maja 2026 roku. Według § 2 ust. 3 ustawa ta nie obejmuje usług świadczonych przez mikroprzedsiębiorstwo. Według § 10 ust. 2 organ nadzoru może nałożyć karę od 200 euro do 3 procent obrotu za poprzedni okres obrachunkowy, najwyżej do 6 000 euro albo do 20 000 euro, zależnie od deliktu administracyjnego.</p>
<p>Wyłączenie mikroprzedsiębiorstwa nie jest świadectwem, że witryna jest dostępna. Mówi tylko tyle, że naglący temat sam z siebie nie dowodzi, że obowiązek powstał i że grozi sankcja. Cztery zgłoszone pozycje nie są przez to obalone. Nie były do wglądu, więc ich nie obalam.</p>
<p>Dostępnością zajmuję się dlatego, że stronę ma umieć użyć człowiek, który na nią wejdzie. Temat, który dobrze się otwiera, do tego nie wystarcza.</p>
<p>Kolejność trzymam więc twardo. Najpierw przeszkoda. Potem obowiązek. Dopiero potem naprawa. Kasa może poczekać, aż diagnoza znajdzie się na stole.</p>

HTML,
        ],
        'hu' => [
            'title' => 'A pénztár a diagnózis előtt',
            'image_alt' => 'Egy bekapcsolt sötét fizetési terminál türkiz fénnyel az előtérben. Mögötte zárt türkiz üvegdosszié áll, a háttérben üres lila kártyák.',
            'excerpt' => '2026. október 17-én, szombaton figyelmeztetés érkezett jelentős akadálymentességi kockázatról: egy magas súlyú megállapítás, három közepes, és egy fizetős csomag. A megállapításokat nem láttam. A bírságösszegek nem egyeztek a 351/2022. sz. törvénnyel.',
            'content' => <<<'HTML'
<p>2026. október 17-én, szombaton elolvastam egy figyelmeztetést a webhely jelentős akadálymentességi kockázatáról. A tárgy sürgősnek hangzott. A szövegben egy magas súlyú megállapítás, három közepes súlyú, és egy fizetős csomag volt, amely rendbe hozta volna a dolgot.</p>
<p>Azokat a megállapításokat, amelyekből ez a négy tétel származott volna, olvasás közben nem láttam. A súly megállapítás nélkül címke. A címkét nem lehet ellenőrizni, és az oldal nem javul meg tőle.</p>
<p>Az értékesítő üzenet három kérdést tett egy bekezdésbe. Összetartoznak, de mindegyiknek saját alap kell. Mi romlott el valójában az oldalon? Melyik kötelezettség vonatkozik erre a tevékenységre? A kínált termék éppen ezt az akadályt szüntetné meg? A negyedik dolog az ár volt. A válaszok után kell jönnie, nem azok helyett.</p>
<p>Az e-mailben szereplő bírságösszegeket összevetettem a szlovák előírással. Nem annak feleltek meg, amit az előír. Megnyitottam a termékek és szolgáltatások fogyatékossággal élő személyek számára való akadálymentességéről szóló <a href="https://www.slov-lex.sk/ezbierky/pravne-predpisy/SK/ZZ/2022/351/20260530">351/2022. sz. törvényt</a>, a 2026. május 30-ától hatályos szövegben. A 2. § (3) bekezdése szerint ez a törvény nem terjed ki a mikrovállalkozás által nyújtott szolgáltatásokra. A 10. § (2) bekezdése szerint a felügyeleti szerv 200 eurótól az előző számviteli időszak forgalmának 3 százalékáig terjedő bírságot szabhat ki, legfeljebb 6 000 vagy 20 000 eurót, aszerint, hogy melyik közigazgatási deliktumról van szó.</p>
<p>A mikrovállalkozás kivétele nem igazolás arról, hogy a webhely akadálymentes. Csak annyit mond, hogy a sürgős tárgy önmagában nem bizonyítja, hogy a kötelezettség létrejött és hogy szankció fenyeget. A négy jelzett tétel ezzel nincs megcáfolva. Nem voltak megtekinthetők, ezért nem cáfolom őket.</p>
<p>Az akadálymentesség azért foglalkoztat, mert az oldalra érkező embernek használnia kell tudnia azt. A tárgy, amely jól nyílik, ehhez nem elég.</p>
<p>A sorrendet ezért tartom. Először az akadály. Aztán a kötelezettség. Csak utána a javítás. A pénztár várjon, amíg a diagnózis az asztalra kerül.</p>

HTML,
        ],
        'it' => [
            'title' => 'La cassa prima della diagnosi',
            'image_alt' => 'Un terminale di pagamento scuro, acceso, con una luce turchese, è in primo piano. Dietro sta una cartella di vetro turchese chiusa e, sullo sfondo, carte viola vuote.',
            'excerpt' => 'Sabato 17 ottobre 2026 è arrivato un avviso su un rischio rilevante di accessibilità: un rilievo di gravità alta, tre di gravità media e un pacchetto a pagamento. I rilievi non li ho visti. Le somme delle sanzioni non corrispondevano alla legge n. 351/2022 Z. z.',
            'content' => <<<'HTML'
<p>Sabato 17 ottobre 2026 ho letto un avviso su un rischio rilevante di accessibilità del sito. L’oggetto sembrava urgente. Nel testo c’erano un rilievo di gravità alta, tre di gravità media e un pacchetto a pagamento che doveva mettere le cose a posto.</p>
<p>I rilievi da cui quelle quattro voci dovevano uscire non li ho visti durante la lettura. La gravità senza rilievo è un’etichetta. Un’etichetta non si verifica, e una pagina non si ripara con essa.</p>
<p>Il messaggio di vendita ha messo tre domande in un solo capoverso. Stanno insieme, ma ciascuna vuole una base propria. Che cosa è davvero rotto nella pagina? Quale obbligo riguarda questa attività? Il prodotto offerto toglierebbe proprio quell’ostacolo? La quarta cosa era il prezzo. Deve arrivare dopo le risposte, non al loro posto.</p>
<p>Ho confrontato le somme delle sanzioni nell’e-mail con la norma slovacca. Non corrispondevano a ciò che essa dispone. Ho aperto la <a href="https://www.slov-lex.sk/ezbierky/pravne-predpisy/SK/ZZ/2022/351/20260530">legge n. 351/2022 Z. z.</a> sull’accessibilità dei prodotti e dei servizi per le persone con disabilità, nel testo in vigore dal 30 maggio 2026. Secondo l’articolo 2, comma 3, questa legge non si applica ai servizi forniti da una microimpresa. Secondo l’articolo 10, comma 2, l’autorità di vigilanza può infliggere una sanzione da 200 euro fino al 3 % del fatturato dell’esercizio contabile precedente, al massimo 6 000 euro o 20 000 euro secondo l’illecito amministrativo.</p>
<p>L’esenzione della microimpresa non è un certificato che il sito sia accessibile. Dice solo che un oggetto urgente, da solo, non prova che l’obbligo sia sorto e che la sanzione incomba. Le quattro voci segnalate non ne risultano confutate. Non erano consultabili, quindi non le confuto.</p>
<p>L’accessibilità mi interessa perché la persona che arriva sulla pagina deve poterla usare. Un oggetto che si apre bene non basta.</p>
<p>Tengo quindi fermo l’ordine. Prima l’ostacolo. Poi l’obbligo. Solo dopo il rimedio. La cassa può attendere che la diagnosi sia sul tavolo.</p>

HTML,
        ],
        'uk' => [
            'title' => 'Каса перед діагнозом',
            'image_alt' => 'Увімкнений темний платіжний термінал із бірюзовим світлом лежить на передньому плані. За ним стоїть закрита бірюзова скляна тека, а на тлі порожні фіолетові картки.',
            'excerpt' => 'У суботу 17 жовтня 2026 року надійшло попередження про істотний ризик для доступності: один висновок високої серйозності, три середньої і платний пакет. Висновків я не бачив. Суми штрафів не збігалися із законом № 351/2022 Z. z.',
            'content' => <<<'HTML'
<p>У суботу 17 жовтня 2026 року я прочитав попередження про істотний ризик для доступності сайту. Тема звучала невідкладно. У тексті був один висновок високої серйозності, три середньої і платний пакет, який мав усе владнати.</p>
<p>Висновків, з яких ці чотири позиції мали постати, під час читання я не бачив. Серйозність без висновку є етикеткою. Етикетку не перевіриш, і сторінка від неї не полагодиться.</p>
<p>Продажний лист склав три питання в один абзац. Вони належать одне до одного, але кожне хоче власної підстави. Що на сторінці справді зламано? Який обов’язок стосується цієї діяльності? Чи прибрав би запропонований виріб саме цю перешкоду? Аж четвертою річчю була ціна. Вона має прийти після відповідей, не замість них.</p>
<p>Суми штрафів у листі я порівняв зі словацьким приписом. Вони не відповідали тому, що він установлює. Я відкрив <a href="https://www.slov-lex.sk/ezbierky/pravne-predpisy/SK/ZZ/2022/351/20260530">закон № 351/2022 Z. z.</a> про доступність виробів і послуг для осіб з інвалідністю, у редакції, чинній від 30 травня 2026 року. Згідно з частиною 3 § 2 цей закон не поширюється на послуги, які надає мікропідприємство. Згідно з частиною 2 § 10 орган нагляду може накласти штраф від 200 євро до 3 відсотків обороту за попередній обліковий період, щонайбільше до 6 000 євро або до 20 000 євро, залежно від адміністративного делікту.</p>
<p>Виняток для мікропідприємства не є підтвердженням, що сайт доступний. Він каже лише те, що невідкладна тема сама по собі не доводить, що обов’язок виник і що загрожує санкція. Чотири повідомлені позиції цим не спростовані. Їх не було для перегляду, тож я їх не спростовую.</p>
<p>Доступність мене обходить тому, що сторінку має вміти використати людина, яка на неї прийде. Теми, яка добре відкривається, для цього не досить.</p>
<p>Порядок тому тримаю твердо. Спершу перешкода. Потім обов’язок. І лише тоді виправлення. Каса нехай зачекає, доки діагноз буде на столі.</p>

HTML,
        ],
    ],
];
