<?php

namespace Tests\Feature\Api;

use App\Models\User;
use App\Models\EProduct;
use App\Models\SoDdetail;

use Tests\TestCase;
use Laravel\Sanctum\Sanctum;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;

class EProductSoDdetailsTest extends TestCase
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
    public function it_gets_e_product_so_ddetails(): void
    {
        $eProduct = EProduct::factory()->create();
        $soDdetails = SoDdetail::factory()
            ->count(2)
            ->create([
                'e_product_id' => $eProduct->id,
            ]);

        $response = $this->getJson(
            route('api.e-products.so-ddetails.index', $eProduct)
        );

        $response->assertOk()->assertSee($soDdetails[0]->id);
    }

    /**
     * @test
     */
    public function it_stores_the_e_product_so_ddetails(): void
    {
        $eProduct = EProduct::factory()->create();
        $data = SoDdetail::factory()
            ->make([
                'e_product_id' => $eProduct->id,
            ])
            ->toArray();

        $response = $this->postJson(
            route('api.e-products.so-ddetails.store', $eProduct),
            $data
        );

        unset($data['sales_order_direct_id']);

        $this->assertDatabaseHas('so_ddetails', $data);

        $response->assertStatus(201)->assertJsonFragment($data);

        $soDdetail = SoDdetail::latest('id')->first();

        $this->assertEquals($eProduct->id, $soDdetail->e_product_id);
    }
}
