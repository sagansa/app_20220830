<?php

// use App\Http\Livewire\EProducts\EProductShow;

use App\Http\Livewire\DetailInvoices\CheckProductions;
use App\Http\Livewire\DetailInvoices\UnitPricePurchases;
use App\Http\Livewire\DetailRequests\CheckProductRequests;
use App\Http\Livewire\RequestPurchases\RequestPurchaseApprovals;
use Illuminate\Support\Facades\Route;


Route::prefix('/')
    ->middleware(['auth:sanctum', 'verified'])
    ->group(function () {
        Route::get('check-productions', CheckProductions::class)->name('check-productions');
        Route::get('unit-price-purchases', UnitPricePurchases::class)->name('unit-price-purchases');
        Route::get('check-product-requests', CheckProductRequests::class)->name('check-product-requests');
        Route::get('request-purchase-approvals', RequestPurchaseApprovals::class)->name('request-purchase-approvals');

        // Route::get('e-products/{e-products}', EProductShow::class)->name('e-products.show');
    });



