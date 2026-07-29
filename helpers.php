<?php

declare(strict_types=1);

$requestedScript = str_replace('\\', '/', (string) ($_SERVER['SCRIPT_NAME'] ?? $_SERVER['PHP_SELF'] ?? ''));
$executedFile = isset($_SERVER['SCRIPT_FILENAME']) ? realpath((string) $_SERVER['SCRIPT_FILENAME']) : false;
if (
    $executedFile === __FILE__
    || preg_match('~(?:^|/)helpers\.php(?:/|$)~i', $requestedScript) === 1
) {
    if (PHP_SAPI === 'cli') {
        fwrite(STDERR, "Chyba: helpers.php je interný súbor a nemožno ho spúšťať priamo.\n");
        exit(1);
    }
    header("HTTP/1.1 403 Forbidden");
    exit("Prístup odmietnutý.");
}
unset($requestedScript, $executedFile);

require_once __DIR__ . '/i18n.php';

const APP_PASSWORD_MIN_BYTES = 12;
const APP_PASSWORD_MAX_BYTES = 72;

// Cena bcryptu je pripnutá, nie prevzatá z PASSWORD_DEFAULT: fiktívny hash
// v APP_DUMMY_PASSWORD_HASH musí mať rovnakú cenu ako reálne hashe, inak by
// rozdiel v čase overenia prezradil, či používateľské meno existuje.
const APP_PASSWORD_HASH_COST = 12;

function appPasswordHashOptions(): array {
    return ['cost' => APP_PASSWORD_HASH_COST];
}

function isAppPasswordValid(string $password): bool {
    $length = strlen($password);
    return $length >= APP_PASSWORD_MIN_BYTES
        && $length <= APP_PASSWORD_MAX_BYTES
        && preg_match('/[A-Z]/', $password) === 1
        && preg_match('/[a-z]/', $password) === 1
        && preg_match('/[0-9]/', $password) === 1;
}

function hashAppPassword(string $password): string {
    if (!isAppPasswordValid($password)) {
        throw new \InvalidArgumentException('Heslo nespĺňa bezpečnostné pravidlá.');
    }
    return password_hash($password, PASSWORD_BCRYPT, appPasswordHashOptions());
}

function appTextLength(string $value): int {
    if (function_exists('mb_strlen')) {
        return mb_strlen($value, 'UTF-8');
    }
    if (function_exists('iconv_strlen')) {
        $length = @iconv_strlen($value, 'UTF-8');
        if ($length !== false) {
            return $length;
        }
    }
    return strlen($value);
}

function appTextSlice(string $value, int $offset, ?int $length = null): string {
    if (function_exists('mb_substr')) {
        return $length === null
            ? mb_substr($value, $offset, null, 'UTF-8')
            : mb_substr($value, $offset, $length, 'UTF-8');
    }
    if (function_exists('iconv_substr')) {
        $slice = $length === null
            ? @iconv_substr($value, $offset, appTextLength($value), 'UTF-8')
            : @iconv_substr($value, $offset, $length, 'UTF-8');
        if ($slice !== false) {
            return $slice;
        }
    }
    return $length === null ? substr($value, $offset) : substr($value, $offset, $length);
}

/**
 * Obsahový blok v požadovanom jazyku.
 *
 * Ak blok pre daný jazyk neexistuje, použije sa `$default` — v šablónach je to
 * preložený reťazec z katalógu, takže stránka je kompletná aj bez toho, aby bol
 * každý blok v databáze vyplnený vo všetkých jazykoch.
 */
function getContentBlock(PDO $pdo, string $key, string $default = '', ?string $lang = null): string {
    $lang ??= function_exists('currentLang') ? currentLang() : 'sk';

    try {
        $stmt = $pdo->prepare(
            "SELECT content FROM content_blocks
             WHERE block_key = :key AND lang = :lang AND is_active = 1
             LIMIT 1"
        );
        $stmt->execute([':key' => $key, ':lang' => $lang]);
        $row = $stmt->fetch();
        $content = is_array($row) && !empty($row['content']) ? (string) $row['content'] : $default;
        return html_entity_decode(strip_tags(sanitizeHtmlContent($content)), ENT_QUOTES | ENT_HTML5, 'UTF-8');
    } catch (\PDOException $e) {
        error_log('getContentBlock error: ' . $e->getMessage());
        return html_entity_decode(strip_tags(sanitizeHtmlContent($default)), ENT_QUOTES | ENT_HTML5, 'UTF-8');
    }
}

/**
 * Počet publikovaných článkov v danom jazyku.
 */
