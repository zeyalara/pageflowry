<?php

// Alternative: Enhanced log driver untuk testing
$envFile = __DIR__ . '/.env';
$envContent = file_get_contents($envFile);

// Kembali ke log driver tapi dengan enhancement
$patterns = [
    '/MAIL_MAILER=.+/m' => 'MAIL_MAILER=log',
    '/MAIL_HOST=.+/m' => 'MAIL_HOST=smtp.gmail.com',
    '/MAIL_USERNAME=.+/m' => 'MAIL_USERNAME=alya488mz@gmail.com',
    '/MAIL_PASSWORD=.+/m' => 'MAIL_PASSWORD=pageflowry123',
    '/MAIL_FROM_ADDRESS=.+/m' => 'MAIL_FROM_ADDRESS=alya488mz@gmail.com',
    '/MAIL_ENCRYPTION=.*/m' => 'MAIL_ENCRYPTION=tls',
];

foreach ($patterns as $pattern => $replacement) {
    $envContent = preg_replace($pattern, $replacement, $envContent);
}

file_put_contents($envFile, $envContent);

echo "✅ Reverted to log driver for testing!" . PHP_EOL;
echo "Email akan disimpan di log dan bisa dilihat di browser." . PHP_EOL;
echo PHP_EOL;

// Clear cache
shell_exec('php artisan config:clear');
shell_exec('php artisan config:cache');

echo "✅ Configuration cache updated!" . PHP_EOL;
