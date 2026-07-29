<?php

declare(strict_types=1);

$requestedScript = str_replace('\\', '/', (string) ($_SERVER['SCRIPT_NAME'] ?? $_SERVER['PHP_SELF'] ?? ''));
$executedFile = isset($_SERVER['SCRIPT_FILENAME']) ? realpath((string) $_SERVER['SCRIPT_FILENAME']) : false;
if (
    $executedFile === __FILE__
    || preg_match('~(?:^|/)lang/[a-z]{2}\.php(?:/|$)~i', $requestedScript) === 1
) {
    if (PHP_SAPI === 'cli') {
        fwrite(STDERR, "Chyba: katalóg prekladov je interný súbor a nemožno ho spúšťať priamo.\n");
        exit(1);
    }
    http_response_code(403);
    exit('Prístup odmietnutý.');
}
unset($requestedScript, $executedFile);

/**
 * Slovenský katalóg prekladov — zdrojový jazyk.
 *
 * Kľúče sú stabilné identifikátory, nie texty. Zástupné znaky sa píšu ako `:meno`.
 * Ostatné jazyky sa odvodzujú od tohto súboru; chýbajúci kľúč v inom jazyku
 * spadne späť sem.
 */
return [
    // Prepínač jazyka
    'lang.switch' => 'Jazyk',
    'lang.switch_aria' => 'Zvoliť jazyk stránky',
    'lang.current' => 'Aktuálny jazyk: :language',

    // Spoločné prvky rozhrania
    'common.site_name' => 'Polascin.net',
    'common.author' => 'MUDr. Ľubomír Polaščín',
    'common.author_short' => 'Ľubomír Polaščín',
    'common.skip_to_content' => 'Preskočiť na hlavný obsah',
    'common.main_navigation' => 'Hlavná navigácia',
    'common.main_content' => 'Hlavný obsah',
    'common.open_navigation' => 'Otvoriť navigáciu',
    'common.close_navigation' => 'Zavrieť navigáciu',
    'common.toggle_dark_mode' => 'Prepnúť tmavý režim',
    'common.switch_to_dark' => 'Prepnúť na tmavý režim',
    'common.switch_to_light' => 'Prepnúť na svetlý režim',
    'common.required' => 'povinné',
    'common.back' => 'Späť',
    'common.read_more' => 'Čítať viac',
    'common.visit' => 'Navštíviť :target',
    'common.opens_new_tab' => 'otvorí sa v novej karte',
    'common.author_meta_prefix' => 'Autor',

    // Navigácia
    'nav.home' => 'Domov',
    'nav.blog' => 'Blog',
    'nav.about' => 'O mne',
    'nav.nephrology' => 'Nefrológia',
    'nav.projects' => 'Projekty',
    'nav.books' => 'Knihy',
    'nav.links' => 'Odkazy',
    'nav.contact' => 'Kontakt',
    'nav.admin' => 'Administrácia',
    'nav.logout' => 'Odhlásiť sa',
    'nav.login' => 'Prihlásenie',

    // Pätička
    'footer.heading' => 'Kontakt a profily',
    'footer.linkedin' => 'Profil na LinkedIn',
    'footer.x' => 'Profil na X',
    'footer.facebook' => 'Profil na Facebooku',
    'footer.email' => 'Poslať e-mail',
    'footer.patreon' => 'Podporiť na Patreon',
    'footer.discord' => 'Pripojiť sa na Discord',
    'footer.copyright' => '© 1998 – :year Ľubomír Polaščín. Všetky práva vyhradené.',
    'footer.privacy' => 'Ochrana súkromia',
    'footer.terms' => 'Podmienky používania',
    'footer.cookie_settings' => 'Nastavenia cookies',

    // Metadáta stránok
    'meta.default_description' => 'Osobný a profesijný web MUDr. Ľubomíra Polaščína: nefrológia a dialýza, medicínske vzdelávanie a písanie, odborné preklady a praktické digitálne nástroje.',
    'meta.home_tagline' => 'Nefrológia, medicínske vzdelávanie a digitálne nástroje',
    'meta.articles_title' => 'Články',
    'meta.articles_description' => 'Najnovšie články a postrehy od MUDr. Ľubomíra Polaščína o nefrológii, internej medicíne, technológiách a písaní.',
    'meta.articles_404_title' => 'Stránka článkov nebola nájdená',
    'meta.articles_404_description' => 'Požadovaná stránka zoznamu článkov neexistuje.',
    'meta.article_404_title' => 'Nenájdené',
    'meta.article_404_description' => 'Článok nebol nájdený.',
    'meta.contact_title' => 'Kontakt',
    'meta.contact_description' => 'Kontaktujte MUDr. Ľubomíra Polaščína pre profesionálne otázky, spoluprácu alebo dotazy.',
    'meta.newsletter_title' => 'Newsletter',
    'meta.newsletter_description' => 'Prihláste sa na odber noviniek z Polascin.net — aktuality o nefrológii, internej medicíne, knihách a technológiách.',
    'meta.login_title' => 'Prihlásenie',
    'meta.login_description' => 'Prihlásenie administrátora na Polascin.net.',
    'meta.privacy_title' => 'Ochrana súkromia',
    'meta.privacy_description' => 'Zásady ochrany súkromia pre webovú stránku MUDr. Ľubomíra Polaščína.',
    'meta.terms_title' => 'Podmienky používania',
    'meta.terms_description' => 'Podmienky používania webovej stránky MUDr. Ľubomíra Polaščína.',

    // Domovská stránka — hrdina
    'home.logo_alt' => 'Crystal Kidney',
    'home.hero_title' => 'MUDr. Ľubomír Polaščín',
    'home.hero_subtitle' => 'Som nefrológ a internista, medicínsky pedagóg a autor. Dlhoročnú skúsenosť s dialýzou prepájam s odborným písaním, prekladmi a tvorbou praktických digitálnych nástrojov.',
    'home.cta_about' => 'Čomu sa venujem',
    'home.cta_articles' => 'Čítať články',

    // Domovská stránka — životopis
    'home.about_heading' => 'O mne',
    'home.about_intro' => 'Som lekár so špecializáciou v nefrológii a vnútornom lekárstve. Moja profesijná práca sa sústreďuje na dialýzu a ochorenia obličiek; viedol som dve dialyzačné pracoviská v Bratislave a pôsobil v medicínskom vzdelávaní.',
    'home.about_who' => 'Píšem odborné aj literárne texty, prekladám medicínsky obsah medzi slovenčinou a angličtinou a tvorím webové stránky a aplikácie. Technológie a umelú inteligenciu posudzujem podľa praktického prínosu: či sprístupnia poznanie, zjednodušia prácu alebo zvýšia kvalitu výsledku.',
    'home.about_synthesis' => 'V medicíne, jazyku aj kóde postupujem podobne: presne pomenujem problém, overím podstatné fakty, priznám neistotu a vytvorím zrozumiteľný, použiteľný výsledok.',

    'home.areas_heading' => 'Čomu sa venujem',
    'home.areas_medicine' => 'Nefrológia a vzdelávanie',
    'home.areas_medicine_1' => 'nefrológia a dialýza',
    'home.areas_medicine_2' => 'interná medicína',
    'home.areas_medicine_3' => 'náhrada funkcie obličiek',
    'home.areas_medicine_4' => 'ultrasonografia a starostlivosť o cievne prístupy',
    'home.areas_medicine_5' => 'odborné prednášky a vzdelávanie',
    'home.areas_language' => 'Písanie a preklad',
    'home.areas_language_1' => 'odborné medicínske texty',
    'home.areas_language_2' => 'medicínske preklady a terminologická práca',
    'home.areas_language_3' => 'lokalizácia medicínskeho softvéru',
    'home.areas_language_4' => 'beletria, eseje a literatúra faktu',
    'home.areas_language_5' => 'popularizácia medicíny a edukácia pacientov',
    'home.areas_tech' => 'Digitálne projekty',
    'home.areas_tech_1' => 'tvorba webových stránok a aplikácií',
    'home.areas_tech_2' => 'medicínske kalkulačky a digitálne nástroje',
    'home.areas_tech_3' => 'automatizácia spracovania informácií',
    'home.areas_tech_4' => 'kritické a praktické využitie umelej inteligencie',
    'home.areas_tech_5' => 'otvorený softvér a systémy Linux/Unix',

    'home.skills_heading' => 'Nástroje a technológie',
    'home.skills_web' => 'Webové technológie',
    'home.skills_web_text' => 'HTML5, CSS3, JavaScript, TypeScript, PHP',
    'home.skills_data' => 'Programovanie a dáta',
    'home.skills_data_text' => 'Python, SQL, databázy a spracovanie dát',
    'home.skills_systems' => 'Systémy a infraštruktúra',
    'home.skills_systems_text' => 'Linux, Unix, slobodný a otvorený softvér',
    'home.skills_ai' => 'Umelá inteligencia',
    'home.skills_ai_text' => 'jazykové modely, automatizácia a kritické hodnotenie ich využitia v medicíne',

    'home.education_heading' => 'Vzdelanie a profesijná dráha',
    'home.education_text' => 'Všeobecné lekárstvo som absolvoval na Univerzite Pavla Jozefa Šafárika v Košiciach v roku 1995. Atestáciu z vnútorného lekárstva som získal v roku 1998 a špecializáciu v nefrológii v roku 2009, keď som získal aj certifikát z abdominálnej ultrasonografie u dospelých.',
    'home.education_path' => 'Dialýze a nefrológii sa venujem od roku 1995. Neskôr som viedol dve dialyzačné pracoviská v Bratislave a pôsobil v medicínskom vzdelávaní.',
    'home.education_scope' => 'Moje odborné skúsenosti zahŕňajú hemodialýzu, hemodiafiltráciu, peritoneálnu dialýzu, akútne eliminačné metódy, ultrasonografiu, starostlivosť o cievne prístupy a prípravu pacientov na transplantáciu obličky. Tieto skúsenosti prepájam s odborným písaním, prednášaním, vzdelávaním a tvorbou medicínskych digitálnych projektov.',

    'home.personal_heading' => 'Mimo medicíny',
    'home.personal_text' => 'Zaujíma ma literatúra, filozofia, poézia a cestovanie.',
    'home.personal_writing' => 'V knihách a ďalších textoch sa vraciam k medicíne, morálnym konfliktom a vzťahu človeka k technológiám.',

    'home.identity_nephrologist' => 'Nefrológ',
    'home.identity_internist' => 'Internista',

    'home.books_cta' => 'Pozrieť knihy',
    'home.amazon_cta' => 'Profil autora na Amazone',

    // Domovská stránka — nefrológia
    'home.nephrology_heading' => 'Nefrológia v skratke',
    'home.nephrology_intro' => 'Nefrológia nie je iba o dialýze. Spája prevenciu, včasnú diagnostiku a dlhodobú liečbu ochorení obličiek s náhradou ich funkcie vtedy, keď konzervatívny postup už nestačí.',
    'home.ckd_title' => 'Chronické ochorenie obličiek (CKD)',
    'home.ckd_text' => 'Chronické ochorenie obličiek znamená dlhodobé poškodenie alebo zníženú funkciu obličiek. Často súvisí s cukrovkou či vysokým krvným tlakom a vyžaduje pravidelné sledovanie, liečbu príčin a znižovanie rizika ďalšieho zhoršovania.',
    'home.aki_title' => 'Akútne poškodenie obličiek (AKI)',
    'home.aki_text' => 'Akútne poškodenie obličiek je náhle zhoršenie ich funkcie. Môže vzniknúť pri závažnom ochorení, nedostatku tekutín, poruche odtoku moču alebo pôsobením niektorých liekov a toxických látok.',
    'home.hemodialysis_title' => 'Hemodialýza',
    'home.hemodialysis_text' => 'Pri hemodialýze sa krv vedie cez dialyzátor, ktorý odstraňuje odpadové látky a nadbytočnú tekutinu a pomáha upraviť vnútorné prostredie organizmu.',
    'home.peritoneal_title' => 'Peritoneálna dialýza',
    'home.peritoneal_text' => 'Pri peritoneálnej dialýze slúži pobrušnica ako prirodzená dialyzačná membrána. Dialyzačný roztok sa privádza do brušnej dutiny a po určenom čase vypúšťa.',
    'home.transplant_title' => 'Transplantácia',
    'home.transplant_text' => 'Pre vhodných pacientov môže transplantácia obličky priniesť lepšie prežívanie a kvalitu života než dlhodobá dialýza. Vyžaduje dôkladné posúdenie, celoživotné sledovanie a imunosupresívnu liečbu.',
    'home.diagnostics_title' => 'Diagnostika',
    'home.diagnostics_text' => 'Diagnostika vychádza z anamnézy, fyzikálneho vyšetrenia, analýzy krvi a moču a zobrazovacích metód. V odôvodnených prípadoch sa dopĺňa biopsia obličky.',
    'home.nephrology_note' => 'Tieto informácie majú vzdelávací charakter a nenahrádzajú lekárske vyšetrenie ani individuálne odporúčanie.',

    // Domovská stránka — články, projekty, odkazy, kontakt
    'home.latest_heading' => 'Najnovšie články',
    'home.all_articles' => 'Zobraziť všetky články',
    'home.projects_heading' => 'Vybrané projekty',
    'home.projects_intro' => 'Projekty, ktoré vytváram alebo dlhodobo spravujem v oblasti medicíny, vzdelávania a technológií.',
    'home.project_nefro_text' => 'Slovenský portál s odbornými článkami, klinickými novinkami, kalkulačkami, liekovými údajmi a študijnými materiálmi z nefrológie.',
    'home.project_nephrosite_text' => 'Archív slovenských prednášok a referenčných materiálov z nefrológie, dialýzy, eliminačných metód a vnútorného lekárstva.',
    'home.project_books_text' => 'Prehľad mojich kníh, odborných publikácií, kapitol a ďalšej autorskej tvorby.',
    'home.project_alphagrab_text' => 'Experimentálny vyhľadávač podujatí a vstupeniek využívajúci Ticketmaster Discovery API.',
    'home.project_arenibus_text' => 'Nefrologický informačný systém v .NET, vo fáze pokročilého vývoja, určený pre ambulanciu a dialyzačné stredisko. MVP zahŕňa evidenciu pacientov a návštev, dialyzačné predpisy, termíny, laboratórne výsledky, audit a integráciu so slovenským ezdravotníctvom; verejné demo používa fiktívne dáta.',
    'home.links_heading' => 'Ďalšie stránky a odkazy',
    'home.links_intro' => 'Moje ďalšie weby, knihy a vybrané nástroje.',
    'home.link_nephrosite' => 'NephroSite (v slovenčine)',
    'home.link_dialysis_bratislava' => 'Dialýza Bratislava: Medimpax',
    'home.link_impax_centres' => 'Dialyzačné strediská IMPAX',
    'home.link_vital_2nd' => 'Vital Algorithm — 2. vydanie (Amazon)',
    'home.link_vital_1st' => 'The Vital Algorithm — 1. vydanie (Amazon)',
    'home.contact_heading' => 'Kontakt',
    'home.contact_intro' => 'Pre odbornú spoluprácu, prednášku, medicínsky preklad alebo digitálny projekt mi napíšte. Tento kontakt neslúži na urgentné zdravotné otázky.',
    'home.contact_cta' => 'Otvoriť kontaktný formulár',

    // Zoznam článkov
    'articles.heading' => 'Články',
    'articles.aria_label' => 'Články',
    'articles.empty' => 'Zatiaľ neboli publikované žiadne články.',
    'articles.page_missing' => 'Požadovaná stránka neexistuje.',
    'articles.go_first_page' => 'Prejsť na prvú stránku článkov',
    'articles.pagination_label' => 'Stránkovanie článkov',
    'articles.no_translation' => 'Tento článok zatiaľ nie je dostupný vo zvolenom jazyku. Zobrazujeme pôvodnú verziu.',

    // Detail článku
    'article.aria_label' => 'Obsah článku',
    'article.not_found_aria' => 'Článok nebol nájdený',
    'article.not_found_heading' => 'Článok nebol nájdený',
    'article.not_found_text' => 'Požadovaný článok neexistuje alebo nie je publikovaný.',
    'article.back_to_list' => 'Späť na články',
    'article.admin_preview' => 'Administrátorský náhľad — tento článok zatiaľ nie je verejne dostupný.',
    'article.available_in' => 'Dostupné aj v jazyku:',

    // Kontaktný formulár
    'contact.heading' => 'Kontakt',
    'contact.aria_label' => 'Kontaktný formulár',
    'contact.name' => 'Meno',
    'contact.email' => 'E-mail',
    'contact.subject' => 'Predmet',
    'contact.message' => 'Správa',
    'contact.submit' => 'Odoslať správu',
    'contact.success' => 'Ďakujem. Správa bola odoslaná.',
    'contact.error_name' => 'Prosím, zadajte platné meno.',
    'contact.error_email' => 'Prosím, zadajte platnú e-mailovú adresu.',
    'contact.error_subject' => 'Predmet je príliš dlhý.',
    'contact.error_message' => 'Prosím, zadajte správu (max 5000 znakov).',
    'contact.error_rate_limit' => 'Príliš veľa správ z tejto adresy. Skúste to znova neskôr.',
    'contact.error_save' => 'Nepodarilo sa odoslať správu. Skúste to znova neskôr.',

    // Newsletter
    'newsletter.heading' => 'Newsletter',
    'newsletter.aria_label' => 'Prihlásenie na odber noviniek',
    'newsletter.intro' => 'Prihláste sa na e-mailové upozornenia na nové články, knihy a projekty.',
    'newsletter.email' => 'E-mailová adresa',
    'newsletter.subscribe' => 'Prihlásiť na odber',
    'newsletter.confirm_unsubscribe' => 'Potvrdiť odhlásenie',
    'newsletter.unsubscribe_prompt' => 'Potvrďte, že sa chcete odhlásiť z odberu newslettera.',
    'newsletter.unsubscribe_link_invalid' => 'Odkaz na odhlásenie je neplatný.',
    'newsletter.unsubscribe_link_used' => 'Odkaz na odhlásenie je neplatný alebo už bol použitý.',
    'newsletter.unsubscribed' => 'Boli ste úspešne odhlásení z odberu.',
    'newsletter.confirm_link_used' => 'Potvrdzovací odkaz je neplatný alebo už bol použitý.',
    'newsletter.confirmed' => 'Vaše predplatné bolo potvrdené. Ďakujeme!',
    'newsletter.pending' => 'Ak je možné adresu prihlásiť, poslali sme na ňu ďalšie pokyny.',
    'newsletter.rate_limit_confirm' => 'Príliš veľa pokusov o potvrdenie. Skúste to znova neskôr.',
    'newsletter.rate_limit_unsubscribe' => 'Príliš veľa pokusov o odhlásenie. Skúste to znova neskôr.',
    'newsletter.rate_limit_subscribe' => 'Príliš veľa pokusov. Skúste to znova neskôr.',
    'newsletter.error_email' => 'Prosím, zadajte platnú e-mailovú adresu.',
    'newsletter.error_generic' => 'Vyskytla sa chyba. Skúste to znova neskôr.',
    'newsletter.error_mail_failed' => 'Potvrdzovací e-mail sa nepodarilo odoslať. Skúste to znova neskôr.',
    'newsletter.error_domain' => 'Doména e-mailovej adresy sa nezdá byť platná.',
    'newsletter.error_action' => 'Neplatná akcia formulára.',
    'newsletter.unsubscribe_hint' => 'Odhlasovací odkaz sme poslali e-mailom. Pre istotu si ho môžete uložiť aj teraz:',
    'newsletter.unsubscribe_hint_link' => 'odhlásiť newsletter',
    'newsletter.mail_confirm_subject' => 'Potvrďte odber Polascin.net',
    'newsletter.mail_confirm_body' => "Ďakujeme za záujem o newsletter Polascin.net.\n\nOdber potvrďte kliknutím na odkaz (platí 48 hodín):\n:url\n\nAk ste o odber nežiadali, tento e-mail ignorujte.",
    'newsletter.mail_welcome_subject' => 'Potvrdenie odberu Polascin.net',
    'newsletter.mail_welcome_body' => "Vaše predplatné newslettera Polascin.net bolo potvrdené.\n\nOdhlásenie z odberu:\n:url\n\nAk ste si odber neobjednali, použite odhlasovací odkaz.",

    // Prihlásenie
    'login.heading' => 'Prihlásenie administrátora',
    'login.aria_label' => 'Prihlásenie',
    'login.username' => 'Prihlasovacie meno',
    'login.password' => 'Heslo',
    'login.submit' => 'Prihlásiť sa',
    'login.error_credentials' => 'Neplatné prihlasovacie meno alebo heslo.',
    'login.error_rate_limit' => 'Príliš veľa pokusov o prihlásenie. Skúste to znova neskôr.',
    'login.session_expired' => 'Vaša relácia vypršala z dôvodu nečinnosti. Prihláste sa znova.',
    'login.account_inactive' => 'Váš účet už nie je aktívny. Prihláste sa znova.',

    // Odhlásenie (hlásenia sa zobrazujú na verejnej stránke)
    'logout.success' => 'Boli ste odhlásení.',
    'logout.csrf_failed' => 'Odhlásenie sa nepodarilo overiť. Skúste to znova.',

    // Spoločné chyby
    'error.csrf' => 'Neplatný bezpečnostný token. Obnovte stránku a skúste to znova.',

    // Cookies (posiela sa do JavaScriptu)
    'cookie.title' => 'Analytické cookies',
    'cookie.description' => 'S vaším súhlasom používam Google Analytics 4 na meranie návštevnosti. Bez súhlasu sa analytika nenačíta a reklamné funkcie zostávajú vypnuté. Podrobnosti nájdete v',
    'cookie.privacy_link' => 'zásadách ochrany súkromia',
    'cookie.decline' => 'Odmietnuť',
    'cookie.accept' => 'Povoliť analytiku',

    // Ochrana súkromia
    'privacy.heading' => 'Ochrana súkromia',
    'privacy.updated' => 'Posledná aktualizácia: 28. júla 2026',
    'privacy.s1_heading' => '1. Úvod',
    'privacy.s1_text' => 'Vitajte na stránke <strong>polascin.net</strong>. Rešpektujem vaše súkromie a zaväzujem sa chrániť vaše osobné údaje. Táto politika ochrany súkromia vysvetľuje, ako nakladám s vašimi osobnými údajmi pri návšteve tejto webovej stránky, a popisuje vaše práva na ochranu súkromia a príslušnú právnu ochranu.',
    'privacy.s2_heading' => '2. Informácie, ktoré zhromažďujem',
    'privacy.s2_text' => 'Táto webová stránka má predovšetkým informačný charakter. Nevyžadujem od vás vytvorenie účtu.',
    'privacy.s2_technical' => '<strong>Technické údaje:</strong> Zahŕňajú adresu internetového protokolu (IP), typ prehliadača, navštívenú adresu, čas požiadavky a základné údaje o odpovedi. Tieto údaje sa používajú na zabezpečenie, diagnostiku a ochranu formulárov pred zneužitím. Citlivé parametre odkazov sa pred uložením odstraňujú.',
    'privacy.s2_contact' => '<strong>Kontaktný formulár:</strong> Ak odošlete správu, uložím meno, e-mailovú adresu, predmet, text správy a čas odoslania, aby som mohol na správu odpovedať.',
    'privacy.s2_newsletter' => '<strong>Newsletter:</strong> Pri prihlásení na odber uložím e-mailovú adresu, čas prihlásenia a kryptografické odtlačky tokenov potrebné na potvrdenie a odhlásenie z odberu.',
    'privacy.s2_cookies' => '<strong>Cookies a lokálne úložisko:</strong> Lokálne ukladám iba preferenciu témy (tmavý/svetlý režim), zvolený jazyk a vaše rozhodnutie o analytike. <strong>Google Analytics 4 (GA4):</strong> Analytický skript sa nenačíta, kým výslovne nekliknete na tlačidlo Povoliť analytiku v lište súhlasu. Reklamné kategórie súhlasu zostávajú vypnuté. Svoje rozhodnutie môžete kedykoľvek zmeniť cez Nastavenia cookies v pätičke.',
    'privacy.s3_heading' => '3. Ako používam vaše informácie',
    'privacy.s3_text' => 'Vaše údaje používam na:',
    'privacy.s3_item1' => 'Poskytovanie obsahu webovej stránky.',
    'privacy.s3_item2' => 'Zabezpečenie bezpečnosti webovej stránky.',
    'privacy.s3_item3' => 'Zapamätanie preferencie témy, jazyka a rozhodnutia o analytike.',
    'privacy.s3_item4' => 'Spracovanie kontaktných správ a správa odberu newslettera na základe vašej žiadosti.',
    'privacy.s3_item5' => 'Analýzu návštevnosti a spôsobov používania webovej stránky prostredníctvom Google Analytics 4, avšak iba v prípade, že kliknete na tlačidlo <strong>Povoliť analytiku</strong> v lište súhlasu s cookies. Právny základ: váš súhlas (článok 6 ods. 1 písm. a) GDPR). Analytické údaje uchováva spoločnosť Google podľa vlastných pravidiel uchovávania (zvyčajne najviac 14 mesiacov). Súhlas môžete kedykoľvek odvolať prostredníctvom tlačidla <strong>Nastavenia cookies</strong> v pätičke a výberom možnosti <strong>Odmietnuť</strong>.',
    'privacy.s4_heading' => '4. Doba uchovávania',
    'privacy.s4_text' => 'Vlastné technické prístupové záznamy sa predvolene automaticky odstraňujú po 90 dňoch; prevádzkovateľ môže túto dobu skrátiť. Krátkodobé záznamy ochrany formulárov sa priebežne odstraňujú po uplynutí ochranného okna. Kontaktné správy uchovávam iba po dobu potrebnú na vybavenie komunikácie. E-mail newslettera uchovávam do odhlásenia z odberu.',
    'privacy.s5_heading' => '5. Odkazy tretích strán',
    'privacy.s5_text' => 'Táto webová stránka môže obsahovať odkazy na webové stránky, doplnky a aplikácie tretích strán (napr. Amazon, sociálne siete). Kliknutím na tieto odkazy môžu tretie strany zhromažďovať alebo zdieľať údaje o vás. Nemám kontrolu nad týmito webovými stránkami tretích strán a nenesiem zodpovednosť za ich vyhlásenia o ochrane súkromia.',
    'privacy.s6_heading' => '6. Vaše zákonné práva (GDPR/CCPA)',
    'privacy.s6_text' => 'Za určitých okolností máte práva vyplývajúce zo zákonov o ochrane osobných údajov vo vzťahu k vašim osobným údajom, vrátane práva požiadať o prístup, opravu, vymazanie alebo obmedzenie spracúvania vašich osobných údajov.',
    'privacy.s7_heading' => '7. Kontakt',
    'privacy.s7_text' => 'Ak máte akékoľvek otázky týkajúce sa tejto politiky ochrany súkromia, kontaktujte ma na adrese:',

    // Podmienky používania
    'terms.heading' => 'Podmienky používania',
    'terms.updated' => 'Posledná aktualizácia: 28. júla 2026',
    'terms.s1_heading' => '1. Akceptácia podmienok',
    'terms.s1_text' => 'Prístupom na webovú stránku a jej používaním <strong>polascin.net</strong> (ďalej len „webová stránka“) akceptujete a súhlasíte, že vás zaväzujú podmienky a ustanovenia tejto dohody.',
    'terms.s2_heading' => '2. Zdravotné zrieknutie sa zodpovednosti',
    'terms.s2_important' => '<strong>DÔLEŽITÉ:</strong> Obsah poskytovaný na tejto webovej stránke slúži len na informačné účely. <strong>Nenahrádza</strong> odborné lekárske poradenstvo, diagnostiku ani liečbu.',
    'terms.s2_text' => 'V prípade akýchkoľvek otázok týkajúcich sa zdravotného stavu sa vždy obráťte na svojho lekára alebo iného kvalifikovaného zdravotníckeho pracovníka. Nikdy nepodceňujte odborné lekárske odporúčanie ani neodkladajte vyhľadanie lekárskej pomoci z dôvodu informácií, ktoré ste si prečítali na tejto webovej stránke.',
    'terms.s3_heading' => '3. Duševné vlastníctvo',
    'terms.s3_text' => 'Obsah, štruktúra, grafika, dizajn, kompilácia a iné prvky súvisiace s touto webovou stránkou sú chránené príslušnými autorskými právami a zákonmi o duševnom vlastníctve. Akékoľvek kopírovanie, redistribúcia, použitie alebo publikovanie týchto prvkov alebo akejkoľvek časti webovej stránky používateľom je prísne zakázané.',
    'terms.s4_heading' => '4. Obmedzenie zodpovednosti',
    'terms.s4_text' => 'V žiadnom prípade nenesiem zodpovednosť za akékoľvek náhodné, nepriame, následné alebo mimoriadne škody akejkoľvek povahy, ani za akékoľvek iné škody, vrátane, ale nie výhradne, škôd vzniknutých v dôsledku straty zisku, straty zmlúv, goodwillu, údajov, informácií, príjmov, očakávaných úspor alebo obchodných vzťahov, bez ohľadu na to, či som bol upozornený na možnosť takýchto škôd, a to v súvislosti s používaním tejto webovej stránky alebo akýchkoľvek na ňu odkazovaných webových stránok.',
    'terms.s5_heading' => '5. Rozhodné právo',
    'terms.s5_text' => 'Tieto podmienky a ustanovenia sa riadia a interpretujú v súlade s právnymi predpismi Slovenskej republiky a bez výhrad sa podriaďujete výlučnej právomoci súdov v tomto mieste.',

    // Administrácia
    'admin.language' => 'Jazyk',
    'admin.language_hint' => 'Jazyk, v ktorom je obsah napísaný.',
    'admin.translation_group' => 'Skupina prekladov',
    'admin.translation_group_hint' => 'Rovnaké číslo prepojí preklady toho istého článku medzi jazykmi. Prázdne pole vytvorí novú skupinu.',
];
