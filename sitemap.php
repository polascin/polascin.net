<?php

declare(strict_types=1);

require_once __DIR__ . '/db_config.php';
require_once __DIR__ . '/helpers.php';

/** @var PDO $pdo */

$baseUrl = getAppBaseUrl();

function sitemapLastModified(string $file): string {
    $timestamp = is_file($file) ? filemtime($file) : false;
    return date(DATE_ATOM, $timestamp !== false ? $timestamp : time());
}

function sitemapDatabaseDate(?string $value, string $fallback): string {
    $timestamp = $value !== null ? strtotime($value) : false;
    return date(DATE_ATOM, $timestamp !== false ? $timestamp : (int) strtotime($fallback));
}

function sitemapLatest(string ...$dates): string {
    $latest = '';
    $latestTimestamp = PHP_INT_MIN;
    foreach ($dates as $date) {
        $timestamp = strtotime($date);
        if ($timestamp !== false && $timestamp > $latestTimestamp) {
            $latestTimestamp = $timestamp;
            $latest = $date;
        }
    }

    return $latest;
}

$languages = array_keys(appLanguages());

// Všetky publikované články sa načítajú jedným dotazom a skupiny prekladov sa
// zostavia v PHP. Sitemap je verejný endpoint bez serverovej cache, takže sa
// tu neoplatí dotazovať databázu pre každý článok zvlášť.
$articleRows = [];
try {
    $articleStmt = $pdo->query(
        "SELECT slug, lang, translation_group, published_at, updated_at
         FROM articles
         WHERE is_published = 1 AND published_at IS NOT NULL AND published_at <= NOW()"
    );
    $articleRows = $articleStmt->fetchAll();
} catch (\PDOException $e) {
    error_log('sitemap articles error: ' . $e->getMessage());
}

// Domovská stránka a zoznam článkov ukazujú najnovšie články. Ich `lastmod`
// preto nesmie zostať na čase úpravy PHP súboru, keď pribudne článok.
$latestArticleByLang = [];
foreach ($articleRows as $row) {
    $rowLang = (string) ($row['lang'] ?? '');
    if (!isSupportedLanguage($rowLang)) {
        continue;
    }
    $rowDate = sitemapDatabaseDate($row['updated_at'] ?? null, (string) ($row['published_at'] ?? ''));
    $latestArticleByLang[$rowLang] = isset($latestArticleByLang[$rowLang])
        ? sitemapLatest($latestArticleByLang[$rowLang], $rowDate)
        : $rowDate;
}

$libraryWorks = libraryList();
$latestLibraryDate = '';
foreach ($libraryWorks as $libraryWork) {
    $libraryMtime = (int) ($libraryWork['mtime'] ?? 0);
    if ($libraryMtime > 0) {
        $latestLibraryDate = sitemapLatest($latestLibraryDate, date(DATE_ATOM, $libraryMtime));
    }
}

/**
 * Statické stránky existujú vo všetkých jazykoch, takže každá dostane vlastnú
 * URL a k nej kompletnú sadu `xhtml:link` alternatív.
 */
$staticPages = [
    ['path' => 'index.php', 'changefreq' => 'weekly', 'priority' => '1.0', 'lists_articles' => true],
    ['path' => 'articles.php', 'changefreq' => 'weekly', 'priority' => '0.8', 'lists_articles' => true],
    ['path' => 'library.php', 'changefreq' => 'weekly', 'priority' => '0.7', 'lists_library' => true],
    ['path' => 'contact.php', 'changefreq' => 'monthly', 'priority' => '0.6'],
];

$urls = [];
foreach ($staticPages as $page) {
    $alternates = [];
    foreach ($languages as $language) {
        $alternates[$language] = absoluteLangUrl($language, $page['path']);
    }
    foreach ($languages as $language) {
        $lastmod = sitemapLastModified(__DIR__ . '/' . $page['path']);
        if (($page['lists_articles'] ?? false) && isset($latestArticleByLang[$language])) {
            $lastmod = sitemapLatest($lastmod, $latestArticleByLang[$language]);
        }
        if (($page['lists_library'] ?? false) && $latestLibraryDate !== '') {
            $lastmod = sitemapLatest($lastmod, $latestLibraryDate);
        }
        $urls[] = [
            'loc' => $alternates[$language],
            'lastmod' => $lastmod,
            'changefreq' => $page['changefreq'],
            'priority' => $page['priority'],
            'alternates' => $alternates,
        ];
    }
}

