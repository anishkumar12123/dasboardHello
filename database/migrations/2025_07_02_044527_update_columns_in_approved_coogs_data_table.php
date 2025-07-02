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
        Schema::table('approved_coogs_data', function (Blueprint $table) {
            $table->decimal('final_coop', 12, 6)->change();
            $table->decimal('net_served', 12, 6)->change();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('approved_coogs_data', function (Blueprint $table) {
            // Revert to old structure if needed
            $table->decimal('final_coop', 10, 4)->change(); // example previous structure
            $table->decimal('net_served', 10, 6)->change(); // example previous structure
        });
    }
};
