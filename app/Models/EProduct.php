<?php

namespace App\Models;

use App\Http\Livewire\DataTables\HasActive;
use App\Models\Scopes\Searchable;
use Illuminate\Database\Eloquent\Model;
use App\Http\Livewire\DataTables\HasValid;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class EProduct extends Model
{
    use HasActive;
    use HasFactory;
    use Searchable;

    const STATUSES = [
        '1' => 'active',
        '2' => 'inactive',
    ];

    protected $fillable = [
        'online_category_id',
        'store_id',
        'product_id',
        'image',
        'quantity_stock',
        'price',
        'status',
    ];

    protected $searchableFields = ['*'];

    protected $table = 'e_products';

    public function product()
    {
        return $this->belongsTo(Product::class);
    }

    public function store()
    {
        return $this->belongsTo(Store::class);
    }

    public function onlineCategory()
    {
        return $this->belongsTo(OnlineCategory::class);
    }

    public function carts()
    {
        return $this->hasMany(Cart::class);
    }

    public function delete_image()
    {
        if ($this->image && file_exists('storage/' . $this->image)) {
            unlink('storage/' . $this->image);
        }
    }
}
