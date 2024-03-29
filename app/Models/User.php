<?php

namespace App\Models;

use Laravel\Sanctum\HasApiTokens;
use App\Models\Scopes\Searchable;
use Spatie\Permission\Traits\HasRoles;
use Laravel\Jetstream\HasProfilePhoto;
use Illuminate\Notifications\Notifiable;
use App\Http\Livewire\DataTables\HasValid;
use Laravel\Fortify\TwoFactorAuthenticatable;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;

class User extends Authenticatable implements MustVerifyEmail
{
    use HasRoles;
    use Notifiable;
    use HasFactory;
    use Searchable;
    use SoftDeletes;
    use HasApiTokens;
    use HasProfilePhoto;
    use TwoFactorAuthenticatable;

    protected $fillable = [
        'name',
        'email',
        'password',
        'two_factor_secret',
        'two_factor_recovery_codes',
        'two_factor_confirmed_at',
        'current_team_id',
        'profile_photo_path',
    ];

    protected $searchableFields = ['*'];

    protected $hidden = ['password', 'remember_token'];

    protected $casts = [
        'email_verified_at' => 'datetime',
        'two_factor_confirmed_at' => 'datetime',
    ];

    public function employees()
    {
        return $this->hasMany(Employee::class);
    }

    public function stores()
    {
        return $this->hasMany(Store::class);
    }

    public function customers()
    {
        return $this->hasMany(Customer::class);
    }

    public function franchiseGroups()
    {
        return $this->hasMany(FranchiseGroup::class);
    }

    public function materialGroups()
    {
        return $this->hasMany(MaterialGroup::class);
    }

    public function vehicles()
    {
        return $this->hasMany(Vehicle::class);
    }

    public function closingStores()
    {
        return $this->hasMany(ClosingStore::class, 'transfer_by_id');
    }

    public function products()
    {
        return $this->hasMany(Product::class);
    }

    public function restaurantCategories()
    {
        return $this->hasMany(RestaurantCategory::class);
    }

    public function purchaseReceipts()
    {
        return $this->hasMany(PurchaseReceipt::class);
    }

    public function movementAssetResults()
    {
        return $this->hasMany(MovementAssetResult::class);
    }

    public function suppliers()
    {
        return $this->hasMany(Supplier::class);
    }

    public function salesOrderOnlinesCreated()
    {
        return $this->hasMany(SalesOrderOnline::class, 'created_by_id');
    }

    public function productionsCreated()
    {
        return $this->hasMany(Production::class, 'created_by_id');
    }

    public function remainingStocksCreated()
    {
        return $this->hasMany(RemainingStock::class, 'created_by_id');
    }

    public function purchaseOrdersCreated()
    {
        return $this->hasMany(PurchaseOrder::class, 'created_by_id');
    }

    public function presencesCreated()
    {
        return $this->hasMany(Presence::class, 'created_by_id');
    }

    public function closingCouriersCreated()
    {
        return $this->hasMany(ClosingCourier::class, 'created_by_id');
    }

    public function permitEmployeesCreated()
    {
        return $this->hasMany(PermitEmployee::class, 'created_by_id');
    }

    public function cleanAndNeatsCreated()
    {
        return $this->hasMany(CleanAndNeat::class, 'created_by_id');
    }

    public function closingStoresCreated()
    {
        return $this->hasMany(ClosingStore::class, 'created_by_id');
    }

    public function hygienesCreated()
    {
        return $this->hasMany(Hygiene::class, 'created_by_id');
    }

    public function cleanAndNeatsApproved()
    {
        return $this->hasMany(CleanAndNeat::class, 'approved_by_id');
    }

    public function salesOrderOnlinesApproved()
    {
        return $this->hasMany(SalesOrderOnline::class, 'approved_by_id');
    }

    public function transferStocksApproved()
    {
        return $this->hasMany(TransferStock::class, 'approved_by_id');
    }

    public function productionsApproved()
    {
        return $this->hasMany(Production::class, 'approved_by_id');
    }

    public function remainingStocksApproved()
    {
        return $this->hasMany(RemainingStock::class, 'approved_by_id');
    }

    public function purchaseOrdersApproved()
    {
        return $this->hasMany(PurchaseOrder::class, 'approved_by_id');
    }

    public function presencesApproved()
    {
        return $this->hasMany(Presence::class, 'approved_by_id');
    }

    public function closingStoresApproved()
    {
        return $this->hasMany(ClosingStore::class, 'approved_by_id');
    }

    public function closingCouriersApproved()
    {
        return $this->hasMany(ClosingCourier::class, 'approved_by_id');
    }

    public function permitEmployeesApproved()
    {
        return $this->hasMany(PermitEmployee::class, 'approved_by_id');
    }

    public function hygienesApproved()
    {
        return $this->hasMany(Hygiene::class, 'approved_by_id');
    }

    public function selfConsumptionsCreated()
    {
        return $this->hasMany(SelfConsumption::class, 'created_by_id');
    }

    public function utiliyUsagesCreated()
    {
        return $this->hasMany(UtilityUsage::class, 'created_by_id');
    }

    public function utiliyUsagesApproved()
    {
        return $this->hasMany(UtilityUsage::class, 'approved_by_id');
    }

    public function selfConsumptionsApproved()
    {
        return $this->hasMany(SelfConsumption::class, 'approved_by_id');
    }

    public function vehicleTaxes()
    {
        return $this->hasMany(VehicleTax::class);
    }

    public function refunds()
    {
        return $this->hasMany(Refund::class);
    }

    public function carts()
    {
        return $this->hasMany(Cart::class);
    }

    public function requestPurchases()
    {
        return $this->hasMany(RequestPurchase::class);
    }

    public function salesOrderEmployees()
    {
        return $this->hasMany(SalesOrderEmployee::class);
    }

    public function fuelServicesApproved()
    {
        return $this->hasMany(FuelService::class, 'approved_by_id');
    }

    public function transferStocksSent()
    {
        return $this->hasMany(TransferStock::class, 'sent_by_id');
    }

    public function dailySalariesCreated()
    {
        return $this->hasMany(DailySalary::class, 'created_by_id');
    }

    public function dailySalariesApproved()
    {
        return $this->hasMany(DailySalary::class, 'approved_by_id');
    }

    public function invoicePurchasesApproved()
    {
        return $this->hasMany(InvoicePurchase::class, 'approved_id');
    }

    public function invoicePurchasesCreated()
    {
        return $this->hasMany(InvoicePurchase::class, 'created_by_id');
    }

    public function fuelServicesCreated()
    {
        return $this->hasMany(FuelService::class, 'created_by_id');
    }

    public function transferStocksReceived()
    {
        return $this->hasMany(TransferStock::class, 'received_by_id');
    }

    public function deliveryLocations()
    {
        return $this->hasMany(DeliveryLocation::class);
    }

    public function salesOrderDirectSubmits()
    {
        return $this->hasMany(SalesOrderDirect::class, 'submitted_by_id');
    }

    public function salesOrderDirectOrders()
    {
        return $this->hasMany(SalesOrderDirect::class, 'order_by_id');
    }

    public function isSuperAdmin()
    {
        return $this->hasRole('super-admin');
    }

    public function delete_image()
    {
        if ($this->image && file_exists('storage/' . $this->image)) {
            unlink('storage/' . $this->image);
        }
    }
}
