<?php

// Simulate web server access with proper headers
require_once __DIR__ . '/../vendor/autoload.php';

$app = require_once __DIR__ . '/../bootstrap/app.php';

$kernel = $app->make(Illuminate\Contracts\Http\Kernel::class);

// Test with proper web server headers
$token = '9834f922-8ac9-4cd3-91a4-d59625c52da1';

echo "Testing web server access simulation...\n";
echo "Token: " . $token . "\n";
echo "URL: /brief/" . $token . "\n";
echo "Host: pageflowry.cludz.net\n\n";

try {
    // Create request with proper headers
    $request = Illuminate\Http\Request::create('/brief/' . $token, 'GET', [], [], [], [
        'HTTP_HOST' => 'pageflowry.cludz.net',
        'HTTP_USER_AGENT' => 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36',
        'HTTP_ACCEPT' => 'text/html,application/xhtml+xml,application/xml;q=0.9,*/*;q=0.8',
        'SERVER_NAME' => 'pageflowry.cludz.net',
        'SERVER_PORT' => '443',
        'HTTPS' => 'on',
        'REQUEST_SCHEME' => 'https',
    ]);
    
    echo "Request created with headers:\n";
    echo "- Host: " . $request->getHost() . "\n";
    echo "- Scheme: " . $request->getScheme() . "\n";
    echo "- Secure: " . ($request->isSecure() ? 'YES' : 'NO') . "\n";
    echo "- Method: " . $request->method() . "\n";
    echo "- URI: " . $request->getRequestUri() . "\n\n";
    
    // Handle request
    $response = $kernel->handle($request);
    
    echo "Response Status: " . $response->getStatusCode() . "\n";
    echo "Content Type: " . $response->headers->get('Content-Type') . "\n";
    echo "Content Length: " . strlen($response->getContent()) . " bytes\n";
    
    if ($response->getStatusCode() === 200) {
        echo "\nSUCCESS: Route returned 200 OK\n";
        echo "First 200 chars of content:\n";
        echo substr($response->getContent(), 0, 200) . "...\n";
    } elseif ($response->getStatusCode() === 404) {
        echo "\nERROR: Route returned 404 Not Found\n";
        echo "Response content:\n";
        echo $response->getContent() . "\n";
    } else {
        echo "\nOther status: " . $response->getStatusCode() . "\n";
        echo "Response content:\n";
        echo $response->getContent() . "\n";
    }
    
    $kernel->terminate($request, $response);
    
} catch (Exception $e) {
    echo "Exception: " . $e->getMessage() . "\n";
    echo "File: " . $e->getFile() . "\n";
    echo "Line: " . $e->getLine() . "\n";
    echo "Trace:\n" . $e->getTraceAsString() . "\n";
}
