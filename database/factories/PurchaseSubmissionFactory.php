<?php

namespace Database\Factories;

use Illuminate\Support\Str;
use App\Models\PurchaseSubmission;
use Illuminate\Database\Eloquent\Factories\Factory;

class PurchaseSubmissionFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = PurchaseSubmission::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
            'date' => $this->faker->date,
            'store_id' => \App\Models\Store::factory(),
            'user_id' => \App\Models\User::factory(),
        ];
    }
}
