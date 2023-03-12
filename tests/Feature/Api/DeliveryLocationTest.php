<?php

namespace Tests\Feature\Api;

use App\Models\User;
use App\Models\DeliveryLocation;

use App\Models\Regency;
use App\Models\Village;
use App\Models\Province;
use App\Models\District;

use Tests\TestCase;
use Laravel\Sanctum\Sanctum;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;

class DeliveryLocationTest extends TestCase
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
    public function it_gets_delivery_locations_list(): void
    {
        $deliveryLocations = DeliveryLocation::factory()
            ->count(5)
            ->create();

        $response = $this->getJson(route('api.delivery-locations.index'));

        $response->assertOk()->assertSee($deliveryLocations[0]->label);
    }

    /**
     * @test
     */
    public function it_stores_the_delivery_location(): void
    {
        $data = DeliveryLocation::factory()
            ->make()
            ->toArray();

        $response = $this->postJson(
            route('api.delivery-locations.store'),
            $data
        );

        $this->assertDatabaseHas('delivery_locations', $data);

        $response->assertStatus(201)->assertJsonFragment($data);
    }

    /**
     * @test
     */
    public function it_updates_the_delivery_location(): void
    {
        $deliveryLocation = DeliveryLocation::factory()->create();

        $user = User::factory()->create();
        $province = Province::factory()->create();
        $regency = Regency::factory()->create();
        $district = District::factory()->create();
        $village = Village::factory()->create();

        $data = [
            'label' => $this->faker->name(),
            'contact_name' => $this->faker->text(255),
            'contact_number' => $this->faker->text(255),
            'address' => $this->faker->address,
            'user_id' => $user->id,
            'province_id' => $province->id,
            'regency_id' => $regency->id,
            'district_id' => $district->id,
            'village_id' => $village->id,
        ];

        $response = $this->putJson(
            route('api.delivery-locations.update', $deliveryLocation),
            $data
        );

        $data['id'] = $deliveryLocation->id;

        $this->assertDatabaseHas('delivery_locations', $data);

        $response->assertOk()->assertJsonFragment($data);
    }

    /**
     * @test
     */
    public function it_deletes_the_delivery_location(): void
    {
        $deliveryLocation = DeliveryLocation::factory()->create();

        $response = $this->deleteJson(
            route('api.delivery-locations.destroy', $deliveryLocation)
        );

        $this->assertModelMissing($deliveryLocation);

        $response->assertNoContent();
    }
}
