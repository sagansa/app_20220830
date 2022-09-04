<?php

namespace Database\Factories;

use Illuminate\Support\Str;
use App\Models\ProductionMainForm;
use Illuminate\Database\Eloquent\Factories\Factory;

class ProductionMainFormFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = ProductionMainForm::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
            'production_id' => \App\Models\Production::factory(),
            'detail_invoice_id' => \App\Models\DetailInvoice::factory(),
        ];
    }
}
