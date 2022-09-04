<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\PurchaseSubmission;

class PurchaseSubmissionSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        PurchaseSubmission::factory()
            ->count(5)
            ->create();
    }
}
