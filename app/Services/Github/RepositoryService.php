<?php

namespace App\Services\Github;

class RepositoryService extends Service
{
    public function getAll(string $userName, int $page = 1, string $type = 'all')
    {
        return $this->http
            ->withUrlParameters([
                'user' => $userName,
                'page' => $page,
                'type' => $type,
                'per_page' => 30,
            ])
            ->get('/users/{user}/repos?page={page}&type={type}&per_page={per_page}')->json();
    }
}
