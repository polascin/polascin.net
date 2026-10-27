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
 * Lacnejší token, drahší účet.
 * Cenník GPT-4: OpenAI, GPT-4 research (30 a 60 USD za milión tokenov, okno 8 000).
 * Štvornásobok mesačných výdavkov: vlastné údaje Ramp, jar 2026.
 * Business Insider ich prevzal a omylom pripísal Gartneru.
 * Dlhopisy CoreWeave: Morningstar, obchody 14. a 15. októbra 2026.
 * Päťdesiat- až päťstonásobok je odhad nákladu ťažkého behu, nie nameraný pomer tokenov.
 */
return [
    'slug' => 'lacnejsi-token-drazsi-ucet',
    'author' => 'MUDr. Ľubomír Polaščín',
    'category' => 'blog',
    'is_top' => 0,
    'published_at' => '2026-10-27 23:00:00',
    'image' => 'images/articles/lacnejsi-token-drazsi-ucet.webp',
    'translations' => [
        'sk' => [
            'title' => 'Lacnejší token, drahší účet',
            'image_alt' => 'Malý tyrkysový sklenený kotúč leží na tmavom stole. Za ním stúpa vlna fialových kariet a v tme svieti rad tyrkysových svetiel.',
            'excerpt' => 'GPT-4 stál v roku 2023 30 dolárov za milión tokenov na vstupe a 60 na výstupe. Jednotková cena padla, mesačné výdavky firiem na AI sa podľa údajov Ramp za predchádzajúci rok zoštvrnásobili. Dlhopisy CoreWeave ukazujú, že kapacita nie je zadarmo.',
            'content' => <<<'HTML'
<p>V marci 2023 účtovala OpenAI za model GPT-4 s oknom 8 000 tokenov 30 dolárov za milión tokenov na vstupe a 60 dolárov za milión na výstupe. Cenník je na <a href="https://openai.com/index/gpt-4-research">jej stránke k modelu</a>.</p>
<p>Lacný koniec trhu je dnes inde. Pri úsporných modeloch sa milión tokenov dostal do pásma od 0,15 do 1 dolára. Špičkové modely ostávajú drahšie a cenník sa líši podľa poskytovateľa. Jednotková cena teda padla. Účet firmy často nie.</p>
<p>Na tú istú otázku minie výkonný model oveľa viac tokenov než krátke okno z roku 2023. Pri najťažších behoch, keď model sám volá nástroje a kroky sa vrstvia, odhady hovoria o päťdesiat- až päťstonásobku nákladu oproti jednoduchému volaniu. Firma nekupuje ten istý balík lacnejšie. Kupuje väčší balík s nižšou cenou za kus. Preto nastala fáza maximalizácie tokenov: míňa sa ich viac práve preto, že sú lacné.</p>
<p>Mesačné výdavky firiem na AI sa podľa vlastných údajov spoločnosti Ramp za predchádzajúci rok zoštvrnásobili. Na jar 2026 to Ramp napísala sama a <a href="https://www.businessinsider.com/tokenmaxxing-ai-token-leaderboards-debate-2026-4">Business Insider</a> to prevzal. Štvornásobok platí pre firmy v jej údajoch, nie pre odhad celého trhu.</p>
<p>William Stanley Jevons to v roku 1865 videl na uhlie. Účinnejší parný stroj spotrebu neznížil. Zlacnil prácu, otvoril nové použitia a Anglicko spálilo viac uhlia. Pri tokenoch pribudlo ešte čosi. Kvalita, ktorá kedysi držala používateľa pri jednom drahom modeli, povolila. Prejsť k inému poskytovateľovi je jednoduchšie. Na jednoduchú úlohu netreba najväčší model. Otvorený model stačí a drahý ostáva na to, čo ho naozaj potrebuje.</p>
<p>Víťazov bude málo a neostanú tí istí. Udrží sa ten, kto si vezme zmysluplný podiel a pritom nespáli maržu. Výstavba a prevádzka dátových centier sú drahé a dlh nie je lacný. V polovici októbra 2026 sa nezabezpečené dlhopisy CoreWeave, firmy z vrstvy nazývanej neocloud, predávali hlboko pod nominálom. <a href="https://www.morningstar.com/bonds/coreweave-data-center-bonds-slide-capex-debt-overhang-concerns">Morningstar</a> zaznamenal 14. októbra pri emisii splatnej v roku 2031 obchody pri 78 percentách nominálu a výnos 16,39 percenta. Emisia splatná v roku 2032 klesla na 75, s výnosom 16,5 percenta. O deň neskôr sa ceny čiastočne vrátili, na 83 a 80. Trh tak ocenil pochybnosť, či firma unesie budúce záväzky. Ceny sa hýbu. Pochybnosť ostala.</p>
<p>Lacný token nie je lacná inteligencia. Je to lacnejší dôvod minúť jej viac.</p>

HTML,
        ],
        'en' => [
            'title' => 'A cheaper token, a higher bill',
            'image_alt' => 'A small teal glass disc rests on a dark table. Behind it a wave of purple cards rises, and a row of teal lights glows in the dark.',
            'excerpt' => 'In 2023 GPT-4 cost 30 dollars per million tokens in and 60 out. The unit price fell, while monthly corporate AI spending quadrupled over the previous year, according to Ramp’s own data. CoreWeave’s bonds show that capacity is not free.',
            'content' => <<<'HTML'
<p>In March 2023 OpenAI charged 30 dollars per million input tokens and 60 dollars per million output tokens for GPT-4 with an 8,000-token window. The price is on <a href="https://openai.com/index/gpt-4-research">its page for the model</a>.</p>
<p>The cheap end of the market is elsewhere now. For economical models a million tokens has moved into a band from 0.15 to 1 dollar. Frontier models stay dearer, and the price list differs by provider. The unit price has therefore fallen. The company’s bill often has not.</p>
<p>On the same question a powerful model spends far more tokens than the short window of 2023. For the heaviest runs, when the model calls tools itself and the steps pile up, estimates put the cost at fifty to five hundred times a simple call. The company is not buying the same bundle more cheaply. It is buying a larger bundle at a lower price per piece. That is why a phase of maximizing tokens has set in: more get spent precisely because they are cheap.</p>
<p>Monthly corporate spending on AI quadrupled over the previous year, according to Ramp’s own data. Ramp said so itself in spring 2026, and <a href="https://www.businessinsider.com/tokenmaxxing-ai-token-leaderboards-debate-2026-4">Business Insider</a> reported it. The fourfold rise is what Ramp sees in its data, not an estimate of the whole market.</p>
<p>William Stanley Jevons saw this in coal in 1865. A more efficient steam engine did not cut consumption. It made work cheaper, opened new uses, and England burned more coal. With tokens something further has happened. The quality that once kept a user on one expensive model has loosened. Moving to another provider is easier. A simple task does not need the largest model. An open model is enough, and the expensive one stays for what actually needs it.</p>
<p>There will be few winners, and they will not stay the same. The one who lasts takes a meaningful share without burning the margin. Building and running data centers is expensive, and debt is not cheap. In mid-October 2026 the unsecured bonds of CoreWeave, a firm in the layer called neocloud, traded far below par. <a href="https://www.morningstar.com/bonds/coreweave-data-center-bonds-slide-capex-debt-overhang-concerns">Morningstar</a> recorded trades on 14 October in the notes due in 2031 at 78 percent of par, with a yield of 16.39 percent. The notes due in 2032 fell to 75, with a yield of 16.5 percent. A day later the prices partly returned, to 83 and 80. The market was pricing the doubt that the company can meet its future obligations. Prices move. The doubt remained.</p>
<p>A cheap token is not cheap intelligence. It is a cheaper reason to spend more of it.</p>

HTML,
        ],
        'cs' => [
            'title' => 'Levnější token, dražší účet',
            'image_alt' => 'Malý tyrkysový skleněný kotouč leží na tmavém stole. Za ním stoupá vlna fialových karet a ve tmě svítí řada tyrkysových světel.',
            'excerpt' => 'GPT-4 stál v roce 2023 30 dolarů za milion tokenů na vstupu a 60 na výstupu. Jednotková cena klesla, měsíční výdaje firem na AI se podle údajů Ramp za předchozí rok zčtyřnásobily. Dluhopisy CoreWeave ukazují, že kapacita není zadarmo.',
            'content' => <<<'HTML'
<p>V březnu 2023 účtovala OpenAI za model GPT-4 s oknem 8 000 tokenů 30 dolarů za milion tokenů na vstupu a 60 dolarů za milion na výstupu. Ceník je na <a href="https://openai.com/index/gpt-4-research">její stránce k modelu</a>.</p>
<p>Levný konec trhu je dnes jinde. U úsporných modelů se milion tokenů dostal do pásma od 0,15 do 1 dolaru. Špičkové modely zůstávají dražší a ceník se liší podle poskytovatele. Jednotková cena tedy klesla. Účet firmy často ne.</p>
<p>Na tutéž otázku spotřebuje výkonný model mnohem více tokenů než krátké okno z roku 2023. U nejtěžších běhů, kdy model sám volá nástroje a kroky se vrství, hovoří odhady o padesáti- až pětisetnásobku nákladu oproti jednoduchému volání. Firma nekupuje týž balík levněji. Kupuje větší balík s nižší cenou za kus. Odtud je fáze maximalizace tokenů: utratí se jich víc právě proto, že jsou levné.</p>
<p>Měsíční výdaje firem na AI se podle vlastních údajů společnosti Ramp za předchozí rok zčtyřnásobily. Na jaře 2026 to Ramp napsala sama a <a href="https://www.businessinsider.com/tokenmaxxing-ai-token-leaderboards-debate-2026-4">Business Insider</a> to převzal. Čtyřnásobek platí pro firmy v jejích údajích, ne pro odhad celého trhu.</p>
<p>William Stanley Jevons to v roce 1865 viděl na uhlí. Účinnější parní stroj spotřebu nesnížil. Zlevnil práci, otevřel nová použití a Anglie spálila více uhlí. U tokenů přibylo ještě něco. Kvalita, která kdysi držela uživatele u jednoho drahého modelu, povolila. Přejít k jinému poskytovateli je jednodušší. Na jednoduchý úkol není potřeba největší model. Otevřený model stačí a drahý zůstává na to, co ho skutečně potřebuje.</p>
<p>Vítězů bude málo a nezůstanou titíž. Udrží se ten, kdo si vezme smysluplný podíl a přitom nespálí marži. Výstavba a provoz datových center jsou drahé a dluh není levný. V polovině října 2026 se nezajištěné dluhopisy CoreWeave, firmy z vrstvy nazývané neocloud, prodávaly hluboko pod nominálem. <a href="https://www.morningstar.com/bonds/coreweave-data-center-bonds-slide-capex-debt-overhang-concerns">Morningstar</a> zaznamenal 14. října u emise splatné v roce 2031 obchody při 78 procentech nominálu a výnos 16,39 procenta. Emise splatná v roce 2032 klesla na 75, s výnosem 16,5 procenta. O den později se ceny částečně vrátily, na 83 a 80. Trh tak ocenil pochybnost, zda firma unese budoucí závazky. Ceny se hýbou. Pochybnost zůstala.</p>
<p>Levný token není levná inteligence. Je to levnější důvod utratit jí víc.</p>

HTML,
        ],
        'de' => [
            'title' => 'Günstigeres Token, höhere Rechnung',
            'image_alt' => 'Eine kleine türkisfarbene Glasscheibe liegt auf einem dunklen Tisch. Dahinter steigt eine Welle violetter Karten, im Dunkel leuchtet eine Reihe türkiser Lichter.',
            'excerpt' => 'GPT-4 kostete 2023 30 Dollar je Million Token auf der Eingabe und 60 auf der Ausgabe. Der Stückpreis fiel, die monatlichen KI-Ausgaben vervierfachten sich nach Ramps Daten. Die Anleihen von CoreWeave zeigen, dass Kapazität nicht umsonst ist.',
            'content' => <<<'HTML'
<p>Im März 2023 berechnete OpenAI für GPT-4 mit einem Fenster von 8 000 Token 30 Dollar je Million Token auf der Eingabe und 60 Dollar je Million auf der Ausgabe. Der Preis steht auf <a href="https://openai.com/index/gpt-4-research">ihrer Seite zum Modell</a>.</p>
<p>Das günstige Ende des Marktes liegt heute woanders. Bei sparsamen Modellen ist eine Million Token in eine Spanne von 0,15 bis 1 Dollar gerückt. Spitzenmodelle bleiben teurer, und die Preisliste hängt vom Anbieter ab. Der Stückpreis ist also gefallen. Die Rechnung des Unternehmens oft nicht.</p>
<p>Für dieselbe Frage verbraucht ein leistungsfähiges Modell weit mehr Token als das kurze Fenster von 2023. Bei den schwersten Läufen, wenn das Modell selbst Werkzeuge aufruft und die Schritte sich schichten, sprechen Schätzungen vom Fünfzig- bis Fünfhundertfachen der Kosten eines einfachen Aufrufs. Das Unternehmen kauft nicht dasselbe Paket billiger. Es kauft ein größeres Paket zu einem niedrigeren Stückpreis. Daher die Phase der Token-Maximierung: Es werden mehr davon ausgegeben, gerade weil sie billig sind.</p>
<p>Die monatlichen KI-Ausgaben von Unternehmen haben sich nach Ramps eigenen Daten im vorangegangenen Jahr vervierfacht. Im Frühjahr 2026 hat Ramp das selbst geschrieben, und <a href="https://www.businessinsider.com/tokenmaxxing-ai-token-leaderboards-debate-2026-4">Business Insider</a> hat es übernommen. Die Vervierfachung gilt für die Unternehmen in den Daten von Ramp, nicht als Schätzung des ganzen Marktes.</p>
<p>William Stanley Jevons sah das 1865 an der Kohle. Die wirksamere Dampfmaschine senkte den Verbrauch nicht. Sie verbilligte die Arbeit, öffnete neue Verwendungen, und England verbrannte mehr Kohle. Bei den Token kam noch etwas hinzu. Die Qualität, die den Nutzer einst an ein einziges teures Modell band, hat nachgegeben. Der Wechsel zu einem anderen Anbieter ist einfacher. Für eine einfache Aufgabe braucht es nicht das größte Modell. Ein offenes Modell genügt, und das teure bleibt für das, was es wirklich braucht.</p>
<p>Sieger wird es wenige geben, und es bleiben nicht dieselben. Es bleibt, wer einen sinnvollen Anteil nimmt und dabei die Marge nicht verbrennt. Bau und Betrieb von Rechenzentren sind teuer, und Schulden sind es auch. Mitte Oktober 2026 wurden die ungesicherten Anleihen von CoreWeave, einer Firma aus der Schicht, die man Neocloud nennt, tief unter pari gehandelt. <a href="https://www.morningstar.com/bonds/coreweave-data-center-bonds-slide-capex-debt-overhang-concerns">Morningstar</a> verzeichnete am 14. Oktober bei der 2031 fälligen Anleihe Geschäfte zu 78 Prozent des Nennwerts und eine Rendite von 16,39 Prozent. Die 2032 fällige Anleihe fiel auf 75, bei einer Rendite von 16,5 Prozent. Einen Tag später kehrten die Preise teilweise zurück, auf 83 und 80. Der Markt setzte damit den Preis für den Zweifel, ob die Firma künftige Verpflichtungen tragen kann. Die Preise bewegen sich. Der Zweifel blieb.</p>
<p>Ein billiges Token ist keine billige Intelligenz. Es ist ein billigerer Grund, mehr davon zu verbrauchen.</p>

HTML,
        ],
        'fr' => [
            'title' => 'Un jeton moins cher, une facture plus lourde',
            'image_alt' => 'Un petit disque de verre turquoise repose sur une table sombre. Derrière lui monte une vague de cartes violettes, et une rangée de lumières turquoise brille dans le noir.',
            'excerpt' => 'En 2023, GPT-4 coûtait 30 dollars le million de jetons en entrée et 60 en sortie. Le prix unitaire a chuté et les dépenses mensuelles en IA ont quadruplé, selon Ramp. Les obligations de CoreWeave montrent que la capacité n’est pas gratuite.',
            'content' => <<<'HTML'
<p>En mars 2023, OpenAI facturait le GPT-4 à fenêtre de 8 000 jetons 30 dollars le million de jetons en entrée et 60 dollars le million en sortie. Le tarif est sur <a href="https://openai.com/index/gpt-4-research">sa page consacrée au modèle</a>.</p>
<p>Le bas du marché est ailleurs aujourd’hui. Pour les modèles économes, le million de jetons est passé dans une fourchette de 0,15 à 1 dollar. Les modèles de pointe restent plus chers, et le tarif change selon le fournisseur. Le prix unitaire a donc chuté. La facture de l’entreprise, souvent, non.</p>
<p>Pour la même question, un modèle puissant consomme bien plus de jetons que la courte fenêtre de 2023. Pour les exécutions les plus lourdes, quand le modèle appelle lui-même des outils et que les étapes s’empilent, les estimations vont de cinquante à cinq cents fois le coût d’un appel simple. L’entreprise n’achète pas le même paquet moins cher. Elle achète un paquet plus gros, à un prix unitaire plus bas. D’où la phase de maximisation des jetons : on en dépense davantage précisément parce qu’ils sont bon marché.</p>
<p>Les dépenses mensuelles des entreprises en IA ont quadruplé sur l’année précédente, selon les données propres de Ramp. Au printemps 2026, Ramp l’a écrit elle-même, et <a href="https://www.businessinsider.com/tokenmaxxing-ai-token-leaderboards-debate-2026-4">Business Insider</a> l’a repris. Le quadruplement vaut pour les entreprises dans les données de Ramp, pas pour une estimation du marché entier.</p>
<p>William Stanley Jevons l’a vu en 1865 sur le charbon. Une machine à vapeur plus efficace n’a pas réduit la consommation. Elle a rendu le travail moins cher, ouvert de nouveaux usages, et l’Angleterre a brûlé plus de charbon. Avec les jetons, quelque chose de plus s’est ajouté. La qualité qui retenait autrefois l’utilisateur sur un seul modèle cher s’est relâchée. Passer à un autre fournisseur est plus simple. Une tâche simple n’a pas besoin du plus grand modèle. Un modèle ouvert suffit, et le modèle cher reste pour ce qui en a vraiment besoin.</p>
<p>Les gagnants seront peu nombreux, et ils ne resteront pas les mêmes. Celui qui dure prend une part sensée du marché sans brûler sa marge. Construire et exploiter des centres de données coûte cher, et la dette aussi. À la mi-octobre 2026, les obligations non garanties de CoreWeave, une entreprise de la couche dite neocloud, se négociaient très au-dessous du pair. <a href="https://www.morningstar.com/bonds/coreweave-data-center-bonds-slide-capex-debt-overhang-concerns">Morningstar</a> a relevé le 14 octobre, pour l’émission arrivant à échéance en 2031, des transactions à 78 pour cent du nominal et un rendement de 16,39 pour cent. L’émission de 2032 est tombée à 75, pour un rendement de 16,5 pour cent. Le lendemain, les prix sont en partie revenus, à 83 et à 80. Le marché y mettait le prix du doute : l’entreprise peut-elle honorer ses engagements à venir. Les prix bougent. Le doute est resté.</p>
<p>Un jeton bon marché n’est pas une intelligence bon marché. C’est une raison moins chère d’en dépenser davantage.</p>

HTML,
        ],
        'es' => [
            'title' => 'Un token más barato, una factura más alta',
            'image_alt' => 'Un pequeño disco de vidrio turquesa descansa sobre una mesa oscura. Detrás sube una ola de tarjetas moradas y, en la oscuridad, brilla una fila de luces turquesa.',
            'excerpt' => 'En 2023 GPT-4 costaba 30 dólares por millón de tokens de entrada y 60 de salida. El precio unitario cayó y el gasto mensual en IA se cuadruplicó, según Ramp. Los bonos de CoreWeave muestran que la capacidad no es gratis.',
            'content' => <<<'HTML'
<p>En marzo de 2023 OpenAI cobraba por GPT-4, con una ventana de 8 000 tokens, 30 dólares por millón de tokens de entrada y 60 dólares por millón de salida. El precio está en <a href="https://openai.com/index/gpt-4-research">su página del modelo</a>.</p>
<p>El extremo barato del mercado está hoy en otra parte. En los modelos austeros, el millón de tokens ha pasado a una banda de 0,15 a 1 dólar. Los modelos de punta siguen siendo más caros, y la tarifa cambia según el proveedor. El precio unitario, por tanto, cayó. La factura de la empresa, a menudo, no.</p>
<p>Para la misma pregunta, un modelo potente gasta muchos más tokens que la ventana corta de 2023. En las ejecuciones más pesadas, cuando el modelo llama él mismo a las herramientas y los pasos se apilan, las estimaciones hablan de cincuenta a quinientas veces el coste de una llamada simple. La empresa no compra el mismo paquete más barato. Compra un paquete mayor, con un precio más bajo por pieza. De ahí la fase de maximización de tokens: se gastan más precisamente porque son baratos.</p>
<p>El gasto mensual de las empresas en IA se cuadruplicó el año anterior, según los datos propios de Ramp. En la primavera de 2026 lo escribió la propia Ramp, y lo recogió <a href="https://www.businessinsider.com/tokenmaxxing-ai-token-leaderboards-debate-2026-4">Business Insider</a>. El cuádruple vale para las empresas en los datos de Ramp, no para una estimación de todo el mercado.</p>
<p>William Stanley Jevons lo vio en 1865 en el carbón. Una máquina de vapor más eficiente no redujo el consumo. Abarató el trabajo, abrió usos nuevos, y Inglaterra quemó más carbón. Con los tokens se añadió algo más. La calidad que antes retenía al usuario en un solo modelo caro se ha aflojado. Pasar a otro proveedor es más fácil. Una tarea simple no necesita el modelo más grande. Basta un modelo abierto, y el caro se reserva para lo que de verdad lo necesita.</p>
<p>Los ganadores serán pocos y no seguirán siendo los mismos. Se mantiene quien toma una parte con sentido y no quema el margen. Construir y operar centros de datos es caro, y la deuda también. A mediados de octubre de 2026, los bonos no garantizados de CoreWeave, una empresa de la capa llamada neocloud, se negociaban muy por debajo de la par. <a href="https://www.morningstar.com/bonds/coreweave-data-center-bonds-slide-capex-debt-overhang-concerns">Morningstar</a> registró el 14 de octubre, en la emisión con vencimiento en 2031, operaciones al 78 por ciento del nominal y un rendimiento del 16,39 por ciento. La emisión con vencimiento en 2032 bajó a 75, con un rendimiento del 16,5 por ciento. Un día después los precios volvieron en parte, a 83 y a 80. El mercado puso así precio a la duda de si la empresa puede asumir sus obligaciones futuras. Los precios se mueven. La duda permaneció.</p>
<p>Un token barato no es inteligencia barata. Es una razón más barata para gastar más de ella.</p>

HTML,
        ],
        'pl' => [
            'title' => 'Tańszy token, droższy rachunek',
            'image_alt' => 'Mały turkusowy szklany krążek leży na ciemnym stole. Za nim wznosi się fala fioletowych kart, a w ciemności świeci rząd turkusowych świateł.',
            'excerpt' => 'W 2023 roku GPT-4 kosztował 30 dolarów za milion tokenów na wejściu i 60 na wyjściu. Cena jednostkowa spadła, a miesięczne wydatki na AI wzrosły według Ramp czterokrotnie. Obligacje CoreWeave pokazują, że moc nie jest za darmo.',
            'content' => <<<'HTML'
<p>W marcu 2023 roku OpenAI pobierała za model GPT-4 z oknem 8 000 tokenów 30 dolarów za milion tokenów na wejściu i 60 dolarów za milion na wyjściu. Cennik jest na <a href="https://openai.com/index/gpt-4-research">jej stronie modelu</a>.</p>
<p>Tani kraniec rynku jest dziś gdzie indziej. Przy oszczędnych modelach milion tokenów wszedł w pasmo od 0,15 do 1 dolara. Modele czołowe pozostają droższe, a cennik różni się zależnie od dostawcy. Cena jednostkowa więc spadła. Rachunek firmy często nie.</p>
<p>Na to samo pytanie wydajny model zużywa znacznie więcej tokenów niż krótkie okno z 2023 roku. Przy najcięższych biegach, gdy model sam wywołuje narzędzia i kroki się nawarstwiają, szacunki mówią o pięćdziesięcio- do pięćsetkrotności kosztu wobec prostego wywołania. Firma nie kupuje tej samej paczki taniej. Kupuje większą paczkę z niższą ceną za sztukę. Stąd faza maksymalizacji tokenów: zużywa się ich więcej właśnie dlatego, że są tanie.</p>
<p>Miesięczne wydatki firm na AI wzrosły według własnych danych spółki Ramp w poprzednim roku czterokrotnie. Wiosną 2026 roku Ramp napisała to sama, a <a href="https://www.businessinsider.com/tokenmaxxing-ai-token-leaderboards-debate-2026-4">Business Insider</a> to podał. Czterokrotność dotyczy firm w danych Ramp, a nie szacunku całego rynku.</p>
<p>William Stanley Jevons zobaczył to w 1865 roku na węglu. Sprawniejsza maszyna parowa nie obniżyła zużycia. Obniżyła koszt pracy, otworzyła nowe zastosowania, a Anglia spaliła więcej węgla. Przy tokenach pojawiło się coś jeszcze. Jakość, która kiedyś trzymała użytkownika przy jednym drogim modelu, zelżała. Przejście do innego dostawcy jest prostsze. Do prostego zadania nie potrzeba największego modelu. Wystarczy model otwarty, a drogi zostaje do tego, co go naprawdę potrzebuje.</p>
<p>Zwycięzców będzie niewielu i nie pozostaną ci sami. Utrzyma się ten, kto weźmie sensowny udział i przy tym nie spali marży. Budowa i utrzymanie centrów danych są drogie, a dług też nie jest tani. W połowie października 2026 roku niezabezpieczone obligacje CoreWeave, firmy z warstwy nazywanej neocloud, sprzedawały się głęboko poniżej nominału. <a href="https://www.morningstar.com/bonds/coreweave-data-center-bonds-slide-capex-debt-overhang-concerns">Morningstar</a> odnotował 14 października przy emisji zapadającej w 2031 roku transakcje przy 78 procentach nominału i rentowność 16,39 procent. Emisja zapadająca w 2032 roku spadła do 75, z rentownością 16,5 procent. Dzień później ceny częściowo wróciły, do 83 i 80. Rynek wycenił w ten sposób wątpliwość, czy firma udźwignie przyszłe zobowiązania. Ceny się poruszają. Wątpliwość została.</p>
<p>Tani token nie jest tanią inteligencją. Jest tańszym powodem, by zużyć jej więcej.</p>

HTML,
        ],
        'hu' => [
            'title' => 'Olcsóbb token, drágább számla',
            'image_alt' => 'Egy kis türkiz üvegkorong fekszik a sötét asztalon. Mögötte lila kártyák hulláma emelkedik, a sötétben türkiz fények sora világít.',
            'excerpt' => 'A GPT-4 2023-ban egymillió bemeneti tokenért 30, kimenetiért 60 dollárba került. Az egységár esett, a cégek havi AI-kiadása a Ramp saját adatai szerint az előző évben a négyszeresére nőtt. A CoreWeave kötvényei mutatják, hogy a kapacitás nem ingyen van.',
            'content' => <<<'HTML'
<p>2023 márciusában az OpenAI a 8 000 tokenes ablakú GPT-4-ért egymillió bemeneti token után 30 dollárt, egymillió kimeneti token után 60 dollárt számolt fel. Az ár a <a href="https://openai.com/index/gpt-4-research">modell oldalán</a> olvasható.</p>
<p>A piac olcsó vége ma máshol van. A takarékos modelleknél egymillió token a 0,15 és 1 dollár közötti sávba került. A csúcskategóriás modellek drágábbak maradnak, és az árjegyzék szolgáltatónként változik. Az egységár tehát esett. A cég számlája gyakran nem.</p>
<p>Ugyanarra a kérdésre egy nagy teljesítményű modell sokkal több tokent használ, mint a 2023-as rövid ablak. A legnehezebb futásoknál, amikor a modell maga hívja az eszközöket és a lépések egymásra rakódnak, a becslések az egyszerű híváshoz képest ötvenszerestől ötszázszorosig terjedő költségről szólnak. A cég nem ugyanazt a csomagot veszi olcsóbban. Nagyobb csomagot vesz, alacsonyabb darabáron. Innen a tokenek maximalizálásának szakasza: éppen azért költenek belőlük többet, mert olcsók.</p>
<p>A cégek havi AI-kiadása a Ramp saját adatai szerint az előző évben a négyszeresére nőtt. 2026 tavaszán ezt maga a Ramp írta meg, és a <a href="https://www.businessinsider.com/tokenmaxxing-ai-token-leaderboards-debate-2026-4">Business Insider</a> vette át. A négyszeres a Ramp adataiban szereplő cégekre vonatkozik, nem az egész piac becslésére.</p>
<p>William Stanley Jevons 1865-ben a szénen látta ugyanezt. A hatékonyabb gőzgép nem csökkentette a fogyasztást. Olcsóbbá tette a munkát, új felhasználást nyitott, és Anglia több szenet égetett el. A tokeneknél még valami hozzáadódott. A minőség, amely egykor egyetlen drága modellnél tartotta a felhasználót, meglazult. Más szolgáltatóhoz átlépni egyszerűbb. Egyszerű feladathoz nem kell a legnagyobb modell. Egy nyílt modell elég, a drága arra marad, ami valóban igényli.</p>
<p>Győztesből kevés lesz, és nem maradnak ugyanazok. Az marad, aki értelmes piaci részt vesz ki, és közben nem égeti el a haszonkulcsot. Az adatközpontok építése és üzemeltetése drága, és az adósság sem olcsó. 2026 októberének közepén a neocloud rétegbe tartozó CoreWeave fedezetlen kötvényei mélyen a névérték alatt forogtak. A <a href="https://www.morningstar.com/bonds/coreweave-data-center-bonds-slide-capex-debt-overhang-concerns">Morningstar</a> október 14-én a 2031-ben lejáró kibocsátásnál a névérték 78 százalékán kötött üzleteket és 16,39 százalékos hozamot jegyzett. A 2032-ben lejáró kibocsátás 75-re esett, 16,5 százalékos hozammal. Egy nappal később az árak részben visszatértek, 83-ra és 80-ra. A piac így árazta a kételyt, hogy a cég elbírja-e jövőbeli kötelezettségeit. Az árak mozognak. A kétely megmaradt.</p>
<p>Az olcsó token nem olcsó intelligencia. Olcsóbb ok arra, hogy többet költsünk belőle.</p>

HTML,
        ],
        'it' => [
            'title' => 'Un token più economico, un conto più alto',
            'image_alt' => 'Un piccolo disco di vetro turchese poggia su un tavolo scuro. Dietro sale un’onda di carte viola e, nel buio, brilla una fila di luci turchesi.',
            'excerpt' => 'Nel 2023 GPT-4 costava 30 dollari per milione di token in ingresso e 60 in uscita. Il prezzo unitario è sceso e la spesa mensile in IA è quadruplicata, secondo Ramp. Le obbligazioni di CoreWeave mostrano che la capacità non è gratis.',
            'content' => <<<'HTML'
<p>Nel marzo 2023 OpenAI addebitava per GPT-4, con una finestra di 8 000 token, 30 dollari per milione di token in ingresso e 60 dollari per milione in uscita. Il prezzo è sulla <a href="https://openai.com/index/gpt-4-research">sua pagina del modello</a>.</p>
<p>Oggi la parte conveniente del mercato è altrove. Nei modelli parsimoniosi un milione di token è entrato in una fascia da 0,15 a 1 dollaro. I modelli di punta restano più cari, e il listino cambia secondo il fornitore. Il prezzo unitario è quindi sceso. Il conto dell’impresa spesso no.</p>
<p>Per la stessa domanda un modello potente consuma molti più token della finestra breve del 2023. Nelle esecuzioni più pesanti, quando il modello chiama da sé gli strumenti e i passi si accumulano, le stime parlano di cinquanta fino a cinquecento volte il costo di una chiamata semplice. L’impresa non compra lo stesso pacchetto a un prezzo minore. Compra un pacchetto più grande, a un prezzo più basso al pezzo. Di qui la fase di massimizzazione dei token: se ne spende di più proprio perché sono economici.</p>
<p>La spesa mensile delle imprese in IA è quadruplicata nell’anno precedente, secondo i dati propri di Ramp. Nella primavera 2026 lo ha scritto la stessa Ramp, e lo ha riferito <a href="https://www.businessinsider.com/tokenmaxxing-ai-token-leaderboards-debate-2026-4">Business Insider</a>. Il quadruplo vale per le imprese nei dati di Ramp, non per una stima dell’intero mercato.</p>
<p>William Stanley Jevons lo vide nel 1865 sul carbone. Una macchina a vapore più efficiente non ridusse il consumo. Rese il lavoro più economico, aprì usi nuovi, e l’Inghilterra bruciò più carbone. Con i token si è aggiunto altro. La qualità che un tempo teneva l’utente su un solo modello caro si è allentata. Passare a un altro fornitore è più semplice. Un compito semplice non ha bisogno del modello più grande. Basta un modello aperto, e quello caro resta per ciò che ne ha davvero bisogno.</p>
<p>I vincitori saranno pochi e non resteranno gli stessi. Resta chi prende una quota sensata e non brucia il margine. Costruire e gestire centri dati è costoso, e il debito non è economico. A metà ottobre 2026 le obbligazioni non garantite di CoreWeave, un’impresa dello strato chiamato neocloud, si scambiavano molto sotto la pari. <a href="https://www.morningstar.com/bonds/coreweave-data-center-bonds-slide-capex-debt-overhang-concerns">Morningstar</a> ha registrato il 14 ottobre, per l’emissione in scadenza nel 2031, scambi al 78 per cento del nominale e un rendimento del 16,39 per cento. L’emissione in scadenza nel 2032 è scesa a 75, con un rendimento del 16,5 per cento. Il giorno dopo i prezzi sono in parte tornati, a 83 e a 80. Il mercato ha così prezzato il dubbio che l’impresa possa sostenere gli obblighi futuri. I prezzi si muovono. Il dubbio è rimasto.</p>
<p>Un token economico non è intelligenza economica. È una ragione più economica per consumarne di più.</p>

HTML,
        ],
        'uk' => [
            'title' => 'Дешевший токен, дорожчий рахунок',
            'image_alt' => 'Малий бірюзовий скляний диск лежить на темному столі. За ним підіймається хвиля фіолетових карток, а в темряві світить ряд бірюзових вогнів.',
            'excerpt' => 'У 2023 році GPT-4 коштував 30 доларів за мільйон токенів на вході і 60 на виході. Одинична ціна впала, а місячні витрати фірм на ШІ за даними Ramp за попередній рік зросли вчетверо. Облігації CoreWeave показують, що потужність не безкоштовна.',
            'content' => <<<'HTML'
<p>У березні 2023 року OpenAI брала за модель GPT-4 з вікном 8 000 токенів 30 доларів за мільйон токенів на вході і 60 доларів за мільйон на виході. Ціна є на <a href="https://openai.com/index/gpt-4-research">її сторінці моделі</a>.</p>
<p>Дешевий край ринку сьогодні інде. Для економних моделей мільйон токенів увійшов у смугу від 0,15 до 1 долара. Провідні моделі лишаються дорожчими, і ціна залежить від постачальника. Тож одинична ціна впала. Рахунок фірми часто ні.</p>
<p>На те саме питання потужна модель витрачає значно більше токенів, ніж коротке вікно 2023 року. У найважчих прогонах, коли модель сама викликає інструменти і кроки нашаровуються, оцінки говорять про вартість у п’ятдесят до п’ятисот разів вищу за простий виклик. Фірма не купує той самий пакет дешевше. Вона купує більший пакет з нижчою ціною за штуку. Звідси фаза максимізації токенів: їх витрачають більше саме тому, що вони дешеві.</p>
<p>Місячні витрати фірм на ШІ за власними даними компанії Ramp за попередній рік зросли вчетверо. Навесні 2026 року це написала сама Ramp, і це передав <a href="https://www.businessinsider.com/tokenmaxxing-ai-token-leaderboards-debate-2026-4">Business Insider</a>. Чотириразове зростання стосується фірм у даних Ramp, а не оцінки всього ринку.</p>
<p>Вільям Стенлі Джевонс побачив це 1865 року на вугіллі. Ефективніша парова машина не знизила споживання. Вона здешевила працю, відкрила нові застосування, і Англія спалила більше вугілля. З токенами додалося ще дещо. Якість, яка колись тримала користувача на одній дорогій моделі, послабла. Перейти до іншого постачальника простіше. Для простого завдання не потрібна найбільша модель. Досить відкритої моделі, а дорога лишається для того, що її справді потребує.</p>
<p>Переможців буде мало, і вони не лишаться тими самими. Втримається той, хто візьме змістовну частку і при цьому не спалить маржу. Будівництво й робота центрів обробки даних дорогі, і борг не дешевий. У середині жовтня 2026 року незабезпечені облігації CoreWeave, фірми з шару, який називають neocloud, продавалися глибоко нижче номіналу. <a href="https://www.morningstar.com/bonds/coreweave-data-center-bonds-slide-capex-debt-overhang-concerns">Morningstar</a> зафіксував 14 жовтня за випуском із погашенням у 2031 році угоди на 78 відсотках номіналу і дохідність 16,39 відсотка. Випуск із погашенням у 2032 році впав до 75, з дохідністю 16,5 відсотка. За день ціни частково повернулися, до 83 і 80. Ринок так оцінив сумнів, чи фірма витримає майбутні зобов’язання. Ціни рухаються. Сумнів лишився.</p>
<p>Дешевий токен не є дешевим інтелектом. Це дешевша причина витратити його більше.</p>

HTML,
        ],
    ],
];
