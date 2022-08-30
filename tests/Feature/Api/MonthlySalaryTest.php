<?php

namespace Tests\Feature\Api;

use App\Models\User;
use App\Models\MonthlySalary;

use App\Models\Presence;

use Tests\TestCase;
use Laravel\Sanctum\Sanctum;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;

class MonthlySalaryTest extends TestCase
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
    public function it_gets_monthly_salaries_list()
    {
        $monthlySalaries = MonthlySalary::factory()
            ->count(5)
            ->create();

        $response = $this->getJson(route('api.monthly-salaries.index'));

        $response->assertOk()->assertSee($monthlySalaries[0]->id);
    }

    /**
     * @test
     */
    public function it_stores_the_monthly_salary()
    {
        $data = MonthlySalary::factory()
            ->make()
            ->toArray();

        $response = $this->postJson(route('api.monthly-salaries.store'), $data);

        $this->assertDatabaseHas('monthly_salaries', $data);

        $response->assertStatus(201)->assertJsonFragment($data);
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

        $response = $this->putJson(
            route('api.monthly-salaries.update', $monthlySalary),
            $data
        );

        $data['id'] = $monthlySalary->id;

        $this->assertDatabaseHas('monthly_salaries', $data);

        $response->assertOk()->assertJsonFragment($data);
    }

    /**
     * @test
     */
    public function it_deletes_the_monthly_salary()
    {
        $monthlySalary = MonthlySalary::factory()->create();

        $response = $this->deleteJson(
            route('api.monthly-salaries.destroy', $monthlySalary)
        );

        $this->assertModelMissing($monthlySalary);

        $response->assertNoContent();
    }
}
