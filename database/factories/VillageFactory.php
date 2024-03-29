<?php

namespace Database\Factories;

use App\Models\Village;
use Illuminate\Support\Str;
use Illuminate\Database\Eloquent\Factories\Factory;

class VillageFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = Village::class;

    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'name' => $this->faker->name,
            'district_id' => \App\Models\District::factory(),
        ];
    }
}
