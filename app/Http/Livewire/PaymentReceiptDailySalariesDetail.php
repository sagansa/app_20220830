<?php

namespace App\Http\Livewire;

use Livewire\Component;
use App\Models\DailySalary;
use App\Models\PaymentReceipt;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;

class PaymentReceiptDailySalariesDetail extends Component
{
    use AuthorizesRequests;

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
            ->latest()
            ->where('payment_type_id', '=', '1')
            ->where('status', '=', '3')
            ->get()
            ->pluck('date', 'id');
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
            ->attach($this->dailySalary_id, []);

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
        return view('livewire.payment-receipt-daily-salaries-detail', [
            'paymentReceiptDailySalaries' => $this->paymentReceipt
                ->dailySalaries()
                ->withPivot([])
                ->paginate(20),
        ]);
    }
}
