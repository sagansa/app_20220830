<?php

namespace Tests\Feature\Api;

use App\Models\User;
use App\Models\Production;
use App\Models\ProductionMainFrom;

use Tests\TestCase;
use Laravel\Sanctum\Sanctum;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;

class ProductionProductionMainFromsTest extends TestCase
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
    public function it_gets_production_production_main_froms()
    {
        $production = Production::factory()->create();
        $productionMainFroms = ProductionMainFrom::factory()
            ->count(2)
            ->create([
                'production_id' => $production->id,
            ]);

        $response = $this->getJson(
            route('api.productions.production-main-froms.index', $production)
        );

        $response->assertOk()->assertSee($productionMainFroms[0]->id);
    }

    /**
     * @test
     */
    public function it_stores_the_production_production_main_froms()
    {
        $production = Production::factory()->create();
        $data = ProductionMainFrom::factory()
            ->make([
                'production_id' => $production->id,
            ])
            ->toArray();

        $response = $this->postJson(
            route('api.productions.production-main-froms.store', $production),
            $data
        );

        unset($data['production_id']);

        $this->assertDatabaseHas('production_main_froms', $data);

        $response->assertStatus(201)->assertJsonFragment($data);

        $productionMainFrom = ProductionMainFrom::latest('id')->first();

        $this->assertEquals(
            $production->id,
            $productionMainFrom->production_id
        );
    }
}
