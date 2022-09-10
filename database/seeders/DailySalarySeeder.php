<?php

namespace Database\Seeders;

use App\Models\DailySalary;
use Illuminate\Database\Seeder;

class DailySalarySeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DailySalary::factory()
            ->count(5)
            ->create();
    }
}
