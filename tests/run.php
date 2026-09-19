<?php

declare(strict_types=1);

require_once dirname(__DIR__) . '/auth.php';

$failures = [];
$assertions = 0;

function expectTrue(bool $condition, string $message): void {
    global $assertions, $failures;
    $assertions++;
    if (!$condition) {
        $failures[] = $message;
    }
}

function expectSame(mixed $expected, mixed $actual, string $message): void {
    expectTrue(
        $expected === $actual,
        $message . ' (očakávané: ' . var_export($expected, true) . ', získané: ' . var_export($actual, true) . ')'
    );
}

expectSame(7, appTextLength('Ľubomír'), 'UTF-8 dĺžka musí fungovať aj bez mbstring');
expectSame('Ľub', appTextSlice('Ľubomír', 0, 3), 'UTF-8 skrátenie nesmie rozbiť znak');
expectSame(
    'pokrok-v-zdravi-obliciek',
    slugify('Pokrok v zdraví obličiek'),
    'Slug musí transliterovať slovenskú diakritiku'
);
expectSame(
    'Krátky text',
    buildSeoExcerpt('<p>Krátky&nbsp;text</p>', 50),
    'SEO úryvok musí odstrániť HTML a dekódovať entity'
);
// Jazyk sa uvádza explicitne: bez neho rozhoduje detekcia, ktorá pri neznámom
// jazyku návštevníka vracia angličtinu (Beh #6).
expectSame('28. júla 2026', formatArticleDate('2026-07-28 12:00:00', 'sk'), 'Dátum článku musí používať slovenský názov mesiaca');

$unsafeHtml = <<<'HTML'
<script>alert(1)</script>
<a href="java&#x0A;script:alert(1)" onclick="alert(2)">Nebezpečný odkaz</a>
<img src="data:image/svg+xml;base64,PHN2Zy8+" onerror="alert(3)">
HTML;
$sanitized = sanitizeHtmlContent($unsafeHtml);
expectTrue(!str_contains(strtolower($sanitized), '<script'), 'Sanitizér musí odstrániť script tag');
expectTrue(!str_contains(strtolower($sanitized), 'javascript:'), 'Sanitizér musí odstrániť obfuskovaný javascript URL');
expectTrue(!str_contains(strtolower($sanitized), 'onclick'), 'Sanitizér musí odstrániť event handlery');
expectTrue(!str_contains(strtolower($sanitized), 'data:image'), 'Sanitizér nesmie povoliť data URL obrázky');

$safeHtml = sanitizeHtmlContent('<p class="lead">Text <a href="https://example.com">odkaz</a><img src="/image.jpg"></p>');
expectTrue(str_contains($safeHtml, 'href="https://example.com"'), 'Sanitizér musí zachovať HTTPS odkaz');
expectTrue(str_contains($safeHtml, 'src="/image.jpg"'), 'Sanitizér musí zachovať relatívny obrázok');
expectTrue(str_contains($safeHtml, 'alt=""'), 'Sanitizér musí obrázku doplniť alt');
expectTrue(str_contains($safeHtml, 'loading="lazy"'), 'Sanitizér musí obrázku doplniť lazy loading');

$mutationHtml = '<svg><p><style><img src=x onerror=alert(1)></style></p></svg><p>Bezpečný text</p>';
$mutationSanitized = sanitizeHtmlContent($mutationHtml);
expectTrue(!str_contains(strtolower($mutationSanitized), 'onerror'), 'Sanitizér musí zahodiť aktívny obsah v cudzom namespace');
expectTrue(!str_contains(strtolower($mutationSanitized), '<svg'), 'Sanitizér nesmie zachovať SVG namespace');
expectSame(
    $mutationSanitized,
    sanitizeHtmlContent($mutationSanitized),
    'Sanitizácia musí byť idempotentná a nesmie pri druhom parsovaní vytvoriť nový HTML obsah'
);

expectTrue(ipMatchesCidr('203.0.113.42', '203.0.113.0/24'), 'Dôveryhodný IPv4 CIDR rozsah sa musí rozpoznať');
expectTrue(!ipMatchesCidr('203.0.114.42', '203.0.113.0/24'), 'IPv4 adresa mimo CIDR rozsahu nesmie prejsť');
expectTrue(ipMatchesCidr('2001:db8::42', '2001:db8::/32'), 'Dôveryhodný IPv6 CIDR rozsah sa musí rozpoznať');
expectTrue(!ipMatchesCidr('2001:db9::42', '2001:db8::/32'), 'IPv6 adresa mimo CIDR rozsahu nesmie prejsť');
$originalRemoteAddress = $_SERVER['REMOTE_ADDR'] ?? null;
$_SERVER['REMOTE_ADDR'] = '203.0.113.42';
expectTrue(
    canTrustProxyHeaders(['TRUST_PROXY_HEADERS' => true, 'TRUSTED_PROXY_IPS' => '203.0.113.0/24']),
    'Proxy hlavičky sa smú použiť iba z allowlistovaného vzdialeného rozsahu'
);
expectTrue(
    !canTrustProxyHeaders(['TRUST_PROXY_HEADERS' => true, 'TRUSTED_PROXY_IPS' => '']),
    'Samotné zapnutie proxy hlavičiek bez allowlistu nesmie vytvoriť dôveru'
);
if ($originalRemoteAddress === null) {
    unset($_SERVER['REMOTE_ADDR']);
} else {
    $_SERVER['REMOTE_ADDR'] = $originalRemoteAddress;
}

// Vstupy pre validátor hesiel — nie sú to prihlasovacie údaje k ničomu.
// Názvy sú zvolené tak, aby to bolo zrejmé aj skenerom tajomstiev.
expectTrue(!isAppPasswordValid('Kratke1A'), 'Krátke heslo nesmie prejsť');
expectTrue(isAppPasswordValid('TestovaciVstup1'), 'Silné heslo musí prejsť');

$query = 'action=confirm&token=secret-value&page=2&email=user%40example.com';
$redacted = redactSensitiveQuery($query);
expectTrue(!str_contains($redacted, 'secret-value'), 'Access log nesmie obsahovať token');
expectTrue(!str_contains($redacted, 'user%40example.com'), 'Access log nesmie obsahovať e-mail');
expectTrue(str_contains($redacted, 'page=2'), 'Access log má zachovať necitlivé parametre');
$nestedRedacted = redactSensitiveQuery('page=2;profile%5Btoken%5D=nested-secret');
expectTrue(!str_contains($nestedRedacted, 'nested-secret'), 'Access log musí redigovať aj vnorený token oddelený bodkočiarkou');

// Nepárové </div> vo vstupe nesmie zahodiť zvyšok obsahu (Beh #4).
$strayClose = sanitizeHtmlContent('<p>prvý</p></div><p>druhý</p>');
expectTrue(str_contains($strayClose, 'prvý'), 'Sanitizér musí zachovať obsah pred nepárovým </div>');
expectTrue(str_contains($strayClose, 'druhý'), 'Sanitizér musí zachovať obsah za nepárovým </div>');
expectSame(
    sanitizeHtmlContent('<p>Stratený obsah</p>'),
    sanitizeHtmlContent('</div><p>Stratený obsah</p>'),
    'Úvodné nepárové </div> nesmie zahodiť celý vstup'
);

// Medzery v ceste URL sa musia zachovať, riadiace znaky nie (Beh #4).
expectSame(
    'https://example.com/môj súbor.pdf',
    normalizeSafeContentUrl('https://example.com/môj súbor.pdf', 'href'),
    'Platná URL s medzerou sa nesmie zlepiť'
);
expectSame(null, normalizeSafeContentUrl("java\tscript:alert(1)", 'href'), 'Obfuskovaná javascript URL musí byť odmietnutá');
expectSame(null, normalizeSafeContentUrl('java script:alert(1)', 'href'), 'Javascript URL s medzerou musí byť odmietnutá');
expectSame(null, normalizeSafeContentUrl('data:text/html,<script>', 'src'), 'Data URL v src musí byť odmietnutá');

// Ukotvené validátory nesmú prepustiť koncový nový riadok (Beh #4).
expectSame(0, preg_match('/^[a-z0-9-]{1,255}$/D', "my-post\n"), 'Slug s koncovým newline musí byť odmietnutý');
expectSame(1, preg_match('/^[a-z0-9-]{1,255}$/D', 'my-post'), 'Platný slug musí prejsť');
expectSame(0, preg_match('/^[a-z0-9_\-]+$/D', "hero_title\n"), 'Kľúč bloku s koncovým newline musí byť odmietnutý');
expectSame(0, preg_match('/^[1-9][0-9]{0,8}$/D', "2\n"), 'Číslo stránky s koncovým newline musí byť odmietnuté');

// Fiktívny hash pri neznámom používateľovi musí mať rovnakú cenu ako reálne hashe,
// inak rozdiel v čase overenia prezradí existenciu účtu (Beh #4).
expectTrue(
    !password_needs_rehash(APP_DUMMY_PASSWORD_HASH, PASSWORD_BCRYPT, appPasswordHashOptions()),
    'APP_DUMMY_PASSWORD_HASH musí mať rovnakú cenu ako hashe z hashAppPassword()'
);

$sessionNow = 100000;
expectSame(
    null,
    authenticatedSessionExpiryReason([
        '_last_activity' => $sessionNow - SESSION_IDLE_TIMEOUT + 1,
        '_session_started_at' => $sessionNow - SESSION_ABSOLUTE_TIMEOUT + 1,
    ], $sessionNow),
    'Aktívna relácia pred limitmi nesmie vypršať'
);
expectSame(
    'idle',
    authenticatedSessionExpiryReason([
        '_last_activity' => $sessionNow - SESSION_IDLE_TIMEOUT,
        '_session_started_at' => $sessionNow - 60,
    ], $sessionNow),
    'Relácia musí vypršať presne po dosiahnutí idle limitu'
);
expectSame(
    'absolute',
    authenticatedSessionExpiryReason([
        '_last_activity' => $sessionNow - 60,
        '_session_started_at' => $sessionNow - SESSION_ABSOLUTE_TIMEOUT,
    ], $sessionNow),
    'Aktivita nesmie predĺžiť reláciu za absolútny limit'
);
$fixtureHashA = '$2y$12$aaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaa';
$fixtureHashB = '$2y$12$bbbbbbbbbbbbbbbbbbbbbbbbbbbbbbbbbbbbbbbbbbbbbbbbbbbbb';
expectSame(64, strlen(passwordHashFingerprint($fixtureHashA)), 'Odtlačok hash-u hesla musí byť SHA-256');
expectTrue(
    !hash_equals(passwordHashFingerprint($fixtureHashA), passwordHashFingerprint($fixtureHashB)),
    'Zmena hash-u hesla musí zmeniť odtlačok relácie'
);

// bcrypt odmieta NUL bajt cez \ValueError, nie \InvalidArgumentException.
// Rehash v login.php preto musí chytať \Throwable, inak by úspešné prihlásenie
// skončilo fatálnou chybou (Beh #4).
$nulPasswordError = null;
try {
    hashAppPassword("TestovaciVstup1\0nul");
} catch (\Throwable $e) {
    $nulPasswordError = $e;
}
expectTrue($nulPasswordError instanceof \Throwable, 'Heslo s NUL bajtom musí vyhodiť výnimku');
expectTrue(
    !$nulPasswordError instanceof \InvalidArgumentException,
    'Výnimka pri NUL bajte nie je InvalidArgumentException — catch musí byť širší'
);

// --- Viacjazyčnosť ---

expectSame('sk', normalizeLanguageTag('SK'), 'Jazyková značka sa musí normalizovať na malé písmená');
expectSame('en', normalizeLanguageTag('en-GB'), 'Regionálny variant sa musí zredukovať na základný jazyk');
expectSame('de', normalizeLanguageTag('DE_at'), 'Podčiarkovník musí fungovať ako oddeľovač');
expectSame(null, normalizeLanguageTag('kl'), 'Nepodporovaný jazyk sa nesmie prijať');
expectSame(null, normalizeLanguageTag('../../etc/passwd'), 'Nezmyselný vstup sa nesmie prijať');
expectSame(null, normalizeLanguageTag(''), 'Prázdna značka sa nesmie prijať');

