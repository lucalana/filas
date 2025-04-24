<?php

namespace App\Services\Github;

class RepositoryService extends Service
{
    public function getAll(string $userName)
    {
        return $this->http->get('/users/' . $userName . '/repos')->json();
    }
}
