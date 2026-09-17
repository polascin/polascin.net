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
 * Osobný blogový príspevok: prechod medzi molekulami GLP-1 pri liečbe Medrolom.
 * Zdroj: vlastný e-mail diabetológovi z 13. 9. 2026.
 */
return [
    'slug' => 'lekar-ako-pacient-glp1-a-kortikosteroidy',
    'author' => 'MUDr. Ľubomír Polaščín',
    'category' => 'blog',
    'is_top' => 1,
    'published_at' => '2026-09-17 18:45:00',
    'image' => 'images/articles/lekar-ako-pacient-glp1-a-kortikosteroidy.webp',
    'translations' => [
        'sk' => [
            'title' => 'Lekári sú najpozornejší pacienti',
            'image_alt' => 'Lekár sedí na vyšetrovacom lôžku ako pacient: v jednej ruke pero GLP-1, v druhej kortikosteroidy.',
            'excerpt' => 'Čo som sa naučil pri prechode medzi tromi molekulami GLP-1, kým som zároveň užíval Medrol. Glykémie 16–18 mmol/l, návrat potravinového šumu a pohľad lekára, ktorý je zároveň pacientom.',
            'content' => <<<'HTML'
<p>Minulý týždeň som prešiel zo semaglutidu na tirzepatid (Mounjaro 5&nbsp;mg). Dôvod bol prostý: zároveň užívam Medrol a hyperglykémia vyvolaná kortikosteroidmi je brutálna. Glykémie 16–18&nbsp;mmol/l. Dávky inzulínu NovoMix, ktoré som mesiace nepotreboval.</p>
<p>Prekvapilo ma však niečo iné: návrat potravinového šumu — <em>food noise</em>.</p>
<p>To stále, vtieravé myslenie na jedlo, ktoré semaglutid potichu vypol, sa vrátilo v priebehu dní po zmene. Nie preto, že by bol tirzepatid slabší. Ale preto, že súhra medzi signálmi chuti do jedla a inzulínovou rezistenciou z kortikosteroidov je zložitejšia, než vysvetlí jeden receptor.</p>
<p>Nízkosacharidové jedlá to paradoxne zhoršili. Bielkoviny a tuk bez sacharidov hlad prehĺbili, namiesto toho, aby ho utíšili. Takú vec si prečítate v štúdiách; inak ju cítite, keď ide o vlastné telo.</p>
<p>V tom istom období som stihol aj krátky pokus s retratrutidom. Iná molekula, iný receptorový profil, iný zážitok. Dáta o týchto liekoch sa hýbu rýchlejšie, než stíhajú klinické odporúčania.</p>
<p>Nejde o to, ktorá molekula „vyhrala“. Ide o to, že ako lekár som vedel zdokumentovať každú premennú. Ako pacient som každú z nich cítil. Takýto dvojitý pohľad by som prial zažiť viacerým kolegom na vlastnej koži.</p>
<p>Ak pracujete s pacientmi na inkretínovej liečbe — najmä súbežne so steroidmi — aké vzorce ste videli? Napíšte mi cez <a href="contact.php">kontakt</a>.</p>
<p><em>Ide o osobnú skúsenosť, nie o liečebné odporúčanie. Rozhodnutia o liečbe patria do rozhovoru s ošetrujúcim lekárom.</em></p>
HTML,
        ],
        'en' => [
            'title' => 'Doctors make the most observant patients',
            'image_alt' => 'A physician sits on an exam table as a patient, holding a GLP-1 injection pen and corticosteroid tablets.',
            'excerpt' => 'What I learned switching between three GLP-1 molecules while on Medrol. Glucose spikes of 16–18 mmol/L, the return of food noise, and the view from a physician who is also the patient.',
            'content' => <<<'HTML'
<p>Last week I moved from semaglutide to tirzepatide (Mounjaro 5&nbsp;mg). The reason was straightforward: I am also on Medrol, and corticosteroid-induced hyperglycemia is brutal. Glucose spikes of 16–18&nbsp;mmol/L. NovoMix insulin doses I had not needed in months.</p>
<p>What surprised me was the return of food noise.</p>
<p>That constant, intrusive thinking about food — the thing semaglutide had quietly switched off — came back within days of the switch. Not because tirzepatide is weaker. But because the interplay between appetite signaling and corticosteroid-driven insulin resistance is more complex than any single receptor explains.</p>
<p>Low-carb meals made it worse, paradoxically. Protein and fat without carbohydrate deepened the hunger rather than satisfying it. The kind of thing you read about in trials but feel differently when it is your own body.</p>
<p>I also ran a short retatrutide trial during this period. A different molecule, a different receptor profile, a different experience. The data on these drugs is moving faster than clinical guidelines can track.</p>
<p>The point is not which drug “won.” It is that as a physician I could document every variable. As a patient, I felt every one of them. That dual perspective is something I wish more of my colleagues had the chance to experience firsthand.</p>
<p>If you work with patients on incretin therapies — especially alongside steroids — what patterns have you seen? Write to me via the <a href="contact.php">contact form</a>.</p>
<p><em>This is personal experience, not medical advice. Treatment decisions belong in a conversation with the treating physician.</em></p>
HTML,
        ],
        'cs' => [
            'title' => 'Lékaři jsou nejpozornější pacienti',
            'image_alt' => 'Lékař sedí na vyšetřovacím lůžku jako pacient: v jedné ruce pero GLP-1, v druhé kortikosteroidy.',
            'excerpt' => 'Co jsem se naučil při přechodu mezi třemi molekulami GLP-1, zatímco jsem zároveň užíval Medrol. Glykemie 16–18 mmol/l, návrat potravinového šumu a pohled lékaře, který je zároveň pacientem.',
            'content' => <<<'HTML'
<p>Minulý týden jsem přešel ze semaglutidu na tirzepatid (Mounjaro 5&nbsp;mg). Důvod byl prostý: zároveň užívám Medrol a hyperglykemie vyvolaná kortikosteroidy je brutální. Glykemie 16–18&nbsp;mmol/l. Dávky inzulinu NovoMix, které jsem měsíce nepotřeboval.</p>
<p>Překvapilo mě však něco jiného: návrat potravinového šumu — <em>food noise</em>.</p>
<p>To stálé, vtíravé myšlení na jídlo, které semaglutid potichu vypnul, se vrátilo během dnů po změně. Ne proto, že by byl tirzepatid slabší. Ale proto, že souhra mezi signály chuti k jídlu a inzulinovou rezistencí z kortikosteroidů je složitější, než vysvětlí jeden receptor.</p>
<p>Nízkosacharidová jídla to paradoxně zhoršila. Bílkoviny a tuk bez sacharidů hlad prohloubily, místo aby ho utišily. Takovou věc si přečtete ve studiích; jinak ji cítíte, když jde o vlastní tělo.</p>
<p>Ve stejném období jsem stihl i krátký pokus s retratrutidem. Jiná molekula, jiný receptorový profil, jiný zážitek. Data o těchto lécích se hýbou rychleji, než stíhají klinická doporučení.</p>
<p>Nejde o to, která molekula „vyhrála“. Jde o to, že jako lékař jsem uměl zdokumentovat každou proměnnou. Jako pacient jsem každou z nich cítil. Takový dvojí pohled bych přál zažít více kolegům na vlastní kůži.</p>
<p>Pokud pracujete s pacienty na inkretinové léčbě — zejména souběžně se steroidy — jaké vzorce jste viděli? Napište mi přes <a href="contact.php">kontakt</a>.</p>
<p><em>Jde o osobní zkušenost, nikoli o léčebné doporučení. Rozhodnutí o léčbě patří do rozhovoru s ošetřujícím lékařem.</em></p>
HTML,
        ],
        'de' => [
            'title' => 'Ärzte sind die aufmerksamsten Patienten',
            'image_alt' => 'Ein Arzt sitzt als Patient auf der Untersuchungsliege: in der einen Hand ein GLP-1-Pen, in der anderen Kortikosteroide.',
            'excerpt' => 'Was ich beim Wechsel zwischen drei GLP-1-Molekülen gelernt habe, während ich zugleich Medrol einnahm. Blutzucker 16–18 mmol/l, die Rückkehr des Food Noise und der Blick eines Arztes, der zugleich Patient ist.',
            'content' => <<<'HTML'
<p>Letzte Woche bin ich von Semaglutid auf Tirzepatid (Mounjaro 5&nbsp;mg) umgestiegen. Der Grund war schlicht: Ich nehme zugleich Medrol, und die kortikosteroidbedingte Hyperglykämie ist brutal. Blutzucker 16–18&nbsp;mmol/l. NovoMix-Insulindosen, die ich monatelang nicht gebraucht hatte.</p>
<p>Überrascht hat mich aber etwas anderes: die Rückkehr des Food Noise.</p>
<p>Dieses ständige, aufdringliche Denken an Essen — das Semaglutid still abgeschaltet hatte — kam innerhalb von Tagen nach dem Wechsel zurück. Nicht weil Tirzepatid schwächer wäre. Sondern weil das Zusammenspiel zwischen Appetitsignalen und kortikosteroidbedingter Insulinresistenz komplexer ist, als ein einzelner Rezeptor erklärt.</p>
<p>Kohlenhydratarme Mahlzeiten haben es paradoxerweise verschlimmert. Eiweiß und Fett ohne Kohlenhydrate haben den Hunger vertieft, statt ihn zu stillen. Sowas liest man in Studien; anders fühlt man es, wenn es der eigene Körper ist.</p>
<p>Im selben Zeitraum habe ich auch einen kurzen Versuch mit Retratrutid gemacht. Ein anderes Molekül, ein anderes Rezeptorprofil, eine andere Erfahrung. Die Daten zu diesen Arzneimitteln bewegen sich schneller, als klinische Leitlinien mithalten können.</p>
<p>Es geht nicht darum, welches Molekül „gewonnen“ hat. Es geht darum, dass ich als Arzt jede Variable dokumentieren konnte. Als Patient habe ich jede einzelne gespürt. Diese doppelte Perspektive wünsche ich mehr Kolleginnen und Kollegen am eigenen Leib.</p>
<p>Wenn Sie Patientinnen und Patienten mit Inkretintherapien betreuen — besonders parallel zu Steroiden — welche Muster haben Sie gesehen? Schreiben Sie mir über das <a href="contact.php">Kontaktformular</a>.</p>
<p><em>Das ist eine persönliche Erfahrung, keine Behandlungsempfehlung. Therapieentscheidungen gehören ins Gespräch mit der behandelnden Ärztin oder dem behandelnden Arzt.</em></p>
HTML,
        ],
        'fr' => [
            'title' => 'Les médecins sont les patients les plus attentifs',
            'image_alt' => 'Un médecin assis sur la table d\'examen en tant que patient : un stylo GLP-1 dans une main, des corticostéroïdes dans l\'autre.',
            'excerpt' => 'Ce que j\'ai appris en passant d\'une molécule GLP-1 à une autre tout en prenant du Médrol. Glycémies à 16–18 mmol/L, retour du food noise, et le regard d\'un médecin qui est aussi le patient.',
            'content' => <<<'HTML'
<p>La semaine dernière, je suis passé du sémaglutide au tirzépatide (Mounjaro 5&nbsp;mg). La raison était simple : je prends aussi du Médrol, et l'hyperglycémie induite par les corticoïdes est brutale. Glycémies à 16–18&nbsp;mmol/L. Des doses d'insuline NovoMix dont je n'avais plus besoin depuis des mois.</p>
<p>Ce qui m'a surpris, c'est le retour du food noise.</p>
<p>Cette pensée constante et intrusive de la nourriture — que le sémaglutide avait discrètement éteinte — est revenue en quelques jours après le changement. Non pas parce que le tirzépatide serait plus faible. Mais parce que l'interaction entre les signaux de l'appétit et la résistance à l'insuline due aux corticoïdes est plus complexe que ce qu'un seul récepteur explique.</p>
<p>Les repas pauvres en glucides ont paradoxalement aggravé la situation. Protéines et lipides sans glucides ont approfondi la faim au lieu de l'apaiser. On lit cela dans les essais ; on le ressent autrement quand il s'agit de son propre corps.</p>
<p>Durant la même période, j'ai aussi fait un court essai de rétratutide. Une autre molécule, un autre profil de récepteurs, une autre expérience. Les données sur ces médicaments évoluent plus vite que les recommandations cliniques.</p>
<p>Il ne s'agit pas de savoir quelle molécule « a gagné ». Il s'agit du fait qu'en tant que médecin, j'ai pu documenter chaque variable. En tant que patient, je les ai toutes ressenties. Ce double regard, je le souhaiterais à davantage de collègues, dans leur propre corps.</p>
<p>Si vous suivez des patients sous traitements incrétines — surtout en parallèle des stéroïdes — quels schémas avez-vous observés ? Écrivez-moi via le <a href="contact.php">formulaire de contact</a>.</p>
<p><em>Il s'agit d'une expérience personnelle, non d'un conseil thérapeutique. Les décisions de traitement appartiennent à la conversation avec le médecin traitant.</em></p>
HTML,
        ],
        'es' => [
            'title' => 'Los médicos son los pacientes más observadores',
            'image_alt' => 'Un médico sentado en la camilla como paciente: un bolígrafo de GLP-1 en una mano y corticoides en la otra.',
            'excerpt' => 'Lo que aprendí al cambiar entre tres moléculas de GLP-1 mientras tomaba Medrol. Glucemias de 16–18 mmol/L, el regreso del food noise y la mirada de un médico que también es el paciente.',
            'content' => <<<'HTML'
<p>La semana pasada pasé de semaglutida a tirzepatida (Mounjaro 5&nbsp;mg). El motivo era sencillo: también tomo Medrol y la hiperglucemia inducida por corticoides es brutal. Glucemias de 16–18&nbsp;mmol/L. Dosis de insulina NovoMix que no había necesitado en meses.</p>
<p>Lo que me sorprendió fue el regreso del food noise.</p>
<p>Ese pensamiento constante e invasivo sobre la comida —lo que la semaglutida había apagado en silencio— volvió a los pocos días del cambio. No porque la tirzepatida sea más débil. Sino porque la interacción entre las señales del apetito y la resistencia a la insulina por corticoides es más compleja de lo que explica un solo receptor.</p>
<p>Las comidas bajas en hidratos de carbono lo empeoraron, paradójicamente. Proteínas y grasas sin hidratos profundizaron el hambre en lugar de calmarla. Eso se lee en los ensayos; se siente de otro modo cuando es el propio cuerpo.</p>
<p>En el mismo periodo también hice un breve ensayo con retratrutida. Otra molécula, otro perfil de receptores, otra experiencia. Los datos sobre estos fármacos se mueven más rápido de lo que pueden seguir las guías clínicas.</p>
<p>No se trata de qué molécula «ganó». Se trata de que, como médico, pude documentar cada variable. Como paciente, sentí cada una de ellas. Esa doble perspectiva se la desearía a más colegas en su propia piel.</p>
<p>Si trabaja con pacientes en terapias incretínicas —sobre todo junto a esteroides— ¿qué patrones ha visto? Escríbame a través del <a href="contact.php">formulario de contacto</a>.</p>
<p><em>Es una experiencia personal, no una recomendación terapéutica. Las decisiones de tratamiento pertenecen a la conversación con el médico responsable.</em></p>
HTML,
        ],
        'pl' => [
            'title' => 'Lekarze są najbardziej uważnymi pacjentami',
            'image_alt' => 'Lekarz siedzi na kozetce jako pacjent: w jednej ręce pen GLP-1, w drugiej kortykosteroidy.',
            'excerpt' => 'Czego nauczyłem się przy przejściu między trzema cząsteczkami GLP-1, gdy jednocześnie brałem Medrol. Glikemie 16–18 mmol/l, powrót food noise i spojrzenie lekarza, który jest zarazem pacjentem.',
            'content' => <<<'HTML'
<p>W zeszłym tygodniu przeszedłem z semaglutydu na tirzepatyd (Mounjaro 5&nbsp;mg). Powód był prosty: jednocześnie biorę Medrol, a hiperglikemia wywołana kortykosteroidami jest brutalna. Glikemie 16–18&nbsp;mmol/l. Dawki insuliny NovoMix, których od miesięcy nie potrzebowałem.</p>
<p>Zaskoczyło mnie jednak coś innego: powrót food noise.</p>
<p>To stałe, natrętne myślenie o jedzeniu — które semaglutyd cicho wyłączył — wróciło w ciągu dni po zmianie. Nie dlatego, że tirzepatyd jest słabszy. Lecz dlatego, że współgra sygnałów apetytu i oporności insulinowej z kortykosteroidów jest bardziej złożona, niż tłumaczy jeden receptor.</p>
<p>Posiłki niskowęglowodanowe paradoksalnie to pogorszyły. Białko i tłuszcz bez węglowodanów pogłębiły głód, zamiast go uciszyć. Taką rzecz czyta się w badaniach; inaczej czuje się ją, gdy chodzi o własne ciało.</p>
<p>W tym samym okresie zdążyłem też na krótki epizod z retratrutydem. Inna cząsteczka, inny profil receptorów, inne doświadczenie. Dane o tych lekach zmieniają się szybciej, niż nadążają zalecenia kliniczne.</p>
<p>Nie chodzi o to, która cząsteczka „wygrała”. Chodzi o to, że jako lekarz umiałem udokumentować każdą zmienną. Jako pacjent każdą z nich czułem. Takiego podwójnego spojrzenia życzyłbym doświadczyć większej liczbie kolegów na własnej skórze.</p>
<p>Jeśli pracujecie z pacjentami na leczeniu inkretynowym — zwłaszcza równolegle ze steroidami — jakie wzorce widzieliście? Napiszcie do mnie przez <a href="contact.php">kontakt</a>.</p>
<p><em>To osobiste doświadczenie, nie zalecenie terapeutyczne. Decyzje o leczeniu należą do rozmowy z lekarzem prowadzącym.</em></p>
HTML,
        ],
        'hu' => [
            'title' => 'Az orvosok a legfigyelmesebb betegek',
            'image_alt' => 'Egy orvos betegként ül a vizsgálóágyon: egyik kezében GLP-1-pen, a másikban kortikoszteroid.',
            'excerpt' => 'Amit három GLP-1-molekula közötti váltáskor tanultam, miközben Medrolt is szedtem. 16–18 mmol/l-es vércukrok, a food noise visszatérése, és egy orvos tekintete, aki egyben a beteg is.',
            'content' => <<<'HTML'
<p>Múlt héten semaglutidról tirzepatidra (Mounjaro 5&nbsp;mg) váltottam. Az ok egyszerű volt: egyúttal Medrolt szedek, és a kortikoszteroid okozta hiperglikémia brutális. Vércukor 16–18&nbsp;mmol/l. NovoMix inzulinadagok, amelyekre hónapokig nem volt szükségem.</p>
<p>Más lepett meg: a food noise visszatérése.</p>
<p>Az az állandó, tolakodó gondolkodás az ételről — amit a semaglutid csendben kikapcsolt — a váltás után napokon belül visszajött. Nem azért, mert a tirzepatid gyengébb lenne. Hanem mert az étvágyjelzések és a kortikoszteroid okozta inzulinrezisztencia összjátéka bonyolultabb, mint amit egyetlen receptor megmagyaráz.</p>
<p>A szénhidrátszegény ételek paradox módon rontottak a helyzeten. Fehérje és zsír szénhidrát nélkül mélyítette az éhséget, ahelyett hogy csillapította volna. Ilyesmit a vizsgálatokban olvas az ember; másképp érzi, ha a saját teste a tét.</p>
<p>Ugyanebben az időszakban egy rövid retratrutid-próbát is beiktattam. Más molekula, más receptorprofil, más élmény. Ezeknek a gyógyszereknek az adatai gyorsabban mozognak, mint a klinikai irányelvek.</p>
<p>Nem az a lényeg, melyik molekula „nyert”. Hanem az, hogy orvosként minden változót dokumentálni tudtam. Betegként mindegyiket éreztem. Ezt a kettős nézőpontot több kollégának kívánnám a saját bőrén.</p>
<p>Ha inkretinkezelésben — különösen szteroiddal együtt — gondoz betegeket: milyen mintázatokat látott? Írjon nekem a <a href="contact.php">kapcsolati űrlapon</a>.</p>
<p><em>Személyes tapasztalat, nem kezelési javaslat. A terápiás döntés a kezelőorvossal folytatott beszélgetéshez tartozik.</em></p>
HTML,
        ],
        'it' => [
            'title' => 'I medici sono i pazienti più attenti',
            'image_alt' => 'Un medico siede sul lettino come paziente: in una mano una penna GLP-1, nell\'altra i corticosteroidi.',
            'excerpt' => 'Cosa ho imparato passando tra tre molecole GLP-1 mentre assumevo anche Medrol. Glicemie 16–18 mmol/L, il ritorno del food noise e lo sguardo di un medico che è anche il paziente.',
            'content' => <<<'HTML'
<p>La settimana scorsa sono passato da semaglutide a tirzepatide (Mounjaro 5&nbsp;mg). Il motivo era semplice: assumo anche Medrol e l'iperglicemia indotta dai corticosteroidi è brutale. Glicemie 16–18&nbsp;mmol/L. Dosi di insulina NovoMix di cui non avevo bisogno da mesi.</p>
<p>Ciò che mi ha sorpreso è stato il ritorno del food noise.</p>
<p>Quel pensiero costante e invadente sul cibo — che il semaglutide aveva spento in silenzio — è tornato nel giro di giorni dal cambio. Non perché il tirzepatide sia più debole. Ma perché l'interazione tra i segnali dell'appetito e la resistenza insulinica da corticosteroidi è più complessa di quanto spieghi un singolo recettore.</p>
<p>I pasti a basso contenuto di carboidrati, paradossalmente, l'hanno peggiorata. Proteine e grassi senza carboidrati hanno approfondito la fame invece di calmarla. È il genere di cosa che si legge negli studi; si sente diversamente quando è il proprio corpo.</p>
<p>Nello stesso periodo ho fatto anche un breve tentativo con retratrutide. Una molecola diversa, un profilo recettoriale diverso, un'esperienza diversa. I dati su questi farmaci si muovono più in fretta di quanto le linee guida cliniche riescano a seguire.</p>
<p>Non si tratta di quale molecola «abbia vinto». Si tratta del fatto che, come medico, ho potuto documentare ogni variabile. Come paziente le ho sentite tutte. Questa doppia prospettiva la augurerei a più colleghi sulla propria pelle.</p>
<p>Se lavorate con pazienti in terapia incretinica — soprattutto in parallelo agli steroidi — quali schemi avete visto? Scrivetemi tramite il <a href="contact.php">modulo di contatto</a>.</p>
<p><em>È un'esperienza personale, non un consiglio terapeutico. Le decisioni di trattamento appartengono al colloquio con il medico curante.</em></p>
HTML,
        ],
        'uk' => [
            'title' => 'Лікарі — найуважніші пацієнти',
            'image_alt' => 'Лікар сидить на кушетці як пацієнт: у одній руці шприц-ручка GLP-1, у іншій кортикостероїди.',
            'excerpt' => 'Чого я навчився, змінюючи три молекули GLP-1, коли водночас приймав Медрол. Глікемії 16–18 ммоль/л, повернення food noise і погляд лікаря, який є також пацієнтом.',
            'content' => <<<'HTML'
<p>Минулого тижня я перейшов із семаглутиду на тирзепатид (Mounjaro 5&nbsp;мг). Причина була проста: я також приймаю Медрол, а гіперглікемія від кортикостероїдів жорстока. Глікемії 16–18&nbsp;ммоль/л. Дози інсуліну NovoMix, яких я місяцями не потребував.</p>
<p>Здивувало мене інше: повернення food noise.</p>
<p>Це постійне, нав'язливе думання про їжу — яке семаглутид тихо вимкнув — повернулося за кілька днів після зміни. Не тому, що тирзепатид слабший. А тому, що взаємодія між сигналами апетиту й інсулінорезистентністю від кортикостероїдів складніша, ніж пояснює один рецептор.</p>
<p>Низьковуглеводні страви парадоксально погіршили ситуацію. Білок і жир без вуглеводів поглибили голод замість того, щоб його вгамувати. Таке читаєш у дослідженнях; інакше відчуваєш, коли йдеться про власне тіло.</p>
<p>У той самий період я встиг і на короткий епізод із ретратрутидом. Інша молекула, інший рецепторний профіль, інший досвід. Дані про ці ліки рухаються швидше, ніж встигають клінічні настанови.</p>
<p>Йдеться не про те, яка молекула «перемогла». Йдеться про те, що як лікар я міг задокументувати кожну змінну. Як пацієнт я кожну з них відчував. Такий подвійний погляд я бажав би більше колегам на власній шкірі.</p>
<p>Якщо ви працюєте з пацієнтами на інкретиновій терапії — особливо разом зі стероїдами — які закономірності ви бачили? Напишіть мені через <a href="contact.php">контакт</a>.</p>
<p><em>Це особистий досвід, а не лікувальне призначення. Рішення про лікування належать розмові з лікарем, який веде пацієнта.</em></p>
HTML,
        ],
    ],
];
