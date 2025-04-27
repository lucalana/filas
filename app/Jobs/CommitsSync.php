<?php

namespace App\Jobs;

use App\Services\Github\CommitService;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Queue\Queueable;

class CommitsSync implements ShouldQueue
{
    use Queueable;

    public function __construct(
        public int $githubBranchId,
        public string $branchName,
        public string $repositoryFullName,
        public int $page = 1
    ) {
    }

    public function handle(CommitService $commitService): void
    {
        $commits = $commitService->getAll($this->repositoryFullName, $this->branchName, $this->page);

        if (empty($commits)) {
            return;
        }

        foreach ($commits as $commit) {
            StoreCommit::dispatch($commit, $this->githubBranchId);
        }

        CommitsSync::dispatch(
            $this->githubBranchId,
            $this->branchName,
            $this->repositoryFullName,
            $this->page + 1
        );
    }
}
