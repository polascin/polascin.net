# Handoff: polascin-site-improvement-loop

_Last updated: 2026-11-07T06:55:00+01:00 · Tool: claude-code · Session: dev loop active_

## Active Task

Vývojová slučka obnovená (/loop, dynamický režim). Posledný Beh #123.

## Current State

**Done:** Beh #101 (`69aa63b`, ETag/304 knižnice), Beh #102 (`b3244f1`, `requestString()` pre verejné vstupy), Beh #103 (`3be6902`, upload nad `post_max_size` hlási 413), Beh #104 (`0899d2b`, `data-submit-once` po bfcache), Beh #105 (`2fac32c`, `lastmod` v sitemape podľa obsahu), Beh #106 (`0651d83`, `og:locale` podľa jazyka obsahu), Beh #107 (`8383cd3`, vek orezaný `appAgeParts()`), Beh #108 (`e8c9a94`, bloky obsahu jedným dotazom), Beh #109 (`d0bfd7a`, `/.well-known/security.txt`; charset je známa výnimka hostingu), Beh #110 (`730afff`, kontakt odmieta CR/LF v mene a predmete), Beh #111 (`785da91`, článok odmieta zalomenie v názve, autorovi a alt texte), Beh #112 (`948d1cc`, id v admine cez `requestPositiveInt()`), Beh #113 (`e8216cf`, jazyk diel v knižnici, WCAG 3.1.2), Beh #114 (`7749f64`, výber jazyka pri nahrávaní diela), Beh #115 (`b50be21`, lokalizovaná stránka 404), Beh #116 (`eec50b6`, regresia: prázdny cookie banner na každej stránke, šablóna ako `<template>`), Beh #117 (prehliadačové kontroly OK, spevnený `keyboard-audit.mjs`), Beh #118 (layout, print, banner OK), Beh #119 (`2174aa1`, limit potvrdzovacích e-mailov podľa adresáta), Beh #120 (`348b454`, dátumy ako `<time datetime>`), Beh #121 (smoke check: `style=`, vlastná 404, security.txt), Beh #122 (nightly.sh a audit_db_check bez nálezu), Beh #123 (`a19b689`, hodiny @beat bez zbytočných zápisov). Testy 3549. Produkcia nasadená a overená. DB report OK (`888740a`).

**Open (owner):** `privacy.s3_item5` a `privacy.s5_text` obsahujú verejnú vetu „ešte treba doložiť“ (príjemcovia a záruky prenosov GA4); Clarity integrations; nightly routine panel prompt; optional local TOTP QR SVG.

## Next Steps

1. `git pull --ff-only websupport main && php tests/run.php`
2. Beh #124: revízia `css/styles.css` (nepoužité selektory, tlač); slučka beží po 60 min; po slučke `.doaudit.md`. `security.txt` Expires 2027-11-01: test zlyhá 30 dní vopred.
