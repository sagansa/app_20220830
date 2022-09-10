<?php

namespace Tests\Feature\Api;

use App\Models\User;
use App\Models\Presence;
use App\Models\MonthlySalary;

use Tests\TestCase;
use Laravel\Sanctum\Sanctum;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;

class MonthlySalaryPresencesTest extends TestCase
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
    public function it_gets_monthly_salary_presences()
    {
        $monthlySalary = MonthlySalary::factory()->create();
        $presence = Presence::factory()->create();

        $monthlySalary->presences()->attach($presence);

        $response = $this->getJson(
            route('api.monthly-salaries.presences.index', $monthlySalary)
        );

        $response->assertOk()->assertSee($presence->image_in);
    }

    /**
     * @test
     */
    public function it_can_attach_presences_to_monthly_salary()
    {
        $monthlySalary = MonthlySalary::factory()->create();
        $presence = Presence::factory()->create();

        $response = $this->postJson(
            route('api.monthly-salaries.presences.store', [
                $monthlySalary,
                $presence,
            ])
        );

        $response->assertNoContent();

        $this->assertTrue(
            $monthlySalary
                ->presences()
                ->where('presences.id', $presence->id)
                ->exists()
        );
    }

    /**
     * @test
     */
    public function it_can_detach_presences_from_monthly_salary()
    {
        $monthlySalary = MonthlySalary::factory()->create();
        $presence = Presence::factory()->create();

        $response = $this->deleteJson(
            route('api.monthly-salaries.presences.store', [
                $monthlySalary,
                $presence,
            ])
        );

        $response->assertNoContent();

        $this->assertFalse(
            $monthlySalary
                ->presences()
                ->where('presences.id', $presence->id)
                ->exists()
        );
    }
}
