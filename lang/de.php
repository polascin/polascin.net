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
 * Deutscher Übersetzungskatalog.
 *
 * Die Schlüssel sind stabile Bezeichner, keine Texte. Platzhalter werden als `:name` geschrieben.
 * Alle Sprachen leiten sich vom slowakischen Quellkatalog ab; ein hier fehlender
 * Schlüssel fällt auf `sk.php` zurück.
 */
return [
    // Sprachumschalter
    'lang.switch' => 'Sprache',
    'lang.switch_aria' => 'Sprache der Website wählen',
    'lang.current' => 'Aktuelle Sprache: :language',

    // Gemeinsame Bedienelemente
    'common.site_name' => 'Polascin.net',
    'common.author' => 'MUDr. Ľubomír Polaščín',
    'common.author_short' => 'Ľubomír Polaščín',
    'common.skip_to_content' => 'Zum Hauptinhalt springen',
    'common.main_navigation' => 'Hauptnavigation',
    'common.main_content' => 'Hauptinhalt',
    'common.open_navigation' => 'Navigation öffnen',
    'common.close_navigation' => 'Navigation schließen',
    'common.toggle_dark_mode' => 'Dunkelmodus umschalten',
    'common.switch_to_dark' => 'Zum dunklen Modus wechseln',
    'common.switch_to_light' => 'Zum hellen Modus wechseln',
    'common.required' => 'Pflichtfeld',
    'common.back' => 'Zurück',
    'common.read_more' => 'Weiterlesen',
    'common.visit' => ':target besuchen',
    'common.opens_new_tab' => 'wird in einem neuen Tab geöffnet',
    'common.author_meta_prefix' => 'Autor',

    // Navigation
    'nav.home' => 'Startseite',
    'nav.blog' => 'Blog',
    'nav.about' => 'Über mich',
    'nav.nephrology' => 'Nephrologie',
    'nav.projects' => 'Projekte',
    'nav.books' => 'Bücher',
    'nav.links' => 'Links',
    'nav.contact' => 'Kontakt',
    'nav.admin' => 'Administration',
    'nav.logout' => 'Abmelden',
    'nav.login' => 'Anmeldung',

    // Fußzeile
    'footer.heading' => 'Kontakt und Profile',
    'footer.linkedin' => 'Profil auf LinkedIn',
    'footer.x' => 'Profil auf X',
    'footer.facebook' => 'Profil auf Facebook',
    'footer.email' => 'E-Mail senden',
    'footer.patreon' => 'Auf Patreon unterstützen',
    'footer.discord' => 'Discord beitreten',
    'footer.copyright' => '© 1998 – :year Ľubomír Polaščín. Alle Rechte vorbehalten.',
    'footer.privacy' => 'Datenschutz',
    'footer.terms' => 'Nutzungsbedingungen',
    'footer.cookie_settings' => 'Cookie-Einstellungen',

    // Seiten-Metadaten
    'meta.default_description' => 'Persönliche und berufliche Website von MUDr. Ľubomír Polaščín: Nephrologie und Dialyse, medizinische Fortbildung und Fachtexte, medizinische Fachübersetzungen sowie praktische digitale Werkzeuge.',
    'meta.home_tagline' => 'Nephrologie, medizinische Fortbildung und digitale Werkzeuge',
    'meta.articles_title' => 'Artikel',
    'meta.articles_description' => 'Aktuelle Artikel und Betrachtungen von MUDr. Ľubomír Polaščín über Nephrologie, Innere Medizin, Technologie und das Schreiben.',
    'meta.articles_404_title' => 'Artikelseite nicht gefunden',
    'meta.articles_404_description' => 'Die angeforderte Seite der Artikelübersicht existiert nicht.',
    'meta.article_404_title' => 'Nicht gefunden',
    'meta.article_404_description' => 'Der Artikel wurde nicht gefunden.',
    'meta.contact_title' => 'Kontakt',
    'meta.contact_description' => 'Kontaktieren Sie MUDr. Ľubomír Polaščín für fachliche Fragen, Zusammenarbeit oder Anfragen.',
    'meta.newsletter_title' => 'Newsletter',
    'meta.newsletter_description' => 'Abonnieren Sie den Newsletter von Polascin.net — Neuigkeiten zu Nephrologie, Innerer Medizin, Büchern und Technologie.',
    'meta.login_title' => 'Anmeldung',
    'meta.login_description' => 'Administrator-Anmeldung bei Polascin.net.',
    'meta.privacy_title' => 'Datenschutz',
    'meta.privacy_description' => 'Datenschutzerklärung für die Website von MUDr. Ľubomír Polaščín.',
    'meta.terms_title' => 'Nutzungsbedingungen',
    'meta.terms_description' => 'Nutzungsbedingungen der Website von MUDr. Ľubomír Polaščín.',

    // Startseite — Hero
    'home.logo_alt' => 'Crystal Kidney',
    'home.hero_title' => 'MUDr. Ľubomír Polaščín',
    'home.hero_subtitle' => 'Ich bin Nephrologe und Internist sowie in der medizinischen Fortbildung und als Autor tätig. Meine langjährige Erfahrung in der Dialyse bringe ich in Fachtexte, Übersetzungen und die Entwicklung praktischer digitaler Werkzeuge ein.',
    'home.cta_about' => 'Meine Arbeit',
    'home.cta_articles' => 'Artikel lesen',

    // Startseite — Lebenslauf
    'home.about_heading' => 'Über mich',
    'home.about_intro' => 'Ich bin Arzt mit Qualifikationen in Nephrologie und Innerer Medizin. Meine berufliche Arbeit konzentriert sich auf Dialyse und Nierenerkrankungen; ich habe zwei Dialysezentren in Bratislava geleitet und in der medizinischen Fortbildung gearbeitet.',
    'home.about_who' => 'Ich schreibe Fachtexte und literarische Texte, übersetze medizinische Inhalte zwischen Slowakisch und Englisch und entwickle Websites und Anwendungen. Technik und künstliche Intelligenz beurteile ich nach ihrem praktischen Nutzen: ob sie Wissen leichter zugänglich machen, Arbeit vereinfachen oder die Qualität des Ergebnisses verbessern.',
    'home.about_synthesis' => 'In Medizin, Sprache und Code gehe ich ähnlich vor: das Problem präzise definieren, die entscheidenden Fakten prüfen, Unsicherheit kenntlich machen und ein klares, brauchbares Ergebnis schaffen.',

    'home.areas_heading' => 'Meine Tätigkeitsfelder',
    'home.areas_medicine' => 'Nephrologie und Fortbildung',
    'home.areas_medicine_1' => 'Nephrologie und Dialyse',
    'home.areas_medicine_2' => 'Innere Medizin',
    'home.areas_medicine_3' => 'Nierenersatztherapie',
    'home.areas_medicine_4' => 'Sonografie und Betreuung von Gefäßzugängen',
    'home.areas_medicine_5' => 'Fachvorträge und medizinische Fortbildung',
    'home.areas_language' => 'Schreiben und Übersetzen',
    'home.areas_language_1' => 'medizinische Fachtexte',
    'home.areas_language_2' => 'medizinische Übersetzungen und Terminologiearbeit',
    'home.areas_language_3' => 'Lokalisierung medizinischer Software',
    'home.areas_language_4' => 'Belletristik, Essays und Sachliteratur',
    'home.areas_language_5' => 'Popularisierung der Medizin und Patientenschulung',
    'home.areas_tech' => 'Digitale Projekte',
    'home.areas_tech_1' => 'Entwicklung von Websites und Anwendungen',
    'home.areas_tech_2' => 'medizinische Rechner und digitale Werkzeuge',
    'home.areas_tech_3' => 'Automatisierung der Informationsverarbeitung',
    'home.areas_tech_4' => 'kritischer und praxisorientierter Einsatz künstlicher Intelligenz',
    'home.areas_tech_5' => 'quelloffene Software und Linux/Unix-Systeme',

    'home.skills_heading' => 'Werkzeuge und Technologien',
    'home.skills_web' => 'Webtechnologien',
    'home.skills_web_text' => 'HTML5, CSS3, JavaScript, TypeScript, PHP',
    'home.skills_data' => 'Programmierung und Daten',
    'home.skills_data_text' => 'Python, SQL, Datenbanken und Datenverarbeitung',
    'home.skills_systems' => 'Systeme und Infrastruktur',
    'home.skills_systems_text' => 'Linux, Unix, freie und quelloffene Software',
    'home.skills_ai' => 'Künstliche Intelligenz',
    'home.skills_ai_text' => 'Sprachmodelle, Automatisierung und kritische Bewertung ihres Einsatzes in der Medizin',

    'home.education_heading' => 'Ausbildung und beruflicher Werdegang',
    'home.education_text' => 'Mein Studium der Humanmedizin an der Pavol-Jozef-Šafárik-Universität in Košice schloss ich 1995 ab. 1998 erwarb ich die Qualifikation in Innerer Medizin und 2009 in Nephrologie; im selben Jahr erhielt ich außerdem die Zertifizierung für Abdomensonografie bei Erwachsenen.',
    'home.education_path' => 'Seit 1995 arbeite ich in Dialyse und Nephrologie. Später leitete ich zwei Dialysezentren in Bratislava und war in der medizinischen Fortbildung tätig.',
    'home.education_scope' => 'Zu meiner fachlichen Erfahrung gehören Hämodialyse, Hämodiafiltration, Peritonealdialyse, akute Eliminationsverfahren, Sonografie, die Betreuung von Gefäßzugängen und die Vorbereitung von Patienten auf die Nierentransplantation. Diese Erfahrung verbinde ich mit fachlichem Schreiben, Vorträgen, Lehre und der Entwicklung medizinischer digitaler Projekte.',

    'home.personal_heading' => 'Über die Medizin hinaus',
    'home.personal_text' => 'Ich interessiere mich für Literatur, Philosophie, Poesie und Reisen.',
    'home.personal_writing' => 'In meinen Büchern und anderen Texten kehre ich immer wieder zu Medizin, moralischen Konflikten und dem Verhältnis von Mensch und Technik zurück.',

    'home.identity_nephrologist' => 'Nephrologe',
    'home.identity_internist' => 'Internist',

    'home.books_cta' => 'Bücher ansehen',
    'home.amazon_cta' => 'Autorenprofil bei Amazon',

    // Startseite — Nephrologie
    'home.nephrology_heading' => 'Nephrologie im Überblick',
    'home.nephrology_intro' => 'Nephrologie ist mehr als Dialyse. Sie verbindet Prävention, Früherkennung und die langfristige Behandlung von Nierenerkrankungen mit Nierenersatztherapie, wenn eine konservative Behandlung nicht mehr ausreicht.',
    'home.ckd_title' => 'Chronische Nierenerkrankung (CKD)',
    'home.ckd_text' => 'Eine chronische Nierenerkrankung ist eine langfristige Schädigung der Nieren oder Einschränkung ihrer Funktion. Sie tritt häufig zusammen mit Diabetes oder Bluthochdruck auf und erfordert regelmäßige Kontrollen, die Behandlung ihrer Ursachen und Maßnahmen, die ein weiteres Fortschreiten bremsen.',
    'home.aki_title' => 'Akute Nierenschädigung (AKI)',
    'home.aki_text' => 'Eine akute Nierenschädigung ist ein plötzlicher Verlust der Nierenfunktion. Sie kann im Rahmen schwerer Erkrankungen, bei Dehydratation, einer Harnabflussstörung oder durch bestimmte Medikamente und Giftstoffe auftreten.',
    'home.hemodialysis_title' => 'Hämodialyse',
    'home.hemodialysis_text' => 'Bei der Hämodialyse fließt das Blut durch einen Dialysator, der Abfallstoffe und überschüssige Flüssigkeit entfernt und hilft, das innere Gleichgewicht des Körpers wiederherzustellen.',
    'home.peritoneal_title' => 'Peritonealdialyse',
    'home.peritoneal_text' => 'Die Peritonealdialyse nutzt das Bauchfell als natürliche Dialysemembran. Dialyselösung wird in die Bauchhöhle eingebracht und nach der vorgegebenen Verweilzeit wieder abgelassen.',
    'home.transplant_title' => 'Transplantation',
    'home.transplant_text' => 'Bei geeigneten Patienten kann eine Nierentransplantation bessere Überlebenschancen und eine höhere Lebensqualität bieten als eine langfristige Dialyse. Sie erfordert eine sorgfältige Beurteilung, lebenslange Nachsorge und eine immunsuppressive Behandlung.',
    'home.diagnostics_title' => 'Diagnostik',
    'home.diagnostics_text' => 'Die Diagnostik stützt sich auf Anamnese, körperliche Untersuchung, Blut- und Urinuntersuchungen sowie bildgebende Verfahren. Eine Nierenbiopsie wird durchgeführt, wenn sie klinisch angezeigt ist.',
    'home.nephrology_note' => 'Diese Informationen dienen der Aufklärung und ersetzen weder eine ärztliche Untersuchung noch eine individuelle Beratung.',

    // Startseite — Artikel, Projekte, Links, Kontakt
    'home.latest_heading' => 'Neueste Artikel',
    'home.all_articles' => 'Alle Artikel anzeigen',
    'home.projects_heading' => 'Ausgewählte Projekte',
    'home.projects_intro' => 'Projekte, die ich in Medizin, Bildung und Technik entwickle oder langfristig betreue.',
    'home.project_nefro_text' => 'Ein slowakisches Portal mit Fachartikeln, klinischen Neuigkeiten, Rechnern, Arzneimittelinformationen und Lernmaterialien zur Nephrologie.',
    'home.project_nephrosite_text' => 'Ein Archiv slowakischer Vorträge und Referenzmaterialien zu Nephrologie, Dialyse, Blutreinigungsverfahren und Innerer Medizin.',
    'home.project_books_text' => 'Ein Überblick über meine Bücher, Fachpublikationen, Buchkapitel und weiteren Texte.',
    'home.project_alphagrab_text' => 'Ein experimentelles Werkzeug zur Suche nach Veranstaltungen und Tickets, das die Ticketmaster Discovery API nutzt.',
    'home.project_arenibus_text' => 'Ein .NET-Informationssystem in fortgeschrittener Entwicklung für nephrologische Ambulanzen und Dialysezentren. Sein MVP umfasst Patienten- und Besuchsdokumentation, Dialyseverordnungen, Terminplanung, Laborergebnisse, Audit-Trails sowie die Anbindung an das slowakische eHealth-System; eine öffentliche Demo verwendet fiktive Daten.',
    'home.links_heading' => 'Weitere Websites und Links',
    'home.links_intro' => 'Meine weiteren Websites, Bücher und ausgewählten Werkzeuge.',
    'home.link_nephrosite' => 'NephroSite (auf Slowakisch)',
    'home.link_dialysis_bratislava' => 'Dialyse in Bratislava: Medimpax (auf Slowakisch)',
    'home.link_impax_centres' => 'IMPAX-Dialysezentren (auf Slowakisch)',
    'home.link_vital_2nd' => 'Vital Algorithm — 2. Auflage (Amazon)',
    'home.link_vital_1st' => 'The Vital Algorithm — 1. Auflage (Amazon)',
    'home.contact_heading' => 'Kontakt',
    'home.contact_intro' => 'Wenn Sie an einer fachlichen Zusammenarbeit, einem Vortrag, einer medizinischen Übersetzung oder einem digitalen Projekt interessiert sind, schreiben Sie mir. Dieser Kontakt ist nicht für dringende medizinische Fragen bestimmt.',
    'home.contact_cta' => 'Kontaktformular öffnen',

    // Artikelübersicht
    'articles.heading' => 'Artikel',
    'articles.aria_label' => 'Artikel',
    'articles.empty' => 'Es wurden noch keine Artikel veröffentlicht.',
    'articles.page_missing' => 'Die angeforderte Seite existiert nicht.',
    'articles.go_first_page' => 'Zur ersten Artikelseite wechseln',
    'articles.pagination_label' => 'Seitennavigation der Artikel',
    'articles.no_translation' => 'Dieser Artikel ist in der gewählten Sprache noch nicht verfügbar. Angezeigt wird die Originalfassung.',

    // Artikelansicht
    'article.aria_label' => 'Artikelinhalt',
    'article.not_found_aria' => 'Artikel nicht gefunden',
    'article.not_found_heading' => 'Artikel nicht gefunden',
    'article.not_found_text' => 'Der angeforderte Artikel existiert nicht oder ist nicht veröffentlicht.',
    'article.back_to_list' => 'Zurück zu den Artikeln',
    'article.admin_preview' => 'Administratorvorschau — dieser Artikel ist noch nicht öffentlich zugänglich.',
    'article.available_in' => 'Auch verfügbar in:',

    // Kontaktformular
    'contact.heading' => 'Kontakt',
    'contact.aria_label' => 'Kontaktformular',
    'contact.name' => 'Name',
    'contact.email' => 'E-Mail',
    'contact.subject' => 'Betreff',
    'contact.message' => 'Nachricht',
    'contact.submit' => 'Nachricht senden',
    'contact.success' => 'Vielen Dank. Ihre Nachricht wurde gesendet.',
    'contact.error_name' => 'Bitte geben Sie einen gültigen Namen ein.',
    'contact.error_email' => 'Bitte geben Sie eine gültige E-Mail-Adresse ein.',
    'contact.error_subject' => 'Der Betreff ist zu lang.',
    'contact.error_message' => 'Bitte geben Sie eine Nachricht ein (max. 5000 Zeichen).',
    'contact.error_rate_limit' => 'Zu viele Nachrichten von dieser Adresse. Bitte versuchen Sie es später erneut.',
    'contact.error_save' => 'Die Nachricht konnte nicht gesendet werden. Bitte versuchen Sie es später erneut.',

    // Newsletter
    'newsletter.heading' => 'Newsletter',
    'newsletter.aria_label' => 'Newsletter-Anmeldung',
    'newsletter.intro' => 'Abonnieren Sie E-Mail-Updates zu neuen Artikeln, Büchern und Projekten.',
    'newsletter.email' => 'E-Mail-Adresse',
    'newsletter.subscribe' => 'Abonnieren',
    'newsletter.confirm_unsubscribe' => 'Abmeldung bestätigen',
    'newsletter.unsubscribe_prompt' => 'Bitte bestätigen Sie, dass Sie den Newsletter abbestellen möchten.',
    'newsletter.unsubscribe_link_invalid' => 'Der Abmeldelink ist ungültig.',
    'newsletter.unsubscribe_link_used' => 'Der Abmeldelink ist ungültig oder wurde bereits verwendet.',
    'newsletter.unsubscribed' => 'Sie wurden erfolgreich abgemeldet.',
    'newsletter.confirm_link_used' => 'Der Bestätigungslink ist ungültig oder wurde bereits verwendet.',
    'newsletter.confirmed' => 'Ihr Abonnement wurde bestätigt. Vielen Dank!',
    'newsletter.pending' => 'Falls eine Anmeldung mit dieser Adresse möglich ist, haben wir weitere Hinweise per E-Mail gesendet.',
    'newsletter.rate_limit_confirm' => 'Zu viele Bestätigungsversuche. Bitte versuchen Sie es später erneut.',
    'newsletter.rate_limit_unsubscribe' => 'Zu viele Abmeldeversuche. Bitte versuchen Sie es später erneut.',
    'newsletter.rate_limit_subscribe' => 'Zu viele Versuche. Bitte versuchen Sie es später erneut.',
    'newsletter.error_email' => 'Bitte geben Sie eine gültige E-Mail-Adresse ein.',
    'newsletter.error_generic' => 'Es ist ein Fehler aufgetreten. Bitte versuchen Sie es später erneut.',
    'newsletter.error_mail_failed' => 'Die Bestätigungs-E-Mail konnte nicht gesendet werden. Bitte versuchen Sie es später erneut.',
    'newsletter.error_domain' => 'Die Domain der E-Mail-Adresse scheint nicht gültig zu sein.',
    'newsletter.error_action' => 'Ungültige Formularaktion.',
    'newsletter.unsubscribe_hint' => 'Den Abmeldelink haben wir Ihnen per E-Mail geschickt. Sicherheitshalber können Sie ihn auch jetzt speichern:',
    'newsletter.unsubscribe_hint_link' => 'Newsletter abbestellen',
    'newsletter.mail_confirm_subject' => 'Bestätigen Sie Ihr Abonnement von Polascin.net',
    'newsletter.mail_confirm_body' => "Vielen Dank für Ihr Interesse am Newsletter von Polascin.net.\n\nBestätigen Sie das Abonnement mit einem Klick auf den folgenden Link (48 Stunden gültig):\n:url\n\nFalls Sie das Abonnement nicht angefordert haben, ignorieren Sie diese E-Mail bitte.",
    'newsletter.mail_welcome_subject' => 'Bestätigung Ihres Abonnements von Polascin.net',
    'newsletter.mail_welcome_body' => "Ihr Abonnement des Newsletters von Polascin.net wurde bestätigt.\n\nAbmeldung vom Newsletter:\n:url\n\nFalls Sie das Abonnement nicht bestellt haben, verwenden Sie bitte den Abmeldelink.",

    // Anmeldung
    'login.heading' => 'Administrator-Anmeldung',
    'login.aria_label' => 'Anmeldung',
    'login.username' => 'Benutzername',
    'login.password' => 'Passwort',
    'login.submit' => 'Anmelden',
    'login.error_credentials' => 'Ungültiger Benutzername oder ungültiges Passwort.',
    'login.error_rate_limit' => 'Zu viele Anmeldeversuche. Bitte versuchen Sie es später erneut.',
    'login.session_expired' => 'Ihre Sitzung ist wegen Inaktivität abgelaufen. Bitte melden Sie sich erneut an.',
    'login.account_inactive' => 'Ihr Konto ist nicht mehr aktiv. Bitte melden Sie sich erneut an.',

    // Abmeldung (Meldungen erscheinen auf der öffentlichen Seite)
    'logout.success' => 'Sie wurden abgemeldet.',
    'logout.csrf_failed' => 'Die Abmeldung konnte nicht verifiziert werden. Bitte versuchen Sie es erneut.',

    // Allgemeine Fehler
    'error.csrf' => 'Ungültiges Sicherheitstoken. Bitte laden Sie die Seite neu und versuchen Sie es erneut.',

    // Cookies (wird an JavaScript übergeben)
    'cookie.title' => 'Analyse-Cookies',
    'cookie.description' => 'Mit Ihrer Einwilligung nutze ich Google Analytics 4 zur Messung der Besuche. Ohne Einwilligung wird die Analyse nicht geladen; Werbefunktionen bleiben deaktiviert. Einzelheiten finden Sie in der',
    'cookie.privacy_link' => 'Datenschutzerklärung',
    'cookie.decline' => 'Ablehnen',
    'cookie.accept' => 'Analytics zulassen',

    // Datenschutz
    'privacy.heading' => 'Datenschutz',
    'privacy.updated' => 'Letzte Aktualisierung: 28. Juli 2026',
    'privacy.s1_heading' => '1. Einleitung',
    'privacy.s1_text' => 'Willkommen auf <strong>polascin.net</strong>. Ich respektiere Ihre Privatsphäre und verpflichte mich, Ihre personenbezogenen Daten zu schützen. Diese Datenschutzerklärung erläutert, wie ich beim Besuch dieser Website mit Ihren personenbezogenen Daten umgehe, und beschreibt Ihre Datenschutzrechte sowie den einschlägigen Rechtsschutz.',
    'privacy.s2_heading' => '2. Informationen, die ich erhebe',
    'privacy.s2_text' => 'Diese Website hat in erster Linie informativen Charakter. Sie müssen kein Benutzerkonto anlegen.',
    'privacy.s2_technical' => '<strong>Technische Daten:</strong> Dazu gehören die Internet-Protokoll-Adresse (IP-Adresse), der Browsertyp, die aufgerufene Adresse, der Zeitpunkt der Anfrage und grundlegende Angaben zur Antwort. Diese Daten dienen der Sicherheit, der Fehlerdiagnose und dem Schutz der Formulare vor Missbrauch. Sensible Parameter von Verweisadressen werden vor der Speicherung entfernt.',
    'privacy.s2_contact' => '<strong>Kontaktformular:</strong> Wenn Sie eine Nachricht absenden, speichere ich Namen, E-Mail-Adresse, Betreff, Nachrichtentext und Sendezeitpunkt, um die Nachricht beantworten zu können.',
    'privacy.s2_newsletter' => '<strong>Newsletter:</strong> Bei der Anmeldung zum Newsletter speichere ich die E-Mail-Adresse, den Zeitpunkt der Anmeldung sowie die kryptografischen Hashwerte der Token, die für die Bestätigung und die Abmeldung erforderlich sind.',
    'privacy.s2_cookies' => '<strong>Cookies und lokaler Speicher:</strong> Lokal speichere ich lediglich die Einstellung des Erscheinungsbilds (Dunkel-/Hellmodus), die gewählte Sprache und Ihre Entscheidung über die Analyse-Cookies. <strong>Google Analytics 4 (GA4):</strong> Das Analyseskript wird erst geladen, wenn Sie im Einwilligungsbanner ausdrücklich auf die Schaltfläche „Analytics zulassen“ klicken. Die Einwilligungskategorien für Werbung bleiben deaktiviert. Ihre Entscheidung können Sie jederzeit über die Cookie-Einstellungen in der Fußzeile ändern.',
    'privacy.s3_heading' => '3. Wie ich Ihre Informationen verwende',
    'privacy.s3_text' => 'Ich verwende Ihre Daten für folgende Zwecke:',
    'privacy.s3_item1' => 'Bereitstellung der Inhalte der Website.',
    'privacy.s3_item2' => 'Gewährleistung der Sicherheit der Website.',
    'privacy.s3_item3' => 'Speicherung Ihrer Einstellungen zu Erscheinungsbild und Sprache sowie Ihrer Entscheidung über die Analyse-Cookies.',
    'privacy.s3_item4' => 'Bearbeitung von Kontaktnachrichten und Verwaltung des Newsletter-Abonnements auf Ihren Wunsch hin.',
    'privacy.s3_item5' => 'Auswertung der Besucherzahlen und des Nutzungsverhaltens auf der Website mithilfe von Google Analytics 4, jedoch nur, wenn Sie im Cookie-Banner auf die Schaltfläche <strong>Analytics zulassen</strong> klicken. Rechtsgrundlage: Ihre Einwilligung (Art. 6 Abs. 1 lit. a DSGVO). Die Analysedaten werden von Google nach dessen eigenen Aufbewahrungsregeln gespeichert (in der Regel höchstens 14 Monate). Ihre Einwilligung können Sie jederzeit widerrufen, indem Sie in der Fußzeile die Schaltfläche <strong>Cookie-Einstellungen</strong> aufrufen und die Option <strong>Ablehnen</strong> wählen.',
    'privacy.s4_heading' => '4. Speicherdauer',
    'privacy.s4_text' => 'Eigene technische Zugriffsprotokolle werden standardmäßig nach 90 Tagen automatisch gelöscht; der Betreiber kann diese Frist verkürzen. Kurzlebige Einträge des Formularschutzes werden fortlaufend gelöscht, sobald das Schutzfenster abgelaufen ist. Kontaktnachrichten bewahre ich nur so lange auf, wie es für die Erledigung der Korrespondenz erforderlich ist. Die E-Mail-Adresse für den Newsletter bewahre ich bis zu Ihrer Abmeldung auf.',
    'privacy.s5_heading' => '5. Links Dritter',
    'privacy.s5_text' => 'Diese Website kann Links zu Websites, Plug-ins und Anwendungen Dritter enthalten (z. B. Amazon, soziale Netzwerke). Wenn Sie diese Links anklicken, können Dritte Daten über Sie erheben oder weitergeben. Ich habe keine Kontrolle über diese Websites Dritter und bin für deren Datenschutzerklärungen nicht verantwortlich.',
    'privacy.s6_heading' => '6. Ihre gesetzlichen Rechte (DSGVO/CCPA)',
    'privacy.s6_text' => 'Unter bestimmten Umständen stehen Ihnen nach den Datenschutzgesetzen Rechte in Bezug auf Ihre personenbezogenen Daten zu, einschließlich des Rechts, Auskunft, Berichtigung, Löschung oder Einschränkung der Verarbeitung Ihrer personenbezogenen Daten zu verlangen.',
    'privacy.s7_heading' => '7. Kontakt',
    'privacy.s7_text' => 'Wenn Sie Fragen zu dieser Datenschutzerklärung haben, kontaktieren Sie mich bitte unter:',

    // Nutzungsbedingungen
    'terms.heading' => 'Nutzungsbedingungen',
    'terms.updated' => 'Letzte Aktualisierung: 28. Juli 2026',
    'terms.s1_heading' => '1. Annahme der Bedingungen',
    'terms.s1_text' => 'Mit dem Zugriff auf die Website <strong>polascin.net</strong> (nachfolgend „Website“) und deren Nutzung nehmen Sie die Bedingungen und Bestimmungen dieser Vereinbarung an und erklären sich damit einverstanden, an sie gebunden zu sein.',
    'terms.s2_heading' => '2. Medizinischer Haftungsausschluss',
    'terms.s2_important' => '<strong>WICHTIG:</strong> Die auf dieser Website bereitgestellten Inhalte dienen ausschließlich Informationszwecken. Sie sind <strong>kein Ersatz</strong> für professionelle medizinische Beratung, Diagnostik oder Behandlung.',
    'terms.s2_text' => 'Wenden Sie sich bei allen Fragen zu Ihrem Gesundheitszustand stets an Ihre Ärztin, Ihren Arzt oder eine andere qualifizierte medizinische Fachkraft. Missachten Sie niemals professionellen ärztlichen Rat und zögern Sie die Inanspruchnahme ärztlicher Hilfe niemals hinaus, weil Sie etwas auf dieser Website gelesen haben.',
    'terms.s3_heading' => '3. Geistiges Eigentum',
    'terms.s3_text' => 'Die Inhalte, die Struktur, die Grafiken, das Design, die Zusammenstellung sowie weitere mit dieser Website verbundene Elemente sind durch das geltende Urheberrecht und die Gesetze zum Schutz des geistigen Eigentums geschützt. Jegliches Kopieren, Weiterverbreiten, Verwenden oder Veröffentlichen dieser Elemente oder eines beliebigen Teils der Website durch den Nutzer ist strengstens untersagt.',
    'terms.s4_heading' => '4. Haftungsbeschränkung',
    'terms.s4_text' => 'Ich hafte in keinem Fall für beiläufig entstandene, mittelbare oder außergewöhnliche Schäden sowie für Folgeschäden gleich welcher Art und ebenso wenig für sonstige Schäden, einschließlich, jedoch nicht beschränkt auf Schäden infolge entgangenen Gewinns, des Verlusts von Verträgen, des Geschäftswerts, von Daten, Informationen, Einnahmen, erwarteten Einsparungen oder Geschäftsbeziehungen, unabhängig davon, ob ich auf die Möglichkeit solcher Schäden hingewiesen wurde, und zwar im Zusammenhang mit der Nutzung dieser Website oder einer von ihr verlinkten Website.',
    'terms.s5_heading' => '5. Anwendbares Recht',
    'terms.s5_text' => 'Diese Bedingungen und Bestimmungen unterliegen dem Recht der Slowakischen Republik und sind nach diesem auszulegen; Sie unterwerfen sich vorbehaltlos der ausschließlichen Zuständigkeit der dortigen Gerichte.',

    // Administration
    'admin.language' => 'Sprache',
    'admin.language_hint' => 'Die Sprache, in der der Inhalt verfasst ist.',
    'admin.translation_group' => 'Übersetzungsgruppe',
    'admin.translation_group_hint' => 'Dieselbe Nummer verknüpft die Übersetzungen desselben Artikels über die Sprachen hinweg. Ein leeres Feld erstellt eine neue Gruppe.',
];
