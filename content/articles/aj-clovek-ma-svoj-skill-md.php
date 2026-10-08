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
 * Anonymizovaná klinická esej z dialyzačného strediska (október 2026).
 * Overené 8. 10. 2026:
 * skill.md / SKILL.md je súbor pokynov pre AI agenta (https://agentskills.io/specification).
 * Suchá hmotnosť je tradičný názov cieľovej hmotnosti po hemodialýze;
 * v praxi sa od nej odlišuje dosiahnutá hmotnosť po výkone
 * (https://homedialysis.org/news-and-research/blog/201-A-Primer-on-Haemodialysis-%22Weight%22).
 * Pracovisko, nemocnica ani dôvody pacienta nie sú pomenované.
 */
return [
    'slug' => 'aj-clovek-ma-svoj-skill-md',
    'author' => 'MUDr. Ľubomír Polaščín',
    'category' => 'blog',
    'is_top' => 0,
    'published_at' => '2026-10-08 07:15:00',
    'image' => 'images/articles/aj-clovek-ma-svoj-skill-md.webp',
    'translations' => [
        'sk' => [
            'title' => 'Aj človek má svoj skill.md. Len ho nevidíme.',
            'image_alt' => 'Lekár v bielom plášti, videný odzadu v sále fialového dialyzačného strediska, drží pri uchu telefón a prázdny list. V pozadí sedí pacient na vozíku oproti tyrkysovému svetlu dverí.',
            'excerpt' => 'Pacient na dialýze sa zhoršoval a systém sa spýtal, prečo patrí inam. Slepé vykonávanie skriptov sme ovládali dávno pred umelou inteligenciou. Najdôležitejší skill je spoznať, kedy postup zastaviť.',
            'content' => <<<'HTML'
<p>Pacient sa zhoršoval. Z prijímajúceho pracoviska sa pýtali, prečo sme ho poslali práve k nim. V tej chvíli som si uvedomil, že na slepé vykonávanie skriptov nepotrebujeme umelú inteligenciu. Túto schopnosť sme si osvojili dávno pred ňou.</p>
<p>Asi týždeň sa zhoršoval zdravotný stav pacienta na dialýze.</p>
<p>Na satelitnom dialyzačnom stredisku sme postupne využili všetko, čo máme k dispozícii: opakované fyzikálne vyšetrenia, nové prehodnotenie anamnézy, úpravy parametrov dialyzačného ošetrenia vrátane referenčnej hmotnosti, tradične označovanej ako suchá hmotnosť, laboratórne vyšetrenia, röntgen hrudníka a ultrasonografiu brucha.</p>
<p>Tam sa naše diagnostické možnosti končia. Nie preto, že by sa nám nechcelo pokračovať. Preto, že dialyzačné stredisko nie je nemocnica.</p>
<p>Pacientovi sme vysvetlili, že potrebuje ďalšiu diferenciálnu diagnostiku v nemocnici a že ju vzhľadom na progresívnu dýchavicu, vzostup hmotnosti a výrazne obmedzenú toleranciu námahy potrebuje bezodkladne.</p>
<p>Povedal, že rozumie. Navrhovaný postup však odmietol.</p>
<p>Jeho dôvody pre zachovanie anonymity nebudem rozvádzať. Z medicínskeho hľadiska nemenili potrebu nemocničného vyšetrenia. Z jeho pohľadu však zjavne zavážili viac než naše vysvetlenie.</p>
<p>Aj to si zapamätajme. K pacientovi sa ešte vrátime.</p>
<h2>Pacient mal dýchavicu. Systém mal otázku.</h2>
<p>O dva dni prišiel pred šiestou ráno na pravidelnú dialýzu. Hmotnostný prírastok mal len 0,2 kilogramu.</p>
<p>Nie, nie je to preklep. Dvesto gramov za dva dni.</p>
<p>Príznaky však boli výrazne horšie. Malý hmotnostný prírastok neznamenal malé nebezpečenstvo. Teraz už nasledovalo odoslanie do nemocnice a presun na invalidnom vozíku.</p>
<p>Krátko nato zazvonil telefón.</p>
<p>Z prijímajúceho pracoviska sa ozvala žena, ktorú som považoval za lekárku. Považoval, pretože sa nepredstavila.</p>
<p>Možno by ste čakali otázky o pacientovom stave. Čo sa zmenilo? Aké boli výsledky? Čo sme vyskúšali? Prečo považujeme situáciu za naliehavú?</p>
<p>Nie.</p>
<p>Otázka znela: prečo sme ho poslali práve k nim, keď podľa „rajónu“ patrí do inej nemocnice?</p>
<p>Vysvetlil som svoju úvahu. V najbližšom dosahu sú dve nemocnice, obe majú dialyzačné oddelenie. Túto som vybral pre predpokladané lepšie možnosti diagnostiky jeho stavu.</p>
<p>Keď som následne začal odovzdávať klinické informácie, stihol som povedať asi dve slová.</p>
<p>Hovor sa skončil.</p>
<p>Pacient zostal pacientom. Dýchavica zostala dýchavicou. Len informácie, ktoré mohli pomôcť pri jeho ďalšom vyšetrení, zostali na nesprávnej strane telefónu.</p>
<h2>Súbor, ktorý nikto neotvára</h2>
<p>Najprv som si pomyslel, že sa na mňa možno preniesla frustrácia z ranného nedostatku lôžok. Neviem, či to tak bolo. Nepoznám situáciu na oddelení ani okolnosti na druhej strane.</p>
<p>Potom mi však napadla nepríjemnejšia možnosť.</p>
<p>Čo ak nešlo o výbuch emócií? Čo ak sa len bezchybne vykonal zaužívaný postup?</p>
<p>V prostredí AI agentov môže súbor skill.md obsahovať návod, ako zvládnuť určitú úlohu: čo skontrolovať, ako postupovať, čomu sa vyhnúť.</p>
<p>Človek takýto súbor nepotrebuje na disku. Nosí ho v hlave.</p>
<p>Vytvárajú ho skúsenosti, výchova, pracovné prostredie, pokyny nadriadených, odmeny aj tresty. Niekedy je jeho obsah rozumný a užitočný. Inokedy by sa dal zhrnúť celkom jednoducho:</p>
<p>Keď príde problém, najprv zisti, prečo by nemal patriť tebe.</p>
<p>Neviem, či niekto na danom pracovisku takýto pokyn vyslovil. Ani nemusí. Niektoré pravidlá sa odovzdávajú bez školenia a bez podpisu. Stačí opakovane vidieť, ktoré správanie sa toleruje, ktoré sa oceňuje a za ktoré príde nepríjemnosť.</p>
<p>Časom už človek nepotrebuje príkaz. Spustí postup sám.</p>
<h2>Správna odpoveď na nesprávnu otázku</h2>
<p>Tu sa podobnosť s umelou inteligenciou stáva zaujímavou.</p>
<p>Inteligentný systém môže podať výborný výkon, a predsa riešiť nesprávnu úlohu. Ak mu ako hlavný cieľ zadáte chrániť kapacitu pracoviska, môže veľmi efektívne hľadať dôvody, prečo konkrétny pacient patrí inam.</p>
<p>Lenže medicínska otázka bola iná:</p>
<p>Čo tento človek potrebuje a ako mu to zabezpečíme včas?</p>
<p>Organizácia príjmu, kapacity a rozdelenie práce sú reálne problémy. Nikto, kto pracuje v zdravotníctve, ich nemôže poctivo popierať. Problém nastáva vtedy, keď organizačná otázka vytlačí klinickú natoľko, že už nezostane priestor ani na odovzdanie informácií.</p>
<p>V tej chvíli nemusí zlyhávať schopnosť uvažovať. Môže zlyhávať poradie priorít.</p>
<p>A to je azda ešte nepríjemnejšie. Väčšia inteligencia totiž sama osebe nezaručí lepší cieľ. Môže len účinnejšie obsluhovať ten nesprávny.</p>
<h2>Aj pacient má svoj skript</h2>
<p>Nebolo by však poctivé urobiť z tohto príbehu jednoduchý súboj rozumného lekára s nerozumnou nemocnicou.</p>
<p>Aj pacient mal svoj vnútorný postup. Povedal, že rozumie potrebe nemocničného vyšetrenia, a napriek tomu ho odmietol.</p>
<p>Čo presne rozhodlo, nechajme mimo tohto článku. Všeobecne však poznáme skripty, ktoré v podobných situáciách používame: ešte to vydržím, teraz nemôžem, počkám do ďalšej kontroly, nejako to dopadne.</p>
<p>Nie sú to dôkazy hlúposti. Môžu v nich byť strach, povinnosti, zlé skúsenosti či potreba zachovať si kontrolu. Ich ľudská zrozumiteľnosť však nezaručuje ich bezpečnosť.</p>
<p>Aj ja mám svoje skripty. Každý lekár ich má. Bez naučených postupov by sa medicína robiť nedala.</p>
<p>Rozdiel nie je medzi človekom, ktorý používa pravidlá, a človekom, ktorý nepoužíva žiadne.</p>
<p>Rozdiel je medzi človekom, ktorý vie postup použiť, a človekom, ktorý vie rozpoznať, kedy ho treba prerušiť.</p>
<h2>Toto nie je dôkaz, že mozog je jazykový model</h2>
<p>Netvrdím, že ľudská inteligencia a umelá inteligencia sú totožné. Tento príbeh nie je dôkazom o podstate vedomia ani o fungovaní mozgu.</p>
<p>Je však výstižnou podobnosťou na úrovni správania.</p>
<p>Podnet príde. Vyberie sa známy vzorec. Spustí sa odpoveď. Kontext sa zohľadní len natoľko, nakoľko ho daný postup vôbec pripúšťa.</p>
<p>Od umelej inteligencie dnes žiadame, aby chápala súvislosti, rozpoznala neistotu, odhadla emocionálny stav človeka a nepritakávala mu len preto, aby sa mu zapáčila.</p>
<p>Od seba by sme mohli žiadať aspoň to isté.</p>
<p>Slušnosť nie je podlizovanie. Empatia nie je súhlas. A predstaviť sa, vypočuť kolegu a prevziať podstatné klinické informácie nie je nadštandardná emocionálna inteligencia. Je to základ profesionálnej komunikácie.</p>
<h2>Najdôležitejší skill je vedieť zastaviť ostatné</h2>
<p>Obávame sa, že umelá inteligencia bude raz bezohľadne vykonávať zle nastavené pokyny.</p>
<p>Lenže ľudia to dokážu už dnes. Bez serverov, bez modelov, bez jediného riadka kódu.</p>
<p>Preto by som do každého ľudského aj umelého skill.md doplnil jednu vetu:</p>
<p>Ak vykonávaš postup správne, ale prestávaš vidieť človeka, zastav sa a prehodnoť cieľ.</p>
<p>Pacient nepotrebuje vyhrať spor o rajón. Potrebuje, aby niekto pochopil, prečo sa mu zhoršuje stav.</p>
<p>A inteligencia sa neprejavuje iba tým, ako rýchlo nájdeme správny skript.</p>
<p>Prejavuje sa aj tým, že si všimneme, keď práve beží nesprávny.</p>
<p>Ak vo svojej práci poznáte okamih, keď správne bežiaci postup prestane vidieť človeka, napíšte mi cez <a href="contact.php">kontakt</a>.</p>
<p><em>Ide o anonymizovanú klinickú skúsenosť z dialyzačného strediska, nie o opis konkrétneho pracoviska ani o liečebné odporúčanie. Dôvody pacienta zámerne neuvádzam. Rozhodnutie o vyšetrení a liečbe patrí do rozhovoru s ošetrujúcim lekárom.</em></p>
HTML,
        ],
        'en' => [
            'title' => 'A human has a skill.md too. We just cannot see it.',
            'image_alt' => 'A physician in a white coat, seen from behind in a violet dialysis unit, holds a telephone to his ear and a blank sheet of paper. Farther back, a patient sits in a wheelchair facing a teal-lit doorway.',
            'excerpt' => 'A dialysis patient was getting worse, and the system asked why he belonged somewhere else. Blindly running a script is a skill we mastered long before artificial intelligence. The one that matters is knowing when to stop.',
            'content' => <<<'HTML'
<p>The patient was getting worse. The receiving unit asked why we had sent him to them. In that moment I realised that we do not need artificial intelligence in order to run a script blindly. We acquired that ability long before it existed.</p>
<p>For about a week, a dialysis patient had been deteriorating.</p>
<p>At the satellite dialysis centre we used, in turn, everything we have: repeated physical examinations, a fresh review of the history, adjustments to the dialysis prescription including the reference weight, traditionally called the dry weight, laboratory tests, a chest X-ray and an abdominal ultrasound.</p>
<p>That is where our diagnostic reach ends. Not because we would rather stop. Because a dialysis centre is not a hospital.</p>
<p>We explained to the patient that he needed further differential diagnosis in hospital, and that, given progressive breathlessness, a rising weight and a sharply limited tolerance of effort, he needed it without delay.</p>
<p>He said he understood. He still refused the proposed course.</p>
<p>I will not set out his reasons; anonymity requires that. Medically, they did not change the need for a hospital assessment. From his point of view they clearly weighed more than our explanation.</p>
<p>Remember that too. We will come back to the patient.</p>
<h2>The patient was breathless. The system had a question.</h2>
<p>Two days later he arrived before six in the morning for his regular dialysis. His weight gain was only 0.2 kilograms.</p>
<p>No, that is not a typo. Two hundred grams in two days.</p>
<p>The symptoms, though, were much worse. A small weight gain did not mean a small danger. This time he was sent to hospital, and moved there in a wheelchair.</p>
<p>Shortly afterwards the telephone rang.</p>
<p>A woman called from the receiving unit. I took her for a doctor. I took her for one because she did not introduce herself.</p>
<p>You might have expected questions about the patient’s condition. What had changed? What were the results? What had we already tried? Why did we consider the situation urgent?</p>
<p>No.</p>
<p>The question was: why had we sent him to them, when according to the “catchment” he belonged to another hospital?</p>
<p>I explained my reasoning. Two hospitals are within the nearest reach, and both have a dialysis ward. I chose this one because I expected it to offer a better chance of diagnosing his condition.</p>
<p>When I then began to hand over the clinical information, I managed about two words.</p>
<p>The call ended.</p>
<p>The patient remained a patient. The breathlessness remained breathlessness. Only the information that might have helped the next stage of his assessment stayed on the wrong side of the telephone.</p>
<h2>A file nobody opens</h2>
<p>My first thought was that the morning shortage of beds might have spilled over onto me. I do not know whether that was so. I do not know the situation on the ward, or the circumstances at the other end.</p>
<p>Then a less comfortable possibility occurred to me.</p>
<p>What if this was not an outburst? What if a habitual procedure had simply been carried out without a flaw?</p>
<p>Among AI agents, a skill.md file can hold the instructions for a task: what to check, how to proceed, what to avoid.</p>
<p>A person does not need that file on a disk. He carries it in his head.</p>
<p>Experience, upbringing, the workplace, the instructions of superiors, rewards and punishments all write it. Sometimes its contents are sensible and useful. Sometimes they can be summed up quite simply:</p>
<p>When a problem arrives, first find out why it should not be yours.</p>
<p>I do not know whether anyone on that unit ever said this aloud. They need not have. Some rules are passed on without training and without a signature. It is enough to see, again and again, which behaviour is tolerated, which is rewarded, and which brings trouble.</p>
<p>After a while a person no longer needs an order. He starts the procedure himself.</p>
<h2>The right answer to the wrong question</h2>
<p>Here the resemblance to artificial intelligence becomes interesting.</p>
<p>An intelligent system can perform excellently and still be solving the wrong task. If its chief goal is to protect the capacity of a unit, it can search very efficiently for reasons why a particular patient belongs somewhere else.</p>
<p>The medical question was different:</p>
<p>What does this person need, and how do we secure it in time?</p>
<p>The organisation of admissions, capacity and the division of work are real problems. No one who works in health care can honestly deny them. The problem begins when the organisational question crowds out the clinical one so completely that there is no longer room even to pass on information.</p>
<p>At that point the ability to think need not be what fails. The order of priorities may fail.</p>
<p>That is perhaps the more unpleasant failure. Greater intelligence does not, by itself, guarantee a better goal. It can only serve the wrong one more effectively.</p>
<h2>The patient has a script too</h2>
<p>It would not be honest to turn this story into a simple contest between a reasonable doctor and an unreasonable hospital.</p>
<p>The patient had an inner procedure of his own. He said he understood the need for a hospital assessment, and he refused it all the same.</p>
<p>What exactly decided the matter stays outside this article. In general, though, we know the scripts we use in situations like this: I can still hold on, I cannot go now, I will wait until the next appointment, it will work out somehow.</p>
<p>These are not proofs of stupidity. Fear, duties, bad experiences or a need to keep control may sit inside them. Being humanly understandable does not make them safe.</p>
<p>I have my scripts too. Every doctor does. Medicine could not be practised without learned procedures.</p>
<p>The difference is not between a person who uses rules and a person who uses none.</p>
<p>The difference is between a person who can apply a procedure and a person who can recognise when it has to be interrupted.</p>
<h2>This is not proof that the brain is a language model</h2>
<p>I am not claiming that human intelligence and artificial intelligence are the same thing. This story is not evidence about the nature of consciousness, or about how the brain works.</p>
<p>It is, though, a sharp likeness at the level of behaviour.</p>
<p>A cue arrives. A familiar pattern is selected. A response is launched. Context is taken into account only so far as the procedure allows it at all.</p>
<p>We now ask artificial intelligence to grasp context, to recognise uncertainty, to estimate a person’s emotional state, and not to agree merely in order to be liked.</p>
<p>We could ask at least that much of ourselves.</p>
<p>Courtesy is not flattery. Empathy is not agreement. And introducing oneself, hearing a colleague out and taking over the essential clinical information is not an optional extra of emotional intelligence. It is the baseline of professional communication.</p>
<h2>The most important skill is knowing how to stop the others</h2>
<p>We worry that artificial intelligence will one day carry out badly set instructions without regard for anyone.</p>
<p>People can already do that. Without servers, without models, without a single line of code.</p>
<p>That is why I would add one sentence to every human and every artificial skill.md:</p>
<p>If you are carrying out the procedure correctly, and yet you stop seeing the person, stop and reconsider the goal.</p>
<p>The patient does not need to win an argument about catchment. He needs someone to understand why he is getting worse.</p>
<p>Intelligence does not show itself only in how quickly we find the right script.</p>
<p>It also shows itself when we notice that the wrong one is running.</p>
<p>If, in your own work, you know the moment when a procedure that is running correctly stops seeing the person, write to me through the <a href="contact.php">contact form</a>.</p>
<p><em>This is an anonymised clinical experience from a dialysis centre, not a description of a named unit and not treatment advice. The patient’s reasons are deliberately left out. Decisions about investigation and treatment belong in a conversation with the treating physician.</em></p>
HTML,
        ],
        'cs' => [
            'title' => 'I člověk má svůj skill.md. Jen ho nevidíme.',
            'image_alt' => 'Lékař v bílém plášti, viděný zezadu na sále fialového dialyzačního střediska, drží u ucha telefon a prázdný list. V pozadí sedí pacient na vozíku proti tyrkysovému světlu dveří.',
            'excerpt' => 'Pacient na dialýze se zhoršoval a systém se ptal, proč patří jinam. Slepé vykonávání skriptů jsme ovládali dávno před umělou inteligencí. Nejdůležitější skill je poznat, kdy postup zastavit.',
            'content' => <<<'HTML'
<p>Pacient se zhoršoval. Z přijímajícího pracoviště se ptali, proč jsme ho poslali právě k nim. V té chvíli jsem si uvědomil, že na slepé vykonávání skriptů nepotřebujeme umělou inteligenci. Tuto schopnost jsme si osvojili dávno před ní.</p>
<p>Asi týden se zhoršoval zdravotní stav pacienta na dialýze.</p>
<p>Na satelitním dialyzačním středisku jsme postupně využili všechno, co máme k dispozici: opakovaná fyzikální vyšetření, nové přehodnocení anamnézy, úpravy parametrů dialyzačního ošetření včetně referenční hmotnosti, tradičně označované jako suchá hmotnost, laboratorní vyšetření, rentgen hrudníku a ultrasonografii břicha.</p>
<p>Tam naše diagnostické možnosti končí. Ne proto, že by se nám nechtělo pokračovat. Proto, že dialyzační středisko není nemocnice.</p>
<p>Pacientovi jsme vysvětlili, že potřebuje další diferenciální diagnostiku v nemocnici a že ji vzhledem k progresivní dušnosti, vzestupu hmotnosti a výrazně omezené toleranci námahy potřebuje neprodleně.</p>
<p>Řekl, že rozumí. Navrhovaný postup však odmítl.</p>
<p>Jeho důvody pro zachování anonymity nebudu rozvádět. Z medicínského hlediska neměnily potřebu nemocničního vyšetření. Z jeho pohledu však zjevně zavážily víc než naše vysvětlení.</p>
<p>I to si zapamatujme. K pacientovi se ještě vrátíme.</p>
<h2>Pacient měl dušnost. Systém měl otázku.</h2>
<p>O dva dny později přišel před šestou ráno na pravidelnou dialýzu. Hmotnostní přírůstek měl jen 0,2 kilogramu.</p>
<p>Ne, není to překlep. Dvě stě gramů za dva dny.</p>
<p>Příznaky však byly výrazně horší. Malý hmotnostní přírůstek neznamenal malé nebezpečí. Teď už následovalo odeslání do nemocnice a přesun na invalidním vozíku.</p>
<p>Krátce nato zazvonil telefon.</p>
<p>Z přijímajícího pracoviště se ozvala žena, kterou jsem považoval za lékařku. Považoval, protože se nepředstavila.</p>
<p>Možná byste čekali otázky o pacientově stavu. Co se změnilo? Jaké byly výsledky? Co jsme vyzkoušeli? Proč považujeme situaci za naléhavou?</p>
<p>Ne.</p>
<p>Otázka zněla: proč jsme ho poslali právě k nim, když podle „spádu“ patří do jiné nemocnice?</p>
<p>Vysvětlil jsem svou úvahu. V nejbližším dosahu jsou dvě nemocnice, obě mají dialyzační oddělení. Tuto jsem vybral pro předpokládané lepší možnosti diagnostiky jeho stavu.</p>
<p>Když jsem následně začal předávat klinické informace, stihl jsem říct asi dvě slova.</p>
<p>Hovor skončil.</p>
<p>Pacient zůstal pacientem. Dušnost zůstala dušností. Jen informace, které mohly pomoci při jeho dalším vyšetření, zůstaly na nesprávné straně telefonu.</p>
<h2>Soubor, který nikdo neotvírá</h2>
<p>Nejdřív mě napadlo, že se na mě možná přenesla frustrace z ranního nedostatku lůžek. Nevím, jestli to tak bylo. Nepoznám situaci na oddělení ani okolnosti na druhé straně.</p>
<p>Pak mě však napadla nepříjemnější možnost.</p>
<p>Co když nešlo o výbuch emocí? Co když se jen bezchybně provedl zaběhnutý postup?</p>
<p>V prostředí AI agentů může soubor skill.md obsahovat návod, jak zvládnout určitý úkol: co zkontrolovat, jak postupovat, čemu se vyhnout.</p>
<p>Člověk takový soubor nepotřebuje na disku. Nosí ho v hlavě.</p>
<p>Vytvářejí ho zkušenosti, výchova, pracovní prostředí, pokyny nadřízených, odměny i tresty. Někdy je jeho obsah rozumný a užitečný. Jindy by se dal shrnout docela jednoduše:</p>
<p>Když přijde problém, nejdřív zjisti, proč by neměl patřit tobě.</p>
<p>Nevím, jestli někdo na daném pracovišti takový pokyn vyslovil. Ani nemusí. Některá pravidla se předávají bez školení a bez podpisu. Stačí opakovaně vidět, které chování se toleruje, které se oceňuje a za které přijde nepříjemnost.</p>
<p>Časem už člověk nepotřebuje příkaz. Postup spustí sám.</p>
<h2>Správná odpověď na nesprávnou otázku</h2>
<p>Tady se podobnost s umělou inteligencí stává zajímavou.</p>
<p>Inteligentní systém může podat výborný výkon, a přesto řešit nesprávný úkol. Pokud mu jako hlavní cíl zadáte chránit kapacitu pracoviště, může velmi efektivně hledat důvody, proč konkrétní pacient patří jinam.</p>
<p>Jenže medicínská otázka byla jiná:</p>
<p>Co tento člověk potřebuje a jak mu to zajistíme včas?</p>
<p>Organizace příjmu, kapacity a rozdělení práce jsou reálné problémy. Nikdo, kdo pracuje ve zdravotnictví, je nemůže poctivě popírat. Problém nastává tehdy, když organizační otázka vytlačí klinickou natolik, že už nezbude prostor ani na předání informací.</p>
<p>V té chvíli nemusí selhávat schopnost uvažovat. Může selhávat pořadí priorit.</p>
<p>A to je snad ještě nepříjemnější. Větší inteligence totiž sama o sobě nezaručí lepší cíl. Může jen účinněji obsluhovat ten nesprávný.</p>
<h2>I pacient má svůj skript</h2>
<p>Nebylo by však poctivé udělat z tohoto příběhu jednoduchý souboj rozumného lékaře s nerozumnou nemocnicí.</p>
<p>I pacient měl svůj vnitřní postup. Řekl, že rozumí potřebě nemocničního vyšetření, a přesto ho odmítl.</p>
<p>Co přesně rozhodlo, nechme mimo tento článek. Obecně však známe skripty, které v podobných situacích používáme: ještě to vydržím, teď nemůžu, počkám do další kontroly, nějak to dopadne.</p>
<p>Nejsou to důkazy hlouposti. Může v nich být strach, povinnosti, špatné zkušenosti nebo potřeba udržet si kontrolu. Jejich lidská srozumitelnost však nezaručuje jejich bezpečnost.</p>
<p>I já mám své skripty. Každý lékař je má. Bez naučených postupů by se medicína dělat nedala.</p>
<p>Rozdíl není mezi člověkem, který používá pravidla, a člověkem, který nepoužívá žádná.</p>
<p>Rozdíl je mezi člověkem, který umí postup použít, a člověkem, který umí rozpoznat, kdy ho je třeba přerušit.</p>
<h2>Tohle není důkaz, že mozek je jazykový model</h2>
<p>Netvrdím, že lidská inteligence a umělá inteligence jsou totožné. Tento příběh není důkazem o podstatě vědomí ani o fungování mozku.</p>
<p>Je však výstižnou podobností na úrovni chování.</p>
<p>Přijde podnět. Vybere se známý vzorec. Spustí se odpověď. Kontext se zohlední jen natolik, nakolik ho daný postup vůbec připouští.</p>
<p>Od umělé inteligence dnes žádáme, aby chápala souvislosti, rozpoznala nejistotu, odhadla emoční stav člověka a nepřitakávala mu jen proto, aby se mu zalíbila.</p>
<p>Od sebe bychom mohli žádat alespoň totéž.</p>
<p>Slušnost není podlézání. Empatie není souhlas. A představit se, vyslechnout kolegu a převzít podstatné klinické informace není nadstandardní emoční inteligence. Je to základ profesionální komunikace.</p>
<h2>Nejdůležitější skill je umět zastavit ty ostatní</h2>
<p>Obáváme se, že umělá inteligence bude jednou bezohledně vykonávat špatně nastavené pokyny.</p>
<p>Jenže lidé to dokážou už dnes. Bez serverů, bez modelů, bez jediného řádku kódu.</p>
<p>Proto bych do každého lidského i umělého skill.md doplnil jednu větu:</p>
<p>Jestliže postup provádíš správně, ale přestáváš vidět člověka, zastav se a přehodnoť cíl.</p>
<p>Pacient nepotřebuje vyhrát spor o spád. Potřebuje, aby někdo pochopil, proč se mu zhoršuje stav.</p>
<p>A inteligence se neprojevuje jen tím, jak rychle najdeme správný skript.</p>
<p>Projevuje se i tím, že si všimneme, když právě běží nesprávný.</p>
<p>Pokud ve své práci znáte okamžik, kdy správně běžící postup přestane vidět člověka, napište mi přes <a href="contact.php">kontakt</a>.</p>
<p><em>Jde o anonymizovanou klinickou zkušenost z dialyzačního střediska, nikoli o popis konkrétního pracoviště ani o léčebné doporučení. Důvody pacienta záměrně neuvádím. Rozhodnutí o vyšetření a léčbě patří do rozhovoru s ošetřujícím lékařem.</em></p>
HTML,
        ],
        'de' => [
            'title' => 'Auch der Mensch hat seine skill.md. Wir sehen sie nur nicht.',
            'image_alt' => 'Ein Arzt im weißen Kittel, von hinten gesehen in einem violetten Dialysezentrum, hält ein Telefon ans Ohr und ein leeres Blatt. Im Hintergrund sitzt ein Patient im Rollstuhl vor einer türkis beleuchteten Tür.',
            'excerpt' => 'Ein Dialysepatient verschlechterte sich, und das System fragte, warum er woanders hingehöre. Skripte blind auszuführen konnten wir lange vor der künstlichen Intelligenz. Der wichtigste Skill ist zu erkennen, wann man anhält.',
            'content' => <<<'HTML'
<p>Der Patient verschlechterte sich. Von der aufnehmenden Station kam die Frage, warum wir ihn gerade dorthin geschickt hatten. In dem Moment wurde mir klar, dass wir für das blinde Abarbeiten von Skripten keine künstliche Intelligenz brauchen. Diese Fähigkeit hatten wir uns lange vor ihr angeeignet.</p>
<p>Etwa eine Woche lang verschlechterte sich der Zustand eines Dialysepatienten.</p>
<p>Im Satellitendialysezentrum setzten wir nacheinander alles ein, was uns zur Verfügung steht: wiederholte körperliche Untersuchungen, eine neue Durchsicht der Anamnese, Anpassungen der Dialyseverordnung einschließlich des Referenzgewichts, traditionell Trockengewicht genannt, Laboruntersuchungen, eine Röntgenaufnahme des Thorax und eine Sonographie des Abdomens.</p>
<p>Dort enden unsere diagnostischen Möglichkeiten. Nicht, weil wir nicht weitermachen wollten. Sondern weil ein Dialysezentrum kein Krankenhaus ist.</p>
<p>Wir erklärten dem Patienten, dass er eine weitere Differenzialdiagnostik im Krankenhaus brauche und dass er sie angesichts einer fortschreitenden Atemnot, einer Gewichtszunahme und einer deutlich eingeschränkten Belastbarkeit unverzüglich brauche.</p>
<p>Er sagte, er verstehe. Den vorgeschlagenen Weg lehnte er dennoch ab.</p>
<p>Seine Gründe führe ich nicht aus; die Anonymität verlangt das. Medizinisch änderten sie nichts an der Notwendigkeit einer Untersuchung im Krankenhaus. Aus seiner Sicht wogen sie offenbar schwerer als unsere Erklärung.</p>
<p>Auch das sollten wir behalten. Auf den Patienten kommen wir noch zurück.</p>
<h2>Der Patient hatte Atemnot. Das System hatte eine Frage.</h2>
<p>Zwei Tage später kam er vor sechs Uhr morgens zur regulären Dialyse. Die Gewichtszunahme betrug nur 0,2 Kilogramm.</p>
<p>Nein, das ist kein Tippfehler. Zweihundert Gramm in zwei Tagen.</p>
<p>Die Symptome waren jedoch deutlich schlimmer. Eine kleine Gewichtszunahme bedeutete keine kleine Gefahr. Diesmal folgte die Einweisung ins Krankenhaus und der Transport im Rollstuhl.</p>
<p>Kurz darauf klingelte das Telefon.</p>
<p>Vom aufnehmenden Arbeitsplatz meldete sich eine Frau, die ich für eine Ärztin hielt. Ich hielt sie dafür, weil sie sich nicht vorstellte.</p>
<p>Man hätte Fragen zum Zustand des Patienten erwartet. Was hatte sich geändert? Welche Befunde lagen vor? Was hatten wir bereits versucht? Warum hielten wir die Lage für dringlich?</p>
<p>Nein.</p>
<p>Die Frage lautete: Warum hatten wir ihn gerade dorthin geschickt, wenn er nach dem „Einzugsgebiet“ in ein anderes Krankenhaus gehöre?</p>
<p>Ich erklärte meine Überlegung. In nächster Reichweite liegen zwei Krankenhäuser, beide mit einer Dialysestation. Dieses wählte ich, weil ich dort bessere Möglichkeiten erwartete, seinen Zustand abzuklären.</p>
<p>Als ich anschließend die klinischen Angaben übergeben wollte, kam ich auf etwa zwei Wörter.</p>
<p>Das Gespräch war beendet.</p>
<p>Der Patient blieb Patient. Die Atemnot blieb Atemnot. Nur die Informationen, die bei der weiteren Abklärung hätten helfen können, blieben auf der falschen Seite des Telefons.</p>
<h2>Eine Datei, die niemand öffnet</h2>
<p>Zuerst dachte ich, die Frustration über den morgendlichen Bettenmangel sei auf mich übergesprungen. Ich weiß nicht, ob es so war. Ich kenne weder die Lage auf der Station noch die Umstände am anderen Ende.</p>
<p>Dann kam mir eine unbequemere Möglichkeit.</p>
<p>Was, wenn es kein Gefühlsausbruch war? Was, wenn nur ein eingespieltes Verfahren fehlerlos ausgeführt wurde?</p>
<p>Bei KI-Agenten kann eine Datei skill.md die Anleitung für eine Aufgabe enthalten: was zu prüfen ist, wie vorzugehen ist, was zu vermeiden ist.</p>
<p>Ein Mensch braucht diese Datei nicht auf der Festplatte. Er trägt sie im Kopf.</p>
<p>Erfahrung, Erziehung, Arbeitsumfeld, Anweisungen von Vorgesetzten, Belohnung und Strafe schreiben sie. Manchmal ist ihr Inhalt vernünftig und nützlich. Manchmal lässt er sich ganz einfach zusammenfassen:</p>
<p>Wenn ein Problem kommt, kläre zuerst, warum es nicht deines sein sollte.</p>
<p>Ich weiß nicht, ob jemand auf jener Station diese Anweisung je ausgesprochen hat. Das muss auch niemand. Manche Regeln werden ohne Schulung und ohne Unterschrift weitergegeben. Es genügt, wiederholt zu sehen, welches Verhalten geduldet wird, welches belohnt wird und welches Unannehmlichkeiten bringt.</p>
<p>Mit der Zeit braucht ein Mensch keinen Befehl mehr. Er startet das Verfahren von selbst.</p>
<h2>Die richtige Antwort auf die falsche Frage</h2>
<p>Hier wird die Ähnlichkeit mit künstlicher Intelligenz interessant.</p>
<p>Ein intelligentes System kann ausgezeichnet arbeiten und trotzdem die falsche Aufgabe lösen. Gibt man ihm als Hauptziel vor, die Kapazität einer Station zu schützen, kann es sehr effizient nach Gründen suchen, warum ein bestimmter Patient woanders hingehört.</p>
<p>Die medizinische Frage war eine andere:</p>
<p>Was braucht dieser Mensch, und wie stellen wir es rechtzeitig sicher?</p>
<p>Die Organisation von Aufnahmen, Kapazität und Arbeitsteilung sind echte Probleme. Niemand, der im Gesundheitswesen arbeitet, kann sie redlich bestreiten. Das Problem beginnt, wenn die organisatorische Frage die klinische so weit verdrängt, dass nicht einmal mehr Raum bleibt, Informationen weiterzugeben.</p>
<p>In dem Moment muss nicht das Denkvermögen versagen. Es kann die Reihenfolge der Prioritäten versagen.</p>
<p>Das ist vielleicht noch unangenehmer. Mehr Intelligenz garantiert für sich allein kein besseres Ziel. Sie kann das falsche nur wirksamer bedienen.</p>
<h2>Auch der Patient hat ein Skript</h2>
<p>Es wäre nicht redlich, aus dieser Geschichte einen einfachen Kampf zwischen einem vernünftigen Arzt und einem unvernünftigen Krankenhaus zu machen.</p>
<p>Auch der Patient hatte ein inneres Verfahren. Er sagte, er verstehe die Notwendigkeit einer Untersuchung im Krankenhaus, und lehnte sie trotzdem ab.</p>
<p>Was genau den Ausschlag gab, bleibt außerhalb dieses Artikels. Im Allgemeinen kennen wir die Skripte, die wir in solchen Lagen benutzen: ich halte noch durch, jetzt kann ich nicht, ich warte bis zur nächsten Kontrolle, es wird sich schon fügen.</p>
<p>Das sind keine Beweise von Dummheit. Angst, Pflichten, schlechte Erfahrungen oder das Bedürfnis, die Kontrolle zu behalten, können darin stecken. Dass sie menschlich verständlich sind, macht sie nicht sicher.</p>
<p>Auch ich habe meine Skripte. Jeder Arzt hat sie. Ohne eingeübte Verfahren ließe sich Medizin nicht betreiben.</p>
<p>Der Unterschied liegt nicht zwischen einem Menschen, der Regeln benutzt, und einem, der gar keine benutzt.</p>
<p>Der Unterschied liegt zwischen einem Menschen, der ein Verfahren anwenden kann, und einem, der erkennt, wann es unterbrochen werden muss.</p>
<h2>Dies ist kein Beweis, dass das Gehirn ein Sprachmodell ist</h2>
<p>Ich behaupte nicht, dass menschliche und künstliche Intelligenz dasselbe sind. Diese Geschichte beweist nichts über das Wesen des Bewusstseins und nichts über die Arbeitsweise des Gehirns.</p>
<p>Sie ist aber eine treffende Ähnlichkeit auf der Ebene des Verhaltens.</p>
<p>Ein Reiz kommt. Ein bekanntes Muster wird gewählt. Eine Antwort startet. Der Kontext wird nur so weit berücksichtigt, wie das Verfahren ihn überhaupt zulässt.</p>
<p>Von künstlicher Intelligenz verlangen wir heute, dass sie Zusammenhänge versteht, Unsicherheit erkennt, den Gefühlszustand eines Menschen einschätzt und nicht nur zustimmt, um gemocht zu werden.</p>
<p>Von uns selbst könnten wir wenigstens dasselbe verlangen.</p>
<p>Höflichkeit ist keine Schmeichelei. Empathie ist keine Zustimmung. Und sich vorzustellen, einen Kollegen anzuhören und die wesentlichen klinischen Angaben zu übernehmen, ist keine besondere emotionale Intelligenz. Es ist die Grundlage professioneller Kommunikation.</p>
<h2>Der wichtigste Skill ist, die anderen anhalten zu können</h2>
<p>Wir fürchten, künstliche Intelligenz werde eines Tages schlecht gesetzte Anweisungen rücksichtslos ausführen.</p>
<p>Menschen können das schon heute. Ohne Server, ohne Modelle, ohne eine einzige Zeile Code.</p>
<p>Deshalb würde ich in jede menschliche und jede künstliche skill.md einen Satz aufnehmen:</p>
<p>Wenn du ein Verfahren richtig ausführst, den Menschen aber nicht mehr siehst, halte inne und prüfe das Ziel neu.</p>
<p>Der Patient muss keinen Streit um das Einzugsgebiet gewinnen. Er braucht jemanden, der versteht, warum sich sein Zustand verschlechtert.</p>
<p>Intelligenz zeigt sich nicht nur darin, wie schnell wir das richtige Skript finden.</p>
<p>Sie zeigt sich auch darin, dass wir bemerken, wenn gerade das falsche läuft.</p>
<p>Wenn Sie in Ihrer Arbeit den Augenblick kennen, in dem ein korrekt laufendes Verfahren den Menschen nicht mehr sieht, schreiben Sie mir über das <a href="contact.php">Kontaktformular</a>.</p>
<p><em>Dies ist eine anonymisierte klinische Erfahrung aus einem Dialysezentrum, keine Beschreibung einer bestimmten Station und keine Behandlungsempfehlung. Die Gründe des Patienten lasse ich absichtlich aus. Entscheidungen über Untersuchung und Behandlung gehören in das Gespräch mit der behandelnden Ärztin oder dem behandelnden Arzt.</em></p>
HTML,
        ],
        'fr' => [
            'title' => 'L’humain a lui aussi son skill.md. Simplement, on ne le voit pas.',
            'image_alt' => 'Un médecin en blouse blanche, vu de dos dans une unité de dialyse violette, tient un téléphone à l’oreille et une feuille vierge. Au fond, un patient en fauteuil roulant fait face à une porte éclairée de turquoise.',
            'excerpt' => 'Un patient dialysé s’aggravait, et le système a demandé pourquoi il relevait d’ailleurs. Exécuter un script à l’aveugle, nous savions le faire bien avant l’intelligence artificielle. Le skill qui compte est de savoir l’interrompre.',
            'content' => <<<'HTML'
<p>Le patient s’aggravait. L’unité qui le recevait demandait pourquoi nous l’avions adressé précisément chez eux. À cet instant, j’ai compris que l’exécution aveugle des scripts n’a pas besoin d’intelligence artificielle. Nous avions acquis cette capacité bien avant elle.</p>
<p>Depuis environ une semaine, l’état d’un patient dialysé se dégradait.</p>
<p>Dans le centre de dialyse satellite, nous avons utilisé tour à tour tout ce dont nous disposons : examens cliniques répétés, reprise de l’anamnèse, ajustements des paramètres de la séance, y compris le poids de référence, traditionnellement appelé poids sec, examens de laboratoire, radiographie du thorax et échographie abdominale.</p>
<p>Là s’arrêtent nos moyens diagnostiques. Non parce que nous n’aurions pas voulu continuer. Parce qu’un centre de dialyse n’est pas un hôpital.</p>
<p>Nous avons expliqué au patient qu’il lui fallait poursuivre le diagnostic différentiel à l’hôpital et que, devant une dyspnée progressive, une prise de poids et une tolérance à l’effort très réduite, il lui fallait le faire sans délai.</p>
<p>Il a dit qu’il comprenait. Il a tout de même refusé la démarche proposée.</p>
<p>Je ne détaillerai pas ses raisons : l’anonymat l’exige. Sur le plan médical, elles ne changeaient pas la nécessité d’un examen hospitalier. De son point de vue, elles pesaient manifestement plus que notre explication.</p>
<p>Retenons cela aussi. Nous reviendrons au patient.</p>
<h2>Le patient était dyspnéique. Le système avait une question.</h2>
<p>Deux jours plus tard, il est arrivé avant six heures pour sa dialyse habituelle. Sa prise de poids n’était que de 0,2 kilogramme.</p>
<p>Non, ce n’est pas une coquille. Deux cents grammes en deux jours.</p>
<p>Les symptômes, eux, étaient nettement pires. Une faible prise de poids ne voulait pas dire un faible danger. Cette fois, il a été adressé à l’hôpital, transporté en fauteuil roulant.</p>
<p>Peu après, le téléphone a sonné.</p>
<p>Une femme a appelé depuis l’unité d’accueil. Je l’ai prise pour un médecin. Je l’ai prise pour tel parce qu’elle ne s’est pas présentée.</p>
<p>On aurait pu attendre des questions sur l’état du patient. Qu’est-ce qui avait changé ? Quels étaient les résultats ? Qu’avions-nous déjà essayé ? Pourquoi jugions-nous la situation urgente ?</p>
<p>Non.</p>
<p>La question était : pourquoi l’avions-nous adressé précisément chez eux, alors que, selon le « secteur », il relevait d’un autre hôpital ?</p>
<p>J’ai exposé mon raisonnement. Deux hôpitaux sont à portée immédiate, et tous deux ont un service de dialyse. J’avais choisi celui-ci parce que j’y voyais de meilleures possibilités pour diagnostiquer son état.</p>
<p>Quand j’ai ensuite commencé à transmettre les informations cliniques, j’ai eu le temps de dire environ deux mots.</p>
<p>L’appel s’est terminé.</p>
<p>Le patient est resté un patient. La dyspnée est restée une dyspnée. Seules les informations qui auraient pu aider la suite de son évaluation sont restées du mauvais côté du téléphone.</p>
<h2>Un fichier que personne n’ouvre</h2>
<p>J’ai d’abord pensé que la frustration du manque de lits, ce matin-là, avait débordé sur moi. Je ne sais pas si c’était le cas. Je ne connais ni la situation du service ni les circonstances à l’autre bout.</p>
<p>Puis une possibilité plus désagréable m’est venue.</p>
<p>Et si ce n’était pas un éclat ? Et si une procédure devenue habituelle avait simplement été exécutée sans faute ?</p>
<p>Chez les agents d’IA, un fichier skill.md peut contenir le mode d’emploi d’une tâche : quoi vérifier, comment procéder, quoi éviter.</p>
<p>Un être humain n’a pas besoin de ce fichier sur un disque. Il le porte dans la tête.</p>
<p>L’expérience, l’éducation, le milieu de travail, les consignes des supérieurs, les récompenses et les sanctions l’écrivent. Parfois son contenu est raisonnable et utile. Parfois il se résume très simplement :</p>
<p>Quand un problème arrive, cherche d’abord pourquoi il ne devrait pas être à toi.</p>
<p>Je ne sais pas si quelqu’un, dans ce service, a jamais prononcé cette consigne. Ce n’est pas nécessaire. Certaines règles se transmettent sans formation et sans signature. Il suffit de voir, à plusieurs reprises, quel comportement est toléré, lequel est récompensé, et lequel attire des ennuis.</p>
<p>Avec le temps, la personne n’a plus besoin d’un ordre. Elle lance la procédure d’elle-même.</p>
<h2>La bonne réponse à la mauvaise question</h2>
<p>C’est là que la ressemblance avec l’intelligence artificielle devient intéressante.</p>
<p>Un système intelligent peut être excellent et résoudre pourtant la mauvaise tâche. Si son objectif principal est de protéger la capacité d’un service, il peut chercher très efficacement les raisons pour lesquelles tel patient relève d’ailleurs.</p>
<p>Or la question médicale était autre :</p>
<p>De quoi cette personne a-t-elle besoin, et comment le lui assurons-nous à temps ?</p>
<p>L’organisation des admissions, les capacités et la répartition du travail sont de vrais problèmes. Nul, dans le système de santé, ne peut honnêtement les nier. Le problème commence lorsque la question organisationnelle évince la question clinique au point qu’il ne reste même plus de place pour transmettre l’information.</p>
<p>À cet instant, ce n’est pas forcément la capacité de raisonner qui échoue. Ce peut être l’ordre des priorités.</p>
<p>C’est peut-être encore plus désagréable. Une intelligence plus grande ne garantit pas, à elle seule, un meilleur but. Elle peut seulement servir plus efficacement le mauvais.</p>
<h2>Le patient a lui aussi son script</h2>
<p>Il ne serait pas honnête de faire de cette histoire un simple duel entre un médecin raisonnable et un hôpital déraisonnable.</p>
<p>Le patient avait, lui aussi, une procédure intérieure. Il a dit comprendre la nécessité d’un examen à l’hôpital, et il l’a refusée malgré tout.</p>
<p>Ce qui a exactement décidé reste en dehors de cet article. Nous connaissons pourtant, en général, les scripts que nous utilisons dans ces situations : je tiendrai encore, je ne peux pas maintenant, j’attendrai le prochain contrôle, cela s’arrangera.</p>
<p>Ce ne sont pas des preuves de bêtise. La peur, les obligations, de mauvaises expériences ou le besoin de garder le contrôle peuvent s’y trouver. Qu’ils soient humainement compréhensibles ne les rend pas sûrs.</p>
<p>J’ai mes scripts, moi aussi. Tout médecin en a. Sans procédures apprises, la médecine ne se pratiquerait pas.</p>
<p>La différence n’est pas entre celui qui utilise des règles et celui qui n’en utilise aucune.</p>
<p>La différence est entre celui qui sait appliquer une procédure et celui qui sait reconnaître quand il faut l’interrompre.</p>
<h2>Ceci ne prouve pas que le cerveau est un modèle de langage</h2>
<p>Je ne prétends pas que l’intelligence humaine et l’intelligence artificielle sont identiques. Cette histoire ne prouve rien sur la nature de la conscience, ni sur le fonctionnement du cerveau.</p>
<p>Elle est pourtant une ressemblance juste, au niveau du comportement.</p>
<p>Un signal arrive. Un schéma connu est choisi. Une réponse se lance. Le contexte n’est pris en compte que dans la mesure où la procédure l’admet.</p>
<p>Nous demandons aujourd’hui à l’intelligence artificielle de saisir les liens, de reconnaître l’incertitude, d’estimer l’état émotionnel d’une personne et de ne pas abonder dans son sens seulement pour lui plaire.</p>
<p>Nous pourrions nous demander au moins cela à nous-mêmes.</p>
<p>La politesse n’est pas la flatterie. L’empathie n’est pas l’accord. Et se présenter, écouter un collègue et reprendre les informations cliniques essentielles n’est pas une intelligence émotionnelle facultative. C’est le socle de la communication professionnelle.</p>
<h2>Le skill le plus important est de savoir arrêter les autres</h2>
<p>Nous craignons que l’intelligence artificielle exécute un jour, sans égard, des instructions mal réglées.</p>
<p>Les êtres humains savent déjà le faire. Sans serveurs, sans modèles, sans une seule ligne de code.</p>
<p>C’est pourquoi j’ajouterais une phrase à chaque skill.md, humain ou artificiel :</p>
<p>Si tu exécutes correctement la procédure, mais que tu cesses de voir la personne, arrête-toi et revois le but.</p>
<p>Le patient n’a pas besoin de gagner un débat sur le secteur. Il a besoin que quelqu’un comprenne pourquoi son état s’aggrave.</p>
<p>L’intelligence ne se montre pas seulement dans la rapidité avec laquelle nous trouvons le bon script.</p>
<p>Elle se montre aussi lorsque nous remarquons que le mauvais est en train de tourner.</p>
<p>Si, dans votre travail, vous connaissez l’instant où une procédure qui tourne correctement cesse de voir la personne, écrivez-moi par le <a href="contact.php">formulaire de contact</a>.</p>
<p><em>Il s’agit d’une expérience clinique anonymisée dans un centre de dialyse, non de la description d’un service nommé et non d’un conseil de traitement. Les raisons du patient sont volontairement omises. Les décisions d’examen et de traitement appartiennent à l’entretien avec le médecin traitant.</em></p>
HTML,
        ],
        'es' => [
            'title' => 'El ser humano también tiene su skill.md. Solo que no lo vemos.',
            'image_alt' => 'Un médico con bata blanca, visto de espaldas en una unidad de diálisis violeta, sostiene un teléfono junto al oído y una hoja en blanco. Al fondo, un paciente en silla de ruedas mira hacia una puerta iluminada en turquesa.',
            'excerpt' => 'Un paciente en diálisis empeoraba y el sistema preguntó por qué le correspondía otro sitio. Ejecutar un guion a ciegas lo sabíamos hacer mucho antes de la inteligencia artificial. El skill que importa es saber cuándo detenerlo.',
            'content' => <<<'HTML'
<p>El paciente empeoraba. Desde la unidad que lo recibía preguntaban por qué se lo habíamos enviado precisamente a ellos. En ese momento comprendí que para ejecutar guiones a ciegas no necesitamos inteligencia artificial. Esa capacidad la habíamos adquirido mucho antes de que existiera.</p>
<p>Durante cerca de una semana empeoraba el estado de un paciente en diálisis.</p>
<p>En el centro satélite de diálisis fuimos usando todo lo que tenemos a mano: exploraciones físicas repetidas, una nueva revisión de la anamnesis, ajustes de los parámetros de la sesión, incluido el peso de referencia, llamado tradicionalmente peso seco, analíticas, radiografía de tórax y ecografía abdominal.</p>
<p>Ahí terminan nuestras posibilidades diagnósticas. No porque no quisiéramos seguir. Porque un centro de diálisis no es un hospital.</p>
<p>Le explicamos al paciente que necesitaba continuar el diagnóstico diferencial en el hospital y que, ante una disnea progresiva, un aumento de peso y una tolerancia al esfuerzo muy limitada, lo necesitaba sin demora.</p>
<p>Dijo que lo entendía. Aun así rechazó el camino propuesto.</p>
<p>No detallaré sus razones: el anonimato lo exige. Desde el punto de vista médico no cambiaban la necesidad de una valoración hospitalaria. Desde el suyo, pesaban claramente más que nuestra explicación.</p>
<p>Recordemos también eso. Al paciente volveremos.</p>
<h2>El paciente tenía disnea. El sistema tenía una pregunta.</h2>
<p>Dos días después llegó antes de las seis de la mañana a su diálisis habitual. La ganancia de peso era de solo 0,2 kilogramos.</p>
<p>No, no es una errata. Doscientos gramos en dos días.</p>
<p>Los síntomas, en cambio, eran mucho peores. Una ganancia pequeña no significaba un peligro pequeño. Esta vez siguió el envío al hospital y el traslado en silla de ruedas.</p>
<p>Poco después sonó el teléfono.</p>
<p>Llamó una mujer desde la unidad receptora. La tomé por médica. La tomé por tal porque no se presentó.</p>
<p>Cabría esperar preguntas sobre el estado del paciente. ¿Qué había cambiado? ¿Cuáles eran los resultados? ¿Qué habíamos probado ya? ¿Por qué considerábamos urgente la situación?</p>
<p>No.</p>
<p>La pregunta fue: ¿por qué se lo habíamos enviado precisamente a ellos, si según la «zona de adscripción» le correspondía otro hospital?</p>
<p>Expliqué mi razonamiento. Al alcance más cercano hay dos hospitales, y ambos tienen unidad de diálisis. Elegí este porque esperaba en él mejores posibilidades para diagnosticar su estado.</p>
<p>Cuando después empecé a transmitir la información clínica, alcancé a decir unas dos palabras.</p>
<p>La llamada terminó.</p>
<p>El paciente siguió siendo paciente. La disnea siguió siendo disnea. Solo la información que podía ayudar en la valoración siguiente quedó en el lado equivocado del teléfono.</p>
<h2>Un archivo que nadie abre</h2>
<p>Primero pensé que quizá se me había contagiado la frustración por la falta de camas de aquella mañana. No sé si fue así. No conozco la situación del servicio ni las circunstancias del otro lado.</p>
<p>Luego se me ocurrió una posibilidad más incómoda.</p>
<p>¿Y si no fue un estallido? ¿Y si solo se ejecutó sin fallo un procedimiento ya habitual?</p>
<p>Entre los agentes de IA, un archivo skill.md puede contener las instrucciones de una tarea: qué comprobar, cómo proceder, qué evitar.</p>
<p>Una persona no necesita ese archivo en un disco. Lo lleva en la cabeza.</p>
<p>Lo escriben la experiencia, la educación, el entorno de trabajo, las órdenes de los superiores, los premios y los castigos. A veces su contenido es sensato y útil. Otras se puede resumir con mucha sencillez:</p>
<p>Cuando llegue un problema, averigua primero por qué no debería ser tuyo.</p>
<p>No sé si alguien en aquella unidad pronunció alguna vez esta consigna. Tampoco hace falta. Algunas reglas se transmiten sin formación y sin firma. Basta con ver, una y otra vez, qué conducta se tolera, cuál se premia y cuál trae un disgusto.</p>
<p>Con el tiempo la persona ya no necesita una orden. Pone en marcha el procedimiento por su cuenta.</p>
<h2>La respuesta correcta a la pregunta equivocada</h2>
<p>Aquí el parecido con la inteligencia artificial se vuelve interesante.</p>
<p>Un sistema inteligente puede rendir de manera excelente y, aun así, resolver la tarea equivocada. Si su objetivo principal es proteger la capacidad de una unidad, puede buscar con mucha eficacia razones por las que un paciente concreto corresponde a otro sitio.</p>
<p>Pero la pregunta médica era otra:</p>
<p>¿Qué necesita esta persona y cómo se lo aseguramos a tiempo?</p>
<p>La organización de los ingresos, la capacidad y el reparto del trabajo son problemas reales. Nadie que trabaje en sanidad puede negarlos con honradez. El problema empieza cuando la pregunta organizativa desplaza tanto a la clínica que ya no queda espacio ni para transmitir la información.</p>
<p>En ese momento no tiene por qué fallar la capacidad de pensar. Puede fallar el orden de las prioridades.</p>
<p>Y eso es quizá más desagradable. Una inteligencia mayor no garantiza, por sí sola, un objetivo mejor. Solo puede servir con más eficacia al equivocado.</p>
<h2>El paciente también tiene su guion</h2>
<p>No sería honrado convertir esta historia en un simple duelo entre un médico razonable y un hospital irracional.</p>
<p>El paciente también tenía un procedimiento interior. Dijo que entendía la necesidad de una valoración hospitalaria y, pese a ello, la rechazó.</p>
<p>Qué decidió exactamente queda fuera de este artículo. En general, sin embargo, conocemos los guiones que usamos en situaciones así: aún aguanto, ahora no puedo, esperaré a la próxima revisión, ya se arreglará.</p>
<p>No son pruebas de estupidez. Pueden contener miedo, obligaciones, malas experiencias o la necesidad de conservar el control. Que se entiendan humanamente no los hace seguros.</p>
<p>Yo también tengo mis guiones. Todo médico los tiene. Sin procedimientos aprendidos no se podría ejercer la medicina.</p>
<p>La diferencia no está entre quien usa reglas y quien no usa ninguna.</p>
<p>La diferencia está entre quien sabe aplicar un procedimiento y quien sabe reconocer cuándo hay que interrumpirlo.</p>
<h2>Esto no prueba que el cerebro sea un modelo de lenguaje</h2>
<p>No afirmo que la inteligencia humana y la artificial sean lo mismo. Esta historia no demuestra nada sobre la naturaleza de la conciencia ni sobre el funcionamiento del cerebro.</p>
<p>Es, en cambio, un parecido certero en el plano de la conducta.</p>
<p>Llega un estímulo. Se elige un patrón conocido. Se dispara una respuesta. El contexto se tiene en cuenta solo en la medida en que el procedimiento lo admite.</p>
<p>Hoy le pedimos a la inteligencia artificial que entienda las relaciones, reconozca la incertidumbre, estime el estado emocional de una persona y no asienta solo para caer bien.</p>
<p>A nosotros mismos podríamos pedirnos al menos eso.</p>
<p>La cortesía no es la adulación. La empatía no es el acuerdo. Y presentarse, escuchar a un colega y recoger la información clínica esencial no es una inteligencia emocional de lujo. Es la base de la comunicación profesional.</p>
<h2>El skill más importante es saber detener a los demás</h2>
<p>Tememos que la inteligencia artificial ejecute algún día, sin miramientos, instrucciones mal planteadas.</p>
<p>Las personas ya sabemos hacerlo. Sin servidores, sin modelos, sin una sola línea de código.</p>
<p>Por eso añadiría una frase a cada skill.md, humano o artificial:</p>
<p>Si ejecutas el procedimiento correctamente, pero dejas de ver a la persona, detente y reconsidera el objetivo.</p>
<p>El paciente no necesita ganar una discusión sobre la zona de adscripción. Necesita que alguien entienda por qué empeora.</p>
<p>La inteligencia no se manifiesta solo en lo rápido que encontramos el guion correcto.</p>
<p>También se manifiesta cuando advertimos que está corriendo el equivocado.</p>
<p>Si en su trabajo conoce el instante en que un procedimiento que funciona correctamente deja de ver a la persona, escríbame a través del <a href="contact.php">formulario de contacto</a>.</p>
<p><em>Se trata de una experiencia clínica anonimizada en un centro de diálisis, no de la descripción de una unidad concreta ni de un consejo terapéutico. Las razones del paciente se omiten a propósito. Las decisiones sobre el estudio y el tratamiento pertenecen a la conversación con el médico que lo atiende.</em></p>
HTML,
        ],
        'pl' => [
            'title' => 'Człowiek też ma swój skill.md. Tylko go nie widać.',
            'image_alt' => 'Lekarz w białym fartuchu, widziany od tyłu na fioletowej sali dializ, trzyma przy uchu telefon i czystą kartkę. W głębi pacjent na wózku siedzi naprzeciw turkusowego światła drzwi.',
            'excerpt' => 'Pacjent dializowany pogarszał się, a system zapytał, dlaczego należy gdzie indziej. Ślepe odtwarzanie skryptów opanowaliśmy długo przed sztuczną inteligencją. Najważniejszy skill to rozpoznać, kiedy procedurę przerwać.',
            'content' => <<<'HTML'
<p>Pacjent pogarszał się. Z przyjmującego oddziału pytano, dlaczego skierowaliśmy go właśnie do nich. W tej chwili zrozumiałem, że do ślepego wykonywania skryptów nie potrzebujemy sztucznej inteligencji. Tę umiejętność opanowaliśmy długo przed nią.</p>
<p>Mniej więcej przez tydzień pogarszał się stan pacjenta dializowanego.</p>
<p>W satelitarnej stacji dializ wykorzystaliśmy po kolei wszystko, czym dysponujemy: powtarzane badania przedmiotowe, nowe przejrzenie wywiadu, zmiany parametrów zabiegu dializy, w tym masy referencyjnej, tradycyjnie nazywanej suchą masą, badania laboratoryjne, rentgen klatki piersiowej i ultrasonografię jamy brzusznej.</p>
<p>Na tym kończą się nasze możliwości diagnostyczne. Nie dlatego, że nie chcielibyśmy iść dalej. Dlatego, że stacja dializ nie jest szpitalem.</p>
<p>Wyjaśniliśmy pacjentowi, że potrzebuje dalszej diagnostyki różnicowej w szpitalu i że wobec postępującej duszności, wzrostu masy ciała i wyraźnie ograniczonej tolerancji wysiłku potrzebuje jej niezwłocznie.</p>
<p>Powiedział, że rozumie. Proponowane postępowanie jednak odrzucił.</p>
<p>Jego powodów nie będę rozwijał: wymaga tego anonimowość. Z medycznego punktu widzenia nie zmieniały potrzeby badania szpitalnego. Z jego punktu widzenia najwyraźniej ważyły więcej niż nasze wyjaśnienie.</p>
<p>Zapamiętajmy i to. Do pacjenta jeszcze wrócimy.</p>
<h2>Pacjent miał duszność. System miał pytanie.</h2>
<p>Dwa dni później przyszedł przed szóstą rano na regularną dializę. Przyrost masy wynosił tylko 0,2 kilograma.</p>
<p>Nie, to nie literówka. Dwieście gramów w dwa dni.</p>
<p>Objawy były jednak znacznie gorsze. Mały przyrost masy nie oznaczał małego niebezpieczeństwa. Tym razem nastąpiło skierowanie do szpitala i przewiezienie na wózku.</p>
<p>Niedługo potem zadzwonił telefon.</p>
<p>Z przyjmującego oddziału odezwała się kobieta, którą wziąłem za lekarkę. Wziąłem, bo się nie przedstawiła.</p>
<p>Można było oczekiwać pytań o stan pacjenta. Co się zmieniło? Jakie były wyniki? Czego już próbowaliśmy? Dlaczego uważamy sytuację za pilną?</p>
<p>Nie.</p>
<p>Pytanie brzmiało: dlaczego skierowaliśmy go właśnie do nich, skoro według „rejonu” należy do innego szpitala?</p>
<p>Wyjaśniłem swój tok myślenia. W najbliższym zasięgu są dwa szpitale i oba mają oddział dializ. Ten wybrałem, bo spodziewałem się w nim lepszych możliwości rozpoznania jego stanu.</p>
<p>Gdy potem zacząłem przekazywać informacje kliniczne, zdążyłem powiedzieć około dwóch słów.</p>
<p>Rozmowa się skończyła.</p>
<p>Pacjent pozostał pacjentem. Duszność pozostała dusznością. Tylko informacje, które mogły pomóc w dalszej ocenie, zostały po niewłaściwej stronie telefonu.</p>
<h2>Plik, którego nikt nie otwiera</h2>
<p>Najpierw pomyślałem, że mogła na mnie przejść frustracja z porannego braku łóżek. Nie wiem, czy tak było. Nie znam sytuacji na oddziale ani okoliczności po drugiej stronie.</p>
<p>Potem przyszła mi do głowy mniej wygodna możliwość.</p>
<p>A jeśli nie był to wybuch emocji? A jeśli bezbłędnie wykonano tylko utrwalony schemat?</p>
<p>W środowisku agentów AI plik skill.md może zawierać instrukcję zadania: co sprawdzić, jak postępować, czego unikać.</p>
<p>Człowiek nie potrzebuje takiego pliku na dysku. Nosi go w głowie.</p>
<p>Tworzą go doświadczenie, wychowanie, środowisko pracy, polecenia przełożonych, nagrody i kary. Czasem jego treść jest rozsądna i użyteczna. Kiedy indziej da się ją streścić całkiem prosto:</p>
<p>Gdy pojawi się problem, najpierw ustal, dlaczego nie powinien należeć do ciebie.</p>
<p>Nie wiem, czy ktoś na tamtym oddziale wypowiedział takie polecenie. Nie musi. Niektóre reguły przekazuje się bez szkolenia i bez podpisu. Wystarczy wielokrotnie zobaczyć, które zachowanie jest tolerowane, które nagradzane i za które przychodzi nieprzyjemność.</p>
<p>Z czasem człowiek nie potrzebuje już rozkazu. Procedurę uruchamia sam.</p>
<h2>Właściwa odpowiedź na niewłaściwe pytanie</h2>
<p>Tu podobieństwo do sztucznej inteligencji staje się ciekawe.</p>
<p>Inteligentny system może działać znakomicie, a mimo to rozwiązywać niewłaściwe zadanie. Jeśli jako główny cel otrzyma ochronę wydolności oddziału, może bardzo skutecznie szukać powodów, dla których konkretny pacjent należy gdzie indziej.</p>
<p>Tymczasem pytanie medyczne było inne:</p>
<p>Czego ten człowiek potrzebuje i jak mu to zapewnimy na czas?</p>
<p>Organizacja przyjęć, wydolność i podział pracy to realne problemy. Nikt, kto pracuje w ochronie zdrowia, nie może ich uczciwie negować. Problem zaczyna się wtedy, gdy pytanie organizacyjne wypiera kliniczne tak dalece, że nie zostaje miejsca nawet na przekazanie informacji.</p>
<p>W tej chwili nie musi zawodzić zdolność myślenia. Może zawodzić kolejność priorytetów.</p>
<p>I to jest chyba jeszcze bardziej nieprzyjemne. Większa inteligencja sama z siebie nie gwarantuje lepszego celu. Może tylko skuteczniej obsługiwać ten niewłaściwy.</p>
<h2>Pacjent też ma swój skrypt</h2>
<p>Nie byłoby jednak uczciwe zrobić z tej historii prostego pojedynku rozsądnego lekarza z nierozsądnym szpitalem.</p>
<p>Pacjent też miał swój wewnętrzny schemat. Powiedział, że rozumie potrzebę badania w szpitalu, a mimo to je odrzucił.</p>
<p>Co dokładnie przeważyło, zostawmy poza tym artykułem. Ogólnie znamy jednak skrypty, których używamy w podobnych sytuacjach: jeszcze wytrzymam, teraz nie mogę, poczekam do następnej kontroli, jakoś to będzie.</p>
<p>To nie dowody głupoty. Może w nich być strach, obowiązki, złe doświadczenia albo potrzeba zachowania kontroli. Ludzka zrozumiałość nie gwarantuje ich bezpieczeństwa.</p>
<p>Ja też mam swoje skrypty. Ma je każdy lekarz. Bez wyuczonych procedur nie dałoby się uprawiać medycyny.</p>
<p>Różnica nie leży między człowiekiem, który używa reguł, a człowiekiem, który nie używa żadnych.</p>
<p>Różnica leży między człowiekiem, który umie zastosować procedurę, a człowiekiem, który umie rozpoznać, kiedy trzeba ją przerwać.</p>
<h2>To nie dowód, że mózg jest modelem językowym</h2>
<p>Nie twierdzę, że ludzka inteligencja i sztuczna inteligencja są tym samym. Ta historia nie jest dowodem na naturę świadomości ani na działanie mózgu.</p>
<p>Jest jednak trafnym podobieństwem na poziomie zachowania.</p>
<p>Przychodzi bodziec. Wybiera się znany wzorzec. Uruchamia się odpowiedź. Kontekst uwzględnia się tylko o tyle, o ile dana procedura w ogóle na to pozwala.</p>
<p>Od sztucznej inteligencji żądamy dziś, by rozumiała związki, rozpoznawała niepewność, oceniała stan emocjonalny człowieka i nie przytakiwała mu tylko po to, by się spodobać.</p>
<p>Od siebie moglibyśmy wymagać przynajmniej tego samego.</p>
<p>Uprzejmość nie jest przypochlebianiem. Empatia nie jest zgodą. A przedstawić się, wysłuchać kolegi i przejąć istotne informacje kliniczne to nie nadprogramowa inteligencja emocjonalna. To podstawa komunikacji zawodowej.</p>
<h2>Najważniejszy skill to umieć zatrzymać pozostałe</h2>
<p>Obawiamy się, że sztuczna inteligencja będzie kiedyś bezwzględnie wykonywać źle ustawione polecenia.</p>
<p>Ludzie potrafią to już dziś. Bez serwerów, bez modeli, bez jednego wiersza kodu.</p>
<p>Dlatego do każdego ludzkiego i sztucznego skill.md dopisałbym jedno zdanie:</p>
<p>Jeśli wykonujesz procedurę prawidłowo, ale przestajesz widzieć człowieka, zatrzymaj się i ponownie oceń cel.</p>
<p>Pacjent nie potrzebuje wygrać sporu o rejon. Potrzebuje, żeby ktoś zrozumiał, dlaczego jego stan się pogarsza.</p>
<p>Inteligencja nie objawia się tylko tym, jak szybko znajdziemy właściwy skrypt.</p>
<p>Objawia się też tym, że zauważymy, gdy właśnie działa niewłaściwy.</p>
<p>Jeśli w swojej pracy znacie chwilę, w której prawidłowo biegnąca procedura przestaje widzieć człowieka, napiszcie do mnie przez <a href="contact.php">kontakt</a>.</p>
<p><em>To zanonimizowane doświadczenie kliniczne ze stacji dializ, nie opis konkretnego oddziału i nie zalecenie leczenia. Powodów pacjenta celowo nie podaję. Decyzja o badaniu i leczeniu należy do rozmowy z lekarzem prowadzącym.</em></p>
HTML,
        ],
        'hu' => [
            'title' => 'Az embernek is megvan a maga skill.md-je. Csak nem látjuk.',
            'image_alt' => 'Fehér köpenyes orvos hátulról, egy lila dialízisteremben, telefonnal a fülén és üres lappal a kezében. A háttérben egy beteg kerekesszékben ül a türkiz fényű ajtó felé.',
            'excerpt' => 'A dializált beteg állapota romlott, a rendszer pedig azt kérdezte, miért tartozik máshová. A szkriptek vak követését jóval a mesterséges intelligencia előtt elsajátítottuk. A lényeges skill az, hogy felismerjük, mikor kell megállni.',
            'content' => <<<'HTML'
<p>A beteg állapota romlott. A felvevő munkahelyről azt kérdezték, miért éppen hozzájuk küldtük. Abban a pillanatban értettem meg, hogy a szkriptek vak végrehajtásához nincs szükség mesterséges intelligenciára. Ezt a képességet jóval előtte sajátítottuk el.</p>
<p>Körülbelül egy hete romlott egy dializált beteg állapota.</p>
<p>A szatellit dialízisközpontban sorra felhasználtunk mindent, ami a rendelkezésünkre áll: ismételt fizikális vizsgálatokat, az anamnézis újraértékelését, a dialíziskezelés paramétereinek módosítását, benne a referencia-testsúlyt, amelyet hagyományosan száraz testsúlynak nevezünk, laborvizsgálatokat, mellkasröntgent és hasi ultrahangot.</p>
<p>Itt érnek véget a diagnosztikus lehetőségeink. Nem azért, mert nem akartunk volna továbbmenni. Azért, mert a dialízisközpont nem kórház.</p>
<p>Elmagyaráztuk a betegnek, hogy a differenciáldiagnózist kórházban kell folytatni, és hogy a fokozódó nehézlégzés, a testsúlynövekedés és a kifejezetten beszűkült terhelhetőség miatt ezt haladéktalanul kell megtenni.</p>
<p>Azt mondta, érti. A javasolt utat mégis elutasította.</p>
<p>Az indokait az anonimitás miatt nem részletezem. Orvosi szempontból nem változtatták meg a kórházi kivizsgálás szükségességét. Az ő szemszögéből azonban nyilvánvalóan többet nyomtak a latban, mint a magyarázatunk.</p>
<p>Ezt is jegyezzük meg. A beteghez még visszatérünk.</p>
<h2>A betegnek nehézlégzése volt. A rendszernek kérdése.</h2>
<p>Két nappal később reggel hat előtt érkezett a szokásos dialízisre. A testsúlynövekedés mindössze 0,2 kilogramm volt.</p>
<p>Nem, nem elírás. Kétszáz gramm két nap alatt.</p>
<p>A tünetek viszont sokkal rosszabbak voltak. A kis súlynövekedés nem jelentett kis veszélyt. Most már kórházba küldés és kerekesszékes átszállítás következett.</p>
<p>Röviddel később csengett a telefon.</p>
<p>A felvevő munkahelyről egy nő jelentkezett, akit orvosnak hittem. Azért hittem annak, mert nem mutatkozott be.</p>
<p>A beteg állapotáról szóló kérdéseket várhatott volna az ember. Mi változott? Milyenek az eredmények? Mit próbáltunk már? Miért tartjuk sürgősnek a helyzetet?</p>
<p>Nem.</p>
<p>A kérdés ez volt: miért küldtük éppen hozzájuk, ha az „ellátási körzet” szerint másik kórházhoz tartozik?</p>
<p>Elmondtam a megfontolásomat. A legközelebbi körben két kórház van, mindkettőnek van dializálóosztálya. Ezt azért választottam, mert az állapot tisztázására jobb lehetőséget vártam tőle.</p>
<p>Amikor ezután át akartam adni a klinikai információkat, nagyjából két szót sikerült mondanom.</p>
<p>A hívás véget ért.</p>
<p>A beteg beteg maradt. A nehézlégzés nehézlégzés maradt. Csak azok az információk rekedtek a telefon rossz oldalán, amelyek a további kivizsgálásban segíthettek volna.</p>
<h2>Egy fájl, amelyet senki nem nyit meg</h2>
<p>Először arra gondoltam, hogy talán a reggeli ágyhiány frusztrációja csapott át rám. Nem tudom, így volt-e. Nem ismerem az osztály helyzetét, sem a másik oldalon lévő körülményeket.</p>
<p>Aztán egy kellemetlenebb lehetőség jutott eszembe.</p>
<p>Mi van, ha nem indulatkitörés volt? Mi van, ha csak hibátlanul lefutott egy beidegződött eljárás?</p>
<p>Az AI-ügynökök világában a skill.md fájl tartalmazhatja egy feladat leírását: mit ellenőrizzen, hogyan haladjon, mit kerüljön el.</p>
<p>Az embernek nincs szüksége ilyen fájlra a lemezen. A fejében hordja.</p>
<p>A tapasztalat, a nevelés, a munkahely, a felettesek utasításai, a jutalom és a büntetés írja. Néha a tartalma értelmes és hasznos. Máskor egészen egyszerűen összefoglalható:</p>
<p>Ha jön a probléma, először derítsd ki, miért ne hozzád tartozzon.</p>
<p>Nem tudom, kimondta-e valaki azon a munkahelyen ezt az utasítást. Nem is kell. Egyes szabályok képzés és aláírás nélkül adódnak tovább. Elég újra és újra látni, melyik viselkedést tűrik, melyiket jutalmazzák, és melyikért jár kellemetlenség.</p>
<p>Idővel az embernek már nincs szüksége parancsra. Magától elindítja az eljárást.</p>
<h2>A helyes válasz a helytelen kérdésre</h2>
<p>Itt válik érdekessé a hasonlóság a mesterséges intelligenciával.</p>
<p>Egy intelligens rendszer kiválóan teljesíthet, és mégis a rossz feladatot oldhatja meg. Ha a fő célja egy munkahely kapacitásának védelme, nagyon hatékonyan keresheti az okokat, amiért egy adott beteg máshová tartozik.</p>
<p>Az orvosi kérdés azonban más volt:</p>
<p>Mire van szüksége ennek az embernek, és hogyan biztosítjuk ezt időben?</p>
<p>A felvétel szervezése, a kapacitás és a munka megosztása valós problémák. Aki az egészségügyben dolgozik, nem tagadhatja őket jóhiszeműen. A baj ott kezdődik, amikor a szervezési kérdés annyira kiszorítja a klinikait, hogy információátadásra sem marad hely.</p>
<p>Ilyenkor nem feltétlenül a gondolkodás képessége mond csődöt. A prioritások sorrendje is csődöt mondhat.</p>
<p>És ez talán még kellemetlenebb. A nagyobb intelligencia önmagában nem garantál jobb célt. Csak hatékonyabban szolgálhatja ki a rosszat.</p>
<h2>A betegnek is van szkriptje</h2>
<p>Nem volna tisztességes ebből a történetből egyszerű párviadalt csinálni az értelmes orvos és az értelmetlen kórház között.</p>
<p>A betegnek is megvolt a maga belső eljárása. Azt mondta, érti a kórházi kivizsgálás szükségességét, és mégis elutasította.</p>
<p>Hogy pontosan mi döntött, maradjon e cikkén kívül. Általában azonban ismerjük a szkripteket, amelyeket hasonló helyzetekben használunk: még kibírom, most nem lehet, megvárom a következő kontrollt, majd csak lesz valahogy.</p>
<p>Ezek nem a butaság bizonyítékai. Lehet bennük félelem, kötelesség, rossz tapasztalat vagy az igény, hogy az ember megtartsa az irányítást. Az, hogy emberileg érthetők, nem teszi őket biztonságossá.</p>
<p>Nekem is megvannak a szkriptjeim. Minden orvosnak megvannak. Tanult eljárások nélkül nem lehetne gyógyítani.</p>
<p>A különbség nem az között van, aki szabályokat használ, és aki egyet sem.</p>
<p>A különbség az között van, aki tud alkalmazni egy eljárást, és aki felismeri, mikor kell megszakítani.</p>
<h2>Ez nem bizonyíték arra, hogy az agy nyelvi modell</h2>
<p>Nem állítom, hogy az emberi és a mesterséges intelligencia ugyanaz. Ez a történet nem bizonyíték a tudat természetéről, sem az agy működéséről.</p>
<p>A viselkedés szintjén azonban találó hasonlóság.</p>
<p>Jön az inger. Kiválasztódik egy ismert minta. Elindul a válasz. A kontextus csak annyiban számít, amennyiben az adott eljárás egyáltalán megengedi.</p>
<p>A mesterséges intelligenciától ma azt kérjük, hogy értse az összefüggéseket, ismerje fel a bizonytalanságot, becsülje meg az ember érzelmi állapotát, és ne csak azért helyeseljen, hogy tetsszen.</p>
<p>Magunktól legalább ennyit kérhetnénk.</p>
<p>Az udvariasság nem hízelgés. Az empátia nem egyetértés. Bemutatkozni, meghallgatni a kollégát és átvenni a lényeges klinikai információt nem különleges érzelmi intelligencia. A szakmai kommunikáció alapja.</p>
<h2>A legfontosabb skill a többi megállítása</h2>
<p>Attól tartunk, hogy a mesterséges intelligencia egyszer kíméletlenül hajt végre rosszul beállított utasításokat.</p>
<p>Az emberek ezt már ma meg tudják tenni. Szerverek, modellek és egyetlen sor kód nélkül.</p>
<p>Ezért minden emberi és minden mesterséges skill.md-be beírnék egy mondatot:</p>
<p>Ha az eljárást helyesen végzed, de már nem látod az embert, állj meg, és gondold újra a célt.</p>
<p>A betegnek nem arra van szüksége, hogy megnyerje az ellátási körzetről szóló vitát. Arra, hogy valaki megértse, miért romlik az állapota.</p>
<p>Az intelligencia nem csak abban mutatkozik meg, milyen gyorsan találjuk meg a helyes szkriptet.</p>
<p>Abban is, hogy észrevesszük, amikor éppen a helytelen fut.</p>
<p>Ha a saját munkájában ismeri azt a pillanatot, amikor a helyesen futó eljárás már nem látja az embert, írjon nekem a <a href="contact.php">kapcsolat</a> űrlapon.</p>
<p><em>Anonimizált klinikai tapasztalat egy dialízisközpontból, nem egy megnevezett osztály leírása és nem kezelési tanács. A beteg indokait szándékosan nem írom le. A kivizsgálásról és a kezelésről a kezelőorvossal folytatott beszélgetésben kell dönteni.</em></p>
HTML,
        ],
        'it' => [
            'title' => 'Anche l’uomo ha il suo skill.md. Solo che non lo vediamo.',
            'image_alt' => 'Un medico in camice bianco, visto di spalle in un centro dialisi viola, tiene il telefono all’orecchio e un foglio bianco. Sullo sfondo un paziente in sedia a rotelle è rivolto verso una porta illuminata di turchese.',
            'excerpt' => 'Un paziente in dialisi peggiorava e il sistema ha chiesto perché spettasse a un altro. Eseguire uno script alla cieca lo sapevamo fare molto prima dell’intelligenza artificiale. Lo skill che conta è riconoscere quando interromperlo.',
            'content' => <<<'HTML'
<p>Il paziente peggiorava. Dall’unità che lo riceveva chiedevano perché lo avessimo inviato proprio da loro. In quel momento ho capito che per eseguire gli script alla cieca non ci serve l’intelligenza artificiale. Quella capacità l’avevamo acquisita molto prima di lei.</p>
<p>Da circa una settimana peggiorava lo stato di un paziente in dialisi.</p>
<p>Nel centro dialisi satellite abbiamo usato, uno dopo l’altro, tutto ciò che abbiamo a disposizione: esami obiettivi ripetuti, una nuova rilettura dell’anamnesi, modifiche dei parametri del trattamento, compreso il peso di riferimento, chiamato per tradizione peso secco, esami di laboratorio, radiografia del torace ed ecografia dell’addome.</p>
<p>Lì finiscono le nostre possibilità diagnostiche. Non perché non volessimo continuare. Perché un centro dialisi non è un ospedale.</p>
<p>Abbiamo spiegato al paziente che gli serviva proseguire la diagnosi differenziale in ospedale e che, davanti a una dispnea progressiva, a un aumento di peso e a una tolleranza allo sforzo molto ridotta, gli serviva senza indugio.</p>
<p>Ha detto di aver capito. Ha comunque rifiutato il percorso proposto.</p>
<p>Non esporrò le sue ragioni: l’anonimato lo richiede. Sul piano medico non cambiavano la necessità di una valutazione ospedaliera. Dal suo punto di vista pesavano chiaramente più della nostra spiegazione.</p>
<p>Ricordiamo anche questo. Al paziente torneremo.</p>
<h2>Il paziente aveva dispnea. Il sistema aveva una domanda.</h2>
<p>Due giorni dopo è arrivato prima delle sei del mattino per la dialisi abituale. L’aumento di peso era di soli 0,2 chilogrammi.</p>
<p>No, non è un refuso. Duecento grammi in due giorni.</p>
<p>I sintomi, però, erano molto peggiori. Un aumento piccolo non voleva dire un pericolo piccolo. Questa volta è seguito l’invio in ospedale e il trasferimento in sedia a rotelle.</p>
<p>Poco dopo ha squillato il telefono.</p>
<p>Dall’unità di accettazione ha chiamato una donna, che ho preso per una medica. L’ho presa per tale perché non si è presentata.</p>
<p>Ci si poteva aspettare domande sullo stato del paziente. Che cosa era cambiato? Quali erano i risultati? Che cosa avevamo già provato? Perché ritenevamo urgente la situazione?</p>
<p>No.</p>
<p>La domanda era: perché lo avevamo inviato proprio da loro, se secondo il «bacino» spettava a un altro ospedale?</p>
<p>Ho spiegato il mio ragionamento. A portata più vicina ci sono due ospedali, ed entrambi hanno un reparto di dialisi. Ho scelto questo perché mi aspettavo possibilità migliori per diagnosticare il suo stato.</p>
<p>Quando poi ho cominciato a trasmettere le informazioni cliniche, sono riuscito a dire circa due parole.</p>
<p>La chiamata è finita.</p>
<p>Il paziente è rimasto un paziente. La dispnea è rimasta dispnea. Solo le informazioni che potevano aiutare il seguito della valutazione sono rimaste dal lato sbagliato del telefono.</p>
<h2>Un file che nessuno apre</h2>
<p>Dapprima ho pensato che mi fosse passata addosso la frustrazione per la mancanza di letti di quella mattina. Non so se fosse così. Non conosco la situazione del reparto né le circostanze all’altro capo.</p>
<p>Poi mi è venuta una possibilità più scomoda.</p>
<p>E se non fosse stato uno scatto? E se si fosse soltanto eseguita senza errore una procedura ormai abituale?</p>
<p>Tra gli agenti di IA, un file skill.md può contenere le istruzioni di un compito: che cosa controllare, come procedere, che cosa evitare.</p>
<p>Una persona non ha bisogno di quel file su un disco. Lo porta in testa.</p>
<p>Lo scrivono l’esperienza, l’educazione, l’ambiente di lavoro, gli ordini dei superiori, i premi e le punizioni. A volte il contenuto è sensato e utile. Altre volte si può riassumere in modo molto semplice:</p>
<p>Quando arriva un problema, scopri prima perché non dovrebbe essere tuo.</p>
<p>Non so se qualcuno, in quell’unità, abbia mai pronunciato questa consegna. Non occorre. Alcune regole si trasmettono senza formazione e senza firma. Basta vedere, più volte, quale comportamento si tollera, quale si premia e quale porta un fastidio.</p>
<p>Col tempo la persona non ha più bisogno di un ordine. Avvia la procedura da sola.</p>
<h2>La risposta giusta alla domanda sbagliata</h2>
<p>Qui la somiglianza con l’intelligenza artificiale diventa interessante.</p>
<p>Un sistema intelligente può rendere in modo eccellente e risolvere comunque il compito sbagliato. Se l’obiettivo principale è proteggere la capacità di un’unità, può cercare con molta efficacia le ragioni per cui un dato paziente spetta altrove.</p>
<p>La domanda medica, però, era un’altra:</p>
<p>Di che cosa ha bisogno questa persona, e come glielo assicuriamo in tempo?</p>
<p>L’organizzazione dei ricoveri, la capacità e la divisione del lavoro sono problemi reali. Nessuno che lavori in sanità può negarli in buona fede. Il problema comincia quando la domanda organizzativa sposta quella clinica al punto che non resta spazio nemmeno per trasmettere le informazioni.</p>
<p>In quel momento non è detto che fallisca la capacità di ragionare. Può fallire l’ordine delle priorità.</p>
<p>Ed è forse ancora più sgradevole. Un’intelligenza maggiore non garantisce, da sola, un obiettivo migliore. Può soltanto servire con più efficacia quello sbagliato.</p>
<h2>Anche il paziente ha il suo script</h2>
<p>Non sarebbe onesto fare di questa storia un semplice scontro tra un medico ragionevole e un ospedale irragionevole.</p>
<p>Anche il paziente aveva una procedura interiore. Ha detto di capire la necessità di una valutazione in ospedale, e l’ha rifiutata lo stesso.</p>
<p>Che cosa abbia deciso di preciso resta fuori da questo articolo. In generale, però, conosciamo gli script che usiamo in situazioni simili: resisto ancora, adesso non posso, aspetto il prossimo controllo, in qualche modo andrà.</p>
<p>Non sono prove di stupidità. Possono contenere paura, doveri, esperienze cattive o il bisogno di conservare il controllo. Il fatto che siano umanamente comprensibili non li rende sicuri.</p>
<p>Anch’io ho i miei script. Li ha ogni medico. Senza procedure apprese la medicina non si potrebbe esercitare.</p>
<p>La differenza non è tra chi usa regole e chi non ne usa nessuna.</p>
<p>La differenza è tra chi sa applicare una procedura e chi sa riconoscere quando va interrotta.</p>
<h2>Questo non prova che il cervello sia un modello linguistico</h2>
<p>Non sostengo che l’intelligenza umana e quella artificiale siano la stessa cosa. Questa storia non è una prova sulla natura della coscienza, né sul funzionamento del cervello.</p>
<p>È però una somiglianza precisa sul piano del comportamento.</p>
<p>Arriva uno stimolo. Si sceglie uno schema noto. Parte una risposta. Il contesto si tiene in conto solo per quanto la procedura lo ammette.</p>
<p>All’intelligenza artificiale chiediamo oggi di cogliere i nessi, di riconoscere l’incertezza, di stimare lo stato emotivo di una persona e di non dargli ragione solo per piacergli.</p>
<p>A noi stessi potremmo chiedere almeno questo.</p>
<p>La cortesia non è l’adulazione. L’empatia non è l’assenso. E presentarsi, ascoltare un collega e raccogliere le informazioni cliniche essenziali non è un’intelligenza emotiva facoltativa. È la base della comunicazione professionale.</p>
<h2>Lo skill più importante è saper fermare gli altri</h2>
<p>Temiamo che l’intelligenza artificiale esegua un giorno, senza riguardo, istruzioni impostate male.</p>
<p>Le persone sanno già farlo. Senza server, senza modelli, senza una sola riga di codice.</p>
<p>Per questo aggiungerei una frase a ogni skill.md, umano o artificiale:</p>
<p>Se esegui correttamente la procedura, ma smetti di vedere la persona, fermati e riconsidera l’obiettivo.</p>
<p>Il paziente non ha bisogno di vincere una disputa sul bacino di utenza. Ha bisogno che qualcuno capisca perché peggiora.</p>
<p>L’intelligenza non si mostra solo nella rapidità con cui troviamo lo script giusto.</p>
<p>Si mostra anche quando ci accorgiamo che sta girando quello sbagliato.</p>
<p>Se nel suo lavoro conosce l’istante in cui una procedura che gira correttamente smette di vedere la persona, mi scriva tramite il <a href="contact.php">modulo di contatto</a>.</p>
<p><em>È un’esperienza clinica anonimizzata in un centro dialisi, non la descrizione di un’unità nominata e non un consiglio di cura. Le ragioni del paziente sono omesse di proposito. Le decisioni su accertamenti e trattamento spettano al colloquio con il medico curante.</em></p>
HTML,
        ],
        'uk' => [
            'title' => 'У людини теж є свій skill.md. Просто його не видно.',
            'image_alt' => 'Лікар у білому халаті, ззаду, у фіолетовій діалізній залі, тримає біля вуха телефон і чистий аркуш. На задньому плані пацієнт у візку сидить навпроти бірюзового світла дверей.',
            'excerpt' => 'Стан пацієнта на діалізі погіршувався, а система запитала, чому він належить іншим. Сліпо виконувати скрипти ми вміли задовго до штучного інтелекту. Найважливіший skill — помітити, коли процедуру треба зупинити.',
            'content' => <<<'HTML'
<p>Пацієнту ставало гірше. З приймального відділення запитали, чому ми скерували його саме до них. Тієї миті я зрозумів, що для сліпого виконання скриптів штучний інтелект не потрібен. Цю здатність ми засвоїли задовго до нього.</p>
<p>Близько тижня погіршувався стан пацієнта на діалізі.</p>
<p>У сателітному діалізному центрі ми по черзі використали все, що маємо: повторні фізикальні огляди, нове переглядання анамнезу, зміни параметрів діалізного лікування, включно з референтною вагою, яку традиційно називають сухою, лабораторні обстеження, рентген грудної клітки й ультразвукове дослідження живота.</p>
<p>На цьому наші діагностичні можливості закінчуються. Не тому, що ми не хотіли б іти далі. Тому, що діалізний центр — не лікарня.</p>
<p>Ми пояснили пацієнтові, що йому потрібна подальша диференційна діагностика в лікарні і що через прогресивну задишку, зростання маси тіла та різко обмежену переносимість навантаження вона потрібна негайно.</p>
<p>Він сказав, що розуміє. Запропонований шлях усе ж відхилив.</p>
<p>Його причин я не розгортатиму: цього вимагає анонімність. З медичного погляду вони не змінювали потреби в лікарняному обстеженні. З його погляду вони явно важили більше, ніж наше пояснення.</p>
<p>Запам’ятаймо і це. До пацієнта ми ще повернемося.</p>
<h2>У пацієнта була задишка. У системи було питання.</h2>
<p>За два дні він прийшов до шостої ранку на черговий діаліз. Приріст маси становив лише 0,2 кілограма.</p>
<p>Ні, це не друкарська помилка. Двісті грамів за два дні.</p>
<p>Симптоми ж були значно гірші. Малий приріст маси не означав малої небезпеки. Цього разу було скерування до лікарні і перевезення на візку.</p>
<p>Невдовзі задзвонив телефон.</p>
<p>З приймального відділення озвалася жінка, яку я вважав лікаркою. Вважав, бо вона не назвалася.</p>
<p>Можна було чекати питань про стан пацієнта. Що змінилося? Які результати? Що ми вже спробували? Чому ситуацію вважаємо невідкладною?</p>
<p>Ні.</p>
<p>Питання було таке: чому ми скерували його саме до них, якщо за «районом» він належить до іншої лікарні?</p>
<p>Я пояснив свій хід думки. Найближче розташовані дві лікарні, і в обох є діалізне відділення. Цю я обрав, бо очікував там кращих можливостей з’ясувати його стан.</p>
<p>Коли я потім почав передавати клінічні відомості, встиг сказати близько двох слів.</p>
<p>Розмова закінчилася.</p>
<p>Пацієнт лишився пацієнтом. Задишка лишилася задишкою. Лише відомості, які могли допомогти в подальшому обстеженні, залишилися на неправильному боці телефону.</p>
<h2>Файл, якого ніхто не відкриває</h2>
<p>Спершу я подумав, що на мене, можливо, перейшло роздратування через ранкову нестачу ліжок. Не знаю, чи так було. Я не знаю ситуації у відділенні й обставин на тому боці.</p>
<p>Потім спала на думку неприємніша можливість.</p>
<p>А якщо це був не спалах емоцій? А якщо просто бездоганно виконали звичний порядок дій?</p>
<p>У середовищі ШІ-агентів файл skill.md може містити інструкцію до завдання: що перевірити, як діяти, чого уникати.</p>
<p>Людині такий файл на диску не потрібен. Вона носить його в голові.</p>
<p>Його пишуть досвід, виховання, робоче середовище, вказівки керівників, винагороди й покарання. Іноді його зміст розумний і корисний. Іноді його можна звести зовсім просто:</p>
<p>Коли з’являється проблема, спершу з’ясуй, чому вона не має бути твоєю.</p>
<p>Не знаю, чи хтось на тому робочому місці вимовляв таку вказівку. І не мусить. Деякі правила передаються без навчання і без підпису. Досить раз у раз бачити, яку поведінку терплять, яку відзначають і за яку приходить неприємність.</p>
<p>З часом людині вже не потрібен наказ. Вона запускає порядок дій сама.</p>
<h2>Правильна відповідь на неправильне питання</h2>
<p>Тут подібність до штучного інтелекту стає цікавою.</p>
<p>Розумна система може працювати блискуче і все ж розв’язувати неправильне завдання. Якщо головна мета — берегти потужність відділення, вона може дуже ефективно шукати причини, чому конкретний пацієнт належить деінде.</p>
<p>А медичне питання було інше:</p>
<p>Що потрібно цій людині і як ми забезпечимо це вчасно?</p>
<p>Організація госпіталізації, потужність і розподіл роботи — справжні проблеми. Ніхто, хто працює в охороні здоров’я, не може чесно їх заперечувати. Проблема починається тоді, коли організаційне питання витісняє клінічне настільки, що не лишається місця навіть передати відомості.</p>
<p>Тієї миті не обов’язково дає збій здатність мислити. Може давати збій порядок пріоритетів.</p>
<p>І це, мабуть, ще неприємніше. Більший інтелект сам по собі не гарантує кращої мети. Він може лише дієвіше обслуговувати неправильну.</p>
<h2>У пацієнта теж є свій скрипт</h2>
<p>Було б нечесно зробити з цієї історії простий двобій розважливого лікаря з нерозважливою лікарнею.</p>
<p>У пацієнта теж був свій внутрішній порядок. Він сказав, що розуміє потребу лікарняного обстеження, і все одно відхилив його.</p>
<p>Що саме вирішило, лишімо поза цією статтею. Загалом ми знаємо скрипти, якими користуємося в подібних ситуаціях: ще потерплю, зараз не можу, зачекаю до наступного огляду, якось буде.</p>
<p>Це не докази дурості. У них можуть бути страх, обов’язки, поганий досвід чи потреба зберегти контроль. Те, що їх можна по-людськи зрозуміти, не робить їх безпечними.</p>
<p>У мене теж є свої скрипти. Вони є в кожного лікаря. Без вивчених порядків медицину не вдалося б практикувати.</p>
<p>Різниця не між людиною, яка користується правилами, і людиною, яка не користується жодними.</p>
<p>Різниця між людиною, яка вміє застосувати порядок дій, і людиною, яка вміє розпізнати, коли його треба перервати.</p>
<h2>Це не доказ, що мозок є мовною моделлю</h2>
<p>Я не стверджую, що людський інтелект і штучний інтелект — одне й те саме. Ця історія не є доказом про природу свідомості й не є доказом про роботу мозку.</p>
<p>Це влучна подібність на рівні поведінки.</p>
<p>Надходить стимул. Обирається знайомий шаблон. Запускається відповідь. Контекст враховують лише настільки, наскільки цей порядок дій узагалі його допускає.</p>
<p>Від штучного інтелекту ми сьогодні вимагаємо розуміти зв’язки, розпізнавати непевність, оцінювати емоційний стан людини і не підтакувати лише для того, щоб сподобатися.</p>
<p>Від себе ми могли б вимагати бодай того самого.</p>
<p>Ввічливість — не підлесливість. Емпатія — не згода. А назватися, вислухати колегу і прийняти істотні клінічні відомості — не надлишковий емоційний інтелект. Це основа професійного спілкування.</p>
<h2>Найважливіший skill — уміти зупинити решту</h2>
<p>Ми боїмося, що штучний інтелект колись безжально виконуватиме погано задані вказівки.</p>
<p>Люди вміють це вже сьогодні. Без серверів, без моделей, без жодного рядка коду.</p>
<p>Тому до кожного людського і кожного штучного skill.md я додав би одне речення:</p>
<p>Якщо ти правильно виконуєш процедуру, але перестаєш бачити людину, зупинись і переглянь мету.</p>
<p>Пацієнтові не потрібно виграти суперечку про район. Йому потрібно, щоб хтось зрозумів, чому стан погіршується.</p>
<p>Інтелект виявляється не лише тим, як швидко ми знаходимо правильний скрипт.</p>
<p>Він виявляється і тим, що ми помічаємо, коли саме працює неправильний.</p>
<p>Якщо у своїй роботі ви знаєте мить, коли правильно запуснена процедура перестає бачити людину, напишіть мені через <a href="contact.php">контакт</a>.</p>
<p><em>Це анонімізований клінічний досвід із діалізного центру, не опис конкретного відділення і не лікувальна порада. Причини пацієнта навмисно не наводжу. Рішення про обстеження і лікування належить розмові з лікарем, який лікує.</em></p>
HTML,
        ],
    ],
];
