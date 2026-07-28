<?php

declare(strict_types=1);

require_once __DIR__ . '/auth.php';
require_once __DIR__ . '/db_config.php';
requireAdmin();

/** @var PDO $pdo */

$errors = [];
$success = '';
$editing = null;

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $csrfToken = $_POST['csrf_token'] ?? '';
    if (!validateCsrfToken((string) $csrfToken)) {
        $errors[] = 'Invalid security token.';
    } else {
        $action = $_POST['action'] ?? '';
        if ($action === 'delete' && isset($_POST['id'])) {
            $stmt = $pdo->prepare("DELETE FROM content_blocks WHERE id = :id LIMIT 1");
            $stmt->execute([':id' => (int) $_POST['id']]);
            logAdminAction($pdo, 'content_delete', 'content_block', (int) $_POST['id']);
            header('Location: admin_content.php');
            exit;
        }

        if ($action === 'save') {
            $id = isset($_POST['id']) && is_numeric($_POST['id']) ? (int) $_POST['id'] : null;
            $blockKey = trim((string) ($_POST['block_key'] ?? ''));
            $title = trim((string) ($_POST['title'] ?? ''));
            $content = trim((string) ($_POST['content'] ?? ''));
            $lang = trim((string) ($_POST['lang'] ?? 'en'));
            $sortOrder = (int) ($_POST['sort_order'] ?? 0);
            $isActive = isset($_POST['is_active']) ? 1 : 0;

            if (!preg_match('/^[a-z0-9_\-]+$/', $blockKey) || mb_strlen($blockKey) > 64) {
                $errors[] = 'Block key is required and must contain only lowercase letters, numbers, underscores and hyphens.';
            }
            if ($title === '' || mb_strlen($title) > 255) {
                $errors[] = 'Title is required (max 255 characters).';
            }

            if (empty($errors)) {
                $dupStmt = $pdo->prepare("SELECT id FROM content_blocks WHERE block_key = :block_key AND id != :id LIMIT 1");
                $dupStmt->execute([':block_key' => $blockKey, ':id' => $id ?? 0]);
                if ($dupStmt->fetch()) {
                    $errors[] = 'Block key already exists.';
                } else {
                    if ($id) {
                        $stmt = $pdo->prepare(
                            "UPDATE content_blocks SET block_key = :block_key, title = :title, content = :content,
                             lang = :lang, sort_order = :sort_order, is_active = :is_active WHERE id = :id"
                        );
                        $stmt->execute([
                            ':block_key' => $blockKey, ':title' => $title, ':content' => $content,
                            ':lang' => $lang, ':sort_order' => $sortOrder, ':is_active' => $isActive, ':id' => $id,
                        ]);
                        logAdminAction($pdo, 'content_update', 'content_block', $id);
                    } else {
                        $stmt = $pdo->prepare(
                            "INSERT INTO content_blocks (block_key, title, content, lang, sort_order, is_active)
                             VALUES (:block_key, :title, :content, :lang, :sort_order, :is_active)"
                        );
                        $stmt->execute([
                            ':block_key' => $blockKey, ':title' => $title, ':content' => $content,
                            ':lang' => $lang, ':sort_order' => $sortOrder, ':is_active' => $isActive,
                        ]);
                        $id = (int) $pdo->lastInsertId();
                        logAdminAction($pdo, 'content_create', 'content_block', $id);
                    }
                    header('Location: admin_content.php?edit=' . $id . '&saved=1');
                    exit;
                }
            }
        }
    }
}

if (isset($_GET['edit']) && is_numeric($_GET['edit'])) {
    $stmt = $pdo->prepare("SELECT * FROM content_blocks WHERE id = :id LIMIT 1");
    $stmt->execute([':id' => (int) $_GET['edit']]);
    $editing = $stmt->fetch();
}

if (isset($_GET['saved']) && $editing) {
    $success = 'Content block saved successfully.';
}

$allBlocks = $pdo->query("SELECT * FROM content_blocks ORDER BY block_key ASC")->fetchAll();

