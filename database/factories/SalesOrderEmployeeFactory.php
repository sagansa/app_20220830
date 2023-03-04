<?php

namespace Database\Factories;

use Illuminate\Support\Str;
use App\Models\SalesOrderEmployee;
use Illuminate\Database\Eloquent\Factories\Factory;

class SalesOrderEmployeeFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = SalesOrderEmployee::class;

    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'date' => $this->faker->date,
            'status' => $this->faker->numberBetween(1, 4),
            'notes' => $this->faker->text,
            'customer_id' => \App\Models\Customer::factory(),
            'delivery_address_id' => \App\Models\DeliveryAddress::factory(),
            'store_id' => \App\Models\Store::factory(),
            'user_id' => \App\Models\User::factory(),
        ];
    }
}
