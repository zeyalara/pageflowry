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
        Schema::table('content_briefs', function (Blueprint $table) {
            // Add missing columns
            $table->text('description')->nullable()->after('title'); // fDesc - Deskripsi Tugas Konten
            $table->string('creator_email')->nullable()->after('status'); // fCreator - Email Content Creator
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('content_briefs', function (Blueprint $table) {
            // Remove columns
            $table->dropColumn(['description', 'creator_email']);
        });
    }
};
