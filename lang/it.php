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
 * Catalogo di traduzioni in italiano.
 *
 * Le chiavi sono identificatori stabili, non testi. I segnaposto si scrivono
 * nella forma `:nome`. Il file deriva da `sk.php`; una chiave mancante ricade
 * sul catalogo slovacco.
 */
return [
    // Selettore della lingua
    'lang.switch' => 'Lingua',
    'lang.switch_aria' => 'Seleziona la lingua del sito',
    'lang.current' => 'Lingua attuale: :language',

    // Elementi comuni dell\'interfaccia
    'common.site_name' => 'Polascin.net',
    'common.author' => 'Dott. Ľubomír Polaščín',
    'common.author_short' => 'Ľubomír Polaščín',
    'common.skip_to_content' => 'Vai al contenuto principale',
    'common.main_navigation' => 'Navigazione principale',
    'common.main_content' => 'Contenuto principale',
    'common.open_navigation' => 'Apri la navigazione',
    'common.close_navigation' => 'Chiudi la navigazione',
    'common.toggle_dark_mode' => 'Attiva o disattiva la modalità scura',
    'common.switch_to_dark' => 'Passa alla modalità scura',
    'common.switch_to_light' => 'Passa alla modalità chiara',
    'common.required' => 'obbligatorio',
    'common.back' => 'Indietro',
    'common.read_more' => 'Continua a leggere',
    'common.visit' => 'Visita :target',
    'common.opens_new_tab' => 'si apre in una nuova scheda',
    'common.author_meta_prefix' => 'Autore',

    // Navigazione
    'nav.home' => 'Home',
    'nav.blog' => 'Blog',
    'nav.about' => 'Biografia',
    'nav.nephrology' => 'Nefrologia',
    'nav.projects' => 'Progetti',
    'nav.books' => 'Libri',
    'nav.links' => 'Collegamenti',
    'nav.contact' => 'Contatti',
    'nav.admin' => 'Amministrazione',
    'nav.logout' => 'Esci',
    'nav.login' => 'Accedi',

    // Piè di pagina
    'footer.heading' => 'Restiamo in contatto',
    'footer.linkedin' => 'Profilo LinkedIn',
    'footer.x' => 'Profilo X',
    'footer.facebook' => 'Profilo Facebook',
    'footer.email' => 'Invia un\'e-mail',
    'footer.patreon' => 'Sostieni su Patreon',
    'footer.discord' => 'Unisciti su Discord',
    'footer.copyright' => '© 1998 – :year Ľubomír Polaščín. Tutti i diritti riservati.',
    'footer.privacy' => 'Informativa sulla privacy',
    'footer.terms' => 'Condizioni d\'uso',
    'footer.cookie_settings' => 'Impostazioni dei cookie',

    // Metadati delle pagine
    'meta.keywords' => 'Ľubomír Polaščín, nefrologia, medicina interna, dialisi, traduzione medica, programmazione',
    'meta.default_description' => 'Dott. Ľubomír Polaščín — nefrologo, internista, traduttore medico, scrittore e programmatore autodidatta.',
    'meta.home_title' => 'Home',
    'meta.articles_title' => 'Articoli',
    'meta.articles_description' => 'Gli ultimi articoli e riflessioni del dott. Ľubomír Polaščín su nefrologia, medicina interna, tecnologia e scrittura.',
    'meta.articles_404_title' => 'Pagina degli articoli non trovata',
    'meta.articles_404_description' => 'La pagina dell\'elenco degli articoli richiesta non esiste.',
    'meta.article_404_title' => 'Non trovato',
    'meta.article_404_description' => 'Articolo non trovato.',
    'meta.contact_title' => 'Contatti',
    'meta.contact_description' => 'Contatta il dott. Ľubomír Polaščín per domande professionali, proposte di collaborazione o informazioni.',
    'meta.newsletter_title' => 'Newsletter',
    'meta.newsletter_description' => 'Iscriviti alla newsletter di Polascin.net — novità su nefrologia, medicina interna, libri e tecnologia.',
    'meta.login_title' => 'Accedi',
    'meta.login_description' => 'Accesso amministratore per Polascin.net.',
    'meta.privacy_title' => 'Informativa sulla privacy',
    'meta.privacy_description' => 'Informativa sulla privacy del sito web del dott. Ľubomír Polaščín.',
    'meta.terms_title' => 'Condizioni d\'uso',
    'meta.terms_description' => 'Condizioni d\'uso del sito web del dott. Ľubomír Polaščín.',

    // Home — sezione principale
    'home.logo_alt' => 'Logo Crystal Kidney',
    'home.hero_title' => 'Progresso per la salute dei reni',
    'home.hero_subtitle' => 'Dott. Ľubomír Polaščín — dedito all\'eccellenza in nefrologia, dialisi, assistenza ai pazienti e tecnologie mediche.',
    'home.cta_about' => 'Chi sono',
    'home.cta_articles' => 'Ultimi articoli',

    // Home — biografia
    'home.about_heading' => 'Il dott. Ľubomír Polaščín',
    'home.about_intro' => 'Mi chiamo Ľubomír Polaščín — medico, nefrologo e internista di professione, autore di narrativa e saggistica per vocazione e programmatore autodidatta per passione.',
    'home.about_who' => 'Il mio lavoro si colloca all\'incrocio tra medicina, narrazione e tecnologia. La medicina affina la mia precisione clinica; la scrittura mi permette di esplorare la condizione umana attraverso narrativa e saggistica; e la tecnologia mi spinge avanti nella risoluzione di problemi complessi. Come consulente collego questi mondi per offrire soluzioni ponderate e ben documentate.',
    'home.who_heading' => 'Chi sono',
    'home.who_approach' => 'Affronto ogni sfida con curiosità e rigore, che si tratti di curare pazienti, correggere codice, tradurre un testo impegnativo o esplorare l\'IA.',
    'home.bio_heading' => 'Dati biografici',
    'home.bio_name' => 'Nome',
    'home.bio_pronunciation' => 'Pronuncia',
    'home.bio_email' => 'E-mail',
    'home.bio_web' => 'Web',
    'home.bio_social' => 'Social',
    'home.identity_heading' => 'Identità professionale',
    'home.identity_text' => 'Sono un medico laureato in Medicina generale (1995) e specializzato in Nefrologia (2009). Ho conseguito l\'abilitazione in Medicina interna (1998) e la certificazione in ecografia addominale nell\'adulto (2009).',
    'home.expertise_heading' => 'Aree di competenza',
    'home.expertise_dialysis' => 'Dialisi e terapie sostitutive della funzione renale (emodialisi, emodiafiltrazione, emofiltrazione)',
    'home.expertise_vascular' => 'Ecografia degli accessi vascolari per dialisi',
    'home.expertise_elimination' => 'Terapie di eliminazione extracorporea e intracorporea',
    'home.expertise_plasma' => 'Plasmaseparazione a membrana e terapie correlate',
    'home.expertise_transplant' => 'Trapianto di rene',
    'home.teaching_text' => 'Ho una lunga esperienza di insegnamento e docenza in medicina interna, diabetologia, nefrologia e discipline affini. Lavoro inoltre come traduttore specializzato in traduzione medica inglese–slovacco e slovacco–inglese e in localizzazione di software.',
    'home.tech_text' => 'Le tecnologie dell\'informazione, l\'informatica e la programmazione mi accompagnano da tempo. Mi interessano in particolare:',
    'home.identity_doctor' => 'Medico (Dott.)',
    'home.identity_nephrologist' => 'Nefrologo',
    'home.identity_internist' => 'Internista',
    'home.identity_translator' => 'Traduttore medico',
    'home.identity_writer' => 'Autore di narrativa e saggistica',
    'home.identity_programmer' => 'Programmatore autodidatta',
    'home.skills_heading' => 'Tecnologia, informatica e programmazione',
    'home.education_heading' => 'Formazione e carriera',
    'home.education_text' => 'Ho iniziato gli studi di medicina all\'Università Pavol Jozef Šafárik di Košice. Dal 1995 mi occupo di dialisi e nefrologia. Dal 2013 al 2022 sono stato primario in due centri dialisi di Bratislava.',
    'home.personal_heading' => 'In privato',
    'home.personal_text' => 'Nato nel 1971 in Cecoslovacchia, sono cresciuto a Kyjov. Le mie radici rutene plasmano il mio sguardo sul mondo. Le mie passioni sono la lettura, i viaggi, la filosofia e la poesia.',
    'home.amazon_cta' => 'Vedi su Amazon Author Central',

    // Home — nefrologia
    'home.nephrology_heading' => 'Nefrologia',
    'home.nephrology_intro' => 'La nefrologia è una specialità medica fondamentale dedicata ai reni — organi vitali responsabili dell\'equilibrio dei liquidi, della filtrazione delle scorie e della regolazione della pressione arteriosa.',
    'home.ckd_title' => 'Malattia renale cronica (MRC)',
    'home.ckd_text' => 'Gestione della perdita graduale della funzione renale nel tempo, causata da diabete, ipertensione o altri fattori.',
    'home.aki_title' => 'Danno renale acuto (AKI)',
    'home.aki_text' => 'Trattamento della perdita improvvisa, spesso temporanea, della funzione renale causata da infezioni, disidratazione o tossine.',
    'home.hemodialysis_title' => 'Emodialisi',
    'home.hemodialysis_text' => 'Procedura in cui una macchina per dialisi e un filtro speciale, detto rene artificiale, vengono usati per depurare il sangue.',
    'home.peritoneal_title' => 'Dialisi peritoneale',
    'home.peritoneal_text' => 'Trattamento che utilizza il rivestimento della cavità addominale e una soluzione detergente chiamata dialisato per depurare il sangue.',
    'home.transplant_title' => 'Trapianto',
    'home.transplant_text' => 'Il trattamento migliore per l\'insufficienza renale. Un rene sano viene inserito nell\'organismo per svolgere il lavoro che i reni del paziente non riescono più a sostenere.',
    'home.diagnostics_title' => 'Diagnostica',
    'home.diagnostics_text' => 'Uso dell\'ecografia, della biopsia renale e di esami di laboratorio avanzati per diagnosticare con precisione le malattie renali.',

    // Home — articoli, progetti, collegamenti, contatti
    'home.latest_heading' => 'Ultimi articoli',
    'home.all_articles' => 'Vedi tutti gli articoli',
    'home.projects_heading' => 'Progetti e rete',
    'home.projects_intro' => 'Una selezione di siti, strumenti e risorse che realizzo o gestisco nei campi della medicina, dell\'istruzione e della tecnologia.',
    'home.project_nefro_text' => 'Portale slovacco di nefrologia con articoli clinici, notizie su dialisi e trapianti, calcolatori, riferimenti sui farmaci e appunti di studio.',
    'home.project_nephrosite_text' => 'Lezioni didattiche e pagine di riferimento su nefrologia, dialisi, metodi di depurazione del sangue e medicina interna (in slovacco).',
    'home.project_books_text' => 'Archivio centrale dei libri, delle pubblicazioni accademiche, dei capitoli e delle opere letterarie del dott. Ľubomír Polaščín.',
    'home.project_alphagrab_text' => 'Progetto sperimentale di ricerca biglietti che arricchisce i collegamenti di riserva tramite la Ticketmaster Discovery API.',
    'home.project_arenibus_text' => 'Istanza dimostrativa pubblica di un progetto web dedicato a eventi e trasporti.',
    'home.links_heading' => 'Rete e risorse',
    'home.links_intro' => 'Scopri altri siti e risorse collegate.',
    'home.link_nephrosite' => 'NephroSite (in slovacco)',
    'home.link_vital_2nd' => 'Vital Algorithm — 2ª edizione (Amazon)',
    'home.link_vital_1st' => 'The Vital Algorithm — 1ª edizione (Amazon)',
    'home.contact_heading' => 'Contatti',
    'home.contact_intro' => 'Non esitare a scrivermi per domande o per parlare di una collaborazione.',
    'home.contact_cta' => 'Invia un messaggio',

    // Elenco degli articoli
    'articles.heading' => 'Articoli',
    'articles.aria_label' => 'Articoli',
    'articles.empty' => 'Non è ancora stato pubblicato alcun articolo.',
    'articles.page_missing' => 'La pagina richiesta non esiste.',
    'articles.go_first_page' => 'Vai alla prima pagina degli articoli',
    'articles.pagination_label' => 'Paginazione degli articoli',
    'articles.no_translation' => 'Questo articolo non è ancora disponibile nella lingua selezionata. Viene mostrata la versione originale.',

    // Dettaglio dell\'articolo
    'article.aria_label' => 'Contenuto dell\'articolo',
    'article.not_found_aria' => 'Articolo non trovato',
    'article.not_found_heading' => 'Articolo non trovato',
    'article.not_found_text' => 'L\'articolo richiesto non esiste o non è stato pubblicato.',
    'article.back_to_list' => 'Torna agli articoli',
    'article.admin_preview' => 'Anteprima amministratore — questo articolo non è ancora pubblico.',
    'article.available_in' => 'Disponibile anche in:',

    // Modulo di contatto
    'contact.heading' => 'Contatti',
    'contact.aria_label' => 'Modulo di contatto',
    'contact.name' => 'Nome',
    'contact.email' => 'E-mail',
    'contact.subject' => 'Oggetto',
    'contact.message' => 'Messaggio',
    'contact.submit' => 'Invia il messaggio',
    'contact.success' => 'Grazie per il messaggio. Risponderò appena possibile.',
    'contact.error_name' => 'Inserisci un nome valido.',
    'contact.error_email' => 'Inserisci un indirizzo e-mail valido.',
    'contact.error_subject' => 'L\'oggetto è troppo lungo.',
    'contact.error_message' => 'Inserisci un messaggio (max 5000 caratteri).',
    'contact.error_rate_limit' => 'Troppi messaggi da questo indirizzo. Riprova più tardi.',
    'contact.error_save' => 'Non è stato possibile inviare il messaggio. Riprova più tardi.',

    // Newsletter
    'newsletter.heading' => 'Newsletter',
    'newsletter.aria_label' => 'Iscrizione alla newsletter',
    'newsletter.intro' => 'Iscriviti per ricevere novità su articoli, libri e progetti.',
    'newsletter.email' => 'Indirizzo e-mail',
    'newsletter.subscribe' => 'Iscriviti',
    'newsletter.confirm_unsubscribe' => 'Conferma la cancellazione',
    'newsletter.unsubscribe_prompt' => 'Conferma di volerti cancellare dalla newsletter.',
    'newsletter.unsubscribe_link_invalid' => 'Il collegamento di cancellazione non è valido.',
    'newsletter.unsubscribe_link_used' => 'Il collegamento di cancellazione non è valido o è già stato usato.',
    'newsletter.unsubscribed' => 'La cancellazione è avvenuta correttamente.',
    'newsletter.confirm_link_used' => 'Il collegamento di conferma non è valido o è già stato usato.',
    'newsletter.confirmed' => 'La tua iscrizione è stata confermata. Grazie!',
    'newsletter.pending' => 'Se questo indirizzo può essere iscritto, gli abbiamo inviato le istruzioni successive.',
    'newsletter.rate_limit_confirm' => 'Troppi tentativi di conferma. Riprova più tardi.',
    'newsletter.rate_limit_unsubscribe' => 'Troppi tentativi di cancellazione. Riprova più tardi.',
    'newsletter.rate_limit_subscribe' => 'Troppi tentativi. Riprova più tardi.',
    'newsletter.error_email' => 'Inserisci un indirizzo e-mail valido.',
    'newsletter.error_generic' => 'Si è verificato un errore. Riprova più tardi.',
    'newsletter.error_mail_failed' => 'Non è stato possibile inviare l\'e-mail di conferma. Riprova più tardi.',
    'newsletter.error_domain' => 'Il dominio dell\'indirizzo e-mail non sembra valido.',
    'newsletter.error_action' => 'Azione del modulo non valida.',
    'newsletter.unsubscribe_hint' => 'Ti abbiamo inviato per e-mail il collegamento di cancellazione. Per sicurezza puoi salvarlo anche ora:',
    'newsletter.unsubscribe_hint_link' => 'cancellati dalla newsletter',
    'newsletter.mail_confirm_subject' => 'Conferma la tua iscrizione a Polascin.net',
    'newsletter.mail_confirm_body' => "Grazie per l\'interesse verso la newsletter di Polascin.net.\n\nConferma l\'iscrizione facendo clic sul collegamento (valido 48 ore):\n:url\n\nSe non hai richiesto questa iscrizione, ignora questo messaggio.",
    'newsletter.mail_welcome_subject' => 'Iscrizione a Polascin.net confermata',
    'newsletter.mail_welcome_body' => "La tua iscrizione alla newsletter di Polascin.net è stata confermata.\n\nPer cancellarti:\n:url\n\nSe non ti sei iscritto tu, usa il collegamento di cancellazione.",

    // Accesso
    'login.heading' => 'Accesso amministratore',
    'login.aria_label' => 'Accesso',
    'login.username' => 'Nome utente',
    'login.password' => 'Password',
    'login.submit' => 'Accedi',
    'login.error_credentials' => 'Nome utente o password non validi.',
    'login.error_rate_limit' => 'Troppi tentativi di accesso. Riprova più tardi.',
    'login.session_expired' => 'La sessione è scaduta per inattività. Accedi di nuovo.',
    'login.account_inactive' => 'Il tuo account non è più attivo. Accedi di nuovo.',

    // Disconnessione (i messaggi compaiono sul sito pubblico)
    'logout.success' => 'Hai effettuato la disconnessione.',
    'logout.csrf_failed' => 'Non è stato possibile verificare la disconnessione. Riprova.',

    // Errori comuni
    'error.csrf' => 'Token di sicurezza non valido. Aggiorna la pagina e riprova.',

    // Cookie (passati a JavaScript)
    'cookie.title' => 'Cookie analitici',
    'cookie.description' => 'Con il tuo consenso useremo Google Analytics 4 per misurare il traffico. L\'archiviazione pubblicitaria e la personalizzazione restano disattivate. Il rifiuto non limita l\'uso del sito. Per i dettagli consulta l\'',
    'cookie.privacy_link' => 'informativa sulla privacy',
    'cookie.decline' => 'Rifiuto',
    'cookie.accept' => 'Accetto',

    // Informativa sulla privacy
    'privacy.heading' => 'Informativa sulla privacy',
    'privacy.updated' => 'Ultimo aggiornamento: 28 luglio 2026',
    'privacy.s1_heading' => '1. Introduzione',
    'privacy.s1_text' => 'Benvenuto su <strong>polascin.net</strong>. Rispetto la tua privacy e mi impegno a proteggere i tuoi dati personali. La presente informativa spiega come tratto i tuoi dati personali quando visiti questo sito e descrive i tuoi diritti in materia di privacy e le relative tutele giuridiche.',
    'privacy.s2_heading' => '2. Informazioni che raccolgo',
    'privacy.s2_text' => 'Questo sito ha carattere prevalentemente informativo. Non è richiesta la creazione di un account.',
    'privacy.s2_technical' => '<strong>Dati tecnici:</strong> Comprendono l\'indirizzo IP (Internet Protocol), il tipo di browser, l\'indirizzo visitato, l\'orario della richiesta e i dati di base sulla risposta. Questi dati servono alla sicurezza, alla diagnostica e alla protezione dei moduli dagli abusi. I parametri sensibili dei collegamenti vengono rimossi prima della memorizzazione.',
    'privacy.s2_contact' => '<strong>Modulo di contatto:</strong> Se invii un messaggio, conservo nome, indirizzo e-mail, oggetto, testo del messaggio e orario di invio per poter rispondere.',
    'privacy.s2_newsletter' => '<strong>Newsletter:</strong> All\'iscrizione conservo l\'indirizzo e-mail, l\'orario dell\'iscrizione e le impronte crittografiche dei token necessari alla conferma e alla cancellazione.',
    'privacy.s2_cookies' => '<strong>Cookie e archiviazione locale:</strong> In locale conservo soltanto la preferenza del tema (modalità scura o chiara), la lingua scelta e la tua decisione sull\'analisi del traffico. <strong>Google Analytics 4 (GA4):</strong> Lo script di analisi non viene caricato finché non fai esplicitamente clic sul pulsante Accetto nella barra del consenso. Le categorie di consenso pubblicitarie restano disattivate. Puoi modificare la tua scelta in qualsiasi momento tramite Impostazioni dei cookie nel piè di pagina.',
    'privacy.s3_heading' => '3. Come utilizzo le tue informazioni',
    'privacy.s3_text' => 'Utilizzo i tuoi dati per:',
    'privacy.s3_item1' => 'Fornire i contenuti del sito.',
    'privacy.s3_item2' => 'Garantire la sicurezza del sito.',
    'privacy.s3_item3' => 'Ricordare la preferenza del tema, la lingua e la decisione sull\'analisi del traffico.',
    'privacy.s3_item4' => 'Gestire i messaggi di contatto e l\'iscrizione alla newsletter su tua richiesta.',
    'privacy.s3_item5' => 'Analizzare il traffico e le modalità d\'uso del sito tramite Google Analytics 4, ma solo se fai clic sul pulsante <strong>Accetto</strong> nella barra del consenso ai cookie. Base giuridica: il tuo consenso (art. 6, par. 1, lett. a, GDPR). I dati analitici sono conservati da Google secondo le proprie regole di conservazione (di norma non oltre 14 mesi). Puoi revocare il consenso in qualsiasi momento con il pulsante <strong>Impostazioni dei cookie</strong> nel piè di pagina, scegliendo <strong>Rifiuto</strong>.',
    'privacy.s4_heading' => '4. Periodo di conservazione',
    'privacy.s4_text' => 'I registri tecnici di accesso propri del sito vengono eliminati automaticamente dopo 90 giorni per impostazione predefinita; il gestore può abbreviare questo periodo. Le voci temporanee di protezione dei moduli vengono eliminate progressivamente al termine della finestra di protezione. I messaggi di contatto sono conservati solo per il tempo necessario a gestire la corrispondenza. L\'indirizzo e-mail della newsletter è conservato fino alla cancellazione.',
    'privacy.s5_heading' => '5. Collegamenti di terze parti',
    'privacy.s5_text' => 'Questo sito può contenere collegamenti a siti, plug-in e applicazioni di terze parti (per esempio Amazon o social network). Facendo clic su tali collegamenti, terze parti possono raccogliere o condividere dati che ti riguardano. Non ho alcun controllo su questi siti e non sono responsabile delle loro informative sulla privacy.',
    'privacy.s6_heading' => '6. I tuoi diritti (GDPR/CCPA)',
    'privacy.s6_text' => 'In determinate circostanze hai diritti previsti dalla normativa sulla protezione dei dati in relazione ai tuoi dati personali, tra cui il diritto di chiederne l\'accesso, la rettifica, la cancellazione o la limitazione del trattamento.',
    'privacy.s7_heading' => '7. Contatti',
    'privacy.s7_text' => 'Per qualsiasi domanda su questa informativa sulla privacy, scrivimi all\'indirizzo:',

    // Condizioni d\'uso
    'terms.heading' => 'Condizioni d\'uso',
    'terms.updated' => 'Ultimo aggiornamento: 28 luglio 2026',
    'terms.s1_heading' => '1. Accettazione delle condizioni',
    'terms.s1_text' => 'Accedendo e utilizzando il sito <strong>polascin.net</strong> (di seguito il «Sito»), accetti le condizioni e le disposizioni del presente accordo e ti impegni a rispettarle.',
    'terms.s2_heading' => '2. Avvertenza medica',
    'terms.s2_important' => '<strong>IMPORTANTE:</strong> I contenuti pubblicati su questo sito hanno finalità esclusivamente informative. <strong>Non sostituiscono</strong> il parere, la diagnosi o il trattamento di un medico.',
    'terms.s2_text' => 'Per qualsiasi dubbio relativo a una condizione di salute rivolgiti sempre al tuo medico o a un altro professionista sanitario qualificato. Non ignorare mai il parere medico professionale e non ritardare la richiesta di assistenza a causa di informazioni lette su questo sito.',
    'terms.s3_heading' => '3. Proprietà intellettuale',
    'terms.s3_text' => 'I contenuti, la struttura, la grafica, il design, la compilazione e gli altri elementi relativi a questo sito sono protetti dalle norme vigenti in materia di diritto d\'autore e proprietà intellettuale. Qualsiasi copia, ridistribuzione, utilizzo o pubblicazione di tali elementi, o di qualsiasi parte del sito, da parte degli utenti è severamente vietata.',
    'terms.s4_heading' => '4. Limitazione di responsabilità',
    'terms.s4_text' => 'In nessun caso sarò responsabile per danni incidentali, indiretti, consequenziali o speciali di qualsiasi natura, né per qualsiasi altro danno, compresi a titolo esemplificativo i danni derivanti da perdita di profitto, perdita di contratti, avviamento, dati, informazioni, ricavi, risparmi previsti o rapporti commerciali, indipendentemente dal fatto che sia stato avvertito della possibilità di tali danni, derivanti dall\'uso di questo sito o di qualsiasi sito a esso collegato o in connessione con esso.',
    'terms.s5_heading' => '5. Legge applicabile',
    'terms.s5_text' => 'Le presenti condizioni sono regolate e interpretate secondo il diritto della Repubblica Slovacca e accetti irrevocabilmente la giurisdizione esclusiva dei suoi tribunali.',

    // Amministrazione
    'admin.language' => 'Lingua',
    'admin.language_hint' => 'La lingua in cui è scritto il contenuto.',
    'admin.translation_group' => 'Gruppo di traduzione',
    'admin.translation_group_hint' => 'Lo stesso numero collega le traduzioni dello stesso articolo tra le lingue. Un campo vuoto crea un nuovo gruppo.',
];
