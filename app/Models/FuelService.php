<?php

namespace App\Models;

use App\Models\Scopes\Searchable;
use Illuminate\Database\Eloquent\Model;
use App\Http\Livewire\DataTables\HasValid;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class FuelService extends Model
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

    const STATUS_BELUM_DIBAYAR = '1';
    const STATUS_SUDAH_DIBAYAR = '2';
    const STATUS_SIAP_DIBAYAR = '3';
    const STATUS_TIDAK_VALID = '4';

    protected $fillable = [
        'image',
        'vehicle_id',
        'payment_type_id',
        'fuel_service',
        'km',
        'liter',
        'amount',
        'closing_store_id',
        'created_by_id',
        'approved_by_id',
        'notes',
        'status',
    ];

    protected $searchableFields = ['*'];

    protected $table = 'fuel_services';

    public function closingStore()
    {
        return $this->belongsTo(ClosingStore::class);
    }

    public function vehicle()
    {
        return $this->belongsTo(Vehicle::class);
    }

    public function paymentType()
    {
        return $this->belongsTo(PaymentType::class);
    }

    public function created_by()
    {
        return $this->belongsTo(User::class, 'created_by_id');
    }

    public function approved_by()
    {
        return $this->belongsTo(User::class, 'approved_by_id');
    }

    public function paymentReceipts()
    {
        return $this->belongsToMany(PaymentReceipt::class);
    }

    public function delete_image()
    {
        if ($this->image && file_exists('storage/' . $this->image)) {
            unlink('storage/' . $this->image);
        }
    }

    public function getFuelServiceNameAttribute()
    {
        return $this->vehicle->no_register . '-' . $this->amount;
    }
}
