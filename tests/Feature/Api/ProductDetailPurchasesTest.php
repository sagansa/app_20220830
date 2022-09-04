<?php

namespace Tests\Feature\Api;

use App\Models\User;
use App\Models\Product;
use App\Models\DetailPurchase;

use Tests\TestCase;
use Laravel\Sanctum\Sanctum;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;

class ProductDetailPurchasesTest extends TestCase
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
    public function it_gets_product_detail_purchases()
    {
        $product = Product::factory()->create();
        $detailPurchases = DetailPurchase::factory()
            ->count(2)
            ->create([
                'product_id' => $product->id,
            ]);

        $response = $this->getJson(
            route('api.products.detail-purchases.index', $product)
        );

        $response->assertOk()->assertSee($detailPurchases[0]->notes);
    }

    /**
     * @test
     */
    public function it_stores_the_product_detail_purchases()
    {
        $product = Product::factory()->create();
        $data = DetailPurchase::factory()
            ->make([
                'product_id' => $product->id,
            ])
            ->toArray();

        $response = $this->postJson(
            route('api.products.detail-purchases.store', $product),
            $data
        );

        unset($data['product_id']);
        unset($data['quantity_plan']);
        unset($data['status']);
        unset($data['notes']);
        unset($data['purchase_submission_id']);

        $this->assertDatabaseHas('detail_purchases', $data);

        $response->assertStatus(201)->assertJsonFragment($data);

        $detailPurchase = DetailPurchase::latest('id')->first();

        $this->assertEquals($product->id, $detailPurchase->product_id);
    }
}
