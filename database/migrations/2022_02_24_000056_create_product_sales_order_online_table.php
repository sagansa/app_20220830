<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

return new class extends Migration {
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('product_sales_order_online', function (
            Blueprint $table
        ) {
            $table->unsignedBigInteger('product_id');
            $table->unsignedBigInteger('sales_order_online_id');
            $table->integer('quantity');
            $table->bigInteger('price');

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('product_sales_order_online');
    }
};
