<?php

namespace App\Components;

use GuzzleHttp\Client;      

class SendDataClient{

    public $client;

    public function __construct()
    {
        $this->client = new Client([
            // 'base_uri' => 'https://aliumpay.com/api/deposit/create',
            'timeout' => 3.0,
            'verify' => false,

        ]);
    }

}