<?php

namespace App\Models;

use App\Models\Scopes\Searchable;
use Illuminate\Database\Eloquent\Model;
use App\Http\Livewire\DataTables\HasValid;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Store extends Model
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
        'name',
        'nickname',
        'no_telp',
        'email',
        'user_id',
        'status',
    ];

    protected $searchableFields = ['*'];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function vehicles()
    {
        return $this->hasMany(Vehicle::class);
    }

    public function movementAssetResults()
    {
        return $this->hasMany(MovementAssetResult::class);
    }

    public function closingStores()
    {
        return $this->hasMany(ClosingStore::class);
    }

    public function purchaseOrders()
    {
        return $this->hasMany(PurchaseOrder::class);
    }

    public function remainingStocks()
    {
        return $this->hasMany(RemainingStock::class);
    }

    public function productions()
    {
        return $this->hasMany(Production::class);
    }

    public function salesOrderEmployees()
    {
        return $this->hasMany(SalesOrderEmployee::class);
    }

    public function salesOrderOnlines()
    {
        return $this->hasMany(SalesOrderOnline::class);
    }

    public function fromTransferStocks()
    {
        return $this->hasMany(TransferStock::class, 'from_store_id');
    }

    public function toTransferStocks()
    {
        return $this->hasMany(TransferStock::class, 'to_store_id');
    }

    public function hygienes()
    {
        return $this->hasMany(Hygiene::class);
    }

    public function selfConsumptions()
    {
        return $this->hasMany(SelfConsumption::class);
    }

    public function utilities()
    {
        return $this->hasMany(Utility::class);
    }

    public function storeAssets()
    {
        return $this->hasMany(StoreAsset::class);
    }

    public function accountCashlesses()
    {
        return $this->hasMany(AccountCashless::class);
    }

    public function eProducts()
    {
        return $this->hasMany(EProduct::class);
    }

    public function requestPurchases()
    {
        return $this->hasMany(RequestPurchase::class);
    }

    public function invoicePurchases()
    {
        return $this->hasMany(InvoicePurchase::class);
    }

    public function detailRequests()
    {
        return $this->hasMany(DetailRequest::class);
    }

    public function presences()
    {
        return $this->hasMany(Presence::class);
    }

    public function dailySalaries()
    {
        return $this->hasMany(DailySalary::class);
    }

    public function salesOrderDirects()
    {
        return $this->hasMany(SalesOrderDirect::class);
    }

    public function locations()
    {
        return $this->hasMany(Location::class);
    }

    public function delete_image()
    {
        if ($this->image && file_exists('storage/' . $this->image)) {
            unlink('storage/' . $this->image);
        }
    }
}
