<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\ReceiptByItemLoyverse;

class ReceiptByItemLoyverseSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        ReceiptByItemLoyverse::factory()
            ->count(5)
            ->create();
    }
}
