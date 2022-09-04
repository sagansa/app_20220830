<?php

namespace Tests\Feature\Api;

use App\Models\User;
use App\Models\ClosingStore;
use App\Models\InvoicePurchase;

use Tests\TestCase;
use Laravel\Sanctum\Sanctum;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;

class InvoicePurchaseClosingStoresTest extends TestCase
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
    public function it_gets_invoice_purchase_closing_stores()
    {
        $invoicePurchase = InvoicePurchase::factory()->create();
        $closingStore = ClosingStore::factory()->create();

        $invoicePurchase->closingStores()->attach($closingStore);

        $response = $this->getJson(
            route(
                'api.invoice-purchases.closing-stores.index',
                $invoicePurchase
            )
        );

        $response->assertOk()->assertSee($closingStore->date);
    }

    /**
     * @test
     */
    public function it_can_attach_closing_stores_to_invoice_purchase()
    {
        $invoicePurchase = InvoicePurchase::factory()->create();
        $closingStore = ClosingStore::factory()->create();

        $response = $this->postJson(
            route('api.invoice-purchases.closing-stores.store', [
                $invoicePurchase,
                $closingStore,
            ])
        );

        $response->assertNoContent();

        $this->assertTrue(
            $invoicePurchase
                ->closingStores()
                ->where('closing_stores.id', $closingStore->id)
                ->exists()
        );
    }

    /**
     * @test
     */
    public function it_can_detach_closing_stores_from_invoice_purchase()
    {
        $invoicePurchase = InvoicePurchase::factory()->create();
        $closingStore = ClosingStore::factory()->create();

        $response = $this->deleteJson(
            route('api.invoice-purchases.closing-stores.store', [
                $invoicePurchase,
                $closingStore,
            ])
        );

        $response->assertNoContent();

        $this->assertFalse(
            $invoicePurchase
                ->closingStores()
                ->where('closing_stores.id', $closingStore->id)
                ->exists()
        );
    }
}
