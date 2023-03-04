<?php

namespace Tests\Feature\Api;

use App\Models\User;
use App\Models\SalesOrderDirect;
use App\Models\TransferToAccount;

use Tests\TestCase;
use Laravel\Sanctum\Sanctum;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;

class TransferToAccountSalesOrderDirectsTest extends TestCase
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
    public function it_gets_transfer_to_account_sales_order_directs(): void
    {
        $transferToAccount = TransferToAccount::factory()->create();
        $salesOrderDirects = SalesOrderDirect::factory()
            ->count(2)
            ->create([
                'transfer_to_account_id' => $transferToAccount->id,
            ]);

        $response = $this->getJson(
            route(
                'api.transfer-to-accounts.sales-order-directs.index',
                $transferToAccount
            )
        );

        $response->assertOk()->assertSee($salesOrderDirects[0]->delivery_date);
    }

    /**
     * @test
     */
    public function it_stores_the_transfer_to_account_sales_order_directs(): void
    {
        $transferToAccount = TransferToAccount::factory()->create();
        $data = SalesOrderDirect::factory()
            ->make([
                'transfer_to_account_id' => $transferToAccount->id,
            ])
            ->toArray();

        $response = $this->postJson(
            route(
                'api.transfer-to-accounts.sales-order-directs.store',
                $transferToAccount
            ),
            $data
        );

        $this->assertDatabaseHas('sales_order_directs', $data);

        $response->assertStatus(201)->assertJsonFragment($data);

        $salesOrderDirect = SalesOrderDirect::latest('id')->first();

        $this->assertEquals(
            $transferToAccount->id,
            $salesOrderDirect->transfer_to_account_id
        );
    }
}
