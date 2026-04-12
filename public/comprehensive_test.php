<?php
require_once __DIR__ . '/../vendor/autoload.php';
$app = require_once __DIR__ . '/../bootstrap/app.php';
$kernel = $app->make(Illuminate\Contracts\Http\Kernel::class);

echo "<h1>Comprehensive Route Test</h1>";

// Get token from database
$brief = \App\Models\ContentBrief::whereNotNull('public_token')->first();
if (!$brief) {
    echo "<p>No brief with token found</p>";
    exit;
}

$token = $brief->public_token;
$baseUrl = config('app.url');

echo "<h2>Token Information:</h2>";
echo "<p><strong>Brief ID:</strong> " . $brief->id . "</p>";
echo "<p><strong>Title:</strong> " . $brief->title . "</p>";
echo "<p><strong>Token:</strong> " . $token . "</p>";
echo "<p><strong>Base URL:</strong> " . $baseUrl . "</p>";

echo "<h2>URL Variations to Test:</h2>";

$urls = [
    '/brief/' . $token,
    $baseUrl . '/brief/' . $token,
    'https://pageflowry.cludz.net/brief/' . $token,
    'http://localhost/pageflowry/public/brief/' . $token,
    '/pageflowry/public/brief/' . $token,
];

foreach ($urls as $url) {
    echo "<h3>Testing: " . $url . "</h3>";
    
    try {
        // Parse URL to get path
        $parsed = parse_url($url);
        $path = $parsed['path'] ?? $url;
        
        // Create request
        $request = \Illuminate\Http\Request::create($path, 'GET');
        
        // Handle request
        $response = $kernel->handle($request);
        
        echo "<p><strong>Status:</strong> " . $response->getStatusCode() . "</p>";
        echo "<p><strong>Content Type:</strong> " . $response->headers->get('Content-Type') . "</p>";
        
        if ($response->getStatusCode() === 200) {
            echo "<p style='color: green;'>SUCCESS: Route works!</p>";
            echo "<a href='" . $url . "' target='_blank'>Open in Browser</a>";
        } elseif ($response->getStatusCode() === 404) {
            echo "<p style='color: red;'>ERROR: 404 Not Found</p>";
        } else {
            echo "<p style='color: orange;'>Other Status: " . $response->getStatusCode() . "</p>";
        }
        
        $kernel->terminate($request, $response);
        
    } catch (Exception $e) {
        echo "<p style='color: red;'>Exception: " . $e->getMessage() . "</p>";
    }
    
    echo "<hr>";
}

echo "<h2>Server Information:</h2>";
echo "<p><strong>Current Host:</strong> " . ($_SERVER['HTTP_HOST'] ?? 'N/A') . "</p>";
echo "<p><strong>Request URI:</strong> " . ($_SERVER['REQUEST_URI'] ?? 'N/A') . "</p>";
echo "<p><strong>HTTPS:</strong> " . (isset($_SERVER['HTTPS']) && $_SERVER['HTTPS'] === 'on' ? 'YES' : 'NO') . "</p>";
echo "<p><strong>Server Port:</strong> " . ($_SERVER['SERVER_PORT'] ?? 'N/A') . "</p>";

echo "<h2>Manual Test Links:</h2>";
echo "<p><a href='/brief/" . $token . "' target='_blank'>Test Local Path</a></p>";
echo "<p><a href='" . $baseUrl . "/brief/" . $token . "' target='_blank'>Test Base URL</a></p>";

echo "<h2>Debug Information:</h2>";
echo "<p><strong>Route exists:</strong> " . (\Illuminate\Support\Facades\Route::has('brief.public') ? 'YES' : 'NO') . "</p>";
echo "<p><strong>Controller method exists:</strong> " . (method_exists(new \App\Http\Controllers\ContentBriefController(), 'showByToken') ? 'YES' : 'NO') . "</p>";
echo "<p><strong>View exists:</strong> " . (view()->exists('public.brief') ? 'YES' : 'NO') . "</p>";
?>
