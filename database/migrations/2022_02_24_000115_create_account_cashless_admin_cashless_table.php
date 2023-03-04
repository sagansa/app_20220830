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
        Schema::create('account_cashless_admin_cashless', function (
            Blueprint $table
        ) {
            $table->unsignedBigInteger('account_cashless_id');
            $table->unsignedBigInteger('admin_cashless_id');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('account_cashless_admin_cashless');
    }
};
