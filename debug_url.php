<?php

require_once 'vendor/autoload.php';

$app = require_once 'bootstrap/app.php';

$kernel = $app->make(Illuminate\Contracts\Http\Kernel::class);

$request = Illuminate\Http\Request::capture();

$response = $kernel->handle($request);

// Debug URL generation step by step
try {
    echo "Debugging URL generation...\n";
    
    $brief = App\Models\ContentBrief::first();
    if ($brief) {
        echo "Brief ID: " . $brief->id . "\n";
        echo "APP_KEY: " . substr(config('app.key'), 0, 20) . "...\n";
        
        // Test publicAccessToken
        $token = $brief->publicAccessToken();
        echo "Public Access Token: " . $token . "\n";
        
        // Test URL components
        $path = '/content-briefs/'.$brief->getKey().'/view?token='.urlencode($token);
        echo "URL Path: " . $path . "\n";
        
        // Test url() helper directly
        $fullUrl = url($path);
        echo "Full URL: " . $fullUrl . "\n";
        
        // Compare with publicViewUrl method
        $methodUrl = $brief->publicViewUrl();
        echo "Method URL: " . $methodUrl . "\n";
        
        if ($fullUrl !== $methodUrl) {
            echo "ERROR: URLs don't match!\n";
        } else {
            echo "SUCCESS: URLs match!\n";
        }
        
    } else {
        echo "No brief found\n";
    }
    
} catch (Exception $e) {
    echo "Error: " . $e->getMessage() . "\n";
}
