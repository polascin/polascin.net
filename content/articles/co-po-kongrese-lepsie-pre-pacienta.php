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
 * Komentár k programu 47. kongresu SNefS (Jasná, 11. až 13. 11. 2026).
 * Zdroj: nefro2026.sk/program.php; e-mail SNefS/Farmiprofi 30. 10. 2026;
 * širšia verzia na nefro.polascin.net (slug komentar-program-47-kongres-snefs-2026).
 * Prednášky ešte nezazneli: text je komentár k rozvrhu, nie správa zo sály.
 */
return [
    'slug' => 'co-po-kongrese-lepsie-pre-pacienta',
    'author' => 'MUDr. Ľubomír Polaščín',
    'category' => 'blog',
    'is_top' => 0,
    'published_at' => '2026-11-01 10:53:00',
    'image' => 'images/articles/co-po-kongrese-lepsie-pre-pacienta.webp',
    'translations' => [
        'sk' => [
            'title' => 'Čo po kongrese dokážeme pre pacienta lepšie',
            'image_alt' => 'Fialová horská chodba. Vľavo priesvitný tvar obličky z tyrkysového svetla, vpravo prázdne dialyzačné kreslo. Pod zatvorenými dverami tenký tyrkysový pás.',
            'excerpt' => 'Program 47. kongresu SNefS v Jasnej je obsahovo silný. Štatistika, nové lieky aj cievne prístupy majú zmysel. Rozhodujúce ostáva, čo z toho po 13. novembri 2026 ostane v ambulancii.',
            'content' => <<<'HTML'
<p>11. až 13. novembra 2026 sa v Hoteli Grand v Jasnej koná <a href="https://nefro2026.sk">47. kongres Slovenskej nefrologickej spoločnosti</a>. <a href="https://nefro2026.sk/program.php">Program</a> je verejný. Prednášky ešte nie. Tento text je komentár k rozvrhu, nie správa zo sály.</p>
<p>30. októbra 2026 prišiel e-mail, že odborný program je pripravený. Odkaz viedol na stránku, nie na prílohu. Zo zverejneného rozvrhu som na Nefro-projekte napísal <a href="https://nefro.polascin.net/article.php?slug=komentar-program-47-kongres-snefs-2026">širší komentár</a>. Tu držím jednu vetu: novinka, ktorá nedôjde k pacientovi, je len zoznam.</p>
<p>Program ukazuje odbor, ktorý sa posúva od náhrady funkcie obličiek k včasnému záchytu, nefroprotekcii a cielenej liečbe. To je správny smer. Rozhodujúce bude, nakoľko sa poznatky premenia na dostupnú, bezpečnú a uskutočniteľnú starostlivosť.</p>
<p>Zaradenie nefrologickej a transplantačnej štatistiky hneď na začiatok je dobré rozhodnutie. Diskusia o budúcnosti slovenskej nefrológie potrebuje najprv pomenovať súčasný stav. Nadväzujúce prezentácie štúdie SIRIUS, projektu Silné obličky a národných epidemiologických údajov môžu priniesť domáci pohľad. Treba však rozlišovať výsledok skríningovej kohorty, skúsenosť jedného centra a údaje, ktoré unesú zovšeobecnenie na celú populáciu.</p>
<p>Silnou stránkou je prepojenie klinickej nefrológie s novými diagnostickými a liečebnými možnosťami. IgA nefropatia, komplementom sprostredkované glomerulopatie či diagnostika rejekcie pomocou darcovskej voľnej DNA majú potenciál meniť rozhodovanie. Pri ich prezentácii nesmú ustúpiť bezpečnosť, výber pacienta, dostupnosť vyšetrení a reálne možnosti úhrady.</p>
<p>Pre každodennú dialyzačnú prax sú cenné prednášky o domácich metódach, predtransplantačnej príprave a cievnych prístupoch. Otázka, kde pri príprave na transplantáciu strácame čas, môže byť pre pacienta rovnako dôležitá ako predstavenie novej technológie. Piatkový blok o ultrazvuku, kanylácii a komplikáciách cievnych prístupov má preto výrazný praktický potenciál.</p>
<p>Samostatný blok o obličkách a životnom prostredí oceňujem. Pri mikroplastoch treba jasne oddeliť biologickú vierohodnosť a experimentálne poznatky od preukázaných klinických dôsledkov. Pri ekologickej udržateľnosti dialýzy treba hodnotiť spotrebu vody, energie a materiálu spolu s bezpečnosťou a výsledkami liečby.</p>
<p>Program otvára aj otázku vyváženosti. Firemné sympóziá aj podporené prednášky sú zreteľne označené, čo je správne. Samotné označenie však nenahrádza kritické porovnanie možností vrátane nefarmakologických postupov a neistôt v dôkazoch. V názvoch menej vystupujú konzervatívna starostlivosť bez dialýzy, spoločné rozhodovanie a kvalita života. Neznamená to, že nezaznejú. Zaslúžili by si viditeľnejší priestor.</p>
<p>Odborná pestrosť naráža na čas. Pediatrický blok zaradený až na štvrtkový večer a krátke diskusie pri viacerých prednáškach môžu obmedziť výmenu skúseností.</p>
<p>Celkovo ide o obsahovo silný program. Jeho hodnotu neukáže počet noviniek. Ukáže ju odpoveď na jednoduchú otázku: čo po kongrese dokážeme pre svojich pacientov robiť lepšie?</p>
<p><em>Ide o komentár k oficiálnemu programu pred začiatkom kongresu, nie o správu z prednášok a nie o liečebné rozhodnutie pre konkrétneho pacienta.</em></p>
HTML,
        ],
        'en' => [
            'title' => 'What can we do better for the patient after the congress',
            'image_alt' => 'A purple mountain corridor. On the left, a translucent kidney form of teal light; on the right, an empty dialysis chair. A thin teal band of light under a closed door.',
            'excerpt' => 'The programme of the 47th SNefS congress in Jasná is strong in content. Statistics, new drugs and vascular access all matter. What counts is what remains in the clinic after 13 November 2026.',
            'content' => <<<'HTML'
<p>From 11 to 13 November 2026, Hotel Grand in Jasná hosts the <a href="https://nefro2026.sk">47th Congress of the Slovak Nephrological Society</a>. The <a href="https://nefro2026.sk/program.php">programme</a> is public. The lectures are not yet. This text is a comment on the schedule, not a report from the hall.</p>
<p>On 30 October 2026 an email announced that the scientific programme was ready. The link pointed to the website, not to an attachment. From the published schedule I wrote a <a href="https://nefro.polascin.net/article.php?slug=komentar-program-47-kongres-snefs-2026">longer commentary</a> on Nefro-projekt. Here I keep one sentence: a novelty that does not reach the patient is only a list.</p>
<p>The programme shows a specialty moving from kidney replacement alone toward early detection, nephroprotection and targeted therapy. That is the right direction. What will decide it is how far knowledge turns into care that is available, safe and feasible.</p>
<p>Opening with nephrology and transplant statistics is a good decision. A debate about the future of Slovak nephrology first needs a clear account of the present. Talks on the SIRIUS study, the Strong Kidneys project and national epidemiological data can bring a domestic view. We still need to separate a screening cohort result, a single-centre experience and figures that can be generalised to the whole population.</p>
<p>A strength is the link between clinical nephrology and new diagnostic and therapeutic options. IgA nephropathy, complement-mediated glomerulopathies and rejection diagnosis with donor-derived cell-free DNA can change decisions. When they are presented, safety, patient selection, access to tests and real reimbursement must not slip aside.</p>
<p>For everyday dialysis practice, talks on home methods, pretransplant preparation and vascular access are especially valuable. Where we lose time before transplantation may matter to a patient as much as a new technology. Friday’s block on ultrasound, cannulation and access complications therefore has clear practical potential.</p>
<p>I also welcome the separate block on kidneys and the environment. With microplastics, biological plausibility and experimental findings must be kept apart from proven clinical consequences. With ecological sustainability of dialysis, water, energy and material use must be judged together with safety and treatment outcomes.</p>
<p>The programme also raises balance. Company symposia and supported talks are clearly labelled, which is right. A label alone does not replace critical comparison of options, including non-pharmacological approaches and uncertainty in the evidence. Conservative care without dialysis, shared decision-making and quality of life appear less often in the titles. That does not mean they will not be heard. They deserve a more visible place.</p>
<p>Breadth meets the clock. A paediatric block late on Thursday evening and short discussions after several talks may limit the exchange of experience.</p>
<p>Overall this is a strong programme. Its value will not be measured by the number of novelties. It will be measured by a simple question: what can we do better for our patients after the congress?</p>
<p><em>This is a commentary on the official programme before the congress begins, not a report from the lectures and not a treatment decision for an individual patient.</em></p>
HTML,
        ],
        'cs' => [
            'title' => 'Co po kongresu dokážeme pro pacienta lépe',
            'image_alt' => 'Fialová horská chodba. Vlevo průsvitný tvar ledviny z tyrkysového světla, vpravo prázdné dialyzační křeslo. Pod zavřenými dveřmi tenký tyrkysový pás.',
            'excerpt' => 'Program 47. kongresu SNefS v Jasné je obsahově silný. Statistika, nové léky i cévní přístupy mají smysl. Rozhodující zůstává, co z toho po 13. listopadu 2026 zůstane v ambulanci.',
            'content' => <<<'HTML'
<p>11. až 13. listopadu 2026 se v Hotelu Grand v Jasné koná <a href="https://nefro2026.sk">47. kongres Slovenské nefrologické společnosti</a>. <a href="https://nefro2026.sk/program.php">Program</a> je veřejný. Přednášky ještě ne. Tento text je komentář k rozvrhu, ne zpráva ze sálu.</p>
<p>30. října 2026 přišel e-mail, že odborný program je připraven. Odkaz vedl na stránku, ne na přílohu. Ze zveřejněného rozvrhu jsem na Nefro-projektu napsal <a href="https://nefro.polascin.net/article.php?slug=komentar-program-47-kongres-snefs-2026">širší komentář</a>. Tady držím jednu větu: novinka, která nedojde k pacientovi, je jen seznam.</p>
<p>Program ukazuje obor, který se posouvá od náhrady funkce ledvin k včasnému záchytu, nefroprotekci a cílené léčbě. To je správný směr. Rozhodující bude, nakolik se poznatky promění v dostupnou, bezpečnou a uskutečnitelnou péči.</p>
<p>Zařazení nefrologické a transplantační statistiky hned na začátek je dobré rozhodnutí. Diskuse o budoucnosti slovenské nefrologie potřebuje nejprve pojmenovat současný stav. Navazující prezentace studie SIRIUS, projektu Silné ledviny a národních epidemiologických údajů mohou přinést domácí pohled. Je však třeba rozlišovat výsledek screeningové kohorty, zkušenost jednoho centra a údaje, které unesou zobecnění na celou populaci.</p>
<p>Silnou stránkou je propojení klinické nefrologie s novými diagnostickými a léčebnými možnostmi. IgA nefropatie, komplementem zprostředkované glomerulopatie či diagnostika rejekce pomocí dárcovské volné DNA mají potenciál měnit rozhodování. Při jejich prezentaci nesmějí ustoupit bezpečnost, výběr pacienta, dostupnost vyšetření a reálné možnosti úhrady.</p>
<p>Pro každodenní dialyzační praxi jsou cenné přednášky o domácích metodách, předtransplantační přípravě a cévních přístupech. Otázka, kde při přípravě na transplantaci ztrácíme čas, může být pro pacienta stejně důležitá jako představení nové technologie. Páteční blok o ultrazvuku, kanylaci a komplikacích cévních přístupů má proto výrazný praktický potenciál.</p>
<p>Samostatný blok o ledvinách a životním prostředí oceňuji. U mikroplastů je třeba jasně oddělit biologickou věrohodnost a experimentální poznatky od prokázaných klinických důsledků. U ekologické udržitelnosti dialýzy je třeba hodnotit spotřebu vody, energie a materiálu spolu s bezpečností a výsledky léčby.</p>
<p>Program otevírá i otázku vyváženosti. Firemní sympozia i podpořené přednášky jsou zřetelně označené, což je správné. Samotné označení však nenahrazuje kritické srovnání možností včetně nefarmakologických postupů a nejistot v důkazech. V názvech méně vystupují konzervativní péče bez dialýzy, společné rozhodování a kvalita života. Neznamená to, že nezazní. Zasloužily by si viditelnější prostor.</p>
<p>Odborná pestrost naráží na čas. Pediatrický blok zařazený až na čtvrteční večer a krátké diskuse u více přednášek mohou omezit výměnu zkušeností.</p>
<p>Celkově jde o obsahově silný program. Jeho hodnotu neukáže počet novinek. Ukáže ji odpověď na jednoduchou otázku: co po kongresu dokážeme pro své pacienty dělat lépe?</p>
<p><em>Jde o komentář k oficiálnímu programu před začátkem kongresu, ne o zprávu z přednášek a ne o léčebné rozhodnutí pro konkrétního pacienta.</em></p>
HTML,
        ],
        'de' => [
            'title' => 'Was können wir nach dem Kongress für den Patienten besser tun',
            'image_alt' => 'Violetter Bergkorridor. Links eine durchscheinende Nierenform aus Türkislicht, rechts ein leerer Dialysesessel. Unter der geschlossenen Tür ein dünner türkiser Lichtstreifen.',
            'excerpt' => 'Das Programm des 47. SNefS-Kongresses in Jasná ist inhaltlich stark. Statistik, neue Arzneimittel und Gefäßzugänge zählen. Entscheidend bleibt, was nach dem 13. November 2026 in der Ambulanz bleibt.',
            'content' => <<<'HTML'
<p>Vom 11. bis 13. November 2026 findet im Hotel Grand in Jasná der <a href="https://nefro2026.sk">47. Kongress der Slowakischen Nephrologischen Gesellschaft</a> statt. Das <a href="https://nefro2026.sk/program.php">Programm</a> ist öffentlich. Die Vorträge noch nicht. Dieser Text ist ein Kommentar zum Zeitplan, kein Bericht aus dem Saal.</p>
<p>Am 30. Oktober 2026 kam eine E-Mail, dass das Fachprogramm bereit sei. Der Link führte zur Website, nicht zu einem Anhang. Aus dem veröffentlichten Zeitplan habe ich auf Nefro-projekt einen <a href="https://nefro.polascin.net/article.php?slug=komentar-program-47-kongres-snefs-2026">längeren Kommentar</a> geschrieben. Hier halte ich einen Satz fest: eine Neuheit, die den Patienten nicht erreicht, ist nur eine Liste.</p>
<p>Das Programm zeigt ein Fach, das sich von der alleinigen Nierenersatztherapie hin zu Früherkennung, Nephroprotektion und gezielter Therapie bewegt. Das ist die richtige Richtung. Entscheidend wird sein, wie weit sich Erkenntnisse in verfügbare, sichere und machbare Versorgung verwandeln.</p>
<p>Nephrologische und transplantationsbezogene Statistik gleich zu Beginn zu setzen ist eine gute Entscheidung. Die Debatte über die Zukunft der slowakischen Nephrologie braucht zuerst eine Benennung des Ist-Zustands. Anschließende Vorträge zur SIRIUS-Studie, zum Projekt Starke Nieren und zu nationalen epidemiologischen Daten können einen heimischen Blick bringen. Man muss jedoch das Ergebnis einer Screening-Kohorte, die Erfahrung eines Zentrums und Daten trennen, die eine Verallgemeinerung auf die ganze Bevölkerung tragen.</p>
<p>Eine Stärke ist die Verbindung klinischer Nephrologie mit neuen diagnostischen und therapeutischen Möglichkeiten. IgA-Nephropathie, komplementvermittelte Glomerulopathien und Rejektionsdiagnostik mit spenderstämmiger zellfreier DNA können Entscheidungen ändern. Bei ihrer Darstellung dürfen Sicherheit, Patientenauswahl, Verfügbarkeit von Untersuchungen und reale Erstattungsmöglichkeiten nicht zurücktreten.</p>
<p>Für die tägliche Dialysepraxis sind Vorträge zu Heimverfahren, prätransplantärer Vorbereitung und Gefäßzugängen besonders wertvoll. Die Frage, wo wir bei der Transplantationsvorbereitung Zeit verlieren, kann für den Patienten ebenso wichtig sein wie die Vorstellung einer neuen Technologie. Der Freitagsblock zu Ultraschall, Kanülierung und Komplikationen der Gefäßzugänge hat deshalb deutliches praktisches Potenzial.</p>
<p>Den eigenen Block zu Nieren und Umwelt begrüße ich. Bei Mikroplastik müssen biologische Plausibilität und experimentelle Erkenntnisse von nachgewiesenen klinischen Folgen klar getrennt werden. Bei der ökologischen Nachhaltigkeit der Dialyse sind Wasser-, Energie- und Materialverbrauch zusammen mit Sicherheit und Behandlungsergebnissen zu bewerten.</p>
<p>Das Programm stellt auch die Frage der Ausgewogenheit. Firmensymposien und unterstützte Vorträge sind klar gekennzeichnet, das ist richtig. Die Kennzeichnung allein ersetzt keinen kritischen Vergleich der Optionen einschließlich nichtpharmakologischer Verfahren und Unsicherheiten in der Evidenz. In den Titeln treten konservative Versorgung ohne Dialyse, gemeinsame Entscheidungsfindung und Lebensqualität weniger hervor. Das heißt nicht, dass sie nicht vorkommen. Sie verdienten einen sichtbarer Platz.</p>
<p>Fachliche Breite trifft auf die Uhr. Ein pädiatrischer Block erst am Donnerstagabend und kurze Diskussionen nach mehreren Vorträgen können den Erfahrungsaustausch begrenzen.</p>
<p>Insgesamt ist das ein inhaltlich starkes Programm. Seinen Wert zeigt nicht die Zahl der Neuheiten. Er zeigt sich an einer einfachen Frage: was können wir nach dem Kongress für unsere Patienten besser tun?</p>
<p><em>Dies ist ein Kommentar zum offiziellen Programm vor Kongressbeginn, kein Bericht von den Vorträgen und keine Behandlungsentscheidung für einen einzelnen Patienten.</em></p>
HTML,
        ],
        'fr' => [
            'title' => 'Que pourrons-nous mieux faire pour le patient après le congrès',
            'image_alt' => 'Couloir de montagne violet. À gauche, une forme de rein translucide de lumière turquoise ; à droite, un fauteuil de dialyse vide. Sous la porte fermée, une fine bande turquoise.',
            'excerpt' => 'Le programme du 47e congrès SNefS à Jasná est riche. Statistiques, nouveaux médicaments et accès vasculaires comptent. L’essentiel est ce qui restera en consultation après le 13 novembre 2026.',
            'content' => <<<'HTML'
<p>Du 11 au 13 novembre 2026, l’Hôtel Grand à Jasná accueille le <a href="https://nefro2026.sk">47e congrès de la Société néphrologique slovaque</a>. Le <a href="https://nefro2026.sk/program.php">programme</a> est public. Les conférences ne le sont pas encore. Ce texte commente le planning, ce n’est pas un compte rendu de salle.</p>
<p>Le 30 octobre 2026, un courriel annonçait que le programme scientifique était prêt. Le lien menait au site, non à une pièce jointe. À partir du planning publié, j’ai écrit sur Nefro-projekt un <a href="https://nefro.polascin.net/article.php?slug=komentar-program-47-kongres-snefs-2026">commentaire plus long</a>. Ici je retiens une phrase : une nouveauté qui n’arrive pas au patient n’est qu’une liste.</p>
<p>Le programme montre une discipline qui passe du seul remplacement de la fonction rénale vers le dépistage précoce, la néphroprotection et le traitement ciblé. C’est la bonne direction. Ce qui décidera, c’est dans quelle mesure les connaissances deviennent des soins disponibles, sûrs et réalisables.</p>
<p>Placer d’emblée les statistiques néphrologiques et transplantationnelles est une bonne décision. Un débat sur l’avenir de la néphrologie slovaque doit d’abord nommer l’état actuel. Les présentations sur l’étude SIRIUS, le projet Reins forts et les données épidémiologiques nationales peuvent apporter un regard local. Il faut cependant distinguer le résultat d’une cohorte de dépistage, l’expérience d’un centre et les chiffres qui supportent une généralisation à toute la population.</p>
<p>Un point fort est le lien entre néphrologie clinique et nouvelles options diagnostiques et thérapeutiques. La néphropathie à IgA, les glomérulopathies médiées par le complément et le diagnostic de rejet par ADN libre du donneur peuvent changer les décisions. Lors de leur présentation, la sécurité, le choix du patient, l’accès aux examens et les possibilités réelles de remboursement ne doivent pas reculer.</p>
<p>Pour la dialyse au quotidien, les conférences sur les méthodes à domicile, la préparation prétransplantationnelle et les accès vasculaires sont précieuses. La question de savoir où l’on perd du temps avant la transplantation peut compter autant pour le patient qu’une nouvelle technologie. Le bloc du vendredi sur l’échographie, la canulation et les complications des accès a donc un fort potentiel pratique.</p>
<p>J’apprécie aussi le bloc distinct sur les reins et l’environnement. Pour les microplastiques, il faut séparer clairement la plausibilité biologique et les données expérimentales des conséquences cliniques prouvées. Pour la durabilité écologique de la dialyse, il faut évaluer la consommation d’eau, d’énergie et de matériel avec la sécurité et les résultats du traitement.</p>
<p>Le programme pose aussi la question de l’équilibre. Les symposiums d’entreprise et les conférences soutenues sont clairement indiqués, ce qui est juste. L’étiquette seule ne remplace pas une comparaison critique des options, y compris les approches non pharmacologiques et les incertitudes des preuves. Les titres font moins apparaître les soins conservateurs sans dialyse, la décision partagée et la qualité de vie. Cela ne signifie pas qu’ils n’apparaîtront pas. Ils mériteraient une place plus visible.</p>
<p>La richesse se heurte au temps. Un bloc pédiatrique placé le jeudi soir et de courtes discussions après plusieurs conférences peuvent limiter l’échange d’expérience.</p>
<p>Dans l’ensemble, c’est un programme solide. Sa valeur ne se mesurera pas au nombre de nouveautés. Elle se mesurera à une question simple : que pourrons-nous mieux faire pour nos patients après le congrès ?</p>
<p><em>Il s’agit d’un commentaire sur le programme officiel avant le début du congrès, non d’un compte rendu des conférences ni d’une décision thérapeutique pour un patient précis.</em></p>
HTML,
        ],
        'es' => [
            'title' => 'Qué podremos hacer mejor por el paciente después del congreso',
            'image_alt' => 'Pasillo de montaña violeta. A la izquierda, una forma de riñón translúcida de luz turquesa; a la derecha, un sillón de diálisis vacío. Bajo la puerta cerrada, una fina franja turquesa.',
            'excerpt' => 'El programa del 47.º congreso SNefS en Jasná es sólido. Estadísticas, fármacos nuevos y accesos vasculares importan. Lo decisivo es qué quedará en la consulta después del 13 de noviembre de 2026.',
            'content' => <<<'HTML'
<p>Del 11 al 13 de noviembre de 2026, el Hotel Grand en Jasná acoge el <a href="https://nefro2026.sk">47.º congreso de la Sociedad Nefrológica Eslovaca</a>. El <a href="https://nefro2026.sk/program.php">programa</a> es público. Las ponencias aún no. Este texto comenta el horario, no es un informe desde la sala.</p>
<p>El 30 de octubre de 2026 llegó un correo anunciando que el programa científico estaba listo. El enlace llevaba a la web, no a un adjunto. A partir del horario publicado escribí en Nefro-projekt un <a href="https://nefro.polascin.net/article.php?slug=komentar-program-47-kongres-snefs-2026">comentario más amplio</a>. Aquí retengo una frase: una novedad que no llega al paciente es solo una lista.</p>
<p>El programa muestra una especialidad que se desplaza del solo reemplazo de la función renal hacia la detección temprana, la nefroprotección y el tratamiento dirigido. Esa es la dirección correcta. Decirá hasta qué punto el conocimiento se convierte en atención disponible, segura y viable.</p>
<p>Abrir con la estadística nefrológica y de trasplante es una buena decisión. El debate sobre el futuro de la nefrología eslovaca necesita primero nombrar el estado actual. Las presentaciones del estudio SIRIUS, el proyecto Riñones fuertes y los datos epidemiológicos nacionales pueden aportar una mirada local. Hay que distinguir, sin embargo, el resultado de una cohorte de cribado, la experiencia de un centro y los datos que sostienen una generalización a toda la población.</p>
<p>Un punto fuerte es el vínculo entre nefrología clínica y nuevas opciones diagnósticas y terapéuticas. La nefropatía IgA, las glomerulopatías mediadas por complemento y el diagnóstico de rechazo con ADN libre del donante pueden cambiar decisiones. Al presentarlas, la seguridad, la selección del paciente, el acceso a pruebas y las posibilidades reales de financiación no deben quedar atrás.</p>
<p>Para la diálisis cotidiana son valiosas las ponencias sobre métodos domiciliarios, preparación pretrasplante y accesos vasculares. La pregunta de dónde se pierde tiempo antes del trasplante puede importar al paciente tanto como una tecnología nueva. El bloque del viernes sobre ecografía, canulación y complicaciones de los accesos tiene por eso un claro potencial práctico.</p>
<p>Valoro también el bloque aparte sobre riñones y medio ambiente. Con los microplásticos hay que separar con claridad la plausibilidad biológica y los hallazgos experimentales de las consecuencias clínicas demostradas. Con la sostenibilidad ecológica de la diálisis hay que valorar el consumo de agua, energía y material junto con la seguridad y los resultados del tratamiento.</p>
<p>El programa abre también la cuestión del equilibrio. Los simposios de empresa y las ponencias patrocinadas están claramente señalados, lo cual es correcto. La etiqueta sola no sustituye una comparación crítica de opciones, incluidos enfoques no farmacológicos e incertidumbres en la evidencia. En los títulos aparecen menos los cuidados conservadores sin diálisis, la decisión compartida y la calidad de vida. No significa que no se oigan. Merecerían un espacio más visible.</p>
<p>La amplitud choca con el reloj. Un bloque pediátrico colocado el jueves por la noche y debates breves tras varias ponencias pueden limitar el intercambio de experiencia.</p>
<p>En conjunto es un programa sólido. Su valor no lo mostrará el número de novedades. Lo mostrará una pregunta sencilla: ¿qué podremos hacer mejor por nuestros pacientes después del congreso?</p>
<p><em>Es un comentario al programa oficial antes del inicio del congreso, no un informe de las ponencias ni una decisión terapéutica para un paciente concreto.</em></p>
HTML,
        ],
        'pl' => [
            'title' => 'Co po kongresie potrafimy zrobić lepiej dla pacjenta',
            'image_alt' => 'Fioletowy górski korytarz. Po lewej półprzezroczysty kształt nerki z turkusowego światła, po prawej puste krzesło dializacyjne. Pod zamkniętymi drzwiami cienki turkusowy pas.',
            'excerpt' => 'Program 47. kongresu SNefS w Jasnej jest treściowo mocny. Statystyka, nowe leki i dostępy naczyniowe mają sens. Decydujące pozostaje, co z tego po 13 listopada 2026 zostanie w poradni.',
            'content' => <<<'HTML'
<p>Od 11 do 13 listopada 2026 w Hotelu Grand w Jasnej odbędzie się <a href="https://nefro2026.sk">47. kongres Słowackiego Towarzystwa Nefrologicznego</a>. <a href="https://nefro2026.sk/program.php">Program</a> jest publiczny. Wykłady jeszcze nie. Ten tekst to komentarz do rozkładu, nie sprawozdanie z sali.</p>
<p>30 października 2026 przyszedł e-mail, że program naukowy jest gotowy. Link prowadził na stronę, nie do załącznika. Ze opublikowanego rozkładu napisałem na Nefro-projekcie <a href="https://nefro.polascin.net/article.php?slug=komentar-program-47-kongres-snefs-2026">szerszy komentarz</a>. Tu trzymam jedno zdanie: nowość, która nie dojdzie do pacjenta, to tylko lista.</p>
<p>Program pokazuje dziedzinę, która przesuwa się od samej zastępczej terapii nerki ku wczesnemu wykrywaniu, nefroprotekcji i leczeniu celowanemu. To właściwy kierunek. Zdecyduje to, na ile wiedza zmieni się w opiekę dostępną, bezpieczną i wykonalną.</p>
<p>Umieszczenie statystyki nefrologicznej i transplantacyjnej zaraz na początku to dobra decyzja. Dyskusja o przyszłości słowackiej nefrologii potrzebuje najpierw nazwania stanu obecnego. Kolejne prezentacje badania SIRIUS, projektu Silne nerki i krajowych danych epidemiologicznych mogą przynieść lokalny punkt widzenia. Trzeba jednak rozróżniać wynik kohorty przesiewowej, doświadczenie jednego ośrodka i dane, które uniosą uogólnienie na całą populację.</p>
<p>Mocną stroną jest połączenie nefrologii klinicznej z nowymi możliwościami diagnostycznymi i leczniczymi. Nefropatia IgA, glomerulopatie zależne od dopełniacza czy diagnostyka odrzucania za pomocą wolnego DNA dawcy mogą zmieniać decyzje. Przy ich prezentacji nie mogą ustąpić bezpieczeństwo, dobór pacjenta, dostępność badań i realne możliwości refundacji.</p>
<p>Dla codziennej praktyki dializacyjnej cenne są wykłady o metodach domowych, przygotowaniu przedtransplantacyjnym i dostępach naczyniowych. Pytanie, gdzie przy przygotowaniu do przeszczepienia tracimy czas, może być dla pacjenta równie ważne jak przedstawienie nowej technologii. Piątkowy blok o ultrasonografii, kaniulacji i powikłaniach dostępów ma więc wyraźny potencjał praktyczny.</p>
<p>Osobny blok o nerkach i środowisku doceniam. Przy mikroplastikach trzeba wyraźnie oddzielić wiarygodność biologiczną i ustalenia doświadczalne od wykazanych skutków klinicznych. Przy ekologicznej zrównoważoności dializy trzeba oceniać zużycie wody, energii i materiału wraz z bezpieczeństwem i wynikami leczenia.</p>
<p>Program otwiera też pytanie o równowagę. Sympozja firmowe i wspierane wykłady są wyraźnie oznaczone, co jest właściwe. Samo oznaczenie nie zastępuje jednak krytycznego porównania możliwości, w tym postępowań niefarmakologicznych i niepewności w dowodach. W tytułach rzadziej widać opiekę zachowawczą bez dializy, wspólne podejmowanie decyzji i jakość życia. Nie znaczy to, że nie wybrzmią. Zasługiwałyby na bardziej widoczne miejsce.</p>
<p>Różnorodność treści zderza się z czasem. Blok pediatryczny dopiero w czwartek wieczorem i krótkie dyskusje przy wielu wykładach mogą ograniczyć wymianę doświadczeń.</p>
<p>Ogółem to treściowo mocny program. Jego wartości nie pokaże liczba nowości. Pokaże ją odpowiedź na proste pytanie: co po kongresie potrafimy zrobić lepiej dla swoich pacjentów?</p>
<p><em>To komentarz do oficjalnego programu przed początkiem kongresu, nie sprawozdanie z wykładów i nie decyzja lecznicza dla konkretnego pacjenta.</em></p>
HTML,
        ],
        'hu' => [
            'title' => 'Mit tudunk jobban csinálni a betegért a kongresszus után',
            'image_alt' => 'Lila hegyi folyosó. Balra áttetsző veseforma türkiz fényből, jobbra üres dialízisszék. A zárt ajtó alatt vékony türkiz sáv.',
            'excerpt' => 'A 47. SNefS-kongresszus programja Jasnában tartalmilag erős. A statisztika, az új gyógyszerek és az érhozzáférések számítanak. A döntő az, mi marad a rendelőben 2026. november 13. után.',
            'content' => <<<'HTML'
<p>2026. november 11. és 13. között a jasnái Hotel Grandban tartják a <a href="https://nefro2026.sk">Szlovák Nefrológiai Társaság 47. kongresszusát</a>. A <a href="https://nefro2026.sk/program.php">program</a> nyilvános. Az előadások még nem. Ez a szöveg a menetrend kommentárja, nem teremjelentés.</p>
<p>2026. október 30-án e-mail jött arról, hogy a szakmai program kész. A hivatkozás az oldalra vezetett, nem mellékletre. A közzétett menetrendből a Nefro-projekten <a href="https://nefro.polascin.net/article.php?slug=komentar-program-47-kongres-snefs-2026">hosszabb kommentárt</a> írtam. Itt egy mondatot tartok: az újdonság, amely nem jut el a beteghez, csak lista.</p>
<p>A program olyan szakmát mutat, amely a vesepótló kezeléstől a korai felismerés, a nefroprotekció és a célzott terápia felé mozdul. Ez a helyes irány. Az dönti el, mennyire válik a tudás elérhető, biztonságos és megvalósítható ellátássá.</p>
<p>A nefrológiai és transzplantációs statisztika elejére helyezése jó döntés. A szlovák nefrológia jövőjéről szóló vitához előbb a jelen állapotot kell megnevezni. A SIRIUS-vizsgálat, az Erős vesék projekt és a nemzeti epidemiológiai adatok bemutatása hazai nézőpontot hozhat. Meg kell azonban különböztetni a szűrő kohorsz eredményét, egy központ tapasztalatát és azokat az adatokat, amelyek az egész népességre általánosíthatók.</p>
<p>Erősség a klinikai nefrológia összekapcsolása új diagnosztikai és terápiás lehetőségekkel. Az IgA-nefropátia, a komplement közvetítette glomerulopátiák és a donor eredetű sejmentes DNS-sel végzett rejekciódiagnosztika megváltoztathatja a döntéseket. Bemutatásukkor a biztonság, a betegválasztás, a vizsgálatok elérhetősége és a valós finanszírozás nem szorulhat háttérbe.</p>
<p>A mindennapi dialízisgyakorlat számára értékesek az otthoni módszerekről, a pretranszplantációs előkészítésről és az érhozzáférésekről szóló előadások. Az a kérdés, hol veszítünk időt a transzplantáció előkészítésében, a beteg számára ugyanolyan fontos lehet, mint egy új technológia. A pénteki ultrahang-, kanülálás- és szövődményblokk ezért erős gyakorlati lehetőséget kínál.</p>
<p>A vesékről és a környezetről szóló külön blokkot értékelem. A mikroplasztikáknál világosan el kell választani a biológiai hihetőséget és a kísérleti ismereteket a bizonyított klinikai következményektől. A dialízis ökológiai fenntarthatóságánál a víz, az energia és az anyag fogyasztását a biztonsággal és a kezelési eredményekkel együtt kell értékelni.</p>
<p>A program a kiegyensúlyozottság kérdését is felveti. A céges szimpóziumok és a támogatott előadások egyértelműen jelöltek, ez helyes. Maga a jelölés nem helyettesíti a lehetőségek kritikus összevetését, beleértve a nem gyógyszeres eljárásokat és a bizonyítékok bizonytalanságát. A címekben kevésbé jelenik meg a dialízis nélküli konzervatív ellátás, a közös döntéshozatal és az életminőség. Ez nem jelenti, hogy nem hangzanak el. Láthatóbb helyet érdemelnének.</p>
<p>A szakmai sokféleség az időbe ütközik. A csütörtök esti gyermekgyógyászati blokk és több előadás utáni rövid vita korlátozhatja a tapasztalatcserét.</p>
<p>Összességében tartalmilag erős programról van szó. Értékét nem az újdonságok száma mutatja meg. Egy egyszerű kérdésre adott válasz mutatja: mit tudunk jobban csinálni a betegeinkért a kongresszus után?</p>
<p><em>Ez a hivatalos program kommentárja a kongresszus kezdete előtt, nem előadásjelentés és nem kezelési döntés konkrét beteg számára.</em></p>
HTML,
        ],
        'it' => [
            'title' => 'Cosa potremo fare meglio per il paziente dopo il congresso',
            'image_alt' => 'Corridoio di montagna viola. A sinistra una forma di rene traslucida di luce turchese; a destra una poltrona di dialisi vuota. Sotto la porta chiusa una sottile fascia turchese.',
            'excerpt' => 'Il programma del 47º congresso SNefS a Jasná è solido. Statistiche, nuovi farmaci e accessi vascolari contano. Resta decisivo ciò che resterà in ambulatorio dopo il 13 novembre 2026.',
            'content' => <<<'HTML'
<p>Dall’11 al 13 novembre 2026 l’Hotel Grand a Jasná ospita il <a href="https://nefro2026.sk">47º congresso della Società nefrologica slovacca</a>. Il <a href="https://nefro2026.sk/program.php">programma</a> è pubblico. Le relazioni non ancora. Questo testo è un commento all’orario, non un resoconto dalla sala.</p>
<p>Il 30 ottobre 2026 è arrivata un’e-mail che annunciava pronto il programma scientifico. Il collegamento portava al sito, non a un allegato. Dall’orario pubblicato ho scritto su Nefro-projekt un <a href="https://nefro.polascin.net/article.php?slug=komentar-program-47-kongres-snefs-2026">commento più ampio</a>. Qui tengo una frase: una novità che non arriva al paziente è solo un elenco.</p>
<p>Il programma mostra una disciplina che si sposta dalla sola sostituzione della funzione renale verso l’individuazione precoce, la nefroprotezione e la terapia mirata. È la direzione giusta. Deciderà quanto le conoscenze diventino cure disponibili, sicure e praticabili.</p>
<p>Mettere subito le statistiche nefrologiche e trapiantologiche è una buona decisione. Il dibattito sul futuro della nefrologia slovacca deve prima nominare lo stato attuale. Le presentazioni sullo studio SIRIUS, sul progetto Reni forti e sui dati epidemiologici nazionali possono offrire uno sguardo locale. Occorre però distinguere il risultato di una coorte di screening, l’esperienza di un centro e i dati che reggono una generalizzazione all’intera popolazione.</p>
<p>Un punto di forza è il collegamento tra nefrologia clinica e nuove opzioni diagnostiche e terapeutiche. La nefropatia da IgA, le glomerulopatie mediate dal complemento e la diagnosi di rigetto con DNA libero del donatore possono cambiare le decisioni. Nella loro presentazione non devono restare indietro sicurezza, selezione del paziente, accesso agli esami e possibilità reali di rimborso.</p>
<p>Per la dialisi quotidiana sono preziose le relazioni su metodi domiciliari, preparazione pretrapianto e accessi vascolari. La domanda su dove si perde tempo prima del trapianto può contare per il paziente quanto una nuova tecnologia. Il blocco del venerdì su ecografia, cannule e complicanze degli accessi ha perciò un chiaro potenziale pratico.</p>
<p>Apprezzo anche il blocco separato su reni e ambiente. Con le microplastiche occorre separare con chiarezza la plausibilità biologica e i dati sperimentali dalle conseguenze cliniche dimostrate. Con la sostenibilità ecologica della dialisi occorre valutare il consumo di acqua, energia e materiale insieme a sicurezza ed esiti di cura.</p>
<p>Il programma apre anche la questione dell’equilibrio. I simposi aziendali e le relazioni sostenute sono chiaramente segnalati, ed è giusto. L’etichetta da sola non sostituisce un confronto critico delle opzioni, inclusi gli approcci non farmacologici e le incertezze delle prove. Nei titoli compaiono meno le cure conservative senza dialisi, la decisione condivisa e la qualità di vita. Non significa che non si sentiranno. Meriterebbero uno spazio più visibile.</p>
<p>La ricchezza urta contro il tempo. Un blocco pediatrico collocato giovedì sera e discussioni brevi dopo più relazioni possono limitare lo scambio di esperienza.</p>
<p>Nel complesso è un programma solido. Il suo valore non lo mostrerà il numero di novità. Lo mostrerà una domanda semplice: cosa potremo fare meglio per i nostri pazienti dopo il congresso?</p>
<p><em>È un commento al programma ufficiale prima dell’inizio del congresso, non un resoconto delle relazioni né una decisione terapeutica per un paziente concreto.</em></p>
HTML,
        ],
        'uk' => [
            'title' => 'Що після конгресу зможемо зробити краще для пацієнта',
            'image_alt' => 'Фіолетовий гірський коридор. Ліворуч напівпрозора форма нирки з бірюзового світла, праворуч порожнє діалізне крісло. Під зачиненими дверима тонка бірюзова смуга.',
            'excerpt' => 'Програма 47-го конгресу SNefS у Ясній змістовна. Статистика, нові ліки й судинні доступи мають сенс. Вирішальним лишається те, що після 13 листопада 2026 залишиться в амбулаторії.',
            'content' => <<<'HTML'
<p>З 11 до 13 листопада 2026 в готелі Grand у Ясній відбудеться <a href="https://nefro2026.sk">47-й конгрес Словацького нефрологічного товариства</a>. <a href="https://nefro2026.sk/program.php">Програма</a> вже відкрита. Доповідей ще немає. Цей текст: коментар до розкладу, не звіт із зали.</p>
<p>30 жовтня 2026 надійшов лист, що наукова програма готова. Посилання вело на сайт, не на вкладення. З оприлюдненого розкладу я написав на Nefro-проекті <a href="https://nefro.polascin.net/article.php?slug=komentar-program-47-kongres-snefs-2026">ширший коментар</a>. Тут тримаю одну фразу: новинка, яка не дійде до пацієнта, лише список.</p>
<p>Програма показує галузь, що зміщується від самої замісної терапії нирок до раннього виявлення, нефропротекції та цільового лікування. Це правильний напрям. Вирішить те, наскільки знання стануть доступною, безпечною і здійсненною допомогою.</p>
<p>Поставити нефрологічну й трансплантаційну статистику одразу на початок: добре рішення. Дискусія про майбутнє словацької нефрології потребує спершу назвати нинішній стан. Наступні презентації дослідження SIRIUS, проєкту Міцні нирки та національних епідеміологічних даних можуть дати місцевий погляд. Треба однак розрізняти результат скринінгової когорти, досвід одного центру й дані, які витримають узагальнення на всю популяцію.</p>
<p>Сильна сторона: зв’язок клінічної нефрології з новими діагностичними й лікувальними можливостями. IgA-нефропатія, гломерулопатії, опосередковані комплементом, і діагностика відторгнення за допомогою донорської вільної ДНК можуть змінювати рішення. Під час їхнього представлення не мають відступати безпека, відбір пацієнта, доступність обстежень і реальні можливості оплати.</p>
<p>Для щоденної діалізної практики цінні доповіді про домашні методи, передтрансплантаційну підготовку та судинні доступи. Питання, де під час підготовки до трансплантації ми втрачаємо час, може бути для пацієнта так само важливим, як показ нової технології. П’ятничний блок про ультразвук, канюляцію й ускладнення доступів має тому виразний практичний потенціал.</p>
<p>Окремий блок про нирки й довкілля ціную. При мікропластиках треба чітко відокремити біологічну правдоподібність і експериментальні дані від доведених клінічних наслідків. При екологічній стійкості діалізу треба оцінювати витрати води, енергії й матеріалу разом із безпекою та результатами лікування.</p>
<p>Програма також відкриває питання рівноваги. Корпоративні симпозіуми й підтримані доповіді чітко позначені, і це правильно. Саме позначення не замінює критичного порівняння варіантів, включно з нефармакологічними підходами та непевністю доказів. У назвах менше видно консервативну допомогу без діалізу, спільне прийняття рішень і якість життя. Це не означає, що їх не почують. Вони заслуговували б на помітніше місце.</p>
<p>Змістовне розмаїття впирається в час. Педіатричний блок, поставлений аж на четвер увечері, і короткі дискусії після кількох доповідей можуть обмежити обмін досвідом.</p>
<p>Загалом це змістовно сильна програма. Її цінність не покаже кількість новинок. Покаже відповідь на просте питання: що після конгресу зможемо робити краще для своїх пацієнтів?</p>
<p><em>Це коментар до офіційної програми перед початком конгресу, не звіт із доповідей і не лікувальне рішення для конкретного пацієнта.</em></p>
HTML,
        ],
    ],
];
