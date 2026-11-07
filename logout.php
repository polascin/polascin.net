<?php

declare(strict_types=1);

require_once __DIR__ . '/auth.php';
require_once __DIR__ . '/db_config.php';

/** @var PDO $pdo */

if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    header('Allow: POST');
    http_response_code(405);
    exit('Táto akcia vyžaduje odoslanie formulára.');
}

$csrfToken = $_POST['csrf_token'] ?? '';
$trustedOrigin = isTrustedStateChangingRequest();
if (!$trustedOrigin || !validateCsrfToken($csrfToken)) {
    logCsrfFailure('logout', $trustedOrigin, $csrfToken);
    // Hlásenie sa vykreslí na verejnej stránke, teda v jazyku návštevníka.
    setFlashMessage('error', t('logout.csrf_failed'));
    if (!isLoggedIn()) {
        $csrfDestination = langUrl(currentLang(), 'index.php');
    } elseif (!empty($_SESSION['must_change_password'])) {
        $csrfDestination = 'admin_users.php?change_required=1';
    } else {
        $csrfDestination = 'admin.php';
    }
    header('Location: ' . $csrfDestination, true, 303);
    exit;
}

logAdminAction($pdo, 'logout', 'session');
$homeAfterLogout = langUrl(currentLang(), 'index.php');
clearUserSession();
if (!session_start()) {
    http_response_code(500);
    exit('Chyba: Nepodarilo sa obnoviť reláciu.');
}
setFlashMessage('info', t('logout.success'));
header('Location: ' . $homeAfterLogout, true, 303);
exit;
