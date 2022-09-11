<?php

use App\Http\Livewire\EProducts\EProductShow;
use Illuminate\Support\Facades\Route;

Route::prefix('/')
    ->middleware(['auth:sanctum', 'verified'])
    ->group(function () {
        Route::get('e-products/{e-products}', EProductShow::class)->name('e-products.show');
    });
