<?php

namespace Tests\Feature\Api;

use App\Models\User;
use App\Models\DetailInvoice;
use App\Models\InvoicePurchase;

use Tests\TestCase;
use Laravel\Sanctum\Sanctum;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;

class InvoicePurchaseDetailInvoicesTest extends TestCase
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
    public function it_gets_invoice_purchase_detail_invoices(): void
    {
        $invoicePurchase = InvoicePurchase::factory()->create();
        $detailInvoices = DetailInvoice::factory()
            ->count(2)
            ->create([
                'invoice_purchase_id' => $invoicePurchase->id,
            ]);

        $response = $this->getJson(
            route(
                'api.invoice-purchases.detail-invoices.index',
                $invoicePurchase
            )
        );

        $response->assertOk()->assertSee($detailInvoices[0]->id);
    }

    /**
     * @test
     */
    public function it_stores_the_invoice_purchase_detail_invoices(): void
    {
        $invoicePurchase = InvoicePurchase::factory()->create();
        $data = DetailInvoice::factory()
            ->make([
                'invoice_purchase_id' => $invoicePurchase->id,
            ])
            ->toArray();

        $response = $this->postJson(
            route(
                'api.invoice-purchases.detail-invoices.store',
                $invoicePurchase
            ),
            $data
        );

        unset($data['invoice_purchase_id']);
        unset($data['detail_request_id']);

        $this->assertDatabaseHas('detail_invoices', $data);

        $response->assertStatus(201)->assertJsonFragment($data);

        $detailInvoice = DetailInvoice::latest('id')->first();

        $this->assertEquals(
            $invoicePurchase->id,
            $detailInvoice->invoice_purchase_id
        );
    }
}
