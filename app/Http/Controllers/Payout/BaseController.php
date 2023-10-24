<?php

namespace App\Http\Controllers\Payout;

use App\Http\Controllers\Controller;
use App\Services\Payout\PayoutService;

class BaseController extends Controller
{
    public $service;
    public function __construct(PayoutService $service)
    {
        $this->service = $service;
    }
}
