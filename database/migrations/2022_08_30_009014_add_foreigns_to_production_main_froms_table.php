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
        Schema::table('production_main_froms', function (Blueprint $table) {
            $table
                ->foreign('production_id')
                ->references('id')
                ->on('productions')
                ->onUpdate('CASCADE')
                ->onDelete('CASCADE');

            $table
                ->foreign('detail_invoice_id')
                ->references('id')
                ->on('detail_invoices')
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
        Schema::table('production_main_froms', function (Blueprint $table) {
            $table->dropForeign(['production_id']);
            $table->dropForeign(['detail_invoice_id']);
        });
    }
};
