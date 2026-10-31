# Handoff: claude/kontrola-opravy-vylepsovani-c22320
_Last updated: 2026-10-31T05:59:41+01:00 · Tool: claude-code · Session: default_

## Active Task
Continuous audit, fix and improvement loop for polascin.net (custom PHP + MariaDB on WebSupport); the loop is stopped and all work is committed, pushed and deployed.

## Current State
**Done:**
- Beh #46 to #50, #55 recorded in `.audit.md` (end of file). Fixes deployed and verified on production.
- Header fixes: `.htaccess:11-26` uses `Header always setifempty` for X-Frame-Options and X-Robots-Tag; server-side parent `.htaccess` above web root changed the same way (backup in `<account>/polascin.net/private/deploy-backups/parent-htaccess.20261027-121354`).
- `auth.php` (top, after requires): 405 for methods other than GET/HEAD/POST; 301 for PATH_INFO URLs.
- `helpers.php` `copySanitizedHtmlChildren()`: allows table tags, `small`, `sup`, `sub`, `code`; wraps tables in `div.table-responsive` once.
- Performance: `CrystalKidney-640.webp` used in `index.php`; 1 MB favicon link removed from `head_meta.php`.
- GitHub independence (Beh #49): bare repo `websupport:git/polascin.net.git` (remote `websupport`); `hooks/deploy.sh` archive transport (git archive over SSH + server rsync), `--dry-run` compares server to HEAD, `--smoke-only`, post-deploy smoke check; `hooks/ops/nightly.sh` + `hooks/ops/crontab.txt` installed in server crontab (retention 21:17, verify-db 21:37 Europe/Bratislava); GitHub workflows reduced to `workflow_dispatch` only.
- Beh #55: all em/en dashes replaced in articles (10 languages), `lang/*.php`, templates, static HTML, docs, comments; migration `2026103101_replace_dashes_in_articles` in `setup_db.php` applied on production; test in `tests/run.php` (after the sanitizer tag probe, ~line 146) forbids dashes in content, lang, templates.
- `AGENTS.md` and `.agents/skills/blogovy-prispevok/` (Codex versions of project rules and blog skill) committed in `4c6a6b0`.
- PreCompact hook of plugin `session-handoff` emptied (outside repo); backup `C:\Users\polas\.claude\backups\session-handoff-hooks.json.20261031-055833`.

**In flight:**
- Nothing. Working tree clean; `main` = `websupport/main` = `origin/main` = `4c6a6b0`.

**Tried and rejected:**
- Mechanical `" — " -> ", "` replacement: rejected, wrong in Ukrainian copula sentences and Spanish paired incisos; used per-language manual judgement instead.
- Disabling GitHub `verify-db.yml` schedule while keeping it: rejected, two report commits to two remotes would diverge history; server cron is now the only scheduled job.

## Next Steps
1. Check first real retention run: `ssh websupport 'tail -20 ~/polascin.net/private/ops-retention.log'` (cron 21:17 local).
2. Before any work: `git pull --ff-only websupport main`; push order `websupport`, then `origin`.
3. Deploy only via `hooks/deploy.sh --dry-run`, then `hooks/deploy.sh` (`--migrate` for new migrations); verify with `hooks/deploy.sh --smoke-only`.

## Key Decisions
- **Decision:** Server crontab replaces GitHub scheduled jobs · **Why:** owner asked for GitHub independence; server has git, rsync, flock · **Alternative considered:** keep GitHub schedules (rejected: report history divergence).
- **Decision:** Kept dashes in Google Drive folder name `polascin.net – obálky blogu` in skill docs · **Why:** real folder name, path would break · **Alternative considered:** rename (needs Drive rename first, owner's call).
- **Decision:** Did not edit `.github/workflows/*` dashes · **Why:** `CLAUDE.md` forbids changing workflows · **Alternative considered:** none.

## Open Questions
- [ ] Cloud nightly routine `trig_01H8nMFqCZagX3YhSZqVWE8a` still clones from GitHub and has no SSH to the host: move it to a local scheduler on the Windows PC, or keep it as code-only audit?
- [ ] Rename Drive folder `polascin.net – obálky blogu` to remove the en dash?
- [ ] Stale branch `origin/docs/doaudit-rutina-2026-10-24` (one obsolete `.doaudit.md` change): delete or keep?

## Working Environment
- Branch: `claude/kontrola-opravy-vylepsovani-c22320` (fast-forwarded to `main`) · Base: `main`
- Commands to run: `php tests/run.php` (2741 checks pass), `php -l` on changed PHP, `node --check js/main.js js/consent-default.js`, `npx prettier --check css/styles.css js/main.js js/consent-default.js .audit.md .doaudit.md README.md DEPLOY.md`
- Known broken / skipped: none. Main checkout reports 2 fewer checks than the worktree (environment-dependent). WebSupport returns 429 after ~25 requests; always read HTTP status when spot-checking.
- Changed files (`git diff --stat HEAD`):
  ```
  (none, working tree clean)
  ```

## Context for the next tool (3-5 sentences)
polascin.net is a plain PHP site deployed from a local machine to WebSupport via SSH alias `websupport`; GitHub is only a mirror and its Actions must not be used as the deploy route. Article content lives in seed files `content/articles/*.php` (10 languages) and reaches the DB only through versioned migrations in `setup_db.php`, which must also be listed in `scripts/audit_db_check.php` EXPECTED_MIGRATIONS. The owner forbids em and en dashes and hidden characters in all text; a test enforces this for content, translations and templates. Project rules are in `CLAUDE.md` (Claude) and `AGENTS.md` (Codex); the audit log `.audit.md` gets a new "Beh #N" entry for each run. Written by Claude Code; any tool can pick it up.
