<?php

namespace App\Services\Github;

use App\Exceptions\GithubRateLimitException;
use Illuminate\Http\Client\PendingRequest;
use Illuminate\Support\Facades\Http;
use Psr\Http\Message\ResponseInterface;

abstract class Service
{
    protected PendingRequest $http;
    public function __construct()
    {
        $this->http = Http::baseUrl('https://api.github.com')
            ->withHeaders([
                'X-GitHub-Api-Version' => '2022-11-28',
                'accept' => 'application/vnd.github+json',
            ])
            ->withResponseMiddleware(function (ResponseInterface $response) {
                if (str_contains('limit', $response->getReasonPhrase()) || $response->getStatusCode() >= 400) {
                    throw new GithubRateLimitException($response->getHeader('X-RateLimit-Reset')[0]);
                }
                return $response;
            });
    }
}
