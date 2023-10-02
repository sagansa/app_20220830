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
        Schema::create('presences', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->unsignedBigInteger('store_id');
            $table->unsignedBigInteger('shift_store_id');
            $table->tinyInteger('status')->default(1);
            $table->string('image_in')->nullable();
            $table->string('image_out')->nullable();
            $table->date('date_in');
            $table->date('date_out');
            $table->time('time_in');
            $table->time('time_out')->nullable();
            $table->unsignedBigInteger('created_by_id')->nullable();
            $table->unsignedBigInteger('approved_by_id')->nullable();
            $table->decimal('latitude_in');
            $table->decimal('longitude_in');
            $table->decimal('latitude_out')->nullable();
            $table->decimal('longitude_out')->nullable();

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('presences');
    }
};
