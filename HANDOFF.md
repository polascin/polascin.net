# Handoff: polascin-site-improvement-loop

_Last updated: 2026-11-07T00:17:00+01:00 · Tool: claude-code · Session: dev loop active_

## Active Task

Vývojová slučka obnovená (/loop, dynamický režim). Posledný Beh #111.

## Current State

**Done:** Beh #101 (`69aa63b`, ETag/304 knižnice), Beh #102 (`b3244f1`, `requestString()` pre verejné vstupy), Beh #103 (`3be6902`, upload nad `post_max_size` hlási 413), Beh #104 (`0899d2b`, `data-submit-once` po bfcache), Beh #105 (`2fac32c`, `lastmod` v sitemape podľa obsahu), Beh #106 (`0651d83`, `og:locale` podľa jazyka obsahu), Beh #107 (`8383cd3`, vek orezaný `appAgeParts()`), Beh #108 (`e8c9a94`, bloky obsahu jedným dotazom), Beh #109 (`d0bfd7a`, `/.well-known/security.txt`; charset je známa výnimka hostingu), Beh #110 (`730afff`, kontakt odmieta CR/LF v mene a predmete), Beh #111 (`785da91`, článok odmieta zalomenie v názve, autorovi a alt texte). Testy 3453. Produkcia nasadená a overená. DB report OK (`888740a`).

**Open (owner):** Clarity integrations; nightly routine panel prompt; optional local TOTP QR SVG.

## Next Steps

1. `git pull --ff-only websupport main && php tests/run.php`
2. Beh #112: revízia `admin_content.php`, `admin_newsletter.php`, `library.php`; po slučke `.doaudit.md`. `security.txt` Expires 2027-11-01: test zlyhá 30 dní vopred.
