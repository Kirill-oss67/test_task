<?php

namespace App\Http\Controllers\Payout;

use App\Http\Controllers\Controller;
use App\Services\Payout\Service;

class BaseController extends Controller
{
    public $service;
    public function __construct(Service $service)
    {
        $this->service = $service;
    }
}