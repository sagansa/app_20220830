<?php

namespace Tests\Feature\Api;

use App\Models\User;
use App\Models\Hygiene;

use Tests\TestCase;
use Laravel\Sanctum\Sanctum;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;

class UserHygienesTest extends TestCase
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
    public function it_gets_user_hygienes()
    {
        $user = User::factory()->create();
        $hygienes = Hygiene::factory()
            ->count(2)
            ->create([
                'approved_by_id' => $user->id,
            ]);

        $response = $this->getJson(route('api.users.hygienes.index', $user));

        $response->assertOk()->assertSee($hygienes[0]->notes);
    }

    /**
     * @test
     */
    public function it_stores_the_user_hygienes()
    {
        $user = User::factory()->create();
        $data = Hygiene::factory()
            ->make([
                'approved_by_id' => $user->id,
            ])
            ->toArray();

        $response = $this->postJson(
            route('api.users.hygienes.store', $user),
            $data
        );

        $this->assertDatabaseHas('hygienes', $data);

        $response->assertStatus(201)->assertJsonFragment($data);

        $hygiene = Hygiene::latest('id')->first();

        $this->assertEquals($user->id, $hygiene->approved_by_id);
    }
}
