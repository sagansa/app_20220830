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

    const STATUSES = [
        '1' => 'belum diperiksa',
        '2' => 'valid',
        '3' => 'diperbaiki',
        '4' => 'periksa ulang',
    ];

    protected $fillable = [
        'product_id',
        'store_id',
        'quantity_plan',
        'status',
        'notes',
        'request_purchase_id',
    ];

    protected $searchableFields = ['*'];

    protected $table = 'detail_requests';

    public function product()
    {
        return $this->belongsTo(Product::class);
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
        return $this->product->name . ' - ' . $this->product->unit->unit . ' - ' . $this->requestPurchase->date->toFormattedDate() . ' - ' . $this->requestPurchase->store->nickname;
    }
}
