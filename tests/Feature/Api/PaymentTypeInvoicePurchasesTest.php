<?php

namespace Tests\Feature\Api;

use App\Models\User;
use App\Models\PaymentType;
use App\Models\InvoicePurchase;

use Tests\TestCase;
use Laravel\Sanctum\Sanctum;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;

class PaymentTypeInvoicePurchasesTest extends TestCase
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
    public function it_gets_payment_type_invoice_purchases()
    {
        $paymentType = PaymentType::factory()->create();
        $invoicePurchases = InvoicePurchase::factory()
            ->count(2)
            ->create([
                'payment_type_id' => $paymentType->id,
            ]);

        $response = $this->getJson(
            route('api.payment-types.invoice-purchases.index', $paymentType)
        );

        $response->assertOk()->assertSee($invoicePurchases[0]->image);
    }

    /**
     * @test
     */
    public function it_stores_the_payment_type_invoice_purchases()
    {
        $paymentType = PaymentType::factory()->create();
        $data = InvoicePurchase::factory()
            ->make([
                'payment_type_id' => $paymentType->id,
            ])
            ->toArray();

        $response = $this->postJson(
            route('api.payment-types.invoice-purchases.store', $paymentType),
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

        $this->assertEquals(
            $paymentType->id,
            $invoicePurchase->payment_type_id
        );
    }
}
