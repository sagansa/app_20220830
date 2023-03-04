<?php

namespace Tests\Feature\Api;

use App\Models\User;
use App\Models\SalesOrderEmployee;

use App\Models\Store;
use App\Models\Customer;
use App\Models\DeliveryAddress;

use Tests\TestCase;
use Laravel\Sanctum\Sanctum;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;

class SalesOrderEmployeeTest extends TestCase
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
    public function it_gets_sales_order_employees_list(): void
    {
        $salesOrderEmployees = SalesOrderEmployee::factory()
            ->count(5)
            ->create();

        $response = $this->getJson(route('api.sales-order-employees.index'));

        $response->assertOk()->assertSee($salesOrderEmployees[0]->date);
    }

    /**
     * @test
     */
    public function it_stores_the_sales_order_employee(): void
    {
        $data = SalesOrderEmployee::factory()
            ->make()
            ->toArray();

        $response = $this->postJson(
            route('api.sales-order-employees.store'),
            $data
        );

        $this->assertDatabaseHas('sales_order_employees', $data);

        $response->assertStatus(201)->assertJsonFragment($data);
    }

    /**
     * @test
     */
    public function it_updates_the_sales_order_employee(): void
    {
        $salesOrderEmployee = SalesOrderEmployee::factory()->create();

        $customer = Customer::factory()->create();
        $deliveryAddress = DeliveryAddress::factory()->create();
        $store = Store::factory()->create();
        $user = User::factory()->create();

        $data = [
            'date' => $this->faker->date,
            'status' => $this->faker->numberBetween(1, 4),
            'notes' => $this->faker->text,
            'customer_id' => $customer->id,
            'delivery_address_id' => $deliveryAddress->id,
            'store_id' => $store->id,
            'user_id' => $user->id,
        ];

        $response = $this->putJson(
            route('api.sales-order-employees.update', $salesOrderEmployee),
            $data
        );

        $data['id'] = $salesOrderEmployee->id;

        $this->assertDatabaseHas('sales_order_employees', $data);

        $response->assertOk()->assertJsonFragment($data);
    }

    /**
     * @test
     */
    public function it_deletes_the_sales_order_employee(): void
    {
        $salesOrderEmployee = SalesOrderEmployee::factory()->create();

        $response = $this->deleteJson(
            route('api.sales-order-employees.destroy', $salesOrderEmployee)
        );

        $this->assertModelMissing($salesOrderEmployee);

        $response->assertNoContent();
    }
}
