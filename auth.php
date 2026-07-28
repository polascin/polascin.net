<?php

declare(strict_types=1);

require_once __DIR__ . '/config_loader.php';

const SESSION_IDLE_TIMEOUT = 3600;
const APP_PASSWORD_MIN_BYTES = 8;
const APP_PASSWORD_MAX_BYTES = 72;
const APP_DUMMY_PASSWORD_HASH = '$2y$12$1tNSCTWlgcAYigjqkJKc4uj2t22PGxoKeDa2ajFJz1Bxb.I5bYPQy';

function getScriptNonce(): string {
    static $nonce = null;
    if ($nonce === null) {
        $nonce = base64_encode(random_bytes(18));
    }
    return $nonce;
}

function requestNeedsNoReferrer(): bool {
    $script = basename((string) ($_SERVER['SCRIPT_NAME'] ?? $_SERVER['PHP_SELF'] ?? ''));
    $sensitiveScripts = [
        'login.php',
        'admin.php',
        'admin_articles.php',
        'admin_content.php',
        'admin_contact.php',
        'admin_newsletter.php',
    ];
    return in_array($script, $sensitiveScripts, true);
}

function getRequestReferrerPolicy(): string {
    return requestNeedsNoReferrer() ? 'no-referrer' : 'strict-origin-when-cross-origin';
}

function sendSecurityHeaders(): void {
    if (php_sapi_name() === 'cli') {
        return;
    }
    header_remove('X-Powered-By');
    header('X-Frame-Options: SAMEORIGIN');
    header('X-XSS-Protection: 0');
    header('X-Content-Type-Options: nosniff');
    header('Strict-Transport-Security: max-age=31536000; includeSubDomains; preload');
    header('Referrer-Policy: ' . getRequestReferrerPolicy());
    header('Permissions-Policy: geolocation=(), microphone=(), camera=(), payment=(), usb=()');
    header('Cross-Origin-Opener-Policy: same-origin');
    header('X-Permitted-Cross-Domain-Policies: none');

    $nonce = getScriptNonce();
    $csp =
        "default-src 'self'; " .
        "img-src 'self' data: https:; " .
        "style-src 'self' https://fonts.googleapis.com 'nonce-{$nonce}'; " .
        "font-src 'self' https://fonts.gstatic.com; " .
        "script-src 'self' 'nonce-{$nonce}' https://www.googletagmanager.com https://www.google-analytics.com; " .
        "connect-src 'self' https://www.google-analytics.com https://*.google-analytics.com " .
            "https://analytics.google.com https://*.analytics.google.com https://stats.g.doubleclick.net; " .
        "frame-ancestors 'self'; base-uri 'self'; object-src 'none'; form-action 'self'; upgrade-insecure-requests";
    header('Content-Security-Policy: ' . $csp);
}

ini_set('session.cookie_httponly', '1');
ini_set('session.use_only_cookies', '1');
ini_set('session.use_strict_mode', '1');
ini_set('session.gc_maxlifetime', (string) SESSION_IDLE_TIMEOUT);

$isHttps = isRequestHttps();
ini_set('session.cookie_secure', $isHttps ? '1' : '0');
ini_set('session.cookie_samesite', 'Strict');

$projectSessionPath = __DIR__ . DIRECTORY_SEPARATOR . 'private' . DIRECTORY_SEPARATOR . 'sessions';
if ((is_dir($projectSessionPath) || @mkdir($projectSessionPath, 0700, true)) && is_writable($projectSessionPath)) {
    @chmod($projectSessionPath, 0700);
    session_save_path($projectSessionPath);
} else {
    $tempSessionPath = sys_get_temp_dir() . DIRECTORY_SEPARATOR . 'polascin_sessions';
    if ((is_dir($tempSessionPath) || @mkdir($tempSessionPath, 0700, true)) && is_writable($tempSessionPath)) {
        @chmod($tempSessionPath, 0700);
        session_save_path($tempSessionPath);
    }
}

if (session_status() === PHP_SESSION_NONE && !session_start()) {
    error_log('Nepodarilo sa spustiť PHP session.');
    http_response_code(500);
    exit('Chyba: Nepodarilo sa spustiť reláciu.');
}

