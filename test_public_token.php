<?php

require_once 'vendor/autoload.php';

$app = require_once 'bootstrap/app.php';

$kernel = $app->make(Illuminate\Contracts\Http\Kernel::class);

// Test public token system
try {
    echo "Testing Public Token System...\n";
    
    // Get a brief from database
    $brief = \App\Models\ContentBrief::first();
    if (!$brief) {
        echo "No brief found in database\n";
        exit;
    }
    
    echo "Brief found: " . $brief->title . "\n";
    echo "Brief ID: " . $brief->id . "\n";
    echo "User ID: " . $brief->user_id . "\n";
    
    // Generate or get public token
    $token = $brief->getPublicToken();
    echo "Public Token: " . $token . "\n";
    
    // Generate public URL
    $publicUrl = $brief->publicViewUrl();
    echo "Public URL: " . $publicUrl . "\n";
    
    // Test if token is saved in database
    $savedBrief = \App\Models\ContentBrief::where('public_token', $token)->first();
    if ($savedBrief) {
        echo "SUCCESS: Token saved in database\n";
        echo "Saved Token: " . $savedBrief->public_token . "\n";
    } else {
        echo "ERROR: Token not found in database\n";
    }
    
    // Test route exists
    $routeExists = \Illuminate\Support\Facades\Route::has('public.brief');
    echo "Route 'public.brief' exists: " . ($routeExists ? 'YES' : 'NO') . "\n";
    
    // Test if controller method exists
    $controller = new \App\Http\Controllers\PublicBriefController();
    $methodExists = method_exists($controller, 'showBrief');
    echo "Controller method exists: " . ($methodExists ? 'YES' : 'NO') . "\n";
    
    // Test if view exists
    $viewExists = view()->exists('public.brief');
    echo "View 'public.brief' exists: " . ($viewExists ? 'YES' : 'NO') . "\n";
    
    // Test URL structure
    $expectedUrl = config('app.url') . '/brief/' . $token;
    echo "Expected URL: " . $expectedUrl . "\n";
    
    if ($publicUrl === $expectedUrl) {
        echo "SUCCESS: URL structure is correct\n";
    } else {
        echo "ERROR: URL structure mismatch\n";
    }
    
    echo "\nPublic Token System is ready!\n";
    echo "Access URL: " . $publicUrl . "\n";
    
} catch (Exception $e) {
    echo "Error: " . $e->getMessage() . "\n";
    echo "File: " . $e->getFile() . "\n";
    echo "Line: " . $e->getLine() . "\n";
}
