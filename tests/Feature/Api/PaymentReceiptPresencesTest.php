<?php

namespace Tests\Feature\Api;

use App\Models\User;
use App\Models\Presence;
use App\Models\PaymentReceipt;

use Tests\TestCase;
use Laravel\Sanctum\Sanctum;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;

class PaymentReceiptPresencesTest extends TestCase
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
    public function it_gets_payment_receipt_presences()
    {
        $paymentReceipt = PaymentReceipt::factory()->create();
        $presence = Presence::factory()->create();

        $paymentReceipt->presences()->attach($presence);

        $response = $this->getJson(
            route('api.payment-receipts.presences.index', $paymentReceipt)
        );

        $response->assertOk()->assertSee($presence->date);
    }

    /**
     * @test
     */
    public function it_can_attach_presences_to_payment_receipt()
    {
        $paymentReceipt = PaymentReceipt::factory()->create();
        $presence = Presence::factory()->create();

        $response = $this->postJson(
            route('api.payment-receipts.presences.store', [
                $paymentReceipt,
                $presence,
            ])
        );

        $response->assertNoContent();

        $this->assertTrue(
            $paymentReceipt
                ->presences()
                ->where('presences.id', $presence->id)
                ->exists()
        );
    }

    /**
     * @test
     */
    public function it_can_detach_presences_from_payment_receipt()
    {
        $paymentReceipt = PaymentReceipt::factory()->create();
        $presence = Presence::factory()->create();

        $response = $this->deleteJson(
            route('api.payment-receipts.presences.store', [
                $paymentReceipt,
                $presence,
            ])
        );

        $response->assertNoContent();

        $this->assertFalse(
            $paymentReceipt
                ->presences()
                ->where('presences.id', $presence->id)
                ->exists()
        );
    }
}