function countPublishedArticles(PDO $pdo, ?string $lang = null): int {
    $lang ??= function_exists('currentLang') ? currentLang() : 'sk';

    try {
        $stmt = $pdo->prepare(
            "SELECT COUNT(*) FROM articles
             WHERE is_published = 1 AND published_at IS NOT NULL AND published_at <= NOW()
               AND lang = :lang"
        );
        $stmt->execute([':lang' => $lang]);
        return (int) $stmt->fetchColumn();
    } catch (\PDOException $e) {
        error_log('countPublishedArticles error: ' . $e->getMessage());
        return 0;
    }
}

/**
 * Publikované články v danom jazyku.
 */
function getPublishedArticles(PDO $pdo, int $limit = 10, int $offset = 0, ?string $lang = null): array {
    $lang ??= function_exists('currentLang') ? currentLang() : 'sk';

    try {
        $stmt = $pdo->prepare(
            "SELECT id, title, slug, excerpt, author, lang, translation_group, published_at, updated_at
             FROM articles
             WHERE is_published = 1 AND published_at IS NOT NULL AND published_at <= NOW()
               AND lang = :lang
             ORDER BY is_top DESC, sort_order ASC, published_at DESC
             LIMIT :limit OFFSET :offset"
        );
        $stmt->bindValue(':lang', $lang);
        $stmt->bindValue(':limit', $limit, PDO::PARAM_INT);
        $stmt->bindValue(':offset', $offset, PDO::PARAM_INT);
        $stmt->execute();
        return $stmt->fetchAll();
    } catch (\PDOException $e) {
        error_log('getPublishedArticles error: ' . $e->getMessage());
        return [];
    }
}

/**
 * Zistí, či je riadok článku verejne viditeľný.
 */
function isArticleRowPubliclyVisible(array $row): bool {
    if ((int) ($row['is_published'] ?? 0) !== 1 || empty($row['published_at'])) {
        return false;
    }
    $publishedAt = strtotime((string) $row['published_at']);
    return $publishedAt !== false && $publishedAt <= time();
}

/**
 * Článok podľa slugu.
 *
 * Najprv sa hľadá v požadovanom jazyku. Ak tam taký článok nie je — alebo je, ale
 * nie je verejne viditeľný a volajúci nemá právo vidieť koncepty — hľadá sa rovnaký
 * slug v inom jazyku, aby staré odkazy nekončili na 404. Volajúci podľa `lang`
 * v odpovedi zistí, že ide o inú jazykovú verziu.
 *
 * `$includeUnpublished` zapína administrátorský náhľad: vtedy má verzia v
 * požadovanom jazyku prednosť aj vtedy, keď ešte nie je publikovaná.
 */
function getArticleBySlug(PDO $pdo, string $slug, ?string $lang = null, bool $includeUnpublished = false): ?array {
    $lang ??= function_exists('currentLang') ? currentLang() : 'sk';

    try {
        $columns = "id, title, slug, excerpt, content, author, lang, translation_group,
                    is_published, published_at, updated_at";

        $stmt = $pdo->prepare("SELECT {$columns} FROM articles WHERE slug = :slug AND lang = :lang LIMIT 1");
        $stmt->execute([':slug' => $slug, ':lang' => $lang]);
        $row = $stmt->fetch();
        $requestedRow = is_array($row) ? $row : null;

        if ($requestedRow !== null && ($includeUnpublished || isArticleRowPubliclyVisible($requestedRow))) {
            return $requestedRow;
        }

        // Verejne viditeľná verzia má prednosť pred jazykom: inak by nepublikovaný
        // koncept v požadovanom jazyku prekryl publikovaný preklad a článok by
        // návštevníkovi skončil na 404.
        $fallback = $pdo->prepare(
            "SELECT {$columns} FROM articles
             WHERE slug = :slug
               AND is_published = 1
               AND published_at IS NOT NULL
               AND published_at <= NOW()
             ORDER BY (lang = :default_lang) DESC, id ASC
             LIMIT 1"
        );
        $fallback->execute([':slug' => $slug, ':default_lang' => APP_DEFAULT_LANGUAGE]);
        $row = $fallback->fetch();
        if (is_array($row)) {
            return $row;
        }

        // Nič publikované neexistuje; vracia sa aspoň nájdený koncept, aby si volajúci
        // mohol rozhodnúť o 404 alebo o administrátorskom náhľade.
        return $requestedRow;
    } catch (\PDOException $e) {
        error_log('getArticleBySlug error: ' . $e->getMessage());
        return null;
    }
}

/**
 * Publikované preklady toho istého článku, indexované jazykom.
 *
 * Slúži na prepínač jazyka na detaile článku a na hreflang odkazy.
 */
