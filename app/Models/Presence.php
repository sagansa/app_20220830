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
        '1' => 'belum diperiksa',
        '2' => 'valid',
        '3' => 'diperbaiki',
        '4' => 'periksa ulang',
    ];

    protected $fillable = [
        'store_id',
        'shift_store_id',
        'status',
        'image_in',
        'image_out',
        'date',
        'time_in',
        'time_out',
        'created_by_id',
        'approved_by_id',
        'latitude_in',
        'longitude_in',
        'latitude_out',
        'longitude_out',
    ];

    protected $searchableFields = ['*'];

    protected $casts = [
        // 'date' => 'date',
        // 'time_in' => 'datetime',
        // 'time_out' => 'datetime',
    ];

    public function created_by()
    {
        return $this->belongsTo(User::class, 'created_by_id');
    }

    public function approved_by()
    {
        return $this->belongsTo(User::class, 'approved_by_id');
    }

    public function store()
    {
        return $this->belongsTo(Store::class);
    }

    public function shiftStore()
    {
        return $this->belongsTo(ShiftStore::class);
    }

    public function dailySalary()
    {
        return $this->hasOne(DailySalary::class);
    }

    public function monthlySalaries()
    {
        return $this->belongsToMany(MonthlySalary::class);
    }

    public function delete_image()
    {
        if ($this->image && file_exists('storage/' . $this->image)) {
            unlink('storage/' . $this->image);
        }
    }
}
