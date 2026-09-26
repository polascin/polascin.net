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

/**
 * Swatch Internet Time (BMT = UTC+1, 1 deň = 1000 beatov) pre daný unix čas.
 *
 * Stotiny sa orezávajú nadol celočíselnou aritmetikou (1 beat = 86,4 s, teda
 * 0,01 beatu = 864 ms) — zaokrúhlenie nahor by na konci dňa zobrazilo
 * neplatné @1000.00. Rovnakú aritmetiku používa živý prepočet v js/main.js.
 */
function appSwatchBeat(int $timestamp): string {
    $bmtSeconds = ((($timestamp + 3600) % 86400) + 86400) % 86400;
    $beatHundredths = intdiv($bmtSeconds * 1000, 864);
    return sprintf('@%d.%02d', intdiv($beatHundredths, 100), $beatHundredths % 100);
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
            "SELECT id, title, slug, excerpt, image, image_alt, author, lang, translation_group,
                    published_at, updated_at
             FROM articles
             WHERE is_published = 1 AND published_at IS NOT NULL AND published_at <= NOW()
               AND lang = :lang
             ORDER BY is_top DESC, published_at DESC, id DESC
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
        // `image` a `image_alt` musia byť v SELECTe: bez nich sa obálka hľadá len
        // podľa názvu súboru zhodného so slugom a jazykovo špecifický alt text
        // uložený migráciou `2026091705_article_cover_images` sa nikdy nepoužije.
        $columns = "id, title, slug, excerpt, image, image_alt, content, author, lang, translation_group,
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

/**
 * Relatívna cesta obalového obrázka článku. Povolené sú len súbory
 * v `images/articles/` s bezpečným názvom — žiadne `../` ani cudzie schémy.
 */
function normalizeArticleCoverPath(string $path): ?string {
    $path = str_replace('\\', '/', trim($path));
    if (preg_match('#^images/articles/[a-z0-9-]+\.(webp|png|jpe?g)$#D', $path) !== 1) {
        return null;
    }
    return $path;
}

function articleCoverSrc(?string $image, ?string $slug = null): ?string {
    $path = normalizeArticleCoverPath((string) $image);
    if ($path !== null && is_file(__DIR__ . '/' . $path)) {
        return $path;
    }
    $slug = (string) $slug;
    if (preg_match('/^[a-z0-9-]+$/D', $slug) === 1) {
        $fallback = 'images/articles/' . $slug . '.webp';
        if (is_file(__DIR__ . '/' . $fallback)) {
            return $fallback;
        }
    }
    return null;
}

/**
 * Obálky dostupné na disku — ponuka pre admin formulár. Zoznam sa berie zo
 * súborov, nie od používateľa, takže do stĺpca `image` sa nedá zapísať cesta,
 * ktorú by `normalizeArticleCoverPath()` odmietla.
 *
 * @return list<string>
 */
function availableArticleCovers(): array {
    // Zámerne bez `GLOB_BRACE` — nie je všade dostupné. Filtruje sa tým istým
    // pravidlom, aké platí pre stĺpec `image`, takže ponuka a validácia
    // nemôžu povedať niečo iné.
    $found = glob(__DIR__ . '/images/articles/*');
    if ($found === false) {
        return [];
    }
    $covers = [];
    foreach ($found as $file) {
        if (!is_file($file)) {
            continue;
        }
        $path = normalizeArticleCoverPath('images/articles/' . basename($file));
        if ($path !== null) {
            $covers[] = $path;
        }
    }
    sort($covers);
    return $covers;
}

/**
 * Obálka pre Open Graph a Twitter Card.
 *
 * Na stránke sa podáva WebP, lebo je menší, ale zdieľanie ho nezvládne všade —
 * LinkedIn WebP náhľad historicky nezobrazí vôbec. Ak teda ku WebP existuje
 * JPEG odvodenina z `scripts/make_og_covers.php`, do `og:image` ide ona.
 * Inak sa vracia pôvodná cesta, takže absencia JPEGu nič nerozbije.
 */
function articleCoverSocialSrc(?string $image, ?string $slug = null): ?string {
    $src = articleCoverSrc($image, $slug);
    if ($src === null) {
        return null;
    }
    if (!str_ends_with($src, '.webp')) {
        return $src;
    }
    $jpeg = 'images/articles/og/' . basename($src, '.webp') . '.jpg';
    return is_file(__DIR__ . '/' . $jpeg) ? $jpeg : $src;
}

function articleCoverHtml(array $article, string $class, bool $lazy = true, bool $decorative = false): string {
    $src = articleCoverSrc(
        isset($article['image']) ? (string) $article['image'] : null,
        isset($article['slug']) ? (string) $article['slug'] : null
    );
    if ($src === null) {
        return '';
    }
    $info = @getimagesize(__DIR__ . '/' . $src);
    $width = is_array($info) ? (int) $info[0] : 1280;
    $height = is_array($info) ? (int) $info[1] : 720;
    $alt = $decorative ? '' : trim((string) ($article['image_alt'] ?? $article['title'] ?? ''));
    $loading = $lazy ? 'lazy' : 'eager';
    return '<img class="' . htmlspecialchars($class, ENT_QUOTES, 'UTF-8')
        . '" src="' . htmlspecialchars($src, ENT_QUOTES, 'UTF-8')
        . '" alt="' . htmlspecialchars($alt, ENT_QUOTES, 'UTF-8')
        . '" width="' . $width . '" height="' . $height
        . '" loading="' . $loading . '" decoding="async">';
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

const LIBRARY_UPLOAD_MAX_BYTES = 41943040;
const LIBRARY_TEXT_RENDER_MAX_BYTES = 1572864;

/**
 * Koreňové priečinky knižnice.
 *
 * `shipped` ide s repozitárom a nasadením. `uploads` je v `private/`, ktorý
 * rsync pri nasadení nemaže, takže text pridaný v administrácii na serveri
 * zostane.
 *
 * @return array{shipped: string, uploads: string}
 */
function libraryRoots(): array {
    $override = $GLOBALS['__library_roots_override'] ?? null;
    if (is_array($override)) {
        /** @var array{shipped: string, uploads: string} $override */
        return $override;
    }

    return [
        'shipped' => __DIR__ . '/content/library',
        'uploads' => __DIR__ . '/private/library',
    ];
}

/**
 * @param array{shipped: string, uploads: string}|null $roots
 */
function libraryUseRoots(?array $roots): void {
    if ($roots === null) {
        unset($GLOBALS['__library_roots_override']);
        return;
    }
    $GLOBALS['__library_roots_override'] = $roots;
}

/**
 * @return array<string, array{mime: string, kind: string}>
 */
function libraryFileTypes(): array {
    return [
        'pdf' => ['mime' => 'application/pdf', 'kind' => 'pdf'],
        'txt' => ['mime' => 'text/plain; charset=UTF-8', 'kind' => 'text'],
        'md' => ['mime' => 'text/plain; charset=UTF-8', 'kind' => 'text'],
        'markdown' => ['mime' => 'text/plain; charset=UTF-8', 'kind' => 'text'],
        'html' => ['mime' => 'text/html; charset=UTF-8', 'kind' => 'html'],
        'htm' => ['mime' => 'text/html; charset=UTF-8', 'kind' => 'html'],
        'epub' => ['mime' => 'application/epub+zip', 'kind' => 'epub'],
    ];
}

function libraryIsSlug(string $slug): bool {
    return preg_match('/^[a-z0-9](?:[a-z0-9-]{0,62}[a-z0-9])?$/D', $slug) === 1;
}

function libraryPathIsInside(string $rootReal, string $pathReal): bool {
    $rootReal = rtrim(str_replace('\\', '/', $rootReal), '/');
    $pathReal = str_replace('\\', '/', $pathReal);
    if (DIRECTORY_SEPARATOR === '\\') {
        $rootReal = strtolower($rootReal);
        $pathReal = strtolower($pathReal);
    }

    return $pathReal === $rootReal || str_starts_with($pathReal, $rootReal . '/');
}

function libraryIniBytes(string $value): int {
    $value = trim($value);
    if ($value === '' || preg_match('/^(\d+)([KMG])?$/i', $value, $matches) !== 1) {
        return 0;
    }
    $bytes = (int) $matches[1];
    $unit = strtoupper($matches[2] ?? '');
    if ($unit === 'G') {
        return $bytes * 1073741824;
    }
    if ($unit === 'M') {
        return $bytes * 1048576;
    }
    if ($unit === 'K') {
        return $bytes * 1024;
    }

    return $bytes;
}

function libraryUploadLimitBytes(): int {
    $limit = LIBRARY_UPLOAD_MAX_BYTES;
    foreach (['upload_max_filesize', 'post_max_size'] as $iniKey) {
        $iniBytes = libraryIniBytes((string) ini_get($iniKey));
        if ($iniBytes > 0 && $iniBytes < $limit) {
            $limit = $iniBytes;
        }
    }

    return $limit;
}

function libraryFormatSize(int $bytes): string {
    if ($bytes < 1024) {
        return $bytes . ' B';
    }
    if ($bytes < 1048576) {
        return number_format($bytes / 1024, 0, '.', ' ') . ' kB';
    }

    return number_format($bytes / 1048576, 1, '.', ' ') . ' MB';
}

function libraryIsUtf8(string $value): bool {
    return preg_match('//u', $value) === 1;
}

function libraryToUtf8(string $raw): string {
    if (str_starts_with($raw, "\xEF\xBB\xBF")) {
        $raw = substr($raw, 3);
    }
    if (libraryIsUtf8($raw)) {
        return $raw;
    }
    $converted = function_exists('iconv')
        ? @iconv('Windows-1250', 'UTF-8//IGNORE', $raw)
        : false;

    return is_string($converted) && $converted !== '' ? $converted : $raw;
}

function librarySampleLooksValid(string $sample, string $extension): bool {
    if ($sample === '') {
        return false;
    }
    $extension = strtolower($extension);
    if ($extension === 'pdf') {
        return str_starts_with($sample, '%PDF-');
    }
    if ($extension === 'epub') {
        return str_starts_with($sample, "PK\x03\x04");
    }
    if (!isset(libraryFileTypes()[$extension])) {
        return false;
    }

    return !str_contains($sample, "\0");
}

function libraryFileLooksValid(string $path, string $extension): bool {
    $handle = @fopen($path, 'rb');
    if ($handle === false) {
        return false;
    }
    $sample = fread($handle, 8192);
    fclose($handle);

    return is_string($sample) && librarySampleLooksValid($sample, $extension);
}

/**
 * @return array<string, mixed>|null
 */
function libraryLoadWork(string $directory, string $source): ?array {
    $slug = basename(str_replace('\\', '/', $directory));
    if (!libraryIsSlug($slug) || ($source !== 'shipped' && $source !== 'uploads')) {
        return null;
    }

    $metaPath = $directory . DIRECTORY_SEPARATOR . 'work.json';
    if (!is_file($metaPath) || is_link($metaPath)) {
        return null;
    }
    $rawMeta = file_get_contents($metaPath);
    if (!is_string($rawMeta) || trim($rawMeta) === '') {
        return null;
    }
    try {
        $meta = json_decode($rawMeta, true, 16, JSON_THROW_ON_ERROR);
    } catch (JsonException) {
        return null;
    }
    if (!is_array($meta)) {
        return null;
    }

    $title = trim(str_replace(["\0", "\r"], '', (string) ($meta['title'] ?? '')));
    if ($title === '' || appTextLength($title) > 255 || !libraryIsUtf8($title)) {
        return null;
    }
    $author = trim(str_replace(["\0", "\r"], '', (string) ($meta['author'] ?? '')));
    $description = trim(str_replace(["\0", "\r"], '', (string) ($meta['description'] ?? '')));
    if (
        appTextLength($author) > 255
        || appTextLength($description) > 4000
        || !libraryIsUtf8($author)
        || !libraryIsUtf8($description)
    ) {
        return null;
    }

    $filename = (string) ($meta['filename'] ?? '');
    if ($filename === '' || basename(str_replace('\\', '/', $filename)) !== $filename || str_contains($filename, "\0")) {
        return null;
    }
    $extension = strtolower(pathinfo($filename, PATHINFO_EXTENSION));
    $types = libraryFileTypes();
    if (!isset($types[$extension])) {
        return null;
    }

    $filePath = $directory . DIRECTORY_SEPARATOR . $filename;
    if (!is_file($filePath) || is_link($filePath)) {
        return null;
    }
    $rootReal = realpath(dirname($directory));
    $directoryReal = realpath($directory);
    $fileReal = realpath($filePath);
    if (
        $rootReal === false
        || $directoryReal === false
        || $fileReal === false
        || !libraryPathIsInside($rootReal, $directoryReal)
        || !libraryPathIsInside($directoryReal, $fileReal)
    ) {
        return null;
    }

    $bytes = filesize($fileReal);
    if ($bytes === false || $bytes < 1) {
        return null;
    }
    if (!libraryFileLooksValid($fileReal, $extension)) {
        return null;
    }

    $addedAt = (string) ($meta['added_at'] ?? '');
    if (preg_match('/^\d{4}-\d{2}-\d{2}$/D', $addedAt) !== 1) {
        $addedAt = date('Y-m-d', (int) filemtime($fileReal));
    }

    $originalName = trim(str_replace(["\0", "\r", "\n", '"', '\\', '/'], '', (string) ($meta['original_name'] ?? '')));

    return [
        'slug' => $slug,
        'title' => $title,
        'author' => $author,
        'description' => $description,
        'added_at' => $addedAt,
        'filename' => $filename,
        'original_name' => $originalName,
        'extension' => $extension,
        'kind' => $types[$extension]['kind'],
        'mime' => $types[$extension]['mime'],
        'bytes' => (int) $bytes,
        'path' => $fileReal,
        'source' => $source,
    ];
}

function librarySlugTaken(string $slug): bool {
    if (!libraryIsSlug($slug)) {
        return true;
    }
    foreach (libraryRoots() as $root) {
        if (file_exists($root . DIRECTORY_SEPARATOR . $slug)) {
            return true;
        }
    }

    return false;
}

function libraryUniqueSlug(string $title): string {
    $base = trim(substr(slugify($title), 0, 60), '-');
    if (!libraryIsSlug($base)) {
        $base = 'text';
    }
    if (!librarySlugTaken($base)) {
        return $base;
    }

    for ($number = 2; $number <= 999; $number++) {
        $suffix = '-' . $number;
        $trimmed = trim(substr($base, 0, 64 - strlen($suffix)), '-');
        if (!libraryIsSlug($trimmed)) {
            $trimmed = 'text';
        }
        $candidate = $trimmed . $suffix;
        if (libraryIsSlug($candidate) && !librarySlugTaken($candidate)) {
            return $candidate;
        }
    }

    return 'text-' . bin2hex(random_bytes(3));
}

/**
 * @return list<array<string, mixed>>
 */
function libraryList(): array {
    $bySlug = [];
    foreach (libraryRoots() as $source => $root) {
        if (!is_dir($root)) {
            continue;
        }
        $entries = scandir($root);
        if (!is_array($entries)) {
            continue;
        }
        foreach ($entries as $entry) {
            if ($entry === '.' || $entry === '..' || str_starts_with($entry, '.')) {
                continue;
            }
            $directory = $root . DIRECTORY_SEPARATOR . $entry;
            if (!is_dir($directory) || is_link($directory)) {
                continue;
            }
            $work = libraryLoadWork($directory, $source);
            if ($work === null) {
                continue;
            }
            if (!isset($bySlug[$work['slug']]) || $source === 'uploads') {
                $bySlug[$work['slug']] = $work;
            }
        }
    }

    $items = array_values($bySlug);
    usort($items, static function (array $left, array $right): int {
        $byDate = strcmp((string) $right['added_at'], (string) $left['added_at']);
        if ($byDate !== 0) {
            return $byDate;
        }

        return strcasecmp((string) $left['title'], (string) $right['title']);
    });

    return $items;
}

/**
 * @return array<string, mixed>|null
 */
function libraryFind(string $slug): ?array {
    if (!libraryIsSlug($slug)) {
        return null;
    }
    foreach (['uploads', 'shipped'] as $source) {
        $roots = libraryRoots();
        if (!isset($roots[$source])) {
            continue;
        }
        $directory = $roots[$source] . DIRECTORY_SEPARATOR . $slug;
        if (!is_dir($directory) || is_link($directory)) {
            continue;
        }
        $work = libraryLoadWork($directory, $source);
        if ($work !== null) {
            return $work;
        }
    }

    return null;
}

function libraryDownloadName(array $work): string {
    $extension = (string) ($work['extension'] ?? '');
    $fallback = (string) ($work['slug'] ?? 'text') . ($extension !== '' ? '.' . $extension : '');
    $candidate = (string) ($work['original_name'] ?? '');
    if (
        $candidate === ''
        || preg_match('/\.php/i', $candidate) === 1
        || strtolower(pathinfo($candidate, PATHINFO_EXTENSION)) !== $extension
        || preg_match('/^[\p{L}\p{N}._ ()-]{1,180}$/u', $candidate) !== 1
    ) {
        return $fallback;
    }

    return $candidate;
}

function libraryContentDisposition(bool $inline, string $downloadName): string {
    $downloadName = str_replace(["\0", "\r", "\n", '"', '\\', '/'], '', $downloadName);
    if ($downloadName === '' || $downloadName === '.' || $downloadName === '..') {
        $downloadName = 'text.bin';
    }
    $ascii = preg_replace('/[^A-Za-z0-9._-]+/', '_', $downloadName) ?? 'file';
    $ascii = trim($ascii, '._');
    if ($ascii === '') {
        $ascii = 'file';
    }
    $type = $inline ? 'inline' : 'attachment';

    return $type . '; filename="' . $ascii . '"; filename*=UTF-8\'\'' . rawurlencode($downloadName);
}

function libraryFileUrl(string $slug, bool $download): string {
    $params = ['slug' => $slug];
    if ($download) {
        $params['download'] = '1';
    }

    return 'library_file.php?' . http_build_query($params, '', '&', PHP_QUERY_RFC3986);
}

function libraryMarkdownInline(string $escaped): string {
    $withLinks = preg_replace_callback(
        '~\[([^\]\n]+)\]\((https?://[^\s)]+)\)~',
        static function (array $matches): string {
            return '<a href="' . $matches[2] . '" rel="noopener noreferrer">' . $matches[1] . '</a>';
        },
        $escaped
    );
    $escaped = is_string($withLinks) ? $withLinks : $escaped;
    $withStrong = preg_replace('~\*\*([^*\n]+)\*\*~', '<strong>$1</strong>', $escaped);
    $escaped = is_string($withStrong) ? $withStrong : $escaped;
    $withEm = preg_replace('~(?<!\*)\*([^*\n]+)\*(?!\*)~', '<em>$1</em>', $escaped);

    return is_string($withEm) ? $withEm : $escaped;
}

function libraryRenderMarkdown(string $text): string {
    $text = str_replace(["\r\n", "\r"], "\n", libraryToUtf8($text));
    $escaped = htmlspecialchars($text, ENT_QUOTES | ENT_HTML5 | ENT_SUBSTITUTE, 'UTF-8');
    $lines = explode("\n", $escaped);
    $html = '';
    $inList = false;
    $paragraph = [];
    $flushParagraph = static function () use (&$html, &$paragraph): void {
        if ($paragraph === []) {
            return;
        }
        $html .= '<p>' . libraryMarkdownInline(implode(' ', $paragraph)) . '</p>';
        $paragraph = [];
    };

    foreach ($lines as $line) {
        if (preg_match('/^(#{1,3}) (.+)$/', $line, $heading) === 1) {
            $flushParagraph();
            if ($inList) {
                $html .= '</ul>';
                $inList = false;
            }
            $level = strlen($heading[1]) + 1;
            $html .= '<h' . $level . '>' . libraryMarkdownInline($heading[2]) . '</h' . $level . '>';
            continue;
        }
        if (preg_match('/^[-*] (.+)$/', $line, $item) === 1) {
            $flushParagraph();
            if (!$inList) {
                $html .= '<ul>';
                $inList = true;
            }
            $html .= '<li>' . libraryMarkdownInline($item[1]) . '</li>';
            continue;
        }
        if (trim($line) === '') {
            $flushParagraph();
            if ($inList) {
                $html .= '</ul>';
                $inList = false;
            }
            continue;
        }
        if ($inList) {
            $html .= '</ul>';
            $inList = false;
        }
        $paragraph[] = $line;
    }
    $flushParagraph();
    if ($inList) {
        $html .= '</ul>';
    }

    return $html;
}

function libraryRenderPlainText(string $text): string {
    $text = libraryToUtf8($text);

    return nl2br(htmlspecialchars($text, ENT_QUOTES | ENT_HTML5 | ENT_SUBSTITUTE, 'UTF-8'), false);
}

/**
 * @param array<string, mixed> $work
 */
function libraryReadableHtml(array $work): ?string {
    $kind = (string) ($work['kind'] ?? '');
    if ($kind !== 'text' && $kind !== 'html') {
        return null;
    }
    if ((int) ($work['bytes'] ?? 0) > LIBRARY_TEXT_RENDER_MAX_BYTES) {
        return null;
    }
    $path = (string) ($work['path'] ?? '');
    if ($path === '' || !is_file($path) || is_link($path)) {
        return null;
    }
    $raw = file_get_contents($path);
    if (!is_string($raw)) {
        return null;
    }
    if ($kind === 'html') {
        return sanitizeHtmlContent(libraryToUtf8($raw));
    }
    $extension = (string) ($work['extension'] ?? '');
    if ($extension === 'md' || $extension === 'markdown') {
        return libraryRenderMarkdown($raw);
    }

    return libraryRenderPlainText($raw);
}

/**
 * @param array<string, mixed> $meta
 * @return array{ok: bool, error: string, slug: string}
 */
function libraryInstallWork(string $rootKey, string $title, string $extension, string $contents, array $meta = []): array {
    $failed = static fn(string $error): array => ['ok' => false, 'error' => $error, 'slug' => ''];
    if ($rootKey !== 'shipped' && $rootKey !== 'uploads') {
        return $failed('Neplatné umiestnenie.');
    }
    $extension = strtolower($extension);
    if (!isset(libraryFileTypes()[$extension]) || !librarySampleLooksValid($contents, $extension)) {
        return $failed('Súbor nie je podporovaný alebo jeho obsah nezodpovedá typu.');
    }
    $title = trim(str_replace(["\0", "\r"], '', $title));
    $author = trim(str_replace(["\0", "\r"], '', (string) ($meta['author'] ?? '')));
    $description = trim(str_replace(["\0", "\r"], '', (string) ($meta['description'] ?? '')));
    if ($title === '' || appTextLength($title) > 255 || !libraryIsUtf8($title)) {
        return $failed('Názov musí mať 1 až 255 znakov.');
    }
    if (appTextLength($author) > 255 || appTextLength($description) > 4000 || !libraryIsUtf8($author) || !libraryIsUtf8($description)) {
        return $failed('Autor alebo popis je príliš dlhý.');
    }

    $roots = libraryRoots();
    $root = $roots[$rootKey];
    if (!is_dir($root) && !@mkdir($root, 0755, true) && !is_dir($root)) {
        return $failed('Priečinok knižnice sa nepodarilo vytvoriť.');
    }
    $slug = libraryUniqueSlug($title);
    $directory = $root . DIRECTORY_SEPARATOR . $slug;
    if (file_exists($directory) || !@mkdir($directory, 0755)) {
        return $failed('Položku sa nepodarilo uložiť.');
    }
    $stored = $slug . '.' . $extension;
    $destination = $directory . DIRECTORY_SEPARATOR . $stored;
    if (file_put_contents($destination, $contents, LOCK_EX) === false) {
        @rmdir($directory);
        return $failed('Súbor sa nepodarilo uložiť.');
    }

    $addedAt = (string) ($meta['added_at'] ?? date('Y-m-d'));
    if (preg_match('/^\d{4}-\d{2}-\d{2}$/D', $addedAt) !== 1) {
        $addedAt = date('Y-m-d');
    }
    $originalName = trim(str_replace(["\0", "\r", "\n", '"', '\\', '/'], '', (string) ($meta['original_name'] ?? '')));
    $record = [
        'title' => $title,
        'author' => $author,
        'description' => $description,
        'added_at' => $addedAt,
        'filename' => $stored,
        'original_name' => $originalName,
    ];
    try {
        $json = json_encode($record, JSON_UNESCAPED_UNICODE | JSON_PRETTY_PRINT | JSON_THROW_ON_ERROR);
    } catch (JsonException) {
        @unlink($destination);
        @rmdir($directory);
        return $failed('Údaje o texte sa nepodarilo uložiť.');
    }
    if (file_put_contents($directory . DIRECTORY_SEPARATOR . 'work.json', $json . "\n", LOCK_EX) === false) {
        @unlink($destination);
        @rmdir($directory);
        return $failed('Údaje o texte sa nepodarilo uložiť.');
    }

    return ['ok' => true, 'error' => '', 'slug' => $slug];
}

/**
 * @param array<string, mixed> $file
 * @return array{ok: bool, error: string, slug: string}
 */
function librarySaveUpload(string $title, string $author, string $description, array $file): array {
    $failed = static fn(string $error): array => ['ok' => false, 'error' => $error, 'slug' => ''];
    $uploadError = (int) ($file['error'] ?? UPLOAD_ERR_NO_FILE);
    if ($uploadError === UPLOAD_ERR_INI_SIZE || $uploadError === UPLOAD_ERR_FORM_SIZE) {
        return $failed('Súbor je väčší, než dovoľuje server (' . libraryFormatSize(libraryUploadLimitBytes()) . ').');
    }
    if ($uploadError === UPLOAD_ERR_NO_FILE) {
        return $failed('Vyberte súbor.');
    }
    if ($uploadError !== UPLOAD_ERR_OK) {
        return $failed('Nahrávanie sa nepodarilo.');
    }

    $size = (int) ($file['size'] ?? 0);
    $limit = libraryUploadLimitBytes();
    if ($size < 1 || $size > $limit) {
        return $failed('Súbor je prázdny alebo väčší ako ' . libraryFormatSize($limit) . '.');
    }
    $temporary = (string) ($file['tmp_name'] ?? '');
    if ($temporary === '' || !is_uploaded_file($temporary)) {
        return $failed('Nahrávanie sa nepodarilo.');
    }

    $original = basename(str_replace('\\', '/', (string) ($file['name'] ?? '')));
    $extension = strtolower(pathinfo($original, PATHINFO_EXTENSION));
    if (!isset(libraryFileTypes()[$extension])) {
        return $failed('Povolené sú súbory PDF, TXT, Markdown, HTML a EPUB.');
    }
    if (!libraryFileLooksValid($temporary, $extension)) {
        return $failed('Obsah súboru nezodpovedá jeho typu.');
    }
    $contents = file_get_contents($temporary);
    if (!is_string($contents)) {
        return $failed('Súbor sa nepodarilo prečítať.');
    }

    return libraryInstallWork('uploads', $title, $extension, $contents, [
        'author' => $author,
        'description' => $description,
        'original_name' => $original,
        'added_at' => date('Y-m-d'),
    ]);
}

function libraryDeleteUpload(string $slug): bool {
    if (!libraryIsSlug($slug)) {
        return false;
    }
    $roots = libraryRoots();
    $root = $roots['uploads'] ?? '';
    if ($root === '' || !is_dir($root)) {
        return false;
    }
    $directory = $root . DIRECTORY_SEPARATOR . $slug;
    $rootReal = realpath($root);
    $directoryReal = realpath($directory);
    if (
        $rootReal === false
        || $directoryReal === false
        || is_link($directory)
        || !libraryPathIsInside($rootReal, $directoryReal)
    ) {
        return false;
    }

    $entries = scandir($directoryReal);
    if (!is_array($entries)) {
        return false;
    }
    foreach ($entries as $entry) {
        if ($entry === '.' || $entry === '..') {
            continue;
        }
        $path = $directoryReal . DIRECTORY_SEPARATOR . $entry;
        if (is_link($path) || !is_file($path) || !unlink($path)) {
            return false;
        }
    }

    return rmdir($directoryReal);
}
