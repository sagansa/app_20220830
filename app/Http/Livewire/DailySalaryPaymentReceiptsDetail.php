<?php

namespace App\Http\Livewire;

use Livewire\Component;
use App\Models\DailySalary;
use App\Models\PaymentReceipt;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Support\Carbon;

class DailySalaryPaymentReceiptsDetail extends Component
{
    use AuthorizesRequests;

    public DailySalary $dailySalary;
    public PaymentReceipt $paymentReceipt;
    public $paymentReceiptsForSelect = [];
    public $payment_receipt_id = null;

    public $showingModal = false;
    public $modalTitle = 'New PaymentReceipt';

    protected $rules = [
        'payment_receipt_id' => ['required', 'exists:payment_receipts,id'],
    ];

    public function mount(DailySalary $dailySalary)
    {
        $this->dailySalary = $dailySalary;
        $this->paymentReceiptsForSelect = PaymentReceipt::where('created_at', '>=', Carbon::now()->subDays(5)->toDateString())
            ->where('created_at','desc')
            ->get()
            ->pluck('id', 'payment_receipt_name');
        $this->resetPaymentReceiptData();
    }

    public function resetPaymentReceiptData()
    {
        $this->paymentReceipt = new PaymentReceipt();

        $this->payment_receipt_id = null;

        $this->dispatchBrowserEvent('refresh');
    }

    public function newPaymentReceipt()
    {
        $this->modalTitle = trans(
            'crud.daily_salary_payment_receipts.new_title'
        );
        $this->resetPaymentReceiptData();

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

        $this->authorize('create', PaymentReceipt::class);

        $this->dailySalary
            ->paymentReceipts()
            ->attach($this->paymentReceipt_id, []);

        $this->hideModal();
    }

    public function detach($paymentReceipt)
    {
        $this->authorize('delete-any', PaymentReceipt::class);

        $this->dailySalary->paymentReceipts()->detach($paymentReceipt);

        $this->resetPaymentReceiptData();
    }

    public function render()
    {
        return view('livewire.daily-salary-payment-receipts-detail', [
            'dailySalaryPaymentReceipts' => $this->dailySalary
                ->paymentReceipts()
                ->withPivot([])
                ->paginate(20),
        ]);
    }
}
