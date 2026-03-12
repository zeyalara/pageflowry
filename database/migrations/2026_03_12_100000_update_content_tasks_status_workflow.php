<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    /**
     * Run the migrations.
     * Workflow: draft → in_production → ready_for_revision → ready_for_approval → ready_to_publish → published
     */
    public function up(): void
    {
        // Change enum to string for flexibility with workflow statuses
        DB::statement("ALTER TABLE content_tasks MODIFY COLUMN status VARCHAR(50) NOT NULL DEFAULT 'draft'");
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        DB::statement("ALTER TABLE content_tasks MODIFY COLUMN status ENUM('draft', 'in_progress', 'completed', 'cancelled') NOT NULL DEFAULT 'draft'");
    }
};
