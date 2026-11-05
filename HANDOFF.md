# Handoff: polascin-site-improvement-loop

_Last updated: 2026-11-05T20:00:00+01:00 · Tool: cursor · Session: loop-dev + daily-doaudit_

## Active Task

1. Self-paced `/loop` for continuous polascin.net fixes (`AGENT_LOOP_WAKE_polascin_dev`, ~20 min).
2. Daily `.doaudit.md` (`AGENT_LOOP_WAKE_polascin_doaudit`, 24 h).

## Current State

**Done:**

- Beh #75: reporting headers, query cache clear, 2FA is_active, guard, `.codex`.
- Beh #76: TOTP requires secret; daily doaudit; DB report refreshed.
- Beh #77 (Loop 2): TOTP enable/disable UI in `admin_users.php` (session pending secret, password + code).

**In flight:**

- Deploy of Beh #77 if not finished in this turn.

**Open:**

- Clarity integrations naming (owner).
- Nightly Claude routine panel prompt (API 404).
- Optional: QR image without third-party host (local SVG later).

## Next Steps

1. `git pull --ff-only websupport main`.
2. Loop 3: next concrete defect (e.g. spot-check production login page, catalog drift, or a11y residual).
3. Daily doaudit wake: full `.doaudit.md`.
4. End each loop: tests, `[skip deploy]` commit, push websupport then origin, deploy if code changed, Beh #NN, HANDOFF + `.codex/handoffs/`, re-arm wake.

## Working Environment

- `d:\Dev\polascin.net`, `main`. Deploy via `hooks/deploy.sh` + SSH `websupport`.
