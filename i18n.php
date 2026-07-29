<?php

declare(strict_types=1);

$requestedScript = str_replace('\\', '/', (string) ($_SERVER['SCRIPT_NAME'] ?? $_SERVER['PHP_SELF'] ?? ''));
$executedFile = isset($_SERVER['SCRIPT_FILENAME']) ? realpath((string) $_SERVER['SCRIPT_FILENAME']) : false;
if (
    $executedFile === __FILE__
    || preg_match('~(?:^|/)i18n\.php(?:/|$)~i', $requestedScript) === 1
) {
    if (PHP_SAPI === 'cli') {
        fwrite(STDERR, "Chyba: i18n.php je interný súbor a nemožno ho spúšťať priamo.\n");
        exit(1);
    }
    http_response_code(403);
    exit('Prístup odmietnutý.');
}
unset($requestedScript, $executedFile);

const APP_DEFAULT_LANGUAGE = 'sk';
const APP_LANGUAGE_COOKIE = 'polascin_lang';
const APP_LANGUAGE_COOKIE_LIFETIME = 31536000;

/**
 * Podporované jazyky. Poradie určuje poradie v prepínači jazykov.
 *
 * - `native`  názov jazyka v danom jazyku (prepínač sa nikdy neprekladá)
 * - `locale`  hodnota pre `og:locale` a `hreflang` regionálne varianty
 * - `label`   prístupný názov pre čítačky obrazovky
 */
function appLanguages(): array {
    static $languages = [
        'sk' => ['native' => 'Slovenčina', 'locale' => 'sk_SK', 'label' => 'Slovensky'],
        'en' => ['native' => 'English', 'locale' => 'en_US', 'label' => 'English'],
        'cs' => ['native' => 'Čeština', 'locale' => 'cs_CZ', 'label' => 'Česky'],
        'de' => ['native' => 'Deutsch', 'locale' => 'de_DE', 'label' => 'Deutsch'],
        'fr' => ['native' => 'Français', 'locale' => 'fr_FR', 'label' => 'Français'],
        'es' => ['native' => 'Español', 'locale' => 'es_ES', 'label' => 'Español'],
    ];
    return $languages;
}

function isSupportedLanguage(string $lang): bool {
    return isset(appLanguages()[$lang]);
}

/**
 * Normalizuje jazykovú značku (`en-GB`, `EN_us`) na podporovaný dvojpísmenový kód.
 */
function normalizeLanguageTag(string $tag): ?string {
    $tag = strtolower(trim($tag));
    if ($tag === '') {
        return null;
    }
    $primary = preg_split('/[-_]/', $tag)[0] ?? '';
    if (!is_string($primary) || preg_match('/^[a-z]{2,3}$/D', $primary) !== 1) {
        return null;
    }
    return isSupportedLanguage($primary) ? $primary : null;
}

/**
 * Jazyk odvodený z hlavičky Accept-Language podľa váh (`q=`).
 */
function languageFromAcceptHeader(?string $header): ?string {
    if (!is_string($header) || trim($header) === '') {
        return null;
    }

    $candidates = [];
    foreach (explode(',', $header) as $index => $part) {
        $segments = explode(';', $part);
        $tag = trim((string) array_shift($segments));
        if ($tag === '' || $tag === '*') {
            continue;
        }

        $quality = 1.0;
        foreach ($segments as $segment) {
            $segment = trim($segment);
            if (stripos($segment, 'q=') === 0) {
                $parsed = filter_var(substr($segment, 2), FILTER_VALIDATE_FLOAT);
                $quality = $parsed === false ? 0.0 : max(0.0, min(1.0, (float) $parsed));
            }
        }

        $normalized = normalizeLanguageTag($tag);
        if ($normalized === null || $quality <= 0.0) {
            continue;
        }
        // Pri rovnakej váhe rozhoduje poradie v hlavičke.
        $candidates[] = ['lang' => $normalized, 'q' => $quality, 'order' => $index];
    }

    if ($candidates === []) {
        return null;
    }

    usort($candidates, static function (array $a, array $b): int {
        return $b['q'] <=> $a['q'] ?: $a['order'] <=> $b['order'];
    });

    return $candidates[0]['lang'];
}

