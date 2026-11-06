# Handoff: beh-111-article-single-line

## Metadata

- Generated At: 2026-11-07T00:17:00+01:00
- Project Root: D:\Dev\polascin.net\.claude\worktrees\vyvoj-opravy-vylepsenia-b834d6
- Git Branch: claude/polascin-portal-development-a66fd3 (push na `websupport main`, potom `origin main`)
- Head Commit: 785da91 (+ docs commit)

## Original Goal

Slučka /loop: vývoj, hľadanie a úplná oprava chýb, optimalizácia polascin.net; po každej slučke `.doaudit.md` a handoff.

## Current State

Beh #111 nasadený a overený. Ďalšia slučka naplánovaná (ScheduleWakeup).

## Completed This Session

- Beh #101: ETag, Last-Modified, 304 a 405 pre `library_file.php`.
- Beh #102: `requestString()` v `helpers.php`, použité v `article.php`, `newsletter.php`, `contact.php`, `login.php`; test zakazuje `(string) $_GET/$_POST[...]` v nich.
- Beh #103: `requestBodyExceededPostLimit()`; `admin_library.php` hlási 413 a limit namiesto falošnej CSRF chyby.
- Beh #104: `js/main.js` po návrate z bfcache (`pageshow`, `event.persisted`) znova povolí tlačidlá `data-submit-once`; pin `?v=ac3068d7` v statických HTML.
- Beh #105: `sitemap.php` dáva `/`, `articles.php` a `library.php` `lastmod` podľa najnovšieho článku v jazyku a najnovšieho diela (`sitemapLatest()`).
- Beh #106: `head_meta.php` `og:locale` podľa `$ogLocaleLang` (článok = `$articleLang`), `og:locale:alternate` len z `$languageAlternates`; test vykresľuje head_meta.
- Beh #107: `appAgeParts()` v `helpers.php` oreže vek na tisíciny; `header.php` a `footer.php` ju používajú.
- Beh #108: `getContentBlock()` načíta aktívne bloky jazyka jedným dotazom so statickou pamäťou na požiadavku; testy na SQLite v pamäti.
- Beh #109: `/.well-known/security.txt` (RFC 9116), povolený v `.htaccess`; test stráži Expires. Charset nejde nastaviť: `/.well-known/` obsluhuje hosting bez `.htaccess`, statické typy určuje openresty (známa výnimka).
- Beh #110: `containsDisallowedSingleLineCharacters()` v `auth.php`; meno a predmet kontaktu odmietnu CR/LF.
- Beh #111: `admin_articles.php` odmietne zalomenie a riadiace znaky v názve, autorovi a alt texte.

## Validated

- `php tests/run.php` OK: 3453; deploy `785da91` 00:15; admin_articles 303, článok 200, interné 403.

## Not Yet Validated

- Serverový PHP error log som nečítal; upload nad limit na produkcii neskúšaný; návrat z bfcache v prehliadači neskúšaný (len testy).

## Remaining Work

- Beh #112: revízia `admin_content.php`, `admin_newsletter.php`, `library.php`.
- Admin súbory ešte používajú `(string) $_POST[...]` (len pre admina, nízka priorita).

## Decisions

- `.htaccess` neplatí pre `/.well-known/` a nemení Content-Type statických súborov (openresty).
- Shell nástroja zlúči zdvojené spätné lomky aj v heredocu: spätnú lomku skladať cez `chr(92)` a kontrolovať `grep -P` na riadiace znaky.
- Lokálny test cez `php -S` nejde bez DB; nezastavovať PHP cez `taskkill /IM php.exe`.

## Critical Files

- `helpers.php` (`requestString`, `libraryEtag`, `libraryRequestIsFresh`), `.audit.md` Beh #101 a #102.

## Next Command

git pull --ff-only websupport main && php tests/run.php
