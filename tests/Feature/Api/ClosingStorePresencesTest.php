<?php

namespace Tests\Feature\Api;

use App\Models\User;
use App\Models\Presence;
use App\Models\ClosingStore;

use Tests\TestCase;
use Laravel\Sanctum\Sanctum;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;

class ClosingStorePresencesTest extends TestCase
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
    public function it_gets_closing_store_presences()
    {
        $closingStore = ClosingStore::factory()->create();
        $presence = Presence::factory()->create();

        $closingStore->presences()->attach($presence);

        $response = $this->getJson(
            route('api.closing-stores.presences.index', $closingStore)
        );

        $response->assertOk()->assertSee($presence->date);
    }

    /**
     * @test
     */
    public function it_can_attach_presences_to_closing_store()
    {
        $closingStore = ClosingStore::factory()->create();
        $presence = Presence::factory()->create();

        $response = $this->postJson(
            route('api.closing-stores.presences.store', [
                $closingStore,
                $presence,
            ])
        );

        $response->assertNoContent();

        $this->assertTrue(
            $closingStore
                ->presences()
                ->where('presences.id', $presence->id)
                ->exists()
        );
    }

    /**
     * @test
     */
    public function it_can_detach_presences_from_closing_store()
    {
        $closingStore = ClosingStore::factory()->create();
        $presence = Presence::factory()->create();

        $response = $this->deleteJson(
            route('api.closing-stores.presences.store', [
                $closingStore,
                $presence,
            ])
        );

        $response->assertNoContent();

        $this->assertFalse(
            $closingStore
                ->presences()
                ->where('presences.id', $presence->id)
                ->exists()
        );
    }
}
