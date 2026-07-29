<?php

declare(strict_types=1);

$requestedScript = str_replace('\\', '/', (string) ($_SERVER['SCRIPT_NAME'] ?? $_SERVER['PHP_SELF'] ?? ''));
$executedFile = isset($_SERVER['SCRIPT_FILENAME']) ? realpath((string) $_SERVER['SCRIPT_FILENAME']) : false;
if (
    $executedFile === __FILE__
    || preg_match('~(?:^|/)auth\.php(?:/|$)~i', $requestedScript) === 1
) {
    if (PHP_SAPI === 'cli') {
        fwrite(STDERR, "Chyba: auth.php je interný súbor a nemožno ho spúšťať priamo.\n");
        exit(1);
    }
    http_response_code(403);
    exit('Prístup odmietnutý.');
}
unset($requestedScript, $executedFile);

require_once __DIR__ . '/config_loader.php';
require_once __DIR__ . '/helpers.php';

const SESSION_IDLE_TIMEOUT = 3600;
const SESSION_ACCOUNT_RECHECK_INTERVAL = 60;
const APP_DUMMY_PASSWORD_HASH = '$2y$12$1tNSCTWlgcAYigjqkJKc4uj2t22PGxoKeDa2ajFJz1Bxb.I5bYPQy';

function getScriptNonce(): string {
    static $nonce = null;
    if ($nonce === null) {
        $nonce = base64_encode(random_bytes(18));
    }
    return $nonce;
}

function requestNeedsNoReferrer(): bool {
    $script = str_replace('\\', '/', (string) ($_SERVER['SCRIPT_NAME'] ?? $_SERVER['PHP_SELF'] ?? ''));
    $sensitiveScripts = [
        'login.php',
        'admin.php',
        'admin_articles.php',
        'admin_content.php',
        'admin_contact.php',
        'admin_newsletter.php',
        'logout.php',
        'newsletter.php',
    ];
    foreach ($sensitiveScripts as $sensitiveScript) {
        if (preg_match('~(?:^|/)' . preg_quote($sensitiveScript, '~') . '(?:/|$)~i', $script) === 1) {
            return true;
        }
    }
    return false;
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
    if (isRequestHttps()) {
        header('Strict-Transport-Security: max-age=31536000; includeSubDomains; preload');
    }
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
        "frame-ancestors 'self'; base-uri 'self'; object-src 'none'; form-action 'self'";
    if (isRequestHttps()) {
        $csp .= '; upgrade-insecure-requests';
    }
    header('Content-Security-Policy: ' . $csp);

    // Odpoveď sa líši podľa zvoleného jazyka, ktorý pochádza z cookie alebo
    // z Accept-Language. Bez Vary by zdieľaná cache mohla podať odpoveď
    // v cudzom jazyku — aj s hlavičkou Set-Cookie, ktorá jazyk pripne.
    header('Vary: Cookie, Accept-Language', false);

    if (requestNeedsNoReferrer()) {
        header('Cache-Control: no-store, private');
        header('Pragma: no-cache');
    } else {
        // Verejné stránky sa smú ukladať len v prehliadači návštevníka, nikdy
        // v zdieľanej cache.
        header('Cache-Control: private, max-age=0, must-revalidate');
    }
}

ini_set('session.cookie_httponly', '1');
ini_set('session.cookie_path', '/');
ini_set('session.use_only_cookies', '1');
ini_set('session.use_strict_mode', '1');
ini_set('session.gc_maxlifetime', (string) SESSION_IDLE_TIMEOUT);

$isHttps = isRequestHttps();
ini_set('session.cookie_secure', $isHttps ? '1' : '0');
ini_set('session.cookie_samesite', 'Strict');
if (session_status() === PHP_SESSION_NONE) {
    session_name('POLASCINSESSID');
    // Bez tohto pridá session_start() vlastnú sadu `Expires: 1981` a
    // `Pragma: no-cache`. Tú prvú síce sendSecurityHeaders() prepíše, ale
    // zvyšné dve v odpovedi ostanú a protirečia `private, max-age=0,
    // must-revalidate` na verejných stránkach. O cache rozhoduje výhradne
    // sendSecurityHeaders(), ktorá citlivým stránkam `Pragma` nastaví sama.
    session_cache_limiter('');
}

