<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\SopController;
use App\Http\Controllers\Api\UserController;
use App\Http\Controllers\Api\BankController;
use App\Http\Controllers\Api\UnitController;
use App\Http\Controllers\Api\RoomController;
use App\Http\Controllers\Api\CartController;
use App\Http\Controllers\Api\AuthController;
use App\Http\Controllers\Api\RoleController;
use App\Http\Controllers\Api\StoreController;
use App\Http\Controllers\Api\SavingController;
use App\Http\Controllers\Api\RefundController;
use App\Http\Controllers\Api\CouponController;
use App\Http\Controllers\Api\VehicleController;
use App\Http\Controllers\Api\ProductController;
use App\Http\Controllers\Api\UtilityController;
use App\Http\Controllers\Api\HygieneController;
use App\Http\Controllers\Api\CustomerController;
use App\Http\Controllers\Api\EmployeeController;
use App\Http\Controllers\Api\SupplierController;
use App\Http\Controllers\Api\CashlessController;
use App\Http\Controllers\Api\EProductController;
use App\Http\Controllers\Api\PresenceController;
use App\Http\Controllers\Api\UserCartsController;
use App\Http\Controllers\Api\UserStoresController;
use App\Http\Controllers\Api\ShiftStoreController;
use App\Http\Controllers\Api\ProductionController;
use App\Http\Controllers\Api\VehicleTaxController;
use App\Http\Controllers\Api\StoreAssetController;
use App\Http\Controllers\Api\PermissionController;
use App\Http\Controllers\Api\UserRefundsController;
use App\Http\Controllers\Api\PaymentTypeController;
use App\Http\Controllers\Api\UtilityBillController;
use App\Http\Controllers\Api\FuelServiceController;
use App\Http\Controllers\Api\DailySalaryController;
use App\Http\Controllers\Api\UserVehiclesController;
use App\Http\Controllers\Api\UserProductsController;
use App\Http\Controllers\Api\UserHygienesController;
use App\Http\Controllers\Api\ProductGroupController;
use App\Http\Controllers\Api\UnitProductsController;
use App\Http\Controllers\Api\CleanAndNeatController;
use App\Http\Controllers\Api\UtilityUsageController;
use App\Http\Controllers\Api\ProductionToController;
use App\Http\Controllers\Api\ClosingStoreController;
use App\Http\Controllers\Api\UserEmployeesController;
use App\Http\Controllers\Api\UserCustomersController;
use App\Http\Controllers\Api\UserSuppliersController;
use App\Http\Controllers\Api\UserPresencesController;
use App\Http\Controllers\Api\StoreVehiclesController;
use App\Http\Controllers\Api\StoreHygienesController;
use App\Http\Controllers\Api\MaterialGroupController;
use App\Http\Controllers\Api\MonthlySalaryController;
use App\Http\Controllers\Api\TransferStockController;
use App\Http\Controllers\Api\BankEmployeesController;
use App\Http\Controllers\Api\BankSuppliersController;
use App\Http\Controllers\Api\PurchaseOrderController;
use App\Http\Controllers\Api\UnitUtilitiesController;
use App\Http\Controllers\Api\MovementAssetController;
use App\Http\Controllers\Api\HygieneOfRoomController;
use App\Http\Controllers\Api\AdminCashlessController;
use App\Http\Controllers\Api\StoreCashlessController;
use App\Http\Controllers\Api\DetailRequestController;
use App\Http\Controllers\Api\DetailInvoiceController;
use App\Http\Controllers\Api\EProductCartsController;
use App\Http\Controllers\Api\StoreUtilitiesController;
use App\Http\Controllers\Api\StoreEProductsController;
use App\Http\Controllers\Api\StorePresencesController;
use App\Http\Controllers\Api\ClosingCourierController;
use App\Http\Controllers\Api\RemainingStockController;
use App\Http\Controllers\Api\FranchiseGroupController;
use App\Http\Controllers\Api\OnlineCategoryController;
use App\Http\Controllers\Api\PermitEmployeeController;
use App\Http\Controllers\Api\EmployeeStatusController;
use App\Http\Controllers\Api\ProductionFromController;
use App\Http\Controllers\Api\PaymentReceiptController;
use App\Http\Controllers\Api\EmployeeSavingsController;
use App\Http\Controllers\Api\UserProductionsController;
use App\Http\Controllers\Api\DeliveryAddressController;
use App\Http\Controllers\Api\ReceiptLoyverseController;
use App\Http\Controllers\Api\UtilityProviderController;
use App\Http\Controllers\Api\SelfConsumptionController;
use App\Http\Controllers\Api\PurchaseReceiptController;
use App\Http\Controllers\Api\AccountCashlessController;
use App\Http\Controllers\Api\DeliveryServiceController;
use App\Http\Controllers\Api\RequestPurchaseController;
use App\Http\Controllers\Api\InvoicePurchaseController;
use App\Http\Controllers\Api\UserVehicleTaxesController;
use App\Http\Controllers\Api\UserFuelServicesController;
use App\Http\Controllers\Api\StoreProductionsController;
use App\Http\Controllers\Api\StoreStoreAssetsController;
use App\Http\Controllers\Api\CashlessProviderController;
use App\Http\Controllers\Api\SalesOrderOnlineController;
use App\Http\Controllers\Api\ProductEProductsController;
use App\Http\Controllers\Api\ContractEmployeeController;
use App\Http\Controllers\Api\ContractLocationController;
use App\Http\Controllers\Api\SalesOrderDirectController;
use App\Http\Controllers\Api\DeliveryLocationController;
use App\Http\Controllers\Api\UserClosingStoresController;
use App\Http\Controllers\Api\UserCleanAndNeatsController;
use App\Http\Controllers\Api\UserUtilityUsagesController;
use App\Http\Controllers\Api\UserDailySalariesController;
use App\Http\Controllers\Api\WorkingExperienceController;
use App\Http\Controllers\Api\TransferToAccountController;
use App\Http\Controllers\Api\UserMaterialGroupsController;
use App\Http\Controllers\Api\UserPurchaseOrdersController;
use App\Http\Controllers\Api\UserTransferStocksController;
use App\Http\Controllers\Api\StoreClosingStoresController;
use App\Http\Controllers\Api\StoreDailySalariesController;
use App\Http\Controllers\Api\OnlineShopProviderController;
use App\Http\Controllers\Api\RestaurantCategoryController;
use App\Http\Controllers\Api\UnitDetailInvoicesController;
use App\Http\Controllers\Api\RoomHygieneOfRoomsController;
use App\Http\Controllers\Api\VehicleCertificateController;
use App\Http\Controllers\Api\MovementAssetAuditController;
use App\Http\Controllers\Api\ProductionMainFromController;
use App\Http\Controllers\Api\SalesOrderEmployeeController;
use App\Http\Controllers\Api\UserFranchiseGroupsController;
use App\Http\Controllers\Api\UserRemainingStocksController;
use App\Http\Controllers\Api\UserClosingCouriersController;
use App\Http\Controllers\Api\UserPermitEmployeesController;
use App\Http\Controllers\Api\VehicleVehicleTaxesController;
use App\Http\Controllers\Api\VehicleFuelServicesController;
use App\Http\Controllers\Api\StorePurchaseOrdersController;
use App\Http\Controllers\Api\StoreTransferStocksController;
use App\Http\Controllers\Api\StoreDetailRequestsController;
use App\Http\Controllers\Api\PaymentTypeProductsController;
use App\Http\Controllers\Api\ShiftStorePresencesController;
use App\Http\Controllers\Api\BankClosingCouriersController;
use App\Http\Controllers\Api\UtilityUtilityBillsController;
use App\Http\Controllers\Api\MovementAssetResultController;
use App\Http\Controllers\Api\UserPurchaseReceiptsController;
use App\Http\Controllers\Api\UserSelfConsumptionsController;
use App\Http\Controllers\Api\UserRequestPurchasesController;
use App\Http\Controllers\Api\UserInvoicePurchasesController;
use App\Http\Controllers\Api\StoreRemainingStocksController;
use App\Http\Controllers\Api\ProductGroupProductsController;
use App\Http\Controllers\Api\ProductProductionTosController;
use App\Http\Controllers\Api\UtilityUtilityUsagesController;
use App\Http\Controllers\Api\UserSalesOrderOnlinesController;
use App\Http\Controllers\Api\UserDeliveryLocationsController;
use App\Http\Controllers\Api\UserSalesOrderDirectsController;
use App\Http\Controllers\Api\StoreSelfConsumptionsController;
use App\Http\Controllers\Api\StoreRequestPurchasesController;
use App\Http\Controllers\Api\StoreInvoicePurchasesController;
use App\Http\Controllers\Api\MaterialGroupProductsController;
use App\Http\Controllers\Api\TransferStockProductsController;
use App\Http\Controllers\Api\ProductMovementAssetsController;
use App\Http\Controllers\Api\ProductDetailRequestsController;
use App\Http\Controllers\Api\ProductTransferStocksController;
use App\Http\Controllers\Api\ReceiptByItemLoyverseController;
use App\Http\Controllers\Api\HygieneHygieneOfRoomsController;
use App\Http\Controllers\Api\ProductionSupportFromController;
use App\Http\Controllers\Api\StoreContractLocationsController;
use App\Http\Controllers\Api\StoreSalesOrderOnlinesController;
use App\Http\Controllers\Api\StoreAccountCashlessesController;
use App\Http\Controllers\Api\StoreSalesOrderDirectsController;
use App\Http\Controllers\Api\SupplierPurchaseOrdersController;
use App\Http\Controllers\Api\RemainingStockProductsController;
use App\Http\Controllers\Api\FranchiseGroupProductsController;
use App\Http\Controllers\Api\MonthlySalaryPresencesController;
use App\Http\Controllers\Api\OnlineCategoryProductsController;
use App\Http\Controllers\Api\ProductRemainingStocksController;
use App\Http\Controllers\Api\BankTransferToAccountsController;
use App\Http\Controllers\Api\product_transfer_stockController;
use App\Http\Controllers\Api\ClosingStoreCashlessesController;
use App\Http\Controllers\Api\UserSalesOrderEmployeesController;
use App\Http\Controllers\Api\OnlineCategoryEProductsController;
use App\Http\Controllers\Api\PaymentTypeFuelServicesController;
use App\Http\Controllers\Api\ShiftStoreClosingStoresController;
use App\Http\Controllers\Api\ShiftStoreDailySalariesController;
use App\Http\Controllers\Api\ProductSelfConsumptionsController;
use App\Http\Controllers\Api\ProductionProductionTosController;
use App\Http\Controllers\Api\product_remaining_stockController;
use App\Http\Controllers\Api\SelfConsumptionProductsController;
use App\Http\Controllers\Api\EmployeeStatusEmployeesController;
use App\Http\Controllers\Api\SalesOrderDirectProductController;
use App\Http\Controllers\Api\CouponSalesOrderDirectsController;
use App\Http\Controllers\Api\PresenceMonthlySalariesController;
use App\Http\Controllers\Api\UserRestaurantCategoriesController;
use App\Http\Controllers\Api\UserMovementAssetResultsController;
use App\Http\Controllers\Api\StoreSalesOrderEmployeesController;
use App\Http\Controllers\Api\SupplierInvoicePurchasesController;
use App\Http\Controllers\Api\PaymentTypeDailySalariesController;
use App\Http\Controllers\Api\SalesOrderOnlineProductsController;
use App\Http\Controllers\Api\ProductSalesOrderOnlinesController;
use App\Http\Controllers\Api\UtilityProviderUtilitiesController;
use App\Http\Controllers\Api\StoreAssetMovementAssetsController;
use App\Http\Controllers\Api\ClosingStoreFuelServicesController;
use App\Http\Controllers\Api\FuelServiceClosingStoresController;
use App\Http\Controllers\Api\DailySalaryClosingStoresController;
use App\Http\Controllers\Api\CustomerSalesOrderOnlinesController;
use App\Http\Controllers\Api\CustomerDeliveryAddressesController;
use App\Http\Controllers\Api\EmployeeContractEmployeesController;
use App\Http\Controllers\Api\StoreMovementAssetResultsController;
use App\Http\Controllers\Api\PaymentTypePurchaseOrdersController;
use App\Http\Controllers\Api\PaymentTypeDetailRequestsController;
use App\Http\Controllers\Api\ProductionProductionFromsController;
use App\Http\Controllers\Api\UnitPurchaseOrderProductsController;
use App\Http\Controllers\Api\ClosingStoreDailySalariesController;
use App\Http\Controllers\Api\AccountCashlessCashlessesController;
use App\Http\Controllers\Api\EmployeeWorkingExperiencesController;
use App\Http\Controllers\Api\RestaurantCategoryProductsController;
use App\Http\Controllers\Api\ProductSalesOrderEmployeesController;
use App\Http\Controllers\Api\product_sales_order_onlineController;
use App\Http\Controllers\Api\PurchaseOrderClosingStoresController;
use App\Http\Controllers\Api\ClosingStorePurchaseOrdersController;
use App\Http\Controllers\Api\PaymentReceiptFuelServicesController;
use App\Http\Controllers\Api\FuelServicePaymentReceiptsController;
use App\Http\Controllers\Api\closing_store_fuel_serviceController;
use App\Http\Controllers\Api\closing_store_daily_salaryController;
use App\Http\Controllers\Api\DailySalaryPaymentReceiptsController;
use App\Http\Controllers\Api\SalesOrderEmployeeProductsController;
use App\Http\Controllers\Api\ClosingCourierClosingStoresController;
use App\Http\Controllers\Api\PaymentTypeInvoicePurchasesController;
use App\Http\Controllers\Api\ClosingStoreClosingCouriersController;
use App\Http\Controllers\Api\PaymentReceiptDailySalariesController;
use App\Http\Controllers\Api\ProductPurchaseOrderProductsController;
use App\Http\Controllers\Api\product_sales_order_employeeController;
use App\Http\Controllers\Api\ClosingStoreInvoicePurchasesController;
use App\Http\Controllers\Api\InvoicePurchaseClosingStoresController;
use App\Http\Controllers\Api\fuel_service_payment_receiptController;
use App\Http\Controllers\Api\daily_salary_payment_receiptController;
use App\Http\Controllers\Api\ProductProductionSupportFromsController;
use App\Http\Controllers\Api\ProductionProductionMainFromsController;
use App\Http\Controllers\Api\PurchaseOrderPurchaseReceiptsController;
use App\Http\Controllers\Api\closing_courier_closing_storeController;
use App\Http\Controllers\Api\PurchaseReceiptPurchaseOrdersController;
use App\Http\Controllers\Api\RequestPurchaseDetailRequestsController;
use App\Http\Controllers\Api\InvoicePurchaseDetailInvoicesController;
use App\Http\Controllers\Api\AdminCashlessAccountCashlessesController;
use App\Http\Controllers\Api\StoreCashlessAccountCashlessesController;
use App\Http\Controllers\Api\AccountCashlessAdminCashlessesController;
use App\Http\Controllers\Api\PaymentReceiptInvoicePurchasesController;
use App\Http\Controllers\Api\InvoicePurchasePaymentReceiptsController;
use App\Http\Controllers\Api\closing_store_invoice_purchaseController;
use App\Http\Controllers\Api\CashlessProviderAdminCashlessesController;
use App\Http\Controllers\Api\purchase_order_purchase_receiptController;
use App\Http\Controllers\Api\account_cashless_admin_cashlessController;
use App\Http\Controllers\Api\ProductionProductionSupportFromsController;
use App\Http\Controllers\Api\DeliveryAddressSalesOrderOnlinesController;
use App\Http\Controllers\Api\MovementAssetMovementAssetAuditsController;
use App\Http\Controllers\Api\DeliveryServiceSalesOrderOnlinesController;
use App\Http\Controllers\Api\DeliveryServiceSalesOrderDirectsController;
use App\Http\Controllers\Api\invoice_purchase_payment_receiptController;
use App\Http\Controllers\Api\DetailInvoiceProductionMainFromsController;
use App\Http\Controllers\Api\EProductSalesOrderDirectProductsController;
use App\Http\Controllers\Api\CashlessProviderAccountCashlessesController;
use App\Http\Controllers\Api\DeliveryLocationSalesOrderDirectsController;
use App\Http\Controllers\Api\TransferToAccountSalesOrderDirectsController;
use App\Http\Controllers\Api\OnlineShopProviderSalesOrderOnlinesController;
use App\Http\Controllers\Api\MovementAssetResultMovementAssetAuditsController;
use App\Http\Controllers\Api\SalesOrderDirectSalesOrderDirectProductsController;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

