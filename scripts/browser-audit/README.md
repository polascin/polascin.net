# Kontroly polascin.net v skutočnom prehliadači

Sada skriptov, ktorá otvorí skutočný Chrome (puppeteer-core) a zmeria to, čo
statické testy v `tests/run.php` nevidia: rozloženie pri reálnych šírkach okna,
kontrast z pixelov, prístupnosť cez axe-core, ovládanie klávesnicou, tlač do
PDF, tok súhlasu so súkromím a správanie pri nastaveniach prístupnosti. Skripty sa nenasadzujú na server
(`.deployignore` vylučuje priečinok `scripts`).

## Inštalácia

```
cd scripts/browser-audit
npm install
```

Treba Node.js a nainštalovaný Chrome alebo Chromium. Cestu k prehliadaču skript
hľadá v obvyklých umiestneniach Windows, macOS a Linuxu, inú cestu nastav cez
`CHROME_PATH`. Verzie balíkov sú pripnuté (`puppeteer-core` 25.16.0, `axe-core`
4.14.0). Overené s Node.js 26.13 a Chrome 156. Priečinok `node_modules/` je v
`.gitignore`, `package-lock.json` sa komituje.

## Spustenie

```
npm run layout     # rozloženie, banner, h1, id, obrázky, konzola, CSP, CLS, LCP
npm run nav        # hlavná navigácia: jeden riadok, hranica kompaktného režimu
npm run worstcase  # kontrast textu v sklenenej navigácii pod ťažkými podkladmi
npm run axe        # axe-core (WCAG 2.0, 2.1, 2.2 A a AA a best practice)
npm run pixels     # kontrast z pixelov tam, kde axe nevie rozhodnúť
npm run consent    # tok súhlasu so súkromím (Clarity, Google Analytics)
npm run keyboard   # ovládanie klávesnicou (prechod Tabom a správanie prvkov)
npm run print      # tlač do PDF (A4): čitateľnosť, opakované prvky, počet strán
npm run modes      # vynútené farby, znížený pohyb, rozostupy, 200 % text, bez JS
npm run cls        # pôvod posunov rozloženia (CLS) pri studenom načítaní
npm run banner     # koľko okna zakrýva cookie banner (limit LIMIT=50 %)
```

Každý skript vypíše súhrn po slovensky a skončí kódom 0 (bez nálezov) alebo 1
(nálezy). Podrobné výstupy (JSON, pri pixelových meraniach aj snímky) idú do
priečinka `AUDIT_OUT`, predvolene `polascin-browser-audit` v dočasnom priečinku
systému.

## Nastavenie cez premenné prostredia

Spoločné: `BASE_URL` (predvolene `https://polascin.net`), `CHROME_PATH`,
`AUDIT_OUT`, `LANGS` (napr. `sk,uk`), `THEMES` (`light,dark`), `STATES`
(`banner` je prvá návšteva bez uloženého súhlasu, `clean` je uložené
odmietnutie), `PAGES`, `SCROLLBARS=1` (klasický posuvník namiesto skrytého),
`LOCAL_ROOT` (pozri nižšie).

Ďalšie podľa skriptu: `VIEWPORT` (`desktop` alebo `mobile`) pri `axe`, `pixels` a
`worstcase`, `BREAKPOINT`, `WIDTHS` a `ADMIN=1` (doplní do navigácie položky
prihláseného správcu) pri `nav`, `BACKDROPS` a `OPACITIES` pri `worstcase`,
`ONLY`, `DIAG` a `DUMP` pri `pixels`.

Pre `modes`: `MODES` (`forced`, `motion`, `spacing`, `bigtext`, `nojs`),
`VIEWPORTS` (`wide` 1440x900, `desktop` 1280x800, `mobile` 390x844, `narrow`
320x640), `MAX_STOPS` (počet zastavení Tabu pri kontrole obrysu v režime
`forced`) a `SHOTS=1` (uloží snímky do `AUDIT_OUT`).