/**
 * Kandidáti na úložisko relácií, od najbezpečnejšieho.
 *
 * Názov súboru relácie je samotné session ID, takže adresár, ktorý by server
 * dokázal podať, znamená prevzatie relácie. Prvá voľba preto leží **mimo web
 * rootu** — rovnako ako konfiguračný súbor, ktorý `config_loader.php` hľadá
 * najprv v nadradenom `private/`. Cesta vnútri web rootu zostáva ako záloha pre
 * prostredia, kde nadradený adresár zapisovateľný nie je; tam ju chráni
 * `.htaccess`.
 */
function appSessionSavePaths(): array {
    $appRoot = __DIR__;
    $parentRoot = dirname($appRoot);

    return [
        $parentRoot . DIRECTORY_SEPARATOR . 'private' . DIRECTORY_SEPARATOR . 'sessions',
        $appRoot . DIRECTORY_SEPARATOR . 'private' . DIRECTORY_SEPARATOR . 'sessions',
        sys_get_temp_dir() . DIRECTORY_SEPARATOR . 'polascin_sessions',
    ];
}

foreach (appSessionSavePaths() as $candidateSessionPath) {
    if ((is_dir($candidateSessionPath) || @mkdir($candidateSessionPath, 0700, true)) && is_writable($candidateSessionPath)) {
        @chmod($candidateSessionPath, 0700);
        session_save_path($candidateSessionPath);
        break;
    }
}
unset($candidateSessionPath);

if (session_status() === PHP_SESSION_NONE && !session_start()) {
    error_log('Nepodarilo sa spustiť PHP session.');
    http_response_code(500);
    exit('Chyba: Nepodarilo sa spustiť reláciu.');
}

// Hlavičky sa posielajú ešte pred vetvou s vypršaním relácie, ktorá končí
// presmerovaním a exitom — aj tá odpoveď musí niesť no-store a ostatné hlavičky.
sendSecurityHeaders();

if (!empty($_SESSION['user_id'])) {
    $now = time();
    if (isset($_SESSION['_last_activity']) && ($now - $_SESSION['_last_activity']) > SESSION_IDLE_TIMEOUT) {
        clearUserSession();
        if (!session_start()) {
            http_response_code(500);
            exit('Chyba: Nepodarilo sa obnoviť reláciu.');
        }
        setFlashMessage('info', t('login.session_expired'));
        $currentScript = basename($_SERVER['SCRIPT_NAME'] ?? '');
        if (!in_array($currentScript, ['login.php'], true)) {
            header('Location: login.php');
            exit;
        }
    } else {
        $_SESSION['_last_activity'] = $now;
    }
}

try {
    $authEnv = loadAppConfig();
    $authTimezone = trim((string) ($authEnv['APP_TIMEZONE'] ?? 'Europe/Bratislava'));
    new DateTimeZone($authTimezone);
    date_default_timezone_set($authTimezone);
} catch (\Throwable) {
    date_default_timezone_set('Europe/Bratislava');
}
unset($authEnv, $authTimezone);

function isLoggedIn(): bool {
    return isset($_SESSION['user_id']) && (int) $_SESSION['user_id'] > 0;
}

function isAdmin(): bool {
    return !empty($_SESSION['is_admin']) && (int) $_SESSION['is_admin'] === 1;
}

/**
 * Znovu overí, či je účet v relácii stále aktívny a s akými právami.
 *
 * Bez tejto kontroly by deaktivácia alebo degradácia účtu v databáze nemala
 * žiadny účinok na už prebiehajúcu reláciu — a keďže sa `_last_activity`
 * obnovuje pri každej požiadavke, aktívne používaná ukradnutá relácia by
 * nevypršala nikdy. Výsledok sa cachuje, aby to nebol dotaz navyše pri každom
 * načítaní stránky.
 */
