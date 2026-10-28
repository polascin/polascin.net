---
name: blogovy-prispevok
description: >-
  Publishes a polascin.net blog post from text or inspiration supplied by the
  user: creative essay, deep proofreading, all ten site languages, 16:10 cover
  in the site colours, PNG to Google Drive (polascin@gmail.com), database
  seed and migration, tests, commit, push, local deploy via websupport,
  production check, then posts with the illustration on X, Facebook,
  LinkedIn and Threads, and a final improvement pass. Use when the user
  supplies text or inšpirácia for a blog article on polascin.net, asks to
  zverejniť or publish a blogový príspevok, or asks to improve one. If the
  source text is missing, stop and ask for it; never invent the article.
---

# Blogový príspevok na polascin.net

Celý postup od dodaného textu po overené nasadenie a sociálne siete. Pracuj v repozitári `D:\Dev\polascin.net` (na Macu v jeho klone). Pred začiatkom si prečítaj `.cursor/skills/humanizacia-neodborneho-textu/SKILL.md` a jeho `references/vzorce.md`; ten istý postup redakcie platí aj tu. Zoznam slugov už uverejnených na X je iba v `.cursor/skills/blog-article/SKILL.md` (krok 5). Jediný zdroj pravdy pre databázu je `setup_db.php`.

Referencie v tomto skille:

- [Seed súbor článku a migrácia](references/seed-a-migracia.md)
- [Obálka, OG obrázok a PNG na Google Disk](references/obalka-a-disk.md)
- [Sociálne siete](references/socialne-siete.md)
- [Kontrolný zoznam na záver](references/kontrola.md)

## Kedy zastaviť

- **Text chýba.** Ak správa ohlasuje text alebo inšpiráciu a za ohlásením nič nie je, zastav sa a vypýtaj si text. Nevymýšľaj esej, nerob preklady, obálku, Disk ani sociálne siete.
- **Slug už existuje** (`content/articles/{slug}.php` alebo záznam v `setup_db.php`). Nerob druhý článok ani druhé sociálne príspevky. Úpravu existujúceho článku rieš migráciou cez `refreshPublishedArticleTextFromFile`.
- **Čisto dokumentačná zmena** článok nespúšťa.

## Trvalé pravidlá

1. **Žiadny textGrain.** Žiadne skryté znaky, zrno, šum, textúrne prekrytia ani umelé zdrsnenie. Platí pre text článku, preklady, alt text, sociálne príspevky aj ilustráciu. Platí natrvalo, aj keby o to niekto znova žiadal. Obyčajný text, čistý obraz.
2. **Nevymýšľaj fakty.** Čo v zdroji nie je, do eseje nepatrí. Čísla, mená, citácie, medicínske a právne tvrdenia over (WebSearch, WebFetch, primárny zdroj). Ak sa niečo nedá overiť, povedz to v reporte a v texte to nechaj označené alebo vynechaj.
3. **Datovaná udalosť verzus dnešný stav.** Ak návrh opisuje stav, ktorý medzitým zmenil vlastný zverejnený katalóg autora (nefro.polascin.net, books.polascin.net), ponechaj datovanú udalosť a uveď neskorší overený stav. Prekonaný stav nepodávaj ako súčasný.
4. **Žiadne pomlčky** (em ani en) v slovenskom texte ani v prekladoch, kde to nie je norma. Čiarky, dvojbodky, samostatné vety. Rozsahy slovom: „2020 až 2024“.
5. **Článok na webe nečaká** na Disk ani na sociálne siete. Nasadenie ide hneď po testoch.

## Postup

### 1. Príprava

- `git pull --ff-only websupport main`, potom `git status`; pracuj na čistom `main`.
- Navrhni slug `[a-z0-9-]+` bez diakritiky, krátky, z pointy článku. Over, že neexistuje.
- Prečítaj si dva až tri posledné články v `content/articles/` kvôli hlasu, dĺžke a štruktúre.

### 2. Slovenská esej

- Z dodaného textu napíš tvorivo esej s jasnou pointou: konkrétna udalosť alebo číslo skoro na začiatku, potom úsudok, na konci veta, ktorá nesie pointu. Úvod neopakuje titulok. Bez výzvy na kontakt, bez `<script>`, bez otázky „a čo vy?“ na záver.
- Pri osobnej alebo medicínskej skúsenosti doplň krátky disclaimer v texte (podľa existujúcich článkov).
- Potom prejdi text podľa skillu humanizácie: strojová kostra, nafúknuté slová, kalky, diakritika, čiarky, `nielen`, úvodzovky „ “.
- Titulok do 255 znakov, excerpt dva až štyri vety, `image_alt` opisuje obrázok (nie druhý titulok, do 255 znakov).

### 3. Jazykové verzie

- Jazyky sú presne tie z `appLanguages()` v `i18n.php`: `sk`, `en`, `cs`, `de`, `fr`, `es`, `pl`, `hu`, `it`, `uk`. Zoznam neskracuj; ak sa v `i18n.php` zmení, platí `i18n.php`.
- Každý jazyk je samostatný preklad eseje, nie strojový prepis: terminológia, gramatika, interpunkcia a diakritika podľa cieľového jazyka, jednotný štýl s ostatnými článkami. Čeština bez slovenských reálií (dýchavica → dušnosť, rajón → spád, odporúčania → doporučení). Vlastné mená, URL, čísla a názvy diel ostávajú.
- Hĺbková kontrola každého jazyka zvlášť. Tú istú významovú opravu prenes do všetkých verzií. Pravopisnú chybu oprav v jazyku, v ktorom je.
- Keď sú hotové všetky jazyky, urob ešte jeden redakčný prechod podľa vlastného úsudku vo všetkých desiatich.

