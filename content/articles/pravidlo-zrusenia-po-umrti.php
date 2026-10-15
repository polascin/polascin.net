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
 * Pravidlo zrušenia po zázname úmrtia v Arenibuse, vydanie v0.17.181.
 * Zdroj: autorov záznam o commite z 13. 10. 2026, 15:48 CEST, a o kóde s auditnou dokumentáciou.
 * Súkromný repozitár sa v článku neodkazuje. Číslo verzie na verejnom webe nie je.
 * Verejný opis produktu: https://arenibus.polascin.net/ (nefrológia a dialýza).
 */
return [
    'slug' => 'pravidlo-zrusenia-po-umrti',
    'author' => 'MUDr. Ľubomír Polaščín',
    'category' => 'blog',
    'is_top' => 0,
    'published_at' => '2026-10-15 17:35:00',
    'image' => 'images/articles/pravidlo-zrusenia-po-umrti.webp',
    'translations' => [
        'sk' => [
            'title' => 'Tento týždeň stojí za reč pravidlo zrušenia.',
            'image_alt' => 'Muž v tmavofialovej košeli sedí zboku pri stole. Monitor delí zvislý fialový pás. Vľavo svietia tyrkysové riadky, vpravo sú bledšie a jeden sa láme. Od podstavca klesá tyrkysová stopa na zatvorený zošit.',
            'excerpt' => '13. októbra 2026 som vo vydaní v0.17.181 doplnil do Arenibusu pravidlá pri zázname úmrtia. Systém zruší plánované, ešte nezačaté dialýzy po tomto dátume, zapíše dôvod a nechá auditnú stopu. Nový program aj nový predpis pre zosnulého pacienta odmietne. Ak zrušenie sedení zlyhá, úmrtie ostane uložené a príde výslovná chyba.',
            'content' => <<<'HTML'
<p>13. októbra 2026 som vo vydaní <strong>v0.17.181</strong> doplnil do <a href="https://arenibus.polascin.net/">Arenibusu</a> pravidlá, ktoré sa spustia pri zázname úmrtia pacienta. Arenibus je softvér, ktorý píšem pre nefrológiu a dialýzu.</p>
<p>Keď sa úmrtie uloží, systém zruší plánované dialyzačné sedenia, ktoré sa ešte nezačali a ktorých termín je po dátume úmrtia. K zrušeniu zapíše dôvod a nechá auditnú stopu.</p>
<p>Nový zápis do dialyzačného programu aj nový predpis pre pacienta vedeného ako zosnulého odmietne.</p>
<p>Sú to tiché pravidlá. Jedna časť systému už má v zázname úmrtie. Druhá preto nemá ďalej plánovať dialýzu, ktorá sa nemá začať.</p>
<p>Ostáva aj prípad, keď sa podarí len prvá polovica.</p>
<p>Ak sa úmrtie uloží a zrušenie budúcich sedení zlyhá, záznam úmrtia ostane. Systém vráti výslovnú chybu. Neohlási úspech celej operácie.</p>
<p>Uložený klinický fakt a dokončené následné kroky sú dve veci. Keď sa stav pacienta zmení, časť nadväzujúcej práce sa má zastaviť. Ak sa dokončí len polovica postupu, má ostať viditeľné, čo sa podarilo.</p>
<p>Kvalita klinického softvéru je v týchto prechodoch rovnako ako na hlavných obrazovkách. Keď sa okolnosti zmenia, produkt má udržať, čo zapísaný údaj znamená.</p>
<p><em>Ide o opis pravidla v softvéri, nie o postup pri úmrtí pacienta v starostlivosti.</em></p>

HTML,
        ],
        'en' => [
            'title' => 'This week, a cancellation rule is worth talking about.',
            'image_alt' => 'A man in a deep purple shirt sits sideways at a desk. A vertical purple band splits the monitor: teal rows glow on the left, grow pale on the right, and one row breaks. A teal trail falls from the stand onto a closed notebook.',
            'excerpt' => 'On 13 October 2026, in release v0.17.181, I added rules to Arenibus for when a death is recorded. The system cancels planned dialysis sessions that have not started and fall after that date, records the reason and leaves an audit trail. A new program and a new prescription for a patient recorded as deceased are refused. If cancelling the sessions fails, the death stays saved and the system returns an explicit error.',
            'content' => <<<'HTML'
<p>On 13 October 2026, in release <strong>v0.17.181</strong>, I added rules to <a href="https://arenibus.polascin.net/">Arenibus</a> that run when a patient’s death is recorded. Arenibus is the software I write for nephrology and dialysis.</p>
<p>When the death is saved, the system cancels planned dialysis sessions that have not started and are scheduled after the date of death. It records the reason for the cancellation and leaves an audit trail.</p>
<p>It refuses a new dialysis-program enrollment and a new prescription for a patient recorded as deceased.</p>
<p>These are quiet rules. One part of the system already has the death on record. The other must stop planning a dialysis session that should not start.</p>
<p>There is also the case where only the first half succeeds.</p>
<p>If the death is saved and cancelling the future sessions fails, the death record remains. The system returns an explicit error. It does not report the whole operation as successful.</p>
<p>A saved clinical fact and completed follow-up steps are two separate things. When a patient’s status changes, part of the work that follows has to stop. If only half the workflow finishes, what succeeded has to stay visible.</p>
<p>In clinical software, product quality sits in these transitions as much as on the main screens. When circumstances change, the product has to keep what the recorded fact means.</p>
<p><em>This describes a rule in software, not a procedure for a patient’s death in care.</em></p>

HTML,
        ],
        'cs' => [
            'title' => 'Tento týden stojí za řeč pravidlo zrušení.',
            'image_alt' => 'Muž v tmavě fialové košili sedí bokem u stolu. Monitor dělí svislý fialový pás. Vlevo svítí tyrkysové řádky, vpravo jsou bledší a jeden se láme. Od podstavce klesá tyrkysová stopa na zavřený sešit.',
            'excerpt' => '13. října 2026 jsem ve vydání v0.17.181 doplnil do Arenibusu pravidla při záznamu úmrtí. Systém zruší plánované, ještě nezahájené dialýzy po tomto datu, zapíše důvod a nechá auditní stopu. Nový program i nový předpis pro zemřelého pacienta odmítne. Když zrušení sezení selže, úmrtí zůstane uložené a přijde výslovná chyba.',
            'content' => <<<'HTML'
<p>13. října 2026 jsem ve vydání <strong>v0.17.181</strong> doplnil do <a href="https://arenibus.polascin.net/">Arenibusu</a> pravidla, která se spustí při záznamu úmrtí pacienta. Arenibus je software, který píšu pro nefrologii a dialýzu.</p>
<p>Když se úmrtí uloží, systém zruší plánovaná dialyzační sezení, která ještě nezačala a jejichž termín je po datu úmrtí. Ke zrušení zapíše důvod a nechá auditní stopu.</p>
<p>Nové zařazení do dialyzačního programu i nový předpis pro pacienta vedeného jako zemřelého odmítne.</p>
<p>Jsou to tichá pravidla. Jedna část systému už má v záznamu úmrtí. Druhá proto nemá dál plánovat dialýzu, která se nemá začít.</p>
<p>Zůstává i případ, kdy se podaří jen první polovina.</p>
<p>Pokud se úmrtí uloží a zrušení budoucích sezení selže, záznam úmrtí zůstane. Systém vrátí výslovnou chybu. Neohlásí úspěch celé operace.</p>
<p>Uložený klinický údaj a dokončené návazné kroky jsou dvě věci. Když se stav pacienta změní, část navazující práce se má zastavit. Pokud se dokončí jen polovina postupu, má zůstat viditelné, co se podařilo.</p>
<p>Kvalita klinického softwaru je v těchto přechodech stejně jako na hlavních obrazovkách. Když se okolnosti změní, produkt má udržet, co zapsaný údaj znamená.</p>
<p><em>Jde o popis pravidla v softwaru, nikoli o postup při úmrtí pacienta v péči.</em></p>

HTML,
        ],
        'de' => [
            'title' => 'Diese Woche ist eine Absageregel der Rede wert.',
            'image_alt' => 'Ein Mann im dunkelvioletten Hemd sitzt seitlich an einem Tisch. Ein senkrechtes violettes Band teilt den Monitor. Links leuchten türkise Zeilen, rechts sind sie blasser und eine bricht. Vom Fuß fällt eine türkise Spur auf ein geschlossenes Heft.',
            'excerpt' => 'Am 13. Oktober 2026 habe ich in Version v0.17.181 Regeln in Arenibus ergänzt, die beim Erfassen eines Todes greifen. Das System sagt geplante, noch nicht begonnene Dialysesitzungen nach diesem Datum ab, schreibt den Grund und hinterlässt eine Prüfspur. Ein neues Programm und eine neue Verordnung für einen als verstorben geführten Patienten werden abgelehnt. Schlägt das Absagen fehl, bleibt der Tod gespeichert und es kommt eine ausdrückliche Fehlermeldung.',
            'content' => <<<'HTML'
<p>Am 13. Oktober 2026 habe ich in Version <strong>v0.17.181</strong> Regeln in <a href="https://arenibus.polascin.net/">Arenibus</a> ergänzt, die greifen, wenn der Tod eines Patienten erfasst wird. Arenibus ist die Software, die ich für Nephrologie und Dialyse schreibe.</p>
<p>Wird der Tod gespeichert, sagt das System geplante Dialysesitzungen ab, die noch nicht begonnen haben und deren Termin nach dem Todesdatum liegt. Zur Absage schreibt es den Grund und hinterlässt eine Prüfspur.</p>
<p>Eine neue Aufnahme in ein Dialyseprogramm und eine neue Verordnung lehnt es für einen als verstorben geführten Patienten ab.</p>
<p>Das sind stille Regeln. Ein Teil des Systems hat den Tod bereits im Datensatz. Der andere darf deshalb keine Dialyse mehr einplanen, die nicht beginnen soll.</p>
<p>Es bleibt auch der Fall, in dem nur die erste Hälfte gelingt.</p>
<p>Wird der Tod gespeichert und das Absagen der künftigen Sitzungen scheitert, bleibt der Todeseintrag. Das System gibt einen ausdrücklichen Fehler zurück. Es meldet nicht, die gesamte Operation sei gelungen.</p>
<p>Ein gespeicherter klinischer Sachverhalt und abgeschlossene Folgeschritte sind zwei Dinge. Ändert sich der Status eines Patienten, muss ein Teil der anschließenden Arbeit aufhören. Wird nur die Hälfte des Ablaufs fertig, muss sichtbar bleiben, was gelungen ist.</p>
<p>Die Qualität klinischer Software liegt in diesen Übergängen ebenso wie auf den Hauptbildschirmen. Wenn sich die Umstände ändern, muss das Produkt bewahren, was der gespeicherte Eintrag bedeutet.</p>
<p><em>Das ist die Beschreibung einer Regel in der Software, kein Vorgehen beim Tod eines Patienten in der Versorgung.</em></p>

HTML,
        ],
        'fr' => [
            'title' => 'Cette semaine, la règle d’annulation mérite qu’on en parle.',
            'image_alt' => 'Un homme en chemise violet foncé est assis de côté à un bureau. Une bande violette verticale partage l’écran. À gauche les lignes turquoise brillent, à droite elles pâlissent et l’une se brise. Une traînée turquoise descend du pied vers un cahier fermé.',
            'excerpt' => 'Le 13 octobre 2026, dans la version v0.17.181, j’ai ajouté à Arenibus des règles au moment où un décès est enregistré. Le système annule les séances de dialyse prévues, pas encore commencées, après cette date, inscrit le motif et laisse une trace d’audit. Une nouvelle inscription et une nouvelle prescription pour un patient enregistré comme décédé sont refusées. Si l’annulation échoue, le décès reste enregistré et le système renvoie une erreur explicite.',
            'content' => <<<'HTML'
<p>Le 13 octobre 2026, dans la version <strong>v0.17.181</strong>, j’ai ajouté à <a href="https://arenibus.polascin.net/">Arenibus</a> des règles qui s’appliquent quand le décès d’un patient est enregistré. Arenibus est le logiciel que j’écris pour la néphrologie et la dialyse.</p>
<p>Quand le décès est enregistré, le système annule les séances de dialyse prévues qui n’ont pas encore commencé et dont la date est postérieure au décès. Il inscrit le motif de l’annulation et laisse une trace d’audit.</p>
<p>Il refuse une nouvelle inscription au programme de dialyse et une nouvelle prescription pour un patient enregistré comme décédé.</p>
<p>Ce sont des règles discrètes. Une partie du système a déjà le décès dans le dossier. L’autre ne doit plus planifier une dialyse qui ne doit pas commencer.</p>
<p>Il reste aussi le cas où seule la première moitié aboutit.</p>
<p>Si le décès est enregistré et que l’annulation des séances à venir échoue, l’enregistrement du décès demeure. Le système renvoie une erreur explicite. Il ne signale pas que l’opération entière a réussi.</p>
<p>Un fait clinique enregistré et des suites menées à terme sont deux choses distinctes. Quand l’état d’un patient change, une partie du travail qui suit doit s’arrêter. Si seule la moitié du circuit se termine, ce qui a réussi doit rester visible.</p>
<p>Dans un logiciel clinique, la qualité du produit se joue dans ces passages autant que sur les écrans principaux. Quand les circonstances changent, le produit doit garder ce que la donnée enregistrée signifie.</p>
<p><em>Il s’agit de la description d’une règle dans un logiciel, pas d’une conduite à tenir lors du décès d’un patient en soins.</em></p>

HTML,
        ],
        'es' => [
            'title' => 'Esta semana, la regla de cancelación merece que se hable de ella.',
            'image_alt' => 'Un hombre con camisa violeta oscura está sentado de lado. Una banda morada vertical parte el monitor. A la izquierda brillan filas turquesa, a la derecha palidecen y una se rompe. Un rastro turquesa baja hasta un cuaderno cerrado.',
            'excerpt' => 'El 13 de octubre de 2026, en la versión v0.17.181, añadí a Arenibus reglas para cuando se registra una muerte. El sistema cancela las sesiones de diálisis previstas que aún no han empezado y quedan después de esa fecha, anota el motivo y deja un rastro de auditoría. Rechaza un programa nuevo y una prescripción nueva para un paciente registrado como fallecido. Si la cancelación falla, la muerte queda guardada y el sistema devuelve un error explícito.',
            'content' => <<<'HTML'
<p>El 13 de octubre de 2026, en la versión <strong>v0.17.181</strong>, añadí a <a href="https://arenibus.polascin.net/">Arenibus</a> reglas que se aplican cuando se registra la muerte de un paciente. Arenibus es el programa que escribo para nefrología y diálisis.</p>
<p>Cuando la muerte queda guardada, el sistema cancela las sesiones de diálisis previstas que aún no han empezado y cuya fecha es posterior a la muerte. Anota el motivo de la cancelación y deja un rastro de auditoría.</p>
<p>Rechaza una nueva inscripción en el programa de diálisis y una nueva prescripción para un paciente registrado como fallecido.</p>
<p>Son reglas discretas. Una parte del sistema ya tiene la muerte en el registro. La otra no debe seguir planificando una diálisis que no debe empezar.</p>
<p>Queda también el caso en que solo se completa la primera mitad.</p>
<p>Si la muerte queda guardada y cancelar las sesiones futuras falla, el registro de la muerte permanece. El sistema devuelve un error explícito. No informa de que toda la operación haya tenido éxito.</p>
<p>Un hecho clínico guardado y los pasos siguientes ya terminados son dos cosas distintas. Cuando cambia el estado de un paciente, parte del trabajo que sigue tiene que detenerse. Si solo se completa la mitad del proceso, debe seguir viéndose qué salió bien.</p>
<p>En el software clínico, la calidad del producto está en estas transiciones tanto como en las pantallas principales. Cuando cambian las circunstancias, el producto tiene que sostener lo que el dato guardado significa.</p>
<p><em>Esto describe una regla del programa, no un procedimiento ante la muerte de un paciente en la asistencia.</em></p>

HTML,
        ],
        'pl' => [
            'title' => 'W tym tygodniu warto mówić o regule anulowania.',
            'image_alt' => 'Mężczyzna w ciemnofioletowej koszuli siedzi bokiem przy biurku. Pionowy fioletowy pas dzieli monitor. Po lewej świecą turkusowe wiersze, po prawej bledną, a jeden się łamie. Od podstawy spływa turkusowy ślad na zamknięty zeszyt.',
            'excerpt' => '13 października 2026 w wydaniu v0.17.181 dodałem do Arenibusa reguły przy zapisie zgonu. System anuluje zaplanowane, jeszcze nierozpoczęte dializy po tej dacie, zapisuje powód i zostawia ślad audytu. Nowy program i nowe zlecenie dla pacjenta zapisanego jako zmarły odrzuca. Jeśli anulowanie sesji się nie uda, zgon zostaje zapisany, a system zwraca jawny błąd.',
            'content' => <<<'HTML'
<p>13 października 2026 w wydaniu <strong>v0.17.181</strong> dodałem do <a href="https://arenibus.polascin.net/">Arenibusa</a> reguły, które uruchamiają się przy zapisie zgonu pacjenta. Arenibus to oprogramowanie, które piszę dla nefrologii i dializy.</p>
<p>Gdy zgon zostanie zapisany, system anuluje zaplanowane sesje dializy, które jeszcze się nie rozpoczęły i których termin wypada po dacie zgonu. Przy anulowaniu zapisuje powód i zostawia ślad audytu.</p>
<p>Nowe przyjęcie do programu dializ i nowe zlecenie dla pacjenta prowadzonego jako zmarły odrzuca.</p>
<p>To ciche reguły. Jedna część systemu ma już zgon w zapisie. Druga nie ma więc dalej planować dializy, która nie powinna się rozpocząć.</p>
<p>Zostaje też przypadek, w którym uda się tylko pierwsza połowa.</p>
<p>Jeśli zgon zostanie zapisany, a anulowanie przyszłych sesji się nie powiedzie, zapis zgonu zostaje. System zwraca jawny błąd. Nie zgłasza sukcesu całej operacji.</p>
<p>Zapisany fakt kliniczny i dokończone kroki następcze to dwie rzeczy. Gdy zmienia się stan pacjenta, część dalszej pracy ma się zatrzymać. Jeśli dokończy się tylko połowa przebiegu, ma zostać widoczne, co się udało.</p>
<p>Jakość oprogramowania klinicznego jest w tych przejściach tak samo jak na głównych ekranach. Gdy zmieniają się okoliczności, produkt ma utrzymać to, co zapisany fakt znaczy.</p>
<p><em>To opis reguły w oprogramowaniu, nie postępowanie przy zgonie pacjenta w opiece.</em></p>

HTML,
        ],
        'hu' => [
            'title' => 'Ezen a héten a lemondási szabályról érdemes beszélni.',
            'image_alt' => 'Egy férfi sötétlila ingben ül oldalt az asztalnál. Függőleges lila sáv osztja a monitort. Balra türkiz sorok világítanak, jobbra halványabbak, és az egyik megtörik. A talptól türkiz nyom ereszkedik egy csukott füzetre.',
            'excerpt' => '2026. október 13-án, a v0.17.181 kiadásban, szabályokat tettem az Arenibusba a halál rögzítéséhez. A rendszer lemondja a tervezett, még el nem kezdett dialíziseket e dátum után, feljegyzi az okot, és ellenőrzési nyomot hagy. Az elhunytként rögzített beteg új programját és új előírását elutasítja. Ha a lemondás sikertelen, a halál rögzítve marad, és a rendszer kifejezett hibát ad vissza.',
            'content' => <<<'HTML'
<p>2026. október 13-án, a <strong>v0.17.181</strong> kiadásban, olyan szabályokat tettem az <a href="https://arenibus.polascin.net/">Arenibusba</a>, amelyek a beteg halálának rögzítésekor lépnek életbe. Az Arenibus az a szoftver, amelyet nefrológiára és dialízisre írok.</p>
<p>Ha a halál rögzítésre kerül, a rendszer lemondja azokat a tervezett dialíziskezeléseket, amelyek még nem kezdődtek el, és amelyek időpontja a halál dátuma után van. A lemondáshoz feljegyzi az okot, és ellenőrzési nyomot hagy.</p>
<p>Elutasítja a dialízisprogramba való új felvételt és az új előírást annál a betegnél, akit elhunytként tartanak nyilván.</p>
<p>Ezek csendes szabályok. A rendszer egyik része már rögzítette a halált. A másik ezért nem tervezhet tovább olyan dialízist, amelynek nem szabad elindulnia.</p>
<p>Marad az az eset is, amikor csak az első rész sikerül.</p>
<p>Ha a halál rögzül, a jövőbeli kezelések lemondása viszont meghiúsul, a halál bejegyzése megmarad. A rendszer kifejezett hibát ad vissza. Nem jelenti a teljes művelet sikerét.</p>
<p>A rögzített klinikai tény és a befejezett következő lépések két külön dolog. Ha a beteg állapota megváltozik, a rákövetkező munka egy részének meg kell állnia. Ha a folyamatnak csak a fele készül el, láthatónak kell maradnia, hogy mi sikerült.</p>
<p>A klinikai szoftver minősége ezekben az átmenetekben ugyanúgy jelen van, mint a fő képernyőkön. Ha a körülmények megváltoznak, a terméknek meg kell tartania, hogy a rögzített adat mit jelent.</p>
<p><em>Ez egy szabály leírása a szoftverben, nem eljárás a beteg halálakor az ellátásban.</em></p>

HTML,
        ],
        'it' => [
            'title' => 'Questa settimana vale la pena parlare della regola di annullamento.',
            'image_alt' => 'Un uomo con una camicia viola scuro siede di lato a una scrivania. Una banda viola verticale divide il monitor. A sinistra brillano righe turchesi, a destra impallidiscono e una si spezza. Una scia turchese scende dal piede su un quaderno chiuso.',
            'excerpt' => 'Il 13 ottobre 2026, nella versione v0.17.181, ho aggiunto ad Arenibus regole per quando viene registrata una morte. Il sistema annulla le sedute di dialisi pianificate, non ancora iniziate, dopo quella data, scrive il motivo e lascia una traccia di verifica. Rifiuta un nuovo programma e una nuova prescrizione per un paziente registrato come deceduto. Se l’annullamento fallisce, la morte resta salvata e il sistema restituisce un errore esplicito.',
            'content' => <<<'HTML'
<p>Il 13 ottobre 2026, nella versione <strong>v0.17.181</strong>, ho aggiunto ad <a href="https://arenibus.polascin.net/">Arenibus</a> regole che scattano quando viene registrata la morte di un paziente. Arenibus è il software che scrivo per la nefrologia e la dialisi.</p>
<p>Quando la morte viene salvata, il sistema annulla le sedute di dialisi pianificate che non sono ancora iniziate e la cui data è successiva alla morte. All’annullamento scrive il motivo e lascia una traccia di verifica.</p>
<p>Rifiuta una nuova iscrizione al programma di dialisi e una nuova prescrizione per un paziente registrato come deceduto.</p>
<p>Sono regole silenziose. Una parte del sistema ha già la morte in registrazione. L’altra non deve continuare a pianificare una dialisi che non deve iniziare.</p>
<p>Resta anche il caso in cui riesce solo la prima metà.</p>
<p>Se la morte viene salvata e l’annullamento delle sedute future fallisce, la registrazione della morte resta. Il sistema restituisce un errore esplicito. Non segnala il successo dell’intera operazione.</p>
<p>Un fatto clinico salvato e i passi successivi portati a termine sono due cose distinte. Quando lo stato di un paziente cambia, una parte del lavoro che segue deve fermarsi. Se si completa solo metà del percorso, deve restare visibile ciò che è riuscito.</p>
<p>Nel software clinico la qualità del prodotto sta in questi passaggi quanto nelle schermate principali. Quando le circostanze cambiano, il prodotto deve tenere ciò che il dato registrato significa.</p>
<p><em>È la descrizione di una regola nel software, non una procedura per la morte di un paziente in cura.</em></p>

HTML,
        ],
        'uk' => [
            'title' => 'Цього тижня варто говорити про правило скасування.',
            'image_alt' => 'Чоловік у темно-фіолетовій сорочці сидить збоку за столом. Вертикальна фіолетова смуга ділить монітор. Ліворуч світять бірюзові рядки, праворуч вони блідіші, і один ламається. Від підставки спадає бірюзовий слід на закритий зошит.',
            'excerpt' => '13 жовтня 2026 року у випуску v0.17.181 я додав до Arenibus правила на випадок запису смерті. Система скасовує заплановані, ще не розпочаті діалізи після цієї дати, записує причину і залишає слід перевірки. Нову програму і нове призначення для пацієнта, записаного як померлий, відхиляє. Якщо скасування сеансів не вдається, смерть лишається збереженою, а система повертає явну помилку.',
            'content' => <<<'HTML'
<p>13 жовтня 2026 року у випуску <strong>v0.17.181</strong> я додав до <a href="https://arenibus.polascin.net/">Arenibus</a> правила, які спрацьовують, коли зафіксовано смерть пацієнта. Arenibus є програмою, яку я пишу для нефрології та діалізу.</p>
<p>Коли смерть збережено, система скасовує заплановані сеанси діалізу, які ще не почалися і дата яких пізніша за дату смерті. До скасування вона записує причину і залишає слід перевірки.</p>
<p>Новий запис до діалізної програми і нове призначення для пацієнта, якого ведуть як померлого, вона відхиляє.</p>
<p>Це тихі правила. Одна частина системи вже має смерть у записі. Інша тому не має далі планувати діаліз, який не повинен початися.</p>
<p>Лишається і випадок, коли вдається лише перша половина.</p>
<p>Якщо смерть збережено, а скасування майбутніх сеансів не вдалося, запис про смерть лишається. Система повертає явну помилку. Вона не повідомляє про успіх усієї операції.</p>
<p>Збережений клінічний факт і завершені наступні кроки є двома речами. Коли стан пацієнта змінюється, частина подальшої роботи має зупинитися. Якщо завершується лише половина ходу, має лишатися видимим, що вдалося.</p>
<p>Якість клінічної програми є в цих переходах так само, як на головних екранах. Коли обставини змінюються, продукт має втримати те, що означає записаний факт.</p>
<p><em>Це опис правила в програмі, а не порядок дій у разі смерті пацієнта під час лікування.</em></p>

HTML,
        ],
    ],
];
