<?php
namespace App\Http\Controllers\Payment;

use App\Http\Requests\TransactionRequest;
// use App\Services\Payment\PayoutService;

class CreatePaymentController extends BaseController{
    public function __invoke(TransactionRequest $request)
    {
        $data = $request->validated();
        $transaction = $this->service->store($data);

        return $this->service->sendPaymentTransaction($transaction);


    }


}
