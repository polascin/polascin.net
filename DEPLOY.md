# Deploy – polascin.net

Repozitár obsahuje dva spôsoby nasadenia:

1. **GitHub Actions** – automatický deploy po pushi do `main` vetvy.
2. **Lokálny `hooks/deploy.sh`** – ručný deploy z vývojového počítača cez SSH/SFTP.

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

## GitHub Actions

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

Workflow `.github/workflows/deploy.yml` sa spustí automaticky po pushi do `main`. Ak chceš pushnúť bez deployu, použi v commit message `[skip deploy]`.

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

```bash
# Iba náhľad
hooks/deploy.sh --dry-run

# Skutočný deploy (iba súbory)
hooks/deploy.sh

# Deploy + automatické spustenie setup_db.php na serveri
hooks/deploy.sh --migrate
```

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
