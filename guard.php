<?php

declare(strict_types=1);

/**
 * Guard.php - Jednotný ochranný mechanizmus pre interné PHP súbory
 *
 * Zabezpečuje, že interné súbory (ako auth.php, config_loader.php, atď.)
 * nemôžu byť spustené priamo cez web server alebo CLI.
 *
 * Použitie:
 *   require_once __DIR__ . '/guard.php';
 *   guardInternalAccess(__FILE__);
 */

/**
 * Ochrana pred priamym prístupom k internému súboru.
 *
 * @param string $filename Názov súboru, ktorý sa chráni (používa __FILE__)
 * @return void Exit s chybou ak je priamy prístup detekovaný
 */
function guardInternalAccess(string $filename): void
{
    $requestedScript = str_replace('\\', '/', (string) ($_SERVER['SCRIPT_NAME'] ?? $_SERVER['PHP_SELF'] ?? ''));
    $executedFile = isset($_SERVER['SCRIPT_FILENAME']) ? realpath((string) $_SERVER['SCRIPT_FILENAME']) : false;
    $protectedFile = realpath($filename);
    $basename = basename($filename);

    // Porovnanie so samotným guard.php by chránený súbor nevyhodnotilo;
    // správne je realpath($filename).
    if (
        ($executedFile !== false && $protectedFile !== false && $executedFile === $protectedFile)
        || preg_match('~(?:^|/)' . preg_quote($basename, '~') . '(?:/|$)~i', $requestedScript) === 1
    ) {
        if (PHP_SAPI === 'cli') {
            fwrite(STDERR, "Chyba: $basename je interný súbor a nemožno ho spúšťať priamo.\n");
            exit(1);
        }
        http_response_code(403);
        exit('Prístup odmietnutý.');
    }

    unset($requestedScript, $executedFile, $protectedFile, $basename);
}
