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
 * Etnografická poznámka o ľudovej prezývke „čeresare“ a o obci Kyjov (okres Stará Ľubovňa).
 * Overené 1. 10. 2026:
 * - SNM, popis knihy N. Varcholovej Odkiaľ a kedy...: príklady prezývok „hurňare, čeresare, mačankoše“
 *   a Kyjov v kapitole o povestiach od presídlencov
 *   (snm.sk … produkt=odkial-a-kedy).
 * - CTĽK / ludovakultura.sk: heslo opasok (čeres), horské oblasti Slovenska.
 * - Obec Kyjov: súpis 1538 ako rusínska obec; legenda o šiestich Rusínoch z Kyjeva označená ako legenda;
 *   hospodárstvo: poľnohospodárstvo, dobytok, sezónna práca v lese, pálenie dreva
 *   (obec-kyjov.sk/p/6367/historia-obce.html).
 * Primárne heslo Varcholovej, ktoré by viazalo „čeresare“ priamo na Kyjov, v dostupnom internetovom
 * popise knihy nie je; preto stotožnenie s Kyjovčanmi zostáva pracovnou hypotézou.
 */
return [
    'slug' => 'ceresare-z-kyjova',
    'author' => 'MUDr. Ľubomír Polaščín',
    'category' => 'blog',
    'is_top' => 0,
    'published_at' => '2026-10-01 08:05:00',
    'image' => 'images/articles/ceresare-z-kyjova.webp',
    'translations' => [
        'sk' => [
            'title' => 'Čeresare z Kyjova: čo o prezývke vieme a čo zatiaľ nie',
            'image_alt' => 'Široký kožený mužský opasok čeres s viacerými prackami a cvočkami na dreve, v pozadí hmlisté karpatské úbočia vo fialovom a tyrkysovom svetle.',
            'excerpt' => 'Výraz čeresare je doložený v etnografii Rusínov východného Slovenska, pravdepodobne podľa širokého koženého opaska. Kyjov do tohto priestoru zapadá, no stotožnenie Čeresarov s Kyjovčanmi zatiaľ nie je primárne doložené.',
            'content' => <<<'HTML'
<p>„Čeresare“ s veľkou pravdepodobnosťou neoznačuje osobitnú etnickú skupinu Rusínov ani Lemkov. Ide skôr o starú kolektívnu prezývku obyvateľov určitej rusínskej obce alebo lokálnej skupiny, odvodenú od charakteristickej súčasti mužského odevu — takzvaného <em>čeresa</em>.</p>
<h2>Čo bol čeres</h2>
<p>Čeres bol široký kožený mužský opasok typický pre horské oblasti Karpát. Nebol to obyčajný remeň na nohavice. Zhotovoval sa zo širokého pásu kože, často sa zapínal na viacero praciek, mohol mať vnútorné vrecko a býval zdobený vybíjaním, kovovými cvočkami, ornamentmi či remienkami. Prakticky spevňoval driek pri ťažkej práci a chránil telo. <a href="https://www.ludovakultura.sk/polozka-encyklopedie/opasok">Centrum pre tradičnú ľudovú kultúru</a> ho priamo uvádza ako „opasok (čeres)“ a konštatuje, že sa nosil v horských oblastiach Slovenska.</p>
<p>Etnografické pramene dokladajú obdobný <em>черес</em> / <em>cheres</em> aj medzi Lemkami, Rusínmi, Huculmi a ďalšími karpatskými skupinami. Z jazykového hľadiska teda veľmi prirodzene vzniká reťazec: čeres → človek charakteristický nosením čeresa → čeresar → množné čeresare. Podobne ako iné miestne pomenovania končiace na <em>-are</em>.</p>
<h2>Najdôležitejší nález</h2>
<p>Výraz „čeresare“ je skutočne doložený v odbornej etnografickej literatúre o Rusínoch východného Slovenska. Etnografka Nadežda Varcholová vo svojej publikácii <em>Odkiaľ a kedy…</em>, vydanej Slovenským národným múzeom — Múzeom ukrajinskej kultúry, opisuje staré ľudové prezývky rusínskych obcí. <a href="https://www.snm.sk/muzea-snm/muzeum-ukrajinskej-kultury/galeria-dezidera-millyho/objavujte/publikacie?produkt=odkial-a-kedy">SNM pri charakteristike knihy</a> píše, že tieto prezývky vznikali okrem iného podľa „nárečových a národopisných (odev, strava a pod.) zvláštností“ a medzi príkladmi uvádza priamo „hurňare, čeresare, mačankoše“.</p>
<p>To je podstatné. Znamená to, že <em>čeresare</em> je autentický etnografický výraz z prostredia Rusínov severovýchodného Slovenska — nie novodobý výmysel ani skomolenina.</p>
<h2>Sú Čeresare práve obyvatelia Kyjova?</h2>
<p>Tu musím byť zatiaľ opatrný. Potvrdené mám tri veci:</p>
<ol>
<li>„čeresare“ bola ľudová prezývka určitej rusínskej lokálnej komunity;</li>
<li>pravdepodobne súvisela s odevom, pretože Varcholová ju zaraďuje medzi prezývky odvodené od nárečových a národopisných — najmä odevných alebo stravovacích — zvláštností;</li>
<li>čeres je práve taký typický prvok mužského karpatského odevu, takže etymologické spojenie „čeresare = nositelia čeresov“ je veľmi silné.</li>
</ol>
<p>Verejne dostupný internetový opis Varcholovej knihy však neuvádza, ku ktorej konkrétnej obci sa prezývka viaže. Na to by bolo treba dostať sa k samotnému heslu v knihe. Preto zatiaľ nechcem kategoricky tvrdiť: „Čeresare = Kyjovčania.“ Je to možné a vzhľadom na kontext aj dosť pravdepodobné, ale zatiaľ to nemám doložené primárnym zápisom.</p>
<h2>Kyjov do tohto kultúrneho priestoru veľmi dobre zapadá</h2>
<p>Pri samotnom Kyjove máme pomerne jednoznačnú historickú kontinuitu rusínskeho osídlenia. <a href="https://www.obec-kyjov.sk/p/6367/historia-obce.html">Oficiálna história obce</a> uvádza, že v súpise z roku 1538 je Kyjov vedený ako rusínska obec. Koncom 16. storočia tu žilo roľnícke a valašské obyvateľstvo slovenského a rusínskeho pôvodu.</p>
<p>Miestna tradícia zachovala legendu, podľa ktorej obec založilo šesť Rusínov prichádzajúcich z Kyjeva; obec samotná správne upozorňuje, že ide o legendu, nie o historicky doložený fakt. Zaujímavé je aj to, že Varcholová vo svojej knihe spomína Kyjov priamo medzi obcami, ktorých názov ľudové podanie vysvetľovalo prisťahovalcami. Kyjov teda rozhodne patrí do geografického a kultúrneho materiálu, ktorý skúmala.</p>
<h2>Rusín, Rusnák a Lemko</h2>
<p>Tu sa oplatí rozlišovať niekoľko úrovní. <em>Rusnák</em> je tradičné ľudové pomenovanie človeka rusínskeho obyvateľstva, ktoré sa na severovýchode Slovenska používalo a používa dodnes. <em>Rusín</em> je širšie etnické pomenovanie. <em>Lemko</em> je regionálna karpatská skupina v severnej a severovýchodnej časti karpatského rusínskeho priestoru. Hranice medzi tým, koho historické pramene označovali ako Lemka a koho ako Rusnáka alebo Rusína, nie sú vždy totožné s dnešnými národnostnými kategóriami.</p>
<p>A Čeresare podľa všetkého predstavujú ešte o úroveň nižšie označenie: nie národ ani etnografickú makroskupinu, ale lokálnu dedinskú prezývku. Schematicky: Rusíni / Rusnáci → regionálne karpatské skupiny vrátane Lemkov → konkrétne dediny → dedinské prezývky typu Čeresare, Hurňare, Mačankoše, Potičkare, Kavkare…</p>
<p>Takéto prezývky boli v tradičnej dedinskej kultúre veľmi dôležité. Susedné dediny podľa nich okamžite vedeli, odkiaľ človek pochádza. Často boli humorné, ironické, niekedy mierne posmešné; postupom času mohli fungovať takmer ako lokálne etnonymum.</p>
<h2>Čo pravdepodobne znamenalo „Čeresare“</h2>
<p>Na základe kombinácie prameňov by som pracovnú interpretáciu formuloval takto: Čeresare boli ľudovým pomenovaním obyvateľov jednej z rusínskych obcí severovýchodného Slovenska, pravdepodobne podľa charakteristického nosenia širokého koženého mužského opaska nazývaného čeres. Nešlo o samostatný rusínsky alebo lemkovský kmeň či etnickú skupinu.</p>
<p>Ak sa potvrdí, že Varcholová viaže túto prezývku priamo na Kyjov, význam by bol jednoduchý: Čeresare = stará susedská alebo národopisná prezývka Kyjovčanov, pravdepodobne podľa ich tradičného mužského odevu.</p>
<h2>Jeden detail, ktorý môže byť zaujímavý</h2>
<p>Čeres nebol iba dekoratívny kus kroja. Bol to predmet spojený s pastierstvom, lesnou prácou, fyzickou silou a horským spôsobom života. Mal praktickú funkciu pri ochrane drieku a nosili sa v ňom peniaze a drobné predmety. V ľudovej kultúre získal aj symbolický význam sily a objavuje sa v zbojníckych tradíciách.</p>
<p>Ak teda susedia nazývali obyvateľov určitej dediny Čeresarmi, mohlo to znamenať nielen „tí s opaskami“, ale aj identifikovať komunitu charakteristickú archaickejším horským odevom alebo pastierskou kultúrou. To by ku Kyjovu pod Minčolom a k tradičnému lesnému a valašskému hospodárstvu veľmi dobre pasovalo: história obce uvádza poľnohospodárstvo, chov dobytka, sezónnu prácu v lesoch a pálenie dreva. Toto posledné spojenie je však interpretácia, nie zatiaľ priamo doložený výrok prameňa.</p>

<p><em>Ide o čítanie verejne dostupných etnografických a obecných prameňov a o pracovnú etymologickú interpretáciu. Nie je to uzavretý historický verdikt o pôvode prezývky konkrétnej obce.</em></p>
HTML,
        ],
        'en' => [
            'title' => 'The Čeresare of Kyjov: what we know about the nickname, and what we do not yet',
            'image_alt' => 'A wide men’s leather belt, a čeres, with several buckles and studs on wood, misty Carpathian slopes behind it in violet and teal light.',
            'excerpt' => 'Čeresare is documented in the ethnography of Rusyns in eastern Slovakia, likely from the wide leather belt. Kyjov fits that world, but equating the Čeresare with the people of Kyjov is not yet backed by a primary entry.',
            'content' => <<<'HTML'
<p>“Čeresare” almost certainly does not name a distinct ethnic group of Rusyns or Lemkos. It is more likely an old collective nickname for the people of a particular Rusyn village or local group, taken from a characteristic piece of men’s dress — the so-called <em>čeres</em>.</p>
<h2>What a čeres was</h2>
<p>A čeres was a wide leather men’s belt typical of the mountain regions of the Carpathians. It was not an ordinary trouser belt. It was made from a broad strip of leather, often fastened with several buckles, could have an inner pocket, and was decorated with embossing, metal studs, ornaments or straps. In practice it braced the waist for hard work and protected the body. The <a href="https://www.ludovakultura.sk/polozka-encyklopedie/opasok">Centre for Traditional Folk Culture</a> lists it directly as “belt (čeres)” and notes that it was worn in the mountain areas of Slovakia.</p>
<p>Ethnographic sources attest a similar <em>черес</em> / <em>cheres</em> among Lemkos, Rusyns, Hutsuls and other Carpathian groups. Linguistically the chain is natural: čeres → a person marked by wearing a čeres → čeresar → plural čeresare — much like other local names ending in <em>-are</em>.</p>
<h2>The key find</h2>
<p>The word “čeresare” is genuinely attested in the scholarly ethnographic literature on the Rusyns of eastern Slovakia. In <em>Odkiaľ a kedy…</em>, published by the Slovak National Museum — Museum of Ukrainian Culture, the ethnographer Nadežda Varcholová describes old folk nicknames of Rusyn villages. <a href="https://www.snm.sk/muzea-snm/muzeum-ukrajinskej-kultury/galeria-dezidera-millyho/objavujte/publikacie?produkt=odkial-a-kedy">The SNM’s book description</a> says these nicknames arose, among other things, from “dialect and ethnographic (dress, food, and so on) peculiarities,” and among the examples it gives “hurňare, čeresare, mačankoše” directly.</p>
<p>That matters. It means <em>čeresare</em> is an authentic ethnographic term from the Rusyn world of north-eastern Slovakia — not a modern invention or a garble.</p>
<h2>Are the Čeresare specifically the people of Kyjov?</h2>
<p>Here I still have to be careful. Three things are confirmed:</p>
<ol>
<li>“čeresare” was a folk nickname for a particular local Rusyn community;</li>
<li>it probably related to dress, because Varcholová places it among nicknames derived from dialect and ethnographic — especially dress or food — peculiarities;</li>
<li>the čeres is exactly that kind of typical men’s Carpathian garment, so the etymological link “čeresare = wearers of čeres belts” is strong.</li>
</ol>
<p>The publicly available internet description of Varcholová’s book does not say which concrete village the nickname belongs to. That would need the entry in the book itself. So I will not yet state categorically: “Čeresare = the people of Kyjov.” It is possible, and given the context quite likely, but I do not yet have a primary record for it.</p>
<h2>Kyjov fits this cultural space well</h2>
<p>For Kyjov itself we have a fairly clear historical continuity of Rusyn settlement. The <a href="https://www.obec-kyjov.sk/p/6367/historia-obce.html">village’s official history</a> states that in the 1538 register Kyjov is listed as a Rusyn village. At the end of the sixteenth century farming and Wallachian populations of Slovak and Rusyn origin lived there.</p>
<p>Local tradition preserves a legend that the village was founded by six Rusyns coming from Kyiv; the municipality itself rightly notes that this is a legend, not a historically documented fact. It is also notable that Varcholová mentions Kyjov among villages whose names folk tradition explained by incomers. Kyjov therefore clearly belongs to the geographic and cultural material she studied.</p>
<h2>Rusyn, Rusnák and Lemko</h2>
<p>Several levels are worth keeping apart. <em>Rusnák</em> is the traditional folk name for a person of the Rusyn population, still used in north-eastern Slovakia. <em>Rusyn</em> is the broader ethnic name. <em>Lemko</em> is a regional Carpathian group in the northern and north-eastern part of the Carpathian Rusyn space. The boundaries of who historical sources called a Lemko and who a Rusnák or Rusyn are not always identical with today’s nationality categories.</p>
<p>And the Čeresare, by all appearances, sit one level lower still: not a nation or an ethnographic macro-group, but a local village nickname. Schematically: Rusyns / Rusnáks → regional Carpathian groups including Lemkos → particular villages → village nicknames of the Čeresare, Hurňare, Mačankoše, Potičkare, Kavkare type…</p>
<p>Such nicknames mattered in traditional village culture. Neighbouring villages could tell at once where someone came from. They were often humorous, ironic, sometimes mildly mocking; over time they could function almost as a local ethnonym.</p>
<h2>What “Čeresare” probably meant</h2>
<p>From the combined sources I would put the working interpretation like this: the Čeresare were a folk name for the people of one of the Rusyn villages of north-eastern Slovakia, probably from the characteristic wearing of the wide leather men’s belt called a čeres. They were not a separate Rusyn or Lemko tribe or ethnic group.</p>
<p>If it is confirmed that Varcholová ties the nickname directly to Kyjov, the meaning would simply be: Čeresare = an old neighbourly or ethnographic nickname for the people of Kyjov, probably from their traditional men’s dress.</p>
<h2>One detail that may matter</h2>
<p>A čeres was not only a decorative piece of costume. It was tied to herding, forest work, physical strength and mountain life. It protected the waist in practice, and money and small items were carried in it. In folk culture it also took on a symbolic meaning of strength and appears in outlaw traditions.</p>
<p>So if neighbours called the people of a village Čeresare, it may have meant not only “those with the belts,” but also marked a community with a more archaic mountain dress or a pastoral culture. That would fit Kyjov under Minčol and its traditional forest and Wallachian economy well: the village history records agriculture, cattle-raising, seasonal forest work and charcoal-burning. That last link, however, is an interpretation, not yet a direct statement from a source.</p>

<p><em>This is a reading of publicly available ethnographic and municipal sources, and a working etymological interpretation. It is not a closed historical verdict on the origin of one village’s nickname.</em></p>
HTML,
        ],
        'cs' => [
            'title' => 'Čeresare z Kyjova: co o přezdívce víme a co zatím ne',
            'image_alt' => 'Široký kožený mužský opasek čeres s několika přezkami a cvočky na dřevě, v pozadí mlhavé karpatské svahy ve fialovém a tyrkysovém světle.',
            'excerpt' => 'Výraz čeresare je doložen v etnografii Rusínů východního Slovenska, pravděpodobně podle širokého koženého opasku. Kyjov do tohoto prostoru zapadá, ale ztotožnění Čeresarů s Kyjovčany zatím není primárně doložené.',
            'content' => <<<'HTML'
<p>„Čeresare“ s velkou pravděpodobností neoznačuje zvláštní etnickou skupinu Rusínů ani Lemků. Jde spíš o starou kolektivní přezdívku obyvatel určité rusínské obce nebo místní skupiny, odvozenou od charakteristické součásti mužského oděvu — takzvaného <em>čeresa</em>.</p>
<h2>Co byl čeres</h2>
<p>Čeres byl široký kožený mužský opasek typický pro horské oblasti Karpat. Nebyl to obyčejný řemen na kalhoty. Vyráběl se ze širokého pásu kůže, často se zapínal na několik přezek, mohl mít vnitřní kapsu a býval zdobený vybíjením, kovovými cvočky, ornamenty či řemínky. Prakticky zpevňoval bedra při těžké práci a chránil tělo. <a href="https://www.ludovakultura.sk/polozka-encyklopedie/opasok">Centrum pro tradiční lidovou kulturu</a> ho přímo uvádí jako „opasek (čeres)“ a konstatuje, že se nosil v horských oblastech Slovenska.</p>
<p>Etnografické prameny dokládají obdobný <em>черес</em> / <em>cheres</em> i mezi Lemky, Rusíny, Huculy a dalšími karpatskými skupinami. Z jazykového hlediska tedy velmi přirozeně vzniká řetězec: čeres → člověk charakteristický nošením čeresa → čeresar → množné čeresare. Podobně jako jiná místní pojmenování končící na <em>-are</em>.</p>
<h2>Nejdůležitější nález</h2>
<p>Výraz „čeresare“ je skutečně doložen v odborné etnografické literatuře o Rusínech východního Slovenska. Etnografka Nadežda Varcholová ve své publikaci <em>Odkiaľ a kedy…</em>, vydané Slovenským národním muzeem — Muzeem ukrajinské kultury, popisuje staré lidové přezdívky rusínských obcí. <a href="https://www.snm.sk/muzea-snm/muzeum-ukrajinskej-kultury/galeria-dezidera-millyho/objavujte/publikacie?produkt=odkial-a-kedy">SNM při charakteristice knihy</a> píše, že tyto přezdívky vznikaly mimo jiné podle „nářečních a národopisných (oděv, strava apod.) zvláštností“ a mezi příklady uvádí přímo „hurňare, čeresare, mačankoše“.</p>
<p>To je podstatné. Znamená to, že <em>čeresare</em> je autentický etnografický výraz z prostředí Rusínů severovýchodního Slovenska — ne novodobý výmysl ani zkomolenina.</p>
<h2>Jsou Čeresare právě obyvatelé Kyjova?</h2>
<p>Tady musím být zatím opatrný. Potvrzené mám tři věci:</p>
<ol>
<li>„čeresare“ byla lidová přezdívka určité rusínské místní komunity;</li>
<li>pravděpodobně souvisela s oděvem, protože Varcholová ji řadí mezi přezdívky odvozené od nářečních a národopisných — zejména oděvních nebo stravovacích — zvláštností;</li>
<li>čeres je právě takový typický prvek mužského karpatského oděvu, takže etymologické spojení „čeresare = nositelé čeresů“ je velmi silné.</li>
</ol>
<p>Veřejně dostupný internetový popis Varcholové knihy však neuvádí, ke které konkrétní obci se přezdívka váže. Na to by bylo třeba dostat se k samotnému heslu v knize. Proto zatím nechci kategoricky tvrdit: „Čeresare = Kyjovčané.“ Je to možné a vzhledem ke kontextu i dost pravděpodobné, ale zatím to nemám doložené primárním zápisem.</p>
<h2>Kyjov do tohoto kulturního prostoru velmi dobře zapadá</h2>
<p>U samotného Kyjova máme poměrně jednoznačnou historickou kontinuitu rusínského osídlení. <a href="https://www.obec-kyjov.sk/p/6367/historia-obce.html">Oficiální historie obce</a> uvádí, že v soupisu z roku 1538 je Kyjov veden jako rusínská obec. Koncem 16. století tu žilo rolnické a valašské obyvatelstvo slovenského a rusínského původu.</p>
<p>Místní tradice zachovala legendu, podle níž obec založilo šest Rusínů přicházejících z Kyjeva; obec samotná správně upozorňuje, že jde o legendu, ne o historicky doložený fakt. Zajímavé je i to, že Varcholová ve své knize zmiňuje Kyjov přímo mezi obcemi, jejichž název lidové podání vysvětlovalo přistěhovalci. Kyjov tedy rozhodně patří do geografického a kulturního materiálu, který zkoumala.</p>
<h2>Rusín, Rusnák a Lemko</h2>
<p>Tady se vyplatí rozlišovat několik úrovní. <em>Rusnák</em> je tradiční lidové pojmenování člověka rusínského obyvatelstva, které se na severovýchodě Slovenska používalo a používá dodnes. <em>Rusín</em> je širší etnické pojmenování. <em>Lemko</em> je regionální karpatská skupina v severní a severovýchodní části karpatského rusínského prostoru. Hranice mezi tím, koho historické prameny označovaly jako Lemka a koho jako Rusnáka nebo Rusína, nejsou vždy totožné s dnešními národnostními kategoriemi.</p>
<p>A Čeresare podle všeho představují ještě o úroveň nižší označení: ne národ ani etnografickou makroskupinu, ale místní vesnickou přezdívku. Schematicky: Rusíni / Rusnáci → regionální karpatské skupiny včetně Lemků → konkrétní vesnice → vesnické přezdívky typu Čeresare, Hurňare, Mačankoše, Potičkare, Kavkare…</p>
<p>Takové přezdívky byly v tradiční vesnické kultuře velmi důležité. Sousední vesnice podle nich okamžitě věděly, odkud člověk pochází. Často byly humorné, ironické, někdy mírně posměšné; postupem času mohly fungovat téměř jako místní ethnonymum.</p>
<h2>Co pravděpodobně znamenalo „Čeresare“</h2>
<p>Na základě kombinace pramenů bych pracovní interpretaci formuloval takto: Čeresare byli lidovým pojmenováním obyvatel jedné z rusínských obcí severovýchodního Slovenska, pravděpodobně podle charakteristického nošení širokého koženého mužského opasku nazývaného čeres. Nešlo o samostatný rusínský nebo lemkovský kmen či etnickou skupinu.</p>
<p>Pokud se potvrdí, že Varcholová váže tuto přezdívku přímo na Kyjov, význam by byl jednoduchý: Čeresare = stará sousedská nebo národopisná přezdívka Kyjovčanů, pravděpodobně podle jejich tradičního mužského oděvu.</p>
<h2>Jeden detail, který může být zajímavý</h2>
<p>Čeres nebyl jen dekorativní kus kroje. Byl to předmět spojený s pastevectvím, lesní prací, fyzickou silou a horským způsobem života. Měl praktickou funkci při ochraně beder a nosily se v něm peníze a drobné předměty. V lidové kultuře získal i symbolický význam síly a objevuje se ve zbojnických tradicích.</p>
<p>Pokud tedy sousedé nazývali obyvatele určité vesnice Čeresary, mohlo to znamenat nejen „ti s opasky“, ale i identifikovat komunitu charakteristickou archaičtějším horským oděvem nebo pasteveckou kulturou. To by ke Kyjovu pod Minčolem a k tradičnímu lesnímu a valašskému hospodářství velmi dobře pasovalo: historie obce uvádí zemědělství, chov dobytka, sezónní práci v lesích a pálení dřeva. Toto poslední spojení je však interpretace, ne zatím přímo doložený výrok pramene.</p>

<p><em>Jde o čtení veřejně dostupných etnografických a obecních pramenů a o pracovní etymologickou interpretaci. Není to uzavřený historický verdikt o původu přezdívky konkrétní obce.</em></p>
HTML,
        ],
        'de' => [
            'title' => 'Die Čeresare von Kyjov: was wir über den Spitznamen wissen — und was noch nicht',
            'image_alt' => 'Ein breiter Männerledergürtel, ein Čeres, mit mehreren Schnallen und Nieten auf Holz, dahinter neblige Karpatenhänge in violettem und türkisem Licht.',
            'excerpt' => 'Čeresare ist in der Ethnografie der Russinen der Ostslowakei belegt, wahrscheinlich nach dem breiten Ledergürtel. Kyjov passt in diesen Raum, doch die Gleichsetzung mit den Kyjovčania ist noch nicht primär belegt.',
            'content' => <<<'HTML'
<p>„Čeresare“ bezeichnet mit großer Wahrscheinlichkeit keine eigene ethnische Gruppe der Russinen oder Lemken. Es handelt sich eher um einen alten kollektiven Spitznamen für die Bewohner eines bestimmten russinischen Dorfes oder einer lokalen Gruppe, abgeleitet von einem charakteristischen Teil der Männertracht — dem sogenannten <em>Čeres</em>.</p>
<h2>Was ein Čeres war</h2>
<p>Ein Čeres war ein breiter lederner Männergürtel, typisch für die Bergregionen der Karpaten. Er war kein gewöhnlicher Hosengürtel. Er wurde aus einem breiten Lederstreifen gefertigt, oft mit mehreren Schnallen geschlossen, konnte eine Innentasche haben und war mit Treibarbeit, Metallnieten, Ornamenten oder Riemchen verziert. Praktisch stützte er die Lende bei schwerer Arbeit und schützte den Körper. Das <a href="https://www.ludovakultura.sk/polozka-encyklopedie/opasok">Zentrum für traditionelle Volkskultur</a> führt ihn direkt als „Gürtel (čeres)“ und stellt fest, dass er in den Berggebieten der Slowakei getragen wurde.</p>
<p>Ethnographische Quellen belegen einen entsprechenden <em>черес</em> / <em>cheres</em> auch bei Lemken, Russinen, Huzulen und anderen karpatischen Gruppen. Sprachlich entsteht damit ganz natürlich die Kette: Čeres → Mensch, der durch das Tragen eines Čeres gekennzeichnet ist → Čeresar → Plural Čeresare — ähnlich anderen lokalen Namen auf <em>-are</em>.</p>
<h2>Der wichtigste Fund</h2>
<p>Der Ausdruck „čeresare“ ist tatsächlich in der fachlichen ethnographischen Literatur über die Russinen der Ostslowakei belegt. Die Ethnographin Nadežda Varcholová beschreibt in ihrer beim Slowakischen Nationalmuseum — Museum der ukrainischen Kultur erschienenen Publikation <em>Odkiaľ a kedy…</em> alte volkstümliche Spitznamen russinischer Dörfer. <a href="https://www.snm.sk/muzea-snm/muzeum-ukrajinskej-kultury/galeria-dezidera-millyho/objavujte/publikacie?produkt=odkial-a-kedy">Das SNM schreibt in der Buchbeschreibung</a>, diese Spitznamen seien unter anderem nach „dialektalen und volkskundlichen (Tracht, Speise u. ä.) Besonderheiten“ entstanden und nennt unter den Beispielen direkt „hurňare, čeresare, mačankoše“.</p>
<p>Das ist wesentlich. Es bedeutet, dass <em>čeresare</em> ein authentischer ethnographischer Ausdruck aus der Welt der Russinen Nordostslowakeis ist — keine moderne Erfindung und keine Verballhornung.</p>
<h2>Sind die Čeresare gerade die Bewohner von Kyjov?</h2>
<p>Hier muss ich vorerst vorsichtig sein. Drei Dinge sind bestätigt:</p>
<ol>
<li>„čeresare“ war ein volkstümlicher Spitzname einer bestimmten lokalen russinischen Gemeinschaft;</li>
<li>er hing wahrscheinlich mit der Tracht zusammen, weil Varcholová ihn unter die von dialektalen und volkskundlichen — vor allem tracht- oder speisebezogenen — Besonderheiten abgeleiteten Spitznamen stellt;</li>
<li>der Čeres ist genau ein solches typisches Element der karpatischen Männertracht, sodass die etymologische Verbindung „Čeresare = Träger von Čeres-Gürteln“ sehr stark ist.</li>
</ol>
<p>Die öffentlich zugängliche Internetbeschreibung von Varcholovás Buch nennt jedoch nicht, an welches konkrete Dorf der Spitzname gebunden ist. Dafür bräuchte man den Eintrag im Buch selbst. Deshalb will ich vorerst nicht kategorisch behaupten: „Čeresare = die Leute von Kyjov.“ Es ist möglich und angesichts des Kontexts sogar recht wahrscheinlich, aber ich habe es noch nicht durch einen Primäreintrag belegt.</p>
<h2>Kyjov passt sehr gut in diesen Kulturraum</h2>
<p>Für Kyjov selbst haben wir eine recht klare historische Kontinuität russinischer Besiedlung. Die <a href="https://www.obec-kyjov.sk/p/6367/historia-obce.html">offizielle Ortsgeschichte</a> führt an, dass Kyjov im Verzeichnis von 1538 als russinisches Dorf geführt wird. Ende des 16. Jahrhunderts lebte dort bäuerliche und walachische Bevölkerung slowakischer und russinischer Herkunft.</p>
<p>Die örtliche Überlieferung bewahrt die Legende, das Dorf sei von sechs aus Kiew kommenden Russinen gegründet worden; die Gemeinde selbst weist zu Recht darauf hin, dass es sich um eine Legende handelt, nicht um einen historisch belegten Fakt. Bemerkenswert ist auch, dass Varcholová Kyjov unter den Orten nennt, deren Namen die Volksüberlieferung mit Zuwanderern erklärte. Kyjov gehört also klar zu dem geographischen und kulturellen Material, das sie untersuchte.</p>
<h2>Russine, Rusnák und Lemke</h2>
<p>Hier lohnt es sich, mehrere Ebenen zu unterscheiden. <em>Rusnák</em> ist die traditionelle volkstümliche Bezeichnung für einen Menschen der russinischen Bevölkerung, die im Nordosten der Slowakei verwendet wurde und wird. <em>Russine</em> ist die breitere ethnische Bezeichnung. <em>Lemke</em> ist eine regionale karpatische Gruppe im nördlichen und nordöstlichen Teil des karpatischen russinischen Raums. Die Grenzen dessen, wen historische Quellen als Lemken und wen als Rusnák oder Russinen bezeichneten, sind nicht immer mit heutigen Nationalitätskategorien identisch.</p>
<p>Und die Čeresare stellen allem Anschein nach noch eine Stufe tiefer dar: weder Nation noch ethnographische Makrogruppe, sondern einen lokalen Dorfspitznamen. Schematisch: Russinen / Rusnáks → regionale karpatische Gruppen einschließlich Lemken → konkrete Dörfer → Dorfspitznamen vom Typ Čeresare, Hurňare, Mačankoše, Potičkare, Kavkare…</p>
<p>Solche Spitznamen waren in der traditionellen Dorfkultur sehr wichtig. Nachbarorte wussten danach sofort, woher jemand kam. Oft waren sie humorvoll, ironisch, manchmal leicht spöttisch; mit der Zeit konnten sie beinahe als lokales Ethnonym funktionieren.</p>
<h2>Was „Čeresare“ wahrscheinlich bedeutete</h2>
<p>Aus der Kombination der Quellen würde ich die Arbeitshypothese so formulieren: Die Čeresare waren die volkstümliche Bezeichnung für die Bewohner eines der russinischen Dörfer Nordostslowakeis, wahrscheinlich nach dem charakteristischen Tragen des breiten ledernen Männergürtels namens Čeres. Es handelte sich nicht um einen eigenen russinischen oder lemkischen Stamm oder eine ethnische Gruppe.</p>
<p>Bestätigt sich, dass Varcholová diesen Spitznamen direkt an Kyjov bindet, wäre die Bedeutung einfach: Čeresare = alter nachbarschaftlicher oder volkskundlicher Spitzname der Kyjovčania, wahrscheinlich nach ihrer traditionellen Männertracht.</p>
<h2>Ein Detail, das interessant sein kann</h2>
<p>Der Čeres war nicht nur ein dekoratives Trachtstück. Er hing mit Hirtenwesen, Waldarbeit, Körperkraft und bergischem Leben zusammen. Er hatte eine praktische Schutzfunktion für die Lende; Geld und Kleinteile wurden darin getragen. In der Volkskultur gewann er auch symbolische Bedeutung von Kraft und erscheint in Räubertraditionen.</p>
<p>Wenn Nachbarn also die Bewohner eines Dorfes Čeresare nannten, konnte das nicht nur „die mit den Gürteln“ bedeuten, sondern auch eine Gemeinschaft mit archaischerer Bergtracht oder Hirtenkultur markieren. Das würde zu Kyjov unter dem Minčol und zur traditionellen Wald- und Walachenwirtschaft gut passen: die Ortsgeschichte nennt Landwirtschaft, Viehzucht, saisonale Waldarbeit und Holzkohlenbrennen. Diese letzte Verbindung ist jedoch Interpretation, noch kein direkt belegter Quellensatz.</p>

<p><em>Es handelt sich um die Lektüre öffentlich zugänglicher ethnographischer und gemeindlicher Quellen und um eine arbeitende etymologische Interpretation. Es ist kein abgeschlossenes historisches Urteil über den Ursprung des Spitznamens eines konkreten Dorfes.</em></p>
HTML,
        ],
        'fr' => [
            'title' => 'Les Čeresare de Kyjov : ce que l’on sait du sobriquet, et ce qu’on ignore encore',
            'image_alt' => 'Large ceinture de cuir masculine, un čeres, à plusieurs boucles et clous sur du bois, pentes carpatiques brumeuses derrière dans une lumière violette et turquoise.',
            'excerpt' => 'Čeresare est attesté dans l’ethnographie des Ruthènes de Slovaquie orientale, sans doute d’après la large ceinture de cuir. Kyjov entre dans cet espace, mais l’équation avec les gens de Kyjov n’est pas encore étayée par une entrée primaire.',
            'content' => <<<'HTML'
<p>« Čeresare » ne désigne très probablement pas un groupe ethnique distinct de Ruthènes ou de Lemkos. C’est plutôt un ancien sobriquet collectif pour les habitants d’un village ruthène ou d’un groupe local particulier, dérivé d’une pièce caractéristique du costume masculin — le <em>čeres</em>.</p>
<h2>Ce qu’était un čeres</h2>
<p>Le čeres était une large ceinture de cuir masculine typique des régions montagneuses des Carpates. Ce n’était pas une simple ceinture de pantalon. Elle était faite d’une large bande de cuir, souvent fermée par plusieurs boucles, pouvait avoir une poche intérieure et était ornée de martelage, de clous métalliques, d’ornements ou de lanières. En pratique, elle renforçait les reins au travail dur et protégeait le corps. Le <a href="https://www.ludovakultura.sk/polozka-encyklopedie/opasok">Centre de la culture populaire traditionnelle</a> la présente directement comme « ceinture (čeres) » et note qu’on la portait dans les régions montagneuses de Slovaquie.</p>
<p>Les sources ethnographiques attestent un <em>черес</em> / <em>cheres</em> analogue chez les Lemkos, les Ruthènes, les Houtsoules et d’autres groupes carpatiques. Linguistiquement, la chaîne est naturelle : čeres → personne marquée par le port du čeres → čeresar → pluriel čeresare — comme d’autres noms locaux en <em>-are</em>.</p>
<h2>La découverte essentielle</h2>
<p>Le mot « čeresare » est réellement attesté dans la littérature ethnographique savante sur les Ruthènes de Slovaquie orientale. Dans <em>Odkiaľ a kedy…</em>, publiée par le Musée national slovaque — Musée de la culture ukrainienne, l’ethnographe Nadežda Varcholová décrit d’anciens sobriquets populaires de villages ruthènes. <a href="https://www.snm.sk/muzea-snm/muzeum-ukrajinskej-kultury/galeria-dezidera-millyho/objavujte/publikacie?produkt=odkial-a-kedy">La présentation SNM du livre</a> indique que ces sobriquets naissaient notamment de « particularités dialectales et ethnographiques (costume, nourriture, etc.) » et cite directement parmi les exemples « hurňare, čeresare, mačankoše ».</p>
<p>C’est essentiel. Cela signifie que <em>čeresare</em> est un terme ethnographique authentique du monde ruthène du nord-est de la Slovaquie — ni invention moderne ni déformation.</p>
<h2>Les Čeresare sont-ils précisément les gens de Kyjov ?</h2>
<p>Ici je dois encore rester prudent. Trois choses sont confirmées :</p>
<ol>
<li>« čeresare » était un sobriquet populaire d’une communauté ruthène locale particulière ;</li>
<li>il se rattachait probablement au costume, car Varcholová le range parmi les sobriquets dérivés de particularités dialectales et ethnographiques — surtout vestimentaires ou alimentaires ;</li>
<li>le čeres est précisément ce type d’élément typique du costume masculin carpatique, si bien que le lien étymologique « čeresare = porteurs de čeres » est très fort.</li>
</ol>
<p>La description internet publique du livre de Varcholová n’indique toutefois pas à quel village concret le sobriquet se rattache. Il faudrait pour cela l’entrée du livre elle-même. Je ne veux donc pas encore affirmer catégoriquement : « Čeresare = habitants de Kyjov. » C’est possible, et vu le contexte assez probable, mais je ne l’ai pas encore d’un enregistrement primaire.</p>
<h2>Kyjov entre très bien dans cet espace culturel</h2>
<p>Pour Kyjov lui-même, nous avons une continuité historique assez claire de peuplement ruthène. L’<a href="https://www.obec-kyjov.sk/p/6367/historia-obce.html">histoire officielle de la commune</a> indique qu’au registre de 1538 Kyjov figure comme village ruthène. À la fin du XVIe siècle y vivaient des populations agricoles et valaques d’origine slovaque et ruthène.</p>
<p>La tradition locale a conservé la légende selon laquelle le village fut fondé par six Ruthènes venus de Kiev ; la commune elle-même rappelle à juste titre qu’il s’agit d’une légende, non d’un fait historiquement établi. Il est aussi intéressant que Varcholová mentionne Kyjov parmi les villages dont le nom était expliqué par la tradition populaire comme venant d’immigrants. Kyjov appartient donc clairement au matériau géographique et culturel qu’elle a étudié.</p>
<h2>Ruthène, Rusnák et Lemko</h2>
<p>Il vaut la peine de distinguer plusieurs niveaux. <em>Rusnák</em> est le nom populaire traditionnel d’une personne de la population ruthène, encore utilisé dans le nord-est de la Slovaquie. <em>Ruthène</em> est le nom ethnique plus large. <em>Lemko</em> est un groupe carpatique régional dans la partie nord et nord-est de l’espace ruthène carpatique. Les frontières entre qui les sources historiques appelaient Lemko et qui Rusnák ou Ruthène ne coïncident pas toujours avec les catégories nationales d’aujourd’hui.</p>
<p>Et les Čeresare, selon toute apparence, représentent encore un niveau plus bas : ni nation ni macrogroupe ethnographique, mais un sobriquet villageois local. Schématiquement : Ruthènes / Rusnáks → groupes carpatiques régionaux y compris Lemkos → villages concrets → sobriquets villageois du type Čeresare, Hurňare, Mačankoše, Potičkare, Kavkare…</p>
<p>Ces sobriquets comptaient beaucoup dans la culture villageoise traditionnelle. Les villages voisins savaient aussitôt d’où venait quelqu’un. Ils étaient souvent humoristiques, ironiques, parfois un peu moqueurs ; avec le temps, ils pouvaient presque fonctionner comme ethnonym local.</p>
<h2>Ce que « Čeresare » signifiait probablement</h2>
<p>À partir des sources combinées, je formulerais l’interprétation de travail ainsi : les Čeresare étaient le nom populaire des habitants de l’un des villages ruthènes du nord-est de la Slovaquie, probablement d’après le port caractéristique de la large ceinture de cuir masculine appelée čeres. Ce n’était pas une tribu ou un groupe ethnique ruthène ou lemko distinct.</p>
<p>Si l’on confirme que Varcholová rattache ce sobriquet directement à Kyjov, le sens serait simple : Čeresare = ancien sobriquet de voisinage ou ethnographique des habitants de Kyjov, probablement d’après leur costume masculin traditionnel.</p>
<h2>Un détail qui peut compter</h2>
<p>Le čeres n’était pas seulement une pièce décorative du costume. Il était lié au pastoralisme, au travail forestier, à la force physique et à la vie montagnarde. Il avait une fonction pratique de protection des reins ; on y portait argent et petits objets. Dans la culture populaire, il a aussi pris une valeur symbolique de force et apparaît dans les traditions de brigands.</p>
<p>Si donc les voisins appelaient les habitants d’un village Čeresare, cela pouvait signifier non seulement « ceux aux ceintures », mais aussi marquer une communauté au costume montagnard plus archaïque ou à culture pastorale. Cela irait bien avec Kyjov au pied du Minčol et avec son économie forestière et valaque traditionnelle : l’histoire communale mentionne l’agriculture, l’élevage, le travail saisonnier en forêt et le chauffage du bois. Ce dernier lien est toutefois une interprétation, pas encore un énoncé de source directement attesté.</p>

<p><em>Il s’agit d’une lecture de sources ethnographiques et communales publiquement disponibles, et d’une interprétation étymologique de travail. Ce n’est pas un verdict historique clos sur l’origine du sobriquet d’un village précis.</em></p>
HTML,
        ],
        'es' => [
            'title' => 'Los Čeresare de Kyjov: lo que sabemos del apodo y lo que aún no',
            'image_alt' => 'Ancho cinturón de cuero masculino, un čeres, con varias hebillas y tachuelas sobre madera, laderas cárpaticas brumosas detrás en luz violeta y turquesa.',
            'excerpt' => 'Čeresare está documentado en la etnografía de los rutenos del este de Eslovaquia, probablemente por el ancho cinturón de cuero. Kyjov encaja en ese espacio, pero igualarlo con la gente de Kyjov aún no tiene respaldo primario.',
            'content' => <<<'HTML'
<p>«Čeresare» con gran probabilidad no designa un grupo étnico distinto de rutenos o lemko. Es más bien un antiguo apodo colectivo de los habitantes de cierta aldea rutena o grupo local, derivado de una pieza característica de la vestimenta masculina: el llamado <em>čeres</em>.</p>
<h2>Qué era un čeres</h2>
<p>El čeres era un ancho cinturón de cuero masculino típico de las zonas montañosas de los Cárpatos. No era un cinturón ordinario de pantalón. Se hacía de una ancha tira de cuero, a menudo se abrochaba con varias hebillas, podía tener un bolsillo interior y se adornaba con repujado, tachuelas metálicas, ornamentos o correas. En la práctica reforzaba la cintura en el trabajo duro y protegía el cuerpo. El <a href="https://www.ludovakultura.sk/polozka-encyklopedie/opasok">Centro de Cultura Popular Tradicional</a> lo presenta directamente como «cinturón (čeres)» y señala que se llevaba en las zonas montañosas de Eslovaquia.</p>
<p>Las fuentes etnográficas documentan un <em>черес</em> / <em>cheres</em> análogo entre lemko, rutenos, hutsules y otros grupos cárpaticos. Lingüísticamente la cadena es natural: čeres → persona marcada por llevar un čeres → čeresar → plural čeresare, como otros nombres locales en <em>-are</em>.</p>
<h2>El hallazgo más importante</h2>
<p>La expresión «čeresare» está realmente documentada en la literatura etnográfica especializada sobre los rutenos del este de Eslovaquia. En <em>Odkiaľ a kedy…</em>, publicada por el Museo Nacional Eslovaco — Museo de Cultura Ucraniana, la etnógrafa Nadežda Varcholová describe antiguos apodos populares de aldeas rutenas. <a href="https://www.snm.sk/muzea-snm/muzeum-ukrajinskej-kultury/galeria-dezidera-millyho/objavujte/publikacie?produkt=odkial-a-kedy">La descripción del SNM del libro</a> dice que estos apodos surgían, entre otras cosas, de «peculiaridades dialectales y etnográficas (vestimenta, comida, etc.)» y entre los ejemplos cita directamente «hurňare, čeresare, mačankoše».</p>
<p>Eso es esencial. Significa que <em>čeresare</em> es un término etnográfico auténtico del mundo ruteno del noreste de Eslovaquia: no una invención moderna ni una deformación.</p>
<h2>¿Son los Čeresare precisamente los habitantes de Kyjov?</h2>
<p>Aquí debo seguir siendo prudente. Tengo confirmadas tres cosas:</p>
<ol>
<li>«čeresare» era un apodo popular de cierta comunidad rutena local;</li>
<li>probablemente se relacionaba con la vestimenta, porque Varcholová lo sitúa entre los apodos derivados de peculiaridades dialectales y etnográficas —sobre todo de vestimenta o comida—;</li>
<li>el čeres es exactamente ese tipo de elemento típico de la vestimenta masculina cárpatica, de modo que el vínculo etimológico «čeresare = portadores de čeres» es muy fuerte.</li>
</ol>
<p>La descripción pública en internet del libro de Varcholová no indica, sin embargo, a qué aldea concreta se liga el apodo. Para eso haría falta la entrada del propio libro. Por eso aún no quiero afirmar de forma categórica: «Čeresare = gente de Kyjov.» Es posible y, dado el contexto, bastante probable, pero aún no lo tengo documentado con un registro primario.</p>
<h2>Kyjov encaja muy bien en este espacio cultural</h2>
<p>En el propio Kyjov tenemos una continuidad histórica bastante clara de asentamiento ruteno. La <a href="https://www.obec-kyjov.sk/p/6367/historia-obce.html">historia oficial de la aldea</a> indica que en el registro de 1538 Kyjov figura como aldea rutena. A finales del siglo XVI vivía allí población campesina y valaca de origen eslovaco y ruteno.</p>
<p>La tradición local conserva la leyenda de que la aldea la fundaron seis rutenos llegados de Kiev; el propio municipio advierte con razón que es una leyenda, no un hecho históricamente documentado. También es interesante que Varcholová mencione Kyjov entre las aldeas cuyo nombre la tradición popular explicaba por inmigrantes. Kyjov pertenece, pues, claramente al material geográfico y cultural que ella estudió.</p>
<h2>Ruteno, Rusnák y Lemko</h2>
<p>Conviene distinguir varios niveles. <em>Rusnák</em> es el nombre popular tradicional de una persona de la población rutena, usado y aún usado en el noreste de Eslovaquia. <em>Ruteno</em> es el nombre étnico más amplio. <em>Lemko</em> es un grupo cárpatico regional en la parte norte y noreste del espacio ruteno cárpatico. Los límites entre a quién las fuentes históricas llamaban lemko y a quién rusnák o ruteno no siempre coinciden con las categorías nacionales de hoy.</p>
<p>Y los Čeresare, según todo indica, representan aún un nivel más bajo: ni nación ni macrogrupo etnográfico, sino un apodo aldeano local. Esquemáticamente: rutenos / rusnáks → grupos cárpaticos regionales incluidos los lemko → aldeas concretas → apodos aldeanos del tipo Čeresare, Hurňare, Mačankoše, Potičkare, Kavkare…</p>
<p>Esos apodos eran muy importantes en la cultura aldeana tradicional. Las aldeas vecinas sabían al instante de dónde venía alguien. A menudo eran humorísticos, irónicos, a veces ligeramente burlones; con el tiempo podían funcionar casi como etónimo local.</p>
<h2>Qué significaba probablemente «Čeresare»</h2>
<p>A partir de la combinación de fuentes formularía la interpretación de trabajo así: los Čeresare eran el nombre popular de los habitantes de una de las aldeas rutenas del noreste de Eslovaquia, probablemente por el uso característico del ancho cinturón de cuero masculino llamado čeres. No se trataba de una tribu o grupo étnico ruteno o lemko aparte.</p>
<p>Si se confirma que Varcholová liga este apodo directamente a Kyjov, el sentido sería sencillo: Čeresare = antiguo apodo vecinal o etnográfico de la gente de Kyjov, probablemente por su vestimenta masculina tradicional.</p>
<h2>Un detalle que puede ser interesante</h2>
<p>El čeres no era solo una pieza decorativa del traje. Estaba ligado al pastoreo, al trabajo forestal, a la fuerza física y a la vida de montaña. Tenía una función práctica de protección de la cintura; en él se llevaban dinero y objetos pequeños. En la cultura popular adquirió también un significado simbólico de fuerza y aparece en tradiciones de bandoleros.</p>
<p>Así que si los vecinos llamaban Čeresare a los habitantes de cierta aldea, podía significar no solo «los de los cinturones», sino también identificar a una comunidad con vestimenta de montaña más arcaica o cultura pastoril. Eso encajaría muy bien con Kyjov bajo el Minčol y con su economía forestal y valaca tradicional: la historia de la aldea menciona agricultura, cría de ganado, trabajo estacional en los bosques y quema de madera. Este último vínculo es, sin embargo, una interpretación, no aún un enunciado de fuente directamente documentado.</p>

<p><em>Se trata de una lectura de fuentes etnográficas y municipales disponibles en público, y de una interpretación etimológica de trabajo. No es un veredicto histórico cerrado sobre el origen del apodo de una aldea concreta.</em></p>
HTML,
        ],
        'pl' => [
            'title' => 'Čeresare z Kyjova: co wiemy o przezwisku, a czego jeszcze nie',
            'image_alt' => 'Szeroki skórzany męski pas, čeres, z kilkoma klamrami i ćwiekami na drewnie, za nim mgliste zbocza karpackie w fioletowym i turkusowym świetle.',
            'excerpt' => 'Wyraz čeresare jest poświadczony w etnografii Rusinów wschodniej Słowacji, prawdopodobnie od szerokiego skórzanego pasa. Kyjov pasuje do tej przestrzeni, lecz utożsamienie Čeresarów z mieszkańcami Kyjova nie ma jeszcze pierwotnego zapisu.',
            'content' => <<<'HTML'
<p>„Čeresare” z dużym prawdopodobieństwem nie oznacza odrębnej grupy etnicznej Rusinów ani Łemków. To raczej stare zbiorowe przezwisko mieszkańców konkretnej rusińskiej wsi lub lokalnej grupy, wywiedzione od charakterystycznej części męskiego stroju — tak zwanego <em>čeresa</em>.</p>
<h2>Czym był čeres</h2>
<p>Čeres był szerokim skórzanym męskim pasem typowym dla górskich obszarów Karpat. Nie był zwykłym paskiem do spodni. Wyrabiano go z szerokiego pasa skóry, często zapinano na kilka klamer, mógł mieć wewnętrzną kieszonkę i bywał zdobiony wybiciem, metalowymi ćwiekami, ornamentami czy rzemykami. W praktyce wzmacniał biodra przy ciężkiej pracy i chronił ciało. <a href="https://www.ludovakultura.sk/polozka-encyklopedie/opasok">Centrum tradycyjnej kultury ludowej</a> podaje go wprost jako „pas (čeres)” i stwierdza, że noszono go w górskich regionach Słowacji.</p>
<p>Źródła etnograficzne poświadczają podobny <em>черес</em> / <em>cheres</em> także wśród Łemków, Rusinów, Hucułów i innych grup karpackich. Językowo więc bardzo naturalnie powstaje łańcuch: čeres → człowiek charakterystyczny noszeniem čeresa → čeresar → liczba mnoga čeresare — podobnie jak inne lokalne nazwy kończące się na <em>-are</em>.</p>
<h2>Najważniejsze znalezisko</h2>
<p>Wyraz „čeresare” jest rzeczywiście poświadczony w fachowej literaturze etnograficznej o Rusinach wschodniej Słowacji. Etnografka Nadežda Varcholová w publikacji <em>Odkiaľ a kedy…</em>, wydanej przez Słowackie Muzeum Narodowe — Muzeum Kultury Ukraińskiej, opisuje stare ludowe przezwiska rusińskich wsi. <a href="https://www.snm.sk/muzea-snm/muzeum-ukrajinskej-kultury/galeria-dezidera-millyho/objavujte/publikacie?produkt=odkial-a-kedy">SNM w charakterystyce książki</a> pisze, że przezwiska te powstawały m.in. według „dialektalnych i etnograficznych (strój, pożywienie itd.) osobliwości” i wśród przykładów podaje wprost „hurňare, čeresare, mačankoše”.</p>
<p>To jest istotne. Znaczy, że <em>čeresare</em> to autentyczny wyraz etnograficzny ze środowiska Rusinów północno-wschodniej Słowacji — nie nowomodny wymysł ani zniekształcenie.</p>
<h2>Czy Čeresare to właśnie mieszkańcy Kyjova?</h2>
<p>Tu muszę na razie być ostrożny. Potwierdzone mam trzy rzeczy:</p>
<ol>
<li>„čeresare” było ludowym przezwiskiem konkretnej lokalnej społeczności rusińskiej;</li>
<li>prawdopodobnie wiązało się ze strojem, bo Varcholová umieszcza je wśród przezwisk wywodzonych od dialektalnych i etnograficznych — zwłaszcza strojowych lub żywieniowych — osobliwości;</li>
<li>čeres jest właśnie takim typowym elementem męskiego stroju karpackiego, więc etymologiczne połączenie „čeresare = nosiciele čeresów” jest bardzo silne.</li>
</ol>
<p>Publicznie dostępny internetowy opis książki Varcholovej nie podaje jednak, do której konkretnej wsi przezwisko się odnosi. Do tego trzeba by dotrzeć do samego hasła w książce. Dlatego na razie nie chcę kategorycznie twierdzić: „Čeresare = mieszkańcy Kyjova.” Jest to możliwe i ze względu na kontekst nawet dość prawdopodobne, ale na razie nie mam tego poświadczonego pierwotnym zapisem.</p>
<h2>Kyjov bardzo dobrze wpisuje się w tę przestrzeń kulturową</h2>
<p>Przy samym Kyjovie mamy dość jednoznaczną historyczną ciągłość osadnictwa rusińskiego. <a href="https://www.obec-kyjov.sk/p/6367/historia-obce.html">Oficjalna historia gminy</a> podaje, że w spisie z 1538 roku Kyjov figuruje jako wieś rusińska. Pod koniec XVI wieku mieszkała tu ludność rolnicza i wołoska pochodzenia słowackiego i rusińskiego.</p>
<p>Lokalna tradycja zachowała legendę, według której wieś założyło sześciu Rusinów przybyłych z Kijowa; sama gmina słusznie zaznacza, że to legenda, nie fakt historycznie udokumentowany. Ciekawe jest też, że Varcholová w swojej książce wymienia Kyjov wprost wśród wsi, których nazwę ludowe podanie tłumaczyło przybyszami. Kyjov zatem zdecydowanie należy do materiału geograficznego i kulturowego, który badała.</p>
<h2>Rusin, Rusnak i Łemko</h2>
<p>Tu warto rozróżniać kilka poziomów. <em>Rusnak</em> to tradycyjne ludowe określenie człowieka ludności rusińskiej, używane i nadal używane na północnym wschodzie Słowacji. <em>Rusin</em> to szersze określenie etniczne. <em>Łemko</em> to regionalna grupa karpacka w północnej i północno-wschodniej części karpackiej przestrzeni rusińskiej. Granice między tym, kogo źródła historyczne nazywały Łemkiem, a kogo Rusnakiem lub Rusinem, nie zawsze pokrywają się z dzisiejszymi kategoriami narodowościowymi.</p>
<p>A Čeresare według wszystkiego stanowią jeszcze stopień niżej: nie naród ani makrogrupę etnograficzną, lecz lokalne wiejskie przezwisko. Schematycznie: Rusini / Rusnacy → regionalne grupy karpackie w tym Łemkowie → konkretne wsie → wiejskie przezwiska typu Čeresare, Hurňare, Mačankoše, Potičkare, Kavkare…</p>
<p>Takie przezwiska były w tradycyjnej kulturze wiejskiej bardzo ważne. Sąsiednie wsie od razu wiedziały, skąd kto pochodzi. Często były humorystyczne, ironiczne, czasem lekko drwiące; z czasem mogły działać niemal jak lokalne etnonim.</p>
<h2>Co prawdopodobnie znaczyło „Čeresare”</h2>
<p>Na podstawie połączenia źródeł sformułowałbym roboczą interpretację tak: Čeresare były ludowym określeniem mieszkańców jednej z rusińskich wsi północno-wschodniej Słowacji, prawdopodobnie według charakterystycznego noszenia szerokiego skórzanego męskiego pasa zwanego čeres. Nie chodziło o osobne plemię ani grupę etniczną rusińską lub łemkowską.</p>
<p>Jeśli potwierdzi się, że Varcholová wiąże to przezwisko wprost z Kyjovem, znaczenie byłoby proste: Čeresare = stare sąsiedzkie lub etnograficzne przezwisko mieszkańców Kyjova, prawdopodobnie według ich tradycyjnego męskiego stroju.</p>
<h2>Jeden szczegół, który może być ciekawy</h2>
<p>Čeres nie był tylko dekoracyjnym elementem stroju. Był przedmiotem związanym z pasterstwem, pracą leśną, siłą fizyczną i górskim trybem życia. Miał praktyczną funkcję ochrony bioder; noszono w nim pieniądze i drobne przedmioty. W kulturze ludowej zyskał też symboliczne znaczenie siły i pojawia się w tradycjach zbójnickich.</p>
<p>Jeśli więc sąsiedzi nazywali mieszkańców danej wsi Čeresarami, mogło to oznaczać nie tylko „tych z pasami”, lecz także identyfikować wspólnotę o bardziej archaicznym stroju górskim lub kulturze pasterskiej. To bardzo dobrze pasowałoby do Kyjova pod Minčolem i do tradycyjnej gospodarki leśnej i wołoskiej: historia wsi wymienia rolnictwo, hodowlę bydła, sezonową pracę w lasach i wypalanie drewna. To ostatnie połączenie jest jednak interpretacją, nie jeszcze bezpośrednio poświadczonym stwierdzeniem źródła.</p>

<p><em>To lektura publicznie dostępnych źródeł etnograficznych i gminnych oraz robocza interpretacja etymologiczna. Nie jest to zamknięty historyczny werdykt o pochodzeniu przezwiska konkretnej wsi.</em></p>
HTML,
        ],
        'hu' => [
            'title' => 'A kyjovi Čeresare: mit tudunk a gúnynévről, és mit még nem',
            'image_alt' => 'Széles bőr férfiöv, a čeres, több csattal és szegecsekkel fán, mögötte ködös kárpáti lejtők ibolya és türkiz fényben.',
            'excerpt' => 'A čeresare kifejezés a kelet-szlovákiai ruszinok néprajzában van dokumentálva, valószínűleg a széles bőrövről. Kyjov beleillik ebbe a térbe, de a Čeresare és a kyjoviak azonosítása még nincs elsődlegesen igazolva.',
            'content' => <<<'HTML'
<p>A „Čeresare” nagy valószínűséggel nem jelent külön ruszin vagy lemko etnikai csoportot. Inkább egy bizonyos ruszin falu vagy helyi közösség régi kollektív gúnyneve, a férfiöltözet jellemző darabjáról — az úgynevezett <em>čeres</em>ről — származtatva.</p>
<h2>Mi volt a čeres</h2>
<p>A čeres széles bőr férfiöv volt, jellemző a Kárpátok hegyvidéki területeire. Nem közönséges nadrágszíj. Széles bőrszíjból készült, gyakran több csattal zárták, lehetett belső zsebe, és díszítették veréssel, fém szegecsekkel, ornamentumokkal vagy szíjakkal. Gyakorlatilag merevítette a deréktájat a nehéz munkánál, és védte a testet. A <a href="https://www.ludovakultura.sk/polozka-encyklopedie/opasok">Hagyományos Népi Kultúra Központja</a> közvetlenül „öv (čeres)”ként említi, és megállapítja, hogy Szlovákia hegyvidéki területein hordták.</p>
<p>Néprajzi források hasonló <em>черес</em> / <em>cheres</em> övet dokumentálnak lemko, ruszin, hucul és más kárpáti csoportoknál is. Nyelvileg tehát nagyon természetesen alakul a lánc: čeres → a čeres hordásával jellemzett ember → čeresar → többes čeresare — más <em>-are</em> végű helyi nevekhez hasonlóan.</p>
<h2>A legfontosabb lelet</h2>
<p>A „čeresare” kifejezés valóban dokumentált a kelet-szlovákiai ruszinokról szóló szakirodalomban. Nadežda Varcholová néprajzkutató a Szlovák Nemzeti Múzeum — Ukrán Kultúra Múzeuma által kiadott <em>Odkiaľ a kedy…</em> című munkájában a ruszin falvak régi népi gúnyneveit írja le. <a href="https://www.snm.sk/muzea-snm/muzeum-ukrajinskej-kultury/galeria-dezidera-millyho/objavujte/publikacie?produkt=odkial-a-kedy">Az SNM a könyv bemutatásában</a> azt írja, hogy ezek a gúnynevek többek között „tájszólási és néprajzi (öltözet, étkezés stb.) sajátosságok” szerint keletkeztek, és a példák között közvetlenül említi a „hurňare, čeresare, mačankoše” neveket.</p>
<p>Ez lényeges. Azt jelenti, hogy a <em>čeresare</em> hiteles néprajzi kifejezés Északkelet-Szlovákia ruszin világából — nem modern találmány és nem eltorzítás.</p>
<h2>A Čeresare éppen Kyjov lakói?</h2>
<p>Itt egyelőre óvatosnak kell lennem. Három dolog megerősített:</p>
<ol>
<li>a „čeresare” egy bizonyos helyi ruszin közösség népi gúnyneve volt;</li>
<li>valószínűleg az öltözethez kapcsolódott, mert Varcholová a tájszólási és néprajzi — különösen öltözeti vagy étkezési — sajátosságokból származó gúnynevek közé sorolja;</li>
<li>a čeres éppen ilyen tipikus eleme a kárpáti férfiöltözetnek, ezért az etimológiai kapcsolat „čeresare = čeres-öv hordói” nagyon erős.</li>
</ol>
<p>Varcholová könyvének nyilvánosan elérhető internetes leírása azonban nem mondja meg, melyik konkrét faluhoz kötődik a gúnynév. Ehhez a könyvben lévő címszóra volna szükség. Ezért egyelőre nem akarom kategorikusan állítani: „Čeresare = kyjoviak.” Lehetséges, és a kontextus miatt elég valószínű is, de még nincs elsődleges bejegyzéssel igazolva.</p>
<h2>Kyjov nagyon jól beleillik ebbe a kulturális térbe</h2>
<p>Magánál Kyjovnál meglehetősen egyértelmű a ruszin település történeti folyamatossága. A <a href="https://www.obec-kyjov.sk/p/6367/historia-obce.html">község hivatalos története</a> azt írja, hogy az 1538-as összeírásban Kyjov ruszin faluként szerepel. A 16. század végén szlovák és ruszin eredetű földműves és oláh lakosság élt itt.</p>
<p>A helyi hagyomány megőrizte a legendát, amely szerint a falut hat, Kijevből érkező ruszin alapította; maga a község helyesen jelzi, hogy ez legenda, nem történetileg igazolt tény. Érdekes az is, hogy Varcholová könyvében Kyjovot közvetlenül említi azok között a falvak között, amelyek nevét a néphagyomány betelepülőkkel magyarázta. Kyjov tehát határozottan abba a földrajzi és kulturális anyagba tartozik, amelyet vizsgált.</p>
<h2>Ruszin, Rusnák és Lemko</h2>
<p>Itt érdemes több szintet megkülönböztetni. A <em>Rusnák</em> a ruszin lakosság emberének hagyományos népi megnevezése, amelyet Északkelet-Szlovákiában használtak és ma is használnak. A <em>ruszin</em> a tágabb etnikai megnevezés. A <em>lemko</em> regionális kárpáti csoport a kárpáti ruszin tér északi és északkeleti részén. Annak határai, akit a történeti források lemkónak, és akit rusnáknak vagy ruszinnak neveztek, nem mindig azonosak a mai nemzetiségi kategóriákkal.</p>
<p>A Čeresare pedig minden jel szerint még egy szinttel lejjebb áll: nem nemzet és nem néprajzi makrocsoport, hanem helyi falusi gúnynév. Sematikusan: ruszinok / rusnákok → regionális kárpáti csoportok, köztük a lemkók → konkrét falvak → Čeresare, Hurňare, Mačankoše, Potičkare, Kavkare típusú falusi gúnynevek…</p>
<p>Az ilyen gúnynevek a hagyományos falusi kultúrában nagyon fontosak voltak. A szomszéd falvak azonnal tudták belőlük, honnan jön valaki. Gyakran humorosak, ironikusak, néha enyhén gúnyosak voltak; idővel csaknem helyi etnonimként működhettek.</p>
<h2>Mit jelenthetett a „Čeresare”</h2>
<p>A források kombinációja alapján a munkahipotézist így fogalmaznám: a Čeresare Északkelet-Szlovákia egyik ruszin faluja lakóinak népi megnevezése volt, valószínűleg a čeres nevű széles bőr férfiöv jellemző hordása szerint. Nem külön ruszin vagy lemko törzs vagy etnikai csoport volt.</p>
<p>Ha bebizonyosodik, hogy Varcholová ezt a gúnynevet közvetlenül Kyjovhoz köti, a jelentés egyszerű volna: Čeresare = a kyjoviak régi szomszédi vagy néprajzi gúnyneve, valószínűleg hagyományos férfiöltözetük szerint.</p>
<h2>Egy részlet, amely érdekes lehet</h2>
<p>A čeres nem csupán díszes viseletdarab volt. A pásztorkodáshoz, erdei munkához, fizikai erőhöz és hegyi életmódhoz kapcsolódott. Gyakorlati funkciója volt a derék védelmében; pénzt és apró tárgyakat hordtak benne. A népi kultúrában az erő szimbolikus jelentését is elnyerte, és megjelenik a betyárhagyományokban.</p>
<p>Ha tehát a szomszédok egy falu lakóit Čeresare néven nevezték, ez jelenthette nemcsak azt, hogy „azok az övesek”, hanem egy archaikusabb hegyi viseletű vagy pásztorkultúrájú közösséget is azonosíthatott. Ez nagyon jól illene a Minčol alatti Kyjovhoz és a hagyományos erdei és oláh gazdasághoz: a falu története mezőgazdaságot, állattartást, szezonális erdei munkát és faszénégetést említ. Ez az utolsó kapcsolat azonban értelmezés, még nem közvetlenül igazolt forrásmondat.</p>

<p><em>Nyilvánosan elérhető néprajzi és községi források olvasata, valamint munkában lévő etimológiai értelmezés. Nem lezárt történeti ítélet egy konkrét falu gúnynevének eredetéről.</em></p>
HTML,
        ],
        'it' => [
            'title' => 'I Čeresare di Kyjov: ciò che sappiamo del soprannome, e ciò che ancora no',
            'image_alt' => 'Ampia cintura di cuoio maschile, un čeres, con più fibbie e borchie sul legno, alle spalle pendii carpatici nebbiosi in luce viola e turchese.',
            'excerpt' => 'Čeresare è attestato nell’etnografia dei ruteni della Slovacchia orientale, probabilmente dalla larga cintura di cuoio. Kyjov rientra in questo spazio, ma l’equazione con la gente di Kyjov non ha ancora un riscontro primario.',
            'content' => <<<'HTML'
<p>«Čeresare» con grande probabilità non indica un gruppo etnico distinto di ruteni o lemko. È piuttosto un antico soprannome collettivo degli abitanti di un determinato villaggio ruteno o gruppo locale, derivato da un pezzo caratteristico dell’abbigliamento maschile: il cosiddetto <em>čeres</em>.</p>
<h2>Cos’era un čeres</h2>
<p>Il čeres era un’ampia cintura di cuoio maschile tipica delle zone montane dei Carpazi. Non era una comune cintura da pantaloni. Era fatta da una larga fascia di cuoio, spesso chiusa con più fibbie, poteva avere una tasca interna ed era ornata di sbalzo, borchie metalliche, ornamenti o strisce. In pratica rinforzava i fianchi nel lavoro pesante e proteggeva il corpo. Il <a href="https://www.ludovakultura.sk/polozka-encyklopedie/opasok">Centro per la cultura popolare tradizionale</a> lo indica direttamente come «cintura (čeres)» e nota che si portava nelle zone montane della Slovacchia.</p>
<p>Le fonti etnografiche attestano un analogo <em>черес</em> / <em>cheres</em> anche tra lemko, ruteni, hutsuli e altri gruppi carpatici. Linguisticamente la catena è naturale: čeres → persona caratterizzata dal portare il čeres → čeresar → plurale čeresare, come altri nomi locali in <em>-are</em>.</p>
<h2>Il reperto più importante</h2>
<p>L’espressione «čeresare» è davvero attestata nella letteratura etnografica specialistica sui ruteni della Slovacchia orientale. Nell’opera <em>Odkiaľ a kedy…</em>, pubblicata dal Museo nazionale slovacco — Museo della cultura ucraina, l’etnografa Nadežda Varcholová descrive antichi soprannomi popolari dei villaggi ruteni. <a href="https://www.snm.sk/muzea-snm/muzeum-ukrajinskej-kultury/galeria-dezidera-millyho/objavujte/publikacie?produkt=odkial-a-kedy">Lo SNM nella scheda del libro</a> scrive che questi soprannomi nascevano tra l’altro da «particolarità dialettali ed etnografiche (abito, cibo ecc.)» e tra gli esempi cita direttamente «hurňare, čeresare, mačankoše».</p>
<p>Questo è essenziale. Significa che <em>čeresare</em> è un termine etnografico autentico del mondo ruteno della Slovacchia nord-orientale — non un’invenzione moderna né una storpiatura.</p>
<h2>I Čeresare sono proprio gli abitanti di Kyjov?</h2>
<p>Qui devo ancora essere cauto. Ho confermate tre cose:</p>
<ol>
<li>«čeresare» era un soprannome popolare di una determinata comunità rutena locale;</li>
<li>probabilmente era legato all’abito, perché Varcholová lo colloca tra i soprannomi derivati da particolarità dialettali ed etnografiche — soprattutto di abito o di cibo;</li>
<li>il čeres è proprio quel tipo di elemento tipico dell’abito maschile carpatico, perciò il legame etimologico «čeresare = portatori di čeres» è molto forte.</li>
</ol>
<p>La descrizione pubblica su internet del libro di Varcholová non indica però a quale villaggio concreto si leghi il soprannome. Per questo servirebbe la voce stessa nel libro. Perciò non voglio ancora affermare categoricamente: «Čeresare = gente di Kyjov.» È possibile e, dato il contesto, anche piuttosto probabile, ma non l’ho ancora documentato con una registrazione primaria.</p>
<h2>Kyjov rientra molto bene in questo spazio culturale</h2>
<p>Per lo stesso Kyjov abbiamo una continuità storica abbastanza chiara dell’insediamento ruteno. La <a href="https://www.obec-kyjov.sk/p/6367/historia-obce.html">storia ufficiale del comune</a> indica che nel registro del 1538 Kyjov figura come villaggio ruteno. Alla fine del XVI secolo vi viveva popolazione contadina e valacca di origine slovacca e rutena.</p>
<p>La tradizione locale ha conservato la leggenda secondo cui il villaggio fu fondato da sei ruteni venuti da Kiev; il comune stesso avverte correttamente che si tratta di una leggenda, non di un fatto storicamente documentato. È interessante anche che Varcholová nel suo libro menzioni Kyjov direttamente tra i villaggi il cui nome la tradizione popolare spiegava con immigrati. Kyjov appartiene dunque chiaramente al materiale geografico e culturale che ella ha studiato.</p>
<h2>Ruteno, Rusnák e Lemko</h2>
<p>Qui conviene distinguere diversi livelli. <em>Rusnák</em> è il nome popolare tradizionale di una persona della popolazione rutena, usato e ancora usato nel nord-est della Slovacchia. <em>Ruteno</em> è il nome etnico più ampio. <em>Lemko</em> è un gruppo carpatico regionale nella parte settentrionale e nord-orientale dello spazio ruteno carpatico. I confini tra chi le fonti storiche chiamavano lemko e chi rusnák o ruteno non sempre coincidono con le categorie nazionali di oggi.</p>
<p>E i Čeresare, a quanto pare, rappresentano ancora un livello più basso: non una nazione né un macrogruppo etnografico, ma un soprannome paesano locale. Schematicamente: ruteni / rusnák → gruppi carpatici regionali inclusi i lemko → villaggi concreti → soprannomi paesani del tipo Čeresare, Hurňare, Mačankoše, Potičkare, Kavkare…</p>
<p>Tali soprannomi erano molto importanti nella cultura paesana tradizionale. I villaggi vicini sapevano subito da dove veniva qualcuno. Spesso erano umoristici, ironici, a volte lievemente derisori; col tempo potevano funzionare quasi come etnonimo locale.</p>
<h2>Cosa significava probabilmente «Čeresare»</h2>
<p>Sulla base della combinazione delle fonti formulerei l’interpretazione di lavoro così: i Čeresare erano il nome popolare degli abitanti di uno dei villaggi ruteni della Slovacchia nord-orientale, probabilmente secondo l’uso caratteristico dell’ampia cintura di cuoio maschile chiamata čeres. Non si trattava di una tribù o di un gruppo etnico ruteno o lemko a sé.</p>
<p>Se si conferma che Varcholová lega questo soprannome direttamente a Kyjov, il senso sarebbe semplice: Čeresare = antico soprannome di vicinato o etnografico della gente di Kyjov, probabilmente secondo il loro abito maschile tradizionale.</p>
<h2>Un dettaglio che può essere interessante</h2>
<p>Il čeres non era solo un pezzo decorativo del costume. Era legato alla pastorizia, al lavoro forestale, alla forza fisica e alla vita di montagna. Aveva una funzione pratica di protezione dei fianchi; vi si portavano denaro e piccoli oggetti. Nella cultura popolare acquisì anche un significato simbolico di forza e compare nelle tradizioni di briganti.</p>
<p>Se dunque i vicini chiamavano Čeresare gli abitanti di un certo villaggio, poteva significare non solo «quelli con le cinture», ma anche identificare una comunità con abito montano più arcaico o cultura pastorale. Ciò andrebbe molto bene con Kyjov sotto il Minčol e con la sua economia forestale e valacca tradizionale: la storia del villaggio cita agricoltura, allevamento, lavoro stagionale nei boschi e carbonizzazione del legno. Quest’ultimo legame è però un’interpretazione, non ancora un enunciato di fonte direttamente attestato.</p>

<p><em>Si tratta di una lettura di fonti etnografiche e comunali pubblicamente disponibili, e di un’interpretazione etimologica di lavoro. Non è un verdetto storico chiuso sull’origine del soprannome di un villaggio concreto.</em></p>
HTML,
        ],
        'uk' => [
            'title' => 'Чересаре з Кийова: що ми знаємо про прізвисько і чого ще ні',
            'image_alt' => 'Широкий шкіряний чоловічий пояс черес із кількома пряжками й цвяшками на дереві, за ним туманні карпатські схили у фіолетовому й бірюзовому світлі.',
            'excerpt' => 'Вираз чересаре засвідчений в етнографії русинів східної Словаччини, ймовірно від широкого шкіряного пояса. Кийов вписується в цей простір, але ототожнення Чересарів із мешканцями Кийова ще не підкріплене первинним записом.',
            'content' => <<<'HTML'
<p>«Чересаре» з великою ймовірністю не позначає окрему етнічну групу русинів чи лемків. Це радше стара колективна прізвисько мешканців певного русинського села чи місцевої групи, утворене від характерної частини чоловічого одягу — так званого <em>череса</em>.</p>
<h2>Що таке черес</h2>
<p>Черес був широким шкіряним чоловічим поясом, типовим для гірських областей Карпат. Це не був звичайний ремінь до штанів. Його робили з широкої смуги шкіри, часто застібали на кілька пряжок, міг мати внутрішню кишеню й оздоблювався карбуванням, металевими цвяшками, орнаментами чи ремінцями. Практично зміцнював поперек при важкій праці й захищав тіло. <a href="https://www.ludovakultura.sk/polozka-encyklopedie/opasok">Центр традиційної народної культури</a> прямо подає його як «пояс (черес)» і зазначає, що його носили в гірських областях Словаччини.</p>
<p>Етнографічні джерела засвідчують подібний <em>черес</em> / <em>cheres</em> також серед лемків, русинів, гуцулів та інших карпатських груп. З мовного погляду дуже природно виникає ланцюг: черес → людина, характерна носінням череса → чересар → множина чересаре — подібно до інших місцевих назв на <em>-are</em>.</p>
<h2>Найважливіша знахідка</h2>
<p>Вираз «чересаре» справді засвідчений у фаховій етнографічній літературі про русинів східної Словаччини. Етнографиня Надія Вархолова у виданні <em>Odkiaľ a kedy…</em>, опублікованому Словацьким національним музеєм — Музеєм української культури, описує старі народні прізвиська русинських сіл. <a href="https://www.snm.sk/muzea-snm/muzeum-ukrajinskej-kultury/galeria-dezidera-millyho/objavujte/publikacie?produkt=odkial-a-kedy">СНМ у характеристиці книжки</a> пише, що ці прізвиська виникали зокрема за «діалектними й народознавчими (одяг, їжа тощо) особливостями» і серед прикладів прямо наводить «hurňare, čeresare, mačankoše».</p>
<p>Це істотно. Означає, що <em>чересаре</em> — автентичний етнографічний вираз із середовища русинів північно-східної Словаччини, а не новочасний вигад чи спотворення.</p>
<h2>Чи Чересаре саме мешканці Кийова?</h2>
<p>Тут я поки мушу бути обережним. Підтверджено три речі:</p>
<ol>
<li>«чересаре» було народним прізвиськом певної місцевої русинської спільноти;</li>
<li>ймовірно пов’язувалося з одягом, бо Вархолова відносить його до прізвиськ, утворених від діалектних і народознавчих — зокрема одягових чи харчових — особливостей;</li>
<li>черес — саме такий типовий елемент чоловічого карпатського одягу, тож етимологічний зв’язок «чересаре = носії чересів» дуже сильний.</li>
</ol>
<p>Однак загальнодоступний інтернет-опис книжки Вархолової не вказує, до якого конкретного села прізвисько прив’язане. Для цього треба дістатися самого гасла в книжці. Тому поки не хочу категорично твердити: «Чересаре = мешканці Кийова.» Це можливо і з огляду на контекст навіть досить імовірно, але поки цього немає первинним записом.</p>
<h2>Кийов дуже добре вписується в цей культурний простір</h2>
<p>Щодо самого Кийова маємо досить однозначну історичну тяглість русинського заселення. <a href="https://www.obec-kyjov.sk/p/6367/historia-obce.html">Офіційна історія громади</a> зазначає, що в описі 1538 року Кийов фігурує як русинське село. Наприкінці XVI століття тут жило хліборобське й волоське населення словацького та русинського походження.</p>
<p>Місцева традиція зберегла легенду, за якою село заснували шестеро русинів, що прийшли з Києва; сама громада слушно зауважує, що це легенда, а не історично засвідчений факт. Цікаво й те, що Вархолова у своїй книжці згадує Кийов прямо серед сіл, назву яких народне передання пояснювало переселенцями. Отже, Кийов рішуче належить до географічного й культурного матеріалу, який вона досліджувала.</p>
<h2>Русин, руснак і лемко</h2>
<p>Тут варто розрізняти кілька рівнів. <em>Руснак</em> — традиційна народна назва людини русинського населення, яку на північному сході Словаччини вживали й уживають досі. <em>Русин</em> — ширша етнічна назва. <em>Лемко</em> — регіональна карпатська група північної й північно-східної частини карпатського русинського простору. Межі між тим, кого історичні джерела називали лемком, а кого руснаком чи русином, не завжди тотожні з нинішніми національними категоріями.</p>
<p>А Чересаре, судячи з усього, являють ще на рівень нижче: не народ і не етнографічну макрогрупу, а місцеве сільське прізвисько. Схематично: русини / руснаки → регіональні карпатські групи включно з лемками → конкретні села → сільські прізвиська типу Чересаре, Гурняре, Мачанкоше, Потічкаре, Кавкаре…</p>
<p>Такі прізвиська в традиційній сільській культурі були дуже важливі. Сусідні села за ними одразу знали, звідки людина. Часто вони були гумористичні, іронічні, іноді трохи насмішкуваті; з часом могли діяти майже як місцевий етнонім.</p>
<h2>Що ймовірно означало «Чересаре»</h2>
<p>На основі поєднання джерел робочу інтерпретацію сформулював би так: Чересаре були народною назвою мешканців одного з русинських сіл північно-східної Словаччини, ймовірно за характерним носінням широкого шкіряного чоловічого пояса, званого черес. Це не був окремий русинський чи лемківський рід чи етнічна група.</p>
<p>Якщо підтвердиться, що Вархолова прив’язує це прізвисько прямо до Кийова, значення буде просте: Чересаре = стара сусідська чи народознавча прізвисько мешканців Кийова, ймовірно за їхнім традиційним чоловічим одягом.</p>
<h2>Одна деталь, яка може бути цікавою</h2>
<p>Черес не був лише декоративною частиною строю. Це був предмет, пов’язаний із пастухуванням, лісовою працею, фізичною силою й гірським способом життя. Мав практичну функцію захисту поперека; у ньому носили гроші й дрібні речі. У народній культурі він також набув символічного значення сили й з’являється в розбійницьких традиціях.</p>
<p>Тож якщо сусіди називали мешканців певного села Чересарами, це могло означати не лише «ті з поясами», а й ідентифікувати спільноту з архаїчнішим гірським одягом чи пастушою культурою. Це дуже добре пасувало б до Кийова під Мінчолом і до традиційного лісового й волоського господарства: історія села згадує рільництво, розведення худоби, сезонну працю в лісах і випалювання деревини. Це останнє поєднання є, однак, інтерпретацією, ще не безпосередньо засвідченим висловом джерела.</p>

<p><em>Це читання загальнодоступних етнографічних і громадських джерел та робоча етимологічна інтерпретація. Це не закритий історичний вердикт про походження прізвиська конкретного села.</em></p>
HTML,
        ],
    ],
];
