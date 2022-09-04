<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\ProductionMainFrom;

class ProductionMainFromSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        ProductionMainFrom::factory()
            ->count(5)
            ->create();
    }
}
