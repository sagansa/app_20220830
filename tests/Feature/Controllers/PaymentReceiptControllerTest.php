<?php

namespace Tests\Feature\Controllers;

use App\Models\User;
use App\Models\PaymentReceipt;

use Tests\TestCase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;

class PaymentReceiptControllerTest extends TestCase
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
    public function it_displays_index_view_with_payment_receipts()
    {
        $paymentReceipts = PaymentReceipt::factory()
            ->count(5)
            ->create();

        $response = $this->get(route('payment-receipts.index'));

        $response
            ->assertOk()
            ->assertViewIs('app.payment_receipts.index')
            ->assertViewHas('paymentReceipts');
    }

    /**
     * @test
     */
    public function it_displays_create_view_for_payment_receipt()
    {
        $response = $this->get(route('payment-receipts.create'));

        $response->assertOk()->assertViewIs('app.payment_receipts.create');
    }

    /**
     * @test
     */
    public function it_stores_the_payment_receipt()
    {
        $data = PaymentReceipt::factory()
            ->make()
            ->toArray();

        $response = $this->post(route('payment-receipts.store'), $data);

        $this->assertDatabaseHas('payment_receipts', $data);

        $paymentReceipt = PaymentReceipt::latest('id')->first();

        $response->assertRedirect(
            route('payment-receipts.edit', $paymentReceipt)
        );
    }

    /**
     * @test
     */
    public function it_displays_show_view_for_payment_receipt()
    {
        $paymentReceipt = PaymentReceipt::factory()->create();

        $response = $this->get(route('payment-receipts.show', $paymentReceipt));

        $response
            ->assertOk()
            ->assertViewIs('app.payment_receipts.show')
            ->assertViewHas('paymentReceipt');
    }

    /**
     * @test
     */
    public function it_displays_edit_view_for_payment_receipt()
    {
        $paymentReceipt = PaymentReceipt::factory()->create();

        $response = $this->get(route('payment-receipts.edit', $paymentReceipt));

        $response
            ->assertOk()
            ->assertViewIs('app.payment_receipts.edit')
            ->assertViewHas('paymentReceipt');
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
            'image_adjust' => $this->faker->text(255),
            'notes' => $this->faker->text,
        ];

        $response = $this->put(
            route('payment-receipts.update', $paymentReceipt),
            $data
        );

        $data['id'] = $paymentReceipt->id;

        $this->assertDatabaseHas('payment_receipts', $data);

        $response->assertRedirect(
            route('payment-receipts.edit', $paymentReceipt)
        );
    }

    /**
     * @test
     */
    public function it_deletes_the_payment_receipt()
    {
        $paymentReceipt = PaymentReceipt::factory()->create();

        $response = $this->delete(
            route('payment-receipts.destroy', $paymentReceipt)
        );

        $response->assertRedirect(route('payment-receipts.index'));

        $this->assertModelMissing($paymentReceipt);
    }
}
