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
 * Authority príspevok: 12 otázok pred nasadením AI recepčnej.
 * Zdroj: ponuka TOMMAX (Martin Koch) cez Branislava Halandu (IMPAX) 16. 9. 2026
 * a vlastná analýza s 12 vetting otázkami (preposlané 17. 9. 2026).
 */
return [
    'slug' => 'ai-recepcna-dvanast-otazok',
    'author' => 'MUDr. Ľubomír Polaščín',
    'category' => 'blog',
    'is_top' => 0,
    'published_at' => '2026-09-24 16:45:00',
    'image' => 'images/articles/ai-recepcna-dvanast-otazok.webp',
    'translations' => [
        'sk' => [
            'title' => 'Dodávateľ nám ponúkol AI recepčnú s plynulou slovenčinou. Namiesto podpisu som napísal 12 otázok.',
            'image_alt' => 'Nočná recepcia nefrologickej ambulancie: lekár prezerá checklist, vedľa bliká nezdvihnutý telefón a jemné tyrkysovo-fialové svetlo hlasového rozhrania.',
            'excerpt' => 'Ponuka sľubovala zachytiť 30 % neprijatých hovorov a stotisíc eur ročne. Pri hĺbkovom pohľade chýbali fallback, eskalácia núdze a dohoda podľa GDPR čl. 9. Preto som napísal dvanásť otázok a navrhol dvojtýždňový pilot.',
            'content' => <<<'HTML'
<p>Dodávateľ nám ponúkol AI recepčnú, ktorá má hovoriť plynule po slovensky. Namiesto podpisu som napísal dvanásť otázok.</p>
<p>Ponuku AI-Recepčnej som dostal cez Branislava Halandu z IMPAX — od Martina Kocha z TOMMAX. Na papieri vyzerala pôsobivo: zachytiť približne 30&nbsp;% neprijatých hovorov, plynulá slovenčina a podľa potreby čeština, nemčina, maďarčina či angličtina, návratnosť často do mesiaca a odhadovaný ročný prínos na tržbách nad 100&nbsp;tisíc eur.</p>
<p>Keď som sa však pozrel podrobnejšie, začali sa ukazovať medzery.</p>
<p>Slovenčina patrí medzi jazyky s menším objemom trénovacích dát pre hlasové modely — tzv. <em>lower-resource</em>. Marketingová „plynulosť“ preto nemusí sedieť s medicínskou konverzáciou so staršími pacientmi, ktorí hovoria dialektom, robia pauzy uprostred vety alebo opisujú príznaky oklukou.</p>
<p>V materiáloch som nenašiel jasný fallback ani eskalačný protokol pre bolesť na hrudníku či dýchavičnosť. Chýbali aj certifikácie, ktoré v USA bežne uvádzajú healthcare voice hráči (HIPAA, SOC&nbsp;2, BAA) — tie však pre slovenskú ambulanciu nie sú záväzným rámcom. Pre nás je kľúčová dohoda o spracúvaní osobitných kategórií podľa <a href="https://gdpr-info.eu/art-9-gdpr/">GDPR čl.&nbsp;9</a> a jasné miesto hostingu či prenosu. Case studies v ponuke — TYMO Beauty a Manhattan Dental Studio — nie sú nefrológia na Slovensku.</p>
<p>Preto som napísal dvanásť otázok pre dodávateľa:</p>
<ol>
<li>Aký je presný eskalačný protokol, keď pacient povie „chcem hovoriť s človekom“ alebo „to je núdzový prípad“?</li>
<li>Čo sa stane, keď AI nedokáže odpovedať a nikto z personálu nie je dostupný (po hodinách, cez víkend)?</li>
<li>Je transfer „warm“ (s kontextom) alebo „cold“ (pacient musí opakovať)?</li>
<li>Ako zaobchádzate so zdravotnými dátami v zmysle GDPR čl.&nbsp;9? Máte podpísaný DPA? Kde stoja servery a transkripty?</li>
<li>Aké certifikácie máte (SOC&nbsp;2, ISO&nbsp;27001, alebo ekvivalent)?</li>
<li>Aká je konkrétna mesačná cena? Koľko minút je zahrnutých? Koľko stojí minúta navyše?</li>
<li>Máte reálnu referenciu zo slovenskej alebo českej ambulancie (nie zubná klinika v Manhattane)?</li>
<li>Aké jazyky sú production-grade a aké len „claimed-support“? Môžete ukázať transkripty reálnych hovorov v slovenčine?</li>
<li>Ako sa testuje kvalita slovenčiny? Máte native-speaker QA pre slovenčinu, češtinu, maďarčinu?</li>
<li>Čo sa stane, keď pacient popisuje príznaky (bolesť na hrudníku, dýchavičnosť)? Rozpozná AI núdzu a nasmeruje na 155?</li>
<li>Môžeme spustiť 2-týždňový pilot na sekundárnom čísle predtým, ako presmerujeme hlavnú linku?</li>
<li>Kto technicky stojí za AI enginom? Používate vlastný model, alebo Vapi/Retell/inú platformu?</li>
</ol>
<p>Navrhli sme dvojtýždňový pilot na sekundárnej linke. Ak dodávateľ odpovie na všetkých dvanásť, testujeme. Ak nie, nejdeme ďalej. Otázky som poslal Halandovi; ten ich 17.&nbsp;9.&nbsp;2026 preposlal dodávateľovi.</p>
<p>Americkí poskytovatelia zameraní na zdravotníctvo — napríklad Ona Health, Hello Patient, Talkie.ai či Arini — na svojich stránkach uvádzajú HIPAA, SOC&nbsp;2 a BAA. To je relevantný signál o vyspelosti produktu, nie však náhrada za európsku DPA. AI v klinike nie je o tom, kto je prvý. Je o tom, či je systém dosť bezpečný, aby pacient, ktorý volá o druhej v noci s bolesťou na hrudníku, dostal správnu odpoveď.</p>
<p>Ak hodnotíte AI nástroje pre ambulanciu — čo máte na svojom checkliste? Napíšte mi cez <a href="contact.php">kontakt</a>.</p>
<p><em>Ide o odborný úsudok autora pri hodnotení ponuky pre ambulanciu, nie o recenziu produktu pre pacientov ani o radu volajúcim v núdzi. Pri akútnych príznakoch volajte 155/112.</em></p>
HTML,
        ],
        'en' => [
            'title' => 'A vendor pitched us an AI receptionist with fluent Slovak. I wrote twelve questions instead of signing.',
            'image_alt' => 'Night-time nephrology clinic reception: a physician reviews a checklist beside an unanswered phone and a soft teal-purple glow of a voice interface.',
            'excerpt' => 'The pitch promised to catch 30% of missed calls and a hundred thousand euros a year. Digging deeper, fallback, emergency escalation, and a GDPR Art. 9 agreement were missing. So I wrote twelve questions and proposed a two-week pilot.',
            'content' => <<<'HTML'
<p>A vendor pitched our clinic an AI receptionist that speaks fluent Slovak. I wrote twelve questions instead of signing.</p>
<p>The AI-Receptionist offer reached me via Branislav Halanda at IMPAX — from Martin Koch at TOMMAX. On paper it looked strong: catch roughly 30% of missed calls; fluent Slovak and, as needed, Czech, German, Hungarian, or English; ROI often within a month; and an estimated annual revenue uplift above €100,000.</p>
<p>When I dug in, the gaps appeared.</p>
<p>Slovak is a lower-resource language for voice models — less training data than English or German. Marketing “fluency” therefore may not match medical conversations with elderly patients who use dialect, pause mid-sentence, or describe symptoms in roundabout ways.</p>
<p>I found no clear fallback and no escalation protocol for chest pain or shortness of breath. The pitch also did not present the certifications US healthcare voice vendors often advertise (HIPAA, SOC&nbsp;2, BAA) — those are US instruments, not what binds a Slovak clinic. What matters here is a processing agreement for special categories under <a href="https://gdpr-info.eu/art-9-gdpr/">GDPR Art.&nbsp;9</a>, plus clear hosting and transfer. The case studies on offer — TYMO Beauty and Manhattan Dental Studio — are not nephrology in Slovakia.</p>
<p>So I wrote twelve questions for the vendor:</p>
<ol>
<li>What is the exact escalation protocol when a patient says “I want to talk to a human” or “this is an emergency”?</li>
<li>What happens when the AI cannot answer and no staff member is available (after hours, weekends)?</li>
<li>Is the transfer “warm” (with context) or “cold” (the patient must repeat)?</li>
<li>How do you handle health data under GDPR Art.&nbsp;9? Do you have a signed DPA? Where are servers and transcripts hosted?</li>
<li>What certifications do you hold (SOC&nbsp;2, ISO&nbsp;27001, or equivalent)?</li>
<li>What is the concrete monthly price? How many minutes are included? What does an extra minute cost?</li>
<li>Do you have a real reference from a Slovak or Czech outpatient clinic (not a Manhattan dental studio)?</li>
<li>Which languages are production-grade and which are only “claimed support”? Can you show transcripts of real Slovak calls?</li>
<li>How is Slovak quality tested? Do you have native-speaker QA for Slovak, Czech, and Hungarian?</li>
<li>What happens when a patient describes symptoms (chest pain, dyspnea)? Does the AI recognise an emergency and direct them to 155?</li>
<li>Can we run a two-week pilot on a secondary number before we redirect the main line?</li>
<li>Who technically powers the AI engine? Do you use your own model, or Vapi/Retell/another platform?</li>
</ol>
<p>We proposed a two-week pilot on a secondary line. If the vendor answers all twelve, we test. If not, we do not. I sent the questions to Halanda; on 17&nbsp;September&nbsp;2026 he forwarded them to the vendor.</p>
<p>US healthcare-focused providers — for example Ona Health, Hello Patient, Talkie.ai, or Arini — state HIPAA, SOC&nbsp;2, and BAA on their sites. That is a maturity signal, not a substitute for a European DPA. AI in a clinic is not about being first. It is about being safe enough that the patient who calls at 2&nbsp;a.m. with chest pain gets the right response.</p>
<p>If you evaluate AI tools for a clinical setting — what is on your checklist? Write to me via the <a href="contact.php">contact form</a>.</p>
<p><em>This is the author’s professional judgement when assessing a clinic vendor offer, not a product review for patients and not advice for callers in distress. For acute symptoms, call 155/112.</em></p>
HTML,
        ],
        'cs' => [
            'title' => 'Dodavatel nám nabídl AI recepční s plynulou slovenštinou. Místo podpisu jsem napsal 12 otázek.',
            'image_alt' => 'Noční recepce nefrologické ambulance: lékař prohlíží checklist, vedle bliká nezvednutý telefon a jemné tyrkysovo-fialové světlo hlasového rozhraní.',
            'excerpt' => 'Nabídka slibovala zachytit 30 % nepřijatých hovorů a sto tisíc eur ročně. Při hlubším pohledu chyběly fallback, eskalace nouze a dohoda podle GDPR čl. 9. Proto jsem napsal dvanáct otázek a navrhl dvoutýdenní pilot.',
            'content' => <<<'HTML'
<p>Dodavatel nám nabídl AI recepční, která má mluvit plynule slovensky. Místo podpisu jsem napsal dvanáct otázek.</p>
<p>Nabídku AI-Recepční jsem dostal přes Branislava Halandu z IMPAX — od Martina Kocha z TOMMAX. Na papíře vypadala působivě: zachytit přibližně 30&nbsp;% nepřijatých hovorů, plynulá slovenština a podle potřeby čeština, němčina, maďarština či angličtina, návratnost často do měsíce a odhadovaný roční přínos na tržbách nad 100&nbsp;tisíc eur.</p>
<p>Když jsem se však podíval podrobněji, začaly se ukazovat mezery.</p>
<p>Slovenština patří mezi jazyky s menším objemem trénovacích dat pro hlasové modely — tzv. <em>lower-resource</em>. Marketingová „plynulost“ proto nemusí sedět s medicínskou konverzací se staršími pacienty, kteří mluví dialektem, dělají pauzy uprostřed věty nebo popisují příznaky oklikou.</p>
<p>V materiálech jsem nenašel jasný fallback ani eskalační protokol pro bolest na hrudi či dušnost. Chyběly i certifikace, které v USA běžně uvádějí healthcare voice hráči (HIPAA, SOC&nbsp;2, BAA) — ty však pro slovenskou ambulanci nejsou závazným rámcem. Pro nás je klíčová dohoda o zpracování zvláštních kategorií podle <a href="https://gdpr-info.eu/art-9-gdpr/">GDPR čl.&nbsp;9</a> a jasné místo hostingu či přenosu. Case studies v nabídce — TYMO Beauty a Manhattan Dental Studio — nejsou nefrologie na Slovensku.</p>
<p>Proto jsem napsal dvanáct otázek pro dodavatele:</p>
<ol>
<li>Jaký je přesný eskalační protokol, když pacient řekne „chci mluvit s člověkem“ nebo „tohle je nouzový případ“?</li>
<li>Co se stane, když AI nedokáže odpovědět a nikdo z personálu není dostupný (po hodinách, o víkendu)?</li>
<li>Je transfer „warm“ (s kontextem), nebo „cold“ (pacient musí opakovat)?</li>
<li>Jak zacházíte se zdravotními daty ve smyslu GDPR čl.&nbsp;9? Máte podepsané DPA? Kde stojí servery a transkripty?</li>
<li>Jaké certifikace máte (SOC&nbsp;2, ISO&nbsp;27001, nebo ekvivalent)?</li>
<li>Jaká je konkrétní měsíční cena? Kolik minut je zahrnutých? Kolik stojí minuta navíc?</li>
<li>Máte reálnou referenci ze slovenské nebo české ambulance (ne zubní klinika na Manhattanu)?</li>
<li>Jaké jazyky jsou production-grade a jaké jen „claimed-support“? Můžete ukázat transkripty reálných hovorů ve slovenštině?</li>
<li>Jak se testuje kvalita slovenštiny? Máte native-speaker QA pro slovenštinu, češtinu, maďarštinu?</li>
<li>Co se stane, když pacient popisuje příznaky (bolest na hrudi, dušnost)? Rozpozná AI nouzi a nasměruje na 155?</li>
<li>Můžeme spustit 2týdenní pilot na sekundárním čísle dříve, než přesměrujeme hlavní linku?</li>
<li>Kdo technicky stojí za AI enginem? Používáte vlastní model, nebo Vapi/Retell/jinou platformu?</li>
</ol>
<p>Navrhli jsme dvoutýdenní pilot na sekundární lince. Pokud dodavatel odpoví na všech dvanáct, testujeme. Pokud ne, nejdeme dál. Otázky jsem poslal Halandovi; ten je 17.&nbsp;9.&nbsp;2026 přeposlal dodavateli.</p>
<p>Američtí poskytovatelé zaměření na zdravotnictví — například Ona Health, Hello Patient, Talkie.ai či Arini — na svých stránkách uvádějí HIPAA, SOC&nbsp;2 a BAA. To je relevantní signál o vyspělosti produktu, nikoli však náhrada za evropskou DPA. AI na klinice není o tom, kdo je první. Je o tom, zda je systém dost bezpečný, aby pacient, který volá o druhé v noci s bolestí na hrudi, dostal správnou odpověď.</p>
<p>Pokud hodnotíte AI nástroje pro ambulanci — co máte na svém checklistu? Napište mi přes <a href="contact.php">kontakt</a>.</p>
<p><em>Jde o odborný úsudek autora při hodnocení nabídky pro ambulanci, nikoli o recenzi produktu pro pacienty ani o radu volajícím v nouzi. Při akutních příznacích volejte 155/112.</em></p>
HTML,
        ],
        'de' => [
            'title' => 'Ein Anbieter bot uns eine KI-Rezeption mit fließendem Slowakisch an. Statt zu unterschreiben, schrieb ich 12 Fragen.',
            'image_alt' => 'Nächtliche Rezeption einer nephrologischen Praxis: ein Arzt prüft eine Checkliste neben einem unbeantworteten Telefon und einem sanften türkis-violetten Schimmer einer Sprachschnittstelle.',
            'excerpt' => 'Das Angebot versprach, 30 % verpasster Anrufe und hunderttausend Euro im Jahr einzufangen. Bei genauerem Blick fehlten Fallback, Notfalleskalation und eine Vereinbarung nach DSGVO Art. 9. Deshalb schrieb ich zwölf Fragen und schlug einen zweiwöchigen Pilot vor.',
            'content' => <<<'HTML'
<p>Ein Anbieter bot unserer Praxis eine KI-Rezeption an, die fließend Slowakisch sprechen soll. Statt zu unterschreiben, schrieb ich zwölf Fragen.</p>
<p>Das Angebot zur AI-Rezeption erreichte mich über Branislav Halanda von IMPAX — von Martin Koch bei TOMMAX. Auf dem Papier wirkte es stark: etwa 30&nbsp;% verpasster Anrufe auffangen; fließendes Slowakisch und bei Bedarf Tschechisch, Deutsch, Ungarisch oder Englisch; ROI oft innerhalb eines Monats; geschätzter jährlicher Umsatzbeitrag über 100&nbsp;000&nbsp;Euro.</p>
<p>Als ich genauer hinsah, zeigten sich die Lücken.</p>
<p>Slowakisch gehört zu den Sprachen mit weniger Trainingsdaten für Sprachmodelle — sogenannt <em>lower-resource</em>. Marketingmäßige „Flüssigkeit“ muss daher nicht zu medizinischen Gesprächen mit älteren Patientinnen und Patienten passen, die Dialekt sprechen, mitten im Satz pausieren oder Symptome umständlich beschreiben.</p>
<p>In den Unterlagen fand ich keinen klaren Fallback und kein Eskalationsprotokoll für Brustschmerz oder Atemnot. Es fehlten auch Zertifizierungen, die US-Healthcare-Voice-Anbieter oft nennen (HIPAA, SOC&nbsp;2, BAA) — das sind US-Instrumente, nicht der verbindliche Rahmen für eine slowakische Praxis. Für uns zählt eine Verarbeitungsvereinbarung für besondere Kategorien nach <a href="https://gdpr-info.eu/art-9-gdpr/">DSGVO Art.&nbsp;9</a> sowie klarer Hosting- und Transferort. Die Case Studies im Angebot — TYMO Beauty und Manhattan Dental Studio — sind keine Nephrologie in der Slowakei.</p>
<p>Deshalb schrieb ich zwölf Fragen an den Anbieter:</p>
<ol>
<li>Wie lautet das genaue Eskalationsprotokoll, wenn ein Patient sagt „Ich möchte mit einem Menschen sprechen“ oder „Das ist ein Notfall“?</li>
<li>Was passiert, wenn die KI nicht antworten kann und niemand vom Personal erreichbar ist (außerhalb der Stunden, am Wochenende)?</li>
<li>Ist der Transfer „warm“ (mit Kontext) oder „cold“ (der Patient muss wiederholen)?</li>
<li>Wie gehen Sie mit Gesundheitsdaten im Sinne von DSGVO Art.&nbsp;9 um? Haben Sie eine unterzeichnete AVV/DPA? Wo stehen Server und Transkripte?</li>
<li>Welche Zertifizierungen haben Sie (SOC&nbsp;2, ISO&nbsp;27001 oder gleichwertig)?</li>
<li>Wie hoch ist der konkrete Monatspreis? Wie viele Minuten sind enthalten? Was kostet eine Extra-Minute?</li>
<li>Haben Sie eine echte Referenz aus einer slowakischen oder tschechischen Ambulanz (nicht eine Zahnklinik in Manhattan)?</li>
<li>Welche Sprachen sind production-grade und welche nur „claimed support“? Können Sie Transkripte echter slowakischer Anrufe zeigen?</li>
<li>Wie wird die Slowakisch-Qualität getestet? Haben Sie Native-Speaker-QA für Slowakisch, Tschechisch, Ungarisch?</li>
<li>Was passiert, wenn ein Patient Symptome beschreibt (Brustschmerz, Dyspnoe)? Erkennt die KI den Notfall und leitet an 155 weiter?</li>
<li>Können wir einen zweiwöchigen Pilot auf einer Nebennummer starten, bevor wir die Hauptleitung umleiten?</li>
<li>Wer steht technisch hinter der KI-Engine? Nutzen Sie ein eigenes Modell oder Vapi/Retell/eine andere Plattform?</li>
</ol>
<p>Wir schlugen einen zweiwöchigen Pilot auf einer Nebenleitung vor. Beantwortet der Anbieter alle zwölf, testen wir. Wenn nicht, gehen wir nicht weiter. Die Fragen schickte ich an Halanda; am 17.&nbsp;9.&nbsp;2026 leitete er sie an den Anbieter weiter.</p>
<p>US-Anbieter mit Healthcare-Fokus — etwa Ona Health, Hello Patient, Talkie.ai oder Arini — nennen auf ihren Seiten HIPAA, SOC&nbsp;2 und BAA. Das ist ein Reifesignal, kein Ersatz für eine europäische DPA. KI in der Klinik geht nicht darum, wer zuerst ist. Es geht darum, ob das System sicher genug ist, dass der Patient, der um 2&nbsp;Uhr nachts mit Brustschmerz anruft, die richtige Antwort bekommt.</p>
<p>Wenn Sie KI-Tools für die Praxis bewerten — was steht auf Ihrer Checkliste? Schreiben Sie mir über das <a href="contact.php">Kontaktformular</a>.</p>
<p><em>Dies ist das fachliche Urteil des Autors bei der Bewertung eines Praxisangebots, keine Produktrezension für Patienten und kein Rat für Anrufende in Not. Bei akuten Symptomen 155/112 wählen.</em></p>
HTML,
        ],
        'fr' => [
            'title' => 'Un fournisseur nous a proposé une réceptionniste IA en slovaque courant. Au lieu de signer, j\'ai écrit 12 questions.',
            'image_alt' => 'Réception nocturne d\'un cabinet de néphrologie : un médecin parcourt une checklist près d\'un téléphone sans réponse et d\'une douce lueur turquoise-violette d\'interface vocale.',
            'excerpt' => 'La proposition promettait de rattraper 30 % des appels manqués et cent mille euros par an. En creusant, manquaient le repli, l\'escalade d\'urgence et un accord RGPD art. 9. J\'ai donc écrit douze questions et proposé un pilote de deux semaines.',
            'content' => <<<'HTML'
<p>Un fournisseur a proposé à notre cabinet une réceptionniste IA qui parle un slovaque courant. Au lieu de signer, j'ai écrit douze questions.</p>
<p>L'offre AI-Réception m'est parvenue via Branislav Halanda d'IMPAX — de Martin Koch chez TOMMAX. Sur le papier, elle impressionnait : rattraper environ 30&nbsp;% des appels manqués ; un slovaque courant et, au besoin, le tchèque, l'allemand, le hongrois ou l'anglais ; un retour sur investissement souvent en un mois ; un gain annuel estimé de plus de 100&nbsp;000&nbsp;euros.</p>
<p>En regardant de plus près, les lacunes sont apparues.</p>
<p>Le slovaque fait partie des langues à moindre volume de données d'entraînement pour les modèles vocaux — dites <em>lower-resource</em>. La « fluidité » marketing peut donc ne pas coller aux conversations médicales avec des patients âgés qui parlent dialecte, s'interrompent en milieu de phrase ou décrivent les symptômes de biais.</p>
<p>Dans les documents, je n'ai trouvé ni repli clair ni protocole d'escalade pour douleur thoracique ou dyspnée. Manquaient aussi les certifications que les acteurs vocaux US healthcare citent souvent (HIPAA, SOC&nbsp;2, BAA) — ce sont des instruments américains, pas le cadre contraignant d'un cabinet slovaque. Pour nous, l'essentiel est un accord de traitement des catégories particulières selon l'<a href="https://gdpr-info.eu/art-9-gdpr/">art.&nbsp;9 du RGPD</a>, plus un hébergement et un transfert clairs. Les études de cas de l'offre — TYMO Beauty et Manhattan Dental Studio — ne sont pas de la néphrologie en Slovaquie.</p>
<p>J'ai donc écrit douze questions au fournisseur :</p>
<ol>
<li>Quel est le protocole d'escalade exact lorsqu'un patient dit « je veux parler à un humain » ou « c'est une urgence » ?</li>
<li>Que se passe-t-il lorsque l'IA ne peut pas répondre et qu'aucun membre du personnel n'est disponible (hors horaires, week-end) ?</li>
<li>Le transfert est-il « warm » (avec contexte) ou « cold » (le patient doit répéter) ?</li>
<li>Comment traitez-vous les données de santé au sens de l'art.&nbsp;9 du RGPD ? Avez-vous un DPA signé ? Où sont les serveurs et les transcriptions ?</li>
<li>Quelles certifications avez-vous (SOC&nbsp;2, ISO&nbsp;27001 ou équivalent) ?</li>
<li>Quel est le prix mensuel concret ? Combien de minutes sont incluses ? Combien coûte une minute supplémentaire ?</li>
<li>Avez-vous une référence réelle d'un cabinet slovaque ou tchèque (pas un cabinet dentaire à Manhattan) ?</li>
<li>Quelles langues sont production-grade et lesquelles seulement « claimed support » ? Pouvez-vous montrer des transcriptions d'appels réels en slovaque ?</li>
<li>Comment teste-t-on la qualité du slovaque ? Avez-vous une QA locuteur natif pour le slovaque, le tchèque, le hongrois ?</li>
<li>Que se passe-t-il lorsqu'un patient décrit des symptômes (douleur thoracique, dyspnée) ? L'IA reconnaît-elle l'urgence et oriente-t-elle vers le 155 ?</li>
<li>Pouvons-nous lancer un pilote de deux semaines sur un numéro secondaire avant de rediriger la ligne principale ?</li>
<li>Qui alimente techniquement le moteur d'IA ? Utilisez-vous votre propre modèle, ou Vapi/Retell/une autre plateforme ?</li>
</ol>
<p>Nous avons proposé un pilote de deux semaines sur une ligne secondaire. Si le fournisseur répond aux douze, nous testons. Sinon, nous n'avançons pas. J'ai envoyé les questions à Halanda ; le 17&nbsp;septembre&nbsp;2026, il les a transmises au fournisseur.</p>
<p>Des fournisseurs américains axés santé — par exemple Ona Health, Hello Patient, Talkie.ai ou Arini — indiquent sur leurs sites HIPAA, SOC&nbsp;2 et BAA. C'est un signal de maturité, pas un substitut à un DPA européen. L'IA en clinique n'est pas une course à être le premier. C'est la question de savoir si le système est assez sûr pour que le patient qui appelle à 2&nbsp;h du matin avec une douleur thoracique reçoive la bonne réponse.</p>
<p>Si vous évaluez des outils d'IA pour un cabinet — qu'y a-t-il sur votre checklist ? Écrivez-moi via le <a href="contact.php">formulaire de contact</a>.</p>
<p><em>Il s'agit du jugement professionnel de l'auteur lors de l'évaluation d'une offre pour un cabinet, non d'une revue produit pour les patients ni d'un conseil aux appelants en détresse. En cas de symptômes aigus, composez le 155/112.</em></p>
HTML,
        ],
        'es' => [
            'title' => 'Un proveedor nos ofreció una recepcionista de IA con eslovaco fluido. En lugar de firmar, escribí 12 preguntas.',
            'image_alt' => 'Recepción nocturna de una consulta de nefrología: un médico revisa una lista junto a un teléfono sin contestar y un suave resplandor turquesa-violeta de una interfaz de voz.',
            'excerpt' => 'La oferta prometía captar el 30 % de las llamadas perdidas y cien mil euros al año. Al profundizar faltaban el fallback, la escalada de emergencia y un acuerdo GDPR art. 9. Por eso escribí doce preguntas y propuse un piloto de dos semanas.',
            'content' => <<<'HTML'
<p>Un proveedor ofreció a nuestra consulta una recepcionista de IA que habla eslovaco fluido. En lugar de firmar, escribí doce preguntas.</p>
<p>La oferta de AI-Recepción me llegó a través de Branislav Halanda de IMPAX — de Martin Koch en TOMMAX. Sobre el papel impresionaba: captar aproximadamente el 30&nbsp;% de las llamadas no atendidas; eslovaco fluido y, según necesidad, checo, alemán, húngaro o inglés; retorno de la inversión a menudo en un mes; y un aporte anual estimado de más de 100&nbsp;000&nbsp;euros.</p>
<p>Cuando miré con más detalle, aparecieron las lagunas.</p>
<p>El eslovaco pertenece a las lenguas con menor volumen de datos de entrenamiento para modelos de voz — las llamadas <em>lower-resource</em>. La «fluidez» de marketing puede no encajar con conversaciones médicas con pacientes mayores que usan dialecto, hacen pausas a mitad de frase o describen síntomas de forma indirecta.</p>
<p>En los materiales no encontré un fallback claro ni un protocolo de escalada para dolor torácico o disnea. Tampoco presentaban las certificaciones que suelen citar los proveedores de voz sanitaria en EE.&nbsp;UU. (HIPAA, SOC&nbsp;2, BAA) — son instrumentos estadounidenses, no el marco vinculante de una consulta eslovaca. Para nosotros es clave un acuerdo de tratamiento de categorías especiales según el <a href="https://gdpr-info.eu/art-9-gdpr/">art.&nbsp;9 del GDPR</a> y un alojamiento o transferencia claros. Los casos de estudio de la oferta — TYMO Beauty y Manhattan Dental Studio — no son nefrología en Eslovaquia.</p>
<p>Por eso escribí doce preguntas al proveedor:</p>
<ol>
<li>¿Cuál es el protocolo exacto de escalada cuando un paciente dice «quiero hablar con una persona» o «esto es una emergencia»?</li>
<li>¿Qué ocurre cuando la IA no puede responder y nadie del personal está disponible (fuera de horario, fin de semana)?</li>
<li>¿La transferencia es «warm» (con contexto) o «cold» (el paciente debe repetir)?</li>
<li>¿Cómo tratan los datos de salud según el art.&nbsp;9 del GDPR? ¿Tienen un DPA firmado? ¿Dónde están los servidores y las transcripciones?</li>
<li>¿Qué certificaciones tienen (SOC&nbsp;2, ISO&nbsp;27001 o equivalente)?</li>
<li>¿Cuál es el precio mensual concreto? ¿Cuántos minutos están incluidos? ¿Cuánto cuesta un minuto extra?</li>
<li>¿Tienen una referencia real de una consulta eslovaca o checa (no una clínica dental en Manhattan)?</li>
<li>¿Qué idiomas son production-grade y cuáles solo «claimed support»? ¿Pueden mostrar transcripciones de llamadas reales en eslovaco?</li>
<li>¿Cómo se prueba la calidad del eslovaco? ¿Tienen QA con hablantes nativos para eslovaco, checo y húngaro?</li>
<li>¿Qué ocurre cuando un paciente describe síntomas (dolor torácico, disnea)? ¿La IA reconoce la emergencia y deriva al 155?</li>
<li>¿Podemos lanzar un piloto de dos semanas en un número secundario antes de redirigir la línea principal?</li>
<li>¿Quién impulsa técnicamente el motor de IA? ¿Usan su propio modelo, o Vapi/Retell/otra plataforma?</li>
</ol>
<p>Propusimos un piloto de dos semanas en una línea secundaria. Si el proveedor responde a las doce, probamos. Si no, no seguimos. Envié las preguntas a Halanda; el 17&nbsp;de&nbsp;septiembre&nbsp;de&nbsp;2026 las reenvió al proveedor.</p>
<p>Proveedores estadounidenses centrados en sanidad — por ejemplo Ona Health, Hello Patient, Talkie.ai o Arini — indican en sus sitios HIPAA, SOC&nbsp;2 y BAA. Es una señal de madurez, no un sustituto de un DPA europeo. La IA en clínica no va de ser el primero. Va de si el sistema es lo bastante seguro para que el paciente que llama a las 2&nbsp;de la madrugada con dolor torácico reciba la respuesta correcta.</p>
<p>Si evalúa herramientas de IA para una consulta — ¿qué tiene en su checklist? Escríbame a través del <a href="contact.php">formulario de contacto</a>.</p>
<p><em>Se trata del juicio profesional del autor al valorar una oferta para una consulta, no de una reseña de producto para pacientes ni de consejo a quienes llaman en urgencia. Ante síntomas agudos, llame al 155/112.</em></p>
HTML,
        ],
        'pl' => [
            'title' => 'Dostawca zaproponował nam recepcję AI z płynnym słowackim. Zamiast podpisać napisałem 12 pytań.',
            'image_alt' => 'Nocna recepcja poradni nefrologicznej: lekarz przegląda checklistę obok nieodebranego telefonu i miękkiej turkusowo-fioletowej poświaty interfejsu głosowego.',
            'excerpt' => 'Oferta obiecywała przechwycić 30 % nieodebranych połączeń i sto tysięcy euro rocznie. Przy głębszym spojrzeniu brakowało fallbacku, eskalacji nagłych przypadków i umowy RODO art. 9. Dlatego napisałem dwanaście pytań i zaproponowałem dwutygodniowy pilotaż.',
            'content' => <<<'HTML'
<p>Dostawca zaproponował naszej poradni recepcję AI, która ma mówić płynnie po słowacku. Zamiast podpisać napisałem dwanaście pytań.</p>
<p>Ofertę AI-Recepcji dostałem przez Branislava Halandę z IMPAX — od Martina Kocha z TOMMAX. Na papierze wyglądała imponująco: przechwycić około 30&nbsp;% nieodebranych połączeń; płynny słowacki i w razie potrzeby czeski, niemiecki, węgierski lub angielski; zwrot często w miesiąc; szacowany roczny wzrost przychodów powyżej 100&nbsp;tys. euro.</p>
<p>Gdy jednak spojrzałem dokładniej, pojawiły się luki.</p>
<p>Słowacki należy do języków z mniejszą ilością danych treningowych dla modeli głosowych — tzw. <em>lower-resource</em>. Marketingowa „płynność” może więc nie pasować do rozmów medycznych ze starszymi pacjentami, którzy mówią dialektem, robią pauzy w środku zdania lub opisują objawy okrężnie.</p>
<p>W materiałach nie znalazłem jasnego fallbacku ani protokołu eskalacji przy bólu w klatce piersiowej czy duszności. Brakowało też certyfikacji, które w USA często podają dostawcy voice healthcare (HIPAA, SOC&nbsp;2, BAA) — to jednak ramy amerykańskie, nie wiążące dla słowackiej poradni. Dla nas kluczowa jest umowa o przetwarzaniu szczególnych kategorii według <a href="https://gdpr-info.eu/art-9-gdpr/">art.&nbsp;9 RODO</a> oraz jasne miejsce hostingu i transferu. Case studies w ofercie — TYMO Beauty i Manhattan Dental Studio — to nie nefrologia na Słowacji.</p>
<p>Dlatego napisałem dwanaście pytań do dostawcy:</p>
<ol>
<li>Jaki jest dokładny protokół eskalacji, gdy pacjent powie „chcę mówić z człowiekiem” lub „to nagły przypadek”?</li>
<li>Co się stanie, gdy AI nie potrafi odpowiedzieć i nikt z personelu nie jest dostępny (po godzinach, w weekend)?</li>
<li>Czy transfer jest „warm” (z kontekstem), czy „cold” (pacjent musi powtórzyć)?</li>
<li>Jak obchodzicie się z danymi zdrowotnymi w sensie art.&nbsp;9 RODO? Czy macie podpisaną DPA? Gdzie stoją serwery i transkrypty?</li>
<li>Jakie macie certyfikacje (SOC&nbsp;2, ISO&nbsp;27001 lub równoważne)?</li>
<li>Jaka jest konkretna miesięczna cena? Ile minut jest wliczonych? Ile kosztuje minuta ekstra?</li>
<li>Czy macie realną referencję ze słowackiej lub czeskiej poradni (nie klinika stomatologiczna na Manhattanie)?</li>
<li>Które języki są production-grade, a które tylko „claimed support”? Czy możecie pokazać transkrypty prawdziwych rozmów po słowacku?</li>
<li>Jak testowana jest jakość słowackiego? Czy macie native-speaker QA dla słowackiego, czeskiego, węgierskiego?</li>
<li>Co się stanie, gdy pacjent opisuje objawy (ból w klatce, duszność)? Czy AI rozpozna nagły przypadek i skieruje na 155?</li>
<li>Czy możemy uruchomić dwutygodniowy pilotaż na numerze dodatkowym, zanim przekierujemy główną linię?</li>
<li>Kto technicznie stoi za silnikiem AI? Używacie własnego modelu, czy Vapi/Retell/innej platformy?</li>
</ol>
<p>Zaproponowaliśmy dwutygodniowy pilotaż na linii dodatkowej. Jeśli dostawca odpowie na wszystkie dwanaście, testujemy. Jeśli nie — nie idziemy dalej. Pytania wysłałem Halandzie; 17&nbsp;września&nbsp;2026 przekazał je dostawcy.</p>
<p>Amerykańscy dostawcy skupieni na ochronie zdrowia — np. Ona Health, Hello Patient, Talkie.ai czy Arini — na swoich stronach podają HIPAA, SOC&nbsp;2 i BAA. To sygnał dojrzałości produktu, nie zastępstwo europejskiej DPA. AI w klinice nie jest o byciu pierwszym. Jest o tym, czy system jest wystarczająco bezpieczny, by pacjent dzwoniący o drugiej w nocy z bólem w klatce dostał właściwą odpowiedź.</p>
<p>Jeśli oceniacie narzędzia AI dla poradni — co macie na swojej checkliście? Napiszcie do mnie przez <a href="contact.php">kontakt</a>.</p>
<p><em>To fachowa ocena autora przy rozpatrywaniu oferty dla poradni, nie recenzja produktu dla pacjentów ani rada dla dzwoniących w nagłym przypadku. Przy ostrych objawach dzwońcie 155/112.</em></p>
HTML,
        ],
        'hu' => [
            'title' => 'Egy szállító folyékony szlovákul beszélő AI-recepcióst ajánlott. Aláírás helyett 12 kérdést írtam.',
            'image_alt' => 'Éjszakai nefrológiai rendelő-recepció: orvos checklistát néz, mellette villogó, felvételen telefon és lágy türkiz-lila hanginterfész-fény.',
            'excerpt' => 'Az ajánlat 30 % elmulasztott hívás és százezer euró éves bevétel megfogását ígérte. Közelebbről hiányzott a fallback, a vészhelyzeti eszkaláció és a GDPR 9. cikk szerinti megállapodás. Ezért tizenkét kérdést írtam és kéthetes pilotot javasoltam.',
            'content' => <<<'HTML'
<p>Egy szállító olyan AI-recepcióst ajánlott a rendelőnknek, amely folyékonyan beszél szlovákul. Aláírás helyett tizenkét kérdést írtam.</p>
<p>Az AI-Recepciós ajánlat Branislav Halandán (IMPAX) keresztül érkezett — Martin Koch-tól (TOMMAX). Papíron erősnek tűnt: kb. 30&nbsp;% elmulasztott hívás megfogása; folyékony szlovák, szükség szerint cseh, német, magyar vagy angol; gyakran egy hónapon belüli megtérülés; évi 100&nbsp;000&nbsp;euró feletti becsült bevételnövekmény.</p>
<p>Amikor azonban közelebbről néztem, megjelentek a hiányosságok.</p>
<p>A szlovák a hangmodellek számára kisebb tanítóadatú — úgynevezett <em>lower-resource</em> — nyelv. A marketing „folyékonyság” ezért nem feltétlenül illik idősebb, dialektust beszélő, mondat közben szünetelő vagy kerülő úton panaszoló betegek orvosi beszélgetéseihez.</p>
<p>Az anyagokban nem találtam világos fallbackot, sem mellkasi fájdalomra vagy nehézlégzésre vonatkozó eszkalációs protokollt. Hiányoztak azok a tanúsítványok is, amelyeket az amerikai healthcare voice szereplők gyakran említenek (HIPAA, SOC&nbsp;2, BAA) — ezek amerikai eszközök, nem a szlovák rendelő kötelező kerete. Nálunk a <a href="https://gdpr-info.eu/art-9-gdpr/">GDPR 9.&nbsp;cikk</a> szerinti különleges kategóriák feldolgozási megállapodása és a hosting/átadás helye a lényeg. Az ajánlat case study-jai — TYMO Beauty és Manhattan Dental Studio — nem szlovákiai nefrológia.</p>
<p>Ezért tizenkét kérdést írtam a szállítónak:</p>
<ol>
<li>Mi a pontos eszkalációs protokoll, ha a beteg azt mondja: „emberrel akarok beszélni” vagy „ez sürgős eset”?</li>
<li>Mi történik, ha az AI nem tud válaszolni, és senki a személyzetből nem elérhető (nyitvatartáson kívül, hétvégén)?</li>
<li>A továbbítás „warm” (kontextussal) vagy „cold” (a betegnek ismételnie kell)?</li>
<li>Hogyan kezelik az egészségügyi adatokat a GDPR 9.&nbsp;cikk szerint? Van aláírt DPA? Hol vannak a szerverek és a transcripttek?</li>
<li>Milyen tanúsítványaik vannak (SOC&nbsp;2, ISO&nbsp;27001 vagy egyenértékű)?</li>
<li>Mi a konkrét havi ár? Hány perc van benne? Mennyibe kerül egy extra perc?</li>
<li>Van valódi referenciájuk szlovák vagy cseh rendelőből (nem manhattani fogászati klinika)?</li>
<li>Mely nyelvek production-grade, és melyek csak „claimed support”? Mutatnak valódi szlovák hívások transcriptjeit?</li>
<li>Hogyan tesztelik a szlovák minőségét? Van anyanyelvi QA szlovákra, csehre, magyarra?</li>
<li>Mi történik, ha a beteg tüneteket ír le (mellkasi fájdalom, dyspnoe)? Felismeri az AI a vészhelyzetet és a 155-re irányít?</li>
<li>Indíthatunk kéthetes pilotot másodlagos számon, mielőtt átirányítjuk a fővonalat?</li>
<li>Ki áll technikailag az AI-motor mögött? Saját modellt használnak, vagy Vapi/Retell/más platformot?</li>
</ol>
<p>Kéthetes pilotot javasoltunk másodlagos vonalon. Ha a szállító mind a tizenkettőre válaszol, tesztelünk. Ha nem, nem megyünk tovább. A kérdéseket elküldtem Halandának; ő 2026.&nbsp;szeptember&nbsp;17-én továbbította a szállítónak.</p>
<p>Az amerikai, egészségügyre fókuszáló szolgáltatók — pl. Ona Health, Hello Patient, Talkie.ai vagy Arini — oldalukon HIPAA-t, SOC&nbsp;2-t és BAA-t említenek. Ez érettségi jel, nem európai DPA-pótlék. A klinikán az AI nem arról szól, ki az első. Arról, hogy elég biztonságos-e a rendszer ahhoz, hogy a hajnali 2-kor mellkasi fájdalommal hívó beteg helyes választ kapjon.</p>
<p>Ha AI-eszközöket értékel rendelőbe — mi van a checklistjén? Írjon nekem a <a href="contact.php">kapcsolati űrlapon</a>.</p>
<p><em>Ez a szerző szakmai ítélete egy rendelői ajánlat értékelésekor, nem termékismertető betegeknek, és nem tanács vészhelyzetben hívóknak. Akut tüneteknél hívja a 155/112-t.</em></p>
HTML,
        ],
        'it' => [
            'title' => 'Un fornitore ci ha proposto una receptionist IA con slovacco fluido. Invece di firmare ho scritto 12 domande.',
            'image_alt' => 'Reception notturna di un ambulatorio di nefrologia: un medico esamina una checklist accanto a un telefono senza risposta e a un soft bagliore turchese-viola di un\'interfaccia vocale.',
            'excerpt' => 'L\'offerta prometteva di intercettare il 30 % delle chiamate perse e centomila euro l\'anno. Approfondendo mancavano fallback, escalation di emergenza e un accordo GDPR art. 9. Perciò ho scritto dodici domande e proposto un pilota di due settimane.',
            'content' => <<<'HTML'
<p>Un fornitore ha proposto al nostro ambulatorio una receptionist IA che parla slovacco fluido. Invece di firmare ho scritto dodici domande.</p>
<p>L'offerta AI-Reception mi è arrivata tramite Branislav Halanda di IMPAX — da Martin Koch di TOMMAX. Sulla carta sembrava solida: intercettare circa il 30&nbsp;% delle chiamate non risposte; slovacco fluido e, se necessario, ceco, tedesco, ungherese o inglese; ROI spesso entro un mese; contributo annuale stimato oltre 100&nbsp;000&nbsp;euro.</p>
<p>Quando ho approfondito, sono emerse le lacune.</p>
<p>Lo slovacco è una lingua con meno dati di addestramento per i modelli vocali — detta <em>lower-resource</em>. La «fluidità» di marketing quindi può non combaciare con conversazioni mediche con pazienti anziani che usano il dialetto, fanno pause a metà frase o descrivono i sintomi in modo indiretto.</p>
<p>Nei materiali non ho trovato un fallback chiaro né un protocollo di escalation per dolore toracico o dispnea. Mancavano anche le certificazioni che i fornitori vocali healthcare USA citano spesso (HIPAA, SOC&nbsp;2, BAA) — strumenti americani, non il quadro vincolante di un ambulatorio slovacco. Per noi conta un accordo di trattamento delle categorie particolari secondo l'<a href="https://gdpr-info.eu/art-9-gdpr/">art.&nbsp;9 del GDPR</a> e un hosting/trasferimento chiari. I case study dell'offerta — TYMO Beauty e Manhattan Dental Studio — non sono nefrologia in Slovacchia.</p>
<p>Perciò ho scritto dodici domande al fornitore:</p>
<ol>
<li>Qual è l'esatto protocollo di escalation quando un paziente dice «voglio parlare con una persona» o «è un'emergenza»?</li>
<li>Cosa succede quando l'IA non sa rispondere e nessuno del personale è disponibile (fuori orario, weekend)?</li>
<li>Il trasferimento è «warm» (con contesto) o «cold» (il paziente deve ripetere)?</li>
<li>Come gestite i dati sanitari ai sensi dell'art.&nbsp;9 del GDPR? Avete un DPA firmato? Dove stanno server e trascrizioni?</li>
<li>Quali certificazioni avete (SOC&nbsp;2, ISO&nbsp;27001 o equivalente)?</li>
<li>Qual è il prezzo mensile concreto? Quanti minuti sono inclusi? Quanto costa un minuto extra?</li>
<li>Avete un riferimento reale da un ambulatorio slovacco o ceco (non uno studio dentistico a Manhattan)?</li>
<li>Quali lingue sono production-grade e quali solo «claimed support»? Potete mostrare trascrizioni di chiamate reali in slovacco?</li>
<li>Come si testa la qualità dello slovacco? Avete QA madrelingua per slovacco, ceco, ungherese?</li>
<li>Cosa succede quando un paziente descrive sintomi (dolore toracico, dispnea)? L'IA riconosce l'emergenza e indirizza al 155?</li>
<li>Possiamo avviare un pilota di due settimane su un numero secondario prima di reindirizzare la linea principale?</li>
<li>Chi alimenta tecnicamente il motore IA? Usate un modello proprio o Vapi/Retell/un'altra piattaforma?</li>
</ol>
<p>Abbiamo proposto un pilota di due settimane su una linea secondaria. Se il fornitore risponde a tutte e dodici, testiamo. Se no, non proseguiamo. Ho inviato le domande a Halanda; il 17&nbsp;settembre&nbsp;2026 le ha inoltrate al fornitore.</p>
<p>Fornitori USA orientati alla sanità — ad esempio Ona Health, Hello Patient, Talkie.ai o Arini — indicano sui propri siti HIPAA, SOC&nbsp;2 e BAA. È un segnale di maturità, non un sostituto di un DPA europeo. L'IA in ambulatorio non è una corsa a essere i primi. È se il sistema è abbastanza sicuro perché il paziente che chiama alle 2&nbsp;di notte con dolore toracico riceva la risposta giusta.</p>
<p>Se valutate strumenti IA per l'ambulatorio — cosa c'è nella vostra checklist? Scrivetemi tramite il <a href="contact.php">modulo di contatto</a>.</p>
<p><em>Si tratta del giudizio professionale dell'autore nella valutazione di un'offerta per ambulatorio, non di una recensione di prodotto per i pazienti né di un consiglio per chi chiama in emergenza. In caso di sintomi acuti, chiamare 155/112.</em></p>
HTML,
        ],
        'uk' => [
            'title' => 'Постачальник запропонував нам AI-рецепцію з вільною словацькою. Замість підпису я написав 12 запитань.',
            'image_alt' => 'Нічна рецепція нефрологічного кабінету: лікар переглядає чеклист біля не піднятого телефону та м’якого бірюзово-фіолетового сяйва голосового інтерфейсу.',
            'excerpt' => 'Пропозиція обіцяла перехопити 30 % пропущених дзвінків і сто тисяч євро на рік. При глибшому погляді бракувало fallback, ескалації невідкладності та угоди за ст. 9 GDPR. Тому я написав дванадцять запитань і запропонував двотижневий пілот.',
            'content' => <<<'HTML'
<p>Постачальник запропонував нашій клініці AI-рецепцію, яка має вільно говорити словацькою. Замість підпису я написав дванадцять запитань.</p>
<p>Пропозиція AI-Рецепції надійшла через Бранислава Галанду з IMPAX — від Мартіна Коха з TOMMAX. На папері виглядала сильно: перехопити приблизно 30&nbsp;% неприйнятих дзвінків; вільна словацька й за потреби чеська, німецька, угорська чи англійська; окупність часто за місяць; оцінений річний приріст виручки понад 100&nbsp;тисяч євро.</p>
<p>Коли я придивився детальніше, з’явилися прогалини.</p>
<p>Словацька належить до мов із меншим обсягом навчальних даних для голосових моделей — так званих <em>lower-resource</em>. Маркетингова «плинність» тому може не збігатися з медичними розмовами з літніми пацієнтами, які говорять діалектом, роблять паузи посеред речення або описують симптоми опосередковано.</p>
<p>У матеріалах я не знайшов чіткого fallback і протоколу ескалації при болю в грудях чи задишці. Бракувало й сертифікацій, які в США часто згадують healthcare voice гравці (HIPAA, SOC&nbsp;2, BAA) — це американські інструменти, не обов’язкова рамка для словацької амбулаторії. Для нас ключова угода про обробку особливих категорій за <a href="https://gdpr-info.eu/art-9-gdpr/">ст.&nbsp;9 GDPR</a> і зрозуміле місце хостингу чи передачі. Case studies у пропозиції — TYMO Beauty і Manhattan Dental Studio — це не нефрологія в Словаччині.</p>
<p>Тому я написав дванадцять запитань постачальнику:</p>
<ol>
<li>Який точний протокол ескалації, коли пацієнт каже «хочу говорити з людиною» або «це невідкладний випадок»?</li>
<li>Що станеться, коли AI не може відповісти й ніхто з персоналу недоступний (після годин, на вихідних)?</li>
<li>Чи є переведення «warm» (з контекстом), чи «cold» (пацієнт мусить повторювати)?</li>
<li>Як ви працюєте з даними про здоров’я за ст.&nbsp;9 GDPR? Чи є підписана DPA? Де сервери й транскрипти?</li>
<li>Які сертифікації маєте (SOC&nbsp;2, ISO&nbsp;27001 або еквівалент)?</li>
<li>Яка конкретна місячна ціна? Скільки хвилин включено? Скільки коштує додаткова хвилина?</li>
<li>Чи є реальна референція зі словацької або чеської амбулаторії (не стоматологічна клініка на Мангеттені)?</li>
<li>Які мови production-grade, а які лише «claimed support»? Чи можете показати транскрипти реальних дзвінків словацькою?</li>
<li>Як тестується якість словацької? Чи є native-speaker QA для словацької, чеської, угорської?</li>
<li>Що станеться, коли пацієнт описує симптоми (біль у грудях, задишка)? Чи розпізнає AI невідкладність і спрямує на 155?</li>
<li>Чи можемо запустити двотижневий пілот на вторинному номері, перш ніж перенаправимо головну лінію?</li>
<li>Хто технічно стоїть за AI-рушієм? Використовуєте власну модель чи Vapi/Retell/іншу платформу?</li>
</ol>
<p>Ми запропонували двотижневий пілот на вторинній лінії. Якщо постачальник відповість на всі дванадцять — тестуємо. Якщо ні — не йдемо далі. Запитання я надіслав Галанді; 17&nbsp;вересня&nbsp;2026 він переслав їх постачальнику.</p>
<p>Американські провайдери з фокусом на охорону здоров’я — наприклад Ona Health, Hello Patient, Talkie.ai чи Arini — на своїх сайтах зазначають HIPAA, SOC&nbsp;2 і BAA. Це сигнал зрілості продукту, а не заміна європейській DPA. AI в клініці — не про те, хто перший. А про те, чи система достатньо безпечна, щоб пацієнт, який дзвонить о другій ночі з болем у грудях, отримав правильну відповідь.</p>
<p>Якщо ви оцінюєте AI-інструменти для амбулаторії — що у вашому чеклисті? Напишіть мені через <a href="contact.php">контакт</a>.</p>
<p><em>Це фахова оцінка автора при розгляді пропозиції для амбулаторії, не огляд продукту для пацієнтів і не порада тим, хто дзвонить у невідкладності. При гострих симптомах телефонуйте 155/112.</em></p>
HTML,
        ],
    ],
];
