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
        Schema::create('daily_salary_payment_receipt', function (
            Blueprint $table
        ) {
            $table->unsignedBigInteger('payment_receipt_id');
            $table->unsignedBigInteger('daily_salary_id');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('daily_salary_payment_receipt');
    }
};
