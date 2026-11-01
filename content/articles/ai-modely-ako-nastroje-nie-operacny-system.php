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
 * Authority príspevok o model-agnostickom AI workflow.
 * Zdroj: Kilo Code Weekly (11. 9. 2026), DeepSeek-V4.1-Flash, GPT-6 Astra, OpenRouter.
 */
return [
    'slug' => 'ai-modely-ako-nastroje-nie-operacny-system',
    'author' => 'MUDr. Ľubomír Polaščín',
    'category' => 'blog',
    'is_top' => 0,
    'published_at' => '2026-09-17 19:00:00',
    'image' => 'images/articles/ai-modely-ako-nastroje-nie-operacny-system.webp',
    'translations' => [
        'sk' => [
            'title' => 'Ak celý workflow visí na jednom AI modeli, nemáte workflow. Máte predplatné.',
            'image_alt' => 'Otvorená taška s nástrojmi namiesto zamknutého operačného systému: každý AI model ako iný nástroj.',
            'excerpt' => 'DeepSeek-V4.1-Flash, GPT-6 Astra, OpenRouter a Kilo Code ukazujú, že model treba voliť podľa úlohy. Kto si postup postaví okolo jedného modelu, pri ďalšej aktualizácii ostane stáť.',
            'content' => <<<'HTML'
<p>Tento týždeň vyšiel DeepSeek-V4.1-Flash a GPT-6 Astra dostal aktualizácie. Ani jeden z nich neberiem ako jediný model na všetko.</p>
<p><a href="https://openrouter.ai/">OpenRouter</a> a <a href="https://kilo.ai/">Kilo Code</a>, nástroje, ktoré skutočne používam, sa nestarajú, ktorý je „najlepší“. Úlohu pošlú modelu, ktorý sa na ňu hodí.</p>
<p>AI používam na tri veľmi odlišné veci. Pri zhrnutí medicínskej literatúry chcem model, ktorý udrží dlhý text a ešte z neho vyvodí záver. Pri písaní C# migrácií ten, ktorý píše čistý, idiomatický kód. Pri rýchlom preklade medicínskej terminológie medzi slovenčinou a angličtinou chcem rýchlosť, nie hĺbku.</p>
<p>Žiadny model nevyhráva všetky tri. A ten, ktorý vyhráva dnes, nemusí vyhrať budúci mesiac.</p>
<p>Pasca je postaviť si postup okolo zvykov jedného modelu. Keď sa zmení, a zmení sa, postup sa zlomí. Vidím to pri tímoch, ktoré sa naučia jednu štruktúru promptu alebo jedno správanie API a potom stratia dni, keď poskytovateľ nasadí aktualizáciu.</p>
<p>Modely patria do tašky s náradím. Operačný systém z nich nerobte. Vymeňte ich podľa úlohy a merajte, čo z nich vyjde, nie vernosť značke.</p>
<p>Kto si postup postaví tak, aby model vedel vymeniť, prispôsobí sa rýchlejšie než ten, kto si vyberie stranu. Kilo to isté volá <a href="https://kilo.ai/model-freedom">model freedom</a>.</p>
<p>Smerujete medzi modelmi, alebo ste oddaní jednému?</p>
HTML,
        ],
        'en' => [
            'title' => 'If your entire workflow depends on one AI model, you do not have a workflow. You have a subscription.',
            'image_alt' => 'An open tool bag instead of a locked operating system: each AI model as a different instrument.',
            'excerpt' => 'DeepSeek-V4.1-Flash, GPT-6 Astra, OpenRouter and Kilo Code make the point: pick the model for the task. Build around one model’s habits and the next update will stall you.',
            'content' => <<<'HTML'
<p>DeepSeek-V4.1-Flash came out this week, and GPT-6 Astra shipped updates. I am not taking either as the one model for every job.</p>
<p><a href="https://openrouter.ai/">OpenRouter</a> and <a href="https://kilo.ai/">Kilo Code</a>, the tools I actually use, do not care which model is “best.” They send the task to the model that fits it.</p>
<p>I use AI for three very different jobs. For summarizing medical literature I want the model that can hold a long text and still draw a conclusion from it. For writing C# migrations I want the one that writes clean, idiomatic code. For quick translation of medical terminology between Slovak and English I want speed, not depth.</p>
<p>No model wins all three. And the one that wins today will not necessarily win next month.</p>
<p>The trap is building the process around one model’s habits. When it changes, and it will, the process breaks. I have seen teams learn one prompt structure or one API behaviour, then lose days when the provider ships an update.</p>
<p>Models belong in a tool bag. Do not make an operating system out of them. Swap them as the task changes, and measure what comes out, not loyalty to a brand.</p>
<p>Whoever builds the process so the model can be swapped will adapt faster than whoever picks a side. Kilo calls the same idea <a href="https://kilo.ai/model-freedom">model freedom</a>.</p>
<p>Are you routing between models, or are you committed to one?</p>
HTML,
        ],
        'cs' => [
            'title' => 'Pokud celý workflow visí na jednom AI modelu, nemáte workflow. Máte předplatné.',
            'image_alt' => 'Otevřená brašna s nástroji místo zamčeného operačního systému: každý AI model jako jiný nástroj.',
            'excerpt' => 'DeepSeek-V4.1-Flash, GPT-6 Astra, OpenRouter a Kilo Code ukazují, že model je třeba volit podle úkolu. Kdo si postup postaví kolem jednoho modelu, při další aktualizaci zůstane stát.',
            'content' => <<<'HTML'
<p>Tento týden vyšel DeepSeek-V4.1-Flash a GPT-6 Astra dostal aktualizace. Ani jeden z nich neberu jako jediný model na všechno.</p>
<p><a href="https://openrouter.ai/">OpenRouter</a> a <a href="https://kilo.ai/">Kilo Code</a>, nástroje, které skutečně používám, se nestarají, který je „nejlepší“. Úkol pošlou modelu, který se na něj hodí.</p>
<p>AI používám na tři velmi odlišné věci. Při shrnutí medicínské literatury chci model, který udrží dlouhý text a ještě z něj vyvodí závěr. Při psaní C# migrací ten, který píše čistý, idiomatický kód. Při rychlém překladu medicínské terminologie mezi slovenštinou a angličtinou chci rychlost, ne hloubku.</p>
<p>Žádný model nevyhrává všechny tři. A ten, který vyhrává dnes, nemusí vyhrát příští měsíc.</p>
<p>Past je postavit si postup kolem zvyků jednoho modelu. Když se změní, a změní se, postup se zlomí. Vidím to u týmů, které se naučí jednu strukturu promptu nebo jedno chování API a pak ztratí dny, když poskytovatel nasadí aktualizaci.</p>
<p>Modely patří do brašny s nářadím. Nedělejte z nich operační systém. Vyměňujte je podle úkolu a měřte, co z nich vyjde, ne věrnost značce.</p>
<p>Kdo si postup postaví tak, aby šel model vyměnit, přizpůsobí se rychleji než ten, kdo si vybere stranu. Kilo totéž nazývá <a href="https://kilo.ai/model-freedom">model freedom</a>.</p>
<p>Směřujete mezi modely, nebo jste oddáni jednomu?</p>
HTML,
        ],
        'de' => [
            'title' => 'Wenn der ganze Workflow an einem KI-Modell hängt, haben Sie keinen Workflow. Sie haben ein Abo.',
            'image_alt' => 'Eine offene Werkzeugtasche statt eines abgeschlossenen Betriebssystems: jedes KI-Modell als anderes Werkzeug.',
            'excerpt' => 'DeepSeek-V4.1-Flash, GPT-6 Astra, OpenRouter und Kilo Code zeigen: Das Modell muss zur Aufgabe passen. Wer den Ablauf um ein Modell herum baut, bleibt beim nächsten Update stehen.',
            'content' => <<<'HTML'
<p>Diese Woche ist DeepSeek-V4.1-Flash erschienen, und GPT-6 Astra hat Updates bekommen. Keines von beiden nehme ich als das einzige Modell für alles.</p>
<p><a href="https://openrouter.ai/">OpenRouter</a> und <a href="https://kilo.ai/">Kilo Code</a>, die Werkzeuge, die ich wirklich nutze, kümmern sich nicht darum, welches „das beste“ ist. Sie schicken die Aufgabe an das Modell, das zu ihr passt.</p>
<p>KI nutze ich für drei sehr verschiedene Dinge. Beim Zusammenfassen medizinischer Literatur will ich das Modell, das einen langen Text hält und trotzdem einen Schluss daraus zieht. Beim Schreiben von C#-Migrationen das, das sauberen, idiomatischen Code schreibt. Bei der schnellen Übersetzung medizinischer Terminologie zwischen Slowakisch und Englisch will ich Tempo, nicht Tiefe.</p>
<p>Kein Modell gewinnt alle drei. Was heute gewinnt, muss nächsten Monat nicht wieder gewinnen.</p>
<p>Die Falle ist, den Ablauf um die Gewohnheiten eines Modells herum zu bauen. Wenn es sich ändert, und das wird es, bricht der Ablauf. Ich sehe das bei Teams, die eine bestimmte Promptstruktur oder ein API-Verhalten lernen und dann Tage verlieren, wenn der Anbieter ein Update ausliefert.</p>
<p>Modelle gehören in die Werkzeugtasche. Machen Sie kein Betriebssystem aus ihnen. Tauschen Sie sie nach der Aufgabe und messen Sie, was herauskommt, nicht die Treue zu einer Marke.</p>
<p>Wer den Ablauf so baut, dass sich das Modell tauschen lässt, passt sich schneller an als der, der eine Seite wählt. Kilo nennt dasselbe <a href="https://kilo.ai/model-freedom">model freedom</a>.</p>
<p>Schicken Sie die Aufgaben an verschiedene Modelle, oder bleiben Sie bei einem?</p>
HTML,
        ],
        'fr' => [
            'title' => 'Si tout votre workflow tient à un seul modèle d\'IA, vous n\'avez pas de workflow. Vous avez un abonnement.',
            'image_alt' => 'Une sacoche d\'outils ouverte à la place d\'un système d\'exploitation verrouillé : chaque modèle d\'IA comme un outil distinct.',
            'excerpt' => 'DeepSeek-V4.1-Flash, GPT-6 Astra, OpenRouter et Kilo Code le montrent : il faut choisir le modèle selon la tâche. Qui construit son travail autour d\'un seul modèle s\'arrête à la prochaine mise à jour.',
            'content' => <<<'HTML'
<p>Cette semaine, DeepSeek-V4.1-Flash est sorti et GPT-6 Astra a reçu des mises à jour. Je ne prends ni l'un ni l'autre comme le seul modèle pour tout.</p>
<p><a href="https://openrouter.ai/">OpenRouter</a> et <a href="https://kilo.ai/">Kilo Code</a>, les outils que j'utilise vraiment, ne se demandent pas lequel est « le meilleur ». Ils envoient la tâche au modèle qui lui convient.</p>
<p>J'utilise l'IA pour trois travaux très différents. Pour résumer la littérature médicale, je veux le modèle qui tient un long texte et en tire encore une conclusion. Pour écrire des migrations C#, celui qui écrit un code propre et idiomatique. Pour traduire vite la terminologie médicale entre le slovaque et l'anglais, je veux la vitesse, pas la profondeur.</p>
<p>Aucun modèle ne gagne les trois. Et celui qui gagne aujourd'hui ne gagnera pas forcément le mois prochain.</p>
<p>Le piège est de construire le travail autour des habitudes d'un modèle. Quand il change, et il changera, le travail casse. Je le vois dans des équipes qui apprennent une structure de prompt ou un comportement d'API, puis perdent des jours quand le fournisseur livre une mise à jour.</p>
<p>Les modèles vont dans la sacoche. N'en faites pas un système d'exploitation. Changez-les selon la tâche et mesurez ce qui en sort, pas la fidélité à une marque.</p>
<p>Qui construit le travail de façon à pouvoir changer de modèle s'adaptera plus vite que celui qui choisit un camp. Kilo appelle la même idée <a href="https://kilo.ai/model-freedom">model freedom</a>.</p>
<p>Envoyez-vous le travail d'un modèle à l'autre, ou êtes-vous lié à un seul ?</p>
HTML,
        ],
        'es' => [
            'title' => 'Si todo el flujo depende de un solo modelo de IA, no tiene un flujo de trabajo. Tiene una suscripción.',
            'image_alt' => 'Un maletín de herramientas abierto en lugar de un sistema operativo cerrado: cada modelo de IA como una herramienta distinta.',
            'excerpt' => 'DeepSeek-V4.1-Flash, GPT-6 Astra, OpenRouter y Kilo Code lo dejan claro: elija el modelo según la tarea. Quien construya el trabajo alrededor de un modelo se detendrá en la próxima actualización.',
            'content' => <<<'HTML'
<p>Esta semana salió DeepSeek-V4.1-Flash y GPT-6 Astra recibió actualizaciones. No tomo ninguno de los dos como el único modelo para todo.</p>
<p><a href="https://openrouter.ai/">OpenRouter</a> y <a href="https://kilo.ai/">Kilo Code</a>, las herramientas que realmente uso, no se preocupan de cuál es «el mejor». Envían la tarea al modelo que le va.</p>
<p>Uso la IA para tres trabajos muy distintos. Para resumir literatura médica quiero el modelo que sostiene un texto largo y aun así saca una conclusión. Para escribir migraciones en C#, el que escribe código limpio e idiomático. Para traducir rápido terminología médica entre eslovaco e inglés, quiero velocidad, no profundidad.</p>
<p>Ningún modelo gana los tres. Y el que gana hoy no tiene por qué ganar el mes que viene.</p>
<p>La trampa es construir el proceso alrededor de los hábitos de un modelo. Cuando cambie, y cambiará, el proceso se rompe. Lo veo en equipos que aprenden una estructura de prompt o un comportamiento de API y luego pierden días cuando el proveedor publica una actualización.</p>
<p>Los modelos van en el maletín. No haga de ellos un sistema operativo. Cámbielos según la tarea y mida lo que sale, no la lealtad a una marca.</p>
<p>Quien construya el proceso de modo que el modelo se pueda cambiar se adaptará más rápido que quien elija bando. Kilo llama a la misma idea <a href="https://kilo.ai/model-freedom">model freedom</a>.</p>
<p>¿Reparte el trabajo entre modelos o está comprometido con uno?</p>
HTML,
        ],
        'pl' => [
            'title' => 'Jeśli cały workflow wisi na jednym modelu AI, nie macie workflow. Macie abonament.',
            'image_alt' => 'Otwarta torba z narzędziami zamiast zamkniętego systemu operacyjnego: każdy model AI jako inne narzędzie.',
            'excerpt' => 'DeepSeek-V4.1-Flash, GPT-6 Astra, OpenRouter i Kilo Code pokazują, że model trzeba dobierać do zadania. Kto zbuduje pracę wokół jednego modelu, przy kolejnej aktualizacji stanie.',
            'content' => <<<'HTML'
<p>W tym tygodniu wyszedł DeepSeek-V4.1-Flash, a GPT-6 Astra dostał aktualizacje. Żadnego z nich nie biorę jako jedynego modelu do wszystkiego.</p>
<p><a href="https://openrouter.ai/">OpenRouter</a> i <a href="https://kilo.ai/">Kilo Code</a>, narzędzia, których naprawdę używam, nie pytają, który jest „najlepszy”. Zadanie wysyłają do modelu, który do niego pasuje.</p>
<p>AI używam do trzech bardzo różnych rzeczy. Przy streszczaniu literatury medycznej chcę modelu, który utrzyma długi tekst i jeszcze wyciągnie z niego wniosek. Przy pisaniu migracji C# chcę tego, który pisze czysty, idiomatyczny kod. Przy szybkim przekładzie terminologii medycznej między słowackim a angielskim chcę szybkości, nie głębi.</p>
<p>Żaden model nie wygrywa wszystkich trzech. A ten, który wygrywa dziś, nie musi wygrać za miesiąc.</p>
<p>Pułapka polega na tym, że proces buduje się wokół przyzwyczajeń jednego modelu. Gdy się zmieni, a zmieni się, proces pęka. Widzę to u zespołów, które uczą się jednej struktury promptu albo jednego zachowania API, a potem tracą dni, gdy dostawca wdraża aktualizację.</p>
<p>Modele należą do torby z narzędziami. Nie róbcie z nich systemu operacyjnego. Wymieniajcie je według zadania i mierzcie, co z nich wychodzi, nie lojalność wobec marki.</p>
<p>Kto zbuduje proces tak, żeby model dało się wymienić, dostosuje się szybciej niż ten, kto wybierze stronę. Kilo nazywa to samo <a href="https://kilo.ai/model-freedom">model freedom</a>.</p>
<p>Rozdzielacie pracę między modele, czy jesteście oddani jednemu?</p>
HTML,
        ],
        'hu' => [
            'title' => 'Ha az egész workflow egyetlen AI-modellen lóg, nincs workflow. Előfizetés van.',
            'image_alt' => 'Nyitott szerszámos táska a bezárt operációs rendszer helyett: minden AI-modell más szerszám.',
            'excerpt' => 'A DeepSeek-V4.1-Flash, a GPT-6 Astra, az OpenRouter és a Kilo Code azt mutatja: a modellt a feladathoz kell választani. Aki egy modell köré építi a munkát, a következő frissítésnél megáll.',
            'content' => <<<'HTML'
<p>Ezen a héten megjelent a DeepSeek-V4.1-Flash, a GPT-6 Astra pedig frissítéseket kapott. Egyiket sem veszem egyetlen modellnek mindenre.</p>
<p>Az <a href="https://openrouter.ai/">OpenRouter</a> és a <a href="https://kilo.ai/">Kilo Code</a>, az eszközök, amelyeket tényleg használok, nem azzal foglalkoznak, melyik a „legjobb”. A feladatot ahhoz a modellhez küldik, amelyik illik hozzá.</p>
<p>Az AI-t három nagyon különböző dologra használom. Orvosi irodalom összefoglalásakor olyan modellt akarok, amely megtart egy hosszú szöveget, és még következtetést is levon belőle. C#-migrációk írásakor azt, amely tiszta, idiomatikus kódot ír. A szlovák és angol orvosi szakszavak gyors fordításakor a sebességet, nem a mélységet.</p>
<p>Egyik modell sem nyeri mind a hármat. És amelyik ma nyer, nem feltétlenül nyeri a következő hónapot.</p>
<p>A csapda az, ha a folyamatot egy modell szokásaira építjük. Ha változik, és változni fog, a folyamat eltörik. Látom ezt azoknál a csapatoknál, amelyek megtanulnak egy promptfelépítést vagy egy API-viselkedést, majd napokat veszítenek, amikor a szolgáltató frissítést ad ki.</p>
<p>A modellek a szerszámos táskába valók. Ne csináljanak belőlük operációs rendszert. Cseréljék őket a feladat szerint, és azt mérjék, mi jön ki belőlük, ne a márkahűséget.</p>
<p>Aki úgy építi a folyamatot, hogy a modellt ki lehessen cserélni, gyorsabban alkalmazkodik, mint aki oldalt választ. A Kilo ugyanezt <a href="https://kilo.ai/model-freedom">model freedom</a> néven írja le.</p>
<p>A munkát modellek között osztja, vagy egyhez ragaszkodik?</p>
HTML,
        ],
        'it' => [
            'title' => 'Se l\'intero flusso dipende da un solo modello di IA, non avete un flusso di lavoro. Avete un abbonamento.',
            'image_alt' => 'Una borsa degli attrezzi aperta al posto di un sistema operativo chiuso: ogni modello di IA come un attrezzo diverso.',
            'excerpt' => 'DeepSeek-V4.1-Flash, GPT-6 Astra, OpenRouter e Kilo Code lo mostrano: il modello va scelto in base al compito. Chi costruisce il lavoro intorno a un modello si ferma al prossimo aggiornamento.',
            'content' => <<<'HTML'
<p>Questa settimana è uscito DeepSeek-V4.1-Flash e GPT-6 Astra ha ricevuto aggiornamenti. Non prendo nessuno dei due come unico modello per tutto.</p>
<p><a href="https://openrouter.ai/">OpenRouter</a> e <a href="https://kilo.ai/">Kilo Code</a>, gli strumenti che uso davvero, non si chiedono quale sia «il migliore». Mandano il compito al modello che gli si addice.</p>
<p>Uso l'IA per tre lavori molto diversi. Per riassumere la letteratura medica voglio il modello che regge un testo lungo e ne trae comunque una conclusione. Per scrivere migrazioni C#, quello che scrive codice pulito e idiomatico. Per tradurre in fretta la terminologia medica tra slovacco e inglese voglio la velocità, non la profondità.</p>
<p>Nessun modello vince tutti e tre. E quello che vince oggi non vincerà necessariamente il mese prossimo.</p>
<p>La trappola è costruire il processo intorno alle abitudini di un modello. Quando cambia, e cambierà, il processo si spezza. Lo vedo in team che imparano una struttura di prompt o un comportamento delle API e poi perdono giorni quando il fornitore rilascia un aggiornamento.</p>
<p>I modelli stanno nella borsa degli attrezzi. Non fatene un sistema operativo. Cambiateli secondo il compito e misurate ciò che ne esce, non la fedeltà a un marchio.</p>
<p>Chi costruisce il processo in modo che il modello si possa cambiare si adatterà più in fretta di chi sceglie una parte. Kilo chiama la stessa idea <a href="https://kilo.ai/model-freedom">model freedom</a>.</p>
<p>Ripartite il lavoro tra i modelli o siete legati a uno solo?</p>
HTML,
        ],
        'uk' => [
            'title' => 'Якщо весь workflow тримається на одній AI-моделі, у вас немає workflow. У вас є підписка.',
            'image_alt' => 'Відкрита сумка з інструментами замість замкненої операційної системи: кожна AI-модель як інший інструмент.',
            'excerpt' => 'DeepSeek-V4.1-Flash, GPT-6 Astra, OpenRouter і Kilo Code показують: модель треба обирати під задачу. Хто збудує роботу навколо однієї моделі, на наступному оновленні зупиниться.',
            'content' => <<<'HTML'
<p>Цього тижня вийшов DeepSeek-V4.1-Flash, а GPT-6 Astra отримав оновлення. Жодну з них я не беру за єдину модель на все.</p>
<p><a href="https://openrouter.ai/">OpenRouter</a> і <a href="https://kilo.ai/">Kilo Code</a>, інструменти, якими я справді користуюся, не питають, яка «найкраща». Задачу вони віддають моделі, яка їй пасує.</p>
<p>AI я використовую для трьох дуже різних речей. Для стислого викладу медичної літератури хочу модель, яка втримає довгий текст і ще виведе з нього висновок. Для написання C#-міграцій хочу ту, що пише чистий, ідіоматичний код. Для швидкого перекладу медичної термінології між словацькою та англійською хочу швидкість, не глибину.</p>
<p>Жодна модель не виграє всі три. І та, що виграє сьогодні, не обов’язково виграє наступного місяця.</p>
<p>Пастка в тому, щоб збудувати процес навколо звичок однієї моделі. Коли вона зміниться, а зміниться, процес ламається. Я бачу це в командах, які вчать одну структуру промпту чи одну поведінку API, а потім втрачають дні, коли постачальник випускає оновлення.</p>
<p>Моделі належать до сумки з інструментами. Не робіть із них операційну систему. Міняйте їх за задачею і міряйте, що з них виходить, а не вірність бренду.</p>
<p>Хто збудує процес так, щоб модель можна було замінити, пристосується швидше за того, хто вибере сторону. Kilo називає те саме <a href="https://kilo.ai/model-freedom">model freedom</a>.</p>
<p>Ви розподіляєте роботу між моделями чи віддані одній?</p>
HTML,
        ],
    ],
];
