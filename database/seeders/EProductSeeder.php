<?php

namespace Database\Seeders;

use App\Models\EProduct;
use Illuminate\Database\Seeder;

class EProductSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        EProduct::factory()
            ->count(5)
            ->create();
    }
}
