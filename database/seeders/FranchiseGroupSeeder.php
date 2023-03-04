<?php

namespace Database\Seeders;

use App\Models\FranchiseGroup;
use Illuminate\Database\Seeder;

class FranchiseGroupSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        FranchiseGroup::factory()
            ->count(5)
            ->create();
    }
}
