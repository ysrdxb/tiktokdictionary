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
        Schema::table('words', function (Blueprint $table) {
            if (!Schema::hasColumn('words', 'rfci_score')) {
                $table->string('rfci_score', 10)->nullable()->after('velocity_score'); // e.g. "82A"
            }
            if (!Schema::hasColumn('words', 'is_polar_trend')) {
                $table->boolean('is_polar_trend')->default(false)->after('rfci_score');
            }
            if (!Schema::hasColumn('words', 'ai_summary')) {
                $table->text('ai_summary')->nullable()->after('is_polar_trend');
            }
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('words', function (Blueprint $table) {
            $table->dropColumn(['rfci_score', 'is_polar_trend', 'ai_summary']);
        });
    }
};