expectSame('de', languageFromAcceptHeader('de-DE,de;q=0.9,en;q=0.8'), 'Accept-Language musí rešpektovať poradie');
expectSame('en', languageFromAcceptHeader('kl;q=1.0,en;q=0.5'), 'Nepodporovaný jazyk s vyššou váhou sa musí preskočiť');
expectSame('fr', languageFromAcceptHeader('en;q=0.3,fr;q=0.9'), 'Rozhodovať musí váha q, nie poradie');
expectSame('cs', languageFromAcceptHeader('cs'), 'Hlavička bez váh musí fungovať');
expectSame(null, languageFromAcceptHeader('en;q=0'), 'Váha q=0 znamená odmietnutie jazyka');
expectSame(null, languageFromAcceptHeader('*'), 'Zástupný znak sám o sebe nič neurčuje');
expectSame(null, languageFromAcceptHeader(null), 'Chýbajúca hlavička nesmie nič vrátiť');

// Návštevník, ktorého jazyk stránka nepozná, dostane angličtinu — nie slovenčinu,
// ktorá je iba zdrojovým jazykom katalógov (Beh #6).
$originalDetectGet = $_GET;
$originalDetectCookie = $_COOKIE;
$originalAcceptLanguage = $_SERVER['HTTP_ACCEPT_LANGUAGE'] ?? null;
$_GET = [];
$_COOKIE = [];
$_SERVER['HTTP_ACCEPT_LANGUAGE'] = 'ja,ko;q=0.8';
expectSame('en', detectAppLanguage(), 'Nepodporovaný jazyk prehliadača musí spadnúť na angličtinu');
unset($_SERVER['HTTP_ACCEPT_LANGUAGE']);
expectSame('en', detectAppLanguage(), 'Chýbajúca hlavička Accept-Language musí spadnúť na angličtinu');
$_SERVER['HTTP_ACCEPT_LANGUAGE'] = 'sk-SK,sk;q=0.9';
expectSame('sk', detectAppLanguage(), 'Podporovaný jazyk prehliadača sa musí zachovať');
$_GET = ['lang' => 'uk'];
expectSame('uk', detectAppLanguage(), 'Explicitná voľba v URL má prednosť');
$_GET = $originalDetectGet;
$_COOKIE = $originalDetectCookie;
if ($originalAcceptLanguage === null) {
    unset($_SERVER['HTTP_ACCEPT_LANGUAGE']);
} else {
    $_SERVER['HTTP_ACCEPT_LANGUAGE'] = $originalAcceptLanguage;
}
expectTrue(isSupportedLanguage(APP_FALLBACK_LANGUAGE), 'Záložný jazyk musí byť medzi podporovanými');

expectSame('sk', languageFromCountryCode('SK'), 'Slovensko sa musí mapovať na slovenčinu');
expectSame('pl', languageFromCountryCode('PL'), 'Poľsko sa musí mapovať na poľštinu');
expectSame('hu', languageFromCountryCode('HU'), 'Maďarsko sa musí mapovať na maďarčinu');
expectSame('it', languageFromCountryCode('IT'), 'Taliansko sa musí mapovať na taliančinu');
expectSame('uk', languageFromCountryCode('UA'), 'Ukrajina sa musí mapovať na ukrajinčinu');
expectSame('es', languageFromCountryCode('mx'), 'Mapovanie krajiny nesmie závisieť od veľkosti písmen');
expectSame(null, languageFromCountryCode('JP'), 'Nepokrytá krajina nesmie nič vrátiť');
expectSame(null, languageFromCountryCode('XX'), 'Neplatný kód krajiny nesmie nič vrátiť');

expectTrue(isSupportedLanguage('sk') && isSupportedLanguage('es'), 'Podporované jazyky musia prejsť');
expectTrue(!isSupportedLanguage('ru'), 'Nepodporovaný jazyk musí byť odmietnutý');

expectSame('Domov', t('nav.home', [], 'sk'), 'Preklad sa musí načítať z katalógu');
expectSame('Home', t('nav.home', [], 'en'), 'Anglický katalóg musí byť použitý');
expectSame('nav.neexistujuci', t('nav.neexistujuci', [], 'en'), 'Chýbajúci kľúč musí vrátiť samotný kľúč');
expectTrue(str_contains(t('common.visit', ['target' => 'example.com'], 'sk'), 'example.com'), 'Zástupný znak sa musí nahradiť');
expectTrue(!str_contains(t('footer.copyright', ['year' => '2026'], 'sk'), ':year'), 'Nenahradený zástupný znak nesmie zostať vo výstupe');

// Katalógy musia byť úplné a konzistentné, inak by na stránke chýbal text.
$skCatalogue = require dirname(__DIR__) . '/lang/sk.php';
foreach (array_keys(appLanguages()) as $catalogueLang) {
    $catalogue = require dirname(__DIR__) . '/lang/' . $catalogueLang . '.php';
    expectSame(
        [],
        array_keys(array_diff_key($skCatalogue, $catalogue)),
        "Katalóg {$catalogueLang} nesmie mať chýbajúce kľúče"
    );
    expectSame(
        [],
        array_keys(array_diff_key($catalogue, $skCatalogue)),
        "Katalóg {$catalogueLang} nesmie mať kľúče navyše"
    );

    // Každý zástupný znak zo slovenčiny musí prežiť aj v preklade.
    $placeholderMismatches = [];
    foreach ($skCatalogue as $key => $value) {
        preg_match_all('/:[a-z_]+/', $value, $skMatches);
        preg_match_all('/:[a-z_]+/', (string) $catalogue[$key], $translatedMatches);
        sort($skMatches[0]);
        sort($translatedMatches[0]);
        if ($skMatches[0] !== $translatedMatches[0]) {
            $placeholderMismatches[] = $key;
        }
    }
    expectSame([], $placeholderMismatches, "Katalóg {$catalogueLang} musí zachovať všetky zástupné znaky");
}

// Katalógy sú text, nie HTML. Väčšina hodnôt sa vypisuje cez te(), ktoré entitu
// zaescapuje, takže by sa zobrazila doslovne („Vzdelanie a&nbsp;kariéra“).
// Typografické znaky sa preto píšu priamo ako UTF-8 (Beh #6).
foreach (array_keys(appLanguages()) as $entityLang) {
    $entityCatalogue = require dirname(__DIR__) . '/lang/' . $entityLang . '.php';
    $withEntities = [];
    foreach ($entityCatalogue as $entityKey => $entityValue) {
        if (preg_match('/&(?:[a-zA-Z][a-zA-Z0-9]*|#\d+|#x[0-9a-fA-F]+);/', (string) $entityValue) === 1) {
            $withEntities[] = $entityKey;
        }
    }
    expectSame([], $withEntities, "Katalóg {$entityLang} nesmie obsahovať HTML entity");
}

// Alt text obrázka je iba názov loga. Slovo „logo“ v ňom čítačka zopakuje
// navyše („obrázok: Logo Crystal Kidney“), preto je hodnota rovnaká vo všetkých
// jazykoch.
foreach (array_keys(appLanguages()) as $altLang) {
    $altCatalogue = require dirname(__DIR__) . '/lang/' . $altLang . '.php';
    expectSame(
        'Crystal Kidney',
        (string) ($altCatalogue['home.logo_alt'] ?? ''),
        "Katalóg {$altLang} musí mať alt text bez slova „logo“"
    );
    expectTrue(
        !array_key_exists('home.hero_eyebrow', $altCatalogue),
        "Katalóg {$altLang} nesmie obsahovať viditeľný popis loga"
    );
}

// Názov Crystal Kidney patrí iba do alt textu obrázka. Samostatný prvok bol
// vizuálne vykreslený verzálkami nad h1, hoci nebol súčasťou obsahu.
$homeTemplate = (string) file_get_contents(dirname(__DIR__) . '/index.php');
$siteStyles = (string) file_get_contents(dirname(__DIR__) . '/css/styles.css');
$staticFallback = (string) file_get_contents(dirname(__DIR__) . '/index.html');
$legacyFallback = (string) file_get_contents(dirname(__DIR__) . '/weblogo/index.html');
$headerTemplate = (string) file_get_contents(dirname(__DIR__) . '/header.php');
expectTrue(!str_contains($homeTemplate, 'home.hero_eyebrow'), 'Domovská šablóna nesmie vypisovať názov loga ako text');
expectTrue(!str_contains($homeTemplate, 'hero-eyebrow'), 'Domovská šablóna nesmie obsahovať prvok hero-eyebrow');
expectTrue(!str_contains($siteStyles, 'hero-eyebrow'), 'CSS nesmie obsahovať nepoužívané štýly hero-eyebrow');
expectTrue(str_contains($staticFallback, 'alt="Crystal Kidney"'), 'Statický fallback musí zachovať alt text loga');
expectTrue(!str_contains($staticFallback, 'alt="Logo Crystal Kidney"'), 'Statický fallback nesmie opakovať slovo logo v alt texte');
expectSame(1, substr_count($staticFallback, 'Crystal Kidney'), 'Statický fallback smie názov loga obsahovať iba v alt texte');
expectTrue(str_contains($legacyFallback, 'alt="Crystal Kidney"'), 'Starší fallback musí zachovať alt text loga');
expectSame(1, substr_count($legacyFallback, 'Crystal Kidney'), 'Starší fallback smie názov loga obsahovať iba v alt texte');

// Štylizovaná fotografia je súčasťou značky v pevnej hlavičke. V odkaze je
// dekoratívna, preto má prázdny alt; zmysel odkazu oznamuje jeho aria-label.
$brandPhotoPath = dirname(__DIR__) . '/pix/lpimg001.webp';
$brandPhotoInfo = is_file($brandPhotoPath) ? getimagesize($brandPhotoPath) : false;
expectTrue(is_file($brandPhotoPath), 'Zdrojová fotografia hlavičky musí existovať');
expectTrue(is_array($brandPhotoInfo), 'Fotografia hlavičky musí byť platný obrázok');
expectSame('image/webp', (string) ($brandPhotoInfo['mime'] ?? ''), 'Fotografia hlavičky musí zostať vo formáte WebP');
expectSame(300, (int) ($brandPhotoInfo[0] ?? 0), 'Fotografia hlavičky musí zachovať pôvodnú šírku');
expectSame(300, (int) ($brandPhotoInfo[1] ?? 0), 'Fotografia hlavičky musí zachovať pôvodnú výšku');
expectSame(1, substr_count($headerTemplate, 'src="pix/lpimg001.webp"'), 'Dynamická hlavička musí obsahovať jednu profilovú fotografiu');
expectTrue(
    preg_match('~<img\s+src="pix/lpimg001\.webp"\s+alt=""\s+class="nav-brand-photo"~', $headerTemplate) === 1
        && str_contains($headerTemplate, 'aria-label="<?= te(\'common.site_name\') ?>"'),
    'Fotografia v dynamickej hlavičke musí byť dekoratívna a odkaz musí mať prístupný názov'
);
foreach (['index.html', 'privacy.html', 'terms.html'] as $staticHeaderFile) {
    $staticHeader = (string) file_get_contents(dirname(__DIR__) . '/' . $staticHeaderFile);
    expectSame(
        1,
        substr_count($staticHeader, 'src="pix/lpimg001.webp"'),
        "{$staticHeaderFile} musí obsahovať jednu profilovú fotografiu v hlavičke"
    );
}

// Dynamické stránky odvodzujú `?v=` z `filemtime()` v `head_meta.php`, statické
// fallbacky ho majú napísaný ručne — a ten sa rozišiel s obsahom (Beh #25):
// `css/styles.css` aj `js/main.js` niesli pin z 2026-07-29, hoci sa medzitým
// zmenili, a `js/consent-default.js` nemal `?v=` vôbec. Fallback sa podáva práve
// pri výpadku databázy, takže vtedy by vracajúci sa návštevník dostal týždne
// starý CSS a JS z vlastnej cache — pri consent skripte s dopadom na GDPR.
// Pin je preto skrátený hash obsahu a drží ho tento test.
foreach (['css/styles.css', 'js/main.js', 'js/consent-default.js'] as $staticAsset) {
    $expectedAssetVersion = substr(hash_file('sha256', dirname(__DIR__) . '/' . $staticAsset), 0, 8);
    foreach (['index.html', 'privacy.html', 'terms.html'] as $staticAssetFile) {
        $staticAssetMarkup = (string) file_get_contents(dirname(__DIR__) . '/' . $staticAssetFile);
        expectTrue(
            str_contains($staticAssetMarkup, $staticAsset . '?v=' . $expectedAssetVersion),
            "{$staticAssetFile} musí odkazovať na {$staticAsset} s aktuálnym cache-busting pinom ?v={$expectedAssetVersion}"
        );
    }
}
expectTrue(
    str_contains($siteStyles, '.nav-brand-photo')
        && str_contains($siteStyles, '.nav-brand-text'),
    'CSS musí obsahovať štýly fotografie a textu značky'
);
expectTrue(
    preg_match('~@media \(max-width: 600px\).*?\.nav-brand-text\s*\{\s*display:\s*none;~s', $siteStyles) === 1,
    'Na úzkych displejoch sa musí skryť iba text značky, nie fotografia'
);
expectTrue(
    preg_match('~@media \(max-width: 1100px\).*?\.nav-menu\s*\{.*?position:\s*fixed;~s', $siteStyles) === 1,
    'Kompaktná navigácia musí zabrániť zalomeniu hlavičky aj tesne nad šírkou tabletu'
);

