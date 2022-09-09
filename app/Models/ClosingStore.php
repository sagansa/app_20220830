<?php

namespace App\Models;

use App\Models\Scopes\Searchable;
use Illuminate\Database\Eloquent\Model;
use App\Http\Livewire\DataTables\HasValid;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class ClosingStore extends Model
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
        'store_id',
        'shift_store_id',
        'date',
        'cash_from_yesterday',
        'cash_for_tomorrow',
        'transfer_by_id',
        'total_cash_transfer',
        'status',
        'notes',
        'created_by_id',
        'approved_by_id',
    ];

    protected $searchableFields = ['*'];

    protected $table = 'closing_stores';

    protected $casts = [
        'date' => 'date',
    ];

    public function store()
    {
        return $this->belongsTo(Store::class);
    }

    public function shiftStore()
    {
        return $this->belongsTo(ShiftStore::class);
    }

    public function transfer_by()
    {
        return $this->belongsTo(User::class, 'transfer_by_id');
    }

    public function created_by()
    {
        return $this->belongsTo(User::class, 'created_by_id');
    }

    public function approved_by()
    {
        return $this->belongsTo(User::class, 'approved_by_id');
    }

    public function cashlesses()
    {
        return $this->hasMany(Cashless::class);
    }

    public function closingCouriers()
    {
        return $this->belongsToMany(ClosingCourier::class);
    }

    public function purchaseOrders()
    {
        return $this->belongsToMany(PurchaseOrder::class);
    }

    public function invoicePurchases()
    {
        return $this->belongsToMany(InvoicePurchase::class);
    }

    public function fuelServices()
    {
        return $this->belongsToMany(FuelService::class);
    }

    public function presences()
    {
        return $this->belongsToMany(Presence::class);
    }

    public function delete_image()
    {
        if ($this->image && file_exists('storage/' . $this->image)) {
            unlink('storage/' . $this->image);
        }
    }

    public function getClosingStoreNameAttribute()
    {
        return $this->store_id . ' - ' . $this->shiftStore->name . ' - ' . $this->date->toFormattedDate();
    }
}
