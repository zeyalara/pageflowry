<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    public function up(): void
    {
        // Infer brand owner from related content_briefs / content_tasks (only where brands.user_id is null).
        DB::statement("
            UPDATE brands b
            JOIN (
                SELECT brand_id, MAX(user_id) AS user_id
                FROM content_briefs
                WHERE user_id IS NOT NULL
                GROUP BY brand_id
            ) cb ON cb.brand_id = b.id
            SET b.user_id = cb.user_id
            WHERE b.user_id IS NULL
        ");

        DB::statement("
            UPDATE brands b
            JOIN (
                SELECT brand_id, MAX(user_id) AS user_id
                FROM content_tasks
                WHERE user_id IS NOT NULL
                GROUP BY brand_id
            ) ct ON ct.brand_id = b.id
            SET b.user_id = ct.user_id
            WHERE b.user_id IS NULL
        ");
    }

    public function down(): void
    {
        // No safe rollback for data backfill.
    }
};

