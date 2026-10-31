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
 * Osobná úvaha po zverejnení Metafyziky 2 v knižnici (nedeľa 4. 10. 2026).
 * 23 strán overených v content/library/metafyzika-2/metafyzika-2.pdf.
 * Krátky protokol je citovaný zo sprievodnej eseje prezivanie-je-vychodisko-nie-odpoved.
 */
return [
    'slug' => 'zvedavost-bez-pozicanej-autority',
    'author' => 'MUDr. Ľubomír Polaščín',
    'category' => 'blog',
    'is_top' => 0,
    'published_at' => '2026-10-15 18:48:00',
    'image' => 'images/articles/zvedavost-bez-pozicanej-autority.webp',
    'translations' => [
        'sk' => [
            'title' => 'Zvedavosť bez požičanej autority',
            'image_alt' => 'Muž v tmavom kabáte, videný odzadu, drží v nočnej pracovni čistú sklenenú dosku oproti tyrkysovému svetlu. Na stoličke vedľa neho leží neoblečený biely lekársky plášť a na stole prázdny list.',
            'excerpt' => 'V nedeľu 4. októbra 2026 som v knižnici zverejnil Metafyziku 2, 23 strán o vedomí, identite, čase, slobodnej vôli a dôveryhodnosti duchovného poznania. Lekársky titul z toho nerobí autoritu o povahe skutočnosti. Do práce si nesiem otázku, aký dôkaz by mi zmenil záver, ktorý práve mám.',
            'content' => <<<'HTML'
<p>V nedeľu 4. októbra 2026 som do <a href="library.php?slug=metafyzika-2">knižnice</a> vložil Metafyziku 2, druhý diel nedeľnej metafyziky. Má 23 strán. Drží sa vedomia, osobnej identity, času, slobodnej vôle a dôveryhodnosti duchovného poznania. V ten istý deň vyšla sprievodná esej <a href="article.php?slug=prezivanie-je-vychodisko-nie-odpoved">Prežívanie je východisko, nie odpoveď</a>.</p>
<p>Lekársky titul z toho nerobí autoritu o povahe skutočnosti.</p>
<p>Najviac mi z dielu ostala disciplína, ako narábať s tvrdeniami.</p>
<p>Silný zážitok je skutočný ako zážitok. Výklad, ktorý sa k nemu pripojí, je už iná otázka.</p>
<p>V sprievodnej eseji je postup krátky. Opíš zážitok. Pomenuj výklad. Uveď alternatívy. Zapíš dôvody za aj proti. Urči, čo by presvedčenie zmenilo.</p>
<p>Ten posledný krok drží celý postup. Bez neho sa skúmanie potichu zmení na obranu toho, čomu už veríme.</p>
<p>Myslím si, že tá istá disciplína patrí aj do práce. Presvedčivá odpoveď umelej inteligencie, úhľadný príbeh produktu aj ukazovateľ, ktorý povzbudí, vedia pôsobiť ako pochopenie skôr, než výklad overíme.</p>
<p>Zvedavosť z toho nechcem vyňať. Chcem, aby sa nezlievala s istotou.</p>
<p>Otázka, ktorú si z tej nedele nesiem do práce: aký dôkaz by ma primäl prehodnotiť záver, ktorý práve mám?</p>
<p><em>Osobná úvaha o druhom diele nedeľnej metafyziky zo 4. októbra 2026. Nie je to lekárska rada. Lekársky titul v nej nerozhoduje otázky o povahe skutočnosti.</em></p>
HTML,
        ],
        'en' => [
            'title' => 'Curiosity without borrowed authority',
            'image_alt' => 'A man in a dark coat, seen from behind, holds a blank pane of glass in a night study toward a teal light. An unworn white medical coat lies on the chair beside him, and a blank sheet rests on the desk.',
            'excerpt' => 'On Sunday, 4 October 2026, I published Metafyzika 2 in the library: 23 pages on consciousness, identity, time, free will and the credibility of spiritual knowledge. A medical title does not make that an authority on the nature of reality. I carry into the work one question: what evidence would make me revise the conclusion I currently hold?',
            'content' => <<<'HTML'
<p>On Sunday, 4 October 2026, I placed <a href="library.php?slug=metafyzika-2">Metafyzika 2</a> in the library, the second volume of Sunday metaphysics. It runs to 23 pages. It stays with consciousness, personal identity, time, free will and the credibility of spiritual knowledge. The same day the companion essay <a href="article.php?slug=prezivanie-je-vychodisko-nie-odpoved">Experience is a starting point, not an answer</a> was published.</p>
<p>A medical title does not make that an authority on the nature of reality.</p>
<p>What stayed with me from the volume was a discipline for handling claims.</p>
<p>A powerful experience is real as an experience. The interpretation attached to it is a separate question.</p>
<p>In the companion essay the protocol is short. Describe the experience. Name the interpretation. State the alternatives. Write the reasons for and against. Decide what would change the belief.</p>
<p>That last step holds the whole procedure. Without it, an inquiry quietly becomes a defence of whatever we already believe.</p>
<p>I think the same discipline belongs in the work as well. A convincing answer from artificial intelligence, an elegant story told about a product, and an encouraging metric can feel like understanding before the explanation has been tested.</p>
<p>I do not want curiosity taken out of that. I want it kept from becoming the same thing as certainty.</p>
<p>The question I carry from that Sunday into the work: what evidence would make me revise the conclusion I currently hold?</p>
<p><em>A personal reflection on the second volume of Sunday metaphysics, dated 4 October 2026. It is not medical advice. A medical title does not settle questions about the nature of reality.</em></p>
HTML,
        ],
        'cs' => [
            'title' => 'Zvědavost bez vypůjčené autority',
            'image_alt' => 'Muž v tmavém kabátě, viděný zezadu, drží v noční pracovně čistou skleněnou desku proti tyrkysovému světlu. Na židli vedle něj leží neoblečený bílý lékařský plášť a na stole prázdný list.',
            'excerpt' => 'V neděli 4. října 2026 jsem v knihovně zveřejnil Metafyziku 2, 23 stran o vědomí, identitě, čase, svobodné vůli a důvěryhodnosti duchovního poznání. Lékařský titul z toho nedělá autoritu o povaze skutečnosti. Do práce si nesu otázku, jaký důkaz by mi změnil závěr, který právě mám.',
            'content' => <<<'HTML'
<p>V neděli 4. října 2026 jsem do <a href="library.php?slug=metafyzika-2">knihovny</a> vložil Metafyziku 2, druhý díl nedělní metafyziky. Má 23 stran. Drží se vědomí, osobní identity, času, svobodné vůle a důvěryhodnosti duchovního poznání. Týž den vyšla doprovodná esej <a href="article.php?slug=prezivanie-je-vychodisko-nie-odpoved">Prožívání je východisko, ne odpověď</a>.</p>
<p>Lékařský titul z toho nedělá autoritu o povaze skutečnosti.</p>
<p>Nejvíc mi z dílu zůstala disciplína, jak zacházet s tvrzeními.</p>
<p>Silný zážitek je skutečný jako zážitek. Výklad, který se k němu připojí, je už jiná otázka.</p>
<p>V doprovodné eseji je postup krátký. Popiš zážitek. Pojmenuj výklad. Uveď alternativy. Zapiš důvody pro i proti. Urči, co by přesvědčení změnilo.</p>
<p>Ten poslední krok drží celý postup. Bez něj se zkoumání potichu změní v obranu toho, čemu už věříme.</p>
<p>Myslím si, že táž disciplína patří i do práce. Přesvědčivá odpověď umělé inteligence, úhledný příběh produktu i ukazatel, který povzbudí, dokážou působit jako pochopení dřív, než výklad ověříme.</p>
<p>Zvědavost z toho nechci vyjmout. Chci, aby nesplývala s jistotou.</p>
<p>Otázka, kterou si z té neděle nesu do práce: jaký důkaz by mě přiměl přehodnotit závěr, který právě mám?</p>
<p><em>Osobní úvaha o druhém dílu nedělní metafyziky ze 4. října 2026. Není to lékařská rada. Lékařský titul v ní nerozhoduje otázky o povaze skutečnosti.</em></p>
HTML,
        ],
        'de' => [
            'title' => 'Neugier ohne geliehene Autorität',
            'image_alt' => 'Ein Mann im dunklen Mantel, von hinten gesehen, hält in einem nächtlichen Arbeitszimmer eine leere Glasscheibe gegen türkisfarbenes Licht. Auf dem Stuhl daneben liegt ein ungetragener weißer Arztkittel, auf dem Tisch ein leeres Blatt.',
            'excerpt' => 'Am Sonntag, dem 4. Oktober 2026, habe ich Metafyzika 2 in der Bibliothek veröffentlicht: 23 Seiten über Bewusstsein, Identität, Zeit, freien Willen und die Glaubwürdigkeit geistiger Erkenntnis. Ein ärztlicher Titel macht daraus keine Autorität über die Natur der Wirklichkeit. In die Arbeit nehme ich die Frage mit, welcher Beleg den Schluss ändern würde, den ich gerade halte.',
            'content' => <<<'HTML'
<p>Am Sonntag, dem 4. Oktober 2026, habe ich <a href="library.php?slug=metafyzika-2">Metafyzika 2</a> in die Bibliothek gelegt, den zweiten Band der Sonntagsmetaphysik. Er umfasst 23 Seiten. Er bleibt bei Bewusstsein, persönlicher Identität, Zeit, freiem Willen und der Glaubwürdigkeit geistiger Erkenntnis. Am selben Tag erschien der Begleitessay <a href="article.php?slug=prezivanie-je-vychodisko-nie-odpoved">Erleben ist ein Ausgangspunkt, keine Antwort</a>.</p>
<p>Ein ärztlicher Titel macht daraus keine Autorität über die Natur der Wirklichkeit.</p>
<p>Aus dem Band ist mir eine Disziplin im Umgang mit Behauptungen geblieben.</p>
<p>Ein starkes Erlebnis ist als Erlebnis wirklich. Die Deutung, die sich daran heftet, ist eine eigene Frage.</p>
<p>Im Begleitessay ist das Vorgehen kurz. Beschreiben Sie das Erlebnis. Benennen Sie die Deutung. Nennen Sie die Alternativen. Schreiben Sie die Gründe dafür und dagegen. Entscheiden Sie, was die Überzeugung ändern würde.</p>
<p>Dieser letzte Schritt trägt das ganze Vorgehen. Ohne ihn wird eine Untersuchung still zur Verteidigung dessen, was wir schon glauben.</p>
<p>Ich halte dafür, dass dieselbe Disziplin auch in die Arbeit gehört. Eine überzeugende Antwort der künstlichen Intelligenz, eine gefällige Produktgeschichte und eine Kennzahl, die ermutigt, können sich wie Verständnis anfühlen, bevor die Erklärung geprüft ist.</p>
<p>Die Neugier will ich daraus nicht nehmen. Sie soll nicht mit Gewissheit zusammenfallen.</p>
<p>Die Frage, die ich von jenem Sonntag in die Arbeit mitnehme: Welcher Beleg würde mich dazu bringen, den Schluss zu revidieren, den ich gerade halte?</p>
<p><em>Eine persönliche Überlegung zum zweiten Band der Sonntagsmetaphysik vom 4. Oktober 2026. Kein ärztlicher Rat. Ein ärztlicher Titel entscheidet darin keine Fragen über die Natur der Wirklichkeit.</em></p>
HTML,
        ],
        'fr' => [
            'title' => 'Curiosité sans autorité empruntée',
            'image_alt' => 'Un homme en manteau sombre, vu de dos, tient dans un cabinet de nuit une vitre vierge face à une lumière turquoise. Sur la chaise à côté de lui repose une blouse blanche de médecin non portée, et sur la table une feuille blanche.',
            'excerpt' => 'Le dimanche 4 octobre 2026, j’ai publié Metafyzika 2 dans la bibliothèque : 23 pages sur la conscience, l’identité, le temps, le libre arbitre et la crédibilité de la connaissance spirituelle. Un titre de médecin n’en fait pas une autorité sur la nature du réel. J’emporte dans le travail une question : quelle preuve me ferait réviser la conclusion que je tiens en ce moment ?',
            'content' => <<<'HTML'
<p>Le dimanche 4 octobre 2026, j’ai déposé dans la <a href="library.php?slug=metafyzika-2">bibliothèque</a> Metafyzika 2, le deuxième volume de la métaphysique du dimanche. Il compte 23 pages. Il reste sur la conscience, l’identité personnelle, le temps, le libre arbitre et la crédibilité de la connaissance spirituelle. Le même jour a paru l’essai compagnon <a href="article.php?slug=prezivanie-je-vychodisko-nie-odpoved">Le vécu est un point de départ, pas une réponse</a>.</p>
<p>Un titre de médecin n’en fait pas une autorité sur la nature du réel.</p>
<p>Ce qui m’est resté du volume, c’est une discipline pour traiter les affirmations.</p>
<p>Une expérience forte est réelle en tant qu’expérience. L’interprétation qui s’y attache est une autre question.</p>
<p>Dans l’essai compagnon, le protocole est court. Décrivez l’expérience. Nommez l’interprétation. Énoncez les alternatives. Écrivez les raisons pour et contre. Décidez ce qui changerait la croyance.</p>
<p>Ce dernier pas porte tout le protocole. Sans lui, une enquête se change, sans qu’on s’en aperçoive, en défense de ce que l’on croit déjà.</p>
<p>Je pense que la même discipline a sa place dans le travail. Une réponse convaincante de l’intelligence artificielle, un récit soigné sur un produit et un indicateur qui encourage peuvent donner le sentiment de comprendre avant que l’explication ait été éprouvée.</p>
<p>Je ne cherche pas à en retirer la curiosité. Je veux qu’elle ne se confonde pas avec la certitude.</p>
<p>La question que j’emporte de ce dimanche dans le travail : quelle preuve me ferait réviser la conclusion que je tiens en ce moment ?</p>
<p><em>Réflexion personnelle sur le deuxième volume de la métaphysique du dimanche, daté du 4 octobre 2026. Ce n’est pas un avis médical. Un titre de médecin n’y tranche pas les questions sur la nature du réel.</em></p>
HTML,
        ],
        'es' => [
            'title' => 'Curiosidad sin autoridad prestada',
            'image_alt' => 'Un hombre con abrigo oscuro, visto de espaldas, sostiene en un estudio nocturno un cristal limpio frente a una luz turquesa. En la silla junto a él hay una bata blanca de médico sin poner, y sobre la mesa una hoja en blanco.',
            'excerpt' => 'El domingo 4 de octubre de 2026 publiqué Metafyzika 2 en la biblioteca: 23 páginas sobre la conciencia, la identidad, el tiempo, el libre albedrío y la credibilidad del conocimiento espiritual. Un título médico no convierte eso en autoridad sobre la naturaleza de la realidad. Me llevo al trabajo una pregunta: ¿qué prueba me haría revisar la conclusión que sostengo ahora?',
            'content' => <<<'HTML'
<p>El domingo 4 de octubre de 2026 dejé en la <a href="library.php?slug=metafyzika-2">biblioteca</a> Metafyzika 2, el segundo volumen de la metafísica del domingo. Tiene 23 páginas. Se queda en la conciencia, la identidad personal, el tiempo, el libre albedrío y la credibilidad del conocimiento espiritual. Ese mismo día apareció el ensayo compañero <a href="article.php?slug=prezivanie-je-vychodisko-nie-odpoved">La experiencia vivida es un punto de partida, no una respuesta</a>.</p>
<p>Un título médico no convierte eso en una autoridad sobre la naturaleza de la realidad.</p>
<p>Lo que me quedó del volumen fue una disciplina para tratar las afirmaciones.</p>
<p>Una experiencia intensa es real como experiencia. La interpretación que se le añade es ya otra pregunta.</p>
<p>En el ensayo compañero el procedimiento es breve. Describa la experiencia. Nombre la interpretación. Enuncie las alternativas. Escriba las razones a favor y en contra. Decida qué cambiaría la creencia.</p>
<p>Ese último paso sostiene todo el procedimiento. Sin él, la indagación se convierte, sin que se note, en una defensa de lo que ya creemos.</p>
<p>Creo que la misma disciplina pertenece también al trabajo. Una respuesta convincente de la inteligencia artificial, un relato pulido de un producto y un indicador que anima pueden sentirse como comprensión antes de que hayamos puesto a prueba la explicación.</p>
<p>No quiero sacar de ahí la curiosidad. Quiero que no se confunda con la certeza.</p>
<p>La pregunta que me llevo de aquel domingo al trabajo: ¿qué prueba me haría revisar la conclusión que sostengo ahora?</p>
<p><em>Reflexión personal sobre el segundo volumen de la metafísica del domingo, del 4 de octubre de 2026. No es un consejo médico. Un título médico no resuelve en ella las preguntas sobre la naturaleza de la realidad.</em></p>
HTML,
        ],
        'pl' => [
            'title' => 'Ciekawość bez pożyczonego autorytetu',
            'image_alt' => 'Mężczyzna w ciemnym płaszczu, widziany od tyłu, trzyma w nocnym gabinecie czystą szybę naprzeciw turkusowego światła. Na krześle obok leży nienoszony biały fartuch lekarski, a na stole pusta kartka.',
            'excerpt' => 'W niedzielę 4 października 2026 roku opublikowałem w bibliotece Metafyzika 2: 23 strony o świadomości, tożsamości, czasie, wolnej woli i wiarygodności poznania duchowego. Tytuł lekarski nie czyni z tego autorytetu w sprawie natury rzeczywistości. Do pracy zabieram pytanie, jaki dowód kazałby mi zrewidować wniosek, który właśnie trzymam.',
            'content' => <<<'HTML'
<p>W niedzielę 4 października 2026 roku umieściłem w <a href="library.php?slug=metafyzika-2">bibliotece</a> Metafyzika 2, drugi tom metafizyki niedzielnej. Liczy 23 strony. Zostaje przy świadomości, tożsamości osobowej, czasie, wolnej woli i wiarygodności poznania duchowego. Tego samego dnia ukazał się esej towarzyszący <a href="article.php?slug=prezivanie-je-vychodisko-nie-odpoved">Przeżywanie jest punktem wyjścia, nie odpowiedzią</a>.</p>
<p>Tytuł lekarski nie czyni z tego autorytetu w sprawie natury rzeczywistości.</p>
<p>Z tomu została mi dyscyplina obchodzenia się z twierdzeniami.</p>
<p>Silne przeżycie jest rzeczywiste jako przeżycie. Interpretacja, która się do niego przyłącza, to już inne pytanie.</p>
<p>W eseju towarzyszącym procedura jest krótka. Opiszcie doświadczenie. Nazwijcie interpretację. Podajcie alternatywy. Zapiszcie racje za i przeciw. Ustalcie, co zmieniłoby przekonanie.</p>
<p>Ten ostatni krok trzyma całą procedurę. Bez niego badanie po cichu staje się obroną tego, w co już wierzymy.</p>
<p>Sądzę, że ta sama dyscyplina należy też do pracy. Przekonująca odpowiedź sztucznej inteligencji, zgrabna opowieść o produkcie i wskaźnik, który dodaje otuchy, potrafią sprawiać wrażenie zrozumienia, zanim sprawdzimy wyjaśnienie.</p>
<p>Nie chcę z tego usuwać ciekawości. Chcę, żeby nie zlewała się z pewnością.</p>
<p>Pytanie, które z tamtej niedzieli zabieram do pracy: jaki dowód kazałby mi zrewidować wniosek, który właśnie trzymam?</p>
<p><em>Osobista refleksja o drugim tomie metafizyki niedzielnej z 4 października 2026 roku. To nie jest porada lekarska. Tytuł lekarski nie rozstrzyga w niej pytań o naturę rzeczywistości.</em></p>
HTML,
        ],
        'hu' => [
            'title' => 'Kíváncsiság kölcsönzött tekintély nélkül',
            'image_alt' => 'Egy sötét kabátos férfi hátulról tiszta üveglapot tart egy éjszakai dolgozószobában a türkiz fény felé. A melletti széken viseltlen fehér orvosi köpeny fekszik, az asztalon üres lap.',
            'excerpt' => '2026. október 4-én, vasárnap közzétettem a könyvtárban a Metafyzika 2-t: 23 oldal a tudatról, az azonosságról, az időről, a szabad akaratról és a szellemi megismerés hitelességéről. Az orvosi cím ettől nem lesz tekintély a valóság természetének kérdésében. A munkába ezt a kérdést viszem: milyen bizonyíték venne rá, hogy felülvizsgáljam a következtetést, amelyet éppen tartok.',
            'content' => <<<'HTML'
<p>2026. október 4-én, vasárnap beletettem a <a href="library.php?slug=metafyzika-2">könyvtárba</a> a Metafyzika 2-t, a vasárnapi metafizika második kötetét. 23 oldal. A tudatnál, a személyes azonosságnál, az időnél, a szabad akaratnál és a szellemi megismerés hitelességénél marad. Ugyanaznap jelent meg a kísérő esszé: <a href="article.php?slug=prezivanie-je-vychodisko-nie-odpoved">A megélés kiindulópont, nem válasz</a>.</p>
<p>Az orvosi cím ettől nem lesz tekintély a valóság természetének kérdésében.</p>
<p>A kötetből egy fegyelem maradt meg: hogyan bánjak az állításokkal.</p>
<p>Az erős élmény élményként valós. Az értelmezés, amely hozzákapcsolódik, már másik kérdés.</p>
<p>A kísérő esszében az eljárás rövid. Írja le a tapasztalatot. Nevezze meg az értelmezést. Mondja ki az alternatívákat. Írja le a mellette és ellene szóló indokokat. Döntse el, mi változtatná meg a meggyőződést.</p>
<p>Az utolsó lépés tartja az egész eljárást. Nélküle a vizsgálat csendben annak a védelmévé válik, amit már hiszünk.</p>
<p>Úgy gondolom, ugyanez a fegyelem a munkába is beletartozik. A mesterséges intelligencia meggyőző válasza, egy termék csiszolt története és egy biztató mutató megértésnek tűnhet, mielőtt az értelmezést ellenőriztük.</p>
<p>A kíváncsiságot nem akarom kivenni belőle. Azt akarom, hogy ne essen egybe a bizonyossággal.</p>
<p>A kérdés, amelyet attól a vasárnaptól a munkába viszek: milyen bizonyíték venne rá, hogy felülvizsgáljam a következtetést, amelyet éppen tartok?</p>
<p><em>Személyes megfontolás a vasárnapi metafizika 2026. október 4-i második kötetéről. Nem orvosi tanács. Az orvosi cím nem dönti el benne a valóság természetére vonatkozó kérdéseket.</em></p>
HTML,
        ],
        'it' => [
            'title' => 'Curiosità senza autorità in prestito',
            'image_alt' => 'Un uomo in cappotto scuro, visto di spalle, tiene in uno studio notturno una lastra di vetro pulita contro una luce turchese. Sulla sedia accanto a lui è posato un camice bianco da medico non indossato, e sul tavolo un foglio bianco.',
            'excerpt' => 'Domenica 4 ottobre 2026 ho pubblicato nella biblioteca Metafyzika 2: 23 pagine su coscienza, identità, tempo, libero arbitrio e credibilità della conoscenza spirituale. Un titolo di medico non ne fa un’autorità sulla natura della realtà. Porto nel lavoro una domanda: quale prova mi farebbe rivedere la conclusione che tengo adesso?',
            'content' => <<<'HTML'
<p>Domenica 4 ottobre 2026 ho messo nella <a href="library.php?slug=metafyzika-2">biblioteca</a> Metafyzika 2, il secondo volume della metafisica della domenica. Conta 23 pagine. Resta sulla coscienza, l’identità personale, il tempo, il libero arbitrio e la credibilità della conoscenza spirituale. Lo stesso giorno è uscito il saggio di accompagnamento <a href="article.php?slug=prezivanie-je-vychodisko-nie-odpoved">Il vissuto è un punto di partenza, non una risposta</a>.</p>
<p>Un titolo di medico non ne fa un’autorità sulla natura della realtà.</p>
<p>Dal volume mi è rimasta una disciplina nel trattare le affermazioni.</p>
<p>Un’esperienza forte è reale in quanto esperienza. L’interpretazione che vi si attacca è un’altra domanda.</p>
<p>Nel saggio di accompagnamento il procedimento è breve. Descrivete l’esperienza. Nominate l’interpretazione. Dichiarate le alternative. Scrivete le ragioni a favore e contro. Decidete che cosa cambierebbe la credenza.</p>
<p>Quest’ultimo passo regge l’intero procedimento. Senza di esso, un’indagine diventa, senza che ce ne accorgiamo, la difesa di ciò che già crediamo.</p>
<p>Penso che la stessa disciplina appartenga anche al lavoro. Una risposta convincente dell’intelligenza artificiale, un racconto nitido di un prodotto e un indicatore che incoraggia possono sembrare comprensione prima che la spiegazione sia stata messa alla prova.</p>
<p>Non voglio toglierne la curiosità. Voglio che non coincida con la certezza.</p>
<p>La domanda che porto da quella domenica nel lavoro: quale prova mi farebbe rivedere la conclusione che tengo adesso?</p>
<p><em>Riflessione personale sul secondo volume della metafisica della domenica, del 4 ottobre 2026. Non è un consiglio medico. Un titolo di medico non decide, in essa, le domande sulla natura della realtà.</em></p>
HTML,
        ],
        'uk' => [
            'title' => 'Цікавість без позиченого авторитету',
            'image_alt' => 'Чоловік у темному пальті, ззаду, тримає в нічному кабінеті чисте скло навпроти бірюзового світла. На стільці поруч лежить неношений білий лікарський халат, а на столі чистий аркуш.',
            'excerpt' => 'У неділю 4 жовтня 2026 року я оприлюднив у бібліотеці Metafyzika 2: 23 сторінки про свідомість, тотожність, час, вільну волю і достовірність духовного пізнання. Медичний титул не робить із цього авторитету щодо природи дійсності. У роботу я несу питання, який доказ змусив би мене переглянути висновок, якого я зараз тримаюся.',
            'content' => <<<'HTML'
<p>У неділю 4 жовтня 2026 року я поклав до <a href="library.php?slug=metafyzika-2">бібліотеки</a> Metafyzika 2, другий том недільної метафізики. У ньому 23 сторінки. Він лишається при свідомості, особистій тотожності, часі, вільній волі і достовірності духовного пізнання. Того самого дня вийшло супровідне есе <a href="article.php?slug=prezivanie-je-vychodisko-nie-odpoved">Переживання є вихідною точкою, а не відповіддю</a>.</p>
<p>Медичний титул не робить із цього авторитету щодо природи дійсності.</p>
<p>З тому мені лишилася дисципліна поводження з твердженнями.</p>
<p>Сильне переживання є дійсним як переживання. Тлумачення, яке до нього долучається, є вже іншим питанням.</p>
<p>У супровідному есе процедура коротка. Опишіть досвід. Назвіть тлумачення. Сформулюйте альтернативи. Запишіть підстави за і проти. Вирішіть, що змінило б переконання.</p>
<p>Цей останній крок тримає всю процедуру. Без нього дослідження тихо стає захистом того, у що ми вже віримо.</p>
<p>Гадаю, та сама дисципліна належить і до роботи. Переконлива відповідь штучного інтелекту, охайна розповідь про продукт і показник, який підбадьорює, можуть здаватися розумінням ще до того, як ми перевіримо пояснення.</p>
<p>Цікавість я з цього не хочу виймати. Хочу, щоб вона не зливалася з певністю.</p>
<p>Питання, яке з тієї неділі несу в роботу: який доказ змусив би мене переглянути висновок, якого я зараз тримаюся?</p>
<p><em>Особистий роздум про другий том недільної метафізики від 4 жовтня 2026 року. Це не лікарська порада. Медичний титул не розв’язує в ньому питань про природу дійсності.</em></p>
HTML,
        ],
    ],
];
