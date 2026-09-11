<?php

declare(strict_types=1);

/**
 * Read-only kontrola produkčnej databázy pre nočný audit.
 *
 * Spúšťa ho workflow `verify-db.yml` cez SSH so skriptom na štandardnom vstupe,
 * takže na server sa nič nezapisuje — ani dočasne do web rootu. Preto sa
 * `db_config.php` načítava z `getcwd()`, nie z `__DIR__`: pri čítaní zo stdin
 * je `__DIR__` pracovný adresár a ten workflow nastavuje na web root.
 *
 *   cd <webroot> && POLASCIN_ENV_PATH=<...> php < scripts/audit_db_check.php
 *
 * Skript zámerne nevypisuje žiadne prihlasovacie údaje ani obsah osobných
 * údajov — len agregáty, počty a veky najstarších záznamov. Report končí
 * v repozitári, takže nesmie obsahovať nič, čo by sa nemalo commitnúť.
 *
 * Vlastné zápisy sú vylúčené trojako: transakciou `READ ONLY`, absenciou
 * akéhokoľvek iného SQL než `SELECT`/`SHOW`, a odporúčaným samostatným DB
 * užívateľom s grantom `SELECT` (viď `.doaudit.md`).
 */

if (PHP_SAPI !== 'cli') {
    http_response_code(403);
    exit("Prístup odmietnutý.");
}

$appRoot = getcwd();
if ($appRoot === false || !is_file($appRoot . '/db_config.php')) {
    fwrite(STDERR, "Chyba: pracovný adresár nie je web root aplikácie (chýba db_config.php).\n");
    exit(1);
}

require $appRoot . '/db_config.php';
/** @var PDO $pdo */

/** Očakávané migrácie. Zhodu s `setup_db.php` stráži test v `tests/run.php`. */
const EXPECTED_MIGRATIONS = [
    '2026072801_security_indexes',
    '2026072901_multilingual_content',
    '2026072902_profile_copy',
];

/** Očakávané tabuľky. Zhodu s `setup_db.php` stráži test v `tests/run.php`. */
const EXPECTED_TABLES = [
    'users',
    'articles',
    'content_blocks',
    'contact_messages',
    'newsletter_subscribers',
    'access_logs',
    'admin_audit_log',
    'form_rate_limit',
    'schema_migrations',
];

/** Podporované jazyky. Zhodu s `appLanguages()` stráži test v `tests/run.php`. */
const EXPECTED_LANGUAGES = ['sk', 'en', 'cs', 'de', 'fr', 'es', 'pl', 'hu', 'it', 'uk'];

/** Tabuľky s osobnými údajmi a ich časová značka pre kontrolu retencie. */
const PII_TABLES = [
    'access_logs' => 'created_at',
    'contact_messages' => 'created_at',
    'newsletter_subscribers' => 'created_at',
    'form_rate_limit' => 'last_attempt',
];

$findings = [];
$header = [];
$lines = [];

function out(string $line = ''): void {
    global $lines;
    $lines[] = $line;
}

function head(string $line = ''): void {
    global $header;
    $header[] = $line;
}

function finding(string $severity, string $text): void {
    global $findings;
    $findings[] = ['severity' => $severity, 'text' => $text];
}

/** Jediná cesta k dátam — nič iné než SELECT/SHOW skript nespúšťa. */
function fetchAll(PDO $pdo, string $sql, array $params = []): array {
    $statement = $pdo->prepare($sql);
    $statement->execute($params);

    return $statement->fetchAll();
}

function fetchOne(PDO $pdo, string $sql, array $params = []): mixed {
    $statement = $pdo->prepare($sql);
    $statement->execute($params);

    return $statement->fetchColumn();
}

// Transakcia READ ONLY: ak by sa do skriptu niekedy dostal zápis, server ho
// odmietne namiesto toho, aby ho ticho vykonal.
$pdo->exec('START TRANSACTION READ ONLY');

