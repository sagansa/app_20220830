<?php

namespace Database\Factories;

use Illuminate\Support\Str;
use App\Models\SalesOrderDirectProduct;
use Illuminate\Database\Eloquent\Factories\Factory;

class SalesOrderDirectProductFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = SalesOrderDirectProduct::class;

    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'quantity' => $this->faker->randomNumber,
            'amount' => $this->faker->randomNumber,
            'e_product_id' => \App\Models\EProduct::factory(),
            'sales_order_direct_id' => \App\Models\SalesOrderDirect::factory(),
        ];
    }
}
