<?php

namespace Tests\Feature\Api;

use App\Models\User;
use App\Models\FuelService;
use App\Models\ClosingStore;

use Tests\TestCase;
use Laravel\Sanctum\Sanctum;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;

class ClosingStoreFuelServicesTest extends TestCase
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
    public function it_gets_closing_store_fuel_services()
    {
        $closingStore = ClosingStore::factory()->create();
        $fuelService = FuelService::factory()->create();

        $closingStore->fuelServices()->attach($fuelService);

        $response = $this->getJson(
            route('api.closing-stores.fuel-services.index', $closingStore)
        );

        $response->assertOk()->assertSee($fuelService->image);
    }

    /**
     * @test
     */
    public function it_can_attach_fuel_services_to_closing_store()
    {
        $closingStore = ClosingStore::factory()->create();
        $fuelService = FuelService::factory()->create();

        $response = $this->postJson(
            route('api.closing-stores.fuel-services.store', [
                $closingStore,
                $fuelService,
            ])
        );

        $response->assertNoContent();

        $this->assertTrue(
            $closingStore
                ->fuelServices()
                ->where('fuel_services.id', $fuelService->id)
                ->exists()
        );
    }

    /**
     * @test
     */
    public function it_can_detach_fuel_services_from_closing_store()
    {
        $closingStore = ClosingStore::factory()->create();
        $fuelService = FuelService::factory()->create();

        $response = $this->deleteJson(
            route('api.closing-stores.fuel-services.store', [
                $closingStore,
                $fuelService,
            ])
        );

        $response->assertNoContent();

        $this->assertFalse(
            $closingStore
                ->fuelServices()
                ->where('fuel_services.id', $fuelService->id)
                ->exists()
        );
    }
}
