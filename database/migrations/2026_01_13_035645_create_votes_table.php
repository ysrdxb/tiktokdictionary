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
        Schema::create('votes', function (Blueprint $table) {
            $table->id();
            $table->foreignId('definition_id')->constrained()->onDelete('cascade');
            $table->foreignId('user_id')->nullable()->constrained()->onDelete('set null');
            $table->string('ip_address')->nullable();
            $table->enum('type', ['agree', 'disagree']);
            $table->timestamps();
            
            // Indexes for faster lookups
            $table->index(['definition_id', 'user_id']); // Check if user voted on this definition
            $table->index(['definition_id', 'ip_address']); // Check if IP voted (for guests)
            $table->index('created_at'); // For "Votes Today" charts
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('votes');
    }
};
