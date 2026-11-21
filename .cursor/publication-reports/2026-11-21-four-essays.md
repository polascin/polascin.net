# Publikácia štyroch esejí, 21. novembra 2026

## Rozsah

Štyri dodané námety spracované ako samostatné eseje. Každá má verzie sk, en, cs, de, fr, es, pl, hu, it, uk podľa `appLanguages()`. Prvé tri používajú výslovne fiktívne modelové situácie. Reálne názvy firiem, súkromné kontakty, cena zariadenia, dátumy incidentov a odkazy do súkromných repozitárov nie sú zverejnené. Názov románu a verejné autorstvo sú zachované. Publikácia neuvádza predaje ani počty čitateľov.

## Články a sociálne siete

### Bunky sa v reklame prebúdzajú. Kde sú výsledky?

- [Článok](https://polascin.net/article.php?slug=slub-nie-je-vysledok)
- [X](https://x.com/polascin/status/2124266985051529330)
- [Facebook, fotografia s textom príspevku](https://www.facebook.com/photo/?fbid=10245940897636121&set=a.1137300272261)
- [LinkedIn](https://www.linkedin.com/feed/update/urn:li:activity:7530033016216313856/)
- [Threads](https://www.threads.com/@lubomirpolascin/post/DgBStGjCIv-)

### Najprv priprav náhradu. Až potom zhasni svetlo.

- [Článok](https://polascin.net/article.php?slug=najprv-priprav-potom-prepni)
- [X](https://x.com/polascin/status/2124267579820667185)
- [Facebook](https://www.facebook.com/lubomir.polascin/posts/pfbid02iYHTcrppo9MpzuLZG9wRSf4cJGQBSuCCoz628MyiEBf85DrarUE7ZPe6caPYFfiWl)
- [LinkedIn](https://www.linkedin.com/feed/update/urn:li:activity:7530033276447592448/)
- [Threads](https://www.threads.com/@lubomirpolascin/post/DgBS69ViHuh)

### Meno sme vymazali. Človek zostal viditeľný.

- [Článok](https://polascin.net/article.php?slug=meno-chyba-clovek-zostava)
- [X](https://x.com/polascin/status/2124267936521314786)
- [Facebook](https://www.facebook.com/lubomir.polascin/posts/pfbid024UbtDvrjopRK5q8SBHH6gKCVjogiNrBSzKdyeTQVUyRUhk2xBK7DxJTfyvuCMUDTl)
- [LinkedIn](https://www.linkedin.com/feed/update/urn:li:activity:7530033602470834178/)
- [Threads](https://www.threads.com/@lubomirpolascin/post/DgBTEXkiDSt)

### Minúty, ktoré v tabuľke nevidno

- [Článok](https://polascin.net/article.php?slug=minuty-ktore-v-tabulke-nevidno)
- [X](https://x.com/polascin/status/2124268319616471361)
- [Facebook](https://www.facebook.com/lubomir.polascin/posts/pfbid0bZSh2nvSmHMfCHMEH9fxi8SYcgjA8HYsNrgn7NtVRH1nMXZxd4N9B2SrVAyL5VUWl)
- [LinkedIn](https://www.linkedin.com/posts/lubomirpolascin_v-mar%C5%BEi-z-krvi-sa-kradne-po-min%C3%BAtach-z-lie%C4%8Dby-share-7530033893991915521-SMhu/)
- [Threads](https://www.threads.com/@lubomirpolascin/post/DgBTMVCiPxo)

Všetkých 16 publikácií bolo potvrdených oznámením siete a následným obsahom profilu alebo detailu. X obsahuje priložený JPEG a alternatívny text. Facebook pri prvom článku obsahuje JPEG, pri ostatných obrazový náhľad. LinkedIn obsahuje obrazové náhľady. Threads pri druhom článku obsahuje JPEG, pri ostatných obrazový náhľad. Texty príspevkov sú slovenské a obsahujú kanonické URL. Automatický titulok náhľadu môže byť anglický podľa jazykovej voľby služby.

## Obálky a Google Disk

Generované vstavaným nástrojom `image_gen`, následne skontrolované. WebP 1600 × 1000, kvalita 82; OG JPEG a karty 480/960 px vytvorené projektovým skriptom. Bez textu, log, zrna, šumu a textúrnych prekrytí. PNG nie sú v Gite.

PNG sú v [priečinku polascin.net obálky blogu](https://drive.google.com/drive/folders/1a_g8vTcMH3hIA2rECaV0aRVoPp3xfwFC), účet polascin@gmail.com. Všetky štyri súbory boli overené aj vo webovom rozhraní Disku, nielen v miestnom synchronizovanom adresári. Názvy: `2026-11-21-{slug}.png`.

Spoločné zadanie generátoru: kvalitná redakčná ilustrácia na blog, pomer 16:10, fialová #3d1a78, tyrkysová #078d70, krémové akcenty, čistá trojrozmerná kompozícia, mäkké svetlo a priestor na orez. Negatívne požiadavky: `no text, no letters, no logos, no watermark, no grain, no noise, no texture overlay, clean smooth rendering`.

Motívy:

1. Sklenený hranol, lupa a prázdny zápisník, v pozadí abstraktný neoznačený prístroj. Metafora overovania zdravotného prísľubu, nie dôkaz liečebného účinku.
2. Fungujúci osvetlený dom na pevnej plošine a pripravovaná náhrada na vedľajšej plošine, most a odpojený kábel. Metafora prípravy pred prepnutím.
3. Dve priesvitné dosky s oddelenými geometrickými fragmentmi, ktoré v prekrytí vytvárajú ľudskú siluetu. Metafora nepriameho odhalenia identity.
4. Otvorená kniha prechádzajúca do presýpacích hodín s tyrkysovými sklenenými guľôčkami, v pozadí prázdne liečebné kreslo. Metafora strácajúceho sa času v románe.

## Overenie

- `php -l` nad zmenenými PHP súbormi bez chyby.
- Celá sada `php tests/run.php`: 4 301 kontrol, úspech aj po záverečnej úprave.
- Kontrola diffu, tajomstiev a pre-commit hook prešli.
- Lokálne nasadenie cez SSH alias `websupport`, režim `archive`; GitHub Actions neboli spustené ani zmenené.
- Produkčné SK, EN a DE verzie všetkých článkov: 200, očakávané titulky a CSP s nonce.
- Štyri OG obrázky: 200 a `image/jpeg`.
- Kľúčové stránky: 200; `/deploy_info.php` a `/i18n.php`: 403. Bezpečnostné hlavičky overil deploy smoke check.
- Mapa webu obsahuje všetky štyri slugy a jazykové alternatívy.
- Prehliadač pri 375 px: všetky štyri titulky správne, žiadne vodorovné pretekanie. Nie je to test na fyzickom telefóne.
- Google Disk: štyri PNG viditeľné na správnom účte.
- Druhý beh pôvodných migrácií prešiel bez chyby.
- Záverečné čítanie SK a EN v produkcii; pri románe odstránená nadbytočná veta o administratíve vo všetkých desiatich jazykoch, migrácia `2026112105_minutes_novel_polish`.

## Overené verejné podklady

- NCCIH: [Be an Informed Consumer](https://www.nccih.nih.gov/health/be-an-informed-consumer), všeobecný rámec hodnotenia zdravotných tvrdení. Modelový prístroj nie je hodnotením konkrétneho výrobku.
- Information Commissioner's Office: [How do we ensure anonymisation is effective?](https://ico.org.uk/for-organisations/uk-gdpr-guidance-and-resources/data-sharing/anonymisation/how-do-we-ensure-anonymisation-is-effective/), princíp posudzovania identifikovateľnosti v kontexte. Text ho nepoužíva ako výklad slovenského práva.
- Ľubomír Polaščín: [Marža z krvi, verejný katalóg Digiport](https://www.digiport.cz/detail/bupebooks-1112189-marza-z-krvi/), dostupnosť a námet. Žiadne súkromné správy či obchodné kontakty nie sú citované.

## Opätovná kontrola sociálnych príspevkov po jazykovej revízii

21. novembra 2026 boli v prihlásenej relácii Chrome otvorené všetky existujúce odkazy uvedené vyššie. Kontrola sa týkala textu, anonymizácie, súladu s článkami po migráciách `2026112106_four_essays_language_privacy_refresh` a `2026112107_deployment_essay_alt_refresh`, správneho motívu ilustrácie a čitateľnosti obrazového náhľadu.

| Článok | X | Facebook | LinkedIn | Threads |
| --- | --- | --- | --- | --- |
| Bunky sa v reklame prebúdzajú | V poriadku | Doplnený alternatívny popis fotografie | V poriadku | V poriadku |
| Najprv priprav náhradu | V poriadku | V poriadku | V poriadku | V poriadku |
| Meno sme vymazali | V poriadku | V poriadku | V poriadku | V poriadku |
| Minúty, ktoré v tabuľke nevidno | V poriadku | V poriadku | V poriadku | V poriadku |

Prvé tri sociálne texty už označovali situácie ako modelové a neobsahovali názov výrobku, firmy, pracoviska, presnú cenu ani súkromný odkaz. Literárne príspevky jednoznačne odkazovali na román. Ich význam sa opravou článkov nezmenil, preto nebolo potrebné prepisovať ich text. Obálky boli vizuálne skontrolované pri každej zo šestnástich publikácií a zodpovedajú príslušnému článku. Automatické anglické titulky odkazových kariet sú v súlade s anglickými verziami článkov; vlastné texty príspevkov sú slovenské.

Pri facebookovej fotografii `10245940897636121` pôvodne chýbal alternatívny popis. Priamo v existujúcej fotografii bol uložený tento text: „Ilustrácia vo fialových a tyrkysových farbách: sklenený hranol, lupa nad otvoreným prázdnym zápisníkom a neoznačený prístroj v pozadí.“ Uloženie bolo overené po obnovení stránky aj opätovným otvorením editora alternatívneho textu.

Nevznikol nový príspevok, komentár ani opakované zdieľanie. Identifikátory a odkazy všetkých šestnástich publikácií zostali zachované. Kontrola sa nevzťahuje na iné, staršie príspevky na týchto profiloch.
