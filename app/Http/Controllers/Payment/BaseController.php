<?php

namespace App\Http\Controllers\Payment;

use App\Http\Controllers\Controller;
use App\Services\Payment\Service;

class BaseController extends Controller
{
    public $service;
    public function __construct(Service $service)
    {
        $this->service = $service;
    }
}
