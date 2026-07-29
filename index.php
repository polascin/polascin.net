<?php

declare(strict_types=1);

require_once __DIR__ . '/config_loader.php';

try {
    loadAppConfig();
} catch (AppConfigException) {
    readfile(__DIR__ . '/index.html');
    exit;
}

require_once __DIR__ . '/auth.php';
require_once __DIR__ . '/db_config.php';
require_once __DIR__ . '/helpers.php';

/** @var PDO $pdo */

$baseUrl = getAppBaseUrl();
$siteName = 'Polascin.net';
$lang = currentLang();

// Redakčný blok má prednosť; ak pre daný jazyk nie je vyplnený, použije sa
// preklad z katalógu, takže stránka je kompletná vo všetkých jazykoch.
$heroTitle = getContentBlock($pdo, 'hero_title', t('home.hero_title'));
$heroSubtitle = getContentBlock($pdo, 'hero_subtitle', t('home.hero_subtitle'));
$aboutIntro = getContentBlock($pdo, 'about_intro', t('home.about_intro'));
$aboutWho = getContentBlock($pdo, 'about_who', t('home.about_who'));
$contactIntro = getContentBlock($pdo, 'contact_intro', t('home.contact_intro'));

$latestArticles = getPublishedArticles($pdo, 3);

$structuredData = [
    '@context' => 'https://schema.org',
    '@type' => 'Person',
    'name' => 'MUDr. Ľubomír Polaščín',
    'alternateName' => 'Lubomir Polascin',
    'url' => $baseUrl . '/',
    'image' => $baseUrl . '/images/profile.jpg',
    'jobTitle' => t('home.identity_nephrologist') . ' / ' . t('home.identity_internist'),
    'description' => t('meta.default_description'),
    'alumniOf' => 'Univerzita Pavla Jozefa Šafárika v Košiciach',
    'sameAs' => [
        'https://polascin.com/',
        'https://polascin.sk/',
        'https://polascin.org/',
        'https://books.polascin.net/',
        'https://nefro.polascin.net/',
        'https://nephrosite.polascin.net/',
        'https://www.amazon.com/stores/author/B07PN436VJ/about',
        // Autorská stránka literárneho pseudonymu Walter Kyo Csoelle.
        'https://www.amazon.com/stores/Walter-Kyo-Csoelle/author/B0G2TCCJZZ',
        'https://www.linkedin.com/in/lubomirpolascin/',
        'https://x.com/polascin',
        'https://www.facebook.com/lubomir.polascin',
        'https://www.patreon.com/c/Csoelle',
        'https://github.com/polascin',
    ],
];

// Na domovskej stránke nesie titulok meno a odbornosť, nie slovo „Domov“ —
// to vo výsledkoch vyhľadávania nič nehovorí.
$pageTitle = t('common.author') . ' | ' . t('meta.home_tagline');
$seoDescription = t('meta.default_description');
$canonicalUrl = absoluteLangUrl($lang, 'index.php');
?>
<!DOCTYPE html>
<html lang="<?= htmlspecialchars($lang, ENT_QUOTES, 'UTF-8') ?>">
<head>
<?php include __DIR__ . '/head_meta.php'; ?>
</head>
<body>
<?php include __DIR__ . '/header.php'; ?>

