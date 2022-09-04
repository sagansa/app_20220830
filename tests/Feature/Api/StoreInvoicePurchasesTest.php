<?php

namespace Tests\Feature\Api;

use App\Models\User;
use App\Models\Store;
use App\Models\InvoicePurchase;

use Tests\TestCase;
use Laravel\Sanctum\Sanctum;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;

class StoreInvoicePurchasesTest extends TestCase
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
    public function it_gets_store_invoice_purchases()
    {
        $store = Store::factory()->create();
        $invoicePurchases = InvoicePurchase::factory()
            ->count(2)
            ->create([
                'store_id' => $store->id,
            ]);

        $response = $this->getJson(
            route('api.stores.invoice-purchases.index', $store)
        );

        $response->assertOk()->assertSee($invoicePurchases[0]->image);
    }

    /**
     * @test
     */
    public function it_stores_the_store_invoice_purchases()
    {
        $store = Store::factory()->create();
        $data = InvoicePurchase::factory()
            ->make([
                'store_id' => $store->id,
            ])
            ->toArray();

        $response = $this->postJson(
            route('api.stores.invoice-purchases.store', $store),
            $data
        );

        unset($data['taxes']);
        unset($data['discounts']);
        unset($data['notes']);
        unset($data['created_by_id']);
        unset($data['approved_id']);

        $this->assertDatabaseHas('invoice_purchases', $data);

        $response->assertStatus(201)->assertJsonFragment($data);

        $invoicePurchase = InvoicePurchase::latest('id')->first();

        $this->assertEquals($store->id, $invoicePurchase->store_id);
    }
}
