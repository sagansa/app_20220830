<?php

namespace Tests\Feature\Controllers;

use App\Models\User;
use App\Models\Coupon;

use Tests\TestCase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;

class CouponControllerTest extends TestCase
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
    public function it_displays_index_view_with_coupons(): void
    {
        $coupons = Coupon::factory()
            ->count(5)
            ->create();

        $response = $this->get(route('coupons.index'));

        $response
            ->assertOk()
            ->assertViewIs('app.coupons.index')
            ->assertViewHas('coupons');
    }

    /**
     * @test
     */
    public function it_displays_create_view_for_coupon(): void
    {
        $response = $this->get(route('coupons.create'));

        $response->assertOk()->assertViewIs('app.coupons.create');
    }

    /**
     * @test
     */
    public function it_stores_the_coupon(): void
    {
        $data = Coupon::factory()
            ->make()
            ->toArray();

        $response = $this->post(route('coupons.store'), $data);

        $this->assertDatabaseHas('coupons', $data);

        $coupon = Coupon::latest('id')->first();

        $response->assertRedirect(route('coupons.edit', $coupon));
    }

    /**
     * @test
     */
    public function it_displays_show_view_for_coupon(): void
    {
        $coupon = Coupon::factory()->create();

        $response = $this->get(route('coupons.show', $coupon));

        $response
            ->assertOk()
            ->assertViewIs('app.coupons.show')
            ->assertViewHas('coupon');
    }

    /**
     * @test
     */
    public function it_displays_edit_view_for_coupon(): void
    {
        $coupon = Coupon::factory()->create();

        $response = $this->get(route('coupons.edit', $coupon));

        $response
            ->assertOk()
            ->assertViewIs('app.coupons.edit')
            ->assertViewHas('coupon');
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

        $response = $this->put(route('coupons.update', $coupon), $data);

        $data['id'] = $coupon->id;

        $this->assertDatabaseHas('coupons', $data);

        $response->assertRedirect(route('coupons.edit', $coupon));
    }

    /**
     * @test
     */
    public function it_deletes_the_coupon(): void
    {
        $coupon = Coupon::factory()->create();

        $response = $this->delete(route('coupons.destroy', $coupon));

        $response->assertRedirect(route('coupons.index'));

        $this->assertModelMissing($coupon);
    }
}
