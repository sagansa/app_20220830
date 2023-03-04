<?php

namespace Tests\Feature\Api;

use App\Models\User;
use App\Models\TransferToAccount;

use App\Models\Bank;

use Tests\TestCase;
use Laravel\Sanctum\Sanctum;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;

class TransferToAccountTest extends TestCase
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
    public function it_gets_transfer_to_accounts_list(): void
    {
        $transferToAccounts = TransferToAccount::factory()
            ->count(5)
            ->create();

        $response = $this->getJson(route('api.transfer-to-accounts.index'));

        $response->assertOk()->assertSee($transferToAccounts[0]->name);
    }

    /**
     * @test
     */
    public function it_stores_the_transfer_to_account(): void
    {
        $data = TransferToAccount::factory()
            ->make()
            ->toArray();

        $response = $this->postJson(
            route('api.transfer-to-accounts.store'),
            $data
        );

        $this->assertDatabaseHas('transfer_to_accounts', $data);

        $response->assertStatus(201)->assertJsonFragment($data);
    }

    /**
     * @test
     */
    public function it_updates_the_transfer_to_account(): void
    {
        $transferToAccount = TransferToAccount::factory()->create();

        $bank = Bank::factory()->create();

        $data = [
            'name' => $this->faker->name(),
            'number' => $this->faker->randomNumber,
            'status' => $this->faker->numberBetween(0, 127),
            'bank_id' => $bank->id,
        ];

        $response = $this->putJson(
            route('api.transfer-to-accounts.update', $transferToAccount),
            $data
        );

        $data['id'] = $transferToAccount->id;

        $this->assertDatabaseHas('transfer_to_accounts', $data);

        $response->assertOk()->assertJsonFragment($data);
    }

    /**
     * @test
     */
    public function it_deletes_the_transfer_to_account(): void
    {
        $transferToAccount = TransferToAccount::factory()->create();

        $response = $this->deleteJson(
            route('api.transfer-to-accounts.destroy', $transferToAccount)
        );

        $this->assertModelMissing($transferToAccount);

        $response->assertNoContent();
    }
}
