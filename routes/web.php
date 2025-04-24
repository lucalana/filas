<?php

use App\Http\Controllers\GithubController;
use Illuminate\Support\Facades\Route;

Route::get('/', [GithubController::class, 'index'])->name('home');
Route::post('/search-github-repositories', [GithubController::class, 'searchRepositories'])->name('search.repositories');
Route::get('/list-repositories/{githubUser:github_user}', [GithubController::class, 'listRepositories'])->name('list.repositories');
