<?php

use Illuminate\Support\Facades\Route;


Route::get('/', function () {
    return 'Welcome to project!!!';
});
Route::namespace('Payment')->group(function () {
    Route::get('/payment/create', 'PaymentController')->name('payment.index');
    Route::post('/payment', 'CreatePaymentController')->name('payment.create');
});
Route::namespace('Payout')->group(function () {
    Route::get('payout/create', 'PayoutController')->name('payout.index');
    Route::post('payout', 'CreatePayoutController')->name('payout.create');
});

Route::get('/status', 'Status\UpdateStatusController')->name('get.status');
Route::get('/balance', 'Balance\GetBalanceController')->name('get.balance');

