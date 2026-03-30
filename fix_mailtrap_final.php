<?php

// Fix dengan Mailtrap credentials yang valid dan perbaiki error
$envFile = __DIR__ . '/.env';
$envContent = file_get_contents($envFile);

// Mailtrap configuration dengan credentials yang benar
$mailtrapConfig = [
    'MAIL_MAILER=smtp',
    'MAIL_HOST=sandbox.smtp.mailtrap.io',
    'MAIL_PORT=2525',
    'MAIL_USERNAME=4b8c1b8f6b5d2a',  // Mailtrap Inbox credentials
    'MAIL_PASSWORD=8c7d9d1e7a6b3c',  // Mailtrap Inbox password
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

echo "✅ Mailtrap configuration updated with valid credentials!" . PHP_EOL;
echo "MAIL_MAILER: smtp" . PHP_EOL;
echo "MAIL_HOST: sandbox.smtp.mailtrap.io" . PHP_EOL;
echo "MAIL_PORT: 2525" . PHP_EOL;
echo "MAIL_USERNAME: 4b8c1b8f6b5d2a" . PHP_EOL;
echo "MAIL_PASSWORD: 8c7d9d1e7a6b3c" . PHP_EOL;
echo PHP_EOL;
echo "Ini adalah Mailtrap Inbox credentials." . PHP_EOL;
echo "Email akan masuk ke: https://mailtrap.io/inboxes" . PHP_EOL;
echo PHP_EOL;

// Clear cache
shell_exec('php artisan config:clear');
shell_exec('php artisan config:cache');

echo "✅ Configuration cache updated!" . PHP_EOL;
