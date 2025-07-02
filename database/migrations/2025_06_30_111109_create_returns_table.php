<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up()
    {
        Schema::create('returns', function (Blueprint $table) {
            $table->id();
            $table->date('return_date')->nullable();
            $table->string('shipment_request_id')->nullable();
            $table->string('return_id')->nullable();
            $table->string('marketplace')->nullable();
            $table->string('authorization_id')->nullable();
            $table->string('vendor_code')->nullable();
            $table->string('invoice_number')->nullable();
            $table->string('warehouse')->nullable();
            $table->decimal('total_cost', 10, 2)->nullable();
            $table->timestamps();
        });
    }


    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('returns');
    }
};
