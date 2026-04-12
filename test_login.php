<?php

require_once 'vendor/autoload.php';

$app = require_once 'bootstrap/app.php';

$kernel = $app->make(Illuminate\Contracts\Http\Kernel::class);

$request = Illuminate\Http\Request::capture();

$response = $kernel->handle($request);

// Test user authentication
try {
    $user = App\Models\User::first();
    if ($user) {
        echo "User found: " . $user->email . "\n";
        
        // Test password hash
        if (Illuminate\Support\Facades\Hash::check('password', $user->password)) {
            echo "Password check: VALID\n";
        } else {
            echo "Password check: INVALID\n";
        }
        
        // Test authentication
        $credentials = ['email' => $user->email, 'password' => 'password'];
        if (Illuminate\Support\Facades\Auth::attempt($credentials)) {
            echo "Authentication: SUCCESS\n";
        } else {
            echo "Authentication: FAILED\n";
        }
    } else {
        echo "No users found in database\n";
    }
} catch (Exception $e) {
    echo "Error: " . $e->getMessage() . "\n";
}
