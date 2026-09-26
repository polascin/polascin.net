<?php

declare(strict_types=1);

require_once __DIR__ . '/auth.php';
require_once __DIR__ . '/db_config.php';
require_once __DIR__ . '/helpers.php';

requireAdmin();

/** @var PDO $pdo */

$errors = [];
$form = [
    'title' => '',
    'author' => 'MUDr. Ľubomír Polaščín',
    'description' => '',
];

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $csrfToken = $_POST['csrf_token'] ?? '';
    if (!validateCsrfToken(is_string($csrfToken) ? $csrfToken : '')) {
        $errors[] = 'Neplatný bezpečnostný token. Odošlite formulár znova.';
    } else {
        $action = $_POST['action'] ?? '';
        if ($action === 'delete') {
            $slug = isset($_POST['slug']) && is_string($_POST['slug']) ? $_POST['slug'] : '';
            if (!libraryDeleteUpload($slug)) {
                $errors[] = 'Nahratý text sa nepodarilo odstrániť. Text, ktorý je súčasťou webu, sa odstraňuje z repozitára.';
            } else {
                logAdminAction($pdo, 'library_delete', 'library', null, ['slug' => $slug]);
                setFlashMessage('success', 'Text bol odstránený z knižnice.');
                header('Location: admin_library.php', true, 303);
                exit;
            }
        } elseif ($action === 'upload') {
            $form['title'] = isset($_POST['title']) && is_string($_POST['title']) ? trim($_POST['title']) : '';
            $form['author'] = isset($_POST['author']) && is_string($_POST['author']) ? trim($_POST['author']) : '';
            $form['description'] = isset($_POST['description']) && is_string($_POST['description']) ? trim($_POST['description']) : '';
            $file = isset($_FILES['file']) && is_array($_FILES['file']) ? $_FILES['file'] : [];
            $saved = librarySaveUpload($form['title'], $form['author'], $form['description'], $file);
            if (!$saved['ok']) {
                $errors[] = $saved['error'];
            } else {
                logAdminAction($pdo, 'library_upload', 'library', null, ['slug' => $saved['slug']]);
                setFlashMessage('success', 'Text je v knižnici.');
                header('Location: admin_library.php', true, 303);
                exit;
            }
        } else {
            $errors[] = 'Neznáma akcia.';
        }
    }
}

$works = libraryList();
$uploadLimit = libraryFormatSize(libraryUploadLimitBytes());
$baseUrl = getAppBaseUrl();
$pageTitle = 'Knižnica | Administrácia';
$seoDescription = 'Správa osobnej knižnice textov.';
$robotsMeta = 'noindex, nofollow';
$canonicalUrl = $baseUrl . '/admin_library.php';
?>
<!DOCTYPE html>
<html lang="sk">
<head>
<?php include __DIR__ . '/head_meta.php'; ?>
</head>
<body>
<?php include __DIR__ . '/header.php'; ?>
<main id="main-content" tabindex="-1" aria-label="Správa knižnice">
  <section class="admin-section">
    <div class="container">
      <h1>Knižnica textov</h1>
      <p class="form-hint">Nahraté súbory zostanú na serveri aj po ďalšom nasadení webu. Povolené sú PDF, TXT, Markdown, HTML a EPUB, najviac <?= htmlspecialchars($uploadLimit, ENT_QUOTES, 'UTF-8') ?>.</p>
      <?php foreach ($errors as $error): ?>
        <div class="alert alert-error"><p><?= htmlspecialchars($error, ENT_QUOTES, 'UTF-8') ?></p></div>
      <?php endforeach; ?>

      <form method="post" enctype="multipart/form-data" class="admin-form" data-submit-once>
        <input type="hidden" name="csrf_token" value="<?= htmlspecialchars(generateCsrfToken(), ENT_QUOTES, 'UTF-8') ?>">
        <input type="hidden" name="action" value="upload">
        <div class="form-group">
          <label for="library-title">Názov</label>
          <input id="library-title" name="title" type="text" maxlength="255" required value="<?= htmlspecialchars($form['title'], ENT_QUOTES, 'UTF-8') ?>">
        </div>
        <div class="form-group">
          <label for="library-author">Autor</label>
          <input id="library-author" name="author" type="text" maxlength="255" value="<?= htmlspecialchars($form['author'], ENT_QUOTES, 'UTF-8') ?>">
        </div>
        <div class="form-group">
          <label for="library-description">Krátky popis</label>
          <textarea id="library-description" name="description" maxlength="4000" rows="4"><?= htmlspecialchars($form['description'], ENT_QUOTES, 'UTF-8') ?></textarea>
        </div>
        <div class="form-group">
          <label for="library-file">Súbor</label>
          <input id="library-file" name="file" type="file" required accept=".pdf,.txt,.md,.markdown,.html,.htm,.epub,application/pdf,text/plain,text/html,text/markdown">
        </div>
        <button type="submit" class="btn btn-primary">Uložiť do knižnice</button>
      </form>

      <h2>Uložené texty</h2>
      <?php if ($works === []): ?>
        <p>Knižnica je zatiaľ prázdna.</p>
      <?php else: ?>
          <table class="admin-table">
            <thead>
              <tr>
                <th>Názov</th>
                <th>Formát</th>
                <th>Veľkosť</th>
                <th>Pôvod</th>
                <th>Akcie</th>
              </tr>
            </thead>
            <tbody>
              <?php foreach ($works as $work): ?>
              <tr>
                <td><?= htmlspecialchars((string) $work['title'], ENT_QUOTES, 'UTF-8') ?></td>
                <td><?= htmlspecialchars(strtoupper((string) $work['extension']), ENT_QUOTES, 'UTF-8') ?></td>
                <td><?= htmlspecialchars(libraryFormatSize((int) $work['bytes']), ENT_QUOTES, 'UTF-8') ?></td>
                <td><?= (string) $work['source'] === 'uploads' ? 'nahraté' : 'súčasť webu' ?></td>
                <td class="actions">
                  <a class="btn btn-secondary btn-sm" href="<?= htmlspecialchars(langUrl('sk', 'library.php', ['slug' => (string) $work['slug']]), ENT_QUOTES, 'UTF-8') ?>">Otvoriť</a>
                  <?php if ((string) $work['source'] === 'uploads'): ?>
                  <form method="post" class="inline-form" data-submit-once>
                    <input type="hidden" name="csrf_token" value="<?= htmlspecialchars(generateCsrfToken(), ENT_QUOTES, 'UTF-8') ?>">
                    <input type="hidden" name="action" value="delete">
                    <input type="hidden" name="slug" value="<?= htmlspecialchars((string) $work['slug'], ENT_QUOTES, 'UTF-8') ?>">
                    <button type="submit" class="btn btn-secondary btn-sm">Odstrániť</button>
                  </form>
                  <?php endif; ?>
                </td>
              </tr>
              <?php endforeach; ?>
            </tbody>
          </table>
      <?php endif; ?>
    </div>
  </section>
</main>
<?php include __DIR__ . '/footer.php'; ?>
</body>
</html>