function getArticleTranslations(PDO $pdo, ?int $translationGroup): array {
    if ($translationGroup === null) {
        return [];
    }

    try {
        $stmt = $pdo->prepare(
            "SELECT slug, lang FROM articles
             WHERE translation_group = :group
               AND is_published = 1 AND published_at IS NOT NULL AND published_at <= NOW()"
        );
        $stmt->bindValue(':group', $translationGroup, PDO::PARAM_INT);
        $stmt->execute();

        $translations = [];
        foreach ($stmt->fetchAll() as $row) {
            $rowLang = (string) ($row['lang'] ?? '');
            if ($rowLang !== '') {
                $translations[$rowLang] = (string) ($row['slug'] ?? '');
            }
        }
        return $translations;
    } catch (\PDOException $e) {
        error_log('getArticleTranslations error: ' . $e->getMessage());
        return [];
    }
}

function formatArticleDate(?string $datetime, ?string $lang = null): string {
    if (empty($datetime)) {
        return '';
    }
    $lang ??= function_exists('currentLang') ? currentLang() : APP_DEFAULT_LANGUAGE;

    try {
        $dt = new DateTimeImmutable($datetime, new DateTimeZone(date_default_timezone_get() ?: 'Europe/Bratislava'));
        return formatLocalizedDate($dt, $lang);
    } catch (\Throwable) {
        return (string) $datetime;
    }
}

function buildSeoExcerpt(string $text, int $maxLen = 170): string {
    $decoded = html_entity_decode($text, ENT_QUOTES | ENT_HTML5, 'UTF-8');
    $stripped = strip_tags($decoded);
    $normalized = preg_replace('/\s+/u', ' ', $stripped) ?? $stripped;
    $normalized = trim($normalized);
    if ($normalized === '') {
        return '';
    }
    if (appTextLength($normalized) <= $maxLen) {
        return $normalized;
    }
    $slice = appTextSlice($normalized, 0, $maxLen + 1);
    $slice = preg_replace('/\s+\S*$/u', '', $slice) ?? $slice;
    $slice = rtrim($slice, " \t\n\r\0\x0B,.;:-");
    return $slice . '…';
}

function normalizeSafeContentUrl(string $value, string $attribute): ?string {
    $decoded = html_entity_decode($value, ENT_QUOTES | ENT_HTML5, 'UTF-8');
    $trimmed = trim($decoded, " \t\n\r\0\x0B");
    if ($trimmed === '') {
        return null;
    }

    // Schéma sa posudzuje z hodnoty bez bielych a riadiacich znakov, inak by
    // `java&#9;script:` alebo `java script:` prešlo cez kontrolu.
    $compact = preg_replace('/[\x00-\x20\x7F]+/u', '', $trimmed);
    if (!is_string($compact) || $compact === '') {
        return null;
    }

    // Vracia sa pôvodná hodnota len bez riadiacich znakov, ktoré prehliadače aj tak
    // z URL odstraňujú. Medzery sa zachovávajú, aby zostali funkčné odkazy typu
    // `https://example.com/môj súbor.pdf`.
    $normalized = preg_replace('/[\x00-\x1F\x7F]+/u', '', $trimmed);
    if (!is_string($normalized) || $normalized === '') {
        return null;
    }

    if (!preg_match('/^([a-z][a-z0-9+.-]*):/i', $compact, $matches)) {
        return $normalized;
    }
    $scheme = strtolower($matches[1]);
    $allowedSchemes = $attribute === 'href'
        ? ['http', 'https', 'mailto', 'tel']
        : ['http', 'https'];
    return in_array($scheme, $allowedSchemes, true) ? $normalized : null;
}

