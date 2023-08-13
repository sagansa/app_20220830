<?php

namespace Tests\Feature\Api;

use App\Models\User;
use App\Models\Location;
use App\Models\ContractLocation;

use Tests\TestCase;
use Laravel\Sanctum\Sanctum;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;

class LocationContractLocationsTest extends TestCase
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
    public function it_gets_location_contract_locations(): void
    {
        $location = Location::factory()->create();
        $contractLocations = ContractLocation::factory()
            ->count(2)
            ->create([
                'location_id' => $location->id,
            ]);

        $response = $this->getJson(
            route('api.locations.contract-locations.index', $location)
        );

        $response->assertOk()->assertSee($contractLocations[0]->from_date);
    }

    /**
     * @test
     */
    public function it_stores_the_location_contract_locations(): void
    {
        $location = Location::factory()->create();
        $data = ContractLocation::factory()
            ->make([
                'location_id' => $location->id,
            ])
            ->toArray();

        $response = $this->postJson(
            route('api.locations.contract-locations.store', $location),
            $data
        );

        $this->assertDatabaseHas('contract_locations', $data);

        $response->assertStatus(201)->assertJsonFragment($data);

        $contractLocation = ContractLocation::latest('id')->first();

        $this->assertEquals($location->id, $contractLocation->location_id);
    }
}
