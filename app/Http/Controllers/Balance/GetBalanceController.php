<?php

namespace App\Http\Controllers\Balance;

use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Http;

class GetBalanceController extends Controller
{
    public function __invoke()
    {
        return Http::withoutVerifying()->withHeaders(['auth' => $_ENV['API_KEY']])->get($_ENV["BALANCE_URL"]);
    }

}

