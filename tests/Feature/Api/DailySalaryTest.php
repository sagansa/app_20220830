<?php

namespace Tests\Feature\Api;

use App\Models\User;
use App\Models\DailySalary;

use App\Models\Store;
use App\Models\Presence;
use App\Models\ShiftStore;
use App\Models\PaymentType;

use Tests\TestCase;
use Laravel\Sanctum\Sanctum;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;

class DailySalaryTest extends TestCase
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
    public function it_gets_daily_salaries_list()
    {
        $dailySalaries = DailySalary::factory()
            ->count(5)
            ->create();

        $response = $this->getJson(route('api.daily-salaries.index'));

        $response->assertOk()->assertSee($dailySalaries[0]->date);
    }

    /**
     * @test
     */
    public function it_stores_the_daily_salary()
    {
        $data = DailySalary::factory()
            ->make()
            ->toArray();

        $response = $this->postJson(route('api.daily-salaries.store'), $data);

        $this->assertDatabaseHas('daily_salaries', $data);

        $response->assertStatus(201)->assertJsonFragment($data);
    }

    /**
     * @test
     */
    public function it_updates_the_daily_salary()
    {
        $dailySalary = DailySalary::factory()->create();

        $store = Store::factory()->create();
        $shiftStore = ShiftStore::factory()->create();
        $paymentType = PaymentType::factory()->create();
        $presence = Presence::factory()->create();

        $data = [
            'date' => $this->faker->date,
            'amount' => $this->faker->randomNumber,
            'status' => $this->faker->numberBetween(1, 4),
            'store_id' => $store->id,
            'shift_store_id' => $shiftStore->id,
            'payment_type_id' => $paymentType->id,
            'presence_id' => $presence->id,
        ];

        $response = $this->putJson(
            route('api.daily-salaries.update', $dailySalary),
            $data
        );

        $data['id'] = $dailySalary->id;

        $this->assertDatabaseHas('daily_salaries', $data);

        $response->assertOk()->assertJsonFragment($data);
    }

    /**
     * @test
     */
    public function it_deletes_the_daily_salary()
    {
        $dailySalary = DailySalary::factory()->create();

        $response = $this->deleteJson(
            route('api.daily-salaries.destroy', $dailySalary)
        );

        $this->assertModelMissing($dailySalary);

        $response->assertNoContent();
    }
}
