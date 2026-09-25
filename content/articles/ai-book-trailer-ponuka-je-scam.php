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
 * Osobný blogový príspevok: nevyžiadaná ponuka book trailera z Gmailu.
 * Overené: Writer Beware 28. 8. 2026, Author Academy august 2026 (scam č. 8),
 * James Scott Bell, Kill Zone, 17. 8. 2025. Meno v podpise je len to, čo bolo v e-maile.
 */
return [
    'slug' => 'ai-book-trailer-ponuka-je-scam',
    'author' => 'MUDr. Ľubomír Polaščín',
    'category' => 'blog',
    'is_top' => 0,
    'published_at' => '2026-09-25 16:45:00',
    'image' => 'images/articles/ai-book-trailer-ponuka-je-scam.webp',
    'translations' => [
        'sk' => [
            'title' => 'Ponuka book trailera z Gmailu. Žiadne portfólio, len lichôtky a háčik.',
            'image_alt' => 'Nočný písací stôl: otvorená kniha, laptop a tyrkysová holografická postava, ktorá z obálky vyťahuje žiariaci filmový pás.',
            'excerpt' => 'Nevyžiadaný e-mail z adresy gbabalola@gmail.com zopakoval verejné detaily z knižnej synopsy a ponúkol ukážku book trailera „bez tlaku“. Writer Beware aj Author Academy opisujú ten istý vzorec. Neodpovedajte.',
            'content' => <<<'HTML'
<p>Prišiel mi e-mail s ponukou book trailera. Odosielateľ sa podpísal ako Gabriel Babalola, adresa bola <em>gbabalola@gmail.com</em>. Písal, že kniha ho zaujala, vymenoval Janu Bravcovú, VITAL-7, Social Utility Score a motív „glitch = vražda“ a spýtal sa, či mi má poslať ukážku. Tón bol mäkký: len ukázať, žiadny tlak.</p>
<p>Znelo to ako filmár, ktorý knihu čítal. Nebol.</p>
<p>Tie detaily sú verejné. Sedia v synopse na Amazon KDP a na Substacku. Model ich zje a vráti správu, ktorá znie, akoby niekto knihu držal v ruke. Žiadna kapitola, ktorú by nešlo vytiahnuť z anotácie. Žiadny web, žiadne portfólio, žiadne IMDb, žiadna produkčná doména. Len meno a Gmail.</p>
<p>V septembri mi prišiel <a href="article.php?slug=ai-generovany-email-o-knihe-je-scam">podobný lichotivý e-mail o knihe</a>. Tentoraz je háčik book trailer. Vzorec je ten istý.</p>
<h2>Čo na správe nesedí</h2>
<ol>
<li><strong>Gmail namiesto firmy.</strong> <a href="https://writerbeware.blog/2026/08/28/production-companies-literary-agents-foreign-languages-ai-driven-scams-continue-to-morph/">Victoria Strauss (Writer Beware, 28. augusta 2026)</a> píše, že priame oslovenie od produkčnej spoločnosti je „one of the least likely things ever to happen to you as a writer“. Ak by sa to naozaj stalo, správa príde z firemnej domény, nie z Gmailu.</li>
<li><strong>Lichôtky z verejného textu.</strong> Personalizácia nie je dôkaz, že niekto knihu čítal. Author Academy v auguste 2026 pripomína, že väčšina takých detailov je verejne dostupná a AI z nich skladá presvedčivý list.</li>
<li><strong>Nevyžiadaný studený kontakt.</strong> Self-publishing a Hollywood sa takto nestretávajú. Strauss to označuje za jednu z najmenej pravdepodobných vecí, ktoré sa autorovi stanú.</li>
<li><strong>„Mám vám poslať ukážku?“</strong> Prvý list nežiada peniaze. Writer Beware to volá boiled-frog prístup: „they ease you gently toward the actual money ask over the course of multiple emails.“</li>
<li><strong>Podpis „Warm regards“.</strong> Rovnaké zakončenie cituje <a href="https://killzoneblog.com/2025/08/your-book-deserves-to-reach-a-larger-audience.html">James Scott Bell (17. augusta 2025)</a> pri AI e-mailoch, ktoré sľubujú väčšie publikum a nemajú web.</li>
<li><strong>Žiadne overiteľné kredity.</strong> Skutočný filmár pošle IMDb, Vimeo, web produkcie a autorov, ktorým sa dá zavolať. Tu nie je nič z toho.</li>
<li><strong>Uhol book trailera.</strong> <a href="https://www.theauthoracademy.com.au/the-new-generation-of-author-scams/">Author Academy, bod 8</a>: za niekoľko tisíc dolárov príde marketingový balík vrátane trailera, ktorý vyzerá, „ako keby vznikol niekomu cez obedňajšiu prestávku“.</li>
<li><strong>Nízky tlak.</strong> „Simply to show“, „no pressure“. Odpoveď nie je zdvorilosť. Je to potvrdenie, že schránka žije.</li>
</ol>
<h2>Ako to zvyčajne pokračuje</h2>
<ol>
<li><strong>Prvý e-mail.</strong> Lichôtka a otázka, či chcete ukážku. Žiadna cena. Cítite sa videní.</li>
<li><strong>Druhý e-mail, ak odpoviete.</strong> Príde „concept sample“, často rýchle video nízkej kvality, a ponuka plnej produkcie. Tu sa objaví suma — stovky až tisíce dolárov.</li>
<li><strong>Ďalšie správy.</strong> Môžu prísť žiadosti o prístup k sociálnym sieťam, k účtu KDP alebo o ďalšie „marketingové“ služby. Bell to zhrnul takto: cieľom „good fit“ je dostať peniaze <em>a</em> prístup ku KDP účtu.</li>
</ol>
<p>Pod menom z podpisu som nenašiel produkciu, IMDb ani portfólio trailera. To nie je totožnosť overená z Facebooku. Je to absencia akejkoľvek profesionálnej stopy. Writer Beware túto vlnu marketingových a produkčných podvodov sleduje ako masovú a stále sa meniacu; časť z nej viaže na operátorov z Nigérie, bez toho, aby jeden Gmail dokazoval konkrétneho človeka.</p>
<h2>Čo s tým</h2>
<ul>
<li><strong>Neodpovedajte.</strong> Ani „nie, ďakujem“. Odpoveď zaradí adresu medzi živé.</li>
<li><strong>Označte správu ako spam</strong> v Gmaile. Samotné zmazanie filter nenaučí.</li>
<li><strong>Neposielajte rukopis, plné znenie knihy ani prístupy k účtom.</strong></li>
<li>Ak by ste predsa overovali: firemný e-mail na vlastnej doméne, portfólio, ktoré si otvoríte vy (nie odkaz z ich správy), a referencie autorov, ktorým zavoláte. Skutočný filmár to pošle. Podvodník zmizne.</li>
</ul>
<p>Bell ten istý vzorec opísal v auguste 2025 a Strauss 28. augusta 2026 napísala, že vlna sa ďalej mení: produkčné spoločnosti, agenti, cudzie jazyky. Objemový obchod. Stačí, keď sa chytí zlomok autorov.</p>
<p>Túto správu som zahodil. Ak vám prišla podobná, napíšte mi cez <a href="contact.php">kontakt</a>. Nie odosielateľovi.</p>
<p><em>Ide o osobnú skúsenosť, nie o právnu radu. Podozrivú správu nahláste poskytovateľovi e-mailu. Meno v podpise je to, čo stálo v e-maile, nie preukázaná totožnosť konkrétneho človeka.</em></p>
HTML,
        ],
        'en' => [
            'title' => 'A Gmail offer to make my book trailer. No portfolio, just flattery and a hook.',
            'image_alt' => 'A night-time writing desk: an open book, a laptop, and a teal holographic figure pulling a glowing film strip out of an envelope.',
            'excerpt' => 'An unsolicited email from gbabalola@gmail.com repeated public details from the book synopsis and offered a book-trailer sample “with no pressure.” Writer Beware and Author Academy describe the same pattern. Do not reply.',
            'content' => <<<'HTML'
<p>I received an email offering a book trailer. The sender signed as Gabriel Babalola, from <em>gbabalola@gmail.com</em>. He wrote that the book had caught him, named Jana Bravcová, VITAL-7, the Social Utility Score, and the “glitch = murder” hook, and asked whether he should send a sample. The tone was soft: just to show, no pressure.</p>
<p>It sounded like a filmmaker who had read the book. It was not.</p>
<p>Those details are public. They sit in the Amazon KDP synopsis and on Substack. A model eats them and returns a message that sounds as if someone held the book. No chapter that cannot be lifted from the blurb. No website, no portfolio, no IMDb, no production domain. A name and a Gmail address.</p>
<p>In September I received <a href="article.php?slug=ai-generovany-email-o-knihe-je-scam">a similar flattering email about a book</a>. This time the hook is a book trailer. The pattern is the same.</p>
<h2>What does not fit</h2>
<ol>
<li><strong>Gmail instead of a company.</strong> <a href="https://writerbeware.blog/2026/08/28/production-companies-literary-agents-foreign-languages-ai-driven-scams-continue-to-morph/">Victoria Strauss (Writer Beware, 28 August 2026)</a> writes that a production company reaching out directly is “one of the least likely things ever to happen to you as a writer.” If it truly happened, the message would come from a company domain, not Gmail.</li>
<li><strong>Flattery built from public text.</strong> Personalization is not proof that someone read the book. Author Academy, in August 2026, notes that most such details are publicly available and that AI assembles a convincing letter from them.</li>
<li><strong>Unsolicited cold contact.</strong> Self-publishing and Hollywood do not meet this way. Strauss calls it one of the least likely things that happen to a writer.</li>
<li><strong>“Shall I send you the sample?”</strong> The first letter does not ask for money. Writer Beware calls this the boiled-frog approach: “they ease you gently toward the actual money ask over the course of multiple emails.”</li>
<li><strong>The sign-off “Warm regards.”</strong> <a href="https://killzoneblog.com/2025/08/your-book-deserves-to-reach-a-larger-audience.html">James Scott Bell (17 August 2025)</a> quotes the same closing on AI emails that promise a larger audience and have no website.</li>
<li><strong>No verifiable credits.</strong> A real filmmaker sends IMDb, Vimeo, a production site, and authors you can call. None of that is here.</li>
<li><strong>The book-trailer angle.</strong> <a href="https://www.theauthoracademy.com.au/the-new-generation-of-author-scams/">Author Academy, item 8</a>: for several thousand dollars you get a marketing package that includes a trailer which looks “like it was made during someone’s lunch break.”</li>
<li><strong>Low pressure.</strong> “Simply to show,” “no pressure.” A reply is not courtesy. It confirms that the inbox is alive.</li>
</ol>
<h2>How it usually continues</h2>
<ol>
<li><strong>Email one.</strong> Flattery and a question about whether you want a sample. No price. You feel seen.</li>
<li><strong>Email two, if you reply.</strong> A “concept sample” arrives, often a quick low-quality video, plus an offer of full production. The sum appears here — hundreds to thousands of dollars.</li>
<li><strong>Later messages.</strong> Requests may follow for access to social accounts, a KDP account, or further “marketing” services. Bell put it this way: the goal of the “good fit” is to get the money <em>and</em> access to the KDP account.</li>
</ol>
<p>Under the name in the signature I found no production company, no IMDb, and no trailer portfolio. That is not an identity verified from Facebook. It is the absence of any professional trace. Writer Beware tracks this wave of marketing and production scams as massive and still changing; it ties part of the wave to operators in Nigeria, without one Gmail proving a specific person.</p>
<h2>What to do</h2>
<ul>
<li><strong>Do not reply.</strong> Not even “no, thank you.” A reply marks the address as live.</li>
<li><strong>Mark the message as spam</strong> in Gmail. Deleting alone does not teach the filter.</li>
<li><strong>Do not send the manuscript, the full book, or account access.</strong></li>
<li>If you still want to check: a company email on its own domain, a portfolio you open yourself (not a link from their message), and author references you can call. A real filmmaker will send that. A scammer disappears.</li>
</ul>
<p>Bell described the same pattern in August 2025, and on 28 August 2026 Strauss wrote that the wave keeps morphing: production companies, agents, foreign languages. A business built on volume. A fraction of authors is enough.</p>
<p>I discarded this message. If a similar one reached you, write to me via the <a href="contact.php">contact form</a>. Not to the sender.</p>
<p><em>This is a personal account, not legal advice. Report a suspicious message to your email provider. The name in the signature is what stood in the email, not a proven identity of a specific person.</em></p>
HTML,
        ],
        'cs' => [
            'title' => 'Nabídka book traileru z Gmailu. Žádné portfolio, jen lichotky a háček.',
            'image_alt' => 'Noční psací stůl: otevřená kniha, laptop a tyrkysová holografická postava, která z obálky vytahuje zářící filmový pás.',
            'excerpt' => 'Nevyžádaný e-mail z adresy gbabalola@gmail.com zopakoval veřejné detaily z knižní synopse a nabídl ukázku book traileru „bez tlaku“. Writer Beware i Author Academy popisují stejný vzorec. Neodpovídejte.',
            'content' => <<<'HTML'
<p>Přišel mi e-mail s nabídkou book traileru. Odesílatel se podepsal jako Gabriel Babalola, adresa byla <em>gbabalola@gmail.com</em>. Psal, že kniha ho zaujala, jmenoval Janu Bravcovou, VITAL-7, Social Utility Score a motiv „glitch = vražda“ a ptal se, jestli mu mám nechat poslat ukázku. Tón byl měkký: jen ukázat, žádný tlak.</p>
<p>Znělo to jako filmař, který knihu četl. Nebyl.</p>
<p>Ty detaily jsou veřejné. Sedí v synopsi na Amazon KDP a na Substacku. Model je spolkne a vrátí zprávu, která zní, jako by někdo knihu držel v ruce. Žádná kapitola, kterou by nešlo vytáhnout z anotace. Žádný web, žádné portfolio, žádné IMDb, žádná produkční doména. Jen jméno a Gmail.</p>
<p>V září mi přišel <a href="article.php?slug=ai-generovany-email-o-knihe-je-scam">podobný lichotivý e-mail o knize</a>. Tentokrát je háček book trailer. Vzorec je stejný.</p>
<h2>Co na zprávě nesedí</h2>
<ol>
<li><strong>Gmail místo firmy.</strong> <a href="https://writerbeware.blog/2026/08/28/production-companies-literary-agents-foreign-languages-ai-driven-scams-continue-to-morph/">Victoria Strauss (Writer Beware, 28. srpna 2026)</a> píše, že přímé oslovení od produkční společnosti je „one of the least likely things ever to happen to you as a writer“. Kdyby se to opravdu stalo, zpráva přijde z firemní domény, ne z Gmailu.</li>
<li><strong>Lichotky z veřejného textu.</strong> Personalizace není důkaz, že někdo knihu četl. Author Academy v srpnu 2026 připomíná, že většina takových detailů je veřejně dostupná a AI z nich skládá přesvědčivý dopis.</li>
<li><strong>Nevyžádaný studený kontakt.</strong> Self-publishing a Hollywood se takto nepotkávají. Strauss to označuje za jednu z nejméně pravděpodobných věcí, které se autorovi stanou.</li>
<li><strong>„Mám vám poslat ukázku?“</strong> První dopis nežádá peníze. Writer Beware tomu říká boiled-frog přístup: „they ease you gently toward the actual money ask over the course of multiple emails.“</li>
<li><strong>Podpis „Warm regards“.</strong> Stejné zakončení cituje <a href="https://killzoneblog.com/2025/08/your-book-deserves-to-reach-a-larger-audience.html">James Scott Bell (17. srpna 2025)</a> u AI e-mailů, které slibují větší publikum a nemají web.</li>
<li><strong>Žádné ověřitelné kredity.</strong> Skutečný filmař pošle IMDb, Vimeo, web produkce a autory, kterým se dá zavolat. Tady z toho není nic.</li>
<li><strong>Úhel book traileru.</strong> <a href="https://www.theauthoracademy.com.au/the-new-generation-of-author-scams/">Author Academy, bod 8</a>: za několik tisíc dolarů přijde marketingový balík včetně traileru, který vypadá, „jako by vznikl někomu přes oběd“.</li>
<li><strong>Nízký tlak.</strong> „Simply to show“, „no pressure“. Odpověď není zdvořilost. Je to potvrzení, že schránka žije.</li>
</ol>
<h2>Jak to obvykle pokračuje</h2>
<ol>
<li><strong>První e-mail.</strong> Lichotka a otázka, jestli chcete ukázku. Žádná cena. Cítíte se viděni.</li>
<li><strong>Druhý e-mail, pokud odpovíte.</strong> Přijde „concept sample“, často rychlé video nízké kvality, a nabídka plné produkce. Tady se objeví suma — stovky až tisíce dolarů.</li>
<li><strong>Další zprávy.</strong> Mohou přijít žádosti o přístup k sociálním sítím, k účtu KDP nebo o další „marketingové“ služby. Bell to shrnul takto: cílem „good fit“ je dostat peníze <em>a</em> přístup ke KDP účtu.</li>
</ol>
<p>Pod jménem z podpisu jsem nenašel produkci, IMDb ani portfolio traileru. To není totožnost ověřená z Facebooku. Je to absence jakékoli profesionální stopy. Writer Beware tuto vlnu marketingových a produkčních podvodů sleduje jako masovou a stále se měnící; část z ní váže na operátory z Nigérie, aniž by jeden Gmail dokazoval konkrétního člověka.</p>
<h2>Co s tím</h2>
<ul>
<li><strong>Neodpovídejte.</strong> Ani „ne, děkuji“. Odpověď zařadí adresu mezi živé.</li>
<li><strong>Označte zprávu jako spam</strong> v Gmailu. Samotné smazání filtr nenaučí.</li>
<li><strong>Neposílejte rukopis, plné znění knihy ani přístupy k účtům.</strong></li>
<li>Pokud byste přesto ověřovali: firemní e-mail na vlastní doméně, portfolio, které si otevřete sami (ne odkaz z jejich zprávy), a reference autorů, kterým zavoláte. Skutečný filmař to pošle. Podvodník zmizí.</li>
</ul>
<p>Bell stejný vzorec popsal v srpnu 2025 a Strauss 28. srpna 2026 napsala, že vlna se dál mění: produkční společnosti, agenti, cizí jazyky. Obchod postavený na objemu. Stačí, když se chytí zlomek autorů.</p>
<p>Tuto zprávu jsem zahodil. Pokud vám přišla podobná, napište mi přes <a href="contact.php">kontakt</a>. Ne odesílateli.</p>
<p><em>Jde o osobní zkušenost, ne o právní radu. Podezřelou zprávu nahlaste poskytovateli e-mailu. Jméno v podpisu je to, co stálo v e-mailu, ne prokázaná totožnost konkrétního člověka.</em></p>
HTML,
        ],
        'de' => [
            'title' => 'Ein Book-Trailer-Angebot von Gmail. Kein Portfolio, nur Schmeichelei und ein Haken.',
            'image_alt' => 'Ein Schreibtisch bei Nacht: ein offenes Buch, ein Laptop und eine türkise holografische Gestalt, die einen leuchtenden Filmstreifen aus einem Umschlag zieht.',
            'excerpt' => 'Eine unerbetene E-Mail von gbabalola@gmail.com wiederholte öffentliche Details aus der Buchsynopse und bot eine Book-Trailer-Probe „ohne Druck“ an. Writer Beware und Author Academy beschreiben dasselbe Muster. Antworten Sie nicht.',
            'content' => <<<'HTML'
<p>Ich erhielt eine E-Mail mit dem Angebot eines Book Trailers. Der Absender unterschrieb als Gabriel Babalola, die Adresse war <em>gbabalola@gmail.com</em>. Er schrieb, das Buch habe ihn gepackt, nannte Jana Bravcová, VITAL-7, den Social Utility Score und das Motiv „glitch = Mord“ und fragte, ob er eine Probe schicken solle. Der Ton war weich: nur zeigen, kein Druck.</p>
<p>Es klang nach einem Filmemacher, der das Buch gelesen hatte. Er war es nicht.</p>
<p>Diese Details sind öffentlich. Sie stehen in der Amazon-KDP-Synopse und auf Substack. Ein Modell schluckt sie und gibt eine Nachricht zurück, die klingt, als hätte jemand das Buch in der Hand gehalten. Kein Kapitel, das sich nicht aus dem Klappentext ziehen ließe. Keine Website, kein Portfolio, kein IMDb, keine Produktionsdomain. Ein Name und Gmail.</p>
<p>Im September kam <a href="article.php?slug=ai-generovany-email-o-knihe-je-scam">eine ähnliche schmeichelnde E-Mail über ein Buch</a>. Diesmal ist der Haken ein Book Trailer. Das Muster ist dasselbe.</p>
<h2>Was an der Nachricht nicht stimmt</h2>
<ol>
<li><strong>Gmail statt Firma.</strong> <a href="https://writerbeware.blog/2026/08/28/production-companies-literary-agents-foreign-languages-ai-driven-scams-continue-to-morph/">Victoria Strauss (Writer Beware, 28. August 2026)</a> schreibt, eine Produktionsfirma, die sich direkt meldet, sei „one of the least likely things ever to happen to you as a writer“. Wenn es wirklich geschähe, käme die Nachricht von einer Firmendomain, nicht von Gmail.</li>
<li><strong>Schmeichelei aus öffentlichem Text.</strong> Personalisierung beweist nicht, dass jemand das Buch gelesen hat. Author Academy erinnerte im August 2026 daran, dass die meisten solchen Details öffentlich sind und KI daraus einen überzeugenden Brief baut.</li>
<li><strong>Unerbetener Kaltkontakt.</strong> Self-Publishing und Hollywood treffen sich so nicht. Strauss nennt es eines der unwahrscheinlichsten Dinge, die einem Autor passieren.</li>
<li><strong>„Soll ich Ihnen die Probe schicken?“</strong> Der erste Brief verlangt kein Geld. Writer Beware nennt das den Boiled-Frog-Ansatz: „they ease you gently toward the actual money ask over the course of multiple emails.“</li>
<li><strong>Die Grußformel „Warm regards“.</strong> Dieselbe Formel zitiert <a href="https://killzoneblog.com/2025/08/your-book-deserves-to-reach-a-larger-audience.html">James Scott Bell (17. August 2025)</a> bei KI-Mails, die ein größeres Publikum versprechen und keine Website haben.</li>
<li><strong>Keine überprüfbaren Credits.</strong> Ein echter Filmemacher schickt IMDb, Vimeo, eine Produktionsseite und Autoren, die man anrufen kann. Hier ist nichts davon.</li>
<li><strong>Der Book-Trailer-Winkel.</strong> <a href="https://www.theauthoracademy.com.au/the-new-generation-of-author-scams/">Author Academy, Punkt 8</a>: Für mehrere Tausend Dollar kommt ein Marketingpaket samt Trailer, der aussieht, „als wäre er in der Mittagspause entstanden“.</li>
<li><strong>Niedriger Druck.</strong> „Simply to show“, „no pressure“. Eine Antwort ist keine Höflichkeit. Sie bestätigt, dass das Postfach lebt.</li>
</ol>
<h2>Wie es gewöhnlich weitergeht</h2>
<ol>
<li><strong>Erste E-Mail.</strong> Schmeichelei und die Frage, ob Sie eine Probe wollen. Kein Preis. Sie fühlen sich gesehen.</li>
<li><strong>Zweite E-Mail, wenn Sie antworten.</strong> Eine „concept sample“ kommt, oft ein schnelles Video geringer Qualität, plus das Angebot einer vollen Produktion. Hier erscheint die Summe — Hunderte bis Tausende Dollar.</li>
<li><strong>Weitere Nachrichten.</strong> Es können Bitten um Zugang zu sozialen Netzen, zum KDP-Konto oder um weitere „Marketing“-Dienste folgen. Bell fasste es so: Das Ziel des „good fit“ ist das Geld <em>und</em> der Zugang zum KDP-Konto.</li>
</ol>
<p>Unter dem Namen in der Signatur fand ich keine Produktion, kein IMDb und kein Trailer-Portfolio. Das ist keine über Facebook geprüfte Identität. Es ist das Fehlen jeder professionellen Spur. Writer Beware verfolgt diese Welle von Marketing- und Produktionsbetrug als massenhaft und weiter wandelbar; einen Teil bindet sie an Betreiber in Nigeria, ohne dass eine Gmail-Adresse eine bestimmte Person beweist.</p>
<h2>Was tun</h2>
<ul>
<li><strong>Antworten Sie nicht.</strong> Auch nicht mit „nein, danke“. Eine Antwort markiert die Adresse als lebendig.</li>
<li><strong>Markieren Sie die Nachricht als Spam</strong> in Gmail. Löschen allein lehrt den Filter nicht.</li>
<li><strong>Schicken Sie kein Manuskript, kein vollständiges Buch und keinen Kontozugang.</strong></li>
<li>Wenn Sie dennoch prüfen: eine Firmenmail auf eigener Domain, ein Portfolio, das Sie selbst öffnen (kein Link aus ihrer Nachricht), und Autorenreferenzen, die Sie anrufen. Ein echter Filmemacher schickt das. Ein Betrüger verschwindet.</li>
</ul>
<p>Bell beschrieb dasselbe Muster im August 2025, und am 28. August 2026 schrieb Strauss, die Welle wandle sich weiter: Produktionsfirmen, Agenten, Fremdsprachen. Ein Geschäft auf Volumen. Ein Bruchteil der Autoren genügt.</p>
<p>Diese Nachricht habe ich verworfen. Wenn eine ähnliche bei Ihnen ankam, schreiben Sie mir über das <a href="contact.php">Kontaktformular</a>. Nicht dem Absender.</p>
<p><em>Das ist ein persönlicher Bericht, keine Rechtsberatung. Melden Sie eine verdächtige Nachricht Ihrem E-Mail-Anbieter. Der Name in der Signatur ist das, was in der E-Mail stand, keine nachgewiesene Identität einer bestimmten Person.</em></p>
HTML,
        ],
        'fr' => [
            'title' => 'Une offre de book trailer depuis Gmail. Pas de portfolio, seulement des flatteries et un hameçon.',
            'image_alt' => 'Un bureau la nuit : un livre ouvert, un ordinateur portable et une figure holographique turquoise qui tire une pellicule lumineuse d’une enveloppe.',
            'excerpt' => 'Un e-mail non sollicité de gbabalola@gmail.com a répété des détails publics du synopsis et a proposé un échantillon de book trailer « sans pression ». Writer Beware et Author Academy décrivent le même schéma. Ne répondez pas.',
            'content' => <<<'HTML'
<p>J’ai reçu un e-mail proposant un book trailer. L’expéditeur signait Gabriel Babalola, depuis <em>gbabalola@gmail.com</em>. Il écrivait que le livre l’avait saisi, citait Jana Bravcová, VITAL-7, le Social Utility Score et le motif « glitch = meurtre », et demandait s’il devait envoyer un échantillon. Le ton était doux : juste montrer, aucune pression.</p>
<p>Cela sonnait comme un cinéaste qui avait lu le livre. Ce n’en était pas un.</p>
<p>Ces détails sont publics. Ils figurent dans le synopsis Amazon KDP et sur Substack. Un modèle les avale et renvoie un message qui donne l’impression que quelqu’un tenait le livre. Aucun chapitre qu’on ne puisse tirer de la quatrième de couverture. Pas de site, pas de portfolio, pas d’IMDb, pas de domaine de production. Un nom et Gmail.</p>
<p>En septembre, j’ai reçu <a href="article.php?slug=ai-generovany-email-o-knihe-je-scam">un e-mail flatteur du même genre au sujet d’un livre</a>. Cette fois, l’hameçon est un book trailer. Le schéma est le même.</p>
<h2>Ce qui ne tient pas</h2>
<ol>
<li><strong>Gmail à la place d’une société.</strong> <a href="https://writerbeware.blog/2026/08/28/production-companies-literary-agents-foreign-languages-ai-driven-scams-continue-to-morph/">Victoria Strauss (Writer Beware, 28 août 2026)</a> écrit qu’une société de production qui vous contacte directement est « one of the least likely things ever to happen to you as a writer ». Si cela arrivait vraiment, le message viendrait d’un domaine d’entreprise, pas de Gmail.</li>
<li><strong>Des flatteries tirées d’un texte public.</strong> La personnalisation ne prouve pas qu’on a lu le livre. Author Academy, en août 2026, rappelle que la plupart de ces détails sont publics et que l’IA en assemble une lettre convaincante.</li>
<li><strong>Un contact froid non sollicité.</strong> L’autoédition et Hollywood ne se rencontrent pas ainsi. Strauss y voit l’une des choses les moins probables pour un auteur.</li>
<li><strong>« Voulez-vous que je vous envoie l’échantillon ? »</strong> Le premier message ne demande pas d’argent. Writer Beware appelle cela l’approche de la grenouille : « they ease you gently toward the actual money ask over the course of multiple emails. »</li>
<li><strong>La formule « Warm regards ».</strong> <a href="https://killzoneblog.com/2025/08/your-book-deserves-to-reach-a-larger-audience.html">James Scott Bell (17 août 2025)</a> cite la même clôture dans des e-mails d’IA qui promettent un plus large public et n’ont pas de site.</li>
<li><strong>Aucun crédit vérifiable.</strong> Un vrai cinéaste envoie IMDb, Vimeo, un site de production et des auteurs qu’on peut appeler. Rien de tout cela ici.</li>
<li><strong>L’angle du book trailer.</strong> <a href="https://www.theauthoracademy.com.au/the-new-generation-of-author-scams/">Author Academy, point 8</a> : pour plusieurs milliers de dollars arrive un pack marketing avec un trailer qui a l’air « fait pendant la pause déjeuner ».</li>
<li><strong>Une faible pression.</strong> « Simply to show », « no pressure ». Répondre n’est pas une politesse. C’est confirmer que la boîte est active.</li>
</ol>
<h2>Comment cela continue d’habitude</h2>
<ol>
<li><strong>Premier e-mail.</strong> Flatterie et question : voulez-vous un échantillon ? Pas de prix. On se sent vu.</li>
<li><strong>Deuxième e-mail, si vous répondez.</strong> Arrive un « concept sample », souvent une vidéo rapide de faible qualité, plus une offre de production complète. La somme apparaît ici — des centaines à des milliers de dollars.</li>
<li><strong>Messages suivants.</strong> Peuvent suivre des demandes d’accès aux réseaux, au compte KDP, ou d’autres services de « marketing ». Bell le résume ainsi : le but du « good fit » est l’argent <em>et</em> l’accès au compte KDP.</li>
</ol>
<p>Sous le nom de la signature, je n’ai trouvé ni production, ni IMDb, ni portfolio de trailers. Ce n’est pas une identité vérifiée sur Facebook. C’est l’absence de toute trace professionnelle. Writer Beware suit cette vague d’arnaques marketing et de production comme massive et encore changeante ; une part est liée à des opérateurs au Nigeria, sans qu’un Gmail prouve une personne précise.</p>
<h2>Que faire</h2>
<ul>
<li><strong>Ne répondez pas.</strong> Même pas « non, merci ». Une réponse marque l’adresse comme active.</li>
<li><strong>Marquez le message comme spam</strong> dans Gmail. Effacer seul n’apprend rien au filtre.</li>
<li><strong>N’envoyez ni manuscrit, ni livre complet, ni accès aux comptes.</strong></li>
<li>Si vous vérifiez quand même : un e-mail d’entreprise sur son propre domaine, un portfolio que vous ouvrez vous-même (pas un lien de leur message), et des références d’auteurs que vous appelez. Un vrai cinéaste enverra cela. Un arnaqueur disparaît.</li>
</ul>
<p>Bell a décrit le même schéma en août 2025, et le 28 août 2026 Strauss a écrit que la vague continue de muter : sociétés de production, agents, langues étrangères. Un commerce de volume. Une fraction d’auteurs suffit.</p>
<p>J’ai jeté ce message. Si un message semblable vous est arrivé, écrivez-moi via le <a href="contact.php">formulaire de contact</a>. Pas à l’expéditeur.</p>
<p><em>Il s’agit d’un récit personnel, pas d’un avis juridique. Signalez un message suspect à votre fournisseur de messagerie. Le nom dans la signature est celui qui figurait dans l’e-mail, pas une identité prouvée.</em></p>
HTML,
        ],
        'es' => [
            'title' => 'Una oferta de book trailer desde Gmail. Sin portafolio, solo halagos y un anzuelo.',
            'image_alt' => 'Un escritorio de noche: un libro abierto, un portátil y una figura holográfica turquesa que saca una tira de película luminosa de un sobre.',
            'excerpt' => 'Un correo no solicitado de gbabalola@gmail.com repitió detalles públicos de la sinopsis y ofreció una muestra de book trailer «sin presión». Writer Beware y Author Academy describen el mismo patrón. No responda.',
            'content' => <<<'HTML'
<p>Me llegó un correo con una oferta de book trailer. El remitente firmaba como Gabriel Babalola, desde <em>gbabalola@gmail.com</em>. Escribía que el libro le había llamado, nombraba a Jana Bravcová, VITAL-7, el Social Utility Score y el motivo «glitch = asesinato», y preguntaba si debía enviar una muestra. El tono era blando: solo mostrar, sin presión.</p>
<p>Sonaba a un cineasta que había leído el libro. No lo era.</p>
<p>Esos detalles son públicos. Están en la sinopsis de Amazon KDP y en Substack. Un modelo los traga y devuelve un mensaje que parece escrito por alguien que tuvo el libro en la mano. Ningún capítulo que no se pueda sacar de la contraportada. Ni web, ni portafolio, ni IMDb, ni dominio de producción. Un nombre y Gmail.</p>
<p>En septiembre recibí <a href="article.php?slug=ai-generovany-email-o-knihe-je-scam">un correo halagador parecido sobre un libro</a>. Esta vez el anzuelo es un book trailer. El patrón es el mismo.</p>
<h2>Lo que no encaja</h2>
<ol>
<li><strong>Gmail en lugar de una empresa.</strong> <a href="https://writerbeware.blog/2026/08/28/production-companies-literary-agents-foreign-languages-ai-driven-scams-continue-to-morph/">Victoria Strauss (Writer Beware, 28 de agosto de 2026)</a> escribe que una productora que contacta directamente es «one of the least likely things ever to happen to you as a writer». Si ocurriera de verdad, el mensaje llegaría desde un dominio de empresa, no desde Gmail.</li>
<li><strong>Halagos sacados de un texto público.</strong> La personalización no prueba que alguien leyó el libro. Author Academy, en agosto de 2026, recuerda que la mayoría de esos detalles son públicos y que la IA arma con ellos una carta convincente.</li>
<li><strong>Contacto en frío no solicitado.</strong> La autopublicación y Hollywood no se encuentran así. Strauss lo llama una de las cosas menos probables para un autor.</li>
<li><strong>«¿Le envío la muestra?»</strong> El primer mensaje no pide dinero. Writer Beware lo llama el método de la rana hervida: «they ease you gently toward the actual money ask over the course of multiple emails.»</li>
<li><strong>El cierre «Warm regards».</strong> El mismo cierre lo cita <a href="https://killzoneblog.com/2025/08/your-book-deserves-to-reach-a-larger-audience.html">James Scott Bell (17 de agosto de 2025)</a> en correos de IA que prometen un público mayor y no tienen web.</li>
<li><strong>Ningún crédito verificable.</strong> Un cineasta real envía IMDb, Vimeo, una web de producción y autores a los que se puede llamar. Aquí no hay nada de eso.</li>
<li><strong>El ángulo del book trailer.</strong> <a href="https://www.theauthoracademy.com.au/the-new-generation-of-author-scams/">Author Academy, punto 8</a>: por varios miles de dólares llega un paquete de marketing con un tráiler que parece «hecho en la pausa del almuerzo».</li>
<li><strong>Poca presión.</strong> «Simply to show», «no pressure». Responder no es cortesía. Confirma que el buzón está vivo.</li>
</ol>
<h2>Cómo suele seguir</h2>
<ol>
<li><strong>Primer correo.</strong> Halago y la pregunta de si quiere una muestra. Sin precio. Uno se siente visto.</li>
<li><strong>Segundo correo, si responde.</strong> Llega un «concept sample», a menudo un vídeo rápido de baja calidad, y la oferta de producción completa. Aquí aparece la cifra: cientos o miles de dólares.</li>
<li><strong>Mensajes posteriores.</strong> Pueden pedir acceso a redes, a la cuenta de KDP u otros servicios de «marketing». Bell lo resumió así: el objetivo del «good fit» es el dinero <em>y</em> el acceso a la cuenta de KDP.</li>
</ol>
<p>Bajo el nombre de la firma no encontré productora, ni IMDb, ni portafolio de tráilers. No es una identidad verificada en Facebook. Es la ausencia de cualquier rastro profesional. Writer Beware sigue esta ola de estafas de marketing y producción como masiva y aún cambiante; vincula una parte con operadores en Nigeria, sin que un Gmail pruebe a una persona concreta.</p>
<h2>Qué hacer</h2>
<ul>
<li><strong>No responda.</strong> Ni siquiera «no, gracias». Una respuesta marca la dirección como activa.</li>
<li><strong>Marque el mensaje como spam</strong> en Gmail. Borrar solo no enseña al filtro.</li>
<li><strong>No envíe el manuscrito, el libro completo ni accesos a cuentas.</strong></li>
<li>Si aun así quiere comprobar: un correo de empresa en su propio dominio, un portafolio que abra usted (no un enlace de su mensaje) y referencias de autores a los que llame. Un cineasta real lo enviará. Un estafador desaparece.</li>
</ul>
<p>Bell describió el mismo patrón en agosto de 2025, y el 28 de agosto de 2026 Strauss escribió que la ola sigue mutando: productoras, agentes, idiomas extranjeros. Un negocio de volumen. Basta una fracción de autores.</p>
<p>Descarté este mensaje. Si le llegó uno parecido, escríbame por el <a href="contact.php">formulario de contacto</a>. No al remitente.</p>
<p><em>Es un relato personal, no asesoramiento legal. Denuncie un mensaje sospechoso a su proveedor de correo. El nombre de la firma es el que figuraba en el correo, no una identidad demostrada.</em></p>
HTML,
        ],
        'pl' => [
            'title' => 'Oferta book trailera z Gmaila. Bez portfolio, same pochlebstwa i haczyk.',
            'image_alt' => 'Nocne biurko: otwarta książka, laptop i turkusowa holograficzna postać, która wyciąga z koperty świecącą taśmę filmową.',
            'excerpt' => 'Niezamówiony e-mail z adresu gbabalola@gmail.com powtórzył publiczne szczegóły ze streszczenia książki i zaproponował próbkę book trailera „bez presji”. Writer Beware i Author Academy opisują ten sam wzorzec. Nie odpowiadajcie.',
            'content' => <<<'HTML'
<p>Dostałem e-mail z ofertą book trailera. Nadawca podpisał się jako Gabriel Babalola, adres to <em>gbabalola@gmail.com</em>. Pisał, że książka go zainteresowała, wymienił Janę Bravcovą, VITAL-7, Social Utility Score i motyw „glitch = morderstwo” i spytał, czy ma przysłać próbkę. Ton był miękki: tylko pokazać, żadnej presji.</p>
<p>Brzmiało to jak filmowiec, który książkę przeczytał. Nie był nim.</p>
<p>Te szczegóły są publiczne. Stoją w streszczeniu na Amazon KDP i na Substacku. Model je zjada i oddaje wiadomość, która brzmi, jakby ktoś trzymał książkę w ręku. Żaden rozdział, którego nie da się wyciągnąć z notki. Żadna strona, żadne portfolio, żadne IMDb, żadna domena produkcji. Imię i Gmail.</p>
<p>We wrześniu dostałem <a href="article.php?slug=ai-generovany-email-o-knihe-je-scam">podobny pochlebny e-mail o książce</a>. Tym razem haczykiem jest book trailer. Wzorzec jest ten sam.</p>
<h2>Co w wiadomości nie pasuje</h2>
<ol>
<li><strong>Gmail zamiast firmy.</strong> <a href="https://writerbeware.blog/2026/08/28/production-companies-literary-agents-foreign-languages-ai-driven-scams-continue-to-morph/">Victoria Strauss (Writer Beware, 28 sierpnia 2026)</a> pisze, że bezpośredni kontakt od firmy produkcyjnej to „one of the least likely things ever to happen to you as a writer”. Gdyby naprawdę do tego doszło, wiadomość przyszłaby z domeny firmowej, nie z Gmaila.</li>
<li><strong>Pochlebstwa z publicznego tekstu.</strong> Personalizacja nie dowodzi, że ktoś książkę przeczytał. Author Academy w sierpniu 2026 przypomina, że większość takich szczegółów jest publiczna, a AI składa z nich przekonujący list.</li>
<li><strong>Niezamówiony zimny kontakt.</strong> Self-publishing i Hollywood tak się nie spotykają. Strauss nazywa to jedną z najmniej prawdopodobnych rzeczy, które spotykają autora.</li>
<li><strong>„Mam wysłać próbkę?”</strong> Pierwszy list nie prosi o pieniądze. Writer Beware nazywa to podejściem gotowanej żaby: „they ease you gently toward the actual money ask over the course of multiple emails.”</li>
<li><strong>Podpis „Warm regards”.</strong> To samo zakończenie cytuje <a href="https://killzoneblog.com/2025/08/your-book-deserves-to-reach-a-larger-audience.html">James Scott Bell (17 sierpnia 2025)</a> przy e-mailach AI, które obiecują większą publiczność i nie mają strony.</li>
<li><strong>Żadnych sprawdzalnych kredytów.</strong> Prawdziwy filmowiec przyśle IMDb, Vimeo, stronę produkcji i autorów, do których można zadzwonić. Tu nie ma nic z tego.</li>
<li><strong>Kąt book trailera.</strong> <a href="https://www.theauthoracademy.com.au/the-new-generation-of-author-scams/">Author Academy, punkt 8</a>: za kilka tysięcy dolarów przychodzi pakiet marketingowy z trailerem, który wygląda, „jakby powstał komuś w przerwie na lunch”.</li>
<li><strong>Niska presja.</strong> „Simply to show”, „no pressure”. Odpowiedź nie jest uprzejmością. To potwierdzenie, że skrzynka żyje.</li>
</ol>
<h2>Jak to zwykle idzie dalej</h2>
<ol>
<li><strong>Pierwszy e-mail.</strong> Pochlebstwo i pytanie, czy chcecie próbkę. Bez ceny. Czujecie się zauważeni.</li>
<li><strong>Drugi e-mail, jeśli odpowiecie.</strong> Przychodzi „concept sample”, często szybkie wideo niskiej jakości, i oferta pełnej produkcji. Tu pojawia się kwota — setki do tysięcy dolarów.</li>
<li><strong>Kolejne wiadomości.</strong> Mogą prosić o dostęp do mediów społecznościowych, do konta KDP albo o dalsze usługi „marketingowe”. Bell ujął to tak: celem „good fit” są pieniądze <em>i</em> dostęp do konta KDP.</li>
</ol>
<p>Pod nazwiskiem z podpisu nie znalazłem produkcji, IMDb ani portfolio trailera. To nie jest tożsamość sprawdzona na Facebooku. To brak jakiegokolwiek śladu zawodowego. Writer Beware śledzi tę falę oszustw marketingowych i produkcyjnych jako masową i wciąż zmienną; część wiąże z operatorami z Nigerii, bez tego, by jeden Gmail dowodził konkretnej osoby.</p>
<h2>Co z tym zrobić</h2>
<ul>
<li><strong>Nie odpowiadajcie.</strong> Nawet „nie, dziękuję”. Odpowiedź oznaczy adres jako żywy.</li>
<li><strong>Oznaczcie wiadomość jako spam</strong> w Gmailu. Samo usunięcie filtra nie nauczy.</li>
<li><strong>Nie wysyłajcie rękopisu, pełnej książki ani dostępów do kont.</strong></li>
<li>Jeśli mimo to sprawdzacie: firmowy e-mail na własnej domenie, portfolio, które otworzycie sami (nie link z ich wiadomości), i referencje autorów, do których zadzwonicie. Prawdziwy filmowiec to przyśle. Oszust zniknie.</li>
</ul>
<p>Bell opisał ten sam wzorzec w sierpniu 2025, a 28 sierpnia 2026 Strauss napisała, że fala dalej się zmienia: firmy produkcyjne, agenci, obce języki. Biznes na wolumenie. Wystarczy ułamek autorów.</p>
<p>Tę wiadomość wyrzuciłem. Jeśli podobna do Was dotarła, napiszcie przez <a href="contact.php">kontakt</a>. Nie do nadawcy.</p>
<p><em>To osobiste doświadczenie, nie porada prawna. Podejrzaną wiadomość zgłoście dostawcy poczty. Imię w podpisie jest tym, co stało w e-mailu, nie udowodnioną tożsamością konkretnej osoby.</em></p>
HTML,
        ],
        'hu' => [
            'title' => 'Book trailer ajánlat Gmailről. Nincs portfólió, csak hízelgés és horog.',
            'image_alt' => 'Éjszakai íróasztal: nyitott könyv, laptop és türkiz holografikus alak, amely világító filmszalagot húz ki egy borítékból.',
            'excerpt' => 'A gbabalola@gmail.com címről érkező kéretlen levél megismételte a könyvszinopszis nyilvános részleteit, és „nyomás nélkül” book trailer mintát kínált. A Writer Beware és az Author Academy ugyanezt a mintát írja le. Ne válaszoljon.',
            'content' => <<<'HTML'
<p>Kaptam egy e-mailt book trailer ajánlattal. A feladó Gabriel Babalolaként írt alá, a cím <em>gbabalola@gmail.com</em> volt. Azt írta, a könyv megragadta, megnevezte Jana Bravcovát, a VITAL-7-et, a Social Utility Score-t és a „glitch = gyilkosság” motívumot, és megkérdezte, küldjön-e mintát. A hang lágy volt: csak megmutatni, semmi nyomás.</p>
<p>Úgy hangzott, mint egy filmes, aki olvasta a könyvet. Nem az volt.</p>
<p>Ezek a részletek nyilvánosak. Az Amazon KDP szinopszisában és a Substackon állnak. A modell lenyeli őket, és olyan üzenetet ad vissza, mintha valaki a kezében tartotta volna a könyvet. Nincs olyan fejezet, amit ne lehetne kiemelni a fülszövegből. Nincs weboldal, portfólió, IMDb, gyártási domain. Egy név és egy Gmail.</p>
<p>Szeptemberben <a href="article.php?slug=ai-generovany-email-o-knihe-je-scam">hasonló hízelgő levelet kaptam egy könyvről</a>. Most a horog a book trailer. A minta ugyanaz.</p>
<h2>Mi nem stimmel</h2>
<ol>
<li><strong>Gmail cég helyett.</strong> <a href="https://writerbeware.blog/2026/08/28/production-companies-literary-agents-foreign-languages-ai-driven-scams-continue-to-morph/">Victoria Strauss (Writer Beware, 2026. augusztus 28.)</a> azt írja, hogy egy gyártócég közvetlen megkeresése „one of the least likely things ever to happen to you as a writer”. Ha valóban megtörténne, az üzenet céges domainről jönne, nem Gmailről.</li>
<li><strong>Hízelgés nyilvános szövegből.</strong> A személyre szabás nem bizonyítja, hogy valaki olvasta a könyvet. Az Author Academy 2026 augusztusában emlékeztet: az ilyen részletek többsége nyilvános, és az MI meggyőző levelet rak belőlük össze.</li>
<li><strong>Kéretlen hideg kapcsolat.</strong> A self-publishing és a Hollywood nem így találkozik. Strauss a szerzővel történhető legkevésbé valószínű dolgok közé sorolja.</li>
<li><strong>„Elküldjem a mintát?”</strong> Az első levél nem kér pénzt. A Writer Beware ezt boiled-frog módszernek hívja: „they ease you gently toward the actual money ask over the course of multiple emails.”</li>
<li><strong>A „Warm regards” aláírás.</strong> Ugyanezt a zárást idézi <a href="https://killzoneblog.com/2025/08/your-book-deserves-to-reach-a-larger-audience.html">James Scott Bell (2025. augusztus 17.)</a> olyan MI-leveleknél, amelyek nagyobb közönséget ígérnek, és nincs weboldaluk.</li>
<li><strong>Nincs ellenőrizhető kredit.</strong> Egy igazi filmes IMDb-t, Vimeót, gyártási oldalt és hívható szerzőket küld. Itt ebből semmi nincs.</li>
<li><strong>A book trailer szög.</strong> <a href="https://www.theauthoracademy.com.au/the-new-generation-of-author-scams/">Author Academy, 8. pont</a>: néhány ezer dollárért marketingcsomag érkezik, benne egy trailerrel, amely úgy néz ki, „mintha valaki ebédszünetben csinálta volna”.</li>
<li><strong>Alacsony nyomás.</strong> „Simply to show”, „no pressure”. A válasz nem udvariasság. Annak a jele, hogy a postaláda él.</li>
</ol>
<h2>Hogyan folytatódik általában</h2>
<ol>
<li><strong>Első e-mail.</strong> Hízelgés és a kérdés, kell-e minta. Nincs ár. Úgy érzi, észrevették.</li>
<li><strong>Második e-mail, ha válaszol.</strong> Jön egy „concept sample”, gyakran gyors, gyenge videó, és a teljes gyártás ajánlata. Itt jelenik meg az összeg — százaktól ezrekig dollárban.</li>
<li><strong>További üzenetek.</strong> Jöhet kérés közösségi fiókokhoz, KDP-fiókhoz vagy további „marketing” szolgáltatásokhoz. Bell így foglalta össze: a „good fit” célja a pénz <em>és</em> a KDP-fiók elérése.</li>
</ol>
<p>Az aláírásban álló név alatt nem találtam gyártót, IMDb-t vagy trailer-portfóliót. Ez nem Facebookon ellenőrzött személyazonosság. Bármilyen szakmai nyom hiánya. A Writer Beware ezt a marketing- és gyártási csaláshullámot tömegesnek és változónak követi; egy részét nigériai üzemeltetőkhöz köti, anélkül hogy egy Gmail konkrét embert bizonyítana.</p>
<h2>Mit tegyen</h2>
<ul>
<li><strong>Ne válaszoljon.</strong> Még „nem, köszönöm” formában sem. A válasz élőnek jelöli a címet.</li>
<li><strong>Jelölje a levelet spamnek</strong> a Gmailben. A törlés önmagában nem tanítja a szűrőt.</li>
<li><strong>Ne küldjön kéziratot, teljes könyvet vagy fiókhozzáférést.</strong></li>
<li>Ha mégis ellenőriz: céges e-mail a saját domainjén, portfólió, amelyet ön nyit meg (nem az ő levelük linkje), és szerzői referenciák, akiket felhív. Egy igazi filmes elküldi. A csaló eltűnik.</li>
</ul>
<p>Bell 2025 augusztusában írta le ugyanezt a mintát, Strauss pedig 2026. augusztus 28-án azt, hogy a hullám tovább alakul: gyártók, ügynökök, idegen nyelvek. Volumenre épülő üzlet. Elég a szerzők töredéke.</p>
<p>Ezt az üzenetet eldobtam. Ha hasonló érkezett, írjon a <a href="contact.php">kapcsolati űrlapon</a>. Ne a feladónak.</p>
<p><em>Személyes beszámoló, nem jogi tanács. A gyanús levelet jelentse az e-mail-szolgáltatónak. Az aláírásban álló név az, ami a levélben állt, nem egy konkrét személy bizonyított kiléte.</em></p>
HTML,
        ],
        'it' => [
            'title' => 'Un’offerta di book trailer da Gmail. Nessun portfolio, solo lusinghe e un amo.',
            'image_alt' => 'Una scrivania di notte: un libro aperto, un laptop e una figura olografica turchese che tira una pellicola luminosa fuori da una busta.',
            'excerpt' => 'Un’email non richiesta da gbabalola@gmail.com ha ripetuto dettagli pubblici della sinossi e ha offerto un campione di book trailer «senza pressione». Writer Beware e Author Academy descrivono lo stesso schema. Non rispondete.',
            'content' => <<<'HTML'
<p>Mi è arrivata un’email con l’offerta di un book trailer. Il mittente firmava Gabriel Babalola, da <em>gbabalola@gmail.com</em>. Scriveva che il libro lo aveva colpito, nominava Jana Bravcová, VITAL-7, il Social Utility Score e il motivo «glitch = omicidio», e chiedeva se dovesse mandare un campione. Il tono era morbido: solo per mostrare, nessuna pressione.</p>
<p>Sembrava un cineasta che aveva letto il libro. Non lo era.</p>
<p>Quei dettagli sono pubblici. Stanno nella sinossi di Amazon KDP e su Substack. Un modello li ingoia e restituisce un messaggio che sembra scritto da chi teneva il libro in mano. Nessun capitolo che non si possa tirare fuori dalla quarta. Nessun sito, nessun portfolio, nessun IMDb, nessun dominio di produzione. Un nome e Gmail.</p>
<p>A settembre ho ricevuto <a href="article.php?slug=ai-generovany-email-o-knihe-je-scam">un’email lusinghiera simile su un libro</a>. Questa volta l’amo è un book trailer. Lo schema è lo stesso.</p>
<h2>Cosa non torna</h2>
<ol>
<li><strong>Gmail al posto di un’azienda.</strong> <a href="https://writerbeware.blog/2026/08/28/production-companies-literary-agents-foreign-languages-ai-driven-scams-continue-to-morph/">Victoria Strauss (Writer Beware, 28 agosto 2026)</a> scrive che una casa di produzione che vi contatta direttamente è «one of the least likely things ever to happen to you as a writer». Se accadesse davvero, il messaggio arriverebbe da un dominio aziendale, non da Gmail.</li>
<li><strong>Lusinghe da un testo pubblico.</strong> La personalizzazione non prova che qualcuno abbia letto il libro. Author Academy, nell’agosto 2026, ricorda che la maggior parte di questi dettagli è pubblica e che l’IA ne compone una lettera convincente.</li>
<li><strong>Contatto a freddo non richiesto.</strong> Il self-publishing e Hollywood non si incontrano così. Strauss lo chiama una delle cose meno probabili per un autore.</li>
<li><strong>«Vi mando il campione?»</strong> La prima lettera non chiede denaro. Writer Beware la chiama l’approccio della rana bollita: «they ease you gently toward the actual money ask over the course of multiple emails.»</li>
<li><strong>La chiusura «Warm regards».</strong> La stessa formula la cita <a href="https://killzoneblog.com/2025/08/your-book-deserves-to-reach-a-larger-audience.html">James Scott Bell (17 agosto 2025)</a> nelle email di IA che promettono un pubblico più ampio e non hanno un sito.</li>
<li><strong>Nessun credito verificabile.</strong> Un vero cineasta manda IMDb, Vimeo, un sito di produzione e autori che si possono chiamare. Qui non c’è nulla di tutto questo.</li>
<li><strong>L’angolo del book trailer.</strong> <a href="https://www.theauthoracademy.com.au/the-new-generation-of-author-scams/">Author Academy, punto 8</a>: per alcune migliaia di dollari arriva un pacchetto di marketing con un trailer che sembra «fatto durante la pausa pranzo».</li>
<li><strong>Bassa pressione.</strong> «Simply to show», «no pressure». Rispondere non è cortesia. Conferma che la casella è viva.</li>
</ol>
<h2>Come di solito continua</h2>
<ol>
<li><strong>Prima email.</strong> Lusinga e la domanda se volete un campione. Nessun prezzo. Vi sentite visti.</li>
<li><strong>Seconda email, se rispondete.</strong> Arriva un «concept sample», spesso un video rapido di bassa qualità, e l’offerta di una produzione completa. Qui compare la cifra: da centinaia a migliaia di dollari.</li>
<li><strong>Messaggi successivi.</strong> Possono chiedere accesso ai social, all’account KDP o altri servizi di «marketing». Bell lo ha riassunto così: lo scopo del «good fit» è il denaro <em>e</em> l’accesso all’account KDP.</li>
</ol>
<p>Sotto il nome della firma non ho trovato una produzione, un IMDb né un portfolio di trailer. Non è un’identità verificata su Facebook. È l’assenza di qualsiasi traccia professionale. Writer Beware segue questa ondata di truffe di marketing e produzione come massiccia e ancora mutevole; ne lega una parte a operatori in Nigeria, senza che un Gmail dimostri una persona precisa.</p>
<h2>Cosa fare</h2>
<ul>
<li><strong>Non rispondete.</strong> Nemmeno «no, grazie». Una risposta segna l’indirizzo come attivo.</li>
<li><strong>Segnate il messaggio come spam</strong> in Gmail. Cancellare da solo non insegna nulla al filtro.</li>
<li><strong>Non inviate il manoscritto, il libro intero né accessi agli account.</strong></li>
<li>Se volete comunque verificare: un’email aziendale sul proprio dominio, un portfolio che aprite voi (non un link del loro messaggio) e riferimenti di autori che chiamate. Un vero cineasta lo manderà. Un truffatore sparisce.</li>
</ul>
<p>Bell ha descritto lo stesso schema nell’agosto 2025, e il 28 agosto 2026 Strauss ha scritto che l’ondata continua a mutare: case di produzione, agenti, lingue straniere. Un affare di volume. Basta una frazione di autori.</p>
<p>Ho cestinato questo messaggio. Se ne è arrivato uno simile, scrivetemi tramite il <a href="contact.php">modulo di contatto</a>. Non al mittente.</p>
<p><em>È un resoconto personale, non un parere legale. Segnalate un messaggio sospetto al fornitore di posta. Il nome nella firma è quello che stava nell’email, non un’identità dimostrata.</em></p>
HTML,
        ],
        'uk' => [
            'title' => 'Пропозиція book trailer з Gmail. Без портфоліо, лише лестощі й гачок.',
            'image_alt' => 'Нічний письмовий стіл: відкрита книга, ноутбук і бірюзова голографічна постать, що витягає з конверта світну кінострічку.',
            'excerpt' => 'Непроханий лист з адреси gbabalola@gmail.com повторив публічні деталі з синопсису книжки й запропонував зразок book trailer «без тиску». Writer Beware і Author Academy описують той самий шаблон. Не відповідайте.',
            'content' => <<<'HTML'
<p>Мені надійшов лист із пропозицією book trailer. Відправник підписався як Gabriel Babalola, адреса — <em>gbabalola@gmail.com</em>. Він писав, що книжка його зачепила, назвав Яну Бравцову, VITAL-7, Social Utility Score і мотив «glitch = вбивство» та спитав, чи надіслати зразок. Тон був м’який: лише показати, жодного тиску.</p>
<p>Це звучало як кінематографіст, який прочитав книжку. Він ним не був.</p>
<p>Ці деталі публічні. Вони стоять у синопсисі на Amazon KDP і на Substack. Модель їх ковтає і повертає лист, ніби хтось тримав книжку в руці. Жодного розділу, якого не витягнути з анотації. Жодного сайту, портфоліо, IMDb, домену продакшену. Ім’я і Gmail.</p>
<p>У вересні мені надійшов <a href="article.php?slug=ai-generovany-email-o-knihe-je-scam">схожий улесливий лист про книжку</a>. Цього разу гачок — book trailer. Шаблон той самий.</p>
<h2>Що в листі не сходиться</h2>
<ol>
<li><strong>Gmail замість компанії.</strong> <a href="https://writerbeware.blog/2026/08/28/production-companies-literary-agents-foreign-languages-ai-driven-scams-continue-to-morph/">Victoria Strauss (Writer Beware, 28 серпня 2026)</a> пише, що пряме звернення продакшен-компанії — це «one of the least likely things ever to happen to you as a writer». Якби це справді сталося, лист прийшов би з корпоративного домену, не з Gmail.</li>
<li><strong>Лестощі з публічного тексту.</strong> Персоналізація не доводить, що хтось прочитав книжку. Author Academy у серпні 2026 нагадує: більшість таких деталей публічні, і ШІ складає з них переконливого листа.</li>
<li><strong>Непроханий холодний контакт.</strong> Самвидав і Голлівуд так не зустрічаються. Strauss називає це однією з найменш імовірних речей для автора.</li>
<li><strong>«Надіслати вам зразок?»</strong> Перший лист не просить грошей. Writer Beware називає це підходом вареної жаби: «they ease you gently toward the actual money ask over the course of multiple emails.»</li>
<li><strong>Підпис «Warm regards».</strong> Те саме завершення цитує <a href="https://killzoneblog.com/2025/08/your-book-deserves-to-reach-a-larger-audience.html">James Scott Bell (17 серпня 2025)</a> в листах ШІ, які обіцяють більшу авдиторію і не мають сайту.</li>
<li><strong>Жодних перевірюваних кредитів.</strong> Справжній кінематографіст надішле IMDb, Vimeo, сайт продакшену й авторів, яким можна зателефонувати. Тут цього немає.</li>
<li><strong>Кут book trailer.</strong> <a href="https://www.theauthoracademy.com.au/the-new-generation-of-author-scams/">Author Academy, пункт 8</a>: за кілька тисяч доларів приходить маркетинговий пакет із трейлером, який виглядає так, «ніби його зробили в обідню перерву».</li>
<li><strong>Низький тиск.</strong> «Simply to show», «no pressure». Відповідь — не ввічливість. Це підтвердження, що скринька жива.</li>
</ol>
<h2>Як це зазвичай триває далі</h2>
<ol>
<li><strong>Перший лист.</strong> Лестощі й питання, чи хочете зразок. Без ціни. Ви почуваєтеся побаченими.</li>
<li><strong>Другий лист, якщо відповісте.</strong> Надходить «concept sample», часто швидке відео низької якості, і пропозиція повної продукції. Тут з’являється сума — від сотень до тисяч доларів.</li>
<li><strong>Наступні листи.</strong> Можуть просити доступ до соцмереж, до облікового запису KDP або подальші «маркетингові» послуги. Bell сформулював це так: мета «good fit» — гроші <em>і</em> доступ до облікового запису KDP.</li>
</ol>
<p>Під ім’ям із підпису я не знайшов продакшену, IMDb чи портфоліо трейлерів. Це не особа, перевірена через Facebook. Це відсутність будь-якого професійного сліду. Writer Beware стежить за цією хвилею маркетингових і продакшен-шахрайств як за масовою і змінною; частину пов’язує з операторами в Нігерії, не стверджуючи, що один Gmail доводить конкретну людину.</p>
<h2>Що робити</h2>
<ul>
<li><strong>Не відповідайте.</strong> Навіть «ні, дякую». Відповідь позначає адресу як живу.</li>
<li><strong>Позначте лист як спам</strong> у Gmail. Саме видалення фільтра не навчить.</li>
<li><strong>Не надсилайте рукопис, повний текст книжки чи доступи до облікових записів.</strong></li>
<li>Якщо все ж перевіряєте: корпоративна пошта на власному домені, портфоліо, яке відкриваєте ви самі (не посилання з їхнього листа), і рекомендації авторів, яким телефонуєте. Справжній кінематографіст це надішле. Шахрай зникне.</li>
</ul>
<p>Bell описав той самий шаблон у серпні 2025, а 28 серпня 2026 Strauss написала, що хвиля далі змінюється: продакшен-компанії, агенти, чужі мови. Бізнес на обсязі. Досить частки авторів.</p>
<p>Цей лист я викинув. Якщо подібний надійшов вам, напишіть через <a href="contact.php">контакт</a>. Не відправнику.</p>
<p><em>Це особистий досвід, не юридична порада. Підозрілий лист повідомте поштовому провайдеру. Ім’я в підписі — те, що стояло в листі, а не доведена особа конкретної людини.</em></p>
HTML,
        ],
    ],
];
