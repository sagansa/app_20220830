<?php

namespace App\Models;

use App\Models\Scopes\Searchable;
use Illuminate\Database\Eloquent\Model;
use App\Http\Livewire\DataTables\HasValid;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class DetailInvoice extends Model
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
        'invoice_purchase_id',
        'detail_request_id',
        'quantity_product',
        'quantity_invoice',
        'unit_invoice_id',
        'subtotal_invoice',
        'status',
    ];

    protected $searchableFields = ['*'];

    protected $table = 'detail_invoices';

    public function invoicePurchase()
    {
        return $this->belongsTo(InvoicePurchase::class);
    }

    public function unit_invoice()
    {
        return $this->belongsTo(Unit::class, 'unit_invoice_id');
    }

    public function productionMainFroms()
    {
        return $this->hasMany(ProductionMainFrom::class);
    }

    public function detailRequest()
    {
        return $this->belongsTo(DetailRequest::class);
    }

    public function delete_image()
    {
        if ($this->image && file_exists('storage/' . $this->image)) {
            unlink('storage/' . $this->image);
        }
    }

    public function getDetailInvoiceNameAttribute()
    {
        return $this->detailRequest->product->name . ' - ' . $this->quantity_product . $this->detailRequest->product->unit->unit . ' - ' . $this->invoicePurchase->date->toFormattedDate();
    }
}
