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
     *
     * @return void
     */
    public function down()
    {
        Schema::table('closing_store_daily_salary', function (
            Blueprint $table
        ) {
            $table->dropForeign(['closing_store_id']);
            $table->dropForeign(['daily_salary_id']);
        });
    }
};
