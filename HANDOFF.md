# Handoff: polascin-site-improvement-loop

_Last updated: 2026-11-07T03:10:00+01:00 · Tool: claude-code · Session: dev loop active_

## Active Task

Vývojová slučka obnovená (/loop, dynamický režim). Posledný Beh #117.

## Current State

**Done:** Beh #101 (`69aa63b`, ETag/304 knižnice), Beh #102 (`b3244f1`, `requestString()` pre verejné vstupy), Beh #103 (`3be6902`, upload nad `post_max_size` hlási 413), Beh #104 (`0899d2b`, `data-submit-once` po bfcache), Beh #105 (`2fac32c`, `lastmod` v sitemape podľa obsahu), Beh #106 (`0651d83`, `og:locale` podľa jazyka obsahu), Beh #107 (`8383cd3`, vek orezaný `appAgeParts()`), Beh #108 (`e8c9a94`, bloky obsahu jedným dotazom), Beh #109 (`d0bfd7a`, `/.well-known/security.txt`; charset je známa výnimka hostingu), Beh #110 (`730afff`, kontakt odmieta CR/LF v mene a predmete), Beh #111 (`785da91`, článok odmieta zalomenie v názve, autorovi a alt texte), Beh #112 (`948d1cc`, id v admine cez `requestPositiveInt()`), Beh #113 (`e8216cf`, jazyk diel v knižnici, WCAG 3.1.2), Beh #114 (`7749f64`, výber jazyka pri nahrávaní diela), Beh #115 (`b50be21`, lokalizovaná stránka 404), Beh #116 (`eec50b6`, regresia: prázdny cookie banner na každej stránke, šablóna ako `<template>`), Beh #117 (prehliadačové kontroly OK, spevnený `keyboard-audit.mjs`). Testy 3508. Produkcia nasadená a overená. DB report OK (`888740a`).

**Open (owner):** `privacy.s3_item5` obsahuje verejnú vetu „ešte treba doložiť“ (príjemcovia a záruky prenosov GA4); Clarity integrations; nightly routine panel prompt; optional local TOTP QR SVG.

## Next Steps

1. `git pull --ff-only websupport main && php tests/run.php`
2. Beh #118: `layout-audit.mjs` a `print-audit.mjs`, revízia `terms.php`; po slučke `.doaudit.md`. `security.txt` Expires 2027-11-01: test zlyhá 30 dní vopred.
