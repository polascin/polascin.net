<?php

declare(strict_types=1);

require_once __DIR__ . '/auth.php';
require_once __DIR__ . '/db_config.php';
require_once __DIR__ . '/helpers.php';

requireAdmin();

/** @var PDO $pdo */

$errors = [];
$success = '';
$editing = null;

$allArticles = (function () use ($pdo): array {
    $stmt = $pdo->query(
        "SELECT id, title, slug, image, author, lang, translation_group, is_published, is_top, sort_order, published_at, updated_at
         FROM articles
         ORDER BY published_at DESC, id DESC"
    );
    return $stmt->fetchAll();
})();

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $csrfToken = $_POST['csrf_token'] ?? '';
    if (!validateCsrfToken((string) $csrfToken)) {
        $errors[] = 'Neplatný bezpečnostný token.';
    } else {
        $action = $_POST['action'] ?? '';

        if ($action === 'toggle_top') {
            $groupId = isset($_POST['translation_group']) && is_numeric($_POST['translation_group'])
                ? (int) $_POST['translation_group']
                : 0;
            if ($groupId < 1) {
                $errors[] = 'Skupina prekladov nie je platná.';
            } else {
                $current = $pdo->prepare(
                    "SELECT MAX(is_top) FROM articles WHERE translation_group = :group"
                );
                $current->execute([':group' => $groupId]);
                $nextTop = ((int) $current->fetchColumn()) === 1 ? 0 : 1;
                $update = $pdo->prepare(
                    "UPDATE articles SET is_top = :is_top WHERE translation_group = :group"
                );
                $update->execute([':is_top' => $nextTop, ':group' => $groupId]);
                logAdminAction($pdo, $nextTop === 1 ? 'article_top_on' : 'article_top_off', 'article_group', $groupId);
                header('Location: admin_articles.php?top=1');
                exit;
            }
        }

        if ($action === 'delete_group') {
            $groupId = isset($_POST['translation_group']) && is_numeric($_POST['translation_group'])
                ? (int) $_POST['translation_group']
                : 0;
            if ($groupId < 1) {
                $errors[] = 'Skupina prekladov nie je platná.';
            } else {
                $stmt = $pdo->prepare("DELETE FROM articles WHERE translation_group = :group");
                $stmt->execute([':group' => $groupId]);
                logAdminAction($pdo, 'article_group_delete', 'article_group', $groupId);
                header('Location: admin_articles.php');
                exit;
            }
        }

        if ($action === 'delete' && isset($_POST['id'])) {
            $id = (int) $_POST['id'];
            $stmt = $pdo->prepare("DELETE FROM articles WHERE id = :id LIMIT 1");
            $stmt->execute([':id' => $id]);
            logAdminAction($pdo, 'article_delete', 'article', $id);
            header('Location: admin_articles.php');
            exit;
        }

        if (in_array($action, ['save', 'publish'], true)) {
            $id = isset($_POST['id']) && is_numeric($_POST['id']) ? (int) $_POST['id'] : null;
            $title = trim((string) ($_POST['title'] ?? ''));
            $slug = trim((string) ($_POST['slug'] ?? ''));
            $excerpt = strip_tags(trim((string) ($_POST['excerpt'] ?? '')));
            $rawContent = trim((string) ($_POST['content'] ?? ''));
            $content = appTextLength($rawContent) <= 1000000 ? sanitizeHtmlContent($rawContent) : '';
            $author = trim((string) ($_POST['author'] ?? ''));
            $image = trim((string) ($_POST['image'] ?? ''));
            $imageAlt = trim((string) ($_POST['image_alt'] ?? ''));
            $articleLang = trim((string) ($_POST['lang'] ?? APP_DEFAULT_LANGUAGE));
            $rawTranslationGroup = trim((string) ($_POST['translation_group'] ?? ''));
            $translationGroup = $rawTranslationGroup === '' ? null : (int) $rawTranslationGroup;
            $sortOrder = (int) ($_POST['sort_order'] ?? 0);
            $publishedAt = trim((string) ($_POST['published_at'] ?? ''));
            $isTop = isset($_POST['is_top']) ? 1 : 0;
            $isPublished = ($action === 'publish' || isset($_POST['is_published'])) ? 1 : 0;

            if ($title === '' || appTextLength($title) > 255) {
                $errors[] = 'Názov je povinný (max 255 znakov).';
            }
            if ($slug === '') {
                $slug = slugify($title);
            }
            if (!preg_match('/^[a-z0-9-]+$/D', $slug)) {
                $errors[] = 'Slug musí obsahovať iba malé písmená, čísla a pomlčky.';
            }
            if (appTextLength($slug) > 255) {
                $errors[] = 'Slug je príliš dlhý.';
            }
            if (appTextLength($excerpt) > 5000) {
                $errors[] = 'Úryvok môže mať najviac 5 000 znakov.';
            }
            if (appTextLength($author) > 255) {
                $errors[] = 'Meno autora môže mať najviac 255 znakov.';
            }
            // Obálka sa vyberá zo súborov na disku, takže do stĺpca `image` sa
            // nedá dostať cesta, ktorú by `normalizeArticleCoverPath()` odmietla.
            if ($image === '') {
                $image = null;
            } else {
                $image = normalizeArticleCoverPath($image);
                if ($image === null || !is_file(__DIR__ . '/' . $image)) {
                    $errors[] = 'Zvolená obálka neexistuje v images/articles/.';
                    $image = null;
                }
            }
            // Prázdny alt text pri nastavenej obálke padá na názov článku —
            // rovnako ako v seederi. Obrázok bez alternatívneho textu by inak
            // zostal pre čítačku obrazovky nemý.
            if ($image !== null && $imageAlt === '') {
                $imageAlt = $title;
            }
            if ($image === null) {
                $imageAlt = '';
            }
            if (appTextLength($imageAlt) > 255) {
                $errors[] = 'Alternatívny text obálky môže mať najviac 255 znakov.';
            }
            if (!isSupportedLanguage($articleLang)) {
                $errors[] = 'Zvolený jazyk nie je podporovaný.';
            }
            if ($rawTranslationGroup !== '' && preg_match('/^[1-9][0-9]{0,8}$/D', $rawTranslationGroup) !== 1) {
                $errors[] = 'Skupina prekladov musí byť kladné celé číslo.';
            }
            // V jednej skupine smie byť od každého jazyka najviac jeden článok, inak
            // by prepínač jazyka aj hreflang zobrazovali náhodne jeden z nich.
            if ($translationGroup !== null && isSupportedLanguage($articleLang)) {
                $groupStmt = $pdo->prepare(
                    "SELECT id FROM articles WHERE translation_group = :group AND lang = :lang AND id != :id LIMIT 1"
                );
                $groupStmt->execute([
                    ':group' => $translationGroup,
                    ':lang' => $articleLang,
                    ':id' => $id ?? 0,
                ]);
                if ($groupStmt->fetch()) {
                    $errors[] = 'V tejto skupine prekladov už článok v zvolenom jazyku existuje.';
                }
            }
            if (appTextLength($rawContent) > 1000000) {
                $errors[] = 'Obsah je príliš dlhý (max 1 000 000 znakov).';
            }
            if ($content === '') {
                $errors[] = 'Obsah je povinný.';
            }
            if ($publishedAt === '') {
                $publishedAt = date('Y-m-d H:i:s');
            } else {
                $publishedDate = DateTimeImmutable::createFromFormat('!Y-m-d\TH:i', $publishedAt);
                $dateErrors = DateTimeImmutable::getLastErrors();
                if (!$publishedDate || (is_array($dateErrors) && ($dateErrors['warning_count'] > 0 || $dateErrors['error_count'] > 0))) {
                    $errors[] = 'Dátum publikovania nie je platný.';
                } else {
                    $publishedAt = $publishedDate->format('Y-m-d H:i:s');
                }
            }

            if (empty($errors)) {
                // Slug musí byť jedinečný v rámci jazyka; ten istý článok tak môže
                // mať preklad pod rovnakým slugom v inom jazyku.
                $dupStmt = $pdo->prepare("SELECT id FROM articles WHERE slug = :slug AND lang = :lang AND id != :id LIMIT 1");
                $dupStmt->execute([':slug' => $slug, ':lang' => $articleLang, ':id' => $id ?? 0]);
                if ($dupStmt->fetch()) {
                    $errors[] = 'Slug už v tomto jazyku existuje.';
                } else {
                    if ($id) {
                        $stmt = $pdo->prepare(
                            "UPDATE articles SET title = :title, slug = :slug, excerpt = :excerpt,
                             image = :image, image_alt = :image_alt, content = :content,
                             author = :author, lang = :lang, translation_group = :translation_group,
                             sort_order = :sort_order, is_published = :is_published, is_top = :is_top,
                             published_at = :published_at WHERE id = :id"
                        );
                        $stmt->execute([
                            ':title' => $title, ':slug' => $slug, ':excerpt' => $excerpt,
                            ':image' => $image, ':image_alt' => $image === null ? null : $imageAlt,
                            ':content' => $content,
                            ':author' => $author, ':lang' => $articleLang,
                            ':translation_group' => $translationGroup ?? $id,
                            ':sort_order' => $sortOrder, ':is_published' => $isPublished,
                            ':is_top' => $isTop, ':published_at' => $publishedAt, ':id' => $id,
                        ]);
                        logAdminAction($pdo, 'article_update', 'article', $id);
                    } else {
                        $stmt = $pdo->prepare(
                            "INSERT INTO articles (title, slug, excerpt, image, image_alt, content, author, lang, translation_group, sort_order, is_published, is_top, published_at)
                             VALUES (:title, :slug, :excerpt, :image, :image_alt, :content, :author, :lang, :translation_group, :sort_order, :is_published, :is_top, :published_at)"
                        );
                        $stmt->execute([
                            ':title' => $title, ':slug' => $slug, ':excerpt' => $excerpt,
                            ':image' => $image, ':image_alt' => $image === null ? null : $imageAlt,
                            ':content' => $content,
                            ':author' => $author, ':lang' => $articleLang, ':translation_group' => $translationGroup,
                            ':sort_order' => $sortOrder, ':is_published' => $isPublished,
                            ':is_top' => $isTop, ':published_at' => $publishedAt,
                        ]);
                        $id = (int) $pdo->lastInsertId();
                        // Bez zadanej skupiny tvorí nový článok vlastnú skupinu prekladov.
                        if ($translationGroup === null) {
                            $groupStmt = $pdo->prepare("UPDATE articles SET translation_group = :group WHERE id = :id");
                            $groupStmt->execute([':group' => $id, ':id' => $id]);
                        }
                        logAdminAction($pdo, 'article_create', 'article', $id);
                    }
                    $groupId = $translationGroup ?? $id;
                    $topStmt = $pdo->prepare(
                        "UPDATE articles SET is_top = :is_top WHERE translation_group = :group"
                    );
                    $topStmt->execute([':is_top' => $isTop, ':group' => $groupId]);
                    header('Location: admin_articles.php?edit=' . $id . '&saved=1');
                    exit;
                }
            }
        }
    }
}

