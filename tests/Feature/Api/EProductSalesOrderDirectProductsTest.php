<?php

namespace Tests\Feature\Api;

use App\Models\User;
use App\Models\EProduct;
use App\Models\SalesOrderDirectProduct;

use Tests\TestCase;
use Laravel\Sanctum\Sanctum;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;

class EProductSalesOrderDirectProductsTest extends TestCase
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
    public function it_gets_e_product_sales_order_direct_products(): void
    {
        $eProduct = EProduct::factory()->create();
        $salesOrderDirectProducts = SalesOrderDirectProduct::factory()
            ->count(2)
            ->create([
                'e_product_id' => $eProduct->id,
            ]);

        $response = $this->getJson(
            route('api.e-products.sales-order-direct-products.index', $eProduct)
        );

        $response->assertOk()->assertSee($salesOrderDirectProducts[0]->id);
    }

    /**
     * @test
     */
    public function it_stores_the_e_product_sales_order_direct_products(): void
    {
        $eProduct = EProduct::factory()->create();
        $data = SalesOrderDirectProduct::factory()
            ->make([
                'e_product_id' => $eProduct->id,
            ])
            ->toArray();

        $response = $this->postJson(
            route(
                'api.e-products.sales-order-direct-products.store',
                $eProduct
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
            $eProduct->id,
            $salesOrderDirectProduct->e_product_id
        );
    }
}
