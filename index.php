<?php

declare(strict_types=1);

require_once __DIR__ . '/auth.php';
require_once __DIR__ . '/db_config.php';
require_once __DIR__ . '/helpers.php';

/** @var PDO $pdo */

$baseUrl = getAppBaseUrl();
$siteName = 'Polascin.net';

$heroTitle = getContentBlock($pdo, 'hero_title', 'Advancing Kidney Health');
$heroSubtitle = getContentBlock($pdo, 'hero_subtitle', 'Dr. Lubomir Polascin — dedicated to excellence in nephrology, dialysis, patient care and medical technology.');
$aboutIntro = getContentBlock($pdo, 'about_intro', "Hi, I'm Lubomir Polascin — a Medical Doctor, Nephrologist, and Internal Medicine Specialist by profession, a Fiction and Non-Fiction Writer by calling, and a Self-Taught Programmer by passion.");
$aboutWho = getContentBlock($pdo, 'about_who', 'My work rests at the intersection of medicine, storytelling, and technology.');
$contactIntro = getContentBlock($pdo, 'contact_intro', 'Feel free to reach out for inquiries or collaboration.');

$latestArticles = getPublishedArticles($pdo, 3);

$structuredData = [
    '@context' => 'https://schema.org',
    '@type' => 'Person',
    'name' => 'Dr. Lubomir Polascin',
    'url' => $baseUrl . '/',
    'image' => $baseUrl . '/images/profile.jpg',
    'jobTitle' => 'Nephrologist and Internal Medicine Specialist',
    'description' => 'Dr. Lubomir Polascin — nephrologist, internal medicine specialist, medical translator, writer and self-taught programmer.',
    'alumniOf' => 'University of Pavol Jozef Šafárik',
    'sameAs' => [
        'https://polascin.com/',
        'https://polascin.sk/',
        'https://polascin.org/',
        'https://books.polascin.net/',
        'https://nefro.polascin.net/',
        'https://nephrosite.polascin.net/',
        'https://www.amazon.com/stores/author/B07PN436VJ/about',
        'https://www.linkedin.com/in/lubomirpolascin/',
        'https://x.com/polascin',
    ],
];

$pageTitle = 'Home | Dr. Lubomir Polascin';
$seoDescription = 'Dr. Lubomir Polascin — nephrologist, internal medicine specialist, medical translator, writer and self-taught programmer.';
?>
<!DOCTYPE html>
<html lang="en">
<head>
<?php include __DIR__ . '/head_meta.php'; ?>
</head>
<body>
<?php include __DIR__ . '/header.php'; ?>

