<?php

namespace Tests\Feature\Api;

use App\Models\User;
use App\Models\Cart;

use App\Models\EProduct;

use Tests\TestCase;
use Laravel\Sanctum\Sanctum;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;

class CartTest extends TestCase
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
    public function it_gets_carts_list()
    {
        $carts = Cart::factory()
            ->count(5)
            ->create();

        $response = $this->getJson(route('api.carts.index'));

        $response->assertOk()->assertSee($carts[0]->id);
    }

    /**
     * @test
     */
    public function it_stores_the_cart()
    {
        $data = Cart::factory()
            ->make()
            ->toArray();

        $response = $this->postJson(route('api.carts.store'), $data);

        $this->assertDatabaseHas('carts', $data);

        $response->assertStatus(201)->assertJsonFragment($data);
    }

    /**
     * @test
     */
    public function it_updates_the_cart()
    {
        $cart = Cart::factory()->create();

        $user = User::factory()->create();
        $eProduct = EProduct::factory()->create();

        $data = [
            'quantity' => $this->faker->randomNumber,
            'user_id' => $user->id,
            'e_product_id' => $eProduct->id,
        ];

        $response = $this->putJson(route('api.carts.update', $cart), $data);

        $data['id'] = $cart->id;

        $this->assertDatabaseHas('carts', $data);

        $response->assertOk()->assertJsonFragment($data);
    }

    /**
     * @test
     */
    public function it_deletes_the_cart()
    {
        $cart = Cart::factory()->create();

        $response = $this->deleteJson(route('api.carts.destroy', $cart));

        $this->assertModelMissing($cart);

        $response->assertNoContent();
    }
}
