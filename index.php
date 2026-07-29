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

$heroTitle = getContentBlock($pdo, 'hero_title', 'Pokrok v zdraví obličiek');
$heroSubtitle = getContentBlock($pdo, 'hero_subtitle', 'MUDr. Ľubomír Polaščín — venovaný excelentnosti v nefrológii, dialýze, starostlivosti o pacientov a medicínskych technológiách.');
$aboutIntro = getContentBlock($pdo, 'about_intro', "Volám sa Ľubomír Polaščín — som lekár, nefrológ a internista povolaním, spisovateľ beletrie a literatúry faktu poslaním a samouk programátor z vášne.");
$aboutWho = getContentBlock($pdo, 'about_who', 'Moja práca spočíva na priesečníku medicíny, rozprávania príbehov a technológií. Medicína cibrí moju klinickú presnosť; písanie mi umožňuje skúmať ľudský údel cez beletriu a literatúru faktu; a technológie ma posúvajú pri riešení zložitých problémov.');
$contactIntro = getContentBlock($pdo, 'contact_intro', 'Neváhajte ma kontaktovať s otázkami alebo ohľadom spolupráce.');

$latestArticles = getPublishedArticles($pdo, 3);

$structuredData = [
    '@context' => 'https://schema.org',
    '@type' => 'Person',
    'name' => 'MUDr. Ľubomír Polaščín',
    'alternateName' => 'Lubomir Polascin',
    'url' => $baseUrl . '/',
    'image' => $baseUrl . '/images/profile.jpg',
    'jobTitle' => 'Nefrológ a internista',
    'description' => 'MUDr. Ľubomír Polaščín — nefrológ, internista, lekársky prekladateľ, spisovateľ a samouk programátor.',
    'alumniOf' => 'Univerzita Pavla Jozefa Šafárika v Košiciach',
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
        'https://www.facebook.com/lubomir.polascin',
        'https://www.patreon.com/c/Csoelle',
        'https://discord.gg/MsGmMZbz',
        'https://github.com/polascin',
    ],
];

$pageTitle = 'Domov | MUDr. Ľubomír Polaščín';
$seoDescription = 'MUDr. Ľubomír Polaščín — nefrológ, internista, lekársky prekladateľ, spisovateľ a samouk programátor.';
$canonicalUrl = rtrim($baseUrl, '/') . '/';
?>
<!DOCTYPE html>
<html lang="sk">
<head>
<?php include __DIR__ . '/head_meta.php'; ?>
</head>
<body>
<?php include __DIR__ . '/header.php'; ?>

