<?php

namespace Database\Seeders;

use App\Models\DetailPurchase;
use Illuminate\Database\Seeder;

class DetailPurchaseSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DetailPurchase::factory()
            ->count(5)
            ->create();
    }
}
