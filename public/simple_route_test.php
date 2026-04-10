<!DOCTYPE html>
<html>
<head>
    <title>Simple Route Test</title>
    <style>
        body { font-family: Arial, sans-serif; margin: 20px; }
        .test { margin: 10px 0; padding: 10px; border: 1px solid #ccc; }
        .success { color: green; }
        .error { color: red; }
    </style>
</head>
<body>
    <h1>Simple Route Test</h1>
    
    <?php
    echo "<div class='test'>";
    echo "<h3>Current Server Info:</h3>";
    echo "<p><strong>Host:</strong> " . $_SERVER['HTTP_HOST'] . "</p>";
    echo "<p><strong>Port:</strong> " . $_SERVER['SERVER_PORT'] . "</p>";
    echo "<p><strong>Request URI:</strong> " . $_SERVER['REQUEST_URI'] . "</p>";
    echo "<p><strong>HTTPS:</strong> " . (isset($_SERVER['HTTPS']) && $_SERVER['HTTPS'] === 'on' ? 'YES' : 'NO') . "</p>";
    echo "</div>";
    
    // Test with hardcoded token
    $token = '9834f922-8ac9-4cd3-91a4-d59625c52da1';
    $url = '/brief/' . $token;
    
    echo "<div class='test'>";
    echo "<h3>Test URLs:</h3>";
    echo "<p><strong>Local Path:</strong> <a href='$url' target='_blank'>$url</a></p>";
    echo "<p><strong>Full URL:</strong> <a href='https://pageflowry.cludz.net$url' target='_blank'>https://pageflowry.cludz.net$url</a></p>";
    echo "</div>";
    
    echo "<div class='test'>";
    echo "<h3>Manual Test Instructions:</h3>";
    echo "<ol>";
    echo "<li>Click on the links above</li>";
    echo "<li>If you get 404, check the URL in browser address bar</li>";
    echo "<li>Make sure the URL matches exactly: <code>$url</code></li>";
    echo "<li>Check if web server is properly configured</li>";
    echo "</ol>";
    echo "</div>";
    
    echo "<div class='test'>";
    echo "<h3>Troubleshooting:</h3>";
    echo "<p><strong>If 404 occurs:</strong></p>";
    echo "<ul>";
    echo "<li>Check if .htaccess exists in public folder</li>";
    echo "<li>Check if mod_rewrite is enabled</li>";
    echo "<li>Check if Apache/Nginx is configured correctly</li>";
    echo "<li>Try accessing via: <code>/index.php/brief/$token</code></li>";
    echo "</ul>";
    echo "</div>";
    
    echo "<div class='test'>";
    echo "<h3>Alternative Test:</h3>";
    echo "<p><a href='/index.php/brief/$token' target='_blank'>Test with index.php in URL</a></p>";
    echo "<p><small>This bypasses URL rewriting</small></p>";
    echo "</div>";
    ?>
    
    <div class="test">
        <h3>Debug Information:</h3>
        <p><strong>Expected Token:</strong> <?php echo $token; ?></p>
        <p><strong>Expected Route:</strong> /brief/{token}</p>
        <p><strong>Expected Controller:</strong> ContentBriefController@showByToken</p>
    </div>
</body>
</html>
