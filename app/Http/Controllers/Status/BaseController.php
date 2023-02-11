<?php

namespace App\Http\Controllers\Status;

use App\Http\Controllers\Controller;
use App\Services\Status\Service;

class BaseController extends Controller
{
    public $service;
    public function __construct(Service $service)
    {
        $this->service = $service;
    }
}
