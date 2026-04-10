<?php

require_once 'vendor/autoload.php';

$app = require_once 'bootstrap/app.php';

$kernel = $app->make(Illuminate\Contracts\Http\Kernel::class);

$request = Illuminate\Http\Request::capture();

$response = $kernel->handle($request);

// Test ContentBrief URL generation
try {
    echo "Testing ContentBrief URL generation...\n";
    echo "APP_URL: " . config('app.url') . "\n";
    
    $brief = App\Models\ContentBrief::first();
    if ($brief) {
        echo "Brief found: " . $brief->title . "\n";
        echo "Brief URL: " . $brief->publicViewUrl() . "\n";
        
        // Test if URL contains localhost
        $url = $brief->publicViewUrl();
        if (strpos($url, '127.0.0.1') !== false || strpos($url, 'localhost') !== false) {
            echo "ERROR: URL still contains localhost!\n";
        } else {
            echo "SUCCESS: URL uses production domain!\n";
        }
    } else {
        echo "No brief found in database\n";
    }
    
} catch (Exception $e) {
    echo "Error: " . $e->getMessage() . "\n";
}
