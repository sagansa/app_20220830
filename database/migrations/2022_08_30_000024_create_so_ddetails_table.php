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
        Schema::create('so_ddetails', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->unsignedBigInteger('e_product_id');
            $table->bigInteger('quantity');
            $table->decimal('price');
            $table->unsignedBigInteger('sales_order_direct_id');

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('so_ddetails');
    }
};
