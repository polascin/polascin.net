<?php

declare(strict_types=1);

if (basename($_SERVER['PHP_SELF']) === basename(__FILE__) && php_sapi_name() !== 'cli') {
    http_response_code(403);
    exit("Prístup odmietnutý. Spustite cez príkazový riadok.");
}

require_once __DIR__ . '/db_config.php';

/** @var PDO $pdo */

function tableExists(PDO $pdo, string $table): bool {
    $stmt = $pdo->prepare(
        "SELECT COUNT(*) FROM INFORMATION_SCHEMA.TABLES
         WHERE TABLE_SCHEMA = DATABASE() AND TABLE_NAME = :table"
    );
    $stmt->execute(['table' => $table]);
    return (int) $stmt->fetchColumn() > 0;
}

function columnExists(PDO $pdo, string $table, string $column): bool {
    $stmt = $pdo->prepare(
        "SELECT COUNT(*) FROM INFORMATION_SCHEMA.COLUMNS
         WHERE TABLE_SCHEMA = DATABASE() AND TABLE_NAME = :table AND COLUMN_NAME = :column"
    );
    $stmt->execute(['table' => $table, 'column' => $column]);
    return (int) $stmt->fetchColumn() > 0;
}

function runSql(PDO $pdo, string $sql): void {
    foreach (array_filter(array_map('trim', explode(';', $sql))) as $statement) {
        $pdo->exec($statement);
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
SQL;

runSql($pdo, $schema);

$defaultBlocks = [
    ['hero_title', '', 'Pokrok v zdraví obličiek', 'sk', 0],
    ['hero_subtitle', '', 'MUDr. Ľubomír Polaščín — venovaný excelentnosti v nefrológii, dialýze, starostlivosti o pacientov a medicínskych technológiách.', 'sk', 1],
    ['about_intro', '', "Volám sa Ľubomír Polaščín — som lekár, nefrológ a internista povolaním, spisovateľ beletrie a literatúry faktu poslaním a samouk programátor z vášne.", 'sk', 2],
    ['about_who', '', 'Moja práca spočíva na priesečníku medicíny, rozprávania príbehov a technológií. Medicína cibrí moju klinickú presnosť; písanie mi umožňuje skúmať ľudský údel cez beletriu a literatúru faktu; a technológie ma posúvajú pri riešení zložitých problémov.', 'sk', 3],
    ['contact_intro', '', 'Neváhajte ma kontaktovať s otázkami alebo ohľadom spolupráce.', 'sk', 4],
];

$stmt = $pdo->prepare(
    "INSERT INTO content_blocks (block_key, title, content, lang, sort_order)
     VALUES (:block_key, :title, :content, :lang, :sort_order)
     ON DUPLICATE KEY UPDATE title = VALUES(title), content = VALUES(content), lang = VALUES(lang), sort_order = VALUES(sort_order)"
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
        $password = bin2hex(random_bytes(8));
    }
    $hash = password_hash($password, PASSWORD_DEFAULT);

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
