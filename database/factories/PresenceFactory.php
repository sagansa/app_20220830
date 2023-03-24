<?php

namespace Database\Factories;

use App\Models\Presence;
use Illuminate\Support\Str;
use Illuminate\Database\Eloquent\Factories\Factory;

class PresenceFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = Presence::class;

    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'status' => $this->faker->numberBetween(1, 2),
            'image_in' => $this->faker->text(255),
            'image_out' => $this->faker->text(255),
            'date' => $this->faker->date,
            'time_in' => $this->faker->dateTime,
            'time_out' => $this->faker->dateTime,
            'latitude_in' => $this->faker->randomNumber(1),
            'longitude_in' => $this->faker->randomNumber(1),
            'latitude_out' => $this->faker->randomNumber(1),
            'longitude_out' => $this->faker->randomNumber(1),
            'created_by_id' => \App\Models\User::factory(),
            'approved_by_id' => \App\Models\User::factory(),
            'store_id' => \App\Models\Store::factory(),
            'shift_store_id' => \App\Models\ShiftStore::factory(),
        ];
    }
}
