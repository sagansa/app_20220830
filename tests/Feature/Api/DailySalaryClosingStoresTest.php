<?php

namespace Tests\Feature\Api;

use App\Models\User;
use App\Models\DailySalary;
use App\Models\ClosingStore;

use Tests\TestCase;
use Laravel\Sanctum\Sanctum;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;

class DailySalaryClosingStoresTest extends TestCase
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
    public function it_gets_daily_salary_closing_stores()
    {
        $dailySalary = DailySalary::factory()->create();
        $closingStore = ClosingStore::factory()->create();

        $dailySalary->closingStores()->attach($closingStore);

        $response = $this->getJson(
            route('api.daily-salaries.closing-stores.index', $dailySalary)
        );

        $response->assertOk()->assertSee($closingStore->date);
    }

    /**
     * @test
     */
    public function it_can_attach_closing_stores_to_daily_salary()
    {
        $dailySalary = DailySalary::factory()->create();
        $closingStore = ClosingStore::factory()->create();

        $response = $this->postJson(
            route('api.daily-salaries.closing-stores.store', [
                $dailySalary,
                $closingStore,
            ])
        );

        $response->assertNoContent();

        $this->assertTrue(
            $dailySalary
                ->closingStores()
                ->where('closing_stores.id', $closingStore->id)
                ->exists()
        );
    }

    /**
     * @test
     */
    public function it_can_detach_closing_stores_from_daily_salary()
    {
        $dailySalary = DailySalary::factory()->create();
        $closingStore = ClosingStore::factory()->create();

        $response = $this->deleteJson(
            route('api.daily-salaries.closing-stores.store', [
                $dailySalary,
                $closingStore,
            ])
        );

        $response->assertNoContent();

        $this->assertFalse(
            $dailySalary
                ->closingStores()
                ->where('closing_stores.id', $closingStore->id)
                ->exists()
        );
    }
}
