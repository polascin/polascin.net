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
            'excerpt' => 'Čo som sa naučil pri prechode medzi tromi molekulami GLP-1, kým som zároveň užíval Medrol. Glykémie 16 až 18 mmol/l, návrat potravinového šumu a pohľad lekára, ktorý je zároveň pacientom.',
            'content' => <<<'HTML'
<p>Minulý týždeň som prešiel zo semaglutidu na tirzepatid (Mounjaro 5&nbsp;mg). Dôvod bol prostý: zároveň užívam Medrol a hyperglykémia vyvolaná kortikosteroidmi je brutálna. Glykémie 16 až 18&nbsp;mmol/l. Dávky inzulínu NovoMix, ktoré som mesiace nepotreboval.</p>
<p>Prekvapilo ma niečo iné: návrat potravinového šumu (<em>food noise</em>).</p>
<p>To stále, vtieravé myslenie na jedlo, ktoré semaglutid potichu vypol, sa vrátilo v priebehu dní po zmene. Nie preto, že by bol tirzepatid slabší. Súhra medzi signálmi chuti do jedla a inzulínovou rezistenciou z kortikosteroidov je zložitejšia, než vysvetlí jeden receptor.</p>
<p>Nízkosacharidové jedlá to paradoxne zhoršili. Bielkoviny a tuk bez sacharidov hlad prehĺbili, namiesto toho, aby ho utíšili. V štúdii to človek prečíta. Na vlastnom tele to cíti inak.</p>
<p>V tom istom období som stihol aj krátky pokus s retatrutidom. Molekula bola iná, receptorový profil tiež, a iný bol aj zážitok. Údaje o týchto liekoch pribúdajú rýchlejšie, než ich stíhajú klinické odporúčania.</p>
<p>Nezaujíma ma, ktorá molekula „vyhrala“. Ako lekár som vedel každú premennú zapísať. Ako pacient som každú z nich cítil. Ten dvojitý pohľad by som prial viacerým kolegom na vlastnej koži.</p>
<p>Ak pracujete s pacientmi na inkretínovej liečbe, najmä súbežne so steroidmi, čo sa vám pri tom opakovalo?</p>
<p><em>Ide o osobnú skúsenosť, nie o liečebné odporúčanie. Rozhodnutia o liečbe patria do rozhovoru s ošetrujúcim lekárom.</em></p>
HTML,
        ],
        'en' => [
            'title' => 'Doctors make the most observant patients',
            'image_alt' => 'A physician sits on an exam table as a patient, holding a GLP-1 injection pen and corticosteroid tablets.',
            'excerpt' => 'What I learned switching between three GLP-1 molecules while on Medrol. Glucose values of 16 to 18 mmol/L, the return of food noise, and the view from a physician who is also the patient.',
            'content' => <<<'HTML'
<p>Last week I moved from semaglutide to tirzepatide (Mounjaro 5&nbsp;mg). The reason was straightforward: I am also on Medrol, and corticosteroid-induced hyperglycemia is brutal. Glucose values of 16 to 18&nbsp;mmol/L. NovoMix insulin doses I had not needed for months.</p>
<p>What surprised me was the return of food noise.</p>
<p>That constant, intrusive thinking about food, which semaglutide had quietly switched off, came back within days of the change. Not because tirzepatide is weaker. The interplay between appetite signals and corticosteroid-driven insulin resistance is more complex than any single receptor explains.</p>
<p>Low-carbohydrate meals made it worse, paradoxically. Protein and fat without carbohydrate deepened the hunger instead of settling it. You can read that in a study. In your own body it feels different.</p>
<p>In the same period I also tried retatrutide briefly, on myself. The molecule was different, the receptor profile too, and so was the experience. Reports on these drugs are accumulating faster than clinical guidelines can follow.</p>
<p>I am not keeping score of which molecule “won.” As a physician I could record every variable. As a patient I felt every one of them. I wish more colleagues could have that double view in their own bodies.</p>
<p>If you look after patients on incretin therapy, especially alongside steroids, what has kept coming back?</p>
<p><em>This is personal experience, not medical advice. Treatment decisions belong in a conversation with the treating physician.</em></p>
HTML,
        ],
        'cs' => [
            'title' => 'Lékaři jsou nejpozornější pacienti',
            'image_alt' => 'Lékař sedí na vyšetřovacím lůžku jako pacient: v jedné ruce pero GLP-1, v druhé kortikosteroidy.',
            'excerpt' => 'Co jsem se naučil při přechodu mezi třemi molekulami GLP-1, zatímco jsem zároveň užíval Medrol. Glykemie 16 až 18 mmol/l, návrat potravinového šumu a pohled lékaře, který je zároveň pacientem.',
            'content' => <<<'HTML'
<p>Minulý týden jsem přešel ze semaglutidu na tirzepatid (Mounjaro 5&nbsp;mg). Důvod byl prostý: zároveň užívám Medrol a hyperglykemie vyvolaná kortikosteroidy je brutální. Glykemie 16 až 18&nbsp;mmol/l. Dávky inzulinu NovoMix, které jsem měsíce nepotřeboval.</p>
<p>Překvapilo mě něco jiného: návrat potravinového šumu (<em>food noise</em>).</p>
<p>To stálé, vtíravé myšlení na jídlo, které semaglutid potichu vypnul, se vrátilo během dnů po změně. Ne proto, že by byl tirzepatid slabší. Souhra mezi signály chuti k jídlu a inzulinovou rezistencí z kortikosteroidů je složitější, než vysvětlí jeden receptor.</p>
<p>Nízkosacharidová jídla to paradoxně zhoršila. Bílkoviny a tuk bez sacharidů hlad prohloubily, místo aby ho utišily. Ve studii to člověk přečte. Na vlastním těle to cítí jinak.</p>
<p>Ve stejném období jsem stihl i krátký pokus s retatrutidem. Molekula byla jiná, receptorový profil také, a jiný byl i zážitek. Údaje o těchto lécích přibývají rychleji, než je stíhají klinická doporučení.</p>
<p>Nezajímá mě, která molekula „vyhrála“. Jako lékař jsem uměl každou proměnnou zapsat. Jako pacient jsem každou z nich cítil. Ten dvojí pohled bych přál více kolegům na vlastní kůži.</p>
<p>Pokud pracujete s pacienty na inkretinové léčbě, zejména souběžně se steroidy, co se vám při tom opakovalo?</p>
<p><em>Jde o osobní zkušenost, nikoli o léčebné doporučení. Rozhodnutí o léčbě patří do rozhovoru s ošetřujícím lékařem.</em></p>
HTML,
        ],
        'de' => [
            'title' => 'Ärzte sind die aufmerksamsten Patienten',
            'image_alt' => 'Ein Arzt sitzt als Patient auf der Untersuchungsliege: in der einen Hand ein GLP-1-Pen, in der anderen Kortikosteroide.',
            'excerpt' => 'Was ich beim Wechsel zwischen drei GLP-1-Molekülen gelernt habe, während ich zugleich Medrol einnahm. Blutzucker 16 bis 18 mmol/l, die Rückkehr des Food Noise und der Blick eines Arztes, der zugleich Patient ist.',
            'content' => <<<'HTML'
<p>Letzte Woche bin ich von Semaglutid auf Tirzepatid (Mounjaro 5&nbsp;mg) umgestiegen. Der Grund war schlicht: Ich nehme zugleich Medrol, und die kortikosteroidbedingte Hyperglykämie ist brutal. Blutzucker 16 bis 18&nbsp;mmol/l. NovoMix-Insulindosen, die ich monatelang nicht gebraucht hatte.</p>
<p>Überrascht hat mich etwas anderes: die Rückkehr des Food Noise.</p>
<p>Dieses ständige, aufdringliche Denken an Essen, das Semaglutid still abgeschaltet hatte, kam innerhalb von Tagen nach dem Wechsel zurück. Nicht weil Tirzepatid schwächer wäre. Das Zusammenspiel zwischen Appetitsignalen und kortikosteroidbedingter Insulinresistenz ist komplexer, als ein einzelner Rezeptor erklärt.</p>
<p>Kohlenhydratarme Mahlzeiten haben es paradoxerweise verschlimmert. Eiweiß und Fett ohne Kohlenhydrate haben den Hunger vertieft, statt ihn zu stillen. In einer Studie liest man das. Am eigenen Körper fühlt es sich anders an.</p>
<p>Im selben Zeitraum habe ich Retatrutid auch kurz an mir selbst probiert. Das Molekül war ein anderes, das Rezeptorprofil auch, und anders war auch die Erfahrung. Die Angaben zu diesen Arzneimitteln nehmen schneller zu, als die klinischen Leitlinien folgen können.</p>
<p>Mich interessiert nicht, welches Molekül „gewonnen“ hat. Als Arzt konnte ich jede Variable aufschreiben. Als Patient habe ich jede einzelne gespürt. Diesen doppelten Blick wünsche ich mehr Kolleginnen und Kollegen am eigenen Leib.</p>
<p>Wenn Sie Patientinnen und Patienten mit Inkretintherapie betreuen, besonders parallel zu Steroiden: was ist Ihnen dabei wieder begegnet?</p>
<p><em>Das ist eine persönliche Erfahrung, keine Behandlungsempfehlung. Therapieentscheidungen gehören ins Gespräch mit der behandelnden Ärztin oder dem behandelnden Arzt.</em></p>
HTML,
        ],
        'fr' => [
            'title' => 'Les médecins sont les patients les plus attentifs',
            'image_alt' => 'Un médecin assis sur la table d\'examen en tant que patient : un stylo GLP-1 dans une main, des corticostéroïdes dans l\'autre.',
            'excerpt' => 'Ce que j\'ai appris en passant d\'une molécule GLP-1 à une autre tout en prenant du Médrol. Glycémies à 16 à 18 mmol/L, retour du food noise, et le regard d\'un médecin qui est aussi le patient.',
            'content' => <<<'HTML'
<p>La semaine dernière, je suis passé du sémaglutide au tirzépatide (Mounjaro 5&nbsp;mg). La raison était simple : je prends aussi du Médrol, et l'hyperglycémie induite par les corticoïdes est brutale. Glycémies de 16 à 18&nbsp;mmol/L. Des doses d'insuline NovoMix dont je n'avais plus besoin depuis des mois.</p>
<p>Ce qui m'a surpris, c'est le retour du food noise.</p>
<p>Cette pensée constante et intrusive de la nourriture, que le sémaglutide avait discrètement éteinte, est revenue en quelques jours après le changement. Non pas parce que le tirzépatide serait plus faible. L'interaction entre les signaux de l'appétit et la résistance à l'insuline due aux corticoïdes est plus complexe que ce qu'un seul récepteur explique.</p>
<p>Les repas pauvres en glucides ont paradoxalement aggravé la situation. Protéines et lipides sans glucides ont approfondi la faim au lieu de l'apaiser. Dans une étude, on le lit. Dans son propre corps, on le sent autrement.</p>
<p>Durant la même période, j'ai aussi essayé brièvement le rétatrutide, sur moi-même. La molécule était différente, le profil des récepteurs aussi, et l'expérience l'était également. Les données sur ces médicaments s'accumulent plus vite que les recommandations cliniques ne suivent.</p>
<p>Je ne tiens pas le compte de la molécule qui « a gagné ». Comme médecin, j'ai pu noter chaque variable. Comme patient, je les ai toutes ressenties. Ce double regard, je le souhaiterais à davantage de collègues, dans leur propre corps.</p>
<p>Si vous suivez des patients sous traitement incrétine, surtout en parallèle des stéroïdes, qu'est-ce qui vous est revenu ?</p>
<p><em>Il s'agit d'une expérience personnelle, non d'un conseil thérapeutique. Les décisions de traitement appartiennent à la conversation avec le médecin traitant.</em></p>
HTML,
        ],
        'es' => [
            'title' => 'Los médicos son los pacientes más observadores',
            'image_alt' => 'Un médico sentado en la camilla como paciente: un bolígrafo de GLP-1 en una mano y corticoides en la otra.',
            'excerpt' => 'Lo que aprendí al cambiar entre tres moléculas de GLP-1 mientras tomaba Medrol. Glucemias de 16 a 18 mmol/L, el regreso del food noise y la mirada de un médico que también es el paciente.',
            'content' => <<<'HTML'
<p>La semana pasada pasé de semaglutida a tirzepatida (Mounjaro 5&nbsp;mg). El motivo era sencillo: también tomo Medrol y la hiperglucemia inducida por corticoides es brutal. Glucemias de 16 a 18&nbsp;mmol/L. Dosis de insulina NovoMix que no había necesitado en meses.</p>
<p>Lo que me sorprendió fue el regreso del food noise.</p>
<p>Ese pensamiento constante e invasivo sobre la comida, lo que la semaglutida había apagado en silencio, volvió a los pocos días del cambio. No porque la tirzepatida sea más débil. La interacción entre las señales del apetito y la resistencia a la insulina por corticoides es más compleja de lo que explica un solo receptor.</p>
<p>Las comidas bajas en hidratos de carbono lo empeoraron, paradójicamente. Proteínas y grasas sin hidratos profundizaron el hambre en lugar de calmarla. En un estudio se lee. En el propio cuerpo se siente de otro modo.</p>
<p>En el mismo periodo también probé la retatrutida un breve tiempo, en mí mismo. La molécula era otra, el perfil de receptores también, y la experiencia también lo fue. Los datos sobre estos fármacos se acumulan más rápido de lo que las guías clínicas pueden seguirlos.</p>
<p>No llevo la cuenta de qué molécula «ganó». Como médico pude anotar cada variable. Como paciente sentí cada una. Esa doble perspectiva se la desearía a más colegas en su propia piel.</p>
<p>Si atiende a pacientes con tratamiento incretínico, sobre todo junto a esteroides, ¿qué se le ha repetido?</p>
<p><em>Es una experiencia personal, no una recomendación terapéutica. Las decisiones de tratamiento pertenecen a la conversación con el médico responsable.</em></p>
HTML,
        ],
        'pl' => [
            'title' => 'Lekarze są najbardziej uważnymi pacjentami',
            'image_alt' => 'Lekarz siedzi na kozetce jako pacjent: w jednej ręce pen GLP-1, w drugiej kortykosteroidy.',
            'excerpt' => 'Czego nauczyłem się przy przejściu między trzema cząsteczkami GLP-1, gdy jednocześnie brałem Medrol. Glikemie od 16 do 18 mmol/l, powrót food noise i spojrzenie lekarza, który jest zarazem pacjentem.',
            'content' => <<<'HTML'
<p>W zeszłym tygodniu przeszedłem z semaglutydu na tirzepatyd (Mounjaro 5&nbsp;mg). Powód był prosty: jednocześnie biorę Medrol, a hiperglikemia wywołana kortykosteroidami jest brutalna. Glikemie od 16 do 18&nbsp;mmol/l. Dawki insuliny NovoMix, których od miesięcy nie potrzebowałem.</p>
<p>Zaskoczyło mnie coś innego: powrót food noise.</p>
<p>To stałe, natrętne myślenie o jedzeniu, które semaglutyd cicho wyłączył, wróciło w ciągu dni po zmianie. Nie dlatego, że tirzepatyd jest słabszy. Współdziałanie sygnałów apetytu i oporności insulinowej z kortykosteroidów jest bardziej złożone, niż tłumaczy jeden receptor.</p>
<p>Posiłki niskowęglowodanowe paradoksalnie to pogorszyły. Białko i tłuszcz bez węglowodanów pogłębiły głód, zamiast go uciszyć. W badaniu człowiek to przeczyta. Na własnym ciele czuje inaczej.</p>
<p>W tym samym okresie zdążyłem też krótko spróbować retatrutydu, na sobie. Cząsteczka była inna, profil receptorów też, i inne było też doświadczenie. Dane o tych lekach przybywają szybciej, niż nadążają zalecenia kliniczne.</p>
<p>Nie liczę, która cząsteczka „wygrała”. Jako lekarz umiałem każdą zmienną zapisać. Jako pacjent każdą z nich czułem. Takie podwójne spojrzenie życzyłbym większej liczbie kolegów na własnej skórze.</p>
<p>Jeśli pracujecie z pacjentami na leczeniu inkretynowym, zwłaszcza równolegle ze steroidami, co wam się przy tym powtarzało?</p>
<p><em>To osobiste doświadczenie, nie zalecenie terapeutyczne. Decyzje o leczeniu należą do rozmowy z lekarzem prowadzącym.</em></p>
HTML,
        ],
        'hu' => [
            'title' => 'Az orvosok a legfigyelmesebb betegek',
            'image_alt' => 'Egy orvos betegként ül a vizsgálóágyon: egyik kezében GLP-1-pen, a másikban kortikoszteroid.',
            'excerpt' => 'Amit három GLP-1-molekula közötti váltáskor tanultam, miközben Medrolt is szedtem. 16 és 18 mmol/l közötti vércukrok, a food noise visszatérése, és egy orvos tekintete, aki egyben a beteg is.',
            'content' => <<<'HTML'
<p>Múlt héten semaglutidról tirzepatidra (Mounjaro 5&nbsp;mg) váltottam. Az ok egyszerű volt: egyúttal Medrolt szedek, és a kortikoszteroid okozta hiperglikémia brutális. Vércukor 16 és 18&nbsp;mmol/l között. NovoMix inzulinadagok, amelyekre hónapokig nem volt szükségem.</p>
<p>Más lepett meg: a food noise visszatérése.</p>
<p>Az az állandó, tolakodó gondolkodás az ételről, amit a semaglutid csendben kikapcsolt, a váltás után napokon belül visszajött. Nem azért, mert a tirzepatid gyengébb lenne. Az étvágyjelzések és a kortikoszteroid okozta inzulinrezisztencia összjátéka bonyolultabb, mint amit egyetlen receptor megmagyaráz.</p>
<p>A szénhidrátszegény ételek paradox módon rontottak a helyzeten. Fehérje és zsír szénhidrát nélkül mélyítette az éhséget, ahelyett hogy csillapította volna. Egy vizsgálatban az ember ezt olvassa. A saját testén másképp érzi.</p>
<p>Ugyanebben az időszakban a retatrutidot röviden magamon is kipróbáltam. A molekula más volt, a receptorprofil is, és más volt az élmény is. Ezekről a gyógyszerekről az adatok gyorsabban gyűlnek, mint ahogy a klinikai irányelvek követni tudják.</p>
<p>Nem tartom számon, melyik molekula „nyert”. Orvosként minden változót le tudtam írni. Betegként mindegyiket éreztem. Ezt a kettős nézőpontot több kollégának kívánnám a saját bőrén.</p>
<p>Ha inkretinkezelésben, különösen szteroiddal együtt, gondoz betegeket: mi tért vissza önnél?</p>
<p><em>Személyes tapasztalat, nem kezelési javaslat. A terápiás döntés a kezelőorvossal folytatott beszélgetéshez tartozik.</em></p>
HTML,
        ],
        'it' => [
            'title' => 'I medici sono i pazienti più attenti',
            'image_alt' => 'Un medico siede sul lettino come paziente: in una mano una penna GLP-1, nell\'altra i corticosteroidi.',
            'excerpt' => 'Cosa ho imparato passando tra tre molecole GLP-1 mentre assumevo anche Medrol. Glicemie da 16 a 18 mmol/L, il ritorno del food noise e lo sguardo di un medico che è anche il paziente.',
            'content' => <<<'HTML'
<p>La settimana scorsa sono passato da semaglutide a tirzepatide (Mounjaro 5&nbsp;mg). Il motivo era semplice: assumo anche Medrol e l'iperglicemia indotta dai corticosteroidi è brutale. Glicemie da 16 a 18&nbsp;mmol/L. Dosi di insulina NovoMix di cui non avevo bisogno da mesi.</p>
<p>Ciò che mi ha sorpreso è stato il ritorno del food noise.</p>
<p>Quel pensiero costante e invadente sul cibo, che il semaglutide aveva spento in silenzio, è tornato nel giro di giorni dal cambio. Non perché il tirzepatide sia più debole. L'interazione tra i segnali dell'appetito e la resistenza insulinica da corticosteroidi è più complessa di quanto spieghi un singolo recettore.</p>
<p>I pasti a basso contenuto di carboidrati, paradossalmente, l'hanno peggiorata. Proteine e grassi senza carboidrati hanno approfondito la fame invece di calmarla. In uno studio lo si legge. Sul proprio corpo lo si sente diversamente.</p>
<p>Nello stesso periodo ho provato brevemente anche il retatrutide, su di me. La molecola era diversa, anche il profilo recettoriale, e diversa era anche l'esperienza. I dati su questi farmaci si accumulano più in fretta di quanto le linee guida cliniche riescano a seguirli.</p>
<p>Non tengo il conto di quale molecola «abbia vinto». Come medico ho potuto annotare ogni variabile. Come paziente le ho sentite tutte. Questa doppia prospettiva la augurerei a più colleghi sulla propria pelle.</p>
<p>Se seguite pazienti in terapia incretinica, soprattutto in parallelo agli steroidi, che cosa vi si è ripetuto?</p>
<p><em>È un'esperienza personale, non un consiglio terapeutico. Le decisioni di trattamento appartengono al colloquio con il medico curante.</em></p>
HTML,
        ],
        'uk' => [
            'title' => 'Лікарі є найуважнішими пацієнтами',
            'image_alt' => 'Лікар сидить на кушетці як пацієнт: у одній руці шприц-ручка GLP-1, у іншій кортикостероїди.',
            'excerpt' => 'Чого я навчився, змінюючи три молекули GLP-1, коли водночас приймав Медрол. Глікемії від 16 до 18 ммоль/л, повернення food noise і погляд лікаря, який є також пацієнтом.',
            'content' => <<<'HTML'
<p>Минулого тижня я перейшов із семаглутиду на тирзепатид (Mounjaro 5&nbsp;мг). Причина була проста: я також приймаю Медрол, а гіперглікемія від кортикостероїдів жорстока. Глікемії від 16 до 18&nbsp;ммоль/л. Дози інсуліну NovoMix, яких я місяцями не потребував.</p>
<p>Здивувало мене інше: повернення food noise.</p>
<p>Це постійне, нав’язливе думання про їжу, яке семаглутид тихо вимкнув, повернулося за кілька днів після зміни. Не тому, що тирзепатид слабший. Взаємодія між сигналами апетиту й інсулінорезистентністю від кортикостероїдів складніша, ніж пояснює один рецептор.</p>
<p>Низьковуглеводні страви парадоксально погіршили ситуацію. Білок і жир без вуглеводів поглибили голод замість того, щоб його вгамувати. У дослідженні це читаєш. На власному тілі відчуваєш інакше.</p>
<p>У той самий період я коротко спробував і ретатрутид, на собі. Молекула була інша, рецепторний профіль теж, і досвід теж був інший. Дані про ці ліки накопичуються швидше, ніж за ними встигають клінічні настанови.</p>
<p>Я не веду лік, яка молекула «перемогла». Як лікар я міг записати кожну змінну. Як пацієнт я кожну з них відчував. Такий подвійний погляд я бажав би більше колегам на власній шкірі.</p>
<p>Якщо ви працюєте з пацієнтами на інкретиновій терапії, особливо разом зі стероїдами, що у вас при цьому повторювалося?</p>
<p><em>Це особистий досвід, а не лікувальне призначення. Рішення про лікування належать розмові з лікарем, який веде пацієнта.</em></p>
HTML,
        ],
    ],
];
