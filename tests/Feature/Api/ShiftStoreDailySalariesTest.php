<?php

namespace Tests\Feature\Api;

use App\Models\User;
use App\Models\ShiftStore;
use App\Models\DailySalary;

use Tests\TestCase;
use Laravel\Sanctum\Sanctum;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;

class ShiftStoreDailySalariesTest extends TestCase
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
    public function it_gets_shift_store_daily_salaries(): void
    {
        $shiftStore = ShiftStore::factory()->create();
        $dailySalaries = DailySalary::factory()
            ->count(2)
            ->create([
                'shift_store_id' => $shiftStore->id,
            ]);

        $response = $this->getJson(
            route('api.shift-stores.daily-salaries.index', $shiftStore)
        );

        $response->assertOk()->assertSee($dailySalaries[0]->date);
    }

    /**
     * @test
     */
    public function it_stores_the_shift_store_daily_salaries(): void
    {
        $shiftStore = ShiftStore::factory()->create();
        $data = DailySalary::factory()
            ->make([
                'shift_store_id' => $shiftStore->id,
            ])
            ->toArray();

        $response = $this->postJson(
            route('api.shift-stores.daily-salaries.store', $shiftStore),
            $data
        );

        unset($data['created_by_id']);
        unset($data['approved_by_id']);

        $this->assertDatabaseHas('daily_salaries', $data);

        $response->assertStatus(201)->assertJsonFragment($data);

        $dailySalary = DailySalary::latest('id')->first();

        $this->assertEquals($shiftStore->id, $dailySalary->shift_store_id);
    }
}
