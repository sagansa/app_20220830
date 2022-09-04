<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\RequestPurchase;

class RequestPurchaseSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        RequestPurchase::factory()
            ->count(5)
            ->create();
    }
}
