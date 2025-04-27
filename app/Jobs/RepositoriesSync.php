<?php

namespace App\Jobs;

use App\Services\Github\RepositoryService;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Queue\Queueable;

class RepositoriesSync implements ShouldQueue
{
    use Queueable;

    public function __construct(
        public int $githubUserId,
        public string $githubUser,
        public int $page = 1
    ) {
    }

    public function handle(RepositoryService $repositoryService): void
    {
        $repositories = $repositoryService->getAll($this->githubUser, $this->page);
        if (empty($repositories)) {
            return;
        }

        foreach ($repositories as $repository) {
            // salvar repositorios no banco
            StoreRepository::dispatch($this->githubUserId, $repository);
        }

        RepositoriesSync::dispatch($this->githubUserId, $this->githubUser, $this->page + 1);
    }
}
