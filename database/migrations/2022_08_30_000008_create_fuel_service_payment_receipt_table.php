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
        Schema::create('fuel_service_payment_receipt', function (
            Blueprint $table
        ) {
            $table->unsignedBigInteger('fuel_service_id');
            $table->unsignedBigInteger('payment_receipt_id');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('fuel_service_payment_receipt');
    }
};
