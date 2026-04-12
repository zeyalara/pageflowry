<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::table('productions', function (Blueprint $table) {
            $table->dropColumn('status');
        });
        
        Schema::table('productions', function (Blueprint $table) {
            $table->enum('status', ['pending', 'under_review', 'approved', 'revision', 'rejected', 'ready_to_publish', 'published'])->default('pending')->after('file_video');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('productions', function (Blueprint $table) {
            $table->dropColumn('status');
        });
        
        Schema::table('productions', function (Blueprint $table) {
            $table->enum('status', ['production', 'in_review', 'need_revision', 'ready_to_publish', 'published'])->default('production');
        });
    }
};
