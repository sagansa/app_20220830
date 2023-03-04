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
        Schema::table('monthly_salary_presence', function (Blueprint $table) {
            $table
                ->foreign('presence_id')
                ->references('id')
                ->on('presences')
                ->onUpdate('CASCADE')
                ->onDelete('CASCADE');

            $table
                ->foreign('monthly_salary_id')
                ->references('id')
                ->on('monthly_salaries')
                ->onUpdate('CASCADE')
                ->onDelete('CASCADE');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('monthly_salary_presence', function (Blueprint $table) {
            $table->dropForeign(['presence_id']);
            $table->dropForeign(['monthly_salary_id']);
        });
    }
};
