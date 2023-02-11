<?php

namespace App\Http\Controllers\Status;

class UpdateStatusController extends BaseController
{

    public function __invoke()
    {   
        
        $data =  json_decode($this->service->getStatus(), true);
        return $this->service->updateStatus($data);
    }
}
