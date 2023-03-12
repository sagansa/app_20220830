<?php

namespace Tests\Feature\Api;

use App\Models\User;
use App\Models\Coupon;
use App\Models\SalesOrderDirect;

use Tests\TestCase;
use Laravel\Sanctum\Sanctum;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;

class CouponSalesOrderDirectsTest extends TestCase
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
    public function it_gets_coupon_sales_order_directs(): void
    {
        $coupon = Coupon::factory()->create();
        $salesOrderDirects = SalesOrderDirect::factory()
            ->count(2)
            ->create([
                'coupon_id' => $coupon->id,
            ]);

        $response = $this->getJson(
            route('api.coupons.sales-order-directs.index', $coupon)
        );

        $response->assertOk()->assertSee($salesOrderDirects[0]->delivery_date);
    }

    /**
     * @test
     */
    public function it_stores_the_coupon_sales_order_directs(): void
    {
        $coupon = Coupon::factory()->create();
        $data = SalesOrderDirect::factory()
            ->make([
                'coupon_id' => $coupon->id,
            ])
            ->toArray();

        $response = $this->postJson(
            route('api.coupons.sales-order-directs.store', $coupon),
            $data
        );

        $this->assertDatabaseHas('sales_order_directs', $data);

        $response->assertStatus(201)->assertJsonFragment($data);

        $salesOrderDirect = SalesOrderDirect::latest('id')->first();

        $this->assertEquals($coupon->id, $salesOrderDirect->coupon_id);
    }
}
