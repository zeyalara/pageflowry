<?php

require_once 'vendor/autoload.php';

use Illuminate\Support\Facades\DB;

try {
    // Create brand
    DB::table('brands')->insert([
        'name' => 'Test Brand',
        'created_at' => now(),
        'updated_at' => now()
    ]);
    $brandId = DB::getPdo()->lastInsertId();

    // Create user
    DB::table('users')->insert([
        'name' => 'Test User',
        'email' => 'test@example.com',
        'password' => bcrypt('password'),
        'created_at' => now(),
        'updated_at' => now()
    ]);
    $userId = DB::getPdo()->lastInsertId();

    // Create content task
    DB::table('content_tasks')->insert([
        'judul_konten' => 'Test Content 1',
        'deskripsi' => 'Test description',
        'brand_id' => $brandId,
        'creator_id' => $userId,
        'status' => 'completed',
        'deadline' => now()->addDays(7),
        'created_at' => now(),
        'updated_at' => now()
    ]);
    $taskId = DB::getPdo()->lastInsertId();

    // Create production
    DB::table('productions')->insert([
        'content_task_id' => $taskId,
        'judul_konten' => 'Test Video 1',
        'versi_video' => 'v1.0',
        'durasi_final' => '2:30',
        'catatan_produksi' => 'Test notes 1',
        'file_video' => 'test1.mp4',
        'status' => 'production',
        'created_at' => now(),
        'updated_at' => now()
    ]);

    echo "Test data created successfully!\n";
    echo "Brand ID: $brandId\n";
    echo "User ID: $userId\n";
    echo "Task ID: $taskId\n";

} catch (Exception $e) {
    echo "Error: " . $e->getMessage() . "\n";
}
