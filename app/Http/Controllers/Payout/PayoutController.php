<?php

namespace App\Http\Controllers\Payout;

use App\Http\Controllers\Controller;


class PayoutController extends Controller
{   
    public function __invoke()
    {
        return view('payout.index');
    }
    
}
