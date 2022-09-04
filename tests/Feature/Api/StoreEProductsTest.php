<?php

namespace Tests\Feature\Api;

use App\Models\User;
use App\Models\Store;
use App\Models\EProduct;

use Tests\TestCase;
use Laravel\Sanctum\Sanctum;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;

class StoreEProductsTest extends TestCase
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
    public function it_gets_store_e_products()
    {
        $store = Store::factory()->create();
        $eProducts = EProduct::factory()
            ->count(2)
            ->create([
                'store_id' => $store->id,
            ]);

        $response = $this->getJson(
            route('api.stores.e-products.index', $store)
        );

        $response->assertOk()->assertSee($eProducts[0]->image);
    }

    /**
     * @test
     */
    public function it_stores_the_store_e_products()
    {
        $store = Store::factory()->create();
        $data = EProduct::factory()
            ->make([
                'store_id' => $store->id,
            ])
            ->toArray();

        $response = $this->postJson(
            route('api.stores.e-products.store', $store),
            $data
        );

        $this->assertDatabaseHas('e_products', $data);

        $response->assertStatus(201)->assertJsonFragment($data);

        $eProduct = EProduct::latest('id')->first();

        $this->assertEquals($store->id, $eProduct->store_id);
    }
}
