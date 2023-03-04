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
        Schema::create('closing_store_purchase_order', function (
            Blueprint $table
        ) {
            $table->unsignedBigInteger('closing_store_id');
            $table->unsignedBigInteger('purchase_order_id');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('closing_store_purchase_order');
    }
};