// Breakpoint mobilnej navigácie musí byť v JavaScripte rovnaký ako v CSS:
// openMobileMenu() má guard na mobileNavigationQuery, takže pri nezhode CSS
// zobrazí hamburger, ale kliknutie menu neotvorí a navigácia je v medzipásme
// šírok úplne nedostupná (regresia z commitu b41d628: CSS 1100px, JS 1024px).
$navigationScript = (string) file_get_contents(dirname(__DIR__) . '/js/main.js');
expectTrue(
    str_contains($navigationScript, 'window.matchMedia("(max-width: 1100px)")'),
    'js/main.js musí prepínať mobilnú navigáciu na rovnakej šírke ako CSS (1100px)'
);
expectTrue(
    !str_contains($navigationScript, '(max-width: 1024px)'),
    'js/main.js nesmie používať starý breakpoint navigácie 1024px'
);
expectTrue(
    str_contains($navigationScript, '"ResizeObserver" in window'),
    'js/main.js musí synchronizovať --navbar-height s nameranou výškou navigácie'
);

// Swatch Internet Time: stotiny sa orezávajú nadol — zaokrúhlenie by na konci
// dňa zobrazilo neplatné @1000.00 (beaty bežia od 0.00 po 999.99).
expectSame('@41.66', appSwatchBeat(0), 'appSwatchBeat musí orezávať stotiny nadol');
expectSame('@999.98', appSwatchBeat(82799), 'Posledná sekunda BMT dňa nesmie byť @1000.00');
expectSame('@0.00', appSwatchBeat(82800), 'Polnoc BMT musí byť @0.00');
expectSame('@999.98', appSwatchBeat(-3601), 'appSwatchBeat musí zvládnuť aj záporný unix čas');
expectTrue(
    str_contains($navigationScript, '/ 864) / 100'),
    'js/main.js musí beat orezávať nadol rovnakou aritmetikou ako appSwatchBeat'
);
expectTrue(
    !str_contains($navigationScript, '/ 86400).toFixed'),
    'js/main.js nesmie beat zaokrúhľovať cez toFixed nad surovou hodnotou'
);
$footerTemplate = (string) file_get_contents(dirname(__DIR__) . '/footer.php');
expectTrue(
    str_contains($headerTemplate, 'appSwatchBeat(') && str_contains($footerTemplate, 'appSwatchBeat('),
    'Hlavička aj pätička musia beat počítať cez spoločný appSwatchBeat'
);

// Vek v hlavičke: title + skrytý popis dávajú číslam kontext (aj pre čítačky)
// a na úzkych obrazovkách sa beat a presný vek skryjú, aby sa lišta zmestila
// do 320 px (prvky majú white-space: nowrap a pretiekli by mimo viewport).
expectTrue(
    str_contains($headerTemplate, '<span class="visually-hidden"><?= te(\'common.age_title\') ?>')
        && str_contains($headerTemplate, 'title="<?= te(\'common.age_title\') ?>"'),
    'Vek v hlavičke musí mať prístupný popis common.age_title'
);
expectTrue(
    preg_match('~@media \(max-width: 480px\)\s*\{\s*\.nav-beat\s*\{\s*display:\s*none;~s', $siteStyles) === 1,
    'Beat v hlavičke sa musí skryť na obrazovkách do 480 px'
);
expectTrue(
    preg_match('~@media \(max-width: 400px\)\s*\{\s*\.nav-age-exact\s*\{\s*display:\s*none;~s', $siteStyles) === 1,
    'Presný vek v hlavičke sa musí skryť na obrazovkách do 400 px'
);

// deploy_info.php je interný súbor: generátory mu musia vkladať guard proti
// priamemu spusteniu, .htaccess ho musí blokovať a smoke check to overuje.
$deployWorkflow = (string) file_get_contents(dirname(__DIR__) . '/.github/workflows/deploy.yml');
$deployScript = (string) file_get_contents(dirname(__DIR__) . '/hooks/deploy.sh');
$htaccessRules = (string) file_get_contents(dirname(__DIR__) . '/.htaccess');
foreach ([['deploy.yml', $deployWorkflow], ['hooks/deploy.sh', $deployScript]] as [$generatorName, $generatorSource]) {
    expectTrue(
        str_contains($generatorSource, "preg_match('~(?:^|/)deploy_info\\.php(?:/|\$)~i'")
            && str_contains($generatorSource, "exit('Prístup odmietnutý.');"),
        "{$generatorName} musí do deploy_info.php vkladať guard proti priamemu spusteniu"
    );
    expectTrue(
        str_contains($generatorSource, "tr -cd 'A-Za-z0-9._/-'"),
        "{$generatorName} musí sanitizovať názov vetvy pred vložením do PHP reťazca"
    );
}
expectTrue(
    preg_match('~<FilesMatch "[^"]*\|deploy_info\|[^"]*"~', $htaccessRules) === 1,
    '.htaccess musí blokovať priamy prístup na deploy_info.php'
);
expectTrue(
    preg_match('~RewriteRule \^\(privacy\|terms\)/\?\$ /\$1\.php \[R=301,L,NE\]~', $htaccessRules) === 1,
    '.htaccess musí 301-presmerovať aliasy /privacy a /terms na .php'
);
expectTrue(
    preg_match('~RewriteRule \^weblogo\(\?:/\.\*\)\?\$ / \[R=301,L,NE\]~', $htaccessRules) === 1,
    '.htaccess musí 301-presmerovať starý weblogo fallback na koreň'
);
expectTrue(
    preg_match('~RewriteRule \^portfolio\(\?:/\.\*\)\?\$ - \[F,L\]~', $htaccessRules) === 1,
    '.htaccess musí zakázať náhodne nasadený adresár portfolio/'
);
expectTrue(
    preg_match('~RewriteRule \^\([^)]*\|content\|[^)]*\)\(/\\.\\*\)\\?\$ - \[F,L\]~', $htaccessRules) === 1,
    '.htaccess musí zakázať priamy prístup na interný adresár content/'
);
expectTrue(
    preg_match('~<FilesMatch "[^"]*\|txt\)\$"~', $htaccessRules) === 1,
    '.htaccess musí blokovať priamy prístup na .txt súbory'
);
expectTrue(
    str_contains($htaccessRules, 'Header always set Cross-Origin-Resource-Policy "same-origin"'),
    '.htaccess musí posielať CORP aj na statické súbory, nielen PHP odpovede'
);
expectTrue(
    str_contains($htaccessRules, '<Files "robots.txt">')
        && str_contains($htaccessRules, 'Require all granted'),
    'robots.txt musí zostať verejne dostupný napriek zákazu .txt'
);
expectTrue(
    str_contains($deployWorkflow, '"/deploy_info.php"'),
    'Smoke check po nasadení musí overiť nedostupnosť deploy_info.php'
);
expectTrue(
    str_contains($deployWorkflow, '"/content/"'),
    'Smoke check po nasadení musí overiť nedostupnosť adresára content/'
);
// Sieťová politika cloudového prostredia nočnej rutiny `polascin.net` blokuje
// (CONNECT → 403), takže hlavičky z nej overiť nemožno. Kontrolu preto robí
// smoke check v deploy workflowe, ktorý na produkciu dosiahne (Beh #24).
foreach (
    [
        'strict-transport-security',
        'x-content-type-options',
        'x-frame-options',
        'referrer-policy',
        'permissions-policy',
        'cross-origin-opener-policy',
        'cross-origin-resource-policy',
        'x-permitted-cross-domain-policies',
        'content-security-policy',
    ] as $smokeHeader
) {
    expectTrue(
        str_contains($deployWorkflow, '"' . $smokeHeader . '"'),
        'Smoke check po nasadení musí overiť hlavičku ' . $smokeHeader
    );
}
expectTrue(
    str_contains($deployWorkflow, 'CSP na produkcii neobsahuje nonce-'),
    'Smoke check po nasadení musí overiť, že CSP na produkcii nesie nonce'
);
// Bod 5 sekcie „Dokončenie“ v `.doaudit.md` vymenúva kľúčové URL; keďže ich
// nočná rutina overiť nemôže, musia byť v smoke checku (Beh #24).
foreach (['"/"', '"/articles.php"', '"/contact.php"', '"/newsletter.php"', '"/sitemap.php"', '"/login.php"', '"/privacy.php"', '"/terms.php"'] as $smokeUrl) {
    expectTrue(
        str_contains($deployWorkflow, $smokeUrl),
        'Smoke check po nasadení musí overiť URL ' . trim($smokeUrl, '"')
    );
}
$robotsTxt = (string) file_get_contents(dirname(__DIR__) . '/robots.txt');
expectTrue(
    str_contains($robotsTxt, 'Disallow: /portfolio/'),
    'robots.txt musí zakazovať crawlovanie adresára portfolio/'
);
expectTrue(
    str_contains($robotsTxt, 'Disallow: /content/'),
    'robots.txt musí zakazovať crawlovanie interného adresára content/'
);

// `robots.txt` vymenúva administrátorské stránky po jednej a zoznam sa pri
// pribudnutí `admin_users.php` (Beh #23) neaktualizoval — všimol si to až
// Beh #25. Indexovaná nebola, lebo `Disallow: /admin` ju pokryl prefixom,
// ale stránka nazvaná inak by takto prepadla bez povšimnutia. Kontrola preto
// nevychádza z názvu súboru, ale z toho, ktoré stránky žiadajú `requireAdmin()`,
// a overuje skutočnú sémantiku robots.txt, teda zhodu prefixu.
// Pravidlá sa berú výhradne zo skupiny `User-agent: *`. Skupiny pre scrapery
// a AI crawlery majú `Disallow: /`, takže zbieranie všetkých riadkov naraz by
// kontrolu urobilo vždy zelenou.
$robotsDisallowedPaths = [];
$robotsInWildcardGroup = false;
foreach (preg_split('~\r?\n~', $robotsTxt) ?: [] as $robotsLine) {
    if (preg_match('~^\s*User-agent:\s*(\S+)~i', $robotsLine, $robotsAgentMatch) === 1) {
        $robotsInWildcardGroup = $robotsAgentMatch[1] === '*';
        continue;
    }
    if ($robotsInWildcardGroup && preg_match('~^\s*Disallow:\s*(\S+)~i', $robotsLine, $robotsMatch) === 1) {
        $robotsDisallowedPaths[] = $robotsMatch[1];
    }
}
expectTrue($robotsDisallowedPaths !== [], 'Skupina User-agent: * v robots.txt musí obsahovať pravidlá Disallow');
$uncoveredAdminPages = [];
foreach (glob(dirname(__DIR__) . '/*.php') ?: [] as $rootPagePath) {
    $rootPageSource = (string) file_get_contents($rootPagePath);
    if (!str_contains($rootPageSource, 'requireAdmin()')) {
        continue;
    }
    $rootPageUrl = '/' . basename($rootPagePath);
    foreach ($robotsDisallowedPaths as $disallowedPath) {
        if (str_starts_with($rootPageUrl, $disallowedPath)) {
            continue 2;
        }
    }
    $uncoveredAdminPages[] = basename($rootPagePath);
}
expectSame(
    [],
    $uncoveredAdminPages,
    'robots.txt musí zakazovať každú stránku, ktorá vyžaduje requireAdmin()'
);
$gitignoreRules = (string) file_get_contents(dirname(__DIR__) . '/.gitignore');
$deployIgnoreRules = (string) file_get_contents(dirname(__DIR__) . '/.deployignore');
expectTrue(
    preg_match('~(^|\r?\n)portfolio/(\r?\n|$)~', $gitignoreRules) === 1,
    '.gitignore musí vylúčiť nested adresár portfolio/'
);
expectTrue(
    preg_match('~(^|\r?\n)portfolio(\r?\n|$)~', $deployIgnoreRules) === 1,
    '.deployignore musí vylúčiť portfolio z nasadenia'
);

// Lokálne konfigurácie editorov a nástrojov nesmú skončiť vo verejnom web roote.
foreach (['.vscode', '.claude', '.trunk', '.cursor', '.idea'] as $localToolDir) {
    expectTrue(
        preg_match('~(^|\r?\n)' . preg_quote($localToolDir, '~') . '(\r?\n|$)~', $deployIgnoreRules) === 1,
        ".deployignore musí vylúčiť {$localToolDir} z nasadenia"
    );
}

