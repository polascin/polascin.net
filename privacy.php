<?php

declare(strict_types=1);

$envFiles = [
    __DIR__ . '/env.ini',
    __DIR__ . '/private/env.ini',
    __DIR__ . '/private/polascin.env.ini',
    dirname(__DIR__) . '/polascin.env.ini',
    dirname(__DIR__) . '/private/polascin.env.ini',
];
$envReady = getenv('POLASCIN_ENV_PATH') !== false;
foreach ($envFiles as $envFile) {
    if (file_exists($envFile)) {
        $envReady = true;
        break;
    }
}

if (!$envReady) {
    readfile(__DIR__ . '/privacy.html');
    exit;
}

require_once __DIR__ . '/auth.php';

$baseUrl = getAppBaseUrl();
$pageTitle = 'Privacy Policy | Dr. Lubomir Polascin';
$seoDescription = 'Privacy Policy for Dr. Lubomir Polascin\'s website.';
$robotsMeta = 'noindex, follow';
$canonicalUrl = $baseUrl . '/privacy.php';
?>
<!DOCTYPE html>
<html lang="en">
<head>
<?php include __DIR__ . '/head_meta.php'; ?>
</head>
<body>
<?php include __DIR__ . '/header.php'; ?>
<main id="main-content" class="page-content" tabindex="-1" aria-label="Privacy policy content">
  <div class="container">
    <h1 class="section-title">Privacy Policy</h1>
    <p><strong>Last Updated: July 28, 2026</strong></p>

    <h3>1. Introduction</h3>
    <p>Welcome to <strong>polascin.net</strong>. I respect your privacy and am committed to protecting your personal data. This privacy policy explains how I handle your personal data when you visit this website, and outlines your privacy rights and the applicable legal protections.</p>

    <h3>2. Information I Collect</h3>
    <p>This website is primarily informational. I do not require you to create an account.</p>
    <ul>
      <li><strong>Technical Data:</strong> Includes internet protocol (IP) address, browser type and version, time zone setting, operating system and platform. This data is collected automatically via server logs for security and performance purposes.</li>
      <li><strong>Cookies:</strong> I use minimal local storage to remember your theme preference (Dark/Light mode).
        <strong>Google Analytics 4 (GA4):</strong> I use Google Analytics to analyze website traffic and user behavior. I implement <strong>Google Consent Mode v2</strong> to respect your privacy preferences. By default, all tracking consent is set to <strong>'denied'</strong>. Scripts may load to ensure basic site functionality, but they will not store cookies or access personal data for tracking purposes unless you explicitly click Accept on the consent banner. You can manage your preferences at any time.</li>
    </ul>

    <h3>3. How I Use Your Information</h3>
    <p>I use your data to:</p>
    <ul>
      <li>Deliver the website content to you.</li>
      <li>Ensure the security of the website.</li>
      <li>Remember your preferences (e.g., theme).</li>
      <li>Analyze website traffic and usage patterns via Google Analytics 4, but only if you click <strong>Accept</strong> on the cookie consent banner. Legal basis: your consent (GDPR Art. 6(1)(a)). Analytics data is retained by Google according to its own retention settings (typically up to 14 months). You can withdraw consent at any time via the <strong>Cookie Settings</strong> button in the footer and choosing <strong>Decline</strong>.</li>
    </ul>

    <h3>4. Third-Party Links</h3>
    <p>This website may include links to third-party websites, plug-ins, and applications (e.g., Amazon, Social Media). Clicking on those links may allow third parties to collect or share data about you. I do not control these third-party websites and am not responsible for their privacy statements.</p>

    <h3>5. Your Legal Rights (GDPR/CCPA)</h3>
    <p>Under certain circumstances, you have rights under data protection laws in relation to your personal data, including the right to request access, correction, erasure, or restriction of processing of your personal data.</p>

    <h3>6. Contact</h3>
    <p>If you have any questions about this privacy policy, please contact me at: <a href="mailto:lubomir@polascin.net">lubomir@polascin.net</a>.</p>
  </div>
</main>
<?php include __DIR__ . '/footer.php'; ?>
</body>
</html>