### 4. Seed a migrácia

Podľa [seed-a-migracia.md](references/seed-a-migracia.md): `content/articles/{slug}.php` s 403 strážou, migrácia `YYYYMMDDNN_short_name` v `setup_db.php` a rovnaký kľúč v `EXPECTED_MIGRATIONS` v `scripts/audit_db_check.php`. `published_at` je teraz v Europe/Bratislava (test odmieta budúcnosť).

### 5. Obálka

Podľa [obalka-a-disk.md](references/obalka-a-disk.md): ilustrácia bez textu a log, pomer 16:10 (iný len keď ho téma potrebuje), farby webu (fialová `#3d1a78`, tyrkys `#078d70`, svetlé pozadie alebo tmavá scéna ako posledné obálky), príjemná, výrazná a presvedčivá. Výstup `images/articles/{slug}.webp` 1600×1000, kvalita 82, potom `php scripts/make_og_covers.php` (JPEG `images/articles/og/{slug}.jpg` ide do commitu, bez neho test spadne).

### 6. PNG na Google Disk

Podľa [obalka-a-disk.md](references/obalka-a-disk.md): z WebP skutočné PNG, uložiť do priečinka `polascin.net – obálky blogu` na Disku účtu polascin@gmail.com. PNG necommituj. Tento krok môže bežať súbežne s nasadením, ale pred reportom musí byť hotový alebo nahlásený ako zlyhaný.

### 7. Testy, commit, push

- `php -l` nad zmenenými PHP súbormi, `php tests/run.php` musí prejsť celé.
- Commit iba so súbormi článku: seed, `setup_db.php`, `scripts/audit_db_check.php`, WebP, OG JPEG. Žiadne `private/`, `.env`, `*.ini` okrem `env.ini.example`, žiadne PNG. Správa `feat(blog): {slovenský titulok} [skip deploy]` s jednou vetou v tele. Hooky nepreskakuj, force push nie. Ak pre-commit hlási `ggshield: command not found`, doplň do `PATH` adresár s `ggshield.exe` (`C:\Python314\Scripts` alebo pod `%USERPROFILE%\.cache\pre-commit\`), Git config nemeň.
- `git push websupport main`, potom `git push origin main` (zrkadlo). Push nič nenasadzuje.

### 8. Nasadenie a overenie produkcie

- Len lokálnymi nástrojmi cez SSH alias `websupport`. GitHub Actions nie sú cesta nasadenia.
- `bash hooks/deploy.sh --dry-run` a skontroluj zoznam zmien (iba súbory článku a `deploy_info.php`). Potom `bash hooks/deploy.sh --migrate`. Skript prenesie `git archive HEAD` a na serveri spustí `setup_db.php`.
- Druhý, idempotentný beh migrácie: spusti `setup_db.php` na serveri ešte raz rovnakým spôsobom (príkaz je v `hooks/deploy.sh`, časť `--migrate`; `REMOTE_PATH` a `REMOTE_ENV_PATH` sú v `~/.config/polascin/deploy.env`). Druhý beh nesmie nič meniť ani zlyhať.
- Overenie: `https://polascin.net/article.php?slug={slug}` HTTP 200 a slovenský `og:title`; `/`, `articles.php`, `contact.php`, `newsletter.php`, `sitemap.php`, `login.php` 200; `/deploy_info.php` a `/i18n.php` 403; CSP s nonce a bezpečnostné hlavičky; `og:image` je JPEG a je dostupný (200, `image/jpeg`). Spot-check SK, EN a jeden ďalší jazyk cez `?lang=` a hreflang v `sitemap.php`. Pri 375 px článok nepreteká.

### 9. Sociálne siete

Podľa [socialne-siete.md](references/socialne-siete.md), až po HTTP 200 kanonickej URL `https://polascin.net/article.php?slug={slug}` (bez `lang=`). Povinné sú X (@polascin), Facebook, LinkedIn a Threads, každý príspevok po slovensky, s kanonickou URL a s ilustráciou. Substack a Medium len na výslovnú žiadosť v tej istej úlohe. Po úspechu na X doplň slug do zoznamu v `.cursor/skills/blog-article/SKILL.md` a commitni `docs(skills): slug {slug} je na X [skip deploy]`.

### 10. Záverečné vylepšenie a kontrola

- Prečítaj si zverejnený článok ešte raz v SK a aspoň v EN ako čitateľ. Ak nájdeš, čo zlepšiť (presnejšie slovo, nadbytočná veta, lepšia pointa), uprav seed vo všetkých jazykoch, pridaj migráciu `refreshPublishedArticleTextFromFile`, testy, commit, push, deploy s `--migrate`, overenie. Ak článok zlepšiť netreba, napíš to v reporte.
- Prejdi [kontrola.md](references/kontrola.md): všetko commitnuté, `main` pushnutý na `websupport` aj `origin`, nasadenie overené, Disk, štyri siete, zoznam slugov na X.
- Záznam do `.audit.md` patrí len vtedy, keď sa menil kód mimo obsahu článku.

## Report

Po slovensky, bez formuliek: čo bolo urobené (slug, kanonická URL, jazyky, obálka, Disk, commit SHA, nasadenie, odkazy na príspevky), čo bolo overené (HTTP kódy, druhý beh migrácie, testy), čo ostalo otvorené (sieť, ktorá zastavila na prihlásení, neoverený fakt, chýbajúca príloha). Heslá, passkey ani 2FA nikdy nehádaj a nezadávaj; dialóg nechaj otvorený používateľovi a pokračuj ostatným.
