# Handoff: polascin-site-improvement-loop

_Last updated: 2026-11-06T22:48:00+01:00 · Tool: claude-code · Session: dev loop active_

## Active Task

Vývojová slučka obnovená (/loop, dynamický režim). Posledný Beh #108.

## Current State

**Done:** Beh #101 (`69aa63b`, ETag/304 knižnice), Beh #102 (`b3244f1`, `requestString()` pre verejné vstupy), Beh #103 (`3be6902`, upload nad `post_max_size` hlási 413), Beh #104 (`0899d2b`, `data-submit-once` po bfcache), Beh #105 (`2fac32c`, `lastmod` v sitemape podľa obsahu), Beh #106 (`0651d83`, `og:locale` podľa jazyka obsahu), Beh #107 (`8383cd3`, vek orezaný `appAgeParts()`), Beh #108 (`e8c9a94`, bloky obsahu jedným dotazom). Testy 3442. Produkcia nasadená a overená. DB report OK (`888740a`).

**Open (owner):** Clarity integrations; nightly routine panel prompt; optional local TOTP QR SVG.

## Next Steps

1. `git pull --ff-only websupport main && php tests/run.php`
2. Beh #109: revízia `admin_users.php`, `privacy.php`, `getArticleBySlug`; po slučke `.doaudit.md`.
