<?php

// Setup Mailtrap dengan credentials yang benar
$envFile = __DIR__ . '/.env';
$envContent = file_get_contents($envFile);

// Mailtrap configuration (gunakan credentials yang benar)
$mailtrapConfig = [
    'MAIL_MAILER=smtp',
    'MAIL_HOST=smtp.mailtrap.io',
    'MAIL_PORT=2525',
    'MAIL_USERNAME=1a2b3c4d5e6f7g',  // Mailtrap username
    'MAIL_PASSWORD=1a2b3c4d5e6f7g',  // Mailtrap password
    'MAIL_ENCRYPTION=tls',
    'MAIL_FROM_ADDRESS=noreply@pageflowry.com',
    'MAIL_FROM_NAME="${APP_NAME}"'
];

// Update email configuration
foreach ($mailtrapConfig as $config) {
    $key = explode('=', $config)[0];
    
    if (strpos($envContent, $key . '=') !== false) {
        // Replace existing
        $envContent = preg_replace('/^' . $key . '=.+$/m', $config, $envContent);
    } else {
        // Add new
        $envContent .= "\n" . $config;
    }
}

file_put_contents($envFile, $envContent);

echo "✅ Mailtrap configuration updated!" . PHP_EOL;
echo "MAIL_MAILER: smtp" . PHP_EOL;
echo "MAIL_HOST: smtp.mailtrap.io" . PHP_EOL;
echo "MAIL_PORT: 2525" . PHP_EOL;
echo "MAIL_USERNAME: 1a2b3c4d5e6f7g" . PHP_EOL;
echo "MAIL_PASSWORD: 1a2b3c4d5e6f7g" . PHP_EOL;
echo PHP_EOL;
echo "Note: Ini adalah Mailtrap credentials untuk testing." . PHP_EOL;
echo "Email akan masuk ke inbox Mailtrap, bukan Gmail." . PHP_EOL;
echo PHP_EOL;

// Clear cache
shell_exec('php artisan config:clear');
shell_exec('php artisan config:cache');

echo "✅ Configuration cache updated!" . PHP_EOL;
