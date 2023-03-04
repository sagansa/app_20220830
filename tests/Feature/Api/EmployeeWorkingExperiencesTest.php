<?php

namespace Tests\Feature\Api;

use App\Models\User;
use App\Models\Employee;
use App\Models\WorkingExperience;

use Tests\TestCase;
use Laravel\Sanctum\Sanctum;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;

class EmployeeWorkingExperiencesTest extends TestCase
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
    public function it_gets_employee_working_experiences(): void
    {
        $employee = Employee::factory()->create();
        $workingExperiences = WorkingExperience::factory()
            ->count(2)
            ->create([
                'employee_id' => $employee->id,
            ]);

        $response = $this->getJson(
            route('api.employees.working-experiences.index', $employee)
        );

        $response->assertOk()->assertSee($workingExperiences[0]->place);
    }

    /**
     * @test
     */
    public function it_stores_the_employee_working_experiences(): void
    {
        $employee = Employee::factory()->create();
        $data = WorkingExperience::factory()
            ->make([
                'employee_id' => $employee->id,
            ])
            ->toArray();

        $response = $this->postJson(
            route('api.employees.working-experiences.store', $employee),
            $data
        );

        unset($data['employee_id']);

        $this->assertDatabaseHas('working_experiences', $data);

        $response->assertStatus(201)->assertJsonFragment($data);

        $workingExperience = WorkingExperience::latest('id')->first();

        $this->assertEquals($employee->id, $workingExperience->employee_id);
    }
}
