<?php

require_once 'vendor/autoload.php';

use App\Models\ContentTask;
use App\Models\Brand;
use Illuminate\Support\Facades\DB;

// Bootstrap Laravel
$app = require_once 'bootstrap/app.php';
$kernel = $app->make(Illuminate\Contracts\Console\Kernel::class);
$kernel->bootstrap();

echo "Creating dummy data for testing...\n";

// Create or get a brand
$brand = Brand::firstOrCreate(
    ['name' => 'Test Brand'],
    ['name' => 'Test Brand']
);

// Create dummy content tasks with status in_production
for ($i = 1; $i <= 5; $i++) {
    ContentTask::firstOrCreate(
        ['judul_konten' => "Test Content Task $i"],
        [
            'judul_konten' => "Test Content Task $i",
            'deskripsi' => "Description for test content task $i",
            'brand_id' => $brand->id,
            'creator_id' => 1, // Assuming user ID 1 exists
            'status' => 'in_production',
            'deadline' => now()->addDays(7),
        ]
    );
}

echo "Created 5 dummy content tasks with status 'in_production'\n";

// Check the results
$tasks = ContentTask::where('status', 'in_production')->get();
echo "Total tasks with status 'in_production': " . $tasks->count() . "\n";

foreach ($tasks as $task) {
    echo "ID: {$task->id}, Title: {$task->judul_konten}, Status: {$task->status}\n";
}
