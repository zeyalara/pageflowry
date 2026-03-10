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
        Schema::create('productions', function (Blueprint $table) {
            $table->id();
            $table->foreignId('content_task_id')->constrained('content_tasks')->onDelete('cascade');
            $table->string('judul_konten');
            $table->string('versi_video')->default('v1.0');
            $table->string('durasi_final')->nullable();
            $table->text('catatan_produksi')->nullable();
            $table->string('file_video')->nullable();
            $table->string('thumbnail')->nullable();
            $table->enum('status', ['production', 'in_review', 'need_revision', 'ready_to_publish', 'published'])->default('production');
            $table->foreignId('creator_id')->nullable()->constrained('users')->onDelete('set null');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('productions');
    }
};
