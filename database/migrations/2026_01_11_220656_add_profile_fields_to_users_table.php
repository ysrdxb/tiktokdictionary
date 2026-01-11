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
            // Add missing profile fields
            if (!Schema::hasColumn('users', 'total_submissions')) {
                $table->integer('total_submissions')->default(0)->after('bio');
            }
            if (!Schema::hasColumn('users', 'total_votes_received')) {
                $table->integer('total_votes_received')->default(0)->after('total_submissions');
            }
            if (!Schema::hasColumn('users', 'last_active_at')) {
                $table->timestamp('last_active_at')->nullable()->after('reputation_score');
            }
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('users', function (Blueprint $table) {
            $table->dropColumn(['total_submissions', 'total_votes_received', 'last_active_at']);
        });
    }
};
