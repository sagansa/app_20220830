<?php

namespace Database\Factories;

use App\Models\EProduct;
use Illuminate\Support\Str;
use Illuminate\Database\Eloquent\Factories\Factory;

class EProductFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = EProduct::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
            'quantity_stock' => $this->faker->randomNumber,
            'price' => $this->faker->randomFloat(2, 0, 9999),
            'status' => $this->faker->numberBetween(0, 127),
            'product_id' => \App\Models\Product::factory(),
            'store_id' => \App\Models\Store::factory(),
            'online_category_id' => \App\Models\OnlineCategory::factory(),
        ];
    }
}
