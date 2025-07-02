<?php
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::create('approved_coogs_data', function (Blueprint $table) {
            $table->id();
            $table->string('asin')->nullable();
            $table->decimal('gross_ship_gms', 10, 2)->nullable();
            $table->decimal('net_ship_gms', 10, 6)->nullable();
            $table->date('order_date')->nullable();
            $table->integer('net_ship_units')->nullable();
            $table->string('duration')->nullable();
            $table->decimal('net_net', 15, 4)->nullable();
            $table->decimal('net_served', 12, 6)->nullable();
            $table->integer('coop')->nullable(); // Changed to integer
            $table->decimal('final_coop', 12, 6)->nullable();
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('approved_coogs_data');
    }
};
