# Handoff: polascin-site-improvement-loop

_Last updated: 2026-11-01T22:55:00+01:00 · Tool: copilot-app · Session: ad5172ac-6e20-490f-9348-449181ba7972_

## Active Task

Standing instruction from the owner (Slovak, 2026-11-01): "Pokračuj vo vývoji, opakovanej kontrole, opravách, optimalizácii a vylepšovaní aplikácie webového sídla polascin.net. Pracuj v slučke. Po ukončení každej slučky ulož handoff a session-handoff. Potom compaktuj alebo clearuj kontextové okno." Loop 1 (finish the Microsoft Clarity rollout) is complete and deployed. Loop 2 has not started.

## Current State

**Done:**

- Loop 1, Beh #62 (commit `f509be1`, deployed 2026-11-01 22:42, production verified in all 10 languages): finished the Microsoft Clarity rollout started in `c2affc9`. The disclosure lives in five catalog keys (`privacy.clarity_text`, `privacy.clarity_recipient`, `privacy.clarity_cookies`, `privacy.clarity_policy_link`, `privacy.clarity_cookies_link`) in all 10 `lang/*.php`, rendered by `privacy.php` through `te()`; `privacy.updated` is 1 November 2026; the static fallback `privacy.html` carries the Slovak text. `footer.php` no longer lists the non-existent `/about.php` in `data-paths` and versions the loader by `filemtime`. Prettier applied to `js/main.js` and `js/clarity-consent.js`, `?v=` pins in the three static pages updated.
- New guard block in `tests/run.php` (suite is now 3248 checks): footer tag shape, public-path allow-list plus file existence, the five keys in 10 languages, `privacy.php` uses `te()`, `privacy.html` parity with `lang/sk.php`. Mutation-tested in a scratch copy: three deliberate breaks, three failures.
- Docs: `.audit.md` Beh #62 with the deploy result and stale entries fixed (script list, localStorage key `privacy_consent_clarity_v1`); `.doaudit.md` lists `js/clarity-consent.js` in the Prettier and node checks.
- Beh #46 to #50 and #55 to #62 recorded in `.audit.md`, deployed and verified on production.
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

## Next Steps

1. Before any work: `git fetch websupport main`, then `git pull --ff-only websupport main` (the server cron commits nightly DB reports); push `websupport`, then `origin`.
2. Loop 2 (not started): run static analysis that no earlier loop used, from a temp dir outside the repo: PHPStan (phar, start at level 5) on the tracked PHP and ESLint on `js/`. Fix only real defects and add a guard test where it makes sense.
3. Loop 2, if time remains: production check of sitemap and hreflang after the Clarity deploy (space the requests, 429 risk), the live publication catalog check (`.audit.md` section 7), an external link check.
4. Every loop ends the same way: full `php tests/run.php`, `php -l`, Prettier, commit with `[skip deploy]`, push, `bash hooks/deploy.sh --dry-run` and deploy only if code changed, verify production, add a "Beh #NN" entry to `.audit.md`, rewrite this file and the session handoff.
5. New article covers: run `php scripts/make_og_covers.php` and commit the og JPEG plus both card variants (tests enforce it). New `fa-*` icon in a template: rerun `scripts/build_fa_subset.py` (venv with fonttools outside the repo) and update the `?v=` pin in `index.html`, `privacy.html`, `terms.html`.

## Key Decisions

- **Decision:** Server crontab replaces GitHub scheduled jobs · **Why:** owner asked for GitHub independence · **Alternative considered:** keep GitHub schedules (report history divergence).
- **Decision:** Icon subset generated by a script and guarded by tests, not hand-edited · **Why:** a missing icon would render as an empty box · **Alternative considered:** inline SVG icons (larger template change).
- **Decision:** Card cover variants generated by the existing `make_og_covers.php` · **Why:** the blog skill already runs it for every new article · **Alternative considered:** a separate script (would be forgotten).
- **Decision:** Clarity disclosure text is stored in catalog keys and rendered through `te()` · **Why:** one source for 10 languages and a testable parity with the static Slovak fallback · **Alternative considered:** hard-coded paragraphs in `privacy.php` (the first Clarity commit did that and leaked English text into the other languages).
- **Decision:** Followed the project runbook (commit, push, deploy, verify after each verified change) · **Why:** `.doaudit.md` and `.cursor/rules/always-commit-push-deploy.mdc` require it and the owner asked for a continuing loop · **Alternative considered:** stop at a verified local state as global AGENTS rule 7 says; revisit if the owner objects.
- **Decision:** Handoff is the tracked `HANDOFF.md` plus an untracked session file · **Why:** `/compact` and `/clear` cannot be triggered from inside a session, so these two files make a context reset lossless.

## Open Questions

- [ ] Cloud nightly routine `trig_01H8nMFqCZagX3YhSZqVWE8a` still clones from GitHub: move it to a local scheduler or keep it as a code-only audit?
- [ ] Rename the Google Drive folder for blog covers (its name is `polascin.net`, an en dash, then `obálky blogu`) so the name no longer contains the en dash?
- [ ] Stale branch `origin/docs/doaudit-rutina-2026-10-24`: delete or keep?
- [ ] Server leftover `private/deploy-staging-25e8b98-714` (144 MB, 2026-10-31 04:27) from an interrupted deploy: safe to delete once no deploy is running.
- [ ] If the Clarity project has any integration enabled (for example a Google Analytics link), the privacy text must name that recipient. Owner to confirm in the Clarity dashboard; code cannot check it.

## Working Environment

- Branch: `polascin-site-improvement-loop` (git worktree `C:\Users\polas\.copilot\repos\copilot-worktrees\polascin.net\polascin-studious-barnacle`, fast-forwarded to `websupport/main`) · Base: `main`. The main checkout `D:\Dev\polascin.net` is not touched by this session.
- Commands to run: `php tests/run.php` (3248 checks), `php -l` on changed PHP, `npx prettier --check css/styles.css js/main.js js/consent-default.js js/clarity-consent.js .audit.md .doaudit.md README.md`, `node --check js/main.js`, `node tests/clarity-consent.cjs`, `bash hooks/deploy.sh --dry-run` before deploying.
- The pre-commit hook needs ggshield: in PowerShell run `$env:Path = 'C:\Python314\Scripts;' + $env:Path` before `git commit`. Push from the worktree with `git push websupport HEAD:main`, then `git push origin HEAD:main`.
- Known broken / skipped: none. WebSupport returns 429 for about two minutes after the deploy smoke check; space out production requests. No rsync, composer, phpstan or eslint is installed locally.
- Changed files (`git diff --stat HEAD`):
  ```
  docs only: .audit.md, HANDOFF.md (code is committed in f509be1)
  ```

## Context for the next tool (3-5 sentences)

polascin.net is a plain PHP site deployed from a local machine to WebSupport via SSH alias `websupport` with `hooks/deploy.sh`; GitHub is only a mirror and its Actions are not the deploy route. Content reaches the DB only through versioned migrations in `setup_db.php`, which must also be listed in `scripts/audit_db_check.php`. The owner forbids em and en dashes and hidden characters in all text, enforced by tests. Microsoft Clarity loads only on public pages after consent (`js/clarity-consent.js`, tag in `footer.php`) and its privacy text is guarded by tests. Written by the GitHub Copilot app; any tool can pick it up.
