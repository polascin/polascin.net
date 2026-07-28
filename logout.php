<?php

declare(strict_types=1);

require_once __DIR__ . '/auth.php';
require_once __DIR__ . '/db_config.php';

/** @var PDO $pdo */

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $csrfToken = $_POST['csrf_token'] ?? '';
    if (validateCsrfToken((string) $csrfToken)) {
        clearUserSession();
    }
}

setFlashMessage('info', 'You have been logged out.');
header('Location: index.php');
exit;
