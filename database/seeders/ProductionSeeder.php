<?php

namespace Database\Seeders;

use App\Models\Production;
use Illuminate\Database\Seeder;

class ProductionSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Production::factory()
            ->count(5)
            ->create();
    }
}
