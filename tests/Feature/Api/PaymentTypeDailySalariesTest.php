<?php

namespace Tests\Feature\Api;

use App\Models\User;
use App\Models\PaymentType;
use App\Models\DailySalary;

use Tests\TestCase;
use Laravel\Sanctum\Sanctum;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;

class PaymentTypeDailySalariesTest extends TestCase
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
    public function it_gets_payment_type_daily_salaries(): void
    {
        $paymentType = PaymentType::factory()->create();
        $dailySalaries = DailySalary::factory()
            ->count(2)
            ->create([
                'payment_type_id' => $paymentType->id,
            ]);

        $response = $this->getJson(
            route('api.payment-types.daily-salaries.index', $paymentType)
        );

        $response->assertOk()->assertSee($dailySalaries[0]->date);
    }

    /**
     * @test
     */
    public function it_stores_the_payment_type_daily_salaries(): void
    {
        $paymentType = PaymentType::factory()->create();
        $data = DailySalary::factory()
            ->make([
                'payment_type_id' => $paymentType->id,
            ])
            ->toArray();

        $response = $this->postJson(
            route('api.payment-types.daily-salaries.store', $paymentType),
            $data
        );

        unset($data['created_by_id']);
        unset($data['approved_by_id']);

        $this->assertDatabaseHas('daily_salaries', $data);

        $response->assertStatus(201)->assertJsonFragment($data);

        $dailySalary = DailySalary::latest('id')->first();

        $this->assertEquals($paymentType->id, $dailySalary->payment_type_id);
    }
}
