<?php

require __DIR__.'/vendor/autoload.php';

$app = require_once __DIR__.'/bootstrap/app.php';

$kernel = $app->make(Illuminate\Contracts\Console\Kernel::class);

$kernel->bootstrap();

// Test email configuration
echo "=== EMAIL CONFIGURATION CHECK ===" . PHP_EOL;
echo "MAIL_MAILER: " . config('mail.default') . PHP_EOL;
echo "MAIL_HOST: " . config('mail.mailers.' . config('mail.default') . '.host') . PHP_EOL;
echo "MAIL_USERNAME: " . config('mail.mailers.' . config('mail.default') . '.username') . PHP_EOL;
echo "MAIL_ENCRYPTION: " . config('mail.mailers.' . config('mail.default') . '.encryption') . PHP_EOL;
echo "MAIL_PORT: " . config('mail.mailers.' . config('mail.default') . '.port') . PHP_EOL;

echo PHP_EOL . "=== TESTING EMAIL SEND ===" . PHP_EOL;

try {
    Mail::raw('Test email from Pageflowry', function($message) {
        $message->to('test@example.com')
            ->subject('Test Email Configuration')
            ->from(config('mail.from.address'), config('mail.from.name'));
    });
    echo "✅ Test email sent successfully!" . PHP_EOL;
} catch (Exception $e) {
    echo "❌ Error sending email: " . $e->getMessage() . PHP_EOL;
}

echo PHP_EOL . "=== LOG FILE CHECK ===" . PHP_EOL;
$logFile = storage_path('logs/laravel.log');
if (file_exists($logFile)) {
    $logContent = file_get_contents($logFile);
    if (strpos($logContent, 'test@example.com') !== false) {
        echo "✅ Email found in log file (using log driver)" . PHP_EOL;
    } else {
        echo "❌ Email not found in log file" . PHP_EOL;
    }
} else {
    echo "❌ Log file not found" . PHP_EOL;
}
