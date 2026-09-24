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
 * Authority príspevok: Cloudflare Disallow AI Training / Search·Training·Agent.
 * Zdroj: Cloudflare email 16. 9. 2026 „Updates to managing AI crawlers“;
 * overené proti blog.cloudflare.com/accountable-mixed-use-ai-crawlers
 * a developers.cloudflare.com/bots/additional-configurations/block-ai-bots (15. 9. 2026).
 */
return [
    'slug' => 'cloudflare-zakaz-ai-trenovania',
    'author' => 'MUDr. Ľubomír Polaščín',
    'category' => 'blog',
    'is_top' => 0,
    'published_at' => '2026-09-24 17:30:00',
    'image' => 'images/articles/cloudflare-zakaz-ai-trenovania.webp',
    'translations' => [
        'sk' => [
            'title' => 'Cloudflare nahradil „Block AI Bots“ nastavením „Disallow AI Training“. Ak publikujete online, pozrite si to.',
            'image_alt' => 'Nočný stôl vydavateľa: notebook so siluetou webu a fialovo-tyrkysový štít svetla, ktorý prepúšťa iba úzky lúč vyhľadávania a blokuje tiene crawlerov.',
            'excerpt' => 'Od 15. septembra 2026 Cloudflare posúva ovládanie AI crawlerov z binárneho blokovania na granulárne Search, Training a Agent. Odporúčané „Disallow AI Training“ nechá indexáciu vyhľadávačov a odmietne trénovanie modelov.',
            'content' => <<<'HTML'
<p>Cloudflare tento mesiac ukončil éru jednoduchého prepínača „Block AI Bots“. Ak publikujete čokoľvek online, potrebujete vedieť, čo ho nahradilo.</p>
<p>Posledný rok bol default jednoduchý: zablokovať AI crawlerov. Nepustiť GPTBot, ClaudeBot ani tréningové boty, aby zoškrabávali obsah.</p>
<p>Od 15.&nbsp;septembra&nbsp;2026 Cloudflare posunul odporúčané nastavenie k <strong>Disallow AI Training</strong>. Vyhľadávače môžu stránky indexovať kvôli objaviteľnosti. Nemajú však používať obsah na trénovanie modelov. Starší prepínač „Block AI Bots“ Cloudflare <a href="https://developers.cloudflare.com/bots/additional-configurations/block-ai-bots/">postupne nahrádza</a> granulárnymi politikami Search, Training a Agent — a pre zmiešané crawlerov (Googlebot, Applebot, Bingbot) zaviedol jemný rozdiel medzi <em>Block</em> a <em>Disallow</em>.</p>
<p>Tento rozdiel je dôležitejší, než znie.</p>
<p>Indexácia do vyhľadávania znamená, že niekto váš článok nájde. Trénovanie znamená, že AI model sa z neho učí a môže reprodukovať jeho podstatu — bez toho, aby vám poslal čitateľa. Podľa Cloudflare blogu <a href="https://blog.cloudflare.com/accountable-mixed-use-ai-crawlers/">Have it both ways</a> nastavenie Disallow AI Training zapisuje preferenciu „no training“ do robots.txt a pri zodpovedných (Accountable) zmiešaných crawleroch — Google, Apple, Microsoft — ponecháva indexáciu pre search. Úplný <em>Block</em> Training by ich mohol odstrihnúť aj od vyhľadávania.</p>
<p>Pre vydavateľov je to skutočné napätie. Chcem, aby Google indexoval nefrologický portál <a href="https://nefro.polascin.net/">nefro.polascin.net</a>, aby pacienti našli informácie. Nechcem, aby AI model články „prehltol“ a odpovedal pacientovi priamo — s obchádzkou môjho webu.</p>
<p>Nové ovládače sú granulárne: <strong>Search</strong>, <strong>Training</strong> a <strong>Agent</strong>. Môžete povoliť indexáciu a zároveň odmietnuť trénovanie. Môžete nechať agentov stiahnuť stránku pre konkrétny používateľský dopyt a zabrániť hromadnému zoškrabávaniu.</p>
<p>Spravujem 14 webových properties. Pacientské portály, produktové weby, katalóg kníh. Každá má iný vzťah k AI crawlerom. Edukačný portál chce maximálny dosah. Produktový web — napríklad <a href="https://nephroctor.com/">nephroctor.com</a> alebo <a href="https://arenibus.polascin.net/">arenibus.polascin.net</a> — nemusí kŕmiť model konkurencie. Katalóg <a href="https://books.polascin.net/">books.polascin.net</a> zase potrebuje objaviteľnosť, nie voľný tréningový materiál.</p>
<p>Starý prepínač bol binárny. Nový je chirurgický.</p>
<p>Ak máte web na Cloudflare a od septembrovej aktualizácie ste AI crawler settings nekontrolovali, je čas to urobiť. Ak chcete prejsť konkrétne zóny so mnou, napíšte cez <a href="contact.php">kontakt</a>.</p>
HTML,
        ],
        'en' => [
            'title' => 'Cloudflare replaced “Block AI Bots” with “Disallow AI Training.” If you publish online, check it.',
            'image_alt' => 'A publisher’s desk at night: a laptop with a website silhouette and a purple-teal shield of light that lets only a narrow search beam through while blocking shadowy crawlers.',
            'excerpt' => 'As of 15 September 2026, Cloudflare moves AI crawler control from a binary block to granular Search, Training, and Agent. The recommended “Disallow AI Training” keeps search indexing while refusing model training.',
            'content' => <<<'HTML'
<p>Cloudflare ended the era of the simple “Block AI Bots” switch this month. If you publish anything online, you need to know what replaced it.</p>
<p>For the past year the default was simple: block AI crawlers. Do not let GPTBot, ClaudeBot, or training bots scrape your content.</p>
<p>As of 15&nbsp;September&nbsp;2026 Cloudflare shifted the recommended setting toward <strong>Disallow AI Training</strong>. Search engines can still index your pages for discovery. They should not use your content to train models. Cloudflare is <a href="https://developers.cloudflare.com/bots/additional-configurations/block-ai-bots/">gradually replacing</a> the older “Block AI Bots” switch with granular Search, Training, and Agent policies — and for mixed-use crawlers (Googlebot, Applebot, Bingbot) it introduced a fine distinction between <em>Block</em> and <em>Disallow</em>.</p>
<p>That distinction matters more than it sounds.</p>
<p>Search indexing means someone finds your article. Training means an AI model learns from it and can reproduce its substance — without ever sending you a reader. According to Cloudflare’s <a href="https://blog.cloudflare.com/accountable-mixed-use-ai-crawlers/">Have it both ways</a> post, Disallow AI Training writes a “no training” preference into robots.txt and, for accountable mixed-use crawlers — Google, Apple, Microsoft — still allows search indexing. A full Training <em>Block</em> could cut them off from search as well.</p>
<p>For publishers, this is the real tension. I want Google to index the nephrology portal <a href="https://nefro.polascin.net/">nefro.polascin.net</a> so patients find information. I do not want an AI model to ingest the articles and answer the patient directly — bypassing my site entirely.</p>
<p>The new controls are granular: <strong>Search</strong>, <strong>Training</strong>, and <strong>Agent</strong>. You can allow indexing while refusing training. You can let agents fetch a page for a specific user query while preventing bulk scraping.</p>
<p>I manage 14 web properties. Patient portals, product sites, a book catalog. Each has a different relationship with AI crawlers. An education portal wants maximum reach. A product site — for example <a href="https://nephroctor.com/">nephroctor.com</a> or <a href="https://arenibus.polascin.net/">arenibus.polascin.net</a> — does not need to feed a competitor’s model. The catalog <a href="https://books.polascin.net/">books.polascin.net</a> needs discoverability, not free training material.</p>
<p>The old switch was binary. The new one is surgical.</p>
<p>If you run a site on Cloudflare and have not checked your AI crawler settings since the September update, now is the time. If you want to walk specific zones with me, write via the <a href="contact.php">contact form</a>.</p>
HTML,
        ],
        'cs' => [
            'title' => 'Cloudflare nahradil „Block AI Bots“ nastavením „Disallow AI Training“. Pokud publikujete online, podívejte se na to.',
            'image_alt' => 'Noční stůl vydavatele: notebook se siluetou webu a fialovo-tyrkysový štít světla, který propouští jen úzký paprsek vyhledávání a blokuje stíny crawlerů.',
            'excerpt' => 'Od 15. září 2026 Cloudflare posouvá ovládání AI crawlerů z binárního blokování na granulární Search, Training a Agent. Doporučené „Disallow AI Training“ nechá indexaci vyhledávačů a odmítne trénování modelů.',
            'content' => <<<'HTML'
<p>Cloudflare tento měsíc ukončil éru jednoduchého přepínače „Block AI Bots“. Pokud publikujete cokoli online, potřebujete vědět, co ho nahradilo.</p>
<p>Poslední rok byl default jednoduchý: zablokovat AI crawlery. Nepustit GPTBot, ClaudeBot ani tréninkové boty, aby oškrabávaly obsah.</p>
<p>Od 15.&nbsp;září&nbsp;2026 Cloudflare posunul doporučené nastavení k <strong>Disallow AI Training</strong>. Vyhledávače mohou stránky indexovat kvůli objevitelnosti. Nemají však používat obsah k trénování modelů. Starší přepínač „Block AI Bots“ Cloudflare <a href="https://developers.cloudflare.com/bots/additional-configurations/block-ai-bots/">postupně nahrazuje</a> granulárními politikami Search, Training a Agent — a pro smíšené crawlery (Googlebot, Applebot, Bingbot) zavedl jemný rozdíl mezi <em>Block</em> a <em>Disallow</em>.</p>
<p>Tento rozdíl je důležitější, než zní.</p>
<p>Indexace do vyhledávání znamená, že někdo váš článek najde. Trénování znamená, že AI model se z něj učí a může reprodukovat jeho podstatu — aniž by vám poslal čtenáře. Podle Cloudflare blogu <a href="https://blog.cloudflare.com/accountable-mixed-use-ai-crawlers/">Have it both ways</a> nastavení Disallow AI Training zapisuje preferenci „no training“ do robots.txt a u odpovědných (Accountable) smíšených crawlerů — Google, Apple, Microsoft — ponechává indexaci pro search. Úplný <em>Block</em> Training by je mohl odříznout i od vyhledávání.</p>
<p>Pro vydavatele je to skutečné napětí. Chci, aby Google indexoval nefrologický portál <a href="https://nefro.polascin.net/">nefro.polascin.net</a>, aby pacienti našli informace. Nechci, aby AI model články „spolkl“ a odpověděl pacientovi přímo — s obejitím mého webu.</p>
<p>Nové ovladače jsou granulární: <strong>Search</strong>, <strong>Training</strong> a <strong>Agent</strong>. Můžete povolit indexaci a zároveň odmítnout trénování. Můžete nechat agenty stáhnout stránku pro konkrétní uživatelský dotaz a zabránit hromadnému oškrabávání.</p>
<p>Spravuji 14 webových properties. Pacientské portály, produktové weby, katalog knih. Každá má jiný vztah k AI crawlerům. Edukační portál chce maximální dosah. Produktový web — například <a href="https://nephroctor.com/">nephroctor.com</a> nebo <a href="https://arenibus.polascin.net/">arenibus.polascin.net</a> — nemusí krmit model konkurence. Katalog <a href="https://books.polascin.net/">books.polascin.net</a> zase potřebuje objevitelnost, ne volný tréninkový materiál.</p>
<p>Starý přepínač byl binární. Nový je chirurgický.</p>
<p>Pokud máte web na Cloudflare a od zářijové aktualizace jste AI crawler settings nekontrolovali, je čas to udělat. Pokud chcete projít konkrétní zóny se mnou, napište přes <a href="contact.php">kontakt</a>.</p>
HTML,
        ],
        'de' => [
            'title' => 'Cloudflare ersetzt „Block AI Bots“ durch „Disallow AI Training“. Wenn Sie online publizieren, prüfen Sie das.',
            'image_alt' => 'Nachtischer Schreibtisch eines Verlegers: Laptop mit Website-Silhouette und ein violett-türkiser Lichtschild, der nur einen schmalen Suchstrahl durchlässt und schattenhafte Crawler blockiert.',
            'excerpt' => 'Ab dem 15. September 2026 verschiebt Cloudflare die Steuerung von KI-Crawlern vom binären Blockieren zu granularem Search, Training und Agent. Das empfohlene „Disallow AI Training“ lässt die Suchindexierung zu und verweigert das Modelltraining.',
            'content' => <<<'HTML'
<p>Cloudflare hat diesen Monat die Ära des einfachen Schalters „Block AI Bots“ beendet. Wenn Sie irgendetwas online publizieren, müssen Sie wissen, was ihn ersetzt hat.</p>
<p>Im vergangenen Jahr war der Default einfach: KI-Crawler blockieren. GPTBot, ClaudeBot und Trainingsbots nicht an den Inhalt lassen.</p>
<p>Seit dem 15.&nbsp;September&nbsp;2026 hat Cloudflare die empfohlene Einstellung zu <strong>Disallow AI Training</strong> verschoben. Suchmaschinen dürfen Seiten weiterhin für die Auffindbarkeit indexieren. Sie sollen den Inhalt jedoch nicht zum Trainieren von Modellen nutzen. Den älteren Schalter „Block AI Bots“ <a href="https://developers.cloudflare.com/bots/additional-configurations/block-ai-bots/">ersetzt Cloudflare schrittweise</a> durch granulare Search-, Training- und Agent-Richtlinien — und für gemischte Crawler (Googlebot, Applebot, Bingbot) führt es einen feinen Unterschied zwischen <em>Block</em> und <em>Disallow</em> ein.</p>
<p>Dieser Unterschied wiegt mehr, als er klingt.</p>
<p>Suchindexierung heißt: jemand findet Ihren Artikel. Training heißt: ein KI-Modell lernt daraus und kann den Kern reproduzieren — ohne Ihnen einen Leser zu schicken. Laut Cloudflare-Blog <a href="https://blog.cloudflare.com/accountable-mixed-use-ai-crawlers/">Have it both ways</a> schreibt Disallow AI Training eine „no training“-Präferenz in robots.txt und lässt bei verantwortlichen (Accountable) gemischten Crawlern — Google, Apple, Microsoft — die Indexierung für die Suche zu. Ein vollständiger Training-<em>Block</em> könnte sie auch von der Suche abschneiden.</p>
<p>Für Verleger ist das die echte Spannung. Ich will, dass Google das Nephrologie-Portal <a href="https://nefro.polascin.net/">nefro.polascin.net</a> indexiert, damit Patienten Informationen finden. Ich will nicht, dass ein KI-Modell die Artikel „verschluckt“ und dem Patienten direkt antwortet — unter Umgehung meiner Website.</p>
<p>Die neuen Steuerungen sind granular: <strong>Search</strong>, <strong>Training</strong> und <strong>Agent</strong>. Sie können Indexierung erlauben und Training zugleich verweigern. Sie können Agenten eine Seite für eine konkrete Nutzeranfrage abrufen lassen und Massen-Scraping verhindern.</p>
<p>Ich verwalte 14 Web-Properties. Patientenportale, Produktseiten, einen Bücherkatalog. Jede hat ein anderes Verhältnis zu KI-Crawlern. Ein Bildungsportal will maximale Reichweite. Eine Produktseite — etwa <a href="https://nephroctor.com/">nephroctor.com</a> oder <a href="https://arenibus.polascin.net/">arenibus.polascin.net</a> — muss kein Konkurrenzmodell füttern. Der Katalog <a href="https://books.polascin.net/">books.polascin.net</a> braucht Auffindbarkeit, kein freies Trainingsmaterial.</p>
<p>Der alte Schalter war binär. Der neue ist chirurgisch.</p>
<p>Wenn Sie eine Website auf Cloudflare betreiben und die AI-Crawler-Einstellungen seit dem September-Update nicht geprüft haben, ist jetzt der Moment. Wenn Sie konkrete Zonen mit mir durchgehen wollen, schreiben Sie über das <a href="contact.php">Kontaktformular</a>.</p>
HTML,
        ],
        'fr' => [
            'title' => 'Cloudflare remplace « Block AI Bots » par « Disallow AI Training ». Si vous publiez en ligne, vérifiez cela.',
            'image_alt' => 'Bureau d’éditeur la nuit : un ordinateur portable avec la silhouette d’un site et un bouclier de lumière violet-turquoise qui ne laisse passer qu’un étroit faisceau de recherche tout en bloquant des crawlers ombreux.',
            'excerpt' => 'Depuis le 15 septembre 2026, Cloudflare passe du blocage binaire des crawlers d’IA au contrôle granulaire Search, Training et Agent. Le « Disallow AI Training » recommandé conserve l’indexation pour la recherche et refuse l’entraînement des modèles.',
            'content' => <<<'HTML'
<p>Cloudflare a mis fin ce mois-ci à l’ère du simple commutateur « Block AI Bots ». Si vous publiez quoi que ce soit en ligne, vous devez savoir ce qui l’a remplacé.</p>
<p>L’année dernière, le défaut était simple : bloquer les crawlers d’IA. Ne pas laisser GPTBot, ClaudeBot ni les bots d’entraînement racler le contenu.</p>
<p>Depuis le 15&nbsp;septembre&nbsp;2026, Cloudflare a déplacé le réglage recommandé vers <strong>Disallow AI Training</strong>. Les moteurs de recherche peuvent encore indexer les pages pour la découvrabilité. Ils ne doivent pas utiliser le contenu pour entraîner des modèles. Cloudflare <a href="https://developers.cloudflare.com/bots/additional-configurations/block-ai-bots/">remplace progressivement</a> l’ancien commutateur « Block AI Bots » par des politiques granulaires Search, Training et Agent — et pour les crawlers à usage mixte (Googlebot, Applebot, Bingbot) introduit une distinction fine entre <em>Block</em> et <em>Disallow</em>.</p>
<p>Cette distinction compte plus qu’il n’y paraît.</p>
<p>L’indexation pour la recherche signifie que quelqu’un trouve votre article. L’entraînement signifie qu’un modèle d’IA en apprend et peut en reproduire la substance — sans jamais vous envoyer de lecteur. Selon le billet Cloudflare <a href="https://blog.cloudflare.com/accountable-mixed-use-ai-crawlers/">Have it both ways</a>, Disallow AI Training inscrit une préférence « no training » dans robots.txt et, pour les crawlers mixtes responsables (Accountable) — Google, Apple, Microsoft — laisse l’indexation pour la recherche. Un <em>Block</em> Training complet pourrait aussi les couper de la recherche.</p>
<p>Pour les éditeurs, c’est la vraie tension. Je veux que Google indexe le portail de néphrologie <a href="https://nefro.polascin.net/">nefro.polascin.net</a> pour que les patients trouvent l’information. Je ne veux pas qu’un modèle d’IA « avale » les articles et réponde au patient directement — en contournant mon site.</p>
<p>Les nouveaux contrôles sont granulaires : <strong>Search</strong>, <strong>Training</strong> et <strong>Agent</strong>. Vous pouvez autoriser l’indexation tout en refusant l’entraînement. Vous pouvez laisser des agents récupérer une page pour une requête utilisateur précise tout en empêchant le raclage massif.</p>
<p>Je gère 14 propriétés web. Portails patients, sites produit, un catalogue de livres. Chacune a un rapport différent aux crawlers d’IA. Un portail éducatif veut une portée maximale. Un site produit — par exemple <a href="https://nephroctor.com/">nephroctor.com</a> ou <a href="https://arenibus.polascin.net/">arenibus.polascin.net</a> — n’a pas besoin de nourrir le modèle d’un concurrent. Le catalogue <a href="https://books.polascin.net/">books.polascin.net</a> a besoin de découvrabilité, pas de matériel d’entraînement libre.</p>
<p>L’ancien commutateur était binaire. Le nouveau est chirurgical.</p>
<p>Si vous avez un site sur Cloudflare et n’avez pas vérifié les réglages AI crawler depuis la mise à jour de septembre, c’est le moment. Pour passer des zones concrètes avec moi, écrivez via le <a href="contact.php">formulaire de contact</a>.</p>
HTML,
        ],
        'es' => [
            'title' => 'Cloudflare sustituyó «Block AI Bots» por «Disallow AI Training». Si publica en línea, revíselo.',
            'image_alt' => 'Escritorio de un editor de noche: un portátil con la silueta de un sitio y un escudo de luz púrpura-turquesa que solo deja pasar un estrecho haz de búsqueda mientras bloquea crawlers en sombra.',
            'excerpt' => 'Desde el 15 de septiembre de 2026, Cloudflare pasa del bloqueo binario de crawlers de IA al control granular Search, Training y Agent. El «Disallow AI Training» recomendado mantiene la indexación de búsqueda y rechaza el entrenamiento de modelos.',
            'content' => <<<'HTML'
<p>Cloudflare puso fin este mes a la era del simple interruptor «Block AI Bots». Si publica cualquier cosa en línea, necesita saber qué lo sustituyó.</p>
<p>El último año el valor por defecto era simple: bloquear crawlers de IA. No dejar que GPTBot, ClaudeBot ni bots de entrenamiento raspen el contenido.</p>
<p>Desde el 15&nbsp;de&nbsp;septiembre&nbsp;de&nbsp;2026 Cloudflare desplazó el ajuste recomendado hacia <strong>Disallow AI Training</strong>. Los buscadores aún pueden indexar páginas para el descubrimiento. No deben usar el contenido para entrenar modelos. Cloudflare <a href="https://developers.cloudflare.com/bots/additional-configurations/block-ai-bots/">sustituye gradualmente</a> el antiguo «Block AI Bots» por políticas granulares Search, Training y Agent — y para crawlers de uso mixto (Googlebot, Applebot, Bingbot) introdujo una distinción fina entre <em>Block</em> y <em>Disallow</em>.</p>
<p>Esa distinción importa más de lo que parece.</p>
<p>La indexación de búsqueda significa que alguien encuentra su artículo. El entrenamiento significa que un modelo de IA aprende de él y puede reproducir su sustancia — sin enviarle un lector. Según el blog de Cloudflare <a href="https://blog.cloudflare.com/accountable-mixed-use-ai-crawlers/">Have it both ways</a>, Disallow AI Training escribe una preferencia «no training» en robots.txt y, en crawlers mixtos responsables (Accountable) — Google, Apple, Microsoft — conserva la indexación para búsqueda. Un <em>Block</em> completo de Training podría cortarlos también de la búsqueda.</p>
<p>Para los editores, esa es la tensión real. Quiero que Google indexe el portal de nefrología <a href="https://nefro.polascin.net/">nefro.polascin.net</a> para que los pacientes encuentren información. No quiero que un modelo de IA «trague» los artículos y responda al paciente directamente — eludiendo mi sitio.</p>
<p>Los nuevos controles son granulares: <strong>Search</strong>, <strong>Training</strong> y <strong>Agent</strong>. Puede permitir la indexación y a la vez rechazar el entrenamiento. Puede dejar que agentes descarguen una página para una consulta concreta del usuario e impedir el raspado masivo.</p>
<p>Gestiono 14 propiedades web. Portales de pacientes, sitios de producto, un catálogo de libros. Cada una tiene una relación distinta con los crawlers de IA. Un portal educativo quiere el máximo alcance. Un sitio de producto — por ejemplo <a href="https://nephroctor.com/">nephroctor.com</a> o <a href="https://arenibus.polascin.net/">arenibus.polascin.net</a> — no necesita alimentar el modelo de un competidor. El catálogo <a href="https://books.polascin.net/">books.polascin.net</a> necesita descubribilidad, no material de entrenamiento libre.</p>
<p>El interruptor antiguo era binario. El nuevo es quirúrgico.</p>
<p>Si tiene un sitio en Cloudflare y no ha revisado los ajustes de AI crawler desde la actualización de septiembre, es el momento. Si quiere revisar zonas concretas conmigo, escriba por el <a href="contact.php">formulario de contacto</a>.</p>
HTML,
        ],
        'pl' => [
            'title' => 'Cloudflare zastąpił „Block AI Bots” ustawieniem „Disallow AI Training”. Jeśli publikujecie online, sprawdźcie to.',
            'image_alt' => 'Nocne biurko wydawcy: laptop z sylwetką strony i fioletowo-turkusowy światłowodny tarcz, który przepuszcza tylko wąski promień wyszukiwania i blokuje cieniste crawlery.',
            'excerpt' => 'Od 15 września 2026 Cloudflare przenosi sterowanie crawlerami AI z binarnego blokowania na granularne Search, Training i Agent. Zalecane „Disallow AI Training” zostawia indeksację wyszukiwarek i odmawia trenowania modeli.',
            'content' => <<<'HTML'
<p>Cloudflare zakończył w tym miesiącu erę prostego przełącznika „Block AI Bots”. Jeśli publikujecie cokolwiek online, musicie wiedzieć, co go zastąpiło.</p>
<p>Przez ostatni rok domyślne było proste: blokować crawlery AI. Nie wpuszczać GPTBot, ClaudeBot ani botów treningowych, by zeskrobywały treść.</p>
<p>Od 15.&nbsp;września&nbsp;2026 Cloudflare przesunął zalecane ustawienie w stronę <strong>Disallow AI Training</strong>. Wyszukiwarki mogą nadal indeksować strony dla odkrywalności. Nie powinny jednak używać treści do trenowania modeli. Starszy przełącznik „Block AI Bots” Cloudflare <a href="https://developers.cloudflare.com/bots/additional-configurations/block-ai-bots/">stopniowo zastępuje</a> granularnymi politykami Search, Training i Agent — a dla crawlerów mieszanych (Googlebot, Applebot, Bingbot) wprowadził subtelną różnicę między <em>Block</em> a <em>Disallow</em>.</p>
<p>Ta różnica jest ważniejsza, niż brzmi.</p>
<p>Indeksacja w wyszukiwaniu oznacza, że ktoś znajdzie Wasz artykuł. Trenowanie oznacza, że model AI się z niego uczy i może odtworzyć jego treść — bez wysłania Wam czytelnika. Według bloga Cloudflare <a href="https://blog.cloudflare.com/accountable-mixed-use-ai-crawlers/">Have it both ways</a> ustawienie Disallow AI Training zapisuje preferencję „no training” w robots.txt i przy odpowiedzialnych (Accountable) crawlerach mieszanych — Google, Apple, Microsoft — pozostawia indeksację dla search. Pełny <em>Block</em> Training mógłby odciąć je także od wyszukiwania.</p>
<p>Dla wydawców to prawdziwe napięcie. Chcę, by Google indeksował portal nefrologiczny <a href="https://nefro.polascin.net/">nefro.polascin.net</a>, żeby pacjenci znaleźli informacje. Nie chcę, by model AI „przełykał” artykuły i odpowiadał pacjentowi bezpośrednio — omijając moją stronę.</p>
<p>Nowe sterowanie jest granularne: <strong>Search</strong>, <strong>Training</strong> i <strong>Agent</strong>. Możecie pozwolić na indeksację i jednocześnie odmówić trenowania. Możecie pozwolić agentom pobrać stronę dla konkretnego zapytania użytkownika i zapobiec masowemu skrobaniu.</p>
<p>Zarządzam 14 właściwościami webowymi. Portale pacjenckie, strony produktowe, katalog książek. Każda ma inny stosunek do crawlerów AI. Portal edukacyjny chce maksymalnego zasięgu. Strona produktowa — na przykład <a href="https://nephroctor.com/">nephroctor.com</a> lub <a href="https://arenibus.polascin.net/">arenibus.polascin.net</a> — nie musi karmić modelu konkurencji. Katalog <a href="https://books.polascin.net/">books.polascin.net</a> z kolei potrzebuje odkrywalności, nie wolnego materiału treningowego.</p>
<p>Stary przełącznik był binarny. Nowy jest chirurgiczny.</p>
<p>Jeśli macie stronę na Cloudflare i od wrześniowej aktualizacji nie sprawdzaliście ustawień AI crawler, czas to zrobić. Jeśli chcecie przejść ze mną konkretne strefy, napiszcie przez <a href="contact.php">kontakt</a>.</p>
HTML,
        ],
        'hu' => [
            'title' => 'A Cloudflare a „Block AI Bots”-ot „Disallow AI Training”-re cserélte. Ha online publikál, nézze meg.',
            'image_alt' => 'Kiadói íróasztal éjszaka: laptop webhely-sziluettel és lilás-türkiz fényű pajzs, amely csak egy keskeny keresési sugarat enged át, miközben árnyékos crawlereket blokkol.',
            'excerpt' => '2026. szeptember 15-től a Cloudflare az AI-crawlerek bináris blokkolásáról a granuláris Search, Training és Agent vezérlésre tér. Az ajánlott „Disallow AI Training” meghagyja a keresőindexelést, és elutasítja a modelltréninget.',
            'content' => <<<'HTML'
<p>A Cloudflare ebben a hónapban lezárta az egyszerű „Block AI Bots” kapcsoló korszakát. Ha bármit online publikál, tudnia kell, mi váltotta fel.</p>
<p>Az elmúlt évben az alapértelmezés egyszerű volt: blokkolni az AI-crawlereket. Ne engedjük be a GPTBotot, a ClaudeBotot vagy a tréningbotokat, hogy lekaparják a tartalmat.</p>
<p>2026.&nbsp;szeptember&nbsp;15-től a Cloudflare az ajánlott beállítást a <strong>Disallow AI Training</strong> felé tolja. A keresők továbbra is indexelhetik az oldalakat a felfedezhetőségért. Nem szabad azonban a tartalmat modellek tréningjére használniuk. A régebbi „Block AI Bots” kapcsolót a Cloudflare <a href="https://developers.cloudflare.com/bots/additional-configurations/block-ai-bots/">fokozatosan felváltja</a> granuláris Search, Training és Agent szabályokkal — és a vegyes crawlereknél (Googlebot, Applebot, Bingbot) finom különbséget vezet be a <em>Block</em> és a <em>Disallow</em> között.</p>
<p>Ez a különbség fontosabb, mint amilyennek hangzik.</p>
<p>A keresőindexelés azt jelenti, hogy valaki megtalálja a cikkét. A tréning azt, hogy egy AI-modell tanul belőle, és reprodukálhatja a lényegét — anélkül, hogy olvasót küldene Önnek. A Cloudflare <a href="https://blog.cloudflare.com/accountable-mixed-use-ai-crawlers/">Have it both ways</a> bejegyzése szerint a Disallow AI Training „no training” preferenciát ír a robots.txt-be, és a felelős (Accountable) vegyes crawlereknél — Google, Apple, Microsoft — meghagyja a keresőindexelést. A teljes Training <em>Block</em> akár a kereséstől is elvághatná őket.</p>
<p>A kiadóknak ez a valódi feszültség. Azt akarom, hogy a Google indexelje a nefrológiai portált (<a href="https://nefro.polascin.net/">nefro.polascin.net</a>), hogy a betegek megtalálják az információt. Nem akarom, hogy egy AI-modell „lenyelje” a cikkeket, és közvetlenül válaszoljon a betegnek — megkerülve a webhelyemet.</p>
<p>Az új vezérlők granulárisak: <strong>Search</strong>, <strong>Training</strong> és <strong>Agent</strong>. Engedélyezheti az indexelést, és közben elutasíthatja a tréninget. Engedheti, hogy ügynökök egy konkrét felhasználói lekérdezéshez letöltsenek egy oldalt, és megakadályozhatja a tömeges kaparást.</p>
<p>14 web propertyt kezelek. Betegportálok, termékoldalak, könyvkatalógus. Mindegyiknek más a viszonya az AI-crawlerekhez. Az oktatási portál maximális elérést akar. A termékoldal — például a <a href="https://nephroctor.com/">nephroctor.com</a> vagy az <a href="https://arenibus.polascin.net/">arenibus.polascin.net</a> — nem kell, hogy a versenytárs modelljét táplálja. A <a href="https://books.polascin.net/">books.polascin.net</a> katalógusnak felfedezhetőség kell, nem szabad tréninganyag.</p>
<p>A régi kapcsoló bináris volt. Az új sebészi.</p>
<p>Ha Cloudflare-en fut a webhelye, és a szeptemberi frissítés óta nem nézte az AI crawler beállításokat, most van itt az ideje. Ha konkrét zónákat szeretne velem átnézni, írjon a <a href="contact.php">kapcsolati űrlapon</a>.</p>
HTML,
        ],
        'it' => [
            'title' => 'Cloudflare ha sostituito «Block AI Bots» con «Disallow AI Training». Se pubblicate online, controllatelo.',
            'image_alt' => 'Scrivania di un editore di notte: un laptop con la silhouette di un sito e uno scudo di luce viola-turchese che lascia passare solo un sottile fascio di ricerca bloccando crawler ombrosi.',
            'excerpt' => 'Dal 15 settembre 2026 Cloudflare sposta il controllo dei crawler IA dal blocco binario a Search, Training e Agent granulari. Il «Disallow AI Training» consigliato lascia l’indicizzazione per la ricerca e rifiuta l’addestramento dei modelli.',
            'content' => <<<'HTML'
<p>Cloudflare ha chiuso questo mese l’era del semplice interruttore «Block AI Bots». Se pubblicate qualsiasi cosa online, dovete sapere cosa lo ha sostituito.</p>
<p>Nell’ultimo anno il default era semplice: bloccare i crawler IA. Non far passare GPTBot, ClaudeBot né i bot di addestramento a raschiare i contenuti.</p>
<p>Dal 15&nbsp;settembre&nbsp;2026 Cloudflare ha spostato l’impostazione consigliata verso <strong>Disallow AI Training</strong>. I motori di ricerca possono ancora indicizzare le pagine per la scopribilità. Non devono però usare i contenuti per addestrare modelli. Cloudflare <a href="https://developers.cloudflare.com/bots/additional-configurations/block-ai-bots/">sta sostituendo gradualmente</a> il vecchio «Block AI Bots» con politiche granulari Search, Training e Agent — e per i crawler a uso misto (Googlebot, Applebot, Bingbot) ha introdotto una distinzione fine tra <em>Block</em> e <em>Disallow</em>.</p>
<p>Questa distinzione conta più di quanto sembri.</p>
<p>L’indicizzazione per la ricerca significa che qualcuno trova il vostro articolo. L’addestramento significa che un modello IA ci impara e può riprodurne la sostanza — senza mai inviarvi un lettore. Secondo il post Cloudflare <a href="https://blog.cloudflare.com/accountable-mixed-use-ai-crawlers/">Have it both ways</a>, Disallow AI Training scrive una preferenza «no training» in robots.txt e, per i crawler misti responsabili (Accountable) — Google, Apple, Microsoft — lascia l’indicizzazione per la ricerca. Un <em>Block</em> completo di Training potrebbe tagliarli anche dalla ricerca.</p>
<p>Per gli editori è la vera tensione. Voglio che Google indicizzi il portale di nefrologia <a href="https://nefro.polascin.net/">nefro.polascin.net</a> così i pazienti trovano le informazioni. Non voglio che un modello IA «ingoii» gli articoli e risponda al paziente direttamente — aggirando il mio sito.</p>
<p>I nuovi controlli sono granulari: <strong>Search</strong>, <strong>Training</strong> e <strong>Agent</strong>. Potete consentire l’indicizzazione e al tempo stesso rifiutare l’addestramento. Potete lasciare che gli agent recuperino una pagina per una query utente specifica e prevenire lo scraping di massa.</p>
<p>Gestisco 14 proprietà web. Portali pazienti, siti prodotto, un catalogo di libri. Ognuna ha un rapporto diverso con i crawler IA. Un portale educativo vuole la massima portata. Un sito prodotto — ad esempio <a href="https://nephroctor.com/">nephroctor.com</a> o <a href="https://arenibus.polascin.net/">arenibus.polascin.net</a> — non deve alimentare il modello di un concorrente. Il catalogo <a href="https://books.polascin.net/">books.polascin.net</a> ha bisogno di scopribilità, non di materiale di addestramento libero.</p>
<p>Il vecchio interruttore era binario. Il nuovo è chirurgico.</p>
<p>Se avete un sito su Cloudflare e non avete controllato le impostazioni AI crawler dall’aggiornamento di settembre, è il momento. Se volete ripassare zone concrete con me, scrivete tramite il <a href="contact.php">modulo di contatto</a>.</p>
HTML,
        ],
        'uk' => [
            'title' => 'Cloudflare замінив «Block AI Bots» на «Disallow AI Training». Якщо публікуєте онлайн — перевірте.',
            'image_alt' => 'Нічний стіл видавця: ноутбук із силуетом сайту та фіолетово-бірюзовий щит світла, що пропускає лише вузький промінь пошуку й блокує тіні crawlerів.',
            'excerpt' => 'З 15 вересня 2026 Cloudflare переводить керування AI-crawlerами з бінарного блокування на гранулярні Search, Training і Agent. Рекомендоване «Disallow AI Training» лишає індексацію для пошуку й відмовляє в тренуванні моделей.',
            'content' => <<<'HTML'
<p>Cloudflare цього місяця завершив еру простого перемикача «Block AI Bots». Якщо публікуєте щось онлайн, вам треба знати, що його замінило.</p>
<p>Останній рік типовим було просте: блокувати AI-crawlerів. Не пускати GPTBot, ClaudeBot і тренувальних ботів зскрібати вміст.</p>
<p>З 15&nbsp;вересня&nbsp;2026 Cloudflare змістив рекомендоване налаштування до <strong>Disallow AI Training</strong>. Пошукові системи все ще можуть індексувати сторінки для знаходження. Вони не повинні використовувати вміст для тренування моделей. Старіший перемикач «Block AI Bots» Cloudflare <a href="https://developers.cloudflare.com/bots/additional-configurations/block-ai-bots/">поступово замінює</a> гранулярними політиками Search, Training і Agent — а для змішаних crawlerів (Googlebot, Applebot, Bingbot) запровадив тонку різницю між <em>Block</em> і <em>Disallow</em>.</p>
<p>Ця різниця важливіша, ніж здається.</p>
<p>Індексація для пошуку означає, що хтось знайде вашу статтю. Тренування означає, що AI-модель вчиться з неї й може відтворити суть — не надіславши вам читача. За блогом Cloudflare <a href="https://blog.cloudflare.com/accountable-mixed-use-ai-crawlers/">Have it both ways</a> Disallow AI Training записує вподобання «no training» у robots.txt і для відповідальних (Accountable) змішаних crawlerів — Google, Apple, Microsoft — лишає індексацію для пошуку. Повний <em>Block</em> Training міг би відрізати їх і від пошуку.</p>
<p>Для видавців це справжня напруга. Я хочу, щоб Google індексував нефрологічний портал <a href="https://nefro.polascin.net/">nefro.polascin.net</a>, щоб пацієнти знаходили інформацію. Не хочу, щоб AI-модель «ковтала» статті й відповідала пацієнтові напряму — в обхід мого сайту.</p>
<p>Нові керування гранулярні: <strong>Search</strong>, <strong>Training</strong> і <strong>Agent</strong>. Можна дозволити індексацію й водночас відмовити в тренуванні. Можна дозволити агентам стягнути сторінку для конкретного запиту користувача й запобігти масовому зскрібанню.</p>
<p>Я керую 14 веб-properties. Пацієнтські портали, продуктові сайти, каталог книг. Кожна має інше ставлення до AI-crawlerів. Освітній портал хоче максимального охоплення. Продуктовий сайт — наприклад <a href="https://nephroctor.com/">nephroctor.com</a> або <a href="https://arenibus.polascin.net/">arenibus.polascin.net</a> — не мусить годувати модель конкурента. Каталог <a href="https://books.polascin.net/">books.polascin.net</a> потребує знаходження, а не вільного тренувального матеріалу.</p>
<p>Старий перемикач був бінарним. Новий — хірургічний.</p>
<p>Якщо ваш сайт на Cloudflare і від вересневого оновлення ви не перевіряли AI crawler settings, час це зробити. Якщо хочете пройти конкретні зони зі мною, напишіть через <a href="contact.php">контакт</a>.</p>
HTML,
        ],
    ],
];
