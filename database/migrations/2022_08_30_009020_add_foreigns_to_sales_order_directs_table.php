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
        Schema::table('sales_order_directs', function (Blueprint $table) {
            $table
                ->foreign('delivery_location_id')
                ->references('id')
                ->on('delivery_locations')
                ->onUpdate('CASCADE')
                ->onDelete('CASCADE');

            $table
                ->foreign('delivery_service_id')
                ->references('id')
                ->on('delivery_services')
                ->onUpdate('CASCADE')
                ->onDelete('CASCADE');

            $table
                ->foreign('transfer_to_account_id')
                ->references('id')
                ->on('transfer_to_accounts')
                ->onUpdate('CASCADE')
                ->onDelete('CASCADE');

            $table
                ->foreign('store_id')
                ->references('id')
                ->on('stores')
                ->onUpdate('CASCADE')
                ->onDelete('CASCADE');

            $table
                ->foreign('submitted_by_id')
                ->references('id')
                ->on('users')
                ->onUpdate('CASCADE')
                ->onDelete('CASCADE');

            $table
                ->foreign('order_by_id')
                ->references('id')
                ->on('users')
                ->onUpdate('CASCADE')
                ->onDelete('CASCADE');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('sales_order_directs', function (Blueprint $table) {
            $table->dropForeign(['delivery_location_id']);
            $table->dropForeign(['delivery_service_id']);
            $table->dropForeign(['transfer_to_account_id']);
            $table->dropForeign(['store_id']);
            $table->dropForeign(['submitted_by_id']);
            $table->dropForeign(['order_by_id']);
        });
    }
};
