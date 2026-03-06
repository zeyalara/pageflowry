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
        Schema::create('content_briefs', function (Blueprint $table) {
            $table->id();
            $table->string('title');
            $table->foreignId('brand_id')->constrained()->onDelete('cascade');
            $table->foreignId('creator_id')->nullable()->constrained('users')->onDelete('set null');
            $table->string('platform');
            $table->string('content_format');
            $table->string('target_duration');
            $table->date('production_deadline');
            $table->date('publish_deadline');
            $table->text('objective');
            $table->text('target_audience');
            $table->text('key_message');
            $table->text('hook');
            $table->text('storyline');
            $table->text('visual_direction');
            $table->text('caption');
            $table->text('cta');
            $table->text('hashtags');
            $table->string('target_views');
            $table->string('target_engagement');
            $table->string('status')->default('In Production');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('content_briefs');
    }
};
