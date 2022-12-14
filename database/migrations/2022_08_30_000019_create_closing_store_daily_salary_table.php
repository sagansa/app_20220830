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
        Schema::create('closing_store_daily_salary', function (
            Blueprint $table
        ) {
            $table->unsignedBigInteger('closing_store_id');
            $table->unsignedBigInteger('daily_salary_id');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('closing_store_daily_salary');
    }
};
