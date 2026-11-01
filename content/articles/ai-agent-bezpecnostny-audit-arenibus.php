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
 * Blogový príspevok o bezpečnostnom audite Arenibusu s AI agentom.
 * Zdroj: CI/CD a audit 15. až 16. 9. 2026 (Claude Opus 5, 14 nálezov, v0.17.128).
 */
return [
    'slug' => 'ai-agent-bezpecnostny-audit-arenibus',
    'author' => 'MUDr. Ľubomír Polaščín',
    'category' => 'blog',
    'is_top' => 0,
    'published_at' => '2026-09-17 18:50:00',
    'image' => 'images/articles/ai-agent-bezpecnostny-audit-arenibus.webp',
    'translations' => [
        'sk' => [
            'title' => 'AI agent našiel 3 závažné bezpečnostné nálezy. Opravu som nasadil ešte pred ránom.',
            'image_alt' => 'Nočný audit klinického softvéru: svetelný AI agent ukazuje tri závažné zraniteľnosti na obrazovkách.',
            'excerpt' => 'Ako lekár, ktorý programuje sám, používam Claude Opus 5 a Cursor na bezpečnostný audit Arenibusu. Včera agent nahlásil 14 nálezov, tri z nich s vysokou prioritou, napísal záplaty a pred spaním odišla verzia v0.17.128.',
            'content' => <<<'HTML'
<p>Včera v noci našiel AI agent v mojej aplikácii tri závažné bezpečnostné zraniteľnosti, napísal záplaty a pomohol mi ich dostať do produkcie ešte pred ránom.</p>
<p>Staviam <a href="https://arenibus.polascin.net/">Arenibus</a>, informačný systém v .NET na nefrológiu a správu dialýzy. Som lekár a programujem sám, tím DevSecOps nemám. Tú medzeru som začal zapĺňať Claude Opus 5 a Cursorom.</p>
<p>Včera som spustil úplný bezpečnostný audit. Agent prešiel kód a nahlásil 14 nálezov, tri z nich s vysokou prioritou. Ku každému napísal záplatu. Pred zlúčením som si prečítal každý riadok.</p>
<p>Priebežná integrácia spustila 1&nbsp;011 testov Vitest. Všetky zelené. Predtým, než som išiel spať, odišla verzia v0.17.128.</p>
<p>Je to postup, ktorým ako jeden človek naozaj posielam do sveta klinický softvér: nie hypotéza a nie ukážka.</p>
<p>Úsudok agent nenahradil. Vyniesol na povrch veci, ktoré by som prehliadol, a napísal šablónový kód, ktorý som písať nechcel. Či nález záleží, či je záplata správna a či je bezpečné ju nasadiť, to ostáva na mne.</p>
<p>Posun nie je v hesle, že AI píše kód. Priepasť medzi tým, čo zvládne jeden človek, a tým, čo zvládne malý tím, sa zúžila.</p>
<p>Ak staviate niečo sami, ktorú jednu úlohu by ste AI agentovi odovzdali ako prvú?</p>
HTML,
        ],
        'en' => [
            'title' => 'Last night an AI agent found 3 high-priority vulnerabilities. I shipped the fix before morning.',
            'image_alt' => 'A night-time clinical-software audit: an AI agent flags three high-priority vulnerabilities on the screens.',
            'excerpt' => 'As a physician who programs alone, I use Claude Opus 5 and Cursor to security-audit Arenibus. Yesterday the agent flagged 14 findings, three of them high priority, wrote the patches, and v0.17.128 went out before I slept.',
            'content' => <<<'HTML'
<p>Last night an AI agent found three high-priority security vulnerabilities in my application, wrote the patches, and helped me get them into production before morning.</p>
<p>I am building <a href="https://arenibus.polascin.net/">Arenibus</a>, a .NET information system for nephrology and dialysis management. I am a physician and I program alone, so I have no DevSecOps team. I have started to fill that gap with Claude Opus 5 and Cursor.</p>
<p>Yesterday I ran a full security audit. The agent went through the code and reported 14 findings, three of them high priority. It wrote a patch for each one. I read every line before merging.</p>
<p>Continuous integration ran 1,011 Vitest tests. All green. Before I went to sleep, version v0.17.128 was out.</p>
<p>This is the workflow I actually use to ship clinical software as one person: not a hypothetical, and not a demo.</p>
<p>The agent did not replace judgment. It brought up things I would have missed and wrote the boilerplate I did not want to write. Whether a finding matters, whether the patch is right, and whether it is safe to deploy stays with me.</p>
<p>The shift is not the slogan that AI writes code. The gap between what one person can do and what a small team can do has narrowed.</p>
<p>If you are building something alone, which single task would you hand to an AI agent first?</p>
HTML,
        ],
        'cs' => [
            'title' => 'AI agent našel 3 závažné bezpečnostní nálezy. Opravu jsem nasadil ještě před ránem.',
            'image_alt' => 'Noční audit klinického softwaru: světelný AI agent ukazuje tři závažné zranitelnosti na obrazovkách.',
            'excerpt' => 'Jako lékař, který programuje sám, používám Claude Opus 5 a Cursor na bezpečnostní audit Arenibusu. Včera agent nahlásil 14 nálezů, tři z nich s vysokou prioritou, napsal záplaty a před spaním odešla verze v0.17.128.',
            'content' => <<<'HTML'
<p>Včera v noci našel AI agent v mé aplikaci tři závažné bezpečnostní zranitelnosti, napsal záplaty a pomohl mi je dostat do produkce ještě před ránem.</p>
<p>Stavím <a href="https://arenibus.polascin.net/">Arenibus</a>, informační systém v .NET pro nefrologii a správu dialýzy. Jsem lékař a programuji sám, tým DevSecOps nemám. Tu mezeru jsem začal zaplňovat Claude Opus 5 a Cursorem.</p>
<p>Včera jsem spustil úplný bezpečnostní audit. Agent prošel kód a nahlásil 14 nálezů, tři z nich s vysokou prioritou. Ke každému napsal záplatu. Před sloučením jsem si přečetl každý řádek.</p>
<p>Průběžná integrace spustila 1&nbsp;011 testů Vitest. Všechny zelené. Než jsem šel spát, odešla verze v0.17.128.</p>
<p>Je to postup, kterým jako jeden člověk opravdu posílám do světa klinický software: ne hypotéza a ne ukázka.</p>
<p>Úsudek agent nenahradil. Vynesl na povrch věci, které bych přehlédl, a napsal šablonový kód, který jsem psát nechtěl. Zda nález záleží, zda je záplata správná a zda je bezpečné ji nasadit, to zůstává na mně.</p>
<p>Posun není v hesle, že AI píše kód. Propast mezi tím, co zvládne jeden člověk, a tím, co zvládne malý tým, se zúžila.</p>
<p>Pokud stavíte něco sami, který jeden úkol byste AI agentovi předali jako první?</p>
HTML,
        ],
        'de' => [
            'title' => 'Ein KI-Agent fand 3 schwerwiegende Sicherheitslücken. Den Fix habe ich noch vor dem Morgen ausgeliefert.',
            'image_alt' => 'Nächtliches Audit klinischer Software: ein leuchtender KI-Agent markiert drei schwerwiegende Schwachstellen auf den Bildschirmen.',
            'excerpt' => 'Als Arzt, der allein programmiert, nutze ich Claude Opus 5 und Cursor für das Sicherheitsaudit von Arenibus. Gestern meldete der Agent 14 Befunde, drei davon mit hoher Priorität, schrieb die Patches, und vor dem Schlafengehen ging v0.17.128 raus.',
            'content' => <<<'HTML'
<p>Gestern Nacht hat ein KI-Agent in meiner Anwendung drei schwerwiegende Sicherheitslücken gefunden, Patches geschrieben und mir geholfen, sie noch vor dem Morgen in die Produktion zu bringen.</p>
<p>Ich baue <a href="https://arenibus.polascin.net/">Arenibus</a>, ein .NET-Informationssystem für Nephrologie und die Verwaltung der Dialyse. Ich bin Arzt und programmiere allein, ein DevSecOps-Team habe ich nicht. Diese Lücke fülle ich mit Claude Opus 5 und Cursor.</p>
<p>Gestern habe ich ein vollständiges Sicherheitsaudit gestartet. Der Agent hat den Code durchgesehen und 14 Befunde gemeldet, drei davon mit hoher Priorität. Zu jedem hat er einen Patch geschrieben. Vor dem Zusammenführen habe ich jede Zeile gelesen.</p>
<p>Die kontinuierliche Integration hat 1&nbsp;011 Vitest-Tests ausgeführt. Alle grün. Bevor ich schlafen ging, war die Version v0.17.128 draußen.</p>
<p>So liefere ich als Einzelner tatsächlich klinische Software aus: kein Gedankenspiel und keine Vorführung.</p>
<p>Das Urteil hat der Agent nicht ersetzt. Er hat Dinge nach oben geholt, die ich übersehen hätte, und den vorgefertigten Code geschrieben, den ich nicht schreiben wollte. Ob ein Befund zählt, ob der Patch stimmt und ob die Auslieferung sicher ist, bleibt bei mir.</p>
<p>Die Verschiebung steckt nicht im Satz „KI schreibt Code“. Der Abstand zwischen dem, was ein Einzelner schafft, und dem, was ein kleines Team schafft, ist schmaler geworden.</p>
<p>Wenn Sie etwas allein bauen, welche eine Aufgabe würden Sie einem KI-Agenten zuerst übergeben?</p>
HTML,
        ],
        'fr' => [
            'title' => 'Un agent IA a trouvé 3 failles de sécurité graves. Le correctif était en production avant l\'aube.',
            'image_alt' => 'Audit nocturne d\'un logiciel clinique : un agent IA lumineux signale trois vulnérabilités graves à l\'écran.',
            'excerpt' => 'Médecin qui programme seul, j’utilise Claude Opus 5 et Cursor pour auditer la sécurité d’Arenibus. Hier, l’agent a signalé 14 constats, dont trois à haute priorité, a écrit les correctifs, et la version v0.17.128 est partie avant que je dorme.',
            'content' => <<<'HTML'
<p>La nuit dernière, un agent IA a trouvé trois vulnérabilités de sécurité graves dans mon application, a écrit les correctifs et m’a aidé à les mettre en production avant l’aube.</p>
<p>Je construis <a href="https://arenibus.polascin.net/">Arenibus</a>, un système d’information .NET pour la néphrologie et la gestion de la dialyse. Je suis médecin et je programme seul, je n’ai pas d’équipe DevSecOps. J’ai commencé à combler ce vide avec Claude Opus 5 et Cursor.</p>
<p>Hier, j’ai lancé un audit de sécurité complet. L’agent a parcouru le code et signalé 14 constats, dont trois à haute priorité. Pour chacun, il a écrit un correctif. Avant la fusion, j’ai lu chaque ligne.</p>
<p>L’intégration continue a exécuté 1&nbsp;011 tests Vitest. Tous verts. Avant que je m’endorme, la version v0.17.128 était partie.</p>
<p>C’est ainsi que, seul, j’envoie réellement du logiciel clinique dans le monde : ni une hypothèse, ni une démonstration.</p>
<p>L’agent n’a pas remplacé le jugement. Il a fait remonter des choses que j’aurais manquées et a écrit le code répétitif que je ne voulais pas écrire. Décider si un constat compte, si le correctif est juste et s’il est sûr de le déployer, cela reste à moi.</p>
<p>Le déplacement n’est pas dans le slogan selon lequel l’IA écrit le code. L’écart entre ce qu’une personne seule peut faire et ce qu’une petite équipe peut faire s’est réduit.</p>
<p>Si vous construisez quelque chose seul, quelle tâche unique confieriez-vous d’abord à un agent IA ?</p>
HTML,
        ],
        'es' => [
            'title' => 'Un agente de IA encontró 3 fallos de seguridad graves. El arreglo salió antes del amanecer.',
            'image_alt' => 'Auditoría nocturna de software clínico: un agente de IA luminoso señala tres vulnerabilidades graves en las pantallas.',
            'excerpt' => 'Como médico que programa en solitario uso Claude Opus 5 y Cursor para auditar la seguridad de Arenibus. Ayer el agente señaló 14 hallazgos, tres de alta prioridad, escribió los parches y salió la versión v0.17.128 antes de que me durmiera.',
            'content' => <<<'HTML'
<p>Anoche un agente de IA encontró tres vulnerabilidades de seguridad graves en mi aplicación, escribió los parches y me ayudó a llevarlos a producción antes del amanecer.</p>
<p>Estoy construyendo <a href="https://arenibus.polascin.net/">Arenibus</a>, un sistema de información en .NET para nefrología y gestión de diálisis. Soy médico y programo solo, no tengo un equipo de DevSecOps. Esa brecha la empecé a cubrir con Claude Opus 5 y Cursor.</p>
<p>Ayer lancé una auditoría de seguridad completa. El agente recorrió el código y señaló 14 hallazgos, tres de alta prioridad. Para cada uno escribió un parche. Antes de fusionar leí cada línea.</p>
<p>La integración continua ejecutó 1&nbsp;011 pruebas Vitest. Todas verdes. Antes de irme a dormir salió la versión v0.17.128.</p>
<p>Así es como, en solitario, envío de verdad software clínico al mundo: ni una hipótesis ni una demostración.</p>
<p>El agente no sustituyó el juicio. Sacó a la superficie cosas que habría pasado por alto y escribió el código repetitivo que no quería escribir. Decidir si un hallazgo importa, si el parche es correcto y si es seguro desplegarlo sigue siendo mío.</p>
<p>El cambio no está en el lema de que la IA escribe código. La brecha entre lo que puede una persona sola y lo que puede un equipo pequeño se ha estrechado.</p>
<p>Si construye algo solo, ¿cuál es la única tarea que entregaría primero a un agente de IA?</p>
HTML,
        ],
        'pl' => [
            'title' => 'Agent AI znalazł 3 poważne luki bezpieczeństwa. Poprawkę wdrożyłem jeszcze przed świtem.',
            'image_alt' => 'Nocny audyt oprogramowania klinicznego: świetlisty agent AI wskazuje trzy poważne podatności na ekranach.',
            'excerpt' => 'Jako lekarz, który programuje sam, używam Claude Opus 5 i Cursora do audytu bezpieczeństwa Arenibusa. Wczoraj agent zgłosił 14 ustaleń, trzy z wysokim priorytetem, napisał łatki, a przed snem wyszła wersja v0.17.128.',
            'content' => <<<'HTML'
<p>Wczoraj w nocy agent AI znalazł w mojej aplikacji trzy poważne luki bezpieczeństwa, napisał łatki i pomógł mi wprowadzić je na produkcję jeszcze przed świtem.</p>
<p>Buduję <a href="https://arenibus.polascin.net/">Arenibus</a>, system informacyjny w .NET dla nefrologii i zarządzania dializą. Jestem lekarzem i programuję sam, nie mam zespołu DevSecOps. Tę lukę zacząłem wypełniać Claude Opus 5 i Cursorem.</p>
<p>Wczoraj uruchomiłem pełny audyt bezpieczeństwa. Agent przeszedł kod i zgłosił 14 ustaleń, trzy z wysokim priorytetem. Do każdego napisał łatkę. Przed scaleniem przeczytałem każdy wiersz.</p>
<p>Ciągła integracja uruchomiła 1&nbsp;011 testów Vitest. Wszystkie zielone. Zanim poszedłem spać, wyszła wersja v0.17.128.</p>
<p>W ten sposób jako jedna osoba naprawdę wysyłam w świat oprogramowanie kliniczne: nie hipotezę i nie pokaz.</p>
<p>Osądu agent nie zastąpił. Wydobył na wierzch rzeczy, które bym przeoczył, i napisał kod szablonowy, którego nie chciałem pisać. Czy ustalenie ma znaczenie, czy łatka jest poprawna i czy wdrożenie jest bezpieczne, to zostaje przy mnie.</p>
<p>Zmiana nie leży w haśle, że AI pisze kod. Przepaść między tym, co ogarnie jedna osoba, a tym, co ogarnie mały zespół, się zwęziła.</p>
<p>Jeśli budujecie coś sami, które jedno zadanie przekazalibyście agentowi AI jako pierwsze?</p>
HTML,
        ],
        'hu' => [
            'title' => 'Egy AI-ügynök 3 súlyos biztonsági hibát talált. A javítást még hajnal előtt telepítettem.',
            'image_alt' => 'Éjszakai klinikai szoftveraudit: egy fényes AI-ügynök három súlyos sebezhetőséget jelez a képernyőkön.',
            'excerpt' => 'Orvosként, aki egyedül programoz, Claude Opus 5-öt és Cursort használok az Arenibus biztonsági auditjához. Tegnap az ügynök 14 megállapítást jelzett, hármat magas prioritásút, megírta a javításokat, és alvás előtt kiment a v0.17.128.',
            'content' => <<<'HTML'
<p>Tegnap éjjel egy AI-ügynök három súlyos biztonsági sebezhetőséget talált az alkalmazásomban, megírta a javításokat, és segített hajnal előtt élesbe tenni őket.</p>
<p>Az <a href="https://arenibus.polascin.net/">Arenibust</a> építem, egy .NET információs rendszert nefrológiára és dialíziskezelésre. Orvos vagyok, és egyedül programozok, DevSecOps-csapatom nincs. Ezt a rést Claude Opus 5-tel és Cursorral kezdtem betölteni.</p>
<p>Tegnap teljes biztonsági auditot indítottam. Az ügynök átnézte a kódot, és 14 megállapítást jelzett, hármat magas prioritással. Mindegyikhez írt egy javítást. Összefésülés előtt minden sort elolvastam.</p>
<p>A folyamatos integráció 1&nbsp;011 Vitest tesztet futtatott. Mind zöld. Mielőtt aludni mentem, kiment a v0.17.128.</p>
<p>Így küldök egy emberként valóban klinikai szoftvert a világba: nem feltevés és nem bemutató.</p>
<p>Az ítélőképességet az ügynök nem helyettesítette. Felszínre hozott dolgokat, amelyeket elnéztem volna, és megírta az ismétlődő kódot, amelyet nem akartam megírni. Eldönteni, hogy egy megállapítás számít-e, helyes-e a javítás, és biztonságos-e telepíteni, rajtam marad.</p>
<p>Az eltolódás nem abban a jelszóban van, hogy az AI kódot ír. A szakadék aközött, amit egy ember bír, és amit egy kis csapat bír, beszűkült.</p>
<p>Ha egyedül épít valamit, melyik egyetlen feladatot adná át először egy AI-ügynöknek?</p>
HTML,
        ],
        'it' => [
            'title' => 'Un agente IA ha trovato 3 vulnerabilità gravi. La correzione è andata in produzione prima dell\'alba.',
            'image_alt' => 'Audit notturno di software clinico: un agente IA luminoso segnala tre vulnerabilità gravi sugli schermi.',
            'excerpt' => 'Come medico che programma da solo uso Claude Opus 5 e Cursor per l’audit di sicurezza di Arenibus. Ieri l’agente ha segnalato 14 rilievi, tre ad alta priorità, ha scritto le patch e prima di dormire è uscita la v0.17.128.',
            'content' => <<<'HTML'
<p>Ieri notte un agente IA ha trovato nella mia applicazione tre vulnerabilità di sicurezza gravi, ha scritto le patch e mi ha aiutato a portarle in produzione prima dell’alba.</p>
<p>Sto costruendo <a href="https://arenibus.polascin.net/">Arenibus</a>, un sistema informativo in .NET per la nefrologia e la gestione della dialisi. Sono medico e programmo da solo, non ho un team DevSecOps. Quella lacuna ho iniziato a colmarla con Claude Opus 5 e Cursor.</p>
<p>Ieri ho avviato un audit di sicurezza completo. L’agente ha esaminato il codice e segnalato 14 rilievi, tre ad alta priorità. Per ciascuno ha scritto una patch. Prima dell’unione ho letto ogni riga.</p>
<p>L’integrazione continua ha eseguito 1&nbsp;011 test Vitest. Tutti verdi. Prima di andare a dormire è uscita la versione v0.17.128.</p>
<p>È così che, da solo, mando davvero nel mondo software clinico: non un’ipotesi e non una dimostrazione.</p>
<p>Il giudizio l’agente non l’ha sostituito. Ha portato in superficie cose che avrei trascurato e ha scritto il codice ripetitivo che non volevo scrivere. Decidere se un rilievo conta, se la patch è corretta e se è sicuro metterla in produzione resta a me.</p>
<p>Lo spostamento non sta nello slogan che l’IA scrive codice. Il divario tra ciò che può fare una persona sola e ciò che può fare un piccolo team si è ridotto.</p>
<p>Se costruite qualcosa da soli, quale unico compito affidereste per primo a un agente IA?</p>
HTML,
        ],
        'uk' => [
            'title' => 'AI-агент знайшов 3 серйозні вразливості. Виправлення я випустив ще до світанку.',
            'image_alt' => 'Нічний аудит клінічного ПЗ: світловий AI-агент вказує на три серйозні вразливості на екранах.',
            'excerpt' => 'Як лікар, який програмує сам, я використовую Claude Opus 5 і Cursor для аудиту безпеки Arenibus. Учора агент повідомив 14 знахідок, три з високим пріоритетом, написав латки, і перед сном вийшла версія v0.17.128.',
            'content' => <<<'HTML'
<p>Учора вночі AI-агент знайшов у моєму застосунку три серйозні вразливості безпеки, написав латки й допоміг випустити їх ще до світанку.</p>
<p>Я будую <a href="https://arenibus.polascin.net/">Arenibus</a>, інформаційну систему на .NET для нефрології та ведення діалізу. Я лікар і програмую сам, команди DevSecOps не маю. Цю прогалину я почав закривати Claude Opus 5 і Cursor.</p>
<p>Учора я запустив повний аудит безпеки. Агент переглянув код і повідомив про 14 знахідок, три з високим пріоритетом. До кожної написав латку. Перед злиттям я прочитав кожен рядок.</p>
<p>Безперервна інтеграція виконала 1&nbsp;011 тестів Vitest. Усі зелені. Перш ніж я пішов спати, вийшла версія v0.17.128.</p>
<p>Так я як одна людина справді відправляю у світ клінічне програмне забезпечення: не як гіпотезу і не як показ.</p>
<p>Судження агент не замінив. Він виніс на поверхню речі, які я б проґавив, і написав шаблонний код, який я не хотів писати. Вирішити, чи знахідка має значення, чи латка правильна і чи безпечно випускати, лишається на мені.</p>
<p>Зсув не в гаслі, що AI пише код. Прірва між тим, що може одна людина, і тим, що може мала команда, звузилася.</p>
<p>Якщо ви будуєте щось самі, яке одне завдання ви передали б AI-агенту першим?</p>
HTML,
        ],
    ],
];
