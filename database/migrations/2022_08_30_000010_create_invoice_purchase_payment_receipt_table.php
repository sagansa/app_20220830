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
        Schema::create('invoice_purchase_payment_receipt', function (
            Blueprint $table
        ) {
            $table->unsignedBigInteger('invoice_purchase_id');
            $table->unsignedBigInteger('payment_receipt_id');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('invoice_purchase_payment_receipt');
    }
};
