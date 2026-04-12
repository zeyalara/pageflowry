<?php

require_once 'vendor/autoload.php';

$app = require_once 'bootstrap/app.php';

$kernel = $app->make(Illuminate\Contracts\Http\Kernel::class);

// Simulate request to test the public view
try {
    echo "Testing public view access...\n";
    
    // Get a brief from database
    $brief = App\Models\ContentBrief::first();
    if (!$brief) {
        echo "No brief found in database\n";
        exit;
    }
    
    echo "Brief found: " . $brief->title . "\n";
    echo "Brief ID: " . $brief->id . "\n";
    
    // Generate URL
    $url = $brief->publicViewUrl();
    echo "Public URL: " . $url . "\n";
    
    // Parse URL to get components
    $parsedUrl = parse_url($url);
    echo "Path: " . $parsedUrl['path'] . "\n";
    echo "Query: " . ($parsedUrl['query'] ?? '') . "\n";
    
    // Extract ID and token from URL
    parse_str($parsedUrl['query'] ?? '', $query);
    $id = $brief->id;
    $token = $query['token'] ?? '';
    
    echo "ID from URL: " . $id . "\n";
    echo "Token from URL: " . substr($token, 0, 20) . "...\n";
    
    // Test token validation
    $expectedToken = $brief->publicAccessToken();
    echo "Expected token: " . substr($expectedToken, 0, 20) . "...\n";
    
    if ($token === $expectedToken) {
        echo "SUCCESS: Token matches!\n";
    } else {
        echo "ERROR: Token mismatch!\n";
    }
    
    // Test if route exists
    $routeExists = \Illuminate\Support\Facades\Route::has('brief.public-view');
    echo "Route 'brief.public-view' exists: " . ($routeExists ? 'YES' : 'NO') . "\n";
    
    echo "\nPublic view should be accessible at: " . $url . "\n";
    
} catch (Exception $e) {
    echo "Error: " . $e->getMessage() . "\n";
}
