<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('users', function (Blueprint $table) {
            // Role Management
            $table->enum('role', ['admin', 'moderator', 'trusted', 'regular', 'banned'])->default('regular')->after('is_admin');
            
            // Ban System
            $table->timestamp('banned_at')->nullable();
            $table->string('ban_reason')->nullable();
            
            // Profiling
            $table->string('avatar')->nullable();
            $table->string('bio')->nullable();
            $table->integer('reputation_score')->default(0);
        });
    }

    public function down(): void
    {
        Schema::table('users', function (Blueprint $table) {
            $table->dropColumn(['role', 'banned_at', 'ban_reason', 'avatar', 'bio', 'reputation_score']);
        });
    }
};
