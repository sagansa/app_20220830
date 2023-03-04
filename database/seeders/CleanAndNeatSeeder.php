<?php

namespace Database\Seeders;

use App\Models\CleanAndNeat;
use Illuminate\Database\Seeder;

class CleanAndNeatSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        CleanAndNeat::factory()
            ->count(5)
            ->create();
    }
}
