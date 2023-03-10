<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\SalesOrderDirectProduct;

class SalesOrderDirectProductSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        SalesOrderDirectProduct::factory()
            ->count(5)
            ->create();
    }
}
