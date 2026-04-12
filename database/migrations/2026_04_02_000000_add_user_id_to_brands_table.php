<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::table('brands', function (Blueprint $table) {
            $table->foreignId('user_id')->nullable()->after('id')->constrained('users')->onDelete('cascade');
        });

        // Backfill: infer brand owner from related content_briefs / content_tasks
        // (only for brands that don't have user_id yet).
        DB::statement("
            UPDATE brands b
            JOIN (
                SELECT brand_id, MAX(creator_id) AS creator_id
                FROM content_briefs
                WHERE creator_id IS NOT NULL
                GROUP BY brand_id
            ) cb ON cb.brand_id = b.id
            SET b.user_id = cb.creator_id
            WHERE b.user_id IS NULL
        ");

        DB::statement("
            UPDATE brands b
            JOIN (
                SELECT brand_id, MAX(creator_id) AS creator_id
                FROM content_tasks
                WHERE creator_id IS NOT NULL
                GROUP BY brand_id
            ) ct ON ct.brand_id = b.id
            SET b.user_id = ct.creator_id
            WHERE b.user_id IS NULL
        ");
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('brands', function (Blueprint $table) {
            $table->dropForeign(['user_id']);
            $table->dropColumn('user_id');
        });
    }
};
