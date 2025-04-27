<?php

namespace App\Jobs;

use App\Models\GithubCommit;
use App\Models\GithubUser;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Queue\Queueable;

class StoreCommit implements ShouldQueue
{
    use Queueable;

    public function __construct(
        public array $commit,
        public int $githubBranchId,
    ) {
    }

    public function handle(): void
    {
        $githubUser = GithubUser::query()
            ->where('github_id', $this->commit['author']['id'])
            ->where('github_user', $this->commit['author']['login'])
            ->first();
        GithubCommit::query()->create([
            'github_branch_id' => $this->githubBranchId,
            'github_user_id' => $githubUser->id,
            'message' => $this->commit['commit']['message'],
        ]);
    }
}
