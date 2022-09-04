<?php

namespace Tests\Feature\Api;

use App\Models\User;
use App\Models\Store;
use App\Models\RequestPurchase;

use Tests\TestCase;
use Laravel\Sanctum\Sanctum;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;

class StoreRequestPurchasesTest extends TestCase
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
    public function it_gets_store_request_purchases()
    {
        $store = Store::factory()->create();
        $requestPurchases = RequestPurchase::factory()
            ->count(2)
            ->create([
                'store_id' => $store->id,
            ]);

        $response = $this->getJson(
            route('api.stores.request-purchases.index', $store)
        );

        $response->assertOk()->assertSee($requestPurchases[0]->date);
    }

    /**
     * @test
     */
    public function it_stores_the_store_request_purchases()
    {
        $store = Store::factory()->create();
        $data = RequestPurchase::factory()
            ->make([
                'store_id' => $store->id,
            ])
            ->toArray();

        $response = $this->postJson(
            route('api.stores.request-purchases.store', $store),
            $data
        );

        $this->assertDatabaseHas('request_purchases', $data);

        $response->assertStatus(201)->assertJsonFragment($data);

        $requestPurchase = RequestPurchase::latest('id')->first();

        $this->assertEquals($store->id, $requestPurchase->store_id);
    }
}
