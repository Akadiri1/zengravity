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
        // 1. Update Users Table
        Schema::table('users', function (Blueprint $table) {
            if (!Schema::hasColumn('users', 'is_student')) {
                $table->boolean('is_student')->default(false)->after('email');
            }
            if (!Schema::hasColumn('users', 'credits')) {
                $table->integer('credits')->default(0)->after('is_student');
            }
        });

        // 2. Ghost Scanner Table
        if (!Schema::hasTable('scans')) {
            Schema::create('scans', function (Blueprint $table) {
                $table->id();
                $table->foreignId('user_id')->constrained()->onDelete('cascade');
                $table->string('file_path');
                $table->integer('safety_score')->default(0);
                $table->json('violations')->nullable();
                $table->text('ai_feedback')->nullable();
                $table->timestamps();
            });
        }

        // 3. Collab Forge Table
        if (!Schema::hasTable('collabs')) {
            Schema::create('collabs', function (Blueprint $table) {
                $table->id();
                $table->foreignId('user_id')->constrained()->onDelete('cascade');
                $table->string('niche');
                $table->text('bio_summary')->nullable();
                $table->binary('vibe_vector')->nullable(); // For vector embeddings
                $table->timestamps();
            });
        }

        // 4. Hive Scout Table
        if (!Schema::hasTable('hives')) {
            Schema::create('hives', function (Blueprint $table) {
                $table->id();
                $table->string('trend_name');
                $table->string('platform'); // TikTok, YouTube, etc.
                $table->float('surge_percentage')->default(0);
                $table->text('strategy_draft')->nullable();
                $table->timestamps();
            });
        }

        // 5. Exam Forge Table (Course Materials)
        if (!Schema::hasTable('course_materials')) {
            Schema::create('course_materials', function (Blueprint $table) {
                $table->id();
                $table->foreignId('user_id')->constrained()->onDelete('cascade');
                $table->string('course_name');
                $table->string('file_path');
                $table->longText('extracted_text')->nullable(); // For RAG context
                $table->boolean('is_indexed')->default(false);
                $table->timestamps();
            });
        }
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('course_materials');
        Schema::dropIfExists('hives');
        Schema::dropIfExists('collabs');
        Schema::dropIfExists('scans');

        Schema::table('users', function (Blueprint $table) {
            $table->dropColumn(['is_student', 'credits']);
        });
    }
};
