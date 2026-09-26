<?php

declare(strict_types=1);

require_once __DIR__ . '/auth.php';
require_once __DIR__ . '/db_config.php';
require_once __DIR__ . '/helpers.php';

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

$handle = fopen((string) $work['path'], 'rb');
if ($handle === false) {
    http_response_code(404);
    header('Content-Type: text/plain; charset=UTF-8');
    header('X-Content-Type-Options: nosniff');
    header('X-Robots-Tag: noindex, noai, noimageai');
    echo 'Not found';
    exit;
}

$kind = (string) $work['kind'];
$inlinePdf = $kind === 'pdf' && !$download;
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
// Súbor knižnice nie je samostatná stránka vo výsledkoch; zároveň nesmie ísť
// do tréningu (noai / noimageai dopĺňa TDM-Reservation z auth.php).
header('X-Robots-Tag: noindex, noai, noimageai');
header('Content-Disposition: ' . libraryContentDisposition($inlinePdf, libraryDownloadName($work)));
header('Content-Length: ' . (string) $work['bytes']);
header('Cache-Control: private, max-age=3600');
fpassthru($handle);
fclose($handle);
