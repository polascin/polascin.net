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

$languages = array_keys(appLanguages());

/**
 * Statické stránky existujú vo všetkých jazykoch, takže každá dostane vlastnú
 * URL a k nej kompletnú sadu `xhtml:link` alternatív.
 */
$staticPages = [
    ['path' => 'index.php', 'changefreq' => 'weekly', 'priority' => '1.0'],
    ['path' => 'articles.php', 'changefreq' => 'weekly', 'priority' => '0.8'],
    ['path' => 'contact.php', 'changefreq' => 'monthly', 'priority' => '0.6'],
];

$urls = [];
foreach ($staticPages as $page) {
    $alternates = [];
    foreach ($languages as $language) {
        $alternates[$language] = absoluteLangUrl($language, $page['path']);
    }
    foreach ($languages as $language) {
        $urls[] = [
            'loc' => $alternates[$language],
            'lastmod' => sitemapLastModified(__DIR__ . '/' . $page['path']),
            'changefreq' => $page['changefreq'],
            'priority' => $page['priority'],
            'alternates' => $alternates,
        ];
    }
}

// Všetky publikované články sa načítajú jedným dotazom a skupiny prekladov sa
// zostavia v PHP — sitemap je verejný endpoint bez serverovej cache, takže sa
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
    if (isset($url['alternates'][APP_DEFAULT_LANGUAGE])) {
        echo '    <xhtml:link rel="alternate" hreflang="x-default" href="'
            . htmlspecialchars((string) $url['alternates'][APP_DEFAULT_LANGUAGE], ENT_XML1 | ENT_QUOTES, 'UTF-8') . "\"/>\n";
    }
    echo '    <lastmod>' . htmlspecialchars((string) $url['lastmod'], ENT_XML1, 'UTF-8') . "</lastmod>\n";
    echo '    <changefreq>' . htmlspecialchars((string) $url['changefreq'], ENT_XML1, 'UTF-8') . "</changefreq>\n";
    echo '    <priority>' . htmlspecialchars((string) $url['priority'], ENT_XML1, 'UTF-8') . "</priority>\n";
    echo "  </url>\n";
}
echo '</urlset>', "\n";