<main id="main-content" tabindex="-1" aria-label="Main content">
  <section id="home" class="hero">
    <div class="container">
      <div class="hero-content">
        <img src="CrystalKidney.png" alt="Crystal Kidney logo" class="profile-img" loading="eager">
        <h1 class="hero-title"><?= htmlspecialchars($heroTitle, ENT_QUOTES, 'UTF-8') ?></h1>
        <p class="hero-subtitle"><?= htmlspecialchars($heroSubtitle, ENT_QUOTES, 'UTF-8') ?></p>
        <div class="hero-buttons">
          <a href="#about" class="btn btn-primary">About Me</a>
          <a href="articles.php" class="btn btn-secondary">Latest Articles</a>
        </div>
      </div>
    </div>
  </section>

  <section id="about" class="about">
    <div class="container">
      <h2 class="section-title reveal">About Dr. Lubomir Polascin</h2>
      <div class="about-grid">
        <div class="about-text">
          <p><?= nl2br(htmlspecialchars($aboutIntro, ENT_QUOTES, 'UTF-8'), false) ?></p>
          <p><?= nl2br(htmlspecialchars($aboutWho, ENT_QUOTES, 'UTF-8'), false) ?></p>
          <h3>Professional Identity</h3>
          <ul>
            <li>Medical Doctor (MD)</li>
            <li>Nephrologist</li>
            <li>Internal Medicine Specialist</li>
            <li>Medical Translator</li>
            <li>Fiction and Non-Fiction Writer</li>
            <li>Self-Taught Programmer</li>
          </ul>
          <h3>Technical Skills</h3>
          <ul>
            <li>HTML5 &amp; CSS3</li>
            <li>JavaScript / TypeScript</li>
            <li>PHP &amp; SQL</li>
            <li>Python</li>
            <li>Linux / Unix</li>
            <li>AI &amp; FOSS</li>
          </ul>
          <h3>Background &amp; Journey</h3>
          <p>I began my medical education at the University of Pavol Jozef Šafárik in Košice, Slovakia. Since 1995, my focus has been on dialysis and nephrology. From 2013 to 2022, I served as Chief Medical Officer / Head Physician at two dialysis centers in Bratislava.</p>
          <h3>Personal Touch</h3>
          <p>Born in 1971 in Czechoslovakia, I was raised in Kyjov. My Ruthenian roots inform my worldview. My passions include reading, travel, philosophy, and poetry.</p>
          <a href="https://www.amazon.com/stores/author/B07PN436VJ/about" target="_blank" rel="noopener noreferrer" class="btn btn-primary btn-sm">View on Amazon Author Central</a>
        </div>
      </div>
    </div>
  </section>

  <section id="nephrology" class="nephrology">
    <div class="container">
      <h2 class="section-title reveal">Nephrology</h2>
      <p class="section-intro">Nephrology is an essential medical specialty dealing with the kidneys, vital organs responsible for fluid balance, waste filtration, and blood pressure regulation.</p>
      <div class="card-grid">
        <article class="card reveal"><div class="card-icon"><i class="fa-solid fa-stethoscope" aria-hidden="true"></i></div><h3>Chronic Kidney Disease (CKD)</h3><p>Management of progressive loss of kidney function over time due to diabetes, hypertension, or other factors.</p></article>
        <article class="card reveal"><div class="card-icon"><i class="fa-solid fa-bolt-lightning" aria-hidden="true"></i></div><h3>Acute Kidney Injury (AKI)</h3><p>Treatment of sudden, often temporary, loss of kidney function caused by infections, dehydration, or toxins.</p></article>
        <article class="card reveal"><div class="card-icon"><i class="fa-solid fa-droplet" aria-hidden="true"></i></div><h3>Hemodialysis</h3><p>A procedure where a dialysis machine and a special filter called an artificial kidney are used to clean your blood.</p></article>
        <article class="card reveal"><div class="card-icon"><i class="fa-solid fa-house-medical" aria-hidden="true"></i></div><h3>Peritoneal Dialysis</h3><p>A treatment that uses the lining of your abdomen and a cleaning solution called dialysate to clean your blood.</p></article>
        <article class="card reveal"><div class="card-icon"><i class="fa-solid fa-hand-holding-medical" aria-hidden="true"></i></div><h3>Transplantation</h3><p>The best treatment for kidney failure. A healthy kidney is placed into your body to do the work your own kidneys can no longer do.</p></article>
        <article class="card reveal"><div class="card-icon"><i class="fa-solid fa-magnifying-glass" aria-hidden="true"></i></div><h3>Diagnostics</h3><p>Utilizing ultrasound, kidney biopsy, and advanced lab tests to accurately diagnose renal conditions.</p></article>
      </div>
    </div>
  </section>

  <?php if (!empty($latestArticles)): ?>
  <section id="latest-articles" class="latest-articles">
    <div class="container">
      <h2 class="section-title reveal">Latest Articles</h2>
      <div class="card-grid">
        <?php foreach ($latestArticles as $article): ?>
        <article class="card reveal">
          <h3><a href="article.php?slug=<?= htmlspecialchars(rawurlencode((string) $article['slug']), ENT_QUOTES, 'UTF-8') ?>"><?= htmlspecialchars((string) $article['title'], ENT_QUOTES, 'UTF-8') ?></a></h3>
          <p class="article-meta"><?= htmlspecialchars(formatArticleDate($article['published_at'] ?? null), ENT_QUOTES, 'UTF-8') ?></p>
          <p><?= htmlspecialchars(buildSeoExcerpt((string) ($article['excerpt'] ?? '')), ENT_QUOTES, 'UTF-8') ?></p>
        </article>
        <?php endforeach; ?>
      </div>
      <p class="center-link"><a href="articles.php" class="btn btn-secondary">View all articles</a></p>
    </div>
  </section>
  <?php endif; ?>

  <section id="projects" class="projects-section">
    <div class="container">
      <h2 class="section-title reveal">Projects &amp; Network</h2>
      <p class="section-intro">A selection of websites, tools and resources I build or curate across medicine, education and technology.</p>
      <div class="card-grid">
        <article class="card project-card"><div class="card-icon"><i class="fa-solid fa-microscope" aria-hidden="true"></i></div><h3>Nefro-projekt Slovensko</h3><p>Slovak nephrology portal with clinical articles, dialysis and transplant updates, calculators, drug references and study notes.</p><a href="https://nefro.polascin.net/" target="_blank" rel="noopener noreferrer" class="btn btn-secondary btn-sm">Visit nefro.polascin.net</a></article>
        <article class="card project-card"><div class="card-icon"><i class="fa-solid fa-hospital-user" aria-hidden="true"></i></div><h3>NephroSite</h3><p>Educational lectures and reference pages on nephrology, dialysis, blood purification methods and internal medicine (in Slovak).</p><a href="https://nephrosite.polascin.net/" target="_blank" rel="noopener noreferrer" class="btn btn-secondary btn-sm">Visit nephrosite.polascin.net</a></article>
        <article class="card project-card"><div class="card-icon"><i class="fa-solid fa-book-open" aria-hidden="true"></i></div><h3>Bibliotheca Polascini</h3><p>Central archive for books, academic publications, chapters and literary work by Dr. Lubomir Polascin.</p><a href="https://books.polascin.net/" target="_blank" rel="noopener noreferrer" class="btn btn-secondary btn-sm">Visit books.polascin.net</a></article>
        <article class="card project-card"><div class="card-icon"><i class="fa-solid fa-ticket" aria-hidden="true"></i></div><h3>AlphaGrab</h3><p>Experimental ticketing-discovery project that enriches fallback links via the Ticketmaster Discovery API.</p><a href="https://alphagrab.de/" target="_blank" rel="noopener noreferrer" class="btn btn-secondary btn-sm">Visit alphagrab.de</a></article>
        <article class="card project-card"><div class="card-icon"><i class="fa-solid fa-bus" aria-hidden="true"></i></div><h3>Arenibus Demo</h3><p>Public demo instance for an event and transport-related web project.</p><a href="https://demo.arenibus.com/" target="_blank" rel="noopener noreferrer" class="btn btn-secondary btn-sm">Visit demo.arenibus.com</a></article>
      </div>
    </div>
  </section>

  <section id="links" class="links-section">
    <div class="container">
      <h2 class="section-title reveal">Network &amp; Resources</h2>
      <p class="section-muted">Explore other related sites and resources.</p>
      <div class="link-grid">
        <a href="https://polascin.com/" class="pill-link" target="_blank" rel="noopener noreferrer"><i class="fa-solid fa-staff-snake" aria-hidden="true"></i> polascin.com</a>
        <a href="https://polascin.sk/" class="pill-link" target="_blank" rel="noopener noreferrer"><i class="fa-solid fa-globe" aria-hidden="true"></i> polascin.sk</a>
        <a href="https://polascin.org/" class="pill-link" target="_blank" rel="noopener noreferrer"><i class="fa-solid fa-building" aria-hidden="true"></i> polascin.org</a>
        <a href="https://nephrosite.polascin.net/" class="pill-link" target="_blank" rel="noopener noreferrer"><i class="fa-solid fa-hospital-user" aria-hidden="true"></i> NephroSite (in Slovak)</a>
        <a href="https://nefro.polascin.net/" class="pill-link" target="_blank" rel="noopener noreferrer"><i class="fa-solid fa-microscope" aria-hidden="true"></i> Nefro-projekt Slovensko</a>
        <a href="https://books.polascin.net/" class="pill-link" target="_blank" rel="noopener noreferrer"><i class="fa-solid fa-book-open" aria-hidden="true"></i> books.polascin.net</a>
        <a href="https://alphagrab.de/" class="pill-link" target="_blank" rel="noopener noreferrer"><i class="fa-solid fa-ticket" aria-hidden="true"></i> AlphaGrab</a>
        <a href="https://demo.arenibus.com/" class="pill-link" target="_blank" rel="noopener noreferrer"><i class="fa-solid fa-bus" aria-hidden="true"></i> Arenibus Demo</a>
        <a href="https://amzn.to/45y4INd" class="pill-link" target="_blank" rel="noopener noreferrer"><i class="fa-solid fa-book" aria-hidden="true"></i> Vital Algorithm - 2nd ed. (Amazon)</a>
        <a href="https://amzn.to/4t4mBNs" class="pill-link" target="_blank" rel="noopener noreferrer"><i class="fa-solid fa-book" aria-hidden="true"></i> The Vital Algorithm - 1st ed. (Amazon)</a>
        <a href="https://amzn.to/4pYuL7D" class="pill-link" target="_blank" rel="noopener noreferrer"><i class="fa-solid fa-book" aria-hidden="true"></i> Blood Equity (Amazon)</a>
        <a href="https://amzn.to/3NJurvZ" class="pill-link" target="_blank" rel="noopener noreferrer"><i class="fa-solid fa-book" aria-hidden="true"></i> Pulse Of The Body (Amazon)</a>
        <a href="https://time.is/" class="pill-link" target="_blank" rel="noopener noreferrer"><i class="fa-solid fa-clock" aria-hidden="true"></i> Time.is</a>
        <a href="https://pr.tn/ref/63X184P7" class="pill-link pill-link--proton" target="_blank" rel="noopener noreferrer"><i class="fa-solid fa-envelope" aria-hidden="true"></i> Proton Mail</a>
      </div>
    </div>
  </section>

  <section id="contact">
    <div class="container">
      <h2 class="section-title reveal">Contact</h2>
      <p><?= htmlspecialchars($contactIntro, ENT_QUOTES, 'UTF-8') ?></p>
      <a href="mailto:lubomir@polascin.net" class="btn btn-primary btn-contact"><i class="fa-solid fa-envelope" aria-hidden="true"></i> lubomir@polascin.net</a>
      <p class="center-link"><a href="contact.php" class="btn btn-secondary">Send a message</a></p>
    </div>
  </section>
</main>

<?php include __DIR__ . '/footer.php'; ?>
</body>
</html>
