<?php

namespace Database\Factories;

use Illuminate\Support\Str;
use App\Models\DetailRequest;
use Illuminate\Database\Eloquent\Factories\Factory;

class DetailRequestFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = DetailRequest::class;

    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'quantity_plan' => $this->faker->randomNumber(1),
            'status' => $this->faker->numberBetween(1, 3),
            'notes' => $this->faker->text,
            'product_id' => \App\Models\Product::factory(),
            'request_purchase_id' => \App\Models\RequestPurchase::factory(),
            'store_id' => \App\Models\Store::factory(),
            'payment_type_id' => \App\Models\PaymentType::factory(),
        ];
    }
}
