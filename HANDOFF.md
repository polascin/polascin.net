# Handoff: polascin-site-improvement-loop

_Last updated: 2026-11-05T19:50:00+01:00 · Tool: cursor · Session: loop-dev + daily-doaudit_

## Active Task

1. Self-paced `/loop` for continuous polascin.net fixes (AGENT_LOOP_WAKE_polascin_dev).
2. **Standing:** run `.doaudit.md` once daily (AGENT_LOOP_WAKE_polascin_doaudit).

## Current State

**Done:**

- Beh #75 deployed (`7e1594b`): reporting headers, query cache clear, 2FA is_active, guard, `.codex` exclude.
- Beh #76 (this doaudit): TOTP requires non-empty secret before challenge; Prettier `js/main.js` + static `?v=dfa6b9dd`; fresh DB report `113973b` (STATUS OK, 71 migrations); publication catalog unchanged and matching.

**In flight:**

- Commit/deploy of Beh #76 code + audit notes (if not yet finished in this turn).

**Open / deferred:**

- TOTP enrollment UI missing in `admin_users.php` (helpers + login ready).
- Clarity integrations naming (owner dashboard).
- Nightly Claude routine panel prompt still stale (API 404).

## Next Steps

1. `git pull --ff-only websupport main`.
2. On daily doaudit wake: follow `.doaudit.md` fully; if migration landed after `db-latest.md`, re-run `verify-db`.
3. On 20m dev wake: one concrete defect (prefer TOTP admin enrollment or next RSI item).
4. End each loop: tests, commit `[skip deploy]`, push websupport then origin, deploy if code changed, Beh #NN, rewrite this file + `.codex/handoffs/`.

## Key Decisions

- Daily doaudit is a separate wake from the 20m improvement loop.
- Incomplete TOTP UI documented, not half-implemented in Beh #76.

## Working Environment

- `d:\Dev\polascin.net`, branch `main`.
- Deploy: `hooks/deploy.sh` via Git Bash + SSH `websupport`.
- ggshield: `C:\Python314\Scripts` on PATH for commits.
