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
        Schema::table('scans', function (Blueprint $table) {
            $table->index('created_at');
        });

        Schema::table('collabs', function (Blueprint $table) {
            $table->index('niche');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('scans', function (Blueprint $table) {
            $table->dropIndex(['created_at']);
        });

        Schema::table('collabs', function (Blueprint $table) {
            $table->dropIndex(['niche']);
        });
    }
};
