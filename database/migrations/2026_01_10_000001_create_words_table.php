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
        Schema::create('words', function (Blueprint $table) {
            $table->id();
            $table->string('term')->unique();
            $table->string('slug')->unique();
            $table->string('category')->default('General');
            $table->integer('total_definitions')->default(0);
            $table->integer('total_agrees')->default(0);
            $table->integer('total_disagrees')->default(0);
            $table->decimal('velocity_score', 10, 4)->default(0);
            $table->boolean('is_verified')->default(false);
            $table->timestamps();
            
            // Indexes for performance
            $table->index('velocity_score');
            $table->index('created_at');
            $table->fullText(['term']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('words');
    }
};