Pre `keyboard`: `VIEWPORTS` (`desktop` 1280x800, `compact` 1100x800, `mobile`
390x844, `narrow` 320x640, `tiny` 320x568, `landscape` 667x375), `MAX_STOPS`,
`TRAVERSAL=0` (preskočí prechod Tabom), `BEHAVIOUR=0` (preskočí kontroly
prvkov), `PIXELS=0` (preskočí kontrolu ukazovateľa fokusu zo snímok),
`AXE_OPEN=0` (preskočí axe pri otvorenej ponuke jazykov), `DUMP=1` (vypíše každý
stop klávesnice s polohou a prekrytím).

Pre `print`: `STATES` (`clean` alebo `banner`), `PAGES` (predvolene `home`,
`articles`, `article`, `library`, `privacy`, `terms`, `contact`, `newsletter`,
na požiadanie aj `login`), `SCROLL=1` (stránku pred tlačou prejde, aby sa
odkryli prvky `.reveal`; bez toho sa meria najhorší prípad, tlač bez posunu),
`PDF=1` (uloží `tlac-<jazyk>-<téma>-<stav>-<stránka>.pdf` a `print-audit.json` do
`AUDIT_OUT` na ručnú kontrolu).

Príklad (PowerShell):

```
$env:LANGS = 'sk,uk'; $env:STATES = 'banner'; $env:VIEWPORTS = 'mobile,tiny'
npm run keyboard
```

## Overenie zmeny pred nasadením (`LOCAL_ROOT`)

Ak `LOCAL_ROOT` ukazuje na koreň repozitára, skript odpovie na požiadavky
`/css/styles.css` a `/js/main.js` lokálnymi súbormi a zvyšok stránky príde z
produkcie. Zmenu v CSS alebo JavaScripte tak možno overiť v skutočnom
prehliadači ešte pred nasadením. PHP šablóny sa takto neskúšajú, tie ostávajú
produkčné. Po nasadení spusti ten istý beh bez `LOCAL_ROOT`.

## Bezpečnosť

- Iba požiadavky GET. Formuláre sa neodosielajú, stláča sa len Tab, Enter,
  medzerník a Escape na vlastných ovládacích prvkoch webu.
- Tretie strany (Clarity, Google Analytics, Tag Manager, DoubleClick) sa
  nahradia prázdnou odpoveďou. Merania sa nepoškodia a nič sa tam neodošle.
- WebSupport pri dávke požiadaviek vracia 429, najmä tesne po nasadení.
  Skripty medzi načítaniami čakajú 2 až 3 s a pri 429 alebo 503 počkajú 45 s a
  zopakujú pokus. Dva behy proti produkcii nikdy nespúšťaj naraz.

## Čo skripty nepokrývajú

- Iba Chrome. Firefox a Safari sa nemerajú, oprava overená tu nie je overená
  tam. Tlač sa meria ako PDF z Chrome (emulované médium `print`, A4, okraje
  10 mm), nie cez tlačiareň ani cez dialóg iných prehliadačov.
- Čítačky obrazovky. Axe posúdi len pravidlá, ktoré sa dajú vyhodnotiť strojovo.
- Prihlásená administrácia. `ADMIN=1` len simuluje položky v navigácii.
- Ukážkové slugy článkov v `PAGES` môžu časom zastarať, vtedy ich v zozname
  stránok na začiatku skriptu vymeň.
- Pri nízkych oknách zaberie cookie banner viac než polovicu okna (najdlhší
  text, ukrajinčina: 81 % pri 320x568, 68 % pri 667x375, 61 % pri 360x640). Vtedy
  sa zaostrený prvok nedá udržať celý nad bannerom a pod navigáciou, skript to
  hlási len ako upozornenie (čiastočné prekrytie), nie ako chybu.

## Pasce pri meraní

1. Odkazy majú `transition: color 0.3s` a skip link `transform 0.2s`. Po
   zaostrení alebo prepnutí počkaj 450 až 700 ms, až potom meraj farbu alebo
   polohu.
