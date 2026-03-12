<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Models\ContentTask;
use App\Models\Brand;

class AddSampleContentTasks extends Command
{
    protected $signature = 'add:sample-tasks';
    protected $description = 'Add sample content tasks for testing';

    public function handle()
    {
        // Get first brand or create one
        $brand = Brand::first();
        if (!$brand) {
            $brand = Brand::create([
                'name' => 'Test Brand',
                'description' => 'Test Brand Description'
            ]);
        }

        // Create sample tasks
        $tasks = [
            [
                'judul_konten' => 'Tutorial Makeup Natural',
                'deskripsi' => 'Tutorial makeup natural untuk pemula',
                'brand_id' => $brand->id,
                'creator_id' => 1,
                'status' => 'task',
                'deadline' => now()->addDays(7)
            ],
            [
                'judul_konten' => 'Review Skincare Terbaru',
                'deskripsi' => 'Review produk skincare terbaru 2024',
                'brand_id' => $brand->id,
                'creator_id' => 1,
                'status' => 'in_production',
                'deadline' => now()->addDays(3)
            ],
            [
                'judul_konten' => 'Tips Fashion Hijab',
                'deskripsi' => 'Tips fashion hijab modern',
                'brand_id' => $brand->id,
                'creator_id' => 1,
                'status' => 'task',
                'deadline' => now()->addDays(10)
            ]
        ];

        foreach ($tasks as $taskData) {
            ContentTask::create($taskData);
            $this->info("Created task: {$taskData['judul_konten']}");
        }

        $this->info("Sample content tasks created successfully!");
        return Command::SUCCESS;
    }
}
