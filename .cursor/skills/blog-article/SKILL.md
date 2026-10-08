---
name: blog-article
description: >-
  Publishes a polascin.net blog essay from supplied text: proofreading, all
  site languages, cover image, Google Drive PNG, database seed, deploy, and
  social posts. Use when the user supplies text for a blog article on
  polascin.net, asks to publish or zverejniť článok, or mentions obálku,
  jazykové mutácie, or posts on X, Facebook, LinkedIn, Threads, Substack, or Medium.
---

# Blogový článok na polascin.net

Ak slug už existuje, nedej duplikát článku ani sociálne príspevky. Čisto dokumentačné zmeny nie. Článok na webe nenechávaj čakať na Disk ani sociálne siete.

Poradie: korektúra a seed (1+4) → obálka WebP + JPEG pre OG (2, seeder ju vyžaduje) → PNG na Disk (3, môže ísť súbežne) → testy, commit, push, deploy, overenie produkcie → sociálne siete (5).

Jazyky: `sk` (zdroj), `en`, `cs`, `de`, `fr`, `es`, `pl`, `hu`, `it`, `uk` (`appLanguages()`). Autor: `MUDr. Ľubomír Polaščín`. DB sa plní len cez `setup_db.php` (`seedPublishedArticleFromFile`).

## 1. Korektúra a seed

- Jazyková korektúra dodaného textu, fakty over Tavily (názvy, URL, dátumy). Nevyhlasuj rukopis za uverejnený, kým to text nepovie. PDF alebo kniha je zdroj: článok je esej, nie prepis celku. Plný text v knižnici prepoj cez `library.php?slug=`.
- `content/articles/{slug}.php`: 403 guard ako existujúce seed súbory; `slug` `[a-z0-9-]+`; `category` `blog`; `published_at` teraz v Europe/Bratislava (test odmieta budúcnosť); `image` `images/articles/{slug}.webp`.
- Každý jazyk: `title` ≤255, `excerpt`, `image_alt` ≤255, HTML `content`. Žiadny `<script>` a žiadna výzva na kontakt (`contact.php`). Disclaimer pri osobnej alebo medicínskej skúsenosti. Úvod neopakuje titulok.
- `image_alt` opisuje obrázok. Nesmie to byť druhý titulok. Verejný výpis ho dáva do `alt` aj `og:image:alt`.
- CS: slovenské reálie (SOLEN/Via practica, dýchavica → dušnosť, rajón → spád) podľa existujúcich článkov. `skill.md` nechaj ako názov súboru.
- Migrácia `YYYYMMDDNN_short_name` v `setup_db.php` a ten istý kľúč v `scripts/audit_db_check.php` `EXPECTED_MIGRATIONS`. Seeder existujúce `(slug, lang)` nevypisuje; doplní chýbajúce a aktualizuje obálku.

## 2. Obálka

- `GenerateImage`, 16:9, cinematic, bez textu a log, fialová `#3d1a78` a tyrkys `#078d70`. Aj keď požiadavka hovorí 16:10, obálka ostáva 16:9, ideálne 1280×720, najmenej 1200×675.
- Nástroj môže uložiť JPEG s príponou `.png` alebo `.jpg`. Podľa obsahu použi `imagecreatefromjpeg` alebo `imagecreatefrompng`. Výstup: `images/articles/{slug}.webp`, kvalita 82.
- Potom `php scripts/make_og_covers.php`. JPEG dvojička `images/articles/og/{slug}.jpg` ide do commitu. Bez nej test spadne. WebP náhľad LinkedIn nezobrazí.

## 3. PNG na Google Disk

