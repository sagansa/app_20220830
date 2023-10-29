<?php

namespace App\Models;

use App\Models\Scopes\Searchable;
use Illuminate\Database\Eloquent\Model;
use App\Http\Livewire\DataTables\HasValid;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class DetailRequest extends Model
{
    use HasValid;
    use HasFactory;
    use Searchable;

    const STATUS_PROCESS = '1';
    const STATUS_DONE = '2';
    const STATUS_REJECT = '3';
    const STATUS_APPROVED = '4';
    const STATUS_NOT_VALID = '5';
    const STATUS_NOT_USED = '6';

    const STATUSES = [
        '1' => 'process',
        '2' => 'done',
        '3' => 'reject',
        '4' => 'approved',
        '5' => 'not valid',
        '6' => 'not used',
    ];

    protected $fillable = [
        'product_id',
        'store_id',
        'quantity_plan',
        'status',
        'notes',
        'request_purchase_id',
        'payment_type_id',
    ];

    protected $searchableFields = ['*'];

    protected $table = 'detail_requests';

    public function product()
    {
        return $this->belongsTo(Product::class);
    }

    public function store()
    {
        return $this->belongsTo(Store::class);
    }

    public function paymentType()
    {
        return $this->belongsTo(PaymentType::class);
    }

    public function requestPurchase()
    {
        return $this->belongsTo(RequestPurchase::class);
    }

    public function detailInvoice()
    {
        return $this->hasOne(DetailInvoice::class);
    }

    public function delete_image()
    {
        if ($this->image && file_exists('storage/' . $this->image)) {
            unlink('storage/' . $this->image);
        }
    }

    public function getDetailRequestNameAttribute()
    {
        return $this->product->name . ' | ' . $this->product->unit->unit . ' | ' . $this->requestPurchase->date->toFormattedDate();
    }
}