/**
 * Mapovanie krajiny na jazyk. Používa sa len ako záloha, keď prehliadač
 * jazyk neposlal — geolokácia je menej spoľahlivá než explicitné nastavenie.
 */
function languageFromCountryCode(?string $countryCode): ?string {
    if (!is_string($countryCode) || preg_match('/^[A-Za-z]{2}$/D', trim($countryCode)) !== 1) {
        return null;
    }

    $map = [
        'SK' => 'sk',
        'CZ' => 'cs',
        'DE' => 'de', 'AT' => 'de', 'CH' => 'de', 'LI' => 'de',
        'FR' => 'fr', 'BE' => 'fr', 'LU' => 'fr', 'MC' => 'fr',
        'ES' => 'es', 'MX' => 'es', 'AR' => 'es', 'CO' => 'es', 'CL' => 'es',
        'PE' => 'es', 'VE' => 'es', 'EC' => 'es', 'UY' => 'es', 'PY' => 'es',
        'BO' => 'es', 'CR' => 'es', 'PA' => 'es', 'DO' => 'es', 'GT' => 'es',
        'HN' => 'es', 'NI' => 'es', 'SV' => 'es', 'CU' => 'es', 'PR' => 'es',
        'GB' => 'en', 'US' => 'en', 'IE' => 'en', 'CA' => 'en', 'AU' => 'en',
        'NZ' => 'en', 'ZA' => 'en', 'IN' => 'en',
    ];

    $code = strtoupper(trim($countryCode));
    return isset($map[$code]) && isSupportedLanguage($map[$code]) ? $map[$code] : null;
}

/**
 * Kód krajiny z hlavičiek, ktoré pridávajú bežné CDN a hostingy.
 */
function detectCountryCode(): ?string {
    $headers = [
        'HTTP_CF_IPCOUNTRY',
        'HTTP_X_GEOIP_COUNTRY',
        'HTTP_X_COUNTRY_CODE',
        'GEOIP_COUNTRY_CODE',
    ];
    foreach ($headers as $header) {
        $value = $_SERVER[$header] ?? null;
        if (is_string($value) && preg_match('/^[A-Za-z]{2}$/D', trim($value)) === 1) {
            $code = strtoupper(trim($value));
            // Cloudflare posiela XX pre neznámu a T1 pre Tor.
            if (!in_array($code, ['XX', 'T1'], true)) {
                return $code;
            }
        }
    }
    return null;
}

/**
 * Zistí jazyk požiadavky. Poradie zdrojov od najsilnejšieho:
 * explicitná voľba v URL → uložená voľba v cookie → nastavenie prehliadača →
 * krajina podľa CDN hlavičky → predvolený jazyk.
 */
function detectAppLanguage(): string {
    $requested = isset($_GET['lang']) && is_string($_GET['lang']) ? normalizeLanguageTag($_GET['lang']) : null;
    if ($requested !== null) {
        return $requested;
    }

    $stored = isset($_COOKIE[APP_LANGUAGE_COOKIE]) && is_string($_COOKIE[APP_LANGUAGE_COOKIE])
        ? normalizeLanguageTag($_COOKIE[APP_LANGUAGE_COOKIE])
        : null;
    if ($stored !== null) {
        return $stored;
    }

    $fromBrowser = languageFromAcceptHeader($_SERVER['HTTP_ACCEPT_LANGUAGE'] ?? null);
    if ($fromBrowser !== null) {
        return $fromBrowser;
    }

    $fromCountry = languageFromCountryCode(detectCountryCode());
    if ($fromCountry !== null) {
        return $fromCountry;
    }

    return APP_DEFAULT_LANGUAGE;
}

/**
 * Aktuálny jazyk požiadavky. Voľba z URL sa uloží do cookie, aby platila
 * aj na ďalších stránkach bez parametra.
 */
