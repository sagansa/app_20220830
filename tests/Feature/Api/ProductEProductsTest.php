<?php

namespace Tests\Feature\Api;

use App\Models\User;
use App\Models\Product;
use App\Models\EProduct;

use Tests\TestCase;
use Laravel\Sanctum\Sanctum;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;

class ProductEProductsTest extends TestCase
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
    public function it_gets_product_e_products(): void
    {
        $product = Product::factory()->create();
        $eProducts = EProduct::factory()
            ->count(2)
            ->create([
                'product_id' => $product->id,
            ]);

        $response = $this->getJson(
            route('api.products.e-products.index', $product)
        );

        $response->assertOk()->assertSee($eProducts[0]->image);
    }

    /**
     * @test
     */
    public function it_stores_the_product_e_products(): void
    {
        $product = Product::factory()->create();
        $data = EProduct::factory()
            ->make([
                'product_id' => $product->id,
            ])
            ->toArray();

        $response = $this->postJson(
            route('api.products.e-products.store', $product),
            $data
        );

        $this->assertDatabaseHas('e_products', $data);

        $response->assertStatus(201)->assertJsonFragment($data);

        $eProduct = EProduct::latest('id')->first();

        $this->assertEquals($product->id, $eProduct->product_id);
    }
}
