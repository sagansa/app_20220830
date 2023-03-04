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
        Schema::table('purchase_order_purchase_receipt', function (
            Blueprint $table
        ) {
            $table
                ->foreign('purchase_order_id')
                ->references('id')
                ->on('purchase_orders')
                ->onUpdate('CASCADE')
                ->onDelete('CASCADE');

            $table
                ->foreign('purchase_receipt_id')
                ->references('id')
                ->on('purchase_receipts')
                ->onUpdate('CASCADE')
                ->onDelete('CASCADE');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('purchase_order_purchase_receipt', function (
            Blueprint $table
        ) {
            $table->dropForeign(['purchase_order_id']);
            $table->dropForeign(['purchase_receipt_id']);
        });
    }
};
