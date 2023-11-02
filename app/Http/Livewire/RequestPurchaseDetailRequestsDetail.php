<?php

namespace App\Http\Livewire;

use Livewire\Component;
use App\Models\Product;
use Livewire\WithPagination;
use App\Models\DetailRequest;
use App\Models\RequestPurchase;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\View\View;

class RequestPurchaseDetailRequestsDetail extends Component
{
    use WithPagination;
    use AuthorizesRequests;

    public RequestPurchase $requestPurchase;
    public DetailRequest $detailRequest;
    // public $productsForSelect = [];

    public $products;

    public $selected = [];
    public $editing = false;
    public $allSelected = false;
    public $showingModal = false;

    public $modalTitle = 'New DetailRequest';

    protected $rules = [
        'detailRequest.product_id' => ['required', 'exists:products,id'],
        'detailRequest.quantity_plan' => ['required', 'numeric', 'min:0'],
        'detailRequest.status' => ['nullable', 'in:1,2,3,4,5,6'],
        'detailRequest.notes' => ['nullable', 'max:255', 'string'],
    ];

    public function mount(RequestPurchase $requestPurchase): void
    {
        $this->requestPurchase = $requestPurchase;
        // $this->productsForSelect = Product::orderBy('name', 'asc')
        //     ->get()->pluck('id', 'product_name');

        $this->products = Product::orderBy('name', 'asc')
            ->whereNotIn('payment_type_id', ['3'])
            ->get()->map(function ($product) {
            return [
                'label' => $product->product_name,
                'value' => $product->id,
            ];
        });

        $this->resetDetailRequestData();
    }

    public function resetDetailRequestData(): void
    {
        $this->detailRequest = new DetailRequest();

        $this->detailRequest->product_id = null;
        $this->detailRequest->status = null;

        if ($this->detailRequest->payment_type_id = '1') {
            $this->detailRequest->status = '4';
        } else if ($this->detailRequest->payment_type_id = '2') {
            $this->detailRequest->status = '1';
        }

        $this->dispatchBrowserEvent('refresh');
    }

    public function newDetailRequest(): void
    {
        $this->editing = false;
        $this->modalTitle = trans(
            'crud.request_purchase_detail_requests.new_title'
        );
        $this->resetDetailRequestData();

        $this->showModal();
    }

    public function editDetailRequest(DetailRequest $detailRequest): void
    {
        $this->editing = true;
        $this->modalTitle = trans(
            'crud.request_purchase_detail_requests.edit_title'
        );
        $this->detailRequest = $detailRequest;

        $this->dispatchBrowserEvent('refresh');

        $this->showModal();
    }

    public function showModal(): void
    {
        $this->resetErrorBag();
        $this->showingModal = true;
    }

    public function hideModal(): void
    {
        $this->showingModal = false;
    }

    public function save(): void
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

        $this->detailRequest->payment_type_id = $this->detailRequest->product->payment_type_id;

        // $this->detailRequest->status = '1';


        $this->detailRequest->save();

        $this->hideModal();
    }

    public function destroySelected(): void
    {
        $this->authorize('delete-any', DetailRequest::class);

        DetailRequest::whereIn('id', $this->selected)->delete();

        $this->selected = [];
        $this->allSelected = false;

        $this->resetDetailRequestData();
    }

    public function toggleFullSelection(): void
    {
        if (!$this->allSelected) {
            $this->selected = [];
            return;
        }

        foreach ($this->requestPurchase->detailRequests as $detailRequest) {
            array_push($this->selected, $detailRequest->id);
        }
    }

    public function render(): View
    {
        return view('livewire.request-purchase-detail-requests-detail', [
            'detailRequests' => $this->requestPurchase
                ->detailRequests()
                ->paginate(20),
        ]);
    }
}
