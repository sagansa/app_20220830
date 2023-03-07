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
        Schema::create('sales_order_directs', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->date('delivery_date');
            $table->unsignedBigInteger('delivery_service_id');
            $table->unsignedBigInteger('transfer_to_account_id');
            $table->string('image_transfer')->nullable();
            $table->tinyInteger('payment_status');
            $table->tinyInteger('delivery_status');
            $table->bigInteger('shipping_cost')->nullable();
            $table->unsignedBigInteger('store_id')->nullable();
            $table->string('image_receipt')->nullable();
            $table->unsignedBigInteger('submitted_by_id')->nullable();
            $table->string('received_by')->nullable();
            $table->string('sign')->nullable();
            $table->unsignedBigInteger('order_by_id');
            $table->bigInteger('Discounts');

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('sales_order_directs');
    }
};
