<?php

namespace Tests\Feature\Api;

use App\Models\User;
use App\Models\RequestPurchase;

use App\Models\Store;

use Tests\TestCase;
use Laravel\Sanctum\Sanctum;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;

class RequestPurchaseTest extends TestCase
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
    public function it_gets_request_purchases_list()
    {
        $requestPurchases = RequestPurchase::factory()
            ->count(5)
            ->create();

        $response = $this->getJson(route('api.request-purchases.index'));

        $response->assertOk()->assertSee($requestPurchases[0]->date);
    }

    /**
     * @test
     */
    public function it_stores_the_request_purchase()
    {
        $data = RequestPurchase::factory()
            ->make()
            ->toArray();

        $response = $this->postJson(
            route('api.request-purchases.store'),
            $data
        );

        $this->assertDatabaseHas('request_purchases', $data);

        $response->assertStatus(201)->assertJsonFragment($data);
    }

    /**
     * @test
     */
    public function it_updates_the_request_purchase()
    {
        $requestPurchase = RequestPurchase::factory()->create();

        $store = Store::factory()->create();
        $user = User::factory()->create();

        $data = [
            'date' => $this->faker->date,
            'status' => $this->faker->numberBetween(1, 2),
            'store_id' => $store->id,
            'user_id' => $user->id,
        ];

        $response = $this->putJson(
            route('api.request-purchases.update', $requestPurchase),
            $data
        );

        $data['id'] = $requestPurchase->id;

        $this->assertDatabaseHas('request_purchases', $data);

        $response->assertOk()->assertJsonFragment($data);
    }

    /**
     * @test
     */
    public function it_deletes_the_request_purchase()
    {
        $requestPurchase = RequestPurchase::factory()->create();

        $response = $this->deleteJson(
            route('api.request-purchases.destroy', $requestPurchase)
        );

        $this->assertModelMissing($requestPurchase);

        $response->assertNoContent();
    }
}
