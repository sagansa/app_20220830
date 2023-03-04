<?php

namespace Database\Seeders;

use App\Models\ProductionFrom;
use Illuminate\Database\Seeder;

class ProductionFromSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        ProductionFrom::factory()
            ->count(5)
            ->create();
    }
}
