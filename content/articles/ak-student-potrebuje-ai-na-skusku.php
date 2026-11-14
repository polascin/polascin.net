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
 * Esej k metodike AI vo výučbe nefrológie (Nefro-projekt, 10. 11. 2026, 10:05).
 * Súvisiaca úvaha na tomto blogu: co-zostane-ked-ai-stichne (10. 11. 2026).
 * Bez textGrain. Návrh na miestne overenie, nie validovaný program.
 */
return [
    'slug' => 'ak-student-potrebuje-ai-na-skusku',
    'author' => 'MUDr. Ľubomír Polaščín',
    'category' => 'blog',
    'is_top' => 0,
    'published_at' => '2026-11-14 13:28:00',
    'image' => 'images/articles/ak-student-potrebuje-ai-na-skusku.webp',
    'translations' => [
        'sk' => [
            'title' => 'Ak študent potrebuje AI na skúšku, čo sme naučili?',
            'image_alt' => 'Fialový stôl s tyrkysovým zápisníkom a perom. V strede priesvitná postava za tenkým svetlom, vpravo zhasnutá obrazovka a fonendoskop.',
            'excerpt' => 'Plynulý rozhovor s virtuálnym pacientom nie je to isté ako samostatná spôsobilosť. Metodika z 10. novembra 2026 oddeľuje nácvik s AI od hodnotenia bez nej.',
            'content' => <<<'HTML'
<p>Skúška môže vyzerať úspešne, kým je asistent na obrazovke stále otvorený. Až keď okno zatvoríte, uvidíte, čo v hlave ostalo.</p>
<p>10. novembra 2026 o 10:05 som na Nefro-projekte zverejnil praktický návrh, ako zaradiť umelú inteligenciu do výučby nefrológie: <a href="https://nefro.polascin.net/article.php?slug=ai-nefrologicka-vyucba-kazuistika-hodnotenie"><em>AI vo výučbe nefrológie: od kazuistiky k overeniu samostatných schopností</em></a>. V ten istý deň, skôr ráno, vyšla na tomto blogu súvisiaca úvaha <a href="https://polascin.net/article.php?slug=co-zostane-ked-ai-stichne"><em>Čo zostane, keď AI stíchne</em></a>. Neskorší text na Nefre dopĺňa konkrétny postup: vstupné riešenie, skontrolovaný fiktívny prípad, rozbor, prenosová úloha a hodnotenie s odstupom.</p>
<p>Východisko nebolo vybrať model. Bolo vybrať schopnosť. Vie účastník pomenovať, ktoré údaje v kazuistike chýbajú? Vie vysvetliť, prečo na nich záleží? Vie obhájiť ďalší krok, aj keď mu ho systém práve nenavrhuje?</p>
<p>Navrhnutý postup preto oddeľuje nácvik s AI od výkonu bez nej. Najprv účastník zaznamená vlastné hodnotenie fiktívneho prípadu, ešte pred pomocou. Potom môže prísť dozorovaný rozhovor s virtuálnym pacientom, ktorého klinické jadro bolo vopred skontrolované. Reč sa môže meniť. Laboratórne hodnoty a časový priebeh si nesmú vymýšľať samy. Po nácviku sa pozrieme, ktoré závery sa zmenili a aký dôkaz tú zmenu unesie. Nakoniec príde iný, príbuzný prípad bez AI. A ešte jedno hodnotenie neskôr, aby bolo vidno, čo ostalo.</p>
<p>Ide o metódu na miestne overenie. Nie o program s preukázaným účinkom a nie o tvrdenie, že sa zlepšili výsledky pacientov.</p>
<p>Otázku hodnotenia však robí ťažšie obísť. Plynulý rozhovor, spokojný študent a správna odpoveď s pomocou sú niečo iné než samostatná spôsobilosť. Užitočná otázka preto neznie len „pomohla im AI dokončiť úlohu?“. Znie: „čo dokážu teraz bez nej?“</p>
<p><em>Úvaha nadväzuje na metodický návrh z Nefro-projektu z 10. novembra 2026 a na súvisiacu esej na tomto blogu z toho istého dňa. Nie je to validovaný vzdelávací program ani liečebné odporúčanie. Fiktívne výučbové prípady sú súčasťou návrhu, nie opisom skutočných pacientov.</em></p>
HTML,
        ],
        'en' => [
            'title' => 'If the student needs AI to pass, what have we taught?',
            'image_alt' => 'A purple desk with a teal notebook and pen. In the centre a translucent figure behind a thin light; on the right a dark screen and a stethoscope.',
            'excerpt' => 'A fluent chat with a virtual patient is not the same as independent competence. The 10 November 2026 method separates practice with AI from assessment without it.',
            'content' => <<<'HTML'
<p>An exam can look successful while the assistant on the screen is still open. Only when you close the window do you see what remained in the mind.</p>
<p>On 10 November 2026 at 10:05 I published a practical proposal on Nefro-projekt for using artificial intelligence in nephrology teaching: <a href="https://nefro.polascin.net/article.php?slug=ai-nefrologicka-vyucba-kazuistika-hodnotenie"><em>AI in nephrology teaching: from case work to checking independent skills</em></a> (Slovak). Earlier that morning this blog carried the related essay <a href="https://polascin.net/article.php?slug=co-zostane-ked-ai-stichne"><em>What remains when AI falls silent</em></a>. The later Nefro text adds a concrete sequence: baseline answer, checked fictional case, debrief, transfer task and delayed assessment.</p>
<p>The starting point was not choosing a model. It was choosing a capability. Can the learner name which facts are missing in a case? Explain why they matter? Defend the next step when the system is not prompting it?</p>
<p>The proposed workflow therefore separates practice with AI from performance without it. First the learner records their own reading of a fictional case, before any help. Then a supervised exchange with a virtual patient whose clinical core has been checked in advance may follow. The conversation can vary. Laboratory values and the timeline must not invent themselves. Afterwards we review which conclusions changed and what evidence carries that change. Finally comes a different but related case without AI. And a later assessment to see what remains.</p>
<p>This is a method for local testing. Not a programme with proven effect, and not a claim that patient outcomes improved.</p>
<p>It does make the evaluation question harder to dodge. A smooth conversation, a satisfied learner and a correct assisted answer are different from independent competence. The useful question is not only “Did AI help them finish?” It is “What can they now do without it?”</p>
<p><em>This reflection follows the methodological proposal on Nefro-projekt of 10 November 2026 and the related essay on this blog from the same day. It is not a validated teaching programme or treatment advice. Fictional teaching cases belong to the proposal; they are not accounts of real patients.</em></p>
HTML,
        ],
        'cs' => [
            'title' => 'Když student potřebuje AI ke zkoušce, co jsme naučili?',
            'image_alt' => 'Fialový stůl s tyrkysovým zápisníkem a perem. Uprostřed průsvitná postava za tenkým světlem, vpravo zhasnutá obrazovka a fonendoskop.',
            'excerpt' => 'Plynulý rozhovor s virtuálním pacientem není totéž co samostatná způsobilost. Metodika z 10. listopadu 2026 odděluje nácvik s AI od hodnocení bez ní.',
            'content' => <<<'HTML'
<p>Zkouška může vypadat úspěšně, dokud je asistent na obrazovce stále otevřený. Teprve když okno zavřete, uvidíte, co zůstalo v hlavě.</p>
<p>10. listopadu 2026 v 10:05 jsem na Nefro-projektu zveřejnil praktický návrh, jak zařadit umělou inteligenci do výuky nefrologie: <a href="https://nefro.polascin.net/article.php?slug=ai-nefrologicka-vyucba-kazuistika-hodnotenie"><em>AI ve výuce nefrologie: od kazuistiky k ověření samostatných schopností</em></a>. Téhož dne, dříve ráno, vyšla na tomto blogu související úvaha <a href="https://polascin.net/article.php?slug=co-zostane-ked-ai-stichne"><em>Co zůstane, když AI ztichne</em></a>. Pozdější text na Nefru doplňuje konkrétní postup: vstupní řešení, zkontrolovaný fiktivní případ, rozbor, přenosová úloha a hodnocení s odstupem.</p>
<p>Východiskem nebylo vybrat model. Bylo vybrat schopnost. Umí účastník pojmenovat, které údaje v kazuistice chybí? Umí vysvětlit, proč na nich záleží? Umí obhájit další krok, i když mu ho systém právě nenavrhuje?</p>
<p>Navržený postup proto odděluje nácvik s AI od výkonu bez ní. Nejprve účastník zaznamená vlastní hodnocení fiktivního případu, ještě před pomocí. Potom může přijít dozorovaný rozhovor s virtuálním pacientem, jehož klinické jádro bylo předem zkontrolováno. Řeč se může měnit. Laboratorní hodnoty a časový průběh si nesmějí vymýšlet samy. Po nácviku se podíváme, které závěry se změnily a jaký důkaz tu změnu unese. Nakonec přijde jiný, příbuzný případ bez AI. A ještě jedno hodnocení později, aby bylo vidět, co zůstalo.</p>
<p>Jde o metodu k místnímu ověření. Ne o program s prokázaným účinkem a ne o tvrzení, že se zlepšily výsledky pacientů.</p>
<p>Otázku hodnocení však dělá těžší obejít. Plynulý rozhovor, spokojený student a správná odpověď s pomocí jsou něco jiného než samostatná způsobilost. Užitečná otázka proto nezní jen „pomohla jim AI dokončit úkol?“. Zní: „co dokážou teď bez ní?“</p>
<p><em>Úvaha navazuje na metodický návrh z Nefro-projektu z 10. listopadu 2026 a na související esej na tomto blogu z téhož dne. Není to validovaný vzdělávací program ani léčebné doporučení. Fiktivní výukové případy jsou součástí návrhu, ne popisem skutečných pacientů.</em></p>
HTML,
        ],
        'de' => [
            'title' => 'Wenn der Student KI für die Prüfung braucht, was haben wir gelehrt?',
            'image_alt' => 'Violetter Tisch mit türkisem Notizbuch und Feder. In der Mitte eine durchscheinende Figur hinter dünnem Licht, rechts dunkler Bildschirm und Stethoskop.',
            'excerpt' => 'Ein flüssiges Gespräch mit einem virtuellen Patienten ist nicht dasselbe wie selbstständige Kompetenz. Die Methode vom 10. November 2026 trennt Übung mit KI von Bewertung ohne sie.',
            'content' => <<<'HTML'
<p>Eine Prüfung kann erfolgreich wirken, solange der Assistent auf dem Bildschirm noch offen ist. Erst wenn Sie das Fenster schließen, sehen Sie, was im Kopf geblieben ist.</p>
<p>Am 10. November 2026 um 10:05 habe ich auf Nefro-projekt einen praktischen Vorschlag veröffentlicht, wie künstliche Intelligenz in die Nephrologie-Lehre eingebunden werden kann: <a href="https://nefro.polascin.net/article.php?slug=ai-nefrologicka-vyucba-kazuistika-hodnotenie"><em>KI in der Nephrologie-Lehre: von der Fallarbeit zur Prüfung selbstständiger Fähigkeiten</em></a> (slowakisch). Am selben Tag, früher am Morgen, erschien auf diesem Blog die verwandte Überlegung <a href="https://polascin.net/article.php?slug=co-zostane-ked-ai-stichne"><em>Was bleibt, wenn KI verstummt</em></a>. Der spätere Nefro-Text ergänzt eine konkrete Abfolge: Ausgangslösung, geprüfter fiktiver Fall, Nachbesprechung, Transferaufgabe und verzögerte Bewertung.</p>
<p>Der Ausgangspunkt war nicht die Wahl eines Modells. Es war die Wahl einer Fähigkeit. Kann die lernende Person benennen, welche Angaben im Fall fehlen? Erklären, warum sie wichtig sind? Den nächsten Schritt verteidigen, wenn das System ihn gerade nicht vorschlägt?</p>
<p>Der vorgeschlagene Ablauf trennt deshalb Übung mit KI von Leistung ohne sie. Zuerst hält die lernende Person die eigene Einschätzung eines fiktiven Falls fest, noch vor jeder Hilfe. Dann kann ein beaufsichtigtes Gespräch mit einem virtuellen Patienten folgen, dessen klinischer Kern vorab geprüft wurde. Die Sprache darf variieren. Laborwerte und Zeitverlauf dürfen sich nicht selbst erfinden. Danach prüfen wir, welche Schlüsse sich geändert haben und welche Evidenz diese Änderung trägt. Schließlich kommt ein anderer, verwandter Fall ohne KI. Und später eine weitere Bewertung, damit sichtbar wird, was geblieben ist.</p>
<p>Es ist eine Methode zur lokalen Prüfung. Kein Programm mit nachgewiesener Wirkung und keine Behauptung, dass Patientenergebnisse besser wurden.</p>
<p>Die Bewertungsfrage wird dadurch schwerer zu umgehen. Ein flüssiges Gespräch, eine zufriedene lernende Person und eine richtige Antwort mit Hilfe sind etwas anderes als selbstständige Kompetenz. Die nützliche Frage lautet nicht nur „Hat KI geholfen, die Aufgabe zu beenden?“. Sie lautet: „Was können sie jetzt ohne sie?“</p>
<p><em>Diese Überlegung schließt an den methodischen Vorschlag auf Nefro-projekt vom 10. November 2026 und an den verwandten Essay auf diesem Blog vom selben Tag an. Sie ist kein validiertes Ausbildungsprogramm und keine Behandlungsempfehlung. Fiktive Lehrfälle gehören zum Vorschlag; sie beschreiben keine realen Patienten.</em></p>
HTML,
        ],
        'fr' => [
            'title' => 'Si l’étudiant a besoin de l’IA pour réussir, qu’avons-nous enseigné ?',
            'image_alt' => 'Bureau violet avec carnet turquoise et stylo. Au centre une silhouette translucide derrière une fine lumière ; à droite un écran éteint et un stéthoscope.',
            'excerpt' => 'Une conversation fluide avec un patient virtuel n’est pas la même chose qu’une compétence autonome. La méthode du 10 novembre 2026 sépare l’entraînement avec l’IA de l’évaluation sans elle.',
            'content' => <<<'HTML'
<p>Un examen peut paraître réussi tant que l’assistant à l’écran reste ouvert. Ce n’est qu’en fermant la fenêtre que l’on voit ce qui est resté dans l’esprit.</p>
<p>Le 10 novembre 2026 à 10 h 05, j’ai publié sur Nefro-projekt une proposition pratique pour intégrer l’intelligence artificielle à l’enseignement de la néphrologie : <a href="https://nefro.polascin.net/article.php?slug=ai-nefrologicka-vyucba-kazuistika-hodnotenie"><em>L’IA dans l’enseignement de la néphrologie : du cas à la vérification des capacités autonomes</em></a> (slovaque). Le même jour, plus tôt le matin, ce blog a publié la réflexion liée <a href="https://polascin.net/article.php?slug=co-zostane-ked-ai-stichne"><em>Ce qui reste quand l’IA se tait</em></a>. Le texte ultérieur sur Nefro ajoute une séquence concrète : réponse initiale, cas fictif vérifié, débriefing, tâche de transfert et évaluation différée.</p>
<p>Le point de départ n’était pas de choisir un modèle. C’était de choisir une capacité. L’apprenant peut-il nommer les données manquantes dans un cas ? Expliquer pourquoi elles comptent ? Défendre l’étape suivante quand le système ne la propose pas ?</p>
<p>Le déroulement proposé sépare donc l’entraînement avec l’IA de la performance sans elle. D’abord l’apprenant consigne sa propre lecture d’un cas fictif, avant toute aide. Puis peut venir un échange supervisé avec un patient virtuel dont le noyau clinique a été vérifié à l’avance. La conversation peut varier. Les valeurs de laboratoire et la chronologie ne doivent pas s’inventer toutes seules. Ensuite on examine quels conclusions ont changé et quelle preuve porte ce changement. Enfin vient un autre cas apparenté sans IA. Puis une évaluation plus tard pour voir ce qui demeure.</p>
<p>C’est une méthode pour un essai local. Pas un programme à effet prouvé, et pas l’affirmation que les résultats des patients se sont améliorés.</p>
<p>Elle rend pourtant plus difficile d’esquiver la question d’évaluation. Une conversation fluide, un apprenant satisfait et une bonne réponse assistée sont autre chose qu’une compétence autonome. La question utile n’est pas seulement « L’IA les a-t-elle aidés à finir ? ». C’est « Que peuvent-ils faire maintenant sans elle ? »</p>
<p><em>Cette réflexion prolonge la proposition méthodologique de Nefro-projekt du 10 novembre 2026 et l’essai lié sur ce blog le même jour. Ce n’est ni un programme d’enseignement validé ni un conseil thérapeutique. Les cas d’enseignement fictifs appartiennent à la proposition ; ce ne sont pas des récits de patients réels.</em></p>
HTML,
        ],
        'es' => [
            'title' => 'Si el estudiante necesita la IA para aprobar, ¿qué hemos enseñado?',
            'image_alt' => 'Escritorio morado con cuaderno turquesa y pluma. En el centro una figura translúcida tras una luz fina; a la derecha una pantalla apagada y un estetoscopio.',
            'excerpt' => 'Una conversación fluida con un paciente virtual no es lo mismo que la competencia independiente. El método del 10 de noviembre de 2026 separa la práctica con IA de la evaluación sin ella.',
            'content' => <<<'HTML'
<p>Un examen puede parecer exitoso mientras el asistente en la pantalla sigue abierto. Solo al cerrar la ventana se ve qué quedó en la mente.</p>
<p>El 10 de noviembre de 2026 a las 10:05 publiqué en Nefro-projekt una propuesta práctica para integrar la inteligencia artificial en la enseñanza de nefrología: <a href="https://nefro.polascin.net/article.php?slug=ai-nefrologicka-vyucba-kazuistika-hodnotenie"><em>IA en la enseñanza de nefrología: del caso a la verificación de capacidades autónomas</em></a> (eslovaco). Ese mismo día, más temprano, este blog publicó la reflexión relacionada <a href="https://polascin.net/article.php?slug=co-zostane-ked-ai-stichne"><em>Qué queda cuando la IA se calla</em></a>. El texto posterior en Nefro añade una secuencia concreta: respuesta inicial, caso ficticio revisado, debriefing, tarea de transferencia y evaluación diferida.</p>
<p>El punto de partida no fue elegir un modelo. Fue elegir una capacidad. ¿Puede quien aprende nombrar qué datos faltan en un caso? ¿Explicar por qué importan? ¿Defender el siguiente paso cuando el sistema no lo sugiere?</p>
<p>El flujo propuesto separa por tanto la práctica con IA del rendimiento sin ella. Primero quien aprende registra su propia lectura de un caso ficticio, antes de cualquier ayuda. Luego puede seguir un intercambio supervisado con un paciente virtual cuyo núcleo clínico se ha comprobado de antemano. La conversación puede variar. Los valores de laboratorio y la cronología no deben inventarse solos. Después revisamos qué conclusiones cambiaron y qué evidencia sostiene ese cambio. Por fin llega otro caso afín sin IA. Y más tarde otra evaluación para ver qué permanece.</p>
<p>Es un método para una prueba local. No un programa con efecto demostrado, ni la afirmación de que mejoraron los resultados de los pacientes.</p>
<p>Sí hace más difícil eludir la pregunta de evaluación. Una conversación fluida, un aprendiz satisfecho y una respuesta correcta asistida son otra cosa que la competencia independiente. La pregunta útil no es solo «¿Les ayudó la IA a terminar?». Es «¿Qué pueden hacer ahora sin ella?»</p>
<p><em>Esta reflexión sigue la propuesta metodológica de Nefro-projekt del 10 de noviembre de 2026 y el ensayo relacionado en este blog el mismo día. No es un programa docente validado ni un consejo terapéutico. Los casos docentes ficticios pertenecen a la propuesta; no son relatos de pacientes reales.</em></p>
HTML,
        ],
        'pl' => [
            'title' => 'Jeśli student potrzebuje AI do zaliczenia, czego nauczyliśmy?',
            'image_alt' => 'Fioletowy stół z turkusowym notesem i piórem. W środku półprzezroczysta postać za cienkim światłem; po prawej zgaszony ekran i stetoskop.',
            'excerpt' => 'Płynna rozmowa z wirtualnym pacjentem to nie to samo co samodzielna kompetencja. Metoda z 10 listopada 2026 oddziela ćwiczenie z AI od oceny bez niej.',
            'content' => <<<'HTML'
<p>Egzamin może wyglądać na udany, dopóki asystent na ekranie jest nadal otwarty. Dopiero gdy zamkniesz okno, widać, co zostało w głowie.</p>
<p>10 listopada 2026 o 10:05 opublikowałem na Nefro-projekcie praktyczną propozycję włączenia sztucznej inteligencji do nauczania nefrologii: <a href="https://nefro.polascin.net/article.php?slug=ai-nefrologicka-vyucba-kazuistika-hodnotenie"><em>AI w nauczaniu nefrologii: od kazuistyki do weryfikacji samodzielnych umiejętności</em></a> (słowacki). Tego samego dnia, wcześniej rano, na tym blogu ukazała się powiązana refleksja <a href="https://polascin.net/article.php?slug=co-zostane-ked-ai-stichne"><em>Co zostanie, gdy AI umilknie</em></a>. Późniejszy tekst na Nefro uzupełnia konkretną sekwencję: rozwiązanie wstępne, sprawdzony fikcyjny przypadek, omówienie, zadanie transferowe i ocena z opóźnieniem.</p>
<p>Punktem wyjścia nie był wybór modelu. Był wybór umiejętności. Czy uczący się potrafi nazwać, których danych brakuje w przypadku? Wyjaśnić, dlaczego mają znaczenie? Obronić kolejny krok, gdy system go właśnie nie podpowiada?</p>
<p>Proponowany przebieg oddziela więc ćwiczenie z AI od występu bez niej. Najpierw uczący się zapisuje własną ocenę fikcyjnego przypadku, jeszcze przed pomocą. Potem może nastąpić nadzorowana rozmowa z wirtualnym pacjentem, którego kliniczny rdzeń sprawdzono z góry. Mowa może się zmieniać. Wartości laboratoryjne i przebieg czasowy nie mogą wymyślać się same. Potem patrzymy, które wnioski się zmieniły i jaki dowód tę zmianę unosi. Na koniec przychodzi inny, pokrewny przypadek bez AI. I jeszcze jedna ocena później, by było widać, co zostało.</p>
<p>To metoda do lokalnego sprawdzenia. Nie program o udowodnionym działaniu i nie twierdzenie, że poprawiły się wyniki pacjentów.</p>
<p>Utrudnia jednak ominięcie pytania o ocenę. Płynna rozmowa, zadowolony student i poprawna odpowiedź z pomocą to coś innego niż samodzielna kompetencja. Pożyteczne pytanie nie brzmi tylko „Czy AI pomogło im dokończyć?”. Brzmi: „Co potrafią teraz bez niej?”</p>
<p><em>Refleksja nawiązuje do propozycji metodycznej z Nefro-projektu z 10 listopada 2026 i do powiązanego eseju na tym blogu z tego samego dnia. To nie walidowany program nauczania ani zalecenie terapeutyczne. Fikcyjne przypadki dydaktyczne należą do propozycji; nie opisują prawdziwych pacjentów.</em></p>
HTML,
        ],
        'hu' => [
            'title' => 'Ha a hallgatónak AI kell a vizsgához, mit tanítottunk?',
            'image_alt' => 'Lila asztal türkiz jegyzetfüzettel és tollal. Középen áttetsző alak vékony fény mögött; jobbra kialudt képernyő és sztetoszkóp.',
            'excerpt' => 'A virtuális beteggel folytatott gördülékeny beszélgetés nem ugyanaz, mint az önálló képesség. A 2026. november 10-i módszer elválasztja az AI-s gyakorlást az nélküle történő értékeléstől.',
            'content' => <<<'HTML'
<p>A vizsga sikeresnek tűnhet, amíg a képernyőn lévő asszisztens még nyitva van. Csak amikor bezárod az ablakot, látod, mi maradt a fejben.</p>
<p>2026. november 10-én 10:05-kor a Nefro-projekten közzétettem egy gyakorlati javaslatot arra, hogyan illeszthető a mesterséges intelligencia a nefrológia oktatásába: <a href="https://nefro.polascin.net/article.php?slug=ai-nefrologicka-vyucba-kazuistika-hodnotenie"><em>AI a nefrológia oktatásában: az esetmunkától az önálló képességek ellenőrzéséig</em></a> (szlovák). Ugyanezen a napon, korábban reggel ezen a blogon megjelent a kapcsolódó gondolat <a href="https://polascin.net/article.php?slug=co-zostane-ked-ai-stichne"><em>Mi marad, amikor az AI elhallgat</em></a>. A későbbi Nefro-szöveg konkrét sorozatot ad: kiinduló megoldás, ellenőrzött fiktív eset, megbeszélés, átviteli feladat és késleltetett értékelés.</p>
<p>A kiindulópont nem a modell választása volt. Egy képesség választása volt. A tanuló meg tudja nevezni, mely adatok hiányoznak az esetből? El tudja magyarázni, miért számítanak? Meg tudja védeni a következő lépést, amikor a rendszer éppen nem javasolja?</p>
<p>A javasolt menet ezért elválasztja az AI-s gyakorlást az nélküle nyújtott teljesítménytől. Először a tanuló rögzíti a fiktív eset saját olvasatát, még segítség előtt. Ezután jöhet felügyelt beszélgetés egy virtuális beteggel, akinek klinikai magját előre ellenőrizték. A beszéd változhat. A laborértékek és az időbeli lefolyás nem találhatják ki magukat. Utána megnézzük, mely következtetések változtak, és milyen bizonyíték viseli el a változást. Végül jön egy másik, rokon eset AI nélkül. És később még egy értékelés, hogy látszódjon, mi maradt.</p>
<p>Ez helyi ellenőrzésre szánt módszer. Nem igazolt hatású program, és nem állítás arról, hogy a betegek eredményei javultak.</p>
<p>Az értékelés kérdését viszont nehezebben lehet megkerülni. A gördülékeny beszélgetés, az elégedett hallgató és a segítséggel helyes válasz más, mint az önálló képesség. A hasznos kérdés nemcsak az, hogy „Segített-e az AI befejezni?”. Hanem: „Mit tudnak most nélküle?”</p>
<p><em>Ez a gondolat a Nefro-projekt 2026. november 10-i módszertani javaslatára és ugyanazon a napon ezen a blogon megjelent kapcsolódó esszére támaszkodik. Nem validált oktatási program és nem kezelési javaslat. A fiktív oktatási esetek a javaslat részei; nem valódi betegek leírásai.</em></p>
HTML,
        ],
        'it' => [
            'title' => 'Se lo studente ha bisogno dell’IA per superare la prova, che cosa abbiamo insegnato?',
            'image_alt' => 'Scrivania viola con taccuino turchese e penna. Al centro una figura traslucida dietro una luce sottile; a destra uno schermo spento e uno stetoscopio.',
            'excerpt' => 'Una conversazione fluida con un paziente virtuale non è la stessa cosa della competenza autonoma. Il metodo del 10 novembre 2026 separa la pratica con l’IA dalla valutazione senza di essa.',
            'content' => <<<'HTML'
<p>Un esame può sembrare riuscito finché l’assistente sullo schermo resta aperto. Solo quando chiudi la finestra vedi che cosa è rimasto in testa.</p>
<p>Il 10 novembre 2026 alle 10:05 ho pubblicato su Nefro-projekt una proposta pratica per inserire l’intelligenza artificiale nell’insegnamento della nefrologia: <a href="https://nefro.polascin.net/article.php?slug=ai-nefrologicka-vyucba-kazuistika-hodnotenie"><em>IA nell’insegnamento della nefrologia: dal caso alla verifica delle capacità autonome</em></a> (slovacco). Lo stesso giorno, più presto al mattino, su questo blog è uscita la riflessione collegata <a href="https://polascin.net/article.php?slug=co-zostane-ked-ai-stichne"><em>Che cosa resta quando l’IA tace</em></a>. Il testo successivo su Nefro aggiunge una sequenza concreta: risposta iniziale, caso fittizio controllato, debriefing, compito di trasferimento e valutazione differita.</p>
<p>Il punto di partenza non era scegliere un modello. Era scegliere una capacità. Chi impara sa nominare quali dati mancano in un caso? Spiegare perché contano? Difendere il passo successivo quando il sistema non lo suggerisce?</p>
<p>Il percorso proposto separa quindi la pratica con l’IA dalla prestazione senza di essa. Prima chi impara registra la propria lettura di un caso fittizio, ancora prima di ogni aiuto. Poi può seguire uno scambio supervisionato con un paziente virtuale il cui nucleo clinico è stato controllato in anticipo. La conversazione può variare. I valori di laboratorio e la cronologia non devono inventarsi da soli. Dopo guardiamo quali conclusioni sono cambiate e quale evidenza sostiene quel cambiamento. Infine arriva un altro caso affine senza IA. E più tardi un’altra valutazione, per vedere che cosa resta.</p>
<p>È un metodo per una verifica locale. Non un programma con effetto dimostrato, e non l’affermazione che i risultati dei pazienti siano migliorati.</p>
<p>Rende però più difficile eludere la domanda di valutazione. Una conversazione fluida, uno studente soddisfatto e una risposta corretta assistita sono altra cosa dalla competenza autonoma. La domanda utile non è solo «L’IA li ha aiutati a finire?». È «Che cosa sanno fare ora senza di essa?»</p>
<p><em>Questa riflessione segue la proposta metodologica di Nefro-projekt del 10 novembre 2026 e il saggio collegato su questo blog dello stesso giorno. Non è un programma didattico validato né un consiglio terapeutico. I casi didattici fittizi appartengono alla proposta; non sono resoconti di pazienti reali.</em></p>
HTML,
        ],
        'uk' => [
            'title' => 'Якщо студентові потрібен ШІ для іспиту, чого ми навчили?',
            'image_alt' => 'Фіолетовий стіл із бірюзовим зошитом і пером. У центрі напівпрозора постать за тонким світлом; праворуч згаслий екран і стетоскоп.',
            'excerpt' => 'Плавна розмова з віртуальним пацієнтом: це не те саме, що самостійна спроможність. Методика від 10 листопада 2026 відокремлює тренування з ШІ від оцінювання без нього.',
            'content' => <<<'HTML'
<p>Іспит може виглядати успішним, доки помічник на екрані ще відкритий. Лише коли закриєте вікно, видно, що лишилося в голові.</p>
<p>10 листопада 2026 о 10:05 я опублікував на Nefro-проекті практичну пропозицію, як включити штучний інтелект у викладання нефрології: <a href="https://nefro.polascin.net/article.php?slug=ai-nefrologicka-vyucba-kazuistika-hodnotenie"><em>ШІ у викладанні нефрології: від казуїстики до перевірки самостійних здібностей</em></a> (словацькою). Того ж дня, раніше вранці, на цьому блозі вийшла пов’язана роздумка <a href="https://polascin.net/article.php?slug=co-zostane-ked-ai-stichne"><em>Що лишається, коли ШІ замовкає</em></a>. Пізніший текст на Nefro доповнює конкретну послідовність: вхідне рішення, перевірений вигаданий випадок, розбір, переносна задача і оцінювання з відступом.</p>
<p>Вихідною точкою був не вибір моделі. Був вибір здібності. Чи вміє учасник назвати, яких даних бракує в казуїстиці? Пояснити, чому вони важливі? Відстояти наступний крок, коли система його саме не пропонує?</p>
<p>Запропонований порядок тому відокремлює тренування з ШІ від виконання без нього. Спочатку учасник записує власну оцінку вигаданого випадку, ще до допомоги. Потім може бути наглядова розмова з віртуальним пацієнтом, чиє клінічне ядро перевірили заздалегідь. Мова може змінюватися. Лабораторні значення і часовий перебіг не мають вигадувати себе самі. Після тренування дивимося, які висновки змінилися і який доказ цю зміну витримує. Нарешті приходить інший, споріднений випадок без ШІ. І ще одне оцінювання пізніше, щоб було видно, що лишилося.</p>
<p>Це метод для місцевої перевірки. Не програма з доведеним ефектом і не твердження, що результати пацієнтів покращилися.</p>
<p>Проте питання оцінювання стає важче обійти. Плавна розмова, задоволений студент і правильна відповідь з допомогою: це інше, ніж самостійна спроможність. Корисне питання тому звучить не лише «Чи ШІ допоміг їм закінчити?». А: «Що вони вміють тепер без нього?»</p>
<p><em>Роздумка спирається на методичну пропозицію Nefro-проекту від 10 листопада 2026 і на пов’язане есе на цьому блозі з того ж дня. Це не валідована освітня програма і не лікувальне рекомендовання. Вигадані навчальні випадки належать до пропозиції; це не описи реальних пацієнтів.</em></p>
HTML,
        ],
    ],
];
