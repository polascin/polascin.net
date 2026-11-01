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
            'excerpt' => 'GitGuardian ggshield ako pre-commit hook vo všetkých mojich projektoch. Skúšobné tajomstvo zablokovalo commit. Potom skener našiel skutočný personal access token v histórii shellu: rotácia, vyčistenie histórie, hook ostáva.',
            'content' => <<<'HTML'
<p>Medzi 18.&nbsp;a&nbsp;19.&nbsp;septembrom&nbsp;2026 som do každého repozitára v vývojárskom priečinku nasadil <a href="https://docs.gitguardian.com/ggshield-docs/integrations/git-hooks/pre-commit">GitGuardian ggshield</a> ako pre-commit hook. Nastavenie trvalo večer. Syntetické skúšobné tajomstvo zablokovalo commit na prvý pokus, takže hook funguje.</p>
<p>Píšem veľa kódu v mnohých repozitároch. Nefrologické portály, dialyzačný informačný systém, katalóg kníh, nástroj na hľadanie podujatí. Všetko sám a všetko na GitHube: verejne známe projekty ako <em>AlphaGrab</em>, <em>Arenibus</em> či <em>Nefro</em>.</p>
<p>Skener potom našiel skutočný personal access token. Nie v súbore, ktorý by šiel do commitu. Vo vlastnej histórii shellu, v terminálovom výstupe, ktorý si väčšina systémov štandardne ukladá na disk.</p>
<p>Oprava bola jednoduchá. Token som zrotoval, históriu vyčistil a hook nechal zapnutý, aby sa to nezopakovalo. Po ceste sa pokazila konfigurácia skenera, kým som neopravil kódovanie súboru (Windows cp1250 verzus UTF-8). Hook ostal.</p>
<p>Keď na kóde pracujete sami, ste celý bezpečnostný tím. Nemáte DevSecOps, partnera na code review ani red team. Nástroje musia strážiť za vás.</p>
<p>Pre-commit hook, ktorý blokuje tajomstvá, nestojí nič na inštaláciu a zastaví commit skôr, než token odíde do repozitára.</p>
<p>Ak píšete kód bez skenera tajomstiev v pre-commit reťazi, dajte ho tam pred ďalším commitom.</p>

