<?php

// Force kembali ke log driver yang pasti berfungsi
$envFile = __DIR__ . '/.env';
$envContent = file_get_contents($envFile);

// Force log driver
$patterns = [
    '/MAIL_MAILER=.+/m' => 'MAIL_MAILER=log',
    '/MAIL_HOST=.+/m' => 'MAIL_HOST=',
    '/MAIL_PORT=.+/m' => 'MAIL_PORT=',
    '/MAIL_USERNAME=.+/m' => 'MAIL_USERNAME=',
    '/MAIL_PASSWORD=.+/m' => 'MAIL_PASSWORD=',
    '/MAIL_ENCRYPTION=.*/m' => 'MAIL_ENCRYPTION=',
];

foreach ($patterns as $pattern => $replacement) {
    $envContent = preg_replace($pattern, $replacement, $envContent);
}

file_put_contents($envFile, $envContent);

echo "✅ Forced back to LOG driver!" . PHP_EOL;
echo "MAIL_MAILER: log" . PHP_EOL;
echo "Email akan disimpan di log file" . PHP_EOL;
echo PHP_EOL;

// Clear cache
shell_exec('php artisan config:clear');
shell_exec('php artisan config:cache');

echo "✅ Configuration cache updated!" . PHP_EOL;
