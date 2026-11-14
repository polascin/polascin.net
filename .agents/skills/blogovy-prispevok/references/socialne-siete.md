# Sociálne siete

Spoločné pravidlá:

- Až po HTTP 200 kanonickej URL `https://polascin.net/article.php?slug={slug}` (bez `lang=`) a po tom, čo `og:image` vracia 200.
- Text vždy po slovensky: hook zo slovenského titulku alebo excerptu, jedna až tri vety pointy, kanonická URL. Bez hashtagového spamu (najviac dva), bez emoji, bez pomlčiek, bez textGrainu.
- Vždy s ilustráciou. Použi OG JPEG `images/articles/og/{slug}.jpg` z lokálneho repozitára (alebo PNG z Disku) ako prílohu. Ak sieť po vložení URL ukáže vlastný náhľad s obrázkom z webu, stačí náhľad; inak súbor prilož.
- Pred publikovaním skontroluj profil, či tam slug už nie je (duplikát nerob).
- Heslo, passkey ani 2FA nikdy nehádaj a nezadávaj. Ak sieť žiada prihlásenie, Cloudflare overenie alebo CAPTCHA, zastav na tejto sieti, dialóg nechaj otvorený používateľovi, pokračuj ďalšou sieťou a v reporte uveď blocker. Web ostáva live bez ohľadu na siete.
- Prehliadač: Claude in Chrome (prihlásená relácia používateľa, má nahrávanie súborov) je prvá voľba na publikovanie s prílohou. Vstavaný prehliadač Claude použi len na čítanie a overenie. Ak príloha zlyhá a sieť neurobí náhľad z URL, uverejni text s kanonickou URL a v reporte napíš, že lokálna príloha zlyhala.
- Po každej sieti si zober verejnú URL príspevku do reportu.

## X (@polascin)

- Účet `https://x.com/polascin`. Iný účet v relácii (napr. `@LPolascin99873`) nepoužívaj; over cez „Odhlásiť používateľa @polascin“ alebo „Upraviť profil“ na profile.
- Tweet pod 280 znakov, URL sa počíta ako 23 znakov. Napíš do poľa „Text príspevku“ v composeri, priložiť obrázok, „Uverejniť“ v composeri (nie tlačidlo v bočnom paneli).
- Výsledok `https://x.com/polascin/status/…`.
- Po úspechu doplň slug na koniec zoznamu „Už na X (neopakovať)“ v `.cursor/skills/blog-article/SKILL.md` a commitni `docs(skills): slug {slug} je na X [skip deploy]`, push na `websupport` a `origin`.

## Facebook

- `https://www.facebook.com/lubomir.polascin`, feed composer („Čo máte na mysli?“), nie skeleton na profile.
- Text vlož naraz. URL vlož naraz zo schránky, nie po znakoch (náhľad sa načítava pri každom znaku a hosting vráti 429). Ak náhľad ukáže chybu 429, otvor Sharing Debugger, „Scrape Again“, a nový composer.
- Ak je po vložení `innerText` composeru prázdny, nepublikuj; nechaj dialóg používateľovi.

## LinkedIn

- `https://www.linkedin.com/in/lubomirpolascin/` alebo `https://www.linkedin.com/sharing/compose`, viditeľnosť „Anyone“.
- Vložený text stratí prázdne riadky: odseky oddeľ dvoma Enter priamo v editore. URL vlož. Ak je „Post“ neaktívny, napíš medzeru a Backspace.
- URN príspevku ber len z príspevku, ktorý začína tvojím hookom.

## Threads

- `https://www.threads.com/@lubomirpolascin`. Cookie banner: odmietni nepovinné.
- Pred „Post“ musí byť hook v `innerText` presne raz. Pri zdvojení textu nepublikuj, vyčisti a napíš znova.
- Lexical composer v Cursor IDE browser často neberie `fill`/`type` a Uverejniť dialóg zatvorí bez príspevku na profile. Vtedy nechaj hotový text používateľovi a nevyhlasuj zverejnenie.

## Substack a Medium (len na výslovnú žiadosť)

| Sieť | Vstup | Poznámky |
|------|-------|----------|
| Substack | `https://polascin.substack.com/publish/post` | Priamy editor, nie sidebar Create. Audience Everyone. Pri „Add subscribe buttons“ klikni „Publish without buttons“, nezaškrtávaj „Don’t ask again“. Verejná URL je `/p/…` bez query. |
| Medium | `https://medium.com/new-story` | Cloudflare „Attention Required!“ alebo editor bez textového poľa znamená stop. Stránku nechaj otvorenú. |


## Overené publikovanie 10. novembra 2026

Slug `co-zostane-ked-ai-stichne`, kanonická URL `https://polascin.net/article.php?slug=co-zostane-ked-ai-stichne`:

- Facebook s náhľadom finálnej ilustrácie: https://www.facebook.com/lubomir.polascin/posts/pfbid0z1z8mvZ3nsEYoDKFhBqyqAFM6jPezMnhE95LJnu93U55WB7nqc464rEUigYAsosBl
- LinkedIn s náhľadom finálnej ilustrácie: https://www.linkedin.com/feed/update/urn:li:activity:7525749398547476480/
- X a Threads: v overenej relácii chýbalo prihlásenie; úspešné publikovanie nebolo potvrdené. Pri pokračovaní najprv over profil a existujúce príspevky.

Facebook ani LinkedIn k tomuto slugu nezakladaj znova.

### Súbežné duplicity z druhého chatu, zistené 10. novembra 2026

K rovnakému slugu vznikol pri súbežnom publikovaní ešte jeden pár príspevkov:

- Duplicitný Facebook: https://www.facebook.com/lubomir.polascin/posts/pfbid027ycjtbpQ1bQ9pyVx2j5reGe8zu3yJWSJEpH8XKyJpf7EMyYNUYUVhKLJ1ht3ptsDl
- Duplicitný LinkedIn: https://www.linkedin.com/feed/update/urn:li:activity:7525749798793256960/

Ich odstránenie bolo navrhnuté používateľovi, zatiaľ nie je potvrdené ani vykonané. Existujúce prvé publikácie uvedené vyššie ostávajú zachované. K tomuto článku už nezakladaj ďalší Facebook ani LinkedIn príspevok. X a Threads ostávajú bez potvrdeného zverejnenia. Pred každým externým odoslaním znovu prever stav súbežných úloh a evidenciu publikovania.

## Overené publikovanie 14. novembra 2026

Slug `rast-ktory-zhorsi-pristup`, kanonická URL `https://polascin.net/article.php?slug=rast-ktory-zhorsi-pristup`:

- LinkedIn (text + OG náhľad): https://www.linkedin.com/feed/update/urn:li:activity:7527308178036826112/
- Facebook: v jednej relácii sa na profile objavil odkaz na `slug=rast-ktory-zhorsi-pristup`; po obnovení timeline príspevky v a11y strome často chýbali. Pred ďalším odoslaním over profil; ak príspevok je, neduplikuj. Permalink ešte nie je v tomto zozname.
- X: Cursor IDE browser na passkey/2FA; nepublikované.
- Threads: relácia @lubomirpolascin OK, ale Lexical composer v Cursor browseri neberie spoľahlivo fill/type; klik Uverejniť dialóg zatvorí bez príspevku na profile. Ručné vloženie textu + URL (a PNG z Disku) ostáva potrebné.

LinkedIn k tomuto slugu nezakladaj znova. X a Threads k tomuto slugu zakladaj len po overení, že na profile ešte nie sú.