// Súbory, ktoré sa kedysi nasadili, musia deploy skripty aj aktívne zmazať —
// rsync --exclude ich na cieli pred --delete chráni, sám ich nezmaže.
$deployShSource = (string) file_get_contents(dirname(__DIR__) . '/hooks/deploy.sh');
foreach (['deploy.yml' => $deployWorkflow, 'hooks/deploy.sh' => $deployShSource] as $cleanupName => $cleanupSource) {
    expectTrue(
        str_contains($cleanupSource, '.cursor/rules/*.mdc'),
        "{$cleanupName} musí zmazať už nasadené .cursor/rules/*.mdc z web rootu"
    );
}

// Prístupnosť: prepínač jazyka (summary) zdieľa fokusový prstenec stránky,
// formulárové polia majú viditeľný prstenec namiesto outline: none a odkazy
// v súvislom texte sú podčiarknuté, nie odlíšené iba farbou (WCAG 1.4.1).
expectTrue(
    str_contains($siteStyles, 'summary:focus-visible'),
    'Prepínač jazyka (summary) musí mať rovnaký fokusový prstenec ako ostatné prvky'
);
expectTrue(
    preg_match('~\.form-group select:focus\s*\{[^}]*outline:\s*3px solid~s', $siteStyles) === 1,
    'Formulárové polia musia mať pri fokuse viditeľný prstenec'
);
expectTrue(
    preg_match('~main p a:not\(\.btn\),\s*\.article-body a\s*\{[^}]*text-decoration:\s*underline~s', $siteStyles) === 1,
    'Odkazy v súvislom texte musia byť podčiarknuté, nie odlíšené len farbou'
);

// Transplantácia môže mať u vhodných pacientov lepšie výsledky než dlhodobá
// dialýza, no nie je univerzálne „najlepšou liečbou“ pre každého.
expectTrue(
    !str_contains((string) $skCatalogue['home.transplant_text'], 'Najlepšia liečba'),
    'Slovenský text o transplantácii nesmie obsahovať absolútne tvrdenie'
);
$enCatalogue = require dirname(__DIR__) . '/lang/en.php';
expectTrue(
    !str_contains(strtolower((string) $enCatalogue['home.transplant_text']), 'best treatment'),
    'Anglický text o transplantácii nesmie obsahovať absolútne tvrdenie'
);
expectTrue(
    !str_contains(strtolower($legacyFallback), 'best treatment'),
    'Starší fallback nesmie obsahovať absolútne tvrdenie o transplantácii'
);

// Arenibus je nefrologický informačný systém, nie dopravný projekt. Portfólio
// odkazuje na jeho oficiálnu projektovú stránku; verejné demo je dostupné až
// odtiaľ spolu s aktuálnymi informáciami o stave vývoja.
foreach (array_keys(appLanguages()) as $arenibusLang) {
    $arenibusCatalogue = require dirname(__DIR__) . '/lang/' . $arenibusLang . '.php';
    $arenibusDescription = (string) ($arenibusCatalogue['home.project_arenibus_text'] ?? '');
    expectTrue(
        str_contains($arenibusDescription, '.NET') && str_contains($arenibusDescription, 'MVP'),
        "Katalóg {$arenibusLang} musí opisovať technológiu a stav Arenibusu"
    );
}
expectSame(
    2,
    substr_count($homeTemplate, 'https://arenibus.polascin.net/'),
    'Dynamická stránka musí odkazovať na oficiálnu stránku Arenibusu'
);
expectTrue(
    !str_contains($homeTemplate, 'https://demo.arenibus.com/')
        && !str_contains($homeTemplate, 'Arenibus Demo')
        && !str_contains($homeTemplate, 'fa-bus'),
    'Dynamická stránka nesmie prezentovať Arenibus ako dopravné demo'
);
expectSame(
    2,
    substr_count($staticFallback, 'https://arenibus.polascin.net/'),
    'Statický fallback musí odkazovať na oficiálnu stránku Arenibusu'
);
expectTrue(
    !str_contains($staticFallback, 'https://demo.arenibus.com/')
        && !str_contains($staticFallback, 'Arenibus Demo')
        && !str_contains($staticFallback, 'podujatiach a doprave')
        && !str_contains($staticFallback, 'fa-bus'),
    'Statický fallback nesmie prezentovať Arenibus ako dopravné demo'
);

// Odkazy na dialyzačné informácie vedú na konkrétnu stránku pracoviska v
// Bratislave a na aktuálny zoznam stredísk IMPAX. Názvy sa prekladajú, cieľové
// slovenské stránky však zostávajú vo všetkých jazykových verziách rovnaké.
$dialysisLinks = [
    'https://nefro.polascin.net/dialyza-bratislava.php',
    'https://www.impax.sk/dialyzacne-strediska/',
];
foreach ($dialysisLinks as $dialysisLink) {
    expectSame(1, substr_count($homeTemplate, $dialysisLink), "Dynamická stránka musí obsahovať odkaz {$dialysisLink}");
    expectSame(1, substr_count($staticFallback, $dialysisLink), "Statický fallback musí obsahovať odkaz {$dialysisLink}");
    expectSame(1, substr_count($legacyFallback, $dialysisLink), "Starší fallback musí obsahovať odkaz {$dialysisLink}");
}
foreach (array_keys(appLanguages()) as $dialysisLinkLang) {
    $dialysisLinkCatalogue = require dirname(__DIR__) . '/lang/' . $dialysisLinkLang . '.php';
    expectTrue(
        !empty($dialysisLinkCatalogue['home.link_dialysis_bratislava'])
            && !empty($dialysisLinkCatalogue['home.link_impax_centres']),
        "Katalóg {$dialysisLinkLang} musí pomenovať oba dialyzačné odkazy"
    );
}

// Profilové bloky môžu byť upravené cez administráciu. Migračný UPDATE preto
// smie nahradiť iba presne známu starú predvolenú hodnotu, nie ľubovoľný obsah
// s rovnakým kľúčom a jazykom.
$setupScript = (string) file_get_contents(dirname(__DIR__) . '/setup_db.php');
expectTrue(
    str_contains($setupScript, "'2026072902_profile_copy'"),
    'Setup musí obsahovať verziovanú migráciu profilových textov'
);
expectTrue(
    str_contains($setupScript, 'AND BINARY content = BINARY :old_content'),
    'Migrácia profilových textov musí chrániť vlastný redakčný obsah binárne presným porovnaním'
);
expectTrue(
    str_contains($setupScript, 'SET content = :new_content'),
    'Migrácia profilových textov musí používať oddelenú novú hodnotu'
);
expectTrue(
    str_contains($setupScript, '$pdo->beginTransaction()')
        && str_contains($setupScript, '$pdo->rollBack()'),
    'Migrácia profilových textov musí byť transakčná'
);

// Katalógy smú obsahovať iba latinku a cyriliku. Zachytáva to znak, ktorý sa do
// prekladu dostane omylom — pri ukrajinčine takto prešli dva čínske znaky (Beh #6).
foreach (array_keys(appLanguages()) as $scriptLang) {
    $scriptCatalogue = require dirname(__DIR__) . '/lang/' . $scriptLang . '.php';
    $foreignScript = [];
    foreach ($scriptCatalogue as $scriptKey => $scriptValue) {
        if (preg_match('~[^\p{Latin}\p{Cyrillic}\p{Common}\p{Inherited}]~u', (string) $scriptValue) === 1) {
            $foreignScript[] = $scriptKey;
        }
    }
    expectSame([], $foreignScript, "Katalóg {$scriptLang} obsahuje znak z cudzieho písma");
}

// Interné súbory nesmú byť spustiteľné priamo cez web. Produkcia beží na
// OpenResty, ktorý `.htaccess` ignoruje, takže guard v PHP je jediná ochrana.
foreach (array_keys(appLanguages()) as $guardedLang) {
    $catalogueSource = (string) file_get_contents(dirname(__DIR__) . '/lang/' . $guardedLang . '.php');
    expectTrue(
        str_contains($catalogueSource, 'http_response_code(403)'),
        "Katalóg {$guardedLang} musí odmietnuť priame spustenie"
    );
}
foreach (['i18n.php', 'lang_switcher.php'] as $guardedFile) {
    $guardedSource = (string) file_get_contents(dirname(__DIR__) . '/' . $guardedFile);
    expectTrue(
        str_contains($guardedSource, 'http_response_code(403)'),
        "{$guardedFile} musí odmietnuť priame spustenie"
    );
}

// Kanonická URL: predvolený jazyk bez parametra, ostatné s ním.
expectSame('https://polascin.net/', absoluteLangUrl('sk', 'index.php'), 'Slovenská domovská stránka má čistú kanonickú URL');
expectSame('https://polascin.net/?lang=en', absoluteLangUrl('en', 'index.php'), 'Cudzojazyčná domovská stránka nesie parameter lang');
expectSame('https://polascin.net/contact.php', absoluteLangUrl('sk', 'contact.php'), 'Slovenská podstránka nemá parameter lang');
expectSame(
    'https://polascin.net/article.php?slug=test&lang=de',
    absoluteLangUrl('de', 'article.php', ['slug' => 'test']),
    'Parametre sa musia skombinovať s jazykom'
);
expectSame('https://polascin.net/', absoluteLangUrl('kl', 'index.php'), 'Nepodporovaný jazyk musí spadnúť na predvolený');

// Prepínač jazyka naopak parameter uvádza vždy, inak by sa nedalo prepnúť späť.
expectSame('index.php?lang=sk', langUrl('sk', 'index.php'), 'Prepínač musí uvádzať jazyk aj pre predvolený jazyk');
expectSame('articles.php?page=2&lang=fr', langUrl('fr', 'articles.php', ['page' => 2]), 'Prepínač musí zachovať parametre stránky');

// Regresia: prepínač postavený na kanonických adresách by pre predvolený jazyk
// neniesol parameter `lang` a návštevník by sa už nikdy nevrátil na slovenčinu.
foreach (array_keys(appLanguages()) as $switcherLang) {
    expectTrue(
        str_contains(langUrl($switcherLang, 'index.php'), 'lang=' . $switcherLang),
        "Cieľ prepínača pre {$switcherLang} musí obsahovať parameter lang"
    );
}

// Regresia: prepínač nesmie zahodiť parametre aktuálnej stránky — na
// newsletter.php by sa tým stratil jednorazový token.
$originalGet = $_GET;
$originalScript = $_SERVER['SCRIPT_NAME'] ?? null;
$_SERVER['SCRIPT_NAME'] = '/newsletter.php';
$_GET = ['action' => 'unsubscribe', 'token' => 'abc123', 'lang' => 'de'];
$switcherHref = langUrl('sk');
expectTrue(str_contains($switcherHref, 'action=unsubscribe'), 'Prepínač musí zachovať parameter action');
expectTrue(str_contains($switcherHref, 'token=abc123'), 'Prepínač musí zachovať jednorazový token');
expectTrue(str_contains($switcherHref, 'lang=sk'), 'Prepínač musí prepísať pôvodný jazyk na cieľový');
expectTrue(!str_contains($switcherHref, 'lang=de'), 'Pôvodný jazyk nesmie v cieli zostať');
$_GET = $originalGet;
if ($originalScript === null) {
    unset($_SERVER['SCRIPT_NAME']);
} else {
    $_SERVER['SCRIPT_NAME'] = $originalScript;
}

// Jazykové varianty (hreflang) sa musia odvodzovať z kanonickej URL, nie zo
// `$_GET` — inak by klaster odkazoval na adresy s inou kanonickou URL (Beh #5).
$homeAlternates = languageAlternatesFor('https://polascin.net/');
expectSame('https://polascin.net/', $homeAlternates['sk'], 'Alternatíva pre predvolený jazyk je čistá adresa');
expectSame('https://polascin.net/?lang=en', $homeAlternates['en'], 'Alternatíva pre cudzí jazyk nesie parameter lang');
expectSame(
    array_keys(appLanguages()),
    array_keys($homeAlternates),
    'Klaster musí obsahovať všetky podporované jazyky v pevnom poradí'
);
expectSame(
    'https://polascin.net/article.php?slug=test&lang=de',
    languageAlternatesFor('https://polascin.net/article.php?slug=test')['de'],
    'Parametre kanonickej URL sa musia preniesť do alternatív'
);
expectSame(
    'https://polascin.net/articles.php?page=2&lang=fr',
    languageAlternatesFor('https://polascin.net/articles.php?page=2')['fr'],
    'Stránkovanie sa musí preniesť do alternatív'
);