Route::post('/login', [AuthController::class, 'login'])->name('api.login');

Route::middleware('auth:sanctum')
    ->get('/user', function (Request $request) {
        return $request->user();
    })
    ->name('api.user');

Route::name('api.')
    ->middleware('auth:sanctum')
    ->group(function () {
        Route::apiResource('roles', RoleController::class);
        Route::apiResource('permissions', PermissionController::class);

        Route::apiResource('customers', CustomerController::class);

        // Customer Sales Order Onlines
        Route::get('/customers/{customer}/sales-order-onlines', [
            CustomerSalesOrderOnlinesController::class,
            'index',
        ])->name('customers.sales-order-onlines.index');
        Route::post('/customers/{customer}/sales-order-onlines', [
            CustomerSalesOrderOnlinesController::class,
            'store',
        ])->name('customers.sales-order-onlines.store');

        // Customer Delivery Addresses
        Route::get('/customers/{customer}/delivery-addresses', [
            CustomerDeliveryAddressesController::class,
            'index',
        ])->name('customers.delivery-addresses.index');
        Route::post('/customers/{customer}/delivery-addresses', [
            CustomerDeliveryAddressesController::class,
            'store',
        ])->name('customers.delivery-addresses.store');

        Route::apiResource('employees', EmployeeController::class);

        // Employee Savings
        Route::get('/employees/{employee}/savings', [
            EmployeeSavingsController::class,
            'index',
        ])->name('employees.savings.index');
        Route::post('/employees/{employee}/savings', [
            EmployeeSavingsController::class,
            'store',
        ])->name('employees.savings.store');

        // Employee Contract Employees
        Route::get('/employees/{employee}/contract-employees', [
            EmployeeContractEmployeesController::class,
            'index',
        ])->name('employees.contract-employees.index');
        Route::post('/employees/{employee}/contract-employees', [
            EmployeeContractEmployeesController::class,
            'store',
        ])->name('employees.contract-employees.store');

        // Employee Working Experiences
        Route::get('/employees/{employee}/working-experiences', [
            EmployeeWorkingExperiencesController::class,
            'index',
        ])->name('employees.working-experiences.index');
        Route::post('/employees/{employee}/working-experiences', [
            EmployeeWorkingExperiencesController::class,
            'store',
        ])->name('employees.working-experiences.store');

        Route::apiResource('users', UserController::class);

        // User Employees
        Route::get('/users/{user}/employees', [
            UserEmployeesController::class,
            'index',
        ])->name('users.employees.index');
        Route::post('/users/{user}/employees', [
            UserEmployeesController::class,
            'store',
        ])->name('users.employees.store');

        // User Stores
        Route::get('/users/{user}/stores', [
            UserStoresController::class,
            'index',
        ])->name('users.stores.index');
        Route::post('/users/{user}/stores', [
            UserStoresController::class,
            'store',
        ])->name('users.stores.store');

        // User Customers
        Route::get('/users/{user}/customers', [
            UserCustomersController::class,
            'index',
        ])->name('users.customers.index');
        Route::post('/users/{user}/customers', [
            UserCustomersController::class,
            'store',
        ])->name('users.customers.store');

        // User Franchise Groups
        Route::get('/users/{user}/franchise-groups', [
            UserFranchiseGroupsController::class,
            'index',
        ])->name('users.franchise-groups.index');
        Route::post('/users/{user}/franchise-groups', [
            UserFranchiseGroupsController::class,
            'store',
        ])->name('users.franchise-groups.store');

        // User Material Groups
        Route::get('/users/{user}/material-groups', [
            UserMaterialGroupsController::class,
            'index',
        ])->name('users.material-groups.index');
        Route::post('/users/{user}/material-groups', [
            UserMaterialGroupsController::class,
            'store',
        ])->name('users.material-groups.store');

        // User Vehicles
        Route::get('/users/{user}/vehicles', [
            UserVehiclesController::class,
            'index',
        ])->name('users.vehicles.index');
        Route::post('/users/{user}/vehicles', [
            UserVehiclesController::class,
            'store',
        ])->name('users.vehicles.store');

        // User Closing Stores
        Route::get('/users/{user}/closing-stores', [
            UserClosingStoresController::class,
            'index',
        ])->name('users.closing-stores.index');
        Route::post('/users/{user}/closing-stores', [
            UserClosingStoresController::class,
            'store',
        ])->name('users.closing-stores.store');

        // User Products
        Route::get('/users/{user}/products', [
            UserProductsController::class,
            'index',
        ])->name('users.products.index');
        Route::post('/users/{user}/products', [
            UserProductsController::class,
            'store',
        ])->name('users.products.store');

        // User Restaurant Categories
        Route::get('/users/{user}/restaurant-categories', [
            UserRestaurantCategoriesController::class,
            'index',
        ])->name('users.restaurant-categories.index');
        Route::post('/users/{user}/restaurant-categories', [
            UserRestaurantCategoriesController::class,
            'store',
        ])->name('users.restaurant-categories.store');

        // User Purchase Receipts
        Route::get('/users/{user}/purchase-receipts', [
            UserPurchaseReceiptsController::class,
            'index',
        ])->name('users.purchase-receipts.index');
        Route::post('/users/{user}/purchase-receipts', [
            UserPurchaseReceiptsController::class,
            'store',
        ])->name('users.purchase-receipts.store');

        // User Movement Asset Results
        Route::get('/users/{user}/movement-asset-results', [
            UserMovementAssetResultsController::class,
            'index',
        ])->name('users.movement-asset-results.index');
        Route::post('/users/{user}/movement-asset-results', [
            UserMovementAssetResultsController::class,
            'store',
        ])->name('users.movement-asset-results.store');

        // User Suppliers
        Route::get('/users/{user}/suppliers', [
            UserSuppliersController::class,
            'index',
        ])->name('users.suppliers.index');
        Route::post('/users/{user}/suppliers', [
            UserSuppliersController::class,
            'store',
        ])->name('users.suppliers.store');

        // User Sales Order Onlines Created
        Route::get('/users/{user}/sales-order-onlines', [
            UserSalesOrderOnlinesController::class,
            'index',
        ])->name('users.sales-order-onlines.index');
        Route::post('/users/{user}/sales-order-onlines', [
            UserSalesOrderOnlinesController::class,
            'store',
        ])->name('users.sales-order-onlines.store');

        // User Productions Created
        Route::get('/users/{user}/productions', [
            UserProductionsController::class,
            'index',
        ])->name('users.productions.index');
        Route::post('/users/{user}/productions', [
            UserProductionsController::class,
            'store',
        ])->name('users.productions.store');

        // User Remaining Stocks Created
        Route::get('/users/{user}/remaining-stocks', [
            UserRemainingStocksController::class,
            'index',
        ])->name('users.remaining-stocks.index');
        Route::post('/users/{user}/remaining-stocks', [
            UserRemainingStocksController::class,
            'store',
        ])->name('users.remaining-stocks.store');

        // User Purchase Orders Created
        Route::get('/users/{user}/purchase-orders', [
            UserPurchaseOrdersController::class,
            'index',
        ])->name('users.purchase-orders.index');
        Route::post('/users/{user}/purchase-orders', [
            UserPurchaseOrdersController::class,
            'store',
        ])->name('users.purchase-orders.store');

        // User Presences Created
        Route::get('/users/{user}/presences', [
            UserPresencesController::class,
            'index',
        ])->name('users.presences.index');
        Route::post('/users/{user}/presences', [
            UserPresencesController::class,
            'store',
        ])->name('users.presences.store');

        // User Closing Couriers Created
        Route::get('/users/{user}/closing-couriers', [
            UserClosingCouriersController::class,
            'index',
        ])->name('users.closing-couriers.index');
        Route::post('/users/{user}/closing-couriers', [
            UserClosingCouriersController::class,
            'store',
        ])->name('users.closing-couriers.store');

        // User Permit Employees Created
        Route::get('/users/{user}/permit-employees', [
            UserPermitEmployeesController::class,
            'index',
        ])->name('users.permit-employees.index');
        Route::post('/users/{user}/permit-employees', [
            UserPermitEmployeesController::class,
            'store',
        ])->name('users.permit-employees.store');

        // User Clean And Neats Created
        Route::get('/users/{user}/clean-and-neats', [
            UserCleanAndNeatsController::class,
            'index',
        ])->name('users.clean-and-neats.index');
        Route::post('/users/{user}/clean-and-neats', [
            UserCleanAndNeatsController::class,
            'store',
        ])->name('users.clean-and-neats.store');

        // User Closing Stores Created
        Route::get('/users/{user}/closing-stores', [
            UserClosingStoresController::class,
            'index',
        ])->name('users.closing-stores.index');
        Route::post('/users/{user}/closing-stores', [
            UserClosingStoresController::class,
            'store',
        ])->name('users.closing-stores.store');

        // User Hygienes Created
        Route::get('/users/{user}/hygienes', [
            UserHygienesController::class,
            'index',
        ])->name('users.hygienes.index');
        Route::post('/users/{user}/hygienes', [
            UserHygienesController::class,
            'store',
        ])->name('users.hygienes.store');

        // User Clean And Neats Approved
        Route::get('/users/{user}/clean-and-neats', [
            UserCleanAndNeatsController::class,
            'index',
        ])->name('users.clean-and-neats.index');
        Route::post('/users/{user}/clean-and-neats', [
            UserCleanAndNeatsController::class,
            'store',
        ])->name('users.clean-and-neats.store');

        // User Sales Order Onlines Approved
        Route::get('/users/{user}/sales-order-onlines', [
            UserSalesOrderOnlinesController::class,
            'index',
        ])->name('users.sales-order-onlines.index');
        Route::post('/users/{user}/sales-order-onlines', [
            UserSalesOrderOnlinesController::class,
            'store',
        ])->name('users.sales-order-onlines.store');

        // User Transfer Stocks Approved
        Route::get('/users/{user}/transfer-stocks', [
            UserTransferStocksController::class,
            'index',
        ])->name('users.transfer-stocks.index');
        Route::post('/users/{user}/transfer-stocks', [
            UserTransferStocksController::class,
            'store',
        ])->name('users.transfer-stocks.store');

        // User Productions Approved
        Route::get('/users/{user}/productions', [
            UserProductionsController::class,
            'index',
        ])->name('users.productions.index');
        Route::post('/users/{user}/productions', [
            UserProductionsController::class,
            'store',
        ])->name('users.productions.store');

        // User Remaining Stocks Approved
        Route::get('/users/{user}/remaining-stocks', [
            UserRemainingStocksController::class,
            'index',
        ])->name('users.remaining-stocks.index');
        Route::post('/users/{user}/remaining-stocks', [
            UserRemainingStocksController::class,
            'store',
        ])->name('users.remaining-stocks.store');

        // User Purchase Orders Approved
        Route::get('/users/{user}/purchase-orders', [
            UserPurchaseOrdersController::class,
            'index',
        ])->name('users.purchase-orders.index');
        Route::post('/users/{user}/purchase-orders', [
            UserPurchaseOrdersController::class,
            'store',
        ])->name('users.purchase-orders.store');

        // User Presences Approved
        Route::get('/users/{user}/presences', [
            UserPresencesController::class,
            'index',
        ])->name('users.presences.index');
        Route::post('/users/{user}/presences', [
            UserPresencesController::class,
            'store',
        ])->name('users.presences.store');

        // User Closing Stores Approved
        Route::get('/users/{user}/closing-stores', [
            UserClosingStoresController::class,
            'index',
        ])->name('users.closing-stores.index');
        Route::post('/users/{user}/closing-stores', [
            UserClosingStoresController::class,
            'store',
        ])->name('users.closing-stores.store');

        // User Closing Couriers Approved
        Route::get('/users/{user}/closing-couriers', [
            UserClosingCouriersController::class,
            'index',
        ])->name('users.closing-couriers.index');
        Route::post('/users/{user}/closing-couriers', [
            UserClosingCouriersController::class,
            'store',
        ])->name('users.closing-couriers.store');

        // User Permit Employees Approved
        Route::get('/users/{user}/permit-employees', [
            UserPermitEmployeesController::class,
            'index',
        ])->name('users.permit-employees.index');
        Route::post('/users/{user}/permit-employees', [
            UserPermitEmployeesController::class,
            'store',
        ])->name('users.permit-employees.store');

        // User Hygienes Approved
        Route::get('/users/{user}/hygienes', [
            UserHygienesController::class,
            'index',
        ])->name('users.hygienes.index');
        Route::post('/users/{user}/hygienes', [
            UserHygienesController::class,
            'store',
        ])->name('users.hygienes.store');

        // User Self Consumptions Created
        Route::get('/users/{user}/self-consumptions', [
            UserSelfConsumptionsController::class,
            'index',
        ])->name('users.self-consumptions.index');
        Route::post('/users/{user}/self-consumptions', [
            UserSelfConsumptionsController::class,
            'store',
        ])->name('users.self-consumptions.store');

        // User Utiliy Usages Created
        Route::get('/users/{user}/utility-usages', [
            UserUtilityUsagesController::class,
            'index',
        ])->name('users.utility-usages.index');
        Route::post('/users/{user}/utility-usages', [
            UserUtilityUsagesController::class,
            'store',
        ])->name('users.utility-usages.store');

        // User Utiliy Usages Approved
        Route::get('/users/{user}/utility-usages', [
            UserUtilityUsagesController::class,
            'index',
        ])->name('users.utility-usages.index');
        Route::post('/users/{user}/utility-usages', [
            UserUtilityUsagesController::class,
            'store',
        ])->name('users.utility-usages.store');

        // User Self Consumptions Approved
        Route::get('/users/{user}/self-consumptions', [
            UserSelfConsumptionsController::class,
            'index',
        ])->name('users.self-consumptions.index');
        Route::post('/users/{user}/self-consumptions', [
            UserSelfConsumptionsController::class,
            'store',
        ])->name('users.self-consumptions.store');

        // User Vehicle Taxes
        Route::get('/users/{user}/vehicle-taxes', [
            UserVehicleTaxesController::class,
            'index',
        ])->name('users.vehicle-taxes.index');
        Route::post('/users/{user}/vehicle-taxes', [
            UserVehicleTaxesController::class,
            'store',
        ])->name('users.vehicle-taxes.store');

        // User Refunds
        Route::get('/users/{user}/refunds', [
            UserRefundsController::class,
            'index',
        ])->name('users.refunds.index');
        Route::post('/users/{user}/refunds', [
            UserRefundsController::class,
            'store',
        ])->name('users.refunds.store');

        // User Carts
        Route::get('/users/{user}/carts', [
            UserCartsController::class,
            'index',
        ])->name('users.carts.index');
        Route::post('/users/{user}/carts', [
            UserCartsController::class,
            'store',
        ])->name('users.carts.store');

        // User Request Purchases
        Route::get('/users/{user}/request-purchases', [
            UserRequestPurchasesController::class,
            'index',
        ])->name('users.request-purchases.index');
        Route::post('/users/{user}/request-purchases', [
            UserRequestPurchasesController::class,
            'store',
        ])->name('users.request-purchases.store');

        // User Sales Order Employees
        Route::get('/users/{user}/sales-order-employees', [
            UserSalesOrderEmployeesController::class,
            'index',
        ])->name('users.sales-order-employees.index');
        Route::post('/users/{user}/sales-order-employees', [
            UserSalesOrderEmployeesController::class,
            'store',
        ])->name('users.sales-order-employees.store');

        // User Fuel Services Approved
        Route::get('/users/{user}/fuel-services', [
            UserFuelServicesController::class,
            'index',
        ])->name('users.fuel-services.index');
        Route::post('/users/{user}/fuel-services', [
            UserFuelServicesController::class,
            'store',
        ])->name('users.fuel-services.store');

        // User Transfer Stocks Sent
        Route::get('/users/{user}/transfer-stocks', [
            UserTransferStocksController::class,
            'index',
        ])->name('users.transfer-stocks.index');
        Route::post('/users/{user}/transfer-stocks', [
            UserTransferStocksController::class,
            'store',
        ])->name('users.transfer-stocks.store');

        // User Daily Salaries Created
        Route::get('/users/{user}/daily-salaries', [
            UserDailySalariesController::class,
            'index',
        ])->name('users.daily-salaries.index');
        Route::post('/users/{user}/daily-salaries', [
            UserDailySalariesController::class,
            'store',
        ])->name('users.daily-salaries.store');

        // User Daily Salaries Approved
        Route::get('/users/{user}/daily-salaries', [
            UserDailySalariesController::class,
            'index',
        ])->name('users.daily-salaries.index');
        Route::post('/users/{user}/daily-salaries', [
            UserDailySalariesController::class,
            'store',
        ])->name('users.daily-salaries.store');

        // User Invoice Purchases Approved
        Route::get('/users/{user}/invoice-purchases', [
            UserInvoicePurchasesController::class,
            'index',
        ])->name('users.invoice-purchases.index');
        Route::post('/users/{user}/invoice-purchases', [
            UserInvoicePurchasesController::class,
            'store',
        ])->name('users.invoice-purchases.store');

        // User Invoice Purchases Created
        Route::get('/users/{user}/invoice-purchases', [
            UserInvoicePurchasesController::class,
            'index',
        ])->name('users.invoice-purchases.index');
        Route::post('/users/{user}/invoice-purchases', [
            UserInvoicePurchasesController::class,
            'store',
        ])->name('users.invoice-purchases.store');

        // User Fuel Services Created
        Route::get('/users/{user}/fuel-services', [
            UserFuelServicesController::class,
            'index',
        ])->name('users.fuel-services.index');
        Route::post('/users/{user}/fuel-services', [
            UserFuelServicesController::class,
            'store',
        ])->name('users.fuel-services.store');

        // User Transfer Stocks Received
        Route::get('/users/{user}/transfer-stocks', [
            UserTransferStocksController::class,
            'index',
        ])->name('users.transfer-stocks.index');
        Route::post('/users/{user}/transfer-stocks', [
            UserTransferStocksController::class,
            'store',
        ])->name('users.transfer-stocks.store');

        // User Delivery Locations
        Route::get('/users/{user}/delivery-locations', [
            UserDeliveryLocationsController::class,
            'index',
        ])->name('users.delivery-locations.index');
        Route::post('/users/{user}/delivery-locations', [
            UserDeliveryLocationsController::class,
            'store',
        ])->name('users.delivery-locations.store');

        // User Sales Order Direct Submits
        Route::get('/users/{user}/sales-order-directs', [
            UserSalesOrderDirectsController::class,
            'index',
        ])->name('users.sales-order-directs.index');
        Route::post('/users/{user}/sales-order-directs', [
            UserSalesOrderDirectsController::class,
            'store',
        ])->name('users.sales-order-directs.store');

        // User Sales Order Direct Orders
        Route::get('/users/{user}/sales-order-directs', [
            UserSalesOrderDirectsController::class,
            'index',
        ])->name('users.sales-order-directs.index');
        Route::post('/users/{user}/sales-order-directs', [
            UserSalesOrderDirectsController::class,
            'store',
        ])->name('users.sales-order-directs.store');

        Route::apiResource('vehicles', VehicleController::class);

        // Vehicle Vehicle Taxes
        Route::get('/vehicles/{vehicle}/vehicle-taxes', [
            VehicleVehicleTaxesController::class,
            'index',
        ])->name('vehicles.vehicle-taxes.index');
        Route::post('/vehicles/{vehicle}/vehicle-taxes', [
            VehicleVehicleTaxesController::class,
            'store',
        ])->name('vehicles.vehicle-taxes.store');

        // Vehicle Fuel Services
        Route::get('/vehicles/{vehicle}/fuel-services', [
            VehicleFuelServicesController::class,
            'index',
        ])->name('vehicles.fuel-services.index');
        Route::post('/vehicles/{vehicle}/fuel-services', [
            VehicleFuelServicesController::class,
            'store',
        ])->name('vehicles.fuel-services.store');

        Route::apiResource('stores', StoreController::class);

        // Store Contract Locations
        Route::get('/stores/{store}/contract-locations', [
            StoreContractLocationsController::class,
            'index',
        ])->name('stores.contract-locations.index');
        Route::post('/stores/{store}/contract-locations', [
            StoreContractLocationsController::class,
            'store',
        ])->name('stores.contract-locations.store');

        // Store Vehicles
        Route::get('/stores/{store}/vehicles', [
            StoreVehiclesController::class,
            'index',
        ])->name('stores.vehicles.index');
        Route::post('/stores/{store}/vehicles', [
            StoreVehiclesController::class,
            'store',
        ])->name('stores.vehicles.store');

        // Store Movement Asset Results
        Route::get('/stores/{store}/movement-asset-results', [
            StoreMovementAssetResultsController::class,
            'index',
        ])->name('stores.movement-asset-results.index');
        Route::post('/stores/{store}/movement-asset-results', [
            StoreMovementAssetResultsController::class,
            'store',
        ])->name('stores.movement-asset-results.store');

        // Store Closing Stores
        Route::get('/stores/{store}/closing-stores', [
            StoreClosingStoresController::class,
            'index',
        ])->name('stores.closing-stores.index');
        Route::post('/stores/{store}/closing-stores', [
            StoreClosingStoresController::class,
            'store',
        ])->name('stores.closing-stores.store');

        // Store Purchase Orders
        Route::get('/stores/{store}/purchase-orders', [
            StorePurchaseOrdersController::class,
            'index',
        ])->name('stores.purchase-orders.index');
        Route::post('/stores/{store}/purchase-orders', [
            StorePurchaseOrdersController::class,
            'store',
        ])->name('stores.purchase-orders.store');

        // Store Remaining Stocks
        Route::get('/stores/{store}/remaining-stocks', [
            StoreRemainingStocksController::class,
            'index',
        ])->name('stores.remaining-stocks.index');
        Route::post('/stores/{store}/remaining-stocks', [
            StoreRemainingStocksController::class,
            'store',
        ])->name('stores.remaining-stocks.store');

        // Store Productions
        Route::get('/stores/{store}/productions', [
            StoreProductionsController::class,
            'index',
        ])->name('stores.productions.index');
        Route::post('/stores/{store}/productions', [
            StoreProductionsController::class,
            'store',
        ])->name('stores.productions.store');

        // Store Sales Order Employees
        Route::get('/stores/{store}/sales-order-employees', [
            StoreSalesOrderEmployeesController::class,
            'index',
        ])->name('stores.sales-order-employees.index');
        Route::post('/stores/{store}/sales-order-employees', [
            StoreSalesOrderEmployeesController::class,
            'store',
        ])->name('stores.sales-order-employees.store');

        // Store Sales Order Onlines
        Route::get('/stores/{store}/sales-order-onlines', [
            StoreSalesOrderOnlinesController::class,
            'index',
        ])->name('stores.sales-order-onlines.index');
        Route::post('/stores/{store}/sales-order-onlines', [
            StoreSalesOrderOnlinesController::class,
            'store',
        ])->name('stores.sales-order-onlines.store');

        // Store From Transfer Stocks
        Route::get('/stores/{store}/transfer-stocks', [
            StoreTransferStocksController::class,
            'index',
        ])->name('stores.transfer-stocks.index');
        Route::post('/stores/{store}/transfer-stocks', [
            StoreTransferStocksController::class,
            'store',
        ])->name('stores.transfer-stocks.store');

        // Store To Transfer Stocks
        Route::get('/stores/{store}/transfer-stocks', [
            StoreTransferStocksController::class,
            'index',
        ])->name('stores.transfer-stocks.index');
        Route::post('/stores/{store}/transfer-stocks', [
            StoreTransferStocksController::class,
            'store',
        ])->name('stores.transfer-stocks.store');

        // Store Hygienes
        Route::get('/stores/{store}/hygienes', [
            StoreHygienesController::class,
            'index',
        ])->name('stores.hygienes.index');
        Route::post('/stores/{store}/hygienes', [
            StoreHygienesController::class,
            'store',
        ])->name('stores.hygienes.store');

        // Store Self Consumptions
        Route::get('/stores/{store}/self-consumptions', [
            StoreSelfConsumptionsController::class,
            'index',
        ])->name('stores.self-consumptions.index');
        Route::post('/stores/{store}/self-consumptions', [
            StoreSelfConsumptionsController::class,
            'store',
        ])->name('stores.self-consumptions.store');

        // Store Utilities
        Route::get('/stores/{store}/utilities', [
            StoreUtilitiesController::class,
            'index',
        ])->name('stores.utilities.index');
        Route::post('/stores/{store}/utilities', [
            StoreUtilitiesController::class,
            'store',
        ])->name('stores.utilities.store');

        // Store Store Assets
        Route::get('/stores/{store}/store-assets', [
            StoreStoreAssetsController::class,
            'index',
        ])->name('stores.store-assets.index');
        Route::post('/stores/{store}/store-assets', [
            StoreStoreAssetsController::class,
            'store',
        ])->name('stores.store-assets.store');

        // Store Account Cashlesses
        Route::get('/stores/{store}/account-cashlesses', [
            StoreAccountCashlessesController::class,
            'index',
        ])->name('stores.account-cashlesses.index');
        Route::post('/stores/{store}/account-cashlesses', [
            StoreAccountCashlessesController::class,
            'store',
        ])->name('stores.account-cashlesses.store');

        // Store E Products
        Route::get('/stores/{store}/e-products', [
            StoreEProductsController::class,
            'index',
        ])->name('stores.e-products.index');
        Route::post('/stores/{store}/e-products', [
            StoreEProductsController::class,
            'store',
        ])->name('stores.e-products.store');

        // Store Request Purchases
        Route::get('/stores/{store}/request-purchases', [
            StoreRequestPurchasesController::class,
            'index',
        ])->name('stores.request-purchases.index');
        Route::post('/stores/{store}/request-purchases', [
            StoreRequestPurchasesController::class,
            'store',
        ])->name('stores.request-purchases.store');

        // Store Invoice Purchases
        Route::get('/stores/{store}/invoice-purchases', [
            StoreInvoicePurchasesController::class,
            'index',
        ])->name('stores.invoice-purchases.index');
        Route::post('/stores/{store}/invoice-purchases', [
            StoreInvoicePurchasesController::class,
            'store',
        ])->name('stores.invoice-purchases.store');

        // Store Detail Requests
        Route::get('/stores/{store}/detail-requests', [
            StoreDetailRequestsController::class,
            'index',
        ])->name('stores.detail-requests.index');
        Route::post('/stores/{store}/detail-requests', [
            StoreDetailRequestsController::class,
            'store',
        ])->name('stores.detail-requests.store');

        // Store Presences
        Route::get('/stores/{store}/presences', [
            StorePresencesController::class,
            'index',
        ])->name('stores.presences.index');
        Route::post('/stores/{store}/presences', [
            StorePresencesController::class,
            'store',
        ])->name('stores.presences.store');

        // Store Daily Salaries
        Route::get('/stores/{store}/daily-salaries', [
            StoreDailySalariesController::class,
            'index',
        ])->name('stores.daily-salaries.index');
        Route::post('/stores/{store}/daily-salaries', [
            StoreDailySalariesController::class,
            'store',
        ])->name('stores.daily-salaries.store');

        // Store Sales Order Directs
        Route::get('/stores/{store}/sales-order-directs', [
            StoreSalesOrderDirectsController::class,
            'index',
        ])->name('stores.sales-order-directs.index');
        Route::post('/stores/{store}/sales-order-directs', [
            StoreSalesOrderDirectsController::class,
            'store',
        ])->name('stores.sales-order-directs.store');

        Route::apiResource('suppliers', SupplierController::class);

        // Supplier Purchase Orders
        Route::get('/suppliers/{supplier}/purchase-orders', [
            SupplierPurchaseOrdersController::class,
            'index',
        ])->name('suppliers.purchase-orders.index');
        Route::post('/suppliers/{supplier}/purchase-orders', [
            SupplierPurchaseOrdersController::class,
            'store',
        ])->name('suppliers.purchase-orders.store');

        // Supplier Invoice Purchases
        Route::get('/suppliers/{supplier}/invoice-purchases', [
            SupplierInvoicePurchasesController::class,
            'index',
        ])->name('suppliers.invoice-purchases.index');
        Route::post('/suppliers/{supplier}/invoice-purchases', [
            SupplierInvoicePurchasesController::class,
            'store',
        ])->name('suppliers.invoice-purchases.store');

        Route::apiResource('closing-couriers', ClosingCourierController::class);

        // ClosingCourier Closing Stores
        Route::get('/closing-couriers/{closingCourier}/closing-stores', [
            ClosingCourierClosingStoresController::class,
            'index',
        ])->name('closing-couriers.closing-stores.index');
        Route::post(
            '/closing-couriers/{closingCourier}/closing-stores/{closingStore}',
            [ClosingCourierClosingStoresController::class, 'store']
        )->name('closing-couriers.closing-stores.store');
        Route::delete(
            '/closing-couriers/{closingCourier}/closing-stores/{closingStore}',
            [ClosingCourierClosingStoresController::class, 'destroy']
        )->name('closing-couriers.closing-stores.destroy');

        Route::apiResource('remaining-stocks', RemainingStockController::class);

        // RemainingStock Products
        Route::get('/remaining-stocks/{remainingStock}/products', [
            RemainingStockProductsController::class,
            'index',
        ])->name('remaining-stocks.products.index');
        Route::post('/remaining-stocks/{remainingStock}/products/{product}', [
            RemainingStockProductsController::class,
            'store',
        ])->name('remaining-stocks.products.store');
        Route::delete('/remaining-stocks/{remainingStock}/products/{product}', [
            RemainingStockProductsController::class,
            'destroy',
        ])->name('remaining-stocks.products.destroy');

        Route::apiResource(
            'cashless-providers',
            CashlessProviderController::class
        );

        // CashlessProvider Admin Cashlesses
        Route::get('/cashless-providers/{cashlessProvider}/admin-cashlesses', [
            CashlessProviderAdminCashlessesController::class,
            'index',
        ])->name('cashless-providers.admin-cashlesses.index');
        Route::post('/cashless-providers/{cashlessProvider}/admin-cashlesses', [
            CashlessProviderAdminCashlessesController::class,
            'store',
        ])->name('cashless-providers.admin-cashlesses.store');

        // CashlessProvider Account Cashlesses
        Route::get(
            '/cashless-providers/{cashlessProvider}/account-cashlesses',
            [CashlessProviderAccountCashlessesController::class, 'index']
        )->name('cashless-providers.account-cashlesses.index');
        Route::post(
            '/cashless-providers/{cashlessProvider}/account-cashlesses',
            [CashlessProviderAccountCashlessesController::class, 'store']
        )->name('cashless-providers.account-cashlesses.store');

        Route::apiResource('franchise-groups', FranchiseGroupController::class);

        // FranchiseGroup Products
        Route::get('/franchise-groups/{franchiseGroup}/products', [
            FranchiseGroupProductsController::class,
            'index',
        ])->name('franchise-groups.products.index');
        Route::post('/franchise-groups/{franchiseGroup}/products', [
            FranchiseGroupProductsController::class,
            'store',
        ])->name('franchise-groups.products.store');

        Route::apiResource('material-groups', MaterialGroupController::class);

        // MaterialGroup Products
        Route::get('/material-groups/{materialGroup}/products', [
            MaterialGroupProductsController::class,
            'index',
        ])->name('material-groups.products.index');
        Route::post('/material-groups/{materialGroup}/products', [
            MaterialGroupProductsController::class,
            'store',
        ])->name('material-groups.products.store');

        Route::apiResource('monthly-salaries', MonthlySalaryController::class);

        // MonthlySalary Presences
        Route::get('/monthly-salaries/{monthlySalary}/presences', [
            MonthlySalaryPresencesController::class,
            'index',
        ])->name('monthly-salaries.presences.index');
        Route::post('/monthly-salaries/{monthlySalary}/presences/{presence}', [
            MonthlySalaryPresencesController::class,
            'store',
        ])->name('monthly-salaries.presences.store');
        Route::delete(
            '/monthly-salaries/{monthlySalary}/presences/{presence}',
            [MonthlySalaryPresencesController::class, 'destroy']
        )->name('monthly-salaries.presences.destroy');

        Route::apiResource(
            'online-categories',
            OnlineCategoryController::class
        );

        // OnlineCategory Products
        Route::get('/online-categories/{onlineCategory}/products', [
            OnlineCategoryProductsController::class,
            'index',
        ])->name('online-categories.products.index');
        Route::post('/online-categories/{onlineCategory}/products', [
            OnlineCategoryProductsController::class,
            'store',
        ])->name('online-categories.products.store');

        // OnlineCategory E Products
        Route::get('/online-categories/{onlineCategory}/e-products', [
            OnlineCategoryEProductsController::class,
            'index',
        ])->name('online-categories.e-products.index');
        Route::post('/online-categories/{onlineCategory}/e-products', [
            OnlineCategoryEProductsController::class,
            'store',
        ])->name('online-categories.e-products.store');

        Route::apiResource(
            'online-shop-providers',
            OnlineShopProviderController::class
        );

        // OnlineShopProvider Sales Order Onlines
        Route::get(
            '/online-shop-providers/{onlineShopProvider}/sales-order-onlines',
            [OnlineShopProviderSalesOrderOnlinesController::class, 'index']
        )->name('online-shop-providers.sales-order-onlines.index');
        Route::post(
            '/online-shop-providers/{onlineShopProvider}/sales-order-onlines',
            [OnlineShopProviderSalesOrderOnlinesController::class, 'store']
        )->name('online-shop-providers.sales-order-onlines.store');

        Route::apiResource('payment-types', PaymentTypeController::class);

        // PaymentType Purchase Orders
        Route::get('/payment-types/{paymentType}/purchase-orders', [
            PaymentTypePurchaseOrdersController::class,
            'index',
        ])->name('payment-types.purchase-orders.index');
        Route::post('/payment-types/{paymentType}/purchase-orders', [
            PaymentTypePurchaseOrdersController::class,
            'store',
        ])->name('payment-types.purchase-orders.store');

        // PaymentType Products
        Route::get('/payment-types/{paymentType}/products', [
            PaymentTypeProductsController::class,
            'index',
        ])->name('payment-types.products.index');
        Route::post('/payment-types/{paymentType}/products', [
            PaymentTypeProductsController::class,
            'store',
        ])->name('payment-types.products.store');

        // PaymentType Fuel Services
        Route::get('/payment-types/{paymentType}/fuel-services', [
            PaymentTypeFuelServicesController::class,
            'index',
        ])->name('payment-types.fuel-services.index');
        Route::post('/payment-types/{paymentType}/fuel-services', [
            PaymentTypeFuelServicesController::class,
            'store',
        ])->name('payment-types.fuel-services.store');

        // PaymentType Invoice Purchases
        Route::get('/payment-types/{paymentType}/invoice-purchases', [
            PaymentTypeInvoicePurchasesController::class,
            'index',
        ])->name('payment-types.invoice-purchases.index');
        Route::post('/payment-types/{paymentType}/invoice-purchases', [
            PaymentTypeInvoicePurchasesController::class,
            'store',
        ])->name('payment-types.invoice-purchases.store');

        // PaymentType Detail Requests
        Route::get('/payment-types/{paymentType}/detail-requests', [
            PaymentTypeDetailRequestsController::class,
            'index',
        ])->name('payment-types.detail-requests.index');
        Route::post('/payment-types/{paymentType}/detail-requests', [
            PaymentTypeDetailRequestsController::class,
            'store',
        ])->name('payment-types.detail-requests.store');

        // PaymentType Daily Salaries
        Route::get('/payment-types/{paymentType}/daily-salaries', [
            PaymentTypeDailySalariesController::class,
            'index',
        ])->name('payment-types.daily-salaries.index');
        Route::post('/payment-types/{paymentType}/daily-salaries', [
            PaymentTypeDailySalariesController::class,
            'store',
        ])->name('payment-types.daily-salaries.store');

        Route::apiResource('permit-employees', PermitEmployeeController::class);

        Route::apiResource('product-groups', ProductGroupController::class);

        // ProductGroup Products
        Route::get('/product-groups/{productGroup}/products', [
            ProductGroupProductsController::class,
            'index',
        ])->name('product-groups.products.index');
        Route::post('/product-groups/{productGroup}/products', [
            ProductGroupProductsController::class,
            'store',
        ])->name('product-groups.products.store');

        Route::apiResource('transfer-stocks', TransferStockController::class);

        // TransferStock Products
        Route::get('/transfer-stocks/{transferStock}/products', [
            TransferStockProductsController::class,
            'index',
        ])->name('transfer-stocks.products.index');
        Route::post('/transfer-stocks/{transferStock}/products/{product}', [
            TransferStockProductsController::class,
            'store',
        ])->name('transfer-stocks.products.store');
        Route::delete('/transfer-stocks/{transferStock}/products/{product}', [
            TransferStockProductsController::class,
            'destroy',
        ])->name('transfer-stocks.products.destroy');

        Route::apiResource(
            'restaurant-categories',
            RestaurantCategoryController::class
        );

        // RestaurantCategory Products
        Route::get('/restaurant-categories/{restaurantCategory}/products', [
            RestaurantCategoryProductsController::class,
            'index',
        ])->name('restaurant-categories.products.index');
        Route::post('/restaurant-categories/{restaurantCategory}/products', [
            RestaurantCategoryProductsController::class,
            'store',
        ])->name('restaurant-categories.products.store');

        Route::apiResource(
            'sales-order-onlines',
            SalesOrderOnlineController::class
        );

        // SalesOrderOnline Products
        Route::get('/sales-order-onlines/{salesOrderOnline}/products', [
            SalesOrderOnlineProductsController::class,
            'index',
        ])->name('sales-order-onlines.products.index');
        Route::post(
            '/sales-order-onlines/{salesOrderOnline}/products/{product}',
            [SalesOrderOnlineProductsController::class, 'store']
        )->name('sales-order-onlines.products.store');
        Route::delete(
            '/sales-order-onlines/{salesOrderOnline}/products/{product}',
            [SalesOrderOnlineProductsController::class, 'destroy']
        )->name('sales-order-onlines.products.destroy');

        Route::apiResource('shift-stores', ShiftStoreController::class);

        // ShiftStore Closing Stores
        Route::get('/shift-stores/{shiftStore}/closing-stores', [
            ShiftStoreClosingStoresController::class,
            'index',
        ])->name('shift-stores.closing-stores.index');
        Route::post('/shift-stores/{shiftStore}/closing-stores', [
            ShiftStoreClosingStoresController::class,
            'store',
        ])->name('shift-stores.closing-stores.store');

        // ShiftStore Presences
        Route::get('/shift-stores/{shiftStore}/presences', [
            ShiftStorePresencesController::class,
            'index',
        ])->name('shift-stores.presences.index');
        Route::post('/shift-stores/{shiftStore}/presences', [
            ShiftStorePresencesController::class,
            'store',
        ])->name('shift-stores.presences.store');

        // ShiftStore Daily Salaries
        Route::get('/shift-stores/{shiftStore}/daily-salaries', [
            ShiftStoreDailySalariesController::class,
            'index',
        ])->name('shift-stores.daily-salaries.index');
        Route::post('/shift-stores/{shiftStore}/daily-salaries', [
            ShiftStoreDailySalariesController::class,
            'store',
        ])->name('shift-stores.daily-salaries.store');

        Route::apiResource('sops', SopController::class);

        Route::apiResource('products', ProductController::class);

        // Product Movement Assets
        Route::get('/products/{product}/movement-assets', [
            ProductMovementAssetsController::class,
            'index',
        ])->name('products.movement-assets.index');
        Route::post('/products/{product}/movement-assets', [
            ProductMovementAssetsController::class,
            'store',
        ])->name('products.movement-assets.store');

        // Product Purchase Order Products
        Route::get('/products/{product}/purchase-order-products', [
            ProductPurchaseOrderProductsController::class,
            'index',
        ])->name('products.purchase-order-products.index');
        Route::post('/products/{product}/purchase-order-products', [
            ProductPurchaseOrderProductsController::class,
            'store',
        ])->name('products.purchase-order-products.store');

        // Product Production Tos
        Route::get('/products/{product}/production-tos', [
            ProductProductionTosController::class,
            'index',
        ])->name('products.production-tos.index');
        Route::post('/products/{product}/production-tos', [
            ProductProductionTosController::class,
            'store',
        ])->name('products.production-tos.store');

        // Product Production Support Froms
        Route::get('/products/{product}/production-support-froms', [
            ProductProductionSupportFromsController::class,
            'index',
        ])->name('products.production-support-froms.index');
        Route::post('/products/{product}/production-support-froms', [
            ProductProductionSupportFromsController::class,
            'store',
        ])->name('products.production-support-froms.store');

        // Product E Products
        Route::get('/products/{product}/e-products', [
            ProductEProductsController::class,
            'index',
        ])->name('products.e-products.index');
        Route::post('/products/{product}/e-products', [
            ProductEProductsController::class,
            'store',
        ])->name('products.e-products.store');

        // Product Detail Requests
        Route::get('/products/{product}/detail-requests', [
            ProductDetailRequestsController::class,
            'index',
        ])->name('products.detail-requests.index');
        Route::post('/products/{product}/detail-requests', [
            ProductDetailRequestsController::class,
            'store',
        ])->name('products.detail-requests.store');

        // Product Remaining Stocks
        Route::get('/products/{product}/remaining-stocks', [
            ProductRemainingStocksController::class,
            'index',
        ])->name('products.remaining-stocks.index');
        Route::post('/products/{product}/remaining-stocks/{remainingStock}', [
            ProductRemainingStocksController::class,
            'store',
        ])->name('products.remaining-stocks.store');
        Route::delete('/products/{product}/remaining-stocks/{remainingStock}', [
            ProductRemainingStocksController::class,
            'destroy',
        ])->name('products.remaining-stocks.destroy');

        // Product Transfer Stocks
        Route::get('/products/{product}/transfer-stocks', [
            ProductTransferStocksController::class,
            'index',
        ])->name('products.transfer-stocks.index');
        Route::post('/products/{product}/transfer-stocks/{transferStock}', [
            ProductTransferStocksController::class,
            'store',
        ])->name('products.transfer-stocks.store');
        Route::delete('/products/{product}/transfer-stocks/{transferStock}', [
            ProductTransferStocksController::class,
            'destroy',
        ])->name('products.transfer-stocks.destroy');

        // Product Sales Order Employees
        Route::get('/products/{product}/sales-order-employees', [
            ProductSalesOrderEmployeesController::class,
            'index',
        ])->name('products.sales-order-employees.index');
        Route::post(
            '/products/{product}/sales-order-employees/{salesOrderEmployee}',
            [ProductSalesOrderEmployeesController::class, 'store']
        )->name('products.sales-order-employees.store');
        Route::delete(
            '/products/{product}/sales-order-employees/{salesOrderEmployee}',
            [ProductSalesOrderEmployeesController::class, 'destroy']
        )->name('products.sales-order-employees.destroy');

        // Product Sales Order Onlines
        Route::get('/products/{product}/sales-order-onlines', [
            ProductSalesOrderOnlinesController::class,
            'index',
        ])->name('products.sales-order-onlines.index');
        Route::post(
            '/products/{product}/sales-order-onlines/{salesOrderOnline}',
            [ProductSalesOrderOnlinesController::class, 'store']
        )->name('products.sales-order-onlines.store');
        Route::delete(
            '/products/{product}/sales-order-onlines/{salesOrderOnline}',
            [ProductSalesOrderOnlinesController::class, 'destroy']
        )->name('products.sales-order-onlines.destroy');

        // Product Self Consumptions
        Route::get('/products/{product}/self-consumptions', [
            ProductSelfConsumptionsController::class,
            'index',
        ])->name('products.self-consumptions.index');
        Route::post('/products/{product}/self-consumptions/{selfConsumption}', [
            ProductSelfConsumptionsController::class,
            'store',
        ])->name('products.self-consumptions.store');
        Route::delete(
            '/products/{product}/self-consumptions/{selfConsumption}',
            [ProductSelfConsumptionsController::class, 'destroy']
        )->name('products.self-consumptions.destroy');

        Route::apiResource('banks', BankController::class);

        // Bank Employees
        Route::get('/banks/{bank}/employees', [
            BankEmployeesController::class,
            'index',
        ])->name('banks.employees.index');
        Route::post('/banks/{bank}/employees', [
            BankEmployeesController::class,
            'store',
        ])->name('banks.employees.store');

        // Bank Suppliers
        Route::get('/banks/{bank}/suppliers', [
            BankSuppliersController::class,
            'index',
        ])->name('banks.suppliers.index');
        Route::post('/banks/{bank}/suppliers', [
            BankSuppliersController::class,
            'store',
        ])->name('banks.suppliers.store');

        // Bank Closing Couriers
        Route::get('/banks/{bank}/closing-couriers', [
            BankClosingCouriersController::class,
            'index',
        ])->name('banks.closing-couriers.index');
        Route::post('/banks/{bank}/closing-couriers', [
            BankClosingCouriersController::class,
            'store',
        ])->name('banks.closing-couriers.store');

        // Bank Transfer To Accounts
        Route::get('/banks/{bank}/transfer-to-accounts', [
            BankTransferToAccountsController::class,
            'index',
        ])->name('banks.transfer-to-accounts.index');
        Route::post('/banks/{bank}/transfer-to-accounts', [
            BankTransferToAccountsController::class,
            'store',
        ])->name('banks.transfer-to-accounts.store');

        Route::apiResource('productions', ProductionController::class);

        // Production Production Froms
        Route::get('/productions/{production}/production-froms', [
            ProductionProductionFromsController::class,
            'index',
        ])->name('productions.production-froms.index');
        Route::post('/productions/{production}/production-froms', [
            ProductionProductionFromsController::class,
            'store',
        ])->name('productions.production-froms.store');

        // Production Production Tos
        Route::get('/productions/{production}/production-tos', [
            ProductionProductionTosController::class,
            'index',
        ])->name('productions.production-tos.index');
        Route::post('/productions/{production}/production-tos', [
            ProductionProductionTosController::class,
            'store',
        ])->name('productions.production-tos.store');

        // Production Production Support Froms
        Route::get('/productions/{production}/production-support-froms', [
            ProductionProductionSupportFromsController::class,
            'index',
        ])->name('productions.production-support-froms.index');
        Route::post('/productions/{production}/production-support-froms', [
            ProductionProductionSupportFromsController::class,
            'store',
        ])->name('productions.production-support-froms.store');

        // Production Production Main Froms
        Route::get('/productions/{production}/production-main-froms', [
            ProductionProductionMainFromsController::class,
            'index',
        ])->name('productions.production-main-froms.index');
        Route::post('/productions/{production}/production-main-froms', [
            ProductionProductionMainFromsController::class,
            'store',
        ])->name('productions.production-main-froms.store');

        Route::apiResource('purchase-orders', PurchaseOrderController::class);

        // PurchaseOrder Closing Stores
        Route::get('/purchase-orders/{purchaseOrder}/closing-stores', [
            PurchaseOrderClosingStoresController::class,
            'index',
        ])->name('purchase-orders.closing-stores.index');
        Route::post(
            '/purchase-orders/{purchaseOrder}/closing-stores/{closingStore}',
            [PurchaseOrderClosingStoresController::class, 'store']
        )->name('purchase-orders.closing-stores.store');
        Route::delete(
            '/purchase-orders/{purchaseOrder}/closing-stores/{closingStore}',
            [PurchaseOrderClosingStoresController::class, 'destroy']
        )->name('purchase-orders.closing-stores.destroy');

        // PurchaseOrder Purchase Receipts
        Route::get('/purchase-orders/{purchaseOrder}/purchase-receipts', [
            PurchaseOrderPurchaseReceiptsController::class,
            'index',
        ])->name('purchase-orders.purchase-receipts.index');
        Route::post(
            '/purchase-orders/{purchaseOrder}/purchase-receipts/{purchaseReceipt}',
            [PurchaseOrderPurchaseReceiptsController::class, 'store']
        )->name('purchase-orders.purchase-receipts.store');
        Route::delete(
            '/purchase-orders/{purchaseOrder}/purchase-receipts/{purchaseReceipt}',
            [PurchaseOrderPurchaseReceiptsController::class, 'destroy']
        )->name('purchase-orders.purchase-receipts.destroy');

        Route::apiResource('utilities', UtilityController::class);

        // Utility Utility Usages
        Route::get('/utilities/{utility}/utility-usages', [
            UtilityUtilityUsagesController::class,
            'index',
        ])->name('utilities.utility-usages.index');
        Route::post('/utilities/{utility}/utility-usages', [
            UtilityUtilityUsagesController::class,
            'store',
        ])->name('utilities.utility-usages.store');

        // Utility Utility Bills
        Route::get('/utilities/{utility}/utility-bills', [
            UtilityUtilityBillsController::class,
            'index',
        ])->name('utilities.utility-bills.index');
        Route::post('/utilities/{utility}/utility-bills', [
            UtilityUtilityBillsController::class,
            'store',
        ])->name('utilities.utility-bills.store');

        Route::apiResource('units', UnitController::class);

        // Unit Products
        Route::get('/units/{unit}/products', [
            UnitProductsController::class,
            'index',
        ])->name('units.products.index');
        Route::post('/units/{unit}/products', [
            UnitProductsController::class,
            'store',
        ])->name('units.products.store');

        // Unit Utilities
        Route::get('/units/{unit}/utilities', [
            UnitUtilitiesController::class,
            'index',
        ])->name('units.utilities.index');
        Route::post('/units/{unit}/utilities', [
            UnitUtilitiesController::class,
            'store',
        ])->name('units.utilities.store');

        // Unit Purchase Order Products
        Route::get('/units/{unit}/purchase-order-products', [
            UnitPurchaseOrderProductsController::class,
            'index',
        ])->name('units.purchase-order-products.index');
        Route::post('/units/{unit}/purchase-order-products', [
            UnitPurchaseOrderProductsController::class,
            'store',
        ])->name('units.purchase-order-products.store');

        // Unit Detail Invoices
        Route::get('/units/{unit}/detail-invoices', [
            UnitDetailInvoicesController::class,
            'index',
        ])->name('units.detail-invoices.index');
        Route::post('/units/{unit}/detail-invoices', [
            UnitDetailInvoicesController::class,
            'store',
        ])->name('units.detail-invoices.store');

        Route::apiResource(
            'receipt-by-item-loyverses',
            ReceiptByItemLoyverseController::class
        );

        Route::apiResource(
            'receipt-loyverses',
            ReceiptLoyverseController::class
        );

        Route::apiResource('hygienes', HygieneController::class);

        // Hygiene Hygiene Of Rooms
        Route::get('/hygienes/{hygiene}/hygiene-of-rooms', [
            HygieneHygieneOfRoomsController::class,
            'index',
        ])->name('hygienes.hygiene-of-rooms.index');
        Route::post('/hygienes/{hygiene}/hygiene-of-rooms', [
            HygieneHygieneOfRoomsController::class,
            'store',
        ])->name('hygienes.hygiene-of-rooms.store');

        Route::apiResource('clean-and-neats', CleanAndNeatController::class);

        Route::apiResource(
            'utility-providers',
            UtilityProviderController::class
        );

        // UtilityProvider Utilities
        Route::get('/utility-providers/{utilityProvider}/utilities', [
            UtilityProviderUtilitiesController::class,
            'index',
        ])->name('utility-providers.utilities.index');
        Route::post('/utility-providers/{utilityProvider}/utilities', [
            UtilityProviderUtilitiesController::class,
            'store',
        ])->name('utility-providers.utilities.store');

        Route::apiResource(
            'self-consumptions',
            SelfConsumptionController::class
        );

        // SelfConsumption Products
        Route::get('/self-consumptions/{selfConsumption}/products', [
            SelfConsumptionProductsController::class,
            'index',
        ])->name('self-consumptions.products.index');
        Route::post('/self-consumptions/{selfConsumption}/products/{product}', [
            SelfConsumptionProductsController::class,
            'store',
        ])->name('self-consumptions.products.store');
        Route::delete(
            '/self-consumptions/{selfConsumption}/products/{product}',
            [SelfConsumptionProductsController::class, 'destroy']
        )->name('self-consumptions.products.destroy');

        Route::apiResource('rooms', RoomController::class);

        // Room Hygiene Of Rooms
        Route::get('/rooms/{room}/hygiene-of-rooms', [
            RoomHygieneOfRoomsController::class,
            'index',
        ])->name('rooms.hygiene-of-rooms.index');
        Route::post('/rooms/{room}/hygiene-of-rooms', [
            RoomHygieneOfRoomsController::class,
            'store',
        ])->name('rooms.hygiene-of-rooms.store');

        Route::apiResource(
            'employee-statuses',
            EmployeeStatusController::class
        );

        // EmployeeStatus Employees
        Route::get('/employee-statuses/{employeeStatus}/employees', [
            EmployeeStatusEmployeesController::class,
            'index',
        ])->name('employee-statuses.employees.index');
        Route::post('/employee-statuses/{employeeStatus}/employees', [
            EmployeeStatusEmployeesController::class,
            'store',
        ])->name('employee-statuses.employees.store');

        Route::apiResource('refunds', RefundController::class);

        Route::apiResource('utility-usages', UtilityUsageController::class);

        Route::apiResource('vehicle-taxes', VehicleTaxController::class);

        Route::apiResource(
            'vehicle-certificates',
            VehicleCertificateController::class
        );

        Route::apiResource(
            'movement-asset-results',
            MovementAssetResultController::class
        );

        // MovementAssetResult Movement Asset Audits
        Route::get(
            '/movement-asset-results/{movementAssetResult}/movement-asset-audits',
            [MovementAssetResultMovementAssetAuditsController::class, 'index']
        )->name('movement-asset-results.movement-asset-audits.index');
        Route::post(
            '/movement-asset-results/{movementAssetResult}/movement-asset-audits',
            [MovementAssetResultMovementAssetAuditsController::class, 'store']
        )->name('movement-asset-results.movement-asset-audits.store');

        Route::apiResource('store-assets', StoreAssetController::class);

        // StoreAsset Movement Assets
        Route::get('/store-assets/{storeAsset}/movement-assets', [
            StoreAssetMovementAssetsController::class,
            'index',
        ])->name('store-assets.movement-assets.index');
        Route::post('/store-assets/{storeAsset}/movement-assets', [
            StoreAssetMovementAssetsController::class,
            'store',
        ])->name('store-assets.movement-assets.store');

        Route::apiResource('admin-cashlesses', AdminCashlessController::class);

        // AdminCashless Account Cashlesses
        Route::get('/admin-cashlesses/{adminCashless}/account-cashlesses', [
            AdminCashlessAccountCashlessesController::class,
            'index',
        ])->name('admin-cashlesses.account-cashlesses.index');
        Route::post(
            '/admin-cashlesses/{adminCashless}/account-cashlesses/{accountCashless}',
            [AdminCashlessAccountCashlessesController::class, 'store']
        )->name('admin-cashlesses.account-cashlesses.store');
        Route::delete(
            '/admin-cashlesses/{adminCashless}/account-cashlesses/{accountCashless}',
            [AdminCashlessAccountCashlessesController::class, 'destroy']
        )->name('admin-cashlesses.account-cashlesses.destroy');

        Route::apiResource(
            'purchase-receipts',
            PurchaseReceiptController::class
        );

        // PurchaseReceipt Purchase Orders
        Route::get('/purchase-receipts/{purchaseReceipt}/purchase-orders', [
            PurchaseReceiptPurchaseOrdersController::class,
            'index',
        ])->name('purchase-receipts.purchase-orders.index');
        Route::post(
            '/purchase-receipts/{purchaseReceipt}/purchase-orders/{purchaseOrder}',
            [PurchaseReceiptPurchaseOrdersController::class, 'store']
        )->name('purchase-receipts.purchase-orders.store');
        Route::delete(
            '/purchase-receipts/{purchaseReceipt}/purchase-orders/{purchaseOrder}',
            [PurchaseReceiptPurchaseOrdersController::class, 'destroy']
        )->name('purchase-receipts.purchase-orders.destroy');

        Route::apiResource('closing-stores', ClosingStoreController::class);

        // ClosingStore Cashlesses
        Route::get('/closing-stores/{closingStore}/cashlesses', [
            ClosingStoreCashlessesController::class,
            'index',
        ])->name('closing-stores.cashlesses.index');
        Route::post('/closing-stores/{closingStore}/cashlesses', [
            ClosingStoreCashlessesController::class,
            'store',
        ])->name('closing-stores.cashlesses.store');

        // ClosingStore Closing Couriers
        Route::get('/closing-stores/{closingStore}/closing-couriers', [
            ClosingStoreClosingCouriersController::class,
            'index',
        ])->name('closing-stores.closing-couriers.index');
        Route::post(
            '/closing-stores/{closingStore}/closing-couriers/{closingCourier}',
            [ClosingStoreClosingCouriersController::class, 'store']
        )->name('closing-stores.closing-couriers.store');
        Route::delete(
            '/closing-stores/{closingStore}/closing-couriers/{closingCourier}',
            [ClosingStoreClosingCouriersController::class, 'destroy']
        )->name('closing-stores.closing-couriers.destroy');

        // ClosingStore Purchase Orders
        Route::get('/closing-stores/{closingStore}/purchase-orders', [
            ClosingStorePurchaseOrdersController::class,
            'index',
        ])->name('closing-stores.purchase-orders.index');
        Route::post(
            '/closing-stores/{closingStore}/purchase-orders/{purchaseOrder}',
            [ClosingStorePurchaseOrdersController::class, 'store']
        )->name('closing-stores.purchase-orders.store');
        Route::delete(
            '/closing-stores/{closingStore}/purchase-orders/{purchaseOrder}',
            [ClosingStorePurchaseOrdersController::class, 'destroy']
        )->name('closing-stores.purchase-orders.destroy');

        // ClosingStore Invoice Purchases
        Route::get('/closing-stores/{closingStore}/invoice-purchases', [
            ClosingStoreInvoicePurchasesController::class,
            'index',
        ])->name('closing-stores.invoice-purchases.index');
        Route::post(
            '/closing-stores/{closingStore}/invoice-purchases/{invoicePurchase}',
            [ClosingStoreInvoicePurchasesController::class, 'store']
        )->name('closing-stores.invoice-purchases.store');
        Route::delete(
            '/closing-stores/{closingStore}/invoice-purchases/{invoicePurchase}',
            [ClosingStoreInvoicePurchasesController::class, 'destroy']
        )->name('closing-stores.invoice-purchases.destroy');

        // ClosingStore Fuel Services
        Route::get('/closing-stores/{closingStore}/fuel-services', [
            ClosingStoreFuelServicesController::class,
            'index',
        ])->name('closing-stores.fuel-services.index');
        Route::post(
            '/closing-stores/{closingStore}/fuel-services/{fuelService}',
            [ClosingStoreFuelServicesController::class, 'store']
        )->name('closing-stores.fuel-services.store');
        Route::delete(
            '/closing-stores/{closingStore}/fuel-services/{fuelService}',
            [ClosingStoreFuelServicesController::class, 'destroy']
        )->name('closing-stores.fuel-services.destroy');

        // ClosingStore Daily Salaries
        Route::get('/closing-stores/{closingStore}/daily-salaries', [
            ClosingStoreDailySalariesController::class,
            'index',
        ])->name('closing-stores.daily-salaries.index');
        Route::post(
            '/closing-stores/{closingStore}/daily-salaries/{dailySalary}',
            [ClosingStoreDailySalariesController::class, 'store']
        )->name('closing-stores.daily-salaries.store');
        Route::delete(
            '/closing-stores/{closingStore}/daily-salaries/{dailySalary}',
            [ClosingStoreDailySalariesController::class, 'destroy']
        )->name('closing-stores.daily-salaries.destroy');

        Route::apiResource('store-cashlesses', StoreCashlessController::class);

        // StoreCashless Account Cashlesses
        Route::get('/store-cashlesses/{storeCashless}/account-cashlesses', [
            StoreCashlessAccountCashlessesController::class,
            'index',
        ])->name('store-cashlesses.account-cashlesses.index');
        Route::post('/store-cashlesses/{storeCashless}/account-cashlesses', [
            StoreCashlessAccountCashlessesController::class,
            'store',
        ])->name('store-cashlesses.account-cashlesses.store');

        Route::apiResource(
            'account-cashlesses',
            AccountCashlessController::class
        );

        // AccountCashless Cashlesses
        Route::get('/account-cashlesses/{accountCashless}/cashlesses', [
            AccountCashlessCashlessesController::class,
            'index',
        ])->name('account-cashlesses.cashlesses.index');
        Route::post('/account-cashlesses/{accountCashless}/cashlesses', [
            AccountCashlessCashlessesController::class,
            'store',
        ])->name('account-cashlesses.cashlesses.store');

        // AccountCashless Admin Cashlesses
        Route::get('/account-cashlesses/{accountCashless}/admin-cashlesses', [
            AccountCashlessAdminCashlessesController::class,
            'index',
        ])->name('account-cashlesses.admin-cashlesses.index');
        Route::post(
            '/account-cashlesses/{accountCashless}/admin-cashlesses/{adminCashless}',
            [AccountCashlessAdminCashlessesController::class, 'store']
        )->name('account-cashlesses.admin-cashlesses.store');
        Route::delete(
            '/account-cashlesses/{accountCashless}/admin-cashlesses/{adminCashless}',
            [AccountCashlessAdminCashlessesController::class, 'destroy']
        )->name('account-cashlesses.admin-cashlesses.destroy');

        Route::apiResource(
            'delivery-services',
            DeliveryServiceController::class
        );

        // DeliveryService Sales Order Onlines
        Route::get('/delivery-services/{deliveryService}/sales-order-onlines', [
            DeliveryServiceSalesOrderOnlinesController::class,
            'index',
        ])->name('delivery-services.sales-order-onlines.index');
        Route::post(
            '/delivery-services/{deliveryService}/sales-order-onlines',
            [DeliveryServiceSalesOrderOnlinesController::class, 'store']
        )->name('delivery-services.sales-order-onlines.store');

        // DeliveryService Sales Order Directs
        Route::get('/delivery-services/{deliveryService}/sales-order-directs', [
            DeliveryServiceSalesOrderDirectsController::class,
            'index',
        ])->name('delivery-services.sales-order-directs.index');
        Route::post(
            '/delivery-services/{deliveryService}/sales-order-directs',
            [DeliveryServiceSalesOrderDirectsController::class, 'store']
        )->name('delivery-services.sales-order-directs.store');

        Route::apiResource('utility-bills', UtilityBillController::class);

        Route::apiResource('carts', CartController::class);

        Route::apiResource('payment-receipts', PaymentReceiptController::class);

        // PaymentReceipt Fuel Services
        Route::get('/payment-receipts/{paymentReceipt}/fuel-services', [
            PaymentReceiptFuelServicesController::class,
            'index',
        ])->name('payment-receipts.fuel-services.index');
        Route::post(
            '/payment-receipts/{paymentReceipt}/fuel-services/{fuelService}',
            [PaymentReceiptFuelServicesController::class, 'store']
        )->name('payment-receipts.fuel-services.store');
        Route::delete(
            '/payment-receipts/{paymentReceipt}/fuel-services/{fuelService}',
            [PaymentReceiptFuelServicesController::class, 'destroy']
        )->name('payment-receipts.fuel-services.destroy');

        // PaymentReceipt Invoice Purchases
        Route::get('/payment-receipts/{paymentReceipt}/invoice-purchases', [
            PaymentReceiptInvoicePurchasesController::class,
            'index',
        ])->name('payment-receipts.invoice-purchases.index');
        Route::post(
            '/payment-receipts/{paymentReceipt}/invoice-purchases/{invoicePurchase}',
            [PaymentReceiptInvoicePurchasesController::class, 'store']
        )->name('payment-receipts.invoice-purchases.store');
        Route::delete(
            '/payment-receipts/{paymentReceipt}/invoice-purchases/{invoicePurchase}',
            [PaymentReceiptInvoicePurchasesController::class, 'destroy']
        )->name('payment-receipts.invoice-purchases.destroy');

        // PaymentReceipt Daily Salaries
        Route::get('/payment-receipts/{paymentReceipt}/daily-salaries', [
            PaymentReceiptDailySalariesController::class,
            'index',
        ])->name('payment-receipts.daily-salaries.index');
        Route::post(
            '/payment-receipts/{paymentReceipt}/daily-salaries/{dailySalary}',
            [PaymentReceiptDailySalariesController::class, 'store']
        )->name('payment-receipts.daily-salaries.store');
        Route::delete(
            '/payment-receipts/{paymentReceipt}/daily-salaries/{dailySalary}',
            [PaymentReceiptDailySalariesController::class, 'destroy']
        )->name('payment-receipts.daily-salaries.destroy');

        Route::apiResource(
            'request-purchases',
            RequestPurchaseController::class
        );

        // RequestPurchase Detail Requests
        Route::get('/request-purchases/{requestPurchase}/detail-requests', [
            RequestPurchaseDetailRequestsController::class,
            'index',
        ])->name('request-purchases.detail-requests.index');
        Route::post('/request-purchases/{requestPurchase}/detail-requests', [
            RequestPurchaseDetailRequestsController::class,
            'store',
        ])->name('request-purchases.detail-requests.store');

        Route::apiResource(
            'invoice-purchases',
            InvoicePurchaseController::class
        );

        // InvoicePurchase Detail Invoices
        Route::get('/invoice-purchases/{invoicePurchase}/detail-invoices', [
            InvoicePurchaseDetailInvoicesController::class,
            'index',
        ])->name('invoice-purchases.detail-invoices.index');
        Route::post('/invoice-purchases/{invoicePurchase}/detail-invoices', [
            InvoicePurchaseDetailInvoicesController::class,
            'store',
        ])->name('invoice-purchases.detail-invoices.store');

        // InvoicePurchase Payment Receipts
        Route::get('/invoice-purchases/{invoicePurchase}/payment-receipts', [
            InvoicePurchasePaymentReceiptsController::class,
            'index',
        ])->name('invoice-purchases.payment-receipts.index');
        Route::post(
            '/invoice-purchases/{invoicePurchase}/payment-receipts/{paymentReceipt}',
            [InvoicePurchasePaymentReceiptsController::class, 'store']
        )->name('invoice-purchases.payment-receipts.store');
        Route::delete(
            '/invoice-purchases/{invoicePurchase}/payment-receipts/{paymentReceipt}',
            [InvoicePurchasePaymentReceiptsController::class, 'destroy']
        )->name('invoice-purchases.payment-receipts.destroy');

        // InvoicePurchase Closing Stores
        Route::get('/invoice-purchases/{invoicePurchase}/closing-stores', [
            InvoicePurchaseClosingStoresController::class,
            'index',
        ])->name('invoice-purchases.closing-stores.index');
        Route::post(
            '/invoice-purchases/{invoicePurchase}/closing-stores/{closingStore}',
            [InvoicePurchaseClosingStoresController::class, 'store']
        )->name('invoice-purchases.closing-stores.store');
        Route::delete(
            '/invoice-purchases/{invoicePurchase}/closing-stores/{closingStore}',
            [InvoicePurchaseClosingStoresController::class, 'destroy']
        )->name('invoice-purchases.closing-stores.destroy');

        Route::apiResource('fuel-services', FuelServiceController::class);

        // FuelService Payment Receipts
        Route::get('/fuel-services/{fuelService}/payment-receipts', [
            FuelServicePaymentReceiptsController::class,
            'index',
        ])->name('fuel-services.payment-receipts.index');
        Route::post(
            '/fuel-services/{fuelService}/payment-receipts/{paymentReceipt}',
            [FuelServicePaymentReceiptsController::class, 'store']
        )->name('fuel-services.payment-receipts.store');
        Route::delete(
            '/fuel-services/{fuelService}/payment-receipts/{paymentReceipt}',
            [FuelServicePaymentReceiptsController::class, 'destroy']
        )->name('fuel-services.payment-receipts.destroy');

        // FuelService Closing Stores
        Route::get('/fuel-services/{fuelService}/closing-stores', [
            FuelServiceClosingStoresController::class,
            'index',
        ])->name('fuel-services.closing-stores.index');
        Route::post(
            '/fuel-services/{fuelService}/closing-stores/{closingStore}',
            [FuelServiceClosingStoresController::class, 'store']
        )->name('fuel-services.closing-stores.store');
        Route::delete(
            '/fuel-services/{fuelService}/closing-stores/{closingStore}',
            [FuelServiceClosingStoresController::class, 'destroy']
        )->name('fuel-services.closing-stores.destroy');

        Route::apiResource('e-products', EProductController::class);

        // EProduct Carts
        Route::get('/e-products/{eProduct}/carts', [
            EProductCartsController::class,
            'index',
        ])->name('e-products.carts.index');
        Route::post('/e-products/{eProduct}/carts', [
            EProductCartsController::class,
            'store',
        ])->name('e-products.carts.store');

        // EProduct Sales Order Direct Products
        Route::get('/e-products/{eProduct}/sales-order-direct-products', [
            EProductSalesOrderDirectProductsController::class,
            'index',
        ])->name('e-products.sales-order-direct-products.index');
        Route::post('/e-products/{eProduct}/sales-order-direct-products', [
            EProductSalesOrderDirectProductsController::class,
            'store',
        ])->name('e-products.sales-order-direct-products.store');

        Route::apiResource('daily-salaries', DailySalaryController::class);

        // DailySalary Closing Stores
        Route::get('/daily-salaries/{dailySalary}/closing-stores', [
            DailySalaryClosingStoresController::class,
            'index',
        ])->name('daily-salaries.closing-stores.index');
        Route::post(
            '/daily-salaries/{dailySalary}/closing-stores/{closingStore}',
            [DailySalaryClosingStoresController::class, 'store']
        )->name('daily-salaries.closing-stores.store');
        Route::delete(
            '/daily-salaries/{dailySalary}/closing-stores/{closingStore}',
            [DailySalaryClosingStoresController::class, 'destroy']
        )->name('daily-salaries.closing-stores.destroy');

        // DailySalary Payment Receipts
        Route::get('/daily-salaries/{dailySalary}/payment-receipts', [
            DailySalaryPaymentReceiptsController::class,
            'index',
        ])->name('daily-salaries.payment-receipts.index');
        Route::post(
            '/daily-salaries/{dailySalary}/payment-receipts/{paymentReceipt}',
            [DailySalaryPaymentReceiptsController::class, 'store']
        )->name('daily-salaries.payment-receipts.store');
        Route::delete(
            '/daily-salaries/{dailySalary}/payment-receipts/{paymentReceipt}',
            [DailySalaryPaymentReceiptsController::class, 'destroy']
        )->name('daily-salaries.payment-receipts.destroy');

        Route::apiResource(
            'sales-order-employees',
            SalesOrderEmployeeController::class
        );

        // SalesOrderEmployee Products
        Route::get('/sales-order-employees/{salesOrderEmployee}/products', [
            SalesOrderEmployeeProductsController::class,
            'index',
        ])->name('sales-order-employees.products.index');
        Route::post(
            '/sales-order-employees/{salesOrderEmployee}/products/{product}',
            [SalesOrderEmployeeProductsController::class, 'store']
        )->name('sales-order-employees.products.store');
        Route::delete(
            '/sales-order-employees/{salesOrderEmployee}/products/{product}',
            [SalesOrderEmployeeProductsController::class, 'destroy']
        )->name('sales-order-employees.products.destroy');

        Route::apiResource(
            'transfer-to-accounts',
            TransferToAccountController::class
        );

        // TransferToAccount Sales Order Directs
        Route::get(
            '/transfer-to-accounts/{transferToAccount}/sales-order-directs',
            [TransferToAccountSalesOrderDirectsController::class, 'index']
        )->name('transfer-to-accounts.sales-order-directs.index');
        Route::post(
            '/transfer-to-accounts/{transferToAccount}/sales-order-directs',
            [TransferToAccountSalesOrderDirectsController::class, 'store']
        )->name('transfer-to-accounts.sales-order-directs.store');

        Route::apiResource(
            'sales-order-directs',
            SalesOrderDirectController::class
        );

        // SalesOrderDirect Sales Order Direct Products
        Route::get(
            '/sales-order-directs/{salesOrderDirect}/sales-order-direct-products',
            [SalesOrderDirectSalesOrderDirectProductsController::class, 'index']
        )->name('sales-order-directs.sales-order-direct-products.index');
        Route::post(
            '/sales-order-directs/{salesOrderDirect}/sales-order-direct-products',
            [SalesOrderDirectSalesOrderDirectProductsController::class, 'store']
        )->name('sales-order-directs.sales-order-direct-products.store');

        Route::apiResource(
            'delivery-locations',
            DeliveryLocationController::class
        );

        // DeliveryLocation Sales Order Directs
        Route::get(
            '/delivery-locations/{deliveryLocation}/sales-order-directs',
            [DeliveryLocationSalesOrderDirectsController::class, 'index']
        )->name('delivery-locations.sales-order-directs.index');
        Route::post(
            '/delivery-locations/{deliveryLocation}/sales-order-directs',
            [DeliveryLocationSalesOrderDirectsController::class, 'store']
        )->name('delivery-locations.sales-order-directs.store');

        Route::apiResource('coupons', CouponController::class);

        // Coupon Sales Order Directs
        Route::get('/coupons/{coupon}/sales-order-directs', [
            CouponSalesOrderDirectsController::class,
            'index',
        ])->name('coupons.sales-order-directs.index');
        Route::post('/coupons/{coupon}/sales-order-directs', [
            CouponSalesOrderDirectsController::class,
            'store',
        ])->name('coupons.sales-order-directs.store');

        Route::apiResource('presences', PresenceController::class);

        // Presence Monthly Salaries
        Route::get('/presences/{presence}/monthly-salaries', [
            PresenceMonthlySalariesController::class,
            'index',
        ])->name('presences.monthly-salaries.index');
        Route::post('/presences/{presence}/monthly-salaries/{monthlySalary}', [
            PresenceMonthlySalariesController::class,
            'store',
        ])->name('presences.monthly-salaries.store');
        Route::delete(
            '/presences/{presence}/monthly-salaries/{monthlySalary}',
            [PresenceMonthlySalariesController::class, 'destroy']
        )->name('presences.monthly-salaries.destroy');

        // API route for logout user
        // Route::post('/logout', [App\Http\Controllers\API\AuthController::class, 'logout']);
        Route::get('/get-presence',  [PresenceController::class, 'getPresences']);
        Route::post('save-presence', [PresenceController::class, 'savePresence']);
    });