<p><em>Osobná skúsenosť autora so spevnením vlastného vývojového prostredia. Nie je to návod na obchádzanie skenerov ani na vyťahovanie tajomstiev z histórie.</em></p>
HTML,
        ],
        'en' => [
            'title' => 'I installed a secret scanner across all my repos. It immediately found one of my own API tokens in shell history.',
            'image_alt' => 'Night desk: a developer holds a glowing key before a monitor with a teal-purple arc of light; no readable text.',
            'excerpt' => 'GitGuardian ggshield as a pre-commit hook across my solo projects. A synthetic test secret blocked a commit. Then the scanner found a real personal access token in shell history: rotate, clear history, keep the hook.',
            'content' => <<<'HTML'
<p>Between 18&nbsp;and&nbsp;19&nbsp;September&nbsp;2026 I put <a href="https://docs.gitguardian.com/ggshield-docs/integrations/git-hooks/pre-commit">GitGuardian ggshield</a> in as a pre-commit hook on every repository in my development folder. The setup took an evening. A synthetic test secret blocked a commit on the first try, so the hook works.</p>
<p>I write a lot of code across many repositories. Nephrology portals, a dialysis information system, a book catalog, a tool for finding events. All of it alone, all of it on GitHub: public projects such as <em>AlphaGrab</em>, <em>Arenibus</em> and <em>Nefro</em>.</p>
<p>The scanner then found a real personal access token. Not in a file that would have gone into a commit. In my own shell history, in the terminal output that most systems save to disk by default.</p>
<p>The fix was simple. I rotated the token, cleared the history and left the hook on, so it would not happen again. Along the way the scanner config broke until I fixed the file encoding (Windows cp1250 versus UTF-8). The hook stayed.</p>
<p>When you work alone, you are the whole security team. There is no DevSecOps, no partner for code review and no red team. The tools have to watch for you.</p>
<p>A pre-commit hook that blocks secrets costs nothing to install and stops the commit before a token leaves for the repository.</p>
<p>If you write code without a secret scanner in the pre-commit chain, put one there before the next commit.</p>

<p><em>Personal experience of the author hardening his own development environment. Not a guide to bypassing scanners or pulling secrets out of history.</em></p>
HTML,
        ],
        'cs' => [
            'title' => 'Nainstaloval jsem skener tajemství do všech repozitářů. Hned našel můj vlastní API token v historii shellu.',
            'image_alt' => 'Noční pracovní stůl: vývojář drží zářící klíč před monitorem s tyrkysovo-fialovým obloukem světla; žádný čitelný text.',
            'excerpt' => 'GitGuardian ggshield jako pre-commit hook ve všech mých projektech. Zkušební tajemství zablokovalo commit. Pak skener našel skutečný personal access token v historii shellu: rotace, vyčištění historie, hook zůstává.',
            'content' => <<<'HTML'
<p>Mezi 18.&nbsp;a&nbsp;19.&nbsp;zářím&nbsp;2026 jsem do každého repozitáře ve vývojářské složce nasadil <a href="https://docs.gitguardian.com/ggshield-docs/integrations/git-hooks/pre-commit">GitGuardian ggshield</a> jako pre-commit hook. Nastavení trvalo večer. Syntetické zkušební tajemství zablokovalo commit na první pokus, takže hook funguje.</p>
<p>Píšu hodně kódu v mnoha repozitářích. Nefrologické portály, dialyzační informační systém, katalog knih, nástroj na hledání akcí. Všechno sám a všechno na GitHubu: veřejně známé projekty jako <em>AlphaGrab</em>, <em>Arenibus</em> či <em>Nefro</em>.</p>
<p>Skener potom našel skutečný personal access token. Ne v souboru, který by šel do commitu. Ve vlastní historii shellu, v terminálovém výstupu, který si většina systémů standardně ukládá na disk.</p>
<p>Oprava byla jednoduchá. Token jsem zrotoval, historii vyčistil a hook nechal zapnutý, aby se to neopakovalo. Po cestě se pokazila konfigurace skeneru, dokud jsem neopravil kódování souboru (Windows cp1250 versus UTF-8). Hook zůstal.</p>
<p>Když na kódu pracujete sami, jste celý bezpečnostní tým. Nemáte DevSecOps, partnera na code review ani red team. Nástroje musí hlídat za vás.</p>
<p>Pre-commit hook, který blokuje tajemství, nestojí nic na instalaci a zastaví commit dřív, než token odejde do repozitáře.</p>
<p>Pokud píšete kód bez skeneru tajemství v pre-commit řetězu, dejte ho tam před dalším commitem.</p>

<p><em>Osobní zkušenost autora se zpevněním vlastního vývojového prostředí. Není to návod na obcházení skenerů ani na vytahování tajemství z historie.</em></p>
HTML,
        ],
        'de' => [
            'title' => 'Ich habe einen Secret-Scanner in allen Repos installiert. Sofort fand er einen meiner eigenen API-Tokens in der Shell-Historie.',
            'image_alt' => 'Nacht-Schreibtisch: ein Entwickler hält einen leuchtenden Schlüssel vor einem Monitor mit türkis-violettem Lichtbogen; kein lesbarer Text.',
            'excerpt' => 'GitGuardian ggshield als Pre-Commit-Hook über meine Solo-Projekte. Ein synthetischer Test-Secret blockierte einen Commit. Dann fand der Scanner einen echten Personal Access Token in der Shell-Historie: rotieren, Historie leeren, Hook behalten.',
            'content' => <<<'HTML'
<p>Zwischen dem 18.&nbsp;und&nbsp;19.&nbsp;September&nbsp;2026 habe ich <a href="https://docs.gitguardian.com/ggshield-docs/integrations/git-hooks/pre-commit">GitGuardian ggshield</a> als Pre-Commit-Hook in jedes Repo in meinem Entwicklungsordner gebracht. Die Einrichtung dauerte einen Abend. Ein synthetisches Testgeheimnis blockierte den Commit beim ersten Versuch, der Hook funktioniert also.</p>
<p>Ich schreibe viel Code in vielen Repositories. Nephrologie-Portale, ein Dialyse-Informationssystem, ein Buchkatalog, ein Werkzeug zur Suche nach Veranstaltungen. Alles allein, alles auf GitHub: öffentliche Projekte wie <em>AlphaGrab</em>, <em>Arenibus</em> und <em>Nefro</em>.</p>
<p>Der Scanner fand danach einen echten Personal Access Token. Nicht in einer Datei, die in den Commit gegangen wäre. In der eigenen Shell-Historie, in der Terminal-Ausgabe, die die meisten Systeme standardmäßig auf die Festplatte schreiben.</p>
<p>Die Korrektur war einfach. Ich habe den Token rotiert, die Historie geleert und den Hook angelassen, damit es sich nicht wiederholt. Unterwegs brach die Scanner-Konfiguration, bis ich die Kodierung der Datei korrigiert hatte (Windows cp1250 versus UTF-8). Der Hook blieb.</p>
<p>Wenn Sie allein arbeiten, sind Sie das gesamte Sicherheitsteam. Es gibt kein DevSecOps, keinen Partner für Code Review und kein Red Team. Die Werkzeuge müssen für Sie wachen.</p>
<p>Ein Pre-Commit-Hook, der Geheimnisse blockiert, kostet bei der Installation nichts und hält den Commit an, bevor ein Token ins Repository gelangt.</p>
<p>Wenn Sie Code ohne Secret-Scanner in der Pre-Commit-Kette schreiben, setzen Sie ihn vor dem nächsten Commit ein.</p>

<p><em>Persönliche Erfahrung des Autors mit der Härtung der eigenen Entwicklungsumgebung. Keine Anleitung zum Umgehen von Scannern oder zum Herausziehen von Geheimnissen aus der Historie.</em></p>
HTML,
        ],
        'fr' => [
            'title' => 'J’ai installé un scanner de secrets sur tous mes dépôts. Il a aussitôt trouvé l’un de mes propres jetons API dans l’historique du shell.',
            'image_alt' => 'Bureau de nuit : un développeur tient une clé lumineuse devant un moniteur à arc turquoise-violet ; aucun texte lisible.',
            'excerpt' => 'GitGuardian ggshield en hook pre-commit sur mes projets solo. Un secret de test synthétique a bloqué un commit. Puis le scanner a trouvé un vrai personal access token dans l’historique du shell : rotation, nettoyage, le hook reste.',
            'content' => <<<'HTML'
<p>Entre le 18&nbsp;et&nbsp;le&nbsp;19&nbsp;septembre&nbsp;2026, j’ai déployé <a href="https://docs.gitguardian.com/ggshield-docs/integrations/git-hooks/pre-commit">GitGuardian ggshield</a> comme hook pre-commit sur chaque dépôt de mon dossier de développement. La mise en place a pris une soirée. Un secret d’essai synthétique a bloqué un commit du premier coup, le hook fonctionne donc.</p>
<p>J’écris beaucoup de code dans beaucoup de dépôts. Portails de néphrologie, système d’information de dialyse, catalogue de livres, outil de recherche d’événements. Tout seul, et tout sur GitHub : des projets publics comme <em>AlphaGrab</em>, <em>Arenibus</em> et <em>Nefro</em>.</p>
<p>Le scanner a ensuite trouvé un vrai personal access token. Pas dans un fichier qui serait parti dans un commit. Dans mon propre historique de shell, dans la sortie du terminal que la plupart des systèmes enregistrent par défaut sur le disque.</p>
<p>La correction était simple. J’ai renouvelé le jeton, nettoyé l’historique et laissé le hook pre-commit en place, pour que cela ne se reproduise pas. En chemin, la configuration du scanner cassait tant que je n’avais pas corrigé l’encodage du fichier (Windows cp1250 versus UTF-8). Le hook est resté.</p>
<p>Quand vous travaillez seul, vous êtes toute l’équipe sécurité. Il n’y a pas de DevSecOps, pas de partenaire de revue de code, pas de red team. Les outils doivent veiller à votre place.</p>
<p>Un hook pre-commit qui bloque les secrets ne coûte rien à installer et arrête le commit avant qu’un jeton parte dans le dépôt.</p>
<p>Si vous écrivez du code sans scanner de secrets dans votre chaîne pre-commit, mettez-en un avant le prochain commit.</p>

<p><em>Expérience personnelle de l’auteur sur le durcissement de son propre environnement de développement. Ce n’est pas un guide pour contourner les scanners ni pour extraire des secrets de l’historique.</em></p>
HTML,
        ],
        'es' => [
            'title' => 'Instalé un escáner de secretos en todos mis repositorios. Enseguida encontró uno de mis propios tokens de API en el historial del shell.',
            'image_alt' => 'Escritorio nocturno: un desarrollador sostiene una llave brillante ante un monitor con un arco de luz turquesa-púrpura; sin texto legible.',
            'excerpt' => 'GitGuardian ggshield como hook pre-commit en mis proyectos en solitario. Un secreto de prueba sintético bloqueó un commit. Luego el escáner halló un personal access token real en el historial del shell: rotar, limpiar y dejar el hook.',
            'content' => <<<'HTML'
<p>Entre el 18&nbsp;y&nbsp;el&nbsp;19&nbsp;de&nbsp;septiembre&nbsp;de&nbsp;2026 desplegué <a href="https://docs.gitguardian.com/ggshield-docs/integrations/git-hooks/pre-commit">GitGuardian ggshield</a> como hook pre-commit en cada repositorio de mi carpeta de desarrollo. La configuración llevó una tarde. Un secreto de prueba sintético bloqueó un commit a la primera, así que el hook funciona.</p>
<p>Escribo mucho código en muchos repositorios. Portales de nefrología, un sistema de información de diálisis, un catálogo de libros, una herramienta de búsqueda de eventos. Todo en solitario y todo en GitHub: proyectos públicos como <em>AlphaGrab</em>, <em>Arenibus</em> y <em>Nefro</em>.</p>
<p>El escáner encontró después un personal access token real. No en un archivo que hubiera ido al commit. En mi propio historial del shell, en la salida del terminal que la mayoría de sistemas guarda en disco por defecto.</p>
<p>La corrección fue sencilla. Roté el token, limpié el historial y dejé el hook pre-commit activo para que no vuelva a ocurrir. Por el camino la configuración del escáner se rompía hasta que corregí la codificación del archivo (Windows cp1250 frente a UTF-8). El hook se quedó.</p>
<p>Cuando trabajas solo, eres todo el equipo de seguridad. No hay DevSecOps, no hay compañero de revisión de código, no hay red team. Las herramientas tienen que vigilar por ti.</p>
<p>Un hook pre-commit que bloquea secretos no cuesta nada de instalar y detiene el commit antes de que un token salga hacia el repositorio.</p>
<p>Si escribes código sin un escáner de secretos en la cadena pre-commit, ponlo antes del próximo commit.</p>

<p><em>Experiencia personal del autor al endurecer su propio entorno de desarrollo. No es una guía para eludir escáneres ni para extraer secretos del historial.</em></p>
HTML,
        ],
        'pl' => [
            'title' => 'Zainstalowałem skaner sekretów we wszystkich repozytoriach. Od razu znalazł mój własny token API w historii shella.',
            'image_alt' => 'Nocne biurko: programista trzyma świecący klucz przed monitorem z turkusowo-fioletowym łukiem światła; bez czytelnego tekstu.',
            'excerpt' => 'GitGuardian ggshield jako hook pre-commit w moich solowych projektach. Syntetyczny sekret testowy zablokował commit. Potem skaner znalazł prawdziwy personal access token w historii shella: rotacja, czyszczenie, hook zostaje.',
            'content' => <<<'HTML'
<p>Między 18&nbsp;a&nbsp;19&nbsp;września&nbsp;2026 wdrożyłem <a href="https://docs.gitguardian.com/ggshield-docs/integrations/git-hooks/pre-commit">GitGuardian ggshield</a> jako hook pre-commit w każdym repozytorium w folderze deweloperskim. Konfiguracja zajęła wieczór. Syntetyczny sekret testowy zablokował commit za pierwszym razem, więc hook działa.</p>
<p>Piszę dużo kodu w wielu repozytoriach. Portale nefrologiczne, system informacji dializacyjnej, katalog książek, narzędzie do wyszukiwania wydarzeń. Wszystko sam i wszystko na GitHubie: publiczne projekty takie jak <em>AlphaGrab</em>, <em>Arenibus</em> i <em>Nefro</em>.</p>
<p>Skaner znalazł potem prawdziwy personal access token. Nie w pliku, który poszedłby do commita. We własnej historii shella, w wyjściu terminala, które większość systemów domyślnie zapisuje na dysk.</p>
<p>Naprawa była prosta. Wymieniłem token, wyczyściłem historię i zostawiłem hook pre-commit włączony, żeby się to nie powtórzyło. Po drodze konfiguracja skanera psuła się, dopóki nie poprawiłem kodowania pliku (Windows cp1250 versus UTF-8). Hook został.</p>
<p>Gdy pracujesz nad kodem sam, jesteś całym zespołem bezpieczeństwa. Nie ma DevSecOps, partnera do code review ani red teamu. Narzędzia muszą pilnować za ciebie.</p>
<p>Hook pre-commit, który blokuje sekrety, nic nie kosztuje w instalacji i zatrzymuje commit, zanim token wyjdzie do repozytorium.</p>
<p>Jeśli piszesz kod bez skanera sekretów w łańcuchu pre-commit, włóż go tam przed następnym commitem.</p>

<p><em>Osobiste doświadczenie autora ze wzmocnieniem własnego środowiska deweloperskiego. To nie jest przewodnik po omijaniu skanerów ani po wyciąganiu sekretów z historii.</em></p>
HTML,
        ],
        'hu' => [
            'title' => 'Titokszkennert telepítettem az összes repómba. Azonnal megtalálta a saját API-tokenemet a shell előzményeiben.',
            'image_alt' => 'Éjszakai íróasztal: fejlesztő izzó kulcsot tart egy türkiz-lila fényíves monitor előtt; nincs olvasható szöveg.',
            'excerpt' => 'GitGuardian ggshield pre-commit hookként a solo projekteimben. Egy szintetikus teszt-titok blokkolta a commitot. Aztán a szkenner valódi personal access tokent talált a shell történetében: forgatás, tisztítás, a hook marad.',
            'content' => <<<'HTML'
<p>2026.&nbsp;szeptember&nbsp;18.&nbsp;és&nbsp;19.&nbsp;között <a href="https://docs.gitguardian.com/ggshield-docs/integrations/git-hooks/pre-commit">GitGuardian ggshield</a>-et vezettem be pre-commit hookként a fejlesztői mappa minden repójában. A beállítás egy estébe telt. A szintetikus teszt-titok elsőre blokkolta a commitot, a hook tehát működik.</p>
<p>Sok kódot írok sok repozitóriumban. Nephrológiai portálok, dialízis információs rendszer, könyvkatalógus, eseménykereső eszköz. Mindent egyedül, és mindent GitHubon: nyilvános projektek, például <em>AlphaGrab</em>, <em>Arenibus</em> és <em>Nefro</em>.</p>
<p>A szkenner ezután valódi personal access tokent talált. Nem olyan fájlban, ami bekerült volna a commitba. A saját shell-előzményeimben, a terminálkimenetben, amelyet a legtöbb rendszer alapból lemezre ment.</p>
<p>A javítás egyszerű volt. Lecseréltem a tokent, töröltem az előzményeket, és a pre-commit hookot bekapcsolva hagytam, hogy ne ismétlődjön. Útközben a szkenner konfigurációja addig tört, amíg nem javítottam a fájl kódolását (Windows cp1250 versus UTF-8). A hook maradt.</p>
<p>Ha a kódon egyedül dolgozol, te vagy a teljes biztonsági csapat. Nincs DevSecOps, nincs partner a code review-hoz, nincs red team. Az eszközöknek kell őrködniük helyetted.</p>
<p>Egy pre-commit hook, amely blokkolja a titkokat, semmibe sem kerül telepíteni, és megállítja a commitot, mielőtt a token a repozitóriumba kerülne.</p>
<p>Ha titokszkenner nélkül írsz kódot a pre-commit láncodban, tedd bele a következő commit előtt.</p>

<p><em>A szerző személyes tapasztalata a saját fejlesztői környezetének megerősítéséről. Nem útmutató szkennerek megkerüléséhez vagy titkok előzményekből való kinyeréséhez.</em></p>
HTML,
        ],
        'it' => [
            'title' => 'Ho installato uno scanner di segreti su tutti i miei repository. Ha subito trovato uno dei miei token API nella cronologia della shell.',
            'image_alt' => 'Scrivania notturna: uno sviluppatore tiene una chiave luminosa davanti a un monitor con un arco di luce turchese-viola; nessun testo leggibile.',
            'excerpt' => 'GitGuardian ggshield come hook pre-commit sui miei progetti solo. Un segreto di test sintetico ha bloccato un commit. Poi lo scanner ha trovato un vero personal access token nella cronologia della shell: ruotare, pulire, tenere l’hook.',
            'content' => <<<'HTML'
<p>Tra il 18&nbsp;e&nbsp;il&nbsp;19&nbsp;settembre&nbsp;2026 ho messo <a href="https://docs.gitguardian.com/ggshield-docs/integrations/git-hooks/pre-commit">GitGuardian ggshield</a> come hook pre-commit in ogni repository della mia cartella di sviluppo. La configurazione ha richiesto una serata. Un segreto di prova sintetico ha bloccato un commit al primo tentativo, quindi l’hook funziona.</p>
<p>Scrivo molto codice in molti repository. Portali di nefrologia, un sistema informativo dialitico, un catalogo di libri, uno strumento per cercare eventi. Tutto da solo e tutto su GitHub: progetti pubblici come <em>AlphaGrab</em>, <em>Arenibus</em> e <em>Nefro</em>.</p>
<p>Lo scanner ha poi trovato un vero personal access token. Non in un file che sarebbe finito nel commit. Nella mia cronologia della shell, nell’output del terminale che la maggior parte dei sistemi salva su disco per impostazione predefinita.</p>
<p>La correzione era semplice. Ho rinnovato il token, pulito la cronologia e lasciato l’hook pre-commit attivo, così non succede più. Lungo la strada la configurazione dello scanner si rompeva finché non ho corretto la codifica del file (Windows cp1250 versus UTF-8). L’hook è rimasto.</p>
<p>Quando lavori al codice da solo, sei l’intero team di sicurezza. Non c’è DevSecOps, non c’è un partner per la code review e non c’è un red team. Gli strumenti devono fare la guardia al posto tuo.</p>
<p>Un hook pre-commit che blocca i segreti non costa nulla da installare e ferma il commit prima che un token esca verso il repository.</p>
<p>Se scrivi codice senza uno scanner di segreti nella catena pre-commit, mettilo prima del prossimo commit.</p>

<p><em>Esperienza personale dell’autore sul rafforzamento del proprio ambiente di sviluppo. Non è una guida per aggirare gli scanner né per estrarre segreti dalla cronologia.</em></p>
HTML,
        ],
        'uk' => [
            'title' => 'Я встановив сканер секретів у всі репозиторії. Він одразу знайшов мій власний API-токен в історії shell.',
            'image_alt' => 'Нічний робочий стіл: розробник тримає сяючий ключ перед монітором із бірюзово-фіолетовою дугою світла; без читабельного тексту.',
            'excerpt' => 'GitGuardian ggshield як pre-commit hook у моїх соло-проєктах. Синтетичний тестовий секрет заблокував commit. Потім сканер знайшов справжній personal access token в історії shell: ротація, очищення, хук лишається.',
            'content' => <<<'HTML'
<p>Між 18&nbsp;і&nbsp;19&nbsp;вересня&nbsp;2026 я розгорнув <a href="https://docs.gitguardian.com/ggshield-docs/integrations/git-hooks/pre-commit">GitGuardian ggshield</a> як pre-commit hook у кожному репозиторії в моїй теці розробки. Налаштування зайняло вечір. Синтетичний тестовий секрет заблокував commit з першої спроби, тож хук працює.</p>
<p>Я пишу багато коду в багатьох репозиторіях. Нефрологічні портали, інформаційна система діалізу, каталог книг, інструмент пошуку подій. Усе сам і усе на GitHub: публічні проєкти на кшталт <em>AlphaGrab</em>, <em>Arenibus</em> і <em>Nefro</em>.</p>
<p>Сканер потім знайшов справжній personal access token. Не у файлі, який пішов би в commit. У власній історії shell, у виводі термінала, який більшість систем стандартно зберігає на диск.</p>
<p>Виправлення було простим. Я замінив токен, очистив історію і лишив pre-commit hook увімкненим, щоб це не повторилося. По дорозі конфігурація сканера ламалася, доки я не виправив кодування файлу (Windows cp1250 versus UTF-8). Хук лишився.</p>
<p>Коли ви працюєте над кодом самі, ви і є вся команда безпеки. Немає DevSecOps, немає партнера з code review, немає red team. Інструменти мають стерегти за вас.</p>
<p>Pre-commit hook, який блокує секрети, нічого не коштує встановити і зупиняє commit, перш ніж токен піде в репозиторій.</p>
<p>Якщо ви пишете код без сканера секретів у pre-commit ланцюгу, поставте його перед наступним commit.</p>

<p><em>Особистий досвід автора зі зміцнення власного середовища розробки. Це не інструкція з обходу сканерів і не з витягування секретів з історії.</em></p>
HTML,
        ],
    ],
];
