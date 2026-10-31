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
 * Osobná reflexia z ročného súhrnu Claude Reflect.
 * Počty konverzácií, podiely tém a opisy návykov sú z dodaného súhrnu.
 * Portál slov-lex.sk overený ako oficiálny právny portál SR (Tavily, 2026-10-29).
 * Stav rukopisu Ztracené kroniky súhrn neurčuje; článok ho neprehlasuje za vydaný.
 * Úradné a právne témy sú zovšeobecnené; konkrétne osobné okolnosti neuverejňujeme.
 */
return [
    'slug' => 'kontext-prichadza-po-davkach',
    'author' => 'MUDr. Ľubomír Polaščín',
    'category' => 'blog',
    'is_top' => 0,
    'published_at' => '2026-10-29 19:45:00',
    'image' => 'images/articles/kontext-prichadza-po-davkach.webp',
    'translations' => [
        'sk' => [
            'title' => 'Kontext prichádza po dávkach',
            'image_alt' => 'Na tmavom stole ležia vrstvy priesvitných listov, každá mierne posunutá. Cez tyrkysové sklo padá svetlo na papier, v pozadí je fialový tieň.',
            'excerpt' => 'Dvadsaťtri konverzácií. Nedeľa najaktívnejší deň, vrchol o ôsmej ráno. Legislatíva, sieť medzi počítačmi a redakcia rukopisu. Spoločný vzorec: dlhé viackolové sedenia, kde každý nový fakt mení celý dokument.',
            'content' => <<<'HTML'
<p>Dvadsaťtri konverzácií za rok. Claude Reflect ich zoradil do troch druhov práce: právne podania a rešerše, sieťová infraštruktúra medzi viacerými počítačmi a redakcia knižného rukopisu. Pri každom som Claudovi pridelil inú úlohu. Výskumníka a autora textu. Technického poradcu. Editora a overovateľa faktov. Spoločný vzorec ostal rovnaký. Dlhé, viackolové konverzácie. Vracal som sa s novou informáciou a nechal som prepracovať celý dokument.</p>
<p>Najaktívnejší deň bola nedeľa. Vrchol o ôsmej ráno slovenského času. Nie preto, že by ráno prinášalo nápady. Preto, že pred bežným dňom ostáva ticho na sústredenú prácu.</p>
<p>Reflect rozdelil témy podľa podielu. Viac než tretina išla do úradných a právnych textov: odvolania, vyjadrenia, zdravotné poistenie, právne poradenstvo. Približne pätina do redakcie rukopisu Ztracené kroniky: analýza, preklad, overovanie faktov a zdrojov. Stav vydania súhrn neurčuje a ja ho tu neprehlasujem. Rovnaký diel do sieťovej infraštruktúry: lokálne AI, SSH, ZeroTier, Tailscale, firewall medzi počítačmi. Menej do lekárskej praxe a legislatívy okolo zdravotnej dokumentácie a dialýzy. Zvyšok do nastavení samotného Claudu: osobné inštrukcie, preferencie a súbory skill.md.</p>
<p>Reflect pomenoval štyri návyky.</p>
<p>Delegovanie: výskum a písanie idú do Claude, rozhodnutia zostávajú u mňa. Pri úradnom texte som nechal pripraviť celý návrh aj výpočty, no každú novú skutočnosť som priniesol sám a nechal prepracovať argumentáciu. Pri rukopise som nechal overiť fakty a opraviť chyby, ale o štruktúre a rozsahu som rozhodoval ja.</p>
<p>Opis: kontext prichádza po dávkach, nie na začiatku. V jednej dlhej konverzácii sa kľúčové fakty objavovali postupne. Najprv všeobecná otázka, potom miesto, potom doklad, potom adresa, potom ďalšia okolnosť. Každý nový fakt zmenil celý dokument. Projekt s kontextom na jednom mieste by znížil počet prepracovaní.</p>
<p>Rozlišovanie: keď niečo nesedí, vrátim sa a opravím to. Pri SSH konfigurácii som si všimol, že sa stratil pôvodný súbor, a vrátil som sa s nájdenou kópiou. Pri rukopise som po analýze nechal overiť každý citát a zdroj. Fakty, ktoré neobstáli, som nechal odstrániť alebo opraviť.</p>
<p>Dôslednosť: overenie zdrojov je súčasť každého väčšieho výstupu. Pri rukopise som žiadal overené zdroje s platnými odkazmi ku každej kapitole. Pri právnych podaniach som žiadal citácie konkrétnych paragrafov a overenie na <a href="https://www.slov-lex.sk">slov-lex.sk</a>. Pri infraštruktúre som žiadal overenie príkazov pred spustením.</p>
<p>Súhrn od nástroja, s ktorým pracujem, nie je chvála. Je to zoznam návykov, ktoré si človek môže myslieť, že už ovláda. Keď v ňom vidím, že väčšina práce je prepracovanie po novej informácii, nečítam to ako zlyhanie modelu. Čítam to ako cenu za to, že kontext neprichádza naraz. A že rozhodnutie, čo s textom urobiť, ostáva tam, kde má ostať.</p>
<p><em>Osobná reflexia z ročného súhrnu Claude Reflect. Nie je to návod na prácu s konkrétnym modelom ani hodnotenie jeho kvality.</em></p>

HTML,
        ],
        'en' => [
            'title' => 'Context arrives in batches',
            'image_alt' => 'Layers of translucent pages lie on a dark desk, each slightly offset. Light falls through a teal glass onto the paper, with a violet shadow behind.',
            'excerpt' => 'Twenty-three conversations. Sunday the busiest day, peak at eight in the morning. Legislation, a network between computers, and manuscript editing. The shared pattern: long multi-round sittings where each new fact rewrites the whole document.',
            'content' => <<<'HTML'
<p>Twenty-three conversations in a year. Claude Reflect sorted them into three kinds of work: legal filings and research, network infrastructure across several computers, and editing a book manuscript. For each I gave Claude a different role. Researcher and writer of text. Technical adviser. Editor and fact-checker. The shared pattern stayed the same. Long, multi-round conversations. I came back with new information and had the whole document rewritten.</p>
<p>The busiest day was Sunday. The peak was at eight in the morning, Slovakia time. Not because morning brings ideas. Because before an ordinary day there is quiet left for concentrated work.</p>
<p>Reflect split the topics by share. More than a third went to official and legal texts: appeals, statements, health insurance, legal advice. About a fifth to editing the manuscript of Ztracené kroniky: analysis, translation, checking facts and sources. The summary does not settle the publication status, and I do not claim it here. The same share went to network infrastructure: local AI, SSH, ZeroTier, Tailscale, a firewall between computers. Less to medical practice and legislation around health records and dialysis. The rest to Claude’s own settings: personal instructions, preferences and skill.md files.</p>
<p>Reflect named four habits.</p>
<p>Delegation: research and writing go to Claude; decisions stay with me. For an official text I had the whole draft and the calculations prepared, yet every new fact I brought myself and had the argument rewritten. For the manuscript I had facts checked and errors fixed, but I decided structure and scope.</p>
<p>Description: context arrives in batches, not at the start. In one long conversation the key facts appeared gradually. First a general question, then a place, then a document, then an address, then another circumstance. Each new fact changed the whole document. A project with context in one place would cut the number of rewrites.</p>
<p>Discernment: when something does not fit, I go back and fix it. With an SSH configuration I noticed that the original file had been lost, and I returned with a recovered copy. For the manuscript, after the analysis I had every quotation and source checked. Facts that did not hold I had removed or corrected.</p>
<p>Diligence: checking sources is part of every larger output. For the manuscript I asked for verified sources with valid links for each chapter. For legal filings I asked for citations of specific sections and verification on <a href="https://www.slov-lex.sk">slov-lex.sk</a>. For infrastructure I asked for commands to be checked before they were run.</p>
<p>A summary from the tool I work with is not praise. It is a list of habits a person may think they already master. When I see in it that most of the work is rewriting after new information, I do not read it as a failure of the model. I read it as the price of context that does not arrive at once. And as a reminder that the decision about what to do with the text stays where it should.</p>
<p><em>A personal reflection from a Claude Reflect yearly summary. It is not a guide to working with a particular model, nor an assessment of its quality.</em></p>

HTML,
        ],
        'cs' => [
            'title' => 'Kontext přichází po dávkách',
            'image_alt' => 'Na tmavém stole leží vrstvy průsvitných listů, každá mírně posunutá. Přes tyrkysové sklo dopadá světlo na papír, v pozadí je fialový stín.',
            'excerpt' => 'Třiadvacet konverzací. Neděle nejaktivnější den, vrchol o osmé ráno. Legislativa, síť mezi počítači a redakce rukopisu. Společný vzorec: dlouhá vícekola sezení, kde každý nový fakt mění celý dokument.',
            'content' => <<<'HTML'
<p>Třiadvacet konverzací za rok. Claude Reflect je seřadil do tří druhů práce: právní podání a rešerše, síťová infrastruktura mezi několika počítači a redakce knižního rukopisu. U každého jsem Claudovi přidělil jinou roli. Výzkumníka a autora textu. Technického poradce. Editora a ověřovatele faktů. Společný vzorec zůstal stejný. Dlouhé, vícekola konverzace. Vracel jsem se s novou informací a nechal jsem přepracovat celý dokument.</p>
<p>Nejaktivnější den byla neděle. Vrchol o osmé ráno slovenského času. Ne proto, že by ráno přinášelo nápady. Proto, že před běžným dnem zbývá ticho na soustředěnou práci.</p>
<p>Reflect rozdělil témata podle podílu. Více než třetina šla do úředních a právních textů: odvolání, vyjádření, zdravotní pojištění, právní poradenství. Přibližně pětina do redakce rukopisu Ztracené kroniky: analýza, překlad, ověřování faktů a zdrojů. Stav vydání souhrn neurčuje a já ho zde neprohlašuji. Stejný díl do síťové infrastruktury: lokální AI, SSH, ZeroTier, Tailscale, firewall mezi počítači. Méně do lékařské praxe a legislativy kolem zdravotní dokumentace a dialýzy. Zbytek do nastavení samotného Clauda: osobní instrukce, preference a soubory skill.md.</p>
<p>Reflect pojmenoval čtyři návyky.</p>
<p>Delegování: výzkum a psaní jdou do Claude, rozhodnutí zůstávají u mě. U úředního textu jsem nechal připravit celý návrh i výpočty, ale každou novou skutečnost jsem přinesl sám a nechal přepracovat argumentaci. U rukopisu jsem nechal ověřit fakta a opravit chyby, ale o struktuře a rozsahu jsem rozhodoval já.</p>
<p>Popis: kontext přichází po dávkách, ne na začátku. V jedné dlouhé konverzaci se klíčová fakta objevovala postupně. Nejprve obecná otázka, pak místo, pak doklad, pak adresa, pak další okolnost. Každý nový fakt změnil celý dokument. Projekt s kontextem na jednom místě by snížil počet přepracování.</p>
<p>Rozlišování: když něco nesedí, vrátím se a opravím to. U SSH konfigurace jsem si všiml, že se ztratil původní soubor, a vrátil jsem se s nalezenou kopií. U rukopisu jsem po analýze nechal ověřit každý citát a zdroj. Fakta, která neobstála, jsem nechal odstranit nebo opravit.</p>
<p>Důslednost: ověření zdrojů je součástí každého většího výstupu. U rukopisu jsem žádal ověřené zdroje s platnými odkazy ke každé kapitole. U právních podání jsem žádal citace konkrétních paragrafů a ověření na <a href="https://www.slov-lex.sk">slov-lex.sk</a>. U infrastruktury jsem žádal ověření příkazů před spuštěním.</p>
<p>Souhrn od nástroje, se kterým pracuji, není chvála. Je to seznam návyků, o kterých si člověk může myslet, že je už ovládá. Když v něm vidím, že většina práce je přepracování po nové informaci, nečtu to jako selhání modelu. Čtu to jako cenu za to, že kontext nepřichází najednou. A že rozhodnutí, co s textem udělat, zůstává tam, kde má zůstat.</p>
<p><em>Osobní reflexe z ročního souhrnu Claude Reflect. Není to návod na práci s konkrétním modelem ani hodnocení jeho kvality.</em></p>

HTML,
        ],
        'de' => [
            'title' => 'Kontext kommt in Portionen',
            'image_alt' => 'Auf einem dunklen Schreibtisch liegen Schichten durchscheinender Blätter, jedes leicht versetzt. Durch ein türkises Glas fällt Licht aufs Papier, dahinter ein violetter Schatten.',
            'excerpt' => 'Dreiundzwanzig Gespräche. Sonntag der aktivste Tag, Höhepunkt um acht Uhr morgens. Gesetzgebung, Netz zwischen Computern und Manuskriptredaktion. Das gemeinsame Muster: lange mehrstufige Sitzungen, in denen jeder neue Fakt das ganze Dokument ändert.',
            'content' => <<<'HTML'
<p>Dreiundzwanzig Gespräche in einem Jahr. Claude Reflect ordnete sie in drei Arten von Arbeit: rechtliche Eingaben und Recherchen, Netzwerkinfrastruktur zwischen mehreren Computern und die Redaktion eines Buchmanuskripts. Bei jeder gab ich Claude eine andere Rolle. Forscher und Verfasser von Text. Technischer Berater. Redakteur und Faktenprüfer. Das gemeinsame Muster blieb gleich. Lange, mehrstufige Gespräche. Ich kam mit neuer Information zurück und ließ das ganze Dokument überarbeiten.</p>
<p>Der aktivste Tag war Sonntag. Der Höhepunkt lag um acht Uhr morgens, slowakischer Zeit. Nicht weil der Morgen Ideen brächte. Weil vor dem gewöhnlichen Tag Stille für konzentrierte Arbeit bleibt.</p>
<p>Reflect teilte die Themen nach Anteil. Mehr als ein Drittel ging in amtliche und rechtliche Texte: Berufungen, Stellungnahmen, Krankenversicherung, Rechtsberatung. Etwa ein Fünftel in die Redaktion des Manuskripts von Ztracené kroniky: Analyse, Übersetzung, Prüfung von Fakten und Quellen. Den Veröffentlichungsstand legt die Zusammenfassung nicht fest, und ich behaupte ihn hier nicht. Derselbe Anteil ging in die Netzwerkinfrastruktur: lokale KI, SSH, ZeroTier, Tailscale, Firewall zwischen Computern. Weniger in die ärztliche Praxis und die Gesetzgebung um Gesundheitsdokumentation und Dialyse. Der Rest in Claudes eigene Einstellungen: persönliche Anweisungen, Präferenzen und skill.md-Dateien.</p>
<p>Reflect benannte vier Gewohnheiten.</p>
<p>Delegation: Forschung und Schreiben gehen an Claude, Entscheidungen bleiben bei mir. Bei einem amtlichen Text ließ ich den ganzen Entwurf und die Berechnungen vorbereiten, doch jede neue Tatsache brachte ich selbst und ließ die Argumentation überarbeiten. Beim Manuskript ließ ich Fakten prüfen und Fehler korrigieren, aber über Struktur und Umfang entschied ich.</p>
<p>Beschreibung: Kontext kommt in Portionen, nicht am Anfang. In einem langen Gespräch erschienen die entscheidenden Fakten nach und nach. Zuerst eine allgemeine Frage, dann ein Ort, dann ein Beleg, dann eine Adresse, dann ein weiterer Umstand. Jeder neue Fakt änderte das ganze Dokument. Ein Projekt mit Kontext an einem Ort würde die Zahl der Überarbeitungen senken.</p>
<p>Unterscheidung: wenn etwas nicht stimmt, gehe ich zurück und korrigiere es. Bei einer SSH-Konfiguration merkte ich, dass die Originaldatei verloren war, und kam mit einer wiedergefundenen Kopie zurück. Beim Manuskript ließ ich nach der Analyse jedes Zitat und jede Quelle prüfen. Fakten, die nicht hielten, ließ ich streichen oder korrigieren.</p>
<p>Sorgfalt: die Prüfung von Quellen gehört zu jedem größeren Ergebnis. Beim Manuskript verlangte ich geprüfte Quellen mit gültigen Links zu jedem Kapitel. Bei rechtlichen Eingaben verlangte ich Zitate konkreter Paragraphen und Prüfung auf <a href="https://www.slov-lex.sk">slov-lex.sk</a>. Bei der Infrastruktur verlangte ich die Prüfung von Befehlen vor dem Ausführen.</p>
<p>Eine Zusammenfassung von dem Werkzeug, mit dem ich arbeite, ist kein Lob. Es ist eine Liste von Gewohnheiten, von denen man meinen kann, man beherrsche sie schon. Wenn ich darin sehe, dass die meiste Arbeit Überarbeitung nach neuer Information ist, lese ich das nicht als Versagen des Modells. Ich lese es als den Preis dafür, dass Kontext nicht auf einmal kommt. Und als Erinnerung, dass die Entscheidung, was mit dem Text geschehen soll, dort bleibt, wo sie bleiben soll.</p>
<p><em>Persönliche Reflexion aus einer jährlichen Claude-Reflect-Zusammenfassung. Kein Leitfaden zur Arbeit mit einem bestimmten Modell und keine Bewertung seiner Qualität.</em></p>

HTML,
        ],
        'fr' => [
            'title' => 'Le contexte arrive par lots',
            'image_alt' => 'Sur un bureau sombre, des couches de feuilles translucides, chacune légèrement décalée. La lumière traverse un verre turquoise jusqu’au papier; derrière, une ombre violette.',
            'excerpt' => 'Vingt-trois conversations. Dimanche jour le plus actif, pic à huit heures du matin. Législation, réseau entre ordinateurs et rédaction d’un manuscrit. Le schéma commun: de longues séances en plusieurs tours où chaque nouveau fait change tout le document.',
            'content' => <<<'HTML'
<p>Vingt-trois conversations en un an. Claude Reflect les a classées en trois sortes de travail: dépôts et recherches juridiques, infrastructure réseau entre plusieurs ordinateurs, et rédaction d’un manuscrit de livre. Pour chacune j’ai donné à Claude un rôle différent. Chercheur et auteur de texte. Conseiller technique. Éditeur et vérificateur de faits. Le schéma commun est resté le même. De longues conversations en plusieurs tours. Je revenais avec une information nouvelle et je faisais retravailler tout le document.</p>
<p>Le jour le plus actif était dimanche. Le pic tombait à huit heures du matin, heure slovaque. Non pas parce que le matin apporte des idées. Parce qu’avant une journée ordinaire il reste le silence pour un travail concentré.</p>
<p>Reflect a réparti les thèmes par part. Plus d’un tiers est allé aux textes officiels et juridiques: recours, déclarations, assurance maladie, conseil juridique. Environ un cinquième à la rédaction du manuscrit de Ztracené kroniky: analyse, traduction, vérification des faits et des sources. Le résumé ne fixe pas l’état de publication, et je ne l’affirme pas ici. La même part est allée à l’infrastructure réseau: IA locale, SSH, ZeroTier, Tailscale, pare-feu entre ordinateurs. Moins à la pratique médicale et à la législation autour de la documentation de santé et de la dialyse. Le reste aux réglages de Claude lui-même: instructions personnelles, préférences et fichiers skill.md.</p>
<p>Reflect a nommé quatre habitudes.</p>
<p>Délégation: la recherche et l’écriture vont à Claude, les décisions restent chez moi. Pour un texte officiel j’ai fait préparer tout le projet et les calculs, mais chaque fait nouveau je l’ai apporté moi-même et j’ai fait retravailler l’argumentation. Pour le manuscrit j’ai fait vérifier les faits et corriger les erreurs, mais j’ai décidé de la structure et de l’ampleur.</p>
<p>Description: le contexte arrive par lots, pas au début. Dans une longue conversation les faits clés apparaissaient peu à peu. D’abord une question générale, puis un lieu, puis une pièce, puis une adresse, puis une autre circonstance. Chaque fait nouveau changeait tout le document. Un projet avec le contexte en un seul endroit réduirait le nombre de reprises.</p>
<p>Discernement: quand quelque chose ne tient pas, je reviens et je corrige. Pour une configuration SSH j’ai remarqué que le fichier d’origine avait disparu, et je suis revenu avec une copie retrouvée. Pour le manuscrit, après l’analyse, j’ai fait vérifier chaque citation et chaque source. Les faits qui ne tenaient pas, je les ai fait supprimer ou corriger.</p>
<p>Diligence: la vérification des sources fait partie de chaque résultat plus large. Pour le manuscrit j’ai demandé des sources vérifiées avec des liens valides pour chaque chapitre. Pour les dépôts juridiques j’ai demandé des citations de paragraphes précis et une vérification sur <a href="https://www.slov-lex.sk">slov-lex.sk</a>. Pour l’infrastructure j’ai demandé la vérification des commandes avant exécution.</p>
<p>Un résumé de l’outil avec lequel je travaille n’est pas une louange. C’est une liste d’habitudes qu’on peut croire déjà maîtriser. Quand j’y vois que la plupart du travail est une reprise après une information nouvelle, je ne le lis pas comme un échec du modèle. Je le lis comme le prix d’un contexte qui n’arrive pas d’un coup. Et comme un rappel que la décision sur ce qu’il faut faire du texte reste là où elle doit rester.</p>
<p><em>Réflexion personnelle tirée d’un résumé annuel Claude Reflect. Ce n’est ni un guide pour travailler avec un modèle particulier, ni une évaluation de sa qualité.</em></p>

HTML,
        ],
        'es' => [
            'title' => 'El contexto llega a trozos',
            'image_alt' => 'Sobre un escritorio oscuro hay capas de hojas translúcidas, cada una ligeramente desplazada. La luz atraviesa un cristal turquesa hasta el papel; detrás, una sombra violeta.',
            'excerpt' => 'Veintitrés conversaciones. Domingo el día más activo, pico a las ocho de la mañana. Legislación, red entre ordenadores y redacción de un manuscrito. El patrón común: largas sesiones en varias rondas donde cada hecho nuevo cambia todo el documento.',
            'content' => <<<'HTML'
<p>Veintitrés conversaciones en un año. Claude Reflect las ordenó en tres clases de trabajo: escritos e investigación jurídica, infraestructura de red entre varios ordenadores y redacción de un manuscrito de libro. En cada una di a Claude un papel distinto. Investigador y autor de texto. Asesor técnico. Editor y comprobador de hechos. El patrón común se mantuvo. Largas conversaciones en varias rondas. Volvía con información nueva y hacía rehacer todo el documento.</p>
<p>El día más activo fue el domingo. El pico fue a las ocho de la mañana, hora de Eslovaquia. No porque la mañana traiga ideas. Porque antes de un día ordinario queda silencio para un trabajo concentrado.</p>
<p>Reflect repartió los temas por cuota. Más de un tercio fue a textos oficiales y jurídicos: recursos, declaraciones, seguro sanitario, asesoramiento jurídico. Alrededor de una quinta parte a la redacción del manuscrito de Ztracené kroniky: análisis, traducción, comprobación de hechos y fuentes. El resumen no fija el estado de publicación, y yo no lo afirmo aquí. La misma cuota fue a la infraestructura de red: IA local, SSH, ZeroTier, Tailscale, cortafuegos entre ordenadores. Menos a la práctica médica y a la legislación sobre documentación sanitaria y diálisis. El resto a los ajustes del propio Claude: instrucciones personales, preferencias y archivos skill.md.</p>
<p>Reflect nombró cuatro hábitos.</p>
<p>Delegación: la investigación y la escritura van a Claude; las decisiones se quedan conmigo. En un texto oficial hice preparar todo el borrador y los cálculos, pero cada hecho nuevo lo aporté yo y hice rehacer la argumentación. En el manuscrito hice comprobar hechos y corregir errores, pero decidí la estructura y el alcance.</p>
<p>Descripción: el contexto llega a trozos, no al principio. En una conversación larga los hechos clave aparecían poco a poco. Primero una pregunta general, luego un lugar, luego un documento, luego una dirección, luego otra circunstancia. Cada hecho nuevo cambió todo el documento. Un proyecto con el contexto en un solo sitio reduciría el número de reescrituras.</p>
<p>Discernimiento: cuando algo no encaja, vuelvo y lo corrijo. En una configuración SSH noté que se había perdido el archivo original y volví con una copia recuperada. En el manuscrito, tras el análisis, hice comprobar cada cita y cada fuente. Los hechos que no se sostenían los hice eliminar o corregir.</p>
<p>Diligencia: la comprobación de fuentes forma parte de todo resultado mayor. En el manuscrito pedí fuentes verificadas con enlaces válidos para cada capítulo. En los escritos jurídicos pedí citas de párrafos concretos y verificación en <a href="https://www.slov-lex.sk">slov-lex.sk</a>. En la infraestructura pedí comprobar los comandos antes de ejecutarlos.</p>
<p>Un resumen de la herramienta con la que trabajo no es un elogio. Es una lista de hábitos que uno puede creer que ya domina. Cuando veo en él que la mayor parte del trabajo es reescribir tras una información nueva, no lo leo como un fallo del modelo. Lo leo como el precio de un contexto que no llega de una vez. Y como un recordatorio de que la decisión sobre qué hacer con el texto se queda donde debe quedarse.</p>
<p><em>Reflexión personal a partir de un resumen anual de Claude Reflect. No es una guía para trabajar con un modelo concreto ni una valoración de su calidad.</em></p>

HTML,
        ],
        'pl' => [
            'title' => 'Kontekst przychodzi partiami',
            'image_alt' => 'Na ciemnym biurku leżą warstwy półprzezroczystych kart, każda lekko przesunięta. Przez turkusowe szkło pada światło na papier, w tle fioletowy cień.',
            'excerpt' => 'Dwadzieścia trzy rozmowy. Niedziela najaktywniejszy dzień, szczyt o ósmej rano. Legislacja, sieć między komputerami i redakcja rękopisu. Wspólny wzorzec: długie wieloetapowe sesje, w których każdy nowy fakt zmienia cały dokument.',
            'content' => <<<'HTML'
<p>Dwadzieścia trzy rozmowy w ciągu roku. Claude Reflect uporządkował je w trzy rodzaje pracy: wnioski i kwerendy prawne, infrastruktura sieciowa między kilkoma komputerami oraz redakcja rękopisu książki. Przy każdej dałem Claude’owi inną rolę. Badacza i autora tekstu. Doradcę technicznego. Redaktora i weryfikatora faktów. Wspólny wzorzec pozostał ten sam. Długie, wieloetapowe rozmowy. Wracałem z nową informacją i kazałem przerobić cały dokument.</p>
<p>Najaktywniejszym dniem była niedziela. Szczyt o ósmej rano czasu słowackiego. Nie dlatego, że rano przynosi pomysły. Dlatego, że przed zwykłym dniem zostaje cisza na skupioną pracę.</p>
<p>Reflect podzielił tematy według udziału. Ponad jedna trzecia poszła na teksty urzędowe i prawne: odwołania, oświadczenia, ubezpieczenie zdrowotne, poradnictwo prawne. Około jednej piątej na redakcję rękopisu Ztracené kroniky: analiza, tłumaczenie, weryfikacja faktów i źródeł. Status wydania podsumowanie nie ustala, a ja go tu nie ogłaszam. Taki sam udział poszedł na infrastrukturę sieciową: lokalne AI, SSH, ZeroTier, Tailscale, zapora między komputerami. Mniej na praktykę lekarską i legislację wokół dokumentacji medycznej i dializy. Reszta na ustawienia samego Claude’a: osobiste instrukcje, preferencje i pliki skill.md.</p>
<p>Reflect nazwał cztery nawyki.</p>
<p>Delegowanie: badania i pisanie idą do Claude’a, decyzje zostają u mnie. Przy tekście urzędowym kazałem przygotować cały projekt i obliczenia, ale każdy nowy fakt przynosiłem sam i kazałem przerobić argumentację. Przy rękopisie kazałem sprawdzić fakty i poprawić błędy, ale o strukturze i zakresie decydowałem ja.</p>
<p>Opis: kontekst przychodzi partiami, nie na początku. W jednej długiej rozmowie kluczowe fakty pojawiały się stopniowo. Najpierw ogólne pytanie, potem miejsce, potem dokument, potem adres, potem kolejna okoliczność. Każdy nowy fakt zmieniał cały dokument. Projekt z kontekstem w jednym miejscu zmniejszyłby liczbę przeróbek.</p>
<p>Rozróżnianie: kiedy coś nie pasuje, wracam i poprawiam. Przy konfiguracji SSH zauważyłem, że zniknął oryginalny plik, i wróciłem z odnalezioną kopią. Przy rękopisie po analizie kazałem sprawdzić każdy cytat i źródło. Fakty, które nie wytrzymały, kazałem usunąć lub poprawić.</p>
<p>Staranność: weryfikacja źródeł jest częścią każdego większego wyniku. Przy rękopisie wymagałem zweryfikowanych źródeł z ważnymi odnośnikami do każdego rozdziału. Przy wnioskach prawnych wymagałem cytacji konkretnych paragrafów i weryfikacji na <a href="https://www.slov-lex.sk">slov-lex.sk</a>. Przy infrastrukturze wymagałem sprawdzenia poleceń przed uruchomieniem.</p>
<p>Podsumowanie od narzędzia, z którym pracuję, nie jest pochwałą. To lista nawyków, o których człowiek może myśleć, że już je opanował. Kiedy widzę w nim, że większość pracy to przeróbka po nowej informacji, nie czytam tego jako porażki modelu. Czytam to jako cenę za to, że kontekst nie przychodzi naraz. I jako przypomnienie, że decyzja, co zrobić z tekstem, zostaje tam, gdzie powinna zostać.</p>
<p><em>Osobista refleksja z rocznego podsumowania Claude Reflect. To nie jest poradnik pracy z konkretnym modelem ani ocena jego jakości.</em></p>

HTML,
        ],
        'hu' => [
            'title' => 'A kontextus adagokban érkezik',
            'image_alt' => 'Sötét asztalon áttetsző lapok rétegei fekszenek, mindegyik kissé eltolva. Türkiz üvegen át fény esik a papírra, mögötte ibolyás árnyék.',
            'excerpt' => 'Huszonhárom beszélgetés. Vasárnap a legaktívabb nap, csúcs reggel nyolckor. Jogszabályok, hálózat a számítógépek között és kézirat-szerkesztés. A közös minta: hosszú, többkörös ülések, ahol minden új tény megváltoztatja az egész dokumentumot.',
            'content' => <<<'HTML'
<p>Huszonhárom beszélgetés egy év alatt. A Claude Reflect háromféle munkába sorolta őket: jogi beadványok és kutatás, hálózati infrastruktúra több számítógép között, és egy könyvkézirat szerkesztése. Mindegyiknél más szerepet adtam Claude-nak. Kutatót és szövegírót. Műszaki tanácsadót. Szerkesztőt és tényellenőrzőt. A közös minta megmaradt. Hosszú, többkörös beszélgetések. Új információval tértem vissza, és átíratam az egész dokumentumot.</p>
<p>A legaktívabb nap a vasárnap volt. A csúcs reggel nyolckor, szlovák idő szerint. Nem azért, mert a reggel ötleteket hozna. Azért, mert a szokásos nap előtt még van csend a koncentrált munkára.</p>
<p>A Reflect arány szerint osztotta a témákat. Több mint egyharmad hivatalos és jogi szövegekre ment: fellebbezések, nyilatkozatok, egészségbiztosítás, jogi tanácsadás. Körülbelül egyötöd a Ztracené kroniky kéziratának szerkesztésére: elemzés, fordítás, tények és források ellenőrzése. A kiadás állapotát az összefoglaló nem rögzíti, és én sem állítom itt. Ugyanakkora rész a hálózati infrastruktúrára: helyi AI, SSH, ZeroTier, Tailscale, tűzfal a számítógépek között. Kevesebb az orvosi gyakorlatra és az egészségügyi dokumentáció és dialízis körüli jogszabályokra. A többi Claude saját beállításaira: személyes utasítások, preferenciák és skill.md fájlok.</p>
<p>A Reflect négy szokást nevezett meg.</p>
<p>Delegálás: a kutatás és az írás Claude-hoz megy, a döntések nálam maradnak. Hivatalos szövegnél az egész tervezetet és a számításokat is elkészíttettem, de minden új tényt magam hoztam, és átíratam az érvelést. A kéziratnál ellenőriztettem a tényeket és javíttattam a hibákat, de a szerkezetről és a terjedelmről én döntöttem.</p>
<p>Leírás: a kontextus adagokban érkezik, nem az elején. Egy hosszú beszélgetésben a kulcsfontosságú tények fokozatosan jelentek meg. Először általános kérdés, aztán hely, aztán igazolvány, aztán cím, aztán újabb körülmény. Minden új tény megváltoztatta az egész dokumentumot. Egy projekt, ahol a kontextus egy helyen van, csökkentené az átírások számát.</p>
<p>Megkülönböztetés: ha valami nem stimmel, visszatérek és javítom. Egy SSH-konfigurációnál észrevettem, hogy elveszett az eredeti fájl, és visszatértem a megtalált másolattal. A kéziratnál az elemzés után minden idézetet és forrást ellenőriztettem. A meg nem álló tényeket eltávolíttattam vagy javíttattam.</p>
<p>Gondosság: a források ellenőrzése minden nagyobb kimenet része. A kéziratnál ellenőrzött forrásokat kértem érvényes hivatkozásokkal minden fejezethez. Jogi beadványoknál konkrét paragrafusok idézését és ellenőrzést kértem a <a href="https://www.slov-lex.sk">slov-lex.sk</a> oldalon. Infrastruktúránál a parancsok ellenőrzését kértem futtatás előtt.</p>
<p>Az eszköz összefoglalója, amellyel dolgozom, nem dicséret. Szokások listája, amelyekről azt hihetjük, már birtokoljuk őket. Amikor azt látom benne, hogy a munka nagy része új információ utáni átírás, nem a modell kudarcának olvasom. Annak az árát olvasom, hogy a kontextus nem egyszerre érkezik. És emlékeztetőnek, hogy a döntés arról, mit tegyen a szöveggel, ott marad, ahol maradnia kell.</p>
<p><em>Személyes reflexió a Claude Reflect éves összefoglalójából. Nem útmutató egy adott modellel való munkához, és nem a minőségének értékelése.</em></p>

HTML,
        ],
        'it' => [
            'title' => 'Il contesto arriva a dose',
            'image_alt' => 'Su una scrivania scura giacciono strati di fogli traslucidi, ciascuno leggermente spostato. Attraverso un vetro turchese cade luce sulla carta; dietro, un’ombra viola.',
            'excerpt' => 'Ventitré conversazioni. Domenica il giorno più attivo, picco alle otto del mattino. Legislazione, rete tra computer e redazione di un manoscritto. Lo schema comune: lunghe sedute a più turni in cui ogni nuovo fatto cambia l’intero documento.',
            'content' => <<<'HTML'
<p>Ventitré conversazioni in un anno. Claude Reflect le ha ordinate in tre tipi di lavoro: atti e ricerche giuridiche, infrastruttura di rete tra più computer e redazione di un manoscritto di libro. In ciascuna ho assegnato a Claude un ruolo diverso. Ricercatore e autore di testo. Consulente tecnico. Redattore e verificatore di fatti. Lo schema comune è rimasto lo stesso. Conversazioni lunghe, a più turni. Tornavo con un’informazione nuova e facevo rifare l’intero documento.</p>
<p>Il giorno più attivo è stata la domenica. Il picco alle otto del mattino, ora slovacca. Non perché il mattino porti idee. Perché prima di una giornata ordinaria resta il silenzio per un lavoro concentrato.</p>
<p>Reflect ha ripartito i temi per quota. Più di un terzo è andato a testi ufficiali e giuridici: ricorsi, dichiarazioni, assicurazione sanitaria, consulenza legale. Circa un quinto alla redazione del manoscritto di Ztracené kroniky: analisi, traduzione, verifica di fatti e fonti. Lo stato di pubblicazione il riepilogo non lo fissa, e io non lo dichiaro qui. La stessa quota è andata all’infrastruttura di rete: AI locale, SSH, ZeroTier, Tailscale, firewall tra computer. Meno alla pratica medica e alla legislazione intorno alla documentazione sanitaria e alla dialisi. Il resto alle impostazioni di Claude stesso: istruzioni personali, preferenze e file skill.md.</p>
<p>Reflect ha nominato quattro abitudini.</p>
<p>Delega: ricerca e scrittura vanno a Claude, le decisioni restano a me. Per un testo ufficiale ho fatto preparare l’intero progetto e i calcoli, ma ogni fatto nuovo l’ho portato io e ho fatto rifare l’argomentazione. Per il manoscritto ho fatto verificare i fatti e correggere gli errori, ma su struttura e ampiezza ho deciso io.</p>
<p>Descrizione: il contesto arriva a dose, non all’inizio. In una lunga conversazione i fatti chiave apparivano a poco a poco. Prima una domanda generale, poi un luogo, poi un documento, poi un indirizzo, poi un’altra circostanza. Ogni fatto nuovo cambiava l’intero documento. Un progetto con il contesto in un solo posto ridurrebbe il numero di rifacimenti.</p>
<p>Discernimento: quando qualcosa non torna, torno indietro e correggo. Con una configurazione SSH ho notato che il file originale era sparito, e sono tornato con una copia ritrovata. Per il manoscritto, dopo l’analisi, ho fatto verificare ogni citazione e ogni fonte. I fatti che non reggevano li ho fatti togliere o correggere.</p>
<p>Diligenza: la verifica delle fonti fa parte di ogni risultato più ampio. Per il manoscritto ho chiesto fonti verificate con collegamenti validi per ogni capitolo. Per gli atti giuridici ho chiesto citazioni di paragrafi precisi e verifica su <a href="https://www.slov-lex.sk">slov-lex.sk</a>. Per l’infrastruttura ho chiesto di verificare i comandi prima di eseguirli.</p>
<p>Un riepilogo dello strumento con cui lavoro non è una lode. È un elenco di abitudini che si può pensare di padroneggiare già. Quando ci vedo che gran parte del lavoro è rifare dopo un’informazione nuova, non lo leggo come un fallimento del modello. Lo leggo come il prezzo di un contesto che non arriva tutto insieme. E come un richiamo che la decisione su cosa fare del testo resta dove deve restare.</p>
<p><em>Riflessione personale da un riepilogo annuale di Claude Reflect. Non è una guida al lavoro con un modello particolare né una valutazione della sua qualità.</em></p>

HTML,
        ],
        'uk' => [
            'title' => 'Контекст приходить порціями',
            'image_alt' => 'На темному столі лежать шари напівпрозорих аркушів, кожен трохи зміщений. Крізь бірюзове скло падає світло на папір, позаду фіолетова тінь.',
            'excerpt' => 'Двадцять три розмови. Неділя найактивніший день, пік о восьмій ранку. Законодавство, мережа між комп’ютерами й редакція рукопису. Спільний візерунок: довгі багатоколові сесії, де кожен новий факт змінює весь документ.',
            'content' => <<<'HTML'
<p>Двадцять три розмови за рік. Claude Reflect упорядкував їх у три види роботи: юридичні подання й дослідження, мережева інфраструктура між кількома комп’ютерами та редакція книжкового рукопису. У кожній я дав Claude іншу роль. Дослідника й автора тексту. Технічного радника. Редактора й перевіряльника фактів. Спільний візерунок лишився той самий. Довгі, багатоколові розмови. Я повертався з новою інформацією й наказував переробити весь документ.</p>
<p>Найактивнішим днем була неділя. Пік о восьмій ранку за словацьким часом. Не тому, що ранок приносить ідеї. Тому, що перед звичайним днем лишається тиша для зосередженої роботи.</p>
<p>Reflect розділив теми за часткою. Понад третина пішла на офіційні й юридичні тексти: апеляції, заяви, медичне страхування, юридичні поради. Близько п’ятої частини на редакцію рукопису Ztracené kroniky: аналіз, переклад, перевірка фактів і джерел. Стан видання підсумок не визначає, і я його тут не стверджую. Така сама частка пішла на мережеву інфраструктуру: локальний AI, SSH, ZeroTier, Tailscale, брандмауер між комп’ютерами. Менше на лікарську практику й законодавство навколо медичної документації та діалізу. Решта на налаштування самого Claude: особисті інструкції, уподобання та файли skill.md.</p>
<p>Reflect назвав чотири звички.</p>
<p>Делегування: дослідження й писання йдуть до Claude, рішення лишаються в мене. Для офіційного тексту я наказав підготувати весь проєкт і обчислення, але кожен новий факт приносив сам і наказував переробити аргументацію. Для рукопису наказав перевірити факти й виправити помилки, але про структуру й обсяг вирішував я.</p>
<p>Опис: контекст приходить порціями, не на початку. В одній довгій розмові ключові факти з’являлися поступово. Спочатку загальне питання, потім місце, потім документ, потім адреса, потім ще одна обставина. Кожен новий факт змінював весь документ. Проєкт із контекстом в одному місці зменшив би кількість переробок.</p>
<p>Розрізнення: коли щось не сходиться, я повертаюся й виправляю. При конфігурації SSH я помітив, що зник оригінальний файл, і повернувся зі знайденою копією. Для рукопису після аналізу наказав перевірити кожну цитату й джерело. Факти, що не встояли, наказав прибрати або виправити.</p>
<p>Ретельність: перевірка джерел є частиною кожного більшого результату. Для рукопису я вимагав перевірені джерела з чинними посиланнями до кожного розділу. Для юридичних подань вимагав цитати конкретних параграфів і перевірку на <a href="https://www.slov-lex.sk">slov-lex.sk</a>. Для інфраструктури вимагав перевірити команди перед запуском.</p>
<p>Підсумок від інструменту, з яким я працюю, не є похвалою. Це список звичок, які людина може вважати вже опанованими. Коли бачу в ньому, що більшість роботи становить переробка після нової інформації, не читаю це як провал моделі. Читаю як ціну за те, що контекст не приходить одразу. І як нагадування, що рішення, що робити з текстом, лишається там, де має лишитися.</p>
<p><em>Особиста рефлексія з річного підсумку Claude Reflect. Це не порадник щодо роботи з конкретною моделлю і не оцінка її якості.</em></p>

HTML,
        ],
    ],
];
