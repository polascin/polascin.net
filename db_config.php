<?php

declare(strict_types=1);

// Ochrana pred priamym prístupom vrátane požiadaviek s PATH_INFO.
$requestedScript = str_replace('\\', '/', (string) ($_SERVER['SCRIPT_NAME'] ?? $_SERVER['PHP_SELF'] ?? ''));
$executedFile = isset($_SERVER['SCRIPT_FILENAME']) ? realpath((string) $_SERVER['SCRIPT_FILENAME']) : false;
if (
    $executedFile === __FILE__
    || preg_match('~(?:^|/)db_config\.php(?:/|$)~i', $requestedScript) === 1
) {
    if (PHP_SAPI === 'cli') {
        fwrite(STDERR, "Chyba: db_config.php je interný súbor a nemožno ho spúšťať priamo.\n");
        exit(1);
    }
    http_response_code(403);
    exit("Prístup odmietnutý.");
}
unset($requestedScript, $executedFile);

require_once __DIR__ . '/config_loader.php';

try {
    $env = loadAppConfig();
} catch (\RuntimeException $e) {
    error_log('Konfigurácia DB nebola načítaná: ' . $e->getMessage());

    if (PHP_SAPI === 'cli') {
        fwrite(STDERR, "Chyba: " . $e->getMessage() . "\n");
        exit(1);
    }

    http_response_code(500);
    exit("Chyba: Konfiguračný súbor sa nenašiel alebo je neplatný.");
}

$appTimezoneName = trim((string) ($env['APP_TIMEZONE'] ?? getenv('APP_TIMEZONE') ?: 'Europe/Bratislava'));
try {
    $appTimezone = new DateTimeZone($appTimezoneName);
} catch (\Throwable) {
    error_log('Konfigurácia APP_TIMEZONE je neplatná.');
    if (PHP_SAPI === 'cli') {
        fwrite(STDERR, "Chyba: APP_TIMEZONE nie je platné časové pásmo.\n");
        exit(1);
    }
    http_response_code(500);
    exit("Chyba: Konfigurácia časového pásma je neplatná.");
}
date_default_timezone_set($appTimezoneName);

$dbHost = (string) ($env['DB_HOST'] ?? '');
$dbName = (string) ($env['DB_NAME'] ?? '');
$dbUser = (string) ($env['DB_USER'] ?? '');
$dbPass = (string) ($env['DB_PASS'] ?? '');
$dbCharset = 'utf8mb4';

if ($dbHost === '' || $dbName === '' || $dbUser === '') {
    error_log('Konfigurácia DB je nekompletná.');
    if (PHP_SAPI === 'cli') {
        fwrite(STDERR, "Chyba: Databázová konfigurácia je nekompletná.\n");
        exit(1);
    }
    http_response_code(500);
    exit("Chyba: Databázová konfigurácia je nekompletná.");
}

$dsn = "mysql:host=$dbHost;dbname=$dbName;charset=$dbCharset";
$options = [
    PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
    PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
    PDO::ATTR_EMULATE_PREPARES => false,
];

try {
    $pdo = new PDO($dsn, $dbUser, $dbPass, $options);
    $pdo->exec("SET NAMES utf8mb4 COLLATE utf8mb4_unicode_ci");
    // Server beží bez STRICT_TRANS_TABLES, takže príliš dlhú hodnotu ticho skráti
    // namiesto chyby. Dĺžky sa validujú v PHP; toto je obrana do hĺbky pre prípad,
    // že by niektorá cesta validáciu obišla. Ostatné režimy servera zostávajú.
    $pdo->exec("SET SESSION sql_mode = CONCAT(@@sql_mode, ',STRICT_TRANS_TABLES')");
    // Číselný offset funguje aj na MariaDB bez nahratých timezone tabuliek.
    // Každé nové pripojenie ho vypočíta nanovo, takže rešpektuje letný čas.
    $databaseTimezoneOffset = (new DateTimeImmutable('now', $appTimezone))->format('P');
    $pdo->exec('SET time_zone = ' . $pdo->quote($databaseTimezoneOffset));
} catch (\PDOException $e) {
    error_log("Chyba pripojenia k databáze: " . $e->getMessage());
    if (PHP_SAPI === 'cli') {
        fwrite(STDERR, "Chyba: Pripojenie k databáze zlyhalo.\n");
        exit(1);
    }
    http_response_code(500);
    exit("Chyba: Pripojenie k databáze zlyhalo.");
}
