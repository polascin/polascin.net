<?php

declare(strict_types=1);

require_once __DIR__ . '/auth.php';

if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    header('Allow: POST');
    http_response_code(405);
    exit('Táto akcia vyžaduje odoslanie formulára.');
}

$csrfToken = $_POST['csrf_token'] ?? '';
if (!validateCsrfToken((string) $csrfToken)) {
    setFlashMessage('error', 'Odhlásenie sa nepodarilo overiť. Skúste to znova.');
    header('Location: ' . (isLoggedIn() ? 'admin.php' : 'index.php'), true, 303);
    exit;
}

clearUserSession();
if (!session_start()) {
    http_response_code(500);
    exit('Chyba: Nepodarilo sa obnoviť reláciu.');
}
setFlashMessage('info', 'Boli ste odhlásení.');
header('Location: index.php', true, 303);
exit;
