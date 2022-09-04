<?php

namespace Database\Factories;

use Illuminate\Support\Str;
use App\Models\DetailPurchase;
use Illuminate\Database\Eloquent\Factories\Factory;

class DetailPurchaseFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = DetailPurchase::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
            'quantity_plan' => $this->faker->randomNumber(1),
            'status' => $this->faker->numberBetween(0, 127),
            'notes' => $this->faker->text,
            'product_id' => \App\Models\Product::factory(),
            'purchase_submission_id' => \App\Models\PurchaseSubmission::factory(),
        ];
    }
}
