<?php

declare(strict_types=1);

require_once __DIR__ . '/auth.php';

$baseUrl = getAppBaseUrl();
$pageTitle = 'Terms of Service | Dr. Lubomir Polascin';
$seoDescription = 'Terms of Service for Dr. Lubomir Polascin\'s website.';
$robotsMeta = 'noindex, follow';
$canonicalUrl = $baseUrl . '/terms.php';
?>
<!DOCTYPE html>
<html lang="en">
<head>
<?php include __DIR__ . '/head_meta.php'; ?>
</head>
<body>
<?php include __DIR__ . '/header.php'; ?>
<main id="main-content" class="page-content" tabindex="-1" aria-label="Terms of service content">
  <div class="container">
    <h1 class="section-title">Terms of Service</h1>
    <p><strong>Last Updated: January 30, 2026</strong></p>

    <h3>1. Acceptance of Terms</h3>
    <p>By accessing and using <strong>polascin.net</strong> ("Website"), you accept and agree to be bound by the terms and provisions of this agreement.</p>

    <h3>2. Medical Disclaimer</h3>
    <div class="medical-disclaimer">
      <p><strong>IMPORTANT:</strong> The content provided on this website is for informational purposes only. It is <strong>not</strong> intended to be a substitute for professional medical advice, diagnosis, or treatment.</p>
      <p>Always seek the advice of your physician or other qualified health provider with any questions you may have regarding a medical condition. Never disregard professional medical advice or delay in seeking it because of something you have read on this website.</p>
    </div>

    <h3>3. Intellectual Property</h3>
    <p>The content, organization, graphics, design, compilation, and other matters related to the Site are protected under applicable copyrights and intellectual property laws. The copying, redistribution, use, or publication by you of any such matters or any part of the Site is strictly prohibited.</p>

    <h3>4. Limitation of Liability</h3>
    <p>In no event will I be liable for any incidental, indirect, consequential, or special damages of any kind, or any damages whatsoever, including, without limitation, those resulting from loss of profit, loss of contracts, goodwill, data, information, income, anticipated savings or business relationships, whether or not advised of the possibility of such damage, arising out of or in connection with the use of this website or any linked websites.</p>

    <h3>5. Governing Law</h3>
    <p>These terms and conditions are governed by and construed in accordance with the laws of Slovakia and you irrevocably submit to the exclusive jurisdiction of the courts in that location.</p>
  </div>
</main>
<?php include __DIR__ . '/footer.php'; ?>
</body>
</html>
