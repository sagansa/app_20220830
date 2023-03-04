<?php

namespace Tests\Feature\Api;

use App\Models\User;
use App\Models\Employee;

use App\Models\Bank;
use App\Models\Regency;
use App\Models\Village;
use App\Models\Province;
use App\Models\District;
use App\Models\EmployeeStatus;

use Tests\TestCase;
use Laravel\Sanctum\Sanctum;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;

class EmployeeTest extends TestCase
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
    public function it_gets_employees_list(): void
    {
        $employees = Employee::factory()
            ->count(5)
            ->create();

        $response = $this->getJson(route('api.employees.index'));

        $response->assertOk()->assertSee($employees[0]->identity_no);
    }

    /**
     * @test
     */
    public function it_stores_the_employee(): void
    {
        $data = Employee::factory()
            ->make()
            ->toArray();

        $response = $this->postJson(route('api.employees.store'), $data);

        unset($data['village_id']);
        unset($data['user_id']);

        $this->assertDatabaseHas('employees', $data);

        $response->assertStatus(201)->assertJsonFragment($data);
    }

    /**
     * @test
     */
    public function it_updates_the_employee(): void
    {
        $employee = Employee::factory()->create();

        $province = Province::factory()->create();
        $regency = Regency::factory()->create();
        $district = District::factory()->create();
        $village = Village::factory()->create();
        $bank = Bank::factory()->create();
        $user = User::factory()->create();
        $employeeStatus = EmployeeStatus::factory()->create();

        $data = [
            'identity_no' => $this->faker->text(255),
            'fullname' => $this->faker->name,
            'nickname' => $this->faker->text(20),
            'no_telp' => $this->faker->randomNumber(),
            'birth_place' => $this->faker->text(255),
            'birth_date' => $this->faker->date,
            'gender' => $this->faker->numberBetween(0, 127),
            'religion' => $this->faker->numberBetween(0, 127),
            'marital_status' => $this->faker->numberBetween(0, 127),
            'level_of_education' => $this->faker->numberBetween(0, 127),
            'major' => $this->faker->text(255),
            'fathers_name' => $this->faker->text(255),
            'mothers_name' => $this->faker->text(255),
            'address' => $this->faker->text,
            'codepos' => $this->faker->randomNumber(0),
            'gps_location' => $this->faker->text(255),
            'parents_no_telp' => $this->faker->randomNumber(),
            'siblings_name' => $this->faker->text(255),
            'siblings_no_telp' => $this->faker->randomNumber(),
            'bpjs' => $this->faker->boolean,
            'driver_license' => $this->faker->text(255),
            'bank_account_no' => $this->faker->randomNumber(),
            'accepted_work_date' => $this->faker->date,
            'ttd' => $this->faker->text(255),
            'notes' => $this->faker->text,
            'image_identity_id' => $this->faker->text(255),
            'image_selfie' => $this->faker->text(255),
            'user_id' => $this->faker->randomNumber,
            'province_id' => $province->id,
            'regency_id' => $regency->id,
            'district_id' => $district->id,
            'village_id' => $village->id,
            'bank_id' => $bank->id,
            'user_id' => $user->id,
            'employee_status_id' => $employeeStatus->id,
        ];

        $response = $this->putJson(
            route('api.employees.update', $employee),
            $data
        );

        unset($data['village_id']);
        unset($data['user_id']);

        $data['id'] = $employee->id;

        $this->assertDatabaseHas('employees', $data);

        $response->assertOk()->assertJsonFragment($data);
    }

    /**
     * @test
     */
    public function it_deletes_the_employee(): void
    {
        $employee = Employee::factory()->create();

        $response = $this->deleteJson(
            route('api.employees.destroy', $employee)
        );

        $this->assertSoftDeleted($employee);

        $response->assertNoContent();
    }
}
