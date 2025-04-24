<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class GithubUser extends Model
{
    protected $guarded = [];

    public function githubRepositories()
    {
        return $this->hasMany(GithubRepository::class);
    }
}
