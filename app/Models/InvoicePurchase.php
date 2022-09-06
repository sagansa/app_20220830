<?php

namespace App\Models;

use App\Models\Scopes\Searchable;
use Illuminate\Database\Eloquent\Model;
use App\Http\Livewire\DataTables\HasValid;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class InvoicePurchase extends Model
{
    use HasValid;
    use HasFactory;
    use Searchable;

    const STATUS_BELUM_DIBAYAR = '1';
    const STATUS_SUDAH_DIBAYAR = '2';
    const STATUS_TIDAK_VALID = '3';

    const PAYMENT_STATUSES = [
        '1' => 'belum dibayar',
        '2' => 'sudah dibayar',
        '3' => 'tidak valid',
    ];

    const ORDER_STATUSES = [
        '1' => 'belum diterima',
        '2' => 'sudah diterima',
        '3' => 'dikembalikan',
    ];

    protected $fillable = [
        'image',
        'payment_type_id',
        'store_id',
        'supplier_id',
        'date',
        'taxes',
        'discounts',
        'notes',
        'payment_status',
        'order_status',
        'created_by_id',
        'approved_id',
    ];

    protected $searchableFields = ['*'];

    protected $table = 'invoice_purchases';

    protected $casts = [
        'date' => 'date',
    ];

    public function detailInvoices()
    {
        return $this->hasMany(DetailInvoice::class);
    }

    public function paymentType()
    {
        return $this->belongsTo(PaymentType::class);
    }

    public function store()
    {
        return $this->belongsTo(Store::class);
    }

    public function supplier()
    {
        return $this->belongsTo(Supplier::class);
    }

    public function created_by()
    {
        return $this->belongsTo(User::class, 'created_by_id');
    }

    public function approved_by()
    {
        return $this->belongsTo(User::class, 'approved_id');
    }

    public function paymentReceipts()
    {
        return $this->belongsToMany(PaymentReceipt::class);
    }

    public function closingStores()
    {
        return $this->belongsToMany(ClosingStore::class);
    }

    public function delete_image()
    {
        if ($this->image && file_exists('storage/' . $this->image)) {
            unlink('storage/' . $this->image);
        }
    }

    public function getInvoicePurchaseNameAttribute()
    {
        if($this->supplier->bank_account_name != null) {
            return $this->supplier->name . ' - ' . $this->supplier->bank->name . ' - ' . $this->date->toFormattedDate() . ' - ' . $this->detailInvoices->sum('subtotal_invoice');
        } else {
            return $this->supplier->name . ' - ' . $this->date->toFormattedDate() . ' - ' . $this->detailInvoices->sum('subtotal_invoice');
        }
    }
}
