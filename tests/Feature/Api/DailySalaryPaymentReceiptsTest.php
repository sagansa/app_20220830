<?php

namespace Tests\Feature\Api;

use App\Models\User;
use App\Models\DailySalary;
use App\Models\PaymentReceipt;

use Tests\TestCase;
use Laravel\Sanctum\Sanctum;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;

class DailySalaryPaymentReceiptsTest extends TestCase
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
    public function it_gets_daily_salary_payment_receipts()
    {
        $dailySalary = DailySalary::factory()->create();
        $paymentReceipt = PaymentReceipt::factory()->create();

        $dailySalary->paymentReceipts()->attach($paymentReceipt);

        $response = $this->getJson(
            route('api.daily-salaries.payment-receipts.index', $dailySalary)
        );

        $response->assertOk()->assertSee($paymentReceipt->image);
    }

    /**
     * @test
     */
    public function it_can_attach_payment_receipts_to_daily_salary()
    {
        $dailySalary = DailySalary::factory()->create();
        $paymentReceipt = PaymentReceipt::factory()->create();

        $response = $this->postJson(
            route('api.daily-salaries.payment-receipts.store', [
                $dailySalary,
                $paymentReceipt,
            ])
        );

        $response->assertNoContent();

        $this->assertTrue(
            $dailySalary
                ->paymentReceipts()
                ->where('payment_receipts.id', $paymentReceipt->id)
                ->exists()
        );
    }

    /**
     * @test
     */
    public function it_can_detach_payment_receipts_from_daily_salary()
    {
        $dailySalary = DailySalary::factory()->create();
        $paymentReceipt = PaymentReceipt::factory()->create();

        $response = $this->deleteJson(
            route('api.daily-salaries.payment-receipts.store', [
                $dailySalary,
                $paymentReceipt,
            ])
        );

        $response->assertNoContent();

        $this->assertFalse(
            $dailySalary
                ->paymentReceipts()
                ->where('payment_receipts.id', $paymentReceipt->id)
                ->exists()
        );
    }
}
