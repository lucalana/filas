<?php

namespace App\Services\Github;

class BranchService extends Service
{
    public function getAll(string $repositoryFullName, int $page)
    {
        return $this->http
            ->withUrlParameters(['repositoryFullName' => $repositoryFullName])
            ->withQueryParameters([
                'per_page' => 30,
                'page' => $page
            ])
            ->get('/repos/{repositoryFullName}/branches')->json();
    }
}
