<?php

namespace Database\Factories;

use Illuminate\Support\Str;
use App\Models\TransferToAccount;
use Illuminate\Database\Eloquent\Factories\Factory;

class TransferToAccountFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = TransferToAccount::class;

    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'name' => $this->faker->name(),
            'number' => $this->faker->randomNumber,
            'status' => $this->faker->numberBetween(0, 127),
            'bank_id' => \App\Models\Bank::factory(),
        ];
    }
}
