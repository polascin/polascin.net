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
 * Český katalog překladů.
 *
 * Klíče jsou stabilní identifikátory, nikoli texty. Zástupné znaky se píší jako `:jméno`.
 * Ostatní jazyky se odvozují od slovenského souboru; chybějící klíč v jiném jazyce
 * spadne zpět tam.
 */
return [
    // Přepínač jazyka
    'lang.switch' => 'Jazyk',
    'lang.switch_aria' => 'Zvolit jazyk stránek',
    'lang.current' => 'Aktuální jazyk: :language',

    // Společné prvky rozhraní
    'common.site_name' => 'Polascin.net',
    'common.author' => 'MUDr. Ľubomír Polaščín',
    'common.author_short' => 'Ľubomír Polaščín',
    'common.skip_to_content' => 'Přeskočit na hlavní obsah',
    'common.main_navigation' => 'Hlavní navigace',
    'common.main_content' => 'Hlavní obsah',
    'common.open_navigation' => 'Otevřít navigaci',
    'common.close_navigation' => 'Zavřít navigaci',
    'common.toggle_dark_mode' => 'Přepnout tmavý režim',
    'common.switch_to_dark' => 'Přepnout na tmavý režim',
    'common.switch_to_light' => 'Přepnout na světlý režim',
    'common.required' => 'povinné',
    'common.back' => 'Zpět',
    'common.read_more' => 'Číst více',
    'common.visit' => 'Navštívit :target',
    'common.opens_new_tab' => 'otevře se v nové kartě',
    'common.author_meta_prefix' => 'Autor',

    // Navigace
    'nav.home' => 'Domů',
    'nav.blog' => 'Blog',
    'nav.about' => 'Životopis',
    'nav.nephrology' => 'Nefrologie',
    'nav.projects' => 'Projekty',
    'nav.books' => 'Knihy',
    'nav.links' => 'Odkazy',
    'nav.contact' => 'Kontakt',
    'nav.admin' => 'Administrace',
    'nav.logout' => 'Odhlásit se',
    'nav.login' => 'Přihlášení',

    // Zápatí
    'footer.heading' => 'Spojte se se mnou',
    'footer.linkedin' => 'Profil na LinkedIn',
    'footer.x' => 'Profil na X',
    'footer.facebook' => 'Profil na Facebooku',
    'footer.email' => 'Poslat e-mail',
    'footer.patreon' => 'Podpořit na Patreonu',
    'footer.discord' => 'Připojit se na Discord',
    'footer.copyright' => '© 1998 – :year Ľubomír Polaščín. Všechna práva vyhrazena.',
    'footer.privacy' => 'Ochrana soukromí',
    'footer.terms' => 'Podmínky používání',
    'footer.cookie_settings' => 'Nastavení cookies',

    // Metadata stránek
    'meta.keywords' => 'Ľubomír Polaščín, nefrologie, vnitřní lékařství, dialýza, lékařský překlad, programování',
    'meta.default_description' => 'Osobní a profesní web nefrologa a internisty se zaměřením na dialýzu, odborné vzdělávání, lékařské psaní, překlady a digitální technologie ve zdravotnictví.',
    'meta.home_tagline' => 'Nefrologie, dialýza a lékařské technologie',
    'meta.articles_title' => 'Články',
    'meta.articles_description' => 'Nejnovější články a postřehy MUDr. Ľubomíra Polaščína o nefrologii, vnitřním lékařství, technologiích a psaní.',
    'meta.articles_404_title' => 'Stránka článků nebyla nalezena',
    'meta.articles_404_description' => 'Požadovaná stránka seznamu článků neexistuje.',
    'meta.article_404_title' => 'Nenalezeno',
    'meta.article_404_description' => 'Článek nebyl nalezen.',
    'meta.contact_title' => 'Kontakt',
    'meta.contact_description' => 'Kontaktujte MUDr. Ľubomíra Polaščína v odborných záležitostech, ohledně spolupráce nebo s dotazy.',
    'meta.newsletter_title' => 'Newsletter',
    'meta.newsletter_description' => 'Přihlaste se k odběru novinek z Polascin.net — aktuality o nefrologii, vnitřním lékařství, knihách a technologiích.',
    'meta.login_title' => 'Přihlášení',
    'meta.login_description' => 'Přihlášení administrátora na Polascin.net.',
    'meta.privacy_title' => 'Ochrana soukromí',
    'meta.privacy_description' => 'Zásady ochrany soukromí pro webové stránky MUDr. Ľubomíra Polaščína.',
    'meta.terms_title' => 'Podmínky používání',
    'meta.terms_description' => 'Podmínky používání webových stránek MUDr. Ľubomíra Polaščína.',

    // Domovská stránka — hlavní blok
    'home.logo_alt' => 'Crystal Kidney',
    'home.hero_eyebrow' => 'Crystal Kidney',
    'home.hero_title' => 'Přesná nefrologie. Lidská péče. Smysluplné technologie.',
    'home.hero_subtitle' => 'Jsem nefrolog a internista s dlouholetou praxí v dialýze a léčbě onemocnění ledvin. Klinickou zkušenost propojuji s odborným psaním, vzděláváním a tvorbou digitálních řešení pro medicínu.',
    'home.cta_about' => 'O mně',
    'home.cta_articles' => 'Nejnovější články',

    // Domovská stránka — životopis
    'home.about_heading' => 'O mně',
    'home.about_intro' => 'Jsem lékař se specializací v nefrologii a vnitřním lékařství. Většinu svého profesního života se věnuji onemocněním ledvin, dialýze a péči o pacienty, jejichž léčba vyžaduje nejen odbornou přesnost, ale také důvěru, srozumitelnou komunikaci a respekt k individuálním potřebám.',
    'home.about_who' => 'Vedle klinické práce píši odborné i literární texty, věnuji se lékařským překladům a tvořím webové stránky a aplikace. Programování a umělou inteligenci nevnímám jako samoúčelné novinky. Jsou to pro mě praktické nástroje, které mohou zpřístupnit poznání, zjednodušit práci a podpořit kvalitnější rozhodování v medicíně.',
    'home.about_synthesis' => 'Medicína, jazyk a technologie pro mě nejsou oddělené oblasti. Spojuje je stejná otázka: jak porozumět složitému problému a vytvořit řešení, které je přesné, srozumitelné a skutečně použitelné.',

    'home.areas_heading' => 'Oblasti působení',
    'home.areas_medicine' => 'Medicína',
    'home.areas_medicine_1' => 'nefrologie a dialyzační medicína',
    'home.areas_medicine_2' => 'vnitřní lékařství',
    'home.areas_medicine_3' => 'náhrada funkce ledvin',
    'home.areas_medicine_4' => 'ultrasonografie a péče o cévní přístupy',
    'home.areas_medicine_5' => 'odborné konzultace a vzdělávání',
    'home.areas_language' => 'Jazyk a autorská tvorba',
    'home.areas_language_1' => 'odborné lékařské texty',
    'home.areas_language_2' => 'lékařské překlady a terminologická práce',
    'home.areas_language_3' => 'lokalizace lékařského softwaru',
    'home.areas_language_4' => 'beletrie, eseje a literatura faktu',
    'home.areas_language_5' => 'popularizace medicíny a edukace pacientů',
    'home.areas_tech' => 'Technologie',
    'home.areas_tech_1' => 'tvorba webových stránek a aplikací',
    'home.areas_tech_2' => 'lékařské kalkulačky a digitální nástroje',
    'home.areas_tech_3' => 'automatizace zpracování informací',
    'home.areas_tech_4' => 'umělá inteligence v medicíně',
    'home.areas_tech_5' => 'otevřený software a systémy Linux/Unix',

    'home.skills_heading' => 'Technologické dovednosti',
    'home.skills_web' => 'Webové technologie',
    'home.skills_web_text' => 'HTML5, CSS3, JavaScript, TypeScript, PHP',
    'home.skills_data' => 'Data a programování',
    'home.skills_data_text' => 'SQL, Python, databázové systémy, zpracování dat',
    'home.skills_systems' => 'Systémy a infrastruktura',
    'home.skills_systems_text' => 'Linux, Unix, svobodný a otevřený software',
    'home.skills_ai' => 'Umělá inteligence',
    'home.skills_ai_text' => 'generativní AI, automatizace, jazykové modely a jejich praktické využití v medicíně',

    'home.education_heading' => 'Vzdělání a profesní dráha',
    'home.education_text' => 'Všeobecné lékařství jsem vystudoval na Univerzitě Pavla Jozefa Šafárika v Košicích. Po začátcích ve vnitřním lékařství jsem se postupně zaměřil na nefrologii, dialýzu a eliminační metody.',
    'home.education_path' => 'K nefrologii mě přivedlo přirozené spojení klinické medicíny s technikou, která může bezprostředně ovlivnit zdravotní stav a kvalitu života pacienta. Od roku 1995 se věnuji dialyzační léčbě a onemocněním ledvin. V letech 2013 až 2022 jsem vedl dvě dialyzační pracoviště v Bratislavě.',
    'home.education_scope' => 'Mé odborné zkušenosti zahrnují hemodialýzu, hemodiafiltraci, peritoneální dialýzu, akutní eliminační metody, ultrasonografii, péči o cévní přístupy a přípravu pacientů k transplantaci ledviny. Klinickou praxi doplňuji odborným psaním, přednášením, vzděláváním a tvorbou digitálních projektů v medicíně.',

    'home.personal_heading' => 'Osobní pohled',
    'home.personal_text' => 'Četba, cestování, filozofie, spiritualita a poezie mi pomáhají vnímat medicínu v širších lidských souvislostech. Zajímají mě příběhy, jazyk, vědomí a otázky, které přesahují hranice jednoho oboru.',
    'home.personal_writing' => 'V literární tvorbě se vracím především k medicíně, lidské existenci, morálním konfliktům a vztahu člověka k technologiím. I zde hledám totéž co v medicíně: přesnost, pravdivost a hlubší porozumění člověku.',

    'home.identity_nephrologist' => 'Nefrolog',
    'home.identity_internist' => 'Internista',

    'home.books_cta' => 'Knihy a autorská tvorba',
    'home.amazon_cta' => 'Autorský profil na Amazonu',

    // Domovská stránka — nefrologie
    'home.nephrology_heading' => 'Nefrologie',
    'home.nephrology_intro' => 'Nefrologie je klíčový lékařský obor zabývající se ledvinami — životně důležitými orgány, které odpovídají za rovnováhu tekutin, filtraci odpadních látek a regulaci krevního tlaku.',
    'home.ckd_title' => 'Chronické onemocnění ledvin (CKD)',
    'home.ckd_text' => 'Management postupné ztráty funkce ledvin v průběhu času, způsobené cukrovkou, hypertenzí nebo jinými faktory.',
    'home.aki_title' => 'Akutní poškození ledvin (AKI)',
    'home.aki_text' => 'Léčba náhlého, často dočasného selhání funkce ledvin způsobeného infekcemi, dehydratací nebo toxiny.',
    'home.hemodialysis_title' => 'Hemodialýza',
    'home.hemodialysis_text' => 'Výkon, při kterém se k očistě krve používá dialyzační přístroj a speciální filtr zvaný umělá ledvina.',
    'home.peritoneal_title' => 'Peritoneální dialýza',
    'home.peritoneal_text' => 'Léčba, která k očistě krve využívá výstelku břišní dutiny a čisticí roztok zvaný dialyzát.',
    'home.transplant_title' => 'Transplantace',
    'home.transplant_text' => 'Nejlepší léčba selhání ledvin. Zdravá ledvina se umístí do těla, aby vykonávala práci, kterou vlastní ledviny už nezvládají.',
    'home.diagnostics_title' => 'Diagnostika',
    'home.diagnostics_text' => 'Využití ultrazvuku, biopsie ledviny a pokročilých laboratorních testů k přesné diagnostice onemocnění ledvin.',

    // Domovská stránka — články, projekty, odkazy, kontakt
    'home.latest_heading' => 'Nejnovější články',
    'home.all_articles' => 'Zobrazit všechny články',
    'home.projects_heading' => 'Projekty a síť',
    'home.projects_intro' => 'Výběr webových stránek, nástrojů a zdrojů, které buduji nebo spravuji v oblasti medicíny, vzdělávání a technologií.',
    'home.project_nefro_text' => 'Slovenský nefrologický portál s klinickými články, aktualitami o dialýze a transplantacích, kalkulačkami, přehledy léků a studijními poznámkami.',
    'home.project_nephrosite_text' => 'Vzdělávací přednášky a referenční stránky o nefrologii, dialýze, metodách očišťování krve a vnitřním lékařství (ve slovenštině).',
    'home.project_books_text' => 'Centrální archiv knih, akademických publikací, kapitol a literárních děl MUDr. Ľubomíra Polaščína.',
    'home.project_alphagrab_text' => 'Experimentální projekt pro vyhledávání vstupenek, který obohacuje záložní odkazy prostřednictvím Ticketmaster Discovery API.',
    'home.project_arenibus_text' => 'Veřejná demo instance webového projektu o událostech a dopravě.',
    'home.links_heading' => 'Síť a zdroje',
    'home.links_intro' => 'Prozkoumejte další související stránky a zdroje.',
    'home.link_nephrosite' => 'NephroSite (ve slovenštině)',
    'home.link_vital_2nd' => 'Vital Algorithm — 2. vydání (Amazon)',
    'home.link_vital_1st' => 'The Vital Algorithm — 1. vydání (Amazon)',
    'home.contact_heading' => 'Kontakt',
    'home.contact_intro' => 'Neváhejte se na mě obrátit s dotazy nebo ohledně spolupráce.',
    'home.contact_cta' => 'Poslat zprávu',

    // Seznam článků
    'articles.heading' => 'Články',
    'articles.aria_label' => 'Články',
    'articles.empty' => 'Zatím nebyly publikovány žádné články.',
    'articles.page_missing' => 'Požadovaná stránka neexistuje.',
    'articles.go_first_page' => 'Přejít na první stránku článků',
    'articles.pagination_label' => 'Stránkování článků',
    'articles.no_translation' => 'Tento článek zatím není dostupný ve zvoleném jazyce. Zobrazujeme původní verzi.',

    // Detail článku
    'article.aria_label' => 'Obsah článku',
    'article.not_found_aria' => 'Článek nebyl nalezen',
    'article.not_found_heading' => 'Článek nebyl nalezen',
    'article.not_found_text' => 'Požadovaný článek neexistuje nebo není publikován.',
    'article.back_to_list' => 'Zpět na články',
    'article.admin_preview' => 'Administrátorský náhled — tento článek zatím není veřejně dostupný.',
    'article.available_in' => 'Dostupné také v jazyce:',

    // Kontaktní formulář
    'contact.heading' => 'Kontakt',
    'contact.aria_label' => 'Kontaktní formulář',
    'contact.name' => 'Jméno',
    'contact.email' => 'E-mail',
    'contact.subject' => 'Předmět',
    'contact.message' => 'Zpráva',
    'contact.submit' => 'Odeslat zprávu',
    'contact.success' => 'Děkuji za zprávu. Ozvu se co nejdříve.',
    'contact.error_name' => 'Zadejte prosím platné jméno.',
    'contact.error_email' => 'Zadejte prosím platnou e-mailovou adresu.',
    'contact.error_subject' => 'Předmět je příliš dlouhý.',
    'contact.error_message' => 'Zadejte prosím zprávu (max. 5000 znaků).',
    'contact.error_rate_limit' => 'Příliš mnoho zpráv z této adresy. Zkuste to znovu později.',
    'contact.error_save' => 'Zprávu se nepodařilo odeslat. Zkuste to znovu později.',

    // Newsletter
    'newsletter.heading' => 'Newsletter',
    'newsletter.aria_label' => 'Přihlášení k odběru novinek',
    'newsletter.intro' => 'Přihlaste se k odběru aktualit o článcích, knihách a projektech.',
    'newsletter.email' => 'E-mailová adresa',
    'newsletter.subscribe' => 'Odebírat',
    'newsletter.confirm_unsubscribe' => 'Potvrdit odhlášení',
    'newsletter.unsubscribe_prompt' => 'Potvrďte, že se chcete odhlásit z odběru newsletteru.',
    'newsletter.unsubscribe_link_invalid' => 'Odkaz pro odhlášení je neplatný.',
    'newsletter.unsubscribe_link_used' => 'Odkaz pro odhlášení je neplatný nebo již byl použit.',
    'newsletter.unsubscribed' => 'Byli jste úspěšně odhlášeni z odběru.',
    'newsletter.confirm_link_used' => 'Potvrzovací odkaz je neplatný nebo již byl použit.',
    'newsletter.confirmed' => 'Váš odběr byl potvrzen. Děkujeme!',
    'newsletter.pending' => 'Pokud lze adresu přihlásit, poslali jsme na ni další pokyny.',
    'newsletter.rate_limit_confirm' => 'Příliš mnoho pokusů o potvrzení. Zkuste to znovu později.',
    'newsletter.rate_limit_unsubscribe' => 'Příliš mnoho pokusů o odhlášení. Zkuste to znovu později.',
    'newsletter.rate_limit_subscribe' => 'Příliš mnoho pokusů. Zkuste to znovu později.',
    'newsletter.error_email' => 'Zadejte prosím platnou e-mailovou adresu.',
    'newsletter.error_generic' => 'Došlo k chybě. Zkuste to znovu později.',
    'newsletter.error_mail_failed' => 'Potvrzovací e-mail se nepodařilo odeslat. Zkuste to prosím později.',
    'newsletter.error_domain' => 'Doména e-mailové adresy se nezdá být platná.',
    'newsletter.error_action' => 'Neplatná akce formuláře.',
    'newsletter.unsubscribe_hint' => 'Odhlašovací odkaz jsme poslali e-mailem. Pro jistotu si jej můžete uložit i nyní:',
    'newsletter.unsubscribe_hint_link' => 'odhlásit newsletter',
    'newsletter.mail_confirm_subject' => 'Potvrďte odběr Polascin.net',
    'newsletter.mail_confirm_body' => "Děkujeme za zájem o newsletter Polascin.net.\n\nOdběr potvrďte kliknutím na odkaz (platí 48 hodin):\n:url\n\nPokud jste o odběr nežádali, tento e-mail ignorujte.",
    'newsletter.mail_welcome_subject' => 'Potvrzení odběru Polascin.net',
    'newsletter.mail_welcome_body' => "Váš odběr newsletteru Polascin.net byl potvrzen.\n\nOdhlášení z odběru:\n:url\n\nPokud jste si odběr neobjednali, použijte odhlašovací odkaz.",

    // Přihlášení
    'login.heading' => 'Přihlášení administrátora',
    'login.aria_label' => 'Přihlášení',
    'login.username' => 'Přihlašovací jméno',
    'login.password' => 'Heslo',
    'login.submit' => 'Přihlásit se',
    'login.error_credentials' => 'Neplatné přihlašovací jméno nebo heslo.',
    'login.error_rate_limit' => 'Příliš mnoho pokusů o přihlášení. Zkuste to znovu později.',
    'login.session_expired' => 'Vaše relace vypršela z důvodu nečinnosti. Přihlaste se znovu.',
    'login.account_inactive' => 'Váš účet již není aktivní. Přihlaste se znovu.',

    // Odhlášení (hlášení se zobrazují na veřejné stránce)
    'logout.success' => 'Byli jste odhlášeni.',
    'logout.csrf_failed' => 'Odhlášení se nepodařilo ověřit. Zkuste to znovu.',

    // Společné chyby
    'error.csrf' => 'Neplatný bezpečnostní token. Obnovte stránku a zkuste to znovu.',

    // Cookies (posílá se do JavaScriptu)
    'cookie.title' => 'Analytické cookies',
    'cookie.description' => 'S vaším souhlasem použijeme Google Analytics 4 k měření návštěvnosti. Reklamní úložiště a personalizace zůstávají vypnuté. Odmítnutí neomezí používání stránek. Podrobnosti najdete v',
    'cookie.privacy_link' => 'zásadách ochrany soukromí',
    'cookie.decline' => 'Odmítnout',
    'cookie.accept' => 'Souhlasím',

    // Ochrana soukromí
    'privacy.heading' => 'Ochrana soukromí',
    'privacy.updated' => 'Poslední aktualizace: 28. července 2026',
    'privacy.s1_heading' => '1. Úvod',
    'privacy.s1_text' => 'Vítejte na stránkách <strong>polascin.net</strong>. Respektuji vaše soukromí a zavazuji se chránit vaše osobní údaje. Tyto zásady ochrany soukromí vysvětlují, jak s vašimi osobními údaji nakládám při návštěvě těchto webových stránek, a popisují vaše práva na ochranu soukromí i příslušnou právní ochranu.',
    'privacy.s2_heading' => '2. Informace, které shromažďuji',
    'privacy.s2_text' => 'Tyto webové stránky mají především informační charakter. Nevyžaduji od vás vytvoření účtu.',
    'privacy.s2_technical' => '<strong>Technické údaje:</strong> Zahrnují adresu internetového protokolu (IP), typ prohlížeče, navštívenou adresu, čas požadavku a základní údaje o odpovědi. Tyto údaje se používají k zabezpečení, diagnostice a ochraně formulářů před zneužitím. Citlivé parametry odkazů se před uložením odstraňují.',
    'privacy.s2_contact' => '<strong>Kontaktní formulář:</strong> Pokud odešlete zprávu, uložím jméno, e-mailovou adresu, předmět, text zprávy a čas odeslání, abych na zprávu mohl odpovědět.',
    'privacy.s2_newsletter' => '<strong>Newsletter:</strong> Při přihlášení k odběru uložím e-mailovou adresu, čas přihlášení a kryptografické otisky tokenů potřebné k potvrzení a odhlášení z odběru.',
    'privacy.s2_cookies' => '<strong>Cookies a lokální úložiště:</strong> Lokálně ukládám pouze předvolbu motivu (tmavý/světlý režim), zvolený jazyk a vaše rozhodnutí o analytice. <strong>Google Analytics 4 (GA4):</strong> Analytický skript se nenačte, dokud výslovně nekliknete na tlačítko Souhlasím v liště souhlasu. Reklamní kategorie souhlasu zůstávají vypnuté. Své rozhodnutí můžete kdykoli změnit přes Nastavení cookies v zápatí.',
    'privacy.s3_heading' => '3. Jak vaše informace používám',
    'privacy.s3_text' => 'Vaše údaje používám k:',
    'privacy.s3_item1' => 'Poskytování obsahu webových stránek.',
    'privacy.s3_item2' => 'Zajištění bezpečnosti webových stránek.',
    'privacy.s3_item3' => 'Zapamatování předvolby motivu, jazyka a rozhodnutí o analytice.',
    'privacy.s3_item4' => 'Zpracování kontaktních zpráv a správě odběru newsletteru na základě vaší žádosti.',
    'privacy.s3_item5' => 'Analýze návštěvnosti a způsobů používání webových stránek prostřednictvím Google Analytics 4, avšak pouze v případě, že kliknete na tlačítko <strong>Souhlasím</strong> v liště souhlasu s cookies. Právní základ: váš souhlas (čl. 6 odst. 1 písm. a) GDPR). Analytické údaje uchovává společnost Google podle vlastních pravidel uchovávání (obvykle nejvýše 14 měsíců). Souhlas můžete kdykoli odvolat prostřednictvím tlačítka <strong>Nastavení cookies</strong> v zápatí a volbou možnosti <strong>Odmítnout</strong>.',
    'privacy.s4_heading' => '4. Doba uchovávání',
    'privacy.s4_text' => 'Vlastní technické přístupové záznamy se ve výchozím nastavení automaticky odstraňují po 90 dnech; provozovatel může tuto dobu zkrátit. Krátkodobé záznamy ochrany formulářů se průběžně odstraňují po uplynutí ochranného okna. Kontaktní zprávy uchovávám pouze po dobu nezbytnou k vyřízení komunikace. E-mail newsletteru uchovávám do odhlášení z odběru.',
    'privacy.s5_heading' => '5. Odkazy třetích stran',
    'privacy.s5_text' => 'Tyto webové stránky mohou obsahovat odkazy na webové stránky, doplňky a aplikace třetích stran (např. Amazon, sociální sítě). Kliknutím na tyto odkazy mohou třetí strany shromažďovat nebo sdílet údaje o vás. Nemám nad těmito webovými stránkami třetích stran kontrolu a nenesu odpovědnost za jejich prohlášení o ochraně soukromí.',
    'privacy.s6_heading' => '6. Vaše zákonná práva (GDPR/CCPA)',
    'privacy.s6_text' => 'Za určitých okolností máte ve vztahu ke svým osobním údajům práva vyplývající ze zákonů o ochraně osobních údajů, včetně práva požádat o přístup, opravu, výmaz nebo omezení zpracování vašich osobních údajů.',
    'privacy.s7_heading' => '7. Kontakt',
    'privacy.s7_text' => 'Máte-li jakékoli dotazy týkající se těchto zásad ochrany soukromí, kontaktujte mě na adrese:',

    // Podmínky používání
    'terms.heading' => 'Podmínky používání',
    'terms.updated' => 'Poslední aktualizace: 28. července 2026',
    'terms.s1_heading' => '1. Přijetí podmínek',
    'terms.s1_text' => 'Přístupem na webové stránky <strong>polascin.net</strong> a jejich používáním (dále jen „webové stránky“) přijímáte podmínky a ustanovení této dohody a souhlasíte s tím, že jimi budete vázáni.',
    'terms.s2_heading' => '2. Vyloučení odpovědnosti za zdravotní informace',
    'terms.s2_important' => '<strong>DŮLEŽITÉ:</strong> Obsah poskytovaný na těchto webových stránkách slouží pouze k informačním účelům. <strong>Nenahrazuje</strong> odborné lékařské poradenství, diagnostiku ani léčbu.',
    'terms.s2_text' => 'V případě jakýchkoli otázek týkajících se zdravotního stavu se vždy obraťte na svého lékaře nebo jiného kvalifikovaného zdravotnického pracovníka. Nikdy nezanedbávejte odborné lékařské doporučení ani neodkládejte vyhledání lékařské pomoci kvůli informacím, které jste si přečetli na těchto webových stránkách.',
    'terms.s3_heading' => '3. Duševní vlastnictví',
    'terms.s3_text' => 'Obsah, struktura, grafika, design, kompilace a další prvky související s těmito webovými stránkami jsou chráněny příslušnými autorskými právy a zákony o duševním vlastnictví. Jakékoli kopírování, redistribuce, použití nebo publikování těchto prvků nebo jakékoli části webových stránek uživatelem je přísně zakázáno.',
    'terms.s4_heading' => '4. Omezení odpovědnosti',
    'terms.s4_text' => 'V žádném případě nenesu odpovědnost za jakékoli nahodilé, nepřímé, následné nebo mimořádné škody jakékoli povahy, ani za jakékoli jiné škody, včetně, avšak nikoli výhradně, škod vzniklých v důsledku ztráty zisku, ztráty smluv, goodwillu, dat, informací, příjmů, očekávaných úspor nebo obchodních vztahů, bez ohledu na to, zda jsem byl na možnost takových škod upozorněn, a to v souvislosti s používáním těchto webových stránek nebo jakýchkoli webových stránek, na které odkazují.',
    'terms.s5_heading' => '5. Rozhodné právo',
    'terms.s5_text' => 'Tyto podmínky a ustanovení se řídí a vykládají v souladu s právními předpisy Slovenské republiky a bez výhrad se podřizujete výlučné pravomoci soudů v tomto místě.',

    // Administrace
    'admin.language' => 'Jazyk',
    'admin.language_hint' => 'Jazyk, ve kterém je obsah napsán.',
    'admin.translation_group' => 'Skupina překladů',
    'admin.translation_group_hint' => 'Stejné číslo propojí překlady téhož článku mezi jazyky. Prázdné pole vytvoří novou skupinu.',
];
