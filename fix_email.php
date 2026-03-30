<?php

// Quick fix untuk email configuration
$envFile = __DIR__ . '/.env';
$envContent = file_exists($envFile) ? file_get_contents($envFile) : '';

// Replace placeholder dengan nilai yang benar
$replacements = [
    'MAIL_USERNAME=your-email@gmail.com' => 'MAIL_USERNAME=alya488mz@gmail.com',
    'MAIL_FROM_ADDRESS=your-email@gmail.com' => 'MAIL_FROM_ADDRESS=alya488mz@gmail.com',
    'MAIL_PASSWORD=your-app-password' => 'MAIL_PASSWORD=UPDATE_WITH_GMAIL_APP_PASSWORD'
];

foreach ($replacements as $from => $to) {
    $envContent = str_replace($from, $to, $envContent);
}

file_put_contents($envFile, $envContent);

echo "✅ .env file updated!" . PHP_EOL;
echo "MAIL_USERNAME: alya488mz@gmail.com" . PHP_EOL;
echo "MAIL_FROM_ADDRESS: alya488mz@gmail.com" . PHP_EOL;
echo "MAIL_PASSWORD: UPDATE_WITH_GMAIL_APP_PASSWORD" . PHP_EOL;
echo PHP_EOL;
echo "⚠️  IMPORTANT: Update MAIL_PASSWORD dengan Gmail App Password!" . PHP_EOL;
echo "Cara dapatkan App Password:" . PHP_EOL;
echo "1. Buka Google Account → Security → 2-Step Verification" . PHP_EOL;
echo "2. App Passwords → Create new → Mail → Other" . PHP_EOL;
echo "3. Name: Pageflowry → Generate" . PHP_EOL;
echo "4. Copy 16 karakter password" . PHP_EOL;
echo "5. Update di .env: MAIL_PASSWORD=password_dari_google" . PHP_EOL;
echo PHP_EOL;
echo "Setelah update, jalankan: php artisan config:cache" . PHP_EOL;
