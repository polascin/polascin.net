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
 * Osobný príbeh: bot_guard na nefro.polascin.net zablokoval vlastného AI agenta
 * pri hromadnom sťahovaní článkov na e-knihu (október 2026).
 */
return [
    'slug' => 'ochrana-webu-pred-ai-aj-pred-vlastnou',
    'author' => 'MUDr. Ľubomír Polaščín',
    'category' => 'blog',
    'is_top' => 0,
    'published_at' => '2026-10-03 06:05:00',
    'image' => 'images/articles/ochrana-webu-pred-ai-aj-pred-vlastnou.webp',
    'translations' => [
        'sk' => [
            'title' => 'Ako som ochránil svoj web pred umelou inteligenciou. Aj pred tou vlastnou.',
            'image_alt' => 'Nočný digitálny vchod: fialovo-tyrkysová brána blokuje siluety AI agentov aj majiteľa webu pred žiariacimi stránkami článkov; bez čitateľného textu.',
            'excerpt' => 'Na nefro.polascin.net som nasadil ochranu pred hromadným sťahovaním obsahu na tréning AI. Potom som poveril vlastného agenta, aby stiahol moje články na e-knihu. Ochrana fungovala — aj proti mne.',
            'content' => <<<'HTML'
<p>Pred pár dňami som na <a href="https://nefro.polascin.net/">nefro.polascin.net</a> implementoval ochranu pred automatizovaným sťahovaním obsahu a zberom textov na tréning umelej inteligencie. Na portáli zverejňujem odborné články, venujem im čas a nechcem, aby si ich každý okoloidúci robot bez opýtania odniesol vo veľkom.</p>
<p>Rozumné rozhodnutie. Aspoň do dnešného rána.</p>
<p>Dnes som totiž poveril AI agenta, aby mi stiahol všetky doposiaľ zverejnené odborné články. Chcel som z nich pripraviť elektronickú knihu, tematicky ich usporiadať do kapitol, doplniť úvod a obsah a dôkladne skontrolovať odbornú terminológiu aj slovenčinu. Pracovný názov: <em>SK Nefro Báza 1</em>.</p>
<p>Moje články. Môj web. Môj agent. Čo by sa mohlo pokaziť?</p>
<p>Agent sa pustil do práce. Ochrana webu tiež.</p>
<p>Len každý plnil inú časť mojich pokynov.</p>
<p>Agent dostal úlohu sťahovať články. Bezpečnostný mechanizmus dostal úlohu brániť automatizovanému sťahovaniu. Na rozdiel odo mňa v tom nevidel nijaký rozpor. Nezaujímalo ho, kto články napísal ani kto agenta poveril. Posudzoval požiadavky, nie vlastnícke vzťahy.</p>
<p>A potom som si chcel otvoriť vlastný web.</p>
<p>Namiesto nefrologickej kalkulačky ma privítalo:</p>
<p><em>„Prístup dočasne pozastavený. Zo zariadenia prišlo neúmerné množstvo požiadaviek. Skúste to znova o 38 minút.“</em></p>
<p>Takže ochrana fungovala.</p>
<p>Dokonca tak dobre, že som sa na svoj portál nedostal ani ja.</p>
<p>Vo vývojovom prostredí sa začalo pátranie po príčine. Objavil sa súbor <code>bot_guard.php</code>, odpoveď <code>403 Forbidden</code> a kontrola pravidiel obmedzujúcich počet požiadaviek. To, čo ešte pred pár dňami predstavovalo úspešne nasadenú ochranu, bolo zrazu predmetom vyšetrovania: čo ma zablokovalo a ako sa dostať späť?</p>
<p>Najkrajšie na celej situácii bolo, že sa vlastne nikto nesprával neposlušne.</p>
<p>Agent robil, čo som mu prikázal.</p>
<p>Ochrana robila, čo som jej prikázal.</p>
<p>Iba ja som si medzitým prikázal dve veci, ktoré sa navzájom vylučovali.</p>
<p>Najprv: „Nedovoľ robotom hromadne sťahovať moje články.“</p>
<p>O pár dní: „Robot, stiahni mi hromadne moje články.“</p>
<p>Web nemal dôvod domýšľať si nevyslovený dodatok: „Ale tento je môj.“</p>
<p>Z dnešného rána si teda odnášam celkom praktické poučenie. Ak chcem chrániť verejný web pred neželaným zberom obsahu a zároveň používať vlastných agentov, musím im pripraviť osobitný, autorizovaný spôsob prístupu. Napríklad export článkov, pri ktorom sa nemusíme tváriť, že môj pomocník je náhodný návštevník internetu.</p>
<p>Nie vypnúť ochranu. Doplniť chýbajúce dvere.</p>
<p>Zatiaľ mám aspoň overené, že môj digitálny vrátnik neberie ohľad na známosti.</p>
<p>Ani keď príde majiteľ.</p>

<p><em>Osobná skúsenosť autora s hardeningom vlastného portálu. Nie je to návod na obchádzanie ochran ani na hromadné sťahovanie cudzích webov.</em></p>
HTML,
        ],
        'en' => [
            'title' => 'How I protected my site from artificial intelligence. Including my own.',
            'image_alt' => 'A night digital doorway: a violet-teal gate blocks AI-agent silhouettes and the site owner from glowing article pages; no readable text.',
            'excerpt' => 'I added protection against bulk content scraping for AI training on nefro.polascin.net. Then I asked my own agent to download my articles for an ebook. The guard worked — against me too.',
            'content' => <<<'HTML'
<p>A few days ago I implemented protection against automated content downloading and text harvesting for AI training on <a href="https://nefro.polascin.net/">nefro.polascin.net</a>. I publish specialist articles there, I invest time in them, and I do not want every passing robot to carry them off in bulk without asking.</p>
<p>A sensible decision. At least until this morning.</p>
<p>Today I tasked an AI agent with downloading every specialist article published so far. I wanted to prepare an ebook from them, arrange them thematically into chapters, add an introduction and a table of contents, and carefully check both the specialist terminology and the Slovak. Working title: <em>SK Nefro Báza 1</em>.</p>
<p>My articles. My site. My agent. What could go wrong?</p>
<p>The agent got to work. So did the site protection.</p>
<p>Only each was fulfilling a different part of my instructions.</p>
<p>The agent was told to download articles. The security mechanism was told to resist automated downloading. Unlike me, it saw no contradiction. It did not care who wrote the articles or who commissioned the agent. It judged requests, not ownership.</p>
<p>And then I tried to open my own site.</p>
<p>Instead of a nephrology calculator I was greeted with:</p>
<p><em>“Access temporarily suspended. This device sent an excessive number of requests. Try again in 38 minutes.”</em></p>
<p>So the protection worked.</p>
<p>So well that even I could not reach my portal.</p>
<p>In the development environment the hunt for the cause began. Up came the file <code>bot_guard.php</code>, a <code>403 Forbidden</code> response, and the rate-limit rules. What a few days earlier had been a successfully deployed defence was suddenly an investigation: what locked me out, and how do I get back in?</p>
<p>The finest part of the whole situation was that nobody was actually disobedient.</p>
<p>The agent did what I ordered.</p>
<p>The protection did what I ordered.</p>
<p>Only I had in the meantime ordered two things that exclude each other.</p>
<p>First: “Do not let robots bulk-download my articles.”</p>
<p>A few days later: “Robot, bulk-download my articles for me.”</p>
<p>The site had no reason to invent the unspoken rider: “But this one is mine.”</p>
<p>So from this morning I take a thoroughly practical lesson. If I want to protect a public site from unwanted content harvesting and still use my own agents, I must prepare a separate, authorised access path for them. For example an article export where we do not have to pretend my helper is a random visitor on the internet.</p>
<p>Not switch the protection off. Add the missing door.</p>
<p>For now I at least have confirmation that my digital doorman does not care about acquaintances.</p>
<p>Even when the owner arrives.</p>

<p><em>Personal experience hardening the author’s own portal. Not a guide to bypassing protections or bulk-downloading other people’s sites.</em></p>
HTML,
        ],
        'cs' => [
            'title' => 'Jak jsem ochránil svůj web před umělou inteligencí. I před tou vlastní.',
            'image_alt' => 'Noční digitální vchod: fialovo-tyrkysová brána blokuje siluety AI agentů i majitele webu před zářícími stránkami článků; bez čitelného textu.',
            'excerpt' => 'Na nefro.polascin.net jsem nasadil ochranu před hromadným stahováním obsahu na trénování AI. Pak jsem pověřil vlastního agenta, aby stáhl mé články na e-knihu. Ochrana fungovala — i proti mně.',
            'content' => <<<'HTML'
<p>Před pár dny jsem na <a href="https://nefro.polascin.net/">nefro.polascin.net</a> implementoval ochranu před automatizovaným stahováním obsahu a sběrem textů na trénování umělé inteligence. Na portálu zveřejňuji odborné články, věnuji jim čas a nechci, aby si je každý kolemjdoucí robot bez otázání odnesl ve velkém.</p>
<p>Rozumné rozhodnutí. Aspoň do dnešního rána.</p>
<p>Dnes jsem totiž pověřil AI agenta, aby mi stáhl všechny doposud zveřejněné odborné články. Chtěl jsem z nich připravit elektronickou knihu, tematicky je uspořádat do kapitol, doplnit úvod a obsah a důkladně zkontrolovat odbornou terminologii i slovenštinu. Pracovní název: <em>SK Nefro Báza 1</em>.</p>
<p>Moje články. Můj web. Můj agent. Co by se mohlo pokazit?</p>
<p>Agent se pustil do práce. Ochrana webu také.</p>
<p>Jen každý plnil jinou část mých pokynů.</p>
<p>Agent dostal úkol stahovat články. Bezpečnostní mechanismus dostal úkol bránit automatizovanému stahování. Na rozdíl ode mě v tom neviděl žádný rozpor. Nezajímalo ho, kdo články napsal ani kdo agenta pověřil. Posuzoval požadavky, ne vlastnické vztahy.</p>
<p>A pak jsem si chtěl otevřít vlastní web.</p>
<p>Místo nefrologické kalkulačky mě přivítalo:</p>
<p><em>„Přístup dočasně pozastaven. Ze zařízení přišlo nepřiměřené množství požadavků. Zkuste to znovu za 38 minut.“</em></p>
<p>Takže ochrana fungovala.</p>
<p>Dokonce tak dobře, že jsem se na svůj portál nedostal ani já.</p>
<p>Ve vývojovém prostředí začalo pátrání po příčině. Objevil se soubor <code>bot_guard.php</code>, odpověď <code>403 Forbidden</code> a kontrola pravidel omezujících počet požadavků. To, co ještě před pár dny představovalo úspěšně nasazenou ochranu, bylo najednou předmětem vyšetřování: co mě zablokovalo a jak se dostat zpět?</p>
<p>Nejkrásnější na celé situaci bylo, že se vlastně nikdo nechoval neposlušně.</p>
<p>Agent dělal, co jsem mu přikázal.</p>
<p>Ochrana dělala, co jsem jí přikázal.</p>
<p>Jen já jsem si mezitím přikázal dvě věci, které se navzájem vylučují.</p>
<p>Nejdřív: „Nedovol robotům hromadně stahovat mé články.“</p>
<p>O pár dní: „Robote, stáhni mi hromadně mé články.“</p>
<p>Web neměl důvod domýšlet si nevyslovený dodatek: „Ale tento je můj.“</p>
<p>Z dnešního rána si tedy odnáším docela praktické poučení. Pokud chci chránit veřejný web před nežádoucím sběrem obsahu a zároveň používat vlastní agenty, musím jim připravit zvláštní, autorizovaný způsob přístupu. Například export článků, při kterém se nemusíme tvářit, že můj pomocník je náhodný návštěvník internetu.</p>
<p>Ne vypnout ochranu. Doplnit chybějící dveře.</p>
<p>Zatím mám aspoň ověřené, že můj digitální vrátný nebere ohled na známosti.</p>
<p>Ani když přijde majitel.</p>

<p><em>Osobní zkušenost autora s hardeningem vlastního portálu. Není to návod na obcházení ochran ani na hromadné stahování cizích webů.</em></p>
HTML,
        ],
        'de' => [
            'title' => 'Wie ich meine Website vor künstlicher Intelligenz schützte. Auch vor der eigenen.',
            'image_alt' => 'Nächtlicher digitaler Eingang: ein violett-türkises Tor blockiert KI-Agenten-Silhouetten und den Website-Besitzer vor leuchtenden Artikelseiten; kein lesbarer Text.',
            'excerpt' => 'Auf nefro.polascin.net habe ich Schutz vor Massen-Scraping für KI-Training eingeführt. Dann beauftragte ich meinen eigenen Agenten, meine Artikel für ein E-Book zu laden. Der Schutz wirkte — auch gegen mich.',
            'content' => <<<'HTML'
<p>Vor wenigen Tagen habe ich auf <a href="https://nefro.polascin.net/">nefro.polascin.net</a> einen Schutz vor automatisiertem Herunterladen von Inhalten und Textsammlung für das Training künstlicher Intelligenz implementiert. Auf dem Portal veröffentliche ich Fachartikel, investiere Zeit und will nicht, dass jeder vorbeikommende Roboter sie ungefragt in großem Stil mitnimmt.</p>
<p>Eine vernünftige Entscheidung. Zumindest bis heute Morgen.</p>
<p>Heute habe ich nämlich einen KI-Agenten beauftragt, alle bisher veröffentlichten Fachartikel herunterzuladen. Ich wollte daraus ein E-Book vorbereiten, sie thematisch in Kapitel ordnen, Einleitung und Inhaltsverzeichnis ergänzen und Fachterminologie sowie Slowakisch gründlich prüfen. Arbeitstitel: <em>SK Nefro Báza 1</em>.</p>
<p>Meine Artikel. Meine Website. Mein Agent. Was könnte schiefgehen?</p>
<p>Der Agent machte sich an die Arbeit. Der Website-Schutz ebenfalls.</p>
<p>Nur erfüllte jeder einen anderen Teil meiner Anweisungen.</p>
<p>Der Agent sollte Artikel laden. Der Sicherheitsmechanismus sollte automatisiertes Laden verhindern. Anders als ich sah er darin keinen Widerspruch. Es interessierte ihn nicht, wer die Artikel schrieb oder wer den Agenten beauftragte. Er bewertete Anfragen, nicht Eigentumsverhältnisse.</p>
<p>Und dann wollte ich meine eigene Website öffnen.</p>
<p>Statt eines nephrologischen Rechners begrüßte mich:</p>
<p><em>„Zugang vorübergehend ausgesetzt. Von diesem Gerät kamen übermäßig viele Anfragen. Versuchen Sie es in 38 Minuten erneut.“</em></p>
<p>Also funktionierte der Schutz.</p>
<p>Sogar so gut, dass selbst ich mein Portal nicht erreichte.</p>
<p>In der Entwicklungsumgebung begann die Spurensuche. Auf tauchte die Datei <code>bot_guard.php</code>, die Antwort <code>403 Forbidden</code> und die Ratenbegrenzungsregeln. Was wenige Tage zuvor ein erfolgreich eingesetzter Schutz war, war plötzlich Gegenstand einer Untersuchung: was hat mich gesperrt, und wie komme ich zurück?</p>
<p>Das Schönste an der ganzen Situation war, dass sich eigentlich niemand ungehorsam verhielt.</p>
<p>Der Agent tat, was ich ihm befahl.</p>
<p>Der Schutz tat, was ich ihm befahl.</p>
<p>Nur ich hatte mir inzwischen zwei Dinge befohlen, die einander ausschließen.</p>
<p>Zuerst: „Lass Roboter meine Artikel nicht massenhaft herunterladen.“</p>
<p>Wenige Tage später: „Roboter, lade mir meine Artikel massenhaft herunter.“</p>
<p>Die Website hatte keinen Grund, den unausgesprochenen Zusatz zu erfinden: „Aber dieser ist meiner.“</p>
<p>Vom heutigen Morgen nehme ich also eine ganz praktische Lektion mit. Wenn ich eine öffentliche Website vor unerwünschter Inhaltssammlung schützen und zugleich eigene Agenten nutzen will, muss ich ihnen einen eigenen, autorisierten Zugangsweg bereiten. Zum Beispiel einen Artikel-Export, bei dem wir nicht so tun müssen, als wäre mein Helfer ein zufälliger Internetbesucher.</p>
<p>Nicht den Schutz abschalten. Die fehlende Tür ergänzen.</p>
<p>Vorerst habe ich zumindest bestätigt, dass mein digitaler Türsteher keine Bekanntschaften kennt.</p>
<p>Auch wenn der Besitzer kommt.</p>

<p><em>Persönliche Erfahrung des Autors mit dem Hardening des eigenen Portals. Keine Anleitung zum Umgehen von Schutzmechanismen oder zum Massen-Download fremder Websites.</em></p>
HTML,
        ],
        'fr' => [
            'title' => 'Comment j’ai protégé mon site contre l’intelligence artificielle. Y compris la mienne.',
            'image_alt' => 'Entrée numérique nocturne : une porte violet-turquoise bloque des silhouettes d’agents IA et le propriétaire du site devant des pages d’articles lumineuses ; aucun texte lisible.',
            'excerpt' => 'Sur nefro.polascin.net j’ai déployé une protection contre le téléchargement massif pour l’entraînement de l’IA. Puis j’ai chargé mon propre agent de télécharger mes articles pour un ebook. La garde a fonctionné — contre moi aussi.',
            'content' => <<<'HTML'
<p>Il y a quelques jours, j’ai mis en place sur <a href="https://nefro.polascin.net/">nefro.polascin.net</a> une protection contre le téléchargement automatisé de contenus et la collecte de textes pour l’entraînement de l’intelligence artificielle. Sur le portail je publie des articles spécialisés, j’y consacre du temps, et je ne veux pas que chaque robot de passage les emporte en masse sans demander.</p>
<p>Une décision raisonnable. Du moins jusqu’à ce matin.</p>
<p>Aujourd’hui, j’ai en effet chargé un agent d’IA de me télécharger tous les articles spécialisés publiés jusqu’ici. Je voulais en préparer un livre électronique, les ordonner thématiquement en chapitres, ajouter une introduction et une table des matières, et vérifier soigneusement la terminologie spécialisée ainsi que le slovaque. Titre de travail : <em>SK Nefro Báza 1</em>.</p>
<p>Mes articles. Mon site. Mon agent. Que pourrait-il mal tourner ?</p>
<p>L’agent s’est mis au travail. La protection du site aussi.</p>
<p>Seulement, chacun accomplissait une partie différente de mes consignes.</p>
<p>L’agent devait télécharger des articles. Le mécanisme de sécurité devait empêcher le téléchargement automatisé. Contrairement à moi, il n’y voyait aucune contradiction. Peu lui importait qui avait écrit les articles ni qui avait mandaté l’agent. Il jugeait les requêtes, pas les relations de propriété.</p>
<p>Et puis j’ai voulu ouvrir mon propre site.</p>
<p>Au lieu d’un calculateur de néphrologie, on m’a accueilli ainsi :</p>
<p><em>« Accès temporairement suspendu. Cet appareil a envoyé un nombre excessif de requêtes. Réessayez dans 38 minutes. »</em></p>
<p>Donc la protection fonctionnait.</p>
<p>Si bien que même moi je n’ai pas pu atteindre mon portail.</p>
<p>Dans l’environnement de développement a commencé la traque de la cause. Ont surgi le fichier <code>bot_guard.php</code>, la réponse <code>403 Forbidden</code> et les règles de limitation du débit. Ce qui, quelques jours plus tôt, était une protection déployée avec succès était soudain l’objet d’une enquête : qu’est-ce qui m’a bloqué, et comment revenir ?</p>
<p>Le plus beau de toute la situation, c’est que personne ne se comportait vraiment de façon désobéissante.</p>
<p>L’agent faisait ce que je lui avais ordonné.</p>
<p>La protection faisait ce que je lui avais ordonné.</p>
<p>Seul moi m’étais entre-temps ordonné deux choses qui s’excluent mutuellement.</p>
<p>D’abord : « N’autorise pas les robots à télécharger mes articles en masse. »</p>
<p>Quelques jours plus tard : « Robot, télécharge-moi mes articles en masse. »</p>
<p>Le site n’avait aucune raison d’inventer l’ajout non dit : « Mais celui-ci est à moi. »</p>
<p>De ce matin j’emporte donc une leçon tout à fait pratique. Si je veux protéger un site public contre une collecte de contenu indésirable et utiliser en même temps mes propres agents, je dois leur préparer un accès distinct et autorisé. Par exemple un export d’articles où l’on n’a pas à faire semblant que mon assistant est un visiteur internet au hasard.</p>
<p>Pas couper la protection. Ajouter la porte manquante.</p>
<p>Pour l’instant j’ai au moins vérifié que mon portier numérique ne tient pas compte des connaissances.</p>
<p>Même quand le propriétaire arrive.</p>

<p><em>Expérience personnelle de l’auteur sur le durcissement de son propre portail. Ce n’est pas un guide pour contourner les protections ni pour télécharger en masse les sites d’autrui.</em></p>
HTML,
        ],
        'es' => [
            'title' => 'Cómo protegí mi web de la inteligencia artificial. También de la mía.',
            'image_alt' => 'Entrada digital nocturna: una puerta violeta-turquesa bloquea siluetas de agentes de IA y al dueño del sitio ante páginas de artículos luminosas; sin texto legible.',
            'excerpt' => 'En nefro.polascin.net desplegué protección contra la descarga masiva de contenido para entrenar IA. Luego encargué a mi propio agente que bajara mis artículos para un ebook. La guarda funcionó — también contra mí.',
            'content' => <<<'HTML'
<p>Hace unos días implementé en <a href="https://nefro.polascin.net/">nefro.polascin.net</a> una protección contra la descarga automatizada de contenidos y la recolección de textos para el entrenamiento de inteligencia artificial. En el portal publico artículos especializados, les dedico tiempo y no quiero que cualquier robot de paso se los lleve a lo grande sin pedir permiso.</p>
<p>Una decisión razonable. Al menos hasta esta mañana.</p>
<p>Hoy encargué a un agente de IA que me descargara todos los artículos especializados publicados hasta ahora. Quería preparar con ellos un libro electrónico, ordenarlos temáticamente en capítulos, añadir introducción e índice y revisar a fondo la terminología especializada y el eslovaco. Título de trabajo: <em>SK Nefro Báza 1</em>.</p>
<p>Mis artículos. Mi web. Mi agente. ¿Qué podía salir mal?</p>
<p>El agente se puso a trabajar. La protección del sitio también.</p>
<p>Solo que cada uno cumplía una parte distinta de mis instrucciones.</p>
<p>El agente debía descargar artículos. El mecanismo de seguridad debía impedir la descarga automatizada. A diferencia de mí, no veía contradicción alguna. No le importaba quién escribió los artículos ni quién encargó al agente. Juzgaba peticiones, no relaciones de propiedad.</p>
<p>Y entonces quise abrir mi propia web.</p>
<p>En lugar de una calculadora nefrológica me recibió:</p>
<p><em>«Acceso suspendido temporalmente. Desde este dispositivo llegó un número excesivo de peticiones. Inténtelo de nuevo en 38 minutos.»</em></p>
<p>Así que la protección funcionaba.</p>
<p>Tan bien que ni siquiera yo pude llegar a mi portal.</p>
<p>En el entorno de desarrollo empezó la búsqueda de la causa. Apareció el archivo <code>bot_guard.php</code>, la respuesta <code>403 Forbidden</code> y las reglas de límite de tasa. Lo que unos días antes era una protección desplegada con éxito era de pronto objeto de investigación: qué me bloqueó y cómo volver.</p>
<p>Lo más hermoso de toda la situación fue que en realidad nadie se comportaba de forma desobediente.</p>
<p>El agente hacía lo que le ordené.</p>
<p>La protección hacía lo que le ordené.</p>
<p>Solo yo me había ordenado entretanto dos cosas que se excluyen mutuamente.</p>
<p>Primero: «No dejes que los robots descarguen mis artículos en masa.»</p>
<p>Unos días después: «Robot, descárgame mis artículos en masa.»</p>
<p>La web no tenía motivo para inventar el añadido no dicho: «Pero este es mío.»</p>
<p>De esta mañana aún me llevo una lección bastante práctica. Si quiero proteger una web pública del acopio indeseado de contenido y a la vez usar mis propios agentes, debo prepararles un acceso separado y autorizado. Por ejemplo una exportación de artículos en la que no tengamos que fingir que mi ayudante es un visitante al azar de internet.</p>
<p>No apagar la protección. Añadir la puerta que falta.</p>
<p>Por ahora al menos he verificado que mi portero digital no hace favores por amistad.</p>
<p>Ni cuando llega el dueño.</p>

<p><em>Experiencia personal del autor endureciendo su propio portal. No es una guía para eludir protecciones ni para descargar en masa webs ajenas.</em></p>
HTML,
        ],
        'pl' => [
            'title' => 'Jak ochroniłem swoją stronę przed sztuczną inteligencją. Także przed własną.',
            'image_alt' => 'Nocne cyfrowe wejście: fioletowo-turkusowa brama blokuje sylwetki agentów AI i właściciela strony przed świecącymi stronami artykułów; bez czytelnego tekstu.',
            'excerpt' => 'Na nefro.polascin.net wdrożyłem ochronę przed masowym pobieraniem treści do trenowania AI. Potem zleciłem własnemu agentowi pobranie moich artykułów na e-book. Ochrona zadziałała — także przeciwko mnie.',
            'content' => <<<'HTML'
<p>Kilka dni temu wdrożyłem na <a href="https://nefro.polascin.net/">nefro.polascin.net</a> ochronę przed automatycznym pobieraniem treści i zbieraniem tekstów do trenowania sztucznej inteligencji. Na portalu publikuję artykuły specjalistyczne, poświęcam im czas i nie chcę, by każdy mijający robot zabierał je masowo bez pytania.</p>
<p>Rozsądna decyzja. Przynajmniej do dzisiejszego rana.</p>
<p>Dziś bowiem zleciłem agentowi AI, by pobrał wszystkie dotychczas opublikowane artykuły specjalistyczne. Chciałem przygotować z nich e-book, ułożyć je tematycznie w rozdziały, dodać wstęp i spis treści oraz dokładnie sprawdzić terminologię specjalistyczną i słowacki. Tytuł roboczy: <em>SK Nefro Báza 1</em>.</p>
<p>Moje artykuły. Moja strona. Mój agent. Co mogło pójść nie tak?</p>
<p>Agent zabrał się do pracy. Ochrona strony też.</p>
<p>Tylko każdy wykonywał inną część moich poleceń.</p>
<p>Agent miał pobierać artykuły. Mechanizm bezpieczeństwa miał bronić przed automatycznym pobieraniem. W przeciwieństwie do mnie nie widział w tym sprzeczności. Nie obchodziło go, kto napisał artykuły ani kto zlecił agentowi. Oceniał żądania, nie stosunki własności.</p>
<p>A potem chciałem otworzyć własną stronę.</p>
<p>Zamiast kalkulatora nefrologicznego powitało mnie:</p>
<p><em>„Dostęp tymczasowo zawieszony. Z urządzenia nadeszła nadmierna liczba żądań. Spróbuj ponownie za 38 minut.”</em></p>
<p>Więc ochrona działała.</p>
<p>Tak dobrze, że nawet ja nie dostałem się na swój portal.</p>
<p>W środowisku deweloperskim zaczęło się śledztwo. Pojawił się plik <code>bot_guard.php</code>, odpowiedź <code>403 Forbidden</code> i reguły ograniczające liczbę żądań. To, co kilka dni wcześniej było skutecznie wdrożoną ochroną, stało się nagle przedmiotem dochodzenia: co mnie zablokowało i jak wrócić?</p>
<p>Najpiękniejsze w całej sytuacji było to, że właściwie nikt nie zachowywał się nieposłusznie.</p>
<p>Agent robił, co mu kazałem.</p>
<p>Ochrona robiła, co jej kazałem.</p>
<p>Tylko ja w międzyczasie kazałem sobie dwie rzeczy, które się wzajemnie wykluczają.</p>
<p>Najpierw: „Nie pozwalaj robotom masowo pobierać moich artykułów.”</p>
<p>Kilka dni później: „Robocie, pobierz mi masowo moje artykuły.”</p>
<p>Strona nie miała powodu wymyślać niewypowiedzianego dodatku: „Ale ten jest mój.”</p>
<p>Z dzisiejszego rana zabieram więc całkiem praktyczną lekcję. Jeśli chcę chronić publiczną stronę przed niepożądanym zbieraniem treści i zarazem używać własnych agentów, muszę przygotować im osobny, autoryzowany sposób dostępu. Na przykład eksport artykułów, przy którym nie musimy udawać, że mój pomocnik jest przypadkowym gościem internetu.</p>
<p>Nie wyłączać ochrony. Dodać brakujące drzwi.</p>
<p>Na razie mam przynajmniej potwierdzenie, że mój cyfrowy portier nie bierze pod uwagę znajomości.</p>
<p>Nawet gdy przychodzi właściciel.</p>

<p><em>Osobiste doświadczenie autora z hardeningiem własnego portalu. To nie jest przewodnik po omijaniu zabezpieczeń ani po masowym pobieraniu cudzych stron.</em></p>
HTML,
        ],
        'hu' => [
            'title' => 'Hogyan védtem meg a webemet a mesterséges intelligenciától. A sajátomtól is.',
            'image_alt' => 'Éjszakai digitális bejárat: lila-türkiz kapu blokkolja az AI-ügynök sziluetteket és a web tulajdonosát a fényes cikkoldalak előtt; nincs olvasható szöveg.',
            'excerpt' => 'A nefro.polascin.net-en védelmet vezettem be a tartalom tömeges letöltése ellen az AI-tréninghez. Aztán saját ügynökömet bíztam meg, hogy töltse le a cikkeimet e-könyvhöz. A védelem működött — ellenem is.',
            'content' => <<<'HTML'
<p>Néhány napja a <a href="https://nefro.polascin.net/">nefro.polascin.net</a>-en védelmet vezettem be a tartalom automatizált letöltése és a szövegek mesterségesintelligencia-tréninghez való gyűjtése ellen. A portálon szakcikkeket teszek közzé, időt fordítok rájuk, és nem akarom, hogy minden arra járó robot kérdezés nélkül nagyban elvigye őket.</p>
<p>Ésszerű döntés. Legalábbis a mai reggelig.</p>
<p>Ma ugyanis megbíztam egy AI-ügynököt, hogy töltse le az összes eddig közzétett szakcikket. E-könyvet akartam belőlük készíteni, tematikus fejezetekbe rendezni, bevezetőt és tartalomjegyzéket kiegészíteni, és alaposan ellenőrizni a szakterminológiát és a szlovákot. Munkacím: <em>SK Nefro Báza 1</em>.</p>
<p>Az én cikkeim. Az én webem. Az én ügynököm. Mi romolhatna el?</p>
<p>Az ügynök munkához látott. A web védelme is.</p>
<p>Csak mindketten az utasításaim más-más részét teljesítették.</p>
<p>Az ügynök cikkeket töltött le. A biztonsági mechanizmus az automatizált letöltést akadályozta. Velem ellentétben nem ő látott ebben ellentmondást. Nem érdekelte, ki írta a cikkeket, sem hogy ki bízta meg az ügynököt. Kéréseket ítélt, nem tulajdonviszonyokat.</p>
<p>Aztán meg akartam nyitni a saját webemet.</p>
<p>Nephrológiai kalkulátor helyett ez fogadott:</p>
<p><em>„A hozzáférés ideiglenesen felfüggesztve. Az eszközről aránytalanul sok kérés érkezett. Próbálja újra 38 perc múlva.”</em></p>
<p>Tehát a védelem működött.</p>
<p>Annyira jól, hogy még én sem jutottam be a saját portálomra.</p>
<p>A fejlesztői környezetben elkezdődött az ok nyomozása. Felbukkant a <code>bot_guard.php</code> fájl, a <code>403 Forbidden</code> válasz és a kérések számát korlátozó szabályok. Ami néhány napja sikeresen bevezetett védelem volt, hirtelen vizsgálat tárgya lett: mi zárt ki, és hogyan jutok vissza?</p>
<p>A helyzet legszebb része az volt, hogy igazából senki sem viselkedett engedetlenül.</p>
<p>Az ügynök azt tette, amit megparancsoltam.</p>
<p>A védelem azt tette, amit megparancsoltam.</p>
<p>Csak én parancsoltam magamnak közben két egymást kizáró dolgot.</p>
<p>Először: „Ne engedd, hogy robotok tömegesen letöltsék a cikkeimet.”</p>
<p>Néhány nap múlva: „Robot, töltsd le tömegesen a cikkeimet.”</p>
<p>A webnek nem volt oka kitalálni a ki nem mondott toldalékot: „De ez az enyém.”</p>
<p>A mai reggelből tehát egészen gyakorlati tanulságot viszek. Ha nyilvános webet akarok védeni a nemkívánatos tartalomgyűjtés ellen, és közben saját ügynököket akarok használni, külön, jogosított hozzáférési utat kell készítenem nekik. Például cikkexportot, ahol nem kell úgy tennünk, mintha a segítőm véletlen internetes látogató volna.</p>
<p>Nem kikapcsolni a védelmet. Pótolni a hiányzó ajtót.</p>
<p>Egyelőre legalább igazoltam, hogy a digitális kapusom nem nézi az ismeretséget.</p>
<p>Még akkor sem, ha a tulajdonos jön.</p>

<p><em>A szerző személyes tapasztalata a saját portáljának megerősítéséről. Nem útmutató védelmek megkerüléséhez vagy idegen webek tömeges letöltéséhez.</em></p>
HTML,
        ],
        'it' => [
            'title' => 'Come ho protetto il mio sito dall’intelligenza artificiale. Anche dalla mia.',
            'image_alt' => 'Ingresso digitale notturno: un cancello viola-turchese blocca silhouettes di agenti IA e il proprietario del sito davanti a pagine di articoli luminose; nessun testo leggibile.',
            'excerpt' => 'Su nefro.polascin.net ho messo una protezione contro il download massivo di contenuti per l’addestramento dell’IA. Poi ho incaricato il mio agente di scaricare i miei articoli per un ebook. La guardia ha funzionato — anche contro di me.',
            'content' => <<<'HTML'
<p>Qualche giorno fa ho implementato su <a href="https://nefro.polascin.net/">nefro.polascin.net</a> una protezione contro il download automatizzato di contenuti e la raccolta di testi per l’addestramento dell’intelligenza artificiale. Sul portale pubblico articoli specialistici, ci investo tempo e non voglio che ogni robot di passaggio se li porti via in massa senza chiedere.</p>
<p>Una decisione ragionevole. Almeno fino a stamattina.</p>
<p>Oggi ho incaricato un agente IA di scaricarmi tutti gli articoli specialistici pubblicati finora. Volevo prepararne un ebook, ordinarli tematicamente in capitoli, aggiungere introduzione e indice e controllare a fondo la terminologia specialistica e lo slovacco. Titolo di lavoro: <em>SK Nefro Báza 1</em>.</p>
<p>I miei articoli. Il mio sito. Il mio agente. Cosa poteva andare storto?</p>
<p>L’agente si è messo al lavoro. Anche la protezione del sito.</p>
<p>Solo che ciascuno eseguiva una parte diversa delle mie istruzioni.</p>
<p>L’agente doveva scaricare articoli. Il meccanismo di sicurezza doveva impedire il download automatizzato. A differenza di me, non vedeva alcuna contraddizione. Non gli importava chi avesse scritto gli articoli né chi avesse incaricato l’agente. Valutava le richieste, non i rapporti di proprietà.</p>
<p>E poi ho voluto aprire il mio sito.</p>
<p>Al posto di un calcolatore di nefrologia mi ha accolto:</p>
<p><em>«Accesso temporaneamente sospeso. Da questo dispositivo è arrivato un numero eccessivo di richieste. Riprova tra 38 minuti.»</em></p>
<p>Quindi la protezione funzionava.</p>
<p>Così bene che nemmeno io riuscivo a raggiungere il mio portale.</p>
<p>Nell’ambiente di sviluppo è iniziata la caccia alla causa. È emerso il file <code>bot_guard.php</code>, la risposta <code>403 Forbidden</code> e le regole di rate limit. Ciò che pochi giorni prima era una protezione distribuita con successo era improvvisamente oggetto di indagine: cosa mi ha bloccato e come rientrare?</p>
<p>La parte più bella di tutta la situazione era che in realtà nessuno si comportava in modo disobbediente.</p>
<p>L’agente faceva ciò che gli avevo ordinato.</p>
<p>La protezione faceva ciò che le avevo ordinato.</p>
<p>Solo io nel frattempo mi ero ordinato due cose che si escludono a vicenda.</p>
<p>Prima: «Non permettere ai robot di scaricare in massa i miei articoli.»</p>
<p>Pochi giorni dopo: «Robot, scaricami in massa i miei articoli.»</p>
<p>Il sito non aveva motivo di inventare l’aggiunta non detta: «Ma questo è mio.»</p>
<p>Da stamattina porto quindi una lezione del tutto pratica. Se voglio proteggere un sito pubblico dalla raccolta indesiderata di contenuti e al tempo stesso usare i miei agenti, devo preparare loro un accesso separato e autorizzato. Per esempio un export degli articoli in cui non dobbiamo fingere che il mio aiutante sia un visitatore internet a caso.</p>
<p>Non spegnere la protezione. Aggiungere la porta mancante.</p>
<p>Per ora ho almeno verificato che il mio portiere digitale non tiene conto delle conoscenze.</p>
<p>Nemmeno quando arriva il proprietario.</p>

<p><em>Esperienza personale dell’autore sull’hardening del proprio portale. Non è una guida per aggirare le protezioni né per scaricare in massa siti altrui.</em></p>
HTML,
        ],
        'uk' => [
            'title' => 'Як я захистив свій сайт від штучного інтелекту. І від власного теж.',
            'image_alt' => 'Нічний цифровий вхід: фіолетово-бірюзова брама блокує силуети AI-агентів і власника сайту перед сяючими сторінками статей; без читабельного тексту.',
            'excerpt' => 'На nefro.polascin.net я впровадив захист від масового звантаження контенту для тренування ШІ. Потім доручив власному агенту звантажити мої статті для е-книги. Захист спрацював — і проти мене.',
            'content' => <<<'HTML'
<p>Кілька днів тому на <a href="https://nefro.polascin.net/">nefro.polascin.net</a> я впровадив захист від автоматизованого звантаження контенту та збору текстів для тренування штучного інтелекту. На порталі публікую фахові статті, витрачаю на них час і не хочу, щоб кожен побіжний робот без дозволу забирав їх масово.</p>
<p>Розумне рішення. Принаймні до сьогоднішнього ранку.</p>
<p>Сьогодні я доручив AI-агенту звантажити всі досі опубліковані фахові статті. Хотів підготувати з них електронну книгу, тематично розкласти їх на розділи, доповнити вступом і змістом і ретельно перевірити фахову термінологію та словацьку. Робоча назва: <em>SK Nefro Báza 1</em>.</p>
<p>Мої статті. Мій сайт. Мій агент. Що могло піти не так?</p>
<p>Агент узявся до роботи. Захист сайту теж.</p>
<p>Тільки кожен виконував іншу частину моїх вказівок.</p>
<p>Агент мав звантажувати статті. Механізм безпеки мав перешкоджати автоматизованому звантаженню. На відміну від мене, він не бачив у цьому суперечності. Йому було байдуже, хто написав статті і хто доручив агенту. Він оцінював запити, а не відносини власності.</p>
<p>А потім я захотів відкрити власний сайт.</p>
<p>Замість нефрологічного калькулятора мене зустріло:</p>
<p><em>«Доступ тимчасово призупинено. З пристрою надійшла надмірна кількість запитів. Спробуйте знову за 38 хвилин.»</em></p>
<p>Отже, захист спрацював.</p>
<p>Настільки добре, що навіть я не потрапив на свій портал.</p>
<p>У середовищі розробки почалося розслідування причини. З’явився файл <code>bot_guard.php</code>, відповідь <code>403 Forbidden</code> і правила обмеження кількості запитів. Те, що кілька днів тому було успішно впровадженим захистом, раптом стало предметом розслідування: що мене заблокувало і як повернутися?</p>
<p>Найкрасивіше в усій ситуації було те, що насправді ніхто не поводився непокірно.</p>
<p>Агент робив те, що я йому наказав.</p>
<p>Захист робив те, що я йому наказав.</p>
<p>Лише я тим часом наказав собі дві речі, які взаємно виключаються.</p>
<p>Спочатку: «Не дозволяй роботам масово звантажувати мої статті.»</p>
<p>За кілька днів: «Роботе, звантаж мені масово мої статті.»</p>
<p>Сайт не мав підстав вигадувати недоговорену додатку: «Але цей — мій.»</p>
<p>З сьогоднішнього ранку я отже виношу цілком практичний урок. Якщо хочу захищати публічний сайт від небажаного збору контенту і водночас користуватися власними агентами, мушу підготувати їм окремий, авторизований спосіб доступу. Наприклад експорт статей, де не треба вдавати, що мій помічник — випадковий відвідувач інтернету.</p>
<p>Не вимикати захист. Додати відсутні двері.</p>
<p>Поки що маю принаймні підтвердження, що мій цифровий швейцар не зважає на знайомства.</p>
<p>Навіть коли приходить власник.</p>

<p><em>Особистий досвід автора з hardening власного порталу. Це не інструкція з обходу захистів і не з масового звантаження чужих сайтів.</em></p>
HTML,
        ],
    ],
];
