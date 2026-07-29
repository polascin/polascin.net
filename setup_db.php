<?php

declare(strict_types=1);

if (PHP_SAPI !== 'cli') {
    http_response_code(403);
    exit("Prístup odmietnutý. Spustite cez príkazový riadok.");
}

require_once __DIR__ . '/db_config.php';
require_once __DIR__ . '/helpers.php';

/** @var PDO $pdo */

function runSql(PDO $pdo, string $sql): void {
    foreach (array_filter(array_map('trim', explode(';', $sql))) as $statement) {
        $pdo->exec($statement);
    }
}

function indexExists(PDO $pdo, string $table, string $index): bool {
    $stmt = $pdo->prepare(
        "SELECT COUNT(*)
         FROM INFORMATION_SCHEMA.STATISTICS
         WHERE TABLE_SCHEMA = DATABASE()
           AND TABLE_NAME = :table_name
           AND INDEX_NAME = :index_name"
    );
    $stmt->execute([':table_name' => $table, ':index_name' => $index]);
    return (int) $stmt->fetchColumn() > 0;
}

function columnExists(PDO $pdo, string $table, string $column): bool {
    $stmt = $pdo->prepare(
        "SELECT COUNT(*)
         FROM INFORMATION_SCHEMA.COLUMNS
         WHERE TABLE_SCHEMA = DATABASE()
           AND TABLE_NAME = :table_name
           AND COLUMN_NAME = :column_name"
    );
    $stmt->execute([':table_name' => $table, ':column_name' => $column]);
    return (int) $stmt->fetchColumn() > 0;
}

/**
 * Nájde názov jedinečného indexu postaveného presne nad jedným zadaným stĺpcom.
 *
 * Implicitný index z `UNIQUE` v CREATE TABLE sa síce zvyčajne volá rovnako ako
 * stĺpec, ale spoliehať sa na to nemožno — pri migrácii by sa potom starý index
 * ticho nezrušil.
 */
function findSingleColumnUniqueIndex(PDO $pdo, string $table, string $column, array $ignore = []): ?string {
    $stmt = $pdo->prepare(
        "SELECT INDEX_NAME
         FROM INFORMATION_SCHEMA.STATISTICS
         WHERE TABLE_SCHEMA = DATABASE()
           AND TABLE_NAME = :table_name
           AND NON_UNIQUE = 0
           AND INDEX_NAME <> 'PRIMARY'
         GROUP BY INDEX_NAME
         HAVING COUNT(*) = 1
            AND MAX(COLUMN_NAME) = :column_name"
    );
    $stmt->execute([':table_name' => $table, ':column_name' => $column]);

    foreach ($stmt->fetchAll(PDO::FETCH_COLUMN) as $indexName) {
        if (!in_array((string) $indexName, $ignore, true)) {
            return (string) $indexName;
        }
    }
    return null;
}

