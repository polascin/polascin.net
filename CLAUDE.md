# polascin.net: pravidlá projektu pre Claude Code

Dopĺňajú globálne `AGENTS.md`. Vlastný PHP web (bez frameworku), MariaDB, hosting WebSupport, SSH alias `websupport`. Dokumentácia nasadenia je v `DEPLOY.md`, auditný denník v `.audit.md`, runbook v `.doaudit.md`.

## Blogový príspevok (vždy platné pravidlo)

Keď používateľ dodá text alebo inšpiráciu na blog, alebo žiada príspevok zverejniť či upraviť, bez ďalšieho pokynu použi skill `blogovy-prispevok` (`.claude/skills/blogovy-prispevok/SKILL.md`) a dodrž ho celý: tvorivá esej z dodaného textu, humanizácia a hĺbková korektúra, všetkých desať jazykov z `appLanguages()`, ešte jeden redakčný prechod, seed a migrácia, obálka 16:10 vo farbách webu a `php scripts/make_og_covers.php`, PNG na Google Disk účtu polascin@gmail.com, testy, commit `[skip deploy]`, push na `websupport` aj `origin`, lokálne nasadenie cez `hooks/deploy.sh --migrate`, druhý idempotentný beh migrácie, overenie produkcie, potom príspevky s ilustráciou na X (@polascin), Facebook, LinkedIn a Threads, nakoniec vylepšenie článku podľa vlastného úsudku a kontrola, že je všetko commitnuté, pushnuté na `main` a nasadenie overené.

- Ak zdrojový text chýba, zastav sa a vypýtaj si ho. Článok, preklady, obálku, Disk ani siete nerob.
- Ak slug už existuje, nerob duplikát článku ani sociálnych príspevkov.
- Článok na webe nečaká na Disk ani na siete. Čisto dokumentačné zmeny článok nespúšťajú.
- Zoznam slugov už uverejnených na X je iba v `.cursor/skills/blog-article/SKILL.md`; po novom príspevku ho doplň tam.

## TextGrain: trvalý zákaz

Text článku, prekladov, alt textu, sociálnych príspevkov ani ilustrácia nesmú obsahovať textGrain, skryté znaky, zrno, šum ani textúrne prekrytia. Obyčajný text, čistý obraz. Platí natrvalo, aj keď o to niekto požiada znova. Nájdené skryté znaky odstráň.

## Nasadenie a Git

- Z lokálneho počítača nasadzuj len lokálnymi nástrojmi: `hooks/deploy.sh --dry-run`, potom `hooks/deploy.sh` (s `--migrate` pri novej migrácii), cez SSH alias `websupport`. GitHub Actions nie sú cesta nasadenia; existujú len ako ručná záloha a nemeň ich.
- Pred prácou `git pull --ff-only websupport main`. Push poradie: `websupport`, potom `origin` (zrkadlo). Push nič nenasadzuje.
- Commit označ `[skip deploy]`. Hooky nepreskakuj, force push nie. Nekomituj `private/`, `.env`, `*.ini` okrem `env.ini.example`, PNG obálky ani tajomstvá.
- Pred commitom `php -l` zmenených súborov a `php tests/run.php` celé.
- Po nasadení over produkciu: kľúčové URL 200, `/deploy_info.php` a `/i18n.php` 403, CSP s nonce a bezpečnostné hlavičky, zmenený obsah spot-checkom. Výsledok nasadenia zmien kódu zapíš do `.audit.md` (obsah článku sa do auditu nezapisuje).
- Databáza sa plní len cez `setup_db.php` a verzované migrácie; priamy zápis do produkčnej DB nie.
