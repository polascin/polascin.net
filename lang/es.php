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
 * Catálogo de traducciones al español.
 *
 * Las claves son identificadores estables, no textos. Los marcadores de posición
 * se escriben como `:nombre`. Los idiomas se derivan del catálogo eslovaco;
 * una clave que falte aquí recae automáticamente en el archivo eslovaco.
 */
return [
    // Selector de idioma
    'lang.switch' => 'Idioma',
    'lang.switch_aria' => 'Seleccionar el idioma del sitio',
    'lang.current' => 'Idioma actual: :language',

    // Elementos comunes de la interfaz
    'common.site_name' => 'Polascin.net',
    'common.author' => 'Dr. Ľubomír Polaščín',
    'common.author_short' => 'Ľubomír Polaščín',
    'common.skip_to_content' => 'Saltar al contenido principal',
    'common.main_navigation' => 'Navegación principal',
    'common.main_content' => 'Contenido principal',
    'common.open_navigation' => 'Abrir la navegación',
    'common.close_navigation' => 'Cerrar la navegación',
    'common.toggle_dark_mode' => 'Alternar el modo oscuro',
    'common.switch_to_dark' => 'Cambiar al modo oscuro',
    'common.switch_to_light' => 'Cambiar al modo claro',
    'common.required' => 'obligatorio',
    'common.back' => 'Volver',
    'common.read_more' => 'Leer más',
    'common.visit' => 'Visitar :target',
    'common.opens_new_tab' => 'se abre en una pestaña nueva',
    'common.author_meta_prefix' => 'Autor',

    // Navegación
    'nav.home' => 'Inicio',
    'nav.blog' => 'Blog',
    'nav.about' => 'Sobre mí',
    'nav.nephrology' => 'Nefrología',
    'nav.projects' => 'Proyectos',
    'nav.books' => 'Libros',
    'nav.links' => 'Enlaces',
    'nav.contact' => 'Contacto',
    'nav.admin' => 'Administración',
    'nav.logout' => 'Cerrar sesión',
    'nav.login' => 'Iniciar sesión',

    // Pie de página
    'footer.heading' => 'Contacto y perfiles',
    'footer.linkedin' => 'Perfil en LinkedIn',
    'footer.x' => 'Perfil en X',
    'footer.facebook' => 'Perfil en Facebook',
    'footer.email' => 'Enviar un correo electrónico',
    'footer.discord' => 'Unirse a Discord',
    'footer.copyright' => '© 1998 – :year Ľubomír Polaščín. Todos los derechos reservados.',
    'footer.privacy' => 'Política de privacidad',
    'footer.terms' => 'Condiciones de uso',
    'footer.cookie_settings' => 'Configuración de cookies',
    'footer.updated' => 'Actualizado:',
    'footer.beat_title' => 'Swiss Internet Time — 1 día = 1000 beats',

    // Metadatos de las páginas
    'meta.default_description' => 'Sitio web personal y profesional del Dr. Ľubomír Polaščín: nefrología y diálisis, formación y escritura médicas, traducción especializada y herramientas digitales prácticas.',
    'meta.home_tagline' => 'Nefrología, formación médica y herramientas digitales',
    'meta.articles_title' => 'Artículos',
    'meta.articles_description' => 'Últimos artículos y reflexiones del Dr. Ľubomír Polaščín sobre nefrología, medicina interna, tecnología y escritura.',
    'meta.articles_404_title' => 'Página de artículos no encontrada',
    'meta.articles_404_description' => 'La página solicitada del listado de artículos no existe.',
    'meta.article_404_title' => 'No encontrado',
    'meta.article_404_description' => 'No se ha encontrado el artículo.',
    'meta.contact_title' => 'Contacto',
    'meta.contact_description' => 'Póngase en contacto con el Dr. Ľubomír Polaščín para consultas profesionales, propuestas de colaboración o cualquier pregunta.',
    'meta.newsletter_title' => 'Newsletter',
    'meta.newsletter_description' => 'Suscríbase al Newsletter de Polascin.net — novedades sobre nefrología, medicina interna, libros y tecnología.',
    'meta.login_title' => 'Iniciar sesión',
    'meta.login_description' => 'Acceso de administrador en Polascin.net.',
    'meta.privacy_title' => 'Política de privacidad',
    'meta.privacy_description' => 'Política de privacidad del sitio web del Dr. Ľubomír Polaščín.',
    'meta.terms_title' => 'Condiciones de uso',
    'meta.terms_description' => 'Condiciones de uso del sitio web del Dr. Ľubomír Polaščín.',

    // Página de inicio — sección principal
    'home.logo_alt' => 'Crystal Kidney',
    'home.hero_title' => 'Dr. Ľubomír Polaščín',
    'home.hero_subtitle' => 'Soy nefrólogo e internista, docente en medicina y autor. Pongo mi larga experiencia en diálisis al servicio de la escritura especializada, la traducción y el desarrollo de herramientas digitales prácticas.',
    'home.cta_about' => 'A qué me dedico',
    'home.cta_articles' => 'Leer artículos',

    // Página de inicio — biografía
    'home.about_heading' => 'Sobre mí',
    'home.about_intro' => 'Soy médico especializado en nefrología y medicina interna. Mi actividad profesional se ha centrado en la diálisis y las enfermedades renales; he dirigido dos centros de diálisis en Bratislava y he trabajado en formación médica.',
    'home.about_who' => 'Escribo textos especializados y literarios, traduzco contenidos médicos entre el eslovaco y el inglés y desarrollo sitios web y aplicaciones. Valoro la tecnología y la inteligencia artificial por su utilidad práctica: si hacen más accesible el conocimiento, simplifican el trabajo o mejoran la calidad del resultado.',
    'home.about_synthesis' => 'Aplico un enfoque similar a la medicina, el lenguaje y el código: definir el problema con precisión, verificar los hechos relevantes, reconocer la incertidumbre y crear un resultado claro y útil.',

    'home.areas_heading' => 'Qué hago',
    'home.areas_medicine' => 'Nefrología y formación',
    'home.areas_medicine_1' => 'nefrología y diálisis',
    'home.areas_medicine_2' => 'medicina interna',
    'home.areas_medicine_3' => 'terapia renal sustitutiva',
    'home.areas_medicine_4' => 'ecografía y cuidado de los accesos vasculares',
    'home.areas_medicine_5' => 'conferencias especializadas y formación',
    'home.areas_language' => 'Escritura y traducción',
    'home.areas_language_1' => 'textos médicos especializados',
    'home.areas_language_2' => 'traducción médica y trabajo terminológico',
    'home.areas_language_3' => 'localización de software médico',
    'home.areas_language_4' => 'narrativa, ensayo y no ficción',
    'home.areas_language_5' => 'divulgación médica y educación de pacientes',
    'home.areas_tech' => 'Proyectos digitales',
    'home.areas_tech_1' => 'desarrollo de sitios web y aplicaciones',
    'home.areas_tech_2' => 'calculadoras médicas y herramientas digitales',
    'home.areas_tech_3' => 'automatización del procesamiento de la información',
    'home.areas_tech_4' => 'uso crítico y práctico de la inteligencia artificial',
    'home.areas_tech_5' => 'software de código abierto y sistemas Linux/Unix',

    'home.skills_heading' => 'Herramientas y tecnología',
    'home.skills_web' => 'Tecnologías web',
    'home.skills_web_text' => 'HTML5, CSS3, JavaScript, TypeScript, PHP, React, Vue, Node.js',
    'home.skills_data' => 'Programación y datos',
    'home.skills_data_text' => 'Python, C#, .NET, SQL, bases de datos y procesamiento de datos',
    'home.skills_systems' => 'Sistemas e infraestructura',
    'home.skills_systems_text' => 'Linux, Unix, Windows, macOS, iOS, iPadOS, Android, Docker, Git, software libre y de código abierto',
    'home.skills_ai' => 'Inteligencia artificial',
    'home.skills_ai_text' => 'Modelos de lenguaje, automatización y evaluación crítica de su uso en medicina',

    'home.education_heading' => 'Formación y trayectoria',
    'home.education_school' => 'Terminé el bachillerato con especialización en programación en 1989, entonces en los lenguajes Basic y Pascal, y gané también un concurso de programación a nivel de distrito.',
    'home.education_text' => 'Me gradué en Medicina en la Universidad Pavol Jozef Šafárik de Košice en 1995. Obtuve la especialización en medicina interna en 1998 y en nefrología en 2009, año en el que también obtuve la certificación en ecografía abdominal en adultos.',
    'home.education_path' => 'Trabajo en diálisis y nefrología desde 1995. Posteriormente dirigí dos centros de diálisis en Bratislava y trabajé en formación médica.',
    'home.education_scope' => 'Mi experiencia profesional abarca la hemodiálisis, la hemodiafiltración, la diálisis peritoneal, la diálisis hepática con el sistema Prometheus, las técnicas de depuración extrarrenal en situaciones agudas, la ecografía, el cuidado de los accesos vasculares y la preparación de pacientes para el trasplante renal. Combino esta experiencia con la escritura especializada, las ponencias, la docencia y el desarrollo de proyectos digitales en medicina.',

    'home.personal_heading' => 'Más allá de la medicina',
    'home.personal_text' => 'Me interesan la literatura, la filosofía, la poesía y los viajes. También me atraen los idiomas — por eso, entre otras razones, este sitio está disponible en diez de ellos — y dedico mi tiempo libre a la lectura, la traducción y la programación de mis propios proyectos.',
    'home.personal_writing' => 'En mis libros y otros escritos vuelvo a la medicina, los conflictos morales y la relación entre las personas y la tecnología. Publico los textos especializados con mi propio nombre, mientras que mi obra literaria aparece también bajo el seudónimo Walter Kyo Csoelle, cuyo perfil de autor está disponible en Amazon.',

    'home.identity_nephrologist' => 'Nefrólogo',
    'home.identity_internist' => 'Internista',

    'home.books_cta' => 'Ver libros',
    'home.amazon_cta' => 'Perfil de autor en Amazon',

    // Página de inicio — nefrología
    'home.nephrology_heading' => 'La nefrología en breve',
    'home.nephrology_intro' => 'La nefrología no se limita a la diálisis. Combina la prevención, el diagnóstico precoz y el tratamiento a largo plazo de las enfermedades renales con la terapia renal sustitutiva cuando el tratamiento conservador ya no es suficiente.',
    'home.ckd_title' => 'Enfermedad renal crónica (ERC)',
    'home.ckd_text' => 'La enfermedad renal crónica es un daño renal prolongado o una reducción persistente de la función renal. A menudo se asocia con la diabetes o la hipertensión y requiere controles regulares, el tratamiento de sus causas y medidas para reducir un mayor deterioro.',
    'home.aki_title' => 'Lesión renal aguda (LRA)',
    'home.aki_text' => 'La lesión renal aguda es una pérdida repentina de la función renal. Puede aparecer durante una enfermedad grave, por deshidratación, obstrucción urinaria o exposición a determinados medicamentos y sustancias tóxicas.',
    'home.hemodialysis_title' => 'Hemodiálisis',
    'home.hemodialysis_text' => 'Durante la hemodiálisis, la sangre pasa por un dializador que elimina los productos de desecho y el exceso de líquido y ayuda a restablecer el equilibrio interno del organismo.',
    'home.peritoneal_title' => 'Diálisis peritoneal',
    'home.peritoneal_text' => 'La diálisis peritoneal utiliza el revestimiento del abdomen como membrana natural de diálisis. El líquido de diálisis se introduce en la cavidad abdominal y se drena después del tiempo de permanencia prescrito.',
    'home.transplant_title' => 'Trasplante',
    'home.transplant_text' => 'En pacientes aptos, el trasplante renal puede ofrecer una mayor supervivencia y calidad de vida que la diálisis a largo plazo. Requiere una evaluación cuidadosa, seguimiento de por vida y tratamiento inmunosupresor.',
    'home.diagnostics_title' => 'Diagnóstico',
    'home.diagnostics_text' => 'El diagnóstico se basa en la historia clínica, la exploración física, los análisis de sangre y orina y las pruebas de imagen. Se realiza una biopsia renal cuando está clínicamente indicada.',
    'home.nephrology_note' => 'Esta información es educativa y no sustituye una exploración médica ni el asesoramiento individual.',

    // Página de inicio — artículos, proyectos, enlaces, contacto
    'home.latest_heading' => 'Últimos artículos',
    'home.all_articles' => 'Ver todos los artículos',
    'home.projects_heading' => 'Proyectos seleccionados',
    'home.projects_intro' => 'Proyectos que creo o mantengo a largo plazo en los ámbitos de la medicina, la formación y la tecnología.',
    'home.project_nefro_text' => 'Portal en eslovaco con artículos especializados, actualizaciones clínicas, calculadoras, material de referencia sobre medicamentos y recursos de estudio en nefrología.',
    'home.project_nephrosite_text' => 'Archivo en eslovaco de clases y materiales de referencia sobre nefrología, diálisis, métodos de depuración de la sangre y medicina interna.',
    'home.project_books_text' => 'Una visión general de mis libros, publicaciones especializadas, capítulos y otros escritos.',
    'home.project_alphagrab_text' => 'Herramienta experimental de búsqueda de eventos y entradas que utiliza la API Ticketmaster Discovery.',
    'home.project_arenibus_text' => 'Un sistema de información .NET en una fase avanzada de desarrollo para clínicas de nefrología y centros de diálisis. Su MVP abarca los registros de pacientes y visitas, las prescripciones de diálisis, la programación, los resultados de laboratorio, las trazas de auditoría y la integración con el sistema eHealth de Eslovaquia; una demostración pública utiliza datos ficticios.',
    'home.project_gumroad_text' => 'Productos digitales y libros electrónicos en Gumroad — entre otros Medical Fasting (en eslovaco Medicínsky pôst), un manual de seguridad sobre el ayuno escrito por un nefrólogo con el protocolo Nephro-Safe Neera 2.0.',
    'home.clinics_heading' => 'Centros clínicos',
    'home.links_heading' => 'Otros sitios web y enlaces',
    'home.links_intro' => 'Mis otros sitios web, libros y una selección de herramientas.',
    'home.link_nephrosite' => 'NephroSite (en eslovaco)',
    'home.link_dialysis_bratislava' => 'Diálisis en Bratislava – Medimpax (en eslovaco)',
    'home.link_impax_centres' => 'Centros de diálisis IMPAX (en eslovaco)',
    'home.link_vital_2nd' => 'Vital Algorithm — 2.ª edición (Amazon)',
    'home.link_vital_1st' => 'The Vital Algorithm — 1.ª edición (Amazon)',
    'home.contact_heading' => 'Contacto',
    'home.contact_intro' => 'Para una colaboración profesional, una conferencia, una traducción médica o un proyecto digital, envíeme un mensaje. Este contacto no está destinado a consultas médicas urgentes.',
    'home.contact_cta' => 'Abrir el formulario de contacto',

    // Listado de artículos
    'articles.heading' => 'Artículos',
    'articles.aria_label' => 'Artículos',
    'articles.empty' => 'Todavía no se ha publicado ningún artículo.',
    'articles.page_missing' => 'La página solicitada no existe.',
    'articles.go_first_page' => 'Ir a la primera página de artículos',
    'articles.pagination_label' => 'Paginación de artículos',
    'articles.no_translation' => 'Este artículo todavía no está disponible en el idioma seleccionado. Se muestra la versión original.',

    // Detalle del artículo
    'article.aria_label' => 'Contenido del artículo',
    'article.not_found_aria' => 'Artículo no encontrado',
    'article.not_found_heading' => 'Artículo no encontrado',
    'article.not_found_text' => 'El artículo solicitado no existe o no está publicado.',
    'article.back_to_list' => 'Volver a los artículos',
    'article.admin_preview' => 'Vista previa de administrador — este artículo todavía no está disponible públicamente.',
    'article.available_in' => 'Disponible también en:',

    // Formulario de contacto
    'contact.heading' => 'Contacto',
    'contact.aria_label' => 'Formulario de contacto',
    'contact.name' => 'Nombre',
    'contact.email' => 'Correo electrónico',
    'contact.subject' => 'Asunto',
    'contact.message' => 'Mensaje',
    'contact.submit' => 'Enviar mensaje',
    'contact.success' => 'Gracias. Su mensaje ha sido enviado.',
    'contact.error_name' => 'Por favor, introduzca un nombre válido.',
    'contact.error_email' => 'Por favor, introduzca una dirección de correo electrónico válida.',
    'contact.error_subject' => 'El asunto es demasiado largo.',
    'contact.error_message' => 'Por favor, escriba un mensaje (máximo 5000 caracteres).',
    'contact.error_rate_limit' => 'Demasiados mensajes desde esta dirección. Inténtelo de nuevo más tarde.',
    'contact.error_save' => 'No se ha podido enviar el mensaje. Inténtelo de nuevo más tarde.',

    // Newsletter
    'newsletter.heading' => 'Newsletter',
    'newsletter.aria_label' => 'Suscripción al Newsletter',
    'newsletter.intro' => 'Suscríbase para recibir por correo electrónico novedades sobre nuevos artículos, libros y proyectos.',
    'newsletter.email' => 'Dirección de correo electrónico',
    'newsletter.subscribe' => 'Suscribirse',
    'newsletter.confirm_unsubscribe' => 'Confirmar la baja',
    'newsletter.unsubscribe_prompt' => 'Confirme que desea darse de baja del Newsletter.',
    'newsletter.unsubscribe_link_invalid' => 'El enlace de baja no es válido.',
    'newsletter.unsubscribe_link_used' => 'El enlace de baja no es válido o ya se ha utilizado.',
    'newsletter.unsubscribed' => 'Se ha dado de baja correctamente.',
    'newsletter.confirm_link_used' => 'El enlace de confirmación no es válido o ya se ha utilizado.',
    'newsletter.confirmed' => 'Su suscripción ha sido confirmada. ¡Gracias!',
    'newsletter.pending' => 'Si esta dirección puede suscribirse, le hemos enviado instrucciones adicionales.',
    'newsletter.rate_limit_confirm' => 'Demasiados intentos de confirmación. Inténtelo de nuevo más tarde.',
    'newsletter.rate_limit_unsubscribe' => 'Demasiados intentos de baja. Inténtelo de nuevo más tarde.',
    'newsletter.rate_limit_subscribe' => 'Demasiados intentos. Inténtelo de nuevo más tarde.',
    'newsletter.error_email' => 'Por favor, introduzca una dirección de correo electrónico válida.',
    'newsletter.error_generic' => 'Se ha producido un error. Inténtelo de nuevo más tarde.',
    'newsletter.error_mail_failed' => 'No se ha podido enviar el correo de confirmación. Inténtelo de nuevo más tarde.',
    'newsletter.error_domain' => 'El dominio de la dirección de correo no parece válido.',
    'newsletter.error_action' => 'Acción de formulario no válida.',
    'newsletter.unsubscribe_hint' => 'Le hemos enviado el enlace de baja por correo electrónico. Por si acaso, puede guardarlo también ahora:',
    'newsletter.unsubscribe_hint_link' => 'darse de baja del Newsletter',
    'newsletter.mail_confirm_subject' => 'Confirme su suscripción a Polascin.net',
    'newsletter.mail_confirm_body' => "Gracias por su interés en el Newsletter de Polascin.net.\n\nConfirme la suscripción haciendo clic en el siguiente enlace (válido durante 48 horas):\n:url\n\nSi usted no ha solicitado esta suscripción, ignore este correo.",
    'newsletter.mail_welcome_subject' => 'Confirmación de la suscripción a Polascin.net',
    'newsletter.mail_welcome_body' => "Su suscripción al Newsletter de Polascin.net ha sido confirmada.\n\nBaja de la suscripción:\n:url\n\nSi usted no ha solicitado esta suscripción, utilice el enlace de baja.",

    // Inicio de sesión
    'login.heading' => 'Acceso de administrador',
    'login.aria_label' => 'Inicio de sesión',
    'login.username' => 'Nombre de usuario',
    'login.password' => 'Contraseña',
    'login.submit' => 'Iniciar sesión',
    'login.error_credentials' => 'Nombre de usuario o contraseña no válidos.',
    'login.error_rate_limit' => 'Demasiados intentos de inicio de sesión. Inténtelo de nuevo más tarde.',
    'login.session_expired' => 'Su sesión ha caducado por inactividad. Inicie sesión de nuevo.',
    'login.account_inactive' => 'Su cuenta ya no está activa. Inicie sesión de nuevo.',

    // Cierre de sesión (los mensajes se muestran en el sitio público)
    'logout.success' => 'Ha cerrado la sesión.',
    'logout.csrf_failed' => 'No se ha podido verificar el cierre de sesión. Inténtelo de nuevo.',

    // Errores comunes
    'error.csrf' => 'Token de seguridad no válido. Actualice la página e inténtelo de nuevo.',

    // Cookies (se envía a JavaScript)
    'cookie.title' => 'Cookies analíticas',
    'cookie.description' => 'Con su consentimiento, utilizo Google Analytics 4 para medir las visitas. El sistema de analítica no se cargará sin consentimiento y las funciones publicitarias permanecerán desactivadas. Encontrará los detalles en la',
    'cookie.privacy_link' => 'política de privacidad',
    'cookie.decline' => 'Rechazar',
    'cookie.accept' => 'Permitir analítica',

    // Política de privacidad
    'privacy.heading' => 'Política de privacidad',
    'privacy.updated' => 'Última actualización: 28 de julio de 2026',
    'privacy.s1_heading' => '1. Introducción',
    'privacy.s1_text' => 'Bienvenido a <strong>polascin.net</strong>. Respeto su privacidad y me comprometo a proteger sus datos personales. Esta política de privacidad explica cómo trato sus datos personales cuando visita este sitio web y describe sus derechos en materia de protección de datos, así como la tutela legal correspondiente.',
    'privacy.s2_heading' => '2. Información que recopilo',
    'privacy.s2_text' => 'Este sitio web tiene un carácter fundamentalmente informativo. No le exijo que cree ninguna cuenta.',
    'privacy.s2_technical' => '<strong>Datos técnicos:</strong> Incluyen la dirección de protocolo de internet (IP), el tipo de navegador, la dirección visitada, la hora de la solicitud y datos básicos sobre la respuesta. Estos datos se utilizan para la seguridad, el diagnóstico y la protección de los formularios frente a usos abusivos. Los parámetros sensibles de los enlaces se eliminan antes de su almacenamiento.',
    'privacy.s2_contact' => '<strong>Formulario de contacto:</strong> Si envía un mensaje, conservaré su nombre, su dirección de correo electrónico, el asunto, el texto del mensaje y la hora de envío, con el fin de poder responderle.',
    'privacy.s2_newsletter' => '<strong>Newsletter:</strong> Al suscribirse conservaré la dirección de correo electrónico, la hora de la suscripción y las huellas criptográficas de los tokens necesarios para confirmar la suscripción y para darse de baja.',
    'privacy.s2_cookies' => '<strong>Cookies y almacenamiento local:</strong> De forma local guardo únicamente la preferencia de tema (modo oscuro o claro), el idioma seleccionado y su decisión sobre la analítica. <strong>Google Analytics 4 (GA4):</strong> El script analítico no se carga mientras no haga clic expresamente en el botón Permitir analítica de la barra de consentimiento. Las categorías publicitarias del consentimiento permanecen desactivadas. Puede cambiar su decisión en cualquier momento mediante la Configuración de cookies del pie de página.',
    'privacy.s3_heading' => '3. Cómo utilizo su información',
    'privacy.s3_text' => 'Utilizo sus datos para:',
    'privacy.s3_item1' => 'Ofrecer el contenido del sitio web.',
    'privacy.s3_item2' => 'Garantizar la seguridad del sitio web.',
    'privacy.s3_item3' => 'Recordar la preferencia de tema, el idioma y la decisión sobre la analítica.',
    'privacy.s3_item4' => 'Tramitar los mensajes de contacto y gestionar la suscripción al Newsletter a petición suya.',
    'privacy.s3_item5' => 'Analizar el tráfico y la forma de uso del sitio web mediante Google Analytics 4, pero únicamente en caso de que haga clic en el botón <strong>Permitir analítica</strong> de la barra de consentimiento de cookies. Base jurídica: su consentimiento (artículo 6, apartado 1, letra a), del RGPD). Google conserva los datos analíticos conforme a sus propias normas de conservación (habitualmente, 14 meses como máximo). Puede retirar su consentimiento en cualquier momento a través del botón <strong>Configuración de cookies</strong> del pie de página, seleccionando la opción <strong>Rechazar</strong>.',
    'privacy.s4_heading' => '4. Plazo de conservación',
    'privacy.s4_text' => 'Los registros técnicos de acceso propios del sitio web se eliminan automáticamente a los 90 días de forma predeterminada; el responsable puede acortar ese plazo. Los registros de corta duración de la protección de los formularios se eliminan de manera continua una vez transcurrida la ventana de protección. Los mensajes de contacto los conservo solo durante el tiempo necesario para atender la comunicación. La dirección de correo del Newsletter la conservo hasta la baja de la suscripción.',
    'privacy.s5_heading' => '5. Enlaces de terceros',
    'privacy.s5_text' => 'Este sitio web puede contener enlaces a sitios web, complementos y aplicaciones de terceros (por ejemplo, Amazon o redes sociales). Al hacer clic en esos enlaces, dichos terceros pueden recopilar o compartir datos sobre usted. No tengo ningún control sobre esos sitios web de terceros y no soy responsable de sus declaraciones de privacidad.',
    'privacy.s6_heading' => '6. Sus derechos legales (RGPD/CCPA)',
    'privacy.s6_text' => 'En determinadas circunstancias, la normativa de protección de datos le reconoce derechos en relación con sus datos personales, entre ellos el derecho a solicitar el acceso, la rectificación, la supresión o la limitación del tratamiento de sus datos personales.',
    'privacy.s7_heading' => '7. Contacto',
    'privacy.s7_text' => 'Si tiene alguna pregunta relacionada con esta política de privacidad, escríbame a la dirección:',

    // Condiciones de uso
    'terms.heading' => 'Condiciones de uso',
    'terms.updated' => 'Última actualización: 28 de julio de 2026',
    'terms.s1_heading' => '1. Aceptación de las condiciones',
    'terms.s1_text' => 'Al acceder al sitio web <strong>polascin.net</strong> (en adelante, «el sitio web») y utilizarlo, usted acepta los términos y condiciones del presente acuerdo y se compromete a quedar vinculado por ellos.',
    'terms.s2_heading' => '2. Exención de responsabilidad médica',
    'terms.s2_important' => '<strong>IMPORTANTE:</strong> El contenido ofrecido en este sitio web tiene una finalidad exclusivamente informativa. <strong>No sustituye</strong> el consejo médico profesional, el diagnóstico ni el tratamiento.',
    'terms.s2_text' => 'Ante cualquier duda relativa a su estado de salud, consulte siempre a su médico o a otro profesional sanitario cualificado. No desestime nunca el consejo médico profesional ni retrase la búsqueda de asistencia médica por algo que haya leído en este sitio web.',
    'terms.s3_heading' => '3. Propiedad intelectual',
    'terms.s3_text' => 'El contenido, la estructura, los gráficos, el diseño, la compilación y los demás elementos relacionados con este sitio web están protegidos por la legislación aplicable en materia de derechos de autor y de propiedad intelectual. Queda estrictamente prohibida cualquier copia, redistribución, uso o publicación de dichos elementos o de cualquier parte del sitio web por parte del usuario.',
    'terms.s4_heading' => '4. Limitación de responsabilidad',
    'terms.s4_text' => 'En ningún caso seré responsable de daños incidentales, indirectos, consecuenciales o especiales de cualquier naturaleza, ni de ningún otro daño, incluidos, entre otros, los derivados de la pérdida de beneficios, de la pérdida de contratos, del fondo de comercio, de datos, de información, de ingresos, de ahorros previstos o de relaciones comerciales, con independencia de que se me hubiera advertido de la posibilidad de tales daños, y ello en relación con el uso de este sitio web o de cualquier sitio web enlazado desde él.',
    'terms.s5_heading' => '5. Legislación aplicable',
    'terms.s5_text' => 'Las presentes condiciones y estipulaciones se rigen e interpretan de conformidad con la legislación de la República Eslovaca, y usted se somete de forma irrevocable a la jurisdicción exclusiva de los tribunales de dicho territorio.',

    // Administración
    'admin.language' => 'Idioma',
    'admin.language_hint' => 'Idioma en el que está redactado el contenido.',
    'admin.translation_group' => 'Grupo de traducción',
    'admin.translation_group_hint' => 'El mismo número vincula entre idiomas las traducciones de un mismo artículo. Si deja el campo vacío, se creará un grupo nuevo.',
];
