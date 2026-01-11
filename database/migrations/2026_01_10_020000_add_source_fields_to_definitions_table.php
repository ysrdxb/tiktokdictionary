<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('definitions', function (Blueprint $table) {
            $table->string('source_platform', 30)->nullable()->after('submitted_by');
            $table->text('source_url')->nullable()->after('source_platform');

            $table->index('source_platform');
        });
    }

    public function down(): void
    {
        Schema::table('definitions', function (Blueprint $table) {
            $table->dropIndex('definitions_source_platform_index');
            $table->dropColumn(['source_platform', 'source_url']);
        });
    }
};
