# Handoff: polascin-site-improvement-loop

_Last updated: 2026-11-05T19:30:00+01:00 · Tool: cursor · Session: loop-dev_

## Active Task

Standing instruction from the owner (Slovak): continue development, bug hunting, fixes, optimisation of polascin.net in a self-paced `/loop`. After each loop save `HANDOFF.md` and a session handoff under `.codex/handoffs/`, then compact or clear context. Collaborate with Grok bots on analyses when useful. Stop only when the owner says so.

## Current State

**Done (this session, Loop 1 / Beh #75):**

- Removed broken reporting headers from `auth.php` (`Expect-CT`, `NEL`, `Report-To`, CSP Report-Only pointing at missing `/.well-known/*` endpoints).
- Call `queryCacheClear()` after every article mutation in `admin_articles.php` and at the end of `setup_db.php`.
- `login.php` 2FA step re-checks `is_active` and clears pending TOTP state for inactive accounts.
- `guard.php` compares `SCRIPT_FILENAME` to `realpath($filename)`, not to `guard.php`.
- Tests: 3310 checks; new guards for the four fixes above.
- Prior work already on `main` at `342fdde`: guard refactor, cookie banner i18n, 2FA scaffolding, query cache, security header experiment (partly reverted by Beh #75).

**In flight:**

- Nothing. Production runs `7e1594b` (Beh #75). Grok headless review hung
  without output and was stopped; retry with a shorter prompt in Loop 2.

**Tried and rejected:**

- Keeping Expect-CT / NEL / Report-To / CSP-RO without a collector: causes browser POSTs to 404.

## Next Steps

1. `git pull --ff-only websupport main` before further work.
2. Loop 2 candidates: verify production headers lack Expect-CT/NEL/Report-To; spot-check login HTML; review TOTP enrollment UI (secret generation exists in helpers but admin UX may be incomplete); external link / publication catalog per `.audit.md` §7; optional `size-adjust` for residual CLS; Clarity integration confirmation still owner-only.
3. Every loop: `php tests/run.php`, `php -l`, Prettier on touched docs/CSS/JS, commit `[skip deploy]`, push `websupport` then `origin`, `hooks/deploy.sh` when code/assets changed, production smoke, Beh #NN in `.audit.md`, rewrite this file and session handoff.
4. Do not treat HTTP 429 as an application defect. Never enter admin credentials.

## Key Decisions

- **Decision:** Drop reporting headers until a real collector exists · **Why:** endpoints 404; CSP-RO group name mismatched Report-To · **Alternative:** implement `/.well-known/reporting` (deferred).
- **Decision:** Invalidate query cache on write, keep 5-minute TTL · **Why:** stale article lists after publish · **Alternative:** per-key invalidation (more code, same outcome here).
- **Decision:** Local deploy via `hooks/deploy.sh` with `[skip deploy]` · **Why:** project AGENTS.md / CLAUDE.md; GitHub Actions are backup only.

## Open Questions

- [ ] Clarity project integrations (if any) must be named in privacy text; owner confirms in dashboard.
- [ ] Nightly routine panel prompt still stale (API 404); mitigated by `.doaudit.md`.
- [ ] TOTP enrollment/admin UI: helpers exist; confirm whether enabling 2FA for users is complete.

## Working Environment

- Branch: `main` at repo root `d:\Dev\polascin.net`, tracking `origin/main` and aligned with `websupport/main` before this loop's commit.
- Commands: `php tests/run.php`, `php -l`, `npx prettier --check …`, `bash hooks/deploy.sh --dry-run` then deploy; ggshield on PATH for pre-commit (`C:\Python314\Scripts`).
- Browser audits: `scripts/browser-audit/` (not deployed). Space production requests; after deploy smoke wait before browser matrix.

## Context for the next tool

polascin.net is plain PHP + MariaDB on WebSupport. Deploy only with local `hooks/deploy.sh` over SSH alias `websupport`. Content changes go through migrations/seeds. Beh #75 fixed four defects introduced or left incomplete by the 2026-11-05 2FA/cache/header work. Next loop should verify production and pick the next concrete defect, not re-litigate closed a11y items from Beh #62 to #74.