$generatedAt = (new DateTimeImmutable('now'))->format('Y-m-d H:i:s T');

// Report sa commituje do **verejného** repozitára, takže názov databázy ani
// presná verzia servera doň nepatria: sú to práve tie údaje, ktoré útočníkovi
// chýbajú k platnému prihláseniu, resp. k namierenému exploitu na konkrétnu
// patch verziu. Do reportu ide len to, čo treba na posúdenie stavu —
// hlavné číslo verzie a či server hlási MariaDB alebo MySQL.
$rawVersion = (string) fetchOne($pdo, 'SELECT VERSION()');
$serverFamily = stripos($rawVersion, 'mariadb') !== false ? 'MariaDB' : 'MySQL';
$serverMajorMinor = preg_match('~^(\d+\.\d+)~', $rawVersion, $versionMatch) === 1
    ? $versionMatch[1] . '.x'
    : 'neznáma';

head('# Kontrola produkčnej databázy — polascin.net');
head();
head('Generované: ' . $generatedAt . '  ');
head('Server: `' . $serverFamily . ' ' . $serverMajorMinor . '`  ');
head('Režim: read-only transakcia, iba `SELECT`/`SHOW`');
head();
head('Názov databázy a presná verzia servera sa do reportu zámerne nepíšu —');
head('repozitár je verejný.');
head();

// ── Tabuľky, engine, charset ────────────────────────────────────────────────
out('## Tabuľky');
out();

$tableRows = fetchAll(
    $pdo,
    'SELECT table_name, engine, table_collation, table_rows
       FROM information_schema.tables
      WHERE table_schema = DATABASE() AND table_type = \'BASE TABLE\'
      ORDER BY table_name'
);
$presentTables = [];
foreach ($tableRows as $tableRow) {
    $presentTables[] = (string) $tableRow['table_name'];
}

foreach (EXPECTED_TABLES as $expectedTable) {
    if (!in_array($expectedTable, $presentTables, true)) {
        finding('KRITICKÉ', "Tabuľka `{$expectedTable}` v databáze chýba — schéma nie je kompletná.");
    }
}
$unexpectedTables = array_diff($presentTables, EXPECTED_TABLES);
foreach ($unexpectedTables as $unexpectedTable) {
    finding('INFO', "Tabuľka `{$unexpectedTable}` nie je v schéme `setup_db.php` — zvyšok po migrácii?");
}

out('| Tabuľka | Engine | Collation | Riadkov (presne) |');
out('| --- | --- | --- | --- |');
foreach ($tableRows as $tableRow) {
    $tableName = (string) $tableRow['table_name'];
    $engine = (string) ($tableRow['engine'] ?? '?');
    $collation = (string) ($tableRow['table_collation'] ?? '?');

    // `information_schema.table_rows` je u InnoDB len odhad, preto presný COUNT.
    // Názov tabuľky pochádza z information_schema, nie zo vstupu, a navyše sa
    // overuje proti zoznamu známych tabuliek — identifikátor sa viazať nedá.
    $exactCount = in_array($tableName, $presentTables, true)
        ? (int) fetchOne($pdo, 'SELECT COUNT(*) FROM `' . str_replace('`', '', $tableName) . '`')
        : 0;

    if ($engine !== 'InnoDB') {
        finding('VYSOKÉ', "Tabuľka `{$tableName}` používa engine `{$engine}` namiesto InnoDB — bez transakcií a FK.");
    }
    if (!str_starts_with($collation, 'utf8mb4')) {
        finding('VYSOKÉ', "Tabuľka `{$tableName}` má collation `{$collation}` namiesto utf8mb4 — riziko poškodenia diakritiky.");
    }

    out('| `' . $tableName . '` | ' . $engine . ' | ' . $collation . ' | ' . $exactCount . ' |');
}
out();

