<?php

namespace Tests\Feature\Api;

use App\Models\User;
use App\Models\DeliveryLocation;

use Tests\TestCase;
use Laravel\Sanctum\Sanctum;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;

class UserDeliveryLocationsTest extends TestCase
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
    public function it_gets_user_delivery_locations(): void
    {
        $user = User::factory()->create();
        $deliveryLocations = DeliveryLocation::factory()
            ->count(2)
            ->create([
                'user_id' => $user->id,
            ]);

        $response = $this->getJson(
            route('api.users.delivery-locations.index', $user)
        );

        $response->assertOk()->assertSee($deliveryLocations[0]->label);
    }

    /**
     * @test
     */
    public function it_stores_the_user_delivery_locations(): void
    {
        $user = User::factory()->create();
        $data = DeliveryLocation::factory()
            ->make([
                'user_id' => $user->id,
            ])
            ->toArray();

        $response = $this->postJson(
            route('api.users.delivery-locations.store', $user),
            $data
        );

        $this->assertDatabaseHas('delivery_locations', $data);

        $response->assertStatus(201)->assertJsonFragment($data);

        $deliveryLocation = DeliveryLocation::latest('id')->first();

        $this->assertEquals($user->id, $deliveryLocation->user_id);
    }
}
