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
    'common.author' => 'Dr. med. Ľubomír Polaščín',
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
    'nav.about' => 'Lebenslauf',
    'nav.nephrology' => 'Nephrologie',
    'nav.projects' => 'Projekte',
    'nav.books' => 'Bücher',
    'nav.links' => 'Links',
    'nav.contact' => 'Kontakt',
    'nav.admin' => 'Administration',
    'nav.logout' => 'Abmelden',
    'nav.login' => 'Anmeldung',

    // Fußzeile
    'footer.heading' => 'Kontakt aufnehmen',
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
    'meta.keywords' => 'Ľubomír Polaščín, Nephrologie, Innere Medizin, Dialyse, medizinische Übersetzung, Programmierung',
    'meta.default_description' => 'Dr. med. Ľubomír Polaščín — Nephrologe, Internist, medizinischer Übersetzer, Schriftsteller und autodidaktischer Programmierer.',
    'meta.home_title' => 'Startseite',
    'meta.articles_title' => 'Artikel',
    'meta.articles_description' => 'Aktuelle Artikel und Betrachtungen von Dr. med. Ľubomír Polaščín über Nephrologie, Innere Medizin, Technologie und das Schreiben.',
    'meta.articles_404_title' => 'Artikelseite nicht gefunden',
    'meta.articles_404_description' => 'Die angeforderte Seite der Artikelübersicht existiert nicht.',
    'meta.article_404_title' => 'Nicht gefunden',
    'meta.article_404_description' => 'Der Artikel wurde nicht gefunden.',
    'meta.contact_title' => 'Kontakt',
    'meta.contact_description' => 'Kontaktieren Sie Dr. med. Ľubomír Polaščín für fachliche Fragen, Zusammenarbeit oder Anfragen.',
    'meta.newsletter_title' => 'Newsletter',
    'meta.newsletter_description' => 'Abonnieren Sie den Newsletter von Polascin.net — Neuigkeiten zu Nephrologie, Innerer Medizin, Büchern und Technologie.',
    'meta.login_title' => 'Anmeldung',
    'meta.login_description' => 'Administrator-Anmeldung bei Polascin.net.',
    'meta.privacy_title' => 'Datenschutz',
    'meta.privacy_description' => 'Datenschutzerklärung für die Website von Dr. med. Ľubomír Polaščín.',
    'meta.terms_title' => 'Nutzungsbedingungen',
    'meta.terms_description' => 'Nutzungsbedingungen der Website von Dr. med. Ľubomír Polaščín.',

    // Startseite — Hero
    'home.logo_alt' => 'Crystal-Kidney-Logo',
    'home.hero_title' => 'Fortschritt für die Nierengesundheit',
    'home.hero_subtitle' => 'Dr. med. Ľubomír Polaščín — der Exzellenz in Nephrologie, Dialyse, Patientenversorgung und Medizintechnik verpflichtet.',
    'home.cta_about' => 'Über mich',
    'home.cta_articles' => 'Neueste Artikel',

    // Startseite — Lebenslauf
    'home.about_heading' => 'Über Dr. med. Ľubomír Polaščín',
    'home.about_intro' => 'Mein Name ist Ľubomír Polaščín — von Beruf Arzt, Nephrologe und Internist, aus Berufung Autor von Belletristik und Sachliteratur und aus Leidenschaft autodidaktischer Programmierer.',
    'home.about_who' => 'Meine Arbeit liegt am Schnittpunkt von Medizin, Erzählkunst und Technologie. Die Medizin schärft meine klinische Präzision; das Schreiben erlaubt mir, das Menschsein in Belletristik und Sachliteratur zu ergründen; und die Technologie treibt mich beim Lösen komplexer Probleme voran. Als Berater verbinde ich diese Welten und liefere durchdachte, fundierte Lösungen.',
    'home.who_heading' => 'Wer ich bin',
    'home.who_approach' => 'Jede Herausforderung gehe ich mit Neugier und Sorgfalt an — ob ich Patienten behandle, Code debugge, anspruchsvolle Texte übersetze oder KI erkunde.',
    'home.bio_heading' => 'Biografische Angaben',
    'home.bio_name' => 'Name',
    'home.bio_pronunciation' => 'Aussprache',
    'home.bio_email' => 'E-Mail',
    'home.bio_web' => 'Web',
    'home.bio_social' => 'Soziale Netzwerke',
    'home.identity_heading' => 'Berufliches Profil',
    'home.identity_text' => 'Ich bin Arzt, habe 1995 das Studium der Allgemeinmedizin abgeschlossen und 2009 die Facharztanerkennung für Nephrologie erworben. Die Anerkennung für Innere Medizin stammt aus dem Jahr 1998, das Zertifikat für abdominelle Ultraschalldiagnostik bei Erwachsenen aus dem Jahr 2009.',
    'home.expertise_heading' => 'Fachgebiete',
    'home.expertise_dialysis' => 'Dialyse und Nierenersatzverfahren (Hämodialyse, Hämodiafiltration, Hämofiltration)',
    'home.expertise_vascular' => 'Ultraschalldiagnostik von Gefäßzugängen für die Dialyse',
    'home.expertise_elimination' => 'Extrakorporale und intrakorporale Eliminationsverfahren',
    'home.expertise_plasma' => 'Membranplasmaseparation und verwandte Verfahren',
    'home.expertise_transplant' => 'Nierentransplantation',
    'home.teaching_text' => 'Ich verfüge über umfangreiche Erfahrung in Lehre und Vorträgen in Innerer Medizin, Diabetologie, Nephrologie und verwandten Fachgebieten. Zudem arbeite ich als Übersetzer für medizinische Fachtexte Englisch–Slowakisch und Slowakisch–Englisch sowie für Softwarelokalisierung.',
    'home.tech_text' => 'Informationstechnologie, Informatik und Programmierung begleiten mich seit Langem. Besonders interessieren mich:',
    'home.identity_doctor' => 'Arzt (Dr. med.)',
    'home.identity_nephrologist' => 'Nephrologe',
    'home.identity_internist' => 'Internist',
    'home.identity_translator' => 'Medizinischer Übersetzer',
    'home.identity_writer' => 'Autor von Belletristik und Sachliteratur',
    'home.identity_programmer' => 'Autodidaktischer Programmierer',
    'home.skills_heading' => 'Technologie, IT und Programmierung',
    'home.education_heading' => 'Ausbildung und Werdegang',
    'home.education_text' => 'Mein Medizinstudium habe ich an der Pavol-Jozef-Šafárik-Universität in Košice begonnen. Seit 1995 widme ich mich der Dialyse und der Nephrologie. Von 2013 bis 2022 war ich Chefarzt zweier Dialysezentren in Bratislava.',
    'home.personal_heading' => 'Persönliches',
    'home.personal_text' => '1971 in der Tschechoslowakei geboren, bin ich in Kyjov aufgewachsen. Meine russinischen Wurzeln prägen meinen Blick auf die Welt. Zu meinen Interessen zählen Lesen, Reisen, Philosophie und Poesie.',
    'home.amazon_cta' => 'Auf Amazon Author Central ansehen',

    // Startseite — Nephrologie
    'home.nephrology_heading' => 'Nephrologie',
    'home.nephrology_intro' => 'Die Nephrologie ist ein zentrales medizinisches Fachgebiet, das sich mit den Nieren befasst — lebenswichtigen Organen, die für den Flüssigkeitshaushalt, die Filtration harnpflichtiger Substanzen und die Regulierung des Blutdrucks verantwortlich sind.',
    'home.ckd_title' => 'Chronische Nierenerkrankung (CKD)',
    'home.ckd_text' => 'Management des fortschreitenden Verlusts der Nierenfunktion infolge von Diabetes, Bluthochdruck oder anderen Faktoren.',
    'home.aki_title' => 'Akute Nierenschädigung (AKI)',
    'home.aki_text' => 'Behandlung des plötzlichen, oft vorübergehenden Ausfalls der Nierenfunktion infolge von Infektionen, Dehydratation oder Toxinen.',
    'home.hemodialysis_title' => 'Hämodialyse',
    'home.hemodialysis_text' => 'Ein Verfahren, bei dem ein Dialysegerät und ein spezieller Filter, die sogenannte künstliche Niere, zur Reinigung des Blutes eingesetzt werden.',
    'home.peritoneal_title' => 'Peritonealdialyse',
    'home.peritoneal_text' => 'Eine Behandlung, bei der das Bauchfell und eine Spüllösung, das sogenannte Dialysat, zur Reinigung des Blutes genutzt werden.',
    'home.transplant_title' => 'Transplantation',
    'home.transplant_text' => 'Die beste Behandlung des Nierenversagens. Eine gesunde Niere wird in den Körper eingesetzt und übernimmt die Aufgaben, zu denen die eigenen Nieren nicht mehr in der Lage sind.',
    'home.diagnostics_title' => 'Diagnostik',
    'home.diagnostics_text' => 'Einsatz von Ultraschall, Nierenbiopsie und modernen Laboruntersuchungen zur präzisen Diagnose von Nierenerkrankungen.',

    // Startseite — Artikel, Projekte, Links, Kontakt
    'home.latest_heading' => 'Neueste Artikel',
    'home.all_articles' => 'Alle Artikel anzeigen',
    'home.projects_heading' => 'Projekte und Netzwerk',
    'home.projects_intro' => 'Eine Auswahl an Websites, Werkzeugen und Ressourcen, die ich in den Bereichen Medizin, Bildung und Technologie aufbaue oder betreue.',
    'home.project_nefro_text' => 'Slowakisches Nephrologieportal mit klinischen Artikeln, Neuigkeiten zu Dialyse und Transplantation, medizinischen Rechnern, Arzneimittelreferenzen und Lernnotizen.',
    'home.project_nephrosite_text' => 'Lehrvorträge und Referenzseiten zu Nephrologie, Dialyse, Blutreinigungsverfahren und Innerer Medizin (auf Slowakisch).',
    'home.project_books_text' => 'Zentrales Archiv der Bücher, wissenschaftlichen Publikationen, Buchkapitel und literarischen Werke von Dr. med. Ľubomír Polaščín.',
    'home.project_alphagrab_text' => 'Ein experimentelles Projekt zur Ticketsuche, das Ausweichlinks über die Ticketmaster Discovery API anreichert.',
    'home.project_arenibus_text' => 'Öffentliche Demo-Instanz eines Webprojekts rund um Veranstaltungen und Verkehr.',
    'home.links_heading' => 'Netzwerk und Ressourcen',
    'home.links_intro' => 'Entdecken Sie weitere verwandte Seiten und Ressourcen.',
    'home.link_nephrosite' => 'NephroSite (auf Slowakisch)',
    'home.link_vital_2nd' => 'Vital Algorithm — 2. Auflage (Amazon)',
    'home.link_vital_1st' => 'The Vital Algorithm — 1. Auflage (Amazon)',
    'home.contact_heading' => 'Kontakt',
    'home.contact_intro' => 'Zögern Sie nicht, mich bei Fragen oder für eine Zusammenarbeit zu kontaktieren.',
    'home.contact_cta' => 'Nachricht senden',

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
    'contact.success' => 'Vielen Dank für Ihre Nachricht. Ich melde mich so bald wie möglich.',
    'contact.error_name' => 'Bitte geben Sie einen gültigen Namen ein.',
    'contact.error_email' => 'Bitte geben Sie eine gültige E-Mail-Adresse ein.',
    'contact.error_subject' => 'Der Betreff ist zu lang.',
    'contact.error_message' => 'Bitte geben Sie eine Nachricht ein (max. 5000 Zeichen).',
    'contact.error_rate_limit' => 'Zu viele Nachrichten von dieser Adresse. Bitte versuchen Sie es später erneut.',
    'contact.error_save' => 'Die Nachricht konnte nicht gesendet werden. Bitte versuchen Sie es später erneut.',

    // Newsletter
    'newsletter.heading' => 'Newsletter',
    'newsletter.aria_label' => 'Newsletter-Anmeldung',
    'newsletter.intro' => 'Abonnieren Sie Neuigkeiten zu Artikeln, Büchern und Projekten.',
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
    'cookie.description' => 'Mit Ihrer Einwilligung setzen wir Google Analytics 4 zur Messung der Besucherzahlen ein. Die Speicherung von Werbedaten und die Personalisierung bleiben deaktiviert. Eine Ablehnung schränkt die Nutzung der Website nicht ein. Einzelheiten finden Sie in der',
    'cookie.privacy_link' => 'Datenschutzerklärung',
    'cookie.decline' => 'Ablehnen',
    'cookie.accept' => 'Einverstanden',

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
    'privacy.s2_cookies' => '<strong>Cookies und lokaler Speicher:</strong> Lokal speichere ich lediglich die Einstellung des Erscheinungsbilds (Dunkel-/Hellmodus), die gewählte Sprache und Ihre Entscheidung über die Analyse-Cookies. <strong>Google Analytics 4 (GA4):</strong> Das Analyseskript wird erst geladen, wenn Sie im Einwilligungsbanner ausdrücklich auf die Schaltfläche „Einverstanden“ klicken. Die Einwilligungskategorien für Werbung bleiben deaktiviert. Ihre Entscheidung können Sie jederzeit über die Cookie-Einstellungen in der Fußzeile ändern.',
    'privacy.s3_heading' => '3. Wie ich Ihre Informationen verwende',
    'privacy.s3_text' => 'Ich verwende Ihre Daten für folgende Zwecke:',
    'privacy.s3_item1' => 'Bereitstellung der Inhalte der Website.',
    'privacy.s3_item2' => 'Gewährleistung der Sicherheit der Website.',
    'privacy.s3_item3' => 'Speicherung Ihrer Einstellungen zu Erscheinungsbild und Sprache sowie Ihrer Entscheidung über die Analyse-Cookies.',
    'privacy.s3_item4' => 'Bearbeitung von Kontaktnachrichten und Verwaltung des Newsletter-Abonnements auf Ihren Wunsch hin.',
    'privacy.s3_item5' => 'Auswertung der Besucherzahlen und des Nutzungsverhaltens auf der Website mithilfe von Google Analytics 4, jedoch nur, wenn Sie im Cookie-Banner auf die Schaltfläche <strong>Einverstanden</strong> klicken. Rechtsgrundlage: Ihre Einwilligung (Art. 6 Abs. 1 lit. a DSGVO). Die Analysedaten werden von Google nach dessen eigenen Aufbewahrungsregeln gespeichert (in der Regel höchstens 14 Monate). Ihre Einwilligung können Sie jederzeit widerrufen, indem Sie in der Fußzeile die Schaltfläche <strong>Cookie-Einstellungen</strong> aufrufen und die Option <strong>Ablehnen</strong> wählen.',
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