2. Pri priehľadnej výplni sú okrajové pixely vyhladené a kontrast vychádza
   nižší, než v skutočnosti je. Porovnávaj s vypočítanou farbou textu.
3. Pri meraní z pixelov vypni plynulé posúvanie a prechody.
4. Obsah zatvoreného `<details>` má rozmery, no nevykresľuje sa.
5. Prvky s `position: fixed` nerozširujú `scrollWidth` a šírka v media query
   zahŕňa posuvník.
6. Headless puppeteer pridáva `--hide-scrollbars`, bez `SCROLLBARS=1` teda
   posuvník nie je vidieť.
7. `page.addStyleTag` blokuje CSP, ak pred navigáciou nezavoláš
   `page.setBypassCSP(true)`. Pred meraním počkaj na `document.fonts.ready`.
8. Po Tabe sa stránka posúva plynule. Meraj až vtedy, keď je stabilná poloha
   posunu aj zaostreného prvku.
9. Zalomený odkaz má viac riadkových boxov. Vzorkuj `getClientRects()`, nie
   spoločný obdĺžnik, ktorý zasiahne susedné odkazy.
10. Stav `banner` musí pri každom novom dokumente zmazať uložený súhlas. Inak ho
    predchádzajúci test, ktorý kliol na „Odmietnuť“, ponechá a ďalšie stránky
    banner nemajú.
11. Zmena výplne, zdvih (`translateY`) a tieň zaostreného prvku zmenia veľa
    pixelov, takže neviditeľný obrys prejde metrikou „zmenené pixely“. Pri
    prvku s obrysom meraj pás mimo prvku, kde obrys naozaj leží, a farbu obrysu
    porovnávaj s podkladom za prvkom, nie s výplňou tlačidla.
12. Obrys presahuje ohraničenie prvku (tu o 5 px), no `scroll-padding` počíta
    len s ohraničením. Prvok zarovnaný presne nad pevný prekryv (banner) alebo
    na okraj okna má celý viditeľný obsah, a predsa mu chýba spodná strana
    obrysu. Pri skúmaní takého nálezu drž tempo Tabu ako skript (po každom Tabe
    počkaj, kým sa dokončí posun): pri rýchlych Taboch je prvok celý mimo okna,
    Chrome ho vycentruje a nález sa nezopakuje.
13. Pri emulácii `forced-colors: active` v Chrome môže `getComputedStyle()`
    vrátiť pôvodnú hodnotu `-webkit-text-fill-color`, hoci sa text vykresľuje
    systémovou farbou. Kontrast preto počítaj z vlastnosti `color`; priehľadnú
    výplň sleduj osobitne.
