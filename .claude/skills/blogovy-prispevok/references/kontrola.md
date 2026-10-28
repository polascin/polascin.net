# Kontrolný zoznam na záver

Prejdi položky skutočne, nie z pamäti. Čo nesedí, oprav alebo uveď v reporte ako otvorené.

Text

- [ ] Slovenská esej má pointu, úvod neopakuje titulok, žiadna výzva na kontakt, žiadny `<script>`.
- [ ] Desať jazykov (sk, en, cs, de, fr, es, pl, hu, it, uk), každý skontrolovaný zvlášť, rovnaký význam, čísla a mená.
- [ ] Žiadne pomlčky v SK, žiadne skryté znaky, žiadny textGrain v žiadnom výstupe.
- [ ] Fakty overené alebo označené ako neoverené v reporte.
- [ ] Druhý redakčný prechod urobený.

Repozitár

- [ ] `content/articles/{slug}.php`, migrácia v `setup_db.php`, kľúč v `scripts/audit_db_check.php`.
- [ ] `images/articles/{slug}.webp` 1600×1000 a `images/articles/og/{slug}.jpg` v commite. PNG nie.
- [ ] `php tests/run.php` prešiel celý.
- [ ] Commit `[skip deploy]`, `git status` čistý, `git log websupport/main..main` prázdny, `origin/main` zhodný.

Produkcia

- [ ] `hooks/deploy.sh --dry-run` ukázal len súbory článku, potom `--migrate` prebehol.
- [ ] Druhý beh `setup_db.php` na serveri bez zmeny a bez chyby.
- [ ] Kanonická URL 200, `og:image` JPEG 200, SK/EN/ďalší jazyk 200, interné cesty 403, hlavičky a CSP v poriadku.

Mimo webu

- [ ] PNG v priečinku `polascin.net – obálky blogu` na Disku polascin@gmail.com (overené spätne).
- [ ] X, Facebook, LinkedIn, Threads: príspevok so slovenským textom, kanonickou URL a ilustráciou; URL príspevkov v reporte. Zlyhanie siete nahlásené.
- [ ] Slug doplnený do zoznamu na X v `.cursor/skills/blog-article/SKILL.md` a commitnutý.

Záver

- [ ] Článok prečítaný ešte raz a buď vylepšený (migrácia refresh, deploy, overenie), alebo v reporte stojí, že zlepšenie nebolo potrebné.
- [ ] Report: urobené, overené, otvorené. Nič iné.
