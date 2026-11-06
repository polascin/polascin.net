<?php

declare(strict_types=1);

require_once __DIR__ . '/auth.php';
require_once __DIR__ . '/db_config.php';
require_once __DIR__ . '/helpers.php';

$method = strtoupper((string) ($_SERVER['REQUEST_METHOD'] ?? 'GET'));
if ($method !== 'GET' && $method !== 'HEAD') {
    http_response_code(405);
    header('Allow: GET, HEAD');
    header('Content-Type: text/plain; charset=UTF-8');
    header('X-Content-Type-Options: nosniff');
    header('X-Robots-Tag: noindex, noai, noimageai');
    echo 'Method not allowed';
    exit;
}

$slug = isset($_GET['slug']) && is_string($_GET['slug']) ? $_GET['slug'] : '';
$download = isset($_GET['download']) && $_GET['download'] === '1';
$work = libraryIsSlug($slug) ? libraryFind($slug) : null;

if (!is_array($work)) {
    http_response_code(404);
    header('Content-Type: text/plain; charset=UTF-8');
    header('X-Content-Type-Options: nosniff');
    header('X-Robots-Tag: noindex, noai, noimageai');
    echo 'Not found';
    exit;
}

$kind = (string) $work['kind'];
$inlinePdf = $kind === 'pdf' && !$download;
$etag = libraryEtag($work, $inlinePdf);
$mtime = (int) ($work['mtime'] ?? 0);
if (libraryRequestIsFresh($etag, $mtime, $_SERVER)) {
    http_response_code(304);
    header('ETag: ' . $etag);
    header('Cache-Control: private, max-age=3600');
    header('X-Robots-Tag: noindex, noai, noimageai');
    exit;
}

$handle = fopen((string) $work['path'], 'rb');
if ($handle === false) {
    http_response_code(404);
    header('Content-Type: text/plain; charset=UTF-8');
    header('X-Content-Type-Options: nosniff');
    header('X-Robots-Tag: noindex, noai, noimageai');
    echo 'Not found';
    exit;
}

$mime = $inlinePdf ? 'application/pdf' : (string) $work['mime'];
if ($kind === 'html') {
    // HTML sa v prehliadači číta až po sanitizácii na stránke diela.
    // Priame otvorenie nesmie bežať v pôvode webu.
    $mime = 'text/plain; charset=UTF-8';
}

while (ob_get_level() > 0) {
    ob_end_clean();
}

header('Content-Type: ' . $mime);
header('X-Content-Type-Options: nosniff');
header('X-Robots-Tag: noindex, noai, noimageai');
header('Content-Disposition: ' . libraryContentDisposition($inlinePdf, libraryDownloadName($work)));
header('Content-Length: ' . (string) $work['bytes']);
header('Cache-Control: private, max-age=3600');
header('ETag: ' . $etag);
if ($mtime > 0) {
    header('Last-Modified: ' . gmdate('D, d M Y H:i:s', $mtime) . ' GMT');
}
fpassthru($handle);
fclose($handle);
