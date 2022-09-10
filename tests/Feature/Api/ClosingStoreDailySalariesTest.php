<?php

namespace Tests\Feature\Api;

use App\Models\User;
use App\Models\DailySalary;
use App\Models\ClosingStore;

use Tests\TestCase;
use Laravel\Sanctum\Sanctum;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;

class ClosingStoreDailySalariesTest extends TestCase
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
    public function it_gets_closing_store_daily_salaries()
    {
        $closingStore = ClosingStore::factory()->create();
        $dailySalary = DailySalary::factory()->create();

        $closingStore->dailySalaries()->attach($dailySalary);

        $response = $this->getJson(
            route('api.closing-stores.daily-salaries.index', $closingStore)
        );

        $response->assertOk()->assertSee($dailySalary->date);
    }

    /**
     * @test
     */
    public function it_can_attach_daily_salaries_to_closing_store()
    {
        $closingStore = ClosingStore::factory()->create();
        $dailySalary = DailySalary::factory()->create();

        $response = $this->postJson(
            route('api.closing-stores.daily-salaries.store', [
                $closingStore,
                $dailySalary,
            ])
        );

        $response->assertNoContent();

        $this->assertTrue(
            $closingStore
                ->dailySalaries()
                ->where('daily_salaries.id', $dailySalary->id)
                ->exists()
        );
    }

    /**
     * @test
     */
    public function it_can_detach_daily_salaries_from_closing_store()
    {
        $closingStore = ClosingStore::factory()->create();
        $dailySalary = DailySalary::factory()->create();

        $response = $this->deleteJson(
            route('api.closing-stores.daily-salaries.store', [
                $closingStore,
                $dailySalary,
            ])
        );

        $response->assertNoContent();

        $this->assertFalse(
            $closingStore
                ->dailySalaries()
                ->where('daily_salaries.id', $dailySalary->id)
                ->exists()
        );
    }
}
