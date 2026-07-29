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
    'common.toggle_dark_mode' => 'Alternar el modo oscuro',
    'common.required' => 'obligatorio',
    'common.back' => 'Volver',
    'common.read_more' => 'Leer más',
    'common.visit' => 'Visitar :target',
    'common.author_meta_prefix' => 'Autor',

    // Navegación
    'nav.home' => 'Inicio',
    'nav.blog' => 'Blog',
    'nav.about' => 'Biografía',
    'nav.nephrology' => 'Nefrología',
    'nav.projects' => 'Proyectos',
    'nav.books' => 'Libros',
    'nav.links' => 'Enlaces',
    'nav.contact' => 'Contacto',
    'nav.admin' => 'Administración',
    'nav.logout' => 'Cerrar sesión',
    'nav.login' => 'Iniciar sesión',

    // Pie de página
    'footer.heading' => 'Conectemos',
    'footer.linkedin' => 'Perfil en LinkedIn',
    'footer.x' => 'Perfil en X',
    'footer.facebook' => 'Perfil en Facebook',
    'footer.email' => 'Enviar un correo electrónico',
    'footer.patreon' => 'Apoyar en Patreon',
    'footer.discord' => 'Unirse a Discord',
    'footer.copyright' => '© 1998 – :year Ľubomír Polaščín. Todos los derechos reservados.',
    'footer.privacy' => 'Política de privacidad',
    'footer.terms' => 'Condiciones de uso',
    'footer.cookie_settings' => 'Configuración de cookies',

    // Metadatos de las páginas
    'meta.keywords' => 'Ľubomír Polaščín, nefrología, medicina interna, diálisis, traducción médica, programación',
    'meta.default_description' => 'Dr. Ľubomír Polaščín — nefrólogo, internista, traductor médico, escritor y programador autodidacta.',
    'meta.home_title' => 'Inicio',
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
    'home.logo_alt' => 'Logo Crystal Kidney',
    'home.hero_title' => 'Avances en la salud renal',
    'home.hero_subtitle' => 'Dr. Ľubomír Polaščín — dedicado a la excelencia en nefrología, diálisis, atención al paciente y tecnología médica.',
    'home.cta_about' => 'Sobre mí',
    'home.cta_articles' => 'Últimos artículos',

    // Página de inicio — biografía
    'home.about_heading' => 'Sobre el Dr. Ľubomír Polaščín',
    'home.about_intro' => 'Me llamo Ľubomír Polaščín — soy médico, nefrólogo e internista de profesión, escritor de ficción y de no ficción por vocación, y programador autodidacta por pasión.',
    'home.about_who' => 'Mi trabajo se sitúa en la intersección de la medicina, la narración y la tecnología. La medicina afina mi precisión clínica; la escritura me permite explorar la condición humana a través de la ficción y de la no ficción; y la tecnología me impulsa a resolver problemas complejos.',
    'home.identity_heading' => 'Identidad profesional',
    'home.identity_doctor' => 'Médico (Dr.)',
    'home.identity_nephrologist' => 'Nefrólogo',
    'home.identity_internist' => 'Internista',
    'home.identity_translator' => 'Traductor médico',
    'home.identity_writer' => 'Escritor de ficción y de no ficción',
    'home.identity_programmer' => 'Programador autodidacta',
    'home.skills_heading' => 'Competencias técnicas',
    'home.education_heading' => 'Formación y&nbsp;trayectoria',
    'home.education_text' => 'Comencé mi formación médica en la Universidad Pavol Jozef Šafárik de Košice. Desde 1995 me dedico a la diálisis y a la nefrología. Entre 2013 y 2022 fui jefe de servicio en dos centros de diálisis de Bratislava.',
    'home.personal_heading' => 'En lo personal',
    'home.personal_text' => 'Nací en 1971 en Checoslovaquia y crecí en Kyjov. Mis raíces rusinas dan forma a mi manera de mirar el mundo. Entre mis aficiones están la lectura, los viajes, la filosofía y la poesía.',
    'home.amazon_cta' => 'Ver en Amazon Author Central',

    // Página de inicio — nefrología
    'home.nephrology_heading' => 'Nefrología',
    'home.nephrology_intro' => 'La nefrología es una especialidad médica esencial dedicada a los riñones, órganos vitales responsables del equilibrio de líquidos, de la filtración de los productos de desecho y de la regulación de la presión arterial.',
    'home.ckd_title' => 'Enfermedad renal crónica (ERC)',
    'home.ckd_text' => 'Manejo de la pérdida progresiva de la función renal a lo largo del tiempo causada por la diabetes, la hipertensión u otros factores.',
    'home.aki_title' => 'Lesión renal aguda (LRA)',
    'home.aki_text' => 'Tratamiento del fallo súbito, a menudo transitorio, de la función renal provocado por infecciones, deshidratación o toxinas.',
    'home.hemodialysis_title' => 'Hemodiálisis',
    'home.hemodialysis_text' => 'Procedimiento en el que se emplean una máquina de diálisis y un filtro especial denominado riñón artificial para depurar la sangre.',
    'home.peritoneal_title' => 'Diálisis peritoneal',
    'home.peritoneal_text' => 'Tratamiento que aprovecha el revestimiento de la cavidad abdominal y una solución depuradora llamada líquido de diálisis para limpiar la sangre.',
    'home.transplant_title' => 'Trasplante',
    'home.transplant_text' => 'El mejor tratamiento para la insuficiencia renal. Se implanta un riñón sano en el organismo para que realice el trabajo que los riñones propios ya no son capaces de asumir.',
    'home.diagnostics_title' => 'Diagnóstico',
    'home.diagnostics_text' => 'Uso de la ecografía, de la biopsia renal y de pruebas de laboratorio avanzadas para diagnosticar con precisión las enfermedades renales.',

    // Página de inicio — artículos, proyectos, enlaces, contacto
    'home.latest_heading' => 'Últimos artículos',
    'home.all_articles' => 'Ver todos los artículos',
    'home.projects_heading' => 'Proyectos y&nbsp;red',
    'home.projects_intro' => 'Una selección de sitios web, herramientas y recursos que desarrollo o gestiono en los ámbitos de la medicina, la educación y la tecnología.',
    'home.project_nefro_text' => 'Portal nefrológico eslovaco con artículos clínicos, novedades sobre diálisis y trasplantes, calculadoras, referencias de medicamentos y apuntes de estudio.',
    'home.project_nephrosite_text' => 'Clases y páginas de referencia sobre nefrología, diálisis, métodos de depuración de la sangre y medicina interna (en eslovaco).',
    'home.project_books_text' => 'Archivo central de los libros, publicaciones académicas, capítulos y obras literarias del Dr. Ľubomír Polaščín.',
    'home.project_alphagrab_text' => 'Proyecto experimental de descubrimiento de entradas que enriquece los enlaces de respaldo mediante la Ticketmaster Discovery API.',
    'home.project_arenibus_text' => 'Instancia pública de demostración de un proyecto web sobre eventos y transporte.',
    'home.links_heading' => 'Red y&nbsp;recursos',
    'home.links_intro' => 'Explore otros sitios y recursos relacionados.',
    'home.link_nephrosite' => 'NephroSite (en eslovaco)',
    'home.link_vital_2nd' => 'Vital Algorithm — 2.ª edición (Amazon)',
    'home.link_vital_1st' => 'The Vital Algorithm — 1.ª edición (Amazon)',
    'home.contact_heading' => 'Contacto',
    'home.contact_intro' => 'No dude en escribirme si tiene alguna pregunta o desea proponer una colaboración.',
    'home.contact_cta' => 'Enviar un mensaje',

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
    'contact.success' => 'Gracias por su mensaje. Le responderé lo antes posible.',
    'contact.error_name' => 'Por favor, introduzca un nombre válido.',
    'contact.error_email' => 'Por favor, introduzca una dirección de correo electrónico válida.',
    'contact.error_subject' => 'El asunto es demasiado largo.',
    'contact.error_message' => 'Por favor, escriba un mensaje (máximo 5000 caracteres).',
    'contact.error_rate_limit' => 'Demasiados mensajes desde esta dirección. Inténtelo de nuevo más tarde.',
    'contact.error_save' => 'No se ha podido enviar el mensaje. Inténtelo de nuevo más tarde.',

    // Newsletter
    'newsletter.heading' => 'Newsletter',
    'newsletter.aria_label' => 'Suscripción al Newsletter',
    'newsletter.intro' => 'Suscríbase para recibir novedades sobre artículos, libros y proyectos.',
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

    // Errores comunes
    'error.csrf' => 'Token de seguridad no válido. Actualice la página e inténtelo de nuevo.',

    // Cookies (se envía a JavaScript)
    'cookie.title' => 'Cookies analíticas',
    'cookie.description' => 'Con su consentimiento utilizaremos Google Analytics 4 para medir el tráfico del sitio. El almacenamiento publicitario y la personalización permanecen desactivados. Rechazarlas no limita el uso del sitio. Encontrará más detalles en la',
    'cookie.privacy_link' => 'política de privacidad',
    'cookie.decline' => 'Rechazar',
    'cookie.accept' => 'Acepto',

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
    'privacy.s2_cookies' => '<strong>Cookies y almacenamiento local:</strong> De forma local guardo únicamente la preferencia de tema (modo oscuro o claro), el idioma seleccionado y su decisión sobre la analítica. <strong>Google Analytics 4 (GA4):</strong> El script analítico no se carga mientras no haga clic expresamente en el botón Acepto de la barra de consentimiento. Las categorías publicitarias del consentimiento permanecen desactivadas. Puede cambiar su decisión en cualquier momento mediante la Configuración de cookies del pie de página.',
    'privacy.s3_heading' => '3. Cómo utilizo su información',
    'privacy.s3_text' => 'Utilizo sus datos para:',
    'privacy.s3_item1' => 'Ofrecer el contenido del sitio web.',
    'privacy.s3_item2' => 'Garantizar la seguridad del sitio web.',
    'privacy.s3_item3' => 'Recordar la preferencia de tema, el idioma y la decisión sobre la analítica.',
    'privacy.s3_item4' => 'Tramitar los mensajes de contacto y gestionar la suscripción al Newsletter a petición suya.',
    'privacy.s3_item5' => 'Analizar el tráfico y la forma de uso del sitio web mediante Google Analytics 4, pero únicamente en caso de que haga clic en el botón <strong>Acepto</strong> de la barra de consentimiento de cookies. Base jurídica: su consentimiento (artículo 6, apartado 1, letra a), del RGPD). Google conserva los datos analíticos conforme a sus propias normas de conservación (habitualmente, 14 meses como máximo). Puede retirar su consentimiento en cualquier momento a través del botón <strong>Configuración de cookies</strong> del pie de página, seleccionando la opción <strong>Rechazar</strong>.',
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
