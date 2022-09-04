<?php

namespace Tests\Feature\Api;

use App\Models\User;
use App\Models\Unit;
use App\Models\DetailInvoice;

use Tests\TestCase;
use Laravel\Sanctum\Sanctum;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;

class UnitDetailInvoicesTest extends TestCase
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
    public function it_gets_unit_detail_invoices()
    {
        $unit = Unit::factory()->create();
        $detailInvoices = DetailInvoice::factory()
            ->count(2)
            ->create([
                'unit_invoice_id' => $unit->id,
            ]);

        $response = $this->getJson(
            route('api.units.detail-invoices.index', $unit)
        );

        $response->assertOk()->assertSee($detailInvoices[0]->id);
    }

    /**
     * @test
     */
    public function it_stores_the_unit_detail_invoices()
    {
        $unit = Unit::factory()->create();
        $data = DetailInvoice::factory()
            ->make([
                'unit_invoice_id' => $unit->id,
            ])
            ->toArray();

        $response = $this->postJson(
            route('api.units.detail-invoices.store', $unit),
            $data
        );

        unset($data['invoice_purchase_id']);
        unset($data['detail_request_id']);

        $this->assertDatabaseHas('detail_invoices', $data);

        $response->assertStatus(201)->assertJsonFragment($data);

        $detailInvoice = DetailInvoice::latest('id')->first();

        $this->assertEquals($unit->id, $detailInvoice->unit_invoice_id);
    }
}
