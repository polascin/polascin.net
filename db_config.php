<?php

declare(strict_types=1);

// Ochrana pred priamym prístupom k súboru
if (basename($_SERVER['PHP_SELF']) === basename(__FILE__)) {
    header("HTTP/1.1 403 Forbidden");
    exit("Prístup odmietnutý.");
}

require_once __DIR__ . '/config_loader.php';

date_default_timezone_set('Europe/Bratislava');

try {
    $env = loadAppConfig();
} catch (\RuntimeException $e) {
    error_log('Konfigurácia DB nebola načítaná: ' . $e->getMessage());

    $isCli = php_sapi_name() === 'cli';
    $host = strtolower((string) ($_SERVER['SERVER_NAME'] ?? ''));
    $isLocalHttp = in_array($host, ['localhost', '127.0.0.1', '::1'], true);

    if ($isCli || $isLocalHttp) {
        exit("Chyba: " . $e->getMessage());
    }

    exit("Chyba: Konfiguračný súbor sa nenašiel alebo je neplatný.");
}

$dbHost = (string) ($env['DB_HOST'] ?? '');
$dbName = (string) ($env['DB_NAME'] ?? '');
$dbUser = (string) ($env['DB_USER'] ?? '');
$dbPass = (string) ($env['DB_PASS'] ?? '');
$dbCharset = 'utf8mb4';

if ($dbHost === '' || $dbName === '' || $dbUser === '') {
    error_log('Konfigurácia DB je nekompletná.');
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
} catch (\PDOException $e) {
    error_log("Chyba pripojenia k databáze: " . $e->getMessage());
    exit("Chyba: Pripojenie k databáze zlyhalo.");
}
