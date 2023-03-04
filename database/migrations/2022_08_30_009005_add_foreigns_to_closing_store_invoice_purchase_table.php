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
        Schema::table('closing_store_invoice_purchase', function (
            Blueprint $table
        ) {
            $table
                ->foreign('invoice_purchase_id')
                ->references('id')
                ->on('invoice_purchases')
                ->onUpdate('CASCADE')
                ->onDelete('CASCADE');

            $table
                ->foreign('closing_store_id')
                ->references('id')
                ->on('closing_stores')
                ->onUpdate('CASCADE')
                ->onDelete('CASCADE');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('closing_store_invoice_purchase', function (
            Blueprint $table
        ) {
            $table->dropForeign(['invoice_purchase_id']);
            $table->dropForeign(['closing_store_id']);
        });
    }
};
