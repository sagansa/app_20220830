<?php

namespace Database\Seeders;

use App\Models\SoDdetail;
use Illuminate\Database\Seeder;

class SoDdetailSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        SoDdetail::factory()
            ->count(5)
            ->create();
    }
}
