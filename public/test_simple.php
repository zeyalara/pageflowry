<!DOCTYPE html>
<html>
<head>
    <title>Test Token Access</title>
</head>
<body>
    <h1>Test Token Access</h1>
    
    <?php
    // Get token from database
    require_once __DIR__ . '/../vendor/autoload.php';
    $app = require_once __DIR__ . '/../bootstrap/app.php';
    
    try {
        $brief = \App\Models\ContentBrief::whereNotNull('public_token')->first();
        if ($brief) {
            $token = $brief->public_token;
            $url = '/brief/' . $token;
            $fullUrl = 'https://pageflowry.cludz.net' . $url;
            
            echo "<h2>Brief Found:</h2>";
            echo "<p><strong>ID:</strong> " . $brief->id . "</p>";
            echo "<p><strong>Title:</strong> " . $brief->title . "</p>";
            echo "<p><strong>Token:</strong> " . $token . "</p>";
            
            echo "<h2>Test Links:</h2>";
            echo "<p><a href='$url' target='_blank'>Test Local: $url</a></p>";
            echo "<p><a href='$fullUrl' target='_blank'>Test Production: $fullUrl</a></p>";
            
            echo "<h2>Debug Info:</h2>";
            echo "<p>Current Host: " . $_SERVER['HTTP_HOST'] . "</p>";
            echo "<p>Request URI: " . $_SERVER['REQUEST_URI'] . "</p>";
            echo "<p>HTTPS: " . (isset($_SERVER['HTTPS']) && $_SERVER['HTTPS'] === 'on' ? 'YES' : 'NO') . "</p>";
            
        } else {
            echo "<p>No brief with token found</p>";
        }
    } catch (Exception $e) {
        echo "<p>Error: " . $e->getMessage() . "</p>";
    }
    ?>
    
    <hr>
    <h2>Manual Test:</h2>
    <form method="get" action="/brief/test-token">
        <input type="text" name="share_token" placeholder="Enter share_token" size="40">
        <button type="submit">Test Route</button>
    </form>
    
    <h2>Route List:</h2>
    <a href="/routes" target="_blank">View All Routes</a>
</body>
</html>
