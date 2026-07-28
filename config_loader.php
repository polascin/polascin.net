<?php

declare(strict_types=1);

// Ochrana pred priamym prístupom k súboru
if (basename($_SERVER['PHP_SELF'] ?? '') === basename(__FILE__)) {
    header("HTTP/1.1 403 Forbidden");
    exit("Prístup odmietnutý.");
}

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

    if (!$isHttps && parseEnvBool($env['TRUST_PROXY_HEADERS'] ?? getenv('TRUST_PROXY_HEADERS'), false)) {
        $forwardedProto = strtolower(trim((string) ($_SERVER['HTTP_X_FORWARDED_PROTO'] ?? '')));
        if ($forwardedProto === 'https') {
            $isHttps = true;
        }
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

    if (parseEnvBool($env['TRUST_PROXY_HEADERS'] ?? getenv('TRUST_PROXY_HEADERS'), false)) {
        $forwarded = $_SERVER['HTTP_X_FORWARDED_FOR'] ?? $_SERVER['HTTP_CLIENT_IP'] ?? $_SERVER['HTTP_X_REAL_IP'] ?? '';
        if ($forwarded !== '') {
            foreach (explode(',', $forwarded) as $candidate) {
                $candidate = trim($candidate);
                if (filter_var($candidate, FILTER_VALIDATE_IP)) {
                    return $candidate;
                }
            }
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

    $scheme = isRequestHttps() ? 'https' : 'http';
    $serverName = trim((string) ($_SERVER['SERVER_NAME'] ?? ''));

    if (($serverName === '' || $serverName === 'localhost') && !isAppLocalDev()) {
        return 'https://polascin.net';
    }

    if ($serverName === '' || !preg_match('/^[a-z0-9.-]+$/i', $serverName)) {
        $serverName = 'localhost';
    }

    $port = (int) ($_SERVER['SERVER_PORT'] ?? 0);
    $includePort = $port > 0 && !(($scheme === 'http' && $port === 80) || ($scheme === 'https' && $port === 443));

    return $scheme . '://' . $serverName . ($includePort ? ':' . $port : '');
}
