<?php

namespace Database\Factories;

use Illuminate\Support\Str;
use App\Models\DeliveryLocation;
use Illuminate\Database\Eloquent\Factories\Factory;

class DeliveryLocationFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = DeliveryLocation::class;

    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'label' => $this->faker->name(),
            'contact_name' => $this->faker->text(255),
            'contact_number' => $this->faker->text(255),
            'Address' => $this->faker->address,
            'user_id' => \App\Models\User::factory(),
            'province_id' => \App\Models\Province::factory(),
            'regency_id' => \App\Models\Regency::factory(),
            'district_id' => \App\Models\District::factory(),
            'village_id' => \App\Models\Village::factory(),
        ];
    }
}
