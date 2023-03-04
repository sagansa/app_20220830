<?php

namespace Tests\Feature\Api;

use App\Models\User;
use App\Models\Store;
use App\Models\DetailRequest;

use Tests\TestCase;
use Laravel\Sanctum\Sanctum;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;

class StoreDetailRequestsTest extends TestCase
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
    public function it_gets_store_detail_requests(): void
    {
        $store = Store::factory()->create();
        $detailRequests = DetailRequest::factory()
            ->count(2)
            ->create([
                'store_id' => $store->id,
            ]);

        $response = $this->getJson(
            route('api.stores.detail-requests.index', $store)
        );

        $response->assertOk()->assertSee($detailRequests[0]->notes);
    }

    /**
     * @test
     */
    public function it_stores_the_store_detail_requests(): void
    {
        $store = Store::factory()->create();
        $data = DetailRequest::factory()
            ->make([
                'store_id' => $store->id,
            ])
            ->toArray();

        $response = $this->postJson(
            route('api.stores.detail-requests.store', $store),
            $data
        );

        unset($data['request_purchase_id']);
        unset($data['store_id']);
        unset($data['payment_type_id']);

        $this->assertDatabaseHas('detail_requests', $data);

        $response->assertStatus(201)->assertJsonFragment($data);

        $detailRequest = DetailRequest::latest('id')->first();

        $this->assertEquals($store->id, $detailRequest->store_id);
    }
}
