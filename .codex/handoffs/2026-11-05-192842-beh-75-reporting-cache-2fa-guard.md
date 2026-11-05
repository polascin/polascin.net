# Handoff: beh-75-reporting-cache-2fa-guard

## Metadata

- Generated At: 2026-11-05T19:28:42+01:00
- Project Root: D:\Dev\polascin.net
- Git Branch: main
- Head Commit: 342fdde (pre-commit; Beh #75 commit follows)

## Original Goal

Continue improving polascin.net in a self-paced `/loop`: find bugs, fix them completely, optimise, save HANDOFF.md and session handoff after each loop, collaborate with Grok bots. Stop only when the owner says so.

## Current State

Loop 1 (Beh #75) code and tests are done locally. Deploy, production verify, and Grok analysis follow. Tracked `HANDOFF.md` rewritten for this session.

## Completed This Session

- Removed Expect-CT, NEL, Report-To, CSP Report-Only from `auth.php` (no collector endpoints).
- Wired `queryCacheClear()` into `admin_articles.php` mutations and `setup_db.php`.
- `login.php` 2FA re-checks `is_active`.
- Fixed `guard.php` to compare against `realpath($filename)`.
- Added regression guards in `tests/run.php` (3310 checks).
- Updated `.audit.md` Beh #75 and `HANDOFF.md`.

## Validated

- Command: `php -l` on changed PHP; `php tests/run.php`
- Result: lint OK; `OK: 3310 kontrol prešlo.`

## Not Yet Validated

- Assumption: production still serves Expect-CT/NEL until deploy lands
- Risk: if deploy skipped, browsers keep POSTing to missing report URLs
- Assumption: Grok headless review may finish with additional findings
- Risk: miss a TOTP enrollment gap if Grok finds one

## Remaining Work

- [ ] Commit `[skip deploy]`, push `websupport` then `origin`
- [ ] `hooks/deploy.sh --dry-run` then deploy; production smoke (headers without Expect-CT/NEL/Report-To)
- [ ] Loop 2: next defect (TOTP admin UX completeness, catalog §7, or production spot-check)
- [ ] Re-arm dynamic `/loop` wake after each loop

## Decisions Made

- Decision: Drop reporting headers until a real collector exists
- Reason: endpoints 404; CSP-RO referenced wrong Report-To group
- Decision: Invalidate whole query cache on article writes
- Reason: only two cached queries; simple and correct

## Blockers / Open Questions

- Clarity integrations naming (owner dashboard)
- Stale nightly routine panel prompt (API 404)
- Whether TOTP enablement UI for users is complete beyond helpers + login

## Critical Files

- auth.php
- guard.php
- login.php
- admin_articles.php
- setup_db.php
- helpers.php (query cache + TOTP helpers)
- tests/run.php
- HANDOFF.md
- .audit.md
- AGENTS.md

## Recent Commits

- 342fdde docs(audit): záznam 2FA, security headers a query cache
- 750e10a feat: 2FA (TOTP) podpora, doplnkové security headers, query cache
- d60a256 docs(audit): záznam refaktorizácie kódu - guard.php, cookie banner, regex optimalizácie
- 67f3bb3 refactor: jednotný guard mechanizmus, oprava hardcoded HTML v JS, optimalizácia regex
- 773ab06 chore(audit): nočná kontrola produkčnej DB: OK [skip deploy]

## Modified Files

- M .audit.md
- M HANDOFF.md
- M admin_articles.php
- M auth.php
- M guard.php
- M login.php
- M setup_db.php
- M tests/run.php
- A .codex/handoffs/2026-11-05-192842-beh-75-reporting-cache-2fa-guard.md

## Context To Load

- AGENTS.md
- HANDOFF.md
- .audit.md (Beh #75)
- .codex/handoffs/2026-11-05-192842-beh-75-reporting-cache-2fa-guard.md

## Next Command

```text
git pull --ff-only websupport main; php tests/run.php
```
