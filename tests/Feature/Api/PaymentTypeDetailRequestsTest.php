<?php

namespace Tests\Feature\Api;

use App\Models\User;
use App\Models\PaymentType;
use App\Models\DetailRequest;

use Tests\TestCase;
use Laravel\Sanctum\Sanctum;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;

class PaymentTypeDetailRequestsTest extends TestCase
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
    public function it_gets_payment_type_detail_requests()
    {
        $paymentType = PaymentType::factory()->create();
        $detailRequests = DetailRequest::factory()
            ->count(2)
            ->create([
                'payment_type_id' => $paymentType->id,
            ]);

        $response = $this->getJson(
            route('api.payment-types.detail-requests.index', $paymentType)
        );

        $response->assertOk()->assertSee($detailRequests[0]->notes);
    }

    /**
     * @test
     */
    public function it_stores_the_payment_type_detail_requests()
    {
        $paymentType = PaymentType::factory()->create();
        $data = DetailRequest::factory()
            ->make([
                'payment_type_id' => $paymentType->id,
            ])
            ->toArray();

        $response = $this->postJson(
            route('api.payment-types.detail-requests.store', $paymentType),
            $data
        );

        unset($data['request_purchase_id']);
        unset($data['store_id']);
        unset($data['payment_type_id']);

        $this->assertDatabaseHas('detail_requests', $data);

        $response->assertStatus(201)->assertJsonFragment($data);

        $detailRequest = DetailRequest::latest('id')->first();

        $this->assertEquals($paymentType->id, $detailRequest->payment_type_id);
    }
}
