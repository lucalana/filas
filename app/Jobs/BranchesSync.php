<?php

namespace App\Jobs;

use App\Services\Github\BranchService;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Queue\Queueable;

class BranchesSync implements ShouldQueue
{
    use Queueable;

    public function __construct(
        public int $githubRepositoryId,
        public string $repositoryFullName,
        public int $page = 1
    ) {
    }

    public function handle(BranchService $branchService): void
    {
        $branches = $branchService->getAll($this->repositoryFullName, $this->page);
        if (empty($branches)) {
            return;
        }
        foreach ($branches as $branch) {
            // salvar branch no banco
            StoreBranch::dispatch($this->githubRepositoryId, $branch['name'], $this->repositoryFullName);
        }

        BranchesSync::dispatch($this->githubRepositoryId, $this->repositoryFullName, $this->page + 1);
    }
}
