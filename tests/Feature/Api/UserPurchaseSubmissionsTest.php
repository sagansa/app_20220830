<?php

namespace Tests\Feature\Api;

use App\Models\User;
use App\Models\PurchaseSubmission;

use Tests\TestCase;
use Laravel\Sanctum\Sanctum;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;

class UserPurchaseSubmissionsTest extends TestCase
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
    public function it_gets_user_purchase_submissions()
    {
        $user = User::factory()->create();
        $purchaseSubmissions = PurchaseSubmission::factory()
            ->count(2)
            ->create([
                'user_id' => $user->id,
            ]);

        $response = $this->getJson(
            route('api.users.purchase-submissions.index', $user)
        );

        $response->assertOk()->assertSee($purchaseSubmissions[0]->date);
    }

    /**
     * @test
     */
    public function it_stores_the_user_purchase_submissions()
    {
        $user = User::factory()->create();
        $data = PurchaseSubmission::factory()
            ->make([
                'user_id' => $user->id,
            ])
            ->toArray();

        $response = $this->postJson(
            route('api.users.purchase-submissions.store', $user),
            $data
        );

        unset($data['store_id']);
        unset($data['date']);
        unset($data['user_id']);

        $this->assertDatabaseHas('purchase_submissions', $data);

        $response->assertStatus(201)->assertJsonFragment($data);

        $purchaseSubmission = PurchaseSubmission::latest('id')->first();

        $this->assertEquals($user->id, $purchaseSubmission->user_id);
    }
}
