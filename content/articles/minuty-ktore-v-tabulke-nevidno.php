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
    'slug' => 'minuty-ktore-v-tabulke-nevidno',
    'author' => 'MUDr. Ľubomír Polaščín',
    'category' => 'blog',
    'is_top' => 0,
    'published_at' => '2026-11-21 08:00:00',
    'image' => 'images/articles/minuty-ktore-v-tabulke-nevidno.webp',
    'translations' => [
        'sk' => [
            'title' => 'Minúty, ktoré v tabuľke nevidno',
            'image_alt' => 'Otvorená kniha sa mení na presýpacie hodiny, v pozadí stojí prázdne liečebné kreslo.',
            'excerpt' => 'V Marži z krvi sa najprv stráca čas liečby. Zaujíma ma okamih, keď si človek zvykne na slovo, ktoré mu dovolí prestať vidieť následok.',
            'content' => <<<'HTML'
<p>V mojom románe Marža z krvi sa kradne po minútach. Bez rozbitého okna, bez prázdneho trezoru. Z liečby ubudne kúsok času a v tabuľke pribudne úspora.</p>
<p>Práve ten preklad ma zaujíma. Niečo sa stane konkrétnemu človeku, ale do porady príde iba uhladené pomenovanie. Keď sa opakuje dosť dlho, prestane znieť ako rozhodnutie. Začne znieť ako vlastnosť sveta.</p>
<p>Nefrológ, sestra a investigatívna novinárka v príbehu sledujú systém, v ktorom sa skrátená liečba mení na príležitosť zarobiť. Sú to románové postavy. Kniha nie je obvinením konkrétneho poskytovateľa a jej dej nie je opisom jednotlivého skutočného prípadu.</p>
<p>O dialýze píšem ako lekár, ktorý v nej pracuje od roku 1995. Literatúra mi však umožňuje položiť inú otázku než odborný článok: ako si človek vysvetlí prvý ústupok a čo musí prestať počuť, aby urobil ďalší?</p>
<p>Elektronické vydanie je už dostupné aj v katalógu predajcu. To je overiteľný publikačný krok, nie dôkaz o čítanosti či predajoch.</p>
<p>Pri každej úspore by som chcel vidieť ešte jeden stĺpec: čo sa zmenilo pre človeka, ktorý službu prijíma. Nemusí obsahovať číslo. Niekedy potrebuje celú vetu.</p>
<p>Keď sa úspora zmestí do tabuľky, človek by nemal zostať za jej okrajom.</p>
<p><small><em>Ľubomír Polaščín. <em>Marža z krvi</em>. <a href="https://www.digiport.cz/detail/bupebooks-1112189-marza-z-krvi/">Digiport</a>.</em></small></p>

HTML,
        ],
        'en' => [
            'title' => 'The minutes a spreadsheet cannot see',
            'image_alt' => 'An open book becomes an hourglass, with an empty treatment chair in the background.',
            'excerpt' => 'In Blood Margin, treatment time disappears first. I am interested in the moment someone adopts a word that lets them stop seeing its consequences.',
            'content' => <<<'HTML'
<p>In my novel Blood Margin, published in Slovak as Marža z krvi, theft happens minute by minute. No broken window, no empty safe. Treatment loses a little time; the spreadsheet gains a saving.</p>
<p>That translation interests me. Something happens to a particular person, but only a polished label reaches the meeting. Repeated often enough, it stops sounding like a decision and starts sounding like a fact of life.</p>
<p>A nephrologist, a nurse and an investigative journalist follow a fictional system where shortened treatment becomes a chance to profit. They are fictional characters. The book makes no allegation against a specific provider and does not portray an individual real case.</p>
<p>I write about dialysis as a physician working in the field since 1995. Fiction lets me ask a different question from a clinical article: how does someone justify the first compromise, and what must they stop hearing to make the next?</p>
<p>The ebook is now available in a retailer's catalogue. That is a verifiable publication milestone, not evidence of readership or sales.</p>
<p>For every saving, I would like one more column: what changed for the person receiving the service? It need not contain a number. Sometimes it needs a full sentence.</p>
<p>When a saving fits into a spreadsheet, the person should not fall outside its margins.</p>
<p><small><em>Ľubomír Polaščín. <em>Marža z krvi</em>. <a href="https://www.digiport.cz/detail/bupebooks-1112189-marza-z-krvi/">Digiport</a>.</em></small></p>

HTML,
        ],
        'cs' => [
            'title' => 'Minuty, které v tabulce nejsou vidět',
            'image_alt' => 'Otevřená kniha se mění v přesýpací hodiny, v pozadí stojí prázdné léčebné křeslo.',
            'excerpt' => 'V románu Marža z krvi nejprve mizí čas léčby. Zajímá mě chvíle, kdy si člověk zvykne na slovo, které mu dovolí přehlížet následky.',
            'content' => <<<'HTML'
<p>V mém románu Marža z krvi se krade po minutách. Bez rozbitého okna, bez prázdného trezoru. Z léčby ubude kousek času a v tabulce přibude úspora.</p>
<p>Právě tento překlad mě zajímá. Něco se stane konkrétnímu člověku, ale na poradu dorazí jen uhlazené pojmenování. Když se opakuje dost dlouho, přestane znít jako rozhodnutí. Začne znít jako vlastnost světa.</p>
<p>Nefrolog, sestra a investigativní novinářka sledují fiktivní systém, v němž se zkrácená léčba mění v příležitost vydělat. Jsou to románové postavy. Kniha neobviňuje konkrétního poskytovatele a nepopisuje jednotlivý skutečný případ.</p>
<p>O dialýze píšu jako lékař, který v ní pracuje od roku 1995. Literatura mi umožňuje jinou otázku než odborný článek: jak si člověk vysvětlí první ústupek a co musí přestat slyšet, aby udělal další?</p>
<p>Elektronické vydání je už dostupné i v katalogu prodejce. To je ověřitelný publikační krok, nikoli důkaz čtenosti nebo prodejů.</p>
<p>U každé úspory bych chtěl ještě jeden sloupec: co se změnilo pro člověka, který službu přijímá. Nemusí obsahovat číslo. Někdy potřebuje celou větu.</p>
<p>Když se úspora vejde do tabulky, člověk by neměl zůstat za jejím okrajem.</p>
<p><small><em>Ľubomír Polaščín. <em>Marža z krvi</em>. <a href="https://www.digiport.cz/detail/bupebooks-1112189-marza-z-krvi/">Digiport</a>.</em></small></p>

HTML,
        ],
        'de' => [
            'title' => 'Die Minuten, die eine Tabelle nicht sieht',
            'image_alt' => 'Ein offenes Buch wird zur Sanduhr, im Hintergrund steht ein leerer Behandlungsstuhl.',
            'excerpt' => 'In Marža z krvi verschwindet zuerst Behandlungszeit. Mich interessiert der Moment, in dem ein Wort erlaubt, die Folgen nicht mehr zu sehen.',
            'content' => <<<'HTML'
<p>In meinem Roman Marža z krvi wird minutenweise gestohlen. Kein zerbrochenes Fenster, kein leerer Tresor. Der Behandlung fehlt etwas Zeit, die Tabelle gewinnt eine Einsparung.</p>
<p>Diese Übersetzung interessiert mich. Einem konkreten Menschen geschieht etwas, doch zur Besprechung gelangt nur eine geglättete Bezeichnung. Oft genug wiederholt, klingt sie nicht mehr nach einer Entscheidung, sondern nach einer Eigenschaft der Welt.</p>
<p>Ein Nephrologe, eine Pflegekraft und eine investigative Journalistin verfolgen ein fiktives System, in dem verkürzte Behandlung zur Gewinnchance wird. Es sind Romanfiguren. Das Buch beschuldigt keinen konkreten Anbieter und schildert keinen einzelnen realen Fall.</p>
<p>Ich schreibe als Arzt über Dialyse und arbeite seit 1995 in diesem Bereich. Literatur erlaubt eine andere Frage als ein Fachartikel: Wie rechtfertigt jemand den ersten Kompromiss, und was muss er überhören, um den nächsten einzugehen?</p>
<p>Das E-Book ist inzwischen auch im Händlerkatalog erhältlich. Das ist ein überprüfbarer Veröffentlichungsschritt, kein Beleg für Leserzahlen oder Verkäufe.</p>
<p>Zu jeder Einsparung wünsche ich mir eine weitere Spalte: Was hat sich für den Menschen geändert, der die Leistung erhält? Darin muss keine Zahl stehen. Manchmal braucht es einen ganzen Satz.</p>
<p>Wenn die Einsparung in die Tabelle passt, darf der Mensch nicht außerhalb ihres Randes bleiben.</p>
<p><small><em>Ľubomír Polaščín. <em>Marža z krvi</em>. <a href="https://www.digiport.cz/detail/bupebooks-1112189-marza-z-krvi/">Digiport</a>.</em></small></p>

HTML,
        ],
        'fr' => [
            'title' => 'Les minutes qu\'un tableau ne voit pas',
            'image_alt' => 'Un livre ouvert devient un sablier, avec un fauteuil de soins vide à l\'arrière-plan.',
            'excerpt' => 'Dans Marža z krvi, le temps de traitement disparaît d\'abord. Je m\'intéresse au moment où un mot permet de ne plus voir les conséquences.',
            'content' => <<<'HTML'
<p>Dans mon roman Marža z krvi, le vol se fait minute par minute. Sans vitre brisée ni coffre vide. Le traitement perd un peu de temps, le tableau gagne une économie.</p>
<p>Cette traduction m'intéresse. Quelque chose arrive à une personne précise, mais seule une appellation lissée parvient à la réunion. À force de répétition, elle cesse de ressembler à une décision. Elle devient une propriété du monde.</p>
<p>Un néphrologue, une infirmière et une journaliste d'investigation suivent un système fictif où raccourcir les soins devient une occasion de profit. Ce sont des personnages romanesques. Le livre n'accuse aucun prestataire précis et ne décrit aucun cas réel individuel.</p>
<p>J'écris sur la dialyse comme médecin travaillant dans ce domaine depuis 1995. La littérature permet une autre question qu'un article clinique : comment justifie-t-on le premier compromis, et que faut-il cesser d'entendre pour accepter le suivant ?</p>
<p>Le livre numérique figure désormais au catalogue d'un revendeur. C'est une étape de publication vérifiable, pas une preuve de lectorat ou de ventes.</p>
<p>À chaque économie, j'ajouterais une colonne : qu'est-ce qui a changé pour la personne recevant le service ? Un chiffre ne suffit pas toujours. Il faut parfois une phrase entière.</p>
<p>Quand l'économie tient dans le tableau, la personne ne doit pas rester en dehors.</p>
<p><small><em>Ľubomír Polaščín. <em>Marža z krvi</em>. <a href="https://www.digiport.cz/detail/bupebooks-1112189-marza-z-krvi/">Digiport</a>.</em></small></p>

HTML,
        ],
        'es' => [
            'title' => 'Los minutos que una tabla no ve',
            'image_alt' => 'Un libro abierto se transforma en reloj de arena, con un sillón de tratamiento vacío al fondo.',
            'excerpt' => 'En Marža z krvi, primero desaparece tiempo de tratamiento. Me interesa el momento en que una palabra permite dejar de ver las consecuencias.',
            'content' => <<<'HTML'
<p>En mi novela Marža z krvi se roba minuto a minuto. Sin cristales rotos ni cajas fuertes vacías. El tratamiento pierde algo de tiempo y la tabla gana un ahorro.</p>
<p>Esa traducción me interesa. Algo le sucede a una persona concreta, pero a la reunión solo llega una expresión pulida. Tras repetirse bastante, deja de sonar a decisión. Empieza a parecer una propiedad del mundo.</p>
<p>Un nefrólogo, una enfermera y una periodista de investigación siguen un sistema ficticio donde acortar tratamientos se convierte en oportunidad de beneficio. Son personajes de ficción. El libro no acusa a un proveedor concreto ni describe un caso real individual.</p>
<p>Escribo sobre diálisis como médico que trabaja en ella desde 1995. La literatura permite una pregunta distinta de la de un artículo clínico: ¿cómo se justifica el primer compromiso y qué hay que dejar de escuchar para aceptar el siguiente?</p>
<p>El libro electrónico ya está disponible en el catálogo de un vendedor. Es un paso editorial verificable, no prueba de lectores o ventas.</p>
<p>A cada ahorro añadiría una columna: qué cambió para la persona que recibe el servicio. No tiene que contener una cifra. A veces necesita una frase entera.</p>
<p>Cuando el ahorro cabe en la tabla, la persona no debería quedar fuera de sus márgenes.</p>
<p><small><em>Ľubomír Polaščín. <em>Marža z krvi</em>. <a href="https://www.digiport.cz/detail/bupebooks-1112189-marza-z-krvi/">Digiport</a>.</em></small></p>

HTML,
        ],
        'pl' => [
            'title' => 'Minuty, których nie widać w tabeli',
            'image_alt' => 'Otwarta książka zamienia się w klepsydrę, w tle stoi pusty fotel zabiegowy.',
            'excerpt' => 'W Marža z krvi najpierw znika czas leczenia. Interesuje mnie chwila, gdy słowo pozwala człowiekowi przestać dostrzegać konsekwencje.',
            'content' => <<<'HTML'
<p>W mojej powieści Marža z krvi kradnie się po minucie. Bez wybitego okna i pustego sejfu. Z leczenia ubywa trochę czasu, a w tabeli przybywa oszczędność.</p>
<p>Właśnie to tłumaczenie mnie interesuje. Coś spotyka konkretnego człowieka, ale na zebranie dociera tylko wygładzone określenie. Powtarzane odpowiednio długo przestaje brzmieć jak decyzja. Staje się właściwością świata.</p>
<p>Nefrolog, pielęgniarka i dziennikarka śledcza przyglądają się fikcyjnemu systemowi, w którym skrócone leczenie staje się okazją do zysku. To postacie powieściowe. Książka nie oskarża konkretnego świadczeniodawcy ani nie opisuje pojedynczego rzeczywistego przypadku.</p>
<p>Piszę o dializie jako lekarz pracujący w tej dziedzinie od 1995 roku. Literatura pozwala zapytać inaczej niż artykuł kliniczny: jak człowiek uzasadnia pierwszy kompromis i co musi przestać słyszeć, by zgodzić się na następny?</p>
<p>E-book jest już dostępny w katalogu sprzedawcy. To weryfikowalny krok wydawniczy, nie dowód liczby czytelników czy sprzedaży.</p>
<p>Przy każdej oszczędności chciałbym jeszcze jedną kolumnę: co zmieniło się dla odbiorcy usługi. Nie musi zawierać liczby. Czasami potrzebuje całego zdania.</p>
<p>Gdy oszczędność mieści się w tabeli, człowiek nie powinien zostać poza jej granicami.</p>
<p><small><em>Ľubomír Polaščín. <em>Marža z krvi</em>. <a href="https://www.digiport.cz/detail/bupebooks-1112189-marza-z-krvi/">Digiport</a>.</em></small></p>

HTML,
        ],
        'hu' => [
            'title' => 'A percek, amelyeket a táblázat nem lát',
            'image_alt' => 'Egy nyitott könyv homokórává alakul, a háttérben üres kezelőszék áll.',
            'excerpt' => 'A Marža z krvi történetében először a kezelési idő tűnik el. Az a pillanat érdekel, amikor egy szó lehetővé teszi a következmények figyelmen kívül hagyását.',
            'content' => <<<'HTML'
<p>A Marža z krvi című regényemben percenként lopnak. Betört ablak és üres páncélszekrény nélkül. A kezelésből idő fogy, a táblázatban megtakarítás keletkezik.</p>
<p>Ez az átfordítás érdekel. Valami történik egy konkrét emberrel, de az értekezletre csak egy simára csiszolt elnevezés jut el. Elég sokszor ismételve már nem döntésnek hangzik. A világ adottságának tűnik.</p>
<p>Egy nefrológus, egy ápolónő és egy oknyomozó újságírónő követi a fiktív rendszert, amelyben a rövidebb kezelés nyereséglehetőséggé válik. Regényalakok. A könyv nem vádol konkrét szolgáltatót, és nem egyetlen valós eset leírása.</p>
<p>Olyan orvosként írok a dialízisről, aki 1995 óta dolgozik ezen a területen. Az irodalom más kérdést enged, mint egy klinikai cikk: hogyan magyarázza meg valaki az első engedményt, és mit kell többé meg nem hallania a következőhöz?</p>
<p>Az e-könyv már egy kereskedő katalógusában is elérhető. Ez ellenőrizhető kiadási lépés, nem olvasottsági vagy eladási adat.</p>
<p>Minden megtakarításhoz hozzátennék egy oszlopot: mi változott a szolgáltatást kapó embernek? Nem feltétlenül szám kell bele. Néha egy teljes mondat.</p>
<p>Ha a megtakarítás belefér a táblázatba, az ember ne maradjon a szélén kívül.</p>
<p><small><em>Ľubomír Polaščín. <em>Marža z krvi</em>. <a href="https://www.digiport.cz/detail/bupebooks-1112189-marza-z-krvi/">Digiport</a>.</em></small></p>

HTML,
        ],
        'it' => [
            'title' => 'I minuti che una tabella non vede',
            'image_alt' => 'Un libro aperto diventa una clessidra, con una poltrona da trattamento vuota sullo sfondo.',
            'excerpt' => 'In Marža z krvi scompare prima il tempo di cura. Mi interessa il momento in cui una parola permette di non vedere più le conseguenze.',
            'content' => <<<'HTML'
<p>Nel mio romanzo Marža z krvi si ruba un minuto alla volta. Nessun vetro rotto, nessuna cassaforte vuota. La cura perde un po' di tempo e la tabella guadagna un risparmio.</p>
<p>È questa traduzione a interessarmi. Qualcosa accade a una persona precisa, ma in riunione arriva solo un'espressione levigata. Ripetuta abbastanza, smette di sembrare una decisione. Diventa una proprietà del mondo.</p>
<p>Un nefrologo, un'infermiera e una giornalista investigativa seguono un sistema immaginario dove accorciare le cure diventa un'occasione di profitto. Sono personaggi di finzione. Il libro non accusa un fornitore concreto né descrive un singolo caso reale.</p>
<p>Scrivo di dialisi come medico che vi lavora dal 1995. La letteratura consente una domanda diversa da un articolo clinico: come si giustifica il primo compromesso e che cosa bisogna smettere di ascoltare per accettare il successivo?</p>
<p>L'ebook è ora disponibile anche nel catalogo di un rivenditore. È un passaggio editoriale verificabile, non una prova di lettori o vendite.</p>
<p>A ogni risparmio aggiungerei una colonna: che cosa è cambiato per chi riceve il servizio? Non deve contenere per forza un numero. A volte serve una frase intera.</p>
<p>Quando il risparmio entra nella tabella, la persona non dovrebbe restare fuori dai suoi margini.</p>
<p><small><em>Ľubomír Polaščín. <em>Marža z krvi</em>. <a href="https://www.digiport.cz/detail/bupebooks-1112189-marza-z-krvi/">Digiport</a>.</em></small></p>

HTML,
        ],
        'uk' => [
            'title' => 'Хвилини, яких не видно в таблиці',
            'image_alt' => 'Розкрита книжка перетворюється на пісочний годинник, позаду стоїть порожнє лікувальне крісло.',
            'excerpt' => 'У Marža z krvi спершу зникає час лікування. Мене цікавить мить, коли слово дозволяє людині більше не бачити наслідків.',
            'content' => <<<'HTML'
<p>У моєму романі Marža z krvi крадуть по хвилині. Без розбитого вікна й порожнього сейфа. У лікуванні меншає часу, а в таблиці більшає економії.</p>
<p>Саме цей переклад мене цікавить. Щось стається з конкретною людиною, але на нараду потрапляє лише відшліфована назва. Повторювана досить довго, вона перестає звучати як рішення. Стає властивістю світу.</p>
<p>Нефролог, медсестра й журналістка-розслідувачка стежать за вигаданою системою, у якій скорочене лікування стає нагодою заробити. Це персонажі роману. Книжка не звинувачує конкретного надавача послуг і не описує окремого реального випадку.</p>
<p>Я пишу про діаліз як лікар, який працює в цій галузі з 1995 року. Література дозволяє інше запитання, ніж клінічна стаття: як людина пояснює собі першу поступку й чого мусить більше не чути, щоб зробити наступну?</p>
<p>Електронне видання вже доступне й у каталозі продавця. Це перевірений видавничий крок, а не доказ читацького охоплення чи продажів.</p>
<p>До кожної економії я додав би стовпець: що змінилося для людини, яка отримує послугу? Не обов’язково число. Іноді потрібне ціле речення.</p>
<p>Коли економія вміщується в таблиці, людина не повинна залишатися поза її межами.</p>
<p><small><em>Ľubomír Polaščín. <em>Marža z krvi</em>. <a href="https://www.digiport.cz/detail/bupebooks-1112189-marza-z-krvi/">Digiport</a>.</em></small></p>

HTML,
        ],
    ],
];