14. Studené načítanie bez cache stiahne asi 25 súborov naraz, čo je limit
    WebSupport na IP. Keď hosting vráti 429 na `css/styles.css`, Chrome
    vykreslí stránku bez štýlu a potom so štýlom, a vznikne „posun“ okolo
    0,22 (navigácia 298 px namiesto 77 px). Tak vznikol aj nález 0,153 až 0,26
    pre uk a 0,22 pre hu a de (Beh #69). `cls-audit.mjs` takýto beh označí ako
    `NEPLATNÉ` a nezapočíta ho; po sérii neplatných behov počkaj aspoň
    15 minút. Behy bez posunu (merané ešte pred kontrolou 429, takže štýly sa
    zjavne načítali): uk desktop 0,0228 a dvakrát 0,0000, uk mobil dvakrát
    0,0000, sk desktop dvakrát 0,0000; neskôr hu 0,0052, de a pl 0,0186.
15. Hlášky konzoly `status of 429` alebo `503` a odpovede 429/503 nie sú chyby
    stránky. `summarizeLog()` v `lib.mjs` ich vynecháva z `consoleIssues`
    a počíta v `rateLimited`; `keyboard-audit.mjs` z nich robí upozornenie
    „limit hostingu“, nie chybu (Beh #72).

## Ukazovateľ fokusu (`keyboard`)

Pri každom stope skript zaostrí prvok Tabom a porovná snímku so zaostreným a s
rozostreným prvkom. Ak má prvok nakreslený obrys, meria sa pás medzi
`outline-offset` a `outline-offset + outline-width` mimo ohraničenia prvku, po
každej strane zvlášť (hore, vpravo, dolu, vľavo), v strede strany (pri zalomenom
odkaze len prvý a posledný riadkový box). Strana platí, ak aspoň polovica
pixelov v páse má voči rozostrenej snímke kontrast 3:1 (WCAG 2.2, SC 1.4.11).
Nálezy:

- `bez ukazovateľa fokusu` (chyba): zaostrenie nezmenilo ani jeden pixel.
- `neviditeľný obrys fokusu` (chyba): obrys je nakreslený, no na žiadnej strane
  nemá dostatočný kontrast.
- `orezaný obrys fokusu` (upozornenie): kontrast chýba len na niektorých
  stranách, typicky pretože obrys zakrýva pevný prvok (banner), odreže ho okraj
  okna alebo rodič s `overflow`.
- `slabý ukazovateľ fokusu` (upozornenie): prvok nemá obrys a zmena je menšia
  než jeho obvod.

Meranie sa kľúčuje témou a oknom, oblasťou (`nav`, `footer`, `banner`) alebo
stránkou a podpisom prvku. Obsah stránky sa teda meria raz, v prvom stave z
`STATES`, preto nechaj `banner` prvý: je to najhorší prípad.

## Čo zachytila klávesnica

1. Pevný cookie banner zakrýval väčšinu zaostrených prvkov pod hrdinským
   blokom (domovská stránka, banner: pri 390x844 bolo 44 zo 74 zastavení Tabu
   úplne pod bannerom a ďalších 6 čiastočne, pri 320x568 66 zo 74; WCAG 2.2,
   SC 2.4.11 Focus Not Obscured). Oprava je v `css/styles.css` (`scroll-padding-bottom` a
   spodné odsadenie pätičky z premennej `--cookie-banner-height`) a v
   `js/main.js` (meranie výšky banneru). Strážia ju testy v `tests/run.php`.
2. Tlačidlá `.btn-primary` a `.btn-cookie-accept` mali pri `:hover` a
   `:focus-visible` obrys prefarbený na farbu výplne (`--focus-on-primary`).
   Obrys ale leží mimo tlačidla, na pozadí stránky: biely na bielom vo svetlej
   téme a tmavomodrý na tmavom v tmavej téme (kontrast 1:1 až 1,26:1), čiže
   neviditeľný. Axe to nezachytí a staršia metrika (zmena pixelov v celom
   prvku) tiež nie, lebo zmena výplne a zdvih tlačidla zmenia veľa pixelov. Oprava
   je odstránenie prefarbenia, obrys určuje len spoločné pravidlo s
   `--focus-color`; strážia ju testy v `tests/run.php`.
3. Obrys fokusu presahuje prvok o 5 px, ale `scroll-padding-bottom` rátal len s
   jeho ohraničením. Posledné tlačidlo stránky (`Späť na články`,
   `Prihlásiť na odber`) sa po Tabe zarovnalo presne nad banner a spodná strana
   obrysu zostala pod ním (bez banneru by ju odrezal okraj okna). Oprava: k
   `scroll-padding-bottom` pribudla rezerva `--spacing-sm`, rovnaká ako hore.
   Overené v oboch témach na desktope aj mobile. Menšiu rezervu
   `--spacing-xs` som zmeral a neosvedčila sa: pri 390x844 nechá textové pole
   kontaktu čiastočne pod bannerom (Chrome ho už nevycentruje) a vo štyroch
   meraných oknách (390x844, 320x568, 320x640, 667x375) zníži počet čiastočných
   prekrytí len zo 43 na 41. Bez rezervy ich je 25, no spodná strana obrysu
   zostane pod bannerom.

## Tlač (`print`)

Skript emuluje médium `print`, vytlačí stránku do PDF s predvolenými
nastaveniami prehliadača (bez tlače pozadí) a zmeria každý text, ktorý sa na
papieri vykreslí. Okno má 718 x 1123 px, čo zodpovedá A4 s okrajmi 10 mm pri 96
dpi. Nálezy:

- pevný alebo lepkavý prvok (navigácia, cookie lišta), ktorý by sa opakoval na
  každej strane,
- text s priehľadnou výplňou (`-webkit-text-fill-color: transparent`) alebo s
  nulovou priehľadnosťou, takže sa na papieri nevytlačí,
- kontrast farby textu voči bielemu papieru (4,5:1, pri veľkom písme 3:1),
  pozadie prvku sa nepočíta, lebo sa netlačí,
- vodorovné pretečenie rozloženia, chyby stránky a porušenia CSP pri tlači,
- počet strán A4 sa len vypíše (z PDF), hranicu nemá.

Pasce pri meraní tlače:

1. `vh` sa v tlači rovná výške strany. Sekcia s `min-height: 80vh` zaberie celú
   stranu, preto je tlačová verzia bez vynulovania týchto výšok plná takmer
   prázdnych strán.
2. Hodnoty nastavené JavaScriptom inline (`--navbar-height`,
   `--cookie-banner-height`) prebije v tlačovom bloku len `!important`.
3. Prvky `.reveal` odkrýva JavaScript až pri posune. Bez `SCROLL=1` sa meria
   najhorší prípad (tlač bez posunu stránky), so `SCROLL=1` bežný prípad.
4. Počet strán sa číta z PDF a vizuálnu kontrolu nenahradí. Na ručné
   preskúmanie spusti beh s `PDF=1` a PDF si prezri.
5. Meranie s `LOCAL_ROOT` podsunie len lokálny CSS a JavaScript, HTML ostáva
   produkčné, takže tlač nových PHP šablón sa takto neskúša.

## Čo zachytala tlač

Beh proti produkcii (Chrome 156) pred opravou, 216 nálezov v oboch témach:

1. Tmavá téma tlačila svetlý text na biely papier s kontrastom 1,13:1 až 2,36:1,
   pretože pozadie sa netlačí a farba textu ostala z obrazovky.
2. Pätička vo svetlej téme tlačila biely text na nevytlačenej fialovej (1:1).
3. Pevná navigácia sa opakovala na každej strane a prekrývala obsah.
4. Nadpis hrdinského bloku s gradientovou výplňou a tlačidlá s farbou
   `--on-primary` sa nevytlačili vôbec.
5. Prvky `.reveal` mali `opacity: 0` do posunu stránky, takže obsah pod prvým
   výrezom na papieri chýbal.
6. Výšky odvodené z `vh` zaberali celé strany. Domovská stránka mala 12 strán
   A4, článok 3, knižnica 6 a kontakt 2.

Oprava je všeobecný blok `@media print` na konci `css/styles.css` (svetlá
schéma, čierny text bez pozadia, viditeľné `.reveal`, skryté ovládacie a pevné
prvky, nulové `min-height`, kompaktné karty bez ilustrácií, adresa za externými
odkazmi). Po oprave má domovská stránka 8 strán A4, zoznam článkov 5, knižnica
4, článok 2 a kontakt 1, bez nálezov v oboch témach a v jazykoch sk a hu.
Strážia ju testy v `tests/run.php`.

## Poučenia (RSI)

- Kontrola, ktorá zapisuje súčasný stav ako požiadavku, musí niesť dôvod.
  `keyboard-audit.mjs` vyžadoval banner „až za pätou“, hoci to bol opísaný
  nedostatok, nie zámer; pri zámernej zmene poradia (Beh #74) kontrolu
  prepíš spolu s kódom.
- Neplatnosť behu pri 429 posudzuj podľa toho, čo meranie ovplyvní: CLS
  znehodnotí 429 na štýl aj obrázok, rozmer banneru iba 429 na stránku,
  štýly, skripty a písma (`banner-audit.mjs`).
