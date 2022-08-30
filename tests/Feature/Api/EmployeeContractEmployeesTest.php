<?php

namespace Tests\Feature\Api;

use App\Models\User;
use App\Models\Employee;
use App\Models\ContractEmployee;

use Tests\TestCase;
use Laravel\Sanctum\Sanctum;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;

class EmployeeContractEmployeesTest extends TestCase
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
    public function it_gets_employee_contract_employees()
    {
        $employee = Employee::factory()->create();
        $contractEmployees = ContractEmployee::factory()
            ->count(2)
            ->create([
                'employee_id' => $employee->id,
            ]);

        $response = $this->getJson(
            route('api.employees.contract-employees.index', $employee)
        );

        $response->assertOk()->assertSee($contractEmployees[0]->file);
    }

    /**
     * @test
     */
    public function it_stores_the_employee_contract_employees()
    {
        $employee = Employee::factory()->create();
        $data = ContractEmployee::factory()
            ->make([
                'employee_id' => $employee->id,
            ])
            ->toArray();

        $response = $this->postJson(
            route('api.employees.contract-employees.store', $employee),
            $data
        );

        unset($data['employee_id']);

        $this->assertDatabaseHas('contract_employees', $data);

        $response->assertStatus(201)->assertJsonFragment($data);

        $contractEmployee = ContractEmployee::latest('id')->first();

        $this->assertEquals($employee->id, $contractEmployee->employee_id);
    }
}
