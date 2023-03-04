<?php

namespace Tests\Feature\Api;

use App\Models\User;
use App\Models\Store;
use App\Models\Presence;

use Tests\TestCase;
use Laravel\Sanctum\Sanctum;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;

class StorePresencesTest extends TestCase
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
    public function it_gets_store_presences(): void
    {
        $store = Store::factory()->create();
        $presences = Presence::factory()
            ->count(2)
            ->create([
                'store_id' => $store->id,
            ]);

        $response = $this->getJson(route('api.stores.presences.index', $store));

        $response->assertOk()->assertSee($presences[0]->image_in);
    }

    /**
     * @test
     */
    public function it_stores_the_store_presences(): void
    {
        $store = Store::factory()->create();
        $data = Presence::factory()
            ->make([
                'store_id' => $store->id,
            ])
            ->toArray();

        $response = $this->postJson(
            route('api.stores.presences.store', $store),
            $data
        );

        unset($data['store_id']);
        unset($data['shift_store_id']);
        unset($data['status']);
        unset($data['image_in']);
        unset($data['image_out']);
        unset($data['lat_long_in']);
        unset($data['lat_long_out']);
        unset($data['created_by_id']);
        unset($data['approved_by_id']);

        $this->assertDatabaseHas('presences', $data);

        $response->assertStatus(201)->assertJsonFragment($data);

        $presence = Presence::latest('id')->first();

        $this->assertEquals($store->id, $presence->store_id);
    }
}
