<?php

namespace Tests\Feature\Api;

use App\Models\User;
use App\Models\Presence;
use App\Models\MonthlySalary;

use Tests\TestCase;
use Laravel\Sanctum\Sanctum;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;

class PresenceMonthlySalariesTest extends TestCase
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
    public function it_gets_presence_monthly_salaries(): void
    {
        $presence = Presence::factory()->create();
        $monthlySalary = MonthlySalary::factory()->create();

        $presence->monthlySalaries()->attach($monthlySalary);

        $response = $this->getJson(
            route('api.presences.monthly-salaries.index', $presence)
        );

        $response->assertOk()->assertSee($monthlySalary->id);
    }

    /**
     * @test
     */
    public function it_can_attach_monthly_salaries_to_presence(): void
    {
        $presence = Presence::factory()->create();
        $monthlySalary = MonthlySalary::factory()->create();

        $response = $this->postJson(
            route('api.presences.monthly-salaries.store', [
                $presence,
                $monthlySalary,
            ])
        );

        $response->assertNoContent();

        $this->assertTrue(
            $presence
                ->monthlySalaries()
                ->where('monthly_salaries.id', $monthlySalary->id)
                ->exists()
        );
    }

    /**
     * @test
     */
    public function it_can_detach_monthly_salaries_from_presence(): void
    {
        $presence = Presence::factory()->create();
        $monthlySalary = MonthlySalary::factory()->create();

        $response = $this->deleteJson(
            route('api.presences.monthly-salaries.store', [
                $presence,
                $monthlySalary,
            ])
        );

        $response->assertNoContent();

        $this->assertFalse(
            $presence
                ->monthlySalaries()
                ->where('monthly_salaries.id', $monthlySalary->id)
                ->exists()
        );
    }
}
