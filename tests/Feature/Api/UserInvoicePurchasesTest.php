<?php

namespace Tests\Feature\Api;

use App\Models\User;
use App\Models\InvoicePurchase;

use Tests\TestCase;
use Laravel\Sanctum\Sanctum;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;

class UserInvoicePurchasesTest extends TestCase
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
    public function it_gets_user_invoice_purchases(): void
    {
        $user = User::factory()->create();
        $invoicePurchases = InvoicePurchase::factory()
            ->count(2)
            ->create([
                'created_by_id' => $user->id,
            ]);

        $response = $this->getJson(
            route('api.users.invoice-purchases.index', $user)
        );

        $response->assertOk()->assertSee($invoicePurchases[0]->image);
    }

    /**
     * @test
     */
    public function it_stores_the_user_invoice_purchases(): void
    {
        $user = User::factory()->create();
        $data = InvoicePurchase::factory()
            ->make([
                'created_by_id' => $user->id,
            ])
            ->toArray();

        $response = $this->postJson(
            route('api.users.invoice-purchases.store', $user),
            $data
        );

        unset($data['approved_id']);

        $this->assertDatabaseHas('invoice_purchases', $data);

        $response->assertStatus(201)->assertJsonFragment($data);

        $invoicePurchase = InvoicePurchase::latest('id')->first();

        $this->assertEquals($user->id, $invoicePurchase->created_by_id);
    }
}
