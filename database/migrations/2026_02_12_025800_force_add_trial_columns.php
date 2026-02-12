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
            if (!Schema::hasColumn('users', 'trial_ends_at')) {
                $table->timestamp('trial_ends_at')->nullable();
            }
            if (!Schema::hasColumn('users', 'daily_tokens_remaining')) {
                $table->integer('daily_tokens_remaining')->default(15);
            }
            if (!Schema::hasColumn('users', 'last_token_reset_at')) {
                $table->timestamp('last_token_reset_at')->nullable();
            }
            
            // Drop old columns if they exist
            $columnsToDrop = [];
            if (Schema::hasColumn('users', 'scans_used')) $columnsToDrop[] = 'scans_used';
            if (Schema::hasColumn('users', 'matches_used')) $columnsToDrop[] = 'matches_used';
            if (Schema::hasColumn('users', 'hives_used')) $columnsToDrop[] = 'hives_used';
            if (Schema::hasColumn('users', 'usage_reset_at')) $columnsToDrop[] = 'usage_reset_at';

            if (!empty($columnsToDrop)) {
                $table->dropColumn($columnsToDrop);
            }
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('users', function (Blueprint $table) {
            $table->dropColumn(['trial_ends_at', 'daily_tokens_remaining', 'last_token_reset_at']);
        });
    }
};
