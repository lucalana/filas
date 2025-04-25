@extends('layout.default')
@section('content')
    <h1>Digite o usuário no github</h1>
    <form action="{{ route('search.repositories') }}" method="POST">
        @csrf
        <input type="text" name="user" id="user">
        @error('user')
            {{ $message }}
        @enderror
        <button>Pesquisar</button>
    </form>
    @foreach ($githubUsers as $user)
        <ul>
            <li><a href="{{ route('list.repositories', $user->github_user) }}">{{ $user->github_user }}</a></li>
        </ul>
    @endforeach
@endsection