function revalidateSessionAccount(): void {
    if (!isLoggedIn()) {
        return;
    }

    $now = time();
    $checkedAt = isset($_SESSION['_account_checked']) ? (int) $_SESSION['_account_checked'] : 0;
    if ($checkedAt > 0 && ($now - $checkedAt) < SESSION_ACCOUNT_RECHECK_INTERVAL) {
        return;
    }

    $pdo = getAccessLogPdo();
    if (!$pdo instanceof PDO) {
        return;
    }

    try {
        $stmt = $pdo->prepare("SELECT is_admin, is_active FROM users WHERE id = :id LIMIT 1");
        $stmt->execute([':id' => (int) $_SESSION['user_id']]);
        $account = $stmt->fetch();
    } catch (\Throwable $e) {
        error_log('Nepodarilo sa overiť stav účtu: ' . $e->getMessage());
        return;
    }

    if (!is_array($account) || (int) $account['is_active'] !== 1) {
        clearUserSession();
        if (!session_start()) {
            http_response_code(500);
            exit('Chyba: Nepodarilo sa obnoviť reláciu.');
        }
        setFlashMessage('info', t('login.account_inactive'));
        header('Location: login.php');
        exit;
    }

    $_SESSION['is_admin'] = (int) $account['is_admin'];
    $_SESSION['_account_checked'] = $now;
}

function requireLogin(): void {
    if (!isLoggedIn()) {
        header('Location: login.php');
        exit;
    }
    revalidateSessionAccount();
}

function requireAdmin(): void {
    requireLogin();
    if (!isAdmin()) {
        header('HTTP/1.1 403 Forbidden');
        exit('Prístup len pre administrátora.');
    }
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
    if ($valid) {
        $_SESSION['csrf_token'] = bin2hex(random_bytes(32));
    }
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
    if (isset($GLOBALS['pdo']) && $GLOBALS['pdo'] instanceof PDO) {
        return $GLOBALS['pdo'];
    }
    return null;
}

function saveAccessLog(array $record, PDO $pdo): bool {
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
        if (random_int(1, 100) === 1) {
            $cutoff = date('Y-m-d H:i:s', time() - (getAccessLogRetentionDays() * 86400));
            $cleanup = $pdo->prepare("DELETE FROM access_logs WHERE created_at < :cutoff");
            $cleanup->execute([':cutoff' => $cutoff]);
        }
        return true;
    } catch (\Throwable $e) {
        error_log('Access log write failed: ' . $e->getMessage());
        return false;
    }
}

function registerAccessLogger(): void {
    if (isAccessLoggingEnabled()) {
        register_shutdown_function('recordAccessLogShutdown');
    }
}

function isAccessLoggingEnabled(): bool {
    try {
        $env = loadAppConfig();
    } catch (\RuntimeException) {
        return false;
    }
    return parseEnvBool($env['ACCESS_LOG_ENABLED'] ?? getenv('ACCESS_LOG_ENABLED'), true);
}

function getAccessLogRetentionDays(): int {
    try {
        $env = loadAppConfig();
    } catch (\RuntimeException) {
        return 90;
    }
    $days = (int) ($env['ACCESS_LOG_RETENTION_DAYS'] ?? getenv('ACCESS_LOG_RETENTION_DAYS') ?: 90);
    return max(1, min($days, 365));
}

function redactSensitiveQuery(string $query): string {
    $redacted = preg_replace_callback(
        '/(^|[&;])([^=&;]*)(?:=([^&;]*))?/',
        static function (array $matches): string {
            $separator = $matches[1] ?? '';
            $rawKey = $matches[2] ?? '';
            $key = strtolower(rawurldecode($rawKey));
            $isSensitive = preg_match(
                '/(?:^|[^a-z0-9])(?:authorization|code|csrf|email|key|password|secret|signature|token)(?:$|[^a-z0-9])/',
                $key
            ) === 1;
            if ($isSensitive) {
                return $separator . $rawKey . '=%5BREDACTED%5D';
            }
            return $matches[0];
        },
        $query
    );
    return $redacted ?? '';
}

function redactSensitiveUrl(string $url): string {
    $queryPosition = strpos($url, '?');
    if ($queryPosition === false) {
        return $url;
    }
    $path = substr($url, 0, $queryPosition);
    $query = substr($url, $queryPosition + 1);
    return $path . '?' . redactSensitiveQuery($query);
}

