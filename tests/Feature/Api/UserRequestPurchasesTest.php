<?php

namespace Tests\Feature\Api;

use App\Models\User;
use App\Models\RequestPurchase;

use Tests\TestCase;
use Laravel\Sanctum\Sanctum;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;

class UserRequestPurchasesTest extends TestCase
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
    public function it_gets_user_request_purchases(): void
    {
        $user = User::factory()->create();
        $requestPurchases = RequestPurchase::factory()
            ->count(2)
            ->create([
                'user_id' => $user->id,
            ]);

        $response = $this->getJson(
            route('api.users.request-purchases.index', $user)
        );

        $response->assertOk()->assertSee($requestPurchases[0]->date);
    }

    /**
     * @test
     */
    public function it_stores_the_user_request_purchases(): void
    {
        $user = User::factory()->create();
        $data = RequestPurchase::factory()
            ->make([
                'user_id' => $user->id,
            ])
            ->toArray();

        $response = $this->postJson(
            route('api.users.request-purchases.store', $user),
            $data
        );

        $this->assertDatabaseHas('request_purchases', $data);

        $response->assertStatus(201)->assertJsonFragment($data);

        $requestPurchase = RequestPurchase::latest('id')->first();

        $this->assertEquals($user->id, $requestPurchase->user_id);
    }
}
