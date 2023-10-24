<?php

namespace App\Services;

class Config
{
    public function getConfig($var): ?string
    {
        return [
            'deduce_create_url' => '"https://aliumpay.com/api/deduce/create"',
            '' => '',           //TODO
        ][$var];
    }
}
