<?php

namespace App\Models;

use App\Models\Scopes\Searchable;
use Illuminate\Database\Eloquent\Model;
use App\Http\Livewire\DataTables\HasValid;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class SoDdetail extends Model
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
        'e_product_id',
        'quantity',
        'price',
        'sales_order_direct_id',
    ];

    protected $searchableFields = ['*'];

    protected $table = 'so_ddetails';

    public function eProduct()
    {
        return $this->belongsTo(EProduct::class);
    }

    public function salesOrderDirect()
    {
        return $this->belongsTo(SalesOrderDirect::class);
    }

    public function delete_image()
    {
        if ($this->image && file_exists('storage/' . $this->image)) {
            unlink('storage/' . $this->image);
        }
    }
}
