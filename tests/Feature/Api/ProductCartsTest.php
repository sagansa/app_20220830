<?php

namespace Tests\Feature\Api;

use App\Models\User;
use App\Models\Cart;
use App\Models\Product;

use Tests\TestCase;
use Laravel\Sanctum\Sanctum;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;

class ProductCartsTest extends TestCase
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
    public function it_gets_product_carts()
    {
        $product = Product::factory()->create();
        $carts = Cart::factory()
            ->count(2)
            ->create([
                'product_id' => $product->id,
            ]);

        $response = $this->getJson(route('api.products.carts.index', $product));

        $response->assertOk()->assertSee($carts[0]->id);
    }

    /**
     * @test
     */
    public function it_stores_the_product_carts()
    {
        $product = Product::factory()->create();
        $data = Cart::factory()
            ->make([
                'product_id' => $product->id,
            ])
            ->toArray();

        $response = $this->postJson(
            route('api.products.carts.store', $product),
            $data
        );

        unset($data['product_id']);

        $this->assertDatabaseHas('carts', $data);

        $response->assertStatus(201)->assertJsonFragment($data);

        $cart = Cart::latest('id')->first();

        $this->assertEquals($product->id, $cart->product_id);
    }
}
