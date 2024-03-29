<?php

namespace Tests\Feature\Api;

use App\Models\User;
use App\Models\Cart;

use Tests\TestCase;
use Laravel\Sanctum\Sanctum;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;

class UserCartsTest extends TestCase
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
    public function it_gets_user_carts(): void
    {
        $user = User::factory()->create();
        $carts = Cart::factory()
            ->count(2)
            ->create([
                'user_id' => $user->id,
            ]);

        $response = $this->getJson(route('api.users.carts.index', $user));

        $response->assertOk()->assertSee($carts[0]->id);
    }

    /**
     * @test
     */
    public function it_stores_the_user_carts(): void
    {
        $user = User::factory()->create();
        $data = Cart::factory()
            ->make([
                'user_id' => $user->id,
            ])
            ->toArray();

        $response = $this->postJson(
            route('api.users.carts.store', $user),
            $data
        );

        $this->assertDatabaseHas('carts', $data);

        $response->assertStatus(201)->assertJsonFragment($data);

        $cart = Cart::latest('id')->first();

        $this->assertEquals($user->id, $cart->user_id);
    }
}
