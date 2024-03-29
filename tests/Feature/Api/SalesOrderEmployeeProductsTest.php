<?php

namespace Tests\Feature\Api;

use App\Models\User;
use App\Models\Product;
use App\Models\SalesOrderEmployee;

use Tests\TestCase;
use Laravel\Sanctum\Sanctum;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;

class SalesOrderEmployeeProductsTest extends TestCase
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
    public function it_gets_sales_order_employee_products(): void
    {
        $salesOrderEmployee = SalesOrderEmployee::factory()->create();
        $product = Product::factory()->create();

        $salesOrderEmployee->products()->attach($product);

        $response = $this->getJson(
            route(
                'api.sales-order-employees.products.index',
                $salesOrderEmployee
            )
        );

        $response->assertOk()->assertSee($product->name);
    }

    /**
     * @test
     */
    public function it_can_attach_products_to_sales_order_employee(): void
    {
        $salesOrderEmployee = SalesOrderEmployee::factory()->create();
        $product = Product::factory()->create();

        $response = $this->postJson(
            route('api.sales-order-employees.products.store', [
                $salesOrderEmployee,
                $product,
            ])
        );

        $response->assertNoContent();

        $this->assertTrue(
            $salesOrderEmployee
                ->products()
                ->where('products.id', $product->id)
                ->exists()
        );
    }

    /**
     * @test
     */
    public function it_can_detach_products_from_sales_order_employee(): void
    {
        $salesOrderEmployee = SalesOrderEmployee::factory()->create();
        $product = Product::factory()->create();

        $response = $this->deleteJson(
            route('api.sales-order-employees.products.store', [
                $salesOrderEmployee,
                $product,
            ])
        );

        $response->assertNoContent();

        $this->assertFalse(
            $salesOrderEmployee
                ->products()
                ->where('products.id', $product->id)
                ->exists()
        );
    }
}
