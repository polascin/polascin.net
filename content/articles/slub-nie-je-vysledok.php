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

/** Editorial essay; anonymised model examples where explicitly stated. */
return [
    'slug' => 'slub-nie-je-vysledok',
    'author' => 'MUDr. Ľubomír Polaščín',
    'category' => 'blog',
    'is_top' => 0,
    'published_at' => '2026-11-21 08:00:00',
    'image' => 'images/articles/slub-nie-je-vysledok.webp',
    'translations' => [
        'sk' => [
            'title' => 'Bunky sa v reklame prebúdzajú. Kde sú výsledky?',
            'image_alt' => 'Sklenený hranol, lupa a otvorený zápisník na fialovom stole.',
            'excerpt' => 'Vedecké slová môžu vysvetľovať, ale aj zastierať. Pri zdravotnom prísľube ma zaujíma, čo sa preukázateľne zmenilo pre človeka.',
            'content' => <<<'HTML'
<p>Predstavme si ponuku prístroja za niekoľko stoviek eur. Sľubuje obnovu buniek, viac energie a silnejšiu obranyschopnosť. O odsek nižšie však predajný text uvádza, že prístroj nie je určený na liečbu. Celá situácia je vymysleným príkladom, nie opisom konkrétneho výrobku alebo predajcu.</p>
<p>Na takej ponuke môže najviac presvedčiť práve vysvetlenie. Znie odborne, dá sa zopakovať pri večeri a vytvára pocit, že rozumieme tomu, za čo platíme. Medzi príbehom o mechanizme a výsledkom pre pacienta však zostáva medzera.</p>
<p>Výskum určitej frekvencie ešte neoveruje konkrétny prístroj. Zmena laboratórneho ukazovateľa sama nehovorí, či sa človek cíti lepšie alebo má menej komplikácií. Ani nadšený ohlas zákazníka neoddelí účinok zariadenia od očakávania a súbežnej liečby.</p>
<p>Pýtal by som si štúdiu práve toho výrobku: u koho sa skúšal, s čím sa porovnával, čo sa meralo a aké nežiaduce účinky sa sledovali. Ak údaje chýbajú, výsledok zostáva nepreukázaný. To nie je dôkaz neúčinnosti, ale ani dôvod hovoriť o potvrdenom prínose.</p>
<p>Na papierik pre blízkeho by som napísal tri riadky: Čo sľubujú? Čím to dokazujú? Čo riskujem, ak tomu uverím? Také otázky sa dajú položiť aj bez zosmiešňovania človeka, ktorý dúfa.</p>
<p>Inovácii tieto otázky neublížia. Dobrému výrobku pomôžu vystúpiť z davu pekných príbehov.</p>
<p><em>Vzdelávacia úvaha, nie hodnotenie konkrétneho výrobku ani individuálne liečebné odporúčanie. Príklad nepredstavuje vlastné testovanie zariadenia.</em></p>
<p><small><em>NCCIH. <a href="https://www.nccih.nih.gov/health/be-an-informed-consumer">Be an Informed Consumer</a>.</em></small></p>

HTML,
        ],
        'en' => [
            'title' => 'Advertising wakes up cells. Where are the results?',
            'image_alt' => 'A glass prism, magnifying glass and open notebook on a violet desk.',
            'excerpt' => 'Scientific language can explain or obscure. When a product promises better health, I want to know what benefit has actually been demonstrated.',
            'content' => <<<'HTML'
<p>Imagine an offer for a device costing several hundred euros. It promises cellular renewal, more energy and stronger immunity. A paragraph later, however, the sales copy says the device is not intended for treatment. This entire scenario is fictional; it does not describe a particular product or seller.</p>
<p>The explanation may be the most persuasive part of the offer. It sounds scientific and gives us the feeling that we understand what we are buying. Yet a gap remains between a story about a mechanism and a patient benefit.</p>
<p>Research on a frequency does not validate a particular device. A change in a laboratory measurement alone does not establish that someone feels better or has fewer complications. A satisfied customer's account cannot separate the device's effect from expectations and concurrent treatment.</p>
<p>I would ask for a study of the exact product: who participated, what the comparison was, what was measured and which adverse effects were monitored. Missing evidence means the benefit remains unproven. It proves neither ineffectiveness nor effectiveness.</p>
<p>For someone close to me, I would write three lines: What is promised? What supports it? What do I risk by believing it? Without shaming anyone for hoping.</p>
<p>These questions do innovation no harm. They help a good product stand apart from attractive stories.</p>
<p><em>An educational reflection, not an assessment of a specific product or individual treatment advice. The example does not describe personal testing.</em></p>
<p><small><em>NCCIH. <a href="https://www.nccih.nih.gov/health/be-an-informed-consumer">Be an Informed Consumer</a>.</em></small></p>

HTML,
        ],
        'cs' => [
            'title' => 'V reklamě se buňky probouzejí. Kde jsou výsledky?',
            'image_alt' => 'Skleněný hranol, lupa a otevřený zápisník na fialovém stole.',
            'excerpt' => 'Vědecká slova mohou vysvětlovat i zastírat. U zdravotního příslibu mě zajímá, co se prokazatelně změnilo pro člověka.',
            'content' => <<<'HTML'
<p>Představme si nabídku přístroje za několik stovek eur. Slibuje obnovu buněk, více energie a silnější obranyschopnost. O odstavec níže však prodejní text uvádí, že přístroj není určen k léčbě. Celá situace je smyšleným příkladem, nikoli popisem konkrétního výrobku nebo prodejce.</p>
<p>Na takové nabídce může nejvíc přesvědčit právě vysvětlení. Zní odborně a vytváří pocit, že rozumíme tomu, za co platíme. Mezi příběhem o mechanismu a přínosem pro pacienta však zůstává mezera.</p>
<p>Výzkum určité frekvence neověřuje konkrétní přístroj. Změna laboratorního ukazatele sama neříká, zda se člověk cítí lépe nebo má méně komplikací. Ani spokojený zákazník neoddělí účinek zařízení od očekávání a souběžné léčby.</p>
<p>Vyžádal bych si studii právě toho výrobku: u koho se zkoušel, s čím se porovnával, co se měřilo a jaké nežádoucí účinky se sledovaly. Bez údajů zůstává přínos neprokázaný. Není to důkaz neúčinnosti ani potvrzení účinku.</p>
<p>Blízkému člověku bych napsal tři řádky: Co slibují? Čím to dokazují? Co riskuji, když tomu uvěřím? Bez zesměšňování člověka, který doufá.</p>
<p>Inovaci tyto otázky neublíží. Dobrému výrobku pomohou vyniknout mezi pěknými příběhy.</p>
<p><em>Vzdělávací úvaha, nikoli hodnocení konkrétního výrobku či individuální léčebné doporučení. Příklad nepopisuje vlastní testování.</em></p>
<p><small><em>NCCIH. <a href="https://www.nccih.nih.gov/health/be-an-informed-consumer">Be an Informed Consumer</a>.</em></small></p>

HTML,
        ],
        'de' => [
            'title' => 'In der Werbung erwachen Zellen. Wo sind die Ergebnisse?',
            'image_alt' => 'Ein Glasprisma, eine Lupe und ein offenes Notizbuch auf einem violetten Tisch.',
            'excerpt' => 'Wissenschaftliche Begriffe können erklären oder verschleiern. Bei Gesundheitsversprechen interessiert mich, was sich für einen Menschen nachweislich verbessert hat.',
            'content' => <<<'HTML'
<p>Stellen wir uns ein Angebot für ein Gerät vor, das mehrere Hundert Euro kostet. Es verspricht Zellerneuerung, mehr Energie und stärkere Abwehrkräfte. Einen Absatz später heißt es im Verkaufstext jedoch, das Gerät sei nicht zur Behandlung bestimmt. Das gesamte Beispiel ist erfunden und beschreibt weder ein bestimmtes Produkt noch einen bestimmten Anbieter.</p>
<p>Am überzeugendsten an diesem Angebot ist womöglich die Erklärung. Sie klingt wissenschaftlich und vermittelt das Gefühl, den Kauf zu verstehen. Zwischen einem Wirkmechanismus und einem Nutzen für Patienten bleibt jedoch eine Lücke.</p>
<p>Forschung zu einer bestimmten Frequenz belegt noch nicht den Nutzen eines konkreten Geräts. Ein veränderter Laborwert allein zeigt nicht, ob es jemandem besser geht oder weniger Komplikationen auftreten. Zufriedene Kundenberichte trennen Wirkung, Erwartungen und begleitende Behandlung nicht voneinander.</p>
<p>Ich würde eine Studie zum konkreten Produkt verlangen: mit welchen Teilnehmern, welchem Vergleich, welchen Endpunkten und welchen erfassten Nebenwirkungen? Fehlen Daten, bleibt der Nutzen unbelegt. Das beweist weder Unwirksamkeit noch Wirksamkeit.</p>
<p>Für einen nahestehenden Menschen würde ich drei Zeilen notieren: Was wird versprochen? Was belegt es? Was riskiere ich, wenn ich es glaube? Ohne jemanden für seine Hoffnung bloßzustellen.</p>
<p>Der Innovation schaden diese Fragen nicht. Ein gutes Produkt kann sich damit von schönen Geschichten abheben.</p>
<p><em>Eine aufklärende Betrachtung, keine Bewertung eines konkreten Produkts oder individuelle Therapieempfehlung. Das Beispiel beschreibt keinen eigenen Gerätetest.</em></p>
<p><small><em>NCCIH. <a href="https://www.nccih.nih.gov/health/be-an-informed-consumer">Be an Informed Consumer</a>.</em></small></p>

HTML,
        ],
        'fr' => [
            'title' => 'La publicité réveille les cellules. Où sont les résultats ?',
            'image_alt' => 'Un prisme de verre, une loupe et un carnet ouvert sur une table violette.',
            'excerpt' => 'Les mots scientifiques peuvent éclairer ou masquer. Face à une promesse de santé, je veux savoir ce qui a réellement changé pour une personne.',
            'content' => <<<'HTML'
<p>Imaginons une offre pour un appareil coûtant plusieurs centaines d'euros. Elle promet le renouvellement cellulaire, davantage d'énergie et de meilleures défenses immunitaires. Un paragraphe plus loin, le texte précise pourtant que l'appareil n'est pas destiné à traiter des maladies. Toute cette situation est fictive ; elle ne décrit aucun produit ni vendeur particulier.</p>
<p>L'explication pourrait être la partie la plus convaincante de cette offre. Elle paraît savante et nous donne l'impression de comprendre notre achat. Pourtant, la description d'un mécanisme ne suffit pas à établir un bénéfice pour le patient.</p>
<p>Des recherches sur une fréquence donnée ne démontrent pas le bénéfice d'un appareil particulier. Une variation biologique ne démontre pas à elle seule un mieux-être ou moins de complications. Un témoignage satisfait ne distingue pas l'effet du dispositif des attentes et des traitements associés.</p>
<p>Je demanderais une étude du produit exact : chez qui, avec quel comparateur, quels critères et quels effets indésirables surveillés ? Sans données, le bénéfice reste non démontré. Cela ne prouve ni l'inefficacité ni l'efficacité.</p>
<p>Pour un proche, j'écrirais trois lignes : Que promet-on ? Quelles preuves ? Que risque-t-on à y croire ? Sans ridiculiser celui qui espère.</p>
<p>Ces questions ne nuisent pas à l'innovation. Elles aident un bon produit à se distinguer des belles histoires.</p>
<p><em>Réflexion pédagogique, sans évaluation d'un produit particulier ni conseil thérapeutique individuel. Cet exemple ne décrit aucun essai personnel.</em></p>
<p><small><em>NCCIH. <a href="https://www.nccih.nih.gov/health/be-an-informed-consumer">Be an Informed Consumer</a>.</em></small></p>

HTML,
        ],
        'es' => [
            'title' => 'La publicidad despierta las células. ¿Dónde están los resultados?',
            'image_alt' => 'Un prisma de cristal, una lupa y un cuaderno abierto sobre una mesa violeta.',
            'excerpt' => 'Las palabras científicas pueden explicar u ocultar. Ante una promesa de salud, quiero saber qué ha cambiado de forma demostrable para una persona.',
            'content' => <<<'HTML'
<p>Imaginemos una oferta de un aparato que cuesta varios cientos de euros. Promete renovación celular, más energía y mejores defensas. Un párrafo después, sin embargo, el texto de venta indica que el aparato no está destinado a tratar enfermedades. Toda la situación es ficticia; no describe ningún producto ni vendedor concreto.</p>
<p>La explicación podría ser la parte más convincente de la oferta. Suena científica y nos hace sentir que entendemos lo que compramos. Sin embargo, entre un mecanismo y un beneficio para el paciente queda un vacío.</p>
<p>Investigar una frecuencia no valida un aparato concreto. Un cambio en un parámetro de laboratorio no demuestra por sí solo que alguien se encuentre mejor o tenga menos complicaciones. Un testimonio satisfecho no separa el efecto del aparato de las expectativas y los tratamientos simultáneos.</p>
<p>Pediría un estudio del producto exacto: en quiénes se probó, con qué se comparó, qué se midió y qué efectos adversos se vigilaron. Sin datos, el beneficio sigue sin demostrarse. Eso no prueba ni ineficacia ni eficacia.</p>
<p>Para alguien cercano escribiría tres líneas: ¿Qué prometen? ¿Qué lo demuestra? ¿Qué arriesgo al creerlo? Sin ridiculizar a quien tiene esperanza.</p>
<p>Estas preguntas no perjudican a la innovación. Ayudan a un buen producto a distinguirse de las historias atractivas.</p>
<p><em>Reflexión educativa, no evaluación de un producto concreto ni recomendación terapéutica individual. El ejemplo no describe pruebas propias.</em></p>
<p><small><em>NCCIH. <a href="https://www.nccih.nih.gov/health/be-an-informed-consumer">Be an Informed Consumer</a>.</em></small></p>

HTML,
        ],
        'pl' => [
            'title' => 'Reklama budzi komórki. Gdzie są wyniki?',
            'image_alt' => 'Szklany pryzmat, lupa i otwarty notes na fioletowym stole.',
            'excerpt' => 'Naukowe słowa mogą wyjaśniać albo zaciemniać. Przy obietnicy zdrowotnej interesuje mnie to, co rzeczywiście zmieniło się dla człowieka.',
            'content' => <<<'HTML'
<p>Wyobraźmy sobie ofertę urządzenia za kilkaset euro. Obiecuje odnowę komórek, więcej energii i lepszą odporność. Akapit dalej tekst sprzedażowy zaznacza jednak, że urządzenie nie jest przeznaczone do leczenia. Cała sytuacja jest fikcyjnym przykładem, a nie opisem konkretnego produktu lub sprzedawcy.</p>
<p>Najbardziej przekonującą częścią oferty może być wyjaśnienie. Brzmi naukowo i daje poczucie, że rozumiemy, za co płacimy. Między opowieścią o mechanizmie a korzyścią dla pacjenta pozostaje jednak luka.</p>
<p>Badanie określonej częstotliwości nie potwierdza działania konkretnego urządzenia. Zmiana parametru laboratoryjnego sama nie dowodzi poprawy samopoczucia ani mniejszej liczby powikłań. Zadowolony klient nie oddzieli działania sprzętu od oczekiwań i równoległego leczenia.</p>
<p>Poprosiłbym o badanie dokładnie tego produktu: u kogo, z jakim porównaniem, co mierzono i jakie działania niepożądane obserwowano? Bez danych korzyść pozostaje nieudowodniona. Nie dowodzi to ani nieskuteczności, ani skuteczności.</p>
<p>Bliskiej osobie napisałbym trzy zdania: Co obiecują? Czym to potwierdzają? Co ryzykuję, jeśli uwierzę? Bez wyśmiewania nadziei.</p>
<p>Te pytania nie szkodzą innowacji. Pomagają dobremu produktowi wyróżnić się spośród pięknych historii.</p>
<p><em>Refleksja edukacyjna, nie ocena konkretnego produktu ani indywidualna porada terapeutyczna. Przykład nie opisuje własnych testów.</em></p>
<p><small><em>NCCIH. <a href="https://www.nccih.nih.gov/health/be-an-informed-consumer">Be an Informed Consumer</a>.</em></small></p>

HTML,
        ],
        'hu' => [
            'title' => 'A reklám felébreszti a sejteket. Hol vannak az eredmények?',
            'image_alt' => 'Üvegprizma, nagyító és nyitott jegyzetfüzet egy lila asztalon.',
            'excerpt' => 'A tudományos szavak magyarázhatnak, de el is fedhetnek valamit. Egészségügyi ígéretnél az érdekel, mi változott bizonyíthatóan az ember számára.',
            'content' => <<<'HTML'
<p>Képzeljünk el egy több száz euróba kerülő készüléket kínáló ajánlatot. Sejtmegújulást, több energiát és erősebb immunvédelmet ígér. Egy bekezdéssel később azonban az értékesítési szöveg közli, hogy a készülék nem kezelésre szolgál. Az egész helyzet kitalált példa, nem egy konkrét termék vagy eladó leírása.</p>
<p>Az ajánlat legmeggyőzőbb része talán éppen a magyarázat. Tudományosnak hangzik, és azt érezteti, hogy értjük, mit kapunk a pénzünkért. A működési elv leírása és a beteg számára jelentkező előny között mégis rés marad.</p>
<p>Egy frekvencia kutatása nem igazol egy konkrét készüléket. A laborérték változása önmagában nem bizonyít jobb közérzetet vagy kevesebb szövődményt. Az elégedett beszámoló nem választja el a készülék hatását a várakozásoktól és az egyidejű kezeléstől.</p>
<p>Az adott termék vizsgálatát kérném: kinél, mivel összehasonlítva, milyen végpontokkal és milyen mellékhatások megfigyelésével? Adatok nélkül az előny bizonyítatlan. Ez sem hatástalanságot, sem hatásosságot nem bizonyít.</p>
<p>Egy hozzátartozómnak három sort írnék: Mit ígérnek? Mi bizonyítja? Mit kockáztatok, ha elhiszem? A reménykedő ember kigúnyolása nélkül.</p>
<p>Ezek a kérdések nem ártanak az innovációnak. Segítenek a jó terméknek kitűnni a szép történetek közül.</p>
<p><em>Ismeretterjesztő gondolatmenet, nem termékértékelés vagy egyéni kezelési tanács. A példa nem saját készüléktesztet ír le.</em></p>
<p><small><em>NCCIH. <a href="https://www.nccih.nih.gov/health/be-an-informed-consumer">Be an Informed Consumer</a>.</em></small></p>

HTML,
        ],
        'it' => [
            'title' => 'La pubblicità risveglia le cellule. Dove sono i risultati?',
            'image_alt' => 'Un prisma di vetro, una lente e un taccuino aperto su un tavolo viola.',
            'excerpt' => 'Le parole scientifiche possono spiegare o nascondere. Davanti a una promessa di salute, voglio sapere che cosa sia cambiato davvero per una persona.',
            'content' => <<<'HTML'
<p>Immaginiamo un'offerta per un apparecchio da alcune centinaia di euro. Promette rinnovamento cellulare, più energia e difese migliori. Un paragrafo dopo, però, il testo di vendita precisa che l'apparecchio non è destinato a curare malattie. L'intera situazione è inventata e non descrive un prodotto o un venditore specifico.</p>
<p>La spiegazione potrebbe essere la parte più convincente dell'offerta. Sembra scientifica e ci dà l'impressione di capire l'acquisto. Tra il racconto di un meccanismo e un beneficio per il paziente resta però uno spazio vuoto.</p>
<p>Studiare una frequenza non convalida un apparecchio specifico. La variazione di un parametro di laboratorio non dimostra da sola un miglioramento del benessere o meno complicanze. Un cliente soddisfatto non distingue l'effetto del dispositivo dalle aspettative e dalle cure concomitanti.</p>
<p>Chiederei uno studio del prodotto esatto: su chi, rispetto a che cosa, con quali esiti e quali effetti avversi monitorati? Senza dati, il beneficio resta non dimostrato. Questo non prova né inefficacia né efficacia.</p>
<p>A una persona cara scriverei tre righe: Che cosa promettono? Che cosa lo dimostra? Che cosa rischio se ci credo? Senza deridere chi spera.</p>
<p>Queste domande non danneggiano l'innovazione. Aiutano un buon prodotto a distinguersi dalle belle storie.</p>
<p><em>Riflessione educativa, non valutazione di un prodotto specifico né consiglio terapeutico individuale. L'esempio non descrive prove personali.</em></p>
<p><small><em>NCCIH. <a href="https://www.nccih.nih.gov/health/be-an-informed-consumer">Be an Informed Consumer</a>.</em></small></p>

HTML,
        ],
        'uk' => [
            'title' => 'У рекламі клітини прокидаються. Де результати?',
            'image_alt' => 'Скляна призма, лупа й відкритий записник на фіолетовому столі.',
            'excerpt' => 'Наукові слова можуть пояснювати або приховувати. Коли обіцяють поліпшення здоров’я, мене цікавить, яку користь для людини справді доведено.',
            'content' => <<<'HTML'
<p>Уявімо пропозицію пристрою за кілька сотень євро. Вона обіцяє оновлення клітин, більше енергії та міцніший імунітет. Абзацом нижче, однак, у рекламному тексті зазначено, що пристрій не призначений для лікування. Уся ситуація вигадана й не описує конкретного виробу чи продавця.</p>
<p>Найпереконливішою частиною пропозиції може бути саме пояснення. Воно звучить науково й дає відчуття, що ми розуміємо, за що платимо. Але між розповіддю про механізм і користю для пацієнта залишається прогалина.</p>
<p>Дослідження певної частоти не підтверджує дієвість конкретного пристрою. Зміна лабораторного показника сама не доводить кращого самопочуття чи меншої кількості ускладнень. Задоволений відгук не відокремлює дію пристрою від очікувань і супутнього лікування.</p>
<p>Я попросив би дослідження саме цього виробу: на кому, з чим порівнювали, що вимірювали та які небажані явища відстежували? Без даних користь залишається недоведеною. Це не доказ ані неефективності, ані ефективності.</p>
<p>Близькій людині я написав би три рядки: Що обіцяють? Чим доводять? Чим я ризикую, якщо повірю? Без висміювання того, хто сподівається.</p>
<p>Ці запитання не шкодять інноваціям. Вони допомагають доброму виробу вирізнитися серед гарних історій.</p>
<p><em>Освітній роздум, а не оцінка конкретного виробу чи індивідуальна лікувальна порада. Приклад не описує власного випробування пристрою.</em></p>
<p><small><em>NCCIH. <a href="https://www.nccih.nih.gov/health/be-an-informed-consumer">Be an Informed Consumer</a>.</em></small></p>

HTML,
        ],
    ],
];
