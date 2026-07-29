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
    'meta.default_description' => 'Dr n. med. Ľubomír Polaščín — nefrolog, internista, tłumacz medyczny, pisarz i programista samouk.',
    'meta.home_title' => 'Strona główna',
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
    'home.logo_alt' => 'Logo Crystal Kidney',
    'home.hero_title' => 'Postęp w zdrowiu nerek',
    'home.hero_subtitle' => 'Dr n. med. Ľubomír Polaščín — oddany doskonałości w nefrologii, dializoterapii, opiece nad pacjentem i technologiach medycznych.',
    'home.cta_about' => 'O mnie',
    'home.cta_articles' => 'Najnowsze artykuły',

    // Strona główna — życiorys
    'home.about_heading' => 'O dr. n. med. Ľubomírze Polaščínie',
    'home.about_intro' => 'Nazywam się Ľubomír Polaščín — z zawodu lekarz, nefrolog i internista, z powołania autor beletrystyki i literatury faktu, a z pasji programista samouk.',
    'home.about_who' => 'Moja praca leży na przecięciu medycyny, opowiadania historii i technologii. Medycyna wyostrza moją precyzję kliniczną; pisanie pozwala mi badać ludzką kondycję poprzez beletrystykę i literaturę faktu; a technologia popycha mnie naprzód w rozwiązywaniu złożonych problemów. Jako konsultant łączę te światy i dostarczam przemyślane, dobrze uzasadnione rozwiązania.',
    'home.who_heading' => 'Kim jestem',
    'home.who_approach' => 'Do każdego wyzwania podchodzę z ciekawością i rzetelnością — czy leczę pacjentów, debuguję kod, tłumaczę wymagający tekst, czy zgłębiam sztuczną inteligencję.',
    'home.bio_heading' => 'Dane biograficzne',
    'home.bio_name' => 'Imię i nazwisko',
    'home.bio_pronunciation' => 'Wymowa',
    'home.bio_email' => 'E-mail',
    'home.bio_web' => 'Strony',
    'home.bio_social' => 'Media społecznościowe',
    'home.identity_heading' => 'Tożsamość zawodowa',
    'home.identity_text' => 'Jestem lekarzem, który ukończył studia z medycyny ogólnej (1995) i uzyskał specjalizację z nefrologii (2009). Specjalizację z chorób wewnętrznych mam z roku 1998, a certyfikat z ultrasonografii jamy brzusznej u dorosłych z roku 2009.',
    'home.expertise_heading' => 'Obszary specjalizacji',
    'home.expertise_dialysis' => 'Dializoterapia i leczenie nerkozastępcze (hemodializa, hemodiafiltracja, hemofiltracja)',
    'home.expertise_vascular' => 'Ultrasonografia dostępów naczyniowych do dializy',
    'home.expertise_elimination' => 'Pozaustrojowe i wewnątrzustrojowe metody eliminacji',
    'home.expertise_plasma' => 'Membranowa separacja osocza i pokrewne metody leczenia',
    'home.expertise_transplant' => 'Przeszczepianie nerek',
    'home.teaching_text' => 'Mam bogate doświadczenie w nauczaniu i wykładaniu chorób wewnętrznych, diabetologii, nefrologii oraz dziedzin pokrewnych. Zajmuję się także tłumaczeniami — angielsko-słowackimi i słowacko-angielskimi przekładami medycznymi oraz lokalizacją oprogramowania.',
    'home.tech_text' => 'Technologie informacyjne, informatyka i programowanie towarzyszą mi od dawna. Interesują mnie przede wszystkim:',
    'home.identity_doctor' => 'Lekarz (dr n. med.)',
    'home.identity_nephrologist' => 'Nefrolog',
    'home.identity_internist' => 'Internista',
    'home.identity_translator' => 'Tłumacz medyczny',
    'home.identity_writer' => 'Autor beletrystyki i literatury faktu',
    'home.identity_programmer' => 'Programista samouk',
    'home.skills_heading' => 'Technologia, IT i programowanie',
    'home.education_heading' => 'Wykształcenie i kariera',
    'home.education_text' => 'Studia medyczne rozpocząłem na Uniwersytecie Pavla Jozefa Šafárika w Koszycach. Od 1995 roku zajmuję się dializoterapią i nefrologią. W latach 2013–2022 pełniłem funkcję ordynatora w dwóch ośrodkach dializ w Bratysławie.',
    'home.personal_heading' => 'Prywatnie',
    'home.personal_text' => 'Urodzony w 1971 roku w Czechosłowacji, wychowałem się w Kyjovie. Moje rusińskie korzenie kształtują sposób, w jaki patrzę na świat. Moje pasje to czytanie, podróże, filozofia i poezja.',
    'home.amazon_cta' => 'Zobacz w Amazon Author Central',

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
