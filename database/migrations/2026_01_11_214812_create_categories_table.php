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
        if (!Schema::hasColumn('categories', 'words_count')) {
            Schema::table('categories', function (Blueprint $table) {
                $table->integer('words_count')->default(0)->after('is_active');
            });
        }
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        if (Schema::hasColumn('categories', 'words_count')) {
            Schema::table('categories', function (Blueprint $table) {
                $table->dropColumn('words_count');
            });
        }
    }
};
