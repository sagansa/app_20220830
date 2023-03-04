<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\ReceiptLoyverse;

class ReceiptLoyverseSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        ReceiptLoyverse::factory()
            ->count(5)
            ->create();
    }
}
