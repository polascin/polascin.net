# Mercury a Claude: publikácia 2026-10-26

Článok: https://polascin.net/article.php?slug=mercury-claude-tri-ulohy-jeden-beh

Jazyky: sk, en, cs, de, fr, es, pl, hu, it, uk. Všetky záznamy boli overené v produkčnej databáze. Presné pôvodné zadania, nastavenia modelov ani úplné odpovede neboli dodané. Článok preto uvádza merania ako podklad autora a priaznivé hodnotenie kvality ako pôvodné hodnotenie. Nejde o nezávislé zopakovanie benchmarku.

Overené: súčty časov a nákladov, pomery, výsledok CKD-EPI 72,70441479277645, európska informácia o lieku Pradaxa a rozdiel CrCl oproti indexovanej eGFR. Po odpočítaní približne 0,055 USD vychádza približne 23-násobok nezaokrúhleného účtu Mercury. Počty reasoning tokenov nie sú meradlom hĺbky myslenia.

Lokálne prešlo 2 407 kontrol. GitGuardian prešiel bez nálezu tajomstiev po doplnení existujúceho ggshield do PATH. Nasadenie cez lokálne scp a SSH alias websupport. Pred nasadením záloha setup_db.php a deploy_info.php v súkromnom adresári servera. setup_db.php úspešne spustený dvakrát. Commit obsahuje [skip deploy], takže starší Actions deploy nebol použitý.

Verejne cez curl overené všetky jazykové URL: HTTP 200, zodpovedajúce titulky a obsah s cenou aj prepočtom. Overené JPEG v og:image, obrázok HTTP 200, sitemap.xml so slugom a hreflang, hlavná stránka, articles.php, contact.php, newsletter.php a login.php HTTP 200. deploy_info.php a i18n.php vracajú 403. Hlavná stránka má CSP nonce a X-Content-Type-Options. Python urllib dostal odlišnú odpoveď 466; rovnaké verejné stránky úspešne overil lokálny curl. Toto nebol prístup cez zastavené Computer Use.

Obrázok: images/articles/mercury-claude-tri-ulohy-jeden-beh.webp, 1600 × 1000. OG JPEG v images/articles/og/. PNG na Disku účtu polascin@gmail.com, účet overený konektorom. Cloudový súbor overený vyhľadávaním, MIME image/png:
https://drive.google.com/file/d/1zA-iTKr5_CNl4-eQSd_vJ_EAwnt79Hxi/view

## Sociálne siete

Uverejnené 2026-10-27 cez Chrome po schválení textu majiteľom. Pred uverejnením skontrolované profily, duplicita nebola nájdená.

- X @polascin: https://x.com/polascin/status/2114974124712059038 (účet je chránený, príspevok vidia sledovatelia)
- Facebook lubomir.polascin (verejné): https://www.facebook.com/lubomir.polascin/posts/pfbid0h7i4KnBHUZ4iApEEVVVEBENGYXUpY3VK9tX2X7b2yr3bVaTxNw2EH1FpggR1HPc1l
- LinkedIn lubomirpolascin: https://www.linkedin.com/feed/update/urn:li:share:7520742317906087936/
- Threads @lubomirpolascin: neuverejnené, Chrome nebol prihlásený. Ostáva otvorené.

Náhľad odkazu nesie og:image a anglický titulok (crawlery dostávajú `lang=en`), rovnako ako pri predchádzajúcich príspevkoch. Ponaučenie: Facebook načítava náhľad pri každom napísanom znaku adresy. Dávka požiadaviek spustila na hostingu limit 429 (197 odpovedí 429 pre facebookexternalhit) a náhľad ukázal „429 Too Many Requests“. Oprava: Sharing Debugger „Scrape Again“ po krátkej pauze a adresu do editora vložiť naraz zo schránky, nie písať po znakoch.

Pripravený text pre X a Threads:

19,7 sekundy oproti 46,9. Mercury 3 bol v troch úlohách rýchlejší a lacnejší než Claude Sonnet 5.5. Jeden beh však neurčí celkovú kvalitu. Prepočítal som náklady aj klinický príklad.
https://polascin.net/article.php?slug=mercury-claude-tri-ulohy-jeden-beh

Pripravený text pre Facebook a LinkedIn:

Na tri rovnaké zadania potreboval Mercury 3 spolu 19,7 sekundy. Claude Sonnet 5.5 potreboval 46,9. Rozdiel v zaznamenaných nákladoch bol približne 45-násobný, no časť tvoril prvý zápis do cache.

V článku rozoberám úpravu slovenčiny, klinické zdôvodnenie pri dabigatrane a kód CKD-EPI 2021. Oddeľujem čísla jedného behu od toho, čo ešte nevieme o kvalite. Počet reasoning tokenov sám neukáže, ktorý model rozmýšľal lepšie. Do ďalšieho merania patrí aj čas kontroly a opráv.

https://polascin.net/article.php?slug=mercury-claude-tri-ulohy-jeden-beh

## Ilustrácia

Vytvorená vstavaným nástrojom imagegen. Úplný prompt:

Create a high quality cinematic editorial blog cover, landscape 16:10. A serene sophisticated dark violet laboratory desk with two elegant transparent glass channels running side by side through three luminous checkpoints, one stream of teal light travels in a compact smooth arc, another violet stream takes a longer graceful route. In the foreground a small precision stopwatch and a magnifying glass resting beside two clean sheets with abstract geometric marks, no legible writing. Metaphor for comparing AI speed, cost and careful verification, no winner podium, no robots. Palette deep purple #3d1a78 and luminous teal #078d70, warm ivory highlights. Beautiful restrained lighting, polished clean surfaces, strong focal composition, inviting and thoughtful, premium editorial 3D illustration. No letters, numbers, logos, watermark, grain, noise, texture overlay, or textGrain. Keep key objects within central area to permit a 16:9 crop.
