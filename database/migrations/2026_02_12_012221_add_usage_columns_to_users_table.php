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
        Schema::table('users', function (Blueprint $table) {
            $table->integer('scans_used')->default(0);
            $table->integer('matches_used')->default(0);
            $table->integer('hives_used')->default(0);
            $table->timestamp('usage_reset_at')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('users', function (Blueprint $table) {
            $table->dropColumn(['scans_used', 'matches_used', 'hives_used', 'usage_reset_at']);
        });
    }
};
