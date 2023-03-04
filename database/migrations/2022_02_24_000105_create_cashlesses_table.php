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
        Schema::create('cashlesses', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->unsignedBigInteger('account_cashless_id');
            $table->string('image')->nullable();
            $table->bigInteger('bruto_apl');
            $table->bigInteger('netto_apl')->nullable();
            $table->bigInteger('bruto_real')->nullable();
            $table->bigInteger('netto_real')->nullable();
            $table->string('image_canceled')->nullable();
            $table->integer('canceled');
            $table->unsignedBigInteger('closing_store_id');

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('cashlesses');
    }
};