$baseUrl = getAppBaseUrl();
$pageTitle = 'Admin Content Blocks | Dr. Lubomir Polascin';
$seoDescription = 'Manage homepage content blocks on Polascin.net.';
$robotsMeta = 'noindex, nofollow';
$canonicalUrl = $baseUrl . '/admin_content.php';
?>
<!DOCTYPE html>
<html lang="en">
<head>
<?php include __DIR__ . '/head_meta.php'; ?>
</head>
<body>
<?php include __DIR__ . '/header.php'; ?>
<main id="main-content" tabindex="-1" aria-label="Admin content blocks">
  <section class="admin-section">
    <div class="container">
      <h1>Manage Content Blocks</h1>
      <p><a href="admin.php" class="btn btn-secondary btn-sm">Back to dashboard</a></p>
      <?php if ($success): ?><div class="alert alert-success"><p><?= htmlspecialchars($success, ENT_QUOTES, 'UTF-8') ?></p></div><?php endif; ?>
      <?php foreach ($errors as $error): ?><div class="alert alert-error"><p><?= htmlspecialchars($error, ENT_QUOTES, 'UTF-8') ?></p></div><?php endforeach; ?>

      <form method="post" action="admin_content.php" class="admin-form">
        <input type="hidden" name="csrf_token" value="<?= htmlspecialchars(generateCsrfToken(), ENT_QUOTES, 'UTF-8') ?>">
        <input type="hidden" name="action" value="save">
        <?php if ($editing): ?><input type="hidden" name="id" value="<?= (int) $editing['id'] ?>"><?php endif; ?>
        <div class="form-group">
          <label for="block_key">Block key</label>
          <input type="text" id="block_key" name="block_key" value="<?= htmlspecialchars((string) ($editing['block_key'] ?? ''), ENT_QUOTES, 'UTF-8') ?>" required maxlength="64" placeholder="e.g. hero_title">
        </div>
        <div class="form-group">
          <label for="title">Title</label>
          <input type="text" id="title" name="title" value="<?= htmlspecialchars((string) ($editing['title'] ?? ''), ENT_QUOTES, 'UTF-8') ?>" required maxlength="255">
        </div>
        <div class="form-group">
          <label for="content">Content (HTML allowed)</label>
          <textarea id="content" name="content" rows="8"><?= htmlspecialchars((string) ($editing['content'] ?? ''), ENT_QUOTES, 'UTF-8') ?></textarea>
        </div>
        <div class="form-group">
          <label for="lang">Language</label>
          <input type="text" id="lang" name="lang" value="<?= htmlspecialchars((string) ($editing['lang'] ?? 'en'), ENT_QUOTES, 'UTF-8') ?>" maxlength="5">
        </div>
        <div class="form-group">
          <label for="sort_order">Sort order</label>
          <input type="number" id="sort_order" name="sort_order" value="<?= (int) ($editing['sort_order'] ?? 0) ?>">
        </div>
        <div class="form-checks">
          <label><input type="checkbox" name="is_active" value="1" <?= (isset($editing['is_active']) && (int) $editing['is_active'] === 1) ? 'checked' : '' ?>> Active</label>
        </div>
        <div class="form-actions">
          <button type="submit" class="btn btn-primary">Save block</button>
          <?php if ($editing): ?><a href="admin_content.php" class="btn btn-secondary">New block</a><?php endif; ?>
        </div>
      </form>

      <h2>Existing Blocks</h2>
      <table class="admin-table">
        <thead><tr><th>Key</th><th>Title</th><th>Lang</th><th>Active</th><th>Actions</th></tr></thead>
        <tbody>
          <?php foreach ($allBlocks as $block): ?>
          <tr>
            <td><?= htmlspecialchars((string) $block['block_key'], ENT_QUOTES, 'UTF-8') ?></td>
            <td><?= htmlspecialchars((string) $block['title'], ENT_QUOTES, 'UTF-8') ?></td>
            <td><?= htmlspecialchars((string) $block['lang'], ENT_QUOTES, 'UTF-8') ?></td>
            <td><?= (int) $block['is_active'] === 1 ? 'Yes' : 'No' ?></td>
            <td class="actions">
              <a href="admin_content.php?edit=<?= (int) $block['id'] ?>" class="btn btn-sm btn-secondary">Edit</a>
              <form method="post" action="admin_content.php" class="inline-form" data-confirm="Delete this block?">
                <input type="hidden" name="csrf_token" value="<?= htmlspecialchars(generateCsrfToken(), ENT_QUOTES, 'UTF-8') ?>">
                <input type="hidden" name="action" value="delete">
                <input type="hidden" name="id" value="<?= (int) $block['id'] ?>">
                <button type="submit" class="btn btn-sm btn-danger">Delete</button>
              </form>
            </td>
          </tr>
          <?php endforeach; ?>
        </tbody>
      </table>
    </div>
  </section>
</main>
<?php include __DIR__ . '/footer.php'; ?>
</body>
</html>
