<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\InvoicePurchase;

class InvoicePurchaseSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        InvoicePurchase::factory()
            ->count(5)
            ->create();
    }
}
