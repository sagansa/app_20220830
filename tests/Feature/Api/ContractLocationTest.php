<?php

namespace Tests\Feature\Api;

use App\Models\User;
use App\Models\ContractLocation;

use App\Models\Location;

use Tests\TestCase;
use Laravel\Sanctum\Sanctum;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;

class ContractLocationTest extends TestCase
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
    public function it_gets_contract_locations_list(): void
    {
        $contractLocations = ContractLocation::factory()
            ->count(5)
            ->create();

        $response = $this->getJson(route('api.contract-locations.index'));

        $response->assertOk()->assertSee($contractLocations[0]->from_date);
    }

    /**
     * @test
     */
    public function it_stores_the_contract_location(): void
    {
        $data = ContractLocation::factory()
            ->make()
            ->toArray();

        $response = $this->postJson(
            route('api.contract-locations.store'),
            $data
        );

        $this->assertDatabaseHas('contract_locations', $data);

        $response->assertStatus(201)->assertJsonFragment($data);
    }

    /**
     * @test
     */
    public function it_updates_the_contract_location(): void
    {
        $contractLocation = ContractLocation::factory()->create();

        $location = Location::factory()->create();

        $data = [
            'from_date' => $this->faker->date,
            'until_date' => $this->faker->date,
            'nominal_contract' => $this->faker->randomNumber,
            'location_id' => $location->id,
        ];

        $response = $this->putJson(
            route('api.contract-locations.update', $contractLocation),
            $data
        );

        $data['id'] = $contractLocation->id;

        $this->assertDatabaseHas('contract_locations', $data);

        $response->assertOk()->assertJsonFragment($data);
    }

    /**
     * @test
     */
    public function it_deletes_the_contract_location(): void
    {
        $contractLocation = ContractLocation::factory()->create();

        $response = $this->deleteJson(
            route('api.contract-locations.destroy', $contractLocation)
        );

        $this->assertModelMissing($contractLocation);

        $response->assertNoContent();
    }
}
