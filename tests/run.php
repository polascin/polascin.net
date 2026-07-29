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
