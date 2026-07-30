<?php

declare(strict_types=1);

$requestedScript = str_replace('\\', '/', (string) ($_SERVER['SCRIPT_NAME'] ?? $_SERVER['PHP_SELF'] ?? ''));
$executedFile = isset($_SERVER['SCRIPT_FILENAME']) ? realpath((string) $_SERVER['SCRIPT_FILENAME']) : false;
if (
    $executedFile === __FILE__
    || preg_match('~(?:^|/)lang/[a-z]{2}\.php(?:/|$)~i', $requestedScript) === 1
) {
    if (PHP_SAPI === 'cli') {
        fwrite(STDERR, "Chyba: katalóg prekladov je interný súbor a nemožno ho spúšťať priamo.\n");
        exit(1);
    }
    http_response_code(403);
    exit('Prístup odmietnutý.');
}
unset($requestedScript, $executedFile);

/**
 * English translation catalogue.
 *
 * Keys are stable identifiers, not texts. Placeholders are written as `:name`.
 * This file is derived from lang/sk.php; a key missing here falls back
 * to the Slovak source catalogue.
 */
return [
    // Language switcher
    'lang.switch' => 'Language',
    'lang.switch_aria' => 'Select page language',
    'lang.current' => 'Current language: :language',

    // Common interface elements
    'common.site_name' => 'Polascin.net',
    'common.author' => 'Ľubomír Polaščín, MD',
    'common.author_short' => 'Ľubomír Polaščín',
    'common.skip_to_content' => 'Skip to main content',
    'common.main_navigation' => 'Main navigation',
    'common.main_content' => 'Main content',
    'common.open_navigation' => 'Open navigation',
    'common.close_navigation' => 'Close navigation',
    'common.toggle_dark_mode' => 'Toggle dark mode',
    'common.switch_to_dark' => 'Switch to dark mode',
    'common.switch_to_light' => 'Switch to light mode',
    'common.age_title' => 'Current age',
    'common.required' => 'required',
    'common.back' => 'Back',
    'common.read_more' => 'Read more',
    'common.visit' => 'Visit :target',
    'common.opens_new_tab' => 'opens in a new tab',
    'common.author_meta_prefix' => 'Author',

    // Navigation
    'nav.home' => 'Home',
    'nav.blog' => 'Blog',
    'nav.about' => 'About me',
    'nav.nephrology' => 'Nephrology',
    'nav.projects' => 'Projects',
    'nav.books' => 'Books',
    'nav.links' => 'Links',
    'nav.contact' => 'Contact',
    'nav.admin' => 'Administration',
    'nav.logout' => 'Log out',
    'nav.login' => 'Log in',

    // Footer
    'footer.heading' => 'Contact and profiles',
    'footer.linkedin' => 'LinkedIn profile',
    'footer.x' => 'X profile',
    'footer.facebook' => 'Facebook profile',
    'footer.email' => 'Send an email',
    'footer.discord' => 'Join on Discord',
    'footer.copyright' => '© 1998 – :year Ľubomír Polaščín. All rights reserved.',
    'footer.privacy' => 'Privacy Policy',
    'footer.terms' => 'Terms of Use',
    'footer.cookie_settings' => 'Cookie settings',
    'footer.updated' => 'Updated:',
    'footer.beat_title' => 'Swiss Internet Time — 1 day = 1000 beats',

    // Page metadata
    'meta.default_description' => 'The personal and professional website of Ľubomír Polaščín, MD: nephrology and dialysis, medical education and writing, specialist translation, and practical digital tools.',
    'meta.home_tagline' => 'Nephrology, medical education and digital tools',
    'meta.articles_title' => 'Articles',
    'meta.articles_description' => 'Latest articles and insights by Ľubomír Polaščín, MD, on nephrology, internal medicine, technology and writing.',
    'meta.articles_404_title' => 'Articles page not found',
    'meta.articles_404_description' => 'The requested article listing page does not exist.',
    'meta.article_404_title' => 'Not found',
    'meta.article_404_description' => 'The article was not found.',
    'meta.contact_title' => 'Contact',
    'meta.contact_description' => 'Contact Ľubomír Polaščín, MD, with professional questions, proposals for collaboration or general inquiries.',
    'meta.newsletter_title' => 'Newsletter',
    'meta.newsletter_description' => 'Subscribe to updates from Polascin.net — news on nephrology, internal medicine, books and technology.',
    'meta.login_title' => 'Log in',
    'meta.login_description' => 'Administrator login for Polascin.net.',
    'meta.privacy_title' => 'Privacy Policy',
    'meta.privacy_description' => 'Privacy policy for the website of Ľubomír Polaščín, MD.',
    'meta.terms_title' => 'Terms of Use',
    'meta.terms_description' => 'Terms of use for the website of Ľubomír Polaščín, MD.',

    // Home page — hero
    'home.logo_alt' => 'Crystal Kidney',
    'home.hero_title' => 'Ľubomír Polaščín, MD',
    'home.hero_subtitle' => 'I am a nephrologist and internist, medical educator and author. I bring long experience in dialysis to specialist writing, translation and the development of practical digital tools.',
    'home.cta_about' => 'What I do',
    'home.cta_articles' => 'Read articles',

    // Home page — biography
    'home.about_heading' => 'About me',
    'home.about_intro' => 'I am a physician specialising in nephrology and internal medicine. My professional work has centred on dialysis and kidney disease; I have led two dialysis centres in Bratislava and worked in medical education.',
    'home.about_who' => 'I write professional and literary texts, translate medical content between Slovak and English, and build websites and applications. I judge technology and artificial intelligence by their practical value: whether they make knowledge more accessible, simplify work or improve the quality of the result.',
    'home.about_synthesis' => 'I take a similar approach in medicine, language and code: define the problem precisely, verify the facts that matter, acknowledge uncertainty and create a clear, usable result.',

    'home.areas_heading' => 'What I do',
    'home.areas_medicine' => 'Nephrology and education',
    'home.areas_medicine_1' => 'nephrology and dialysis',
    'home.areas_medicine_2' => 'internal medicine',
    'home.areas_medicine_3' => 'kidney replacement therapy',
    'home.areas_medicine_4' => 'ultrasonography and vascular access care',
    'home.areas_medicine_5' => 'specialist lectures and education',
    'home.areas_language' => 'Writing and translation',
    'home.areas_language_1' => 'specialist medical texts',
    'home.areas_language_2' => 'medical translation and terminology work',
    'home.areas_language_3' => 'localisation of medical software',
    'home.areas_language_4' => 'fiction, essays and non-fiction',
    'home.areas_language_5' => 'popularising medicine and patient education',
    'home.areas_tech' => 'Digital projects',
    'home.areas_tech_1' => 'building websites and applications',
    'home.areas_tech_2' => 'medical calculators and digital tools',
    'home.areas_tech_3' => 'automation of information processing',
    'home.areas_tech_4' => 'critical and practical use of artificial intelligence',
    'home.areas_tech_5' => 'open-source software and Linux/Unix systems',

    'home.skills_heading' => 'Tools and technology',
    'home.skills_web' => 'Web technologies',
    'home.skills_web_text' => 'HTML5, CSS3, JavaScript, TypeScript, PHP, React, Vue, Node.js',
    'home.skills_data' => 'Programming and data',
    'home.skills_data_text' => 'Python, C#, .NET, SQL, databases and data processing',
    'home.skills_systems' => 'Systems and infrastructure',
    'home.skills_systems_text' => 'Linux, Unix, Windows, macOS, iOS, iPadOS, Android, Docker, Git, free and open-source software',
    'home.skills_ai' => 'Artificial intelligence',
    'home.skills_ai_text' => 'language models, automation and critical evaluation of their use in medicine',

    'home.education_heading' => 'Education and career',
    'home.education_school' => 'I completed secondary school with a focus on programming in 1989 — in Basic and Pascal at the time — and also won a district programming competition.',
    'home.education_text' => 'I graduated in general medicine from Pavol Jozef Šafárik University in Košice in 1995. I qualified in internal medicine in 1998 and in nephrology in 2009, when I also received certification in abdominal ultrasonography in adults.',
    'home.education_path' => 'I have worked in dialysis and nephrology since 1995. I later led two dialysis centres in Bratislava and worked in medical education.',
    'home.education_scope' => 'My professional experience covers haemodialysis, haemodiafiltration, peritoneal dialysis, liver dialysis on the Prometheus system, acute extracorporeal blood purification, ultrasonography, vascular access care and the preparation of patients for kidney transplantation. I combine this experience with specialist writing, lectures, teaching and the development of digital medical projects.',

    'home.personal_heading' => 'Beyond medicine',
    'home.personal_text' => 'I am interested in literature, philosophy, poetry and travel. Languages are close to my heart — one reason this site is available in ten of them — and I spend my free time reading, translating and programming my own projects.',
    'home.personal_writing' => 'In my books and other writing I return to medicine, moral conflict and the relationship between people and technology. I publish specialist texts under my own name, while my literary work also appears under the pen name Walter Kyo Csoelle — whose author profile is available on Amazon.',

    'home.identity_nephrologist' => 'Nephrologist',
    'home.identity_internist' => 'Internist',

    'home.books_cta' => 'View books',
    'home.amazon_cta' => 'Amazon author profile',

    // Home page — nephrology
    'home.nephrology_heading' => 'Nephrology in brief',
    'home.nephrology_intro' => 'Nephrology is not only about dialysis. It combines prevention, early diagnosis and long-term treatment of kidney disease with kidney replacement therapy when conservative care is no longer enough.',
    'home.ckd_title' => 'Chronic kidney disease (CKD)',
    'home.ckd_text' => 'Chronic kidney disease is long-term kidney damage or reduced kidney function. It often accompanies diabetes or high blood pressure and calls for regular monitoring, treatment of its causes and measures to reduce further decline.',
    'home.aki_title' => 'Acute kidney injury (AKI)',
    'home.aki_text' => 'Acute kidney injury is a sudden loss of kidney function. It can occur during severe illness, dehydration, urinary obstruction, or exposure to certain medicines and toxins.',
    'home.hemodialysis_title' => 'Hemodialysis',
    'home.hemodialysis_text' => 'During haemodialysis, blood passes through a dialyser that removes waste and excess fluid and helps restore the body\'s internal balance.',
    'home.peritoneal_title' => 'Peritoneal dialysis',
    'home.peritoneal_text' => 'Peritoneal dialysis uses the lining of the abdomen as a natural dialysis membrane. Dialysis fluid is introduced into the abdominal cavity and drained after a prescribed dwell time.',
    'home.transplant_title' => 'Transplantation',
    'home.transplant_text' => 'For suitable patients, kidney transplantation can offer better survival and quality of life than long-term dialysis. It requires careful assessment, lifelong follow-up and immunosuppressive treatment.',
    'home.diagnostics_title' => 'Diagnostics',
    'home.diagnostics_text' => 'Diagnosis draws on medical history, physical examination, blood and urine tests, and imaging. A kidney biopsy is added when clinically indicated.',
    'home.nephrology_note' => 'This information is educational and does not replace a medical examination or individual advice.',

    // Home page — articles, projects, links, contact
    'home.latest_heading' => 'Latest articles',
    'home.all_articles' => 'View all articles',
    'home.projects_heading' => 'Selected projects',
    'home.projects_intro' => 'Projects I create or maintain over the long term in medicine, education and technology.',
    'home.project_nefro_text' => 'A Slovak portal with specialist articles, clinical updates, calculators, drug reference material and study resources in nephrology.',
    'home.project_nephrosite_text' => 'An archive of Slovak lectures and reference materials on nephrology, dialysis, blood purification methods and internal medicine.',
    'home.project_books_text' => 'An overview of my books, specialist publications, chapters and other writing.',
    'home.project_alphagrab_text' => 'An experimental event and ticket search tool using the Ticketmaster Discovery API.',
    'home.project_arenibus_text' => 'A .NET information system in advanced development for nephrology clinics and dialysis centres. Its MVP covers patient and visit records, dialysis prescriptions, scheduling, laboratory results, audit trails and integration with Slovakia\'s eHealth system; a public demo uses fictional data.',
    'home.project_gumroad_text' => 'Digital products and e-books on Gumroad — including Medical Fasting (also in Slovak as Medicínsky pôst), a fasting safety manual by a nephrologist featuring the Nephro-Safe Neera 2.0 protocol.',
    'home.clinics_heading' => 'Clinical facilities',
    'home.links_heading' => 'Other websites and links',
    'home.links_intro' => 'My other websites, books and selected tools.',
    'home.link_nephrosite' => 'NephroSite (in Slovak)',
    'home.link_dialysis_bratislava' => 'Dialysis in Bratislava: Medimpax (in Slovak)',
    'home.link_impax_centres' => 'IMPAX dialysis centres (in Slovak)',
    'home.link_vital_2nd' => 'Vital Algorithm — 2nd edition (Amazon)',
    'home.link_vital_1st' => 'The Vital Algorithm — 1st edition (Amazon)',
    'home.contact_heading' => 'Contact',
    'home.contact_intro' => 'For professional collaboration, a lecture, medical translation or a digital project, send me a message. This contact is not intended for urgent medical questions.',
    'home.contact_cta' => 'Open the contact form',

    // Article listing
    'articles.heading' => 'Articles',
    'articles.aria_label' => 'Articles',
    'articles.empty' => 'No articles have been published yet.',
    'articles.page_missing' => 'The requested page does not exist.',
    'articles.go_first_page' => 'Go to the first page of articles',
    'articles.pagination_label' => 'Article pagination',
    'articles.no_translation' => 'This article is not available in the selected language yet. The original version is shown.',

    // Article detail
    'article.aria_label' => 'Article content',
    'article.not_found_aria' => 'Article not found',
    'article.not_found_heading' => 'Article not found',
    'article.not_found_text' => 'The requested article does not exist or has not been published.',
    'article.back_to_list' => 'Back to articles',
    'article.admin_preview' => 'Administrator preview — this article is not publicly available yet.',
    'article.available_in' => 'Also available in:',

    // Contact form
    'contact.heading' => 'Contact',
    'contact.aria_label' => 'Contact form',
    'contact.name' => 'Name',
    'contact.email' => 'Email',
    'contact.subject' => 'Subject',
    'contact.message' => 'Message',
    'contact.submit' => 'Send message',
    'contact.success' => 'Thank you. Your message has been sent.',
    'contact.error_name' => 'Please enter a valid name.',
    'contact.error_email' => 'Please enter a valid email address.',
    'contact.error_subject' => 'The subject is too long.',
    'contact.error_message' => 'Please enter a message (max. 5000 characters).',
    'contact.error_rate_limit' => 'Too many messages from this address. Please try again later.',
    'contact.error_save' => 'The message could not be sent. Please try again later.',

    // Newsletter
    'newsletter.heading' => 'Newsletter',
    'newsletter.aria_label' => 'Newsletter subscription',
    'newsletter.intro' => 'Subscribe for email updates on new articles, books and projects.',
    'newsletter.email' => 'Email address',
    'newsletter.subscribe' => 'Subscribe',
    'newsletter.confirm_unsubscribe' => 'Confirm unsubscribe',
    'newsletter.unsubscribe_prompt' => 'Please confirm that you wish to unsubscribe from the newsletter.',
    'newsletter.unsubscribe_link_invalid' => 'The unsubscribe link is invalid.',
    'newsletter.unsubscribe_link_used' => 'The unsubscribe link is invalid or has already been used.',
    'newsletter.unsubscribed' => 'You have been successfully unsubscribed.',
    'newsletter.confirm_link_used' => 'The confirmation link is invalid or has already been used.',
    'newsletter.confirmed' => 'Your subscription has been confirmed. Thank you!',
    'newsletter.pending' => 'If this address can be subscribed, we have sent further instructions to that address.',
    'newsletter.rate_limit_confirm' => 'Too many confirmation attempts. Please try again later.',
    'newsletter.rate_limit_unsubscribe' => 'Too many unsubscribe attempts. Please try again later.',
    'newsletter.rate_limit_subscribe' => 'Too many attempts. Please try again later.',
    'newsletter.error_email' => 'Please enter a valid email address.',
    'newsletter.error_generic' => 'An error occurred. Please try again later.',
    'newsletter.error_mail_failed' => 'The confirmation e-mail could not be sent. Please try again later.',
    'newsletter.error_domain' => 'The e-mail address domain does not appear to be valid.',
    'newsletter.error_action' => 'Invalid form action.',
    'newsletter.unsubscribe_hint' => 'We have emailed you the unsubscribe link. You can also save it now, just in case:',
    'newsletter.unsubscribe_hint_link' => 'unsubscribe from the newsletter',
    'newsletter.mail_confirm_subject' => 'Confirm your Polascin.net subscription',
    'newsletter.mail_confirm_body' => "Thank you for your interest in the Polascin.net newsletter.\n\nConfirm your subscription by clicking the link (valid for 48 hours):\n:url\n\nIf you did not request this subscription, please ignore this email.",
    'newsletter.mail_welcome_subject' => 'Polascin.net subscription confirmed',
    'newsletter.mail_welcome_body' => "Your subscription to the Polascin.net newsletter has been confirmed.\n\nTo unsubscribe:\n:url\n\nIf you did not sign up for this subscription, please use the unsubscribe link.",

    // Login
    'login.heading' => 'Administrator login',
    'login.aria_label' => 'Login',
    'login.username' => 'Username',
    'login.password' => 'Password',
    'login.submit' => 'Log in',
    'login.error_credentials' => 'Invalid username or password.',
    'login.error_rate_limit' => 'Too many login attempts. Please try again later.',
    'login.session_expired' => 'Your session has expired due to inactivity. Please log in again.',
    'login.account_inactive' => 'Your account is no longer active. Please log in again.',

    // Logout (messages are shown on the public site)
    'logout.success' => 'You have been logged out.',
    'logout.csrf_failed' => 'The logout could not be verified. Please try again.',

    // Common errors
    'error.csrf' => 'Invalid security token. Please refresh the page and try again.',

    // Cookies (passed to JavaScript)
    'cookie.title' => 'Analytics cookies',
    'cookie.description' => 'With your consent, I use Google Analytics 4 to measure visits. Analytics will not load without consent, and advertising features remain disabled. Details are in the',
    'cookie.privacy_link' => 'privacy policy',
    'cookie.decline' => 'Decline',
    'cookie.accept' => 'Allow analytics',

    // Privacy Policy
    'privacy.heading' => 'Privacy Policy',
    'privacy.updated' => 'Last updated: July 28, 2026',
    'privacy.s1_heading' => '1. Introduction',
    'privacy.s1_text' => 'Welcome to <strong>polascin.net</strong>. I respect your privacy and am committed to protecting your personal data. This privacy policy explains how I handle your personal data when you visit this website and describes your privacy rights and the legal protections available to you.',
    'privacy.s2_heading' => '2. Information I collect',
    'privacy.s2_text' => 'This website is primarily informational in nature. I do not require you to create an account.',
    'privacy.s2_technical' => '<strong>Technical data:</strong> This includes the Internet Protocol (IP) address, browser type, the address visited, the time of the request and basic response data. This data is used for security, diagnostics and to protect forms against abuse. Sensitive link parameters are removed before storage.',
    'privacy.s2_contact' => '<strong>Contact form:</strong> If you send a message, I store the name, email address, subject, message text and time of submission so that I can reply to it.',
    'privacy.s2_newsletter' => '<strong>Newsletter:</strong> When you subscribe, I store the email address, the time of subscription and the cryptographic hashes of the tokens needed to confirm and to cancel the subscription.',
    'privacy.s2_cookies' => '<strong>Cookies and local storage:</strong> Locally I store only your theme preference (dark/light mode), the selected language and your decision about analytics. <strong>Google Analytics 4 (GA4):</strong> The analytics script is not loaded until you explicitly click the Allow analytics button in the consent bar. The advertising consent categories remain disabled. You can change your decision at any time via Cookie settings in the footer.',
    'privacy.s3_heading' => '3. How I use your information',
    'privacy.s3_text' => 'I use your data to:',
    'privacy.s3_item1' => 'Deliver the content of the website.',
    'privacy.s3_item2' => 'Keep the website secure.',
    'privacy.s3_item3' => 'Remember your theme preference, language and analytics decision.',
    'privacy.s3_item4' => 'Process contact messages and manage your newsletter subscription at your request.',
    'privacy.s3_item5' => 'Analyze traffic and website usage through Google Analytics 4, but only if you click the <strong>Allow analytics</strong> button in the cookie consent bar. Legal basis: your consent (Article 6(1)(a) GDPR). Analytics data is retained by Google under its own retention rules (usually no more than 14 months). You may withdraw your consent at any time using the <strong>Cookie settings</strong> button in the footer and choosing <strong>Decline</strong>.',
    'privacy.s4_heading' => '4. Retention period',
    'privacy.s4_text' => 'The site\'s own technical access logs are deleted automatically after 90 days by default; the operator may shorten this period. Short-lived form-protection records are deleted on an ongoing basis once the protection window has passed. Contact messages are kept only for as long as is necessary to handle the correspondence. The newsletter email address is kept until you unsubscribe.',
    'privacy.s5_heading' => '5. Third-party links',
    'privacy.s5_text' => 'This website may contain links to third-party websites, plug-ins and applications (for example Amazon or social networks). Clicking such links may allow third parties to collect or share data about you. I have no control over these third-party websites and am not responsible for their privacy statements.',
    'privacy.s6_heading' => '6. Your legal rights (GDPR/CCPA)',
    'privacy.s6_text' => 'In certain circumstances you have rights under data protection law in relation to your personal data, including the right to request access to, the correction or erasure of, or the restriction of the processing of your personal data.',
    'privacy.s7_heading' => '7. Contact',
    'privacy.s7_text' => 'If you have any questions about this privacy policy, please contact me at:',

    // Terms of Use
    'terms.heading' => 'Terms of Use',
    'terms.updated' => 'Last updated: July 28, 2026',
    'terms.s1_heading' => '1. Acceptance of terms',
    'terms.s1_text' => 'By accessing and using the website <strong>polascin.net</strong> (the “Website”), you accept and agree to be bound by the terms and provisions of this agreement.',
    'terms.s2_heading' => '2. Medical disclaimer',
    'terms.s2_important' => '<strong>IMPORTANT:</strong> The content provided on this website is for informational purposes only. It is <strong>not a substitute</strong> for professional medical advice, diagnosis or treatment.',
    'terms.s2_text' => 'Always seek the advice of your physician or another qualified health care professional with any questions you may have regarding a medical condition. Never disregard professional medical advice or delay seeking medical care because of information you have read on this website.',
    'terms.s3_heading' => '3. Intellectual property',
    'terms.s3_text' => 'The content, structure, graphics, design, compilation and other elements relating to this website are protected by applicable copyright and intellectual property laws. Any copying, redistribution, use or publication by users of these elements, or of any part of the website, is strictly prohibited.',
    'terms.s4_heading' => '4. Limitation of liability',
    'terms.s4_text' => 'In no event shall I be liable for any incidental, indirect, consequential or special damages of any nature, or for any other damages whatsoever, including but not limited to damages arising from loss of profit, loss of contracts, goodwill, data, information, revenue, anticipated savings or business relationships, whether or not I have been advised of the possibility of such damages, arising out of or in connection with the use of this website or of any website linked from it.',
    'terms.s5_heading' => '5. Governing law',
    'terms.s5_text' => 'These terms and conditions are governed by and construed in accordance with the laws of the Slovak Republic, and you irrevocably submit to the exclusive jurisdiction of its courts.',

    // Administration
    'admin.language' => 'Language',
    'admin.language_hint' => 'The language the content is written in.',
    'admin.translation_group' => 'Translation group',
    'admin.translation_group_hint' => 'The same number links translations of the same article across languages. Leave the field empty to create a new group.',
];
