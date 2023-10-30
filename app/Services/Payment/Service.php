<?php

namespace App\Services\Payment;

use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Redirect;
use App\Models\Transaction;
use Throwable;


class Service
{
    public function store(array $data): object
    {
        $data['type'] = 'deposit';
        if ($transaction = Transaction::create($data)) {
            return $transaction;
        }
        return new JsonResponse(['message' => 'no created transaction'], 200);
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
        return new JsonResponse(['message' => 'no transaction created'], 200);
    }

    public function requestTransactionPayment(object $transaction): ?object
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
        try {
            $response = Http::withoutVerifying()->withHeaders(['auth' => $_ENV['API_KEY'], 'sign' => $sign])->asJson()->post($url, $body);
        } catch (Throwable $exception) {
            $response = $exception;
        }
        if ($response instanceof Throwable) {
            return null;
        }
        return $response;
    }

    public function updateErrorTransaction(object $transaction, array $response): object
    {
        if ($transaction = Transaction::find($transaction['id'])) {
            $transaction->update([
                'transaction_status' => $response['status'],
                'error_text' => $response['message'],
                'code' => $response['code']
            ]);
            return $transaction;
        }
        return new JsonResponse(['message' => 'no updated transaction'], 200);
    }

    public function updateСreatedTransaction(object $transaction, array $response): object
    {
        if ($transaction = Transaction::find($transaction['id'])) {
            $transaction->update([
                'transaction_status' => $response['status'],
                'system_id' => $response['id'],
            ]);
            return $transaction;
        }
        return new JsonResponse(['message' => 'System error'], 200);
    }

    public function makeRedirect(array $response): object
    {
        if (isset($response['redirect']['params']['data'], $response['redirect']['url'],
            $response['redirect']['method'])) {
            $url = $response['redirect']['url'] . '?data=' . $response['redirect']['params']['data'];
            $method = $response['redirect']['method'];
            if ($method == 'GET') {
                // $data = $this->getStatus();  // TODO
                return Redirect::to($url);
            }
        }
        return new JsonResponse(['message' => 'System error'], 200);
    }
}
