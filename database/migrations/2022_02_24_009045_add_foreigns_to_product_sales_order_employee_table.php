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
        Schema::table('product_sales_order_employee', function (
            Blueprint $table
        ) {
            $table
                ->foreign('product_id')
                ->references('id')
                ->on('products')
                ->onUpdate('CASCADE')
                ->onDelete('CASCADE');

            $table
                ->foreign('sales_order_employee_id')
                ->references('id')
                ->on('sales_order_employees')
                ->onUpdate('CASCADE')
                ->onDelete('CASCADE');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('product_sales_order_employee', function (
            Blueprint $table
        ) {
            $table->dropForeign(['product_id']);
            $table->dropForeign(['sales_order_employee_id']);
        });
    }
};
