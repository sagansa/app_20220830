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
        Schema::table('daily_salary_payment_receipt', function (
            Blueprint $table
        ) {
            $table
                ->foreign('payment_receipt_id')
                ->references('id')
                ->on('payment_receipts')
                ->onUpdate('CASCADE')
                ->onDelete('CASCADE');

            $table
                ->foreign('daily_salary_id')
                ->references('id')
                ->on('daily_salaries')
                ->onUpdate('CASCADE')
                ->onDelete('CASCADE');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('daily_salary_payment_receipt', function (
            Blueprint $table
        ) {
            $table->dropForeign(['payment_receipt_id']);
            $table->dropForeign(['daily_salary_id']);
        });
    }
};
