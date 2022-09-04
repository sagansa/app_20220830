<?php

namespace Database\Factories;

use Illuminate\Support\Str;
use App\Models\PaymentReceipt;
use Illuminate\Database\Eloquent\Factories\Factory;

class PaymentReceiptFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = PaymentReceipt::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
            'amount' => $this->faker->randomNumber,
            'payment_for' => $this->faker->numberBetween(1, 3),
        ];
    }
}
