<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\ProductionMainForm;

class ProductionMainFormSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        ProductionMainForm::factory()
            ->count(5)
            ->create();
    }
}
