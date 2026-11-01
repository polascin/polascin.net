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
 * Syntéza troch už zverejnených článkov z jedného týždňa (25. 9. 2026):
 * awai-dvojstranovy-pribeh-za-1500, atlas-agents-studeny-email-z-icloud,
 * ai-book-trailer-ponuka-je-scam.
 * Writer Beware overené 3. 10. 2026: titulok a dátum 28. 8. 2026 na
 * https://writerbeware.blog/2026/08/28/production-companies-literary-agents-foreign-languages-ai-driven-scams-continue-to-morph/
 * (Victoria Strauss). Pasáž o produkčných spoločnostiach, hyperpersonalizácii,
 * chvále a Gmaile je z toho textu. Záver o zlomku adresátov je môj, nie citát.
 */
return [
    'slug' => 'tri-ponuky-za-tyzden-nikto-necital',
    'author' => 'MUDr. Ľubomír Polaščín',
    'category' => 'blog',
    'is_top' => 0,
    'published_at' => '2026-10-03 22:18:00',
    'image' => 'images/articles/tri-ponuky-za-tyzden-nikto-necital.webp',
    'translations' => [
        'sk' => [
            'title' => 'Tri ponuky za týždeň. Nikto z nich nečítal, čo píšem.',
            'image_alt' => 'Tmavý stôl v noci: tri zatvorené obálky vo fialovom a tyrkysovom svetle, vedľa nich mince a filmový kotúč. Ruka po ne nesiahne.',
            'excerpt' => 'Za jeden týždeň prišli tri nevyžiadané správy: 1 500 dolárov za dvojstranový príbeh, Northgrid Agents z iCloudu a book trailer z Gmailu. Chvála, ktorá sedí na kohokoľvek. Neodpovedajte.',
            'content' => <<<'HTML'
<p>Chvála v prvej správe by sa dala poslať komukoľvek s newsletterom. V druhej komukoľvek s verejným GitHubom. V tretej komukoľvek, kto má verejnú synopsu. Prišli v jednom týždni od troch odosielateľov a ani jedna nevznikla z toho, že by niekto čítal, čo píšem.</p>
<p>Jedna sľubovala peniaze, druhá nástroj a tretia trailer, z ktorého vraj príde sláva. Tá istá kostra: chvála pre kohokoľvek, neurčité konkrétnosti, malý prvý krok, ktorý takmer nič nestojí, a tlak, aby ste odpovedali.</p>
<p>Každú som už rozobral osobitne.</p>
<h2>Peniaze: 1 500 dolárov za dve strany</h2>
<p>Prvá bola platená správa v newslettri Contest Ledger. Sľubovala v priemere 1 500 dolárov za dvojstranový príbeh. Za textom stálo NWG. Nie je to podvod v trestnom zmysle. Obe firmy existujú roky. Je to lievik: bezplatný sprievodca je návnada na kurz. Rozpis je v článku <a href="article.php?slug=awai-dvojstranovy-pribeh-za-1500">1 500 dolárov za dvojstranový príbeh</a>.</p>
<h2>Nástroj: Northgrid Agents z iCloudu</h2>
<p>Druhá bola vycibrená správa o nástrojoch pre AI agentov. Prišla z adresy <em>r.nanduri@icloud.com</em> a ponúkala Northgrid Agents. Gmail ju hodil do spamu. V poli Komu nestálo moje meno. Text znel: „Built for GitHub superusers like you.“ Web produktu existuje. Dôvod dávať mu API kľúče nie. Viac je v článku <a href="article.php?slug=atlas-agents-studeny-email-z-icloud">Northgrid Agents z iCloudu</a>.</p>
<h2>Sláva: book trailer z Gmailu</h2>
<p>Tretia ponúkla book trailer. Správa sa podpísala ako Marek Velen a prišla z <em>m.velen.offers4821@gmail.com</em>. To je to, čo stálo v liste, nie preukázaná totožnosť. Žiadne portfólio, žiadne IMDb, žiadna produkčná doména. Len lichôtky z verejnej synopsy a otázka, či mám dostať ukážku, bez tlaku. Podrobnosti sú v článku <a href="article.php?slug=ai-book-trailer-ponuka-je-scam">Ponuka book trailera z Gmailu</a>.</p>
<p>Táto tretia sedí na to, čo dokumentuje Writer Beware. <a href="https://writerbeware.blog/2026/08/28/production-companies-literary-agents-foreign-languages-ai-driven-scams-continue-to-morph/">Victoria Strauss, 28. augusta 2026</a>, v texte <em>Production Companies, Literary Agents, Foreign Languages: AI-Driven Scams Continue to Morph</em> píše, že jej v posledných týždňoch chodili hlásenia o ľuďoch, ktorí sa vydávajú za produkčné spoločnosti. Znaky pozná z AI podvodov: prehnaná personalizácia, chvála a všadeprítomný Gmail. Také oslovenie sa dnes dá pustiť vo veľkom lacno. Mne z toho ostáva jedno: stačí, keď sa chytí zlomok adresátov.</p>
<h2>Tá istá kostra</h2>
<ul>
<li><strong>Chvála pre kohokoľvek.</strong> Ani jedna veta, ktorá by vznikla len z toho, že niekto čítal moju prácu.</li>
<li><strong>Neurčité konkrétnosti.</strong> Číslo 1 500, oslovenie „superuser“, mená z anotácie. Vyzerá to ako dôkaz. Je to šablóna.</li>
<li><strong>Malý prvý krok.</strong> Stiahnuť sprievodcu. Odpovedať na iCloud. Nechať si poslať ukážku. Takmer zadarmo, a otvorí ďalší krok.</li>
<li><strong>Tlak na odpoveď.</strong> Nie hneď na peniaze. Na to, aby schránka potvrdila, že žije.</li>
</ul>
<h2>Čo s tým</h2>
<p>Neodpovedajte. Ani „nie, ďakujem“. Odpoveď potvrdí, že adresa žije. Potom si zapíšte, čo v správe bolo. Netvrďte, že viete, kto ten človek je. Viete len to, čo správa povedala. Rozbor, ktorý dáte von, trvá asi dvadsať minút a ďalší človek má čo vyhľadať. Najspoľahlivejší signál je chvála, ktorá sedí na kohokoľvek.</p>

HTML,
        ],
        'en' => [
            'title' => 'Three offers in one week. None of them had read what I write.',
            'image_alt' => 'A dark desk at night: three sealed envelopes in purple and teal light, with coins and a film reel beside them. A hand does not reach for them.',
            'excerpt' => 'In one week, three unsolicited messages arrived: $1,500 for a two-page story, Northgrid Agents from iCloud, and a book trailer from Gmail. Praise that would fit anyone. Do not reply.',
            'content' => <<<'HTML'
<p>The praise in the first message could have gone to anyone with a newsletter. In the second, to anyone with a public GitHub account. In the third, to anyone with a public synopsis. They arrived in one week from three senders, and not one sentence came from someone having read what I write.</p>
<p>One promised money, the second a tool, and the third a trailer that was supposed to bring the fame. The same frame: praise for anyone, vague specifics, a small first step that costs almost nothing, and a push to reply.</p>
<p>I have already taken each one apart on its own.</p>
<h2>Money: $1,500 for two pages</h2>
<p>The first was a paid message in the Contest Ledger newsletter. It promised $1,500 on average for a two-page story. Behind the copy was NWG. It is not a scam in the criminal sense. Both firms have existed for years. It is a funnel: the free guide is bait for a course. The breakdown is in <a href="article.php?slug=awai-dvojstranovy-pribeh-za-1500">Fifteen hundred dollars for a two-page story</a>.</p>
<h2>A tool: Northgrid Agents from iCloud</h2>
<p>The second was a polished note about tools for AI agents. It came from <em>r.nanduri@icloud.com</em> and pitched Northgrid Agents. Gmail put it in spam. The To field did not carry my name. The line was: “Built for GitHub superusers like you.” The product site exists. A reason to hand over API keys does not. More is in <a href="article.php?slug=atlas-agents-studeny-email-z-icloud">Northgrid Agents from iCloud</a>.</p>
<h2>Fame: a book trailer from Gmail</h2>
<p>The third offered a book trailer. The message was signed Marek Velen and came from <em>m.velen.offers4821@gmail.com</em>. That is what the letter said, not a proven identity. No portfolio, no IMDb, no production domain. Only flattery lifted from a public synopsis, and a question about whether I should receive a sample, with no pressure. The detail is in <a href="article.php?slug=ai-book-trailer-ponuka-je-scam">A Gmail offer to make my book trailer</a>.</p>
<p>This third one matches what Writer Beware has been documenting. <a href="https://writerbeware.blog/2026/08/28/production-companies-literary-agents-foreign-languages-ai-driven-scams-continue-to-morph/">Victoria Strauss, on 28 August 2026</a>, in <em>Production Companies, Literary Agents, Foreign Languages: AI-Driven Scams Continue to Morph</em>, writes that in recent weeks she had been getting reports of people impersonating production companies. The markers are the ones she knows from AI-driven scams: hyper-personalization, praise, and the ubiquitous Gmail address. That kind of outreach is now cheap to run at volume. What I take from it is this: a fraction of recipients is enough.</p>
<h2>The same frame</h2>
<ul>
<li><strong>Praise for anyone.</strong> Not one sentence that could exist only because someone had read my work.</li>
<li><strong>Vague specifics.</strong> The figure $1,500, the word “superuser,” names from a blurb. It looks like evidence. It is a template.</li>
<li><strong>A small first step.</strong> Download the guide. Reply to the iCloud address. Let them send a sample. Almost free, and it opens the next step.</li>
<li><strong>Pressure to reply.</strong> Not for money, not yet. For the inbox to confirm that it is alive.</li>
</ul>
<h2>What to do</h2>
<p>Do not reply. Not even “no, thank you.” A reply confirms that the address is live. Then write down what was in the message. Do not claim to know who the person is. You only know what the message said. Putting that analysis where someone can find it takes about twenty minutes, and the next person has something to search for. The most reliable tell is praise that would fit anyone.</p>

HTML,
        ],
        'cs' => [
            'title' => 'Tři nabídky za týden. Nikdo z nich nečetl, co píšu.',
            'image_alt' => 'Tmavý stůl v noci: tři zavřené obálky ve fialovém a tyrkysovém světle, vedle nich mince a filmová cívka. Ruka po ně nesáhne.',
            'excerpt' => 'Za jeden týden přišly tři nevyžádané zprávy: 1 500 dolarů za dvoustránkový příběh, Northgrid Agents z iCloudu a book trailer z Gmailu. Chvála, která sedí na kohokoli. Neodpovídejte.',
            'content' => <<<'HTML'
<p>Chvála v první zprávě by se dala poslat komukoli s newsletterem. Ve druhé komukoli s veřejným GitHubem. Ve třetí komukoli, kdo má veřejnou synopsi. Přišly v jednom týdnu od tří odesílatelů a ani jedna nevznikla z toho, že by někdo četl, co píšu.</p>
<p>Jedna slibovala peníze, druhá nástroj a třetí trailer, ze kterého prý přijde sláva. Táž kostra: chvála pro kohokoli, neurčité konkrétnosti, malý první krok, který skoro nic nestojí, a tlak, abyste odpověděli.</p>
<p>Každou jsem už rozebral zvlášť.</p>
<h2>Peníze: 1 500 dolarů za dvě strany</h2>
<p>První byla placená zpráva v newsletteru Contest Ledger. Slibovala v průměru 1 500 dolarů za dvoustránkový příběh. Za textem stálo NWG. Není to podvod v trestním smyslu. Obě firmy existují roky. Je to trychtýř: bezplatný průvodce je návnada na kurz. Rozpis je v článku <a href="article.php?slug=awai-dvojstranovy-pribeh-za-1500">1 500 dolarů za dvoustránkový příběh</a>.</p>
<h2>Nástroj: Northgrid Agents z iCloudu</h2>
<p>Druhá byla uhlazená zpráva o nástrojích pro AI agenty. Přišla z adresy <em>r.nanduri@icloud.com</em> a nabízela Northgrid Agents. Gmail ji hodil do spamu. V poli Komu nestálo mé jméno. Text zněl: „Built for GitHub superusers like you.“ Web produktu existuje. Důvod dávat mu API klíče ne. Víc je v článku <a href="article.php?slug=atlas-agents-studeny-email-z-icloud">Northgrid Agents z iCloudu</a>.</p>
<h2>Sláva: book trailer z Gmailu</h2>
<p>Třetí nabídla book trailer. Zpráva se podepsala jako Marek Velen a přišla z <em>m.velen.offers4821@gmail.com</em>. To je to, co stálo v dopise, ne prokázaná totožnost. Žádné portfolio, žádné IMDb, žádná produkční doména. Jen lichotky z veřejné synopse a otázka, jestli mám dostat ukázku, bez tlaku. Podrobnosti jsou v článku <a href="article.php?slug=ai-book-trailer-ponuka-je-scam">Nabídka book traileru z Gmailu</a>.</p>
<p>Tahle třetí odpovídá tomu, co dokumentuje Writer Beware. <a href="https://writerbeware.blog/2026/08/28/production-companies-literary-agents-foreign-languages-ai-driven-scams-continue-to-morph/">Victoria Strauss, 28. srpna 2026</a>, v textu <em>Production Companies, Literary Agents, Foreign Languages: AI-Driven Scams Continue to Morph</em> píše, že jí v posledních týdnech chodila hlášení o lidech, kteří se vydávají za produkční společnosti. Znaky zná z AI podvodů: přehnaná personalizace, chvála a všudypřítomný Gmail. Takové oslovení se dnes dá pustit ve velkém levně. Mně z toho zůstává jedno: stačí, když se chytí zlomek adresátů.</p>
<h2>Táž kostra</h2>
<ul>
<li><strong>Chvála pro kohokoli.</strong> Ani jedna věta, která by vznikla jen z toho, že někdo četl mou práci.</li>
<li><strong>Neurčité konkrétnosti.</strong> Číslo 1 500, oslovení „superuser“, jména z anotace. Vypadá to jako důkaz. Je to šablona.</li>
<li><strong>Malý první krok.</strong> Stáhnout průvodce. Odpovědět na iCloud. Nechat si poslat ukázku. Skoro zadarmo, a otevře další krok.</li>
<li><strong>Tlak na odpověď.</strong> Ne hned na peníze. Na to, aby schránka potvrdila, že žije.</li>
</ul>
<h2>Co s tím</h2>
<p>Neodpovídejte. Ani „ne, děkuji“. Odpověď potvrdí, že adresa žije. Pak si zapište, co ve zprávě bylo. Netvrďte, že víte, kdo ten člověk je. Víte jen to, co zpráva řekla. Rozbor, který dáte ven, trvá asi dvacet minut a další člověk má co vyhledat. Nejspolehlivější znamení je chvála, která sedí na kohokoli.</p>

HTML,
        ],
        'de' => [
            'title' => 'Drei Angebote in einer Woche. Keiner hatte gelesen, was ich schreibe.',
            'image_alt' => 'Ein dunkler Tisch bei Nacht: drei geschlossene Umschläge in violettem und türkisem Licht, daneben Münzen und eine Filmspule. Eine Hand greift nicht danach.',
            'excerpt' => 'In einer Woche kamen drei unerbetene Nachrichten: 1 500 Dollar für eine zweiseitige Geschichte, Northgrid Agents aus iCloud und ein Book Trailer von Gmail. Lob, das auf jeden passt. Antworten Sie nicht.',
            'content' => <<<'HTML'
<p>Das Lob in der ersten Nachricht hätte an jeden mit einem Newsletter gehen können. In der zweiten an jeden mit einem öffentlichen GitHub. In der dritten an jeden mit einer öffentlichen Synopse. Sie kamen in einer Woche von drei Absendern, und kein Satz war daraus entstanden, dass jemand gelesen hätte, was ich schreibe.</p>
<p>Eine versprach Geld, die zweite ein Werkzeug, die dritte einen Trailer, aus dem angeblich der Ruhm kommt. Dasselbe Gerüst: Lob für jeden, vage Konkretionen, ein kleiner erster Schritt, der fast nichts kostet, und Druck, zu antworten.</p>
<p>Jede habe ich schon für sich auseinandergenommen.</p>
<h2>Geld: 1 500 Dollar für zwei Seiten</h2>
<p>Die erste war eine bezahlte Nachricht im Newsletter von Contest Ledger. Sie versprach im Schnitt 1 500 Dollar für eine zweiseitige Geschichte. Hinter dem Text stand NWG. Das ist kein Betrug im strafrechtlichen Sinn. Beide Firmen gibt es seit Jahren. Es ist ein Trichter: Der kostenlose Leitfaden ist Köder für einen Kurs. Die Aufschlüsselung steht in <a href="article.php?slug=awai-dvojstranovy-pribeh-za-1500">1 500 Dollar für eine zweiseitige Geschichte</a>.</p>
<h2>Ein Werkzeug: Northgrid Agents aus iCloud</h2>
<p>Die zweite war eine polierte Nachricht über Werkzeuge für KI-Agenten. Sie kam von <em>r.nanduri@icloud.com</em> und bot Northgrid Agents an. Gmail legte sie in den Spam. Im Feld An stand nicht mein Name. Der Satz lautete: „Built for GitHub superusers like you.“ Die Produktseite existiert. Ein Grund, API-Schlüssel herauszugeben, nicht. Mehr steht in <a href="article.php?slug=atlas-agents-studeny-email-z-icloud">Northgrid Agents aus iCloud</a>.</p>
<h2>Ruhm: ein Book Trailer von Gmail</h2>
<p>Die dritte bot einen Book Trailer an. Die Nachricht war als Marek Velen unterschrieben und kam von <em>m.velen.offers4821@gmail.com</em>. Das ist, was im Brief stand, keine nachgewiesene Identität. Kein Portfolio, kein IMDb, keine Produktionsdomain. Nur Schmeichelei aus einer öffentlichen Synopse und die Frage, ob ich eine Probe bekommen solle, ohne Druck. Das Einzelne steht in <a href="article.php?slug=ai-book-trailer-ponuka-je-scam">Ein Book-Trailer-Angebot von Gmail</a>.</p>
<p>Diese dritte passt zu dem, was Writer Beware dokumentiert. <a href="https://writerbeware.blog/2026/08/28/production-companies-literary-agents-foreign-languages-ai-driven-scams-continue-to-morph/">Victoria Strauss, am 28. August 2026</a>, schreibt in <em>Production Companies, Literary Agents, Foreign Languages: AI-Driven Scams Continue to Morph</em>, dass ihr in den letzten Wochen Meldungen zugingen über Leute, die sich als Produktionsfirmen ausgeben. Die Merkmale kennt sie von KI-Betrug: übertriebene Personalisierung, Lob und das allgegenwärtige Gmail. Solche Ansprache lässt sich heute billig in großer Zahl verschicken. Was ich daraus mitnehme: Es reicht, wenn ein Bruchteil der Empfänger anbeißt.</p>
<h2>Dasselbe Gerüst</h2>
<ul>
<li><strong>Lob für jeden.</strong> Kein Satz, der nur entstehen konnte, weil jemand meine Arbeit gelesen hat.</li>
<li><strong>Vage Konkretionen.</strong> Die Zahl 1 500, die Anrede „superuser“, Namen aus einem Klappentext. Es sieht aus wie ein Beweis. Es ist eine Vorlage.</li>
<li><strong>Ein kleiner erster Schritt.</strong> Den Leitfaden laden. Auf iCloud antworten. Sich eine Probe schicken lassen. Fast umsonst, und er öffnet den nächsten Schritt.</li>
<li><strong>Druck zur Antwort.</strong> Noch nicht auf Geld. Darauf, dass das Postfach bestätigt, dass es lebt.</li>
</ul>
<h2>Was tun</h2>
<p>Antworten Sie nicht. Auch nicht mit „nein, danke“. Eine Antwort bestätigt, dass die Adresse lebt. Schreiben Sie danach auf, was in der Nachricht stand. Behaupten Sie nicht, zu wissen, wer die Person ist. Sie wissen nur, was die Nachricht gesagt hat. Die Analyse, die Sie veröffentlichen, dauert etwa zwanzig Minuten, und der nächste Mensch hat etwas zu suchen. Das verlässlichste Zeichen ist Lob, das auf jeden passt.</p>

HTML,
        ],
        'fr' => [
            'title' => 'Trois offres en une semaine. Aucun n’avait lu ce que j’écris.',
            'image_alt' => 'Un bureau sombre la nuit : trois enveloppes fermées en lumière violette et turquoise, avec des pièces et une bobine de film à côté. Une main ne les prend pas.',
            'excerpt' => 'En une semaine, trois messages non sollicités : 1 500 dollars pour une histoire de deux pages, Northgrid Agents depuis iCloud, et un book trailer depuis Gmail. Un éloge qui irait à n’importe qui. Ne répondez pas.',
            'content' => <<<'HTML'
<p>L’éloge du premier message aurait pu partir vers n’importe qui avec une lettre d’information. Celui du deuxième, vers n’importe qui avec un GitHub public. Celui du troisième, vers n’importe qui avec un synopsis public. Ils sont arrivés dans la même semaine, de trois expéditeurs, et aucune phrase ne venait de ce que quelqu’un aurait lu ce que j’écris.</p>
<p>L’un promettait de l’argent, le deuxième un outil, le troisième un trailer d’où la gloire était censée venir. La même ossature : un éloge pour n’importe qui, des précisions vagues, un petit premier pas qui ne coûte presque rien, et une poussée pour que vous répondiez.</p>
<p>J’ai déjà démonté chacun à part.</p>
<h2>L’argent : 1 500 dollars pour deux pages</h2>
<p>Le premier était un message payé dans la lettre de Contest Ledger. Il promettait 1 500 dollars en moyenne pour une histoire de deux pages. Derrière le texte, NWG. Ce n’est pas une arnaque au sens pénal. Les deux maisons existent depuis des années. C’est un entonnoir : le guide gratuit est un appât vers un cours. Le détail est dans <a href="article.php?slug=awai-dvojstranovy-pribeh-za-1500">1 500 dollars pour une histoire de deux pages</a>.</p>
<h2>Un outil : Northgrid Agents depuis iCloud</h2>
<p>Le deuxième était une note soignée sur des outils pour agents d’IA. Il venait de <em>r.nanduri@icloud.com</em> et proposait Northgrid Agents. Gmail l’a mis dans les spams. Le champ À ne portait pas mon nom. La phrase était : « Built for GitHub superusers like you. » Le site du produit existe. Une raison de lui confier des clés API, non. La suite est dans <a href="article.php?slug=atlas-agents-studeny-email-z-icloud">Northgrid Agents depuis iCloud</a>.</p>
<h2>La gloire : un book trailer depuis Gmail</h2>
<p>Le troisième offrait un book trailer. Le message était signé Marek Velen et venait de <em>m.velen.offers4821@gmail.com</em>. C’est ce qui figurait dans la lettre, pas une identité établie. Pas de portfolio, pas d’IMDb, pas de domaine de production. Seulement des flatteries tirées d’un synopsis public, et la question de savoir si je devais recevoir un échantillon, sans pression. Le détail est dans <a href="article.php?slug=ai-book-trailer-ponuka-je-scam">Une offre de book trailer depuis Gmail</a>.</p>
<p>Ce troisième correspond à ce que documente Writer Beware. <a href="https://writerbeware.blog/2026/08/28/production-companies-literary-agents-foreign-languages-ai-driven-scams-continue-to-morph/">Victoria Strauss, le 28 août 2026</a>, dans <em>Production Companies, Literary Agents, Foreign Languages: AI-Driven Scams Continue to Morph</em>, écrit que, ces dernières semaines, elle recevait des signalements de gens qui se font passer pour des sociétés de production. Les marques sont celles qu’elle connaît des arnaques par IA : hyperpersonnalisation, éloge, et le Gmail partout. Ce genre de démarchage se lance aujourd’hui à peu de frais, en volume. Ce que j’en retiens : il suffit qu’une fraction des destinataires morde.</p>
<h2>La même ossature</h2>
<ul>
<li><strong>Un éloge pour n’importe qui.</strong> Pas une phrase qui n’existerait que parce que quelqu’un a lu mon travail.</li>
<li><strong>Des précisions vagues.</strong> Le chiffre 1 500, la formule « superuser », des noms tirés d’un texte de présentation. Cela ressemble à une preuve. C’est un modèle.</li>
<li><strong>Un petit premier pas.</strong> Télécharger le guide. Répondre à l’iCloud. Se laisser envoyer un échantillon. Presque gratuit, et cela ouvre l’étape suivante.</li>
<li><strong>La pression de répondre.</strong> Pas tout de suite pour l’argent. Pour que la boîte confirme qu’elle est vivante.</li>
</ul>
<h2>Quoi faire</h2>
<p>Ne répondez pas. Même pas « non, merci ». Une réponse confirme que l’adresse est active. Notez ensuite ce que le message disait. Ne prétendez pas savoir qui est la personne. Vous ne savez que ce que le message a dit. Publier cette analyse prend environ vingt minutes, et la personne suivante a quelque chose à chercher. L’indice le plus sûr est un éloge qui irait à n’importe qui.</p>

HTML,
        ],
        'es' => [
            'title' => 'Tres ofertas en una semana. Ninguno había leído lo que escribo.',
            'image_alt' => 'Un escritorio oscuro de noche: tres sobres cerrados con luz violeta y turquesa, monedas y una bobina de película al lado. Una mano no los toca.',
            'excerpt' => 'En una semana llegaron tres mensajes no pedidos: 1 500 dólares por una historia de dos páginas, Northgrid Agents desde iCloud y un book trailer desde Gmail. Un elogio que valdría para cualquiera. No responda.',
            'content' => <<<'HTML'
<p>El elogio del primer mensaje podría haberse enviado a cualquiera con un boletín. El del segundo, a cualquiera con un GitHub público. El del tercero, a cualquiera con una sinopsis pública. Llegaron en una semana, de tres remitentes, y ninguna frase nacía de que alguien hubiera leído lo que escribo.</p>
<p>Uno prometía dinero, el segundo una herramienta y el tercero un tráiler del que, según decía, vendría la fama. El mismo armazón: un elogio para cualquiera, precisiones vagas, un primer paso pequeño que casi no cuesta nada y un empujón para que usted responda.</p>
<p>Ya desmonté cada uno por separado.</p>
<h2>Dinero: 1 500 dólares por dos páginas</h2>
<p>El primero fue un mensaje de pago en el boletín de Contest Ledger. Prometía 1 500 dólares de media por una historia de dos páginas. Detrás del texto estaba NWG. No es una estafa en sentido penal. Las dos casas existen desde hace años. Es un embudo: la guía gratuita es cebo para un curso. El desglose está en <a href="article.php?slug=awai-dvojstranovy-pribeh-za-1500">1 500 dólares por una historia de dos páginas</a>.</p>
<h2>Una herramienta: Northgrid Agents desde iCloud</h2>
<p>El segundo fue una nota pulida sobre herramientas para agentes de IA. Llegó desde <em>r.nanduri@icloud.com</em> y ofrecía Northgrid Agents. Gmail lo mandó al spam. El campo Para no llevaba mi nombre. La frase era: «Built for GitHub superusers like you.» El sitio del producto existe. Un motivo para entregarle claves de API, no. Hay más en <a href="article.php?slug=atlas-agents-studeny-email-z-icloud">Northgrid Agents desde iCloud</a>.</p>
<h2>Fama: un book trailer desde Gmail</h2>
<p>El tercero ofreció un book trailer. El mensaje iba firmado como Marek Velen y llegó desde <em>m.velen.offers4821@gmail.com</em>. Eso es lo que decía la carta, no una identidad demostrada. Sin portafolio, sin IMDb, sin dominio de producción. Solo halagos sacados de una sinopsis pública y la pregunta de si debía recibir una muestra, sin presión. El detalle está en <a href="article.php?slug=ai-book-trailer-ponuka-je-scam">Una oferta de book trailer desde Gmail</a>.</p>
<p>Este tercero encaja con lo que documenta Writer Beware. <a href="https://writerbeware.blog/2026/08/28/production-companies-literary-agents-foreign-languages-ai-driven-scams-continue-to-morph/">Victoria Strauss, el 28 de agosto de 2026</a>, en <em>Production Companies, Literary Agents, Foreign Languages: AI-Driven Scams Continue to Morph</em>, escribe que en las últimas semanas le llegaban avisos de gente que se hace pasar por productoras. Las marcas son las que conoce de las estafas con IA: hiperpersonalización, elogio y el Gmail por todas partes. Ese tipo de contacto hoy se lanza barato y en volumen. Lo que yo saco de ahí: basta con que pique una fracción de los destinatarios.</p>
<h2>El mismo armazón</h2>
<ul>
<li><strong>Elogio para cualquiera.</strong> Ni una frase que solo existiría porque alguien leyó mi trabajo.</li>
<li><strong>Precisiones vagas.</strong> La cifra de 1 500, el trato de «superuser», nombres de una solapa. Parece una prueba. Es una plantilla.</li>
<li><strong>Un primer paso pequeño.</strong> Descargar la guía. Responder al iCloud. Dejarse enviar una muestra. Casi gratis, y abre el paso siguiente.</li>
<li><strong>Presión para responder.</strong> Todavía no por el dinero. Para que el buzón confirme que está vivo.</li>
</ul>
<h2>Qué hacer</h2>
<p>No responda. Ni siquiera «no, gracias». Una respuesta confirma que la dirección está viva. Después anote lo que decía el mensaje. No afirme saber quién es la persona. Usted solo sabe lo que el mensaje dijo. Publicar ese análisis lleva unos veinte minutos, y la siguiente persona tiene algo que buscar. La señal más segura es un elogio que valdría para cualquiera.</p>

HTML,
        ],
        'pl' => [
            'title' => 'Trzy oferty w jednym tygodniu. Nikt nie czytał tego, co piszę.',
            'image_alt' => 'Ciemne biurko w nocy: trzy zamknięte koperty w fioletowym i turkusowym świetle, obok monety i szpula filmowa. Dłoń po nie nie sięga.',
            'excerpt' => 'W jednym tygodniu przyszły trzy niezamówione wiadomości: 1 500 dolarów za dwustronicową historię, Northgrid Agents z iClouda i book trailer z Gmaila. Pochwała, która pasuje do każdego. Nie odpowiadaj.',
            'content' => <<<'HTML'
<p>Pochwała w pierwszej wiadomości dałaby się wysłać każdemu z newsletterem. W drugiej każdemu z publicznym GitHubem. W trzeciej każdemu, kto ma publiczne streszczenie. Przyszły w jednym tygodniu od trzech nadawców i żadna nie powstała z tego, że ktoś przeczytał, co piszę.</p>
<p>Jedna obiecywała pieniądze, druga narzędzie, a trzecia trailer, z którego rzekomo przyjdzie sława. Ten sam szkielet: pochwała dla każdego, mgliste konkrety, mały pierwszy krok, który prawie nic nie kosztuje, i nacisk, żebyś odpowiedział.</p>
<p>Każdą rozebrałem już osobno.</p>
<h2>Pieniądze: 1 500 dolarów za dwie strony</h2>
<p>Pierwsza była płatną wiadomością w newsletterze Contest Ledger. Obiecywała średnio 1 500 dolarów za dwustronicową historię. Za tekstem stało NWG. To nie jest oszustwo w sensie karnym. Obie firmy istnieją od lat. To lejek: darmowy przewodnik jest przynętą na kurs. Szczegóły są w artykule <a href="article.php?slug=awai-dvojstranovy-pribeh-za-1500">1 500 dolarów za dwustronicową historię</a>.</p>
<h2>Narzędzie: Northgrid Agents z iClouda</h2>
<p>Druga była wygładzoną wiadomością o narzędziach dla agentów AI. Przyszła z adresu <em>r.nanduri@icloud.com</em> i oferowała Northgrid Agents. Gmail wrzucił ją do spamu. W polu Do nie było mojego nazwiska. Zdanie brzmiało: „Built for GitHub superusers like you.” Strona produktu istnieje. Powodu, by oddawać klucze API, nie ma. Więcej jest w artykule <a href="article.php?slug=atlas-agents-studeny-email-z-icloud">Northgrid Agents z iClouda</a>.</p>
<h2>Sława: book trailer z Gmaila</h2>
<p>Trzecia oferowała book trailer. Wiadomość podpisała się jako Marek Velen i przyszła z <em>m.velen.offers4821@gmail.com</em>. To jest to, co stało w liście, nie udowodniona tożsamość. Żadnego portfolio, żadnego IMDb, żadnej domeny produkcji. Tylko pochlebstwa z publicznego streszczenia i pytanie, czy mam dostać próbkę, bez presji. Szczegóły są w artykule <a href="article.php?slug=ai-book-trailer-ponuka-je-scam">Oferta book trailera z Gmaila</a>.</p>
<p>Ta trzecia pasuje do tego, co dokumentuje Writer Beware. <a href="https://writerbeware.blog/2026/08/28/production-companies-literary-agents-foreign-languages-ai-driven-scams-continue-to-morph/">Victoria Strauss, 28 sierpnia 2026</a>, w tekście <em>Production Companies, Literary Agents, Foreign Languages: AI-Driven Scams Continue to Morph</em> pisze, że w ostatnich tygodniach dostawała zgłoszenia o ludziach, którzy podszywają się pod firmy produkcyjne. Znaki zna z oszustw AI: przesadna personalizacja, pochwała i wszechobecny Gmail. Taki kontakt da się dziś puścić tanio i masowo. Ja biorę z tego jedno: wystarczy, że złapie się ułamek adresatów.</p>
<h2>Ten sam szkielet</h2>
<ul>
<li><strong>Pochwała dla każdego.</strong> Ani jedno zdanie, które powstałoby tylko dlatego, że ktoś przeczytał moją pracę.</li>
<li><strong>Mgliste konkrety.</strong> Liczba 1 500, zwrot „superuser”, nazwiska z notki. Wygląda jak dowód. To szablon.</li>
<li><strong>Mały pierwszy krok.</strong> Pobrać przewodnik. Odpowiedzieć na iCloud. Pozwolić przysłać próbkę. Prawie za darmo, a otwiera następny krok.</li>
<li><strong>Nacisk na odpowiedź.</strong> Jeszcze nie na pieniądze. Na to, żeby skrzynka potwierdziła, że żyje.</li>
</ul>
<h2>Co z tym zrobić</h2>
<p>Nie odpowiadaj. Nawet „nie, dziękuję”. Odpowiedź potwierdza, że adres żyje. Potem zapisz, co było w wiadomości. Nie twierdź, że wiesz, kim jest ta osoba. Wiesz tylko to, co wiadomość powiedziała. Analiza, którą opublikujesz, zajmuje około dwudziestu minut, a następna osoba ma czego szukać. Najpewniejszy sygnał to pochwała, która pasuje do każdego.</p>

HTML,
        ],
        'hu' => [
            'title' => 'Három ajánlat egy hét alatt. Egyikük sem olvasta, amit írok.',
            'image_alt' => 'Sötét asztal éjjel: három zárt boríték lila és türkiz fényben, mellettük érmék és egy filmtekercs. Egy kéz nem nyúl értük.',
            'excerpt' => 'Egy hét alatt három kéretlen üzenet jött: 1500 dollár egy kétoldalas történetért, Northgrid Agents iCloudról, és book trailer Gmailről. Dicséret, amely bárkire illik. Ne válaszolj.',
            'content' => <<<'HTML'
<p>Az első üzenet dicsérete bárkinek elmehetett volna, akinek hírlevele van. A másodiké bárkinek, akinek nyilvános GitHubja van. A harmadiké bárkinek, akinek nyilvános szinopszisa van. Egy hét alatt jöttek, három feladótól, és egyik mondat sem azért született, mert valaki olvasta, amit írok.</p>
<p>Az egyik pénzt ígért, a második eszközt, a harmadik trailert, amelyből állítólag a hírnév jön. Ugyanaz a váz: dicséret bárkinek, homályos részletek, apró első lépés, amely szinte semmibe nem kerül, és nyomás, hogy válaszolj.</p>
<p>Mindegyiket külön már szétszedtem.</p>
<h2>Pénz: 1500 dollár két oldalért</h2>
<p>Az első fizetett üzenet volt a Contest Ledger hírlevelében. Átlagosan 1500 dollárt ígért egy kétoldalas történetért. A szöveg mögött az NWG állt. Ez nem bűncselekmény értelmében vett átverés. Mindkét cég évek óta létezik. Tölcsér: az ingyenes útmutató csalétek egy tanfolyamhoz. A bontás a <a href="article.php?slug=awai-dvojstranovy-pribeh-za-1500">1500 dollár egy kétoldalas történetért</a> című cikkben van.</p>
<h2>Eszköz: Northgrid Agents iCloudról</h2>
<p>A második csiszolt üzenet volt AI-ügynökök eszközeiről. A <em>r.nanduri@icloud.com</em> címről jött, és az Northgrid Agentset kínálta. A Gmail a spambe tette. A Címzett mezőben nem az én nevem állt. A mondat ez volt: „Built for GitHub superusers like you.” A termék oldala létezik. Ok arra, hogy API-kulcsot adjak neki, nem. A többi az <a href="article.php?slug=atlas-agents-studeny-email-z-icloud">Northgrid Agents iCloudról</a> című cikkben van.</p>
<h2>Hírnév: book trailer Gmailről</h2>
<p>A harmadik book trailert kínált. Az üzenet Marek Velenként volt aláírva, és a <em>m.velen.offers4821@gmail.com</em> címről jött. Ez az, ami a levélben állt, nem bizonyított személyazonosság. Nincs portfólió, nincs IMDb, nincs gyártási domain. Csak hízelgés egy nyilvános szinopszisból, és a kérdés, hogy kapjak-e mintát, nyomás nélkül. A részletek a <a href="article.php?slug=ai-book-trailer-ponuka-je-scam">Book trailer ajánlat Gmailről</a> című cikkben vannak.</p>
<p>Ez a harmadik illik arra, amit a Writer Beware dokumentál. <a href="https://writerbeware.blog/2026/08/28/production-companies-literary-agents-foreign-languages-ai-driven-scams-continue-to-morph/">Victoria Strauss, 2026. augusztus 28-án</a>, a <em>Production Companies, Literary Agents, Foreign Languages: AI-Driven Scams Continue to Morph</em> című szövegben azt írja, hogy az utóbbi hetekben olyan bejelentések érkeztek hozzá, amelyekben emberek gyártócégeknek adják ki magukat. A jeleket az AI-átverésekből ismeri: túlzott személyre szabás, dicséret és a mindenütt jelen lévő Gmail. Az ilyen megkeresést ma olcsón, nagy tételben lehet futtatni. Amit én viszek el belőle: elég, ha a címzettek töredéke beleharap.</p>
<h2>Ugyanaz a váz</h2>
<ul>
<li><strong>Dicséret bárkinek.</strong> Egyetlen mondat sem, amely csak azért születhetett, mert valaki olvasta a munkámat.</li>
<li><strong>Homályos részletek.</strong> Az 1500-as szám, a „superuser” megszólítás, nevek a fülszövegből. Bizonyítéknak látszik. Sablon.</li>
<li><strong>Apró első lépés.</strong> Letölteni az útmutatót. Válaszolni az iCloudra. Hagyni, hogy mintát küldjenek. Szinte ingyen, és kinyitja a következő lépést.</li>
<li><strong>Nyomás a válaszra.</strong> Még nem a pénzre. Arra, hogy a postaláda megerősítse: él.</li>
</ul>
<h2>Mi legyen vele</h2>
<p>Ne válaszolj. Még „nem, köszönöm”-mel sem. A válasz megerősíti, hogy a cím él. Utána írd le, mi volt az üzenetben. Ne állítsd, hogy tudod, ki az az ember. Csak azt tudod, amit az üzenet mondott. A nyilvános elemzés körülbelül húsz perc, és a következő embernek van mit keresnie. A legbiztosabb jel a dicséret, amely bárkire illik.</p>

HTML,
        ],
        'it' => [
            'title' => 'Tre offerte in una settimana. Nessuno aveva letto quello che scrivo.',
            'image_alt' => 'Una scrivania buia di notte: tre buste chiuse in luce viola e turchese, accanto monete e una bobina di pellicola. Una mano non le prende.',
            'excerpt' => 'In una settimana sono arrivati tre messaggi non richiesti: 1 500 dollari per una storia di due pagine, Northgrid Agents da iCloud e un book trailer da Gmail. Un elogio che andrebbe a chiunque. Non rispondere.',
            'content' => <<<'HTML'
<p>L’elogio del primo messaggio poteva andare a chiunque avesse una newsletter. Quello del secondo, a chiunque avesse un GitHub pubblico. Quello del terzo, a chiunque avesse una sinossi pubblica. Sono arrivati in una settimana da tre mittenti, e nessuna frase nasceva dal fatto che qualcuno avesse letto quello che scrivo.</p>
<p>Uno prometteva denaro, il secondo uno strumento, il terzo un trailer da cui, a detta loro, sarebbe arrivata la fama. La stessa ossatura: un elogio per chiunque, precisazioni vaghe, un primo passo piccolo che non costa quasi nulla, e una spinta perché tu risponda.</p>
<p>Li ho già smontati uno per uno.</p>
<h2>Denaro: 1 500 dollari per due pagine</h2>
<p>Il primo era un messaggio a pagamento nella newsletter di Contest Ledger. Prometteva in media 1 500 dollari per una storia di due pagine. Dietro il testo c’era NWG. Non è una truffa in senso penale. Entrambe le case esistono da anni. È un imbuto: la guida gratuita è un’esca per un corso. Lo svisceramento è in <a href="article.php?slug=awai-dvojstranovy-pribeh-za-1500">1 500 dollari per una storia di due pagine</a>.</p>
<h2>Uno strumento: Northgrid Agents da iCloud</h2>
<p>Il secondo era una nota levigata su strumenti per agenti di IA. Arrivava da <em>r.nanduri@icloud.com</em> e proponeva Northgrid Agents. Gmail l’ha messo nello spam. Nel campo A non c’era il mio nome. La frase era: «Built for GitHub superusers like you.» Il sito del prodotto esiste. Un motivo per consegnare chiavi API, no. Il resto è in <a href="article.php?slug=atlas-agents-studeny-email-z-icloud">Northgrid Agents da iCloud</a>.</p>
<h2>Fama: un book trailer da Gmail</h2>
<p>Il terzo offriva un book trailer. Il messaggio era firmato Marek Velen e arrivava da <em>m.velen.offers4821@gmail.com</em>. È quello che stava nella lettera, non un’identità dimostrata. Nessun portfolio, nessun IMDb, nessun dominio di produzione. Solo lusinghe prese da una sinossi pubblica e la domanda se dovessi ricevere un campione, senza pressione. Il dettaglio è in <a href="article.php?slug=ai-book-trailer-ponuka-je-scam">Un’offerta di book trailer da Gmail</a>.</p>
<p>Questo terzo combacia con ciò che documenta Writer Beware. <a href="https://writerbeware.blog/2026/08/28/production-companies-literary-agents-foreign-languages-ai-driven-scams-continue-to-morph/">Victoria Strauss, il 28 agosto 2026</a>, in <em>Production Companies, Literary Agents, Foreign Languages: AI-Driven Scams Continue to Morph</em>, scrive che nelle ultime settimane le arrivavano segnalazioni di persone che si spacciano per case di produzione. I segni sono quelli che conosce dalle truffe con l’IA: iper-personalizzazione, elogio e Gmail ovunque. Quel tipo di contatto oggi si manda a poco prezzo e in volume. Quello che ne ricavo io: basta che abbocchi una frazione dei destinatari.</p>
<h2>La stessa ossatura</h2>
<ul>
<li><strong>Elogio per chiunque.</strong> Nemmeno una frase che esisterebbe solo perché qualcuno ha letto il mio lavoro.</li>
<li><strong>Precisazioni vaghe.</strong> La cifra 1 500, l’appello «superuser», nomi da una quarta di copertina. Sembra una prova. È un modello.</li>
<li><strong>Un primo passo piccolo.</strong> Scaricare la guida. Rispondere a iCloud. Farsi mandare un campione. Quasi gratis, e apre il passo successivo.</li>
<li><strong>Pressione a rispondere.</strong> Non subito per i soldi. Perché la casella confermi di essere viva.</li>
</ul>
<h2>Cosa farne</h2>
<p>Non rispondere. Nemmeno con «no, grazie». Una risposta conferma che l’indirizzo è vivo. Poi annota che cosa c’era nel messaggio. Non sostenere di sapere chi sia la persona. Sai solo ciò che il messaggio ha detto. Pubblicare quell’analisi richiede circa venti minuti, e la persona dopo ha qualcosa da cercare. Il segnale più sicuro è un elogio che andrebbe a chiunque.</p>

HTML,
        ],
        'uk' => [
            'title' => 'Три пропозиції за тиждень. Ніхто з них не читав того, що я пишу.',
            'image_alt' => 'Темний стіл уночі: три закриті конверти у фіолетовому й бірюзовому світлі, поруч монети й кінобобіна. Рука по них не сягає.',
            'excerpt' => 'За один тиждень надійшли три непрохані листи: 1500 доларів за двосторінкову історію, Northgrid Agents з iCloud і book trailer з Gmail. Похвала, яка пасує будь-кому. Не відповідайте.',
            'content' => <<<'HTML'
<p>Похвалу в першому листі можна було надіслати будь-кому з розсилкою. У другому будь-кому з публічним GitHub. У третьому будь-кому, хто має публічний синопсис. Вони прийшли за один тиждень від трьох відправників, і жодне речення не виникло з того, що хтось прочитав, що я пишу.</p>
<p>Один обіцяв гроші, другий інструмент, третій трейлер, з якого нібито прийде слава. Той самий каркас: похвала для будь-кого, розмиті конкретності, малий перший крок, який майже нічого не коштує, і тиск, щоб ви відповіли.</p>
<p>Кожен я вже розібрав окремо.</p>
<h2>Гроші: 1500 доларів за дві сторінки</h2>
<p>Перший був платним листом у розсилці Contest Ledger. Він обіцяв у середньому 1500 доларів за двосторінкову історію. За текстом стояв NWG. Це не шахрайство в кримінальному сенсі. Обидві фірми існують роками. Це лійка: безкоштовний посібник є наживкою на курс. Розбір є в статті <a href="article.php?slug=awai-dvojstranovy-pribeh-za-1500">1500 доларів за двосторінкову історію</a>.</p>
<h2>Інструмент: Northgrid Agents з iCloud</h2>
<p>Другий був відшліфованим листом про інструменти для ШІ-агентів. Він прийшов з адреси <em>r.nanduri@icloud.com</em> і пропонував Northgrid Agents. Gmail поклав його в спам. У полі Кому не було мого імені. Рядок звучав так: «Built for GitHub superusers like you.» Сайт продукту існує. Причини віддавати API-ключі немає. Більше є в статті <a href="article.php?slug=atlas-agents-studeny-email-z-icloud">Northgrid Agents з iCloud</a>.</p>
<h2>Слава: book trailer з Gmail</h2>
<p>Третій пропонував book trailer. Лист був підписаний як Marek Velen і прийшов з <em>m.velen.offers4821@gmail.com</em>. Це те, що стояло в листі, а не доведена особа. Жодного портфоліо, жодного IMDb, жодного домену продакшену. Лише лестощі з публічного синопсису й питання, чи маю я отримати зразок, без тиску. Подробиці є в статті <a href="article.php?slug=ai-book-trailer-ponuka-je-scam">Пропозиція book trailer з Gmail</a>.</p>
<p>Цей третій лягає на те, що документує Writer Beware. <a href="https://writerbeware.blog/2026/08/28/production-companies-literary-agents-foreign-languages-ai-driven-scams-continue-to-morph/">Victoria Strauss, 28 серпня 2026</a>, у тексті <em>Production Companies, Literary Agents, Foreign Languages: AI-Driven Scams Continue to Morph</em> пише, що останніми тижнями їй надходили повідомлення про людей, які видають себе за продакшен-компанії. Ознаки вона знає з ШІ-шахрайств: надмірна персоналізація, похвала і всюдисущий Gmail. Таке звернення сьогодні можна пустити дешево й масово. Я виношу з цього одне: досить, щоб клюнула частка адресатів.</p>
<h2>Той самий каркас</h2>
<ul>
<li><strong>Похвала для будь-кого.</strong> Жодного речення, яке виникло б лише тому, що хтось прочитав мою роботу.</li>
<li><strong>Розмиті конкретності.</strong> Число 1500, звернення «superuser», імена з анотації. Скидається на доказ. Це шаблон.</li>
<li><strong>Малий перший крок.</strong> Завантажити посібник. Відповісти на iCloud. Дозволити надіслати зразок. Майже безкоштовно, і він відкриває наступний крок.</li>
<li><strong>Тиск на відповідь.</strong> Ще не на гроші. На те, щоб скринька підтвердила, що жива.</li>
</ul>
<h2>Що з цим робити</h2>
<p>Не відповідайте. Навіть «ні, дякую». Відповідь підтверджує, що адреса жива. Потім запишіть, що було в листі. Не стверджуйте, що знаєте, хто ця людина. Ви знаєте лише те, що сказав лист. Аналіз, який ви опублікуєте, триває близько двадцяти хвилин, і наступна людина має що шукати. Найнадійніша ознака: похвала, яка пасує будь-кому.</p>

HTML,
        ],
    ],
];
