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
        Schema::table('so_ddetails', function (Blueprint $table) {
            $table
                ->foreign('e_product_id')
                ->references('id')
                ->on('e_products')
                ->onUpdate('CASCADE')
                ->onDelete('CASCADE');

            $table
                ->foreign('sales_order_direct_id')
                ->references('id')
                ->on('sales_order_directs')
                ->onUpdate('CASCADE')
                ->onDelete('CASCADE');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('so_ddetails', function (Blueprint $table) {
            $table->dropForeign(['e_product_id']);
            $table->dropForeign(['sales_order_direct_id']);
        });
    }
};
