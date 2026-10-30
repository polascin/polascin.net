# Deploy – polascin.net

Vývoj, nasadenie aj nočné úlohy nezávisia od GitHubu (od Behu #49):

1. **Lokálny `hooks/deploy.sh`** – jediná bežná cesta nasadenia, z vývojového
   počítača cez SSH alias `websupport`. Push do žiadneho remotu nič nenasadzuje.
2. **Crontab na serveri** – retenčné čistenie a nočná kontrola DB
   (sekcia „Nočné úlohy na serveri“).
3. **Git remote `websupport`** – repozitár na hostingu mimo web rootu. GitHub
   (`origin`) je iba zrkadlo a jeho výpadok vývoj nezastaví.
4. **GitHub Actions** – workflowy zostali iba ako ručná záloha
   (`workflow_dispatch`), bez spúšťania pushom alebo plánom.

Oba spôsoby odmietnu prázdnu, relatívnu alebo koreňovú (`/`) cieľovú cestu. Pred
synchronizáciou tiež overia, že vzdialený adresár už existuje. Je to bezpečnostná
poistka pre `rsync --delete-delay`; cieľ preto vytvor manuálne ešte pred prvým
deployom.

## Čo sa nasadzuje

Rsync synchronizuje celý repozitár do vzdialeného web rootu, pričom vynecháva
súbory uvedené v `.deployignore` (git metadáta, IDE konfigurácie, hooky, testy,
auditné MD, README, ukážkový aj lokálny env súbor, `private/` a pod.). Po
synchronizácii odstráni presne pomenované staré repozitárové súbory, ktoré mohli
ostať z dávnejšieho manuálneho deployu; obsah `private/` sa nemaže.

## Git remote na serveri

Repozitár `~/git/polascin.net.git` na hostingu je holý, mimo web rootu, so
zakázaným force-pushom (`receive.denyNonFastForwards`) a mazaním vetiev
(`receive.denyDeletes`). Na vývojovom stroji:

```bash
git remote add websupport websupport:git/polascin.net.git
git pull websupport main
git push websupport main
git push origin main   # zrkadlo na GitHub, keď je dostupný
```

Nočná kontrola DB commituje report do `websupport` `main`, preto pred prácou
vždy `git pull websupport main`.

## Nočné úlohy na serveri

[`hooks/ops/crontab.txt`](hooks/ops/crontab.txt) spúšťa
[`hooks/ops/nightly.sh`](hooks/ops/nightly.sh) priamo z vetvy `main`
v repozitári na serveri: o 21:17 retenciu, o 21:37 read-only kontrolu DB
(Europe/Bratislava). Kontrola zapíše `audit-reports/db-latest.md` a commitne
ho do `main` na serveri. Úlohy aj nasadenie zdieľajú zámok `private/ops.lock`.
Logy sú v `private/ops-retention.log` a `private/ops-verify-db.log`.

Inštalácia (crontab na serveri obsahuje aj úlohy iných projektov, preto iba
pridať blok medzi značkami `BEGIN/END polascin.net ops`, po zálohe):

```bash
ssh websupport 'crontab -l > ~/crontab.bak-$(date +%Y%m%d-%H%M%S)'
```

Ručné spustenie a náhľad retencie bez mazania:

```bash
ssh websupport 'bash -s verify-db' < hooks/ops/nightly.sh
ssh websupport 'RETENTION_DRY_RUN=true bash -s retention' < hooks/ops/nightly.sh
```

## GitHub Actions (iba ručná záloha)

### Nastavenie secrets

V repozitári na GitHub choď do **Settings → Secrets and variables → Actions** a pridaj:

| Secret                    | Popis                                                       |
| ------------------------- | ----------------------------------------------------------- |
| `DEPLOY_HOST`             | Hostname servera (napr. `shell.r1.websupport.sk`)           |
| `DEPLOY_USER`             | SSH používateľ (napr. `uid12345`)                           |
| `DEPLOY_SSH_KEY`          | Celý obsah SSH privátneho kľúča pre deploy                  |
| `DEPLOY_KNOWN_HOSTS`      | Overený host key servera pre `known_hosts` (**povinné**)    |
| `DEPLOY_PORT`             | SSH port (predvolené `22`)                                  |
| `DEPLOY_REMOTE_PATH`      | Bezpečná absolútna cesta k existujúcemu web rootu           |
| `POLASCIN_ADMIN_PASSWORD` | Heslo pre prvého admina pri vytvorení databázy (odporúčané) |
| `POLASCIN_ENV_INI`        | Celý obsah súboru `env.ini` na server (odporúčané)          |
| `POLASCIN_ENV_PATH`       | Absolútna cesta k env.ini **mimo** web rootu                |

`DEPLOY_KNOWN_HOSTS` získaj napríklad cez `ssh-keyscan -p <port> <host>`, ale
fingerprint kľúča vždy over aj nezávislým kanálom u poskytovateľa hostingu. Pri
neštandardnom porte musí záznam obsahovať tvar `[host]:port`. Ak secret nie je
nastavený, workflow zlyhá — na efemérnom GitHub runneri neexistuje dôveryhodný
`known_hosts`, ktorý by sa dal použiť. Hodnota `accept-new` je dostupná iba pre
lokálny skript `hooks/deploy.sh`.

`POLASCIN_ENV_PATH` musí byť absolútna cesta mimo `DEPLOY_REMOTE_PATH` (obidva
deploy skripty relatívnu cestu aj cestu vo web roote odmietnu). Ak secret
nenastavíš, použije sa `<rodič-web-rootu>/private/polascin.env.ini`, napríklad
pre web root `/data/uid12345/www` je to `/data/uid12345/private/polascin.env.ini`.

### Aktivácia

Workflow `.github/workflows/deploy.yml` sa pushom nespúšťa, iba ručne cez
`workflow_dispatch`. Značka `[skip deploy]` v commitoch zostáva ako popis
pre čitateľa histórie.

Pred nasadením sa vždy skontroluje syntax deploy skriptu, všetkých sledovaných
PHP súborov a vlastných JavaScript súborov a spustí sa `php tests/run.php`.
Produkčné deployee cez GitHub Actions sú serializované, takže dve rýchle zmeny
nemôžu súčasne spustiť `rsync` a migrácie. Manuálny `hooks/deploy.sh` do tejto
serializácie nespadá — nespúšťaj ho, kým beží deploy v Actions.

Po úspešnom súborovom deployu workflow automaticky spustí `setup_db.php` na
serveri. Skript vytvorí chýbajúce tabuľky a aplikuje iba doteraz nevykonané
verzované migrácie; existujúci redakčný obsah neprepisuje.

### Manuálny spustenie

Workflow podporuje aj `workflow_dispatch`, takže ho môžeš spustiť ručne z GitHub UI.

### Automatické retenčné mazanie

Denné mazanie spúšťa crontab na serveri (`nightly.sh retention`), workflow
`.github/workflows/retention-cleanup.yml` je iba ručná záloha. Oba vykonajú
`scripts/retention_cleanup.php` priamo nad produkčnou databázou. Skript
maže iba záznamy staršie než nakonfigurovaná lehota a vypisuje len počty, nie
obsah osobných údajov. Ručné spustenie podporuje voľbu `dry_run`, ktorá celú
transakciu vráti späť.

Predvolené lehoty sa dajú zmeniť v produkčnom `env.ini`:

| Premenná                             | Predvolená hodnota | Účel                                |
| ------------------------------------ | -----------------: | ----------------------------------- |
| `CONTACT_MESSAGE_RETENTION_DAYS`     |                180 | kontaktné správy                    |
| `NEWSLETTER_PENDING_RETENTION_HOURS` |                 72 | nepotvrdené registrácie newslettera |
| `ACCESS_LOG_RETENTION_DAYS`          |                 90 | technické prístupové záznamy        |
| `FORM_RATE_LIMIT_RETENTION_HOURS`    |                 48 | záznamy ochrany formulárov          |
| `ADMIN_AUDIT_LOG_RETENTION_DAYS`     |                365 | administrátorský audit              |

Potvrdené adresy newslettera sa automaticky nemažú; uchovávajú sa do
odhlásenia. Lehotu nepotvrdenej registrácie nemožno nastaviť pod 48 hodín,
pretože tak dlho platí potvrdzovací odkaz.

## Lokálny deploy

### 1. Príprava SSH kľúča a configu

Vytvor SSH kľúč pre deploy:

```powershell
ssh-keygen -t ed25519 -f "$HOME\.ssh\polascin_deploy" -C "polascin-deploy"
```

Pridaj verejnú časť na server do `~/.ssh/authorized_keys`.

Vytvor/uprav `~/.ssh/config`:

```ssh
Host polascin
    HostName shell.r1.websupport.sk
    User uid12345
    Port 22
    IdentityFile ~/.ssh/polascin_deploy
    IdentitiesOnly yes
```

### 2. Konfigurácia deploy.env

Skopíruj príklad:

```powershell
New-Item -ItemType Directory -Force -Path "$HOME\.config\polascin"
copy "hooks\deploy.env.example" "$HOME\.config\polascin\deploy.env"
```

Uprav `$HOME\.config\polascin\deploy.env`:

```bash
POLASCIN_DEPLOY_TARGET=polascin
POLASCIN_REMOTE_PATH=/data/.../polascin.net
POLASCIN_DEPLOY_KNOWN_HOSTS_FILE=$HOME/.ssh/known_hosts
```

Ak nepoužiješ explicitný `known_hosts` súbor, lokálny skript predvolene používa
`StrictHostKeyChecking=accept-new`. Prísne overovanie môžeš vynútiť aj cez
`POLASCIN_SSH_HOST_KEY_CHECK=yes`.

### 3. Spustenie deployu

Z rootu repozitára:

Ak na stroji chýba `rsync` (Git Bash na Windows), skript prenesie
`git archive HEAD` cez SSH do dočasného adresára v `private/` a `rsync`
spustí na serveri s porovnaním obsahu (`-c`). Nasadzuje sa iba commitnutý
stav; necommitnuté zmeny skript odmietne. V tomto režime `--dry-run` naozaj
porovná server s HEAD a vypíše, čo by sa zmenilo, bez zásahu do web rootu.

```bash
# Náhľad zmien (v režime archive porovnanie so serverom)
hooks/deploy.sh --dry-run

# Skutočný deploy (iba súbory)
hooks/deploy.sh

# Deploy + automatické spustenie setup_db.php na serveri
hooks/deploy.sh --migrate
```

Po nasadení skript overí produkciu: kľúčové stránky musia vrátiť 200, interné
súbory 403 alebo 404, detail prvého článku zo sitemapy 200, domovská stránka
musí niesť bezpečnostné hlavičky a CSP s nonce bez `'unsafe-inline'`. Pri
odpovedi 429 (limit hostingu na IP) curl požiadavku zopakuje po 10 s. Pri chybe
skončí nenulovým kódom. Samotné overenie bez nasadenia: `hooks/deploy.sh --smoke-only`.

Pred prenosom skript overí syntax vygenerovaného `deploy_info.php` cez `php -l`;
pätička ho načítava na každej stránke, preto sa chybný súbor nenasadí.
Overenie cieľa, rsync na serveri a čistenie súborov určených iba pre repozitár
sa pri zlyhaní SSH (hosting občas zruší spojenie pri výmene kľúčov) opakujú až
trikrát po 15 s. Kroky so vstupom zo stdin sa neopakujú.

## Databázová schéma a env.ini

GitHub Actions aj `hooks/deploy.sh --migrate` automaticky spustia `setup_db.php` na serveri po súborovom deploye.

Pri prvej inštalácii treba mať na serveri aj `env.ini` s DB credentials. Ak do GitHub secretu `POLASCIN_ENV_INI` vložíš celý obsah `env.ini`, workflow ho automaticky nahraje pred spustením migrácií na cestu `POLASCIN_ENV_PATH`, predvolene `<rodič-web-rootu>/private/polascin.env.ini`.

Lokálne môžeš použiť súbor (cesta musí byť absolútna a mimo web rootu):

```bash
# ~/.config/polascin/deploy.env
POLASCIN_ENV_INI_FILE=$HOME/.config/polascin/env.ini
POLASCIN_ENV_PATH=/data/uid12345/private/polascin.env.ini
```

Pri prvej inštalácii nastav aj `POLASCIN_ADMIN_PASSWORD` v `~/.config/polascin/deploy.env` (alebo ako GitHub secret), aby sa vytvoril admin účet so známym heslom.

```bash
# Príklad lokálneho spustenia migrácií (po bežnom deploye)
ssh polascin "php ${POLASCIN_REMOTE_PATH}/setup_db.php"
```

## Bezpečnosť

- SSH privátny kľúč a deploy konfigurácia nikdy nepatria do repozitára.
- `.deployignore` zabraňuje nasadeniu `private/`, environment súborov, privátnych
  kľúčov, lokálnych pomocných súborov, hookov, testov a auditných súborov.
- Admin heslo sa do vzdialeného shell príkazu nevkladá priamo; prenáša sa cez
  štandardný vstup v Base64 obálke.
- Vzdialená cesta môže obsahovať iba bezpečné znaky a nesmie obsahovať komponenty
  `.` ani `..`; koreň servera `/` je vždy odmietnutý.
- Na Apache over, že je povolené spracovanie `.htaccess`. OpenResty/Nginx tento
  súbor ignoruje, preto treba rovnaké zákazy pre `private/`, dot-súbory,
  repozitárovú dokumentáciu a interné skripty nastaviť priamo v konfigurácii
  virtuálneho hosta. Interné PHP súbory majú aj aplikačnú ochranu, tá však
  nenahrádza pravidlá web servera pre statické súbory.
