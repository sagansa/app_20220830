<?php

namespace Database\Factories;

use Illuminate\Support\Str;
use App\Models\SalesOrderDirect;
use Illuminate\Database\Eloquent\Factories\Factory;

class SalesOrderDirectFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = SalesOrderDirect::class;

    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'delivery_date' => $this->faker->date,
            'payment_status' => $this->faker->numberBetween(0, 127),
            'delivery_status' => $this->faker->numberBetween(0, 127),
            'shipping_cost' => $this->faker->randomNumber,
            'image_receipt' => $this->faker->text(255),
            'received_by' => $this->faker->text(255),
            'sign' => $this->faker->text(255),
            'Discounts' => $this->faker->randomNumber,
            'store_id' => \App\Models\Store::factory(),
            'delivery_service_id' => \App\Models\DeliveryService::factory(),
            'transfer_to_account_id' => \App\Models\TransferToAccount::factory(),
            'submitted_by_id' => \App\Models\User::factory(),
            'order_by_id' => \App\Models\User::factory(),
        ];
    }
}
