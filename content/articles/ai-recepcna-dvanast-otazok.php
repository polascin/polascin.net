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
 * Zdroj: ponuka TOMMAX cez sprostredkovateľa z IMPAX, 16. 9. 2026
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
            'image_alt' => 'Nočná recepcia nefrologickej ambulancie: lekár prezerá zoznam otázok, vedľa bliká nezdvihnutý telefón a jemné tyrkysovo-fialové svetlo hlasového rozhrania.',
            'excerpt' => 'Ponuka sľubovala zachytiť 30 % neprijatých hovorov a stotisíc eur ročne. V materiáloch chýbal záložný postup, eskalácia núdze a dohoda podľa GDPR čl. 9. Preto som napísal dvanásť otázok a navrhol dvojtýždňový pilot.',
            'content' => <<<'HTML'
<p>Ponuku AI-Recepčnej som dostal cez sprostredkovateľa z IMPAX, od zástupcu dodávateľa TOMMAX. Na papieri vyzerala pôsobivo: zachytiť približne 30&nbsp;% neprijatých hovorov, plynulá slovenčina a podľa potreby čeština, nemčina, maďarčina či angličtina, návratnosť často do mesiaca a odhadovaný ročný prínos na tržbách nad 100&nbsp;tisíc eur.</p>
<p>Medzery sa ukázali v detailoch.</p>
<p>Slovenčina má pre hlasové modely menej trénovacích dát než angličtina či nemčina. V odbore sa tomu hovorí jazyk s menším zdrojom, <em>lower-resource</em>. Marketingová „plynulosť“ preto nemusí sedieť s medicínskou konverzáciou so staršími pacientmi, ktorí hovoria dialektom, robia pauzy uprostred vety alebo opisujú príznaky oklukou.</p>
<p>V materiáloch som nenašiel jasný záložný postup ani eskalačný protokol pre bolesť na hrudníku či dýchavičnosť. Chýbali aj certifikácie, ktoré v USA bežne uvádzajú poskytovatelia hlasových služieb v zdravotníctve (HIPAA, SOC&nbsp;2, BAA). Tie však pre slovenskú ambulanciu nie sú záväzným rámcom. Rozhoduje dohoda o spracúvaní osobitných kategórií podľa <a href="https://gdpr-info.eu/art-9-gdpr/">GDPR čl.&nbsp;9</a> a jasné miesto hostingu či prenosu. Prípadové štúdie v ponuke, Lumen Studio Beauty a Hudson River Dental Studio, nie sú nefrológia na Slovensku.</p>
<p>Preto som napísal dvanásť otázok pre dodávateľa:</p>
<ol>
<li>Aký je presný eskalačný protokol, keď pacient povie „chcem hovoriť s človekom“ alebo „to je núdzový prípad“?</li>
<li>Čo sa stane, keď AI nedokáže odpovedať a nikto z personálu nie je dostupný (po hodinách, cez víkend)?</li>
<li>Je transfer „warm“ (s kontextom) alebo „cold“ (pacient musí opakovať)?</li>
<li>Ako zaobchádzate so zdravotnými dátami v zmysle GDPR čl.&nbsp;9? Máte podpísaný DPA? Kde stoja servery a transkripty?</li>
<li>Aké certifikácie máte (SOC&nbsp;2, ISO&nbsp;27001, alebo ekvivalent)?</li>
<li>Aká je konkrétna mesačná cena? Koľko minút je zahrnutých? Koľko stojí minúta navyše?</li>
<li>Máte reálnu referenciu zo slovenskej alebo českej ambulancie (nie zubná klinika pri rieke Hudson)?</li>
<li>Aké jazyky sú production-grade a aké len „claimed-support“? Môžete ukázať transkripty reálnych hovorov v slovenčine?</li>
<li>Ako sa testuje kvalita slovenčiny? Máte native-speaker QA pre slovenčinu, češtinu, maďarčinu?</li>
<li>Čo sa stane, keď pacient opisuje príznaky (bolesť na hrudníku, dýchavičnosť)? Rozpozná AI núdzu a nasmeruje na 155?</li>
<li>Môžeme spustiť 2-týždňový pilot na sekundárnom čísle predtým, ako presmerujeme hlavnú linku?</li>
<li>Kto technicky stojí za AI enginom? Používate vlastný model, alebo Vapi/Retell/inú platformu?</li>
</ol>
<p>Navrhli sme dvojtýždňový pilot na sekundárnej linke. Ak dodávateľ odpovie na všetkých dvanásť, testujeme. Ak nie, nejdeme ďalej. Otázky som poslal sprostredkovateľovi; ten ich 17.&nbsp;9.&nbsp;2026 preposlal dodávateľovi.</p>
<p>Americkí poskytovatelia zameraní na zdravotníctvo, napríklad Haven Voice Care, Deskline Health, Callform.ai či Voxora, na svojich stránkach uvádzajú HIPAA, SOC&nbsp;2 a BAA. To je signál o vyspelosti produktu, nie náhrada za európsku dohodu o spracúvaní údajov. V klinike nerozhoduje, kto nasadí hlasovú linku ako prvý. Rozhoduje, či pacient, ktorý volá o druhej v noci s bolesťou na hrudníku, dostane správnu odpoveď.</p>
<p><em>Ide o odborný úsudok autora pri hodnotení ponuky pre ambulanciu, nie o recenziu produktu pre pacientov ani o radu volajúcim v núdzi. Pri akútnych príznakoch volajte 155/112.</em></p>
HTML,
        ],
        'en' => [
            'title' => 'A vendor pitched us an AI receptionist with fluent Slovak. I wrote twelve questions instead of signing.',
            'image_alt' => 'Night-time nephrology clinic reception: a physician reviews a checklist beside an unanswered phone and a soft teal-purple glow of a voice interface.',
            'excerpt' => 'The pitch promised to catch 30% of missed calls and a hundred thousand euros a year. The materials had no fallback plan, no emergency escalation and no GDPR Art. 9 agreement. So I wrote twelve questions and proposed a two-week pilot.',
            'content' => <<<'HTML'
<p>The AI-Receptionist offer reached me via an intermediary at IMPAX, from a representative of the vendor TOMMAX. On paper it looked strong: catch roughly 30% of missed calls; fluent Slovak and, as needed, Czech, German, Hungarian, or English; the outlay often pays for itself within a month; and an estimated annual revenue contribution above €100,000.</p>
<p>The gaps showed up in the details.</p>
<p>Slovak is a lower-resource language for voice models: less training data than English or German. Marketing “fluency” therefore may not match medical conversations with elderly patients who use dialect, pause mid-sentence, or describe symptoms in roundabout ways.</p>
<p>I found no clear fallback and no escalation protocol for chest pain or shortness of breath. The pitch also did not present the certifications US healthcare voice vendors often advertise (HIPAA, SOC&nbsp;2, BAA). Those are US instruments, not what binds a Slovak clinic. What matters here is a processing agreement for special categories under <a href="https://gdpr-info.eu/art-9-gdpr/">GDPR Art.&nbsp;9</a>, plus clear hosting and transfer. The case studies on offer, Lumen Studio Beauty and Hudson River Dental Studio, are not nephrology in Slovakia.</p>
<p>So I wrote twelve questions for the vendor:</p>
<ol>
<li>What is the exact escalation protocol when a patient says “I want to talk to a human” or “this is an emergency”?</li>
<li>What happens when the AI cannot answer and no staff member is available (after hours, weekends)?</li>
<li>Is the transfer “warm” (with context) or “cold” (the patient must repeat)?</li>
<li>How do you handle health data under GDPR Art.&nbsp;9? Do you have a signed DPA? Where are servers and transcripts hosted?</li>
<li>What certifications do you hold (SOC&nbsp;2, ISO&nbsp;27001, or equivalent)?</li>
<li>What is the concrete monthly price? How many minutes are included? What does an extra minute cost?</li>
<li>Do you have a real reference from a Slovak or Czech outpatient clinic (not a Hudson River dental studio)?</li>
<li>Which languages are production-grade and which are only “claimed support”? Can you show transcripts of real Slovak calls?</li>
<li>How is Slovak quality tested? Do you have native-speaker QA for Slovak, Czech, and Hungarian?</li>
<li>What happens when a patient describes symptoms (chest pain, dyspnea)? Does the AI recognise an emergency and direct them to 155?</li>
<li>Can we run a two-week pilot on a secondary number before we redirect the main line?</li>
<li>Who technically powers the AI engine? Do you use your own model, or Vapi/Retell/another platform?</li>
</ol>
<p>We proposed a two-week pilot on a secondary line. If the vendor answers all twelve, we test. If not, we do not. I sent the questions to the intermediary; on 17&nbsp;September&nbsp;2026 he forwarded them to the vendor.</p>
<p>US healthcare-focused providers, for example Haven Voice Care, Deskline Health, Callform.ai, or Voxora, state HIPAA, SOC&nbsp;2, and BAA on their sites. That is a maturity signal, not a substitute for a European DPA. In a clinic the question is whether the patient who calls at 2&nbsp;a.m. with chest pain gets the right response.</p>
<p><em>This is the author’s professional judgement when assessing a clinic vendor offer, not a product review for patients and not advice for callers in distress. For acute symptoms, call 155/112.</em></p>
HTML,
        ],
        'cs' => [
            'title' => 'Dodavatel nám nabídl AI recepční s plynulou slovenštinou. Místo podpisu jsem napsal 12 otázek.',
            'image_alt' => 'Noční recepce nefrologické ambulance: lékař prohlíží kontrolní seznam, vedle bliká nezvednutý telefon a jemné tyrkysovo-fialové světlo hlasového rozhraní.',
            'excerpt' => 'Nabídka slibovala zachytit 30 % nepřijatých hovorů a sto tisíc eur ročně. V materiálech chyběl záložní postup, eskalace nouze a dohoda podle GDPR čl. 9. Proto jsem napsal dvanáct otázek a navrhl dvoutýdenní pilot.',
            'content' => <<<'HTML'
<p>Nabídku AI-Recepční jsem dostal přes zprostředkovatele z IMPAX, od zástupce dodavatele TOMMAX. Na papíře vypadala působivě: zachytit přibližně 30&nbsp;% nepřijatých hovorů, plynulá slovenština a podle potřeby čeština, němčina, maďarština či angličtina, návratnost často do měsíce a odhadovaný roční přínos na tržbách nad 100&nbsp;tisíc eur.</p>
<p>Mezery se ukázaly v detailech.</p>
<p>Slovenština má pro hlasové modely méně trénovacích dat než angličtina či němčina. V oboru se tomu říká jazyk s menším zdrojem, <em>lower-resource</em>. Marketingová „plynulost“ proto nemusí sedět s medicínskou konverzací se staršími pacienty, kteří mluví dialektem, dělají pauzy uprostřed věty nebo popisují příznaky oklikou.</p>
<p>V materiálech jsem nenašel jasný záložní postup ani eskalační protokol pro bolest na hrudi či dušnost. Chyběly i certifikace, které v USA běžně uvádějí poskytovatelé hlasových služeb ve zdravotnictví (HIPAA, SOC&nbsp;2, BAA). Ty však pro slovenskou ambulanci nejsou závazným rámcem. Rozhoduje dohoda o zpracování zvláštních kategorií podle <a href="https://gdpr-info.eu/art-9-gdpr/">GDPR čl.&nbsp;9</a> a jasné místo hostingu či přenosu. Případové studie v nabídce, Lumen Studio Beauty a Hudson River Dental Studio, nejsou nefrologie na Slovensku.</p>
<p>Proto jsem napsal dvanáct otázek pro dodavatele:</p>
<ol>
<li>Jaký je přesný eskalační protokol, když pacient řekne „chci mluvit s člověkem“ nebo „tohle je nouzový případ“?</li>
<li>Co se stane, když AI nedokáže odpovědět a nikdo z personálu není dostupný (po hodinách, o víkendu)?</li>
<li>Je transfer „warm“ (s kontextem), nebo „cold“ (pacient musí opakovat)?</li>
<li>Jak zacházíte se zdravotními daty ve smyslu GDPR čl.&nbsp;9? Máte podepsané DPA? Kde stojí servery a transkripty?</li>
<li>Jaké certifikace máte (SOC&nbsp;2, ISO&nbsp;27001, nebo ekvivalent)?</li>
<li>Jaká je konkrétní měsíční cena? Kolik minut je zahrnutých? Kolik stojí minuta navíc?</li>
<li>Máte reálnou referenci ze slovenské nebo české ambulance (ne zubní klinika u řeky Hudson)?</li>
<li>Jaké jazyky jsou production-grade a jaké jen „claimed-support“? Můžete ukázat transkripty reálných hovorů ve slovenštině?</li>
<li>Jak se testuje kvalita slovenštiny? Máte native-speaker QA pro slovenštinu, češtinu, maďarštinu?</li>
<li>Co se stane, když pacient popisuje příznaky (bolest na hrudi, dušnost)? Rozpozná AI nouzi a nasměruje na 155?</li>
<li>Můžeme spustit 2týdenní pilot na sekundárním čísle dříve, než přesměrujeme hlavní linku?</li>
<li>Kdo technicky stojí za AI enginem? Používáte vlastní model, nebo Vapi/Retell/jinou platformu?</li>
</ol>
<p>Navrhli jsme dvoutýdenní pilot na sekundární lince. Pokud dodavatel odpoví na všech dvanáct, testujeme. Pokud ne, nejdeme dál. Otázky jsem poslal zprostředkovateli; ten je 17.&nbsp;9.&nbsp;2026 přeposlal dodavateli.</p>
<p>Američtí poskytovatelé zaměření na zdravotnictví, například Haven Voice Care, Deskline Health, Callform.ai či Voxora, na svých stránkách uvádějí HIPAA, SOC&nbsp;2 a BAA. To je signál o vyspělosti produktu, ne náhrada za evropskou smlouvu o zpracování údajů. Na klinice nerozhoduje, kdo nasadí hlasovou linku jako první. Rozhoduje, zda pacient, který volá o druhé v noci s bolestí na hrudi, dostane správnou odpověď.</p>
<p><em>Jde o odborný úsudek autora při hodnocení nabídky pro ambulanci, nikoli o recenzi produktu pro pacienty ani o radu volajícím v nouzi. Při akutních příznacích volejte 155/112.</em></p>
HTML,
        ],
        'de' => [
            'title' => 'Ein Anbieter bot uns eine KI-Rezeption mit fließendem Slowakisch an. Statt zu unterschreiben, schrieb ich 12 Fragen.',
            'image_alt' => 'Nächtliche Rezeption einer nephrologischen Praxis: ein Arzt prüft eine Checkliste neben einem unbeantworteten Telefon und einem sanften türkis-violetten Schimmer einer Sprachschnittstelle.',
            'excerpt' => 'Das Angebot versprach, 30 % verpasster Anrufe und hunderttausend Euro im Jahr einzufangen. In den Unterlagen fehlten ein Ausweichplan, die Notfalleskalation und eine Vereinbarung nach DSGVO Art. 9. Deshalb schrieb ich zwölf Fragen und schlug einen zweiwöchigen Pilot vor.',
            'content' => <<<'HTML'
<p>Das Angebot zur AI-Rezeption erreichte mich über einen Vermittler von IMPAX, von einem Vertreter des Anbieters TOMMAX. Auf dem Papier wirkte es stark: etwa 30&nbsp;% verpasster Anrufe auffangen; fließendes Slowakisch und bei Bedarf Tschechisch, Deutsch, Ungarisch oder Englisch; die Ausgabe rechnet sich oft innerhalb eines Monats; geschätzter jährlicher Umsatzbeitrag über 100&nbsp;000&nbsp;Euro.</p>
<p>Die Lücken zeigten sich im Detail.</p>
<p>Slowakisch hat für Sprachmodelle weniger Trainingsdaten als Englisch oder Deutsch. Im Fach heißt das <em>lower-resource</em>. Die beworbene Sprachgewandtheit muss daher nicht zu medizinischen Gesprächen mit älteren Patientinnen und Patienten passen, die Dialekt sprechen, mitten im Satz pausieren oder Symptome umständlich beschreiben.</p>
<p>In den Unterlagen fand ich keinen klaren Ausweichplan und kein Eskalationsprotokoll für Brustschmerz oder Atemnot. Es fehlten auch Zertifizierungen, die US-Healthcare-Voice-Anbieter oft nennen (HIPAA, SOC&nbsp;2, BAA). Das sind US-Instrumente, nicht der verbindliche Rahmen für eine slowakische Praxis. Für uns zählt eine Verarbeitungsvereinbarung für besondere Kategorien nach <a href="https://gdpr-info.eu/art-9-gdpr/">DSGVO Art.&nbsp;9</a> sowie klarer Hosting- und Transferort. Die Fallstudien im Angebot, Lumen Studio Beauty und Hudson River Dental Studio, sind keine Nephrologie in der Slowakei.</p>
<p>Deshalb schrieb ich zwölf Fragen an den Anbieter:</p>
<ol>
<li>Wie lautet das genaue Eskalationsprotokoll, wenn ein Patient sagt „Ich möchte mit einem Menschen sprechen“ oder „Das ist ein Notfall“?</li>
<li>Was passiert, wenn die KI nicht antworten kann und niemand vom Personal erreichbar ist (außerhalb der Stunden, am Wochenende)?</li>
<li>Ist der Transfer „warm“ (mit Kontext) oder „cold“ (der Patient muss wiederholen)?</li>
<li>Wie gehen Sie mit Gesundheitsdaten im Sinne von DSGVO Art.&nbsp;9 um? Haben Sie eine unterzeichnete AVV/DPA? Wo stehen Server und Transkripte?</li>
<li>Welche Zertifizierungen haben Sie (SOC&nbsp;2, ISO&nbsp;27001 oder gleichwertig)?</li>
<li>Wie hoch ist der konkrete Monatspreis? Wie viele Minuten sind enthalten? Was kostet eine Extra-Minute?</li>
<li>Haben Sie eine echte Referenz aus einer slowakischen oder tschechischen Ambulanz (nicht eine Zahnklinik am Hudson)?</li>
<li>Welche Sprachen sind production-grade und welche nur „claimed support“? Können Sie Transkripte echter slowakischer Anrufe zeigen?</li>
<li>Wie wird die Slowakisch-Qualität getestet? Haben Sie Native-Speaker-QA für Slowakisch, Tschechisch, Ungarisch?</li>
<li>Was passiert, wenn ein Patient Symptome beschreibt (Brustschmerz, Dyspnoe)? Erkennt die KI den Notfall und leitet an 155 weiter?</li>
<li>Können wir einen zweiwöchigen Pilot auf einer Nebennummer starten, bevor wir die Hauptleitung umleiten?</li>
<li>Wer steht technisch hinter der KI-Engine? Nutzen Sie ein eigenes Modell oder Vapi/Retell/eine andere Plattform?</li>
</ol>
<p>Wir schlugen einen zweiwöchigen Pilot auf einer Nebenleitung vor. Beantwortet der Anbieter alle zwölf, testen wir. Wenn nicht, gehen wir nicht weiter. Die Fragen schickte ich an den Vermittler; am 17.&nbsp;9.&nbsp;2026 leitete er sie an den Anbieter weiter.</p>
<p>US-Anbieter mit Healthcare-Fokus, etwa Haven Voice Care, Deskline Health, Callform.ai oder Voxora, nennen auf ihren Seiten HIPAA, SOC&nbsp;2 und BAA. Das ist ein Reifesignal, kein Ersatz für eine europäische DPA. In der Klinik kommt es darauf an, ob der Patient, der um 2&nbsp;Uhr nachts mit Brustschmerz anruft, die richtige Antwort bekommt.</p>
<p><em>Dies ist das fachliche Urteil des Autors bei der Bewertung eines Praxisangebots, keine Produktrezension für Patienten und kein Rat für Anrufende in Not. Bei akuten Symptomen 155/112 wählen.</em></p>
HTML,
        ],
        'fr' => [
            'title' => 'Un fournisseur nous a proposé une réceptionniste IA en slovaque courant. Au lieu de signer, j\'ai écrit 12 questions.',
            'image_alt' => 'Réception nocturne d\'un cabinet de néphrologie : un médecin parcourt une liste de contrôle près d\'un téléphone sans réponse et d\'une douce lueur turquoise-violette d\'interface vocale.',
            'excerpt' => 'La proposition promettait de rattraper 30 % des appels manqués et cent mille euros par an. Dans les documents manquaient le repli, l\'escalade d\'urgence et un accord RGPD art. 9. J\'ai donc écrit douze questions et proposé un pilote de deux semaines.',
            'content' => <<<'HTML'
<p>L'offre AI-Réception m'est parvenue via un intermédiaire d'IMPAX, d'un représentant du fournisseur TOMMAX. Sur le papier, elle impressionnait : rattraper environ 30&nbsp;% des appels manqués ; un slovaque courant et, au besoin, le tchèque, l'allemand, le hongrois ou l'anglais ; un retour sur investissement souvent en un mois ; un gain annuel estimé de plus de 100&nbsp;000&nbsp;euros.</p>
<p>Les lacunes sont apparues dans le détail.</p>
<p>Le slovaque fait partie des langues à moindre volume de données d'entraînement pour les modèles vocaux, dites <em>lower-resource</em>. La « fluidité » marketing peut donc ne pas coller aux conversations médicales avec des patients âgés qui parlent dialecte, s'interrompent en milieu de phrase ou décrivent les symptômes de biais.</p>
<p>Dans les documents, je n'ai trouvé ni repli clair ni protocole d'escalade pour douleur thoracique ou dyspnée. Manquaient aussi les certifications que les acteurs vocaux US healthcare citent souvent (HIPAA, SOC&nbsp;2, BAA). Ce sont des instruments américains, pas le cadre contraignant d'un cabinet slovaque. Pour nous, l'essentiel est un accord de traitement des catégories particulières selon l'<a href="https://gdpr-info.eu/art-9-gdpr/">art.&nbsp;9 du RGPD</a>, plus un hébergement et un transfert clairs. Les études de cas de l'offre, Lumen Studio Beauty et Hudson River Dental Studio, ne sont pas de la néphrologie en Slovaquie.</p>
<p>J'ai donc écrit douze questions au fournisseur :</p>
<ol>
<li>Quel est le protocole d'escalade exact lorsqu'un patient dit « je veux parler à un humain » ou « c'est une urgence » ?</li>
<li>Que se passe-t-il lorsque l'IA ne peut pas répondre et qu'aucun membre du personnel n'est disponible (hors horaires, week-end) ?</li>
<li>Le transfert est-il « warm » (avec contexte) ou « cold » (le patient doit répéter) ?</li>
<li>Comment traitez-vous les données de santé au sens de l'art.&nbsp;9 du RGPD ? Avez-vous un DPA signé ? Où sont les serveurs et les transcriptions ?</li>
<li>Quelles certifications avez-vous (SOC&nbsp;2, ISO&nbsp;27001 ou équivalent) ?</li>
<li>Quel est le prix mensuel concret ? Combien de minutes sont incluses ? Combien coûte une minute supplémentaire ?</li>
<li>Avez-vous une référence réelle d'un cabinet slovaque ou tchèque (pas un cabinet dentaire près de l’Hudson) ?</li>
<li>Quelles langues sont production-grade et lesquelles seulement « claimed support » ? Pouvez-vous montrer des transcriptions d'appels réels en slovaque ?</li>
<li>Comment teste-t-on la qualité du slovaque ? Avez-vous une QA locuteur natif pour le slovaque, le tchèque, le hongrois ?</li>
<li>Que se passe-t-il lorsqu'un patient décrit des symptômes (douleur thoracique, dyspnée) ? L'IA reconnaît-elle l'urgence et oriente-t-elle vers le 155 ?</li>
<li>Pouvons-nous lancer un pilote de deux semaines sur un numéro secondaire avant de rediriger la ligne principale ?</li>
<li>Qui alimente techniquement le moteur d'IA ? Utilisez-vous votre propre modèle, ou Vapi/Retell/une autre plateforme ?</li>
</ol>
<p>Nous avons proposé un pilote de deux semaines sur une ligne secondaire. Si le fournisseur répond aux douze, nous testons. Sinon, nous n'avançons pas. J'ai envoyé les questions à l'intermédiaire ; le 17&nbsp;septembre&nbsp;2026, il les a transmises au fournisseur.</p>
<p>Des fournisseurs américains axés santé, par exemple Haven Voice Care, Deskline Health, Callform.ai ou Voxora, indiquent sur leurs sites HIPAA, SOC&nbsp;2 et BAA. C'est un signal de maturité, pas un substitut à un DPA européen. En cabinet, la question est de savoir si le patient qui appelle à 2&nbsp;h du matin avec une douleur thoracique reçoit la bonne réponse.</p>
<p><em>Il s'agit du jugement professionnel de l'auteur lors de l'évaluation d'une offre pour un cabinet, non d'une revue produit pour les patients ni d'un conseil aux appelants en détresse. En cas de symptômes aigus, composez le 155/112.</em></p>
HTML,
        ],
        'es' => [
            'title' => 'Un proveedor nos ofreció una recepcionista de IA con eslovaco fluido. En lugar de firmar, escribí 12 preguntas.',
            'image_alt' => 'Recepción nocturna de una consulta de nefrología: un médico revisa una lista junto a un teléfono sin contestar y un suave resplandor turquesa-violeta de una interfaz de voz.',
            'excerpt' => 'La oferta prometía captar el 30 % de las llamadas perdidas y cien mil euros al año. En los materiales faltaban un plan de reserva, la escalada de emergencia y un acuerdo GDPR art. 9. Por eso escribí doce preguntas y propuse un piloto de dos semanas.',
            'content' => <<<'HTML'
<p>La oferta de AI-Recepción me llegó a través de un intermediario de IMPAX, de un representante del proveedor TOMMAX. Sobre el papel impresionaba: captar aproximadamente el 30&nbsp;% de las llamadas no atendidas; eslovaco fluido y, según necesidad, checo, alemán, húngaro o inglés; retorno de la inversión a menudo en un mes; y un aporte anual estimado de más de 100&nbsp;000&nbsp;euros.</p>
<p>Las lagunas aparecieron en el detalle.</p>
<p>El eslovaco pertenece a las lenguas con menor volumen de datos de entrenamiento para modelos de voz, las llamadas <em>lower-resource</em>. La «fluidez» de marketing puede no encajar con conversaciones médicas con pacientes mayores que usan dialecto, hacen pausas a mitad de frase o describen síntomas de forma indirecta.</p>
<p>En los materiales no encontré un plan de reserva claro ni un protocolo de escalada para dolor torácico o disnea. Tampoco presentaban las certificaciones que suelen citar los proveedores de voz sanitaria en EE.&nbsp;UU. (HIPAA, SOC&nbsp;2, BAA). Son instrumentos estadounidenses, no el marco vinculante de una consulta eslovaca. Para nosotros cuenta un acuerdo de tratamiento de categorías especiales según el <a href="https://gdpr-info.eu/art-9-gdpr/">art.&nbsp;9 del GDPR</a> y un alojamiento o transferencia claros. Los estudios de caso de la oferta, Lumen Studio Beauty y Hudson River Dental Studio, no son nefrología en Eslovaquia.</p>
<p>Por eso escribí doce preguntas al proveedor:</p>
<ol>
<li>¿Cuál es el protocolo exacto de escalada cuando un paciente dice «quiero hablar con una persona» o «esto es una emergencia»?</li>
<li>¿Qué ocurre cuando la IA no puede responder y nadie del personal está disponible (fuera de horario, fin de semana)?</li>
<li>¿La transferencia es «warm» (con contexto) o «cold» (el paciente debe repetir)?</li>
<li>¿Cómo tratan los datos de salud según el art.&nbsp;9 del GDPR? ¿Tienen un DPA firmado? ¿Dónde están los servidores y las transcripciones?</li>
<li>¿Qué certificaciones tienen (SOC&nbsp;2, ISO&nbsp;27001 o equivalente)?</li>
<li>¿Cuál es el precio mensual concreto? ¿Cuántos minutos están incluidos? ¿Cuánto cuesta un minuto extra?</li>
<li>¿Tienen una referencia real de una consulta eslovaca o checa (no una clínica dental junto al Hudson)?</li>
<li>¿Qué idiomas son production-grade y cuáles solo «claimed support»? ¿Pueden mostrar transcripciones de llamadas reales en eslovaco?</li>
<li>¿Cómo se prueba la calidad del eslovaco? ¿Tienen QA con hablantes nativos para eslovaco, checo y húngaro?</li>
<li>¿Qué ocurre cuando un paciente describe síntomas (dolor torácico, disnea)? ¿La IA reconoce la emergencia y deriva al 155?</li>
<li>¿Podemos lanzar un piloto de dos semanas en un número secundario antes de redirigir la línea principal?</li>
<li>¿Quién impulsa técnicamente el motor de IA? ¿Usan su propio modelo, o Vapi/Retell/otra plataforma?</li>
</ol>
<p>Propusimos un piloto de dos semanas en una línea secundaria. Si el proveedor responde a las doce, probamos. Si no, no seguimos. Envié las preguntas al intermediario; el 17&nbsp;de&nbsp;septiembre&nbsp;de&nbsp;2026 las reenvió al proveedor.</p>
<p>Proveedores estadounidenses centrados en sanidad, por ejemplo Haven Voice Care, Deskline Health, Callform.ai o Voxora, indican en sus sitios HIPAA, SOC&nbsp;2 y BAA. Es una señal de madurez, no un sustituto de un DPA europeo. En la consulta importa si el paciente que llama a las 2&nbsp;de la madrugada con dolor torácico recibe la respuesta correcta.</p>
<p><em>Se trata del juicio profesional del autor al valorar una oferta para una consulta, no de una reseña de producto para pacientes ni de consejo a quienes llaman en urgencia. Ante síntomas agudos, llame al 155/112.</em></p>
HTML,
        ],
        'pl' => [
            'title' => 'Dostawca zaproponował nam recepcję AI z płynnym słowackim. Zamiast podpisać napisałem 12 pytań.',
            'image_alt' => 'Nocna recepcja poradni nefrologicznej: lekarz przegląda listę kontrolną obok nieodebranego telefonu i miękkiej turkusowo-fioletowej poświaty interfejsu głosowego.',
            'excerpt' => 'Oferta obiecywała przechwycić 30 % nieodebranych połączeń i sto tysięcy euro rocznie. W materiałach brakowało planu awaryjnego, eskalacji nagłych przypadków i umowy RODO art. 9. Dlatego napisałem dwanaście pytań i zaproponowałem dwutygodniowy pilotaż.',
            'content' => <<<'HTML'
<p>Ofertę AI-Recepcji dostałem przez pośrednika z IMPAX, od przedstawiciela dostawcy TOMMAX. Na papierze wyglądała imponująco: przechwycić około 30&nbsp;% nieodebranych połączeń; płynny słowacki i w razie potrzeby czeski, niemiecki, węgierski lub angielski; zwrot często w miesiąc; szacowany roczny wzrost przychodów powyżej 100&nbsp;tys. euro.</p>
<p>Luki wyszły w szczegółach.</p>
<p>Słowacki ma dla modeli głosowych mniej danych treningowych niż angielski czy niemiecki. W branży nazywa się to językiem o mniejszym zasobie, <em>lower-resource</em>. Marketingowa „płynność” może więc nie pasować do rozmów medycznych ze starszymi pacjentami, którzy mówią dialektem, robią pauzy w środku zdania lub opisują objawy okrężnie.</p>
<p>W materiałach nie znalazłem jasnego planu awaryjnego ani protokołu eskalacji przy bólu w klatce piersiowej czy duszności. Brakowało też certyfikacji, które w USA często podają dostawcy usług głosowych w ochronie zdrowia (HIPAA, SOC&nbsp;2, BAA). To jednak ramy amerykańskie, nie wiążące dla słowackiej poradni. Dla nas decyduje umowa o przetwarzaniu szczególnych kategorii według <a href="https://gdpr-info.eu/art-9-gdpr/">art.&nbsp;9 RODO</a> oraz jasne miejsce hostingu i transferu. Studia przypadków w ofercie, Lumen Studio Beauty i Hudson River Dental Studio, to nie nefrologia na Słowacji.</p>
<p>Dlatego napisałem dwanaście pytań do dostawcy:</p>
<ol>
<li>Jaki jest dokładny protokół eskalacji, gdy pacjent powie „chcę mówić z człowiekiem” lub „to nagły przypadek”?</li>
<li>Co się stanie, gdy AI nie potrafi odpowiedzieć i nikt z personelu nie jest dostępny (po godzinach, w weekend)?</li>
<li>Czy transfer jest „warm” (z kontekstem), czy „cold” (pacjent musi powtórzyć)?</li>
<li>Jak obchodzicie się z danymi zdrowotnymi w sensie art.&nbsp;9 RODO? Czy macie podpisaną DPA? Gdzie stoją serwery i transkrypty?</li>
<li>Jakie macie certyfikacje (SOC&nbsp;2, ISO&nbsp;27001 lub równoważne)?</li>
<li>Jaka jest konkretna miesięczna cena? Ile minut jest wliczonych? Ile kosztuje minuta ekstra?</li>
<li>Czy macie realną referencję ze słowackiej lub czeskiej poradni (nie klinika stomatologiczna nad Hudsonem)?</li>
<li>Które języki są production-grade, a które tylko „claimed support”? Czy możecie pokazać transkrypty prawdziwych rozmów po słowacku?</li>
<li>Jak testowana jest jakość słowackiego? Czy macie native-speaker QA dla słowackiego, czeskiego, węgierskiego?</li>
<li>Co się stanie, gdy pacjent opisuje objawy (ból w klatce, duszność)? Czy AI rozpozna nagły przypadek i skieruje na 155?</li>
<li>Czy możemy uruchomić dwutygodniowy pilotaż na numerze dodatkowym, zanim przekierujemy główną linię?</li>
<li>Kto technicznie stoi za silnikiem AI? Używacie własnego modelu, czy Vapi/Retell/innej platformy?</li>
</ol>
<p>Zaproponowaliśmy dwutygodniowy pilotaż na linii dodatkowej. Jeśli dostawca odpowie na wszystkie dwanaście, testujemy. Jeśli nie, nie idziemy dalej. Pytania wysłałem pośrednikowi; 17&nbsp;września&nbsp;2026 przekazał je dostawcy.</p>
<p>Amerykańscy dostawcy skupieni na ochronie zdrowia, np. Haven Voice Care, Deskline Health, Callform.ai czy Voxora, na swoich stronach podają HIPAA, SOC&nbsp;2 i BAA. To sygnał dojrzałości produktu, nie zastępstwo europejskiej DPA. W poradni decyduje to, czy pacjent dzwoniący o drugiej w nocy z bólem w klatce dostanie właściwą odpowiedź.</p>
<p><em>To fachowa ocena autora przy rozpatrywaniu oferty dla poradni, nie recenzja produktu dla pacjentów ani rada dla dzwoniących w nagłym przypadku. Przy ostrych objawach dzwońcie 155/112.</em></p>
HTML,
        ],
        'hu' => [
            'title' => 'Egy szállító folyékony szlovákul beszélő AI-recepcióst ajánlott. Aláírás helyett 12 kérdést írtam.',
            'image_alt' => 'Éjszakai nefrológiai rendelő-recepció: orvos ellenőrző listát néz, mellette villogó, felvételen telefon és lágy türkiz-lila hanginterfész-fény.',
            'excerpt' => 'Az ajánlat a nem fogadott hívások 30 százalékának és évi százezer euró bevételnek a megfogását ígérte. Az anyagokból hiányzott a tartalék eljárás, a vészhelyzeti eszkaláció és a GDPR 9. cikk szerinti megállapodás. Ezért tizenkét kérdést írtam, és kéthetes próbaüzemet javasoltam.',
            'content' => <<<'HTML'
<p>Az AI-Recepciós ajánlat egy IMPAX-os közvetítőn keresztül érkezett, a TOMMAX egy képviselőjétől. Papíron erősnek tűnt: kb. 30&nbsp;% elmulasztott hívás megfogása; folyékony szlovák, szükség szerint cseh, német, magyar vagy angol; gyakran egy hónapon belüli megtérülés; évi 100&nbsp;000&nbsp;euró feletti becsült bevételnövekmény.</p>
<p>A hiányosságok a részletekben jelentek meg.</p>
<p>A szlovák a hangmodellek számára kisebb tanítóadatú (úgynevezett <em>lower-resource</em>) nyelv. A marketing „folyékonyság” ezért nem feltétlenül illik idősebb, dialektust beszélő, mondat közben szünetelő vagy kerülő úton panaszoló betegek orvosi beszélgetéseihez.</p>
<p>Az anyagokban nem találtam világos tartalék eljárást, sem mellkasi fájdalomra vagy nehézlégzésre vonatkozó eszkalációs protokollt. Hiányoztak azok a tanúsítványok is, amelyeket az amerikai healthcare voice szereplők gyakran említenek (HIPAA, SOC&nbsp;2, BAA). Ezek amerikai eszközök, nem a szlovák rendelő kötelező kerete. Nálunk a <a href="https://gdpr-info.eu/art-9-gdpr/">GDPR 9.&nbsp;cikk</a> szerinti különleges kategóriák feldolgozási megállapodása és a hosting/átadás helye a lényeg. Az ajánlat esettanulmányai, Lumen Studio Beauty és Hudson River Dental Studio, nem szlovákiai nefrológia.</p>
<p>Ezért tizenkét kérdést írtam a szállítónak:</p>
<ol>
<li>Mi a pontos eszkalációs protokoll, ha a beteg azt mondja: „emberrel akarok beszélni” vagy „ez sürgős eset”?</li>
<li>Mi történik, ha az AI nem tud válaszolni, és senki a személyzetből nem elérhető (nyitvatartáson kívül, hétvégén)?</li>
<li>A továbbítás „warm” (kontextussal) vagy „cold” (a betegnek ismételnie kell)?</li>
<li>Hogyan kezelik az egészségügyi adatokat a GDPR 9.&nbsp;cikk szerint? Van aláírt DPA? Hol vannak a szerverek és a transcripttek?</li>
<li>Milyen tanúsítványaik vannak (SOC&nbsp;2, ISO&nbsp;27001 vagy egyenértékű)?</li>
<li>Mi a konkrét havi ár? Hány perc van benne? Mennyibe kerül egy extra perc?</li>
<li>Van valódi referenciájuk szlovák vagy cseh rendelőből (nem hudson-parti fogászati klinika)?</li>
<li>Mely nyelvek production-grade, és melyek csak „claimed support”? Mutatnak valódi szlovák hívások transcriptjeit?</li>
<li>Hogyan tesztelik a szlovák minőségét? Van anyanyelvi QA szlovákra, csehre, magyarra?</li>
<li>Mi történik, ha a beteg tüneteket ír le (mellkasi fájdalom, dyspnoe)? Felismeri az AI a vészhelyzetet és a 155-re irányít?</li>
<li>Indíthatunk kéthetes pilotot másodlagos számon, mielőtt átirányítjuk a fővonalat?</li>
<li>Ki áll technikailag az AI-motor mögött? Saját modellt használnak, vagy Vapi/Retell/más platformot?</li>
</ol>
<p>Kéthetes próbaüzemet javasoltunk másodlagos vonalon. Ha a szállító mind a tizenkettőre válaszol, tesztelünk. Ha nem, nem megyünk tovább. A kérdéseket elküldtem a közvetítőnek; ő 2026.&nbsp;szeptember&nbsp;17-én továbbította a szállítónak.</p>
<p>Az amerikai, egészségügyre fókuszáló szolgáltatók, pl. Haven Voice Care, Deskline Health, Callform.ai vagy Voxora, oldalukon HIPAA-t, SOC&nbsp;2-t és BAA-t említenek. Ez érettségi jel, nem európai DPA-pótlék. A rendelőben az dönt, hogy a hajnali 2-kor mellkasi fájdalommal hívó beteg helyes választ kap-e.</p>
<p><em>Ez a szerző szakmai ítélete egy rendelői ajánlat értékelésekor, nem termékismertető betegeknek, és nem tanács vészhelyzetben hívóknak. Akut tüneteknél hívja a 155/112-t.</em></p>
HTML,
        ],
        'it' => [
            'title' => 'Un fornitore ci ha proposto una receptionist IA con slovacco fluido. Invece di firmare ho scritto 12 domande.',
            'image_alt' => 'Reception notturna di un ambulatorio di nefrologia: un medico esamina un elenco di controllo accanto a un telefono senza risposta e a un bagliore tenue turchese-viola di un\'interfaccia vocale.',
            'excerpt' => 'L\'offerta prometteva di intercettare il 30 % delle chiamate perse e centomila euro l\'anno. Nei materiali mancavano un piano di riserva, escalation di emergenza e un accordo GDPR art. 9. Perciò ho scritto dodici domande e proposto un pilota di due settimane.',
            'content' => <<<'HTML'
<p>L'offerta AI-Reception mi è arrivata tramite un intermediario di IMPAX, da un rappresentante del fornitore TOMMAX. Sulla carta sembrava solida: intercettare circa il 30&nbsp;% delle chiamate non risposte; slovacco fluido e, se necessario, ceco, tedesco, ungherese o inglese; ROI spesso entro un mese; contributo annuale stimato oltre 100&nbsp;000&nbsp;euro.</p>
<p>Le lacune sono emerse nei dettagli.</p>
<p>Lo slovacco è una lingua con meno dati di addestramento per i modelli vocali, detta <em>lower-resource</em>. La «fluidità» di marketing quindi può non combaciare con conversazioni mediche con pazienti anziani che usano il dialetto, fanno pause a metà frase o descrivono i sintomi in modo indiretto.</p>
<p>Nei materiali non ho trovato un piano di riserva chiaro né un protocollo di escalation per dolore toracico o dispnea. Mancavano anche le certificazioni che i fornitori vocali healthcare USA citano spesso (HIPAA, SOC&nbsp;2, BAA): strumenti americani, non il quadro vincolante di un ambulatorio slovacco. Per noi conta un accordo di trattamento delle categorie particolari secondo l'<a href="https://gdpr-info.eu/art-9-gdpr/">art.&nbsp;9 del GDPR</a> e un hosting/trasferimento chiari. I casi citati nell'offerta, Lumen Studio Beauty e Hudson River Dental Studio, non sono nefrologia in Slovacchia.</p>
<p>Perciò ho scritto dodici domande al fornitore:</p>
<ol>
<li>Qual è l'esatto protocollo di escalation quando un paziente dice «voglio parlare con una persona» o «è un'emergenza»?</li>
<li>Cosa succede quando l'IA non sa rispondere e nessuno del personale è disponibile (fuori orario, weekend)?</li>
<li>Il trasferimento è «warm» (con contesto) o «cold» (il paziente deve ripetere)?</li>
<li>Come gestite i dati sanitari ai sensi dell'art.&nbsp;9 del GDPR? Avete un DPA firmato? Dove stanno server e trascrizioni?</li>
<li>Quali certificazioni avete (SOC&nbsp;2, ISO&nbsp;27001 o equivalente)?</li>
<li>Qual è il prezzo mensile concreto? Quanti minuti sono inclusi? Quanto costa un minuto extra?</li>
<li>Avete un riferimento reale da un ambulatorio slovacco o ceco (non uno studio dentistico sull’Hudson)?</li>
<li>Quali lingue sono production-grade e quali solo «claimed support»? Potete mostrare trascrizioni di chiamate reali in slovacco?</li>
<li>Come si testa la qualità dello slovacco? Avete QA madrelingua per slovacco, ceco, ungherese?</li>
<li>Cosa succede quando un paziente descrive sintomi (dolore toracico, dispnea)? L'IA riconosce l'emergenza e indirizza al 155?</li>
<li>Possiamo avviare un pilota di due settimane su un numero secondario prima di reindirizzare la linea principale?</li>
<li>Chi alimenta tecnicamente il motore IA? Usate un modello proprio o Vapi/Retell/un'altra piattaforma?</li>
</ol>
<p>Abbiamo proposto un pilota di due settimane su una linea secondaria. Se il fornitore risponde a tutte e dodici, testiamo. Se no, non proseguiamo. Ho inviato le domande all'intermediario; il 17&nbsp;settembre&nbsp;2026 le ha inoltrate al fornitore.</p>
<p>Fornitori USA orientati alla sanità, ad esempio Haven Voice Care, Deskline Health, Callform.ai o Voxora, indicano sui propri siti HIPAA, SOC&nbsp;2 e BAA. È un segnale di maturità, non un sostituto di un DPA europeo. In ambulatorio conta se il paziente che chiama alle 2&nbsp;di notte con dolore toracico riceve la risposta giusta.</p>
<p><em>Si tratta del giudizio professionale dell'autore nella valutazione di un'offerta per ambulatorio, non di una recensione di prodotto per i pazienti né di un consiglio per chi chiama in emergenza. In caso di sintomi acuti, chiamare 155/112.</em></p>
HTML,
        ],
        'uk' => [
            'title' => 'Постачальник запропонував нам AI-рецепцію з вільною словацькою. Замість підпису я написав 12 запитань.',
            'image_alt' => 'Нічна рецепція нефрологічного кабінету: лікар переглядає перелік біля не піднятого телефону та м’якого бірюзово-фіолетового сяйва голосового інтерфейсу.',
            'excerpt' => 'Пропозиція обіцяла перехопити 30 % пропущених дзвінків і сто тисяч євро на рік. У матеріалах бракувало запасного порядку, ескалації невідкладності та угоди за ст. 9 GDPR. Тому я написав дванадцять запитань і запропонував двотижневий пілот.',
            'content' => <<<'HTML'
<p>Пропозиція AI-Рецепції надійшла через посередника з IMPAX, від представника постачальника TOMMAX. На папері виглядала сильно: перехопити приблизно 30&nbsp;% пропущених дзвінків; вільна словацька й за потреби чеська, німецька, угорська чи англійська; окупність часто за місяць; оцінений річний приріст виручки понад 100&nbsp;тисяч євро.</p>
<p>Прогалини вийшли в подробицях.</p>
<p>Словацька належить до мов із меншим обсягом навчальних даних для голосових моделей, так званих <em>lower-resource</em>. Маркетингова «плинність» тому може не збігатися з медичними розмовами з літніми пацієнтами, які говорять діалектом, роблять паузи посеред речення або описують симптоми опосередковано.</p>
<p>У матеріалах я не знайшов чіткого запасного порядку і протоколу ескалації при болю в грудях чи задишці. Бракувало й сертифікацій, які в США часто згадують постачальники голосових сервісів у медицині (HIPAA, SOC&nbsp;2, BAA). Це американські інструменти, не обов’язкова рамка для словацької амбулаторії. Для нас вирішує угода про обробку особливих категорій за <a href="https://gdpr-info.eu/art-9-gdpr/">ст.&nbsp;9 GDPR</a> і зрозуміле місце хостингу чи передачі. Приклади в пропозиції, Lumen Studio Beauty і Hudson River Dental Studio, не є нефрологією в Словаччині.</p>
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
<p>Ми запропонували двотижневий пілот на вторинній лінії. Якщо постачальник відповість на всі дванадцять, тестуємо. Якщо ні, не йдемо далі. Запитання я надіслав посереднику; 17&nbsp;вересня&nbsp;2026 він переслав їх постачальнику.</p>
<p>Американські провайдери з фокусом на охорону здоров’я, наприклад Haven Voice Care, Deskline Health, Callform.ai чи Voxora, на своїх сайтах зазначають HIPAA, SOC&nbsp;2 і BAA. Це сигнал зрілості продукту, а не заміна європейській DPA. В амбулаторії вирішує те, чи пацієнт, який дзвонить о другій ночі з болем у грудях, отримає правильну відповідь.</p>
<p><em>Це фахова оцінка автора при розгляді пропозиції для амбулаторії, не огляд продукту для пацієнтів і не порада тим, хто дзвонить у невідкладності. При гострих симптомах телефонуйте 155/112.</em></p>
HTML,
        ],
    ],
];
