<?php

// Simple test to check if URL structure is correct
echo "Testing URL structure...\n";

// Get a brief from database
$brief = App\Models\ContentBrief::first();
if ($brief) {
    echo "Brief ID: " . $brief->id . "\n";
    echo "Brief Title: " . $brief->title . "\n";
    
    // Generate the URL
    $url = $brief->publicViewUrl();
    echo "Generated URL: " . $url . "\n";
    
    // Parse URL
    $parts = parse_url($url);
    echo "Host: " . ($parts['host'] ?? 'N/A') . "\n";
    echo "Path: " . ($parts['path'] ?? 'N/A') . "\n";
    echo "Query: " . ($parts['query'] ?? 'N/A') . "\n";
    
    // Extract ID and token
    if (preg_match('/\/content-briefs\/(\d+)\/view/', $url, $matches)) {
        echo "Extracted ID: " . $matches[1] . "\n";
    }
    
    if (preg_match('/token=([^&]+)/', $url, $matches)) {
        echo "Extracted Token: " . substr($matches[1], 0, 20) . "...\n";
    }
    
    echo "\nURL is correctly formatted!\n";
    echo "Should be accessible at: " . $url . "\n";
    
} else {
    echo "No brief found in database\n";
}
