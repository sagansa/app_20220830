<?php

use App\Http\Livewire\EProducts\EProductShow;

use App\Http\Livewire\DetailInvoices\CheckProductions;
use App\Http\Livewire\DetailInvoices\UnitPricePurchases;
use App\Http\Livewire\DetailRequests\RequestPurchaseApprovals;
use Illuminate\Support\Facades\Route;


Route::prefix('/')
    ->middleware(['auth:sanctum', 'verified'])
    ->group(function () {
        Route::get('check-productions', CheckProductions::class)->name('check-productions');
        Route::get('unit-price-purchases', UnitPricePurchases::class)->name('unit-price-purchases');
        Route::get('request-purchase-approvals', RequestPurchaseApprovals::class)->name('request-purchase-approvals');

        Route::get('e-products/{e-product}', EProductShow::class)->name('e-products.detail');

        // Route::get('sales-order-onlines', SalesOrderOnlinesList::class)->name('sales-order-onlines.index');
        // Route::get('sales-order-onlines/create', SalesOrderOnlineForm::class)->name('sales-order-onlines.create');
        // Route::get('sales-order-onlines/{salesOrderOnline}', SalesOrderOnlineForm::class)->name('sales-order-onlines.edit');

    });



