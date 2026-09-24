<?php

declare(strict_types=1);

$requestedScript = str_replace('\\', '/', (string) ($_SERVER['SCRIPT_NAME'] ?? $_SERVER['PHP_SELF'] ?? ''));
$executedFile = isset($_SERVER['SCRIPT_FILENAME']) ? realpath((string) $_SERVER['SCRIPT_FILENAME']) : false;
if (
    $executedFile === __FILE__
    || preg_match('~(?:^|/)content/articles/.+\.php(?:/|$)~i', $requestedScript) === 1
) {
    if (PHP_SAPI === 'cli') {
        fwrite(STDERR, "Chyba: súbor článku je interný a nemožno ho spúšťať priamo.\n");
        exit(1);
    }
    http_response_code(403);
    exit('Prístup odmietnutý.');
}
unset($requestedScript, $executedFile);

/**
 * Osobný príbeh: nasadenie GitGuardian ggshield / pre-commit skenera tajomstiev
 * a nález vlastného PAT v histórii shellu (september 2026). Bez citovania tajomstiev.
 */
return [
    'slug' => 'skener-tajomstiev-shell-historia',
    'author' => 'MUDr. Ľubomír Polaščín',
    'category' => 'blog',
    'is_top' => 0,
    'published_at' => '2026-09-24 17:45:00',
    'image' => 'images/articles/skener-tajomstiev-shell-historia.webp',
    'translations' => [
        'sk' => [
            'title' => 'Nainštaloval som skener tajomstiev do všetkých repozitárov. Hneď našiel môj vlastný API token v histórii shellu.',
            'image_alt' => 'Nočný pracovný stôl: vývojár drží žiariaci kľúč pred monitorom s tyrkysovo-fialovým oblúkom svetla; žiadny čitateľný text.',
            'excerpt' => 'GitGuardian ggshield ako pre-commit hook naprieč mojimi solo projektmi. Syntetický test zablokoval commit. Potom skener našiel skutočný personal access token v histórii shellu — rotácia, vyčistenie histórie, hook ostáva.',
            'content' => <<<'HTML'
<p>Tento týždeň som nainštaloval skener tajomstiev naprieč všetkými svojimi kódovými repozitármi. Okamžite našiel jeden z mojich vlastných API tokenov v histórii shellu.</p>
<p>Píšem veľa kódu v mnohých repozitároch. Nefrologické portály, dialyzačný informačný systém, katalóg kníh, nástroj na hľadanie eventov. Všetko solo. Všetko na GitHube — verejne známe projekty ako <em>AlphaGrab</em>, <em>Arenibus</em> či <em>Nefro</em>.</p>
<p>Medzi 18.&nbsp;a&nbsp;19.&nbsp;septembrom&nbsp;2026 som nasadil <a href="https://docs.gitguardian.com/ggshield-docs/integrations/git-hooks/pre-commit">GitGuardian ggshield</a> ako pre-commit hook do každého repozitára v mojom vývojárskom priečinku. Nastavenie trvalo večer. Syntetický testovací secret zablokoval commit na prvý pokus — hook funguje.</p>
<p>Potom našiel skutočný. Personal access token, odhalený vo vlastnej histórii shellu. Nie v commitnutom súbore. V terminálovom výstupe, ktorý si väčšina systémov štandardne ukladá na disk.</p>
<p>Oprava bola jednoduchá: rotovať token, vyčistiť históriu, nechať pre-commit hook, aby sa to už nezopakovalo. Po ceste som narazil aj na drobný encoding problém v konfiguračnom súbore skenera (Windows cp1250 verzus UTF-8) — konfigurácia sa pokazila, kým som kódovanie neopravil. Hook ostal.</p>
<p>Ale poučenie ostalo.</p>
<p>Keď ste solo vývojár, ste celý bezpečnostný tím. Nie je DevSecOps, nie je partner na code review, nie je red team. Nástroje musia strážiť za vás.</p>
<p>Pre-commit hook, ktorý blokuje tajomstvá, nestojí nič na inštaláciu a chytí jedinú chybu, ktorá by stála všetko. Je to bezpečnostné opatrenie s najvyšším ROI, ktoré som tento rok pridal.</p>
<p>Ak píšete kód bez skenera tajomstiev v pre-commit reťazi, opravte to tento týždeň. Nie budúci.</p>
<p>Ak spúšťate projekty solo a chcete si prebrať praktický checklist, napíšte cez <a href="contact.php">kontakt</a>.</p>
<p><em>Osobná skúsenosť autora s hardeningom vlastného vývojového prostredia. Nie je to návod na obchádzanie skenerov ani na ťaženie tajomstiev z histórie.</em></p>
HTML,
        ],
        'en' => [
            'title' => 'I installed a secret scanner across all my repos. It immediately found one of my own API tokens in shell history.',
            'image_alt' => 'Night desk: a developer holds a glowing key before a monitor with a teal-purple arc of light; no readable text.',
            'excerpt' => 'GitGuardian ggshield as a pre-commit hook across my solo projects. A synthetic test secret blocked a commit. Then the scanner found a real personal access token in shell history — rotate, clear history, keep the hook.',
            'content' => <<<'HTML'
<p>This week I installed a secret scanner across all my code repositories. It immediately found one of my own API tokens sitting in shell history.</p>
<p>I write a lot of code across a lot of repositories. Nephrology portals, a dialysis information system, a book catalog, an event-search tool. All solo. All on GitHub — public projects such as <em>AlphaGrab</em>, <em>Arenibus</em>, and <em>Nefro</em>.</p>
<p>Between 18&nbsp;and&nbsp;19&nbsp;September&nbsp;2026 I rolled out <a href="https://docs.gitguardian.com/ggshield-docs/integrations/git-hooks/pre-commit">GitGuardian ggshield</a> as a pre-commit hook across every repo in my development folder. The setup took an evening. The synthetic test secret blocked a commit on the first try — the hook works.</p>
<p>Then it found a real one. A personal access token, exposed in my own shell history. Not in a committed file. In the terminal output that most systems save to disk by default.</p>
<p>The fix was simple: rotate the token, clear the history, keep the pre-commit hook so it never happens again. Along the way I also hit a small encoding snag in the scanner config (Windows cp1250 versus UTF-8) — the config broke until the encoding was fixed. The hook stayed.</p>
<p>But the lesson stuck.</p>
<p>When you are a solo developer, you are the entire security team. There is no DevSecOps, no code-review partner, no red team. The tools have to do the watching for you.</p>
<p>A pre-commit hook that blocks secrets costs nothing to install and catches the one mistake that would cost everything. It is the highest-ROI security measure I have added this year.</p>
<p>If you are writing code without a secret scanner in your pre-commit chain, fix that this week. Not next week.</p>
<p>If you ship projects solo and want to walk through a practical checklist, write via the <a href="contact.php">contact form</a>.</p>
<p><em>Personal experience hardening the author’s own development environment. Not a guide to bypassing scanners or mining secrets from history.</em></p>
HTML,
        ],
        'cs' => [
            'title' => 'Nainstaloval jsem skener tajemství do všech repozitářů. Hned našel můj vlastní API token v historii shellu.',
            'image_alt' => 'Noční pracovní stůl: vývojář drží zářící klíč před monitorem s tyrkysovo-fialovým obloukem světla; žádný čitelný text.',
            'excerpt' => 'GitGuardian ggshield jako pre-commit hook napříč mými solo projekty. Syntetický test zablokoval commit. Pak skener našel skutečný personal access token v historii shellu — rotace, vyčištění historie, hook zůstává.',
            'content' => <<<'HTML'
<p>Tento týden jsem nainstaloval skener tajemství napříč všemi svými kódovými repozitáři. Okamžitě našel jeden z mých vlastních API tokenů v historii shellu.</p>
<p>Píšu hodně kódu v mnoha repozitářích. Nefrologické portály, dialyzační informační systém, katalog knih, nástroj na hledání eventů. Vše solo. Vše na GitHubu — veřejně známé projekty jako <em>AlphaGrab</em>, <em>Arenibus</em> či <em>Nefro</em>.</p>
<p>Mezi 18.&nbsp;a&nbsp;19.&nbsp;zářím&nbsp;2026 jsem nasadil <a href="https://docs.gitguardian.com/ggshield-docs/integrations/git-hooks/pre-commit">GitGuardian ggshield</a> jako pre-commit hook do každého repozitáře ve své vývojářské složce. Nastavení trvalo večer. Syntetický testovací secret zablokoval commit na první pokus — hook funguje.</p>
<p>Pak našel skutečný. Personal access token, odhalený ve vlastní historii shellu. Ne v commitnutém souboru. V terminálovém výstupu, který si většina systémů standardně ukládá na disk.</p>
<p>Oprava byla jednoduchá: rotovat token, vyčistit historii, nechat pre-commit hook, aby se to už neopakovalo. Po cestě jsem narazil i na drobný encoding problém v konfiguračním souboru skeneru (Windows cp1250 versus UTF-8) — konfigurace se pokazila, dokud jsem kódování neopravil. Hook zůstal.</p>
<p>Ale poučení zůstalo.</p>
<p>Když jste solo vývojář, jste celý bezpečnostní tým. Není DevSecOps, není partner na code review, není red team. Nástroje musí hlídat za vás.</p>
<p>Pre-commit hook, který blokuje tajemství, nestojí nic na instalaci a chytí jedinou chybu, která by stála všechno. Je to bezpečnostní opatření s nejvyšším ROI, které jsem letos přidal.</p>
<p>Pokud píšete kód bez skeneru tajemství v pre-commit řetězu, opravte to tento týden. Ne příští.</p>
<p>Pokud spouštíte projekty solo a chcete si projít praktický checklist, napište přes <a href="contact.php">kontakt</a>.</p>
<p><em>Osobní zkušenost autora s hardeningem vlastního vývojového prostředí. Není to návod na obcházení skenerů ani na těžbu tajemství z historie.</em></p>
HTML,
        ],
        'de' => [
            'title' => 'Ich habe einen Secret-Scanner in allen Repos installiert. Sofort fand er einen meiner eigenen API-Tokens in der Shell-Historie.',
            'image_alt' => 'Nacht-Schreibtisch: ein Entwickler hält einen leuchtenden Schlüssel vor einem Monitor mit türkis-violettem Lichtbogen; kein lesbarer Text.',
            'excerpt' => 'GitGuardian ggshield als Pre-Commit-Hook über meine Solo-Projekte. Ein synthetischer Test-Secret blockierte einen Commit. Dann fand der Scanner einen echten Personal Access Token in der Shell-Historie — rotieren, Historie leeren, Hook behalten.',
            'content' => <<<'HTML'
<p>Diese Woche habe ich einen Secret-Scanner über alle meine Code-Repositories ausgerollt. Sofort fand er einen meiner eigenen API-Tokens in der Shell-Historie.</p>
<p>Ich schreibe viel Code in vielen Repositories. Nephrologie-Portale, ein Dialyse-Informationssystem, ein Buchkatalog, ein Event-Suchtool. Alles solo. Alles auf GitHub — öffentliche Projekte wie <em>AlphaGrab</em>, <em>Arenibus</em> und <em>Nefro</em>.</p>
<p>Zwischen dem 18.&nbsp;und&nbsp;19.&nbsp;September&nbsp;2026 habe ich <a href="https://docs.gitguardian.com/ggshield-docs/integrations/git-hooks/pre-commit">GitGuardian ggshield</a> als Pre-Commit-Hook in jedes Repo in meinem Entwicklungsordner gebracht. Die Einrichtung dauerte einen Abend. Der synthetische Test-Secret blockierte den Commit beim ersten Versuch — der Hook funktioniert.</p>
<p>Dann fand er einen echten. Einen Personal Access Token, freigelegt in meiner eigenen Shell-Historie. Nicht in einer committed Datei. In der Terminal-Ausgabe, die die meisten Systeme standardmäßig auf die Festplatte schreiben.</p>
<p>Der Fix war einfach: Token rotieren, Historie leeren, den Pre-Commit-Hook behalten, damit es nicht wieder passiert. Unterwegs stolperte ich auch über ein kleines Encoding-Problem in der Scanner-Konfiguration (Windows cp1250 versus UTF-8) — die Konfiguration brach, bis die Kodierung korrigiert war. Der Hook blieb.</p>
<p>Aber die Lektion blieb.</p>
<p>Als Solo-Entwickler sind Sie das gesamte Security-Team. Es gibt kein DevSecOps, keinen Code-Review-Partner, kein Red Team. Die Tools müssen für Sie wachen.</p>
<p>Ein Pre-Commit-Hook, der Secrets blockiert, kostet nichts in der Installation und fängt den einen Fehler, der alles kosten würde. Es ist die Security-Maßnahme mit dem höchsten ROI, die ich dieses Jahr hinzugefügt habe.</p>
<p>Wenn Sie Code ohne Secret-Scanner in der Pre-Commit-Kette schreiben, beheben Sie das diese Woche. Nicht nächste Woche.</p>
<p>Wenn Sie Projekte solo ausliefern und einen praktischen Checklist durchgehen wollen, schreiben Sie über das <a href="contact.php">Kontaktformular</a>.</p>
<p><em>Persönliche Erfahrung des Autors mit dem Hardening der eigenen Entwicklungsumgebung. Keine Anleitung zum Umgehen von Scannern oder zum Auslesen von Secrets aus der Historie.</em></p>
HTML,
        ],
        'fr' => [
            'title' => 'J’ai installé un scanner de secrets sur tous mes dépôts. Il a aussitôt trouvé l’un de mes propres jetons API dans l’historique du shell.',
            'image_alt' => 'Bureau de nuit : un développeur tient une clé lumineuse devant un moniteur à arc turquoise-violet ; aucun texte lisible.',
            'excerpt' => 'GitGuardian ggshield en hook pre-commit sur mes projets solo. Un secret de test synthétique a bloqué un commit. Puis le scanner a trouvé un vrai personal access token dans l’historique du shell — rotation, nettoyage, le hook reste.',
            'content' => <<<'HTML'
<p>Cette semaine, j’ai installé un scanner de secrets sur tous mes dépôts de code. Il a immédiatement trouvé l’un de mes propres jetons API dans l’historique du shell.</p>
<p>J’écris beaucoup de code dans beaucoup de dépôts. Portails de néphrologie, système d’information de dialyse, catalogue de livres, outil de recherche d’événements. Tout en solo. Tout sur GitHub — des projets publics comme <em>AlphaGrab</em>, <em>Arenibus</em> et <em>Nefro</em>.</p>
<p>Entre le 18&nbsp;et&nbsp;le&nbsp;19&nbsp;septembre&nbsp;2026, j’ai déployé <a href="https://docs.gitguardian.com/ggshield-docs/integrations/git-hooks/pre-commit">GitGuardian ggshield</a> comme hook pre-commit sur chaque dépôt de mon dossier de développement. La mise en place a pris une soirée. Le secret de test synthétique a bloqué un commit du premier coup — le hook fonctionne.</p>
<p>Puis il en a trouvé un vrai. Un personal access token, exposé dans mon propre historique de shell. Pas dans un fichier commité. Dans la sortie du terminal que la plupart des systèmes enregistrent par défaut sur le disque.</p>
<p>La correction était simple : faire tourner le jeton, nettoyer l’historique, garder le hook pre-commit pour que cela ne se reproduise pas. En chemin, j’ai aussi buté sur un petit problème d’encodage dans la config du scanner (Windows cp1250 versus UTF-8) — la config cassait tant que l’encodage n’était pas corrigé. Le hook est resté.</p>
<p>Mais la leçon est restée.</p>
<p>Quand vous êtes développeur solo, vous êtes toute l’équipe sécurité. Pas de DevSecOps, pas de partenaire de revue de code, pas de red team. Les outils doivent veiller à votre place.</p>
<p>Un hook pre-commit qui bloque les secrets ne coûte rien à installer et attrape l’erreur unique qui coûterait tout. C’est la mesure de sécurité au meilleur ROI que j’ai ajoutée cette année.</p>
<p>Si vous écrivez du code sans scanner de secrets dans votre chaîne pre-commit, corrigez cela cette semaine. Pas la semaine prochaine.</p>
<p>Si vous livrez des projets en solo et voulez parcourir une checklist pratique, écrivez via le <a href="contact.php">formulaire de contact</a>.</p>
<p><em>Expérience personnelle de l’auteur sur le durcissement de son propre environnement de développement. Ce n’est pas un guide pour contourner les scanners ni pour extraire des secrets de l’historique.</em></p>
HTML,
        ],
        'es' => [
            'title' => 'Instalé un escáner de secretos en todos mis repositorios. Enseguida encontró uno de mis propios tokens de API en el historial del shell.',
            'image_alt' => 'Escritorio nocturno: un desarrollador sostiene una llave brillante ante un monitor con un arco de luz turquesa-púrpura; sin texto legible.',
            'excerpt' => 'GitGuardian ggshield como hook pre-commit en mis proyectos en solitario. Un secreto de prueba sintético bloqueó un commit. Luego el escáner halló un personal access token real en el historial del shell: rotar, limpiar y dejar el hook.',
            'content' => <<<'HTML'
<p>Esta semana instalé un escáner de secretos en todos mis repositorios de código. Enseguida encontró uno de mis propios tokens de API en el historial del shell.</p>
<p>Escribo mucho código en muchos repositorios. Portales de nefrología, un sistema de información de diálisis, un catálogo de libros, una herramienta de búsqueda de eventos. Todo en solitario. Todo en GitHub: proyectos públicos como <em>AlphaGrab</em>, <em>Arenibus</em> y <em>Nefro</em>.</p>
<p>Entre el 18&nbsp;y&nbsp;el&nbsp;19&nbsp;de&nbsp;septiembre&nbsp;de&nbsp;2026 desplegué <a href="https://docs.gitguardian.com/ggshield-docs/integrations/git-hooks/pre-commit">GitGuardian ggshield</a> como hook pre-commit en cada repositorio de mi carpeta de desarrollo. La configuración llevó una tarde. El secreto de prueba sintético bloqueó un commit a la primera: el hook funciona.</p>
<p>Luego encontró uno real. Un personal access token, expuesto en mi propio historial del shell. No en un archivo confirmado. En la salida del terminal que la mayoría de sistemas guarda en disco por defecto.</p>
<p>La corrección fue sencilla: rotar el token, limpiar el historial, mantener el hook pre-commit para que no vuelva a ocurrir. Por el camino también choqué con un pequeño problema de encoding en la configuración del escáner (Windows cp1250 frente a UTF-8): la config se rompía hasta corregir la codificación. El hook se quedó.</p>
<p>Pero la lección quedó.</p>
<p>Cuando eres desarrollador en solitario, eres todo el equipo de seguridad. No hay DevSecOps, no hay compañero de revisión de código, no hay red team. Las herramientas tienen que vigilar por ti.</p>
<p>Un hook pre-commit que bloquea secretos no cuesta nada instalar y atrapa el único error que lo costaría todo. Es la medida de seguridad con mayor ROI que he añadido este año.</p>
<p>Si escribes código sin un escáner de secretos en tu cadena pre-commit, arréglalo esta semana. No la próxima.</p>
<p>Si lanzas proyectos en solitario y quieres revisar una checklist práctica, escribe por el <a href="contact.php">formulario de contacto</a>.</p>
<p><em>Experiencia personal del autor endureciendo su propio entorno de desarrollo. No es una guía para eludir escáneres ni para extraer secretos del historial.</em></p>
HTML,
        ],
        'pl' => [
            'title' => 'Zainstalowałem skaner sekretów we wszystkich repozytoriach. Od razu znalazł mój własny token API w historii shella.',
            'image_alt' => 'Nocne biurko: programista trzyma świecący klucz przed monitorem z turkusowo-fioletowym łukiem światła; bez czytelnego tekstu.',
            'excerpt' => 'GitGuardian ggshield jako hook pre-commit w moich solowych projektach. Syntetyczny sekret testowy zablokował commit. Potem skaner znalazł prawdziwy personal access token w historii shella — rotacja, czyszczenie, hook zostaje.',
            'content' => <<<'HTML'
<p>W tym tygodniu zainstalowałem skaner sekretów we wszystkich swoich repozytoriach kodu. Natychmiast znalazł jeden z moich własnych tokenów API w historii shella.</p>
<p>Piszę dużo kodu w wielu repozytoriach. Portale nefrologiczne, system informacji dializacyjnej, katalog książek, narzędzie do wyszukiwania wydarzeń. Wszystko solo. Wszystko na GitHubie — publiczne projekty takie jak <em>AlphaGrab</em>, <em>Arenibus</em> i <em>Nefro</em>.</p>
<p>Między 18&nbsp;a&nbsp;19&nbsp;września&nbsp;2026 wdrożyłem <a href="https://docs.gitguardian.com/ggshield-docs/integrations/git-hooks/pre-commit">GitGuardian ggshield</a> jako hook pre-commit w każdym repozytorium w folderze deweloperskim. Konfiguracja zajęła wieczór. Syntetyczny sekret testowy zablokował commit za pierwszym razem — hook działa.</p>
<p>Potem znalazł prawdziwy. Personal access token, ujawniony we własnej historii shella. Nie w pliku w commicie. W wyjściu terminala, które większość systemów domyślnie zapisuje na dysk.</p>
<p>Naprawa była prosta: obrócić token, wyczyścić historię, zostawić hook pre-commit, żeby się to nie powtórzyło. Po drodze natknąłem się też na drobny problem z kodowaniem w konfiguracji skanera (Windows cp1250 versus UTF-8) — konfiguracja się psuła, dopóki nie poprawiłem kodowania. Hook został.</p>
<p>Ale lekcja została.</p>
<p>Gdy jesteś solo developerem, jesteś całym zespołem bezpieczeństwa. Nie ma DevSecOps, nie ma partnera do code review, nie ma red teamu. Narzędzia muszą pilnować za Ciebie.</p>
<p>Hook pre-commit, który blokuje sekrety, nic nie kosztuje w instalacji i łapie jeden błąd, który kosztowałby wszystko. To zabezpieczenie o najwyższym ROI, jakie dodałem w tym roku.</p>
<p>Jeśli piszesz kod bez skanera sekretów w łańcuchu pre-commit, napraw to w tym tygodniu. Nie w następnym.</p>
<p>Jeśli prowadzisz projekty solo i chcesz przejść praktyczną checklistę, napisz przez <a href="contact.php">kontakt</a>.</p>
<p><em>Osobiste doświadczenie autora z hardeningiem własnego środowiska deweloperskiego. To nie jest przewodnik po omijaniu skanerów ani wydobywaniu sekretów z historii.</em></p>
HTML,
        ],
        'hu' => [
            'title' => 'Titokszkennert telepítettem az összes repómba. Azonnal megtalálta a saját API-tokenemet a shell előzményeiben.',
            'image_alt' => 'Éjszakai íróasztal: fejlesztő izzó kulcsot tart egy türkiz-lila fényíves monitor előtt; nincs olvasható szöveg.',
            'excerpt' => 'GitGuardian ggshield pre-commit hookként a solo projekteimben. Egy szintetikus teszt-titok blokkolta a commitot. Aztán a szkenner valódi personal access tokent talált a shell történetében — forgatás, tisztítás, a hook marad.',
            'content' => <<<'HTML'
<p>Ezen a héten titokszkennert telepítettem az összes kódrepozitóriumomba. Azonnal megtalálta az egyik saját API-tokenemet a shell előzményeiben.</p>
<p>Sok kódot írok sok repozitóriumban. Nephrológiai portálok, dialízis információs rendszer, könyvkatalógus, eseménykereső eszköz. Minden solo. Minden GitHubon — nyilvános projektek, például <em>AlphaGrab</em>, <em>Arenibus</em> és <em>Nefro</em>.</p>
<p>2026.&nbsp;szeptember&nbsp;18.&nbsp;és&nbsp;19.&nbsp;között <a href="https://docs.gitguardian.com/ggshield-docs/integrations/git-hooks/pre-commit">GitGuardian ggshield</a>-et vezettem be pre-commit hookként a fejlesztői mappa minden repójában. A beállítás egy estébe telt. A szintetikus teszt-titok elsőre blokkolta a commitot — a hook működik.</p>
<p>Aztán talált egy valódit. Egy personal access tokent, amely a saját shell-előzményeimben volt kitéve. Nem commitolt fájlban. A terminálkimenetben, amelyet a legtöbb rendszer alapból lemezre ment.</p>
<p>A javítás egyszerű volt: token forgatása, előzmények törlése, a pre-commit hook megtartása, hogy ne ismétlődjön. Útközben egy apró encoding-problémába is beleütköztem a szkenner konfigurációjában (Windows cp1250 versus UTF-8) — a konfig addig tört, amíg a kódolást nem javítottam. A hook maradt.</p>
<p>De a tanulság megmaradt.</p>
<p>Ha solo fejlesztő vagy, te vagy a teljes biztonsági csapat. Nincs DevSecOps, nincs code-review partner, nincs red team. Az eszközöknek kell őrködniük helyetted.</p>
<p>Egy pre-commit hook, amely blokkolja a titkokat, semmibe sem kerül telepíteni, és elkapja azt az egy hibát, ami mindent elvinne. Ez az idei legmagasabb ROI-jú biztonsági intézkedésem.</p>
<p>Ha titokszkenner nélkül írsz kódot a pre-commit láncodban, javítsd ki ezen a héten. Ne a következőn.</p>
<p>Ha solo projekteket futtatsz, és szeretnél végigmenni egy gyakorlati checklistán, írj a <a href="contact.php">kapcsolati űrlapon</a>.</p>
<p><em>A szerző személyes tapasztalata a saját fejlesztői környezetének megerősítéséről. Nem útmutató szkennerek megkerüléséhez vagy titkok előzményekből való kinyeréséhez.</em></p>
HTML,
        ],
        'it' => [
            'title' => 'Ho installato uno scanner di segreti su tutti i miei repository. Ha subito trovato uno dei miei token API nella cronologia della shell.',
            'image_alt' => 'Scrivania notturna: uno sviluppatore tiene una chiave luminosa davanti a un monitor con un arco di luce turchese-viola; nessun testo leggibile.',
            'excerpt' => 'GitGuardian ggshield come hook pre-commit sui miei progetti solo. Un segreto di test sintetico ha bloccato un commit. Poi lo scanner ha trovato un vero personal access token nella cronologia della shell: ruotare, pulire, tenere l’hook.',
            'content' => <<<'HTML'
<p>Questa settimana ho installato uno scanner di segreti su tutti i miei repository di codice. Ha immediatamente trovato uno dei miei token API nella cronologia della shell.</p>
<p>Scrivo molto codice in molti repository. Portali di nefrologia, un sistema informativo dialitico, un catalogo di libri, uno strumento di ricerca eventi. Tutto da solo. Tutto su GitHub — progetti pubblici come <em>AlphaGrab</em>, <em>Arenibus</em> e <em>Nefro</em>.</p>
<p>Tra il 18&nbsp;e&nbsp;il&nbsp;19&nbsp;settembre&nbsp;2026 ho distribuito <a href="https://docs.gitguardian.com/ggshield-docs/integrations/git-hooks/pre-commit">GitGuardian ggshield</a> come hook pre-commit in ogni repository della mia cartella di sviluppo. La configurazione ha richiesto una serata. Il segreto di test sintetico ha bloccato un commit al primo tentativo — l’hook funziona.</p>
<p>Poi ne ha trovato uno vero. Un personal access token, esposto nella mia stessa cronologia della shell. Non in un file committato. Nell’output del terminale che la maggior parte dei sistemi salva su disco per impostazione predefinita.</p>
<p>La correzione era semplice: ruotare il token, pulire la cronologia, mantenere l’hook pre-commit così non succede più. Lungo la strada ho anche incontrato un piccolo problema di encoding nella configurazione dello scanner (Windows cp1250 versus UTF-8) — la config si rompeva finché non correggevo la codifica. L’hook è rimasto.</p>
<p>Ma la lezione è rimasta.</p>
<p>Quando sei uno sviluppatore solo, sei l’intero team di sicurezza. Non c’è DevSecOps, non c’è un partner di code review, non c’è red team. Gli strumenti devono fare la guardia al posto tuo.</p>
<p>Un hook pre-commit che blocca i segreti non costa nulla da installare e cattura l’unico errore che costerebbe tutto. È la misura di sicurezza con il ROI più alto che ho aggiunto quest’anno.</p>
<p>Se scrivi codice senza uno scanner di segreti nella catena pre-commit, sistemalo questa settimana. Non la prossima.</p>
<p>Se spedisci progetti da solo e vuoi ripassare una checklist pratica, scrivi tramite il <a href="contact.php">modulo di contatto</a>.</p>
<p><em>Esperienza personale dell’autore sull’hardening del proprio ambiente di sviluppo. Non è una guida per aggirare gli scanner né per estrarre segreti dalla cronologia.</em></p>
HTML,
        ],
        'uk' => [
            'title' => 'Я встановив сканер секретів у всі репозиторії. Він одразу знайшов мій власний API-токен в історії shell.',
            'image_alt' => 'Нічний робочий стіл: розробник тримає сяючий ключ перед монітором із бірюзово-фіолетовою дугою світла; без читабельного тексту.',
            'excerpt' => 'GitGuardian ggshield як pre-commit hook у моїх соло-проєктах. Синтетичний тестовий секрет заблокував commit. Потім сканер знайшов справжній personal access token в історії shell — ротація, очищення, хук лишається.',
            'content' => <<<'HTML'
<p>Цього тижня я встановив сканер секретів у всі свої кодові репозиторії. Він одразу знайшов один із моїх власних API-токенів в історії shell.</p>
<p>Я пишу багато коду в багатьох репозиторіях. Нефрологічні портали, інформаційна система діалізу, каталог книг, інструмент пошуку подій. Усе соло. Усе на GitHub — публічні проєкти на кшталт <em>AlphaGrab</em>, <em>Arenibus</em> і <em>Nefro</em>.</p>
<p>Між 18&nbsp;і&nbsp;19&nbsp;вересня&nbsp;2026 я розгорнув <a href="https://docs.gitguardian.com/ggshield-docs/integrations/git-hooks/pre-commit">GitGuardian ggshield</a> як pre-commit hook у кожному репозиторії в моїй теці розробки. Налаштування зайняло вечір. Синтетичний тестовий секрет заблокував commit з першої спроби — хук працює.</p>
<p>Потім він знайшов справжній. Personal access token, розкритий у власній історії shell. Не в закоміченому файлі. У виводі термінала, який більшість систем стандартно зберігає на диск.</p>
<p>Виправлення було простим: ротувати токен, очистити історію, залишити pre-commit hook, щоб це більше не повторилося. По дорозі я також натрапив на дрібну проблему кодування в конфігурації сканера (Windows cp1250 versus UTF-8) — конфіг ламався, доки я не виправив кодування. Хук лишився.</p>
<p>Але урок лишився.</p>
<p>Коли ви соло-розробник, ви — вся команда безпеки. Немає DevSecOps, немає партнера з code review, немає red team. Інструменти мають стерегти за вас.</p>
<p>Pre-commit hook, який блокує секрети, нічого не коштує встановити і ловить ту єдину помилку, яка коштувала б усього. Це захід безпеки з найвищим ROI, який я додав цього року.</p>
<p>Якщо ви пишете код без сканера секретів у pre-commit ланцюгу, виправте це цього тижня. Не наступного.</p>
<p>Якщо запускаєте проєкти соло і хочете пройти практичний чекліст, напишіть через <a href="contact.php">контакт</a>.</p>
<p><em>Особистий досвід автора з hardening власного середовища розробки. Це не інструкція з обходу сканерів і не з видобування секретів з історії.</em></p>
HTML,
        ],
    ],
];
