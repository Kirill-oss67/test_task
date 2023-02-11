<?php

namespace App\Services\Status;

use Illuminate\Support\Facades\Http;
use App\Models\Transaction;

class Service
{
    public function getStatus()
    {
        $exampleId = '1944884481';
        $url = 'https://aliumpay.com/api/status/' . $exampleId;
        return Http::withoutVerifying()->withHeaders(['auth' => $_ENV['API_KEY']])->get($url);
    }

    public function updateStatus(array $data): object
    {
        $transaction = Transaction::find($data['transaction_id']);
        if($data['status'] == 'pending'){
            $transaction->update([
                'transaction_status' => 'rejected',
            ]);
        }
        if($data['status'] == 'ok'){
            $transaction->update([
                'transaction_status' => 'successful ',
            ]);
        }
        return $transaction;
    }
}
