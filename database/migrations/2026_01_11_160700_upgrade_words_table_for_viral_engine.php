<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('words', function (Blueprint $table) {
            if (!Schema::hasColumn('words', 'admin_boost')) {
                $table->integer('admin_boost')->default(0)->after('slug');
            }
            if (!Schema::hasColumn('words', 'rfci_score')) {
                $table->string('rfci_score')->nullable()->after('slug');
            }
            if (!Schema::hasColumn('words', 'views')) {
                $table->unsignedBigInteger('views')->default(0)->after('slug');
            }
            if (!Schema::hasColumn('words', 'views_buffer')) {
                $table->integer('views_buffer')->default(0)->after('slug');
            }
            if (!Schema::hasColumn('words', 'is_polar_trend')) {
                $table->boolean('is_polar_trend')->default(false)->after('slug');
            }
            if (!Schema::hasColumn('words', 'vibes')) {
                $table->json('vibes')->nullable();
            }
        });
    }

    public function down(): void
    {
        Schema::table('words', function (Blueprint $table) {
            $table->dropColumn(['admin_boost', 'rfci_score', 'views_buffer', 'is_polar_trend', 'vibes']);
        });
    }
};
