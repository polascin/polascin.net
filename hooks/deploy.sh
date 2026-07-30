#!/usr/bin/env bash

set -eEuo pipefail

usage() {
	cat <<'EOF'
Použitie: hooks/deploy.sh [--dry-run] [--migrate]

Lokálny deploy polascin.net cez rsync/SSH.
Konfiguráciu načíta zo súboru ~/.config/polascin/deploy.env alebo z premenných
prostredia (POLASCIN_DEPLOY_*). Cieľ môže odkazovať aj na host definovaný
v ~/.ssh/config (cez POLASCIN_DEPLOY_TARGET).

Príklad ~/.config/polascin/deploy.env:
  POLASCIN_DEPLOY_TARGET=websupport
  POLASCIN_REMOTE_PATH=/data/.../polascin.net

Alebo explicitne:
  POLASCIN_DEPLOY_HOST=shell.r1.websupport.sk
  POLASCIN_DEPLOY_PORT=26650
  POLASCIN_DEPLOY_USER=uid12345
  POLASCIN_REMOTE_PATH=/data/.../polascin.net
  POLASCIN_SSH_KEY=$HOME/.ssh/polascin_deploy
  POLASCIN_DEPLOY_KNOWN_HOSTS_FILE=$HOME/.ssh/known_hosts

S prepínačom --migrate sa po súborovom deployu automaticky spustí aj setup_db.php
na serveri (pre novú inštaláciu treba nastaviť POLASCIN_ADMIN_PASSWORD).
EOF
}

fail() {
	echo "[deploy] $1" >&2
	exit 1
}

