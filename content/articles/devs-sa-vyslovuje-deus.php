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
 * Esej o minisérii Devs (Alex Garland, 2020): názov oddelenia je Deus.
 * Overené 28. 11. 2026: ČSFD.sk (71 %, 1 597 hodnotení, 8 epizód, USA 2020),
 * Wikipedia/IMDb (premiéra FX on Hulu 5. 3. 2020, Sonoya Mizuno, Nick Offerman, Alison Pill).
 * Bez osobných ani zdravotných údajov tretích strán.
 */
return [
    'slug' => 'devs-sa-vyslovuje-deus',
    'author' => 'MUDr. Ľubomír Polaščín',
    'category' => 'blog',
    'is_top' => 0,
    'published_at' => '2026-11-28 14:15:00',
    'image' => 'images/articles/devs-sa-vyslovuje-deus.webp',
    'translations' => [
        'sk' => [
            'title' => 'Devs sa vyslovuje Deus',
            'image_alt' => 'Zlatistá priesvitná kocka vo fialovom priestore, cez ktorú prechádzajú tyrkysové svetelné dráhy; čistá ilustrácia bez textu.',
            'excerpt' => 'Miniséria Alexa Garlanda z roku 2020 má v názve oddelenie vývoja. V skutočnosti ide o latinské Deus. Predpoveď môže byť hustá a zodpovednosť aj tak nezanikne.',
            'content' => <<<'HTML'
<p>Na <a href="https://www.csfd.sk/film/777240-devs/prehlad/">ČSFD</a> stojí pri minisérii <em>Devs</em> rok 2020, žánre dráma, sci-fi a thriller, osem epizód a tvorca Alex Garland. Hodnotenie 28. novembra 2026 bolo 71 % z 1 597 hlasov. Stručný obsah hovorí o softvérovej inžinierke Lily Chanovej, ktorá vyšetruje uzavretú divíziu rozvoja technologickej firmy v Silicon Valley a spája ju so smrťou svojho partnera.</p>
<p>To stačí na vstup. Zvyšok textu predpokladá, že poznáte príbeh, alebo ste ochotní ísť do spoileru. Pointa je v mene.</p>
<p>Garland napísal, režíroval a vystaval celú osemdielnu minisériu. Hrajú Sonoya Mizuno, Nick Offerman a Alison Pill. Premiéra bola 5. marca 2020 na FX on Hulu. Oddelenie sa volá Devs, teda vývojári. Až neskôr padne vysvetlenie, ktoré názov otočí: písmeno <em>v</em> je rímske <em>u</em>. Systém sa nevyslovuje „devs“. Vyslovuje sa Deus. Boh.</p>
<p>Stroj v zlatej klietke kreslí minulosť aj budúcnosť. Jeho majitelia berú determinizmus vážne: pri daných podmienkach je cesta jedna. Keď mapa ukáže, čo sa stane, zdá sa, že voľba bola ilúzia. Garland však nenechá túto vetu ako poslednú. Predpoveď, ktorá tvrdí, že iná cesta nebola, ešte nie je rozhodnutie. Mapa môže byť hustá. Zodpovednosť sa ňou nezruší.</p>
<p>To je dôvod, prečo ma táto miniséria zaujíma aj mimo sci-fi. V praxi, kde niekto podpisuje súhlas alebo odmietnutie, nestačí povedať, že „tak to malo dopadnúť“. Stačí vedieť, že predpoveď a čin nie sú to isté. O slobodnej vôli som písal aj v texte <a href="article.php?slug=co-jestvuje-ked-nic-nezjestvuje">Čo jestvuje, keď nič nezjestvuje</a>: vedomý popud nemusí byť prvý pohyb v hlave, a predsa je to, na čom stojí veta „rozhodol som sa“. <em>Devs</em> túto otázku neuzatvára laboratóriom. Necháva ju v mene, ktoré sme najprv čítali ako skratku vývoja.</p>
<p>Ak chcete len atmosféru a napätie, miniséria ich má. Ak chcete jednu vetu, nech je táto: systém, ktorý sa tvári ako oddelenie vývoja, môže byť Bohom len dovtedy, kým niekto ešte koná tak, ako keby na voľbe záležalo.</p>
<p><small><em>Inšpirácia a overenie 28. novembra 2026: <a href="https://www.csfd.sk/film/777240-devs/prehlad/">ČSFD, Devs (2020)</a>; <a href="https://en.wikipedia.org/wiki/Devs_(TV_series)">Wikipedia, Devs (TV series)</a>; <a href="https://www.imdb.com/title/tt8134186/">IMDb, Devs</a>. Text obsahuje spoiler k významu názvu.</em></small></p>
HTML,
        ],
        'en' => [
            'title' => 'Devs is pronounced Deus',
            'image_alt' => 'A translucent golden cube in violet space, with teal paths of light passing through it; clean illustration without text.',
            'excerpt' => 'Alex Garland’s 2020 miniseries names a development division Devs. It is Latin Deus. A dense forecast still does not cancel responsibility.',
            'content' => <<<'HTML'
<p>On <a href="https://www.csfd.sk/film/777240-devs/prehlad/">ČSFD</a>, the miniseries <em>Devs</em> is listed as 2020, drama, sci-fi and thriller, eight episodes, created by Alex Garland. On 28 November 2026 the rating stood at 71% from 1,597 votes. The short synopsis follows software engineer Lily Chan as she investigates a closed development division at a Silicon Valley tech firm and links it to her partner’s death.</p>
<p>That is enough to enter. The rest of this piece assumes you know the story, or are willing to take a spoiler. The point is in the name.</p>
<p>Garland wrote, directed and shaped the whole eight-part miniseries. It stars Sonoya Mizuno, Nick Offerman and Alison Pill. It premiered on 5 March 2020 on FX on Hulu. The division is called Devs, as in developers. Later comes the turn that reverses the title: the letter <em>v</em> is a Roman <em>u</em>. The system is not pronounced “devs”. It is pronounced Deus. God.</p>
<p>A machine in a golden cage draws the past and the future. Its owners take determinism seriously: given the conditions, there is one path. When the map shows what will happen, choice can look like an illusion. Garland does not leave that sentence as the last word. A forecast that claims there was no other path is still not a decision. The map may be dense. Responsibility is not cancelled by it.</p>
<p>That is why the miniseries interests me beyond sci-fi. In practice, where someone signs consent or refusal, it is not enough to say “this is how it had to end”. It is enough to know that a forecast and an act are not the same thing. I wrote about free will also in <a href="article.php?slug=co-jestvuje-ked-nic-nezjestvuje">What exists when nothing exists</a>: the conscious urge need not be the first movement in the head, and yet it is what the sentence “I decided” stands on. <em>Devs</em> does not close that question with a laboratory. It leaves it in a name we first read as a development acronym.</p>
<p>If you want atmosphere and tension, the miniseries has both. If you want one sentence, let it be this: a system that poses as a development division can be God only for as long as someone still acts as if the choice mattered.</p>
<p><small><em>Inspiration and verification 28 November 2026: <a href="https://www.csfd.sk/film/777240-devs/prehlad/">ČSFD, Devs (2020)</a>; <a href="https://en.wikipedia.org/wiki/Devs_(TV_series)">Wikipedia, Devs (TV series)</a>; <a href="https://www.imdb.com/title/tt8134186/">IMDb, Devs</a>. This text spoils the meaning of the title.</em></small></p>
HTML,
        ],
        'cs' => [
            'title' => 'Devs se vyslovuje Deus',
            'image_alt' => 'Zlatavá průsvitná kostka ve fialovém prostoru, jíž procházejí tyrkysové světelné dráhy; čistá ilustrace bez textu.',
            'excerpt' => 'Minisérie Alexe Garlanda z roku 2020 má v názvu oddělení vývoje. Ve skutečnosti jde o latinské Deus. Předpověď může být hustá a odpovědnost přesto nezanikne.',
            'content' => <<<'HTML'
<p>Na <a href="https://www.csfd.sk/film/777240-devs/prehlad/">ČSFD</a> stojí u minisérie <em>Devs</em> rok 2020, žánry drama, sci-fi a thriller, osm epizod a tvůrce Alex Garland. Hodnocení 28. listopadu 2026 bylo 71 % z 1 597 hlasů. Stručný obsah mluví o softwarové inženýrce Lily Chanové, která vyšetřuje uzavřenou divizi rozvoje technologické firmy v Silicon Valley a spojuje ji se smrtí svého partnera.</p>
<p>To stačí na vstup. Zbytek textu předpokládá, že příběh znáte, nebo jste ochotni jít do spoileru. Pointa je ve jméně.</p>
<p>Garland napsal, režíroval a vystavěl celou osmidílnou minisérii. Hrají Sonoya Mizuno, Nick Offerman a Alison Pill. Premiéra byla 5. března 2020 na FX on Hulu. Oddělení se jmenuje Devs, tedy vývojáři. Až později padne vysvětlení, které název otočí: písmeno <em>v</em> je římské <em>u</em>. Systém se nevyslovuje „devs“. Vyslovuje se Deus. Bůh.</p>
<p>Stroj ve zlaté kleci kreslí minulost i budoucnost. Jeho majitelé berou determinismus vážně: při daných podmínkách je cesta jedna. Když mapa ukáže, co se stane, zdá se, že volba byla iluze. Garland však nenechá tuto větu jako poslední. Předpověď, která tvrdí, že jiná cesta nebyla, ještě není rozhodnutí. Mapa může být hustá. Odpovědnost se jí nezruší.</p>
<p>To je důvod, proč mě tato minisérie zajímá i mimo sci-fi. V praxi, kde někdo podepisuje souhlas nebo odmítnutí, nestačí říct, že „tak to mělo dopadnout“. Stačí vědět, že předpověď a čin nejsou totéž. O svobodné vůli jsem psal i v textu <a href="article.php?slug=co-jestvuje-ked-nic-nezjestvuje">Čo jestvuje, keď nič nezjestvuje</a>: vědomý popud nemusí být první pohyb v hlavě, a přesto je to, na čem stojí věta „rozhodl jsem se“. <em>Devs</em> tuto otázku neuzavírá laboratoří. Nechává ji ve jméně, které jsme nejprve četli jako zkratku vývoje.</p>
<p>Chcete-li jen atmosféru a napětí, minisérie je má. Chcete-li jednu větu, ať je tato: systém, který se tváří jako oddělení vývoje, může být Bohem jen potud, dokud někdo ještě jedná tak, jako by na volbě záleželo.</p>
<p><small><em>Inspirace a ověření 28. listopadu 2026: <a href="https://www.csfd.sk/film/777240-devs/prehlad/">ČSFD, Devs (2020)</a>; <a href="https://en.wikipedia.org/wiki/Devs_(TV_series)">Wikipedia, Devs (TV series)</a>; <a href="https://www.imdb.com/title/tt8134186/">IMDb, Devs</a>. Text obsahuje spoiler k významu názvu.</em></small></p>
HTML,
        ],
        'de' => [
            'title' => 'Devs spricht man Deus',
            'image_alt' => 'Ein durchscheinender goldener Würfel in violettem Raum, durchzogen von türkisen Lichtbahnen; klare Illustration ohne Text.',
            'excerpt' => 'Alex Garlands Miniserie von 2020 nennt eine Entwicklungsabteilung Devs. Gemeint ist lateinisch Deus. Eine dichte Vorhersage hebt Verantwortung nicht auf.',
            'content' => <<<'HTML'
<p>Auf <a href="https://www.csfd.sk/film/777240-devs/prehlad/">ČSFD</a> steht bei der Miniserie <em>Devs</em> das Jahr 2020, die Genres Drama, Sci-Fi und Thriller, acht Episoden und der Schöpfer Alex Garland. Die Bewertung am 28. November 2026 betrug 71 % aus 1 597 Stimmen. Die kurze Inhaltsangabe folgt der Softwareingenieurin Lily Chan, die eine geschlossene Entwicklungsabteilung einer Tech-Firma im Silicon Valley untersucht und mit dem Tod ihres Partners verknüpft.</p>
<p>Das genügt zum Einstieg. Der Rest setzt voraus, dass Sie die Geschichte kennen oder einen Spoiler in Kauf nehmen. Die Pointe steckt im Namen.</p>
<p>Garland schrieb, führte Regie und baute die gesamte achteilige Miniserie. Mit Sonoya Mizuno, Nick Offerman und Alison Pill. Premiere war am 5. März 2020 auf FX on Hulu. Die Abteilung heißt Devs, also Entwickler. Später kommt die Wendung, die den Titel umkehrt: der Buchstabe <em>v</em> ist ein römisches <em>u</em>. Das System spricht man nicht „devs“. Man spricht es Deus. Gott.</p>
<p>Eine Maschine im goldenen Käfig zeichnet Vergangenheit und Zukunft. Ihre Besitzer nehmen den Determinismus ernst: bei gegebenen Bedingungen gibt es einen Weg. Zeigt die Karte, was geschieht, scheint die Wahl eine Illusion. Garland lässt diesen Satz nicht das letzte Wort sein. Eine Vorhersage, die behauptet, es habe keinen anderen Weg gegeben, ist noch keine Entscheidung. Die Karte mag dicht sein. Verantwortung löscht sie nicht.</p>
<p>Deshalb interessiert mich die Miniserie auch jenseits von Sci-Fi. In der Praxis, wo jemand Zustimmung oder Ablehnung unterschreibt, reicht es nicht zu sagen, „so musste es enden“. Es reicht zu wissen, dass Vorhersage und Tat nicht dasselbe sind. Über den freien Willen schrieb ich auch in <a href="article.php?slug=co-jestvuje-ked-nic-nezjestvuje">Was existiert, wenn nichts existiert</a>: der bewusste Impuls muss nicht die erste Bewegung im Kopf sein, und doch ist er das, worauf der Satz „ich habe entschieden“ steht. <em>Devs</em> schließt diese Frage nicht mit einem Labor. Sie bleibt in einem Namen, den wir zuerst als Entwicklungsakronym lasen.</p>
<p>Wer nur Atmosphäre und Spannung will, findet beides. Wer einen Satz will, nehme diesen: ein System, das sich als Entwicklungsabteilung gibt, kann Gott nur so lange sein, wie jemand noch handelt, als ob die Wahl zählte.</p>
<p><small><em>Inspiration und Prüfung am 28. November 2026: <a href="https://www.csfd.sk/film/777240-devs/prehlad/">ČSFD, Devs (2020)</a>; <a href="https://en.wikipedia.org/wiki/Devs_(TV_series)">Wikipedia, Devs (TV series)</a>; <a href="https://www.imdb.com/title/tt8134186/">IMDb, Devs</a>. Der Text spoilt die Bedeutung des Titels.</em></small></p>
HTML,
        ],
        'fr' => [
            'title' => 'Devs se prononce Deus',
            'image_alt' => 'Un cube doré translucide dans un espace violet, traversé de trajectoires de lumière turquoise ; illustration nette sans texte.',
            'excerpt' => 'La mini-série d’Alex Garland (2020) nomme une division de développement Devs. C’est le latin Deus. Une prévision dense n’annule pas la responsabilité.',
            'content' => <<<'HTML'
<p>Sur <a href="https://www.csfd.sk/film/777240-devs/prehlad/">ČSFD</a>, la mini-série <em>Devs</em> est datée 2020, genres drame, science-fiction et thriller, huit épisodes, créée par Alex Garland. Le 28 novembre 2026, la note était de 71 % pour 1 597 votes. Le résumé suit l’ingénieure logicielle Lily Chan, qui enquête sur une division de développement fermée d’une entreprise technologique de la Silicon Valley et la relie à la mort de son compagnon.</p>
<p>Cela suffit pour entrer. La suite suppose que vous connaissez l’histoire, ou acceptez un spoiler. Le point est dans le nom.</p>
<p>Garland a écrit, réalisé et construit toute la mini-série en huit parties. Avec Sonoya Mizuno, Nick Offerman et Alison Pill. Première le 5 mars 2020 sur FX on Hulu. La division s’appelle Devs, comme développeurs. Plus tard vient le retournement du titre : la lettre <em>v</em> est un <em>u</em> romain. Le système ne se prononce pas « devs ». Il se prononce Deus. Dieu.</p>
<p>Une machine dans une cage dorée dessine le passé et l’avenir. Ses propriétaires prennent le déterminisme au sérieux : dans des conditions données, il n’y a qu’un chemin. Quand la carte montre ce qui arrivera, le choix peut paraître une illusion. Garland ne laisse pas cette phrase comme dernier mot. Une prévision qui affirme qu’il n’y avait pas d’autre voie n’est pas encore une décision. La carte peut être dense. Elle n’annule pas la responsabilité.</p>
<p>C’est pourquoi cette mini-série m’intéresse aussi hors de la science-fiction. Dans la pratique, où quelqu’un signe un consentement ou un refus, il ne suffit pas de dire « cela devait finir ainsi ». Il suffit de savoir qu’une prévision et un acte ne sont pas la même chose. J’ai aussi écrit sur le libre arbitre dans <a href="article.php?slug=co-jestvuje-ked-nic-nezjestvuje">Ce qui existe quand rien n’existe</a> : l’élan conscient n’a pas besoin d’être le premier mouvement dans la tête, et pourtant c’est sur lui que repose la phrase « j’ai décidé ». <em>Devs</em> ne ferme pas cette question par un laboratoire. Elle la laisse dans un nom que nous avions d’abord lu comme un sigle de développement.</p>
<p>Si vous voulez seulement l’atmosphère et la tension, la mini-série les a. Si vous voulez une phrase, que ce soit celle-ci : un système qui se donne pour une division de développement ne peut être Dieu que tant que quelqu’un agit encore comme si le choix comptait.</p>
<p><small><em>Inspiration et vérification le 28 novembre 2026 : <a href="https://www.csfd.sk/film/777240-devs/prehlad/">ČSFD, Devs (2020)</a> ; <a href="https://en.wikipedia.org/wiki/Devs_(TV_series)">Wikipedia, Devs (TV series)</a> ; <a href="https://www.imdb.com/title/tt8134186/">IMDb, Devs</a>. Le texte révèle le sens du titre.</em></small></p>
HTML,
        ],
        'es' => [
            'title' => 'Devs se pronuncia Deus',
            'image_alt' => 'Un cubo dorado translúcido en un espacio violeta, atravesado por trayectorias de luz turquesa; ilustración limpia sin texto.',
            'excerpt' => 'La miniserie de Alex Garland (2020) llama Devs a una división de desarrollo. Es el latín Deus. Un pronóstico denso no cancela la responsabilidad.',
            'content' => <<<'HTML'
<p>En <a href="https://www.csfd.sk/film/777240-devs/prehlad/">ČSFD</a>, la miniserie <em>Devs</em> aparece como 2020, géneros drama, ciencia ficción y thriller, ocho episodios, creada por Alex Garland. El 28 de noviembre de 2026 la valoración era del 71 % con 1 597 votos. La sinopsis breve sigue a la ingeniera de software Lily Chan, que investiga una división de desarrollo cerrada de una empresa tecnológica de Silicon Valley y la relaciona con la muerte de su pareja.</p>
<p>Eso basta para entrar. El resto supone que conoce la historia o acepta un spoiler. La clave está en el nombre.</p>
<p>Garland escribió, dirigió y construyó toda la miniserie de ocho partes. Con Sonoya Mizuno, Nick Offerman y Alison Pill. Estreno el 5 de marzo de 2020 en FX on Hulu. La división se llama Devs, como desarrolladores. Más tarde llega el giro que invierte el título: la letra <em>v</em> es una <em>u</em> romana. El sistema no se pronuncia «devs». Se pronuncia Deus. Dios.</p>
<p>Una máquina en una jaula dorada dibuja el pasado y el futuro. Sus dueños toman en serio el determinismo: dadas las condiciones, hay un solo camino. Cuando el mapa muestra lo que ocurrirá, la elección puede parecer una ilusión. Garland no deja esa frase como la última. Un pronóstico que afirma que no había otro camino aún no es una decisión. El mapa puede ser denso. No cancela la responsabilidad.</p>
<p>Por eso la miniserie me interesa también fuera de la ciencia ficción. En la práctica, donde alguien firma un consentimiento o una negativa, no basta decir «así tenía que acabar». Basta saber que un pronóstico y un acto no son lo mismo. También escribí sobre el libre albedrío en <a href="article.php?slug=co-jestvuje-ked-nic-nezjestvuje">Qué existe cuando nada existe</a>: el impulso consciente no tiene que ser el primer movimiento en la cabeza, y sin embargo es aquello sobre lo que se sostiene la frase «decidí». <em>Devs</em> no cierra esa pregunta con un laboratorio. La deja en un nombre que primero leímos como sigla de desarrollo.</p>
<p>Si solo quiere atmósfera y tensión, la miniserie las tiene. Si quiere una frase, que sea esta: un sistema que se presenta como división de desarrollo solo puede ser Dios mientras alguien actúe todavía como si la elección importara.</p>
<p><small><em>Inspiración y verificación el 28 de noviembre de 2026: <a href="https://www.csfd.sk/film/777240-devs/prehlad/">ČSFD, Devs (2020)</a>; <a href="https://en.wikipedia.org/wiki/Devs_(TV_series)">Wikipedia, Devs (TV series)</a>; <a href="https://www.imdb.com/title/tt8134186/">IMDb, Devs</a>. El texto revela el sentido del título.</em></small></p>
HTML,
        ],
        'pl' => [
            'title' => 'Devs wymawia się Deus',
            'image_alt' => 'Przeźroczysta złota kostka w fioletowej przestrzeni, przez którą przechodzą turkusowe tory światła; czysta ilustracja bez tekstu.',
            'excerpt' => 'Miniserial Alexa Garlanda z 2020 roku nazywa dział rozwoju Devs. To łacińskie Deus. Gęsta prognoza nie kasuje odpowiedzialności.',
            'content' => <<<'HTML'
<p>Na <a href="https://www.csfd.sk/film/777240-devs/prehlad/">ČSFD</a> przy miniserialu <em>Devs</em> stoi rok 2020, gatunki dramat, sci-fi i thriller, osiem odcinków i twórca Alex Garland. Ocena 28 listopada 2026 wynosiła 71 % z 1 597 głosów. Krótki opis śledzi inżynierkę oprogramowania Lily Chan, która bada zamknięty dział rozwoju firmy technologicznej z Doliny Krzemowej i łączy go ze śmiercią partnera.</p>
<p>To wystarczy na wejście. Reszta zakłada, że znacie fabułę albo godzicie się na spoiler. Pointa jest w nazwie.</p>
<p>Garland napisał, wyreżyserował i zbudował cały ośmioodcinkowy miniserial. Grają Sonoya Mizuno, Nick Offerman i Alison Pill. Premiera 5 marca 2020 na FX on Hulu. Dział nazywa się Devs, czyli deweloperzy. Później pada wyjaśnienie, które odwraca tytuł: litera <em>v</em> to rzymskie <em>u</em>. Systemu nie wymawia się „devs”. Wymawia się Deus. Bóg.</p>
<p>Maszyna w złotej klatce rysuje przeszłość i przyszłość. Jej właściciele biorą determinizm serio: przy danych warunkach droga jest jedna. Gdy mapa pokazuje, co się stanie, wybór może wyglądać jak złudzenie. Garland nie zostawia tego zdania jako ostatniego. Prognoza, która twierdzi, że innej drogi nie było, wciąż nie jest decyzją. Mapa może być gęsta. Odpowiedzialności nie kasuje.</p>
<p>Dlatego ten miniserial interesuje mnie także poza sci-fi. W praktyce, gdzie ktoś podpisuje zgodę lub odmowę, nie wystarczy powiedzieć „tak miało się skończyć”. Wystarczy wiedzieć, że prognoza i czyn to nie to samo. O wolnej woli pisałem też w tekście <a href="article.php?slug=co-jestvuje-ked-nic-nezjestvuje">Co istnieje, gdy nic nie istnieje</a>: świadomy impuls nie musi być pierwszym ruchem w głowie, a jednak to na nim stoi zdanie „zdecydowałem”. <em>Devs</em> nie zamyka tego pytania laboratorium. Zostawia je w nazwie, którą najpierw czytaliśmy jako skrót rozwoju.</p>
<p>Jeśli chcecie tylko atmosferę i napięcie, miniserial je ma. Jeśli jedno zdanie, niech będzie takie: system, który udaje dział rozwoju, może być Bogiem tylko dopóty, dopóki ktoś jeszcze działa tak, jakby wybór miał znaczenie.</p>
<p><small><em>Inspiracja i weryfikacja 28 listopada 2026: <a href="https://www.csfd.sk/film/777240-devs/prehlad/">ČSFD, Devs (2020)</a>; <a href="https://en.wikipedia.org/wiki/Devs_(TV_series)">Wikipedia, Devs (TV series)</a>; <a href="https://www.imdb.com/title/tt8134186/">IMDb, Devs</a>. Tekst ujawnia znaczenie tytułu.</em></small></p>
HTML,
        ],
        'hu' => [
            'title' => 'A Devs kiejtése Deus',
            'image_alt' => 'Áttetsző arany kocka ibolyaszínű térben, rajta átfutó türkiz fényösvényekkel; tiszta illusztráció szöveg nélkül.',
            'excerpt' => 'Alex Garland 2020-as minisorozata fejlesztési részleget nevez Devsnek. Valójában a latin Deus. Sűrű előrejelzés sem törli a felelősséget.',
            'content' => <<<'HTML'
<p>A <a href="https://www.csfd.sk/film/777240-devs/prehlad/">ČSFD</a>-n a <em>Devs</em> minisorozatnál 2020 áll, műfajok: dráma, sci-fi és thriller, nyolc epizód, alkotója Alex Garland. 2026. november 28-án az értékelés 71 % volt 1 597 szavazatból. A rövid tartalom Lily Chan szoftvermérnököt követi, aki a Silicon Valley-beli techcég zárt fejlesztési részlegét vizsgálja, és partnerének halálához köti.</p>
<p>Ez elég a belépéshez. A folytatás feltételezi, hogy ismeritek a történetet, vagy vállaljátok a spoilert. A lényeg a névben van.</p>
<p>Garland megírta, rendezte és felépítette a teljes nyolcrészes minisorozatot. Szereplők: Sonoya Mizuno, Nick Offerman és Alison Pill. Bemutató: 2020. március 5., FX on Hulu. A részleg neve Devs, azaz fejlesztők. Később jön a fordulat, amely megfordítja a címet: a <em>v</em> betű római <em>u</em>. A rendszert nem „devs”-nek ejtik. Deusnak. Istennek.</p>
<p>Egy arany ketrecben lévő gép a múltat és a jövőt rajzolja. Tulajdonosai komolyan veszik a determinizmust: adott feltételek mellett egy út van. Ha a térkép megmutatja, mi történik, a választás illúziónak tűnhet. Garland mégsem hagyja ezt az utolsó mondatnak. Az előrejelzés, amely azt állítja, nem volt más út, még nem döntés. A térkép lehet sűrű. A felelősséget nem törli el.</p>
<p>Ezért érdekel a minisorozat a sci-fin túl is. A gyakorlatban, ahol valaki beleegyezést vagy elutasítást ír alá, nem elég azt mondani: „így kellett végződnie”. Elég tudni, hogy az előrejelzés és a tett nem ugyanaz. A szabad akaratról a <a href="article.php?slug=co-jestvuje-ked-nic-nezjestvuje">Mi létezik, ha semmi sem létezik</a> című szövegben is írtam: a tudatos késztetésnek nem kell a fej első mozgásának lennie, és mégis ezen áll a „döntöttem” mondat. A <em>Devs</em> ezt a kérdést nem zárja laborral. Egy olyan névben hagyja, amelyet először fejlesztési betűszónak olvastunk.</p>
<p>Ha csak hangulatot és feszültséget akartok, a minisorozatnak van mindkettő. Ha egy mondatot, legyen ez: a rendszer, amely fejlesztési részlegnek adja ki magát, csak addig lehet Isten, amíg valaki még úgy cselekszik, mintha a választás számítana.</p>
<p><small><em>Inspiráció és ellenőrzés 2026. november 28.: <a href="https://www.csfd.sk/film/777240-devs/prehlad/">ČSFD, Devs (2020)</a>; <a href="https://en.wikipedia.org/wiki/Devs_(TV_series)">Wikipedia, Devs (TV series)</a>; <a href="https://www.imdb.com/title/tt8134186/">IMDb, Devs</a>. A szöveg spoilereli a cím jelentését.</em></small></p>
HTML,
        ],
        'it' => [
            'title' => 'Devs si pronuncia Deus',
            'image_alt' => 'Un cubo dorato traslucido in uno spazio violetto, attraversato da traiettorie di luce turchese; illustrazione nitida senza testo.',
            'excerpt' => 'La miniserie di Alex Garland del 2020 chiama Devs una divisione di sviluppo. È il latino Deus. Una previsione densa non cancella la responsabilità.',
            'content' => <<<'HTML'
<p>Su <a href="https://www.csfd.sk/film/777240-devs/prehlad/">ČSFD</a> la miniserie <em>Devs</em> risulta del 2020, generi drama, fantascienza e thriller, otto episodi, creata da Alex Garland. Il 28 novembre 2026 la valutazione era del 71 % su 1 597 voti. La sinossi breve segue l’ingegnera del software Lily Chan, che indaga su una divisione di sviluppo chiusa di un’azienda tecnologica della Silicon Valley e la collega alla morte del partner.</p>
<p>Questo basta per entrare. Il resto presuppone che conosciate la storia o accettiate uno spoiler. Il punto è nel nome.</p>
<p>Garland ha scritto, diretto e costruito l’intera miniserie in otto parti. Con Sonoya Mizuno, Nick Offerman e Alison Pill. Prima il 5 marzo 2020 su FX on Hulu. La divisione si chiama Devs, cioè sviluppatori. Più tardi arriva la svolta che ribalta il titolo: la lettera <em>v</em> è una <em>u</em> romana. Il sistema non si pronuncia «devs». Si pronuncia Deus. Dio.</p>
<p>Una macchina in una gabbia dorata disegna il passato e il futuro. I suoi proprietari prendono sul serio il determinismo: date le condizioni, c’è una sola via. Quando la mappa mostra ciò che accadrà, la scelta può sembrare un’illusione. Garland non lascia quella frase come ultima. Una previsione che afferma che non c’era un’altra via non è ancora una decisione. La mappa può essere densa. Non cancella la responsabilità.</p>
<p>Per questo la miniserie mi interessa anche oltre la fantascienza. Nella pratica, dove qualcuno firma un consenso o un rifiuto, non basta dire «doveva finire così». Basta sapere che una previsione e un atto non sono la stessa cosa. Ho scritto sul libero arbitrio anche in <a href="article.php?slug=co-jestvuje-ked-nic-nezjestvuje">Cosa esiste quando nulla esiste</a>: l’impulso consapevole non deve essere il primo movimento nella testa, eppure è ciò su cui regge la frase «ho deciso». <em>Devs</em> non chiude questa domanda con un laboratorio. La lascia in un nome che all’inizio leggevamo come sigla di sviluppo.</p>
<p>Se volete solo atmosfera e tensione, la miniserie le ha. Se volete una frase, sia questa: un sistema che si presenta come divisione di sviluppo può essere Dio solo finché qualcuno agisce ancora come se la scelta contasse.</p>
<p><small><em>Ispirazione e verifica il 28 novembre 2026: <a href="https://www.csfd.sk/film/777240-devs/prehlad/">ČSFD, Devs (2020)</a>; <a href="https://en.wikipedia.org/wiki/Devs_(TV_series)">Wikipedia, Devs (TV series)</a>; <a href="https://www.imdb.com/title/tt8134186/">IMDb, Devs</a>. Il testo rivela il significato del titolo.</em></small></p>
HTML,
        ],
        'uk' => [
            'title' => 'Devs вимовляється Deus',
            'image_alt' => 'Напівпрозорий золотавий куб у фіолетовому просторі, крізь який проходять бірюзові світлові шляхи; чиста ілюстрація без тексту.',
            'excerpt' => 'Мінісеріал Алекса Ґарленда 2020 року називає відділ розробки Devs. Насправді це латинське Deus. Густий прогноз не скасовує відповідальності.',
            'content' => <<<'HTML'
<p>На <a href="https://www.csfd.sk/film/777240-devs/prehlad/">ČSFD</a> біля мінісеріалу <em>Devs</em> стоїть 2020 рік, жанри драма, наукова фантастика і трилер, вісім епізодів і творець Алекс Ґарленд. Оцінка 28 листопада 2026 року була 71 % з 1 597 голосів. Короткий опис іде за інженеркою програмного забезпечення Лілі Чан, яка розслідує закритий відділ розвитку технологічної компанії в Силіконовій долині й пов’язує його зі смертю партнера.</p>
<p>Цього досить для входу. Далі текст передбачає, що ви знаєте історію або готові до спойлера. Суть у назві.</p>
<p>Ґарленд написав, зрежисував і вибудував увесь восьмисерійний мінісеріал. У ролях Sonoya Mizuno, Nick Offerman і Alison Pill. Прем’єра 5 березня 2020 на FX on Hulu. Відділ називається Devs, тобто розробники. Пізніше лунає пояснення, яке перевертає назву: літера <em>v</em> є римським <em>u</em>. Систему не вимовляють «devs». Вимовляють Deus. Бог.</p>
<p>Машина в золотій клітці малює минуле й майбутнє. Її власники сприймають детермінізм серйозно: за даних умов шлях один. Коли карта показує, що станеться, вибір може здатися ілюзією. Ґарленд не лишає це речення останнім. Прогноз, який твердить, що іншого шляху не було, ще не є рішенням. Карта може бути густою. Відповідальність вона не скасовує.</p>
<p>Тому цей мінісеріал цікавить мене й поза науковою фантастикою. На практиці, де хтось підписує згоду або відмову, недостатньо сказати «так і мало закінчитись». Достатньо знати, що прогноз і вчинок не є одним і тим самим. Про вільну волю я писав також у тексті <a href="article.php?slug=co-jestvuje-ked-nic-nezjestvuje">Що існує, коли нічого не існує</a>: свідомий поштовх не мусить бути першим рухом у голові, і все ж саме на ньому стоїть речення «я вирішив». <em>Devs</em> не закриває це питання лабораторією. Залишає його в назві, яку спочатку читали як абревіатуру розвитку.</p>
<p>Якщо потрібні лише атмосфера й напруга, мінісеріал їх має. Якщо одне речення, хай буде таке: система, що вдає з себе відділ розвитку, може бути Богом лише доти, доки хтось іще діє так, ніби вибір має значення.</p>
<p><small><em>Натхнення й перевірка 28 листопада 2026: <a href="https://www.csfd.sk/film/777240-devs/prehlad/">ČSFD, Devs (2020)</a>; <a href="https://en.wikipedia.org/wiki/Devs_(TV_series)">Wikipedia, Devs (TV series)</a>; <a href="https://www.imdb.com/title/tt8134186/">IMDb, Devs</a>. Текст розкриває значення назви.</em></small></p>
HTML,
        ],
    ],
];
