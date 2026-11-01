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
 * Odporúčanie nie je povolenie.
 * Komentár k štvrtému dielu Nedeľnej metafyziky (knižnica, metafyzika-4).
 * Filozofická esej o hranici medzi odborným odporúčaním a súhlasom;
 * nie správa o identifikovateľnom pacientovi. Väzba na medicínsku AI
 * je redakčná syntéza, nie deklarovaná funkcia softvéru.
 */
return [
    'slug' => 'odporucanie-nie-je-povolenie',
    'author' => 'MUDr. Ľubomír Polaščín',
    'category' => 'blog',
    'is_top' => 0,
    'published_at' => '2026-11-01 08:52:00',
    'image' => 'images/articles/odporucanie-nie-je-povolenie.webp',
    'translations' => [
        'sk' => [
            'title' => 'Odporúčanie nie je povolenie',
            'image_alt' => 'Fialová chodba. V strede otvorené dvere s ostrým tyrkysovým svetlom. Pred prahom stojí tmavšia silueta, ktorá ešte neprekročila prah.',
            'excerpt' => 'Liečba môže byť odborne správna, a predsa to lekára neoprávňuje ju vynútiť. Štvrtý diel Nedeľnej metafyziky drží túto hranicu otvorenú. Predchádzajúci súhlas dnešné rozhodnutie nenahradí.',
            'content' => <<<'HTML'
<p>Liečba môže byť medicínsky odôvodnená, a predsa to lekára neoprávňuje ju niekomu vnútiť.</p>
<p>Toto rozlíšenie som držal v strede štvrtého dielu <a href="library.php?slug=metafyzika-4"><em>Nedeľnej metafyziky</em></a>. Otázky, ktoré medicína sama technikou nevyrieši: ako ďaleko smieme pomáhať a kde sa pomoc mení na ovládanie?</p>
<p>V jednej modelovej situácii človek odmietne to, na čo pred dvoma dňami pristúpil. Lákavá skratka je brať včerajšie áno ako skutočné rozhodnutie a dnešné nie ako prekážku. Zmenená odpoveď však žiada posúdenie a rozhovor, nie automatické oprávnenie pokračovať.</p>
<p>Čo človek rozumie? Zmenila sa jeho schopnosť rozhodovať? Je zmätenosť zvratná? Čo sa zmenilo v cieľoch alebo strachoch? Tieto otázky odmietnutie neuľahčia. Bránia tomu, aby sme ho falošne zjednodušili.</p>
<p>Ide o filozofickú prácu, nie o správu o identifikovateľnom pacientovi. Napätie je pritom praktické: vedieť, čo by mohlo pomôcť, nie je totéž ako vedieť, čo niekto musí prijať. Kto stavia medicínsku umelú inteligenciu, mal by toto rozlíšenie vložiť do samotného pracovného toku. Odporúčanie nie je súhlas. Predchádzajúca dohoda nie je náhradou za pochopenie dnešného rozhodnutia.</p>
<p>Právne rozlíšenie predchádzajúceho súhlasu, dnešného odmietnutia a výnimky pri neodkladnej starostlivosti som rozobral osobitne v článku <a href="article.php?slug=ohrozenie-zivota-samo-suhlas-nenahradi">Ohrozenie života samo súhlas nenahradí</a>.</p>
<p><em>Ide o komentár k štvrtému dielu Nedeľnej metafyziky, nie o liečebné rozhodnutie pre konkrétneho pacienta a nie o návod na posúdenie na konkrétnom pracovisku. Modelové situácie neoznačujú konkrétnych ľudí. Väzba na medicínsku umelú inteligenciu je redakčná úvaha, nie popis nasadeného softvéru.</em></p>

HTML,
        ],
        'en' => [
            'title' => 'A recommendation is not permission',
            'image_alt' => 'A purple corridor. In the centre, an open doorway with sharp teal light. A darker silhouette stands before the threshold and has not crossed it.',
            'excerpt' => 'A treatment can be medically sound and still give the doctor no right to impose it. The fourth volume of Sunday Metaphysics keeps that boundary open. Prior consent does not replace today’s decision.',
            'content' => <<<'HTML'
<p>A treatment can be medically justified without giving the doctor permission to impose it.</p>
<p>That distinction sat at the centre of the fourth volume of <a href="library.php?slug=metafyzika-4"><em>Nedeľná metafyzika</em></a> (Sunday Metaphysics). The questions medicine cannot settle by technical competence alone: how far may we help, and where does help become control?</p>
<p>In one model situation a person refuses what they agreed to two days earlier. The tempting shortcut is to treat yesterday’s yes as the real decision and today’s no as an obstacle. A changed answer calls for assessment and conversation, not automatic permission to proceed.</p>
<p>What does the person understand? Has their decision-making capacity changed? Is the confusion reversible? What has shifted in their goals or fears? Those questions do not make refusal simple. They stop us from making it falsely simple.</p>
<p>This is philosophical work, not a report about an identifiable patient. The tension is practical nonetheless: knowing what might help is not the same as knowing what someone must accept. Anyone building medical artificial intelligence should put that distinction into the workflow itself. A recommendation is not consent. A previous agreement is not a substitute for understanding the present decision.</p>
<p>I set out the legal distinction between prior consent, today’s refusal, and the emergency-care exception separately in <a href="article.php?slug=ohrozenie-zivota-samo-suhlas-nenahradi">A threat to life does not replace consent</a>.</p>
<p><em>This is a commentary on the fourth volume of Sunday Metaphysics, not a treatment decision for an individual patient, and not guidance for judgment on a particular ward. The model situations do not identify real people. The link to medical artificial intelligence is an editorial reflection, not a description of deployed software.</em></p>

HTML,
        ],
        'cs' => [
            'title' => 'Doporučení není povolení',
            'image_alt' => 'Fialová chodba. Uprostřed otevřené dveře s ostrým tyrkysovým světlem. Před prahem stojí tmavší silueta, která práh ještě nepřekročila.',
            'excerpt' => 'Léčba může být odborně správná, a přesto to lékaře neoprávňuje ji vynutit. Čtvrtý díl Nedělní metafyziky drží tuto hranici otevřenou. Předchozí souhlas dnešní rozhodnutí nenahradí.',
            'content' => <<<'HTML'
<p>Léčba může být medicínsky odůvodněná, a přesto to lékaře neoprávňuje ji někomu vnutit.</p>
<p>Toto rozlišení jsem držel ve středu čtvrtého dílu <a href="library.php?slug=metafyzika-4"><em>Nedeľnej metafyziky</em></a> (Nedělní metafyzika). Otázky, které medicína sama technikou nevyřeší: jak daleko smíme pomáhat a kde se pomoc mění v ovládání?</p>
<p>V jedné modelové situaci člověk odmítne to, na co před dvěma dny přistoupil. Lákavá zkratka je brát včerejší ano jako skutečné rozhodnutí a dnešní ne jako překážku. Změněná odpověď však žádá posouzení a rozhovor, ne automatické oprávnění pokračovat.</p>
<p>Co člověk rozumí? Změnila se jeho schopnost rozhodovat? Je zmatenost zvratná? Co se změnilo v cílech nebo strachách? Tyto otázky odmítnutí neusnadní. Brání tomu, abychom je falešně zjednodušili.</p>
<p>Jde o filosofickou práci, ne o zprávu o identifikovatelném pacientovi. Napětí je přitom praktické: vědět, co by mohlo pomoci, není totéž jako vědět, co někdo musí přijmout. Kdo staví medicínskou umělou inteligenci, měl by toto rozlišení vložit do samotného pracovního toku. Doporučení není souhlas. Předchozí dohoda není náhradou za pochopení dnešního rozhodnutí.</p>
<p>Právní rozlišení předchozího souhlasu, dnešního odmítnutí a výjimky při neodkladné péči jsem rozebral zvlášť v článku <a href="article.php?slug=ohrozenie-zivota-samo-suhlas-nenahradi">Ohrožení života samo souhlas nenahradí</a>.</p>
<p><em>Jde o komentář ke čtvrtému dílu Nedělní metafyziky, ne o léčebné rozhodnutí pro konkrétního pacienta a ne o návod k posouzení na konkrétním pracovišti. Modelové situace neoznačují konkrétní lidi. Vazba na medicínskou umělou inteligenci je redakční úvaha, ne popis nasazeného softwaru.</em></p>

HTML,
        ],
        'de' => [
            'title' => 'Eine Empfehlung ist keine Erlaubnis',
            'image_alt' => 'Violetter Gang. In der Mitte eine offene Tür mit scharfem Türkislicht. Vor der Schwelle steht eine dunklere Silhouette, die sie noch nicht überschritten hat.',
            'excerpt' => 'Eine Behandlung kann fachlich richtig sein und dem Arzt dennoch kein Recht geben, sie zu erzwingen. Der vierte Band der Sonntagsmetaphysik hält diese Grenze offen. Frühere Einwilligung ersetzt die heutige Entscheidung nicht.',
            'content' => <<<'HTML'
<p>Eine Behandlung kann medizinisch begründet sein und dem Arzt dennoch keine Erlaubnis geben, sie jemandem aufzuzwingen.</p>
<p>Diese Unterscheidung stand im Zentrum des vierten Bandes der <a href="library.php?slug=metafyzika-4"><em>Nedeľná metafyzika</em></a> (Sonntagsmetaphysik). Die Fragen, die die Medizin mit Technik allein nicht löst: wie weit dürfen wir helfen, und wo wird Hilfe zur Kontrolle?</p>
<p>In einer Modellsituation lehnt ein Mensch ab, dem er zwei Tage zuvor zugestimmt hat. Der verlockende Kurzschluss ist, das gestrige Ja als die echte Entscheidung und das heutige Nein als Hindernis zu nehmen. Eine geänderte Antwort verlangt Beurteilung und Gespräch, keine automatische Erlaubnis weiterzugehen.</p>
<p>Was versteht der Mensch? Hat sich seine Entscheidungsfähigkeit geändert? Ist die Verwirrung umkehrbar? Was hat sich an Zielen oder Ängsten verschoben? Diese Fragen machen die Ablehnung nicht einfach. Sie hindern uns daran, sie falsch zu vereinfachen.</p>
<p>Es ist philosophische Arbeit, kein Bericht über einen identifizierbaren Patienten. Die Spannung ist gleichwohl praktisch: zu wissen, was helfen könnte, ist nicht dasselbe wie zu wissen, was jemand annehmen muss. Wer medizinische künstliche Intelligenz baut, sollte diese Unterscheidung in den Arbeitsablauf selbst legen. Eine Empfehlung ist keine Einwilligung. Eine frühere Vereinbarung ersetzt nicht das Verstehen der heutigen Entscheidung.</p>
<p>Die rechtliche Unterscheidung zwischen früherer Einwilligung, heutiger Ablehnung und der Ausnahme bei unaufschiebbarer Versorgung habe ich gesondert in <a href="article.php?slug=ohrozenie-zivota-samo-suhlas-nenahradi">Lebensgefahr ersetzt die Einwilligung nicht</a> dargelegt.</p>
<p><em>Dies ist ein Kommentar zum vierten Band der Sonntagsmetaphysik, keine Behandlungsentscheidung für einen einzelnen Patienten und keine Anleitung zur Beurteilung auf einer bestimmten Station. Die Modellsituationen bezeichnen keine konkreten Menschen. Der Bezug zur medizinischen künstlichen Intelligenz ist eine redaktionelle Überlegung, keine Beschreibung eingesetzter Software.</em></p>

HTML,
        ],
        'fr' => [
            'title' => 'Une recommandation n’est pas une permission',
            'image_alt' => 'Couloir violet. Au centre, une porte ouverte à la lumière turquoise vive. Une silhouette plus sombre se tient devant le seuil sans l’avoir franchi.',
            'excerpt' => 'Un traitement peut être médicalement fondé sans donner au médecin le droit de l’imposer. Le quatrième volume de la métaphysique du dimanche tient cette limite ouverte. Un consentement antérieur ne remplace pas la décision d’aujourd’hui.',
            'content' => <<<'HTML'
<p>Un traitement peut être médicalement justifié sans donner au médecin la permission de l’imposer.</p>
<p>Cette distinction était au centre du quatrième volume de <a href="library.php?slug=metafyzika-4"><em>Nedeľná metafyzika</em></a> (métaphysique du dimanche). Les questions que la médecine ne tranche pas par la seule compétence technique : jusqu’où pouvons-nous aider, et où l’aide devient-elle du contrôle ?</p>
<p>Dans une situation modèle, une personne refuse ce à quoi elle avait consenti deux jours plus tôt. Le raccourci tentant est de traiter le oui d’hier comme la vraie décision et le non d’aujourd’hui comme un obstacle. Une réponse changée appelle une évaluation et une conversation, non une permission automatique de poursuivre.</p>
<p>Que comprend la personne ? Sa capacité de décider a-t-elle changé ? La confusion est-elle réversible ? Qu’est-ce qui a bougé dans ses buts ou ses peurs ? Ces questions ne rendent pas le refus simple. Elles empêchent de le simplifier à tort.</p>
<p>C’est un travail philosophique, non un compte rendu sur un patient identifiable. La tension n’en est pas moins pratique : savoir ce qui pourrait aider n’est pas savoir ce que quelqu’un doit accepter. Quiconque construit une intelligence artificielle médicale devrait placer cette distinction dans le flux de travail lui-même. Une recommandation n’est pas un consentement. Un accord antérieur ne remplace pas la compréhension de la décision présente.</p>
<p>J’ai exposé séparément la distinction juridique entre consentement antérieur, refus d’aujourd’hui et exception de soins urgents dans <a href="article.php?slug=ohrozenie-zivota-samo-suhlas-nenahradi">La menace pour la vie ne remplace pas le consentement</a>.</p>
<p><em>Il s’agit d’un commentaire sur le quatrième volume de la métaphysique du dimanche, non d’une décision thérapeutique pour un patient précis, ni d’un guide d’évaluation dans un service donné. Les situations modèles n’identifient personne. Le lien avec l’intelligence artificielle médicale est une réflexion éditoriale, non la description d’un logiciel déployé.</em></p>

HTML,
        ],
        'es' => [
            'title' => 'Una recomendación no es un permiso',
            'image_alt' => 'Pasillo violeta. En el centro, una puerta abierta con luz turquesa intensa. Una silueta más oscura está ante el umbral sin haberlo cruzado.',
            'excerpt' => 'Un tratamiento puede estar médicamente justificado sin dar al médico permiso para imponerlo. El cuarto volumen de la metafísica del domingo mantiene abierto ese límite. El consentimiento previo no sustituye la decisión de hoy.',
            'content' => <<<'HTML'
<p>Un tratamiento puede estar médicamente justificado sin dar al médico permiso para imponerlo.</p>
<p>Esa distinción estuvo en el centro del cuarto volumen de <a href="library.php?slug=metafyzika-4"><em>Nedeľná metafyzika</em></a> (metafísica del domingo). Las preguntas que la medicina no resuelve solo con competencia técnica: ¿hasta dónde podemos ayudar, y dónde la ayuda se vuelve control?</p>
<p>En una situación modelo, una persona rechaza lo que aceptó dos días antes. El atajo tentador es tratar el sí de ayer como la decisión real y el no de hoy como un obstáculo. Una respuesta cambiada pide evaluación y conversación, no permiso automático para seguir.</p>
<p>¿Qué entiende la persona? ¿Ha cambiado su capacidad de decidir? ¿Es reversible la confusión? ¿Qué ha cambiado en sus metas o miedos? Esas preguntas no hacen sencillo el rechazo. Impiden simplificarlo en falso.</p>
<p>Es trabajo filosófico, no un informe sobre un paciente identificable. La tensión, aun así, es práctica: saber qué podría ayudar no es lo mismo que saber qué alguien debe aceptar. Quien construya inteligencia artificial médica debería poner esa distinción en el propio flujo de trabajo. Una recomendación no es un consentimiento. Un acuerdo previo no sustituye la comprensión de la decisión presente.</p>
<p>Expuse por separado la distinción jurídica entre consentimiento previo, rechazo de hoy y excepción de atención urgente en <a href="article.php?slug=ohrozenie-zivota-samo-suhlas-nenahradi">La amenaza a la vida no sustituye el consentimiento</a>.</p>
<p><em>Es un comentario al cuarto volumen de la metafísica del domingo, no una decisión terapéutica para un paciente concreto ni una guía de valoración en una planta concreta. Las situaciones modelo no identifican a personas reales. El vínculo con la inteligencia artificial médica es una reflexión editorial, no la descripción de un software desplegado.</em></p>

HTML,
        ],
        'pl' => [
            'title' => 'Zalecenie nie jest pozwoleniem',
            'image_alt' => 'Fioletowy korytarz. Na środku otwarte drzwi z ostrym turkusowym światłem. Przed progiem stoi ciemniejsza sylwetka, która jeszcze go nie przekroczyła.',
            'excerpt' => 'Leczenie może być medycznie uzasadnione, a mimo to nie daje lekarzowi prawa, by je narzucić. Czwarty tom niedzielnej metafizyki trzyma tę granicę otwartą. Wcześniejsza zgoda nie zastępuje dzisiejszej decyzji.',
            'content' => <<<'HTML'
<p>Leczenie może być medycznie uzasadnione, a mimo to nie daje lekarzowi pozwolenia, by je komuś narzucić.</p>
<p>To rozróżnienie trzymałem w centrum czwartego tomu <a href="library.php?slug=metafyzika-4"><em>Nedeľnej metafyziky</em></a> (niedzielna metafizyka). Pytania, których medycyna sama techniką nie rozstrzygnie: jak daleko wolno pomagać i gdzie pomoc staje się kontrolą?</p>
<p>W jednej sytuacji modelowej człowiek odmawia tego, na co dwa dni wcześniej przystał. Kuszące skrócenie to brać wczorajsze tak jako prawdziwą decyzję, a dzisiejsze nie jako przeszkodę. Zmieniona odpowiedź wymaga oceny i rozmowy, nie automatycznego prawa do kontynuacji.</p>
<p>Co człowiek rozumie? Czy zmieniła się jego zdolność do decydowania? Czy splątanie jest odwracalne? Co się zmieniło w celach lub lękach? Te pytania nie ułatwiają odmowy. Chronią przed fałszywym uproszczeniem.</p>
<p>To praca filozoficzna, nie sprawozdanie o możliwym do zidentyfikowania pacjencie. Napięcie jest przy tym praktyczne: wiedzieć, co mogłoby pomóc, to nie to samo, co wiedzieć, co ktoś musi przyjąć. Kto buduje medyczną sztuczną inteligencję, powinien włożyć to rozróżnienie w sam tok pracy. Zalecenie nie jest zgodą. Wcześniejsze porozumienie nie zastępuje zrozumienia dzisiejszej decyzji.</p>
<p>Prawne rozróżnienie wcześniejszej zgody, dzisiejszej odmowy i wyjątku przy niecierpiącej zwłoki opiece omówiłem osobno w artykule <a href="article.php?slug=ohrozenie-zivota-samo-suhlas-nenahradi">Zagrożenie życia samo zgody nie zastąpi</a>.</p>
<p><em>To komentarz do czwartego tomu niedzielnej metafizyki, nie decyzja lecznicza dla konkretnego pacjenta i nie wskazówka do oceny na konkretnym oddziale. Sytuacje modelowe nie oznaczają konkretnych ludzi. Więź z medyczną sztuczną inteligencją to refleksja redakcyjna, nie opis wdrożonego oprogramowania.</em></p>

HTML,
        ],
        'hu' => [
            'title' => 'Az ajánlás nem engedély',
            'image_alt' => 'Lila folyosó. Középen nyitott ajtó éles türkiz fénnyel. A küszöb előtt sötétebb sziluett áll, és még nem lépte át.',
            'excerpt' => 'A kezelés lehet orvosilag indokolt, és mégis nem ad jogot az orvosnak, hogy kikényszerítse. A vasárnapi metafizika negyedik kötete nyitva tartja ezt a határt. A korábbi beleegyezés nem helyettesíti a mai döntést.',
            'content' => <<<'HTML'
<p>A kezelés lehet orvosilag indokolt anélkül, hogy az orvosnak engedélyt adna arra, hogy kikényszerítse.</p>
<p>Ezt a megkülönböztetést tartottam a <a href="library.php?slug=metafyzika-4"><em>Nedeľná metafyzika</em></a> (vasárnapi metafizika) negyedik kötetének középpontjában. A kérdések, amelyeket az orvostudomány önmagában technikával nem old meg: meddig segíthetünk, és hol válik a segítség uralommá?</p>
<p>Egy modellhelyzetben az ember elutasítja azt, amibe két nappal korábban beleegyezett. A csábító rövidítés tegnap igenjét tekinteni valódi döntésnek, a mai nemet pedig akadálynak. A megváltozott válasz értékelést és beszélgetést kíván, nem automatikus engedélyt a folytatásra.</p>
<p>Mit ért az ember? Megváltozott a döntési képessége? Visszafordítható a zavarodottság? Mi változott a célokban vagy a félelmekben? Ezek a kérdések nem teszik egyszerűvé az elutasítást. Megakadályozzák, hogy hamisan egyszerűsítsük.</p>
<p>Ez filozófiai munka, nem jelentés azonosítható betegről. A feszültség mégis gyakorlati: tudni, mi segíthetne, nem ugyanaz, mint tudni, mit kell valakinek elfogadnia. Aki orvosi mesterséges intelligenciát épít, ezt a megkülönböztetést magába a munkafolyamatba tegye. Az ajánlás nem beleegyezés. A korábbi megállapodás nem helyettesíti a mai döntés megértését.</p>
<p>A korábbi beleegyezés, a mai elutasítás és a sürgős ellátás kivételének jogi megkülönböztetését külön tárgyaltam a <a href="article.php?slug=ohrozenie-zivota-samo-suhlas-nenahradi">Az életveszély önmagában nem helyettesíti a beleegyezést</a> című cikkben.</p>
<p><em>Ez a vasárnapi metafizika negyedik kötetének kommentárja, nem kezelési döntés konkrét beteg számára, és nem útmutató egy adott osztályon való megítéléshez. A modellhelyzetek nem jelölnek konkrét embereket. Az orvosi mesterséges intelligenciára való utalás szerkesztői megfontolás, nem telepített szoftver leírása.</em></p>

HTML,
        ],
        'it' => [
            'title' => 'Una raccomandazione non è un permesso',
            'image_alt' => 'Corridoio viola. Al centro, una porta aperta con luce turchese nitida. Una silhouette più scura sta davanti alla soglia senza averla oltrepassata.',
            'excerpt' => 'Un trattamento può essere giustificato sul piano medico senza dare al medico il permesso di imporlo. Il quarto volume della metafisica della domenica tiene aperto quel confine. Il consenso precedente non sostituisce la decisione di oggi.',
            'content' => <<<'HTML'
<p>Un trattamento può essere giustificato sul piano medico senza dare al medico il permesso di imporlo.</p>
<p>Questa distinzione stava al centro del quarto volume di <a href="library.php?slug=metafyzika-4"><em>Nedeľná metafyzika</em></a> (metafisica della domenica). Le domande che la medicina non risolve con la sola competenza tecnica: fino a dove possiamo aiutare, e dove l’aiuto diventa controllo?</p>
<p>In una situazione modello una persona rifiuta ciò a cui aveva acconsentito due giorni prima. La scorciatoia allettante è trattare il sì di ieri come la decisione vera e il no di oggi come un ostacolo. Una risposta cambiata chiede valutazione e conversazione, non un permesso automatico di proseguire.</p>
<p>Che cosa comprende la persona? È cambiata la sua capacità di decidere? La confusione è reversibile? Che cosa è mutato nei suoi obiettivi o nelle paure? Queste domande non rendono semplice il rifiuto. Impediscono di semplificarlo falsamente.</p>
<p>È lavoro filosofico, non un resoconto su un paziente identificabile. La tensione resta pratica: sapere che cosa potrebbe aiutare non è lo stesso che sapere che cosa qualcuno deve accettare. Chi costruisce intelligenza artificiale medica dovrebbe mettere questa distinzione nel flusso di lavoro stesso. Una raccomandazione non è un consenso. Un accordo precedente non sostituisce la comprensione della decisione presente.</p>
<p>Ho esposto separatamente la distinzione giuridica tra consenso precedente, rifiuto di oggi ed eccezione delle cure urgenti in <a href="article.php?slug=ohrozenie-zivota-samo-suhlas-nenahradi">La minaccia alla vita non sostituisce il consenso</a>.</p>
<p><em>È un commento al quarto volume della metafisica della domenica, non una decisione terapeutica per un paziente concreto e non una guida di valutazione in un reparto specifico. Le situazioni modello non identificano persone reali. Il legame con l’intelligenza artificiale medica è una riflessione editoriale, non la descrizione di un software in uso.</em></p>

HTML,
        ],
        'uk' => [
            'title' => 'Рекомендація: це не дозвіл',
            'image_alt' => 'Фіолетовий коридор. Посередині відчинені двері з різким бірюзовим світлом. Перед порогом стоїть темніша силуета, яка ще його не переступила.',
            'excerpt' => 'Лікування може бути медично обґрунтованим і все ж не давати лікарю права його нав’язати. Четвертий том недільної метафізики тримає цю межу відкритою. Попередня згода не замінює сьогоднішнього рішення.',
            'content' => <<<'HTML'
<p>Лікування може бути медично обґрунтованим і все ж не давати лікарю дозволу його нав’язати.</p>
<p>Цю відмінність я тримав у центрі четвертого тому <a href="library.php?slug=metafyzika-4"><em>Nedeľná metafyzika</em></a> (недільна метафізика). Питання, які медицина сама технікою не розв’яже: як далеко ми можемо допомагати і де допомога стає контролем?</p>
<p>В одній модельній ситуації людина відмовляється від того, на що погодилася два дні тому. Спокусливе скорочення: брати вчорашнє так за справжнє рішення, а сьогоднішнє ні за перешкоду. Змінена відповідь вимагає оцінки й розмови, а не автоматичного дозволу продовжувати.</p>
<p>Що людина розуміє? Чи змінилася її здатність вирішувати? Чи зворотна сплутаність? Що змінилось у цілях або страхах? Ці питання не роблять відмову простою. Вони не дають зробити її фальшиво простою.</p>
<p>Це філософська робота, не звіт про ідентифікованого пацієнта. Напруга при цьому практична: знати, що могло б допомогти, не те саме, що знати, що хтось мусить прийняти. Хто будує медичний штучний інтелект, має вкласти цю відмінність у сам робочий потік. Рекомендація: це не згода. Попередня домовленість не замінює розуміння сьогоднішнього рішення.</p>
<p>Правову відмінність між попередньою згодою, сьогоднішньою відмовою та винятком при невідкладній допомозі я розібрав окремо в статті <a href="article.php?slug=ohrozenie-zivota-samo-suhlas-nenahradi">Загроза життю сама по собі згоди не замінює</a>.</p>
<p><em>Це коментар до четвертого тому недільної метафізики, не лікувальне рішення для конкретного пацієнта і не настанова до оцінки на конкретному відділенні. Модельні ситуації не позначають конкретних людей. Зв’язок із медичним штучним інтелектом: редакційне міркування, не опис розгорнутого програмного забезпечення.</em></p>

HTML,
        ],
    ],
];
