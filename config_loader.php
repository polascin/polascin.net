<?php

declare(strict_types=1);

// Ochrana pred priamym prístupom vrátane požiadaviek s PATH_INFO.
$requestedScript = str_replace('\\', '/', (string) ($_SERVER['SCRIPT_NAME'] ?? $_SERVER['PHP_SELF'] ?? ''));
$executedFile = isset($_SERVER['SCRIPT_FILENAME']) ? realpath((string) $_SERVER['SCRIPT_FILENAME']) : false;
if (
    $executedFile === __FILE__
    || preg_match('~(?:^|/)config_loader\.php(?:/|$)~i', $requestedScript) === 1
) {
    if (PHP_SAPI === 'cli') {
        fwrite(STDERR, "Chyba: config_loader.php je interný súbor a nemožno ho spúšťať priamo.\n");
        exit(1);
    }
    header("HTTP/1.1 403 Forbidden");
    exit("Prístup odmietnutý.");
}
unset($requestedScript, $executedFile);

class AppConfigException extends RuntimeException {}

function getAppConfigPaths(): array {
    $paths = [];

    $envOverride = trim((string) getenv('POLASCIN_ENV_PATH'));
    if ($envOverride !== '') {
        $paths[] = $envOverride;
    }

    $appRoot = __DIR__;
    $parentRoot = dirname($appRoot);

    $paths[] = $parentRoot . DIRECTORY_SEPARATOR . 'polascin.env.ini';
    $paths[] = $parentRoot . DIRECTORY_SEPARATOR . 'private' . DIRECTORY_SEPARATOR . 'polascin.env.ini';
    $paths[] = $parentRoot . DIRECTORY_SEPARATOR . 'private' . DIRECTORY_SEPARATOR . 'env.ini';
    $paths[] = $appRoot . DIRECTORY_SEPARATOR . 'private' . DIRECTORY_SEPARATOR . 'polascin.env.ini';
    $paths[] = $appRoot . DIRECTORY_SEPARATOR . 'private' . DIRECTORY_SEPARATOR . 'env.ini';
    $paths[] = $appRoot . DIRECTORY_SEPARATOR . 'env.ini';

    return array_values(array_unique($paths));
}

function loadAppConfig(): array {
    static $config = null;
    if ($config !== null) {
        return $config;
    }

    foreach (getAppConfigPaths() as $path) {
        if (!is_file($path) || !is_readable($path)) {
            continue;
        }
        $parsed = parse_ini_file($path, false, INI_SCANNER_TYPED);
        if ($parsed !== false) {
            $config = $parsed;
            return $parsed;
        }
    }

    throw new AppConfigException('Konfiguračný súbor sa nenašiel. Hľadané cesty: ' . implode(', ', getAppConfigPaths()));
}

function parseEnvBool(mixed $value, bool $default = false): bool {
    if ($value === null) {
        return $default;
    }
    $normalized = strtolower(trim((string) $value));
    if ($normalized === '') {
        return $default;
    }
    return in_array($normalized, ['1', 'true', 'yes', 'on'], true);
}

function ipMatchesCidr(string $ip, string $cidr): bool {
    $cidr = trim($cidr);
    if ($cidr === '') {
        return false;
    }

    [$network, $prefixText] = array_pad(explode('/', $cidr, 2), 2, null);
    $ipBinary = @inet_pton($ip);
    $networkBinary = @inet_pton($network);
    if ($ipBinary === false || $networkBinary === false || strlen($ipBinary) !== strlen($networkBinary)) {
        return false;
    }

    $maxBits = strlen($ipBinary) * 8;
    $prefix = $prefixText === null ? $maxBits : filter_var(
        $prefixText,
        FILTER_VALIDATE_INT,
        ['options' => ['min_range' => 0, 'max_range' => $maxBits]]
    );
    if ($prefix === false) {
        return false;
    }

    $wholeBytes = intdiv((int) $prefix, 8);
    $remainingBits = (int) $prefix % 8;
    if ($wholeBytes > 0 && substr($ipBinary, 0, $wholeBytes) !== substr($networkBinary, 0, $wholeBytes)) {
        return false;
    }
    if ($remainingBits === 0) {
        return true;
    }

    $mask = (0xFF << (8 - $remainingBits)) & 0xFF;
    return (ord($ipBinary[$wholeBytes]) & $mask) === (ord($networkBinary[$wholeBytes]) & $mask);
}

function getTrustedProxyRanges(array $env): array {
    $raw = trim((string) ($env['TRUSTED_PROXY_IPS'] ?? getenv('TRUSTED_PROXY_IPS') ?: ''));
    if ($raw === '') {
        return [];
    }

    $ranges = preg_split('/[\s,;]+/', $raw, -1, PREG_SPLIT_NO_EMPTY);
    return is_array($ranges) ? array_values(array_unique($ranges)) : [];
}

