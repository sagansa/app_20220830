<?php

namespace Tests\Feature\Controllers;

use App\Models\User;
use App\Models\Location;

use App\Models\Store;
use App\Models\Regency;
use App\Models\Village;
use App\Models\Province;
use App\Models\District;

use Tests\TestCase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;

class LocationControllerTest extends TestCase
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
    public function it_displays_index_view_with_locations(): void
    {
        $locations = Location::factory()
            ->count(5)
            ->create();

        $response = $this->get(route('locations.index'));

        $response
            ->assertOk()
            ->assertViewIs('app.locations.index')
            ->assertViewHas('locations');
    }

    /**
     * @test
     */
    public function it_displays_create_view_for_location(): void
    {
        $response = $this->get(route('locations.create'));

        $response->assertOk()->assertViewIs('app.locations.create');
    }

    /**
     * @test
     */
    public function it_stores_the_location(): void
    {
        $data = Location::factory()
            ->make()
            ->toArray();

        $response = $this->post(route('locations.store'), $data);

        $this->assertDatabaseHas('locations', $data);

        $location = Location::latest('id')->first();

        $response->assertRedirect(route('locations.edit', $location));
    }

    /**
     * @test
     */
    public function it_displays_show_view_for_location(): void
    {
        $location = Location::factory()->create();

        $response = $this->get(route('locations.show', $location));

        $response
            ->assertOk()
            ->assertViewIs('app.locations.show')
            ->assertViewHas('location');
    }

    /**
     * @test
     */
    public function it_displays_edit_view_for_location(): void
    {
        $location = Location::factory()->create();

        $response = $this->get(route('locations.edit', $location));

        $response
            ->assertOk()
            ->assertViewIs('app.locations.edit')
            ->assertViewHas('location');
    }

    /**
     * @test
     */
    public function it_updates_the_location(): void
    {
        $location = Location::factory()->create();

        $store = Store::factory()->create();
        $province = Province::factory()->create();
        $regency = Regency::factory()->create();
        $district = District::factory()->create();
        $village = Village::factory()->create();

        $data = [
            'name' => $this->faker->name(),
            'contact_person_name' => $this->faker->text(255),
            'contact_person_number' => $this->faker->text(255),
            'address' => $this->faker->text(),
            'codepos' => $this->faker->randomNumber(0),
            'store_id' => $store->id,
            'province_id' => $province->id,
            'regency_id' => $regency->id,
            'district_id' => $district->id,
            'village_id' => $village->id,
        ];

        $response = $this->put(route('locations.update', $location), $data);

        $data['id'] = $location->id;

        $this->assertDatabaseHas('locations', $data);

        $response->assertRedirect(route('locations.edit', $location));
    }

    /**
     * @test
     */
    public function it_deletes_the_location(): void
    {
        $location = Location::factory()->create();

        $response = $this->delete(route('locations.destroy', $location));

        $response->assertRedirect(route('locations.index'));

        $this->assertModelMissing($location);
    }
}
