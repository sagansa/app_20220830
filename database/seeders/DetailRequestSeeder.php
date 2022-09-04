<?php

namespace Database\Seeders;

use App\Models\DetailRequest;
use Illuminate\Database\Seeder;

class DetailRequestSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DetailRequest::factory()
            ->count(5)
            ->create();
    }
}
