<?php

namespace Tests\Feature\Api;

use App\Models\User;
use App\Models\DailySalary;
use App\Models\PaymentReceipt;

use Tests\TestCase;
use Laravel\Sanctum\Sanctum;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;

class PaymentReceiptDailySalariesTest extends TestCase
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
    public function it_gets_payment_receipt_daily_salaries()
    {
        $paymentReceipt = PaymentReceipt::factory()->create();
        $dailySalary = DailySalary::factory()->create();

        $paymentReceipt->dailySalaries()->attach($dailySalary);

        $response = $this->getJson(
            route('api.payment-receipts.daily-salaries.index', $paymentReceipt)
        );

        $response->assertOk()->assertSee($dailySalary->date);
    }

    /**
     * @test
     */
    public function it_can_attach_daily_salaries_to_payment_receipt()
    {
        $paymentReceipt = PaymentReceipt::factory()->create();
        $dailySalary = DailySalary::factory()->create();

        $response = $this->postJson(
            route('api.payment-receipts.daily-salaries.store', [
                $paymentReceipt,
                $dailySalary,
            ])
        );

        $response->assertNoContent();

        $this->assertTrue(
            $paymentReceipt
                ->dailySalaries()
                ->where('daily_salaries.id', $dailySalary->id)
                ->exists()
        );
    }

    /**
     * @test
     */
    public function it_can_detach_daily_salaries_from_payment_receipt()
    {
        $paymentReceipt = PaymentReceipt::factory()->create();
        $dailySalary = DailySalary::factory()->create();

        $response = $this->deleteJson(
            route('api.payment-receipts.daily-salaries.store', [
                $paymentReceipt,
                $dailySalary,
            ])
        );

        $response->assertNoContent();

        $this->assertFalse(
            $paymentReceipt
                ->dailySalaries()
                ->where('daily_salaries.id', $dailySalary->id)
                ->exists()
        );
    }
}
