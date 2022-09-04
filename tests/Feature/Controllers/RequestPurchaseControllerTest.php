<?php

namespace Tests\Feature\Controllers;

use App\Models\User;
use App\Models\RequestPurchase;

use App\Models\Store;

use Tests\TestCase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;

class RequestPurchaseControllerTest extends TestCase
{
    use RefreshDatabase, WithFaker;

    protected function setUp(): void
    {
        parent::setUp();

        $this->actingAs(
            User::factory()->create(['email' => 'admin@admin.com'])
        );

        $this->seed(\Database\Seeders\PermissionsSeeder::class);

        $this->withoutExceptionHandling();
    }

    /**
     * @test
     */
    public function it_displays_index_view_with_request_purchases()
    {
        $requestPurchases = RequestPurchase::factory()
            ->count(5)
            ->create();

        $response = $this->get(route('request-purchases.index'));

        $response
            ->assertOk()
            ->assertViewIs('app.request_purchases.index')
            ->assertViewHas('requestPurchases');
    }

    /**
     * @test
     */
    public function it_displays_create_view_for_request_purchase()
    {
        $response = $this->get(route('request-purchases.create'));

        $response->assertOk()->assertViewIs('app.request_purchases.create');
    }

    /**
     * @test
     */
    public function it_stores_the_request_purchase()
    {
        $data = RequestPurchase::factory()
            ->make()
            ->toArray();

        $response = $this->post(route('request-purchases.store'), $data);

        $this->assertDatabaseHas('request_purchases', $data);

        $requestPurchase = RequestPurchase::latest('id')->first();

        $response->assertRedirect(
            route('request-purchases.edit', $requestPurchase)
        );
    }

    /**
     * @test
     */
    public function it_displays_show_view_for_request_purchase()
    {
        $requestPurchase = RequestPurchase::factory()->create();

        $response = $this->get(
            route('request-purchases.show', $requestPurchase)
        );

        $response
            ->assertOk()
            ->assertViewIs('app.request_purchases.show')
            ->assertViewHas('requestPurchase');
    }

    /**
     * @test
     */
    public function it_displays_edit_view_for_request_purchase()
    {
        $requestPurchase = RequestPurchase::factory()->create();

        $response = $this->get(
            route('request-purchases.edit', $requestPurchase)
        );

        $response
            ->assertOk()
            ->assertViewIs('app.request_purchases.edit')
            ->assertViewHas('requestPurchase');
    }

    /**
     * @test
     */
    public function it_updates_the_request_purchase()
    {
        $requestPurchase = RequestPurchase::factory()->create();

        $store = Store::factory()->create();
        $user = User::factory()->create();

        $data = [
            'date' => $this->faker->date,
            'status' => $this->faker->numberBetween(1, 2),
            'store_id' => $store->id,
            'user_id' => $user->id,
        ];

        $response = $this->put(
            route('request-purchases.update', $requestPurchase),
            $data
        );

        $data['id'] = $requestPurchase->id;

        $this->assertDatabaseHas('request_purchases', $data);

        $response->assertRedirect(
            route('request-purchases.edit', $requestPurchase)
        );
    }

    /**
     * @test
     */
    public function it_deletes_the_request_purchase()
    {
        $requestPurchase = RequestPurchase::factory()->create();

        $response = $this->delete(
            route('request-purchases.destroy', $requestPurchase)
        );

        $response->assertRedirect(route('request-purchases.index'));

        $this->assertModelMissing($requestPurchase);
    }
}