if (isset($_GET['edit']) && is_numeric($_GET['edit'])) {
    $stmt = $pdo->prepare("SELECT * FROM articles WHERE id = :id LIMIT 1");
    $stmt->execute([':id' => (int) $_GET['edit']]);
    $editing = $stmt->fetch();
}

if (isset($_GET['saved']) && $editing) {
    $success = 'Článok bol úspešne uložený.';
}
if (isset($_GET['top'])) {
    $success = 'Označenie Top (Navrchu) bolo uložené pre všetky jazykové verzie.';
}

$articleGroups = [];
foreach ($allArticles as $articleRow) {
    $groupKey = $articleRow['translation_group'] !== null
        ? 'g' . (int) $articleRow['translation_group']
        : 'id' . (int) $articleRow['id'];
    $articleGroups[$groupKey][] = $articleRow;
}
$articleGroups = array_map(static function (array $members): array {
    $byLang = [];
    $isTop = 0;
    $publishedCount = 0;
    $publishedAt = '';
    foreach ($members as $member) {
        $byLang[(string) $member['lang']] = $member;
        if ((int) $member['is_top'] === 1) {
            $isTop = 1;
        }
        if ((int) $member['is_published'] === 1) {
            $publishedCount++;
        }
        $stamp = (string) ($member['published_at'] ?? '');
        if ($stamp > $publishedAt) {
            $publishedAt = $stamp;
        }
    }
    $primary = $byLang[APP_DEFAULT_LANGUAGE] ?? reset($byLang);
    return [
        'primary' => $primary,
        'by_lang' => $byLang,
        'is_top' => $isTop,
        'published_count' => $publishedCount,
        'total' => count($members),
        'published_at' => $publishedAt,
        'group' => $primary['translation_group'] !== null ? (int) $primary['translation_group'] : null,
    ];
}, $articleGroups);
usort($articleGroups, static function (array $a, array $b): int {
    if ($a['is_top'] !== $b['is_top']) {
        return $b['is_top'] <=> $a['is_top'];
    }
    return strcmp((string) $b['published_at'], (string) $a['published_at']);
});

