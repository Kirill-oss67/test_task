<?php

use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/


Route::get('/', function () {
    return 'welcome';
});

Route::group(['namespace' => 'Payment'], function () {
    Route::get('/payment/create', 'PaymentController')->name('payment.index');
    Route::post('/payment', 'CreatePaymentController')->name('payment.create');
});
Route::group(['namespace' => 'Payout'], function () {
    Route::get('payout/create', 'PayoutController')->name('payout.index');
    Route::post('payout', 'CreatePayoutController')->name('payout.create');
});

Route::get('/status', 'Status\UpdateStatusController')->name('get.status');
Route::get('/balance', 'Balance\GetBalanceController')->name('get.balance');

