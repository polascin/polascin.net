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
 * Osobná reflexia z mesačného súhrnu Claude Reflect (september 2026).
 * Čísla konverzácií, podiely tém a opisy návykov sú z dodaného súhrnu.
 * Portál slov-lex.sk overený ako oficiálny právny portál SR (Tavily, 2026-10-29).
 * Stav rukopisu Ztracené kroniky súhrn neurčuje; článok ho neprehlasuje za vydaný.
 */
return [
    'slug' => 'mesiac-v-ktorom-sa-overovalo-vsetko',
    'author' => 'MUDr. Ľubomír Polaščín',
    'category' => 'blog',
    'is_top' => 0,
    'published_at' => '2026-10-29 19:35:00',
    'image' => 'images/articles/mesiac-v-ktorom-sa-overovalo-vsetko.webp',
    'translations' => [
        'sk' => [
            'title' => 'Mesiac, v ktorom sa overovalo všetko',
            'image_alt' => 'Na stole pri lampičke ležia otvorené rukopisy a listy. Cez sklenenú lupu padá svetlo na text, medzi papiermi sú tyrkysové záložky a v pozadí fialový tieň.',
            'excerpt' => 'Šesť konverzácií, štyri aktívne dni. Analýza audioknihy, legislatívny rešerš a nastavenie práce s Claudom. Väčšina relácií trvala hodiny. Claude ako výskumník a editor, ktorému zadám materiál a čakám zoznam toho, čo nesedí.',
            'content' => <<<'HTML'
<p>Šesť konverzácií, štyri aktívne dni. Takmer každá sa točila okolo toho istého: vziať cudzí text alebo vlastný systém a preveriť, či drží. Analýza audioknihy, overovanie zdrojov kapitolu po kapitole, legislatívny rešerš, audit vlastných inštrukcií. S Claudom som pracoval ako s výskumníkom a editorom, ktorému zadám materiál a čakám späť zoznam toho, čo nesedí. Väčšina relácií trvala hodiny, nie minúty.</p>
<p>Claude Reflect to zhrnul ako mesiac overovania. Najaktívnejší deň bol utorok, vrchol o jedenástej večer slovenského času. Nie preto, že by som hľadal spoločnosť. Preto, že po práci ostáva ticho na sústredenú kontrolu.</p>
<p>Polovica práce išla do analýzy a redakcie audioknihy: faktická analýza, preklad, overovanie zdrojov a redakcia knihy Ztracené kroniky. Sedemnásť percent zobral legislatívny rešerš o prevode zdravotnej dokumentácie pri zmene zamestnávateľa podľa slovenskej legislatívy. Zvyšok, tretina, išiel do nastavenia práce samotnej: osobné inštrukcie, preferencie v Coworku, príkazy a to, čo súhrn nazval recursive self-improvement, teda opätovné zlepšovanie vlastných pravidiel.</p>
<p>Reflect pritom pomenoval štyri návyky, ktoré som si ani nevšímal ako zručnosti.</p>
<p>Delegovanie: redakčnú prácu zadávam celú, ale rozhodnutie o štruktúre si nechávam. Pri audioknihe som nechal Claude preložiť, opraviť fakty a doplniť zdroje kapitolu po kapitole. Otázku, či má text ostať scenárom alebo knihou, som ponechal otvorenú na vlastné rozhodnutie.</p>
<p>Kontext: zadám ho raz a potom odkazujem na to, čo už bolo povedané. V prvej správe o audioknihe som dal celý súbor a povedal urob analýzu. Každá ďalšia správa stavala na predchádzajúcej bez opakovania, vrátane príkazu pokračovať, kde stačilo jedno slovo.</p>
<p>Rozlišovanie: keď sa zdroj nedá overiť, chcem to vedieť. Pri audioknihe som žiadal platné webové odkazy a hĺbkové overenie. Pri legislatívnom rešerši som trval na konsolidovanom znení z <a href="https://www.slov-lex.sk">slov-lex.sk</a>, nie na sekundárnych súhrnoch.</p>
<p>Starostlivosť o údaje: osobné údaje v inštrukciách majú vlastné pravidlo. Claude nemá uchovávať mená, rodné čísla ani kontaktné údaje, s výnimkou fiktívnych postáv. V preferenciách Coworku som to rozšíril o citovaných autorov a verejných činiteľov.</p>
<p>Mesačný súhrn od nástroja, s ktorým pracujem, nie je diagnostika. Je to zrkadlo. Keď v ňom vidím, že som štyri dni strávil overovaním, nečítam to ako chválu produktu. Čítam to ako pripomienku, že dôvera bez kontroly ma stojí hodiny. A že hodiny kontroly sú práve tou prácou, ktorú nechcem automatizovať preč.</p>
<p><em>Osobná reflexia z mesačného súhrnu Claude Reflect. Nie je to návod na prácu s konkrétnym modelom ani hodnotenie jeho kvality.</em></p>

HTML,
        ],
        'en' => [
            'title' => 'The month when everything was checked',
            'image_alt' => 'Open manuscripts and pages lie on a desk by a lamp. Light falls through a glass magnifier onto the text; teal bookmarks sit among the papers, with a violet shadow behind.',
            'excerpt' => 'Six conversations, four active days. Audiobook analysis, legislative research and setting up work with Claude. Most sessions lasted hours. Claude as researcher and editor: I hand over material and wait for a list of what does not hold.',
            'content' => <<<'HTML'
<p>Six conversations, four active days. Almost every one turned on the same point: take someone else’s text or my own system and test whether it holds. Audiobook analysis, source checks chapter by chapter, legislative research, an audit of my own instructions. I worked with Claude as with a researcher and editor: I hand over the material and wait for a list of what does not fit. Most sessions lasted hours, not minutes.</p>
<p>Claude Reflect summed it up as a month of verification. The busiest day was Tuesday, with a peak at eleven in the evening, Slovakia time. Not because I was looking for company. Because after work there is quiet left for concentrated checking.</p>
<p>Half the work went into analysing and editing an audiobook: factual analysis, translation, source verification and editing of the book Ztracené kroniky. Seventeen percent went to a legislative search on transferring health records when changing employer under Slovak law. The rest, a third, went into setting up the work itself: personal instructions, Cowork preferences, commands and what the summary called recursive self-improvement, the repeated improvement of my own rules.</p>
<p>Reflect also named four habits I had not even noticed as skills.</p>
<p>Delegation: I hand over the whole editorial job, but I keep the decision about structure. For the audiobook I let Claude translate, correct facts and add sources chapter by chapter. Whether the text should remain a script or become a book I left open for my own decision.</p>
<p>Context: I give it once and then point back to what was already said. In the first message about the audiobook I supplied the whole file and said do the analysis. Every later message built on the previous one without repetition, including a continue command where a single word was enough.</p>
<p>Discernment: when a source cannot be verified, I want to know. For the audiobook I asked for valid web links and deep verification. For the legislative search I insisted on the consolidated text from <a href="https://www.slov-lex.sk">slov-lex.sk</a>, not on secondary summaries.</p>
<p>Care with data: personal data in the instructions have their own rule. Claude is not to retain names, birth numbers or contact details, except for fictional characters. In the Cowork preferences I extended that with an exception for cited authors and public officials.</p>
<p>A monthly summary from the tool I work with is not a diagnosis. It is a mirror. When I see in it that I spent four days verifying, I do not read it as praise of the product. I read it as a reminder that trust without checking costs me hours. And that the hours of checking are exactly the work I do not want to automate away.</p>
<p><em>A personal reflection from a Claude Reflect monthly summary. It is not a guide to working with a particular model, nor an assessment of its quality.</em></p>

HTML,
        ],
        'cs' => [
            'title' => 'Měsíc, ve kterém se ověřovalo všechno',
            'image_alt' => 'Na stole u lampičky leží otevřené rukopisy a listy. Přes skleněnou lupu dopadá světlo na text, mezi papíry jsou tyrkysové záložky a v pozadí fialový stín.',
            'excerpt' => 'Šest konverzací, čtyři aktivní dny. Analýza audioknihy, legislativní rešerše a nastavení práce s Claudem. Většina relací trvala hodiny. Claude jako výzkumník a editor, kterému zadám materiál a čekám seznam toho, co nesedí.',
            'content' => <<<'HTML'
<p>Šest konverzací, čtyři aktivní dny. Téměř každá se točila kolem téhož: vzít cizí text nebo vlastní systém a ověřit, zda drží. Analýza audioknihy, ověřování zdrojů kapitolu po kapitole, legislativní rešerše, audit vlastních instrukcí. S Claudem jsem pracoval jako s výzkumníkem a editorem, kterému zadám materiál a čekám zpět seznam toho, co nesedí. Většina relací trvala hodiny, ne minuty.</p>
<p>Claude Reflect to shrnul jako měsíc ověřování. Nejaktivnější den byl úterý, vrchol o jedenácté večer slovenského času. Ne proto, že bych hledal společnost. Proto, že po práci zbývá ticho na soustředěnou kontrolu.</p>
<p>Polovina práce šla do analýzy a redakce audioknihy: faktická analýza, překlad, ověřování zdrojů a redakce knihy Ztracené kroniky. Sedmnáct procent vzala legislativní rešerše o převodu zdravotní dokumentace při změně zaměstnavatele podle slovenské legislativy. Zbytek, třetina, šel do nastavení práce samotné: osobní instrukce, preference v Coworku, příkazy a to, co souhrn nazval recursive self-improvement, tedy opětovné zlepšování vlastních pravidel.</p>
<p>Reflect přitom pojmenoval čtyři návyky, které jsem si ani nevšímal jako dovedností.</p>
<p>Delegování: redakční práci zadávám celou, ale rozhodnutí o struktuře si nechávám. U audioknihy jsem nechal Claude přeložit, opravit fakta a doplnit zdroje kapitolu po kapitole. Otázku, zda má text zůstat scénářem, nebo knihou, jsem ponechal otevřenou na vlastní rozhodnutí.</p>
<p>Kontext: zadám ho jednou a pak odkazuji na to, co už bylo řečeno. V první zprávě o audioknize jsem dal celý soubor a řekl udělej analýzu. Každá další zpráva stavěla na předchozí bez opakování, včetně příkazu pokračovat, kde stačilo jedno slovo.</p>
<p>Rozlišování: když se zdroj nedá ověřit, chci to vědět. U audioknihy jsem žádal platné webové odkazy a hloubkové ověření. U legislativní rešerše jsem trval na konsolidovaném znění z <a href="https://www.slov-lex.sk">slov-lex.sk</a>, ne na sekundárních souhrnech.</p>
<p>Péče o údaje: osobní údaje v instrukcích mají vlastní pravidlo. Claude nemá uchovávat jména, rodná čísla ani kontaktní údaje, s výjimkou fiktivních postav. V preferencích Coworku jsem to rozšířil o citované autory a veřejné činitele.</p>
<p>Měsíční souhrn od nástroje, se kterým pracuji, není diagnostika. Je to zrcadlo. Když v něm vidím, že jsem čtyři dny strávil ověřováním, nečtu to jako chválu produktu. Čtu to jako připomínku, že důvěra bez kontroly mě stojí hodiny. A že hodiny kontroly jsou právě tou prací, kterou nechci automatizovat pryč.</p>
<p><em>Osobní reflexe z měsíčního souhrnu Claude Reflect. Není to návod na práci s konkrétním modelem ani hodnocení jeho kvality.</em></p>

HTML,
        ],
        'de' => [
            'title' => 'Der Monat, in dem alles geprüft wurde',
            'image_alt' => 'Auf dem Schreibtisch neben der Lampe liegen offene Manuskripte und Blätter. Durch eine Glaslupe fällt Licht auf den Text, zwischen den Papieren liegen türkise Lesezeichen, dahinter ein violetter Schatten.',
            'excerpt' => 'Sechs Gespräche, vier aktive Tage. Analyse eines Hörbuchs, legislativer Recherche und Einrichtung der Arbeit mit Claude. Die meisten Sitzungen dauerten Stunden. Claude als Forscher und Redakteur: ich gebe Material und warte auf die Liste dessen, was nicht hält.',
            'content' => <<<'HTML'
<p>Sechs Gespräche, vier aktive Tage. Fast jedes drehte sich um dasselbe: einen fremden Text oder das eigene System nehmen und prüfen, ob es hält. Analyse eines Hörbuchs, Quellenprüfung Kapitel für Kapitel, legislative Recherche, Prüfung der eigenen Anweisungen. Mit Claude arbeitete ich wie mit einem Forscher und Redakteur, dem ich Material gebe und auf die Liste dessen warte, was nicht stimmt. Die meisten Sitzungen dauerten Stunden, nicht Minuten.</p>
<p>Claude Reflect fasste es als Monat der Prüfung zusammen. Der aktivste Tag war Dienstag, der Höhepunkt um elf Uhr abends slowakischer Zeit. Nicht, weil ich Gesellschaft suchte. Weil nach der Arbeit Stille für konzentrierte Kontrolle bleibt.</p>
<p>Die Hälfte der Arbeit ging in Analyse und Redaktion eines Hörbuchs: faktische Analyse, Übersetzung, Quellenprüfung und Redaktion des Buches Ztracené kroniky. Siebzehn Prozent nahm eine legislative Recherche zur Übertragung der Gesundheitsdokumentation bei Arbeitgeberwechsel nach slowakischem Recht. Der Rest, ein Drittel, ging in die Einrichtung der Arbeit selbst: persönliche Anweisungen, Cowork-Präferenzen, Befehle und das, was die Zusammenfassung recursive self-improvement nannte, also die wiederholte Verbesserung der eigenen Regeln.</p>
<p>Reflect benannte dabei vier Gewohnheiten, die ich gar nicht als Fähigkeiten wahrgenommen hatte.</p>
<p>Delegation: die redaktionelle Arbeit gebe ich ganz ab, die Entscheidung über die Struktur behalte ich. Beim Hörbuch ließ ich Claude übersetzen, Fakten korrigieren und Quellen Kapitel für Kapitel ergänzen. Die Frage, ob der Text ein Drehbuch oder ein Buch bleiben soll, ließ ich für meine eigene Entscheidung offen.</p>
<p>Kontext: ich gebe ihn einmal und verweise dann auf das bereits Gesagte. In der ersten Nachricht zum Hörbuch lieferte ich die ganze Datei und sagte: mach die Analyse. Jede weitere Nachricht baute ohne Wiederholung auf der vorigen auf, einschließlich eines Weiter-Befehls, bei dem ein einziges Wort genügte.</p>
<p>Unterscheidung: wenn sich eine Quelle nicht prüfen lässt, will ich das wissen. Beim Hörbuch verlangte ich gültige Weblinks und gründliche Prüfung. Bei der legislativen Recherche bestand ich auf dem konsolidierten Text von <a href="https://www.slov-lex.sk">slov-lex.sk</a>, nicht auf sekundären Zusammenfassungen.</p>
<p>Sorgfalt mit Daten: personenbezogene Daten in den Anweisungen haben eine eigene Regel. Claude soll Namen, Geburtsnummern und Kontaktdaten nicht speichern, ausgenommen fiktionale Figuren. In den Cowork-Präferenzen erweiterte ich das um zitierte Autoren und Amtsträger.</p>
<p>Eine monatliche Zusammenfassung des Werkzeugs, mit dem ich arbeite, ist keine Diagnose. Es ist ein Spiegel. Wenn ich darin sehe, dass ich vier Tage mit Prüfen verbracht habe, lese ich das nicht als Lob des Produkts. Ich lese es als Erinnerung, dass Vertrauen ohne Kontrolle mich Stunden kostet. Und dass die Stunden der Kontrolle genau die Arbeit sind, die ich nicht wegrationalisieren will.</p>
<p><em>Persönliche Reflexion aus einer monatlichen Claude-Reflect-Zusammenfassung. Keine Anleitung zur Arbeit mit einem bestimmten Modell und keine Bewertung seiner Qualität.</em></p>

HTML,
        ],
        'fr' => [
            'title' => 'Le mois où tout a été vérifié',
            'image_alt' => 'Sur le bureau près de la lampe reposent des manuscrits ouverts et des feuilles. La lumière traverse une loupe de verre sur le texte; des signets turquoise sont glissés entre les papiers, avec une ombre violette derrière.',
            'excerpt' => 'Six conversations, quatre jours actifs. Analyse d’un livre audio, recherche législative et réglage du travail avec Claude. La plupart des sessions ont duré des heures. Claude comme chercheur et éditeur: je lui donne le matériau et j’attends la liste de ce qui ne tient pas.',
            'content' => <<<'HTML'
<p>Six conversations, quatre jours actifs. Presque chacune tournait autour de la même chose: prendre un texte d’autrui ou mon propre système et vérifier s’il tient. Analyse d’un livre audio, vérification des sources chapitre par chapitre, recherche législative, audit de mes propres instructions. Avec Claude, j’ai travaillé comme avec un chercheur et un éditeur: je donne le matériau et j’attends en retour la liste de ce qui ne colle pas. La plupart des sessions ont duré des heures, pas des minutes.</p>
<p>Claude Reflect l’a résumé comme un mois de vérification. Le jour le plus actif était mardi, avec un pic à onze heures du soir, heure slovaque. Pas parce que je cherchais de la compagnie. Parce qu’après le travail il reste le silence pour un contrôle concentré.</p>
<p>La moitié du travail est allée à l’analyse et à la rédaction d’un livre audio: analyse factuelle, traduction, vérification des sources et rédaction du livre Ztracené kroniky. Dix-sept pour cent ont pris une recherche législative sur le transfert de la documentation de santé lors d’un changement d’employeur selon le droit slovaque. Le reste, un tiers, est allé au réglage du travail lui-même: instructions personnelles, préférences Cowork, commandes et ce que le résumé appelait recursive self-improvement, c’est-à-dire l’amélioration répétée de mes propres règles.</p>
<p>Reflect a aussi nommé quatre habitudes que je n’avais même pas remarquées comme compétences.</p>
<p>Délégation: je confie tout le travail éditorial, mais je garde la décision sur la structure. Pour le livre audio, j’ai laissé Claude traduire, corriger les faits et compléter les sources chapitre par chapitre. La question de savoir si le texte devait rester un scénario ou devenir un livre, je l’ai laissée ouverte pour ma propre décision.</p>
<p>Contexte: je le donne une fois, puis je renvoie à ce qui a déjà été dit. Dans le premier message sur le livre audio, j’ai fourni le fichier entier et dit fais l’analyse. Chaque message suivant s’appuyait sur le précédent sans répétition, y compris une commande de continuer où un seul mot suffisait.</p>
<p>Discernement: quand une source ne peut pas être vérifiée, je veux le savoir. Pour le livre audio, j’ai demandé des liens web valides et une vérification approfondie. Pour la recherche législative, j’ai insisté sur le texte consolidé de <a href="https://www.slov-lex.sk">slov-lex.sk</a>, pas sur des résumés secondaires.</p>
<p>Soin des données: les données personnelles dans les instructions ont leur propre règle. Claude ne doit pas conserver les noms, les numéros d’identité ni les coordonnées, sauf pour les personnages fictifs. Dans les préférences Cowork, j’ai élargi cela aux auteurs cités et aux responsables publics.</p>
<p>Un résumé mensuel de l’outil avec lequel je travaille n’est pas un diagnostic. C’est un miroir. Quand j’y vois que j’ai passé quatre jours à vérifier, je ne le lis pas comme un éloge du produit. Je le lis comme un rappel que la confiance sans contrôle me coûte des heures. Et que les heures de contrôle sont précisément le travail que je ne veux pas automatiser hors de ma portée.</p>
<p><em>Réflexion personnelle tirée d’un résumé mensuel Claude Reflect. Ce n’est ni un guide pour travailler avec un modèle précis, ni une évaluation de sa qualité.</em></p>

HTML,
        ],
        'es' => [
            'title' => 'El mes en que se comprobó todo',
            'image_alt' => 'Sobre el escritorio junto a la lámpara hay manuscritos abiertos y hojas. La luz cae a través de una lupa de cristal sobre el texto; entre los papeles hay marcapáginas turquesa y detrás una sombra violeta.',
            'excerpt' => 'Seis conversaciones, cuatro días activos. Análisis de un audiolibro, investigación legislativa y ajuste del trabajo con Claude. La mayoría de las sesiones duraron horas. Claude como investigador y editor: le doy el material y espero la lista de lo que no se sostiene.',
            'content' => <<<'HTML'
<p>Seis conversaciones, cuatro días activos. Casi todas giraban en torno a lo mismo: tomar un texto ajeno o el propio sistema y comprobar si se sostiene. Análisis de un audiolibro, verificación de fuentes capítulo a capítulo, investigación legislativa, auditoría de las propias instrucciones. Con Claude trabajé como con un investigador y un editor: le doy el material y espero la lista de lo que no encaja. La mayoría de las sesiones duraron horas, no minutos.</p>
<p>Claude Reflect lo resumió como un mes de verificación. El día más activo fue el martes, con un pico a las once de la noche, hora de Eslovaquia. No porque buscara compañía. Porque después del trabajo queda silencio para un control concentrado.</p>
<p>La mitad del trabajo fue al análisis y a la redacción de un audiolibro: análisis fáctico, traducción, verificación de fuentes y redacción del libro Ztracené kroniky. El diecisiete por ciento lo ocupó una investigación legislativa sobre la transferencia de documentación sanitaria al cambiar de empleador según la legislación eslovaca. El resto, un tercio, fue al ajuste del trabajo mismo: instrucciones personales, preferencias de Cowork, comandos y lo que el resumen llamó recursive self-improvement, es decir, la mejora reiterada de las propias reglas.</p>
<p>Reflect nombró además cuatro hábitos que ni siquiera había notado como habilidades.</p>
<p>Delegación: encargo todo el trabajo editorial, pero me reservo la decisión sobre la estructura. En el audiolibro dejé que Claude tradujera, corrigiera hechos y añadiera fuentes capítulo a capítulo. La pregunta de si el texto debía seguir siendo un guion o convertirse en un libro la dejé abierta para mi propia decisión.</p>
<p>Contexto: lo doy una vez y luego remito a lo ya dicho. En el primer mensaje sobre el audiolibro entregué el archivo completo y dije haz el análisis. Cada mensaje siguiente se apoyaba en el anterior sin repetición, incluido un comando de continuar en el que bastaba una sola palabra.</p>
<p>Discernimiento: cuando una fuente no se puede verificar, quiero saberlo. En el audiolibro pedí enlaces web válidos y una verificación profunda. En la investigación legislativa insistí en el texto consolidado de <a href="https://www.slov-lex.sk">slov-lex.sk</a>, no en resúmenes secundarios.</p>
<p>Cuidado con los datos: los datos personales en las instrucciones tienen su propia regla. Claude no debe conservar nombres, números de identidad ni datos de contacto, salvo personajes ficticios. En las preferencias de Cowork lo amplié a autores citados y cargos públicos.</p>
<p>Un resumen mensual de la herramienta con la que trabajo no es un diagnóstico. Es un espejo. Cuando veo en él que pasé cuatro días verificando, no lo leo como elogio del producto. Lo leo como un recordatorio de que la confianza sin control me cuesta horas. Y de que las horas de control son precisamente el trabajo que no quiero automatizar fuera de mi alcance.</p>
<p><em>Reflexión personal a partir de un resumen mensual de Claude Reflect. No es una guía para trabajar con un modelo concreto ni una valoración de su calidad.</em></p>

HTML,
        ],
        'pl' => [
            'title' => 'Miesiąc, w którym sprawdzano wszystko',
            'image_alt' => 'Na biurku przy lampce leżą otwarte rękopisy i kartki. Przez szklaną lupę pada światło na tekst; między papierami są turkusowe zakładki, a w tle fioletowy cień.',
            'excerpt' => 'Sześć rozmów, cztery aktywne dni. Analiza audiobooka, kwerenda legislacyjna i ustawienie pracy z Claude’em. Większość sesji trwała godzinami. Claude jako badacz i redaktor: daję materiał i czekam na listę tego, co nie trzyma się.',
            'content' => <<<'HTML'
<p>Sześć rozmów, cztery aktywne dni. Prawie każda krążyła wokół tego samego: wziąć cudzy tekst albo własny system i sprawdzić, czy się trzyma. Analiza audiobooka, weryfikacja źródeł rozdział po rozdziale, kwerenda legislacyjna, audyt własnych instrukcji. Z Claude’em pracowałem jak z badaczem i redaktorem, któremu daję materiał i czekam na listę tego, co nie pasuje. Większość sesji trwała godzinami, nie minutami.</p>
<p>Claude Reflect podsumował to jako miesiąc weryfikacji. Najaktywniejszy dzień to wtorek, szczyt o jedenastej wieczorem czasu słowackiego. Nie dlatego, że szukałem towarzystwa. Dlatego, że po pracy zostaje cisza na skupioną kontrolę.</p>
<p>Połowa pracy poszła na analizę i redakcję audiobooka: analiza faktów, tłumaczenie, weryfikacja źródeł i redakcja książki Ztracené kroniky. Siedemnaście procent zajęła kwerenda legislacyjna o przekazaniu dokumentacji medycznej przy zmianie pracodawcy według prawa słowackiego. Reszta, jedna trzecia, poszła na ustawienie samej pracy: osobiste instrukcje, preferencje Cowork, polecenia i to, co podsumowanie nazwało recursive self-improvement, czyli ponowne ulepszanie własnych reguł.</p>
<p>Reflect nazwał przy tym cztery nawyki, których nawet nie zauważałem jako umiejętności.</p>
<p>Delegowanie: pracę redakcyjną zlecam w całości, ale decyzję o strukturze zostawiam sobie. Przy audiobooku pozwoliłem Claude’owi tłumaczyć, poprawiać fakty i uzupełniać źródła rozdział po rozdziale. Pytanie, czy tekst ma zostać scenariuszem, czy książką, zostawiłem otwarte na własną decyzję.</p>
<p>Kontekst: podaję go raz, a potem odsyłam do tego, co już zostało powiedziane. W pierwszej wiadomości o audiobooku dałem cały plik i powiedziałem zrób analizę. Każda kolejna wiadomość budowała na poprzedniej bez powtórzeń, w tym polecenie kontynuuj, gdzie wystarczyło jedno słowo.</p>
<p>Rozróżnianie: gdy źródła nie da się sprawdzić, chcę o tym wiedzieć. Przy audiobooku żądałem ważnych linków internetowych i dogłębnej weryfikacji. Przy kwerendzie legislacyjnej nalegałem na tekst skonsolidowany z <a href="https://www.slov-lex.sk">slov-lex.sk</a>, nie na wtórne streszczenia.</p>
<p>Dbałość o dane: dane osobowe w instrukcjach mają własną regułę. Claude nie ma przechowywać imion, numerów urodzenia ani danych kontaktowych, z wyjątkiem postaci fikcyjnych. W preferencjach Cowork rozszerzyłem to o cytowanych autorów i osoby pełniące funkcje publiczne.</p>
<p>Miesięczne podsumowanie od narzędzia, z którym pracuję, nie jest diagnozą. To lustro. Gdy widzę w nim, że cztery dni spędziłem na sprawdzaniu, nie czytam tego jako pochwały produktu. Czytam to jako przypomnienie, że zaufanie bez kontroli kosztuje mnie godziny. I że godziny kontroli to właśnie ta praca, której nie chcę automatyzować na bok.</p>
<p><em>Osobista refleksja z miesięcznego podsumowania Claude Reflect. To nie jest przewodnik po pracy z konkretnym modelem ani ocena jego jakości.</em></p>

HTML,
        ],
        'hu' => [
            'title' => 'A hónap, amikor mindent ellenőriztek',
            'image_alt' => 'Az asztalon a lámpa mellett nyitott kéziratok és lapok fekszenek. Üveg nagyítón át esik a fény a szövegre; a papírok között türkiz könyvjelzők, mögöttük ibolyaárnyék.',
            'excerpt' => 'Hat beszélgetés, négy aktív nap. Hangoskönyv-elemzés, jogszabályi kutatás és a Claude-dal való munka beállítása. A legtöbb ülés órákig tartott. Claude mint kutató és szerkesztő: átadom az anyagot, és várom, mi nem állja meg a helyét.',
            'content' => <<<'HTML'
<p>Hat beszélgetés, négy aktív nap. Majdnem mindegyik ugyanarról forgott: idegen szöveget vagy a saját rendszert venni, és ellenőrizni, hogy megállja-e a helyét. Hangoskönyv elemzése, források ellenőrzése fejezetről fejezetre, jogszabályi kutatás, a saját utasítások auditja. Claude-dal úgy dolgoztam, mint egy kutatóval és szerkesztővel: átadom az anyagot, és vissza várom annak a listáját, ami nem stimmel. A legtöbb ülés órákig tartott, nem percekig.</p>
<p>A Claude Reflect ezt ellenőrző hónapként foglalta össze. A legaktívabb nap a kedd volt, a csúcs este tizenegykor, szlovákiai idő szerint. Nem azért, mert társaságra vágytam. Azért, mert a munka után csend marad a koncentrált ellenőrzésre.</p>
<p>A munka fele hangoskönyv elemzésére és szerkesztésére ment: tényszerű elemzés, fordítás, forrásellenőrzés és a Ztracené kroniky című könyv szerkesztése. Tizenhét százalékot egy jogszabályi kutatás vitt el az egészségügyi dokumentáció átadásáról munkáltatóváltáskor a szlovák jog szerint. A többi, egyharmad, magának a munkának a beállítására ment: személyes utasítások, Cowork-preferenciák, parancsok és amit az összefoglaló recursive self-improvementnek nevezett, vagyis a saját szabályok ismételt javítása.</p>
<p>A Reflect közben négy szokást nevezett meg, amelyeket ügyességként észre sem vettem.</p>
<p>Delegálás: a szerkesztői munkát teljes egészében átadom, de a szerkezetről szóló döntést magamnak tartom. A hangoskönyvnél hagytam, hogy Claude fordítson, javítsa a tényeket és egészítse ki a forrásokat fejezetről fejezetre. Azt a kérdést, hogy a szöveg forgatókönyv vagy könyv maradjon-e, nyitva hagytam a saját döntésemre.</p>
<p>Kontextus: egyszer adom meg, aztán visszautalok arra, ami már elhangzott. A hangoskönyvről szóló első üzenetben az egész fájlt odaadtam, és azt mondtam: csináld meg az elemzést. Minden további üzenet ismétlés nélkül épült az előzőre, beleértve a folytatás parancsot, ahol egyetlen szó is elég volt.</p>
<p>Megkülönböztetés: ha a forrás nem ellenőrizhető, tudni akarom. A hangoskönyvnél érvényes webcímeket és mély ellenőrzést kértem. A jogszabályi kutatásnál a <a href="https://www.slov-lex.sk">slov-lex.sk</a> konszolidált szövegére ragaszkodtam, nem másodlagos összefoglalókra.</p>
<p>Adatgondosság: a személyes adatoknak az utasításokban saját szabályuk van. Claude ne őrizzen neveket, születési számokat vagy elérhetőségeket, a fiktív szereplők kivételével. A Cowork-preferenciákban ezt kiterjesztettem az idézett szerzőkre és a közszereplőkre.</p>
<p>A havi összefoglaló attól az eszköztől, amellyel dolgozom, nem diagnózis. Tükör. Ha azt látom benne, hogy négy napot ellenőrzéssel töltöttem, nem a termék dicséreteként olvasom. Emlékeztetőként olvasom, hogy a bizalom ellenőrzés nélkül óráimba kerül. És hogy az ellenőrzés órái pontosan az a munka, amelyet nem akarok automatizálással elvenni magamtól.</p>
<p><em>Személyes reflexió a Claude Reflect havi összefoglalójából. Nem útmutató egy konkrét modellel való munkához, és nem a minőségének értékelése.</em></p>

HTML,
        ],
        'it' => [
            'title' => 'Il mese in cui si è controllato tutto',
            'image_alt' => 'Sulla scrivania accanto alla lampada ci sono manoscritti aperti e fogli. La luce passa attraverso una lente di vetro sul testo; tra le carte ci sono segnalibri turchese e dietro un’ombra viola.',
            'excerpt' => 'Sei conversazioni, quattro giorni attivi. Analisi di un audiolibro, ricerca legislativa e impostazione del lavoro con Claude. La maggior parte delle sessioni è durata ore. Claude come ricercatore ed editore: gli do il materiale e aspetto l’elenco di ciò che non regge.',
            'content' => <<<'HTML'
<p>Sei conversazioni, quattro giorni attivi. Quasi ognuna ruotava intorno alla stessa cosa: prendere un testo altrui o il proprio sistema e verificare se regge. Analisi di un audiolibro, controllo delle fonti capitolo per capitolo, ricerca legislativa, audit delle proprie istruzioni. Con Claude ho lavorato come con un ricercatore e un editore: gli do il materiale e aspetto l’elenco di ciò che non torna. La maggior parte delle sessioni è durata ore, non minuti.</p>
<p>Claude Reflect l’ha riassunto come un mese di verifica. Il giorno più attivo è stato martedì, con un picco alle undici di sera, ora slovacca. Non perché cercassi compagnia. Perché dopo il lavoro resta il silenzio per un controllo concentrato.</p>
<p>Metà del lavoro è andata all’analisi e alla redazione di un audiolibro: analisi fattuale, traduzione, verifica delle fonti e redazione del libro Ztracené kroniky. Il diciassette per cento l’ha preso una ricerca legislativa sul trasferimento della documentazione sanitaria al cambio di datore di lavoro secondo la legislazione slovacca. Il resto, un terzo, è andato all’impostazione del lavoro stesso: istruzioni personali, preferenze Cowork, comandi e ciò che il riepilogo ha chiamato recursive self-improvement, cioè il miglioramento ripetuto delle proprie regole.</p>
<p>Reflect ha inoltre nominato quattro abitudini che non avevo nemmeno notato come competenze.</p>
<p>Delega: affido tutto il lavoro editoriale, ma mi tengo la decisione sulla struttura. Per l’audiolibro ho lasciato a Claude tradurre, correggere i fatti e integrare le fonti capitolo per capitolo. La domanda se il testo dovesse restare una sceneggiatura o diventare un libro l’ho lasciata aperta alla mia decisione.</p>
<p>Contesto: lo do una volta e poi rimando a ciò che è già stato detto. Nel primo messaggio sull’audiolibro ho dato l’intero file e detto fai l’analisi. Ogni messaggio successivo si costruiva sul precedente senza ripetizioni, compreso un comando di continua in cui bastava una sola parola.</p>
<p>Discernimento: quando una fonte non si può verificare, voglio saperlo. Per l’audiolibro ho chiesto link web validi e una verifica approfondita. Per la ricerca legislativa ho insistito sul testo consolidato di <a href="https://www.slov-lex.sk">slov-lex.sk</a>, non su riassunti secondari.</p>
<p>Cura dei dati: i dati personali nelle istruzioni hanno una regola propria. Claude non deve conservare nomi, numeri di nascita né dati di contatto, salvo personaggi fittizi. Nelle preferenze Cowork l’ho estesa agli autori citati e ai pubblici ufficiali.</p>
<p>Un riepilogo mensile dello strumento con cui lavoro non è una diagnosi. È uno specchio. Quando ci vedo che ho passato quattro giorni a verificare, non lo leggo come lode del prodotto. Lo leggo come un promemoria: la fiducia senza controllo mi costa ore. E che le ore di controllo sono proprio il lavoro che non voglio automatizzare via.</p>
<p><em>Riflessione personale da un riepilogo mensile di Claude Reflect. Non è una guida al lavoro con un modello particolare né una valutazione della sua qualità.</em></p>

HTML,
        ],
        'uk' => [
            'title' => 'Місяць, у якому перевіряли все',
            'image_alt' => 'На столі біля лампи лежать відкриті рукописи й аркуші. Крізь скляну лупу світло падає на текст; між паперами бірюзові закладки, а позаду фіолетова тінь.',
            'excerpt' => 'Шість розмов, чотири активні дні. Аналіз аудіокниги, законодавчий пошук і налаштування роботи з Claude. Більшість сесій тривала годинами. Claude як дослідник і редактор: я передаю матеріал і чекаю список того, що не тримається.',
            'content' => <<<'HTML'
<p>Шість розмов, чотири активні дні. Майже кожна крутилася навколо того самого: взяти чужий текст або власну систему й перевірити, чи вона тримається. Аналіз аудіокниги, перевірка джерел розділ за розділом, законодавчий пошук, аудит власних інструкцій. З Claude я працював як із дослідником і редактором, якому передаю матеріал і чекаю список того, що не сходиться. Більшість сесій тривала годинами, не хвилинами.</p>
<p>Claude Reflect підсумував це як місяць перевірки. Найактивнішим днем був вівторок, пік о одинадцятій вечора за словацьким часом. Не тому, що я шукав товариства. Тому, що після роботи лишається тиша для зосередженої перевірки.</p>
<p>Половина роботи пішла на аналіз і редагування аудіокниги: фактичний аналіз, переклад, перевірка джерел і редагування книги Ztracené kroniky. Сімнадцять відсотків зайняв законодавчий пошук про передачу медичної документації при зміні роботодавця згідно зі словацьким законодавством. Решта, третина, пішла на налаштування самої роботи: особисті інструкції, уподобання Cowork, команди і те, що підсумок назвав recursive self-improvement, тобто повторне вдосконалення власних правил.</p>
<p>Reflect при цьому назвав чотири звички, яких я навіть не помічав як навички.</p>
<p>Делегування: редакторську роботу я віддаю цілком, але рішення про структуру залишаю собі. Для аудіокниги я дозволив Claude перекладати, виправляти факти й доповнювати джерела розділ за розділом. Питання, чи має текст лишитися сценарієм, чи стати книгою, я залишив відкритим для власного рішення.</p>
<p>Контекст: я даю його раз, а потім посилаюся на те, що вже було сказано. У першому повідомленні про аудіокнигу я дав увесь файл і сказав зроби аналіз. Кожне наступне повідомлення будувалося на попередньому без повторень, включно з командою продовжуй, де вистачало одного слова.</p>
<p>Розрізнення: коли джерело неможливо перевірити, я хочу це знати. Для аудіокниги я вимагав чинні вебпосилання й глибоку перевірку. Для законодавчого пошуку я наполягав на консолідованому тексті з <a href="https://www.slov-lex.sk">slov-lex.sk</a>, а не на вторинних оглядах.</p>
<p>Дбайливість щодо даних: особисті дані в інструкціях мають власне правило. Claude не має зберігати імена, ідентифікаційні номери чи контакти, за винятком вигаданих персонажів. В уподобаннях Cowork я розширив це винятком для цитованих авторів і публічних посадовців.</p>
<p>Місячний підсумок від інструменту, з яким я працюю, не є діагнозом. Це дзеркало. Коли я бачу в ньому, що чотири дні провів на перевірці, я не читаю це як похвалу продукту. Я читаю це як нагадування, що довіра без контролю коштує мені годин. І що години контролю — саме та робота, яку я не хочу автоматизувати геть.</p>
<p><em>Особиста рефлексія з місячного підсумку Claude Reflect. Це не інструкція з роботи з конкретною моделлю і не оцінка її якості.</em></p>

HTML,
        ],
    ],
];
