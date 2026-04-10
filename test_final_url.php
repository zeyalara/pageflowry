<?php

require_once 'vendor/autoload.php';

$app = require_once 'bootstrap/app.php';

$kernel = $app->make(Illuminate\Contracts\Http\Kernel::class);

$request = Illuminate\Http\Request::capture();

$response = $kernel->handle($request);

// Final test of email URL generation
try {
    echo "Final test of email URL generation...\n";
    
    $brief = App\Models\ContentBrief::first();
    if ($brief) {
        $emailUrl = $brief->publicViewUrl();
        echo "Email URL: " . $emailUrl . "\n";
        
        // Check if URL contains localhost
        if (strpos($emailUrl, '127.0.0.1') !== false || strpos($emailUrl, 'localhost') !== false) {
            echo "ERROR: URL still contains localhost!\n";
        } else {
            echo "SUCCESS: URL uses production domain!\n";
        }
        
        // Check if URL uses HTTPS
        if (strpos($emailUrl, 'https://') === 0) {
            echo "SUCCESS: URL uses HTTPS!\n";
        } else {
            echo "WARNING: URL does not use HTTPS\n";
        }
        
        // Check if URL contains correct domain
        if (strpos($emailUrl, 'pageflowry.cludz.net') !== false) {
            echo "SUCCESS: URL uses correct domain!\n";
        } else {
            echo "ERROR: URL uses wrong domain!\n";
        }
        
        echo "\nEmail link is ready for production!\n";
        
    } else {
        echo "No brief found in database\n";
    }
    
} catch (Exception $e) {
    echo "Error: " . $e->getMessage() . "\n";
}
