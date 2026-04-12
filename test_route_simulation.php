<?php

require_once 'vendor/autoload.php';

$app = require_once 'bootstrap/app.php';

$kernel = $app->make(Illuminate\Contracts\Http\Kernel::class);

// Simulate a request to test the route
try {
    echo "Testing route simulation...\n";
    
    // Get a brief with token
    $brief = \App\Models\ContentBrief::whereNotNull('public_token')->first();
    if (!$brief) {
        echo "No brief with token found\n";
        exit;
    }
    
    echo "Brief: " . $brief->title . "\n";
    echo "Token: " . $brief->public_token . "\n";
    
    // Create a simulated request
    $request = \Illuminate\Http\Request::create('/brief/' . $brief->public_token, 'GET');
    
    // Find the route
    $route = $app->router->getRoutes()->match($request);
    
    if ($route) {
        echo "SUCCESS: Route found!\n";
        echo "Route name: " . $route->getName() . "\n";
        echo "Route action: " . $route->getActionName() . "\n";
        echo "Route URI: " . $route->uri() . "\n";
    } else {
        echo "ERROR: Route not found!\n";
    }
    
    // Test if the route resolves correctly
    echo "\nTesting route resolution...\n";
    $routes = $app->router->getRoutes();
    foreach ($routes as $r) {
        if ($r->uri() === 'brief/{token}') {
            echo "Found route in collection: " . $r->getName() . "\n";
            echo "Action: " . $r->getActionName() . "\n";
            break;
        }
    }
    
    echo "\nURL should be accessible: " . $brief->publicViewUrl() . "\n";
    
} catch (Exception $e) {
    echo "Error: " . $e->getMessage() . "\n";
    echo "File: " . $e->getFile() . "\n";
    echo "Line: " . $e->getLine() . "\n";
}
