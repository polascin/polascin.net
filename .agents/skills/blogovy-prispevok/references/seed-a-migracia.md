# Seed súbor článku a migrácia

Vzorom je vždy posledný článok v `content/articles/`. Štruktúra sa nemení.

## `content/articles/{slug}.php`

```php
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
 * Krátky komentár: o čom článok je, dátum udalosti, čo bolo overené a kedy.
 */
return [
    'slug' => '{slug}',
    'author' => 'MUDr. Ľubomír Polaščín',
    'category' => 'blog',
    'is_top' => 0,
    'published_at' => 'YYYY-MM-DD HH:MM:SS',   // teraz, Europe/Bratislava; test odmieta budúcnosť
    'image' => 'images/articles/{slug}.webp',
    'translations' => [
        'sk' => [
            'title' => '...',        // do 255 znakov
            'image_alt' => '...',    // opis obrázka, nie druhý titulok, do 255 znakov
            'excerpt' => '...',      // dve až štyri vety
            'content' => <<<'HTML'
<p>...</p>
<p>...</p>

HTML,
        ],
        'en' => [ /* rovnako */ ],
        'cs' => [ /* rovnako */ ],
        'de' => [ /* rovnako */ ],
        'fr' => [ /* rovnako */ ],
        'es' => [ /* rovnako */ ],
        'pl' => [ /* rovnako */ ],
        'hu' => [ /* rovnako */ ],
        'it' => [ /* rovnako */ ],
        'uk' => [ /* rovnako */ ],
    ],
];
```

Pravidlá obsahu:

- Poradie jazykov ako v `appLanguages()`: sk, en, cs, de, fr, es, pl, hu, it, uk. Všetkých desať je povinných.
- HTML v rozsahu sanitizéra (`sanitizeHtmlContent` v `helpers.php`): `<p>`, `<a href>`, `<strong>`, `<em>`, `<sup>`, `<sub>`, `<small>`, `<code>`, `<blockquote>`, `<ul>/<ol>/<li>`, `<h2>` až `<h6>`, tabuľka v `div.table-responsive` len keď je nutná. V eseji spravidla stačia `<p>` a `<a>`. Žiadny `<script>`, `<style>`, `<iframe>`, žiadny odkaz na `contact.php`.
- Odkazy absolútne (`https://...`). Plný text v knižnici webu prepoj cez `library.php?slug=`.
- Heredoc `<<<'HTML'` s apostrofmi, aby sa nič neinterpolovalo. Pred `HTML,` nechaj prázdny riadok ako v existujúcich súboroch.
- Vlastné mená, čísla a dátumy rovnaké vo všetkých jazykoch.

## Migrácia v `setup_db.php`

Do poľa migrácií pridaj na koniec nový kľúč `YYYYMMDDNN_short_name` (dátum, poradové číslo dňa, krátky anglický názov so sufixom `_article`):

```php
'2026102901_short_name_article' => static function (PDO $pdo): void {
    seedPublishedArticleFromFile(
        $pdo,
        __DIR__ . '/content/articles/{slug}.php'
    );
},
```

Ten istý kľúč pridaj na koniec `EXPECTED_MIGRATIONS` v `scripts/audit_db_check.php`. Test v `tests/run.php` stráži zhodu oboch zoznamov.

`seedPublishedArticleFromFile` existujúce dvojice `(slug, lang)` neprepisuje, doplní chýbajúce preklady a aktualizuje obálku. Je idempotentná: druhý beh `setup_db.php` nesmie nič zmeniť.

## Oprava už zverejneného článku

Text uprav v seed súbore (vo všetkých jazykoch, ktorých sa oprava týka) a pridaj novú migráciu:

```php
'2026102902_short_name_text_refresh' => static function (PDO $pdo): void {
    refreshPublishedArticleTextFromFile(
        $pdo,
        __DIR__ . '/content/articles/{slug}.php'
    );
},
```

Rovnaký kľúč opäť do `EXPECTED_MIGRATIONS`. Sociálne príspevky k existujúcemu slugu nezakladaj znova.
