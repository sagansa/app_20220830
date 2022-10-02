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
        '1' => 'belum dibayar',
        '2' => 'sudah dibayar',
        '3' => 'siap dibayar',
        '4' => 'tidak valid',
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
        'status',
        'notes',
        'created_by_id',
        'approved_by_id',
    ];

    protected $searchableFields = ['*'];

    protected $table = 'fuel_services';

    public function vehicle()
    {
        return $this->belongsTo(Vehicle::class);
    }

    public function closingStores()
    {
        return $this->belongsToMany(ClosingStore::class);
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
        return $this->vehicle->no_register . ' | ' . $this->amount . ' | ' . $this->created_at . ' | ' . $this->created_by->name;
    }
}
