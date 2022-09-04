<?php

namespace Tests\Feature\Api;

use App\Models\User;
use App\Models\InvoicePurchase;

use App\Models\Store;
use App\Models\Supplier;
use App\Models\PaymentType;

use Tests\TestCase;
use Laravel\Sanctum\Sanctum;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;

class InvoicePurchaseTest extends TestCase
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
    public function it_gets_invoice_purchases_list()
    {
        $invoicePurchases = InvoicePurchase::factory()
            ->count(5)
            ->create();

        $response = $this->getJson(route('api.invoice-purchases.index'));

        $response->assertOk()->assertSee($invoicePurchases[0]->image);
    }

    /**
     * @test
     */
    public function it_stores_the_invoice_purchase()
    {
        $data = InvoicePurchase::factory()
            ->make()
            ->toArray();

        $response = $this->postJson(
            route('api.invoice-purchases.store'),
            $data
        );

        unset($data['taxes']);
        unset($data['discounts']);
        unset($data['notes']);
        unset($data['created_by_id']);
        unset($data['approved_id']);

        $this->assertDatabaseHas('invoice_purchases', $data);

        $response->assertStatus(201)->assertJsonFragment($data);
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

        $response = $this->putJson(
            route('api.invoice-purchases.update', $invoicePurchase),
            $data
        );

        unset($data['taxes']);
        unset($data['discounts']);
        unset($data['notes']);
        unset($data['created_by_id']);
        unset($data['approved_id']);

        $data['id'] = $invoicePurchase->id;

        $this->assertDatabaseHas('invoice_purchases', $data);

        $response->assertOk()->assertJsonFragment($data);
    }

    /**
     * @test
     */
    public function it_deletes_the_invoice_purchase()
    {
        $invoicePurchase = InvoicePurchase::factory()->create();

        $response = $this->deleteJson(
            route('api.invoice-purchases.destroy', $invoicePurchase)
        );

        $this->assertModelMissing($invoicePurchase);

        $response->assertNoContent();
    }
}