function currentLang(): string {
    static $current = null;
    if ($current !== null) {
        return $current;
    }

    $current = detectAppLanguage();

    $explicit = isset($_GET['lang']) && is_string($_GET['lang']) ? normalizeLanguageTag($_GET['lang']) : null;
    $stored = isset($_COOKIE[APP_LANGUAGE_COOKIE]) && is_string($_COOKIE[APP_LANGUAGE_COOKIE])
        ? normalizeLanguageTag($_COOKIE[APP_LANGUAGE_COOKIE])
        : null;

    if ($explicit !== null && $explicit !== $stored && PHP_SAPI !== 'cli' && !headers_sent()) {
        setcookie(APP_LANGUAGE_COOKIE, $explicit, [
            'expires' => time() + APP_LANGUAGE_COOKIE_LIFETIME,
            'path' => '/',
            'secure' => function_exists('isRequestHttps') ? isRequestHttps() : false,
            // Cookie číta iba server; JavaScript ju nepotrebuje.
            'httponly' => true,
            'samesite' => 'Lax',
        ]);
        $_COOKIE[APP_LANGUAGE_COOKIE] = $explicit;
    }

    return $current;
}

function currentLocale(): string {
    $languages = appLanguages();
    return $languages[currentLang()]['locale'] ?? 'sk_SK';
}

/**
 * Načíta katalóg prekladov pre daný jazyk.
 */
function loadTranslations(string $lang): array {
    static $cache = [];
    if (isset($cache[$lang])) {
        return $cache[$lang];
    }

    $cache[$lang] = [];
    if (!isSupportedLanguage($lang)) {
        return $cache[$lang];
    }

    $file = __DIR__ . '/lang/' . $lang . '.php';
    if (is_file($file)) {
        $loaded = require $file;
        if (is_array($loaded)) {
            $cache[$lang] = $loaded;
        }
    }

    return $cache[$lang];
}

/**
 * Preloží kľúč do aktuálneho jazyka.
 *
 * Ak preklad chýba, použije sa predvolený jazyk a až potom samotný kľúč, takže
 * chýbajúci reťazec nikdy nespôsobí prázdne miesto v rozhraní.
 * Zástupné znaky sa zapisujú ako `:meno`.
 */
function t(string $key, array $params = [], ?string $lang = null): string {
    $lang ??= currentLang();

    $translations = loadTranslations($lang);
    $value = $translations[$key] ?? null;

    if (!is_string($value) && $lang !== APP_DEFAULT_LANGUAGE) {
        $fallback = loadTranslations(APP_DEFAULT_LANGUAGE);
        $value = $fallback[$key] ?? null;
    }

    if (!is_string($value)) {
        $value = $key;
    }

    if ($params !== []) {
        $replacements = [];
        foreach ($params as $name => $replacement) {
            $replacements[':' . $name] = (string) $replacement;
        }
        $value = strtr($value, $replacements);
    }

    return $value;
}

/**
 * Preložený reťazec pripravený na priamy výpis do HTML.
 */
function te(string $key, array $params = [], ?string $lang = null): string {
    return htmlspecialchars(t($key, $params, $lang), ENT_QUOTES, 'UTF-8');
}

/**
 * Zostaví URL aktuálnej stránky v inom jazyku.
 *
 * Produkcia beží na OpenResty, ktorý neaplikuje `.htaccess`, takže jazyk sa
 * nesie v query parametri — funguje bez akéhokoľvek prepisu na strane servera
 * a zároveň dáva každej jazykovej verzii vlastnú indexovateľnú URL.
 */
function langUrl(string $lang, ?string $path = null, array $extraParams = []): string {
    $lang = isSupportedLanguage($lang) ? $lang : APP_DEFAULT_LANGUAGE;

    if ($path === null) {
        $script = basename((string) ($_SERVER['SCRIPT_NAME'] ?? 'index.php'));
        $path = $script === '' ? 'index.php' : $script;

        $query = $_GET;
        unset($query['lang']);
        $extraParams = array_merge($query, $extraParams);
    }

    $params = array_merge($extraParams, ['lang' => $lang]);
    $params = array_filter($params, static fn($value) => is_scalar($value) && (string) $value !== '');

    $pairs = [];
    foreach ($params as $name => $value) {
        if (!is_string($name) || preg_match('/^[A-Za-z0-9_\-]{1,32}$/D', $name) !== 1) {
            continue;
        }
        $pairs[] = rawurlencode($name) . '=' . rawurlencode((string) $value);
    }

    return $path . ($pairs === [] ? '' : '?' . implode('&', $pairs));
}

