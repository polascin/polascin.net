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
 * Zdroj: CI/CD a audit 15.–16. 9. 2026 (Claude Opus 5, 14 nálezov, v0.17.128).
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
            'excerpt' => 'Ako sólový lekár-vývojár používam Claude Opus 5 a Cursor na bezpečnostný audit Arenibusu. Včera agent nahlásil 14 nálezov, tri z nich s vysokou prioritou, napísal záplaty a pred spaním odišla verzia v0.17.128.',
            'content' => <<<'HTML'
<p>Včera v noci našiel AI agent v mojej aplikácii tri závažné bezpečnostné zraniteľnosti, napísal záplaty a pomohol mi ich dostať do produkcie ešte pred ránom.</p>
<p>Staviam <a href="https://arenibus.polascin.net/">Arenibus</a>, informačný systém v .NET pre nefrológiu a manažment dialýzy. Ako sólový vývojár, ktorý je zároveň lekár, nemám tím DevSecOps. Tú medzeru som začal zapĺňať Claude Opus 5 a Cursorom.</p>
<p>Včera som spustil úplný bezpečnostný audit. AI prešla kód a nahlásila 14 nálezov — tri z nich s vysokou prioritou. Ku každému napísala záplatu. Pred zlúčením som si prečítal každý riadok.</p>
<p>CI pipeline spustila 1&nbsp;011 testov Vitest. Všetky zelené. Predtým, než som išiel spať, odišla verzia v0.17.128.</p>
<p>Toto nie je hypotéza. Ani demo. Je to skutočný postup, ktorým ako jeden človek posielam do sveta klinický softvér.</p>
<p>Chcem byť úprimný v jednom: AI nenahradila úsudok. Vyniesla na povrch veci, ktoré by som prehliadol, a napísala boilerplate, ktorý som písať nechcel. Ale rozhodnúť, či nález záleží, či je záplata správna a či je bezpečné nasadiť — to ostáva na mne.</p>
<p>Skutočný posun nie je v tom, že „AI píše kód“. Je v tom, že priepasť medzi tým, čo zvládne sólový zakladateľ, a tým, čo zvládne malý tím, sa dramaticky zúžila.</p>
<p>Ak staviate niečo sami: ktorú jednu úlohu by ste AI agentovi odovzdali ako prvú? Napíšte mi cez <a href="contact.php">kontakt</a>.</p>
HTML,
        ],
        'en' => [
            'title' => 'Last night an AI agent found 3 high-priority vulnerabilities. We shipped the fix before morning.',
            'image_alt' => 'A night-time clinical-software audit: an AI agent flags three high-priority vulnerabilities on the screens.',
            'excerpt' => 'As a solo physician-developer I use Claude Opus 5 and Cursor to security-audit Arenibus. Yesterday the agent flagged 14 findings, three of them high priority, wrote the patches, and v0.17.128 went out before I slept.',
            'content' => <<<'HTML'
<p>Last night an AI agent found three high-priority security vulnerabilities in my app, wrote the patches, and helped me ship the fix before morning.</p>
<p>I have been building <a href="https://arenibus.polascin.net/">Arenibus</a>, a .NET information system for nephrology and dialysis management. As a solo developer who is also a physician, I do not have a DevSecOps team. So I have been using Claude Opus 5 and Cursor to fill that gap.</p>
<p>Yesterday I ran a full security audit. The AI reviewed the codebase and flagged 14 findings — three of them high priority. It then wrote the patches for each one. I reviewed every line before merging.</p>
<p>The CI pipeline ran 1,011 Vitest tests. All green. I deployed v0.17.128 before I went to bed.</p>
<p>This is not a hypothetical. It is not a demo. It is the actual workflow I use to ship clinical software as a one-person team.</p>
<p>The part I want to be honest about: the AI did not replace judgment. It surfaced things I would have missed and wrote boilerplate I did not want to write. But deciding whether a finding matters, whether the patch is correct, and whether it is safe to deploy — that is still on me.</p>
<p>The real shift is not “AI writes code.” It is that the gap between what a solo founder can build and what a small team can build has narrowed dramatically.</p>
<p>If you are building something alone, what is the one task you would hand to an AI agent first? Write to me via the <a href="contact.php">contact form</a>.</p>
HTML,
        ],
        'cs' => [
            'title' => 'AI agent našel 3 závažné bezpečnostní nálezy. Opravu jsem nasadil ještě před ránem.',
            'image_alt' => 'Noční audit klinického softwaru: světelný AI agent ukazuje tři závažné zranitelnosti na obrazovkách.',
            'excerpt' => 'Jako sólový lékař-vývojář používám Claude Opus 5 a Cursor na bezpečnostní audit Arenibusu. Včera agent nahlásil 14 nálezů, tři z nich s vysokou prioritou, napsal záplaty a před spaním odešla verze v0.17.128.',
            'content' => <<<'HTML'
<p>Včera v noci našel AI agent v mé aplikaci tři závažné bezpečnostní zranitelnosti, napsal záplaty a pomohl mi je dostat do produkce ještě před ránem.</p>
<p>Stavím <a href="https://arenibus.polascin.net/">Arenibus</a>, informační systém v .NET pro nefrologii a management dialýzy. Jako sólový vývojář, který je zároveň lékař, nemám tým DevSecOps. Tu mezeru jsem začal zaplňovat Claude Opus 5 a Cursorem.</p>
<p>Včera jsem spustil úplný bezpečnostní audit. AI prošla kód a nahlásila 14 nálezů — tři z nich s vysokou prioritou. Ke každému napsala záplatu. Před sloučením jsem si přečetl každý řádek.</p>
<p>CI pipeline spustila 1&nbsp;011 testů Vitest. Všechny zelené. Než jsem šel spát, odešla verze v0.17.128.</p>
<p>Tohle není hypotéza. Ani demo. Je to skutečný postup, kterým jako jeden člověk posílám do světa klinický software.</p>
<p>Chci být upřímný v jednom: AI nenahradila úsudek. Vynesla na povrch věci, které bych přehlédl, a napsala boilerplate, který jsem psát nechtěl. Ale rozhodnout, zda nález záleží, zda je záplata správná a zda je bezpečné nasadit — to zůstává na mně.</p>
<p>Skutečný posun není v tom, že „AI píše kód“. Je v tom, že propast mezi tím, co zvládne sólový zakladatel, a tím, co zvládne malý tým, se dramaticky zúžila.</p>
<p>Pokud stavíte něco sami: který jeden úkol byste AI agentovi předali jako první? Napište mi přes <a href="contact.php">kontakt</a>.</p>
HTML,
        ],
        'de' => [
            'title' => 'Ein KI-Agent fand 3 schwerwiegende Sicherheitslücken. Den Fix habe ich noch vor dem Morgen ausgeliefert.',
            'image_alt' => 'Nächtliches Audit klinischer Software: ein leuchtender KI-Agent markiert drei schwerwiegende Schwachstellen auf den Bildschirmen.',
            'excerpt' => 'Als Solo-Arzt und Entwickler nutze ich Claude Opus 5 und Cursor für das Sicherheitsaudit von Arenibus. Gestern meldete der Agent 14 Befunde, drei davon mit hoher Priorität, schrieb die Patches, und vor dem Schlafengehen ging v0.17.128 raus.',
            'content' => <<<'HTML'
<p>Gestern Nacht hat ein KI-Agent in meiner Anwendung drei schwerwiegende Sicherheitslücken gefunden, Patches geschrieben und mir geholfen, den Fix noch vor dem Morgen in Produktion zu bringen.</p>
<p>Ich baue <a href="https://arenibus.polascin.net/">Arenibus</a>, ein .NET-Informationssystem für Nephrologie und Dialysemanagement. Als Solo-Entwickler, der zugleich Arzt ist, habe ich kein DevSecOps-Team. Diese Lücke fülle ich mit Claude Opus 5 und Cursor.</p>
<p>Gestern habe ich ein vollständiges Sicherheitsaudit gestartet. Die KI hat den Code durchgesehen und 14 Befunde gemeldet — drei davon mit hoher Priorität. Zu jedem hat sie einen Patch geschrieben. Vor dem Merge habe ich jede Zeile gelesen.</p>
<p>Die CI-Pipeline hat 1&nbsp;011 Vitest-Tests ausgeführt. Alle grün. Bevor ich schlafen ging, war Version v0.17.128 draußen.</p>
<p>Das ist keine Hypothese. Auch kein Demo. Es ist der tatsächliche Ablauf, mit dem ich als Einzelperson klinische Software ausliefere.</p>
<p>In einem Punkt will ich ehrlich sein: Die KI hat das Urteil nicht ersetzt. Sie hat Dinge an die Oberfläche gebracht, die ich übersehen hätte, und Boilerplate geschrieben, den ich nicht schreiben wollte. Ob ein Befund zählt, ob der Patch stimmt und ob ein Deploy sicher ist — das bleibt bei mir.</p>
<p>Die eigentliche Verschiebung ist nicht „KI schreibt Code“. Es ist, dass die Kluft zwischen dem, was ein Solo-Gründer schafft, und dem, was ein kleines Team schafft, dramatisch schmaler geworden ist.</p>
<p>Wenn Sie etwas allein bauen: Welche eine Aufgabe würden Sie einem KI-Agenten als erste übergeben? Schreiben Sie mir über das <a href="contact.php">Kontaktformular</a>.</p>
HTML,
        ],
        'fr' => [
            'title' => 'Un agent IA a trouvé 3 failles de sécurité graves. Le correctif était en production avant l\'aube.',
            'image_alt' => 'Audit nocturne d\'un logiciel clinique : un agent IA lumineux signale trois vulnérabilités graves à l\'écran.',
            'excerpt' => 'Médecin-développeur en solo, j\'utilise Claude Opus 5 et Cursor pour auditer la sécurité d\'Arenibus. Hier, l\'agent a signalé 14 constats, dont trois à haute priorité, a écrit les rustines, et la version v0.17.128 est partie avant que je dorme.',
            'content' => <<<'HTML'
<p>La nuit dernière, un agent IA a trouvé trois vulnérabilités de sécurité de haute priorité dans mon application, a écrit les rustines et m'a aidé à les mettre en production avant l'aube.</p>
<p>Je construis <a href="https://arenibus.polascin.net/">Arenibus</a>, un système d'information .NET pour la néphrologie et la gestion de la dialyse. Développeur solo qui est aussi médecin, je n'ai pas d'équipe DevSecOps. J'ai commencé à combler ce vide avec Claude Opus 5 et Cursor.</p>
<p>Hier, j'ai lancé un audit de sécurité complet. L'IA a parcouru le code et signalé 14 constats — dont trois à haute priorité. Pour chacun, elle a écrit un correctif. Avant la fusion, j'ai lu chaque ligne.</p>
<p>La pipeline CI a exécuté 1&nbsp;011 tests Vitest. Tous verts. Avant d'aller dormir, la version v0.17.128 était partie.</p>
<p>Ce n'est pas une hypothèse. Ni une démo. C'est le flux réel par lequel, seul, j'envoie du logiciel clinique dans le monde.</p>
<p>Je veux être honnête sur un point : l'IA n'a pas remplacé le jugement. Elle a fait remonter des choses que j'aurais manquées et écrit le boilerplate que je ne voulais pas écrire. Décider si un constat compte, si le correctif est juste et s'il est sûr de déployer — cela reste à moi.</p>
<p>Le vrai basculement n'est pas « l'IA écrit du code ». C'est que l'écart entre ce qu'un fondateur solo peut faire et ce qu'une petite équipe peut faire s'est dramatiquement réduit.</p>
<p>Si vous construisez quelque chose seul : quelle unique tâche confieriez-vous en premier à un agent IA ? Écrivez-moi via le <a href="contact.php">formulaire de contact</a>.</p>
HTML,
        ],
        'es' => [
            'title' => 'Un agente de IA encontró 3 fallos de seguridad graves. El arreglo salió antes del amanecer.',
            'image_alt' => 'Auditoría nocturna de software clínico: un agente de IA luminoso señala tres vulnerabilidades graves en las pantallas.',
            'excerpt' => 'Como médico-desarrollador en solitario uso Claude Opus 5 y Cursor para auditar la seguridad de Arenibus. Ayer el agente señaló 14 hallazgos, tres de alta prioridad, escribió los parches y salió la versión v0.17.128 antes de que me durmiera.',
            'content' => <<<'HTML'
<p>Anoche un agente de IA encontró tres vulnerabilidades de seguridad de alta prioridad en mi aplicación, escribió los parches y me ayudó a llevarlos a producción antes del amanecer.</p>
<p>Estoy construyendo <a href="https://arenibus.polascin.net/">Arenibus</a>, un sistema de información en .NET para nefrología y gestión de diálisis. Como desarrollador en solitario que también es médico, no tengo un equipo de DevSecOps. Esa brecha la empecé a cubrir con Claude Opus 5 y Cursor.</p>
<p>Ayer lancé una auditoría de seguridad completa. La IA recorrió el código y señaló 14 hallazgos — tres de alta prioridad. Para cada uno escribió un parche. Antes de fusionar leí cada línea.</p>
<p>El pipeline de CI ejecutó 1&nbsp;011 pruebas Vitest. Todas verdes. Antes de irme a dormir salió la versión v0.17.128.</p>
<p>Esto no es una hipótesis. Ni una demo. Es el flujo real con el que, como una sola persona, envío software clínico al mundo.</p>
<p>Quiero ser honesto en una cosa: la IA no sustituyó el juicio. Sacó a la superficie cosas que habría pasado por alto y escribió el boilerplate que no quería escribir. Decidir si un hallazgo importa, si el parche es correcto y si es seguro desplegar — eso sigue siendo mío.</p>
<p>El verdadero cambio no es que «la IA escribe código». Es que la brecha entre lo que puede un fundador en solitario y lo que puede un equipo pequeño se ha estrechado de forma dramática.</p>
<p>Si construye algo solo: ¿cuál es la única tarea que entregaría primero a un agente de IA? Escríbame a través del <a href="contact.php">formulario de contacto</a>.</p>
HTML,
        ],
        'pl' => [
            'title' => 'Agent AI znalazł 3 poważne luki bezpieczeństwa. Poprawkę wdrożyłem jeszcze przed świtem.',
            'image_alt' => 'Nocny audyt oprogramowania klinicznego: świetlisty agent AI wskazuje trzy poważne podatności na ekranach.',
            'excerpt' => 'Jako solowy lekarz-programista używam Claude Opus 5 i Cursora do audytu bezpieczeństwa Arenibusa. Wczoraj agent zgłosił 14 ustaleń, trzy z wysokim priorytetem, napisał łatki, a przed snem wyszła wersja v0.17.128.',
            'content' => <<<'HTML'
<p>Wczoraj w nocy agent AI znalazł w mojej aplikacji trzy poważne luki bezpieczeństwa, napisał łatki i pomógł mi wprowadzić je na produkcję jeszcze przed świtem.</p>
<p>Buduję <a href="https://arenibus.polascin.net/">Arenibus</a>, system informacyjny w .NET dla nefrologii i zarządzania dializą. Jako solowy programista, który jest zarazem lekarzem, nie mam zespołu DevSecOps. Tę lukę zacząłem wypełniać Claude Opus 5 i Cursorem.</p>
<p>Wczoraj uruchomiłem pełny audyt bezpieczeństwa. AI przeszła kod i zgłosiła 14 ustaleń — trzy z wysokim priorytetem. Do każdego napisała łatkę. Przed scaleniem przeczytałem każdy wiersz.</p>
<p>Pipeline CI uruchomił 1&nbsp;011 testów Vitest. Wszystkie zielone. Zanim poszedłem spać, wyszła wersja v0.17.128.</p>
<p>To nie hipoteza. Ani demo. To rzeczywisty proces, którym jako jedna osoba wysyłam w świat oprogramowanie kliniczne.</p>
<p>Chcę być szczery w jednym: AI nie zastąpiła osądu. Wydobyła na wierzch rzeczy, które bym przeoczył, i napisała boilerplate, którego nie chciałem pisać. Ale zdecydować, czy ustalenie ma znaczenie, czy łatka jest poprawna i czy wdrożenie jest bezpieczne — to zostaje przy mnie.</p>
<p>Prawdziwa zmiana nie polega na tym, że „AI pisze kod”. Polega na tym, że przepaść między tym, co ogarnie solowy założyciel, a tym, co ogarnie mały zespół, dramatycznie się zwęziła.</p>
<p>Jeśli budujecie coś sami: które jedno zadanie przekazalibyście agentowi AI jako pierwsze? Napiszcie do mnie przez <a href="contact.php">kontakt</a>.</p>
HTML,
        ],
        'hu' => [
            'title' => 'Egy AI-ügynök 3 súlyos biztonsági hibát talált. A javítást még hajnal előtt telepítettem.',
            'image_alt' => 'Éjszakai klinikai szoftveraudit: egy fényes AI-ügynök három súlyos sebezhetőséget jelez a képernyőkön.',
            'excerpt' => 'Szóló orvos-fejlesztőként Claude Opus 5-öt és Cursort használok az Arenibus biztonsági auditjához. Tegnap az ügynök 14 megállapítást jelzett, három magas prioritásút, megírta a foltokat, és alvás előtt kiment a v0.17.128.',
            'content' => <<<'HTML'
<p>Tegnap éjjel egy AI-ügynök három súlyos biztonsági sebezhetőséget talált az alkalmazásomban, megírta a foltokat, és segített hajnal előtt élesbe tenni a javítást.</p>
<p>Az <a href="https://arenibus.polascin.net/">Arenibust</a> építem, egy .NET információs rendszert nefrológiára és dialíziskezelésre. Szóló fejlesztőként, aki egyben orvos, nincs DevSecOps-csapatom. Ezt a rést Claude Opus 5-tel és Cursorral kezdtem betölteni.</p>
<p>Tegnap teljes biztonsági auditot indítottam. Az AI átnézte a kódot, és 14 megállapítást jelzett — három magas prioritásút. Mindegyikhez írt egy foltot. Összefésülés előtt minden sort elolvastam.</p>
<p>A CI-folyamat 1&nbsp;011 Vitest tesztet futtatott. Mind zöld. Mielőtt aludni mentem, kiment a v0.17.128.</p>
<p>Ez nem hipotézis. Nem demo. Ez a valós folyamat, amellyel egy emberként klinikai szoftvert küldök a világba.</p>
<p>Egy dologban őszinte akarok lenni: az AI nem helyettesítette az ítélőképességet. Felszínre hozott dolgokat, amelyeket elnéztem volna, és megírta a boilerplate-et, amelyet nem akartam megírni. De eldönteni, hogy egy megállapítás számít-e, helyes-e a folt, és biztonságos-e telepíteni — az rajtam marad.</p>
<p>Az igazi eltolódás nem az, hogy „az AI kódot ír”. Hanem az, hogy a szóló alapító és egy kis csapat képessége közötti szakadék drámaian beszűkült.</p>
<p>Ha egyedül épít valamit: melyik egyetlen feladatot adná át először egy AI-ügynöknek? Írjon nekem a <a href="contact.php">kapcsolati űrlapon</a>.</p>
HTML,
        ],
        'it' => [
            'title' => 'Un agente IA ha trovato 3 vulnerabilità gravi. La correzione è andata in produzione prima dell\'alba.',
            'image_alt' => 'Audit notturno di software clinico: un agente IA luminoso segnala tre vulnerabilità gravi sugli schermi.',
            'excerpt' => 'Come medico-sviluppatore in solitaria uso Claude Opus 5 e Cursor per l\'audit di sicurezza di Arenibus. Ieri l\'agente ha segnalato 14 rilievi, tre ad alta priorità, ha scritto le patch e prima di dormire è uscita la v0.17.128.',
            'content' => <<<'HTML'
<p>Ieri notte un agente IA ha trovato nella mia applicazione tre vulnerabilità di sicurezza ad alta priorità, ha scritto le patch e mi ha aiutato a portarle in produzione prima dell'alba.</p>
<p>Sto costruendo <a href="https://arenibus.polascin.net/">Arenibus</a>, un sistema informativo in .NET per la nefrologia e la gestione della dialisi. Come sviluppatore in solitaria che è anche medico, non ho un team DevSecOps. Quella lacuna ho iniziato a colmarla con Claude Opus 5 e Cursor.</p>
<p>Ieri ho lanciato un audit di sicurezza completo. L'IA ha esaminato il codice e segnalato 14 rilievi — tre ad alta priorità. Per ciascuno ha scritto una patch. Prima del merge ho letto ogni riga.</p>
<p>La pipeline CI ha eseguito 1&nbsp;011 test Vitest. Tutti verdi. Prima di andare a dormire è uscita la versione v0.17.128.</p>
<p>Non è un'ipotesi. Né una demo. È il flusso reale con cui, da solo, mando nel mondo software clinico.</p>
<p>Voglio essere onesto su un punto: l'IA non ha sostituito il giudizio. Ha portato in superficie cose che avrei trascurato e ha scritto il boilerplate che non volevo scrivere. Decidere se un rilievo conta, se la patch è corretta e se è sicuro fare il deploy — resta a me.</p>
<p>Il vero spostamento non è «l'IA scrive codice». È che il divario tra ciò che un fondatore in solitaria può fare e ciò che può fare un piccolo team si è ridotto in modo drammatico.</p>
<p>Se costruite qualcosa da soli: quale unico compito affidereste per primo a un agente IA? Scrivetemi tramite il <a href="contact.php">modulo di contatto</a>.</p>
HTML,
        ],
        'uk' => [
            'title' => 'AI-агент знайшов 3 серйозні вразливості. Виправлення я випустив ще до світанку.',
            'image_alt' => 'Нічний аудит клінічного ПЗ: світловий AI-агент вказує на три серйозні вразливості на екранах.',
            'excerpt' => 'Як лікар-розробник наодинці я використовую Claude Opus 5 і Cursor для аудиту безпеки Arenibus. Учора агент повідомив 14 знахідок, три з високим пріоритетом, написав латки, і перед сном вийшла версія v0.17.128.',
            'content' => <<<'HTML'
<p>Учора вночі AI-агент знайшов у моєму застосунку три серйозні вразливості безпеки, написав латки й допоміг вивести їх у прод ще до світанку.</p>
<p>Я будую <a href="https://arenibus.polascin.net/">Arenibus</a> — інформаційну систему на .NET для нефрології та ведення діалізу. Як соло-розробник, який водночас лікар, я не маю команди DevSecOps. Цю прогалину я почав закривати Claude Opus 5 і Cursor.</p>
<p>Учора я запустив повний аудит безпеки. AI переглянула код і повідомила 14 знахідок — три з високим пріоритетом. До кожної написала латку. Перед злиттям я прочитав кожен рядок.</p>
<p>CI-конвеєр виконав 1&nbsp;011 тестів Vitest. Усі зелені. Перш ніж я пішов спати, вийшла версія v0.17.128.</p>
<p>Це не гіпотеза. І не демо. Це реальний процес, яким я як одна людина відправляю у світ клінічне ПЗ.</p>
<p>Хочу бути чесним в одному: AI не замінила судження. Вона винесла на поверхню речі, які я б проґавив, і написала boilerplate, який я не хотів писати. Але вирішити, чи знахідка має значення, чи латка правильна і чи безпечно випускати — лишається на мені.</p>
<p>Справжній зсув не в тому, що «AI пише код». А в тому, що прірва між тим, що може соло-засновник, і тим, що може мала команда, драматично звузилася.</p>
<p>Якщо ви будуєте щось самі: яке одне завдання ви передали б AI-агенту першим? Напишіть мені через <a href="contact.php">контакт</a>.</p>
HTML,
        ],
    ],
];
