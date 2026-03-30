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
            
            // Informasi Dasar - Step 2
            $table->string('title'); // fTitle - Judul Konten
            $table->text('description')->nullable(); // fDesc - Deskripsi Tugas Konten
            $table->foreignId('brand_id')->constrained()->onDelete('cascade'); // fBrand - Foreign Key ke brands
            $table->string('platform'); // fPlatform - Platform
            $table->string('content_format'); // fFormat - Format Konten
            $table->string('target_duration'); // fDuration - Durasi Target
            $table->date('production_deadline'); // fDeadProd - Deadline Produksi
            $table->date('publish_deadline'); // fDeadPub - Deadline Publish
            
            // Strategi Konten - Step 3
            $table->text('objective'); // fObjective - Objective
            $table->text('target_audience'); // fAudience - Target Audience
            $table->text('key_message'); // fKeyMsg - Key Message
            
            // Brief Kreatif - Step 4
            $table->text('hook'); // fHook - Hook
            $table->text('storyline'); // fStory - Storyline
            $table->text('visual_direction'); // fVisual - Visual Direction
            
            // Konten & Publishing - Step 5
            $table->text('caption'); // fCaption - Caption
            $table->text('cta'); // fCta - Call to Action
            $table->text('hashtags'); // fHashtag - Hashtag
            
            // Target KPI - Step 6
            $table->string('target_views'); // fViews - Target Views
            $table->string('target_engagement'); // fEngage - Target Engagement Rate
            
            // Assign & Summary - Step 7
            $table->string('creator_email')->nullable(); // fCreator - Email Content Creator
            
            // System Fields
            $table->foreignId('creator_id')->nullable()->constrained('users')->onDelete('set null'); // User yang membuat
            $table->string('status')->default('In Production'); // Status default
            $table->timestamps(); // created_at, updated_at
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
