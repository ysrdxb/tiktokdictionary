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
        Schema::create('definitions', function (Blueprint $table) {
            $table->id();
            $table->foreignId('word_id')->constrained()->onDelete('cascade');
            $table->text('definition');
            $table->text('example')->nullable();
            $table->string('submitted_by')->default('Anonymous');
            $table->integer('agrees')->default(0);
            $table->integer('disagrees')->default(0);
            $table->decimal('velocity_score', 10, 4)->default(0);
            $table->boolean('is_primary')->default(false);
            $table->timestamps();
            
            // Indexes for performance
            $table->index('word_id');
            $table->index('agrees');
            $table->index('velocity_score');
            $table->fullText(['definition', 'example']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('definitions');
    }
};
