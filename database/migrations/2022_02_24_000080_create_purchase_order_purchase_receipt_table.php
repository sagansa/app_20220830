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
        Schema::create('purchase_order_purchase_receipt', function (
            Blueprint $table
        ) {
            $table->unsignedBigInteger('purchase_order_id');
            $table->unsignedBigInteger('purchase_receipt_id');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('purchase_order_purchase_receipt');
    }
};
