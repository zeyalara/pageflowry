<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    use WithoutModelEvents;

    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // User::factory(10)->create();

        // Create admin user
        User::factory()->create([
            'name' => 'Admin User',
            'email' => 'admin@pageflowry.com',
            'role' => 'admin',
        ]);

        // Create test creator user
        User::factory()->create([
            'name' => 'Test User',
            'email' => 'creator@pageflowry.com',
            'role' => 'creator',
        ]);
    }
}
