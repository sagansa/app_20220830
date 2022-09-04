<?php

namespace Tests\Feature\Api;

use App\Models\User;
use App\Models\PaymentReceipt;
use App\Models\InvoicePurchase;

use Tests\TestCase;
use Laravel\Sanctum\Sanctum;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;

class InvoicePurchasePaymentReceiptsTest extends TestCase
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
    public function it_gets_invoice_purchase_payment_receipts()
    {
        $invoicePurchase = InvoicePurchase::factory()->create();
        $paymentReceipt = PaymentReceipt::factory()->create();

        $invoicePurchase->paymentReceipts()->attach($paymentReceipt);

        $response = $this->getJson(
            route(
                'api.invoice-purchases.payment-receipts.index',
                $invoicePurchase
            )
        );

        $response->assertOk()->assertSee($paymentReceipt->image);
    }

    /**
     * @test
     */
    public function it_can_attach_payment_receipts_to_invoice_purchase()
    {
        $invoicePurchase = InvoicePurchase::factory()->create();
        $paymentReceipt = PaymentReceipt::factory()->create();

        $response = $this->postJson(
            route('api.invoice-purchases.payment-receipts.store', [
                $invoicePurchase,
                $paymentReceipt,
            ])
        );

        $response->assertNoContent();

        $this->assertTrue(
            $invoicePurchase
                ->paymentReceipts()
                ->where('payment_receipts.id', $paymentReceipt->id)
                ->exists()
        );
    }

    /**
     * @test
     */
    public function it_can_detach_payment_receipts_from_invoice_purchase()
    {
        $invoicePurchase = InvoicePurchase::factory()->create();
        $paymentReceipt = PaymentReceipt::factory()->create();

        $response = $this->deleteJson(
            route('api.invoice-purchases.payment-receipts.store', [
                $invoicePurchase,
                $paymentReceipt,
            ])
        );

        $response->assertNoContent();

        $this->assertFalse(
            $invoicePurchase
                ->paymentReceipts()
                ->where('payment_receipts.id', $paymentReceipt->id)
                ->exists()
        );
    }
}
