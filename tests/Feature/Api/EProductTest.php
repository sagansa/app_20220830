<?php

namespace Tests\Feature\Api;

use App\Models\User;
use App\Models\EProduct;

use App\Models\Store;
use App\Models\Product;
use App\Models\OnlineCategory;

use Tests\TestCase;
use Laravel\Sanctum\Sanctum;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;

class EProductTest extends TestCase
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
    public function it_gets_e_products_list()
    {
        $eProducts = EProduct::factory()
            ->count(5)
            ->create();

        $response = $this->getJson(route('api.e-products.index'));

        $response->assertOk()->assertSee($eProducts[0]->image);
    }

    /**
     * @test
     */
    public function it_stores_the_e_product()
    {
        $data = EProduct::factory()
            ->make()
            ->toArray();

        $response = $this->postJson(route('api.e-products.store'), $data);

        $this->assertDatabaseHas('e_products', $data);

        $response->assertStatus(201)->assertJsonFragment($data);
    }

    /**
     * @test
     */
    public function it_updates_the_e_product()
    {
        $eProduct = EProduct::factory()->create();

        $product = Product::factory()->create();
        $store = Store::factory()->create();
        $onlineCategory = OnlineCategory::factory()->create();

        $data = [
            'quantity_stock' => $this->faker->randomNumber,
            'price' => $this->faker->randomFloat(2, 0, 9999),
            'status' => $this->faker->numberBetween(0, 127),
            'product_id' => $product->id,
            'store_id' => $store->id,
            'online_category_id' => $onlineCategory->id,
        ];

        $response = $this->putJson(
            route('api.e-products.update', $eProduct),
            $data
        );

        $data['id'] = $eProduct->id;

        $this->assertDatabaseHas('e_products', $data);

        $response->assertOk()->assertJsonFragment($data);
    }

    /**
     * @test
     */
    public function it_deletes_the_e_product()
    {
        $eProduct = EProduct::factory()->create();

        $response = $this->deleteJson(
            route('api.e-products.destroy', $eProduct)
        );

        $this->assertModelMissing($eProduct);

        $response->assertNoContent();
    }
}
