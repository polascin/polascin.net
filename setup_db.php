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

function applySchemaMigrations(PDO $pdo): void {
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
    slug VARCHAR(255) UNIQUE NOT NULL,
    excerpt TEXT,
    content LONGTEXT,
    author VARCHAR(255),
    category ENUM('blog', 'news') DEFAULT 'blog',
    is_published TINYINT(1) DEFAULT 0,
    is_top TINYINT(1) DEFAULT 0,
    sort_order INT DEFAULT 0,
    published_at DATETIME NULL,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
    INDEX idx_published (is_published, published_at),
    INDEX idx_slug (slug)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

CREATE TABLE IF NOT EXISTS content_blocks (
    id INT AUTO_INCREMENT PRIMARY KEY,
    block_key VARCHAR(64) UNIQUE NOT NULL,
    title VARCHAR(255),
    content LONGTEXT,
    lang VARCHAR(5) DEFAULT 'en',
    is_active TINYINT(1) DEFAULT 1,
    sort_order INT DEFAULT 0,
    updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
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
    ['hero_title', '', 'Pokrok v zdraví obličiek', 'sk', 0],
    ['hero_subtitle', '', 'MUDr. Ľubomír Polaščín — venovaný excelentnosti v nefrológii, dialýze, starostlivosti o pacientov a medicínskych technológiách.', 'sk', 1],
    ['about_intro', '', "Volám sa Ľubomír Polaščín — som lekár, nefrológ a internista povolaním, spisovateľ beletrie a literatúry faktu poslaním a samouk programátor z vášne.", 'sk', 2],
    ['about_who', '', 'Moja práca spočíva na priesečníku medicíny, rozprávania príbehov a technológií. Medicína cibrí moju klinickú presnosť; písanie mi umožňuje skúmať ľudský údel cez beletriu a literatúru faktu; a technológie ma posúvajú pri riešení zložitých problémov.', 'sk', 3],
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
    } catch (\InvalidArgumentException) {
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
