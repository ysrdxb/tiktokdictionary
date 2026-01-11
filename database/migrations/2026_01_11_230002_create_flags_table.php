<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('flags', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('reporter_id')->nullable(); // User who reported
            $table->string('flaggable_type'); // Word, Definition, User
            $table->unsignedBigInteger('flaggable_id');
            $table->string('reason');
            $table->enum('status', ['pending', 'reviewed', 'dismissed', 'resolved'])->default('pending');
            $table->unsignedBigInteger('reviewed_by')->nullable();
            $table->timestamp('reviewed_at')->nullable();
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('flags');
    }
};
