<?php

// Script untuk update .env dengan konfigurasi email
$envFile = __DIR__ . '/.env';
$envContent = file_exists($envFile) ? file_get_contents($envFile) : '';

// Email configuration to add
$emailConfig = [
    'MAIL_MAILER=smtp',
    'MAIL_HOST=smtp.gmail.com',
    'MAIL_PORT=587',
    'MAIL_USERNAME=your-email@gmail.com',
    'MAIL_PASSWORD=your-app-password',
    'MAIL_ENCRYPTION=tls',
    'MAIL_FROM_ADDRESS=your-email@gmail.com',
    'MAIL_FROM_NAME="${APP_NAME}"'
];

// Update or add email configuration
$newEnvContent = $envContent;
foreach ($emailConfig as $config) {
    $key = explode('=', $config)[0];
    
    if (strpos($newEnvContent, $key . '=') !== false) {
        // Replace existing
        $newEnvContent = preg_replace('/^' . $key . '=.+$/m', $config, $newEnvContent);
    } else {
        // Add new
        $newEnvContent .= "\n" . $config;
    }
}

// Write back to .env
file_put_contents($envFile, $newEnvContent);

echo "✅ .env file updated with email configuration!" . PHP_EOL;
echo "Please update the following values in .env:" . PHP_EOL;
echo "- MAIL_USERNAME (your Gmail address)" . PHP_EOL;
echo "- MAIL_PASSWORD (Gmail App Password)" . PHP_EOL;
echo "- MAIL_FROM_ADDRESS (your Gmail address)" . PHP_EOL;
echo PHP_EOL;
echo "Then run: php artisan config:cache" . PHP_EOL;
