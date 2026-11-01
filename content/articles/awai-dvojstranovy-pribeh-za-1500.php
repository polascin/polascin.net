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
 * Osobný blogový príspevok: sponzorovaná správa Contest Ledger / NWG.
 * Overené 25. 9. 2026: contestledger.example/about-us (založenie 2001, Jendi Reiter
 * a Adam Cohen, Northampton MA, odhlásenie z newslettera), kontakt na reklamu
 * editor@contestledger.example, nwgwriters.example (od 1997, Cedar Point; vlajkový kurz
 * uvedený za 507 USD, na tej istej stránke veta o vrátení 197 USD),
 * prehľad honorárov NWG: case study 1 200 až 2 000 USD.
 * Názov bezplatného sprievodcu je citát z e-mailu, nie stránka, ktorú som otvoril.
 */
return [
    'slug' => 'awai-dvojstranovy-pribeh-za-1500',
    'author' => 'MUDr. Ľubomír Polaščín',
    'category' => 'blog',
    'is_top' => 0,
    'published_at' => '2026-09-25 17:48:00',
    'image' => 'images/articles/awai-dvojstranovy-pribeh-za-1500.webp',
    'translations' => [
        'sk' => [
            'title' => '1 500 dolárov za dvojstranový príbeh. Nie je to podvod, je to lievik.',
            'image_alt' => 'Nočný písací stôl vo fialovom a tyrkysovom svetle: dve prázdne strany, otvorená obálka a papierový pás, ktorý sa zužuje k vzdialeným dverám.',
            'excerpt' => 'E-mail od Contest Ledger sľubuje v priemere 1 500 dolárov za dvojstranový príbeh. Obe firmy sú reálne. Správa je platená reklama NWG a bezplatný sprievodca je návnada na kurz.',
            'content' => <<<'HTML'
<p>Do schránky <em>lubomir@polascin.net</em> prišiel e-mail s nadpisom, ktorý znie ako ponuka, na ktorú sa nedá povedať nie: v priemere 1 500 dolárov za dvojstranový príbeh. Poslal ho newsletter <a href="https://contestledger.example/about-us">Contest Ledger</a>. Za textom stálo <a href="https://www.nwgwriters.example/">NWG</a>, Northbridge Writers Guild.</p>
<p>Od podvodu s <a href="article.php?slug=ai-book-trailer-ponuka-je-scam">ponukou book trailera</a> sa to líši. Od nevyzretého produktu ako <a href="article.php?slug=atlas-agents-studeny-email-z-icloud">Northgrid Agents z iCloudu</a> tiež. Obe firmy existujú roky. Správa je platená reklama a bezplatný sprievodca je návnada do predajného lievika.</p>
<h2>Kto to posiela</h2>
<p><a href="https://contestledger.example/about-us">Contest Ledger</a> založili v roku 2001 Jendi Reiter a Adam Cohen. Sídlo uvádzajú na 351 Pleasant Street, PMB 222, Northampton v Massachusetts. Vedú databázu literárnych súťaží a rozposielajú bezplatný newsletter. Na stránke o sebe píšu, že z neho možno kedykoľvek odísť. Model je známy: súťaže a prehľady zadarmo, vnútri platené sponzorované správy. Kontakt na reklamu, ktorý zverejňujú, je <em>editor@contestledger.example</em>. V päte listu, ktorý mi prišiel, stálo, že sponzorované správy im pomáhajú poskytovať služby bez poplatku.</p>
<p><a href="https://www.nwgwriters.example/copywriting/learn/opportunity-for-writers">NWG</a> predáva kurzy copywritingu od roku 1997, s adresou v Cedar Point na Floride. Vlajkový produkt je Accelerated Program for Six-Figure Copywriting. Stránku som čítal 25. septembra 2026: uvádza cenu 507 dolárov. Na tej istej stránke ostala veta o vrátení 197 dolárov. To nie je podvod. Je to predajný text, ktorý si nesedí sám so sebou.</p>
<h2>Čo sa skrýva za vetami</h2>
<ul>
<li><strong>„Dvojstranový príbeh.“</strong> Je to prípadová štúdia pre firmu. Kostra je problém, riešenie a výsledok. Verejne je opísaná desiatky rokov. Tajná štruktúra v tom nie je.</li>
<li><strong>„V priemere 1 500 dolárov.“</strong> Ich vlastný <a href="https://www.nwgwriters.example/inside-nwg/blueprint-for-becoming-well-paid-copywriter">prehľad honorárov</a>, ktorý som čítal v ten istý deň, uvádza prípadovú štúdiu v rozpätí 1 200 až 2 000 dolárov. To je horná liga človeka, ktorý už má klientov. Začiatočník z toho vidí zlomok. Číslo v predmete správy je ich marketing, nie audit trhu.</li>
<li><strong>„Tajná štruktúra.“</strong> Predajná fráza. Tú istú kostru nájdete v učebniciach aj v textoch, ktoré NWG samo zverejňuje.</li>
<li><strong>Bezplatný sprievodca „9 Ways to Make a Real Living as a Writer“.</strong> Po zadaní e-mailu začne predajná sekvencia na kurz. Súbor nie je fígel. Má prilákať adresu, aby sa dal predávať kurz.</li>
<li><strong>„Hi, Friend“ a „To your success“.</strong> Celý list je ukážka copywritingu, ktorý predávajú. „Friend“ v takomto predajnom liste neznamená, že vás niekto pozná.</li>
</ul>
<h2>Prečo to prišlo mne</h2>
<p>Adresa <em>lubomir@polascin.net</em> je autorská schránka. Do newslettera Contest Ledger som sa kedysi prihlásil kvôli súťažiam k literárnemu pseudonymu Walter Rye Koelle. To sedí. Cieľová skupina NWG nie.</p>
<p>NWG hovorí k začiatočníkom na americkom trhu priameho predajného textu, po anglicky a pre firmy. Odborné texty píšem pod vlastným menom, literárne pod pseudonymom. Medicínske články pre Zdravotnícke noviny, Lekárske listy a <a href="https://www.solen.sk/sk/casopisy/via-practica">Via practica</a> majú vlastný cenník: 60 eur za normostranu, prevzatý text 40 eur. To je iný trh ako sľub, že sa z dvoch strán stane živobytie.</p>
<h2>Čo s tým</h2>
<ol>
<li><strong>Nechajte to tak, alebo si sprievodcu stiahnite len zo zvedavosti.</strong> Súbor nie je malware. Po ňom príde nával ponúk. Ak ho chcete, dajte im inú adresu, nie tú, na ktorej vediete autorskú poštu.</li>
<li><strong>Ak chodia pravidelne, odhláste sa.</strong> Je to skutočný newsletter. Odhlásenie, ktoré sľubujú na webe, má fungovať. Toto nie je správa, ktorú má zmysel nahlásiť ako spam len preto, že predáva.</li>
<li><strong>Prečítajte si, ako je list napísaný.</strong> Otázka v predmete, kurzíva, „secret“, „free“. Keď budete predávať vlastnú vec, tento predajný list je učebnica zadarmo. Kurz za 507 dolárov by som nekupoval. Verejne dostupný materiál o copywritingu pokrýva väčšinu toho istého.</li>
</ol>
<p>V tejto sérii sú tri rôzne veci. Book trailer je podvod. Northgrid Agents je legálny web bez zrelosti a bez dôvodu dávať mu kľúče. NWG cez Contest Ledger je legitímna reklama. Prvé dve patria do hlásenia spamu. Tretia patrí do odhlásenia, ak vás súťaže už nezaujímajú.</p>

<p><em>Ide o osobnú skúsenosť, nie o právnu ani investičnú radu. Názvy, adresy a ceny sú to, čo 25. septembra 2026 stálo na weboch Contest Ledger a NWG a v e-maile, ktorý mi prišiel. Honorár za normostranu je môj vlastný cenník, nie ponuka pre čitateľa.</em></p>
HTML,
        ],
        'en' => [
            'title' => 'Fifteen hundred dollars for a two-page story. Not a scam. A funnel.',
            'image_alt' => 'A night writing desk in violet and teal light: two blank pages, an open envelope, and a paper ribbon narrowing toward a distant door.',
            'excerpt' => 'An email from Contest Ledger promises $1,500 on average for a two-page story. Both firms are real. The message is a paid NWG ad, and the free guide is bait for a course.',
            'content' => <<<'HTML'
<p>An email landed in <em>lubomir@polascin.net</em> with a subject that sounds like an offer you cannot refuse: $1,500 on average for a two-page story. It came from the <a href="https://contestledger.example/about-us">Contest Ledger</a> newsletter. Behind the copy was <a href="https://www.nwgwriters.example/">NWG</a>, the Northbridge Writers Guild.</p>
<p>It differs from the <a href="article.php?slug=ai-book-trailer-ponuka-je-scam">book-trailer scam</a>. It also differs from an immature product such as <a href="article.php?slug=atlas-agents-studeny-email-z-icloud">Northgrid Agents from iCloud</a>. Both firms have existed for years. The message is a paid advertisement, and the free guide is bait into a sales funnel.</p>
<h2>Who sent it</h2>
<p><a href="https://contestledger.example/about-us">Contest Ledger</a> was founded in 2001 by Jendi Reiter and Adam Cohen. They list their address as 351 Pleasant Street, PMB 222, Northampton, Massachusetts. They keep a database of literary contests and send a free newsletter. On their own about page they say you can leave that newsletter at any time. The model is familiar: contests and roundups at no charge, paid sponsored messages inside. The advertising contact they publish is <em>editor@contestledger.example</em>. The footer of the letter I received said sponsored messages help them provide services at no charge.</p>
<p><a href="https://www.nwgwriters.example/copywriting/learn/opportunity-for-writers">NWG</a> has sold copywriting courses since 1997, from Cedar Point, Florida. The flagship is the Accelerated Program for Six-Figure Copywriting. I read the page on 25 September 2026: it lists a price of $507. The same page still contains a sentence about refunding $197. That is not a scam. It is sales copy that does not agree with itself.</p>
<h2>What the lines hide</h2>
<ul>
<li><strong>“A two-page story.”</strong> That is a case study for a company. The problem-solution-result frame has been public for decades. There is no secret structure.</li>
<li><strong>“$1,500 on average.”</strong> Their own <a href="https://www.nwgwriters.example/inside-nwg/blueprint-for-becoming-well-paid-copywriter">fee overview</a>, which I read the same day, lists a case study at $1,200 to $2,000. That is the upper band of someone who already has clients. A beginner sees a fraction of it. The number in the subject line is their marketing, not a market audit.</li>
<li><strong>“A secret structure.”</strong> A sales phrase. The same frame sits in textbooks and in pieces NWG itself publishes.</li>
<li><strong>The free guide “9 Ways to Make a Real Living as a Writer.”</strong> After you enter an email, a sales sequence for the course begins. The file is not malware. It is there to catch the address so the course can be sold.</li>
<li><strong>“Hi, Friend” and “To your success.”</strong> The whole letter is a sample of the copywriting they sell. “Friend” in direct response does not mean anyone knows you.</li>
</ul>
<h2>Why it reached me</h2>
<p><em>lubomir@polascin.net</em> is my author mailbox. I signed up for the Contest Ledger newsletter years ago because of contests tied to the pen name Walter Rye Koelle. That part fits. NWG’s audience does not.</p>
<p>NWG speaks to beginners on the American direct-response market, in English, for businesses. I publish specialist texts under my own name and literary work under the pen name. Medical articles for Zdravotnícke noviny, Lekárske listy, and <a href="https://www.solen.sk/en/journals/via-practica">Via practica</a> have their own price list: €60 per standard page, €40 for a reprint. That is a different market from the promise that two pages become a living.</p>
<h2>What to do</h2>
<ol>
<li><strong>Leave it, or download the guide only out of curiosity.</strong> The file is not malware. A flood of offers follows it. If you want it, give them another address, not the one that carries your author mail.</li>
<li><strong>If they arrive regularly, unsubscribe.</strong> This is a real newsletter. The unsubscribe they promise on the site should work. This is not a message worth reporting as spam merely because it sells something.</li>
<li><strong>Read how the letter is built.</strong> A question in the subject, italics, “secret,” “free.” When you sell something of your own, this direct-response copy is a free textbook. I would not buy the $507 course. Publicly available material on copywriting covers most of the same ground.</li>
</ol>
<p>This series holds three different things. The book trailer is a scam. Northgrid Agents is a lawful site without maturity, and without a reason to hand over keys. NWG through Contest Ledger is a legitimate ad. The first two belong in a spam report. The third belongs in an unsubscribe, if the contests no longer interest you.</p>

<p><em>This is a personal account, not legal or investment advice. The names, addresses, and prices are what stood on the Contest Ledger and NWG sites, and in the email I received, on 25 September 2026. The fee per standard page is my own price list, not an offer to the reader.</em></p>
HTML,
        ],
        'cs' => [
            'title' => '1 500 dolarů za dvoustránkový příběh. Není to podvod, je to trychtýř.',
            'image_alt' => 'Noční psací stůl ve fialovém a tyrkysovém světle: dvě prázdné strany, otevřená obálka a papírový pás, který se zužuje ke vzdáleným dveřím.',
            'excerpt' => 'E-mail od Contest Ledger slibuje v průměru 1 500 dolarů za dvoustránkový příběh. Obě firmy jsou reálné. Zpráva je placená reklama NWG a bezplatný průvodce je návnada na kurz.',
            'content' => <<<'HTML'
<p>Do schránky <em>lubomir@polascin.net</em> přišel e-mail s předmětem, který zní jako nabídka, na kterou se nedá říct ne: v průměru 1 500 dolarů za dvoustránkový příběh. Poslal ho newsletter <a href="https://contestledger.example/about-us">Contest Ledger</a>. Za textem stálo <a href="https://www.nwgwriters.example/">NWG</a>, Northbridge Writers Guild.</p>
<p>Od podvodu s <a href="article.php?slug=ai-book-trailer-ponuka-je-scam">nabídkou book traileru</a> se to liší. Od nevyzrálého produktu jako <a href="article.php?slug=atlas-agents-studeny-email-z-icloud">Northgrid Agents z iCloudu</a> také. Obě firmy existují roky. Zpráva je placená reklama a bezplatný průvodce je návnada do prodejního trychtýře.</p>
<h2>Kdo to posílá</h2>
<p><a href="https://contestledger.example/about-us">Contest Ledger</a> založili v roce 2001 Jendi Reiter a Adam Cohen. Sídlo uvádějí na 351 Pleasant Street, PMB 222, Northampton v Massachusetts. Vedou databázi literárních soutěží a rozesílají bezplatný newsletter. Na stránce o sobě píšou, že z něj lze kdykoli odejít. Model je známý: soutěže a přehledy zdarma, uvnitř placené sponzorované zprávy. Kontakt na reklamu, který zveřejňují, je <em>editor@contestledger.example</em>. V patě dopisu, který mi přišel, stálo, že sponzorované zprávy jim pomáhají poskytovat služby bez poplatku.</p>
<p><a href="https://www.nwgwriters.example/copywriting/learn/opportunity-for-writers">NWG</a> prodává kurzy copywritingu od roku 1997, s adresou v Cedar Point na Floridě. Vlajkový produkt je Accelerated Program for Six-Figure Copywriting. Stránku jsem četl 25. září 2026: uvádí cenu 507 dolarů. Na téže stránce zůstala věta o vrácení 197 dolarů. To není podvod. Je to prodejní text, který si nesedí sám se sebou.</p>
<h2>Co se skrývá za větami</h2>
<ul>
<li><strong>„Dvoustránkový příběh.“</strong> Je to případová studie pro firmu. Kostra je problém, řešení a výsledek. Veřejně je popsaná desítky let. Tajná struktura v tom není.</li>
<li><strong>„V průměru 1 500 dolarů.“</strong> Jejich vlastní <a href="https://www.nwgwriters.example/inside-nwg/blueprint-for-becoming-well-paid-copywriter">přehled honorářů</a>, který jsem četl týž den, uvádí případovou studii v rozmezí 1 200 až 2 000 dolarů. To je horní liga člověka, který už má klienty. Začátečník z toho vidí zlomek. Číslo v předmětu zprávy je jejich marketing, ne audit trhu.</li>
<li><strong>„Tajná struktura.“</strong> Prodejní fráze. Tutéž kostru najdete v učebnicích i v textech, které NWG samo zveřejňuje.</li>
<li><strong>Bezplatný průvodce „9 Ways to Make a Real Living as a Writer“.</strong> Po zadání e-mailu začne prodejní sekvence na kurz. Soubor není malware. Má přilákat adresu, aby se dal prodávat kurz.</li>
<li><strong>„Hi, Friend“ a „To your success“.</strong> Celý dopis je ukázka copywritingu, který prodávají. „Friend“ v takovém prodejním dopise neznamená, že vás někdo zná.</li>
</ul>
<h2>Proč to přišlo mně</h2>
<p>Adresa <em>lubomir@polascin.net</em> je autorská schránka. Do newsletteru Contest Ledger jsem se kdysi přihlásil kvůli soutěžím k literárnímu pseudonymu Walter Rye Koelle. To sedí. Cílová skupina NWG ne.</p>
<p>NWG mluví k začátečníkům na americkém trhu přímého prodejního textu, anglicky a pro firmy. Odborné texty píšu pod vlastním jménem, literární pod pseudonymem. Medicínské články pro Zdravotnícke noviny, Lekárske listy a <a href="https://www.solen.sk/sk/casopisy/via-practica">Via practica</a> mají vlastní ceník: 60 eur za normostranu, převzatý text 40 eur. To je jiný trh než slib, že se ze dvou stran stane živobytí.</p>
<h2>Co s tím</h2>
<ol>
<li><strong>Nechte to být, nebo si průvodce stáhněte jen ze zvědavosti.</strong> Soubor není malware. Po něm přijde nával nabídek. Chcete-li ho, dejte jim jinou adresu, ne tu, na které vedete autorskou poštu.</li>
<li><strong>Pokud chodí pravidelně, odhlaste se.</strong> Je to skutečný newsletter. Odhlášení, které slibují na webu, má fungovat. Tohle není zpráva, kterou má smysl hlásit jako spam jen proto, že prodává.</li>
<li><strong>Přečtěte si, jak je dopis napsaný.</strong> Otázka v předmětu, kurzíva, „secret“, „free“. Až budete prodávat vlastní věc, tenhle prodejní dopis je učebnice zdarma. Kurz za 507 dolarů bych nekupoval. Veřejně dostupný materiál o copywritingu pokrývá většinu téhož.</li>
</ol>
<p>V této sérii jsou tři různé věci. Book trailer je podvod. Northgrid Agents je legální web bez zralosti a bez důvodu dávat mu klíče. NWG přes Contest Ledger je legitimní reklama. První dvě patří do hlášení spamu. Třetí patří do odhlášení, pokud vás soutěže už nezajímají.</p>

<p><em>Jde o osobní zkušenost, ne o právní ani investiční radu. Názvy, adresy a ceny jsou to, co 25. září 2026 stálo na webech Contest Ledger a NWG a v e-mailu, který mi přišel. Honorář za normostranu je můj vlastní ceník, ne nabídka pro čtenáře.</em></p>
HTML,
        ],
        'de' => [
            'title' => '1 500 Dollar für eine zweiseitige Geschichte. Kein Betrug. Ein Trichter.',
            'image_alt' => 'Ein Nachtschreibtisch in violettem und türkisem Licht: zwei leere Seiten, ein offener Umschlag und ein Papierband, das sich zu einer fernen Tür verengt.',
            'excerpt' => 'Eine E-Mail von Contest Ledger verspricht im Schnitt 1 500 Dollar für eine zweiseitige Geschichte. Beide Firmen sind echt. Die Nachricht ist eine bezahlte NWG-Anzeige, der kostenlose Leitfaden ist Köder für einen Kurs.',
            'content' => <<<'HTML'
<p>In <em>lubomir@polascin.net</em> landete eine E-Mail mit einem Betreff, der klingt wie ein Angebot, zu dem man nicht nein sagt: im Schnitt 1 500 Dollar für eine zweiseitige Geschichte. Sie kam vom Newsletter <a href="https://contestledger.example/about-us">Contest Ledger</a>. Hinter dem Text stand <a href="https://www.nwgwriters.example/">NWG</a>, das Northbridge Writers Guild.</p>
<p>Vom Betrug mit dem <a href="article.php?slug=ai-book-trailer-ponuka-je-scam">Book-Trailer-Angebot</a> unterscheidet es sich. Von einem unreifen Produkt wie <a href="article.php?slug=atlas-agents-studeny-email-z-icloud">Northgrid Agents aus iCloud</a> ebenfalls. Beide Firmen gibt es seit Jahren. Die Nachricht ist eine bezahlte Anzeige, und der kostenlose Leitfaden ist Köder in einen Verkaufstrichter.</p>
<h2>Wer das schickt</h2>
<p><a href="https://contestledger.example/about-us">Contest Ledger</a> wurde 2001 von Jendi Reiter und Adam Cohen gegründet. Als Sitz nennen sie 351 Pleasant Street, PMB 222, Northampton, Massachusetts. Sie führen eine Datenbank literarischer Wettbewerbe und verschicken einen kostenlosen Newsletter. Auf der eigenen Seite schreiben sie, dass man ihn jederzeit verlassen kann. Das Modell ist bekannt: Wettbewerbe und Übersichten gratis, darin bezahlte Sponsored Messages. Der Werbekontakt, den sie veröffentlichen, ist <em>editor@contestledger.example</em>. In der Fußzeile des Briefs, der mich erreichte, stand, dass gesponserte Nachrichten ihnen helfen, Dienste ohne Gebühr anzubieten.</p>
<p><a href="https://www.nwgwriters.example/copywriting/learn/opportunity-for-writers">NWG</a> verkauft Copywriting-Kurse seit 1997, mit Adresse in Cedar Point, Florida. Das Flaggschiff ist das Accelerated Program for Six-Figure Copywriting. Die Seite habe ich am 25. September 2026 gelesen: Sie nennt 507 Dollar. Auf derselben Seite steht noch ein Satz über die Rückerstattung von 197 Dollar. Das ist kein Betrug. Es ist ein Verkaufstext, der nicht mit sich selbst übereinstimmt.</p>
<h2>Was hinter den Sätzen steckt</h2>
<ul>
<li><strong>„Eine zweiseitige Geschichte.“</strong> Das ist eine Fallstudie für ein Unternehmen. Das Gerüst Problem, Lösung, Ergebnis ist seit Jahrzehnten öffentlich beschrieben. Keine geheime Struktur.</li>
<li><strong>„Im Schnitt 1 500 Dollar.“</strong> Ihre eigene <a href="https://www.nwgwriters.example/inside-nwg/blueprint-for-becoming-well-paid-copywriter">Honorarübersicht</a>, die ich am selben Tag gelesen habe, nennt eine Fallstudie mit 1 200 bis 2 000 Dollar. Das ist die obere Liga von jemandem, der schon Kunden hat. Ein Anfänger sieht davon einen Bruchteil. Die Zahl in der Betreffzeile ist ihr Marketing, keine Marktprüfung.</li>
<li><strong>„Geheime Struktur.“</strong> Eine Verkaufsformel. Dasselbe Gerüst steht in Lehrbüchern und in Texten, die NWG selbst veröffentlicht.</li>
<li><strong>Der kostenlose Leitfaden „9 Ways to Make a Real Living as a Writer“.</strong> Nach der E-Mail-Adresse beginnt eine Verkaufsfolge für den Kurs. Die Datei ist keine Schadsoftware. Sie soll die Adresse anlocken, damit der Kurs verkauft werden kann.</li>
<li><strong>„Hi, Friend“ und „To your success“.</strong> Der ganze Brief ist eine Probe des Copywritings, das sie verkaufen. „Friend“ im Direct Response heißt nicht, dass jemand Sie kennt.</li>
</ul>
<h2>Warum das bei mir ankam</h2>
<p><em>lubomir@polascin.net</em> ist mein Autorenpostfach. Den Newsletter von Contest Ledger habe ich einst wegen Wettbewerben zum literarischen Pseudonym Walter Rye Koelle abonniert. Das passt. Die Zielgruppe von NWG nicht.</p>
<p>NWG spricht Anfänger auf dem amerikanischen Direct-Response-Markt an, auf Englisch und für Unternehmen. Fachtexte schreibe ich unter eigenem Namen, literarische unter dem Pseudonym. Medizinische Artikel für Zdravotnícke noviny, Lekárske listy und <a href="https://www.solen.sk/en/journals/via-practica">Via practica</a> haben eine eigene Preisliste: 60 Euro je Normseite, 40 Euro für einen übernommenen Text. Das ist ein anderer Markt als das Versprechen, aus zwei Seiten ein Auskommen zu machen.</p>
<h2>Was tun</h2>
<ol>
<li><strong>Lassen Sie es, oder laden Sie den Leitfaden nur aus Neugier.</strong> Die Datei ist keine Schadsoftware. Danach kommt eine Flut von Angeboten. Wenn Sie sie wollen, geben Sie eine andere Adresse an, nicht die, über die Ihre Autorenpost läuft.</li>
<li><strong>Wenn sie regelmäßig kommen, melden Sie sich ab.</strong> Das ist ein echter Newsletter. Die Abmeldung, die sie auf der Seite versprechen, sollte funktionieren. Diese Nachricht gehört nicht in eine Spam-Meldung, nur weil sie etwas verkauft.</li>
<li><strong>Lesen Sie, wie der Brief gebaut ist.</strong> Eine Frage im Betreff, Kursiv, „secret“, „free“. Wenn Sie etwas Eigenes verkaufen, ist dieser Direct-Response-Text ein kostenloses Lehrbuch. Den Kurs für 507 Dollar würde ich nicht kaufen. Öffentlich zugängliches Material über Copywriting deckt das meiste davon ab.</li>
</ol>
<p>In dieser Reihe stehen drei verschiedene Dinge. Der Book Trailer ist Betrug. Northgrid Agents ist eine rechtmäßige Seite ohne Reife und ohne Grund, ihr Schlüssel zu geben. NWG über Contest Ledger ist eine legitime Anzeige. Die ersten beiden gehören in eine Spam-Meldung. Die dritte gehört in eine Abmeldung, wenn die Wettbewerbe Sie nicht mehr interessieren.</p>

<p><em>Das ist ein persönlicher Bericht, keine Rechts- und keine Anlageberatung. Namen, Adressen und Preise sind das, was am 25. September 2026 auf den Seiten von Contest Ledger und NWG und in der E-Mail stand, die mich erreichte. Das Honorar je Normseite ist meine eigene Preisliste, kein Angebot an die Leserin oder den Leser.</em></p>
HTML,
        ],
        'fr' => [
            'title' => '1 500 dollars pour une histoire de deux pages. Pas une arnaque. Un entonnoir.',
            'image_alt' => 'Un bureau de nuit en lumière violette et turquoise : deux pages vierges, une enveloppe ouverte et un ruban de papier qui se resserre vers une porte lointaine.',
            'excerpt' => 'Un e-mail de Contest Ledger promet 1 500 dollars en moyenne pour une histoire de deux pages. Les deux maisons sont réelles. Le message est une publicité payée d’NWG, et le guide gratuit est un appât vers un cours.',
            'content' => <<<'HTML'
<p>Un e-mail est arrivé dans <em>lubomir@polascin.net</em>, avec un objet qui sonne comme une offre à laquelle on ne dit pas non : 1 500 dollars en moyenne pour une histoire de deux pages. Il venait de la lettre <a href="https://contestledger.example/about-us">Contest Ledger</a>. Derrière le texte, <a href="https://www.nwgwriters.example/">NWG</a>, l’Northbridge Writers Guild.</p>
<p>Cela se distingue de l’arnaque dans <a href="article.php?slug=ai-book-trailer-ponuka-je-scam">l’offre de book trailer</a>. Cela se distingue aussi d’un produit immature comme <a href="article.php?slug=atlas-agents-studeny-email-z-icloud">Northgrid Agents depuis iCloud</a>. Les deux maisons existent depuis des années. Le message est une publicité payée, et le guide gratuit est un appât dans un entonnoir de vente.</p>
<h2>Qui l’envoie</h2>
<p><a href="https://contestledger.example/about-us">Contest Ledger</a> a été fondé en 2001 par Jendi Reiter et Adam Cohen. Ils indiquent leur adresse au 351 Pleasant Street, PMB 222, Northampton, Massachusetts. Ils tiennent une base de concours littéraires et envoient une lettre gratuite. Sur leur page, ils écrivent qu’on peut la quitter à tout moment. Le modèle est connu : concours et sélections sans frais, messages sponsorisés payants à l’intérieur. Le contact publicitaire qu’ils publient est <em>editor@contestledger.example</em>. Le pied du courrier que j’ai reçu disait que les messages sponsorisés les aident à fournir des services sans frais.</p>
<p><a href="https://www.nwgwriters.example/copywriting/learn/opportunity-for-writers">NWG</a> vend des cours de copywriting depuis 1997, depuis Cedar Point, en Floride. Le produit phare est l’Accelerated Program for Six-Figure Copywriting. J’ai lu la page le 25 septembre 2026 : elle affiche 507 dollars. La même page contient encore une phrase sur le remboursement de 197 dollars. Ce n’est pas une arnaque. C’est un texte de vente qui ne s’accorde pas avec lui-même.</p>
<h2>Ce que cachent les phrases</h2>
<ul>
<li><strong>« Une histoire de deux pages. »</strong> C’est une étude de cas pour une entreprise. L’ossature problème, solution, résultat est décrite publiquement depuis des décennies. Pas de structure secrète.</li>
<li><strong>« 1 500 dollars en moyenne. »</strong> Leur propre <a href="https://www.nwgwriters.example/inside-nwg/blueprint-for-becoming-well-paid-copywriter">barème</a>, lu le même jour, place une étude de cas entre 1 200 et 2 000 dollars. C’est le haut de la fourchette de quelqu’un qui a déjà des clients. Un débutant en voit une fraction. Le chiffre dans l’objet est leur marketing, pas un audit du marché.</li>
<li><strong>« Structure secrète. »</strong> Une formule de vente. La même ossature est dans les manuels et dans les textes qu’NWG publie lui-même.</li>
<li><strong>Le guide gratuit « 9 Ways to Make a Real Living as a Writer ».</strong> Après l’e-mail, une séquence de vente pour le cours commence. Le fichier n’est pas un logiciel malveillant. Il sert à recueillir l’adresse pour vendre le cours.</li>
<li><strong>« Hi, Friend » et « To your success ».</strong> Toute la lettre est un échantillon du copywriting qu’ils vendent. « Friend », en réponse directe, ne veut pas dire que quelqu’un vous connaît.</li>
</ul>
<h2>Pourquoi cela m’est arrivé</h2>
<p><em>lubomir@polascin.net</em> est ma boîte d’auteur. Je me suis inscrit autrefois à la lettre de Contest Ledger pour des concours liés au pseudonyme littéraire Walter Rye Koelle. Cela tient. Le public d’NWG, non.</p>
<p>NWG s’adresse à des débutants sur le marché américain de la réponse directe, en anglais, pour des entreprises. J’écris les textes spécialisés sous mon nom, et l’œuvre littéraire sous le pseudonyme. Les articles médicaux pour Zdravotnícke noviny, Lekárske listy et <a href="https://www.solen.sk/en/journals/via-practica">Via practica</a> ont leur propre tarif : 60 euros la page normalisée, 40 euros pour une reprise. C’est un autre marché que la promesse de vivre de deux pages.</p>
<h2>Quoi faire</h2>
<ol>
<li><strong>Laissez-le, ou téléchargez le guide seulement par curiosité.</strong> Le fichier n’est pas un logiciel malveillant. Une vague d’offres suit. Si vous le voulez, donnez une autre adresse, pas celle qui porte votre courrier d’auteur.</li>
<li><strong>S’ils arrivent souvent, désabonnez-vous.</strong> C’est une vraie lettre d’information. Le désabonnement promis sur le site doit fonctionner. Ce message ne mérite pas un signalement comme spam seulement parce qu’il vend quelque chose.</li>
<li><strong>Lisez comment la lettre est construite.</strong> Une question dans l’objet, de l’italique, « secret », « free ». Quand vous vendrez quelque chose à vous, ce texte de réponse directe est un manuel gratuit. Je n’achèterais pas le cours à 507 dollars. Le matériau public sur le copywriting couvre l’essentiel de la même matière.</li>
</ol>
<p>Cette série tient trois choses différentes. Le book trailer est une arnaque. Northgrid Agents est un site licite, sans maturité, et sans raison de lui confier des clés. NWG via Contest Ledger est une publicité légitime. Les deux premiers vont dans un signalement de spam. Le troisième va dans un désabonnement, si les concours ne vous intéressent plus.</p>

<p><em>Il s’agit d’un récit personnel, pas d’un conseil juridique ni d’un conseil en investissement. Les noms, les adresses et les prix sont ce qui figurait sur les sites de Contest Ledger et d’NWG, et dans l’e-mail reçu, le 25 septembre 2026. Le tarif à la page normalisée est mon propre barème, pas une offre au lecteur.</em></p>
HTML,
        ],
        'es' => [
            'title' => '1 500 dólares por una historia de dos páginas. No es una estafa. Es un embudo.',
            'image_alt' => 'Un escritorio de noche con luz violeta y turquesa: dos páginas en blanco, un sobre abierto y una cinta de papel que se estrecha hacia una puerta lejana.',
            'excerpt' => 'Un correo de Contest Ledger promete 1 500 dólares de media por una historia de dos páginas. Las dos casas son reales. El mensaje es un anuncio de pago de NWG y la guía gratuita es cebo para un curso.',
            'content' => <<<'HTML'
<p>Llegó un correo a <em>lubomir@polascin.net</em> con un asunto que suena a oferta que no se puede rechazar: 1 500 dólares de media por una historia de dos páginas. Lo envió el boletín de <a href="https://contestledger.example/about-us">Contest Ledger</a>. Detrás del texto estaba <a href="https://www.nwgwriters.example/">NWG</a>, el Northbridge Writers Guild.</p>
<p>Se distingue de la estafa en la <a href="article.php?slug=ai-book-trailer-ponuka-je-scam">oferta de book trailer</a>. También se distingue de un producto inmaduro como <a href="article.php?slug=atlas-agents-studeny-email-z-icloud">Northgrid Agents desde iCloud</a>. Las dos casas existen desde hace años. El mensaje es un anuncio de pago, y la guía gratuita es cebo de un embudo de venta.</p>
<h2>Quién lo envía</h2>
<p><a href="https://contestledger.example/about-us">Contest Ledger</a> lo fundaron en 2001 Jendi Reiter y Adam Cohen. Dan como sede 351 Pleasant Street, PMB 222, Northampton, Massachusetts. Mantienen una base de concursos literarios y envían un boletín gratuito. En su propia página dicen que se puede abandonar en cualquier momento. El modelo es conocido: concursos y reseñas sin coste, y dentro mensajes patrocinados de pago. El contacto de publicidad que publican es <em>editor@contestledger.example</em>. El pie de la carta que me llegó decía que los mensajes patrocinados les ayudan a prestar servicios sin cargo.</p>
<p><a href="https://www.nwgwriters.example/copywriting/learn/opportunity-for-writers">NWG</a> vende cursos de copywriting desde 1997, con dirección en Cedar Point, Florida. El producto principal es el Accelerated Program for Six-Figure Copywriting. Leí la página el 25 de septiembre de 2026: indica un precio de 507 dólares. En la misma página queda una frase sobre devolver 197 dólares. Eso no es una estafa. Es un texto de venta que no concuerda consigo mismo.</p>
<h2>Qué esconden las frases</h2>
<ul>
<li><strong>«Una historia de dos páginas.»</strong> Es un caso de estudio para una empresa. El armazón problema, solución, resultado está descrito en público desde hace décadas. No hay estructura secreta.</li>
<li><strong>«1 500 dólares de media.»</strong> Su propio <a href="https://www.nwgwriters.example/inside-nwg/blueprint-for-becoming-well-paid-copywriter">cuadro de honorarios</a>, leído el mismo día, sitúa un caso de estudio entre 1 200 y 2 000 dólares. Es la banda alta de quien ya tiene clientes. Quien empieza ve una fracción. La cifra del asunto es su marketing, no una auditoría del mercado.</li>
<li><strong>«Estructura secreta.»</strong> Una frase de venta. El mismo armazón está en los manuales y en textos que la propia NWG publica.</li>
<li><strong>La guía gratuita «9 Ways to Make a Real Living as a Writer».</strong> Tras dejar el correo empieza una secuencia de venta del curso. El archivo no es malware. Sirve para conseguir la dirección y vender el curso.</li>
<li><strong>«Hi, Friend» y «To your success».</strong> Toda la carta es una muestra del copywriting que venden. «Friend», en respuesta directa, no significa que alguien le conozca.</li>
</ul>
<h2>Por qué me llegó</h2>
<p><em>lubomir@polascin.net</em> es mi buzón de autor. Me suscribí hace tiempo al boletín de Contest Ledger por concursos ligados al seudónimo literario Walter Rye Koelle. Eso encaja. El público de NWG, no.</p>
<p>NWG habla a principiantes del mercado estadounidense de respuesta directa, en inglés y para empresas. Los textos especializados los firmo con mi nombre, y la obra literaria con el seudónimo. Los artículos médicos para Zdravotnícke noviny, Lekárske listy y <a href="https://www.solen.sk/en/journals/via-practica">Via practica</a> tienen su propia tarifa: 60 euros por página normalizada, 40 euros si el texto ya se publicó. Es otro mercado, distinto de la promesa de vivir de dos páginas.</p>
<h2>Qué hacer</h2>
<ol>
<li><strong>Déjelo, o descargue la guía solo por curiosidad.</strong> El archivo no es malware. Después llega una oleada de ofertas. Si la quiere, dé otra dirección, no la que lleva su correo de autor.</li>
<li><strong>Si llegan con regularidad, cancele la suscripción.</strong> Es un boletín real. La baja que prometen en la web debería funcionar. Este mensaje no merece un aviso de spam solo porque vende algo.</li>
<li><strong>Lea cómo está escrita la carta.</strong> Una pregunta en el asunto, cursiva, «secret», «free». Cuando venda algo propio, este texto de respuesta directa es un manual gratuito. Yo no compraría el curso de 507 dólares. El material público sobre copywriting cubre la mayor parte de lo mismo.</li>
</ol>
<p>En esta serie hay tres cosas distintas. El book trailer es una estafa. Northgrid Agents es un sitio lícito, sin madurez y sin motivo para entregarle claves. NWG a través de Contest Ledger es un anuncio legítimo. Los dos primeros van a un aviso de spam. El tercero va a una baja, si los concursos ya no le interesan.</p>

<p><em>Es un relato personal, no un consejo jurídico ni de inversión. Los nombres, las direcciones y los precios son lo que figuraba en las webs de Contest Ledger y NWG, y en el correo que recibí, el 25 de septiembre de 2026. La tarifa por página normalizada es mi propia lista, no una oferta al lector.</em></p>
HTML,
        ],
        'pl' => [
            'title' => '1 500 dolarów za dwustronicową historię. To nie oszustwo. To lejek.',
            'image_alt' => 'Nocne biurko w fioletowym i turkusowym świetle: dwie puste strony, otwarta koperta i wstęga papieru, która zwęża się ku dalekim drzwiom.',
            'excerpt' => 'E-mail od Contest Ledger obiecuje średnio 1 500 dolarów za dwustronicową historię. Obie firmy są prawdziwe. Wiadomość to płatna reklama NWG, a darmowy przewodnik jest przynętą na kurs.',
            'content' => <<<'HTML'
<p>Do skrzynki <em>lubomir@polascin.net</em> przyszedł e-mail z tematem, który brzmi jak oferta nie do odrzucenia: średnio 1 500 dolarów za dwustronicową historię. Wysłał go newsletter <a href="https://contestledger.example/about-us">Contest Ledger</a>. Za tekstem stało <a href="https://www.nwgwriters.example/">NWG</a>, Northbridge Writers Guild.</p>
<p>Od oszustwa w <a href="article.php?slug=ai-book-trailer-ponuka-je-scam">ofercie book trailera</a> to się różni. Od niedojrzałego produktu, jak <a href="article.php?slug=atlas-agents-studeny-email-z-icloud">Northgrid Agents z iCloud</a>, też. Obie firmy istnieją od lat. Wiadomość jest płatną reklamą, a darmowy przewodnik przynętą do lejka sprzedażowego.</p>
<h2>Kto to wysyła</h2>
<p><a href="https://contestledger.example/about-us">Contest Ledger</a> założyli w 2001 roku Jendi Reiter i Adam Cohen. Siedzibę podają jako 351 Pleasant Street, PMB 222, Northampton w Massachusetts. Prowadzą bazę konkursów literackich i rozsyłają darmowy newsletter. Na własnej stronie piszą, że można z niego w każdej chwili zrezygnować. Model jest znany: konkursy i przeglądy za darmo, w środku płatne wiadomości sponsorowane. Kontakt do reklamy, który publikują, to <em>editor@contestledger.example</em>. W stopce listu, który do mnie przyszedł, było napisane, że wiadomości sponsorowane pomagają im świadczyć usługi bez opłaty.</p>
<p><a href="https://www.nwgwriters.example/copywriting/learn/opportunity-for-writers">NWG</a> sprzedaje kursy copywritingu od 1997 roku, z adresem w Cedar Point na Florydzie. Sztandarowy produkt to Accelerated Program for Six-Figure Copywriting. Stronę czytałem 25 września 2026: podaje cenę 507 dolarów. Na tej samej stronie zostało zdanie o zwrocie 197 dolarów. To nie jest oszustwo. To tekst sprzedażowy, który nie zgadza się sam ze sobą.</p>
<h2>Co kryje się za zdaniami</h2>
<ul>
<li><strong>„Dwustronicowa historia.”</strong> To studium przypadku dla firmy. Szkielet problem, rozwiązanie, wynik jest publicznie opisany od dziesięcioleci. Żadnej tajnej struktury.</li>
<li><strong>„Średnio 1 500 dolarów.”</strong> Ich własny <a href="https://www.nwgwriters.example/inside-nwg/blueprint-for-becoming-well-paid-copywriter">przegląd stawek</a>, który czytałem tego samego dnia, podaje studium przypadku w przedziale od 1 200 do 2 000 dolarów. To górna liga kogoś, kto już ma klientów. Początkujący widzi z tego ułamek. Liczba w temacie to ich marketing, nie audyt rynku.</li>
<li><strong>„Tajna struktura.”</strong> Formuła sprzedażowa. Ten sam szkielet jest w podręcznikach i w tekstach, które samo NWG publikuje.</li>
<li><strong>Darmowy przewodnik „9 Ways to Make a Real Living as a Writer”.</strong> Po podaniu e-maila zaczyna się sekwencja sprzedażowa kursu. Plik nie jest złośliwym oprogramowaniem. Ma złapać adres, żeby dało się sprzedać kurs.</li>
<li><strong>„Hi, Friend” i „To your success”.</strong> Cały list jest próbką copywritingu, który sprzedają. „Friend” w direct response nie znaczy, że ktoś cię zna.</li>
</ul>
<h2>Dlaczego przyszło do mnie</h2>
<p><em>lubomir@polascin.net</em> to moja autorska skrzynka. Do newslettera Contest Ledger zapisałem się kiedyś ze względu na konkursy przy pseudonimie literackim Walter Rye Koelle. To się zgadza. Grupa docelowa NWG nie.</p>
<p>NWG mówi do początkujących na amerykańskim rynku direct response, po angielsku i dla firm. Teksty specjalistyczne piszę pod własnym nazwiskiem, literackie pod pseudonimem. Artykuły medyczne dla Zdravotnícke noviny, Lekárske listy i <a href="https://www.solen.sk/en/journals/via-practica">Via practica</a> mają własny cennik: 60 euro za normostronę, 40 euro za tekst już opublikowany. To inny rynek niż obietnica, że z dwóch stron da się żyć.</p>
<h2>Co z tym zrobić</h2>
<ol>
<li><strong>Zostaw to albo pobierz przewodnik tylko z ciekawości.</strong> Plik nie jest złośliwym oprogramowaniem. Potem przychodzi fala ofert. Jeśli go chcesz, podaj inny adres, nie ten, na którym prowadzisz pocztę autorską.</li>
<li><strong>Jeśli przychodzą regularnie, wypisz się.</strong> To prawdziwy newsletter. Wypisanie, które obiecują na stronie, powinno działać. Tej wiadomości nie warto zgłaszać jako spamu tylko dlatego, że coś sprzedaje.</li>
<li><strong>Przeczytaj, jak list jest zbudowany.</strong> Pytanie w temacie, kursywa, „secret”, „free”. Kiedy będziesz sprzedawać coś własnego, ten tekst direct response jest darmowym podręcznikiem. Kursu za 507 dolarów bym nie kupił. Publicznie dostępny materiał o copywritingu pokrywa większość tego samego.</li>
</ol>
<p>W tej serii są trzy różne rzeczy. Book trailer to oszustwo. Northgrid Agents to legalna strona bez dojrzałości i bez powodu, by oddawać jej klucze. NWG przez Contest Ledger to legalna reklama. Dwie pierwsze należą do zgłoszenia spamu. Trzecia należy do wypisania, jeśli konkursy już cię nie obchodzą.</p>

<p><em>To osobiste doświadczenie, nie porada prawna ani inwestycyjna. Nazwy, adresy i ceny są tym, co 25 września 2026 stało na stronach Contest Ledger i NWG oraz w e-mailu, który do mnie przyszedł. Stawka za normostronę to mój własny cennik, nie oferta dla czytelnika.</em></p>
HTML,
        ],
        'hu' => [
            'title' => '1 500 dollár egy kétoldalas történetért. Nem átverés. Értékesítési tölcsér.',
            'image_alt' => 'Éjszakai íróasztal lila és türkiz fényben: két üres lap, nyitott boríték és egy papírszalag, amely távoli ajtó felé szűkül.',
            'excerpt' => 'A Contest Ledger e-mailje átlagosan 1 500 dollárt ígér egy kétoldalas történetért. Mindkét cég valódi. Az üzenet fizetett NWG-hirdetés, az ingyenes útmutató pedig csali egy tanfolyamhoz.',
            'content' => <<<'HTML'
<p>A <em>lubomir@polascin.net</em> fiókba olyan tárggyal érkezett levél, amely úgy hangzik, mint egy visszautasíthatatlan ajánlat: átlagosan 1 500 dollár egy kétoldalas történetért. A <a href="https://contestledger.example/about-us">Contest Ledger</a> hírlevele küldte. A szöveg mögött az <a href="https://www.nwgwriters.example/">NWG</a>, az Northbridge Writers Guild állt.</p>
<p>A <a href="article.php?slug=ai-book-trailer-ponuka-je-scam">book trailer ajánlat</a> csalásától ez különbözik. Az éretlen terméktől, mint az <a href="article.php?slug=atlas-agents-studeny-email-z-icloud">iCloudos Northgrid Agents</a>, szintén. Mindkét cég évek óta létezik. Az üzenet fizetett hirdetés, az ingyenes útmutató pedig csali az értékesítési tölcsérbe.</p>
<h2>Ki küldi</h2>
<p>A <a href="https://contestledger.example/about-us">Contest Ledgert</a> 2001-ben alapította Jendi Reiter és Adam Cohen. Székhelyükként a 351 Pleasant Street, PMB 222, Northampton, Massachusetts címet adják meg. Irodalmi pályázatok adatbázisát vezetik, és ingyenes hírlevelet küldenek. A saját oldalukon azt írják, hogy bármikor le lehet iratkozni. A modell ismert: pályázatok és szemlék ingyen, belül fizetett szponzorált üzenetek. A hirdetési kapcsolat, amelyet közzétesznek: <em>editor@contestledger.example</em>. A levél láblécében, amely hozzám érkezett, az állt, hogy a szponzorált üzenetek segítenek nekik díj nélkül szolgáltatni.</p>
<p>Az <a href="https://www.nwgwriters.example/copywriting/learn/opportunity-for-writers">NWG</a> 1997 óta árul szövegíró tanfolyamokat, Cedar Point-i címmel, Floridában. A zászlóshajó az Accelerated Program for Six-Figure Copywriting. Az oldalt 2026. szeptember 25-én olvastam: 507 dolláros árat ír. Ugyanazon az oldalon megmaradt egy mondat 197 dollár visszatérítéséről. Ez nem átverés. Ez olyan értékesítési szöveg, amely nem egyezik önmagával.</p>
<h2>Mi rejtőzik a mondatok mögött</h2>
<ul>
<li><strong>„Kétoldalas történet.”</strong> Ez esettanulmány egy cégnek. A probléma, megoldás, eredmény váza évtizedek óta nyilvános. Nincs titkos szerkezet.</li>
<li><strong>„Átlagosan 1 500 dollár.”</strong> A saját <a href="https://www.nwgwriters.example/inside-nwg/blueprint-for-becoming-well-paid-copywriter">díjszabásuk</a>, amelyet ugyanaznap olvastam, az esettanulmányt 1 200 és 2 000 dollár közé teszi. Ez annak a felső sávja, akinek már vannak ügyfelei. A kezdő ennek a töredékét látja. A tárgysorban lévő szám az ő marketingjük, nem piaci vizsgálat.</li>
<li><strong>„Titkos szerkezet.”</strong> Értékesítési fordulat. Ugyanez a váz tankönyvekben és az NWG saját szövegeiben is ott van.</li>
<li><strong>Az ingyenes útmutató: „9 Ways to Make a Real Living as a Writer”.</strong> Az e-mail megadása után elindul a tanfolyam értékesítési sorozata. A fájl nem kártékony program. Az a dolga, hogy begyűjtse a címet, és el lehessen adni a tanfolyamot.</li>
<li><strong>„Hi, Friend” és „To your success”.</strong> Az egész levél minta abból a szövegírásból, amelyet árulnak. A „Friend” a direct response-ban nem azt jelenti, hogy valaki ismeri önt.</li>
</ul>
<h2>Miért érkezett hozzám</h2>
<p>A <em>lubomir@polascin.net</em> a szerzői postafiókom. A Contest Ledger hírlevelére egykor a Walter Rye Koelle irodalmi álnévhez kötött pályázatok miatt iratkoztam fel. Ez stimmel. Az NWG célcsoportja nem.</p>
<p>Az NWG az amerikai direct-response piac kezdőinek beszél, angolul, cégeknek. A szakmai szövegeket a saját nevemen írom, az irodalmat álnéven. Az orvosi cikkek a Zdravotnícke noviny, a Lekárske listy és a <a href="https://www.solen.sk/en/journals/via-practica">Via practica</a> számára saját díjszabással mennek: 60 euró normáloldalanként, 40 euró az átvett szövegért. Ez más piac, mint az ígéret, hogy két oldalból megélés lesz.</p>
<h2>Mit érdemes tenni</h2>
<ol>
<li><strong>Hagyja, vagy csak kíváncsiságból töltse le az útmutatót.</strong> A fájl nem kártékony program. Utána ajánlatok özöne jön. Ha kell, adjon meg másik címet, ne azt, amelyen a szerzői posta megy.</li>
<li><strong>Ha rendszeresen jönnek, iratkozzon le.</strong> Ez valódi hírlevél. A leiratkozásnak, amelyet az oldalon ígérnek, működnie kell. Ezt az üzenetet nem érdemes spamként jelenteni csak azért, mert elad valamit.</li>
<li><strong>Olvassa el, hogyan van megírva a levél.</strong> Kérdés a tárgyban, dőlt betű, „secret”, „free”. Ha saját dolgot ad el, ez a direct-response szöveg ingyenes tankönyv. Az 507 dolláros tanfolyamot nem venném meg. A szövegírásról nyilvánosan elérhető anyag a java részét lefedi.</li>
</ol>
<p>Ebben a sorozatban három különböző dolog van. A book trailer átverés. Az Northgrid Agents jogszerű oldal, érettség nélkül, és ok nélkül adni neki kulcsokat. Az NWG a Contest Ledgern keresztül törvényes hirdetés. Az első kettő spambejelentésbe való. A harmadik leiratkozásba, ha a pályázatok már nem érdeklik.</p>

<p><em>Személyes beszámoló, nem jogi és nem befektetési tanács. A nevek, címek és árak azok, amelyek 2026. szeptember 25-én a Contest Ledger és az NWG oldalain, valamint a kapott e-mailben álltak. A normáloldal díja a saját díjszabásom, nem ajánlat az olvasónak.</em></p>
HTML,
        ],
        'it' => [
            'title' => '1 500 dollari per una storia di due pagine. Non è una truffa. È un imbuto.',
            'image_alt' => 'Una scrivania notturna in luce viola e turchese: due pagine bianche, una busta aperta e un nastro di carta che si stringe verso una porta lontana.',
            'excerpt' => 'Un’e-mail di Contest Ledger promette in media 1 500 dollari per una storia di due pagine. Entrambe le case sono reali. Il messaggio è una pubblicità a pagamento di NWG e la guida gratuita è un’esca per un corso.',
            'content' => <<<'HTML'
<p>Nella casella <em>lubomir@polascin.net</em> è arrivata un’e-mail con un oggetto che suona come un’offerta a cui non si dice di no: in media 1 500 dollari per una storia di due pagine. L’ha mandata la newsletter di <a href="https://contestledger.example/about-us">Contest Ledger</a>. Dietro il testo c’era <a href="https://www.nwgwriters.example/">NWG</a>, l’Northbridge Writers Guild.</p>
<p>Si distingue dalla truffa nell’<a href="article.php?slug=ai-book-trailer-ponuka-je-scam">offerta di book trailer</a>. Si distingue anche da un prodotto immaturo come <a href="article.php?slug=atlas-agents-studeny-email-z-icloud">Northgrid Agents da iCloud</a>. Entrambe le case esistono da anni. Il messaggio è una pubblicità a pagamento, e la guida gratuita è un’esca in un imbuto di vendita.</p>
<h2>Chi lo manda</h2>
<p><a href="https://contestledger.example/about-us">Contest Ledger</a> è stata fondata nel 2001 da Jendi Reiter e Adam Cohen. Come sede indicano 351 Pleasant Street, PMB 222, Northampton, Massachusetts. Tengono un database di concorsi letterari e inviano una newsletter gratuita. Nella pagina su di sé scrivono che ci si può cancellare in qualsiasi momento. Il modello è noto: concorsi e rassegne gratis, dentro messaggi sponsorizzati a pagamento. Il contatto pubblicitario che pubblicano è <em>editor@contestledger.example</em>. Nel piè di pagina della lettera che mi è arrivata c’era scritto che i messaggi sponsorizzati li aiutano a offrire servizi senza costo.</p>
<p><a href="https://www.nwgwriters.example/copywriting/learn/opportunity-for-writers">NWG</a> vende corsi di copywriting dal 1997, con indirizzo a Cedar Point, in Florida. Il prodotto di punta è l’Accelerated Program for Six-Figure Copywriting. Ho letto la pagina il 25 settembre 2026: indica un prezzo di 507 dollari. Nella stessa pagina resta una frase sul rimborso di 197 dollari. Non è una truffa. È un testo di vendita che non concorda con se stesso.</p>
<h2>Cosa nascondono le frasi</h2>
<ul>
<li><strong>«Una storia di due pagine.»</strong> È un caso di studio per un’azienda. L’ossatura problema, soluzione, risultato è descritta in pubblico da decenni. Nessuna struttura segreta.</li>
<li><strong>«In media 1 500 dollari.»</strong> Il loro <a href="https://www.nwgwriters.example/inside-nwg/blueprint-for-becoming-well-paid-copywriter">prospetto dei compensi</a>, letto lo stesso giorno, colloca un case study tra 1 200 e 2 000 dollari. È la fascia alta di chi ha già clienti. Un principiante ne vede una frazione. Il numero nell’oggetto è il loro marketing, non un audit del mercato.</li>
<li><strong>«Struttura segreta.»</strong> Una formula di vendita. La stessa ossatura sta nei manuali e nei testi che NWG stessa pubblica.</li>
<li><strong>La guida gratuita «9 Ways to Make a Real Living as a Writer».</strong> Dopo l’e-mail parte una sequenza di vendita del corso. Il file non è malware. Serve a raccogliere l’indirizzo per vendere il corso.</li>
<li><strong>«Hi, Friend» e «To your success».</strong> Tutta la lettera è un saggio del copywriting che vendono. «Friend», nella direct response, non significa che qualcuno vi conosca.</li>
</ul>
<h2>Perché è arrivata a me</h2>
<p><em>lubomir@polascin.net</em> è la mia casella d’autore. Alla newsletter di Contest Ledger mi iscrissi un tempo per concorsi legati allo pseudonimo letterario Walter Rye Koelle. Questo torna. Il pubblico di NWG no.</p>
<p>NWG parla a principianti del mercato americano della direct response, in inglese e per le aziende. I testi specialistici li firmo col mio nome, l’opera letteraria con lo pseudonimo. Gli articoli medici per Zdravotnícke noviny, Lekárske listy e <a href="https://www.solen.sk/en/journals/via-practica">Via practica</a> hanno un listino proprio: 60 euro a cartella, 40 euro per un testo già pubblicato. È un altro mercato rispetto alla promessa di vivere di due pagine.</p>
<h2>Cosa fare</h2>
<ol>
<li><strong>Lasciatela stare, oppure scaricate la guida solo per curiosità.</strong> Il file non è malware. Dopo arriva un’ondata di offerte. Se la volete, date un altro indirizzo, non quello su cui passa la posta d’autore.</li>
<li><strong>Se arrivano spesso, cancellate l’iscrizione.</strong> È una newsletter vera. La cancellazione che promettono sul sito dovrebbe funzionare. Questo messaggio non merita una segnalazione come spam solo perché vende qualcosa.</li>
<li><strong>Leggete come è costruita la lettera.</strong> Una domanda nell’oggetto, il corsivo, «secret», «free». Quando venderete qualcosa di vostro, questo testo di direct response è un manuale gratuito. Il corso da 507 dollari non lo comprerei. Il materiale pubblico sul copywriting copre gran parte della stessa materia.</li>
</ol>
<p>In questa serie ci sono tre cose diverse. Il book trailer è una truffa. Northgrid Agents è un sito lecito, senza maturità e senza motivo per consegnargli le chiavi. NWG attraverso Contest Ledger è una pubblicità legittima. I primi due vanno in una segnalazione di spam. Il terzo va in una cancellazione, se i concorsi non vi interessano più.</p>

<p><em>È un resoconto personale, non un consiglio legale né di investimento. Nomi, indirizzi e prezzi sono ciò che il 25 settembre 2026 stava sui siti di Contest Ledger e NWG e nell’e-mail che ho ricevuto. Il compenso a cartella è il mio listino, non un’offerta al lettore.</em></p>
HTML,
        ],
        'uk' => [
            'title' => '1 500 доларів за двосторінкову історію. Це не шахрайство. Це воронка.',
            'image_alt' => 'Нічний письмовий стіл у фіолетовому й бірюзовому світлі: дві чисті сторінки, відкритий конверт і паперова стрічка, що звужується до далеких дверей.',
            'excerpt' => 'Лист від Contest Ledger обіцяє в середньому 1 500 доларів за двосторінкову історію. Обидві фірми справжні. Повідомлення є платною рекламою NWG, а безкоштовний посібник є принадою на курс.',
            'content' => <<<'HTML'
<p>На <em>lubomir@polascin.net</em> прийшов лист із темою, яка звучить як пропозиція, від якої не відмовляються: у середньому 1 500 доларів за двосторінкову історію. Його надіслала розсилка <a href="https://contestledger.example/about-us">Contest Ledger</a>. За текстом стояв <a href="https://www.nwgwriters.example/">NWG</a>, Northbridge Writers Guild.</p>
<p>Це не шахрайство в тому сенсі, що й <a href="article.php?slug=ai-book-trailer-ponuka-je-scam">пропозиція book trailer</a>. Це й не незрілий продукт, як <a href="article.php?slug=atlas-agents-studeny-email-z-icloud">Northgrid Agents з iCloud</a>. Обидві фірми існують роками. Повідомлення є платною рекламою, а безкоштовний посібник є принадою у воронку продажу.</p>
<h2>Хто це надсилає</h2>
<p><a href="https://contestledger.example/about-us">Contest Ledger</a> заснували 2001 року Дженді Райтер і Адам Коен. Адресу вони вказують як 351 Pleasant Street, PMB 222, Нортгемптон, Массачусетс. Вони ведуть базу літературних конкурсів і надсилають безкоштовну розсилку. На власній сторінці пишуть, що з неї можна вийти будь-коли. Модель відома: конкурси й огляди безкоштовно, всередині платні спонсорські повідомлення. Контакт для реклами, який вони публікують: <em>editor@contestledger.example</em>. У підвалі листа, який мені прийшов, було сказано, що спонсорські повідомлення допомагають їм надавати послуги без плати.</p>
<p><a href="https://www.nwgwriters.example/copywriting/learn/opportunity-for-writers">NWG</a> продає курси копірайтингу з 1997 року, з адресою в Делрей-Біч, Флорида. Головний продукт: Accelerated Program for Six-Figure Copywriting. Сторінку я читав 25 вересня 2026 року: там указана ціна 507 доларів. На тій самій сторінці лишилася фраза про повернення 197 доларів. Це не шахрайство. Це продажний текст, який не збігається сам із собою.</p>
<h2>Що ховається за фразами</h2>
<ul>
<li><strong>«Двосторінкова історія».</strong> Це приклад для компанії, англійською case study. Каркас «проблема, рішення, результат» публічно описаний десятиліттями. Жодної таємної структури.</li>
<li><strong>«У середньому 1 500 доларів».</strong> Їхній власний <a href="https://www.nwgwriters.example/inside-nwg/blueprint-for-becoming-well-paid-copywriter">огляд гонорарів</a>, який я читав того самого дня, ставить кейс у діапазон від 1 200 до 2 000 доларів. Це верхня смуга того, хто вже має клієнтів. Початківець бачить із цього частку. Число в темі є їхнім маркетингом, не аудитом ринку.</li>
<li><strong>«Таємна структура».</strong> Продажна фраза. Той самий каркас є в підручниках і в текстах, які саме NWG публікує.</li>
<li><strong>Безкоштовний посібник «9 Ways to Make a Real Living as a Writer».</strong> Після електронної пошти починається продажна послідовність курсу. Файл не є шкідливою програмою. Він має зібрати адресу, щоб курс можна було продати.</li>
<li><strong>«Hi, Friend» і «To your success».</strong> Увесь лист є зразком копірайтингу, який вони продають. «Friend» у direct response не означає, що вас хтось знає.</li>
</ul>
<h2>Чому це прийшло мені</h2>
<p><em>lubomir@polascin.net</em> є моєю авторською скринькою. На розсилку Contest Ledger я колись підписався через конкурси до літературного псевдоніма Walter Rye Koelle. Це сходиться. Цільова група NWG не сходиться.</p>
<p>NWG звертається до початківців на американському ринку direct response, англійською і для компаній. Фахові тексти я пишу під власним іменем, а літературні під псевдонімом. Медичні статті для Zdravotnícke noviny, Lekárske listy і <a href="https://www.solen.sk/en/journals/via-practica">Via practica</a> мають власний прайс: 60 євро за нормосторінку, 40 євро за уже опублікований текст. Це інший ринок, ніж обіцянка, що з двох сторінок вийде прожиток.</p>
<h2>Що з цим робити</h2>
<ol>
<li><strong>Залиште це, або завантажте посібник лише з цікавості.</strong> Файл не є шкідливою програмою. Після нього піде хвиля пропозицій. Якщо він потрібен, дайте іншу адресу, не ту, на якій іде авторська пошта.</li>
<li><strong>Якщо листи йдуть регулярно, відпишіться.</strong> Це справжня розсилка. Відписка, яку вони обіцяють на сайті, має спрацювати. Це повідомлення не варто позначати як спам лише тому, що воно щось продає.</li>
<li><strong>Прочитайте, як побудовано лист.</strong> Питання в темі, курсив, «secret», «free». Коли продаватимете своє, цей direct-response текст є безкоштовним підручником. Курс за 507 доларів я б не купував. Відкриті матеріали про копірайтинг покривають більшу частину того самого.</li>
</ol>
<p>У цій серії три різні речі. Book trailer: шахрайство. Northgrid Agents: законний сайт без зрілості і без причини віддавати йому ключі. NWG через Contest Ledger: легітимна реклама. Перші два належать до скарги на спам. Третє належить до відписки, якщо конкурси вас уже не цікавлять.</p>

<p><em>Це особистий досвід, не юридична і не інвестиційна порада. Назви, адреси й ціни відповідають тому, що 25 вересня 2026 року стояло на сайтах Contest Ledger і NWG та в листі, який мені прийшов. Гонорар за нормосторінку є моїм власним прайсом, не пропозицією читачеві.</em></p>
HTML,
        ],
    ],
];
