<?php

namespace Tests\Feature\Api;

use App\Models\User;
use App\Models\PaymentReceipt;

use Tests\TestCase;
use Laravel\Sanctum\Sanctum;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;

class PaymentReceiptTest extends TestCase
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
    public function it_gets_payment_receipts_list()
    {
        $paymentReceipts = PaymentReceipt::factory()
            ->count(5)
            ->create();

        $response = $this->getJson(route('api.payment-receipts.index'));

        $response->assertOk()->assertSee($paymentReceipts[0]->image);
    }

    /**
     * @test
     */
    public function it_stores_the_payment_receipt()
    {
        $data = PaymentReceipt::factory()
            ->make()
            ->toArray();

        $response = $this->postJson(route('api.payment-receipts.store'), $data);

        $this->assertDatabaseHas('payment_receipts', $data);

        $response->assertStatus(201)->assertJsonFragment($data);
    }

    /**
     * @test
     */
    public function it_updates_the_payment_receipt()
    {
        $paymentReceipt = PaymentReceipt::factory()->create();

        $data = [
            'amount' => $this->faker->randomNumber,
            'payment_for' => $this->faker->numberBetween(1, 3),
        ];

        $response = $this->putJson(
            route('api.payment-receipts.update', $paymentReceipt),
            $data
        );

        $data['id'] = $paymentReceipt->id;

        $this->assertDatabaseHas('payment_receipts', $data);

        $response->assertOk()->assertJsonFragment($data);
    }

    /**
     * @test
     */
    public function it_deletes_the_payment_receipt()
    {
        $paymentReceipt = PaymentReceipt::factory()->create();

        $response = $this->deleteJson(
            route('api.payment-receipts.destroy', $paymentReceipt)
        );

        $this->assertModelMissing($paymentReceipt);

        $response->assertNoContent();
    }
}
