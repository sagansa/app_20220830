<?php

namespace Database\Factories;

use App\Models\DailySalary;
use Illuminate\Support\Str;
use Illuminate\Database\Eloquent\Factories\Factory;

class DailySalaryFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = DailySalary::class;

    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'date' => $this->faker->date,
            'amount' => $this->faker->randomNumber,
            'status' => $this->faker->numberBetween(1, 4),
            'store_id' => \App\Models\Store::factory(),
            'shift_store_id' => \App\Models\ShiftStore::factory(),
            'payment_type_id' => \App\Models\PaymentType::factory(),
            'presence_id' => \App\Models\Presence::factory(),
            'created_by_id' => \App\Models\User::factory(),
            'approved_by_id' => \App\Models\User::factory(),
        ];
    }
}
