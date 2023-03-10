<?php

namespace Tests\Feature\Api;

use App\Models\User;
use App\Models\SalesOrderDirect;
use App\Models\SalesOrderDirectProduct;

use Tests\TestCase;
use Laravel\Sanctum\Sanctum;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;

class SalesOrderDirectSalesOrderDirectProductsTest extends TestCase
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
    public function it_gets_sales_order_direct_sales_order_direct_products(): void
    {
        $salesOrderDirect = SalesOrderDirect::factory()->create();
        $salesOrderDirectProducts = SalesOrderDirectProduct::factory()
            ->count(2)
            ->create([
                'sales_order_direct_id' => $salesOrderDirect->id,
            ]);

        $response = $this->getJson(
            route(
                'api.sales-order-directs.sales-order-direct-products.index',
                $salesOrderDirect
            )
        );

        $response->assertOk()->assertSee($salesOrderDirectProducts[0]->id);
    }

    /**
     * @test
     */
    public function it_stores_the_sales_order_direct_sales_order_direct_products(): void
    {
        $salesOrderDirect = SalesOrderDirect::factory()->create();
        $data = SalesOrderDirectProduct::factory()
            ->make([
                'sales_order_direct_id' => $salesOrderDirect->id,
            ])
            ->toArray();

        $response = $this->postJson(
            route(
                'api.sales-order-directs.sales-order-direct-products.store',
                $salesOrderDirect
            ),
            $data
        );

        unset($data['sales_order_direct_id']);

        $this->assertDatabaseHas('sales_order_direct_products', $data);

        $response->assertStatus(201)->assertJsonFragment($data);

        $salesOrderDirectProduct = SalesOrderDirectProduct::latest(
            'id'
        )->first();

        $this->assertEquals(
            $salesOrderDirect->id,
            $salesOrderDirectProduct->sales_order_direct_id
        );
    }
}
