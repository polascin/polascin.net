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

## Substack a Medium (len na výslovnú žiadosť)

| Sieť | Vstup | Poznámky |
|------|-------|----------|
| Substack | `https://polascin.substack.com/publish/post` | Priamy editor, nie sidebar Create. Audience Everyone. Pri „Add subscribe buttons“ klikni „Publish without buttons“, nezaškrtávaj „Don’t ask again“. Verejná URL je `/p/…` bez query. |
| Medium | `https://medium.com/new-story` | Cloudflare „Attention Required!“ alebo editor bez textového poľa znamená stop. Stránku nechaj otvorenú. |