function applySchemaMigrations(PDO $pdo): void {
    // Poradie kľúčov určuje poradie aplikovania — drž ho chronologicky.
    $migrations = [
        '2026072801_security_indexes' => static function (PDO $pdo): void {
            $indexes = [
                ['form_rate_limit', 'idx_action_last_attempt', 'ALTER TABLE form_rate_limit ADD INDEX idx_action_last_attempt (action, last_attempt)'],
                ['newsletter_subscribers', 'idx_confirm_token', 'ALTER TABLE newsletter_subscribers ADD INDEX idx_confirm_token (confirm_token_hash(64))'],
                ['newsletter_subscribers', 'idx_unsubscribe_token', 'ALTER TABLE newsletter_subscribers ADD INDEX idx_unsubscribe_token (unsubscribe_token_hash(64))'],
            ];
            foreach ($indexes as [$table, $index, $sql]) {
                if (!indexExists($pdo, $table, $index)) {
                    $pdo->exec($sql);
                }
            }
        },
        '2026072901_multilingual_content' => static function (PDO $pdo): void {
            // Články dostávajú jazyk a skupinu prekladov. Existujúci obsah je
            // slovenský, preto sa dopĺňa 'sk'.
            if (!columnExists($pdo, 'articles', 'lang')) {
                $pdo->exec("ALTER TABLE articles ADD COLUMN lang VARCHAR(5) NOT NULL DEFAULT 'sk' AFTER author");
            }
            if (!columnExists($pdo, 'articles', 'translation_group')) {
                $pdo->exec("ALTER TABLE articles ADD COLUMN translation_group INT NULL AFTER lang");
            }
            // Doplnenie hodnôt beží mimo guardov, aby prerušená migrácia po opätovnom
            // spustení dokončila aj to, čo pri páde stihla vynechať.
            $pdo->exec("UPDATE articles SET lang = 'sk' WHERE lang IS NULL OR TRIM(lang) = ''");
            // Každý existujúci článok tvorí vlastnú skupinu; preklady sa k nemu
            // pripoja neskôr nastavením rovnakej hodnoty.
            $pdo->exec("UPDATE articles SET translation_group = id WHERE translation_group IS NULL");

            // Slug musí byť jedinečný v rámci jazyka, nie globálne — inak by ten istý
            // článok nemohol mať preklad s rovnakým slugom.
            $oldSlugIndex = findSingleColumnUniqueIndex($pdo, 'articles', 'slug', ['uniq_slug_lang']);
            if ($oldSlugIndex !== null) {
                $pdo->exec('ALTER TABLE articles DROP INDEX `' . str_replace('`', '``', $oldSlugIndex) . '`');
            }
            if (!indexExists($pdo, 'articles', 'uniq_slug_lang')) {
                $pdo->exec("ALTER TABLE articles ADD UNIQUE KEY uniq_slug_lang (slug, lang)");
            }
            if (!indexExists($pdo, 'articles', 'idx_lang_published')) {
                $pdo->exec("ALTER TABLE articles ADD INDEX idx_lang_published (lang, is_published, published_at)");
            }
            if (!indexExists($pdo, 'articles', 'idx_translation_group')) {
                $pdo->exec("ALTER TABLE articles ADD INDEX idx_translation_group (translation_group)");
            }

            // Obsahové bloky už stĺpec lang majú, ale s predvolenou hodnotou 'en'
            // a jedinečným kľúčom bez jazyka.

            // Hodnoty sa upratujú ešte pred zavedením NOT NULL, inak by v striktnom
            // sql_mode ALTER na existujúcich NULL riadkoch zlyhal.
            $pdo->exec("UPDATE content_blocks SET lang = 'sk' WHERE lang IS NULL OR TRIM(lang) = ''");
            // Starý stĺpec bol voľný text, takže mohol obsahovať regionálne varianty
            // („sk-SK“) aj jazyky, ktoré stránka nepodporuje. Bez normalizácie by
            // taký blok zostal navždy neviditeľný a v novom admine neuložiteľný.
            $pdo->exec("UPDATE content_blocks SET lang = LOWER(SUBSTRING_INDEX(lang, '-', 1))");

            $supportedLangs = array_keys(appLanguages());
            $placeholders = implode(', ', array_fill(0, count($supportedLangs), '?'));
            $normalize = $pdo->prepare(
                "UPDATE content_blocks SET lang = '" . APP_DEFAULT_LANGUAGE . "' WHERE lang NOT IN ({$placeholders})"
            );
            $normalize->execute($supportedLangs);

            // Historicky bola predvolená hodnota 'en', hoci obsah bol slovenský.
            // Prepíše sa len vtedy, keď pre daný kľúč slovenská verzia ešte neexistuje,
            // aby sa nezmazal skutočný anglický preklad ani nevznikol konflikt kľúčov.
            $pdo->exec(
                "UPDATE content_blocks AS target
                 LEFT JOIN (SELECT DISTINCT block_key FROM content_blocks WHERE lang = 'sk') AS existing
                        ON existing.block_key = target.block_key
                 SET target.lang = 'sk'
                 WHERE target.lang = 'en' AND existing.block_key IS NULL"
            );

            // Duplicity, ktoré by novému unikátnemu kľúču bránili, sa musia odstrániť
            // pred jeho vytvorením. Ponecháva sa najnovšie upravený záznam.
            $pdo->exec(
                "DELETE older FROM content_blocks AS older
                 JOIN content_blocks AS newer
                   ON older.block_key = newer.block_key
                  AND older.lang = newer.lang
                  AND (older.updated_at < newer.updated_at
                       OR (older.updated_at = newer.updated_at AND older.id < newer.id))"
            );

            $pdo->exec("ALTER TABLE content_blocks MODIFY COLUMN lang VARCHAR(5) NOT NULL DEFAULT 'sk'");

            $oldBlockKeyIndex = findSingleColumnUniqueIndex($pdo, 'content_blocks', 'block_key', ['uniq_block_key_lang']);
            if ($oldBlockKeyIndex !== null) {
                $pdo->exec('ALTER TABLE content_blocks DROP INDEX `' . str_replace('`', '``', $oldBlockKeyIndex) . '`');
            }
            if (!indexExists($pdo, 'content_blocks', 'uniq_block_key_lang')) {
                $pdo->exec("ALTER TABLE content_blocks ADD UNIQUE KEY uniq_block_key_lang (block_key, lang)");
            }
        },
    ];

    $applied = $pdo->query("SELECT version FROM schema_migrations")->fetchAll(PDO::FETCH_COLUMN);
    $appliedLookup = array_fill_keys(array_map('strval', $applied), true);
    $record = $pdo->prepare("INSERT INTO schema_migrations (version) VALUES (:version)");

    foreach ($migrations as $version => $migration) {
        if (isset($appliedLookup[$version])) {
            continue;
        }
        $migration($pdo);
        $record->execute([':version' => $version]);
    }
}

