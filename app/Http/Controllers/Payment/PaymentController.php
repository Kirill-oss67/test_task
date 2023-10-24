<?php
namespace App\Http\Controllers\Payment;

use App\Http\Controllers\Controller;



class PaymentController extends Controller{
    public function __invoke()
    {
        return view('payment.index');
    }
}

