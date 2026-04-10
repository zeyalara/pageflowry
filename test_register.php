<?php

require_once 'vendor/autoload.php';

$app = require_once 'bootstrap/app.php';

$kernel = $app->make(Illuminate\Contracts\Http\Kernel::class);

$request = Illuminate\Http\Request::capture();

$response = $kernel->handle($request);

// Test registration process
try {
    echo "Testing registration process...\n";
    
    // Check if users table exists and structure
    $columns = Illuminate\Support\Facades\Schema::getColumnListing('users');
    echo "Users table columns: " . implode(', ', $columns) . "\n";
    
    // Test user creation
    $userData = [
        'name' => 'Test User',
        'email' => 'test' . time() . '@example.com',
        'password' => Illuminate\Support\Facades\Hash::make('password123'),
        'role' => 'admin',
    ];
    
    echo "Attempting to create user...\n";
    $user = App\Models\User::create($userData);
    echo "User created successfully! ID: " . $user->id . "\n";
    
} catch (Exception $e) {
    echo "Error: " . $e->getMessage() . "\n";
    echo "File: " . $e->getFile() . " Line: " . $e->getLine() . "\n";
}
