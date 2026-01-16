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
        // Force cleanup of bad state
        Schema::dropIfExists('definition_reactions');
        
        // Cleanup columns if they exist partially
        if (Schema::hasColumn('definitions', 'reaction_fire')) {
            Schema::table('definitions', function (Blueprint $table) {
                $table->dropColumn(['reaction_fire', 'reaction_skull', 'reaction_melt', 'reaction_clown']);
            });
        }

        // 1. Create the tracking table
        Schema::create('definition_reactions', function (Blueprint $table) {
            $table->id();
            $table->foreignId('definition_id')->constrained()->onDelete('cascade');
            $table->string('ip_address', 45); // Support IPv6
            $table->string('type'); // fire, skull, melt, clown
            $table->timestamps();
            
            // Prevent spam: One reaction type per IP per definition
            $table->unique(['definition_id', 'ip_address', 'type']);
        });

        // 2. Add cached counts to definitions table
        Schema::table('definitions', function (Blueprint $table) {
            $table->integer('reaction_fire')->default(0);
            $table->integer('reaction_skull')->default(0);
            $table->integer('reaction_melt')->default(0);
            $table->integer('reaction_clown')->default(0);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('definition_reactions');
        
        Schema::table('definitions', function (Blueprint $table) {
            $table->dropColumn(['reaction_fire', 'reaction_skull', 'reaction_melt', 'reaction_clown']);
        });
    }
};
