# Handoff: polascin-site-improvement-loop

_Last updated: 2026-11-02T01:45:00+01:00 · Tool: copilot-app · Session: ad5172ac-6e20-490f-9348-449181ba7972_

## Active Task

Standing instruction from the owner (Slovak, 2026-11-01): "Pokračuj vo vývoji, opakovanej kontrole, opravách, optimalizácii a vylepšovaní aplikácie webového sídla polascin.net. Pracuj v slučke. Po ukončení každej slučky ulož handoff a session-handoff. Potom compaktuj alebo clearuj kontextové okno." Loop 1 (Microsoft Clarity rollout) and Loop 2 (real-browser audit: navigation fit and navbar contrast) are complete, deployed and verified on production. Loop 3 has not started.

## Current State

**Done:**

- Loop 1, Beh #62 (commit `f509be1`, deployed 2026-11-01 22:42, production verified in all 10 languages): finished the Microsoft Clarity rollout started in `c2affc9`. The disclosure lives in five catalog keys (`privacy.clarity_text`, `privacy.clarity_recipient`, `privacy.clarity_cookies`, `privacy.clarity_policy_link`, `privacy.clarity_cookies_link`) in all 10 `lang/*.php`, rendered by `privacy.php` through `te()`; `privacy.updated` is 1 November 2026; the static fallback `privacy.html` carries the Slovak text. `footer.php` no longer lists the non-existent `/about.php` in `data-paths` and versions the loader by `filemtime`. Prettier applied to `js/main.js` and `js/clarity-consent.js`, `?v=` pins in the three static pages updated.
- New guard block in `tests/run.php` (suite is now 3248 checks): footer tag shape, public-path allow-list plus file existence, the five keys in 10 languages, `privacy.php` uses `te()`, `privacy.html` parity with `lang/sk.php`. Mutation-tested in a scratch copy: three deliberate breaks, three failures.
- Docs: `.audit.md` Beh #62 with the deploy result and stale entries fixed (script list, localStorage key `privacy_consent_clarity_v1`); `.doaudit.md` lists `js/clarity-consent.js` in the Prettier and node checks.
- Loop 2, Beh #63 (commits `b0c5cc9` and `17a6a1b`, deployed 2026-11-02 00:01 and 01:16, production verified): a real-browser audit (puppeteer-core 25.16.0, axe-core 4.14.0, Chrome 156 with real scrollbars) plus PHPStan 2.3.4 (levels 5 and 8) and ESLint 10.14.0, which found no real defect.
  - Navigation fit (`b0c5cc9`): from 1101 px to about 1500 px the desktop navigation did not fit in any of the 10 languages (labels wrapped, bar 84.19 px instead of 77 px, last links clipped). The old overflow check was blind to it because `.navbar` is `position: fixed`. The compact (hamburger) menu now applies up to 1320 px in `css/styles.css` and in `matchMedia("(max-width: 1320px)")` in `js/main.js`; above it the container is capped at 1440 px, items are `white-space: nowrap` and the admin menu wraps as whole items. Guards in `tests/run.php` (3248 to 3254 checks, 7 mutations caught).
  - Navbar contrast (`17a6a1b`): glass `color-mix(in srgb, var(--bg-card) 92%, transparent)` instead of 84 %. Worst case (black backdrop in the light theme, white in the dark theme): 4.13 and 3.60 before, 5.03 and 4.70 after. The guard requires 92 to 100 % (3255 checks, 3 mutations caught). Live `css/styles.css` hash prefix `140a6231`, pinned as `?v=140a6231` in `index.html`, `privacy.html`, `terms.html`.
  - Verified on production: key URLs 200, internal files 403, CSP with nonce, nav fit in 10 languages at 22 widths, axe-core 0 violations (desktop and 390x844 mobile, both themes, banner shown, 10 languages), consent flow (sk, en), pixel contrast, worst-case navbar contrast, server error log (no PHP errors).
  - Not defects: the 15 px horizontal overflow at 320 px (classic scrollbar artifact); uk cold-load CLS 0.153 to 0.26 (Cyrillic font swap plus cookie banner growth, no font preload, optional optimisation); the intermittent `#beatClock` reading 4.22 to 4.31 versus 5.16 (tool artifact, see Key Decisions).
- Beh #46 to #50 and #55 to #63 recorded in `.audit.md`, deployed and verified on production.
- Beh #56: Font Awesome subset. Templates load `css/icons.css` and `fonts/icons-solid.woff2`, `fonts/icons-brands.woff2` (about 18 KB instead of about 300 KB), built by `scripts/build_fa_subset.py`; see README section "Ikony".
- Beh #57: card cover variants `images/articles/card/{slug}-480.webp` and `-960.webp`, produced by `scripts/make_og_covers.php`; `articleCoverHtml()` emits `srcset` and `sizes` when the `$sizes` argument is given (`CARD_COVER_SIZES` in `helpers.php`).
- Beh #58: article detail cover uses the same `srcset` with `ARTICLE_COVER_SIZES` (column measured at 700 px).
- Earlier in this session: header fixes (`setifempty`), 405/PATH_INFO handling in `auth.php`, sanitizer tags, GitHub independence (server cron `hooks/ops/nightly.sh`, local `hooks/deploy.sh`), em/en dash replacement with a test that forbids them.

