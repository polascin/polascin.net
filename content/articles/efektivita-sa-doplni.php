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
 * Efektivita, ktorá sa doplní novou prácou.
 * Zdroj: Devrim Ozcay, Javarevisited / Medium, 21. 9. 2026.
 * Verejný podtitul článku overený; percento a doslovná odpoveď za paywallom nie sú v texte.
 */
return [
    'slug' => 'efektivita-sa-doplni',
    'author' => 'MUDr. Ľubomír Polaščín',
    'category' => 'blog',
    'is_top' => 0,
    'published_at' => '2026-10-03 21:30:00',
    'image' => 'images/articles/efektivita-sa-doplni.webp',
    'translations' => [
        'sk' => [
            'title' => 'Efektivita sa neodmeňuje. Uvoľnený čas sa doplní.',
            'image_alt' => 'Muž od chrbta pri tmavom stole zdvihne ruku. Na doske žiari prázdny tyrkysový štvorec, fialové karty sa vlievajú zo stohu, nad stolom svieti otvorená kniha a vzadu stojí prázdne kreslo.',
            'excerpt' => 'Inžinier v texte Devrima Ozcaya zautomatizoval väčšinu opakovanej práce. Tím to zistil až na dovolenke. Firma nebola zlomyseľná. Len vie, čo spraviť s voľnou kapacitou. Ak nerozhodnete, hodiny, ktoré vráti AI, sa naplnia tou istou prácou.',
            'content' => <<<'HTML'
<p>Efektivita sa neodmeňuje. Uvoľnený čas sa doplní.</p>
<p>Koncom septembra som čítal text, ktorý v publikácii <a href="https://medium.com/javarevisited">Javarevisited</a> na Medium napísal Devrim Ozcay. Volá sa <a href="https://medium.com/javarevisited/one-of-our-employees-secretly-had-ai-doing-most-of-his-job-we-found-out-because-he-took-a-vacation-bc0eedb0fd94"><em>One of Our Employees Secretly Had AI Doing Most of His Job. We Found Out Because He Took a Vacation.</em></a> Vyšiel 21. septembra 2026.</p>
<p>Inžiniera v texte volá Marcus. Deväť mesiacov si na jeho výkon nikto nesťažoval. Práca chodila načas, zákazníci dostávali odpovede, hlásenia chodili každý piatok a systémy, ktoré mal na starosti, robili menej problémov než predtým. Potom si vzal dva týždne voľna. Do stredu tím zistil, že väčšinu práce, za ktorú ho platili, potichu zautomatizoval.</p>
<p>Najviac mi ostala otázka, ktorú mu v tom texte položili: prečo si nám to nepovedal? Nie preto, že by niekto klamal. Preto, že uvoľnené hodiny nezostali voľné. Zautomatizoval proces, ušetril čas a do mesiaca bol ten čas plný nových povinností. Časť z nich zautomatizoval tiež. Prišla ďalšia práca.</p>
<p>Nikto nebol zlomyseľný. Stal sa človekom, ktorý má kapacitu. A firmy vedia veľmi presne, čo s kapacitou spraviť.</p>
<p>Sám prevádzkujem AI agentov, najmä v Cursori. Pripravujú koncepty, kontrolujú ich a pomáhajú s nasadením. Keďže pracujem sám, som aj ten, kto rozhoduje, čo sa stane s vráteným časom.</p>
<p>To je iný problém než ten v Ozcayovom texte. Väčšina tímov nemá výslovnú odpoveď na otázku, čo sa stane s hodinami, ktoré AI vráti.</p>
<p>Ak nerozhodnete, samo od seba príde viac tej istej práce, len rýchlejšie. Ten čas sa nikomu nevráti.</p>
<p>Preto som sa o tom začal rozhodovať zámerne. Časť ide do hĺbky, časť do oddychu a časť do práce, ktorú by som predtým odmietol. Nie je to výkaz hodín. Je to pravidlo. Inak sa prázdno doplní samo.</p>
<p>Vedúci: ak vám zamestnanec povie, že mu AI ušetrila desať hodín týždenne, aký je váš úprimný ďalší krok?</p>
<p>Napíšte mi cez <a href="contact.php">kontakt</a>.</p>
HTML,
        ],
        'en' => [
            'title' => 'Efficiency is not rewarded. Freed time gets refilled.',
            'image_alt' => 'A man seen from behind at a dark desk raises his hand. An empty teal square glows on the desktop while purple cards flow in from a stack; an open book under a lamp and an empty chair wait beyond.',
            'excerpt' => 'An engineer in Devrim Ozcay’s piece automated most of his recurring work. The team found out only when he went on leave. Nobody was malicious. Companies know what to do with spare capacity. If you do not decide, the hours AI gives back fill with the same work.',
            'content' => <<<'HTML'
<p>Efficiency is not rewarded. Freed time gets refilled.</p>
<p>Late in September I read a piece Devrim Ozcay published in <a href="https://medium.com/javarevisited">Javarevisited</a> on Medium. It is called <a href="https://medium.com/javarevisited/one-of-our-employees-secretly-had-ai-doing-most-of-his-job-we-found-out-because-he-took-a-vacation-bc0eedb0fd94"><em>One of Our Employees Secretly Had AI Doing Most of His Job. We Found Out Because He Took a Vacation.</em></a> It came out on 21 September 2026.</p>
<p>In the piece the engineer is called Marcus. For nine months nobody complained about his performance. The work arrived on time, customers got answers, reports appeared every Friday, and the systems he owned caused fewer problems than before. Then he took two weeks off. By Wednesday the team discovered that he had quietly automated most of the job they were paying him to do.</p>
<p>The question that stayed with me is the one they ask him in that piece: why didn’t you tell us? Not because anyone was lying. Because the freed hours did not stay free. He automated a process, saved time, and within a month that time was full of new responsibilities. He automated part of those too. More work arrived.</p>
<p>Nobody was malicious. He became the person with capacity. And companies know exactly what to do with capacity.</p>
<p>I run AI agents myself, mostly in Cursor. They draft, review, and help me deploy. I work alone, so I am also the person who decides what happens to the time that comes back.</p>
<p>That is a different problem from the one in Ozcay’s piece. Most teams have no explicit answer to what happens to the hours AI gives back.</p>
<p>If you do not decide, the default is more of the same work, only faster. Nobody gets that time back.</p>
<p>So I have started deciding on purpose. Some of it goes to depth, some to rest, and some to work I would have declined before. This is not a timesheet. It is a rule. Otherwise the empty space refills itself.</p>
<p>Leaders: if an employee tells you AI saved them ten hours a week, what is your honest next move?</p>
<p>Write to me via the <a href="contact.php">contact form</a>.</p>
HTML,
        ],
        'cs' => [
            'title' => 'Efektivita se neodměňuje. Uvolněný čas se zaplní.',
            'image_alt' => 'Muž zády k nám u tmavého stolu zvedne ruku. Na desce září prázdný tyrkysový čtverec, fialové karty se vlévají ze stohu, nad stolem svítí otevřená kniha a vzadu stojí prázdné křeslo.',
            'excerpt' => 'Inženýr v textu Devrima Ozcaye zautomatizoval většinu opakované práce. Tým to zjistil až na dovolené. Firma nebyla zlomyslná. Jen ví, co udělat s volnou kapacitou. Když nerozhodnete, hodiny, které vrátí AI, se naplní toutéž prací.',
            'content' => <<<'HTML'
<p>Efektivita se neodměňuje. Uvolněný čas se zaplní.</p>
<p>Koncem září jsem četl text, který v publikaci <a href="https://medium.com/javarevisited">Javarevisited</a> na Medium napsal Devrim Ozcay. Jmenuje se <a href="https://medium.com/javarevisited/one-of-our-employees-secretly-had-ai-doing-most-of-his-job-we-found-out-because-he-took-a-vacation-bc0eedb0fd94"><em>One of Our Employees Secretly Had AI Doing Most of His Job. We Found Out Because He Took a Vacation.</em></a> Vyšel 21. září 2026.</p>
<p>Inženýra v textu nazývá Marcus. Devět měsíců si na jeho výkon nikdo nestěžoval. Práce chodila včas, zákazníci dostávali odpovědi, hlášení byla každý pátek a systémy, které měl na starosti, dělaly méně problémů než dřív. Pak si vzal dva týdny volna. Do středy tým zjistil, že většinu práce, za kterou ho platili, potichu zautomatizoval.</p>
<p>Nejvíc mi zůstala otázka, kterou mu v tom textu položili: proč jsi nám to neřekl? Ne proto, že by někdo lhal. Proto, že uvolněné hodiny nezůstaly volné. Zautomatizoval proces, ušetřil čas a do měsíce byl ten čas plný nových povinností. Část z nich zautomatizoval také. Přišla další práce.</p>
<p>Nikdo nebyl zlomyslný. Stal se člověkem, který má kapacitu. A firmy velmi přesně vědí, co s kapacitou udělat.</p>
<p>Sám provozuji AI agenty, zejména v Cursoru. Připravují koncepty, kontrolují je a pomáhají s nasazením. Protože pracuji sám, jsem také ten, kdo rozhoduje, co se stane s vráceným časem.</p>
<p>To je jiný problém než ten v Ozcayově textu. Většina týmů nemá výslovnou odpověď na otázku, co se stane s hodinami, které AI vrátí.</p>
<p>Když nerozhodnete, samo od sebe přijde víc téže práce, jen rychleji. Ten čas se nikomu nevrátí.</p>
<p>Proto jsem se o tom začal rozhodovat záměrně. Část jde do hloubky, část do odpočinku a část do práce, kterou bych dřív odmítl. Není to výkaz hodin. Je to pravidlo. Jinak se prázdno zaplní samo.</p>
<p>Vedoucí: když vám zaměstnanec řekne, že mu AI ušetřila deset hodin týdně, jaký je váš upřímný další krok?</p>
<p>Napište mi přes <a href="contact.php">kontakt</a>.</p>
HTML,
        ],
        'de' => [
            'title' => 'Effizienz wird nicht belohnt. Freie Zeit füllt sich wieder.',
            'image_alt' => 'Ein Mann von hinten an einem dunklen Tisch hebt die Hand. Auf der Platte leuchtet ein leeres türkises Quadrat, violette Karten fließen aus einem Stapel, darüber eine Lampe auf einem offenen Buch, hinten ein leerer Sessel.',
            'excerpt' => 'Ein Ingenieur in Devrim Ozcays Text hat den größten Teil der wiederkehrenden Arbeit automatisiert. Das Team merkte es erst im Urlaub. Niemand war böswillig. Firmen wissen, was sie mit freier Kapazität tun. Wer nicht entscheidet, füllt die von KI zurückgegebenen Stunden mit derselben Arbeit.',
            'content' => <<<'HTML'
<p>Effizienz wird nicht belohnt. Freie Zeit füllt sich wieder.</p>
<p>Ende September habe ich einen Text gelesen, den Devrim Ozcay in der Medium-Publikation <a href="https://medium.com/javarevisited">Javarevisited</a> veröffentlicht hat. Er heißt <a href="https://medium.com/javarevisited/one-of-our-employees-secretly-had-ai-doing-most-of-his-job-we-found-out-because-he-took-a-vacation-bc0eedb0fd94"><em>One of Our Employees Secretly Had AI Doing Most of His Job. We Found Out Because He Took a Vacation.</em></a> Erschienen ist er am 21. September 2026.</p>
<p>Den Ingenieur nennt der Text Marcus. Neun Monate lang beschwerte sich niemand über seine Leistung. Die Arbeit kam pünktlich, Kunden bekamen Antworten, Berichte erschienen jeden Freitag, und die Systeme, für die er verantwortlich war, machten weniger Probleme als zuvor. Dann nahm er zwei Wochen Urlaub. Bis Mittwoch stellte das Team fest, dass er den größten Teil der Arbeit, für die man ihn bezahlte, still automatisiert hatte.</p>
<p>Am meisten blieb die Frage hängen, die man ihm in dem Text stellt: Warum hast du es uns nicht gesagt? Nicht, weil jemand gelogen hätte. Sondern weil die freien Stunden nicht frei blieben. Er automatisierte einen Ablauf, sparte Zeit, und innerhalb eines Monats war diese Zeit voller neuer Aufgaben. Einen Teil davon automatisierte er ebenfalls. Es kam weitere Arbeit.</p>
<p>Niemand war böswillig. Er wurde der Mensch mit Kapazität. Und Unternehmen wissen genau, was sie mit Kapazität tun.</p>
<p>Ich betreibe selbst KI-Agenten, vor allem in Cursor. Sie schreiben Entwürfe, prüfen sie und helfen beim Veröffentlichen. Weil ich allein arbeite, entscheide auch ich, was mit der zurückgewonnenen Zeit geschieht.</p>
<p>Das ist ein anderes Problem als das bei Ozcay. Die meisten Teams haben keine ausdrückliche Antwort darauf, was mit den Stunden geschieht, die KI zurückgibt.</p>
<p>Wenn Sie nicht entscheiden, kommt standardmäßig mehr von derselben Arbeit, nur schneller. Diese Zeit bekommt niemand zurück.</p>
<p>Deshalb habe ich angefangen, das bewusst zu entscheiden. Ein Teil geht in die Tiefe, ein Teil in die Ruhe und ein Teil in Arbeit, die ich früher abgelehnt hätte. Das ist keine Stundenzählung. Es ist eine Regel. Sonst füllt sich die Leere von selbst.</p>
<p>Führungskräfte: Wenn ein Mitarbeiter Ihnen sagt, dass KI ihm zehn Stunden pro Woche gespart hat, was ist Ihr ehrlicher nächster Schritt?</p>
<p>Schreiben Sie mir über das <a href="contact.php">Kontaktformular</a>.</p>
HTML,
        ],
        'fr' => [
            'title' => 'L’efficacité n’est pas récompensée. Le temps libéré se remplit.',
            'image_alt' => 'Un homme vu de dos, devant un bureau sombre, lève la main. Un carré turquoise vide luit sur le plateau, des cartes violettes arrivent d’une pile, une lampe éclaire un livre ouvert et un fauteuil vide attend derrière.',
            'excerpt' => 'Un ingénieur, dans le texte de Devrim Ozcay, a automatisé la plus grande partie du travail répétitif. L’équipe ne l’a su qu’à ses congés. Personne n’était malveillant. L’entreprise sait quoi faire d’une capacité libre. Sans décision, les heures rendues par l’IA se remplissent du même travail.',
            'content' => <<<'HTML'
<p>L’efficacité n’est pas récompensée. Le temps libéré se remplit.</p>
<p>Fin septembre, j’ai lu un texte que Devrim Ozcay a publié dans <a href="https://medium.com/javarevisited">Javarevisited</a> sur Medium. Il s’intitule <a href="https://medium.com/javarevisited/one-of-our-employees-secretly-had-ai-doing-most-of-his-job-we-found-out-because-he-took-a-vacation-bc0eedb0fd94"><em>One of Our Employees Secretly Had AI Doing Most of His Job. We Found Out Because He Took a Vacation.</em></a> Il est paru le 21 septembre 2026.</p>
<p>Dans le texte, l’ingénieur s’appelle Marcus. Pendant neuf mois, personne ne s’est plaint de son travail. Le travail arrivait à l’heure, les clients recevaient des réponses, les rapports paraissaient chaque vendredi, et les systèmes dont il avait la charge causaient moins de problèmes qu’avant. Puis il a pris deux semaines de congé. Dès le mercredi, l’équipe a découvert qu’il avait discrètement automatisé la plus grande partie du travail pour lequel on le payait.</p>
<p>La question qui m’est restée est celle qu’on lui pose dans ce texte : pourquoi ne nous l’as-tu pas dit ? Pas parce que quelqu’un aurait menti. Parce que les heures libérées ne sont pas restées libres. Il a automatisé un processus, gagné du temps, et en un mois ce temps était plein de nouvelles responsabilités. Il en a automatisé une partie aussi. Du travail supplémentaire est arrivé.</p>
<p>Personne n’était malveillant. Il est devenu l’homme qui a de la capacité. Et les entreprises savent très bien quoi faire de la capacité.</p>
<p>Je fais tourner moi-même des agents d’IA, surtout dans Cursor. Ils préparent des brouillons, les relisent et m’aident à publier. Comme je travaille seul, je suis aussi celui qui décide de ce qui arrive au temps récupéré.</p>
<p>C’est un autre problème que celui du texte d’Ozcay. La plupart des équipes n’ont pas de réponse explicite à ce que deviennent les heures que l’IA rend.</p>
<p>Si vous ne décidez pas, la valeur par défaut est davantage du même travail, plus vite. Personne ne récupère ce temps.</p>
<p>J’ai donc commencé à en décider exprès. Une part va à la profondeur, une part au repos, une part au travail que j’aurais refusé avant. Ce n’est pas un relevé d’heures. C’est une règle. Sinon, le vide se remplit tout seul.</p>
<p>Responsables : si un employé vous dit que l’IA lui a fait gagner dix heures par semaine, quel est votre prochain geste honnête ?</p>
<p>Écrivez-moi via le <a href="contact.php">formulaire de contact</a>.</p>
HTML,
        ],
        'es' => [
            'title' => 'La eficiencia no se premia. El tiempo liberado vuelve a llenarse.',
            'image_alt' => 'Un hombre de espaldas, ante un escritorio oscuro, levanta la mano. En la superficie brilla un cuadrado turquesa vacío, las tarjetas moradas llegan desde una pila, una lámpara ilumina un libro abierto y al fondo hay un sillón vacío.',
            'excerpt' => 'Un ingeniero, en el texto de Devrim Ozcay, automatizó la mayor parte del trabajo repetido. El equipo lo supo solo en sus vacaciones. Nadie fue malintencionado. La empresa sabe qué hacer con la capacidad libre. Si usted no decide, las horas que devuelve la IA se llenan del mismo trabajo.',
            'content' => <<<'HTML'
<p>La eficiencia no se premia. El tiempo liberado vuelve a llenarse.</p>
<p>A finales de septiembre leí un texto que Devrim Ozcay publicó en <a href="https://medium.com/javarevisited">Javarevisited</a>, en Medium. Se llama <a href="https://medium.com/javarevisited/one-of-our-employees-secretly-had-ai-doing-most-of-his-job-we-found-out-because-he-took-a-vacation-bc0eedb0fd94"><em>One of Our Employees Secretly Had AI Doing Most of His Job. We Found Out Because He Took a Vacation.</em></a> Salió el 21 de septiembre de 2026.</p>
<p>En el texto, al ingeniero lo llama Marcus. Durante nueve meses nadie se quejó de su rendimiento. El trabajo llegaba a tiempo, los clientes recibían respuestas, los informes aparecían cada viernes y los sistemas a su cargo daban menos problemas que antes. Luego se tomó dos semanas de vacaciones. Para el miércoles el equipo descubrió que había automatizado en silencio la mayor parte del trabajo por el que le pagaban.</p>
<p>La pregunta que me quedó es la que le hacen en ese texto: ¿por qué no nos lo dijiste? No porque alguien mintiera. Porque las horas liberadas no siguieron libres. Automatizó un proceso, ahorró tiempo y, en un mes, ese tiempo estaba lleno de nuevas responsabilidades. Automatizó parte de eso también. Llegó más trabajo.</p>
<p>Nadie fue malintencionado. Se convirtió en la persona con capacidad. Y las empresas saben muy bien qué hacer con la capacidad.</p>
<p>Yo mismo hago funcionar agentes de IA, sobre todo en Cursor. Preparan borradores, los revisan y me ayudan a publicar. Como trabajo solo, también soy quien decide qué pasa con el tiempo recuperado.</p>
<p>Es un problema distinto del que plantea el texto de Ozcay. La mayoría de los equipos no tiene una respuesta explícita sobre qué ocurre con las horas que la IA devuelve.</p>
<p>Si usted no decide, lo predeterminado es más del mismo trabajo, más rápido. Nadie recupera ese tiempo.</p>
<p>Por eso he empezado a decidirlo a propósito. Una parte va a la profundidad, una al descanso y una al trabajo que antes habría rechazado. No es un parte de horas. Es una regla. Si no, el vacío se llena solo.</p>
<p>Directivos: si un empleado les dice que la IA le ahorró diez horas a la semana, ¿cuál es su siguiente paso honesto?</p>
<p>Escríbame a través del <a href="contact.php">formulario de contacto</a>.</p>
HTML,
        ],
        'pl' => [
            'title' => 'Efektywności się nie nagradza. Uwolniony czas się zapełnia.',
            'image_alt' => 'Mężczyzna od tyłu przy ciemnym stole unosi dłoń. Na blacie świeci pusty turkusowy kwadrat, fioletowe karty spływają ze stosu, nad stołem lampa oświetla otwartą książkę, a w tle stoi pusty fotel.',
            'excerpt' => 'Inżynier w tekście Devrima Ozcaya zautomatyzował większą część powtarzalnej pracy. Zespół dowiedział się dopiero na urlopie. Nikt nie był złośliwy. Firma wie, co zrobić z kimś, kto ma zapas czasu. Jeśli nie zdecydujesz, godziny oddane przez AI wypełni ta sama praca.',
            'content' => <<<'HTML'
<p>Efektywności się nie nagradza. Uwolniony czas się zapełnia.</p>
<p>Pod koniec września przeczytałem tekst, który Devrim Ozcay opublikował w <a href="https://medium.com/javarevisited">Javarevisited</a> na Medium. Nosi tytuł <a href="https://medium.com/javarevisited/one-of-our-employees-secretly-had-ai-doing-most-of-his-job-we-found-out-because-he-took-a-vacation-bc0eedb0fd94"><em>One of Our Employees Secretly Had AI Doing Most of His Job. We Found Out Because He Took a Vacation.</em></a> Ukazał się 21 września 2026.</p>
<p>Inżyniera w tekście nazywa Marcus. Przez dziewięć miesięcy nikt nie narzekał na jego pracę. Praca przychodziła na czas, klienci dostawali odpowiedzi, raporty pojawiały się w każdy piątek, a systemy, za które odpowiadał, sprawiały mniej kłopotów niż wcześniej. Potem wziął dwa tygodnie urlopu. Do środy zespół odkrył, że po cichu zautomatyzował większą część pracy, za którą mu płacono.</p>
<p>Najmocniej zostało mi pytanie, które zadają mu w tym tekście: dlaczego nam nie powiedziałeś? Nie dlatego, że ktoś kłamał. Dlatego, że uwolnione godziny nie zostały wolne. Zautomatyzował proces, zaoszczędził czas i w ciągu miesiąca ten czas wypełnił się nowymi obowiązkami. Część z nich też zautomatyzował. Przyszła kolejna praca.</p>
<p>Nikt nie był złośliwy. Stał się człowiekiem, który ma zapas czasu. A firmy dokładnie wiedzą, co z zapasem czasu zrobić.</p>
<p>Sam uruchamiam agentów AI, głównie w Cursorze. Przygotowują szkice, sprawdzają je i pomagają w publikacji. Pracuję sam, więc to ja decyduję, co stanie się z odzyskanym czasem.</p>
<p>To inny problem niż ten z tekstu Ozcaya. Większość zespołów nie ma wyraźnej odpowiedzi, co dzieje się z godzinami, które oddaje AI.</p>
<p>Jeśli nie zdecydujesz, domyślnie przyjdzie więcej tej samej pracy, tylko szybciej. Tego czasu nikt nie dostanie z powrotem.</p>
<p>Dlatego zacząłem decydować o tym świadomie. Część idzie w głąb, część na odpoczynek, a część na pracę, którą wcześniej bym odmówił. To nie jest ewidencja godzin. To reguła. Inaczej pustka zapełni się sama.</p>
<p>Jeśli pracownik powie ci, że AI zaoszczędziło mu dziesięć godzin tygodniowo, jaki jest twój uczciwy następny krok?</p>
<p>Napisz przez <a href="contact.php">kontakt</a>.</p>
HTML,
        ],
        'hu' => [
            'title' => 'A hatékonyságot nem jutalmazzák. A felszabadult idő újra megtelik.',
            'image_alt' => 'Egy férfi hátulról, sötét asztalnál, felemeli a kezét. A lapon üres türkiz négyzet világít, lila kártyák ömlenek egy kötegből, fölötte lámpa nyitott könyvre, hátul üres fotel áll.',
            'excerpt' => 'Egy mérnök Devrim Ozcay szövegében a visszatérő munka nagyobb részét automatizálta. A csapat csak a szabadságán jött rá. Senki nem volt rosszindulatú. A cég tudja, mit kezdjen a szabad kapacitással. Ha nem döntesz, az AI által visszaadott órák ugyanazzal a munkával telnek meg.',
            'content' => <<<'HTML'
<p>A hatékonyságot nem jutalmazzák. A felszabadult idő újra megtelik.</p>
<p>Szeptember végén elolvastam a szöveget, amelyet Devrim Ozcay a Medium <a href="https://medium.com/javarevisited">Javarevisited</a> kiadványában tett közzé. A címe: <a href="https://medium.com/javarevisited/one-of-our-employees-secretly-had-ai-doing-most-of-his-job-we-found-out-because-he-took-a-vacation-bc0eedb0fd94"><em>One of Our Employees Secretly Had AI Doing Most of His Job. We Found Out Because He Took a Vacation.</em></a> 2026. szeptember 21-én jelent meg.</p>
<p>A mérnököt a szöveg Marcusnak hívja. Kilenc hónapig senki nem panaszkodott a teljesítményére. A munka időben megérkezett, az ügyfelek választ kaptak, a jelentések minden pénteken megjelentek, és a rendszerek, amelyekért felelt, kevesebb gondot okoztak, mint korábban. Aztán kivett két hét szabadságot. Szerdára a csapat rájött, hogy csendben automatizálta a munka nagyobb részét, amiért fizették.</p>
<p>A kérdés maradt meg bennem, amit ebben a szövegben feltesznek neki: miért nem szóltál nekünk? Nem azért, mert valaki hazudott volna. Azért, mert a felszabadult órák nem maradtak szabadok. Automatizált egy folyamatot, időt spórolt, és egy hónapon belül az az idő új feladatokkal telt meg. Egy részüket is automatizálta. Újabb munka érkezett.</p>
<p>Senki nem volt rosszindulatú. Ő lett az, akinek van szabad kapacitása. A cégek pedig pontosan tudják, mit kezdjenek a kapacitással.</p>
<p>Magam is AI-ügynököket futtatok, főleg a Cursorban. Vázlatokat készítenek, ellenőrzik őket, és segítenek a közzétételben. Mivel egyedül dolgozom, én döntöm el azt is, mi történik a visszakapott idővel.</p>
<p>Ez más probléma, mint Ozcay szövegében. A legtöbb csapatnak nincs kimondott válasza arra, mi történik az órákkal, amelyeket az AI visszaad.</p>
<p>Ha nem döntesz, az alapértelmezés ugyanabból a munkából több, csak gyorsabban. Azt az időt senki nem kapja vissza.</p>
<p>Ezért kezdtem szándékosan dönteni róla. Egy része mélységre megy, egy része pihenésre, egy része olyan munkára, amelyet korábban visszautasítottam volna. Ez nem óraelszámolás. Szabály. Különben az üres hely magától megtelik.</p>
<p>Ha egy munkatárs azt mondja, hogy az AI heti tíz órát spórolt neki, mi a következő őszinte lépésed?</p>
<p>Írj a <a href="contact.php">kapcsolati űrlapon</a>.</p>
HTML,
        ],
        'it' => [
            'title' => 'L’efficienza non viene premiata. Il tempo liberato si riempie.',
            'image_alt' => 'Un uomo di spalle, a un tavolo scuro, alza la mano. Sul piano brilla un quadrato turchese vuoto, carte viola arrivano da una pila, una lampada illumina un libro aperto e sullo sfondo c’è una poltrona vuota.',
            'excerpt' => 'Un ingegnere, nel testo di Devrim Ozcay, ha automatizzato la maggior parte del lavoro ripetitivo. Il team lo ha scoperto solo in ferie. Nessuno era in malafede. L’azienda sa cosa fare della capacità libera. Se non decidi, le ore che l’IA restituisce si riempiono dello stesso lavoro.',
            'content' => <<<'HTML'
<p>L’efficienza non viene premiata. Il tempo liberato si riempie.</p>
<p>A fine settembre ho letto un testo che Devrim Ozcay ha pubblicato su <a href="https://medium.com/javarevisited">Javarevisited</a>, su Medium. Si intitola <a href="https://medium.com/javarevisited/one-of-our-employees-secretly-had-ai-doing-most-of-his-job-we-found-out-because-he-took-a-vacation-bc0eedb0fd94"><em>One of Our Employees Secretly Had AI Doing Most of His Job. We Found Out Because He Took a Vacation.</em></a> È uscito il 21 settembre 2026.</p>
<p>Nel testo l’ingegnere si chiama Marcus. Per nove mesi nessuno si è lamentato del suo rendimento. Il lavoro arrivava in orario, i clienti ricevevano risposte, i rapporti comparivano ogni venerdì e i sistemi di cui era responsabile davano meno problemi di prima. Poi ha preso due settimane di ferie. Entro mercoledì il team ha scoperto che aveva automatizzato in silenzio la maggior parte del lavoro per cui lo pagavano.</p>
<p>Mi è rimasta la domanda che in quel testo gli pongono: perché non ce l’hai detto? Non perché qualcuno avesse mentito. Perché le ore liberate non sono rimaste libere. Ha automatizzato un processo, ha risparmiato tempo e nel giro di un mese quel tempo era pieno di nuove responsabilità. Ne ha automatizzata anche una parte. È arrivato altro lavoro.</p>
<p>Nessuno era in malafede. È diventato la persona con capacità libera. E le aziende sanno benissimo cosa fare della capacità.</p>
<p>Faccio girare anch’io agenti di IA, soprattutto in Cursor. Preparano bozze, le controllano e mi aiutano a pubblicare. Siccome lavoro da solo, sono anche io a decidere che cosa succede al tempo restituito.</p>
<p>È un problema diverso da quello del testo di Ozcay. La maggior parte dei team non ha una risposta esplicita su che cosa accade alle ore che l’IA restituisce.</p>
<p>Se non decidi, il valore predefinito è più dello stesso lavoro, più in fretta. Quel tempo non torna a nessuno.</p>
<p>Per questo ho cominciato a deciderlo apposta. Una parte va in profondità, una al riposo e una al lavoro che prima avrei rifiutato. Non è un consuntivo ore. È una regola. Altrimenti il vuoto si riempie da solo.</p>
<p>Responsabili: se un collaboratore ti dice che l’IA gli ha fatto risparmiare dieci ore a settimana, qual è la tua prossima mossa onesta?</p>
<p>Scrivi tramite il <a href="contact.php">modulo di contatto</a>.</p>
HTML,
        ],
        'uk' => [
            'title' => 'Ефективність не винагороджують. Звільнений час знову заповнюється.',
            'image_alt' => 'Чоловік зі спини біля темного столу піднімає руку. На стільниці світиться порожній бірюзовий квадрат, фіолетові картки течуть зі стосу, лампа освітлює відкриту книгу, а позаду стоїть порожнє крісло.',
            'excerpt' => 'Інженер у тексті Devrim Ozcay автоматизував більшу частину повторюваної роботи. Команда дізналася лише на відпустці. Ніхто не був зловмисним. Фірма знає, що робити з вільною ємністю. Якщо не вирішите, години, які повертає ШІ, заповняться тією самою роботою.',
            'content' => <<<'HTML'
<p>Ефективність не винагороджують. Звільнений час знову заповнюється.</p>
<p>Наприкінці вересня я прочитав текст, який Devrim Ozcay опублікував у виданні <a href="https://medium.com/javarevisited">Javarevisited</a> на Medium. Він називається <a href="https://medium.com/javarevisited/one-of-our-employees-secretly-had-ai-doing-most-of-his-job-we-found-out-because-he-took-a-vacation-bc0eedb0fd94"><em>One of Our Employees Secretly Had AI Doing Most of His Job. We Found Out Because He Took a Vacation.</em></a> Вийшов 21 вересня 2026 року.</p>
<p>Інженера в тексті звуть Marcus. Дев’ять місяців ніхто не скаржився на його роботу. Робота приходила вчасно, клієнти отримували відповіді, звіти з’являлися щоп’ятниці, а системи, за які він відповідав, створювали менше проблем, ніж раніше. Потім він узяв два тижні відпустки. До середи команда з’ясувала, що він тихо автоматизував більшу частину роботи, за яку йому платили.</p>
<p>Найбільше мені лишилося питання, яке йому ставлять у тому тексті: чому ти нам не сказав? Не тому, що хтось брехав. Тому, що звільнені години не лишилися вільними. Він автоматизував процес, заощадив час, і протягом місяця той час заповнився новими обов’язками. Частину з них він теж автоматизував. Прийшла нова робота.</p>
<p>Ніхто не був зловмисним. Він став людиною, у якої є запас часу. А компанії дуже добре знають, що з запасом часу робити.</p>
<p>Сам я запускаю ШІ-агентів, переважно в Cursor. Вони готують чернетки, перевіряють їх і допомагають із публікацією. Оскільки я працюю сам, я й вирішую, що станеться з поверненим часом.</p>
<p>Це інша проблема, ніж та, про яку пише Devrim Ozcay. Більшість команд не має прямої відповіді, що відбувається з годинами, які повертає ШІ.</p>
<p>Якщо не вирішите, типово прийде більше тієї самої роботи, лише швидше. Той час ніхто не отримає назад.</p>
<p>Тому я почав вирішувати це навмисно. Частина йде в глибину, частина на відпочинок, частина на роботу, від якої я раніше відмовився б. Це не табель годин. Це правило. Інакше порожнеча заповниться сама.</p>
<p>Керівники: якщо працівник скаже вам, що ШІ заощадив йому десять годин на тиждень, який ваш чесний наступний крок?</p>
<p>Напишіть через <a href="contact.php">контакт</a>.</p>
HTML,
        ],
    ],
];
