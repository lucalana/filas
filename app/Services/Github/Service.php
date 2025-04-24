<?php

namespace App\Services\Github;

use Illuminate\Http\Client\PendingRequest;
use Illuminate\Support\Facades\Http;

abstract class Service
{
    protected PendingRequest $http;
    public function __construct()
    {
        $this->http = Http::baseUrl('https://api.github.com')
            ->withHeaders([
                'X-GitHub-Api-Version' => '2022-11-28'
            ]);
    }
}
