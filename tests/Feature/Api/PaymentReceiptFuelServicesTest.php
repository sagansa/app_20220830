<?php

namespace Tests\Feature\Api;

use App\Models\User;
use App\Models\FuelService;
use App\Models\PaymentReceipt;

use Tests\TestCase;
use Laravel\Sanctum\Sanctum;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;

class PaymentReceiptFuelServicesTest extends TestCase
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
    public function it_gets_payment_receipt_fuel_services()
    {
        $paymentReceipt = PaymentReceipt::factory()->create();
        $fuelService = FuelService::factory()->create();

        $paymentReceipt->fuelServices()->attach($fuelService);

        $response = $this->getJson(
            route('api.payment-receipts.fuel-services.index', $paymentReceipt)
        );

        $response->assertOk()->assertSee($fuelService->image);
    }

    /**
     * @test
     */
    public function it_can_attach_fuel_services_to_payment_receipt()
    {
        $paymentReceipt = PaymentReceipt::factory()->create();
        $fuelService = FuelService::factory()->create();

        $response = $this->postJson(
            route('api.payment-receipts.fuel-services.store', [
                $paymentReceipt,
                $fuelService,
            ])
        );

        $response->assertNoContent();

        $this->assertTrue(
            $paymentReceipt
                ->fuelServices()
                ->where('fuel_services.id', $fuelService->id)
                ->exists()
        );
    }

    /**
     * @test
     */
    public function it_can_detach_fuel_services_from_payment_receipt()
    {
        $paymentReceipt = PaymentReceipt::factory()->create();
        $fuelService = FuelService::factory()->create();

        $response = $this->deleteJson(
            route('api.payment-receipts.fuel-services.store', [
                $paymentReceipt,
                $fuelService,
            ])
        );

        $response->assertNoContent();

        $this->assertFalse(
            $paymentReceipt
                ->fuelServices()
                ->where('fuel_services.id', $fuelService->id)
                ->exists()
        );
    }
}