$schema = <<<SQL
CREATE TABLE IF NOT EXISTS users (
    id INT AUTO_INCREMENT PRIMARY KEY,
    username VARCHAR(255) UNIQUE NOT NULL,
    email VARCHAR(255) UNIQUE NOT NULL,
    password_hash VARCHAR(255) NOT NULL,
    is_admin TINYINT(1) DEFAULT 0,
    is_active TINYINT(1) DEFAULT 1,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

CREATE TABLE IF NOT EXISTS articles (
    id INT AUTO_INCREMENT PRIMARY KEY,
    title VARCHAR(255) NOT NULL,
    slug VARCHAR(255) NOT NULL,
    excerpt TEXT,
    content LONGTEXT,
    author VARCHAR(255),
    lang VARCHAR(5) NOT NULL DEFAULT 'sk',
    translation_group INT NULL,
    category ENUM('blog', 'news') DEFAULT 'blog',
    is_published TINYINT(1) DEFAULT 0,
    is_top TINYINT(1) DEFAULT 0,
    sort_order INT DEFAULT 0,
    published_at DATETIME NULL,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
    UNIQUE KEY uniq_slug_lang (slug, lang),
    INDEX idx_published (is_published, published_at),
    INDEX idx_lang_published (lang, is_published, published_at),
    INDEX idx_translation_group (translation_group),
    INDEX idx_slug (slug)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

CREATE TABLE IF NOT EXISTS content_blocks (
    id INT AUTO_INCREMENT PRIMARY KEY,
    block_key VARCHAR(64) NOT NULL,
    title VARCHAR(255),
    content LONGTEXT,
    lang VARCHAR(5) NOT NULL DEFAULT 'sk',
    is_active TINYINT(1) DEFAULT 1,
    sort_order INT DEFAULT 0,
    updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
    UNIQUE KEY uniq_block_key_lang (block_key, lang),
    INDEX idx_key (block_key)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

CREATE TABLE IF NOT EXISTS contact_messages (
    id INT AUTO_INCREMENT PRIMARY KEY,
    name VARCHAR(255) NOT NULL,
    email VARCHAR(255) NOT NULL,
    subject VARCHAR(255),
    message TEXT NOT NULL,
    is_read TINYINT(1) DEFAULT 0,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    INDEX idx_read (is_read, created_at)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

CREATE TABLE IF NOT EXISTS newsletter_subscribers (
    id INT AUTO_INCREMENT PRIMARY KEY,
    email VARCHAR(255) UNIQUE NOT NULL,
    is_confirmed TINYINT(1) DEFAULT 0,
    confirm_token_hash VARCHAR(255) NULL,
    unsubscribe_token_hash VARCHAR(255) NULL,
    confirmed_at DATETIME NULL,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    INDEX idx_confirmed (is_confirmed, created_at)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

CREATE TABLE IF NOT EXISTS access_logs (
    id INT AUTO_INCREMENT PRIMARY KEY,
    user_id INT NULL,
    username VARCHAR(255) NULL,
    method VARCHAR(10) NOT NULL,
    request_uri VARCHAR(2048) NOT NULL,
    query_string VARCHAR(2048) NULL,
    http_status SMALLINT NOT NULL,
    client_ip VARCHAR(45) NOT NULL,
    user_agent VARCHAR(500) NULL,
    referer VARCHAR(2048) NULL,
    host VARCHAR(255) NULL,
    response_time_ms INT NULL,
    is_bot TINYINT(1) DEFAULT 0,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    INDEX idx_created (created_at),
    INDEX idx_user (user_id)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

CREATE TABLE IF NOT EXISTS admin_audit_log (
    id INT AUTO_INCREMENT PRIMARY KEY,
    admin_user_id INT NOT NULL,
    action VARCHAR(120) NOT NULL,
    target_type VARCHAR(60) NULL,
    target_id INT NULL,
    details TEXT NULL,
    client_ip VARCHAR(45) NULL,
    user_agent VARCHAR(500) NULL,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    INDEX idx_admin (admin_user_id, created_at)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

CREATE TABLE IF NOT EXISTS form_rate_limit (
    id INT AUTO_INCREMENT PRIMARY KEY,
    ip VARCHAR(45) NOT NULL,
    action VARCHAR(64) NOT NULL,
    attempt_count INT DEFAULT 0,
    first_attempt DATETIME DEFAULT CURRENT_TIMESTAMP,
    last_attempt DATETIME DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
    blocked_until DATETIME NULL,
    UNIQUE KEY unique_ip_action (ip, action),
    INDEX idx_blocked (blocked_until)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

CREATE TABLE IF NOT EXISTS schema_migrations (
    version VARCHAR(128) PRIMARY KEY,
    applied_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
SQL;

runSql($pdo, $schema);
applySchemaMigrations($pdo);

$defaultBlocks = [
    ['hero_title', '', 'Presná nefrológia. Ľudská starostlivosť. Zmysluplné technológie.', 'sk', 0],
    ['hero_subtitle', '', 'Som nefrológ a internista s dlhoročnou praxou v dialýze a liečbe ochorení obličiek. Klinickú skúsenosť prepájam s odborným písaním, vzdelávaním a tvorbou digitálnych riešení pre medicínu.', 'sk', 1],
    ['about_intro', '', 'Som lekár so špecializáciou v nefrológii a internej medicíne. Väčšinu svojho profesijného života sa venujem ochoreniam obličiek, dialýze a starostlivosti o pacientov, ktorých liečba si vyžaduje nielen odbornú presnosť, ale aj dôveru, zrozumiteľnú komunikáciu a rešpektovanie individuálnych potrieb.', 'sk', 2],
    ['about_who', '', 'Popri klinickej práci píšem odborné aj literárne texty, venujem sa medicínskym prekladom a tvorím webové stránky a aplikácie. Programovanie a umelú inteligenciu nevnímam ako samoúčelné novinky. Sú to pre mňa praktické nástroje, ktoré môžu sprístupniť poznanie, zjednodušiť prácu a podporiť kvalitnejšie rozhodovanie v medicíne.', 'sk', 3],
    ['contact_intro', '', 'Neváhajte ma kontaktovať s otázkami alebo ohľadom spolupráce.', 'sk', 4],
];

$stmt = $pdo->prepare(
    "INSERT IGNORE INTO content_blocks (block_key, title, content, lang, sort_order)
     VALUES (:block_key, :title, :content, :lang, :sort_order)"
);

foreach ($defaultBlocks as $block) {
    $stmt->execute([
        ':block_key' => $block[0],
        ':title' => $block[1],
        ':content' => $block[2],
        ':lang' => $block[3],
        ':sort_order' => $block[4],
    ]);
}

$adminEmail = getenv('POLASCIN_ADMIN_EMAIL') ?: 'admin@polascin.net';
$adminUsername = 'admin';

if (!filter_var($adminEmail, FILTER_VALIDATE_EMAIL) || appTextLength($adminEmail) > 255) {
    fwrite(STDERR, "Chyba: POLASCIN_ADMIN_EMAIL nie je platná e-mailová adresa.\n");
    exit(1);
}

$existing = $pdo->prepare("SELECT id FROM users WHERE username = :username LIMIT 1");
$existing->execute([':username' => $adminUsername]);
$quiet = getenv('POLASCIN_SETUP_QUIET') === '1';

if (!$existing->fetch()) {
    $password = getenv('POLASCIN_ADMIN_PASSWORD');
    if ($password === false || $password === '') {
        if ($quiet) {
            fwrite(STDERR, "Chyba: chýbajúci admin účet a premenná POLASCIN_ADMIN_PASSWORD nie je nastavená.\n");
            exit(1);
        }
        $password = bin2hex(random_bytes(10)) . 'Aa1';
    }
    try {
        $hash = hashAppPassword($password);
    } catch (\Throwable) {
        // Okrem pravidiel pre heslo odmieta bcrypt aj NUL bajt, a to cez
        // \ValueError — užší catch by inicializáciu zhodil fatálnou chybou.
        fwrite(STDERR, "Chyba: administrátorské heslo musí mať " . APP_PASSWORD_MIN_BYTES . " až " . APP_PASSWORD_MAX_BYTES . " bajtov a obsahovať malé písmeno, veľké písmeno a číslicu.\n");
        exit(1);
    }

    $stmt = $pdo->prepare(
        "INSERT INTO users (username, email, password_hash, is_admin, is_active)
         VALUES (:username, :email, :password_hash, 1, 1)"
    );
    $stmt->execute([
        ':username' => $adminUsername,
        ':email' => $adminEmail,
        ':password_hash' => $hash,
    ]);

    if (!$quiet) {
        echo "Vytvorený admin účet: {$adminUsername}\n";
        echo "Heslo: {$password}\n";
        echo "Uložte si ho, v databáze nie je uchované v čitateľnej podobe.\n";
    }
} elseif (!$quiet) {
    echo "Admin účet už existuje.\n";
}

if (!$quiet) {
    echo "Inicializácia databázy polascin.net dokončená.\n";
}
