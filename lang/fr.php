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
 * Catalogue de traductions français.
 *
 * Les clés sont des identifiants stables, et non des textes. Les paramètres
 * substituables s'écrivent sous la forme `:nom`. Ce fichier est dérivé de
 * `sk.php` ; toute clé manquante ici retombe sur la version slovaque.
 */
return [
    // Sélecteur de langue
    'lang.switch' => 'Langue',
    'lang.switch_aria' => 'Choisir la langue du site',
    'lang.current' => 'Langue actuelle : :language',

    // Éléments communs de l'interface
    'common.site_name' => 'Polascin.net',
    'common.author' => 'Dr Ľubomír Polaščín',
    'common.author_short' => 'Ľubomír Polaščín',
    'common.skip_to_content' => 'Aller au contenu principal',
    'common.main_navigation' => 'Navigation principale',
    'common.main_content' => 'Contenu principal',
    'common.open_navigation' => 'Ouvrir la navigation',
    'common.close_navigation' => 'Fermer la navigation',
    'common.toggle_dark_mode' => 'Activer ou désactiver le mode sombre',
    'common.switch_to_dark' => 'Passer en mode sombre',
    'common.switch_to_light' => 'Passer en mode clair',
    'common.required' => 'obligatoire',
    'common.back' => 'Retour',
    'common.read_more' => 'Lire la suite',
    'common.visit' => 'Visiter :target',
    'common.opens_new_tab' => 's\'ouvre dans un nouvel onglet',
    'common.author_meta_prefix' => 'Auteur',

    // Navigation
    'nav.home' => 'Accueil',
    'nav.blog' => 'Blog',
    'nav.about' => 'À propos',
    'nav.nephrology' => 'Néphrologie',
    'nav.projects' => 'Projets',
    'nav.books' => 'Livres',
    'nav.links' => 'Liens',
    'nav.contact' => 'Contact',
    'nav.admin' => 'Administration',
    'nav.logout' => 'Se déconnecter',
    'nav.login' => 'Connexion',

    // Pied de page
    'footer.heading' => 'Contact et profils',
    'footer.linkedin' => 'Profil LinkedIn',
    'footer.x' => 'Profil X',
    'footer.facebook' => 'Profil Facebook',
    'footer.email' => 'Envoyer un e-mail',
    'footer.patreon' => 'Soutenir sur Patreon',
    'footer.discord' => 'Rejoindre sur Discord',
    'footer.copyright' => '© 1998 – :year Ľubomír Polaščín. Tous droits réservés.',
    'footer.privacy' => 'Confidentialité',
    'footer.terms' => 'Conditions d\'utilisation',
    'footer.cookie_settings' => 'Paramètres des cookies',

    // Métadonnées des pages
    'meta.default_description' => 'Site personnel et professionnel du Dr Ľubomír Polaščín : néphrologie et dialyse, enseignement et écriture médicale, traduction spécialisée et outils numériques pratiques.',
    'meta.home_tagline' => 'Néphrologie, enseignement médical et outils numériques',
    'meta.articles_title' => 'Articles',
    'meta.articles_description' => 'Les derniers articles et réflexions du Dr Ľubomír Polaščín sur la néphrologie, la médecine interne, les technologies et l\'écriture.',
    'meta.articles_404_title' => 'Page d\'articles introuvable',
    'meta.articles_404_description' => 'La page de la liste d\'articles demandée n\'existe pas.',
    'meta.article_404_title' => 'Introuvable',
    'meta.article_404_description' => 'Article introuvable.',
    'meta.contact_title' => 'Contact',
    'meta.contact_description' => 'Contactez le Dr Ľubomír Polaščín pour toute question professionnelle, proposition de collaboration ou demande de renseignements.',
    'meta.newsletter_title' => 'Newsletter',
    'meta.newsletter_description' => 'Abonnez-vous à la newsletter de Polascin.net — actualités sur la néphrologie, la médecine interne, les livres et les technologies.',
    'meta.login_title' => 'Connexion',
    'meta.login_description' => 'Connexion administrateur sur Polascin.net.',
    'meta.privacy_title' => 'Politique de confidentialité',
    'meta.privacy_description' => 'Politique de confidentialité du site web du Dr Ľubomír Polaščín.',
    'meta.terms_title' => 'Conditions d\'utilisation',
    'meta.terms_description' => 'Conditions d\'utilisation du site web du Dr Ľubomír Polaščín.',

    // Page d'accueil — bandeau principal
    'home.logo_alt' => 'Crystal Kidney',
    'home.hero_title' => 'Dr Ľubomír Polaščín',
    'home.hero_subtitle' => 'Je suis néphrologue et interniste, enseignant en médecine et auteur. Je mets ma longue expérience de la dialyse au service de l\'écriture spécialisée, de la traduction et du développement d\'outils numériques pratiques.',
    'home.cta_about' => 'Ce que je fais',
    'home.cta_articles' => 'Lire les articles',

    // Page d'accueil — parcours
    'home.about_heading' => 'À propos de moi',
    'home.about_intro' => 'Je suis médecin spécialisé en néphrologie et en médecine interne. Mon activité professionnelle s\'est concentrée sur la dialyse et les maladies rénales ; j\'ai dirigé deux centres de dialyse à Bratislava et travaillé dans l\'enseignement médical.',
    'home.about_who' => 'J\'écris des textes spécialisés et littéraires, je traduis des contenus médicaux du slovaque vers l\'anglais et de l\'anglais vers le slovaque, et je crée des sites web et des applications. J\'évalue la technologie et l\'intelligence artificielle selon leur utilité pratique : rendent-elles le savoir plus accessible, simplifient-elles le travail ou améliorent-elles la qualité du résultat ?',
    'home.about_synthesis' => 'J\'adopte une démarche similaire en médecine, en langue et en code : définir précisément le problème, vérifier les faits pertinents, reconnaître les incertitudes et produire un résultat clair et utilisable.',

    'home.areas_heading' => 'Ce que je fais',
    'home.areas_medicine' => 'Néphrologie et enseignement',
    'home.areas_medicine_1' => 'néphrologie et dialyse',
    'home.areas_medicine_2' => 'médecine interne',
    'home.areas_medicine_3' => 'traitements de suppléance rénale',
    'home.areas_medicine_4' => 'échographie et prise en charge des abords vasculaires',
    'home.areas_medicine_5' => 'conférences et enseignement spécialisés',
    'home.areas_language' => 'Écriture et traduction',
    'home.areas_language_1' => 'textes médicaux spécialisés',
    'home.areas_language_2' => 'traduction médicale et travail terminologique',
    'home.areas_language_3' => 'localisation de logiciels médicaux',
    'home.areas_language_4' => 'fiction, essais et non-fiction',
    'home.areas_language_5' => 'vulgarisation médicale et éducation des patients',
    'home.areas_tech' => 'Projets numériques',
    'home.areas_tech_1' => 'développement de sites web et d\'applications',
    'home.areas_tech_2' => 'calculateurs médicaux et outils numériques',
    'home.areas_tech_3' => 'automatisation du traitement de l\'information',
    'home.areas_tech_4' => 'usage critique et pratique de l\'intelligence artificielle',
    'home.areas_tech_5' => 'logiciels libres et systèmes Linux/Unix',

    'home.skills_heading' => 'Outils et technologies',
    'home.skills_web' => 'Technologies web',
    'home.skills_web_text' => 'HTML5, CSS3, JavaScript, TypeScript, PHP',
    'home.skills_data' => 'Programmation et données',
    'home.skills_data_text' => 'Python, SQL, bases de données et traitement des données',
    'home.skills_systems' => 'Systèmes et infrastructure',
    'home.skills_systems_text' => 'Linux, Unix, logiciels libres et open source',
    'home.skills_ai' => 'Intelligence artificielle',
    'home.skills_ai_text' => 'Modèles de langage, automatisation et évaluation critique de leur usage en médecine',

    'home.education_heading' => 'Formation et parcours professionnel',
    'home.education_text' => 'J\'ai obtenu mon diplôme de médecine à l\'Université Pavol Jozef Šafárik de Košice en 1995. J\'ai obtenu ma qualification en médecine interne en 1998, puis en néphrologie en 2009, année où j\'ai également reçu une certification en échographie abdominale de l\'adulte.',
    'home.education_path' => 'Je travaille dans les domaines de la dialyse et de la néphrologie depuis 1995. J\'ai ensuite dirigé deux centres de dialyse à Bratislava et travaillé dans l\'enseignement médical.',
    'home.education_scope' => 'Mon expérience couvre l\'hémodialyse, l\'hémodiafiltration, la dialyse péritonéale, l\'épuration extrarénale en situation aiguë, l\'échographie, la prise en charge des abords vasculaires et la préparation des patients à la transplantation rénale. J\'associe cette expérience à l\'écriture scientifique, aux conférences, à l\'enseignement et à la création de projets numériques en médecine.',

    'home.personal_heading' => 'Au-delà de la médecine',
    'home.personal_text' => 'Je m\'intéresse à la littérature, à la philosophie, à la poésie et aux voyages.',
    'home.personal_writing' => 'Dans mes livres et mes autres écrits, je reviens à la médecine, aux conflits moraux et aux relations entre les personnes et la technologie.',

    'home.identity_nephrologist' => 'Néphrologue',
    'home.identity_internist' => 'Interniste',

    'home.books_cta' => 'Voir les livres',
    'home.amazon_cta' => 'Profil d\'auteur sur Amazon',

    // Page d'accueil — néphrologie
    'home.nephrology_heading' => 'La néphrologie en bref',
    'home.nephrology_intro' => 'La néphrologie ne se limite pas à la dialyse. Elle associe la prévention, le diagnostic précoce et le traitement au long cours des maladies rénales aux traitements de suppléance rénale lorsque les soins conservateurs ne suffisent plus.',
    'home.ckd_title' => 'Maladie rénale chronique (MRC)',
    'home.ckd_text' => 'La maladie rénale chronique correspond à une atteinte rénale durable ou à une diminution prolongée de la fonction rénale. Elle est souvent associée au diabète ou à l\'hypertension artérielle et nécessite une surveillance régulière, le traitement de ses causes et des mesures visant à ralentir son aggravation.',
    'home.aki_title' => 'Insuffisance rénale aiguë (IRA)',
    'home.aki_text' => 'L\'insuffisance rénale aiguë correspond à une perte soudaine de la fonction rénale. Elle peut survenir au cours d\'une maladie grave, d\'une déshydratation, d\'une obstruction des voies urinaires ou après l\'exposition à certains médicaments et toxiques.',
    'home.hemodialysis_title' => 'Hémodialyse',
    'home.hemodialysis_text' => 'Au cours de l\'hémodialyse, le sang traverse un dialyseur qui élimine les déchets et l\'excès de liquide et contribue à rétablir l\'équilibre interne de l\'organisme.',
    'home.peritoneal_title' => 'Dialyse péritonéale',
    'home.peritoneal_text' => 'La dialyse péritonéale utilise le péritoine comme membrane naturelle de dialyse. Le liquide de dialyse est introduit dans la cavité abdominale, puis drainé après un temps de stase prescrit.',
    'home.transplant_title' => 'Transplantation',
    'home.transplant_text' => 'Chez les patients qui peuvent en bénéficier, la transplantation rénale peut offrir une meilleure survie et une meilleure qualité de vie qu\'une dialyse au long cours. Elle exige une évaluation rigoureuse, un suivi à vie et un traitement immunosuppresseur.',
    'home.diagnostics_title' => 'Diagnostic',
    'home.diagnostics_text' => 'Le diagnostic repose sur l\'anamnèse, l\'examen clinique, les analyses de sang et d\'urine et l\'imagerie. Une biopsie rénale est réalisée lorsqu\'elle est cliniquement indiquée.',
    'home.nephrology_note' => 'Ces informations ont une vocation pédagogique et ne remplacent ni un examen médical ni un avis personnalisé.',

    // Page d'accueil — articles, projets, liens, contact
    'home.latest_heading' => 'Derniers articles',
    'home.all_articles' => 'Voir tous les articles',
    'home.projects_heading' => 'Projets sélectionnés',
    'home.projects_intro' => 'Projets que je crée ou maintiens sur le long terme dans les domaines de la médecine, de l\'enseignement et des technologies.',
    'home.project_nefro_text' => 'Portail slovaque proposant des articles spécialisés, des actualités cliniques, des calculateurs, des références sur les médicaments et des ressources d\'étude en néphrologie.',
    'home.project_nephrosite_text' => 'Archives de conférences et de documents de référence en slovaque sur la néphrologie, la dialyse, les méthodes d\'épuration du sang et la médecine interne.',
    'home.project_books_text' => 'Présentation de mes livres, publications spécialisées, chapitres et autres écrits.',
    'home.project_alphagrab_text' => 'Outil expérimental de recherche d\'événements et de billets utilisant l\'API Ticketmaster Discovery.',
    'home.project_arenibus_text' => 'Un système d’information .NET à un stade avancé de développement pour les cliniques de néphrologie et les centres de dialyse. Son MVP couvre les dossiers des patients et des consultations, les prescriptions de dialyse, la planification, les résultats de laboratoire, les pistes d’audit et l’intégration au système eHealth slovaque ; une démonstration publique utilise des données fictives.',
    'home.links_heading' => 'Autres sites et liens',
    'home.links_intro' => 'Mes autres sites, mes livres et une sélection d\'outils.',
    'home.link_nephrosite' => 'NephroSite (en slovaque)',
    'home.link_dialysis_bratislava' => 'Dialyse à Bratislava – Medimpax (en slovaque)',
    'home.link_impax_centres' => 'Centres de dialyse IMPAX (en slovaque)',
    'home.link_vital_2nd' => 'Vital Algorithm — 2e édition (Amazon)',
    'home.link_vital_1st' => 'The Vital Algorithm — 1re édition (Amazon)',
    'home.contact_heading' => 'Contact',
    'home.contact_intro' => 'Pour une collaboration professionnelle, une conférence, une traduction médicale ou un projet numérique, envoyez-moi un message. Ce contact n\'est pas destiné aux questions médicales urgentes.',
    'home.contact_cta' => 'Ouvrir le formulaire de contact',

    // Liste des articles
    'articles.heading' => 'Articles',
    'articles.aria_label' => 'Articles',
    'articles.empty' => 'Aucun article n\'a encore été publié.',
    'articles.page_missing' => 'La page demandée n\'existe pas.',
    'articles.go_first_page' => 'Aller à la première page des articles',
    'articles.pagination_label' => 'Pagination des articles',
    'articles.no_translation' => 'Cet article n\'est pas encore disponible dans la langue choisie. La version originale est affichée.',

    // Détail de l'article
    'article.aria_label' => 'Contenu de l\'article',
    'article.not_found_aria' => 'Article introuvable',
    'article.not_found_heading' => 'Article introuvable',
    'article.not_found_text' => 'L\'article demandé n\'existe pas ou n\'est pas publié.',
    'article.back_to_list' => 'Retour aux articles',
    'article.admin_preview' => 'Aperçu administrateur — cet article n\'est pas encore accessible au public.',
    'article.available_in' => 'Également disponible en :',

    // Formulaire de contact
    'contact.heading' => 'Contact',
    'contact.aria_label' => 'Formulaire de contact',
    'contact.name' => 'Nom',
    'contact.email' => 'E-mail',
    'contact.subject' => 'Objet',
    'contact.message' => 'Message',
    'contact.submit' => 'Envoyer le message',
    'contact.success' => 'Merci. Votre message a été envoyé.',
    'contact.error_name' => 'Veuillez saisir un nom valide.',
    'contact.error_email' => 'Veuillez saisir une adresse e-mail valide.',
    'contact.error_subject' => 'L\'objet est trop long.',
    'contact.error_message' => 'Veuillez saisir un message (5000 caractères maximum).',
    'contact.error_rate_limit' => 'Trop de messages envoyés depuis cette adresse. Veuillez réessayer plus tard.',
    'contact.error_save' => 'L\'envoi du message a échoué. Veuillez réessayer plus tard.',

    // Newsletter
    'newsletter.heading' => 'Newsletter',
    'newsletter.aria_label' => 'Inscription à la newsletter',
    'newsletter.intro' => 'Abonnez-vous pour recevoir par e-mail les nouveaux articles ainsi que les actualités sur les livres et les projets.',
    'newsletter.email' => 'Adresse e-mail',
    'newsletter.subscribe' => 'S\'abonner',
    'newsletter.confirm_unsubscribe' => 'Confirmer la désinscription',
    'newsletter.unsubscribe_prompt' => 'Veuillez confirmer que vous souhaitez vous désabonner de la newsletter.',
    'newsletter.unsubscribe_link_invalid' => 'Le lien de désinscription n\'est pas valide.',
    'newsletter.unsubscribe_link_used' => 'Le lien de désinscription n\'est pas valide ou a déjà été utilisé.',
    'newsletter.unsubscribed' => 'Votre désinscription a bien été prise en compte.',
    'newsletter.confirm_link_used' => 'Le lien de confirmation n\'est pas valide ou a déjà été utilisé.',
    'newsletter.confirmed' => 'Votre abonnement a été confirmé. Merci !',
    'newsletter.pending' => 'Si cette adresse peut être inscrite, nous venons de lui envoyer la marche à suivre.',
    'newsletter.rate_limit_confirm' => 'Trop de tentatives de confirmation. Veuillez réessayer plus tard.',
    'newsletter.rate_limit_unsubscribe' => 'Trop de tentatives de désinscription. Veuillez réessayer plus tard.',
    'newsletter.rate_limit_subscribe' => 'Trop de tentatives. Veuillez réessayer plus tard.',
    'newsletter.error_email' => 'Veuillez saisir une adresse e-mail valide.',
    'newsletter.error_generic' => 'Une erreur est survenue. Veuillez réessayer plus tard.',
    'newsletter.error_mail_failed' => 'L\'e-mail de confirmation n\'a pas pu être envoyé. Veuillez réessayer plus tard.',
    'newsletter.error_domain' => 'Le domaine de l\'adresse e-mail ne semble pas valide.',
    'newsletter.error_action' => 'Action de formulaire invalide.',
    'newsletter.unsubscribe_hint' => 'Nous vous avons envoyé le lien de désinscription par e-mail. Par précaution, vous pouvez également l\'enregistrer dès maintenant :',
    'newsletter.unsubscribe_hint_link' => 'se désabonner de la newsletter',
    'newsletter.mail_confirm_subject' => 'Confirmez votre abonnement à Polascin.net',
    'newsletter.mail_confirm_body' => "Merci de l'intérêt que vous portez à la newsletter de Polascin.net.\n\nConfirmez votre abonnement en cliquant sur le lien suivant (valable 48 heures) :\n:url\n\nSi vous n'êtes pas à l'origine de cette demande, ignorez cet e-mail.",
    'newsletter.mail_welcome_subject' => 'Confirmation de votre abonnement à Polascin.net',
    'newsletter.mail_welcome_body' => "Votre abonnement à la newsletter de Polascin.net a été confirmé.\n\nSe désabonner :\n:url\n\nSi vous n'avez pas demandé cet abonnement, utilisez le lien de désinscription.",

    // Connexion
    'login.heading' => 'Connexion administrateur',
    'login.aria_label' => 'Connexion',
    'login.username' => 'Nom d\'utilisateur',
    'login.password' => 'Mot de passe',
    'login.submit' => 'Se connecter',
    'login.error_credentials' => 'Nom d\'utilisateur ou mot de passe incorrect.',
    'login.error_rate_limit' => 'Trop de tentatives de connexion. Veuillez réessayer plus tard.',
    'login.session_expired' => 'Votre session a expiré pour cause d\'inactivité. Veuillez vous reconnecter.',
    'login.account_inactive' => 'Votre compte n\'est plus actif. Veuillez vous reconnecter.',

    // Déconnexion (les messages apparaissent sur le site public)
    'logout.success' => 'Vous avez été déconnecté.',
    'logout.csrf_failed' => 'La déconnexion n\'a pas pu être vérifiée. Veuillez réessayer.',

    // Erreurs communes
    'error.csrf' => 'Jeton de sécurité invalide. Actualisez la page et réessayez.',

    // Cookies (transmis au JavaScript)
    'cookie.title' => 'Cookies analytiques',
    'cookie.description' => 'Avec votre consentement, j\'utilise Google Analytics 4 pour mesurer la fréquentation. L\'outil d\'analyse ne se charge pas sans consentement et les fonctionnalités publicitaires restent désactivées. Les détails figurent dans la',
    'cookie.privacy_link' => 'politique de confidentialité',
    'cookie.decline' => 'Refuser',
    'cookie.accept' => 'Autoriser l\'analyse d\'audience',

    // Politique de confidentialité
    'privacy.heading' => 'Politique de confidentialité',
    'privacy.updated' => 'Dernière mise à jour : 28 juillet 2026',
    'privacy.s1_heading' => '1. Introduction',
    'privacy.s1_text' => 'Bienvenue sur <strong>polascin.net</strong>. Je respecte votre vie privée et je m\'engage à protéger vos données personnelles. La présente politique de confidentialité explique comment je traite vos données personnelles lorsque vous visitez ce site web ; elle décrit également vos droits en matière de protection de la vie privée ainsi que la protection juridique correspondante.',
    'privacy.s2_heading' => '2. Informations que je collecte',
    'privacy.s2_text' => 'Ce site web a avant tout une vocation informative. Je ne vous demande pas de créer un compte.',
    'privacy.s2_technical' => '<strong>Données techniques :</strong> Elles comprennent l\'adresse IP (protocole Internet), le type de navigateur, l\'adresse consultée, l\'heure de la requête et les données de base relatives à la réponse. Ces données servent à la sécurité, au diagnostic et à la protection des formulaires contre les abus. Les paramètres sensibles des liens sont supprimés avant tout enregistrement.',
    'privacy.s2_contact' => '<strong>Formulaire de contact :</strong> Si vous m\'envoyez un message, j\'enregistre le nom, l\'adresse e-mail, l\'objet, le texte du message et l\'heure d\'envoi afin de pouvoir y répondre.',
    'privacy.s2_newsletter' => '<strong>Newsletter :</strong> Lors de l\'abonnement, j\'enregistre l\'adresse e-mail, l\'horodatage de l\'inscription et les empreintes cryptographiques des jetons nécessaires à la confirmation et à la désinscription.',
    'privacy.s2_cookies' => '<strong>Cookies et stockage local :</strong> Je conserve localement uniquement la préférence de thème (mode sombre ou clair), la langue choisie et votre décision concernant la mesure d\'audience. <strong>Google Analytics 4 (GA4) :</strong> Le script d\'analyse n\'est chargé qu\'après un clic explicite de votre part sur le bouton Autoriser l\'analyse d\'audience du bandeau de consentement. Les catégories de consentement publicitaires restent désactivées. Vous pouvez modifier votre choix à tout moment via les Paramètres des cookies, dans le pied de page.',
    'privacy.s3_heading' => '3. Comment j\'utilise vos informations',
    'privacy.s3_text' => 'J\'utilise vos données pour :',
    'privacy.s3_item1' => 'Fournir le contenu du site web.',
    'privacy.s3_item2' => 'Assurer la sécurité du site web.',
    'privacy.s3_item3' => 'Mémoriser la préférence de thème, la langue et la décision concernant la mesure d\'audience.',
    'privacy.s3_item4' => 'Traiter les messages de contact et gérer l\'abonnement à la newsletter, à votre demande.',
    'privacy.s3_item5' => 'Analyser la fréquentation et les modes d\'utilisation du site web au moyen de Google Analytics 4, mais uniquement si vous cliquez sur le bouton <strong>Autoriser l\'analyse d\'audience</strong> du bandeau de consentement aux cookies. Base juridique : votre consentement au sens de l\'article 6, paragraphe 1, point a), du RGPD. Les données analytiques sont conservées par Google conformément à ses propres règles de conservation (généralement 14 mois au maximum). Vous pouvez retirer votre consentement à tout moment au moyen du bouton <strong>Paramètres des cookies</strong> situé dans le pied de page, en choisissant l\'option <strong>Refuser</strong>.',
    'privacy.s4_heading' => '4. Durée de conservation',
    'privacy.s4_text' => 'Les journaux d\'accès techniques internes sont supprimés automatiquement au bout de 90 jours par défaut ; l\'exploitant peut raccourcir cette durée. Les enregistrements de courte durée liés à la protection des formulaires sont effacés au fur et à mesure, dès l\'expiration de la fenêtre de protection. Je ne conserve les messages de contact que le temps nécessaire au traitement de la correspondance. Je conserve l\'adresse e-mail liée à la newsletter jusqu\'à la désinscription.',
    'privacy.s5_heading' => '5. Liens de tiers',
    'privacy.s5_text' => 'Ce site web peut contenir des liens vers des sites, des modules complémentaires et des applications de tiers (par exemple Amazon ou des réseaux sociaux). En cliquant sur ces liens, vous permettez éventuellement à des tiers de collecter ou de partager des données vous concernant. Je n\'exerce aucun contrôle sur ces sites tiers et je ne suis pas responsable de leurs déclarations de confidentialité.',
    'privacy.s6_heading' => '6. Vos droits légaux (RGPD/CCPA)',
    'privacy.s6_text' => 'Dans certaines circonstances, vous disposez, en vertu de la législation sur la protection des données, de droits relatifs à vos données personnelles, notamment celui d\'en demander l\'accès, la rectification, l\'effacement ou la limitation du traitement.',
    'privacy.s7_heading' => '7. Contact',
    'privacy.s7_text' => 'Si vous avez la moindre question concernant la présente politique de confidentialité, vous pouvez me contacter à l\'adresse suivante :',

    // Conditions d'utilisation
    'terms.heading' => 'Conditions d\'utilisation',
    'terms.updated' => 'Dernière mise à jour : 28 juillet 2026',
    'terms.s1_heading' => '1. Acceptation des conditions',
    'terms.s1_text' => 'En accédant au site web <strong>polascin.net</strong> et en l\'utilisant (ci-après le « site web »), vous acceptez les conditions générales du présent accord et vous engagez à les respecter.',
    'terms.s2_heading' => '2. Avertissement médical',
    'terms.s2_important' => '<strong>IMPORTANT :</strong> Le contenu de ce site web est fourni à titre purement informatif. Il <strong>ne remplace pas</strong> un avis, un diagnostic ou un traitement médical professionnel.',
    'terms.s2_text' => 'Pour toute question relative à votre état de santé, adressez-vous toujours à votre médecin ou à un autre professionnel de santé qualifié. Ne négligez jamais un avis médical professionnel et ne tardez jamais à consulter en raison d\'informations lues sur ce site web.',
    'terms.s3_heading' => '3. Propriété intellectuelle',
    'terms.s3_text' => 'Le contenu, la structure, les graphismes, le design, la compilation et les autres éléments liés à ce site web sont protégés par le droit d\'auteur et par les lois applicables en matière de propriété intellectuelle. Toute copie, redistribution, utilisation ou publication de ces éléments, ou de toute partie du site web, par les utilisateurs est strictement interdite.',
    'terms.s4_heading' => '4. Limitation de responsabilité',
    'terms.s4_text' => 'Je ne saurais en aucun cas être tenu responsable de dommages accessoires, indirects, consécutifs ou exceptionnels, de quelque nature que ce soit, ni de tout autre dommage, y compris, sans s\'y limiter, les dommages résultant d\'une perte de bénéfices, de contrats, de clientèle, de données, d\'informations, de revenus, d\'économies escomptées ou de relations commerciales, que j\'aie ou non été informé de l\'éventualité de tels dommages, en lien avec l\'utilisation de ce site web ou de tout site web vers lequel il renvoie.',
    'terms.s5_heading' => '5. Droit applicable',
    'terms.s5_text' => 'Les présentes conditions générales sont régies et interprétées conformément au droit de la République slovaque, et vous vous soumettez sans réserve à la compétence exclusive des tribunaux de ce ressort.',

    // Administration
    'admin.language' => 'Langue',
    'admin.language_hint' => 'Langue dans laquelle le contenu est rédigé.',
    'admin.translation_group' => 'Groupe de traduction',
    'admin.translation_group_hint' => 'Un même numéro relie entre elles les traductions d\'un même article dans les différentes langues. Un champ vide crée un nouveau groupe.',
];
