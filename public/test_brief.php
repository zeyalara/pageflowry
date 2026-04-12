<?php

// Simple test to access the brief route directly
require_once __DIR__ . '/../vendor/autoload.php';

$app = require_once __DIR__ . '/../bootstrap/app.php';

$kernel = $app->make(Illuminate\Contracts\Http\Kernel::class);

// Test with a real token
$token = '9834f922-8ac9-4cd3-91a4-d59625c52da1'; // From database

echo "Testing direct access to brief route...\n";
echo "Token: " . $token . "\n";
echo "URL: /brief/" . $token . "\n";

try {
    // Create request
    $request = Illuminate\Http\Request::create('/brief/' . $token, 'GET');
    
    // Handle request
    $response = $kernel->handle($request);
    
    echo "Response Status: " . $response->getStatusCode() . "\n";
    
    if ($response->getStatusCode() === 200) {
        echo "SUCCESS: Route returned 200 OK\n";
        echo "Content Type: " . $response->headers->get('Content-Type') . "\n";
    } elseif ($response->getStatusCode() === 404) {
        echo "ERROR: Route returned 404 Not Found\n";
    } else {
        echo "Response Status: " . $response->getStatusCode() . "\n";
    }
    
} catch (Exception $e) {
    echo "Exception: " . $e->getMessage() . "\n";
    echo "File: " . $e->getFile() . "\n";
    echo "Line: " . $e->getLine() . "\n";
}
