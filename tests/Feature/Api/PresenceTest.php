<?php

namespace Tests\Feature\Api;

use App\Models\User;
use App\Models\Presence;

use App\Models\Store;
use App\Models\ShiftStore;

use Tests\TestCase;
use Laravel\Sanctum\Sanctum;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;

class PresenceTest extends TestCase
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
    public function it_gets_presences_list(): void
    {
        $presences = Presence::factory()
            ->count(5)
            ->create();

        $response = $this->getJson(route('api.presences.index'));

        $response->assertOk()->assertSee($presences[0]->image_in);
    }

    /**
     * @test
     */
    public function it_stores_the_presence(): void
    {
        $data = Presence::factory()
            ->make()
            ->toArray();

        $response = $this->postJson(route('api.presences.store'), $data);

        $this->assertDatabaseHas('presences', $data);

        $response->assertStatus(201)->assertJsonFragment($data);
    }

    /**
     * @test
     */
    public function it_updates_the_presence(): void
    {
        $presence = Presence::factory()->create();

        $user = User::factory()->create();
        $user = User::factory()->create();
        $store = Store::factory()->create();
        $shiftStore = ShiftStore::factory()->create();

        $data = [
            'status' => $this->faker->numberBetween(1, 2),
            'image_in' => $this->faker->text(255),
            'image_out' => $this->faker->text(255),
            'date_in' => $this->faker->date,
            'date_out' => $this->faker->date(),
            'time_in' => $this->faker->time(),
            'time_out' => $this->faker->time(),
            'latitude_in' => $this->faker->randomNumber(1),
            'longitude_in' => $this->faker->randomNumber(1),
            'latitude_out' => $this->faker->randomNumber(1),
            'longitude_out' => $this->faker->randomNumber(1),
            'created_by_id' => $user->id,
            'approved_by_id' => $user->id,
            'store_id' => $store->id,
            'shift_store_id' => $shiftStore->id,
        ];

        $response = $this->putJson(
            route('api.presences.update', $presence),
            $data
        );

        $data['id'] = $presence->id;

        $this->assertDatabaseHas('presences', $data);

        $response->assertOk()->assertJsonFragment($data);
    }

    /**
     * @test
     */
    public function it_deletes_the_presence(): void
    {
        $presence = Presence::factory()->create();

        $response = $this->deleteJson(
            route('api.presences.destroy', $presence)
        );

        $this->assertModelMissing($presence);

        $response->assertNoContent();
    }
}