// ── Migrácie ───────────────────────────────────────────────────────────────
out('## Migrácie schémy');
out();

$appliedMigrations = [];
if (in_array('schema_migrations', $presentTables, true)) {
    foreach (fetchAll($pdo, 'SELECT version, applied_at FROM schema_migrations ORDER BY version') as $migrationRow) {
        $appliedMigrations[(string) $migrationRow['version']] = (string) $migrationRow['applied_at'];
    }
}

foreach (EXPECTED_MIGRATIONS as $expectedMigration) {
    if (!array_key_exists($expectedMigration, $appliedMigrations)) {
        finding('KRITICKÉ', "Migrácia `{$expectedMigration}` nie je aplikovaná — nasadený kód počíta so schémou, ktorú DB nemá.");
        out('- ❌ `' . $expectedMigration . '` — **neaplikovaná**');
        continue;
    }
    out('- ✅ `' . $expectedMigration . '` — ' . $appliedMigrations[$expectedMigration]);
}
foreach (array_keys($appliedMigrations) as $appliedVersion) {
    if (!in_array($appliedVersion, EXPECTED_MIGRATIONS, true)) {
        finding('STREDNÉ', "V DB je migrácia `{$appliedVersion}`, ktorú `setup_db.php` nepozná — DB je pred kódom.");
        out('- ⚠️ `' . $appliedVersion . '` — v DB, ale nie v `setup_db.php`');
    }
}
out();

// ── Indexy z migrácie bezpečnostných indexov ───────────────────────────────
out('## Indexy strážené migráciou');
out();

$requiredIndexes = [
    ['form_rate_limit', 'idx_action_last_attempt'],
    ['newsletter_subscribers', 'idx_confirm_token'],
    ['newsletter_subscribers', 'idx_unsubscribe_token'],
];
foreach ($requiredIndexes as [$indexTable, $indexName]) {
    if (!in_array($indexTable, $presentTables, true)) {
        continue;
    }
    $indexCount = (int) fetchOne(
        $pdo,
        'SELECT COUNT(*) FROM information_schema.statistics
          WHERE table_schema = DATABASE() AND table_name = ? AND index_name = ?',
        [$indexTable, $indexName]
    );
    if ($indexCount === 0) {
        finding('VYSOKÉ', "Index `{$indexName}` na `{$indexTable}` chýba — vyhľadávanie tokenov a rate-limit bežia bez indexu.");
        out('- ❌ `' . $indexTable . '.' . $indexName . '` — chýba');
        continue;
    }
    out('- ✅ `' . $indexTable . '.' . $indexName . '`');
}
out();

// ── Admin účty ─────────────────────────────────────────────────────────────
out('## Prístupové účty');
out();

if (in_array('users', $presentTables, true)) {
    $activeAdmins = (int) fetchOne($pdo, 'SELECT COUNT(*) FROM users WHERE is_admin = 1 AND is_active = 1');
    $inactiveAdmins = (int) fetchOne($pdo, 'SELECT COUNT(*) FROM users WHERE is_admin = 1 AND is_active = 0');
    $nonAdmins = (int) fetchOne($pdo, 'SELECT COUNT(*) FROM users WHERE is_admin = 0');
    $weakHashes = (int) fetchOne($pdo, 'SELECT COUNT(*) FROM users WHERE password_hash NOT LIKE \'$2y$%\' AND password_hash NOT LIKE \'$argon2%\'');

    out('- Aktívnych administrátorov: **' . $activeAdmins . '**');
    out('- Deaktivovaných administrátorov: ' . $inactiveAdmins);
    out('- Neadministrátorských účtov: ' . $nonAdmins);

    if ($activeAdmins === 0) {
        finding('KRITICKÉ', 'V DB nie je žiadny aktívny administrátor — do admin rozhrania sa nedá prihlásiť.');
    }
    if ($activeAdmins > 1) {
        finding('STREDNÉ', "Aktívnych administrátorov je {$activeAdmins}; projekt má jediného správcu, preto over, či ide o zámer.");
    }
    if ($weakHashes > 0) {
        finding('KRITICKÉ', "{$weakHashes} účtov nemá bcrypt ani argon2 hash hesla — možný zvyšok po ručnom zásahu do DB.");
    }
}
out();

