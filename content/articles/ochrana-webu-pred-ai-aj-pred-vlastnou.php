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
            'excerpt' => 'Na nefro.polascin.net som nasadil ochranu pred hromadným sťahovaním obsahu na tréning AI. Potom som poveril vlastného agenta, aby stiahol moje články na e-knihu. Ochrana fungovala, aj proti mne.',
            'content' => <<<'HTML'
<p>Pred pár dňami som na <a href="https://nefro.polascin.net/">nefro.polascin.net</a> nasadil ochranu pred automatizovaným sťahovaním obsahu a pred zberom textov na tréning umelej inteligencie. Na portáli zverejňujem odborné články, venujem im čas a nechcem, aby si ich každý okoloidúci robot bez opýtania odniesol vo veľkom.</p>
<p>Rozumné rozhodnutie. Aspoň do dnešného rána.</p>
<p>Dnes som totiž poveril AI agenta, aby mi stiahol všetky doteraz zverejnené odborné články. Chcel som z nich pripraviť elektronickú knihu, tematicky ich usporiadať do kapitol, doplniť úvod a obsah a dôkladne skontrolovať odbornú terminológiu aj slovenčinu. Pracovný názov: <em>SK Nefro Báza 1</em>.</p>
<p>Moje články, môj web, môj agent. Čo by sa mohlo pokaziť?</p>
<p>Agent sa pustil do sťahovania a ochrana webu do blokovania. Každý plnil inú časť mojich pokynov. Agent mal články stiahnuť. Bezpečnostný mechanizmus mal automatizované sťahovanie zastaviť. Na rozdiel odo mňa v tom nevidel rozpor. Nezaujímalo ho, kto články napísal ani kto agenta poveril. Posudzoval požiadavky, nie to, komu web patrí.</p>
<p>Potom som si chcel otvoriť vlastný web. Namiesto nefrologickej kalkulačky ma privítalo:</p>
<p><em>„Prístup dočasne pozastavený. Zo zariadenia prišlo neúmerné množstvo požiadaviek. Skúste to znova o 38 minút.“</em></p>
<p>Ochrana teda fungovala. Tak dobre, že som sa na svoj portál nedostal ani ja.</p>
<p>Vo vývojovom prostredí sa začalo pátranie po príčine. Objavil sa súbor <code>bot_guard.php</code>, odpoveď <code>403 Forbidden</code> a kontrola pravidiel, ktoré obmedzujú počet požiadaviek. To, čo ešte pred pár dňami vyzeralo ako úspešne nasadená ochrana, bolo zrazu predmetom otázky, čo ma zablokovalo a ako sa dostať späť.</p>
<p>Nikto sa pritom nesprával neposlušne. Agent robil, čo som mu prikázal. Ochrana robila, čo som jej prikázal. Iba ja som si medzitým prikázal dve veci, ktoré sa navzájom vylučujú.</p>
<p>Najprv: „Nedovoľ robotom hromadne sťahovať moje články.“</p>
<p>O pár dní: „Robot, stiahni mi hromadne moje články.“</p>
<p>Web nemal dôvod domýšľať si nevyslovený dodatok: „Ale tento je môj.“</p>
<p>Z dnešného rána ostáva praktická vec. Ak chcem chrániť verejný web pred neželaným zberom obsahu a zároveň používať vlastných agentov, musím im pripraviť osobitný, autorizovaný prístup. Napríklad export článkov, pri ktorom sa nemusíme tváriť, že môj pomocník je náhodný návštevník internetu.</p>
<p>Ochranu nevypínam. Doplním dvere, ktoré chýbali.</p>
<p>Zatiaľ mám overené, že digitálny vrátnik neberie ohľad na známosti. Ani keď príde majiteľ.</p>

