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
            $table->dropColumn(['scans_used', 'matches_used', 'hives_used', 'usage_reset_at']);
            $table->timestamp('trial_ends_at')->nullable();
            $table->integer('daily_tokens_remaining')->default(15);
            $table->timestamp('last_token_reset_at')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('users', function (Blueprint $table) {
            $table->dropColumn(['trial_ends_at', 'daily_tokens_remaining', 'last_token_reset_at']);
            $table->integer('scans_used')->default(0);
            $table->integer('matches_used')->default(0);
            $table->integer('hives_used')->default(0);
            $table->timestamp('usage_reset_at')->nullable();
        });
    }
};
