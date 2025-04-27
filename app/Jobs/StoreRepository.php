<?php

namespace App\Jobs;

use App\Models\GithubRepository;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Queue\Queueable;

class StoreRepository implements ShouldQueue
{
    use Queueable;

    public function __construct(
        public int $githubUserId,
        public array $repository
    ) {
    }

    public function handle(): void
    {
        $githubRepository = GithubRepository::query()->create([
            'github_user_id' => $this->githubUserId,
            'repository_id' => $this->repository['id'],
            'repository_name' => $this->repository['name'],
            'repository_full_name' => $this->repository['full_name'],
            'repository_html_url' => $this->repository['html_url'],
            'is_fork' => $this->repository['fork'],
        ]);
        // pegar branchs de cada repositorio
        BranchesSync::dispatch($githubRepository->id, $this->repository['full_name']);
    }
}
