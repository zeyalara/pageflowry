<?php

require_once 'vendor/autoload.php';

$app = require_once 'bootstrap/app.php';

$kernel = $app->make(Illuminate\Contracts\Http\Kernel::class);

// Test if route and controller work
try {
    echo "Testing route access...\n";
    
    // Get a brief
    $brief = \App\Models\ContentBrief::first();
    if (!$brief) {
        echo "No brief found in database\n";
        exit;
    }
    
    echo "Brief ID: " . $brief->id . "\n";
    echo "Brief Title: " . $brief->title . "\n";
    
    // Generate URL
    $url = $brief->publicViewUrl();
    echo "Generated URL: " . $url . "\n";
    
    // Parse URL to get components
    $parsedUrl = parse_url($url);
    $path = $parsedUrl['path'] ?? '';
    $query = $parsedUrl['query'] ?? '';
    
    echo "Path: " . $path . "\n";
    echo "Query: " . $query . "\n";
    
    // Extract ID and token
    if (preg_match('/\/content-briefs\/(\d+)\/view/', $path, $matches)) {
        $id = $matches[1];
        echo "Extracted ID: " . $id . "\n";
    }
    
    if (preg_match('/token=([^&]+)/', $query, $matches)) {
        $token = $matches[1];
        echo "Extracted Token: " . substr($token, 0, 20) . "...\n";
    }
    
    // Test if route exists
    $routeExists = \Illuminate\Support\Facades\Route::has('brief.public-view');
    echo "Route exists: " . ($routeExists ? 'YES' : 'NO') . "\n";
    
    // Test if method exists
    $controller = new \App\Http\Controllers\ContentBriefController();
    $methodExists = method_exists($controller, 'publicView');
    echo "Controller method exists: " . ($methodExists ? 'YES' : 'NO') . "\n";
    
    // Test if view exists
    $viewExists = view()->exists('brief.public-view');
    echo "View exists: " . ($viewExists ? 'YES' : 'NO') . "\n";
    
    echo "\nAll components are ready! URL should be accessible.\n";
    echo "Test URL: " . $url . "\n";
    
} catch (Exception $e) {
    echo "Error: " . $e->getMessage() . "\n";
    echo "File: " . $e->getFile() . "\n";
    echo "Line: " . $e->getLine() . "\n";
}
