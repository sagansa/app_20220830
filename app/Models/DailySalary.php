<?php

namespace App\Models;

use App\Http\Livewire\DataTables\HasPayment;
use App\Models\Scopes\Searchable;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class DailySalary extends Model
{
    use HasPayment;
    use HasFactory;
    use Searchable;

    const STATUSES = [
        '1' => 'belum diperiksa',
        '2' => 'sudah dibayar',
        '3' => 'siap dibayar',
        '4' => 'perbaiki',
    ];

    const STATUS_BELUM_DIPERIKSA = '1';
    const STATUS_SUDAH_DIBAYAR = '2';
    const STATUS_SIAP_DIBAYAR = '3';
    const STATUS_TIDAK_VALID = '4';

    protected $fillable = [
        'store_id',
        'shift_store_id',
        'date',
        'amount',
        'payment_type_id',
        'status',
        'presence_id',
        'created_by_id',
        'approved_by_id',
    ];

    protected $searchableFields = ['*'];

    protected $table = 'daily_salaries';

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

    public function paymentType()
    {
        return $this->belongsTo(PaymentType::class);
    }

    public function presence()
    {
        return $this->belongsTo(Presence::class);
    }

    public function created_by()
    {
        return $this->belongsTo(User::class, 'created_by_id');
    }

    public function approved_by()
    {
        return $this->belongsTo(User::class, 'approved_by_id');
    }

    public function closingStores()
    {
        return $this->belongsToMany(ClosingStore::class);
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

    public function getDailySalaryNameAttribute()
    {
        return $this->created_by->name . ' | ' . $this->date->toFormattedDate() . ' | ' . $this->store->nickname;
    }
}
