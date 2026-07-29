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

$urls = [
    ['loc' => $baseUrl . '/', 'lastmod' => sitemapLastModified(__DIR__ . '/index.php'), 'changefreq' => 'weekly', 'priority' => '1.0'],
    ['loc' => $baseUrl . '/articles.php', 'lastmod' => sitemapLastModified(__DIR__ . '/articles.php'), 'changefreq' => 'weekly', 'priority' => '0.8'],
    ['loc' => $baseUrl . '/contact.php', 'lastmod' => sitemapLastModified(__DIR__ . '/contact.php'), 'changefreq' => 'monthly', 'priority' => '0.6'],
];

foreach (getPublishedArticles($pdo, 1000) as $article) {
    $publishedAt = (string) ($article['published_at'] ?? '');
    $urls[] = [
        'loc' => $baseUrl . '/article.php?slug=' . rawurlencode((string) $article['slug']),
        'lastmod' => sitemapDatabaseDate($article['updated_at'] ?? null, $publishedAt),
        'changefreq' => 'monthly',
        'priority' => '0.7',
    ];
}

header('Content-Type: application/xml; charset=UTF-8');
header('Cache-Control: public, max-age=3600');
header('X-Content-Type-Options: nosniff');
echo '<?xml version="1.0" encoding="UTF-8"?>', "\n";
echo '<urlset xmlns="http://www.sitemaps.org/schemas/sitemap/0.9">', "\n";
foreach ($urls as $url) {
    echo "  <url>\n";
    echo '    <loc>' . htmlspecialchars((string) $url['loc'], ENT_XML1, 'UTF-8') . "</loc>\n";
    echo '    <lastmod>' . htmlspecialchars((string) $url['lastmod'], ENT_XML1, 'UTF-8') . "</lastmod>\n";
    echo '    <changefreq>' . htmlspecialchars((string) $url['changefreq'], ENT_XML1, 'UTF-8') . "</changefreq>\n";
    echo '    <priority>' . htmlspecialchars((string) $url['priority'], ENT_XML1, 'UTF-8') . "</priority>\n";
    echo "  </url>\n";
}
echo '</urlset>', "\n";
