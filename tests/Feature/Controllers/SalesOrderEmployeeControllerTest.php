<?php

namespace Tests\Feature\Controllers;

use App\Models\User;
use App\Models\SalesOrderEmployee;

use App\Models\Store;
use App\Models\Customer;
use App\Models\DeliveryAddress;

use Tests\TestCase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;

class SalesOrderEmployeeControllerTest extends TestCase
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
    public function it_displays_index_view_with_sales_order_employees()
    {
        $salesOrderEmployees = SalesOrderEmployee::factory()
            ->count(5)
            ->create();

        $response = $this->get(route('sales-order-employees.index'));

        $response
            ->assertOk()
            ->assertViewIs('app.sales_order_employees.index')
            ->assertViewHas('salesOrderEmployees');
    }

    /**
     * @test
     */
    public function it_displays_create_view_for_sales_order_employee()
    {
        $response = $this->get(route('sales-order-employees.create'));

        $response->assertOk()->assertViewIs('app.sales_order_employees.create');
    }

    /**
     * @test
     */
    public function it_stores_the_sales_order_employee()
    {
        $data = SalesOrderEmployee::factory()
            ->make()
            ->toArray();

        $response = $this->post(route('sales-order-employees.store'), $data);

        $this->assertDatabaseHas('sales_order_employees', $data);

        $salesOrderEmployee = SalesOrderEmployee::latest('id')->first();

        $response->assertRedirect(
            route('sales-order-employees.edit', $salesOrderEmployee)
        );
    }

    /**
     * @test
     */
    public function it_displays_show_view_for_sales_order_employee()
    {
        $salesOrderEmployee = SalesOrderEmployee::factory()->create();

        $response = $this->get(
            route('sales-order-employees.show', $salesOrderEmployee)
        );

        $response
            ->assertOk()
            ->assertViewIs('app.sales_order_employees.show')
            ->assertViewHas('salesOrderEmployee');
    }

    /**
     * @test
     */
    public function it_displays_edit_view_for_sales_order_employee()
    {
        $salesOrderEmployee = SalesOrderEmployee::factory()->create();

        $response = $this->get(
            route('sales-order-employees.edit', $salesOrderEmployee)
        );

        $response
            ->assertOk()
            ->assertViewIs('app.sales_order_employees.edit')
            ->assertViewHas('salesOrderEmployee');
    }

    /**
     * @test
     */
    public function it_updates_the_sales_order_employee()
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

        $response = $this->put(
            route('sales-order-employees.update', $salesOrderEmployee),
            $data
        );

        $data['id'] = $salesOrderEmployee->id;

        $this->assertDatabaseHas('sales_order_employees', $data);

        $response->assertRedirect(
            route('sales-order-employees.edit', $salesOrderEmployee)
        );
    }

    /**
     * @test
     */
    public function it_deletes_the_sales_order_employee()
    {
        $salesOrderEmployee = SalesOrderEmployee::factory()->create();

        $response = $this->delete(
            route('sales-order-employees.destroy', $salesOrderEmployee)
        );

        $response->assertRedirect(route('sales-order-employees.index'));

        $this->assertModelMissing($salesOrderEmployee);
    }
}
