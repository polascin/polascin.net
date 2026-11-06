# Handoff: polascin-site-improvement-loop

## Metadata

- Generated At: 2026-11-06T19:51:30+01:00
- Project Root: D:\Dev\polascin.net\.claude\worktrees\vyvoj-opravy-vylepsenia-b834d6
- Git Branch: claude/polascin-portal-development-a66fd3 (push na `websupport main`, potom `origin main`)
- Head Commit: 36f3310

## Original Goal

Slučka /loop: postupný vývoj, hľadanie a úplná oprava chýb, optimalizácia polascin.net.
Po každej slučke `.doaudit.md`, handoff, potom ďalšia slučka, kým používateľ nepovie stop.

## Current State

Slučka obnovená 2026-11-06 večer (po pauze po Behu #99). Beh #101 hotový,
nasadený a overený. Working tree čistý. Ďalšia slučka naplánovaná cez ScheduleWakeup.

## Completed This Session

- Beh #101: `library_file.php` ETag (`libraryEtag`), Last-Modified, 304 podľa
  RFC 9110 (`libraryRequestIsFresh` v `helpers.php`), 405 pre iné metódy než GET/HEAD.
- Dielo knižnice nesie `mtime`. 14 nových testov v `tests/run.php` (OK: 3413).

## Validated

- `php -l`, `php tests/run.php` OK: 3413.
- `hooks/deploy.sh` so smoke checkom (69aa63b, 19:47). Produkcia: 200 + ETag, 304, POST 405, 403 interné.
- `verify-db` cez `websupport`: STATUS OK (a818b15).
- Publikácie: nefro 9, Gumroad 9, zhodné s `index.php`.

## Not Yet Validated

- Lokálny `php -S` bez DB vracia 500 (db_config), HTTP správanie sa overuje len testami a produkciou.

## Remaining Work

- Ďalší Beh #102: pokračovať v revízii menej prechádzaných súborov (napr. `sitemap.php`, `article.php`, `admin_library.php`).
- Vlastník: Clarity integrácie, prompt nočnej rutiny v paneli, voliteľne lokálny TOTP QR SVG.

## Decisions

- Push nič nenasadzuje; nasadenie len `hooks/deploy.sh` cez `websupport`.
- Pozor: `taskkill /IM php.exe` ukončí všetky PHP procesy na stroji; nabudúce zastaviť len vlastný server.

## Critical Files

- `.audit.md` (Beh #101), `.doaudit.md`, `library_file.php`, `helpers.php`, `tests/run.php`.

## Next Command

git pull --ff-only websupport main && php tests/run.php