<main id="main-content" tabindex="-1" aria-label="<?= te('common.main_content') ?>">
  <section id="home" class="hero">
    <div class="container">
      <div class="hero-content">
        <img src="CrystalKidney.png" alt="<?= te('home.logo_alt') ?>" class="profile-img" loading="eager">
        <h1 class="hero-title"><?= htmlspecialchars($heroTitle, ENT_QUOTES, 'UTF-8') ?></h1>
        <p class="hero-subtitle"><?= htmlspecialchars($heroSubtitle, ENT_QUOTES, 'UTF-8') ?></p>
        <div class="hero-buttons">
          <a href="#about" class="btn btn-primary"><?= te('home.cta_about') ?></a>
          <a href="<?= htmlspecialchars(langUrl($lang, 'articles.php'), ENT_QUOTES, 'UTF-8') ?>" class="btn btn-secondary"><?= te('home.cta_articles') ?></a>
        </div>
      </div>
    </div>
  </section>

  <section id="about" class="about">
    <div class="container">
      <h2 class="section-title reveal"><?= te('home.about_heading') ?></h2>
      <div class="about-grid">
        <div class="about-text">
          <p><?= nl2br(htmlspecialchars($aboutIntro, ENT_QUOTES, 'UTF-8'), false) ?></p>
          <p><?= nl2br(htmlspecialchars($aboutWho, ENT_QUOTES, 'UTF-8'), false) ?></p>
          <p><?= te('home.about_synthesis') ?></p>

          <h3><?= te('home.areas_heading') ?></h3>
          <div class="area-grid">
            <div class="area">
              <h4><?= te('home.areas_medicine') ?></h4>
              <ul>
                <li><?= te('home.areas_medicine_1') ?></li>
                <li><?= te('home.areas_medicine_2') ?></li>
                <li><?= te('home.areas_medicine_3') ?></li>
                <li><?= te('home.areas_medicine_4') ?></li>
                <li><?= te('home.areas_medicine_5') ?></li>
              </ul>
            </div>
            <div class="area">
              <h4><?= te('home.areas_language') ?></h4>
              <ul>
                <li><?= te('home.areas_language_1') ?></li>
                <li><?= te('home.areas_language_2') ?></li>
                <li><?= te('home.areas_language_3') ?></li>
                <li><?= te('home.areas_language_4') ?></li>
                <li><?= te('home.areas_language_5') ?></li>
              </ul>
            </div>
            <div class="area">
              <h4><?= te('home.areas_tech') ?></h4>
              <ul>
                <li><?= te('home.areas_tech_1') ?></li>
                <li><?= te('home.areas_tech_2') ?></li>
                <li><?= te('home.areas_tech_3') ?></li>
                <li><?= te('home.areas_tech_4') ?></li>
                <li><?= te('home.areas_tech_5') ?></li>
              </ul>
            </div>
          </div>

          <h3><?= te('home.skills_heading') ?></h3>
          <dl class="skill-list">
            <dt><?= te('home.skills_web') ?></dt>
            <dd><?= te('home.skills_web_text') ?></dd>
            <dt><?= te('home.skills_data') ?></dt>
            <dd><?= te('home.skills_data_text') ?></dd>
            <dt><?= te('home.skills_systems') ?></dt>
            <dd><?= te('home.skills_systems_text') ?></dd>
            <dt><?= te('home.skills_ai') ?></dt>
            <dd><?= te('home.skills_ai_text') ?></dd>
          </dl>

          <h3><?= te('home.education_heading') ?></h3>
          <p><?= te('home.education_text') ?></p>
          <p><?= te('home.education_path') ?></p>
          <p><?= te('home.education_scope') ?></p>

          <h3><?= te('home.personal_heading') ?></h3>
          <p><?= te('home.personal_text') ?></p>
          <p><?= te('home.personal_writing') ?></p>

          <div class="about-actions">
            <a href="https://books.polascin.net/" target="_blank" rel="noopener noreferrer" class="btn btn-primary btn-sm"><?= te('home.books_cta') ?></a>
            <a href="https://www.amazon.com/stores/author/B07PN436VJ/about" target="_blank" rel="noopener noreferrer" class="btn btn-secondary btn-sm"><?= te('home.amazon_cta') ?></a>
            <?php // Pseudonym je vlastné meno, neprekladá sa — kľúč v katalógoch netreba. ?>
            <a href="https://www.amazon.com/stores/Walter-Kyo-Csoelle/author/B0G2TCCJZZ" target="_blank" rel="noopener noreferrer" class="btn btn-secondary btn-sm">Walter Kyo Csoelle (Amazon)</a>
          </div>
        </div>
      </div>
    </div>
  </section>

  <section id="nephrology" class="nephrology">
    <div class="container">
      <h2 class="section-title reveal"><?= te('home.nephrology_heading') ?></h2>
      <p class="section-intro"><?= te('home.nephrology_intro') ?></p>
      <div class="card-grid">
        <article class="card reveal"><div class="card-icon"><i class="fa-solid fa-stethoscope" aria-hidden="true"></i></div><h3><?= te('home.ckd_title') ?></h3><p><?= te('home.ckd_text') ?></p></article>
        <article class="card reveal"><div class="card-icon"><i class="fa-solid fa-bolt-lightning" aria-hidden="true"></i></div><h3><?= te('home.aki_title') ?></h3><p><?= te('home.aki_text') ?></p></article>
        <article class="card reveal"><div class="card-icon"><i class="fa-solid fa-droplet" aria-hidden="true"></i></div><h3><?= te('home.hemodialysis_title') ?></h3><p><?= te('home.hemodialysis_text') ?></p></article>
        <article class="card reveal"><div class="card-icon"><i class="fa-solid fa-house-medical" aria-hidden="true"></i></div><h3><?= te('home.peritoneal_title') ?></h3><p><?= te('home.peritoneal_text') ?></p></article>
        <article class="card reveal"><div class="card-icon"><i class="fa-solid fa-hand-holding-medical" aria-hidden="true"></i></div><h3><?= te('home.transplant_title') ?></h3><p><?= te('home.transplant_text') ?></p></article>
        <article class="card reveal"><div class="card-icon"><i class="fa-solid fa-magnifying-glass" aria-hidden="true"></i></div><h3><?= te('home.diagnostics_title') ?></h3><p><?= te('home.diagnostics_text') ?></p></article>
      </div>
      <p class="section-muted nephrology-note"><?= te('home.nephrology_note') ?></p>
    </div>
  </section>

  <?php if (!empty($latestArticles)): ?>
  <section id="latest-articles" class="latest-articles">
    <div class="container">
      <h2 class="section-title reveal"><?= te('home.latest_heading') ?></h2>
      <div class="card-grid">
        <?php foreach ($latestArticles as $article): ?>
        <article class="card reveal">
          <h3><a href="<?= htmlspecialchars(langUrl($lang, 'article.php', ['slug' => (string) $article['slug']]), ENT_QUOTES, 'UTF-8') ?>"><?= htmlspecialchars((string) $article['title'], ENT_QUOTES, 'UTF-8') ?></a></h3>
          <p class="article-meta"><?= htmlspecialchars(formatArticleDate($article['published_at'] ?? null), ENT_QUOTES, 'UTF-8') ?></p>
          <p><?= htmlspecialchars(buildSeoExcerpt((string) ($article['excerpt'] ?? '')), ENT_QUOTES, 'UTF-8') ?></p>
        </article>
        <?php endforeach; ?>
      </div>
      <p class="center-link"><a href="<?= htmlspecialchars(langUrl($lang, 'articles.php'), ENT_QUOTES, 'UTF-8') ?>" class="btn btn-secondary"><?= te('home.all_articles') ?></a></p>
    </div>
  </section>
  <?php endif; ?>

  <section id="projects" class="projects-section">
    <div class="container">
      <h2 class="section-title reveal"><?= te('home.projects_heading') ?></h2>
      <p class="section-intro"><?= te('home.projects_intro') ?></p>
      <div class="card-grid">
        <article class="card project-card"><div class="card-icon"><i class="fa-solid fa-microscope" aria-hidden="true"></i></div><h3>Nefro-projekt Slovensko</h3><p><?= te('home.project_nefro_text') ?></p><a href="https://nefro.polascin.net/" target="_blank" rel="noopener noreferrer" class="btn btn-secondary btn-sm"><?= te('common.visit', ['target' => 'nefro.polascin.net']) ?></a></article>
        <article class="card project-card"><div class="card-icon"><i class="fa-solid fa-hospital-user" aria-hidden="true"></i></div><h3>NephroSite</h3><p><?= te('home.project_nephrosite_text') ?></p><a href="https://nephrosite.polascin.net/" target="_blank" rel="noopener noreferrer" class="btn btn-secondary btn-sm"><?= te('common.visit', ['target' => 'nephrosite.polascin.net']) ?></a></article>
        <article class="card project-card"><div class="card-icon"><i class="fa-solid fa-book-open" aria-hidden="true"></i></div><h3>Bibliotheca Polascini</h3><p><?= te('home.project_books_text') ?></p><a href="https://books.polascin.net/" target="_blank" rel="noopener noreferrer" class="btn btn-secondary btn-sm"><?= te('common.visit', ['target' => 'books.polascin.net']) ?></a></article>
        <article class="card project-card"><div class="card-icon"><i class="fa-solid fa-ticket" aria-hidden="true"></i></div><h3>AlphaGrab</h3><p><?= te('home.project_alphagrab_text') ?></p><a href="https://alphagrab.de/" target="_blank" rel="noopener noreferrer" class="btn btn-secondary btn-sm"><?= te('common.visit', ['target' => 'alphagrab.de']) ?></a></article>
        <article class="card project-card"><div class="card-icon"><i class="fa-solid fa-laptop-medical" aria-hidden="true"></i></div><h3>Arenibus</h3><p><?= te('home.project_arenibus_text') ?></p><a href="https://arenibus.polascin.net/" target="_blank" rel="noopener noreferrer" class="btn btn-secondary btn-sm"><?= te('common.visit', ['target' => 'arenibus.polascin.net']) ?></a></article>
      </div>
    </div>
  </section>

  <section id="links" class="links-section">
    <div class="container">
      <h2 class="section-title reveal"><?= te('home.links_heading') ?></h2>
      <p class="section-muted"><?= te('home.links_intro') ?></p>
      <div class="link-grid">
        <a href="https://polascin.com/" class="pill-link" target="_blank" rel="noopener noreferrer"><i class="fa-solid fa-staff-snake" aria-hidden="true"></i> polascin.com</a>
        <a href="https://polascin.sk/" class="pill-link" target="_blank" rel="noopener noreferrer"><i class="fa-solid fa-globe" aria-hidden="true"></i> polascin.sk</a>
        <a href="https://polascin.org/" class="pill-link" target="_blank" rel="noopener noreferrer"><i class="fa-solid fa-building" aria-hidden="true"></i> polascin.org</a>
        <a href="https://nephrosite.polascin.net/" class="pill-link" target="_blank" rel="noopener noreferrer"><i class="fa-solid fa-hospital-user" aria-hidden="true"></i> <?= te('home.link_nephrosite') ?></a>
        <a href="https://nefro.polascin.net/" class="pill-link" target="_blank" rel="noopener noreferrer"><i class="fa-solid fa-microscope" aria-hidden="true"></i> Nefro-projekt Slovensko</a>
        <a href="https://nefro.polascin.net/dialyza-bratislava.php" class="pill-link" target="_blank" rel="noopener noreferrer"><i class="fa-solid fa-location-dot" aria-hidden="true"></i> <?= te('home.link_dialysis_bratislava') ?></a>
        <a href="https://www.impax.sk/dialyzacne-strediska/" class="pill-link" target="_blank" rel="noopener noreferrer"><i class="fa-solid fa-hospital" aria-hidden="true"></i> <?= te('home.link_impax_centres') ?></a>
        <a href="https://books.polascin.net/" class="pill-link" target="_blank" rel="noopener noreferrer"><i class="fa-solid fa-book-open" aria-hidden="true"></i> books.polascin.net</a>
        <a href="https://alphagrab.de/" class="pill-link" target="_blank" rel="noopener noreferrer"><i class="fa-solid fa-ticket" aria-hidden="true"></i> AlphaGrab</a>
        <a href="https://arenibus.polascin.net/" class="pill-link" target="_blank" rel="noopener noreferrer"><i class="fa-solid fa-laptop-medical" aria-hidden="true"></i> Arenibus</a>
        <a href="https://www.amazon.com/stores/Walter-Kyo-Csoelle/author/B0G2TCCJZZ" class="pill-link" target="_blank" rel="noopener noreferrer"><i class="fa-solid fa-feather-pointed" aria-hidden="true"></i> Walter Kyo Csoelle (Amazon)</a>
        <a href="https://amzn.to/45y4INd" class="pill-link" target="_blank" rel="noopener noreferrer"><i class="fa-solid fa-book" aria-hidden="true"></i> <?= te('home.link_vital_2nd') ?></a>
        <a href="https://amzn.to/4t4mBNs" class="pill-link" target="_blank" rel="noopener noreferrer"><i class="fa-solid fa-book" aria-hidden="true"></i> <?= te('home.link_vital_1st') ?></a>
        <a href="https://amzn.to/4pYuL7D" class="pill-link" target="_blank" rel="noopener noreferrer"><i class="fa-solid fa-book" aria-hidden="true"></i> Blood Equity (Amazon)</a>
        <a href="https://amzn.to/3NJurvZ" class="pill-link" target="_blank" rel="noopener noreferrer"><i class="fa-solid fa-book" aria-hidden="true"></i> Pulse Of The Body (Amazon)</a>
        <a href="https://time.is/" class="pill-link" target="_blank" rel="noopener noreferrer"><i class="fa-solid fa-clock" aria-hidden="true"></i> Time.is</a>
        <a href="https://pr.tn/ref/63X184P7" class="pill-link pill-link--proton" target="_blank" rel="noopener noreferrer"><i class="fa-solid fa-envelope" aria-hidden="true"></i> Proton Mail</a>
      </div>
    </div>
  </section>

  <section id="contact">
    <div class="container">
      <h2 class="section-title reveal"><?= te('home.contact_heading') ?></h2>
      <p><?= htmlspecialchars($contactIntro, ENT_QUOTES, 'UTF-8') ?></p>
      <a href="mailto:lubomir@polascin.net" class="btn btn-primary btn-contact"><i class="fa-solid fa-envelope" aria-hidden="true"></i> lubomir@polascin.net</a>
      <p class="center-link"><a href="<?= htmlspecialchars(langUrl($lang, 'contact.php'), ENT_QUOTES, 'UTF-8') ?>" class="btn btn-secondary"><?= te('home.contact_cta') ?></a></p>
    </div>
  </section>
</main>

<?php include __DIR__ . '/footer.php'; ?>
</body>
</html>
