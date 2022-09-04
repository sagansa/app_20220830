<?php

namespace App\Http\Livewire;

use Livewire\Component;
use App\Models\Production;
use Livewire\WithPagination;
use App\Models\DetailInvoice;
use App\Models\ProductionMainForm;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;

class ProductionProductionMainFormsDetail extends Component
{
    use WithPagination;
    use AuthorizesRequests;

    public Production $production;
    public ProductionMainForm $productionMainForm;
    public $detailInvoicesForSelect = [];

    public $selected = [];
    public $editing = false;
    public $allSelected = false;
    public $showingModal = false;

    public $modalTitle = 'New ProductionMainForm';

    protected $rules = [
        'productionMainForm.detail_invoice_id' => [
            'required',
            'exists:detail_invoices,id',
        ],
    ];

    public function mount(Production $production)
    {
        $this->production = $production;
        $this->detailInvoicesForSelect = DetailInvoice::pluck('id', 'id');
        $this->resetProductionMainFormData();
    }

    public function resetProductionMainFormData()
    {
        $this->productionMainForm = new ProductionMainForm();

        $this->productionMainForm->detail_invoice_id = null;

        $this->dispatchBrowserEvent('refresh');
    }

    public function newProductionMainForm()
    {
        $this->editing = false;
        $this->modalTitle = trans(
            'crud.production_production_main_forms.new_title'
        );
        $this->resetProductionMainFormData();

        $this->showModal();
    }

    public function editProductionMainForm(
        ProductionMainForm $productionMainForm
    ) {
        $this->editing = true;
        $this->modalTitle = trans(
            'crud.production_production_main_forms.edit_title'
        );
        $this->productionMainForm = $productionMainForm;

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

        if (!$this->productionMainForm->production_id) {
            $this->authorize('create', ProductionMainForm::class);

            $this->productionMainForm->production_id = $this->production->id;
        } else {
            $this->authorize('update', $this->productionMainForm);
        }

        $this->productionMainForm->save();

        $this->hideModal();
    }

    public function destroySelected()
    {
        $this->authorize('delete-any', ProductionMainForm::class);

        ProductionMainForm::whereIn('id', $this->selected)->delete();

        $this->selected = [];
        $this->allSelected = false;

        $this->resetProductionMainFormData();
    }

    public function toggleFullSelection()
    {
        if (!$this->allSelected) {
            $this->selected = [];
            return;
        }

        foreach (
            $this->production->productionMainForms
            as $productionMainForm
        ) {
            array_push($this->selected, $productionMainForm->id);
        }
    }

    public function render()
    {
        return view('livewire.production-production-main-forms-detail', [
            'productionMainForms' => $this->production
                ->productionMainForms()
                ->paginate(20),
        ]);
    }
}
