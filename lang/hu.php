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
 * Magyar fordítási katalógus.
 *
 * A kulcsok állandó azonosítók, nem szövegek. A helyőrzőket `:név` alakban
 * írjuk. A fájl a `sk.php` alapján készült; a hiányzó kulcs a szlovák
 * katalógusra esik vissza.
 */
return [
    // Nyelvváltó
    'lang.switch' => 'Nyelv',
    'lang.switch_aria' => 'Az oldal nyelvének kiválasztása',
    'lang.current' => 'Jelenlegi nyelv: :language',

    // Közös felületi elemek
    'common.site_name' => 'Polascin.net',
    'common.author' => 'Dr. Ľubomír Polaščín',
    'common.author_short' => 'Ľubomír Polaščín',
    'common.skip_to_content' => 'Ugrás a fő tartalomra',
    'common.main_navigation' => 'Fő navigáció',
    'common.main_content' => 'Fő tartalom',
    'common.open_navigation' => 'Navigáció megnyitása',
    'common.close_navigation' => 'Navigáció bezárása',
    'common.toggle_dark_mode' => 'Sötét mód váltása',
    'common.switch_to_dark' => 'Váltás sötét módra',
    'common.switch_to_light' => 'Váltás világos módra',
    'common.required' => 'kötelező',
    'common.back' => 'Vissza',
    'common.read_more' => 'Tovább olvasom',
    'common.visit' => ':target felkeresése',
    'common.opens_new_tab' => 'új lapon nyílik meg',
    'common.author_meta_prefix' => 'Szerző',

    // Navigáció
    'nav.home' => 'Kezdőlap',
    'nav.blog' => 'Blog',
    'nav.about' => 'Életrajz',
    'nav.nephrology' => 'Nefrológia',
    'nav.projects' => 'Projektek',
    'nav.books' => 'Könyvek',
    'nav.links' => 'Hivatkozások',
    'nav.contact' => 'Kapcsolat',
    'nav.admin' => 'Adminisztráció',
    'nav.logout' => 'Kijelentkezés',
    'nav.login' => 'Bejelentkezés',

    // Lábléc
    'footer.heading' => 'Lépjünk kapcsolatba',
    'footer.linkedin' => 'LinkedIn-profil',
    'footer.x' => 'X-profil',
    'footer.facebook' => 'Facebook-profil',
    'footer.email' => 'E-mail küldése',
    'footer.patreon' => 'Támogatás a Patreonon',
    'footer.discord' => 'Csatlakozás a Discordon',
    'footer.copyright' => '© 1998 – :year Ľubomír Polaščín. Minden jog fenntartva.',
    'footer.privacy' => 'Adatvédelem',
    'footer.terms' => 'Felhasználási feltételek',
    'footer.cookie_settings' => 'Sütibeállítások',

    // Oldalak metaadatai
    'meta.keywords' => 'Ľubomír Polaščín, nefrológia, belgyógyászat, dialízis, orvosi fordítás, programozás',
    'meta.default_description' => 'Nefrológus és belgyógyász személyes és szakmai honlapja: dialízis, szakmai oktatás, orvosi szakszövegírás, fordítás és az egészségügy digitális technológiái.',
    'meta.home_tagline' => 'Nefrológia, dialízis és orvosi technológiák',
    'meta.articles_title' => 'Cikkek',
    'meta.articles_description' => 'Dr. Ľubomír Polaščín legújabb cikkei és gondolatai a nefrológiáról, a belgyógyászatról, a technológiáról és az írásról.',
    'meta.articles_404_title' => 'A cikkoldal nem található',
    'meta.articles_404_description' => 'A kért cikklista-oldal nem létezik.',
    'meta.article_404_title' => 'Nem található',
    'meta.article_404_description' => 'A cikk nem található.',
    'meta.contact_title' => 'Kapcsolat',
    'meta.contact_description' => 'Vegye fel a kapcsolatot Dr. Ľubomír Polaščínnal szakmai kérdésekkel, együttműködési javaslatokkal vagy érdeklődéssel.',
    'meta.newsletter_title' => 'Hírlevél',
    'meta.newsletter_description' => 'Iratkozzon fel a Polascin.net hírlevelére — újdonságok a nefrológiáról, a belgyógyászatról, könyvekről és a technológiáról.',
    'meta.login_title' => 'Bejelentkezés',
    'meta.login_description' => 'Adminisztrátori bejelentkezés a Polascin.net oldalon.',
    'meta.privacy_title' => 'Adatvédelem',
    'meta.privacy_description' => 'Dr. Ľubomír Polaščín webhelyének adatvédelmi tájékoztatója.',
    'meta.terms_title' => 'Felhasználási feltételek',
    'meta.terms_description' => 'Dr. Ľubomír Polaščín webhelyének felhasználási feltételei.',

    // Kezdőlap — fejrész
    'home.logo_alt' => 'Crystal Kidney',
    'home.hero_eyebrow' => 'Crystal Kidney',
    'home.hero_title' => 'Pontos nefrológia. Emberséges ellátás. Értelmes technológia.',
    'home.hero_subtitle' => 'Nefrológus és belgyógyász vagyok, sokéves gyakorlattal a dialízis és a vesebetegségek kezelése terén. A klinikai tapasztalatot szakmai írással, oktatással és orvosi célú digitális megoldások fejlesztésével kapcsolom össze.',
    'home.cta_about' => 'Rólam',
    'home.cta_articles' => 'Legújabb cikkek',

    // Kezdőlap — életrajz
    'home.about_heading' => 'Rólam',
    'home.about_intro' => 'Orvos vagyok, nefrológiai és belgyógyászati szakvizsgával. Szakmai életem nagy részében vesebetegségekkel, dialízissel és olyan betegek ellátásával foglalkozom, akiknek a kezelése nemcsak szakmai pontosságot kíván, hanem bizalmat, érthető tájékoztatást és az egyéni igények tiszteletben tartását is.',
    'home.about_who' => 'A klinikai munka mellett szakmai és szépirodalmi szövegeket írok, orvosi szakfordítással foglalkozom, valamint weboldalakat és alkalmazásokat készítek. A programozást és a mesterséges intelligenciát nem öncélú újdonságnak tartom. Számomra ezek gyakorlati eszközök, amelyek hozzáférhetővé tehetik a tudást, egyszerűsíthetik a munkát, és támogathatják a jobb orvosi döntéshozatalt.',
    'home.about_synthesis' => 'Az orvoslás, a nyelv és a technológia számomra nem különálló területek. Ugyanaz a kérdés köti össze őket: hogyan érthetünk meg egy összetett problémát, és hogyan hozhatunk létre olyan megoldást, amely pontos, érthető és valóban használható.',

    'home.areas_heading' => 'Tevékenységi területek',
    'home.areas_medicine' => 'Orvoslás',
    'home.areas_medicine_1' => 'nefrológia és dialízis',
    'home.areas_medicine_2' => 'belgyógyászat',
    'home.areas_medicine_3' => 'vesepótló kezelés',
    'home.areas_medicine_4' => 'ultrahangdiagnosztika és az érbemenetek gondozása',
    'home.areas_medicine_5' => 'szakmai konzultáció és oktatás',
    'home.areas_language' => 'Nyelv és szerzői tevékenység',
    'home.areas_language_1' => 'orvosi szakszövegek',
    'home.areas_language_2' => 'orvosi szakfordítás és terminológiai munka',
    'home.areas_language_3' => 'orvosi szoftverek lokalizációja',
    'home.areas_language_4' => 'szépirodalom, esszék és tényirodalom',
    'home.areas_language_5' => 'az orvostudomány népszerűsítése és betegoktatás',
    'home.areas_tech' => 'Technológia',
    'home.areas_tech_1' => 'weboldalak és alkalmazások fejlesztése',
    'home.areas_tech_2' => 'orvosi kalkulátorok és digitális eszközök',
    'home.areas_tech_3' => 'az információfeldolgozás automatizálása',
    'home.areas_tech_4' => 'mesterséges intelligencia az orvoslásban',
    'home.areas_tech_5' => 'nyílt forráskódú szoftverek és Linux/Unix rendszerek',

    'home.skills_heading' => 'Technológiai ismeretek',
    'home.skills_web' => 'Webtechnológiák',
    'home.skills_web_text' => 'HTML5, CSS3, JavaScript, TypeScript, PHP',
    'home.skills_data' => 'Adatok és programozás',
    'home.skills_data_text' => 'SQL, Python, adatbázisrendszerek, adatfeldolgozás',
    'home.skills_systems' => 'Rendszerek és infrastruktúra',
    'home.skills_systems_text' => 'Linux, Unix, szabad és nyílt forráskódú szoftverek',
    'home.skills_ai' => 'Mesterséges intelligencia',
    'home.skills_ai_text' => 'generatív mesterséges intelligencia, automatizálás, nyelvi modellek és gyakorlati alkalmazásuk az orvoslásban',

    'home.education_heading' => 'Tanulmányok és szakmai pálya',
    'home.education_text' => 'Általános orvosi diplomámat a kassai Pavol Jozef Šafárik Egyetemen szereztem. A belgyógyászatban töltött kezdeti évek után fokozatosan a nefrológia, a dialízis és az eliminációs eljárások felé fordultam.',
    'home.education_path' => 'A nefrológiához az vezetett, hogy a klinikai orvoslás természetesen összekapcsolódik azzal a technikával, amely közvetlenül befolyásolhatja a beteg egészségi állapotát és életminőségét. 1995 óta foglalkozom dialíziskezeléssel és vesebetegségekkel. 2013 és 2022 között két pozsonyi dialízisközpontot vezettem.',
    'home.education_scope' => 'Szakmai tapasztalatom kiterjed a hemodialízisre, a hemodiafiltrációra, a peritoneális dialízisre, az akut eliminációs módszerekre, az ultrahangdiagnosztikára, az érbemenetek gondozására és a betegek veseátültetésre való előkészítésére. A klinikai gyakorlatot szakmai írással, előadásokkal, oktatással és orvosi digitális projektek készítésével egészítem ki.',

    'home.personal_heading' => 'Személyes nézőpont',
    'home.personal_text' => 'Az olvasás, az utazás, a filozófia, a spiritualitás és a költészet segít abban, hogy az orvoslást tágabb emberi összefüggésben lássam. Érdekelnek a történetek, a nyelv, a tudat és azok a kérdések, amelyek túlmutatnak egyetlen szakterület határain.',
    'home.personal_writing' => 'Írásaimban leginkább az orvosláshoz, az emberi léthez, az erkölcsi konfliktusokhoz és az ember technológiához fűződő viszonyához térek vissza. Itt is ugyanazt keresem, mint az orvoslásban: a pontosságot, az igazságot és az ember mélyebb megértését.',

    'home.identity_nephrologist' => 'Nefrológus',
    'home.identity_internist' => 'Belgyógyász',

    'home.books_cta' => 'Könyvek és szerzői tevékenység',
    'home.amazon_cta' => 'Szerzői profil az Amazonon',

    // Kezdőlap — nefrológia
    'home.nephrology_heading' => 'Nefrológia',
    'home.nephrology_intro' => 'A nefrológia kulcsfontosságú orvosi szakterület, amely a vesékkel foglalkozik — azokkal a létfontosságú szervekkel, amelyek a folyadékegyensúlyért, a salakanyagok kiszűréséért és a vérnyomás szabályozásáért felelnek.',
    'home.ckd_title' => 'Krónikus vesebetegség (CKD)',
    'home.ckd_text' => 'A vesefunkció cukorbetegség, magas vérnyomás vagy más tényezők okozta fokozatos elvesztésének kezelése.',
    'home.aki_title' => 'Akut vesekárosodás (AKI)',
    'home.aki_text' => 'A fertőzés, kiszáradás vagy toxinok okozta hirtelen, gyakran átmeneti vesefunkció-kiesés kezelése.',
    'home.hemodialysis_title' => 'Hemodialízis',
    'home.hemodialysis_text' => 'Eljárás, amelyben dialízisgép és egy művesének nevezett különleges szűrő tisztítja a vért.',
    'home.peritoneal_title' => 'Peritoneális dialízis',
    'home.peritoneal_text' => 'Olyan kezelés, amely a hasüreg hártyáját és a dializátumnak nevezett tisztítóoldatot használja a vér tisztítására.',
    'home.transplant_title' => 'Transzplantáció',
    'home.transplant_text' => 'A veseelégtelenség legjobb kezelése. Egészséges vesét ültetnek a szervezetbe, hogy elvégezze azt a munkát, amelyre a beteg saját veséi már nem képesek.',
    'home.diagnostics_title' => 'Diagnosztika',
    'home.diagnostics_text' => 'Ultrahang, vesebiopszia és korszerű laborvizsgálatok alkalmazása a vesebetegségek pontos felismerésére.',

    // Kezdőlap — cikkek, projektek, hivatkozások, kapcsolat
    'home.latest_heading' => 'Legújabb cikkek',
    'home.all_articles' => 'Összes cikk megtekintése',
    'home.projects_heading' => 'Projektek és kapcsolatok',
    'home.projects_intro' => 'Válogatás azokból a webhelyekből, eszközökből és forrásokból, amelyeket az orvoslás, az oktatás és a technológia területén építek vagy üzemeltetek.',
    'home.project_nefro_text' => 'Szlovák nefrológiai portál klinikai cikkekkel, dialízissel és transzplantációval kapcsolatos hírekkel, kalkulátorokkal, gyógyszer-referenciákkal és tanulmányi jegyzetekkel.',
    'home.project_nephrosite_text' => 'Oktatási előadások és referenciaoldalak a nefrológiáról, a dialízisről, a vértisztítási módszerekről és a belgyógyászatról (szlovák nyelven).',
    'home.project_books_text' => 'Dr. Ľubomír Polaščín könyveinek, tudományos publikációinak, fejezeteinek és irodalmi műveinek központi archívuma.',
    'home.project_alphagrab_text' => 'Kísérleti jegyfelfedező projekt, amely a Ticketmaster Discovery API-n keresztül gazdagítja a tartalék hivatkozásokat.',
    'home.project_arenibus_text' => 'Egy eseményekről és közlekedésről szóló webes projekt nyilvános bemutatópéldánya.',
    'home.links_heading' => 'Kapcsolatok és források',
    'home.links_intro' => 'Fedezzen fel további kapcsolódó oldalakat és forrásokat.',
    'home.link_nephrosite' => 'NephroSite (szlovák nyelven)',
    'home.link_vital_2nd' => 'Vital Algorithm — 2. kiadás (Amazon)',
    'home.link_vital_1st' => 'The Vital Algorithm — 1. kiadás (Amazon)',
    'home.contact_heading' => 'Kapcsolat',
    'home.contact_intro' => 'Forduljon hozzám bizalommal kérdéseivel vagy együttműködési javaslataival.',
    'home.contact_cta' => 'Üzenet küldése',

    // Cikklista
    'articles.heading' => 'Cikkek',
    'articles.aria_label' => 'Cikkek',
    'articles.empty' => 'Még nem jelent meg egyetlen cikk sem.',
    'articles.page_missing' => 'A kért oldal nem létezik.',
    'articles.go_first_page' => 'Ugrás a cikkek első oldalára',
    'articles.pagination_label' => 'Cikkek lapozása',
    'articles.no_translation' => 'Ez a cikk a választott nyelven még nem érhető el. Az eredeti változatot mutatjuk.',

    // Cikk részletei
    'article.aria_label' => 'A cikk tartalma',
    'article.not_found_aria' => 'A cikk nem található',
    'article.not_found_heading' => 'A cikk nem található',
    'article.not_found_text' => 'A kért cikk nem létezik, vagy még nem jelent meg.',
    'article.back_to_list' => 'Vissza a cikkekhez',
    'article.admin_preview' => 'Adminisztrátori előnézet — ez a cikk még nem nyilvános.',
    'article.available_in' => 'Elérhető még ezeken a nyelveken:',

    // Kapcsolatfelvételi űrlap
    'contact.heading' => 'Kapcsolat',
    'contact.aria_label' => 'Kapcsolatfelvételi űrlap',
    'contact.name' => 'Név',
    'contact.email' => 'E-mail',
    'contact.subject' => 'Tárgy',
    'contact.message' => 'Üzenet',
    'contact.submit' => 'Üzenet küldése',
    'contact.success' => 'Köszönöm az üzenetét. Amint tudok, válaszolok.',
    'contact.error_name' => 'Adjon meg érvényes nevet.',
    'contact.error_email' => 'Adjon meg érvényes e-mail-címet.',
    'contact.error_subject' => 'A tárgy túl hosszú.',
    'contact.error_message' => 'Írjon üzenetet (legfeljebb 5000 karakter).',
    'contact.error_rate_limit' => 'Túl sok üzenet érkezett erről a címről. Próbálja meg később.',
    'contact.error_save' => 'Az üzenetet nem sikerült elküldeni. Próbálja meg később.',

    // Hírlevél
    'newsletter.heading' => 'Hírlevél',
    'newsletter.aria_label' => 'Feliratkozás a hírlevélre',
    'newsletter.intro' => 'Iratkozzon fel a cikkekről, könyvekről és projektekről szóló újdonságokért.',
    'newsletter.email' => 'E-mail-cím',
    'newsletter.subscribe' => 'Feliratkozás',
    'newsletter.confirm_unsubscribe' => 'Leiratkozás megerősítése',
    'newsletter.unsubscribe_prompt' => 'Erősítse meg, hogy le kíván iratkozni a hírlevélről.',
    'newsletter.unsubscribe_link_invalid' => 'A leiratkozási hivatkozás érvénytelen.',
    'newsletter.unsubscribe_link_used' => 'A leiratkozási hivatkozás érvénytelen, vagy már felhasználták.',
    'newsletter.unsubscribed' => 'Sikeresen leiratkozott.',
    'newsletter.confirm_link_used' => 'A megerősítő hivatkozás érvénytelen, vagy már felhasználták.',
    'newsletter.confirmed' => 'A feliratkozását megerősítettük. Köszönöm!',
    'newsletter.pending' => 'Ha ez a cím feliratkoztatható, elküldtük rá a további tudnivalókat.',
    'newsletter.rate_limit_confirm' => 'Túl sok megerősítési kísérlet. Próbálja meg később.',
    'newsletter.rate_limit_unsubscribe' => 'Túl sok leiratkozási kísérlet. Próbálja meg később.',
    'newsletter.rate_limit_subscribe' => 'Túl sok kísérlet. Próbálja meg később.',
    'newsletter.error_email' => 'Adjon meg érvényes e-mail-címet.',
    'newsletter.error_generic' => 'Hiba történt. Próbálja meg később.',
    'newsletter.error_mail_failed' => 'A megerősítő e-mailt nem sikerült elküldeni. Próbálja meg később.',
    'newsletter.error_domain' => 'Az e-mail-cím tartománya érvénytelennek tűnik.',
    'newsletter.error_action' => 'Érvénytelen űrlapművelet.',
    'newsletter.unsubscribe_hint' => 'A leiratkozási hivatkozást e-mailben elküldtük. Minden esetre most is elmentheti:',
    'newsletter.unsubscribe_hint_link' => 'leiratkozás a hírlevélről',
    'newsletter.mail_confirm_subject' => 'Erősítse meg a Polascin.net feliratkozását',
    'newsletter.mail_confirm_body' => "Köszönöm, hogy érdeklődik a Polascin.net hírlevele iránt.\n\nErősítse meg a feliratkozását a hivatkozásra kattintva (48 óráig érvényes):\n:url\n\nHa nem Ön kérte a feliratkozást, hagyja figyelmen kívül ezt az üzenetet.",
    'newsletter.mail_welcome_subject' => 'A Polascin.net feliratkozás megerősítve',
    'newsletter.mail_welcome_body' => "A Polascin.net hírlevelére való feliratkozását megerősítettük.\n\nLeiratkozás:\n:url\n\nHa nem Ön iratkozott fel, használja a leiratkozási hivatkozást.",

    // Bejelentkezés
    'login.heading' => 'Adminisztrátori bejelentkezés',
    'login.aria_label' => 'Bejelentkezés',
    'login.username' => 'Felhasználónév',
    'login.password' => 'Jelszó',
    'login.submit' => 'Bejelentkezés',
    'login.error_credentials' => 'Érvénytelen felhasználónév vagy jelszó.',
    'login.error_rate_limit' => 'Túl sok bejelentkezési kísérlet. Próbálja meg később.',
    'login.session_expired' => 'A munkamenet inaktivitás miatt lejárt. Jelentkezzen be újra.',
    'login.account_inactive' => 'A fiókja már nem aktív. Jelentkezzen be újra.',

    // Kijelentkezés (az üzenetek a nyilvános oldalon jelennek meg)
    'logout.success' => 'Kijelentkezett.',
    'logout.csrf_failed' => 'A kijelentkezést nem sikerült ellenőrizni. Próbálja meg újra.',

    // Közös hibaüzenetek
    'error.csrf' => 'Érvénytelen biztonsági token. Frissítse az oldalt, és próbálja meg újra.',

    // Sütik (a JavaScriptnek átadva)
    'cookie.title' => 'Analitikai sütik',
    'cookie.description' => 'Az Ön hozzájárulásával a Google Analytics 4 szolgáltatást használjuk a látogatottság mérésére. A hirdetési tárolás és a személyre szabás kikapcsolva marad. Az elutasítás nem korlátozza az oldal használatát. A részleteket itt találja:',
    'cookie.privacy_link' => 'adatvédelmi tájékoztató',
    'cookie.decline' => 'Elutasítom',
    'cookie.accept' => 'Elfogadom',

    // Adatvédelem
    'privacy.heading' => 'Adatvédelem',
    'privacy.updated' => 'Utolsó frissítés: 2026. július 28.',
    'privacy.s1_heading' => '1. Bevezetés',
    'privacy.s1_text' => 'Üdvözlöm a <strong>polascin.net</strong> oldalon. Tiszteletben tartom a magánszféráját, és elkötelezett vagyok a személyes adatai védelme mellett. Ez az adatvédelmi tájékoztató elmagyarázza, hogyan kezelem a személyes adatait a webhely látogatásakor, és ismerteti az adatvédelmi jogait, valamint a vonatkozó jogi védelmet.',
    'privacy.s2_heading' => '2. Az általam gyűjtött adatok',
    'privacy.s2_text' => 'Ez a webhely elsősorban tájékoztató jellegű. Nem kérem, hogy fiókot hozzon létre.',
    'privacy.s2_technical' => '<strong>Technikai adatok:</strong> Ide tartozik az internetprotokoll-cím (IP), a böngésző típusa, a meglátogatott cím, a kérés időpontja és a válasz alapadatai. Ezeket az adatokat biztonsági, diagnosztikai célokra és az űrlapok visszaélés elleni védelmére használom. A hivatkozások érzékeny paramétereit mentés előtt eltávolítom.',
    'privacy.s2_contact' => '<strong>Kapcsolatfelvételi űrlap:</strong> Ha üzenetet küld, elmentem a nevet, az e-mail-címet, a tárgyat, az üzenet szövegét és a küldés időpontját, hogy válaszolni tudjak rá.',
    'privacy.s2_newsletter' => '<strong>Hírlevél:</strong> Feliratkozáskor elmentem az e-mail-címet, a feliratkozás időpontját és a megerősítéshez, illetve leiratkozáshoz szükséges tokenek kriptográfiai lenyomatát.',
    'privacy.s2_cookies' => '<strong>Sütik és helyi tárolás:</strong> Helyben kizárólag a témabeállítást (sötét/világos mód), a választott nyelvet és az analitikára vonatkozó döntését tárolom. <strong>Google Analytics 4 (GA4):</strong> Az analitikai szkript addig nem töltődik be, amíg kifejezetten rá nem kattint a hozzájárulási sávon az Elfogadom gombra. A hirdetési hozzájárulási kategóriák kikapcsolva maradnak. Döntését bármikor módosíthatja a lábléc Sütibeállítások menüpontjában.',
    'privacy.s3_heading' => '3. Hogyan használom fel az adatait',
    'privacy.s3_text' => 'Az adatait a következőkre használom:',
    'privacy.s3_item1' => 'A webhely tartalmának megjelenítése.',
    'privacy.s3_item2' => 'A webhely biztonságának fenntartása.',
    'privacy.s3_item3' => 'A témabeállítás, a nyelv és az analitikai döntés megjegyzése.',
    'privacy.s3_item4' => 'A kapcsolatfelvételi üzenetek feldolgozása és a hírlevél-feliratkozás kezelése az Ön kérésére.',
    'privacy.s3_item5' => 'A látogatottság és a használati szokások elemzése a Google Analytics 4 segítségével, de kizárólag akkor, ha rákattint a süti-hozzájárulási sáv <strong>Elfogadom</strong> gombjára. Jogalap: az Ön hozzájárulása (GDPR 6. cikk (1) bekezdés a) pont). Az analitikai adatokat a Google a saját megőrzési szabályai szerint tárolja (általában legfeljebb 14 hónapig). Hozzájárulását bármikor visszavonhatja a lábléc <strong>Sütibeállítások</strong> gombjával, az <strong>Elutasítom</strong> lehetőséget választva.',
    'privacy.s4_heading' => '4. Megőrzési idő',
    'privacy.s4_text' => 'A saját technikai hozzáférési naplók alapértelmezés szerint 90 nap után automatikusan törlődnek; az üzemeltető ezt az időszakot lerövidítheti. Az űrlapvédelem rövid életű bejegyzései a védelmi időablak lejárta után folyamatosan törlődnek. A kapcsolatfelvételi üzeneteket csak a levelezés lebonyolításához szükséges ideig őrzöm meg. A hírlevél e-mail-címét a leiratkozásig tárolom.',
    'privacy.s5_heading' => '5. Harmadik felek hivatkozásai',
    'privacy.s5_text' => 'A webhely tartalmazhat harmadik felek webhelyeire, beépülő moduljaira és alkalmazásaira mutató hivatkozásokat (például Amazon vagy közösségi oldalak). Az ilyen hivatkozásokra kattintva harmadik felek adatokat gyűjthetnek Önről vagy oszthatnak meg Önről. Ezekre a webhelyekre nincs befolyásom, és nem vállalok felelősséget az adatvédelmi nyilatkozataikért.',
    'privacy.s6_heading' => '6. Az Ön jogai (GDPR/CCPA)',
    'privacy.s6_text' => 'Bizonyos körülmények között az adatvédelmi jogszabályok alapján jogok illetik meg a személyes adataival kapcsolatban, ideértve a hozzáférés, a helyesbítés, a törlés, illetve az adatkezelés korlátozásának kérését.',
    'privacy.s7_heading' => '7. Kapcsolat',
    'privacy.s7_text' => 'Ha bármilyen kérdése van ezzel az adatvédelmi tájékoztatóval kapcsolatban, keressen az alábbi címen:',

    // Felhasználási feltételek
    'terms.heading' => 'Felhasználási feltételek',
    'terms.updated' => 'Utolsó frissítés: 2026. július 28.',
    'terms.s1_heading' => '1. A feltételek elfogadása',
    'terms.s1_text' => 'A <strong>polascin.net</strong> webhely (a továbbiakban: „Webhely”) elérésével és használatával elfogadja a jelen megállapodás feltételeit és rendelkezéseit, és vállalja, hogy azok kötik.',
    'terms.s2_heading' => '2. Orvosi felelősségkizárás',
    'terms.s2_important' => '<strong>FONTOS:</strong> A webhelyen közzétett tartalom kizárólag tájékoztató jellegű. <strong>Nem helyettesíti</strong> a szakszerű orvosi tanácsadást, diagnózist vagy kezelést.',
    'terms.s2_text' => 'Egészségi állapotával kapcsolatos bármely kérdés esetén mindig kérje ki kezelőorvosa vagy más képzett egészségügyi szakember véleményét. Soha ne hagyja figyelmen kívül a szakszerű orvosi tanácsot, és ne halogassa az orvoshoz fordulást a webhelyen olvasottak miatt.',
    'terms.s3_heading' => '3. Szellemi tulajdon',
    'terms.s3_text' => 'A webhelyhez kapcsolódó tartalom, szerkezet, grafika, formatervezés, összeállítás és egyéb elemek a vonatkozó szerzői jogi és szellemi tulajdonjogi szabályok védelme alatt állnak. Ezen elemek vagy a webhely bármely részének felhasználók általi másolása, továbbterjesztése, felhasználása vagy közzététele szigorúan tilos.',
    'terms.s4_heading' => '4. A felelősség korlátozása',
    'terms.s4_text' => 'Semmilyen esetben nem vállalok felelősséget semmilyen járulékos, közvetett, következményes vagy különleges kárért, sem bármely más kárért, ideértve többek között az elmaradt haszonból, a szerződések elvesztéséből, a jó hírnév, az adatok, az információk, a bevétel, a várt megtakarítások vagy az üzleti kapcsolatok sérelméből eredő károkat, függetlenül attól, hogy figyelmeztettek-e az ilyen károk lehetőségére, amelyek a webhely vagy a róla hivatkozott bármely webhely használatából erednek vagy azzal összefüggésben merülnek fel.',
    'terms.s5_heading' => '5. Irányadó jog',
    'terms.s5_text' => 'A jelen feltételekre a Szlovák Köztársaság joga az irányadó, és azokat annak megfelelően kell értelmezni; Ön visszavonhatatlanul aláveti magát bíróságainak kizárólagos joghatóságának.',

    // Adminisztráció
    'admin.language' => 'Nyelv',
    'admin.language_hint' => 'Az a nyelv, amelyen a tartalom íródott.',
    'admin.translation_group' => 'Fordítási csoport',
    'admin.translation_group_hint' => 'Ugyanaz a szám kapcsolja össze ugyanannak a cikknek a fordításait a nyelvek között. Üres mező új csoportot hoz létre.',
];
