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
   // database/migrations/xxxx_create_coogs_data_table.php
Schema::create('coogs_data', function (Blueprint $table) {
    $table->id();
    $table->string('invoice_id')->nullable();
    $table->date('invoice_date')->nullable();
    $table->string('agreement_id')->nullable();
    $table->text('agreement_title')->nullable();
    $table->string('funding_type')->nullable();
    $table->decimal('original_balance', 10, 2)->nullable();
    $table->timestamps();
});
}


    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('coogs_data');
    }
};
