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

$sourceBookspace = '<a href="https://bookspace.com/">BookSpace Weekly</a>';
$sourceTor = '<a href="https://ilona-andrews.com/blog/generative-ai-on-this-crowns-cover">Generative AI on This Crown’s Cover</a>';
$sourceFriedman = '<a href="https://janefriedman.com/early-drafts-and-process-notes-prove-little-to-nothing-about-authors-ai-use">Early Drafts and Process Notes Prove Little to Nothing About Authors’ AI Use</a>';

return [
    'slug' => 'klauzula-nie-je-dokaz',
    'author' => 'MUDr. Ľubomír Polaščín',
    'category' => 'blog',
    'is_top' => 0,
    'published_at' => '2026-11-28 11:12:00',
    'image' => 'images/articles/klauzula-nie-je-dokaz.webp',
    'translations' => [
        'sk' => [
            'title' => 'Klauzula nie je dôkaz',
            'image_alt' => 'Dve staršie ruky v tenkej modrofialovej akvarelovej farbe držia ihlu na látanie na fialovom a tyrkysovom pozadí.',
            'excerpt' => 'Poetka podpisovala zbierku o rukách starej mamy a po jednom komentári už nevedela s istotou povedať, či ich na obálke namaľovala ľudská ruka. Veľké vydavateľstvo malo dve zmluvy proti AI a aj tak ostalo bez obálky.',
            'content' => <<<'HTML'
<p>Poetka pri susednom stole na knižnom veľtrhu v Edinburghu predala do poludnia jedenásť výtlačkov. Pri poézii to stačí na pocit návalu. Zbierka je o rukách starej mamy. Obálka ukazuje pár rúk v tenkej modrej akvarelovej farbe s ihlicou na látanie.</p>
<p>Za návrh zaplatila dizajnérovi 450 dolárov. Vo štvrtok pod príspevkom o uvedení knihy pribudol komentár cudzieho človeka: „Škoda tej AI obálky.“ Nič viac. Dizajnérovi napísala dvakrát. Odpísal raz, že má veľa práce.</p>
<p>Celé popoludnie teda podpisovala knihu o rukách starej mamy a nemohla s rukou na srdci povedať, či tie na prednej strane namaľovala ľudská ruka.</p>
<p>Nie je to len jeden hrubý komentár. Vydavateľstvo Tor stiahlo obálku novej fantasy Ilony Andrewsovej po tom, čo čitatelia na Instagramu upozornili na generatívnu AI. Podľa vydavateľstva sa použila bez vedomia Toru aj autorov. V zmluve autorov aj v zmluvách Toru s výtvarníkmi pritom stál zákaz AI. Ak sa veľké vydavateľstvo s výtvarným oddelením a dvoma zmluvami nechytí včas, poetka s potvrdením z PayPalu je na to sama. Ostáva otázka, ktorú stojí za to položiť pred tlačou ďalšej obálky: vedeli by ste dokázať, kto ju urobil?</p>
<p>Klauzula je začiatok, nie dôkaz. Žiadajte skice a rozpracované verzie cestou a uchovávajte ich s faktúrou.</p>
<p>To isté platí pri texte. Debutovú autorku podľa Publishers Marketplace vyhodil agent potom, čo britské vydavateľstvo, údajne Cornerstone v rámci Penguin Random House, prehnalo rukopis detektorom Pangram. Predložila jedenásť konceptov, poznámky a plány. Podozrenie zostalo. Autorka AI popiera. Jane Friedmanová tento týždeň píše, že dokumenty o procese dokazujú málo: AI sa dá použiť medzi ktorýmikoľvek dvoma konceptmi. Odporúča nebudovať papierovú stopu „pre istotu“, ale vedieť jednoducho povedať, ako ste AI použili, alebo že ste ju nepoužili. Jedna jasná veta môže dnes znamenať viac než škatula konceptov.</p>
<p>Späť do Edinburghu. Poetka napísala dizajnérovi tretíkrát a žiada skice. Medzitým začala sama maľovať ruky starej mamy.</p>
HTML
            . "\n<p><small><em>Inšpirácia: James Alcott, {$sourceBookspace}, 28. novembra 2026. Odkazy: Ilona Andrewsová, {$sourceTor}; Jane Friedmanová, {$sourceFriedman}.</em></small></p>",
        ],
        'en' => [
            'title' => 'A clause is not proof',
            'image_alt' => 'A pair of elderly hands in thin blue-violet watercolour holds a darning needle against a violet and teal background.',
            'excerpt' => 'A poet was signing a collection about her grandmother’s hands when one comment left her unable to say, hand on heart, whether a human had painted the ones on the cover. A major publisher had two no-AI contracts and still lost a cover.',
            'content' => <<<'HTML'
<p>The poet at the next table at a book fair in Edinburgh had sold eleven copies by lunchtime, which in poetry counts as a stampede. Her collection is about her grandmother’s hands. The cover shows a pair of them in thin blue watercolour, holding a darning needle.</p>
<p>She paid a designer $450 for it. On Thursday a stranger left a comment under her launch post: “Shame about the AI cover.” Nothing else. She has emailed the designer twice. He has replied once, to say he was very busy.</p>
<p>So she spent the afternoon signing a book about her grandmother’s hands without being able to say, hand on heart, whether a human hand had painted the ones on the front.</p>
<p>This is not one rude stranger. Last week Tor pulled the cover of a new Ilona Andrews fantasy after readers spotted AI in it. The publisher says generative AI was used without the knowledge of either Tor or the authors. The authors’ contract and Tor’s art contracts both ruled out AI. If a major publisher with an art department and two contracts can be caught out, a poet with a PayPal receipt is on her own. Which leaves a question worth asking before your next cover goes to print: could you prove who made it?</p>
<p>A clause is a start, not proof. Ask for sketches and work in progress along the way, and keep them with the invoice.</p>
<p>The same applies to the text. A debut author was dropped by her agent after a UK publisher, reportedly Cornerstone at Penguin Random House, ran her manuscript through the AI detector Pangram. Publishers Marketplace reported that she produced eleven drafts plus notes and plotting plans, and the suspicion stayed. She denies using AI. Jane Friedman argues this week that process documents prove little either way, because AI can be used between any two drafts, and she advises against building a paper trail just in case. Her practical advice is to be ready to explain plainly how you did, or did not, use AI. One clear sentence may now count for more than a shoebox of drafts.</p>
<p>Back to Edinburgh. She has emailed the designer a third time, asking for his sketches, and in the meantime has started painting her grandmother’s hands herself.</p>
HTML
            . "\n<p><small><em>Inspiration: James Alcott, {$sourceBookspace}, 28 November 2026. Links: Ilona Andrews, {$sourceTor}; Jane Friedman, {$sourceFriedman}.</em></small></p>",
        ],
        'cs' => [
            'title' => 'Klauzule není důkaz',
            'image_alt' => 'Dvě starší ruce v tenké modrofialové akvarelové barvě drží jehlu na látání na fialovém a tyrkysovém pozadí.',
            'excerpt' => 'Básnířka podepisovala sbírku o rukách babičky a po jednom komentáři už nedokázala s jistotou říct, zda je na obálce namalovala lidská ruka. Velké nakladatelství mělo dvě smlouvy proti AI a stejně zůstalo bez obálky.',
            'content' => <<<'HTML'
<p>Básnířka u sousedního stolu na knižním veletrhu v Edinburghu prodala do poledne jedenáct výtisků. U poezie to stačí na pocit návalu. Sbírka je o rukách babičky. Obálka ukazuje pár rukou v tenké modré akvarelové barvě s jehlou na látání.</p>
<p>Za návrh zaplatila designerovi 450 dolarů. Ve čtvrtek pod příspěvkem o uvedení knihy přibyl komentář cizího člověka: „Škoda té AI obálky.“ Nic víc. Designerovi napsala dvakrát. Odepsal jednou, že má hodně práce.</p>
<p>Celé odpoledne tedy podepisovala knihu o rukách babičky a nemohla s rukou na srdci říct, zda ty na přední straně namalovala lidská ruka.</p>
<p>Není to jen jeden hrubý komentář. Nakladatelství Tor stáhlo obálku nové fantasy Ilony Andrewsové poté, co čtenáři na Instagramu upozornili na generativní AI. Podle nakladatelství se použila bez vědomí Toru i autorů. Ve smlouvě autorů i ve smlouvách Toru s výtvarníky přitom stál zákaz AI. Pokud se velké nakladatelství s výtvarným oddělením a dvěma smlouvami nechytí včas, básnířka s potvrzením z PayPalu je na to sama. Zůstává otázka, kterou stojí za to položit před tiskem další obálky: dokázali byste prokázat, kdo ji udělal?</p>
<p>Klauzule je začátek, ne důkaz. Žádejte skici a rozpracované verze cestou a uchovávejte je s fakturou.</p>
<p>Totéž platí u textu. Debutovou autorku podle Publishers Marketplace vyhodil agent poté, co britské nakladatelství, údajně Cornerstone v rámci Penguin Random House, prohnalo rukopis detektorem Pangram. Předložila jedenáct konceptů, poznámky a plány. Podezření zůstalo. Autorka AI popírá. Jane Friedmanová tento týden píše, že dokumenty o procesu dokazují málo: AI se dá použít mezi kterýmikoli dvěma koncepty. Doporučuje nebudovat papírovou stopu „pro jistotu“, ale umět jednoduše říct, jak jste AI použili, nebo že jste ji nepoužili. Jedna jasná věta může dnes znamenat víc než krabice konceptů.</p>
<p>Zpátky do Edinburghu. Básnířka napsala designerovi potřetí a žádá skici. Mezitím začala sama malovat ruce babičky.</p>
HTML
            . "\n<p><small><em>Inspirace: James Alcott, {$sourceBookspace}, 28. listopadu 2026. Odkazy: Ilona Andrewsová, {$sourceTor}; Jane Friedmanová, {$sourceFriedman}.</em></small></p>",
        ],
        'de' => [
            'title' => 'Eine Klausel ist kein Beweis',
            'image_alt' => 'Zwei ältere Hände in dünner blauvioletter Aquarellfarbe halten eine Stopfnadel vor violettem und türkisem Hintergrund.',
            'excerpt' => 'Eine Dichterin signierte eine Sammlung über die Hände ihrer Großmutter und konnte nach einem Kommentar nicht mehr mit der Hand aufs Herz sagen, ob eine menschliche Hand die auf dem Cover gemalt hatte. Ein großer Verlag hatte zwei Verträge gegen KI und verlor trotzdem ein Cover.',
            'content' => <<<'HTML'
<p>Die Dichterin am Nachbartisch auf einer Buchmesse in Edinburgh hatte bis zum Mittag elf Exemplare verkauft. Bei Lyrik gilt das als Ansturm. Ihre Sammlung handelt von den Händen ihrer Großmutter. Das Cover zeigt ein Paar in dünnem blauem Aquarell mit einer Stopfnadel.</p>
<p>Sie zahlte einem Designer 450 Dollar dafür. Am Donnerstag hinterließ ein Unbekannter unter ihrem Launch-Beitrag den Kommentar: „Schade um das KI-Cover.“ Sonst nichts. Sie hat dem Designer zweimal geschrieben. Er hat einmal geantwortet, er sei sehr beschäftigt.</p>
<p>So verbrachte sie den Nachmittag damit, ein Buch über die Hände ihrer Großmutter zu signieren, ohne mit der Hand aufs Herz sagen zu können, ob eine menschliche Hand die auf der Vorderseite gemalt hatte.</p>
<p>Das ist nicht nur ein grober Kommentar. Der Verlag Tor zog das Cover einer neuen Fantasy von Ilona Andrews zurück, nachdem Leser auf Instagram generative KI bemerkt hatten. Laut Verlag wurde sie ohne Wissen von Tor und der Autoren verwendet. Im Autorenvertrag und in Tors Verträgen mit Künstlern stand ein KI-Verbot. Wenn ein großer Verlag mit Kunstabteilung und zwei Verträgen zu spät kommt, steht eine Dichterin mit einer PayPal-Quittung allein da. Es bleibt eine Frage, die man vor dem Druck des nächsten Covers stellen sollte: Könnten Sie beweisen, wer es gemacht hat?</p>
<p>Eine Klausel ist ein Anfang, kein Beweis. Verlangen Sie Skizzen und Zwischenstände unterwegs und bewahren Sie sie mit der Rechnung auf.</p>
<p>Dasselbe gilt für den Text. Eine Debütautorin wurde laut Publishers Marketplace von ihrer Agentin fallen gelassen, nachdem ein britischer Verlag, Berichten zufolge Cornerstone bei Penguin Random House, das Manuskript durch den KI-Detektor Pangram laufen ließ. Sie legte elf Entwürfe, Notizen und Handlungspläne vor. Der Verdacht blieb. Die Autorin bestreitet den Einsatz von KI. Jane Friedman schreibt diese Woche, dass Prozessdokumente wenig beweisen: KI lässt sich zwischen zwei beliebigen Entwürfen einsetzen. Sie rät davon ab, nur für alle Fälle eine Papierspur aufzubauen. Stattdessen sollte man klar sagen können, wie man KI genutzt hat oder dass man sie nicht genutzt hat. Ein klarer Satz kann heute mehr zählen als eine Schachtel Entwürfe.</p>
<p>Zurück nach Edinburgh. Sie hat dem Designer zum dritten Mal geschrieben und um seine Skizzen gebeten. In der Zwischenzeit hat sie angefangen, die Hände ihrer Großmutter selbst zu malen.</p>
HTML
            . "\n<p><small><em>Anregung: James Alcott, {$sourceBookspace}, 28. November 2026. Links: Ilona Andrews, {$sourceTor}; Jane Friedman, {$sourceFriedman}.</em></small></p>",
        ],
        'fr' => [
            'title' => 'Une clause n’est pas une preuve',
            'image_alt' => 'Deux mains âgées en aquarelle bleu-violet tiennent une aiguille à repriser sur un fond violet et turquoise.',
            'excerpt' => 'Une poète dédicaçait un recueil sur les mains de sa grand-mère quand un commentaire l’a laissée incapable de dire, la main sur le cœur, si une main humaine avait peint celles de la couverture. Un grand éditeur avait deux contrats anti-IA et a quand même perdu une couverture.',
            'content' => <<<'HTML'
<p>La poète à la table voisine d’un salon du livre à Édimbourg avait vendu onze exemplaires avant midi, ce qui, en poésie, tient du raz-de-marée. Son recueil parle des mains de sa grand-mère. La couverture montre une paire peinte en aquarelle bleue fine, tenant une aiguille à repriser.</p>
<p>Elle a payé 450 dollars à un graphiste. Jeudi, un inconnu a laissé sous sa publication de lancement le commentaire : « Dommage pour cette couverture IA. » Rien d’autre. Elle lui a écrit deux fois. Il a répondu une fois pour dire qu’il était très occupé.</p>
<p>Elle a donc passé l’après-midi à dédicacer un livre sur les mains de sa grand-mère sans pouvoir dire, la main sur le cœur, si une main humaine avait peint celles de la couverture.</p>
<p>Ce n’est pas qu’un commentaire grossier. La maison Tor a retiré la couverture d’une nouvelle fantasy d’Ilona Andrews après que des lecteurs ont signalé de l’IA générative sur Instagram. Selon l’éditeur, elle a été utilisée à l’insu de Tor et des auteurs. Le contrat des auteurs et les contrats d’art de Tor interdisaient pourtant l’IA. Si un grand éditeur avec un service artistique et deux contrats peut être pris de court, une poète munie d’un reçu PayPal se retrouve seule. Il reste une question à poser avant d’envoyer la prochaine couverture à l’impression : pourriez-vous prouver qui l’a faite ?</p>
<p>Une clause est un début, pas une preuve. Demandez des croquis et des étapes de travail en cours, et conservez-les avec la facture.</p>
<p>Il en va de même pour le texte. Une auteure débutante a été lâchée par son agente après qu’un éditeur britannique, selon les informations Cornerstone chez Penguin Random House, a passé son manuscrit au détecteur d’IA Pangram. Publishers Marketplace rapporte qu’elle a produit onze versions, des notes et des plans. Le soupçon est resté. Elle nie avoir utilisé l’IA. Jane Friedman écrit cette semaine que les documents de processus prouvent peu de chose : l’IA peut s’insérer entre deux versions quelconques. Elle déconseille de constituer une piste papier « au cas où » et recommande d’être prêt à expliquer clairement comment on a, ou n’a pas, utilisé l’IA. Une phrase nette peut aujourd’hui compter davantage qu’une boîte de brouillons.</p>
<p>Retour à Édimbourg. Elle a écrit une troisième fois au graphiste pour demander ses croquis et, en attendant, a commencé à peindre elle-même les mains de sa grand-mère.</p>
HTML
            . "\n<p><small><em>Source d’inspiration : James Alcott, {$sourceBookspace}, 28 novembre 2026. Liens : Ilona Andrews, {$sourceTor} ; Jane Friedman, {$sourceFriedman}.</em></small></p>",
        ],
        'es' => [
            'title' => 'Una cláusula no es una prueba',
            'image_alt' => 'Dos manos ancianas en acuarela azul violácea sostienen una aguja de zurcir sobre un fondo violeta y turquesa.',
            'excerpt' => 'Una poeta firmaba una colección sobre las manos de su abuela cuando un comentario la dejó sin poder decir, con la mano en el corazón, si una mano humana había pintado las de la cubierta. Una gran editorial tenía dos contratos contra la IA y aun así perdió una cubierta.',
            'content' => <<<'HTML'
<p>La poeta de la mesa de al lado en una feria del libro en Edimburgo había vendido once ejemplares a mediodía, lo que en poesía equivale a una avalancha. Su colección habla de las manos de su abuela. La cubierta muestra un par en acuarela azul fina, con una aguja de zurcir.</p>
<p>Pagó 450 dólares a un diseñador. El jueves, un desconocido dejó bajo su publicación de lanzamiento el comentario: «Qué pena esa cubierta de IA». Nada más. Le ha escrito dos veces. Él ha respondido una, para decir que estaba muy ocupado.</p>
<p>Así que pasó la tarde firmando un libro sobre las manos de su abuela sin poder decir, con la mano en el corazón, si una mano humana había pintado las de la portada.</p>
<p>No es solo un comentario grosero. La editorial Tor retiró la cubierta de una nueva fantasía de Ilona Andrews después de que lectores detectaran IA generativa en Instagram. Según la editorial, se usó sin conocimiento de Tor ni de los autores. El contrato de los autores y los contratos artísticos de Tor prohibían la IA. Si una gran editorial con departamento de arte y dos contratos puede verse sorprendida, una poeta con un recibo de PayPal se queda sola. Queda una pregunta que conviene hacerse antes de mandar a imprimir la siguiente cubierta: ¿podría usted demostrar quién la hizo?</p>
<p>Una cláusula es un comienzo, no una prueba. Pida bocetos y avances del trabajo por el camino y guárdelos con la factura.</p>
<p>Lo mismo vale para el texto. Una autora debutante fue abandonada por su agente después de que una editorial británica, según se informa Cornerstone en Penguin Random House, pasara el manuscrito por el detector de IA Pangram. Publishers Marketplace informó de que presentó once borradores, notas y planes. La sospecha permaneció. Ella niega haber usado IA. Jane Friedman escribe esta semana que los documentos del proceso prueban poco: la IA puede usarse entre dos borradores cualesquiera. Aconseja no construir un rastro de papel «por si acaso» y sí estar listo para explicar con claridad cómo se usó, o no se usó, la IA. Una frase clara puede valer hoy más que una caja de borradores.</p>
<p>De vuelta a Edimburgo. Ha escrito al diseñador por tercera vez para pedirle los bocetos y, mientras tanto, ha empezado a pintar ella misma las manos de su abuela.</p>
HTML
            . "\n<p><small><em>Fuente de inspiración: James Alcott, {$sourceBookspace}, 28 de noviembre de 2026. Enlaces: Ilona Andrews, {$sourceTor}; Jane Friedman, {$sourceFriedman}.</em></small></p>",
        ],
        'pl' => [
            'title' => 'Klauzula to nie dowód',
            'image_alt' => 'Dwie starsze dłonie w cienkiej niebieskofioletowej akwareli trzymają igłę do cerowania na fioletowym i turkusowym tle.',
            'excerpt' => 'Poetka podpisywała tomik o dłoniach babci, a po jednym komentarzu nie potrafiła już z ręką na sercu powiedzieć, czy te na okładce namalowała ludzka ręka. Duże wydawnictwo miało dwie umowy przeciw AI i i tak zostało bez okładki.',
            'content' => <<<'HTML'
<p>Poetka przy sąsiednim stole na targach książki w Edynburgu sprzedała do południa jedenaście egzemplarzy. W poezji to wystarczy, by poczuć napór. Jej tomik jest o dłoniach babci. Okładka pokazuje parę dłoni w cienkiej niebieskiej akwareli z igłą do cerowania.</p>
<p>Zapłaciła projektantowi 450 dolarów. W czwartek pod wpisem o premierze ktoś obcy zostawił komentarz: „Szkoda tej okładki AI”. Nic więcej. Napisała do projektanta dwa razy. Odpisał raz, że ma dużo pracy.</p>
<p>Całe popołudnie podpisywała więc książkę o dłoniach babci i nie mogła z ręką na sercu powiedzieć, czy te na przedniej stronie namalowała ludzka ręka.</p>
<p>To nie jeden grubiański komentarz. Wydawnictwo Tor wycofało okładkę nowej fantasy Ilony Andrews, gdy czytelnicy na Instagramie wskazali generatywną AI. Według wydawnictwa użyto jej bez wiedzy Toru i autorów. W umowie autorów i w umowach Toru z artystami stał zakaz AI. Jeśli duże wydawnictwo z działem artystycznym i dwiema umowami nie zdąży w porę, poetka z potwierdzeniem z PayPala zostaje sama. Zostaje pytanie, które warto zadać przed drukiem kolejnej okładki: czy potrafilibyście udowodnić, kto ją zrobił?</p>
<p>Klauzula to początek, nie dowód. Proście o szkice i wersje robocze po drodze i trzymajcie je z fakturą.</p>
<p>To samo dotyczy tekstu. Debiutantkę według Publishers Marketplace porzucił agent, gdy brytyjskie wydawnictwo, jak donoszą Cornerstone w ramach Penguin Random House, przepuściło rękopis przez detektor AI Pangram. Przedłożyła jedenaście szkiców, notatki i plany. Podejrzenie pozostało. Autorka zaprzecza użyciu AI. Jane Friedman pisze w tym tygodniu, że dokumenty procesu dowodzą niewiele: AI można użyć między dowolnymi dwoma wersjami. Radzi nie budować papierowego śladu „na wszelki wypadek”, lecz umieć jasno powiedzieć, jak użyto AI albo że się jej nie użyło. Jedno jasne zdanie może dziś znaczyć więcej niż pudełko szkiców.</p>
<p>Z powrotem do Edynburga. Napisała do projektanta po raz trzeci i prosi o szkice. Tymczasem sama zaczęła malować dłonie babci.</p>
HTML
            . "\n<p><small><em>Inspiracja: James Alcott, {$sourceBookspace}, 28 listopada 2026 r. Odnośniki: Ilona Andrews, {$sourceTor}; Jane Friedman, {$sourceFriedman}.</em></small></p>",
        ],
        'hu' => [
            'title' => 'A záradék nem bizonyíték',
            'image_alt' => 'Két idős kéz vékony kékeslila akvarellben stoppolótűt tart lila és türkiz háttéren.',
            'excerpt' => 'Egy költő a nagyanyja kezeiről szóló kötetet dedikálta, amikor egy komment után már nem tudta kéz a szívére téve megmondani, hogy emberi kéz festette-e a borítón lévőket. Egy nagy kiadónak két AI-ellenes szerződése volt, és így is elvesztett egy borítót.',
            'content' => <<<'HTML'
<p>A szomszéd asztalnál ülő költő egy edinburghi könyvvásáron délre tizenegy példányt adott el. Költészetben ez már rohamnak számít. A kötete a nagyanyja kezeiről szól. A borítón vékony kék akvarellben egy pár kéz látható stoppolótűvel.</p>
<p>A tervezőnek 450 dollárt fizetett. Csütörtökön az induló bejegyzése alatt egy idegen ezt a kommentet hagyta: „Kár az AI-borítóért.” Semmi több. Kétszer írt a tervezőnek. Egyszer válaszolt: nagyon elfoglalt.</p>
<p>Így töltötte a délutánt azzal, hogy a nagyanyja kezeiről szóló könyvet dedikálta, anélkül hogy kéz a szívére téve megmondhatta volna, emberi kéz festette-e az előlapon lévőket.</p>
<p>Ez nem egy durva idegen. A Tor kiadó visszavonta Ilona Andrews új fantasyjának borítóját, miután az olvasók az Instagramon generatív AI-t jeleztek. A kiadó szerint a Tor és a szerzők tudta nélkül használták. A szerzői szerződésben és a Tor művészekkel kötött szerződéseiben is szerepelt az AI tilalma. Ha egy nagy kiadó művészeti osztállyal és két szerződéssel is elkéshet, a PayPal-igazolással rendelkező költő egyedül marad. Marad egy kérdés, amelyet érdemes feltenni a következő borító nyomdába küldése előtt: be tudná bizonyítani, ki készítette?</p>
<p>A záradék kezdet, nem bizonyíték. Kérjen vázlatokat és közbenső változatokat útközben, és őrizze őket a számlával együtt.</p>
<p>Ugyanez érvényes a szövegre. Egy bemutatkozó szerzőt az ügynöke elengedett, miután egy brit kiadó, állítólag a Cornerstone a Penguin Random House keretében, a Pangram AI-detektoron futtatta a kéziratot, jelentette a Publishers Marketplace. Tizenegy vázlatot, jegyzeteket és terveket mutatott be. A gyanú megmaradt. A szerző tagadja az AI használatát. Jane Friedman ezen a héten azt írja, hogy a folyamatdokumentumok keveset bizonyítanak: az AI bármelyik két vázlat között beilleszthető. Azt tanácsolja, ne építsünk „csak a biztonság kedvéért” papírnyomot, hanem tudjunk világosan elmondani, hogyan használtuk az AI-t, vagy hogy nem használtuk. Egy tiszta mondat ma többet érhet, mint egy doboznyi vázlat.</p>
<p>Vissza Edinburghba. Harmadszor is írt a tervezőnek, és a vázlatait kéri. Közben maga kezdte el festeni a nagyanyja kezeit.</p>
HTML
            . "\n<p><small><em>Ihlető forrás: James Alcott, {$sourceBookspace}, 2026. november 28. Hivatkozások: Ilona Andrews, {$sourceTor}; Jane Friedman, {$sourceFriedman}.</em></small></p>",
        ],
        'it' => [
            'title' => 'Una clausola non è una prova',
            'image_alt' => 'Due mani anziane in acquerello blu-viola tengono un ago da rammendo su uno sfondo viola e turchese.',
            'excerpt' => 'Una poetessa firmava una raccolta sulle mani della nonna quando un commento le ha impedito di dire, mano sul cuore, se una mano umana avesse dipinto quelle in copertina. Una grande casa editrice aveva due contratti contro l’IA e ha comunque perso una copertina.',
            'content' => <<<'HTML'
<p>La poetessa al tavolo vicino a una fiera del libro a Edimburgo aveva venduto undici copie entro mezzogiorno, che in poesia equivale a una valanga. La sua raccolta parla delle mani della nonna. La copertina mostra un paio in acquerello blu sottile, con un ago da rammendo.</p>
<p>Ha pagato 450 dollari a un designer. Giovedì uno sconosciuto ha lasciato sotto il post di lancio il commento: «Peccato per quella copertina IA». Nient’altro. Gli ha scritto due volte. Ha risposto una, per dire che era molto impegnato.</p>
<p>Così ha passato il pomeriggio a firmare un libro sulle mani della nonna senza poter dire, mano sul cuore, se una mano umana avesse dipinto quelle in primo piano.</p>
<p>Non è solo un commento sgarbato. La casa editrice Tor ha ritirato la copertina di una nuova fantasy di Ilona Andrews dopo che i lettori su Instagram avevano segnalato l’IA generativa. Secondo l’editore è stata usata a insaputa di Tor e degli autori. Il contratto degli autori e i contratti artistici di Tor vietavano l’IA. Se una grande casa editrice con un reparto artistico e due contratti può restare indietro, una poetessa con una ricevuta PayPal resta sola. Resta una domanda da porsi prima di mandare in stampa la prossima copertina: potreste dimostrare chi l’ha fatta?</p>
<p>Una clausola è un inizio, non una prova. Chiedete schizzi e versioni intermedie lungo il percorso e conservateli con la fattura.</p>
<p>Lo stesso vale per il testo. Un’autrice all’esordio è stata lasciata dalla sua agente dopo che un editore britannico, secondo le notizie Cornerstone presso Penguin Random House, ha passato il manoscritto al rilevatore di IA Pangram. Publishers Marketplace riporta che ha prodotto undici bozze, appunti e piani. Il sospetto è rimasto. Lei nega di aver usato l’IA. Jane Friedman scrive questa settimana che i documenti di processo provano poco: l’IA si può usare tra due bozze qualsiasi. Consiglia di non costruire una traccia cartacea «per sicurezza» e di essere pronti a spiegare con chiarezza come si è usata, o non usata, l’IA. Una frase chiara oggi può contare più di una scatola di bozze.</p>
<p>Di nuovo a Edimburgo. Ha scritto al designer una terza volta per chiedere gli schizzi e nel frattempo ha iniziato a dipingere lei stessa le mani della nonna.</p>
HTML
            . "\n<p><small><em>Ispirazione: James Alcott, {$sourceBookspace}, 28 novembre 2026. Collegamenti: Ilona Andrews, {$sourceTor}; Jane Friedman, {$sourceFriedman}.</em></small></p>",
        ],
        'uk' => [
            'title' => 'Застереження в договорі ще не доказ',
            'image_alt' => 'Дві літні руки в тонкій синьо-фіолетовій акварелі тримають штопальну голку на фіолетовому й бірюзовому тлі.',
            'excerpt' => 'Поетеса підписувала збірку про руки бабусі й після одного коментаря вже не могла з рукою на серці сказати, чи їх на обкладинці намалювала людська рука. Велике видавництво мало два договори проти ШІ й усе одно лишилося без обкладинки.',
            'content' => <<<'HTML'
<p>Поетеса за сусіднім столом на книжковому ярмарку в Единбурзі до обіду продала одинадцять примірників. Для поезії цього досить, щоб відчути наплив. Збірка про руки бабусі. На обкладинці пара рук у тонкій блакитній акварелі з штопальною голкою.</p>
<p>За макет вона заплатила дизайнерові 450 доларів. У четвер під дописом про вихід книжки з’явився коментар незнайомця: «Шкода тієї ШІ-обкладинки». Більше нічого. Вона двічі написала дизайнерові. Він відповів один раз, що дуже зайнятий.</p>
<p>Тож ціле пообіддя вона підписувала книжку про руки бабусі й не могла з рукою на серці сказати, чи ті на передній стороні намалювала людська рука.</p>
<p>Це не лише один грубий коментар. Видавництво Tor зняло обкладинку нової фентезі Ілони Ендрюс після того, як читачі в Instagram помітили генеративний ШІ. За словами видавництва, його використали без відома Tor і авторів. У договорі авторів і в договорах Tor з художниками стояла заборона ШІ. Якщо велике видавництво з художнім відділом і двома договорами може спізнитися, поетеса з квитанцією PayPal лишається сама. Залишається питання, яке варто поставити перед друком наступної обкладинки: чи змогли б ви довести, хто її зробив?</p>
<p>Застереження в договорі є початком, не доказом. Просіть ескізи й проміжні версії дорогою й зберігайте їх із рахунком.</p>
<p>Те саме стосується тексту. Дебютну авторку, за даними Publishers Marketplace, відпустив агент після того, як британське видавництво, нібито Cornerstone у складі Penguin Random House, прогнало рукопис через детектор ШІ Pangram. Вона подала одинадцять чернеток, нотатки й плани. Підозра лишилася. Авторка заперечує використання ШІ. Джейн Фрідман цього тижня пише, що документи процесу доводять мало: ШІ можна вставити між будь-якими двома чернетками. Вона радить не будувати паперовий слід «про всяк випадок», а вміти просто сказати, як ви використовували ШІ або що не використовували. Одна ясна фраза сьогодні може важити більше за коробку чернеток.</p>
<p>Назад до Единбурга. Вона написала дизайнерові втретє й просить ескізи. Тим часом сама почала малювати руки бабусі.</p>
HTML
            . "\n<p><small><em>Натхнення: James Alcott, {$sourceBookspace}, 28 листопада 2026 р. Посилання: Ilona Andrews, {$sourceTor}; Jane Friedman, {$sourceFriedman}.</em></small></p>",
        ],
    ],
];
