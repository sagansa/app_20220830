<?php

namespace Tests\Feature\Api;

use App\Models\User;
use App\Models\PaymentType;

use Tests\TestCase;
use Laravel\Sanctum\Sanctum;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;

class PaymentTypeTest extends TestCase
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
    public function it_gets_payment_types_list()
    {
        $paymentTypes = PaymentType::factory()
            ->count(5)
            ->create();

        $response = $this->getJson(route('api.payment-types.index'));

        $response->assertOk()->assertSee($paymentTypes[0]->name);
    }

    /**
     * @test
     */
    public function it_stores_the_payment_type()
    {
        $data = PaymentType::factory()
            ->make()
            ->toArray();

        $response = $this->postJson(route('api.payment-types.store'), $data);

        $this->assertDatabaseHas('payment_types', $data);

        $response->assertStatus(201)->assertJsonFragment($data);
    }

    /**
     * @test
     */
    public function it_updates_the_payment_type()
    {
        $paymentType = PaymentType::factory()->create();

        $data = [
            'name' => $this->faker->text(10),
            'status' => $this->faker->numberBetween(1, 2),
        ];

        $response = $this->putJson(
            route('api.payment-types.update', $paymentType),
            $data
        );

        $data['id'] = $paymentType->id;

        $this->assertDatabaseHas('payment_types', $data);

        $response->assertOk()->assertJsonFragment($data);
    }

    /**
     * @test
     */
    public function it_deletes_the_payment_type()
    {
        $paymentType = PaymentType::factory()->create();

        $response = $this->deleteJson(
            route('api.payment-types.destroy', $paymentType)
        );

        $this->assertModelMissing($paymentType);

        $response->assertNoContent();
    }
}
