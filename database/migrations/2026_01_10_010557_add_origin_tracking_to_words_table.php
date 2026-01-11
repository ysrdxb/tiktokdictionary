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
            $table->string('origin_source')->nullable()->after('category');
            $table->date('first_seen_date')->nullable()->after('origin_source');
            $table->json('related_word_ids')->nullable()->after('first_seen_date');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('words', function (Blueprint $table) {
            $table->dropColumn(['origin_source', 'first_seen_date', 'related_word_ids']);
        });
    }
};
