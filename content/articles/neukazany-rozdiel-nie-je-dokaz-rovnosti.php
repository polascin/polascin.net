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
 * Esej o hranici medzi neukázanou superioritou a dôkazom ekvivalencie
 * pri štúdii Prepare for Kidney Care (Lancet 2026; PMID 42982076).
 * Väzba na komentár na nefro.polascin.net z 8. 11. 2026, 16:22 CET.
 * Bez textGrain. Žiadne fiktívne čísla štúdie: verejné údaje.
 */
return [
    'slug' => 'neukazany-rozdiel-nie-je-dokaz-rovnosti',
    'author' => 'MUDr. Ľubomír Polaščín',
    'category' => 'blog',
    'is_top' => 0,
    'published_at' => '2026-11-14 13:20:00',
    'image' => 'images/articles/neukazany-rozdiel-nie-je-dokaz-rovnosti.webp',
    'translations' => [
        'sk' => [
            'title' => 'Neukázaný rozdiel nie je dôkaz rovnosti',
            'image_alt' => 'Fialová plocha s dvoma cestami svetla: jedna k tyrkysovej geometrii dialýzy, druhá k pokojnému kruhu starostlivosti; medzi nimi váhy z svetla, ktoré sa nenakláňajú.',
            'excerpt' => 'Skúšanie môže neukázať rozdiel, a predsa nedokáže, že liečby sú rovnaké. Prepare for Kidney Care porovnala prípravu stratégií, nie každého na dialýze s každým, kto ju odmietol. Titulok „Dialýza nepomáha“ ide ďalej, než dôkaz unesie.',
            'content' => <<<'HTML'
<p>Skúšanie môže neukázať rozdiel, a predsa nedokáže, že liečby sú rovnaké.</p>
<p>Toto rozlíšenie som držal v strede komentára k štúdii <em>Prepare for Kidney Care</em>, ktorý som 8. novembra 2026 o 16:22 zverejnil na portáli Nefro-projekt: <a href="https://nefro.polascin.net/article.php?slug=dialyza-konzervativna-starostlivost-starsi-prepare-kidney-care"><em>Dialýza a konzervatívna starostlivosť u starších pacientov v štúdii Prepare for Kidney Care</em></a>.</p>
<p>Štúdia randomizovala 445 starších ľudí so zlyhaním obličiek v 31 britských centrách. Medián veku bol 82 rokov. Porovnala prípravu na stratégiu konzervatívnej starostlivosti s prípravou na dialyzačnú stratégiu. Neporovnala jednoducho každého, kto dialýzu dostal, s každým, kto ju odmietol.</p>
<p>Primárny výsledok spájal dĺžku života s kvalitou života. Skúšanie superiority nepreukázalo štatisticky významný rozdiel. To nie je to isté ako dôkaz rovnakých výsledkov.</p>
<p>Neistota ostáva. Platí aj populácia, ktorú štúdia skúmala, možnosť zmeniť stratégiu a rozdiel medzi plánovaním liečby a tým, čo pacient naozaj dostane. Podľa správy o výsledkoch dialýzu nakoniec začala asi len štvrtina tých, ktorí sa na ňu pripravovali.</p>
<p>Bojím sa momentu, keď sa opatrný výsledok zmení na sebavedomý titulok: „Dialýza neprináša žiadny prínos.“ Ten záver ide ďalej, než táto štúdia unesie.</p>
<p>Konzervatívna starostlivosť o obličky si zaslúži vážny rozhovor ako aktívna liečba, nie ako odmietnutie „nerobiť nič“. Dialýza si zaslúži rovnako úprimný rozhovor o prínosoch aj o záťaži. Ani jeden z tých rozhovorov sa nezlepší, keď z dôkazu odstránime neistotu.</p>
<p>Predtým, než zdieľate klinický titulok, opýtajte sa: aké porovnanie štúdia naozaj urobila?</p>
<p><em>Ide o komentár k štúdii Prepare for Kidney Care (Lancet 2026; DOI: <a href="https://doi.org/10.1016/S0140-6736(26)01818-0">10.1016/S0140-6736(26)01818-0</a>; <a href="https://pubmed.ncbi.nlm.nih.gov/42982076/">PMID 42982076</a>) a k vlastnému článku na Nefro-projekte z 8. novembra 2026. Nie je to individuálny liečebný predpis. Plný text štúdie som pri tejto eseji samostatne nečítal; opieram sa o publikovaný komentár a o verejne dostupné abstrakty a správy o výsledkoch.</em></p>
HTML,
        ],
        'en' => [
            'title' => 'Failure to show a difference is not proof of equality',
            'image_alt' => 'A violet field with two paths of light: one toward teal dialysis geometry, the other toward a calm circle of care; between them a light-made scale that does not tip.',
            'excerpt' => 'A trial can fail to show a difference without proving the treatments are the same. Prepare for Kidney Care compared preparation strategies, not everyone on dialysis with everyone who refused it. The headline “Dialysis offers no benefit” goes beyond the evidence.',
            'content' => <<<'HTML'
<p>A trial can fail to show a difference without proving that the treatments are the same.</p>
<p>That distinction sat at the centre of my commentary on the <em>Prepare for Kidney Care</em> trial, published on 8 November 2026 at 16:22 on the Nefro-projekt site: <a href="https://nefro.polascin.net/article.php?slug=dialyza-konzervativna-starostlivost-starsi-prepare-kidney-care"><em>Dialysis and conservative care in older patients in the Prepare for Kidney Care trial</em></a>.</p>
<p>The trial randomised 445 older people with kidney failure across 31 UK centres. Their median age was 82. It compared preparation for a conservative-care strategy with preparation for a dialysis strategy. It did not simply compare everyone who received dialysis with everyone who refused it.</p>
<p>The primary outcome combined length of life with quality of life. The superiority trial did not establish a statistically significant difference. That is not the same as proving equal outcomes.</p>
<p>The uncertainty still matters. So do the population studied, the possibility of changing strategy, and the difference between planning treatment and actually receiving it. According to reports of the results, only about one in four of those preparing for dialysis eventually started it.</p>
<p>My concern is what happens when a careful result becomes a confident headline: “Dialysis offers no benefit.” That conclusion goes beyond what this trial establishes.</p>
<p>Conservative kidney care deserves a serious discussion as active treatment, not dismissal as doing nothing. Dialysis deserves an equally honest discussion of benefits and burdens. Neither conversation improves when we strip the uncertainty out of the evidence.</p>
<p>Before sharing a clinical headline, ask: what comparison did the study actually make?</p>
<p><em>This is a commentary on the Prepare for Kidney Care trial (Lancet 2026; DOI: <a href="https://doi.org/10.1016/S0140-6736(26)01818-0">10.1016/S0140-6736(26)01818-0</a>; <a href="https://pubmed.ncbi.nlm.nih.gov/42982076/">PMID 42982076</a>) and on my own Nefro-projekt article of 8 November 2026. It is not an individual treatment prescription. For this essay I did not independently read the full trial paper; I rely on the published commentary and on publicly available abstracts and result reports.</em></p>
HTML,
        ],
        'cs' => [
            'title' => 'Neukázaný rozdíl není důkaz rovnosti',
            'image_alt' => 'Fialová plocha se dvěma cestami světla: jedna k tyrkysové geometrii dialýzy, druhá ke klidnému kruhu péče; mezi nimi váhy ze světla, které se nenaklánějí.',
            'excerpt' => 'Zkoušení může neukázat rozdíl, a přesto nedokáže, že léčby jsou stejné. Prepare for Kidney Care porovnala přípravu strategií, ne každého na dialýze s každým, kdo ji odmítl. Titulek „Dialýza nepomáhá“ jde dál, než důkaz unese.',
            'content' => <<<'HTML'
<p>Zkoušení může neukázat rozdíl, a přesto nedokáže, že léčby jsou stejné.</p>
<p>Toto rozlišení jsem držel uprostřed komentáře ke studii <em>Prepare for Kidney Care</em>, který jsem 8. listopadu 2026 v 16:22 zveřejnil na portálu Nefro-projekt: <a href="https://nefro.polascin.net/article.php?slug=dialyza-konzervativna-starostlivost-starsi-prepare-kidney-care"><em>Dialýza a konzervativní péče u starších pacientů ve studii Prepare for Kidney Care</em></a>.</p>
<p>Studie randomizovala 445 starších lidí se selháním ledvin ve 31 britských centrech. Medián věku byl 82 let. Porovnala přípravu na strategii konzervativní péče s přípravou na dialyzační strategii. Neporovnala jednoduše každého, kdo dialýzu dostal, s každým, kdo ji odmítl.</p>
<p>Primární výsledek spojoval délku života s kvalitou života. Zkoušení superiority neprokázalo statisticky významný rozdíl. To není totéž jako důkaz stejných výsledků.</p>
<p>Nejistota zůstává. Platí i populace, kterou studie zkoumala, možnost změnit strategii a rozdíl mezi plánováním léčby a tím, co pacient opravdu dostane. Podle zpráv o výsledcích dialýzu nakonec začala asi jen čtvrtina těch, kteří se na ni připravovali.</p>
<p>Bojím se chvíle, kdy se opatrný výsledek změní v sebevědomý titulek: „Dialýza nepřináší žádný prospěch.“ Ten závěr jde dál, než tato studie unese.</p>
<p>Konzervativní péče o ledviny si zaslouží vážný rozhovor jako aktivní léčba, ne jako odmítnutí „nedělat nic“. Dialýza si zaslouží stejně upřímný rozhovor o prospěchu i o zátěži. Ani jeden z těch rozhovorů se nezlepší, když z důkazu odstraníme nejistotu.</p>
<p>Než sdílíte klinický titulek, zeptejte se: jaké porovnání studie opravdu udělala?</p>
<p><em>Jde o komentář ke studii Prepare for Kidney Care (Lancet 2026; DOI: <a href="https://doi.org/10.1016/S0140-6736(26)01818-0">10.1016/S0140-6736(26)01818-0</a>; <a href="https://pubmed.ncbi.nlm.nih.gov/42982076/">PMID 42982076</a>) a k vlastnímu článku na Nefro-projektu z 8. listopadu 2026. Není to individuální léčebný předpis. Plný text studie jsem při této eseji samostatně nečetl; opírám se o publikovaný komentář a o veřejně dostupné abstrakty a zprávy o výsledcích.</em></p>
HTML,
        ],
        'de' => [
            'title' => 'Kein gezeigter Unterschied ist kein Beweis der Gleichheit',
            'image_alt' => 'Violette Fläche mit zwei Lichtwegen: einer zur türkisen Dialyse-Geometrie, einer zum ruhigen Pflegekreis; dazwischen eine Waage aus Licht, die nicht kippt.',
            'excerpt' => 'Eine Studie kann keinen Unterschied zeigen und dennoch nicht beweisen, dass Behandlungen gleich sind. Prepare for Kidney Care verglich Vorbereitungsstrategien, nicht jeden an der Dialyse mit jedem, der sie ablehnte. Die Schlagzeile „Dialyse bringt keinen Nutzen“ geht über den Beweis hinaus.',
            'content' => <<<'HTML'
<p>Eine Studie kann keinen Unterschied zeigen und dennoch nicht beweisen, dass die Behandlungen gleich sind.</p>
<p>Diese Unterscheidung stand im Zentrum meines Kommentars zur Studie <em>Prepare for Kidney Care</em>, den ich am 8. November 2026 um 16:22 auf dem Portal Nefro-projekt veröffentlicht habe: <a href="https://nefro.polascin.net/article.php?slug=dialyza-konzervativna-starostlivost-starsi-prepare-kidney-care"><em>Dialyse und konservative Versorgung älterer Patienten in der Studie Prepare for Kidney Care</em></a>.</p>
<p>Die Studie randomisierte 445 ältere Menschen mit Nierenversagen in 31 britischen Zentren. Das mediane Alter betrug 82 Jahre. Sie verglich die Vorbereitung auf eine Strategie der konservativen Versorgung mit der Vorbereitung auf eine Dialysestrategie. Sie verglich nicht einfach jeden, der Dialyse erhielt, mit jedem, der sie ablehnte.</p>
<p>Der primäre Endpunkt verband Überlebensdauer mit Lebensqualität. Die Superioritätsstudie zeigte keinen statistisch signifikanten Unterschied. Das ist nicht dasselbe wie der Nachweis gleicher Ergebnisse.</p>
<p>Die Unsicherheit bleibt. Ebenso die untersuchte Population, die Möglichkeit, die Strategie zu wechseln, und der Unterschied zwischen der Planung einer Behandlung und dem, was der Patient tatsächlich erhält. Berichten zufolge begann nur etwa ein Viertel derer, die sich auf Dialyse vorbereiteten, sie schließlich.</p>
<p>Mich beunruhigt der Moment, in dem ein vorsichtiges Ergebnis zur selbstbewussten Schlagzeile wird: „Dialyse bringt keinen Nutzen.“ Dieser Schluss geht weiter, als diese Studie trägt.</p>
<p>Konservative Nierenversorgung verdient ein ernstes Gespräch als aktive Behandlung, nicht als Abtun von „nichts tun“. Dialyse verdient ein ebenso ehrliches Gespräch über Nutzen und Belastung. Keines der beiden Gespräche wird besser, wenn wir die Unsicherheit aus dem Beweis streichen.</p>
<p>Bevor Sie eine klinische Schlagzeile teilen, fragen Sie: welchen Vergleich hat die Studie tatsächlich angestellt?</p>
<p><em>Dies ist ein Kommentar zur Studie Prepare for Kidney Care (Lancet 2026; DOI: <a href="https://doi.org/10.1016/S0140-6736(26)01818-0">10.1016/S0140-6736(26)01818-0</a>; <a href="https://pubmed.ncbi.nlm.nih.gov/42982076/">PMID 42982076</a>) und zu meinem eigenen Artikel auf Nefro-projekt vom 8. November 2026. Es ist keine individuelle Behandlungsvorschrift. Den Volltext der Studie habe ich für diesen Essay nicht selbst gelesen; ich stütze mich auf den veröffentlichten Kommentar und auf öffentlich verfügbare Abstracts und Ergebnisberichte.</em></p>
HTML,
        ],
        'fr' => [
            'title' => 'L’absence de différence n’est pas une preuve d’égalité',
            'image_alt' => 'Champ violet avec deux chemins de lumière : l’un vers une géométrie turquoise de dialyse, l’autre vers un cercle calme de soins ; entre eux une balance de lumière qui ne penche pas.',
            'excerpt' => 'Un essai peut ne pas montrer de différence sans prouver que les traitements sont égaux. Prepare for Kidney Care a comparé des stratégies de préparation, non tous les dialysés à tous ceux qui l’ont refusée. Le titre « La dialyse n’apporte aucun bénéfice » dépasse la preuve.',
            'content' => <<<'HTML'
<p>Un essai peut ne pas montrer de différence sans pour autant prouver que les traitements sont égaux.</p>
<p>Cette distinction était au centre de mon commentaire sur l’essai <em>Prepare for Kidney Care</em>, publié le 8 novembre 2026 à 16 h 22 sur le portail Nefro-projekt : <a href="https://nefro.polascin.net/article.php?slug=dialyza-konzervativna-starostlivost-starsi-prepare-kidney-care"><em>Dialyse et soins conservateurs chez les patients âgés dans l’essai Prepare for Kidney Care</em></a>.</p>
<p>L’essai a randomisé 445 personnes âgées en insuffisance rénale dans 31 centres britanniques. L’âge médian était de 82 ans. Il a comparé la préparation à une stratégie de soins conservateurs avec la préparation à une stratégie de dialyse. Il n’a pas simplement comparé tous ceux qui ont reçu la dialyse à tous ceux qui l’ont refusée.</p>
<p>Le critère principal combinait durée et qualité de vie. L’essai de supériorité n’a pas établi de différence statistiquement significative. Ce n’est pas la même chose que prouver des résultats égaux.</p>
<p>L’incertitude compte encore. De même la population étudiée, la possibilité de changer de stratégie, et la différence entre planifier un traitement et le recevoir vraiment. Selon les comptes rendus des résultats, seulement environ un quart de ceux qui se préparaient à la dialyse l’ont finalement commencée.</p>
<p>Ce qui m’inquiète, c’est le moment où un résultat prudent devient un titre assuré : « La dialyse n’apporte aucun bénéfice. » Cette conclusion va au-delà de ce que cet essai établit.</p>
<p>Les soins rénaux conservateurs méritent une discussion sérieuse comme traitement actif, non comme un « ne rien faire ». La dialyse mérite une discussion aussi honnête sur les bénéfices et les charges. Aucune de ces conversations ne s’améliore quand on retire l’incertitude de la preuve.</p>
<p>Avant de partager un titre clinique, demandez : quelle comparaison l’étude a-t-elle réellement faite ?</p>
<p><em>Il s’agit d’un commentaire sur l’essai Prepare for Kidney Care (Lancet 2026 ; DOI : <a href="https://doi.org/10.1016/S0140-6736(26)01818-0">10.1016/S0140-6736(26)01818-0</a> ; <a href="https://pubmed.ncbi.nlm.nih.gov/42982076/">PMID 42982076</a>) et sur mon article Nefro-projekt du 8 novembre 2026. Ce n’est pas une prescription individuelle. Pour ce texte, je n’ai pas lu indépendamment le texte intégral de l’étude ; je m’appuie sur le commentaire publié et sur les résumés et comptes rendus publics.</em></p>
HTML,
        ],
        'es' => [
            'title' => 'No mostrar diferencia no es prueba de igualdad',
            'image_alt' => 'Campo violeta con dos caminos de luz: uno hacia una geometría turquesa de diálisis, otro hacia un círculo sereno de cuidados; entre ellos una balanza de luz que no se inclina.',
            'excerpt' => 'Un ensayo puede no mostrar diferencia sin demostrar que los tratamientos son iguales. Prepare for Kidney Care comparó estrategias de preparación, no a todos en diálisis con todos los que la rechazaron. El titular «La diálisis no aporta beneficio» va más allá de la evidencia.',
            'content' => <<<'HTML'
<p>Un ensayo puede no mostrar una diferencia sin demostrar que los tratamientos son iguales.</p>
<p>Esa distinción estuvo en el centro de mi comentario sobre el ensayo <em>Prepare for Kidney Care</em>, publicado el 8 de noviembre de 2026 a las 16:22 en el portal Nefro-projekt: <a href="https://nefro.polascin.net/article.php?slug=dialyza-konzervativna-starostlivost-starsi-prepare-kidney-care"><em>Diálisis y cuidados conservadores en pacientes mayores en el ensayo Prepare for Kidney Care</em></a>.</p>
<p>El ensayo aleatorizó a 445 personas mayores con fallo renal en 31 centros del Reino Unido. La mediana de edad fue 82 años. Comparó la preparación para una estrategia de cuidados conservadores con la preparación para una estrategia de diálisis. No comparó simplemente a todos los que recibieron diálisis con todos los que la rechazaron.</p>
<p>El desenlace primario combinó duración y calidad de vida. El ensayo de superioridad no estableció una diferencia estadísticamente significativa. Eso no es lo mismo que demostrar resultados iguales.</p>
<p>La incertidumbre sigue importando. También la población estudiada, la posibilidad de cambiar de estrategia y la diferencia entre planificar un tratamiento y recibirlo de verdad. Según los informes de resultados, solo alrededor de una cuarta parte de quienes se preparaban para la diálisis acabó iniciándola.</p>
<p>Me preocupa el momento en que un resultado cuidadoso se convierte en un titular seguro: «La diálisis no aporta ningún beneficio.» Esa conclusión va más allá de lo que este ensayo establece.</p>
<p>Los cuidados renales conservadores merecen una discusión seria como tratamiento activo, no como un «no hacer nada». La diálisis merece una discusión igual de honesta sobre beneficios y cargas. Ninguna de esas conversaciones mejora cuando quitamos la incertidumbre de la evidencia.</p>
<p>Antes de compartir un titular clínico, pregunte: ¿qué comparación hizo realmente el estudio?</p>
<p><em>Es un comentario sobre el ensayo Prepare for Kidney Care (Lancet 2026; DOI: <a href="https://doi.org/10.1016/S0140-6736(26)01818-0">10.1016/S0140-6736(26)01818-0</a>; <a href="https://pubmed.ncbi.nlm.nih.gov/42982076/">PMID 42982076</a>) y sobre mi artículo en Nefro-projekt del 8 de noviembre de 2026. No es una prescripción individual. Para este ensayo no leí de forma independiente el texto completo del estudio; me baso en el comentario publicado y en resúmenes e informes públicos.</em></p>
HTML,
        ],
        'pl' => [
            'title' => 'Brak wykazanej różnicy nie jest dowodem równości',
            'image_alt' => 'Fioletowa płaszczyzna z dwoma ścieżkami światła: jedna ku turkusowej geometrii dializy, druga ku spokojnemu kręgowi opieki; między nimi waga ze światła, która się nie przechyla.',
            'excerpt' => 'Badanie może nie wykazać różnicy, a mimo to nie udowodnić, że terapie są równe. Prepare for Kidney Care porównała strategie przygotowania, nie każdego na dializie z każdym, kto ją odrzucił. Nagłówek „Dializa nie przynosi korzyści” idzie dalej niż dowód.',
            'content' => <<<'HTML'
<p>Badanie może nie wykazać różnicy, a mimo to nie udowodnić, że terapie są równe.</p>
<p>To rozróżnienie trzymałem w centrum komentarza do badania <em>Prepare for Kidney Care</em>, który 8 listopada 2026 o 16:22 opublikowałem na portalu Nefro-projekt: <a href="https://nefro.polascin.net/article.php?slug=dialyza-konzervativna-starostlivost-starsi-prepare-kidney-care"><em>Dializa i opieka zachowawcza u starszych pacjentów w badaniu Prepare for Kidney Care</em></a>.</p>
<p>Badanie randomizowało 445 starszych osób z niewydolnością nerek w 31 ośrodkach w Wielkiej Brytanii. Mediana wieku wyniosła 82 lata. Porównało przygotowanie do strategii opieki zachowawczej z przygotowaniem do strategii dializacyjnej. Nie porównało po prostu każdego, kto otrzymał dializę, z każdym, kto ją odrzucił.</p>
<p>Pierwotny wynik łączył długość życia z jakością życia. Badanie wyższości nie wykazało statystycznie istotnej różnicy. To nie to samo co dowód równych wyników.</p>
<p>Niepewność nadal ma znaczenie. Także badana populacja, możliwość zmiany strategii oraz różnica między planowaniem leczenia a tym, co pacjent naprawdę otrzyma. Według doniesień o wynikach dializę ostatecznie rozpoczęła tylko około jedna czwarta tych, którzy się do niej przygotowywali.</p>
<p>Obawiam się chwili, gdy ostrożny wynik staje się pewnym siebie nagłówkiem: „Dializa nie przynosi żadnej korzyści.” Ten wniosek idzie dalej, niż to badanie unosi.</p>
<p>Zachowawcza opieka nerkowa zasługuje na poważną rozmowę jako aktywne leczenie, nie jako odrzucenie „nicnierobienia”. Dializa zasługuje na równie szczerą rozmowę o korzyściach i obciążeniu. Żadna z tych rozmów nie poprawia się, gdy z dowodu usuniemy niepewność.</p>
<p>Zanim udostępnicie kliniczny nagłówek, zapytajcie: jakie porównanie badanie naprawdę przeprowadziło?</p>
<p><em>To komentarz do badania Prepare for Kidney Care (Lancet 2026; DOI: <a href="https://doi.org/10.1016/S0140-6736(26)01818-0">10.1016/S0140-6736(26)01818-0</a>; <a href="https://pubmed.ncbi.nlm.nih.gov/42982076/">PMID 42982076</a>) oraz do własnego artykułu na Nefro-projekcie z 8 listopada 2026. Nie jest to indywidualna recepta. Pełnego tekstu badania przy tym eseju samodzielnie nie czytałem; opieram się na opublikowanym komentarzu oraz na publicznie dostępnych abstraktach i raportach wyników.</em></p>
HTML,
        ],
        'hu' => [
            'title' => 'A ki nem mutatott különbség nem az egyenlőség bizonyítéka',
            'image_alt' => 'Lila mező két fényúttal: az egyik a dialízis türkiz geometriája felé, a másik a gondozás nyugodt köre felé; köztük egy fényből álló mérleg, amely nem billen.',
            'excerpt' => 'Egy vizsgálat nem mutathat különbséget anélkül, hogy bebizonyítaná: a kezelések egyenlők. A Prepare for Kidney Care előkészítési stratégiákat hasonlított össze, nem minden dializáltat mindenkivel, aki elutasította. A „A dialízisnek nincs haszna” cím túl megy a bizonyítékon.',
            'content' => <<<'HTML'
<p>Egy vizsgálat nem mutathat különbséget anélkül, hogy bebizonyítaná: a kezelések egyenlők.</p>
<p>Ez a megkülönböztetés állt a <em>Prepare for Kidney Care</em> vizsgálatról írt kommentárom középpontjában, amelyet 2026. november 8-án 16:22-kor tettem közzé a Nefro-projekt portálon: <a href="https://nefro.polascin.net/article.php?slug=dialyza-konzervativna-starostlivost-starsi-prepare-kidney-care"><em>Dialízis és konzervatív ellátás idősebb betegeknél a Prepare for Kidney Care vizsgálatban</em></a>.</p>
<p>A vizsgálat 445 idősebb, veseelégtelenséggel élő embert randomizált 31 brit központban. A medián életkor 82 év volt. A konzervatív ellátási stratégia előkészítését hasonlította össze a dialízisstratégia előkészítésével. Nem egyszerűen mindenkit, aki dialízist kapott, hasonlított össze mindenkivel, aki elutasította.</p>
<p>Az elsődleges végpont az élet hosszát és minőségét kapcsolta össze. A superioritásvizsgálat nem mutatott ki statisztikailag szignifikáns különbséget. Ez nem ugyanaz, mint az egyenlő eredmények bizonyítása.</p>
<p>A bizonytalanság továbbra is számít. Ugyanígy a vizsgált populáció, a stratégiaváltás lehetősége, és a különbség a kezelés tervezése és a tényleges fogadása között. Az eredményekről szóló beszámolók szerint a dialízisre készülőknek csak körülbelül egynegyede kezdte el végül.</p>
<p>Attól tartok, amikor egy óvatos eredmény magabiztos címmé válik: „A dialízisnek nincs haszna.” Ez a következtetés tovább megy, mint amit ez a vizsgálat megállapít.</p>
<p>A konzervatív vesegondozás komoly beszélgetést érdemel aktív kezelésként, nem pedig „semmittevésként” való elutasítást. A dialízis ugyanolyan őszinte beszélgetést érdemel az előnyökről és a terhekről. Egyik beszélgetés sem javul, ha a bizonyítékból kivesszük a bizonytalanságot.</p>
<p>Mielőtt klinikai címet megosztanának, kérdezzék meg: milyen összehasonlítást végzett valójában a vizsgálat?</p>
<p><em>Ez a Prepare for Kidney Care vizsgálatról (Lancet 2026; DOI: <a href="https://doi.org/10.1016/S0140-6736(26)01818-0">10.1016/S0140-6736(26)01818-0</a>; <a href="https://pubmed.ncbi.nlm.nih.gov/42982076/">PMID 42982076</a>) és a 2026. november 8-i Nefro-projekt cikkelyemről szóló kommentár. Nem egyéni kezelési előírás. Ehhez az esszéhez a vizsgálat teljes szövegét önállóan nem olvastam; a közzétett kommentárra és a nyilvánosan elérhető absztraktokra és eredményjelentésekre támaszkodom.</em></p>
HTML,
        ],
        'it' => [
            'title' => 'Non mostrare una differenza non è prova di uguaglianza',
            'image_alt' => 'Campo violetto con due percorsi di luce: uno verso la geometria turchese della dialisi, l’altro verso un cerchio calmo di cura; tra di essi una bilancia di luce che non si inclina.',
            'excerpt' => 'Uno studio può non mostrare una differenza senza dimostrare che i trattamenti sono uguali. Prepare for Kidney Care ha confrontato strategie di preparazione, non tutti in dialisi con tutti coloro che l’hanno rifiutata. Il titolo «La dialisi non offre alcun beneficio» va oltre la prova.',
            'content' => <<<'HTML'
<p>Uno studio può non mostrare una differenza senza dimostrare che i trattamenti sono uguali.</p>
<p>Questa distinzione era al centro del mio commento allo studio <em>Prepare for Kidney Care</em>, pubblicato l’8 novembre 2026 alle 16:22 sul portale Nefro-projekt: <a href="https://nefro.polascin.net/article.php?slug=dialyza-konzervativna-starostlivost-starsi-prepare-kidney-care"><em>Dialisi e cure conservative nei pazienti anziani nello studio Prepare for Kidney Care</em></a>.</p>
<p>Lo studio ha randomizzato 445 persone anziane con insufficienza renale in 31 centri britannici. L’età mediana era 82 anni. Ha confrontato la preparazione a una strategia di cure conservative con la preparazione a una strategia dialitica. Non ha semplicemente confrontato tutti coloro che hanno ricevuto la dialisi con tutti coloro che l’hanno rifiutata.</p>
<p>L’esito primario combinava durata e qualità della vita. Lo studio di superiorità non ha stabilito una differenza statisticamente significativa. Non è la stessa cosa che dimostrare esiti uguali.</p>
<p>L’incertezza conta ancora. Così la popolazione studiata, la possibilità di cambiare strategia e la differenza tra pianificare un trattamento e riceverlo davvero. Secondo i resoconti dei risultati, solo circa un quarto di chi si preparava alla dialisi l’ha infine iniziata.</p>
<p>Temo il momento in cui un risultato cauto diventa un titolo sicuro: «La dialisi non offre alcun beneficio.» Quella conclusione va oltre ciò che questo studio stabilisce.</p>
<p>Le cure renali conservative meritano una discussione seria come trattamento attivo, non come un «non fare nulla». La dialisi merita una discussione altrettanto onesta su benefici e oneri. Nessuna delle due conversazioni migliora quando togliamo l’incertezza dalla prova.</p>
<p>Prima di condividere un titolo clinico, chiedete: quale confronto ha davvero fatto lo studio?</p>
<p><em>È un commento allo studio Prepare for Kidney Care (Lancet 2026; DOI: <a href="https://doi.org/10.1016/S0140-6736(26)01818-0">10.1016/S0140-6736(26)01818-0</a>; <a href="https://pubmed.ncbi.nlm.nih.gov/42982076/">PMID 42982076</a>) e al mio articolo su Nefro-projekt dell’8 novembre 2026. Non è una prescrizione individuale. Per questo saggio non ho letto indipendentemente il testo integrale dello studio; mi baso sul commento pubblicato e su abstract e resoconti pubblici.</em></p>
HTML,
        ],
        'uk' => [
            'title' => 'Непоказана різниця не є доказом рівності',
            'image_alt' => 'Фіолетове поле з двома шляхами світла: один до бірюзової геометрії діалізу, другий до спокійного кола догляду; між ними терези зі світла, які не нахиляються.',
            'excerpt' => 'Дослідження може не показати різниці і все ж не довести, що лікування однакові. Prepare for Kidney Care порівняла стратегії підготовки, а не кожного на діалізі з кожним, хто відмовився. Заголовок «Діаліз не дає користі» йде далі за доказ.',
            'content' => <<<'HTML'
<p>Дослідження може не показати різниці і все ж не довести, що лікування однакові.</p>
<p>Це розрізнення я тримав у центрі коментаря до дослідження <em>Prepare for Kidney Care</em>, який 8 листопада 2026 о 16:22 опублікував на порталі Nefro-projekt: <a href="https://nefro.polascin.net/article.php?slug=dialyza-konzervativna-starostlivost-starsi-prepare-kidney-care"><em>Діаліз і консервативний догляд у літніх пацієнтів у дослідженні Prepare for Kidney Care</em></a>.</p>
<p>Дослідження рандомізувало 445 літніх людей із нирковою недостатністю в 31 британському центрі. Медіана віку становила 82 роки. Воно порівняло підготовку до стратегії консервативного догляду з підготовкою до діалізної стратегії. Воно не просто порівняло кожного, хто отримав діаліз, з кожним, хто його відхилив.</p>
<p>Первинний результат поєднував тривалість життя з якістю життя. Дослідження суперіорності не встановило статистично значущої різниці. Це не те саме, що доказ однакових результатів.</p>
<p>Невизначеність досі має значення. Так само й досліджена популяція, можливість змінити стратегію та різниця між плануванням лікування і тим, що пацієнт справді отримує. За повідомленнями про результати діаліз зрештою почала лише приблизно чверть тих, хто до нього готувався.</p>
<p>Мене турбує момент, коли обережний результат стає впевненим заголовком: «Діаліз не дає жодної користі.» Цей висновок іде далі, ніж те, що встановлює це дослідження.</p>
<p>Консервативний догляд за нирками заслуговує на серйозну розмову як активне лікування, а не як відмову «нічого не робити». Діаліз заслуговує на так само чесну розмову про користь і тягар. Жодна з цих розмов не покращується, коли з доказу прибираємо невизначеність.</p>
<p>Перш ніж ділитися клінічним заголовком, запитайте: яке порівняння дослідження насправді зробило?</p>
<p><em>Це коментар до дослідження Prepare for Kidney Care (Lancet 2026; DOI: <a href="https://doi.org/10.1016/S0140-6736(26)01818-0">10.1016/S0140-6736(26)01818-0</a>; <a href="https://pubmed.ncbi.nlm.nih.gov/42982076/">PMID 42982076</a>) і до власної статті на Nefro-проекті від 8 листопада 2026. Це не індивідуальний лікувальний припис. Повний текст дослідження для цього есе я самостійно не читав; спираюся на опублікований коментар і на загальнодоступні анотації та звіти про результати.</em></p>
HTML,
        ],
    ],
];
