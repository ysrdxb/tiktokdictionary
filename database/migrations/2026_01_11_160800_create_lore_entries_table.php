<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('lore_entries', function (Blueprint $table) {
            $table->id();
            $table->foreignId('word_id')->constrained()->cascadeOnDelete();
            $table->string('platform')->comment('tiktok, twitter, etc');
            $table->string('source_url');
            $table->string('description')->nullable();
            $table->string('creator_handle')->nullable(); // @username
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('lore_entries');
    }
};
