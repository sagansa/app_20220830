<?php

namespace Tests\Feature\Api;

use App\Models\User;
use App\Models\Presence;
use App\Models\ClosingStore;

use Tests\TestCase;
use Laravel\Sanctum\Sanctum;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;

class PresenceClosingStoresTest extends TestCase
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
    public function it_gets_presence_closing_stores()
    {
        $presence = Presence::factory()->create();
        $closingStore = ClosingStore::factory()->create();

        $presence->closingStores()->attach($closingStore);

        $response = $this->getJson(
            route('api.presences.closing-stores.index', $presence)
        );

        $response->assertOk()->assertSee($closingStore->date);
    }

    /**
     * @test
     */
    public function it_can_attach_closing_stores_to_presence()
    {
        $presence = Presence::factory()->create();
        $closingStore = ClosingStore::factory()->create();

        $response = $this->postJson(
            route('api.presences.closing-stores.store', [
                $presence,
                $closingStore,
            ])
        );

        $response->assertNoContent();

        $this->assertTrue(
            $presence
                ->closingStores()
                ->where('closing_stores.id', $closingStore->id)
                ->exists()
        );
    }

    /**
     * @test
     */
    public function it_can_detach_closing_stores_from_presence()
    {
        $presence = Presence::factory()->create();
        $closingStore = ClosingStore::factory()->create();

        $response = $this->deleteJson(
            route('api.presences.closing-stores.store', [
                $presence,
                $closingStore,
            ])
        );

        $response->assertNoContent();

        $this->assertFalse(
            $presence
                ->closingStores()
                ->where('closing_stores.id', $closingStore->id)
                ->exists()
        );
    }
}
