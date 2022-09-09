<?php

namespace Tests\Feature\Api;

use App\Models\User;
use App\Models\FuelService;
use App\Models\ClosingStore;

use Tests\TestCase;
use Laravel\Sanctum\Sanctum;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;

class FuelServiceClosingStoresTest extends TestCase
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
    public function it_gets_fuel_service_closing_stores()
    {
        $fuelService = FuelService::factory()->create();
        $closingStore = ClosingStore::factory()->create();

        $fuelService->closingStores()->attach($closingStore);

        $response = $this->getJson(
            route('api.fuel-services.closing-stores.index', $fuelService)
        );

        $response->assertOk()->assertSee($closingStore->date);
    }

    /**
     * @test
     */
    public function it_can_attach_closing_stores_to_fuel_service()
    {
        $fuelService = FuelService::factory()->create();
        $closingStore = ClosingStore::factory()->create();

        $response = $this->postJson(
            route('api.fuel-services.closing-stores.store', [
                $fuelService,
                $closingStore,
            ])
        );

        $response->assertNoContent();

        $this->assertTrue(
            $fuelService
                ->closingStores()
                ->where('closing_stores.id', $closingStore->id)
                ->exists()
        );
    }

    /**
     * @test
     */
    public function it_can_detach_closing_stores_from_fuel_service()
    {
        $fuelService = FuelService::factory()->create();
        $closingStore = ClosingStore::factory()->create();

        $response = $this->deleteJson(
            route('api.fuel-services.closing-stores.store', [
                $fuelService,
                $closingStore,
            ])
        );

        $response->assertNoContent();

        $this->assertFalse(
            $fuelService
                ->closingStores()
                ->where('closing_stores.id', $closingStore->id)
                ->exists()
        );
    }
}
