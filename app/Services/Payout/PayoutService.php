<?php

namespace App\Services\Payout;

use App\Services\Config;
use Illuminate\Support\Facades\Http;
use App\Models\Transaction;
use Throwable;


class PayoutService extends Config
{

    public function store(array $data): object
    {
        $data['type'] = 'deduce';
        $transaction = Transaction::create($data);
        return $transaction;
    }

    public function sendPayoutTransaction(object $transaction): array
    {
        $response = $this->requestTransactionPayout($transaction);
        if ($response) {
            $response = json_decode($response->body(), true);
            if ($response['status'] == "error") {
                $this->updateErrorTransaction($transaction, $response);
                return $response;
            }

            if ($response['status'] == "created") {

                $this->updateСreatedTransaction($transaction, $response);
                return $response;
            };
        }
        return $response;
    }

    public function requestTransactionPayout(object $transaction): ?object
    {
        $body = [
            'amount' => $transaction['amount'],
            'currency' => $transaction['currency'],
            'payment_system' => $transaction['payment_system'],
            'transaction_id' => $transaction['id'],
            'system_fields' => [
                'card_number' => $transaction['card_number'],
                'client_phone' => $transaction['phone_number'],
                'payment_description' => 'payment_description'
            ]
        ];
        $request = json_encode($body);
        $sign = md5($request . $_ENV["SECRET_KEY"]);
        try {
            $response = Http::withoutVerifying()->withHeaders(['auth' => $_ENV['API_KEY'], 'sign' => $sign])->asJson()->post($this->getConfig('deduce_create_url'), $body);
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
        $transaction = Transaction::find($transaction['id']);
        $transaction->update([
            'transaction_status' => $response['status'],
            'error_text' => $response['message'],
            'code' => $response['code']
        ]);
        return $transaction;
    }

    public function updateСreatedTransaction(object $transaction, array $response): object
    {
        $transaction = Transaction::find($transaction['id']);
        $transaction->update([
            'transaction_status' => $response['status'],
            'system_id' => $response['id'],
        ]);
        return $transaction;
    }
}
