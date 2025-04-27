<?php

namespace App\Services\Github;

class CommitService extends Service
{
    public function getAll(string $repositoryFullName, string $branch, int $page)
    {
        return $this->http
            ->withUrlParameters([
                'repository' => $repositoryFullName
            ])
            ->withQueryParameters([
                'per_page' => 30,
                'page' => $page,
                'sha' => $branch,
            ])
            ->get('/repos/{repository}/commits')->json();
    }
}
