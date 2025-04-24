<?php

namespace App\Http\Controllers;

use App\Models\GithubRepository;
use App\Models\GithubUser;
use App\Services\Github\ProfileService;
use App\Services\Github\RepositoryService;

class GithubController extends Controller
{
    public function index()
    {
        return view('index', [
            'githubUsers' => GithubUser::all()
        ]);
    }

    public function searchRepositories(ProfileService $githubUser, RepositoryService $repository)
    {
        $githubUserInfo = $githubUser->get(request()->get('user'));
        $githubUser = GithubUser::query()->updateOrCreate(
            ['github_id' => $githubUserInfo['id']],
            [
                'github_user' => $githubUserInfo['login'],
                'github_id' => $githubUserInfo['id'],
                'github_avatar_url' => $githubUserInfo['avatar_url'],
            ]
        );
        $reposUrl = $githubUserInfo['repos_url'];
        $repositories = $repository->getAll($reposUrl);

        GithubRepository::where('github_user_id', $githubUser->id)->delete();
        $insertRepos = collect($repositories)
            ->filter(fn($repository) => $repository['private'] === false)
            ->map(function ($repository) use ($githubUser) {
                return [
                    'github_user_id' => $githubUser->id,
                    'repository_id' => $repository['id'],
                    'repository_name' => $repository['name'],
                    'repository_full_name' => $repository['full_name'],
                    'repository_html_url' => $repository['html_url'],
                    'is_fork' => $repository['fork'],
                    'created_at' => now(),
                    'updated_at' => now(),
                ];
            })
            ->toArray();
        $githubUser->githubRepositories()->insert($insertRepos);

        return to_route('home');
    }

    public function listRepositories(GithubUser $githubUser)
    {
        return view('user-repositories', [
            'githubRepositories' => $githubUser->githubRepositories
        ]);
    }
}