function recordAccessLogShutdown(): void {
    if (php_sapi_name() === 'cli') {
        return;
    }
    $method = $_SERVER['REQUEST_METHOD'] ?? 'GET';
    $uri = redactSensitiveUrl((string) ($_SERVER['REQUEST_URI'] ?? ($_SERVER['PHP_SELF'] ?? '/')));
    $query = redactSensitiveQuery((string) ($_SERVER['QUERY_STRING'] ?? ''));
    $status = http_response_code();
    if (!is_int($status) || $status < 100 || $status > 599) {
        $status = 200;
    }

    $record = [
        'user_id' => isLoggedIn() ? (int) ($_SESSION['user_id'] ?? 0) : null,
        'username' => $_SESSION['username'] ?? null,
        'method' => appTextSlice(strtoupper((string) $method), 0, 10),
        'request_uri' => appTextSlice($uri, 0, 2048),
        'query_string' => appTextSlice($query, 0, 2048),
        'http_status' => $status,
        'client_ip' => getClientIpAddress(),
        'user_agent' => appTextSlice((string) ($_SERVER['HTTP_USER_AGENT'] ?? ''), 0, 500),
        'referer' => appTextSlice(redactSensitiveUrl((string) ($_SERVER['HTTP_REFERER'] ?? '')), 0, 2048),
        'host' => appTextSlice((string) ($_SERVER['HTTP_HOST'] ?? ''), 0, 255),
        'response_time_ms' => isset($_SERVER['REQUEST_TIME_FLOAT']) ? (int) round((microtime(true) - $_SERVER['REQUEST_TIME_FLOAT']) * 1000) : null,
        'is_bot' => isKnownBotUserAgent() ? 1 : 0,
    ];

    $pdo = getAccessLogPdo();
    if ($pdo === null) {
        return;
    }
    if (!saveAccessLog($record, $pdo)) {
        error_log('Access log nebolo možné uložiť.');
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
    if (!function_exists('checkdnsrr')) {
        return true;
    }
    $domain = substr(strrchr($email, '@'), 1);
    return $domain !== '' && (checkdnsrr($domain, 'MX') || checkdnsrr($domain, 'A'));
}

function checkFormRateLimit(PDO $pdo, string $action, string $ip, int $maxAttempts, int $windowSeconds): bool {
    try {
        // Housekeeping nie je súčasťou kritickej transakcie a beží iba občas.
        // Index (action, last_attempt) pridáva verzovaná migrácia.
        if (random_int(1, 100) === 1) {
            $cleanupBefore = date('Y-m-d H:i:s', time() - max($windowSeconds * 2, 86400));
            try {
                $pdo->prepare(
                    "DELETE FROM form_rate_limit
                     WHERE action = :action
                       AND (
                           (blocked_until IS NOT NULL AND blocked_until < NOW())
                           OR last_attempt < :cleanup_before
                       )"
                )->execute(['action' => $action, 'cleanup_before' => $cleanupBefore]);
            } catch (\Throwable $cleanupError) {
                error_log('Rate-limit cleanup chyba (' . $action . '): ' . $cleanupError->getMessage());
            }
        }

        $pdo->beginTransaction();
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
        return false;
    }
}

function clearFormRateLimit(PDO $pdo, string $action, string $ip): void {
    try {
        $stmt = $pdo->prepare("DELETE FROM form_rate_limit WHERE ip = :ip AND action = :action");
        $stmt->execute([':ip' => $ip, ':action' => $action]);
    } catch (\PDOException $e) {
        error_log('Rate-limit reset chyba (' . $action . '): ' . $e->getMessage());
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
            ':user_agent' => appTextSlice((string) ($_SERVER['HTTP_USER_AGENT'] ?? ''), 0, 500),
        ]);
        $cleanup = $pdo->prepare("DELETE FROM admin_audit_log WHERE created_at < :cutoff");
        $cleanup->execute([':cutoff' => date('Y-m-d H:i:s', time() - 31536000)]);
    } catch (\Throwable $e) {
        error_log('logAdminAction failed: ' . $e->getMessage());
    }
}

registerAccessLogger();
