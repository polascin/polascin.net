<#
.SYNOPSIS
  Zrkadlí main z remotu websupport na GitHub (origin), iba fast-forward.

.DESCRIPTION
  Crontab na hostingu commituje nočný report DB (21:37) iba do websupport.
  Cloudová auditná rutina klonuje z GitHubu, preto bez zrkadlenia číta report
  o deň starší. Tento skript beží v Plánovači úloh Windows (21:50 a 02:50,
  zmeškaný beh sa spustí po zapnutí PC) a posunie origin/main na websupport/main.

  Nikdy nerobí force push. Keď origin/main nie je predkom websupport/main,
  skončí s chybou a nič nemení (Next Steps v HANDOFF.md: push websupport, potom origin).

  Log: %LOCALAPPDATA%\polascin\mirror-origin.log

.PARAMETER RepoPath
  Lokálny klon s remotmi websupport a origin. Predvolene koreň repozitára nad týmto skriptom.

.PARAMETER Register
  Zaregistruje (alebo prepíše) úlohu "polascin.net mirror origin" pre aktuálneho používateľa.
  Úloha beží iba pri prihlásenom používateľovi, heslo sa neukladá.

.EXAMPLE
  powershell -NoProfile -ExecutionPolicy Bypass -File hooks\ops\mirror-origin.ps1
  powershell -NoProfile -ExecutionPolicy Bypass -File hooks\ops\mirror-origin.ps1 -Register
#>
[CmdletBinding()]
param(
    [string]$RepoPath = (Split-Path -Parent (Split-Path -Parent $PSScriptRoot)),
    [switch]$Register
)

$ErrorActionPreference = 'Stop'
$TaskName = 'polascin.net mirror origin'

$logDir = Join-Path $env:LOCALAPPDATA 'polascin'
if (-not (Test-Path $logDir)) { New-Item -ItemType Directory -Path $logDir | Out-Null }
$logFile = Join-Path $logDir 'mirror-origin.log'

function Write-Log([string]$Message) {
    $line = '{0} {1}' -f (Get-Date -Format 'yyyy-MM-dd HH:mm:ss'), $Message
    Add-Content -Path $logFile -Value $line -Encoding UTF8
    Write-Output $line
}

function Invoke-Git {
    param([Parameter(ValueFromRemainingArguments = $true)][string[]]$GitArgs)
    # V PowerShell 5.1 by stderr natívneho príkazu pri Stop vyhodil výnimku aj pri úspechu.
    $ErrorActionPreference = 'Continue'
    $out = & git -C $RepoPath @GitArgs 2>&1
    if ($LASTEXITCODE -ne 0) {
        throw ('git {0} zlyhal ({1}): {2}' -f ($GitArgs -join ' '), $LASTEXITCODE, ($out -join ' '))
    }
    return $out
}

if ($Register) {
    $script = $MyInvocation.MyCommand.Path
    $action = New-ScheduledTaskAction -Execute 'powershell.exe' `
        -Argument ('-NoProfile -NonInteractive -ExecutionPolicy Bypass -WindowStyle Hidden -File "{0}" -RepoPath "{1}"' -f $script, $RepoPath)
    $triggers = @(
        (New-ScheduledTaskTrigger -Daily -At '21:50'),
        (New-ScheduledTaskTrigger -Daily -At '02:50')
    )
    $settings = New-ScheduledTaskSettingsSet -StartWhenAvailable -AllowStartIfOnBatteries `
        -DontStopIfGoingOnBatteries -ExecutionTimeLimit (New-TimeSpan -Minutes 10) -MultipleInstances IgnoreNew
    $principal = New-ScheduledTaskPrincipal -UserId ([Security.Principal.WindowsIdentity]::GetCurrent().Name) -LogonType Interactive
    Register-ScheduledTask -TaskName $TaskName -Action $action -Trigger $triggers -Settings $settings `
        -Principal $principal -Description 'Zrkadlí websupport/main na GitHub origin/main (iba fast-forward). Skript: hooks/ops/mirror-origin.ps1' -Force | Out-Null
    Write-Log ('Úloha "{0}" zaregistrovaná: {1} -RepoPath {2}' -f $TaskName, $script, $RepoPath)
    return
}

# ggshield pre-push hook potrebuje svoj adresár v PATH (README, HANDOFF).
$ggshieldDir = 'C:\Python314\Scripts'
if ((Test-Path $ggshieldDir) -and ($env:Path -notlike "*$ggshieldDir*")) {
    $env:Path = $ggshieldDir + ';' + $env:Path
}

try {
    Invoke-Git fetch -q websupport main | Out-Null
    Invoke-Git fetch -q origin main | Out-Null
    $source = (Invoke-Git rev-parse websupport/main | Select-Object -First 1).Trim()
    $target = (Invoke-Git rev-parse origin/main | Select-Object -First 1).Trim()

    if ($source -eq $target) {
        Write-Log ('OK, origin/main už je na {0}.' -f $source.Substring(0, 7))
        exit 0
    }

    & git -C $RepoPath merge-base --is-ancestor $target $source 2>$null
    if ($LASTEXITCODE -ne 0) {
        Write-Log ('CHYBA: origin/main {0} nie je predkom websupport/main {1}, zrkadlenie zastavené (force push sa nerobí).' -f $target.Substring(0, 7), $source.Substring(0, 7))
        exit 2
    }

    Invoke-Git push -q origin ('{0}:refs/heads/main' -f $source) | Out-Null
    Write-Log ('OK, origin/main posunutý {0} -> {1}.' -f $target.Substring(0, 7), $source.Substring(0, 7))
    exit 0
}
catch {
    Write-Log ('CHYBA: {0}' -f $_.Exception.Message)
    exit 1
}
