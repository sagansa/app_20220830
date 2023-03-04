<?php

namespace Tests\Feature\Api;

use App\Models\User;
use App\Models\SoDdetail;
use App\Models\SalesOrderDirect;

use Tests\TestCase;
use Laravel\Sanctum\Sanctum;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;

class SalesOrderDirectSoDdetailsTest extends TestCase
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
    public function it_gets_sales_order_direct_so_ddetails(): void
    {
        $salesOrderDirect = SalesOrderDirect::factory()->create();
        $soDdetails = SoDdetail::factory()
            ->count(2)
            ->create([
                'sales_order_direct_id' => $salesOrderDirect->id,
            ]);

        $response = $this->getJson(
            route(
                'api.sales-order-directs.so-ddetails.index',
                $salesOrderDirect
            )
        );

        $response->assertOk()->assertSee($soDdetails[0]->id);
    }

    /**
     * @test
     */
    public function it_stores_the_sales_order_direct_so_ddetails(): void
    {
        $salesOrderDirect = SalesOrderDirect::factory()->create();
        $data = SoDdetail::factory()
            ->make([
                'sales_order_direct_id' => $salesOrderDirect->id,
            ])
            ->toArray();

        $response = $this->postJson(
            route(
                'api.sales-order-directs.so-ddetails.store',
                $salesOrderDirect
            ),
            $data
        );

        unset($data['sales_order_direct_id']);

        $this->assertDatabaseHas('so_ddetails', $data);

        $response->assertStatus(201)->assertJsonFragment($data);

        $soDdetail = SoDdetail::latest('id')->first();

        $this->assertEquals(
            $salesOrderDirect->id,
            $soDdetail->sales_order_direct_id
        );
    }
}
