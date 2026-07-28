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
        $content = is_array($row) && !empty($row['content']) ? (string) $row['content'] : $default;
        return sanitizeHtmlContent($content);
    } catch (\PDOException $e) {
        error_log('getContentBlock error: ' . $e->getMessage());
        return sanitizeHtmlContent($default);
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

function sanitizeHtmlContent(string $html): string {
    if (trim($html) === '') {
        return '';
    }

    $allowedTags = [
        'p', 'br', 'hr', 'h1', 'h2', 'h3', 'h4', 'h5', 'h6',
        'strong', 'b', 'em', 'i', 'u', 'ul', 'ol', 'li',
        'blockquote', 'a', 'span', 'img', 'div',
    ];
    $allowedGlobalAttrs = ['class', 'id', 'title'];
    $allowedTagAttrs = [
        'a' => ['href'],
        'img' => ['src', 'alt', 'title', 'loading'],
    ];

    $dom = new DOMDocument('1.0', 'UTF-8');
    $prevUseInternalErrors = libxml_use_internal_errors(true);

    $wrapped = '<html><head><meta http-equiv="Content-Type" content="text/html; charset=utf-8"></head><body><div>' . $html . '</div></body></html>';
    $loaded = $dom->loadHTML($wrapped, LIBXML_HTML_NODEFDTD);
    libxml_clear_errors();
    libxml_use_internal_errors($prevUseInternalErrors);

    if (!$loaded) {
        return htmlspecialchars(strip_tags($html), ENT_QUOTES | ENT_HTML5, 'UTF-8');
    }

    $body = $dom->getElementsByTagName('body')->item(0);
    $container = $body instanceof DOMElement ? $body->getElementsByTagName('div')->item(0) : null;
    if (!$container instanceof DOMElement) {
        return htmlspecialchars(strip_tags($html), ENT_QUOTES | ENT_HTML5, 'UTF-8');
    }

    $nodesToRemove = [];
    $elements = $container->getElementsByTagName('*');

    for ($i = $elements->length - 1; $i >= 0; $i--) {
        $node = $elements->item($i);
        if (!$node instanceof DOMElement) {
            continue;
        }

        $tag = strtolower($node->nodeName);
        if (!in_array($tag, $allowedTags, true)) {
            $nodesToRemove[] = $node;
            continue;
        }

        $allowed = array_merge($allowedGlobalAttrs, $allowedTagAttrs[$tag] ?? []);
        $attrsToRemove = [];

        if ($node->hasAttributes()) {
            foreach ($node->attributes as $attr) {
                $name = strtolower($attr->name);
                if ($name === 'style' || !in_array($name, $allowed, true)) {
                    $attrsToRemove[] = $name;
                    continue;
                }
                if (($name === 'href' || $name === 'src') && preg_match('/^\s*javascript:/i', $attr->value)) {
                    $attrsToRemove[] = $name;
                }
            }
        }

        foreach ($attrsToRemove as $name) {
            $node->removeAttribute($name);
        }
    }

    foreach ($nodesToRemove as $node) {
        $parent = $node->parentNode;
        if (!$parent instanceof DOMNode) {
            continue;
        }
        while ($node->firstChild) {
            $parent->insertBefore($node->firstChild, $node);
        }
        $parent->removeChild($node);
    }

    $result = '';
    foreach ($container->childNodes as $child) {
        $result .= $dom->saveHTML($child);
    }

    return trim($result);
}

function slugify(string $text): string {
    $text = trim($text);
    $text = preg_replace('/[^\p{L}\p{N}\s-]/u', '', $text) ?? $text;
    $text = preg_replace('/\s+/u', '-', $text) ?? $text;
    $text = preg_replace('/-+/', '-', $text) ?? $text;
    $text = mb_strtolower($text, 'UTF-8');
    return trim($text, '-');
}
