<?php

namespace Tests\Feature\Api;

use App\Models\User;
use App\Models\Location;

use App\Models\Store;
use App\Models\Regency;
use App\Models\Village;
use App\Models\Province;
use App\Models\District;

use Tests\TestCase;
use Laravel\Sanctum\Sanctum;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;

class LocationTest extends TestCase
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
    public function it_gets_locations_list(): void
    {
        $locations = Location::factory()
            ->count(5)
            ->create();

        $response = $this->getJson(route('api.locations.index'));

        $response->assertOk()->assertSee($locations[0]->name);
    }

    /**
     * @test
     */
    public function it_stores_the_location(): void
    {
        $data = Location::factory()
            ->make()
            ->toArray();

        $response = $this->postJson(route('api.locations.store'), $data);

        $this->assertDatabaseHas('locations', $data);

        $response->assertStatus(201)->assertJsonFragment($data);
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

        $response = $this->putJson(
            route('api.locations.update', $location),
            $data
        );

        $data['id'] = $location->id;

        $this->assertDatabaseHas('locations', $data);

        $response->assertOk()->assertJsonFragment($data);
    }

    /**
     * @test
     */
    public function it_deletes_the_location(): void
    {
        $location = Location::factory()->create();

        $response = $this->deleteJson(
            route('api.locations.destroy', $location)
        );

        $this->assertModelMissing($location);

        $response->assertNoContent();
    }
}
