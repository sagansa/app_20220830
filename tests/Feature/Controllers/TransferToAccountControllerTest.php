<?php

namespace Tests\Feature\Controllers;

use App\Models\User;
use App\Models\TransferToAccount;

use App\Models\Bank;

use Tests\TestCase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;

class TransferToAccountControllerTest extends TestCase
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
    public function it_displays_index_view_with_transfer_to_accounts(): void
    {
        $transferToAccounts = TransferToAccount::factory()
            ->count(5)
            ->create();

        $response = $this->get(route('transfer-to-accounts.index'));

        $response
            ->assertOk()
            ->assertViewIs('app.transfer_to_accounts.index')
            ->assertViewHas('transferToAccounts');
    }

    /**
     * @test
     */
    public function it_displays_create_view_for_transfer_to_account(): void
    {
        $response = $this->get(route('transfer-to-accounts.create'));

        $response->assertOk()->assertViewIs('app.transfer_to_accounts.create');
    }

    /**
     * @test
     */
    public function it_stores_the_transfer_to_account(): void
    {
        $data = TransferToAccount::factory()
            ->make()
            ->toArray();

        $response = $this->post(route('transfer-to-accounts.store'), $data);

        $this->assertDatabaseHas('transfer_to_accounts', $data);

        $transferToAccount = TransferToAccount::latest('id')->first();

        $response->assertRedirect(
            route('transfer-to-accounts.edit', $transferToAccount)
        );
    }

    /**
     * @test
     */
    public function it_displays_show_view_for_transfer_to_account(): void
    {
        $transferToAccount = TransferToAccount::factory()->create();

        $response = $this->get(
            route('transfer-to-accounts.show', $transferToAccount)
        );

        $response
            ->assertOk()
            ->assertViewIs('app.transfer_to_accounts.show')
            ->assertViewHas('transferToAccount');
    }

    /**
     * @test
     */
    public function it_displays_edit_view_for_transfer_to_account(): void
    {
        $transferToAccount = TransferToAccount::factory()->create();

        $response = $this->get(
            route('transfer-to-accounts.edit', $transferToAccount)
        );

        $response
            ->assertOk()
            ->assertViewIs('app.transfer_to_accounts.edit')
            ->assertViewHas('transferToAccount');
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

        $response = $this->put(
            route('transfer-to-accounts.update', $transferToAccount),
            $data
        );

        $data['id'] = $transferToAccount->id;

        $this->assertDatabaseHas('transfer_to_accounts', $data);

        $response->assertRedirect(
            route('transfer-to-accounts.edit', $transferToAccount)
        );
    }

    /**
     * @test
     */
    public function it_deletes_the_transfer_to_account(): void
    {
        $transferToAccount = TransferToAccount::factory()->create();

        $response = $this->delete(
            route('transfer-to-accounts.destroy', $transferToAccount)
        );

        $response->assertRedirect(route('transfer-to-accounts.index'));

        $this->assertModelMissing($transferToAccount);
    }
}
