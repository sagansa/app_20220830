<?php

namespace Database\Factories;

use App\Models\Regency;
use Illuminate\Support\Str;
use Illuminate\Database\Eloquent\Factories\Factory;

class RegencyFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = Regency::class;

    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'name' => $this->faker->name,
            'province_id' => \App\Models\Province::factory(),
        ];
    }
}
