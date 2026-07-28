<?php

declare(strict_types=1);

require_once __DIR__ . '/db_config.php';
require_once __DIR__ . '/helpers.php';

/** @var PDO $pdo */

$baseUrl = getAppBaseUrl();
$now = date('c');

$urls = [
    ['loc' => $baseUrl . '/', 'lastmod' => $now, 'changefreq' => 'weekly', 'priority' => '1.0'],
    ['loc' => $baseUrl . '/articles.php', 'lastmod' => $now, 'changefreq' => 'weekly', 'priority' => '0.8'],
    ['loc' => $baseUrl . '/contact.php', 'lastmod' => $now, 'changefreq' => 'monthly', 'priority' => '0.6'],
    ['loc' => $baseUrl . '/privacy.php', 'lastmod' => $now, 'changefreq' => 'yearly', 'priority' => '0.3'],
    ['loc' => $baseUrl . '/terms.php', 'lastmod' => $now, 'changefreq' => 'yearly', 'priority' => '0.3'],
];

foreach (getPublishedArticles($pdo, 1000) as $article) {
    $urls[] = [
        'loc' => $baseUrl . '/article.php?slug=' . rawurlencode((string) $article['slug']),
        'lastmod' => $now,
        'changefreq' => 'monthly',
        'priority' => '0.7',
    ];
}

header('Content-Type: application/xml; charset=UTF-8');
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
