<?php

namespace Database\Seeders;

use App\Models\EProduct;
use Illuminate\Database\Seeder;

class EProductSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        EProduct::factory()
            ->count(5)
            ->create();
    }
}
