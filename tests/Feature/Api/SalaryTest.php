<?php

namespace Tests\Feature\Api;

use App\Models\User;
use App\Models\Salary;

use Tests\TestCase;
use Laravel\Sanctum\Sanctum;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;

class SalaryTest extends TestCase
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
    public function it_gets_salaries_list()
    {
        $salaries = Salary::factory()
            ->count(5)
            ->create();

        $response = $this->getJson(route('api.salaries.index'));

        $response->assertOk()->assertSee($salaries[0]->id);
    }

    /**
     * @test
     */
    public function it_stores_the_salary()
    {
        $data = Salary::factory()
            ->make()
            ->toArray();

        $response = $this->postJson(route('api.salaries.store'), $data);

        $this->assertDatabaseHas('salaries', $data);

        $response->assertStatus(201)->assertJsonFragment($data);
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

        $response = $this->putJson(
            route('api.salaries.update', $salary),
            $data
        );

        $data['id'] = $salary->id;

        $this->assertDatabaseHas('salaries', $data);

        $response->assertOk()->assertJsonFragment($data);
    }

    /**
     * @test
     */
    public function it_deletes_the_salary()
    {
        $salary = Salary::factory()->create();

        $response = $this->deleteJson(route('api.salaries.destroy', $salary));

        $this->assertModelMissing($salary);

        $response->assertNoContent();
    }
}
