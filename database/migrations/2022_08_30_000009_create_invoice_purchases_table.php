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
        Schema::create('invoice_purchases', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('image')->nullable();
            $table->unsignedBigInteger('payment_type_id');
            $table->unsignedBigInteger('store_id');
            $table->unsignedBigInteger('supplier_id');
            $table->date('date');
            $table->bigInteger('taxes');
            $table->bigInteger('discounts');
            $table->text('notes')->nullable();
            $table->tinyInteger('payment_status');
            $table->tinyInteger('order_status');
            $table->unsignedBigInteger('created_by_id')->nullable();
            $table->unsignedBigInteger('approved_id')->nullable();

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('invoice_purchases');
    }
};
