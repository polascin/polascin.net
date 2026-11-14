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
 * Podpis ešte nie je vydanie.
 * 10. 11. 2026: nevýhradná dohoda o distribúcii elektronického vydania
 * trilera Marža z krvi; odovzdanie súborov a faktúra.
 * 11. 11. 2026 ráno: súhlas s odovzdaním predajcom za 9,98 EUR.
 * Potvrdený výpis u predajcov ešte nie je. Firma a kontakt sú fiktívne
 * náhrady (Ekvora Digital, Mgr. Adam Vránský). Bez textGrain.
 */
return [
    'slug' => 'podpis-este-nie-je-vydanie',
    'author' => 'MUDr. Ľubomír Polaščín',
    'category' => 'blog',
    'is_top' => 0,
    'published_at' => '2026-11-14 13:30:00',
    'image' => 'images/articles/podpis-este-nie-je-vydanie.webp',
    'translations' => [
        'sk' => [
            'title' => 'Podpis ešte nie je vydanie',
            'image_alt' => 'Na fialovom stole tyrkysové pero dokončuje podpis na pergamene; vedľa leží tableta s e-knihou a v diaľke jemne svieti zatvorený výklad predajne.',
            'excerpt' => 'Desiateho novembra som podpísal nevýhradnú dohodu o distribúcii elektronického vydania Marže z krvi. Súbory odišli, faktúra prišla, odovzdanie predajcom som schválil. Potvrdený výpis v ich katalógu ešte nemám.',
            'content' => <<<'HTML'
<p>Desiateho novembra 2026 som podpísal nevýhradnú dohodu o distribúcii nového elektronického vydania slovenského trilera Marža z krvi.</p>
<p>Vydavateľstvo Ekvora Digital dostalo súbory a vystavilo faktúru. Ráno jedenásteho novembra som schválil navrhované odovzdanie predajcom za odporúčanú cenu 9,98&nbsp;eur.</p>
<p>To sú skutočné míľniky. Potvrdený výpis u predajcu je iný míľnik a ten ešte nemám.</p>
<p>Práca na tomto kroku ma prinútila precíznejšie používať slovo „hotové“.</p>
<p>Rukopis je dopísaný. Súbory sú pripravené. Dohoda je podpísaná. Podklady sú prijaté. Distribúcia je autorizovaná. Kniha sa dá kúpiť.</p>
<p>Každý riadok opisuje iný stav. Žiadny sám osebe nedokazuje, že nastal ten nasledujúci.</p>
<p>Nevýhradnosť dohody tiež váži. Podpisom som neodovzdal tlačové práva ani neopustil už existujúce vydania.</p>
<p>Ako autor by som rád uzatvoril príbeh jedným uspokojivým „vyšlo“.</p>
<p>Ako človek, ktorý stavia aj softvér, poznám medzeru medzi odovzdanou prácou a overeným výsledkom.</p>
<p>Presná správa je zatiaľ táto: dohoda je podpísaná, súbory sú doručené a distribúcia predajcom je autorizovaná.</p>
<p>Míľnik stojí za zdieľanie aj bez toho, aby som ho vydával za cieľovú čiaru.</p>
<p><em>Osobná skúsenosť z prípravy distribúcie. Nie je to obchodná ani právna rada. Názov vydavateľstva a meno kontaktu sú fiktívne náhrady.</em></p>
HTML,
        ],
        'en' => [
            'title' => 'A signature is not yet a launch',
            'image_alt' => 'On a violet desk a teal pen finishes a signature on parchment; beside it an ebook tablet, and in the distance a softly lit closed shop window.',
            'excerpt' => 'On 10 November I signed a non-exclusive distribution agreement for the electronic edition of Marža z krvi. Files went out, an invoice arrived, and I approved the retailer handover. I still do not have a confirmed listing.',
            'content' => <<<'HTML'
<p>On 10 November 2026 I signed a non-exclusive distribution agreement for a new electronic edition of the Slovak thriller Marža z krvi.</p>
<p>The publisher Ekvora Digital received the files and issued an invoice. On the morning of 11 November I approved the proposed retailer handover at a recommended price of EUR&nbsp;9.98.</p>
<p>Those are real milestones. A confirmed retailer listing is a different milestone, and I do not have that confirmation yet.</p>
<p>Working through this step has made me more precise about the word “done.”</p>
<p>Manuscript finished. Files prepared. Agreement signed. Materials received. Distribution authorized. Book available to buy.</p>
<p>Each line describes a different state. None by itself proves that the next one has happened.</p>
<p>The non-exclusive arrangement also matters. By signing I did not hand over my print rights or abandon editions that already exist.</p>
<p>As an author I would love the story to end with one satisfying “published.”</p>
<p>As someone who also builds software, I recognise the familiar gap between a completed handoff and a verified result.</p>
<p>For now the accurate update is this: the agreement is signed, the files are delivered, and retailer distribution is authorized.</p>
<p>A milestone is worth sharing without pretending it is the finish line.</p>
<p><em>Personal experience from preparing distribution. Not commercial or legal advice. The publisher name and contact name are fictional substitutes.</em></p>
HTML,
        ],
        'cs' => [
            'title' => 'Podpis ještě není vydání',
            'image_alt' => 'Na fialovém stole tyrkysové pero dokončuje podpis na pergamenu; vedle leží tablet s e-knihou a v dálce jemně svítí zavřená výloha prodejny.',
            'excerpt' => 'Desátého listopadu jsem podepsal nevýhradní dohodu o distribuci elektronického vydání Marže z krvi. Soubory odešly, faktura přišla, předání prodejcům jsem schválil. Potvrzený výpis v jejich katalogu ještě nemám.',
            'content' => <<<'HTML'
<p>Desátého listopadu 2026 jsem podepsal nevýhradní dohodu o distribuci nového elektronického vydání slovenského thrilleru Marža z krvi.</p>
<p>Nakladatelství Ekvora Digital dostalo soubory a vystavilo fakturu. Ráno jedenáctého listopadu jsem schválil navrhované předání prodejcům za doporučenou cenu 9,98&nbsp;eur.</p>
<p>To jsou skutečné milníky. Potvrzený výpis u prodejce je jiný milník a ten ještě nemám.</p>
<p>Práce na tomto kroku mě přiměla přesněji používat slovo „hotové“.</p>
<p>Rukopis je dopsaný. Soubory jsou připravené. Dohoda je podepsaná. Podklady jsou přijaté. Distribuce je autorizovaná. Knihu lze koupit.</p>
<p>Každý řádek popisuje jiný stav. Žádný sám o sobě nedokazuje, že nastal ten následující.</p>
<p>Nevýhradnost dohody také váží. Podpisem jsem neodevzdal tisková práva ani neopustil už existující vydání.</p>
<p>Jako autor bych rád uzavřel příběh jedním uspokojivým „vyšlo“.</p>
<p>Jako člověk, který staví i software, znám mezeru mezi odevzdanou prací a ověřeným výsledkem.</p>
<p>Přesná zpráva je zatím tato: dohoda je podepsaná, soubory jsou doručené a distribuce prodejcům je autorizovaná.</p>
<p>Milník stojí za sdílení i bez toho, abych ho vydával za cílovou čáru.</p>
<p><em>Osobní zkušenost z přípravy distribuce. Není to obchodní ani právní rada. Název nakladatelství a jméno kontaktu jsou fiktivní náhrady.</em></p>
HTML,
        ],
        'de' => [
            'title' => 'Eine Unterschrift ist noch keine Veröffentlichung',
            'image_alt' => 'Auf einem violetten Tisch vollendet ein türkiser Stift eine Unterschrift auf Pergament; daneben ein E-Book-Tablet, in der Ferne ein sanft erleuchtetes geschlossenes Schaufenster.',
            'excerpt' => 'Am 10. November unterzeichnete ich eine nicht ausschließliche Vertriebsvereinbarung für die elektronische Ausgabe von Marža z krvi. Dateien gingen raus, eine Rechnung kam, die Übergabe an Händler genehmigte ich. Eine bestätigte Listung fehlt noch.',
            'content' => <<<'HTML'
<p>Am 10. November 2026 habe ich eine nicht ausschließliche Vertriebsvereinbarung für eine neue elektronische Ausgabe des slowakischen Thrillers Marža z krvi unterzeichnet.</p>
<p>Der Verlag Ekvora Digital erhielt die Dateien und stellte eine Rechnung aus. Am Morgen des 11. November genehmigte ich die vorgeschlagene Übergabe an den Handel zum empfohlenen Preis von 9,98&nbsp;Euro.</p>
<p>Das sind echte Meilensteine. Eine bestätigte Listung beim Händler ist ein anderer Meilenstein, und den habe ich noch nicht.</p>
<p>Diese Arbeit hat mich dazu gebracht, das Wort „fertig“ genauer zu verwenden.</p>
<p>Manuskript abgeschlossen. Dateien vorbereitet. Vereinbarung unterzeichnet. Unterlagen angenommen. Vertrieb autorisiert. Buch käuflich.</p>
<p>Jede Zeile beschreibt einen anderen Zustand. Keine beweist für sich, dass der nächste eingetreten ist.</p>
<p>Auch die Nichtausschließlichkeit zählt. Mit der Unterschrift habe ich weder Druckrechte abgegeben noch bestehende Ausgaben aufgegeben.</p>
<p>Als Autor würde ich die Geschichte gern mit einem befriedigenden „erschienen“ schließen.</p>
<p>Als jemand, der auch Software baut, kenne ich die Lücke zwischen abgeschlossener Übergabe und verifiziertem Ergebnis.</p>
<p>Die genaue Mitteilung lautet vorerst: die Vereinbarung ist unterzeichnet, die Dateien sind geliefert, und der Vertrieb an Händler ist autorisiert.</p>
<p>Ein Meilenstein verdient das Teilen, ohne ihn als Ziellinie auszugeben.</p>
<p><em>Persönliche Erfahrung aus der Vorbereitung des Vertriebs. Keine geschäftliche oder rechtliche Beratung. Verlagsname und Kontaktname sind fiktive Ersatzangaben.</em></p>
HTML,
        ],
        'fr' => [
            'title' => 'Une signature n’est pas encore une parution',
            'image_alt' => 'Sur un bureau violet, un stylo turquoise achève une signature sur parchemin ; à côté une tablette e-book, et au loin une vitrine fermée doucement éclairée.',
            'excerpt' => 'Le 10 novembre j’ai signé un accord de distribution non exclusive pour l’édition électronique de Marža z krvi. Les fichiers sont partis, la facture est arrivée, j’ai approuvé la remise aux détaillants. Je n’ai pas encore de listing confirmé.',
            'content' => <<<'HTML'
<p>Le 10 novembre 2026, j’ai signé un accord de distribution non exclusive pour une nouvelle édition électronique du thriller slovaque Marža z krvi.</p>
<p>L’éditeur Ekvora Digital a reçu les fichiers et émis une facture. Le matin du 11 novembre, j’ai approuvé la remise proposée aux détaillants au prix recommandé de 9,98&nbsp;euros.</p>
<p>Ce sont de vrais jalons. Un listing confirmé chez un détaillant en est un autre, et je ne l’ai pas encore.</p>
<p>Ce travail m’a obligé à employer le mot « terminé » avec plus de précision.</p>
<p>Manuscrit achevé. Fichiers préparés. Accord signé. Documents reçus. Distribution autorisée. Livre disponible à l’achat.</p>
<p>Chaque ligne décrit un état différent. Aucune ne prouve à elle seule que le suivant est advenu.</p>
<p>Le caractère non exclusif compte aussi. En signant, je n’ai cédé ni les droits d’impression ni les éditions déjà existantes.</p>
<p>Comme auteur, j’aimerais clore l’histoire sur un « paru » satisfaisant.</p>
<p>Comme quelqu’un qui construit aussi des logiciels, je reconnais l’écart familier entre une remise achevée et un résultat vérifié.</p>
<p>Pour l’instant, la mise à jour exacte est celle-ci : l’accord est signé, les fichiers sont livrés, et la distribution aux détaillants est autorisée.</p>
<p>Un jalon mérite d’être partagé sans le faire passer pour la ligne d’arrivée.</p>
<p><em>Expérience personnelle de la préparation de la distribution. Ce n’est pas un conseil commercial ou juridique. Le nom de l’éditeur et celui du contact sont des substituts fictifs.</em></p>
HTML,
        ],
        'es' => [
            'title' => 'Una firma aún no es un lanzamiento',
            'image_alt' => 'Sobre un escritorio violeta, un bolígrafo turquesa termina una firma en pergamino; al lado una tableta de e-book y a lo lejos un escaparate cerrado suavemente iluminado.',
            'excerpt' => 'El 10 de noviembre firmé un acuerdo de distribución no exclusiva de la edición electrónica de Marža z krvi. Salieron los archivos, llegó la factura y aprobé la entrega a los comercios. Aún no tengo un listado confirmado.',
            'content' => <<<'HTML'
<p>El 10 de noviembre de 2026 firmé un acuerdo de distribución no exclusiva para una nueva edición electrónica del thriller eslovaco Marža z krvi.</p>
<p>La editorial Ekvora Digital recibió los archivos y emitió una factura. En la mañana del 11 de noviembre aprobé la entrega propuesta a los comercios al precio recomendado de 9,98&nbsp;euros.</p>
<p>Esos son hitos reales. Un listado confirmado en un comercio es otro hito, y todavía no lo tengo.</p>
<p>Trabajar este paso me ha obligado a usar con más precisión la palabra «hecho».</p>
<p>Manuscrito terminado. Archivos preparados. Acuerdo firmado. Materiales recibidos. Distribución autorizada. Libro a la venta.</p>
<p>Cada línea describe un estado distinto. Ninguna por sí sola demuestra que haya ocurrido el siguiente.</p>
<p>Lo no exclusivo también importa. Al firmar no entregué los derechos de impresión ni abandoné ediciones que ya existen.</p>
<p>Como autor me gustaría cerrar la historia con un «publicado» satisfactorio.</p>
<p>Como alguien que también construye software, reconozco la brecha familiar entre una entrega completada y un resultado verificado.</p>
<p>Por ahora la actualización exacta es esta: el acuerdo está firmado, los archivos entregados y la distribución a comercios autorizada.</p>
<p>Un hito merece compartirse sin pretender que sea la meta final.</p>
<p><em>Experiencia personal de la preparación de la distribución. No es consejo comercial ni jurídico. El nombre de la editorial y el del contacto son sustitutos ficticios.</em></p>
HTML,
        ],
        'pl' => [
            'title' => 'Podpis to jeszcze nie wydanie',
            'image_alt' => 'Na fioletowym biurku turkusowy długopis kończy podpis na pergaminie; obok tablet z e-bookiem, a w oddali delikatnie świeci zamknięta witryna sklepu.',
            'excerpt' => '10 listopada podpisałem niewyłączną umowę dystrybucji elektronicznego wydania Marży z krvi. Pliki odeszły, faktura przyszła, przekazanie sprzedawcom zatwierdziłem. Potwierdzonego wpisu w katalogu jeszcze nie mam.',
            'content' => <<<'HTML'
<p>10 listopada 2026 podpisałem niewyłączną umowę dystrybucji nowego elektronicznego wydania słowackiego thrillera Marža z krvi.</p>
<p>Wydawnictwo Ekvora Digital otrzymało pliki i wystawiło fakturę. Rankiem 11 listopada zatwierdziłem proponowane przekazanie sprzedawcom w zalecanej cenie 9,98&nbsp;euro.</p>
<p>To prawdziwe kamienie milowe. Potwierdzony wpis u sprzedawcy to inny kamień milowy, a tego jeszcze nie mam.</p>
<p>Praca nad tym krokiem zmusiła mnie do precyzyjniejszego używania słowa „gotowe”.</p>
<p>Rękopis dokończony. Pliki przygotowane. Umowa podpisana. Materiały przyjęte. Dystrybucja autoryzowana. Książkę można kupić.</p>
<p>Każdy wiersz opisuje inny stan. Żaden sam z siebie nie dowodzi, że nastąpił następny.</p>
<p>Niewyłączność umowy też ma znaczenie. Podpisem nie oddałem praw do druku ani nie porzuciłem już istniejących wydań.</p>
<p>Jako autor chciałbym zamknąć historię jednym satysfakcjonującym „ukazało się”.</p>
<p>Jako ktoś, kto buduje też oprogramowanie, znam lukę między przekazaną pracą a zweryfikowanym wynikiem.</p>
<p>Dokładna wiadomość na razie jest taka: umowa jest podpisana, pliki dostarczone, a dystrybucja do sprzedawców autoryzowana.</p>
<p>Kamień milowy warto udostępnić, nie udając, że to linia mety.</p>
<p><em>Osobiste doświadczenie z przygotowania dystrybucji. To nie jest porada handlowa ani prawna. Nazwa wydawnictwa i imię kontaktu to fikcyjne zamienniki.</em></p>
HTML,
        ],
        'hu' => [
            'title' => 'Az aláírás még nem megjelenés',
            'image_alt' => 'Ibolyaasztalon türkiz toll fejezi be az aláírást pergamenen; mellette e-könyv táblagép, a távolban lágyan világít egy zárt bolti kirakat.',
            'excerpt' => 'November 10-én nem kizárólagos terjesztési megállapodást írtam alá a Marža z krvi elektronikus kiadására. A fájlok elmentek, a számla megérkezett, a kereskedői átadást jóváhagytam. Megerősített listázásom még nincs.',
            'content' => <<<'HTML'
<p>2026. november 10-én nem kizárólagos terjesztési megállapodást írtam alá a szlovák thriller, a Marža z krvi új elektronikus kiadására.</p>
<p>Az Ekvora Digital kiadó megkapta a fájlokat és számlát állított ki. November 11-én reggel jóváhagytam a javasolt kereskedői átadást 9,98&nbsp;eurós ajánlott áron.</p>
<p>Ezek valódi mérföldkövek. A megerősített kereskedői listázás másik mérföldkő, és az még nincs meg.</p>
<p>Ez a lépés arra kényszerített, hogy pontosabban használjam a „kész” szót.</p>
<p>Kézirat befejezve. Fájlok előkészítve. Megállapodás aláírva. Anyagok átvéve. Terjesztés engedélyezve. Könyv megvásárolható.</p>
<p>Minden sor más állapotot ír le. Egyik sem bizonyítja önmagában, hogy a következő bekövetkezett.</p>
<p>A nem kizárólagosság is számít. Az aláírással nem adtam át a nyomdai jogokat, és nem hagytam el a már meglévő kiadásokat.</p>
<p>Szerzőként szeretném egy kielégítő „megjelent” szóval lezárni a történetet.</p>
<p>Valakiként, aki szoftvert is épít, felismerem az átadott munka és az ellenőrzött eredmény közötti ismerős rést.</p>
<p>Egyelőre a pontos jelentés ez: a megállapodás alá van írva, a fájlok kézbesítve, a kereskedői terjesztés engedélyezve.</p>
<p>Egy mérföldkövet érdemes megosztani anélkül, hogy célvonalként adnám el.</p>
<p><em>Személyes tapasztalat a terjesztés előkészítéséből. Nem kereskedelmi vagy jogi tanács. A kiadó neve és a kapcsolattartó neve fiktív helyettesítők.</em></p>
HTML,
        ],
        'it' => [
            'title' => 'Una firma non è ancora una pubblicazione',
            'image_alt' => 'Su una scrivania viola una penna turchese completa una firma su pergamena; accanto un tablet con e-book e in lontananza una vetrina chiusa soffusamente illuminata.',
            'excerpt' => 'Il 10 novembre ho firmato un accordo di distribuzione non esclusiva per l’edizione elettronica di Marža z krvi. I file sono partiti, è arrivata la fattura, ho approvato la consegna ai rivenditori. Non ho ancora un listing confermato.',
            'content' => <<<'HTML'
<p>Il 10 novembre 2026 ho firmato un accordo di distribuzione non esclusiva per una nuova edizione elettronica del thriller slovacco Marža z krvi.</p>
<p>L’editore Ekvora Digital ha ricevuto i file e emesso una fattura. La mattina dell’11 novembre ho approvato la consegna proposta ai rivenditori al prezzo consigliato di 9,98&nbsp;euro.</p>
<p>Sono traguardi reali. Un listing confermato presso un rivenditore è un altro traguardo, e non ce l’ho ancora.</p>
<p>Questo passaggio mi ha costretto a usare con più precisione la parola «finito».</p>
<p>Manoscritto concluso. File preparati. Accordo firmato. Materiali ricevuti. Distribuzione autorizzata. Libro acquistabile.</p>
<p>Ogni riga descrive uno stato diverso. Nessuna da sola prova che sia avvenuto quello successivo.</p>
<p>Conta anche la non esclusività. Firmando non ho ceduto i diritti di stampa né abbandonato edizioni già esistenti.</p>
<p>Come autore vorrei chiudere la storia con un «uscito» soddisfacente.</p>
<p>Come chi costruisce anche software, riconosco il familiare scarto tra una consegna completata e un risultato verificato.</p>
<p>Per ora l’aggiornamento esatto è questo: l’accordo è firmato, i file sono consegnati e la distribuzione ai rivenditori è autorizzata.</p>
<p>Un traguardo merita di essere condiviso senza fingersi il traguardo finale.</p>
<p><em>Esperienza personale dalla preparazione della distribuzione. Non è un consiglio commerciale o legale. Il nome dell’editore e quello del contatto sono sostituti fittizi.</em></p>
HTML,
        ],
        'uk' => [
            'title' => 'Підпис ще не є виданням',
            'image_alt' => 'На фіолетовому столі бірюзовий перо завершує підпис на пергаменті; поруч планшет з е-книгою, а вдалині м’яко світить зачинена вітрина крамниці.',
            'excerpt' => '10 листопада я підписав невиключну угоду про розповсюдження електронного видання Marža z krvi. Файли пішли, рахунок прийшов, передачу продавцям я схвалив. Підтвердженого запису в їхньому каталозі ще немає.',
            'content' => <<<'HTML'
<p>10 листопада 2026 року я підписав невиключну угоду про розповсюдження нового електронного видання словацького трилера Marža z krvi.</p>
<p>Видавництво Ekvora Digital отримало файли і виставило рахунок. Вранці 11 листопада я схвалив запропоновану передачу продавцям за рекомендованою ціною 9,98&nbsp;євро.</p>
<p>Це справжні віхи. Підтверджений запис у продавця ,  інша віха, і її в мене ще немає.</p>
<p>Робота над цим кроком змусила мене точніше вживати слово «готово».</p>
<p>Рукопис дописано. Файли підготовлено. Угоду підписано. Матеріали прийнято. Розповсюдження авторизовано. Книгу можна купити.</p>
<p>Кожен рядок описує інший стан. Жоден сам по собі не доводить, що настав наступний.</p>
<p>Невиключність угоди теж важить. Підписом я не віддав друкарські права й не залишив уже наявні видання.</p>
<p>Як автор я хотів би завершити історію одним задовільним «вийшло».</p>
<p>Як людина, що також будує програмне забезпечення, я впізнаю знайому прогалину між переданою роботою і перевіреним результатом.</p>
<p>Точна звістка поки така: угоду підписано, файли доставлено, розповсюдження продавцям авторизовано.</p>
<p>Віху варто поділитися, не видаючи її за фінішну лінію.</p>
<p><em>Особистий досвід підготовки розповсюдження. Це не комерційна й не юридична порада. Назва видавництва та ім’я контакту ,  вигадані заміни.</em></p>
HTML,
        ],
    ],
];