// Regresia: `articles.php?page=1` má kanonickú URL bez parametra `page` a
// `articles.php?slug=…` parameter `slug` vôbec nepozná. Zo `$_GET` by sa oba
// dostali do hreflang a rozbili by súlad canonical ↔ hreflang.
$originalGet = $_GET;
$_GET = ['page' => '1', 'slug' => 'nepatri-sem', 'utm_source' => 'newsletter'];
$leakAlternates = languageAlternatesFor('https://polascin.net/articles.php');
expectSame('https://polascin.net/articles.php', $leakAlternates['sk'], 'Parametre zo $_GET nesmú preniknúť do alternatív');
expectSame('https://polascin.net/articles.php?lang=es', $leakAlternates['es'], 'Cudzojazyčná alternatíva nesmie niesť parametre zo $_GET');
$_GET = $originalGet;

// Zástupný jazyk v kanonickej URL sa nesmie zdvojiť.
expectSame(
    'https://polascin.net/contact.php?lang=cs',
    languageAlternatesFor('https://polascin.net/contact.php?lang=de')['cs'],
    'Pôvodný parameter lang v kanonickej URL sa musí nahradiť cieľovým jazykom'
);

// Popisy prepínačov idú do JavaScriptu cez data atribúty; bez nich by stránka
// v cudzom jazyku ohlásila tlačidlá po slovensky (Beh #5).
$jsLabelKeys = ['common.open_navigation', 'common.close_navigation', 'common.switch_to_dark', 'common.switch_to_light'];
foreach (array_keys(appLanguages()) as $labelLang) {
    // Číta sa priamo katalóg, nie `t()`: záloha na predvolený jazyk by chýbajúci
    // preklad zamaskovala slovenským reťazcom.
    $labelCatalogue = require dirname(__DIR__) . '/lang/' . $labelLang . '.php';
    $missingLabels = [];
    foreach ($jsLabelKeys as $labelKey) {
        if (!isset($labelCatalogue[$labelKey]) || trim((string) $labelCatalogue[$labelKey]) === '') {
            $missingLabels[] = $labelKey;
        }
    }
    expectSame([], $missingLabels, "Katalóg {$labelLang} musí mať preložené popisy prepínačov");
}
$headerSource = (string) file_get_contents(dirname(__DIR__) . '/header.php');
foreach (['data-label-open', 'data-label-close', 'data-label-dark', 'data-label-light'] as $dataAttribute) {
    expectTrue(
        str_contains($headerSource, $dataAttribute),
        "header.php musí posielať do JavaScriptu atribút {$dataAttribute}"
    );
}
$mainJsSource = (string) file_get_contents(dirname(__DIR__) . '/js/main.js');
foreach (['labelOpen', 'labelClose', 'labelDark', 'labelLight'] as $datasetKey) {
    expectTrue(
        str_contains($mainJsSource, $datasetKey),
        "js/main.js musí čítať preložený popis {$datasetKey}"
    );
}

// Miesta, kde sa preklad zámerne vypisuje bez escapovania. Hodnoty musia zostať
// redakčnými reťazcami s bezpečnou značkou, inak by sa z katalógu stal XSS vektor.
$unescapedKeys = [
    'privacy.s1_text',
    'privacy.s2_technical',
    'privacy.s2_contact',
    'privacy.s2_newsletter',
    'privacy.s2_cookies',
    'privacy.s3_item5',
    'terms.s1_text',
    'terms.s2_important',
];
$foundUnescaped = [];
foreach ((array) glob(dirname(__DIR__) . '/*.php') as $templateFile) {
    if (preg_match_all('/<\?=\s*t\(\s*[\'"]([^\'"]+)[\'"]/', (string) file_get_contents((string) $templateFile), $matches) > 0) {
        foreach ($matches[1] as $unescapedKey) {
            $foundUnescaped[$unescapedKey] = true;
        }
    }
}
expectSame(
    [],
    array_keys(array_diff_key($foundUnescaped, array_flip($unescapedKeys))),
    'Nový neescapovaný t() musí prejsť revíziou a doplniť sa do zoznamu v teste'
);
expectSame(
    [],
    array_values(array_diff($unescapedKeys, array_keys($foundUnescaped))),
    'Zoznam neescapovaných kľúčov nesmie obsahovať kľúče, ktoré sa už escapujú'
);
foreach (array_keys(appLanguages()) as $markupLang) {
    $catalogue = require dirname(__DIR__) . '/lang/' . $markupLang . '.php';
    $unsafeMarkup = [];
    foreach ($unescapedKeys as $unescapedKey) {
        $withoutStrong = str_replace(['<strong>', '</strong>'], '', (string) ($catalogue[$unescapedKey] ?? ''));
        if (str_contains($withoutStrong, '<') || str_contains($withoutStrong, '>')) {
            $unsafeMarkup[] = $unescapedKey;
        }
    }
    expectSame([], $unsafeMarkup, "Katalóg {$markupLang} smie v neescapovaných kľúčoch používať iba <strong>");
}

$testDate = new DateTimeImmutable('2026-07-28 12:00:00');
expectSame('28. júla 2026', formatLocalizedDate($testDate, 'sk'), 'Slovenský dátum');
expectSame('July 28, 2026', formatLocalizedDate($testDate, 'en'), 'Anglický dátum');
expectSame('28. července 2026', formatLocalizedDate($testDate, 'cs'), 'Český dátum');
expectSame('28. Juli 2026', formatLocalizedDate($testDate, 'de'), 'Nemecký dátum');
expectSame('28 juillet 2026', formatLocalizedDate($testDate, 'fr'), 'Francúzsky dátum');
expectSame('28 de julio de 2026', formatLocalizedDate($testDate, 'es'), 'Španielsky dátum používa predložku „de“');
expectSame('28 lipca 2026', formatLocalizedDate($testDate, 'pl'), 'Poľský dátum používa genitív mesiaca');
expectSame('2026. július 28.', formatLocalizedDate($testDate, 'hu'), 'Maďarský dátum ide od najväčšej jednotky');
expectSame('28 luglio 2026', formatLocalizedDate($testDate, 'it'), 'Taliansky dátum');
expectSame('28 липня 2026', formatLocalizedDate($testDate, 'uk'), 'Ukrajinský dátum používa genitív mesiaca');

// Každý podporovaný jazyk musí mať vlastnú sadu názvov mesiacov, inak by dátum
// ticho spadol na slovenské názvy.
foreach (array_keys(appLanguages()) as $monthLang) {
    $months = localizedMonthNames($monthLang);
    expectSame(12, count($months), "Jazyk {$monthLang} musí mať 12 názvov mesiacov");
    expectTrue(
        $monthLang === APP_DEFAULT_LANGUAGE || $months !== localizedMonthNames(APP_DEFAULT_LANGUAGE),
        "Jazyk {$monthLang} nesmie ticho používať slovenské názvy mesiacov"
    );
}

// hreflang x-default patrí jazyku, ktorý dostane návštevník s nepodporovaným
// jazykom — musí byť teda odvodený od APP_FALLBACK_LANGUAGE (Beh #6).
$defaultCluster = languageAlternatesFor('https://polascin.net/');
expectSame(
    'https://polascin.net/?lang=en',
    $defaultCluster[APP_FALLBACK_LANGUAGE],
    'x-default musí ukazovať na anglickú verziu'
);

// PHP by inak k odpovedi pridal vlastné `Expires: 1981` a `Pragma: no-cache`,
// ktoré protirečia `private, max-age=0, must-revalidate` na verejných stránkach.
// O cache rozhoduje výhradne sendSecurityHeaders() (Beh #5).
expectSame(
    '',
    session_cache_limiter(),
    'Session nesmie pridávať vlastné cache hlavičky'
);

$csrf = generateCsrfToken();
expectTrue(!validateCsrfToken('nespravny-token'), 'Neplatný CSRF token musí byť odmietnutý');
expectSame($csrf, generateCsrfToken(), 'Neplatný CSRF pokus nesmie zneplatniť platný token');
expectTrue(validateCsrfToken($csrf), 'Platný CSRF token musí prejsť');
expectTrue(generateCsrfToken() !== $csrf, 'Platný CSRF token sa musí po použití otočiť');

$originalFormProofs = $_SESSION['_form_proofs'] ?? null;
$formProof = generateTimedFormProof('contact');
$_SESSION['_form_proofs']['contact'][$formProof] = time() - 3;
expectTrue(
    consumeTimedFormProof('contact', $formProof, 2, 7200),
    'Dostatočne starý formulárový dôkaz musí prejsť'
);
expectTrue(
    !consumeTimedFormProof('contact', $formProof, 2, 7200),
    'Formulárový dôkaz musí byť jednorazový'
);
$tooFastProof = generateTimedFormProof('contact');
expectTrue(
    !consumeTimedFormProof('contact', $tooFastProof, 2, 7200),
    'Okamžite odoslaný formulár musí byť označený ako automatizovaný'
);
expectTrue(
    !consumeTimedFormProof('contact', "not-a-proof\n", 2, 7200),
    'Neplatný formát formulárového dôkazu nesmie prejsť'
);
if ($originalFormProofs === null) {
    unset($_SESSION['_form_proofs']);
} else {
    $_SESSION['_form_proofs'] = $originalFormProofs;
}

expectTrue(
    httpOriginsMatch('https://polascin.net/contact.php', 'https://polascin.net'),
    'Referer z rovnakej HTTPS domény musí mať zhodný pôvod'
);
expectTrue(
    isTrustedApplicationOrigin('https://www.polascin.net/contact.php'),
    'Verejný www alias aplikácie musí zostať povoleným pôvodom'
);
expectTrue(
    !httpOriginsMatch('https://polascin.net.attacker.example', 'https://polascin.net'),
    'Doména s dôveryhodným prefixom nesmie mať zhodný pôvod'
);
expectTrue(
    !httpOriginsMatch('http://polascin.net', 'https://polascin.net'),
    'Odlišná schéma nesmie mať zhodný pôvod'
);
expectTrue(
    containsDisallowedControlCharacters("text\0payload")
        && !containsDisallowedControlCharacters("Bežný text\nna dvoch riadkoch"),
    'Validácia musí odmietnuť riadiace znaky, ale povoliť nový riadok'
);

// Prehľad projektu v `.audit.md` sa v Behu #19 rozišiel so skutočnosťou: uvádzal
// šesť jazykov, hoci `lang/` má desať katalógov. Dokumentácia je vstupom ďalších
// auditných behov, takže nesmie zaostávať za kódom.
$auditDoc = (string) file_get_contents(dirname(__DIR__) . '/.audit.md');
$missingFromDoc = [];
$missingFromDisk = [];
foreach (array_keys(appLanguages()) as $docLang) {
    if (!is_file(dirname(__DIR__) . '/lang/' . $docLang . '.php')) {
        $missingFromDisk[] = $docLang;
    }
    if (!str_contains($auditDoc, '`lang/' . $docLang . '.php`')) {
        $missingFromDoc[] = $docLang;
    }
}
expectSame([], $missingFromDisk, 'Každý podporovaný jazyk musí mať katalóg v lang/');
expectSame([], $missingFromDoc, 'Prehľad projektu v .audit.md musí uvádzať katalóg každého podporovaného jazyka');

// Kontrola vyššie porovnáva zoznam katalógov, nie počty vypísané slovom. Bod
// o `hreflang` v kontrolnom zozname preto prežil Beh #19 s tvrdením „šesť
// jazykov“ až do Behu #25, hoci ich je desať — a kontrolný zoznam je zadaním
// ďalších behov, takže by budúci beh šesť odkazov pokladal za správny stav.
// Kontroluje sa iba kontrolný zoznam: staršie „Beh #X“ sú záznamom toho, čo
// v danom čase platilo, a prepisovať sa nesmú — vtedy jazykov naozaj bolo šesť.
$checklistSection = '';
if (preg_match('~\n## Kontrolný zoznam auditu\n(.*?)\n## ~s', $auditDoc, $checklistMatch) === 1) {
    $checklistSection = $checklistMatch[1];
}
expectTrue($checklistSection !== '', '.audit.md musí obsahovať sekciu „Kontrolný zoznam auditu“');

$languageWordForms = [
    6 => 'šesť',
    10 => 'desať',
];
$staleLanguageWords = [];
foreach ($languageWordForms as $wordCount => $languageWord) {
    if ($wordCount === count(appLanguages())) {
        continue;
    }
    if (preg_match('~' . $languageWord . '\s+jazykov~ui', $checklistSection) === 1) {
        $staleLanguageWords[] = $languageWord;
    }
}
expectSame(
    [],
    $staleLanguageWords,
    'Kontrolný zoznam v .audit.md nesmie uvádzať iný počet jazykov, než má appLanguages()'
);

