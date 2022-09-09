<?php

namespace Database\Factories;

use App\Models\FuelService;
use Illuminate\Support\Str;
use Illuminate\Database\Eloquent\Factories\Factory;

class FuelServiceFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = FuelService::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
            'fuel_service' => $this->faker->numberBetween(0, 127),
            'km' => $this->faker->randomNumber(2),
            'liter' => $this->faker->randomNumber(2),
            'amount' => $this->faker->randomNumber,
            'status' => $this->faker->numberBetween(1, 3),
            'notes' => $this->faker->text,
            'vehicle_id' => \App\Models\Vehicle::factory(),
            'payment_type_id' => \App\Models\PaymentType::factory(),
            'created_by_id' => \App\Models\User::factory(),
            'approved_by_id' => \App\Models\User::factory(),
        ];
    }
}
