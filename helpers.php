<?php

declare(strict_types=1);

if (basename($_SERVER['PHP_SELF'] ?? '') === basename(__FILE__)) {
    header("HTTP/1.1 403 Forbidden");
    exit("Prístup odmietnutý.");
}

function getContentBlock(PDO $pdo, string $key, string $default = ''): string {
    try {
        $stmt = $pdo->prepare("SELECT content FROM content_blocks WHERE block_key = :key AND is_active = 1 LIMIT 1");
        $stmt->execute([':key' => $key]);
        $row = $stmt->fetch();
        return is_array($row) && !empty($row['content']) ? (string) $row['content'] : $default;
    } catch (\PDOException $e) {
        error_log('getContentBlock error: ' . $e->getMessage());
        return $default;
    }
}

function getPublishedArticles(PDO $pdo, int $limit = 10, int $offset = 0): array {
    try {
        $stmt = $pdo->prepare(
            "SELECT id, title, slug, excerpt, author, published_at
             FROM articles
             WHERE is_published = 1 AND published_at <= NOW()
             ORDER BY is_top DESC, sort_order ASC, published_at DESC
             LIMIT :limit OFFSET :offset"
        );
        $stmt->bindValue(':limit', $limit, PDO::PARAM_INT);
        $stmt->bindValue(':offset', $offset, PDO::PARAM_INT);
        $stmt->execute();
        return $stmt->fetchAll();
    } catch (\PDOException $e) {
        error_log('getPublishedArticles error: ' . $e->getMessage());
        return [];
    }
}

function getArticleBySlug(PDO $pdo, string $slug): ?array {
    try {
        $stmt = $pdo->prepare(
            "SELECT id, title, slug, excerpt, content, author, is_published, published_at
             FROM articles WHERE slug = :slug LIMIT 1"
        );
        $stmt->execute([':slug' => $slug]);
        $row = $stmt->fetch();
        return is_array($row) ? $row : null;
    } catch (\PDOException $e) {
        error_log('getArticleBySlug error: ' . $e->getMessage());
        return null;
    }
}

function formatArticleDate(?string $datetime): string {
    if (empty($datetime)) {
        return '';
    }
    try {
        $dt = new DateTimeImmutable($datetime, new DateTimeZone(date_default_timezone_get() ?: 'Europe/Bratislava'));
        return $dt->format('F j, Y');
    } catch (\Throwable) {
        return htmlspecialchars((string) $datetime, ENT_QUOTES, 'UTF-8');
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
    if (mb_strlen($normalized) <= $maxLen) {
        return $normalized;
    }
    $slice = mb_substr($normalized, 0, $maxLen + 1);
    $slice = preg_replace('/\s+\S*$/u', '', $slice) ?? $slice;
    $slice = rtrim($slice, " \t\n\r\0\x0B,.;:-");
    return $slice . '…';
}

function slugify(string $text): string {
    $text = trim($text);
    $text = preg_replace('/[^\p{L}\p{N}\s-]/u', '', $text) ?? $text;
    $text = preg_replace('/\s+/u', '-', $text) ?? $text;
    $text = preg_replace('/-+/', '-', $text) ?? $text;
    $text = mb_strtolower($text, 'UTF-8');
    return trim($text, '-');
}