// Beh #21 skrátil idle timeout na 30 minút, ale kontrolný zoznam ešte v Behu #26
// tvrdil „1 hodina“. Ďalší beh by to pokladal za správny stav.
$idleMinutes = (int) (SESSION_IDLE_TIMEOUT / 60);
$absoluteHours = (int) (SESSION_ABSOLUTE_TIMEOUT / 3600);
expectTrue(
    $idleMinutes > 0
        && preg_match('~Idle timeout relácie \(' . $idleMinutes . ' minút\)~u', $checklistSection) === 1,
    'Kontrolný zoznam musí uvádzať aktuálny idle timeout relácie odvodený z SESSION_IDLE_TIMEOUT'
);
expectTrue(
    $absoluteHours > 0 && str_contains($checklistSection, (string) $absoluteHours . ' hodín'),
    'Kontrolný zoznam musí uvádzať aktuálny absolútny limit relácie'
);

$headMetaSource = (string) file_get_contents(dirname(__DIR__) . '/head_meta.php');
expectTrue(
    str_contains($headMetaSource, 'name="description"')
        && str_contains($headMetaSource, 'name="author"')
        && str_contains($headMetaSource, 'name="robots"')
        && str_contains($headMetaSource, 'name="theme-color"')
        && !str_contains($headMetaSource, 'name="keywords"'),
    'head_meta.php musí emitovať description/author/robots/theme-color a nesmie emitovať zastaraný keywords'
);
expectTrue(
    !preg_match('~Meta tagy: `description`, `keywords`~', $checklistSection),
    'Kontrolný zoznam nesmie vyžadovať zastaraný meta keywords ako povinný tag'
);

$doAuditDoc = (string) file_get_contents(dirname(__DIR__) . '/.doaudit.md');
expectTrue(
    str_contains($auditDoc, '## Recursive self-improvement (povinné)')
        && str_contains($doAuditDoc, '## Recursive self-improvement (povinné)'),
    '.audit.md aj .doaudit.md musia obsahovať povinnú sekciu recursive self-improvement'
);

foreach (glob(dirname(__DIR__) . '/lang/*.php') ?: [] as $cataloguePath) {
    $catalogueCode = basename($cataloguePath, '.php');
    expectTrue(
        isSupportedLanguage($catalogueCode),
        "Katalóg lang/{$catalogueCode}.php musí patriť podporovanému jazyku, inak je mŕtvy kód"
    );
}

// Statický `sitemap.xml` je len záložný index; nesmie sa vrátiť k zoznamu adries,
// ktorý by na produkcii prekryl dynamický `sitemap.php` (Beh #5, nález 6).
$sitemapIndex = (string) file_get_contents(dirname(__DIR__) . '/sitemap.xml');
expectTrue(str_contains($sitemapIndex, '<sitemapindex'), 'sitemap.xml musí zostať sitemap index');
expectTrue(str_contains($sitemapIndex, 'https://polascin.net/sitemap.php'), 'sitemap.xml musí odkazovať na sitemap.php');
expectTrue(!str_contains($sitemapIndex, '<urlset'), 'sitemap.xml nesmie obsahovať vlastný zoznam adries');

// Read-only kontrola DB (`scripts/audit_db_check.php`) beží na produkčnom
// serveri, kde ju nikto neuvidí zlyhať na drobnosti. Jej zabudované zoznamy sa
// preto porovnávajú so schémou a s `appLanguages()` tu, lokálne: keby sa
// rozišli, kontrola by ticho hlásila „OK" na schéme, ktorú vôbec nepozná.
$dbCheckSource = (string) file_get_contents(dirname(__DIR__) . '/scripts/audit_db_check.php');
$setupDbSource = (string) file_get_contents(dirname(__DIR__) . '/setup_db.php');

/** Vytiahne prvky z `const NAZOV = [...]` v kontrolnom skripte. */
$dbCheckConstant = static function (string $constantName) use ($dbCheckSource): array {
    if (preg_match('~const\s+' . preg_quote($constantName, '~') . '\s*=\s*\[(.*?)\];~s', $dbCheckSource, $match) !== 1) {
        return [];
    }
    // Všetky tri sledované konštanty sú ploché zoznamy reťazcov, takže stačí
    // vyzbierať uvodzovkované hodnoty; delimiter za poslednou položkou chýba.
    preg_match_all("~'([^']+)'~", $match[1], $items);

    return $items[1];
};

preg_match_all("~^\s{8}'(\d{10}_[a-z0-9_]+)'\s*=>~m", $setupDbSource, $migrationMatches);
expectTrue($migrationMatches[1] !== [], 'V setup_db.php sa musia dať nájsť kľúče migrácií');
expectSame(
    $migrationMatches[1],
    $dbCheckConstant('EXPECTED_MIGRATIONS'),
    'EXPECTED_MIGRATIONS v audit_db_check.php musí zodpovedať migráciám v setup_db.php'
);

preg_match_all('~CREATE TABLE IF NOT EXISTS (\w+)~', $setupDbSource, $tableMatches);
expectTrue($tableMatches[1] !== [], 'V setup_db.php sa musia dať nájsť názvy tabuliek');
$expectedTablesInCheck = $dbCheckConstant('EXPECTED_TABLES');
expectSame([], array_values(array_diff($tableMatches[1], $expectedTablesInCheck)), 'EXPECTED_TABLES v audit_db_check.php nesmie vynechať tabuľku zo setup_db.php');
expectSame([], array_values(array_diff($expectedTablesInCheck, $tableMatches[1])), 'EXPECTED_TABLES v audit_db_check.php nesmie uvádzať tabuľku, ktorú setup_db.php nevytvára');

expectSame(
    array_keys(appLanguages()),
    $dbCheckConstant('EXPECTED_LANGUAGES'),
    'EXPECTED_LANGUAGES v audit_db_check.php musí zodpovedať appLanguages()'
);

// Kontrola musí zostať read-only. Toto je hrubé sito nad zdrojom, nie dôkaz —
// skutočnú ochranu nesie `START TRANSACTION READ ONLY` a odporúčaný DB grant.
foreach (['INSERT ', 'UPDATE ', 'DELETE ', 'DROP ', 'TRUNCATE ', 'ALTER ', 'REPLACE INTO'] as $writeKeyword) {
    expectTrue(
        !str_contains($dbCheckSource, "'" . $writeKeyword) && !str_contains($dbCheckSource, '"' . $writeKeyword),
        "audit_db_check.php nesmie obsahovať zápisové SQL ({$writeKeyword})"
    );
}
expectTrue(
    str_contains($dbCheckSource, 'START TRANSACTION READ ONLY'),
    'audit_db_check.php musí čítať v read-only transakcii'
);

