<?php

namespace Database\Factories;

use Illuminate\Support\Str;
use App\Models\RequestPurchase;
use Illuminate\Database\Eloquent\Factories\Factory;

class RequestPurchaseFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = RequestPurchase::class;

    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'date' => $this->faker->date,
            'status' => $this->faker->numberBetween(1, 2),
            'store_id' => \App\Models\Store::factory(),
            'user_id' => \App\Models\User::factory(),
        ];
    }
}
