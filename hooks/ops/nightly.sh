#!/usr/bin/env bash
# Nočné úlohy polascin.net priamo na hostingu (crontab), bez GitHub Actions.
#
#   retention:   retenčné čistenie osobných a prevádzkových údajov
#   verify-db:   read-only kontrola produkčnej DB; report sa commitne do
#                repozitára na serveri (audit-reports/db-latest.md)
#
# Skripty sa berú z vetvy `main` v repozitári na serveri, nie z web rootu:
# `scripts/` sa nenasadzuje a cez web nesmie byť dosiahnuteľný. PHP číta kód
# zo stdin a beží v web roote, rovnako ako predtým workflowy (getcwd()).
# Crontab spúšťa tento súbor tiež priamo z `main` (hooks/ops/crontab.txt).

set -euo pipefail
umask 077

MODE=${1:-}
BASE=${POLASCIN_BASE:-"$HOME/polascin.net"}
WEB=${POLASCIN_WEB_ROOT:-"$BASE/web"}
ENV_PATH=${POLASCIN_ENV_PATH:-"$BASE/private/polascin.env.ini"}
GIT_DIR_BARE=${POLASCIN_GIT_DIR:-"$HOME/git/polascin.net.git"}
LOCK_FILE="$BASE/private/ops.lock"

log() {
	printf '[%s] [%s] %s\n' "$(date '+%Y-%m-%d %H:%M:%S %Z')" "${MODE:-ops}" "$1"
}

php_from_main() {
	# $1 = cesta v repozitári; ďalšie argumenty sú premenné prostredia.
	local script_path=$1
	shift
	git --git-dir="$GIT_DIR_BARE" show "main:${script_path}" |
		(cd "$WEB" && env POLASCIN_ENV_PATH="$ENV_PATH" "$@" php)
}

run_retention() {
	log "Spúšťam retenčné čistenie."
	php_from_main scripts/retention_cleanup.php RETENTION_DRY_RUN="${RETENTION_DRY_RUN:-false}"
	log "Retenčné čistenie skončilo."
}

run_verify_db() {
	local work report stderr status attempts
	work=$(mktemp -d "$BASE/private/ops-verify.XXXXXX")
	# shellcheck disable=SC2064
	trap "rm -rf -- '$work'" EXIT
	report="$work/db-latest.md"
	stderr="$work/db-stderr.log"

	log "Spúšťam read-only kontrolu DB."
	if ! php_from_main scripts/audit_db_check.php >"$report" 2>"$stderr"; then
		{
			echo "# Kontrola produkčnej databázy: polascin.net"
			echo
			echo "STATUS: ZLYHANIE"
			echo "NALEZOV: neznáme"
			echo
			echo '## Súhrn'
			echo
			echo "Kontrolu nebolo možné dokončiť, skript zlyhal."
			echo "Nejde o vyjadrenie o stave databázy: tá nebola overená."
			echo
			echo '### Chybový výstup'
			echo
			echo '```'
			sed -e "s~${WEB}~<WEB_ROOT>~g" -e "s~${ENV_PATH}~<ENV_PATH>~g" "$stderr" | tail -30
			echo '```'
		} >"$report"
	fi
	status=$(grep -m1 '^STATUS: ' "$report" | cut -d' ' -f2- || echo "ZLYHANIE")
	log "Stav kontroly DB: ${status}"

	git clone -q --branch main "$GIT_DIR_BARE" "$work/repo"
	mkdir -p "$work/repo/audit-reports"
	cp "$report" "$work/repo/audit-reports/db-latest.md"
	cd "$work/repo"
	git add audit-reports/db-latest.md
	if git diff --cached --quiet -- audit-reports/db-latest.md; then
		log "Report sa nezmenil, commit nie je potrebný."
	else
		git -c user.name="polascin-ops" -c user.email="polascin-ops@localhost" \
			commit -q -m "chore(audit): nočná kontrola produkčnej DB: ${status} [skip deploy]"
		attempts=0
		until git push -q origin HEAD:main; do
			attempts=$((attempts + 1))
			((attempts < 3)) || {
				log "Push reportu zlyhal po ${attempts} pokusoch."
				return 1
			}
			git pull -q --rebase origin main
		done
		log "Report commitnutý do main ($(git rev-parse --short HEAD))."
	fi
	cd "$BASE"
	[[ $status == "OK" ]]
}

case "$MODE" in
retention | verify-db) ;;
*)
	echo "Použitie: nightly.sh retention|verify-db" >&2
	exit 2
	;;
esac

[[ -d $GIT_DIR_BARE && -d $WEB && -r $ENV_PATH ]] || {
	log "Chýba repozitár, web root alebo konfigurácia."
	exit 1
}

# Rovnaký zámok ako nasadenie: kontrola nikdy nebeží nad rozostavaným web rootom.
exec 9>"$LOCK_FILE"
flock -w 900 9 || {
	log "Zámok $LOCK_FILE sa neuvoľnil do 15 minút."
	exit 1
}

if [[ $MODE == retention ]]; then
	run_retention
else
	run_verify_db
fi
