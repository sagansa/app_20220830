<?php

namespace Tests\Feature\Controllers;

use App\Models\User;
use App\Models\Cart;

use App\Models\EProduct;

use Tests\TestCase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;

class CartControllerTest extends TestCase
{
    use RefreshDatabase, WithFaker;

    protected function setUp(): void
    {
        parent::setUp();

        $this->actingAs(
            User::factory()->create(['email' => 'admin@admin.com'])
        );

        $this->seed(\Database\Seeders\PermissionsSeeder::class);

        $this->withoutExceptionHandling();
    }

    /**
     * @test
     */
    public function it_displays_index_view_with_carts(): void
    {
        $carts = Cart::factory()
            ->count(5)
            ->create();

        $response = $this->get(route('carts.index'));

        $response
            ->assertOk()
            ->assertViewIs('app.carts.index')
            ->assertViewHas('carts');
    }

    /**
     * @test
     */
    public function it_displays_create_view_for_cart(): void
    {
        $response = $this->get(route('carts.create'));

        $response->assertOk()->assertViewIs('app.carts.create');
    }

    /**
     * @test
     */
    public function it_stores_the_cart(): void
    {
        $data = Cart::factory()
            ->make()
            ->toArray();

        $response = $this->post(route('carts.store'), $data);

        $this->assertDatabaseHas('carts', $data);

        $cart = Cart::latest('id')->first();

        $response->assertRedirect(route('carts.edit', $cart));
    }

    /**
     * @test
     */
    public function it_displays_show_view_for_cart(): void
    {
        $cart = Cart::factory()->create();

        $response = $this->get(route('carts.show', $cart));

        $response
            ->assertOk()
            ->assertViewIs('app.carts.show')
            ->assertViewHas('cart');
    }

    /**
     * @test
     */
    public function it_displays_edit_view_for_cart(): void
    {
        $cart = Cart::factory()->create();

        $response = $this->get(route('carts.edit', $cart));

        $response
            ->assertOk()
            ->assertViewIs('app.carts.edit')
            ->assertViewHas('cart');
    }

    /**
     * @test
     */
    public function it_updates_the_cart(): void
    {
        $cart = Cart::factory()->create();

        $user = User::factory()->create();
        $eProduct = EProduct::factory()->create();

        $data = [
            'quantity' => $this->faker->randomNumber,
            'user_id' => $user->id,
            'e_product_id' => $eProduct->id,
        ];

        $response = $this->put(route('carts.update', $cart), $data);

        $data['id'] = $cart->id;

        $this->assertDatabaseHas('carts', $data);

        $response->assertRedirect(route('carts.edit', $cart));
    }

    /**
     * @test
     */
    public function it_deletes_the_cart(): void
    {
        $cart = Cart::factory()->create();

        $response = $this->delete(route('carts.destroy', $cart));

        $response->assertRedirect(route('carts.index'));

        $this->assertModelMissing($cart);
    }
}
