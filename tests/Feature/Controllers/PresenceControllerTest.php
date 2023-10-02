<?php

namespace Tests\Feature\Controllers;

use App\Models\User;
use App\Models\Presence;

use App\Models\Store;
use App\Models\ShiftStore;

use Tests\TestCase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;

class PresenceControllerTest extends TestCase
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
    public function it_displays_index_view_with_presences(): void
    {
        $presences = Presence::factory()
            ->count(5)
            ->create();

        $response = $this->get(route('presences.index'));

        $response
            ->assertOk()
            ->assertViewIs('app.presences.index')
            ->assertViewHas('presences');
    }

    /**
     * @test
     */
    public function it_displays_create_view_for_presence(): void
    {
        $response = $this->get(route('presences.create'));

        $response->assertOk()->assertViewIs('app.presences.create');
    }

    /**
     * @test
     */
    public function it_stores_the_presence(): void
    {
        $data = Presence::factory()
            ->make()
            ->toArray();

        $response = $this->post(route('presences.store'), $data);

        $this->assertDatabaseHas('presences', $data);

        $presence = Presence::latest('id')->first();

        $response->assertRedirect(route('presences.edit', $presence));
    }

    /**
     * @test
     */
    public function it_displays_show_view_for_presence(): void
    {
        $presence = Presence::factory()->create();

        $response = $this->get(route('presences.show', $presence));

        $response
            ->assertOk()
            ->assertViewIs('app.presences.show')
            ->assertViewHas('presence');
    }

    /**
     * @test
     */
    public function it_displays_edit_view_for_presence(): void
    {
        $presence = Presence::factory()->create();

        $response = $this->get(route('presences.edit', $presence));

        $response
            ->assertOk()
            ->assertViewIs('app.presences.edit')
            ->assertViewHas('presence');
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

        $response = $this->put(route('presences.update', $presence), $data);

        $data['id'] = $presence->id;

        $this->assertDatabaseHas('presences', $data);

        $response->assertRedirect(route('presences.edit', $presence));
    }

    /**
     * @test
     */
    public function it_deletes_the_presence(): void
    {
        $presence = Presence::factory()->create();

        $response = $this->delete(route('presences.destroy', $presence));

        $response->assertRedirect(route('presences.index'));

        $this->assertModelMissing($presence);
    }
}
