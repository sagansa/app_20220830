<?php

namespace Tests\Feature\Controllers;

use App\Models\User;
use App\Models\InvoicePurchase;

use App\Models\Store;
use App\Models\Supplier;
use App\Models\PaymentType;

use Tests\TestCase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;

class InvoicePurchaseControllerTest extends TestCase
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
    public function it_displays_index_view_with_invoice_purchases()
    {
        $invoicePurchases = InvoicePurchase::factory()
            ->count(5)
            ->create();

        $response = $this->get(route('invoice-purchases.index'));

        $response
            ->assertOk()
            ->assertViewIs('app.invoice_purchases.index')
            ->assertViewHas('invoicePurchases');
    }

    /**
     * @test
     */
    public function it_displays_create_view_for_invoice_purchase()
    {
        $response = $this->get(route('invoice-purchases.create'));

        $response->assertOk()->assertViewIs('app.invoice_purchases.create');
    }

    /**
     * @test
     */
    public function it_stores_the_invoice_purchase()
    {
        $data = InvoicePurchase::factory()
            ->make()
            ->toArray();

        $response = $this->post(route('invoice-purchases.store'), $data);

        unset($data['taxes']);
        unset($data['discounts']);
        unset($data['notes']);

        $this->assertDatabaseHas('invoice_purchases', $data);

        $invoicePurchase = InvoicePurchase::latest('id')->first();

        $response->assertRedirect(
            route('invoice-purchases.edit', $invoicePurchase)
        );
    }

    /**
     * @test
     */
    public function it_displays_show_view_for_invoice_purchase()
    {
        $invoicePurchase = InvoicePurchase::factory()->create();

        $response = $this->get(
            route('invoice-purchases.show', $invoicePurchase)
        );

        $response
            ->assertOk()
            ->assertViewIs('app.invoice_purchases.show')
            ->assertViewHas('invoicePurchase');
    }

    /**
     * @test
     */
    public function it_displays_edit_view_for_invoice_purchase()
    {
        $invoicePurchase = InvoicePurchase::factory()->create();

        $response = $this->get(
            route('invoice-purchases.edit', $invoicePurchase)
        );

        $response
            ->assertOk()
            ->assertViewIs('app.invoice_purchases.edit')
            ->assertViewHas('invoicePurchase');
    }

    /**
     * @test
     */
    public function it_updates_the_invoice_purchase()
    {
        $invoicePurchase = InvoicePurchase::factory()->create();

        $paymentType = PaymentType::factory()->create();
        $store = Store::factory()->create();
        $supplier = Supplier::factory()->create();
        $user = User::factory()->create();
        $user = User::factory()->create();

        $data = [
            'date' => $this->faker->date,
            'taxes' => $this->faker->randomNumber,
            'discounts' => $this->faker->randomNumber,
            'notes' => $this->faker->text,
            'payment_status' => $this->faker->numberBetween(1, 3),
            'order_status' => $this->faker->numberBetween(1, 3),
            'payment_type_id' => $paymentType->id,
            'store_id' => $store->id,
            'supplier_id' => $supplier->id,
            'created_by_id' => $user->id,
            'approved_id' => $user->id,
        ];

        $response = $this->put(
            route('invoice-purchases.update', $invoicePurchase),
            $data
        );

        unset($data['taxes']);
        unset($data['discounts']);
        unset($data['notes']);

        $data['id'] = $invoicePurchase->id;

        $this->assertDatabaseHas('invoice_purchases', $data);

        $response->assertRedirect(
            route('invoice-purchases.edit', $invoicePurchase)
        );
    }

    /**
     * @test
     */
    public function it_deletes_the_invoice_purchase()
    {
        $invoicePurchase = InvoicePurchase::factory()->create();

        $response = $this->delete(
            route('invoice-purchases.destroy', $invoicePurchase)
        );

        $response->assertRedirect(route('invoice-purchases.index'));

        $this->assertModelMissing($invoicePurchase);
    }
}