**In flight:**

- Nothing. Once the docs commit carrying this file is pushed, local HEAD, `websupport/main` and `origin/main` are identical and the working tree is clean.

**Tried and rejected:**

- Mechanical dash replacement: wrong in Ukrainian copula sentences; replaced per language by hand.
- Disabling the GitHub verify-db schedule while keeping it: report commits on two remotes would diverge; the server cron is the only scheduled job.
- Lazy-start PHP sessions for anonymous visitors (they now get `__Host-POLASCINSESSID` and `polascin_lang` on public pages): not done, high risk for CSRF and flash handling and no strong benefit.
- Spot-checking `privacy.html`, `terms.html` and `index.html` over HTTP: the server answers 301 to the `.php` pages, so their content is guarded by tests only.
- A broad pixel-contrast batch over every page and language (about 1 minute per page): stopped on purpose. The worst-case tool with black and white backdrops already bounds every page, and the navbar does not depend on the language.
- Changing site code because of the intermittent `#beatClock` reading: it was a measurement artifact (`a { transition: color 0.3s ease }`), not a site defect.

## Next Steps

1. Before any work: `git fetch websupport main`, then `git pull --ff-only websupport main` (the server cron commits nightly DB reports); push `websupport`, then `origin`.
2. Loop 3, first item: move the browser-audit tools from the temp folder into the repository under `scripts/browser-audit/` (a `package.json` pinning `puppeteer-core` 25.16.0 and `axe-core` 4.14.0, a `README.md` with the pitfalls listed under Working Environment, then the shared `lib`, the nav fit check, the axe scan, the pixel contrast check and the navbar worst case). Add `scripts/browser-audit/node_modules/` to `.gitignore`, run it once from the repo path to prove it works, and add one bullet to `.doaudit.md` (Postup, point 4). `scripts/` is not deployed and the dash test does not scan it, so this is a tooling and docs commit with no deploy.
3. Loop 3, then, if real value remains: production performance under throttling (LCP, CLS, TBT; the one known lead is the uk cold-load CLS 0.153 to 0.26, so font preload or fallback metrics), an external link check, and the live publication catalog check (`.audit.md` section 7).
4. Every loop ends the same way: full `php tests/run.php`, `php -l`, Prettier, commit with `[skip deploy]`, push, `bash hooks/deploy.sh --dry-run` and deploy only if code or served assets changed, verify production, add a "Beh #NN" entry to `.audit.md`, rewrite this file and the session handoff.
5. New article covers: run `php scripts/make_og_covers.php` and commit the og JPEG plus both card variants (tests enforce it). New `fa-*` icon in a template: rerun `scripts/build_fa_subset.py` (venv with fonttools outside the repo) and update the `?v=` pin in `index.html`, `privacy.html`, `terms.html`.
6. If `css/styles.css` changes again: re-pin `?v=` in the three static pages (`php -r 'echo substr(hash_file("sha256","css/styles.css"),0,8);'`), keep the 1320 px breakpoint equal in CSS and JS and keep the navbar glass at 92 % or more (tests enforce all three).

## Key Decisions

- **Decision:** Server crontab replaces GitHub scheduled jobs · **Why:** owner asked for GitHub independence · **Alternative considered:** keep GitHub schedules (report history divergence).
- **Decision:** Icon subset generated by a script and guarded by tests, not hand-edited · **Why:** a missing icon would render as an empty box · **Alternative considered:** inline SVG icons (larger template change).
- **Decision:** Card cover variants generated by the existing `make_og_covers.php` · **Why:** the blog skill already runs it for every new article · **Alternative considered:** a separate script (would be forgotten).
- **Decision:** Clarity disclosure text is stored in catalog keys and rendered through `te()` · **Why:** one source for 10 languages and a testable parity with the static Slovak fallback · **Alternative considered:** hard-coded paragraphs in `privacy.php` (the first Clarity commit did that and leaked English text into the other languages).
- **Decision:** Followed the project runbook (commit, push, deploy, verify after each verified change) · **Why:** `.doaudit.md` and `.cursor/rules/always-commit-push-deploy.mdc` require it and the owner asked for a continuing loop · **Alternative considered:** stop at a verified local state as global AGENTS rule 7 says; revisit if the owner objects.
- **Decision:** Handoff is the tracked `HANDOFF.md` plus an untracked session file · **Why:** `/compact` and `/clear` cannot be triggered from inside a session, so these two files make a context reset lossless.
- **Decision:** Compact navigation breakpoint 1320 px, one row above it · **Why:** the longest (Hungarian) labels need that width with a classic scrollbar, and the old 1100 px limit wrapped labels and clipped links · **Alternative considered:** keep 1100 px (what the site had).
- **Decision:** Navbar glass opacity 92 % · **Why:** 91 % is the integer minimum that keeps `--text-muted` at 4.5:1 over a white backdrop in the dark theme, 92 % adds margin (measured 5.03 and 4.70) · **Alternative considered:** 88 % or 90 % (dark theme over white 4.11 and 4.39, below 4.5).
- **Decision:** No site change for a non-deterministic measurement · **Why:** the intermittent `#beatClock` value came from the tool (a 300 ms colour transition after the hide stylesheet is removed), so the tools now wait 700 ms and use computed colours · **Alternative considered:** raising the contrast further (would not have changed the reading).

