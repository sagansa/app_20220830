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
        Schema::table('fuel_service_payment_receipt', function (
            Blueprint $table
        ) {
            $table
                ->foreign('fuel_service_id')
                ->references('id')
                ->on('fuel_services')
                ->onUpdate('CASCADE')
                ->onDelete('CASCADE');

            $table
                ->foreign('payment_receipt_id')
                ->references('id')
                ->on('payment_receipts')
                ->onUpdate('CASCADE')
                ->onDelete('CASCADE');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('fuel_service_payment_receipt', function (
            Blueprint $table
        ) {
            $table->dropForeign(['fuel_service_id']);
            $table->dropForeign(['payment_receipt_id']);
        });
    }
};
