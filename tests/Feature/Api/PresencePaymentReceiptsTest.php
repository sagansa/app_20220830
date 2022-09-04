<?php

namespace Tests\Feature\Api;

use App\Models\User;
use App\Models\Presence;
use App\Models\PaymentReceipt;

use Tests\TestCase;
use Laravel\Sanctum\Sanctum;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;

class PresencePaymentReceiptsTest extends TestCase
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
    public function it_gets_presence_payment_receipts()
    {
        $presence = Presence::factory()->create();
        $paymentReceipt = PaymentReceipt::factory()->create();

        $presence->paymentReceipts()->attach($paymentReceipt);

        $response = $this->getJson(
            route('api.presences.payment-receipts.index', $presence)
        );

        $response->assertOk()->assertSee($paymentReceipt->image);
    }

    /**
     * @test
     */
    public function it_can_attach_payment_receipts_to_presence()
    {
        $presence = Presence::factory()->create();
        $paymentReceipt = PaymentReceipt::factory()->create();

        $response = $this->postJson(
            route('api.presences.payment-receipts.store', [
                $presence,
                $paymentReceipt,
            ])
        );

        $response->assertNoContent();

        $this->assertTrue(
            $presence
                ->paymentReceipts()
                ->where('payment_receipts.id', $paymentReceipt->id)
                ->exists()
        );
    }

    /**
     * @test
     */
    public function it_can_detach_payment_receipts_from_presence()
    {
        $presence = Presence::factory()->create();
        $paymentReceipt = PaymentReceipt::factory()->create();

        $response = $this->deleteJson(
            route('api.presences.payment-receipts.store', [
                $presence,
                $paymentReceipt,
            ])
        );

        $response->assertNoContent();

        $this->assertFalse(
            $presence
                ->paymentReceipts()
                ->where('payment_receipts.id', $paymentReceipt->id)
                ->exists()
        );
    }
}
