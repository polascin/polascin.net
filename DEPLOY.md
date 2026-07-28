# Deploy – polascin.net

Repozitár obsahuje dva spôsoby nasadenia:

1. **GitHub Actions** – automatický deploy po pushi do `main` vetvy.
2. **Lokálny `hooks/deploy.sh`** – ručný deploy z vývojového počítača cez SSH/SFTP.

## Čo sa nasadzuje

Rsync synchronizuje celý repozitár do vzdialeného web rootu, pričom vynecháva súbory uvedené v `.deployignore` (git metadáta, IDE konfigurácie, hooky, auditné MD, README, lokálne env súbory, `private/` a pod.).

## GitHub Actions

### Nastavenie secrets

V repozitári na GitHub choď do **Settings → Secrets and variables → Actions** a pridaj:

| Secret                    | Popis                                                       |
| ------------------------- | ----------------------------------------------------------- |
| `DEPLOY_HOST`             | Hostname servera (napr. `shell.r1.websupport.sk`)           |
| `DEPLOY_USER`             | SSH používateľ (napr. `uid12345`)                           |
| `DEPLOY_SSH_KEY`          | Celý obsah SSH privátneho kľúča pre deploy                  |
| `DEPLOY_KNOWN_HOSTS`      | Host key servera pre `known_hosts` (voliteľné, odporúčané)  |
| `DEPLOY_PORT`             | SSH port (predvolené `22`)                                  |
| `DEPLOY_REMOTE_PATH`      | Absolútna cesta k web rootu na serveri                      |
| `POLASCIN_ADMIN_PASSWORD` | Heslo pre prvého admina pri vytvorení databázy (odporúčané) |
| `POLASCIN_ENV_INI`        | Celý obsah súboru `env.ini` na server (odporúčané)          |
| `POLASCIN_ENV_PATH`       | Cieľová cesta pre env.ini (`private/polascin.env.ini`)      |

### Aktivácia

Workflow `.github/workflows/deploy.yml` sa spustí automaticky po pushi do `main`. Ak chceš pushnúť bez deployu, použi v commit message `[skip deploy]`.

Po úspešnom súborovom deployu workflow automaticky spustí `setup_db.php` na serveri, čím sa vytvorí alebo aktualizuje databázová schéma.

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
```

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

Pri prvej inštalácii treba mať na serveri aj `env.ini` s DB credentials. Ak do GitHub secretu `POLASCIN_ENV_INI` vložíš celý obsah `env.ini`, workflow ho automaticky nahraje na cestu `private/polascin.env.ini` pred spustením migrácií.

Lokálne môžeš použiť súbor:

```bash
# ~/.config/polascin/deploy.env
POLASCIN_ENV_INI_FILE=$HOME/.config/polascin/env.ini
POLASCIN_ENV_PATH=private/polascin.env.ini
```

Pri prvej inštalácii nastav aj `POLASCIN_ADMIN_PASSWORD` v `~/.config/polascin/deploy.env` (alebo ako GitHub secret), aby sa vytvoril admin účet so známym heslom.

```bash
# Príklad lokálneho spustenia migrácií (po bežnom deploye)
ssh polascin "php ${POLASCIN_REMOTE_PATH}/setup_db.php"
```

## Bezpečnosť

- SSH privátny kľúč a deploy konfigurácia nikdy nepatria do repozitára.
- `.deployignore` zabraňuje nasadeniu `private/`, `*.env`, `*.ini`, hookov a auditných súborov.
- Na serveri over, že `private/`, `.git/`, `.env` a podobné cesty sú blokované v `.htaccess`.
