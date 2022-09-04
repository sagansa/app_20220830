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
        Schema::table('detail_invoices', function (Blueprint $table) {
            $table
                ->foreign('invoice_purchase_id')
                ->references('id')
                ->on('invoice_purchases')
                ->onUpdate('CASCADE')
                ->onDelete('CASCADE');

            $table
                ->foreign('detail_request_id')
                ->references('id')
                ->on('detail_requests')
                ->onUpdate('CASCADE')
                ->onDelete('CASCADE');

            $table
                ->foreign('unit_invoice_id')
                ->references('id')
                ->on('units')
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
        Schema::table('detail_invoices', function (Blueprint $table) {
            $table->dropForeign(['invoice_purchase_id']);
            $table->dropForeign(['detail_request_id']);
            $table->dropForeign(['unit_invoice_id']);
        });
    }
};
