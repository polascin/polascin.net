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
 * Vygenerované nie je doručené.
 * Vlastná skúsenosť z prvej polovice októbra 2026: prihláška súvisiaca
 * s umelou inteligenciou v medicíne, životopis a motivačný list v PDF a DOCX.
 * Kontrola očakávanej veľkosti odmietla stiahnutý súbor. Po oprave prenosu
 * sedeli odtlačky SHA-256 všetkých štyroch súborov.
 */
return [
    'slug' => 'vygenerovane-nie-je-dorucene',
    'author' => 'MUDr. Ľubomír Polaščín',
    'category' => 'blog',
    'is_top' => 0,
    'published_at' => '2026-10-28 00:35:00',
    'image' => 'images/articles/vygenerovane-nie-je-dorucene.webp',
    'translations' => [
        'sk' => [
            'title' => 'Vygenerované nie je doručené',
            'image_alt' => 'Tri svetlé prázdne hárky ležia na tmavofialovom stole. Nad dvoma v popredí visí tyrkysový sklenený kotúč a v pozadí svieti rad malých tyrkysových bodov.',
            'excerpt' => 'V prvej polovici októbra bol životopis z modelu hotový. Kontrola očakávanej veľkosti odmietla stiahnutý súbor. Po oprave prenosu ostali štyri súbory a pri každom sa zhodoval odtlačok SHA-256. Odtlačok nehodnotí text. Hovorí len to, či prišli tie isté bajty.',
            'content' => <<<'HTML'
<p>Pri príprave prihlášky súvisiacej s umelou inteligenciou v medicíne, v prvej polovici októbra, sa zastavil obyčajný krok. Dokument sa stiahol, lenže nemal očakávanú veľkosť. Prvý skript ho preto odmietol.</p>
<p>Životopis z modelu pritom už bol hotový. Zlyhanie nebolo v texte. Bolo v prenose. Užitočné nebolo samotné zlyhanie. Užitočná bola kontrola, ktorá nedovolila zapísať nedokončený prenos ako úspech.</p>
<p>Po oprave prenosu sa uložili všetky štyri dokumenty a pri každom sa overil odtlačok SHA-256. Boli to životopis a motivačný list, oba vo formáte PDF aj DOCX. Až vtedy platilo, že súbory sú uložené a odtlačky sa zhodujú.</p>
<p>Ostal z toho malý postup, ktorý sa dá použiť znova. Cieľové miesto musí byť dosiahnuteľné a musí sa doň dať zapisovať. Nestačí, že požiadavka skončila bez hlásenia o chybe. Treba si pozrieť, čo sa skutočne vrátilo. Odtlačok uloženého súboru sa porovná s odtlačkom, ktorý mal súbor mať. Úspech sa hlási až po tomto porovnaní.</p>
<p>Odtlačok SHA-256 nepovie, či je životopis dobre napísaný. Povie, či bajty v priečinku sú tie, ktoré sa mali uložiť. To sú dve kontroly kvality. Jedna sa pozerá na zmysel textu, druhá na to, či súbor vôbec došiel celý. Obe majú miesto a jedna druhú nenahrádza.</p>
<p>Na výstupy modelov sa pozeráme najmä podľa toho, či znejú rozumne. Oveľa menej sledujeme, či ten istý výstup došiel do správneho priečinka, neporušený a použiteľný. Text, ktorý ostal len v rozhovore s modelom, ešte nie je príloha k prihláške. Bez kontroly veľkosti by sa dokončená požiadavka zapísala ako úspech, hoci súbor nemal očakávanú veľkosť.</p>
<p>Pri automatizácii dokumentov je vygenerovanie medzník. Hotovo je až vtedy, keď je súbor doručený a overený.</p>

HTML,
        ],
        'en' => [
            'title' => 'Generated is not delivered',
            'image_alt' => 'Three blank pale sheets lie on a dark purple table. A teal glass disc hovers above the two in front, and a row of small teal points glows in the background.',
            'excerpt' => 'In the first half of October a CV from the model was ready. A check of the expected size rejected the download. After the transfer was corrected, four files remained, and the SHA-256 digest of each one matched. A digest does not judge the writing. It only says whether the same bytes arrived.',
            'content' => <<<'HTML'
<p>In the first half of October, while I was preparing an application connected with artificial intelligence in medicine, an ordinary step stopped the work. The document downloaded, but it did not have the expected size. The first script rejected it.</p>
<p>The CV from the model was already finished. The failure was not in the text. It was in the transfer. The failure itself was not the useful part. The useful part was the check that refused to record an unfinished transfer as success.</p>
<p>After the transfer was corrected, all four documents were saved, and the SHA-256 digest of each one was verified. They were the CV and the motivation letter, each as PDF and as DOCX. Only then was it true that the files were saved and the digests matched.</p>
<p>A small procedure remained, and it can be used again. The destination has to be reachable, and it has to be writable. It is not enough that the request ended without an error report. You have to look at what actually came back. The digest of the saved file is compared with the digest the file was supposed to have. Success is reported only after that comparison.</p>
<p>A SHA-256 digest does not say whether the CV is well written. It says whether the bytes in the folder are the bytes that were supposed to be saved. Those are two quality checks. One looks at the sense of the text. The other looks at whether the file arrived whole. Both belong, and neither replaces the other.</p>
<p>We look at model outputs mostly by whether they sound sensible. We watch much less whether that same output reached the right folder, intact and usable. Text that stayed only in the conversation with the model is not yet an attachment to the application. Without the size check, a completed request would have been recorded as success even though the file did not have the expected size.</p>
<p>In document automation, generation is a milestone. The work is finished only when the file has been delivered and verified.</p>

HTML,
        ],
        'cs' => [
            'title' => 'Vygenerované není doručené',
            'image_alt' => 'Tři světlé prázdné listy leží na tmavě fialovém stole. Nad dvěma v popředí visí tyrkysový skleněný kotouč a v pozadí svítí řada malých tyrkysových bodů.',
            'excerpt' => 'V první polovině října byl životopis z modelu hotový. Kontrola očekávané velikosti odmítla stažený soubor. Po opravě přenosu zůstaly čtyři soubory a u každého se shodoval otisk SHA-256. Otisk nehodnotí text. Říká jen to, zda přišly tytéž bajty.',
            'content' => <<<'HTML'
<p>Při přípravě přihlášky související s umělou inteligencí v medicíně, v první polovině října, se zastavil obyčejný krok. Dokument se stáhl, jenže neměl očekávanou velikost. První skript ho proto odmítl.</p>
<p>Životopis z modelu přitom už byl hotový. Selhání nebylo v textu. Bylo v přenosu. Užitečné nebylo samotné selhání. Užitečná byla kontrola, která nedovolila zapsat nedokončený přenos jako úspěch.</p>
<p>Po opravě přenosu se uložily všechny čtyři dokumenty a u každého se ověřil otisk SHA-256. Byl to životopis a motivační dopis, každý ve formátu PDF i DOCX. Teprve tehdy platilo, že soubory jsou uložené a otisky se shodují.</p>
<p>Zůstal z toho malý postup, který se dá použít znovu. Cílové místo musí být dosažitelné a musí se do něj dát zapisovat. Nestačí, že požadavek skončil bez hlášení o chybě. Je třeba se podívat, co se skutečně vrátilo. Otisk uloženého souboru se porovná s otiskem, který měl soubor mít. Úspěch se hlásí až po tomto porovnání.</p>
<p>Otisk SHA-256 neřekne, zda je životopis dobře napsaný. Řekne, zda bajty ve složce jsou ty, které se měly uložit. To jsou dvě kontroly kvality. Jedna se dívá na smysl textu, druhá na to, zda soubor vůbec dorazil celý. Obě mají své místo a jedna druhou nenahrazuje.</p>
<p>Na výstupy modelů se díváme především podle toho, zda znějí rozumně. Mnohem méně sledujeme, zda týž výstup dorazil do správné složky, neporušený a použitelný. Text, který zůstal jen v rozhovoru s modelem, ještě není příloha k přihlášce. Bez kontroly velikosti by se dokončený požadavek zapsal jako úspěch, ačkoli soubor neměl očekávanou velikost.</p>
<p>Při automatizaci dokumentů je vygenerování milník. Hotovo je až tehdy, když je soubor doručený a ověřený.</p>

HTML,
        ],
        'de' => [
            'title' => 'Erzeugt ist nicht zugestellt',
            'image_alt' => 'Drei helle leere Blätter liegen auf einem dunkelvioletten Tisch. Über den beiden vorn schwebt eine türkisfarbene Glasscheibe, im Hintergrund leuchtet eine Reihe kleiner türkiser Punkte.',
            'excerpt' => 'In der ersten Oktoberhälfte war der Lebenslauf aus dem Modell fertig. Die Prüfung der erwarteten Größe wies die heruntergeladene Datei zurück. Nach der Korrektur der Übertragung blieben vier Dateien, und bei jeder stimmte die SHA-256-Prüfsumme. Eine Prüfsumme beurteilt den Text nicht. Sie sagt nur, ob dieselben Bytes ankamen.',
            'content' => <<<'HTML'
<p>Bei der Vorbereitung einer Bewerbung im Zusammenhang mit künstlicher Intelligenz in der Medizin, in der ersten Oktoberhälfte, stockte die Arbeit an einem gewöhnlichen Schritt. Das Dokument wurde heruntergeladen, hatte aber nicht die erwartete Größe. Das erste Skript wies es deshalb zurück.</p>
<p>Der Lebenslauf aus dem Modell war bereits fertig. Das Scheitern lag nicht im Text. Es lag in der Übertragung. Nützlich war nicht das Scheitern selbst. Nützlich war die Prüfung, die eine unvollendete Übertragung nicht als Erfolg eintragen ließ.</p>
<p>Nach der Korrektur der Übertragung wurden alle vier Dokumente gespeichert, und bei jedem wurde die SHA-256-Prüfsumme verifiziert. Es waren der Lebenslauf und das Motivationsschreiben, jedes als PDF und als DOCX. Erst dann galt, dass die Dateien gespeichert sind und die Prüfsummen übereinstimmen.</p>
<p>Daraus blieb ein kleines Verfahren, das sich wieder verwenden lässt. Der Zielort muss erreichbar sein, und es muss sich dorthin schreiben lassen. Es genügt nicht, dass die Anfrage ohne Fehlermeldung endete. Man muss ansehen, was tatsächlich zurückkam. Die Prüfsumme der gespeicherten Datei wird mit der Prüfsumme verglichen, die die Datei haben sollte. Erfolg wird erst nach diesem Vergleich gemeldet.</p>
<p>Eine SHA-256-Prüfsumme sagt nicht, ob der Lebenslauf gut geschrieben ist. Sie sagt, ob die Bytes im Ordner die sind, die gespeichert werden sollten. Das sind zwei Qualitätsprüfungen. Die eine sieht auf den Sinn des Textes, die andere darauf, ob die Datei überhaupt vollständig ankam. Beide haben ihren Platz, und keine ersetzt die andere.</p>
<p>Auf die Ausgaben der Modelle sehen wir vor allem danach, ob sie vernünftig klingen. Viel weniger achten wir darauf, ob dieselbe Ausgabe im richtigen Ordner ankam, unversehrt und brauchbar. Ein Text, der nur im Gespräch mit dem Modell blieb, ist noch kein Anhang zur Bewerbung. Ohne die Größenprüfung wäre eine abgeschlossene Anfrage als Erfolg eingetragen worden, obwohl die Datei nicht die erwartete Größe hatte.</p>
<p>Bei der Automatisierung von Dokumenten ist das Erzeugen ein Meilenstein. Fertig ist die Arbeit erst, wenn die Datei zugestellt und geprüft ist.</p>

HTML,
        ],
        'fr' => [
            'title' => 'Généré n’est pas livré',
            'image_alt' => 'Trois feuilles claires et vides reposent sur une table violet foncé. Un disque de verre turquoise flotte au-dessus des deux de devant, et une rangée de petits points turquoise brille au fond.',
            'excerpt' => 'Dans la première moitié d’octobre, le CV issu du modèle était prêt. Le contrôle de la taille attendue a refusé le téléchargement. Après la correction du transfert, quatre fichiers restaient, et l’empreinte SHA-256 de chacun concordait. Une empreinte ne juge pas le texte. Elle dit seulement si les mêmes octets sont arrivés.',
            'content' => <<<'HTML'
<p>Lors de la préparation d’une candidature liée à l’intelligence artificielle en médecine, dans la première moitié d’octobre, une étape ordinaire a arrêté le travail. Le document s’est téléchargé, mais il n’avait pas la taille attendue. Le premier script l’a donc refusé.</p>
<p>Le CV issu du modèle était pourtant déjà prêt. L’échec n’était pas dans le texte. Il était dans le transfert. L’utile n’était pas l’échec lui-même. L’utile était le contrôle qui a empêché d’enregistrer un transfert inachevé comme un succès.</p>
<p>Après la correction du transfert, les quatre documents ont été enregistrés, et l’empreinte SHA-256 de chacun a été vérifiée. Il s’agissait du CV et de la lettre de motivation, chacun en PDF et en DOCX. C’est seulement alors qu’il était vrai que les fichiers étaient enregistrés et que les empreintes concordaient.</p>
<p>Il en est resté une petite procédure, que l’on peut réutiliser. Le lieu de destination doit être accessible, et l’on doit pouvoir y écrire. Il ne suffit pas que la requête se soit terminée sans message d’erreur. Il faut regarder ce qui est réellement revenu. L’empreinte du fichier enregistré est comparée à l’empreinte que le fichier devait avoir. Le succès n’est annoncé qu’après cette comparaison.</p>
<p>Une empreinte SHA-256 ne dit pas si le CV est bien écrit. Elle dit si les octets dans le dossier sont ceux qui devaient être enregistrés. Ce sont deux contrôles de qualité. L’un regarde le sens du texte, l’autre si le fichier est arrivé entier. Les deux ont leur place, et l’un ne remplace pas l’autre.</p>
<p>Nous jugeons les sorties des modèles surtout à ceci : est-ce qu’elles sonnent juste. Nous surveillons beaucoup moins si la même sortie est arrivée dans le bon dossier, intacte et utilisable. Un texte resté seulement dans la conversation avec le modèle n’est pas encore une pièce jointe à la candidature. Sans le contrôle de taille, une requête achevée aurait été enregistrée comme un succès, alors que le fichier n’avait pas la taille attendue.</p>
<p>Dans l’automatisation des documents, la génération est une étape. Le travail est fini seulement lorsque le fichier est livré et vérifié.</p>

HTML,
        ],
        'es' => [
            'title' => 'Generado no es entregado',
            'image_alt' => 'Tres hojas claras y vacías están sobre una mesa violeta oscura. Sobre las dos delanteras flota un disco de vidrio turquesa y, al fondo, brilla una fila de pequeños puntos turquesa.',
            'excerpt' => 'En la primera mitad de octubre el currículum del modelo estaba listo. El control del tamaño esperado rechazó la descarga. Tras corregir la transferencia quedaron cuatro archivos y la huella SHA-256 de cada uno coincidía. Una huella no juzga el texto. Solo dice si llegaron los mismos bytes.',
            'content' => <<<'HTML'
<p>Al preparar una solicitud relacionada con la inteligencia artificial en medicina, en la primera mitad de octubre, un paso ordinario detuvo el trabajo. El documento se descargó, pero no tenía el tamaño esperado. El primer script lo rechazó.</p>
<p>El currículum salido del modelo ya estaba listo. El fallo no estaba en el texto. Estaba en la transferencia. Lo útil no fue el fallo mismo. Lo útil fue el control que impidió registrar una transferencia inacabada como un éxito.</p>
<p>Tras corregir la transferencia se guardaron los cuatro documentos y se verificó la huella SHA-256 de cada uno. Eran el currículum y la carta de motivación, cada uno en PDF y en DOCX. Solo entonces era cierto que los archivos estaban guardados y que las huellas coincidían.</p>
<p>De ello quedó un procedimiento pequeño, que se puede volver a usar. El destino tiene que ser accesible y tiene que admitir escritura. No basta con que la petición terminara sin un aviso de error. Hay que mirar lo que realmente volvió. La huella del archivo guardado se compara con la huella que el archivo debía tener. El éxito se comunica solo después de esa comparación.</p>
<p>Una huella SHA-256 no dice si el currículum está bien escrito. Dice si los bytes de la carpeta son los que debían guardarse. Son dos controles de calidad. Uno mira el sentido del texto y el otro si el archivo llegó entero. Los dos tienen su lugar, y uno no sustituye al otro.</p>
<p>Miramos las salidas de los modelos sobre todo por si suenan sensatas. Vigilamos mucho menos si esa misma salida llegó a la carpeta correcta, intacta y utilizable. Un texto que se quedó solo en la conversación con el modelo todavía no es un adjunto de la solicitud. Sin el control de tamaño, una petición terminada se habría registrado como un éxito, aunque el archivo no tenía el tamaño esperado.</p>
<p>En la automatización de documentos, generar es un hito. El trabajo está terminado solo cuando el archivo está entregado y verificado.</p>

HTML,
        ],
        'pl' => [
            'title' => 'Wygenerowane nie jest dostarczone',
            'image_alt' => 'Trzy jasne puste arkusze leżą na ciemnofioletowym stole. Nad dwoma z przodu wisi turkusowy szklany krążek, a w tle świeci rząd małych turkusowych punktów.',
            'excerpt' => 'W pierwszej połowie października życiorys z modelu był gotowy. Kontrola oczekiwanej wielkości odrzuciła pobrany plik. Po poprawieniu przesyłu zostały cztery pliki i przy każdym zgodny był skrót SHA-256. Skrót nie ocenia tekstu. Mówi tylko, czy przyszły te same bajty.',
            'content' => <<<'HTML'
<p>Przy przygotowaniu zgłoszenia związanego ze sztuczną inteligencją w medycynie, w pierwszej połowie października, zatrzymał się zwykły krok. Dokument się pobrał, ale nie miał oczekiwanej wielkości. Pierwszy skrypt go dlatego odrzucił.</p>
<p>Życiorys z modelu był już gotowy. Niepowodzenie nie leżało w tekście. Leżało w przesyle. Pożyteczne nie było samo niepowodzenie. Pożyteczna była kontrola, która nie pozwoliła zapisać niedokończonego przesyłu jako sukcesu.</p>
<p>Po poprawieniu przesyłu zapisano wszystkie cztery dokumenty i przy każdym sprawdzono skrót SHA-256. Były to życiorys i list motywacyjny, każdy w formacie PDF i DOCX. Dopiero wtedy było prawdą, że pliki są zapisane, a skróty się zgadzają.</p>
<p>Został z tego mały sposób postępowania, który można użyć ponownie. Miejsce docelowe musi być osiągalne i musi dać się w nim zapisywać. Nie wystarczy, że żądanie zakończyło się bez komunikatu o błędzie. Trzeba obejrzeć, co naprawdę wróciło. Skrót zapisanego pliku porównuje się ze skrótem, który plik miał mieć. Sukces zgłasza się dopiero po tym porównaniu.</p>
<p>Skrót SHA-256 nie powie, czy życiorys jest dobrze napisany. Powie, czy bajty w folderze są tymi, które miały zostać zapisane. To dwie kontrole jakości. Jedna patrzy na sens tekstu, druga na to, czy plik w ogóle dotarł w całości. Obie mają swoje miejsce i jedna nie zastępuje drugiej.</p>
<p>Na wyjścia modeli patrzymy głównie pod tym kątem, czy brzmią rozsądnie. Znacznie mniej pilnujemy, czy to samo wyjście dotarło do właściwego folderu, nienaruszone i zdatne do użycia. Tekst, który został tylko w rozmowie z modelem, nie jest jeszcze załącznikiem do zgłoszenia. Bez kontroli wielkości ukończone żądanie zostałoby zapisane jako sukces, choć plik nie miał oczekiwanej wielkości.</p>
<p>Przy automatyzacji dokumentów wygenerowanie jest kamieniem milowym. Skończone jest dopiero wtedy, gdy plik jest dostarczony i sprawdzony.</p>

HTML,
        ],
        'hu' => [
            'title' => 'A generált még nincs kézbesítve',
            'image_alt' => 'Három világos üres lap fekszik a sötétlila asztalon. A két elülső fölött türkiz üvegkorong lebeg, a háttérben apró türkiz pontok sora világít.',
            'excerpt' => 'Október első felében a modellből származó önéletrajz kész volt. A várt méret ellenőrzése elutasította a letöltést. Az átvitel javítása után négy fájl maradt, és mindegyik SHA-256 lenyomata egyezett. A lenyomat nem ítéli meg a szöveget. Csak azt mondja meg, hogy ugyanazok a bájtok érkeztek-e meg.',
            'content' => <<<'HTML'
<p>Egy, az orvosi mesterséges intelligenciához kapcsolódó jelentkezés előkészítése közben, október első felében, egy hétköznapi lépés megállította a munkát. A dokumentum letöltődött, de nem a várt méretű volt. Az első szkript ezért elutasította.</p>
<p>A modellből származó önéletrajz addigra kész volt. A hiba nem a szövegben volt. Az átvitelben volt. Nem maga a hiba volt a hasznos. A hasznos az az ellenőrzés volt, amely nem engedte, hogy egy befejezetlen átvitel sikernek számítson.</p>
<p>Az átvitel javítása után mind a négy dokumentum elmentődött, és mindegyiknek ellenőriztük a SHA-256 lenyomatát. Önéletrajz és motivációs levél volt, mindkettő PDF és DOCX formátumban. Csak akkor volt igaz, hogy a fájlok el vannak mentve, és a lenyomatok egyeznek.</p>
<p>Maradt belőle egy kis eljárás, amelyet újra lehet használni. A célhelynek elérhetőnek kell lennie, és írhatónak. Nem elég, hogy a kérés hibaüzenet nélkül ért véget. Meg kell nézni, mi érkezett vissza valójában. A mentett fájl lenyomatát azzal a lenyomattal vetjük össze, amelynek a fájlon lennie kellett. A sikert csak ez után az összevetés után jelentjük.</p>
<p>A SHA-256 lenyomat nem mondja meg, hogy az önéletrajz jól van-e megírva. Azt mondja meg, hogy a mappában lévő bájtok azok-e, amelyeket menteni kellett. Ez két minőségellenőrzés. Az egyik a szöveg értelmét nézi, a másik azt, hogy a fájl egyáltalán egészben megérkezett-e. Mindkettőnek helye van, és egyik sem pótolja a másikat.</p>
<p>A modellek kimenetét főként aszerint nézzük, hogy értelmesen hangzik-e. Sokkal kevésbé figyeljük, hogy ugyanaz a kimenet a megfelelő mappába érkezett-e, sértetlenül és használhatóan. A szöveg, amely csak a modellel folytatott beszélgetésben maradt, még nem melléklet a jelentkezéshez. A méretellenőrzés nélkül a befejezett kérés sikernek íródott volna, holott a fájl nem a várt méretű volt.</p>
<p>A dokumentumok automatizálásánál a generálás mérföldkő. Akkor van kész, amikor a fájl kézbesítve és ellenőrizve van.</p>

HTML,
        ],
        'it' => [
            'title' => 'Generato non è consegnato',
            'image_alt' => 'Tre fogli chiari e vuoti stanno su un tavolo viola scuro. Sopra i due in primo piano fluttua un disco di vetro turchese e, sullo sfondo, brilla una fila di piccoli punti turchesi.',
            'excerpt' => 'Nella prima metà di ottobre il curriculum uscito dal modello era pronto. Il controllo della dimensione attesa ha rifiutato il download. Dopo la correzione del trasferimento restavano quattro file, e l’impronta SHA-256 di ciascuno coincideva. Un’impronta non giudica il testo. Dice solo se sono arrivati gli stessi byte.',
            'content' => <<<'HTML'
<p>Nella prima metà di ottobre, mentre preparavo una candidatura legata all’intelligenza artificiale in medicina, un passaggio ordinario ha fermato il lavoro. Il documento si è scaricato, ma non aveva la dimensione attesa. Il primo script lo ha quindi rifiutato.</p>
<p>Il curriculum uscito dal modello era già pronto. Il fallimento non era nel testo. Era nel trasferimento. Non è stato utile il fallimento in sé. È stato utile il controllo che ha impedito di registrare un trasferimento incompiuto come un successo.</p>
<p>Dopo la correzione del trasferimento sono stati salvati tutti e quattro i documenti, e per ciascuno è stata verificata l’impronta SHA-256. Erano il curriculum e la lettera di motivazione, ognuno in PDF e in DOCX. Solo allora era vero che i file erano salvati e che le impronte coincidevano.</p>
<p>Ne è rimasta una piccola procedura, che si può riusare. La destinazione deve essere raggiungibile e ci si deve poter scrivere. Non basta che la richiesta sia finita senza un messaggio di errore. Bisogna guardare che cosa è davvero tornato indietro. L’impronta del file salvato si confronta con l’impronta che il file doveva avere. Il successo si comunica solo dopo questo confronto.</p>
<p>Un’impronta SHA-256 non dice se il curriculum è scritto bene. Dice se i byte nella cartella sono quelli che dovevano essere salvati. Sono due controlli di qualità. Uno guarda il senso del testo, l’altro se il file è arrivato intero. Tutti e due hanno un posto, e l’uno non sostituisce l’altro.</p>
<p>Guardiamo le uscite dei modelli soprattutto per capire se suonano sensate. Controlliamo molto meno se quella stessa uscita è arrivata nella cartella giusta, intatta e utilizzabile. Un testo rimasto solo nella conversazione con il modello non è ancora un allegato della candidatura. Senza il controllo della dimensione, una richiesta conclusa sarebbe stata registrata come un successo, benché il file non avesse la dimensione attesa.</p>
<p>Nell’automazione dei documenti, generare è una tappa. Il lavoro è finito solo quando il file è consegnato e verificato.</p>

HTML,
        ],
        'uk' => [
            'title' => 'Згенероване ще не доставлене',
            'image_alt' => 'Три світлі порожні аркуші лежать на темно-фіолетовому столі. Над двома спереду висить бірюзовий скляний диск, а на тлі світить ряд малих бірюзових цяток.',
            'excerpt' => 'У першій половині жовтня резюме з моделі було готове. Перевірка очікуваного розміру відхилила завантаження. Після виправлення передавання лишилися чотири файли, і відбиток SHA-256 кожного збігався. Відбиток не оцінює текст. Він каже лише те, чи прийшли ті самі байти.',
            'content' => <<<'HTML'
<p>Під час підготовки заявки, пов’язаної зі штучним інтелектом у медицині, у першій половині жовтня, звичайний крок зупинив роботу. Документ завантажився, але не мав очікуваного розміру. Перший скрипт його тому відхилив.</p>
<p>Резюме з моделі вже було готове. Збій був не в тексті. Він був у передаванні. Корисним був не сам збій. Корисною була перевірка, яка не дозволила записати незавершене передавання як успіх.</p>
<p>Після виправлення передавання збереглися всі чотири документи, і для кожного перевірили відбиток SHA-256. Це були резюме і мотиваційний лист, кожен у форматі PDF і DOCX. Лише тоді було правдою, що файли збережені, а відбитки збігаються.</p>
<p>З цього лишився невеликий порядок дій, який можна використати знову. Цільове місце має бути досяжним, і до нього має бути змога записати. Недостатньо того, що запит завершився без повідомлення про помилку. Треба подивитися, що справді повернулося. Відбиток збереженого файлу порівнюють із відбитком, який файл мав мати. Успіх повідомляють лише після цього порівняння.</p>
<p>Відбиток SHA-256 не скаже, чи резюме добре написане. Він скаже, чи байти в теці є тими, які мали зберегтися. Це дві перевірки якості. Одна дивиться на сенс тексту, друга на те, чи файл узагалі прибув цілим. Обидві мають своє місце, і одна не замінює іншу.</p>
<p>На виходи моделей ми дивимося передусім за тим, чи вони звучать розумно. Набагато менше стежимо, чи той самий вихід прибув до правильної теки, непошкоджений і придатний до використання. Текст, який лишився лише в розмові з моделлю, ще не є додатком до заявки. Без перевірки розміру завершений запит було б записано як успіх, хоча файл не мав очікуваного розміру.</p>
<p>В автоматизації документів генерування є проміжним етапом. Готово лише тоді, коли файл доправлено і перевірено.</p>

HTML,
        ],
    ],
];
