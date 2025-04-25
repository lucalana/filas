<?php

namespace App\Http\Controllers;

use App\Models\GithubUser;
use App\Services\Github\ProfileService;
use App\Services\Github\RepositoryService;
use Illuminate\Http\Request;

class GithubController extends Controller
{
    public function index()
    {
        return view('index', [
            'githubUsers' => GithubUser::all()
        ]);
    }

    public function searchRepositories(Request $request, ProfileService $githubUser, RepositoryService $repository)
    {
        $request->validate(
            ['user' => ['required']],
            ['user' => ['required' => 'Digite um usuário',]]
        );
        $githubUserName = request()->get('user');
        $githubUserInfo = $githubUser->get($githubUserName);
        $githubUser = GithubUser::query()->updateOrCreate(
            ['github_id' => $githubUserInfo['id']],
            [
                'github_user' => $githubUserInfo['login'],
                'github_id' => $githubUserInfo['id'],
                'github_avatar_url' => $githubUserInfo['avatar_url'],
            ]
        );
        // pegar todos os repositórios
        // salvar repositorios no banco
        // pegar branchs de cada repositorio
        // pegar commits de cada branch

        return to_route('home')->with(
            'message',
            'Vamos sincronizar todos repositórios com todas as branchs e commits. Quando finalizar será enviado um email!'
        );
    }

    public function listRepositories(GithubUser $githubUser)
    {
        return view('user-repositories', [
            'githubRepositories' => $githubUser->githubRepositories
        ]);
    }
}
