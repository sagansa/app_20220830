<?php

namespace App\Http\Livewire;

use Livewire\Component;
use App\Models\DailySalary;
use App\Models\PaymentReceipt;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\Rule;

class PaymentReceiptDailySalariesDetail extends Component
{
    use AuthorizesRequests;

    public $state = [];

    public PaymentReceipt $paymentReceipt;
    public DailySalary $dailySalary;
    public $dailySalariesForSelect = [];
    public $daily_salary_id = null;

    public $showingModal = false;
    public $modalTitle = 'New DailySalary';

    protected $rules = [
        'daily_salary_id' => ['required', 'exists:daily_salaries,id'],
    ];

    public function mount(PaymentReceipt $paymentReceipt)
    {
        $this->paymentReceipt = $paymentReceipt;
        $this->dailySalariesForSelect = DailySalary::
            orderBy('created_by_id', 'asc')
            ->orderBy('date', 'desc')
            ->where('payment_type_id', '=', '1')
            ->where('status', '=', '3')
            ->get()
            ->pluck('id', 'daily_salary_name');
        $this->resetDailySalaryData();
    }

    public function resetDailySalaryData()
    {
        $this->dailySalary = new DailySalary();

        $this->daily_salary_id = null;

        $this->dispatchBrowserEvent('refresh');
    }

    public function newDailySalary()
    {
        $this->modalTitle = trans(
            'crud.payment_receipt_daily_salaries.new_title'
        );
        $this->resetDailySalaryData();

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

        $this->authorize('create', DailySalary::class);

        $this->paymentReceipt
            ->dailySalaries()
            ->attach($this->daily_salary_id, []);

        $this->hideModal();
    }

    public function detach($dailySalary)
    {
        $this->authorize('delete-any', DailySalary::class);

        $this->paymentReceipt->dailySalaries()->detach($dailySalary);

        $this->resetDailySalaryData();
    }

    public function render()
    {
        $this->totals = 0;

        foreach($this->paymentReceipt->dailySalaries as $dailySalary) {
            $this->totals += $dailySalary->sum('amount');
        }

        $this->difference = $this->paymentReceipt->amount - $this->totals;

        return view('livewire.payment-receipt-daily-salaries-detail', [
            'paymentReceiptDailySalaries' => $this->paymentReceipt
                ->dailySalaries()
                ->withPivot([])
                ->paginate(30),
        ]);
    }

    public function changeStatus(DailySalary $dailySalary, $status)
    {
        Validator::make(['status' => $status], [
			'status' => [
				'required',
				Rule::in(DailySalary::STATUS_SIAP_DIBAYAR, DailySalary::STATUS_SUDAH_DIBAYAR),
			],
		])->validate();

		$dailySalary->update(['status' => $status]);

		$this->dispatchBrowserEvent('updated', ['message' => "Status changed to {$status} successfully."]);
    }

    public function updatePaymentReceipt()
    {
        Validator::make(
            $this->state,
            [
                'amount' => 'required', 'numeric', 'min:0'
            ]
        )->validate();

        $this->paymentReceipt->update($this->state);
    }
}
