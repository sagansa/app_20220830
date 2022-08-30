<?php

namespace Tests\Feature\Controllers;

use App\Models\User;
use App\Models\Employee;

use App\Models\Bank;
use App\Models\Regency;
use App\Models\Village;
use App\Models\Province;
use App\Models\District;
use App\Models\EmployeeStatus;

use Tests\TestCase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;

class EmployeeControllerTest extends TestCase
{
    use RefreshDatabase, WithFaker;

    protected function setUp(): void
    {
        parent::setUp();

        $this->actingAs(
            User::factory()->create(['email' => 'admin@admin.com'])
        );

        $this->seed(\Database\Seeders\PermissionsSeeder::class);

        $this->withoutExceptionHandling();
    }

    /**
     * @test
     */
    public function it_displays_index_view_with_employees()
    {
        $employees = Employee::factory()
            ->count(5)
            ->create();

        $response = $this->get(route('employees.index'));

        $response
            ->assertOk()
            ->assertViewIs('app.employees.index')
            ->assertViewHas('employees');
    }

    /**
     * @test
     */
    public function it_displays_create_view_for_employee()
    {
        $response = $this->get(route('employees.create'));

        $response->assertOk()->assertViewIs('app.employees.create');
    }

    /**
     * @test
     */
    public function it_stores_the_employee()
    {
        $data = Employee::factory()
            ->make()
            ->toArray();

        $response = $this->post(route('employees.store'), $data);

        unset($data['user_id']);

        $this->assertDatabaseHas('employees', $data);

        $employee = Employee::latest('id')->first();

        $response->assertRedirect(route('employees.edit', $employee));
    }

    /**
     * @test
     */
    public function it_displays_show_view_for_employee()
    {
        $employee = Employee::factory()->create();

        $response = $this->get(route('employees.show', $employee));

        $response
            ->assertOk()
            ->assertViewIs('app.employees.show')
            ->assertViewHas('employee');
    }

    /**
     * @test
     */
    public function it_displays_edit_view_for_employee()
    {
        $employee = Employee::factory()->create();

        $response = $this->get(route('employees.edit', $employee));

        $response
            ->assertOk()
            ->assertViewIs('app.employees.edit')
            ->assertViewHas('employee');
    }

    /**
     * @test
     */
    public function it_updates_the_employee()
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

        $response = $this->put(route('employees.update', $employee), $data);

        unset($data['user_id']);

        $data['id'] = $employee->id;

        $this->assertDatabaseHas('employees', $data);

        $response->assertRedirect(route('employees.edit', $employee));
    }

    /**
     * @test
     */
    public function it_deletes_the_employee()
    {
        $employee = Employee::factory()->create();

        $response = $this->delete(route('employees.destroy', $employee));

        $response->assertRedirect(route('employees.index'));

        $this->assertSoftDeleted($employee);
    }
}
