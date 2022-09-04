<?php

namespace Tests\Feature\Api;

use App\Models\User;
use App\Models\Product;
use App\Models\DetailRequest;

use Tests\TestCase;
use Laravel\Sanctum\Sanctum;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;

class ProductDetailRequestsTest extends TestCase
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
    public function it_gets_product_detail_requests()
    {
        $product = Product::factory()->create();
        $detailRequests = DetailRequest::factory()
            ->count(2)
            ->create([
                'product_id' => $product->id,
            ]);

        $response = $this->getJson(
            route('api.products.detail-requests.index', $product)
        );

        $response->assertOk()->assertSee($detailRequests[0]->notes);
    }

    /**
     * @test
     */
    public function it_stores_the_product_detail_requests()
    {
        $product = Product::factory()->create();
        $data = DetailRequest::factory()
            ->make([
                'product_id' => $product->id,
            ])
            ->toArray();

        $response = $this->postJson(
            route('api.products.detail-requests.store', $product),
            $data
        );

        unset($data['request_purchase_id']);
        unset($data['store_id']);

        $this->assertDatabaseHas('detail_requests', $data);

        $response->assertStatus(201)->assertJsonFragment($data);

        $detailRequest = DetailRequest::latest('id')->first();

        $this->assertEquals($product->id, $detailRequest->product_id);
    }
}
