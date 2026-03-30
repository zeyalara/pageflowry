<?php

// Update .env dengan SMTP configuration yang benar
$envFile = __DIR__ . '/.env';
$envContent = file_get_contents($envFile);

// Gunakan Mailtrap untuk testing (bisa diganti dengan Gmail nanti)
$emailConfig = [
    'MAIL_MAILER=smtp',
    'MAIL_HOST=smtp.mailtrap.io',
    'MAIL_PORT=2525',
    'MAIL_USERNAME=your-mailtrap-username',
    'MAIL_PASSWORD=your-mailtrap-password',
    'MAIL_ENCRYPTION=tls',
    'MAIL_FROM_ADDRESS=noreply@pageflowry.com',
    'MAIL_FROM_NAME="${APP_NAME}"'
];

// Update email configuration
foreach ($emailConfig as $config) {
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

echo "✅ .env updated with SMTP configuration!" . PHP_EOL;
echo "MAIL_MAILER: smtp" . PHP_EOL;
echo "MAIL_HOST: smtp.mailtrap.io" . PHP_EOL;
echo "MAIL_PORT: 2525" . PHP_EOL;
echo PHP_EOL;
echo "Note: Update MAIL_USERNAME dan MAIL_PASSWORD dengan Mailtrap credentials" . PHP_EOL;
echo "Atau ganti dengan Gmail configuration untuk production" . PHP_EOL;
echo PHP_EOL;
echo "Clear cache..." . PHP_EOL;

// Clear cache
shell_exec('php artisan config:clear');
shell_exec('php artisan config:cache');

echo "✅ Configuration cache updated!" . PHP_EOL;
