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
        // 1. GHOST SCANNER: Storage for safety checks
        Schema::create('scans', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained()->onDelete('cascade');
            $table->string('file_path');
            $table->integer('safety_score')->nullable(); // We will mock this for now
            $table->json('violations')->nullable();
            $table->timestamps();
        });

        // 2. COLLAB FORGE: Storage for influencer matching
        Schema::create('collabs', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained();
            $table->string('niche');
            $table->text('bio_summary');
            // Check if vector type is supported, otherwise fallback to json/text
            // $table->vector('vibe_vector', 1536)->nullable(); // For future AI matching
            // MySQL 8.0/MariaDB doesn't support vector type natively in default Laravel blueprint yet without extensions.
            // Using TEXT/JSON for now to avoid errors on standard MySQL.
            $table->text('vibe_vector')->nullable(); 
            $table->timestamps();
        });

        // 3. HIVE SCOUT: Storage for niche trends
        Schema::create('hives', function (Blueprint $table) {
            $table->id();
            $table->string('trend_name');
            $table->string('platform'); // TikTok, IG, etc.
            $table->integer('engagement_surge');
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('hives');
        Schema::dropIfExists('collabs');
        Schema::dropIfExists('scans');
    }
};
