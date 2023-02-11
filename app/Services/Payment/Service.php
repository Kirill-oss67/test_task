<?php

namespace App\Services\Payment;

use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Redirect;
use App\Models\Transaction;



class Service
{
    public function store(array $data): object
    {
        $data['type'] = 'deposit';
        $transaction = Transaction::create($data);
        return $transaction;
    }

    public function sendPaymentTransaction(object $transaction)
    {
        $response = $this->requestTransactionPayment($transaction);
        if ($response) {
            $response = json_decode($response->body(), true);
            if ($response['status'] == "error") {
                $this->updateErrorTransaction($transaction, $response);

                return $response;
            };
            if ($response['status'] == "created") {
                $this->updateСreatedTransaction($transaction, $response);
                return $this->makeRedirect($response);
            }
        }
    }

    public function requestTransactionPayment(object $transaction)
    {

        $body = [
            'amount' => $transaction['amount'],
            'currency' => $transaction['currency'],
            'payment_system' => $transaction['payment_system'],
            'transaction_id' => $transaction['id']
        ];
        $url = "https://aliumpay.com/api/deposit/create";

        $request = json_encode($body);

        $sign = md5($request . $_ENV['SECRET_KEY']);

        return Http::withoutVerifying()->withHeaders(['auth' => $_ENV['API_KEY'], 'sign' => $sign])->asJson()->post($url, $body);
    }

    public function updateErrorTransaction(object $transaction,array $response): object
    {
        $transaction = Transaction::find($transaction['id']);
        $transaction->update([
            'transaction_status' => $response['status'],
            'error_text' => $response['message'],
            'code' => $response['code']
        ]);
        return $transaction;
    }

    public function updateСreatedTransaction(object $transaction,array $response): object
    {
        $transaction = Transaction::find($transaction['id']);
        $transaction->update([
            'transaction_status' => $response['status'],
            'system_id' => $response['id'],
        ]);
        return $transaction;
    }

    public function makeRedirect(array $response)
    {
        $params = $response['redirect']['params']['data'];
        $url = $response['redirect']['url'] . '?data=' . $params;
        $method = $response['redirect']['method'];
        if ($method == 'GET') {
            // $data = $this->getStatus();
            return Redirect::to($url);
        }
    }
}
