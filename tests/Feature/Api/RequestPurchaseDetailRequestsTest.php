<?php

namespace Tests\Feature\Api;

use App\Models\User;
use App\Models\DetailRequest;
use App\Models\RequestPurchase;

use Tests\TestCase;
use Laravel\Sanctum\Sanctum;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;

class RequestPurchaseDetailRequestsTest extends TestCase
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
    public function it_gets_request_purchase_detail_requests()
    {
        $requestPurchase = RequestPurchase::factory()->create();
        $detailRequests = DetailRequest::factory()
            ->count(2)
            ->create([
                'request_purchase_id' => $requestPurchase->id,
            ]);

        $response = $this->getJson(
            route(
                'api.request-purchases.detail-requests.index',
                $requestPurchase
            )
        );

        $response->assertOk()->assertSee($detailRequests[0]->notes);
    }

    /**
     * @test
     */
    public function it_stores_the_request_purchase_detail_requests()
    {
        $requestPurchase = RequestPurchase::factory()->create();
        $data = DetailRequest::factory()
            ->make([
                'request_purchase_id' => $requestPurchase->id,
            ])
            ->toArray();

        $response = $this->postJson(
            route(
                'api.request-purchases.detail-requests.store',
                $requestPurchase
            ),
            $data
        );

        unset($data['request_purchase_id']);

        $this->assertDatabaseHas('detail_requests', $data);

        $response->assertStatus(201)->assertJsonFragment($data);

        $detailRequest = DetailRequest::latest('id')->first();

        $this->assertEquals(
            $requestPurchase->id,
            $detailRequest->request_purchase_id
        );
    }
}
