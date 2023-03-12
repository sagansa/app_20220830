<?php

namespace Tests\Feature\Controllers;

use App\Models\User;
use App\Models\DeliveryLocation;

use App\Models\Regency;
use App\Models\Village;
use App\Models\Province;
use App\Models\District;

use Tests\TestCase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;

class DeliveryLocationControllerTest extends TestCase
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
    public function it_displays_index_view_with_delivery_locations(): void
    {
        $deliveryLocations = DeliveryLocation::factory()
            ->count(5)
            ->create();

        $response = $this->get(route('delivery-locations.index'));

        $response
            ->assertOk()
            ->assertViewIs('app.delivery_locations.index')
            ->assertViewHas('deliveryLocations');
    }

    /**
     * @test
     */
    public function it_displays_create_view_for_delivery_location(): void
    {
        $response = $this->get(route('delivery-locations.create'));

        $response->assertOk()->assertViewIs('app.delivery_locations.create');
    }

    /**
     * @test
     */
    public function it_stores_the_delivery_location(): void
    {
        $data = DeliveryLocation::factory()
            ->make()
            ->toArray();

        $response = $this->post(route('delivery-locations.store'), $data);

        $this->assertDatabaseHas('delivery_locations', $data);

        $deliveryLocation = DeliveryLocation::latest('id')->first();

        $response->assertRedirect(
            route('delivery-locations.edit', $deliveryLocation)
        );
    }

    /**
     * @test
     */
    public function it_displays_show_view_for_delivery_location(): void
    {
        $deliveryLocation = DeliveryLocation::factory()->create();

        $response = $this->get(
            route('delivery-locations.show', $deliveryLocation)
        );

        $response
            ->assertOk()
            ->assertViewIs('app.delivery_locations.show')
            ->assertViewHas('deliveryLocation');
    }

    /**
     * @test
     */
    public function it_displays_edit_view_for_delivery_location(): void
    {
        $deliveryLocation = DeliveryLocation::factory()->create();

        $response = $this->get(
            route('delivery-locations.edit', $deliveryLocation)
        );

        $response
            ->assertOk()
            ->assertViewIs('app.delivery_locations.edit')
            ->assertViewHas('deliveryLocation');
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

        $response = $this->put(
            route('delivery-locations.update', $deliveryLocation),
            $data
        );

        $data['id'] = $deliveryLocation->id;

        $this->assertDatabaseHas('delivery_locations', $data);

        $response->assertRedirect(
            route('delivery-locations.edit', $deliveryLocation)
        );
    }

    /**
     * @test
     */
    public function it_deletes_the_delivery_location(): void
    {
        $deliveryLocation = DeliveryLocation::factory()->create();

        $response = $this->delete(
            route('delivery-locations.destroy', $deliveryLocation)
        );

        $response->assertRedirect(route('delivery-locations.index'));

        $this->assertModelMissing($deliveryLocation);
    }
}
