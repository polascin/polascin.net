# Obálka, OG obrázok a PNG na Google Disk

## 1. Generovanie ilustrácie

Použi dostupný nástroj na generovanie obrázkov (v Claude Code typicky Figma MCP `generate_image` alebo Canva `generate-image`; ak ani jeden nie je pripojený, povedz to a požiadaj o obrázok alebo o iný nástroj). Nekresli obálku ručne z tvarov v HTML, ak je generátor dostupný.

Zadanie pre generátor (uprav motív podľa pointy článku, štýl nechaj):

- Motív: jedna konkrétna scéna alebo predmet, ktorý nesie pointu článku. Bez ľudí s rozpoznateľnou tvárou, bez textu, písmen, čísel, log a vodoznakov.
- Farby: fialová `#3d1a78` a tyrkysová `#078d70` ako hlavné akcenty, jemné svetlé pozadie alebo tmavá scéna, ako majú posledné obálky v `images/articles/`. Pred generovaním si dve alebo tri posledné obálky pozri, nech nová zapadne.
- Štýl: čistá ilustrácia alebo pokojná fotografická kompozícia, mäkké svetlo, výrazný stred, dosť „vzduchu“ po stranách pre orez.
- Pomer 16:10. Ak generátor dáva len 16:9 alebo 3:2, vygeneruj väčší formát a orež. Minimálne 1600 px na šírku.
- Do promptu vždy pridaj: „no text, no letters, no logos, no watermark, no grain, no noise, no texture overlay, clean smooth rendering“.

Obrázok ulož do dočasného adresára (scratchpad), nie do repozitára.

## 2. WebP obálka 1600×1000

Generátor môže uložiť JPEG s príponou `.png`. Formát ber podľa obsahu (`getimagesize`), nie podľa prípony. Stredový orez po zväčšení na 1600×1000, kvalita 82:

```php
<?php
// php -d memory_limit=512M tools-cover.php <vstup> images/articles/{slug}.webp
[$src, $dst] = [$argv[1], $argv[2]];
$info = getimagesize($src);
$img = match ($info[2]) {
    IMAGETYPE_JPEG => imagecreatefromjpeg($src),
    IMAGETYPE_PNG  => imagecreatefrompng($src),
    IMAGETYPE_WEBP => imagecreatefromwebp($src),
};
[$w, $h] = [imagesx($img), imagesy($img)];
$tw = 1600; $th = 1000;
$scale = max($tw / $w, $th / $h);
$cw = (int) round($tw / $scale); $ch = (int) round($th / $scale);
$cx = (int) (($w - $cw) / 2); $cy = (int) (($h - $ch) / 2);
$out = imagecreatetruecolor($tw, $th);
imagecopyresampled($out, $img, 0, 0, $cx, $cy, $tw, $th, $cw, $ch);
imagewebp($out, $dst, 82);
echo "$dst " . filesize($dst) . " B\n";
```

Skript drž mimo repozitára (scratchpad) alebo ho po použití zmaž. Over: `images/articles/{slug}.webp` existuje, 1600×1000, `image/webp`, bez pridaného zrna.

## 3. OG JPEG

```bash
php scripts/make_og_covers.php
```

Vznikne `images/articles/og/{slug}.jpg`. Ide do commitu spolu s WebP. Bez neho `tests/run.php` spadne a LinkedIn nezobrazí náhľad. Článok v HTML podsúva JPEG do `og:image` a `twitter:image` automaticky.

## 4. PNG na Google Disk

Účet polascin@gmail.com, priečinok `polascin.net – obálky blogu` (ID `1a_g8vTcMH3hIA2rECaV0aRVoPp3xfwFC`). Staršie ID `1MOa4l69tswsLmQB3ZmYAdoZd9gZ5aVas` je v koši, nepoužívaj ho.

Z WebP urob skutočné PNG (signatúra `89 50 4E 47`, nie premenovaný JPEG):

```php
<?php
$img = imagecreatefromwebp($argv[1]);
imagepng($img, $argv[2], 6);
```

Uloženie, jedna z ciest:

1. **Lokálny Disk pre počítače** (Windows): skopíruj do `G:\Môj disk\polascin.net – obálky blogu\{slug}.png`. Na Macu je to priečinok Google Drive v Finderi s rovnakým názvom. Over, že súbor existuje a má správnu veľkosť; klient Disku ho synchronizuje.
2. **Google Drive MCP** (ak je pripojený): vytvor súbor `{slug}.png` v priečinku s uvedeným ID, potom si metadáta prečítaj späť a over `image/png` a rozmery.

PNG necommituj. Dočasné súbory v scratchpade zmaž. Ak sa Disk nepodarí (nie je prihlásený klient ani MCP), článok nasaď bez čakania a v reporte to uveď ako otvorený bod.