<p><em>Osobná skúsenosť autora so spevnením vlastného portálu. Nie je to návod na obchádzanie ochrán ani na hromadné sťahovanie cudzích webov.</em></p>
HTML,
        ],
        'en' => [
            'title' => 'How I protected my site from artificial intelligence. Including my own.',
            'image_alt' => 'A night digital doorway: a violet-teal gate blocks AI-agent silhouettes and the site owner from glowing article pages; no readable text.',
            'excerpt' => 'I added protection against bulk content scraping for AI training on nefro.polascin.net. Then I asked my own agent to download my articles for an ebook. The guard worked, against me too.',
            'content' => <<<'HTML'
<p>A few days ago I put protection against automated downloading and against text harvesting for AI training on <a href="https://nefro.polascin.net/">nefro.polascin.net</a>. I publish specialist articles there, I put time into them, and I do not want every passing robot to carry them off in bulk without asking.</p>
<p>A sensible decision. At least until this morning.</p>
<p>Today I tasked an AI agent with downloading every specialist article published so far. I wanted an ebook from them, arranged by theme into chapters, with an introduction and a table of contents, and a careful check of the specialist terminology and of the Slovak. Working title: <em>SK Nefro Báza 1</em>.</p>
<p>My articles, my site, my agent. What could go wrong?</p>
<p>The agent started downloading and the site protection started blocking. Each was carrying out a different part of my instructions. The agent was to download the articles. The security mechanism was to stop automated downloading. Unlike me, it saw no contradiction. It did not care who wrote the articles or who had given the agent the job. It judged requests, not who the site belongs to.</p>
<p>Then I tried to open my own site. Instead of a nephrology calculator I was greeted with:</p>
<p><em>“Access temporarily suspended. This device sent an excessive number of requests. Try again in 38 minutes.”</em></p>
<p>So the protection worked. So well that even I could not reach my portal.</p>
<p>In the development environment the search for the cause began. Up came the file <code>bot_guard.php</code>, a <code>403 Forbidden</code> response, and the rules that limit how many requests get through. What a few days earlier had looked like a defence successfully in place was suddenly the question of what had locked me out, and how to get back in.</p>
<p>Nobody was disobeying. The agent did what I ordered. The protection did what I ordered. Only I had in the meantime ordered two things that exclude each other.</p>
<p>First: “Do not let robots bulk-download my articles.”</p>
<p>A few days later: “Robot, bulk-download my articles for me.”</p>
<p>The site had no reason to invent the unspoken rider: “But this one is mine.”</p>
<p>What remains from this morning is a practical point. If I want to protect a public site from unwanted harvesting and still use my own agents, I have to give them a separate, authorised way in. An export of the articles, for example, so we do not have to pretend that my helper is a random visitor.</p>
<p>I am not switching the protection off. I am adding the door that was missing.</p>
<p>For now I have checked that the digital doorman does not care about acquaintances. Not even when the owner arrives.</p>

<p><em>Personal experience of the author hardening his own portal. Not a guide to bypassing protections or bulk-downloading other people’s sites.</em></p>
HTML,
        ],
        'cs' => [
            'title' => 'Jak jsem ochránil svůj web před umělou inteligencí. I před tou vlastní.',
            'image_alt' => 'Noční digitální vchod: fialovo-tyrkysová brána blokuje siluety AI agentů i majitele webu před zářícími stránkami článků; bez čitelného textu.',
            'excerpt' => 'Na nefro.polascin.net jsem nasadil ochranu před hromadným stahováním obsahu na trénování AI. Pak jsem pověřil vlastního agenta, aby stáhl mé články na e-knihu. Ochrana fungovala, i proti mně.',
            'content' => <<<'HTML'
<p>Před pár dny jsem na <a href="https://nefro.polascin.net/">nefro.polascin.net</a> nasadil ochranu před automatizovaným stahováním obsahu a před sběrem textů na trénování umělé inteligence. Na portálu zveřejňuji odborné články, věnuji jim čas a nechci, aby si je každý kolemjdoucí robot bez ptaní odnesl ve velkém.</p>
<p>Rozumné rozhodnutí. Aspoň do dnešního rána.</p>
<p>Dnes jsem totiž pověřil AI agenta, aby mi stáhl všechny dosud zveřejněné odborné články. Chtěl jsem z nich připravit elektronickou knihu, tematicky je uspořádat do kapitol, doplnit úvod a obsah a důkladně zkontrolovat odbornou terminologii i slovenštinu. Pracovní název: <em>SK Nefro Báza 1</em>.</p>
<p>Moje články, můj web, můj agent. Co by se mohlo pokazit?</p>
<p>Agent se pustil do stahování a ochrana webu do blokování. Každý plnil jinou část mých pokynů. Agent měl články stáhnout. Bezpečnostní mechanismus měl automatizované stahování zastavit. Na rozdíl ode mě v tom neviděl rozpor. Nezajímalo ho, kdo články napsal ani kdo agenta pověřil. Posuzoval požadavky, ne to, komu web patří.</p>
<p>Pak jsem si chtěl otevřít vlastní web. Místo nefrologické kalkulačky mě přivítalo:</p>
<p><em>„Přístup dočasně pozastaven. Ze zařízení přišlo nepřiměřené množství požadavků. Zkuste to znovu za 38 minut.“</em></p>
<p>Ochrana tedy fungovala. Tak dobře, že jsem se na svůj portál nedostal ani já.</p>
<p>Ve vývojovém prostředí začalo pátrání po příčině. Objevil se soubor <code>bot_guard.php</code>, odpověď <code>403 Forbidden</code> a kontrola pravidel, která omezují počet požadavků. To, co ještě před pár dny vypadalo jako úspěšně nasazená ochrana, bylo najednou předmětem otázky, co mě zablokovalo a jak se dostat zpět.</p>
<p>Nikdo se přitom nechoval neposlušně. Agent dělal, co jsem mu přikázal. Ochrana dělala, co jsem jí přikázal. Jen já jsem si mezitím přikázal dvě věci, které se navzájem vylučují.</p>
<p>Nejdřív: „Nedovol robotům hromadně stahovat mé články.“</p>
<p>O pár dní: „Robote, stáhni mi hromadně mé články.“</p>
<p>Web neměl důvod domýšlet si nevyslovený dodatek: „Ale tento je můj.“</p>
<p>Z dnešního rána zůstává praktická věc. Pokud chci chránit veřejný web před nežádoucím sběrem obsahu a zároveň používat vlastní agenty, musím jim připravit zvláštní, autorizovaný přístup. Například export článků, při kterém se nemusíme tvářit, že můj pomocník je náhodný návštěvník internetu.</p>
<p>Ochranu nevypínám. Doplním dveře, které chyběly.</p>
<p>Zatím mám ověřené, že digitální vrátný nebere ohled na známosti. Ani když přijde majitel.</p>

<p><em>Osobní zkušenost autora se zpevněním vlastního portálu. Není to návod na obcházení ochran ani na hromadné stahování cizích webů.</em></p>
HTML,
        ],
        'de' => [
            'title' => 'Wie ich meine Website vor künstlicher Intelligenz schützte. Auch vor der eigenen.',
            'image_alt' => 'Nächtlicher digitaler Eingang: ein violett-türkises Tor blockiert KI-Agenten-Silhouetten und den Website-Besitzer vor leuchtenden Artikelseiten; kein lesbarer Text.',
            'excerpt' => 'Auf nefro.polascin.net habe ich Schutz vor Massen-Scraping für KI-Training eingeführt. Dann beauftragte ich meinen eigenen Agenten, meine Artikel für ein E-Book zu laden. Der Schutz wirkte, auch gegen mich.',
            'content' => <<<'HTML'
<p>Vor wenigen Tagen habe ich auf <a href="https://nefro.polascin.net/">nefro.polascin.net</a> einen Schutz vor automatisiertem Herunterladen und vor dem Sammeln von Texten für das Training künstlicher Intelligenz eingerichtet. Auf dem Portal veröffentliche ich Fachartikel, stecke Zeit in sie und will nicht, dass jeder vorbeikommende Roboter sie ungefragt in großem Stil mitnimmt.</p>
<p>Eine vernünftige Entscheidung. Zumindest bis heute Morgen.</p>
<p>Heute habe ich nämlich einen KI-Agenten beauftragt, alle bisher veröffentlichten Fachartikel herunterzuladen. Ich wollte daraus ein E-Book machen, sie thematisch in Kapitel ordnen, Einleitung und Inhaltsverzeichnis ergänzen und Fachterminologie sowie Slowakisch gründlich prüfen. Arbeitstitel: <em>SK Nefro Báza 1</em>.</p>
<p>Meine Artikel, meine Website, mein Agent. Was könnte schiefgehen?</p>
<p>Der Agent begann zu laden, der Schutz der Website zu blockieren. Jeder erfüllte einen anderen Teil meiner Anweisungen. Der Agent sollte die Artikel laden. Der Sicherheitsmechanismus sollte automatisiertes Laden anhalten. Anders als ich sah er darin keinen Widerspruch. Es interessierte ihn nicht, wer die Artikel schrieb oder wer den Agenten beauftragte. Er bewertete Anfragen, nicht wem die Website gehört.</p>
<p>Dann wollte ich meine eigene Website öffnen. Statt eines nephrologischen Rechners begrüßte mich:</p>
<p><em>„Zugang vorübergehend ausgesetzt. Von diesem Gerät kamen übermäßig viele Anfragen. Versuchen Sie es in 38 Minuten erneut.“</em></p>
<p>Der Schutz funktionierte also. Sogar so gut, dass selbst ich mein Portal nicht erreichte.</p>
<p>In der Entwicklungsumgebung begann die Suche nach der Ursache. Es tauchte die Datei <code>bot_guard.php</code> auf, dazu die Antwort <code>403 Forbidden</code> und die Regeln, die die Zahl der Anfragen begrenzen. Was wenige Tage zuvor wie ein erfolgreich eingerichteter Schutz aussah, war plötzlich die Frage, was mich gesperrt hatte und wie ich zurückkomme.</p>
<p>Niemand war ungehorsam. Der Agent tat, was ich ihm befahl. Der Schutz tat, was ich ihm befahl. Nur ich hatte mir inzwischen zwei Dinge befohlen, die einander ausschließen.</p>
<p>Zuerst: „Lass Roboter meine Artikel nicht massenhaft herunterladen.“</p>
<p>Wenige Tage später: „Roboter, lade mir meine Artikel massenhaft herunter.“</p>
<p>Die Website hatte keinen Grund, den unausgesprochenen Zusatz zu erfinden: „Aber dieser ist meiner.“</p>
<p>Vom heutigen Morgen bleibt eine praktische Sache. Wenn ich eine öffentliche Website vor unerwünschtem Sammeln schützen und zugleich eigene Agenten nutzen will, muss ich ihnen einen eigenen, autorisierten Zugang geben. Zum Beispiel einen Export der Artikel, bei dem wir nicht so tun müssen, als wäre mein Helfer ein zufälliger Besucher.</p>
<p>Ich schalte den Schutz nicht ab. Ich ergänze die Tür, die gefehlt hat.</p>
<p>Vorerst habe ich geprüft, dass der digitale Türsteher keine Bekanntschaften kennt. Auch nicht, wenn der Besitzer kommt.</p>

<p><em>Persönliche Erfahrung des Autors mit der Härtung des eigenen Portals. Keine Anleitung zum Umgehen von Schutzmechanismen oder zum Massen-Download fremder Websites.</em></p>
HTML,
        ],
        'fr' => [
            'title' => 'Comment j’ai protégé mon site contre l’intelligence artificielle. Y compris la mienne.',
            'image_alt' => 'Entrée numérique nocturne : une porte violet-turquoise bloque des silhouettes d’agents IA et le propriétaire du site devant des pages d’articles lumineuses ; aucun texte lisible.',
            'excerpt' => 'Sur nefro.polascin.net j’ai déployé une protection contre le téléchargement massif pour l’entraînement de l’IA. Puis j’ai chargé mon propre agent de télécharger mes articles pour un ebook. La garde a fonctionné, contre moi aussi.',
            'content' => <<<'HTML'
<p>Il y a quelques jours, j’ai mis en place sur <a href="https://nefro.polascin.net/">nefro.polascin.net</a> une protection contre le téléchargement automatisé et contre la collecte de textes pour l’entraînement de l’intelligence artificielle. Sur le portail je publie des articles spécialisés, j’y consacre du temps, et je ne veux pas que chaque robot de passage les emporte en masse sans demander.</p>
<p>Une décision raisonnable. Du moins jusqu’à ce matin.</p>
<p>Aujourd’hui, j’ai chargé un agent d’IA de me télécharger tous les articles spécialisés publiés jusqu’ici. Je voulais en faire un livre électronique, les ranger par thème en chapitres, ajouter une introduction et une table des matières, et vérifier soigneusement la terminologie spécialisée ainsi que le slovaque. Titre de travail : <em>SK Nefro Báza 1</em>.</p>
<p>Mes articles, mon site, mon agent. Que pouvait-il mal tourner ?</p>
<p>L’agent s’est mis à télécharger, la protection du site à bloquer. Chacun accomplissait une partie différente de mes consignes. L’agent devait télécharger les articles. Le mécanisme de sécurité devait arrêter le téléchargement automatisé. Contrairement à moi, il n’y voyait pas de contradiction. Peu lui importait qui avait écrit les articles ni qui avait mandaté l’agent. Il jugeait les requêtes, pas à qui le site appartient.</p>
<p>Puis j’ai voulu ouvrir mon propre site. Au lieu d’un calculateur de néphrologie, on m’a accueilli ainsi :</p>
<p><em>« Accès temporairement suspendu. Cet appareil a envoyé un nombre excessif de requêtes. Réessayez dans 38 minutes. »</em></p>
<p>La protection fonctionnait donc. Si bien que même moi je n’ai pas pu atteindre mon portail.</p>
<p>Dans l’environnement de développement, la recherche de la cause a commencé. Sont apparus le fichier <code>bot_guard.php</code>, la réponse <code>403 Forbidden</code> et les règles qui limitent le nombre de requêtes. Ce qui, quelques jours plus tôt, avait l’air d’une protection bien en place est devenu la question de ce qui m’avait bloqué, et comment revenir.</p>
<p>Personne ne désobéissait. L’agent faisait ce que je lui avais ordonné. La protection faisait ce que je lui avais ordonné. Seul moi m’étais entre-temps ordonné deux choses qui s’excluent.</p>
<p>D’abord : « N’autorise pas les robots à télécharger mes articles en masse. »</p>
<p>Quelques jours plus tard : « Robot, télécharge-moi mes articles en masse. »</p>
<p>Le site n’avait aucune raison d’inventer l’ajout non dit : « Mais celui-ci est à moi. »</p>
<p>De ce matin il reste une chose pratique. Si je veux protéger un site public contre une collecte indésirable et utiliser en même temps mes propres agents, je dois leur préparer un accès distinct et autorisé. Un export des articles, par exemple, pour ne pas faire semblant que mon assistant est un visiteur au hasard.</p>
<p>Je ne coupe pas la protection. J’ajoute la porte qui manquait.</p>
<p>Pour l’instant j’ai vérifié que le portier numérique ne tient pas compte des connaissances. Même quand le propriétaire arrive.</p>

<p><em>Expérience personnelle de l’auteur sur le durcissement de son propre portail. Ce n’est pas un guide pour contourner les protections ni pour télécharger en masse les sites d’autrui.</em></p>
HTML,
        ],
        'es' => [
            'title' => 'Cómo protegí mi web de la inteligencia artificial. También de la mía.',
            'image_alt' => 'Entrada digital nocturna: una puerta violeta-turquesa bloquea siluetas de agentes de IA y al dueño del sitio ante páginas de artículos luminosas; sin texto legible.',
            'excerpt' => 'En nefro.polascin.net desplegué protección contra la descarga masiva de contenido para entrenar IA. Luego encargué a mi propio agente que bajara mis artículos para un ebook. La guarda funcionó, también contra mí.',
            'content' => <<<'HTML'
<p>Hace unos días puse en <a href="https://nefro.polascin.net/">nefro.polascin.net</a> una protección contra la descarga automatizada y contra la recolección de textos para el entrenamiento de inteligencia artificial. En el portal publico artículos especializados, les dedico tiempo y no quiero que cualquier robot de paso se los lleve en masa sin pedir permiso.</p>
<p>Una decisión razonable. Al menos hasta esta mañana.</p>
<p>Hoy encargué a un agente de IA que me descargara todos los artículos especializados publicados hasta ahora. Quería un libro electrónico, ordenado por temas en capítulos, con introducción e índice, y una revisión a fondo de la terminología especializada y del eslovaco. Título de trabajo: <em>SK Nefro Báza 1</em>.</p>
<p>Mis artículos, mi web, mi agente. ¿Qué podía salir mal?</p>
<p>El agente se puso a descargar y la protección del sitio a bloquear. Cada uno cumplía una parte distinta de mis instrucciones. El agente debía descargar los artículos. El mecanismo de seguridad debía parar la descarga automatizada. A diferencia de mí, no veía contradicción. No le importaba quién escribió los artículos ni quién encargó al agente. Juzgaba peticiones, no a quién pertenece la web.</p>
<p>Luego quise abrir mi propia web. En lugar de una calculadora nefrológica me recibió:</p>
<p><em>«Acceso suspendido temporalmente. Desde este dispositivo llegó un número excesivo de peticiones. Inténtelo de nuevo en 38 minutos.»</em></p>
<p>La protección funcionaba, pues. Tan bien que ni siquiera yo pude llegar a mi portal.</p>
<p>En el entorno de desarrollo empezó la búsqueda de la causa. Apareció el archivo <code>bot_guard.php</code>, la respuesta <code>403 Forbidden</code> y las reglas que limitan el número de peticiones. Lo que unos días antes parecía una protección bien puesta pasó a ser la pregunta de qué me bloqueó y cómo volver.</p>
<p>Nadie desobedecía. El agente hacía lo que le ordené. La protección hacía lo que le ordené. Solo yo me había ordenado entretanto dos cosas que se excluyen.</p>
<p>Primero: «No dejes que los robots descarguen mis artículos en masa.»</p>
<p>Unos días después: «Robot, descárgame mis artículos en masa.»</p>
<p>La web no tenía motivo para inventar el añadido no dicho: «Pero este es mío.»</p>
<p>De esta mañana queda una cosa práctica. Si quiero proteger una web pública del acopio indeseado y a la vez usar mis propios agentes, tengo que prepararles un acceso separado y autorizado. Una exportación de los artículos, por ejemplo, para no fingir que mi ayudante es un visitante al azar.</p>
<p>No apago la protección. Añado la puerta que faltaba.</p>
<p>Por ahora he comprobado que el portero digital no hace favores por amistad. Ni cuando llega el dueño.</p>

<p><em>Experiencia personal del autor endureciendo su propio portal. No es una guía para eludir protecciones ni para descargar en masa webs ajenas.</em></p>
HTML,
        ],
        'pl' => [
            'title' => 'Jak ochroniłem swoją stronę przed sztuczną inteligencją. Także przed własną.',
            'image_alt' => 'Nocne cyfrowe wejście: fioletowo-turkusowa brama blokuje sylwetki agentów AI i właściciela strony przed świecącymi stronami artykułów; bez czytelnego tekstu.',
            'excerpt' => 'Na nefro.polascin.net wdrożyłem ochronę przed masowym pobieraniem treści do trenowania AI. Potem zleciłem własnemu agentowi pobranie moich artykułów na e-book. Ochrona zadziałała, także przeciwko mnie.',
            'content' => <<<'HTML'
<p>Kilka dni temu wdrożyłem na <a href="https://nefro.polascin.net/">nefro.polascin.net</a> ochronę przed automatycznym pobieraniem treści i przed zbieraniem tekstów do trenowania sztucznej inteligencji. Na portalu publikuję artykuły specjalistyczne, poświęcam im czas i nie chcę, by każdy mijający robot zabierał je masowo bez pytania.</p>
<p>Rozsądna decyzja. Przynajmniej do dzisiejszego rana.</p>
<p>Dziś zleciłem agentowi AI, by pobrał wszystkie dotychczas opublikowane artykuły specjalistyczne. Chciałem z nich e-book, ułożony tematycznie w rozdziały, ze wstępem i spisem treści, i dokładne sprawdzenie terminologii specjalistycznej oraz słowackiego. Tytuł roboczy: <em>SK Nefro Báza 1</em>.</p>
<p>Moje artykuły, moja strona, mój agent. Co mogło pójść nie tak?</p>
<p>Agent zabrał się do pobierania, ochrona strony do blokowania. Każdy wykonywał inną część moich poleceń. Agent miał pobrać artykuły. Mechanizm bezpieczeństwa miał zatrzymać automatyczne pobieranie. W przeciwieństwie do mnie nie widział w tym sprzeczności. Nie obchodziło go, kto napisał artykuły ani kto zlecił agentowi. Oceniał żądania, nie to, do kogo strona należy.</p>
<p>Potem chciałem otworzyć własną stronę. Zamiast kalkulatora nefrologicznego powitało mnie:</p>
<p><em>„Dostęp tymczasowo zawieszony. Z urządzenia nadeszła nadmierna liczba żądań. Spróbuj ponownie za 38 minut.”</em></p>
<p>Ochrona więc działała. Tak dobrze, że nawet ja nie dostałem się na swój portal.</p>
<p>W środowisku deweloperskim zaczęło się szukanie przyczyny. Pojawił się plik <code>bot_guard.php</code>, odpowiedź <code>403 Forbidden</code> i reguły, które ograniczają liczbę żądań. To, co kilka dni wcześniej wyglądało na skutecznie wdrożoną ochronę, stało się pytaniem, co mnie zablokowało i jak wrócić.</p>
<p>Nikt nie był nieposłuszny. Agent robił, co mu kazałem. Ochrona robiła, co jej kazałem. Tylko ja w międzyczasie kazałem sobie dwie rzeczy, które się wzajemnie wykluczają.</p>
<p>Najpierw: „Nie pozwalaj robotom masowo pobierać moich artykułów.”</p>
<p>Kilka dni później: „Robocie, pobierz mi masowo moje artykuły.”</p>
<p>Strona nie miała powodu wymyślać niewypowiedzianego dodatku: „Ale ten jest mój.”</p>
<p>Z dzisiejszego rana zostaje praktyczna rzecz. Jeśli chcę chronić publiczną stronę przed niepożądanym zbieraniem treści i zarazem używać własnych agentów, muszę przygotować im osobny, autoryzowany dostęp. Na przykład eksport artykułów, przy którym nie trzeba udawać, że mój pomocnik jest przypadkowym gościem.</p>
<p>Ochrony nie wyłączam. Dodaję drzwi, których brakowało.</p>
<p>Na razie sprawdziłem, że cyfrowy portier nie bierze pod uwagę znajomości. Nawet gdy przychodzi właściciel.</p>

<p><em>Osobiste doświadczenie autora ze wzmocnieniem własnego portalu. To nie jest przewodnik po omijaniu zabezpieczeń ani po masowym pobieraniu cudzych stron.</em></p>
HTML,
        ],
        'hu' => [
            'title' => 'Hogyan védtem meg a webemet a mesterséges intelligenciától. A sajátomtól is.',
            'image_alt' => 'Éjszakai digitális bejárat: lila-türkiz kapu blokkolja az AI-ügynök sziluetteket és a web tulajdonosát a fényes cikkoldalak előtt; nincs olvasható szöveg.',
            'excerpt' => 'A nefro.polascin.net-en védelmet vezettem be a tartalom tömeges letöltése ellen az AI-tréninghez. Aztán saját ügynökömet bíztam meg, hogy töltse le a cikkeimet e-könyvhöz. A védelem működött, ellenem is.',
            'content' => <<<'HTML'
<p>Néhány napja a <a href="https://nefro.polascin.net/">nefro.polascin.net</a>-en védelmet vezettem be a tartalom automatizált letöltése és a szövegek mesterségesintelligencia-tréninghez való gyűjtése ellen. A portálon szakcikkeket teszek közzé, időt fordítok rájuk, és nem akarom, hogy minden arra járó robot kérdezés nélkül nagyban elvigye őket.</p>
<p>Ésszerű döntés. Legalábbis a mai reggelig.</p>
<p>Ma megbíztam egy AI-ügynököt, hogy töltse le az összes eddig közzétett szakcikket. E-könyvet akartam belőlük, tematikus fejezetekbe rendezve, bevezetővel és tartalomjegyzékkel, és alapos ellenőrzést a szakterminológián és a szlovákon. Munkacím: <em>SK Nefro Báza 1</em>.</p>
<p>Az én cikkeim, az én webem, az én ügynököm. Mi romolhatna el?</p>
<p>Az ügynök letöltésbe fogott, a web védelme blokkolásba. Mindketten az utasításaim más-más részét teljesítették. Az ügynöknek le kellett töltenie a cikkeket. A biztonsági mechanizmusnak meg kellett állítania az automatizált letöltést. Velem ellentétben nem látott ebben ellentmondást. Nem érdekelte, ki írta a cikkeket, sem az, ki bízta meg az ügynököt. Kéréseket ítélt, nem azt, kié a web.</p>
<p>Aztán meg akartam nyitni a saját webemet. Nephrológiai kalkulátor helyett ez fogadott:</p>
<p><em>„A hozzáférés ideiglenesen felfüggesztve. Az eszközről aránytalanul sok kérés érkezett. Próbálja újra 38 perc múlva.”</em></p>
<p>A védelem tehát működött. Annyira jól, hogy még én sem jutottam be a saját portálomra.</p>
<p>A fejlesztői környezetben elkezdődött az ok keresése. Felbukkant a <code>bot_guard.php</code> fájl, a <code>403 Forbidden</code> válasz és a szabályok, amelyek a kérések számát korlátozzák. Ami néhány napja sikeresen bevezetett védelemnek látszott, hirtelen az a kérdés lett, mi zárt ki, és hogyan jutok vissza.</p>
<p>Senki sem volt engedetlen. Az ügynök azt tette, amit megparancsoltam. A védelem azt tette, amit megparancsoltam. Csak én parancsoltam magamnak közben két egymást kizáró dolgot.</p>
<p>Először: „Ne engedd, hogy robotok tömegesen letöltsék a cikkeimet.”</p>
<p>Néhány nap múlva: „Robot, töltsd le tömegesen a cikkeimet.”</p>
<p>A webnek nem volt oka kitalálni a ki nem mondott toldalékot: „De ez az enyém.”</p>
<p>A mai reggelből egy gyakorlati dolog marad. Ha nyilvános webet akarok védeni a nemkívánatos gyűjtés ellen, és közben saját ügynököket akarok használni, külön, jogosított hozzáférést kell készítenem nekik. Például cikkexportot, ahol nem kell úgy tennünk, mintha a segítőm véletlen látogató volna.</p>
<p>A védelmet nem kapcsolom ki. Pótlom az ajtót, amely hiányzott.</p>
<p>Egyelőre ellenőriztem, hogy a digitális kapus nem nézi az ismeretséget. Még akkor sem, ha a tulajdonos jön.</p>

<p><em>A szerző személyes tapasztalata a saját portáljának megerősítéséről. Nem útmutató védelmek megkerüléséhez vagy idegen webek tömeges letöltéséhez.</em></p>
HTML,
        ],
        'it' => [
            'title' => 'Come ho protetto il mio sito dall’intelligenza artificiale. Anche dalla mia.',
            'image_alt' => 'Ingresso digitale notturno: un cancello viola-turchese blocca silhouettes di agenti IA e il proprietario del sito davanti a pagine di articoli luminose; nessun testo leggibile.',
            'excerpt' => 'Su nefro.polascin.net ho messo una protezione contro il download massivo di contenuti per l’addestramento dell’IA. Poi ho incaricato il mio agente di scaricare i miei articoli per un ebook. La guardia ha funzionato, anche contro di me.',
            'content' => <<<'HTML'
<p>Qualche giorno fa ho messo su <a href="https://nefro.polascin.net/">nefro.polascin.net</a> una protezione contro il download automatizzato e contro la raccolta di testi per l’addestramento dell’intelligenza artificiale. Sul portale pubblico articoli specialistici, ci metto tempo e non voglio che ogni robot di passaggio se li porti via in massa senza chiedere.</p>
<p>Una decisione ragionevole. Almeno fino a stamattina.</p>
<p>Oggi ho incaricato un agente IA di scaricarmi tutti gli articoli specialistici pubblicati finora. Volevo un ebook, ordinato per temi in capitoli, con introduzione e indice, e un controllo attento della terminologia specialistica e dello slovacco. Titolo di lavoro: <em>SK Nefro Báza 1</em>.</p>
<p>I miei articoli, il mio sito, il mio agente. Cosa poteva andare storto?</p>
<p>L’agente si è messo a scaricare, la protezione del sito a bloccare. Ciascuno eseguiva una parte diversa delle mie istruzioni. L’agente doveva scaricare gli articoli. Il meccanismo di sicurezza doveva fermare il download automatizzato. A differenza di me, non vedeva contraddizione. Non gli importava chi avesse scritto gli articoli né chi avesse incaricato l’agente. Valutava le richieste, non di chi è il sito.</p>
<p>Poi ho voluto aprire il mio sito. Al posto di un calcolatore di nefrologia mi ha accolto:</p>
<p><em>«Accesso temporaneamente sospeso. Da questo dispositivo è arrivato un numero eccessivo di richieste. Riprova tra 38 minuti.»</em></p>
<p>La protezione funzionava, dunque. Così bene che nemmeno io riuscivo a raggiungere il mio portale.</p>
<p>Nell’ambiente di sviluppo è iniziata la ricerca della causa. È emerso il file <code>bot_guard.php</code>, la risposta <code>403 Forbidden</code> e le regole che limitano il numero di richieste. Ciò che pochi giorni prima sembrava una protezione ben messa è diventato la domanda di che cosa mi avesse bloccato e come rientrare.</p>
<p>Nessuno disobbediva. L’agente faceva ciò che gli avevo ordinato. La protezione faceva ciò che le avevo ordinato. Solo io nel frattempo mi ero ordinato due cose che si escludono.</p>
<p>Prima: «Non permettere ai robot di scaricare in massa i miei articoli.»</p>
<p>Pochi giorni dopo: «Robot, scaricami in massa i miei articoli.»</p>
<p>Il sito non aveva motivo di inventare l’aggiunta non detta: «Ma questo è mio.»</p>
<p>Da stamattina resta una cosa pratica. Se voglio proteggere un sito pubblico dalla raccolta indesiderata e al tempo stesso usare i miei agenti, devo preparare loro un accesso separato e autorizzato. Un export degli articoli, per esempio, così non dobbiamo fingere che il mio aiutante sia un visitatore a caso.</p>
<p>Non spengo la protezione. Aggiungo la porta che mancava.</p>
<p>Per ora ho verificato che il portiere digitale non tiene conto delle conoscenze. Nemmeno quando arriva il proprietario.</p>

<p><em>Esperienza personale dell’autore sul rafforzamento del proprio portale. Non è una guida per aggirare le protezioni né per scaricare in massa siti altrui.</em></p>
HTML,
        ],
        'uk' => [
            'title' => 'Як я захистив свій сайт від штучного інтелекту. І від власного теж.',
            'image_alt' => 'Нічний цифровий вхід: фіолетово-бірюзова брама блокує силуети AI-агентів і власника сайту перед сяючими сторінками статей; без читабельного тексту.',
            'excerpt' => 'На nefro.polascin.net я впровадив захист від масового звантаження контенту для тренування ШІ. Потім доручив власному агенту звантажити мої статті для е-книги. Захист спрацював, і проти мене.',
            'content' => <<<'HTML'
<p>Кілька днів тому на <a href="https://nefro.polascin.net/">nefro.polascin.net</a> я впровадив захист від автоматизованого звантаження контенту і від збору текстів для тренування штучного інтелекту. На порталі публікую фахові статті, витрачаю на них час і не хочу, щоб кожен побіжний робот без дозволу забирав їх масово.</p>
<p>Розумне рішення. Принаймні до сьогоднішнього ранку.</p>
<p>Сьогодні я доручив AI-агенту звантажити всі досі опубліковані фахові статті. Хотів електронну книгу, тематично розкладену на розділи, зі вступом і змістом, і ретельну перевірку фахової термінології та словацької. Робоча назва: <em>SK Nefro Báza 1</em>.</p>
<p>Мої статті, мій сайт, мій агент. Що могло піти не так?</p>
<p>Агент узявся звантажувати, захист сайту блокувати. Кожен виконував іншу частину моїх вказівок. Агент мав звантажити статті. Механізм безпеки мав зупинити автоматизоване звантаження. На відміну від мене, він не бачив у цьому суперечності. Йому було байдуже, хто написав статті і хто доручив агенту. Він оцінював запити, а не те, чий це сайт.</p>
<p>Потім я захотів відкрити власний сайт. Замість нефрологічного калькулятора мене зустріло:</p>
<p><em>«Доступ тимчасово призупинено. З пристрою надійшла надмірна кількість запитів. Спробуйте знову за 38 хвилин.»</em></p>
<p>Отже, захист спрацював. Настільки добре, що навіть я не потрапив на свій портал.</p>
<p>У середовищі розробки почався пошук причини. З’явився файл <code>bot_guard.php</code>, відповідь <code>403 Forbidden</code> і правила, які обмежують кількість запитів. Те, що кілька днів тому виглядало як успішно впроваджений захист, стало питанням, що мене заблокувало і як повернутися.</p>
<p>Ніхто не був непокірний. Агент робив те, що я йому наказав. Захист робив те, що я йому наказав. Лише я тим часом наказав собі дві речі, які взаємно виключаються.</p>
<p>Спочатку: «Не дозволяй роботам масово звантажувати мої статті.»</p>
<p>За кілька днів: «Роботе, звантаж мені масово мої статті.»</p>
<p>Сайт не мав підстав вигадувати недоговорену додатку: «Але цей є моїм.»</p>
<p>З сьогоднішнього ранку лишається практична річ. Якщо хочу захищати публічний сайт від небажаного збору і водночас користуватися власними агентами, мушу підготувати їм окремий, авторизований доступ. Наприклад експорт статей, де не треба вдавати, що мій помічник є випадковим відвідувачем.</p>
<p>Захист не вимикаю. Додаю двері, яких бракувало.</p>
<p>Поки що перевірив, що цифровий швейцар не зважає на знайомства. Навіть коли приходить власник.</p>

<p><em>Особистий досвід автора зі зміцнення власного порталу. Це не інструкція з обходу захистів і не з масового звантаження чужих сайтів.</em></p>
HTML,
        ],
    ],
];
