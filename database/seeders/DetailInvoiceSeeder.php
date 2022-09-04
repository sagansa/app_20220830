<?php

namespace Database\Seeders;

use App\Models\DetailInvoice;
use Illuminate\Database\Seeder;

class DetailInvoiceSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DetailInvoice::factory()
            ->count(5)
            ->create();
    }
}
