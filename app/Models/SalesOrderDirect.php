<?php

namespace App\Models;

use App\Models\Scopes\Searchable;
use Illuminate\Database\Eloquent\Model;
use App\Http\Livewire\DataTables\HasValid;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class SalesOrderDirect extends Model
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
        'delivery_date',
        'delivery_service_id',
        'transfer_to_account_id',
        'image_transfer',
        'payment_status',
        'delivery_status',
        'shipping_cost',
        'store_id',
        'image_receipt',
        'submitted_by_id',
        'received_by',
        'sign',
        'order_by_id',
    ];

    protected $searchableFields = ['*'];

    protected $table = 'sales_order_directs';

    protected $casts = [
        'delivery_date' => 'date',
    ];

    public function store()
    {
        return $this->belongsTo(Store::class);
    }

    public function deliveryService()
    {
        return $this->belongsTo(DeliveryService::class);
    }

    public function transferToAccount()
    {
        return $this->belongsTo(TransferToAccount::class);
    }

    public function soDdetails()
    {
        return $this->hasMany(SoDdetail::class);
    }

    public function submitted_by()
    {
        return $this->belongsTo(User::class, 'submitted_by_id');
    }

    public function order_by()
    {
        return $this->belongsTo(User::class, 'order_by_id');
    }

    public function delete_image()
    {
        if ($this->image && file_exists('storage/' . $this->image)) {
            unlink('storage/' . $this->image);
        }
    }
}