if (!empty($_SESSION['user_id'])) {
    $now = time();
    if (isset($_SESSION['_last_activity']) && ($now - $_SESSION['_last_activity']) > SESSION_IDLE_TIMEOUT) {
        clearUserSession();
        if (!session_start()) {
            http_response_code(500);
            exit('Chyba: Nepodarilo sa obnoviť reláciu.');
        }
        setFlashMessage('info', 'Vaša relácia vypršala z dôvodu nečinnosti. Prihláste sa znova.');
        $currentScript = basename($_SERVER['SCRIPT_NAME'] ?? '');
        if (!in_array($currentScript, ['login.php'], true)) {
            header('Location: login.php');
            exit;
        }
    } else {
        $_SESSION['_last_activity'] = $now;
    }
}

sendSecurityHeaders();
date_default_timezone_set('Europe/Bratislava');

function isLoggedIn(): bool {
    return isset($_SESSION['user_id']) && (int) $_SESSION['user_id'] > 0;
}

function isAdmin(): bool {
    return !empty($_SESSION['is_admin']) && (int) $_SESSION['is_admin'] === 1;
}

function requireLogin(): void {
    if (!isLoggedIn()) {
        header('Location: login.php');
        exit;
    }
}

function requireAdmin(): void {
    requireLogin();
    if (!isAdmin()) {
        header('HTTP/1.1 403 Forbidden');
        exit('Prístup len pre administrátora.');
    }
}

function isAppPasswordValid(string $password): bool {
    $length = strlen($password);
    return $length >= APP_PASSWORD_MIN_BYTES
        && $length <= APP_PASSWORD_MAX_BYTES
        && preg_match('/[A-Z]/', $password) === 1
        && preg_match('/[a-z]/', $password) === 1
        && preg_match('/[0-9]/', $password) === 1;
}

function hashAppPassword(string $password): string {
    if (!isAppPasswordValid($password)) {
        throw new \InvalidArgumentException('Heslo nespĺňa bezpečnostné pravidlá.');
    }
    return password_hash($password, PASSWORD_DEFAULT);
}

function generateCsrfToken(): string {
    if (empty($_SESSION['csrf_token'])) {
        $_SESSION['csrf_token'] = bin2hex(random_bytes(32));
    }
    return $_SESSION['csrf_token'];
}

function validateCsrfToken(mixed $token): bool {
    if (!is_string($token) || !isset($_SESSION['csrf_token']) || $token === '') {
        return false;
    }
    $valid = hash_equals($_SESSION['csrf_token'], $token);
    $_SESSION['csrf_token'] = bin2hex(random_bytes(32));
    return $valid;
}

function regenerateSession(): void {
    session_regenerate_id(true);
}

function clearUserSession(): void {
    if (session_status() !== PHP_SESSION_ACTIVE) {
        session_start();
    }
    session_unset();
    $_SESSION = [];
    if (ini_get('session.use_cookies')) {
        $params = session_get_cookie_params();
        setcookie(session_name(), '', [
            'expires' => time() - 42000,
            'path' => $params['path'],
            'domain' => $params['domain'],
            'secure' => $params['secure'],
            'httponly' => $params['httponly'],
            'samesite' => $params['samesite'],
        ]);
        unset($_COOKIE[session_name()]);
    }
    session_destroy();
}

function setFlashMessage(string $type, string $message): void {
    $_SESSION['flash_message'] = ['type' => $type, 'message' => $message];
}

function popFlashMessage(): ?array {
    if (empty($_SESSION['flash_message']) || !is_array($_SESSION['flash_message'])) {
        return null;
    }
    $flash = $_SESSION['flash_message'];
    unset($_SESSION['flash_message']);
    return $flash;
}

function getAccessLogPdo(): ?PDO {
    $resolvedPdo = null;
    if (isset($GLOBALS['pdo']) && $GLOBALS['pdo'] instanceof PDO) {
        $resolvedPdo = $GLOBALS['pdo'];
    } else {
        $configPath = __DIR__ . '/db_config.php';
        if (is_file($configPath)) {
            try {
                require_once $configPath;
            } catch (\Throwable $e) {
                error_log('Access log DB load failed: ' . $e->getMessage());
            }
        }
        if (isset($pdo) && $pdo instanceof PDO) {
            $resolvedPdo = $pdo;
        }
        if ($resolvedPdo === null && isset($GLOBALS['pdo']) && $GLOBALS['pdo'] instanceof PDO) {
            $resolvedPdo = $GLOBALS['pdo'];
        }
    }
    return $resolvedPdo;
}

