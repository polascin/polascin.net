#!/usr/bin/env bash

set -uo pipefail

usage() {
	cat <<'EOF'
Použitie: hooks/deploy.sh [--dry-run] [--migrate]

Lokálny deploy polascin.net cez rsync/SSH.
Konfiguráciu načíta z:
  1. Premenných prostredia (POLASCIN_DEPLOY_*)
  2. Súboru ~/.config/polascin/deploy.env
  3. SSH config hostu nastaveného v ~/.ssh/config (cez POLASCIN_DEPLOY_TARGET)

Príklad ~/.config/polascin/deploy.env:
  POLASCIN_DEPLOY_TARGET=websupport
  POLASCIN_REMOTE_PATH=/data/.../polascin.net

Alebo explicitne:
  POLASCIN_DEPLOY_HOST=shell.r1.websupport.sk
  POLASCIN_DEPLOY_PORT=26650
  POLASCIN_DEPLOY_USER=uid12345
  POLASCIN_REMOTE_PATH=/data/.../polascin.net
  POLASCIN_SSH_KEY=$HOME/.ssh/polascin_deploy

S prepínačom --migrate sa po súborovom deployu automaticky spustí aj setup_db.php
na serveri (pre novú inštaláciu treba nastaviť POLASCIN_ADMIN_PASSWORD).
EOF
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

if [[ -n $DEPLOY_TARGET ]]; then
	SSH_SPEC="$DEPLOY_TARGET"
	SSH_OPTS="-o BatchMode=yes -o ConnectTimeout=30 -o StrictHostKeyChecking=accept-new"
	if [[ -f $SSH_KEY ]]; then
		SSH_OPTS="$SSH_OPTS -i $SSH_KEY"
	fi
elif [[ -n $DEPLOY_HOST && -n $DEPLOY_USER ]]; then
	SSH_SPEC="${DEPLOY_USER}@${DEPLOY_HOST}"
	SSH_OPTS="-p ${DEPLOY_PORT} -o BatchMode=yes -o ConnectTimeout=30 -o StrictHostKeyChecking=accept-new"
	if [[ -f $SSH_KEY ]]; then
		SSH_OPTS="$SSH_OPTS -i $SSH_KEY"
	fi
else
	echo "[deploy] Nie je nastavený cieľ deployu." >&2
	echo "         Použij buď POLASCIN_DEPLOY_TARGET (SSH config host) alebo POLASCIN_DEPLOY_HOST + POLASCIN_DEPLOY_USER." >&2
	usage >&2
	exit 1
fi

if [[ -z $REMOTE_PATH ]]; then
	echo "[deploy] Chýba POLASCIN_REMOTE_PATH." >&2
	exit 1
fi

REMOTE_PATH=${REMOTE_PATH%/}

echo "[deploy] Cieľ: ${SSH_SPEC}:${REMOTE_PATH}"

if ((DRY_RUN)); then
	echo "[deploy] DRY-RUN: rsync -avz --delete -e \"ssh ${SSH_OPTS}\" ./ ${SSH_SPEC}:${REMOTE_PATH}/ --exclude-from=.deployignore"
	exit 0
fi

if ! command -v rsync >/dev/null 2>&1; then
	echo "[deploy] Chýba príkaz: rsync" >&2
	exit 1
fi

echo "[deploy] Spúšťam rsync..."
rsync -avz --delete \
	-e "ssh ${SSH_OPTS}" \
	./ \
	"${SSH_SPEC}:${REMOTE_PATH}/" \
	--exclude-from=.deployignore

RC=$?
if ((RC != 0)); then
	echo "[deploy] rsync zlyhal (exit code: $RC)." >&2
	exit "$RC"
fi

COMMIT=$(git rev-parse --short HEAD)
BRANCH=$(git symbolic-ref --quiet --short HEAD 2>/dev/null || printf 'detached')
TIMESTAMP=$(date '+%d.%m.%Y %H:%M')
UNIX_TS=$(date '+%s')

DEPLOY_INFO=$(mktemp)
cat >"$DEPLOY_INFO" <<PHPEOF
<?php
define('DEPLOY_TIME', '${TIMESTAMP}');
define('DEPLOY_TIMESTAMP', ${UNIX_TS});
define('DEPLOY_COMMIT', '${COMMIT}');
define('DEPLOY_BRANCH', '${BRANCH}');
PHPEOF

scp ${SSH_OPTS// -p / -P} "$DEPLOY_INFO" "${SSH_SPEC}:${REMOTE_PATH}/deploy_info.php"
rm -f "$DEPLOY_INFO"

POLASCIN_ENV_INI=${POLASCIN_ENV_INI:-""}
if [[ -z $POLASCIN_ENV_INI && -n ${POLASCIN_ENV_INI_FILE:-} && -f $POLASCIN_ENV_INI_FILE ]]; then
	POLASCIN_ENV_INI=$(cat "$POLASCIN_ENV_INI_FILE")
fi

if [[ -n $POLASCIN_ENV_INI ]]; then
	REMOTE_ENV_PATH="${POLASCIN_ENV_PATH:-private/polascin.env.ini}"
	REMOTE_ENV_DIR=$(dirname "$REMOTE_ENV_PATH")
	echo "[deploy] Vytváram remote env config: ${REMOTE_ENV_PATH}"
	printf '%s\n' "$POLASCIN_ENV_INI" | ssh ${SSH_OPTS} "${SSH_SPEC}" \
		"cd '${REMOTE_PATH}' && mkdir -p '${REMOTE_ENV_DIR}' && umask 077 && cat > '${REMOTE_ENV_PATH}' && chmod 640 '${REMOTE_ENV_PATH}'"
fi

if ((MIGRATE)); then
	echo "[deploy] Spúšťam setup_db.php na serveri..."
	if [[ -n ${POLASCIN_ADMIN_PASSWORD:-} ]]; then
		ssh ${SSH_OPTS} "${SSH_SPEC}" \
			"cd '${REMOTE_PATH}' && POLASCIN_SETUP_QUIET=1 POLASCIN_ADMIN_PASSWORD='${POLASCIN_ADMIN_PASSWORD}' php setup_db.php"
	else
		ssh ${SSH_OPTS} "${SSH_SPEC}" \
			"cd '${REMOTE_PATH}' && php setup_db.php"
	fi
fi

echo "[deploy] Hotovo! (${TIMESTAMP}, ${BRANCH}@${COMMIT})"
