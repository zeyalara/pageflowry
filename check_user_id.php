<?php

require_once 'vendor/autoload.php';

$app = require_once 'bootstrap/app.php';

$kernel = $app->make(Illuminate\Contracts\Http\Kernel::class);

$request = Illuminate\Http\Request::capture();

$response = $kernel->handle($request);

// Check which tables have user_id column
try {
    echo "Checking user_id columns in tables...\n";
    
    $tables = ['content_briefs', 'content_tasks', 'productions', 'brands'];
    
    foreach ($tables as $table) {
        $columns = Illuminate\Support\Facades\Schema::getColumnListing($table);
        $hasUserId = in_array('user_id', $columns);
        echo $table . ': ' . ($hasUserId ? 'HAS user_id' : 'MISSING user_id') . "\n";
        
        if (!$hasUserId) {
            echo "  Columns in " . $table . ": " . implode(', ', $columns) . "\n";
        }
    }
    
} catch (Exception $e) {
    echo "Error: " . $e->getMessage() . "\n";
}