## Open Questions

- [ ] Cloud nightly routine `trig_01H8nMFqCZagX3YhSZqVWE8a` still clones from GitHub: move it to a local scheduler or keep it as a code-only audit?
- [ ] Rename the Google Drive folder for blog covers (its name is `polascin.net`, an en dash, then `obálky blogu`) so the name no longer contains the en dash?
- [ ] Stale branch `origin/docs/doaudit-rutina-2026-10-24`: delete or keep?
- [ ] Server leftover `private/deploy-staging-25e8b98-714` (144 MB, 2026-10-31 04:27) from an interrupted deploy: safe to delete once no deploy is running.
- [ ] If the Clarity project has any integration enabled (for example a Google Analytics link), the privacy text must name that recipient. Owner to confirm in the Clarity dashboard; code cannot check it.

## Working Environment

- Branch: `polascin-site-improvement-loop` (git worktree `C:\Users\polas\.copilot\repos\copilot-worktrees\polascin.net\polascin-studious-barnacle`, fast-forwarded to `websupport/main`) · Base: `main`. The main checkout `D:\Dev\polascin.net` is not touched by this session.
- Commands to run: `php tests/run.php` (3255 checks), `php -l` on changed PHP, `npx prettier --check css/styles.css js/main.js js/consent-default.js js/clarity-consent.js .audit.md .doaudit.md README.md`, `node --check js/main.js`, `node tests/clarity-consent.cjs`, `bash hooks/deploy.sh --dry-run` before deploying.
- The pre-commit hook needs ggshield: in PowerShell run `$env:Path = 'C:\Python314\Scripts;' + $env:Path` before `git commit`. Push from the worktree with `git push websupport HEAD:main`, then `git push origin HEAD:main`.
- Browser audit tools (still outside the repo, Loop 3 moves them): `C:\Users\polas\AppData\Local\Temp\polascin-tools\` with `phpstan.phar`, `node_modules` (eslint 10.14.0, puppeteer-core 25.16.0, axe-core 4.14.0), `lib.mjs`, `layout-audit.mjs`, `nav-*.mjs`, `axe-scan.mjs`, `contrast-pixels.mjs`, `nav-worstcase.mjs`, `consent-flow.mjs`, `cls-*.mjs` and `out\` (logs, screenshots). Windows may wipe a temp folder; if it is gone, rebuild from the method in Beh #63.
- Running them: from that folder with `$env:SCROLLBARS='1'` (real scrollbars). `$env:LOCAL_ROOT='<worktree>'` serves the local `css/styles.css` and `js/main.js` over the production HTML (leave it unset to test production). Filters: `LANGS`, `THEMES`, `STATES`, `VIEWPORT`, `PAGES`, `ONLY`; `nav-worstcase.mjs` also takes `BACKDROPS` and `OPACITIES`.
- Measurement pitfalls: wait at least 700 ms after changing styles (colour transition on `a`); use instant scroll and no transitions for two-shot pixel measurements; closed `<details>` content is not painted; fixed elements do not extend `scrollWidth`; media-query width includes the scrollbar and headless Chrome hides scrollbars unless `--hide-scrollbars` is ignored; call `page.setBypassCSP(true)` before navigation to inject styles; wait for `document.fonts.ready`.
- Known broken / skipped: none. WebSupport returns 429 for about two minutes after the deploy smoke check and on bursts; space production requests 2 to 3 seconds apart and never run two browser audits against production at once. No rsync or composer is installed locally. Not covered by the browser audits: the open language menu (`<details open>`) and a full pixel batch over every page and language. The static `index.html`, `privacy.html` and `terms.html` are not Prettier-conformant at HEAD (pre-existing, out of scope).
- Changed files (`git diff --stat HEAD`):
  ```
  docs only: .audit.md, HANDOFF.md (code is committed in b0c5cc9 and 17a6a1b)
  ```

## Context for the next tool (3-5 sentences)

polascin.net is a plain PHP site deployed from a local machine to WebSupport via SSH alias `websupport` with `hooks/deploy.sh`; GitHub is only a mirror and its Actions are not the deploy route. Content reaches the DB only through versioned migrations in `setup_db.php`, which must also be listed in `scripts/audit_db_check.php`. The owner forbids em and en dashes and hidden characters in all text, enforced by tests. Two layout facts are guarded by tests and must stay: the compact navigation breakpoint is 1320 px in both `css/styles.css` and `js/main.js`, and the navbar glass opacity is 92 % or more; Loop 2 also showed that an overflow check through `scrollWidth` misses fixed elements and that a non-deterministic measurement must be explained before any code is changed. Written by the GitHub Copilot app; any tool can pick it up.
