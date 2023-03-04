<?php

namespace Tests\Feature\Api;

use App\Models\User;
use App\Models\ProductGroup;

use Tests\TestCase;
use Laravel\Sanctum\Sanctum;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;

class ProductGroupTest extends TestCase
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
    public function it_gets_product_groups_list(): void
    {
        $productGroups = ProductGroup::factory()
            ->count(5)
            ->create();

        $response = $this->getJson(route('api.product-groups.index'));

        $response->assertOk()->assertSee($productGroups[0]->name);
    }

    /**
     * @test
     */
    public function it_stores_the_product_group(): void
    {
        $data = ProductGroup::factory()
            ->make()
            ->toArray();

        $response = $this->postJson(route('api.product-groups.store'), $data);

        $this->assertDatabaseHas('product_groups', $data);

        $response->assertStatus(201)->assertJsonFragment($data);
    }

    /**
     * @test
     */
    public function it_updates_the_product_group(): void
    {
        $productGroup = ProductGroup::factory()->create();

        $data = [
            'name' => $this->faker->text(50),
        ];

        $response = $this->putJson(
            route('api.product-groups.update', $productGroup),
            $data
        );

        $data['id'] = $productGroup->id;

        $this->assertDatabaseHas('product_groups', $data);

        $response->assertOk()->assertJsonFragment($data);
    }

    /**
     * @test
     */
    public function it_deletes_the_product_group(): void
    {
        $productGroup = ProductGroup::factory()->create();

        $response = $this->deleteJson(
            route('api.product-groups.destroy', $productGroup)
        );

        $this->assertModelMissing($productGroup);

        $response->assertNoContent();
    }
}
