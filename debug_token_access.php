<?php

require_once 'vendor/autoload.php';

$app = require_once 'bootstrap/app.php';

$kernel = $app->make(Illuminate\Contracts\Http\Kernel::class);

// Test direct access to token-based URL
try {
    echo "Debug Token Access...\n";
    
    // Get a brief with token
    $brief = \App\Models\ContentBrief::whereNotNull('public_token')->first();
    if (!$brief) {
        echo "No brief with token found. Generating token...\n";
        $brief = \App\Models\ContentBrief::first();
        if ($brief) {
            $token = $brief->getPublicToken();
            echo "Generated token: " . $token . "\n";
        } else {
            echo "No brief found in database\n";
            exit;
        }
    }
    
    echo "Brief: " . $brief->title . "\n";
    echo "Token: " . $brief->public_token . "\n";
    
    // Test if we can find the brief by token
    $foundBrief = \App\Models\ContentBrief::where('public_token', $brief->public_token)->first();
    if ($foundBrief) {
        echo "SUCCESS: Brief found by token\n";
        echo "Found Brief ID: " . $foundBrief->id . "\n";
    } else {
        echo "ERROR: Brief not found by token\n";
    }
    
    // Test if route exists
    $routeExists = \Illuminate\Support\Facades\Route::has('brief.public');
    echo "Route exists: " . ($routeExists ? 'YES' : 'NO') . "\n";
    
    // Test if controller method exists
    $controller = new \App\Http\Controllers\ContentBriefController();
    $methodExists = method_exists($controller, 'showByToken');
    echo "Controller method exists: " . ($methodExists ? 'YES' : 'NO') . "\n";
    
    // Test if view exists
    $viewExists = view()->exists('public.brief');
    echo "View exists: " . ($viewExists ? 'YES' : 'NO') . "\n";
    
    echo "\nURL should be accessible: " . $brief->publicViewUrl() . "\n";
    
} catch (Exception $e) {
    echo "Error: " . $e->getMessage() . "\n";
    echo "File: " . $e->getFile() . "\n";
    echo "Line: " . $e->getLine() . "\n";
}
