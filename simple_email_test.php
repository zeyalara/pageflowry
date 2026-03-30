<?php

// Simple test untuk memastikan email notification berfungsi
require __DIR__.'/vendor/autoload.php';

$app = require_once __DIR__.'/bootstrap/app.php';
$kernel = $app->make(Illuminate\Contracts\Console\Kernel::class);
$kernel->bootstrap();

use App\Models\ContentBrief;
use App\Models\Brand;
use App\Http\Controllers\ContentBriefController;

echo "=== SIMPLE EMAIL TEST ===" . PHP_EOL;

// Test dengan data real dari database
$brief = ContentBrief::first();
if (!$brief) {
    echo "❌ Tidak ada content brief di database!" . PHP_EOL;
    exit;
}

echo "✅ Found brief: {$brief->id} - {$brief->title}" . PHP_EOL;
echo "✅ Brand: " . ($brief->brand ? $brief->brand->name : 'No brand') . PHP_EOL;
echo "✅ Platform: {$brief->platform}" . PHP_EOL;

// Test email function
$controller = new ContentBriefController();
$testEmail = 'test@example.com';

echo PHP_EOL . "Testing email to: {$testEmail}" . PHP_EOL;
echo "MAIL_MAILER: " . config('mail.default') . PHP_EOL;
echo "MAIL_HOST: " . config('mail.mailers.' . config('mail.default') . '.host') . PHP_EOL;

try {
    $controller->sendCreatorNotificationEmail($brief, $testEmail);
    echo "✅ Email sent successfully!" . PHP_EOL;
} catch (Exception $e) {
    echo "❌ Email failed: " . $e->getMessage() . PHP_EOL;
}

echo PHP_EOL . "Check log for details..." . PHP_EOL;
