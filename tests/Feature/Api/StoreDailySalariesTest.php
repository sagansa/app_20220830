<?php

namespace Tests\Feature\Api;

use App\Models\User;
use App\Models\Store;
use App\Models\DailySalary;

use Tests\TestCase;
use Laravel\Sanctum\Sanctum;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;

class StoreDailySalariesTest extends TestCase
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
    public function it_gets_store_daily_salaries(): void
    {
        $store = Store::factory()->create();
        $dailySalaries = DailySalary::factory()
            ->count(2)
            ->create([
                'store_id' => $store->id,
            ]);

        $response = $this->getJson(
            route('api.stores.daily-salaries.index', $store)
        );

        $response->assertOk()->assertSee($dailySalaries[0]->date);
    }

    /**
     * @test
     */
    public function it_stores_the_store_daily_salaries(): void
    {
        $store = Store::factory()->create();
        $data = DailySalary::factory()
            ->make([
                'store_id' => $store->id,
            ])
            ->toArray();

        $response = $this->postJson(
            route('api.stores.daily-salaries.store', $store),
            $data
        );

        unset($data['created_by_id']);
        unset($data['approved_by_id']);

        $this->assertDatabaseHas('daily_salaries', $data);

        $response->assertStatus(201)->assertJsonFragment($data);

        $dailySalary = DailySalary::latest('id')->first();

        $this->assertEquals($store->id, $dailySalary->store_id);
    }
}
