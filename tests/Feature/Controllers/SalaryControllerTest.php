<?php

namespace Tests\Feature\Controllers;

use App\Models\User;
use App\Models\Salary;

use Tests\TestCase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;

class SalaryControllerTest extends TestCase
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
    public function it_displays_index_view_with_salaries()
    {
        $salaries = Salary::factory()
            ->count(5)
            ->create();

        $response = $this->get(route('salaries.index'));

        $response
            ->assertOk()
            ->assertViewIs('app.salaries.index')
            ->assertViewHas('salaries');
    }

    /**
     * @test
     */
    public function it_displays_create_view_for_salary()
    {
        $response = $this->get(route('salaries.create'));

        $response->assertOk()->assertViewIs('app.salaries.create');
    }

    /**
     * @test
     */
    public function it_stores_the_salary()
    {
        $data = Salary::factory()
            ->make()
            ->toArray();

        $response = $this->post(route('salaries.store'), $data);

        $this->assertDatabaseHas('salaries', $data);

        $salary = Salary::latest('id')->first();

        $response->assertRedirect(route('salaries.edit', $salary));
    }

    /**
     * @test
     */
    public function it_displays_show_view_for_salary()
    {
        $salary = Salary::factory()->create();

        $response = $this->get(route('salaries.show', $salary));

        $response
            ->assertOk()
            ->assertViewIs('app.salaries.show')
            ->assertViewHas('salary');
    }

    /**
     * @test
     */
    public function it_displays_edit_view_for_salary()
    {
        $salary = Salary::factory()->create();

        $response = $this->get(route('salaries.edit', $salary));

        $response
            ->assertOk()
            ->assertViewIs('app.salaries.edit')
            ->assertViewHas('salary');
    }

    /**
     * @test
     */
    public function it_updates_the_salary()
    {
        $salary = Salary::factory()->create();

        $data = [
            'amount' => $this->faker->randomNumber,
        ];

        $response = $this->put(route('salaries.update', $salary), $data);

        $data['id'] = $salary->id;

        $this->assertDatabaseHas('salaries', $data);

        $response->assertRedirect(route('salaries.edit', $salary));
    }

    /**
     * @test
     */
    public function it_deletes_the_salary()
    {
        $salary = Salary::factory()->create();

        $response = $this->delete(route('salaries.destroy', $salary));

        $response->assertRedirect(route('salaries.index'));

        $this->assertModelMissing($salary);
    }
}
