<?php

namespace Tests\Feature\Controllers;

use App\Models\User;
use App\Models\ContractLocation;

use App\Models\Location;

use Tests\TestCase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;

class ContractLocationControllerTest extends TestCase
{
    use RefreshDatabase, WithFaker;

    protected function setUp(): void
    {
        parent::setUp();

        $this->actingAs(
            User::factory()->create(['email' => 'admin@admin.com'])
        );

        $this->seed(\Database\Seeders\PermissionsSeeder::class);

        $this->withoutExceptionHandling();
    }

    /**
     * @test
     */
    public function it_displays_index_view_with_contract_locations(): void
    {
        $contractLocations = ContractLocation::factory()
            ->count(5)
            ->create();

        $response = $this->get(route('contract-locations.index'));

        $response
            ->assertOk()
            ->assertViewIs('app.contract_locations.index')
            ->assertViewHas('contractLocations');
    }

    /**
     * @test
     */
    public function it_displays_create_view_for_contract_location(): void
    {
        $response = $this->get(route('contract-locations.create'));

        $response->assertOk()->assertViewIs('app.contract_locations.create');
    }

    /**
     * @test
     */
    public function it_stores_the_contract_location(): void
    {
        $data = ContractLocation::factory()
            ->make()
            ->toArray();

        $response = $this->post(route('contract-locations.store'), $data);

        $this->assertDatabaseHas('contract_locations', $data);

        $contractLocation = ContractLocation::latest('id')->first();

        $response->assertRedirect(
            route('contract-locations.edit', $contractLocation)
        );
    }

    /**
     * @test
     */
    public function it_displays_show_view_for_contract_location(): void
    {
        $contractLocation = ContractLocation::factory()->create();

        $response = $this->get(
            route('contract-locations.show', $contractLocation)
        );

        $response
            ->assertOk()
            ->assertViewIs('app.contract_locations.show')
            ->assertViewHas('contractLocation');
    }

    /**
     * @test
     */
    public function it_displays_edit_view_for_contract_location(): void
    {
        $contractLocation = ContractLocation::factory()->create();

        $response = $this->get(
            route('contract-locations.edit', $contractLocation)
        );

        $response
            ->assertOk()
            ->assertViewIs('app.contract_locations.edit')
            ->assertViewHas('contractLocation');
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

        $response = $this->put(
            route('contract-locations.update', $contractLocation),
            $data
        );

        $data['id'] = $contractLocation->id;

        $this->assertDatabaseHas('contract_locations', $data);

        $response->assertRedirect(
            route('contract-locations.edit', $contractLocation)
        );
    }

    /**
     * @test
     */
    public function it_deletes_the_contract_location(): void
    {
        $contractLocation = ContractLocation::factory()->create();

        $response = $this->delete(
            route('contract-locations.destroy', $contractLocation)
        );

        $response->assertRedirect(route('contract-locations.index'));

        $this->assertModelMissing($contractLocation);
    }
}