// Report sa commituje do verejného repozitára. Názov databázy a presná verzia
// servera doň nepatria — sú to práve tie údaje, ktoré útočníkovi chýbajú
// k platnému prihláseniu, resp. k exploitu na konkrétnu patch verziu.
expectTrue(
    !str_contains($dbCheckSource, 'SELECT DATABASE()'),
    'audit_db_check.php nesmie čítať názov databázy — report je vo verejnom repozitári'
);
expectTrue(
    str_contains($dbCheckSource, '$serverMajorMinor') && !str_contains($dbCheckSource, '$rawVersion . '),
    'audit_db_check.php musí verziu servera skrátiť na hlavné číslo, nie ju vypísať celú'
);
// Čistenie `form_rate_limit` nesmie byť obmedzené na jednu akciu: predtým
// prerezávalo len práve vykonávanú akciu, takže riadky zriedka používaných
// akcií držali IP adresy 44 dní (Beh #20, nález z nočnej kontroly DB).
$authSource = (string) file_get_contents(dirname(__DIR__) . '/auth.php');
expectTrue(
    str_contains($authSource, "session_name(\$isHttps ? '__Host-POLASCINSESSID' : 'POLASCINSESSID')"),
    'Produkčná session cookie musí používať prefix __Host-'
);
expectTrue(
    str_contains($authSource, 'SESSION_ABSOLUTE_TIMEOUT')
        && str_contains($authSource, 'SESSION_RENEWAL_INTERVAL'),
    'Autentifikovaná relácia musí mať absolútny aj obnovovací časový limit'
);
expectTrue(
    str_contains($authSource, "SELECT username, email, password_hash, is_admin, is_active"),
    'Priebežné overenie účtu musí kontrolovať aj zmenu hash-u hesla'
);
$loginSource = (string) file_get_contents(dirname(__DIR__) . '/login.php');
expectTrue(
    str_contains($loginSource, "http_response_code(401)")
        && str_contains($loginSource, "http_response_code(429)")
        && str_contains($loginSource, "header('Retry-After: 900')"),
    'Neúspešné prihlásenia musia mať rozlíšiteľné bezpečnostné HTTP stavy a Retry-After'
);
expectTrue(
    str_contains($loginSource, "logAdminAction(\$pdo, 'login_success', 'session')"),
    'Úspešné prihlásenie musí zostať v administrátorskom audite'
);
$logoutSource = (string) file_get_contents(dirname(__DIR__) . '/logout.php');
expectTrue(
    str_contains($logoutSource, "logAdminAction(\$pdo, 'logout', 'session')"),
    'Odhlásenie musí zostať v administrátorskom audite'
);
$adminContactSource = (string) file_get_contents(dirname(__DIR__) . '/admin_contact.php');
expectTrue(
    str_contains($adminContactSource, "\$action === 'delete_all'")
        && str_contains($adminContactSource, "DELETE FROM contact_messages"),
    'Administrácia správ musí podporovať hromadné odstránenie'
);
expectTrue(
    str_contains($adminContactSource, 'name="csrf_token"')
        && str_contains($adminContactSource, 'name="confirmation" value="" data-confirmation-value="delete_all_contact_messages"')
        && str_contains($adminContactSource, 'data-confirm="Natrvalo odstrániť všetky kontaktné správy'),
    'Hromadné odstránenie správ musí vyžadovať CSRF aj výslovné potvrdenie'
);
expectTrue(
    str_contains($adminContactSource, "'contact_delete_all'")
        && str_contains($adminContactSource, "['deleted_count' => \$deletedCount]"),
    'Hromadné odstránenie správ musí zapísať počet zmazaných správ do auditu'
);
$mainJsSource = (string) file_get_contents(dirname(__DIR__) . '/js/main.js');
expectTrue(
    str_contains($mainJsSource, 'confirmationInput.dataset.confirmationValue'),
    'Serverové potvrdenie hromadného odstránenia sa smie aktivovať až po potvrdení dialógu'
);
$adminUsersSource = (string) file_get_contents(dirname(__DIR__) . '/admin_users.php');
expectTrue(
    str_contains($adminUsersSource, 'requireAdmin()')
        && str_contains($adminUsersSource, 'isTrustedStateChangingRequest()')
        && str_contains($adminUsersSource, 'validateCsrfToken('),
    'Správa administrátorov musí vyžadovať admin oprávnenie, dôveryhodný pôvod a CSRF'
);
expectTrue(
    str_contains($adminUsersSource, "password_verify(\$currentPassword, \$currentHash)")
        && str_contains($adminUsersSource, 'SET password_hash = :new_hash, must_change_password = 0')
        && str_contains($adminUsersSource, 'password_hash = :current_hash'),
    'Zmena hesla musí znovu overiť aktuálne heslo a použiť podmienenú aktualizáciu hash-u'
);
expectTrue(
    str_contains($adminUsersSource, 'hashAppPassword($newPassword)')
        && str_contains($adminUsersSource, "'admin_password_change'")
        && str_contains($adminUsersSource, "logAdminAction(\$pdo, 'admin_password_change'"),
    'Zmena hesla musí použiť spoločnú hashovaciu politiku, limit a audit'
);
expectTrue(
    str_contains($adminUsersSource, 'must_change_password)')
        && str_contains($adminUsersSource, 'VALUES (:username, :email, :password_hash, 1, 1, 1)')
        && str_contains($adminUsersSource, "password_verify(\$authorizingPassword, \$currentHash)"),
    'Nový administrátor musí dostať iba hash dočasného hesla a povinnú prvú zmenu po opätovnom overení správcu'
);
expectTrue(
    str_contains($adminUsersSource, "logAdminAction(\$pdo, 'admin_user_create'")
        && str_contains($adminUsersSource, '$pdo->beginTransaction()')
        && str_contains($adminUsersSource, '$pdo->rollBack()'),
    'Vytvorenie administrátora musí byť transakčné a auditované'
);
expectTrue(
    str_contains($authSource, 'must_change_password')
        && str_contains($authSource, "admin_users.php?change_required=1")
        && str_contains($loginSource, "'admin_users.php?change_required=1'"),
    'Prihlásenie s dočasným heslom musí vynútiť prechod na zmenu hesla'
);
$adminDashboardSource = (string) file_get_contents(dirname(__DIR__) . '/admin.php');
$mainNavSource = (string) file_get_contents(dirname(__DIR__) . '/main_nav.php');
expectTrue(
    str_contains($adminDashboardSource, 'href="admin_users.php"')
        && str_contains($mainNavSource, "'admin_users.php'"),
    'Správa administrátorov musí byť dostupná z panela aj admin navigácie'
);
$contactSource = (string) file_get_contents(dirname(__DIR__) . '/contact.php');
expectTrue(
    str_contains($contactSource, 'isTrustedStateChangingRequest()')
        && str_contains($contactSource, "consumeTimedFormProof('contact'")
        && str_contains($contactSource, 'name="website"'),
    'Kontaktný formulár musí kontrolovať pôvod, časovaný dôkaz aj honeypot'
);
expectTrue(
    str_contains($contactSource, "'contact_global'")
        && str_contains($contactSource, "'contact_sender'")
        && str_contains($contactSource, "'contact_duplicate'")
        && str_contains($contactSource, 'isEmailDomainValid($email)'),
    'Kontaktný formulár musí obmedzovať distribuovaný spam, odosielateľa aj duplicity'
);
expectTrue(
    str_contains($contactSource, 'minlength="20"')
        && str_contains($contactSource, "clearFormRateLimit(\$pdo, 'contact_duplicate', \$duplicateKey)"),
    'Správa musí mať minimálnu dĺžku a neúspešný zápis musí uvoľniť deduplikačný limit'
);
expectTrue(
    str_contains($mainJsSource, 'form[data-submit-once]')
        && str_contains($mainJsSource, 'submitButton.disabled = true'),
    'Klient musí zabrániť opakovanému odoslaniu dvojklikom'
);
$stylesSource = (string) file_get_contents(dirname(__DIR__) . '/css/styles.css');
expectTrue(
    str_contains($stylesSource, '.contact-form-trap')
        && preg_match('/\.contact-form-trap\s*\{[^}]*display\s*:\s*none/is', $stylesSource) !== 1,
    'Honeypot musí zostať v DOM a nesmie používať display:none'
);
expectTrue(
    preg_match('~DELETE FROM form_rate_limit\s+WHERE\s+\(blocked_until~', $authSource) === 1,
    'Čistenie form_rate_limit musí prerezávať všetky akcie, nie len tú práve vykonávanú'
);
expectTrue(
    !str_contains($authSource, "DELETE FROM form_rate_limit
                     WHERE action = :action"),
    'Čistenie form_rate_limit sa nesmie vrátiť k obmedzeniu na jednu akciu'
);
// Prerezanie viazané len na `checkFormRateLimit()` sa na stránke s nulovou
// prevádzkou formulárov nespustí nikdy — produkčná DB držala IP adresy 47 dní
// (Beh #24, nález z nočnej kontroly DB). Zápis access logu beží pri každej
// požiadavke, takže housekeeping musí visieť aj na ňom.
expectTrue(
    preg_match(
        '~DELETE FROM access_logs WHERE created_at < :cutoff.*?pruneFormRateLimit\(\$pdo\)~s',
        $authSource
    ) === 1,
    'Prerezanie form_rate_limit musí bežať aj v housekeepingu zápisu access logu'
);
expectTrue(
    preg_match('~const FORM_RATE_LIMIT_MAX_AGE_SECONDS = (\d+);~', $authSource, $rateLimitAgeMatch) === 1
        && (int) $rateLimitAgeMatch[1] >= 2 * 86400,
    'Vek prerezania form_rate_limit musí byť aspoň dvojnásobok najdlhšieho okna (86 400 s)'
);
// Prerezanie nesmie zhodiť zápis access logu: chybu si rieši samo.
expectTrue(
    preg_match(
        '~function pruneFormRateLimit\(PDO \$pdo.*?catch \(\\\\Throwable \$cleanupError\)~s',
        $authSource
    ) === 1,
    'pruneFormRateLimit musí odchytávať vlastné chyby'
);
$longestRateLimitWindow = 0;
foreach (['contact.php', 'newsletter.php', 'login.php', 'admin_users.php'] as $rateLimitCaller) {
    preg_match_all(
        '~checkFormRateLimit\(\$pdo,[^)]*?,\s*(\d+)\)~',
        (string) file_get_contents(dirname(__DIR__) . '/' . $rateLimitCaller),
        $windowMatches
    );
    foreach ($windowMatches[1] as $window) {
        $longestRateLimitWindow = max($longestRateLimitWindow, (int) $window);
    }
}
expectTrue(
    $longestRateLimitWindow > 0 && (int) $rateLimitAgeMatch[1] >= 2 * $longestRateLimitWindow,
    'FORM_RATE_LIMIT_MAX_AGE_SECONDS musí pokryť dvojnásobok skutočne najdlhšieho okna v kóde'
);

$reportPath = dirname(__DIR__) . '/audit-reports/db-latest.md';
if (is_file($reportPath)) {
    $lastReport = (string) file_get_contents($reportPath);
    expectTrue(
        preg_match('~Databáza: `~', $lastReport) !== 1,
        'Commitnutý report nesmie obsahovať názov databázy'
    );
    expectTrue(
        preg_match('~\d+\.\d+\.\d+-MariaDB~', $lastReport) !== 1,
        'Commitnutý report nesmie obsahovať presnú verziu servera'
    );
}

// `POLASCIN_ENV_PATH` nie je nastavené ako tajomstvo, takže oba workflowy si
// cestu k env.ini odvodzujú rovnakým defaultom. Keby sa odvodenie rozišlo,
// nočná kontrola by čítala inú konfiguráciu než tá, s ktorou beží aplikácia.
$verifyWorkflow = (string) file_get_contents(dirname(__DIR__) . '/.github/workflows/verify-db.yml');
$envPathDerivation = 'REMOTE_ENV_PATH="${POLASCIN_ENV_PATH:-${REMOTE_PARENT%/}/private/polascin.env.ini}"';
foreach (['deploy.yml' => $deployWorkflow, 'verify-db.yml' => $verifyWorkflow] as $workflowName => $workflowSource) {
    expectTrue(
        str_contains($workflowSource, $envPathDerivation),
        "{$workflowName} musí odvodzovať cestu k env.ini rovnakým defaultom"
    );
}

// Kontrolný skript ani reporty nesmú skončiť vo verejnom web roote.
foreach (['scripts', 'audit-reports'] as $auditOnlyDir) {
    expectTrue(
        preg_match('~(^|\r?\n)' . preg_quote($auditOnlyDir, '~') . '(\r?\n|$)~', $deployIgnoreRules) === 1,
        ".deployignore musí vylúčiť {$auditOnlyDir} z nasadenia"
    );
}

// Nočná kontrola sa musí spustiť pred behom auditnej rutiny (00:00 UTC), inak
// rutina číta report z predchádzajúceho dňa. Samotné „pred polnocou“ nestačí:
// GitHub plánované behy odkladá aj o ~2 h (behy #5–#7 štartovali 01:27–01:45
// UTC namiesto 23:50), preto sa vyžaduje rezerva aspoň 2 hodiny (Beh #24).
expectTrue(
    preg_match('~cron: "(\d{1,2}) (\d{1,2}) \* \* \*"~', $verifyWorkflow, $cronMatch) === 1
        && (24 - (int) $cronMatch[2]) * 60 - (int) $cronMatch[1] >= 120,
    'verify-db.yml musí bežať aspoň 2 h pred 00:00 UTC, aby stihol report pred nočnou rutinou'
);
expectTrue(
    isset($cronMatch[1]) && (int) $cronMatch[1] !== 0,
    'cron verify-db.yml nesmie sedieť na celej hodine, kde je fronta plánovaných behov najdlhšia'
);
expectTrue(
    str_contains($verifyWorkflow, 'group: polascin-production-deploy'),
    'verify-db.yml musí zdieľať concurrency skupinu s nasadením, aby sa nikdy neprekryli'
);

// Beh #24: SSH krok „Create remote environment config“ raz padol na
// `Connection closed by <host>` bez zmeny kódu. Keepalive a opakovaný pokus
// musia byť vo všetkých SSH cestách, inak sa prechodný výpadok hostingu vráti.
foreach (
    [
        'deploy.yml' => $deployWorkflow,
        'verify-db.yml' => $verifyWorkflow,
        'hooks/deploy.sh' => $deployScript,
    ] as $sshSourceName => $sshSource
) {
    expectTrue(
        str_contains($sshSource, 'ServerAliveInterval=15')
            && str_contains($sshSource, 'ServerAliveCountMax=4')
            && str_contains($sshSource, 'ConnectionAttempts=3'),
        "{$sshSourceName} musí na SSH používať keepalive a opakované pripojenie"
    );
}
expectTrue(
    str_contains($deployWorkflow, 'SSH zlyhalo po ${attempts} pokusoch pri zápise vzdialenej konfigurácie.'),
    'deploy.yml musí pri zápise env.ini zopakovať SSH po prechodnom dropnutí'
);
expectTrue(
    str_contains($verifyWorkflow, 'ssh_ok=0')
        && str_contains($verifyWorkflow, 'while (( attempts < 3 )); do'),
    'verify-db.yml musí SSH kontrolu DB zopakovať po prechodnom dropnutí'
);

$articleSeedFiles = glob(dirname(__DIR__) . '/content/articles/*.php') ?: [];
expectTrue($articleSeedFiles !== [], 'Adresár content/articles musí obsahovať aspoň jeden blogový príspevok');
foreach ($articleSeedFiles as $articleSeedPath) {
    $articleSeed = require $articleSeedPath;
    $articleFile = basename($articleSeedPath);
    expectTrue(
        is_array($articleSeed)
            && preg_match('/^[a-z0-9-]+$/', (string) ($articleSeed['slug'] ?? '')) === 1
            && array_diff(array_keys(appLanguages()), array_keys($articleSeed['translations'] ?? [])) === [],
        "{$articleFile} musí mať slug a preklad v každom jazyku stránky"
    );
    foreach (array_keys(appLanguages()) as $articleLang) {
        $payload = $articleSeed['translations'][$articleLang];
        $clean = sanitizeHtmlContent((string) ($payload['content'] ?? ''));
        expectTrue(
            trim((string) ($payload['title'] ?? '')) !== ''
                && appTextLength((string) ($payload['title'] ?? '')) <= 255
                && trim((string) ($payload['excerpt'] ?? '')) !== ''
                && $clean !== '',
            "{$articleFile} ({$articleLang}) musí mať názov, úryvok aj bezpečný HTML obsah"
        );
        expectTrue(
            !str_contains(strtolower($clean), '<script')
                && str_contains($clean, 'contact.php'),
            "{$articleFile} ({$articleLang}) musí po sanitizácii zachovať odkaz na kontakt a nesmie obsahovať skript"
        );
        expectTrue(
            trim((string) ($payload['image_alt'] ?? '')) !== ''
                && appTextLength((string) $payload['image_alt']) <= 255,
            "{$articleFile} ({$articleLang}) musí mať alt text obálky do 255 znakov"
        );
    }
    $coverPath = normalizeArticleCoverPath((string) ($articleSeed['image'] ?? ''));
    $slug = (string) $articleSeed['slug'];
    expectTrue(
        $coverPath === 'images/articles/' . $slug . '.webp'
            && is_file(dirname(__DIR__) . '/' . $coverPath),
        "{$articleFile} musí mať obálku images/articles/{$slug}.webp"
    );
    $coverInfo = getimagesize(dirname(__DIR__) . '/' . $coverPath);
    expectTrue(
        is_array($coverInfo)
            && (string) ($coverInfo['mime'] ?? '') === 'image/webp'
            && (int) $coverInfo[0] >= 1200
            && (int) $coverInfo[1] >= 675,
        "{$articleFile} musí mať širokú WebP obálku"
    );
    expectTrue(
        str_contains($setupDbSource, $articleFile),
        "setup_db.php musí {$articleFile} vložiť idempotentnou migráciou"
    );
}
expectTrue(
    str_contains($setupDbSource, 'function seedPublishedArticleFromFile'),
    'setup_db.php musí články vkladať spoločnou funkciou, nie kopírovať INSERT do každej migrácie'
);
expectTrue(
    str_contains($setupDbSource, '2026091706_article_all_language_translations'),
    'setup_db.php musí jazykové mutácie článkov vložiť migráciou'
);
expectTrue(
    normalizeArticleCoverPath('../etc/passwd') === null
        && normalizeArticleCoverPath('https://evil.example/x.webp') === null
        && normalizeArticleCoverPath('images/articles/not-a-slug.webp') === 'images/articles/not-a-slug.webp',
    'Cesta obálky smie byť len súbor v images/articles/'
);
expectTrue(
    articleCoverSrc(null, 'lekar-ako-pacient-glp1-a-kortikosteroidy')
        === 'images/articles/lekar-ako-pacient-glp1-a-kortikosteroidy.webp',
    'Obálka sa musí dať nájsť podľa slugu, aj keď stĺpec image ešte nie je v SELECT'
);
$articleTemplate = (string) file_get_contents(dirname(__DIR__) . '/article.php');
$articlesTemplate = (string) file_get_contents(dirname(__DIR__) . '/articles.php');
$homeTemplate = (string) file_get_contents(dirname(__DIR__) . '/index.php');
$articleCss = (string) file_get_contents(dirname(__DIR__) . '/css/styles.css');
expectTrue(
    str_contains($articleTemplate, 'articleCoverHtml(')
        && str_contains($articleTemplate, 'class="article-cover"')
        && str_contains($articlesTemplate, 'articleCoverHtml(')
        && str_contains($homeTemplate, 'articleCoverHtml('),
    'Detail, zoznam aj homepage musia vykresliť obálku článku'
);
expectTrue(
    str_contains($articleCss, '.article-cover')
        && str_contains($articleCss, '.card-cover'),
    'CSS musí mať štýly pre obálku v detaile aj na kartách'
);

// ── Beh #27: obálky článkov, cache statických prostriedkov, kotva `$` ────────
// Migrácia `2026091705_article_cover_images` pridala stĺpce `image`
// a `image_alt` a seeder ich plní vo všetkých desiatich jazykoch, ale čítacia
// cesta ich nevyberala. Obálka sa preto našla len vďaka tomu, že sa súbor volá
// rovnako ako slug, a jazykovo špecifický alt text (aj `og:image:alt`) sa nikdy
// nepoužil — namiesto neho sa opakoval titulok článku. Rovnaký vzor drift ako
// „stĺpec je v schéme, ale nie v SELECTe“ stráži tento test v oboch smeroch.
$helpersSource = (string) file_get_contents(dirname(__DIR__) . '/helpers.php');
expectTrue(
    preg_match('~SELECT id, title, slug, excerpt, image, image_alt, author, lang~', $helpersSource) === 1,
    'getPublishedArticles() musí vyberať aj stĺpce image a image_alt'
);
expectTrue(
    preg_match('~\$columns = "id, title, slug, excerpt, image, image_alt, content, author~', $helpersSource) === 1,
    'getArticleBySlug() musí vyberať aj stĺpce image a image_alt'
);
expectTrue(
    str_contains($setupDbSource, 'image VARCHAR(255) NULL')
        && str_contains($setupDbSource, 'image_alt VARCHAR(255) NULL'),
    'setup_db.php musí mať stĺpce obálky aj v CREATE TABLE pre čistú inštaláciu'
);
expectTrue(
    articleCoverSrc('images/articles/lekar-ako-pacient-glp1-a-kortikosteroidy.webp', null)
        === 'images/articles/lekar-ako-pacient-glp1-a-kortikosteroidy.webp',
    'Obálka sa musí dať nájsť podľa stĺpca image aj bez slugu'
);

// Kotva `$` bez modifikátora `D` prepúšťa vstup zakončený novým riadkom.
// Tu to nebolo zneužiteľné (is_file, prepared statements), ale validácia má
// platiť presne tak, ako je napísaná.
expectTrue(
    articleCoverSrc(null, "lekar-ako-pacient-glp1-a-kortikosteroidy\n") === null,
    'Slug zakončený novým riadkom nesmie prejsť validáciou obálky'
);
$newsletterSource = (string) file_get_contents(dirname(__DIR__) . '/newsletter.php');
expectSame(
    0,
    preg_match_all('~preg_match\(\'/\^\[a-f0-9\]\{48\}\$/\'~', $newsletterSource),
    'Kontroly newsletterových tokenov musia mať modifikátor D'
);
expectSame(
    4,
    preg_match_all('~preg_match\(\'/\^\[a-f0-9\]\{48\}\$/D\'~', $newsletterSource),
    'Všetky štyri kontroly newsletterových tokenov musia byť ukotvené s D'
);

// Statické prostriedky sa podávali bez Cache-Control, takže každá návšteva
// ťahala CSS, JS aj obálky článkov znova. CSS a JS sú verziované cez
// `?v=<filemtime>` (a v statických fallbackoch pinom, ktorý stráži test vyššie),
// takže smú byť immutable; obrázky a fonty verziované nie sú.
expectTrue(
    preg_match('~<FilesMatch "\\\\\.\(css\|js\)\$">\s*\n\s*Header always set Cache-Control "public, max-age=31536000, immutable"~', $htaccessRules) === 1,
    '.htaccess musí verziované CSS a JS cachovať natrvalo'
);
expectTrue(
    preg_match('~<FilesMatch "\\\\\.\(webp\|avif\|png\|jpe\?g\|gif\|svg\|ico\|woff2\?\|ttf\|otf\|eot\)\$">\s*\n\s*Header always set Cache-Control "public, max-age=2592000"~', $htaccessRules) === 1,
    '.htaccess musí neverziované obrázky a fonty cachovať konzervatívne (30 dní)'
);
expectTrue(
    str_contains($deployWorkflow, 'article\.php?slug=')
        && str_contains($deployWorkflow, 'Detail článku vracia'),
    'Smoke check musí overiť aj detail článku, nielen zoznam'
);
expectTrue(
    str_contains($deployWorkflow, '/css/styles.css')
        && str_contains($deployWorkflow, 'bez hlavičky Cache-Control'),
    'Smoke check musí overiť Cache-Control na statickom prostriedku'
);

// ── Obálka v admin rozhraní a JPEG variant pre Open Graph ────────────────────
// Beh #27 nechal obe veci ako odporúčanie: obálku nebolo možné nastaviť
// z admina (stĺpce boli len v seederi) a `og:image` bol WebP, ktorý LinkedIn
// nezobrazí. Testy držia obe doplnenia na mieste.
$adminArticles = (string) file_get_contents(dirname(__DIR__) . '/admin_articles.php');
expectTrue(
    str_contains($adminArticles, 'image = :image, image_alt = :image_alt')
        && str_contains($adminArticles, 'INSERT INTO articles (title, slug, excerpt, image, image_alt, content'),
    'Admin musí obálku zapisovať pri úprave aj pri vytvorení článku'
);
expectTrue(
    str_contains($adminArticles, 'name="image"')
        && str_contains($adminArticles, 'name="image_alt"')
        && str_contains($adminArticles, 'availableArticleCovers()'),
    'Admin formulár musí mať pole obálky aj alternatívneho textu z ponuky súborov'
);
expectTrue(
    str_contains($adminArticles, 'normalizeArticleCoverPath($image)')
        && str_contains($adminArticles, "!is_file(__DIR__ . '/' . \$image)"),
    'Admin musí zvolenú obálku validovať cestou aj existenciou súboru'
);
expectTrue(
    str_contains($adminArticles, '$coverMissing'),
    'Admin musí uloženú obálku ponechať v ponuke aj keď súbor na disku chýba'
);
// Ponuka sa berie z disku, takže do stĺpca `image` sa nedá dostať nič,
// čo by `normalizeArticleCoverPath()` odmietla.
foreach (availableArticleCovers() as $offeredCover) {
    expectTrue(
        normalizeArticleCoverPath($offeredCover) === $offeredCover
            && is_file(dirname(__DIR__) . '/' . $offeredCover),
        "Ponúkaná obálka {$offeredCover} musí prejsť validáciou aj existovať"
    );
}
expectTrue(
    !in_array('images/articles/og', availableArticleCovers(), true)
        && array_filter(availableArticleCovers(), static fn(string $c): bool => str_contains($c, '/og/')) === [],
    'JPEG odvodeniny z podadresára og/ sa nesmú ponúkať ako obálka'
);

// Každá WebP obálka musí mať JPEG dvojičku pre Open Graph, inak by nový článok
// prišiel o náhľad na sieťach, ktoré WebP nevykreslia.
$coverSources = glob(dirname(__DIR__) . '/images/articles/*.webp') ?: [];
expectTrue($coverSources !== [], 'V images/articles/ musí byť aspoň jedna obálka');
foreach ($coverSources as $coverSource) {
    $coverName = basename($coverSource, '.webp');
    $ogTwin = dirname(__DIR__) . '/images/articles/og/' . $coverName . '.jpg';
    expectTrue(
        is_file($ogTwin),
        "Obálka {$coverName}.webp musí mať JPEG dvojičku v images/articles/og/ (php scripts/make_og_covers.php)"
    );
    if (is_file($ogTwin)) {
        $ogInfo = getimagesize($ogTwin);
        expectTrue(
            is_array($ogInfo) && $ogInfo['mime'] === 'image/jpeg' && $ogInfo[0] >= 1200 && $ogInfo[1] >= 630,
            "JPEG dvojička {$coverName}.jpg musí byť skutočný JPEG s rozmermi aspoň 1200×630"
        );
    }
    expectTrue(
        articleCoverSocialSrc('images/articles/' . $coverName . '.webp', null)
            === 'images/articles/og/' . $coverName . '.jpg',
        "Open Graph musí pre {$coverName} podsunúť JPEG, nie WebP"
    );
}
expectTrue(
    articleCoverSocialSrc(null, 'neexistujuci-slug') === null,
    'Bez obálky nesmie articleCoverSocialSrc() nič vymyslieť'
);
$headMetaSource = (string) file_get_contents(dirname(__DIR__) . '/head_meta.php');
expectTrue(
    str_contains($headMetaSource, 'property="og:image:type"')
        && str_contains($headMetaSource, "\$ogImageType = \$ogImageType ?? 'image/jpeg'"),
    'head_meta.php musí emitovať og:image:type s JPEG predvoľbou'
);
expectTrue(
    str_contains((string) file_get_contents(dirname(__DIR__) . '/article.php'), 'articleCoverSocialSrc('),
    'Detail článku musí do og:image posielať sociálny variant obálky'
);
$ogGenerator = (string) file_get_contents(dirname(__DIR__) . '/scripts/make_og_covers.php');
expectTrue(
    str_contains($ogGenerator, "PHP_SAPI !== 'cli'"),
    'Generátor OG obálok musí odmietnuť spustenie cez web'
);
// Rúra do `head` zavrie predchádzajúcemu príkazu výstup a zelený smoke check
// potom hlási `curl: (23)` alebo „Broken pipe“ — vyzerá to ako chyba nasadenia.
// Stalo sa to dvakrát (Beh #27 pri sitemape, Beh #28 pri og:image), preto
// vzor v smoke checku stráži test. Namiesto rúry: `grep -m 1` a expanzia.
$deployHeadPipes = [];
foreach (explode("\n", $deployWorkflow) as $lineNumber => $deployLine) {
    $trimmed = ltrim($deployLine);
    if ($trimmed === '' || str_starts_with($trimmed, '#')) {
        continue;
    }
    if (preg_match('~\|\s*head\b~', $deployLine) === 1) {
        $deployHeadPipes[] = $lineNumber + 1;
    }
}
expectSame(
    [],
    $deployHeadPipes,
    'deploy.yml nesmie rúrou posielať výstup do head (Broken pipe v zelenom behu)'
);
expectTrue(
    str_contains($deployWorkflow, 'grep -m 1 -o'),
    'Smoke check musí prvý výskyt brať cez grep -m 1, nie cez head'
);
expectTrue(
    str_contains($deployWorkflow, 'property="og:image" content=')
        && str_contains($deployWorkflow, 'og:image nie je dostupný ako obrázok'),
    'Smoke check musí overiť, že og:image z detailu článku je na produkcii dostupný'
);
$pipelineRule = (string) file_get_contents(dirname(__DIR__) . '/.cursor/rules/blog-article-pipeline.mdc');
expectTrue(
    str_contains($pipelineRule, 'scripts/make_og_covers.php'),
    'Pipeline blogu musí generovanie OG obálky spomínať, inak ju ďalší článok vynechá'
);

if ($failures !== []) {
    fwrite(STDERR, "Zlyhané kontroly:\n- " . implode("\n- ", $failures) . "\n");
    exit(1);
}

fwrite(STDOUT, "OK: {$assertions} kontrol prešlo.\n");
