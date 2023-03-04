<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\RestaurantCategory;

class RestaurantCategorySeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        RestaurantCategory::factory()
            ->count(5)
            ->create();
    }
}