foreach ($libraryWorks as $libraryWork) {
    $librarySlug = (string) ($libraryWork['slug'] ?? '');
    if ($librarySlug === '') {
        continue;
    }
    $libraryFile = (string) ($libraryWork['path'] ?? '');
    $libraryAlternates = [];
    foreach ($languages as $language) {
        $libraryAlternates[$language] = absoluteLangUrl($language, 'library.php', ['slug' => $librarySlug]);
    }
    foreach ($languages as $language) {
        $urls[] = [
            'loc' => $libraryAlternates[$language],
            'lastmod' => sitemapLastModified($libraryFile),
            'changefreq' => 'monthly',
            'priority' => '0.6',
            'alternates' => $libraryAlternates,
        ];
    }
}

$translationMap = [];
foreach ($articleRows as $row) {
    $rowLang = (string) ($row['lang'] ?? '');
    $group = $row['translation_group'] ?? null;
    if ($group !== null && $rowLang !== '' && isSupportedLanguage($rowLang)) {
        $translationMap[(int) $group][$rowLang] = (string) ($row['slug'] ?? '');
    }
}

foreach ($articleRows as $row) {
    $rowLang = (string) ($row['lang'] ?? '');
    if (!isSupportedLanguage($rowLang)) {
        continue;
    }

    $group = $row['translation_group'] ?? null;
    $siblings = $group !== null ? ($translationMap[(int) $group] ?? []) : [];

    $alternates = [];
    if (count($siblings) > 1) {
        foreach ($siblings as $siblingLang => $siblingSlug) {
            $alternates[$siblingLang] = absoluteLangUrl($siblingLang, 'article.php', ['slug' => $siblingSlug]);
        }
    }

    $urls[] = [
        'loc' => absoluteLangUrl($rowLang, 'article.php', ['slug' => (string) $row['slug']]),
        'lastmod' => sitemapDatabaseDate($row['updated_at'] ?? null, (string) ($row['published_at'] ?? '')),
        'changefreq' => 'monthly',
        'priority' => '0.7',
        'alternates' => $alternates,
    ];
}

header('Content-Type: application/xml; charset=UTF-8');
header('Cache-Control: public, max-age=3600');
header('X-Content-Type-Options: nosniff');
echo '<?xml version="1.0" encoding="UTF-8"?>', "\n";
echo '<urlset xmlns="http://www.sitemaps.org/schemas/sitemap/0.9" xmlns:xhtml="http://www.w3.org/1999/xhtml">', "\n";
foreach ($urls as $url) {
    echo "  <url>\n";
    echo '    <loc>' . htmlspecialchars((string) $url['loc'], ENT_XML1, 'UTF-8') . "</loc>\n";
    foreach ($url['alternates'] as $alternateLang => $alternateUrl) {
        echo '    <xhtml:link rel="alternate" hreflang="' . htmlspecialchars((string) $alternateLang, ENT_XML1 | ENT_QUOTES, 'UTF-8')
            . '" href="' . htmlspecialchars((string) $alternateUrl, ENT_XML1 | ENT_QUOTES, 'UTF-8') . "\"/>\n";
    }
    // x-default musí ukazovať na tú istú adresu ako v `head_meta.php`, teda na
    // jazyk, ktorý dostane návštevník s nepodporovaným jazykom.
    $xDefaultUrl = $url['alternates'][APP_FALLBACK_LANGUAGE]
        ?? $url['alternates'][APP_DEFAULT_LANGUAGE]
        ?? null;
    if ($xDefaultUrl !== null) {
        echo '    <xhtml:link rel="alternate" hreflang="x-default" href="'
            . htmlspecialchars((string) $xDefaultUrl, ENT_XML1 | ENT_QUOTES, 'UTF-8') . "\"/>\n";
    }
    echo '    <lastmod>' . htmlspecialchars((string) $url['lastmod'], ENT_XML1, 'UTF-8') . "</lastmod>\n";
    echo '    <changefreq>' . htmlspecialchars((string) $url['changefreq'], ENT_XML1, 'UTF-8') . "</changefreq>\n";
    echo '    <priority>' . htmlspecialchars((string) $url['priority'], ENT_XML1, 'UTF-8') . "</priority>\n";
    echo "  </url>\n";
}
echo '</urlset>', "\n";
