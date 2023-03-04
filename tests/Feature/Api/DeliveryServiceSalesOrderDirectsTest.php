<?php

namespace Tests\Feature\Api;

use App\Models\User;
use App\Models\DeliveryService;
use App\Models\SalesOrderDirect;

use Tests\TestCase;
use Laravel\Sanctum\Sanctum;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;

class DeliveryServiceSalesOrderDirectsTest extends TestCase
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
    public function it_gets_delivery_service_sales_order_directs(): void
    {
        $deliveryService = DeliveryService::factory()->create();
        $salesOrderDirects = SalesOrderDirect::factory()
            ->count(2)
            ->create([
                'delivery_service_id' => $deliveryService->id,
            ]);

        $response = $this->getJson(
            route(
                'api.delivery-services.sales-order-directs.index',
                $deliveryService
            )
        );

        $response->assertOk()->assertSee($salesOrderDirects[0]->delivery_date);
    }

    /**
     * @test
     */
    public function it_stores_the_delivery_service_sales_order_directs(): void
    {
        $deliveryService = DeliveryService::factory()->create();
        $data = SalesOrderDirect::factory()
            ->make([
                'delivery_service_id' => $deliveryService->id,
            ])
            ->toArray();

        $response = $this->postJson(
            route(
                'api.delivery-services.sales-order-directs.store',
                $deliveryService
            ),
            $data
        );

        $this->assertDatabaseHas('sales_order_directs', $data);

        $response->assertStatus(201)->assertJsonFragment($data);

        $salesOrderDirect = SalesOrderDirect::latest('id')->first();

        $this->assertEquals(
            $deliveryService->id,
            $salesOrderDirect->delivery_service_id
        );
    }
}
