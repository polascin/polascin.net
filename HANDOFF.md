# Handoff: polascin-site-improvement-loop

_Last updated: 2026-11-05T21:26:00+01:00 · Tool: cursor · Session: loop-dev + daily-doaudit_

## Active Task

1. Dev `/loop` (`AGENT_LOOP_WAKE_polascin_dev`, ~20 min).
2. Daily `.doaudit.md` (`AGENT_LOOP_WAKE_polascin_doaudit`, 24 h).

## Current State

**Done:** Beh #75–#81 deployed (`adea9dc`). Robots disallow `/.codex/` and `/.claude/`; `totp_begin` regenerates session before `totp_setup_secret`. Smoke OK; `robots.txt` verified on production.

**Open:** Clarity integrations (owner); nightly routine panel prompt; optional local TOTP QR SVG.

## Next Steps

1. `git pull --ff-only websupport main`.
2. Loop 7: next concrete defect.
3. Daily doaudit on its wake only (PID still armed).
