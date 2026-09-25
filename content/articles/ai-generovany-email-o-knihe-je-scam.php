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
 * Osobný blogový príspevok: AI-generovaný phishing e-mail o knihe Elimination.
 * Zdroj: e-mail od neznámeho odosielateľa s vymysleným menom (throwaway Gmail), overené zdroje júl 2025 – 2026.
 */
return [
    'slug' => 'ai-generovany-email-o-knihe-je-scam',
    'author' => 'MUDr. Ľubomír Polaščín',
    'category' => 'blog',
    'is_top' => 0,
    'published_at' => '2026-09-20 16:30:00',
    'image' => 'images/articles/ai-generovany-email-o-knihe-je-scam.webp',
    'translations' => [
        'sk' => [
            'title' => 'Lichotivý e-mail o mojej knihe. Napísal ho bot, nie čitateľ.',
            'image_alt' => 'Nočný písací stôl: otvorená kniha, laptop a tyrkysová holografická postava, ktorá skladá žiariacu obálku.',
            'excerpt' => 'Prišiel mi e-mail od neznámeho odosielateľa. Chválil knihu Elimination, spomenul gymnázium v Starej Ľubovni a pýtal sa na medicínske vzdelanie. Všetko to bolo z Amazona. Od leta 2025 ide o vlnu AI phishingu na autorov. Neodpovedajte.',
            'content' => <<<'HTML'
<p>Prišiel mi lichotivý e-mail o knihe <em>Elimination: Get out of my body</em>. Odosielateľ sa predstavil vymysleným menom. Písal, že kniha mu utkvela, lebo „prináša dlhoročné nefrologické a dialyzačné skúsenosti do praktického sprievodcu“. Pýtal sa, ako moje medicínske vzdelanie a literárna práca knihu formovali.</p>
<p>Znelo to ako čitateľ. Nebol.</p>
<p>Adresa bola throwaway Gmail s náhodnými číslami: <em>fransicmason3598@gmail.com</em>. Žiadna firma, žiadny web, žiadny podpis. Text bol príliš uhladený a príliš všeobecný — ani jedna konkrétna kapitola, veta, scéna z knihy. Školu a mesto — Gymnázium Terézie Vansovej v Starej Ľubovni — vytiahol z verejného Amazon KDP author bio. „Osobná“ chvála kopírovala <a href="https://www.amazon.com/dp/1090779291">blurb na Amazone</a>: kniha je stručný sprievodca eliminačnou liečbou a dialýzou, nie spomienka niekoho, kto ju čítal.</p>
<p>Háčik bol otvorený: odpovedzte, rád sa dozviem viac. Cieľ nie je rozhovor. Cieľ je potvrdiť, že adresa žije.</p>
<p>Od leta 2025 ide o vlnu. <a href="https://jonathanemmett.com/2025/07/authors-beware-if-you-receive-a-flattering-email-about-your-book-it-may-be-from-an-ai.html">autor verejného blogu</a> ju v júli 2025 popísal na svojom blogu: lichotivý e-mail o knihe, Gmail, detektor AI na 100&nbsp;%, žiadosť o odpoveď. Autori na <a href="https://www.reddit.com/r/selfpublish/comments/1vbs1hz/author_psa_were_being_hit_by_a_tsunami_of_really">r/selfpublish</a> hlásia „cunami“ takých správ. <a href="https://electricliterature.com/that-personalized-email-about-loving-and-marketing-your-book-is-a-scam/">Electric Literature</a> ukázala, že po odpovedi príde ponuka „marketingu“ za stovky dolárov. <a href="https://authorsguild.org/resource/publishing-scam-alerts">Authors Guild</a> v októbri 2025 varovala pred explóziou AI-vylepšených scam e-mailov. Watchdog Writer Beware to isté sleduje ešte v roku 2026.</p>
<p>Po odpovedi zvyčajne príde žiadosť o peniaze za „book promotion“, phishing o identitu, odkaz na malware, alebo „investičná príležitosť“. Jeden autor v komentári pod tým článkom napísal, že bot mu ublížil na pocitoch: za dva dni päť takých e-mailov, všetky 100&nbsp;% AI.</p>
<p>Neodpovedal som. Ani „ďakujem, nemám záujem“. <a href="https://caniphish.com/blog/responding-to-a-phishing-email">CanIPhish</a> to vysvetľuje jednoducho: odpoveď je signál, že adresa je aktívna a pravidelne kontrolovaná. Zaradí vás do ďalších zoznamov.</p>
<p>V Gmaile som správu označil ako spam a odosielateľa zablokoval. Vymazať nestačí — filter sa učí z označenia.</p>
<p>Ak publikujete na Amazone, pozrite si author bio. Škola, mesto, mená učiteľov sú verejné krmivo pre botov, ktorí z nich skladajú ilúziu lokálneho spojenia.</p>
<p>Dostali ste podobný e-mail? Napíšte mi cez <a href="contact.php">kontakt</a>. Nie odosielateľovi.</p>
<p><em>Ide o osobnú skúsenosť, nie o právnu radu. Podozrivú správu nahláste poskytovateľovi e-mailu.</em></p>
HTML,
        ],
        'en' => [
            'title' => 'A flattering email about my book. A bot wrote it, not a reader.',
            'image_alt' => 'A night-time writing desk: an open book, a laptop, and a teal holographic figure folding a glowing envelope.',
            'excerpt' => 'I got an email from an unknown sender. It praised Elimination, named my grammar school in Stará Ľubovňa, and asked about my medical education. All of it came from Amazon. Since summer 2025 this has been a wave of AI phishing aimed at authors. Do not reply.',
            'content' => <<<'HTML'
<p>I received a flattering email about my book <em>Elimination: Get out of my body</em>. The sender introduced himself under a made-up name. He wrote that the book stood out because it “brings your long nephrology and dialysis experience into a practical guide.” He asked how my medical education and literary work informed the book.</p>
<p>It sounded like a reader. It was not.</p>
<p>The address was a throwaway Gmail with random digits: <em>fransicmason3598@gmail.com</em>. No company, no website, no signature. The prose was too polished and too generic — not one specific chapter, sentence, or scene from the book. The school and the town — Gymnázium Terézie Vansovej in Stará Ľubovňa — were lifted from the public Amazon KDP author bio. The “personal” praise copied the <a href="https://www.amazon.com/dp/1090779291">Amazon blurb</a>: the book is a short handbook on elimination treatment and dialysis, not a memory of someone who read it.</p>
<p>The hook was open: reply, I would be glad to learn more. The goal is not a conversation. The goal is to confirm that the address is live.</p>
<p>This has been a wave since summer 2025. <a href="https://jonathanemmett.com/2025/07/authors-beware-if-you-receive-a-flattering-email-about-your-book-it-may-be-from-an-ai.html">a public blogger</a> described it in July 2025: a flattering email about a book, Gmail, an AI detector at 100&nbsp;%, a request for a reply. Authors on <a href="https://www.reddit.com/r/selfpublish/comments/1vbs1hz/author_psa_were_being_hit_by_a_tsunami_of_really">r/selfpublish</a> report a “tsunami” of such messages. <a href="https://electricliterature.com/that-personalized-email-about-loving-and-marketing-your-book-is-a-scam/">Electric Literature</a> showed that a reply is followed by a “marketing” offer for hundreds of dollars. The <a href="https://authorsguild.org/resource/publishing-scam-alerts">Authors Guild</a> warned in October 2025 of an explosion of AI-enhanced scam emails. Writer Beware is still tracking the same pattern in 2026.</p>
<p>After a reply there usually comes a request for money for “book promotion,” an identity phish, a malware link, or an “investment opportunity.” One author in a comment under that post wrote that the bot hurt their feelings: five such emails in two days, all 100&nbsp;% AI.</p>
<p>I did not reply. Not even “thank you, I am not interested.” <a href="https://caniphish.com/blog/responding-to-a-phishing-email">CanIPhish</a> puts it simply: a reply signals that the address is active and regularly checked. It puts you on further lists.</p>
<p>In Gmail I marked the message as spam and blocked the sender. Deleting is not enough — the filter learns from the spam label.</p>
<p>If you publish on Amazon, look at your author bio. School, town, teachers’ names are public feed for bots that assemble the illusion of a local connection.</p>
<p>Have you received a similar email? Write to me via the <a href="contact.php">contact form</a>. Not to the sender.</p>
<p><em>This is a personal account, not legal advice. Report a suspicious message to your email provider.</em></p>
HTML,
        ],
        'cs' => [
            'title' => 'Lichotivý e-mail o mé knize. Napsal ho bot, ne čtenář.',
            'image_alt' => 'Noční psací stůl: otevřená kniha, laptop a tyrkysová holografická postava, která skládá zářící obálku.',
            'excerpt' => 'Přišel mi e-mail od neznámého odesílatele. Chválil knihu Elimination, zmínil gymnázium ve Staré Ľubovni a ptal se na lékařské vzdělání. Všechno to bylo z Amazonu. Od léta 2025 jde o vlnu AI phishingu na autory. Neodpovídejte.',
            'content' => <<<'HTML'
<p>Přišel mi lichotivý e-mail o knize <em>Elimination: Get out of my body</em>. Odesílatel se představil vymyšleným jménem. Psal, že kniha mu utkvěla, protože „přináší dlouholeté nefrologické a dialyzační zkušenosti do praktického průvodce“. Ptal se, jak mé lékařské vzdělání a literární práce knihu formovaly.</p>
<p>Znělo to jako čtenář. Nebyl.</p>
<p>Adresa byla throwaway Gmail s náhodnými čísly: <em>fransicmason3598@gmail.com</em>. Žádná firma, žádný web, žádný podpis. Text byl příliš uhlazený a příliš obecný — ani jedna konkrétní kapitola, věta, scéna z knihy. Školu a město — Gymnázium Terézie Vansovej ve Staré Ľubovni — vytáhl z veřejného Amazon KDP author bio. „Osobní“ chvála kopírovala <a href="https://www.amazon.com/dp/1090779291">blurb na Amazonu</a>: kniha je stručný průvodce eliminační léčbou a dialýzou, ne vzpomínka někoho, kdo ji četl.</p>
<p>Háček byl otevřený: odpovězte, rád se dozvím víc. Cíl není rozhovor. Cíl je potvrdit, že adresa žije.</p>
<p>Od léta 2025 jde o vlnu. <a href="https://jonathanemmett.com/2025/07/authors-beware-if-you-receive-a-flattering-email-about-your-book-it-may-be-from-an-ai.html">autor veřejného blogu</a> ji v červenci 2025 popsal na svém blogu: lichotivý e-mail o knize, Gmail, detektor AI na 100&nbsp;%, žádost o odpověď. Autoři na <a href="https://www.reddit.com/r/selfpublish/comments/1vbs1hz/author_psa_were_being_hit_by_a_tsunami_of_really">r/selfpublish</a> hlásí „cunami“ takových zpráv. <a href="https://electricliterature.com/that-personalized-email-about-loving-and-marketing-your-book-is-a-scam/">Electric Literature</a> ukázala, že po odpovědi přijde nabídka „marketingu“ za stovky dolarů. <a href="https://authorsguild.org/resource/publishing-scam-alerts">Authors Guild</a> v říjnu 2025 varovala před explozí AI-vylepšených scam e-mailů. Watchdog Writer Beware totéž sleduje ještě v roce 2026.</p>
<p>Po odpovědi obvykle přijde žádost o peníze za „book promotion“, phishing o identitu, odkaz na malware, nebo „investiční příležitost“. Jeden autor v komentáři pod tím článkem napsal, že bot mu ublížil na pocitech: za dva dny pět takových e-mailů, všechny 100&nbsp;% AI.</p>
<p>Neodpověděl jsem. Ani „děkuji, nemám zájem“. <a href="https://caniphish.com/blog/responding-to-a-phishing-email">CanIPhish</a> to vysvětluje jednoduše: odpověď je signál, že adresa je aktivní a pravidelně kontrolovaná. Zařadí vás do dalších seznamů.</p>
<p>V Gmailu jsem zprávu označil jako spam a odesílatele zablokoval. Smazat nestačí — filtr se učí z označení.</p>
<p>Pokud publikujete na Amazonu, podívejte se na author bio. Škola, město, jména učitelů jsou veřejné krmivo pro boty, kteří z nich skládají iluzi místního spojení.</p>
<p>Dostali jste podobný e-mail? Napište mi přes <a href="contact.php">kontakt</a>. Ne odesílateli.</p>
<p><em>Jde o osobní zkušenost, ne o právní radu. Podezřelou zprávu nahlaste poskytovateli e-mailu.</em></p>
HTML,
        ],
        'de' => [
            'title' => 'Eine schmeichelhafte E-Mail über mein Buch. Geschrieben hat sie ein Bot, kein Leser.',
            'image_alt' => 'Ein nächtlicher Schreibtisch: aufgeschlagenes Buch, Laptop und eine türkise holografische Figur, die einen leuchtenden Umschlag faltet.',
            'excerpt' => 'Ich bekam eine E-Mail von einem unbekannten Absender. Sie lobte Elimination, nannte mein Gymnasium in Stará Ľubovňa und fragte nach der medizinischen Ausbildung. Alles stammte von Amazon. Seit Sommer 2025 läuft eine Welle von KI-Phishing gegen Autoren. Nicht antworten.',
            'content' => <<<'HTML'
<p>Ich habe eine schmeichelhafte E-Mail über mein Buch <em>Elimination: Get out of my body</em> bekommen. Der Absender stellte sich mit einem erfundenen Namen vor. Er schrieb, das Buch sei ihm aufgefallen, weil es „Ihre lange nephrologische und dialytische Erfahrung in einen praktischen Leitfaden bringt“. Er fragte, wie meine medizinische Ausbildung und literarische Arbeit das Buch geprägt hätten.</p>
<p>Es klang wie ein Leser. Es war keiner.</p>
<p>Die Adresse war ein Wegwerf-Gmail mit Zufallszahlen: <em>fransicmason3598@gmail.com</em>. Keine Firma, keine Website, keine Signatur. Der Text war zu glatt und zu allgemein — kein einziges konkretes Kapitel, kein Satz, keine Szene aus dem Buch. Schule und Stadt — das Gymnázium Terézie Vansovej in Stará Ľubovňa — stammten aus der öffentlichen Amazon-KDP-Autorenbio. Das „persönliche“ Lob kopierte den <a href="https://www.amazon.com/dp/1090779291">Amazon-Klappentext</a>: das Buch ist ein kurzer Leitfaden zur Eliminationstherapie und Dialyse, keine Erinnerung jemandes, der es gelesen hat.</p>
<p>Der Haken war offen: Antworten Sie, ich würde gerne mehr erfahren. Das Ziel ist kein Gespräch. Das Ziel ist zu bestätigen, dass die Adresse lebt.</p>
<p>Seit Sommer 2025 läuft eine Welle. <a href="https://jonathanemmett.com/2025/07/authors-beware-if-you-receive-a-flattering-email-about-your-book-it-may-be-from-an-ai.html">ein öffentlicher Blogger</a> hat sie im Juli 2025 in seinem Blog beschrieben: schmeichelhafte E-Mail über ein Buch, Gmail, KI-Detektor bei 100&nbsp;%, Bitte um Antwort. Autoren auf <a href="https://www.reddit.com/r/selfpublish/comments/1vbs1hz/author_psa_were_being_hit_by_a_tsunami_of_really">r/selfpublish</a> berichten von einem „Tsunami“ solcher Nachrichten. <a href="https://electricliterature.com/that-personalized-email-about-loving-and-marketing-your-book-is-a-scam/">Electric Literature</a> zeigte, dass auf eine Antwort ein „Marketing“-Angebot für Hunderte Dollar folgt. Die <a href="https://authorsguild.org/resource/publishing-scam-alerts">Authors Guild</a> warnte im Oktober 2025 vor einer Explosion KI-verstärkter Betrugsmails. Writer Beware verfolgt dasselbe Muster noch 2026.</p>
<p>Nach einer Antwort kommt meist eine Geldforderung für „book promotion“, ein Identitäts-Phish, ein Malware-Link oder eine „Investitionsgelegenheit“. Ein Autor schrieb unter diesem Beitrag, der Bot habe seine Gefühle verletzt: fünf solcher E-Mails in zwei Tagen, alle 100&nbsp;% KI.</p>
<p>Ich habe nicht geantwortet. Auch nicht mit „danke, kein Interesse“. <a href="https://caniphish.com/blog/responding-to-a-phishing-email">CanIPhish</a> sagt es schlicht: Eine Antwort signalisiert, dass die Adresse aktiv und regelmäßig geprüft wird. Sie landet auf weiteren Listen.</p>
<p>In Gmail habe ich die Nachricht als Spam markiert und den Absender blockiert. Löschen reicht nicht — der Filter lernt von der Markierung.</p>
<p>Wenn Sie auf Amazon veröffentlichen, sehen Sie sich die Autorenbio an. Schule, Stadt, Lehrernamen sind öffentliches Futter für Bots, die daraus die Illusion einer lokalen Verbindung bauen.</p>
<p>Haben Sie eine ähnliche E-Mail bekommen? Schreiben Sie mir über das <a href="contact.php">Kontaktformular</a>. Nicht dem Absender.</p>
<p><em>Das ist ein persönlicher Bericht, keine Rechtsberatung. Melden Sie eine verdächtige Nachricht Ihrem E-Mail-Anbieter.</em></p>
HTML,
        ],
        'fr' => [
            'title' => 'Un e-mail flatteur sur mon livre. C\'est un bot qui l\'a écrit, pas un lecteur.',
            'image_alt' => 'Un bureau de nuit : un livre ouvert, un ordinateur portable et une silhouette holographique turquoise qui plie une enveloppe lumineuse.',
            'excerpt' => 'J’ai reçu un e-mail d\'un expéditeur inconnu. Il louait Elimination, citait mon lycée à Stará Ľubovňa et demandait ma formation médicale. Tout venait d’Amazon. Depuis l’été 2025, c’est une vague de hameçonnage par IA visant les auteurs. Ne répondez pas.',
            'content' => <<<'HTML'
<p>J'ai reçu un e-mail flatteur sur mon livre <em>Elimination: Get out of my body</em>. L'expéditeur s'est présenté sous un nom inventé. Il écrivait que le livre l'avait marqué parce qu'il « apporte votre longue expérience en néphrologie et en dialyse dans un guide pratique ». Il demandait comment ma formation médicale et mon travail littéraire avaient informé le livre.</p>
<p>Cela sonnait comme un lecteur. Ce n'en était pas un.</p>
<p>L'adresse était un Gmail jetable avec des chiffres aléatoires : <em>fransicmason3598@gmail.com</em>. Pas d'entreprise, pas de site, pas de signature. Le texte était trop lisse et trop général — pas un seul chapitre, phrase ou scène précis du livre. L'école et la ville — le Gymnázium Terézie Vansovej à Stará Ľubovňa — venaient de la bio publique Amazon KDP. L'éloge « personnel » copiait le <a href="https://www.amazon.com/dp/1090779291">texte de présentation Amazon</a> : le livre est un court guide sur le traitement par élimination et la dialyse, pas le souvenir de quelqu'un qui l'aurait lu.</p>
<p>L'hameçon était ouvert : répondez, je serais heureux d'en savoir plus. Le but n'est pas une conversation. Le but est de confirmer que l'adresse vit.</p>
<p>Depuis l'été 2025, c'est une vague. <a href="https://jonathanemmett.com/2025/07/authors-beware-if-you-receive-a-flattering-email-about-your-book-it-may-be-from-an-ai.html">un blogueur</a> l'a décrite en juillet 2025 sur son blog : e-mail flatteur sur un livre, Gmail, détecteur d'IA à 100&nbsp;%, demande de réponse. Les auteurs sur <a href="https://www.reddit.com/r/selfpublish/comments/1vbs1hz/author_psa_were_being_hit_by_a_tsunami_of_really">r/selfpublish</a> parlent d'un « tsunami » de tels messages. <a href="https://electricliterature.com/that-personalized-email-about-loving-and-marketing-your-book-is-a-scam/">Electric Literature</a> a montré qu'une réponse est suivie d'une offre de « marketing » à des centaines de dollars. L'<a href="https://authorsguild.org/resource/publishing-scam-alerts">Authors Guild</a> a mis en garde en octobre 2025 contre une explosion d'e-mails d'escroquerie améliorés par l'IA. Writer Beware suit encore le même schéma en 2026.</p>
<p>Après une réponse vient en général une demande d'argent pour une « book promotion », un hameçonnage d'identité, un lien malveillant, ou une « opportunité d'investissement ». Un auteur, en commentaire sous cet article, a écrit que le bot lui avait fait mal : cinq e-mails de ce type en deux jours, tous 100&nbsp;% IA.</p>
<p>Je n'ai pas répondu. Même pas « merci, cela ne m'intéresse pas ». <a href="https://caniphish.com/blog/responding-to-a-phishing-email">CanIPhish</a> le dit simplement : une réponse signale que l'adresse est active et régulièrement consultée. Elle vous place sur d'autres listes.</p>
<p>Dans Gmail, j'ai marqué le message comme spam et bloqué l'expéditeur. Effacer ne suffit pas — le filtre apprend de l'étiquette spam.</p>
<p>Si vous publiez sur Amazon, regardez votre bio d'auteur. L'école, la ville, les noms d'enseignants sont de la nourriture publique pour des bots qui en assemblent l'illusion d'un lien local.</p>
<p>Avez-vous reçu un e-mail similaire ? Écrivez-moi via le <a href="contact.php">formulaire de contact</a>. Pas à l'expéditeur.</p>
<p><em>Ceci est un récit personnel, pas un conseil juridique. Signalez un message suspect à votre fournisseur de messagerie.</em></p>
HTML,
        ],
        'es' => [
            'title' => 'Un correo halagador sobre mi libro. Lo escribió un bot, no un lector.',
            'image_alt' => 'Un escritorio nocturno: un libro abierto, un portátil y una figura holográfica turquesa que pliega un sobre luminoso.',
            'excerpt' => 'Recibí un correo de un remitente desconocido. Elogiaba Elimination, nombraba mi instituto en Stará Ľubovňa y preguntaba por mi formación médica. Todo venía de Amazon. Desde el verano de 2025 es una oleada de phishing con IA contra autores. No responda.',
            'content' => <<<'HTML'
<p>Recibí un correo halagador sobre mi libro <em>Elimination: Get out of my body</em>. El remitente se presentó con un nombre inventado. Escribía que el libro le había marcado porque «lleva su larga experiencia en nefrología y diálisis a una guía práctica». Preguntaba cómo mi formación médica y mi trabajo literario habían informado el libro.</p>
<p>Sonaba a un lector. No lo era.</p>
<p>La dirección era un Gmail de usar y tirar con números aleatorios: <em>fransicmason3598@gmail.com</em>. Ninguna empresa, ningún sitio, ninguna firma. El texto era demasiado pulido y demasiado general: ni un capítulo, una frase o una escena concretos del libro. La escuela y la ciudad — el Gymnázium Terézie Vansovej en Stará Ľubovňa — salían de la bio pública de Amazon KDP. El elogio «personal» copiaba la <a href="https://www.amazon.com/dp/1090779291">sinopsis de Amazon</a>: el libro es una guía breve sobre el tratamiento de eliminación y la diálisis, no el recuerdo de alguien que lo leyó.</p>
<p>El anzuelo estaba abierto: responda, me alegraría saber más. El objetivo no es una conversación. El objetivo es confirmar que la dirección vive.</p>
<p>Desde el verano de 2025 es una oleada. <a href="https://jonathanemmett.com/2025/07/authors-beware-if-you-receive-a-flattering-email-about-your-book-it-may-be-from-an-ai.html">un bloguero</a> la describió en julio de 2025 en su blog: correo halagador sobre un libro, Gmail, detector de IA al 100&nbsp;%, petición de respuesta. Los autores en <a href="https://www.reddit.com/r/selfpublish/comments/1vbs1hz/author_psa_were_being_hit_by_a_tsunami_of_really">r/selfpublish</a> hablan de un «tsunami» de esos mensajes. <a href="https://electricliterature.com/that-personalized-email-about-loving-and-marketing-your-book-is-a-scam/">Electric Literature</a> mostró que a una respuesta le sigue una oferta de «marketing» por cientos de dólares. La <a href="https://authorsguild.org/resource/publishing-scam-alerts">Authors Guild</a> advirtió en octubre de 2025 de una explosión de correos estafa mejorados con IA. Writer Beware sigue el mismo patrón aún en 2026.</p>
<p>Tras una respuesta suele llegar una petición de dinero por «book promotion», un phishing de identidad, un enlace de malware o una «oportunidad de inversión». Un autor, en un comentario bajo ese artículo, escribió que el bot le hirió los sentimientos: cinco correos así en dos días, todos 100&nbsp;% IA.</p>
<p>No respondí. Ni siquiera «gracias, no me interesa». <a href="https://caniphish.com/blog/responding-to-a-phishing-email">CanIPhish</a> lo explica con sencillez: una respuesta señala que la dirección está activa y se revisa con regularidad. Le mete en más listas.</p>
<p>En Gmail marqué el mensaje como spam y bloqueé al remitente. Borrar no basta: el filtro aprende de la etiqueta.</p>
<p>Si publica en Amazon, mire su bio de autor. La escuela, la ciudad, los nombres de profesores son alimento público para bots que montan la ilusión de un vínculo local.</p>
<p>¿Ha recibido un correo parecido? Escríbame a través del <a href="contact.php">formulario de contacto</a>. No al remitente.</p>
<p><em>Esto es un relato personal, no un consejo jurídico. Denuncie un mensaje sospechoso a su proveedor de correo.</em></p>
HTML,
        ],
        'pl' => [
            'title' => 'Pochlebny e-mail o mojej książce. Napisał go bot, nie czytelnik.',
            'image_alt' => 'Nocne biurko: otwarta książka, laptop i turkusowa holograficzna postać składająca świecącą kopertę.',
            'excerpt' => 'Dostałem e-mail od nieznanego nadawcy. Chwalił Elimination, wymienił moje gimnazjum w Starej Lubowli i pytał o wykształcenie medyczne. Wszystko wzięło z Amazonu. Od lata 2025 to fala AI-phishingu na autorów. Nie odpowiadajcie.',
            'content' => <<<'HTML'
<p>Dostałem pochlebny e-mail o książce <em>Elimination: Get out of my body</em>. Nadawca przedstawił się zmyślonym imieniem. Pisał, że książka utkwiła mu w pamięci, bo „wnosi wieloletnie doświadczenie nefrologiczne i dializacyjne do praktycznego przewodnika”. Pytał, jak moje wykształcenie medyczne i praca literacka ukształtowały książkę.</p>
<p>Brzmiało jak czytelnik. Nie był.</p>
<p>Adres to throwaway Gmail z losowymi cyframi: <em>fransicmason3598@gmail.com</em>. Żadnej firmy, żadnej strony, żadnego podpisu. Tekst był zbyt wygładzony i zbyt ogólny — ani jednego konkretnego rozdziału, zdania, sceny z książki. Szkołę i miasto — Gymnázium Terézie Vansovej w Starej Lubowli — wyciągnął z publicznego Amazon KDP author bio. „Osobista” pochwała kopiowała <a href="https://www.amazon.com/dp/1090779291">blurb na Amazonie</a>: książka to krótki przewodnik po leczeniu eliminacyjnym i dializie, nie wspomnienie kogoś, kto ją przeczytał.</p>
<p>Haczyk był otwarty: odpowiedzcie, chętnie dowiem się więcej. Celem nie jest rozmowa. Celem jest potwierdzić, że adres żyje.</p>
<p>Od lata 2025 to fala. <a href="https://jonathanemmett.com/2025/07/authors-beware-if-you-receive-a-flattering-email-about-your-book-it-may-be-from-an-ai.html">autor publicznego bloga</a> opisał ją w lipcu 2025 na blogu: pochlebny e-mail o książce, Gmail, detektor AI na 100&nbsp;%, prośba o odpowiedź. Autorzy na <a href="https://www.reddit.com/r/selfpublish/comments/1vbs1hz/author_psa_were_being_hit_by_a_tsunami_of_really">r/selfpublish</a> zgłaszają „tsunami” takich wiadomości. <a href="https://electricliterature.com/that-personalized-email-about-loving-and-marketing-your-book-is-a-scam/">Electric Literature</a> pokazała, że po odpowiedzi przychodzi oferta „marketingu” za setki dolarów. <a href="https://authorsguild.org/resource/publishing-scam-alerts">Authors Guild</a> w październiku 2025 ostrzegała przed eksplozją ulepszonych przez AI e-maili oszustów. Writer Beware śledzi ten sam wzorzec jeszcze w 2026.</p>
<p>Po odpowiedzi zwykle przychodzi prośba o pieniądze za „book promotion”, phishing tożsamości, link do malware albo „okazja inwestycyjna”. Jeden autor w komentarzu pod tym tekstem napisał, że bot zranił mu uczucia: pięć takich e-maili w dwa dni, wszystkie 100&nbsp;% AI.</p>
<p>Nie odpowiedziałem. Nawet nie „dziękuję, nie jestem zainteresowany”. <a href="https://caniphish.com/blog/responding-to-a-phishing-email">CanIPhish</a> tłumaczy to prosto: odpowiedź to sygnał, że adres jest aktywny i regularnie sprawdzany. Wciąga was na kolejne listy.</p>
<p>W Gmailu oznaczyłem wiadomość jako spam i zablokowałem nadawcę. Usunięcie nie wystarczy — filtr uczy się z oznaczenia.</p>
<p>Jeśli publikujecie na Amazonie, zerknijcie na author bio. Szkoła, miasto, nazwiska nauczycieli to publiczna karma dla botów, które składają z nich złudzenie lokalnego powiązania.</p>
<p>Dostaliście podobny e-mail? Napiszcie do mnie przez <a href="contact.php">kontakt</a>. Nie do nadawcy.</p>
<p><em>To osobiste doświadczenie, nie porada prawna. Podejrzaną wiadomość zgłoście dostawcy poczty.</em></p>
HTML,
        ],
        'hu' => [
            'title' => 'Hízelgő e-mail a könyvemről. Bot írta, nem olvasó.',
            'image_alt' => 'Éjszakai íróasztal: nyitott könyv, laptop és egy türkiz holografikus alak, aki világító borítékot hajtogat.',
            'excerpt' => 'E-mailt kaptam egy ismeretlen feladótól. Dicsérte az Eliminationt, megnevezte a stará ľubovňai gimnáziumomat, és az orvosi képzésemről kérdezett. Minden az Amazonról jött. 2025 nyara óta ez AI-adathalász hullám szerzők ellen. Ne válaszoljon.',
            'content' => <<<'HTML'
<p>Hízelgő e-mailt kaptam a <em>Elimination: Get out of my body</em> című könyvemről. A feladó kitalált néven mutatkozott be. Azt írta, a könyv megragadta, mert „hosszú nefrológiai és dialízises tapasztalatát gyakorlati útmutatóba viszi”. Azt kérdezte, orvosi képzésem és irodalmi munkám hogyan formálta a könyvet.</p>
<p>Olvasónak hangzott. Nem az volt.</p>
<p>A cím throwaway Gmail volt véletlen számokkal: <em>fransicmason3598@gmail.com</em>. Sem cég, sem weboldal, sem aláírás. A szöveg túl sima és túl általános volt — egyetlen konkrét fejezet, mondat, jelenet sem a könyvből. Az iskolát és a várost — a Gymnázium Terézie Vansovej-t Stará Ľubovňában — a nyilvános Amazon KDP szerzői bióból emelte. A „személyes” dicséret az <a href="https://www.amazon.com/dp/1090779291">Amazon-blurbot</a> másolta: a könyv rövid útmutató az eliminációs kezelésről és a dialízisről, nem annak az emléke, aki elolvasta.</p>
<p>A horog nyitott volt: válaszoljon, szívesen megtudnék többet. A cél nem a beszélgetés. A cél annak megerősítése, hogy a cím él.</p>
<p>2025 nyara óta ez egy hullám. <a href="https://jonathanemmett.com/2025/07/authors-beware-if-you-receive-a-flattering-email-about-your-book-it-may-be-from-an-ai.html">egy nyilvános blog szerzője</a> 2025 júliusában írta le a blogján: hízelgő e-mail egy könyvről, Gmail, AI-detektor 100&nbsp;%-on, kérés a válaszra. A szerzők a <a href="https://www.reddit.com/r/selfpublish/comments/1vbs1hz/author_psa_were_being_hit_by_a_tsunami_of_really">r/selfpublish</a>en „cunami”-ról számolnak be. Az <a href="https://electricliterature.com/that-personalized-email-about-loving-and-marketing-your-book-is-a-scam/">Electric Literature</a> megmutatta, hogy a válasz után „marketing” ajánlat jön több száz dollárért. Az <a href="https://authorsguild.org/resource/publishing-scam-alerts">Authors Guild</a> 2025 októberében AI-val felerősített csaló e-mailek robbanására figyelmeztetett. A Writer Beware ugyanezt a mintát 2026-ban is követi.</p>
<p>A válasz után általában pénzkérés jön „book promotion”-ért, személyazonosság-adathalászat, malware-link vagy „befektetési lehetőség”. Egy szerző a cikk alatt azt írta, a bot megsértette az érzéseit: két nap alatt öt ilyen e-mail, mind 100&nbsp;% AI.</p>
<p>Nem válaszoltam. Még egy „köszönöm, nem érdekel” sem. A <a href="https://caniphish.com/blog/responding-to-a-phishing-email">CanIPhish</a> egyszerűen fogalmaz: a válasz jelzi, hogy a cím aktív és rendszeresen ellenőrzött. További listákra teszi.</p>
<p>A Gmailben spammé jelöltem az üzenetet, és letiltottam a feladót. Törölni nem elég — a szűrő a jelölésből tanul.</p>
<p>Ha Amazonon publikál, nézze meg a szerzői biót. Iskola, város, tanárok nevei nyilvános táplálék botoknak, amelyek ebből helyi kapcsolat illúzióját rakják össze.</p>
<p>Kapott hasonló e-mailt? Írjon nekem a <a href="contact.php">kapcsolati űrlapon</a>. Nem a feladónak.</p>
<p><em>Személyes beszámoló, nem jogi tanács. A gyanús üzenetet jelentse az e-mail-szolgáltatójának.</em></p>
HTML,
        ],
        'it' => [
            'title' => 'Un\'e-mail lusinghiera sul mio libro. L\'ha scritta un bot, non un lettore.',
            'image_alt' => 'Una scrivania notturna: un libro aperto, un portatile e una figura olografica turchese che piega una busta luminosa.',
            'excerpt' => 'Ho ricevuto un’e-mail da un mittente sconosciuto. Lodava Elimination, citava il mio liceo a Stará Ľubovňa e chiedeva della formazione medica. Tutto veniva da Amazon. Dall’estate 2025 è un’ondata di phishing con IA sugli autori. Non rispondete.',
            'content' => <<<'HTML'
<p>Ho ricevuto un'e-mail lusinghiera sul mio libro <em>Elimination: Get out of my body</em>. Il mittente si è presentato con un nome inventato. Scriveva che il libro gli era rimasto impresso perché «porta la vostra lunga esperienza in nefrologia e dialisi in una guida pratica». Chiedeva come la mia formazione medica e il lavoro letterario avessero informato il libro.</p>
<p>Sembrava un lettore. Non lo era.</p>
<p>L'indirizzo era un Gmail usa e getta con cifre casuali: <em>fransicmason3598@gmail.com</em>. Nessuna azienda, nessun sito, nessuna firma. Il testo era troppo liscio e troppo generico — né un capitolo, una frase o una scena specifici del libro. La scuola e la città — il Gymnázium Terézie Vansovej a Stará Ľubovňa — venivano dalla bio pubblica Amazon KDP. L'elogio «personale» copiava la <a href="https://www.amazon.com/dp/1090779291">sinossi su Amazon</a>: il libro è una breve guida sul trattamento di eliminazione e sulla dialisi, non il ricordo di chi l'ha letto.</p>
<p>L'amo era aperto: rispondete, sarei lieto di saperne di più. L'obiettivo non è una conversazione. L'obiettivo è confermare che l'indirizzo vive.</p>
<p>Dall'estate 2025 è un'ondata. <a href="https://jonathanemmett.com/2025/07/authors-beware-if-you-receive-a-flattering-email-about-your-book-it-may-be-from-an-ai.html">un blogger</a> l'ha descritta a luglio 2025 sul suo blog: e-mail lusinghiera su un libro, Gmail, rilevatore di IA al 100&nbsp;%, richiesta di risposta. Gli autori su <a href="https://www.reddit.com/r/selfpublish/comments/1vbs1hz/author_psa_were_being_hit_by_a_tsunami_of_really">r/selfpublish</a> parlano di uno «tsunami» di messaggi del genere. <a href="https://electricliterature.com/that-personalized-email-about-loving-and-marketing-your-book-is-a-scam/">Electric Literature</a> ha mostrato che a una risposta segue un'offerta di «marketing» da centinaia di dollari. L'<a href="https://authorsguild.org/resource/publishing-scam-alerts">Authors Guild</a> a ottobre 2025 ha avvertito di un'esplosione di e-mail truffa potenziate dall'IA. Writer Beware segue lo stesso schema ancora nel 2026.</p>
<p>Dopo una risposta di solito arriva una richiesta di soldi per una «book promotion», un phishing sull'identità, un link malware o un'«opportunità di investimento». Un autore, in un commento sotto quell'articolo, ha scritto che il bot gli aveva ferito i sentimenti: cinque e-mail così in due giorni, tutte 100&nbsp;% IA.</p>
<p>Non ho risposto. Nemmeno «grazie, non mi interessa». <a href="https://caniphish.com/blog/responding-to-a-phishing-email">CanIPhish</a> lo spiega in modo semplice: una risposta segnala che l'indirizzo è attivo e controllato di routine. Vi mette in altre liste.</p>
<p>In Gmail ho contrassegnato il messaggio come spam e bloccato il mittente. Cancellare non basta — il filtro impara dall'etichetta.</p>
<p>Se pubblicate su Amazon, guardate la bio dell'autore. Scuola, città, nomi degli insegnanti sono cibo pubblico per bot che ne assemblano l'illusione di un legame locale.</p>
<p>Avete ricevuto un'e-mail simile? Scrivetemi tramite il <a href="contact.php">modulo di contatto</a>. Non al mittente.</p>
<p><em>Questo è un resoconto personale, non un parere legale. Segnalate un messaggio sospetto al vostro fornitore di posta.</em></p>
HTML,
        ],
        'uk' => [
            'title' => 'Лестивий лист про мою книгу. Написав його бот, не читач.',
            'image_alt' => 'Нічний письмовий стіл: розкрита книга, ноутбук і бірюзова голографічна постать, що складає світний конверт.',
            'excerpt' => 'Мені надійшов лист від невідомого відправника. Він хвалив Elimination, згадав гімназію в Старій Любовні й питав про медичну освіту. Усе це було з Amazon. Від літа 2025-го це хвиля AI-фішингу на авторів. Не відповідайте.',
            'content' => <<<'HTML'
<p>Мені надійшов лестивий лист про книгу <em>Elimination: Get out of my body</em>. Відправник представився вигаданим іменем. Писав, що книга запам'яталася, бо «приносить багаторічний нефрологічний і діалізний досвід у практичний порадник». Питав, як моя медична освіта й літературна робота сформували книгу.</p>
<p>Звучало як читач. Ним не було.</p>
<p>Адреса була одноразовим Gmail з випадковими цифрами: <em>fransicmason3598@gmail.com</em>. Жодної фірми, жодного сайту, жодного підпису. Текст був надто вилизаний і надто загальний — жодного конкретного розділу, речення, сцени з книги. Школу й місто — Gymnázium Terézie Vansovej у Старій Любовні — витягнув із публічного Amazon KDP author bio. «Особиста» хвала копіювала <a href="https://www.amazon.com/dp/1090779291">анотацію на Amazon</a>: книга — короткий порадник з елімінаційного лікування й діалізу, не спогад того, хто її читав.</p>
<p>Гачок був відкритий: дайте відповідь, буду радий дізнатися більше. Мета не розмова. Мета — підтвердити, що адреса жива.</p>
<p>Від літа 2025-го це хвиля. <a href="https://jonathanemmett.com/2025/07/authors-beware-if-you-receive-a-flattering-email-about-your-book-it-may-be-from-an-ai.html">автор публічного блогу</a> описав її в липні 2025-го у своєму блозі: лестивий лист про книгу, Gmail, детектор ШІ на 100&nbsp;%, прохання відповісти. Автори на <a href="https://www.reddit.com/r/selfpublish/comments/1vbs1hz/author_psa_were_being_hit_by_a_tsunami_of_really">r/selfpublish</a> повідомляють про «цунамі» таких листів. <a href="https://electricliterature.com/that-personalized-email-about-loving-and-marketing-your-book-is-a-scam/">Electric Literature</a> показала, що після відповіді приходить пропозиція «маркетингу» за сотні доларів. <a href="https://authorsguild.org/resource/publishing-scam-alerts">Authors Guild</a> у жовтні 2025-го попередила про вибух шахрайських листів, підсилених ШІ. Watchdog Writer Beware відстежує той самий візерунок ще в 2026-му.</p>
<p>Після відповіді зазвичай приходить прохання про гроші за «book promotion», фішинг особистості, посилання на шкідливе ПЗ або «інвестиційна нагода». Один автор у коментарі під тією статтею написав, що бот зачепив його почуття: за два дні п'ять таких листів, усі 100&nbsp;% ШІ.</p>
<p>Я не відповів. Навіть не «дякую, не цікаво». <a href="https://caniphish.com/blog/responding-to-a-phishing-email">CanIPhish</a> пояснює просто: відповідь — сигнал, що адреса активна й регулярно перевіряється. Вона ставить вас у наступні списки.</p>
<p>У Gmail я позначив повідомлення як спам і заблокував відправника. Видалити замало — фільтр вчиться з позначки.</p>
<p>Якщо публікуєте на Amazon, подивіться author bio. Школа, місто, імена вчителів — публічна пожива для ботів, які складають з них ілюзію місцевого зв'язку.</p>
<p>Отримали подібний лист? Напишіть мені через <a href="contact.php">контакт</a>. Не відправникові.</p>
<p><em>Це особистий досвід, не юридична порада. Підозріле повідомлення повідомте постачальникові пошти.</em></p>
HTML,
        ],
    ],
];
