<?php

namespace App\Http\Livewire;

use Livewire\Component;
use App\Models\Product;
use Livewire\WithPagination;
use App\Models\DetailRequest;
use App\Models\RequestPurchase;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;

class RequestPurchaseDetailRequestsDetail extends Component
{
    use WithPagination;
    use AuthorizesRequests;

    public RequestPurchase $requestPurchase;
    public DetailRequest $detailRequest;
    public $productsForSelect = [];

    public $selected = [];
    public $editing = false;
    public $allSelected = false;
    public $showingModal = false;

    public $modalTitle = 'New DetailRequest';

    protected $rules = [
        'detailRequest.product_id' => ['required', 'exists:products,id'],
        'detailRequest.quantity_plan' => ['required', 'numeric', 'min:0'],
        'detailRequest.status' => ['required', 'in:1,2,3,4,5'],
        'detailRequest.notes' => ['nullable', 'max:255', 'string'],
    ];

    public function mount(RequestPurchase $requestPurchase)
    {
        $this->requestPurchase = $requestPurchase;
        $this->productsForSelect = Product::orderBy('name', 'asc')
            ->get()->pluck('id', 'product_name');
        $this->resetDetailRequestData();
    }

    public function resetDetailRequestData()
    {
        $this->detailRequest = new DetailRequest();

        $this->detailRequest->product_id = null;
        $this->detailRequest->status = '1';

        $this->dispatchBrowserEvent('refresh');
    }

    public function newDetailRequest()
    {
        $this->editing = false;
        $this->modalTitle = trans(
            'crud.request_purchase_detail_requests.new_title'
        );
        $this->resetDetailRequestData();

        $this->showModal();
    }

    public function editDetailRequest(DetailRequest $detailRequest)
    {
        $this->editing = true;
        $this->modalTitle = trans(
            'crud.request_purchase_detail_requests.edit_title'
        );
        $this->detailRequest = $detailRequest;

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

        if (!$this->detailRequest->request_purchase_id) {
            $this->authorize('create', DetailRequest::class);

            $this->detailRequest->request_purchase_id =
                $this->requestPurchase->id;
        } else {
            $this->authorize('update', $this->detailRequest);
        }

        $this->detailRequest->store_id = $this->requestPurchase->store_id;
        $this->detailRequest->payment_type_id = '1';

        $this->detailRequest->save();

        $this->hideModal();
    }

    public function destroySelected()
    {
        $this->authorize('delete-any', DetailRequest::class);

        DetailRequest::whereIn('id', $this->selected)->delete();

        $this->selected = [];
        $this->allSelected = false;

        $this->resetDetailRequestData();
    }

    public function toggleFullSelection()
    {
        if (!$this->allSelected) {
            $this->selected = [];
            return;
        }

        foreach ($this->requestPurchase->detailRequests as $detailRequest) {
            array_push($this->selected, $detailRequest->id);
        }
    }

    public function render()
    {
        return view('livewire.request-purchase-detail-requests-detail', [
            'detailRequests' => $this->requestPurchase
                ->detailRequests()
                ->paginate(20),
        ]);
    }
}
