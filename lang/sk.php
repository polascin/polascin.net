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
    'nav.about' => 'Životopis',
    'nav.nephrology' => 'Nefrológia',
    'nav.projects' => 'Projekty',
    'nav.books' => 'Knihy',
    'nav.links' => 'Odkazy',
    'nav.contact' => 'Kontakt',
    'nav.admin' => 'Administrácia',
    'nav.logout' => 'Odhlásiť sa',
    'nav.login' => 'Prihlásenie',

    // Pätička
    'footer.heading' => 'Spojte sa',
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
    'meta.keywords' => 'Ľubomír Polaščín, nefrológia, interná medicína, dialýza, lekársky preklad, programovanie',
    'meta.default_description' => 'MUDr. Ľubomír Polaščín — nefrológ, internista, lekársky prekladateľ, spisovateľ a samouk programátor.',
    'meta.home_title' => 'Domov',
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
    'home.logo_alt' => 'Logo Crystal Kidney',
    'home.hero_title' => 'Pokrok v zdraví obličiek',
    'home.hero_subtitle' => 'MUDr. Ľubomír Polaščín — venovaný excelentnosti v nefrológii, dialýze, starostlivosti o pacientov a medicínskych technológiách.',
    'home.cta_about' => 'O mne',
    'home.cta_articles' => 'Najnovšie články',

    // Domovská stránka — životopis
    'home.about_heading' => 'O MUDr. Ľubomírovi Polaščínovi',
    'home.about_intro' => 'Volám sa Ľubomír Polaščín — som lekár, nefrológ a internista povolaním, spisovateľ beletrie a literatúry faktu poslaním a samouk programátor z vášne.',
    'home.about_who' => 'Moja práca spočíva na priesečníku medicíny, rozprávania príbehov a technológií. Medicína cibrí moju klinickú presnosť; písanie mi umožňuje skúmať ľudský údel cez beletriu a literatúru faktu; a technológie ma posúvajú pri riešení zložitých problémov. Ako konzultant tieto svety prepájam a prinášam premyslené, dobre podložené riešenia.',
    'home.who_heading' => 'Kto som',
    'home.who_approach' => 'Ku každej výzve pristupujem so zvedavosťou a dôslednosťou — či už liečim pacientov, ladím kód, prekladám náročný text alebo skúmam umelú inteligenciu.',
    'home.bio_heading' => 'Životopisné údaje',
    'home.bio_name' => 'Meno',
    'home.bio_pronunciation' => 'Výslovnosť',
    'home.bio_email' => 'E-mail',
    'home.bio_web' => 'Web',
    'home.bio_social' => 'Sociálne siete',
    'home.identity_heading' => 'Profesionálna identita',
    'home.identity_text' => 'Som lekár, ktorý promoval vo všeobecnom lekárstve (1995) a atestoval z nefrológie (2009). Atestáciu z vnútorného lekárstva mám z roku 1998 a certifikát z abdominálnej ultrasonografie u dospelých z roku 2009.',
    'home.expertise_heading' => 'Oblasti odbornosti',
    'home.expertise_dialysis' => 'Dialýza a náhrada funkcie obličiek (hemodialýza, hemodiafiltrácia, hemofiltrácia)',
    'home.expertise_vascular' => 'Ultrasonografia cievnych prístupov pre dialýzu',
    'home.expertise_elimination' => 'Extrakorporálne a intrakorporálne eliminačné metódy',
    'home.expertise_plasma' => 'Membránová separácia plazmy a súvisiace liečebné postupy',
    'home.expertise_transplant' => 'Transplantácia obličiek',
    'home.teaching_text' => 'Mám rozsiahle skúsenosti s výučbou a prednášaním vo vnútornom lekárstve, diabetológii, nefrológii a príbuzných odboroch. Venujem sa aj prekladom — anglicko-slovenským a slovensko-anglickým lekárskym prekladom a lokalizácii softvéru.',
    'home.tech_text' => 'Informačné technológie, informatika a programovanie sú mojou dlhodobou súčasťou. Zaujímajú ma najmä:',
    'home.identity_doctor' => 'Lekár (MUDr.)',
    'home.identity_nephrologist' => 'Nefrológ',
    'home.identity_internist' => 'Internista',
    'home.identity_translator' => 'Lekársky prekladateľ',
    'home.identity_writer' => 'Spisovateľ beletrie a literatúry faktu',
    'home.identity_programmer' => 'Samouk programátor',
    'home.skills_heading' => 'Technológie, IT a programovanie',
    'home.education_heading' => 'Vzdelanie a kariéra',
    'home.education_text' => 'Svoje lekárske vzdelanie som začal na Univerzite Pavla Jozefa Šafárika v Košiciach. Od roku 1995 sa zameriavam na dialýzu a nefrológiu. V rokoch 2013 až 2022 som pôsobil ako primár na dvoch dialyzačných strediskách v Bratislave.',
    'home.personal_heading' => 'Osobné',
    'home.personal_text' => 'Narodený v roku 1971 v Československu, vyrastal som v Kyjove. Moje rusínske korene formujú môj pohľad na svet. Mojimi záľubami sú čítanie, cestovanie, filozofia a poézia.',
    'home.amazon_cta' => 'Zobraziť na Amazon Author Central',

    // Domovská stránka — nefrológia
    'home.nephrology_heading' => 'Nefrológia',
    'home.nephrology_intro' => 'Nefrológia je kľúčový lekársky odbor zaoberajúci sa obličkami — životne dôležitými orgánmi zodpovednými za rovnováhu tekutín, filtráciu odpadových látok a reguláciu krvného tlaku.',
    'home.ckd_title' => 'Chronické ochorenie obličiek (CKD)',
    'home.ckd_text' => 'Manažment postupnej straty funkcie obličiek v čase spôsobenej cukrovkou, hypertenziou alebo inými faktormi.',
    'home.aki_title' => 'Akútne poškodenie obličiek (AKI)',
    'home.aki_text' => 'Liečba náhleho, často dočasného zlyhania funkcie obličiek spôsobeného infekciami, dehydratáciou alebo toxínmi.',
    'home.hemodialysis_title' => 'Hemodialýza',
    'home.hemodialysis_text' => 'Procedúra, pri ktorej sa dialyzačný prístroj a špeciálny filter nazývaný umelá oblička používajú na čistenie krvi.',
    'home.peritoneal_title' => 'Peritoneálna dialýza',
    'home.peritoneal_text' => 'Liečba, ktorá využíva výstelku brušnej dutiny a čistiaci roztok nazývaný dialyzát na čistenie krvi.',
    'home.transplant_title' => 'Transplantácia',
    'home.transplant_text' => 'Najlepšia liečba zlyhania obličiek. Zdravá oblička sa umiestni do tela, aby vykonala prácu, ktorú vlastné obličky už nedokážu zvládnuť.',
    'home.diagnostics_title' => 'Diagnostika',
    'home.diagnostics_text' => 'Využívanie ultrazvuku, biopsie obličiek a pokročilých laboratórnych testov na presnú diagnostiku obličkových ochorení.',

    // Domovská stránka — články, projekty, odkazy, kontakt
    'home.latest_heading' => 'Najnovšie články',
    'home.all_articles' => 'Zobraziť všetky články',
    'home.projects_heading' => 'Projekty a sieť',
    'home.projects_intro' => 'Výber webových stránok, nástrojov a zdrojov, ktoré budujem alebo spravujem v oblasti medicíny, vzdelávania a technológií.',
    'home.project_nefro_text' => 'Slovenský nefrologický portál s klinickými článkami, aktualitami o dialýze a transplantáciách, kalkulačkami, referenciami liekov a študijnými poznámkami.',
    'home.project_nephrosite_text' => 'Vzdelávacie prednášky a referenčné stránky o nefrológii, dialýze, metódach očisťovania krvi a internom lekárstve (v slovenčine).',
    'home.project_books_text' => 'Centrálny archív kníh, akademických publikácií, kapitol a literárnych diel MUDr. Ľubomíra Polaščína.',
    'home.project_alphagrab_text' => 'Experimentálny projekt na objavovanie lístkov, ktorý obohacuje záložné odkazy cez Ticketmaster Discovery API.',
    'home.project_arenibus_text' => 'Verejná demo inštancia pre webový projekt o udalostiach a doprave.',
    'home.links_heading' => 'Sieť a zdroje',
    'home.links_intro' => 'Preskúmajte ďalšie súvisiace stránky a zdroje.',
    'home.link_nephrosite' => 'NephroSite (v slovenčine)',
    'home.link_vital_2nd' => 'Vital Algorithm — 2. vydanie (Amazon)',
    'home.link_vital_1st' => 'The Vital Algorithm — 1. vydanie (Amazon)',
    'home.contact_heading' => 'Kontakt',
    'home.contact_intro' => 'Neváhajte ma kontaktovať s otázkami alebo ohľadom spolupráce.',
    'home.contact_cta' => 'Poslať správu',

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
    'contact.success' => 'Ďakujeme za vašu správu. Ozveme sa vám čoskoro.',
    'contact.error_name' => 'Prosím, zadajte platné meno.',
    'contact.error_email' => 'Prosím, zadajte platnú e-mailovú adresu.',
    'contact.error_subject' => 'Predmet je príliš dlhý.',
    'contact.error_message' => 'Prosím, zadajte správu (max 5000 znakov).',
    'contact.error_rate_limit' => 'Príliš veľa správ z tejto adresy. Skúste to znova neskôr.',
    'contact.error_save' => 'Nepodarilo sa odoslať správu. Skúste to znova neskôr.',

    // Newsletter
    'newsletter.heading' => 'Newsletter',
    'newsletter.aria_label' => 'Prihlásenie na odber noviniek',
    'newsletter.intro' => 'Prihláste sa na odber aktualít o článkoch, knihách a projektoch.',
    'newsletter.email' => 'E-mailová adresa',
    'newsletter.subscribe' => 'Odoberať',
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
    'cookie.description' => 'S vaším súhlasom použijeme Google Analytics 4 na meranie návštevnosti. Reklamné úložisko a personalizácia zostávajú vypnuté. Odmietnutie neobmedzí používanie stránky. Podrobnosti nájdete v',
    'cookie.privacy_link' => 'zásadách ochrany súkromia',
    'cookie.decline' => 'Odmietnuť',
    'cookie.accept' => 'Súhlasím',

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
    'privacy.s2_cookies' => '<strong>Cookies a lokálne úložisko:</strong> Lokálne ukladám iba preferenciu témy (tmavý/svetlý režim), zvolený jazyk a vaše rozhodnutie o analytike. <strong>Google Analytics 4 (GA4):</strong> Analytický skript sa nenačíta, kým výslovne nekliknete na tlačidlo Súhlasím v lište súhlasu. Reklamné kategórie súhlasu zostávajú vypnuté. Svoje rozhodnutie môžete kedykoľvek zmeniť cez Nastavenia cookies v pätičke.',
    'privacy.s3_heading' => '3. Ako používam vaše informácie',
    'privacy.s3_text' => 'Vaše údaje používam na:',
    'privacy.s3_item1' => 'Poskytovanie obsahu webovej stránky.',
    'privacy.s3_item2' => 'Zabezpečenie bezpečnosti webovej stránky.',
    'privacy.s3_item3' => 'Zapamätanie preferencie témy, jazyka a rozhodnutia o analytike.',
    'privacy.s3_item4' => 'Spracovanie kontaktných správ a správa odberu newslettera na základe vašej žiadosti.',
    'privacy.s3_item5' => 'Analýzu návštevnosti a spôsobov používania webovej stránky prostredníctvom Google Analytics 4, avšak iba v prípade, že kliknete na tlačidlo <strong>Súhlasím</strong> v lište súhlasu s cookies. Právny základ: váš súhlas (článok 6 ods. 1 písm. a) GDPR). Analytické údaje uchováva spoločnosť Google podľa vlastných pravidiel uchovávania (zvyčajne najviac 14 mesiacov). Súhlas môžete kedykoľvek odvolať prostredníctvom tlačidla <strong>Nastavenia cookies</strong> v pätičke a výberom možnosti <strong>Odmietnuť</strong>.',
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
