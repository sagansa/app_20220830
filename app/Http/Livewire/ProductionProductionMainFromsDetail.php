<?php

namespace App\Http\Livewire;

use Livewire\Component;
use App\Models\Production;
use Livewire\WithPagination;
use App\Models\DetailInvoice;
use App\Models\ProductionMainFrom;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;

class ProductionProductionMainFromsDetail extends Component
{
    use WithPagination;
    use AuthorizesRequests;

    public Production $production;
    public ProductionMainFrom $productionMainFrom;
    public $detailInvoicesForSelect = [];

    public $selected = [];
    public $editing = false;
    public $allSelected = false;
    public $showingModal = false;

    public $modalTitle = 'New Production Main From';

    protected $rules = [
        'productionMainFrom.detail_invoice_id' => [
            'required',
            'exists:detail_invoices,id',
        ],
    ];

    public function mount(Production $production)
    {
        $this->production = $production;
        $this->detailInvoicesForSelect = DetailInvoice::whereIn('status', ['1'])
            ->get()
            ->pluck('id', 'detail_invoice_name');
        $this->resetProductionMainFromData();
    }

    public function resetProductionMainFromData()
    {
        $this->productionMainFrom = new ProductionMainFrom();

        $this->productionMainFrom->detail_invoice_id = null;

        $this->dispatchBrowserEvent('refresh');
    }

    public function newProductionMainFrom()
    {
        $this->editing = false;
        $this->modalTitle = trans(
            'crud.production_production_main_froms.new_title'
        );
        $this->resetProductionMainFromData();

        $this->showModal();
    }

    public function editProductionMainFrom(
        ProductionMainFrom $productionMainFrom
    ) {
        $this->editing = true;
        $this->modalTitle = trans(
            'crud.production_production_main_froms.edit_title'
        );
        $this->productionMainFrom = $productionMainFrom;

        $this->dispatchBrowserEvent('refresh');

        $this->showModal();
    }

    public function showModal()
    {
        $this->resetErrorBag();
        $this->showingModal = true;
    }

    public function hideModal()
    {
        $this->showingModal = false;
    }

    public function save()
    {
        $this->validate();

        if (!$this->productionMainFrom->production_id) {
            $this->authorize('create', ProductionMainFrom::class);

            $this->productionMainFrom->production_id = $this->production->id;
        } else {
            $this->authorize('update', $this->productionMainFrom);
        }

        $this->productionMainFrom->save();

        $this->hideModal();
    }

    public function destroySelected()
    {
        $this->authorize('delete-any', ProductionMainFrom::class);

        ProductionMainFrom::whereIn('id', $this->selected)->delete();

        $this->selected = [];
        $this->allSelected = false;

        $this->resetProductionMainFromData();
    }

    public function toggleFullSelection()
    {
        if (!$this->allSelected) {
            $this->selected = [];
            return;
        }

        foreach (
            $this->production->productionMainFroms
            as $productionMainFrom
        ) {
            array_push($this->selected, $productionMainFrom->id);
        }
    }

    public function render()
    {
        return view('livewire.production-production-main-froms-detail', [
            'productionMainFroms' => $this->production
                ->productionMainFroms()
                ->paginate(20),
        ]);
    }
}
