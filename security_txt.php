<?php

declare(strict_types=1);

// RFC 9116 vyžaduje `text/plain; charset=utf-8`. Statické súbory podáva
// predradený openresty s typom podľa prípony bez charset a direktívy Apache
// (`Header set`, `ForceType`) ho neprepíšu (Beh #109). `.htaccess` preto
// smeruje `/.well-known/security.txt` sem.
$securityTxtPath = __DIR__ . '/.well-known/security.txt';
$securityTxt = is_file($securityTxtPath) ? file_get_contents($securityTxtPath) : false;

header('X-Content-Type-Options: nosniff');
if (!is_string($securityTxt) || $securityTxt === '') {
    http_response_code(404);
    header('Content-Type: text/plain; charset=utf-8');
    echo "Not found\n";
    exit;
}

header('Content-Type: text/plain; charset=utf-8');
header('Cache-Control: public, max-age=86400');
echo $securityTxt;
