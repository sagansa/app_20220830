<?php

namespace App\Models;

use App\Http\Livewire\DataTables\HasSalesDirect;
use App\Models\Scopes\Searchable;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class SalesOrderDirect extends Model
{
    use HasSalesDirect;
    use HasFactory;
    use Searchable;

    const PAYMENT_STATUSES = [
        '1' => 'proses validasi',
        '2' => 'valid',
        '3' => 'tidak valid',
    ];

    const DELIVERY_STATUSES = [
        '1' => 'belum diproses',
        '2' => 'pesanan diproses',
        '3' => 'siap dikirim',
        '4' => 'telah dikirim',
        '5' => 'selesai',
        '6' => 'dikembalikan',
        '7' => 'batal',
    ];

    protected $fillable = [
        'delivery_date',
        'delivery_location_id',
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
        'discounts',
        'notes',
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

    public function submitted_by()
    {
        return $this->belongsTo(User::class, 'submitted_by_id');
    }

    public function order_by()
    {
        return $this->belongsTo(User::class, 'order_by_id');
    }

    public function deliveryLocation()
    {
        return $this->belongsTo(DeliveryLocation::class);
    }

    public function salesOrderDirectProducts()
    {
        return $this->hasMany(SalesOrderDirectProduct::class);
    }

    public function delete_image()
    {
        if ($this->image && file_exists('storage/' . $this->image)) {
            unlink('storage/' . $this->image);
        }
    }
}
