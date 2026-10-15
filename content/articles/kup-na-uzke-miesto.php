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
 * Esej z rozborov, o ktoré som požiadal 8. 10. 2026 (BookSpace) a 10. 10. 2026 (Zeely).
 * Overené 15. 10. 2026:
 * BookSpace (https://bookspace.com/) je priama predajňa autora, nie trhovisko.
 * Zeely (https://zeely.ai/) je platforma na výrobu reklamy a kampane.
 * Štvorica výroba / distribúcia / dopyt / ekonomika je redakčná syntéza tých
 * rozborov. Text netvrdí, že som spustil platenú kampaň.
 */
return [
    'slug' => 'kup-na-uzke-miesto',
    'author' => 'MUDr. Ľubomír Polaščín',
    'category' => 'blog',
    'is_top' => 0,
    'published_at' => '2026-10-15 17:40:00',
    'image' => 'images/articles/kup-na-uzke-miesto.webp',
    'translations' => [
        'sk' => [
            'title' => 'Kúp na úzke miesto.',
            'image_alt' => 'Tmavá úzka štrbina medzi fialovou stenou pohyblivých reklám a tyrkysovým pultom s knihami. V hrdle ležia jedna zatvorená kniha a prázdna miska. Postava od chrbta nejde ani k reklame, ani k pultu.',
            'excerpt' => 'V októbri som si dal rozobrať BookSpace a Zeely. Jedna ponúka predaj, druhá reklamu a kampaň. Ani jedno z nich samo nepovie, či túto knihu niekto kúpi.',
            'content' => <<<'HTML'
<p>V októbri som si dal rozobrať <a href="https://bookspace.com/">BookSpace</a> a <a href="https://zeely.ai/">Zeely</a>. Hľadal som, čo z toho sa hodí na moje knihy.</p>
<p>BookSpace ponúka predajnú infraštruktúru. Zeely ponúka výrobu reklamy a nástroje na kampaň. Sú to rôzne práce. Ani jedno z nich samo neodpovie, či túto konkrétnu knihu niekto kúpi.</p>
<p>Rozlišujem to takto.</p>
<ul>
<li><strong>Výroba.</strong> Viem ten materiál pripraviť rýchlejšie?</li>
<li><strong>Distribúcia.</strong> Viem ho dostať pred správnych ľudí?</li>
<li><strong>Dopyt.</strong> Chcú ho tí ľudia naozaj?</li>
<li><strong>Ekonomika.</strong> Ostane z predaja po nákladoch niečo?</li>
</ul>
<p>Kým sa zaviažem k nástroju s opakovaným poplatkom, vzal by som jednu knihu. Rozpočet by bol pevný. Obdobie merania by som určil vopred.</p>
<p>Ešte pred platbou by som si overil, ktoré funkcie dnes naozaj idú, čo sa obnovuje samo a či sa platí aj niečo okrem predplatného.</p>
<p>Potom by som počítal dokončené nákupy a to, čo ostane po reklame, poplatkoch platformy a vybavení objednávky. Do toho by som nepočítal kliky ani to, koľko reklamy nástroj vyrobí.</p>
<p>Nástroj môže obstáť vo vlastnej skúške a predaj aj tak nevyjde. Krásna reklama vie nepredať nič. Predajňa s lepšou maržou môže ostať bez návštevníka.</p>
<p>Začínam úzkym miestom. Nástroj kúpim, len ak rieši práve to.</p>

HTML,
        ],
        'en' => [
            'title' => 'Buy for the bottleneck.',
            'image_alt' => 'A dark narrow gap between a purple wall of moving ads and a teal counter of books. In the throat of the gap lie one closed book and an empty coin dish. A figure seen from behind goes neither toward the ads nor toward the counter.',
            'excerpt' => 'In October I asked for analyses of BookSpace and Zeely. One offers a store. The other offers ads and a campaign. Neither, on its own, says whether anyone will buy this book.',
            'content' => <<<'HTML'
<p>In October I asked for analyses of <a href="https://bookspace.com/">BookSpace</a> and <a href="https://zeely.ai/">Zeely</a>. I was looking for what would fit my books.</p>
<p>BookSpace offers sales infrastructure. Zeely offers ad production and campaign tools. Those are different jobs. Neither, on its own, answers whether anyone will buy this particular book.</p>
<p>This is how I separate them.</p>
<ul>
<li><strong>Production.</strong> Can I make the material faster?</li>
<li><strong>Distribution.</strong> Can I put it in front of the right people?</li>
<li><strong>Demand.</strong> Do those people actually want it?</li>
<li><strong>Economics.</strong> Does the sale leave anything after costs?</li>
</ul>
<p>Before I commit to a tool with a recurring fee, I would take one book. The budget would be fixed. I would set the measurement period in advance.</p>
<p>Before paying, I would check which features actually work today, what renews on its own, and whether anything is charged beyond the subscription.</p>
<p>Then I would count completed purchases and what remains after advertising, platform fees and fulfillment. I would not count clicks, or how much advertising the tool produces.</p>
<p>A tool can pass its own test and the sale can still fail. A beautiful ad can sell nothing. A storefront with a better margin can have no visitors.</p>
<p>I start with the bottleneck. I buy the tool only if it addresses that.</p>

HTML,
        ],
        'cs' => [
            'title' => 'Kup na úzké místo.',
            'image_alt' => 'Tmavá úzká štěrbina mezi fialovou stěnou pohyblivých reklam a tyrkysovým pultem s knihami. V hrdle leží jedna zavřená kniha a prázdná miska. Postava zády k nám nejde ani k reklamě, ani k pultu.',
            'excerpt' => 'V říjnu jsem si nechal rozebrat BookSpace a Zeely. Jedna nabízí prodej, druhá reklamu a kampaň. Ani jedno z nich samo neřekne, jestli tuhle knihu někdo koupí.',
            'content' => <<<'HTML'
<p>V říjnu jsem si nechal rozebrat <a href="https://bookspace.com/">BookSpace</a> a <a href="https://zeely.ai/">Zeely</a>. Hledal jsem, co z toho se hodí na mé knihy.</p>
<p>BookSpace nabízí prodejní infrastrukturu. Zeely nabízí výrobu reklamy a nástroje na kampaň. Jsou to různé práce. Ani jedno z nich samo neodpoví, jestli tuhle konkrétní knihu někdo koupí.</p>
<p>Rozlišuji to takhle.</p>
<ul>
<li><strong>Výroba.</strong> Umím ten materiál připravit rychleji?</li>
<li><strong>Distribuce.</strong> Umím ho dostat před správné lidi?</li>
<li><strong>Poptávka.</strong> Chtějí ho ti lidé opravdu?</li>
<li><strong>Ekonomika.</strong> Zbude z prodeje po nákladech něco?</li>
</ul>
<p>Než se zavážu k nástroji s opakovaným poplatkem, vzal bych jednu knihu. Rozpočet by byl pevný. Období měření bych určil předem.</p>
<p>Ještě před platbou bych si ověřil, které funkce dnes opravdu fungují, co se obnovuje samo a jestli se platí i něco kromě předplatného.</p>
<p>Pak bych počítal dokončené nákupy a to, co zbude po reklamě, poplatcích platformy a vyřízení objednávky. Nepočítal bych do toho kliky ani to, kolik reklamy nástroj vyrobí.</p>
<p>Nástroj může obstát ve vlastní zkoušce a prodej přesto nevyjde. Krásná reklama nemusí prodat nic. Prodejna s lepší marží může zůstat bez návštěvníka.</p>
<p>Začínám úzkým místem. Nástroj koupím, jen pokud řeší právě to.</p>

HTML,
        ],
        'de' => [
            'title' => 'Kauf für den Engpass.',
            'image_alt' => 'Ein dunkler enger Spalt zwischen einer violetten Wand aus bewegter Werbung und einem türkisen Tresen mit Büchern. Im Engpass liegen ein geschlossenes Buch und eine leere Münzschale. Eine Gestalt von hinten geht weder zur Werbung noch zum Tresen.',
            'excerpt' => 'Im Oktober habe ich BookSpace und Zeely auseinandernehmen lassen. Das eine bietet Verkauf, das andere Werbung und eine Kampagne. Keines sagt allein, ob jemand dieses Buch kauft.',
            'content' => <<<'HTML'
<p>Im Oktober habe ich <a href="https://bookspace.com/">BookSpace</a> und <a href="https://zeely.ai/">Zeely</a> auseinandernehmen lassen. Ich suchte, was davon zu meinen Büchern passt.</p>
<p>BookSpace bietet Verkaufsinfrastruktur. Zeely bietet Werbeproduktion und Werkzeuge für Kampagnen. Das sind verschiedene Arbeiten. Keines von beiden beantwortet allein, ob jemand genau dieses Buch kauft.</p>
<p>Ich trenne das so.</p>
<ul>
<li><strong>Herstellung.</strong> Kann ich das Material schneller fertigmachen?</li>
<li><strong>Vertrieb.</strong> Kann ich es vor die richtigen Leute bringen?</li>
<li><strong>Nachfrage.</strong> Wollen diese Leute es wirklich?</li>
<li><strong>Wirtschaft.</strong> Bleibt vom Verkauf nach den Kosten etwas übrig?</li>
</ul>
<p>Bevor ich mich auf ein Werkzeug mit wiederkehrender Gebühr festlege, würde ich ein Buch nehmen. Das Budget wäre fest. Den Messzeitraum würde ich vorher festlegen.</p>
<p>Noch vor der Zahlung würde ich prüfen, welche Funktionen heute wirklich funktionieren, was sich von selbst verlängert und ob neben dem Abo noch etwas kostet.</p>
<p>Danach würde ich abgeschlossene Käufe zählen und das, was nach Werbung, Plattformgebühren und Auftragsabwicklung übrig bleibt. Klicks würde ich nicht zählen, und auch nicht, wie viel Werbung das Werkzeug erzeugt.</p>
<p>Ein Werkzeug kann die eigene Prüfung bestehen. Der Verkauf kann trotzdem scheitern. Auch schöne Werbung kann ohne Verkauf enden. Eine eigene Verkaufsseite mit besserer Marge kann ohne Besucher bleiben.</p>
<p>Ich fange beim Engpass an. Das Werkzeug kaufe ich nur, wenn es genau den löst.</p>

HTML,
        ],
        'fr' => [
            'title' => 'Achète pour le goulot.',
            'image_alt' => 'Une fente sombre et étroite entre un mur violet de publicités en mouvement et un comptoir turquoise chargé de livres. Dans le goulot, un livre fermé et une coupelle vide. Une silhouette de dos ne va ni vers les publicités ni vers le comptoir.',
            'excerpt' => 'En octobre, j’ai fait analyser BookSpace et Zeely. L’un offre la vente, l’autre la publicité et la campagne. Aucun des deux ne dit à lui seul si quelqu’un achètera ce livre.',
            'content' => <<<'HTML'
<p>En octobre, j’ai fait analyser <a href="https://bookspace.com/">BookSpace</a> et <a href="https://zeely.ai/">Zeely</a>. Je cherchais ce qui convenait à mes livres.</p>
<p>BookSpace offre une infrastructure de vente. Zeely offre la production de publicités et des outils de campagne. Ce sont des travaux différents. Aucun des deux ne dit, à lui seul, si quelqu’un achètera ce livre précis.</p>
<p>Je sépare les choses ainsi.</p>
<ul>
<li><strong>Production.</strong> Puis-je préparer le support plus vite ?</li>
<li><strong>Distribution.</strong> Puis-je le mettre devant les bonnes personnes ?</li>
<li><strong>Demande.</strong> Ces personnes le veulent-elles vraiment ?</li>
<li><strong>Économie.</strong> Reste-t-il quelque chose de la vente une fois les coûts payés ?</li>
</ul>
<p>Avant de m’engager sur un outil à frais récurrents, je prendrais un seul livre. Le budget serait fixe. Je fixerais à l’avance la période de mesure.</p>
<p>Avant de payer, je vérifierais quelles fonctions marchent vraiment aujourd’hui, ce qui se renouvelle tout seul, et si l’on paie autre chose que l’abonnement.</p>
<p>Ensuite, je compterais les achats menés à terme et ce qui reste après la publicité, les frais de plateforme et le traitement de la commande. Je ne compterais ni les clics, ni le volume de publicité que l’outil produit.</p>
<p>Un outil peut réussir son propre examen, et la vente échouer quand même. Une belle publicité peut ne rien vendre. Une boutique à meilleure marge peut rester sans visiteur.</p>
<p>Je commence par le goulot. Je n’achète l’outil que s’il traite exactement cela.</p>

HTML,
        ],
        'es' => [
            'title' => 'Compra para el cuello de botella.',
            'image_alt' => 'Una grieta oscura y estrecha entre un muro violeta de anuncios en movimiento y un mostrador turquesa con libros. En el cuello hay un libro cerrado y un cuenco vacío. Una figura de espaldas no va ni hacia los anuncios ni hacia el mostrador.',
            'excerpt' => 'En octubre pedí un análisis de BookSpace y de Zeely. Uno ofrece la venta, el otro el anuncio y la campaña. Ninguno de los dos dice por sí solo si alguien comprará este libro.',
            'content' => <<<'HTML'
<p>En octubre pedí un análisis de <a href="https://bookspace.com/">BookSpace</a> y de <a href="https://zeely.ai/">Zeely</a>. Buscaba qué encajaba con mis libros.</p>
<p>BookSpace ofrece infraestructura de venta. Zeely ofrece producción de anuncios y herramientas de campaña. Son trabajos distintos. Ninguno de los dos dice por sí solo si alguien comprará este libro concreto.</p>
<p>Lo separo así.</p>
<ul>
<li><strong>Producción.</strong> ¿Puedo preparar el material más rápido?</li>
<li><strong>Distribución.</strong> ¿Puedo ponerlo delante de las personas adecuadas?</li>
<li><strong>Demanda.</strong> ¿Esas personas lo quieren de verdad?</li>
<li><strong>Economía.</strong> ¿Queda algo de la venta después de los costes?</li>
</ul>
<p>Antes de comprometerme con una herramienta de pago periódico, tomaría un solo libro. El presupuesto sería fijo. Fijaría de antemano el plazo de medición.</p>
<p>Antes de pagar, comprobaría qué funciones sirven de verdad hoy, qué se renueva solo y si se cobra algo además de la suscripción.</p>
<p>Luego contaría las compras terminadas y lo que queda después del anuncio, las comisiones de la plataforma y la tramitación del pedido. No contaría los clics ni cuánta publicidad produce la herramienta.</p>
<p>Una herramienta puede aprobar su propio examen y la venta fracasar igual. Un anuncio hermoso puede no vender nada. Una tienda con mejor margen puede quedarse sin visitas.</p>
<p>Empiezo por el cuello de botella. Compro la herramienta solo si resuelve justo eso.</p>

HTML,
        ],
        'pl' => [
            'title' => 'Kup na wąskie gardło.',
            'image_alt' => 'Ciemna wąska szczelina między fioletową ścianą ruchomych reklam a turkusowym kontuarem z książkami. W gardle leżą jedna zamknięta książka i pusta miseczka. Postać od tyłu nie idzie ani do reklam, ani do kontuaru.',
            'excerpt' => 'W październiku kazałem rozebrać BookSpace i Zeely. Jedno oferuje sprzedaż, drugie reklamę i kampanię. Żadne z nich samo nie powie, czy ktoś kupi tę książkę.',
            'content' => <<<'HTML'
<p>W październiku kazałem rozebrać <a href="https://bookspace.com/">BookSpace</a> i <a href="https://zeely.ai/">Zeely</a>. Szukałem, co z tego pasuje do moich książek.</p>
<p>BookSpace oferuje infrastrukturę sprzedaży. Zeely oferuje produkcję reklam i narzędzia do kampanii. To różne prace. Żadne z nich samo nie odpowie, czy ktoś kupi tę konkretną książkę.</p>
<p>Rozdzielam to tak.</p>
<ul>
<li><strong>Produkcja.</strong> Czy umiem przygotować ten materiał szybciej?</li>
<li><strong>Dystrybucja.</strong> Czy umiem pokazać go właściwym ludziom?</li>
<li><strong>Popyt.</strong> Czy ci ludzie naprawdę go chcą?</li>
<li><strong>Ekonomia.</strong> Czy ze sprzedaży po kosztach coś zostaje?</li>
</ul>
<p>Zanim zwiążę się z narzędziem o cyklicznej opłacie, wziąłbym jedną książkę. Budżet byłby stały. Okres pomiaru ustaliłbym z góry.</p>
<p>Jeszcze przed płatnością sprawdziłbym, które funkcje dziś naprawdę działają, co odnawia się samo i czy płaci się też coś poza subskrypcją.</p>
<p>Potem liczyłbym dokończone zakupy i to, co zostaje po reklamie, opłatach platformy i realizacji zamówienia. Nie liczyłbym kliknięć ani tego, ile reklamy narzędzie wyprodukuje.</p>
<p>Narzędzie może zdać własny sprawdzian, a sprzedaż i tak nie wyjdzie. Piękna reklama może nie sprzedać nic. Sklep z lepszą marżą może zostać bez odwiedzającego.</p>
<p>Zaczynam od wąskiego gardła. Narzędzie kupię tylko wtedy, gdy rozwiązuje właśnie to.</p>

HTML,
        ],
        'hu' => [
            'title' => 'A szűk keresztmetszetre vegyél.',
            'image_alt' => 'Sötét keskeny rés egy lila, mozgó hirdetésekből álló fal és egy türkiz könyvespult között. A rés torkában egy csukott könyv és egy üres tálka. Egy hátulról látott alak sem a hirdetések, sem a pult felé nem indul.',
            'excerpt' => 'Októberben elemzést kértem a BookSpace-ről és a Zeelyről. Az egyik eladást kínál, a másik hirdetést és kampányt. Egyik sem mondja meg önmagában, hogy megveszi-e valaki ezt a könyvet.',
            'content' => <<<'HTML'
<p>Októberben elemzést kértem a <a href="https://bookspace.com/">BookSpace</a>-ről és a <a href="https://zeely.ai/">Zeely</a>ről. Azt kerestem, mi illik a könyveimhez.</p>
<p>A BookSpace értékesítési infrastruktúrát kínál. A Zeely hirdetéskészítést és kampányeszközöket kínál. Ezek különböző munkák. Egyik sem válaszol önmagában arra, hogy ezt a konkrét könyvet megveszi-e valaki.</p>
<p>Így választom szét.</p>
<ul>
<li><strong>Gyártás.</strong> Gyorsabban el tudom készíteni az anyagot?</li>
<li><strong>Terjesztés.</strong> Oda tudom tenni a megfelelő emberek elé?</li>
<li><strong>Kereslet.</strong> Azok az emberek tényleg akarják?</li>
<li><strong>Gazdaságosság.</strong> Marad-e valami az eladásból a költségek után?</li>
</ul>
<p>Mielőtt elkötelezném magam egy ismétlődő díjú eszköz mellett, egyetlen könyvet vennék. A költségkeret rögzített lenne. A mérési időszakot előre meghatároznám.</p>
<p>Fizetés előtt megnézném, mely funkciók működnek ma valóban, mi újul meg magától, és kell-e fizetni valamit az előfizetésen kívül is.</p>
<p>Utána a lezárt vásárlásokat számolnám, és azt, ami a hirdetés, a platform díjai és a rendelés teljesítése után megmarad. Nem számolnám a kattintásokat, sem azt, mennyi hirdetést gyárt az eszköz.</p>
<p>Egy eszköz átmehet a saját vizsgáján, az eladás pedig ettől még elbukhat. A szép hirdetés is maradhat eladatlan. A jobb árrésű bolt látogató nélkül maradhat.</p>
<p>A szűk keresztmetszettel kezdem. Az eszközt csak akkor veszem meg, ha éppen azt oldja meg.</p>

HTML,
        ],
        'it' => [
            'title' => 'Compra per il collo di bottiglia.',
            'image_alt' => 'Una fessura buia e stretta tra un muro viola di pubblicità in movimento e un banco turchese di libri. Nella strettoia stanno un libro chiuso e una ciotola vuota. Una figura di spalle non va né verso le pubblicità né verso il banco.',
            'excerpt' => 'A ottobre ho chiesto un’analisi di BookSpace e di Zeely. Uno offre la vendita, l’altro la pubblicità e la campagna. Nessuno dei due, da solo, dice se qualcuno comprerà questo libro.',
            'content' => <<<'HTML'
<p>A ottobre ho chiesto un’analisi di <a href="https://bookspace.com/">BookSpace</a> e di <a href="https://zeely.ai/">Zeely</a>. Cercavo che cosa si adattasse ai miei libri.</p>
<p>BookSpace offre un’infrastruttura di vendita. Zeely offre la produzione di pubblicità e strumenti per le campagne. Sono lavori diversi. Nessuno dei due risponde da solo se qualcuno comprerà questo libro preciso.</p>
<p>Li separo così.</p>
<ul>
<li><strong>Produzione.</strong> Posso preparare il materiale più in fretta?</li>
<li><strong>Distribuzione.</strong> Posso metterlo davanti alle persone giuste?</li>
<li><strong>Domanda.</strong> Quelle persone lo vogliono davvero?</li>
<li><strong>Economia.</strong> Dalla vendita, dopo i costi, resta qualcosa?</li>
</ul>
<p>Prima di impegnarmi su uno strumento a canone ricorrente, prenderei un solo libro. Il budget sarebbe fisso. Il periodo di misurazione lo fisserei prima.</p>
<p>Prima di pagare, controllerei quali funzioni sono davvero attive oggi, che cosa si rinnova da solo e se si paga altro oltre all’abbonamento.</p>
<p>Poi conterei gli acquisti conclusi e ciò che resta dopo la pubblicità, le commissioni della piattaforma e l’evasione dell’ordine. Non conterei i clic, né quanta pubblicità lo strumento produce.</p>
<p>Uno strumento può superare la propria prova e la vendita fallire lo stesso. Una bella pubblicità può non vendere nulla. Un negozio con un margine migliore può restare senza visitatori.</p>
<p>Parto dal collo di bottiglia. Lo strumento lo compro solo se risolve proprio quello.</p>

HTML,
        ],
        'uk' => [
            'title' => 'Купи на вузьке місце.',
            'image_alt' => 'Темна вузька щілина між фіолетовою стіною рухомої реклами і бірюзовою стійкою з книжками. У горлі лежать одна закрита книжка і порожня миска. Постать зі спини не йде ні до реклами, ні до стійки.',
            'excerpt' => 'У жовтні я дав розібрати BookSpace і Zeely. Одне пропонує продаж, друге рекламу і кампанію. Жодне з них саме не скаже, чи хтось купить цю книжку.',
            'content' => <<<'HTML'
<p>У жовтні я дав розібрати <a href="https://bookspace.com/">BookSpace</a> і <a href="https://zeely.ai/">Zeely</a>. Шукав, що з цього пасує до моїх книжок.</p>
<p>BookSpace пропонує інфраструктуру продажу. Zeely пропонує виробництво реклами й інструменти для кампанії. Це різна робота. Жодне з них саме не відповість, чи хтось купить саме цю книжку.</p>
<p>Розрізняю це так.</p>
<ul>
<li><strong>Виробництво.</strong> Чи можу я підготувати цей матеріал швидше?</li>
<li><strong>Дистрибуція.</strong> Чи можу я показати його потрібним людям?</li>
<li><strong>Попит.</strong> Чи ці люди справді його хочуть?</li>
<li><strong>Економіка.</strong> Чи після витрат від продажу щось лишається?</li>
</ul>
<p>Поки не візьму інструмент із повторною платою, я б узяв одну книжку. Бюджет був би фіксований. Період вимірювання я б визначив наперед.</p>
<p>Ще до оплати я б перевірив, які функції сьогодні справді працюють, що поновлюється само собою і чи доводиться платити ще щось, крім передплати.</p>
<p>Потім я б рахував завершені покупки і те, що лишається після реклами, комісій платформи і виконання замовлення. Кліки я б не рахував, і не те, скільки реклами інструмент виготовить.</p>
<p>Інструмент може витримати власну перевірку, а продаж усе одно не вийде. Гарна реклама може не продати нічого. Крамниця з кращою маржею може лишитися без відвідувача.</p>
<p>Починаю з вузького місця. Інструмент куплю, лише якщо розв’язує саме його.</p>

HTML,
        ],
    ],
];
