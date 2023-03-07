<?php

namespace Tests\Feature\Api;

use App\Models\User;
use App\Models\SalesOrderDirect;

use App\Models\Store;
use App\Models\DeliveryService;
use App\Models\TransferToAccount;

use Tests\TestCase;
use Laravel\Sanctum\Sanctum;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;

class SalesOrderDirectTest extends TestCase
{
    use RefreshDatabase, WithFaker;

    protected function setUp(): void
    {
        parent::setUp();

        $user = User::factory()->create(['email' => 'admin@admin.com']);

        Sanctum::actingAs($user, [], 'web');

        $this->seed(\Database\Seeders\PermissionsSeeder::class);

        $this->withoutExceptionHandling();
    }

    /**
     * @test
     */
    public function it_gets_sales_order_directs_list(): void
    {
        $salesOrderDirects = SalesOrderDirect::factory()
            ->count(5)
            ->create();

        $response = $this->getJson(route('api.sales-order-directs.index'));

        $response->assertOk()->assertSee($salesOrderDirects[0]->delivery_date);
    }

    /**
     * @test
     */
    public function it_stores_the_sales_order_direct(): void
    {
        $data = SalesOrderDirect::factory()
            ->make()
            ->toArray();

        $response = $this->postJson(
            route('api.sales-order-directs.store'),
            $data
        );

        $this->assertDatabaseHas('sales_order_directs', $data);

        $response->assertStatus(201)->assertJsonFragment($data);
    }

    /**
     * @test
     */
    public function it_updates_the_sales_order_direct(): void
    {
        $salesOrderDirect = SalesOrderDirect::factory()->create();

        $store = Store::factory()->create();
        $deliveryService = DeliveryService::factory()->create();
        $transferToAccount = TransferToAccount::factory()->create();
        $user = User::factory()->create();
        $user = User::factory()->create();

        $data = [
            'delivery_date' => $this->faker->date,
            'payment_status' => $this->faker->numberBetween(0, 127),
            'delivery_status' => $this->faker->numberBetween(0, 127),
            'shipping_cost' => $this->faker->randomNumber,
            'image_receipt' => $this->faker->text(255),
            'received_by' => $this->faker->text(255),
            'sign' => $this->faker->text(255),
            'Discounts' => $this->faker->randomNumber,
            'store_id' => $store->id,
            'delivery_service_id' => $deliveryService->id,
            'transfer_to_account_id' => $transferToAccount->id,
            'submitted_by_id' => $user->id,
            'order_by_id' => $user->id,
        ];

        $response = $this->putJson(
            route('api.sales-order-directs.update', $salesOrderDirect),
            $data
        );

        $data['id'] = $salesOrderDirect->id;

        $this->assertDatabaseHas('sales_order_directs', $data);

        $response->assertOk()->assertJsonFragment($data);
    }

    /**
     * @test
     */
    public function it_deletes_the_sales_order_direct(): void
    {
        $salesOrderDirect = SalesOrderDirect::factory()->create();

        $response = $this->deleteJson(
            route('api.sales-order-directs.destroy', $salesOrderDirect)
        );

        $this->assertModelMissing($salesOrderDirect);

        $response->assertNoContent();
    }
}
