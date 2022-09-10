<?php

namespace Tests\Feature\Controllers;

use App\Models\User;
use App\Models\DailySalary;

use App\Models\Store;
use App\Models\Presence;
use App\Models\ShiftStore;
use App\Models\PaymentType;

use Tests\TestCase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;

class DailySalaryControllerTest extends TestCase
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
    public function it_displays_index_view_with_daily_salaries()
    {
        $dailySalaries = DailySalary::factory()
            ->count(5)
            ->create();

        $response = $this->get(route('daily-salaries.index'));

        $response
            ->assertOk()
            ->assertViewIs('app.daily_salaries.index')
            ->assertViewHas('dailySalaries');
    }

    /**
     * @test
     */
    public function it_displays_create_view_for_daily_salary()
    {
        $response = $this->get(route('daily-salaries.create'));

        $response->assertOk()->assertViewIs('app.daily_salaries.create');
    }

    /**
     * @test
     */
    public function it_stores_the_daily_salary()
    {
        $data = DailySalary::factory()
            ->make()
            ->toArray();

        $response = $this->post(route('daily-salaries.store'), $data);

        $this->assertDatabaseHas('daily_salaries', $data);

        $dailySalary = DailySalary::latest('id')->first();

        $response->assertRedirect(route('daily-salaries.edit', $dailySalary));
    }

    /**
     * @test
     */
    public function it_displays_show_view_for_daily_salary()
    {
        $dailySalary = DailySalary::factory()->create();

        $response = $this->get(route('daily-salaries.show', $dailySalary));

        $response
            ->assertOk()
            ->assertViewIs('app.daily_salaries.show')
            ->assertViewHas('dailySalary');
    }

    /**
     * @test
     */
    public function it_displays_edit_view_for_daily_salary()
    {
        $dailySalary = DailySalary::factory()->create();

        $response = $this->get(route('daily-salaries.edit', $dailySalary));

        $response
            ->assertOk()
            ->assertViewIs('app.daily_salaries.edit')
            ->assertViewHas('dailySalary');
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

        $response = $this->put(
            route('daily-salaries.update', $dailySalary),
            $data
        );

        $data['id'] = $dailySalary->id;

        $this->assertDatabaseHas('daily_salaries', $data);

        $response->assertRedirect(route('daily-salaries.edit', $dailySalary));
    }

    /**
     * @test
     */
    public function it_deletes_the_daily_salary()
    {
        $dailySalary = DailySalary::factory()->create();

        $response = $this->delete(
            route('daily-salaries.destroy', $dailySalary)
        );

        $response->assertRedirect(route('daily-salaries.index'));

        $this->assertModelMissing($dailySalary);
    }
}
