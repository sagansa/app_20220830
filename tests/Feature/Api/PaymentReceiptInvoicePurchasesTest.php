<?php

namespace Tests\Feature\Api;

use App\Models\User;
use App\Models\PaymentReceipt;
use App\Models\InvoicePurchase;

use Tests\TestCase;
use Laravel\Sanctum\Sanctum;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;

class PaymentReceiptInvoicePurchasesTest extends TestCase
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
    public function it_gets_payment_receipt_invoice_purchases()
    {
        $paymentReceipt = PaymentReceipt::factory()->create();
        $invoicePurchase = InvoicePurchase::factory()->create();

        $paymentReceipt->invoicePurchases()->attach($invoicePurchase);

        $response = $this->getJson(
            route(
                'api.payment-receipts.invoice-purchases.index',
                $paymentReceipt
            )
        );

        $response->assertOk()->assertSee($invoicePurchase->image);
    }

    /**
     * @test
     */
    public function it_can_attach_invoice_purchases_to_payment_receipt()
    {
        $paymentReceipt = PaymentReceipt::factory()->create();
        $invoicePurchase = InvoicePurchase::factory()->create();

        $response = $this->postJson(
            route('api.payment-receipts.invoice-purchases.store', [
                $paymentReceipt,
                $invoicePurchase,
            ])
        );

        $response->assertNoContent();

        $this->assertTrue(
            $paymentReceipt
                ->invoicePurchases()
                ->where('invoice_purchases.id', $invoicePurchase->id)
                ->exists()
        );
    }

    /**
     * @test
     */
    public function it_can_detach_invoice_purchases_from_payment_receipt()
    {
        $paymentReceipt = PaymentReceipt::factory()->create();
        $invoicePurchase = InvoicePurchase::factory()->create();

        $response = $this->deleteJson(
            route('api.payment-receipts.invoice-purchases.store', [
                $paymentReceipt,
                $invoicePurchase,
            ])
        );

        $response->assertNoContent();

        $this->assertFalse(
            $paymentReceipt
                ->invoicePurchases()
                ->where('invoice_purchases.id', $invoicePurchase->id)
                ->exists()
        );
    }
}
