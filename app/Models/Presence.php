<?php

namespace App\Models;

use App\Models\Scopes\Searchable;
use Illuminate\Database\Eloquent\Model;
use App\Http\Livewire\DataTables\HasValid;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Presence extends Model
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
        'store_id',
        'shift_store_id',
        'date',
        'amount',
        'payment_type_id',
        'status',
        'image_in',
        'image_out',
        'lat_long_in',
        'lat_long_out',
        'created_by_id',
        'approved_by_id',
    ];

    protected $searchableFields = ['*'];

    public function store()
    {
        return $this->belongsTo(Store::class);
    }

    public function shiftStore()
    {
        return $this->belongsTo(ShiftStore::class);
    }

    public function created_by()
    {
        return $this->belongsTo(User::class, 'created_by_id');
    }

    public function approved_by()
    {
        return $this->belongsTo(User::class, 'approved_by_id');
    }

    public function paymentType()
    {
        return $this->belongsTo(PaymentType::class);
    }

    public function paymentReceipts()
    {
        return $this->belongsToMany(PaymentReceipt::class);
    }

    public function salaries()
    {
        return $this->belongsToMany(
            Salary::class,
            'monthly_salary_presence',
            'presence_id',
            'monthly_salary_id'
        );
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

    public function getPresenceNameAttribute()
    {
        return $this->created_by->name . ' - ' . $this->closingStore->store->nickname . ' - ' . $this->closingStore->date->toFormattedDate();
    }
}
