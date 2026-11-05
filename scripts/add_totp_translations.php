<?php
declare(strict_types=1);

require_once dirname(__DIR__) . '/guard.php';
guardInternalAccess(__FILE__);

if (PHP_SAPI !== 'cli') {
    http_response_code(403);
    exit("Prístup odmietnutý. Spustite cez príkazový riadok.\n");
}

// Pridá TOTP preklady do všetkých jazykových súborov

$translations = [
    'en' => [
        'login.totp_prompt' => 'Enter the 6-digit code from your authenticator app.',
        'login.totp_code' => 'Verification code (2FA)',
        'login.totp_submit' => 'Verify code',
        'login.error_totp_invalid' => 'Invalid verification code. Check the time in your authenticator.',
        'login.error_totp_reused' => 'This code has already been used. Wait for a new code.',
    ],
    'cs' => [
        'login.totp_prompt' => 'Zadejte 6místný kód z autentizační aplikace.',
        'login.totp_code' => 'Ověřovací kód (2FA)',
        'login.totp_submit' => 'Ověřit kód',
        'login.error_totp_invalid' => 'Neplatný ověřovací kód. Zkontrolujte čas v aplikaci.',
        'login.error_totp_reused' => 'Tento kód byl již použit. Počkejte na nový kód.',
    ],
    'de' => [
        'login.totp_prompt' => 'Geben Sie den 6-stelligen Code aus Ihrer Authentifizierungs-App ein.',
        'login.totp_code' => 'Bestätigungscode (2FA)',
        'login.totp_submit' => 'Code bestätigen',
        'login.error_totp_invalid' => 'Ungültiger Bestätigungscode. Prüfen Sie die Zeit in der App.',
        'login.error_totp_reused' => 'Dieser Code wurde bereits verwendet. Warten Sie auf einen neuen Code.',
    ],
    'fr' => [
        'login.totp_prompt' => 'Entrez le code à 6 chiffres de votre application d\'authentification.',
        'login.totp_code' => 'Code de vérification (2FA)',
        'login.totp_submit' => 'Vérifier le code',
        'login.error_totp_invalid' => 'Code de vérification invalide. Vérifiez l\'heure dans l\'application.',
        'login.error_totp_reused' => 'Ce code a déjà été utilisé. Attendez un nouveau code.',
    ],
    'es' => [
        'login.totp_prompt' => 'Introduce el código de 6 dígitos de tu aplicación de autenticación.',
        'login.totp_code' => 'Código de verificación (2FA)',
        'login.totp_submit' => 'Verificar código',
        'login.error_totp_invalid' => 'Código de verificación no válido. Comprueba la hora en la aplicación.',
        'login.error_totp_reused' => 'Este código ya se ha usado. Espera un código nuevo.',
    ],
    'pl' => [
        'login.totp_prompt' => 'Wprowadź 6-cyfrowy kod z aplikacji uwierzytelniającej.',
        'login.totp_code' => 'Kod weryfikacyjny (2FA)',
        'login.totp_submit' => 'Zweryfikuj kod',
        'login.error_totp_invalid' => 'Nieprawidłowy kod weryfikacyjny. Sprawdź czas w aplikacji.',
        'login.error_totp_reused' => 'Ten kod został już użyty. Poczekaj na nowy kod.',
    ],
    'hu' => [
        'login.totp_prompt' => 'Írja be a 6 jegyű kódot a hitelesítő alkalmazásból.',
        'login.totp_code' => 'Ellenőrző kód (2FA)',
        'login.totp_submit' => 'Kód ellenőrzése',
        'login.error_totp_invalid' => 'Érvénytelen ellenőrző kód. Ellenőrizze az időt az alkalmazásban.',
        'login.error_totp_reused' => 'Ez a kód már fel lett használva. Várjon egy új kódra.',
    ],
    'it' => [
        'login.totp_prompt' => 'Inserisci il codice a 6 cifre dalla tua app di autenticazione.',
        'login.totp_code' => 'Codice di verifica (2FA)',
        'login.totp_submit' => 'Verifica codice',
        'login.error_totp_invalid' => 'Codice di verifica non valido. Controlla l\'ora nell\'app.',
        'login.error_totp_reused' => 'Questo codice è già stato utilizzato. Attendi un nuovo codice.',
    ],
    'uk' => [
        'login.totp_prompt' => 'Введіть 6-значний код з вашого автентифікатора.',
        'login.totp_code' => 'Код підтвердження (2FA)',
        'login.totp_submit' => 'Підтвердити код',
        'login.error_totp_invalid' => 'Недійсний код підтвердження. Перевірте час в автентифікаторі.',
        'login.error_totp_reused' => 'Цей код вже використано. Зачекайте на новий код.',
    ],
];

$langDir = __DIR__ . '/../lang';

foreach ($translations as $lang => $keys) {
    $file = $langDir . '/' . $lang . '.php';
    if (!is_file($file)) {
        echo "Preskakujem $lang.php (neexistuje)\n";
        continue;
    }
    
    $content = file_get_contents($file);
    $lines = explode("\n", $content);
    
    // Nájdeme posledný login.* záznam
    $insertIndex = -1;
    for ($i = count($lines) - 1; $i >= 0; $i--) {
        if (strpos($lines[$i], "'login.") !== false) {
            $insertIndex = $i + 1;
            break;
        }
    }
    
    if ($insertIndex === -1 || $insertIndex >= count($lines)) {
        echo "Nenašiel sa bod vloženia pre $lang.php\n";
        continue;
    }
    
    $newLines = [];
    foreach ($keys as $key => $value) {
        $escaped = str_replace("'", "\\'", $value);
        $newLines[] = "    '" . $key . "' => '" . $escaped . "',";
    }
    
    array_splice($lines, $insertIndex, 0, $newLines);
    file_put_contents($file, implode("\n", $lines));
    echo "Pridané preklady do $lang.php\n";
}

echo "Hotovo!\n";
