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
        Schema::create('production_main_froms', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->unsignedBigInteger('production_id');
            $table->unsignedBigInteger('detail_invoice_id');

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('production_main_froms');
    }
};
