<?php

namespace App\Services\Github;

class RepositoryService extends Service
{
    public function getAll(string $userName, int $page, string $type = 'all')
    {
        return $this->http
            ->withUrlParameters(['user' => $userName,])
            ->withQueryParameters([
                'page' => $page,
                'type' => $type,
                'per_page' => 30,
            ])
            ->get('/users/{user}/repos')->json();
    }
}
