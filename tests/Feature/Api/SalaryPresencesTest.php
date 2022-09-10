<?php

namespace Tests\Feature\Api;

use App\Models\User;
use App\Models\Salary;
use App\Models\Presence;

use Tests\TestCase;
use Laravel\Sanctum\Sanctum;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;

class SalaryPresencesTest extends TestCase
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
    public function it_gets_salary_presences()
    {
        $salary = Salary::factory()->create();
        $presence = Presence::factory()->create();

        $salary->presences()->attach($presence);

        $response = $this->getJson(
            route('api.salaries.presences.index', $salary)
        );

        $response->assertOk()->assertSee($presence->date);
    }

    /**
     * @test
     */
    public function it_can_attach_presences_to_salary()
    {
        $salary = Salary::factory()->create();
        $presence = Presence::factory()->create();

        $response = $this->postJson(
            route('api.salaries.presences.store', [$salary, $presence])
        );

        $response->assertNoContent();

        $this->assertTrue(
            $salary
                ->presences()
                ->where('presences.id', $presence->id)
                ->exists()
        );
    }

    /**
     * @test
     */
    public function it_can_detach_presences_from_salary()
    {
        $salary = Salary::factory()->create();
        $presence = Presence::factory()->create();

        $response = $this->deleteJson(
            route('api.salaries.presences.store', [$salary, $presence])
        );

        $response->assertNoContent();

        $this->assertFalse(
            $salary
                ->presences()
                ->where('presences.id', $presence->id)
                ->exists()
        );
    }
}
