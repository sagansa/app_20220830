<?php

namespace App\Models;

use App\Models\Scopes\Searchable;
use Illuminate\Database\Eloquent\Model;
use App\Http\Livewire\DataTables\HasValid;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class PaymentReceipt extends Model
{
    use HasValid;
    use HasFactory;
    use Searchable;

    const STATUSES = [
        '1' => 'belum diperiksa',
        '2' => 'valid',
        '3' => 'diperbaiki',
        '4' => 'periksa ulang',
    ];

    protected $fillable = [
        'image',
        'amount',
        'payment_for',
        'image_adjust',
        'notes',
    ];

    protected $searchableFields = ['*'];

    protected $table = 'payment_receipts';

    public function fuelServices()
    {
        return $this->belongsToMany(FuelService::class);
    }

    public function invoicePurchases()
    {
        return $this->belongsToMany(InvoicePurchase::class);
    }

    public function dailySalaries()
    {
        return $this->belongsToMany(DailySalary::class);
    }

    public function delete_image()
    {
        if ($this->image && file_exists('storage/' . $this->image)) {
            unlink('storage/' . $this->image);
        }
    }

    public function delete_image_adjust()
    {
        if ($this->image_adjust && file_exists('storage/' . $this->image_adjust)) {
            unlink('storage/' . $this->image_adjust);
        }
    }

    public function getPaymentReceiptNameAttribute()
    {
        return $this->amount . ' | ' . $this->created_at->toFormattedDate();
    }
}
