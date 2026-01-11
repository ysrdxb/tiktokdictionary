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
        // Table already exists, just add missing column
        if (!Schema::hasColumn('settings', 'type')) {
            Schema::table('settings', function (Blueprint $table) {
                $table->string('type', 20)->default('string')->after('group');
            });
        }
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        if (Schema::hasColumn('settings', 'type')) {
            Schema::table('settings', function (Blueprint $table) {
                $table->dropColumn('type');
            });
        }
    }
};
