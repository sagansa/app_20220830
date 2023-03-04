<?php

namespace Tests\Feature\Api;

use App\Models\User;
use App\Models\Bank;
use App\Models\TransferToAccount;

use Tests\TestCase;
use Laravel\Sanctum\Sanctum;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;

class BankTransferToAccountsTest extends TestCase
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
    public function it_gets_bank_transfer_to_accounts(): void
    {
        $bank = Bank::factory()->create();
        $transferToAccounts = TransferToAccount::factory()
            ->count(2)
            ->create([
                'bank_id' => $bank->id,
            ]);

        $response = $this->getJson(
            route('api.banks.transfer-to-accounts.index', $bank)
        );

        $response->assertOk()->assertSee($transferToAccounts[0]->name);
    }

    /**
     * @test
     */
    public function it_stores_the_bank_transfer_to_accounts(): void
    {
        $bank = Bank::factory()->create();
        $data = TransferToAccount::factory()
            ->make([
                'bank_id' => $bank->id,
            ])
            ->toArray();

        $response = $this->postJson(
            route('api.banks.transfer-to-accounts.store', $bank),
            $data
        );

        $this->assertDatabaseHas('transfer_to_accounts', $data);

        $response->assertStatus(201)->assertJsonFragment($data);

        $transferToAccount = TransferToAccount::latest('id')->first();

        $this->assertEquals($bank->id, $transferToAccount->bank_id);
    }
}