function isTrustedProxyAddress(string $ip, array $env): bool {
    if (!filter_var($ip, FILTER_VALIDATE_IP)) {
        return false;
    }
    foreach (getTrustedProxyRanges($env) as $range) {
        if (ipMatchesCidr($ip, $range)) {
            return true;
        }
    }
    return false;
}

function canTrustProxyHeaders(array $env): bool {
    if (!parseEnvBool($env['TRUST_PROXY_HEADERS'] ?? getenv('TRUST_PROXY_HEADERS'), false)) {
        return false;
    }
    return isTrustedProxyAddress((string) ($_SERVER['REMOTE_ADDR'] ?? ''), $env);
}

function isAppLocalDev(): bool {
    try {
        $env = loadAppConfig();
    } catch (RuntimeException) {
        $env = [];
    }

    $appEnv = strtolower(trim((string) ($env['APP_ENV'] ?? getenv('APP_ENV') ?? '')));
    if ($appEnv !== '') {
        return in_array($appEnv, ['local', 'dev', 'development', 'test', 'testing'], true);
    }

    return parseEnvBool($env['APP_LOCAL_DEV'] ?? getenv('APP_LOCAL_DEV'), false);
}

function isRequestHttps(): bool {
    $httpsFlag = $_SERVER['HTTPS'] ?? null;
    $httpsFromFlag = !empty($httpsFlag) && strtolower((string) $httpsFlag) !== 'off';
    $httpsFromPort = isset($_SERVER['SERVER_PORT']) && (int) $_SERVER['SERVER_PORT'] === 443;
    $isHttps = $httpsFromFlag || $httpsFromPort;

    try {
        $env = loadAppConfig();
    } catch (RuntimeException) {
        $env = [];
    }

    if (!$isHttps && canTrustProxyHeaders($env)) {
        $forwardedValues = array_map('trim', explode(',', strtolower((string) ($_SERVER['HTTP_X_FORWARDED_PROTO'] ?? ''))));
        $forwardedProto = end($forwardedValues);
        if ($forwardedProto === 'https') {
            $isHttps = true;
        }
    }
    if (!$isHttps && !isAppLocalDev()) {
        $configuredBaseUrl = trim((string) ($env['APP_BASE_URL'] ?? getenv('APP_BASE_URL') ?: ''));
        $isHttps = strtolower((string) parse_url($configuredBaseUrl, PHP_URL_SCHEME)) === 'https';
    }

    return $isHttps;
}

function getClientIpAddress(): string {
    $defaultIp = $_SERVER['REMOTE_ADDR'] ?? '0.0.0.0';

    try {
        $env = loadAppConfig();
    } catch (RuntimeException) {
        $env = [];
    }

    if (canTrustProxyHeaders($env)) {
        $forwarded = (string) ($_SERVER['HTTP_X_FORWARDED_FOR'] ?? '');
        $chain = [];
        foreach (explode(',', $forwarded) as $candidate) {
            $candidate = trim($candidate);
            if (filter_var($candidate, FILTER_VALIDATE_IP)) {
                $chain[] = $candidate;
            }
        }
        $chain[] = $defaultIp;

        for ($i = count($chain) - 1; $i >= 0; $i--) {
            if (!isTrustedProxyAddress($chain[$i], $env)) {
                return $chain[$i];
            }
        }

        $realIp = trim((string) ($_SERVER['HTTP_X_REAL_IP'] ?? ''));
        if (filter_var($realIp, FILTER_VALIDATE_IP)) {
            return $realIp;
        }
    }

    return filter_var($defaultIp, FILTER_VALIDATE_IP) ? $defaultIp : '0.0.0.0';
}

function getAppBaseUrl(): string {
    try {
        $env = loadAppConfig();
    } catch (RuntimeException) {
        $env = [];
    }

    $configured = trim((string) ($env['APP_BASE_URL'] ?? getenv('APP_BASE_URL') ?? ''));
    if ($configured !== '' && filter_var($configured, FILTER_VALIDATE_URL)) {
        return rtrim($configured, '/');
    }

    // Mimo lokálneho vývoja sa SERVER_NAME nepoužíva vôbec. Pri `UseCanonicalName Off`
    // ho riadi hlavička Host, takže by útočník vedel podvrhnúť doménu v odkazoch,
    // ktoré sa posielajú e-mailom aj s jednorazovým tokenom.
    if (!isAppLocalDev()) {
        return 'https://polascin.net';
    }

    $scheme = isRequestHttps() ? 'https' : 'http';
    $serverName = trim((string) ($_SERVER['SERVER_NAME'] ?? ''));

    if ($serverName === '' || !preg_match('/^[a-z0-9.-]+$/i', $serverName)) {
        $serverName = 'localhost';
    }

    $port = (int) ($_SERVER['SERVER_PORT'] ?? 0);
    $includePort = $port > 0 && !(($scheme === 'http' && $port === 80) || ($scheme === 'https' && $port === 443));

    return $scheme . '://' . $serverName . ($includePort ? ':' . $port : '');
}