function saveAccessLog(array $record): bool {
    $pdo = getAccessLogPdo();
    if ($pdo === null) {
        return false;
    }
    try {
        $stmt = $pdo->prepare(
            "INSERT INTO access_logs (
                user_id, username, method, request_uri, query_string, http_status,
                client_ip, user_agent, referer, host, response_time_ms, is_bot
            ) VALUES (
                :user_id, :username, :method, :request_uri, :query_string, :http_status,
                :client_ip, :user_agent, :referer, :host, :response_time_ms, :is_bot
            )"
        );
        $stmt->execute([
            ':user_id' => $record['user_id'] ?? null,
            ':username' => $record['username'] ?? null,
            ':method' => $record['method'],
            ':request_uri' => $record['request_uri'],
            ':query_string' => $record['query_string'],
            ':http_status' => $record['http_status'],
            ':client_ip' => $record['client_ip'],
            ':user_agent' => $record['user_agent'],
            ':referer' => $record['referer'],
            ':host' => $record['host'],
            ':response_time_ms' => $record['response_time_ms'],
            ':is_bot' => $record['is_bot'],
        ]);
        return true;
    } catch (\PDOException $e) {
        error_log('Access log write failed: ' . $e->getMessage());
        return false;
    }
}

function registerAccessLogger(): void {
    register_shutdown_function('recordAccessLogShutdown');
}

function recordAccessLogShutdown(): void {
    if (php_sapi_name() === 'cli') {
        return;
    }
    $method = $_SERVER['REQUEST_METHOD'] ?? 'GET';
    $uri = (string) ($_SERVER['REQUEST_URI'] ?? ($_SERVER['PHP_SELF'] ?? '/'));
    $query = (string) ($_SERVER['QUERY_STRING'] ?? '');
    $status = http_response_code();
    if (!is_int($status) || $status < 100 || $status > 599) {
        $status = 200;
    }

    $record = [
        'user_id' => isLoggedIn() ? (int) ($_SESSION['user_id'] ?? 0) : null,
        'username' => $_SESSION['username'] ?? null,
        'method' => $method,
        'request_uri' => $uri,
        'query_string' => $query,
        'http_status' => $status,
        'client_ip' => getClientIpAddress(),
        'user_agent' => mb_substr((string) ($_SERVER['HTTP_USER_AGENT'] ?? ''), 0, 500),
        'referer' => mb_substr((string) ($_SERVER['HTTP_REFERER'] ?? ''), 0, 2048),
        'host' => mb_substr((string) ($_SERVER['HTTP_HOST'] ?? ''), 0, 255),
        'response_time_ms' => isset($_SERVER['REQUEST_TIME_FLOAT']) ? (int) round((microtime(true) - $_SERVER['REQUEST_TIME_FLOAT']) * 1000) : null,
        'is_bot' => isKnownBotUserAgent() ? 1 : 0,
    ];

    if (!saveAccessLog($record)) {
        error_log('Access log fallback: ' . json_encode($record, JSON_UNESCAPED_UNICODE));
    }
}

function isKnownBotUserAgent(): bool {
    $ua = $_SERVER['HTTP_USER_AGENT'] ?? '';
    if (empty($ua)) {
        return true;
    }
    $patterns = ['/curl/i', '/Wget/i', '/libwww-perl/i', '/Python-urllib/i', '/php/i', '/Go-http-client/i', '/Java\//i', '/PostmanRuntime/i', '/axios/i'];
    foreach ($patterns as $pattern) {
        if (preg_match($pattern, $ua)) {
            return true;
        }
    }
    return false;
}

function isEmailDomainValid(string $email): bool {
    if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        return false;
    }
    $domain = substr(strrchr($email, '@'), 1);
    return $domain !== '' && (checkdnsrr($domain, 'MX') || checkdnsrr($domain, 'A'));
}

