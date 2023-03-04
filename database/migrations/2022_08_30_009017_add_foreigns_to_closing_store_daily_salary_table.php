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
        Schema::table('closing_store_daily_salary', function (
            Blueprint $table
        ) {
            $table
                ->foreign('closing_store_id')
                ->references('id')
                ->on('closing_stores')
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
        Schema::table('closing_store_daily_salary', function (
            Blueprint $table
        ) {
            $table->dropForeign(['closing_store_id']);
            $table->dropForeign(['daily_salary_id']);
        });
    }
};
