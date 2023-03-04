<?php

namespace Database\Factories;

use Illuminate\Support\Str;
use App\Models\DetailInvoice;
use Illuminate\Database\Eloquent\Factories\Factory;

class DetailInvoiceFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = DetailInvoice::class;

    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'quantity_product' => $this->faker->randomNumber(1),
            'quantity_invoice' => $this->faker->randomNumber(1),
            'subtotal_invoice' => $this->faker->randomNumber,
            'status' => $this->faker->numberBetween(1, 3),
            'invoice_purchase_id' => \App\Models\InvoicePurchase::factory(),
            'unit_invoice_id' => \App\Models\Unit::factory(),
            'detail_request_id' => \App\Models\DetailRequest::factory(),
        ];
    }
}