function columnExists(PDO $pdo, string $table, string $column): bool {
    $stmt = $pdo->prepare(
        "SELECT COUNT(*) FROM INFORMATION_SCHEMA.COLUMNS
         WHERE TABLE_SCHEMA = DATABASE() AND TABLE_NAME = :table AND COLUMN_NAME = :column"
    );
    $stmt->execute(['table' => $table, 'column' => $column]);
    return (int) $stmt->fetchColumn() > 0;
}

function checkFormRateLimit(PDO $pdo, string $action, string $ip, int $maxAttempts, int $windowSeconds): bool {
    $pdo->beginTransaction();
    try {
        $pdo->prepare(
            "DELETE FROM form_rate_limit
             WHERE action = :action AND blocked_until IS NOT NULL AND blocked_until < NOW()"
        )->execute(['action' => $action]);

        $pdo->prepare(
            "INSERT INTO form_rate_limit (ip, action, attempt_count, first_attempt, last_attempt)
             VALUES (:ip, :action, 0, NOW(), NOW())
             ON DUPLICATE KEY UPDATE id = id"
        )->execute(['ip' => $ip, 'action' => $action]);

        $rowStmt = $pdo->prepare(
            "SELECT attempt_count, first_attempt, blocked_until
             FROM form_rate_limit
             WHERE ip = :ip AND action = :action
             FOR UPDATE"
        );
        $rowStmt->execute(['ip' => $ip, 'action' => $action]);
        $row = $rowStmt->fetch();

        $now = time();
        if ($row && !empty($row['blocked_until']) && strtotime((string) $row['blocked_until']) > $now) {
            $pdo->commit();
            return false;
        }

        $firstAttempt = !empty($row['first_attempt']) ? strtotime((string) $row['first_attempt']) : $now;
        $windowExpired = ($now - $firstAttempt) >= $windowSeconds;
        $count = $windowExpired ? 1 : ((int) ($row['attempt_count'] ?? 0) + 1);
        $blockedUntil = ($count > $maxAttempts) ? date('Y-m-d H:i:s', $now + $windowSeconds) : null;

        $updStmt = $pdo->prepare(
            "UPDATE form_rate_limit
             SET attempt_count = :count,
                 first_attempt = IF(:reset_window = 1, NOW(), first_attempt),
                 last_attempt = NOW(),
                 blocked_until = :blocked_until
             WHERE ip = :ip AND action = :action"
        );
        $updStmt->execute([
            'count' => $count,
            'reset_window' => $windowExpired ? 1 : 0,
            'blocked_until' => $blockedUntil,
            'ip' => $ip,
            'action' => $action,
        ]);

        $pdo->commit();
        return $count <= $maxAttempts;
    } catch (\Throwable $e) {
        if ($pdo->inTransaction()) {
            $pdo->rollBack();
        }
        error_log('Rate-limit chyba (' . $action . '): ' . $e->getMessage());
        return true;
    }
}

function logAdminAction(PDO $pdo, string $action, ?string $targetType = null, ?int $targetId = null, array $details = []): void {
    if (!isLoggedIn() || empty($_SESSION['user_id'])) {
        return;
    }
    try {
        $stmt = $pdo->prepare(
            "INSERT INTO admin_audit_log
                (admin_user_id, action, target_type, target_id, details, client_ip, user_agent)
             VALUES (:admin_user_id, :action, :target_type, :target_id, :details, :client_ip, :user_agent)"
        );
        $stmt->execute([
            ':admin_user_id' => (int) $_SESSION['user_id'],
            ':action' => substr($action, 0, 120),
            ':target_type' => $targetType !== null ? substr($targetType, 0, 60) : null,
            ':target_id' => $targetId,
            ':details' => empty($details) ? null : json_encode($details, JSON_UNESCAPED_UNICODE | JSON_UNESCAPED_SLASHES),
            ':client_ip' => getClientIpAddress(),
            ':user_agent' => $_SERVER['HTTP_USER_AGENT'] ?? null,
        ]);
    } catch (\Throwable $e) {
        error_log('logAdminAction failed: ' . $e->getMessage());
    }
}

registerAccessLogger();
