<?php

namespace Database\Factories;

use Illuminate\Support\Str;
use App\Models\InvoicePurchase;
use Illuminate\Database\Eloquent\Factories\Factory;

class InvoicePurchaseFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = InvoicePurchase::class;

    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'date' => $this->faker->date,
            'taxes' => $this->faker->randomNumber,
            'discounts' => $this->faker->randomNumber,
            'notes' => $this->faker->text,
            'payment_status' => $this->faker->numberBetween(1, 3),
            'order_status' => $this->faker->numberBetween(1, 3),
            'payment_type_id' => \App\Models\PaymentType::factory(),
            'store_id' => \App\Models\Store::factory(),
            'supplier_id' => \App\Models\Supplier::factory(),
            'created_by_id' => \App\Models\User::factory(),
            'approved_id' => \App\Models\User::factory(),
        ];
    }
}
