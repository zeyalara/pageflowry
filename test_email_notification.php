<?php

// Test email notification functionality
require __DIR__.'/vendor/autoload.php';

$app = require_once __DIR__.'/bootstrap/app.php';
$kernel = $app->make(Illuminate\Contracts\Console\Kernel::class);
$kernel->bootstrap();

use App\Models\ContentBrief;
use App\Models\Brand;

echo "=== TEST EMAIL NOTIFICATION ===" . PHP_EOL;

// Test dengan data dummy
$testBrief = new stdClass();
$testBrief->id = 999;
$testBrief->title = 'Test Brief for Email';
$testBrief->description = 'Test description';
$testBrief->objective = 'Test objective';
$testBrief->platform = 'Instagram';
$testBrief->production_deadline = now()->addDays(7);
$testBrief->created_at = now();

$testBrand = new stdClass();
$testBrand->name = 'Test Brand';

$testBrief->brand = $testBrand;

// Test email function
$controller = new App\Http\Controllers\ContentBriefController();

echo "Testing email to: alya488mz@gmail.com" . PHP_EOL;
echo "MAIL_MAILER: " . config('mail.default') . PHP_EOL;
echo "MAIL_HOST: " . config('mail.mailers.' . config('mail.default') . '.host') . PHP_EOL;

try {
    $controller->sendCreatorNotificationEmail($testBrief, 'alya488mz@gmail.com');
    echo "✅ Email function executed successfully!" . PHP_EOL;
} catch (Exception $e) {
    echo "❌ Email function failed: " . $e->getMessage() . PHP_EOL;
}

echo PHP_EOL . "Check log file for details..." . PHP_EOL;
