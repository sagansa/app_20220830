<?php

namespace App\Models;

use App\Models\Scopes\Searchable;
use Illuminate\Database\Eloquent\Model;
use App\Http\Livewire\DataTables\HasValid;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class TransferToAccount extends Model
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

    protected $fillable = ['name', 'number', 'bank_id', 'status'];

    protected $searchableFields = ['*'];

    protected $table = 'transfer_to_accounts';

    public function bank()
    {
        return $this->belongsTo(Bank::class);
    }

    public function salesOrderDirects()
    {
        return $this->hasMany(SalesOrderDirect::class);
    }

    public function delete_image()
    {
        if ($this->image && file_exists('storage/' . $this->image)) {
            unlink('storage/' . $this->image);
        }
    }

    public function getTransferNameAttribute()
    {
        return $this->bank->name . ' | ' . $this->number . ' | ' . $this->name;
    }
}