validate_absolute_remote_path() {
	local path=$1
	local component
	local -a components=()

	[[ -n $path && $path == /* && ! $path =~ ^/+$ ]] || return 1
	[[ $path =~ ^/[A-Za-z0-9._/-]+$ && $path != *"//"* ]] || return 1

	IFS='/' read -r -a components <<<"$path"
	for component in "${components[@]}"; do
		[[ $component != "." && $component != ".." ]] || return 1
	done
}

DRY_RUN=0
MIGRATE=0

while (($# > 0)); do
	case "$1" in
	--dry-run)
		DRY_RUN=1
		;;
	--migrate)
		MIGRATE=1
		;;
	-h | --help)
		usage
		exit 0
		;;
	--*)
		echo "[deploy] Neznámy prepínač: $1" >&2
		usage >&2
		exit 2
		;;
	*)
		usage >&2
		exit 2
		;;
	esac
	shift
done

REPO_ROOT=$(git rev-parse --show-toplevel 2>/dev/null) || {
	echo "[deploy] Skript musí bežať v Git repozitári." >&2
	exit 1
}
cd "$REPO_ROOT" || exit 1

DEPLOY_CONFIG=${POLASCIN_DEPLOY_CONFIG:-"$HOME/.config/polascin/deploy.env"}
if [[ -r $DEPLOY_CONFIG ]]; then
	# shellcheck source=/dev/null
	source "$DEPLOY_CONFIG"
fi

REMOTE_PATH=${POLASCIN_REMOTE_PATH:-""}
DEPLOY_TARGET=${POLASCIN_DEPLOY_TARGET:-""}
DEPLOY_HOST=${POLASCIN_DEPLOY_HOST:-""}
DEPLOY_PORT=${POLASCIN_DEPLOY_PORT:-"22"}
DEPLOY_USER=${POLASCIN_DEPLOY_USER:-""}
SSH_KEY=${POLASCIN_SSH_KEY:-"$HOME/.ssh/polascin_deploy"}
KNOWN_HOSTS_FILE=${POLASCIN_DEPLOY_KNOWN_HOSTS_FILE:-""}
HOST_KEY_CHECK=${POLASCIN_SSH_HOST_KEY_CHECK:-"accept-new"}
REMOTE_ENV_PATH=${POLASCIN_ENV_PATH:-""}

if [[ -n $DEPLOY_TARGET ]]; then
	[[ $DEPLOY_TARGET =~ ^[A-Za-z0-9._-]+$ ]] ||
		fail "POLASCIN_DEPLOY_TARGET obsahuje nepodporované znaky."
	SSH_SPEC="$DEPLOY_TARGET"
elif [[ -n $DEPLOY_HOST && -n $DEPLOY_USER ]]; then
	[[ $DEPLOY_HOST =~ ^[A-Za-z0-9.-]+$ ]] ||
		fail "POLASCIN_DEPLOY_HOST obsahuje nepodporované znaky."
	[[ $DEPLOY_USER =~ ^[A-Za-z0-9._-]+$ ]] ||
		fail "POLASCIN_DEPLOY_USER obsahuje nepodporované znaky."
	[[ $DEPLOY_PORT =~ ^[0-9]{1,5}$ ]] ||
		fail "POLASCIN_DEPLOY_PORT musí byť číslo od 1 do 65535."
	((10#$DEPLOY_PORT >= 1 && 10#$DEPLOY_PORT <= 65535)) ||
		fail "POLASCIN_DEPLOY_PORT musí byť číslo od 1 do 65535."
	SSH_SPEC="${DEPLOY_USER}@${DEPLOY_HOST}"
else
	echo "[deploy] Nie je nastavený cieľ deployu." >&2
	echo "         Použij buď POLASCIN_DEPLOY_TARGET (SSH config host) alebo POLASCIN_DEPLOY_HOST + POLASCIN_DEPLOY_USER." >&2
	usage >&2
	exit 1
fi

while [[ $REMOTE_PATH == */ && $REMOTE_PATH != "/" ]]; do
	REMOTE_PATH=${REMOTE_PATH%/}
done
validate_absolute_remote_path "$REMOTE_PATH" ||
	fail "POLASCIN_REMOTE_PATH musí byť bezpečná absolútna cesta a nesmie byť koreň '/'."
REMOTE_PARENT=${REMOTE_PATH%/*}
[[ -n $REMOTE_PARENT ]] || REMOTE_PARENT="/"
REMOTE_ENV_PATH=${REMOTE_ENV_PATH:-"${REMOTE_PARENT%/}/private/polascin.env.ini"}
validate_absolute_remote_path "$REMOTE_ENV_PATH" ||
	fail "POLASCIN_ENV_PATH musí byť bezpečná absolútna cesta mimo web rootu."
case "$REMOTE_ENV_PATH" in
"$REMOTE_PATH" | "$REMOTE_PATH"/*)
	fail "POLASCIN_ENV_PATH musí byť mimo POLASCIN_REMOTE_PATH."
	;;
esac

case "$HOST_KEY_CHECK" in
yes | accept-new) ;;
*)
	fail "POLASCIN_SSH_HOST_KEY_CHECK podporuje iba hodnoty 'yes' alebo 'accept-new'."
	;;
esac

if [[ -n $KNOWN_HOSTS_FILE ]]; then
	[[ -r $KNOWN_HOSTS_FILE ]] ||
		fail "Súbor POLASCIN_DEPLOY_KNOWN_HOSTS_FILE nie je čitateľný."
	HOST_KEY_CHECK=yes
fi

if [[ -n ${POLASCIN_SSH_KEY:-} && ! -f $SSH_KEY ]]; then
	fail "Súbor POLASCIN_SSH_KEY neexistuje."
fi

SSH_OPTS=(
	-o BatchMode=yes
	-o ConnectTimeout=30
	-o "StrictHostKeyChecking=${HOST_KEY_CHECK}"
)

if [[ -n $KNOWN_HOSTS_FILE ]]; then
	SSH_OPTS+=(-o "UserKnownHostsFile=${KNOWN_HOSTS_FILE}")
fi

if [[ -z $DEPLOY_TARGET ]]; then
	SSH_OPTS+=(-p "$DEPLOY_PORT")
fi

if [[ -f $SSH_KEY ]]; then
	SSH_OPTS+=(-i "$SSH_KEY")
fi

# rsync -e rozdeľuje reťazec podľa úvodzoviek, nie podľa spätných lomítok,
# preto sa každý argument obaľuje úvodzovkami (cesty môžu obsahovať medzery).
RSYNC_RSH="ssh"
for _ssh_opt in "${SSH_OPTS[@]}"; do
	RSYNC_RSH+=" \"${_ssh_opt}\""
done
unset _ssh_opt

echo "[deploy] Cieľ: ${SSH_SPEC}:${REMOTE_PATH}"

if ((DRY_RUN)); then
	printf '[deploy] DRY-RUN: '
	printf '%q ' rsync -avz --delete-delay --exclude-from=.deployignore -e "$RSYNC_RSH" ./ "${SSH_SPEC}:${REMOTE_PATH}/"
	printf '\n'
	exit 0
fi

for required_command in git rsync ssh date base64 tr dirname; do
	command -v "$required_command" >/dev/null 2>&1 ||
		fail "Chýba príkaz: ${required_command}"
done

COMMIT=$(git rev-parse --short HEAD)
# Iba bezpečné znaky — apostrof alebo backslash vo vetve by rozbili generovaný
# PHP reťazec a footer.php by potom zhodil každú stránku fatálnou chybou.
BRANCH=$( (git symbolic-ref --quiet --short HEAD 2>/dev/null || printf 'detached') | tr -cd 'A-Za-z0-9._/-')
[[ -n $BRANCH ]] || BRANCH='detached'
UNIX_TS=$(date '+%s')
TIMESTAMP=$(date '+%d.%m.%Y %H:%M')

# Presný čas nasadenia pre pätičku — súbor vzniká pred rsyncom, aby sa
# nasadil spolu s kódom; lokálna kópia je v .gitignore. Guard proti priamemu
# spusteniu cez web (aj cez PATH_INFO) — rovnaký vzor ako v lang/*.php;
# include z footer.php guard nespustí.
cat >deploy_info.php <<'GUARD'
<?php
// Automaticky generované nasadením — neupravovať manuálne.
$requestedScript = str_replace('\\', '/', (string) ($_SERVER['SCRIPT_NAME'] ?? $_SERVER['PHP_SELF'] ?? ''));
$executedFile = isset($_SERVER['SCRIPT_FILENAME']) ? realpath((string) $_SERVER['SCRIPT_FILENAME']) : false;
if (
    PHP_SAPI !== 'cli'
    && ($executedFile === __FILE__
        || preg_match('~(?:^|/)deploy_info\.php(?:/|$)~i', $requestedScript) === 1)
) {
    http_response_code(403);
    exit('Prístup odmietnutý.');
}
unset($requestedScript, $executedFile);
GUARD
{
	printf "define('DEPLOY_TIME', '%s');\n" "$TIMESTAMP"
	printf "define('DEPLOY_TIMESTAMP', %s);\n" "$UNIX_TS"
	printf "define('DEPLOY_COMMIT', '%s');\n" "$COMMIT"
	printf "define('DEPLOY_BRANCH', '%s');\n" "$BRANCH"
} >>deploy_info.php

echo "[deploy] Overujem vzdialený cieľový adresár..."
ssh "${SSH_OPTS[@]}" "$SSH_SPEC" "test -d '${REMOTE_PATH}'"

echo "[deploy] Spúšťam rsync..."
rsync -avz --delete-delay \
	--exclude-from=.deployignore \
	-e "$RSYNC_RSH" \
	./ \
	"${SSH_SPEC}:${REMOTE_PATH}/"

echo "[deploy] Odstraňujem staré súbory určené iba pre repozitár..."
ssh "${SSH_OPTS[@]}" "$SSH_SPEC" \
	"set -eu; cd '${REMOTE_PATH}'; rm -f -- DEPLOY.md README.md .audit.md .doaudit.md .deployignore .gitignore .gitattributes env.ini.example hooks/deploy.sh hooks/deploy.env.example tests/run.php .github/workflows/deploy.yml .vscode/settings.json .vscode/tasks.json .vscode/extensions.json .claude/settings.json .trunk/trunk.yaml .trunk/configs/svgo.config.js; rmdir hooks tests .github/workflows .github .vscode .claude .trunk/configs .trunk 2>/dev/null || true"

POLASCIN_ENV_INI=${POLASCIN_ENV_INI:-""}
if [[ -z $POLASCIN_ENV_INI && -n ${POLASCIN_ENV_INI_FILE:-} && -f $POLASCIN_ENV_INI_FILE ]]; then
	POLASCIN_ENV_INI=$(cat "$POLASCIN_ENV_INI_FILE")
fi

if [[ -n $POLASCIN_ENV_INI ]]; then
	REMOTE_ENV_DIR=$(dirname -- "$REMOTE_ENV_PATH")
	echo "[deploy] Vytváram remote env config: ${REMOTE_ENV_PATH}"
	printf '%s\n' "$POLASCIN_ENV_INI" | ssh "${SSH_OPTS[@]}" "$SSH_SPEC" \
		"umask 077 && mkdir -p '${REMOTE_ENV_DIR}' && cat > '${REMOTE_ENV_PATH}' && chmod 600 '${REMOTE_ENV_PATH}'"
fi

if ((MIGRATE)); then
	echo "[deploy] Spúšťam setup_db.php na serveri..."
	if [[ -n ${POLASCIN_ADMIN_PASSWORD:-} ]]; then
		ADMIN_PASSWORD_B64=$(printf '%s' "$POLASCIN_ADMIN_PASSWORD" | base64 | tr -d '\n')
		printf '%s' "$ADMIN_PASSWORD_B64" | ssh "${SSH_OPTS[@]}" "$SSH_SPEC" \
			"cd '${REMOTE_PATH}' && ADMIN_PASSWORD_B64=\$(cat) && POLASCIN_ADMIN_PASSWORD=\$( { printf '%s' \"\$ADMIN_PASSWORD_B64\" | base64 -d; printf '.'; } ) && POLASCIN_ADMIN_PASSWORD=\${POLASCIN_ADMIN_PASSWORD%.} && export POLASCIN_ADMIN_PASSWORD POLASCIN_SETUP_QUIET=1 POLASCIN_ENV_PATH='${REMOTE_ENV_PATH}' && php setup_db.php && rm -f -- '${REMOTE_PATH}/env.ini' '${REMOTE_PATH}/private/polascin.env.ini' '${REMOTE_PATH}/private/env.ini'"
	else
		ssh "${SSH_OPTS[@]}" "$SSH_SPEC" \
			"cd '${REMOTE_PATH}' && export POLASCIN_ENV_PATH='${REMOTE_ENV_PATH}' && php setup_db.php && rm -f -- '${REMOTE_PATH}/env.ini' '${REMOTE_PATH}/private/polascin.env.ini' '${REMOTE_PATH}/private/env.ini'"
	fi
fi

echo "[deploy] Hotovo! (${TIMESTAMP}, ${BRANCH}@${COMMIT})"
