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
        // Table already exists, just add missing columns
        if (!Schema::hasColumn('flags', 'reporter_ip')) {
            Schema::table('flags', function (Blueprint $table) {
                $table->string('reporter_ip', 45)->nullable()->after('reporter_id');
            });
        }
        
        if (!Schema::hasColumn('flags', 'details')) {
            Schema::table('flags', function (Blueprint $table) {
                $table->text('details')->nullable()->after('reason');
            });
        }
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('flags', function (Blueprint $table) {
            if (Schema::hasColumn('flags', 'reporter_ip')) {
                $table->dropColumn('reporter_ip');
            }
            if (Schema::hasColumn('flags', 'details')) {
                $table->dropColumn('details');
            }
        });
    }
};