// ── Obsah a jazyky ─────────────────────────────────────────────────────────
out('## Obsah a jazyky');
out();

if (in_array('articles', $presentTables, true)) {
    $publishedArticles = (int) fetchOne($pdo, 'SELECT COUNT(*) FROM articles WHERE is_published = 1');
    out('- Publikovaných článkov: ' . $publishedArticles);

    $duplicateSlugs = fetchAll(
        $pdo,
        'SELECT slug, lang, COUNT(*) AS pocet FROM articles GROUP BY slug, lang HAVING COUNT(*) > 1'
    );
    foreach ($duplicateSlugs as $duplicateSlug) {
        finding(
            'VYSOKÉ',
            'Duplicitný slug `' . (string) $duplicateSlug['slug'] . '` v jazyku `'
            . (string) $duplicateSlug['lang'] . '` (' . (int) $duplicateSlug['pocet']
            . 'x) — `article.php` vráti nedeterministický článok.'
        );
    }

    out('- Články podľa jazyka:');
    foreach (fetchAll($pdo, 'SELECT lang, COUNT(*) AS pocet FROM articles GROUP BY lang ORDER BY lang') as $langRow) {
        $langCode = (string) $langRow['lang'];
        out('  - `' . $langCode . '`: ' . (int) $langRow['pocet']);
        if (!in_array($langCode, EXPECTED_LANGUAGES, true)) {
            finding('STREDNÉ', "Články majú jazyk `{$langCode}`, ktorý aplikácia nepodporuje — nezobrazia sa nikde.");
        }
    }
}

if (in_array('content_blocks', $presentTables, true)) {
    $blockLanguages = fetchAll(
        $pdo,
        'SELECT lang, COUNT(*) AS pocet FROM content_blocks GROUP BY lang ORDER BY lang'
    );
    out('- Obsahové bloky podľa jazyka:');
    foreach ($blockLanguages as $blockRow) {
        $blockLang = (string) $blockRow['lang'];
        out('  - `' . $blockLang . '`: ' . (int) $blockRow['pocet']);
        if (!in_array($blockLang, EXPECTED_LANGUAGES, true)) {
            finding('STREDNÉ', "Obsahové bloky majú jazyk `{$blockLang}`, ktorý aplikácia nepodporuje.");
        }
    }
}
out();

// ── Retencia osobných údajov (GDPR) ────────────────────────────────────────
out('## Retencia osobných údajov');
out();

$retentionDays = (int) ($env['ACCESS_LOG_RETENTION_DAYS'] ?? 90);
if ($retentionDays <= 0) {
    $retentionDays = 90;
}
out('Nastavená retencia access logov: **' . $retentionDays . ' dní** (`ACCESS_LOG_RETENTION_DAYS`).');
out();
out('| Tabuľka | Riadkov | Najstarší záznam | Vek (dní) |');
out('| --- | --- | --- | --- |');

