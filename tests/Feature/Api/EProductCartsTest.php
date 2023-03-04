<?php

namespace Tests\Feature\Api;

use App\Models\User;
use App\Models\Cart;
use App\Models\EProduct;

use Tests\TestCase;
use Laravel\Sanctum\Sanctum;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;

class EProductCartsTest extends TestCase
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
    public function it_gets_e_product_carts(): void
    {
        $eProduct = EProduct::factory()->create();
        $carts = Cart::factory()
            ->count(2)
            ->create([
                'e_product_id' => $eProduct->id,
            ]);

        $response = $this->getJson(
            route('api.e-products.carts.index', $eProduct)
        );

        $response->assertOk()->assertSee($carts[0]->id);
    }

    /**
     * @test
     */
    public function it_stores_the_e_product_carts(): void
    {
        $eProduct = EProduct::factory()->create();
        $data = Cart::factory()
            ->make([
                'e_product_id' => $eProduct->id,
            ])
            ->toArray();

        $response = $this->postJson(
            route('api.e-products.carts.store', $eProduct),
            $data
        );

        $this->assertDatabaseHas('carts', $data);

        $response->assertStatus(201)->assertJsonFragment($data);

        $cart = Cart::latest('id')->first();

        $this->assertEquals($eProduct->id, $cart->e_product_id);
    }
}
