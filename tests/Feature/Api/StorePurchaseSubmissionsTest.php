<?php

namespace Tests\Feature\Api;

use App\Models\User;
use App\Models\Store;
use App\Models\PurchaseSubmission;

use Tests\TestCase;
use Laravel\Sanctum\Sanctum;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;

class StorePurchaseSubmissionsTest extends TestCase
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
    public function it_gets_store_purchase_submissions()
    {
        $store = Store::factory()->create();
        $purchaseSubmissions = PurchaseSubmission::factory()
            ->count(2)
            ->create([
                'store_id' => $store->id,
            ]);

        $response = $this->getJson(
            route('api.stores.purchase-submissions.index', $store)
        );

        $response->assertOk()->assertSee($purchaseSubmissions[0]->date);
    }

    /**
     * @test
     */
    public function it_stores_the_store_purchase_submissions()
    {
        $store = Store::factory()->create();
        $data = PurchaseSubmission::factory()
            ->make([
                'store_id' => $store->id,
            ])
            ->toArray();

        $response = $this->postJson(
            route('api.stores.purchase-submissions.store', $store),
            $data
        );

        unset($data['store_id']);
        unset($data['date']);
        unset($data['user_id']);

        $this->assertDatabaseHas('purchase_submissions', $data);

        $response->assertStatus(201)->assertJsonFragment($data);

        $purchaseSubmission = PurchaseSubmission::latest('id')->first();

        $this->assertEquals($store->id, $purchaseSubmission->store_id);
    }
}
