<?php

namespace Tests\Feature\Api;

use App\Models\User;
use App\Models\DeliveryLocation;
use App\Models\SalesOrderDirect;

use Tests\TestCase;
use Laravel\Sanctum\Sanctum;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;

class DeliveryLocationSalesOrderDirectsTest extends TestCase
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
    public function it_gets_delivery_location_sales_order_directs(): void
    {
        $deliveryLocation = DeliveryLocation::factory()->create();
        $salesOrderDirects = SalesOrderDirect::factory()
            ->count(2)
            ->create([
                'delivery_location_id' => $deliveryLocation->id,
            ]);

        $response = $this->getJson(
            route(
                'api.delivery-locations.sales-order-directs.index',
                $deliveryLocation
            )
        );

        $response->assertOk()->assertSee($salesOrderDirects[0]->delivery_date);
    }

    /**
     * @test
     */
    public function it_stores_the_delivery_location_sales_order_directs(): void
    {
        $deliveryLocation = DeliveryLocation::factory()->create();
        $data = SalesOrderDirect::factory()
            ->make([
                'delivery_location_id' => $deliveryLocation->id,
            ])
            ->toArray();

        $response = $this->postJson(
            route(
                'api.delivery-locations.sales-order-directs.store',
                $deliveryLocation
            ),
            $data
        );

        $this->assertDatabaseHas('sales_order_directs', $data);

        $response->assertStatus(201)->assertJsonFragment($data);

        $salesOrderDirect = SalesOrderDirect::latest('id')->first();

        $this->assertEquals(
            $deliveryLocation->id,
            $salesOrderDirect->delivery_location_id
        );
    }
}
