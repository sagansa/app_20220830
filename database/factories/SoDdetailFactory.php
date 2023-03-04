<?php

namespace Database\Factories;

use App\Models\SoDdetail;
use Illuminate\Support\Str;
use Illuminate\Database\Eloquent\Factories\Factory;

class SoDdetailFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = SoDdetail::class;

    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'quantity' => $this->faker->randomNumber,
            'price' => $this->faker->randomNumber(1),
            'e_product_id' => \App\Models\EProduct::factory(),
            'sales_order_direct_id' => \App\Models\SalesOrderDirect::factory(),
        ];
    }
}
