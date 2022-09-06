<?php

namespace Tests\Feature\Api;

use App\Models\User;
use App\Models\Salary;
use App\Models\Presence;

use Tests\TestCase;
use Laravel\Sanctum\Sanctum;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;

class PresenceSalariesTest extends TestCase
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
    public function it_gets_presence_salaries()
    {
        $presence = Presence::factory()->create();
        $salary = Salary::factory()->create();

        $presence->salaries()->attach($salary);

        $response = $this->getJson(
            route('api.presences.salaries.index', $presence)
        );

        $response->assertOk()->assertSee($salary->id);
    }

    /**
     * @test
     */
    public function it_can_attach_salaries_to_presence()
    {
        $presence = Presence::factory()->create();
        $salary = Salary::factory()->create();

        $response = $this->postJson(
            route('api.presences.salaries.store', [$presence, $salary])
        );

        $response->assertNoContent();

        $this->assertTrue(
            $presence
                ->salaries()
                ->where('salaries.id', $salary->id)
                ->exists()
        );
    }

    /**
     * @test
     */
    public function it_can_detach_salaries_from_presence()
    {
        $presence = Presence::factory()->create();
        $salary = Salary::factory()->create();

        $response = $this->deleteJson(
            route('api.presences.salaries.store', [$presence, $salary])
        );

        $response->assertNoContent();

        $this->assertFalse(
            $presence
                ->salaries()
                ->where('salaries.id', $salary->id)
                ->exists()
        );
    }
}