$baseUrl = getAppBaseUrl();
$pageTitle = 'Správa článkov | MUDr. Ľubomír Polaščín';
$seoDescription = 'Správa článkov na Polascin.net.';
$robotsMeta = 'noindex, nofollow';
$canonicalUrl = $baseUrl . '/admin_articles.php';
?>
<!DOCTYPE html>
<html lang="sk">
<head>
<?php include __DIR__ . '/head_meta.php'; ?>
</head>
<body>
<?php include __DIR__ . '/header.php'; ?>
<main id="main-content" tabindex="-1" aria-label="Správa článkov">
  <section class="admin-section">
    <div class="container">
      <h1>Správa článkov</h1>
      <p><a href="admin.php" class="btn btn-secondary btn-sm">Späť na panel</a></p>
      <?php if ($success): ?><div class="alert alert-success"><p><?= htmlspecialchars($success, ENT_QUOTES, 'UTF-8') ?></p></div><?php endif; ?>
      <?php foreach ($errors as $error): ?><div class="alert alert-error"><p><?= htmlspecialchars($error, ENT_QUOTES, 'UTF-8') ?></p></div><?php endforeach; ?>

      <form method="post" action="admin_articles.php" class="admin-form">
        <input type="hidden" name="csrf_token" value="<?= htmlspecialchars(generateCsrfToken(), ENT_QUOTES, 'UTF-8') ?>">
        <input type="hidden" name="action" value="save">
        <?php if ($editing): ?><input type="hidden" name="id" value="<?= (int) $editing['id'] ?>"><?php endif; ?>

        <div class="form-group">
          <label for="title">Názov</label>
          <input type="text" id="title" name="title" value="<?= htmlspecialchars((string) ($editing['title'] ?? ''), ENT_QUOTES, 'UTF-8') ?>" required maxlength="255">
        </div>
        <div class="form-group">
          <label for="slug">Slug (časť URL)</label>
          <input type="text" id="slug" name="slug" value="<?= htmlspecialchars((string) ($editing['slug'] ?? ''), ENT_QUOTES, 'UTF-8') ?>" maxlength="255" placeholder="automaticky vygenerovaný z názvu, ak je prázdny">
        </div>
        <div class="form-group">
          <label for="author">Autor</label>
          <input type="text" id="author" name="author" value="<?= htmlspecialchars((string) ($editing['author'] ?? ''), ENT_QUOTES, 'UTF-8') ?>" maxlength="255">
        </div>
        <?php
        $editingImage = trim((string) ($editing['image'] ?? ''));
        $coverChoices = availableArticleCovers();
        // Uloženú hodnotu treba v ponuke nechať aj vtedy, keď súbor na disku
        // chýba — inak by uloženie formulára obálku ticho zmazalo.
        $coverMissing = $editingImage !== '' && !in_array($editingImage, $coverChoices, true);
        ?>
        <div class="form-row">
          <div class="form-group">
            <label for="image">Obálka</label>
            <select id="image" name="image" aria-describedby="image-hint">
              <option value="">— bez obálky —</option>
              <?php if ($coverMissing): ?>
                <option value="<?= htmlspecialchars($editingImage, ENT_QUOTES, 'UTF-8') ?>" selected>
                  <?= htmlspecialchars(basename($editingImage), ENT_QUOTES, 'UTF-8') ?> (súbor chýba)
                </option>
              <?php endif; ?>
              <?php foreach ($coverChoices as $coverChoice): ?>
                <option value="<?= htmlspecialchars($coverChoice, ENT_QUOTES, 'UTF-8') ?>" <?= $coverChoice === $editingImage ? 'selected' : '' ?>>
                  <?= htmlspecialchars(basename($coverChoice), ENT_QUOTES, 'UTF-8') ?>
                </option>
              <?php endforeach; ?>
            </select>
            <small id="image-hint" class="form-hint">Súbory z <code>images/articles/</code>. Nový obrázok sa pridáva do repozitára, nie cez formulár.</small>
          </div>
          <div class="form-group">
            <label for="image_alt">Alternatívny text obálky</label>
            <input type="text" id="image_alt" name="image_alt" maxlength="255"
                   value="<?= htmlspecialchars((string) ($editing['image_alt'] ?? ''), ENT_QUOTES, 'UTF-8') ?>"
                   aria-describedby="image-alt-hint">
            <small id="image-alt-hint" class="form-hint">Popis obrázka pre čítačky obrazovky a <code>og:image:alt</code>. Ak zostane prázdny, použije sa názov článku.</small>
          </div>
        </div>
        <?php if ($coverMissing): ?>
          <div class="alert alert-error"><p>Obálka <code><?= htmlspecialchars($editingImage, ENT_QUOTES, 'UTF-8') ?></code> nie je na disku. Doplň súbor do repozitára alebo vyber inú.</p></div>
        <?php endif; ?>
        <div class="form-row">
          <div class="form-group">
            <label for="lang"><?= te('admin.language') ?></label>
            <select id="lang" name="lang" aria-describedby="lang-hint">
              <?php $editingLang = (string) ($editing['lang'] ?? APP_DEFAULT_LANGUAGE); ?>
              <?php foreach (appLanguages() as $code => $meta): ?>
                <option value="<?= htmlspecialchars($code, ENT_QUOTES, 'UTF-8') ?>" <?= $code === $editingLang ? 'selected' : '' ?>>
                  <?= htmlspecialchars((string) $meta['native'], ENT_QUOTES, 'UTF-8') ?> (<?= htmlspecialchars($code, ENT_QUOTES, 'UTF-8') ?>)
                </option>
              <?php endforeach; ?>
            </select>
            <small id="lang-hint" class="form-hint"><?= te('admin.language_hint') ?></small>
          </div>
          <div class="form-group">
            <label for="translation_group"><?= te('admin.translation_group') ?></label>
            <input type="number" id="translation_group" name="translation_group" min="1" step="1"
                   value="<?= isset($editing['translation_group']) && $editing['translation_group'] !== null ? (int) $editing['translation_group'] : '' ?>"
                   aria-describedby="translation-group-hint">
            <small id="translation-group-hint" class="form-hint"><?= te('admin.translation_group_hint') ?></small>
          </div>
        </div>
        <div class="form-group">
          <label for="excerpt">Úryvok</label>
          <textarea id="excerpt" name="excerpt" rows="3" maxlength="5000"><?= htmlspecialchars((string) ($editing['excerpt'] ?? ''), ENT_QUOTES, 'UTF-8') ?></textarea>
        </div>
        <div class="form-group">
          <label for="content">Obsah (HTML povolené)</label>
          <textarea id="content" name="content" rows="12" required maxlength="1000000"><?= htmlspecialchars((string) ($editing['content'] ?? ''), ENT_QUOTES, 'UTF-8') ?></textarea>
        </div>
        <div class="form-row">
          <div class="form-group">
            <label for="sort_order">Poradie</label>
            <input type="number" id="sort_order" name="sort_order" value="<?= (int) ($editing['sort_order'] ?? 0) ?>">
          </div>
          <div class="form-group">
            <label for="published_at">Publikované</label>
            <input type="datetime-local" id="published_at" name="published_at" value="<?= isset($editing['published_at']) ? date('Y-m-d\TH:i', strtotime((string) $editing['published_at'])) : date('Y-m-d\TH:i') ?>">
          </div>
        </div>
        <div class="form-checks">
          <label><input type="checkbox" name="is_published" value="1" <?= (isset($editing['is_published']) && (int) $editing['is_published'] === 1) ? 'checked' : '' ?>> Publikovaný</label>
          <label><input type="checkbox" name="is_top" value="1" <?= (isset($editing['is_top']) && (int) $editing['is_top'] === 1) ? 'checked' : '' ?>> Top (Navrchu)</label>
        </div>
        <div class="form-actions">
          <button type="submit" name="action" value="save" class="btn btn-secondary">Uložiť koncept</button>
          <button type="submit" name="action" value="publish" class="btn btn-primary">Uložiť a&nbsp;publikovať</button>
          <?php if ($editing): ?><a href="admin_articles.php" class="btn btn-secondary">Nový článok</a><?php endif; ?>
        </div>
      </form>

      <h2>Články podľa jazykových skupín</h2>
      <p class="form-hint">Jeden riadok je jeden článok vo všetkých jazykoch. Klik na skratku jazyka otvorí tú verziu. Top (Navrchu) platí pre celú skupinu a na webe ju zaradí pred ostatné; v rámci Top aj mimo neho ostáva poradie od najnovšieho.</p>
      <?php if ($articleGroups === []): ?>
        <p>Zatiaľ žiadne články.</p>
      <?php else: ?>
      <div class="table-responsive">
      <table class="admin-table">
        <thead>
          <tr><th>Názov</th><th>Jazyky</th><th>Stav</th><th>Publikované</th><th>Akcie</th></tr>
        </thead>
        <tbody>
          <?php foreach ($articleGroups as $group): ?>
          <?php $primary = $group['primary']; ?>
          <tr>
            <td>
              <?= htmlspecialchars((string) $primary['title'], ENT_QUOTES, 'UTF-8') ?>
              <?php if ((int) $group['is_top'] === 1): ?> <strong>Top</strong><?php endif; ?>
              <br><small><?= htmlspecialchars((string) $primary['slug'], ENT_QUOTES, 'UTF-8') ?></small>
            </td>
            <td>
              <div class="lang-chips">
                <?php foreach (appLanguages() as $code => $meta): ?>
                  <?php if (isset($group['by_lang'][$code])): ?>
                    <a class="lang-chip" href="admin_articles.php?edit=<?= (int) $group['by_lang'][$code]['id'] ?>" title="<?= htmlspecialchars((string) $meta['native'], ENT_QUOTES, 'UTF-8') ?>"><?= htmlspecialchars(strtoupper($code), ENT_QUOTES, 'UTF-8') ?></a>
                  <?php else: ?>
                    <span class="lang-chip is-missing" title="<?= htmlspecialchars((string) $meta['native'], ENT_QUOTES, 'UTF-8') ?> chýba"><?= htmlspecialchars(strtoupper($code), ENT_QUOTES, 'UTF-8') ?></span>
                  <?php endif; ?>
                <?php endforeach; ?>
              </div>
            </td>
            <td><?= (int) $group['published_count'] ?>/<?= (int) $group['total'] ?> publikovaných</td>
            <td><?= htmlspecialchars((string) $group['published_at'], ENT_QUOTES, 'UTF-8') ?></td>
            <td class="actions">
              <a href="admin_articles.php?edit=<?= (int) $primary['id'] ?>" class="btn btn-sm btn-secondary">Upraviť</a>
              <a href="<?= htmlspecialchars(langUrl((string) ($primary['lang'] ?? APP_DEFAULT_LANGUAGE), 'article.php', ['slug' => (string) $primary['slug']]), ENT_QUOTES, 'UTF-8') ?>" target="_blank" rel="noopener noreferrer" class="btn btn-sm btn-secondary">Zobraziť</a>
              <?php if ($group['group'] !== null): ?>
              <form method="post" action="admin_articles.php" class="inline-form">
                <input type="hidden" name="csrf_token" value="<?= htmlspecialchars(generateCsrfToken(), ENT_QUOTES, 'UTF-8') ?>">
                <input type="hidden" name="action" value="toggle_top">
                <input type="hidden" name="translation_group" value="<?= (int) $group['group'] ?>">
                <button type="submit" class="btn btn-sm <?= (int) $group['is_top'] === 1 ? 'btn-primary' : 'btn-secondary' ?>"><?= (int) $group['is_top'] === 1 ? 'Zrušiť Top' : 'Top (Navrchu)' ?></button>
              </form>
              <form method="post" action="admin_articles.php" class="inline-form" data-confirm="Odstrániť všetky jazykové verzie tohto článku?">
                <input type="hidden" name="csrf_token" value="<?= htmlspecialchars(generateCsrfToken(), ENT_QUOTES, 'UTF-8') ?>">
                <input type="hidden" name="action" value="delete_group">
                <input type="hidden" name="translation_group" value="<?= (int) $group['group'] ?>">
                <button type="submit" class="btn btn-sm btn-danger">Odstrániť skupinu</button>
              </form>
              <?php endif; ?>
            </td>
          </tr>
          <?php endforeach; ?>
        </tbody>
      </table>
      </div>
      <?php endif; ?>
    </div>
  </section>
</main>
<?php include __DIR__ . '/footer.php'; ?>
</body>
</html>
