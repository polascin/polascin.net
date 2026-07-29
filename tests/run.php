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
expectSame('28. júla 2026', formatArticleDate('2026-07-28 12:00:00'), 'Dátum článku musí používať slovenský názov mesiaca');

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

expectTrue(!isAppPasswordValid('Short1A'), 'Krátke heslo nesmie prejsť');
expectTrue(isAppPasswordValid('LongEnoughPassword1'), 'Silné heslo musí prejsť');

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

// bcrypt odmieta NUL bajt cez \ValueError, nie \InvalidArgumentException.
// Rehash v login.php preto musí chytať \Throwable, inak by úspešné prihlásenie
// skončilo fatálnou chybou (Beh #4).
$nulPasswordError = null;
try {
    hashAppPassword("Password1234\0junk");
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

expectSame('sk', languageFromCountryCode('SK'), 'Slovensko sa musí mapovať na slovenčinu');
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

$csrf = generateCsrfToken();
expectTrue(!validateCsrfToken('nespravny-token'), 'Neplatný CSRF token musí byť odmietnutý');
expectSame($csrf, generateCsrfToken(), 'Neplatný CSRF pokus nesmie zneplatniť platný token');
expectTrue(validateCsrfToken($csrf), 'Platný CSRF token musí prejsť');
expectTrue(generateCsrfToken() !== $csrf, 'Platný CSRF token sa musí po použití otočiť');

if ($failures !== []) {
    fwrite(STDERR, "Zlyhané kontroly:\n- " . implode("\n- ", $failures) . "\n");
    exit(1);
}

fwrite(STDOUT, "OK: {$assertions} kontrol prešlo.\n");
