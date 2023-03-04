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
        Schema::table('hygiene_of_rooms', function (Blueprint $table) {
            $table
                ->foreign('hygiene_id')
                ->references('id')
                ->on('hygienes')
                ->onUpdate('CASCADE')
                ->onDelete('CASCADE');

            $table
                ->foreign('room_id')
                ->references('id')
                ->on('rooms')
                ->onUpdate('CASCADE')
                ->onDelete('CASCADE');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('hygiene_of_rooms', function (Blueprint $table) {
            $table->dropForeign(['hygiene_id']);
            $table->dropForeign(['room_id']);
        });
    }
};
