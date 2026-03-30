<?php

// Direct fix untuk email configuration
$envFile = __DIR__ . '/.env';
$envContent = file_get_contents($envFile);

// Replace semua email configuration dengan yang benar
$patterns = [
    '/MAIL_USERNAME=.+/m' => 'MAIL_USERNAME=alya488mz@gmail.com',
    '/MAIL_PASSWORD=.+/m' => 'MAIL_PASSWORD=pageflowry123', // Temporary password untuk test
    '/MAIL_FROM_ADDRESS=.+/m' => 'MAIL_FROM_ADDRESS=alya488mz@gmail.com',
    '/MAIL_ENCRYPTION=.*/m' => 'MAIL_ENCRYPTION=tls',
];

foreach ($patterns as $pattern => $replacement) {
    $envContent = preg_replace($pattern, $replacement, $envContent);
}

file_put_contents($envFile, $envContent);

echo "✅ .env file updated with correct email configuration!" . PHP_EOL;
echo "MAIL_USERNAME: alya488mz@gmail.com" . PHP_EOL;
echo "MAIL_PASSWORD: pageflowry123" . PHP_EOL;
echo "MAIL_FROM_ADDRESS: alya488mz@gmail.com" . PHP_EOL;
echo "MAIL_ENCRYPTION: tls" . PHP_EOL;
echo PHP_EOL;
echo "Running: php artisan config:cache" . PHP_EOL;

// Clear and rebuild cache
shell_exec('php artisan config:clear');
shell_exec('php artisan config:cache');

echo "✅ Configuration cache updated!" . PHP_EOL;
