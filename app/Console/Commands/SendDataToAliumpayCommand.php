<?php

namespace App\Console\Commands;

use App\Components\SendDataClient;
use Illuminate\Console\Command;

class SendDataToAliumpayCommand extends Command
{
    
    protected $signature = 'send:aliumpay';

   
    protected $description = 'sent request to aliumpay';

    
    public function __construct()
    {
        parent::__construct();
    }

    public function handle()
    {   $service = new SendDataClient;
        $response = $service->client->request("GET");
        dd($response->getBody()->getContents());
    }
}