/**
 * Absolútna URL stránky v danom jazyku — pre canonical, hreflang a og:url.
 *
 * Na rozdiel od `langUrl()` sa pri predvolenom jazyku parameter `lang`
 * vynecháva a domovská stránka sa zapisuje ako koreň. Prepínač jazyka musí
 * parameter uvádzať vždy (inak by sa nedalo prepnúť späť), ale kanonická URL
 * má byť čo najkratšia a stabilná.
 */
function absoluteLangUrl(string $lang, string $path, array $extraParams = []): string {
    $lang = isSupportedLanguage($lang) ? $lang : APP_DEFAULT_LANGUAGE;
    $baseUrl = function_exists('getAppBaseUrl') ? rtrim(getAppBaseUrl(), '/') : '';

    $isHome = $path === 'index.php' || $path === '' || $path === '/';
    $params = $extraParams;
    if ($lang !== APP_DEFAULT_LANGUAGE) {
        $params['lang'] = $lang;
    } else {
        unset($params['lang']);
    }

    $pairs = [];
    foreach ($params as $name => $value) {
        if (!is_string($name) || preg_match('/^[A-Za-z0-9_\-]{1,32}$/D', $name) !== 1) {
            continue;
        }
        if (!is_scalar($value) || (string) $value === '') {
            continue;
        }
        $pairs[] = rawurlencode($name) . '=' . rawurlencode((string) $value);
    }

    $query = $pairs === [] ? '' : '?' . implode('&', $pairs);
    return $baseUrl . '/' . ($isHome ? '' : ltrim($path, '/')) . $query;
}

/**
 * Názvy mesiacov v genitíve/tvare používanom v dátumoch pre jednotlivé jazyky.
 */
function localizedMonthNames(string $lang): array {
    static $months = [
        'sk' => ['januára', 'februára', 'marca', 'apríla', 'mája', 'júna', 'júla', 'augusta', 'septembra', 'októbra', 'novembra', 'decembra'],
        'cs' => ['ledna', 'února', 'března', 'dubna', 'května', 'června', 'července', 'srpna', 'září', 'října', 'listopadu', 'prosince'],
        'en' => ['January', 'February', 'March', 'April', 'May', 'June', 'July', 'August', 'September', 'October', 'November', 'December'],
        'de' => ['Januar', 'Februar', 'März', 'April', 'Mai', 'Juni', 'Juli', 'August', 'September', 'Oktober', 'November', 'Dezember'],
        'fr' => ['janvier', 'février', 'mars', 'avril', 'mai', 'juin', 'juillet', 'août', 'septembre', 'octobre', 'novembre', 'décembre'],
        'es' => ['enero', 'febrero', 'marzo', 'abril', 'mayo', 'junio', 'julio', 'agosto', 'septiembre', 'octubre', 'noviembre', 'diciembre'],
    ];
    return $months[$lang] ?? $months[APP_DEFAULT_LANGUAGE];
}

/**
 * Dátum naformátovaný podľa zvyklostí daného jazyka.
 */
function formatLocalizedDate(DateTimeInterface $date, string $lang): string {
    $day = (int) $date->format('j');
    $month = localizedMonthNames($lang)[(int) $date->format('n') - 1] ?? '';
    $year = $date->format('Y');

    return match ($lang) {
        'en' => $month . ' ' . $day . ', ' . $year,
        'de' => $day . '. ' . $month . ' ' . $year,
        'fr' => $day . ' ' . $month . ' ' . $year,
        // Španielčina vkladá medzi zložky dátumu predložku „de“.
        'es' => $day . ' de ' . $month . ' de ' . $year,
        default => $day . '. ' . $month . ' ' . $year,
    };
}
