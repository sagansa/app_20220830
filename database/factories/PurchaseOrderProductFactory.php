<?php

namespace Database\Factories;

use Illuminate\Support\Str;
use App\Models\PurchaseOrderProduct;
use Illuminate\Database\Eloquent\Factories\Factory;

class PurchaseOrderProductFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = PurchaseOrderProduct::class;

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
            'product_id' => \App\Models\Product::factory(),
            'unit_id' => \App\Models\Unit::factory(),
        ];
    }
}
