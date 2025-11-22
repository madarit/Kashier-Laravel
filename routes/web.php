<?php

use App\Http\Controllers\PaymentController;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Kashier Payment Routes
|--------------------------------------------------------------------------
|
| Add these routes to your existing routes/web.php file
|
*/

Route::prefix('payment')->name('payment.')->group(function () {
    Route::get('/checkout', [PaymentController::class, 'checkout'])->name('checkout');
    Route::get('/iframe/callback', [PaymentController::class, 'iframeCallback'])->name('iframe.callback');
    Route::get('/hpp/callback', [PaymentController::class, 'hppCallback'])->name('hpp.callback');
});
