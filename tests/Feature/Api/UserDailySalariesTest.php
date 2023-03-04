<?php

namespace Tests\Feature\Api;

use App\Models\User;
use App\Models\DailySalary;

use Tests\TestCase;
use Laravel\Sanctum\Sanctum;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;

class UserDailySalariesTest extends TestCase
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
    public function it_gets_user_daily_salaries(): void
    {
        $user = User::factory()->create();
        $dailySalaries = DailySalary::factory()
            ->count(2)
            ->create([
                'approved_by_id' => $user->id,
            ]);

        $response = $this->getJson(
            route('api.users.daily-salaries.index', $user)
        );

        $response->assertOk()->assertSee($dailySalaries[0]->date);
    }

    /**
     * @test
     */
    public function it_stores_the_user_daily_salaries(): void
    {
        $user = User::factory()->create();
        $data = DailySalary::factory()
            ->make([
                'approved_by_id' => $user->id,
            ])
            ->toArray();

        $response = $this->postJson(
            route('api.users.daily-salaries.store', $user),
            $data
        );

        unset($data['created_by_id']);
        unset($data['approved_by_id']);

        $this->assertDatabaseHas('daily_salaries', $data);

        $response->assertStatus(201)->assertJsonFragment($data);

        $dailySalary = DailySalary::latest('id')->first();

        $this->assertEquals($user->id, $dailySalary->approved_by_id);
    }
}
