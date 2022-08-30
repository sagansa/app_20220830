<?php

namespace Tests\Feature\Api;

use App\Models\User;
use App\Models\Saving;
use App\Models\Employee;

use Tests\TestCase;
use Laravel\Sanctum\Sanctum;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;

class EmployeeSavingsTest extends TestCase
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
    public function it_gets_employee_savings()
    {
        $employee = Employee::factory()->create();
        $savings = Saving::factory()
            ->count(2)
            ->create([
                'employee_id' => $employee->id,
            ]);

        $response = $this->getJson(
            route('api.employees.savings.index', $employee)
        );

        $response->assertOk()->assertSee($savings[0]->id);
    }

    /**
     * @test
     */
    public function it_stores_the_employee_savings()
    {
        $employee = Employee::factory()->create();
        $data = Saving::factory()
            ->make([
                'employee_id' => $employee->id,
            ])
            ->toArray();

        $response = $this->postJson(
            route('api.employees.savings.store', $employee),
            $data
        );

        unset($data['employee_id']);

        $this->assertDatabaseHas('savings', $data);

        $response->assertStatus(201)->assertJsonFragment($data);

        $saving = Saving::latest('id')->first();

        $this->assertEquals($employee->id, $saving->employee_id);
    }
}
