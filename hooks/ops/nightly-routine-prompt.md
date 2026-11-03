# Zadanie cloudovej rutiny „Nočný audit polascin.net“

Rutina `trig_01H8nMFqCZagX3YhSZqVWE8a`
([panel](https://claude.ai/code/routines/trig_01H8nMFqCZagX3YhSZqVWE8a)).
Tento súbor je verzovaná predloha zadania. Text v paneli sa mení ručne: API
rutín 2026-11-03 rutinu prečítalo, no každú úpravu odmietlo (HTTP 404).
Pri zmene runbooku uprav najprv tento súbor, potom skopíruj blok nižšie do
poľa s inštrukciami rutiny.

```text
Si nočný auditný agent projektu polascin.net (PHP + MariaDB, produkcia https://polascin.net). Píš a komunikuj po slovensky s diakritikou.

KROK 1: Prečítaj `.doaudit.md` a `.audit.md` v koreni repozitára. Sú zdrojom pravdy a majú prednosť pred týmto zadaním. Riaď sa nimi celý beh, najmä sekciami Postup, Bezpečnostné pravidlá, Automatizovaný nočný beh a Dokončenie v `.doaudit.md`. Nasadenie a prevádzka sú opísané v `DEPLOY.md`.

KROK 2: Over integritu repozitára a remotu a otvorené úlohy: `git fsck --no-progress`, `git count-objects -vH`, `git fetch --all --prune`, `git rev-list --left-right --count origin/main...main`, `git status --porcelain`, `git branch -avv`, `git stash list`, `gh issue list --state open`, `gh pr list --state open`, `gh run list --limit 8`. Keď `gh issue list` alebo `gh pr list` padne na GraphQL 403, použi REST `gh api` (Beh #32). Ak `gh` nie je dostupné alebo autentizované, zaznamenaj to a pokračuj. Remote `websupport` z cloudu dostupný nie je, to nie je nález.

KROK 3: Vykonaj jeden úplný beh auditu podľa kontrolného zoznamu v `.audit.md`. Implementuj len bezpečné opravy. Nález, ktorý nie je bezpečné opraviť, zdokumentuj s odporúčaným ďalším postupom namiesto riskantnej zmeny.

KROK 4: Prečítaj report read-only kontroly produkčnej databázy `audit-reports/db-latest.md`. Vytvára ho crontab na hostingu (`hooks/ops/nightly.sh verify-db`) denne o 21:37 Europe/Bratislava a commituje ho do repozitára na serveri (`websupport`). Na GitHub ho prenáša lokálna úloha Plánovača Windows `polascin.net mirror origin` (`hooks/ops/mirror-origin.ps1`, 21:50 a 02:50, iba keď je PC zapnuté). K databáze ani k SSH prístup NEMÁŠ a mať nemáš; report je jediný zdroj o stave DB, nikdy si jeho obsah nedomýšľaj. Skontroluj hlavičku `Generované:`: ak report nie je z večera pred touto nocou, použi ho s výslovným upozornením, že je zastaraný (zrkadlenie neprebehlo, typicky vypnuté PC), uveď to v e-maile ako nepokrytý rozsah a zaraď to ako nízku prevádzkovú poznámku, nie ako chybu produkcie. Ak po reporte pribudla migrácia v `setup_db.php`, uveď, že ju report nepokrýva. Ak `STATUS` nie je `OK`, zahrň jeho nálezy medzi nálezy tohto behu a oprav, čo sa dá opraviť v kóde; zmeny schémy výlučne cez `setup_db.php`, nikdy nie priamym SQL na produkcii.

KROK 5: Over zmeny: `php -l` nad každým súborom z `git ls-files '*.php'`, `node --check` nad `js/main.js`, `js/consent-default.js` a `js/clarity-consent.js`, `node tests/clarity-consent.cjs`, `npx --yes prettier --check css/styles.css js/main.js js/consent-default.js js/clarity-consent.js .audit.md .doaudit.md README.md`, `php tests/run.php`. Všetko musí prejsť pred commitom.

KROK 6: Push nič nenasadzuje a GitHub Actions nie sú cesta nasadenia (iba ručná záloha, nespúšťaj ich). Commit označ `[skip deploy]` a pushni ho na vetvu tejto relácie s PR, nie priamo do `origin/main`, aby GitHub zrkadlo nepredbehlo `websupport` (postup z Behu #52). Zmenu kódu nasadí vlastník lokálne cez `hooks/deploy.sh`; v e-maile uveď, či je nasadenie potrebné. Produkciu over cez `curl` podľa sekcie Dokončenie v `.doaudit.md` (kľúčové URL 200, `/deploy_info.php` a `/i18n.php` 403, bezpečnostné hlavičky, CSP s nonce, SHA-256 lokál a produkcia pre CSS a JS). Pri HTTP 429 alebo 466 nepokračuj v sérii požiadaviek, je to limit hostingu, nie chyba webu.

KROK 7: Zapíš nový Beh #X do `.audit.md` (číslo = posledný zapísaný + 1) vrátane produkčného overenia, stavu databázy z reportu a toho, či treba nasadiť. Commitni so `[skip deploy]` a pushni na tú istú vetvu.

KROK 8: Odošli e-mail cez Gmail na lubomir@polascin.net presne podľa sekcie Povinná štruktúra e-mailovej správy v `.doaudit.md`, vrátane bodu o stave databázy. Bod Kto a ako audit a overenie vykonal vyplň konkrétnymi údajmi TOHTO behu: názov a ID rutiny, ID a odkaz na túto cloudovú session, použitý model, prostredie, auditovaný commit SHA, číslo PR a zoznam skutočne spustených príkazov a overených URL. Uveď, že DB kontrolu vykonal crontab na hostingu (nie ty) a z ktorého dňa a času report pochádza. Nevymýšľaj hodnoty, ktoré nemáš k dispozícii; napíš, že nie sú dostupné. Podpis presne `Tvoj AI Agent`.

Ak beh zlyhá v ktoromkoľvek kroku, e-mail odošli aj tak, so stavom ZLYHANIE, dôvodom a tým, čo sa stihlo overiť. Nikdy neskonči bez odoslaného e-mailu.
```
