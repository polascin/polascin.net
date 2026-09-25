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
 * Osobný blogový príspevok: cold e-mail Atlas Agents / SovereignML.
 * Overené 25. 9. 2026: atlasagents.dev (cenník, tím, demo dashboard, pätička DBA),
 * GitHub API org SovereignML (0 verejných repozitárov, 1 follower, e-mail s dvoma @,
 * vznik 2026-05-28) a účet pavankmeka (jeden fork, vznik 2025-07-13).
 * Register North Carolina Secretary of State som neoveroval.
 */
return [
    'slug' => 'atlas-agents-studeny-email-z-icloud',
    'author' => 'MUDr. Ľubomír Polaščín',
    'category' => 'blog',
    'is_top' => 0,
    'published_at' => '2026-09-25 17:05:00',
    'image' => 'images/articles/atlas-agents-studeny-email-z-icloud.webp',
    'translations' => [
        'sk' => [
            'title' => 'Atlas Agents z iCloudu. Web existuje, API kľúče mu nedám.',
            'image_alt' => 'Nočný pult pred prázdnym skleneným výkladom: laptop so žiariacim panelom, obálka, telefón a zväzok kľúčov, po ktorý ruka nesiahne.',
            'excerpt' => 'Nevyžiadaný e-mail z pavankmeka@icloud.com predáva hosting AI agentov. atlasagents.dev funguje a ceny sedia. GitHub organizácie nie. Nereagujte a nenechávajte im kľúče.',
            'content' => <<<'HTML'
<p>Prišiel mi e-mail o hostingu AI agentov. Odosielateľ <em>pavankmeka@icloud.com</em>, produkt <a href="https://atlasagents.dev">Atlas Agents</a>. Gmail ho hodil do spamu. Text bol hromadný: „Built for GitHub superusers like you.“ V poli Komu nestálo moje meno. Stálo tam <em>pavankmeka</em> — prihlasovacie meno odosielateľa.</p>
<p>Nie je to ten istý vzorec ako <a href="article.php?slug=ai-book-trailer-ponuka-je-scam">ponuka book trailera</a>. Tam nebol web. Tu web je. Napriek tomu by som im teraz nedal ani cent, a už vôbec nie API kľúče.</p>
<h2>Čo na webe sedí</h2>
<p><a href="https://atlasagents.dev">atlasagents.dev</a> je funkčný produkt: nasadenie a správa agentov nad runtime <strong>OpenClaw</strong> a <strong>Hermes</strong> (Nous Research). Hermes je u nich predvolený a má API v tvare OpenAI. OpenClaw opisujú ako ľahší engine, ktorý vojde aj do plánu s 1 GB RAM.</p>
<p>Ceny v e-maile sedia s cenníkom na stránke, ako som ho čítal 25. septembra 2026. Plán Builder je 29 dolárov mesačne, v launch cene 19. Porovnávacia tabuľka na tom istom webe uvádza Atlas od 2,50 dolára mesačne a plne spravovaný box od 9. Pätička hovorí: „© 2026 Atlas Agents, a DBA of SovereignML, L.L.C.“ Register North Carolina Secretary of State som neotváral. To, čo je v pätičke, nie je to isté ako zápis v štátnom registri.</p>
<h2>Čo na správe nesedí</h2>
<ol>
<li><strong>Osobný iCloud, nie doména.</strong> Správa neprišla z @atlasagents.dev. Kto predáva infraštruktúru agentov a píše z iCloudu, buď ešte nemá firemnú poštu, alebo ju nechce ukázať.</li>
<li><strong>Adresát je odosielateľ.</strong> <a href="https://github.com/pavankmeka">github.com/pavankmeka</a> vznikol 13. júla 2025. Má jeden verejný repozitár a ten je fork. Môj GitHub je polascin. Správa teda nebola poriadne adresovaná mne. Buď si ju poslal sám sebe, alebo sa hlavička Komu rozsypala pri hromadnom odoslaní.</li>
<li><strong>GitHub organizácie je prázdny.</strong> <a href="https://github.com/sovereignml">SovereignML</a> vznikla 28. mája 2026. Nula verejných repozitárov, jeden follower. Kontaktný e-mail v profile je <em>admin@sovereignml@gmail.com</em> — dve zavináče, adresa, na ktorú sa nedá odpovedať. Predávajú infraštruktúru agentov a vlastná identita na GitHube je rozbitá.</li>
<li><strong>Päť mien, jedna verejná stopa.</strong> <a href="https://atlasagents.dev/team">Tím</a> uvádza Pavana Meku, Subbu Reddyho Meku, Mahmudura Labiba, Mahfuza Imona a Yeasira Joya. Jediný verejný člen organizácie na GitHube je Labib. Tlačidlá X, Instagram a LinkedIn na stránke tímu vedú na <em>#</em>, nie na profily. Rovnaké priezvisko dvoch Mekov je na stránke, nie dôkaz. Je to malá firma bez recenzií, ktoré by som vedel nájsť inde.</li>
<li><strong>Text pre „superuserov“.</strong> Žiadna veta o tom, čo robím. Len oslovenie, ktoré sedí na každý verejný GitHub. To je zber adries z profilov, nie hack schránky.</li>
</ol>
<h2>Čo predávajú</h2>
<p>Sľub je „working agent on day one“: nainštalujú OpenClaw alebo Hermes na ich alebo váš server, s prehliadačom, knowledge base a vaším n8n. Kľúče k modelom si prinesiete vy. Na každom pláne. To znie prakticky, kým si neuvedomíte, čo tým dávate päťčlennej firme bez verejnej histórie: prístup k agentovi, ktorý má sedieť na vašej pošte, v Slacku alebo v CRM, plus kľúče k OpenAI či OpenRouteru.</p>
<p>Kreditný model je na ich vlastnej ukážke nepriehľadný. Demo dashboard na úvodnej stránke — nadpis „Welcome back, Admin“, nie faktúra — ukazuje spaľovanie 1 180 kreditov denne, runway 41 dní a asi 11,80 dolára na deň. Plán za 19 dolárov mesačne takýto denný odber nepokryje. Porovnanie s Agent 37, AgentSky a Jurniti je ich tabuľka. Nie nezávislý test.</p>
<h2>Čo s tým</h2>
<ul>
<li><strong>Nechajte to v spame.</strong> Neodpovedajte, ani „nie, ďakujem“. Odpoveď potvrdí, že adresa žije, a táto správa je očividne hromadná.</li>
<li><strong>Schovajte e-mail na GitHube.</strong> V Settings → Emails zapnite „Keep my email addresses private“ a „Block command line pushes that expose my email address“. Na verejný profil dajte noreply adresu, ktorú GitHub v tom istom nastavení vypíše. Má tvar <em>používateľ@users.noreply.github.com</em> alebo <em>ID+používateľ@users.noreply.github.com</em>. <a href="https://docs.github.com/en/account-and-profile/how-tos/setting-up-and-managing-your-personal-account-on-github/managing-email-preferences/setting-your-commit-email-address">GitHub to popisuje pri commit e-maile</a>. Tým skončí celá kategória správ zoškrabaných z profilu.</li>
<li><strong>Ak by vás produkt niekedy zaujímal naozaj,</strong> až potom: zápis LLC u North Carolina Secretary of State, referencie, ktorým zavoláte vy, a API kľúče len ako burner s denným stropom útraty. Nikdy so širokými oprávneniami. Dnes nie.</li>
</ul>
<p>Toto je tretia vlna na ten istý základ. Predtým <a href="article.php?slug=ai-generovany-email-o-knihe-je-scam">lichôtky o knihe</a> a book trailer. Zdroj nie je prienik do schránky. Je to verejný e-mail na GitHub profile a scraper.</p>
<p>Správu som nechal v spame. Ak vám prišla podobná, napíšte mi cez <a href="contact.php">kontakt</a>. Nie odosielateľovi.</p>
<p><em>Ide o osobnú skúsenosť, nie o právnu radu. Mená a čísla sú to, čo 25. septembra 2026 stálo na webe, na GitHube a v e-maile. Register firmy som neoveroval. Podozrivú správu nahláste poskytovateľovi pošty.</em></p>
HTML,
        ],
        'en' => [
            'title' => 'Atlas Agents wrote from iCloud. The site is real. The API keys stay here.',
            'image_alt' => 'A night counter in front of an empty glass storefront: a laptop with a glowing panel, an envelope, a phone, and a set of keys a hand does not take.',
            'excerpt' => 'An unsolicited email from pavankmeka@icloud.com sells AI-agent hosting. atlasagents.dev works and the prices match. The GitHub org does not. Do not reply, and do not hand over keys.',
            'content' => <<<'HTML'
<p>I received an email about hosting AI agents. The sender was <em>pavankmeka@icloud.com</em>, the product <a href="https://atlasagents.dev">Atlas Agents</a>. Gmail put it in spam. The copy was bulk: “Built for GitHub superusers like you.” The To field did not carry my name. It carried <em>pavankmeka</em> — the sender’s own login.</p>
<p>This is not the same pattern as the <a href="article.php?slug=ai-book-trailer-ponuka-je-scam">book-trailer offer</a>. That one had no website. This one does. I still would not give them a cent right now, and I would not give them API keys at all.</p>
<h2>What on the site holds</h2>
<p><a href="https://atlasagents.dev">atlasagents.dev</a> is a working product: deploy and manage agents on the <strong>OpenClaw</strong> and <strong>Hermes</strong> runtimes (Nous Research). Hermes is their default and exposes an OpenAI-shaped API. They describe OpenClaw as the lighter engine, the one that also fits a 1 GB RAM plan.</p>
<p>The prices in the email match the page as I read it on 25 September 2026. The Builder plan is $29 a month, $19 at the launch price. The comparison table on the same site lists Atlas from $2.50 a month, and a fully managed box from $9. The footer says: “© 2026 Atlas Agents, a DBA of SovereignML, L.L.C.” I did not open the North Carolina Secretary of State register. A line in a footer is not the same thing as a filing.</p>
<h2>What does not fit</h2>
<ol>
<li><strong>A personal iCloud address, not the domain.</strong> The message did not come from @atlasagents.dev. Someone selling agent infrastructure from iCloud either has no company mail yet, or does not want to show it.</li>
<li><strong>The recipient is the sender.</strong> <a href="https://github.com/pavankmeka">github.com/pavankmeka</a> was created on 13 July 2025. It has one public repository, and that repository is a fork. My GitHub login is polascin. The message was not properly addressed to me. Either he sent it to himself, or the To header fell apart in a bulk send.</li>
<li><strong>The GitHub org is empty.</strong> <a href="https://github.com/sovereignml">SovereignML</a> was created on 28 May 2026. Zero public repositories, one follower. The contact email on the profile is <em>admin@sovereignml@gmail.com</em> — two at-signs, an address nobody can reply to. They sell agent infrastructure, and their own identity on GitHub is broken.</li>
<li><strong>Five names, one public trace.</strong> The <a href="https://atlasagents.dev/team">team page</a> lists Pavan Meka, Subba Reddy Meka, Mahmudur Labib, Mahfuz Imon, and Yeasir Joy. The only public member of the org on GitHub is Labib. The X, Instagram, and LinkedIn buttons on the team page point at <em>#</em>, not at profiles. Two Mekas sharing a surname is what the page shows, not proof of anything else. It is a small firm, and I could not find reviews elsewhere.</li>
<li><strong>Copy for “superusers.”</strong> Not one sentence about what I do. Just a greeting that fits every public GitHub profile. That is address harvesting, not a break-in.</li>
</ol>
<h2>What they sell</h2>
<p>The promise is a working agent on day one: they install OpenClaw or Hermes on their server or yours, with a browser, a knowledge base, and your own n8n. You bring the model keys. On every plan. That sounds practical until you notice what you would be handing a five-person shop with no public track record: an agent meant to sit in your mail, Slack, or CRM, plus keys to OpenAI or OpenRouter.</p>
<p>The credit model is opaque even on their own illustration. The demo dashboard on the homepage — headed “Welcome back, Admin,” not an invoice — shows a burn of 1,180 credits a day, a 41-day runway, and about $11.80 a day. A $19-a-month plan does not cover a burn at that pace. The comparison with Agent 37, AgentSky, and Jurniti is their table. Not an independent test.</p>
<h2>What to do</h2>
<ul>
<li><strong>Leave it in spam.</strong> Do not reply, not even with “no, thank you.” A reply confirms that the address is alive, and this message is plainly bulk.</li>
<li><strong>Hide the email on GitHub.</strong> In Settings → Emails, turn on “Keep my email addresses private” and “Block command line pushes that expose my email address.” Put the noreply address GitHub shows in that same screen on your public profile. It looks like <em>username@users.noreply.github.com</em> or <em>ID+username@users.noreply.github.com</em>. <a href="https://docs.github.com/en/account-and-profile/how-tos/setting-up-and-managing-your-personal-account-on-github/managing-email-preferences/setting-your-commit-email-address">GitHub describes this next to the commit email</a>. That ends the whole category of mail scraped from the profile.</li>
<li><strong>If the product ever interests you for real,</strong> only then: an LLC filing at the North Carolina Secretary of State, references you call yourself, and API keys only as a burner with a daily spend cap. Never with wide scopes. Not today.</li>
</ul>
<p>This is the third wave on the same footing. Before it, <a href="article.php?slug=ai-generovany-email-o-knihe-je-scam">flattery about a book</a> and a book trailer. The source is not a break-in. It is a public email on a GitHub profile, and a scraper.</p>
<p>I left the message in spam. If a similar one reached you, write to me via the <a href="contact.php">contact form</a>. Not to the sender.</p>
<p><em>This is a personal account, not legal advice. The names and figures are what stood on the site, on GitHub, and in the email on 25 September 2026. I did not verify the company register. Report a suspicious message to your email provider.</em></p>
HTML,
        ],
        'cs' => [
            'title' => 'Atlas Agents z iCloudu. Web existuje, API klíče mu nedám.',
            'image_alt' => 'Noční pult před prázdnou skleněnou výlohou: laptop se zářícím panelem, obálka, telefon a svazek klíčů, po který ruka nesáhne.',
            'excerpt' => 'Nevyžádaný e-mail z pavankmeka@icloud.com prodává hosting AI agentů. atlasagents.dev funguje a ceny sedí. GitHub organizace ne. Neodpovídejte a nenechávejte jim klíče.',
            'content' => <<<'HTML'
<p>Přišel mi e-mail o hostingu AI agentů. Odesílatel <em>pavankmeka@icloud.com</em>, produkt <a href="https://atlasagents.dev">Atlas Agents</a>. Gmail ho hodil do spamu. Text byl hromadný: „Built for GitHub superusers like you.“ V poli Komu nestálo mé jméno. Stálo tam <em>pavankmeka</em> — přihlašovací jméno odesílatele.</p>
<p>Není to stejný vzorec jako <a href="article.php?slug=ai-book-trailer-ponuka-je-scam">nabídka book traileru</a>. Tam nebyl web. Tady web je. Přesto bych jim teď nedal ani cent, a už vůbec ne API klíče.</p>
<h2>Co na webu sedí</h2>
<p><a href="https://atlasagents.dev">atlasagents.dev</a> je funkční produkt: nasazení a správa agentů nad runtime <strong>OpenClaw</strong> a <strong>Hermes</strong> (Nous Research). Hermes je u nich výchozí a má API ve tvaru OpenAI. OpenClaw popisují jako lehčí engine, který se vejde i do plánu s 1 GB RAM.</p>
<p>Ceny v e-mailu sedí s ceníkem na stránce, jak jsem ho četl 25. září 2026. Plán Builder je 29 dolarů měsíčně, v launch ceně 19. Srovnávací tabulka na tomtéž webu uvádí Atlas od 2,50 dolaru měsíčně a plně spravovaný box od 9. Patička říká: „© 2026 Atlas Agents, a DBA of SovereignML, L.L.C.“ Rejstřík North Carolina Secretary of State jsem neotevíral. To, co je v patičce, není totéž co zápis ve státním rejstříku.</p>
<h2>Co na zprávě nesedí</h2>
<ol>
<li><strong>Osobní iCloud, ne doména.</strong> Zpráva nepřišla z @atlasagents.dev. Kdo prodává infrastrukturu agentů a píše z iCloudu, buď ještě nemá firemní poštu, nebo ji nechce ukázat.</li>
<li><strong>Adresát je odesílatel.</strong> <a href="https://github.com/pavankmeka">github.com/pavankmeka</a> vznikl 13. července 2025. Má jeden veřejný repozitář a ten je fork. Můj GitHub je polascin. Zpráva tedy nebyla pořádně adresovaná mně. Buď si ji poslal sám sobě, nebo se hlavička Komu rozsypala při hromadném odeslání.</li>
<li><strong>GitHub organizace je prázdná.</strong> <a href="https://github.com/sovereignml">SovereignML</a> vznikla 28. května 2026. Nula veřejných repozitářů, jeden follower. Kontaktní e-mail v profilu je <em>admin@sovereignml@gmail.com</em> — dva zavináče, adresa, na kterou se nedá odpovědět. Prodávají infrastrukturu agentů a vlastní identita na GitHubu je rozbitá.</li>
<li><strong>Pět jmen, jedna veřejná stopa.</strong> <a href="https://atlasagents.dev/team">Tým</a> uvádí Pavana Meku, Subbu Reddyho Meku, Mahmudura Labiba, Mahfuza Imona a Yeasira Joye. Jediný veřejný člen organizace na GitHubu je Labib. Tlačítka X, Instagram a LinkedIn na stránce týmu vedou na <em>#</em>, ne na profily. Stejné příjmení dvou Meků je na stránce, ne důkaz. Je to malá firma bez recenzí, které bych našel jinde.</li>
<li><strong>Text pro „superusery“.</strong> Žádná věta o tom, co dělám. Jen oslovení, které sedí na každý veřejný GitHub. To je sběr adres z profilů, ne průnik do schránky.</li>
</ol>
<h2>Co prodávají</h2>
<p>Slib je „working agent on day one“: nainstalují OpenClaw nebo Hermes na jejich nebo váš server, s prohlížečem, knowledge base a vaším n8n. Klíče k modelům si přinesete vy. Na každém plánu. To zní prakticky, dokud si neuvědomíte, co tím dáváte pětičlenné firmě bez veřejné historie: přístup k agentovi, který má sedět na vaší poště, ve Slacku nebo v CRM, plus klíče k OpenAI či OpenRouteru.</p>
<p>Kreditní model je na jejich vlastní ukázce neprůhledný. Demo dashboard na úvodní stránce — nadpis „Welcome back, Admin“, ne faktura — ukazuje pálení 1 180 kreditů denně, runway 41 dní a asi 11,80 dolaru na den. Plán za 19 dolarů měsíčně takový denní odběr nepokryje. Srovnání s Agent 37, AgentSky a Jurniti je jejich tabulka. Ne nezávislý test.</p>
<h2>Co s tím</h2>
<ul>
<li><strong>Nechte to ve spamu.</strong> Neodpovídejte, ani „ne, děkuji“. Odpověď potvrdí, že adresa žije, a tato zpráva je očividně hromadná.</li>
<li><strong>Schovejte e-mail na GitHubu.</strong> V Settings → Emails zapněte „Keep my email addresses private“ a „Block command line pushes that expose my email address“. Na veřejný profil dejte noreply adresu, kterou GitHub v tomtéž nastavení vypíše. Má tvar <em>uživatel@users.noreply.github.com</em> nebo <em>ID+uživatel@users.noreply.github.com</em>. <a href="https://docs.github.com/en/account-and-profile/how-tos/setting-up-and-managing-your-personal-account-on-github/managing-email-preferences/setting-your-commit-email-address">GitHub to popisuje u commit e-mailu</a>. Tím skončí celá kategorie zpráv seškrábaných z profilu.</li>
<li><strong>Kdyby vás produkt někdy zajímal doopravdy,</strong> až potom: zápis LLC u North Carolina Secretary of State, reference, kterým zavoláte sami, a API klíče jen jako burner s denním stropem útraty. Nikdy s širokými oprávněními. Dnes ne.</li>
</ul>
<p>Tohle je třetí vlna na stejném základě. Předtím <a href="article.php?slug=ai-generovany-email-o-knihe-je-scam">lichotky o knize</a> a book trailer. Zdroj není průnik do schránky. Je to veřejný e-mail na GitHub profilu a scraper.</p>
<p>Zprávu jsem nechal ve spamu. Pokud vám přišla podobná, napište mi přes <a href="contact.php">kontakt</a>. Ne odesílateli.</p>
<p><em>Jde o osobní zkušenost, ne o právní radu. Jména a čísla jsou to, co 25. září 2026 stálo na webu, na GitHubu a v e-mailu. Rejstřík firmy jsem neověřoval. Podezřelou zprávu nahlaste poskytovateli pošty.</em></p>
HTML,
        ],
        'de' => [
            'title' => 'Atlas Agents schrieb von iCloud. Die Seite ist echt. Die API-Schlüssel bleiben hier.',
            'image_alt' => 'Ein Nachttresen vor einem leeren Glasschaufenster: ein Laptop mit leuchtender Fläche, ein Umschlag, ein Telefon und ein Schlüsselbund, den eine Hand nicht nimmt.',
            'excerpt' => 'Eine unerbetene E-Mail von pavankmeka@icloud.com verkauft Hosting für KI-Agenten. atlasagents.dev funktioniert und die Preise stimmen. Die GitHub-Organisation nicht. Antworten Sie nicht und geben Sie keine Schlüssel heraus.',
            'content' => <<<'HTML'
<p>Ich erhielt eine E-Mail über Hosting für KI-Agenten. Absender <em>pavankmeka@icloud.com</em>, Produkt <a href="https://atlasagents.dev">Atlas Agents</a>. Gmail legte sie in den Spam. Der Text war Massenpost: „Built for GitHub superusers like you.“ Im Feld An stand nicht mein Name. Dort stand <em>pavankmeka</em> — der Login des Absenders.</p>
<p>Das ist nicht dasselbe Muster wie das <a href="article.php?slug=ai-book-trailer-ponuka-je-scam">Book-Trailer-Angebot</a>. Dort gab es keine Website. Hier gibt es eine. Trotzdem würde ich ihnen jetzt keinen Cent geben, und API-Schlüssel schon gar nicht.</p>
<h2>Was auf der Seite stimmt</h2>
<p><a href="https://atlasagents.dev">atlasagents.dev</a> ist ein funktionierendes Produkt: Agenten auf den Runtimes <strong>OpenClaw</strong> und <strong>Hermes</strong> (Nous Research) bereitstellen und verwalten. Hermes ist bei ihnen der Standard und bietet eine API in OpenAI-Form. OpenClaw beschreiben sie als die leichtere Engine, die auch in einen Plan mit 1 GB RAM passt.</p>
<p>Die Preise in der E-Mail stimmen mit der Seite überein, wie ich sie am 25. September 2026 gelesen habe. Der Plan Builder kostet 29 Dollar im Monat, zum Launch-Preis 19. Die Vergleichstabelle auf derselben Seite nennt Atlas ab 2,50 Dollar im Monat und eine voll verwaltete Box ab 9. Die Fußzeile sagt: „© 2026 Atlas Agents, a DBA of SovereignML, L.L.C.“ Das Register des North Carolina Secretary of State habe ich nicht geöffnet. Eine Zeile in der Fußzeile ist nicht dasselbe wie eine Eintragung.</p>
<h2>Was an der Nachricht nicht stimmt</h2>
<ol>
<li><strong>Persönliches iCloud, nicht die Domain.</strong> Die Nachricht kam nicht von @atlasagents.dev. Wer Agenten-Infrastruktur verkauft und von iCloud schreibt, hat entweder noch keine Firmenpost, oder will sie nicht zeigen.</li>
<li><strong>Der Empfänger ist der Absender.</strong> <a href="https://github.com/pavankmeka">github.com/pavankmeka</a> entstand am 13. Juli 2025. Ein öffentliches Repository, und das ist ein Fork. Mein GitHub-Login ist polascin. Die Nachricht war also nicht ordentlich an mich adressiert. Entweder hat er sie an sich selbst geschickt, oder die An-Zeile ist beim Massenversand auseinandergefallen.</li>
<li><strong>Die GitHub-Organisation ist leer.</strong> <a href="https://github.com/sovereignml">SovereignML</a> entstand am 28. Mai 2026. Null öffentliche Repositories, ein Follower. Die Kontakt-E-Mail im Profil ist <em>admin@sovereignml@gmail.com</em> — zwei At-Zeichen, eine Adresse, an die niemand antworten kann. Sie verkaufen Agenten-Infrastruktur, und die eigene Identität auf GitHub ist kaputt.</li>
<li><strong>Fünf Namen, eine öffentliche Spur.</strong> Die <a href="https://atlasagents.dev/team">Teamseite</a> nennt Pavan Meka, Subba Reddy Meka, Mahmudur Labib, Mahfuz Imon und Yeasir Joy. Das einzige öffentliche Mitglied der Organisation auf GitHub ist Labib. Die Schaltflächen für X, Instagram und LinkedIn auf der Teamseite zeigen auf <em>#</em>, nicht auf Profile. Zwei Mekas mit demselben Nachnamen stehen so auf der Seite, das ist kein weiterer Beweis. Eine kleine Firma, und Bewertungen habe ich anderswo nicht gefunden.</li>
<li><strong>Text für „Superuser“.</strong> Kein Satz darüber, was ich tue. Nur eine Anrede, die auf jedes öffentliche GitHub-Profil passt. Das ist Adressenernte, kein Einbruch ins Postfach.</li>
</ol>
<h2>Was sie verkaufen</h2>
<p>Das Versprechen ist ein laufender Agent am ersten Tag: Sie installieren OpenClaw oder Hermes auf ihrem oder Ihrem Server, mit Browser, Knowledge Base und Ihrem eigenen n8n. Die Modellschlüssel bringen Sie mit. In jedem Plan. Das klingt praktisch, bis klar wird, was Sie damit einem Fünf-Personen-Laden ohne öffentliche Geschichte geben: einen Agenten, der in Ihrer Post, in Slack oder im CRM sitzen soll, plus Schlüssel zu OpenAI oder OpenRouter.</p>
<p>Das Kreditmodell ist schon auf ihrer eigenen Darstellung undurchsichtig. Das Demo-Dashboard auf der Startseite — Überschrift „Welcome back, Admin“, keine Rechnung — zeigt einen Verbrauch von 1 180 Credits am Tag, 41 Tage Runway und etwa 11,80 Dollar am Tag. Ein Plan für 19 Dollar im Monat deckt dieses Tempo nicht. Der Vergleich mit Agent 37, AgentSky und Jurniti ist ihre Tabelle. Kein unabhängiger Test.</p>
<h2>Was tun</h2>
<ul>
<li><strong>Lassen Sie es im Spam.</strong> Antworten Sie nicht, auch nicht mit „nein, danke“. Eine Antwort bestätigt, dass die Adresse lebt, und diese Nachricht ist offensichtlich Massenpost.</li>
<li><strong>Verstecken Sie die E-Mail auf GitHub.</strong> Unter Settings → Emails schalten Sie „Keep my email addresses private“ und „Block command line pushes that expose my email address“ ein. Ins öffentliche Profil gehört die Noreply-Adresse, die GitHub auf demselben Bildschirm anzeigt. Sie hat die Form <em>nutzer@users.noreply.github.com</em> oder <em>ID+nutzer@users.noreply.github.com</em>. <a href="https://docs.github.com/en/account-and-profile/how-tos/setting-up-and-managing-your-personal-account-on-github/managing-email-preferences/setting-your-commit-email-address">GitHub beschreibt das neben der Commit-E-Mail</a>. Damit endet die ganze Kategorie von Post, die vom Profil abgekratzt wurde.</li>
<li><strong>Wenn das Produkt Sie einmal wirklich interessiert,</strong> erst dann: eine LLC-Eintragung beim North Carolina Secretary of State, Referenzen, die Sie selbst anrufen, und API-Schlüssel nur als Burner mit täglicher Ausgabengrenze. Niemals mit weiten Rechten. Heute nicht.</li>
</ul>
<p>Das ist die dritte Welle auf derselben Grundlage. Davor <a href="article.php?slug=ai-generovany-email-o-knihe-je-scam">Schmeichelei über ein Buch</a> und ein Book Trailer. Die Quelle ist kein Einbruch. Es ist eine öffentliche E-Mail im GitHub-Profil und ein Scraper.</p>
<p>Die Nachricht habe ich im Spam gelassen. Wenn eine ähnliche bei Ihnen ankam, schreiben Sie mir über das <a href="contact.php">Kontaktformular</a>. Nicht dem Absender.</p>
<p><em>Das ist ein persönlicher Bericht, keine Rechtsberatung. Namen und Zahlen sind das, was am 25. September 2026 auf der Seite, auf GitHub und in der E-Mail stand. Das Firmenregister habe ich nicht geprüft. Melden Sie eine verdächtige Nachricht Ihrem E-Mail-Anbieter.</em></p>
HTML,
        ],
        'fr' => [
            'title' => 'Atlas Agents a écrit depuis iCloud. Le site est réel. Les clés API restent ici.',
            'image_alt' => 'Un comptoir de nuit devant une vitrine vide : un ordinateur avec un panneau lumineux, une enveloppe, un téléphone et un trousseau de clés qu’une main ne prend pas.',
            'excerpt' => 'Un e-mail non sollicité de pavankmeka@icloud.com vend de l’hébergement d’agents IA. atlasagents.dev fonctionne et les prix correspondent. L’organisation GitHub, non. Ne répondez pas et ne confiez pas vos clés.',
            'content' => <<<'HTML'
<p>J’ai reçu un e-mail sur l’hébergement d’agents IA. Expéditeur <em>pavankmeka@icloud.com</em>, produit <a href="https://atlasagents.dev">Atlas Agents</a>. Gmail l’a mis dans les spams. Le texte était de masse : « Built for GitHub superusers like you. » Le champ À ne portait pas mon nom. Il portait <em>pavankmeka</em> — l’identifiant de l’expéditeur.</p>
<p>Ce n’est pas le même schéma que <a href="article.php?slug=ai-book-trailer-ponuka-je-scam">l’offre de book trailer</a>. Là, il n’y avait pas de site. Ici, le site existe. Je ne leur donnerais quand même pas un centime maintenant, et encore moins des clés API.</p>
<h2>Ce qui tient sur le site</h2>
<p><a href="https://atlasagents.dev">atlasagents.dev</a> est un produit qui fonctionne : déployer et gérer des agents sur les runtimes <strong>OpenClaw</strong> et <strong>Hermes</strong> (Nous Research). Hermes est leur choix par défaut et expose une API au format OpenAI. Ils décrivent OpenClaw comme le moteur plus léger, celui qui tient aussi dans un plan à 1 Go de RAM.</p>
<p>Les prix de l’e-mail correspondent à la page telle que je l’ai lue le 25 septembre 2026. Le plan Builder est à 29 dollars par mois, 19 au prix de lancement. Le tableau comparatif du même site indique Atlas à partir de 2,50 dollars par mois, et une machine entièrement gérée à partir de 9. Le pied de page dit : « © 2026 Atlas Agents, a DBA of SovereignML, L.L.C. » Je n’ai pas ouvert le registre du North Carolina Secretary of State. Une ligne de pied de page n’est pas un dépôt officiel.</p>
<h2>Ce qui ne tient pas</h2>
<ol>
<li><strong>Un iCloud personnel, pas le domaine.</strong> Le message ne venait pas de @atlasagents.dev. Quelqu’un qui vend de l’infrastructure d’agents et écrit depuis iCloud n’a pas encore de messagerie d’entreprise, ou ne veut pas la montrer.</li>
<li><strong>Le destinataire est l’expéditeur.</strong> <a href="https://github.com/pavankmeka">github.com/pavankmeka</a> a été créé le 13 juillet 2025. Un seul dépôt public, et c’est un fork. Mon identifiant GitHub est polascin. Le message ne m’était donc pas vraiment adressé. Soit il se l’est envoyé à lui-même, soit l’en-tête À s’est défait dans un envoi de masse.</li>
<li><strong>L’organisation GitHub est vide.</strong> <a href="https://github.com/sovereignml">SovereignML</a> a été créée le 28 mai 2026. Zéro dépôt public, un abonné. L’e-mail de contact du profil est <em>admin@sovereignml@gmail.com</em> — deux arobases, une adresse à laquelle personne ne peut répondre. Ils vendent de l’infrastructure d’agents, et leur propre identité sur GitHub est cassée.</li>
<li><strong>Cinq noms, une trace publique.</strong> La <a href="https://atlasagents.dev/team">page équipe</a> cite Pavan Meka, Subba Reddy Meka, Mahmudur Labib, Mahfuz Imon et Yeasir Joy. Le seul membre public de l’organisation sur GitHub est Labib. Les boutons X, Instagram et LinkedIn de la page équipe pointent vers <em>#</em>, pas vers des profils. Deux Meka du même nom de famille, c’est ce que la page affiche, pas une preuve de plus. Une petite société, et je n’ai pas trouvé d’avis ailleurs.</li>
<li><strong>Un texte pour « superusers ».</strong> Pas une phrase sur ce que je fais. Juste une formule qui va à tout profil GitHub public. C’est une collecte d’adresses, pas une intrusion dans la boîte mail.</li>
</ol>
<h2>Ce qu’ils vendent</h2>
<p>La promesse est un agent qui tourne dès le premier jour : ils installent OpenClaw ou Hermes sur leur serveur ou le vôtre, avec un navigateur, une base de connaissances et votre propre n8n. Vous apportez les clés des modèles. Sur chaque offre. Cela semble pratique, jusqu’au moment où l’on voit ce que l’on remet à une équipe de cinq personnes sans historique public : un agent censé siéger dans votre courrier, Slack ou CRM, plus des clés OpenAI ou OpenRouter.</p>
<p>Le modèle de crédits est opaque jusque dans leur propre illustration. Le tableau de bord de démo sur la page d’accueil — titre « Welcome back, Admin », pas une facture — affiche une consommation de 1 180 crédits par jour, une autonomie de 41 jours et environ 11,80 dollars par jour. Une offre à 19 dollars par mois ne couvre pas ce rythme. La comparaison avec Agent 37, AgentSky et Jurniti est leur tableau. Pas un test indépendant.</p>
<h2>Quoi faire</h2>
<ul>
<li><strong>Laissez-le dans les spams.</strong> Ne répondez pas, même pas « non, merci ». Une réponse confirme que l’adresse est vivante, et ce message est clairement de masse.</li>
<li><strong>Cachez l’e-mail sur GitHub.</strong> Dans Settings → Emails, activez « Keep my email addresses private » et « Block command line pushes that expose my email address ». Mettez sur le profil public l’adresse noreply que GitHub affiche sur le même écran. Elle a la forme <em>utilisateur@users.noreply.github.com</em> ou <em>ID+utilisateur@users.noreply.github.com</em>. <a href="https://docs.github.com/en/account-and-profile/how-tos/setting-up-and-managing-your-personal-account-on-github/managing-email-preferences/setting-your-commit-email-address">GitHub le décrit à côté de l’e-mail de commit</a>. Cela coupe toute la catégorie de messages grattés depuis le profil.</li>
<li><strong>Si le produit vous intéresse vraiment un jour,</strong> seulement alors : un dépôt de LLC auprès du North Carolina Secretary of State, des références que vous appelez vous-même, et des clés API seulement en burner avec un plafond de dépense quotidien. Jamais avec des droits larges. Pas aujourd’hui.</li>
</ul>
<p>C’est la troisième vague sur la même base. Avant, <a href="article.php?slug=ai-generovany-email-o-knihe-je-scam">des flatteries sur un livre</a> et un book trailer. La source n’est pas une intrusion. C’est un e-mail public sur un profil GitHub, et un scraper.</p>
<p>J’ai laissé le message dans les spams. Si un message semblable vous est arrivé, écrivez-moi via le <a href="contact.php">formulaire de contact</a>. Pas à l’expéditeur.</p>
<p><em>Il s’agit d’un récit personnel, pas d’un conseil juridique. Les noms et les chiffres sont ce qui figurait sur le site, sur GitHub et dans l’e-mail le 25 septembre 2026. Je n’ai pas vérifié le registre de la société. Signalez un message suspect à votre fournisseur de messagerie.</em></p>
HTML,
        ],
        'es' => [
            'title' => 'Atlas Agents escribió desde iCloud. El sitio es real. Las claves API se quedan aquí.',
            'image_alt' => 'Un mostrador de noche frente a un escaparate vacío: un portátil con un panel luminoso, un sobre, un teléfono y un llavero que una mano no toma.',
            'excerpt' => 'Un correo no solicitado de pavankmeka@icloud.com vende alojamiento de agentes de IA. atlasagents.dev funciona y los precios coinciden. La organización de GitHub, no. No responda y no entregue las claves.',
            'content' => <<<'HTML'
<p>Me llegó un correo sobre alojamiento de agentes de IA. Remitente <em>pavankmeka@icloud.com</em>, producto <a href="https://atlasagents.dev">Atlas Agents</a>. Gmail lo mandó a spam. El texto era masivo: «Built for GitHub superusers like you.» El campo Para no llevaba mi nombre. Llevaba <em>pavankmeka</em>, el usuario del remitente.</p>
<p>No es el mismo patrón que la <a href="article.php?slug=ai-book-trailer-ponuka-je-scam">oferta de book trailer</a>. Allí no había web. Aquí la hay. Aun así no les daría ahora ni un céntimo, y mucho menos claves API.</p>
<h2>Lo que sí cuadra en la web</h2>
<p><a href="https://atlasagents.dev">atlasagents.dev</a> es un producto que funciona: desplegar y gestionar agentes sobre los runtimes <strong>OpenClaw</strong> y <strong>Hermes</strong> (Nous Research). Hermes es su opción por defecto y expone una API con forma de OpenAI. Describen OpenClaw como el motor más ligero, el que también cabe en un plan de 1 GB de RAM.</p>
<p>Los precios del correo coinciden con la página tal como la leí el 25 de septiembre de 2026. El plan Builder cuesta 29 dólares al mes, 19 en el precio de lanzamiento. La tabla comparativa del mismo sitio pone Atlas desde 2,50 dólares al mes y una máquina totalmente gestionada desde 9. El pie dice: «© 2026 Atlas Agents, a DBA of SovereignML, L.L.C.» No abrí el registro del North Carolina Secretary of State. Una línea en el pie no es un asiento registral.</p>
<h2>Lo que no cuadra</h2>
<ol>
<li><strong>Un iCloud personal, no el dominio.</strong> El mensaje no vino de @atlasagents.dev. Quien vende infraestructura de agentes y escribe desde iCloud o aún no tiene correo de empresa, o no quiere enseñarlo.</li>
<li><strong>El destinatario es el remitente.</strong> <a href="https://github.com/pavankmeka">github.com/pavankmeka</a> se creó el 13 de julio de 2025. Tiene un repositorio público y es un fork. Mi usuario de GitHub es polascin. El mensaje no iba bien dirigido a mí. O se lo envió a sí mismo, o la cabecera Para se deshizo en un envío masivo.</li>
<li><strong>La organización de GitHub está vacía.</strong> <a href="https://github.com/sovereignml">SovereignML</a> se creó el 28 de mayo de 2026. Cero repositorios públicos, un seguidor. El correo de contacto del perfil es <em>admin@sovereignml@gmail.com</em>: dos arrobas, una dirección a la que nadie puede responder. Venden infraestructura de agentes y su propia identidad en GitHub está rota.</li>
<li><strong>Cinco nombres, un rastro público.</strong> La <a href="https://atlasagents.dev/team">página del equipo</a> lista a Pavan Meka, Subba Reddy Meka, Mahmudur Labib, Mahfuz Imon y Yeasir Joy. El único miembro público de la organización en GitHub es Labib. Los botones de X, Instagram y LinkedIn en la página del equipo apuntan a <em>#</em>, no a perfiles. Dos Meka con el mismo apellido es lo que muestra la página, no una prueba más. Es una empresa pequeña y no encontré reseñas en otro sitio.</li>
<li><strong>Texto para «superusers».</strong> Ni una frase sobre lo que hago. Solo un saludo que vale para cualquier perfil público de GitHub. Eso es recolección de direcciones, no un acceso a la bandeja.</li>
</ol>
<h2>Qué venden</h2>
<p>La promesa es un agente en marcha el primer día: instalan OpenClaw o Hermes en su servidor o en el suyo, con navegador, base de conocimiento y su propio n8n. Usted aporta las claves de los modelos. En todos los planes. Suena práctico hasta que se ve lo que se entrega a un equipo de cinco personas sin historial público: un agente que debería sentarse en su correo, en Slack o en el CRM, más claves de OpenAI u OpenRouter.</p>
<p>El modelo de créditos es opaco incluso en su propia ilustración. El panel de demostración de la portada — título «Welcome back, Admin», no una factura — muestra un consumo de 1 180 créditos al día, una autonomía de 41 días y unos 11,80 dólares al día. Un plan de 19 dólares al mes no cubre ese ritmo. La comparación con Agent 37, AgentSky y Jurniti es su tabla. No una prueba independiente.</p>
<h2>Qué hacer</h2>
<ul>
<li><strong>Déjelo en spam.</strong> No responda, ni siquiera con «no, gracias». Una respuesta confirma que la dirección está viva, y este mensaje es claramente masivo.</li>
<li><strong>Oculte el correo en GitHub.</strong> En Settings → Emails active «Keep my email addresses private» y «Block command line pushes that expose my email address». Ponga en el perfil público la dirección noreply que GitHub muestra en esa misma pantalla. Tiene la forma <em>usuario@users.noreply.github.com</em> o <em>ID+usuario@users.noreply.github.com</em>. <a href="https://docs.github.com/en/account-and-profile/how-tos/setting-up-and-managing-your-personal-account-on-github/managing-email-preferences/setting-your-commit-email-address">GitHub lo describe junto al correo de commit</a>. Con eso se corta toda la categoría de mensajes raspados del perfil.</li>
<li><strong>Si el producto le interesa de verdad algún día,</strong> solo entonces: un asiento de LLC en el North Carolina Secretary of State, referencias a las que llame usted, y claves API solo como burner con un tope de gasto diario. Nunca con permisos amplios. Hoy no.</li>
</ul>
<p>Esta es la tercera oleada sobre la misma base. Antes, <a href="article.php?slug=ai-generovany-email-o-knihe-je-scam">halagos sobre un libro</a> y un book trailer. La fuente no es una intrusión. Es un correo público en un perfil de GitHub y un scraper.</p>
<p>Dejé el mensaje en spam. Si le llegó uno parecido, escríbame por el <a href="contact.php">formulario de contacto</a>. No al remitente.</p>
<p><em>Es un relato personal, no asesoramiento jurídico. Los nombres y las cifras son lo que figuraba en la web, en GitHub y en el correo el 25 de septiembre de 2026. No verifiqué el registro de la empresa. Denuncie un mensaje sospechoso a su proveedor de correo.</em></p>
HTML,
        ],
        'pl' => [
            'title' => 'Atlas Agents napisał z iCloud. Strona jest prawdziwa. Klucze API zostają u mnie.',
            'image_alt' => 'Nocny blat przed pustą szklaną witryną: laptop ze świecącym panelem, koperta, telefon i pęk kluczy, po który ręka nie sięga.',
            'excerpt' => 'Nieproszony e-mail z pavankmeka@icloud.com sprzedaje hosting agentów AI. atlasagents.dev działa i ceny się zgadzają. Organizacja na GitHubie nie. Nie odpowiadajcie i nie oddawajcie kluczy.',
            'content' => <<<'HTML'
<p>Dostałem e-mail o hostingu agentów AI. Nadawca <em>pavankmeka@icloud.com</em>, produkt <a href="https://atlasagents.dev">Atlas Agents</a>. Gmail wrzucił go do spamu. Tekst był masowy: „Built for GitHub superusers like you.” W polu Do nie było mojego nazwiska. Było <em>pavankmeka</em> — login nadawcy.</p>
<p>To nie ten sam wzorzec co <a href="article.php?slug=ai-book-trailer-ponuka-je-scam">oferta book trailera</a>. Tam nie było strony. Tu strona jest. Mimo to nie dałbym im teraz ani centa, a już na pewno nie kluczy API.</p>
<h2>Co na stronie się zgadza</h2>
<p><a href="https://atlasagents.dev">atlasagents.dev</a> to działający produkt: wdrażanie i zarządzanie agentami na runtime’ach <strong>OpenClaw</strong> i <strong>Hermes</strong> (Nous Research). Hermes jest u nich domyślny i ma API w kształcie OpenAI. OpenClaw opisują jako lżejszy silnik, który mieści się też w planie z 1 GB RAM.</p>
<p>Ceny w e-mailu zgadzają się ze stroną, jak ją czytałem 25 września 2026. Plan Builder to 29 dolarów miesięcznie, w cenie startowej 19. Tabela porównawcza na tej samej stronie podaje Atlas od 2,50 dolara miesięcznie i w pełni zarządzaną maszynę od 9. Stopka mówi: „© 2026 Atlas Agents, a DBA of SovereignML, L.L.C.” Rejestru North Carolina Secretary of State nie otwierałem. Linia w stopce to nie to samo co wpis w rejestrze.</p>
<h2>Co w wiadomości nie pasuje</h2>
<ol>
<li><strong>Prywatny iCloud, nie domena.</strong> Wiadomość nie przyszła z @atlasagents.dev. Kto sprzedaje infrastrukturę agentów i pisze z iCloud, albo nie ma jeszcze firmowej poczty, albo nie chce jej pokazać.</li>
<li><strong>Adresat jest nadawcą.</strong> <a href="https://github.com/pavankmeka">github.com/pavankmeka</a> powstał 13 lipca 2025. Ma jedno publiczne repozytorium i jest to fork. Mój login na GitHubie to polascin. Wiadomość nie była więc porządnie zaadresowana do mnie. Albo wysłał ją sam do siebie, albo nagłówek Do rozpadł się przy wysyłce masowej.</li>
<li><strong>Organizacja na GitHubie jest pusta.</strong> <a href="https://github.com/sovereignml">SovereignML</a> powstała 28 maja 2026. Zero publicznych repozytoriów, jeden obserwujący. E-mail kontaktowy w profilu to <em>admin@sovereignml@gmail.com</em> — dwa małpy, adres, na który nie da się odpowiedzieć. Sprzedają infrastrukturę agentów, a własna tożsamość na GitHubie jest zepsuta.</li>
<li><strong>Pięć nazwisk, jeden publiczny ślad.</strong> <a href="https://atlasagents.dev/team">Strona zespołu</a> wymienia Pavana Mekę, Subbę Reddy’ego Mekę, Mahmudura Labiba, Mahfuza Imona i Yeasira Joya. Jedyny publiczny członek organizacji na GitHubie to Labib. Przyciski X, Instagram i LinkedIn na stronie zespołu prowadzą do <em>#</em>, nie do profili. Dwóch Meków o tym samym nazwisku to to, co widać na stronie, nie dodatkowy dowód. Mała firma i nie znalazłem recenzji gdzie indziej.</li>
<li><strong>Tekst dla „superuserów”.</strong> Ani jednego zdania o tym, co robię. Tylko zwrot, który pasuje do każdego publicznego profilu na GitHubie. To zbieranie adresów, nie włamanie do skrzynki.</li>
</ol>
<h2>Co sprzedają</h2>
<p>Obietnica to działający agent pierwszego dnia: instalują OpenClaw albo Hermes na swoim lub waszym serwerze, z przeglądarką, bazą wiedzy i waszym n8n. Klucze do modeli przynosicie wy. W każdym planie. Brzmi praktycznie, dopóki nie widać, co oddajecie pięcioosobowej firmie bez publicznej historii: agenta, który ma siedzieć w poczcie, na Slacku albo w CRM, plus klucze do OpenAI lub OpenRoutera.</p>
<p>Model kredytów jest nieprzejrzysty już na ich własnej ilustracji. Demo pulpitu na stronie głównej — nagłówek „Welcome back, Admin”, nie faktura — pokazuje spalanie 1 180 kredytów dziennie, runway 41 dni i około 11,80 dolara dziennie. Plan za 19 dolarów miesięcznie takiego tempa nie pokryje. Porównanie z Agent 37, AgentSky i Jurniti to ich tabela. Nie niezależny test.</p>
<h2>Co z tym zrobić</h2>
<ul>
<li><strong>Zostawcie to w spamie.</strong> Nie odpowiadajcie, nawet „nie, dziękuję”. Odpowiedź potwierdza, że adres żyje, a ta wiadomość jest wyraźnie masowa.</li>
<li><strong>Schowajcie e-mail na GitHubie.</strong> W Settings → Emails włączcie „Keep my email addresses private” i „Block command line pushes that expose my email address”. Na publiczny profil włóżcie adres noreply, który GitHub pokazuje na tym samym ekranie. Ma postać <em>użytkownik@users.noreply.github.com</em> albo <em>ID+użytkownik@users.noreply.github.com</em>. <a href="https://docs.github.com/en/account-and-profile/how-tos/setting-up-and-managing-your-personal-account-on-github/managing-email-preferences/setting-your-commit-email-address">GitHub opisuje to przy e-mailu commita</a>. Tym kończy się cała kategoria wiadomości zdrapanych z profilu.</li>
<li><strong>Jeśli produkt kiedyś naprawdę was zainteresuje,</strong> dopiero wtedy: wpis LLC u North Carolina Secretary of State, referencje, do których zadzwonicie sami, i klucze API tylko jako burner z dziennym limitem wydatków. Nigdy z szerokimi uprawnieniami. Dziś nie.</li>
</ul>
<p>To trzecia fala na tym samym podłożu. Wcześniej <a href="article.php?slug=ai-generovany-email-o-knihe-je-scam">komplementy o książce</a> i book trailer. Źródłem nie jest włamanie. To publiczny e-mail na profilu GitHub i scraper.</p>
<p>Wiadomość zostawiłem w spamie. Jeśli podobna przyszła do was, napiszcie przez <a href="contact.php">kontakt</a>. Nie do nadawcy.</p>
<p><em>To osobiste doświadczenie, nie porada prawna. Nazwiska i liczby są tym, co 25 września 2026 stało na stronie, na GitHubie i w e-mailu. Rejestru firmy nie sprawdzałem. Podejrzaną wiadomość zgłoście dostawcy poczty.</em></p>
HTML,
        ],
        'hu' => [
            'title' => 'Az Atlas Agents iCloudról írt. Az oldal valódi. Az API-kulcsok itt maradnak.',
            'image_alt' => 'Éjszakai pult egy üres üvegkirakat előtt: laptop fénylő panellel, boríték, telefon és egy kulcscsomó, amelyhez a kéz nem nyúl.',
            'excerpt' => 'Egy kéretlen levél a pavankmeka@icloud.com címről MI-ügynökök hosztolását árulja. Az atlasagents.dev működik, az árak stimmelnek. A GitHub-szervezet nem. Ne válaszoljon, és ne adja oda a kulcsokat.',
            'content' => <<<'HTML'
<p>Levelet kaptam MI-ügynökök hosztolásáról. A feladó <em>pavankmeka@icloud.com</em>, a termék az <a href="https://atlasagents.dev">Atlas Agents</a>. A Gmail spambe tette. A szöveg tömeges volt: „Built for GitHub superusers like you.” A Címzett mezőben nem az én nevem állt. A <em>pavankmeka</em> állt ott — a feladó saját belépőneve.</p>
<p>Ez nem ugyanaz a minta, mint a <a href="article.php?slug=ai-book-trailer-ponuka-je-scam">book trailer ajánlat</a>. Ott nem volt weboldal. Itt van. Most sem adnék nekik egy centet sem, API-kulcsot pedig végképp nem.</p>
<h2>Ami az oldalon stimmel</h2>
<p>Az <a href="https://atlasagents.dev">atlasagents.dev</a> működő termék: ügynökök telepítése és kezelése az <strong>OpenClaw</strong> és a <strong>Hermes</strong> runtime-on (Nous Research). Náluk a Hermes az alapértelmezett, és OpenAI formájú API-t ad. Az OpenClaw-t könnyebb motorként írják le, amely egy 1 GB RAM-os csomagba is belefér.</p>
<p>A levél árai egyeznek az oldallal, ahogyan 2026. szeptember 25-én olvastam. A Builder csomag havi 29 dollár, bevezető áron 19. Ugyanazon az oldalon az összehasonlító táblázat az Atlas-t havi 2,50 dollártól, a teljesen felügyelt gépet 9 dollártól írja. A lábléc ezt mondja: „© 2026 Atlas Agents, a DBA of SovereignML, L.L.C.” A North Carolina Secretary of State nyilvántartását nem nyitottam meg. A lábléc sora nem ugyanaz, mint a bejegyzés.</p>
<h2>Ami a levélen nem stimmel</h2>
<ol>
<li><strong>Személyes iCloud, nem a domain.</strong> Az üzenet nem az @atlasagents.dev címről jött. Aki ügynökinfrastruktúrát árul és iCloudról ír, annak vagy még nincs céges levelezése, vagy nem akarja megmutatni.</li>
<li><strong>A címzett maga a feladó.</strong> A <a href="https://github.com/pavankmeka">github.com/pavankmeka</a> 2025. július 13-án jött létre. Egy nyilvános tárolója van, és az fork. Az én GitHub-belépőm a polascin. A levél tehát nem volt rendesen nekem címezve. Vagy saját magának küldte, vagy a Címzett fejléc szétesett a tömeges küldésnél.</li>
<li><strong>A GitHub-szervezet üres.</strong> A <a href="https://github.com/sovereignml">SovereignML</a> 2026. május 28-án jött létre. Nulla nyilvános tároló, egy követő. A profil kapcsolati e-mailje <em>admin@sovereignml@gmail.com</em> — két kukac, olyan cím, amelyre nem lehet válaszolni. Ügynökinfrastruktúrát árulnak, a saját GitHub-azonosságuk pedig törött.</li>
<li><strong>Öt név, egy nyilvános nyom.</strong> A <a href="https://atlasagents.dev/team">csapatoldal</a> Pavan Mekát, Subba Reddy Mekát, Mahmudur Labibot, Mahfuz Imont és Yeasir Joyt sorolja. A szervezet egyetlen nyilvános tagja a GitHubon Labib. Az X, az Instagram és a LinkedIn gombok a csapatoldalon <em>#</em>-re mutatnak, nem profilokra. Két Meka azonos vezetéknévvel az, amit az oldal mutat, nem további bizonyíték. Kis cég, és máshol nem találtam értékelést.</li>
<li><strong>Szöveg „superusereknek”.</strong> Egy mondat sincs arról, hogy mit csinálok. Csak egy megszólítás, amely minden nyilvános GitHub-profilra illik. Ez címgyűjtés, nem betörés a postafiókba.</li>
</ol>
<h2>Mit árulnak</h2>
<p>Az ígéret az, hogy az ügynök az első napon működik: az OpenClaw-t vagy a Hermest az ő vagy az ön szerverére telepítik, böngészővel, tudásbázissal és a saját n8n-jével. A modellkulcsokat ön hozza. Minden csomagban. Ez gyakorlatiasan hangzik, amíg nem látni, mit ad át egy ötfős, nyilvános múlttal nem rendelkező cégnek: egy ügynököt, amelynek a levelezésben, a Slackben vagy a CRM-ben kellene ülnie, plusz OpenAI- vagy OpenRouter-kulcsokat.</p>
<p>A kreditrendszer a saját szemléltetésükön is átláthatatlan. A kezdőoldal demó irányítópultja — „Welcome back, Admin” felirat, nem számla — napi 1 180 kredit égését, 41 napos futamidőt és körülbelül napi 11,80 dollárt mutat. Egy havi 19 dolláros csomag ezt a tempót nem fedezi. Az Agent 37, az AgentSky és a Jurniti összehasonlítása az ő táblázatuk. Nem független teszt.</p>
<h2>Mit tegyen</h2>
<ul>
<li><strong>Hagyja a spamben.</strong> Ne válaszoljon, még „nem, köszönöm” formában sem. A válasz megerősíti, hogy a cím él, és ez az üzenet nyilvánvalóan tömeges.</li>
<li><strong>Rejtse el az e-mailt a GitHubon.</strong> A Settings → Emails alatt kapcsolja be a „Keep my email addresses private” és a „Block command line pushes that expose my email address” lehetőséget. A nyilvános profilra azt a noreply címet tegye, amelyet a GitHub ugyanazon a képernyőn kiír. A formája <em>felhasználó@users.noreply.github.com</em> vagy <em>ID+felhasználó@users.noreply.github.com</em>. <a href="https://docs.github.com/en/account-and-profile/how-tos/setting-up-and-managing-your-personal-account-on-github/managing-email-preferences/setting-your-commit-email-address">A GitHub a commit e-mail mellett írja le</a>. Ezzel véget ér a profilról lekapart levelek egész kategóriája.</li>
<li><strong>Ha a termék egyszer valóban érdekli,</strong> csak utána: LLC-bejegyzés a North Carolina Secretary of State-nél, referenciák, amelyeket ön hív fel, és API-kulcsok csak burnerként, napi költési plafonnal. Soha széles jogosultsággal. Ma nem.</li>
</ul>
<p>Ez a harmadik hullám ugyanazon az alapon. Előtte <a href="article.php?slug=ai-generovany-email-o-knihe-je-scam">hízelgés egy könyvről</a> és egy book trailer. A forrás nem betörés. Nyilvános e-mail egy GitHub-profilon, és egy scraper.</p>
<p>A levelet a spamben hagytam. Ha hasonló érkezett önhöz, írjon a <a href="contact.php">kapcsolati űrlapon</a>. Ne a feladónak.</p>
<p><em>Személyes beszámoló, nem jogi tanács. A nevek és a számok azok, amelyek 2026. szeptember 25-én a weben, a GitHubon és a levélben álltak. A cégjegyzéket nem ellenőriztem. A gyanús üzenetet jelentse a levelezőszolgáltatónak.</em></p>
HTML,
        ],
        'it' => [
            'title' => 'Atlas Agents ha scritto da iCloud. Il sito è reale. Le chiavi API restano qui.',
            'image_alt' => 'Un banco notturno davanti a una vetrina vuota: un laptop con un pannello luminoso, una busta, un telefono e un mazzo di chiavi che una mano non prende.',
            'excerpt' => 'Un’e-mail non richiesta da pavankmeka@icloud.com vende hosting di agenti IA. atlasagents.dev funziona e i prezzi coincidono. L’organizzazione GitHub no. Non rispondete e non consegnate le chiavi.',
            'content' => <<<'HTML'
<p>Mi è arrivata un’e-mail sull’hosting di agenti IA. Mittente <em>pavankmeka@icloud.com</em>, prodotto <a href="https://atlasagents.dev">Atlas Agents</a>. Gmail l’ha messa nello spam. Il testo era di massa: «Built for GitHub superusers like you.» Nel campo A non c’era il mio nome. C’era <em>pavankmeka</em> — il login del mittente.</p>
<p>Non è lo stesso schema dell’<a href="article.php?slug=ai-book-trailer-ponuka-je-scam">offerta di book trailer</a>. Lì non c’era un sito. Qui il sito c’è. Anche così non gli darei adesso un centesimo, e tanto meno chiavi API.</p>
<h2>Cosa sul sito regge</h2>
<p><a href="https://atlasagents.dev">atlasagents.dev</a> è un prodotto che funziona: distribuire e gestire agenti sui runtime <strong>OpenClaw</strong> e <strong>Hermes</strong> (Nous Research). Hermes è la loro scelta predefinita e espone un’API in forma OpenAI. Descrivono OpenClaw come il motore più leggero, quello che entra anche in un piano da 1 GB di RAM.</p>
<p>I prezzi nell’e-mail coincidono con la pagina come l’ho letta il 25 settembre 2026. Il piano Builder è 29 dollari al mese, 19 al prezzo di lancio. La tabella comparativa sullo stesso sito indica Atlas da 2,50 dollari al mese e una macchina completamente gestita da 9. Il piè di pagina dice: «© 2026 Atlas Agents, a DBA of SovereignML, L.L.C.» Non ho aperto il registro del North Carolina Secretary of State. Una riga nel piè di pagina non è un deposito.</p>
<h2>Cosa non torna</h2>
<ol>
<li><strong>Un iCloud personale, non il dominio.</strong> Il messaggio non arrivava da @atlasagents.dev. Chi vende infrastruttura di agenti e scrive da iCloud o non ha ancora una posta aziendale, o non vuole mostrarla.</li>
<li><strong>Il destinatario è il mittente.</strong> <a href="https://github.com/pavankmeka">github.com/pavankmeka</a> è stato creato il 13 luglio 2025. Ha un solo repository pubblico, ed è un fork. Il mio login GitHub è polascin. Il messaggio quindi non era indirizzato bene a me. O l’ha mandato a se stesso, o l’intestazione A si è sfaldata in un invio di massa.</li>
<li><strong>L’organizzazione GitHub è vuota.</strong> <a href="https://github.com/sovereignml">SovereignML</a> è stata creata il 28 maggio 2026. Zero repository pubblici, un follower. L’e-mail di contatto nel profilo è <em>admin@sovereignml@gmail.com</em> — due chiocciole, un indirizzo a cui nessuno può rispondere. Vendono infrastruttura di agenti e la loro identità su GitHub è rotta.</li>
<li><strong>Cinque nomi, una traccia pubblica.</strong> La <a href="https://atlasagents.dev/team">pagina del team</a> elenca Pavan Meka, Subba Reddy Meka, Mahmudur Labib, Mahfuz Imon e Yeasir Joy. L’unico membro pubblico dell’organizzazione su GitHub è Labib. I pulsanti X, Instagram e LinkedIn sulla pagina del team puntano a <em>#</em>, non a profili. Due Meka con lo stesso cognome è ciò che mostra la pagina, non un’altra prova. Una piccola società, e non ho trovato recensioni altrove.</li>
<li><strong>Testo per «superuser».</strong> Nemmeno una frase su quello che faccio. Solo un saluto che sta su ogni profilo GitHub pubblico. È raccolta di indirizzi, non un’intrusione nella casella.</li>
</ol>
<h2>Cosa vendono</h2>
<p>La promessa è un agente che funziona dal primo giorno: installano OpenClaw o Hermes sul loro server o sul vostro, con browser, knowledge base e il vostro n8n. Le chiavi dei modelli le portate voi. In ogni piano. Suona pratico finché non si vede che cosa si consegna a un gruppo di cinque persone senza storia pubblica: un agente che dovrebbe stare nella posta, su Slack o nel CRM, più chiavi di OpenAI o OpenRouter.</p>
<p>Il modello a crediti è opaco anche nella loro illustrazione. La dashboard demo in homepage — titolo «Welcome back, Admin», non una fattura — mostra un consumo di 1 180 crediti al giorno, un runway di 41 giorni e circa 11,80 dollari al giorno. Un piano da 19 dollari al mese non copre quel ritmo. Il confronto con Agent 37, AgentSky e Jurniti è la loro tabella. Non un test indipendente.</p>
<h2>Cosa fare</h2>
<ul>
<li><strong>Lasciatelo nello spam.</strong> Non rispondete, nemmeno con «no, grazie». Una risposta conferma che l’indirizzo è vivo, e questo messaggio è chiaramente di massa.</li>
<li><strong>Nascondete l’e-mail su GitHub.</strong> In Settings → Emails attivate «Keep my email addresses private» e «Block command line pushes that expose my email address». Sul profilo pubblico mettete l’indirizzo noreply che GitHub mostra in quella stessa schermata. Ha la forma <em>utente@users.noreply.github.com</em> oppure <em>ID+utente@users.noreply.github.com</em>. <a href="https://docs.github.com/en/account-and-profile/how-tos/setting-up-and-managing-your-personal-account-on-github/managing-email-preferences/setting-your-commit-email-address">GitHub lo descrive accanto all’e-mail di commit</a>. Così finisce l’intera categoria di messaggi raschiati dal profilo.</li>
<li><strong>Se il prodotto un giorno vi interessa davvero,</strong> solo allora: un deposito LLC presso il North Carolina Secretary of State, referenze che chiamate voi, e chiavi API solo come burner con un tetto di spesa giornaliero. Mai con permessi ampi. Oggi no.</li>
</ul>
<p>Questa è la terza ondata sulla stessa base. Prima, <a href="article.php?slug=ai-generovany-email-o-knihe-je-scam">lusinghe su un libro</a> e un book trailer. La fonte non è un’intrusione. È un’e-mail pubblica su un profilo GitHub e uno scraper.</p>
<p>Ho lasciato il messaggio nello spam. Se ne è arrivato uno simile, scrivetemi tramite il <a href="contact.php">modulo di contatto</a>. Non al mittente.</p>
<p><em>È un resoconto personale, non un parere legale. Nomi e cifre sono ciò che il 25 settembre 2026 stava sul sito, su GitHub e nell’e-mail. Non ho verificato il registro della società. Segnalate un messaggio sospetto al fornitore di posta.</em></p>
HTML,
        ],
        'uk' => [
            'title' => 'Atlas Agents написав з iCloud. Сайт справжній. Ключі API лишаю собі.',
            'image_alt' => 'Нічна стійка перед порожньою скляною вітриною: ноутбук зі світним панелем, конверт, телефон і зв’язка ключів, до якої рука не тягнеться.',
            'excerpt' => 'Непроханий лист з pavankmeka@icloud.com продає хостинг ШІ-агентів. atlasagents.dev працює, і ціни збігаються. Організація на GitHub — ні. Не відповідайте і не віддавайте ключі.',
            'content' => <<<'HTML'
<p>Мені надійшов лист про хостинг ШІ-агентів. Відправник <em>pavankmeka@icloud.com</em>, продукт <a href="https://atlasagents.dev">Atlas Agents</a>. Gmail поклав його в спам. Текст був масовий: «Built for GitHub superusers like you.» У полі Кому стояло не моє ім’я. Там стояло <em>pavankmeka</em> — логін відправника.</p>
<p>Це не той самий шаблон, що <a href="article.php?slug=ai-book-trailer-ponuka-je-scam">пропозиція book trailer</a>. Там не було сайту. Тут сайт є. І все одно я не дав би їм зараз ні цента, а ключів API — тим більше.</p>
<h2>Що на сайті сходиться</h2>
<p><a href="https://atlasagents.dev">atlasagents.dev</a> — робочий продукт: розгортання й керування агентами на runtime <strong>OpenClaw</strong> і <strong>Hermes</strong> (Nous Research). Hermes у них типовий і має API у формі OpenAI. OpenClaw вони описують як легший рушій, який вміщується і в план з 1 ГБ оперативної пам’яті.</p>
<p>Ціни в листі збігаються зі сторінкою, як я її читав 25 вересня 2026 року. План Builder — 29 доларів на місяць, за стартовою ціною 19. Порівняльна таблиця на тому самому сайті вказує Atlas від 2,50 долара на місяць і повністю керовану машину від 9. У підвалі написано: «© 2026 Atlas Agents, a DBA of SovereignML, L.L.C.» Реєстр North Carolina Secretary of State я не відкривав. Рядок у підвалі — це не те саме, що запис у реєстрі.</p>
<h2>Що в листі не сходиться</h2>
<ol>
<li><strong>Особистий iCloud, не домен.</strong> Лист прийшов не з @atlasagents.dev. Хто продає інфраструктуру агентів і пише з iCloud, або ще не має корпоративної пошти, або не хоче її показувати.</li>
<li><strong>Адресат — це відправник.</strong> <a href="https://github.com/pavankmeka">github.com/pavankmeka</a> створено 13 липня 2025 року. Один публічний репозиторій, і це форк. Мій логін на GitHub — polascin. Отже, лист не був нормально адресований мені. Або він надіслав його собі, або заголовок Кому розсипався під час масового розсилання.</li>
<li><strong>Організація на GitHub порожня.</strong> <a href="https://github.com/sovereignml">SovereignML</a> створено 28 травня 2026 року. Нуль публічних репозиторіїв, один підписник. Контактна адреса в профілі — <em>admin@sovereignml@gmail.com</em>: два символи @, адреса, на яку неможливо відповісти. Вони продають інфраструктуру агентів, а власна ідентичність на GitHub зламана.</li>
<li><strong>П’ять імен, один публічний слід.</strong> <a href="https://atlasagents.dev/team">Сторінка команди</a> називає Павана Меку, Суббу Редді Меку, Махмудура Лабіба, Махфуза Імона і Єасіра Джоя. Єдиний публічний учасник організації на GitHub — Лабіб. Кнопки X, Instagram і LinkedIn на сторінці команди ведуть на <em>#</em>, не на профілі. Два Меки з одним прізвищем — це те, що показано на сторінці, а не додатковий доказ. Мала фірма, і відгуків я деінде не знайшов.</li>
<li><strong>Текст для «суперкористувачів».</strong> Жодного речення про те, що я роблю. Лише звернення, яке пасує до будь-якого публічного профілю GitHub. Це збір адрес, а не злам скриньки.</li>
</ol>
<h2>Що вони продають</h2>
<p>Обіцянка — робочий агент з першого дня: вони встановлюють OpenClaw або Hermes на свій чи ваш сервер, із браузером, базою знань і вашим n8n. Ключі до моделей приносите ви. На кожному плані. Це звучить практично, доки не видно, що ви віддаєте фірмі з п’яти людей без публічної історії: агента, який має сидіти в пошті, у Slack або в CRM, плюс ключі OpenAI чи OpenRouter.</p>
<p>Кредитна модель непрозора навіть на їхній власній ілюстрації. Демопанель на головній сторінці — заголовок «Welcome back, Admin», не рахунок — показує спалювання 1 180 кредитів на день, запас на 41 день і близько 11,80 долара на день. План за 19 доларів на місяць такого темпу не покриє. Порівняння з Agent 37, AgentSky і Jurniti — це їхня таблиця. Не незалежний тест.</p>
<h2>Що робити</h2>
<ul>
<li><strong>Лишіть це в спамі.</strong> Не відповідайте, навіть «ні, дякую». Відповідь підтвердить, що адреса жива, а цей лист явно масовий.</li>
<li><strong>Сховайте адресу на GitHub.</strong> У Settings → Emails увімкніть «Keep my email addresses private» і «Block command line pushes that expose my email address». У публічний профіль поставте noreply-адресу, яку GitHub показує на тому самому екрані. Вона має вигляд <em>користувач@users.noreply.github.com</em> або <em>ID+користувач@users.noreply.github.com</em>. <a href="https://docs.github.com/en/account-and-profile/how-tos/setting-up-and-managing-your-personal-account-on-github/managing-email-preferences/setting-your-commit-email-address">GitHub описує це біля адреси для комітів</a>. Так закінчується ціла категорія листів, зідраних із профілю.</li>
<li><strong>Якщо продукт колись справді зацікавить,</strong> лише тоді: запис LLC у North Carolina Secretary of State, рекомендації, яким зателефонуєте ви самі, і ключі API лише як burner із денною стелею витрат. Ніколи з широкими правами. Сьогодні — ні.</li>
</ul>
<p>Це третя хвиля на тій самій основі. Перед тим — <a href="article.php?slug=ai-generovany-email-o-knihe-je-scam">компліменти про книжку</a> і book trailer. Джерело — не злам. Це публічна адреса в профілі GitHub і скрейпер.</p>
<p>Лист я лишив у спамі. Якщо подібний надійшов і вам, напишіть мені через <a href="contact.php">контакт</a>. Не відправнику.</p>
<p><em>Це особистий досвід, не юридична порада. Імена й цифри — те, що 25 вересня 2026 року стояло на сайті, на GitHub і в листі. Реєстр компанії я не перевіряв. Підозрілий лист повідомте своєму поштовому сервісу.</em></p>
HTML,
        ],
    ],
];
