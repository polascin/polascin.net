<?php

declare(strict_types=1);

/**
 * Vygeneruje JPEG varianty obálok článkov pre Open Graph.
 *
 * Obálky sú WebP, lebo na stránke je menší. Open Graph však WebP nezobrazí
 * všade — LinkedIn ho historicky nepodporuje a zdieľaný článok potom nemá
 * náhľadový obrázok vôbec. Preto ku každej obálke vzniká JPEG dvojička
 * v `images/articles/og/`, ktorú `articleCoverSocialSrc()` podsunie do
 * `og:image` a `twitter:image`.
 *
 * Podadresár je zámerný: JPEG je odvodenina, nie ďalšia obálka na výber,
 * a `availableArticleCovers()` do podadresárov nesiaha.
 *
 * Spustenie (len CLI, z koreňa repozitára):
 *   php scripts/make_og_covers.php
 *
 * Skript je idempotentný — prepisuje len to, čo chýba alebo je staršie
 * ako zdrojový WebP. Súlad zdrojov a odvodenín stráži test v `tests/run.php`.
 */

if (PHP_SAPI !== 'cli') {
    http_response_code(403);
    exit('Prístup odmietnutý.');
}

const OG_JPEG_QUALITY = 82;

$root = dirname(__DIR__);
$sourceDir = $root . '/images/articles';
$targetDir = $sourceDir . '/og';

if (!is_dir($sourceDir)) {
    fwrite(STDERR, "Chyba: {$sourceDir} neexistuje.\n");
    exit(1);
}
if (!is_dir($targetDir) && !mkdir($targetDir, 0o755, true) && !is_dir($targetDir)) {
    fwrite(STDERR, "Chyba: nepodarilo sa vytvoriť {$targetDir}.\n");
    exit(1);
}
if (!function_exists('imagecreatefromwebp') || !function_exists('imagejpeg')) {
    fwrite(STDERR, "Chyba: PHP GD nemá podporu WebP alebo JPEG.\n");
    exit(1);
}

$sources = glob($sourceDir . '/*.webp');
if ($sources === false || $sources === []) {
    fwrite(STDOUT, "Žiadne WebP obálky — niet čo generovať.\n");
    exit(0);
}

$created = 0;
$skipped = 0;
foreach ($sources as $source) {
    $target = $targetDir . '/' . pathinfo($source, PATHINFO_FILENAME) . '.jpg';

    if (is_file($target) && filemtime($target) >= filemtime($source)) {
        $skipped++;
        continue;
    }

    $image = @imagecreatefromwebp($source);
    if ($image === false) {
        fwrite(STDERR, "Chyba: nepodarilo sa načítať " . basename($source) . ".\n");
        exit(1);
    }

    // WebP môže mať alfa kanál; JPEG nie. Podklad je biely, aby priehľadné
    // miesta nevyšli čierne.
    $flattened = imagecreatetruecolor(imagesx($image), imagesy($image));
    if ($flattened === false) {
        imagedestroy($image);
        fwrite(STDERR, "Chyba: nepodarilo sa pripraviť plátno pre " . basename($source) . ".\n");
        exit(1);
    }
    imagefill($flattened, 0, 0, (int) imagecolorallocate($flattened, 255, 255, 255));
    imagecopy($flattened, $image, 0, 0, 0, 0, imagesx($image), imagesy($image));
    imagedestroy($image);

    $ok = imagejpeg($flattened, $target, OG_JPEG_QUALITY);
    imagedestroy($flattened);
    if (!$ok) {
        fwrite(STDERR, "Chyba: nepodarilo sa zapísať " . basename($target) . ".\n");
        exit(1);
    }

    fwrite(STDOUT, '  vytvorené  ' . basename($target) . ' (' . number_format(filesize($target) / 1024, 1) . " kB)\n");
    $created++;
}

fwrite(STDOUT, "Hotovo: {$created} vygenerovaných, {$skipped} aktuálnych.\n");
