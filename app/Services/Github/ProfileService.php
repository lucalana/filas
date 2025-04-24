<?php

namespace App\Services\Github;

class ProfileService extends Service
{
    public function get(string $userName)
    {
        return $this->http->get('/users/' . $userName)->json();
    }
}
