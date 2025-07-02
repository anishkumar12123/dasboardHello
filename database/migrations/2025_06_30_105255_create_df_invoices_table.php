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
     Schema::create('df_invoices', function (Blueprint $table) {
    $table->id();
    $table->date('date')->nullable();
    $table->string('sale_order_number')->nullable();
    $table->string('invoice_number')->nullable();
    $table->string('channel_entry')->nullable();
    $table->string('product_name')->nullable();
    $table->string('product_sku_code')->nullable();
    $table->integer('qty')->nullable();
    $table->decimal('unit_price', 10, 2)->nullable();
    $table->string('currency')->nullable();
    $table->decimal('total', 10, 2)->nullable();
    $table->timestamps();

});

    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('df_invoices');
    }
};