<main id="main-content" tabindex="-1" aria-label="Hlavný obsah">
  <section id="home" class="hero">
    <div class="container">
      <div class="hero-content">
        <img src="CrystalKidney.png" alt="Logo Crystal Kidney" class="profile-img" loading="eager">
        <h1 class="hero-title"><?= htmlspecialchars($heroTitle, ENT_QUOTES, 'UTF-8') ?></h1>
        <p class="hero-subtitle"><?= htmlspecialchars($heroSubtitle, ENT_QUOTES, 'UTF-8') ?></p>
        <div class="hero-buttons">
          <a href="#about" class="btn btn-primary">O mne</a>
          <a href="articles.php" class="btn btn-secondary">Najnovšie články</a>
        </div>
      </div>
    </div>
  </section>

  <section id="about" class="about">
    <div class="container">
      <h2 class="section-title reveal">O MUDr. Ľubomírovi Polaščínovi</h2>
      <div class="about-grid">
        <div class="about-text">
          <p><?= nl2br(htmlspecialchars($aboutIntro, ENT_QUOTES, 'UTF-8'), false) ?></p>
          <p><?= nl2br(htmlspecialchars($aboutWho, ENT_QUOTES, 'UTF-8'), false) ?></p>
          <h3>Profesionálna identita</h3>
          <ul>
            <li>Lekár (MUDr.)</li>
            <li>Nefrológ</li>
            <li>Internista</li>
            <li>Lekársky prekladateľ</li>
            <li>Spisovateľ beletrie a literatúry faktu</li>
            <li>Samouk programátor</li>
          </ul>
          <h3>Technické zručnosti</h3>
          <ul>
            <li>HTML5 &amp; CSS3</li>
            <li>JavaScript / TypeScript</li>
            <li>PHP &amp; SQL</li>
            <li>Python</li>
            <li>Linux / Unix</li>
            <li>AI &amp; FOSS</li>
          </ul>
          <h3>Vzdelanie a&nbsp;kariéra</h3>
          <p>Svoje lekárske vzdelanie som začal na Univerzite Pavla Jozefa Šafárika v Košiciach. Od roku 1995 sa zameriavam na dialýzu a nefrológiu. V rokoch 2013 až 2022 som pôsobil ako primár na dvoch dialyzačných strediskách v Bratislave.</p>
          <h3>Osobné</h3>
          <p>Narodený v roku 1971 v Československu, vyrastal som v Kyjove. Moje rusínske korene formujú môj pohľad na svet. Mojimi záľubami sú čítanie, cestovanie, filozofia a poézia.</p>
          <a href="https://www.amazon.com/stores/author/B07PN436VJ/about" target="_blank" rel="noopener noreferrer" class="btn btn-primary btn-sm">Zobraziť na Amazon Author Central</a>
        </div>
      </div>
    </div>
  </section>

  <section id="nephrology" class="nephrology">
    <div class="container">
      <h2 class="section-title reveal">Nefrológia</h2>
      <p class="section-intro">Nefrológia je kľúčový lekársky odbor zaoberajúci sa obličkami — životne dôležitými orgánmi zodpovednými za rovnováhu tekutín, filtráciu odpadových látok a reguláciu krvného tlaku.</p>
      <div class="card-grid">
        <article class="card reveal"><div class="card-icon"><i class="fa-solid fa-stethoscope" aria-hidden="true"></i></div><h3>Chronické ochorenie obličiek (CKD)</h3><p>Manažment postupnej straty funkcie obličiek v čase spôsobenej cukrovkou, hypertenziou alebo inými faktormi.</p></article>
        <article class="card reveal"><div class="card-icon"><i class="fa-solid fa-bolt-lightning" aria-hidden="true"></i></div><h3>Akútne poškodenie obličiek (AKI)</h3><p>Liečba náhleho, často dočasného zlyhania funkcie obličiek spôsobeného infekciami, dehydratáciou alebo toxínmi.</p></article>
        <article class="card reveal"><div class="card-icon"><i class="fa-solid fa-droplet" aria-hidden="true"></i></div><h3>Hemodialýza</h3><p>Procedúra, pri ktorej sa dialyzačný prístroj a špeciálny filter nazývaný umelá oblička používajú na čistenie krvi.</p></article>
        <article class="card reveal"><div class="card-icon"><i class="fa-solid fa-house-medical" aria-hidden="true"></i></div><h3>Peritoneálna dialýza</h3><p>Liečba, ktorá využíva výstelku brušnej dutiny a čistiaci roztok nazývaný dialyzát na čistenie krvi.</p></article>
        <article class="card reveal"><div class="card-icon"><i class="fa-solid fa-hand-holding-medical" aria-hidden="true"></i></div><h3>Transplantácia</h3><p>Najlepšia liečba zlyhania obličiek. Zdravá oblička sa umiestni do tela, aby vykonala prácu, ktorú vlastné obličky už nedokážu zvládnuť.</p></article>
        <article class="card reveal"><div class="card-icon"><i class="fa-solid fa-magnifying-glass" aria-hidden="true"></i></div><h3>Diagnostika</h3><p>Využívanie ultrazvuku, biopsie obličiek a pokročilých laboratórnych testov na presnú diagnostiku obličkových ochorení.</p></article>
      </div>
    </div>
  </section>

  <?php if (!empty($latestArticles)): ?>
  <section id="latest-articles" class="latest-articles">
    <div class="container">
      <h2 class="section-title reveal">Najnovšie články</h2>
      <div class="card-grid">
        <?php foreach ($latestArticles as $article): ?>
        <article class="card reveal">
          <h3><a href="article.php?slug=<?= htmlspecialchars(rawurlencode((string) $article['slug']), ENT_QUOTES, 'UTF-8') ?>"><?= htmlspecialchars((string) $article['title'], ENT_QUOTES, 'UTF-8') ?></a></h3>
          <p class="article-meta"><?= htmlspecialchars(formatArticleDate($article['published_at'] ?? null), ENT_QUOTES, 'UTF-8') ?></p>
          <p><?= htmlspecialchars(buildSeoExcerpt((string) ($article['excerpt'] ?? '')), ENT_QUOTES, 'UTF-8') ?></p>
        </article>
        <?php endforeach; ?>
      </div>
      <p class="center-link"><a href="articles.php" class="btn btn-secondary">Zobraziť všetky články</a></p>
    </div>
  </section>
  <?php endif; ?>

  <section id="projects" class="projects-section">
    <div class="container">
      <h2 class="section-title reveal">Projekty a&nbsp;sieť</h2>
      <p class="section-intro">Výber webových stránok, nástrojov a zdrojov, ktoré budujem alebo spravujem v oblasti medicíny, vzdelávania a technológií.</p>
      <div class="card-grid">
        <article class="card project-card"><div class="card-icon"><i class="fa-solid fa-microscope" aria-hidden="true"></i></div><h3>Nefro-projekt Slovensko</h3><p>Slovenský nefrologický portál s klinickými článkami, aktualitami o dialýze a transplantáciách, kalkulačkami, referenciami liekov a študijnými poznámkami.</p><a href="https://nefro.polascin.net/" target="_blank" rel="noopener noreferrer" class="btn btn-secondary btn-sm">Navštíviť nefro.polascin.net</a></article>
        <article class="card project-card"><div class="card-icon"><i class="fa-solid fa-hospital-user" aria-hidden="true"></i></div><h3>NephroSite</h3><p>Vzdelávacie prednášky a referenčné stránky o nefrológii, dialýze, metódach očisťovania krvi a internom lekárstve (v slovenčine).</p><a href="https://nephrosite.polascin.net/" target="_blank" rel="noopener noreferrer" class="btn btn-secondary btn-sm">Navštíviť nephrosite.polascin.net</a></article>
        <article class="card project-card"><div class="card-icon"><i class="fa-solid fa-book-open" aria-hidden="true"></i></div><h3>Bibliotheca Polascini</h3><p>Centrálny archív kníh, akademických publikácií, kapitol a literárnych diel MUDr. Ľubomíra Polaščína.</p><a href="https://books.polascin.net/" target="_blank" rel="noopener noreferrer" class="btn btn-secondary btn-sm">Navštíviť books.polascin.net</a></article>
        <article class="card project-card"><div class="card-icon"><i class="fa-solid fa-ticket" aria-hidden="true"></i></div><h3>AlphaGrab</h3><p>Experimentálny projekt na objavovanie lístkov, ktorý obohacuje záložné odkazy cez Ticketmaster Discovery API.</p><a href="https://alphagrab.de/" target="_blank" rel="noopener noreferrer" class="btn btn-secondary btn-sm">Navštíviť alphagrab.de</a></article>
        <article class="card project-card"><div class="card-icon"><i class="fa-solid fa-bus" aria-hidden="true"></i></div><h3>Arenibus Demo</h3><p>Verejná demo inštancia pre webový projekt o udalostiach a doprave.</p><a href="https://demo.arenibus.com/" target="_blank" rel="noopener noreferrer" class="btn btn-secondary btn-sm">Navštíviť demo.arenibus.com</a></article>
      </div>
    </div>
  </section>

  <section id="links" class="links-section">
    <div class="container">
      <h2 class="section-title reveal">Sieť a&nbsp;zdroje</h2>
      <p class="section-muted">Preskúmajte ďalšie súvisiace stránky a zdroje.</p>
      <div class="link-grid">
        <a href="https://polascin.com/" class="pill-link" target="_blank" rel="noopener noreferrer"><i class="fa-solid fa-staff-snake" aria-hidden="true"></i> polascin.com</a>
        <a href="https://polascin.sk/" class="pill-link" target="_blank" rel="noopener noreferrer"><i class="fa-solid fa-globe" aria-hidden="true"></i> polascin.sk</a>
        <a href="https://polascin.org/" class="pill-link" target="_blank" rel="noopener noreferrer"><i class="fa-solid fa-building" aria-hidden="true"></i> polascin.org</a>
        <a href="https://nephrosite.polascin.net/" class="pill-link" target="_blank" rel="noopener noreferrer"><i class="fa-solid fa-hospital-user" aria-hidden="true"></i> NephroSite (v slovenčine)</a>
        <a href="https://nefro.polascin.net/" class="pill-link" target="_blank" rel="noopener noreferrer"><i class="fa-solid fa-microscope" aria-hidden="true"></i> Nefro-projekt Slovensko</a>
        <a href="https://books.polascin.net/" class="pill-link" target="_blank" rel="noopener noreferrer"><i class="fa-solid fa-book-open" aria-hidden="true"></i> books.polascin.net</a>
        <a href="https://alphagrab.de/" class="pill-link" target="_blank" rel="noopener noreferrer"><i class="fa-solid fa-ticket" aria-hidden="true"></i> AlphaGrab</a>
        <a href="https://demo.arenibus.com/" class="pill-link" target="_blank" rel="noopener noreferrer"><i class="fa-solid fa-bus" aria-hidden="true"></i> Arenibus Demo</a>
        <a href="https://amzn.to/45y4INd" class="pill-link" target="_blank" rel="noopener noreferrer"><i class="fa-solid fa-book" aria-hidden="true"></i> Vital Algorithm — 2. vydanie (Amazon)</a>
        <a href="https://amzn.to/4t4mBNs" class="pill-link" target="_blank" rel="noopener noreferrer"><i class="fa-solid fa-book" aria-hidden="true"></i> The Vital Algorithm — 1. vydanie (Amazon)</a>
        <a href="https://amzn.to/4pYuL7D" class="pill-link" target="_blank" rel="noopener noreferrer"><i class="fa-solid fa-book" aria-hidden="true"></i> Blood Equity (Amazon)</a>
        <a href="https://amzn.to/3NJurvZ" class="pill-link" target="_blank" rel="noopener noreferrer"><i class="fa-solid fa-book" aria-hidden="true"></i> Pulse Of The Body (Amazon)</a>
        <a href="https://time.is/" class="pill-link" target="_blank" rel="noopener noreferrer"><i class="fa-solid fa-clock" aria-hidden="true"></i> Time.is</a>
        <a href="https://pr.tn/ref/63X184P7" class="pill-link pill-link--proton" target="_blank" rel="noopener noreferrer"><i class="fa-solid fa-envelope" aria-hidden="true"></i> Proton Mail</a>
      </div>
    </div>
  </section>

  <section id="contact">
    <div class="container">
      <h2 class="section-title reveal">Kontakt</h2>
      <p><?= htmlspecialchars($contactIntro, ENT_QUOTES, 'UTF-8') ?></p>
      <a href="mailto:lubomir@polascin.net" class="btn btn-primary btn-contact"><i class="fa-solid fa-envelope" aria-hidden="true"></i> lubomir@polascin.net</a>
      <p class="center-link"><a href="contact.php" class="btn btn-secondary">Poslať správu</a></p>
    </div>
  </section>
</main>

<?php include __DIR__ . '/footer.php'; ?>
</body>
</html>
