<?php

namespace App\Http\Livewire\DetailRequests;

use App\Http\Livewire\DataTables\WithBulkAction;
use App\Http\Livewire\DataTables\WithCachedRows;
use App\Http\Livewire\DataTables\WithFilter;
use App\Http\Livewire\DataTables\WithModal;
use App\Http\Livewire\DataTables\WithSimpleTablePagination;
use App\Http\Livewire\DataTables\WithSortingDate;
use App\Models\DetailRequest;
use App\Models\Product;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\Rule;
use Livewire\Component;

class RequestPurchaseApprovals extends Component
{
    use WithSimpleTablePagination, WithSortingDate, WithModal, WithBulkAction, WithCachedRows, WithFilter;

    public DetailRequest $editing;

    public $sortColumn = 'detail_requests.created_at';

    protected $queryString = [
        'sortColumn' => [
        'except' => 'detail_requests.date'
        ],
        'sortDirection' => [
            'except' => 'asc',
        ],
    ];

    public $filters = [
        'product_id' => null,
        'status' => '',
    ];

    public function mount()
    {
        $this->products = Product::orderBy('name', 'asc')->pluck('id', 'name');
    }

    public function changeStatus(DetailRequest $detailRequest, $status)
    {
        Validator::make(['status' => $status], [
			'status' => [
				'required',
				Rule::in(
                    DetailRequest::STATUS_PROCESS,
                    DetailRequest::STATUS_APPROVED,
                    DetailRequest::STATUS_DONE,
                    DetailRequest::STATUS_REJECT,
                    DetailRequest::STATUS_NOT_VALID,
                    DetailRequest::STATUS_NOT_USED,
                ),
			],
		])->validate();

		$detailRequest->update(['status' => $status]);

		$this->dispatchBrowserEvent('updated', ['message' => "Status changed to {$status} successfully."]);
    }

    public function getRowsQueryProperty()
    {
        $detailRequests = DetailRequest::query();

        foreach ($this->filters as $filter => $value) {
            if (!empty($value)) {
                $detailRequests
                    ->when($filter == 'product_id', fn($detailRequests) => $detailRequests->whereRelation('product', 'id', $value))
                    ->when($filter == 'status', fn($detailRequests) => $detailRequests->where('detail_requests.' . $filter, 'LIKE', '%' . $value . '%'));
            }
        }

        return $this->applySorting($detailRequests);
    }

    public function getRowsProperty()
    {
        return $this->cache(function () {
            return $this->applyPagination($this->rowsQuery);
        });
    }

    public function render()
    {
        return view('livewire.detail-requests.request-purchase-approvals', [
              'detailRequests' => $this->rows,
        ]);
    }

    public function markAllAsDone()
    {
        DetailRequest::whereIn('id', $this->selectedRows)->update([
            'status' => '2',
        ]);
    }

    public function markAllAsApproved()
    {
        DetailRequest::whereIn('id', $this->selectedRows)->update([
            'status' => '4',
        ]);
    }

    public function markAllAsReject()
    {
        DetailRequest::whereIn('id', $this->selectedRows)->update([
            'status' => '3',
        ]);
    }

    public function markAllAsNotValid()
    {
        DetailRequest::whereIn('id', $this->selectedRows)->update([
            'status' => '5',
        ]);
    }

    public function markAllAsNotUsed()
    {
        DetailRequest::whereIn('id', $this->selectedRows)->update([
            'status' => '6',
        ]);
    }
}
