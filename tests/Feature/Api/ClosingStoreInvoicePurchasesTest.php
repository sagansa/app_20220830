<?php

namespace Tests\Feature\Api;

use App\Models\User;
use App\Models\ClosingStore;
use App\Models\InvoicePurchase;

use Tests\TestCase;
use Laravel\Sanctum\Sanctum;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;

class ClosingStoreInvoicePurchasesTest extends TestCase
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
    public function it_gets_closing_store_invoice_purchases(): void
    {
        $closingStore = ClosingStore::factory()->create();
        $invoicePurchase = InvoicePurchase::factory()->create();

        $closingStore->invoicePurchases()->attach($invoicePurchase);

        $response = $this->getJson(
            route('api.closing-stores.invoice-purchases.index', $closingStore)
        );

        $response->assertOk()->assertSee($invoicePurchase->image);
    }

    /**
     * @test
     */
    public function it_can_attach_invoice_purchases_to_closing_store(): void
    {
        $closingStore = ClosingStore::factory()->create();
        $invoicePurchase = InvoicePurchase::factory()->create();

        $response = $this->postJson(
            route('api.closing-stores.invoice-purchases.store', [
                $closingStore,
                $invoicePurchase,
            ])
        );

        $response->assertNoContent();

        $this->assertTrue(
            $closingStore
                ->invoicePurchases()
                ->where('invoice_purchases.id', $invoicePurchase->id)
                ->exists()
        );
    }

    /**
     * @test
     */
    public function it_can_detach_invoice_purchases_from_closing_store(): void
    {
        $closingStore = ClosingStore::factory()->create();
        $invoicePurchase = InvoicePurchase::factory()->create();

        $response = $this->deleteJson(
            route('api.closing-stores.invoice-purchases.store', [
                $closingStore,
                $invoicePurchase,
            ])
        );

        $response->assertNoContent();

        $this->assertFalse(
            $closingStore
                ->invoicePurchases()
                ->where('invoice_purchases.id', $invoicePurchase->id)
                ->exists()
        );
    }
}
