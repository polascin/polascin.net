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
    'published_at' => '2026-09-24 17:15:00',
    'image' => 'images/articles/cloudflare-zakaz-ai-trenovania.webp',
    'translations' => [
        'sk' => [
            'title' => 'Cloudflare nahradil „Block AI Bots“ nastavením „Disallow AI Training“. Ak publikujete online, pozrite si to.',
            'image_alt' => 'Nočný stôl vydavateľa: notebook so siluetou webu a fialovo-tyrkysový štít svetla, ktorý prepúšťa iba úzky lúč vyhľadávania a blokuje tiene crawlerov.',
            'excerpt' => 'Od 15. septembra 2026 Cloudflare delí ovládanie AI crawlerov na Search, Training a Agent. Odporúčané „Disallow AI Training“ nechá indexáciu vyhľadávačov a odmietne trénovanie modelov.',
            'content' => <<<'HTML'
<p>Od 15.&nbsp;septembra&nbsp;2026 Cloudflare odporúča nastavenie <strong>Disallow AI Training</strong>. Vyhľadávače môžu stránky naďalej indexovať, aby sa dali nájsť. Obsah z nich nemajú brať na trénovanie modelov.</p>
<p>Posledný rok bolo predvolené nastavenie jednoduché: zablokovať AI crawlerov. Nepustiť GPTBot, ClaudeBot ani tréningové boty, aby zoškrabávali obsah.</p>
<p>Starší prepínač „Block AI Bots“ Cloudflare <a href="https://developers.cloudflare.com/bots/additional-configurations/block-ai-bots/">postupne nahrádza</a> oddelenými pravidlami Search, Training a Agent. Pri zmiešaných crawleroch (Googlebot, Applebot, Bingbot) rozlišuje <em>Block</em> a <em>Disallow</em>.</p>
<p>Indexácia do vyhľadávania znamená, že niekto váš článok nájde. Trénovanie znamená, že model sa z neho učí a môže zopakovať jeho podstatu, bez toho, aby vám poslal čitateľa. Podľa blogu Cloudflare <a href="https://blog.cloudflare.com/accountable-mixed-use-ai-crawlers/">Have it both ways</a> nastavenie Disallow AI Training zapíše voľbu „no training“ do robots.txt. Pri zodpovedných (Accountable) zmiešaných crawleroch Google, Apple a Microsoft nechá indexáciu pre vyhľadávanie. Úplný <em>Block</em> pri Training by ich mohol odstrihnúť aj od vyhľadávania.</p>
<p>Pri vlastných weboch je to napätie, ktoré mám naozaj. Chcem, aby Google indexoval nefrologický portál <a href="https://nefro.polascin.net/">nefro.polascin.net</a>, aby pacienti našli informácie. Nechcem, aby model články pohltil a odpovedal pacientovi priamo, mimo môjho webu.</p>
<p>Nové ovládanie je rozdelené na <strong>Search</strong>, <strong>Training</strong> a <strong>Agent</strong>. Indexáciu môžete povoliť a trénovanie odmietnuť. Agentom môžete dovoliť stiahnuť stránku pre konkrétny dopyt používateľa a zabrániť hromadnému zoškrabávaniu.</p>
<p>Spravujem 14 webov. Pacientské portály, produktové stránky, katalóg kníh. Každý má k AI crawlerom iný vzťah. Edukačný portál má mať čo najviac čitateľov. Produktový web, napríklad <a href="https://nephroctor.com/">nephroctor.com</a> alebo <a href="https://arenibus.polascin.net/">arenibus.polascin.net</a>, nemusí kŕmiť model konkurencie. Katalóg <a href="https://books.polascin.net/">books.polascin.net</a> sa má dať nájsť. Voľný materiál na trénovanie z neho byť nemá.</p>
<p>Starý prepínač mal dve polohy. Nové nastavenie rozlišuje, na čo sa obsah smie použiť.</p>
<p>Ak máte web na Cloudflare a od septembrovej aktualizácie ste nastavenie AI crawlerov nekontrolovali, pozrite si ho.</p>
HTML,
        ],
        'en' => [
            'title' => 'Cloudflare replaced “Block AI Bots” with “Disallow AI Training.” If you publish online, check it.',
            'image_alt' => 'A publisher’s desk at night: a laptop with a website silhouette and a purple-teal shield of light that lets only a narrow search beam through while blocking shadowy crawlers.',
            'excerpt' => 'As of 15 September 2026, Cloudflare splits AI crawler control into Search, Training, and Agent. The recommended “Disallow AI Training” keeps search indexing and refuses model training.',
            'content' => <<<'HTML'
<p>As of 15&nbsp;September&nbsp;2026, Cloudflare recommends <strong>Disallow AI Training</strong>. Search engines may still index pages so that people can find them. They should not take the content to train models.</p>
<p>For the past year the default was simple: block AI crawlers. Do not let GPTBot, ClaudeBot, or training bots scrape the content.</p>
<p>Cloudflare is <a href="https://developers.cloudflare.com/bots/additional-configurations/block-ai-bots/">gradually replacing</a> the older “Block AI Bots” switch with separate Search, Training, and Agent rules. For mixed-use crawlers (Googlebot, Applebot, Bingbot) it distinguishes <em>Block</em> from <em>Disallow</em>.</p>
<p>Search indexing means someone finds your article. Training means a model learns from it and can repeat its substance without sending you a reader. According to Cloudflare’s post <a href="https://blog.cloudflare.com/accountable-mixed-use-ai-crawlers/">Have it both ways</a>, Disallow AI Training writes a “no training” choice into robots.txt. For accountable mixed-use crawlers from Google, Apple, and Microsoft, it still allows search indexing. A full <em>Block</em> on Training could cut them off from search as well.</p>
<p>On my own sites that tension is real. I want Google to index the nephrology portal <a href="https://nefro.polascin.net/">nefro.polascin.net</a> so patients can find the information. I do not want a model to swallow the articles and answer the patient directly, away from my site.</p>
<p>The new controls are split into <strong>Search</strong>, <strong>Training</strong>, and <strong>Agent</strong>. You can allow indexing and refuse training. You can let agents fetch a page for one user’s query and stop bulk scraping.</p>
<p>I run 14 sites. Patient portals, product sites, a book catalog. Each stands differently toward AI crawlers. An education portal should have as many readers as it can. A product site, for example <a href="https://nephroctor.com/">nephroctor.com</a> or <a href="https://arenibus.polascin.net/">arenibus.polascin.net</a>, does not need to feed a competitor’s model. The catalog at <a href="https://books.polascin.net/">books.polascin.net</a> should be findable. It should not be free training material.</p>
<p>The old switch had two positions. The new setting distinguishes what the content may be used for.</p>
<p>If your site is on Cloudflare and you have not checked the AI crawler settings since the September update, look at them.</p>
HTML,
        ],
        'cs' => [
            'title' => 'Cloudflare nahradil „Block AI Bots“ nastavením „Disallow AI Training“. Pokud publikujete online, podívejte se na to.',
            'image_alt' => 'Noční stůl vydavatele: notebook se siluetou webu a fialovo-tyrkysový štít světla, který propouští jen úzký paprsek vyhledávání a blokuje stíny crawlerů.',
            'excerpt' => 'Od 15. září 2026 Cloudflare dělí ovládání AI crawlerů na Search, Training a Agent. Doporučené „Disallow AI Training“ nechá indexaci vyhledávačů a odmítne trénování modelů.',
            'content' => <<<'HTML'
<p>Od 15.&nbsp;září&nbsp;2026 Cloudflare doporučuje nastavení <strong>Disallow AI Training</strong>. Vyhledávače mohou stránky dál indexovat, aby se daly najít. Obsah z nich nemají brát na trénování modelů.</p>
<p>Poslední rok bylo výchozí nastavení jednoduché: zablokovat AI crawlery. Nepustit GPTBot, ClaudeBot ani tréninkové boty, aby oškrabávaly obsah.</p>
<p>Starší přepínač „Block AI Bots“ Cloudflare <a href="https://developers.cloudflare.com/bots/additional-configurations/block-ai-bots/">postupně nahrazuje</a> oddělenými pravidly Search, Training a Agent. U smíšených crawlerů (Googlebot, Applebot, Bingbot) rozlišuje <em>Block</em> a <em>Disallow</em>.</p>
<p>Indexace do vyhledávání znamená, že někdo váš článek najde. Trénování znamená, že se model z něj učí a může zopakovat jeho podstatu, aniž by vám poslal čtenáře. Podle blogu Cloudflare <a href="https://blog.cloudflare.com/accountable-mixed-use-ai-crawlers/">Have it both ways</a> nastavení Disallow AI Training zapíše volbu „no training“ do robots.txt. U odpovědných (Accountable) smíšených crawlerů Google, Apple a Microsoft nechá indexaci pro vyhledávání. Úplný <em>Block</em> u Training by je mohl odříznout i od vyhledávání.</p>
<p>U vlastních webů je to napětí, které mám doopravdy. Chci, aby Google indexoval nefrologický portál <a href="https://nefro.polascin.net/">nefro.polascin.net</a>, aby pacienti našli informace. Nechci, aby model články pohltil a odpověděl pacientovi přímo, mimo můj web.</p>
<p>Nové ovládání je rozdělené na <strong>Search</strong>, <strong>Training</strong> a <strong>Agent</strong>. Indexaci můžete povolit a trénování odmítnout. Agentům můžete dovolit stáhnout stránku pro konkrétní dotaz uživatele a zabránit hromadnému oškrabávání.</p>
<p>Spravuji 14 webů. Pacientské portály, produktové stránky, katalog knih. Každý má k AI crawlerům jiný vztah. Vzdělávací portál má mít co nejvíc čtenářů. Produktový web, například <a href="https://nephroctor.com/">nephroctor.com</a> nebo <a href="https://arenibus.polascin.net/">arenibus.polascin.net</a>, nemusí krmit model konkurence. Katalog <a href="https://books.polascin.net/">books.polascin.net</a> se má dát najít. Volný materiál na trénování z něj být nemá.</p>
<p>Starý přepínač měl dvě polohy. Nové nastavení rozlišuje, k čemu se obsah smí použít.</p>
<p>Pokud máte web na Cloudflare a od zářijové aktualizace jste nastavení AI crawlerů nekontrolovali, podívejte se na ně.</p>
HTML,
        ],
        'de' => [
            'title' => 'Cloudflare ersetzt „Block AI Bots“ durch „Disallow AI Training“. Wenn Sie online publizieren, prüfen Sie das.',
            'image_alt' => 'Nachtischer Schreibtisch eines Verlegers: Laptop mit Website-Silhouette und ein violett-türkiser Lichtschild, der nur einen schmalen Suchstrahl durchlässt und schattenhafte Crawler blockiert.',
            'excerpt' => 'Ab dem 15. September 2026 teilt Cloudflare die Steuerung von KI-Crawlern in Search, Training und Agent. Das empfohlene „Disallow AI Training“ lässt die Suchindexierung zu und verweigert das Modelltraining.',
            'content' => <<<'HTML'
<p>Seit dem 15.&nbsp;September&nbsp;2026 empfiehlt Cloudflare die Einstellung <strong>Disallow AI Training</strong>. Suchmaschinen dürfen Seiten weiter indexieren, damit man sie findet. Den Inhalt sollen sie nicht zum Trainieren von Modellen nehmen.</p>
<p>Im vergangenen Jahr war die Voreinstellung einfach: KI-Crawler blockieren. GPTBot, ClaudeBot und Trainingsbots nicht an den Inhalt lassen.</p>
<p>Den älteren Schalter „Block AI Bots“ <a href="https://developers.cloudflare.com/bots/additional-configurations/block-ai-bots/">ersetzt Cloudflare schrittweise</a> durch getrennte Regeln für Search, Training und Agent. Bei gemischten Crawlern (Googlebot, Applebot, Bingbot) unterscheidet es <em>Block</em> und <em>Disallow</em>.</p>
<p>Suchindexierung heißt: jemand findet Ihren Artikel. Training heißt: ein Modell lernt daraus und kann den Kern wiedergeben, ohne Ihnen einen Leser zu schicken. Laut dem Cloudflare-Beitrag <a href="https://blog.cloudflare.com/accountable-mixed-use-ai-crawlers/">Have it both ways</a> schreibt Disallow AI Training die Wahl „no training“ in robots.txt. Bei verantwortlichen (Accountable) gemischten Crawlern von Google, Apple und Microsoft lässt es die Indexierung für die Suche zu. Ein vollständiger <em>Block</em> bei Training könnte sie auch von der Suche abschneiden.</p>
<p>Bei den eigenen Websites ist das eine Spannung, die ich wirklich habe. Ich will, dass Google das Nephrologie-Portal <a href="https://nefro.polascin.net/">nefro.polascin.net</a> indexiert, damit Patienten die Informationen finden. Ich will nicht, dass ein Modell die Artikel schluckt und dem Patienten direkt antwortet, an meiner Website vorbei.</p>
<p>Die neue Steuerung ist aufgeteilt in <strong>Search</strong>, <strong>Training</strong> und <strong>Agent</strong>. Sie können die Indexierung erlauben und das Training ablehnen. Sie können Agenten eine Seite für eine konkrete Nutzeranfrage abrufen lassen und das massenhafte Abgreifen verhindern.</p>
<p>Ich betreibe 14 Websites. Patientenportale, Produktseiten, einen Bücherkatalog. Jede steht zu KI-Crawlern anders. Ein Bildungsportal soll so viele Leser wie möglich haben. Eine Produktseite, etwa <a href="https://nephroctor.com/">nephroctor.com</a> oder <a href="https://arenibus.polascin.net/">arenibus.polascin.net</a>, muss kein Modell der Konkurrenz füttern. Der Katalog <a href="https://books.polascin.net/">books.polascin.net</a> soll auffindbar sein. Freies Trainingsmaterial soll er nicht sein.</p>
<p>Der alte Schalter hatte zwei Stellungen. Die neue Einstellung unterscheidet, wofür der Inhalt verwendet werden darf.</p>
<p>Wenn Ihre Website auf Cloudflare liegt und Sie die Einstellungen für KI-Crawler seit dem September-Update nicht geprüft haben, sehen Sie sie sich an.</p>
HTML,
        ],
        'fr' => [
            'title' => 'Cloudflare remplace « Block AI Bots » par « Disallow AI Training ». Si vous publiez en ligne, vérifiez cela.',
            'image_alt' => 'Bureau d’éditeur la nuit : un ordinateur portable avec la silhouette d’un site et un bouclier de lumière violet-turquoise qui ne laisse passer qu’un étroit faisceau de recherche tout en bloquant des crawlers ombreux.',
            'excerpt' => 'Depuis le 15 septembre 2026, Cloudflare sépare le contrôle des crawlers d’IA en Search, Training et Agent. Le « Disallow AI Training » recommandé laisse l’indexation pour la recherche et refuse l’entraînement des modèles.',
            'content' => <<<'HTML'
<p>Depuis le 15&nbsp;septembre&nbsp;2026, Cloudflare recommande le réglage <strong>Disallow AI Training</strong>. Les moteurs de recherche peuvent encore indexer les pages pour qu’on les trouve. Ils ne doivent pas prendre le contenu pour entraîner des modèles.</p>
<p>L’an dernier, le réglage par défaut était simple : bloquer les crawlers d’IA. Ne pas laisser GPTBot, ClaudeBot ni les bots d’entraînement racler le contenu.</p>
<p>Cloudflare <a href="https://developers.cloudflare.com/bots/additional-configurations/block-ai-bots/">remplace progressivement</a> l’ancien commutateur « Block AI Bots » par des règles séparées, Search, Training et Agent. Pour les crawlers à usage mixte (Googlebot, Applebot, Bingbot), il distingue <em>Block</em> et <em>Disallow</em>.</p>
<p>L’indexation pour la recherche veut dire que quelqu’un trouve votre article. L’entraînement veut dire qu’un modèle en apprend et peut en répéter la substance sans vous envoyer de lecteur. Selon le billet Cloudflare <a href="https://blog.cloudflare.com/accountable-mixed-use-ai-crawlers/">Have it both ways</a>, Disallow AI Training écrit le choix « no training » dans robots.txt. Pour les crawlers mixtes responsables (Accountable) de Google, Apple et Microsoft, il laisse l’indexation pour la recherche. Un <em>Block</em> complet sur Training pourrait aussi les couper de la recherche.</p>
<p>Sur mes propres sites, cette tension est réelle. Je veux que Google indexe le portail de néphrologie <a href="https://nefro.polascin.net/">nefro.polascin.net</a> pour que les patients trouvent l’information. Je ne veux pas qu’un modèle avale les articles et réponde au patient directement, hors de mon site.</p>
<p>Le nouveau contrôle est réparti en <strong>Search</strong>, <strong>Training</strong> et <strong>Agent</strong>. Vous pouvez autoriser l’indexation et refuser l’entraînement. Vous pouvez laisser des agents récupérer une page pour la requête d’un utilisateur et empêcher le raclage en masse.</p>
<p>Je gère 14 sites. Des portails pour les patients, des sites de produit, un catalogue de livres. Chacun n’a pas le même rapport aux crawlers d’IA. Un portail éducatif doit avoir autant de lecteurs que possible. Un site de produit, par exemple <a href="https://nephroctor.com/">nephroctor.com</a> ou <a href="https://arenibus.polascin.net/">arenibus.polascin.net</a>, n’a pas à nourrir le modèle d’un concurrent. Le catalogue <a href="https://books.polascin.net/">books.polascin.net</a> doit pouvoir être trouvé. Il ne doit pas servir de matériau d’entraînement libre.</p>
<p>L’ancien commutateur avait deux positions. Le nouveau réglage distingue à quoi le contenu peut servir.</p>
<p>Si votre site est chez Cloudflare et que vous n’avez pas vérifié les réglages des crawlers d’IA depuis la mise à jour de septembre, regardez-les.</p>
HTML,
        ],
        'es' => [
            'title' => 'Cloudflare sustituyó «Block AI Bots» por «Disallow AI Training». Si publica en línea, revíselo.',
            'image_alt' => 'Escritorio de un editor de noche: un portátil con la silueta de un sitio y un escudo de luz púrpura-turquesa que solo deja pasar un estrecho haz de búsqueda mientras bloquea crawlers en sombra.',
            'excerpt' => 'Desde el 15 de septiembre de 2026, Cloudflare separa el control de los crawlers de IA en Search, Training y Agent. El «Disallow AI Training» recomendado mantiene la indexación de búsqueda y rechaza el entrenamiento de modelos.',
            'content' => <<<'HTML'
<p>Desde el 15&nbsp;de&nbsp;septiembre&nbsp;de&nbsp;2026, Cloudflare recomienda el ajuste <strong>Disallow AI Training</strong>. Los buscadores aún pueden indexar las páginas para que se encuentren. No deben tomar el contenido para entrenar modelos.</p>
<p>El último año el ajuste por defecto era simple: bloquear los crawlers de IA. No dejar que GPTBot, ClaudeBot ni los bots de entrenamiento raspen el contenido.</p>
<p>Cloudflare <a href="https://developers.cloudflare.com/bots/additional-configurations/block-ai-bots/">sustituye poco a poco</a> el antiguo interruptor «Block AI Bots» por reglas separadas: Search, Training y Agent. En los crawlers de uso mixto (Googlebot, Applebot, Bingbot) distingue <em>Block</em> y <em>Disallow</em>.</p>
<p>La indexación de búsqueda quiere decir que alguien encuentra su artículo. El entrenamiento quiere decir que un modelo aprende de él y puede repetir su sustancia sin enviarle un lector. Según el blog de Cloudflare <a href="https://blog.cloudflare.com/accountable-mixed-use-ai-crawlers/">Have it both ways</a>, Disallow AI Training escribe la elección «no training» en robots.txt. En los crawlers mixtos responsables (Accountable) de Google, Apple y Microsoft deja la indexación para la búsqueda. Un <em>Block</em> completo de Training podría cortarlos también de la búsqueda.</p>
<p>En mis propios sitios esa tensión es real. Quiero que Google indexe el portal de nefrología <a href="https://nefro.polascin.net/">nefro.polascin.net</a> para que los pacientes encuentren la información. No quiero que un modelo se trague los artículos y responda al paciente directamente, fuera de mi sitio.</p>
<p>El control nuevo está repartido en <strong>Search</strong>, <strong>Training</strong> y <strong>Agent</strong>. Puede permitir la indexación y rechazar el entrenamiento. Puede dejar que los agentes descarguen una página para la consulta de un usuario e impedir el raspado masivo.</p>
<p>Gestiono 14 sitios. Portales de pacientes, sitios de producto, un catálogo de libros. Cada uno tiene una relación distinta con los crawlers de IA. Un portal educativo ha de tener tantos lectores como sea posible. Un sitio de producto, por ejemplo <a href="https://nephroctor.com/">nephroctor.com</a> o <a href="https://arenibus.polascin.net/">arenibus.polascin.net</a>, no tiene que alimentar el modelo de un competidor. El catálogo <a href="https://books.polascin.net/">books.polascin.net</a> ha de poder encontrarse. No ha de ser material libre de entrenamiento.</p>
<p>El interruptor antiguo tenía dos posiciones. El ajuste nuevo distingue para qué se puede usar el contenido.</p>
<p>Si su sitio está en Cloudflare y no ha revisado los ajustes de los crawlers de IA desde la actualización de septiembre, mírelos.</p>
HTML,
        ],
        'pl' => [
            'title' => 'Cloudflare zastąpił „Block AI Bots” ustawieniem „Disallow AI Training”. Jeśli publikujecie online, sprawdźcie to.',
            'image_alt' => 'Nocne biurko wydawcy: laptop z sylwetką strony i fioletowo-turkusowa tarcza światła, która przepuszcza tylko wąski promień wyszukiwania i blokuje cieniste crawlery.',
            'excerpt' => 'Od 15 września 2026 Cloudflare dzieli sterowanie crawlerami AI na Search, Training i Agent. Zalecane „Disallow AI Training” zostawia indeksację wyszukiwarek i odmawia trenowania modeli.',
            'content' => <<<'HTML'
<p>Od 15.&nbsp;września&nbsp;2026 Cloudflare zaleca ustawienie <strong>Disallow AI Training</strong>. Wyszukiwarki mogą nadal indeksować strony, żeby dało się je znaleźć. Treści z nich nie powinny brać do trenowania modeli.</p>
<p>Przez ostatni rok ustawienie domyślne było proste: blokować crawlery AI. Nie wpuszczać GPTBot, ClaudeBot ani botów treningowych, żeby zeskrobywały treść.</p>
<p>Starszy przełącznik „Block AI Bots” Cloudflare <a href="https://developers.cloudflare.com/bots/additional-configurations/block-ai-bots/">stopniowo zastępuje</a> osobnymi regułami Search, Training i Agent. Przy crawlerach mieszanych (Googlebot, Applebot, Bingbot) odróżnia <em>Block</em> od <em>Disallow</em>.</p>
<p>Indeksacja w wyszukiwaniu znaczy, że ktoś znajdzie wasz artykuł. Trenowanie znaczy, że model uczy się z niego i może powtórzyć jego treść, nie przysyłając wam czytelnika. Według wpisu Cloudflare <a href="https://blog.cloudflare.com/accountable-mixed-use-ai-crawlers/">Have it both ways</a> ustawienie Disallow AI Training zapisuje wybór „no training” w robots.txt. Przy odpowiedzialnych (Accountable) crawlerach mieszanych Google, Apple i Microsoft zostawia indeksację dla wyszukiwania. Pełny <em>Block</em> przy Training mógłby odciąć je także od wyszukiwania.</p>
<p>Na własnych stronach to napięcie mam naprawdę. Chcę, żeby Google indeksował portal nefrologiczny <a href="https://nefro.polascin.net/">nefro.polascin.net</a>, aby pacjenci znaleźli informacje. Nie chcę, żeby model połknął artykuły i odpowiedział pacjentowi wprost, poza moją stroną.</p>
<p>Nowe sterowanie jest podzielone na <strong>Search</strong>, <strong>Training</strong> i <strong>Agent</strong>. Możecie pozwolić na indeksację i odmówić trenowania. Możecie pozwolić agentom pobrać stronę dla jednego zapytania użytkownika i zatrzymać masowe skrobanie.</p>
<p>Prowadzę 14 stron. Portale dla pacjentów, strony produktowe, katalog książek. Każda ma inny stosunek do crawlerów AI. Portal edukacyjny ma mieć jak najwięcej czytelników. Strona produktowa, na przykład <a href="https://nephroctor.com/">nephroctor.com</a> albo <a href="https://arenibus.polascin.net/">arenibus.polascin.net</a>, nie musi karmić modelu konkurencji. Katalog <a href="https://books.polascin.net/">books.polascin.net</a> ma dać się znaleźć. Nie ma być wolnym materiałem treningowym.</p>
<p>Stary przełącznik miał dwa położenia. Nowe ustawienie rozróżnia, do czego treść wolno użyć.</p>
<p>Jeśli macie stronę na Cloudflare i od wrześniowej aktualizacji nie sprawdzaliście ustawień crawlerów AI, zajrzyjcie do nich.</p>
HTML,
        ],
        'hu' => [
            'title' => 'A Cloudflare a „Block AI Bots”-ot „Disallow AI Training”-re cserélte. Ha online publikál, nézze meg.',
            'image_alt' => 'Kiadói íróasztal éjszaka: laptop webhely-sziluettel és lilás-türkiz fényű pajzs, amely csak egy keskeny keresési sugarat enged át, miközben árnyékos crawlereket blokkol.',
            'excerpt' => '2026. szeptember 15-től a Cloudflare az AI-crawlerek vezérlését Search, Training és Agent részekre bontja. Az ajánlott „Disallow AI Training” meghagyja a keresőindexelést, és elutasítja a modelltréninget.',
            'content' => <<<'HTML'
<p>2026.&nbsp;szeptember&nbsp;15-től a Cloudflare a <strong>Disallow AI Training</strong> beállítást ajánlja. A keresők továbbra is indexelhetik az oldalakat, hogy meg lehessen találni őket. A tartalmat nem vehetik el modellek tréningjére.</p>
<p>Az elmúlt évben az alapértelmezés egyszerű volt: blokkolni az AI-crawlereket. A GPTBot, a ClaudeBot és a tréningbotok ne kaparhassák le a tartalmat.</p>
<p>A régebbi „Block AI Bots” kapcsolót a Cloudflare <a href="https://developers.cloudflare.com/bots/additional-configurations/block-ai-bots/">fokozatosan felváltja</a> külön Search, Training és Agent szabályokkal. A vegyes crawlereknél (Googlebot, Applebot, Bingbot) megkülönbözteti a <em>Block</em> és a <em>Disallow</em> lehetőséget.</p>
<p>A keresőindexelés azt jelenti, hogy valaki megtalálja a cikket. A tréning azt, hogy egy modell tanul belőle, és megismételheti a lényegét anélkül, hogy olvasót küldene. A Cloudflare <a href="https://blog.cloudflare.com/accountable-mixed-use-ai-crawlers/">Have it both ways</a> bejegyzése szerint a Disallow AI Training a „no training” választást írja a robots.txt-be. A Google, az Apple és a Microsoft felelős (Accountable) vegyes crawlereinél meghagyja a keresőindexelést. A Training teljes <em>Block</em> beállítása a kereséstől is elvághatná őket.</p>
<p>A saját webhelyeimen ez a feszültség valódi. Azt akarom, hogy a Google indexelje a nefrológiai portált, a <a href="https://nefro.polascin.net/">nefro.polascin.net</a> oldalt, hogy a betegek megtalálják az információt. Nem akarom, hogy egy modell lenyelje a cikkeket, és közvetlenül válaszoljon a betegnek, a webhelyemen kívül.</p>
<p>Az új vezérlés <strong>Search</strong>, <strong>Training</strong> és <strong>Agent</strong> részekre oszlik. Engedélyezheti az indexelést, és elutasíthatja a tréninget. Megengedheti, hogy egy ügynök egy felhasználó konkrét kérdésére letöltsön egy oldalt, és megakadályozhatja a tömeges kaparást.</p>
<p>14 webhelyet kezelek. Betegportálokat, termékoldalakat, egy könyvkatalógust. Mindegyik másként áll az AI-crawlerekhez. Az oktatási portálnak annyi olvasója legyen, amennyi csak lehet. A termékoldalnak, például a <a href="https://nephroctor.com/">nephroctor.com</a> vagy az <a href="https://arenibus.polascin.net/">arenibus.polascin.net</a> oldalnak nem kell táplálnia a versenytárs modelljét. A <a href="https://books.polascin.net/">books.polascin.net</a> katalógus legyen megtalálható. Szabad tréninganyag ne legyen.</p>
<p>A régi kapcsolónak két állása volt. Az új beállítás megkülönbözteti, mire szabad a tartalmat használni.</p>
<p>Ha a webhelye Cloudflare-en fut, és a szeptemberi frissítés óta nem nézte meg az AI-crawlerek beállítását, nézze meg.</p>
HTML,
        ],
        'it' => [
            'title' => 'Cloudflare ha sostituito «Block AI Bots» con «Disallow AI Training». Se pubblicate online, controllatelo.',
            'image_alt' => 'Scrivania di un editore di notte: un laptop con la silhouette di un sito e uno scudo di luce viola-turchese che lascia passare solo un sottile fascio di ricerca bloccando crawler ombrosi.',
            'excerpt' => 'Dal 15 settembre 2026 Cloudflare divide il controllo dei crawler IA in Search, Training e Agent. Il «Disallow AI Training» consigliato lascia l’indicizzazione per la ricerca e rifiuta l’addestramento dei modelli.',
            'content' => <<<'HTML'
<p>Dal 15&nbsp;settembre&nbsp;2026 Cloudflare consiglia l’impostazione <strong>Disallow AI Training</strong>. I motori di ricerca possono ancora indicizzare le pagine, perché si possano trovare. Non devono prendere i contenuti per addestrare modelli.</p>
<p>Nell’ultimo anno l’impostazione predefinita era semplice: bloccare i crawler IA. Non lasciare che GPTBot, ClaudeBot e i bot di addestramento raschiassero i contenuti.</p>
<p>Cloudflare <a href="https://developers.cloudflare.com/bots/additional-configurations/block-ai-bots/">sta sostituendo a poco a poco</a> il vecchio interruttore «Block AI Bots» con regole separate per Search, Training e Agent. Per i crawler a uso misto (Googlebot, Applebot, Bingbot) distingue <em>Block</em> e <em>Disallow</em>.</p>
<p>L’indicizzazione per la ricerca vuol dire che qualcuno trova il vostro articolo. L’addestramento vuol dire che un modello impara da esso e può ripeterne la sostanza senza mandarvi un lettore. Secondo il post di Cloudflare <a href="https://blog.cloudflare.com/accountable-mixed-use-ai-crawlers/">Have it both ways</a>, Disallow AI Training scrive la scelta «no training» in robots.txt. Per i crawler misti responsabili (Accountable) di Google, Apple e Microsoft lascia l’indicizzazione per la ricerca. Un <em>Block</em> completo su Training potrebbe tagliarli anche dalla ricerca.</p>
<p>Sui miei siti questa tensione è reale. Voglio che Google indicizzi il portale di nefrologia <a href="https://nefro.polascin.net/">nefro.polascin.net</a>, così i pazienti trovano le informazioni. Non voglio che un modello inghiotta gli articoli e risponda al paziente direttamente, fuori dal mio sito.</p>
<p>Il controllo nuovo è diviso in <strong>Search</strong>, <strong>Training</strong> e <strong>Agent</strong>. Potete consentire l’indicizzazione e rifiutare l’addestramento. Potete lasciare che un agent recuperi una pagina per la richiesta di un utente e fermare lo scraping di massa.</p>
<p>Gestisco 14 siti. Portali per i pazienti, siti di prodotto, un catalogo di libri. Ognuno sta in modo diverso verso i crawler IA. Un portale educativo deve avere quanti più lettori è possibile. Un sito di prodotto, per esempio <a href="https://nephroctor.com/">nephroctor.com</a> o <a href="https://arenibus.polascin.net/">arenibus.polascin.net</a>, non deve alimentare il modello di un concorrente. Il catalogo <a href="https://books.polascin.net/">books.polascin.net</a> deve potersi trovare. Non deve essere materiale libero di addestramento.</p>
<p>Il vecchio interruttore aveva due posizioni. L’impostazione nuova distingue a che cosa si può usare il contenuto.</p>
<p>Se il sito è su Cloudflare e dall’aggiornamento di settembre non avete controllato le impostazioni dei crawler IA, guardatele.</p>
HTML,
        ],
        'uk' => [
            'title' => 'Cloudflare замінив «Block AI Bots» на «Disallow AI Training». Якщо публікуєте онлайн, перевірте.',
            'image_alt' => 'Нічний стіл видавця: ноутбук із силуетом сайту та фіолетово-бірюзовий щит світла, що пропускає лише вузький промінь пошуку й блокує тіні crawlerів.',
            'excerpt' => 'З 15 вересня 2026 Cloudflare ділить керування AI-crawlerами на Search, Training і Agent. Рекомендоване «Disallow AI Training» лишає індексацію для пошуку й відмовляє в тренуванні моделей.',
            'content' => <<<'HTML'
<p>З 15&nbsp;вересня&nbsp;2026 Cloudflare рекомендує налаштування <strong>Disallow AI Training</strong>. Пошукові системи й далі можуть індексувати сторінки, щоб їх можна було знайти. Вміст із них не слід брати на тренування моделей.</p>
<p>Минулого року типове налаштування було просте: блокувати AI-crawlerів. Не пускати GPTBot, ClaudeBot і тренувальних ботів зскрібати вміст.</p>
<p>Старіший перемикач «Block AI Bots» Cloudflare <a href="https://developers.cloudflare.com/bots/additional-configurations/block-ai-bots/">поступово замінює</a> окремими правилами Search, Training і Agent. Для змішаних crawlerів (Googlebot, Applebot, Bingbot) він розрізняє <em>Block</em> і <em>Disallow</em>.</p>
<p>Індексація для пошуку означає, що хтось знайде вашу статтю. Тренування означає, що модель учиться з неї й може повторити суть, не надіславши вам читача. За дописом Cloudflare <a href="https://blog.cloudflare.com/accountable-mixed-use-ai-crawlers/">Have it both ways</a> Disallow AI Training записує вибір «no training» у robots.txt. Для відповідальних (Accountable) змішаних crawlerів Google, Apple і Microsoft лишає індексацію для пошуку. Повний <em>Block</em> для Training міг би відрізати їх і від пошуку.</p>
<p>На власних сайтах ця напруга для мене справжня. Я хочу, щоб Google індексував нефрологічний портал <a href="https://nefro.polascin.net/">nefro.polascin.net</a>, щоб пацієнти знаходили інформацію. Не хочу, щоб модель ковтала статті й відповідала пацієнтові напряму, поза моїм сайтом.</p>
<p>Нове керування поділене на <strong>Search</strong>, <strong>Training</strong> і <strong>Agent</strong>. Можна дозволити індексацію й відмовити в тренуванні. Можна дозволити агенту стягнути сторінку для одного запиту користувача й не дати масового зскрібання.</p>
<p>Я веду 14 сайтів. Портали для пацієнтів, продуктові сайти, каталог книжок. Кожен інакше стоїть до AI-crawlerів. Освітній портал має мати якнайбільше читачів. Продуктовий сайт, наприклад <a href="https://nephroctor.com/">nephroctor.com</a> або <a href="https://arenibus.polascin.net/">arenibus.polascin.net</a>, не мусить годувати модель конкурента. Каталог <a href="https://books.polascin.net/">books.polascin.net</a> має бути в пошуку. Вільним матеріалом для тренування він бути не має.</p>
<p>Старий перемикач мав два положення. Нове налаштування розрізняє, для чого вміст можна використати.</p>
<p>Якщо ваш сайт на Cloudflare і від вересневого оновлення ви не перевіряли налаштування AI-crawlerів, подивіться їх.</p>
HTML,
        ],
    ],
];