- Z WebP urob skutočné PNG (`imagepng`, signatúra PNG, nie premenovaný JPEG).
- Skopíruj na `G:\Môj disk\polascin.net – obálky blogu\` (účet polascin@gmail.com, priečinok `1MOa4l69tswsLmQB3ZmYAdoZd9gZ5aVas`). Over `image/png` a rozmery.
- PNG necommituj. Lokálne tmp zmaž.

## 4. Test, deploy, produkcia

- `php tests/run.php` musí prejsť.
- Ak je `main` za `origin/main`, najprv `git pull --ff-only`.
- Commit a push na `main`. Hooky nepreskakuj, force push nie. Nekomituj `private/`, `.env`, `*.ini` okrem `env.ini.example`, ani PNG.
- Ak GitGuardian hlási `ggshield: command not found`, pred commit pridaj do `PATH` adresár s `ggshield.exe` pod `%USERPROFILE%\.cache\pre-commit\`. Git config nemeň.
- Počkaj na success workflow **Deploy to polascin.net** vrátane migrácie a smoke checku.
- Over produkciu: `/`, articles, contact, newsletter, sitemap, login HTTP 200; `/deploy_info.php` a `/i18n.php` 403; CSP s nonce a bezpečnostné hlavičky. Spot-check SK, EN a jeden ďalší jazyk plus hreflang v sitemape. `og:image` je JPEG. `og:title` kanonickej stránky je slovenský; anglický titulok v náhľade crawlera je jazyk session, nie chyba seedu.

## 5. Sociálne siete

Až po HTTP 200 kanonickej URL `https://polascin.net/article.php?slug=SLUG` (bez `lang=`). Text vždy slovenský, s touto URL a s ilustráciou. Heslo, passkey ani 2FA nehádaj. Dialóg nechaj otvorený, na danej sieti zastav a pokračuj ostatnými. Sieť, ktorá zlyhá, nahlás; web ostane live. Pred ďalším článkom skontroluj, či slug na profile už nie je.

Prehliadač: `cursor-ide-browser` (tabs → navigate → lock → interact → unlock). CDP `DOM.setFileInputFiles` je zakázané. Ak súbor inak nenahráš, uverejni text a kanonickú URL (OG JPEG z webu) a v reporte napíš, že lokálna príloha zlyhala.

### X.com @polascin

Účet `https://x.com/polascin`, nie `@LPolascin99873` a nie `@polacin`. Overenie: „Odhlásiť používateľa @polascin“, na profile „Upraviť profil“.

Tweet: hook z SK title/excerpt, URL sa počíta ako 23 znakov, pod 280. Pole „Text príspevku“ → „Uverejniť“ v compose, nie v sidebari. Zober `https://x.com/polascin/status/…`.

Po úspechu doplň slug do zoznamu nižšie a ten doplnok commitni ako `docs(rules): … [skip deploy]`.

Už na X (neopakovať): `lekar-ako-pacient-glp1-a-kortikosteroidy`, `ai-agent-bezpecnostny-audit-arenibus`, `hypertenzia-oblicky-algoritmus-pre-vld`, `ai-modely-ako-nastroje-nie-operacny-system`, `ai-recepcna-dvanast-otazok`, `cloudflare-zakaz-ai-trenovania`, `skener-tajomstiev-shell-historia`, `arenibus-v-google-4177-testov`, `ai-book-trailer-ponuka-je-scam`, `atlas-agents-studeny-email-z-icloud`, `awai-dvojstranovy-pribeh-za-1500`, `dobry-skeptik-viac-nez-pochybnost`, `ceresare-z-kyjova`, `ochrana-webu-pred-ai-aj-pred-vlastnou`, `efektivita-sa-doplni`, `inkrementalna-hemodialyza-nie-je-skratka`, `tri-ponuky-za-tyzden-nikto-necital`, `pipeline-ktory-podpisujem`, `co-jestvuje-ked-nic-nezjestvuje`, `prezivanie-je-vychodisko-nie-odpoved`, `aj-clovek-ma-svoj-skill-md`.

### Ostatné siete

| Sieť | Vstup | Ako publikovať |
|------|--------|----------------|
| Facebook | `https://www.facebook.com/lubomir.polascin` | Feed composer, nie skeleton na profile. Text vlož raz. Ak `innerText` ostane prázdny, nepublikuj a nechaj dialóg používateľovi. |
| LinkedIn | `https://www.linkedin.com/in/lubomirpolascin/` alebo `/sharing/compose` | Post to Anyone. Ak je Post disabled, medzera a backspace. URN ber len z príspevku, ktorého text začína hookom. |
| Threads | `https://www.threads.com/@lubomirpolascin` | Cookie banner Decline/Allow. Nepíš `slowly`. Pred Post musí byť hook v `innerText` raz. Pri zdvojení nepublikuj. |
| Substack | `https://polascin.substack.com/publish/post` | Priamy editor, nie sidebar Create. Audience Everyone. Ak vyskočí „Add subscribe buttons“, klikni „Publish without buttons“ a nezaškrtávaj „Don’t ask again“. Verejná URL je v poli na share center (`/p/…`), bez query. |
| Medium | `https://medium.com/new-story` | Cloudflare „Attention Required!“ alebo editor bez textového poľa (iframe) znamená stop. Stránku nechaj otvorenú. |

Ak login, passkey, 2FA alebo Cloudflare zastaví automatizáciu, dialóg nechaj použiteľný a blocker uveď v reporte.
