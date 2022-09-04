<?php

namespace Tests\Feature\Controllers;

use App\Models\User;
use App\Models\EProduct;

use App\Models\Store;
use App\Models\Product;
use App\Models\OnlineCategory;

use Tests\TestCase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;

class EProductControllerTest extends TestCase
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
    public function it_displays_index_view_with_e_products()
    {
        $eProducts = EProduct::factory()
            ->count(5)
            ->create();

        $response = $this->get(route('e-products.index'));

        $response
            ->assertOk()
            ->assertViewIs('app.e_products.index')
            ->assertViewHas('eProducts');
    }

    /**
     * @test
     */
    public function it_displays_create_view_for_e_product()
    {
        $response = $this->get(route('e-products.create'));

        $response->assertOk()->assertViewIs('app.e_products.create');
    }

    /**
     * @test
     */
    public function it_stores_the_e_product()
    {
        $data = EProduct::factory()
            ->make()
            ->toArray();

        $response = $this->post(route('e-products.store'), $data);

        $this->assertDatabaseHas('e_products', $data);

        $eProduct = EProduct::latest('id')->first();

        $response->assertRedirect(route('e-products.edit', $eProduct));
    }

    /**
     * @test
     */
    public function it_displays_show_view_for_e_product()
    {
        $eProduct = EProduct::factory()->create();

        $response = $this->get(route('e-products.show', $eProduct));

        $response
            ->assertOk()
            ->assertViewIs('app.e_products.show')
            ->assertViewHas('eProduct');
    }

    /**
     * @test
     */
    public function it_displays_edit_view_for_e_product()
    {
        $eProduct = EProduct::factory()->create();

        $response = $this->get(route('e-products.edit', $eProduct));

        $response
            ->assertOk()
            ->assertViewIs('app.e_products.edit')
            ->assertViewHas('eProduct');
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

        $response = $this->put(route('e-products.update', $eProduct), $data);

        $data['id'] = $eProduct->id;

        $this->assertDatabaseHas('e_products', $data);

        $response->assertRedirect(route('e-products.edit', $eProduct));
    }

    /**
     * @test
     */
    public function it_deletes_the_e_product()
    {
        $eProduct = EProduct::factory()->create();

        $response = $this->delete(route('e-products.destroy', $eProduct));

        $response->assertRedirect(route('e-products.index'));

        $this->assertModelMissing($eProduct);
    }
}
