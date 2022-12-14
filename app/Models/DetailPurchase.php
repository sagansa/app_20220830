<?php

namespace App\Models;

use App\Models\Scopes\Searchable;
use Illuminate\Database\Eloquent\Model;
use App\Http\Livewire\DataTables\HasValid;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class DetailPurchase extends Model
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
        'product_id',
        'quantity_plan',
        'status',
        'notes',
        'purchase_submission_id',
    ];

    protected $searchableFields = ['*'];

    protected $table = 'detail_purchases';

    public function product()
    {
        return $this->belongsTo(Product::class);
    }

    public function purchaseSubmission()
    {
        return $this->belongsTo(PurchaseSubmission::class);
    }

    public function delete_image()
    {
        if ($this->image && file_exists('storage/' . $this->image)) {
            unlink('storage/' . $this->image);
        }
    }
}
