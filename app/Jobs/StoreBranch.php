<?php

namespace App\Jobs;

use App\Models\GithubBranch;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Queue\Queueable;

class StoreBranch implements ShouldQueue
{
    use Queueable;

    public function __construct(
        public int $githubRepositoryId,
        public string $branchName,
        public string $repositoryFullName,
    ) {
    }

    public function handle(): void
    {
        $githubBranch = GithubBranch::query()->create([
            'github_repository_id' => $this->githubRepositoryId,
            'name' => $this->branchName,
        ]);
        // pegar commits de cada branch
        CommitsSync::dispatch($githubBranch->id, $this->branchName, $this->repositoryFullName);
    }
}
