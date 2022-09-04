<?php

namespace Database\Seeders;

use App\Models\PaymentReceipt;
use Illuminate\Database\Seeder;

class PaymentReceiptSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        PaymentReceipt::factory()
            ->count(5)
            ->create();
    }
}
