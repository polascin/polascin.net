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
    'nav.about' => 'Chi sono',
    'nav.nephrology' => 'Nefrologia',
    'nav.projects' => 'Progetti',
    'nav.books' => 'Libri',
    'nav.links' => 'Collegamenti',
    'nav.contact' => 'Contatti',
    'nav.admin' => 'Amministrazione',
    'nav.logout' => 'Esci',
    'nav.login' => 'Accedi',

    // Piè di pagina
    'footer.heading' => 'Contatti e profili',
    'footer.linkedin' => 'Profilo LinkedIn',
    'footer.x' => 'Profilo X',
    'footer.facebook' => 'Profilo Facebook',
    'footer.email' => 'Invia un\'e-mail',
    'footer.discord' => 'Unisciti su Discord',
    'footer.copyright' => '© 1998 – :year Ľubomír Polaščín. Tutti i diritti riservati.',
    'footer.privacy' => 'Informativa sulla privacy',
    'footer.terms' => 'Condizioni d\'uso',
    'footer.cookie_settings' => 'Impostazioni dei cookie',
    'footer.updated' => 'Aggiornato:',
    'footer.beat_title' => 'Swiss Internet Time — 1 giorno = 1000 beat',

    // Metadati delle pagine
    'meta.default_description' => 'Sito personale e professionale del dott. Ľubomír Polaščín: nefrologia e dialisi, formazione e scrittura medica, traduzione specialistica e strumenti digitali pratici.',
    'meta.home_tagline' => 'Nefrologia, formazione medica e strumenti digitali',
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
    'home.logo_alt' => 'Crystal Kidney',
    'home.hero_title' => 'Dott. Ľubomír Polaščín',
    'home.hero_subtitle' => 'Sono nefrologo e internista, formatore in ambito medico e autore. Metto la mia lunga esperienza in dialisi al servizio della scrittura specialistica, della traduzione e dello sviluppo di strumenti digitali pratici.',
    'home.cta_about' => 'Di cosa mi occupo',
    'home.cta_articles' => 'Leggi gli articoli',

    // Home — biografia
    'home.about_heading' => 'Chi sono',
    'home.about_intro' => 'Sono un medico specializzato in nefrologia e medicina interna. La mia attività professionale si è concentrata sulla dialisi e sulle malattie renali; ho diretto due centri dialisi a Bratislava e ho lavorato nella formazione medica.',
    'home.about_who' => 'Scrivo testi specialistici e letterari, traduco contenuti medici tra slovacco e inglese e sviluppo siti web e applicazioni. Valuto la tecnologia e l\'intelligenza artificiale in base al loro valore pratico: se rendono le conoscenze più accessibili, semplificano il lavoro o migliorano la qualità del risultato.',
    'home.about_synthesis' => 'Adotto un approccio simile in medicina, nel linguaggio e nel codice: definire il problema con precisione, verificare i fatti rilevanti, riconoscere l\'incertezza e creare un risultato chiaro e utilizzabile.',

    'home.areas_heading' => 'Di cosa mi occupo',
    'home.areas_medicine' => 'Nefrologia e formazione',
    'home.areas_medicine_1' => 'nefrologia e dialisi',
    'home.areas_medicine_2' => 'medicina interna',
    'home.areas_medicine_3' => 'terapia renale sostitutiva',
    'home.areas_medicine_4' => 'ecografia e gestione degli accessi vascolari',
    'home.areas_medicine_5' => 'lezioni specialistiche e formazione',
    'home.areas_language' => 'Scrittura e traduzione',
    'home.areas_language_1' => 'testi medico-scientifici',
    'home.areas_language_2' => 'traduzione medica e lavoro terminologico',
    'home.areas_language_3' => 'localizzazione di software medicale',
    'home.areas_language_4' => 'narrativa, saggi e saggistica',
    'home.areas_language_5' => 'divulgazione medica ed educazione dei pazienti',
    'home.areas_tech' => 'Progetti digitali',
    'home.areas_tech_1' => 'sviluppo di siti web e applicazioni',
    'home.areas_tech_2' => 'calcolatori medici e strumenti digitali',
    'home.areas_tech_3' => 'automazione dell\'elaborazione delle informazioni',
    'home.areas_tech_4' => 'uso critico e pratico dell\'intelligenza artificiale',
    'home.areas_tech_5' => 'software open source e sistemi Linux/Unix',

    'home.skills_heading' => 'Strumenti e tecnologie',
    'home.skills_web' => 'Tecnologie web',
    'home.skills_web_text' => 'HTML5, CSS3, JavaScript, TypeScript, PHP, React, Vue, Node.js',
    'home.skills_data' => 'Programmazione e dati',
    'home.skills_data_text' => 'Python, C#, .NET, SQL, database ed elaborazione dei dati',
    'home.skills_systems' => 'Sistemi e infrastruttura',
    'home.skills_systems_text' => 'Linux, Unix, Windows, macOS, iOS, iPadOS, Android, Docker, Git, software libero e open source',
    'home.skills_ai' => 'Intelligenza artificiale',
    'home.skills_ai_text' => 'Modelli linguistici, automazione e valutazione critica del loro impiego in medicina',

    'home.education_heading' => 'Formazione e percorso professionale',
    'home.education_school' => 'Ho concluso il liceo a indirizzo programmazione nel 1989 — all\'epoca si programmava in Basic e Pascal — e ho vinto anche una gara distrettuale di programmazione.',
    'home.education_text' => 'Mi sono laureato in Medicina e Chirurgia presso l\'Università Pavol Jozef Šafárik di Košice nel 1995. Ho conseguito la specializzazione in medicina interna nel 1998 e in nefrologia nel 2009, anno in cui ho ottenuto anche la certificazione in ecografia addominale dell\'adulto.',
    'home.education_path' => 'Lavoro nella dialisi e nella nefrologia dal 1995. In seguito ho diretto due centri dialisi a Bratislava e ho lavorato nella formazione medica.',
    'home.education_scope' => 'La mia esperienza professionale comprende l\'emodialisi, l\'emodiafiltrazione, la dialisi peritoneale, la dialisi epatica con il sistema Prometheus, le metodiche depurative extracorporee in acuto, l\'ecografia, la gestione degli accessi vascolari e la preparazione dei pazienti al trapianto di rene. Unisco questa esperienza alla scrittura specialistica, all\'attività di relatore, alla didattica e alla realizzazione di progetti digitali in ambito medico.',

    'home.personal_heading' => 'Oltre la medicina',
    'home.personal_text' => 'Mi interessano la letteratura, la filosofia, la poesia e i viaggi. Anche le lingue straniere mi stanno a cuore — è anche per questo che il sito è disponibile in dieci lingue — e dedico il tempo libero alla lettura, alla traduzione e alla programmazione dei miei progetti.',
    'home.personal_writing' => 'Nei miei libri e negli altri scritti torno alla medicina, ai conflitti morali e al rapporto tra le persone e la tecnologia. Pubblico i testi specialistici con il mio nome, mentre le opere letterarie escono anche con lo pseudonimo Walter Kyo Csoelle — il cui profilo d\'autore è disponibile su Amazon.',

    'home.identity_nephrologist' => 'Nefrologo',
    'home.identity_internist' => 'Internista',

    'home.books_cta' => 'Vedi i libri',
    'home.amazon_cta' => 'Profilo autore su Amazon',

    // Home — nefrologia
    'home.nephrology_heading' => 'La nefrologia in breve',
    'home.nephrology_intro' => 'La nefrologia non riguarda soltanto la dialisi. Unisce prevenzione, diagnosi precoce e trattamento a lungo termine delle malattie renali alla terapia renale sostitutiva quando il trattamento conservativo non è più sufficiente.',
    'home.ckd_title' => 'Malattia renale cronica (MRC)',
    'home.ckd_text' => 'La malattia renale cronica è un danno renale di lunga durata o una riduzione persistente della funzione renale. Spesso si accompagna al diabete o all\'ipertensione e richiede controlli regolari, il trattamento delle cause e misure per limitarne l\'ulteriore peggioramento.',
    'home.aki_title' => 'Danno renale acuto (AKI)',
    'home.aki_text' => 'Il danno renale acuto è una perdita improvvisa della funzione renale. Può manifestarsi durante una malattia grave, per disidratazione, ostruzione urinaria o esposizione a determinati farmaci e sostanze tossiche.',
    'home.hemodialysis_title' => 'Emodialisi',
    'home.hemodialysis_text' => 'Durante l\'emodialisi il sangue passa attraverso un dializzatore, che rimuove le scorie e i liquidi in eccesso e contribuisce a ripristinare l\'equilibrio interno dell\'organismo.',
    'home.peritoneal_title' => 'Dialisi peritoneale',
    'home.peritoneal_text' => 'La dialisi peritoneale utilizza il rivestimento dell\'addome come membrana dialitica naturale. Il liquido di dialisi viene introdotto nella cavità addominale e drenato dopo il tempo di permanenza prescritto.',
    'home.transplant_title' => 'Trapianto',
    'home.transplant_text' => 'Nei pazienti idonei, il trapianto di rene può offrire una sopravvivenza e una qualità di vita migliori rispetto alla dialisi a lungo termine. Richiede una valutazione accurata, controlli per tutta la vita e una terapia immunosoppressiva.',
    'home.diagnostics_title' => 'Diagnostica',
    'home.diagnostics_text' => 'La diagnosi si basa su anamnesi, esame obiettivo, analisi del sangue e delle urine e diagnostica per immagini. Si esegue una biopsia renale quando clinicamente indicata.',
    'home.nephrology_note' => 'Queste informazioni hanno finalità educative e non sostituiscono una visita medica o una consulenza individuale.',

    // Home — articoli, progetti, collegamenti, contatti
    'home.latest_heading' => 'Ultimi articoli',
    'home.all_articles' => 'Vedi tutti gli articoli',
    'home.projects_heading' => 'Progetti selezionati',
    'home.projects_intro' => 'Progetti che creo o mantengo nel tempo nei campi della medicina, della formazione e della tecnologia.',
    'home.project_nefro_text' => 'Portale in lingua slovacca con articoli specialistici, aggiornamenti clinici, calcolatori, materiale di riferimento sui farmaci e risorse di studio in nefrologia.',
    'home.project_nephrosite_text' => 'Archivio in lingua slovacca di lezioni e materiali di riferimento su nefrologia, dialisi, metodi di depurazione del sangue e medicina interna.',
    'home.project_books_text' => 'Una panoramica dei miei libri, delle pubblicazioni specialistiche, dei capitoli e degli altri scritti.',
    'home.project_alphagrab_text' => 'Strumento sperimentale per la ricerca di eventi e biglietti che utilizza la Ticketmaster Discovery API.',
    'home.project_arenibus_text' => 'Un sistema informativo .NET in fase avanzata di sviluppo per cliniche nefrologiche e centri dialisi. Il suo MVP comprende le cartelle dei pazienti e le registrazioni delle visite, le prescrizioni dialitiche, la pianificazione, i risultati di laboratorio, le tracce di audit e l’integrazione con il sistema eHealth slovacco; una demo pubblica utilizza dati fittizi.',
    'home.project_gumroad_text' => 'Prodotti digitali ed e-book su Gumroad — tra cui Medical Fasting (in slovacco Medicínsky pôst), un manuale di sicurezza sul digiuno scritto da un nefrologo con il protocollo Nephro-Safe Neera 2.0.',
    'home.clinics_heading' => 'Strutture cliniche',
    'home.links_heading' => 'Altri siti web e collegamenti',
    'home.links_intro' => 'I miei altri siti web, i miei libri e una selezione di strumenti.',
    'home.link_nephrosite' => 'NephroSite (in slovacco)',
    'home.link_dialysis_bratislava' => 'Dialisi a Bratislava – Medimpax (in slovacco)',
    'home.link_impax_centres' => 'Centri dialisi IMPAX (in slovacco)',
    'home.link_vital_2nd' => 'Vital Algorithm — 2ª edizione (Amazon)',
    'home.link_vital_1st' => 'The Vital Algorithm — 1ª edizione (Amazon)',
    'home.contact_heading' => 'Contatti',
    'home.contact_intro' => 'Per una collaborazione professionale, una lezione, una traduzione medica o un progetto digitale, inviami un messaggio. Questo contatto non è destinato a quesiti medici urgenti.',
    'home.contact_cta' => 'Apri il modulo di contatto',

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
    'contact.success' => 'Grazie. Il tuo messaggio è stato inviato.',
    'contact.error_name' => 'Inserisci un nome valido.',
    'contact.error_email' => 'Inserisci un indirizzo e-mail valido.',
    'contact.error_subject' => 'L\'oggetto è troppo lungo.',
    'contact.error_message' => 'Inserisci un messaggio (max 5000 caratteri).',
    'contact.error_rate_limit' => 'Troppi messaggi da questo indirizzo. Riprova più tardi.',
    'contact.error_save' => 'Non è stato possibile inviare il messaggio. Riprova più tardi.',

    // Newsletter
    'newsletter.heading' => 'Newsletter',
    'newsletter.aria_label' => 'Iscrizione alla newsletter',
    'newsletter.intro' => 'Iscriviti per ricevere via e-mail aggiornamenti su nuovi articoli, libri e progetti.',
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
    'cookie.description' => 'Con il tuo consenso, uso Google Analytics 4 per misurare le visite. Il sistema di analisi non viene caricato senza consenso e le funzionalità pubblicitarie restano disattivate. Per i dettagli consulta l\'',
    'cookie.privacy_link' => 'informativa sulla privacy',
    'cookie.decline' => 'Rifiuta',
    'cookie.accept' => 'Consenti analisi del traffico',

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
    'privacy.s2_cookies' => '<strong>Cookie e archiviazione locale:</strong> In locale conservo soltanto la preferenza del tema (modalità scura o chiara), la lingua scelta e la tua decisione sull\'analisi del traffico. <strong>Google Analytics 4 (GA4):</strong> Lo script di analisi non viene caricato finché non fai esplicitamente clic sul pulsante Consenti analisi del traffico nella barra del consenso. Le categorie di consenso pubblicitarie restano disattivate. Puoi modificare la tua scelta in qualsiasi momento tramite Impostazioni dei cookie nel piè di pagina.',
    'privacy.s3_heading' => '3. Come utilizzo le tue informazioni',
    'privacy.s3_text' => 'Utilizzo i tuoi dati per:',
    'privacy.s3_item1' => 'Fornire i contenuti del sito.',
    'privacy.s3_item2' => 'Garantire la sicurezza del sito.',
    'privacy.s3_item3' => 'Ricordare la preferenza del tema, la lingua e la decisione sull\'analisi del traffico.',
    'privacy.s3_item4' => 'Gestire i messaggi di contatto e l\'iscrizione alla newsletter su tua richiesta.',
    'privacy.s3_item5' => 'Analizzare il traffico e le modalità d\'uso del sito tramite Google Analytics 4, ma solo se fai clic sul pulsante <strong>Consenti analisi del traffico</strong> nella barra del consenso ai cookie. Base giuridica: il tuo consenso (art. 6, par. 1, lett. a, GDPR). I dati analitici sono conservati da Google secondo le proprie regole di conservazione (di norma non oltre 14 mesi). Puoi revocare il consenso in qualsiasi momento con il pulsante <strong>Impostazioni dei cookie</strong> nel piè di pagina, scegliendo <strong>Rifiuta</strong>.',
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
