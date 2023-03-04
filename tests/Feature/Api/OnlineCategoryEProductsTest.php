<?php

namespace Tests\Feature\Api;

use App\Models\User;
use App\Models\EProduct;
use App\Models\OnlineCategory;

use Tests\TestCase;
use Laravel\Sanctum\Sanctum;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;

class OnlineCategoryEProductsTest extends TestCase
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
    public function it_gets_online_category_e_products(): void
    {
        $onlineCategory = OnlineCategory::factory()->create();
        $eProducts = EProduct::factory()
            ->count(2)
            ->create([
                'online_category_id' => $onlineCategory->id,
            ]);

        $response = $this->getJson(
            route('api.online-categories.e-products.index', $onlineCategory)
        );

        $response->assertOk()->assertSee($eProducts[0]->image);
    }

    /**
     * @test
     */
    public function it_stores_the_online_category_e_products(): void
    {
        $onlineCategory = OnlineCategory::factory()->create();
        $data = EProduct::factory()
            ->make([
                'online_category_id' => $onlineCategory->id,
            ])
            ->toArray();

        $response = $this->postJson(
            route('api.online-categories.e-products.store', $onlineCategory),
            $data
        );

        $this->assertDatabaseHas('e_products', $data);

        $response->assertStatus(201)->assertJsonFragment($data);

        $eProduct = EProduct::latest('id')->first();

        $this->assertEquals($onlineCategory->id, $eProduct->online_category_id);
    }
}
