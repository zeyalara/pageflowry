<!DOCTYPE html>
<html>
<head>
    <title>Test Brief Access</title>
    <style>
        body { font-family: Arial, sans-serif; margin: 20px; }
        .test-item { margin: 10px 0; padding: 10px; border: 1px solid #ccc; }
        .success { color: green; }
        .error { color: red; }
        .info { color: blue; }
    </style>
</head>
<body>
    <h1>Test Brief Access</h1>
    
    <?php
    // Initialize Laravel
    require_once __DIR__ . '/../vendor/autoload.php';
    $app = require_once __DIR__ . '/../bootstrap/app.php';
    $kernel = $app->make(Illuminate\Contracts\Http\Kernel::Class);
    
    echo "<div class='info'>Laravel initialized</div>";
    
    // Get token from database
    try {
        $brief = \App\Models\ContentBrief::whereNotNull('public_token')->first();
        if ($brief) {
            $token = $brief->public_token;
            $url = '/brief/' . $token;
            
            echo "<div class='test-item'>";
            echo "<h3>Brief Found:</h3>";
            echo "<p><strong>ID:</strong> " . $brief->id . "</p>";
            echo "<p><strong>Title:</strong> " . $brief->title . "</p>";
            echo "<p><strong>Token:</strong> " . $token . "</p>";
            echo "</div>";
            
            echo "<div class='test-item'>";
            echo "<h3>Test Links:</h3>";
            echo "<p><a href='$url' target='_blank' class='success'>Test: $url</a></p>";
            echo "<p><small>Click the link above to test the route</small></p>";
            echo "</div>";
            
            // Test the route programmatically
            echo "<div class='test-item'>";
            echo "<h3>Programmatic Test:</h3>";
            
            try {
                $request = \Illuminate\Http\Request::create($url, 'GET');
                $response = $kernel->handle($request);
                
                echo "<p><strong>Status:</strong> " . $response->getStatusCode() . "</p>";
                
                if ($response->getStatusCode() === 200) {
                    echo "<p class='success'>SUCCESS: Route works!</p>";
                } else {
                    echo "<p class='error'>FAILED: " . $response->getStatusCode() . "</p>";
                }
                
                $kernel->terminate($request, $response);
                
            } catch (Exception $e) {
                echo "<p class='error'>Exception: " . $e->getMessage() . "</p>";
            }
            
            echo "</div>";
            
            // Check route exists
            echo "<div class='test-item'>";
            echo "<h3>Route Check:</h3>";
            echo "<p><strong>Route exists:</strong> " . (\Illuminate\Support\Facades\Route::has('brief.public') ? 'YES' : 'NO') . "</p>";
            echo "<p><strong>Controller method:</strong> " . (method_exists(new \App\Http\Controllers\ContentBriefController(), 'showByToken') ? 'YES' : 'NO') . "</p>";
            echo "<p><strong>View exists:</strong> " . (view()->exists('public.brief') ? 'YES' : 'NO') . "</p>";
            echo "</div>";
            
        } else {
            echo "<div class='error'>No brief with token found</div>";
        }
    } catch (Exception $e) {
        echo "<div class='error'>Database error: " . $e->getMessage() . "</div>";
    }
    ?>
    
    <div class="test-item">
        <h3>Server Information:</h3>
        <p><strong>Current URL:</strong> <?php echo "http://" . $_SERVER['HTTP_HOST'] . $_SERVER['REQUEST_URI']; ?></p>
        <p><strong>Base URL:</strong> <?php echo config('app.url'); ?></p>
    </div>
    
    <div class="test-item">
        <h3>Manual Test:</h3>
        <p>Copy this URL and test in browser:</p>
        <p><code><?php 
            if (isset($token)) {
                echo config('app.url') . '/brief/' . $token;
            } else {
                echo 'No token available';
            }
        ?></code></p>
    </div>
</body>
</html>
