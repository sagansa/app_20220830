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
        Schema::create('sales_order_employees', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('customer');
            $table->text('detail_customer');
            $table->unsignedBigInteger('store_id');
            $table->date('date');
            $table->string('image')->nullable();
            $table
                ->tinyInteger('status')
                ->default(1)
                ->nullable();
            $table->unsignedBigInteger('user_id')->nullable();

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('sales_order_employees');
    }
};
