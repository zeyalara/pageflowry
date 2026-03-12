<?php

require_once 'vendor/autoload.php';

use App\Models\ContentTask;
use Illuminate\Support\Facades\DB;

// Bootstrap Laravel
$app = require_once 'bootstrap/app.php';
$kernel = $app->make(Illuminate\Contracts\Console\Kernel::class);
$kernel->bootstrap();

// Check all content tasks
echo "=== ALL CONTENT TASKS ===\n";
$allTasks = ContentTask::all();
echo "Total tasks: " . $allTasks->count() . "\n";

foreach ($allTasks as $task) {
    echo "ID: {$task->id}, Title: {$task->judul_konten}, Status: {$task->status}\n";
}

echo "\n=== TASKS WITH STATUS IN_PRODUCTION ===\n";
$inProductionTasks = ContentTask::where('status', 'in_production')->get();
echo "Total in_production tasks: " . $inProductionTasks->count() . "\n";

foreach ($inProductionTasks as $task) {
    echo "ID: {$task->id}, Title: {$task->judul_konten}, Status: {$task->status}\n";
}

echo "\n=== ALL DISTINCT STATUSES ===\n";
$distinctStatuses = ContentTask::distinct()->pluck('status');
foreach ($distinctStatuses as $status) {
    $count = ContentTask::where('status', $status)->count();
    echo "Status: {$status}, Count: {$count}\n";
}
