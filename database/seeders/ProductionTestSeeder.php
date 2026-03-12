<?php

use Illuminate\Database\Seeder;
use App\Models\ContentTask;
use App\Models\Brand;

class ProductionTestSeeder extends Seeder
{
    public function run()
    {
        // Create or get a brand
        $brand = Brand::firstOrCreate(
            ['name' => 'Test Brand'],
            ['name' => 'Test Brand']
        );

        // Create dummy content tasks with status in_production
        for ($i = 1; $i <= 3; $i++) {
            ContentTask::firstOrCreate(
                ['judul_konten' => "Test Content Task $i"],
                [
                    'judul_konten' => "Test Content Task $i",
                    'deskripsi' => "Description for test content task $i",
                    'brand_id' => $brand->id,
                    'creator_id' => 1,
                    'status' => 'in_production',
                    'deadline' => now()->addDays(7),
                ]
            );
        }

        $this->command->info('Created 3 dummy content tasks with status in_production');
    }
}
