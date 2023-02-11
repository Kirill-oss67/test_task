<?php

namespace App\Http\Controllers\Payout;


use App\Http\Requests\TransactionRequest;

class CreatePayoutController extends BaseController
{
    public function __invoke(TransactionRequest $request)
    {
        $data = $request->validated();
        $transaction = $this->service->store($data);
        return $this->service->sendPayoutTransaction($transaction);
    }
}
