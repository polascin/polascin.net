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
 * Správna odpoveď zo zlého dôvodu.
 * Tri prihlášky firme Evalora Labs v sobotu 17. októbra 2026. Potvrdenia ApplicantDesk
 * o 08:25, 08:28 a 08:29 CEST. Prihlášky čakajú na posúdenie.
 * Z textu nevyplýva prijatie ani platená práca.
 */
return [
    'slug' => 'spravna-odpoved-zo-zleho-dovodu',
    'author' => 'MUDr. Ľubomír Polaščín',
    'category' => 'blog',
    'is_top' => 0,
    'published_at' => '2026-10-28 00:45:00',
    'image' => 'images/articles/spravna-odpoved-zo-zleho-dovodu.webp',
    'translations' => [
        'sk' => [
            'title' => 'Správna odpoveď zo zlého dôvodu',
            'image_alt' => 'Hromada krémových hárkov na tmavom stole a pred ňou tyrkysové sklo rozvetvené do troch ramien. V pozadí fialová tma a rad tyrkysových svetiel.',
            'excerpt' => 'V sobotu 17. októbra som poslal tri prihlášky na hodnotenie medicínskej umelej inteligencie. Ponuku nemám. Dvadsať rokov písania skúškových otázok mi ukázalo, čo by som tam robil.',
            'content' => <<<'HTML'
<p>V sobotu 17. októbra 2026 som poslal tri prihlášky firme Evalora Labs. Sú to miesta, kde lekár hodnotí medicínsku umelú inteligenciu a podieľa sa na jej učení. Ponuku nemám a úlohu mi nepridelili. Prihlášky čakajú na posúdenie.</p>
<p><em>Ide o osobnú skúsenosť. Z textu nevyplýva prijatie ani platená práca.</em></p>
<p>Príprava podkladov ma donútila vysvetliť, prečo by skúsenosť nefrológa mohla platiť aj mimo ambulancie. Našiel som ho v práci, ktorú som dvadsať rokov robil na štátnej zdravotníckej univerzite v hlavnom meste. Časťou tej práce bolo písanie otázok do medicínskych skúšok.</p>
<p>Pri kazuistike si kladiem tri otázky. Či zadanie neprezradí odpoveď skôr, než ju študent nájde. Či odôvodnenie naozaj drží záver, alebo ho len obíde hladkou vetou. A či možnosť, ktorá vyzerá ako chybná, neukazuje skôr chybu v otázke.</p>
<p>Tie isté tri otázky sa hodia na model. Môže dôjsť k správnej odpovedi zo zlého dôvodu. Môže napísať hladké vysvetlenie a vynechať rozlíšenie, na ktorom pri lôžku záleží. Rozpoznať to nie je plynulá angličtina ani zvyk písať si s konverzačným modelom. Treba vedieť, kde sa uvažovanie láme.</p>
<p>Neviem, kam tieto prihlášky povedú. Keď som tú prax mal opísať pre toto miesto, zručnosť, ktorú som predtým len vykonával, dostala meno. Keď sa zmení podoba práce, niektoré zručnosti nezastarávajú. Ľahšie sa dajú pomenovať.</p>
<p>Ktorú časť svojej doterajšej práce by ste spoznali v názve miesta, ktoré v čase, keď ste začínali, ešte neexistovalo?</p>

HTML,
        ],
        'en' => [
            'title' => 'The right answer for a bad reason',
            'image_alt' => 'A stack of cream sheets on a dark table, with a teal glass form in front that splits into three arms. Purple dark behind, and a row of teal lights.',
            'excerpt' => 'On Saturday 17 October I sent three applications to evaluate medical artificial intelligence. I have no offer. Twenty years of writing exam questions showed me what I would be doing there.',
            'content' => <<<'HTML'
<p>On Saturday, 17 October 2026, I sent three applications to Evalora Labs. The roles are for a physician who evaluates medical artificial intelligence and takes part in its training. I have no offer, and no task has been assigned to me. The applications are waiting to be reviewed.</p>
<p><em>This is a personal account. Nothing in it implies acceptance or paid work.</em></p>
<p>Preparing the material forced me to explain why a nephrologist's experience might matter outside the clinic. I found it in work I have done for twenty years at the a public health university in the capital. Part of that work was writing questions for medical exams.</p>
<p>With a vignette I ask three questions. Whether the stem gives the answer away before the student finds it. Whether the reasoning actually holds the conclusion, or only walks around it in a smooth sentence. And whether an option that looks wrong is really a flaw in the question.</p>
<p>The same three questions fit a model. It can reach the right answer for a bad reason. It can write a smooth explanation and skip the distinction that matters at the bedside. Seeing that is not fluent English, and it is not the habit of writing with a conversational model. It takes knowing where the reasoning can break.</p>
<p>I do not know where these applications will lead. When I had to describe that practice for this role, a skill I had only been using received a name. When the form of the work changes, some skills do not go out of date. They become easier to name.</p>
<p>Which part of the work you already do would you recognize in the title of a role that did not exist when you started?</p>

HTML,
        ],
        'cs' => [
            'title' => 'Správná odpověď ze špatného důvodu',
            'image_alt' => 'Hromada krémových listů na tmavém stole a před ní tyrkysové sklo rozvětvené do tří ramen. V pozadí fialová tma a řada tyrkysových světel.',
            'excerpt' => 'V sobotu 17. října jsem poslal tři přihlášky na hodnocení medicínské umělé inteligence. Nabídku nemám. Dvacet let psaní zkušebních otázek mi ukázalo, co bych tam dělal.',
            'content' => <<<'HTML'
<p>V sobotu 17. října 2026 jsem poslal tři přihlášky firmě Evalora Labs. Jsou to místa, kde lékař hodnotí medicínskou umělou inteligenci a podílí se na jejím učení. Nabídku nemám a úkol mi nepřidělili. Přihlášky čekají na posouzení.</p>
<p><em>Jde o osobní zkušenost. Z textu nevyplývá přijetí ani placená práce.</em></p>
<p>Příprava podkladů mě donutila vysvětlit, proč by zkušenost nefrologa mohla platit i mimo ambulanci. Našel jsem je v práci, kterou jsem dvacet let dělal na státní zdravotnické univerzitě v hlavním městě. Součástí té práce bylo psaní otázek k lékařským zkouškám.</p>
<p>U kazuistiky si kladu tři otázky. Zda zadání neprozradí odpověď dřív, než ji student najde. Zda odůvodnění opravdu drží závěr, nebo ho jen obejde hladkou větou. A zda možnost, která vypadá jako chybná, neukazuje spíš chybu v otázce.</p>
<p>Tytéž tři otázky se hodí na model. Může dojít ke správné odpovědi ze špatného důvodu. Může napsat hladké vysvětlení a vynechat rozlišení, na kterém u lůžka záleží. Rozpoznat to není plynulá angličtina ani zvyk psát si s konverzačním modelem. Je třeba vědět, kde se uvažování láme.</p>
<p>Nevím, kam tyto přihlášky povedou. Když jsem tu praxi měl popsat pro toto místo, dovednost, kterou jsem předtím jen vykonával, dostala jméno. Když se změní podoba práce, některé dovednosti nezastarávají. Snáze se dají pojmenovat.</p>
<p>Kterou část své dosavadní práce byste poznali v názvu místa, které v době, kdy jste začínali, ještě neexistovalo?</p>

HTML,
        ],
        'de' => [
            'title' => 'Die richtige Antwort aus dem falschen Grund',
            'image_alt' => 'Ein Stapel cremefarbener Blätter auf einem dunklen Tisch, davor türkisfarbenes Glas, das sich in drei Arme teilt. Dahinter violettes Dunkel und eine Reihe türkiser Lichter.',
            'excerpt' => 'Am Samstag, dem 17. Oktober, habe ich drei Bewerbungen zur Bewertung medizinischer künstlicher Intelligenz geschickt. Ein Angebot habe ich nicht. Zwanzig Jahre Prüfungsfragen haben mir gezeigt, was ich dort tun würde.',
            'content' => <<<'HTML'
<p>Am Samstag, dem 17. Oktober 2026, habe ich drei Bewerbungen an die Firma Evalora Labs geschickt. Es geht um Stellen, an denen ein Arzt medizinische künstliche Intelligenz bewertet und an ihrem Training mitwirkt. Ein Angebot habe ich nicht, und eine Aufgabe wurde mir nicht zugeteilt. Die Bewerbungen warten auf Prüfung.</p>
<p><em>Es ist eine persönliche Erfahrung. Aus dem Text folgt weder eine Zusage noch bezahlte Arbeit.</em></p>
<p>Die Vorbereitung der Unterlagen zwang mich, zu erklären, warum die Erfahrung eines Nephrologen auch außerhalb der Sprechstunde gelten könnte. Ich fand sie in der Arbeit, die ich zwanzig Jahre lang an der staatlichen medizinischen Universität in der Hauptstadt getan habe. Ein Teil dieser Arbeit war das Schreiben von Fragen für medizinische Prüfungen.</p>
<p>Bei einer Fallvignette stelle ich drei Fragen. Ob die Aufgabe die Antwort verrät, bevor der Student sie findet. Ob die Begründung den Schluss wirklich trägt oder ihn nur mit einem glatten Satz umgeht. Und ob eine Möglichkeit, die falsch aussieht, eher einen Fehler in der Frage zeigt.</p>
<p>Dieselben drei Fragen passen auf ein Modell. Es kann zur richtigen Antwort aus dem falschen Grund kommen. Es kann eine glatte Erklärung schreiben und die Unterscheidung auslassen, auf die es am Krankenbett ankommt. Das zu erkennen, ist weder flüssiges Englisch noch die Gewohnheit, mit einem Konversationsmodell zu schreiben. Man muss wissen, wo das Denken brechen kann.</p>
<p>Ich weiß nicht, wohin diese Bewerbungen führen. Als ich diese Praxis für diese Stelle beschreiben musste, bekam eine Fähigkeit, die ich zuvor nur ausgeübt hatte, einen Namen. Wenn sich die Gestalt der Arbeit ändert, veralten manche Fähigkeiten nicht. Sie lassen sich leichter benennen.</p>
<p>Welchen Teil Ihrer bisherigen Arbeit würden Sie in der Bezeichnung einer Stelle wiedererkennen, die es bei Ihrem Anfang noch nicht gab?</p>

HTML,
        ],
        'fr' => [
            'title' => 'La bonne réponse pour une mauvaise raison',
            'image_alt' => 'Une pile de feuilles crème sur une table sombre, et devant elle un verre turquoise qui se divise en trois branches. Derrière, une obscurité violette et une rangée de lumières turquoise.',
            'excerpt' => 'Le samedi 17 octobre, j’ai envoyé trois candidatures pour évaluer l’intelligence artificielle médicale. Je n’ai pas d’offre. Vingt ans de questions d’examen m’ont montré ce que j’y ferais.',
            'content' => <<<'HTML'
<p>Le samedi 17 octobre 2026, j’ai envoyé trois candidatures à la société Evalora Labs. Il s’agit de postes où un médecin évalue l’intelligence artificielle médicale et participe à son entraînement. Je n’ai pas d’offre, et aucune tâche ne m’a été confiée. Les candidatures attendent d’être examinées.</p>
<p><em>Il s’agit d’une expérience personnelle. Le texte n’implique ni une acceptation ni un travail rémunéré.</em></p>
<p>Préparer le dossier m’a obligé à expliquer pourquoi l’expérience d’un néphrologue pourrait compter aussi en dehors du cabinet. Je l’ai trouvée dans le travail que je fais depuis vingt ans à l’université de santé publique de la capitale. Une partie de ce travail consistait à écrire des questions d’examens médicaux.</p>
<p>Devant une vignette, je me pose trois questions. Si l’énoncé livre la réponse avant que l’étudiant ne la trouve. Si le raisonnement soutient vraiment la conclusion, ou s’il se contente de la contourner par une phrase lisse. Et si une option qui semble fausse ne révèle pas plutôt un défaut de la question.</p>
<p>Les mêmes trois questions valent pour un modèle. Il peut arriver à la bonne réponse pour une mauvaise raison. Il peut écrire une explication lisse et omettre la distinction qui compte au lit du malade. Reconnaître cela ne tient ni à un anglais fluide ni à l’habitude d’écrire avec un modèle conversationnel. Il faut savoir où le raisonnement peut casser.</p>
<p>Je ne sais pas où ces candidatures mèneront. Quand j’ai dû décrire cette pratique pour ce poste, une compétence que je ne faisais qu’exercer a reçu un nom. Quand la forme du travail change, certaines compétences ne deviennent pas obsolètes. Elles deviennent plus faciles à nommer.</p>
<p>Quelle partie du travail que vous faites déjà reconnaîtriez-vous dans l’intitulé d’un poste qui n’existait pas quand vous avez commencé ?</p>

HTML,
        ],
        'es' => [
            'title' => 'La respuesta correcta por una mala razón',
            'image_alt' => 'Una pila de hojas color crema sobre una mesa oscura y, delante, un vidrio turquesa que se abre en tres brazos. Al fondo, oscuridad violeta y una fila de luces turquesa.',
            'excerpt' => 'El sábado 17 de octubre envié tres solicitudes para evaluar la inteligencia artificial médica. No tengo oferta. Veinte años de preguntas de examen me mostraron qué haría allí.',
            'content' => <<<'HTML'
<p>El sábado 17 de octubre de 2026 envié tres solicitudes a la empresa Evalora Labs. Son puestos en los que un médico evalúa la inteligencia artificial médica y participa en su entrenamiento. No tengo oferta y no me han asignado ninguna tarea. Las solicitudes están pendientes de revisión.</p>
<p><em>Es una experiencia personal. El texto no implica aceptación ni trabajo remunerado.</em></p>
<p>Preparar los documentos me obligó a explicar por qué la experiencia de un nefrólogo podría valer también fuera de la consulta. La encontré en el trabajo que llevo veinte años haciendo en la universidad de salud pública de la capital. Parte de ese trabajo era redactar preguntas de exámenes médicos.</p>
<p>Ante un caso clínico me hago tres preguntas. Si el enunciado revela la respuesta antes de que el estudiante la encuentre. Si el razonamiento sostiene de verdad la conclusión, o solo la rodea con una frase lisa. Y si una opción que parece errónea muestra más bien un fallo de la pregunta.</p>
<p>Las mismas tres preguntas sirven para un modelo. Puede llegar a la respuesta correcta por una mala razón. Puede escribir una explicación lisa y omitir la distinción que importa a la cabecera del enfermo. Reconocer eso no es un inglés fluido ni el hábito de escribir con un modelo conversacional. Hay que saber dónde puede romperse el razonamiento.</p>
<p>No sé adónde llevarán estas solicitudes. Cuando tuve que describir esta práctica para este puesto, una destreza que hasta entonces solo ejercía recibió un nombre. Cuando cambia la forma del trabajo, algunas destrezas no caducan. Se vuelven más fáciles de nombrar.</p>
<p>¿Qué parte del trabajo que ya hace reconocería en el nombre de un puesto que no existía cuando empezó?</p>

HTML,
        ],
        'pl' => [
            'title' => 'Właściwa odpowiedź z niewłaściwego powodu',
            'image_alt' => 'Stos kremowych kartek na ciemnym stole, a przed nim turkusowe szkło rozgałęzione na trzy ramiona. W tle fioletowa ciemność i rząd turkusowych świateł.',
            'excerpt' => 'W sobotę 17 października wysłałem trzy zgłoszenia do oceny medycznej sztucznej inteligencji. Oferty nie mam. Dwadzieścia lat pisania pytań egzaminacyjnych pokazało mi, co bym tam robił.',
            'content' => <<<'HTML'
<p>W sobotę 17 października 2026 wysłałem trzy zgłoszenia do firmy Evalora Labs. Chodzi o stanowiska, na których lekarz ocenia medyczną sztuczną inteligencję i bierze udział w jej uczeniu. Oferty nie mam i zadania mi nie przydzielono. Zgłoszenia czekają na ocenę.</p>
<p><em>To doświadczenie osobiste. Z tekstu nie wynika przyjęcie ani płatna praca.</em></p>
<p>Przygotowanie materiałów zmusiło mnie do wyjaśnienia, dlaczego doświadczenie nefrologa mogłoby mieć znaczenie także poza przychodnią. Znalazłem je w pracy, którą od dwudziestu lat wykonuję na państwowym uniwersytecie medycznym w stolicy. Częścią tej pracy było pisanie pytań na egzaminy lekarskie.</p>
<p>Przy kazusie stawiam trzy pytania. Czy treść zadania nie zdradza odpowiedzi, zanim student ją znajdzie. Czy uzasadnienie naprawdę podtrzymuje wniosek, czy tylko obchodzi go gładkim zdaniem. I czy możliwość, która wygląda na błędną, nie pokazuje raczej błędu w pytaniu.</p>
<p>Te same trzy pytania pasują do modelu. Może dojść do właściwej odpowiedzi z niewłaściwego powodu. Może napisać gładkie wyjaśnienie i pominąć rozróżnienie, które ma znaczenie przy łóżku chorego. Na to nie wystarczy płynny angielski ani nawyk pisania z modelem konwersacyjnym. Trzeba wiedzieć, gdzie rozumowanie może się załamać.</p>
<p>Nie wiem, dokąd te zgłoszenia doprowadzą. Gdy miałem opisać tę praktykę na to stanowisko, umiejętność, którą wcześniej tylko wykonywałem, dostała nazwę. Gdy zmienia się postać pracy, niektóre umiejętności nie starzeją się. Łatwiej je nazwać.</p>
<p>Którą część swojej dotychczasowej pracy rozpoznaliby Państwo w nazwie stanowiska, którego nie było, gdy Państwo zaczynali?</p>

HTML,
        ],
        'hu' => [
            'title' => 'A helyes válasz rossz okból',
            'image_alt' => 'Krémszínű lapok halma egy sötét asztalon, előtte három ágra bomló türkiz üveg. A háttérben lila sötétség és egy sor türkiz fény.',
            'excerpt' => 'Október 17-én, szombaton három jelentkezést küldtem az orvosi mesterséges intelligencia értékelésére. Ajánlatom nincs. Húsz év vizsgakérdés-írás mutatta meg, mit csinálnék ott.',
            'content' => <<<'HTML'
<p>2026. október 17-én, szombaton három jelentkezést küldtem a Evalora Labsnek. Olyan helyekről van szó, ahol az orvos az orvosi mesterséges intelligenciát értékeli, és részt vesz a betanításában. Ajánlatom nincs, és feladatot nem bíztak rám. A jelentkezések elbírálásra várnak.</p>
<p><em>Személyes tapasztalat. A szövegből nem következik sem felvétel, sem fizetett munka.</em></p>
<p>Az anyagok összeállítása arra kényszerített, hogy megmagyarázzam, miért számíthat egy nefrológus tapasztalata a rendelőn kívül is. Abban a munkában találtam meg, amelyet húsz éve végzek az országos egészségügyi egyetemen a fővárosban. Ennek a munkának a része volt az orvosi vizsgakérdések írása.</p>
<p>Egy kazuisztikánál három kérdést teszek fel. Elárulja-e a feladat a választ, mielőtt a hallgató megtalálná. Valóban tartja-e az indoklás a következtetést, vagy csak sima mondattal kerüli meg. És egy lehetőség, amely hibásnak látszik, nem inkább a kérdés hibáját mutatja-e.</p>
<p>Ugyanez a három kérdés illik a modellre is. Eljuthat a helyes válaszhoz rossz okból. Írhat sima magyarázatot, és kihagyhatja azt a megkülönböztetést, amely a betegágy mellett számít. Ennek felismerése nem folyékony angol, és nem is a szokás, hogy az ember egy beszélgető modellel ír. Tudni kell, hol törhet meg a gondolkodás.</p>
<p>Nem tudom, hová vezetnek ezek a jelentkezések. Amikor ezt a gyakorlatot erre a helyre kellett leírnom, névhez jutott egy készség, amelyet addig csak végeztem. Amikor a munka formája megváltozik, egyes készségek nem avulnak el. Könnyebb lesz őket megnevezni.</p>
<p>Munkájának melyik részét ismerné fel egy olyan hely megnevezésében, amely akkor, amikor kezdte, még nem létezett?</p>

HTML,
        ],
        'it' => [
            'title' => 'La risposta giusta per la ragione sbagliata',
            'image_alt' => 'Una pila di fogli color crema su un tavolo scuro e, davanti, un vetro turchese che si divide in tre bracci. Sullo sfondo un buio viola e una fila di luci turchesi.',
            'excerpt' => 'Sabato 17 ottobre ho inviato tre candidature per valutare l’intelligenza artificiale medica. Non ho un’offerta. Vent’anni di domande d’esame mi hanno mostrato che cosa farei lì.',
            'content' => <<<'HTML'
<p>Sabato 17 ottobre 2026 ho inviato tre candidature all’azienda Evalora Labs. Si tratta di posti in cui un medico valuta l’intelligenza artificiale medica e partecipa al suo addestramento. Non ho un’offerta e non mi è stato assegnato alcun compito. Le candidature attendono di essere esaminate.</p>
<p><em>È un’esperienza personale. Dal testo non segue né un’accettazione né un lavoro retribuito.</em></p>
<p>Preparare i documenti mi ha costretto a spiegare perché l’esperienza di un nefrologo potrebbe contare anche fuori dall’ambulatorio. L’ho trovata nel lavoro che faccio da vent’anni all’università sanitaria pubblica nella capitale. Parte di quel lavoro era scrivere domande per gli esami di medicina.</p>
<p>Davanti a un caso clinico mi pongo tre domande. Se il testo rivela la risposta prima che lo studente la trovi. Se il ragionamento regge davvero la conclusione, o se la aggira soltanto con una frase liscia. E se un’opzione che sembra sbagliata non mostri piuttosto un difetto della domanda.</p>
<p>Le stesse tre domande valgono per un modello. Può arrivare alla risposta giusta per la ragione sbagliata. Può scrivere una spiegazione liscia e tralasciare la distinzione che conta al letto del malato. Riconoscerlo non è un inglese scorrevole, né l’abitudine di scrivere con un modello conversazionale. Bisogna sapere dove il ragionamento può spezzarsi.</p>
<p>Non so dove porteranno queste candidature. Quando ho dovuto descrivere questa pratica per questo posto, un’abilità che prima esercitavo soltanto ha ricevuto un nome. Quando cambia la forma del lavoro, alcune abilità non diventano obsolete. Diventano più facili da nominare.</p>
<p>Quale parte del lavoro che già fate riconoscereste nel nome di un posto che non esisteva quando avete cominciato?</p>

HTML,
        ],
        'uk' => [
            'title' => 'Правильна відповідь з поганої причини',
            'image_alt' => 'Стос кремових аркушів на темному столі, а перед ним бірюзове скло, що розгалужується на три гілки. Позаду фіолетова темрява і ряд бірюзових вогнів.',
            'excerpt' => 'У суботу 17 жовтня я надіслав три заявки на оцінювання медичного штучного інтелекту. Пропозиції не маю. Двадцять років написання екзаменаційних питань показали мені, що я б там робив.',
            'content' => <<<'HTML'
<p>У суботу, 17 жовтня 2026 року, я надіслав три заявки компанії Evalora Labs. Ідеться про посади, на яких лікар оцінює медичний штучний інтелект і бере участь у його навчанні. Пропозиції не маю, і завдання мені не призначили. Заявки чекають на розгляд.</p>
<p><em>Це особистий досвід. З тексту не випливає ні прийняття, ні оплачувана робота.</em></p>
<p>Підготовка матеріалів змусила мене пояснити, чому досвід нефролога може мати значення і поза амбулаторією. Я знайшов його в роботі, яку двадцять років роблю в державному медичному університеті в столиці. Частиною цієї роботи було написання питань до медичних іспитів.</p>
<p>Над клінічним випадком я ставлю три питання. Чи не видає умова відповіді раніше, ніж її знайде студент. Чи обґрунтування справді тримає висновок, чи лише обходить його гладким реченням. І чи варіант, який виглядає хибним, не показує радше ваду самого питання.</p>
<p>Ті самі три питання пасують і до моделі. Вона може дійти правильної відповіді з поганої причини. Може написати гладке пояснення і пропустити розрізнення, яке має значення біля ліжка хворого. Розпізнати це не означає вільно володіти англійською чи мати звичку листуватися з розмовним моделем. Треба знати, де міркування може зламатися.</p>
<p>Не знаю, куди приведуть ці заявки. Коли мені довелося описати цю практику для цієї посади, вміння, яке я доти лише виконував, отримало ім’я. Коли змінюється вигляд роботи, деякі вміння не застарівають. Їх стає легше назвати.</p>
<p>Яку частину своєї дотеперішньої роботи ви впізнали б у назві посади, якої не існувало тоді, коли ви починали?</p>

HTML,
        ],
    ],
];
