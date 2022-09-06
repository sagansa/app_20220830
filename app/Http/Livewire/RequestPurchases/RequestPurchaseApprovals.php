<?php

namespace App\Http\Livewire\RequestPurchases;

use App\Http\Livewire\DataTables\WithBulkAction;
use App\Http\Livewire\DataTables\WithCachedRows;
use App\Http\Livewire\DataTables\WithFilter;
use App\Http\Livewire\DataTables\WithModal;
use App\Http\Livewire\DataTables\WithPerPagePagination;
use App\Http\Livewire\DataTables\WithSortingDate;
use App\Models\DetailRequest;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\Rule;
use Livewire\Component;

class RequestPurchaseApprovals extends Component
{
    use WithPerPagePagination, WithSortingDate, WithModal, WithBulkAction, WithCachedRows, WithFilter;

    public DetailRequest $editing;

    public $sortColumn = 'detail_requests.created_at';

    protected $queryString = [
        'sortColumn' => [
        'except' => 'detail_requests.created_at'
        ],
        'sortDirection' => [
            'except' => 'asc',
        ],
    ];

    public $filters = [
        'status' => '',
    ];

    public function changeStatus(DetailRequest $detailRequest, $status)
    {
        Validator::make(['status' => $status], [
            'status' => [
                'required',
                Rule::in(
                    DetailRequest::STATUS_APPROVED,
                    DetailRequest::STATUS_DONE,
                    DetailRequest::STATUS_NOT_VALID,
                    DetailRequest::STATUS_PROCESS,
                    DetailRequest::STATUS_REJECT,
                    )
            ],
        ])->validate();

        $detailRequest->update(['status' => $status]);

        $this->dispatchBrowserEvent('updated', ['message' => "Status changed to {$status} successfully."]);
    }

    public function getRowsQueryProperty()
    {
        $detailRequests = DetailRequest::query()->latest();

        if (Auth::user()->hasRole('super-admin|manager')) {
                foreach ($this->filters as $filter => $value) {
                    if (!empty($value)) {
                        $detailRequests
                            ->when($filter == 'status', fn($detailRequests) => $detailRequests->where('detail_requests.' . $filter, 'LIKE', '%' . $value . '%'));
                    }
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
        return view('livewire.request-purchases.request-purchase-approvals', [
            'detailRequests' => $this->rows,
        ]);
    }
}