function copySanitizedHtmlChildren(DOMNode $source, DOMNode $destination, DOMDocument $cleanDom): void {
    $allowedTags = [
        'p', 'br', 'hr', 'h2', 'h3', 'h4', 'h5', 'h6',
        'strong', 'b', 'em', 'i', 'u', 'ul', 'ol', 'li',
        'blockquote', 'a', 'span', 'img', 'div',
    ];
    $dropWithContents = [
        'script', 'style', 'iframe', 'object', 'embed', 'template',
        'svg', 'math', 'noscript',
    ];
    $allowedGlobalAttrs = ['class', 'id', 'title'];
    $allowedTagAttrs = [
        'a' => ['href'],
        'img' => ['src', 'alt', 'title', 'loading'],
    ];

    foreach ($source->childNodes as $child) {
        if ($child->nodeType === XML_TEXT_NODE || $child->nodeType === XML_CDATA_SECTION_NODE) {
            $destination->appendChild($cleanDom->createTextNode((string) $child->nodeValue));
            continue;
        }

        if (!$child instanceof DOMElement) {
            continue;
        }

        $tag = strtolower($child->tagName);
        if (in_array($tag, $dropWithContents, true)) {
            continue;
        }

        if (!in_array($tag, $allowedTags, true)) {
            copySanitizedHtmlChildren($child, $destination, $cleanDom);
            continue;
        }

        // Vždy vytvoríme nový HTML strom. Nekopírujeme pôvodné uzly, preto sa
        // obsah z cudzích namespace (SVG/MathML) nemôže po serializácii zmeniť
        // na nový spustiteľný HTML atribút (mutation XSS).
        $cleanElement = $cleanDom->createElement($tag);
        $allowedAttrs = array_merge($allowedGlobalAttrs, $allowedTagAttrs[$tag] ?? []);

        foreach ($allowedAttrs as $name) {
            if (!$child->hasAttribute($name)) {
                continue;
            }

            $value = $child->getAttribute($name);
            if ($name === 'href' || $name === 'src') {
                $safeUrl = normalizeSafeContentUrl($value, $name);
                if ($safeUrl === null) {
                    continue;
                }
                $value = $safeUrl;
            } elseif ($name === 'class' && preg_match('/^[a-z0-9 _-]{1,200}$/i', $value) !== 1) {
                continue;
            } elseif ($name === 'id' && preg_match('/^[a-z][a-z0-9_-]{0,99}$/i', $value) !== 1) {
                continue;
            } elseif ($name === 'loading' && !in_array(strtolower($value), ['eager', 'lazy'], true)) {
                continue;
            }

            $cleanElement->setAttribute($name, $value);
        }

        if ($tag === 'img') {
            if (!$cleanElement->hasAttribute('alt')) {
                $cleanElement->setAttribute('alt', '');
            }
            if (!$cleanElement->hasAttribute('loading')) {
                $cleanElement->setAttribute('loading', 'lazy');
            }
        }

        $destination->appendChild($cleanElement);
        if (!in_array($tag, ['br', 'hr', 'img'], true)) {
            copySanitizedHtmlChildren($child, $cleanElement, $cleanDom);
        }
    }
}

function sanitizeHtmlContent(string $html): string {
    if (trim($html) === '') {
        return '';
    }
    if (!class_exists(DOMDocument::class)) {
        return htmlspecialchars(strip_tags($html), ENT_QUOTES | ENT_HTML5, 'UTF-8');
    }

    $dom = new DOMDocument('1.0', 'UTF-8');
    $prevUseInternalErrors = libxml_use_internal_errors(true);

    // Obsah sa nezabaľuje do <div>: prvé nepárové </div> vo vstupe by taký obal
    // predčasne uzavrelo a všetko za ním by sa ticho zahodilo. <body> uzavrieť nemožno.
    $wrapped = '<html><head><meta http-equiv="Content-Type" content="text/html; charset=utf-8"></head><body>' . $html . '</body></html>';
    $loaded = $dom->loadHTML($wrapped, LIBXML_HTML_NODEFDTD);
    libxml_clear_errors();
    libxml_use_internal_errors($prevUseInternalErrors);

    if (!$loaded) {
        return htmlspecialchars(strip_tags($html), ENT_QUOTES | ENT_HTML5, 'UTF-8');
    }

    $container = $dom->getElementsByTagName('body')->item(0);
    if (!$container instanceof DOMElement) {
        return htmlspecialchars(strip_tags($html), ENT_QUOTES | ENT_HTML5, 'UTF-8');
    }

    $cleanDom = new DOMDocument('1.0', 'UTF-8');
    $cleanContainer = $cleanDom->createElement('div');
    $cleanDom->appendChild($cleanContainer);
    copySanitizedHtmlChildren($container, $cleanContainer, $cleanDom);

    $result = '';
    foreach ($cleanContainer->childNodes as $child) {
        $result .= $cleanDom->saveHTML($child);
    }

    return trim($result);
}

function slugify(string $text): string {
    $text = trim($text);
    $transliterated = function_exists('iconv')
        ? @iconv('UTF-8', 'ASCII//TRANSLIT//IGNORE', $text)
        : false;
    if (is_string($transliterated) && $transliterated !== '') {
        $text = $transliterated;
    }
    $text = strtolower($text);
    $text = preg_replace('/[^a-z0-9\s-]/', '', $text) ?? $text;
    $text = preg_replace('/\s+/', '-', $text) ?? $text;
    $text = preg_replace('/-+/', '-', $text) ?? $text;
    return trim($text, '-');
}
