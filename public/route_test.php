<?php
echo "<h1>Simple Route Test</h1>";

// Test 1: Basic route without database
echo "<h2>Test 1: Basic Route</h2>";
echo "<p>Testing: /debug-token/test123</p>";

try {
    $request = \Illuminate\Http\Request::create('/debug-token/test123', 'GET');
    $response = $kernel->handle($request);
    echo "<p>Status: " . $response->getStatusCode() . "</p>";
    echo "<p>Content: " . $response->getContent() . "</p>";
    $kernel->terminate($request, $response);
} catch (Exception $e) {
    echo "<p>Error: " . $e->getMessage() . "</p>";
}

echo "<hr>";

// Test 2: Brief route with hardcoded token
echo "<h2>Test 2: Brief Route with Hardcoded Token</h2>";
$token = '9834f922-8ac9-4cd3-91a4-d59625c52da1';
echo "<p>Testing: /brief/" . $token . "</p>";

try {
    $request = \Illuminate\Http\Request::create('/brief/' . $token, 'GET');
    $response = $kernel->handle($request);
    echo "<p>Status: " . $response->getStatusCode() . "</p>";
    
    if ($response->getStatusCode() === 200) {
        echo "<p style='color: green;'>SUCCESS: Brief route works!</p>";
    } else {
        echo "<p style='color: red;'>FAILED: " . $response->getStatusCode() . "</p>";
        echo "<p>Content: " . substr($response->getContent(), 0, 500) . "...</p>";
    }
    
    $kernel->terminate($request, $response);
} catch (Exception $e) {
    echo "<p>Error: " . $e->getMessage() . "</p>";
}

echo "<hr>";

// Test 3: Route list check
echo "<h2>Test 3: Route Information</h2>";
echo "<p>Checking if route exists...</p>";

try {
    $routes = app('router')->getRoutes();
    $found = false;
    foreach ($routes as $route) {
        if ($route->uri() === 'brief/{token}') {
            echo "<p style='color: green;'>Route found!</p>";
            echo "<p>URI: " . $route->uri() . "</p>";
            echo "<p>Name: " . $route->getName() . "</p>";
            echo "<p>Action: " . $route->getActionName() . "</p>";
            $found = true;
            break;
        }
    }
    
    if (!$found) {
        echo "<p style='color: red;'>Route NOT found!</p>";
    }
} catch (Exception $e) {
    echo "<p>Error: " . $e->getMessage() . "</p>";
}

echo "<hr>";

// Test 4: Manual links
echo "<h2>Test 4: Manual Test Links</h2>";
echo "<p>Try opening these links in your browser:</p>";
echo "<ul>";
echo "<li><a href='/debug-token/test123' target='_blank'>Debug Route Test</a></li>";
echo "<li><a href='/brief/" . $token . "' target='_blank'>Brief Route Test</a></li>";
echo "</ul>";

echo "<h2>Current Server Info:</h2>";
echo "<p>Host: " . ($_SERVER['HTTP_HOST'] ?? 'N/A') . "</p>";
echo "<p>Port: " . ($_SERVER['SERVER_PORT'] ?? 'N/A') . "</p>";
echo "<p>Request URI: " . ($_SERVER['REQUEST_URI'] ?? 'N/A') . "</p>";
echo "<p>HTTPS: " . (isset($_SERVER['HTTPS']) && $_SERVER['HTTPS'] === 'on' ? 'YES' : 'NO') . "</p>";

// Initialize Laravel app
require_once __DIR__ . '/../vendor/autoload.php';
$app = require_once __DIR__ . '/../bootstrap/app.php';
$kernel = $app->make(Illuminate\Contracts\Http\Kernel::class);
?>
