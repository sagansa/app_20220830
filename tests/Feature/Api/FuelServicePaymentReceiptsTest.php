<?php

namespace Tests\Feature\Api;

use App\Models\User;
use App\Models\FuelService;
use App\Models\PaymentReceipt;

use Tests\TestCase;
use Laravel\Sanctum\Sanctum;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;

class FuelServicePaymentReceiptsTest extends TestCase
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
    public function it_gets_fuel_service_payment_receipts()
    {
        $fuelService = FuelService::factory()->create();
        $paymentReceipt = PaymentReceipt::factory()->create();

        $fuelService->paymentReceipts()->attach($paymentReceipt);

        $response = $this->getJson(
            route('api.fuel-services.payment-receipts.index', $fuelService)
        );

        $response->assertOk()->assertSee($paymentReceipt->image);
    }

    /**
     * @test
     */
    public function it_can_attach_payment_receipts_to_fuel_service()
    {
        $fuelService = FuelService::factory()->create();
        $paymentReceipt = PaymentReceipt::factory()->create();

        $response = $this->postJson(
            route('api.fuel-services.payment-receipts.store', [
                $fuelService,
                $paymentReceipt,
            ])
        );

        $response->assertNoContent();

        $this->assertTrue(
            $fuelService
                ->paymentReceipts()
                ->where('payment_receipts.id', $paymentReceipt->id)
                ->exists()
        );
    }

    /**
     * @test
     */
    public function it_can_detach_payment_receipts_from_fuel_service()
    {
        $fuelService = FuelService::factory()->create();
        $paymentReceipt = PaymentReceipt::factory()->create();

        $response = $this->deleteJson(
            route('api.fuel-services.payment-receipts.store', [
                $fuelService,
                $paymentReceipt,
            ])
        );

        $response->assertNoContent();

        $this->assertFalse(
            $fuelService
                ->paymentReceipts()
                ->where('payment_receipts.id', $paymentReceipt->id)
                ->exists()
        );
    }
}
