<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

class ProductionSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Get admin user (assuming user with id 1 exists)
        $adminId = 1;

        // Create sample brands
        $brands = [
            [
                'name' => 'GlowSkin',
                'pic' => 'glowskin.png',
                'contact' => 'contact@glowskin.com',
                'target_market' => 'Skincare products for glowing skin',
                'tone' => '#5897fe',
                'status' => 'Active',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'name' => 'BeautyHaus',
                'pic' => 'beautyhaus.png',
                'contact' => 'contact@beautyhaus.com',
                'target_market' => 'Premium beauty products',
                'tone' => '#8b5cf6',
                'status' => 'Active',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'name' => 'StyleCo',
                'pic' => 'styleco.png',
                'contact' => 'contact@styleco.com',
                'target_market' => 'Fashion and lifestyle brand',
                'tone' => '#f59e0b',
                'status' => 'Active',
                'created_at' => now(),
                'updated_at' => now(),
            ],
        ];

        DB::table('brands')->insert($brands);

        // Get brand IDs
        $brandIds = DB::table('brands')->pluck('id');

        // Create sample content tasks
        $contentTasks = [];
        foreach ($brandIds as $index => $brandId) {
            $contentTasks[] = [
                'judul_konten' => 'Tutorial Skincare Pagi',
                'deskripsi' => 'Tutorial lengkap perawatan kulit pagi hari',
                'brand_id' => $brandId,
                'creator_id' => $adminId,
                'status' => 'completed',
                'deadline' => now()->addDays(7),
                'created_at' => now(),
                'updated_at' => now(),
            ];
            
            if ($index === 1) {
                $contentTasks[] = [
                    'judul_konten' => 'Review Produk Q1',
                    'deskripsi' => 'Review produk terbaik Q1 2026',
                    'brand_id' => $brandId,
                    'creator_id' => $adminId,
                    'status' => 'completed',
                    'deadline' => now()->addDays(5),
                    'created_at' => now(),
                    'updated_at' => now(),
                ];
            }
            
            if ($index === 2) {
                $contentTasks[] = [
                    'judul_konten' => 'Unboxing Summer',
                    'deskripsi' => 'Unboxing produk summer collection',
                    'brand_id' => $brandId,
                    'creator_id' => $adminId,
                    'status' => 'completed',
                    'deadline' => now()->addDays(10),
                    'created_at' => now(),
                    'updated_at' => now(),
                ];
            }
        }

        DB::table('content_tasks')->insert($contentTasks);

        // Get content task IDs
        $contentTaskIds = DB::table('content_tasks')->pluck('id');

        // Create sample productions
        $productions = [];
        $statuses = ['In Production', 'Under Review', 'Need Revision', 'Ready to Publish', 'Published'];
        
        foreach ($contentTaskIds as $index => $taskId) {
            $task = DB::table('content_tasks')->find($taskId);
            $productions[] = [
                'content_task_id' => $taskId,
                'video_version' => 'v' . ($index + 1) . '.0',
                'final_duration' => rand(60, 300) . ' seconds', // 1-5 minutes
                'video_file_path' => 'video_' . ($index + 1) . '.mp4',
                'production_notes' => 'Catatan produksi untuk video ' . ($index + 1),
                'status' => $statuses[$index % count($statuses)],
                'created_at' => now(),
                'updated_at' => now(),
            ];
        }

        DB::table('productions')->insert($productions);
    }
}
