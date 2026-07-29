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
 * Polski katalog tłumaczeń.
 *
 * Klucze są stabilnymi identyfikatorami, a nie tekstami. Symbole zastępcze
 * zapisuje się jako `:nazwa`. Plik wywodzi się z `sk.php`; brakujący klucz
 * wraca do katalogu słowackiego.
 */
return [
    // Przełącznik języka
    'lang.switch' => 'Język',
    'lang.switch_aria' => 'Wybierz język strony',
    'lang.current' => 'Aktualny język: :language',

    // Wspólne elementy interfejsu
    'common.site_name' => 'Polascin.net',
    'common.author' => 'dr n. med. Ľubomír Polaščín',
    'common.author_short' => 'Ľubomír Polaščín',
    'common.skip_to_content' => 'Przejdź do treści głównej',
    'common.main_navigation' => 'Nawigacja główna',
    'common.main_content' => 'Treść główna',
    'common.open_navigation' => 'Otwórz nawigację',
    'common.close_navigation' => 'Zamknij nawigację',
    'common.toggle_dark_mode' => 'Przełącz tryb ciemny',
    'common.switch_to_dark' => 'Przełącz na tryb ciemny',
    'common.switch_to_light' => 'Przełącz na tryb jasny',
    'common.required' => 'wymagane',
    'common.back' => 'Wstecz',
    'common.read_more' => 'Czytaj więcej',
    'common.visit' => 'Odwiedź :target',
    'common.opens_new_tab' => 'otwiera się w nowej karcie',
    'common.author_meta_prefix' => 'Autor',

    // Nawigacja
    'nav.home' => 'Strona główna',
    'nav.blog' => 'Blog',
    'nav.about' => 'Życiorys',
    'nav.nephrology' => 'Nefrologia',
    'nav.projects' => 'Projekty',
    'nav.books' => 'Książki',
    'nav.links' => 'Odnośniki',
    'nav.contact' => 'Kontakt',
    'nav.admin' => 'Administracja',
    'nav.logout' => 'Wyloguj się',
    'nav.login' => 'Logowanie',

    // Stopka
    'footer.heading' => 'Nawiążmy kontakt',
    'footer.linkedin' => 'Profil na LinkedIn',
    'footer.x' => 'Profil na X',
    'footer.facebook' => 'Profil na Facebooku',
    'footer.email' => 'Wyślij e-mail',
    'footer.patreon' => 'Wesprzyj na Patreonie',
    'footer.discord' => 'Dołącz na Discordzie',
    'footer.copyright' => '© 1998 – :year Ľubomír Polaščín. Wszelkie prawa zastrzeżone.',
    'footer.privacy' => 'Ochrona prywatności',
    'footer.terms' => 'Warunki korzystania',
    'footer.cookie_settings' => 'Ustawienia plików cookie',

    // Metadane stron
    'meta.keywords' => 'Ľubomír Polaščín, nefrologia, choroby wewnętrzne, dializa, tłumaczenia medyczne, programowanie',
    'meta.default_description' => 'Osobista i zawodowa strona nefrologa oraz internisty, poświęcona dializoterapii, kształceniu specjalistycznemu, pisarstwu medycznemu, tłumaczeniom i technologiom cyfrowym w ochronie zdrowia.',
    'meta.home_tagline' => 'Nefrologia, dializoterapia i technologie medyczne',
    'meta.articles_title' => 'Artykuły',
    'meta.articles_description' => 'Najnowsze artykuły i spostrzeżenia dr. n. med. Ľubomíra Polaščína o nefrologii, chorobach wewnętrznych, technologii i pisaniu.',
    'meta.articles_404_title' => 'Nie znaleziono strony artykułów',
    'meta.articles_404_description' => 'Żądana strona listy artykułów nie istnieje.',
    'meta.article_404_title' => 'Nie znaleziono',
    'meta.article_404_description' => 'Nie znaleziono artykułu.',
    'meta.contact_title' => 'Kontakt',
    'meta.contact_description' => 'Skontaktuj się z dr. n. med. Ľubomírem Polaščínem w sprawach zawodowych, propozycji współpracy lub pytań.',
    'meta.newsletter_title' => 'Newsletter',
    'meta.newsletter_description' => 'Zapisz się na newsletter Polascin.net — nowości z nefrologii, chorób wewnętrznych, książek i technologii.',
    'meta.login_title' => 'Logowanie',
    'meta.login_description' => 'Logowanie administratora w Polascin.net.',
    'meta.privacy_title' => 'Ochrona prywatności',
    'meta.privacy_description' => 'Polityka prywatności serwisu dr. n. med. Ľubomíra Polaščína.',
    'meta.terms_title' => 'Warunki korzystania',
    'meta.terms_description' => 'Warunki korzystania z serwisu dr. n. med. Ľubomíra Polaščína.',

    // Strona główna — sekcja powitalna
    'home.logo_alt' => 'Crystal Kidney',
    'home.hero_eyebrow' => 'Crystal Kidney',
    'home.hero_title' => 'Precyzyjna nefrologia. Ludzka opieka. Sensowne technologie.',
    'home.hero_subtitle' => 'Jestem nefrologiem i internistą z wieloletnią praktyką w dializoterapii i leczeniu chorób nerek. Doświadczenie kliniczne łączę z pisaniem tekstów specjalistycznych, nauczaniem i tworzeniem rozwiązań cyfrowych dla medycyny.',
    'home.cta_about' => 'O mnie',
    'home.cta_articles' => 'Najnowsze artykuły',

    // Strona główna — życiorys
    'home.about_heading' => 'O mnie',
    'home.about_intro' => 'Jestem lekarzem ze specjalizacją z nefrologii i chorób wewnętrznych. Przez większość życia zawodowego zajmuję się chorobami nerek, dializoterapią i opieką nad pacjentami, których leczenie wymaga nie tylko precyzji merytorycznej, lecz także zaufania, zrozumiałej komunikacji i poszanowania indywidualnych potrzeb.',
    'home.about_who' => 'Obok pracy klinicznej piszę teksty specjalistyczne i literackie, zajmuję się tłumaczeniami medycznymi oraz tworzę strony i aplikacje internetowe. Programowania i sztucznej inteligencji nie traktuję jako nowinek dla samych nowinek. Są dla mnie praktycznymi narzędziami, które mogą przybliżać wiedzę, ułatwiać pracę i wspierać trafniejsze decyzje w medycynie.',
    'home.about_synthesis' => 'Medycyna, język i technologie nie są dla mnie odrębnymi dziedzinami. Łączy je to samo pytanie: jak zrozumieć złożony problem i stworzyć rozwiązanie, które jest precyzyjne, zrozumiałe i naprawdę użyteczne.',

    'home.areas_heading' => 'Obszary działalności',
    'home.areas_medicine' => 'Medycyna',
    'home.areas_medicine_1' => 'nefrologia i dializoterapia',
    'home.areas_medicine_2' => 'choroby wewnętrzne',
    'home.areas_medicine_3' => 'leczenie nerkozastępcze',
    'home.areas_medicine_4' => 'ultrasonografia i opieka nad dostępami naczyniowymi',
    'home.areas_medicine_5' => 'konsultacje specjalistyczne i nauczanie',
    'home.areas_language' => 'Język i twórczość autorska',
    'home.areas_language_1' => 'specjalistyczne teksty medyczne',
    'home.areas_language_2' => 'tłumaczenia medyczne i praca terminologiczna',
    'home.areas_language_3' => 'lokalizacja oprogramowania medycznego',
    'home.areas_language_4' => 'beletrystyka, eseje i literatura faktu',
    'home.areas_language_5' => 'popularyzacja medycyny i edukacja pacjentów',
    'home.areas_tech' => 'Technologie',
    'home.areas_tech_1' => 'tworzenie stron i aplikacji internetowych',
    'home.areas_tech_2' => 'kalkulatory medyczne i narzędzia cyfrowe',
    'home.areas_tech_3' => 'automatyzacja przetwarzania informacji',
    'home.areas_tech_4' => 'sztuczna inteligencja w medycynie',
    'home.areas_tech_5' => 'otwarte oprogramowanie oraz systemy Linux/Unix',

    'home.skills_heading' => 'Umiejętności technologiczne',
    'home.skills_web' => 'Technologie internetowe',
    'home.skills_web_text' => 'HTML5, CSS3, JavaScript, TypeScript, PHP',
    'home.skills_data' => 'Dane i programowanie',
    'home.skills_data_text' => 'SQL, Python, systemy baz danych, przetwarzanie danych',
    'home.skills_systems' => 'Systemy i infrastruktura',
    'home.skills_systems_text' => 'Linux, Unix, wolne i otwarte oprogramowanie',
    'home.skills_ai' => 'Sztuczna inteligencja',
    'home.skills_ai_text' => 'generatywna AI, automatyzacja, modele językowe i ich praktyczne zastosowanie w medycynie',

    'home.education_heading' => 'Wykształcenie i droga zawodowa',
    'home.education_text' => 'Studia medyczne ukończyłem na Uniwersytecie Pavla Jozefa Šafárika w Koszycach. Po początkach w chorobach wewnętrznych stopniowo skupiłem się na nefrologii, dializoterapii i metodach eliminacyjnych.',
    'home.education_path' => 'Do nefrologii doprowadziło mnie naturalne połączenie medycyny klinicznej z techniką, która może bezpośrednio wpływać na stan zdrowia i jakość życia pacjenta. Od 1995 roku zajmuję się leczeniem dializacyjnym i chorobami nerek. W latach 2013–2022 kierowałem dwoma ośrodkami dializ w Bratysławie.',
    'home.education_scope' => 'Moje doświadczenie zawodowe obejmuje hemodializę, hemodiafiltrację, dializę otrzewnową, metody eliminacyjne stosowane w stanach ostrych, ultrasonografię, opiekę nad dostępami naczyniowymi oraz przygotowanie pacjentów do przeszczepienia nerki. Praktykę kliniczną uzupełniam pisaniem tekstów specjalistycznych, wykładami, nauczaniem i tworzeniem medycznych projektów cyfrowych.',

    'home.personal_heading' => 'Osobiste spojrzenie',
    'home.personal_text' => 'Czytanie, podróże, filozofia, duchowość i poezja pomagają mi postrzegać medycynę w szerszym kontekście ludzkim. Interesują mnie historie, język, świadomość i pytania wykraczające poza granice jednej dziedziny.',
    'home.personal_writing' => 'W twórczości literackiej wracam przede wszystkim do medycyny, ludzkiej egzystencji, konfliktów moralnych i relacji człowieka z technologiami. Także tutaj szukam tego samego co w medycynie: precyzji, prawdy i głębszego zrozumienia człowieka.',

    'home.identity_nephrologist' => 'Nefrolog',
    'home.identity_internist' => 'Internista',

    'home.books_cta' => 'Książki i twórczość autorska',
    'home.amazon_cta' => 'Profil autora na Amazonie',

    // Strona główna — nefrologia
    'home.nephrology_heading' => 'Nefrologia',
    'home.nephrology_intro' => 'Nefrologia to kluczowa specjalizacja medyczna poświęcona nerkom — narządom niezbędnym do utrzymania równowagi płynów, filtracji produktów przemiany materii i regulacji ciśnienia tętniczego.',
    'home.ckd_title' => 'Przewlekła choroba nerek (PChN)',
    'home.ckd_text' => 'Postępowanie w stopniowej utracie czynności nerek spowodowanej cukrzycą, nadciśnieniem lub innymi czynnikami.',
    'home.aki_title' => 'Ostre uszkodzenie nerek (OUN)',
    'home.aki_text' => 'Leczenie nagłej, często przejściowej utraty czynności nerek wywołanej zakażeniem, odwodnieniem lub toksynami.',
    'home.hemodialysis_title' => 'Hemodializa',
    'home.hemodialysis_text' => 'Zabieg, w którym do oczyszczania krwi wykorzystuje się aparat do dializy i specjalny filtr zwany sztuczną nerką.',
    'home.peritoneal_title' => 'Dializa otrzewnowa',
    'home.peritoneal_text' => 'Metoda leczenia wykorzystująca wyściółkę jamy brzusznej i płyn oczyszczający zwany dializatem do oczyszczania krwi.',
    'home.transplant_title' => 'Przeszczepienie',
    'home.transplant_text' => 'Najlepsza metoda leczenia niewydolności nerek. Zdrową nerkę umieszcza się w ciele, aby wykonywała pracę, której własne nerki pacjenta nie są już w stanie podołać.',
    'home.diagnostics_title' => 'Diagnostyka',
    'home.diagnostics_text' => 'Wykorzystanie ultrasonografii, biopsji nerki i zaawansowanych badań laboratoryjnych do trafnego rozpoznania chorób nerek.',

    // Strona główna — artykuły, projekty, odnośniki, kontakt
    'home.latest_heading' => 'Najnowsze artykuły',
    'home.all_articles' => 'Zobacz wszystkie artykuły',
    'home.projects_heading' => 'Projekty i sieć',
    'home.projects_intro' => 'Wybór stron, narzędzi i zasobów, które tworzę lub prowadzę w obszarze medycyny, edukacji i technologii.',
    'home.project_nefro_text' => 'Słowacki portal nefrologiczny z artykułami klinicznymi, aktualnościami o dializie i przeszczepieniach, kalkulatorami, informacjami o lekach i notatkami do nauki.',
    'home.project_nephrosite_text' => 'Wykłady edukacyjne i strony referencyjne o nefrologii, dializie, metodach oczyszczania krwi i chorobach wewnętrznych (po słowacku).',
    'home.project_books_text' => 'Centralne archiwum książek, publikacji naukowych, rozdziałów i dzieł literackich dr. n. med. Ľubomíra Polaščína.',
    'home.project_alphagrab_text' => 'Eksperymentalny projekt wyszukiwania biletów, który wzbogaca odnośniki zapasowe przez Ticketmaster Discovery API.',
    'home.project_arenibus_text' => 'Publiczna instancja demonstracyjna projektu internetowego o wydarzeniach i transporcie.',
    'home.links_heading' => 'Sieć i zasoby',
    'home.links_intro' => 'Poznaj inne powiązane strony i zasoby.',
    'home.link_nephrosite' => 'NephroSite (po słowacku)',
    'home.link_vital_2nd' => 'Vital Algorithm — wydanie 2. (Amazon)',
    'home.link_vital_1st' => 'The Vital Algorithm — wydanie 1. (Amazon)',
    'home.contact_heading' => 'Kontakt',
    'home.contact_intro' => 'Zapraszam do kontaktu w razie pytań lub chęci współpracy.',
    'home.contact_cta' => 'Wyślij wiadomość',

    // Lista artykułów
    'articles.heading' => 'Artykuły',
    'articles.aria_label' => 'Artykuły',
    'articles.empty' => 'Nie opublikowano jeszcze żadnych artykułów.',
    'articles.page_missing' => 'Żądana strona nie istnieje.',
    'articles.go_first_page' => 'Przejdź do pierwszej strony artykułów',
    'articles.pagination_label' => 'Stronicowanie artykułów',
    'articles.no_translation' => 'Ten artykuł nie jest jeszcze dostępny w wybranym języku. Wyświetlamy wersję oryginalną.',

    // Szczegóły artykułu
    'article.aria_label' => 'Treść artykułu',
    'article.not_found_aria' => 'Nie znaleziono artykułu',
    'article.not_found_heading' => 'Nie znaleziono artykułu',
    'article.not_found_text' => 'Żądany artykuł nie istnieje lub nie został opublikowany.',
    'article.back_to_list' => 'Powrót do artykułów',
    'article.admin_preview' => 'Podgląd administratora — ten artykuł nie jest jeszcze publicznie dostępny.',
    'article.available_in' => 'Dostępne także w językach:',

    // Formularz kontaktowy
    'contact.heading' => 'Kontakt',
    'contact.aria_label' => 'Formularz kontaktowy',
    'contact.name' => 'Imię i nazwisko',
    'contact.email' => 'E-mail',
    'contact.subject' => 'Temat',
    'contact.message' => 'Wiadomość',
    'contact.submit' => 'Wyślij wiadomość',
    'contact.success' => 'Dziękuję za wiadomość. Odezwę się najszybciej, jak to możliwe.',
    'contact.error_name' => 'Podaj prawidłowe imię i nazwisko.',
    'contact.error_email' => 'Podaj prawidłowy adres e-mail.',
    'contact.error_subject' => 'Temat jest za długi.',
    'contact.error_message' => 'Wpisz wiadomość (maks. 5000 znaków).',
    'contact.error_rate_limit' => 'Zbyt wiele wiadomości z tego adresu. Spróbuj ponownie później.',
    'contact.error_save' => 'Nie udało się wysłać wiadomości. Spróbuj ponownie później.',

    // Newsletter
    'newsletter.heading' => 'Newsletter',
    'newsletter.aria_label' => 'Zapis na newsletter',
    'newsletter.intro' => 'Zapisz się, aby otrzymywać nowości o artykułach, książkach i projektach.',
    'newsletter.email' => 'Adres e-mail',
    'newsletter.subscribe' => 'Zapisz się',
    'newsletter.confirm_unsubscribe' => 'Potwierdź wypisanie',
    'newsletter.unsubscribe_prompt' => 'Potwierdź, że chcesz wypisać się z newslettera.',
    'newsletter.unsubscribe_link_invalid' => 'Odnośnik do wypisania jest nieprawidłowy.',
    'newsletter.unsubscribe_link_used' => 'Odnośnik do wypisania jest nieprawidłowy lub został już użyty.',
    'newsletter.unsubscribed' => 'Zostałeś pomyślnie wypisany.',
    'newsletter.confirm_link_used' => 'Odnośnik potwierdzający jest nieprawidłowy lub został już użyty.',
    'newsletter.confirmed' => 'Twoja subskrypcja została potwierdzona. Dziękuję!',
    'newsletter.pending' => 'Jeśli ten adres można zapisać, wysłaliśmy na niego dalsze instrukcje.',
    'newsletter.rate_limit_confirm' => 'Zbyt wiele prób potwierdzenia. Spróbuj ponownie później.',
    'newsletter.rate_limit_unsubscribe' => 'Zbyt wiele prób wypisania. Spróbuj ponownie później.',
    'newsletter.rate_limit_subscribe' => 'Zbyt wiele prób. Spróbuj ponownie później.',
    'newsletter.error_email' => 'Podaj prawidłowy adres e-mail.',
    'newsletter.error_generic' => 'Wystąpił błąd. Spróbuj ponownie później.',
    'newsletter.error_mail_failed' => 'Nie udało się wysłać e-maila potwierdzającego. Spróbuj ponownie później.',
    'newsletter.error_domain' => 'Domena adresu e-mail wygląda na nieprawidłową.',
    'newsletter.error_action' => 'Nieprawidłowa akcja formularza.',
    'newsletter.unsubscribe_hint' => 'Odnośnik do wypisania wysłaliśmy e-mailem. Na wszelki wypadek możesz go zapisać także teraz:',
    'newsletter.unsubscribe_hint_link' => 'wypisz się z newslettera',
    'newsletter.mail_confirm_subject' => 'Potwierdź subskrypcję Polascin.net',
    'newsletter.mail_confirm_body' => "Dziękuję za zainteresowanie newsletterem Polascin.net.\n\nPotwierdź subskrypcję, klikając odnośnik (ważny przez 48 godzin):\n:url\n\nJeśli nie zapisywałeś się na tę subskrypcję, zignoruj tę wiadomość.",
    'newsletter.mail_welcome_subject' => 'Subskrypcja Polascin.net potwierdzona',
    'newsletter.mail_welcome_body' => "Twoja subskrypcja newslettera Polascin.net została potwierdzona.\n\nAby się wypisać:\n:url\n\nJeśli nie zapisywałeś się na tę subskrypcję, skorzystaj z odnośnika do wypisania.",

    // Logowanie
    'login.heading' => 'Logowanie administratora',
    'login.aria_label' => 'Logowanie',
    'login.username' => 'Nazwa użytkownika',
    'login.password' => 'Hasło',
    'login.submit' => 'Zaloguj się',
    'login.error_credentials' => 'Nieprawidłowa nazwa użytkownika lub hasło.',
    'login.error_rate_limit' => 'Zbyt wiele prób logowania. Spróbuj ponownie później.',
    'login.session_expired' => 'Sesja wygasła z powodu bezczynności. Zaloguj się ponownie.',
    'login.account_inactive' => 'Twoje konto nie jest już aktywne. Zaloguj się ponownie.',

    // Wylogowanie (komunikaty pojawiają się na stronie publicznej)
    'logout.success' => 'Zostałeś wylogowany.',
    'logout.csrf_failed' => 'Nie udało się zweryfikować wylogowania. Spróbuj ponownie.',

    // Wspólne błędy
    'error.csrf' => 'Nieprawidłowy token bezpieczeństwa. Odśwież stronę i spróbuj ponownie.',

    // Pliki cookie (przekazywane do JavaScriptu)
    'cookie.title' => 'Pliki cookie analityczne',
    'cookie.description' => 'Za Twoją zgodą użyjemy Google Analytics 4 do pomiaru ruchu. Magazyn reklamowy i personalizacja pozostają wyłączone. Odmowa nie ogranicza korzystania ze strony. Szczegóły znajdziesz w',
    'cookie.privacy_link' => 'polityce prywatności',
    'cookie.decline' => 'Odmawiam',
    'cookie.accept' => 'Zgadzam się',

    // Ochrona prywatności
    'privacy.heading' => 'Ochrona prywatności',
    'privacy.updated' => 'Ostatnia aktualizacja: 28 lipca 2026',
    'privacy.s1_heading' => '1. Wprowadzenie',
    'privacy.s1_text' => 'Witamy w serwisie <strong>polascin.net</strong>. Szanuję Twoją prywatność i zobowiązuję się chronić Twoje dane osobowe. Niniejsza polityka prywatności wyjaśnia, jak postępuję z Twoimi danymi osobowymi podczas wizyty w tym serwisie, oraz opisuje Twoje prawa i przysługującą Ci ochronę prawną.',
    'privacy.s2_heading' => '2. Informacje, które zbieram',
    'privacy.s2_text' => 'Ten serwis ma przede wszystkim charakter informacyjny. Nie wymagam zakładania konta.',
    'privacy.s2_technical' => '<strong>Dane techniczne:</strong> Obejmują adres protokołu internetowego (IP), typ przeglądarki, odwiedzony adres, czas żądania i podstawowe dane o odpowiedzi. Dane te służą bezpieczeństwu, diagnostyce i ochronie formularzy przed nadużyciami. Wrażliwe parametry odnośników są usuwane przed zapisem.',
    'privacy.s2_contact' => '<strong>Formularz kontaktowy:</strong> Jeśli wyślesz wiadomość, zapisuję imię i nazwisko, adres e-mail, temat, treść wiadomości oraz czas wysłania, aby móc na nią odpowiedzieć.',
    'privacy.s2_newsletter' => '<strong>Newsletter:</strong> Przy zapisie przechowuję adres e-mail, czas zapisu oraz kryptograficzne skróty tokenów potrzebnych do potwierdzenia i wypisania się z subskrypcji.',
    'privacy.s2_cookies' => '<strong>Pliki cookie i pamięć lokalna:</strong> Lokalnie przechowuję wyłącznie preferencję motywu (tryb ciemny/jasny), wybrany język oraz Twoją decyzję dotyczącą analityki. <strong>Google Analytics 4 (GA4):</strong> Skrypt analityczny nie jest ładowany, dopóki wyraźnie nie klikniesz przycisku Zgadzam się na pasku zgody. Reklamowe kategorie zgody pozostają wyłączone. Swoją decyzję możesz zmienić w dowolnej chwili przez Ustawienia plików cookie w stopce.',
    'privacy.s3_heading' => '3. Jak wykorzystuję Twoje informacje',
    'privacy.s3_text' => 'Twoje dane wykorzystuję do:',
    'privacy.s3_item1' => 'Udostępniania treści serwisu.',
    'privacy.s3_item2' => 'Zapewnienia bezpieczeństwa serwisu.',
    'privacy.s3_item3' => 'Zapamiętania preferencji motywu, języka i decyzji o analityce.',
    'privacy.s3_item4' => 'Obsługi wiadomości kontaktowych i zarządzania subskrypcją newslettera na Twoje żądanie.',
    'privacy.s3_item5' => 'Analizy ruchu i sposobów korzystania z serwisu za pomocą Google Analytics 4, ale wyłącznie jeśli klikniesz przycisk <strong>Zgadzam się</strong> na pasku zgody na pliki cookie. Podstawa prawna: Twoja zgoda (art. 6 ust. 1 lit. a RODO). Dane analityczne przechowuje Google zgodnie z własnymi zasadami retencji (zwykle nie dłużej niż 14 miesięcy). Zgodę możesz wycofać w dowolnej chwili przyciskiem <strong>Ustawienia plików cookie</strong> w stopce, wybierając opcję <strong>Odmawiam</strong>.',
    'privacy.s4_heading' => '4. Okres przechowywania',
    'privacy.s4_text' => 'Własne techniczne dzienniki dostępu są domyślnie usuwane automatycznie po 90 dniach; operator może ten okres skrócić. Krótkotrwałe wpisy ochrony formularzy są usuwane na bieżąco po upływie okna ochronnego. Wiadomości kontaktowe przechowuję tylko tak długo, jak jest to konieczne do obsługi korespondencji. Adres e-mail newslettera przechowuję do momentu wypisania się.',
    'privacy.s5_heading' => '5. Odnośniki podmiotów trzecich',
    'privacy.s5_text' => 'Serwis może zawierać odnośniki do stron, wtyczek i aplikacji podmiotów trzecich (na przykład Amazona lub serwisów społecznościowych). Kliknięcie takich odnośników może umożliwić podmiotom trzecim zbieranie lub udostępnianie danych o Tobie. Nie mam kontroli nad tymi stronami i nie odpowiadam za ich oświadczenia o ochronie prywatności.',
    'privacy.s6_heading' => '6. Twoje prawa (RODO/CCPA)',
    'privacy.s6_text' => 'W określonych okolicznościach przysługują Ci prawa wynikające z przepisów o ochronie danych osobowych, w tym prawo żądania dostępu do danych, ich sprostowania lub usunięcia albo ograniczenia ich przetwarzania.',
    'privacy.s7_heading' => '7. Kontakt',
    'privacy.s7_text' => 'W razie pytań dotyczących niniejszej polityki prywatności skontaktuj się ze mną pod adresem:',

    // Warunki korzystania
    'terms.heading' => 'Warunki korzystania',
    'terms.updated' => 'Ostatnia aktualizacja: 28 lipca 2026',
    'terms.s1_heading' => '1. Akceptacja warunków',
    'terms.s1_text' => 'Uzyskując dostęp do serwisu <strong>polascin.net</strong> (dalej „Serwis”) i korzystając z niego, akceptujesz warunki i postanowienia niniejszej umowy oraz zobowiązujesz się ich przestrzegać.',
    'terms.s2_heading' => '2. Zastrzeżenie medyczne',
    'terms.s2_important' => '<strong>WAŻNE:</strong> Treści udostępniane w tym serwisie mają charakter wyłącznie informacyjny. <strong>Nie zastępują</strong> profesjonalnej porady lekarskiej, diagnozy ani leczenia.',
    'terms.s2_text' => 'W przypadku jakichkolwiek pytań dotyczących stanu zdrowia zawsze zasięgaj porady swojego lekarza lub innego wykwalifikowanego pracownika ochrony zdrowia. Nigdy nie lekceważ profesjonalnej porady lekarskiej ani nie odkładaj wizyty u lekarza z powodu informacji przeczytanych w tym serwisie.',
    'terms.s3_heading' => '3. Własność intelektualna',
    'terms.s3_text' => 'Treść, struktura, grafika, projekt, kompilacja i pozostałe elementy związane z tym serwisem są chronione obowiązującym prawem autorskim i przepisami o własności intelektualnej. Jakiekolwiek kopiowanie, rozpowszechnianie, wykorzystywanie lub publikowanie tych elementów bądź dowolnej części serwisu przez użytkowników jest surowo zabronione.',
    'terms.s4_heading' => '4. Ograniczenie odpowiedzialności',
    'terms.s4_text' => 'W żadnym wypadku nie ponoszę odpowiedzialności za jakiekolwiek szkody uboczne, pośrednie, wynikowe ani szczególne, ani za jakiekolwiek inne szkody, w tym między innymi za szkody wynikające z utraty zysku, utraty umów, renomy, danych, informacji, przychodów, przewidywanych oszczędności lub relacji biznesowych, niezależnie od tego, czy zostałem poinformowany o możliwości ich wystąpienia, powstałe w związku z korzystaniem z tego serwisu lub z dowolnego serwisu, do którego prowadzą z niego odnośniki.',
    'terms.s5_heading' => '5. Prawo właściwe',
    'terms.s5_text' => 'Niniejsze warunki podlegają prawu Republiki Słowackiej i są zgodnie z nim interpretowane, a Ty nieodwołalnie poddajesz się wyłącznej jurysdykcji jej sądów.',

    // Administracja
    'admin.language' => 'Język',
    'admin.language_hint' => 'Język, w którym napisana jest treść.',
    'admin.translation_group' => 'Grupa tłumaczeń',
    'admin.translation_group_hint' => 'Ten sam numer łączy tłumaczenia tego samego artykułu między językami. Puste pole tworzy nową grupę.',
];
