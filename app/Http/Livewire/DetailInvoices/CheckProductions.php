<?php

namespace App\Http\Livewire\DetailInvoices;

use App\Http\Livewire\DataTables\WithBulkAction;
use App\Http\Livewire\DataTables\WithCachedRows;
use App\Http\Livewire\DataTables\WithFilter;
use App\Http\Livewire\DataTables\WithModal;
use App\Http\Livewire\DataTables\WithSimpleTablePagination;
use App\Http\Livewire\DataTables\WithSortingDate;
use App\Models\DetailInvoice;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\Rule;
use Livewire\Component;
use Illuminate\Support\Collection;

class CheckProductions extends Component
{
    use WithSimpleTablePagination, WithSortingDate, WithModal, WithBulkAction, WithCachedRows, WithFilter;

    public DetailInvoice $editing;

    public $sortColumn = 'detail_invoices.created_at';

    protected $queryString = [
        'sortColumn' => [
        'except' => 'detail_invoices.created_at'
        ],
        'sortDirection' => [
            'except' => 'asc',
        ],
    ];

    public $filters = [
        'status' => '',
    ];

    public function changeStatus(DetailInvoice $detailInvoice, $status)
    {
        Validator::make(['status' => $status], [
			'status' => [
				'required',
				Rule::in(DetailInvoice::STATUS_PROCESS, DetailInvoice::STATUS_DONE, DetailInvoice::STATUS_NO_NEED),
			],
		])->validate();

		$detailInvoice->update(['status' => $status]);

		$this->dispatchBrowserEvent('updated', ['message' => "Status changed to {$status} successfully."]);
    }

    public function getRowsQueryProperty()
    {
        $detailInvoices = DetailInvoice::query();

        if (Auth::user()->hasRole('super-admin|manager')) {
            foreach ($this->filters as $filter => $value) {
                if (!empty($value)) {
                    $detailInvoices
                        ->when($filter == 'status', fn($detailInvoices) => $detailInvoices->where('detail_invoices.' . $filter, 'LIKE', '%' . $value . '%'));
                }
            }
        }

        return $this->applySorting($detailInvoices);
    }

    public function getRowsProperty()
    {
        return $this->cache(function () {
            return $this->applyPagination($this->rowsQuery);
        });
    }

    public function render()
    {
        return view('livewire.detail-invoices.check-productions', [
            'detailInvoices' => $this->rows,
        ]);
    }
}
