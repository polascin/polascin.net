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

$source = '<a href="https://aeon.co/essays/all-our-models-of-how-the-mind-functions-are-missing-something">The energy of thought</a>';

return [
    'slug' => 'co-drzi-spomienku-pohromade',
    'author' => 'MUDr. Ľubomír Polaščín',
    'category' => 'blog',
    'is_top' => 0,
    'published_at' => '2026-11-28 09:55:00',
    'image' => 'images/articles/co-drzi-spomienku-pohromade.webp',
    'translations' => [
        'sk' => [
            'title' => 'Čo drží spomienku pohromade',
            'image_alt' => 'Tyrkysová voda prúdi skleneným prstencom na fialovom pozadí.',
            'excerpt' => 'Niektoré spomienky pretrvajú dlhšie než molekuly v synapsiách. Ako sa dá niečo uchovať na mieste, ktoré sa ustavične obnovuje?',
            'content' => <<<'HTML'
<p>Prúd vo fontáne má svoj tvar, hoci voda, ktorú vidíme, sa ustavične mení. Kým čerpadlo beží, dá sa ten tvar nakresliť. Z kresby však nezistíme, čo ho drží.</p>
<p>Pri pamäti sa podobný rozdiel ľahko stratí. Slovo „uložiť“ pripomína súbor, ktorý sa po zatvorení dá znova otvoriť. V mozgu sa pri učení menia synapsie, miesta, kde si nervové bunky odovzdávajú signály. Molekuly v synapsiách sa priebežne vymieňajú. Niektoré spomienky pritom vydržia roky. Predstava zápisu nám pomáha opísať, čo zostáva. Hneď za ňou sa však vynorí otázka, čo sa musí diať, aby to zostalo.</p>
<p>David Colaço a Philipp Haueis v eseji pre <em>Aeon</em> navrhujú, aby sme od modelov mysle žiadali odpoveď aj na túto otázku. Nervová bunka potrebuje energiu na prenos signálu aj na udržanie podmienok, v ktorých signál môže vzniknúť. Jedna z možností, ktoré autori rozoberajú, je, že synapsia môže aktívne udržiavať určitý stav aj počas výmeny svojich molekúl. Je to vysvetlenie, ktoré možno skúmať. Doklad o tom, ako mozog uchováva konkrétnu spomienku, by si vyžadoval ďalšie dôkazy.</p>
<p>Energia tu dáva teórii mierku. Ak model predpokladá viac práce, než živá bunka dokáže vykonať, treba ho prepracovať. Ak sa do jej možností zmestí, má zmysel skúmať ďalej, či bunka túto prácu skutočne robí. Rovnaká opatrnosť sa hodí pri porovnávaní mozgu s počítačom. Podobný výsledok ešte veľa nehovorí o tom, čo každý z nich musí priebežne udržiavať, aby k nemu dospel.</p>
<p>Na fontáne je najľahšie všimnúť si oblúk vody. Pri pamäti si zasa všimneme chvíľu, keď sa nám niečo vybaví. Tá najzaujímavejšia práca sa možno odohráva medzi dvoma takými chvíľami, keď si na tú vec vôbec nespomenieme.</p>
HTML
            . "\n<p><small><em>Inšpirácia: David Colaço a Philipp Haueis, {$source}, Aeon, 27. novembra 2026.</em></small></p>",
        ],
        'en' => [
            'title' => 'What holds a memory together',
            'image_alt' => 'Turquoise water flows through a glass ring against a violet background.',
            'excerpt' => 'Some memories outlast the molecules in synapses. How can something persist in a place that is continually being renewed?',
            'content' => <<<'HTML'
<p>The stream in a fountain keeps its shape even as the water passing through it changes. While the pump runs, you can draw that shape. The drawing gives you little idea of what keeps it there.</p>
<p>With memory, it is easy to lose sight of that distinction. To “store” something brings to mind a file you close and open again later. Learning changes synapses, the places where nerve cells pass signals to one another. Their molecules are continually replaced. Some memories last for years. Thinking of memory as a record helps describe what stays. It also raises a question about what has to happen for it to stay.</p>
<p>In an essay for <em>Aeon</em>, David Colaço and Philipp Haueis suggest that models of the mind should answer this question too. A nerve cell needs energy to transmit a signal and to sustain the conditions in which that signal can arise. One possibility the authors discuss is that a synapse actively maintains a particular state even as its molecules are replaced. This explanation can be investigated. Showing how the brain preserves a particular memory would require further evidence.</p>
<p>Energy gives us a way to test the theory. If a model calls for more work than a living cell can do, it needs revising. If the work is within the cell’s capacity, we can go on to ask whether the cell actually does it. The same caution helps when comparing a brain with a computer. A similar result tells us little about what each has to keep going in order to arrive at it.</p>
<p>The easiest thing to see in a fountain is the arc of water. With memory, what we notice is the moment something comes to mind. Perhaps the most interesting work happens between two such moments, when the thing never crosses our mind at all.</p>
HTML
            . "\n<p><small><em>Inspiration: David Colaço and Philipp Haueis, {$source}, Aeon, 27 November 2026.</em></small></p>",
        ],
        'cs' => [
            'title' => 'Co drží vzpomínku pohromadě',
            'image_alt' => 'Tyrkysová voda proudí skleněným prstencem na fialovém pozadí.',
            'excerpt' => 'Některé vzpomínky přetrvají déle než molekuly v synapsích. Jak lze něco uchovat na místě, které se neustále obnovuje?',
            'content' => <<<'HTML'
<p>Proud ve fontáně si zachovává tvar, i když se voda, kterou vidíme, neustále mění. Dokud běží čerpadlo, dá se ten tvar nakreslit. Z kresby se však nedozvíme, co ho udržuje.</p>
<p>U paměti se podobný rozdíl snadno přehlédne. Slovo „uložit“ připomíná soubor, který po zavření můžeme zase otevřít. Při učení se v mozku mění synapse, místa, kde si nervové buňky předávají signály. Molekuly v synapsích se průběžně vyměňují. Některé vzpomínky přitom vydrží celé roky. Představa zápisu nám pomáhá popsat, co zůstává. Hned nato se ovšem vynoří otázka, co se musí dít, aby to zůstalo.</p>
<p>David Colaço a Philipp Haueis v eseji pro <em>Aeon</em> navrhují, abychom od modelů mysli žádali odpověď i na tuto otázku. Nervová buňka potřebuje energii k přenosu signálu i k udržení podmínek, za nichž může signál vzniknout. Jedna z možností, o nichž autoři píšou, je, že synapse aktivně udržuje určitý stav, i když se její molekuly vyměňují. Takové vysvětlení lze zkoumat. K doložení toho, jak mozek uchovává konkrétní vzpomínku, by bylo třeba dalších důkazů.</p>
<p>Energie tu dává teorii měřítko. Pokud model vyžaduje víc práce, než dokáže živá buňka vykonat, je třeba ho přepracovat. Pokud je ta práce v jejích silách, má smysl dál zkoumat, zda ji skutečně vykonává. Stejná opatrnost se hodí při srovnávání mozku s počítačem. Podobný výsledek nám říká málo o tom, co každý z nich musí průběžně udržovat, aby k němu dospěl.</p>
<p>Na fontáně si nejsnáze všimneme oblouku vody. U paměti si zase všimneme chvíle, kdy se nám něco vybaví. Možná se ta nejzajímavější práce odehrává mezi dvěma takovými chvílemi, kdy si na tu věc vůbec nevzpomeneme.</p>
HTML
            . "\n<p><small><em>Inspirace: David Colaço a Philipp Haueis, {$source}, Aeon, 27. listopadu 2026.</em></small></p>",
        ],
        'de' => [
            'title' => 'Was eine Erinnerung zusammenhält',
            'image_alt' => 'Türkisfarbenes Wasser fließt durch einen Glasring vor violettem Hintergrund.',
            'excerpt' => 'Manche Erinnerungen überdauern die Moleküle in den Synapsen. Wie kann etwas an einem Ort bestehen bleiben, der sich ständig erneuert?',
            'content' => <<<'HTML'
<p>Der Wasserstrahl eines Springbrunnens behält seine Form, obwohl das Wasser darin ständig wechselt. Solange die Pumpe läuft, lässt sich die Form zeichnen. Die Zeichnung verrät kaum etwas darüber, was den Wasserstrahl in Form hält.</p>
<p>Beim Gedächtnis gerät dieser Unterschied leicht aus dem Blick. Das Wort „speichern“ erinnert an eine Datei, die wir schließen und später wieder öffnen können. Beim Lernen verändern sich im Gehirn die Synapsen, die Stellen, an denen Nervenzellen Signale weitergeben. Die Moleküle dort werden laufend ausgetauscht. Manche Erinnerungen bleiben dennoch jahrelang erhalten. Die Vorstellung einer Aufzeichnung hilft zu beschreiben, was bleibt. Sie wirft zugleich die Frage auf, was geschehen muss, damit es bleibt.</p>
<p>David Colaço und Philipp Haueis schlagen in einem Essay für <em>Aeon</em> vor, dass Modelle des Geistes auch diese Frage beantworten sollten. Eine Nervenzelle braucht Energie, um ein Signal zu übertragen und die Bedingungen aufrechtzuerhalten, unter denen es entstehen kann. Eine der Möglichkeiten, die die Autoren erörtern, ist, dass eine Synapse einen bestimmten Zustand aktiv aufrechterhält, während ihre Moleküle ausgetauscht werden. Diese Erklärung lässt sich untersuchen. Um zu zeigen, wie das Gehirn eine bestimmte Erinnerung bewahrt, wären weitere Belege nötig.</p>
<p>Die Energie gibt der Theorie hier einen Maßstab. Verlangt ein Modell mehr Arbeit, als eine lebende Zelle leisten kann, muss es überarbeitet werden. Liegt die Arbeit im Rahmen ihrer Möglichkeiten, lässt sich weiter untersuchen, ob die Zelle sie tatsächlich leistet. Dieselbe Vorsicht ist beim Vergleich von Gehirn und Computer angebracht. Ein ähnliches Ergebnis sagt wenig darüber aus, was beide jeweils aufrechterhalten müssen, um es zu erreichen.</p>
<p>Am Springbrunnen fällt der Wasserbogen zuerst ins Auge. Beim Erinnern fällt uns der Augenblick auf, in dem uns etwas wieder einfällt. Vielleicht geschieht die interessanteste Arbeit zwischen zwei solchen Augenblicken, wenn wir überhaupt nicht daran denken.</p>
HTML
            . "\n<p><small><em>Anregung: David Colaço und Philipp Haueis, {$source}, Aeon, 27. November 2026.</em></small></p>",
        ],
        'fr' => [
            'title' => 'Ce qui permet à un souvenir de durer',
            'image_alt' => 'De l’eau turquoise circule dans un anneau de verre sur fond violet.',
            'excerpt' => 'Certains souvenirs durent plus longtemps que les molécules des synapses. Comment une chose peut-elle se conserver dans un milieu qui se renouvelle sans cesse ?',
            'content' => <<<'HTML'
<p>Le jet d’une fontaine garde sa forme alors que l’eau qui le compose change sans cesse. Tant que la pompe fonctionne, on peut dessiner cette forme. Le dessin nous dit peu de chose sur ce qui la maintient.</p>
<p>Quand il est question de mémoire, cette distinction passe facilement inaperçue. Le mot « stocker » évoque un fichier que l’on ferme et que l’on peut rouvrir plus tard. Dans le cerveau, l’apprentissage modifie les synapses, ces points où les cellules nerveuses se transmettent des signaux. Les molécules qui s’y trouvent sont continuellement remplacées. Certains souvenirs durent pourtant des années. L’idée d’un enregistrement aide à décrire ce qui persiste. Elle amène aussitôt à se demander ce qui doit se passer pour que cela dure.</p>
<p>Dans un essai paru dans <em>Aeon</em>, David Colaço et Philipp Haueis proposent de demander aux modèles de l’esprit de répondre aussi à cette question. Une cellule nerveuse a besoin d’énergie pour transmettre un signal et pour maintenir les conditions dans lesquelles il peut naître. Parmi les possibilités qu’examinent les auteurs, une synapse pourrait maintenir activement un état donné pendant que ses molécules se renouvellent. Cette explication peut être étudiée. Il faudrait d’autres éléments pour établir comment le cerveau conserve un souvenir précis.</p>
<p>L’énergie donne ici un moyen d’évaluer la théorie. Si un modèle exige plus de travail qu’une cellule vivante ne peut en fournir, il faut le revoir. Si ce travail est à sa portée, on peut chercher à savoir si elle l’effectue réellement. La même prudence s’impose quand on compare le cerveau à un ordinateur. Un résultat semblable nous renseigne peu sur ce que chacun doit maintenir en fonctionnement pour y parvenir.</p>
<p>Dans une fontaine, c’est l’arc de l’eau que l’on remarque le plus facilement. Dans le cas de la mémoire, c’est l’instant où quelque chose nous revient. Le travail le plus intéressant se fait peut-être entre deux de ces instants, quand nous n’y pensons pas du tout.</p>
HTML
            . "\n<p><small><em>Source d’inspiration : David Colaço et Philipp Haueis, {$source}, Aeon, 27 novembre 2026.</em></small></p>",
        ],
        'es' => [
            'title' => 'Qué sostiene un recuerdo',
            'image_alt' => 'Agua turquesa circula por un anillo de cristal sobre un fondo violeta.',
            'excerpt' => 'Algunos recuerdos duran más que las moléculas de las sinapsis. ¿Cómo se conserva algo en un lugar que se renueva continuamente?',
            'content' => <<<'HTML'
<p>El chorro de una fuente conserva su forma aunque el agua que vemos cambie continuamente. Mientras funcione la bomba, podemos dibujar esa forma. El dibujo apenas nos dice qué la mantiene.</p>
<p>Cuando hablamos de memoria, es fácil pasar por alto esa diferencia. La palabra «guardar» recuerda a un archivo que cerramos y podemos volver a abrir. Al aprender, cambian en el cerebro las sinapsis, los puntos en los que las células nerviosas se transmiten señales. Sus moléculas se reemplazan de forma continua. Algunos recuerdos, sin embargo, duran años. Pensar en un registro ayuda a describir lo que permanece. Enseguida surge la pregunta de qué tiene que ocurrir para que permanezca.</p>
<p>En un ensayo para <em>Aeon</em>, David Colaço y Philipp Haueis proponen que los modelos de la mente respondan también a esta pregunta. Una célula nerviosa necesita energía para transmitir una señal y para mantener las condiciones en las que esa señal puede surgir. Una de las posibilidades que examinan los autores es que una sinapsis mantenga activamente un determinado estado mientras se reemplazan sus moléculas. Es una explicación que puede investigarse. Para demostrar cómo conserva el cerebro un recuerdo concreto harían falta más pruebas.</p>
<p>La energía da aquí una medida con la que evaluar la teoría. Si un modelo exige más trabajo del que puede hacer una célula viva, hay que revisarlo. Si ese trabajo está a su alcance, tiene sentido investigar si realmente lo realiza. Conviene la misma cautela al comparar el cerebro con un ordenador. Un resultado parecido dice poco sobre lo que cada uno debe mantener en funcionamiento para llegar a él.</p>
<p>En una fuente, lo más fácil de ver es el arco del agua. Cuando recordamos, lo que advertimos es el instante en que algo vuelve a la mente. Quizá el trabajo más interesante ocurra entre dos de esos momentos, cuando ese recuerdo ni siquiera nos pasa por la cabeza.</p>
HTML
            . "\n<p><small><em>Fuente de inspiración: David Colaço y Philipp Haueis, {$source}, Aeon, 27 de noviembre de 2026.</em></small></p>",
        ],
        'pl' => [
            'title' => 'Co podtrzymuje wspomnienie',
            'image_alt' => 'Turkusowa woda przepływa przez szklany pierścień na fioletowym tle.',
            'excerpt' => 'Niektóre wspomnienia trwają dłużej niż cząsteczki w synapsach. Jak coś może przetrwać w miejscu, które stale się odnawia?',
            'content' => <<<'HTML'
<p>Strumień fontanny zachowuje kształt, choć woda, którą widzimy, stale się zmienia. Dopóki działa pompa, można ten kształt narysować. Z rysunku niewiele się jednak dowiemy o tym, co go podtrzymuje.</p>
<p>W przypadku pamięci łatwo przeoczyć tę różnicę. Słowo „zapisać” przywodzi na myśl plik, który zamykamy, by później znów go otworzyć. Kiedy się uczymy, w mózgu zmieniają się synapsy, czyli miejsca, w których komórki nerwowe przekazują sobie sygnały. Cząsteczki w synapsach są stale wymieniane. Niektóre wspomnienia trwają mimo to latami. Wyobrażenie zapisu pomaga opisać to, co pozostaje. Zaraz pojawia się pytanie, co musi się dziać, żeby to pozostało.</p>
<p>David Colaço i Philipp Haueis w eseju dla <em>Aeon</em> proponują, by modele umysłu odpowiadały również na to pytanie. Komórka nerwowa potrzebuje energii, by przekazać sygnał i utrzymać warunki, w których może on powstać. Jedna z możliwości omawianych przez autorów jest taka, że synapsa aktywnie utrzymuje określony stan, choć jej cząsteczki się wymieniają. To wyjaśnienie da się badać. Aby wykazać, jak mózg zachowuje konkretne wspomnienie, potrzeba dalszych dowodów.</p>
<p>Energia daje tu miarę, według której można ocenić teorię. Jeśli model wymaga więcej pracy, niż żywa komórka jest w stanie wykonać, trzeba go zmienić. Jeśli praca mieści się w jej możliwościach, warto zbadać, czy rzeczywiście ją wykonuje. Ta sama ostrożność przydaje się przy porównywaniu mózgu z komputerem. Podobny wynik mówi niewiele o tym, co każde z nich musi podtrzymywać, żeby go osiągnąć.</p>
<p>W fontannie najłatwiej zauważyć łuk wody. W przypadku pamięci zauważamy chwilę, w której coś nam się przypomina. Być może najciekawsza praca odbywa się pomiędzy dwiema takimi chwilami, kiedy w ogóle o tym nie myślimy.</p>
HTML
            . "\n<p><small><em>Inspiracja: David Colaço i Philipp Haueis, {$source}, Aeon, 27 listopada 2026 r.</em></small></p>",
        ],
        'hu' => [
            'title' => 'Mi tart egyben egy emléket?',
            'image_alt' => 'Türkizkék víz áramlik egy üveggyűrűben, lila háttér előtt.',
            'excerpt' => 'Néhány emlék tovább él, mint a szinapszisok molekulái. Hogyan maradhat fenn valami ott, ahol a környezete folyton megújul?',
            'content' => <<<'HTML'
<p>A szökőkút vízsugara megtartja az alakját, noha a benne áramló víz folyton cserélődik. Amíg jár a szivattyú, a vízsugár alakja lerajzolható. A rajzból azonban aligha derül ki, mi tartja fenn.</p>
<p>Az emlékezetről gondolkodva könnyű elsiklani e különbség fölött. A „tárolni” szóról egy fájl juthat eszünkbe, amelyet bezárunk, majd később újra megnyitunk. Tanuláskor megváltoznak az agyban a szinapszisok, vagyis azok a helyek, ahol az idegsejtek jeleket adnak át egymásnak. A szinapszisok molekulái folyamatosan cserélődnek. Egyes emlékek mégis évekig megmaradnak. A rögzítés képe segít leírni, mi marad meg. Mindjárt fel is vetődik, minek kell történnie ahhoz, hogy megmaradjon.</p>
<p>David Colaço és Philipp Haueis az <em>Aeon</em> hasábjain megjelent esszéjükben azt javasolják, hogy az elme modelljei erre a kérdésre is adjanak választ. Az idegsejtnek energiára van szüksége a jel továbbításához és azoknak a feltételeknek a fenntartásához, amelyek között a jel létrejöhet. A szerzők által tárgyalt egyik lehetőség az, hogy a szinapszis tevékenyen fenntart egy adott állapotot, miközben a molekulái kicserélődnek. Ez a magyarázat vizsgálható. Annak kimutatásához, hogy az agy hogyan őriz meg egy adott emléket, további bizonyítékokra lenne szükség.</p>
<p>Az energiafelhasználás alapján megítélhetjük, mit engednek meg a sejt adottságai. Ha egy modell több munkát feltételez, mint amennyit egy élő sejt el tud végezni, át kell dolgozni. Ha a sejt képes lehet erre a munkára, érdemes megvizsgálni, hogy valóban elvégzi-e. Ugyanez az óvatosság indokolt az agy és a számítógép összehasonlításakor. A hasonló eredmény keveset árul el arról, hogy közben melyiknek mit kell fenntartania ahhoz, hogy eljusson odáig.</p>
<p>A szökőkútnál a víz íve a legszembetűnőbb. Az emlékezésből azt a pillanatot vesszük észre, amikor valami eszünkbe jut. Talán két ilyen pillanat között zajlik a legérdekesebb munka, amikor az a dolog egyáltalán nem jut eszünkbe.</p>
HTML
            . "\n<p><small><em>Az esszé ihletője: David Colaço és Philipp Haueis, {$source}, Aeon, 2026. november 27.</em></small></p>",
        ],
        'it' => [
            'title' => 'Che cosa tiene insieme un ricordo',
            'image_alt' => 'Acqua turchese scorre in un anello di vetro su uno sfondo viola.',
            'excerpt' => 'Alcuni ricordi durano più delle molecole delle sinapsi. Come può conservarsi qualcosa in un luogo che si rinnova di continuo?',
            'content' => <<<'HTML'
<p>Il getto di una fontana conserva la sua forma anche se l’acqua che vediamo cambia di continuo. Finché la pompa funziona, quella forma si può disegnare. Il disegno ci dice ben poco su che cosa la mantenga.</p>
<p>Quando si parla di memoria, è facile perdere di vista questa distinzione. La parola «salvare» fa pensare a un file che si può chiudere e riaprire in seguito. Quando impariamo, nel cervello cambiano le sinapsi, i punti in cui le cellule nervose si trasmettono segnali. Le loro molecole vengono sostituite di continuo. Eppure alcuni ricordi durano anni. L’idea di una registrazione aiuta a descrivere ciò che rimane. Subito sorge la domanda su che cosa debba accadere perché rimanga.</p>
<p>In un saggio per <em>Aeon</em>, David Colaço e Philipp Haueis propongono che i modelli della mente rispondano anche a questa domanda. Una cellula nervosa ha bisogno di energia per trasmettere un segnale e per mantenere le condizioni in cui il segnale può nascere. Una delle possibilità discusse dagli autori è che una sinapsi mantenga attivamente un determinato stato mentre le sue molecole vengono sostituite. È una spiegazione che si può mettere alla prova. Per stabilire come il cervello conservi un ricordo preciso servirebbero ulteriori prove.</p>
<p>L’energia offre qui un metro con cui valutare la teoria. Se un modello richiede più lavoro di quanto una cellula viva possa svolgere, va rivisto. Se il lavoro è alla portata della cellula, si può studiare se lo svolga davvero. La stessa cautela è utile nel confronto tra il cervello e un computer. Un risultato simile dice poco su ciò che ciascuno deve mantenere in funzione per arrivarci.</p>
<p>In una fontana, la cosa più facile da notare è l’arco dell’acqua. Della memoria ci accorgiamo nell’istante in cui qualcosa ci torna in mente. Forse il lavoro più interessante si svolge tra due istanti del genere, quando non ci pensiamo affatto.</p>
HTML
            . "\n<p><small><em>Fonte d’ispirazione: David Colaço e Philipp Haueis, {$source}, Aeon, 27 novembre 2026.</em></small></p>",
        ],
        'uk' => [
            'title' => 'Що дає спогаду змогу тривати',
            'image_alt' => 'Бірюзова вода тече скляним кільцем на фіолетовому тлі.',
            'excerpt' => 'Деякі спогади живуть довше за молекули в синапсах. Як щось може зберегтися там, де середовище безперервно оновлюється?',
            'content' => <<<'HTML'
<p>Струмінь у фонтані зберігає форму, хоча вода, яку ми бачимо, безперервно змінюється. Поки працює насос, цю форму можна намалювати. Але малюнок мало що скаже про те, завдяки чому вона тримається.</p>
<p>Коли йдеться про пам’ять, цю різницю легко випустити з уваги. Слово «зберегти» нагадує про файл, який можна закрити, а згодом знову відкрити. Під час навчання в мозку змінюються синапси, тобто місця, де нервові клітини передають одна одній сигнали. Молекули в синапсах постійно замінюються. Деякі спогади при цьому зберігаються роками. Уявлення про запис допомагає описати те, що залишається. Відразу постає питання, що має відбуватися, аби воно залишалося.</p>
<p>David Colaço та Philipp Haueis в есеї для <em>Aeon</em> пропонують, щоб моделі розуму відповідали й на це питання. Нервова клітина потребує енергії, щоб передати сигнал і підтримувати умови, за яких він може виникнути. Одна з можливостей, які розглядають автори, полягає в тому, що синапс активно підтримує певний стан, поки його молекули замінюються. Це пояснення можна досліджувати. Щоб з’ясувати, як мозок зберігає конкретний спогад, знадобилися б додаткові докази.</p>
<p>Енергія дає тут змогу оцінити теорію. Якщо модель вимагає більше роботи, ніж здатна виконати жива клітина, її слід переглянути. Якщо клітина здатна виконати цю роботу, варто дослідити, чи вона справді її виконує. Така сама обережність доречна, коли порівнюємо мозок із комп’ютером. Подібний результат мало говорить про те, що кожен із них мусить підтримувати в робочому стані, аби до нього дійти.</p>
<p>У фонтані найлегше помітити дугу води. У випадку пам’яті ми помічаємо мить, коли щось спадає на думку. Можливо, найцікавіша робота відбувається між двома такими митями, коли ми про це взагалі не згадуємо.</p>
HTML
            . "\n<p><small><em>Джерело натхнення: David Colaço та Philipp Haueis, {$source}, Aeon, 27 листопада 2026 року.</em></small></p>",
        ],
    ],
];
