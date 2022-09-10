<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

return new class extends Migration {
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
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
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('daily_salary_payment_receipt');
    }
};
