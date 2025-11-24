<?php

use Madarit\LaravelKashier\Http\Controllers\PaymentController;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Kashier Payment Routes
|--------------------------------------------------------------------------
|
| These routes are automatically loaded by the package service provider
|
*/

Route::prefix('kashier')->name('kashier.payment.')->group(function () {
    Route::get('/checkout', [PaymentController::class, 'checkout'])->name('checkout');
    Route::get('/iframe/callback', [PaymentController::class, 'iframeCallback'])->name('iframe.callback');
    Route::get('/hpp/callback', [PaymentController::class, 'hppCallback'])->name('hpp.callback');
});