foreach (PII_TABLES as $piiTable => $timestampColumn) {
    if (!in_array($piiTable, $presentTables, true)) {
        continue;
    }
    $rowCount = (int) fetchOne($pdo, 'SELECT COUNT(*) FROM `' . $piiTable . '`');
    if ($rowCount === 0) {
        out('| `' . $piiTable . '` | 0 | — | — |');
        continue;
    }

    $oldest = (string) fetchOne($pdo, 'SELECT MIN(`' . $timestampColumn . '`) FROM `' . $piiTable . '`');
    $ageDays = (int) fetchOne(
        $pdo,
        'SELECT TIMESTAMPDIFF(DAY, MIN(`' . $timestampColumn . '`), NOW()) FROM `' . $piiTable . '`'
    );
    out('| `' . $piiTable . '` | ' . $rowCount . ' | ' . $oldest . ' | ' . $ageDays . ' |');

    if ($piiTable === 'access_logs' && $ageDays > $retentionDays) {
        finding(
            'VYSOKÉ',
            "V `access_logs` sú záznamy staré {$ageDays} dní, hoci retencia je {$retentionDays} dní — "
            . 'čistenie logov sa nevykonáva a IP adresy sa držia dlhšie, než sľubuje zásada ochrany údajov.'
        );
    }
    // Zásada ochrany údajov sľubuje: „Kontaktné správy uchovávam iba po dobu
    // potrebnú na vybavenie komunikácie.“ Mazanie je ručné (`admin_contact.php`),
    // takže sľub drží len to, či sa vybavené správy naozaj mažú. Bez pevnej
    // lhoty v zásade je pol roka najmiernejší obhájiteľný prah.
    if ($piiTable === 'contact_messages') {
        $handled = (int) fetchOne($pdo, 'SELECT COUNT(*) FROM contact_messages WHERE is_read = 1');
        $pending = (int) fetchOne($pdo, 'SELECT COUNT(*) FROM contact_messages WHERE is_read = 0');
        $staleHandled = (int) fetchOne(
            $pdo,
            'SELECT COUNT(*) FROM contact_messages WHERE is_read = 1 AND created_at < (NOW() - INTERVAL 180 DAY)'
        );
        out();
        out('Kontaktné správy: **' . $handled . '** vybavených, **' . $pending . '** nevybavených.');

        if ($staleHandled > 0) {
            finding(
                'STREDNÉ',
                "{$staleHandled} vybavených kontaktných správ je starších ako 180 dní. Zásada ochrany údajov "
                . 'sľubuje uchovanie „iba po dobu potrebnú na vybavenie komunikácie“ — vybavené správy '
                . 'treba zmazať v `admin_contact.php` alebo do zásady doplniť konkrétnu lhotu.'
            );
        }
    }
    if ($piiTable === 'form_rate_limit' && $ageDays > 7) {
        finding(
            'STREDNÉ',
            "`form_rate_limit` drží záznamy staré {$ageDays} dní; tabuľka je prevádzková a mala by sa priebežne prerezávať."
        );
    }
}
out();

// ── Súhrn ──────────────────────────────────────────────────────────────────
$pdo->exec('COMMIT');

$severityOrder = ['KRITICKÉ' => 0, 'VYSOKÉ' => 1, 'STREDNÉ' => 2, 'NÍZKE' => 3, 'INFO' => 4];
usort(
    $findings,
    static fn(array $a, array $b): int => ($severityOrder[$a['severity']] ?? 9) <=> ($severityOrder[$b['severity']] ?? 9)
);

$blocking = array_filter($findings, static fn(array $f): bool => $f['severity'] !== 'INFO');
$status = $blocking === [] ? 'OK' : 'NÁLEZY';

// `STATUS:` a `NALEZOV:` sú strojovo čitateľné značky — workflow podľa nich
// nastavuje výsledok behu a nočná rutina ich cituje v e-maile.
$summary = [];
$summary[] = 'STATUS: ' . $status;
$summary[] = 'NALEZOV: ' . count($blocking);
$summary[] = '';
$summary[] = '## Súhrn';
$summary[] = '';
if ($findings === []) {
    $summary[] = 'Bez nálezov — schéma, migrácie, indexy, účty aj retencia sú v očakávanom stave.';
} else {
    foreach ($findings as $singleFinding) {
        $summary[] = '- **' . $singleFinding['severity'] . '** — ' . $singleFinding['text'];
    }
}
$summary[] = '';

fwrite(STDOUT, implode("\n", array_merge($header, $summary, $lines)) . "\n");
exit(0);
