<?php

namespace Database\Factories;

use App\Models\Cart;
use Illuminate\Support\Str;
use Illuminate\Database\Eloquent\Factories\Factory;

class CartFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = Cart::class;

    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'quantity' => $this->faker->randomNumber,
            'user_id' => \App\Models\User::factory(),
            'e_product_id' => \App\Models\EProduct::factory(),
        ];
    }
}
