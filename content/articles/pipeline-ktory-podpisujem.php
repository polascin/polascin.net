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
 * Trinásť článkov medzi 17. a 25. septembrom 2026 a kontrola pred nasadením.
 * Počet je zo súborov content/articles podľa published_at.
 * Aeon: Massimo Pigliucci, He was probably right, 21. 9. 2026.
 */
return [
    'slug' => 'pipeline-ktory-podpisujem',
    'author' => 'MUDr. Ľubomír Polaščín',
    'category' => 'blog',
    'is_top' => 0,
    'published_at' => '2026-10-03 22:15:00',
    'image' => 'images/articles/pipeline-ktory-podpisujem.webp',
    'translations' => [
        'sk' => [
            'title' => 'Trinásť článkov za deväť dní. Podpis ostáva môj.',
            'image_alt' => 'Muž od chrbta pri tmavom stole v noci drží v ruke svietiacu stranu. Pred ním sa vejárom rozkladajú slabé fialové a tyrkysové strany a nad nimi visí svetelný znak začiarknutia.',
            'excerpt' => 'Medzi 17. a 25. septembrom 2026 vyšlo na tomto webe trinásť článkov, každý v desiatich jazykoch. Nie je to rýchlejšie písanie. Je to postup. Agent text pripraví. Pred nasadením ostáva kontrola, ktorú nepreskočím.',
            'content' => <<<'HTML'
<p>Medzi 17. a 25. septembrom 2026 som na tomto webe zverejnil trinásť článkov. Každý je v slovenčine, angličtine, češtine, nemčine, taliančine, ukrajinčine, francúzštine, španielčine, poľštine a maďarčine. Od prvého dňa po posledný je to deväť dní.</p>
<p>To nie je rýchlejšie písanie. Je to postup. Agentovi v Cursori odovzdám jeden zdrojový odkaz. Pripraví návrh, preloží ho a pomôže s nasadením. Výsledok sa potom overí. Postup si drží aj zoznam toho, čo už odišlo na X, aby sa ten istý text neposlal druhýkrát.</p>
<p>Z tohto radu si najviac stojím za textom, ktorý berie Cicerónove <em>probabilia</em> a vzťahuje ich na medicínu aj na písanie o umelej inteligencii. Názor má byť dosť pevný na čin a dosť voľný na opravu. Je to esej <a href="article.php?slug=dobry-skeptik-viac-nez-pochybnost">Dobrý skeptik má viac než pochybnosť a menej než istotu</a>. Vychádza z textu Massima Pigliucciho <a href="https://aeon.co/essays/a-good-sceptic-has-more-than-doubt-and-less-than-certainty"><em>He was probably right</em></a> na Aeon z 21. septembra 2026. Tá esej nie je liečebný postup.</p>
<p>To isté je princíp tohto postupu. Agent text pripraví. Nasadenie sa overí. Pravidlo, ktoré si nechávam, znie takto: ostávam človek, ktorý tvrdenie podpisuje. Nie je to výkaz, že som po slove prešiel každú už zverejnenú vetu. Je to záväzok, podľa ktorého ďalší text ide von.</p>
<p>Kontrola, ktorú pred nasadením nepreskočím, je konkrétna. Kľúčové stránky majú vrátiť stav 200, interné cesty stav 403, hlavička Content-Security-Policy má niesť nonce a mapa stránok má uviesť odkazy hreflang. Rýchlosť nie je riziko. Riziko je zverejniť niečo, čo ste neoverili.</p>
<p>Ak publikujete s pomocou umelej inteligencie, aká je vaša kontrola, ktorú pred nasadením neobídete?</p>
<p>Napíšte mi cez <a href="contact.php">kontakt</a>.</p>
HTML,
        ],
        'en' => [
            'title' => 'Thirteen articles in nine days. The signature stays mine.',
            'image_alt' => 'A man seen from behind at a dark desk at night holds a glowing page. A fan of faint purple and teal pages opens in front of him, and a check mark made of light hangs above them.',
            'excerpt' => 'Between 17 and 25 September 2026 this site published thirteen articles, each in ten languages. That is not faster typing. It is a pipeline. The agent drafts. Before deploy, a check remains that I do not skip.',
            'content' => <<<'HTML'
<p>Between 17 and 25 September 2026 I published thirteen articles on this site. Each one is in Slovak, English, Czech, German, Italian, Ukrainian, French, Spanish, Polish and Hungarian. From the first day to the last, that is nine days.</p>
<p>That is not faster typing. It is a pipeline. I hand an agent in Cursor one source link. It drafts, translates and helps with deployment. The result is then checked. The pipeline also keeps a list of what has already gone to X, so the same piece is not sent twice.</p>
<p>Of that run, the piece I stand by most takes Cicero’s <em>probabilia</em> and applies them to medicine and to writing about artificial intelligence. A view should be firm enough to act on and loose enough to revise. That essay is <a href="article.php?slug=dobry-skeptik-viac-nez-pochybnost">A good sceptic has more than doubt and less than certainty</a>. It starts from Massimo Pigliucci’s <a href="https://aeon.co/essays/a-good-sceptic-has-more-than-doubt-and-less-than-certainty"><em>He was probably right</em></a> on Aeon, 21 September 2026. That essay is not a treatment protocol.</p>
<p>The same thing is the design principle of this pipeline. The agent produces. Deployment is checked. The rule I keep is this: I remain the person who signs the claim. It is not a ledger that I have gone through every sentence already published, word by word. It is the commitment under which the next piece goes out.</p>
<p>The check I do not skip before deploy is concrete. Key pages should return status 200, internal paths status 403, the Content-Security-Policy header should carry a nonce, and the sitemap should list the hreflang links. Speed is not the risk. Publishing something you have not checked is.</p>
<p>If you publish with the help of artificial intelligence, what is the check you do not bypass before deploy?</p>
<p>Write to me via the <a href="contact.php">contact form</a>.</p>
HTML,
        ],
        'cs' => [
            'title' => 'Třináct článků za devět dní. Podpis zůstává můj.',
            'image_alt' => 'Muž zády k nám u tmavého stolu v noci drží v ruce svítící list. Před ním se vějířem rozevírají slabé fialové a tyrkysové listy a nad nimi visí fajfka ze světla.',
            'excerpt' => 'Mezi 17. a 25. zářím 2026 vyšlo na tomto webu třináct článků, každý v deseti jazycích. Není to rychlejší psaní. Je to postup. Agent text připraví. Před nasazením zůstává kontrola, kterou nepřeskočím.',
            'content' => <<<'HTML'
<p>Mezi 17. a 25. zářím 2026 jsem na tomto webu zveřejnil třináct článků. Každý je ve slovenštině, angličtině, češtině, němčině, italštině, ukrajinštině, francouzštině, španělštině, polštině a maďarštině. Od prvního dne k poslednímu je to devět dní.</p>
<p>To není rychlejší psaní. Je to postup. Agentovi v Cursoru předám jeden zdrojový odkaz. Připraví návrh, přeloží ho a pomůže s nasazením. Výsledek se potom ověří. Postup si drží i seznam toho, co už odešlo na X, aby se tentýž text neposlal podruhé.</p>
<p>Z této řady si nejvíc stojím za textem, který bere Ciceronova <em>probabilia</em> a vztahuje je na medicínu i na psaní o umělé inteligenci. Názor má být dost pevný na čin a dost volný na opravu. Je to esej <a href="article.php?slug=dobry-skeptik-viac-nez-pochybnost">Dobrý skeptik má víc než pochybnost a méně než jistotu</a>. Vychází z textu Massima Pigliucciho <a href="https://aeon.co/essays/a-good-sceptic-has-more-than-doubt-and-less-than-certainty"><em>He was probably right</em></a> na Aeonu z 21. září 2026. Ta esej není léčebný postup.</p>
<p>Totéž je princip tohoto postupu. Agent text připraví. Nasazení se ověří. Pravidlo, které si nechávám, zní takto: zůstávám člověk, který tvrzení podepisuje. Není to výkaz, že jsem po slově prošel každou už zveřejněnou větu. Je to závazek, podle kterého další text jde ven.</p>
<p>Kontrola, kterou před nasazením nepřeskočím, je konkrétní. Klíčové stránky mají vrátit stav 200, interní cesty stav 403, hlavička Content-Security-Policy má nést nonce a mapa stránek má uvést odkazy hreflang. Rychlost není riziko. Riziko je zveřejnit něco, co jste neověřili.</p>
<p>Pokud publikujete s pomocí umělé inteligence, jakou kontrolu před nasazením neobejdete?</p>
<p>Napište mi přes <a href="contact.php">kontakt</a>.</p>
HTML,
        ],
        'de' => [
            'title' => 'Dreizehn Beiträge in neun Tagen. Die Unterschrift bleibt meine.',
            'image_alt' => 'Ein Mann von hinten an einem dunklen Tisch bei Nacht hält ein leuchtendes Blatt. Vor ihm fächern sich schwache violette und türkise Seiten auf, darüber hängt ein Häkchen aus Licht.',
            'excerpt' => 'Zwischen dem 17. und dem 25. September 2026 erschienen auf dieser Website dreizehn Beiträge, jeder in zehn Sprachen. Das ist kein schnelleres Tippen. Es ist ein Ablauf. Der Agent schreibt. Vor der Veröffentlichung bleibt eine Prüfung, die ich nicht auslasse.',
            'content' => <<<'HTML'
<p>Zwischen dem 17. und dem 25. September 2026 habe ich auf dieser Website dreizehn Beiträge veröffentlicht. Jeder liegt auf Slowakisch, Englisch, Tschechisch, Deutsch, Italienisch, Ukrainisch, Französisch, Spanisch, Polnisch und Ungarisch vor. Vom ersten Tag bis zum letzten sind das neun Tage.</p>
<p>Das ist kein schnelleres Tippen. Es ist ein Ablauf. Einem Agenten in Cursor gebe ich einen Quelllink. Er entwirft, übersetzt und hilft bei der Veröffentlichung. Das Ergebnis wird danach geprüft. Der Ablauf führt auch eine Liste dessen, was schon auf X gegangen ist, damit derselbe Text nicht ein zweites Mal hinausgeht.</p>
<p>Aus dieser Reihe stehe ich am meisten zu dem Text, der Ciceros <em>probabilia</em> auf die Medizin und auf das Schreiben über künstliche Intelligenz bezieht. Eine Ansicht soll fest genug zum Handeln und locker genug zur Korrektur sein. Das ist der Essay <a href="article.php?slug=dobry-skeptik-viac-nez-pochybnost">Ein guter Skeptiker hat mehr als Zweifel und weniger als Gewissheit</a>. Er geht von Massimo Pigliuccis <a href="https://aeon.co/essays/a-good-sceptic-has-more-than-doubt-and-less-than-certainty"><em>He was probably right</em></a> auf Aeon vom 21. September 2026 aus. Dieser Essay ist kein Behandlungsprotokoll.</p>
<p>Dasselbe ist der Grundsatz dieses Ablaufs. Der Agent bereitet den Text vor. Die Veröffentlichung wird geprüft. Die Regel, die ich behalte, lautet: Ich bleibe der Mensch, der die Behauptung unterschreibt. Das ist keine Aufstellung, dass ich jeden schon veröffentlichten Satz Wort für Wort durchgegangen wäre. Es ist die Verpflichtung, unter der der nächste Text hinausgeht.</p>
<p>Die Prüfung, die ich vor der Veröffentlichung nicht auslasse, ist konkret. Zentrale Seiten sollen den Status 200 liefern, interne Pfade den Status 403, der Content-Security-Policy-Header soll eine Nonce tragen und die Sitemap soll die hreflang-Links nennen. Geschwindigkeit ist nicht das Risiko. Das Risiko ist, etwas zu veröffentlichen, das Sie nicht geprüft haben.</p>
<p>Wenn Sie mit Hilfe künstlicher Intelligenz veröffentlichen: Welche Prüfung lassen Sie vor der Veröffentlichung nicht aus?</p>
<p>Schreiben Sie mir über das <a href="contact.php">Kontaktformular</a>.</p>
HTML,
        ],
        'fr' => [
            'title' => 'Treize articles en neuf jours. La signature reste la mienne.',
            'image_alt' => 'Un homme vu de dos, à un bureau sombre la nuit, tient une page lumineuse. Devant lui s’ouvre un éventail de pages violettes et turquoise pâles, et au-dessus flotte une coche faite de lumière.',
            'excerpt' => 'Entre le 17 et le 25 septembre 2026, treize articles sont parus sur ce site, chacun en dix langues. Ce n’est pas une frappe plus rapide. C’est un circuit. L’agent prépare le texte. Avant la mise en ligne reste un contrôle que je ne saute pas.',
            'content' => <<<'HTML'
<p>Entre le 17 et le 25 septembre 2026, j’ai publié treize articles sur ce site. Chacun existe en slovaque, anglais, tchèque, allemand, italien, ukrainien, français, espagnol, polonais et hongrois. Du premier jour au dernier, cela fait neuf jours.</p>
<p>Ce n’est pas une frappe plus rapide. C’est un circuit. Je donne à un agent dans Cursor un seul lien source. Il prépare une version, la traduit et aide à la mise en ligne. Le résultat est ensuite vérifié. Le circuit garde aussi une liste de ce qui est déjà parti sur X, pour que le même texte ne parte pas une deuxième fois.</p>
<p>Dans cette série, le texte auquel je tiens le plus prend les <em>probabilia</em> de Cicéron et les applique à la médecine et à l’écriture sur l’intelligence artificielle. Un avis doit être assez ferme pour agir et assez souple pour être corrigé. C’est l’essai <a href="article.php?slug=dobry-skeptik-viac-nez-pochybnost">Un bon sceptique a plus que le doute et moins que la certitude</a>. Il part du texte de Massimo Pigliucci, <a href="https://aeon.co/essays/a-good-sceptic-has-more-than-doubt-and-less-than-certainty"><em>He was probably right</em></a>, sur Aeon, le 21 septembre 2026. Cet essai n’est pas un protocole de traitement.</p>
<p>Le même principe règle ce circuit. L’agent prépare le texte. La mise en ligne est vérifiée. La règle que je garde est celle-ci : je reste la personne qui signe l’affirmation. Ce n’est pas un relevé selon lequel j’aurais relu mot à mot chaque phrase déjà publiée. C’est l’engagement sous lequel le texte suivant sort.</p>
<p>Le contrôle que je ne saute pas avant la mise en ligne est concret. Les pages principales doivent renvoyer le statut 200, les chemins internes le statut 403, l’en-tête Content-Security-Policy doit porter un nonce et le plan du site doit indiquer les liens hreflang. La vitesse n’est pas le risque. Le risque est de publier quelque chose que vous n’avez pas vérifié.</p>
<p>Si vous publiez avec l’aide de l’intelligence artificielle, quel contrôle ne laissez-vous pas de côté avant la mise en ligne ?</p>
<p>Écrivez-moi via le <a href="contact.php">formulaire de contact</a>.</p>
HTML,
        ],
        'es' => [
            'title' => 'Trece artículos en nueve días. La firma sigue siendo mía.',
            'image_alt' => 'Un hombre de espaldas, ante un escritorio oscuro de noche, sostiene una hoja que brilla. Delante se abre un abanico de páginas moradas y turquesa tenues, y encima flota una marca de visto hecha de luz.',
            'excerpt' => 'Entre el 17 y el 25 de septiembre de 2026 aparecieron en este sitio trece artículos, cada uno en diez idiomas. No es teclear más rápido. Es un circuito. El agente prepara el texto. Antes de publicar queda un control que no me salto.',
            'content' => <<<'HTML'
<p>Entre el 17 y el 25 de septiembre de 2026 publiqué trece artículos en este sitio. Cada uno está en eslovaco, inglés, checo, alemán, italiano, ucraniano, francés, español, polaco y húngaro. Del primer día al último son nueve días.</p>
<p>No es teclear más rápido. Es un circuito. A un agente en Cursor le entrego un solo enlace de origen. Prepara un borrador, lo traduce y ayuda a publicarlo. El resultado se comprueba después. El circuito guarda también una lista de lo que ya salió en X, para que el mismo texto no se envíe una segunda vez.</p>
<p>De esa serie, el texto que más defiendo toma los <em>probabilia</em> de Cicerón y los aplica a la medicina y a la escritura sobre inteligencia artificial. Una opinión debe ser bastante firme para actuar y bastante suelta para corregirla. Es el ensayo <a href="article.php?slug=dobry-skeptik-viac-nez-pochybnost">Un buen escéptico tiene más que la duda y menos que la certeza</a>. Parte del texto de Massimo Pigliucci <a href="https://aeon.co/essays/a-good-sceptic-has-more-than-doubt-and-less-than-certainty"><em>He was probably right</em></a> en Aeon, del 21 de septiembre de 2026. Ese ensayo no es un protocolo de tratamiento.</p>
<p>El mismo principio rige este circuito. El agente prepara el texto. La publicación se comprueba. La regla que me quedo es esta: sigo siendo la persona que firma la afirmación. No es un parte de que haya revisado palabra por palabra cada frase ya publicada. Es el compromiso con el que sale el texto siguiente.</p>
<p>El control que no me salto antes de publicar es concreto. Las páginas principales deben devolver el estado 200, las rutas internas el estado 403, la cabecera Content-Security-Policy debe llevar un nonce y el mapa del sitio debe indicar los enlaces hreflang. La velocidad no es el riesgo. El riesgo es publicar algo que usted no ha comprobado.</p>
<p>Si publica con ayuda de la inteligencia artificial, ¿cuál es el control que usted no se salta antes de publicar?</p>
<p>Escríbame a través del <a href="contact.php">formulario de contacto</a>.</p>
HTML,
        ],
        'pl' => [
            'title' => 'Trzynaście artykułów w dziewięć dni. Podpis zostaje mój.',
            'image_alt' => 'Mężczyzna od tyłu przy ciemnym stole w nocy trzyma świecącą kartkę. Przed nim wachlarzem otwierają się blade fioletowe i turkusowe strony, a nad nimi wisi ptaszek ze światła.',
            'excerpt' => 'Między 17 a 25 września 2026 na tej stronie ukazało się trzynaście artykułów, każdy w dziesięciu językach. To nie jest szybsze pisanie. To jest tok pracy. Agent przygotowuje tekst. Przed wdrożeniem zostaje kontrola, której nie pomijam.',
            'content' => <<<'HTML'
<p>Między 17 a 25 września 2026 opublikowałem na tej stronie trzynaście artykułów. Każdy jest po słowacku, angielsku, czesku, niemiecku, włosku, ukraińsku, francusku, hiszpańsku, polsku i węgiersku. Od pierwszego dnia do ostatniego to dziewięć dni.</p>
<p>To nie jest szybsze pisanie. To jest tok pracy. Agentowi w Cursorze podaję jeden link źródłowy. Przygotowuje szkic, tłumaczy go i pomaga przy publikacji. Wynik jest potem sprawdzany. Tok pracy trzyma też listę tego, co już poszło na X, żeby ten sam tekst nie wyszedł drugi raz.</p>
<p>Z tego ciągu najbardziej stoję przy tekście, który bierze <em>probabilia</em> Cycerona i odnosi je do medycyny oraz do pisania o sztucznej inteligencji. Pogląd ma być dość pewny, by działać, i dość luźny, by go poprawić. To esej <a href="article.php?slug=dobry-skeptik-viac-nez-pochybnost">Dobry sceptyk ma więcej niż wątpliwość i mniej niż pewność</a>. Wychodzi z tekstu Massima Pigliucciego <a href="https://aeon.co/essays/a-good-sceptic-has-more-than-doubt-and-less-than-certainty"><em>He was probably right</em></a> na Aeonie z 21 września 2026. Ten esej nie jest protokołem leczenia.</p>
<p>Ta sama zasada rządzi tym tokiem pracy. Agent przygotowuje tekst. Publikacja jest sprawdzana. Reguła, którą zostawiam sobie, brzmi tak: zostaję człowiekiem, który twierdzenie podpisuje. To nie jest zestawienie, że przeszedłem słowo po słowie każde już opublikowane zdanie. To zobowiązanie, według którego wychodzi następny tekst.</p>
<p>Kontrola, której nie pomijam przed wdrożeniem, jest konkretna. Kluczowe strony mają zwrócić stan 200, ścieżki wewnętrzne stan 403, nagłówek Content-Security-Policy ma nieść nonce, a mapa witryny ma podać odnośniki hreflang. Szybkość nie jest ryzykiem. Ryzykiem jest opublikować coś, czego nie sprawdziłeś.</p>
<p>Jeśli publikujesz z pomocą sztucznej inteligencji, jakiej kontroli nie pomijasz przed wdrożeniem?</p>
<p>Napisz przez <a href="contact.php">kontakt</a>.</p>
HTML,
        ],
        'hu' => [
            'title' => 'Tizenhárom cikk kilenc nap alatt. Az aláírás az enyém marad.',
            'image_alt' => 'Egy férfi hátulról, sötét asztalnál éjjel, világító lapot tart a kezében. Előtte halvány lila és türkiz oldalak legyezője nyílik, fölöttük fényből álló pipa lebeg.',
            'excerpt' => '2026. szeptember 17. és 25. között tizenhárom cikk jelent meg ezen az oldalon, mindegyik tíz nyelven. Ez nem gyorsabb gépelés. Ez egy menet. Az ügynök megírja a szöveget. A közzététel előtt marad egy ellenőrzés, amelyet nem hagyok ki.',
            'content' => <<<'HTML'
<p>2026. szeptember 17. és 25. között tizenhárom cikket tettem közzé ezen az oldalon. Mindegyik megvan szlovákul, angolul, csehül, németül, olaszul, ukránul, franciául, spanyolul, lengyelül és magyarul. Az első naptól az utolsóig ez kilenc nap.</p>
<p>Ez nem gyorsabb gépelés. Ez egy menet. A Cursorban egy ügynöknek egy forráslinket adok. Elkészíti a vázlatot, lefordítja, és segít a közzétételben. Az eredményt utána ellenőrzöm. A menet azt is számon tartja, mi ment már ki az X-re, hogy ugyanaz a szöveg másodszor ne menjen ki.</p>
<p>Ebből a sorból ahhoz a szöveghez állok a leginkább, amely Cicero <em>probabiliáit</em> az orvoslásra és a mesterséges intelligenciáról szóló írásra vonatkoztatja. A nézet legyen elég szilárd a cselekvéshez, és elég laza a javításhoz. Ez az esszé: <a href="article.php?slug=dobry-skeptik-viac-nez-pochybnost">A jó szkeptikusnak többje van a kételynél, és kevesebbje a bizonyosságnál</a>. Massimo Pigliucci <a href="https://aeon.co/essays/a-good-sceptic-has-more-than-doubt-and-less-than-certainty"><em>He was probably right</em></a> című Aeon-szövegéből indul, 2026. szeptember 21-éről. Az az esszé nem kezelési protokoll.</p>
<p>Ugyanez a menete elve. Az ügynök elkészíti a szöveget. A közzétételt ellenőrzöm. A szabály, amelyet magamnál tartok, ez: én maradok az, aki az állítást aláírja. Ez nem kimutatás arról, hogy szóról szóra végigmentem minden már megjelent mondaton. Ez az a kötelezettség, amely szerint a következő szöveg kimehet.</p>
<p>Az ellenőrzés, amelyet a közzététel előtt nem hagyok ki, konkrét. A fontos oldalak 200-as állapotot adjanak, a belső útvonalak 403-at, a Content-Security-Policy fejléc vigyen nonce-t, a webhelytérkép pedig sorolja a hreflang hivatkozásokat. A sebesség nem a kockázat. A kockázat az, ha olyasmit teszel közzé, amit nem ellenőriztél.</p>
<p>Ha mesterséges intelligencia segítségével publikálsz, melyik ellenőrzést nem hagyod ki a közzététel előtt?</p>
<p>Írj a <a href="contact.php">kapcsolati űrlapon</a>.</p>
HTML,
        ],
        'it' => [
            'title' => 'Tredici articoli in nove giorni. La firma resta mia.',
            'image_alt' => 'Un uomo di spalle, a un tavolo scuro di notte, tiene in mano una pagina luminosa. Davanti a lui si apre un ventaglio di pagine viola e turchesi tenui, e sopra resta una spunta fatta di luce.',
            'excerpt' => 'Tra il 17 e il 25 settembre 2026 su questo sito sono usciti tredici articoli, ciascuno in dieci lingue. Non è scrivere più in fretta. È un procedimento. L’agente prepara il testo. Prima della pubblicazione resta un controllo che non salto.',
            'content' => <<<'HTML'
<p>Tra il 17 e il 25 settembre 2026 ho pubblicato tredici articoli su questo sito. Ognuno è in slovacco, inglese, ceco, tedesco, italiano, ucraino, francese, spagnolo, polacco e ungherese. Dal primo giorno all’ultimo sono nove giorni.</p>
<p>Non è scrivere più in fretta. È un procedimento. A un agente in Cursor consegno un solo link di partenza. Prepara una bozza, la traduce e aiuta a pubblicarla. Il risultato viene poi verificato. Il procedimento tiene anche un elenco di ciò che è già uscito su X, così lo stesso testo non esce una seconda volta.</p>
<p>Di questa serie, il testo a cui tengo di più prende i <em>probabilia</em> di Cicerone e li applica alla medicina e alla scrittura sull’intelligenza artificiale. Un’opinione deve essere abbastanza ferma per agire e abbastanza sciolta per essere corretta. È il saggio <a href="article.php?slug=dobry-skeptik-viac-nez-pochybnost">Un buon scettico ha più del dubbio e meno della certezza</a>. Parte dal testo di Massimo Pigliucci <a href="https://aeon.co/essays/a-good-sceptic-has-more-than-doubt-and-less-than-certainty"><em>He was probably right</em></a> su Aeon, del 21 settembre 2026. Quel saggio non è un protocollo di cura.</p>
<p>Lo stesso principio regola questo procedimento. L’agente prepara il testo. La pubblicazione viene verificata. La regola che mi tengo è questa: resto la persona che firma l’affermazione. Non è un rendiconto di aver riletto parola per parola ogni frase già pubblicata. È l’impegno con cui esce il testo successivo.</p>
<p>Il controllo che non salto prima della pubblicazione è concreto. Le pagine principali devono restituire lo stato 200, i percorsi interni lo stato 403, l’intestazione Content-Security-Policy deve portare un nonce e la mappa del sito deve indicare i link hreflang. La velocità non è il rischio. Il rischio è pubblicare qualcosa che non hai verificato.</p>
<p>Se pubblichi con l’aiuto dell’intelligenza artificiale, quale controllo non salti prima della messa online?</p>
<p>Scrivi tramite il <a href="contact.php">modulo di contatto</a>.</p>
HTML,
        ],
        'uk' => [
            'title' => 'Тринадцять статей за дев’ять днів. Підпис лишається мій.',
            'image_alt' => 'Чоловік зі спини біля темного столу вночі тримає світну сторінку. Перед ним віялом розкриваються тьмяні фіолетові й бірюзові аркуші, а над ними висить галочка зі світла.',
            'excerpt' => 'Між 17 і 25 вересня 2026 року на цьому сайті вийшло тринадцять статей, кожна з них десятьма мовами. Це не швидший набір. Це хід роботи. Агент готує текст. Перед розгортанням лишається перевірка, яку я не пропускаю.',
            'content' => <<<'HTML'
<p>Між 17 і 25 вересня 2026 року я опублікував на цьому сайті тринадцять статей. Кожна є словацькою, англійською, чеською, німецькою, італійською, українською, французькою, іспанською, польською та угорською. Від першого дня до останнього це дев’ять днів.</p>
<p>Це не швидший набір тексту. Це хід роботи. Агентові в Cursor я передаю одне вихідне посилання. Він готує чернетку, перекладає її і допомагає з публікацією. Результат потім перевіряється. Хід роботи тримає й список того, що вже пішло в X, щоб той самий текст не вийшов удруге.</p>
<p>Із цього ряду я найбільше стою за текстом, який бере Цицеронові <em>probabilia</em> і відносить їх до медицини та до письма про штучний інтелект. Погляд має бути досить твердим для дії і досить вільним для виправлення. Це есе <a href="article.php?slug=dobry-skeptik-viac-nez-pochybnost">Добрий скептик має більше, ніж сумнів, і менше, ніж певність</a>. Воно виходить із тексту Массімо Пільюччі <a href="https://aeon.co/essays/a-good-sceptic-has-more-than-doubt-and-less-than-certainty"><em>He was probably right</em></a> на Aeon від 21 вересня 2026 року. Те есе не є протоколом лікування.</p>
<p>Той самий принцип тримає цей хід роботи. Агент готує текст. Розгортання перевіряється. Правило, яке я лишаю собі, таке: я лишаюся людиною, яка підписує твердження. Це не звіт про те, що я слово за словом переглянув кожне вже опубліковане речення. Це зобов’язання, за яким виходить наступний текст.</p>
<p>Перевірка, яку я не пропускаю перед розгортанням, конкретна. Ключові сторінки мають повернути стан 200, внутрішні шляхи — стан 403, заголовок Content-Security-Policy має нести nonce, а мапа сайту має навести посилання hreflang. Швидкість не є ризиком. Ризик — оприлюднити те, чого ви не перевірили.</p>
<p>Якщо ви публікуєте з допомогою штучного інтелекту, яку перевірку ви не пропускаєте перед розгортанням?</p>
<p>Напишіть через <a href="contact.php">контакт</a>.</p>
HTML,
        ],
    ],
];
