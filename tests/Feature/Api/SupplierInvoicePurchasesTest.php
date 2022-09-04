<?php

namespace Tests\Feature\Api;

use App\Models\User;
use App\Models\Supplier;
use App\Models\InvoicePurchase;

use Tests\TestCase;
use Laravel\Sanctum\Sanctum;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;

class SupplierInvoicePurchasesTest extends TestCase
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
    public function it_gets_supplier_invoice_purchases()
    {
        $supplier = Supplier::factory()->create();
        $invoicePurchases = InvoicePurchase::factory()
            ->count(2)
            ->create([
                'supplier_id' => $supplier->id,
            ]);

        $response = $this->getJson(
            route('api.suppliers.invoice-purchases.index', $supplier)
        );

        $response->assertOk()->assertSee($invoicePurchases[0]->image);
    }

    /**
     * @test
     */
    public function it_stores_the_supplier_invoice_purchases()
    {
        $supplier = Supplier::factory()->create();
        $data = InvoicePurchase::factory()
            ->make([
                'supplier_id' => $supplier->id,
            ])
            ->toArray();

        $response = $this->postJson(
            route('api.suppliers.invoice-purchases.store', $supplier),
            $data
        );

        unset($data['approved_id']);

        $this->assertDatabaseHas('invoice_purchases', $data);

        $response->assertStatus(201)->assertJsonFragment($data);

        $invoicePurchase = InvoicePurchase::latest('id')->first();

        $this->assertEquals($supplier->id, $invoicePurchase->supplier_id);
    }
}
