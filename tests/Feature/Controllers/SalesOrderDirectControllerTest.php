<?php

namespace Tests\Feature\Controllers;

use App\Models\User;
use App\Models\SalesOrderDirect;

use App\Models\Store;
use App\Models\DeliveryService;
use App\Models\DeliveryLocation;
use App\Models\TransferToAccount;

use Tests\TestCase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;

class SalesOrderDirectControllerTest extends TestCase
{
    use RefreshDatabase, WithFaker;

    protected function setUp(): void
    {
        parent::setUp();

        $this->actingAs(
            User::factory()->create(['email' => 'admin@admin.com'])
        );

        $this->seed(\Database\Seeders\PermissionsSeeder::class);

        $this->withoutExceptionHandling();
    }

    /**
     * @test
     */
    public function it_displays_index_view_with_sales_order_directs(): void
    {
        $salesOrderDirects = SalesOrderDirect::factory()
            ->count(5)
            ->create();

        $response = $this->get(route('sales-order-directs.index'));

        $response
            ->assertOk()
            ->assertViewIs('app.sales_order_directs.index')
            ->assertViewHas('salesOrderDirects');
    }

    /**
     * @test
     */
    public function it_displays_create_view_for_sales_order_direct(): void
    {
        $response = $this->get(route('sales-order-directs.create'));

        $response->assertOk()->assertViewIs('app.sales_order_directs.create');
    }

    /**
     * @test
     */
    public function it_stores_the_sales_order_direct(): void
    {
        $data = SalesOrderDirect::factory()
            ->make()
            ->toArray();

        $response = $this->post(route('sales-order-directs.store'), $data);

        $this->assertDatabaseHas('sales_order_directs', $data);

        $salesOrderDirect = SalesOrderDirect::latest('id')->first();

        $response->assertRedirect(
            route('sales-order-directs.edit', $salesOrderDirect)
        );
    }

    /**
     * @test
     */
    public function it_displays_show_view_for_sales_order_direct(): void
    {
        $salesOrderDirect = SalesOrderDirect::factory()->create();

        $response = $this->get(
            route('sales-order-directs.show', $salesOrderDirect)
        );

        $response
            ->assertOk()
            ->assertViewIs('app.sales_order_directs.show')
            ->assertViewHas('salesOrderDirect');
    }

    /**
     * @test
     */
    public function it_displays_edit_view_for_sales_order_direct(): void
    {
        $salesOrderDirect = SalesOrderDirect::factory()->create();

        $response = $this->get(
            route('sales-order-directs.edit', $salesOrderDirect)
        );

        $response
            ->assertOk()
            ->assertViewIs('app.sales_order_directs.edit')
            ->assertViewHas('salesOrderDirect');
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
        $deliveryLocation = DeliveryLocation::factory()->create();

        $data = [
            'delivery_date' => $this->faker->date,
            'payment_status' => $this->faker->numberBetween(0, 127),
            'delivery_status' => $this->faker->numberBetween(0, 127),
            'shipping_cost' => $this->faker->randomNumber,
            'image_receipt' => $this->faker->text(255),
            'received_by' => $this->faker->text(255),
            'sign' => $this->faker->text(255),
            'discounts' => $this->faker->randomNumber,
            'notes' => $this->faker->text,
            'store_id' => $store->id,
            'delivery_service_id' => $deliveryService->id,
            'transfer_to_account_id' => $transferToAccount->id,
            'submitted_by_id' => $user->id,
            'order_by_id' => $user->id,
            'delivery_location_id' => $deliveryLocation->id,
        ];

        $response = $this->put(
            route('sales-order-directs.update', $salesOrderDirect),
            $data
        );

        $data['id'] = $salesOrderDirect->id;

        $this->assertDatabaseHas('sales_order_directs', $data);

        $response->assertRedirect(
            route('sales-order-directs.edit', $salesOrderDirect)
        );
    }

    /**
     * @test
     */
    public function it_deletes_the_sales_order_direct(): void
    {
        $salesOrderDirect = SalesOrderDirect::factory()->create();

        $response = $this->delete(
            route('sales-order-directs.destroy', $salesOrderDirect)
        );

        $response->assertRedirect(route('sales-order-directs.index'));

        $this->assertModelMissing($salesOrderDirect);
    }
}
