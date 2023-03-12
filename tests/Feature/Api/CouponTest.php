<?php

namespace Tests\Feature\Api;

use App\Models\User;
use App\Models\Coupon;

use Tests\TestCase;
use Laravel\Sanctum\Sanctum;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;

class CouponTest extends TestCase
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
    public function it_gets_coupons_list(): void
    {
        $coupons = Coupon::factory()
            ->count(5)
            ->create();

        $response = $this->getJson(route('api.coupons.index'));

        $response->assertOk()->assertSee($coupons[0]->name);
    }

    /**
     * @test
     */
    public function it_stores_the_coupon(): void
    {
        $data = Coupon::factory()
            ->make()
            ->toArray();

        $response = $this->postJson(route('api.coupons.store'), $data);

        $this->assertDatabaseHas('coupons', $data);

        $response->assertStatus(201)->assertJsonFragment($data);
    }

    /**
     * @test
     */
    public function it_updates_the_coupon(): void
    {
        $coupon = Coupon::factory()->create();

        $data = [
            'name' => $this->faker->name(),
            'amount' => $this->faker->randomNumber,
        ];

        $response = $this->putJson(route('api.coupons.update', $coupon), $data);

        $data['id'] = $coupon->id;

        $this->assertDatabaseHas('coupons', $data);

        $response->assertOk()->assertJsonFragment($data);
    }

    /**
     * @test
     */
    public function it_deletes_the_coupon(): void
    {
        $coupon = Coupon::factory()->create();

        $response = $this->deleteJson(route('api.coupons.destroy', $coupon));

        $this->assertModelMissing($coupon);

        $response->assertNoContent();
    }
}
