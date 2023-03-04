<?php

namespace Tests\Feature\Api;

use App\Models\User;
use App\Models\SalesOrderDirect;

use Tests\TestCase;
use Laravel\Sanctum\Sanctum;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;

class UserSalesOrderDirectsTest extends TestCase
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
    public function it_gets_user_sales_order_directs(): void
    {
        $user = User::factory()->create();
        $salesOrderDirects = SalesOrderDirect::factory()
            ->count(2)
            ->create([
                'order_by_id' => $user->id,
            ]);

        $response = $this->getJson(
            route('api.users.sales-order-directs.index', $user)
        );

        $response->assertOk()->assertSee($salesOrderDirects[0]->delivery_date);
    }

    /**
     * @test
     */
    public function it_stores_the_user_sales_order_directs(): void
    {
        $user = User::factory()->create();
        $data = SalesOrderDirect::factory()
            ->make([
                'order_by_id' => $user->id,
            ])
            ->toArray();

        $response = $this->postJson(
            route('api.users.sales-order-directs.store', $user),
            $data
        );

        $this->assertDatabaseHas('sales_order_directs', $data);

        $response->assertStatus(201)->assertJsonFragment($data);

        $salesOrderDirect = SalesOrderDirect::latest('id')->first();

        $this->assertEquals($user->id, $salesOrderDirect->order_by_id);
    }
}
