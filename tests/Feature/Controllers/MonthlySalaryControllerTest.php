<?php

namespace Tests\Feature\Controllers;

use App\Models\User;
use App\Models\MonthlySalary;

use App\Models\Presence;

use Tests\TestCase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;

class MonthlySalaryControllerTest extends TestCase
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
    public function it_displays_index_view_with_monthly_salaries()
    {
        $monthlySalaries = MonthlySalary::factory()
            ->count(5)
            ->create();

        $response = $this->get(route('monthly-salaries.index'));

        $response
            ->assertOk()
            ->assertViewIs('app.monthly_salaries.index')
            ->assertViewHas('monthlySalaries');
    }

    /**
     * @test
     */
    public function it_displays_create_view_for_monthly_salary()
    {
        $response = $this->get(route('monthly-salaries.create'));

        $response->assertOk()->assertViewIs('app.monthly_salaries.create');
    }

    /**
     * @test
     */
    public function it_stores_the_monthly_salary()
    {
        $data = MonthlySalary::factory()
            ->make()
            ->toArray();

        $response = $this->post(route('monthly-salaries.store'), $data);

        $this->assertDatabaseHas('monthly_salaries', $data);

        $monthlySalary = MonthlySalary::latest('id')->first();

        $response->assertRedirect(
            route('monthly-salaries.edit', $monthlySalary)
        );
    }

    /**
     * @test
     */
    public function it_displays_show_view_for_monthly_salary()
    {
        $monthlySalary = MonthlySalary::factory()->create();

        $response = $this->get(route('monthly-salaries.show', $monthlySalary));

        $response
            ->assertOk()
            ->assertViewIs('app.monthly_salaries.show')
            ->assertViewHas('monthlySalary');
    }

    /**
     * @test
     */
    public function it_displays_edit_view_for_monthly_salary()
    {
        $monthlySalary = MonthlySalary::factory()->create();

        $response = $this->get(route('monthly-salaries.edit', $monthlySalary));

        $response
            ->assertOk()
            ->assertViewIs('app.monthly_salaries.edit')
            ->assertViewHas('monthlySalary');
    }

    /**
     * @test
     */
    public function it_updates_the_monthly_salary()
    {
        $monthlySalary = MonthlySalary::factory()->create();

        $presence = Presence::factory()->create();

        $data = [
            'amount' => $this->faker->randomNumber,
            'presence_id' => $presence->id,
        ];

        $response = $this->put(
            route('monthly-salaries.update', $monthlySalary),
            $data
        );

        $data['id'] = $monthlySalary->id;

        $this->assertDatabaseHas('monthly_salaries', $data);

        $response->assertRedirect(
            route('monthly-salaries.edit', $monthlySalary)
        );
    }

    /**
     * @test
     */
    public function it_deletes_the_monthly_salary()
    {
        $monthlySalary = MonthlySalary::factory()->create();

        $response = $this->delete(
            route('monthly-salaries.destroy', $monthlySalary)
        );

        $response->assertRedirect(route('monthly-salaries.index'));

        $this->assertModelMissing($monthlySalary);
    }
}
