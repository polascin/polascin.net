<?php

declare(strict_types=1);

/**
 * Automatické retenčné mazanie osobných a prevádzkových údajov.
 *
 * Skript je určený výhradne pre CLI. Workflow ho posiela na produkčný server
 * cez štandardný vstup, takže pomocný súbor nemusí byť vo web roote.
 * Vypisuje iba počty odstránených riadkov, nikdy obsah záznamov.
 */

if (PHP_SAPI !== 'cli') {
    http_response_code(403);
    exit("Prístup odmietnutý.\n");
}

$appRoot = getcwd();
if ($appRoot === false || !is_file($appRoot . '/db_config.php')) {
    fwrite(STDERR, "Chyba: pracovný adresár nie je web root aplikácie (chýba db_config.php).\n");
    exit(1);
}

require $appRoot . '/db_config.php';
/** @var PDO $pdo */
/** @var array<string, mixed> $env */

function retentionValue(array $env, string $key, int $default, int $minimum, int $maximum): int {
    $raw = $env[$key] ?? getenv($key);
    if ($raw === false || $raw === null || $raw === '') {
        return $default;
    }
    $validated = filter_var($raw, FILTER_VALIDATE_INT);
    if ($validated === false || $validated < $minimum || $validated > $maximum) {
        throw new RuntimeException("Neplatná hodnota {$key}; očakáva sa celé číslo {$minimum} až {$maximum}.");
    }
    return $validated;
}

function deleteOlderThan(PDO $pdo, string $sql, DateTimeImmutable $cutoff): int {
    $statement = $pdo->prepare($sql);
    $statement->execute(['cutoff' => $cutoff->format('Y-m-d H:i:s')]);
    return $statement->rowCount();
}

$dryRun = parseEnvBool(getenv('RETENTION_DRY_RUN'), false);
$now = new DateTimeImmutable('now');

try {
    $policies = [
        'contact_messages' => retentionValue($env, 'CONTACT_MESSAGE_RETENTION_DAYS', 180, 30, 3650),
        'access_logs' => retentionValue($env, 'ACCESS_LOG_RETENTION_DAYS', 90, 1, 365),
        'admin_audit_log' => retentionValue($env, 'ADMIN_AUDIT_LOG_RETENTION_DAYS', 365, 30, 3650),
        'form_rate_limit' => retentionValue($env, 'FORM_RATE_LIMIT_RETENTION_HOURS', 48, 48, 720),
        // Potvrdzovací odkaz platí 48 hodín. Retencia preto nesmie byť kratšia.
        'newsletter_pending' => retentionValue($env, 'NEWSLETTER_PENDING_RETENTION_HOURS', 72, 48, 720),
    ];

    $pdo->beginTransaction();
    $deleted = [];
    $deleted['contact_messages'] = deleteOlderThan(
        $pdo,
        'DELETE FROM contact_messages WHERE created_at < :cutoff',
        $now->sub(new DateInterval('P' . $policies['contact_messages'] . 'D'))
    );
    $deleted['newsletter_pending'] = deleteOlderThan(
        $pdo,
        'DELETE FROM newsletter_subscribers WHERE is_confirmed = 0 AND created_at < :cutoff',
        $now->sub(new DateInterval('PT' . $policies['newsletter_pending'] . 'H'))
    );
    $deleted['access_logs'] = deleteOlderThan(
        $pdo,
        'DELETE FROM access_logs WHERE created_at < :cutoff',
        $now->sub(new DateInterval('P' . $policies['access_logs'] . 'D'))
    );
    $deleted['admin_audit_log'] = deleteOlderThan(
        $pdo,
        'DELETE FROM admin_audit_log WHERE created_at < :cutoff',
        $now->sub(new DateInterval('P' . $policies['admin_audit_log'] . 'D'))
    );
    $deleted['form_rate_limit'] = deleteOlderThan(
        $pdo,
        'DELETE FROM form_rate_limit WHERE last_attempt < :cutoff',
        $now->sub(new DateInterval('PT' . $policies['form_rate_limit'] . 'H'))
    );

    if ($dryRun) {
        $pdo->rollBack();
    } else {
        $pdo->commit();
    }

    echo $dryRun ? "Retenčný náhľad, zmeny boli vrátené späť:\n" : "Retenčné mazanie bolo dokončené:\n";
    foreach ($deleted as $table => $count) {
        echo "- {$table}: {$count}\n";
    }
} catch (Throwable $error) {
    if ($pdo->inTransaction()) {
        $pdo->rollBack();
    }
    fwrite(STDERR, 'Retenčné mazanie zlyhalo: ' . $error->getMessage() . "\n");
    exit(1);
}
