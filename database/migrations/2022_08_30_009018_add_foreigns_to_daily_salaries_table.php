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
        Schema::table('daily_salaries', function (Blueprint $table) {
            $table
                ->foreign('store_id')
                ->references('id')
                ->on('stores')
                ->onUpdate('CASCADE')
                ->onDelete('CASCADE');

            $table
                ->foreign('shift_store_id')
                ->references('id')
                ->on('shift_stores')
                ->onUpdate('CASCADE')
                ->onDelete('CASCADE');

            $table
                ->foreign('payment_type_id')
                ->references('id')
                ->on('payment_types')
                ->onUpdate('CASCADE')
                ->onDelete('CASCADE');

            $table
                ->foreign('presence_id')
                ->references('id')
                ->on('presences')
                ->onUpdate('CASCADE')
                ->onDelete('CASCADE');

            $table
                ->foreign('created_by_id')
                ->references('id')
                ->on('users')
                ->onUpdate('CASCADE')
                ->onDelete('CASCADE');

            $table
                ->foreign('approved_by_id')
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
        Schema::table('daily_salaries', function (Blueprint $table) {
            $table->dropForeign(['store_id']);
            $table->dropForeign(['shift_store_id']);
            $table->dropForeign(['payment_type_id']);
            $table->dropForeign(['presence_id']);
            $table->dropForeign(['created_by_id']);
            $table->dropForeign(['approved_by_id']);
        });
    }
};
